CREATE TABLE IF NOT EXISTS `clients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `company_name` varchar(50),
  `inn` varchar(50),
  `address` varchar(50),
  `email` varchar(50),
  `phone` varchar(50),
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `docs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `load_id` int,
  `name` int,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `loads` (
  `id` int NOT NULL AUTO_INCREMENT,
  `container` varchar(50),
  `client` int,
  `manager` int,
  `timestamp` timestamp,
  `status` int,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `managers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `surname` varchar(50),
  `name` varchar(50),
  `email` varchar(50),
  `phone` varchar(50),
  PRIMARY KEY (`id`)
);
