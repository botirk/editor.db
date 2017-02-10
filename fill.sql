CREATE DATABASE `test_shop` DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;

CREATE USER 'test_shop_php'@'localhost' IDENTIFIED BY 'test_shop_pw';
GRANT SELECT,INSERT,UPDATE,DELETE ON `test_shop`.* TO 'test_shop_php'@'localhost';

USE `test_shop`;

CREATE TABLE Category (
	id INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(id),
	parent INT,
	FOREIGN KEY(parent) REFERENCES Category(id),
	name CHAR(50) NOT NULL
);

INSERT INTO Category VALUE (DEFAULT,DEFAULT,'Автобусы');
INSERT INTO Category VALUE (DEFAULT,DEFAULT,'Тролейбусы');

CREATE TABLE Position (
	id INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(id),
	price DECIMAL(6,2) NOT NULL,
	description TEXT(300),
	category INT NOT NULL,
	FOREIGN KEY(category) REFERENCES Category(id)
);

CREATE TABLE User (
	id INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(id),
	email CHAR(80) NOT NULL,
	email_confirmed BOOL NOT NULL,
	pw CHAR(50) NOT NULL
);

CREATE TABLE UserOrder (
	id INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(id),
	user INT NOT NULL,
	FOREIGN KEY(user) REFERENCES User(id),
	csv TEXT(300) NOT NULL
);
