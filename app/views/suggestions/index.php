<h2>Sugerencias</h2>
<p class="text-muted">Mostrando abiertas; si no hay, se listan las más recientes.</p>
<?php if (!$items): ?>
  <div class="alert alert-info">No hay sugerencias para mostrar.</div>
<?php else: ?>
<table class="table table-sm table-striped align-middle">
  <thead>
    <tr>
      <th>#</th>
      <th>Fecha</th>
      <th>Mutual</th>
      <th>Usuario</th>
      <th>Contenido</th>
      <th>Estado</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($items as $it): ?>
    <tr>
      <td><?= (int)$it['id'] ?></td>
      <td><?= htmlspecialchars($it['created_at']) ?></td>
      <td>
        <a href="<?= $appUrl ?>/mutuales/view?id=<?= (int)$it['mutual_id'] ?>" class="text-decoration-none">
          <?= htmlspecialchars($it['mutual_name']) ?>
        </a>
      </td>
      <td><?= htmlspecialchars($it['username']) ?></td>
      <td style="max-width: 420px;"><div class="small"><?= nl2br(htmlspecialchars($it['content'])) ?></div></td>
      <td>
        <span class="badge <?= $it['status']==='ABIERTA'?'bg-warning text-dark':($it['status']==='RESUELTA'?'bg-success':'bg-secondary') ?>">
          <?= htmlspecialchars($it['status']) ?>
        </span>
      </td>
      <td>
        <?php if (($_SESSION['user']['role'] ?? '') === 'ADMIN' && $it['status']==='ABIERTA'): ?>
        <form class="d-flex gap-2 flex-wrap" method="post" action="<?= $appUrl ?>/sugerencias/cerrar">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
          <input type="hidden" name="id" value="<?= (int)$it['id'] ?>">
          <input type="hidden" name="back" value="<?= $appUrl ?>/sugerencias">
          <input class="form-control form-control-sm" style="max-width:220px" name="resolver_note" placeholder="Nota (opcional)">
          <button name="status" value="RESUELTA" class="btn btn-sm btn-success">Resuelta</button>
          <button name="status" value="RECHAZADA" class="btn btn-sm btn-outline-secondary">Rechazar</button>
        </form>
        <?php endif; ?>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>
