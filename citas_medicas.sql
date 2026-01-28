-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-01-2026 a las 21:04:17
-- Versión del servidor: 8.0.44
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `citas_medicas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `phone` int DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `rol` varchar(20) DEFAULT NULL,
  `lastLogin` date DEFAULT NULL,
  `state` varchar(20) NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `name`, `age`, `phone`, `email`, `pass`, `rol`, `lastLogin`, `state`) VALUES
(2, 'Maria Garcia Perez', 37, 99431277, 'Maria.Garcia@example.com', '$2a$12$flCLyEvq1vMg0GkHPKfIH.drojx2WB7fpl0dzAq8IAYqIcbRKdSSa', 'admin', '2026-03-15', 'Activo'),
(3, 'Juana Vargas', 33, 88283463, 'Juana.Vargas@gmail.com', '$2a$12$.C7awtJKxgcOjcc7wbuwc.ny/rO8eQhPB/fCJkcedK697oTSxxXni', 'admin', '2026-01-28', 'Activo'),
(4, 'Pablo Ramirez', 27, 88283463, 'Pablo.Ramirez@example.com', '$2y$10$SljsRGHQVixpFfbpXWewK.SuYG3PR6cbur8rWepYuJQlfZ2TTTrgq', 'admin', '2026-01-28', 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE `cita` (
  `id` int NOT NULL,
  `fecha` date DEFAULT NULL,
  `hour` time DEFAULT NULL,
  `paciente` int DEFAULT NULL,
  `doctor` int DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`id`, `fecha`, `hour`, `paciente`, `doctor`, `state`, `description`) VALUES
(1, '2026-01-29', '08:00:00', 1, 1, 'pendiente', 'Consulta general'),
(2, '2026-01-29', '09:00:00', 2, 2, 'confirmada', 'Chequeo cardiológico'),
(3, '2026-01-29', '10:00:00', 3, 3, 'confirmada', 'Dolor de oído'),
(4, '2026-01-29', '11:00:00', 4, 4, 'confirmada', 'Examen visual'),
(5, '2026-01-30', '08:30:00', 5, 1, 'pendiente', 'Control general'),
(6, '2026-01-30', '09:30:00', 6, 2, 'cancelada', 'Electrocardiograma'),
(7, '2026-01-30', '10:30:00', 7, 3, 'pendiente', 'Congestión nasal'),
(8, '2026-01-30', '11:30:00', 8, 4, 'pendiente', 'Revisión de lentes'),
(9, '2026-02-01', '08:00:00', 9, 1, 'pendiente', 'Dolor abdominal'),
(10, '2026-02-01', '09:00:00', 10, 2, 'confirmada', 'Presión arterial alta'),
(11, '2026-02-01', '10:00:00', 1, 3, 'confirmada', 'Infección de garganta'),
(12, '2026-02-01', '11:00:00', 2, 4, 'pendiente', 'Visión borrosa'),
(13, '2026-02-02', '08:30:00', 3, 1, 'pendiente', 'Chequeo anual'),
(14, '2026-02-02', '09:30:00', 4, 2, 'pendiente', 'Seguimiento cardíaco'),
(15, '2026-02-02', '10:30:00', 5, 3, 'cancelada', 'Zumbido en oído'),
(16, '2026-02-02', '11:30:00', 6, 4, 'pendiente', 'Control optométrico'),
(17, '2026-02-03', '08:00:00', 7, 1, 'pendiente', 'Fiebre persistente'),
(18, '2026-02-03', '09:00:00', 8, 2, 'pendiente', 'Ritmo cardíaco irregular'),
(19, '2026-02-03', '10:00:00', 9, 3, 'confirmada', 'Problemas respiratorios'),
(20, '2026-02-03', '11:00:00', 10, 4, 'cancelada', 'Evaluación visual'),
(21, '2026-02-04', '08:30:00', 1, 1, 'confirmada', 'Consulta general'),
(22, '2026-02-04', '09:30:00', 2, 2, 'confirmada', 'Control de colesterol'),
(23, '2026-02-04', '10:30:00', 3, 3, 'cancelada', 'Dolor de garganta'),
(24, '2026-02-04', '11:30:00', 4, 4, 'pendiente', 'Revisión ocular'),
(25, '2026-02-05', '08:00:00', 5, 1, 'cancelada', 'Chequeo preventivo'),
(26, '2026-01-28', '07:30:00', 1, 11, 'confirmada', 'Revisión de hemorroides'),
(27, '2026-01-31', '14:30:00', 1, 1, 'pendiente', 'Dolor punzante en el hombro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctor`
--

