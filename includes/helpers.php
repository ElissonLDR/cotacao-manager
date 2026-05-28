<?php

if (!function_exists('cotacao_to_float')) {

  function cotacao_to_float($v){

    $v = str_replace(['R$', ' ', '.'], '', (string) $v);
    $v = str_replace(',', '.', $v);

    return is_numeric($v) ? (float) $v : 0;

  }

}

if (!function_exists('cotacao_format_money')) {

  function cotacao_format_money($value){

    if ($value === '' || $value === null) return '';

    if (!is_numeric($value)) return '';

    return 'R$ ' . number_format((float) $value, 2, ',', '.');

  }

}

if (!function_exists('cotacao_get_author_name')) {

  function cotacao_get_author_name($row){

    if (!empty($row->user_name)) {
      return $row->user_name;
    }

    if (!empty($row->user_id)) {
      $user = get_userdata((int) $row->user_id);
      if ($user) {
        return $user->display_name ?: $user->user_login;
      }
    }

    return '—';

  }

}

if (!function_exists('cotacao_current_author')) {

  function cotacao_current_author(){

    $user_id = get_current_user_id();

    if (!$user_id) {
      return ['user_id' => null, 'user_name' => ''];
    }

    $user = get_userdata($user_id);

    if (!$user) {
      return ['user_id' => null, 'user_name' => ''];
    }

    return [
      'user_id'   => $user_id,
      'user_name' => $user->display_name ?: $user->user_login,
    ];

  }

}