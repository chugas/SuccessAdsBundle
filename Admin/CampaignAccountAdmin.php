<?php

namespace Success\AdsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;

class CampaignAccountAdmin extends Admin
{
    protected $datagridValues = array(
      '_sort_order' => 'DESC', // sort direction
      '_sort_by' => 'id' // field name
    );
  
    protected $translationDomain = 'SuccessAdsBundle';

    public function configureFormFields(FormMapper $formMapper)
    {              
        $formMapper
          ->add('currency', 'text', array('label' => 'campaignAccount.form.currency'))
          ->add('total', 'text', array('label' => 'campaignAccount.form.total', 'required' => false))
          ->add('user', 'sonata_type_model_list', array('btn_add' => false, 'label' => 'campaignAccount.form.user'))
        ;
    }

    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('code')
            ->add('user')
            ->add('total')
            ->add('currency')
            ->add('isDeleted', null, array('editable' => true))
        ;
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('code')
        ;
    }
    
  protected function configureTabMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null) {
    if (!$childAdmin && !in_array($action, array('edit'))) {
      return;
    }

    $admin = $this->isChild() ? $this->getParent() : $this;

    $id = $admin->getRequest()->get('id');

    $menu->addChild(
      $this->trans('Cuenta'), array('uri' => $admin->generateUrl('edit', array('id' => $id)))
    );

    $menu->addChild(
      $this->trans('Movimientos'), array('uri' => $admin->generateUrl('success_ads.admin.campaigntransactionaccount.list', array('id' => $id)))
    );

  }    
}
