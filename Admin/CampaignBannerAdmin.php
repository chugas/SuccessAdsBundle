<?php

namespace Success\AdsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class CampaignBannerAdmin extends Admin
{
    protected $datagridValues = array(
      '_sort_order' => 'DESC', // sort direction
      '_sort_by' => 'id' // field name
    );
  
    protected $translationDomain = 'SuccessAdsBundle';

    public function configureFormFields(FormMapper $formMapper)
    {
        $options = array('required' => false, 'label' => 'campaignBanner.form.file', 'data_class' => null);
        if (($subject = $this->getSubject()) && $subject->getImage()) {
          $path = $subject->getWebPath();
          $options['help'] = '<img src="' . $path . '" width="290" />';      
        }
              
        $formMapper
          ->add('file', 'file', $options)
          ->add('link', 'text', array('label' => 'campaignBanner.form.link'))
          ->add('targetBlank', 'checkbox', array('label' => 'campaignBanner.form.targetBlank', 'required' => false))
          ->add('html', 'textarea', array(
              'label' => 'campaignBanner.form.html', 
              'required' => false,
              'attr' => array(
                'class' => 'tinymce span8 form-control',
                'data-theme' => 'simple', // simple, advanced, bbcode,
                'rows' => 10
              )
          ))
        ;
    }

    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('link')
        ;
    }

}
