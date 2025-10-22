<?php
function sha256_file_safe($path) { if (!is_file($path)) return null; return hash_file('sha256', $path); }
function out($m){ if(PHP_SAPI==='cli') echo $m.PHP_EOL; else echo htmlspecialchars($m)."<br>"; }
$root = dirname(__DIR__);
$manifestPath = $root . DIRECTORY_SEPARATOR . 'manifest.json';
if (!is_file($manifestPath)) { out("❌ No se encontró manifest.json"); exit(1); }
$data = json_decode(file_get_contents($manifestPath), true);
if (!$data || empty($data['files'])) { out("❌ manifest.json inválido"); exit(1); }
out("Verificando versión: " . ($data['version'] ?? 'sin_version'));
$ok=true;
foreach ($data['files'] as $rel=>$exp){
  $path = $root.DIRECTORY_SEPARATOR.str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $rel);
  $hash = sha256_file_safe($path);
  if ($hash===null){ out("❌ FALTA: $rel"); $ok=false; continue; }
  if ($hash!==$exp){ out("❌ HASH DIFERENTE: $rel"); out("   Esperado: $exp"); out("   Actual:   $hash"); $ok=false; }
  else out("✅ OK: $rel");
}
out($ok? "✅ Todos los archivos coinciden" : "⚠️ Hay diferencias");
exit($ok?0:2);
