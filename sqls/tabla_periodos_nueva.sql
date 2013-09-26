
CREATE  TABLE IF NOT EXISTS `iscwiki`.`periodos` (
  `periodo_id` INT NOT NULL AUTO_INCREMENT,
  `semestre` INT(1) NOT NULL ,
  `periodo` INT(1) NOT NULL ,
  `year` YEAR NOT NULL ,
  `fecha_inicio` TIMESTAMP NOT NULL ,
  `fecha_final` TIMESTAMP NOT NULL ,
  PRIMARY KEY (`periodo_id`) ,
  UNIQUE INDEX `PSA` (`semestre` ASC, `periodo` ASC, `year` ASC) 
  );
