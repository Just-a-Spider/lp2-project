DROP DATABASE sistema_matriculas;
CREATE DATABASE IF NOT EXISTS sistema_matriculas;
USE sistema_matriculas;

-- 1. Tabla Usuario
CREATE TABLE usuario (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombres VARCHAR(100),
    apellidos VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    telefono VARCHAR(20),
    direccion VARCHAR(200),
    password VARCHAR(255),
    username VARCHAR(50),
    tipo ENUM('admin', 'estudiante') DEFAULT 'estudiante'
);

-- 2. Tabla Aula
CREATE TABLE aula (
    id_aula INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    disponibilidad ENUM('disponible', 'ocupado') DEFAULT 'disponible',
    capacidad INT NOT NULL
);

-- 3. Tabla Curso
CREATE TABLE curso (
    id_curso INT PRIMARY KEY AUTO_INCREMENT,
    nombre_curso VARCHAR(100),
    duracion INT, -- Duración en semanas
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    costo DECIMAL(10,2) NOT NULL,
    id_aula INT,
    FOREIGN KEY (id_aula) REFERENCES aula(id_aula) ON DELETE SET NULL
);

-- 4. Tabla Horario
CREATE TABLE horario (
    id_horario INT PRIMARY KEY AUTO_INCREMENT,
    id_curso INT,
    fecha DATE,
    hora TIME,
    dia VARCHAR(20),
    FOREIGN KEY (id_curso) REFERENCES curso(id_curso) ON DELETE CASCADE
);

-- 5. Tabla Pago
CREATE TABLE pago (
    id_pago INT PRIMARY KEY AUTO_INCREMENT,
    id_estudiante INT,
    id_curso INT,
    monto DECIMAL(10,2),
    estado ENUM('pendiente', 'exitoso', 'fallido') DEFAULT 'pendiente',
    codigo_transaccion VARCHAR(100),
    fecha_pago DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_estudiante) REFERENCES usuario(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_curso) REFERENCES curso(id_curso) ON DELETE CASCADE
);

-- 6. Tabla Matricula
CREATE TABLE matricula (
    id_matricula INT PRIMARY KEY AUTO_INCREMENT,
    id_estudiante INT,
    id_curso INT,
    fecha DATE,
    FOREIGN KEY (id_estudiante) REFERENCES usuario(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_curso) REFERENCES curso(id_curso) ON DELETE CASCADE,
    UNIQUE (id_estudiante, id_curso)
);

-- 7. Tabla Asistencia
CREATE TABLE asistencia (
    id_asistencia INT PRIMARY KEY AUTO_INCREMENT,
    id_estudiante INT,
    id_horario INT,
    estado ENUM('presente', 'ausente', 'justificado'),
    FOREIGN KEY (id_estudiante) REFERENCES usuario(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_horario) REFERENCES horario(id_horario) ON DELETE CASCADE
);

-- Datos de prueba

-- Usuario Administrador (contraseña: admin123)
INSERT INTO usuario (nombres, apellidos, email, telefono, direccion, password, username, tipo)
VALUES ('Admin', 'User', 'admin@academia.com', '123456789', 'Calle Falsa 123', '$2y$12$vYmfW7R4pmeTeNQJECgvx.09vkccoFfU1qVHSpE7q14XaXgj7SCn.', 'admin', 'admin');

-- Aulas
INSERT INTO aula (nombre, disponibilidad, capacidad) VALUES ('Aula 101', 'disponible', 30);
INSERT INTO aula (nombre, disponibilidad, capacidad) VALUES ('Aula 102', 'disponible', 25);
INSERT INTO aula (nombre, disponibilidad, capacidad) VALUES ('Aula 103', 'ocupado', 20);