-- ****************** SqlDBM: MySQL ******************;
-- ***************************************************;


-- ************************************** `astreya`.`user_role`

CREATE TABLE `astreya`.`user_role`
(
 `idRole` int(11) NOT NULL AUTO_INCREMENT ,
 `name`   varchar(45) NOT NULL ,
PRIMARY KEY (`idRole`)
);






-- ************************************** `astreya`.`support_statues`

CREATE TABLE `astreya`.`support_statues`
(
 `idStatus` int(11) NOT NULL AUTO_INCREMENT ,
 `name`     varchar(60) NOT NULL ,
PRIMARY KEY (`idStatus`)
);






-- ************************************** `astreya`.`payment_methods`

CREATE TABLE `astreya`.`payment_methods`
(
 `id`   int(11) NOT NULL AUTO_INCREMENT ,
 `name` varchar(50) NOT NULL ,
PRIMARY KEY (`id`),
UNIQUE KEY `name_uq` (`name`)
);






-- ************************************** `astreya`.`country`

CREATE TABLE `astreya`.`country`
(
 `idCountry` int(11) NOT NULL AUTO_INCREMENT ,
 `name_ru`   varchar(100) NOT NULL ,
 `name_en`   varchar(100) NOT NULL ,
PRIMARY KEY (`idCountry`)
);






-- ************************************** `astreya`.`cities`

CREATE TABLE `astreya`.`cities`
(
 `idCity`   int(11) NOT NULL AUTO_INCREMENT ,
 `name_ru`  varchar(100) NOT NULL ,
 `name_eng` varchar(100) NOT NULL ,
PRIMARY KEY (`idCity`)
);






-- ************************************** `astreya`.`2FA_types`

CREATE TABLE `astreya`.`2FA_types`
(
 `idType` int(11) NOT NULL AUTO_INCREMENT ,
 `name`   varchar(50) NOT NULL ,
PRIMARY KEY (`idType`),
UNIQUE KEY `name_uq` (`name`)
);






-- ************************************** `astreya`.`users`

CREATE TABLE `astreya`.`users`
(
 `idU`          int(11) NOT NULL AUTO_INCREMENT ,
 `email`        varchar(128) NOT NULL ,
 `password`     varchar(255) NOT NULL ,
 `nickname`     varchar(25) NOT NULL ,
 `tag`          int(4) NOT NULL ,
 `spare_email`  varchar(128) NOT NULL ,
 `phone_number` varchar(15) NOT NULL ,
 `birthday`     date NOT NULL ,
 `idRole`       int(11) NOT NULL ,
PRIMARY KEY (`idU`),
UNIQUE KEY `user_uq_data` (`email`, `tag`, `phone_number`),
KEY `fkIdx_87` (`idRole`),
CONSTRAINT `FK_87` FOREIGN KEY `fkIdx_87` (`idRole`) REFERENCES `astreya`.`user_role` (`idRole`)
);






-- ************************************** `astreya`.`users_payment_method`

CREATE TABLE `astreya`.`users_payment_method`
(
 `id`       int(11) NOT NULL AUTO_INCREMENT ,
 `idMethod` int(11) NOT NULL ,
 `idUser`   int(11) NOT NULL ,
PRIMARY KEY (`id`),
KEY `fkIdx_67` (`idMethod`),
CONSTRAINT `FK_67` FOREIGN KEY `fkIdx_67` (`idMethod`) REFERENCES `astreya`.`payment_methods` (`id`),
KEY `fkIdx_70` (`idUser`),
CONSTRAINT `FK_70` FOREIGN KEY `fkIdx_70` (`idUser`) REFERENCES `astreya`.`users` (`idU`)
);






-- ************************************** `astreya`.`support_requests`

CREATE TABLE `astreya`.`support_requests`
(
 `idRequest`    int(11) NOT NULL AUTO_INCREMENT ,
 `opening_date` datetime NOT NULL ,
 `title`        varchar(60) NOT NULL ,
 `content`      text NOT NULL ,
 `closing_date` datetime ,
 `sender`       int(11) NOT NULL ,
 `status`       int(11) NOT NULL ,
PRIMARY KEY (`idRequest`),
KEY `fkIdx_101` (`status`),
CONSTRAINT `FK_101` FOREIGN KEY `fkIdx_101` (`status`) REFERENCES `astreya`.`support_statues` (`idStatus`),
KEY `fkIdx_104` (`sender`),
CONSTRAINT `FK_104` FOREIGN KEY `fkIdx_104` (`sender`) REFERENCES `astreya`.`users` (`idU`)
);






-- ************************************** `astreya`.`shipping_addresses`

