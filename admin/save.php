<?php

add_action('admin_init', function(){

  register_setting('cotacao_group', 'cotacao_dados', [
    'sanitize_callback' => 'cotacao_save'
  ]);

});

function cotacao_save($input){

  global $wpdb;
  $table = $wpdb->prefix . 'cotacoes';

  $soja = cotacao_to_float($input['soja'] ?? 0);
  $milho = cotacao_to_float($input['milho'] ?? 0);
  $trigo_branqueador = cotacao_to_float($input['trigo_branqueador'] ?? 0);
  $trigo_pao = cotacao_to_float($input['trigo_pao'] ?? 0);
  $data = sanitize_text_field($input['data'] ?? '');

  if ($soja == 0 && $milho == 0 && $trigo_branqueador == 0 && $trigo_pao == 0) {
    return get_option('cotacao_dados');
  }

  $wpdb->insert($table, [
    'soja' => $soja,
    'milho' => $milho,
    'trigo_branqueador' => $trigo_branqueador,
    'trigo_pao' => $trigo_pao,
    'data' => $data
  ]);

  return [
    'soja' => $soja,
    'milho' => $milho,
    'trigo_branqueador' => $trigo_branqueador,
    'trigo_pao' => $trigo_pao,
    'data' => $data
  ];
}