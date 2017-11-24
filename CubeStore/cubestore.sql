CREATE DATABASE cubestore;
USE cubestore;
-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 27-02-2017 a las 16:25:08
-- Versión del servidor: 10.1.16-MariaDB
-- Versión de PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cubestore`
--

-- --------------------------------------------------------


--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `Usuario` varchar(25) NOT NULL,
  `Contrasena` varchar(25) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `Apellido` varchar(40) NOT NULL,
  `CorreoElectronico` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`Usuario`, `Contrasena`, `Nombre`, `Apellido`, `CorreoElectronico`) VALUES
('Elisa', '1234', 'elisa', 'arscott', 'elisa@hotmail.com'),
('Youssef', '1234', 'youssef', 'elfaqir', 'youssef@hotmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `Nombre` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`Nombre`) VALUES
('10X10'),
('11X11'),
('1X3X3'),
('2X2'),
('3X3'),
('4X4'),
('5X5'),
('6X6'),
('7X7'),
('9X9'),
('Mastermorphix'),
('Pyraminx'),
('Variaciones del 2X2'),
('Variaciones del 3X3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `Usuario` varchar(25) NOT NULL,
  `Contrasena` varchar(25) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `Apellido` varchar(40) NOT NULL,
  `CorreoElectronico` varchar(30) NOT NULL,
  `Direccion` varchar(70) NOT NULL,
  `NumeroTarjeta` bigint(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`Usuario`, `Contrasena`, `Nombre`, `Apellido`, `CorreoElectronico`, `Direccion`, `NumeroTarjeta`) VALUES
('Foxy', 'agua', 'Martina', 'Mateos', 'martina@hotmail.com', 'Calle Velarde', 2147483647),
('Hulahoop', 'php', 'Olivia', 'Lopez', 'olivia@gmail.com', 'Avenida Cardenal Herrera Oria', 123456789),
('Lenovo', 'estuche', 'Jose', 'Perez', 'jprez@gmail.com', 'Calle Cervantes', 2147483647),
('Numero1', 'caracola', 'Atila', 'Gonzalez', 'atila@yahoo.com', 'Calle Islas Cies', 2147483647);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `linea`
--

CREATE TABLE `linea` (
  `Id_L` int(4) NOT NULL,
  `IdPedido_L` int(4) DEFAULT NULL,
  `ModeloProducto_L` int(3) DEFAULT NULL,
  `Cantidad` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `linea`
--

INSERT INTO `linea` (`Id_L`, `IdPedido_L`, `ModeloProducto_L`, `Cantidad`) VALUES
(18, 5, 102, 1),
(19, 5, 461, 1),
(20, 6, 4, 1),
(29, 13, 84, 1),
(30, 14, 463, 2),
(31, 14, 772, 3),
(32, 15, 3, 1),
(33, 16, 991, 1),
(34, 16, 121, 3),
(35, 17, 461, 1),
(36, 18, 45, 1),
(37, 18, 45, 2),
(38, 13, 14, 1),
(39, 19, 258, 1),
(40, 19, 21, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_de_deseados`
--

