<?php

namespace Success\AdsBundle\Doctrine\Manager;

class CampaignLogManager {

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
  public function create() {
    $class = $this->getClass();
    $campaignLog = new $class;

    return $campaignLog;
  }

  /**
   * {@inheritDoc}
   */
  public function reload($campaignLog) {
    $this->objectManager->refresh($campaignLog);
  }

  /**
   * Updates a campaignLog.
   *
   * @param Application\Success\AdsBundle\Model\campaignLog $campaignLog
   * @param Boolean       $andFlush Whether to flush the changes (default true)
   */
  public function update($campaignLog, $andFlush = true) {
    $this->objectManager->persist($campaignLog);
    if ($andFlush) {
      $this->objectManager->flush();
    }
  }  

  public function delete($campaignLog) {
    $this->objectManager->remove($campaignLog);
    $this->objectManager->flush();
  }
  
  public function getOneBy($campaign, $date){
    $campaignLog = $this->repository->findOneBy(array('campaign' => $campaign, 'createdDate' => $date));
    if(is_null($campaignLog)){
      $campaignLog = $this->create();              
    }
    return $campaignLog;
  }  

  /**
   * {@inheritDoc}
   */
  public function getClass() {
    return $this->class;
  }

}
