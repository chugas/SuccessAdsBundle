<?php

namespace Success\AdsBundle\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;

class CampaignTransactionAccountRepository extends EntityRepository {

  public function getQueryBuilder($alias = 'c'){
    return $this->createQueryBuilder($alias);
  }
  
  /**
   * DoctrineDbalSingleTableAdapter::__construct() must be an instance of Doctrine\DBAL\Query\QueryBuilder
   * 
   * @param integer $id
   * @return Doctrine\DBAL\Query\QueryBuilder
   */
  public function findByAccountQuery($id){
    $conn = $this->_em->getConnection();
    $qb = $conn->createQueryBuilder()
              ->select('t.*')
              ->from('success_campaign_transaction_account', 't')
              ->where('t.campaign_account_id = :account_id')
              ->setParameter('account_id', $id);

    return $qb;
  }
}