CREATE TABLE `lista_de_deseados` (
  `Usuario_Cliente` varchar(25) NOT NULL,
  `Modelo_de_Producto` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `lista_de_deseados`
--

INSERT INTO `lista_de_deseados` (`Usuario_Cliente`, `Modelo_de_Producto`) VALUES
('Foxy', 2),
('Foxy', 69),
('Foxy', 116),
('Foxy', 123),
('Foxy', 748),
('Hulahoop', 1),
('Hulahoop', 34),
('Hulahoop', 102),
('Lenovo', 3),
('Lenovo', 84),
('Lenovo', 101),
('Lenovo', 120),
('Lenovo', 245),
('Lenovo', 772),
('Numero1', 45),
('Numero1', 462);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `Id_P` int(4) NOT NULL,
  `FechaCompra` varchar(10) NOT NULL,
  `Comprado` varchar(5) NOT NULL,
  `Usuario_Cliente` varchar(25) NOT NULL,
  `Precio_Total` double(6,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`Id_P`, `FechaCompra`, `Comprado`, `Usuario_Cliente`, `Precio_Total`) VALUES
(5, '25/2/2017', 'true', 'Foxy', 113.98),
(6, '26/2/2017', 'true', 'Foxy', 7.99),
(13, '26/2/2017', 'true', 'Foxy', 13.48),
(14, '26/2/2017', 'true', 'Hulahoop', 93.95),
(15, '26/2/2017', 'false', 'Hulahoop', 7.99),
(16, '26/2/2017', 'true', 'Lenovo', 108.47),
(17, '26/2/2017', 'true', 'Lenovo', 13.99),
(18, '26/2/2017', 'true', 'Lenovo', 29.97),
(19, '26/2/2017', 'false', 'Foxy', 49.98);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `Modelo` int(3) NOT NULL,
  `Nombre` varchar(70) NOT NULL,
  `Tamano` int(3) DEFAULT NULL,
  `Peso` int(3) DEFAULT NULL,
  `Precio` double(4,2) NOT NULL,
  `CantidadEnStock` int(3) NOT NULL,
  `MarcaProveedor` varchar(20) DEFAULT NULL,
  `Foto1` varchar(150) DEFAULT NULL,
  `Foto2` varchar(150) DEFAULT NULL,
  `Video` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`Modelo`, `Nombre`, `Tamano`, `Peso`, `Precio`, `CantidadEnStock`, `MarcaProveedor`, `Foto1`, `Foto2`, `Video`) VALUES
