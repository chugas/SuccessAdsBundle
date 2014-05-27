<?php

namespace Success\AdsBundle\Component\Helper;

use Doctrine\Common\Persistence\ObjectRepository;

class Helper {

  protected $campaignRepository;
  protected $realLogRepository;

  public function __construct(ObjectRepository $campaignRepository, $realLogRepository) {
    $this->campaignRepository = $campaignRepository;
    $this->realLogRepository = $realLogRepository;
  }

  public function processAds($ip){
    $campaigns = $this->intelligentSelection();

    $this->realLogRepository->insert($campaigns, $ip);

    return $campaigns;
  }
  
  public function intelligentSelection(){
    $campaigns = $this->campaignRepository->intelligentFinder();    
    return $campaigns;
  }

}
