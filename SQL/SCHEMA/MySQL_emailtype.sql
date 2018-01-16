/*
Author:			This code was generated by DALGen version 1.1.0.0 available at https://github.com/H0r53/DALGen 
Date:			1/15/2018
Description:	Creates the emailtype table and respective stored procedures

*/


USE ayehaadb;



-- ------------------------------------------------------------
-- Drop existing objects
-- ------------------------------------------------------------

DROP TABLE IF EXISTS `ayehaadb`.`emailtype`;
DROP PROCEDURE IF EXISTS `ayehaadb`.`usp_emailtype_Load`;
DROP PROCEDURE IF EXISTS `ayehaadb`.`usp_emailtype_LoadAll`;
DROP PROCEDURE IF EXISTS `ayehaadb`.`usp_emailtype_Add`;
DROP PROCEDURE IF EXISTS `ayehaadb`.`usp_emailtype_Update`;
DROP PROCEDURE IF EXISTS `ayehaadb`.`usp_emailtype_Delete`;
DROP PROCEDURE IF EXISTS `ayehaadb`.`usp_emailtype_Search`;


-- ------------------------------------------------------------
-- Create table
-- ------------------------------------------------------------



CREATE TABLE `ayehaadb`.`emailtype` (
Id INT AUTO_INCREMENT,
Name VARCHAR(255),
Description VARCHAR(1025),
CONSTRAINT pk_emailtype_Id PRIMARY KEY (Id)
);


-- ------------------------------------------------------------
-- Create default SCRUD sprocs for this table
-- ------------------------------------------------------------


DELIMITER //
CREATE PROCEDURE `ayehaadb`.`usp_emailtype_Load`
(
	 IN paramId INT
)
BEGIN
	SELECT
		`emailtype`.`Id` AS `Id`,
		`emailtype`.`Name` AS `Name`,
		`emailtype`.`Description` AS `Description`
	FROM `emailtype`
	WHERE 		`emailtype`.`Id` = paramId;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE `ayehaadb`.`usp_emailtype_LoadAll`
()
BEGIN
	SELECT
		`emailtype`.`Id` AS `Id`,
		`emailtype`.`Name` AS `Name`,
		`emailtype`.`Description` AS `Description`
	FROM `emailtype`;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE `ayehaadb`.`usp_emailtype_Add`
(
	 IN paramName VARCHAR(255),
	 IN paramDescription VARCHAR(1025)
)
BEGIN
	INSERT INTO `emailtype` (Name,Description)
	VALUES (paramName, paramDescription);
	-- Return last inserted ID as result
	SELECT LAST_INSERT_ID() as id;
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE `ayehaadb`.`usp_emailtype_Update`
(
	IN paramId INT,
	IN paramName VARCHAR(255),
	IN paramDescription VARCHAR(1025)
)
BEGIN
	UPDATE `emailtype`
	SET Name = paramName
		,Description = paramDescription
	WHERE		`emailtype`.`Id` = paramId;
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE `ayehaadb`.`usp_emailtype_Delete`
(
	IN paramId INT
)
BEGIN
	DELETE FROM `emailtype`
	WHERE		`emailtype`.`Id` = paramId;
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE `ayehaadb`.`usp_emailtype_Search`
(
	IN paramId INT,
	IN paramName VARCHAR(255),
	IN paramDescription VARCHAR(1025)
)
BEGIN
	SELECT
		`emailtype`.`Id` AS `Id`,
		`emailtype`.`Name` AS `Name`,
		`emailtype`.`Description` AS `Description`
	FROM `emailtype`
	WHERE
		COALESCE(emailtype.`Id`,0) = COALESCE(paramId,emailtype.`Id`,0)
		AND COALESCE(emailtype.`Name`,'') = COALESCE(paramName,emailtype.`Name`,'')
		AND COALESCE(emailtype.`Description`,'') = COALESCE(paramDescription,emailtype.`Description`,'');
END //
DELIMITER ;


