<?php

namespace Success\AdsBundle\Doctrine\Repository;

use Doctrine\DBAL\Connection;

class CampaignRealLogRepository {
  
  protected $connection;
  
  public function __construct(Connection $conn) {
    $this->connection = $conn;
  }
  
  public function insert($campaigns, $ip){
    $this->connection->beginTransaction();
    foreach($campaigns as $campaign){
      $now = new \DateTime('now');
      $sql = 'INSERT INTO campaign_real_log ( campaign_id, created_date, ip ) VALUES (?,?,?)';
      $stmt = $this->connection->prepare($sql);
      $stmt->bindValue(1, $campaign->getId());
      $stmt->bindValue(2, $now->format('Y-m-d H:i:s'));
      $stmt->bindValue(3, $ip);
      $stmt->execute();
    }
    $this->connection->commit();  
  }

}
