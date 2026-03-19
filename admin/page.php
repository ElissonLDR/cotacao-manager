<?php

function cotacao_page_html(){

  global $wpdb;
  $table = $wpdb->prefix . 'cotacoes';

  $page   = max(1, intval($_GET['paged'] ?? 1));
  $limit  = 10;
  $offset = ($page - 1) * $limit;

  $total = $wpdb->get_var("SELECT COUNT(*) FROM $table");

  $results = $wpdb->get_results(
    $wpdb->prepare(
      "SELECT * FROM $table ORDER BY id DESC LIMIT %d OFFSET %d",
      $limit,
      $offset
    )
  );

  $dados = get_option('cotacao_dados') ?: [];
  ?>

  <div class="wrap">
    <h1>Cotação</h1>

    <?php if (isset($_GET['msg'])): ?>
      <?php if ($_GET['msg'] === 'deleted'): ?>
        <div class="notice notice-success"><p>Registro excluído.</p></div>
      <?php elseif ($_GET['msg'] === 'deleted_all'): ?>
        <div class="notice notice-success"><p>Histórico apagado.</p></div>
      <?php endif; ?>
    <?php endif; ?>

    <form method="post" action="options.php">
      <?php settings_fields('cotacao_group'); ?>

      <table class="form-table">
        <tr>
          <th>Soja</th>
          <td><input class="money" name="cotacao_dados[soja]" value="<?php echo esc_attr($dados['soja'] ?? ''); ?>"></td>
        </tr>
        <tr>
          <th>Milho</th>
          <td><input class="money" name="cotacao_dados[milho]" value="<?php echo esc_attr($dados['milho'] ?? ''); ?>"></td>
        </tr>
        <tr>
          <th>Trigo Branqueador</th>
          <td><input class="money" name="cotacao_dados[trigo_branqueador]" value="<?php echo esc_attr($dados['trigo_branqueador'] ?? ''); ?>"></td>
        </tr>
        <tr>
          <th>Trigo Pão</th>
          <td><input class="money" name="cotacao_dados[trigo_pao]" value="<?php echo esc_attr($dados['trigo_pao'] ?? ''); ?>"></td>
        </tr>
        <tr>
          <th>Data</th>
          <td><input type="date" name="cotacao_dados[data]" value="<?php echo esc_attr($dados['data'] ?? ''); ?>"></td>
        </tr>
      </table>

      <?php submit_button(); ?>
    </form>

    <h2>Histórico</h2>

    <table class="widefat">
      <thead>
        <tr>
          <th>Data</th>
          <th>Soja</th>
          <th>Milho</th>
          <th>Trigo B.</th>
          <th>Trigo P.</th>
          <th>Ação</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($results): ?>
          <?php foreach($results as $row): ?>
            <tr>
              <td><?php echo esc_html(date('d/m/Y', strtotime($row->data))); ?></td>
              <td>R$ <?php echo number_format($row->soja,2,',','.'); ?></td>
              <td>R$ <?php echo number_format($row->milho,2,',','.'); ?></td>
              <td>R$ <?php echo number_format($row->trigo_branqueador,2,',','.'); ?></td>
              <td>R$ <?php echo number_format($row->trigo_pao,2,',','.'); ?></td>
              <td>
                <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=cotacao&delete_id=' . $row->id), 'delete_item'); ?>" class="button">
                  Excluir
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="6">Sem dados</td></tr>
        <?php endif; ?>
      </tbody>
    </table>

    <?php
    $pages = ceil($total / $limit);

    if ($pages > 1){
      echo '<div class="tablenav"><div class="tablenav-pages">';
      for ($i=1; $i <= $pages; $i++){
        echo '<a class="button '.($i==$page?'button-primary':'').'" href="?page=cotacao&paged='.$i.'">'.$i.'</a> ';
      }
      echo '</div></div>';
    }
    ?>

    <form method="post" onsubmit="return confirm('TEM CERTEZA ABSOLUTA? Essa ação apaga tudo.')">
      <?php wp_nonce_field('delete_all'); ?>
      <input type="hidden" name="delete_all" value="1">
      <?php submit_button('Excluir tudo (irreversível)', 'delete'); ?>
    </form>

  </div>

  <?php
}