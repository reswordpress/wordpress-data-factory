<?php
defined('ABSPATH') || exit;

/**
 * 
 */
class Requirements {

  public function __construct() {

  }

  public static function init() {


  }

  public static function ACF() {

    if(class_exists('ACF')):

    endif;

  }

  public static function ACFToRestAPI() {

    if(class_exists('ACF_To_REST_API')):

    endif;

  }
  
}