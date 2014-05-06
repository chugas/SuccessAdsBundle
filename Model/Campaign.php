<?php

namespace Success\AdsBundle\Model;

use Symfony\Component\Security\Core\User\UserInterface;

class Campaign {

  /** @var Name $name */
  protected $name = null;
  
  /** @var Float $pricePerDay */
  protected $pricePerDay;

  /** @var Boolean $active */
  protected $active;

  /**
   *
   * @var \DateTime $createdDate
   */
  protected $createdDate;

  /**
   *
   * @var Boolean $isDeleted
   */
  protected $isDeleted = false;

  /**
   *
   * @var \DateTime $deletedDate
   */
  protected $deletedDate;

  /**
   *
   * @var \DateTime $unlockedDate
   */
  protected $unlockedDate;

  /**
   *
   * @var \DateTime $unlockedUntilDate
   */
  protected $unlockedUntilDate;

  /** @var UserInterface $createdBy */
  protected $createdBy;

  /** @var Attachment $attachment */
  protected $attachment = null;

  /**
   *
   * @access public
   */
  public function __construct() {
    // your own logic

    $this->unlockedDate = new \Datetime('now');
    $this->unlockedUntilDate = new \Datetime('now + 7 days');
  }
  
  public function getPricePerDay() {
    return $this->pricePerDay;
  }

  public function setPricePerDay($price) {
    $this->pricePerDay = $price;

    return $this;
  }
  
  public function getActive() {
    return $this->active;
  }

  public function setActive($active) {
    $this->active = $active;

    return $this;
  }  

  /**
   * Get createdDate
   *
   * @return \datetime
   */
  public function getCreatedDate() {
    return $this->createdDate;
  }

  /**
   * Set createdDate
   *
   * @param  \datetime $createdDate
   * @return Post
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
   * @return Post
   */
  public function setDeleted($isDeleted) {
    $this->isDeleted = $isDeleted;

    return $this;
  }

  /**
   * Get deletedDate
   *
   * @return \datetime
   */
  public function getDeletedDate() {
    return $this->deletedDate;
  }

  /**
   * Set deletedDate
   *
   * @param  \datetime $deletedDate
   * @return Post
   */
  public function setDeletedDate($deletedDate) {
    $this->deletedDate = $deletedDate;

    return $this;
  }

  /**
   * Get unlockedDate
   *
   * @return \datetime
   */
  public function getUnlockedDate() {
    return $this->unlockedDate;
  }

  /**
   * Set unlockedDate
   *
   * @param  \datetime $datetime
   * @return Post
   */
  public function setUnlockedDate(\Datetime $datetime) {
    $this->unlockedDate = $datetime;

    return $this;
  }

  /**
   * Get unlockedUntilDate
   *
   * @return \datetime
   */
  public function getUnlockedUntilDate() {
    return $this->unlockedUntilDate;
  }

  /**
   * Set unlockedUntilDate
   *
   * @param  \datetime $datetime
   * @return Post
   */
  public function setUnlockedUntilDate(\Datetime $datetime) {
    $this->unlockedUntilDate = $datetime;

    return $this;
  }

  /**
   * Get isUnlocked
   *
   * @return \datetime
   */
  public function isLocked() {
    return $this->unlockedUntilDate > new \Datetime('now') ? false : true;
  }

  /**
   * Get name
   *
   * @return Name
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Set name
   *
   * @param  Name $name
   * @return Post
   */
  public function setName($name = null) {
    $this->name = $name;

    return $this;
  }

  /**
   * Get created_by
   *
   * @return UserInterface
   */
  public function getCreatedBy() {
    return $this->createdBy;
  }

  /**
   * Set created_by
   *
   * @param  UserInterface $createdBy
   * @return Post
   */
  public function setCreatedBy(UserInterface $createdBy = null) {
    $this->createdBy = $createdBy;

    return $this;
  }

}
