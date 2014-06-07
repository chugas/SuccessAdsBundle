<?php

namespace Success\AdsBundle\Model;

class CampaignLog implements CampaignLogInterface {
  
  protected $campaign;
  
  protected $createdDate;
  
  protected $views;
  
  protected $clicks;
  
  protected $active;

  function __construct() {
    $this->createdDate = new \Datetime('now');
    $this->views = 0;
    $this->clicks = 0;
  }

  public function __toString() {
    return (string) $this->campaign;
  }

  public function setCreatedDate($createdDate) {
    $this->createdDate = $createdDate;

    return $this;
  }

  public function getCreatedDate() {
    return $this->createdDate;
  }

  public function setViews($views) {
    $this->views = $views;

    return $this;
  }

  public function getViews() {
    return $this->views;
  }

  public function setClicks($clicks) {
    $this->clicks = $clicks;

    return $this;
  }

  public function getClicks() {
    return $this->clicks;
  }

  public function setCampaign(\Success\AdsBundle\Model\CampaignInterface $campaign) {
    $this->campaign = $campaign;

    return $this;
  }

  public function getCampaign() {
    return $this->campaign;
  }
  
  public function getActive() {
    return $this->active;
  }

  public function setActive($active) {
    $this->active = $active;

    return $this;
  }
}