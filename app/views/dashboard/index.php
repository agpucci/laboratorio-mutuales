<div class="d-flex justify-content-between align-items-center mb-3">
  <h2 class="mb-0">Dashboard</h2>
</div>
<div class="row g-3 mb-4">
  <div class="col-md-3"><a class="btn btn-primary w-100" href="<?= $appUrl ?>/mutuales">Mutuales</a></div>
  <div class="col-md-3"><a class="btn btn-outline-primary w-100" href="<?= $appUrl ?>/mutuales/recientes">Últimas modificadas</a></div>
  <div class="col-md-3"><a class="btn btn-outline-secondary w-100" href="<?= $appUrl ?>/sugerencias">Sugerencias</a></div>
  <div class="col-md-3"><a class="btn btn-outline-secondary w-100" href="<?= $appUrl ?>/auditoria">Log de cambios</a></div>
</div>
<h5>Últimas modificadas</h5>
<?php if (empty($recientes)): ?>
  <div class="alert alert-light border">Sin cambios recientes.</div>
<?php else: ?>
  <div class="table-responsive">
    <table class="table table-sm align-middle">
      <thead><tr><th>Nombre</th><th>Código en sistema</th><th>Validación</th><th>Estado</th><th>Actualizado</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($recientes as $m): ?>
        <tr>
          <td><?= htmlspecialchars($m['name'] ?? '') ?></td>
          <td><?= htmlspecialchars($m['codigo_sistema'] ?? '') ?></td>
          <td>
            <span class="badge <?= !empty($m['validada']) ? 'bg-success' : 'bg-warning text-dark' ?>">
              <?= !empty($m['validada']) ? 'Validada' : 'Pendiente' ?>
            </span>
          </td>
          <td><span class="badge bg-secondary"><?= htmlspecialchars($m['estado'] ?? '') ?></span></td>
          <td><small class="text-muted"><?php if (!empty($m['updated_at'])) { $d=strtotime($m['updated_at']); echo $d?date('d-m-Y',$d):''; } ?></small></td>
          <td><a class="btn btn-sm btn-outline-primary" href="<?= $appUrl ?>/mutuales/view?id=<?= (int)($m['id'] ?? 0) ?>">Ver</a></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>
</div>
