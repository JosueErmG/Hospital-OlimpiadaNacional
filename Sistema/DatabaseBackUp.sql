-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-09-2023 a las 23:04:41
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hospital`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `codigo` int(8) UNSIGNED NOT NULL,
  `pass` varchar(256) NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `telefono` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`codigo`, `pass`, `nombre`, `telefono`) VALUES
(1, '$2y$10$nVlQRHlWGHynQmMYYV2qm.OEkjPRMJd80ZoQl7hE0tT9sEq6ZZ4dC', 'Sala principal', '+54 291 100-0001'),
(2, '$2y$10$oNbyaErCBv4i1QFtxch9Z.Nn8QB5mK.9bt5dAPRekNGKvXTJTwCsy', 'Pediatría', '+54 291 100-0002'),
(3, '$2y$10$BncI.v4Qfz9XVAovjqPWCebyA9T4eoSbz6/haVR6ywANQCsJ8lhci', 'Clinica', '+54 291 100-0003'),
(4, '$2y$10$DhmQzM74WH3t56l5P8G3x.7FaLhZz6DW4GcTVWPRChnodbRUrUcVa', 'Cardiologia', '+54 291 100-0004'),
(5, '$2y$10$/9fX9ug7zoalBiGkgt7erOKQX6nvEtNEvSc2nHC4K8f.b4XtBrmSK', 'Farmacia', '+54 291 100-0005'),
(6, '$2y$10$bgpcGW8kqIeGfChlAUIEheYLzDBHpDZUlhxhU5nC2YpxVp3JOzCrS', 'Cirugia', '+54 291 100-0006'),
(7, '$2y$10$mAJD5xtb6RDgHYzBrdus/.H0gtqhsiIxbZ3OQKwp84vrNDVwNV15G', 'Cuidados intensivos', '+54 291 100-0007'),
(8, '$2y$10$2taNSscuTfs4NOeX.i6rYOmR3g6iMxcJHLL0l1HGa8cJBNBkKXdcq', 'Laboratorio', '+54 291 100-0008'),
(9, '$2y$10$Z2PzaWgaf7gXN/MfYsdTgOue3VpHHCZiCNfEXufGTQpHQqoh8zEba', 'Ginecologia', '+54 291 100-0009'),
(10, '$2y$10$UfCrFK7PEsZ.fuFiq8mhHea95VDVDMPluwAJpeu5sBJcQmjDLHubS', 'Guardia', '+54 291 100-0010'),
(11, '$2y$10$KGm9YVqUYEtK/IvmqCUnoeB3qV8gWTx33CqQN.Ke34AJ1qVLgHtU2', 'Cuidados intensivos sala 1', '+54 291 100-0011'),
(12, '$2y$10$HWCCoKk/TyWATsRuevLOk.zd8QCJtK6x1sebTpFRJvpKQNJz0gQzq', 'Cuidados intensivos sala 2', '+54 291 100-0012'),
(13, '$2y$10$YmgdDgb0YLqOTp6ozOJKwOmstj8zC8AFcbL4q43.unQFZdFnFPLFe', 'Cuidados intensivos sala 3', '+54 291 100-0013'),
(14, '$2y$10$J2f/zWfWDmewVWi3RsFNm.a48LShk0gTrryjdF3UYkljFinQxE75W', 'Cuidados intensivos sala 4', '+54 291 100-0014'),
(15, '$2y$10$IQgh7WFcR8tXQubdnrZUPuIG7UjSH2MB/aryq2Q4heqByK9qkitZG', 'Cuidados intensivos sala 5', '+54 291 100-0015'),
(16, '$2y$10$BZqREyQINwxf6OzluhDrz.EoOTpQjrIwurWy12JmdNG8ejlI8gUQy', 'Tesoreria', '+54 291 100-0016'),
(17, '$2y$10$4ImLSht8QjdqBSL5uV.afedSXQOrqw507YFg8XLevTcgl.JPsSAwy', 'Social', '+54 291 100-0017'),
(18, '$2y$10$V8nQnFVfGK68k/HTETls0u1Vl3qVfBG5oD7XcWspxwU.P9f.N7RhW', 'Oncologia', '+54 291 100-0018'),
(19, '$2y$10$gMT1N8piDGhNiqNYs/amnO9XlGDLYynrXstl9kFxGGgd9f.y80MEu', 'Rehabilitación', '+54 291 100-0019'),
(20, '$2y$10$nTW7Cl.05FFHd7y9YScJQuOKPLv/jlee1s9cq7Az7qMmr1SRJ6g7u', 'Hematologia', '+54 291 100-0020');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `areasview`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `areasview` (
`Código` int(8) unsigned
,`Nombre` varchar(32)
,`Teléfono` varchar(20)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fichas`
--

