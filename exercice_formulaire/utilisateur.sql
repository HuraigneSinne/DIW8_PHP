CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `email` varchar(250) DEFAULT NULL,
  `gender`varchar(1) DEFAULT NULL,
  `birthdate` DATE DEFAULT NULL,
  `phone` varchar(15),
  `mail_subscribe` tinyint(1) DEFAULT 0,
  `phone_subscribe` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;