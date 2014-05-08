<?php

namespace Success\AdsBundle\Model;

interface CampaignInterface {

  public function getCode();
  public function setCode($code);
  public function getPricePerDay();
  public function setPricePerDay($price);
  public function getCampaignType();
  public function setCampaignType($campaignType);
  public function getActive();
  public function setActive($active);
  public function getCreatedDate();
  public function setCreatedDate($createdDate);
  public function isDeleted();
  public function setDeleted($isDeleted);
  public function getDeletedDate();
  public function setDeletedDate($deletedDate);
  public function getUnlockedDate();
  public function setUnlockedDate(\Datetime $datetime);
  public function getUnlockedUntilDate();
  public function setUnlockedUntilDate(\Datetime $datetime);
  public function isLocked();
  public function getName();
  public function setName($name = null);
  public function getCreatedBy();
  public function setCreatedBy(\Symfony\Component\Security\Core\User\UserInterface $createdBy = null);
  public function getBanner();
  public function setBanner($banner);
  
}
