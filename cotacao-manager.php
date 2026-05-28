<?php
/*
	Plugin Name: Cotação Manager
	Description: Gerencie cotações de soja, milho e trigo com painel administrativo, histórico paginado em tabela própria e exibição via shortcode.
	Version: 2.3
	Author: Elisson Rodrigues
 */

if (!defined('ABSPATH')) exit;

require_once plugin_dir_path(__FILE__) . 'includes/helpers.php';
require_once plugin_dir_path(__FILE__) . 'includes/capabilities.php';

register_activation_hook(__FILE__, 'cotacao_grant_default_caps');

require_once plugin_dir_path(__FILE__) . 'admin/menu.php';
require_once plugin_dir_path(__FILE__) . 'admin/db.php';
require_once plugin_dir_path(__FILE__) . 'admin/save.php';
require_once plugin_dir_path(__FILE__) . 'admin/actions.php';
require_once plugin_dir_path(__FILE__) . 'admin/page.php';

require_once plugin_dir_path(__FILE__) . 'public/shortcode.php';

add_action('admin_enqueue_scripts', function($hook){
  if ($hook !== 'toplevel_page_cotacao') return;

  $script_path = plugin_dir_path(__FILE__) . 'admin/scripts.js';

  wp_enqueue_script(
    'cotacao-mask',
    plugin_dir_url(__FILE__) . 'admin/scripts.js',
    [],
    file_exists($script_path) ? (string) filemtime($script_path) : '2.1',
    true
  );
});