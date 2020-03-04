<?php
defined('ABSPATH') || exit;

/**
 * 
 */
class Entities {

  public $entities;

  public function __construct($entities) {

    if(empty($entities)) return;

    $this->entities = $entities;

  }

  public function init() {

  }

  public function loopEntities($action) {

    if(empty($this->entities)) return;

    foreach($this->entities as $entity):
      if(!method_exists($entity, $action)) return;

      call_user_func([$entity, $action]);
    endforeach;

  }

  public function registerPostTypes() {

    $this->loopEntities('registerPostType');

  }

  public function registerTaxonomies() {

    $this->loopEntities('registerTaxonomies');

  }

  public function registerAPI() {

  }

}