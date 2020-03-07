<?php
defined('ABSPATH') || exit;

/**
 * 
 */
class PostRESTController extends RESTController {

  public function __construct() {

    parent::__construct();

    $this->post_type = 'post';
    
  }

  public function addData($data, $post, $context) {

    parent::addData($data, $post, $context);

  }

  public function removeData($data, $post, $context) {
    
    parent::removeData($data, $post, $context);

    //unset($data->data['title']); //Example

  }

}