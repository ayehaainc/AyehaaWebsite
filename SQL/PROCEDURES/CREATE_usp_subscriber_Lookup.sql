use ayehaadb;
DELIMITER //
CREATE PROCEDURE `ayehaadb`.`usp_subscriber_Lookup`
(
	 IN paramEmail VARCHAR(255)
)
BEGIN
	SELECT
		`subscriber`.`Id` AS `Id`,
		`subscriber`.`Email` AS `Email`,
		`subscriber`.`CreateDate` AS `CreateDate`
	FROM `subscriber`
	WHERE 		`subscriber`.`Email` = paramEmail;
END //
DELIMITER ;