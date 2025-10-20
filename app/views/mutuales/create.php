<?php
// CREATE view (v1.5.2) — Ajustes: agrega "Coseguros descripción" (textarea grande)
// y cambia "Validez" a campo de texto.
?>
<h2>Nueva Mutual</h2>

<form method="post" action="<?= $appUrl ?>/mutuales/create" enctype="multipart/form-data">
  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

  <?php
    // Helpers locales
    $mutual = $mutual ?? [];
    $data = $data ?? [];
    $sel = function($val,$cur){ return ($val===$cur)?'selected':''; };
    $getv = function($key, $default='') use ($mutual, $data){
      if (isset($mutual[$key])) return $mutual[$key];
      if (isset($data[$key])) return $data[$key];
      return $default;
    };
    $recOpts = ['Digital','Electrónica','Pre-impresa','Grillada','Todas'];
    $recSel  = isset($mutual['receta']) && $mutual['receta'] ? json_decode($mutual['receta'], true) : (isset($data['receta']) ? (is_array($data['receta']) ? $data['receta'] : json_decode($data['receta'], true)) : []);
    $recSel  = is_array($recSel) ? $recSel : [];
    $tipoMutualOpts = ['', 'Obra social','Prepaga','Particular','Particular con descuento','Ensalud','Roisa','Otra'];
    $validarOpts = ['Portal','DNI','Credencial','Credencial virtual','Cupón de pago'];
    $valSel = isset($mutual['validar_afiliado']) && $mutual['validar_afiliado'] ? json_decode($mutual['validar_afiliado'], true) : (isset($data['validar_afiliado']) ? (is_array($data['validar_afiliado']) ? $data['validar_afiliado'] : json_decode($data['validar_afiliado'], true)) : []);
    $valSel = is_array($valSel) ? $valSel : [];
  ?>

  <div class="row g-3 mt-3">
    <div class="col-md-8">
      <label class="form-label">Nombre</label>
      <input class="form-control" name="name" value="<?= htmlspecialchars($getv('name')) ?>">
    </div>

    <div class="col-md-4">
      <label class="form-label">Código en sistema</label>
      <input class="form-control" name="codigo_sistema" value="<?= htmlspecialchars($getv('codigo_sistema')) ?>">
    </div>

    <!-- Código en un solo renglón -->
    <div class="col-md-4">
      <label class="form-label">Código</label>
      <input type="text" class="form-control" name="codigos" value="<?= htmlspecialchars($getv('codigos')) ?>">
    </div>

    <div class="col-md-4">
      <label class="form-label">APB</label>
      <?php $opts=['','Paga','No paga','Mitad y Mitad','Varía según plan','Viene en la autorización','Validar en portal','Otro']; $v=$getv('apb'); ?>
      <select class="form-select" name="apb">
        <option value="">Seleccionar…</option>
        <?php foreach($opts as $o): if($o==='') continue; ?><option value="<?= $o ?>" <?= $sel($o,$v) ?>><?= $o ?></option><?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-4">
      <label class="form-label">Tipo de mutual</label>
      <?php $v=$getv('tipo_mutual'); ?>
      <select class="form-select" name="tipo_mutual">
        <option value="">Seleccionar…</option>
        <?php foreach($tipoMutualOpts as $o): if($o==='') continue; ?><option value="<?= $o ?>" <?= $sel($o,$v) ?>><?= $o ?></option><?php endforeach; ?>
      </select>
    </div>

    <div class="col-12">
      <label class="form-label">APB descripción</label>
      <textarea class="form-control" name="apb_adicional" rows="2"><?= htmlspecialchars($getv('apb_adicional')) ?></textarea>
    </div>

    <div class="col-md-6">
      <label class="form-label">Coseguros</label>
      <?php $opts=['','Paga','No paga','Varía según plan','Viene en la autorización','Validar en portal','Otro']; $v=$getv('coseguros'); ?>
      <select class="form-select" name="coseguros">
        <option value="">Seleccionar…</option>
        <?php foreach($opts as $o): if($o==='') continue; ?><option value="<?= $o ?>" <?= $sel($o,$v) ?>><?= $o ?></option><?php endforeach; ?>
      </select>
    </div>

    <!-- NUEVO: Coseguros descripción (textarea grande) -->
    <div class="col-12">
      <label class="form-label">Coseguros descripción</label>
      <textarea class="form-control" name="coseguros_descripcion" rows="5"><?= htmlspecialchars($getv('coseguros_descripcion')) ?></textarea>
    </div>

    <div class="col-md-6">
      <label class="form-label">Validez</label>
      <input type="text" class="form-control" name="validez" value="<?= htmlspecialchars($getv('validez','30')) ?>">
    </div>

    <div class="col-md-6">
      <label class="form-label">Token</label>
      <?php $opts=['','Solicitar','No requiere']; $v=$getv('token'); ?>
      <select class="form-select" name="token">
        <option value="">Seleccionar…</option>
        <?php foreach($opts as $o): if($o==='') continue; ?><option value="<?= $o ?>" <?= $sel($o,$v) ?>><?= $o ?></option><?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Autorización</label>
      <?php $opts=['','Debe venir todo autorizado','Debe venir autorizado prácticas específicas','Sin autorización','Autorizar en el momento','Autorizar posteriormente','Todo fuera del listado']; $v=$getv('autorizacion'); ?>
      <select class="form-select" name="autorizacion">
        <option value="">Seleccionar…</option>
        <?php foreach($opts as $o): if($o==='') continue; ?><option value="<?= $o ?>" <?= $sel($o,$v) ?>><?= $o ?></option><?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Autorizar en</label>
      <?php $opts=['','AOL','Traditum','Apligen','Otro']; $v=$getv('autorizar_en'); ?>
      <select class="form-select" name="autorizar_en">
        <option value="">Seleccionar…</option>
        <?php foreach($opts as $o): if($o==='') continue; ?><option value="<?= $o ?>" <?= $sel($o,$v) ?>><?= $o ?></option><?php endforeach; ?>
      </select>
    </div>

    <div class="col-12">
      <label class="form-label">Validar afiliado (múltiple)</label>
      <select class="form-select" name="validar_afiliado[]" multiple>
        <?php foreach($validarOpts as $o): ?><option value="<?= $o ?>" <?= in_array($o,$valSel,true)?'selected':'' ?>><?= $o ?></option><?php endforeach; ?>
      </select>
    </div>

    <div class="col-12">
      <label class="form-label">Planes</label>
      <textarea class="form-control" name="planes" rows="2"><?= htmlspecialchars($getv('planes')) ?></textarea>
    </div>

    <div class="col-12">
      <label class="form-label">Receta (múltiple)</label>
      <select class="form-select" name="receta[]" multiple>
        <?php foreach($recOpts as $o): ?><option value="<?= $o ?>" <?= in_array($o,$recSel,true)?'selected':'' ?>><?= $o ?></option><?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Domicilio</label>
      <?php $opts=['','Cubre','No cubre']; $v=$getv('domicilio_cubre'); ?>
      <select class="form-select" name="domicilio_cubre">
        <option value="">Seleccionar…</option>
        <?php foreach($opts as $o): if($o==='') continue; ?><option value="<?= $o ?>" <?= $sel($o,$v) ?>><?= $o ?></option><?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Credencial</label>
      <?php $opts=['','Plástica','Digital','Todas']; $v=$getv('credencial'); ?>
      <select class="form-select" name="credencial">
        <option value="">Seleccionar…</option>
        <?php foreach($opts as $o): if($o==='') continue; ?><option value="<?= $o ?>" <?= $sel($o,$v) ?>><?= $o ?></option><?php endforeach; ?>
      </select>
    </div>

    <div class="col-12">
      <label class="form-label">Domicilio descripción</label>
      <textarea class="form-control" name="domicilio_adicional" rows="3"><?= htmlspecialchars($getv('domicilio_adicional')) ?></textarea>
    </div>

    <div class="col-12">
      <label class="form-label">Atención a prestadores</label>
      <textarea class="form-control" name="atencion" rows="3"><?= htmlspecialchars($getv('atencion')) ?></textarea>
    </div>

    <div class="col-12">
      <label class="form-label">Otra información</label>
      <textarea class="form-control" name="comentarios" rows="3"><?= htmlspecialchars($getv('comentarios')) ?></textarea>
    </div>

    <div class="col-12">
      <label class="form-label">Link prácticas específicas</label>
      <input class="form-control" name="link_estudios" value="<?= htmlspecialchars($getv('link_estudios')) ?>" placeholder="https://...">
    </div>

    <div class="col-md-6">
      <label class="form-label">Listado de estudios (adjunto)</label>
      <input type="file" class="form-control" name="adj_listado_estudios">
    </div>

    <div class="col-md-6">
      <label class="form-label">Adjunto observaciones</label>
      <input class="form-control" name="adj_listado_obs" value="<?= htmlspecialchars($getv('adj_listado_obs')) ?>">
    </div>

    <div class="col-md-6">
      <label class="form-label">Normas operativas (adjunto)</label>
      <input type="file" class="form-control" name="adj_normas_operativas">
    </div>

    <div class="col-md-6">
      <label class="form-label">Adjunto observaciones</label>
      <input class="form-control" name="adj_normas_obs" value="<?= htmlspecialchars($getv('adj_normas_obs')) ?>">
    </div>

  </div>

  <hr class="my-4">
  <h5>Facturación</h5>
  <div class="row g-3">
    <div class="col-md-4">
      <label class="form-label">CUIT</label>
      <input class="form-control" name="cuit" value="<?= htmlspecialchars($getv('cuit')) ?>">
    </div>
    <div class="col-md-8">
      <label class="form-label">Razón social</label>
      <input class="form-control" name="razon_social" value="<?= htmlspecialchars($getv('razon_social')) ?>">
    </div>

    <div class="col-md-4">
      <label class="form-label">Facturación</label>
      <?php $opts=['','Físico','Email','Portal','No se factura']; $v=$getv('factura'); ?>
      <select class="form-select" name="factura">
        <option value="">Seleccionar…</option>
        <?php foreach($opts as $o): if($o==='') continue; ?><option value="<?= $o ?>" <?= $sel($o,$v) ?>><?= $o ?></option><?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-4">
      <label class="form-label">Condición ante el IVA</label>
      <?php $opts=['','Factura A (exento)','Factura A (exento y gravado)','Factura B']; $v=$getv('condicion_iva'); ?>
      <select class="form-select" name="condicion_iva">
        <option value="">Seleccionar…</option>
        <?php foreach($opts as $o): if($o==='') continue; ?><option value="<?= $o ?>" <?= $sel($o,$v) ?>><?= $o ?></option><?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-4">
      <label class="form-label">NBU convenio</label>
      <?php $opts=['','NBU 2012','NBU 2016','NBU 2023','NBU 2024','Particular','Propio']; $v=$getv('nbu_convenio'); ?>
      <select class="form-select" name="nbu_convenio">
        <option value="">Seleccionar…</option>
        <?php foreach($opts as $o): if($o==='') continue; ?><option value="<?= $o ?>" <?= $sel($o,$v) ?>><?= $o ?></option><?php endforeach; ?>
      </select>
    </div>

    <div class="col-12">
      <label class="form-label">Portal prestadores</label>
      <textarea class="form-control" name="portal_prestadores" rows="3" placeholder="URL / usuario / clave / instrucciones"><?= htmlspecialchars($getv('portal_prestadores')) ?></textarea>
    </div>

    <div class="col-md-4">
      <label class="form-label">Nombre/área del otro portal</label>
      <input class="form-control" name="portal_prestadores_extra_label" value="<?= htmlspecialchars($getv('portal_prestadores_extra_label')) ?>">
    </div>
    <div class="col-md-8">
      <label class="form-label">Otro portal (acceso / instrucciones)</label>
      <textarea class="form-control" name="portal_prestadores_extra" rows="3"><?= htmlspecialchars($getv('portal_prestadores_extra')) ?></textarea>
    </div>

    <div class="col-12">
      <label class="form-label">Observaciones sobre la facturación</label>
      <textarea class="form-control" name="fact_observaciones" rows="3"><?= htmlspecialchars($getv('fact_observaciones')) ?></textarea>
    </div>

    <div class="col-md-6">
      <label class="form-label">Teléfono 1</label>
      <input class="form-control" name="telefono1" value="<?= htmlspecialchars($getv('telefono1')) ?>">
      <small class="text-muted">Área</small>
      <input class="form-control" name="telefono1_area" value="<?= htmlspecialchars($getv('telefono1_area')) ?>">
    </div>
    <div class="col-md-6">
      <label class="form-label">Teléfono 2</label>
      <input class="form-control" name="telefono2" value="<?= htmlspecialchars($getv('telefono2')) ?>">
      <small class="text-muted">Área</small>
      <input class="form-control" name="telefono2_area" value="<?= htmlspecialchars($getv('telefono2_area')) ?>">
    </div>

    <div class="col-md-6">
      <label class="form-label">Teléfono 3</label>
      <input class="form-control" name="telefono3" value="<?= htmlspecialchars($getv('telefono3')) ?>">
      <small class="text-muted">Área</small>
      <input class="form-control" name="telefono3_area" value="<?= htmlspecialchars($getv('telefono3_area')) ?>">
    </div>
    <div class="col-md-6">
      <label class="form-label">Teléfono 4</label>
      <input class="form-control" name="telefono4" value="<?= htmlspecialchars($getv('telefono4')) ?>">
      <small class="text-muted">Área</small>
      <input class="form-control" name="telefono4_area" value="<?= htmlspecialchars($getv('telefono4_area')) ?>">
    </div>

    <div class="col-md-6">
      <label class="form-label">Dirección 1</label>
      <input class="form-control" name="direccion1" value="<?= htmlspecialchars($getv('direccion1')) ?>">
      <small class="text-muted">Área</small>
      <input class="form-control" name="direccion1_area" value="<?= htmlspecialchars($getv('direccion1_area')) ?>">
    </div>
    <div class="col-md-6">
      <label class="form-label">Dirección 2</label>
      <input class="form-control" name="direccion2" value="<?= htmlspecialchars($getv('direccion2')) ?>">
      <small class="text-muted">Área</small>
      <input class="form-control" name="direccion2_area" value="<?= htmlspecialchars($getv('direccion2_area')) ?>">
    </div>

    <div class="col-12">
      <label class="form-label">Estado</label>
      <?php $opts=['','Activo','Suspendido','Finalizado']; $v=$getv('estado','Activo'); ?>
      <select class="form-select" name="estado">
        <option value="">Seleccionar…</option>
        <?php foreach($opts as $o): if($o==='') continue; ?><option value="<?= $o ?>" <?= $sel($o,$v) ?>><?= $o ?></option><?php endforeach; ?>
      </select>
    </div>
  </div>

  <div class="mt-3 d-flex gap-2">
    <button class="btn btn-primary" name="action" value="save">Actualizar</button>
    <button class="btn btn-success" name="action" value="save_validate">Guardar y validar</button>
    <a class="btn btn-link" href="<?= $appUrl ?>/mutuales">Cancelar</a>
  </div>
</form>
