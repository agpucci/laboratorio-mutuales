<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h2 class="mb-0"><?= htmlspecialchars($mutual['name']) ?></h2>
    <small class="text-muted">ID #<?= (int)$mutual['id'] ?> · Actualizada: <?= htmlspecialchars($mutual['updated_at'] ?? '') ?> · Creada: <?= htmlspecialchars($mutual['created_at'] ?? '') ?></small>
  </div>
  <div>
    <span class="badge <?= $mutual['validada'] ? 'bg-success' : 'bg-warning text-dark' ?>">
      <?= $mutual['validada'] ? 'Validada' : 'Pendiente' ?>
    </span>
  </div>
</div>

<div class="row g-3">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-header fw-semibold">Atención al afiliado</div>
      <div class="card-body">
        <p class="mb-1"><strong>Códigos:</strong> <?= htmlspecialchars($mutual['codigos'] ?? '') ?></p>
        <p class="mb-1"><strong>APB:</strong> <?= htmlspecialchars($mutual['apb'] ?? '') ?> <?php if(!empty($mutual['apb_adicional'])): ?> — <?= htmlspecialchars($mutual['apb_adicional']) ?><?php endif; ?></p>
        <p class="mb-1"><strong>Coseguros:</strong> <?= htmlspecialchars($mutual['coseguros'] ?? '') ?></p>
        <?php if (!empty($mutual['coseguros_adicional'])): ?>
          <p class="mb-1"><strong>Coseguros adicional:</strong> <?= nl2br(htmlspecialchars($mutual['coseguros_adicional'])) ?></p>
        <?php endif; ?>
        <p class="mb-1"><strong>Token:</strong> <?= htmlspecialchars($mutual['token'] ?? '') ?></p>
        <p class="mb-1"><strong>Autorización:</strong> <?= htmlspecialchars($mutual['autorizacion'] ?? '') ?></p>
        <p class="mb-1"><strong>Elegibilidad:</strong> <?= htmlspecialchars($mutual['elegibilidad'] ?? '') ?></p>
        <?php if (!empty($mutual['elegibilidad_adicional'])): ?>
          <p class="mb-1"><strong>Elegibilidad adicional:</strong> <?= nl2br(htmlspecialchars($mutual['elegibilidad_adicional'])) ?></p>
        <?php endif; ?>
        <p class="mb-1"><strong>Validez:</strong> <?= (int)($mutual['validez'] ?? 0) ?></p>
        <p class="mb-1"><strong>Planes:</strong> <?= htmlspecialchars($mutual['planes'] ?? '') ?></p>
        <p class="mb-1"><strong>Receta:</strong>
          <?php $r = !empty($mutual['receta']) ? json_decode($mutual['receta'], true) : []; echo htmlspecialchars(implode(', ', $r?:[])); ?>
        </p>
        <p class="mb-1"><strong>Domicilio:</strong> <?= htmlspecialchars($mutual['domicilio_cubre'] ?? '') ?> <?php if(!empty($mutual['domicilio_adicional'])): ?> — <?= htmlspecialchars($mutual['domicilio_adicional']) ?><?php endif; ?></p>
        <p class="mb-0"><strong>Credencial:</strong> <?= htmlspecialchars($mutual['credencial'] ?? '') ?></p>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-header fw-semibold">Información general</div>
      <div class="card-body">
        <p class="mb-1"><strong>Paga coseguro:</strong> <?= $mutual['paga_coseguro'] ? 'Sí' : 'No' ?></p>
        <?php if ($mutual['paga_coseguro']): ?>
          <p class="mb-1"><strong>Detalle coseguro:</strong> <?= htmlspecialchars($mutual['detalle_coseguro'] ?? '') ?></p>
        <?php endif; ?>
        <p class="mb-0"><strong>Descripción:</strong><br><?= nl2br(htmlspecialchars($mutual['description'] ?? '')) ?></p>
      </div>
    </div>

    <div class="card shadow-sm mt-3">
      <div class="card-header fw-semibold">Facturación</div>
      <div class="card-body">
        <p class="mb-1"><strong>CUIT:</strong> <?= htmlspecialchars($mutual['cuit'] ?? '') ?></p>
        <p class="mb-1"><strong>Razón social:</strong> <?= htmlspecialchars($mutual['razon_social'] ?? '') ?></p>
        <p class="mb-1"><strong>Factura:</strong> <?= htmlspecialchars($mutual['factura'] ?? '') ?></p>
        <p class="mb-1"><strong>Nomenclador:</strong> <?= htmlspecialchars($mutual['nomenclador'] ?? '') ?></p>
        <p class="mb-1"><strong>Domicilio fact.:</strong> <?= htmlspecialchars($mutual['domicilio_fact'] ?? '') ?></p>
        <p class="mb-1"><strong>Entrega:</strong> <?= htmlspecialchars($mutual['entrega'] ?? '') ?></p>
        <p class="mb-1"><strong>Correo:</strong> <?= htmlspecialchars($mutual['correo'] ?? '') ?></p>
        <p class="mb-1"><strong>Teléfonos:</strong> <?= htmlspecialchars($mutual['telefonos'] ?? '') ?></p>
        <p class="mb-0"><strong>Portal:</strong> <?= htmlspecialchars($mutual['portal'] ?? '') ?></p>
      </div>
    </div>
  </div>
