CREATE DATABASE ejercicioSwing;
USE ejercicioSwing;

CREATE TABLE estudiante (
  id int(11) NOT NULL AUTO_INCREMENT,
  codigo VARCHAR(15) NOT NULL,
  nombre VARCHAR(45) NOT NULL,
  fecha DATE NOT NULL,
  genero varchar(15) NOT NULL,
  carrera INT NOT NULL,
  intereses VARCHAR (200) ,
  PRIMARY KEY (id),
  FOREIGN KEY (carrera) REFERENCES carreras(id_carrera)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO estudiante (id, codigo, nombre, fecha, genero, carrera, intereses) VALUES
(1, '1', '1', '2018-11-15', '', 0, NULL),
(2, '2', '2', '2018-11-15', '', 0, NULL);


CREATE TABLE  carreras (
  id_carrera INT NOT NULL AUTO_INCREMENT,
  nombre_carrera VARCHAR(25) NOT NULL,
  PRIMARY KEY (id_carrera)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

ALTER TABLE estudiante ADD FOREIGN KEY(carrera) REFERENCES carreras(id_carrera);


INSERT INTO carreras (id_carrera, nombre_carrera) VALUES
(1, 'INGENIERIA SISTEMAS'),
(2, 'INGENIERIA ELECTRONICA'),
(3, 'COMUNICACION SOCIAL'),
(4, 'ADMINISTRACION EMPRESAS'),
(5, 'CONTADURIA'),
(6, 'DISENO GRAFICO');