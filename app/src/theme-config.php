<?php
defined('ABSPATH') || exit;

/**
 * Theme config.
 */
class ThemeConfig {

  public function __construct() {

  }

  public function init() {

  }

  public static function addThemeSupports() {

    //add_theme_support($name);
    add_theme_support('theme-support');
    add_theme_support( 'automatic-feed-links' );
    //add_theme_support( 'title-tag' ); //?? bug -> if no title found
    add_theme_support( 'post-thumbnails' );
    add_theme_support(
      'html5',
      array(
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
      )
    );
    //Enable support for Post Formats.
    add_theme_support(
      'post-formats',
      array(
        'aside',
        'image',
        'video',
        'quote',
        'link',
        'gallery',
        'audio'
      )
    );
    add_theme_support( 'menus' );

  }

}