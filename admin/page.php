<?php

function cotacao_page_html(){

  $dados = get_option('cotacao_dados');

  $soja   = $dados['soja'] ?? '';
  $milho  = $dados['milho'] ?? '';
  $trigo  = $dados['trigo'] ?? '';
  $trigo2 = $dados['trigo2'] ?? '';
  $data   = $dados['data'] ?? '';
  $history= $dados['history'] ?? [];
?>

<div class="wrap">
  <h1>Cotação</h1>

  <form method="post" action="options.php">
    <?php settings_fields('cotacao_group'); ?>

    <table class="form-table">
      <tr><th>Soja</th><td><input class="money" name="cotacao_dados[soja]" value="<?php echo esc_attr($soja); ?>"></td></tr>
      <tr><th>Milho</th><td><input class="money" name="cotacao_dados[milho]" value="<?php echo esc_attr($milho); ?>"></td></tr>
      <tr><th>Trigo B.</th><td><input class="money" name="cotacao_dados[trigo]" value="<?php echo esc_attr($trigo); ?>"></td></tr>
      <tr><th>Trigo P.</th><td><input class="money" name="cotacao_dados[trigo2]" value="<?php echo esc_attr($trigo2); ?>"></td></tr>
      <tr><th>Data</th><td><input type="date" name="cotacao_dados[data]" value="<?php echo esc_attr($data); ?>"></td></tr>
    </table>

    <?php submit_button(); ?>
  </form>

  <h2>Histórico</h2>

  <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
    <input type="hidden" name="action" value="delete_cotacao_history">
    <?php submit_button('Excluir histórico', 'delete'); ?>
  </form>

  <table class="widefat">
    <thead><tr><th>Data</th><th>Soja</th><th>Milho</th><th>Trigo</th><th>Trigo2</th></tr></thead>
    <tbody>
      <?php if ($history): foreach(array_reverse($history) as $h): ?>
        <tr>
          <td><?php echo date('d/m/Y H:i', strtotime($h['date'])); ?></td>
          <td>R$ <?php echo number_format($h['soja'],2,',','.'); ?></td>
          <td>R$ <?php echo number_format($h['milho'],2,',','.'); ?></td>
          <td>R$ <?php echo number_format($h['trigo'],2,',','.'); ?></td>
          <td>R$ <?php echo number_format($h['trigo2'],2,',','.'); ?></td>
        </tr>
      <?php endforeach; else: ?>
        <tr><td colspan="5">Sem histórico</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

</div>