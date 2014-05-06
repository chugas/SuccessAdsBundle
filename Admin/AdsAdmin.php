<?php

namespace Success\AdsBundle\Admin;

use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;


class AdsAdmin extends SuccessNewsAdmin {
  protected $datagridValues = array(
    '_sort_order' => 'DESC', // sort direction
    '_sort_by' => 'date_published' // field name
  );
  
/* public function getTemplate($name) {
    switch ($name) {
      case 'edit':
        return 'PortalBundle:Admin/News:edit.html.twig';
        break;
      default:
        return parent::getTemplate($name);
        break;
    }
  }  */
  
  /**
   * Create and Edit
   * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
   *
   * @return void
   */
  /*protected function configureFormFields(FormMapper $formMapper) {
    $formMapper
            ->add('title')
            ->add('status', 'choice', array('choices' => NewsStatusEnumType::getChoices()))
            ->add('template', 'choice', array('choices' => NewsTemplateEnumType::getChoices()))            
            ->add('published', null, array('required' => false))
            ->add('slider', null, array('required' => false))
            ->add('date_published')
            ->add('abstract', 'textarea', array(
                'attr' => array(
                    'class' => 'span8',
                    'data-theme' => 'simple', // simple, advanced, bbcode,
                    'rows' => 20
                    )))   
            ->add('content', 'textarea', array(
                'attr' => array(
                    'class' => 'tinymce span8',
                    'data-theme' => 'advanced', // simple, advanced, bbcode,
                    'rows' => 20
                    )))

            ->with('Categorias')            
              ->add('categories', new TreeType($this->entity_manager, $this), array(
                      'class' => 'Success\CategoryBundle\Entity\Category',
                      'multiple' => true
                  ))
            ->end()
            
            ->with('Imagenes')
              ->add('newsHasMedias', 'sonata_type_collection', array(
                      'cascade_validation' => true,
                      'required' => false,
                      'by_reference' => false,
                      'label' => 'Medias'
                  ), array(
                      'edit' => 'inline',
                      'inline' => 'table',
                      'sortable'  => 'position',
                      'link_parameters' => array('context' => 'default'),
                      'allow_delete' => true,
                      'help' => 'Opcionalmente puedes agregar la cantidad de imagenes que quieras a la noticia.'
                  ))
            ->end()
            
            ->with('Documentos')
              ->add('newsHasDocuments', 'sonata_type_collection', array(
                      'cascade_validation' => true,
                      'required' => false,
                      'by_reference' => false,
                      'label' => 'Documentos'
                  ), array(
                      'edit' => 'inline',
                      'inline' => 'table',
                      'sortable'  => 'position',
                      'link_parameters' => array('context' => 'news_files'),
                      'allow_delete' => true
                  ))
            ->end()            
    ;
  }*/

  /**
   * List
   * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
   *
   * @return void
   */
  /*protected function configureListFields(ListMapper $listMapper) {
    $listMapper
            ->addIdentifier('id')
            ->addIdentifier('title')
            ->add('published', null, array('editable' => true))
            ->add('slider', null, array('editable' => true))            
            ->add('status')
            ->add('author', null, array('label' => 'Author'))
            ->add('created', null, array('label' => 'Created on'))
    ;
  }*/

  /**
   * Filters
   * @param \Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper
   *
   * @return void
   */
  /*protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
    $datagridMapper
            ->add('id')
            ->add('published')
            ->add('title')
            //->add('author')
            ->add('created')
    ;
  }*/

}
