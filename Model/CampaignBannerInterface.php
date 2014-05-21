<?php

namespace Success\AdsBundle\Model;

interface CampaignBannerInterface {

  public function getAbsolutePath();

  public function getWebPath();

  public function getUploadRootDir();

  public function preUpload();

  public function upload();

  public function removeUpload();

  public function setImage($image);

  public function getImage();

  public function setFile($file);

  public function getFile();

  public function setLink($link);

  public function getLink();

  public function setHtml($html);

  public function getHtml();

  public function setTargetBlank($inNewWindow);

  public function getTargetBlank();

}