CREATE TABLE `doctor` (
  `id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `phone` int DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `rol` varchar(20) DEFAULT NULL,
  `specialty` varchar(255) DEFAULT NULL,
  `state` varchar(20) NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `doctor`
--

INSERT INTO `doctor` (`id`, `name`, `age`, `phone`, `email`, `pass`, `rol`, `specialty`, `state`) VALUES
(1, 'Dra. Ana López', 38, 87776666, 'ana.lopez@hospital.com', '$2a$12$ivx121IqZIP/lnQ6..XAcOhlaNJ4D.yd.5ZCoh2g/Hdek1xJCBWp.', 'doctor', 'Medicina General', 'Activo'),
(2, 'Carlos Méndez', 45, 22223333, 'cmendez@hospital.com', '$2a$12$bwEENFzzuIqMlU0j4aQe4ubon2ZOnTR.w/hXRmbbcCGJyiVvKCSzO', 'doctor', 'Cardiología', 'Activo'),
(3, 'Maria Méndez', 36, 88887777, 'Mmendez@hospital.com', '$2a$12$2UIdtl./qPTKhXlNh9M9Pux9dDMzIPyg2OfzIdNNCSJrPq/lPuSbS', 'doctor', 'Otorrinolaringia', 'Activo'),
(4, 'Gerardo Perez', 37, 88283465, 'GPerez@hospital.com', '$2a$12$vbWq5x87Kc601tvIJBQeu.roQq3Vd/unAljmomiNiKQIc4ndR16yy', 'doctor', 'Optometria', 'Activo'),
(5, 'Dr. Juan Pérez', 42, 86665555, 'juan.perez@hospital.com', '$2a$12$T5gO88ZJ3iTu9m.JgSYJwO7Ehro7K8cw.ESUc2rvI.GBUWun/rCYy', 'doctor', 'Pediatría', 'Inactivo'),
(11, 'Francisco Rojas', 44, 88283463, 'francisco.rojas@gmail.com', '$2y$10$HR7IMkzDRDV0vRfUkEXqKeg/xw.ORhQOAsapibb28MPEe2S.jTeRO', 'doctor', 'Urologia', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `phone` int DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `rol` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `state` varchar(20) NOT NULL DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`id`, `name`, `age`, `phone`, `email`, `pass`, `rol`, `address`, `state`) VALUES
(1, 'Pedro Ramírez', 30, 70001111, 'pedro@gmail.com', '$2a$12$LDiu.IXd/WlvJ0oy9Yc1.eqEiqDXnDhwXuBZmXK.20aEQday.X2zS', 'paciente', 'San José', 'Activo'),
(2, 'María Torres', 25, 70002222, 'maria@gmail.com', '$2a$12$Q/CouM3DQwnn9xVmzpXuOu3VW78e1fs08wCYDWpY7J2oKwbFaZfKi', 'paciente', 'Cartago', 'Inactivo'),
(3, 'Luis Fernández', 40, 70003333, 'luis@gmail.com', '$2a$12$c6p3xmZcJ58Af/yyIQesmO/ww3.B7lUShkwDy5mty6IuDLM7Mc6ui', 'paciente', 'Heredia', 'Activo'),
(4, 'Sofía Morales', 29, 70004444, 'sofia@gmail.com', '$2a$12$8oMTnRtFZBq5PATtCO.1sOqO6eMqXn1quxeP/cIQdBmSdPgwvA6cC', 'paciente', 'Alajuela', 'Activo'),
(5, 'Daniel Rojas', 35, 70005555, 'daniel@gmail.com', '$2a$12$02b5Mo.IxrErKlOPGjNwQeRPbuTpIsvPEx5kGzlJF0IWk3j9CMh5C', 'paciente', 'Limón', 'Activo'),
(6, 'Andrea Vargas', 22, 70006666, 'andrea@gmail.com', '$2a$12$QWF5AN4qaC9vytHBI4iQXekeizZV0hYejj/F40HOKEaJ.sUk3oTMC', 'paciente', 'Puntarenas', 'Activo'),
(7, 'José Navarro', 50, 70007777, 'jose@gmail.com', '$2a$12$fyMuZwbU9NzjNDPiR.wkZe27JvWfHTyfje0JI5.oibyhR06XjbcR2', 'paciente', 'San Carlos', 'Activo'),
(8, 'Paola Jiménez', 33, 70008888, 'paola@gmail.com', '$2a$12$pyZqm33bE69RpeQShfcM0uFnw7kuQBySo5Z0EHBuBDdsxfgv2VxuW', 'paciente', 'Grecia', 'Activo'),
(9, 'Ricardo Solís', 45, 70009999, 'ricardo@gmail.com', '$2a$12$bcE86tsIN6qSP6FB8pIAbe.V/KziPE1D20mj3M6xjd76OvZcvTq06', 'paciente', 'Turrialba', 'Activo'),
(10, 'Natalia Castro', 27, 70001010, 'natalia@gmail.com', '$2a$12$VYZB/vEysVFYS4BMUlSoKub4W23XP9ejf58uFKRn2p6gTGbPKVO1C', 'paciente', 'Escazú', 'Activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_doctor` (`doctor`),
  ADD KEY `fk_paciente` (`paciente`);

--
-- Indices de la tabla `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `fk_doctor` FOREIGN KEY (`doctor`) REFERENCES `doctor` (`id`),
  ADD CONSTRAINT `fk_paciente` FOREIGN KEY (`paciente`) REFERENCES `paciente` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
