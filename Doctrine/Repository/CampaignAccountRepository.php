<?php

namespace Success\AdsBundle\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;

class CampaignAccountRepository extends EntityRepository {

  public function getQueryBuilder($alias = 'c'){
    return $this->createQueryBuilder($alias);
  }

  public function findAccountBy(array $criteria) {
    return $this->findOneBy($criteria);
  }

}
