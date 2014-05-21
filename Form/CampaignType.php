<?php

namespace Success\AdsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;

class CampaignType extends AbstractType {

  private $dataClass;

  public function __construct($dataClass) {
    $this->dataClass = $dataClass;
  }

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
            ->add('name', 'text', array(
                'label' => 'campaign.form.name',
                'constraints' => array(
                    new NotBlank(),
                    new Length(array('min' => 2))
                )
            ))
            ->add('pricePerDay', 'text', array(
                'label' => 'campaign.form.pricePerDay',
                'constraints' => array(
                    new NotBlank(),
                    new Type(array('type' => 'float'))
                )
            ))
            ->add('unlockedDate', 'datetime', array(
                'label' => 'campaign.form.unlockedDate'
            ))
            ->add('unlockedUntilDate', 'datetime', array(
                'label' => 'campaign.form.unlockedUntilDate'
            ))
            ->add('banner', 'success_campaign_banner', array(
                'constraints' => array(
                    new NotBlank()
                )
            ))
    ;
  }

  public function getName() {
    return 'success_campaign';
  }

  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
        'translation_domain' => 'SuccessAdsBundle',
        'data_class' => $this->dataClass
    ));
  }

}
