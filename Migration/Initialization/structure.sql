CREATE TABLE `user` (
  `id_user` INT NOT NULL AUTO_INCREMENT,
  `id_profile` INT NULL,
  `name` VARCHAR(80) NULL,
  `email` VARCHAR(200) NULL,
  `password` VARCHAR(50) NULL,
  `status` TINYINT(1) NULL DEFAULT 1,
  PRIMARY KEY (`id_user`));

CREATE TABLE user_log_login (
      id_user_log_login INT NOT NULL AUTO_INCREMENT,
      id_user INT NULL,
      dateLogin DATETIME NULL DEFAULT NOW(),
      info TEXT NULL,
      PRIMARY KEY (id_user_log_login)
);
