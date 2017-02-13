CREATE TABLE IF NOT EXISTS #__gencell_user_type (
  id INT NOT NULL AUTO_INCREMENT,
  user_type VARCHAR(45) NOT NULL,
  PRIMARY KEY (id))
ENGINE = InnoDB;
CREATE TABLE IF NOT EXISTS #__gencell_doc_type (
  id INT NOT NULL AUTO_INCREMENT,
  doc_type VARCHAR(32) NOT NULL,
  PRIMARY KEY (id))
ENGINE = InnoDB;
CREATE TABLE IF NOT EXISTS #__gencell_user (
  user_id INT NOT NULL,
  documento VARCHAR(16) NOT NULL,
  doc_type_id INT NOT NULL,
  direccion VARCHAR(128) NOT NULL,
  telefono VARCHAR(45) NOT NULL,
  nombre VARCHAR(400) NOT NULL,
  user_type_id INT NOT NULL,
  PRIMARY KEY (user_id),
  UNIQUE INDEX uk_documento (documento ASC),
  INDEX in_gencell_type (user_type_id ASC),
  INDEX in_gencell_doc_type (doc_type_id ASC),
  CONSTRAINT fk_gencell_user_type
    FOREIGN KEY (user_type_id)
    REFERENCES #__gencell_user_type (id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT fk_gencell_doc_type
    FOREIGN KEY (doc_type_id)
    REFERENCES #__gencell_doc_type (id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;
CREATE TABLE IF NOT EXISTS #__gencell_enterprise (
  id INT NOT NULL,
  nit VARCHAR(32) NOT NULL,
  nombre VARCHAR(256) NOT NULL,
  PRIMARY KEY (id))
ENGINE = InnoDB;
CREATE TABLE IF NOT EXISTS #__gencell_position (
  id INT NOT NULL AUTO_INCREMENT,
  position VARCHAR(32) NOT NULL,
  PRIMARY KEY (id))
ENGINE = InnoDB;
CREATE TABLE IF NOT EXISTS #__gencell_employee (
  enterprise_id INT NOT NULL,
  user_id INT NOT NULL,
  position_id INT NOT NULL,
  INDEX in_gencell_user_em (user_id ASC),
  INDEX in_gencell_enterprise_em (enterprise_id ASC),
  INDEX in_gencell_position_em (position_id ASC),
  PRIMARY KEY (enterprise_id, user_id, position_id),
  CONSTRAINT fk_gencell_user_em
    FOREIGN KEY (user_id)
    REFERENCES #__gencell_user (user_id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT fk_gencell_enterprise_em
    FOREIGN KEY (enterprise_id)
    REFERENCES #__gencell_enterprise (id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT fk_gencell_position_em
    FOREIGN KEY (position_id)
    REFERENCES #__gencell_position (id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;
CREATE TABLE IF NOT EXISTS #__gencell_result (
  id INT NOT NULL AUTO_INCREMENT,
  user_id INT NOT NULL,
  upload_date DATETIME NOT NULL,
  path VARCHAR(1024) NOT NULL,
  petitioner_id INT NULL,
  PRIMARY KEY (id),
  INDEX in_gencell_user_re (user_id ASC),
  INDEX in_gencell_enterprise_re (petitioner_id ASC),
  CONSTRAINT fk_gencell_user_re
    FOREIGN KEY (user_id)
    REFERENCES #__gencell_user (user_id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT fk_gencell_enterprise_re
    FOREIGN KEY (petitioner_id)
    REFERENCES #__gencell_enterprise (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
CREATE TABLE IF NOT EXISTS #__gencell_usrseq (
  `id` INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;