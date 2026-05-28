<?php

add_action('init', function(){

  global $wpdb;
  $table = $wpdb->prefix . 'cotacoes';

  if ($wpdb->get_var("SHOW TABLES LIKE '$table'") === $table) return;

  $charset = $wpdb->get_charset_collate();

  $sql = "CREATE TABLE $table (
    id BIGINT UNSIGNED AUTO_INCREMENT,
    soja FLOAT,
    milho FLOAT,
    trigo_branqueador FLOAT,
    trigo_pao FLOAT,
    data DATE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
  ) $charset;";

  require_once ABSPATH . 'wp-admin/includes/upgrade.php';
  dbDelta($sql);

});