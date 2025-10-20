USE labbio_admin;

-- Crear usuario de vista
INSERT INTO users (username, password_hash, role)
VALUES ('vista', SHA2('1234',256), 'VIEWER')
ON DUPLICATE KEY UPDATE username=username;

-- Crear tabla de sugerencias (si no existe)
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
