-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 13-11-2025 a las 22:20:04
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
-- Base de datos: `fogones`
--
CREATE DATABASE IF NOT EXISTS `fogones` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `fogones`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

DROP TABLE IF EXISTS `administradores`;
CREATE TABLE `administradores` (
  `id_administrador` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `administradores`
--

TRUNCATE TABLE `administradores`;
--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id_administrador`, `id_usuario`) VALUES
(1, 1),
(13, 8),
(14, 13),
(15, 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alergenos`
--

DROP TABLE IF EXISTS `alergenos`;
CREATE TABLE `alergenos` (
  `id_alergeno` int(11) NOT NULL,
  `nombre_alergeno` varchar(200) NOT NULL,
  `foto_alergeno` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `alergenos`
--

TRUNCATE TABLE `alergenos`;
--
-- Volcado de datos para la tabla `alergenos`
--

INSERT INTO `alergenos` (`id_alergeno`, `nombre_alergeno`, `foto_alergeno`) VALUES
(1, 'Crustáceos y productos derivados de crustáceos', 'Crustceos_y_productos_derivados_de_crustceos.png'),
(2, 'Leche y sus derivados (incluida la lactosa)', 'Leche_y_sus_derivados_(incluida_la_lactosa).png'),
(3, 'Cereales con gluten', 'Cereales_con_gluten.png'),
(4, 'Huevos y productos derivados', 'Huevos_y_productos_derivados.png'),
(5, 'Pescado y productos a base de pescados', 'Pescado_y_productos_a_base_de_pescados.png'),
(6, 'Cacahuetes, productos a base de cacahuetes y frutos secos', 'Cacahuetes,_productos_a_base_de_cacahuetes_y_frutos_secos.png'),
(7, 'Soja y productos a base de soja', 'Soja_y_productos_a_base_de_soja.png'),
(8, 'Frutos de cáscara y productos derivados', 'Frutos_de_cscara_y_productos_derivados.png'),
(9, 'Apio y productos derivados', 'Apio_y_productos_derivados.png'),
(10, 'Mostaza y productos a base de mostaza', 'Mostaza_y_productos_a_base_de_mostaza.png'),
(11, 'Granos o semillas de sésamo y productos a base de sésamo', 'Granos_o_semillas_de_ssamo_y_productos_a_base_de_ssamo.png'),
(12, 'Sulfitos y Dióxido de azufre', 'Dixido_de_azufre_y_sulfitos.png'),
(13, 'Altramuces y productos a base de altramuces', 'Altramuces_y_productos_a_base_de_altramuces.png'),
(14, 'Moluscos y productos a base de estos', 'Moluscos_y_crustceos_y_productos_a_base_de_estos.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autores`
--

DROP TABLE IF EXISTS `autores`;
CREATE TABLE `autores` (
  `id_autor` int(11) NOT NULL,
  `nombre_autor` varchar(80) NOT NULL,
  `foto_autor` varchar(100) DEFAULT NULL,
  `id_pais` int(11) DEFAULT NULL,
  `descripcion_autor` varchar(180) DEFAULT NULL,
  `activo_autor` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `autores`
--

TRUNCATE TABLE `autores`;
--
-- Volcado de datos para la tabla `autores`
--

INSERT INTO `autores` (`id_autor`, `nombre_autor`, `foto_autor`, `id_pais`, `descripcion_autor`, `activo_autor`) VALUES
(5, 'David Muñoz', 'David_Muoz_1497.jpg', 64, 'David Muñoz Rosillo, también conocido como Dabiz Muñoz, es un cocinero español especializado en cocina de vanguardia. Su restaurante DiverXo ha recibido tres estrellas Michelin.​', 0),
(17, 'Ferrán Adriá', 'Ferrn_Adri_6594.jpg', 64, 'Cocinero español promotor de la cocina molecular. Copropietario del prestigioso restaurante \"El Bulli\" hasta su desaparición en 2011.', 0),
(18, 'Yoshimiro Murata', 'Yoshimiro_Murata_2358.jpg', 124, NULL, 0),
(19, 'Sergi Roca', 'Sergi_Roca_6830.jpg', NULL, 'Chef del prestigioso restaurante \"El Chiringuito de Pepe\" de Peñíscola, famoso por su preciado croquetón.', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `editores`
--

DROP TABLE IF EXISTS `editores`;
CREATE TABLE `editores` (
  `id_editor` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `editores`
--

TRUNCATE TABLE `editores`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estilos_cocina`
--

DROP TABLE IF EXISTS `estilos_cocina`;
CREATE TABLE `estilos_cocina` (
  `id_estilo` int(11) NOT NULL,
  `nombre_estilo` varchar(50) NOT NULL,
  `foto_estilo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `estilos_cocina`
--

TRUNCATE TABLE `estilos_cocina`;
--
-- Volcado de datos para la tabla `estilos_cocina`
--

INSERT INTO `estilos_cocina` (`id_estilo`, `nombre_estilo`, `foto_estilo`) VALUES
(1, 'Mediterránea', NULL),
(3, 'Internacional', NULL),
(4, 'Molecular', NULL),
(8, 'De Autor', NULL),
(9, 'Vegana', NULL),
(10, 'Bio', NULL),
(11, 'Sin Gluten', NULL),
(12, 'Sin Lactosa', NULL),
(13, 'Vegetariana', NULL),
(14, 'Tradicional', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritas`
--

DROP TABLE IF EXISTS `favoritas`;
CREATE TABLE `favoritas` (
  `id_favoritas` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `favoritas`
--

TRUNCATE TABLE `favoritas`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos_plato`
--

DROP TABLE IF EXISTS `grupos_plato`;
CREATE TABLE `grupos_plato` (
  `id_grupo` int(11) NOT NULL,
  `nombre_grupo` varchar(50) NOT NULL,
  `foto_grupo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `grupos_plato`
--

TRUNCATE TABLE `grupos_plato`;
--
-- Volcado de datos para la tabla `grupos_plato`
--

INSERT INTO `grupos_plato` (`id_grupo`, `nombre_grupo`, `foto_grupo`) VALUES
(1, 'Carnes y Aves', 'Carnes_8964.jpg'),
(2, 'Pescados y mariscos', 'Pescados_1447.jpg'),
(3, 'Salsas', 'Salsas_7554.jpg'),
(5, 'Frutas y verduras', 'Frutas_622.jpg'),
(6, 'Postres y Dulces', 'Bollera_y_pastelera_1687.jpg'),
(13, 'Pan y masas', 'Masas_2454.jpg'),
(15, 'Arroz legumbres y cereales', NULL),
(16, 'Bebidas', NULL),
(17, 'Lácteos y huevos', NULL),
(18, 'Pasta y pizza', NULL),
(19, 'Sopas y cremas', NULL),
(25, 'Ensaladas', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredientes`
--

DROP TABLE IF EXISTS `ingredientes`;
CREATE TABLE `ingredientes` (
  `id_ingrediente` int(11) NOT NULL,
  `nombre_ingrediente` varchar(80) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `ingredientes`
--

TRUNCATE TABLE `ingredientes`;
--
-- Volcado de datos para la tabla `ingredientes`
--

INSERT INTO `ingredientes` (`id_ingrediente`, `nombre_ingrediente`, `activo`) VALUES
(2, 'Harina de trigo', 1),
(3, 'Vino', 1),
(4, 'Sardinas', 1),
(6, 'Mantequilla de Cacahuete', 1),
(7, 'Leche de Vaca', 1),
(8, 'Mantequilla de vaca', 1),
(9, 'Azúcar blanco refinado', 1),
(22, 'Azúcar en cuadradillo', 1),
(23, 'Almendras', 1),
(24, 'Bourbon', 1),
(27, 'Magret de pato', 1),
(28, 'Sal', 1),
(29, 'Pimienta negra', 1),
(30, 'Zanahorias', 1),
(31, 'Setas variadas', 1),
(32, 'Brócoli', 1),
(33, 'Tomillo', 1),
(34, 'Romero', 1),
(35, 'Aceite de oliva virgen extra', 1),
(36, 'Naranjas', 1),
(37, 'Salsa de soja', 1),
(38, 'vinagre balsámico', 1),
(39, 'Miel', 1),
(40, 'Harina de maíz', 1),
(41, 'Huevo', 1),
(42, 'Bicarbonato', 1),
(43, 'Agua', 1),
(44, 'Levadura en polvo', 1),
(45, 'Aceite de girasol', 1),
(46, 'Cerveza', 1),
(47, 'Nata', 1),
(48, 'Yema de huevo', 1),
(49, 'Pan', 1),
(50, 'Canela', 1),
(51, 'Pimienta', 1),
(52, 'Aceite de oliva suave', 1),
(53, 'Tomate', 1),
(54, 'Cebolla blanca', 1),
(55, 'Jalapeño', 1),
(56, 'Cilantro', 1),
(57, 'Limón', 1),
(58, 'Clara de huevo', 1),
(59, 'Harina fuerte', 1),
(60, 'Levadura prensada', 1),
(61, 'Agua fría', 1),
(62, 'Agua templada', 1),
(63, 'Aguacates', 1),
(64, 'Langostinos', 1),
(65, 'Cebolla morada', 1),
(66, 'Chile chipotle', 1),
(67, 'Mayonesa', 1),
(68, 'Salmón', 1),
(69, 'Bacalao', 1),
(70, 'Pan rallado', 1),
(71, 'Ajo', 1),
(72, 'Perejil', 1),
(73, 'Vino blanco', 1),
(74, 'Fumet', 1),
(75, 'Guisantes', 1),
(76, 'Almeja', 1),
(77, 'Cayena', 1),
(78, 'Arroz bomba', 1),
(79, 'Aromas (ver en receta)', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredientes_alergenos`
--

DROP TABLE IF EXISTS `ingredientes_alergenos`;
CREATE TABLE `ingredientes_alergenos` (
  `id_ing_ale` int(11) NOT NULL,
  `id_ingrediente` int(11) NOT NULL,
  `id_alergeno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `ingredientes_alergenos`
--

TRUNCATE TABLE `ingredientes_alergenos`;
--
-- Volcado de datos para la tabla `ingredientes_alergenos`
--

INSERT INTO `ingredientes_alergenos` (`id_ing_ale`, `id_ingrediente`, `id_alergeno`) VALUES
(1, 2, 3),
(3, 3, 12),
(21, 4, 5),
(6, 6, 6),
(29, 7, 2),
(5, 8, 2),
(22, 23, 6),
(25, 37, 3),
(24, 37, 7),
(26, 38, 12),
(27, 41, 4),
(28, 44, 3),
(30, 46, 3),
(31, 47, 2),
(33, 48, 4),
(32, 49, 3),
(34, 58, 4),
(35, 59, 3),
(36, 60, 3),
(37, 64, 1),
(38, 67, 4),
(45, 68, 5),
(40, 69, 5),
(44, 70, 3),
(46, 73, 12),
(41, 74, 1),
(43, 74, 5),
(42, 74, 14),
(39, 76, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

DROP TABLE IF EXISTS `paises`;
CREATE TABLE `paises` (
  `id_pais` int(11) NOT NULL,
  `esp_pais` varchar(50) NOT NULL,
  `eng_pais` varchar(50) NOT NULL,
  `fra_pais` varchar(50) NOT NULL,
  `iso2_pais` varchar(2) NOT NULL,
  `iso3_pais` varchar(3) NOT NULL,
  `cod_tel` int(11) DEFAULT NULL,
  `id_zona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `paises`
--

TRUNCATE TABLE `paises`;
--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`id_pais`, `esp_pais`, `eng_pais`, `fra_pais`, `iso2_pais`, `iso3_pais`, `cod_tel`, `id_zona`) VALUES
(0, 'No definido', 'Not defined', 'Sans definir', 'nd', 'nd', 0, 0),
(1, 'Afganistán', 'Afghanistan', 'Afghanistan', 'AF', 'AFG', 93, 2),
(2, 'Albania', 'Albania', 'Albanie', 'AL', 'ALB', 355, 1),
(3, 'Alemania', 'Germany', 'Allemagne', 'DE', 'DEU', 49, 1),
(4, 'Algeria', 'Algeria', 'Algérie', 'DZ', 'DZA', 213, 3),
(5, 'Andorra', 'Andorra', 'Andorra', 'AD', 'AND', 376, 1),
(6, 'Angola', 'Angola', 'Angola', 'AO', 'AGO', 244, 3),
(7, 'Anguila', 'Anguilla', 'Anguilla', 'AI', 'AIA', 1264, 4),
(8, 'Antártida', 'Antarctica', 'L\'Antarctique', 'AQ', 'ATA', 672, 5),
(9, 'Antigua y Barbuda', 'Antigua and Barbuda', 'Antigua et Barbuda', 'AG', 'ATG', 1268, 4),
(10, 'Antillas Neerlandesas', 'Netherlands Antilles', 'Antilles Néerlandaises', 'AN', 'ANT', 599, 4),
(11, 'Arabia Saudita', 'Saudi Arabia', 'Arabie Saoudite', 'SA', 'SAU', 966, 2),
(12, 'Argentina', 'Argentina', 'Argentine', 'AR', 'ARG', 54, 4),
(13, 'Armenia', 'Armenia', 'L\'Arménie', 'AM', 'ARM', 374, 2),
(14, 'Aruba', 'Aruba', 'Aruba', 'AW', 'ABW', 297, 4),
(15, 'Australia', 'Australia', 'Australie', 'AU', 'AUS', 61, 6),
(16, 'Austria', 'Austria', 'Autriche', 'AT', 'AUT', 43, 1),
(17, 'Azerbayán', 'Azerbaijan', 'L\'Azerbaïdjan', 'AZ', 'AZE', 994, 2),
(18, 'Bélgica', 'Belgium', 'Belgique', 'BE', 'BEL', 32, 1),
(19, 'Bahamas', 'Bahamas', 'Bahamas', 'BS', 'BHS', 1242, 4),
(20, 'Bahrein', 'Bahrain', 'Bahreïn', 'BH', 'BHR', 973, 2),
(21, 'Bangladesh', 'Bangladesh', 'Bangladesh', 'BD', 'BGD', 880, 2),
(22, 'Barbados', 'Barbados', 'Barbade', 'BB', 'BRB', 1246, 4),
(23, 'Belice', 'Belize', 'Belize', 'BZ', 'BLZ', 501, 4),
(24, 'Benín', 'Benin', 'Bénin', 'BJ', 'BEN', 229, 3),
(25, 'Bhután', 'Bhutan', 'Le Bhoutan', 'BT', 'BTN', 975, 2),
(26, 'Bielorrusia', 'Belarus', 'Biélorussie', 'BY', 'BLR', 375, 1),
(27, 'Birmania', 'Myanmar', 'Myanmar', 'MM', 'MMR', 95, 2),
(28, 'Bolivia', 'Bolivia', 'Bolivie', 'BO', 'BOL', 591, 4),
(29, 'Bosnia y Herzegovina', 'Bosnia and Herzegovina', 'Bosnie-Herzégovine', 'BA', 'BIH', 387, 1),
(30, 'Botsuana', 'Botswana', 'Botswana', 'BW', 'BWA', 267, 3),
(31, 'Brasil', 'Brazil', 'Brésil', 'BR', 'BRA', 55, 4),
(32, 'Brunéi', 'Brunei', 'Brunei', 'BN', 'BRN', 673, 2),
(33, 'Bulgaria', 'Bulgaria', 'Bulgarie', 'BG', 'BGR', 359, 1),
(34, 'Burkina Faso', 'Burkina Faso', 'Burkina Faso', 'BF', 'BFA', 226, 3),
(35, 'Burundi', 'Burundi', 'Burundi', 'BI', 'BDI', 257, 3),
(36, 'Cabo Verde', 'Cape Verde', 'Cap-Vert', 'CV', 'CPV', 238, 3),
(37, 'Camboya', 'Cambodia', 'Cambodge', 'KH', 'KHM', 855, 2),
(38, 'Camerún', 'Cameroon', 'Cameroun', 'CM', 'CMR', 237, 3),
(39, 'Canadá', 'Canada', 'Canada', 'CA', 'CAN', 1, 4),
(40, 'Chad', 'Chad', 'Tchad', 'TD', 'TCD', 235, 3),
(41, 'Chile', 'Chile', 'Chili', 'CL', 'CHL', 56, 4),
(42, 'China', 'China', 'Chine', 'CN', 'CHN', 86, 2),
(43, 'Chipre', 'Cyprus', 'Chypre', 'CY', 'CYP', 357, 2),
(44, 'Ciudad del Vaticano', 'Vatican City State', 'Cité du Vatican', 'VA', 'VAT', 39, 1),
(45, 'Colombia', 'Colombia', 'Colombie', 'CO', 'COL', 57, 4),
(46, 'Comoras', 'Comoros', 'Comores', 'KM', 'COM', 269, 3),
(47, 'Congo', 'Congo', 'Congo', 'CG', 'COG', 242, 3),
(48, 'Congo Belga', 'Belgium Congo', 'Congo Belga', 'CD', 'COD', 243, 3),
(49, 'Corea del Norte', 'North Korea', 'Corée du Nord', 'KP', 'PRK', 850, 2),
(50, 'Corea del Sur', 'South Korea', 'Corée du Sud', 'KR', 'KOR', 82, 2),
(51, 'Costa de Marfil', 'Ivory Coast', 'Côte-d\'Ivoire', 'CI', 'CIV', 225, 3),
(52, 'Costa Rica', 'Costa Rica', 'Costa Rica', 'CR', 'CRI', 506, 4),
(53, 'Croacia', 'Croatia', 'Croatie', 'HR', 'HRV', 385, 1),
(54, 'Cuba', 'Cuba', 'Cuba', 'CU', 'CUB', 53, 4),
(55, 'Dinamarca', 'Denmark', 'Danemark', 'DK', 'DNK', 45, 1),
(56, 'Dominica', 'Dominica', 'Dominique', 'DM', 'DMA', 1767, 4),
(57, 'Ecuador', 'Ecuador', 'Equateur', 'EC', 'ECU', 593, 4),
(58, 'Egipto', 'Egypt', 'Egypte', 'EG', 'EGY', 20, 3),
(59, 'El Salvador', 'El Salvador', 'El Salvador', 'SV', 'SLV', 503, 4),
(60, 'Emiratos Árabes Unidos', 'United Arab Emirates', 'Emirats Arabes Unis', 'AE', 'ARE', 971, 2),
(61, 'Eritrea', 'Eritrea', 'Erythrée', 'ER', 'ERI', 291, 3),
(62, 'Eslovaquia', 'Slovakia', 'Slovaquie', 'SK', 'SVK', 421, 1),
(63, 'Eslovenia', 'Slovenia', 'Slovénie', 'SI', 'SVN', 386, 1),
(64, 'España', 'Spain', 'Espagne', 'ES', 'ESP', 34, 1),
(65, 'Estados Unidos de América', 'United States of America', 'États-Unis d\'Amérique', 'US', 'USA', 1, 4),
(66, 'Estonia', 'Estonia', 'L\'Estonie', 'EE', 'EST', 372, 1),
(67, 'Etiopía', 'Ethiopia', 'Ethiopie', 'ET', 'ETH', 251, 3),
(68, 'Filipinas', 'Philippines', 'Philippines', 'PH', 'PHL', 63, 2),
(69, 'Finlandia', 'Finland', 'Finlande', 'FI', 'FIN', 358, 1),
(70, 'Fiyi', 'Fiji', 'Fidji', 'FJ', 'FJI', 679, 6),
(71, 'Francia', 'France', 'France', 'FR', 'FRA', 33, 1),
(72, 'Gabón', 'Gabon', 'Gabon', 'GA', 'GAB', 241, 3),
(73, 'Gambia', 'Gambia', 'Gambie', 'GM', 'GMB', 220, 3),
(74, 'Georgia', 'Georgia', 'Géorgie', 'GE', 'GEO', 995, 2),
(75, 'Ghana', 'Ghana', 'Ghana', 'GH', 'GHA', 233, 3),
(76, 'Gibraltar', 'Gibraltar', 'Gibraltar', 'GI', 'GIB', 350, 1),
(77, 'Granada', 'Grenada', 'Grenade', 'GD', 'GRD', 1473, 4),
(78, 'Grecia', 'Greece', 'Grèce', 'GR', 'GRC', 30, 1),
(79, 'Groenlandia', 'Greenland', 'Groenland', 'GL', 'GRL', 299, 4),
(80, 'Guadalupe', 'Guadeloupe', 'Guadeloupe', 'GP', 'GLP', 0, 4),
(81, 'Guam', 'Guam', 'Guam', 'GU', 'GUM', 1671, 6),
(82, 'Guatemala', 'Guatemala', 'Guatemala', 'GT', 'GTM', 502, 4),
(83, 'Guayana Francesa', 'French Guiana', 'Guyane française', 'GF', 'GUF', 0, 4),
(84, 'Guernsey', 'Guernsey', 'Guernesey', 'GG', 'GGY', 0, 1),
(85, 'Guinea', 'Guinea', 'Guinée', 'GN', 'GIN', 224, 3),
(86, 'Guinea Ecuatorial', 'Equatorial Guinea', 'Guinée Equatoriale', 'GQ', 'GNQ', 240, 3),
(87, 'Guinea-Bissau', 'Guinea-Bissau', 'Guinée-Bissau', 'GW', 'GNB', 245, 3),
(88, 'Guyana', 'Guyana', 'Guyane', 'GY', 'GUY', 592, 4),
(89, 'Haití', 'Haiti', 'Haïti', 'HT', 'HTI', 509, 4),
(90, 'Honduras', 'Honduras', 'Honduras', 'HN', 'HND', 504, 4),
(91, 'Hong kong', 'Hong Kong', 'Hong Kong', 'HK', 'HKG', 852, 2),
(92, 'Hungría', 'Hungary', 'Hongrie', 'HU', 'HUN', 36, 1),
(93, 'India', 'India', 'Inde', 'IN', 'IND', 91, 2),
(94, 'Indonesia', 'Indonesia', 'Indonésie', 'ID', 'IDN', 62, 2),
(95, 'Irán', 'Iran', 'Iran', 'IR', 'IRN', 98, 2),
(96, 'Irak', 'Iraq', 'Irak', 'IQ', 'IRQ', 964, 2),
(97, 'Irlanda', 'Ireland', 'Irlande', 'IE', 'IRL', 353, 1),
(98, 'Isla Bouvet', 'Bouvet Island', 'Bouvet Island', 'BV', 'BVT', 0, 5),
(99, 'Isla de Man', 'Isle of Man', 'Ile de Man', 'IM', 'IMN', 44, 1),
(100, 'Isla de Navidad', 'Christmas Island', 'Christmas Island', 'CX', 'CXR', 61, 2),
(101, 'Isla Norfolk', 'Norfolk Island', 'Île de Norfolk', 'NF', 'NFK', 0, 6),
(102, 'Islandia', 'Iceland', 'Islande', 'IS', 'ISL', 354, 1),
(103, 'Islas Bermudas', 'Bermuda Islands', 'Bermudes', 'BM', 'BMU', 1441, 4),
(104, 'Islas Caimán', 'Cayman Islands', 'Iles Caïmans', 'KY', 'CYM', 1345, 4),
(105, 'Islas Cocos (Keeling)', 'Cocos (Keeling) Islands', 'Cocos (Keeling', 'CC', 'CCK', 61, 2),
(106, 'Islas Cook', 'Cook Islands', 'Iles Cook', 'CK', 'COK', 682, 6),
(107, 'Islas de Åland', 'Åland Islands', 'Îles Åland', 'AX', 'ALA', 0, 1),
(108, 'Islas Feroe', 'Faroe Islands', 'Iles Féro', 'FO', 'FRO', 298, 1),
(109, 'Islas Georgias del Sur y Sandwich del Sur', 'South Georgia and the South Sandwich Islands', 'Géorgie du Sud et les Îles Sandwich du Sud', 'GS', 'SGS', 0, 4),
(110, 'Islas Heard y McDonald', 'Heard Island and McDonald Islands', 'Les îles Heard et McDonald', 'HM', 'HMD', 0, 5),
(111, 'Islas Maldivas', 'Maldives', 'Maldives', 'MV', 'MDV', 960, 2),
(112, 'Islas Malvinas', 'Falkland Islands (Malvinas)', 'Iles Falkland (Malvinas', 'FK', 'FLK', 500, 4),
(113, 'Islas Marianas del Norte', 'Northern Mariana Islands', 'Iles Mariannes du Nord', 'MP', 'MNP', 1670, 6),
(114, 'Islas Marshall', 'Marshall Islands', 'Iles Marshall', 'MH', 'MHL', 692, 6),
(115, 'Islas Pitcairn', 'Pitcairn Islands', 'Iles Pitcairn', 'PN', 'PCN', 870, 6),
(116, 'Islas Salomón', 'Solomon Islands', 'Iles Salomon', 'SB', 'SLB', 677, 6),
(117, 'Islas Turcas y Caicos', 'Turks and Caicos Islands', 'Iles Turques et Caïques', 'TC', 'TCA', 1649, 4),
(118, 'Islas Ultramarinas Menores de Estados Unidos', 'United States Minor Outlying Islands', 'États-Unis Îles mineures éloignées', 'UM', 'UMI', 0, 4),
(119, 'Islas Vírgenes Británicas', 'Virgin Islands', 'Iles Vierges', 'VG', 'VG', 1284, 4),
(120, 'Islas Vírgenes de los Estados Unidos', 'United States Virgin Islands', 'Îles Vierges américaines', 'VI', 'VIR', 1340, 4),
(121, 'Israel', 'Israel', 'Israël', 'IL', 'ISR', 972, 2),
(122, 'Italia', 'Italy', 'Italie', 'IT', 'ITA', 39, 1),
(123, 'Jamaica', 'Jamaica', 'Jamaïque', 'JM', 'JAM', 1876, 4),
(124, 'Japón', 'Japan', 'Japon', 'JP', 'JPN', 81, 2),
(125, 'Jersey', 'Jersey', 'Maillot', 'JE', 'JEY', 0, 1),
(126, 'Jordania', 'Jordan', 'Jordan', 'JO', 'JOR', 962, 2),
(127, 'Kazajistán', 'Kazakhstan', 'Le Kazakhstan', 'KZ', 'KAZ', 7, 2),
(128, 'Kenia', 'Kenya', 'Kenya', 'KE', 'KEN', 254, 3),
(129, 'Kirgizstán', 'Kyrgyzstan', 'Kirghizstan', 'KG', 'KGZ', 996, 2),
(130, 'Kiribati', 'Kiribati', 'Kiribati', 'KI', 'KIR', 686, 6),
(131, 'Kuwait', 'Kuwait', 'Koweït', 'KW', 'KWT', 965, 2),
(132, 'Líbano', 'Lebanon', 'Liban', 'LB', 'LBN', 961, 2),
(133, 'Laos', 'Laos', 'Laos', 'LA', 'LAO', 856, 2),
(134, 'Lesoto', 'Lesotho', 'Lesotho', 'LS', 'LSO', 266, 3),
(135, 'Letonia', 'Latvia', 'La Lettonie', 'LV', 'LVA', 371, 1),
(136, 'Liberia', 'Liberia', 'Liberia', 'LR', 'LBR', 231, 3),
(137, 'Libia', 'Libya', 'Libye', 'LY', 'LBY', 218, 3),
(138, 'Liechtenstein', 'Liechtenstein', 'Liechtenstein', 'LI', 'LIE', 423, 1),
(139, 'Lituania', 'Lithuania', 'La Lituanie', 'LT', 'LTU', 370, 1),
(140, 'Luxemburgo', 'Luxembourg', 'Luxembourg', 'LU', 'LUX', 352, 1),
(141, 'México', 'Mexico', 'Mexique', 'MX', 'MEX', 52, 4),
(142, 'Mónaco', 'Monaco', 'Monaco', 'MC', 'MCO', 377, 1),
(143, 'Macao', 'Macao', 'Macao', 'MO', 'MAC', 853, 2),
(144, 'Macedônia', 'Macedonia', 'Macédoine', 'MK', 'MKD', 389, 1),
(145, 'Madagascar', 'Madagascar', 'Madagascar', 'MG', 'MDG', 261, 3),
(146, 'Malasia', 'Malaysia', 'Malaisie', 'MY', 'MYS', 60, 2),
(147, 'Malawi', 'Malawi', 'Malawi', 'MW', 'MWI', 265, 3),
(148, 'Mali', 'Mali', 'Mali', 'ML', 'MLI', 223, 3),
(149, 'Malta', 'Malta', 'Malte', 'MT', 'MLT', 356, 1),
(150, 'Marruecos', 'Morocco', 'Maroc', 'MA', 'MAR', 212, 3),
(151, 'Martinica', 'Martinique', 'Martinique', 'MQ', 'MTQ', 0, 4),
(152, 'Mauricio', 'Mauritius', 'Iles Maurice', 'MU', 'MUS', 230, 3),
(153, 'Mauritania', 'Mauritania', 'Mauritanie', 'MR', 'MRT', 222, 3),
(154, 'Mayotte', 'Mayotte', 'Mayotte', 'YT', 'MYT', 262, 3),
(155, 'Micronesia', 'Estados Federados de', 'Federados Estados de', 'FM', 'FSM', 691, 6),
(156, 'Moldavia', 'Moldova', 'Moldavie', 'MD', 'MDA', 373, 1),
(157, 'Mongolia', 'Mongolia', 'Mongolie', 'MN', 'MNG', 976, 2),
(158, 'Montenegro', 'Montenegro', 'Monténégro', 'ME', 'MNE', 382, 1),
(159, 'Montserrat', 'Montserrat', 'Montserrat', 'MS', 'MSR', 1664, 4),
(160, 'Mozambique', 'Mozambique', 'Mozambique', 'MZ', 'MOZ', 258, 3),
(161, 'Namibia', 'Namibia', 'Namibie', 'NA', 'NAM', 264, 3),
(162, 'Nauru', 'Nauru', 'Nauru', 'NR', 'NRU', 674, 6),
(163, 'Nepal', 'Nepal', 'Népal', 'NP', 'NPL', 977, 2),
(164, 'Nicaragua', 'Nicaragua', 'Nicaragua', 'NI', 'NIC', 505, 4),
(165, 'Niger', 'Niger', 'Niger', 'NE', 'NER', 227, 3),
(166, 'Nigeria', 'Nigeria', 'Nigeria', 'NG', 'NGA', 234, 3),
(167, 'Niue', 'Niue', 'Niou', 'NU', 'NIU', 683, 6),
(168, 'Noruega', 'Norway', 'Norvège', 'NO', 'NOR', 47, 1),
(169, 'Nueva Caledonia', 'New Caledonia', 'Nouvelle-Calédonie', 'NC', 'NCL', 687, 6),
(170, 'Nueva Zelanda', 'New Zealand', 'Nouvelle-Zélande', 'NZ', 'NZL', 64, 6),
(171, 'Omán', 'Oman', 'Oman', 'OM', 'OMN', 968, 2),
(172, 'Países Bajos', 'Netherlands', 'Pays-Bas', 'NL', 'NLD', 31, 1),
(173, 'Pakistán', 'Pakistan', 'Pakistan', 'PK', 'PAK', 92, 2),
(174, 'Palau', 'Palau', 'Palau', 'PW', 'PLW', 680, 6),
(175, 'Palestina', 'Palestine', 'La Palestine', 'PS', 'PSE', 0, 2),
(176, 'Panamá', 'Panama', 'Panama', 'PA', 'PAN', 507, 4),
(177, 'Papúa Nueva Guinea', 'Papua New Guinea', 'Papouasie-Nouvelle-Guinée', 'PG', 'PNG', 675, 6),
(178, 'Paraguay', 'Paraguay', 'Paraguay', 'PY', 'PRY', 595, 4),
(179, 'Perú', 'Peru', 'Pérou', 'PE', 'PER', 51, 4),
(180, 'Polinesia Francesa', 'French Polynesia', 'Polynésie française', 'PF', 'PYF', 689, 6),
(181, 'Polonia', 'Poland', 'Pologne', 'PL', 'POL', 48, 1),
(182, 'Portugal', 'Portugal', 'Portugal', 'PT', 'PRT', 351, 1),
(183, 'Puerto Rico', 'Puerto Rico', 'Porto Rico', 'PR', 'PRI', 1, 4),
(184, 'Qatar', 'Qatar', 'Qatar', 'QA', 'QAT', 974, 2),
(185, 'Reino Unido', 'United Kingdom', 'Royaume-Uni', 'GB', 'GBR', 44, 1),
(186, 'República Centroafricana', 'Central African Republic', 'République Centrafricaine', 'CF', 'CAF', 236, 3),
(187, 'República Checa', 'Czech Republic', 'République Tchèque', 'CZ', 'CZE', 420, 1),
(188, 'República Dominicana', 'Dominican Republic', 'République Dominicaine', 'DO', 'DOM', 1809, 4),
(189, 'Reunión', 'Réunion', 'Réunion', 'RE', 'REU', 0, 3),
(190, 'Ruanda', 'Rwanda', 'Rwanda', 'RW', 'RWA', 250, 3),
(191, 'Rumanía', 'Romania', 'Roumanie', 'RO', 'ROU', 40, 1),
(192, 'Rusia', 'Russia', 'La Russie', 'RU', 'RUS', 7, 1),
(193, 'Sahara Occidental', 'Western Sahara', 'Sahara Occidental', 'EH', 'ESH', 0, 3),
(194, 'Samoa', 'Samoa', 'Samoa', 'WS', 'WSM', 685, 6),
(195, 'Samoa Americana', 'American Samoa', 'Les Samoa américaines', 'AS', 'ASM', 1684, 6),
(196, 'San Bartolomé', 'Saint Barthélemy', 'Saint-Barthélemy', 'BL', 'BLM', 590, 4),
(197, 'San Cristóbal y Nieves', 'Saint Kitts and Nevis', 'Saint Kitts et Nevis', 'KN', 'KNA', 1869, 4),
(198, 'San Marino', 'San Marino', 'San Marino', 'SM', 'SMR', 378, 1),
(199, 'San Martín (Francia)', 'Saint Martin (French part)', 'Saint-Martin (partie française)', 'MF', 'MAF', 1599, 4),
(200, 'San Pedro y Miquelón', 'Saint Pierre and Miquelon', 'Saint-Pierre-et-Miquelon', 'PM', 'SPM', 508, 4),
(201, 'San Vicente y las Granadinas', 'Saint Vincent and the Grenadines', 'Saint-Vincent et Grenadines', 'VC', 'VCT', 1784, 4),
(202, 'Santa Elena', 'Ascensión y Tristán de Acuña', 'Ascensión y Tristan de Acuña', 'SH', 'SHN', 290, 3),
(203, 'Santa Lucía', 'Saint Lucia', 'Sainte-Lucie', 'LC', 'LCA', 1758, 4),
(204, 'Santo Tomé y Príncipe', 'Sao Tome and Principe', 'Sao Tomé et Principe', 'ST', 'STP', 239, 3),
(205, 'Senegal', 'Senegal', 'Sénégal', 'SN', 'SEN', 221, 3),
(206, 'Serbia', 'Serbia', 'Serbie', 'RS', 'SRB', 381, 1),
(207, 'Seychelles', 'Seychelles', 'Les Seychelles', 'SC', 'SYC', 248, 3),
(208, 'Sierra Leona', 'Sierra Leone', 'Sierra Leone', 'SL', 'SLE', 232, 3),
(209, 'Singapur', 'Singapore', 'Singapour', 'SG', 'SGP', 65, 2),
(210, 'Siria', 'Syria', 'Syrie', 'SY', 'SYR', 963, 2),
(211, 'Somalia', 'Somalia', 'Somalie', 'SO', 'SOM', 252, 3),
(212, 'Sri lanka', 'Sri Lanka', 'Sri Lanka', 'LK', 'LKA', 94, 2),
(213, 'Sudáfrica', 'South Africa', 'Afrique du Sud', 'ZA', 'ZAF', 27, 3),
(214, 'Sudán', 'Sudan', 'Soudan', 'SD', 'SDN', 249, 3),
(215, 'Suecia', 'Sweden', 'Suède', 'SE', 'SWE', 46, 1),
(216, 'Suiza', 'Switzerland', 'Suisse', 'CH', 'CHE', 41, 1),
(217, 'Surinám', 'Suriname', 'Surinam', 'SR', 'SUR', 597, 4),
(218, 'Svalbard y Jan Mayen', 'Svalbard and Jan Mayen', 'Svalbard et Jan Mayen', 'SJ', 'SJM', 0, 1),
(219, 'Swazilandia', 'Swaziland', 'Swaziland', 'SZ', 'SWZ', 268, 3),
(220, 'Tadjikistán', 'Tajikistan', 'Le Tadjikistan', 'TJ', 'TJK', 992, 2),
(221, 'Tailandia', 'Thailand', 'Thaïlande', 'TH', 'THA', 66, 2),
(222, 'Taiwán', 'Taiwan', 'Taiwan', 'TW', 'TWN', 886, 2),
(223, 'Tanzania', 'Tanzania', 'Tanzanie', 'TZ', 'TZA', 255, 3),
(224, 'Territorio Británico del Océano Índico', 'British Indian Ocean Territory', 'Territoire britannique de l\'océan Indien', 'IO', 'IOT', 2, 2),
(225, 'Territorios Australes y Antárticas Franceses', 'French Southern Territories', 'Terres australes françaises', 'TF', 'ATF', 5, 5),
(226, 'Timor Oriental', 'East Timor', 'Timor-Oriental', 'TL', 'TLS', 670, 2),
(227, 'Togo', 'Togo', 'Togo', 'TG', 'TGO', 228, 3),
(228, 'Tokelau', 'Tokelau', 'Tokélaou', 'TK', 'TKL', 690, 6),
(229, 'Tonga', 'Tonga', 'Tonga', 'TO', 'TON', 676, 6),
(230, 'Trinidad y Tobago', 'Trinidad and Tobago', 'Trinidad et Tobago', 'TT', 'TTO', 1868, 4),
(231, 'Tunez', 'Tunisia', 'Tunisie', 'TN', 'TUN', 216, 3),
(232, 'Turkmenistán', 'Turkmenistan', 'Le Turkménistan', 'TM', 'TKM', 993, 2),
(233, 'Turquía', 'Turkey', 'Turquie', 'TR', 'TUR', 90, 2),
(234, 'Tuvalu', 'Tuvalu', 'Tuvalu', 'TV', 'TUV', 688, 6),
(235, 'Ucrania', 'Ukraine', 'L\'Ukraine', 'UA', 'UKR', 380, 1),
(236, 'Uganda', 'Uganda', 'Ouganda', 'UG', 'UGA', 256, 3),
(237, 'Uruguay', 'Uruguay', 'Uruguay', 'UY', 'URY', 598, 4),
(238, 'Uzbekistán', 'Uzbekistan', 'L\'Ouzbékistan', 'UZ', 'UZB', 998, 2),
(239, 'Vanuatu', 'Vanuatu', 'Vanuatu', 'VU', 'VUT', 678, 6),
(240, 'Venezuela', 'Venezuela', 'Venezuela', 'VE', 'VEN', 58, 4),
(241, 'Vietnam', 'Vietnam', 'Vietnam', 'VN', 'VNM', 84, 2),
(242, 'Wallis y Futuna', 'Wallis and Futuna', 'Wallis et Futuna', 'WF', 'WLF', 681, 6),
(243, 'Yemen', 'Yemen', 'Yémen', 'YE', 'YEM', 967, 2),
(244, 'Yibuti', 'Djibouti', 'Djibouti', 'DJ', 'DJI', 253, 3),
(245, 'Zambia', 'Zambia', 'Zambie', 'ZM', 'ZMB', 260, 3),
(246, 'Zimbabue', 'Zimbabwe', 'Zimbabwe', 'ZW', 'ZWE', 263, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propias`
--

DROP TABLE IF EXISTS `propias`;
CREATE TABLE `propias` (
  `id_propias` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `propias`
--

TRUNCATE TABLE `propias`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas`
--

DROP TABLE IF EXISTS `recetas`;
CREATE TABLE `recetas` (
  `id_receta` int(11) NOT NULL,
  `nombre_receta` varchar(255) NOT NULL,
  `descripcion_receta` varchar(255) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `n_personas` int(11) NOT NULL,
  `tiempo_receta` time NOT NULL,
  `id_autor` int(11) DEFAULT NULL,
  `id_region` int(11) DEFAULT NULL,
  `id_pais` int(11) DEFAULT NULL,
  `id_zona` int(11) DEFAULT 0,
  `dificultad` int(11) NOT NULL,
  `elaboracion` mediumtext NOT NULL,
  `emplatado` mediumtext DEFAULT NULL,
  `foto_receta` varchar(255) DEFAULT NULL,
  `visualizaciones` bigint(20) NOT NULL DEFAULT 1,
  `creado_receta` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_receta` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activo` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `recetas`
--

TRUNCATE TABLE `recetas`;
--
-- Volcado de datos para la tabla `recetas`
--

INSERT INTO `recetas` (`id_receta`, `nombre_receta`, `descripcion_receta`, `id_usuario`, `id_grupo`, `n_personas`, `tiempo_receta`, `id_autor`, `id_region`, `id_pais`, `id_zona`, `dificultad`, `elaboracion`, `emplatado`, `foto_receta`, `visualizaciones`, `creado_receta`, `actualizado_receta`, `activo`) VALUES
(36, 'Bolovanes rellenos', 'Bolovanes salados rellenos de sardinas, atún, paté, etc.', 1, 13, 4, '00:45:00', NULL, 0, 160, 3, 2, 'Juntamos todo excepto las sardinas en la kitchen aid:\r\nMezclamos hasta que quede todo como una pasta asquerosa.\r\nFreimos las sardinas en abundante aceite caliente.\r\nEstiramos la masa y la moldeamos formando vasitos, que hornearemos hasta que aparezcan churruscaditos.\r\nColocamos cada sardina en un vasito, dejando asomar la cola por arriba para que parezca que se están ahogando.', 'Todos juntitos en una bandeja cuadrada y los espolvoreamos con abundante farlopa colombiana.', 'Bolovanes_202511100809491167.jpg', 1, '2025-11-10 19:09:49', '2025-11-10 19:09:49', 0),
(37, 'Pechuga de pato con verduras', 'Plato con gran aporte de proteinas pero también con grasas saturadas.', 1, 1, 4, '01:20:00', NULL, 0, 0, 0, 3, '* Para el puré de zanahoria caramelizada:\r\n    1.- Pelamos las zanahorias, las cortamos longitudinalmente y retiramos la parte central, que es menos dulce.\r\n    2.- Troceamos en piezas pequeñas y las añadimos a un cazo con la mantequilla deretida.\r\n    3.- Incorporamos un chorrito de agua y cocinamos a fuego suave durante unos 20 minutos, hasta que estén tiernas y ligeramente caramelizadas.\r\n    4.- Trituramos hasta obtener un puré fino y lo pasamos por un colador para lograr una textura más lisa y sedosa.\r\n\r\n* Para la salsa de naranja:\r\n    5.- En un cazo ponemos el zumo de naranja, la soja, el vinagre, la miel y una pizca de sal. Calentamos a fuego medio, removiendo de vez en cuando hasta que reduzca.\r\n    6.- Añadimos la maicena disuelta y cocinamos 2-3 minutos más hasta espesar.\r\n\r\n* Para la guarnición:\r\n    7.- Cortamos los brócolis en pequeños trozos y las zanahorias en trozos medianos.\r\n    8.- En una sartén con aceite de oliva, rehogamos las verduras con una pizca de sal, tomillo y romero. Cocinamos a fuego medio-bajo hasta que estén tiernas pero ligeramente al dente.\r\n    9.- Por otro lado salteamos las setas en una sartén. Reservamos para usarlas como base de nuestro pato.\r\n    10.- Reservamos las verduras calientes para emplatar.\r\n\r\n* Para la carne:\r\n    11.- Limpiamos los magrets retirando restos de grasa o plumas.\r\n    12.- Hacemos cortes superficiales en la piel en forma de rombos sin llegar a la carne. Sazonamos con sal y pimienta.\r\n    13.- Cocinamos en una sartén sin aceite, primero por el lado de la piel hasta que suelte la grasa y quede dorada, luego damos la vuelta y cocinamos 2-3 minutos más.\r\n    14.- Retiramos, dejamos reposar 2 minutos y cortamos en rodajas.', 'En una bandeja ovalada, colocamos las rodajas de pato en forma de fichas de dominó en el centro, la salsa a un lado y las verduras en el otro.', 'Pechuga_202511110141257051.png', 1, '2025-11-11 12:41:25', '2025-11-11 12:41:25', 0),
(38, 'Doriyakis', 'Tortitas muy esponjosas japonesas emparejadas a modo de sandwich con algún relleno en medio de mermelada, crema,  dulce de leche, etc., al gusto', 23, 6, 6, '00:45:00', NULL, 0, 124, 2, 2, 'Abizcochar los huevos con el azúcar, añadir la miel y continuar batiendo.\r\nDiluir el bicarbonato en el agua e incorporarlo a la masa. Mezclarlo bien.\r\nTamizar la harina con la levadura y añadir poco a poco a la masa, sin dejar de mezclar para que no queden grumos.\r\nPintar una sartén con aceite de girasol y, cuando esté bien caliente, añadir 2-3 cucharadas soperas de masa en el centro. Cocinar unos minutos, hasta que la superficie se llene de burbujas. La parte inferior debería estar bien dorada. Dar la vuelta con cuidado  y esperar a que se dore por la otra cara. Sacar a una bandeja con papel de horno para que no se pegue.\r\nCuando estén frias, emparejar las tortas de dos en dos, poniendo juntas las que más se parezcan por su forma. Untar con el relleno elegido la mitad y cierra con sus respectivas parejas, formando sandwiches.', '', NULL, 1, '2025-11-12 20:07:10', '2025-11-12 20:07:10', 0),
(39, 'Biersuppe', 'Reconfortante sopa cremosa elaborada con cerveza originaria de Baviera', 23, 19, 6, '00:30:00', NULL, 0, 3, 1, 2, 'Croutons:\nCortar las rebanadas de pan, si son del día anterior mejor, en cuadraditos de uno o dos centímetros y freír en abundante aceite de oliva suave. Sopa: Fundir la mantequilla en una olla a fuego suave. Cuando esté líquida se incorpora la harina y se remueve hasta que se haya tostado ligeramente; incorporar la cerveza. Se deja hervir a fuego lento, sin dejar de remover durante unos 20 min. y, a continuación, se salpimenta y, opcionalmente, se añade la canela. Se retira del fuego, se baten las yemas con la nata líquida y se incorporan a la sopa caliente cuando ya no esté hirviendo. Se vuelve a poner el conjunto a fuego bajo durante unos cinco minutos.', 'Se sirve bien caliente en plato hondo con unos poquitos croutons adornando', 'Biersuppe_202511120955296304.jpg', 1, '2025-11-12 20:55:29', '2025-11-12 20:55:29', 0),
(40, 'Pico de gallo', 'Es una mezcla fresca de verduras picadas, y su encanto está en la simplicidad y el equlibrio entre lo picante, ácido y lo crujiente, ideal para acompañar, tacos, carnes asadas, quesadilla o totopos.', 23, 3, 6, '00:30:00', NULL, 0, 141, 4, 1, 'Cortar los tomates, la cebolla y jalapeño en brunoise, y picar finamente el cilantro,\r\nMetemos estos ingredientes en un bol y añadimos zumo de limón ,si es verde, mejor, y la sal.\r\nMezclamos suavemete y dejamos reposar 10-15 minutos para que se integren los sabores.\r\nRectificamos de sal y limón, si es necesario.', 'En un cuenco adornado con unos trozos en cuartos de lima o limón, o le podemos añadir pepino o aguacate en cuadraditos en una versión más moderna.', 'Pico_202511121117113292.jpg', 1, '2025-11-12 22:17:11', '2025-11-12 22:17:11', 0),
(43, 'Bica blanca  o estilo Laza', 'Es un bizcocho tradicional gallego, que se caracteriza por su esponjosidad y color blanco', 23, 6, 8, '01:30:00', NULL, 13, 64, 1, 3, 'Montamos las claras con 430gr de azúcar a punto de nieve.\r\nDespués mezclaremos suavemente con la nata (35% grasa) semimontada.\r\nPor último agregamos la harina, poco a poco, tamizando y con cuidado de que no se baje la mezcla.\r\nIntroducimos en una bandeja de horno con papel sulfurizado y espolvoreamos bien de azúcar en grano por encima.\r\nHorneamos a 180ºC 10 minutos y después a 170ºC aproximadamente 50 minutos, o hasta que la brocheta salga limpia.\r\nEnfriar sobre rejilla, consumimos una vez fría', 'Cortar en trocitos para emplatar, con un sirope o sola\r\nademás de postre, puede servirse en un desayuno o merienda acompañando una bebida caliente tipo café, chocolate o una infusión', 'Bica_202511121144135279.jpg', 1, '2025-11-12 22:44:13', '2025-11-12 22:44:13', 0),
(45, 'Pan (receta básica)', 'Masa horneada compuesta básicamente por un cereal, agua y sal', 23, 13, 8, '03:00:00', NULL, 0, 0, 1, 3, 'Tasmizamos la harina con la sal en un bol grande, y disolvemos la levadura en agua templada.\r\nIncorporamos la levadura junto al agua fría a la harina\r\nMezclamos manualmente hasta conseguir una mezcla homogénea y amasamos hasta conseguir una masa elástica que se suelte de las manos.\r\nHacemos una bola y la depositamos en un recipiente enharinado. espolvoreamos con harina por encima y arropamos. Dejamos fermentar una hora en  lugar templado.\r\nPasado ese tiempo formateamos la masa, dándole el menor trabajo posible para evitar que las levaduras bajen.\r\nUna vez le damos la forma que le queremos, se deposita en papel sulfurizado y se espolvorea con harina. Le damos el mismo tiempo de reposo que la primera vez. \r\nUna vez reposado, se le da un corte en la superficie y se mete al horno 220ºC durante 1 hora si es para pan mollete, y 40 minutos si es para bollitos.', 'Troceado en un platito', 'Pan_202511131129281648.jpg', 1, '2025-11-13 10:29:28', '2025-11-13 10:29:28', 0),
(46, 'Aguacates rellenos de langostinos', 'Refrescante ensalada fácil de preparar con un toque picante', 23, 25, 4, '00:30:00', NULL, 0, 141, 4, 1, 'Pelamos y salpimentamos los langostinos salteamos en aceite. Picamos 8 en paisana fina , y dejamos 8 para el final.\r\nPicamos en brunoise la cebolla y mezclamos con los langostinos.\r\nAñadimos el chile chipotle a la mayonesa. y la incorporamos a la mezcla de langostinos con cebolla.\r\nPartimos los aguacates por la mitad, retiramos el hueso, y la carne que trocearemos y rellenamos junto a la mezcla anterior cada cáscara del aguacate.', 'Podemos presentar cada dos mitades con los langostinos enteros reservados encima y espolvoreado de cilantro, sobre una cama de lechuga.', 'Aguacates_202511130751164383.jpg', 1, '2025-11-13 18:51:16', '2025-11-13 18:51:16', 0),
(47, 'Albóndigas de pescado', 'Las albóndigas de pescado son una alternativa deliciosa y saludable que te permitirá disfrutar del sabor del mar en cada bocado.', 23, 2, 6, '01:00:00', NULL, 0, 0, 0, 3, '*Albóndigas: Machacar 1 diente de ajo con un poco de aceite  hasta conseguir una pasta.\r\nPicar el bacalao y el salmón sin piel ni espinas, muy fino a cuchillo. Sazonar con sal, la pasta de ajo y perejil.\r\nMezclar todos los ingredientes, formar albóndigas, enharinarlas y freírlas en aceite muy caliente, reservarlas\r\n\r\n*Salsa: Picar muy fino los tres dientes de ajo y se dispone en un rondón, con aceite, cayena picada y perejil se dora ligeramente y se añade la harina, removiéndo con espátula.\r\nSe añade el fumet y se deja reducir, removiendo par qeu no se formen grumos.\r\nA parte, se abren las almejas y se las incorpora a la salsa. \r\nSe añaden las albóndigas, se les da un hervor y se sirven', 'Emplatamos 5 o 6 albóndigas con almejas  y espolvoreado todo con perejil muy picado.\r\nPodemos acompañar con arroz blanco o un salteado de verduras, por ejemplo.', 'Albndigas_202511130853442671.jpg', 1, '2025-11-13 19:53:44', '2025-11-13 19:53:44', 0),
(48, 'Arroz con leche', 'Postre cremoso con arroz, leche, azúcar y aromatizado con canel y limón, su textura suave y dulzor delicado lo convierten en un clásico.', 23, 6, 8, '01:00:00', NULL, 0, 0, 0, 2, '*Aromas: Rama de vainilla o rama de canela con piel de naranja y limón, etc.\r\n\r\nSe lava el arroz en agua fría y se deposita en un caza con 150 ml de agua, cuando rompa el hervor, se le incorpora la leche y los aromas y se remueve bien. Se deja cocer a fuego muy suave, removiendo de vez en cuando para que no se agarre, unos 40 minutos..\r\nCuando el grano esté abierto, se retiran los aromas se incorpora la nata y un poco más de leche si vemos que nos queda muy espeso. Se remueve hasta punto de ebullición y se incorpora el azúcar. Se sigue removiendo hasta que el azúcar esté bien incorporado.', 'En copas individuales espolvoreado con canela y un hilito de zeste de limón adornando.', 'Arroz_202511130924359281.jpg', 1, '2025-11-13 20:24:35', '2025-11-13 20:24:35', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas_alergenos`
--

DROP TABLE IF EXISTS `recetas_alergenos`;
CREATE TABLE `recetas_alergenos` (
  `id_recetas_alergenos` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL,
  `id_alergeno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `recetas_alergenos`
--

TRUNCATE TABLE `recetas_alergenos`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas_estilos`
--

DROP TABLE IF EXISTS `recetas_estilos`;
CREATE TABLE `recetas_estilos` (
  `id_recetas_estilos` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL,
  `id_estilo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `recetas_estilos`
--

TRUNCATE TABLE `recetas_estilos`;
--
-- Volcado de datos para la tabla `recetas_estilos`
--

INSERT INTO `recetas_estilos` (`id_recetas_estilos`, `id_receta`, `id_estilo`) VALUES
(20, 36, 8),
(21, 37, 3),
(22, 39, 14),
(23, 40, 3),
(26, 43, 14),
(28, 45, 14),
(29, 46, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas_ingredientes`
--

DROP TABLE IF EXISTS `recetas_ingredientes`;
CREATE TABLE `recetas_ingredientes` (
  `id_recetas_ingredientes` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL,
  `id_ingrediente` int(11) NOT NULL,
  `cantidad` decimal(10,0) NOT NULL,
  `id_unidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `recetas_ingredientes`
--

TRUNCATE TABLE `recetas_ingredientes`;
--
-- Volcado de datos para la tabla `recetas_ingredientes`
--

INSERT INTO `recetas_ingredientes` (`id_recetas_ingredientes`, `id_receta`, `id_ingrediente`, `cantidad`, `id_unidad`) VALUES
(16, 36, 9, 10, 2),
(17, 36, 2, 1, 1),
(18, 36, 8, 50, 2),
(19, 36, 7, 1, 3),
(20, 36, 4, 4, 9),
(21, 36, 6, 5, 2),
(22, 36, 23, 100, 1),
(23, 37, 27, 4, 9),
(24, 37, 28, 1, 6),
(25, 37, 29, 2, 8),
(26, 37, 30, 4, 9),
(27, 37, 31, 300, 2),
(28, 37, 32, 200, 2),
(29, 37, 33, 2, 8),
(30, 37, 34, 2, 8),
(31, 37, 35, 4, 8),
(32, 37, 36, 4, 9),
(33, 37, 37, 200, 4),
(34, 37, 38, 200, 4),
(35, 37, 39, 2, 8),
(36, 37, 40, 2, 8),
(37, 38, 41, 2, 9),
(38, 38, 9, 150, 2),
(39, 38, 39, 60, 2),
(40, 38, 42, 2, 2),
(41, 38, 43, 120, 4),
(42, 38, 44, 2, 2),
(43, 38, 2, 200, 2),
(44, 38, 45, 0, 5),
(45, 39, 46, 1, 3),
(46, 39, 8, 50, 2),
(47, 39, 2, 100, 2),
(48, 39, 47, 150, 4),
(49, 39, 48, 2, 9),
(50, 39, 49, 8, 9),
(51, 39, 50, 1, 11),
(52, 39, 51, 1, 6),
(53, 39, 28, 1, 6),
(54, 39, 52, 1, 5),
(55, 40, 53, 3, 9),
(56, 40, 54, 1, 9),
(57, 40, 55, 2, 9),
(58, 40, 56, 0, 7),
(59, 40, 57, 1, 9),
(60, 40, 28, 1, 6),
(63, 43, 58, 330, 2),
(64, 43, 9, 530, 2),
(65, 43, 47, 240, 2),
(66, 43, 2, 240, 2),
(68, 45, 59, 1, 1),
(69, 45, 60, 25, 2),
(70, 45, 28, 15, 2),
(71, 45, 61, 500, 4),
(72, 45, 62, 150, 4),
(73, 46, 63, 4, 9),
(74, 46, 64, 16, 9),
(75, 46, 65, 1, 9),
(76, 46, 35, 1, 5),
(77, 46, 67, 1, 6),
(78, 46, 66, 1, 6),
(79, 46, 56, 1, 6),
(80, 46, 28, 1, 6),
(81, 46, 51, 1, 6),
(82, 47, 68, 250, 2),
(83, 47, 69, 250, 2),
(84, 47, 70, 50, 2),
(85, 47, 41, 2, 9),
(86, 47, 71, 4, 9),
(87, 47, 72, 1, 5),
(88, 47, 28, 1, 5),
(89, 47, 52, 1, 5),
(90, 47, 2, 10, 2),
(91, 47, 74, 200, 4),
(92, 47, 73, 100, 4),
(93, 47, 75, 100, 2),
(94, 47, 76, 200, 2),
(95, 47, 77, 1, 5),
(96, 48, 7, 1, 3),
(97, 48, 47, 100, 4),
(98, 48, 78, 80, 2),
(99, 48, 9, 100, 2),
(100, 48, 79, 1, 6),
(101, 48, 43, 150, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas_tecnicas`
--

DROP TABLE IF EXISTS `recetas_tecnicas`;
CREATE TABLE `recetas_tecnicas` (
  `id_recetas_tecnicas` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL,
  `id_tecnica` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `recetas_tecnicas`
--

TRUNCATE TABLE `recetas_tecnicas`;
--
-- Volcado de datos para la tabla `recetas_tecnicas`
--

INSERT INTO `recetas_tecnicas` (`id_recetas_tecnicas`, `id_receta`, `id_tecnica`) VALUES
(10, 36, 12),
(11, 37, 12),
(12, 38, 21),
(13, 39, 13),
(16, 43, 25),
(19, 45, 25),
(20, 46, 21),
(21, 47, 28),
(22, 48, 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas_tiposplato`
--

DROP TABLE IF EXISTS `recetas_tiposplato`;
CREATE TABLE `recetas_tiposplato` (
  `id_recetas_tiposplato` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `recetas_tiposplato`
--

TRUNCATE TABLE `recetas_tiposplato`;
--
-- Volcado de datos para la tabla `recetas_tiposplato`
--

INSERT INTO `recetas_tiposplato` (`id_recetas_tiposplato`, `id_receta`, `id_tipo`) VALUES
(21, 36, 1),
(23, 37, 7),
(24, 38, 10),
(25, 39, 3),
(26, 40, 11),
(29, 43, 4),
(32, 45, 12),
(33, 46, 3),
(34, 47, 3),
(35, 48, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas_utensilios`
--

DROP TABLE IF EXISTS `recetas_utensilios`;
CREATE TABLE `recetas_utensilios` (
  `id_recetas_utensilios` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL,
  `id_utensilio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `recetas_utensilios`
--

TRUNCATE TABLE `recetas_utensilios`;
--
-- Volcado de datos para la tabla `recetas_utensilios`
--

INSERT INTO `recetas_utensilios` (`id_recetas_utensilios`, `id_receta`, `id_utensilio`) VALUES
(11, 36, 1),
(12, 36, 4),
(13, 36, 6),
(14, 38, 163),
(15, 38, 164),
(16, 38, 165),
(17, 38, 166),
(18, 38, 167),
(19, 39, 163),
(21, 39, 166),
(20, 39, 168),
(24, 40, 169),
(22, 40, 170),
(23, 40, 171),
(29, 43, 1),
(30, 43, 165),
(31, 43, 167),
(32, 43, 172),
(33, 43, 173),
(34, 43, 174),
(40, 45, 167),
(39, 45, 172),
(41, 45, 174),
(38, 45, 175),
(42, 46, 166),
(43, 47, 166),
(44, 47, 178),
(45, 47, 180),
(47, 48, 180),
(46, 48, 181);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `redactores`
--

DROP TABLE IF EXISTS `redactores`;
CREATE TABLE `redactores` (
  `id_redactor` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `redactores`
--

TRUNCATE TABLE `redactores`;
--
-- Volcado de datos para la tabla `redactores`
--

INSERT INTO `redactores` (`id_redactor`, `id_usuario`) VALUES
(1, 1),
(4, 2),
(18, 3),
(26, 8),
(27, 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regiones`
--

DROP TABLE IF EXISTS `regiones`;
CREATE TABLE `regiones` (
  `id_region` int(11) NOT NULL,
  `id_pais` int(11) NOT NULL,
  `nombre_region` varchar(50) NOT NULL,
  `activo_region` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `regiones`
--

TRUNCATE TABLE `regiones`;
--
-- Volcado de datos para la tabla `regiones`
--

INSERT INTO `regiones` (`id_region`, `id_pais`, `nombre_region`, `activo_region`) VALUES
(0, 0, 'Sin definir', 0),
(1, 64, 'Andalucía', 0),
(2, 64, 'Aragón', 0),
(3, 64, 'Islas Baleares', 0),
(4, 64, 'Canarias', 0),
(5, 64, 'Cantabria', 0),
(6, 64, 'Castilla-La Mancha', 0),
(7, 64, 'Castilla y León', 0),
(8, 64, 'Cataluña', 0),
(9, 64, 'Comunidad de Madrid', 0),
(10, 64, 'Comunidad Foral de Navarra', 0),
(11, 64, 'Comunidad Valenciana', 0),
(12, 64, 'Extremadura', 0),
(13, 64, 'Galicia', 0),
(14, 64, 'País Vasco', 0),
(15, 64, 'Principado de Asturias', 0),
(16, 64, 'Región de Murcia', 0),
(17, 64, 'La Rioja', 0),
(18, 64, 'Ceuta', 0),
(19, 64, 'Melilla', 0),
(20, 182, 'Norte', 0),
(21, 182, 'Centro', 0),
(22, 182, 'Lisboa', 0),
(23, 182, 'Alentejo', 0),
(24, 182, 'Algarve', 0),
(25, 71, 'Gran Este', 0),
(26, 71, 'Nueva Aquitania', 0),
(27, 71, 'Auvernia-Ródano-Alpes', 0),
(28, 71, 'Borgoña-Franco-Condado', 0),
(29, 71, 'Bretaña', 0),
(30, 71, 'Centro-Val de Loira', 0),
(31, 71, 'Córcega', 0),
(32, 71, 'Isla de Francia', 0),
(33, 71, 'Occitania', 0),
(34, 71, 'Altos de Francia', 0),
(35, 71, 'Normandía', 0),
(36, 71, 'País del Loira', 0),
(37, 71, 'Provenza-Alpes-Costa Azul', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `revisores`
--

DROP TABLE IF EXISTS `revisores`;
CREATE TABLE `revisores` (
  `id_revisor` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `revisores`
--

TRUNCATE TABLE `revisores`;
--
-- Volcado de datos para la tabla `revisores`
--

INSERT INTO `revisores` (`id_revisor`, `id_usuario`) VALUES
(5, 1),
(6, 2),
(8, 5),
(9, 13),
(11, 19),
(10, 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tecnicas`
--

DROP TABLE IF EXISTS `tecnicas`;
CREATE TABLE `tecnicas` (
  `id_tecnica` int(11) NOT NULL,
  `nombre_tecnica` varchar(50) NOT NULL,
  `foto_tecnica` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `tecnicas`
--

TRUNCATE TABLE `tecnicas`;
--
-- Volcado de datos para la tabla `tecnicas`
--

INSERT INTO `tecnicas` (`id_tecnica`, `nombre_tecnica`, `foto_tecnica`) VALUES
(11, 'Papillote', 'Papillote_8681.jpg'),
(12, 'Freir', 'Fritos_3425.jpg'),
(13, 'Hervir', 'Hervir_3088.png'),
(17, 'Pochar o escalfar', NULL),
(18, 'Cocción al vapor', NULL),
(19, 'Cocción en olla a presión', NULL),
(20, 'Blanquear', NULL),
(21, 'Sofreir', NULL),
(22, 'Saltear', NULL),
(23, 'Dorar o gratinar', NULL),
(24, 'En parrilla', NULL),
(25, 'Al horno', NULL),
(26, 'Guisar', NULL),
(27, 'Estofar', NULL),
(28, 'Brasear', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_plato`
--

DROP TABLE IF EXISTS `tipos_plato`;
CREATE TABLE `tipos_plato` (
  `id_tipo` int(11) NOT NULL,
  `nombre_tipo` varchar(50) NOT NULL,
  `foto_tipo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `tipos_plato`
--

TRUNCATE TABLE `tipos_plato`;
--
-- Volcado de datos para la tabla `tipos_plato`
--

INSERT INTO `tipos_plato` (`id_tipo`, `nombre_tipo`, `foto_tipo`) VALUES
(1, 'Picoteo aperitivos entrantes...', 'aperitivos.jpg'),
(3, 'Primeros Platos', 'Primeros_Platos_7868.jpg'),
(4, 'Postres', 'Postres_5632.jpg'),
(7, 'Segundos platos', 'Segundos_platos_2673.jpg'),
(10, 'Desayunos y meriendas', NULL),
(11, 'Guarniciones', NULL),
(12, 'Acompañamientos', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades_medida`
--

DROP TABLE IF EXISTS `unidades_medida`;
CREATE TABLE `unidades_medida` (
  `id_unidad` int(11) NOT NULL,
  `nombre_unidad` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `unidades_medida`
--

TRUNCATE TABLE `unidades_medida`;
--
-- Volcado de datos para la tabla `unidades_medida`
--

INSERT INTO `unidades_medida` (`id_unidad`, `nombre_unidad`) VALUES
(1, 'Kg.'),
(2, 'gr.'),
(3, 'l.'),
(4, 'ml.'),
(5, 'c/s'),
(6, 'al gusto'),
(7, 'taza'),
(8, 'cucharada'),
(9, 'ud.'),
(10, 'cucharadita'),
(11, 'pizca');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `ap1_usuario` varchar(50) NOT NULL,
  `ap2_usuario` varchar(50) DEFAULT NULL,
  `login_usuario` varchar(15) NOT NULL,
  `clave_usuario` varchar(100) NOT NULL,
  `email_usuario` varchar(50) NOT NULL,
  `foto_usuario` varchar(255) DEFAULT NULL,
  `sobre_usuario` text DEFAULT NULL,
  `creado_usuario` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_usuario` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `usuarios`
--

TRUNCATE TABLE `usuarios`;
--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `ap1_usuario`, `ap2_usuario`, `login_usuario`, `clave_usuario`, `email_usuario`, `foto_usuario`, `sobre_usuario`, `creado_usuario`, `actualizado_usuario`) VALUES
(1, 'José Manuel', 'Abelleira', 'López', 'pepe', '$2y$10$f2/F0rDKighrCLIke0NnD.HV5LSJoMEro7cx/p8hqURUCMwWtzKQy', 'elpatonegro@live.com', 'pepe_30.jpg', NULL, '2025-10-09 18:08:24', '2025-11-10 12:01:44'),
(2, 'Juanito', 'Donald', 'Trump', 'juanito', '$2y$10$cI8/W6JquWMa0.GRO7hUyOWKQAATeBqSsbiU7z0ASr7SJXrZUgXoO', 'juanito@juanito.es', 'juanito_58.jpg', 'Premio Chuletón de Hormiga 2.024. Galardonado con la Filloa de Oro en la décimo quinta Feira da Empanada de Leiloio.', '2025-10-09 18:08:24', '2025-10-19 09:46:45'),
(3, 'Jorgito', 'Donald', 'Trump', 'jorgito', '$2y$10$Wg2zQZd5Agaqx.HSVzgms.6TzAfgyPgLf4dD3I5WfG1lEfyM98Uwi', 'jorgito@jorgito.es', 'jorgito_55.png', NULL, '2025-01-09 19:08:24', '2025-10-18 19:47:08'),
(5, 'Juan Manuel', 'Pérez', 'Vázquez', 'juanma', '$2y$10$rJZ4px9J0WCEo3vH5rY7LeU.FFCOgoZWmykAYvjinIUx8XAKk9966', 'juanma@juanma.es', '', 'Freganchín en Pensión Pepita. No ha ganado nada, pero interés le pone y la comida está buena.', '2025-10-09 18:08:24', '2025-10-09 18:57:43'),
(6, 'Nestor', 'Tilla', 'Paisana', 'nestor', '$2y$10$wpwZfw8ld7lrIgKic0YC5uesujtNhhscMBA33cF95f1mxTTRQKmEK', 'nestor@nestor.es', '', NULL, '2025-10-09 18:08:24', '2025-10-09 18:57:43'),
(8, 'Gilito', 'Tio', 'de Donald Duck', 'gilito', '$2y$10$/khnLb0FfImjThFxiStGZuc9Vp78WIDUKR09NV5d6KUF.ICd6kRiq', 'gilito@tiogilito.es', 'gilito_38.jpg', NULL, '2025-10-09 18:08:24', '2025-10-19 09:45:16'),
(13, 'Daysy', 'Donald', 'Trump', 'daysy', '$2y$10$/1xNGm5nSS9CZjPC4WUo6.1.wHNgde5E/9ARvcIQdte25C.AbgeY.', 'daysy@daysy.es', 'daysy_14.jpg', 'Jefa de cocina del restaurante Golfos Apandadores. 1º premio Cocineros sin Fronteras.', '2025-10-09 18:08:24', '2025-10-19 09:58:47'),
(14, 'Golfo', 'Apandador', '', 'golfo', '$2y$10$m/s/mNVa6T75INJFoRIElu5Fsa.gexrvFf9kWv3vkf8.ox2LMwoJ2', 'golfo@apandadores.es', 'golfo_92.png', '', '2025-10-09 18:08:24', '2025-10-19 10:06:43'),
(19, 'Wile E', 'Coyote', 'Express', 'coyote', '$2y$10$gHukJqNU3UJTmGM0PkKvYOIU/z9cjyiCKFMvu9V2VEGmo9ZAY80U6', 'wile.e.coyote@coyote.es', 'coyote_8514.jpg', 'Persigo al correcaminos pero siempre se me escapa', '2025-10-16 20:08:56', '2025-10-18 18:23:18'),
(21, 'Road', 'Runner', '', 'correcaminos', '$2y$10$AE5HvOZV8ZuY5J8Y.KLnDuNo1u.qzEZ.IUUT/RgRfB4uL7R3CMpgi', 'roadrunner@correcaminos.es', 'correcaminos_6221.jpg', 'El coyote me quiere pillar, pero corro más que él.', '2025-10-20 17:57:19', '2025-10-20 17:57:19'),
(23, 'Loly', 'soto', 'Roca', 'Soto', '$2y$10$cPl1jtqs0dccTjzIjulxnu6Plt/Zs8lFcwefSKKDlk2kuhQlHEq3i', 'lolysotor@gmail.com', 'Soto_34.jpg', '', '2025-10-26 10:50:55', '2025-10-26 20:44:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `utensilios`
--

DROP TABLE IF EXISTS `utensilios`;
CREATE TABLE `utensilios` (
  `id_utensilio` int(11) NOT NULL,
  `nombre_utensilio` varchar(80) NOT NULL,
  `foto_utensilio` varchar(100) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `utensilios`
--

TRUNCATE TABLE `utensilios`;
--
-- Volcado de datos para la tabla `utensilios`
--

INSERT INTO `utensilios` (`id_utensilio`, `nombre_utensilio`, `foto_utensilio`, `activo`) VALUES
(1, 'Kitchen Aid', 'Kitchen_Aid_5407.jpg', 1),
(2, 'Sous Vide', 'Sous_Vide_6223.png', 1),
(4, 'Pasapurés', 'Colador_470.jpg', 1),
(5, 'Olla Express', 'Olla_Express_3483.jpg', 1),
(6, 'Thermomix', 'Thermomix_2984.jpg', 1),
(148, 'Cuchara de madera', 'Cuchara_de_madera_5105.jpg', 1),
(149, 'Cucharilla de café', 'Cucharilla_de_postre_9316.jpg', 1),
(163, 'Varillas', NULL, 1),
(164, 'Colador', NULL, 1),
(165, 'Lengua de silicona', NULL, 1),
(166, 'Sartén', NULL, 1),
(167, 'Papel de horno', NULL, 1),
(168, 'Olla', NULL, 1),
(169, 'Tabla de corte', NULL, 1),
(170, 'Cuchillo cebollero', NULL, 1),
(171, 'Bol pequeño', NULL, 1),
(172, 'Bandeja de horno', NULL, 1),
(173, 'Rejilla', NULL, 1),
(174, 'Tamiz', NULL, 1),
(175, 'Bol grande', NULL, 1),
(176, 'Cuerna', NULL, 1),
(177, 'Sauté', NULL, 1),
(178, 'Rondón', NULL, 1),
(179, 'Marmita', NULL, 1),
(180, 'Espátula', NULL, 1),
(181, 'Cazo', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zonas`
--

DROP TABLE IF EXISTS `zonas`;
CREATE TABLE `zonas` (
  `id_zona` int(11) NOT NULL,
  `nombre_zona` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Truncar tablas antes de insertar `zonas`
--

TRUNCATE TABLE `zonas`;
--
-- Volcado de datos para la tabla `zonas`
--

INSERT INTO `zonas` (`id_zona`, `nombre_zona`) VALUES
(3, 'África'),
(4, 'América'),
(5, 'Antártida'),
(2, 'Asia'),
(6, 'Australia y Oceanía'),
(1, 'Europa'),
(0, 'No definida');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id_administrador`),
  ADD UNIQUE KEY `USUARIOS_ADMINISTRADORES` (`id_usuario`);

--
-- Indices de la tabla `alergenos`
--
ALTER TABLE `alergenos`
  ADD PRIMARY KEY (`id_alergeno`);

--
-- Indices de la tabla `autores`
--
ALTER TABLE `autores`
  ADD PRIMARY KEY (`id_autor`),
  ADD UNIQUE KEY `nombre_autor` (`nombre_autor`),
  ADD KEY `id_pais` (`id_pais`);

--
-- Indices de la tabla `editores`
--
ALTER TABLE `editores`
  ADD PRIMARY KEY (`id_editor`),
  ADD KEY `editores_ibfk_1` (`id_usuario`);

--
-- Indices de la tabla `estilos_cocina`
--
ALTER TABLE `estilos_cocina`
  ADD PRIMARY KEY (`id_estilo`);

--
-- Indices de la tabla `favoritas`
--
ALTER TABLE `favoritas`
  ADD PRIMARY KEY (`id_favoritas`),
  ADD UNIQUE KEY `usuario_receta` (`id_usuario`,`id_receta`) USING BTREE,
  ADD KEY `id_receta` (`id_receta`);

--
-- Indices de la tabla `grupos_plato`
--
ALTER TABLE `grupos_plato`
  ADD PRIMARY KEY (`id_grupo`);

--
-- Indices de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD PRIMARY KEY (`id_ingrediente`);

--
-- Indices de la tabla `ingredientes_alergenos`
--
ALTER TABLE `ingredientes_alergenos`
  ADD PRIMARY KEY (`id_ing_ale`),
  ADD UNIQUE KEY `ingrediente_alergeno` (`id_ingrediente`,`id_alergeno`),
  ADD KEY `id_alergeno` (`id_alergeno`);

--
-- Indices de la tabla `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`id_pais`),
  ADD UNIQUE KEY `esp_pais` (`esp_pais`),
  ADD UNIQUE KEY `eng_pais` (`eng_pais`),
  ADD UNIQUE KEY `iso2_pais` (`iso2_pais`),
  ADD UNIQUE KEY `iso3_pais` (`iso3_pais`),
  ADD UNIQUE KEY `fra_pais` (`fra_pais`),
  ADD KEY `PAISES_ZONAS` (`id_zona`);

--
-- Indices de la tabla `propias`
--
ALTER TABLE `propias`
  ADD PRIMARY KEY (`id_propias`),
  ADD UNIQUE KEY `usuario_receta` (`id_usuario`,`id_receta`),
  ADD KEY `id_receta` (`id_receta`);

--
-- Indices de la tabla `recetas`
--
ALTER TABLE `recetas`
  ADD PRIMARY KEY (`id_receta`),
  ADD KEY `id_zona` (`id_zona`),
  ADD KEY `id_pais` (`id_pais`),
  ADD KEY `id_region` (`id_region`),
  ADD KEY `id_autor` (`id_autor`),
  ADD KEY `id_grupo` (`id_grupo`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `recetas_alergenos`
--
ALTER TABLE `recetas_alergenos`
  ADD PRIMARY KEY (`id_recetas_alergenos`) USING BTREE,
  ADD UNIQUE KEY `receta_alergeno` (`id_receta`,`id_alergeno`),
  ADD KEY `recetas_alergenos_ibfk_1` (`id_alergeno`);

--
-- Indices de la tabla `recetas_estilos`
--
ALTER TABLE `recetas_estilos`
  ADD PRIMARY KEY (`id_recetas_estilos`),
  ADD KEY `recetas_estilos_ibfk_2` (`id_estilo`),
  ADD KEY `recetas_estilos_ibfk_1` (`id_receta`);

--
-- Indices de la tabla `recetas_ingredientes`
--
ALTER TABLE `recetas_ingredientes`
  ADD PRIMARY KEY (`id_recetas_ingredientes`),
  ADD UNIQUE KEY `recetas_ingredientes` (`id_receta`,`id_ingrediente`),
  ADD KEY `id_ingrediente` (`id_ingrediente`),
  ADD KEY `recetas_ingredientes_ibfk_3` (`id_unidad`);

--
-- Indices de la tabla `recetas_tecnicas`
--
ALTER TABLE `recetas_tecnicas`
  ADD PRIMARY KEY (`id_recetas_tecnicas`),
  ADD UNIQUE KEY `id_receta` (`id_receta`,`id_tecnica`) USING BTREE,
  ADD KEY `id_tecnica` (`id_tecnica`);

--
-- Indices de la tabla `recetas_tiposplato`
--
ALTER TABLE `recetas_tiposplato`
  ADD PRIMARY KEY (`id_recetas_tiposplato`),
  ADD UNIQUE KEY `recetas_tiposplato` (`id_receta`,`id_tipo`),
  ADD KEY `id_tipo` (`id_tipo`);

--
-- Indices de la tabla `recetas_utensilios`
--
ALTER TABLE `recetas_utensilios`
  ADD PRIMARY KEY (`id_recetas_utensilios`),
  ADD UNIQUE KEY `receta_utensilio` (`id_receta`,`id_utensilio`),
  ADD KEY `recetas_utensilios_ibfk_2` (`id_utensilio`);

--
-- Indices de la tabla `redactores`
--
ALTER TABLE `redactores`
  ADD PRIMARY KEY (`id_redactor`),
  ADD UNIQUE KEY `REDACTOR_USUARIO` (`id_usuario`);

--
-- Indices de la tabla `regiones`
--
ALTER TABLE `regiones`
  ADD PRIMARY KEY (`id_region`),
  ADD UNIQUE KEY `nombre_region` (`nombre_region`),
  ADD KEY `REGIONES_PAISES` (`id_pais`);

--
-- Indices de la tabla `revisores`
--
ALTER TABLE `revisores`
  ADD PRIMARY KEY (`id_revisor`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `tecnicas`
--
ALTER TABLE `tecnicas`
  ADD PRIMARY KEY (`id_tecnica`);

--
-- Indices de la tabla `tipos_plato`
--
ALTER TABLE `tipos_plato`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `unidades_medida`
--
ALTER TABLE `unidades_medida`
  ADD PRIMARY KEY (`id_unidad`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `utensilios`
--
ALTER TABLE `utensilios`
  ADD PRIMARY KEY (`id_utensilio`);

--
-- Indices de la tabla `zonas`
--
ALTER TABLE `zonas`
  ADD PRIMARY KEY (`id_zona`),
  ADD UNIQUE KEY `nombre_zona` (`nombre_zona`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id_administrador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `alergenos`
--
ALTER TABLE `alergenos`
  MODIFY `id_alergeno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `autores`
--
ALTER TABLE `autores`
  MODIFY `id_autor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `editores`
--
ALTER TABLE `editores`
  MODIFY `id_editor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estilos_cocina`
--
ALTER TABLE `estilos_cocina`
  MODIFY `id_estilo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `favoritas`
--
ALTER TABLE `favoritas`
  MODIFY `id_favoritas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grupos_plato`
--
ALTER TABLE `grupos_plato`
  MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  MODIFY `id_ingrediente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT de la tabla `ingredientes_alergenos`
--
ALTER TABLE `ingredientes_alergenos`
  MODIFY `id_ing_ale` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `paises`
--
ALTER TABLE `paises`
  MODIFY `id_pais` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT de la tabla `propias`
--
ALTER TABLE `propias`
  MODIFY `id_propias` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recetas`
--
ALTER TABLE `recetas`
  MODIFY `id_receta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `recetas_alergenos`
--
ALTER TABLE `recetas_alergenos`
  MODIFY `id_recetas_alergenos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recetas_estilos`
--
ALTER TABLE `recetas_estilos`
  MODIFY `id_recetas_estilos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `recetas_ingredientes`
--
ALTER TABLE `recetas_ingredientes`
  MODIFY `id_recetas_ingredientes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT de la tabla `recetas_tecnicas`
--
ALTER TABLE `recetas_tecnicas`
  MODIFY `id_recetas_tecnicas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `recetas_tiposplato`
--
ALTER TABLE `recetas_tiposplato`
  MODIFY `id_recetas_tiposplato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `recetas_utensilios`
--
ALTER TABLE `recetas_utensilios`
  MODIFY `id_recetas_utensilios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `redactores`
--
ALTER TABLE `redactores`
  MODIFY `id_redactor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `regiones`
--
ALTER TABLE `regiones`
  MODIFY `id_region` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `revisores`
--
ALTER TABLE `revisores`
  MODIFY `id_revisor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tecnicas`
--
ALTER TABLE `tecnicas`
  MODIFY `id_tecnica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `tipos_plato`
--
ALTER TABLE `tipos_plato`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `unidades_medida`
--
ALTER TABLE `unidades_medida`
  MODIFY `id_unidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `utensilios`
--
ALTER TABLE `utensilios`
  MODIFY `id_utensilio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT de la tabla `zonas`
--
ALTER TABLE `zonas`
  MODIFY `id_zona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD CONSTRAINT `administradores_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `autores`
--
ALTER TABLE `autores`
  ADD CONSTRAINT `AUTORES_PAISES` FOREIGN KEY (`id_pais`) REFERENCES `paises` (`id_pais`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `editores`
--
ALTER TABLE `editores`
  ADD CONSTRAINT `editores_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `favoritas`
--
ALTER TABLE `favoritas`
  ADD CONSTRAINT `favoritas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `favoritas_ibfk_2` FOREIGN KEY (`id_receta`) REFERENCES `recetas` (`id_receta`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ingredientes_alergenos`
--
ALTER TABLE `ingredientes_alergenos`
  ADD CONSTRAINT `ingredientes_alergenos_ibfk_1` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingredientes` (`id_ingrediente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ingredientes_alergenos_ibfk_2` FOREIGN KEY (`id_alergeno`) REFERENCES `alergenos` (`id_alergeno`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `paises`
--
ALTER TABLE `paises`
  ADD CONSTRAINT `PAISES_ZONAS` FOREIGN KEY (`id_zona`) REFERENCES `zonas` (`id_zona`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `propias`
--
ALTER TABLE `propias`
  ADD CONSTRAINT `propias_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `propias_ibfk_2` FOREIGN KEY (`id_receta`) REFERENCES `recetas` (`id_receta`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `recetas`
--
ALTER TABLE `recetas`
  ADD CONSTRAINT `recetas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `recetas_ibfk_2` FOREIGN KEY (`id_zona`) REFERENCES `zonas` (`id_zona`) ON UPDATE CASCADE,
  ADD CONSTRAINT `recetas_ibfk_3` FOREIGN KEY (`id_pais`) REFERENCES `paises` (`id_pais`) ON UPDATE CASCADE,
  ADD CONSTRAINT `recetas_ibfk_4` FOREIGN KEY (`id_region`) REFERENCES `regiones` (`id_region`) ON UPDATE CASCADE,
  ADD CONSTRAINT `recetas_ibfk_5` FOREIGN KEY (`id_autor`) REFERENCES `autores` (`id_autor`) ON UPDATE CASCADE,
  ADD CONSTRAINT `recetas_ibfk_6` FOREIGN KEY (`id_grupo`) REFERENCES `grupos_plato` (`id_grupo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `recetas_alergenos`
--
ALTER TABLE `recetas_alergenos`
  ADD CONSTRAINT `recetas_alergenos_ibfk_1` FOREIGN KEY (`id_alergeno`) REFERENCES `alergenos` (`id_alergeno`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recetas_alergenos_ibfk_2` FOREIGN KEY (`id_receta`) REFERENCES `recetas` (`id_receta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `recetas_estilos`
--
ALTER TABLE `recetas_estilos`
  ADD CONSTRAINT `recetas_estilos_ibfk_1` FOREIGN KEY (`id_receta`) REFERENCES `recetas` (`id_receta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recetas_estilos_ibfk_2` FOREIGN KEY (`id_estilo`) REFERENCES `estilos_cocina` (`id_estilo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `recetas_ingredientes`
--
ALTER TABLE `recetas_ingredientes`
  ADD CONSTRAINT `recetas_ingredientes_ibfk_1` FOREIGN KEY (`id_receta`) REFERENCES `recetas` (`id_receta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recetas_ingredientes_ibfk_2` FOREIGN KEY (`id_ingrediente`) REFERENCES `ingredientes` (`id_ingrediente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recetas_ingredientes_ibfk_3` FOREIGN KEY (`id_unidad`) REFERENCES `unidades_medida` (`id_unidad`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `recetas_tecnicas`
--
ALTER TABLE `recetas_tecnicas`
  ADD CONSTRAINT `recetas_tecnicas_ibfk_1` FOREIGN KEY (`id_tecnica`) REFERENCES `tecnicas` (`id_tecnica`) ON UPDATE CASCADE,
  ADD CONSTRAINT `recetas_tecnicas_ibfk_2` FOREIGN KEY (`id_receta`) REFERENCES `recetas` (`id_receta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `recetas_tiposplato`
--
ALTER TABLE `recetas_tiposplato`
  ADD CONSTRAINT `recetas_tiposplato_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipos_plato` (`id_tipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recetas_tiposplato_ibfk_2` FOREIGN KEY (`id_receta`) REFERENCES `recetas` (`id_receta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `recetas_utensilios`
--
ALTER TABLE `recetas_utensilios`
  ADD CONSTRAINT `recetas_utensilios_ibfk_1` FOREIGN KEY (`id_receta`) REFERENCES `recetas` (`id_receta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recetas_utensilios_ibfk_2` FOREIGN KEY (`id_utensilio`) REFERENCES `utensilios` (`id_utensilio`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `redactores`
--
ALTER TABLE `redactores`
  ADD CONSTRAINT `redactores_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `regiones`
--
ALTER TABLE `regiones`
  ADD CONSTRAINT `REGIONES_PAISES` FOREIGN KEY (`id_pais`) REFERENCES `paises` (`id_pais`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `revisores`
--
ALTER TABLE `revisores`
  ADD CONSTRAINT `revisores_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
