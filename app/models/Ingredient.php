<?php
defined('ABSPATH') || exit;

/**
 * 
 */
class Ingredient {

  public $title;

  public $id;

  public $slug;

  public $image;

  public $gallery;

  public $description;

  public $unit;

  public $macros;

  public $post_type;

  public function __construct($ingredient) {

    $this->post_type = 'ingredient';

    $this->id = $ingredient->ID;
    $this->title = $ingredient->post_title;
    $this->slug = $ingredient->post_name;
    $this->image = null;

    $fields = get_fields($this->id);

    $this->gallery = $fields['gallery'] ?? [];
    $this->description = $fields['description'] ?? [];
    $this->unit = $fields['unit'] ?? [];
    $this->macros = $fields['macros'] ?? [];

    $this->image_url = get_the_post_thumbnail_url($this->id);
    $this->excerpt = $ingredient->post_excerpt;

    $this->next_post = get_next_post();
    $this->previous_post = get_previous_post();

  }

  public static function parseRecipeItem($_ingredient) {

    $ingredient = new Ingredient($_ingredient['ingredient']);
    $ingredient->quantity = $_ingredient['quantity'];
    $ingredient->unit = $_ingredient['unit'];

    return $ingredient;

  }

  public static function getMacros($_ingredient) {

    $ingredient = new Ingredient($_ingredient);
    
    return $ingredient->macros;

  }

  public static function parseMacros($macros, $total) {

    foreach($macros as $key => $macro):
      $total[$key] += $macro;
    endforeach;

    return $total;

  }

}