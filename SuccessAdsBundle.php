<?php

namespace Success\AdsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SuccessAdsBundle extends Bundle
{
  const DRIVER_DOCTRINE_ORM = 'doctrine/orm';
  const DRIVER_DOCTRINE_MONGODB_ODM = 'doctrine/mongodb-odm';

  public static function getSupportedDrivers() {
    return array(
        self::DRIVER_DOCTRINE_ORM
    );
  }
  
  /*public function build(ContainerBuilder $container){
    $mappings = array(
        realpath(__DIR__ . '/Resources/config/doctrine/model') => 'Application\Success\CoreBundle\Model',
    );

    $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver($mappings, array('doctrine.orm.entity_manager'), 'core.driver.doctrine/orm'));    
  }*/  
}
