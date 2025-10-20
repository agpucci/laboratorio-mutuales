-- DB base (instalación limpia)
CREATE DATABASE IF NOT EXISTS labbio_admin CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE labbio_admin;

-- Usuarios
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) UNIQUE,
  password_hash VARCHAR(255),
  role ENUM('ADMIN','VIEWER') DEFAULT 'ADMIN',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO users (username,password_hash,role)
VALUES ('admin', SHA2('1234',256), 'ADMIN')
ON DUPLICATE KEY UPDATE username=username;

INSERT INTO users (username,password_hash,role)
VALUES ('vista', SHA2('1234',256), 'VIEWER')
ON DUPLICATE KEY UPDATE username=username;

-- Mutuales
CREATE TABLE IF NOT EXISTS mutuales (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL,
  paga_coseguro TINYINT(1) NOT NULL DEFAULT 0,
  detalle_coseguro VARCHAR(255) DEFAULT NULL,
  description TEXT,
  validada TINYINT(1) NOT NULL DEFAULT 0,
  codigos VARCHAR(255) NULL,
  apb ENUM('Paga','No paga','Mitad y mitad','Depende plan') NULL,
  apb_adicional VARCHAR(255) NULL,
  coseguros ENUM('Paga','No paga','Depende plan','Viene en la autorización') NULL,
  coseguros_adicional TEXT NULL,
  token ENUM('Solicitar','No dispone') NULL,
  autorizacion ENUM('Tiene que venir autorizado','Sin autorización','Autorizar luego') NULL,
  elegibilidad ENUM('Validar','No hace falta') NULL,
  elegibilidad_adicional TEXT NULL,
  validez INT NULL,
  planes VARCHAR(255) NULL,
  receta JSON NULL,
  domicilio_cubre ENUM('Cubre','No cubre') NULL,
  domicilio_adicional VARCHAR(255) NULL,
  credencial ENUM('Plástica','Digital','Todas') NULL,
  atencion VARCHAR(255) NULL,
  comentarios TEXT NULL,
  cuit VARCHAR(32) NULL,
  razon_social VARCHAR(255) NULL,
  factura VARCHAR(255) NULL,
  nomenclador VARCHAR(255) NULL,
  domicilio_fact VARCHAR(255) NULL,
  entrega VARCHAR(255) NULL,
  correo VARCHAR(255) NULL,
  telefonos VARCHAR(255) NULL,
  portal VARCHAR(255) NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at DATETIME DEFAULT NULL
) ENGINE=InnoDB;

-- Auditoría
CREATE TABLE IF NOT EXISTS audit_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  table_name VARCHAR(100),
  record_id INT,
  action VARCHAR(50),
  old_value TEXT,
  new_value TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX(user_id),
  INDEX(table_name),
  INDEX(record_id)
) ENGINE=InnoDB;

-- Sugerencias
CREATE TABLE IF NOT EXISTS mutual_suggestions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  mutual_id INT NOT NULL,
  user_id INT NOT NULL,
  content TEXT NOT NULL,
  status ENUM('ABIERTA','RESUELTA','RECHAZADA') NOT NULL DEFAULT 'ABIERTA',
  resolver_id INT NULL,
  resolver_note TEXT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  resolved_at DATETIME NULL,
  INDEX(mutual_id),
  INDEX(status)
) ENGINE=InnoDB;
