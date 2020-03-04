<?php
defined('ABSPATH') || exit;

/**
 * Plugin Name: Wordpress Data Factory
 * Plugin URI:      
 * Description:     
 * Author: Jim Joligeon
 * Author URI:      
 * Text Domain: WordpressDataFactory
 * Version: 1.0.0
 *
 * @package WordpressApp
 */

/**
 * Define path constants.
 */
if(!defined('DATA_FACTORY_PATH')):
  define('DATA_FACTORY_PATH', plugin_dir_path(__FILE__));
endif;

if(!defined('DATA_FACTORY_URI')):
  define('DATA_FACTORY_URI', plugin_dir_url(__FILE__));
endif;

require_once DATA_FACTORY_PATH . 'app/factory.php';

if(class_exists('DataFactory')):
  $App = new DataFactory();
  $App->run();
endif;