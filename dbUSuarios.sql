CREATE TABLE Usuarios (
		id_usuario INT NOT NULL AUTO_INCREMENT,
        nombre varchar(255) NOT NULL,
        apellidos varchar(255) NOT NULL,
        celular varchar(15),
        email varchar(255),
        fotografia varchar(255),
        contrasenia varchar(255),
        tipo_usuario varchar(15) DEFAULT 'basico',
        create_at TIMESTAMP  default CURRENT_TIMESTAMP,
        modifi_at TIMESTAMP  default CURRENT_TIMESTAMP,
        ultimo_login TIMESTAMP,
        estatus int(1) DEFAULT 1,
        PRIMARY KEY (id_usuario)
);