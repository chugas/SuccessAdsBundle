<?php

namespace Success\AdsBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

/**
 * Comando que actualiza las estadisticas de los anuncios
 */
class InitializeCommand extends ContainerAwareCommand {

  
  protected function configure() {
    $this
            ->setName('success:ads:init')
            ->setDefinition(array())
            ->setDescription('Inicializa la cola de los anuncios activos del dia')
            ->setHelp(<<<EOT
Inicializacion de anuncios del dia
EOT
    );
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $container = $this->getContainer();

    // Vaciamos la tabla
    $container->get('success.manager.campaignRealStats')->emptyqueue();

    // Obtenemos campanias
    $campaigns = $container->get('success.repository.campaign')->findCampaignRecords();

    // Encolamos campanias
    $container->get('success.repository.campaignRealStats')->insert($campaigns, $container->getParameter('price_per_view'));
  }

}
