<?php

namespace Success\AdsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Success\AdsBundle\Model\Campaign;

class CampaignAdmin extends Admin
{
    protected $datagridValues = array(
      '_sort_order' => 'DESC', // sort direction
      '_sort_by' => 'createdDate' // field name
    );
  
    protected $translationDomain = 'SuccessAdsBundle';

    public function configureFormFields(FormMapper $formMapper)
    {
      $choices = array(
        Campaign::TYPE_FIXED => $this->trans('campaign.form.campaignType.' . Campaign::TYPE_FIXED),
        Campaign::TYPE_VIEWS => $this->trans('campaign.form.campaignType.' . Campaign::TYPE_VIEWS),
      );
      
      $formMapper
        ->add('name', 'text', array('label' => 'campaign.form.name'))
        ->add('pricePerDay', 'text', array('label' => 'campaign.form.pricePerDay'))
        ->add('campaignType', 'choice', array('choices' => $choices, 'label' => 'campaign.form.campaignType.label'))                
        ->add('unlockedDate', 'date', array('label' => 'campaign.form.unlockedDate'))
        ->add('unlockedUntilDate', 'date', array('label' => 'campaign.form.unlockedUntilDate'))
        ->add('createdBy', 'sonata_type_model_list', array('btn_add' => false, 'label' => 'campaign.form.createdBy'))
        ->add('active', 'checkbox', array('label' => 'campaign.form.active'))
        ->add('verified', 'checkbox', array('label' => 'campaign.form.verified'))
        ->add('blocked', 'checkbox', array('label' => 'campaign.form.blocked'))
        ->add('banner', 'sonata_type_model_list', array('btn_list' => false))
      ;
    }

    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('code')
            ->add('name')
            ->add('pricePerDay')
            ->add('unlockedDate')
            ->add('unlockedUntilDate')
            ->add('active', null, array('editable' => true))
            ->add('isDeleted', null, array('editable' => true))
        ;
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('code')
            ->add('name')
            ->add('unlockedDate', 'doctrine_orm_date')
            ->add('unlockedUntilDate', 'doctrine_orm_date')
            ->add('active')
        ;
    }

}
