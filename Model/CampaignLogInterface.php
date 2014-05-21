<?php

namespace Success\AdsBundle\Model;

interface CampaignLogInterface {
  
  public function setCreatedDate($createdDate);

  public function getCreatedDate();

  public function setViews($views);

  public function getViews();

  public function setClicks($clicks);

  public function getClicks();

  public function setCampaign(\Success\AdsBundle\Model\CampaignInterface $campaign);

  public function getCampaign();

  public function getActive();

  public function setActive($active);  
}