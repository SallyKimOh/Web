CREATE DATABASE cst8285;
GRANT USAGE ON *.* TO cst8285@localhost IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON cst8285.* TO cst8285@localhost;
FLUSH PRIVILEGES;

USE cst8285;

CREATE TABLE wp_eatery(
	firstName VARCHAR(50) NOT NULL,
	lastName VARCHAR(50) NOT NULL,
    email    Varchar(50)   not null,
    phoneNumber varchar(12) not null,
	PRIMARY KEY (email)
	);
