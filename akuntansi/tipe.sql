/*
SQLyog Enterprise - MySQL GUI v8.12 
MySQL - 5.1.30-community : Database - simkeu
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`simkeu` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `simkeu`;

/*Table structure for table `m_tipe_jurnal` */

DROP TABLE IF EXISTS `m_tipe_jurnal`;

CREATE TABLE `m_tipe_jurnal` (
  `id_tipe` int(11) DEFAULT NULL,
  `nama_tipe` varchar(15) DEFAULT NULL,
  `korek` bigint(20) DEFAULT NULL,
  `idrek` varchar(15) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `m_tipe_jurnal` */

insert  into `m_tipe_jurnal`(`id_tipe`,`nama_tipe`,`korek`,`idrek`) values (0,'Normal',NULL,NULL),(1,'Kas Out',111020301,'10'),(2,'Bank',111020301,'19');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
