<?php

namespace Success\AdsBundle\Model;

class CampaignPlaneLog {
  
  protected $id;
  
  protected $campaign;
  
  protected $createdDate;
  
  protected $ip;

  function __construct() {
    $this->createdDate = new \Datetime('now');
  }

  public function setId($id) {
    $this->id = $id;

    return $this;
  }

  public function getId() {
    return $this->id;
  }

  public function setCreatedDate($createdDate) {
    $this->createdDate = $createdDate;

    return $this;
  }

  public function getCreatedDate() {
    return $this->createdDate;
  }

  public function setIp($ip) {
    $this->ip = $ip;

    return $this;
  }

  public function getIp() {
    return $this->ip;
  }

  public function setCampaignId($campaign_id) {
    $this->campaign_id = $campaign_id;

    return $this;
  }

  public function getCampaignId() {
    return $this->campaign_id;
  }

}