<?php

add_action('admin_init', function() {

  register_setting('cotacao_group', 'cotacao_dados', [
    'sanitize_callback' => 'cotacao_sanitize'
  ]);

});

function cotacao_sanitize($input){

  $old = get_option('cotacao_dados') ?: [];

  $novo = [
    'soja' => cotacao_to_float($input['soja'] ?? 0),
    'milho' => cotacao_to_float($input['milho'] ?? 0),
    'trigo_branqueador' => cotacao_to_float($input['trigo_branqueador'] ?? 0),
    'trigo_pao' => cotacao_to_float($input['trigo_pao'] ?? 0),
    'data' => sanitize_text_field($input['data'] ?? ''),
    'history' => $old['history'] ?? []
  ];

  // NÃO salva se tudo for zero
  if (
    $novo['soja'] == 0 &&
    $novo['milho'] == 0 &&
    $novo['trigo_branqueador'] == 0 &&
    $novo['trigo_pao'] == 0
  ) {
    return $old;
  }

  // SALVA HISTÓRICO
  $novo['history'][] = [
    'date' => current_time('mysql'),
    'soja' => $novo['soja'],
    'milho' => $novo['milho'],
    'trigo_branqueador' => $novo['trigo_branqueador'],
    'trigo_pao' => $novo['trigo_pao'],
  ];

  return $novo;
}