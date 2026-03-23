<?php

add_shortcode('cotacao', function(){

  global $wpdb;
  $table = $wpdb->prefix . 'cotacoes';

  $row = $wpdb->get_row("SELECT * FROM $table ORDER BY id DESC LIMIT 1");

  if (!$row) return '';

  ob_start();
?>

<div class="cotacao-box">
  
    <div class="cotacao-header">
      <div class="cotacao-title">
        <img src="https://v4amaral.com.br/vicato/wp-content/uploads/2026/03/Icone-trigo.svg" class="cotacao-icon">
        <span>COTAÇÕES AGRÍCOLAS</span>
      </div>
      <div class="cotacao-sub">
        Cotações praticadas pela Vicato - <?php echo date('d/m/Y'); ?>
      </div>
    </div>
  
    <div class="cotacao-list">
      <div class="cotacao-item">
        <span>Soja</span>
        <strong>R$ <?php echo number_format($row->soja, 2, ',', '.'); ?></strong>
      </div>
  
      <div class="cotacao-item">
        <span>Trigo Branqueador</span>
        <strong>R$ <?php echo number_format($row->trigo_branqueador, 2, ',', '.'); ?></strong>
      </div>
  
      <div class="cotacao-item">
        <span>Trigo Pão</span>
        <strong>R$ <?php echo number_format($row->trigo_pao, 2, ',', '.'); ?></strong>
      </div>
  
      <div class="cotacao-item">
        <span>Milho</span>
        <strong>R$ <?php echo number_format($row->milho, 2, ',', '.'); ?></strong>
      </div>
    </div>
  
  </div>

<?php
  return ob_get_clean();
});