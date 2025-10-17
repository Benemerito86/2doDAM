DROP DATABASE IF EXISTS GranDescanso;
CREATE DATABASE GranDescanso;

USE GranDescanso;

CREATE TABLE Habitaciones(
	numero INT PRIMARY KEY,
    tipo VARCHAR(50),
    precio_base FLOAT,
    estado_limpieza VARCHAR(50)
);

CREATE TABLE Huespedes(
	email VARCHAR(50) PRIMARY KEY,
    nombre VARCHAR(50),
    documento VARCHAR(50)
);
CREATE TABLE Mantenimiento(
	id INT primary KEY auto_increment,
    habitacion_numero INT,
    FOREIGN KEY (habitacion_numero) REFERENCES Habitaciones(numero),
    inicio DATE,
    fin DATE,
    descripcion VARCHAR(500)
);

CREATE TABLE Reservas(
	id INT PRIMARY KEY auto_increment,
    inicio DATE,
    fin DATE,
    precio_total float,
    estado VARCHAR(50),
	huesped_email VARCHAR(50),
    FOREIGN KEY (huesped_email) REFERENCES Huespedes(email),
    habitacion_numero INT,
    FOREIGN KEY (habitacion_numero) REFERENCES Habitaciones(numero)
);

INSERT INTO Habitaciones (numero, tipo, precio_base, estado_limpieza)
VALUES 
(1, 'Individual', 100.00, 'Limpia'),
(2, 'Doble', 120.00, 'Limpia'),
(3, 'Suite', 200.00, 'Limpia');

INSERT INTO Huespedes (nombre, documento, email)
VALUES 
('Juan Pérez', '12345678A', 'juan@example.com'),
('María López', '98765432B', 'maria@example.com'),
('Carlos Ruiz', '45678901C', 'carlos@example.com');

INSERT INTO Reservas (huesped_email, habitacion_numero, inicio, fin, precio_total, estado) 
VALUES 
('carlos@example.com', 2, '2025-11-01', '2025-11-05', 400.00, 'Confirmada'),
('juan@example.com', 1, '2025-10-20', '2025-10-25', 500.00, 'Pendiente'),
('maria@example.com', 3, '2025-12-10', '2025-12-15', 600.00, 'Cancelada');

INSERT INTO Mantenimiento (habitacion_numero, inicio, fin, descripcion)
VALUES 
(1, '2025-10-26', '2025-10-27', 'Revisión de fontanería'),
(2, '2025-11-06', '2025-11-08', 'Reparación de aire acondicionado'),
(3, '2025-12-16', '2025-12-18', 'Pintura general y mantenimiento eléctrico');

SELECT * FROM Habitaciones;
SELECT * FROM Huespedes;
SELECT * FROM Reservas;
SELECT * FROM Mantenimiento;
