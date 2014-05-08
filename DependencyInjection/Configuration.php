<?php

namespace Success\AdsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Success\AdsBundle\SuccessAdsBundle;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('success_ads');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('driver')->defaultValue(SuccessAdsBundle::DRIVER_DOCTRINE_ORM)->end()
            ->end()
        ;

        $this->addClassesSection($rootNode);

        return $treeBuilder;
    }
    
    private function addClassesSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('classes')
                    ->addDefaultsIfNotSet()
                    ->children()

                        ->arrayNode('campaign')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('Success\AdsBundle\Entity\Campaign')->end()
                                ->scalarNode('controller')->defaultValue('Success\AdsBundle\Controller\CampaignController')->end()
                                ->scalarNode('repository')->defaultValue('Success\AdsBundle\Doctrine\Repository\CampaignRepository')->end()
                                ->scalarNode('form')->defaultValue('Success\AdsBundle\Form\CampaignType')->end()
                                ->scalarNode('admin')->defaultValue('Success\AdsBundle\Admin\CampaignAdmin')->end()
                            ->end()
                        ->end()

                
                        ->arrayNode('campaignBanner')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('Success\AdsBundle\Entity\CampaignBanner')->end()
                                ->scalarNode('controller')->defaultValue('Success\AdsBundle\Controller\CampaignBannerController')->end()
                                ->scalarNode('repository')->defaultValue('Success\AdsBundle\Doctrine\Repository\CampaignBannerRepository')->end()
                                ->scalarNode('form')->defaultValue('Success\AdsBundle\Form\CampaignBannerType')->end()
                                ->scalarNode('admin')->defaultValue('Success\AdsBundle\Admin\CampaignBannerAdmin')->end()
                            ->end()
                        ->end()
                
                        ->arrayNode('campaignLog')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('Success\AdsBundle\Entity\CampaignLog')->end()
                                ->scalarNode('controller')->defaultValue('Success\AdsBundle\Controller\CampaignLogController')->end()
                                ->scalarNode('repository')->defaultValue('Success\AdsBundle\Doctrine\Repository\CampaignLogRepository')->end()
                                ->scalarNode('admin')->defaultValue('Success\AdsBundle\Admin\CampaignLogAdmin')->end()
                            ->end()
                        ->end()
                
                
                        ->arrayNode('campaignAccount')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('Success\AdsBundle\Entity\CampaignAccount')->end()
                                ->scalarNode('controller')->defaultValue('Success\AdsBundle\Controller\CampaignAccountController')->end()
                                ->scalarNode('repository')->defaultValue('Success\AdsBundle\Doctrine\Repository\CampaignAccountRepository')->end()
                                ->scalarNode('form')->defaultValue('Success\AdsBundle\Form\CampaignAccountType')->end()
                                ->scalarNode('admin')->defaultValue('Success\AdsBundle\Admin\CampaignAccountAdmin')->end()
                            ->end()
                        ->end()
                
                
                        ->arrayNode('campaignTransactionAccount')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('Success\AdsBundle\Entity\CampaignTransactionAccount')->end()
                                ->scalarNode('controller')->defaultValue('Success\AdsBundle\Controller\CampaignTransactionAccountController')->end()
                                ->scalarNode('repository')->defaultValue('Success\AdsBundle\Doctrine\Repository\CampaignTransactionAccountRepository')->end()
                                ->scalarNode('form')->defaultValue('Success\AdsBundle\Form\CampaignTransactionAccountType')->end()
                                ->scalarNode('admin')->defaultValue('Success\AdsBundle\Admin\CampaignTransactionAccountAdmin')->end()
                            ->end()
                        ->end()
                
                
                    ->end()
                ->end()
            ->end()
        ;
    }    
}
