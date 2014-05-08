<?php

namespace Success\AdsBundle\Model;

class CampaignTransactionAccount implements CampaignTransactionAccountInterface {
  protected $concept;
  protected $debit;
  protected $credit;
  protected $createdDate;
  protected $account;
  protected $total;
  
  public function __construct() {
    $this->createdDate = new \Datetime('now');
  }
  
  public function __toString() {
    return (string) $this->account;
  }
  
  public function getConcept(){
    return $this->concept;
  }
  
  public function setConcept($concept){
    $this->concept = $concept;
    
    return $this;    
  }
  
  public function getDebit(){
    return $this->debit;
  }
  
  public function setDebit($debit){
    $this->debit = $debit;
    
    return $this;    
  }
  
  public function getCredit(){
    return $this->credit;
  }
  
  public function setCredit($credit){
    $this->credit = $credit;

    return $this;    
  }
  
  public function getCreatedDate(){
    return $this->createdDate;
  }
  
  public function setCreatedDate($createdDate){
    $this->createdDate = $createdDate;
    
    return $this;
  }
  
  public function getAccount(){
    return $this->account;
  }
  
  public function setAccount(\Success\AdsBundle\Model\CampaignAccount $account){
    $this->account = $account;
    
    return $this;    
  }
  
  public function getTotal(){
    return $this->total;
  }
  
  public function setTotal($total){
    $this->total = $total;
    
    return $this;
  }  
}
