-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 10-05-2024 a las 20:23:26
-- Versión del servidor: 8.2.0
-- Versión de PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pingpong`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadopartido`
--

DROP TABLE IF EXISTS `estadopartido`;
CREATE TABLE IF NOT EXISTS `estadopartido` (
  `id_estadoPartido` int NOT NULL AUTO_INCREMENT,
  `estadoPartido` varchar(150) NOT NULL,
  PRIMARY KEY (`id_estadoPartido`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `estadopartido`
--

INSERT INTO `estadopartido` (`id_estadoPartido`, `estadoPartido`) VALUES
(1, 'En espera de resultado'),
(2, 'No se jugo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadoserie`
--

DROP TABLE IF EXISTS `estadoserie`;
CREATE TABLE IF NOT EXISTS `estadoserie` (
  `id_estadoSerie` int NOT NULL AUTO_INCREMENT,
  `estadoSerie` varchar(150) NOT NULL,
  PRIMARY KEY (`id_estadoSerie`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `estadoserie`
--

INSERT INTO `estadoserie` (`id_estadoSerie`, `estadoSerie`) VALUES
(1, 'En espera de ganador'),
(2, 'Finalizada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadotorneo`
--

DROP TABLE IF EXISTS `estadotorneo`;
CREATE TABLE IF NOT EXISTS `estadotorneo` (
  `id_estadoTorneo` int NOT NULL AUTO_INCREMENT,
  `estadoTorneo` varchar(150) NOT NULL,
  PRIMARY KEY (`id_estadoTorneo`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `estadotorneo`
--

INSERT INTO `estadotorneo` (`id_estadoTorneo`, `estadoTorneo`) VALUES
(1, 'activo'),
(2, 'inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formatopartido`
--

DROP TABLE IF EXISTS `formatopartido`;
CREATE TABLE IF NOT EXISTS `formatopartido` (
  `id_formatoPartido` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) NOT NULL,
  `juegosMaximos` int NOT NULL,
  PRIMARY KEY (`id_formatoPartido`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `formatopartido`
--

INSERT INTO `formatopartido` (`id_formatoPartido`, `descripcion`, `juegosMaximos`) VALUES
(1, 'Al mejor de 1', 1),
(2, 'Al mejor de 3', 3),
(3, 'Al mejor de 5', 5),
(4, 'Al mejor de 7', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero`
--

DROP TABLE IF EXISTS `genero`;
CREATE TABLE IF NOT EXISTS `genero` (
  `id_genero` int NOT NULL AUTO_INCREMENT,
  `genero` varchar(100) NOT NULL,
  PRIMARY KEY (`id_genero`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `genero`
--

INSERT INTO `genero` (`id_genero`, `genero`) VALUES
(1, 'Masculino'),
(2, 'Femenino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugador`
--

DROP TABLE IF EXISTS `jugador`;
CREATE TABLE IF NOT EXISTS `jugador` (
  `id_jugador` int NOT NULL AUTO_INCREMENT,
  `nombre_jugador` varchar(180) NOT NULL,
  `edad` int NOT NULL,
  `telefono` varchar(9) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `id_nivelHabilidad` int NOT NULL,
  `id_genero` int NOT NULL,
  PRIMARY KEY (`id_jugador`),
  KEY `id_genero` (`id_genero`),
  KEY `id_nivelHabilidad` (`id_nivelHabilidad`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `jugador`
--

INSERT INTO `jugador` (`id_jugador`, `nombre_jugador`, `edad`, `telefono`, `correo`, `id_nivelHabilidad`, `id_genero`) VALUES
(5, 'Carlos', 18, '7479-8091', 'cv@gmail.com', 4, 1),
(2, 'Carlos Gómez', 30, '7786-5151', 'carlosgomez@example.com', 1, 1),
(3, 'Jonathan', 25, '7202-2905', 'jonathanmendoza2001.jm@gmail.com', 5, 1),
(4, 'Karina', 22, '7777-7475', 'ko@gmail.com', 2, 2),
(6, 'Carlos', 18, '7479-8095', 'cva@gmail.com', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugador_torneo`
--

DROP TABLE IF EXISTS `jugador_torneo`;
CREATE TABLE IF NOT EXISTS `jugador_torneo` (
  `id_jugadorTorneo` int NOT NULL AUTO_INCREMENT,
  `id_jugador` int NOT NULL,
  `id_torneo` int NOT NULL,
  PRIMARY KEY (`id_jugadorTorneo`),
  KEY `id_jugador` (`id_jugador`),
  KEY `id_torneo` (`id_torneo`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `jugador_torneo`
--

INSERT INTO `jugador_torneo` (`id_jugadorTorneo`, `id_jugador`, `id_torneo`) VALUES
(1, 2, 1),
(3, 3, 3),
(4, 3, 4),
(5, 4, 4),
(6, 5, 4),
(7, 4, 4),
(8, 5, 4),
(9, 3, 4);

--
-- Disparadores `jugador_torneo`
--
DROP TRIGGER IF EXISTS `decrementarJugadores`;
DELIMITER $$
CREATE TRIGGER `decrementarJugadores` AFTER DELETE ON `jugador_torneo` FOR EACH ROW BEGIN
    -- Decrementar el conteo de jugadores en el torneo relacionado
    UPDATE torneo
    SET jugadores = GREATEST(COALESCE(jugadores, 0) - 1, 0)
    WHERE id_torneo = OLD.id_torneo;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `incrementarJugadores`;
DELIMITER $$
CREATE TRIGGER `incrementarJugadores` AFTER INSERT ON `jugador_torneo` FOR EACH ROW BEGIN
    -- Incrementar el conteo de jugadores en el torneo relacionado
    UPDATE torneo
    SET jugadores = COALESCE(jugadores, 0) + 1
    WHERE id_torneo = NEW.id_torneo;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivelhabilidad`
--

DROP TABLE IF EXISTS `nivelhabilidad`;
CREATE TABLE IF NOT EXISTS `nivelhabilidad` (
  `id_nivelHabilidad` int NOT NULL AUTO_INCREMENT,
  `nivelHabilidad` varchar(100) NOT NULL,
  PRIMARY KEY (`id_nivelHabilidad`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `nivelhabilidad`
--

INSERT INTO `nivelhabilidad` (`id_nivelHabilidad`, `nivelHabilidad`) VALUES
(1, 'Jugadores Principiantes (0 - 1000)'),
(2, 'Jugadores Intermedios (1001 - 1800)'),
(3, 'Jugadores Avanzados (1801 - 2200)'),
(4, 'Jugadores Expertos (2201 - 2500)'),
(5, 'Jugadores Semi-Profesionales y Profesionales (2500+)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidos`
--

DROP TABLE IF EXISTS `partidos`;
CREATE TABLE IF NOT EXISTS `partidos` (
  `id_partidos` int NOT NULL AUTO_INCREMENT,
  `numeroPartido` int NOT NULL,
  `id_serie` int NOT NULL,
  `ganadorPartido` int NOT NULL,
  `id_estadoPartido` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_partidos`),
  KEY `ganadorPartido` (`ganadorPartido`),
  KEY `id_serie` (`id_serie`),
  KEY `id_estadoPartido` (`id_estadoPartido`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `partidos`
--

INSERT INTO `partidos` (`id_partidos`, `numeroPartido`, `id_serie`, `ganadorPartido`, `id_estadoPartido`) VALUES
(1, 1, 2, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `serie`
--

DROP TABLE IF EXISTS `serie`;
CREATE TABLE IF NOT EXISTS `serie` (
  `id_serie` int NOT NULL AUTO_INCREMENT,
  `id_torneo` int NOT NULL,
  `id_jugador1` int NOT NULL,
  `id_jugador2` int NOT NULL,
  `fechaHora` datetime NOT NULL,
  `ganadorSerie` int NOT NULL,
  `id_estadoSerie` int NOT NULL DEFAULT '1',
  `etapaTorneo` varchar(100) NOT NULL DEFAULT 'Cuartos',
  PRIMARY KEY (`id_serie`),
  KEY `id_torneo` (`id_torneo`),
  KEY `id_jugador1` (`id_jugador1`),
  KEY `id_jugador2` (`id_jugador2`),
  KEY `ganadorSerie` (`ganadorSerie`),
  KEY `id_estadoSerie` (`id_estadoSerie`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `serie`
--

INSERT INTO `serie` (`id_serie`, `id_torneo`, `id_jugador1`, `id_jugador2`, `fechaHora`, `ganadorSerie`, `id_estadoSerie`, `etapaTorneo`) VALUES
(2, 1, 1, 2, '2023-03-14 12:34:56', 2, 1, 'Cuartos');

--
-- Disparadores `serie`
--
DROP TRIGGER IF EXISTS `CrearPartidosDespuesDeSerie`;
DELIMITER $$
CREATE TRIGGER `CrearPartidosDespuesDeSerie` AFTER INSERT ON `serie` FOR EACH ROW BEGIN
    DECLARE juegosMax INT;
    
    -- Buscar el número máximo de juegos para el formato de partido del torneo asociado a la nueva serie
    SELECT f.juegosMaximos INTO juegosMax
    FROM formatoPartido AS f
    JOIN torneo AS t ON f.id_formatoPartido = t.id_formatoPartido
    WHERE t.id_torneo = NEW.id_torneo;
    
    -- Crear los partidos basados en el número de juegos máximos
    WHILE juegosMax > 0 DO
        INSERT INTO partidos (numeroPartido, id_serie, ganadorPartido, id_estadoPartido)
        VALUES (juegosMax, NEW.id_serie, 0, 1); -- Asumiendo que 'ganadorPartido' puede ser 0 para indicar que aún no hay ganador
        SET juegosMax = juegosMax - 1;
    END WHILE;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `actualizarEtapaTorneo`;
DELIMITER $$
CREATE TRIGGER `actualizarEtapaTorneo` AFTER INSERT ON `serie` FOR EACH ROW BEGIN
    DECLARE totalSeries INT;
    DECLARE seriesCuartos INT;
    DECLARE seriesSemifinales INT;
    DECLARE seriesFinal INT;

    -- Contar el total de series en el torneo
    SELECT COUNT(*) INTO totalSeries FROM serie WHERE id_torneo = NEW.id_torneo;

    -- Calcular el número de series de cada etapa
    SET seriesCuartos = FLOOR(totalSeries * 0.5);
    SET seriesSemifinales = FLOOR(totalSeries * 0.25);
    SET seriesFinal = FLOOR(totalSeries * 0.125);

    -- Actualizar el campo 'etapaTorneo' de la nueva serie
    IF totalSeries = 1 THEN
        UPDATE serie SET etapaTorneo = 'Final' WHERE id_serie = NEW.id_serie;
    ELSEIF totalSeries <= seriesCuartos THEN
        UPDATE serie SET etapaTorneo = 'Cuartos' WHERE id_serie = NEW.id_serie;
    ELSEIF totalSeries <= (seriesCuartos + seriesSemifinales) THEN
        UPDATE serie SET etapaTorneo = 'Semifinales' WHERE id_serie = NEW.id_serie;
    ELSE
        UPDATE serie SET etapaTorneo = 'Final' WHERE id_serie = NEW.id_serie;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipotorneo`
--

DROP TABLE IF EXISTS `tipotorneo`;
CREATE TABLE IF NOT EXISTS `tipotorneo` (
  `id_tipoTorneo` int NOT NULL AUTO_INCREMENT,
  `tipoTorneo` varchar(150) NOT NULL,
  PRIMARY KEY (`id_tipoTorneo`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tipotorneo`
--

INSERT INTO `tipotorneo` (`id_tipoTorneo`, `tipoTorneo`) VALUES
(1, 'Eliminacion Directa'),
(2, 'Eliminacion Directa (dobles)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `torneo`
--

DROP TABLE IF EXISTS `torneo`;
CREATE TABLE IF NOT EXISTS `torneo` (
  `id_torneo` int NOT NULL AUTO_INCREMENT,
  `nombre_torneo` varchar(150) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `maxjugadores` int NOT NULL DEFAULT '8',
  `jugadores` int DEFAULT NULL,
  `id_estadoTorneo` int NOT NULL,
  `id_tipoTorneo` int NOT NULL,
  `id_nivelHabilidad` int DEFAULT NULL,
  `id_formatoPartido` int NOT NULL,
  `id_usuario` int DEFAULT NULL,
  `fechaInicio` date NOT NULL,
  PRIMARY KEY (`id_torneo`),
  KEY `id_formatoPartido` (`id_formatoPartido`),
  KEY `id_nivelHabilidad` (`id_nivelHabilidad`),
  KEY `id_estadoTorneo` (`id_estadoTorneo`),
  KEY `id_tipoTorneo` (`id_tipoTorneo`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `torneo`
--

INSERT INTO `torneo` (`id_torneo`, `nombre_torneo`, `direccion`, `maxjugadores`, `jugadores`, `id_estadoTorneo`, `id_tipoTorneo`, `id_nivelHabilidad`, `id_formatoPartido`, `id_usuario`, `fechaInicio`) VALUES
(4, 'Champions', 'Mi Casa', 8, 6, 1, 1, 5, 2, 5, '2024-05-17'),
(3, 'La Liga', 'calle3 Casa 4', 8, 1, 1, 1, 3, 2, 5, '2024-05-03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(150) NOT NULL,
  `apellido_usuario` varchar(150) NOT NULL,
  `alias_usuario` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `correo` varchar(150) NOT NULL,
  `clave` varchar(150) NOT NULL,
  `telefono` varchar(9) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `correo` (`correo`),
  UNIQUE KEY `telefono` (`telefono`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `apellido_usuario`, `alias_usuario`, `correo`, `clave`, `telefono`) VALUES
(5, 'Jonathan', 'Mendoza', 'jonaMendo', 'jm@gmail.com', '$2y$10$6KlIR22YjCI6thHyo3SrMO61UYVKPhX01gYswgXPB2znXxTfizFB2', '7202-2904');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
