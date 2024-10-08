
-- ELIMINO LA BASE DE DATOS
	DROP DATABASE IF EXISTS neo;
-- CREO LA BASE DE DATOS
	CREATE DATABASE IF NOT EXISTS neo;
-- USO LA BASE
	USE neo;
-- CREANDO TABLAS
	-- roles
		CREATE TABLE IF NOT EXISTS roles(
			ID INT(11) AUTO_INCREMENT PRIMARY KEY,
			TIPO VARCHAR(100) NOT NULL,
			FECHA_CREACION DATETIME NOT NULL,
			FECHA_MODIFICACION DATETIME NULL
		);
	-- usuarios
		CREATE TABLE IF NOT EXISTS usuarios(
			ID INT(11) AUTO_INCREMENT PRIMARY KEY,
			ID_ROL INT(11) NOT NULL,
			USUARIO_ALTA INT(11) NOT NULL,
			NOMBRE VARCHAR(100) NOT NULL,
			APELLIDO VARCHAR(100) NOT NULL,
			DNI VARCHAR(100) NOT NULL UNIQUE,
			CONTRASENIA VARCHAR(120) NOT NULL,
			SEXO VARCHAR(10) NULL,
			BLOQUEAR INT(11) NOT NULL,
			INVISIBLE INT(11) NOT NULL,
			FECHA_NACIMIENTO DATETIME NULL,
			FECHA_CREACION DATETIME NOT NULL,
			FECHA_MODIFICACION DATETIME NULL,
			FOREIGN KEY (ID_ROL) REFERENCES roles (ID)
		);
	-- sesiones
		CREATE TABLE IF NOT EXISTS sesiones(
			ID INT(11) AUTO_INCREMENT PRIMARY KEY,
			ID_USUARIO INT(11) NOT NULL,
			FECHA_INICIO DATETIME NOT NULL,
			FECHA_CIERRE DATETIME NOT NULL,
			FOREIGN KEY (ID_USUARIO) REFERENCES usuarios (ID)
		);
	-- empresas
		CREATE TABLE IF NOT EXISTS empresas(
			ID INT(11) AUTO_INCREMENT PRIMARY KEY,
			RAZONSOCIAL VARCHAR(120) NOT NULL,
			CUIT VARCHAR(100) NOT NULL,
			DOMICILIO VARCHAR(120) NOT NULL,
			PROVINCIA VARCHAR(120) NULL,
			LATITUD FLOAT(11) NULL,
			LONGITUD FLOAT(11) NULL,
			FECHA_CREACION DATETIME NOT NULL,
			FECHA_MODIFICACION DATETIME NULL
		);
	-- proveedores
		CREATE TABLE IF NOT EXISTS proveedores(
			ID INT(11) AUTO_INCREMENT PRIMARY KEY,
			ID_USUARIO INT(11) NOT NULL,
			NOMBRE VARCHAR(100) NOT NULL,
			APELLIDO VARCHAR(100) NOT NULL,
			FECHA_CREACION DATETIME NOT NULL,
			FECHA_MODIFICACION DATETIME NULL,
			FOREIGN KEY (ID_USUARIO) REFERENCES usuarios (ID)
		);
	-- tiposdepersona
		CREATE TABLE IF NOT EXISTS tiposdepersona(
			ID INT(11) AUTO_INCREMENT PRIMARY KEY,
			TIPO VARCHAR(100) NOT NULL, -- juridica, fisica
			FECHA_CREACION DATETIME NULL,
			FECHA_MODIFICACION DATETIME NULL
		);

	-- clientes
		CREATE TABLE IF NOT EXISTS clientes(
			ID INT(11) AUTO_INCREMENT PRIMARY KEY,
			ID_TIPOSDEPERSONA INT(11) DEFAULT 1, -- default 1 representa a persona "fisica"
			ID_USUARIO INT(11) NOT NULL,
			NOMBRE VARCHAR(100) NOT NULL,
			APELLIDO VARCHAR(100) NOT NULL,
			DNI VARCHAR(100) NOT NULL,
			FECHA_CREACION DATETIME NOT NULL,
			FECHA_MODIFICACION DATETIME NULL,
			FOREIGN KEY (ID_TIPOSDEPERSONA) REFERENCES tiposdepersona (ID),
			FOREIGN KEY (ID_USUARIO) REFERENCES usuarios (ID)
		);
	-- contactos
		CREATE TABLE IF NOT EXISTS contactos(
			ID INT(11) AUTO_INCREMENT PRIMARY KEY,
			ID_USUARIO INT(11) NULL,
			ID_EMPRESA INT(11) NULL,
			ID_PROVEEDOR INT(11) NULL,
			ID_CLIENTE INT(11) NULL,
			TELEFONO VARCHAR(120) NULL,
			EMAIL VARCHAR(100) NOT NULL UNIQUE,
			FOREIGN KEY (ID_USUARIO) REFERENCES usuarios (ID),
			FOREIGN KEY (ID_EMPRESA) REFERENCES empresas (ID),
			FOREIGN KEY (ID_PROVEEDOR) REFERENCES proveedores (ID),
			FOREIGN KEY (ID_CLIENTE) REFERENCES clientes (ID)
		);
	-- localidades
		CREATE TABLE IF NOT EXISTS localidades(
			ID INT(11) AUTO_INCREMENT PRIMARY KEY,
			ID_USUARIO INT(11) NULL,
			ID_EMPRESA INT(11) NULL,
			ID_PROVEEDOR INT(11) NULL,
			ID_CLIENTE INT(11) NULL,
			CALLE VARCHAR(120) NULL,
			NUMERO VARCHAR(10) NULL,
			LOCALIDAD VARCHAR(120) NULL,
			PROVINCIA VARCHAR(100) DEFAULT 'Bs.As',
			PAIS VARCHAR(120) DEFAULT 'Argentina',
			ZONA VARCHAR(100) NULL, -- sur, norte,oeste,este
			FOREIGN KEY (ID_USUARIO) REFERENCES usuarios (ID),
			FOREIGN KEY (ID_EMPRESA) REFERENCES empresas (ID),
			FOREIGN KEY (ID_PROVEEDOR) REFERENCES proveedores (ID),
			FOREIGN KEY (ID_CLIENTE) REFERENCES clientes (ID)
		);
	-- categorias
		CREATE TABLE IF NOT EXISTS categorias(
			ID INT(11) AUTO_INCREMENT PRIMARY KEY,
			ID_USUARIO INT(11) NULL, -- para identificar que usuario creo la categoria
			NOMBRE VARCHAR(255) NOT NULL,
			FECHA_CREACION DATETIME NOT NULL,
			FECHA_MODIFICACION DATETIME NULL
		);
	-- productos
		CREATE TABLE IF NOT EXISTS productos(
			ID INT(11) AUTO_INCREMENT PRIMARY KEY,
			ID_USUARIO INT(11) NULL,
			ID_CATEGORIA INT(11) NOT NULL,
			ID_PROVEEDOR INT(11) NOT NULL,
			CODIGO VARCHAR(100) NOT NULL,
			NOMBRE VARCHAR(150) NOT NULL,
			DESCRIPCION VARCHAR(150) NOT NULL,
			PRECIO FLOAT NULL,
			PRECIO_ANTERIOR FLOAT NULL,
			STOCK INT(11) NULL,
			ESTADO ENUM('Activo', 'Inactivo', 'Pendiente', 'Otro') DEFAULT 'Activo',
			INVISIBLE INT(11) NULL DEFAULT 0, -- 0 producto visible / 1 producto oculto
			UNIDAD_MEDIDA ENUM('kg','Lt') DEFAULT 'Kg',
 			FECHA_CREACION DATETIME NULL,
			FECHA_MODIFICACION DATETIME NULL,
			FOREIGN KEY (ID_USUARIO) REFERENCES usuarios (ID),
			FOREIGN KEY (ID_CATEGORIA) REFERENCES categorias (ID),
			FOREIGN KEY (ID_PROVEEDOR) REFERENCES proveedores (ID)
		);

		CREATE TABLE IF NOT EXISTS pedidos(
			ID INT(11) AUTO_INCREMENT PRIMARY KEY,
			ID_USUARIO INT(11) NOT NULL,
			ID_CLIENTE INT(11) NOT NULL,
			TOTAL FLOAT NOT NULL,
			DESCRIPCION VARCHAR(255),
			DIRECCION_ENTREGA VARCHAR(100),
			METODO_PAGO VARCHAR(50),
			ESTADO VARCHAR(20),
			FOREIGN KEY (ID_USUARIO) REFERENCES usuarios (ID)
		);

		/*
		CREATE TABLE IF NOT EXISTS historial_pedidos(
		);
		*/