</div>

<div class="mt-3 d-flex flex-wrap gap-2">
  <a class="btn btn-outline-primary" href="<?= $appUrl ?>/auditoria/mutual?id=<?= (int)$mutual['id'] ?>">Ver historial</a>
  <?php if (($_SESSION['user']['role'] ?? '') === 'ADMIN'): ?>
    <?php if (!$mutual['validada']): ?>
      <form class="d-inline" method="post" action="<?= $appUrl ?>/mutuales/validate">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
        <input type="hidden" name="id" value="<?= (int)$mutual['id'] ?>">
        <button class="btn btn-success">Validar</button>
      </form>
    <?php else: ?>
      <form class="d-inline" method="post" action="<?= $appUrl ?>/mutuales/desvalidar">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
        <input type="hidden" name="id" value="<?= (int)$mutual['id'] ?>">
        <button class="btn btn-outline-warning">Desvalidar</button>
      </form>
    <?php endif; ?>
    <a class="btn btn-secondary" href="<?= $appUrl ?>/mutuales/edit?id=<?= (int)$mutual['id'] ?>">Editar</a>
  <?php endif; ?>
  <a class="btn btn-link" href="<?= $appUrl ?>/mutuales">Volver</a>
</div>

<?php $sugs = \Models\Suggestion::listByMutual((int)$mutual['id']); ?>
<hr class="my-4" id="sugerencias">
<h4>Sugerencias y comentarios</h4>

<div class="row g-3">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-header fw-semibold">Nueva sugerencia</div>
      <div class="card-body">
        <form method="post" action="<?= $appUrl ?>/sugerencias/add">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
          <input type="hidden" name="mutual_id" value="<?= (int)$mutual['id'] ?>">
          <div class="mb-2">
            <label class="form-label">Detalle</label>
            <textarea class="form-control" name="content" rows="3" placeholder="Escribí tu sugerencia o comentario..."></textarea>
          </div>
          <button class="btn btn-primary">Enviar</button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-header fw-semibold">Historial de sugerencias</div>
      <div class="card-body">
        <?php if (!$sugs): ?>
          <div class="text-muted">Aún no hay sugerencias.</div>
        <?php else: ?>
          <ul class="list-group">
            <?php foreach ($sugs as $sg): ?>
              <li class="list-group-item">
                <div class="d-flex justify-content-between">
                  <div>
                    <span class="badge <?= $sg['status']==='ABIERTA'?'bg-warning text-dark':($sg['status']==='RESUELTA'?'bg-success':'bg-secondary') ?>">
                      <?= htmlspecialchars($sg['status']) ?>
                    </span>
                    <small class="text-muted"> · por <?= htmlspecialchars($sg['username']) ?> · <?= htmlspecialchars($sg['created_at']) ?></small>
                  </div>
                </div>
                <div class="mt-2"><?= nl2br(htmlspecialchars($sg['content'])) ?></div>
                <?php if (!empty($sg['resolver_note'])): ?>
                  <div class="mt-2 small text-muted"><strong>Nota:</strong> <?= nl2br(htmlspecialchars($sg['resolver_note'])) ?></div>
                <?php endif; ?>

                <?php if (($_SESSION['user']['role'] ?? '') === 'ADMIN' && $sg['status']==='ABIERTA'): ?>
                  <form class="mt-2 d-flex gap-2 flex-wrap" method="post" action="<?= $appUrl ?>/sugerencias/cerrar">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                    <input type="hidden" name="id" value="<?= (int)$sg['id'] ?>">
                    <input type="hidden" name="back" value="<?= $appUrl ?>/mutuales/view?id=<?= (int)$mutual['id'] ?>#sugerencias">
                    <input class="form-control form-control-sm" style="max-width:320px" name="resolver_note" placeholder="Nota (opcional)">
                    <button name="status" value="RESUELTA" class="btn btn-sm btn-success">Marcar resuelta</button>
                    <button name="status" value="RECHAZADA" class="btn btn-sm btn-outline-secondary">Rechazar</button>
                  </form>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
