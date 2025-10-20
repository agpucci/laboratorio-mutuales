<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($title ?? $appName) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
:root{ --p:#274369; --s1:#B02517; --s2:#24997E; }
.navbar{ background: var(--p); }
.badge.bg-warning.text-dark{ color:#000 !important; }
.card.shadow-sm{ box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important; }
</style>
</head>
<body>
<?php

function btnClassExact(string $regex): string {
  $current = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
  return (preg_match($regex, $current)) ? 'btn-light' : 'btn-outline-light';
}
?>
<nav class="navbar navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="<?= $appUrl ?>/dashboard"><?= htmlspecialchars($appName) ?></a>
    <div class="d-flex gap-2">
      <a class="btn <?= btnClassExact('#^/mutuales/?$#') ?> btn-sm" href="<?= $appUrl ?>/mutuales">Mutuales</a>
      <a class="btn <?= btnClassExact('#^/mutuales/recientes/?$#') ?> btn-sm" href="<?= $appUrl ?>/mutuales/recientes">Últimas modificadas</a>
      <a class="btn <?= btnClassExact('#^/auditoria/ultimos/?$#') ?> btn-sm" href="<?= $appUrl ?>/auditoria/ultimos">Log de cambios</a>
      <?php if (!empty($_SESSION['user']) && (($_SESSION['user']['role'] ?? '') === 'ADMIN')): ?>
        <a class="btn <?= btnClassExact('#^/sugerencias(?:/.*)?$#') ?> btn-sm" href="<?= $appUrl ?>/sugerencias">Sugerencias</a>
      <?php endif; ?>
      <?php if (!empty($_SESSION['user'])): ?>
        <form method="post" action="<?= $appUrl ?>/logout" class="m-0">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
          <button class="btn btn-light btn-sm">Salir (<?= htmlspecialchars($_SESSION['user']['username']) ?>)</button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</nav>
<main class="container my-4">
