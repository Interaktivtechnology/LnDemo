-- MySQL dump 10.13  Distrib 5.7.12, for osx10.9 (x86_64)
--
-- Host: localhost    Database: bcf
-- ------------------------------------------------------
-- Server version	5.6.23

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Account`
--

DROP TABLE IF EXISTS `Account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Account` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `salesforce_id` char(18) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `FirstName` varchar(255) DEFAULT NULL,
  `LastName` varchar(255) DEFAULT NULL,
  `AccountNumber` varchar(255) DEFAULT NULL,
  `Site` varchar(255) DEFAULT NULL,
  `AccountSource` varchar(255) DEFAULT NULL,
  `AnnualRevenue` varchar(255) DEFAULT NULL,
  `BillingAddress` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Phone` varchar(32) DEFAULT NULL,
  `Rating` varchar(32) DEFAULT NULL,
  `Account_Rating__c` varchar(255) DEFAULT NULL,
  `Avg_Donation_Amt_Curr_FY__c` decimal(10,2) DEFAULT NULL,
  `Email__c` varchar(45) DEFAULT NULL,
  `ID_No__c` varchar(10) DEFAULT NULL,
  `ID_Type__c` varchar(32) DEFAULT NULL,
  `Type_of_Donor__c` varchar(45) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `LastModifiedDate` datetime DEFAULT NULL,
  `AWSStatus` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `SalesforceId_UNIQUE` (`salesforce_id`)
) ENGINE=InnoDB AUTO_INCREMENT=380 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Contact`
--

DROP TABLE IF EXISTS `Contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Contact` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `salesforce_id` char(18) DEFAULT NULL,
  `Account_id` bigint(20) NOT NULL,
  `account_salesforce_id` char(18) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `ID_Type__c` varchar(255) DEFAULT NULL,
  `ID_No__c` varchar(10) DEFAULT NULL,
  `Address` text,
  `Postal_Code` varchar(6) DEFAULT NULL,
  `AWSStatus` varchar(45) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `LastModifiedDate` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `salesforce_id_UNIQUE` (`salesforce_id`),
  UNIQUE KEY `account_salesforce_id_UNIQUE` (`account_salesforce_id`),
  KEY `fk_Contacts_Account_idx` (`Account_id`),
  CONSTRAINT `fk_Contacts_Account` FOREIGN KEY (`Account_id`) REFERENCES `Account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `donation_temp3`
--

DROP TABLE IF EXISTS `donation_temp3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `donation_temp3` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `salesforce_id` char(18) DEFAULT NULL,
  `payment_type` varchar(255) NOT NULL,
  `date_received` date NOT NULL,
  `reference` varchar(45) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `amount` decimal(8,2) NOT NULL DEFAULT '0.00',
  `tax_deductable` varchar(32) DEFAULT NULL,
  `salutation` varchar(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `id_type` varchar(45) DEFAULT NULL,
  `id_no` varchar(255) DEFAULT NULL,
  `valid_nric` tinyint(1) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `postcode` varchar(6) DEFAULT NULL,
  `channel` varchar(45) NOT NULL,
  `imported_date` datetime DEFAULT NULL,
  `event_name` varchar(255) DEFAULT NULL,
  `charity_name` varchar(255) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `trx_id` varchar(128) DEFAULT NULL,
  `sf_upload` tinyint(1) NOT NULL DEFAULT '0',
  `created_date` datetime DEFAULT NULL,
  `last_modified_date` datetime DEFAULT NULL,
  `Account_id` bigint(20) DEFAULT NULL,
  `Contacts_Id` bigint(20) DEFAULT NULL,
  `Bank__c` varchar(255) DEFAULT NULL,
  `Cheque_No__c` varchar(128) DEFAULT NULL,
  `Cheque_Bank__c` varchar(128) DEFAULT NULL,
  `Status__c` varchar(128) DEFAULT NULL,
  `date_cleared` date DEFAULT NULL,
  `data_source` varchar(255) DEFAULT NULL,
  `fees` decimal(8,2) DEFAULT '0.00',
  `gross` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `salesforce_id_UNIQUE` (`salesforce_id`),
  KEY `fk_donation_temp3_Account1_idx` (`Account_id`),
  KEY `fk_donation_temp3_Contacts1_idx` (`Contacts_Id`),
  CONSTRAINT `fk_donation_temp3_Account1` FOREIGN KEY (`Account_id`) REFERENCES `Account` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_donation_temp3_Contacts1` FOREIGN KEY (`Contacts_Id`) REFERENCES `Contact` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary view structure for view `exportaccountsf`
--

