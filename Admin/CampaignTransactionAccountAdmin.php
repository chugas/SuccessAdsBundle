<?php

namespace Success\AdsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class CampaignTransactionAccountAdmin extends Admin
{
    protected $datagridValues = array(
      '_sort_order' => 'DESC', // sort direction
      '_sort_by' => 'createdDate' // field name
    );
  
    protected $translationDomain = 'SuccessAdsBundle';
    protected $parentAssociationMapping = 'account';
  
    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
          ->add('concept', 'textarea', array('label' => 'campaignTransactionAccount.form.concept'))
          ->add('debit', 'text', array('label' => 'campaignTransactionAccount.form.debit', 'required' => false))
          ->add('credit', 'text', array('label' => 'campaignTransactionAccount.form.credit', 'required' => false))
        ;
    }

    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('createdDate')
            ->add('concept')
            ->add('debit')
            ->add('credit')
            ->add('total')
        ;
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
    }

    /*public function prePersist($object){
      $campaignAccount = $object->getAccount();
      
      $saldo = $campaignAccount->getTotal();
      if(!is_null($object->getDebit())){
        $saldo = $saldo - $object->getDebit();
        $object->setTotal($saldo);
      }
      if(!is_null($object->getCredit())){
        $saldo = $saldo + $object->getCredit();
        $object->setTotal($saldo);
      }
      
      $campaignAccount->setTotal($saldo);
    }*/

}
