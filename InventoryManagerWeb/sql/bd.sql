-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.24-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para inventorymanager
CREATE DATABASE IF NOT EXISTS `inventorymanager` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `inventorymanager`;

-- Volcando estructura para tabla inventorymanager.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla inventorymanager.categories: ~9 rows (aproximadamente)
DELETE FROM `categories`;
INSERT INTO `categories` (`id`, `name`, `description`, `image`) VALUES
	(1, 'Ordenadores PC y portátiles', 'PC, ordenadores portátiles y convertibles', 'ordenadores.jpg'),
	(2, 'Móviles libres y Smartphones', 'Móviles y smartphones libres.', 'smartphones.jpg'),
	(3, 'Televisores', 'Televisores Smart TV.', 'televisores.jpg'),
	(4, 'Audio, Fotografía y Video', 'Auriculares, cámara réflex, videocámara o altavoces.', 'audio.jpg'),
	(5, 'Periféricos Ordenador', 'Periféricos para ordenador. Monitores, teclados, ratones, altavoces, micrófonos, alfombrillas e impresoras.', 'perifericos.jpg'),
	(6, 'Componentes de PC', 'Componentes para ordenadores. Placas base, procesadores, tarjetas gráficas, memorias RAM, discos duro, ...', 'componentes.jpg'),
	(7, 'Electrodomésticos ', 'Electrodomésticos para el hogar, el jardín y la oficina.', 'electrodomesticos.jpg'),
	(8, 'Consolas, juegos y PC gaming', 'Accesorios gaming para PC. Videoconsolas, juegos y accesorios.', 'consolas.jpg'),
	(9, 'Tablets y Libros electrónicos', 'Tablets, iPad, Ebook o eReader. Accesorios, fundas, carcasas y cargadores.', 'tablets.jpg');

-- Volcando estructura para tabla inventorymanager.products
CREATE TABLE IF NOT EXISTS `products` (
  `id_product` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_category` int(11) unsigned NOT NULL,
  `ref` int(8) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `units` int(5) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id_product`),
  UNIQUE KEY `ref` (`ref`),
  KEY `id_category` (`id_category`),
  CONSTRAINT `id_category` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla inventorymanager.products: ~12 rows (aproximadamente)
