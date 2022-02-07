/*
SQLyog Ultimate v10.42 
MySQL - 5.5.25a : Database - backup
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`backup` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `backup`;

/*Table structure for table `b_ms_pengkajian_awal_medis` */

DROP TABLE IF EXISTS `b_ms_pengkajian_awal_medis`;

CREATE TABLE `b_ms_pengkajian_awal_medis` (
  `1d` int(11) NOT NULL AUTO_INCREMENT,
  `pelayanan_id` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jam` time DEFAULT NULL,
  `anamnesis` varchar(50) DEFAULT NULL,
  `hubungan` varchar(50) DEFAULT NULL,
  `keluhan_utama` varchar(50) DEFAULT NULL,
  `riwayat_ps` varchar(50) DEFAULT NULL,
  `alergi` varchar(50) DEFAULT NULL,
  `tahun` varchar(50) DEFAULT NULL,
  `riwayat_pd` varchar(50) DEFAULT NULL,
  `riwayat_pengobatan` varchar(50) DEFAULT NULL,
  `riwayat_pdk` varchar(50) DEFAULT NULL,
  `riwayat_pekerjaan` varchar(50) DEFAULT NULL,
  `tgl_act` date DEFAULT NULL,
  `user_act` int(11) DEFAULT NULL,
  PRIMARY KEY (`1d`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `b_ms_pengkajian_awal_medis` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