(1, 'Lanlan Floppy 1x3x3 black', 57, 100, 5.99, 2, 'LanLan', 'http://www.championscubestore.com/images/s/201608/LLFP01_14724516332.jpg', 'http://www.championscubestore.com/images/s/201608/LLFP01_14724516333.jpg', NULL),
(2, 'Lanlan Floppy 1x3x3 white', 57, 100, 5.99, 0, 'LanLan', 'http://www.championscubestore.com/images/s/201408/14093143310.jpg', 'http://www.championscubestore.com/images/s/201608/LLFP02_14724516341.jpg', NULL),
(3, 'Lanlan Tiled 5x5x5 white', 155, 228, 7.99, 15, 'LanLan', 'http://www.championscubestore.com/images/s/201205/13377556841.jpg', 'http://www.championscubestore.com/images/s/201205/13377556852.jpg', 'nr84VMs8zug'),
(4, 'Lanlan Tiled 5x5x5 black', 155, 228, 7.99, 17, 'LanLan', 'http://www.championscubestore.com/images/s/201205/13377555941.jpg', 'http://www.championscubestore.com/images/s/201205/13377555942.jpg', 'nr84VMs8zug'),
(5, 'YJ monochrome blue Mirror Cube', 80, 170, 4.99, 6, 'YJ', 'http://www.championscubestore.com/images/s/201608/YXJM05_14724524572.JPG', 'http://www.championscubestore.com/images/s/201608/YXJM05_14724524584.JPG', 'Iw8DgSVUEjU'),
(6, 'YJ monochrome pink Mirror Cube', 80, 170, 4.99, 2, 'YJ', 'http://www.championscubestore.com/images/s/201511/14481694130.jpg', 'http://www.championscubestore.com/images/s/201608/YXJM06_14724524642.JPG', 'Iw8DgSVUEjU'),
(11, 'MoYu House 2x2', 50, 125, 5.99, 15, 'MoYu', 'http://www.championscubestore.com/images/s/201605/14644173300.jpg', 'http://www.championscubestore.com/images/s/201609/1473392168uoB.JPG', NULL),
(12, 'MoYu House 2x2', 50, 125, 5.99, 15, 'MoYu', 'http://www.championscubestore.com/images/s/201609/1473392129iPd.JPG', 'http://www.championscubestore.com/images/s/201609/147339212829G.JPG', NULL),
(13, 'MoYu House 2x2', 50, 125, 5.99, 15, 'MoYu', 'http://www.championscubestore.com/images/s/201609/147339222961F.JPG', 'http://www.championscubestore.com/images/s/201609/1473392231SFr.JPG', NULL),
(14, 'YJ red Apple Cube 3x3 in a moneybox', 70, 137, 5.99, 18, 'YJ', 'http://www.championscubestore.com/images/s/201608/YJAP14_14724518710.jpg', 'http://www.championscubestore.com/images/s/201608/YJAP14_14724518713.jpg', 'gvA0ho_-cvg'),
(21, 'Lanlan two colored cube 7x7x7', 207, 328, 19.99, 20, 'LanLan', 'http://www.championscubestore.com/images/s/201608/LL7X21_14724518181.jpg', 'http://www.championscubestore.com/images/s/201608/LL7X21_14724518184.jpg', '3vCWM7SvZT0'),
(31, 'MoYu 6x6x6 WeiShi GTS White', 164, 204, 36.99, 17, 'MoYu', 'http://www.championscubestore.com/images/s/201611/1478873661BT0.jpg', NULL, 'QZbFUqJT6fY'),
(32, 'MoYu Dianma white for speed-cubing', 53, 83, 9.99, 7, 'MoYu', 'http://www.championscubestore.com/images/s/201405/13995660590.jpg', 'http://www.championscubestore.com/images/s/201405/13995658680.jpg', 'a3o-qaYYyVQ'),
(34, 'MoYu Dianma black for speed-cubing', 56, 83, 9.99, 11, 'MoYu', 'http://www.championscubestore.com/images/s/201405/13995656180.jpg', 'http://www.championscubestore.com/images/s/201405/13995658680.jpg', 'a3o-qaYYyVQ'),
(45, 'MoYu Dianma stickerless version for speed-cubing', 56, 83, 9.99, 5, 'MoYu', 'http://www.championscubestore.com/images/s/201405/13995663870.jpg', 'http://www.championscubestore.com/images/s/201405/13995658680.jpg', 'a3o-qaYYyVQ'),
(48, 'YJ Heart tiled 3x3x3 transparent blue', 78, 110, 6.99, 2, 'YJ', 'http://www.championscubestore.com/images/s/201509/14430019370.jpg', 'http://www.championscubestore.com/images/s/201509/14430019371.jpg', NULL),
(68, 'MoYu 6x6x6 WeiShi GTS Black', 164, 204, 36.99, 5, 'MoYu', 'http://www.championscubestore.com/images/s/201611/14788736268SV.jpg', NULL, 'QZbFUqJT6fY'),
(69, 'YJ Unequal 3x3 rainbow cube', 89, 150, 6.99, 9, 'YJ', 'http://www.championscubestore.com/images/s/201701/1483939362Ubd.JPG', 'http://www.championscubestore.com/images/s/201701/1483939361gEl.JPG', NULL),
(80, 'YJ green Apple Cube 3x3 in a moneybox', 70, 137, 5.99, 9, 'YJ', 'http://www.championscubestore.com/images/s/201608/YJAP04_14724518713.jpg', 'http://www.championscubestore.com/images/s/201608/YJAP04_14724518700.jpg', 'gvA0ho_-cvg'),
(84, 'YJ YuSu R 4x4x4 transparent stickerless', 155, 200, 7.49, 5, 'YJ', 'http://www.championscubestore.com/images/s/201606/14656277250.jpg', 'http://www.championscubestore.com/images/s/201606/14656277251.jpg', NULL),
(88, 'YuXin Cube New 11x11x11 Stickerless Pink', 125, 150, 99.99, 8, 'YuXin', 'http://www.championscubestore.com/images/s/201612/1481372829vba.jpg', 'http://www.championscubestore.com/images/s/201612/1481372724HL9.jpg', 'SI_Gjpt-m1g'),
(101, 'MoYu Dianma primary for speed-cubing', 56, 83, 9.99, 5, 'MoYu', 'http://www.championscubestore.com/images/s/201405/13995662140.jpg', 'http://www.championscubestore.com/images/s/201405/13995658680.jpg', 'a3o-qaYYyVQ'),
(102, 'YuXin Huanglong 10x10x10', 175, 200, 99.99, 10, 'YuXin', 'http://www.championscubestore.com/images/s/201612/1483024999f8i.JPG', 'http://www.championscubestore.com/images/s/201612/14830250027NN.JPG', 'mEWi-mwP9og'),
(114, 'Shengshou Cube 10x10x10 black', 350, 774, 84.99, 25, 'Shengshou', 'http://www.championscubestore.com/images/s/201311/13850516930.jpg', 'http://www.championscubestore.com/images/s/201608/SS1014_14724518980.jpg', 'y98HeOqyHyw'),
(115, 'Shengshou Cube 10x10x10 white', 350, 774, 84.99, 22, 'Shengshou', 'http://www.championscubestore.com/images/s/201608/SS1024_147245195810.jpg', 'http://www.championscubestore.com/images/s/201608/SS1024_14724519583.jpg', 'lwOarRYyojE'),
(116, 'Lanlan 2x2 Fortune Cat', 120, 101, 5.99, 7, 'LanLan', 'http://www.championscubestore.com/images/s/201608/YJZCM01_14724519583.jpg', 'http://www.championscubestore.com/images/s/201401/13891557241.jpg', NULL),
(120, 'YJ Mastermorphix white', 85, 135, 6.49, 3, 'YJ', 'http://www.championscubestore.com/images/s/201305/13691507980.jpg', 'http://www.championscubestore.com/images/s/201305/13691507981.jpg', NULL),
(121, 'YJ Mastermorphix black', 85, 135, 6.49, 12, 'YJ', 'http://www.championscubestore.com/images/s/201606/14660625300.jpg', 'http://www.championscubestore.com/images/s/201606/14660625301.jpg', NULL),
(123, 'Lanlan ZhiSheng 2x2 Panda', 160, 292, 11.99, 13, 'LanLan', 'http://www.championscubestore.com/images/s/201608/14716901920.jpg', 'http://www.championscubestore.com/images/s/201608/YXXM001_14724528827.jpg', NULL),
(146, 'DaYan 4 Lunhui white', 64, 100, 13.99, 12, 'DaYan', 'http://www.championscubestore.com/images/s/201210/13507046620.jpg', 'http://www.championscubestore.com/images/s/201210/13507046631.jpg', NULL),
(245, 'DaYan Pyraminx puzzle white', 110, 240, 14.99, 6, 'DaYan', 'http://www.championscubestore.com/images/s/201506/14345521940.jpg', 'http://www.championscubestore.com/images/s/201506/14345521941.jpg', 'UlWQvi97sG4'),
(258, 'MoYu Aosu 4x4 black', 62, 180, 29.99, 0, 'MoYu', 'http://www.championscubestore.com/images/s/201611/1478873942lwA.jpg', 'http://www.championscubestore.com/images/s/201611/1478873940fDk.jpg', 'a5n1pdHKpkc'),
(297, 'Lanlan 2x2 football', 110, 95, 3.49, 23, 'LanLan', 'http://www.championscubestore.com/images/s/201505/14329134470.jpg', 'http://www.championscubestore.com/images/s/201505/14329134471.jpg', NULL),
(298, 'Lanlan 2x2 football version B', 110, 95, 3.49, 22, 'LanLan', 'http://www.championscubestore.com/images/s/201608/SS2298_14724519831.jpg', 'http://www.championscubestore.com/images/s/201608/SS2298_14724519830.jpg', NULL),
(341, 'DaYan 4 Lunhui red', 64, 108, 13.99, 16, 'DaYan', 'http://www.championscubestore.com/images/s/201210/13507061740.jpg', 'http://www.championscubestore.com/images/s/201210/13507061751.jpg', NULL),
(362, 'MoYu Aosu 4x4 white', 62, 180, 29.99, 13, 'MoYu', 'http://www.championscubestore.com/images/s/201611/1478874000RYh.jpg', 'http://www.championscubestore.com/images/s/201411/14154341960.jpg', 'a5n1pdHKpkc'),
(448, 'DaYan 4 Lunhui green', 64, 104, 13.99, 1, 'DaYan', 'http://www.championscubestore.com/images/s/201407/14066751390.jpg', 'http://www.championscubestore.com/images/s/201407/14066751401.jpg', NULL),
(461, 'Dayan 46mm 2x2 black', 46, 61, 13.99, 7, 'DaYan', 'http://www.championscubestore.com/images/s/201608/DY4621_14724518243.jpg', 'http://www.championscubestore.com/images/s/201608/DY4621_14724518245.jpg', 'Ybd-CxOmh5Y'),
(462, 'Dayan 46mm 2x2 stickerless version', 46, 70, 13.99, 10, 'DaYan', 'http://www.championscubestore.com/images/s/201608/DY4629_14724518265.jpg', 'http://www.championscubestore.com/images/s/201305/13684425761.jpg', 'Ybd-CxOmh5Y'),
(463, 'Dayan 46mm 2x2 white', 46, 61, 13.99, 5, 'DaYan', 'http://www.championscubestore.com/images/s/201608/DY4622_14724518263.jpg', 'http://www.championscubestore.com/images/s/201608/DY4622_14724518261.jpg', 'Ybd-CxOmh5Y'),
(484, 'DaYan Pyraminx puzzle stickerless', 110, 240, 14.99, 9, 'DaYan', 'http://www.championscubestore.com/images/s/201506/14345553080.jpg', 'http://www.championscubestore.com/images/s/201506/14345553091.jpg', 'UlWQvi97sG4'),
(664, 'MoYu 6x6x6 stickerless pink', 69, 217, 36.99, 2, 'MoYu', 'http://www.championscubestore.com/images/s/201608/MY6664_14724520826.jpg', 'http://www.championscubestore.com/images/s/201608/MY6664_14724520828.jpg', NULL),
(714, 'DaYan Pyraminx puzzle black', 110, 240, 14.99, 3, 'DaYan', 'http://www.championscubestore.com/images/s/201506/14345507480.jpg', 'http://www.championscubestore.com/images/s/201506/14345507481.jpg', 'UlWQvi97sG4'),
(748, 'DaYan 4 Lunhui orange', 64, 104, 13.99, 2, 'DaYan', 'http://www.championscubestore.com/images/s/201210/13507150220.jpg', 'http://www.championscubestore.com/images/s/201210/13507150221.jpg', NULL),
(772, 'Lanlan seven colored cube 7x7x7', 215, 325, 21.99, 17, 'LanLan', 'http://www.championscubestore.com/images/s/201608/LL77X2_14724518181.jpg', 'http://www.championscubestore.com/images/s/201608/LL77X2_14724518185.jpg', '3vCWM7SvZT0'),
(991, 'YJ Cube 9x9x9 white', 305, 550, 89.00, 2, 'YJ', 'http://www.championscubestore.com/images/s/201111/13221235541.jpg', 'http://www.championscubestore.com/images/s/201111/13221235530.jpg', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `Marca` varchar(20) NOT NULL,
  `Telefono` int(9) NOT NULL,
  `CorreoElectronico` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`Marca`, `Telefono`, `CorreoElectronico`) VALUES
