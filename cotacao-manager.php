<?php
/*
Plugin Name: Cotação Manager
Description: Sistema de cotação com painel, histórico e shortcode
Version: 1.0
*/

if (!defined('ABSPATH')) exit;

/*INCLUDES*/
require_once plugin_dir_path(__FILE__) . 'includes/helpers.php';

require_once plugin_dir_path(__FILE__) . 'admin/menu.php';
require_once plugin_dir_path(__FILE__) . 'admin/page.php';
require_once plugin_dir_path(__FILE__) . 'admin/save.php';
require_once plugin_dir_path(__FILE__) . 'admin/history.php';

require_once plugin_dir_path(__FILE__) . 'public/shortcode.php';

/*SCRIPTS ADMIN*/
add_action('admin_enqueue_scripts', function($hook){
  if ($hook !== 'toplevel_page_cotacao') return;

  wp_enqueue_script(
    'cotacao-mask',
    plugin_dir_url(__FILE__) . 'admin/scripts.js',
    [],
    false,
    true
  );
});

/*STYLE FRONT*/
add_action('wp_enqueue_scripts', function(){
  wp_enqueue_style(
    'cotacao-style',
    plugin_dir_url(__FILE__) . 'public/style.css'
  );
});