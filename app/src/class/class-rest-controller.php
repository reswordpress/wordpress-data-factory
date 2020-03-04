<?php
defined('ABSPATH') || exit;

/**
 * 
 */
class RESTController {

  public $data;

  public $post_type;

  public function __construct() {

    $this->data = [];

  }

  public function prepare($data, $post, $context) {

    $type = get_post_type($post->ID);

    if($this->post_type !== $type) return;

    $this->addData($data, $post, $context);

    /** add data before init */
    if(!empty($this->data)):
      foreach($this->data as $key => $newValue):
        $data->data[$key] = $newValue;
      endforeach;
    endif;


    $this->removeData($data, $post, $context);

  }

  /**
   * 
   * Rewrite object keys to avoid doing it on the client side.
   */
  public function addData($data, $post, $context) {

    $post_id = $post->ID;
    // modify
    $data->data['title'] = $post->post_title;
    $data->data['author'] = get_the_author_meta('display_name', $data->data['author']);
    // add
    $next_post = new Recipe(get_next_post());
    $previous_post = new Recipe(get_previous_post());

    $data->data['next_post'] = $next_post;
    $data->data['previous_post'] = $previous_post;

    if($data->data['featured_media']):
      $data->data['image_url'] = get_the_post_thumbnail_url($post_id);
    endif;

    /** parse ACF to REST API data to post data level - avoid parsing on front */
    if($data->data['acf']):
      foreach($data->data['acf'] as $key => $field):
        $data->data[$key] = $field;
      endforeach;
    endif;

  }

  public function removeData($data, $post, $context) {

    $_keys = [
      'content',
      'status',
      'guid',
      'link',
      'meta',
      'modified',
      'modified_gmt',
      'template',
      '_links',
      'featured_media',
      'acf'
    ];

    foreach($_keys as $_key):
      unset($data->data[$_key]);
    endforeach;

  }

}