('DaYan', 917392357, 'dayan@hotmail.com'),
('LanLan', 918958761, 'lanlan@hotmail.com'),
('MoYu', 917399036, 'moyu@hotmail.com'),
('Shengshou', 998535624, 'shengshou@gmail.com'),
('YJ', 917380180, 'yj@hotmail.com'),
('YuXin', 911222356, 'yuxin@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiene`
--

CREATE TABLE `tiene` (
  `ModeloProducto` int(3) NOT NULL,
  `NombreCategoria` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tiene`
--

INSERT INTO `tiene` (`ModeloProducto`, `NombreCategoria`) VALUES
(1, '1X3X3'),
(2, '1X3X3'),
(3, '5X5'),
(4, '5X5'),
(5, 'Variaciones del 3X3'),
(6, 'Variaciones del 3X3'),
(11, 'Variaciones del 2X2'),
(12, 'Variaciones del 2X2'),
(13, 'Variaciones del 2X2'),
(14, 'Variaciones del 3X3'),
(21, '7X7'),
(31, '6X6'),
(32, '3X3'),
(34, '3X3'),
(45, '3X3'),
(48, 'Variaciones del 3X3'),
(68, '6X6'),
(69, 'Variaciones del 3X3'),
(80, 'Variaciones del 3X3'),
(84, '4X4'),
(88, '11X11'),
(101, '3X3'),
(102, '10X10'),
(114, '10X10'),
(115, '10X10'),
(116, 'Variaciones del 2X2'),
(120, 'Mastermorphix'),
(121, 'Mastermorphix'),
(123, 'Variaciones del 2X2'),
(146, '3X3'),
(245, 'Pyraminx'),
(258, '4X4'),
(297, 'Variaciones del 2X2'),
(298, 'Variaciones del 2X2'),
(341, '3X3'),
(362, '4X4'),
(448, '3X3'),
(461, '2X2'),
(462, '2X2'),
(463, '2X2'),
(484, 'Pyraminx'),
(664, '6X6'),
(714, 'Pyraminx'),
(748, '3X3'),
(772, '7X7'),
(991, '9X9');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`Usuario`),
  ADD UNIQUE KEY `CorreoElectronico` (`CorreoElectronico`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`Nombre`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`Usuario`),
  ADD UNIQUE KEY `CorreoElectronico` (`CorreoElectronico`);

--
-- Indices de la tabla `linea`
--
ALTER TABLE `linea`
  ADD PRIMARY KEY (`Id_L`),
  ADD KEY `FK` (`IdPedido_L`),
  ADD KEY `FKEY` (`ModeloProducto_L`);

--
-- Indices de la tabla `lista_de_deseados`
--
ALTER TABLE `lista_de_deseados`
  ADD PRIMARY KEY (`Usuario_Cliente`,`Modelo_de_Producto`),
  ADD KEY `FK_LD_MDP` (`Modelo_de_Producto`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`Id_P`),
  ADD KEY `FKEY_P` (`Usuario_Cliente`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`Modelo`),
  ADD KEY `FKEY` (`MarcaProveedor`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`Marca`),
  ADD UNIQUE KEY `CorreoElectronico` (`CorreoElectronico`),
  ADD UNIQUE KEY `Telefono` (`Telefono`);

--
-- Indices de la tabla `tiene`
--
ALTER TABLE `tiene`
  ADD PRIMARY KEY (`ModeloProducto`,`NombreCategoria`),
  ADD KEY `ModeloProducto` (`ModeloProducto`),
  ADD KEY `FK_T_Nom` (`NombreCategoria`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `linea`
--
ALTER TABLE `linea`
  MODIFY `Id_L` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `Id_P` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `linea`
--
ALTER TABLE `linea`
  ADD CONSTRAINT `FKEY_L_IP` FOREIGN KEY (`IdPedido_L`) REFERENCES `pedido` (`Id_P`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FKEY_L_MP` FOREIGN KEY (`ModeloProducto_L`) REFERENCES `producto` (`Modelo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `lista_de_deseados`
--
ALTER TABLE `lista_de_deseados`
  ADD CONSTRAINT `FK_LD_MDP` FOREIGN KEY (`Modelo_de_Producto`) REFERENCES `producto` (`Modelo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_LD_UC` FOREIGN KEY (`Usuario_Cliente`) REFERENCES `cliente` (`Usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `FKEY_P` FOREIGN KEY (`Usuario_Cliente`) REFERENCES `cliente` (`Usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `FKEY` FOREIGN KEY (`MarcaProveedor`) REFERENCES `proveedor` (`Marca`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tiene`
--
ALTER TABLE `tiene`
  ADD CONSTRAINT `FK_T_M` FOREIGN KEY (`ModeloProducto`) REFERENCES `producto` (`Modelo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_T_Nom` FOREIGN KEY (`NombreCategoria`) REFERENCES `categoria` (`Nombre`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
