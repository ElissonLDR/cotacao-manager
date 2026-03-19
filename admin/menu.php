<?php

add_action('admin_menu', function() {
  add_menu_page(
    'Cotação',
    'Cotação',
    'manage_options',
    'cotacao',
    'cotacao_page_html',
    'dashicons-chart-line',
    25
  );
});