CREATE TABLE `fichas` (
  `ID` int(8) UNSIGNED NOT NULL,
  `DNI` int(8) UNSIGNED NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `apellido` varchar(32) NOT NULL,
  `datosMedicos` varchar(1024) NOT NULL,
  `usuarioLegajo` int(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fichas`
--

INSERT INTO `fichas` (`ID`, `DNI`, `nombre`, `apellido`, `datosMedicos`, `usuarioLegajo`) VALUES
(1, 37106423, 'Fernando', 'Maya', 'Diarrea', 2),
(2, 45996102, 'Maria', 'Fernandez', 'Sutura', 7),
(3, 35113543, 'Julia', 'Ferrari', 'Quebradura', 12),
(4, 40856362, 'Luca', 'Barria', 'Lesión ', 20),
(5, 47962353, 'Sebastian', 'Torres', 'Quemadura', 16);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `fichasview`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `fichasview` (
`ID` int(8) unsigned
,`DNI` int(8) unsigned
,`Nombre` varchar(32)
,`Apellido` varchar(32)
,`Datos médicos` varchar(1024)
,`Médico/Enfermero` int(8) unsigned
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE `reportes` (
  `ID` int(10) UNSIGNED NOT NULL,
  `nivel` int(1) UNSIGNED NOT NULL,
  `atendido` tinyint(1) NOT NULL DEFAULT 0,
  `ubicacion` varchar(4) DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaAtendido` datetime DEFAULT NULL,
  `usuarioLegajo` int(8) UNSIGNED DEFAULT NULL,
  `areaCodigo` int(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reportes`
--

INSERT INTO `reportes` (`ID`, `nivel`, `atendido`, `ubicacion`, `fechaCreacion`, `fechaAtendido`, `usuarioLegajo`, `areaCodigo`) VALUES
(1, 1, 1, NULL, '2023-09-13 15:24:15', '2023-09-13 16:04:15', 7, 7),
(2, 3, 1, 'Cama', '2023-09-17 15:57:15', '2023-09-17 19:24:11', NULL, 2),
(3, 1, 1, 'Cama', '2023-09-18 01:36:09', '2023-09-25 17:28:06', NULL, 15),
(4, 3, 1, 'Baño', '2023-09-19 01:53:07', '2023-09-19 06:14:42', NULL, 10),
(5, 1, 1, 'Baño', '2023-09-20 10:24:15', '2023-09-25 17:28:06', NULL, 13),
(6, 2, 1, NULL, '2023-09-20 18:52:41', '2023-09-20 20:12:27', 9, 9),
(7, 2, 1, NULL, '2023-09-21 05:07:49', '2023-09-21 08:00:12', 8, 8),
(8, 3, 0, NULL, '2023-09-22 15:43:21', NULL, 20, 20),
(9, 3, 0, 'Cama', '2023-09-22 17:28:40', NULL, NULL, 4),
(12, 3, 0, NULL, '2023-09-25 22:50:16', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `reportesview`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `reportesview` (
`ID` int(10) unsigned
,`Fecha de creación` datetime
,`Fecha de atención` datetime
,`Nivel de
emergencia` int(1) unsigned
,`Ubicación` varchar(4)
,`Código de
área` int(8) unsigned
,`Médico/
Enfermero` int(8) unsigned
,`Atendido` tinyint(1)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `legajo` int(8) UNSIGNED NOT NULL,
  `DNI` int(8) UNSIGNED NOT NULL,
  `pass` varchar(256) NOT NULL,
  `nombre` varchar(32) DEFAULT NULL,
  `apellido` varchar(32) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `esAdmin` tinyint(1) NOT NULL,
  `areaCodigo` int(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`legajo`, `DNI`, `pass`, `nombre`, `apellido`, `telefono`, `email`, `esAdmin`, `areaCodigo`) VALUES
(1, 10000000, '$2y$10$j2Fkpl2YF3s0fE2Ekw8xN.Zdsscssv5Y0VexemMSyoGDkhdOXTrC2', 'root', 'root', '+54 291 000-0000', 'root@hospital.gob.ar', 1, 1),
(2, 10000001, '$2y$10$KtkF8aZ5r7Ec9VcAj3038u.rnxPpfuUqpTktU3.WVl8uAJJ.HM4VS', 'Pedro', 'Long', '+54 291 000-0001', 'PLong@hospital.gob.ar', 0, 2),
(3, 10000002, '$2y$10$xzOSOefWvhKkqeeXleHMcOP8k.3mhABBISC9zarEquy01.EsyYqIC', 'Matias', 'Cast', '+54 291 000-0002', 'MCast@hospital.gob.ar', 0, 3),
(4, 10000003, '$2y$10$B1ra.OxGUNZt/UgFUbYcjuiZfbHBk0or/RuSbywWkUgPbax2FV/Va', 'Lujan', 'Fernandez', '+54 291 000-0003', 'LFernandez@hospital.gob.ar', 0, 4),
(5, 10000004, '$2y$10$9LFYjG4bXbR4FdDjaq21/OWfSgbqnQ6ZqKI1lW/IWwJlSu/ZPZ0r2', 'Yamila', 'Obreque', '+54 291 000-0004', 'YObreque@hospital.gob.ar', 0, 5),
(6, 10000005, '$2y$10$CfkSz0RKyYVGoGKahHO3u.hIQjV3xgYR4No9QgeTMcOXyqiDYI7BC', 'Pablo Airton ', 'Blito', '+54 291 000-0005', 'PABlito@hospital.gob.ar', 0, 6),
(7, 10000006, '$2y$10$an5GTXcte6MtwxHhCU4OP.EbeR.OltLpt/2VM8O5BVNIeSWn1UKCK', 'Luca', 'Cejas', '+54 291 000-0006', 'LCejas@hospital.gob.ar', 0, 7),
(8, 10000007, '$2y$10$bZDHYmBUj5gXhdcbAs.ccO8IOADQuFnfQF1zt.glFAlUSftc1akQ2', 'Sandra', 'Mayer', '+54 291 000-0007', 'SMayer@hospital.gob.ar', 0, 8),
(9, 10000008, '$2y$10$bIXApin3Lu87Eqme4hRsJeeVp8JyPJn0ZcwNlIe4h6kFuzgyVXaCW', 'Santiago', 'Belsito', '+54 291 000-0008', 'SBelsito@hospital.gob.ar', 0, 9),
(10, 10000009, '$2y$10$szkaniWeQlkjaWZvTpCkN.QIH116Jy6TcGmlBoDgp80HUwC8JSCii', 'Florencia', 'Cejas', '+54 291 000-0009', 'FCejas@hospital.gob.ar', 0, 10),
(11, 10000010, '$2y$10$kFg2Vaw4czIv4vVofewFiuP/krOCMjPM3CiytGTkQuF1gezHXJSC6', 'Josue', 'Salazar', '+54 291 000-0010', 'JSalazar@hospital.gob.ar', 0, 11),
(12, 10000011, '$2y$10$npKUGnK96ajMv9z2MF5XEe977YC4lXcS4cWktDhgoBR63AFWRpcoK', 'Irma', 'Valentini', '+54 291 000-0011', 'IValentini@hospital.gob.ar', 0, 12),
(13, 10000012, '$2y$10$y.QWtKOFIB3sQmrGxktZdO6xDGN5eMK72QSA.sRrvLkppe8kpjkO6', 'Camila', 'Roldan', '+54 291 000-0012', 'CRoldan@hospital.gob.ar', 0, 13),
(14, 10000013, '$2y$10$XiS6Bm2FMpxOz/3wZxKXSeESuXuTnt7HptBpUSo7o8VIM36ejboF6', 'Fernando', 'Hueche', '+54 291 000-0013', 'FHueche@hospital.gob.ar', 0, 14),
(15, 10000014, '$2y$10$tG0LJO4D/0QjPulIpWGjlOsERp/t/v00JAgfvM9dnJvtM0Qz2C/WW', 'Valentina', 'Haag', '+54 291 000-0014', 'VHaag@hospital.gob.ar', 0, 15),
(16, 10000015, '$2y$10$K6SboQ/DqOX4o36Cs4K9d.qWZuMJg8bZb71K.Q.Eu1kJM5lA0KolO', 'Alex', 'Perez', '+54 291 000-0015', 'VHaag@hospital.gob.ar', 0, 16),
(17, 10000016, '$2y$10$dI8bEPiKuJZMnKc/tKcj2.JguJnRbcN5kZmk.M01zbUeL7/wAqi3.', 'Laura', 'Navarro', '+54 291 000-0016', 'LNavarro@hospital.gob.ar', 0, 17),
(18, 10000017, '$2y$10$Zmtt05lgvq9Lp2nB8CkbNOGc8t.end84FEferTbB2t4aMh3mAqWVW', 'Mariano', 'Domínguez', '+54 291 000-0017', 'MDominguez@hospital.gob.ar', 0, 18),
(19, 10000018, '$2y$10$.2fvPLqyNX9YKrQhvUZLY.bvGdA.P5nNXbUihgd.caSB9owfAs/wG', 'Agustin', 'Echeverry', '+54 291 000-0018', 'MDominguez@hospital.gob.ar', 0, 19),
(20, 10000019, '$2y$10$PLF2a.34MUuqZBQz4FDBeOuQpndFiPrteqq25TZr3hsjk5ak.uZgC', 'Lucia', 'Graci', '+54 291 000-0019', 'LGraci@hospital.gob.ar', 0, 20);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `usuariosview`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `usuariosview` (
`Legajo` int(8) unsigned
,`DNI` int(8) unsigned
,`Nombre` varchar(65)
,`Email` varchar(64)
,`Teléfono` varchar(20)
,`Código de área` int(8) unsigned
);

-- --------------------------------------------------------

--
-- Estructura para la vista `areasview`
--
DROP TABLE IF EXISTS `areasview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `areasview`  AS SELECT `areas`.`codigo` AS `Código`, `areas`.`nombre` AS `Nombre`, `areas`.`telefono` AS `Teléfono` FROM `areas` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `fichasview`
--
DROP TABLE IF EXISTS `fichasview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `fichasview`  AS SELECT `fichas`.`ID` AS `ID`, `fichas`.`DNI` AS `DNI`, `fichas`.`nombre` AS `Nombre`, `fichas`.`apellido` AS `Apellido`, `fichas`.`datosMedicos` AS `Datos médicos`, `fichas`.`usuarioLegajo` AS `Médico/Enfermero` FROM `fichas` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `reportesview`
--
DROP TABLE IF EXISTS `reportesview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `reportesview`  AS SELECT `reportes`.`ID` AS `ID`, `reportes`.`fechaCreacion` AS `Fecha de creación`, `reportes`.`fechaAtendido` AS `Fecha de atención`, `reportes`.`nivel` AS `Nivel de
emergencia`, `reportes`.`ubicacion` AS `Ubicación`, `reportes`.`areaCodigo` AS `Código de
área`, `reportes`.`usuarioLegajo` AS `Médico/
Enfermero`, `reportes`.`atendido` AS `Atendido` FROM `reportes` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `usuariosview`
--
DROP TABLE IF EXISTS `usuariosview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `usuariosview`  AS SELECT `usuarios`.`legajo` AS `Legajo`, `usuarios`.`DNI` AS `DNI`, concat(`usuarios`.`nombre`,'\n',`usuarios`.`apellido`) AS `Nombre`, `usuarios`.`email` AS `Email`, `usuarios`.`telefono` AS `Teléfono`, `usuarios`.`areaCodigo` AS `Código de área` FROM `usuarios` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `Nombre` (`nombre`);

--
-- Indices de la tabla `fichas`
--
ALTER TABLE `fichas`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `DNI` (`DNI`),
  ADD KEY `legajo` (`usuarioLegajo`);

--
-- Indices de la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `areaCodigo` (`areaCodigo`),
  ADD KEY `usuarioLegajo` (`usuarioLegajo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`legajo`),
  ADD UNIQUE KEY `DNI` (`DNI`),
  ADD KEY `_areaCodigo` (`areaCodigo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `codigo` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `fichas`
--
ALTER TABLE `fichas`
  MODIFY `ID` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `reportes`
--
ALTER TABLE `reportes`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `fichas`
--
ALTER TABLE `fichas`
  ADD CONSTRAINT `legajo` FOREIGN KEY (`usuarioLegajo`) REFERENCES `usuarios` (`legajo`);

--
-- Filtros para la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD CONSTRAINT `areaCodigo` FOREIGN KEY (`areaCodigo`) REFERENCES `areas` (`codigo`),
  ADD CONSTRAINT `usuarioLegajo` FOREIGN KEY (`usuarioLegajo`) REFERENCES `usuarios` (`legajo`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `_areaCodigo` FOREIGN KEY (`areaCodigo`) REFERENCES `areas` (`codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
