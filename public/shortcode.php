<?php

add_shortcode('cotacao', function(){

  $dados = get_option('cotacao_dados') ?: [];

  $soja   = $dados['soja'] ?? 0;
  $milho  = $dados['milho'] ?? 0;
  $trigo  = $dados['trigo'] ?? 0;
  $trigo2 = $dados['trigo2'] ?? 0;
  $data   = $dados['data'] ?? '';

  ob_start();
?>

<div class="cotacao-box">

  <h3>
    Cotações 
    <?php echo $data ? esc_html(date('d/m/Y', strtotime($data))) : ''; ?>
  </h3>

  <div class="cotacao-item">
    <span>Soja</span>
    <strong>R$ <?php echo esc_html(number_format($soja, 2, ',', '.')); ?></strong>
  </div>

  <div class="cotacao-item">
    <span>Trigo B.</span>
    <strong>R$ <?php echo esc_html(number_format($trigo, 2, ',', '.')); ?></strong>
  </div>

  <div class="cotacao-item">
    <span>Trigo P.</span>
    <strong>R$ <?php echo esc_html(number_format($trigo2, 2, ',', '.')); ?></strong>
  </div>

  <div class="cotacao-item">
    <span>Milho</span>
    <strong>R$ <?php echo esc_html(number_format($milho, 2, ',', '.')); ?></strong>
  </div>

</div>

<?php
  return ob_get_clean();
});