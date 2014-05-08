<?php

namespace Success\AdsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class CampaignLogAdmin extends Admin
{
    protected $datagridValues = array(
      '_sort_order' => 'DESC', // sort direction
      '_sort_by' => 'createdDate' // field name
    );
  
    protected $translationDomain = 'SuccessAdsBundle';

    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
          ->add('campaign', 'sonata_type_model_list', array('btn_add' => false, 'label' => 'campaignLog.form.campaign'))
          ->add('views', 'text', array('label' => 'campaignLog.form.name'))
          ->add('clicks', 'text', array('label' => 'campaignLog.form.pricePerDay'))
          ->add('active', 'checkbox', array('label' => 'campaignLog.form.active', 'required' => false))
        ;
    }

    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('campaign')
            ->add('views')
            ->add('clicks')
            ->add('createdDate')
            ->add('active', null, array('editable' => true))
        ;
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('campaign')
            ->add('createdDate', 'doctrine_orm_date')
        ;
    }

}
