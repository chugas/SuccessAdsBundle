<?php

namespace Success\AdsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CampaignBannerType extends AbstractType {

  private $dataClass;

  public function __construct($dataClass) {
    $this->dataClass = $dataClass;
  }

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('link', 'text', array(
          'label' => 'campaignBanner.form.link'
      ))
      ->add('file', 'file', array(
          'label' => 'campaignBanner.form.file',
          'required' => false,
          'data_class' => null
      ))
    ;
  }

  public function getName() {
    return 'success_campaign_banner';
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
        'translation_domain' => 'SuccessAdsBundle',
        'data_class' => $this->dataClass
    ));
  }
}
