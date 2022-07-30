-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema rdass
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema rdass
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `rdass` DEFAULT CHARACTER SET latin1 ;
USE `rdass` ;

-- -----------------------------------------------------
-- Table `rdass`.`Clients931`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `rdass`.`Clients931` (
  `clientId931` INT(11) NOT NULL AUTO_INCREMENT,
  `clientName931` VARCHAR(45) NOT NULL,
  `clientCity931` VARCHAR(45) NOT NULL,
  `clientPassword931` VARCHAR(45) NOT NULL,
  `moneyOwed931` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY USING BTREE (`clientId931`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `rdass`.`POs931`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `rdass`.`POs931` (
  `poNo931` INT(11) NOT NULL AUTO_INCREMENT,
  `clientCompID931` INT(11) NOT NULL,
  `dateOfPO931` DATE NOT NULL,
  `status931` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`poNo931`),
  INDEX `foreign_key` (`clientCompID931` ASC),
  CONSTRAINT `foreign_key`
    FOREIGN KEY (`clientCompID931`)
    REFERENCES `rdass`.`Clients931` (`clientId931`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `rdass`.`Lines931`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `rdass`.`Lines931` (
  `poNo931` INT(11) NOT NULL,
  `lineNo931` INT(11) NOT NULL,
  `partNo931` INT(11) NOT NULL,
  `qty931` INT(11) NOT NULL,
  `priceOrdered931` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY USING BTREE (`poNo931`, `partNo931`),
  CONSTRAINT `Lines931_ibfk_1`
    FOREIGN KEY (`poNo931`)
    REFERENCES `rdass`.`POs931` (`poNo931`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `rdass`.`Parts931`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `rdass`.`Parts931` (
  `partNo931` INT(11) NOT NULL AUTO_INCREMENT,
  `partName931` VARCHAR(45) NOT NULL,
  `currentPrice931` DECIMAL(10,2) NOT NULL,
  `qoh931` INT(11) NOT NULL,
  PRIMARY KEY (`partNo931`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = latin1;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
