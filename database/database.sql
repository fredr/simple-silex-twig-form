-- create the database
CREATE DATABASE IF NOT EXISTS `db_programs`;


-- create the table
CREATE TABLE IF NOT EXISTS `db_programs`.`program` (
	`id` int NOT NULL AUTO_INCREMENT,
	`date` date NOT NULL,
	`time` int NOT NULL COMMENT 'Stored as minutes from midnight',
	`leadtext` text NOT NULL,
	`name` varchar(100) NOT NULL,
	`bline` varchar(256) NOT NULL,
	`synopsis` text NOT NULL,
	`url` varchar(256) NOT NULL,
	PRIMARY KEY (`id`)
) DEFAULT CHARACTER SET utf8;