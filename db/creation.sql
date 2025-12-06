CREATE DATABASE IF NOT EXISTS khattarnelli_db;
USE khattarnelli_db;

-- Tabla: productos
DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos iniciales
INSERT INTO `productos` (`id`, `nombre`, `precio`, `descripcion`, `imagen`, `created_at`, `updated_at`) VALUES
(1, 'Chocolate Premium Khatarnelli 70% Cacao', 5.99, 'Chocolate artesanal 70% cacao en barra de 120g.', 'images/productos/chocolate70.png', '2025-12-01 16:44:21', '2025-12-01 16:44:21');


-- Tabla: pedidos
DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE `pedidos` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `total` decimal(20,6) NOT NULL,
  `costo_envio` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tipo_envio` varchar(20) NOT NULL DEFAULT 'normal',
  `productos` varchar(200) NOT NULL,
  `ubicacion` varchar(100) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `metodo_de_pago` varchar(50) NOT NULL,
  `estado` enum('pendiente','enviado','cancelado','completado') NOT NULL DEFAULT 'pendiente',
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `transaction_id` varchar(150) DEFAULT NULL,
  `payment_gateway` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Datos iniciales
INSERT INTO `pedidos` VALUES
(1,'juan',100.980000,89.00,'economico','{\"1\":{\"id\":1,\"nombre\":\"Chocolate Premium Khatarnelli 70% Cacao\",\"precio\":5.99,\"imagen\":\"images\\/productos\\/chocolate70.png\",\"cantidad\":2}}','calle 72 #38','test@test.com','3152556478','paypal','completado','2025-12-03 15:54:36','2025-12-03 20:54:36','2025-12-03 20:54:36','PAYID-NEYKG3A5020964310825600U','paypal');


-- Tabla: detalle_pedido
DROP TABLE IF EXISTS `detalle_pedido`;
CREATE TABLE `detalle_pedido` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `pedido_id` int(20) unsigned NOT NULL,
  `producto_id` int(11) unsigned NOT NULL,
  `cantidad` int(10) unsigned NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pedido_id` (`pedido_id`),
  KEY `detalle_producto_fk` (`producto_id`),
  CONSTRAINT `detalle_pedido_pedido_fk` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `detalle_producto_fk` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Tabla: usuarios
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `passw` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;