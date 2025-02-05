-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: fct-mariadb
-- Tiempo de generación: 03-02-2025 a las 16:32:30
-- Versión del servidor: 11.4.3-MariaDB-ubu2404
-- Versión de PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ies-distancias`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aux_tipo_ciclo`
--

CREATE TABLE `aux_tipo_ciclo` (
  `id_tipo` int(11) NOT NULL,
  `nombre_tipo` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `aux_tipo_ciclo`
--

INSERT INTO `aux_tipo_ciclo` (`id_tipo`, `nombre_tipo`) VALUES
(1, 'BÁSICO'),
(2, 'MEDIO'),
(3, 'SUPERIOR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centros`
--

CREATE TABLE `centros` (
  `concello` varchar(50) DEFAULT NULL,
  `codigo` int(8) NOT NULL,
  `centro_educativo` varchar(40) DEFAULT NULL,
  `telefono` varchar(9) DEFAULT NULL,
  `provincia` varchar(10) DEFAULT NULL,
  `link_fp` varchar(100) DEFAULT NULL,
  `latitud` decimal(8,6) DEFAULT NULL,
  `longitud` varchar(10) DEFAULT NULL,
  `familia_informatica` int(1) DEFAULT NULL,
  `CBIFC01` varchar(1) DEFAULT NULL,
  `CBIFC02` varchar(1) DEFAULT NULL,
  `CMIFC01` varchar(1) DEFAULT NULL,
  `CSIFC01` varchar(1) DEFAULT NULL,
  `CSIFC02` varchar(1) DEFAULT NULL,
  `CSIFC03` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `centros`
--

INSERT INTO `centros` (`concello`, `codigo`, `centro_educativo`, `telefono`, `provincia`, `link_fp`, `latitud`, `longitud`, `familia_informatica`, `CBIFC01`, `CBIFC02`, `CMIFC01`, `CSIFC01`, `CSIFC02`, `CSIFC03`) VALUES
('Coruña, A ', 15004356, 'CPR Nebrija Torre de Hércules ', '981259006', 'A Coruña', 'http://www.edu.xunta.gal/fp/centro%252F15004356', 43.364942, '-8.413776', 1, '1', '', '', '', '', ''),
('A Coruña ', 15005269, 'IES Urbano Lugrís ', '881960715', 'A Coruña', 'http://www.edu.xunta.gal/fp/centro%252F15005269', 43.350421, '-8.418370', 1, '', '1', '', '', '', ''),
('Coruña, A ', 15005270, 'CPR Afundación A Coruña ', '881963018', 'A Coruña', 'http://www.edu.xunta.gal/fp/centro%252F15005270', 43.358761, '-8.411263', 1, '', '', '', '', '1', ''),
('A Coruña ', 15005397, 'IES Fernando Wirtz Suárez ', '881960260', 'A Coruña', 'http://www.edu.xunta.gal/fp/centro%252F15005397', 43.355711, '-8.405904', 1, '1', '', '', '1', '1', ''),
('Ferrol ', 15006778, 'CIFP Rodolfo Ucha Piñeiro ', '881930145', 'A Coruña', 'http://www.edu.xunta.gal/fp/centro%252F15006778', 43.481297, '-8.201922', 1, '', '1', '', '1', '1', '1'),
('Santiago de Compostela ', 15015743, 'IES Arcebispo Xelmírez I ', '881866962', 'A Coruña', 'http://www.edu.xunta.gal/fp/centro%252F15015743', 42.878291, '-8.552685', 1, '', '1', '', '1', '', ''),
('Santiago de Compostela ', 15021482, 'IES San Clemente ', '881867501', 'A Coruña', 'http://www.edu.xunta.gal/fp/centro%252F15021482', 42.878661, '-8.547374', 1, '', '', '1', '1', '1', '1'),
('Cariño', 15021755, 'IES Cabo Ortegal', '881960101', 'A Coruña', 'https://www.edu.xunta.gal/fp/centro/15021755', 43.732193, '-7.872702', 1, NULL, NULL, '1', NULL, NULL, NULL),
('Pontes de García Rodríguez, As ', 15021767, 'IES Plurilingüe Castro da Uz ', '881930001', 'A Coruña', 'http://www.edu.xunta.gal/fp/centro%252F15021767', 43.460493, '-7.854168', 1, '', '1', '', '', '', ''),
('Curtis', 15022620, 'IES de Curtis', '881880620', 'A Coruña', 'http://www.edu.xunta.gal/fp/centro%252F15022620', 43.119530, '-8.148047', 1, NULL, NULL, '1', NULL, NULL, NULL),
('Muros ', 15026388, 'IES Plurilingüe Fontexería ', '881867110', 'A Coruña', 'http://www.edu.xunta.gal/fp/centro%252F15026388', 42.789334, '-9.062777', 1, '', '1', '', '', '', ''),
('Negreira ', 15026391, 'IES Xulián Magariños ', '881867126', 'A Coruña', 'http://www.edu.xunta.gal/fp/centro%252F15026391', 42.912883, '-8.733509', 1, '', '', '', '1', '1', ''),
('Boiro ', 15026698, 'IES Espiñeira ', '881866630', 'A Coruña', 'http://www.edu.xunta.gal/fp/centro%252F15026698', 42.656691, '-8.881674', 1, '1', '', '', '', '', ''),
('Carballo ', 15027307, 'IES Isidro Parga Pondal ', '881880371', 'A Coruña', 'http://www.edu.xunta.gal/fp/centro%252F15027307', 43.221889, '-8.690883', 1, '', '', '', '1', '', ''),
('Baio (Zas) ', 15027368, 'IES Maximino Romero de Lema ', '881960015', 'A Coruña', 'http://www.edu.xunta.gal/fp/centro%252F15027368', 43.144037, '-8.956255', 1, '', '1', '', '', '', ''),
('Ribeira ', 15027711, 'IES Leliadoura ', '881867186', 'A Coruña', 'http://www.edu.xunta.gal/fp/centro%252F15027711', 42.553199, '-9.001451', 1, '1', '', '', '1', '1', ''),
('Ames ', 15027721, 'IES Plurilingüe de Ames ', '881866729', 'A Coruña', 'http://www.edu.xunta.gal/fp/centro%252F15027721', 42.867897, '-8.658525', 1, '', '1', '', '', '', ''),
('Cambre ', 15027873, 'IES Afonso X O sabio ', '881880339', 'A Coruña', 'http://www.edu.xunta.gal/fp/centro%252F15027873', 43.301360, '-8.356084', 1, '', '1', '', '', '', ''),
('A Coruña ', 15032431, 'CPR Aula Nosa ', '981250019', 'A Coruña', 'http://www.edu.xunta.gal/fp/centro%252F15032431', 43.362260, '-8.425544', 1, '', '1', '', '', '', ''),
('Chantada', 27003175, 'IES Val do Asma', '982870236', 'Lugo', 'http://www.edu.xunta.gal/fp/centro%252F27003175', 42.607914, '-7.757903', 1, NULL, NULL, NULL, NULL, NULL, NULL),
('Vilalba ', 27013326, 'IES Lois Peña Novo ', '982870860', 'Lugo', 'http://www.edu.xunta.gal/fp/centro%252F27013326', 43.293025, '-7.683204', 1, '', '1', '', '1', '', ''),
('Fonsagrada (A) ', 27014811, 'IES Plurilingüe Fontem Albei ', '982828263', 'Lugo', 'http://www.edu.xunta.gal/fp/centro%252F27014811', 43.132180, '-7.066328', 1, '', '1', '', '', '', ''),
('Monforte de Lemos ', 27015311, 'IES A Pinguela ', '982828051', 'Lugo', 'http://www.edu.xunta.gal/fp/centro%252F27013326', 42.512000, '-7.526000', 1, '', '', '1', '', '', '1'),
('Lugo ', 27015773, 'IES Muralla Romana ', '982828081', 'Lugo', 'http://www.edu.xunta.gal/fp/centro%252F27015773', 43.024031, '-7.571291', 1, '', '1', '', '1', '1', '1'),
('Monterroso ', 27016248, 'IES de Monterroso ', '982870573', 'Lugo', 'http://www.edu.xunta.gal/fp/centro%252F27016248', 42.797732, '-7.834151', 1, '', '1', '', '', '', ''),
('Cervo ', 27016509, 'IES Marqués de Sargadelos ', '982870193', 'Lugo', 'https://www.edu.xunta.gal/fp/ies-marques-sargadelos', 43.691956, '-7.437648', 1, '', '1', '', '', '', ''),
('Xove', 27016625, 'IES Illa de Sarón', '982870973', 'Lugo', 'http://www.edu.xunta.gal/fp/centro%252F27016625', 43.685754, '-7.503925', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Ourense ', 32008665, 'CPR Plurilingüe Divino Maestro ', '988217800', 'Ourense', 'http://www.edu.xunta.gal/fp/centro%252F32008665', 42.355373, '-7.864591', 1, '', '1', '', '', '', ''),
('Ourense ', 32008902, 'CIFP A Carballeira - Marcos Valcárcel', '988788470', 'Ourense', 'http://www.edu.xunta.gal/fp/centro%252F32008902', 42.331378, '-7.874870', 1, '', '1', '1', '1', '1', '1'),
('Ourense ', 32015530, 'CPR San Martín ', '988221990', 'Ourense', 'http://www.edu.xunta.gal/fp/centro%252F32015530', 42.336722, '-7.864258', 1, '1', '', '', '', '', ''),
('Bande ', 32016340, 'IES Aquis Querquernis ', '988788028', 'Ourense', 'http://www.edu.xunta.gal/fp/centro%252F32016340', 42.032705, '-7.973137', 1, '', '1', '', '', '', ''),
('Maceda ', 32016431, 'IES San Mamede ', '988788561', 'Ourense', 'http://www.edu.xunta.gal/fp/centro%252F32016431', 42.270700, '-7.655600', 1, '', '1', '1', '', '', ''),
('Rúa (A) ', 32016637, 'IES Cosme López Rodríguez ', '988310833', 'Ourense', 'http://www.edu.xunta.gal/fp/centro%252F32016637', 42.392110, '-7.128131', 1, '', '1', '', '', '', ''),
('Viana do Bolo ', 32016777, 'IES Carlos Casares ', '988788594', 'Ourense', 'http://www.edu.xunta.gal/fp/centro%252F32016777', 42.188012, '-7.103798', 1, '', '1', '', '', '', ''),
('A Estrada ', 36002359, 'IES Plurilingüe Antón Losada Diéguez', '886151924', 'Pontevedra', 'http://www.edu.xunta.gal/fp/centro%252F36002359', 42.692912, '-8.505076', 1, '', '1', '1', '', '', ''),
('Lalín ', 36004137, 'IES Ramón Mª Aller Ulloa ', '986780114', 'Pontevedra', 'https://www.edu.xunta.gal/fp/ies-ramon-m%C2%AA-aller-ulloa', 42.663811, '-8.105614', 1, '', '1', '1', '', '', '1'),
('Moaña', 36004745, 'IES Plurilingüe A Paralaia', '886120354', 'Pontevedra', 'http://www.edu.xunta.gal/fp/centro%252F36004745', 42.293963, '-8.735434', 1, NULL, NULL, NULL, NULL, NULL, NULL),
('Porriño, O ', 36007011, 'IES Pino Manso ', '886110392', 'Pontevedra', 'http://www.edu.xunta.gal/fp/centro%252F36007011', 42.159769, '-8.613560', 1, '', '1', '', '', '', ''),
('Vigo ', 36011211, 'CPR Plurilingüe San Miguel 2 ', '986293282', 'Pontevedra', 'http://www.edu.xunta.gal/fp/centro%252F36011211', 42.223560, '-8.736999', 1, '1', '', '', '', '', ''),
('Vigo ', 36011361, 'CPR Plurilingüe San José de la Guía ', '986376153', 'Pontevedra', 'http://www.edu.xunta.gal/fp/centro%252F36011361', 42.250577, '-8.696781', 1, '1', '', '', '', '', ''),
('Vigo ', 36011521, 'CPR Vivas ', '986227085', 'Pontevedra', 'http://www.edu.xunta.gal/fp/centro%252F36011521', 42.237097, '-8.723381', 1, '', '', '', '', '1', ''),
('Vigo ', 36011853, 'CPR Daniel Castelao ', '986442121', 'Pontevedra', 'http://www.edu.xunta.gal/fp/centro%252F36011853', 42.236310, '-8.714261', 1, '', '', '', '1', '1', ''),
('Vigo ', 36013795, 'CPR CEBEM ', '986419899', 'Pontevedra', 'http://www.edu.xunta.gal/fp/centro%252F36013795', 42.232807, '-8.728431', 1, '', '', '', '', '1', ''),
('Tui', 36014544, 'IES Indalecio Pérez Tizón', '886110749', 'Pontevedra', 'http://www.edu.xunta.gal/fp/centro%252F36014544', 42.050705, '-8.643054', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('Cañiza, A ', 36015101, 'IES da Cañiza ', '886110001', 'Pontevedra', 'http://www.edu.xunta.gal/fp/centro%252F36015101', 42.216095, '-8.263006', 1, '', '1', '', '', '', ''),
('Marín ', 36015159, 'IES Chan do Monte ', '886151275', 'Pontevedra', 'http://www.edu.xunta.gal/fp/centro%252F36015159', 42.389677, '-8.709937', 1, '', '1', '1', '1', '1', ''),
('Nigrán ', 36015184, 'IES Escolas Proval ', '886110369', 'Pontevedra', 'http://www.edu.xunta.gal/fp/centro%252F36015184', 42.113549, '-8.779903', 1, '1', '', '', '', '', ''),
('Redondela', 36016656, 'IES Pedro Floriani', '886120413', 'Pontevedra', 'http://www.edu.xunta.gal/fp/centro%252F36016656', 42.290322, '-8.609475', 1, NULL, NULL, NULL, NULL, NULL, NULL),
('Vigo ', 36018173, 'IES de Teis ', '886120464', 'Pontevedra', 'http://www.edu.xunta.gal/fp/centro%252F36018173', 42.251552, '-8.690046', 1, '', '1', '1', '1', '1', '1'),
('Grove (O) ', 36019232, 'IES Monte da Vila ', '886151412', 'Pontevedra', 'http://www.edu.xunta.gal/fp/centro%252F36019232', 42.490486, '-8.861638', 1, '', '', '1', '', '', ''),
('A Guarda ', 36019244, 'IES A Sangriña ', '886110060', 'Pontevedra', 'http://www.edu.xunta.gal/fp/centro%252F36019244', 41.900694, '-8.862552', 1, '', '', '1', '', '', ''),
('Cambados ', 36019396, 'IES Francisco Asorey ', '886159160', 'Pontevedra', 'http://www.edu.xunta.gal/fp/centro%252F36019396', 42.507701, '-8.811388', 1, '', '1', '', '', '', ''),
('As Neves ', 36019402, 'IES Pazo da Mercé ', '886110110', 'Pontevedra', 'http://www.edu.xunta.gal/fp/centro%252F36019402', 42.094696, '-8.423791', 1, '', '1', '1', '', '', ''),
('Cangas ', 36019475, 'IES de Rodeira ', '986303933', 'Pontevedra', 'http://www.edu.xunta.gal/fp/centro%252F36019475', 42.262979, '-8.771172', 1, '', '', '', '1', '', ''),
('Vilagarcía de Arousa ', 36019669, 'IES Armando Cotarelo Valledor ', '986512311', 'Pontevedra', 'http://www.edu.xunta.gal/fp/centro%252F36019669', 42.589820, '-8.784041', 1, '1', '', '1', '1', '', ''),
('Ponteareas ', 36024781, 'IES do Barral ', '986644406', 'Pontevedra', 'http://www.edu.xunta.gal/fp/centro%252F36024781', 42.175014, '-8.491207', 1, '', '1', '', '', '', ''),
('Vigo ', 36025037, 'CPR Plurilingüe Las Acacias-Montecastelo', '', 'Pontevedra', 'http://www.edu.xunta.gal/fp/centro%252F36025037', 42.213636, '-8.6928669', 1, '', '', '1', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciclos_formativos`
--

CREATE TABLE `ciclos_formativos` (
  `codigo` varchar(10) NOT NULL,
  `familia_profesional` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ciclos_formativos`
--

INSERT INTO `ciclos_formativos` (`codigo`, `familia_profesional`, `nombre`, `tipo`) VALUES
('CBIFC01', 1, 'Informática e comunicacións', 1),
('CBIFC02', 1, 'Informática de oficina', 1),
('CMIFC01', 1, 'Sistemas microinformáticos e redes', 2),
('CSIFC01', 1, 'Administración de sistemas informáticos en rede', 3),
('CSIFC02', 1, 'Desenvolvemento de aplicacións multiplataforma', 3),
('CSIFC03', 1, 'Desenvolvemento de aplicacións web', 3),
('ZSIFC03', 1, '[FPD] Desenvolvemento de aplicacións web', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concellos_galicia`
--

CREATE TABLE `concellos_galicia` (
  `Provincia` varchar(10) DEFAULT NULL,
  `Concello` varchar(31) NOT NULL,
  `Latitud` varchar(8) DEFAULT NULL,
  `Longitud` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `concellos_galicia`
--

INSERT INTO `concellos_galicia` (`Provincia`, `Concello`, `Latitud`, `Longitud`) VALUES
('Lugo', 'Abadín', '43.36666', '-7.483333'),
('A Coruña', 'Abegondo', '43.21667', '-8.283333'),
('Pontevedra', 'Agolada', '42.76227', '-8.019424'),
('Lugo', 'Alfoz', '43.52817', '-7.414435'),
('Ourense', 'Allariz', '42.19012', '-7.801597'),
('A Coruña', 'Ames', '42.9', '-8.633333'),
('Ourense', 'Amoeiro', '42.40992', '-7.954321'),
('Lugo', 'Antas de Ulla', '42.78225', '-7.891078'),
('A Coruña', 'Aranga', '43.23333', '-8.016667'),
('Pontevedra', 'Arbo', '42.1145', '-8.319313'),
('A Coruña', 'Ares', '43.4263', '-8.247746'),
('Ourense', 'Arnoia (A)', '42.25028', '-8.133056'),
('A Coruña', 'Arteixo', '43.30451', '-8.511387'),
('A Coruña', 'Arzúa', '42.92717', '-8.164196'),
('Ourense', 'Avión', '42.37632', '-8.250866'),
('Pontevedra', 'Baiona', '42.11809', '-8.84958'),
('Lugo', 'Baleira', '43.00167', '-7.239167'),
('Ourense', 'Baltar', '41.94975', '-7.716806'),
('A Coruña', 'Baña (A)', '42.80187', '-8.842805'),
('Ourense', 'Bande', '42.03019', '-7.976335'),
('Ourense', 'Baños de Molgas', '42.24161', '-7.672231'),
('Lugo', 'Baralla', '42.89286', '-7.253127'),
('Ourense', 'Barbadás', '42.29916', '-7.887585'),
('Ourense', 'Barco de Valdeorras (O)', '42.41542', '-6.98196'),
('Lugo', 'Barreiros', '43.53333', '-7.233333'),
('Pontevedra', 'Barro', '42.525', '-8.647223'),
('Ourense', 'Beade', '42.33477', '-8.145673'),
('Ourense', 'Beariz', '42.4678', '-8.273106'),
('Lugo', 'Becerreá', '42.85341', '-7.162147'),
('Lugo', 'Begonte', '43.14534', '-7.680204'),
('A Coruña', 'Bergondo', '43.31667', '-8.233334'),
('A Coruña', 'Betanzos', '43.28106', '-8.211315'),
('Ourense', 'Blancos (Os)', '41.99734', '-7.752397'),
('Ourense', 'Boborás', '42.43336', '-8.142965'),
('A Coruña', 'Boimorto', '43.008', '-8.127'),
('A Coruña', 'Boiro', '42.65', '-8.9'),
('Ourense', 'Bola (A)', '42.152', '-7.915448'),
('Ourense', 'Bolo (O)', '42.4406', '-8.006111'),
('A Coruña', 'Boqueixón', '42.817', '-8.417'),
('Lugo', 'Bóveda', '42.62622', '-7.479327'),
('A Coruña', 'Brión', '42.867', '-8.678'),
('Pontevedra', 'Bueu', '42.31977', '-8.790135'),
('Lugo', 'Burela', '43.65594', '-7.363514'),
('A Coruña', 'Cabana de Bergantiños', '43.21917', '-8.98'),
('A Coruña', 'Cabanas', '43.41724', '-8.16521'),
('Pontevedra', 'Caldas de Reis', '42.6055', '-8.643308'),
('Ourense', 'Calvos de Randín', '41.94423', '-7.897644'),
('A Coruña', 'Camariñas', '43.12862', '-9.184929'),
('Pontevedra', 'Cambados', '42.5138', '-8.812893'),
('A Coruña', 'Cambre', '43.29416', '-8.34498'),
('Pontevedra', 'Campo Lameiro', '42.54222', '-8.542778'),
('Pontevedra', 'Cangas', '42.26471', '-8.782845'),
('Pontevedra', 'Cañiza (A)', '42.21304', '-8.27567'),
('A Coruña', 'Capela (A)', '42.69293', '-8.792709'),
('Ourense', 'Carballeda de Avia', '42.32087', '-8.164418'),
('Ourense', 'Carballeda de Valdeorras', '42.37857', '-6.880474'),
('Lugo', 'Carballedo', '42.51667', '-7.833333'),
('Ourense', 'Carballiño (O)', '42.42981', '-8.077559'),
('A Coruña', 'Carballo', '43.21217', '-8.691041'),
('A Coruña', 'Cariño', '43.73265', '-7.877766'),
('A Coruña', 'Carnota', '42.82107', '-9.0871'),
('A Coruña', 'Carral', '43.2297', '-8.355897'),
('Ourense', 'Cartelle', '42.24883', '-8.070292'),
('Ourense', 'Castrelo de Miño', '42.28333', '-8.116667'),
('Ourense', 'Castrelo do Val', '41.9929', '-7.42577'),
('Ourense', 'Castro Caldelas', '42.37637', '-7.411907'),
('Lugo', 'Castro de Rei', '43.20859', '-7.400369'),
('Lugo', 'Castroverde', '43.03097', '-7.327102'),
('Pontevedra', 'Catoira', '42.66665', '-8.722511'),
('A Coruña', 'Cedeira', '43.66142', '-8.05547'),
('A Coruña', 'Cee', '42.95541', '-9.18975'),
('Ourense', 'Celanova', '42.15223', '-7.958191'),
('Ourense', 'Cenlle', '42.34312', '-8.087995'),
('A Coruña', 'Cerceda', '43.16024', '-8.473271'),
('Pontevedra', 'Cerdedo', '42.53204', '-8.391931'),
('A Coruña', 'Cerdido', '43.62384', '-7.994961'),
('Lugo', 'Cervantes', '42.86984', '-7.060073'),
('Lugo', 'Cervo', '43.68209', '-7.44769'),
('A Coruña', 'Cesuras', '43.17367', '-8.197223'),
('Ourense', 'Chandrexa de Queixa', '42.26029', '-7.379771'),
('Lugo', 'Chantada', '42.60867', '-7.773468'),
('A Coruña', 'Coirós', '43.25033', '-8.164351'),
('Ourense', 'Coles', '42.40143', '-7.836892'),
('A Coruña', 'Corcubión', '42.94464', '-9.19431'),
('Lugo', 'Corgo (O)', '42.93829', '-7.415542'),
('A Coruña', 'Coristanco', '43.19048', '-8.760949'),
('Ourense', 'Cortegada', '42.20771', '-8.169045'),
('A Coruña', 'Coruña (A)', '43.37087', '-8.395835'),
('Lugo', 'Cospeito', '43.23597', '-7.558825'),
('Pontevedra', 'Cotobade', '42.46667', '-8.466667'),
('Pontevedra', 'Covelo', '42.23195', '-8.363334'),
('Pontevedra', 'Crecente', '42.15374', '-8.223059'),
('Ourense', 'Cualedro', '41.99015', '-7.595024'),
('A Coruña', 'Culleredo', '43.31584', '-8.384923'),
('Pontevedra', 'Cuntis', '42.63263', '-8.563463'),
('A Coruña', 'Curtis', '43.12437', '-8.146308'),
('A Coruña', 'Dodro', '42.7175', '-8.714723'),
('Pontevedra', 'Dozón', '42.57058', '-8.04944'),
('A Coruña', 'Dumbría', '43.00933', '-9.11521'),
('Ourense', 'Entrimo', '41.93333', '-8.116667'),
('Ourense', 'Esgos', '42.32457', '-7.695685'),
('Pontevedra', 'Estrada (A)', '42.68958', '-8.491302'),
('A Coruña', 'Fene', '43.47521', '-8.165961'),
('A Coruña', 'Ferrol', '43.48839', '-8.222509'),
('A Coruña', 'Fisterra', '42.90507', '-9.264338'),
('Lugo', 'Folgoso do Courel', '42.58882', '-7.195468'),
('Lugo', 'Fonsagrada (A)', '43.12375', '-7.06791'),
('Pontevedra', 'Forcarei', '42.59233', '-8.350904'),
('Pontevedra', 'Fornelos de Montes', '42.34055', '-8.453166'),
('Lugo', 'Foz', '43.56639', '-7.25667'),
('A Coruña', 'Frades', '43.04', '-8.277223'),
('Lugo', 'Friol', '43.02889', '-7.79354'),
('Ourense', 'Gomesende', '42.16586', '-8.103775'),
('Pontevedra', 'Gondomar', '42.11078', '-8.761466'),
('Pontevedra', 'Grove (O)', '42.49366', '-8.865339'),
('Pontevedra', 'Guarda (A)', '41.90252', '-8.873672'),
('Ourense', 'Gudiña (A)', '42.06117', '-7.138263'),
('Lugo', 'Guitiriz', '43.18174', '-7.900185'),
('Lugo', 'Guntín', '42.88778', '-7.697222'),
('Pontevedra', 'Illa de Arousa (A)', '42.56406', '-8.873684'),
('Lugo', 'Incio (O)', '42.64861', '-7.33'),
('Ourense', 'Irixo (O)', '42.52346', '-8.107206'),
('A Coruña', 'Irixoa', '43.28474', '-8.058925'),
('Pontevedra', 'Lalín', '42.66137', '-8.110957'),
('Pontevedra', 'Lama (A)', '42.11277', '-8.302681'),
('Lugo', 'Láncara', '42.86206', '-7.348236'),
('A Coruña', 'Laracha (A)', '43.25232', '-8.584469'),
('Ourense', 'Larouco', '42.34745', '-7.159348'),
('A Coruña', 'Laxe', '43.21975', '-9.005163'),
('Ourense', 'Laza', '42.06162', '-7.461647'),
('Ourense', 'Leiro', '42.36928', '-8.123707'),
('Ourense', 'Lobeira', '41.99889', '-8.043056'),
('Ourense', 'Lobios', '41.89356', '-8.068343'),
('Lugo', 'Lourenzá', '43.4711', '-7.297891'),
('A Coruña', 'Lousame', '42.75896', '-8.846885'),
('Lugo', 'Lugo', '43.01208', '-7.555851'),
('Ourense', 'Maceda', '42.27217', '-7.650074'),
('A Coruña', 'Malpica de Bergantiños', '43.32416', '-8.809312'),
('A Coruña', 'Mañón', '43.7692', '-7.685581'),
('Ourense', 'Manzaneda', '42.31055', '-7.235425'),
('Pontevedra', 'Marín', '42.39147', '-8.699853'),
('Ourense', 'Maside', '42.41143', '-8.025622'),
('A Coruña', 'Mazaricos', '42.93893', '-8.992199'),
('Pontevedra', 'Meaño', '42.45', '-8.783333'),
('Lugo', 'Meira', '43.2131', '-7.294944'),
('Pontevedra', 'Meis', '42.51667', '-8.7'),
('A Coruña', 'Melide', '42.91393', '-8.014727'),
('Ourense', 'Melón', '42.25759', '-8.217762'),
('Ourense', 'Merca (A)', '42.22276', '-7.904709'),
('A Coruña', 'Mesía', '43.11592', '-8.244491'),
('Ourense', 'Mezquita (A)', '42.00964', '-7.04605'),
('A Coruña', 'Miño', '43.3475', '-8.206388'),
('Pontevedra', 'Moaña', '42.28551', '-8.749413'),
('A Coruña', 'Moeche', '43.55053', '-7.991225'),
('Pontevedra', 'Mondariz', '42.23425', '-8.455334'),
('Pontevedra', 'Mondariz-Balneario', '42.22697', '-8.465821'),
('Lugo', 'Mondoñedo', '43.4281', '-7.362851'),
('A Coruña', 'Monfero', '43.32491', '-8.054685'),
('Lugo', 'Monforte de Lemos', '42.5185', '-7.510688'),
('Ourense', 'Montederramo', '42.27694', '-7.502669'),
('Ourense', 'Monterrei', '41.94715', '-7.449487'),
('Lugo', 'Monterroso', '42.79319', '-7.836526'),
('Pontevedra', 'Moraña', '42.56186', '-8.560328'),
('Pontevedra', 'Mos', '42.19545', '-8.654388'),
('A Coruña', 'Mugardos', '43.46075', '-8.253842'),
('Ourense', 'Muíños', '41.95426', '-7.985605'),
('Lugo', 'Muras', '43.46788', '-7.723003'),
('A Coruña', 'Muros', '42.77432', '-9.057509'),
('A Coruña', 'Muxía', '43.10466', '-9.218463'),
('A Coruña', 'Narón', '43.53705', '-8.180766'),
('Lugo', 'Navia de Suarna', '42.96486', '-7.003865'),
('A Coruña', 'Neda', '43.50128', '-8.156269'),
('A Coruña', 'Negreira', '42.90954', '-8.736245'),
('Lugo', 'Negueira de Muñiz', '43.13335', '-6.893023'),
('Pontevedra', 'Neves (As)', '42.08818', '-8.415079'),
('Pontevedra', 'Nigrán', '42.1452', '-8.807062'),
('Lugo', 'Nogais (As)', '42.80933', '-7.109268'),
('Ourense', 'Nogueira de Ramuín', '42.41308', '-7.726115'),
('A Coruña', 'Noia', '42.78525', '-8.888309'),
('Pontevedra', 'Oia', '42.00307', '-8.875215'),
('Ourense', 'Oímbra', '41.88543', '-7.47204'),
('A Coruña', 'Oleiros', '43.3335', '-8.313619'),
('A Coruña', 'Ordes', '43.07674', '-8.407746'),
('A Coruña', 'Oroso', '42.99442', '-8.434846'),
('A Coruña', 'Ortigueira', '43.68634', '-7.851941'),
('Ourense', 'Ourense', '42.34001', '-7.864641'),
('Lugo', 'Ourol', '43.55678', '-7.636109'),
('Lugo', 'Outeiro de Rei', '43.10213', '-7.615168'),
('A Coruña', 'Outes', '42.85127', '-8.926455'),
('A Coruña', 'Oza dos Ríos', '43.21533', '-8.186943'),
('A Coruña', 'Paderne', '43.28677', '-8.176355'),
('Ourense', 'Paderne de Allariz', '42.2775', '-7.745833'),
('Ourense', 'Padrenda', '42.13334', '-8.15'),
('A Coruña', 'Padrón', '42.73898', '-8.660538'),
('Lugo', 'Palas de Rei', '42.87424', '-7.868907'),
('Lugo', 'Pantón', '42.51667', '-7.6'),
('Ourense', 'Parada de Sil', '42.38281', '-7.568525'),
('Lugo', 'Paradela', '42.76667', '-7.6'),
('Lugo', 'Páramo (O)', '42.8396', '-7.535555'),
('Lugo', 'Pastoriza (A)', '43.30063', '-7.351371'),
('Pontevedra', 'Pazos de Borbén', '42.29383', '-8.531596'),
('Lugo', 'Pedrafita do Cebreiro', '42.72624', '-7.021226'),
('Ourense', 'Pereiro de Aguiar (O)', '42.34643', '-7.801086'),
('Ourense', 'Peroxa (A)', '42.43982', '-7.795459'),
('Ourense', 'Petín', '42.38257', '-7.125877'),
('A Coruña', 'Pino (O)', '42.98462', '-8.313807'),
('Ourense', 'Piñor', '42.49816', '-8.004752'),
('Ourense', 'Pobra de Trives (A)', '42.33931', '-7.2539'),
('Lugo', 'Pobra do Brollón (A)', '42.55704', '-7.392418'),
('A Coruña', 'Pobra do Caramiñal (A)', '42.6033', '-8.938943'),
('Pontevedra', 'Poio', '42.44446', '-8.715083'),
('Lugo', 'Pol', '43.15272', '-7.330053'),
('Pontevedra', 'Ponte Caldelas', '42.38924', '-8.503109'),
('Pontevedra', 'Ponteareas', '42.17637', '-8.502382'),
('A Coruña', 'Ponteceso', '43.24269', '-8.900965'),
('Pontevedra', 'Pontecesures', '42.71667', '-8.65'),
('A Coruña', 'Pontedeume', '43.40258', '-8.152691'),
('Ourense', 'Pontedeva', '42.16861', '-8.139167'),
('Lugo', 'Pontenova (A)', '43.34803', '-7.192536'),
('A Coruña', 'Pontes de García Rodríguez (As)', '43.44582', '-7.849446'),
('Pontevedra', 'Pontevedra', '42.43362', '-8.648053'),
('Ourense', 'Porqueira', '42.01787', '-7.839515'),
('Pontevedra', 'Porriño (O)', '42.16036', '-8.619299'),
('Pontevedra', 'Portas', '42.58333', '-8.666667'),
('A Coruña', 'Porto do Son', '42.72468', '-9.006695'),
('Lugo', 'Portomarín', '42.80775', '-7.615518'),
('Ourense', 'Punxín', '42.37028', '-8.011945'),
('Ourense', 'Quintela de Leirado', '42.13896', '-8.102153'),
('Lugo', 'Quiroga', '42.47597', '-7.271719'),
('Lugo', 'Rábade', '43.12088', '-7.621819'),
('Ourense', 'Rairiz de Veiga', '42.08272', '-7.833268'),
('Ourense', 'Ramirás', '42.18779', '-8.022355'),
('Pontevedra', 'Redondela', '42.28379', '-8.607425'),
('A Coruña', 'Rianxo', '42.65199', '-8.81842'),
('Ourense', 'Ribadavia', '42.28755', '-8.143497'),
('Lugo', 'Ribadeo', '43.53735', '-7.043029'),
('Pontevedra', 'Ribadumia', '42.51466', '-8.757588'),
('Lugo', 'Ribas de Sil', '42.44611', '-7.297662'),
('A Coruña', 'Ribeira', '42.57627', '-9.023945'),
('Lugo', 'Ribeira de Piquín', '43.19055', '-7.189803'),
('Ourense', 'Riós', '41.97426', '-7.282634'),
('Lugo', 'Riotorto', '43.35972', '-7.254445'),
('Pontevedra', 'Rodeiro', '42.64951', '-7.949817'),
('A Coruña', 'Rois', '42.76181', '-8.706309'),
('Pontevedra', 'Rosal (O)', '41.93539', '-8.83549'),
('Ourense', 'Rúa (A)', '42.39249', '-7.120533'),
('Ourense', 'Rubiá', '42.44963', '-6.948192'),
('A Coruña', 'Sada', '43.35093', '-8.254611'),
('Pontevedra', 'Salceda de Caselas', '42.10196', '-8.558377'),
('Pontevedra', 'Salvaterra de Miño', '42.08197', '-8.499002'),
('Lugo', 'Samos', '42.73054', '-7.325293'),
('Ourense', 'San Amaro', '42.37314', '-8.071692'),
('Ourense', 'San Cibrao das Viñas', '42.29727', '-7.873343'),
('Ourense', 'San Cristovo de Cea', '42.4728', '-7.985322'),
('A Coruña', 'San Sadurniño', '43.56245', '-8.054992'),
('Ourense', 'San Xoán de Río', '42.3706', '-7.29888'),
('Ourense', 'Sandiás', '42.11305', '-7.756991'),
('A Coruña', 'Santa Comba', '43.0477', '-8.814226'),
('A Coruña', 'Santiago de Compostela', '42.88045', '-8.546304'),
('A Coruña', 'Santiso', '42.85', '-8.05'),
('Pontevedra', 'Sanxenxo', '42.39948', '-8.806928'),
('Ourense', 'Sarreaus', '42.08629', '-7.603325'),
('Lugo', 'Sarria', '42.77766', '-7.414474'),
('Lugo', 'Saviñao (O)', '42.64709', '-7.654811'),
('Pontevedra', 'Silleda', '42.69791', '-8.248382'),
('Lugo', 'Sober', '42.46107', '-7.586344'),
('A Coruña', 'Sobrado', '43.042', '-8.027381'),
('A Coruña', 'Somozas (As)', '43.53605', '-7.924339'),
('Pontevedra', 'Soutomaior', '42.333', '-8.567'),
('Lugo', 'Taboada', '42.71615', '-7.762904'),
('Ourense', 'Taboadela', '42.2409', '-7.825325'),
('Ourense', 'Teixeira (A)', '42.38874', '-7.266197'),
('A Coruña', 'Teo', '42.80227', '-8.586169'),
('Ourense', 'Toén', '42.31652', '-7.954854'),
('Pontevedra', 'Tomiño', '41.98744', '-8.745583'),
('A Coruña', 'Toques', '42.96787', '-7.988449'),
('A Coruña', 'Tordoia', '43.088', '-8.56'),
('A Coruña', 'Touro', '42.86709', '-8.306829'),
('Lugo', 'Trabada', '43.44833', '-7.194592'),
('Ourense', 'Trasmiras', '42.02463', '-7.616568'),
('A Coruña', 'Trazo', '43.01667', '-8.533333'),
('Lugo', 'Triacastela', '42.75665', '-7.240443'),
('Pontevedra', 'Tui', '42.04621', '-8.643768'),
('A Coruña', 'Val do Dubra', '43.0225', '-8.638333'),
('Lugo', 'Valadouro (O)', '43.56673', '-7.459773'),
('A Coruña', 'Valdoviño', '43.6', '-8.133056'),
('Pontevedra', 'Valga', '42.69431', '-8.639425'),
('A Coruña', 'Vedra', '42.78234', '-8.467377'),
('Ourense', 'Veiga (A)', '42.2506', '-7.02599'),
('Ourense', 'Verea', '42.1', '-7.95'),
('Ourense', 'Verín', '41.94045', '-7.439122'),
('Ourense', 'Viana do Bolo', '42.17919', '-7.112754'),
('Lugo', 'Vicedo (O)', '43.73336', '-7.672058'),
('Pontevedra', 'Vigo', '42.23136', '-8.712447'),
('Pontevedra', 'Vila de Cruces', '42.79403', '-8.170012'),
('Pontevedra', 'Vilaboa', '42.34724', '-8.646326'),
('Pontevedra', 'Vilagarcía de Arousa', '42.59387', '-8.765963'),
('Lugo', 'Vilalba', '43.29541', '-7.684412'),
('Ourense', 'Vilamarín', '42.46451', '-7.892807'),
('Ourense', 'Vilamartín de Valdeorras', '42.41521', '-7.059831'),
('Pontevedra', 'Vilanova de Arousa', '42.56221', '-8.82772'),
('Ourense', 'Vilar de Barrio', '42.16056', '-7.612335'),
('Ourense', 'Vilar de Santos', '42.0871', '-7.794695'),
('Ourense', 'Vilardevós', '41.90748', '-7.314034'),
('Ourense', 'Vilariño de Conso', '42.17825', '-7.171638'),
('A Coruña', 'Vilarmaior', '43.34461', '-8.15395'),
('A Coruña', 'Vilasantar', '43.06667', '-8.1'),
('A Coruña', 'Vimianzo', '43.1103', '-9.033895'),
('Lugo', 'Viveiro', '43.66143', '-7.594532'),
('Lugo', 'Xermade', '43.35552', '-7.813554'),
('Ourense', 'Xinzo de Limia', '42.06366', '-7.724412'),
('Lugo', 'Xove', '43.68557', '-7.512421'),
('Ourense', 'Xunqueira de Ambía', '42.20422', '-7.734962'),
('Ourense', 'Xunqueira de Espadanedo', '42.31957', '-7.629323'),
('A Coruña', 'Zas', '43.09975', '-8.916149');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familias`
--

CREATE TABLE `familias` (
  `id_familia` int(11) NOT NULL,
  `nombre_familia` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `familias`
--

INSERT INTO `familias` (`id_familia`, `nombre_familia`) VALUES
(1, 'Informática e comunicacións');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id_grupo` int(11) NOT NULL,
  `grupo` varchar(255) DEFAULT NULL,
  `descripcion_en` text DEFAULT NULL,
  `descripcion_gl` text DEFAULT NULL,
  `orden` int(255) DEFAULT NULL,
  `seccion_ini` varchar(255) DEFAULT NULL,
  `has_role` int(11) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id_grupo`, `grupo`, `descripcion_en`, `descripcion_gl`, `orden`, `seccion_ini`, `has_role`) VALUES
(1, 'Administrador', 'Can access without restrictions. Can manage all the data of the application including master data tables.', 'Acceso a toda a aplicación.\nA única restricción é que non poden modificar o usuario superadmin.', 3, 'distancias', 0),
(2, 'Usuario distancias', 'Puede visionar el listado y la información de los institutos', 'Revisión de la parte de distancias', 1, '/', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `options`
--

CREATE TABLE `options` (
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `help` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `options`
--

INSERT INTO `options` (`key`, `value`, `help`) VALUES
('export_timetable_pdf', '0', 'Should we export timetable in pdf format? 1 = Yes, 0 = no'),
('mail_recover_password', '<h3>{PROJECT}</h3>Please, click on the following link to recover your password <br/><br/>{LINK}', 'Text that will be sent when a user requests a password reset. Use the {LINK} tag to markup link position.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_centro_ciclo_formativo`
--

CREATE TABLE `rel_centro_ciclo_formativo` (
  `codigo_centro` int(8) NOT NULL,
  `codigo_ciclo` varchar(10) NOT NULL,
  `provisional` tinyint(1) DEFAULT 0,
  `modular` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rel_centro_ciclo_formativo`
--

INSERT INTO `rel_centro_ciclo_formativo` (`codigo_centro`, `codigo_ciclo`, `provisional`, `modular`) VALUES
(15004356, 'CBIFC01', 0, 0),
(15005269, 'CBIFC02', 0, 0),
(15005270, 'CSIFC02', 0, 0),
(15005397, 'CBIFC01', 0, 0),
(15005397, 'CSIFC01', 0, 0),
(15005397, 'CSIFC02', 0, 0),
(15006778, 'CBIFC02', 0, 0),
(15006778, 'CSIFC01', 0, 0),
(15006778, 'CSIFC02', 0, 0),
(15006778, 'CSIFC03', 0, 0),
(15015743, 'CBIFC02', 0, 0),
(15015743, 'CSIFC01', 0, 0),
(15021482, 'CMIFC01', 0, 0),
(15021482, 'CSIFC01', 0, 0),
(15021482, 'CSIFC02', 0, 0),
(15021482, 'CSIFC03', 0, 0),
(15021767, 'CBIFC02', 0, 0),
(15026388, 'CBIFC02', 0, 0),
(15026391, 'CSIFC01', 0, 0),
(15026391, 'CSIFC02', 0, 0),
(15026698, 'CBIFC01', 0, 0),
(15027307, 'CSIFC01', 0, 0),
(15027368, 'CBIFC02', 0, 0),
(15027711, 'CBIFC01', 0, 0),
(15027711, 'CSIFC01', 0, 0),
(15027711, 'CSIFC02', 0, 0),
(15027721, 'CBIFC02', 0, 0),
(15027873, 'CBIFC02', 0, 0),
(15032431, 'CBIFC02', 0, 0),
(27013326, 'CBIFC02', 0, 0),
(27013326, 'CSIFC01', 0, 0),
(27014811, 'CBIFC02', 0, 0),
(27015311, 'CMIFC01', 0, 0),
(27015311, 'CSIFC03', 0, 0),
(27015773, 'CBIFC02', 0, 0),
(27015773, 'CSIFC01', 0, 0),
(27015773, 'CSIFC02', 0, 0),
(27015773, 'CSIFC03', 0, 0),
(27016248, 'CBIFC02', 0, 0),
(27016509, 'CBIFC02', 0, 0),
(32008665, 'CBIFC02', 0, 0),
(32008902, 'CBIFC02', 0, 0),
(32008902, 'CMIFC01', 0, 0),
(32008902, 'CSIFC01', 0, 0),
(32008902, 'CSIFC02', 0, 0),
(32008902, 'CSIFC03', 0, 0),
(32015530, 'CBIFC01', 0, 0),
(32016340, 'CBIFC02', 0, 0),
(32016431, 'CBIFC02', 0, 0),
(32016431, 'CMIFC01', 0, 0),
(32016637, 'CBIFC02', 0, 0),
(32016777, 'CBIFC02', 0, 0),
(36002359, 'CBIFC02', 0, 0),
(36002359, 'CMIFC01', 0, 0),
(36004137, 'CBIFC02', 0, 0),
(36004137, 'CMIFC01', 0, 0),
(36004137, 'CSIFC03', 0, 0),
(36007011, 'CBIFC02', 0, 0),
(36011211, 'CBIFC01', 0, 0),
(36011361, 'CBIFC01', 0, 0),
(36011521, 'CSIFC02', 0, 0),
(36011853, 'CSIFC01', 0, 0),
(36011853, 'CSIFC02', 0, 0),
(36013795, 'CSIFC02', 0, 0),
(36015101, 'CBIFC02', 0, 0),
(36015159, 'CBIFC02', 0, 0),
(36015159, 'CMIFC01', 0, 0),
(36015159, 'CSIFC01', 0, 0),
(36015159, 'CSIFC02', 0, 0),
(36015184, 'CBIFC01', 0, 0),
(36018173, 'CBIFC02', 0, 0),
(36018173, 'CMIFC01', 0, 0),
(36018173, 'CSIFC01', 0, 0),
(36018173, 'CSIFC02', 0, 0),
(36018173, 'CSIFC03', 0, 0),
(36019232, 'CMIFC01', 0, 0),
(36019244, 'CMIFC01', 0, 0),
(36019396, 'CBIFC02', 0, 0),
(36019402, 'CBIFC02', 0, 0),
(36019402, 'CMIFC01', 0, 0),
(36019475, 'CSIFC01', 0, 0),
(36019669, 'CBIFC01', 0, 0),
(36019669, 'CMIFC01', 0, 0),
(36019669, 'CSIFC01', 0, 0),
(36024781, 'CBIFC02', 0, 0),
(36025037, 'CMIFC01', 0, 0),
(27003175, 'ZSIFC03', 0, 0),
(32008902, 'ZSIFC03', 0, 0),
(15021482, 'ZSIFC03', 0, 0),
(32016637, 'CMIFC01', 0, 0),
(36004137, 'CSIFC01', 0, 0),
(36002359, 'CSIFC02', 0, 0),
(36019402, 'CSIFC03', 0, 0),
(15027307, 'CBIFC02', 1, 0),
(27003175, 'CBIFC02', 1, 0),
(36019232, 'CBIFC02', 1, 0),
(36016656, 'CBIFC02', 1, 0),
(36004745, 'CBIFC02', 1, 0),
(36004745, 'CBIFC02', 1, 0),
(36014544, 'CBIFC02', 1, 0),
(15021755, 'CMIFC01', 0, 0),
(15022620, 'CMIFC01', 0, 0),
(27016625, 'CMIFC01', 0, 0),
(15027368, 'ZSIFC03', 0, 0),
(36019475, 'CSIFC03', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `system_logs`
--

CREATE TABLE `system_logs` (
  `idlog` int(10) UNSIGNED NOT NULL,
  `seccion` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `full_url` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `variables` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `ip` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `ip_forwarded` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `system_logs`
--

INSERT INTO `system_logs` (`idlog`, `seccion`, `full_url`, `variables`, `id_usuario`, `ip`, `ip_forwarded`, `fecha`) VALUES
(1, 'login.ok', 'http://php74.localhost/IES-distancia/_load_ajax.php?file=controllers/login.validate', '{\"get\":{\"file\":\"controllers\\/login.validate\"},\"post\":{\"email\":\"mikote2000@gmail.com\",\"pass\":\"alen\",\"checkbox-fill-1\":\"on\"}}', 1, '127.0.0.1', NULL, '2020-06-09 11:09:20'),
(2, 'user.controller', 'http://php74.localhost/IES-distancia/_load_ajax.php?file=controllers/user.controller', '{\"get\":{\"file\":\"controllers\\/user.controller\"},\"post\":{\"id_usuario\":\"1\",\"userSubmit\":\"1\",\"name\":\"Administrador\",\"pass\":\"alonso2000\",\"pass2\":\"alonso2000\",\"id_grupo\":1}}', 1, '127.0.0.1', NULL, '2020-06-09 11:21:58'),
(3, 'login.ok', 'http://php74.localhost/IES-distancia/_load_ajax.php?file=controllers/login.validate', '{\"get\":{\"file\":\"controllers\\/login.validate\"},\"post\":{\"email\":\"mikote2000@gmail.com\",\"pass\":\"alonso2000\",\"checkbox-fill-1\":\"on\"}}', 1, '127.0.0.1', NULL, '2020-06-09 11:31:20'),
(4, 'login.ok', 'http://php56.localhost/IES-distancia/_load_ajax.php?file=controllers/login.validate', '{\"get\":{\"file\":\"controllers\\/login.validate\"},\"post\":{\"email\":\"mikote2000@gmail.com\",\"pass\":\"alonso2000\",\"checkbox-fill-1\":\"on\"}}', 1, '127.0.0.1', NULL, '2020-06-09 13:30:18'),
(5, 'login.fail', 'http://localhost/IES-distancia/_load_ajax.php?file=controllers/login.validate', '{\"get\":{\"file\":\"controllers\\/login.validate\"},\"post\":{\"email\":\"mikote2000@gmail.com\",\"pass\":\"alonso\",\"checkbox-fill-1\":\"on\"}}', NULL, '127.0.0.1', NULL, '2020-06-18 11:14:08'),
(6, 'login.fail', 'http://localhost/IES-distancia/_load_ajax.php?file=controllers/login.validate', '{\"get\":{\"file\":\"controllers\\/login.validate\"},\"post\":{\"email\":\"mikote2000@gmail.com\",\"pass\":\"alen\",\"checkbox-fill-1\":\"on\"}}', NULL, '127.0.0.1', NULL, '2020-06-18 11:14:16'),
(7, 'login.ok', 'http://localhost/IES-distancia/_load_ajax.php?file=controllers/login.validate', '{\"get\":{\"file\":\"controllers\\/login.validate\"},\"post\":{\"email\":\"mikote2000@gmail.com\",\"pass\":\"alonso2000\",\"checkbox-fill-1\":\"on\"}}', 1, '127.0.0.1', NULL, '2020-06-18 11:14:22'),
(8, 'login.ok', 'http://php74.localhost/IES-distancia/_load_ajax.php?file=controllers/login.validate', '{\"get\":{\"file\":\"controllers\\/login.validate\"},\"post\":{\"email\":\"mikote2000@gmail.com\",\"pass\":\"alonso2000\",\"checkbox-fill-1\":\"on\"}}', 1, '127.0.0.1', NULL, '2020-06-19 11:18:57'),
(9, 'cirurxian.controller', 'http://php74.localhost/IES-distancia/_load_ajax.php?file=controllers/cirurxian.controller', '{\"get\":{\"file\":\"controllers\\/cirurxian.controller\"},\"post\":{\"id_cirurxian\":\"1\",\"userSubmit\":\"1\",\"nome\":\"Mar\\u00eda Darriba\",\"zonas\":[\"1\",\"2\",\"3\"]}}', 1, '127.0.0.1', NULL, '2020-06-19 12:41:37'),
(10, 'cirurxian.controller', 'http://php74.localhost/IES-distancia/_load_ajax.php?file=controllers/cirurxian.controller', '{\"get\":{\"file\":\"controllers\\/cirurxian.controller\"},\"post\":{\"id_cirurxian\":\"1\",\"userSubmit\":\"1\",\"nome\":\"Mar\\u00eda Darriba\",\"zonas\":[\"1\",\"3\"]}}', 1, '127.0.0.1', NULL, '2020-06-19 12:41:55'),
(11, 'cirurxian.controller', 'http://php74.localhost/IES-distancia/_load_ajax.php?file=controllers/cirurxian.controller', '{\"get\":{\"file\":\"controllers\\/cirurxian.controller\"},\"post\":{\"id_cirurxian\":\"1\",\"userSubmit\":\"1\",\"nome\":\"M. Darriba\",\"zonas\":[\"1\",\"3\"]}}', 1, '127.0.0.1', NULL, '2020-06-19 12:42:07'),
(12, 'cirurxian.controller', 'http://php74.localhost/IES-distancia/_load_ajax.php?file=controllers/cirurxian.controller', '{\"get\":{\"file\":\"controllers\\/cirurxian.controller\"},\"post\":{\"id_cirurxian\":\"\",\"userSubmit\":\"1\",\"nome\":\"C. Enr\\u00edquez\",\"zonas\":[\"1\"]}}', 1, '127.0.0.1', NULL, '2020-06-19 12:44:00'),
(13, 'cirurxian.controller', 'http://php74.localhost/IES-distancia/_load_ajax.php?file=controllers/cirurxian.controller', '{\"get\":{\"file\":\"controllers\\/cirurxian.controller\"},\"post\":{\"id_cirurxian\":\"\",\"userSubmit\":\"1\",\"nome\":\"T. Baleiras\",\"zonas\":[\"1\"]}}', 1, '127.0.0.1', NULL, '2020-06-19 12:45:35'),
(14, 'cirurxian.controller', 'http://php74.localhost/IES-distancia/_load_ajax.php?file=controllers/cirurxian.controller', '{\"get\":{\"file\":\"controllers\\/cirurxian.controller\"},\"post\":{\"id_cirurxian\":\"1\",\"userSubmit\":\"1\",\"nome\":\"M. Darriba\",\"zonas\":[\"1\",\"2\",\"3\"]}}', 1, '127.0.0.1', NULL, '2020-06-19 12:45:48'),
(15, 'cirurxian.controller', 'http://php74.localhost/IES-distancia/_load_ajax.php?file=controllers/cirurxian.controller', '{\"get\":{\"file\":\"controllers\\/cirurxian.controller\"},\"post\":{\"id_cirurxian\":\"1\",\"userSubmit\":\"1\",\"nome\":\"M. Darriba\",\"zonas\":[\"1\",\"3\"]}}', 1, '127.0.0.1', NULL, '2020-06-19 12:46:12'),
(16, 'cirurxian.controller', 'http://php74.localhost/IES-distancia/_load_ajax.php?file=controllers/cirurxian.controller', '{\"get\":{\"file\":\"controllers\\/cirurxian.controller\"},\"post\":{\"id_cirurxian\":\"1\",\"userSubmit\":\"1\",\"nome\":\"M. Darriba\",\"zonas\":[\"1\",\"2\",\"3\"]}}', 1, '127.0.0.1', NULL, '2020-06-19 12:46:39'),
(17, 'cirurxian.controller', 'http://php74.localhost/IES-distancia/_load_ajax.php?file=controllers/cirurxian.controller', '{\"get\":{\"file\":\"controllers\\/cirurxian.controller\"},\"post\":{\"id_cirurxian\":\"1\",\"userSubmit\":\"1\",\"nome\":\"M. Darriba\",\"zonas\":[\"1\",\"3\"]}}', 1, '127.0.0.1', NULL, '2020-06-19 12:48:38'),
(18, 'cirurxian.controller', 'http://php74.localhost/IES-distancia/_load_ajax.php?file=controllers/cirurxian.controller', '{\"get\":{\"file\":\"controllers\\/cirurxian.controller\"},\"post\":{\"id_cirurxian\":\"1\",\"userSubmit\":\"1\",\"nome\":\"M. Darriba\",\"zonas\":[\"1\",\"2\",\"3\"]}}', 1, '127.0.0.1', NULL, '2020-06-19 12:48:52'),
(19, 'cirurxian.controller', 'http://php74.localhost/IES-distancia/_load_ajax.php?file=controllers/cirurxian.controller', '{\"get\":{\"file\":\"controllers\\/cirurxian.controller\"},\"post\":{\"id_cirurxian\":\"4\",\"userSubmit\":\"1\",\"nome\":\"T. Baleiras\",\"zonas\":[\"1\",\"2\"]}}', 1, '127.0.0.1', NULL, '2020-06-19 12:49:11'),
(20, 'cirurxian.controller', 'http://php74.localhost/IES-distancia/_load_ajax.php?file=controllers/cirurxian.controller', '{\"get\":{\"file\":\"controllers\\/cirurxian.controller\"},\"post\":{\"id_cirurxian\":\"4\",\"userSubmit\":\"1\",\"nome\":\"T. Baleiras\",\"zonas\":[\"1\"]}}', 1, '127.0.0.1', NULL, '2020-06-19 12:49:17'),
(21, 'login.ok', 'http://php56.localhost/IES-distancia/_load_ajax.php?file=controllers/login.validate', '{\"get\":{\"file\":\"controllers\\/login.validate\"},\"post\":{\"email\":\"mikote2000@gmail.com\",\"pass\":\"alonso2000\",\"checkbox-fill-1\":\"on\"}}', 1, '127.0.0.1', NULL, '2020-06-19 12:50:52'),
(22, 'cirurxian.controller', 'http://php56.localhost/IES-distancia/_load_ajax.php?file=controllers/cirurxian.controller', '{\"get\":{\"file\":\"controllers\\/cirurxian.controller\"},\"post\":{\"id_cirurxian\":\"1\",\"userSubmit\":\"1\",\"nome\":\"M. Darriba\",\"zonas\":[\"1\",\"3\"]}}', 1, '127.0.0.1', NULL, '2020-06-19 12:54:11'),
(23, 'cirurxian.controller', 'http://php56.localhost/IES-distancia/_load_ajax.php?file=controllers/cirurxian.controller', '{\"get\":{\"file\":\"controllers\\/cirurxian.controller\"},\"post\":{\"id_cirurxian\":\"1\",\"userSubmit\":\"1\",\"nome\":\"M. Darriba\",\"zonas\":[\"1\",\"2\",\"3\"]}}', 1, '127.0.0.1', NULL, '2020-06-19 13:04:59'),
(24, 'cirurxian.controller', 'http://php56.localhost/IES-distancia/_load_ajax.php?file=controllers/cirurxian.controller', '{\"get\":{\"file\":\"controllers\\/cirurxian.controller\"},\"post\":{\"id_cirurxian\":\"4\",\"userSubmit\":\"1\",\"nome\":\"E. Valeiras\",\"zonas\":[\"1\"]}}', 1, '127.0.0.1', NULL, '2020-06-19 13:05:12'),
(25, 'cirurxian.controller', 'http://php56.localhost/IES-distancia/_load_ajax.php?file=controllers/cirurxian.controller', '{\"get\":{\"file\":\"controllers\\/cirurxian.controller\"},\"post\":{\"id_cirurxian\":\"1\",\"userSubmit\":\"1\",\"nome\":\"M. Darriba\",\"zonas\":[\"1\",\"3\"]}}', 1, '127.0.0.1', NULL, '2020-06-19 13:06:43'),
(26, 'cirurxian.delete O cirurxián foi eliminado!', 'http://php56.localhost/IES-distancia/_load_ajax.php?file=controllers/cirurxian.delete', '{\"get\":{\"file\":\"controllers\\/cirurxian.delete\"},\"post\":{\"del\":\"2\"}}', 1, '127.0.0.1', NULL, '2020-06-19 13:29:46'),
(27, 'login.ok', 'http://php56.localhost/IES-distancia/_load_ajax.php?file=controllers/login.validate', '{\"get\":{\"file\":\"controllers\\/login.validate\"},\"post\":{\"email\":\"mikote2000@gmail.com\",\"pass\":\"alonso2000\",\"checkbox-fill-1\":\"on\"}}', 1, '127.0.0.1', NULL, '2020-06-22 10:24:40'),
(28, 'login.ok', 'http://localhost/IES-distancia/_load_ajax.php?file=controllers/login.validate', '{\"get\":{\"file\":\"controllers\\/login.validate\"},\"post\":{\"email\":\"mikote2000@gmail.com\",\"pass\":\"alonso2000\",\"checkbox-fill-1\":\"on\"}}', 1, '127.0.0.1', NULL, '2020-06-22 10:25:31'),
(29, 'login.ok', 'http://localhost/IES-distancia/_load_ajax.php?file=controllers/login.validate', '{\"get\":{\"file\":\"controllers\\/login.validate\"},\"post\":{\"email\":\"mikote2000@gmail.com\",\"pass\":\"alonso2000\",\"checkbox-fill-1\":\"on\"}}', 1, '127.0.0.1', NULL, '2020-06-26 12:42:21'),
(30, 'login.ok', 'http://localhost/IES-distancia/_load_ajax.php?file=controllers/login.validate', '{\"get\":{\"file\":\"controllers\\/login.validate\"},\"post\":{\"email\":\"mikote2000@gmail.com\",\"pass\":\"alonso2000\",\"checkbox-fill-1\":\"on\"}}', 1, '127.0.0.1', NULL, '2020-06-30 12:45:39'),
(31, 'login.ok', 'http://localhost/IES-distancia/_load_ajax.php?file=controllers/login.validate', '{\"get\":{\"file\":\"controllers\\/login.validate\"},\"post\":{\"email\":\"mikote2000@gmail.com\",\"pass\":\"alonso2000\",\"checkbox-fill-1\":\"on\"}}', 1, '127.0.0.1', NULL, '2020-07-01 18:43:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `id_grupo` int(11) DEFAULT 1,
  `id_center` int(11) DEFAULT NULL,
  `id_role` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `superadmin` tinyint(1) DEFAULT 0,
  `bloqueado` tinyint(1) DEFAULT 0,
  `last_date` datetime DEFAULT NULL,
  `idioma` char(2) DEFAULT 'en',
  `recover_token` varchar(255) DEFAULT NULL,
  `recover_time` int(11) DEFAULT NULL,
  `debug` int(11) NOT NULL DEFAULT 0,
  `baja` int(11) DEFAULT 0,
  `theme` varchar(50) DEFAULT 'light'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `id_grupo`, `id_center`, `id_role`, `email`, `pass`, `nombre`, `superadmin`, `bloqueado`, `last_date`, `idioma`, `recover_token`, `recover_time`, `debug`, `baja`, `theme`) VALUES
(1, 1, NULL, NULL, 'mikote2000@gmail.com', 'YWxvbnNvMjAwMA==', 'Administrador', 1, 0, '2020-07-01 18:43:44', 'en', NULL, NULL, 1, 0, 'light_colored');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aux_tipo_ciclo`
--
ALTER TABLE `aux_tipo_ciclo`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `centros`
--
ALTER TABLE `centros`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `ciclos_formativos`
--
ALTER TABLE `ciclos_formativos`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `familia_ciclo_FK` (`familia_profesional`),
  ADD KEY `ciclos_formativos_tipo_FK` (`tipo`);

--
-- Indices de la tabla `concellos_galicia`
--
ALTER TABLE `concellos_galicia`
  ADD PRIMARY KEY (`Concello`);

--
-- Indices de la tabla `familias`
--
ALTER TABLE `familias`
  ADD PRIMARY KEY (`id_familia`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id_grupo`);

--
-- Indices de la tabla `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `rel_centro_ciclo_formativo`
--
ALTER TABLE `rel_centro_ciclo_formativo`
  ADD KEY `codigo_centro` (`codigo_centro`),
  ADD KEY `codigo_ciclo` (`codigo_ciclo`);

--
-- Indices de la tabla `system_logs`
--
ALTER TABLE `system_logs`
  ADD PRIMARY KEY (`idlog`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `familias`
--
ALTER TABLE `familias`
  MODIFY `id_familia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `system_logs`
--
ALTER TABLE `system_logs`
  MODIFY `idlog` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ciclos_formativos`
--
ALTER TABLE `ciclos_formativos`
  ADD CONSTRAINT `ciclos_formativos_tipo_FK` FOREIGN KEY (`tipo`) REFERENCES `aux_tipo_ciclo` (`id_tipo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `familia_ciclo_FK` FOREIGN KEY (`familia_profesional`) REFERENCES `familias` (`id_familia`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `rel_centro_ciclo_formativo`
--
ALTER TABLE `rel_centro_ciclo_formativo`
  ADD CONSTRAINT `rel_centro_ciclo_formativo_ibfk_1` FOREIGN KEY (`codigo_centro`) REFERENCES `centros` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rel_centro_ciclo_formativo_ibfk_2` FOREIGN KEY (`codigo_ciclo`) REFERENCES `ciclos_formativos` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

