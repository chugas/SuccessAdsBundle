<?php

namespace Success\AdsBundle\Filter;

//Pager

//use Pagerfanta\Adapter\DoctrineCollectionAdapter;
//use Pagerfanta\Adapter\DoctrineDbalAdapter;

use Pagerfanta\Adapter\DoctrineDbalSingleTableAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\QueryBuilder;

class CoreFilter {
  
  const DOCTRINE_ORM = 'doctrine_orm';
  
  const DOCTRINE_DBAL = 'doctrine_dbal';
  
  protected $pager;
  protected $request;
  protected $form;
  protected $query_builder_updater;

  protected $class;
  protected $em;

  protected $queryBuilder;
  protected $sort_order = 'DESC';
  protected $sort_by = 'id';  
  protected $alias;
  protected $maxPerPage = 20;

  protected $persistFilters;
  protected $bound = false;
  
  protected $adapter;

  protected $results;
  
  public function __construct(FormInterface $form, $query_builder_updater, $em, $class) {
    $this->request = null;
    $this->em = $em;
    $this->class = $class;
    $this->form = $form;

    $this->persistFilters = false;
    $this->results = false;
    $this->query_builder_updater = $query_builder_updater;
    $this->queryBuilder = false;
    $this->adapter = self::DOCTRINE_ORM;
  }
  
  public function setAlias($alias) {
    $this->alias = $alias;
  }
  
  public function setMaxPerPage($max) {
    $this->maxPerPage = $max;
  }

  public function setAdapter($adapter) {
    $this->adapter = $adapter;
  }

  public function setPersistFilters($value) {
    $this->persistFilters = $value;
  }
  
  public function setRequest(Request $request = null)
  {
      $this->request = $request;
  }  

  public function getPager() {
    $this->buildFilter();
    
    return $this->pager;
  }

  public function getResults() {
    $this->buildFilter();

    if (!$this->results) {
      $this->results = $this->pager->getCurrentPageResults();
    }

    return $this->results;
  }

  public function setQueryBuilder($qb) {
    $this->queryBuilder = $qb;
  }
  
  public function getQueryBuilder() {
    return $this->queryBuilder;
  }  
  
  public function setOrderBy($sort_by, $sort_order) {
    $this->sort_order = $sort_order;
    $this->sort_by = $sort_by;
  }
  
  public function createQueryBuilder($alias) {
    $query = $this->em->getRepository($this->class)->createQueryBuilder($alias);

    return $query;
  }

  public function getFilterParameters() {
    $default_filters = array(
        '_sort_order' => $this->sort_order,
        '_sort_by' => $this->sort_by,
        '_per_page' => $this->maxPerPage
    );

    $filters = array();
    
    $code = $this->form->getName();

    // build the values array
    if (!is_null($this->request)) {
      $filters = $this->request->query->get($code, array());
      // if persisting filters, save filters to session, or pull them out of session if no new filters set
      if ($this->persistFilters) {
        if ($filters == array() && $this->request->query->get('filters') != 'reset') {
          $filters = $this->request->getSession()->get($code . '.filter.parameters', array());
        } else {
          $this->request->getSession()->set($code . '.filter.parameters', $filters);
        }
      }
    }
    
    $parameters = array_merge($default_filters, $filters);

    return $parameters;
  }
  
  public function buildFilter() {
    if ($this->bound) {
      return;
    }

    // obtenemos los parametros
    $filterParameters = $this->getFilterParameters();
    // bind values from the request
    $this->form->bind($filterParameters);
    if(!$this->queryBuilder) 
      $this->queryBuilder = $this->createQueryBuilder('a');
    
    switch ($this->adapter){
      case self::DOCTRINE_DBAL:
          $info = (current($this->queryBuilder->getQueryPart('from')));
          $this->alias = $info['alias'];
          $this->query_builder_updater->addFilterConditions($this->form, $this->queryBuilder);
          $this->queryBuilder->orderBy($this->alias . '.' . $filterParameters['_sort_by'], $filterParameters['_sort_order']);
          $adapter = new DoctrineDbalSingleTableAdapter($this->queryBuilder, $this->alias . '.id');
        break;
      case self::DOCTRINE_ORM:
      default:
          $this->alias = $this->queryBuilder->getRootAlias();
          $this->query_builder_updater->addFilterConditions($this->form, $this->queryBuilder);
          $this->queryBuilder->orderBy($this->alias . '.' . $filterParameters['_sort_by'], $filterParameters['_sort_order']);
          $adapter = new DoctrineORMAdapter($this->queryBuilder);      
        break;
    }

    $this->pager = new Pagerfanta($adapter);
    $this->pager->setMaxPerPage(array_key_exists('_per_page', $filterParameters) ? $filterParameters['_per_page'] : $this->maxPerPage);
    $this->pager->setCurrentPage(array_key_exists('_page', $filterParameters) ? $filterParameters['_page'] : $this->request->get('page', 1));
    
    $this->bound = true;
  }

  public function getFormFilter() {
    $this->buildFilter();

    return $this->form;
  }

}
?>
