<?php
defined('ABSPATH') || exit;

/**
 * 
 */
class Recipe {

  public $title;

  public $id;

  public $slug;

  public $image;

  public $gallery;

  public $description;

  public $ingredients;

  public $procedures;

  public $post_type;

  public $macros;

  public function __construct($recipe) {

    $this->post_type = 'recipe';

    $this->id = $recipe->ID;
    $this->title = $recipe->post_title;
    $this->slug = $recipe->post_name;
    $this->image = null;

    $fields = get_fields($this->id);

    $this->gallery = $fields['gallery'];
    $this->description = $fields['description'];
    $this->procedures = $fields['procedures'];
    $this->ingredients = $fields['ingredients'];
    $this->macros = $fields['macros'];

    $this->next_post = get_next_post();
    $this->previous_post = get_previous_post();

  }

  public static function sumMacros($ingredients) {

    $calories = 0;
    $carbs = 0;
    $fats = 0;
    $proteins = 0;

    $macros = [
      'calories' => $calories,
      'carbs' => $carbs,
      'fats' => $fats,
      'proteins' => $proteins
    ];

    foreach($ingredients as $_ingredient):
      $ingredient = get_post($_ingredient['ingredient']);
      $item_macros = Ingredient::getMacros($ingredient);

      $macros = Ingredient::parseMacros($item_macros, $macros);
    endforeach;

    return $macros;

  }
  
}