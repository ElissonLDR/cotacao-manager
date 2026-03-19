<?php

function cotacao_page_html()
{

  $dados = get_option('cotacao_dados') ?: [];

  $soja   = $dados['soja'] ?? '';
  $milho  = $dados['milho'] ?? '';
  $trigo  = $dados['trigo'] ?? '';
  $trigo2 = $dados['trigo2'] ?? '';
  $data   = $dados['data'] ?? '';
  $history = $dados['history'] ?? [];
?>

  <div class="wrap">
    <h1>Cotação</h1>

    <form method="post" action="options.php">
      <?php settings_fields('cotacao_group'); ?>

      <table class="form-table">
        <tr>
          <th>Preço da Soja</th>
          <td><input class="money" name="cotacao_dados[soja]" value="<?php echo esc_attr($soja); ?>"></td>
        </tr>
        <tr>
          <th>Preço do Milho</th>
          <td><input class="money" name="cotacao_dados[milho]" value="<?php echo esc_attr($milho); ?>"></td>
        </tr>
        <tr>
          <th>Preço do Trigo Branqueador</th>
          <td><input class="money" name="cotacao_dados[trigo]" value="<?php echo esc_attr($trigo); ?>"></td>
        </tr>
        <tr>
          <th>Preço do Trigo Pão</th>
          <td><input class="money" name="cotacao_dados[trigo2]" value="<?php echo esc_attr($trigo2); ?>"></td>
        </tr>
      </table>

      <?php submit_button(); ?>
    </form>

    <h2>Histórico</h2>

    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
      <input type="hidden" name="action" value="delete_cotacao_history">
      <?php wp_nonce_field('delete_cotacao_history'); ?>
      <?php submit_button('Excluir histórico', 'delete'); ?>
    </form>

    <table class="widefat">
      <thead>
        <tr>
          <th>Data</th>
          <th>Soja</th>
          <th>Milho</th>
          <th>Trigo</th>
          <th>Trigo2</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($history)): foreach (array_reverse($history, true) as $index => $h): ?>
            <tr>
              <td><?php echo esc_html(date('d/m/Y H:i', strtotime($h['date']))); ?></td>

              <td>R$ <?php echo esc_html(number_format($h['soja'], 2, ',', '.')); ?></td>
              <td>R$ <?php echo esc_html(number_format($h['milho'], 2, ',', '.')); ?></td>
              <td>R$ <?php echo esc_html(number_format($h['trigo'], 2, ',', '.')); ?></td>
              <td>R$ <?php echo esc_html(number_format($h['trigo2'], 2, ',', '.')); ?></td>

              <td>
                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                  <input type="hidden" name="action" value="delete_cotacao_item">
                  <input type="hidden" name="index" value="<?php echo esc_attr($index); ?>">
                  <?php wp_nonce_field('delete_cotacao_item'); ?>
                  <button class="button button-danger">Excluir</button>
                </form>
              </td>
            </tr>
          <?php endforeach;
        else: ?>
          <tr>
            <td colspan="6">Sem histórico</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>

  </div>

<?php
}
