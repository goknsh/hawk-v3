CREATE TABLE `users`(
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(3072) NOT NULL,
    `name` VARCHAR(3072) NOT NULL,
    `email_verified` VARCHAR(3072) NOT NULL,
    `password` VARCHAR(3072) NOT NULL,
    PRIMARY KEY(`id`),
    UNIQUE KEY `email`(`email`)
) ENGINE = InnoDB DEFAULT CHARSET = latin1;