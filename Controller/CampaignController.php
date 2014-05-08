<?php

namespace Success\AdsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CampaignController extends Controller {

  public function indexAction() {
    $respuesta = $this->render('AdsBundle:Ads:index.html.twig', array());
    return $respuesta;
  }

  public function showAction($id) {
    $respuesta = $this->render('AdsBundle:Ads:show.html.twig', array());
    return $respuesta;
  }
  
  public function editAction($id) {
    $respuesta = $this->render('AdsBundle:Ads:edit.html.twig', array());
    return $respuesta;
  }
  
  public function createAction() {
    $respuesta = $this->render('AdsBundle:Ads:create.html.twig', array());
    return $respuesta;
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
