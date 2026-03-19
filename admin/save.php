<?php

add_action('admin_init', 'cotacao_register_settings');

function cotacao_register_settings() {

  register_setting('cotacao_group', 'cotacao_dados', [
    'sanitize_callback' => 'cotacao_sanitize'
  ]);

}


function cotacao_sanitize($input){

  $old = get_option('cotacao_dados') ?: [];

  $novo = [
    'soja'   => cotacao_to_float($input['soja'] ?? 0),
    'milho'  => cotacao_to_float($input['milho'] ?? 0),
    'trigo'  => cotacao_to_float($input['trigo'] ?? 0),
    'trigo2' => cotacao_to_float($input['trigo2'] ?? 0),
    'data'   => sanitize_text_field($input['data'] ?? ''),
    'history'=> $old['history'] ?? []
  ];

  // Salva histórico apenas se mudou algo
  if (
    empty($old) ||
    $old['soja'] != $novo['soja'] ||
    $old['milho'] != $novo['milho'] ||
    $old['trigo'] != $novo['trigo'] ||
    $old['trigo2'] != $novo['trigo2']
  ) {

    $novo['history'][] = [
      'date'   => current_time('mysql'),
      'soja'   => $novo['soja'],
      'milho'  => $novo['milho'],
      'trigo'  => $novo['trigo'],
      'trigo2' => $novo['trigo2'],
    ];

  }

  return $novo;

}