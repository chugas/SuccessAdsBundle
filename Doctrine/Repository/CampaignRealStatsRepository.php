<?php

namespace Success\AdsBundle\Doctrine\Repository;

use Doctrine\DBAL\Connection;

class CampaignRealStatsRepository {
  
  protected $connection;
  
  public function __construct(Connection $conn) {
    $this->connection = $conn;
  }
  
  public function getConnection(){
    return $this->connection;
  }

  public function insert($campaigns, $pricePerView){
    $this->connection->beginTransaction();
    foreach($campaigns as $campaign){
      // calculamos la cantidad maxima de impresiones que puede tener
      $max_views = floor((float)$campaign['pricePerDay'] / (float)$pricePerView);

      $sql = 'INSERT INTO campaign_real_stats ( campaign_id, views, max_views, weight ) VALUES (?,?,?,?)';
      $stmt = $this->connection->prepare($sql);
      $stmt->bindValue(1, $campaign['id']);
      $stmt->bindValue(2, 0);
      $stmt->bindValue(3, $max_views);
      $stmt->bindValue(4, $max_views);
      $stmt->execute();
    }
    $this->connection->commit();  
  }
  
  public function intelligentFinder($limit = 3){
    $sql = 'SELECT campaign_id, views, RAND() * weight as coef FROM campaign_real_stats WHERE views < max_views ORDER BY coef DESC LIMIT ' . $limit;
    $stmt = $this->connection->prepare($sql);
    return $stmt->execute();
  }

}
