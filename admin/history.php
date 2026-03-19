<?php

add_action('admin_post_delete_cotacao_history', function(){

  // Permissão
  if (!current_user_can('manage_options')) {
    wp_die('Sem permissão');
  }

  // Nonce (segurança)
  if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'delete_cotacao_history')) {
    wp_die('Falha de segurança');
  }

  $dados = get_option('cotacao_dados') ?: [];

  $dados['history'] = [];

  update_option('cotacao_dados', $dados);

  wp_redirect(admin_url('admin.php?page=cotacao'));
  exit;

});