<?php

namespace Success\AdsBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;

class CampaignTransactionAccountFilter extends AbstractType {
  
  public function buildForm(FormBuilderInterface $builder, array $options) {
    
    $builder->add('created_date', 'filter_date_range', array(
      'left_date_options'  => array(
          'format' => 'dd/MM/yyyy',
          'attr'   => array('class' => 'nav-datepicker', 'autocomplete' => 'off'),
          'widget' => 'single_text'
      ),
      'right_date_options' => array(
          'format' => 'dd/MM/yyyy',
          'attr'   => array('class' => 'nav-datepicker', 'autocomplete' => 'off'),
          'widget' => 'single_text'
      )
    ));
    
    /*$builder->add('sections', 'filter_entity', array(
      'class' => 'Application\Success\AdsBundle\Entity\Section',
      'property' => 'name',
      'attr'   => array('class' => 'form-control', 'autocomplete' => 'off'),
      'apply_filter' => function (QueryInterface $filterQuery, $field, $values) {

        if (!empty($values['value'])) {
          $qb = $filterQuery->getQueryBuilder();

          $alias = current($qb->getDQLPart('from'))->getAlias();

          $qb->leftJoin($alias . '.sections', 's');
          $qb->andWhere($qb->expr()->in('s.id', $values['value']->getId()));
        }

      }
    ));*/
    
  }

  public function getName() {
    return 'success_campaign_transaction_account_filter';
  }
  
  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
        'csrf_protection' => false,
        'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
    ));
  }

}

?>
