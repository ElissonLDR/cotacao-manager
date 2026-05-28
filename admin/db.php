<?php

function cotacao_table_name(){

  global $wpdb;
  return $wpdb->prefix . 'cotacoes';

}

function cotacao_install_table(){

  global $wpdb;
  $table = cotacao_table_name();

  if ($wpdb->get_var($wpdb->prepare('SHOW TABLES LIKE %s', $table)) === $table) {
    return;
  }

  $charset = $wpdb->get_charset_collate();

  $sql = "CREATE TABLE $table (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    soja FLOAT,
    milho FLOAT,
    trigo_branqueador FLOAT,
    trigo_pao FLOAT,
    data DATE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    user_id BIGINT UNSIGNED NULL,
    user_name VARCHAR(255) NULL,
    PRIMARY KEY (id)
  ) $charset;";

  require_once ABSPATH . 'wp-admin/includes/upgrade.php';
  dbDelta($sql);

}

function cotacao_upgrade_table(){

  global $wpdb;
  $table = cotacao_table_name();

  if ($wpdb->get_var($wpdb->prepare('SHOW TABLES LIKE %s', $table)) !== $table) {
    return;
  }

  $columns = $wpdb->get_col("DESC $table", 0);

  if (!in_array('user_id', $columns, true)) {
    $wpdb->query("ALTER TABLE $table ADD COLUMN user_id BIGINT UNSIGNED NULL");
  }

  if (!in_array('user_name', $columns, true)) {
    $wpdb->query("ALTER TABLE $table ADD COLUMN user_name VARCHAR(255) NULL");
  }

}

add_action('init', function(){

  cotacao_install_table();
  cotacao_upgrade_table();

});
