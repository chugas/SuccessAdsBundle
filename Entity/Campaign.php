<?php

namespaceSuccess\AdsBundle\Entity;

use Success\AdsBundle\Model\Campaign as BaseCampaign;

class Campaign extends BaseCampaign {

  /**
   *
   * @var integer $id
   */
  protected $id;

  /**
   *
   * @access public
   */
  public function __construct() {
    parent::__construct();
  }

  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
  }

}
