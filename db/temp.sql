/*
SQLyog Community Edition- MySQL GUI v6.15
MySQL - 5.5.5-10.1.21-MariaDB : Database - project100
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

create database if not exists `project100`;

USE `project100`;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `law_essay_issues` */

DROP TABLE IF EXISTS `law_essay_issues`;

CREATE TABLE `law_essay_issues` (
  `essay_issue_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `issue_id` int(11) DEFAULT NULL,
  `comments` text,
  `sorting` int(11) NOT NULL DEFAULT '0',
  `essay_id` int(11) DEFAULT NULL,
  `statementHint` text,
  PRIMARY KEY (`essay_issue_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `law_essay_issues` */

insert  into `law_essay_issues`(`essay_issue_id`,`user_id`,`issue_id`,`comments`,`sorting`,`essay_id`,`statementHint`) values (1,1,1,'The rights and remedies of the parties depend on whether or not there was a valid contract. A contract is a promise or set of promises the performance of which the law will recognize as a duty and for which the law will provide a remedy. ',1,3,NULL),(2,1,2,'UCC Article 2 governs contracts for sale of GOODS, movable things at the time of identification to the contract. Otherwise, only COMMON LAW governs the contract. \r\n\r\nHere the contract does not concern a sale of movable things because it is for the \"rent\" of a \"house\". \r\n\r\nTherefore, only COMMON LAW principles govern this contract.',2,3,'She advertised in the newspaper to find a renter, citing rent of $700 a month.'),(3,1,3,'Under the STATUTE OF FRAUDS certain types of contract must be in writing to be enforced. A contract for conveyance of an interest in LAND often requires a writing, but not leaseholds of a year or less.\r\n\r\nHere the question involves conveyance of an interest in land because the alleged agreement was to rent a \"house\", but this appears to be a month-month rental.\r\n\r\nTherefore, a writing would not generally be required. ',3,3,'citing rent of $700 a month. \r\n'),(4,1,4,'Under contract law an OFFER is a manifestation of present intent to enter into a bargain communicated to the offeree and sufficiently specific that an observer would reasonably believe assent would form a bargain. Advertisements are generally not offers because they usually fail to identity the parties or the quantity being offered. \r\n\r\nHere the advertisement was not specific as to the parties because it did not guarantee that Lucy would rent to the first person to respond. \r\n\r\nTherefore, the advertisement was not an offer. ',4,3,' She advertised in the newspaper to find a renter, citing rent of $700 a month. '),(5,1,5,'Was the 9:00 statement by Homer an OFFER?\r\n\r\nOffer is defined supra\r\n\r\nHere the statement by Homer did not appear to manifest intent to enter into a bargain because even though he said, \"I accept\" he added that he \"had to see the house first\". No reasonable person would believe assent to that statement would form a bargain because it was clear he wanted to \"see the house first\". \r\n\r\nTherefore the statement was not an offer. \r\n\r\nWas the 9.00 response by Lucy an OFFER?\r\n\r\nOffer is defined supra\r\n\r\nHere the statement by Lucy did manifest intent to enter into a bargain because she said \"It\'s a deal, I will rent to you for $550.\" A reaonable person would believe assent to that statment would form a bargain.\r\n\r\nTherefore that statement was an offer.',5,3,'I have to see the house.\r\nLucy said, â€œIt\'s a deal. I will rent to you for $550.\"'),(6,1,6,'Offer is defined supra. Under common law an OPTION is a contractual agreement that an offeror will not revoke an offer for a specific period of time in exchange for CONSIDERATION from the offeree. CONSIDERATION is an exchange of promises posing legal detriment such that the law deems it sufficient to support an agreement. \r\n\r\nHere Lucy promised to give a \"firm offer\", but Homer gave no promise or value in exchange. While the UCC provides for \"firm offers\" from merchants, the UCC does not govern here. Therefore, Lucy received no legal consideration in exchange for her promise to give a \"firm offer\" and her promise cannot be enforced against her as an option contract.\r\n\r\nTherefore, Lucy\'s offer did not create an option contract, and she could revoke her offer at any time.',6,3,'Lucy said, â€œIt\'s a deal. I will rent to you for $550. This is a firm offer.â€ ');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
