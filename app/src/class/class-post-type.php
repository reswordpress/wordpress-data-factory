<?php
defined('ABSPATH') || exit;

/**
 * Post Types class.
 * 
 * Register defaut custom post types settings.
 * 
 * @version 0.1.0
 */
class PostType {

  public $name;
  public $args;
  public $labels;
  public $taxonomies;

  public function __construct($name, $singular, $plural, $taxonomies, $labels, $args) {

    $this->name = $name;
    $this->taxonomies = $taxonomies ?? [];

    $this->labels = $this->getLabels($singular, $plural);
    $this->args = $this->getArgs($this->name, $this->taxonomies);

    if(!empty($labels)):
      $this->labels = array_merge($this->labels, $labels);
    endif;

    if(!empty($args)):
      $this->args = array_merge($this->args, $args);
    endif;
  
  }

  public function getLabels($singular, $plural) {

    $labels = [
      'name'                  => $plural,
      'singular_name'         => $singular,
      'menu_name'             => $plural,
      'parent_item_colon'     => "Parent {$plural}",
      'all_items'             => "All {$plural}",
      'view_item'             => "View {$singular}",
      'add_new_item'          => "Add New {$singular}",
      'add_new'               => 'Add New',
      'edit_item'             => "Edit {$singular}",
      'update_item'           => "Update {$singular}",
      'search_items'          => "Search {$singular}",
      'not_found'             => 'Not Found',
      'not_found_in_trash'    => 'Not found in Trash',
    ];

    return $labels;
  }

  public function getArgs($name, $taxonomies) {

    $args = [
      'label'                 => $name,
       'description'          => '',
      'labels'                => [],
      // Features this CPT supports in Post Editor
      'supports'              => [
        'title',
        //'editor',
        //'excerpt',
        //'comments',
        'author',
        'thumbnail',
        'custom-fields',
        'excerpt'
      ],
      'taxonomies'             => $taxonomies,
      'hierarchical'           => false,
      'public'                 => true,
      'show_ui'                => true,
      'show_in_menu'           => true,
      'show_in_nav_menus'      => true,
      'show_in_admin_bar'      => true,
      'rest_base'              => $name,
      'show_in_rest'           => true,
      //'supports'             => ['editor'], // gutenberg
      'menu_position'          => 4,
      'can_export'             => true,
      'has_archive'            => true,
      'exclude_from_search'    => false, // ! excluded from search
      'publicly_queryable'     => true,
      'capability_type'        => 'post',
    ];

    return $args;

  }

  public function register() {

    $this->args['labels'] = $this->labels;

    register_post_type($this->name, $this->args);

  }

}