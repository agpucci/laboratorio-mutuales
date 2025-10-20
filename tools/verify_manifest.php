<?php
/**
 * tools/verify_manifest.php
 *
 * Verifica que los archivos listados en manifest.json coincidan (SHA-256)
 * con los presentes en el servidor. Útil después de subir un ZIP patch.
 *
 * Uso (web):   https://tu-dominio/tools/verify_manifest.php
 * Uso (CLI):   php tools/verify_manifest.php
 */
 
function sha256_file_safe($path) {
    if (!is_file($path)) return null;
    return hash_file('sha256', $path);
}

function out($msg) {
    if (PHP_SAPI === 'cli') {
        echo $msg . PHP_EOL;
    } else {
        echo htmlspecialchars($msg) . "<br>";
    }
}

$root = dirname(__DIR__); // carpeta del proyecto (un nivel arriba de /tools)
$manifestPath = $root . DIRECTORY_SEPARATOR . 'manifest.json';

if (!is_file($manifestPath)) {
    out("❌ No se encontró manifest.json en: " . $manifestPath);
    exit(1);
}

$json = file_get_contents($manifestPath);
$data = json_decode($json, true);

if (!$data || empty($data['files']) || !is_array($data['files'])) {
    out("❌ manifest.json inválido o sin sección 'files'.");
    exit(1);
}

$version = $data['version'] ?? 'sin_version';
out("Verificando archivos para versión: " . $version);
$outAllOk = true;

foreach ($data['files'] as $rel => $expected) {
    $path = $root . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $rel);
    $hash = sha256_file_safe($path);
    if ($hash === null) {
        out("❌ FALTA: " . $rel);
        $outAllOk = false;
        continue;
    }
    if ($hash !== $expected) {
        out("❌ HASH DIFERENTE: " . $rel);
        out("   Esperado: " . $expected);
        out("   Actual:   " . $hash);
        $outAllOk = false;
    } else {
        out("✅ OK: " . $rel);
    }
}

if ($outAllOk) {
    out("✅ Todos los archivos coinciden con manifest.json");
    exit(0);
} else {
    out("⚠️  Hay diferencias con manifest.json");
    exit(2);
}
