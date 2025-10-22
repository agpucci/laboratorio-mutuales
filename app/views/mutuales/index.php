<?php // lista ?>
<div class="d-flex justify-content-between align-items-center">
  <h2 class="mb-0">Mutuales</h2>
  <?php if (($_SESSION['user']['role'] ?? '') === 'ADMIN'): ?>
    <a class="btn btn-success" href="<?= $appUrl ?>/mutuales/create">+ Nueva</a>
  <?php endif; ?>
</div>
<div class="mt-2">
  <a class="btn btn-outline-dark btn-sm" href="<?= $appUrl ?>/mutuales/recientes">Asltimas modificadas</a>
  <a class="btn btn-outline-dark btn-sm" href="<?= $appUrl ?>/auditoria/ultimos">Log de cambios</a>
  <?php if (($_SESSION['user']['role'] ?? '') === 'ADMIN'): ?>
    <a class="btn btn-outline-dark btn-sm" href="<?= $appUrl ?>/sugerencias">Sugerencias</a>
  <?php endif; ?>
</div>

<div class="mt-2">
  <form class="mb-3" method="get" action="<?= $appUrl ?>/mutuales">
    <div class="input-group">
      <input class="form-control" type="text" name="q"
       value="<?= htmlspecialchars($q ?? ($_GET['q'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
       placeholder="Buscar por nombre">
      <button class="btn btn-outline-secondary">Buscar</button>
    </div>
  </form>
</div>

<table class="table table-sm table-striped mt-3 align-middle">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nombre</th>
      <th>Validacion</th>
      <th>Fecha modificacion</th>
      <th style="width:260px">Acciones</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($mutuales as $m): ?>
    <tr>
      <td><?= (int)$m['id'] ?></td>
      <td><?= htmlspecialchars($m['name']) ?></td>
      <td><?= $m['validada'] ? '<span class="badge bg-success">Validada</span>' : '<span class="badge bg-warning text-dark">Pendiente</span>' ?></td>
      <td>
        <?php
          $updatedAt = $m['updated_at'] ?? '';
          if ($updatedAt) {
              $ts = strtotime($updatedAt);
              $formatted = $ts ? date('d/m/Y H:i', $ts) : $updatedAt;
              echo htmlspecialchars($formatted);
          }
        ?>
      </td>
      <td>
        <a class="btn btn-sm btn-outline-primary" href="<?= $appUrl ?>/mutuales/view?id=<?= (int)$m['id'] ?>">Ver</a>
        <?php if (($_SESSION['user']['role'] ?? '') === 'ADMIN'): ?>
          <a class="btn btn-sm btn-outline-secondary" href="<?= $appUrl ?>/mutuales/edit?id=<?= (int)$m['id'] ?>">Editar</a>
          <a class="btn btn-sm btn-outline-dark" href="<?= $appUrl ?>/auditoria/mutual?id=<?= (int)$m['id'] ?>">Cambios</a>
          <form method="post" action="<?= $appUrl ?>/mutuales/delete" style="display:inline">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
            <input type="hidden" name="id" value="<?= (int)$m['id'] ?>">
            <button class="btn btn-sm btn-danger" onclick="return confirm('Eliminar?')">Eliminar</button>
          </form>
        <?php endif; ?>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
