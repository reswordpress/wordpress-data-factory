<?php
defined('ABSPATH') || exit;

/**
 * 
 */
class DataFactory {

  public $entities;

  public function __construct() {
    
    $this->entities = [
      'type' => ['post'], // default add support for post custom fields
      'entities' => []
    ];

  }

  public function loader() {


    foreach(glob(DATA_FACTORY_PATH . 'app/src/class/*.php') as $file) {
      include_once $file;
    }

    foreach(glob(DATA_FACTORY_PATH . 'app/controllers/*.php') as $file) {
      include_once $file;
    }
    
    foreach(glob(DATA_FACTORY_PATH . 'app/src/*.php') as $file) {
      include_once $file;
    }

    foreach(glob(DATA_FACTORY_PATH . 'app/models/*.php') as $file) {
      include_once $file;
    }

  }

  public function run() {

    $this->loader();
    $this->registerEntities();

    //$requirements = new Requirements;
    $entities = new Entities($this->entities['entities']);
    $api = new API($this->entities['type']);
    $acf = new FactoryACF;

    add_action('after_setup_theme', ['ThemeConfig', 'addThemeSupports']);

    /** use ACF to REST API plugin if fields queries are required */
    add_action('init', ['Server', 'init'], 1);
    add_action('rest_api_init', [$api, 'registerFields'], 99);

    add_action('init', [$entities, 'registerTaxonomies'], 10);
    add_action('init', [$entities, 'registerPostTypes'], 11);

    add_filter('wp_revisions_to_keep', [$this, 'limitRevisions'], 10, 2);

    add_filter('acf/init', [$acf, 'registerFields'], 11);
    add_action(
      'save_post',
      [$acf, 'calcRecipesMacros'],
      12,
      3
    );
    add_filter(
      'acf/update_value/key=field_ingredient_macros',
      [$acf, 'updateMacrosFromIngredients'],
      12,
      3
    );
    add_filter(
      'acf/load_field/key=field_recipe_macros',
      [$acf, 'disableField'],
      10,
      3
    );

  }

  public function registerEntities() {

    foreach(glob(DATA_FACTORY_PATH . 'app/entities/*.php') as $file) {
      include_once $file;
    }

    $recipe = new eRecipe();
    $ingredient = new eIngredient();

    $entities = [
      $recipe,
      $ingredient
    ];

    foreach($entities as $entity):
      $this->entities['type'][] = $entity->post_type;
      $this->entities['entities'][] = $entity;
    endforeach;

  }

  public function limitRevisions($num, $post) {

    $config = [
      'post' => 2,
      'page' => 1,
      'recipe'  => 2,
      'ingredient' => 2
    ];

    $post_type = get_post_type( $post );

    if(isset($config[$post_type]) && is_int($config[$post_type]))
      $num = $config[$post_type];

    return $num;
    
  }

}