DELETE FROM `products`;
INSERT INTO `products` (`id_product`, `id_category`, `ref`, `name`, `description`, `units`, `price`, `image`) VALUES
	(1, 4, 10332877, 'Lenovo IdeaPad 3 15ALC6 AMD Ryzen 7 5700U/16GB/512GB SSD/15.6', 'Justo el rendimiento que necesitas. ¿Buscas un portátil de gama básica lo suficientemente potente para que te ayude a sacar el trabajo adelante? Echa un vistazo al IdeaPad 3 (15, AMD) de 39,62 cm (15,6"). Los últimos procesadores AMD aumentan el rendimiento, te permiten realizar fácilmente varias tareas a la vez y te ofrecen una extraordinaria experiencia de entretenimiento. Los detalles de diseño bien meditados, como el obturador de seguridad físico de la cámara web, completan el producto.', 10, 579.00, '10332877.jpg'),
	(2, 1, 10188918, 'Lenovo IdeaPad 3 15ITL6 Intel Core i3-1115G4/8GB/512GB SSD/15.6"', 'Justo el rendimiento que necesitas. ¿Buscas un portátil de gama básica lo suficientemente potente para que te ayude a sacar el trabajo adelante? Echa un vistazo al IdeaPad 3 (15, Intel) de 39,62 cm (15,6"). Los últimos procesadores Intel® Core™ de 11.ª generación aumentan el rendimiento, te permiten realizar fácilmente varias tareas a la vez y te ofrecen una extraordinaria experiencia de entretenimiento. Los detalles de diseño bien meditados, como el obturador de seguridad físico de la cámara web, completan el producto.', 0, 349.00, '10188918.jpg'),
	(3, 1, 10347902, 'HP Victus 16-e0090ns AMD Ryzen 7 5800H/16GB/512GB SSD/RTX 3050Ti/16.1"', 'Gracias a un procesador AMD, el portátil Victus by HP de 16,1 pulgadas cuenta con todas las características que necesitas para jugar y utilizarlo en tu día a día. Consigue más flexibilidad al jugar con un teclado para videojuegos polivalente y disfruta de una pantalla con frecuencia de actualización y sin tearing. Supera el acaloramiento de cada partida gracias a un sistema de refrigeración que evita el sobrecalentamiento. Gana experiencia de juego más allá de tu hardware con OMEN Gaming Hub.', 10, 869.00, '10347902.jpg'),
	(4, 2, 10191359, 'Apple iPhone 13 256GB Verde Alpino Libre', 'Prodigioso Pro. Un sistema de cámaras revolucionario.  Una pantalla con una respuesta tan fluida que cada toque parece magia. El chip más rápido que jamás ha tenido un móvil. Una resistencia extraordinaria. Y la mayor autonomía en un iPhone. Es todo un Pro.', 1, 959.00, '10191359.jpg'),
	(5, 2, 10358177, 'Samsung Galaxy M13 Libre Verde 4 GB RAM 128 GB', 'Samsung Galaxy M13 combina un procesador Exynos 850 (8nm) Octa-core de 2.0GHz con una memoria RAM de 4 GB para que puedas disfrutar con mayor eficiencia tus aplicaciones y videojuegos.', 5, 189.00, '10358177.jpg'),
	(6, 2, 585662, 'Realme GT Master 8GB 5G Libre Gris 8 GB RAM 256 GB', 'La vida consiste en explorar. Explorar el mundo y a uno mismo. Cada interacción con el mundo es una aventura.', 3, 380.00, '585662.jpg'),
	(7, 2, 10217930, 'Xiaomi Redmi 10C 4/128GB Azul Libre', 'Redmi 10C está equipado con un procesador Snapdragon® 680 con memoria UFS ultrarrápida, una cámara principal de alta resolución de 50MP y cámara para selfies de 5MP, pantalla inmersiva Dot Drop de 6,71", altavoz potente con sonido vibrante, batería de alta capacidad de 5000 mAh (típica) y soporta carga rápida de 18W.', 1, 153.00, '10217930.jpg'),
	(8, 2, 10197438, 'Realme Narzo 50 4/128GB Azul Libre', 'El nuevo smartphone Narzo 50 de realme tiene una pantalla de 6,6 pulgadas de 120 Hz, 4GB de RAM y 128 GB de almacenamiento interno, una cámara principal de 50 MP y una batería de 5000 mAh con carga rápida SuperDat 33W.', 8, 179.00, '10197438.jpg'),
	(9, 2, 585663, 'Realme 8i 4/64GB Negro Libre', 'realme 8i es el compañero de juego perfecto para ti con su potente procesador MediaTek Helio G96. Este procesador cuenta con ocho potentes núcleos que, sumados a sus 4GB de RAM, proporcionarán una fluidez y funcionamiento perfectos en su gran pantalla de 6.6" y 120Hz.', 0, 159.00, '585663.jpg'),
	(10, 2, 10312728, 'Xiaomi Redmi 10 2022 4/128GB Gris Libre', 'El nuevo Xiaomi Redmi 10 (2022) tiene cuádruple cámara AI de 50MP, altavoces duales, pantalla AdaptativeSync de 6.5" FHD+ DotDisplay de 90Hz, procesador MediaTek Helio G88 de ocho núcleos hasta 2.0GHz y batería de alta capacidad de 5000mAh con carga rápida de 18W.', 6, 179.00, '10312728.jpg'),
	(11, 2, 10581317, 'Apple iPhone 14 Pro Max 256GB Plata Libre', 'Llega a tus manos una forma mágica de utilizar el iPhone, combinada con prestaciones de seguridad pensadas para salvar vidas. Y una espectacular cámara de 48 Mpx que consigue un nivel de detalle descomunal. Todo bajo el control del chip más avanzado en un smartphone. ¿Lo ves? Es que no se puede ser más Pro.', 1, 2000.00, '10581317.jpg'),
	(12, 2, 10295183, 'Samsung Galaxy S22 Ultra 5G 12/256GB Negro Libre', 'Samsung Galaxy S22 Ultra 5G. Un nuevo épico estándar para cada momento en tu vida, con pantalla Dynamic AMOLED x2 de 6.8" QHD+, 5 cámaras de alta resolución y calidad profesional, un procesador todopoderoso de solo 4 nm y un atrevido diseño Premium con 4 nuevos colores. Galaxy S22 Ultra 5G es el primer Galaxy S en incluir el S Pen de manera gratuita en a caja.', 1, 1175.00, '10295183.jpg');

-- Volcando estructura para tabla inventorymanager.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(240) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- Volcando datos para la tabla inventorymanager.usuarios: ~2 rows (aproximadamente)
DELETE FROM `usuarios`;
INSERT INTO `usuarios` (`id`, `email`, `contrasena`) VALUES
	(1, 'user@gmail.com', '$2y$10$9ek64/1jkocZGBTijTe74ug7gGM2ZQd6uj1VrOjdjmqPN9n.MbDIO'),
	(2, 'teacher@gmail.com', '$2y$10$HQOoUR6gB7he3AAgzrDQ7eYCqaF5b3iBePhenlQtH2Xyx0Dj/xBkm');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
