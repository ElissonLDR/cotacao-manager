<?php

add_action('admin_menu', 'cotacao_add_admin_menu');

function cotacao_add_admin_menu() {

  add_menu_page(
    'Cotação',
    'Cotação',
    COTACAO_CAP,
    'cotacao',
    'cotacao_page_html',
    'dashicons-chart-line',
    25
  );

}