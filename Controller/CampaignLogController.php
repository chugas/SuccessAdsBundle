<?php

namespace Success\AdsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CampaignLogController extends Controller {

  public function statsAction($campaign_id) {
    $user = $this->getUser();
    if(is_null($user)) {
      throw new AccessDeniedHttpException('access denied');
    }
    // Validar si el usuario tiene permisos para consultar por la campania

    $qb =  $this->get('success.repository.campaignLog')->findStatsQuery($campaign_id);

    // Obtenemos el orden
    $sort_by = 'created_date';
    $sort_order = 'asc';
    
    // Instanciamos el manejador
    $service = $this->get('success.campaignLog.filter');
    // Seteamos Adaptador
    $service->setAdapter(\Success\AdsBundle\Filter\CoreFilter::DOCTRINE_DBAL);
    // Inyectamos el Request
    $service->setRequest($this->get('request'));
    // Seteamos QueryBuilder
    $service->setQueryBuilder($qb);
    // Seteamos el Orden por defecto
    $service->setOrderBy($sort_by, $sort_order);
    $service->setMaxPerPage(365);
    $pager = $service->getPager();    
    $results = $pager->getCurrentPageResults();
    
    //$results = $this->get('success.repository.campaignLog')->findStats($campaign_id);
    $data = json_encode(array('stats' => $results));
    return new Response($data, 200, array('Content-Type' => 'application/json'));
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
