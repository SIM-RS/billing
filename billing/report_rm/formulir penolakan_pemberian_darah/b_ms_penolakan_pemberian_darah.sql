/*
SQLyog Ultimate v10.42 
MySQL - 5.5.16 : Database - billing_tangerang
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`billing_tangerang` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `billing_tangerang`;

/*Table structure for table `b_ms_penolakan_pemberian_darah` */

DROP TABLE IF EXISTS `b_ms_penolakan_pemberian_darah`;

CREATE TABLE `b_ms_penolakan_pemberian_darah` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `pelayanan_id` int(12) DEFAULT NULL,
  `nama1` varchar(100) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `umur` int(11) DEFAULT NULL,
  `jenis_kelamin` varchar(30) DEFAULT NULL,
  `alamat` text,
  `no_telp` varchar(20) DEFAULT NULL,
  `no_ktp` varchar(50) DEFAULT NULL,
  `hubungan` varchar(100) DEFAULT NULL,
  `sehingga` text,
  `alasan` text,
  `tgl` date DEFAULT NULL,
  `jam` time DEFAULT NULL,
  `saksi1` varchar(100) DEFAULT NULL,
  `saksi2` varchar(100) DEFAULT NULL,
  `tgl_act` date DEFAULT NULL,
  `user_act` int(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `b_ms_penolakan_pemberian_darah` */

insert  into `b_ms_penolakan_pemberian_darah`(`id`,`pelayanan_id`,`nama1`,`tgl_lahir`,`umur`,`jenis_kelamin`,`alamat`,`no_telp`,`no_ktp`,`hubungan`,`sehingga`,`alasan`,`tgl`,`jam`,`saksi1`,`saksi2`,`tgl_act`,`user_act`) values (1,6,'tes','1985-02-06',28,'Laki-Laki','jalan jalan','081567456781','24876182476861','Wali',',2,,,','alasan','1995-11-17','13:30:59','saksi1','saksi2','2013-11-27',372);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
