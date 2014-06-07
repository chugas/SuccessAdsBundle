<?php

namespace Success\AdsBundle\Component\Helper;

use Doctrine\Common\Persistence\ObjectRepository;

class Helper {

  protected $campaignRepository;
  protected $realLogRepository;
  protected $campaignRealStatsRepository;
  protected $managerRealStats;
  protected $managerCampaign;
  protected $pricePerView;
  protected $campaignAccountRepository;
  
  public function __construct(ObjectRepository $campaignRepository, $realLogRepository, $campaignRealStatsRepository, $managerRealStats, $managerCampaign, $campaignAccountRepository, $pricePerView) {
    $this->campaignRepository = $campaignRepository;
    $this->realLogRepository = $realLogRepository;
    $this->campaignRealStatsRepository = $campaignRealStatsRepository;
    $this->managerRealStats = $managerRealStats;
    $this->managerCampaign = $managerCampaign;
    $this->pricePerView = $pricePerView;
    $this->campaignAccountRepository = $campaignAccountRepository;
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
