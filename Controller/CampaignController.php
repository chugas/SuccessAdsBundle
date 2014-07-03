<?php

namespace Success\AdsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use Success\AdsBundle\Model\Campaign;

class CampaignController extends Controller {

  public function indexAction() {
    $user = $this->getUser();
    if(is_null($user)) {
      throw new AccessDeniedHttpException('access denied');
    }

    // Creamos la QueryBuilder
    $qb =  $this->get('success.repository.campaign')->findCampaignByUserQuery($user->getId());

    // Obtenemos el orden
    $sort = $this->getRequest()->get('_sort_by', 'unlockedDate_desc');
    $sort_data = explode('_', $sort);
    $sort_by = $sort_data[0];
    $sort_order = $sort_data[1];
    
    // Instanciamos el manejador
    $service = $this->get('success.campaign.filter');
    // Inyectamos el Request
    $service->setRequest($this->get('request'));
    // Seteamos QueryBuilder
    $service->setQueryBuilder($qb);
    // Seteamos el Orden por defecto
    $service->setOrderBy($sort_by, $sort_order);
    $pager = $service->getPager();
    
    return $this->render('SuccessAdsBundle:Frontend/Campaign:index.html.twig', 
        array(
          'pager' => $pager,
          'filter' => $service->getFormFilter()->createView(),
          'pricePerView' => $this->get('service_container')->getParameter('price_per_view')
        ));
  }

  public function showAction($id) {
    $campaign = $this->get('success.repository.campaign')->find($id);
    if(!$campaign){
      throw new NotFoundHttpException('Campana not found');
    }  
    
    // Creamos la QueryBuilder
    $qb =  $this->get('success.repository.campaignLog')->findByCampaignQuery($id);

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
    
    return $this->render('SuccessAdsBundle:Frontend/Campaign:show.html.twig', 
            array(
              'campaign' => $campaign,
              'filter' => $service->getFormFilter()->createView(),                
              'service' => $service,
              'pricePerView' => $this->get('service_container')->getParameter('price_per_view')
            ));
  }
  
  public function editAction($id) {
    $respuesta = $this->render('SuccessAdsBundle:Frontend/Campaign:edit.html.twig', array());
    return $respuesta;
  }
  
  public function successAction(){
    return $this->render('SuccessAdsBundle:Frontend/Campaign:success.html.twig', array());    
  }

  public function createAction() {
    $request = $this->getRequest();
    
    $type = $this->get('success.form.type.campaign');
    $form = $this->getForm($type);
    $resource = $this->get('success.manager.campaign')->create();
    $form->setData($resource);
    
    if ($request->isMethod('POST')) {

      if ($form->bind($request)->isValid()) {
        $user = $this->getUser();

        // Seteamos parametros extra
        $resource->setCreatedBy($user);
        $resource->setActive(true);
        $resource->setVerified(false);
        $resource->setCampaignType(Campaign::TYPE_VIEWS);
        
        $this->create($resource);
        $this->setFlash('success', 'create_campaign');

        if($this->redirectPaymentPage($resource)){
          // Pago
          return $this->redirect($this->generateUrl('campaignPayment_index'));
        } elseif ($this->redirectListPage($resource)) {
          // Listado
          return $this->redirect($this->generateUrl('ads_index'));
        } else {
          // Listado + Notificacion
          return $this->redirect($this->generateUrl('campaignPayment_index'));          
        }

      }
    }
    
    $respuesta = $this->render('SuccessAdsBundle:Frontend/Campaign:create.html.twig', 
        array(
          'form'  => $form->createView()
        ));

    return $respuesta;
  }

  /*private function securityCheck($news){
    $columnista = $news->getColumnista();
    return ($columnista->getId() == $this->getUser()->getId() && $this->container->get('security.context')->isGranted('ROLE_COLUMNISTA'));
  }*/
  
  private function getForm($type, $resource = null)
  {
      return $this->createForm($type, $resource);
  }
  
  public function deleteAction() {
    /*$resource = $this->findOr404();

    $this->delete($resource);
    $this->setFlash('success', 'delete');

    return $this->redirectToIndex($resource);*/
  }

  public function create($resource) {
    //$this->dispatchEvent('success.product.pre_create', $resource);
    $this->persistAndFlush($resource);
    //$this->dispatchEvent('success.product.post_create', $resource);
  }

  public function update($resource) {
    //$this->dispatchEvent('success.product.pre_update', $resource);
    $this->persistAndFlush($resource);
    //$this->dispatchEvent('success.product.post_update', $resource);
  }

  public function delete($resource) {
    //$this->dispatchEvent('pre_delete', $resource);
    $this->removeAndFlush($resource);
    //$this->dispatchEvent('post_delete', $resource);
  }

  public function persistAndFlush($resource) {
    $manager = $this->getDoctrine()->getManager();

    $manager->persist($resource);
    $manager->flush();
  }

  public function removeAndFlush($resource) {
    $manager = $this->getDoctrine()->getManager();

    $manager->remove($resource);
    $manager->flush();
  }

  public function getManager() {
    return $this->getDoctrine()->getManager();
  }

  protected function setFlash($type, $event) {
    return $this
            ->get('session')
            ->getFlashBag()
            ->add($type, $this->generateFlashMessage($event))
    ;
  }

  protected function generateFlashMessage($event) {
    $message = 'success.resource.' . $event;
    
    return $this->get('translator')->trans($message, array('%resource%' => 'flashes'), 'flashes');    
  }
  
  protected function redirectPaymentPage($campaign){
    $user = $this->getUser();
    
    $account = $this->get('success.repository.campaignAccount')->findAccountBy( array('user' => $user->getId()) );
    if(is_null($account)){
      $account = $this->get('success.manager.campaignAccount')->create();
      $account->setUser($user);
      $account->setCurrency('UYU');
      $this->create($account);
      return true;
    }
    
    return $account->getTotal() <= 0;
  }
  
  protected function redirectListPage($campaign){
    $user = $this->getUser();

    $account = $this->get('success.repository.campaignAccount')->findAccountBy( array('user' => $user->getId()) );

    $maxPerDay = $campaign->getPricePerDay();

    // Si tiene saldo para cubrir 1 semana de publicidad devolvemos true
    return ( $account->getTotal() >= ($maxPerDay * 7) );
  }

}
