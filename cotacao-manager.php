<?php
/*
Plugin Name: Cotação Manager
Version: 2.1
*/

if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'includes/helpers.php';

require_once plugin_dir_path(__FILE__) . 'admin/menu.php';
require_once plugin_dir_path(__FILE__) . 'admin/db.php';
require_once plugin_dir_path(__FILE__) . 'admin/save.php';
require_once plugin_dir_path(__FILE__) . 'admin/actions.php';
require_once plugin_dir_path(__FILE__) . 'admin/page.php';

require_once plugin_dir_path(__FILE__) . 'public/shortcode.php';

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