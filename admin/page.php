<?php

function cotacao_page_html(){

  $dados = get_option('cotacao_dados') ?: [];

  $soja   = $dados['soja'] ?? '';
  $milho  = $dados['milho'] ?? '';
  $trigo_branqueador  = $dados['trigo_branqueador'] ?? '';
  $trigo_pao = $dados['trigo_pao'] ?? '';
  $data   = $dados['data'] ?? '';
  $history= $dados['history'] ?? [];

  // DELETE DIRETO (SEM HOOK)
  if (isset($_GET['delete_item'])) {
    $index = intval($_GET['delete_item']);

    if (isset($history[$index])) {
      unset($history[$index]);
      $dados['history'] = array_values($history);
      update_option('cotacao_dados', $dados);
      echo '<div class="notice notice-success"><p>Registro excluído.</p></div>';
    } else {
      echo '<div class="notice notice-error"><p>Erro ao excluir.</p></div>';
    }
  }

  if (isset($_GET['delete_all'])) {
    $dados['history'] = [];
    update_option('cotacao_dados', $dados);
    echo '<div class="notice notice-success"><p>Histórico limpo.</p></div>';
  }

?>

<div class="wrap">
  <h1>Cotação</h1>

  <form method="post" action="options.php">
    <?php settings_fields('cotacao_group'); ?>

    <table class="form-table">
      <tr><th>Preço da Soja</th><td><input class="money" name="cotacao_dados[soja]" value="<?php echo esc_attr($soja); ?>"></td></tr>
      <tr><th>Preço do Milho</th><td><input class="money" name="cotacao_dados[milho]" value="<?php echo esc_attr($milho); ?>"></td></tr>
      <tr><th>Preço do Trigo Branqueador</th><td><input class="money" name="cotacao_dados[trigo_branqueador]" value="<?php echo esc_attr($trigo_branqueador); ?>"></td></tr>
      <tr><th>Preço do Trigo Pão</th><td><input class="money" name="cotacao_dados[trigo_pao]" value="<?php echo esc_attr($trigo_pao); ?>"></td></tr>
      <tr><th>Atualizado em</th><td><input type="date" name="cotacao_dados[data]" value="<?php echo esc_attr($data); ?>"></td></tr>
    </table>

    <?php submit_button(); ?>
  </form>

  <h2>Histórico</h2>

  <a href="?page=cotacao&delete_all=1" class="button" onclick="return confirm('Excluir tudo?')">Excluir histórico</a>

  <table class="widefat">
    <thead>
      <tr>
        <th>Data</th>
        <th>Soja</th>
        <th>Milho</th>
        <th>Trigo Branqueador</th>
        <th>Trigo Pão</th>
        <th>Ação</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($history)): foreach($history as $index => $h): ?>
        <tr>
          <td><?php echo esc_html(date('d/m/Y H:i', strtotime($h['date']))); ?></td>
          <td>R$ <?php echo esc_html(number_format($h['soja'],2,',','.')); ?></td>
          <td>R$ <?php echo esc_html(number_format($h['milho'],2,',','.')); ?></td>
          <td>R$ <?php echo esc_html(number_format($h['trigo_branqueador'],2,',','.')); ?></td>
          <td>R$ <?php echo esc_html(number_format($h['trigo_pao'],2,',','.')); ?></td>
          <td>
            <a href="?page=cotacao&delete_item=<?php echo $index; ?>" class="button" onclick="return confirm('Excluir?')">Excluir</a>
          </td>
        </tr>
      <?php endforeach; else: ?>
        <tr><td colspan="6">Sem histórico</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

</div>

<?php
}