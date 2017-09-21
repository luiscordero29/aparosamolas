-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 21, 2017 at 03:32 AM
-- Server version: 10.0.32-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aparosam_codeigniter`
--

-- --------------------------------------------------------

--
-- Table structure for table `accesos`
--

CREATE TABLE `accesos` (
  `id_acceso` bigint(20) NOT NULL,
  `usuario` char(60) NOT NULL,
  `id_tutor` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `deportes`
--

CREATE TABLE `deportes` (
  `id_deporte` bigint(20) NOT NULL,
  `deporte` varchar(250) NOT NULL,
  `precio` double DEFAULT NULL,
  `tipo` enum('DORSAL','SIN DORSAL') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hijos`
--

CREATE TABLE `hijos` (
  `id_hijo` bigint(20) NOT NULL,
  `id_tutor` bigint(20) DEFAULT NULL,
  `dni` char(30) DEFAULT NULL,
  `nombres` varchar(120) DEFAULT NULL,
  `apellido_1` varchar(120) DEFAULT NULL,
  `apellido_2` varchar(120) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `centro_escolar` text,
  `colegio` enum('SI','NO') DEFAULT NULL,
  `sexo` enum('MASCULINO','FEMENINO') DEFAULT NULL,
  `foto` text,
  `afoto` enum('SI','NO') NOT NULL,
  `estatus` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `familia` enum('SI','NO') NOT NULL DEFAULT 'NO',
  `descuento_1` enum('SI','NO','','') NOT NULL DEFAULT 'NO',
  `descuento_2` enum('SI','NO','','') NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inscripciones`
--

CREATE TABLE `inscripciones` (
  `id_inscripcion` bigint(20) NOT NULL,
  `id_hijo` bigint(20) DEFAULT NULL,
  `id_deporte` bigint(20) DEFAULT NULL,
  `valor` varchar(60) DEFAULT NULL,
  `descuento` double DEFAULT NULL,
  `precio` double DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `estatus` enum('ACTIVO','INACTIVO','ELIMINADO') DEFAULT 'ACTIVO',
  `modificar` enum('SI','NO') DEFAULT 'NO',
  `pagado` enum('MITAD','COMPLETO','NO') DEFAULT 'NO',
  `estado` enum('NO ENVIADO','ENVIADO','DEVUELTO') DEFAULT 'NO ENVIADO',
  `porcentajes` enum('0','50','100') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `periodos`
--

CREATE TABLE `periodos` (
  `id_periodo` bigint(20) NOT NULL,
  `periodo` varchar(100) DEFAULT NULL,
  `estatus` enum('ABIERTAS','CERRADAS') DEFAULT 'CERRADAS'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `poblaciones`
--

CREATE TABLE `poblaciones` (
  `id_poblacion` bigint(20) NOT NULL,
  `poblacion` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tutores`
--

CREATE TABLE `tutores` (
  `id_tutor` bigint(20) NOT NULL,
  `dni` char(60) NOT NULL,
  `nombres` varchar(120) NOT NULL,
  `apellidos` varchar(120) NOT NULL,
  `direccion` text NOT NULL,
  `id_poblacion` bigint(20) DEFAULT NULL,
  `codigo_postal` char(60) NOT NULL,
  `telefono_movil` char(30) NOT NULL,
  `telefono_fijo` char(30) DEFAULT NULL,
  `email_principal` text NOT NULL,
  `email_secundario` text,
  `pareja_nombres` varchar(120) DEFAULT NULL,
  `pareja_apellidos` varchar(120) DEFAULT NULL,
  `pareja_movil` char(30) DEFAULT NULL,
  `cuenta_bancaria` char(60) NOT NULL,
  `noticias` enum('NO','SI') NOT NULL DEFAULT 'NO',
  `condiciones_1` enum('NO','SI') NOT NULL DEFAULT 'NO',
  `condiciones_2` enum('NO','SI') NOT NULL DEFAULT 'NO',
  `familia` enum('SI','NO','','') NOT NULL DEFAULT 'NO',
  `carnet` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` bigint(20) NOT NULL,
  `usuario` char(60) NOT NULL,
  `clave` text NOT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `tipo` enum('ADMINISTRADOR','SUPERVISOR','USUARIO') DEFAULT 'USUARIO',
  `activo` enum('SI','NO') DEFAULT 'NO',
  `llave` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accesos`
--
ALTER TABLE `accesos`
  ADD PRIMARY KEY (`id_acceso`),
  ADD KEY `accesos_usuario` (`usuario`),
  ADD KEY `accesos_id_tutor` (`id_tutor`);

--
-- Indexes for table `deportes`
--
ALTER TABLE `deportes`
  ADD PRIMARY KEY (`id_deporte`),
  ADD UNIQUE KEY `deporte` (`deporte`);

--
-- Indexes for table `hijos`
--
ALTER TABLE `hijos`
  ADD PRIMARY KEY (`id_hijo`),
  ADD KEY `hijos_id_tutor` (`id_tutor`);

--
-- Indexes for table `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`id_inscripcion`),
  ADD KEY `inscripciones_id_hijo` (`id_hijo`),
  ADD KEY `inscripciones_id_deporte` (`id_deporte`);

--
-- Indexes for table `periodos`
--
ALTER TABLE `periodos`
  ADD PRIMARY KEY (`id_periodo`),
  ADD UNIQUE KEY `periodo` (`periodo`);

--
-- Indexes for table `poblaciones`
--
ALTER TABLE `poblaciones`
  ADD PRIMARY KEY (`id_poblacion`),
  ADD UNIQUE KEY `poblacion` (`poblacion`);

--
-- Indexes for table `tutores`
--
ALTER TABLE `tutores`
  ADD PRIMARY KEY (`id_tutor`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD KEY `tutores_id_poblacion` (`id_poblacion`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accesos`
--
ALTER TABLE `accesos`
  MODIFY `id_acceso` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=333;
--
-- AUTO_INCREMENT for table `deportes`
--
ALTER TABLE `deportes`
  MODIFY `id_deporte` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `hijos`
--
ALTER TABLE `hijos`
  MODIFY `id_hijo` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=467;
--
-- AUTO_INCREMENT for table `inscripciones`
--
ALTER TABLE `inscripciones`
  MODIFY `id_inscripcion` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;
--
-- AUTO_INCREMENT for table `periodos`
--
ALTER TABLE `periodos`
  MODIFY `id_periodo` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `poblaciones`
--
ALTER TABLE `poblaciones`
  MODIFY `id_poblacion` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT for table `tutores`
--
ALTER TABLE `tutores`
  MODIFY `id_tutor` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=334;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=356;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `accesos`
--
ALTER TABLE `accesos`
  ADD CONSTRAINT `accesos_id_tutor` FOREIGN KEY (`id_tutor`) REFERENCES `tutores` (`id_tutor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accesos_usuario` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hijos`
--
ALTER TABLE `hijos`
  ADD CONSTRAINT `hijos_id_tutor` FOREIGN KEY (`id_tutor`) REFERENCES `tutores` (`id_tutor`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD CONSTRAINT `inscripciones_id_deporte` FOREIGN KEY (`id_deporte`) REFERENCES `deportes` (`id_deporte`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inscripciones_id_hijo` FOREIGN KEY (`id_hijo`) REFERENCES `hijos` (`id_hijo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tutores`
--
ALTER TABLE `tutores`
  ADD CONSTRAINT `tutores_id_poblacion` FOREIGN KEY (`id_poblacion`) REFERENCES `poblaciones` (`id_poblacion`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
