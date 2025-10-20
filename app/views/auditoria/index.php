<h2>Log de cambios</h2>
<?php if (empty($items)): ?>
  <div class="alert alert-light border">Sin registros.</div>
<?php else: ?>
  <div class="table-responsive">
    <table class="table table-sm align-middle">
      <thead><tr><th>Fecha</th><th>Acción</th><th>Objeto</th></tr></thead>
      <tbody>
      <?php foreach($items as $it): ?>
        <tr>
          <td><?php $d=strtotime($it['created_at'] ?? ''); echo $d?date('d-m-Y',$d):''; ?></td>
          <td><?= htmlspecialchars($it['action'] ?? '') ?></td>
          <td><?= htmlspecialchars(($it['table_name'] ?? '').' #'.($it['record_id'] ?? '')) ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>
