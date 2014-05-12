<?php

namespace Success\AdsBundle\Model;

class CampaignBanner implements CampaignBannerInterface {

  const UPLOAD_DIR = 'uploads/campaign';
  
  protected $image;

  protected $link;

  protected $targetBlank;
  
  protected $file;
  
  protected $html;
  
//  protected $campaign;

  function __construct() {
    $this->start_date = new \DateTime();
    $this->end_date = new \DateTime('tomorrow 23:59:00');
  }
  
  public function __toString() {
    return (string) $this->link;
  }

  public function getAbsolutePath() {
    return null === $this->image ? null : $this->getUploadRootDir() . '/' . $this->image;
  }

  public function getWebPath() {
    return null === $this->image ? null : '/' . $this->getUploadDir() . '/' . $this->image;
  }

  public function getUploadRootDir() {
    return __DIR__ . '/../../../../../../web/' . $this->getUploadDir();
  }

  protected function getUploadDir() {
    // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
    return self::UPLOAD_DIR;
  }
  
  public function preUpload() {
    if (null !== $this->file) {
      // do whatever you want to generate a unique name
      $this->image = uniqid() . '.' . $this->file->guessExtension();
    }
  }

  public function upload() {
    if (null === $this->file) {
      return;
    }

    // you must throw an exception here if the file cannot be moved
    // so that the entity is not persisted to the database
    // which the UploadedFile move() method does automatically
    $this->file->move($this->getUploadRootDir(), $this->image);

    unset($this->file);
  }

  public function removeUpload() {
    if (!$file = $this->getAbsolutePath()) {
      return;
    }
    if (is_file($file)) {
      unlink($file);
    }
  }

  /**
   * Set image
   *
   * @param string $image
   */
  public function setImage($image) {
    $this->image = $image;
    return $this;
  }

  /**
   * Get image
   *
   * @return string
   */
  public function getImage() {
    return $this->image;
  }

  /**
   * Set file
   *
   * @param string $file
   */
  public function setFile($file) {
    if (!empty($file)) {
      $this->image = 'changed';
    }
    $this->file = $file;
    return $this;
  }

  /**
   * Get file
   *
   * @return string
   */
  public function getFile() {
    return $this->file;
  }

  /**
   * Set link
   *
   * @param string $link
   */
  public function setLink($link) {
    $this->link = $link;
    return $this;
  }

  /**
   * Get link
   *
   * @return string
   */
  public function getLink() {
    return $this->link;
  }

  /**
   * Set start_date
   *
   * @param \DateTime $start_date
   */
  public function setStartDate($start_date) {
    $this->start_date = $start_date;
    return $this;
  }

  /**
   * Get start_date
   *
   * @return \DateTime
   */
  public function getStartDate() {
    return $this->start_date;
  }

  /**
   * Set end_date
   *
   * @param \DateTime $end_date
   */
  public function setEndDate($end_date) {
    $this->end_date = $end_date;
    return $this;
  }

  /**
   * Get end_date
   *
   * @return \DateTime
   */
  public function getEndDate() {
    return $this->end_date;
  }

  /**
   * Set html
   *
   * @param string $html
   */
  public function setHtml($html) {
    $this->html = $html;
    return $this;
  }

  /**
   * Get html
   *
   * @return string
   */
  public function getHtml() {
    return $this->html;
  }

  /**
   * Set in_new_window
   *
   * @param boolean $inNewWindow
   * @return Banner
   */
  public function setTargetBlank($inNewWindow) {
    $this->targetBlank = $inNewWindow;

    return $this;
  }

  /**
   * Get in_new_window
   *
   * @return boolean 
   */
  public function getTargetBlank() {
    return $this->targetBlank;
  }
  
  /*public function setCampaign(\Success\AdsBundle\Model\Campaign $campaign) {
    $this->campaign = $campaign;

    return $this;
  }

  public function getCampaign() {
    return $this->campaign;
  }  */

}