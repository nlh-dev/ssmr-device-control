-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-02-2025 a las 20:47:28
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `controles`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departments`
--

CREATE TABLE `departments` (
  `department_ID` int(11) NOT NULL,
  `department_Name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `departments`
--

INSERT INTO `departments` (`department_ID`, `department_Name`) VALUES
(1, 'PISO 2, LADO A'),
(2, 'PISO 2, LADO B'),
(3, 'PISO 3, LADO A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devices`
--

CREATE TABLE `devices` (
  `device_ID` int(11) NOT NULL,
  `device_userFullName` text NOT NULL,
  `device_recievedByName` text NOT NULL,
  `device_Description` text NOT NULL,
  `device_serialCode` varchar(50) NOT NULL,
  `device_RoomCode` varchar(50) NOT NULL,
  `device_department_ID` int(50) NOT NULL,
  `device_deliveryDate` varchar(15) NOT NULL,
  `device_withdrawalDate` varchar(15) NOT NULL,
  `device_withdrawByName` text NOT NULL,
  `device_returnedByName` text NOT NULL,
  `device_isDelivered` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `devices`
--

INSERT INTO `devices` (`device_ID`, `device_userFullName`, `device_recievedByName`, `device_Description`, `device_serialCode`, `device_RoomCode`, `device_department_ID`, `device_deliveryDate`, `device_withdrawalDate`, `device_withdrawByName`, `device_returnedByName`, `device_isDelivered`) VALUES
(1, 'USUARIO ADMINISTRADOR', 'DANNY MORAN', 'CONTROL SAMSUNG', 'HM-2-636', 'A-303', 1, '04/02/2025', '07/02/2025', 'USUARIO ADMINISTRADOR', 'JUAN BOZO', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `observations`
--

CREATE TABLE `observations` (
  `observation_ID` int(11) NOT NULL,
  `observation_user` text NOT NULL,
  `observation_reason` text NOT NULL,
  `observation_text` text NOT NULL,
  `observation_creationDate` varchar(15) NOT NULL,
  `observation_isChecked` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `role_ID` int(11) NOT NULL,
  `role_Name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`role_ID`, `role_Name`) VALUES
(1, 'Usuario Administrador'),
(2, 'Usuario Estandar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_ID` int(11) NOT NULL,
  `user_FirstName` text NOT NULL,
  `user_LastName` text NOT NULL,
  `user_userName` varchar(50) NOT NULL,
  `user_Password` varchar(50) NOT NULL,
  `user_role_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_ID`, `user_FirstName`, `user_LastName`, `user_userName`, `user_Password`, `user_role_ID`) VALUES
(1, 'Usuario', 'Administrador', 'administrador', 'HospitalAdmin99', 1),
(2, 'Hector', 'Navarro', 'hectorlnavarro', '27822521', 2),
(19, 'Juan Carlos', 'Bozo', 'juancbozo', 'juanc12345', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_ID`);

--
-- Indices de la tabla `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`device_ID`),
  ADD KEY `device_department_ID` (`device_department_ID`);

--
-- Indices de la tabla `observations`
--
ALTER TABLE `observations`
  ADD PRIMARY KEY (`observation_ID`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_ID`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_ID`),
  ADD KEY `user_role_ID` (`user_role_ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `departments`
--
ALTER TABLE `departments`
  MODIFY `department_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `devices`
--
ALTER TABLE `devices`
  MODIFY `device_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `observations`
--
ALTER TABLE `observations`
  MODIFY `observation_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `role_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `devices`
--
ALTER TABLE `devices`
  ADD CONSTRAINT `devices_ibfk_1` FOREIGN KEY (`device_department_ID`) REFERENCES `departments` (`department_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_role_ID`) REFERENCES `roles` (`role_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
