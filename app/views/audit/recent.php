<h2>Log de cambios — Global</h2>
<p class="text-muted">Últimos 50 registros</p>
<table class="table table-sm table-striped align-middle">
  <thead>
    <tr>
      <th>#</th>
      <th>Fecha</th>
      <th>Usuario</th>
      <th>Tabla</th>
      <th>Registro</th>
      <th>Acción</th>
      <th>Detalle</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($items as $it): ?>
    <tr>
      <td><?= (int)$it['id'] ?></td>
      <td><?= htmlspecialchars($it['created_at']) ?></td>
      <td><?= (int)$it['user_id'] ?></td>
      <td><?= htmlspecialchars($it['table_name']) ?></td>
      <td><?= (int)$it['record_id'] ?></td>
      <td><span class="badge bg-secondary"><?= htmlspecialchars($it['action']) ?></span></td>
      <td style="max-width: 360px;">
        <?php if ($it['table_name'] === 'mutuales'): ?>
          <a class="btn btn-sm btn-outline-primary" href="<?= $appUrl ?>/mutuales/view?id=<?= (int)$it['record_id'] ?>">Ver mutual</a>
          <a class="btn btn-sm btn-outline-dark" href="<?= $appUrl ?>/auditoria/mutual?id=<?= (int)$it['record_id'] ?>">Historial</a>
        <?php endif; ?>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
