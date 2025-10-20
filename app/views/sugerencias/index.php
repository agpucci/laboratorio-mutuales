<h2>Sugerencias</h2>
<?php if (empty($items)): ?>
  <div class="alert alert-light border">No hay sugerencias.</div>
<?php else: ?>
  <div class="table-responsive">
    <table class="table table-sm align-middle">
      <thead><tr><th>Fecha</th><th>Mutual</th><th>Usuario</th><th>Texto</th><th class="text-end">Acciones</th></tr></thead>
      <tbody>
      <?php foreach($items as $it): ?>
        <tr>
          <td><?php $d=strtotime($it['created_at'] ?? ''); echo $d?date('d-m-Y',$d):''; ?></td>
          <td><?= htmlspecialchars($it['mutual_name'] ?? '') ?></td>
          <td><?= htmlspecialchars($it['username'] ?? '') ?></td>
          <td><?= nl2br(htmlspecialchars($it['texto'] ?? '')) ?></td>
          <td class="text-end">
            <?php if (($_SESSION['user']['role'] ?? '') === 'ADMIN'): ?>
              <form class="d-inline" method="post" action="<?= $appUrl ?>/sugerencias/delete" onsubmit="return confirm('¿Eliminar sugerencia?')">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                <input type="hidden" name="id" value="<?= (int)$it['id'] ?>">
                <button class="btn btn-sm btn-outline-danger">Eliminar</button>
              </form>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>
