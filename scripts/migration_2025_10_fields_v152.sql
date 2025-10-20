USE labbio_admin;
ALTER TABLE mutuales
  ADD COLUMN tipo_mutual VARCHAR(64) NULL AFTER name,
  ADD COLUMN portal_prestadores TEXT NULL AFTER correo,
  ADD COLUMN telefono1 VARCHAR(64) NULL,
  ADD COLUMN telefono1_area VARCHAR(64) NULL,
  ADD COLUMN telefono2 VARCHAR(64) NULL,
  ADD COLUMN telefono2_area VARCHAR(64) NULL,
  ADD COLUMN telefono3 VARCHAR(64) NULL,
  ADD COLUMN telefono3_area VARCHAR(64) NULL,
  ADD COLUMN telefono4 VARCHAR(64) NULL,
  ADD COLUMN telefono4_area VARCHAR(64) NULL,
  ADD COLUMN direccion1 VARCHAR(255) NULL,
  ADD COLUMN direccion1_area VARCHAR(64) NULL,
  ADD COLUMN direccion2 VARCHAR(255) NULL,
  ADD COLUMN direccion2_area VARCHAR(64) NULL;
-- columnas antiguas (portal, portal_acceso, domicilio_fact, email_facturacion) se mantienen para compatibilidad
