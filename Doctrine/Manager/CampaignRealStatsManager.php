<?php

namespace Success\AdsBundle\Doctrine\Manager;

class CampaignRealStatsManager {

  protected $repository;

  public function __construct($repo) {
    $this->repository = $repo;
  }
  
  public function enqueue($record) {
    /*$conn = $this->repository->getConnection();
    $stmt = $conn->prepare('DELETE FROM campaign_real_stats WHERE campaign_id = ' . $campaign->getId());
    $stmt->execute();*/    
  }

  public function dequeue($campaign) {
    $conn = $this->repository->getConnection();
    $stmt = $conn->prepare('DELETE FROM campaign_real_stats WHERE campaign_id = ' . $campaign->getId());
    $stmt->execute();
  }

  public function emptyqueue(){
    $conn = $this->repository->getConnection();
    $stmt = $conn->prepare('DELETE FROM campaign_real_stats');
    $stmt->execute();
  }
}
