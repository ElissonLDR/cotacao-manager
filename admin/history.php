<?php

add_action('admin_init', function(){

  if (!isset($_GET['cotacao_action'])) return;

  if (!current_user_can('manage_options')) {
    wp_die('Sem permissão');
  }

  $dados = get_option('cotacao_dados') ?: [];
  $action = sanitize_text_field($_GET['cotacao_action']);
  $index  = isset($_GET['index']) ? intval($_GET['index']) : null;

  // EXCLUIR TUDO
  if ($action === 'delete_all') {

    $antes = $dados['history'] ?? [];

    $dados['history'] = [];

    update_option('cotacao_dados', $dados);

    $depois = get_option('cotacao_dados')['history'] ?? [];

    if (empty($antes)) {
      error_log('DELETE ALL: nada para excluir');
      wp_redirect(admin_url('admin.php?page=cotacao&msg=empty'));
    } elseif (empty($depois)) {
      error_log('DELETE ALL: sucesso');
      wp_redirect(admin_url('admin.php?page=cotacao&msg=deleted_all'));
    } else {
      error_log('DELETE ALL: falhou');
      wp_redirect(admin_url('admin.php?page=cotacao&msg=error'));
    }

    exit;
  }

  // EXCLUIR ITEM
  if ($action === 'delete_item') {

    if ($index === null) {
      error_log('DELETE ITEM: index não enviado');
      wp_redirect(admin_url('admin.php?page=cotacao&msg=error'));
      exit;
    }

    if (!isset($dados['history'][$index])) {
      error_log('DELETE ITEM: index não existe - ' . $index);
      wp_redirect(admin_url('admin.php?page=cotacao&msg=not_found'));
      exit;
    }

    $antes = $dados['history'];

    unset($dados['history'][$index]);
    $dados['history'] = array_values($dados['history']);

    update_option('cotacao_dados', $dados);

    $depois = get_option('cotacao_dados')['history'] ?? [];

    if (count($depois) < count($antes)) {
      error_log('DELETE ITEM: sucesso index ' . $index);
      wp_redirect(admin_url('admin.php?page=cotacao&msg=deleted'));
    } else {
      error_log('DELETE ITEM: falhou index ' . $index);
      wp_redirect(admin_url('admin.php?page=cotacao&msg=error'));
    }

    exit;
  }

});