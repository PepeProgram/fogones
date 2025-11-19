-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 19-11-2025 a las 23:47:57
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
(1, 'Mediterránea', 'Mediterrnea_8037.png'),
(3, 'Internacional', 'Internacional_8719.jpg'),
(4, 'Molecular', 'Molecular_6892.jpg'),
(8, 'De Autor', 'De_Autor_5595.jpg'),
(9, 'Vegana', 'Vegana_9402.jpg'),
(10, 'Bio', 'Bio_8974.jpg'),
(11, 'Sin Gluten', 'Sin_Gluten_6070.jpg'),
(12, 'Sin Lactosa', 'Sin_Lactosa_6174.jpg'),
(13, 'Vegetariana', 'Vegetariana_9459.jpg'),
(14, 'Tradicional', 'Tradicional_4056.jpg'),
(15, 'Erótica', 'Ertica_6985.jpg'),
(16, 'Cumpleaños y aniversarios', 'Cumpleaos_y_aniversarios_8159.jpg'),
(17, 'Navidad', 'Navidad_1119.jpg'),
(18, 'Semana Santa', 'Semana_Santa_352.jpg'),
(19, 'Halloween', 'Halloween_5022.jpg'),
(20, 'Carnavales', 'Carnavales_5594.jpg');

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
(15, 'Arroz legumbres y cereales', 'Arroz_legumbres_y_cereales_2945.jpg'),
(16, 'Bebidas', 'Bebidas_5515.jpg'),
(17, 'Lácteos y huevos', 'Lcteos_y_huevos_738.jpg'),
(18, 'Pasta y pizza', 'Pasta_y_pizza_4396.jpg'),
(19, 'Sopas y cremas', 'Sopas_y_cremas_6922.jpg'),
(25, 'Ensaladas', 'Ensaladas_1950.jpg');

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
(7, 'Leche', 1),
(8, 'Mantequilla', 1),
(9, 'Azúcar blanco', 1),
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
(38, 'Vinagre balsámico', 1),
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
(79, 'Aromas (ver en receta)', 1),
(80, 'Trucha', 1),
(81, 'Pimentón dulce', 1),
(82, 'Pimiento verde', 1),
(83, 'Pimiento rojo', 1),
(84, 'Miga de pan', 1),
(85, 'Uva blanca', 1),
(86, 'Vinagre blanco', 1),
(87, 'Ajo diente', 1),
(88, 'Azafrán', 1),
(89, 'Caldo de pollo', 1),
(90, 'Conejo', 1),
(91, 'Pollo', 1),
(92, 'Judias verdes', 1),
(94, 'Rama romero', 1),
(95, 'Mero', 1),
(96, 'Manzana', 1),
(97, 'Ácido cítrico', 1),
(98, 'Ortiguillas anémona marina', 1),
(99, 'Lima', 1),
(100, 'Vinagre de jerez', 1),
(101, 'Jengibre', 1),
(102, 'Xantana', 1),
(103, 'Frutos rojos', 1),
(104, 'Chocolate blanco', 1),
(105, 'Nuez moscada', 1),
(106, 'Jamón serrano', 1),
(107, 'Alga nori', 1),
(108, 'Huevas de salmón', 1),
(109, 'Sal en escamas', 1),
(110, 'Centolla', 1),
(111, 'Puerro', 1),
(112, 'Brandy', 1),
(113, 'Rape', 1),
(114, 'Laurel', 1),
(115, 'Lomo de buey', 1),
(116, 'Mostaza en polvo', 1),
(117, 'Patatas', 1),
(118, 'Vino tinto', 1),
(119, 'Brécol', 1),
(120, 'Picantones', 1),
(121, 'Pimienta blanca', 1),
(122, 'Pasas', 1),
(123, 'Caldo de carne', 1),
(124, 'Almíbar', 1),
(125, 'Piña', 1),
(126, 'Puré de castaña', 1),
(127, 'Calabaza', 1),
(128, 'Nuez', 1),
(129, 'Harina de espelta', 1),
(130, 'Azúcar moreno', 1),
(131, 'Ajo en polvo', 1),
(132, 'Arroz Basmati', 1);

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
(39, 76, 14),
(47, 80, 5),
(48, 84, 3),
(49, 86, 12),
(51, 95, 5),
(52, 98, 14),
(53, 100, 12),
(54, 105, 8),
(55, 107, 1),
(56, 107, 14),
(57, 108, 5),
(59, 110, 1),
(58, 112, 12),
(60, 113, 5),
(61, 116, 10),
(62, 118, 12),
(63, 126, 8),
(64, 128, 8);

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
(36, 'Bolovanes rellenos', 'Bolovanes salados rellenos de sardinas, atún, paté, etc.', 1, 1, 4, '00:45:00', NULL, 0, 160, 3, 2, 'Juntamos todo excepto las sardinas en la kitchen aid:\r\nMezclamos hasta que quede todo como una pasta asquerosa.\r\nFreimos las sardinas en abundante aceite caliente.\r\nEstiramos la masa y la moldeamos formando vasitos, que hornearemos hasta que aparezcan churruscaditos.\r\nColocamos cada sardina en un vasito, dejando asomar la cola por arriba para que parezca que se están ahogando.', 'Todos juntitos en una bandeja cuadrada y los espolvoreamos con abundante farlopa colombiana.', 'Bolovanes_202511100809491167.jpg', 1, '2025-11-10 19:09:49', '2025-11-19 22:39:28', 1),
(37, 'Pechuga de pato con verduras', 'Es un plato perfecto para ocasiones especiales, equilibra la intensidad de la carne  con la frescura de las verduaras y la salsa agridulce.', 1, 1, 4, '01:20:00', NULL, 0, 0, 1, 3, '* Para el puré de zanahoria caramelizada:\r\n    1.- Pelamos las zanahorias, las cortamos longitudinalmente y retiramos la parte central, que es menos dulce.\r\n    2.- Troceamos en piezas pequeñas y las añadimos a un cazo con la mantequilla deretida.\r\n    3.- Incorporamos un chorrito de agua y cocinamos a fuego suave durante unos 20 minutos, hasta que estén tiernas y ligeramente caramelizadas.\r\n    4.- Trituramos hasta obtener un puré fino y lo pasamos por un colador para lograr una textura más lisa y sedosa.\r\n\r\n* Para la salsa de naranja:\r\n    5.- En un cazo ponemos el zumo de naranja, la soja, el vinagre, la miel y una pizca de sal. Calentamos a fuego medio, removiendo de vez en cuando hasta que reduzca.\r\n    6.- Añadimos la maicena disuelta y cocinamos 2-3 minutos más hasta espesar.\r\n\r\n* Para la guarnición:\r\n    7.- Cortamos los brócolis en pequeños trozos y las zanahorias en trozos medianos.\r\n    8.- En una sartén con aceite de oliva, rehogamos las verduras con una pizca de sal, tomillo y romero. Cocinamos a fuego medio-bajo hasta que estén tiernas pero ligeramente al dente.\r\n    9.- Por otro lado salteamos las setas en una sartén. Reservamos para usarlas como base de nuestro pato.\r\n    10.- Reservamos las verduras calientes para emplatar.\r\n\r\n* Para la carne:\r\n    11.- Limpiamos los magrets retirando restos de grasa o plumas.\r\n    12.- Hacemos cortes superficiales en la piel en forma de rombos sin llegar a la carne. Sazonamos con sal y pimienta.\r\n    13.- Cocinamos en una sartén sin aceite, primero por el lado de la piel hasta que suelte la grasa y quede dorada, luego damos la vuelta y cocinamos 2-3 minutos más.\r\n    14.- Retiramos, dejamos reposar 2 minutos y cortamos en rodajas.', 'En una bandeja ovalada, colocamos las rodajas de pato un poco montadas, con  salsa en un lado y unas verduras salteadas al otro.', 'Pechuga_202511110141257051.png', 1, '2025-11-18 12:14:33', '2025-11-19 21:02:05', 1),
(38, 'Doriyakis', 'Tortitas muy esponjosas japonesas emparejadas a modo de sandwich con algún relleno en medio de mermelada, crema,  dulce de leche, etc...', 23, 6, 6, '00:45:00', NULL, 0, 124, 2, 2, 'Abizcochar los huevos con el azúcar, añadir la miel y continuar batiendo.\r\nDiluir el bicarbonato en el agua e incorporarlo a la masa. Mezclarlo bien.\r\nTamizar la harina con la levadura y añadir poco a poco a la masa, sin dejar de mezclar para que no queden grumos.\r\nPintar una sartén con aceite de girasol y, cuando esté bien caliente, añadir 2-3 cucharadas soperas de masa en el centro. Cocinar unos minutos, hasta que la superficie se llene de burbujas. La parte inferior debería estar bien dorada. Dar la vuelta con cuidado  y esperar a que se dore por la otra cara. Sacar a una bandeja con papel de horno para que no se pegue.\r\nCuando estén frias, emparejar las tortas de dos en dos, poniendo juntas las que más se parezcan por su forma. Untar con el relleno elegido la mitad y cierra con sus respectivas parejas, formando sandwiches.', 'En platitos individuales, acompañada de nata montada, fruta fresca, sirope....', 'Doriyakis_202511170743548061.jpg', 1, '2025-11-18 11:48:08', '2025-11-18 11:48:08', 1),
(39, 'Biersuppe', 'Reconfortante sopa cremosa elaborada con cerveza originaria de Baviera', 23, 19, 6, '00:30:00', NULL, 0, 3, 1, 2, '*Croutons: Cortar las rebanadas de pan, si son del día anterior mejor, en cuadraditos de uno o dos centímetros y freír en abundante aceite de oliva suave. \r\n\r\n    *Sopa: Fundir la mantequilla en una olla a fuego suave. Cuando esté líquida se incorpora la harina y se remueve hasta que se haya tostado ligeramente incorporar la cerveza. Se deja hervir a fuego lento, sin dejar de remover durante unos 20 min. y, a continuación, se salpimenta y, opcionalmente, se añade la canela. Se retira del fuego, se baten las yemas con la nata líquida y se incorporan a la sopa caliente cuando ya no esté hirviendo. Se vuelve a poner el conjunto a fuego bajo durante unos cinco minutos.', 'Se sirve bien caliente en plato hondo con unos poquitos croutons adornando', 'Biersuppe_202511120955296304.jpg', 1, '2025-11-18 11:43:04', '2025-11-18 11:43:04', 1),
(40, 'Pico de gallo', 'Es una mezcla fresca de verduras picadas, y su encanto está en la simplicidad y el equlibrio entre lo picante, ácido y lo crujiente, ideal para acompañar, tacos, carnes asadas, quesadilla o totopos.', 23, 3, 6, '00:30:00', NULL, 0, 141, 4, 1, 'Cortar los tomates, la cebolla y jalapeño en brunoise, y picar finamente el cilantro,\r\nMetemos estos ingredientes en un bol y añadimos zumo de limón ,si es verde, mejor, y la sal.\r\nMezclamos suavemete y dejamos reposar 10-15 minutos para que se integren los sabores.\r\nRectificamos de sal y limón, si es necesario.\r\nSi queremos un pico de gallo más suave podemos utilizar cebolla morada en vez de blanca, además de la un poco más de contraste visual al plato, en algunas zonas del sur méxico es  más típica esta cebolla.', 'En un cuenco adornado con unos trozos en cuartos de lima o limón, o le podemos añadir pepino o aguacate en cuadraditos en una versión más moderna.', 'Pico_202511121117113292.jpg', 1, '2025-11-18 11:59:10', '2025-11-18 11:59:10', 1),
(43, 'Bica blanca  o estilo Laza', 'Es un bizcocho tradicional gallego, que se caracteriza por no llevar levadura, lo que le confiere una textura diferente del bizcocho convecional.', 23, 6, 8, '01:30:00', NULL, 0, 64, 1, 3, 'Montamos las claras con 430gr de azúcar a punto de nieve.\r\nDespués mezclaremos suavemente con la nata (35% grasa) semimontada.\r\nPor último agregamos la harina, poco a poco, tamizando y con cuidado de que no se baje la mezcla.\r\nIntroducimos en una bandeja de horno con papel sulfurizado y espolvoreamos bien de azúcar en grano por encima.\r\nHorneamos a 180ºC 10 minutos y después a 170ºC aproximadamente 50 minutos, o hasta que la brocheta salga limpia.\r\nEnfriar sobre rejilla, consumimos una vez fría', 'Cortar en trocitos para emplatar, con un sirope o sola\r\nademás de postre, puede servirse en un desayuno o merienda acompañando una bebida caliente tipo café, chocolate o una infusión', 'Bica_202511121144135279.jpg', 1, '2025-11-18 11:55:22', '2025-11-18 11:55:22', 1),
(45, 'Pan (receta básica)', 'Masa horneada compuesta básicamente por un cereal, agua y sal', 23, 13, 8, '03:00:00', NULL, 0, 0, 1, 3, 'Tamizamos la harina con la sal en un bol grande, y disolvemos la levadura en agua templada.\r\nIncorporamos la levadura junto al agua fría a la harina\r\nMezclamos manualmente hasta conseguir una mezcla homogénea y amasamos hasta conseguir una masa elástica que se suelte de las manos.\r\nHacemos una bola y la depositamos en un recipiente enharinado. espolvoreamos con harina por encima y arropamos. Dejamos fermentar una hora en  lugar templado.\r\nPasado ese tiempo formateamos la masa, dándole el menor trabajo posible para evitar que las levaduras bajen.\r\nUna vez le damos la forma elegida, se deposita en papel sulfurizado y se espolvorea con harina. Le damos el mismo tiempo de reposo que la primera vez. \r\nUna vez reposado, se le da un corte en la superficie y se mete al horno 220ºC durante 1 hora si es para pan mollete, y 40 minutos si es para bollitos.', 'Troceado en un platito', 'Pan_202511170738598223.jpg', 1, '2025-11-17 21:17:54', '2025-11-17 21:17:54', 1),
(46, 'Aguacates rellenos de langostinos', 'Refrescante ensalada fácil de preparar con un toque picante', 23, 25, 4, '00:30:00', NULL, 0, 141, 4, 1, 'Pelamos y salpimentamos los langostinos salteamos en aceite. Picamos 8 en paisana fina , y dejamos 8 para el final.\r\nPicamos en brunoise la cebolla y mezclamos con los langostinos.\r\nAñadimos el chile chipotle a la mayonesa, emulsionamos  y la incorporamos a la mezcla de langostinos con cebolla.\r\nPartimos los aguacates por la mitad, retiramos el hueso, y la carne la trocearemos y rellenamos junto a la mezcla anterior cada cáscara del aguacate.', 'Podemos presentar cada dos mitades con los langostinos enteros reservados encima y espolvoreado de cilantro.', 'Aguacates_202511130751164383.jpg', 1, '2025-11-17 21:08:04', '2025-11-17 21:08:04', 1),
(47, 'Albóndigas de pescado', 'Las albóndigas de pescado son una alternativa deliciosa y saludable que te permitirá disfrutar del sabor del mar en cada bocado.', 23, 2, 6, '01:00:00', NULL, 0, 0, 0, 3, '*Albóndigas: Machacar 1 diente de ajo con un poco de aceite  hasta conseguir una pasta.\r\nPicar el bacalao y el salmón sin piel ni espinas, muy fino a cuchillo. Sazonar con sal, la pasta de ajo y perejil.\r\nMezclar todos los ingredientes, formar albóndigas, enharinarlas y freírlas en aceite muy caliente, reservarlas\r\n\r\n    *Salsa: Picar muy fino los tres dientes de ajo y se dispone en un rondón, con aceite, cayena picada y perejil se dora ligeramente y se añade la harina, removiéndo con espátula.\r\nSe añade el fumet y se deja reducir, removiendo para que no se formen grumos.\r\nA parte, se abren las almejas y se las incorpora a la salsa. \r\nSe añaden las albóndigas, se les da un hervor y se sirven', 'Emplatamos 5 o 6 albóndigas con almejas  y espolvoreado todo con perejil muy picado.\r\nPodemos acompañar con arroz blanco o un salteado de verduras, por ejemplo.', 'Albndigas_202511130853442671.jpg', 1, '2025-11-17 21:04:58', '2025-11-17 21:04:58', 1),
(48, 'Arroz con leche', 'Postre cremoso con arroz, leche, azúcar y aromatizado con canel y limón, su textura suave y dulzor delicado lo convierten en un clásico.', 23, 6, 8, '01:00:00', NULL, 0, 0, 0, 2, '*Aromas: Rama de vainilla o rama de canela con piel de naranja y limón, etc. \r\n\r\nSe lava el arroz en agua fría y se deposita en un caza con 150 ml de agua, cuando rompa el hervor, se le incorpora la leche y los aromas y se remueve bien. Se deja cocer a fuego muy suave, removiendo de vez en cuando para que no se agarre, unos 40 minutos..\r\nCuando el grano esté abierto, se retiran los aromas se incorpora la nata y un poco más de leche si vemos que nos queda muy espeso. Se remueve hasta punto de ebullición y se incorpora el azúcar. Se sigue removiendo hasta que el azúcar esté bien incorporado.', 'En copas individuales espolvoreado con canela y un hilito de zeste de limón adornando.', 'Arroz_202511170830348077.jpg', 1, '2025-11-17 21:01:50', '2025-11-17 21:01:50', 1),
(49, 'Empanada de trucha y pimientos asados', 'Receta típica de Galicia. Su masa crujiente y tierna a la vez, contrasta con el relleno jugoso', 23, 13, 8, '01:15:00', NULL, 13, 64, 1, 3, 'La trucha mejor blanca o asalmonada grande. \r\n\r\n    *Para el relleno: Cortar en juliana la cebolla y los pimientos, sofreir a fuego lento hasta que liguen los ingredientes, con un aspecto suave y meloso.\r\nSazonar la trucha y cocer al vapor 8 minutos para que quede poco cocinada ya que se acabará dentro de la empanada. Dejar enfriar, desespinar y desmigar. Reservar.\r\n\r\n    *Para la masa: Mezclar en un bol la harina, el pimentón, el aceite, la leche y el agua. Amasar hasta obtener una masa uniforme.\r\nColocar sobre papel sulfurizado y extender con un rodillo hasta que la masa quede fina.\r\n\r\nRellenar con el relleno y la trucha, cerrar la masa y sellar pellizcando. hacer cortes pequeños en la superficid.  Pintar con huevo batido y hornear 30 minutos a 180ºC', 'En un plato dos trozos pequeños cruzados o en una bandeja, o, si es para varios comensales, media empanada dispuesta en trocitos un poco montados. Le podemos espolvorear un poco de pimentón en el plato para dar color. o una ramita de romero', 'Empanada_20251114113939781.jpg', 1, '2025-11-17 20:58:42', '2025-11-17 20:58:42', 1),
(50, 'Ajoblanco', 'Receta típica de algunas zonas de Andalucía y Extremadura, muy refrescante de de sabor suave, lleva poco ajo a pesar de su nombre, predominando la almendra', 23, 19, 4, '00:20:00', NULL, 1, 64, 1, 1, 'El pan se pone a remojo en la leche y el agua.\r\nLas almendras, el ajo y la sal, se majan en un mortero. Tras el majado, se añade el pan remojado, el aceite y el vinagre.\r\nSe sazona al gusto. y se reserva una hora mínimo en frio. Se debe servir bien frio', 'En plato hondo, adornado con unas uvas blancas y unas lágrimas de aceite de oliva, esta es la forma tradicional, aunque también le va muy bien unos cubos de melón, lascas de jamón...', 'Ajoblanco_202511140104553040.jpg', 1, '2025-11-17 20:54:51', '2025-11-17 20:54:51', 1),
(51, 'Paella valenciana', 'Sabor limpio y equilibrado, donde se aprecia el caldo reducido y el socarrat (capa fina tostada del fondo) con identidad cultural propia.', 23, 15, 6, '01:00:00', NULL, 11, 64, 1, 3, 'Cortar la cebolla y  el ajo  en brunoise,  el tomate en concassé,  el pimiento en trozos pequeños. y trocear las judias.\r\nCortar en trozos pequeños el pollo y el conejo y salpimentar. Calentar 3 cucharadas de aceite en una paella y dorar los trozos de la carne a fuego moderado durante 20 minutos, o hasta que estén bien dorados. Retirar de la paella y reservar.\r\nAgregar del resto del aceite a esta misma sartén y añadir la cebolla y el pimiento unos 5 minutos a fuego moderado, remover de vez en cuando hasta que ablanden. Añadir el ajo, mezclar un minuto e incorporar los guisantes, las judias, y la carne.\r\nRehogar con el vino, dejar cocer 3 minutos para reducir el alcohol incorporar el arroz, rehogar bien, añadirle el caldo y el azafrán. Cocer a fuego moderado unos 10 minutos y rectificar de sal si fuera necesario. Añadir la ramita de romero y proseguir la cocción otros 15 minutos, o hasta que el líquido se haya evaporado y el arroz esté completamente cocido.', 'En la misma paella con un trozo de limón por comensal para limpiar el borde donde va a apoyar la cuchara con la que se sirve y come directamente.', 'Paella_202511140754054351.jpg', 1, '2025-11-17 20:48:58', '2025-11-17 20:48:58', 1),
(52, 'Mero con ortiguillas y salsa de lima', 'Receta de Paco Roncero donde utiliza la ortiguilla, que es una anémona marina, que junto al mero evoca el sabor a mar, la salsa de lima contrasta y equilibra con su frescura, y el dulce del  puré de manzana equilibra el plato', 23, 2, 4, '03:00:00', NULL, 0, 64, 1, 4, '*Para el mero: Limpiar el mero de escamas y espinas.  Sacar los dos lomos y racionar en porciones de 180 gr. aproximadamente. Reservar en cámara hasta su utilización.\r\n\r\n    *Para el puré de manzana: Pelar las manzanas, descorazonar y cortar en gajos irregulares. Pochar la mantequilla y el ácido cítrico o zumo de limón hasta que queden blandos. Triturar, colar y reservar en caliente hasta el momento de su uso.\r\n    \r\n    *Para las ortiguillas: Cortar en 2 o 3 partes en función de su tamaño. Enharinar y freír en abundante aceite de oliva bien caliente para que se forme una costra en el exterior manteniendo la melosidad en su interior. Quitar el exceso de aceite y congelar hasta su uso.\r\n\r\n    *Para la salsa de lima: Mezclar la salsa de soja y el vinagre de jerez y calentar hasta llegar hasta su punto de ebullición. Añadir el jengibre rallado, tapar y dejar infusionar durante 25 minutos aproximadamente. Colar. Mezlar el zumo de las limas y el azúcar e incorporar a la infusión anterior. Mezclar. Añadir la xantana y batir con la túrmix hasta que la xantana se hidrate completamente y la mezcla tenga textura de crema ligera.', 'Disponer en el centro del plato una cucharada de sasa de lima. A la izquierda 4 puntos de puré de manzana y encima de estos 4 ortiguillas fritas y sazonadas. \r\nEncima de la salsa de lima, terminar con el mero marcado a la plancha.', 'Mero_202511140837496775.jpg', 1, '2025-11-14 19:37:49', '2025-11-14 19:37:49', 1),
(53, 'Pavlova con frutos rojos', 'Estupenda combinación de sabores y texturas crujiente por fuera y suave por dentro,  muy impactante a la vista', 23, 6, 4, '01:30:00', NULL, 0, 0, 6, 3, 'Realizamos un merengue francés, Batiendo las claras (con unas gotas de limón o cremor tártaro)  hasta que empiecen a hacer picos blandos, momento en el que empezamos a añadir el azúcar poco a poco, hacia el final, añadimos el vinagre y la harina de maiz sin dejar de batir.\r\nFormamos un nido de 20 cm. o varios individuales, más pequeños, y horneamos a 150ºC una  hora. Apagar el horno y dejar el merengue dentro hasta que enfríe.\r\nUna hora antes de servir, montamos la nata hasta que haga picos duros, e introducimos en manga pastelera con boquilla rizada.\r\nSe recomienda pincelar con chocolate blanco derretido el interior de la pavlova para que la humedad de la nata y las frutas no ablande el merengue', 'Dentro del nido de merengue, rellenamos con la manga pastelera la nata,\r\nEncima disponemos los frutos rojos como más nos guste.', 'Pavlova_20251114091805974.jpg', 1, '2025-11-17 20:41:45', '2025-11-17 20:41:45', 1),
(61, 'Croquetas de jamón serrano', 'Masa rellena de jamón que se caracteríza por su textura crujiente por fuera y suavidad por dentro.', 23, 1, 8, '01:00:00', NULL, 0, 0, 1, 2, 'Además de la harina indicada, necesitamos c/s para rebozar ligeramente las croquetas. Picamos el jamón en brunoise muy fina\r\n\r\nElaboramos un roux derritiendo la harina a fuego suave e incorporamos la harina tamizada. Removemos bien y cocemos unos 5 min., sin dejar de remover.\r\nAñdimos la leche caliente. Removemos procurando romper todos los grumos de harina que se hayan formado.\r\nIncorporamos los aromas y la sal, el jamón. Cocemos hasta que la masa se separe de las paredes y el suelo de la olla.\r\nUna vez bien espeso, se unta la placa de aceite y se deposita la masa sobre ella. Se deja enfriar, mejor un dia entero\r\nSe forman bolitas y se pasan por harina. a continuación por huevo y, por último, por pan rallado.\r\nSe fríen en abundante aceite caliente.', 'En un plato, espolvoreadas de cebollino, perejil o alguna hierba al gusto, o un punto de mayonesa de kimchi, o chipotle, por ejemplo', 'Croquetas_20251116111011811.jpg', 1, '2025-11-17 20:38:18', '2025-11-17 20:38:18', 1),
(62, 'Huevo marino: Yema líquida con tempura crujiente de alga marina', 'La textura crujiente exterior del alga nori se contrapone a la fluida yema de su interior. Intenso sabor a mar en un bocado sorprendente', 23, 17, 4, '03:00:00', NULL, 0, 0, 0, 3, 'El agua debe de estar helada.\r\n\r\nSeparamos las yemas de las claras y colocamos cada una de las yemas, de forma individual envueltas en papel film. Congelamos las yemas, mínimo dos horas. \r\nPreparamos la tempura, para ello hacemos una pasta espesa con la harina, el agua helada y una pizca de sal.\r\n\r\nCortamos la hoja de alga nori en cuadrados lo suficientemente grandes para envolver una yema. Mojamos un pincel con agua y humedecemos el alga nori, para que sea fácil de manejar.\r\n\r\nExtraemos las yemas del congelador, envolvemos cada una en una lámina de alga nori. Sumergimos en la tempura y las freímos en abundante aceite hasta que se dore ligeramente ( un par de minutos aproximadamente).', 'Disponemos una cucharada de huevas de salmón o huevas de pez volador y, sobre estas, depositamos una yema envuelta en tempura de alga nori. Le echamos por encima unas escamas de sal', 'Huevo_202511161155485082.jpg', 1, '2025-11-17 20:31:46', '2025-11-17 20:31:46', 1),
(63, 'Txangurro', 'Combinación de sabores intensos y textura cremosa.', 23, 2, 2, '01:30:00', NULL, 14, 64, 1, 2, 'Picamos la cebolla y el  blanco del puerro en brunoise, y el tomate en concassé.\r\n\r\nPonemos la cazuela al fuego muy suave, con un poco de aove. Pochamos la cebolla y el puerro sin que tome color, añadiendo el tomate, cocemos 15 minutos.\r\n\r\nA parte, cocemos la centolla en agua con sal entre 12 y 15 minutos (para una centolla de 750gr. más o menos), desde que empiece a hervir. Retiramos la centolla y, en caliente la abrimos para colar su caldo y el coral que tiene en su caparazón. Vertemos el caldo en el sofrito y echamos brandy para flambear.\r\n\r\nLimpiamos las patas para aprovechar su carne y la introducimos en la salsa. Le damos un hervor a todos los ingredientes, reciticamos de sal y llenamos el caparazón de la centolla limpia con esta mezcla..\r\n\r\nEspolvoreamos con pan rallado y colocamos encima unos dados de mantequilla repartidos por toda la superficie.\r\nGratinamos y servimos caliente.', 'Ponemos una cama de lechuga o hielo picado en un plato y encima el txangurro.\r\nPodemos acompañar con un alioli casero.', 'Txangurro_202511161219353318.jpg', 1, '2025-11-17 20:26:59', '2025-11-17 20:26:59', 1),
(64, 'Rape alangostado', 'Pescado con sabor intenso y ahumado que recuerda al de la langosta.', 23, 2, 4, '03:00:00', NULL, 0, 64, 1, 2, 'Necesitamos un cola de rape.\r\nEmbadurnamos la cola de rape de pimentón, en seco. Untar de aceite y salpimentar. Lo cubrimos con papel fim y le damos forma de cola de langosta con la cuerda de bramamante. Dejamos reposar en la nevera por dos horas. Crubrir y apretar con papel aluminio.\r\n\r\nDisponer fumet en una olla, el suficiente para que cubra la cola de rape. Cuando rompa a hervir, bajar el fuego y cocer a fuego muy suave durante 10 minutos (por cada 500gr de rape).\r\nTambién se puede cocer al vapor para conservar mejor el sabor y color.', 'Cortamos en rodajas finas como si se tratara de un lomo de langosta.\r\nPodemos ponerle unos puntitos de mayonesa de ajo y unos tomatitos cherry en mitades.', 'Rape_20251116014357231.jpg', 1, '2025-11-17 20:24:01', '2025-11-17 20:24:01', 1),
(65, 'Roast beef con salsa gravy', 'Un plato que combina la eleganciaa de un buen asado con el sabor intenso de una salsa casera.', 23, 1, 4, '02:00:00', NULL, 0, 185, 1, 2, '* Carne: En un bol mezclamos una cucharada de mostaza en polvo y un poco de agua para hacer una pasta con la que untaremos el lomo de buey.\r\nSellamos la carne en una sartén o cazuela con una cucharada de aceite. La ponemos en una rustidera y al horno 200ºC (por cada 500gr. de carne le damos 15 min. si la quermos poco hecha, 20min. si la queremos al punto y 25 min. si la queremos más hecha.\r\nUna vez que haya pasado el tiempo que consideramos oportuno, sacaremos la carne y la cubrimos con papel aluminio para que sude.\r\n\r\n    *Mientras pelamos las patatas y las cocemos en abundante agua con con sal, pero antes de que estén cocidas del todo, se retiran y se acaban en horno junto a unos dientes de ajo majados con un chorrito de aceite y unas ramitas romero.\r\n\r\n    *Salsa: Picamos la cebolla en brunoise y la rehogamos en aceite de oliva. Cuando esté transparente, añadimos un poco de harina y le damos unas vueltas para que tueste un poco.\r\nAgregamos los jugos que ha soltado nuestro lomo y el vinto dejamos que cueza y reduzca.\r\n\r\nHervimos el brécol.', 'Cortamos la carne en lonchas finas,  bañada en la salsa gravy, la acompañamos con las patatas y el brécol hervido', 'Roast_202511160743214398.jpg', 1, '2025-11-17 20:20:32', '2025-11-17 20:20:32', 1),
(66, 'Picantones rellenos de manzana', 'La versatilidad de esta carne nos permite acompañarla con infinidad de guarniciones, desde el clásico puré de patata o patata panadera, hasta una ensalada, que le va a dar frescor sin llenar demasiado.', 23, 1, 2, '01:30:00', NULL, 0, 0, 1, 3, '*Relleno: Cortamos el pan en dados que tostaremos en 15 gr. de mantequilla en una sartén. Escurrimos en papel y reservamos.\r\nPelamos las manzanas y las cortamos en brunoise, las depositamos en un bol donde las mezclamos con las pasas, el licor, el vino y el caldo y el almíbar. Dejamos macerar unos 30 minutos.\r\nAl pan frito le añadimos ajo en brunoise frito, la yema de huevo en crudo, la nata y el perejil. Añadimos esta mezcla a la marinada. Condimentamos.\r\n\r\n    *Picantones: Los deshuesamos y salpimentamos. Separamos la piel de las pechugas y comenzamos a rellenar debajo, dándole forma.\r\nDamos la vuelta al pollo y rellenamos la cavidad abdominal con el relleno que nos queda.\r\nBridamos dándole una bonita forma y metemos al horno durante 40-45 minutos a 165ºC. Hidratar de vez en cuando con almíbar mezclado con aceite o mantequilla.\r\n\r\nDoramos unas rodajas de piña a la plancha como guarnición.', 'En un plato, acompañado de la piña a la plancha colocamos el picantón con la piel hacia arriba y lo braseamos con sus jugos.\r\nAdemás le podemos poner otra  guarnción a mayores como,  patata panadera, puré de patata, ensalada, ....', 'Picantones_202511160819295636.jpg', 1, '2025-11-17 20:16:34', '2025-11-17 20:16:34', 1),
(67, 'Flan de castaña', 'Evoca los sabores de otoño con una textura cremosa y un sabor delicadamente dulce.', 23, 6, 8, '01:00:00', NULL, 13, 64, 1, 3, '*Puré de castaña: Cocer las castañas, pelar y triturar con parte de la leche.\r\nAñadir el resto de la leche y calentar el conjunto.\r\n\r\nPor otro lado mezclar los huevos con 200 gr. de azúcar, sobre esta mezcla, añadir la  leche de castaña, .\r\n\r\nCon los 200gr restantes de azúcar, caramelizar los moldes con un caramelo rubio (128ºC).\r\n\r\nLlenar los moldes hasta 3/4 con la mezcla de flan. Hornear a 180ºC en baño maría, 20 minutos para flanes individuales.\r\n\r\nEnfriar antes de desmoldar.', 'Se puede acompañar de cigarrillos, tejas, figura de caramelo o chocolate, crumble, nata montada etc..', 'Flan_202511160839378170.jpg', 1, '2025-11-17 20:05:50', '2025-11-17 20:05:50', 1),
(68, 'Naked cake de calabaza vegano (sin huevos, sin lactosa)', 'Un cake libre de ingredientes de origen animal, siendo una deliciosa opción para quienes siguen una dieta vegana o les apetece probar algo nuevo.', 23, 6, 8, '01:00:00', NULL, 0, 0, 1, 2, 'Asar la calabaza y triturarla hasta obtener un puré.\r\nAñadir al puré el aceite de oliva y el azúcar, triturar de nuevo.\r\nSobre esta mezcla, ir incorporando suavemente la harina con la canela molida y el bicarbonato y la sal.\r\nIncorporamos las nueces troceadas.\r\nHornear  a 180ºC aproximadamente unos 40 minutos. en pequeños moldes\r\nDesmoldar una vez frío. Es delicado.', 'Montamos varios discos en un aro estilo naked cake, rellenar de nata vegetal montada con fresas naturales en daditos y puntos de coulis de calabaza.', 'Naked_202511160857516651.jpg', 1, '2025-11-18 12:17:37', '2025-11-18 12:17:37', 1),
(69, 'Platito de pruebas', 'Descripción descrita muy descritamente', 19, 15, 3, '05:11:00', NULL, 13, 64, 1, 1, 'Elaboración muy elaborada y elaboradita', 'Emplatadito bien emplatado', 'Platito_202511170712064815.jpg', 1, '2025-11-17 18:26:02', '2025-11-17 18:26:02', 0),
(70, 'Buñuelosde  bacalao', 'Su origen se remonta a la cuaresma, cuando se evitava el consumo de carne,  una alternativa rica y fácil de conservar.  Son unas bolitas fritas y esponjosas con un sabor saldo delicioso.', 2, 2, 4, '02:30:00', NULL, 0, 64, 1, 3, 'Preparar la masa de los buñuelos: Poner en un cuenco la harina formando un volcán y verter en el centro el aceite de oliva, la cerveza, la levadura, el ajo en polvo, una pizca de sal y pimienta negra molida la yema de huevo y el agua (la que necesita.) \r\nAmasar hasta conseguir una masa densa. Tapar y dejar reposar 1-2 horas.\r\nAparte, escaldamos el bacalao, desmigamos y desmenuzamos.\r\nUna vez reposada la masa de los buñuelos, montar la clara a punto de nieve.\r\nIncorporar el bacalao a la masa y a continuación la clara, con cuidado.\r\nFreír en abundante aceite caliente.', '', 'Buuelosde_20251119065416671.jpg', 1, '2025-11-19 17:54:16', '2025-11-19 18:28:20', 1),
(71, 'Arroz pilaf', 'Receta de arroz largo de origen oriental, que admite infinidad de ingredientes.  Ideal para guarnición de carnes, aves,  pescados e incluso parrillada de verduras', 13, 15, 4, '00:45:00', NULL, 0, 0, 2, 1, 'Estos son los ingredientes de la receta básica, pero se le pueden añadir pasas, almendras o pistachos para darle dulzura o vegetales como zanahoria, guisantes, pimientos para hacerlo más nutritivo y colorido. Además en algunos paises de medio oriente lo enriquecen con comino, canela, clavo y cardamomo\r\n\r\nPasamos el arroz bajo el grifo de agua fria para quitarle el almidón.\r\nCortamos el ajo y la cebolla en brunoise y, opcionalmente los vegetales . Los pochamos en 1 cucharada mantequilla, hasta que estén transparentes,(es el momento de añadir hierbas, y frutos secos que hayas elegido),  incorporamos el arroz y rehogamos todo junto. Dejamos que tome los sabores y añadimos el caldo de pollo, también le va bien  de verduras. Dejamos a fuego lento 15 minutos y terminamos en horno con el arroz tapado a 160ºC. 10 minutos más.', 'Servir en plato decorado con hierbas frescas', 'Arroz_202511190849446374.jpg', 1, '2025-11-19 19:49:44', '2025-11-19 19:51:39', 1);

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
(35, 52, 8),
(63, 69, 8),
(77, 67, 14),
(78, 66, 17),
(79, 66, 14),
(80, 65, 3),
(81, 64, 14),
(82, 63, 14),
(83, 62, 8),
(84, 62, 3),
(85, 61, 14),
(86, 53, 16),
(87, 53, 3),
(88, 53, 11),
(89, 51, 1),
(90, 51, 14),
(91, 50, 14),
(92, 49, 14),
(93, 46, 3),
(94, 45, 3),
(95, 45, 14),
(96, 39, 3),
(97, 43, 20),
(98, 43, 14),
(99, 40, 3),
(102, 68, 11),
(103, 68, 12),
(104, 68, 9),
(112, 70, 1),
(113, 70, 18),
(114, 70, 14),
(120, 71, 3),
(121, 71, 11),
(122, 71, 12),
(123, 71, 9),
(124, 71, 13),
(125, 37, 3),
(151, 36, 20),
(152, 36, 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas_ingredientes`
--

DROP TABLE IF EXISTS `recetas_ingredientes`;
CREATE TABLE `recetas_ingredientes` (
  `id_recetas_ingredientes` int(11) NOT NULL,
  `id_receta` int(11) NOT NULL,
  `id_ingrediente` int(11) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
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
(23, 37, 27, 4.00, 9),
(24, 37, 28, 1.00, 6),
(25, 37, 29, 2.00, 8),
(26, 37, 30, 4.00, 9),
(27, 37, 31, 300.00, 2),
(28, 37, 32, 200.00, 2),
(29, 37, 33, 2.00, 8),
(30, 37, 34, 2.00, 8),
(31, 37, 35, 4.00, 8),
(32, 37, 36, 4.00, 9),
(33, 37, 37, 200.00, 4),
(34, 37, 38, 200.00, 4),
(35, 37, 39, 2.00, 8),
(36, 37, 40, 2.00, 8),
(37, 38, 41, 2.00, 9),
(38, 38, 9, 150.00, 2),
(39, 38, 39, 60.00, 2),
(40, 38, 42, 2.00, 2),
(41, 38, 43, 120.00, 4),
(42, 38, 44, 2.00, 2),
(43, 38, 2, 200.00, 2),
(44, 38, 45, 0.00, 5),
(55, 40, 53, 3.00, 9),
(56, 40, 54, 1.00, 9),
(57, 40, 55, 2.00, 9),
(58, 40, 56, 0.00, 7),
(59, 40, 57, 1.00, 9),
(60, 40, 28, 1.00, 6),
(82, 47, 68, 250.00, 2),
(83, 47, 69, 250.00, 2),
(84, 47, 70, 50.00, 2),
(85, 47, 41, 2.00, 9),
(86, 47, 71, 4.00, 9),
(87, 47, 72, 1.00, 5),
(88, 47, 28, 1.00, 5),
(89, 47, 52, 1.00, 5),
(90, 47, 2, 10.00, 2),
(91, 47, 74, 200.00, 4),
(92, 47, 73, 100.00, 4),
(93, 47, 75, 100.00, 2),
(94, 47, 76, 200.00, 2),
(95, 47, 77, 1.00, 5),
(96, 48, 7, 1.00, 3),
(97, 48, 47, 100.00, 4),
(98, 48, 78, 80.00, 2),
(99, 48, 9, 100.00, 2),
(100, 48, 79, 1.00, 6),
(101, 48, 43, 150.00, 4),
(113, 50, 23, 100.00, 2),
(114, 50, 43, 500.00, 4),
(115, 50, 84, 100.00, 2),
(116, 50, 35, 100.00, 4),
(117, 50, 86, 1.00, 10),
(118, 50, 7, 100.00, 4),
(119, 50, 28, 1.00, 6),
(120, 50, 87, 2.00, 9),
(138, 52, 95, 1.00, 1),
(139, 52, 96, 4.00, 9),
(140, 52, 8, 50.00, 2),
(141, 52, 97, 1.00, 5),
(142, 52, 98, 1.00, 6),
(143, 52, 52, 1.00, 5),
(144, 52, 99, 2.00, 9),
(145, 52, 37, 100.00, 4),
(146, 52, 100, 50.00, 4),
(147, 52, 101, 1.00, 6),
(148, 52, 9, 20.00, 2),
(149, 52, 102, 5.00, 2),
(253, 69, 43, 2.00, 3),
(254, 69, 71, 1.00, 9),
(255, 69, 97, 3.75, 3),
(304, 67, 126, 300.00, 2),
(305, 67, 41, 12.00, 9),
(306, 67, 9, 400.00, 2),
(307, 67, 7, 1.00, 3),
(308, 66, 120, 2.00, 9),
(309, 66, 28, 1.00, 6),
(310, 66, 121, 1.00, 6),
(311, 66, 52, 30.00, 4),
(312, 66, 8, 55.00, 2),
(313, 66, 49, 60.00, 2),
(314, 66, 96, 1.00, 9),
(315, 66, 122, 40.00, 2),
(316, 66, 73, 100.00, 4),
(317, 66, 112, 100.00, 4),
(318, 66, 123, 200.00, 4),
(319, 66, 124, 200.00, 4),
(320, 66, 48, 2.00, 9),
(321, 66, 47, 1.00, 8),
(322, 66, 87, 1.00, 9),
(323, 66, 105, 1.00, 6),
(324, 66, 125, 1.00, 6),
(325, 65, 115, 1.00, 1),
(326, 65, 116, 1.00, 8),
(327, 65, 43, 1.00, 5),
(328, 65, 117, 4.00, 9),
(329, 65, 34, 1.00, 6),
(330, 65, 28, 1.00, 6),
(331, 65, 51, 1.00, 6),
(332, 65, 118, 1.00, 5),
(333, 65, 54, 0.50, 9),
(334, 65, 2, 1.00, 8),
(335, 65, 71, 1.00, 9),
(336, 65, 119, 1.00, 6),
(337, 64, 113, 1.00, 1),
(338, 64, 81, 1.00, 5),
(339, 64, 114, 1.00, 9),
(340, 64, 52, 1.00, 5),
(341, 64, 28, 1.00, 6),
(342, 64, 51, 1.00, 6),
(343, 64, 74, 1.00, 5),
(344, 63, 110, 1.00, 9),
(345, 63, 54, 0.50, 9),
(346, 63, 111, 1.00, 9),
(347, 63, 53, 2.00, 9),
(348, 63, 70, 1.00, 5),
(349, 63, 112, 2.00, 8),
(350, 63, 35, 1.00, 5),
(351, 63, 8, 40.00, 2),
(352, 63, 28, 1.00, 6),
(353, 62, 41, 4.00, 9),
(354, 62, 28, 1.00, 6),
(355, 62, 43, 2.00, 8),
(356, 62, 107, 2.00, 9),
(357, 62, 108, 1.00, 6),
(358, 62, 45, 1.00, 5),
(359, 62, 109, 1.00, 6),
(360, 61, 52, 1.00, 5),
(361, 61, 2, 175.00, 2),
(362, 61, 8, 175.00, 2),
(363, 61, 28, 1.00, 6),
(364, 61, 51, 1.00, 6),
(365, 61, 105, 1.00, 6),
(366, 61, 106, 250.00, 2),
(367, 61, 70, 1.00, 5),
(368, 61, 41, 4.00, 9),
(369, 61, 7, 1.00, 3),
(370, 53, 58, 3.00, 9),
(371, 53, 9, 175.00, 2),
(372, 53, 86, 1.00, 10),
(373, 53, 40, 1.00, 8),
(374, 53, 47, 300.00, 4),
(375, 53, 103, 1.00, 6),
(376, 53, 57, 1.00, 5),
(377, 53, 104, 50.00, 2),
(378, 51, 73, 125.00, 4),
(379, 51, 88, 1.00, 10),
(380, 51, 89, 1.00, 3),
(381, 51, 90, 750.00, 2),
(382, 51, 91, 750.00, 2),
(383, 51, 82, 1.00, 9),
(384, 51, 87, 5.00, 9),
(385, 51, 53, 2.00, 9),
(386, 51, 81, 2.00, 10),
(387, 51, 78, 750.00, 2),
(388, 51, 75, 100.00, 2),
(389, 51, 92, 450.00, 2),
(390, 51, 72, 2.00, 11),
(391, 51, 28, 1.00, 6),
(392, 51, 52, 4.00, 8),
(393, 51, 94, 1.00, 9),
(394, 51, 57, 1.00, 9),
(395, 49, 80, 1.00, 1),
(396, 49, 2, 1.00, 1),
(397, 49, 81, 2.00, 8),
(398, 49, 43, 50.00, 4),
(399, 49, 52, 400.00, 4),
(400, 49, 7, 400.00, 4),
(401, 49, 54, 3.00, 9),
(402, 49, 82, 2.00, 9),
(403, 49, 83, 2.00, 9),
(404, 49, 41, 1.00, 9),
(405, 49, 28, 1.00, 6),
(406, 46, 63, 4.00, 9),
(407, 46, 64, 16.00, 9),
(408, 46, 65, 1.00, 9),
(409, 46, 35, 1.00, 5),
(410, 46, 67, 1.00, 6),
(411, 46, 66, 1.00, 6),
(412, 46, 56, 1.00, 6),
(413, 46, 28, 1.00, 6),
(414, 46, 51, 1.00, 6),
(415, 45, 59, 1.00, 1),
(416, 45, 60, 25.00, 2),
(417, 45, 28, 15.00, 2),
(418, 45, 61, 500.00, 4),
(419, 45, 62, 150.00, 4),
(420, 39, 46, 1.00, 3),
(421, 39, 8, 50.00, 2),
(422, 39, 2, 100.00, 2),
(423, 39, 47, 150.00, 4),
(424, 39, 48, 2.00, 9),
(425, 39, 49, 8.00, 9),
(426, 39, 50, 1.00, 11),
(427, 39, 51, 1.00, 6),
(428, 39, 28, 1.00, 6),
(429, 39, 52, 1.00, 5),
(430, 43, 58, 330.00, 2),
(431, 43, 9, 530.00, 2),
(432, 43, 47, 240.00, 2),
(433, 43, 2, 240.00, 2),
(434, 68, 28, 1.00, 11),
(435, 68, 42, 5.00, 2),
(436, 68, 50, 1.00, 5),
(437, 68, 52, 100.00, 4),
(438, 68, 127, 300.00, 2),
(439, 68, 128, 100.00, 2),
(440, 68, 129, 200.00, 2),
(441, 68, 130, 100.00, 2),
(470, 70, 69, 250.00, 2),
(471, 70, 43, 130.00, 2),
(472, 70, 2, 145.00, 2),
(473, 70, 52, 1.00, 5),
(474, 70, 46, 1.00, 5),
(475, 70, 44, 1.00, 2),
(476, 70, 41, 1.00, 9),
(477, 70, 72, 1.00, 5),
(478, 70, 28, 1.00, 6),
(479, 70, 29, 1.00, 6),
(480, 70, 131, 1.00, 10),
(488, 71, 132, 180.00, 2),
(489, 71, 8, 2.00, 8),
(490, 71, 54, 0.50, 9),
(491, 71, 87, 1.00, 9),
(492, 71, 52, 1.00, 5),
(493, 71, 28, 1.00, 6),
(494, 71, 89, 315.00, 4),
(513, 36, 9, 10.00, 2),
(514, 36, 2, 1.00, 1),
(515, 36, 8, 50.00, 2),
(516, 36, 7, 1.00, 3),
(517, 36, 4, 4.00, 9),
(518, 36, 6, 5.00, 2),
(519, 36, 23, 100.00, 1);

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
(113, 36, 12),
(112, 36, 28),
(100, 37, 12),
(12, 38, 21),
(86, 39, 13),
(87, 43, 25),
(85, 45, 25),
(84, 46, 21),
(21, 47, 28),
(22, 48, 13),
(82, 49, 18),
(83, 49, 21),
(81, 49, 25),
(80, 51, 21),
(27, 52, 13),
(28, 52, 21),
(79, 53, 25),
(77, 61, 12),
(78, 61, 21),
(76, 62, 12),
(74, 63, 13),
(75, 63, 21),
(73, 63, 25),
(72, 64, 13),
(71, 64, 18),
(70, 65, 13),
(69, 65, 25),
(68, 66, 21),
(67, 66, 25),
(66, 67, 18),
(90, 68, 25),
(58, 69, 20),
(94, 70, 12),
(98, 71, 21),
(97, 71, 25);

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
(139, 36, 1),
(137, 36, 10),
(138, 36, 11),
(136, 36, 12),
(100, 37, 7),
(24, 38, 10),
(87, 39, 3),
(89, 40, 11),
(88, 43, 4),
(86, 45, 12),
(85, 46, 3),
(34, 47, 3),
(35, 48, 4),
(83, 49, 1),
(84, 49, 3),
(82, 50, 3),
(81, 50, 11),
(80, 51, 7),
(41, 52, 7),
(79, 53, 4),
(78, 61, 1),
(76, 62, 1),
(77, 62, 3),
(75, 63, 3),
(74, 64, 7),
(73, 65, 7),
(72, 66, 7),
(71, 67, 4),
(92, 68, 4),
(64, 69, 12),
(96, 70, 1),
(98, 71, 11);

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
(217, 36, 1),
(218, 36, 4),
(219, 36, 6),
(14, 38, 163),
(15, 38, 164),
(16, 38, 165),
(17, 38, 166),
(18, 38, 167),
(168, 39, 163),
(169, 39, 166),
(170, 39, 168),
(24, 40, 169),
(22, 40, 170),
(23, 40, 171),
(171, 43, 1),
(172, 43, 165),
(173, 43, 167),
(174, 43, 172),
(175, 43, 173),
(176, 43, 174),
(164, 45, 167),
(165, 45, 172),
(166, 45, 174),
(167, 45, 175),
(163, 46, 166),
(43, 47, 166),
(44, 47, 178),
(45, 47, 180),
(47, 48, 180),
(46, 48, 181),
(158, 49, 167),
(159, 49, 175),
(160, 49, 176),
(161, 49, 177),
(162, 49, 182),
(54, 50, 171),
(53, 50, 183),
(157, 51, 184),
(60, 52, 4),
(56, 52, 164),
(58, 52, 166),
(57, 52, 181),
(59, 52, 185),
(151, 53, 1),
(152, 53, 165),
(153, 53, 167),
(154, 53, 186),
(155, 53, 187),
(156, 53, 188),
(148, 61, 178),
(149, 61, 180),
(150, 61, 190),
(145, 62, 166),
(146, 62, 186),
(147, 62, 191),
(143, 63, 172),
(144, 63, 178),
(139, 64, 168),
(140, 64, 191),
(141, 64, 192),
(142, 64, 193),
(135, 65, 168),
(136, 65, 171),
(137, 65, 193),
(138, 65, 194),
(131, 66, 166),
(132, 66, 171),
(133, 66, 192),
(134, 66, 194),
(128, 67, 168),
(129, 67, 190),
(130, 67, 195),
(177, 68, 168),
(178, 68, 185),
(108, 69, 175),
(186, 70, 166),
(187, 70, 175),
(190, 71, 164),
(191, 71, 168);

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
(28, 13),
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
(12, 'Freir', 'Freir_8221.jpg'),
(13, 'Hervir', 'Hervir_1558.jpg'),
(17, 'Pochar o escalfar', 'Pochar_o_escalfar_9643.jpg'),
(18, 'Cocción al vapor', 'Coccin_al_vapor_4152.jpg'),
(19, 'Cocción en olla a presión', 'Coccin_en_olla_a_presin_5363.jpg'),
(20, 'Blanquear', 'Blanquear_1120.jpg'),
(21, 'Sofreir', 'Sofreir_2565.jpg'),
(22, 'Saltear', 'Saltear_5732.jpg'),
(23, 'Dorar o gratinar', 'Dorar_o_gratinar_5922.jpg'),
(24, 'En parrilla', 'En_parrilla_7125.jpg'),
(25, 'Al horno', 'Al_horno_451.jpg'),
(26, 'Guisar', 'Guisar_2041.jpg'),
(27, 'Estofar', 'Estofar_6448.jpg'),
(28, 'Brasear', 'Brasear_2736.jpg');

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
(1, 'Picoteo y aperitivos', 'aperitivos.jpg'),
(3, 'Primeros Platos', 'Primeros_Platos_7868.jpg'),
(4, 'Postres', 'Postres_5632.jpg'),
(7, 'Segundos platos', 'Segundos_platos_2673.jpg'),
(10, 'Desayunos y meriendas', 'Desayunos_y_meriendas_149.jpg'),
(11, 'Guarniciones', 'Guarniciones_7773.png'),
(12, 'Acompañamientos', 'Acompaamientos_65.jpg');

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
(163, 'Varillas', 'Varillas_3926.jpg', 1),
(164, 'Colador', 'Colador_255.jpg', 1),
(165, 'Lengua de silicona', 'Lengua_de_silicona_3072.jpg', 1),
(166, 'Sartén', 'Sartn_2082.jpg', 1),
(167, 'Papel de horno', 'Papel_de_horno_710.jpg', 1),
(168, 'Olla', 'Olla_6735.jpg', 1),
(169, 'Tabla de corte', 'Tabla_de_corte_395.jpg', 1),
(170, 'Cuchillo cebollero', 'Cuchillo_cebollero_4767.jpg', 1),
(171, 'Bol pequeño', 'Bol_pequeo_8385.jpg', 1),
(172, 'Bandeja de horno', 'Bandeja_de_horno_6659.jpg', 1),
(173, 'Rejilla', 'Rejilla_6104.jpg', 1),
(174, 'Tamiz', 'Tamiz_2435.jpg', 1),
(175, 'Bol grande', 'Bol_grande_8799.jpg', 1),
(176, 'Cuerna', 'Cuerna_2571.jpg', 1),
(177, 'Sauté', 'Saut_4777.jpg', 1),
(178, 'Rondón', 'Rondn_7701.jpg', 1),
(179, 'Marmita', 'Marmita_2520.jpg', 1),
(180, 'Espátula', 'Esptula_8938.jpg', 1),
(181, 'Cazo', 'Cazo_6249.jpg', 1),
(182, 'Rodillo', 'Rodillo_8207.jpg', 1),
(183, 'Mortero', 'Mortero_7185.jpg', 1),
(184, 'Paella', 'Paella_976.jpg', 1),
(185, 'Batidora eléctrica túrmix', 'Batidora_elctrica_trmix_2894.jpg', 1),
(186, 'Pincel silicona', 'Pincel_silicona_9108.jpg', 1),
(187, 'Manga pastelera', 'Manga_pastelera_3566.jpg', 1),
(188, 'Boquilla', 'Boquilla_845.jpg', 1),
(190, 'Gastronorm', 'Gastronorm_170.jpg', 1),
(191, 'Papel film', 'Papel_film_2266.jpg', 1),
(192, 'Cuerda bramante', 'Cuerda_bramante_3417.jpg', 1),
(193, 'Papel aluminio', 'Papel_aluminio_444.jpg', 1),
(194, 'Rustidera', 'Rustidera_8258.jpg', 1),
(195, 'Moldes', 'Moldes_4457.jpg', 1),
(196, 'Molde individual', 'Molde_individual_2170.jpg', 1),
(197, 'wok', 'wok_4545.jpg', 1);

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
  MODIFY `id_estilo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
  MODIFY `id_ingrediente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT de la tabla `ingredientes_alergenos`
--
ALTER TABLE `ingredientes_alergenos`
  MODIFY `id_ing_ale` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

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
  MODIFY `id_receta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de la tabla `recetas_alergenos`
--
ALTER TABLE `recetas_alergenos`
  MODIFY `id_recetas_alergenos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recetas_estilos`
--
ALTER TABLE `recetas_estilos`
  MODIFY `id_recetas_estilos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT de la tabla `recetas_ingredientes`
--
ALTER TABLE `recetas_ingredientes`
  MODIFY `id_recetas_ingredientes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=520;

--
-- AUTO_INCREMENT de la tabla `recetas_tecnicas`
--
ALTER TABLE `recetas_tecnicas`
  MODIFY `id_recetas_tecnicas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT de la tabla `recetas_tiposplato`
--
ALTER TABLE `recetas_tiposplato`
  MODIFY `id_recetas_tiposplato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT de la tabla `recetas_utensilios`
--
ALTER TABLE `recetas_utensilios`
  MODIFY `id_recetas_utensilios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;

--
-- AUTO_INCREMENT de la tabla `redactores`
--
ALTER TABLE `redactores`
  MODIFY `id_redactor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
  MODIFY `id_utensilio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

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
