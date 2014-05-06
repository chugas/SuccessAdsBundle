<?php

namespace Success\AdsBundle\Doctrine;

class CampaignManager {

  protected $objectManager;
  protected $class;
  protected $repository;

  public function __construct($em, $class) {
    $this->objectManager = $em;
    $this->repository = $em->getRepository($class);

    $metadata = $em->getClassMetadata($class);
    $this->class = $metadata->getName();
  }
  
  /**
   * Returns an empty user instance
   *
   * @return Application\Success\AdsBundle\Model\Campaign
   */
  public function createCampaign() {
    $class = $this->getClass();
    $campaign = new $class;

    return $campaign;
  }

  /**
   * {@inheritDoc}
   */
  public function reloadCampaign($campaign) {
    $this->objectManager->refresh($campaign);
  }

  /**
   * Updates a campaign.
   *
   * @param Application\Success\AdsBundle\Model\Campaign $campaign
   * @param Boolean       $andFlush Whether to flush the changes (default true)
   */
  public function updateCampaign($campaign, $andFlush = true) {
    $this->objectManager->persist($campaign);
    if ($andFlush) {
      $this->objectManager->flush();
    }
  }  

  public function deleteCampaign($campaign) {
    $this->objectManager->remove($campaign);
    $this->objectManager->flush();
  }

  /**
   * {@inheritDoc}
   */
  public function getClass() {
    return $this->class;
  }

}
