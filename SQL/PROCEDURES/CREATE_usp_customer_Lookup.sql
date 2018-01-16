use ayehaadb;
DELIMITER //
CREATE PROCEDURE `ayehaadb`.`usp_customer_Lookup`
(
	IN paramEmail VARCHAR(255)
)
BEGIN
  SELECT
	  `customer`.`Id` AS `Id`,
		`customer`.`FirstName` AS `FirstName`,
		`customer`.`LastName` AS `LastName`,
		`customer`.`Email` AS `Email`,
		`customer`.`Password` AS `Password`,
		`customer`.`CreateDate` AS `CreateDate`
	FROM `customer`
	WHERE 		`customer`.`Email` = paramEmail;
END //
DELIMITER ;