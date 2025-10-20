<?php /* Navbar */ ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<nav class="navbar navbar-expand-lg navbar-dark" style="background:#274369">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= $appUrl ?>/dashboard">LBP Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="topNav" class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="<?= $appUrl ?>/mutuales">Mutuales</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $appUrl ?>/mutuales/recientes">Últimas modificadas</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $appUrl ?>/sugerencias">Sugerencias</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $appUrl ?>/auditoria">Log de cambios</a></li>
      </ul>
      <div class="d-flex">
        <span class="navbar-text me-3"><?= htmlspecialchars($_SESSION['user']['username'] ?? '') ?></span>
        <a class="btn btn-outline-light btn-sm" href="<?= $appUrl ?>/logout">Salir</a>
      </div>
    </div>
  </div>
</nav>
<div class="container py-3">
