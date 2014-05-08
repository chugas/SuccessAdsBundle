<?php

namespace Success\AdsBundle\Model;

interface CampaignTransactionAccountInterface {
  
  public function getConcept();
  
  public function setConcept($concept);
  
  public function getDebit();
  
  public function setDebit($debit);
  
  public function getCredit();
  
  public function setCredit($credit);
  
  public function getCreatedDate();
  
  public function setCreatedDate($createdDate);
  
  public function getAccount();
  
  public function setAccount(\Success\AdsBundle\Model\CampaignAccount $account);
  
  public function getTotal();
  
  public function setTotal($total);
}
