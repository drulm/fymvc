CREATE TABLE IF NOT EXISTS remembered_logins (
  `token_hash` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expires_at` datetime NOT NULL,
  PRIMARY KEY (`token_hash`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS users (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_hash` varchar(64) DEFAULT NULL,
  `password_reset_expires_at` datetime DEFAULT NULL,
  `activation_hash` varchar(64) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_hash` (`password_reset_hash`),
  UNIQUE KEY `activation_hash` (`activation_hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS blog (
  `blog_id` int(11) NOT NULL AUTO_INCREMENT,
  `post` longtext NOT NULL,
  `title` varchar(255) NOT NULL,
  `timestamp` varchar(45) NOT NULL,
  `user_id` int(11) DEFAULT '0',
  PRIMARY KEY (`blog_id`),
  KEY `fk_user_idx` (`user_id`),
  CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
