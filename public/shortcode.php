<?php

add_shortcode('cotacao', function(){

  $dados = get_option('cotacao_dados') ?: [];

  ob_start();
?>

<div class="cotacao-box">

  <h3>
    Cotações <?php echo !empty($dados['data']) ? esc_html(date('d/m/Y', strtotime($dados['data']))) : ''; ?>
  </h3>

  <div class="cotacao-item"><span>Soja</span><strong>R$ <?php echo esc_html(number_format($dados['soja'] ?? 0,2,',','.')); ?></strong></div>
  <div class="cotacao-item"><span>Trigo B.</span><strong>R$ <?php echo esc_html(number_format($dados['trigo'] ?? 0,2,',','.')); ?></strong></div>
  <div class="cotacao-item"><span>Trigo P.</span><strong>R$ <?php echo esc_html(number_format($dados['trigo2'] ?? 0,2,',','.')); ?></strong></div>
  <div class="cotacao-item"><span>Milho</span><strong>R$ <?php echo esc_html(number_format($dados['milho'] ?? 0,2,',','.')); ?></strong></div>

</div>

<?php
  return ob_get_clean();
});