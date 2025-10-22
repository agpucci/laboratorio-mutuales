<?php

ini_set('mostrar_errores', 1);
ini_set('mostrar_errores_de_inicio', 1);
informe_de_errores(E_ALL);

function patch_file($path, callable $transform) {
    if (!is_file($path)) { echo "❌ No existe: $path\n"; return false; }
    $orig = file_get_contents($path);
    $new  = $transform($orig);
    if ($new === $orig) { echo "ℹ️  Sin cambios: $path\n"; return true; }
    if (file_put_contents($path, $new) === false) { echo "❌ No pude escribir: $path\n"; return false; }
    echo "✅ Modificado: $path\n"; return true;
}

$root = dirname(__DIR__);

// Controller: MutualController.php
patch_file($root . "/app/controllers/MutualController.php", function($src){
    if (strpos($src, "__BUSCADOR_Q_BEGIN__") !== false) return $src;
    if (!preg_match("/function\\s+index\\s*\\(\\s*\\)\\s*\\{/m", $src, $m, PREG_OFFSET_CAPTURE)) {
        echo "⚠️  No encontré function index() en MutualController.php\n"; return $src;
    }
    $pos = $m[0][1] + strlen($m[0][0]);
    $inject = <<<'PHP'

        /* __BUSCADOR_Q_BEGIN__ ajustes mínimos */
        $q = isset($_GET['q']) ? trim($_GET['q']) : '';
        if (function_exists('mb_strlen') && mb_strlen($q) > 100) {
            $q = mb_substr($q, 0, 100);
        } else if (strlen($q) > 100) {
            $q = substr($q, 0, 100);
        }

        if (!isset($mutuales)) { $mutuales = []; }
        if (!empty($this->mutualModel)) {
            if ($q !== '' && method_exists($this->mutualModel, 'searchByName')) {
                $mutuales = $this->mutualModel->searchByName($q);
            } elseif (method_exists($this->mutualModel, 'allOrderedByName')) {
                $mutuales = $this->mutualModel->allOrderedByName();
            } elseif (empty($mutuales) && method_exists($this->mutualModel, 'all')) {
                $mutuales = $this->mutualModel->all();
            }
        }
        /* __BUSCADOR_Q_END__ */

PHP;
    $new = substr($src, 0, $pos) . $inject . substr($src, $pos);

    // Inyectar 'q' al array del view si es necesario
    $new = preg_replace_callback(
        "/(\\$this->view\\(\\s*'mutuales\\/index'\\s*,\\s*\\[)(.*?)(\\]\\s*\\)\\s*;)/s",
        function($m){
            $arr = $m[2];
            if (strpos($arr, "'q'") === false && strpos($arr, '"q"') === false) {
                $arr = rtrim($arr);
                if ($arr !== '') $arr .= ", ";
                $arr .= "'q' => \$q";
            }
            return $m[1] . $arr . $m[3];
        },
        $new, 1
    );

    return $new;
});

// Model: Mutual.php
patch_file($root . "/app/models/Mutual.php", function($src){
    if (strpos($src, "function searchByName(") !== false && strpos($src, "function allOrderedByName(") !== false) return $src;
    $insertion = <<<'PHP'

    /* === Ajustes mínimos buscador (no destructivo) === */
    public function allOrderedByName(): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY name ASC";
        $st = $this->pdo->query($sql);
        return $st->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function searchByName(string $q): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE name LIKE :q ORDER BY name ASC";
        $st = $this->pdo->prepare($sql);
        $like = '%' . $q . '%';
        $st->bindParam(':q', $like, \PDO::PARAM_STR);
        $st->execute();
        return $st->fetchAll(\PDO::FETCH_ASSOC);
    }
    /* === Fin ajustes mínimos buscador === */

PHP;
    $end = strrpos($src, "}");
    if ($end === false) return $src;
    return substr($src, 0, $end) . $insertion . substr($src, $end);
});

// View: app/views/mutuales/index.php
patch_file($root . "/app/views/mutuales/index.php", function($src){
    if (strpos($src, 'name="q"') !== false) {
        // Asegurar value con $q si no está
        if (strpos($src, "value=\"<?= htmlspecialchars(\$q") === false) {
            $src = preg_replace(
                '/(<input[^>]*name="q"[^>]*value=")([^"]*)(")/i',
                '\\1<?= htmlspecialchars($q ?? ($_GET[\'q\'] ?? \'\'), ENT_QUOTES, \'UTF-8\') ?>\\3',
                $src, 1
            );
        }
        return $src;
    }
    $form = <<<'HTML'

<form class="mb-3" method="get" action="<?= $appUrl ?>/mutuales">
  <div class="input-group">
    <input class="form-control" type="text" name="q"
           value="<?= htmlspecialchars($q ?? ($_GET['q'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
           placeholder="Buscar por nombre">
    <button class="btn btn-outline-secondary">Buscar</button>
  </div>
</form>

HTML;
    if (preg_match('/<h2[^>]*>.*?<\/h2>/s', $src, $m, PREG_OFFSET_CAPTURE)) {
        $pos = $m[0][1] + strlen($m[0][0]);
        return substr($src, 0, $pos) . "\n" . $form . substr($src, $pos);
    }
    return $form . $src;
});

echo "Terminado.\n";
