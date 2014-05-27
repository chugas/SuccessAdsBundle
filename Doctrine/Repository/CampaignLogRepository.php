<?php

namespace Success\AdsBundle\Doctrine\Repository;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;

class CampaignLogRepository extends EntityRepository {

  public function getQueryBuilder($alias = 'c'){
    return $this->createQueryBuilder($alias);
  }

  public function findCampaignBy(array $criteria) {
    return $this->findOneBy($criteria);
  }

  public function findCampaigns() {
    return $this->findAll();
  }  
  
  /**
   * DoctrineDbalSingleTableAdapter::__construct() must be an instance of Doctrine\DBAL\Query\QueryBuilder
   * 
   * @param integer $id
   * @return Doctrine\DBAL\Query\QueryBuilder
   */
  public function findByCampaignQuery($id){
    $conn = $this->_em->getConnection();
    $qb = $conn->createQueryBuilder()
              ->select('l.*')
              ->from('success_campaign_log', 'l')
              ->where('l.campaign_id = :campaign_id')
              ->setParameter('campaign_id', $id);

    return $qb;
  }
  
  public function findStats($campaign_id){
    $conn = $this->_em->getConnection();
    $qb = $conn->createQueryBuilder()
              ->select('UNIX_TIMESTAMP(created_date)*1000 as date, views as count')
              ->from('success_campaign_log', 'l')
              ->where('l.campaign_id = :campaign_id')
              ->setParameter('campaign_id', $campaign_id);
    
    $stmt = $qb->execute();
    return $stmt->fetchAll();
  }
  
  public function findStatsQuery($campaign_id){
    $conn = $this->_em->getConnection();
    $qb = $conn->createQueryBuilder()
              ->select('UNIX_TIMESTAMP(created_date)*1000 as date, views as count')
              ->from('success_campaign_log', 'l')
              ->where('l.campaign_id = :campaign_id')
              ->setParameter('campaign_id', $campaign_id);
    
    return $qb;
  }
}
