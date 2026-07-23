-- Database Structure for ProTec General Insurance

CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Default password is 'admin123'
INSERT IGNORE INTO `admin_users` (`id`, `username`, `password_hash`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

CREATE TABLE IF NOT EXISTS `contact_leads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(150) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL,
  `insurance_type` varchar(100) DEFAULT NULL,
  `message` text,
  `whatsapp_consent` tinyint(1) NOT NULL DEFAULT '0',
  `promo_consent` tinyint(1) NOT NULL DEFAULT '0',
  `is_contacted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