DROP TABLE IF EXISTS `exportaccountsf`;
/*!50001 DROP VIEW IF EXISTS `exportaccountsf`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `exportaccountsf` AS SELECT 
 1 AS `Migration_Key`,
 1 AS `SalesforceId`,
 1 AS `ID_Type__c`,
 1 AS `ID_No__c`,
 1 AS `Name`,
 1 AS `BillingStreetAddress`,
 1 AS `BillingPostalCode`,
 1 AS `Country`,
 1 AS `City`,
 1 AS `Email__c`,
 1 AS `Phone`,
 1 AS `DataSource`,
 1 AS `RecordTypeId`,
 1 AS `DonorStatus`,
 1 AS `IsDonor`,
 1 AS `LastDonationDate`,
 1 AS `NumberOfDonationAll`,
 1 AS `AvgDonationAmtAll`,
 1 AS `SerialNumberRef`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `import_log`
--

DROP TABLE IF EXISTS `import_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `import_log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `object` varchar(255) DEFAULT NULL,
  `row` int(11) DEFAULT NULL,
  `file_name` text,
  `error_log` text,
  `ip_address` varchar(128) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mcp_verification`
--

DROP TABLE IF EXISTS `mcp_verification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mcp_verification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(255) DEFAULT NULL,
  `trx_date` datetime DEFAULT NULL,
  `auth_code` varchar(16) DEFAULT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `donation_id` int(11) DEFAULT NULL,
  `response_message` varchar(15) DEFAULT NULL,
  `card_no` varchar(128) DEFAULT NULL,
  `payer_name` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_modified_date` datetime DEFAULT NULL,
  `salesforce_id` char(18) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary view structure for view `vw_cms_data`
--

DROP TABLE IF EXISTS `vw_cms_data`;
/*!50001 DROP VIEW IF EXISTS `vw_cms_data`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vw_cms_data` AS SELECT 
 1 AS `donor_id`,
 1 AS `date_receive`,
 1 AS `payment_type`,
 1 AS `Transaction_No`,
 1 AS `amount`,
 1 AS `status`,
 1 AS `Remarks`,
 1 AS `CategoryName`,
 1 AS `Fund_Type__c`,
 1 AS `Cleared_Date__c`,
 1 AS `Old_Serial_Number`,
 1 AS `fullname`,
 1 AS `occupation`,
 1 AS `dob`,
 1 AS `sex`,
 1 AS `contact`,
 1 AS `address`,
 1 AS `email`,
 1 AS `salutation`,
 1 AS `postal`,
 1 AS `id_nos`,
 1 AS `id_type`,
 1 AS `is_donor`,
 1 AS `is_volunteer`,
 1 AS `country`*/;
SET character_set_client = @saved_cs_client;

--
-- Dumping routines for database 'bcf'
--

--
-- Final view structure for view `exportaccountsf`
--

/*!50001 DROP VIEW IF EXISTS `exportaccountsf`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `exportaccountsf` AS select `a`.`Id` AS `Migration_Key`,`a`.`SalesforceId` AS `SalesforceId`,`a`.`ID_Type__c` AS `ID_Type__c`,`a`.`ID_No__c` AS `ID_No__c`,`a`.`Name` AS `Name`,`a`.`BillingStreetAddress` AS `BillingStreetAddress`,`a`.`BillingPostalCode` AS `BillingPostalCode`,ifnull(`a`.`BillingCountry`,'Singapore') AS `Country`,ifnull(`a`.`BillingCountry`,'Singapore') AS `City`,`a`.`Email__c` AS `Email__c`,`a`.`Phone` AS `Phone`,`a`.`DataSource` AS `DataSource`,if((`a`.`ID_Type__c` = 'UEN'),'012280000001qmeAAA','012280000001qmdAAA') AS `RecordTypeId`,(case when (`a`.`NumberOfDonationAll` = 0) then NULL when (`a`.`NumberOfDonationAll` = 1) then 'New Donor' when (`a`.`NumberOfDonationAll` = 2) then 'Repeat Donor' when (`a`.`NumberOfDonationAll` > 2) then 'Loyal Donor' end) AS `DonorStatus`,if((`a`.`NumberOfDonationAll` = 0),0,1) AS `IsDonor`,ifnull((select `boystown_temp2`.`migration_ipc`.`Date_Received__c` from `boystown_temp2`.`migration_ipc` where (`boystown_temp2`.`migration_ipc`.`AccountId` = `a`.`Id`) order by `boystown_temp2`.`migration_ipc`.`Date_Received__c` desc limit 1),(select `boystown_temp2`.`migration_cms`.`Donation_Date__c` from `boystown_temp2`.`migration_cms` where (`boystown_temp2`.`migration_cms`.`AccountId` = `a`.`Id`) order by `boystown_temp2`.`migration_cms`.`Donation_Date__c` desc limit 1)) AS `LastDonationDate`,`a`.`NumberOfDonationAll` AS `NumberOfDonationAll`,`a`.`AvgDonationAmtAll` AS `AvgDonationAmtAll`,`a`.`DonationAmountAll` AS `SerialNumberRef` from `boystown_temp2`.`migration_account` `a` limit 50000 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vw_cms_data`
--

/*!50001 DROP VIEW IF EXISTS `vw_cms_data`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_cms_data` AS select `a`.`donor_id` AS `donor_id`,`a`.`date_receive` AS `date_receive`,`a`.`payment_type` AS `payment_type`,`a`.`cheque_no` AS `Transaction_No`,`a`.`amount` AS `amount`,`a`.`status` AS `status`,concat('CMS Remarks: ',ifnull(`a`.`remarks`,''),' log:',ifnull(`a`.`logs`,'')) AS `Remarks`,`b`.`name` AS `CategoryName`,`a`.`type_donation` AS `Fund_Type__c`,`a`.`date_clear` AS `Cleared_Date__c`,if((`a`.`receipt_no` = ''),`a`.`id`,`a`.`receipt_no`) AS `Old_Serial_Number`,`c`.`fullname` AS `fullname`,`c`.`occupation` AS `occupation`,`c`.`dob` AS `dob`,`c`.`sex` AS `sex`,`c`.`contact` AS `contact`,concat(`c`.`address`,' ',`c`.`address2`,' ',`c`.`address3`) AS `address`,`c`.`email` AS `email`,`c`.`salutation` AS `salutation`,`c`.`postal` AS `postal`,`c`.`id_nos` AS `id_nos`,`c`.`id_type` AS `id_type`,`c`.`is_donor` AS `is_donor`,`c`.`is_volunteer` AS `is_volunteer`,`c`.`country` AS `country` from ((`boystown`.`donation` `a` join `boystown`.`donation_categories` `b` on((`a`.`category` = `b`.`id`))) join `boystown`.`profile` `c` on((`c`.`id` = `a`.`donor_id`))) order by `a`.`id` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-10-19 12:17:38
