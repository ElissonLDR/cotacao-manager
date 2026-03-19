<?php

add_action('admin_post_delete_cotacao_history', function(){

  if (!current_user_can('manage_options')) return;

  $dados = get_option('cotacao_dados');
  $dados['history'] = [];

  update_option('cotacao_dados', $dados);

  wp_redirect(admin_url('admin.php?page=cotacao'));
  exit;
});
