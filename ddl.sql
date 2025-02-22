SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE SCHEMA IF NOT EXISTS `bdportalvagas` DEFAULT CHARACTER SET utf8 ;

USE `bdportalvagas` ;

CREATE TABLE IF NOT EXISTS `bdportalvagas`.`usuario` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(1000) NOT NULL,
  `email` VARCHAR(1000) NOT NULL,
  `senha` VARCHAR(1000) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `update_at` DATETIME NULL,
  `deleted_at` DATETIME NULL,
  PRIMARY KEY (`idUsuario`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `bdportalvagas`.`etapa` (
  `idEtapa` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `descricao` TEXT NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`idEtapa`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `bdportalvagas`.`empresa` (
  `idEmpresa` INT NOT NULL,
  `cnpj` CHAR(14) NOT NULL,
  PRIMARY KEY (`idEmpresa`),
  INDEX `fk_empresa_usuario1_idx` (`idEmpresa` ASC) VISIBLE,
  CONSTRAINT `fk_empresa_usuario1`
    FOREIGN KEY (`idEmpresa`)
    REFERENCES `bdportalvagas`.`usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `bdportalvagas`.`vaga` (
  `idVaga` INT NOT NULL AUTO_INCREMENT,
  `etapa_idEtapa` INT NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL,
  `deleted_at` DATETIME NULL,
  `cargo` VARCHAR(1000) NOT NULL,
  `empresa_idEmpresa` INT NOT NULL,
  PRIMARY KEY (`idVaga`),
  INDEX `fk_vaga_status1_idx` (`etapa_idEtapa` ASC) VISIBLE,
  INDEX `fk_vaga_empresa1_idx` (`empresa_idEmpresa` ASC) VISIBLE,
  CONSTRAINT `fk_vaga_status1`
    FOREIGN KEY (`etapa_idEtapa`)
    REFERENCES `bdportalvagas`.`etapa` (`idEtapa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_vaga_empresa1`
    FOREIGN KEY (`empresa_idEmpresa`)
    REFERENCES `bdportalvagas`.`empresa` (`idEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `bdportalvagas`.`situacao` (
  `idSituacao` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `descricao` TEXT NOT NULL,
  PRIMARY KEY (`idSituacao`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `bdportalvagas`.`aluno` (
  `idAluno` INT NOT NULL,
  `cpf` CHAR(11) NOT NULL,
  PRIMARY KEY (`idAluno`),
  INDEX `fk_aluno_usuario1_idx` (`idAluno` ASC) VISIBLE,
  CONSTRAINT `fk_aluno_usuario1`
    FOREIGN KEY (`idAluno`)
    REFERENCES `bdportalvagas`.`usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `bdportalvagas`.`candidatura` (
  `idVaga` INT NOT NULL,
  `aluno_idAluno` INT NOT NULL,
  `curriculo` VARBINARY(5000) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL,
  `deleted_at` DATETIME NULL,
  `situacao_idSituacao` INT NOT NULL,
  PRIMARY KEY (`idVaga`, `aluno_idAluno`),
  INDEX `fk_usuario_has_vaga_vaga1_idx` (`idVaga` ASC) VISIBLE,
  INDEX `fk_candidatura_status1_idx` (`situacao_idSituacao` ASC) VISIBLE,
  INDEX `fk_candidatura_aluno1_idx` (`aluno_idAluno` ASC) VISIBLE,
  CONSTRAINT `fk_usuario_has_vaga_vaga1`
    FOREIGN KEY (`idVaga`)
    REFERENCES `bdportalvagas`.`vaga` (`idVaga`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_candidatura_status1`
    FOREIGN KEY (`situacao_idSituacao`)
    REFERENCES `bdportalvagas`.`situacao` (`idSituacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_candidatura_aluno1`
    FOREIGN KEY (`aluno_idAluno`)
    REFERENCES `bdportalvagas`.`aluno` (`idAluno`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `bdportalvagas`.`egresso` (
  `idEgresso` INT NOT NULL,
  `idEmpresa` INT NOT NULL,
  `cpf` CHAR(11) NOT NULL,
  PRIMARY KEY (`idEgresso`),
  INDEX `fk_egresso_usuario1_idx` (`idEgresso` ASC) VISIBLE,
  INDEX `fk_egresso_empresa1_idx` (`idEmpresa` ASC) VISIBLE,
  CONSTRAINT `fk_egresso_usuario1`
    FOREIGN KEY (`idEgresso`)
    REFERENCES `bdportalvagas`.`usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_egresso_empresa1`
    FOREIGN KEY (`idEmpresa`)
    REFERENCES `bdportalvagas`.`empresa` (`idEmpresa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `bdportalvagas`.`status` (
  `idstatus` INT NOT NULL,
  `nome` VARCHAR(100) NOT NULL,
  `descricao` TEXT NOT NULL,
  PRIMARY KEY (`idstatus`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `bdportalvagas`.`indicacao` (
  `egresso_idEgresso` INT NOT NULL,
  `aluno_idAluno` INT NOT NULL,
  `vaga_idVaga` INT NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NULL,
  `deleted_at` DATETIME NULL,
  `status_idStatus` INT NOT NULL,
  PRIMARY KEY (`egresso_idEgresso`, `aluno_idAluno`, `vaga_idVaga`),
  INDEX `fk_indicacao_aluno1_idx` (`aluno_idAluno` ASC) VISIBLE,
  INDEX `fk_indicacao_vaga1_idx` (`vaga_idVaga` ASC) VISIBLE,
  INDEX `fk_indicacao_status1_idx` (`status_idStatus` ASC) VISIBLE,
  CONSTRAINT `fk_indicacao_egresso1`
    FOREIGN KEY (`egresso_idEgresso`)
    REFERENCES `bdportalvagas`.`egresso` (`idEgresso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_indicacao_aluno1`
    FOREIGN KEY (`aluno_idAluno`)
    REFERENCES `bdportalvagas`.`aluno` (`idAluno`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_indicacao_vaga1`
    FOREIGN KEY (`vaga_idVaga`)
    REFERENCES `bdportalvagas`.`vaga` (`idVaga`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_indicacao_status1`
    FOREIGN KEY (`status_idStatus`)
    REFERENCES `bdportalvagas`.`status` (`idstatus`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `bdportalvagas`.`requisito` (
  `idRequisito` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(1000) NOT NULL,
  `duracao` VARCHAR(1000) NULL,
  PRIMARY KEY (`idRequisito`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `bdportalvagas`.`vaga_requisito` (
  `vaga_idVaga` INT NOT NULL,
  `requisito_idRequisito` INT NOT NULL,
  PRIMARY KEY (`vaga_idVaga`, `requisito_idRequisito`),
  INDEX `fk_vaga_has_requisito_requisito1_idx` (`requisito_idRequisito` ASC) VISIBLE,
  INDEX `fk_vaga_has_requisito_vaga1_idx` (`vaga_idVaga` ASC) VISIBLE,
  CONSTRAINT `fk_vaga_has_requisito_vaga1`
    FOREIGN KEY (`vaga_idVaga`)
    REFERENCES `bdportalvagas`.`vaga` (`idVaga`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_vaga_has_requisito_requisito1`
    FOREIGN KEY (`requisito_idRequisito`)
    REFERENCES `bdportalvagas`.`requisito` (`idRequisito`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
