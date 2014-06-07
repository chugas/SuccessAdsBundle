<?php

namespace Success\AdsBundle\Model;

class CampaignAccount implements CampaignAccountInterface {

  protected $code;
  protected $currency;
  protected $total;
  protected $createdDate;
  protected $user;
  protected $isDeleted = false;
  protected $deletedDate;
  
  public function __construct() {
    $this->createdDate = new \Datetime('now');    
    $this->code = 'AGAC' . $this->createdDate->format('Ym') . strtoupper(substr(sha1(uniqid(mt_rand(), true)), 30, 10));
    $this->total = 0;
  }
  
  public function __toString() {
    return (string) $this->code;
  }
  
  public function getCode(){
    return $this->code;
  }
  
  public function setCode($code){
    $this->code = $code;
    
    return $this;    
  }
  
  public function getCurrency(){
    return $this->currency;
  }
  
  public function setCurrency($currency){
    $this->currency = $currency;
    
    return $this;    
  }
  
  public function getTotal(){
    return $this->total;
  }
  
  public function setTotal($total){
    $this->total = $total;
    
    return $this;    
  }
  
  public function getUser(){
    return $this->user;
  }
  
  public function setUser(\Symfony\Component\Security\Core\User\UserInterface $user){
    $this->user = $user;
    
    return $this;
  }

  /**
   * Get createdDate
   *
   * @return \Datetime
   */
  public function getCreatedDate() {
    return $this->createdDate;
  }

  /**
   * Set createdDate
   *
   * @param  \Datetime $createdDate
   * @return CampaignAccount
   */
  public function setCreatedDate($createdDate) {
    $this->createdDate = $createdDate;

    return $this;
  }
  
  /**
   * Get isDeleted
   *
   * @return boolean
   */
  public function isDeleted() {
    return $this->isDeleted;
  }

  /**
   * Set is_deleted
   *
   * @param  boolean $isDeleted
   * @return CampaignAccount
   */
  public function setDeleted($isDeleted) {
    $this->isDeleted = $isDeleted;
    $this->deletedDate = new \Datetime('now');

    return $this;
  }

  /**
   * Get deletedDate
   *
   * @return \Datetime
   */
  public function getDeletedDate() {
    return $this->deletedDate;
  }

  /**
   * Set deletedDate
   *
   * @param  \datetime $deletedDate
   * @return CampaignAccount
   */
  public function setDeletedDate($deletedDate) {
    $this->deletedDate = $deletedDate;

    return $this;
  }
  
  public function isBankruptcy($gasto = null){
    if(!is_null($gasto)){
      $this->total = $this->total - $gasto;
    }
    
    return $this->total <= 0;
  }
}
