<?php

/*========================================
=        EXCLUIR TODO HISTÓRICO         =
========================================*/
add_action('admin_post_delete_cotacao_history', function(){

  if (!current_user_can('manage_options')) {
    wp_die('Sem permissão');
  }

  if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'delete_cotacao_history')) {
    wp_die('Falha de segurança');
  }

  $dados = get_option('cotacao_dados') ?: [];
  $dados['history'] = [];

  update_option('cotacao_dados', $dados);

  wp_redirect(admin_url('admin.php?page=cotacao'));
  exit;

});


/*========================================
=     EXCLUIR ITEM ESPECÍFICO           =
========================================*/
add_action('admin_post_delete_cotacao_item', function(){

  if (!current_user_can('manage_options')) {
    wp_die('Sem permissão');
  }

  if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'delete_cotacao_item')) {
    wp_die('Falha de segurança');
  }

  $index = intval($_POST['index'] ?? -1);

  $dados = get_option('cotacao_dados') ?: [];

  if (isset($dados['history'][$index])) {

    unset($dados['history'][$index]);

    // reorganiza o array (evita buracos no índice)
    $dados['history'] = array_values($dados['history']);

    update_option('cotacao_dados', $dados);
  }

  wp_redirect(admin_url('admin.php?page=cotacao'));
  exit;

});