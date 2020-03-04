<?php
defined('ABSPATH') || exit;

/**
 * 
 */
class Server {

  public function __construct() {

  }

  public static function init() {

    self::addHeaders();

  }

  public static function addHeaders() {

    header("Access-Control-Allow-Origin: *");
  
  }

}