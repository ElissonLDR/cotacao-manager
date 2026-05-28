<?php

add_action('admin_init', function(){

  register_setting('cotacao_group', 'cotacao_dados', [
    'sanitize_callback' => 'cotacao_save'
  ]);

});

function cotacao_save($input){

  if (!cotacao_user_can_manage()) {
    return get_option('cotacao_dados');
  }

  global $wpdb;
  $table = $wpdb->prefix . 'cotacoes';

  $soja = cotacao_to_float($input['soja'] ?? 0);
  $milho = cotacao_to_float($input['milho'] ?? 0);
  $trigo_branqueador = cotacao_to_float($input['trigo_branqueador'] ?? 0);
  $trigo_pao = cotacao_to_float($input['trigo_pao'] ?? 0);
  $data = sanitize_text_field($input['data'] ?? '');
  if ($data === '') {
    $data = current_time('Y-m-d');
  }

  if ($soja == 0 && $milho == 0 && $trigo_branqueador == 0 && $trigo_pao == 0) {
    return get_option('cotacao_dados');
  }

  $author = cotacao_current_author();

  $wpdb->insert($table, [
    'soja' => $soja,
    'milho' => $milho,
    'trigo_branqueador' => $trigo_branqueador,
    'trigo_pao' => $trigo_pao,
    'data' => $data,
    'user_id' => $author['user_id'],
    'user_name' => $author['user_name'],
  ]);

  return [
    'soja' => $soja,
    'milho' => $milho,
    'trigo_branqueador' => $trigo_branqueador,
    'trigo_pao' => $trigo_pao,
    'data' => current_time('Y-m-d'),
  ];
}