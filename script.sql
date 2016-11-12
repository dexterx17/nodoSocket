CREATE TABLE controlador
( 
	id integer primary key auto_increment,
	c1    DOUBLE PRECISION,
    c2    DOUBLE PRECISION,
    c3    DOUBLE PRECISION,
    c4    DOUBLE PRECISION,
    c5    DOUBLE PRECISION,
    c6    DOUBLE PRECISION,
    c7    DOUBLE PRECISION,
    c8    DOUBLE PRECISION,
    leido BOOLEAN DEFAULT FALSE,
    fecha integer 
);

CREATE TABLE plataforma
(
	id integer primary key auto_increment,
	p1    DOUBLE PRECISION,
    p2    DOUBLE PRECISION,
    p3    DOUBLE PRECISION,
    p4    DOUBLE PRECISION,
    p5    DOUBLE PRECISION,
    p6    DOUBLE PRECISION,
    p7    DOUBLE PRECISION,
    p8    DOUBLE PRECISION,
    p9    DOUBLE PRECISION,
    leido    BOOLEAN DEFAULT FALSE
);

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