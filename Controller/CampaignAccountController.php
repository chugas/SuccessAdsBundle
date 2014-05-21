<?php

namespace Success\AdsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CampaignAccountController extends Controller {

  public function indexAction() {
    $user = $this->getUser();
    if(is_null($user)) {
      throw new AccessDeniedHttpException('access denied');
    }
    
    $account = $this->get('success.repository.campaignAccount')->findOneByUser($user);
    if(!$account){
      throw new NotFoundHttpException('Account not found');
    }
    
    // Creamos la QueryBuilder
    $qb =  $this->get('success.repository.campaignTransactionAccount')->findByAccountQuery($account->getId());

    // Obtenemos el orden
    $sort_by = 'created_date';
    $sort_order = 'desc';

    // Instanciamos el manejador
    $service = $this->get('success.campaignTransactionAccount.filter');
    // Seteamos Adaptador
    $service->setAdapter(\Success\AdsBundle\Filter\CoreFilter::DOCTRINE_DBAL);
    // Inyectamos el Request
    $service->setRequest($this->get('request'));
    // Seteamos QueryBuilder
    $service->setQueryBuilder($qb);
    // Seteamos el Orden por defecto
    $service->setOrderBy($sort_by, $sort_order);
    $service->setMaxPerPage(25);

    return $this->render('SuccessAdsBundle:Frontend/CampaignAccount:index.html.twig', 
            array(
              'account' => $account,
              'filter' => $service->getFormFilter()->createView(),                
              'service' => $service
            ));
  }

  /*public function securityCheck($news){
    $columnista = $news->getColumnista();
    return ($columnista->getId() == $this->getUser()->getId() && $this->container->get('security.context')->isGranted('ROLE_COLUMNISTA'));
  }*/
  
  public function getUser(){
    if (null === $token = $this->container->get('security.context')->getToken()) {
      return null;
    }

    if (!is_object($user = $token->getUser())) {
      return null;
    }
    
    return $user;
  }
}
