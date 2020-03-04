<?php
defined('ABSPATH') || exit;

/**
 * 
 */
class RecipeRESTController extends RESTController {

  public function __construct() {

    parent::__construct();

    $this->post_type = 'recipe';
    
  }

  public function addData($data, $post, $context) {

    parent::addData($data, $post, $context);

    if(!empty($data->data['ingredients'])):
      foreach($data->data['ingredients'] as $key => $ingredient):
        $data->data['ingredients'][$key] = Ingredient::parseRecipeItem($ingredient);
      endforeach;
    endif;

    if(!empty($data->data['procedures'])):
      foreach($data->data['procedures'] as $key => $instruction):
        $data->data['procedures'][$key] = $instruction['instruction'];
      endforeach;
    endif;

    if(!empty($data->data['related_object'])):
      foreach($data->data['related_object'] as $key => $related_ingredient):
        $data->data['related_object'][$key] = new Ingredient($related_ingredient);
      endforeach;
    endif;

  }

  public function removeData($data, $post, $context) {
    
    parent::removeData($data, $post, $context);

    //unset($data->data['title']); //Example

  }

}