/*******************************************************************************
NO MODIFIQUE ESTE FICHERO, NO TENDRÁ EFECTO
********************************************************************************/
/*******************************************************************************
Gestión de distribuidora
Description: Creates and populates the DB.
DB Server: Sqlite
Author: Juan Carlos Rodriguez-del-Pino
License: GPL3
********************************************************************************/
PRAGMA foreign_keys = ON;
/*******************************************************************************
   Drop Tables
********************************************************************************/
DROP TABLE IF EXISTS [usuarios];
DROP TABLE IF EXISTS [bebidas];
DROP TABLE IF EXISTS [pedidos];
DROP TABLE IF EXISTS [lineaspedidos];

/*******************************************************************************
   Create Tables
********************************************************************************/
CREATE TABLE [usuarios]
(
    [id] INTEGER PRIMARY KEY,
    [usuario] NVARCHAR(20) NOT NULL,
    [clave] NVARCHAR(32) NOT NULL,
    [nombre] NVARCHAR(200) DEFAULT '',
    [tipo] INTEGER DEFAULT 2,
    [poblacion] NVARCHAR(200) DEFAULT '',
    [direccion] NVARCHAR(200) DEFAULT ''
);
/*
tipo = 1 => administrador
tipo = 2 => cliente
tipo = 3 => repartidor
*/
CREATE UNIQUE INDEX IF NOT EXISTS [indexusuario] on [usuarios] ([usuario]);

CREATE TABLE [bebidas]
(
    [id] INTEGER PRIMARY KEY,
    [marca] NVARCHAR(60),
    [stock] INTEGER,
    [PVP] DECIMAL(10,2)
);

CREATE TABLE [pedidos]
(
    [id] INTEGER PRIMARY KEY,
    [idcliente] INTEGER NOT NULL,
    [poblacionentrega] NVARCHAR(200) DEFAULT '',
    [direccionentrega] NVARCHAR(200) DEFAULT '',
    [horacreacion] INTEGER NOT NULL,
    [idrepartidor] INTEGER DEFAULT NULL,
    [horaasignacion] INTEGER,
    [horareparto] INTEGER DEFAULT 0,
    [horaentrega] INTEGER DEFAULT 0,
    [PVP] INTEGER DEFAULT 0,
    FOREIGN KEY ([idcliente]) REFERENCES [usuarios] ([id]),
    FOREIGN KEY ([idrepartidor]) REFERENCES [usuarios] ([id])
);

CREATE TABLE [lineaspedido]
(
    [id] INTEGER PRIMARY KEY,
    [idpedido] INTEGER  NOT NULL,
    [idbebida] INTEGER  NOT NULL,
    [unidades] INTEGER  DEFAULT 0,
    [PVP] INTEGER NOT NULL,
    FOREIGN KEY ([idpedido]) REFERENCES [pedidos] ([id]) 
		ON DELETE CASCADE,
    FOREIGN KEY ([idbebida]) REFERENCES [bebidas] ([id])
);

CREATE UNIQUE INDEX IF NOT EXISTS [indexlineaspedido] on [lineaspedido] ([idpedido],[idbebida]);


/*******************************************************************************
   Populate Tables
********************************************************************************/
INSERT INTO [usuarios] ([usuario], [clave], [nombre], [tipo])
     VALUES ('adm', 'c4ca4238a0b923820dcc509a6f75849b', 'El Manda Más', 1);
INSERT INTO [usuarios] ([usuario], [clave], [nombre], [tipo], [poblacion], [direccion])
     VALUES ('cli1', 'c81e728d9d4c2f636f067f89cc14862c', 'Bar Vaso Obrero', 2, 'Arucas', 'Calle Mayor Nº 33');
INSERT INTO [usuarios] ([usuario], [clave], [nombre], [tipo], [poblacion], [direccion])
     VALUES ('cli2', 'eccbc87e4b5ce2fe28308fd9f2a7baf3', 'Restaurante El Almorzador', 2, 'Telde', 'San Greorio Nº 44');
INSERT INTO [usuarios] ([usuario], [clave], [nombre], [tipo])
     VALUES ('rep1', 'a87ff679a2f3e71d9181a67b7542122c', 'Perengano de Na', 3);
INSERT INTO [usuarios] ([usuario], [clave], [nombre], [tipo])
     VALUES ('rep2', 'e4da3b7fbbce2345d7772b0674a318d5', 'Hiperdimos', 3);

INSERT INTO [bebidas] ([marca], [stock], [PVP]) VALUES ('Agua artificial', 12000, 1.05);
INSERT INTO [bebidas] ([marca], [stock], [PVP]) VALUES ('Poca Cola', 10000, 1.85);
INSERT INTO [bebidas] ([marca], [stock], [PVP]) VALUES ('Falta Naranja', 100200, 1.75);
INSERT INTO [bebidas] ([marca], [stock], [PVP]) VALUES ('Six Up', 102500, 1.60);
INSERT INTO [bebidas] ([marca], [stock], [PVP]) VALUES ('Cerveza Subtropical', 30234, 1.90);
INSERT INTO [bebidas] ([marca], [stock], [PVP]) VALUES ('Vino Pinto', 9008, 5.35);
INSERT INTO [bebidas] ([marca], [stock], [PVP]) VALUES ('Vino Azul', 3350, 10.75);

INSERT INTO [pedidos] ([idcliente], [horacreacion], [PVP]) VALUES (2, 1487755441, 952.5);
INSERT INTO [lineaspedido] ([idpedido], [idbebida], [unidades], [PVP])
      VALUES (1, 1, 300, 1.05);
INSERT INTO [lineaspedido] ([idpedido], [idbebida], [unidades], [PVP])
      VALUES (1, 2, 250, 1.85);
INSERT INTO [lineaspedido] ([idpedido], [idbebida], [unidades], [PVP])
      VALUES (1, 3, 100, 1.75);
INSERT INTO [pedidos] ([idcliente], [horacreacion], [PVP]) VALUES (3, 1487758501, 2982.5);
INSERT INTO [lineaspedido] ([idpedido], [idbebida], [unidades], [PVP])
      VALUES (2, 5, 300, 1.90);
INSERT INTO [lineaspedido] ([idpedido], [idbebida], [unidades], [PVP])
      VALUES (2, 6, 250, 5.35);
INSERT INTO [lineaspedido] ([idpedido], [idbebida], [unidades], [PVP])
      VALUES (2, 7, 100, 10.75);
