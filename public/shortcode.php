<?php

add_shortcode('cotacao', function(){

  global $wpdb;
  $table = $wpdb->prefix . 'cotacoes';

  $row = $wpdb->get_row("SELECT * FROM $table ORDER BY id DESC LIMIT 1");

  if (!$row) return '';

  ob_start();
?>

<div class="cotacao-box">
  <h3>Cotações <?php echo date('d/m/Y', strtotime($row->data)); ?></h3>

  <div>Soja: R$ <?php echo number_format($row->soja,2,',','.'); ?></div>
  <div>Trigo Branqueador: R$ <?php echo number_format($row->trigo_branqueador,2,',','.'); ?></div>
  <div>Trigo Pão: R$ <?php echo number_format($row->trigo_pao,2,',','.'); ?></div>
  <div>Milho: R$ <?php echo number_format($row->milho,2,',','.'); ?></div>
</div>

<?php
  return ob_get_clean();
});