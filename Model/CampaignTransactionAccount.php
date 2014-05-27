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
    $this->debit = null;
    $this->credit = null;
    $this->total = 0;
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
  
  public function syncroAccount(){
    $saldo = $this->account->getTotal();
    if(!is_null($this->getDebit())){
      $saldo = $saldo - $this->getDebit();
      $this->setTotal($saldo);
    }
    if(!is_null($this->getCredit())){
      $saldo = $saldo + $this->getCredit();
      $this->setTotal($saldo);
    }

    $this->account->setTotal($saldo);
  }
}
