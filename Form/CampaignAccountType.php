<?php

namespace Success\AdsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CampaignAccounType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $options_file = array('required' => false);
    $options_file['data_class'] = null;
    /*if (($subject = $this->getSubject()) && $subject->getImage()) {
      $path = $subject->getWebPath();
      $options['help'] = '<img src="' . $path . '" width="290" />';
    }*/

    $builder
      ->add('name', 'text')
      ->add('pricePerDay', 'text')
      ->add('active')
      ->add('file', 'file', $options_file)
    ;
  }

  public function getName() {
    return 'success_ads';
  }

}
