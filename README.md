
LB Pellegrini - Sistema Mutuales (PHP + MySQL)
=============================================

Instrucciones de instalación:
1. Subir la carpeta al hosting (por ejemplo en /home/usuario/lab-mutuales).
2. Importar `scripts/schema.sql` en MySQL (phpMyAdmin). Esto creará la BD labbio_admin y las tablas.
3. Ajustar `config/config.php` si tus credenciales de MySQL difieren.
4. Acceder a: http://admin.lbpellegrini.com.ar/ (será redirigido a /public/ por .htaccess)
   - Usuario: admin
   - Contraseña: 1234  (¡cambiar inmediatamente!)

Seguridad:
- El hash de contraseñas usa PBKDF2-HMAC-SHA256 con salt por usuario y un pepper global en config/config.php.
- Cambiar el valor PEPPER en config/config.php después de instalar.
