<?php
defined('ABSPATH') || exit;

/**
 * 
 */
class IngredientRESTController extends RESTController {

  public function __construct() {

    parent::__construct();

    $this->post_type = 'ingredient';
    
  }

  public function addData($data, $post, $context) {

    parent::addData($data, $post, $context);

    if(!empty($data->data['related_object'])):
      foreach($data->data['related_object'] as $key => $related_ingredient):
        $data->data['related_object'][$key] = new Recipe($related_ingredient);
      endforeach;
    endif;

  }

  public function removeData($data, $post, $context) {
    
    parent::removeData($data, $post, $context);

    //unset($data->data['title']); //Example

  }

}