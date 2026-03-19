<?php

function cotacao_to_float($v){
  $v = str_replace(['R$', ' ', '.'], '', (string)$v);
  $v = str_replace(',', '.', $v);
  return is_numeric($v) ? (float)$v : 0;
}