-- TABLAS SIN RELACIONES "Creadas para la parte visual"
CREATE TABLE IF NOT EXISTS factura(
	ID INT(11) AUTO_INCREMENT PRIMARY KEY,
	ID_USUARIO INT(11) NULL,
	LOGO VARCHAR(255) NOT NULL,
	FACTURA VARCHAR(100) NULL, -- a / b / c
	REMITO INT(11),
	FECHA DATETIME NULL,
	FOREIGN KEY (ID_USUARIO) REFERENCES usuarios (ID)
);

CREATE TABLE IF NOT EXISTS imagenes(
	ID INT(11) AUTO_INCREMENT PRIMARY KEY,
	ID_USUARIO INT(11) NULL,
	ID_PRODUCTO INT(11) NULL,
	FECHA_CREACION DATETIME NULL,
	FECHA_MODIFICACION DATETIME NULL,
	FOREIGN KEY (ID_USUARIO) REFERENCES usuarios (ID),
	FOREIGN KEY (ID_PRODUCTO) REFERENCES productos (ID)
);

-- TABLA CREADA PARA EL SISTEMA
CREATE TABLE IF NOT EXISTS sistema(
	ID INT(11) AUTO_INCREMENT PRIMARY KEY,
	INTENTOS_LOGIN INT(5) NULL,
	BLOQUEAR_LOGIN INT(1) NULL,
	VERSION_ACTUAL INT(11) NULL,
	VERSION_ANTERIOR INT(11) NULL,
	FECHA_CREACION DATETIME NULL,
	FECHA_MODIFICACION DATETIME NULL
);

