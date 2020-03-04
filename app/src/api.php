<?php
defined('ABSPATH') || exit;

/**
 * 
 */
class API {

  public $post_types;

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

    if(is_admin()) return $data;

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

    return $data;
    
  }

}