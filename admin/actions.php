<?php

add_action('admin_init', function(){

  $is_cotacao_page = (isset($_GET['page']) && $_GET['page'] === 'cotacao');
  $is_delete_all   = (isset($_POST['delete_all']) && isset($_POST['_wpnonce']));

  if (!$is_cotacao_page && !$is_delete_all) return;

  $doing_delete = ($is_cotacao_page && isset($_GET['delete_id'])) || $is_delete_all;

  if (!$doing_delete) return;

  if (!cotacao_user_can_manage()) {
    wp_die('Sem permissão para executar esta ação.', 'Acesso negado', ['response' => 403]);
  }

  global $wpdb;
  $table = $wpdb->prefix . 'cotacoes';

  // DELETE ITEM
  if ($is_cotacao_page && isset($_GET['delete_id'])) {

    if (!isset($_GET['_wpnonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['_wpnonce'])), 'delete_item')) {
      wp_die('Link de exclusão inválido ou expirado.', 'Erro de segurança', ['response' => 403]);
    }

    $id = intval($_GET['delete_id']);

    if ($id > 0) {
      $wpdb->delete($table, ['id' => $id], ['%d']);
    }

    wp_safe_redirect(admin_url('admin.php?page=cotacao&msg=deleted'));
    exit;
  }

  // DELETE ALL
  if ($is_delete_all) {

    check_admin_referer('delete_all');

    if (!isset($_POST['delete_all_confirm']) || $_POST['delete_all_confirm'] !== '1') {
      wp_safe_redirect(admin_url('admin.php?page=cotacao&msg=delete_all_denied'));
      exit;
    }

    $wpdb->query("TRUNCATE TABLE $table");
    delete_option('cotacao_dados');

    wp_safe_redirect(admin_url('admin.php?page=cotacao&msg=deleted_all'));
    exit;
  }

});
