<h2>Historial de cambios — Mutual #<?= (int)$mutual_id ?></h2>
<p class="text-muted">Últimos 50 registros</p>
<table class="table table-sm table-striped align-middle">
  <thead>
    <tr>
      <th>#</th>
      <th>Fecha</th>
      <th>Usuario</th>
      <th>Acción</th>
      <th>Antes</th>
      <th>Después</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($items as $it): ?>
    <tr>
      <td><?= (int)$it['id'] ?></td>
      <td><?= htmlspecialchars($it['created_at']) ?></td>
      <td><?= (int)$it['user_id'] ?></td>
      <td><span class="badge bg-secondary"><?= htmlspecialchars($it['action']) ?></span></td>
      <td style="max-width: 320px;"><pre class="mb-0 small" style="white-space: pre-wrap;"><?= htmlspecialchars($it['old_value'] ?? '') ?></pre></td>
      <td style="max-width: 320px;"><pre class="mb-0 small" style="white-space: pre-wrap;"><?= htmlspecialchars($it['new_value'] ?? '') ?></pre></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<a class="btn btn-link" href="<?= $appUrl ?>/mutuales/view?id=<?= (int)$mutual_id ?>">Volver al detalle</a>
