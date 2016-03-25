-- Copiando estrutura para tabela imobiliaria.ll_contato
CREATE TABLE `ll_contato` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`nome` VARCHAR(255) NOT NULL,
	`Host` VARCHAR(255) NOT NULL,
	`SMTPAuth` ENUM('true','false') NOT NULL DEFAULT 'false',
	`Port` VARCHAR(255) NULL DEFAULT NULL,
	`SMTPSecure` ENUM('tls','ssl') NULL DEFAULT NULL,
	`Username` VARCHAR(255) NOT NULL,
	`Password` VARCHAR(255) NOT NULL,
	`form` TEXT NOT NULL,
	`css` TEXT NOT NULL,
	PRIMARY KEY (`id`)
)ENGINE=InnoDB;



-- Copiando estrutura para tabela imobiliaria.ll_contato_email
CREATE TABLE `ll_contato_email` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`contato` INT(11) NOT NULL,
	`asunto` VARCHAR(255) NOT NULL,
	`emisorNome` VARCHAR(255) NOT NULL,
	`emisorEmail` VARCHAR(255) NOT NULL,
	`destinatarioNome` VARCHAR(255) NOT NULL,
	`destinatarioEmail` VARCHAR(255) NOT NULL,
	`mensagem` TEXT NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `email_conatato` (`contato`),
	CONSTRAINT `ll_FK_email_conatato` FOREIGN KEY (`contato`) REFERENCES `ll_contato` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=InnoDB;



-- Copiando estrutura para tabela imobiliaria.ll_contato_input
CREATE TABLE `ll_contato_input` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`contato` INT(11) NOT NULL,
	`nome` VARCHAR(255) NOT NULL,
	`preenchimento` VARCHAR(255) NOT NULL,
	`tipo` ENUM('input','textarea','button') NOT NULL DEFAULT 'input',
	`referencia` VARCHAR(255) NOT NULL,
	`class` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `input_contato` (`contato`),
	CONSTRAINT `ll_FK_input_contato` FOREIGN KEY (`contato`) REFERENCES `ll_contato` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=InnoDB;