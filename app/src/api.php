<?php
defined('ABSPATH') || exit;

/**
 * 
 */
class API {

  public $post_types;
  public $controller;

  public function __construct($post_types = []) {

    $this->post_types = $post_types;

  }

  public function registerFields() {

    if(is_admin()) return;
    
    if(empty($this->post_types)) return;

    foreach($this->post_types as $post_type):
      add_filter('rest_prepare_' . $post_type, [$this, 'prepareAPI'], 10, 3);
    endforeach;

  }

  public function prepareAPI($data, $post, $request) {

    // Return if in admin to avoid issue with core and other plugins.
    if(is_admin()) return $data;

    $post_type = get_post_type($post);
    $controller_name = ucfirst($post_type) . 'RESTController';

    if(!class_exists($controller_name)) return $data;

    $this->controller = new $controller_name;

    $this->controller->prepare($data, $post, $request);

/*  ACF Fields...
    $response_data = $data->get_data();

    if($request['context'] !== 'view' || is_wp_error($data)):
      return $data;
    endif;

    $fields = get_fields($post->ID);

    if(!$fields || empty($fields)) return $data;

    foreach($fields as $field_key => $field):
      $response_data[$field_key] = $field;
    endforeach;

    $data->set_data($response_data);
*/
    return $data;
    
  }

}