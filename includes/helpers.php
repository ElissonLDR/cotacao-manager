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