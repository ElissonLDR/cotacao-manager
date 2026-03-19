<?php

add_shortcode('cotacao', function(){

  $dados = get_option('cotacao_dados');

  ob_start();
?>

<div class="cotacao-box">

  <h3>Cotações <?php echo !empty($dados['data']) ? date('d/m/Y', strtotime($dados['data'])) : ''; ?></h3>

  <div class="cotacao-item"><span>Soja</span><strong>R$ <?php echo number_format($dados['soja'] ?? 0,2,',','.'); ?></strong></div>
  <div class="cotacao-item"><span>Trigo Branqueador</span><strong>R$ <?php echo number_format($dados['trigo_branqueador'] ?? 0,2,',','.'); ?></strong></div>
  <div class="cotacao-item"><span>Trigo Pão</span><strong>R$ <?php echo number_format($dados['trigo_pao'] ?? 0,2,',','.'); ?></strong></div>
  <div class="cotacao-item"><span>Milho</span><strong>R$ <?php echo number_format($dados['milho'] ?? 0,2,',','.'); ?></strong></div>

</div>

<?php
  return ob_get_clean();
});