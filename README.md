# v1.5.6 — Buscador por nombre (ajustes mínimos no destructivos)

## Cómo aplicar
1. Subí el contenido del ZIP a la raíz del proyecto (debe quedar `tools/` en la raíz).
2. Ejecutá:
   - Web:  `https://TU-DOMINIO/tools/apply_patches.php`
   - CLI:  `php tools/apply_patches.php`
3. Probá `/mutuales?q=OSDE`.
4. Verificá integridad con `/tools/verify_manifest.php` si querés.

El script agrega sin sobrescribir tu código:
- Lee `?q=` en `MutualController::index()` y pasa `q` a la vista.
- Agrega `searchByName()` y `allOrderedByName()` en `Models\Mutual` si faltan.
- Asegura el formulario de búsqueda en `views/mutuales/index.php` y conserva el valor.