-- INSERT
	-- roles
		INSERT INTO roles (`ID`,`TIPO`, `FECHA_CREACION`, `FECHA_MODIFICACION`) VALUES
			(1,'Administrador',now(),null),
			(2,'Ventas',now(),null),
			(3,'Supervisor',now(),null);

	-- usuarios
		INSERT INTO `usuarios`(`ID`, `ID_ROL`, `NOMBRE`, `APELLIDO`, `DNI`, `CONTRASENIA`, `SEXO`, `FECHA_NACIMIENTO`, `FECHA_CREACION`, `FECHA_MODIFICACION`) VALUES
		(-1, 1,'softwabot','invisible','10987654321','123456+','M',now(),now(),null);
			-- contactos
			INSERT INTO `contactos`(`ID_USUARIO`, `ID_EMPRESA`, `ID_PROVEEDOR`, `ID_CLIENTE`, `TELEFONO`, `EMAIL`) VALUES
				(-1,null,null,null,'1127122753','softwabot@gmail.com');
			-- localidades
			INSERT INTO `localidades`(`ID_USUARIO`, `ID_EMPRESA`, `ID_PROVEEDOR`, `ID_CLIENTE`, `CALLE`, `NUMERO`, `LOCALIDAD`, `PROVINCIA`, `PAIS`, `ZONA`) VALUES
				(-1,null,null,null,'Alfredo Palacios','9898','Lanus Oeste','Bs As','Argentina','Sur');

	-- tiposdepersona
		INSERT INTO `tiposdepersona`(`ID`, `TIPO`, `FECHA_CREACION`, `FECHA_MODIFICACION`) VALUES
		(1,'Fisica',now(),'null'),
		(2,'Juridica',now(),'null');
	-- clientes
		INSERT INTO `clientes`(`ID`, `ID_TIPOSDEPERSONA`, `ID_USUARIO`, `NOMBRE`, `APELLIDO`, `DNI`, `FECHA_CREACION`, `FECHA_MODIFICACION`) VALUES
		(1,1,-1,'Damian','Balsis','12345678910',now(),null);
	-- categorias
		INSERT INTO `categorias`(`ID`, `ID_USUARIO`, `NOMBRE`, `FECHA_CREACION`, `FECHA_MODIFICACION`) VALUES
			(1,-1,'Pintureria',now(),null),
			(2,-1,'Electricidad',now(),null),
			(3,-1,'Plomeria',now(),null);
	-- proveedores
		INSERT INTO `proveedores`(`ID`, `ID_USUARIO`, `NOMBRE`, `APELLIDO`, `FECHA_CREACION`, `FECHA_MODIFICACION`) VALUES
			(1,-1,'Mariano','Castellano',now(),null);
	-- productos
		INSERT INTO `productos`(`ID`, `ID_USUARIO`, `ID_CATEGORIA`, `ID_PROVEEDOR`, `CODIGO`, `NOMBRE`, `DESCRIPCION`, `PRECIO`, `PRECIO_ANTERIOR`, `STOCK`, `ESTADO`, `INVISIBLE`, `UNIDAD_MEDIDA`, `FECHA_CREACION`, `FECHA_MODIFICACION`) VALUES
			(1,-1, 1, 1, 'A300', 'Pincel','Pincel cerda suave',550.50, 450.00, 12, 'Activo', 0, null, now(), null);

	-- sistema
		INSERT INTO `sistema`(`INTENTOS_LOGIN`, `BLOQUEAR_LOGIN`) VALUES (1,0);
