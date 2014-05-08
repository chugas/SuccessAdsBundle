<?php

namespace Success\AdsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;

class SuccessAdsBundle extends Bundle {

  const DRIVER_DOCTRINE_ORM = 'doctrine/orm';
  const DRIVER_DOCTRINE_MONGODB_ODM = 'doctrine/mongodb-odm';

  public static function getSupportedDrivers() {
    return array(
        self::DRIVER_DOCTRINE_ORM
    );
  }

  public function build(ContainerBuilder $container) {
    $mappings = array(
        realpath(__DIR__ . '/Resources/config/doctrine/model') => 'Success\AdsBundle\Entity'
    );

    $container->addCompilerPass(DoctrineOrmMappingsPass::createYamlMappingDriver($mappings, array('doctrine.orm.entity_manager'), 'success_ads.driver.doctrine/orm'));
  }

}
