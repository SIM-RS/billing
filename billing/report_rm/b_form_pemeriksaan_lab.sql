/*
SQLyog Ultimate v9.63 
MySQL - 5.0.67-community : Database - billing_tangerang_1
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `b_form_pemeriksaan_lab` */

DROP TABLE IF EXISTS `b_form_pemeriksaan_lab`;

CREATE TABLE `b_form_pemeriksaan_lab` (
  `id` bigint(11) NOT NULL auto_increment,
  `pelayanan_id` int(11) default NULL,
  `kunjungan_id` int(11) default NULL,
  `no_formulir` int(11) default NULL,
  `tgl_terima` date default NULL,
  `jam_terima` time default NULL,
  `isi` varchar(400) default NULL,
  `tgl_act` date default NULL,
  `user_act` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

/*Data for the table `b_form_pemeriksaan_lab` */

insert  into `b_form_pemeriksaan_lab`(`id`,`pelayanan_id`,`kunjungan_id`,`no_formulir`,`tgl_terima`,`jam_terima`,`isi`,`tgl_act`,`user_act`) values (12,6,2,8,'2013-11-11','14:44:48','1,2,3,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,168,,,,172,,,,,,,,,,182,,184,,186,','2013-11-11',0),(13,6,2,90,'2013-11-11','14:44:48',',,,,5,,,8,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,179,,181,,,,185,186,','2013-11-11',0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
