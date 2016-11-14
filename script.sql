CREATE DATABASE nodos;

USE nodos;


CREATE TABLE controlador
( 
	id integer primary key auto_increment,
	com   DOUBLE PRECISION,
    valorx    DOUBLE PRECISION,
    valory    DOUBLE PRECISION,
    valorz    DOUBLE PRECISION,
    errorx    DOUBLE PRECISION,
    errory    DOUBLE PRECISION,
    errorz    DOUBLE PRECISION,
    control   DOUBLE PRECISION,
    fecha  DOUBLE PRECISION,
    leido BOOLEAN DEFAULT FALSE
);


CREATE TABLE plataforma
(
    id integer primary key auto_increment,
    ok   DOUBLE PRECISION,
    valorx   DOUBLE PRECISION,
    valory   DOUBLE PRECISION,
    teta   DOUBLE PRECISION,
    q1   DOUBLE PRECISION,
    q2   DOUBLE PRECISION,
    q3   DOUBLE PRECISION,
    q4   DOUBLE PRECISION,
    ftang   DOUBLE PRECISION,
    fnormal   DOUBLE PRECISION,
    fecha  DOUBLE PRECISION,
    leido BOOLEAN DEFAULT FALSE
);

INSERT INTO controlador(com,valorx,valory,valorz,errorx,errory,errorz,control)
VALUES(0,0,0,0,0,0,0,4);
INSERT INTO plataforma(ok,valorx,valory,teta,q1,q2,q3,q4,ftang,fnormal)
VALUES(0,0,0,0,0,0,0,0,0,0);
