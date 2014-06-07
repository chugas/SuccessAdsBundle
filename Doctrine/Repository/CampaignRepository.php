<?php

namespace Success\AdsBundle\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;

class CampaignRepository extends EntityRepository {

  public function getQueryBuilder($alias = 'c'){
    return $this->createQueryBuilder($alias);
  }
  
  public function findCampaignByUserQuery($success_user_id){
    $qb = $this->getQueryBuilder('c')
            ->where('c.createdBy = :user_id');
    
    $qb->setParameter('user_id', $success_user_id);

    return $qb;
  }

  public function findCampaignBy(array $criteria) {
    return $this->findOneBy($criteria);
  }

  public function findCampaigns() {
    return $this->findAll();
  }

  public function findCampaignsByIds($ids) {
    $qb = $this->getQueryBuilder('c');
    $qb->add('where', $qb->expr()->in('c.id', $ids));
    return $qb->getQuery()->execute();
  }

  public function intelligentFinder(){
    $qb = $this->getQueryBuilder('c')
            ->innerJoin('c.banner', 'b')
            ->where('c.active = 1')
            ->andWhere('c.verified = 1')
            ->andWhere('c.blocked = 0')            
            ->andWhere('c.unlockedDate <= CURRENT_TIMESTAMP()')
            ->andWhere('c.unlockedUntilDate > CURRENT_TIMESTAMP()')
            ->orderBy('c.pricePerDay', 'DESC');
    $qb->setMaxResults(20);
    
    return $qb->getQuery()->execute();
  }
  
  /**
   * DoctrineDbalSingleTableAdapter::__construct() must be an instance of Doctrine\DBAL\Query\QueryBuilder
   * 
   */
  public function findCampaignRecords(){
    $conn = $this->_em->getConnection();
    $qb = $conn->createQueryBuilder()
              ->select('c.*')
              ->from('success_campaign', 'c')
              ->where('c.active = 1')
              ->andWhere('c.verified = 1')
              ->andWhere('c.blocked = 0')
              ->andWhere('c.unlocked_date <= CURRENT_TIMESTAMP()')
              ->andWhere('c.unlocked_until_date > CURRENT_TIMESTAMP()');

    $stmt = $qb->execute();
    return $stmt->fetchAll();
  }
  
  /*public function getFirstPostForTopicById($topicId) {
    if (null == $topicId || !is_numeric($topicId) || $topicId == 0) {
      throw new \Exception('Topic id "' . $topicId . '" is invalid!');
    }

    $params = array(':topicId' => $topicId);

    $qb = $this->createSelectQuery(array('p', 't'));

    $qb
            ->leftJoin('p.topic', 't')
            ->where(
                    $qb->expr()->eq('t.id', ':topicId')
            )
            ->orderBy('p.createdDate', 'ASC')
            ->setMaxResults(1)
    ;

    return $this->gateway->findPost($qb, $params);
  }*/

  /*public function findList($page, $count){
    $consulta = $this->getQueryBuilder()
            ->orderBy('e.timeAt', 'DESC');

    $consulta->setFirstResult(($page-1)*$count);
    $consulta->setMaxResults($count);
    
    //$q->useResultCache(true, 300, 'eventos.proximos'); // 5 minutos
    
    return $consulta->getQuery()->execute();    
  }*/
}
