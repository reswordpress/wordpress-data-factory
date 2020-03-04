<?php
defined('ABSPATH') || exit;

/**
 * 
 */
class eRecipe {

  public $post_type;
  public $taxonomies;

  public function __construct() {

    $this->post_type = 'recipe';
    $this->taxonomies = [];

  }

  public function init() {

    add_action('init', [$this, 'registerTaxonomies'], 10);
    add_action('init', [$this, 'registerPostType'], 11);

  }

  public function registerTaxonomies() {

    $this->registerCategories();
    $this->registerTags();

    if(!$this->taxonomies || empty($this->taxonomies)) return;

  }

  public function registerAPI() {


  }

  /** args for registration */

  // taxonomies
  public function registerCategories() {

    $singular = 'Category';
    $plural = 'Categories';
    $name = $this->post_type . strtolower($plural); // post_taxonomies

    $labels = [];
    $args = [];

    $recipesTags = new Taxonomy($name, $this->post_type, $singular, $plural, $labels, $args);
    $recipesTags->register();

    $this->taxonomies[] = $name;   

  }

  public function registerTags() {

    $singular = 'Tag';
    $plural = 'Tags';
    $type = ucfirst($this->post_type);
    $name = $this->post_type . strtolower($plural); // post_taxonomies

    $labels = [];
    $args = [];

    $recipesTags = new Taxonomy($name, $this->post_type, $singular, $plural, $labels, $args);
    $recipesTags->register(); 

    $this->taxonomies[] = $name;

  }

  //post type
  public function registerPostType() {

    $name = $this->post_type;
    $singular = 'Recipe';
    $plural = 'Recipes';

    $taxonomies = $this->taxonomies;
    $labels = [];
    $args = [];

    $recipe = new PostType($name, $singular, $plural, $taxonomies, $labels, $args);
    $recipe->register();
    
  }

}