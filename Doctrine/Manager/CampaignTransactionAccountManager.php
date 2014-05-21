<?php

namespace Success\AdsBundle\Doctrine\Manager;

class CampaignTransactionAccountManager {

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
   * @return Application\Success\AdsBundle\Model\CampaignTransactionAccountInterface
   */
  public function create() {
    $class = $this->getClass();
    $campaign = new $class;

    return $campaign;
  }

  /**
   * {@inheritDoc}
   */
  public function reload($campaign) {
    $this->objectManager->refresh($campaign);
  }

  /**
   * Updates a campaign.
   *
   * @param Application\Success\AdsBundle\Model\CampaignTransactionAccountInterface $campaign
   * @param Boolean       $andFlush Whether to flush the changes (default true)
   */
  public function update($campaign, $andFlush = true) {
    $this->objectManager->persist($campaign);
    if ($andFlush) {
      $this->objectManager->flush();
    }
  }  

  public function delete($campaign) {
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
