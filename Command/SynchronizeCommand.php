<?php

namespace Success\AdsBundle\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

/**
 * Comando que actualiza las estadisticas de los anuncios
 */
class SynchronizeCommand extends ContainerAwareCommand {

  
  protected function configure() {
    $this
            ->setName('success:ads:sync')
            ->setDefinition(array(
                new InputOption('limit', null, InputOption::VALUE_OPTIONAL, 'Limit', 20),
                new InputOption('debug', null, InputOption::VALUE_OPTIONAL, 'Debug', 0)
            ))
            ->setDescription('Actualiza las estadisticas de los anuncios')
            ->setHelp(<<<EOT
Sincronizacion de Estadisticas
EOT
    );
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    if(!$this->firewallTime()){ return; }
    
    $limit = $input->getOption('limit');
    $debug = (boolean)$input->getOption('debug');
    
    $container = $this->getContainer();
    $conn = $container->get('doctrine.dbal.default_connection');
    $em = $container->get('doctrine')->getManager();

    try {
      $sql = 'SELECT campaign_id, DATE(created_date) as created, count(campaign_id) as views FROM campaign_real_log WHERE processed_date is null AND DATE(created_date) < CURRENT_DATE() GROUP BY campaign_id, created ORDER BY created ASC LIMIT ' . $limit;
      $rows = $conn->fetchAll($sql);

      foreach($rows as $record){

        $em->transactional(function($em) use ($conn, $container, $record, $debug, $output) {

          $id = $record['campaign_id'];
          $created = $record['created'];
          $views = (integer) $record['views'];
          $createdDate = new \DateTime($created);
          $pricePerView = $container->getParameter('price_per_view');

          $campaign = $container->get('success.repository.campaign')->find($id);

          if($campaign){
            $maxPerDay = $campaign->getPricePerDay();
            $user = $campaign->getCreatedBy();

            $gasto = ($pricePerView * $views);
            
            // Si hubo un gasto mayor al que el cliente queria acotamos la cantidad de visitas reales
            $views = ( $gasto  > $maxPerDay ? floor($maxPerDay / $pricePerView) : $views );
            
            // Si hubo un gasto mayor al que el cliente queria acotamos a lo maximo que quiere gastar
            $amount = ( $gasto  > $maxPerDay ? ( $views * $pricePerView ) : $gasto );
            
            // Actualizacion del campo sumarizado de views en la tabla success_campaign
            /********* ESTO TAMBIEN PODRIA IR EN UN PREPERSIST DE campaignLog ************/
            $campaign->setViews($campaign->getViews()+$views);
            $em->persist($campaign);

            // Sumarizacion de la estadistica en la tabla success_campaign_log
            // campaign_id views created_date
            $campaignLog = $container->get('success.manager.campaignLog')->getOneBy($campaign, $createdDate);
            $campaignLog->setViews($campaignLog->getViews()+$views);
            $campaignLog->setCampaign($campaign);
            $campaignLog->setCreatedDate($createdDate);
            $em->persist($campaignLog);

            // Actualizacion de los gastos de la cuenta success_campaign_transaction_account success_campaign_account
            $account = $container->get('success.repository.campaignAccount')->findAccountBy( array('user' => $user->getId()) );
            if(is_null($account)){
              $account = $container->get('success.manager.campaignAccount')->create();
              $account->setUser($user);
              $account->setCurrency('UYU');
              $em->persist($account);
            }

            //$queue_accounts[$account->getId()] = (array_key_exists($account->getId(), $queue_accounts) ? ($queue_accounts[$account->getId()] - $amount) : $account->getTotal());
            
            // DEBUG
            if($debug){
              $output->writeln( $id . ' - ' . $account->getId() . ' - ' .  $createdDate->format('Y-m-d') . ' - ' . $views );
            }
            
            $transaction = $container->get('success.manager.campaignTransactionAccount')->create();
            // Inicializamos el total de la transaccion con el saldo de la cuenta
            $transaction->setTotal($account->getTotal());
            $transaction->setConcept(strtoupper($container->get('translator')->trans('campaignTransactionAccount.concept.publicidad', array(), 'SuccessAdsBundle')));
            $transaction->setDebit($amount);
            $transaction->setAccount($account);

            $em->persist($transaction);

            //$conn->beginTransaction();
            $sql = 'UPDATE campaign_real_log SET processed_date = CURRENT_TIMESTAMP WHERE campaign_id = ? AND DATE(created_date) = ?';
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->bindValue(2, $created);
            $stmt->execute();

            //$em->flush();
            //$conn->commit();

          } else {

            //$conn->beginTransaction();
            $sql = 'UPDATE campaign_real_log SET processed_date = CURRENT_TIMESTAMP WHERE campaign_id = ? AND DATE(created_date) = ?';
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->bindValue(2, $created);
            $stmt->execute();

            //$conn->commit();

          }

          sleep(1);
        });
      }

    }catch(\Exception $e) {
      
    }
  }
  
  /**
   * Devuelve true si esta dentro de la hora permitida para correr
   * 
   * @return boolean
   */
  public function firewallTime(){
    /*$max_limit = strtotime( date('Y-m-d') . ' 23:00' );
    $min_limit = strtotime( date('Y-m-d') . ' 10:00' );
    $now = strtotime( date('Y-m-d H:i') );
    
    if($now < $max_limit || $now > $min_limit) {
      return;
    }*/
    return true;
  }

}
