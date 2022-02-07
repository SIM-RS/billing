/*
SQLyog - Free MySQL GUI v5.02
Host - 5.0.22-community-nt : Database - dbapotik
*********************************************************************
Server version : 5.0.22-community-nt
*/


create database if not exists `dbapotik`;

USE `dbapotik`;

SET FOREIGN_KEY_CHECKS=0;

/*Table structure for table `a_produksi` */

DROP TABLE IF EXISTS `a_produksi`;

CREATE TABLE `a_produksi` (
  `idproduksi` bigint(20) unsigned NOT NULL auto_increment,
  `id_lama` bigint(20) unsigned NOT NULL,
  `id_baru` bigint(20) unsigned NOT NULL,
  `qty_lama` double default '0',
  `tgl` date default NULL,
  `tgl_act` datetime default NULL,
  PRIMARY KEY  (`idproduksi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `a_produksi` */

SET FOREIGN_KEY_CHECKS=1;