CREATE TABLE `astreya`.`shipping_addresses`
(
 `idAddress` int(11) NOT NULL AUTO_INCREMENT ,
 `idU`       int(11) NOT NULL ,
 `full_name` varchar(100) NOT NULL ,
 `address`   text(500) NOT NULL ,
 `apartment` varchar(10) NOT NULL ,
 `idCity`    int(11) NOT NULL ,
 `idCountry` int(11) NOT NULL ,
 `postcode`  varchar(15) NOT NULL ,
PRIMARY KEY (`idAddress`),
KEY `fkIdx_20` (`idU`),
CONSTRAINT `FK_20` FOREIGN KEY `fkIdx_20` (`idU`) REFERENCES `astreya`.`users` (`idU`),
KEY `fkIdx_37` (`idCity`),
CONSTRAINT `FK_37` FOREIGN KEY `fkIdx_37` (`idCity`) REFERENCES `astreya`.`cities` (`idCity`),
KEY `fkIdx_40` (`idCountry`),
CONSTRAINT `FK_40` FOREIGN KEY `fkIdx_40` (`idCountry`) REFERENCES `astreya`.`country` (`idCountry`)
);






-- ************************************** `astreya`.`projects`

CREATE TABLE `astreya`.`projects`
(
 `idProject`       int(11) NOT NULL AUTO_INCREMENT ,
 `name`            varchar(60) NOT NULL ,
 `theme`           varchar(60) NOT NULL ,
 `description`     text NOT NULL ,
 `adult-content`   tinyint(1) NOT NULL ,
 `subscribers`     int(11) NOT NULL ,
 `monthly_income`  int(11) NOT NULL ,
 `income_per_item` int(11) NOT NULL ,
 `total _income`   int(11) NOT NULL ,
 `opening_date`    datetime NOT NULL ,
 `closing_date`    datetime ,
 `profile_photo`   tinyint(1) NOT NULL ,
 `cover_photo`     tinyint(1) NOT NULL ,
 `author`          int(11) NOT NULL ,
PRIMARY KEY (`idProject`),
KEY `fkIdx_80` (`author`),
CONSTRAINT `FK_80` FOREIGN KEY `fkIdx_80` (`author`) REFERENCES `astreya`.`users` (`idU`)
);






-- ************************************** `astreya`.`2FA_users`

CREATE TABLE `astreya`.`2FA_users`
(
 `id`     int(11) NOT NULL AUTO_INCREMENT ,
 `idUser` int(11) NOT NULL ,
 `idType` int(11) NOT NULL ,
 `status` tinyint(1) NOT NULL ,
PRIMARY KEY (`id`),
KEY `fkIdx_51` (`idType`),
CONSTRAINT `FK_51` FOREIGN KEY `fkIdx_51` (`idType`) REFERENCES `astreya`.`2FA_types` (`idType`),
KEY `fkIdx_55` (`idUser`),
CONSTRAINT `FK_55` FOREIGN KEY `fkIdx_55` (`idUser`) REFERENCES `astreya`.`users` (`idU`)
);






-- ************************************** `astreya`.`support_ answers`

CREATE TABLE `astreya`.`support_ answers`
(
 `idAnswer` int(11) NOT NULL AUTO_INCREMENT ,
 `content`  text NOT NULL ,
 `request`  int(11) NOT NULL ,
 `sender`   int(11) NOT NULL ,
PRIMARY KEY (`idAnswer`),
KEY `fkIdx_111` (`request`),
CONSTRAINT `FK_111` FOREIGN KEY `fkIdx_111` (`request`) REFERENCES `astreya`.`support_requests` (`idRequest`),
KEY `fkIdx_114` (`sender`),
CONSTRAINT `FK_114` FOREIGN KEY `fkIdx_114` (`sender`) REFERENCES `astreya`.`users` (`idU`)
);






-- ************************************** `astreya`.`projects_tiers`

CREATE TABLE `astreya`.`projects_tiers`
(
 `idTier`           int(11) NOT NULL AUTO_INCREMENT ,
 `title`            varchar(30) NOT NULL ,
 `price`            int(11) NOT NULL ,
 `description`      text NOT NULL ,
 `limit`            int(5) NOT NULL ,
 `ask_ship_address` tinyint(1) NOT NULL ,
 `project`          int(11) NOT NULL ,
PRIMARY KEY (`idTier`),
KEY `fkIdx_125` (`project`),
CONSTRAINT `FK_125` FOREIGN KEY `fkIdx_125` (`project`) REFERENCES `astreya`.`projects` (`idProject`)
);






-- ************************************** `astreya`.`project_benefits`

CREATE TABLE `astreya`.`project_benefits`
(
 `idBenefit` int(11) NOT NULL AUTO_INCREMENT ,
 `content`   text(500) NOT NULL ,
 `project`   int(11) NOT NULL ,
 `tier`      int(11) NOT NULL ,
PRIMARY KEY (`idBenefit`),
KEY `fkIdx_132` (`project`),
CONSTRAINT `FK_132` FOREIGN KEY `fkIdx_132` (`project`) REFERENCES `astreya`.`projects` (`idProject`),
KEY `fkIdx_135` (`tier`),
CONSTRAINT `FK_135` FOREIGN KEY `fkIdx_135` (`tier`) REFERENCES `astreya`.`projects_tiers` (`idTier`)
);