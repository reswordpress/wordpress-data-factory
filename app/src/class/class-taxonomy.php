<?php
/**
 * Taxonomies class.
 * 
 * Register default taxonomies settings.
 * 
 * @version 0.1.0
 */
class Taxonomy {

  public $name;
  public $post_type;
  public $args;
  public $labels;

  public function __construct($name, $post_type, $singular, $plural, $labels, $args) {

    $this->name = $name;
    $this->post_type = $post_type;
    $this->type_name = ucfirst($this->post_type);
    
    $this->labels = $this->getLabels($this->type_name, $singular, $plural);
    $this->args = $this->getArgs($plural);

    if(!empty($labels)):
      $this->labels = array_merge($this->labels, $labels);
    endif;

    if(!empty($args)):
      $this->args = array_merge($this->args, $args);
    endif;
  
  }

  public function getLabels($type, $singular, $plural) {

    $labels = [
      'name'                        => "{$type} {$plural}",
      'singular_name'               => "{$type} {$singular}",
      'search_items'                => "Search {$singular}",
      'popular_items'               => "Popular {$plural}",
      'all_items'                   => "All {$plural}",
      'parent_item'                 => null,
      'parent_item_colon'           => null,
      'edit_item'                   => "Edit {$singular}",
      'update_item'                 => "Update {$singular}",
      'add_new_item'                => "Add New {$singular}",
      'new_item_name'               => "New {$singular} Name",
      'separate_items_with_commas'  => 'Separate'  . strtolower($plural) . ' with commas',
      'add_or_remove_items'         => 'Add or remove ' . strtolower($plural),
      'choose_from_most_used'       => 'Choose from the most used ' . strtolower($plural),
      'not_found'                   => 'No ' . strtolower($plural) . ' found.',
      'menu_name'                   => "{$type} {$plural}"
    ];

    return $labels;
  }

  public function getArgs($plural) {

    $args = [
      'hierarchical'                => false,
      'labels'                      => [],
      'show_ui'                     => true,
      'show_admin_column'           => true,
      'update_count_callback'       => '_update_post_term_count',
      'query_var'                   => true,
      'rewrite'                     => false
    ];

    return $args;

  }

  public function register() {

    $this->args['labels'] = $this->labels;

    register_taxonomy($this->name, $this->post_type, $this->args);

  }

}