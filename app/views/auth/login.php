<div class='row justify-content-center'>
  <div class='col-md-4'>
    <h3 class="mb-3">Ingreso</h3>
    <?php if(!empty($error)):?><div class='alert alert-danger'><?=htmlspecialchars($error)?></div><?php endif;?>
    <form method='post' action='<?=APP_URL?>/login'>
      <input type='hidden' name='csrf_token' value='<?=htmlspecialchars($csrf)?>'>
      <div class='mb-3'><label class="form-label">Usuario</label><input class='form-control' name='username' autocomplete="username"></div>
      <div class='mb-3'><label class="form-label">Contraseña</label><input type='password' class='form-control' name='password' autocomplete="current-password"></div>
      <button class='btn btn-primary w-100'>Entrar</button>
    </form>
  </div>
</div>
