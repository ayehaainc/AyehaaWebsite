use ayehaadb;
DELIMITER //
CREATE PROCEDURE `ayehaadb`.`usp_securityuser_Lookup`
(
	IN paramUsername VARCHAR(255)
)
BEGIN
  SELECT
			`securityuser`.`Id` AS `Id`,
		`securityuser`.`Username` AS `Username`,
		`securityuser`.`Password` AS `Password`,
		`securityuser`.`Email` AS `Email`,
		`securityuser`.`RoleId` AS `RoleId`,
		`securityuser`.`CreateDate` AS `CreateDate`
	FROM `securityuser`
	WHERE 		`securityuser`.`Username` = paramUsername;
END //
DELIMITER ;