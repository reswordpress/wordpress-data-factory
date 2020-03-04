<?php
defined('ABSPATH') || exit;

/**
 * 
 */
class FactoryACF {

  public function __construct() {


  }

  public function disableField( $field ) {
    $field['disabled'] = 1;

    return $field;
  }

  public function registerFields(){

    /*
    foreach(glob(DATA_FACTORY_PATH . 'app/components/parts/*.php') as $file) {
      include_once $file;
    }
    */
    foreach(glob(DATA_FACTORY_PATH . 'app/components/*.php') as $file) {
      include_once $file;
    }

  }

  public function calcRecipesMacros($post_id, $post, $update ) {

    $type = get_post_type($post_id);

    if($type !== 'recipe') return;

    $macros_field = 'field_recipe_macros';
    $recipes_field = 'field_ingredient_recipes';
    $rel_field = 'field_recipe_rel';

    $default = [
      'calories' => 0,
      'carbs' => 0,
      'fats' => 0,
      'proteins' => 0
    ];

    $fields = get_fields($post_id);

    $ingredients = $fields['ingredients'] ?? [];
    
    if(empty($ingredients)): 
      update_field($macros_field, $default, $post_id);

      return;
    endif;

    $macros = Recipe::sumMacros($ingredients);

    update_field($macros_field, $macros, $post_id);

    $ing = [];

    foreach($ingredients as $ingredient):
      $ing[] = $ingredient['ingredient'];
    endforeach;

    update_field($rel_field, $ing, $post_id);

  }

  public function updateMacrosFromIngredients($value, $post_id, $field) {
    
    $type = get_post_type($post_id);

    if($type !== 'ingredient') return $value;

    $recipes = get_field('related_object', $post_id);

    if(empty($recipes)) return $value;

    foreach($recipes as $recipe):
      wp_update_post($recipe);
    endforeach;

    return $value;

  }

}