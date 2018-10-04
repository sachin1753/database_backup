

CREATE DATABASE `project_management` /*!40100 DEFAULT CHARACTER SET latin1 */;

CREATE TABLE `clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;


INSERT INTO clients VALUES
("1","Client1"),
("2","Client2"),
("3","Client3"),
("4","Client4"),
("5","Client5");

CREATE DATABASE `project_management` /*!40100 DEFAULT CHARACTER SET latin1 */;

CREATE TABLE `projects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `client_id` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;


INSERT INTO projects VALUES
("1","1","Project1"),
("2","1","Project2"),
("3","1","Project3"),
("4","2","Project4"),
("5","2","Project5"),
("6","3","Project6"),
("7","4","Project1"),
("8","4","Project2"),
("9","5","Project7"),
("10","5","Project8");

CREATE DATABASE `project_management` /*!40100 DEFAULT CHARACTER SET latin1 */;

CREATE TABLE `time_tracking` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `time` double DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  CONSTRAINT `project_id` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

