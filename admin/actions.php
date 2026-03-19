<?php

add_action('admin_init', function(){

  if (!isset($_GET['page']) || $_GET['page'] !== 'cotacao') return;

  global $wpdb;
  $table = $wpdb->prefix . 'cotacoes';

  // DELETE ITEM
  if (isset($_GET['delete_id']) && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'delete_item')) {

    $id = intval($_GET['delete_id']);
    $wpdb->delete($table, ['id' => $id]);

    wp_redirect(admin_url('admin.php?page=cotacao&msg=deleted'));
    exit;
  }

  // DELETE ALL
  if (isset($_POST['delete_all']) && check_admin_referer('delete_all')) {

    $wpdb->query("TRUNCATE TABLE $table");

    wp_redirect(admin_url('admin.php?page=cotacao&msg=deleted_all'));
    exit;
  }

});