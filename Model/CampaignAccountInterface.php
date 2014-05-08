<?php

namespace Success\AdsBundle\Model;

interface CampaignAccountInterface {
  
  public function getCode();
  
  public function setCode($code);
  
  public function getCurrency();
  
  public function setCurrency($currency);
  
  public function getTotal();
  
  public function setTotal($total);
  
  public function getUser();
  
  public function setUser(\Symfony\Component\Security\Core\User\UserInterface $user);
  
  public function getCreatedDate();
  
  public function setCreatedDate($createdDate);
  
  public function isDeleted();
  
  public function setDeleted($isDeleted);

  public function getDeletedDate();
  
  public function setDeletedDate($deletedDate);  
}
