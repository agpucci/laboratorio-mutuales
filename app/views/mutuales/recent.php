<h2>Últimas modificadas</h2>
<table class="table table-sm table-striped mt-3 align-middle">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nombre</th>
      <th>Validación</th>
      <th>Actualizada</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($mutuales as $m): ?>
    <tr>
      <td><?= (int)$m['id'] ?></td>
      <td><?= htmlspecialchars($m['name']) ?></td>
      <td><?= $m['validada'] ? '<span class="badge bg-success">Validada</span>' : '<span class="badge bg-warning text-dark">Pendiente</span>' ?></td>
      <td><?= htmlspecialchars($m['updated_at']) ?></td>
      <td>
        <a class="btn btn-sm btn-outline-primary" href="<?= $appUrl ?>/mutuales/view?id=<?= (int)$m['id'] ?>">Ver</a>
        <?php if (($_SESSION['user']['role'] ?? '') === 'ADMIN'): ?>
          <a class="btn btn-sm btn-outline-secondary" href="<?= $appUrl ?>/mutuales/edit?id=<?= (int)$m['id'] ?>">Editar</a>
          <a class="btn btn-sm btn-outline-dark" href="<?= $appUrl ?>/auditoria/mutual?id=<?= (int)$m['id'] ?>">Cambios</a>
        <?php endif; ?>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
