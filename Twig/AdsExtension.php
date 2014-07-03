<?php

namespace Success\AdsBundle\Twig;

class AdsExtension extends \Twig_Extension {

  private $container;

  public function __construct($container) {
    $this->container = $container;
  }

  public function getName() {
    return 'success_ads';
  }

  /*public function getFilters() {
    return array(
        'birthday'  => new \Twig_Filter_Method($this, 'birthday')
    );
  }*/
  
  public function getFunctions() {
    return array(
        'sponsors_ads'    => new \Twig_Function_Method($this, 'sponsors_ads', array('is_safe' => array('html'))),
        'payment_details' => new \Twig_Function_Method($this, 'payment_details', array('is_safe' => array('html'))),
        'payment_details_mail' => new \Twig_Function_Method($this, 'payment_details_mail', array('is_safe' => array('html')))        
    );
  }  

  public function sponsors_ads($section){
    //$container->get('request')->server->get("REMOTE_ADDR");
    $ip = $this->container->get('request')->getClientIp();    
    
    $ads = $this->container->get('success.campaign.helper')->processAds($ip, $section);

    return $this->getTemplating()->render('SuccessAdsBundle:Frontend/Campaign:ads.html.twig', array('campaigns' => $ads));
  }
  
  public function payment_details($gateway){
    $service = $this->container->get('success.gateway.' . $gateway);
    $data = $service->getOptions();
    
    return $this->getTemplating()->render('SuccessPaymentsBundle:Info:' . $service->getTemplate(), array('parameters' => $data));    
  }

  public function payment_details_mail($gateway){
    $service = $this->container->get('success.gateway.' . $gateway);
    $data = $service->getOptions();
    
    return $this->getTemplating()->render('SuccessPaymentsBundle:Mails:' . $service->getTemplate(), array('parameters' => $data));    
  }

  public function getTemplating(){
    return $this->container->get('templating');
  }  

}
