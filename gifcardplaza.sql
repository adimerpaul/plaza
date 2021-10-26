-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-10-2021 a las 23:43:44
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gifcardplaza`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anulartarjeta`
--

CREATE TABLE `anulartarjeta` (
  `AnulartarjetaID` int(11) NOT NULL,
  `Fecha_anular` date DEFAULT NULL,
  `Hora_anular` time DEFAULT NULL,
  `Concepto_anular` varchar(255) DEFAULT NULL,
  `Doc_anular` varchar(255) DEFAULT NULL,
  `Saldo_tarjeta_anulada` int(11) DEFAULT NULL,
  `N_reciboa` varchar(255) DEFAULT NULL,
  `TarjetaID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargartarjeta`
--

CREATE TABLE `cargartarjeta` (
  `CargartarjetaID` int(11) NOT NULL,
  `Fecha_carga` date DEFAULT NULL,
  `Hora_carga` time DEFAULT NULL,
  `Monto_recarga` int(11) DEFAULT NULL,
  `Porcentaje_beneficiario` double(10,2) DEFAULT NULL,
  `N_recibor` varchar(255) DEFAULT NULL,
  `Lugar_recibor` varchar(255) DEFAULT NULL,
  `TarjetaID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cargartarjeta`
--

INSERT INTO `cargartarjeta` (`CargartarjetaID`, `Fecha_carga`, `Hora_carga`, `Monto_recarga`, `Porcentaje_beneficiario`, `N_recibor`, `Lugar_recibor`, `TarjetaID`) VALUES
(17, '2021-10-31', '21:39:00', 10, 10.00, '1', 'Aqui', 5),
(18, '2021-10-13', '15:50:00', 10, 10.00, '2', 'Aqui', 5),
(19, '2021-10-31', '09:25:00', 10, 10.00, '3', 'Aqui', 5),
(20, '2021-10-06', '08:28:00', 10, 10.00, '4', 'Aqui', 5),
(21, '2021-10-06', '08:29:00', 10, 10.00, '5', 'Aqui', 7),
(22, '2021-10-06', '08:29:00', 10, 10.00, '6', 'Aqui', 7),
(23, '2021-10-06', '10:05:00', 20, 20.00, '7', 'candy bar', 5),
(24, '2021-10-06', '10:32:00', 24, 20.00, '8', 'candy bar', 8),
(25, '2021-10-06', '16:10:00', 120, 20.00, '9', 'BOLETERIA', 9),
(26, '2021-10-06', '16:18:00', 200, 0.00, '10', 'BOLETERIA', 5),
(27, '2021-10-07', '17:01:30', 120, 20.00, '11', 'BOLETERIA', 9),
(28, '2021-10-08', '13:20:57', 24, 20.00, '12', 'BOLETERIA', 6),
(29, '2021-10-08', '13:25:34', 240, 20.00, '13', 'BOLETERIA', 6),
(30, '2021-10-10', '18:00:30', 120, 20.00, '14', 'BOLETERIA', 9),
(31, '2021-10-14', '17:47:23', 84, 0.00, '15', 'BOLETERIA', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `Nombre` varchar(255) DEFAULT NULL,
  `Apellido` varchar(255) DEFAULT NULL,
  `Cel` varchar(255) DEFAULT NULL,
  `Ci_nit` varchar(255) DEFAULT NULL,
  `Direccion` varchar(255) DEFAULT NULL,
  `Fecha_nac` date DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `Nombre`, `Apellido`, `Cel`, `Ci_nit`, `Direccion`, `Fecha_nac`, `Email`, `Img`) VALUES
(11, 'Eddy Carlos ', 'Plaza Garcia', '78610570', '3520226', 'oruro', '1975-05-23', 'algo@gmail.om', NULL),
(12, 'Carlos Javier ', 'Espinoza Mamani ', '72483447', '7277735', 'oruro', '1989-11-03', 'cjespibozam7@gmail.com', NULL),
(13, 'Dennilzón Adrián', 'Choque Chanez', '65430762', '65430762', 'oruro', '1996-10-25', 'adrianchoque857@gmail.com', NULL),
(14, 'Jacquelin Tatiana', 'Colque Aro', '69600260', '7398770', 'oruro', '1969-12-31', 'tati28ab@gmail.com', NULL),
(15, 'Roberto Kevin', 'Martinez Villegas', '65415389', '7336001', 'oruro', '1997-04-17', 'robertokevinmartinezvillegas@gmail.com', NULL),
(16, 'Andree Enrique', 'Espinoza mamani', '65408201', '7277736', 'oruro', '1969-12-31', 'cjespinozam7@gmail.com', NULL),
(17, 'Roberto Jaime', 'Zubieta Orihuela', '76142243', '5721136', 'oruro', '1985-02-16', 'rzubieta@gmail.com', NULL),
(18, 'Karol Silvana', 'Vera Ruiz', '60423382', '7359532', 'oruro', '1969-12-31', '7359532@gmail.com', NULL),
(19, 'Álvaro Cristhian ', 'Pereira Soto ', '71107629', '7347276', 'oruro', '1993-11-22', 'cristhianalvaro22@gmail.com', NULL),
(20, 'Marcelo Jorge', 'Gonzáles Del Castillo', '78611101', '5068681', 'oruro', '1985-03-12', 'gonzalesdelcastillomarcelo@hotmail.com', NULL),
(21, 'Reyna Alejandra', 'Quisbert Morales', '61826080', '7372995', 'oruro', '1996-10-28', 'reyalequismor936@gmail.com', NULL),
(22, 'Milenka Jacqueline', 'Meave Parra', '79405225', '7362901', 'oruro', '1994-09-22', 'mily22cita@gmail.com', NULL),
(23, 'Kevin Raúl ', 'Rodríguez Villacorta', '70434750', '5065381 or', 'oruro', '1995-04-19', 'kerovy530@gmail.com', NULL),
(24, 'Albina ', 'Villacorta Ojeda', '77146882', '3053241 or', 'ORURO', '1965-06-03', 'kerovy530@gmail.com', NULL),
(25, 'Alex Alejandro ', 'Crispin contreras', '65828328', '7407201', 'ORURO', '1998-09-13', 'alexcrispin087@gmail.com', NULL),
(26, 'José Alfredo', 'Flores Troncoso', '77145799', '12549368', 'ORURO', '2002-12-26', 'florestroncosojosealfredo@gmail.com', NULL),
(27, 'William Mucio', 'Achabal Villalpando', '75402638', '7311222', 'ORURO', '1969-12-31', 'ofeliavm69@gmail.com', NULL),
(28, 'Paola Jazmin ', 'Atora Muñoz', '72460534', '12549352', 'ORURO', '1999-12-19', 'paojazminangell@gmail.com', NULL),
(29, 'Yulian mario', 'Williams Ramírez', '65407662', '9972519lp', 'ORURO', '1997-12-02', 'yulianwilliams@gmail.com', NULL),
(30, 'Luis Diego', 'Condarco Navarro', '67222944', '7285329', 'ORURO', '1969-12-31', 'condarcoluis05ldcn@gmail.com', NULL),
(31, 'KAREN', 'ROSALES VILLARROEL', '77150045', '7377084', 'ORURO', '1992-03-30', 'rosalesvillarroelkaren@gmail.com', NULL),
(32, 'Pablo Sebastian ', 'Vega Bellot ', '72431973', '7342865 ', 'ORURO', '1969-12-31', 'pvegabellot17@gmail.com', NULL),
(33, 'Joel Armando ', 'Ojeda Hurtado ', '76145308', '7418071 ', 'ORURO', '2000-07-29', 'jaoh444@gmail.com', NULL),
(34, 'José Manuel', 'Zenteno Espinoza ', '77144609', '7422244', 'ORURO', '1996-04-02', 'tobiwanke12@gmail.com', NULL),
(35, 'Diego Dalecio ', 'Ortega Morales ', '68283174', '7367544', 'ORURO', '2000-03-11', 'diego321bien@gmail.com', NULL),
(36, 'Adelaida ', 'Choquetupa Huanca', '75709919', '7392328', 'ORURO', '2001-01-18', 'achoquetupa-es@udabol.edu.bo', NULL),
(37, 'Lucero', 'Vargas anavi', '77861638', '12551996', 'ORURO', '1969-12-31', 'luceroanavi1255@gmail.com', NULL),
(38, 'Ariel Simón ', 'Flores Troncoso', '75429805', '7321086', 'ORURO', '1997-08-12', 'arielsimonflorestroncoso@gmail.com', NULL),
(39, 'Katherine ', 'Crispin Colque ', '76159675', '7410039', 'ORURO', '2000-02-17', 'katheswiftcris@gmail.com', NULL),
(40, 'Rodrigo Alberto', 'Corrales Ortiz', '68322800', '7423494', 'ORURO', '2002-11-07', 'rodrigoalbertocorralesortiz@gmail.com', NULL),
(41, 'SILVIA', 'MARCA DIAZ', '77148571', '7328319', 'ORURO', '1999-02-19', 'silviamarcadiaz99@gmail.com', NULL),
(42, 'Paulo Andres', 'Paco Torrico', '65407525', '7391118', 'ORURO', '1999-07-31', 'andy.exe.apt@gmail.com', NULL),
(43, 'Gonzalo', 'Copa Pastor', '72342784', '5067630', 'ORURO', '1996-12-29', 'rodriguespepo@gmail.com', NULL),
(44, 'Gonzalo ', 'Copa Barrios', '71859988', '3552551', 'ORURO', '1975-03-14', 'pasokevin466@gmail.com', NULL),
(45, 'Tito', 'Ticona  Olivera', '78610573', '4306168 LP', 'ORURO', '1973-06-28', 'titoticona.73@gmail.com', NULL),
(46, 'Mery Ruth', 'Pastor Velasco ', '72468404', '3546122', 'ORURO', '1975-07-10', 'putasoisaac@gmail.com', NULL),
(47, 'Juan Carlos ', 'García Siles ', '70421618', '4056766 Or', 'ORURO', '1982-07-14', 'juanqui.kq@gmail.com', NULL),
(48, 'Rosalba Marlene ', 'Hidalgo Peñafiel ', '71889665', '3548921', 'ORURO', '1978-02-20', 'rosmarhipe@gmail.com', NULL),
(49, 'Rodrigo Tomás', 'Escalante Arias ', '72342037', '5738420', 'ORURO', '1988-05-13', 'rodrigoesc2@gmail.com', NULL),
(50, 'Daniela mishell', 'Peñaylillo Tapia', '76152380', '15302867', 'ORURO', '2000-06-22', 'danielats38@gmail.com', NULL),
(51, 'LIZBETH HEIDI', 'CHOQUE SOLIZ', '69576899', '7419827', 'ORURO', '2000-09-24', 'lizbethheidichoquesoliz@gmail.com', NULL),
(52, 'Alvaro Leonel ', 'Choque Achacollo ', '72355654', '7381267', 'ORURO', '1994-01-21', 'rleo92090@gmail.com', NULL),
(53, 'Javier', 'Canaviri Espinoza', '76150552', '7311074', 'ORURO', '1999-12-02', 'byjavidj@gmail.com', NULL),
(54, 'Elvia Wendy', 'Jacinto Coca ', '68282013', '4075322', 'ORURO', '1987-06-20', 'wendybel.coca@gmail.com', NULL),
(55, 'Cecilia', 'Blacut Condori ', '70437136', '4068322 Or', 'ORURO', '1983-01-25', 'cecibc83@gmail.com', NULL),
(56, 'Axel Rodrigo ', 'Pita Jacinto ', '71180037', '13189129', 'ORURO', '2006-11-20', 'axelrodrigopita@gmail.com', NULL),
(57, 'Juan Abel', 'Calizaya Tarqui', '71888855', '7338602', 'ORURO', '2002-10-29', 'abelxct@gmail.com', NULL),
(58, 'Ronald ', 'Quispe Flores', '60410135', '5742064 Or ', 'ORURO', '1985-08-26', 'ronald_7champions@hotmail.com', NULL),
(59, 'Kelly Mercedez', 'Atanacio Torrez', '72343985', '7319559', 'ORURO', '1995-09-17', 'atanaciotorrez.kell@gmail.com', NULL),
(60, 'Melany Andrea', 'Rivera Ojeda', '75701235', '7356321', 'ORURO', '1996-12-15', 'mel123andre@gmail.com', NULL),
(61, 'Jheymi', 'Choque Pacheco ', '73841623', '7345330', 'ORURO', '1992-04-16', 'jhemcp@gmail.com', NULL),
(62, 'Mauricio Jesús', 'Llanque Colque', '75707202', '7347396', 'ORURO', '1995-09-22', 'mro3do.ll@gmail.com', NULL),
(63, 'Josue', 'Cadena Choque ', '75414663', '7364389', 'ORURO', '1994-03-05', 'josuesito.4007@gmail.com', NULL),
(64, 'Marcelo ', 'Rodriguez Suarez ', '79406520', '7374504', 'ORURO', '1994-06-20', 'mrodriguezs2015@hotmail.com', NULL),
(65, 'Elizangela', 'Avilez Morales', '70434305', '5758203', 'ORURO', '1984-10-21', 'elizangelaam84@hotmail.com', NULL),
(66, 'Selena', 'Lopez Dorado', '65415235', '7367321', 'ORURO', '2001-09-24', 'selenalopezdorado094@gmail.com', NULL),
(67, 'Mayra Alejandra ', 'Ochoa Flores ', '61838638', '7289858', 'ORURO', '1998-07-24', 'mayhula1@gmail.com', NULL),
(68, 'Arnold Miguel', 'Rios Pacheco', '68304503', '4054646', 'ORURO', '1985-09-20', 'asrath.rios@gmail.com', NULL),
(69, 'Samuel Josué', 'Salvatierra Caro', '60402547', '7344209', 'ORURO', '1998-03-30', 'ssalvatierracaro1@gmail.com', NULL),
(70, 'Paul Douglas', 'Soliz Julián', '74461320', '7387611', 'ORURO', '1999-10-03', 'dsoliz354@gmail.com', NULL),
(71, 'Alvaro Hector', 'Simón Mollo', '72451562', '7351138', 'ORURO', '2002-04-05', 'alvarohectorsimonmollo@gmail.com', NULL),
(72, 'Edwin Cristian', 'Velasquez Gutiérrez', '68291585', '7334547', 'ORURO', '1999-09-02', 'edcristianvelasquezgutierrez@gmail.com', NULL),
(73, 'Cindy Michelle', 'Sejas Ascarraga', '75410028', '5764079', 'ORURO', '1987-06-20', 'cindysejasascarraga@gmail.com', NULL),
(74, 'Cristian Edwin ', 'Beltrán Ríos ', '70433335', '5741048', 'ORURO', '1986-02-09', 'wipobeltran@gmail.com', NULL),
(75, 'Paul Guillermo ', 'Sejas Ascarraga', '67203947', '5773293 ', 'ORURO', '1988-11-29', 'paul.estrelladelsur@gmail.com', NULL),
(76, 'INTI MARCELO', 'PEÑARANDA COCA', '72476914', '5770348', 'ORURO', '1997-05-14', 'tineli97@gmail.com', NULL),
(77, 'Daniela Adriana', 'Córdova Choque', '60405333', '9341687', 'ORURO', '2001-06-24', 'daniadriana1212@gmail.com', NULL),
(78, 'Joselin Marcia', 'Velasquez lopez', '70435933', '7362892', 'ORURO', '1996-06-23', 'jvelasquez-es1@udabol.edu.bo', NULL),
(79, 'HENRY MANUEL ', 'MAMANI HUARACHI ', '73818845', '7367513 ', 'ORURO', '2003-07-19', 'mamanihuarachihenry0@gmail.com', NULL),
(80, 'Fidel Alexander', 'Vasquez Huanca', '75418705', '7298082', 'ORURO', '1997-06-03', 'alex.paola.vasquezcr7@gmail.com', NULL),
(81, 'Brayan Alvert', 'Poma Villca', '61832411', '13464307', 'ORURO', '1998-03-09', 'b.a.pyexo@gmail.com', NULL),
(82, 'Roxana ', 'Huarachi Villa', '75700461', '3520195', 'ORURO', '1974-05-20', 'roxanahuarachivilla@gmail.com', NULL),
(83, 'Ezequiel Felipe ', 'Vázquez Huanca ', '72318631', '7405795', 'ORURO', '2004-09-22', 'alexlopizza23@gamil.com', NULL),
(84, 'Daysi Jeovana ', 'Colque Cruz', '65409615', '7323417', 'ORURO', '2000-10-09', 'colquecruzdaysijeovana@gmail.com', NULL),
(85, 'ADDA BELÉN', 'ACHO RIVERA', '75711979', '7375944', 'ORURO', '2000-06-28', 'achoadda@gmail.com', NULL),
(86, 'Daysi Jeovana ', 'Colque Cruz', '65409615', '7323417', 'ORURO', '2000-10-09', 'colquecruzdaysijeovana@gmail.com', NULL),
(87, 'Jose Fernando', 'Pinaya', '76156159', '7422801', 'ORURO', '1997-04-18', 'ferplus740@gmail.com', NULL),
(88, 'Luisa Karen', 'Ramirez Llampa', '72316231', '7371055', 'ORURO', '1996-03-29', 'luisakramirez@gmail.com', NULL),
(89, 'Andrés  Jhonny', 'Manzaneda Adrian', '75707714', '7367629 ', 'ORURO', '1996-07-05', 'andresmanzaneda18@gmail.com', NULL),
(90, 'Graciela Génesis', 'Carpio Iturricha', '77149148', '12741850', 'ORURO', '1996-12-13', 'genesiscarpio060@gmail.com', NULL),
(91, 'Mathias Alejandro', 'Delgado Sanchez', '70415725', '13156784', 'ORURO', '2007-09-01', 'mathiasdelgado24@gmail.com', NULL),
(92, 'Jhovany Alvaro ', 'Paco Pacolla', '65413602', '7270560', 'ORURO', '1995-11-28', 'pacoalvarjhovany@gmail.com', NULL),
(93, 'Susana', 'Garnica Fernández ', '72472858', '7270162', 'ORURO', '1990-09-20', 'susanagarnica567@gmail.com', NULL),
(94, 'Alexander', 'Villegas Chambi', '75425088', '7388599', 'ORURO', '1994-09-21', 'alexanderkratos007@gmail.com', NULL),
(95, 'Gersom Adalid ', 'Bricher Lainez', '78603077', '7282032 ', 'ORURO', '1989-07-01', 'BriLain10@GMail.Com', NULL),
(96, 'Andrés Arturo', 'Delgado Sánchez', '70423333', '13156783', 'ORURO', '1969-12-31', 'andresdelgadosanchez25@gmail.com', NULL),
(97, 'Alan Beymar', 'Mendoza Yucra', '75411386', '5758986 ', 'ORURO', '2002-11-21', 'alan13.am45@gmail.com', NULL),
(98, 'Melania Jackeline', 'Ortiz Huayta', '72470704', '3521152', 'ORURO', '1975-05-15', 'lunadecristal001@gmail.com', NULL),
(99, 'ALBERTO FRANCISCO', 'Corrales Villanueva', '71185939', '3515598', 'ORURO', '1974-07-09', 'alfracovil@gmail.com', NULL),
(100, 'Patricia', 'Guzman Patiño', '65402456', '7329671', 'ORURO', '2000-07-25', 'patisita09@gmail.com', NULL),
(101, 'SAMUEL', 'ROSEL MUÑOZ', '62808933', '7333917', 'ORURO', '2000-09-08', 'sroselmuoz@gmail.com', NULL),
(102, 'María Claudia', 'Delgadillo Corrales', '72488277', '5773851', 'ORURO', '1995-07-10', 'delgadillocorralesmariaclaudia@gmail.com', NULL),
(103, 'Rosario Vanessa', 'Ticona Flores', '75704569', '7394457', 'ORURO', '1992-10-29', 'ticonavanessa140@gmail.com', NULL),
(104, 'Carlos Franz', 'Arequipa Salas', '74102094', '7379324', 'ORURO', '1993-03-09', 'carloslevy_7@gmsil.com', NULL),
(105, 'Marina ', 'Fernández Irahola', '73839400', '3060609', 'ORURO', '1966-06-18', 'marinafernandezirahola@gmail.com', NULL),
(106, 'ALEJANDRA ', 'VIÑOLA FERNÁNDEZ', '70417237', '5769852', 'ORURO', '1988-03-08', 'aleben122015@gmail.com', NULL),
(107, 'Romeo Alejandro', 'Calizaya Oczachoque', '79409933', '7294175', 'ORURO', '1993-03-18', 'zodiaco1815@gmail.com', NULL),
(108, 'Percy Alberto', 'Yavé Fernández', '67221965', '7313439', 'ORURO', '2001-11-13', 'yavepercy@gmail.com', NULL),
(109, 'Kevin Luis', 'Ramirez Choque', '74460655', '7370530', 'ORURO', '2001-10-04', 'kevinmusico1pianista@gmail.com', NULL),
(110, 'Rodrigo', 'Aramayo Mercado', '60411101', '5762653', 'ORURO', '1988-03-12', 'rcjam.103@gmail.com', NULL),
(111, 'Ronald', 'Morochi Paredez', '72304498', '7356813', 'ORURO', '2002-09-12', 'paredezronald54@gmail.com', NULL),
(112, 'Velka Brita', 'Navarro Claros', '72005303', '5064533', 'ORURO', '1986-12-16', 'cabri_1@hotmail.com', NULL),
(113, 'Claudia Mabel ', 'Jimenez Irahola', '78607538', '7302632', 'ORURO', '1989-04-06', 'jhonnatan.arely060489@gmail.com', NULL),
(114, 'Marialy Jhaziel', 'Cossio Riveros', '70430260', '7294469', 'ORURO', '2003-08-21', 'maryjhazita@gmail.com', NULL),
(115, 'Gary', 'Quezada Mendez', '70422556', '7290827', 'ORURO', '1993-11-22', 'garyquezada.2211@gmail.com', NULL),
(116, 'ROLANDO ', 'YUCRA MAMANI ', '79427725', '5728755', 'ORURO', '1984-06-04', 'ryucra@bancosol.com.bo', NULL),
(117, ' Miguel Alexander ', 'Muñoz Arratia', '61814656', '7293332', 'ORURO', '1996-12-16', 'alex96dic@gmail.com', NULL),
(118, 'Erick Gualberto ', 'Rivera Ramirez', '69601932', '5767953', 'ORURO', '1989-10-20', 'Erickriveraramirez40@gmail.com', NULL),
(119, 'Jhosemar Miguel', 'Condori Andia', '72491711', '5741967', 'ORURO', '1987-08-07', 'mickyjhos23@gmail.com', NULL),
(120, 'Liz Gabriela', 'Quispe Benítez', '72454667', '7264796', 'ORURO', '1988-08-10', 'gabeliz177@gmail.com', NULL),
(121, 'Maricela Magdaly', 'Yucra Paredes', '79404978', '6634181', 'ORURO', '1987-07-06', 'maricela.yucra@gmail.com', NULL),
(122, 'Estefani Michel ', 'Chungara Valencia ', '74479258', '7367698', 'ORURO', '1995-03-10', 'estefy.18.yo@gmail.com', NULL),
(123, 'Roger Alan', 'Medina Chambi', '79427662', '5739508', 'ORURO', '1989-03-07', 'medina.roger05@gmail.com', NULL),
(124, 'Marvin Adhemar', 'Choque Mamani', '72838566', '7360804', 'ORURO', '1997-08-27', 'adhemar688@gmail.com', NULL),
(125, 'Benjamin', 'Ramos Calizaya', '74225242', '10542283', 'ORURO', '1998-10-25', 'benjamincalizaya2510@gmail.com', NULL),
(126, 'Stefany Sharon ', 'Colodro Huerta ', '73830506', '7998868', 'ORURO', '2000-06-10', 'STEFY.SSCH20@GMAIL.COM', NULL),
(127, 'Ivi Aida', 'Romero Cama', '72471764', '7277027', 'ORURO', '1994-03-12', 'iviaidaromerocama@gmail.com', NULL),
(128, 'Lilian', 'Apata Mamani', '71849713', '5765693', 'ORURO', '1985-11-27', 'apatamamanililian@gmail.com', NULL),
(129, 'Rolando', 'Aquino Gutierrez', '61825444', '5755961', 'ORURO', '1986-05-31', 'rolandoaquino654@gmail.com', NULL),
(130, 'franz pablo', 'mamani encinas', '71857668', '7425790', 'ORURO', '1994-03-03', 'franchescopunkrock@gmail.com', NULL),
(131, 'Valquiria Judith ', 'Martínez Ayala ', '73820296', '7359469', 'ORURO', '1994-01-03', 'valki.kim93@gmail.com', NULL),
(132, 'Monica Andrea', 'Rodriguez Coca', '71108840', '7355212', 'ORURO', '1995-10-11', 'monikita0777@gmal.com', NULL),
(133, 'Osmar ', 'Porcel', '70419539', '8551455', 'ORURO', '1990-08-21', 'osmarporcel1@gmail.com', NULL),
(134, 'Favio Daniel', 'Yugar Caceres', '75428090', '5723192', 'ORURO', '1983-08-18', 'danielyugar69@gmail.com', NULL),
(135, 'Isabel', 'Choque Gutiérrez', '76157671', '7374887', 'ORURO', '1992-05-11', 'chavi132.2303@gmail.com', NULL),
(136, 'Marcos antonio', 'Mallcu garcia', '68306869', '7338018', 'ORURO', '1993-10-28', 'mallcugarciamarcosantonio@fmail.com', NULL),
(137, 'Katia Olga', 'Bernuy Malla', '70426192', '14670927', 'ORURO', '1990-05-26', 'bernuymallak@gmail.com', NULL),
(138, 'Lady Lorena', 'Mareño Mamani', '72481500', '3522197', 'ORURO', '1984-04-14', 'lorenamareno34@gmail.com', NULL),
(139, 'Ernesto Norman', 'Choque López', '62787806', '8995032', 'ORURO', '2001-05-03', 'dj.mr.rabbit.xd@gmail.com', NULL),
(140, 'Marcos antonio', 'Mallcu garcia', '68306869', '7338018', 'ORURO', '1993-10-28', 'mallcugarciamarcosantonio@gmail.com', NULL),
(141, 'CESAR ANDRES ', 'CHAMBI MORALES ', '77146668', '12644893', 'ORURO', '1998-09-13', 'aishiterulilith@gmail.com', NULL),
(142, 'Sandra', 'Huanca Guarachi', '60422053', '7450882', 'ORURO', '1995-11-25', 'sandy.hg2011@gmail.com', NULL),
(143, 'Ronald', 'Rodríguez Ayma ', '60423282', '7331953', 'ORURO', '1993-01-20', 'ronald.cruzito@gmail.com', NULL),
(144, 'Mireya Celeste', 'Velásquez Pantoja', '76142086', '7269940', 'ORURO', '1997-04-16', 'mireya123.mvp@gmail.com', NULL),
(145, 'Ronald', 'Apaza chile', '68338903', '7399965', 'ORURO', '1999-09-12', 'ronaldapazachilerach@gmail.com', NULL),
(146, 'GLADYS VARINIA', 'VALDEZ FERNÁNDEZ', '69600155', '5745841', 'ORURO', '1986-03-20', 'variyangel@gmail.com', NULL),
(147, 'Lilian Cecilia', 'Mamani Choque', '75405203', '7346004', 'ORURO', '1996-07-31', 'lilianmamanichoque@gmail.com', NULL),
(148, 'Herbert Giovanni ', 'Mamani Bernabe ', '68335925', '9396648', 'ORURO', '1994-05-27', 'herbertbernsbe62@gmail.com', NULL),
(149, 'Jimena', 'Salazar Mendoza ', '77440154', '4042971 ', 'ORURO', '1986-06-19', 'jsmalejandra30@gmail.com', NULL),
(150, 'Yamil Jorge', 'Gomez Antezana', '79409818', '5065438', 'ORURO', '1983-09-01', 'yamilgoa@gmail.com', NULL),
(151, 'Junior Ariel', 'Mendoza Andrade', '69604178', '7389828', 'ORURO', '1993-09-18', 'Junior.AMendoza@hotmail.com', NULL),
(152, 'Neyza ', 'López Chila', '62846249', '7403684', 'ORURO', '1998-03-22', 'neyzalopezchila@gmail.com', NULL),
(153, 'Alison', 'Mendoza Andrade', '69593555', '7389829', 'ORURO', '2007-08-11', 'alisonmendoza1108@gmail.com', NULL),
(154, 'Paola Andrea ', 'Navarro Rojas ', '68319995', '7272555', 'ORURO', '1993-04-20', 'paonavarro93@gmail.com', NULL),
(155, 'Mauricio Ariel ', 'Ugarte Deheza ', '69588890', '5774528', 'ORURO', '1989-06-04', 'mauigtr35@gmail.com', NULL),
(156, 'Ricardo Sergio', 'Soto Bernal ', '72499884', '4079010', 'ORURO', '1984-09-16', 'ricardo.soto.bernal@gmail.com', NULL),
(157, 'Nelson Rolando ', 'Mamani Choque', '60419875', '7363616', 'ORURO', '1995-12-15', 'nelsonhannss@gmail.com', NULL),
(158, 'KEVIN JONATHAN', 'COPA RICALDI', '68341749', '10463504', 'ORURO', '1996-07-20', 'corike7@gmail.com', NULL),
(159, 'BRAYAN JIMMY', 'RUFINO ARROYO', '68305977', '4076140', 'ORURO', '1997-04-26', 'brayanrufino36@gmail.com', NULL),
(160, 'Jhoselin', 'Mamani Choque', '70436052', '7398676', 'ORURO', '1999-07-22', 'mamanijhoselyn411@gmail.com', NULL),
(161, 'Richard', 'Achabal Villalpando', '71884710', '4060586', 'ORURO', '1985-10-02', 'drahcirby@gmail.com', NULL),
(162, 'RONALD JAIME', 'VARGAS OBLITAS', '75413303', '3558204', 'ORURO', '1980-11-07', 'rvargasoblitas7@gmail.com', NULL),
(163, 'José Alexander ', 'Marce Flores', '68322331', '7418853', 'ORURO', '1996-11-15', 'marcejose1996@gmail.com', NULL),
(164, 'Boris Elmer', 'Chambi Ricaldi', '72435224', '6593853', 'ORURO', '1988-10-12', 'yamiyugi.bc@gmail.com', NULL),
(165, 'Dayana Arelis', 'Villalobos Benito', '75403881', '7291087', 'ORURO', '1996-02-07', 'dayanavillalobosbenito@gmail.com', NULL),
(166, 'Grace Pamela ', 'Villalobos Benito', '69591130', '7289566', 'ORURO', '1993-09-09', 'gracepvillalobosb@gmail.com', NULL),
(167, 'Patricia Allison ', 'Loría Frias ', '76144902', '12869769', 'ORURO', '2006-03-30', 'patriciaallisonloriafrias@gmail.com', NULL),
(168, 'IRMA', 'QUISPE MAGNE', '72487725', '72487725', 'ORURO', '1983-02-24', 'irmaquispemagne@gmail.com', NULL),
(169, 'Enilsen Lizett ', 'Patiño Arce', '72488088', '3559649', 'ORURO', '1979-03-20', 'eniliz79@gmail.com', NULL),
(170, 'Diego Manuel', 'Conde Estupiñon', '75420335', '7346366', 'ORURO', '1993-08-15', 'condemanuel1508@gmail.com', NULL),
(171, 'Jacqueline', 'Patiño Arce ', '71108919', '4051850', 'ORURO', '1980-09-28', 'jackyluzjpa26@gmail.com', NULL),
(172, 'Oscar Rodrigo', 'Gutierrez Torrico ', '67235240', '3544856', 'ORURO', '1978-01-22', 's4d1k0s0y@gmail.com', NULL),
(173, 'Marcelo de Jesus ', 'Aima Gutiérrez ', '72335531', '7336632', 'ORURO', '1999-11-29', 'marcelodejesusaima@gmail.com', NULL),
(174, 'Oscar', 'Cuentas Sandy', '72485985', '5726211', 'ORURO', '2000-04-30', 'o.cuentassandy@gmail.com', NULL),
(175, 'Lezly Britha', 'Patiño Arce ', '79403504', '5065528', 'ORURO', '1982-04-26', 'brithapatino@gmail.com', NULL),
(176, 'Alvaro ', 'Sanchez Vargas ', '76142753', '7404972', 'ORURO', '2003-04-28', 'alvarosv606mila@gmail.com', NULL),
(177, 'Pedro Amador', 'Callisaya Caceres', '68327337', '7327147', 'ORURO', '1999-12-31', 'pekeamador2025@gmail.com', NULL),
(178, 'Luis Alejandro', 'García herbas', '68368185', '7424962', 'ORURO', '1993-12-02', 'gascpetrol.gp@gmail.com', NULL),
(179, 'Edgar', 'Choquetupa Huanca ', '67252521', '7392329', 'ORURO', '1969-12-31', 'edgartupa4444@mail.com', NULL),
(180, 'Mauricio', 'Chambi Vergara ', '69336046', '5737850', 'ORURO', '1991-04-16', 'mauriciochvergara1@gmail.com', NULL),
(181, 'JHESSIKA HELEN', 'ROCHA AJHUACHO', '69580685', '7275255', 'ORURO', '1996-07-01', 'rochaajhuachojhessika@gmail.com', NULL),
(182, 'OSEL JUAN ', 'CRISPIN FAJARDO', '75700129', '5736563', 'ORURO', '1990-09-07', 'osselfajardo@gmail.com', NULL),
(183, 'Gilmer', 'Garcia Huayllani', '67231680', '7314984 ', 'ORURO', '2002-05-24', 'gilmergarciah09@gmail.com', NULL),
(184, 'Conny Sofia', 'Macedo Cussi', '63692126', '7405995', 'ORURO', '2002-09-30', 'connyman16@gmail.com', NULL),
(185, 'Abdeel Miguel', 'Escobar Vargas ', '76132552', '7316415', 'ORURO', '1969-12-31', 'abdeelvargas99@gmail.com', NULL),
(186, 'Omar Saúl', 'Frías Enríquez', '77148000', '3547554', 'ORURO', '1977-09-15', 'omarex009@gmail.com', NULL),
(187, 'Jessica Evelyn ', 'Mamani Nina', '71856031', '7333755', 'ORURO', '2000-05-06', 'jesmani.271@gmail.com', NULL),
(188, 'Jessica Evelyn ', 'Mamani Nina', '71856031', '7333755', 'ORURO', '2000-05-06', 'jesmani.271@gmail.com', NULL),
(189, 'Daniel', 'Pacheco Gonzales', '73829873', '4041615', 'ORURO', '1978-10-05', 'dr.dandach@gmail.com', NULL),
(190, 'Gustavo Pablo', 'Vásquez Llorenty', '77158449', '5740424', 'ORURO', '1984-09-14', 'pabloviene@gmail.com', NULL),
(191, 'LIZETH ', 'PLAZA GARCIA ', '74158178', '5062436', 'ORURO', '1987-04-29', 'plazagarcializeth@gmail.com', NULL),
(192, 'Maria Reneé', 'Pérez Toro', '72455628', '5062055', 'ORURO', '1981-07-08', 'maritaptx@gmail.com', NULL),
(193, 'Martha Laura', 'Sánchez Espinoza', '71889868', '2759855', 'ORURO', '1968-09-14', 'marthalaurasanchezespinoza@gmail.com', NULL),
(194, 'Andrea Valentina', 'Alcócer Sánchez ', '75413200', '6553738', 'ORURO', '1994-08-11', 'andreitavale007@hotmail.com', NULL),
(195, 'Gabriela Erika ', 'Alcócer Sánchez ', '70436681', '6553724', 'ORURO', '1992-12-17', 'gabicita.17.92@gmail.com', NULL),
(196, 'Henrry', 'Frias Tito', '70553876', '5741863 ', 'ORURO', '1986-05-14', 'henrryfrias0@gmail.com', NULL),
(197, 'Sandra Marcela ', 'Alvarez Colque ', '72003174', '5741279', 'ORURO', '1988-05-21', 'mr4hp.sa@gmail.com', NULL),
(198, 'Santos ', 'Soliz Guzman ', '68303555', '7282363', 'ORURO', '1988-12-23', 'santos_soliz23@hotmail.es', NULL),
(199, 'Juan pablo', 'Cerrogrande Acuña', '67208613', '7409962', 'ORURO', '2000-09-05', 'cerrograndejuanpablo@gmail.com', NULL),
(200, 'Miguel A.', 'Humerez Mamani', '69336339', '7270080', 'ORURO', '1989-02-02', 'mikky.mian@gmail.com', NULL),
(201, 'Ronald', 'Mamani Choque ', '72456452', '7330878', 'ORURO', '1989-12-21', 'ronynor21@gmail.com', NULL),
(202, 'María Renée', 'Morante Condori', '79410198', '7413644', 'ORURO', '1998-09-05', 'mariareneemorante@gmail.com', NULL),
(203, 'Soledad', 'Condori Flores', '60430963', '4057959', 'ORURO', '1980-12-19', 'mariareneemorante@gmail.com', NULL),
(204, 'Ritha Jazmine', 'Aima Gutierrez ', '75415540', '7261025', 'ORURO', '1988-02-12', 'jazmineaimagutierrez@gmail.com', NULL),
(205, 'Andrea Silvana', 'Gutierrez Rodriguez', '79404475', '7275151', 'ORURO', '1988-07-22', 'ansildis@gmail.com', NULL),
(206, 'Matías charly', 'Córdova Aguilar ', '79413104', '13857944', 'ORURO', '2009-06-10', 'cm_cordova19@hotmail.com', NULL),
(207, 'Jose luis', 'Magne escobar', '70344117', '5908775', 'ORURO', '1984-02-02', 'magneescobarjoseluis@gmail.com', NULL),
(208, 'Milenka Ana', 'Vega Garcia', '70417579', '4832494', 'ORURO', '1986-01-07', 'milenkavegag7@hotmail.com', NULL),
(209, 'GREGORIO FERNANDO', 'UREÑA MERIDA', '69572229', '3395650', 'ORURO', '1973-01-12', 'gregorio.urena@sistemas.edu.bo', NULL),
(210, 'Marcelo Edgar', 'Huarachi Chila', '78616459', '7364378-Or', 'ORURO', '1993-06-28', 'marcelo943256@gmail.com', NULL),
(211, 'Carlos ', 'Córdova reynaga ', '79413104', '4075892 ', 'ORURO', '1985-12-19', 'cm_cordova19@hotmail.com', NULL),
(212, 'Junior jairo', 'Viza moya', '72336906', '4077923', 'ORURO', '2000-07-14', 'juniorviza666@gmail.com', NULL),
(213, 'Jhoselin Andrea ', 'Soria Vallejos', '72302779', '7275669 ', 'ORURO', '1996-05-07', 'jhoseandrea700@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cobrartarjeta`
--

CREATE TABLE `cobrartarjeta` (
  `CobrartarjetaID` int(11) NOT NULL,
  `Fecha_cobro` date DEFAULT NULL,
  `Hora_cobro` time DEFAULT NULL,
  `Monto_cobro` int(11) DEFAULT NULL,
  `N_factura` varchar(255) DEFAULT NULL,
  `N_reciboc` varchar(255) DEFAULT NULL,
  `Lugar_reciboc` varchar(255) DEFAULT NULL,
  `TarjetaID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cobrartarjeta`
--

INSERT INTO `cobrartarjeta` (`CobrartarjetaID`, `Fecha_cobro`, `Hora_cobro`, `Monto_cobro`, `N_factura`, `N_reciboc`, `Lugar_reciboc`, `TarjetaID`) VALUES
(1, '2021-10-06', '08:52:00', 7, '1212', '1', 'aqui', 0),
(2, '2021-10-06', '08:54:00', 7, '1212', '2', 'aqui', 5),
(3, '2021-10-06', '08:58:00', 120, '1212', '3', 'aqui', 5),
(4, '2021-10-06', '09:34:00', 65, '1212', '4', 'aqui', 5),
(5, '2021-10-06', '10:09:00', 10, '000004', '5', 'boleteria', 5),
(6, '2021-10-06', '16:31:00', 85, '76769', '6', 'boleteria', 9),
(7, '2021-10-07', '17:02:39', 135, '000006', '7', 'CAFE ITALIA', 9),
(8, '2021-10-08', '13:19:33', 100, '776477', '8', 'SABOR PERU', 6),
(9, '2021-10-08', '13:23:23', 50, '0000056', '9', 'CANDY BAR', 6),
(10, '2021-10-10', '17:51:03', 20, '898678', '10', 'BOLETERIA', 9),
(11, '2021-10-10', '17:52:58', 80, '789977', '11', 'CAFE ITALIA', 9),
(12, '2021-10-10', '18:00:02', 30, '58867758', '12', 'BOLETERIA', 9),
(13, '2021-10-14', '17:46:18', 84, '00001', '13', 'SABOR PERU', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarjeta`
--

CREATE TABLE `tarjeta` (
  `TarjetaID` int(11) NOT NULL,
  `Codigo_tarjeta` varchar(255) DEFAULT NULL,
  `Fechacaducidad` date DEFAULT NULL,
  `Saldo` int(11) DEFAULT NULL,
  `ClienteID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tarjeta`
--

INSERT INTO `tarjeta` (`TarjetaID`, `Codigo_tarjeta`, `Fechacaducidad`, `Saldo`, `ClienteID`) VALUES
(15, 'ecpg-6220253-10', '2022-10-11', 100, 11),
(16, 'cjem-5377727-1', '2022-10-13', 100, 12),
(17, 'dacc-26703456-2', '2022-10-12', 100, 13),
(18, 'aeem-6377727-3', '2022-10-12', 100, 16),
(19, 'jtca-0778937-4', '2022-10-12', 100, 14),
(20, 'rkmv-1006337-5', '2022-10-12', 100, 15),
(21, 'ksvr-2359537-6', '2022-10-12', 100, 18),
(22, 'rjzo-6311275-7', '2022-10-12', 100, 17),
(23, 'krrv-ro 1835605-8', '2022-10-12', 100, 23),
(24, 'avo-ro 1423503-9', '2022-10-12', 100, 24),
(25, 'jaft-86394521-10', '2022-10-12', 100, 26),
(26, 'aacc-1027047-11', '2022-10-12', 100, 25),
(27, 'wmav-2221137-12', '2022-10-12', 100, 27),
(28, 'pjam-43506427-13', '2022-10-12', 100, 28),
(29, 'ldcn-9235827-14', '2022-10-12', 100, 30),
(30, 'ymwr-pl9152799-15', '2022-10-12', 100, 29),
(31, 'psvb- 5682437-16', '2022-10-12', 100, 32),
(32, 'jaoh- 1708147-17', '2022-10-12', 100, 33),
(33, 'ach-91990757-18', '2022-10-12', 100, 36),
(34, 'ddom-4457637-19', '2022-10-12', 100, 35),
(35, 'jmze-4422247-20', '2022-10-12', 100, 34),
(36, 'asft-6801237-21', '2022-10-12', 100, 38),
(37, 'kcc-9300147-22', '2022-10-12', 100, 39),
(38, 'raco-4943247-23', '2022-10-12', 100, 40),
(39, 'smd-9138237-24', '2022-10-12', 100, 41),
(40, 'tto-37501687-25', '2022-10-12', 100, 45),
(41, 'mrpv-2216453-26', '2022-10-12', 100, 46),
(42, 'gcp-0367605-27', '2022-10-12', 100, 43),
(43, 'gcb-1552553-28', '2022-10-12', 100, 44),
(44, '?cps-6727437-29', '2022-10-12', 100, 19),
(45, 'krv-4807737-30', '2022-10-12', 100, 31),
(46, 'mjmp-1092637-31', '2022-10-12', 100, 22),
(47, 'papt-8111937-32', '2022-10-12', 100, 42),
(48, 'raqm-5992737-33', '2022-10-12', 100, 21),
(49, 'mjgdc-1868605-34', '2022-10-12', 100, 20),
(50, 'rmhp-1298453-35', '2022-10-12', 100, 48),
(51, 'rtea-0248375-36', '2022-10-12', 100, 49),
(52, 'dmpt-76820351-37', '2022-10-12', 100, 50),
(53, 'alca-7621837-38', '2022-10-12', 100, 52),
(54, 'lhcs-7289147-39', '2022-10-12', 100, 51),
(55, 'jce-4701137-40', '2022-10-12', 100, 53),
(56, 'cbc-rO 2238604-41', '2022-10-12', 100, 55),
(57, 'jact-2068337-42', '2022-10-12', 100, 57),
(58, 'ewjc-2235704-43', '2022-10-12', 100, 54),
(59, 'arpj-92198131-44', '2022-10-12', 100, 56),
(60, 'rqf- rO 4602475-45', '2022-10-12', 100, 58),
(61, 'kmat-9559137-46', '2022-10-12', 100, 59),
(62, 'jcp-0335437-47', '2022-10-12', 100, 61),
(63, 'maro-1236537-48', '2022-10-12', 100, 60),
(64, 'mjlc-6937437-49', '2022-10-12', 100, 62),
(65, 'jcc-9834637-50', '2022-10-12', 100, 63),
(66, 'mrs-4054737-51', '2022-10-12', 100, 64),
(67, 'em-3028575-52', '2022-10-12', 100, 65),
(68, 'maof-8589827-53', '2022-10-12', 100, 67),
(69, 'sld-1237637-54', '2022-10-12', 100, 66),
(70, 'amrp-6464504-55', '2022-10-12', 100, 68),
(71, 'ahsm-8311537-56', '2022-10-12', 100, 71),
(72, 'pdsj-1167837-57', '2022-10-12', 100, 70),
(73, 'sjsc-9024437-58', '2022-10-12', 100, 69),
(74, 'jmvl-2982637-59', '2022-10-12', 100, 78),
(75, 'ecvg-7454337-60', '2022-10-12', 100, 72),
(76, 'cmsa-9704675-61', '2022-10-12', 100, 73),
(77, 'pgsa- 3923775-62', '2022-10-12', 100, 75),
(78, 'cebr-8401475-63', '2022-10-12', 100, 74),
(79, 'hmmh- 3157637-64', '2022-10-12', 100, 79),
(80, 'rhv-5910253-65', '2022-10-12', 100, 82),
(81, 'bapv-70346431-66', '2022-10-12', 100, 81),
(82, 'djcc-7143237-67', '2022-10-12', 100, 84),
(83, 'abar-4495737-68', '2022-10-12', 100, 85),
(84, 'jfp-95165167-69', '2022-10-12', 100, 87),
(85, 'ggci-05814721-70', '2022-10-12', 100, 90),
(86, 'ajma- 9267637-71', '2022-10-12', 100, 89),
(87, 'lkrl-5501737-72', '2022-10-12', 100, 88),
(88, 'sgf-2610727-73', '2022-10-12', 100, 93),
(89, 'avc-9958837-74', '2022-10-12', 100, 94),
(90, 'gabl- 2302827-75', '2022-10-12', 100, 95),
(91, 'abmy- 6898575-76', '2022-10-12', 100, 97),
(92, 'srm-7193337-77', '2022-10-12', 100, 101),
(93, 'rvtf-7544937-78', '2022-10-12', 100, 103),
(94, 'mjoh-2511253-79', '2022-10-12', 100, 98),
(95, 'mcdc-77288427-80', '2022-10-12', 100, 102),
(96, 'afcv-8955153-81', '2022-10-12', 100, 99),
(97, 'cfas-4239737-82', '2022-10-12', 100, 104),
(98, 'pgp-1769237-83', '2022-10-12', 100, 100),
(99, 'raco-5714927-84', '2022-10-12', 100, 107),
(100, 'mfi-9060603-85', '2022-10-12', 100, 105),
(101, 'avf-2589675-86', '2022-10-12', 100, 106),
(102, 'payf-9343137-87', '2022-10-12', 100, 108),
(103, 'klrc-0350737-88', '2022-10-12', 100, 109),
(104, 'cmji-2362037-89', '2022-10-12', 100, 113),
(105, 'rmp-3186537-90', '2022-10-12', 100, 111),
(106, 'mjcr-9644927-91', '2022-10-12', 100, 114),
(107, 'vbnc-3354605-92', '2022-10-12', 100, 112),
(108, 'ram-3562675-93', '2022-10-12', 100, 110),
(109, 'gqm-7280927-94', '2022-10-12', 100, 115),
(110, 'mama-2333927-95', '2022-10-12', 100, 117),
(111, 'egrr-3597675-96', '2022-10-12', 100, 118),
(112, 'mmyp-1814366-97', '2022-10-12', 100, 121),
(113, 'jmca-7691475-98', '2022-10-12', 100, 119),
(114, 'lgqb-6974627-99', '2022-10-12', 100, 120),
(115, 'favh-2808927-100', '2022-10-12', 100, 80),
(116, 'efvh-5975047-101', '2022-10-12', 100, 83),
(117, 'japp-0650727-102', '2022-10-12', 100, 92),
(118, 'ramc-8059375-103', '2022-10-12', 100, 123),
(119, 'emcv-8967637-104', '2022-10-12', 100, 122),
(120, 'rym-5578275-105', '2022-10-12', 100, 116),
(121, 'brc-38224501-106', '2022-10-12', 100, 125),
(122, 'iarc-7207727-107', '2022-10-12', 100, 127),
(123, 'ssch-8688997-108', '2022-10-12', 100, 126),
(124, 'dacc-7861439-109', '2022-10-12', 100, 77),
(125, 'macm-4080637-110', '2022-10-12', 100, 124),
(126, 'impc-8430775-111', '2022-10-12', 100, 76),
(127, 'lam-3965675-112', '2022-10-12', 100, 128),
(128, 'rag-1695675-113', '2022-10-12', 100, 129),
(129, 'fpme-0975247-114', '2022-10-12', 100, 130),
(130, 'vjma-9649537-115', '2022-10-12', 100, 131),
(131, 'marc-2125537-116', '2022-10-12', 100, 132),
(132, 'fdyc-2913275-117', '2022-10-12', 100, 134),
(133, 'op-5541558-118', '2022-10-12', 100, 133),
(134, 'icg-7884737-119', '2022-10-12', 100, 135),
(135, 'kobm-72907641-120', '2022-10-12', 100, 137),
(136, 'encl-2305998-121', '2022-10-12', 100, 139),
(137, 'llmm-7912253-122', '2022-10-12', 100, 138),
(138, 'mamg-8108337-123', '2022-10-12', 100, 136),
(139, 'cacm-39844621-124', '2022-10-12', 100, 141),
(140, 'shg-2880547-125', '2022-10-12', 100, 142),
(141, 'rra-3591337-126', '2022-10-12', 100, 143),
(142, 'mcvp-0499627-127', '2022-10-12', 100, 144),
(143, 'rac-5699937-128', '2022-10-12', 100, 145),
(144, 'hgmb-8466939-129', '2022-10-12', 100, 148),
(145, 'gvvf-1485475-130', '2022-10-12', 100, 146),
(146, 'lcmc-4006437-131', '2022-10-12', 100, 147),
(147, 'yjga-8345605-132', '2022-10-12', 100, 150),
(148, 'jsm- 1792404-133', '2022-10-12', 100, 149),
(149, 'jama-8289837-134', '2022-10-12', 100, 151),
(150, 'nlc-4863047-135', '2022-10-12', 100, 152),
(151, 'ama-9289837-136', '2022-10-12', 100, 153),
(152, 'panr-5552727-137', '2022-10-12', 100, 154),
(153, 'maud-09888596-138', '2022-10-12', 100, 155),
(154, 'nrmc-6163637-139', '2022-10-12', 100, 157),
(155, 'kjcr-40536401-140', '2022-10-12', 100, 158),
(156, 'jmc-6768937-141', '2022-10-12', 100, 160),
(157, 'bjra-0416704-142', '2022-10-12', 100, 159),
(158, 'rav-6850604-143', '2022-10-12', 100, 161),
(159, 'jamf-3588147-144', '2022-10-12', 100, 163),
(160, 'becr-3583956-145', '2022-10-12', 100, 164),
(161, 'davb-7801927-146', '2022-10-12', 100, 165),
(162, 'gpvb-6659827-147', '2022-10-12', 100, 166),
(163, 'palf-96796821-148', '2022-10-12', 100, 167),
(164, 'elpa-9469553-149', '2022-10-12', 100, 169),
(165, 'dmce- 6636437-150', '2022-10-12', 100, 170),
(166, 'jpa-0581504-151', '2022-10-12', 100, 171),
(167, 'orgt-6584453-152', '2022-10-12', 100, 172),
(168, 'mdjag-2366337-153', '2022-10-12', 100, 173),
(169, 'asv-2794047-154', '2022-10-12', 100, 176),
(170, 'ocs-1126275-155', '2022-10-12', 100, 174),
(171, 'lbpa-8255605-156', '2022-10-12', 100, 175),
(172, 'lagh-2694247-157', '2022-10-12', 100, 178),
(173, 'ech-9232937-158', '2022-10-12', 100, 179),
(174, 'mcv-0587375-159', '2022-10-12', 100, 180),
(175, 'amev-5146137-160', '2022-10-12', 100, 185),
(176, 'osfe-00084177-161', '2022-10-12', 100, 186),
(177, 'csmc-5995047-162', '2022-10-12', 100, 184),
(178, 'ggh- 4894137-163', '2022-10-12', 100, 183),
(179, 'jemn-5573337-164', '2022-10-12', 100, 187),
(180, 'hft- 3681475-165', '2022-10-14', 100, 196),
(181, 'smac-9721475-166', '2022-10-14', 100, 197),
(182, 'ssg-3632827-167', '2022-10-14', 100, 198),
(183, 'mahm-0800727-168', '2022-10-14', 100, 200),
(184, '[mads-48765131-169]', '2022-10-14', 100, 91),
(185, 'aads-38765131-170', '2022-10-14', 100, 96),
(186, 'jpca-2699047-171', '2022-10-14', 100, 199),
(187, 'rmc-8780337-172', '2022-10-14', 100, 201),
(188, 'mrmc-4463147-173', '2022-10-14', 100, 202),
(189, 'scf-9597504-174', '2022-10-14', 100, 203),
(190, 'rjag-5201627-175', '2022-10-14', 100, 204),
(192, 'asgr-1515727-176', '2022-10-14', 100, 205),
(193, 'lva-69915521-177', '2022-10-14', 100, 37),
(194, 'geas-4273556-178', '2022-10-14', 100, 195),
(195, 'avas-8373556-179', '2022-10-14', 100, 194),
(196, 'mlse-5589572-180', '2022-10-14', 100, 193),
(197, 'gpvl-4240475-181', '2022-10-14', 100, 190),
(198, 'lpg-6342605-182', '2022-10-14', 100, 191),
(199, 'jcgs-rO 6676504-183', '2022-10-14', 100, 47),
(200, 'rssb-0109704-184', '2022-10-14', 100, 156),
(201, 'jhra-5525727-185', '2022-10-14', 100, 181),
(202, 'ojcf-3656375-186', '2022-10-14', 100, 182),
(203, 'rjvo-4028553-187', '2022-10-14', 100, 162),
(204, 'mcca-44975831-188', '2022-10-14', 100, 206),
(205, 'jlme-5778095-189', '2022-10-14', 100, 207),
(206, 'mavg-4942384-190', '2022-10-14', 100, 208),
(207, 'gfum-0565933-191', '2022-10-14', 100, 209),
(208, 'mehc-rO-8734637-192', '2022-10-14', 100, 210),
(209, 'jjvm-3297704-193', '2022-10-14', 100, 212),
(210, 'jasv- 9665727-194', '2022-10-14', 100, 213),
(211, 'ccr- 2985704-195', '2022-10-14', 100, 211);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipousuario`
--

CREATE TABLE `tipousuario` (
  `TipousuarioID` int(11) NOT NULL,
  `Permisos` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `UsuarioID` int(11) NOT NULL,
  `Nombre_usuario` varchar(255) DEFAULT NULL,
  `Apellido_usuario` varchar(255) DEFAULT NULL,
  `Ci_usuario` varchar(255) DEFAULT NULL,
  `Cuenta` varchar(255) DEFAULT NULL,
  `Cargo` varchar(255) DEFAULT NULL,
  `Pass` varchar(255) DEFAULT NULL,
  `TipousuarioID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`UsuarioID`, `Nombre_usuario`, `Apellido_usuario`, `Ci_usuario`, `Cuenta`, `Cargo`, `Pass`, `TipousuarioID`) VALUES
(2, 'ADMINISTRADOR', 'ADMINISTRADOR', '0', 'admin', 'Administrador', '6930d0f25d4da04dd0cc64d500b23b19', 0),
(3, 'Cajero', 'Cajero', '2345678', 'cajero', 'Cajero', 'f80bb5a954ee71b40f1c31b79734d82d', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anulartarjeta`
--
ALTER TABLE `anulartarjeta`
  ADD PRIMARY KEY (`AnulartarjetaID`),
  ADD KEY `FK_AnularTarjeta_Anula` (`TarjetaID`);

--
-- Indices de la tabla `cargartarjeta`
--
ALTER TABLE `cargartarjeta`
  ADD PRIMARY KEY (`CargartarjetaID`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cobrartarjeta`
--
ALTER TABLE `cobrartarjeta`
  ADD PRIMARY KEY (`CobrartarjetaID`);

--
-- Indices de la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  ADD PRIMARY KEY (`TarjetaID`),
  ADD KEY `FK_Tarjeta_Adquiere` (`ClienteID`);

--
-- Indices de la tabla `tipousuario`
--
ALTER TABLE `tipousuario`
  ADD PRIMARY KEY (`TipousuarioID`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`UsuarioID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anulartarjeta`
--
ALTER TABLE `anulartarjeta`
  MODIFY `AnulartarjetaID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cargartarjeta`
--
ALTER TABLE `cargartarjeta`
  MODIFY `CargartarjetaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT de la tabla `cobrartarjeta`
--
ALTER TABLE `cobrartarjeta`
  MODIFY `CobrartarjetaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  MODIFY `TarjetaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT de la tabla `tipousuario`
--
ALTER TABLE `tipousuario`
  MODIFY `TipousuarioID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `UsuarioID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tarjeta`
--
ALTER TABLE `tarjeta`
  ADD CONSTRAINT `FK_Tarjeta_Adquiere` FOREIGN KEY (`ClienteID`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
