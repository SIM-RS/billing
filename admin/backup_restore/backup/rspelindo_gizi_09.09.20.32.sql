DROP TABLE gz_jadwal_menu;

CREATE TABLE `gz_jadwal_menu` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tgl` date DEFAULT NULL,
  `pasiso` tinyint(1) unsigned DEFAULT '1' COMMENT '1=pagi,2=siang,3=sore',
  `ms_menu_jenis_id` bigint(20) DEFAULT '0',
  `ms_komp_menu_id` bigint(20) unsigned DEFAULT '0',
  `qty` double unsigned DEFAULT '1',
  `ms_unit_id` bigint(20) unsigned DEFAULT '0',
  `user_act` bigint(20) unsigned DEFAULT '0',
  `tgl_act` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=latin1;

INSERT INTO gz_jadwal_menu VALUES("1","2012-12-17","1","1","8","1","1","732","2012-12-17 16:23:48");
INSERT INTO gz_jadwal_menu VALUES("2","2012-12-17","1","1","9","1","1","732","2012-12-17 16:23:48");
INSERT INTO gz_jadwal_menu VALUES("3","2012-12-17","1","1","10","1","1","732","2012-12-17 16:23:48");
INSERT INTO gz_jadwal_menu VALUES("63","2012-12-21","1","1","8","1","1","732","2012-12-28 16:14:53");
INSERT INTO gz_jadwal_menu VALUES("64","2012-12-21","1","1","17","1","1","732","2012-12-28 16:14:53");
INSERT INTO gz_jadwal_menu VALUES("65","2012-12-21","1","1","77","1","1","732","2012-12-28 16:14:53");
INSERT INTO gz_jadwal_menu VALUES("66","2012-12-21","1","3","9","1","2","732","2012-12-28 16:14:53");
INSERT INTO gz_jadwal_menu VALUES("67","2012-12-21","1","3","89","1","2","732","2012-12-28 16:14:53");
INSERT INTO gz_jadwal_menu VALUES("68","2012-12-21","1","3","91","1","2","732","2012-12-28 16:14:53");
INSERT INTO gz_jadwal_menu VALUES("69","2012-12-21","1","3","7","1","3","732","2012-12-28 16:14:53");
INSERT INTO gz_jadwal_menu VALUES("70","2012-12-21","1","3","10","1","3","732","2012-12-28 16:14:53");
INSERT INTO gz_jadwal_menu VALUES("71","2012-12-21","1","3","12","1","3","732","2012-12-28 16:14:53");
INSERT INTO gz_jadwal_menu VALUES("72","2012-12-21","1","3","237","1","3","732","2012-12-28 16:14:53");
INSERT INTO gz_jadwal_menu VALUES("73","2012-12-21","1","1","7","1","4","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("74","2012-12-21","1","1","11","1","4","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("75","2012-12-21","1","1","13","1","4","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("76","2012-12-22","1","1","7","1","1","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("77","2012-12-22","1","1","155","1","1","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("78","2012-12-22","1","1","173","1","1","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("79","2012-12-22","1","1","8","1","2","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("80","2012-12-22","1","1","17","1","2","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("81","2012-12-22","1","1","91","1","2","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("82","2012-12-21","2","3","7","1","1","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("83","2012-12-21","2","3","12","1","1","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("84","2012-12-21","2","3","13","1","1","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("85","2012-12-21","2","3","8","1","2","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("86","2012-12-21","2","3","13","1","2","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("87","2012-12-21","2","3","76","1","2","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("88","2012-12-21","2","1","7","1","4","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("89","2012-12-21","2","1","10","1","4","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("90","2012-12-21","2","1","11","1","4","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("91","2012-12-22","2","1","8","1","1","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("92","2012-12-22","2","1","143","1","1","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("93","2012-12-22","2","1","145","1","1","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("94","2012-12-22","2","1","146","1","1","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("95","2012-12-22","2","2","8","1","2","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("96","2012-12-22","2","2","230","1","2","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("97","2012-12-22","2","2","237","1","2","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("98","2012-12-21","3","3","9","1","1","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("99","2012-12-21","3","3","10","1","1","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("100","2012-12-21","3","3","11","1","1","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("101","2012-12-21","3","3","8","1","2","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("102","2012-12-21","3","3","13","1","2","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("103","2012-12-21","3","3","76","1","2","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("104","2012-12-21","3","3","234","1","2","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("105","2012-12-21","3","3","235","1","2","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("106","2012-12-21","3","3","237","1","2","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("107","2012-12-21","3","1","7","1","4","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("108","2012-12-21","3","1","8","1","4","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("109","2012-12-21","3","1","14","1","4","732","2012-12-28 16:14:54");
INSERT INTO gz_jadwal_menu VALUES("110","2012-12-22","3","1","8","1","1","732","2012-12-28 16:14:55");
INSERT INTO gz_jadwal_menu VALUES("111","2012-12-22","3","1","11","1","1","732","2012-12-28 16:14:55");
INSERT INTO gz_jadwal_menu VALUES("112","2012-12-22","3","1","12","1","1","732","2012-12-28 16:14:55");
INSERT INTO gz_jadwal_menu VALUES("113","2012-12-22","3","1","14","1","1","732","2012-12-28 16:14:55");



DROP TABLE gz_makan_harian;

CREATE TABLE `gz_makan_harian` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pelayanan_id` bigint(20) unsigned DEFAULT '0',
  `pasien_id` bigint(20) unsigned DEFAULT '0',
  `kamar_id` bigint(20) unsigned DEFAULT '0',
  `kode_bed` varchar(50) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `pasiso` tinyint(1) unsigned DEFAULT '1',
  `ms_menu_jenis_id` bigint(20) unsigned DEFAULT '0',
  `ket` text,
  `diterima` tinyint(1) unsigned DEFAULT '0',
  `user_act` bigint(20) unsigned DEFAULT '0',
  `tgl_act` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=272 DEFAULT CHARSET=latin1;

INSERT INTO gz_makan_harian VALUES("1","112599","416705","46","","2011-12-07","1","3","RG","0","0","2011-12-08 05:31:15");
INSERT INTO gz_makan_harian VALUES("8","371508","761885","46","","2011-12-06","1","2","","0","0","2011-12-08 05:30:25");
INSERT INTO gz_makan_harian VALUES("9","480279","371699","46","","2011-12-06","1","4","DM","0","0","2011-12-08 05:32:01");
INSERT INTO gz_makan_harian VALUES("12","589301","661596","0","","2012-01-10","1","2","Ikannya disendirikan","0","979","2012-01-11 10:53:44");
INSERT INTO gz_makan_harian VALUES("13","589301","661596","0","","2012-01-10","2","3","keterangan","0","0","2012-02-16 13:28:40");
INSERT INTO gz_makan_harian VALUES("14","112599","416705","46","","","3","2","","0","0","2012-02-16 13:37:04");
INSERT INTO gz_makan_harian VALUES("16","604555","639898","46","","2012-02-16","3","5","sore","0","609","2012-02-16 16:30:02");
INSERT INTO gz_makan_harian VALUES("17","604555","639898","46","","2012-02-16","1","1","pagi","0","609","2012-02-16 16:13:31");
INSERT INTO gz_makan_harian VALUES("18","604555","639898","46","","2012-02-16","2","2","siang","0","609","2012-02-16 16:30:31");
INSERT INTO gz_makan_harian VALUES("19","600863","140595","46","","2012-02-17","1","1","asdad","0","609","2012-02-17 09:05:04");
INSERT INTO gz_makan_harian VALUES("20","112599","416705","46","","2012-04-27","1","1","nasi","0","732","2012-04-28 10:26:20");
INSERT INTO gz_makan_harian VALUES("21","629592","800137","46","","2012-04-27","2","3","sdfsdfsd","0","732","2012-04-27 13:39:08");
INSERT INTO gz_makan_harian VALUES("22","676521","710448","46","","2012-04-27","2","5","sdfsdf","0","732","2012-04-27 13:39:16");
INSERT INTO gz_makan_harian VALUES("23","112599","416705","46","","2012-04-27","2","1","putihan","0","732","2012-04-27 13:44:13");
INSERT INTO gz_makan_harian VALUES("24","700107","566658","46","","2012-04-27","3","2","belum kuat","0","732","2012-04-28 11:57:44");
INSERT INTO gz_makan_harian VALUES("25","674835","435","46","","2012-04-27","2","2","ajskdhsjkad","0","732","2012-04-27 14:16:33");
INSERT INTO gz_makan_harian VALUES("26","669400","618455","46","","2012-04-27","1","4","bubur saringan","0","732","2012-04-27 14:54:58");
INSERT INTO gz_makan_harian VALUES("28","112599","416705","46","","2012-04-26","1","3","qweqweeeqe","0","732","2012-04-27 15:00:51");
INSERT INTO gz_makan_harian VALUES("29","674758","719002","46","","2012-04-27","1","5","sfssdfsd","0","732","2012-04-27 15:08:11");
INSERT INTO gz_makan_harian VALUES("30","676521","710448","46","","2012-04-27","1","3","adsad","0","732","2012-04-27 15:17:17");
INSERT INTO gz_makan_harian VALUES("31","112599","416705","46","","2012-04-26","2","5","nfnfghbfg","0","732","2012-04-27 15:17:32");
INSERT INTO gz_makan_harian VALUES("32","676521","710448","46","","2012-04-27","3","4","asdadad","0","732","2012-04-27 16:29:25");
INSERT INTO gz_makan_harian VALUES("33","112599","416705","46","","2012-04-28","1","3","bubur cacah","0","732","2012-04-28 10:30:04");
INSERT INTO gz_makan_harian VALUES("34","112599","416705","46","","2012-04-28","2","1","nasi non diet","0","732","2012-04-28 10:30:16");
INSERT INTO gz_makan_harian VALUES("35","112599","416705","46","","2012-04-28","3","2","timtim","0","732","2012-04-28 11:14:04");
INSERT INTO gz_makan_harian VALUES("39","669400","618455","46","","2012-04-28","3","1","diet khusus","0","732","2012-04-28 11:47:31");
INSERT INTO gz_makan_harian VALUES("40","700107","566658","46","","2012-04-27","3","2","Belum bisa mengunyah","0","732","2012-04-28 11:57:14");
INSERT INTO gz_makan_harian VALUES("49","669400","618455","46","","2012-04-28","1","2","asdasdsa","0","732","2012-04-30 10:29:29");
INSERT INTO gz_makan_harian VALUES("58","709078","809896","46","","2012-04-30","2","3","cacah12121","0","732","2012-04-30 11:30:20");
INSERT INTO gz_makan_harian VALUES("59","709078","809896","46","","2012-04-30","1","4","bubur saring","0","732","2012-04-30 11:29:39");
INSERT INTO gz_makan_harian VALUES("60","112599","416705","46","","2012-04-30","1","1","non diet","0","732","2012-04-30 11:29:24");
INSERT INTO gz_makan_harian VALUES("61","112599","416705","46","","2012-04-30","2","2","asasas","0","732","2012-04-30 11:29:13");
INSERT INTO gz_makan_harian VALUES("62","708750","809563","46","","2012-04-30","1","5","MLP","0","732","2012-04-30 11:38:27");
INSERT INTO gz_makan_harian VALUES("63","709078","809896","46","","2012-05-02","1","1","nasi","0","732","2012-05-02 09:15:46");
INSERT INTO gz_makan_harian VALUES("64","709078","809896","46","","2012-05-02","2","5","lewat pipa","0","732","2012-05-02 14:09:18");
INSERT INTO gz_makan_harian VALUES("65","709078","809896","46","","2012-05-02","3","3","gag pake sambel bos","0","732","2012-05-02 14:09:50");
INSERT INTO gz_makan_harian VALUES("66","708750","809563","46","","2012-05-02","2","4","pake saringan","0","732","2012-05-02 14:25:05");
INSERT INTO gz_makan_harian VALUES("67","698035","809056","46","","2012-05-02","1","2","ojhkj","0","732","2012-05-02 14:31:16");
INSERT INTO gz_makan_harian VALUES("68","690258","807746","100","","2012-05-04","1","2","","0","732","2012-05-04 13:43:22");
INSERT INTO gz_makan_harian VALUES("69","709078","809896","46","","2012-05-04","1","2","","0","732","2012-05-04 13:43:25");
INSERT INTO gz_makan_harian VALUES("70","700345","765983","148","","2012-05-04","1","2","s","0","732","2012-05-04 13:50:59");
INSERT INTO gz_makan_harian VALUES("71","709078","809896","46","","2012-05-05","1","3","asas","0","732","2012-05-05 09:06:57");
INSERT INTO gz_makan_harian VALUES("72","709078","809896","46","","2012-05-05","2","2","zxczxcxz","0","732","2012-05-05 09:07:44");
INSERT INTO gz_makan_harian VALUES("73","709078","809896","46","","2012-05-28","1","3","zxcxzc","0","732","2012-05-28 15:09:58");
INSERT INTO gz_makan_harian VALUES("74","709078","809896","46","","2012-05-29","1","1","a","0","732","2012-05-29 17:06:59");
INSERT INTO gz_makan_harian VALUES("75","709078","809896","46","","2012-05-29","2","2","b","0","732","2012-05-29 17:07:09");
INSERT INTO gz_makan_harian VALUES("80","709078","809896","46","","2012-06-01","1","3","zxc","0","732","2012-06-01 11:15:28");
INSERT INTO gz_makan_harian VALUES("81","704942","809860","46","","2012-06-01","2","2","zxcz","0","732","2012-06-01 11:16:27");
INSERT INTO gz_makan_harian VALUES("82","357458","764189","10","","2011-06-09","1","4","BUBUR AYAM","0","732","2012-06-01 09:39:46");
INSERT INTO gz_makan_harian VALUES("83","709833","292318","46","","2012-06-01","1","4","BUBUR KECAP","0","732","2012-06-01 09:45:29");
INSERT INTO gz_makan_harian VALUES("84","698035","809056","46","","2012-06-01","1","3","bubur ketan","0","732","2012-06-01 09:48:16");
INSERT INTO gz_makan_harian VALUES("85","708750","809563","46","","2012-06-01","1","3","bubur merah","0","732","2012-06-01 10:00:52");
INSERT INTO gz_makan_harian VALUES("86","705044","809703","46","","2012-06-01","1","5","MLP","0","732","2012-06-01 10:18:35");
INSERT INTO gz_makan_harian VALUES("87","704942","809860","46","","2012-06-01","1","1","bubur mutiara","0","732","2012-06-01 16:12:09");
INSERT INTO gz_makan_harian VALUES("88","112599","416705","46","","2012-06-01","1","2","nas lalapan","0","732","2012-06-01 15:49:34");
INSERT INTO gz_makan_harian VALUES("89","707130","810157","46","","2012-06-01","1","1","ahahahhahaa","0","732","2012-06-01 15:51:17");
INSERT INTO gz_makan_harian VALUES("91","705068","365549","46","","2012-06-01","1","5","zxc","0","732","2012-06-01 17:36:49");
INSERT INTO gz_makan_harian VALUES("94","709078","809896","46","bed 2","2012-06-03","1","1","zxczxc","0","732","2012-06-03 17:17:04");
INSERT INTO gz_makan_harian VALUES("95","709078","809896","46","3","2012-06-08","2","1","zxc","0","732","2012-06-08 13:08:12");
INSERT INTO gz_makan_harian VALUES("103","707133","543988","66","bed 2","2012-06-12","1","3","pagi2","0","732","2012-06-12 15:58:50");
INSERT INTO gz_makan_harian VALUES("105","707133","543988","66","bed 2","2012-06-12","3","5","sore","0","732","2012-06-12 15:57:50");
INSERT INTO gz_makan_harian VALUES("106","707424","809731","66","bed3","2012-06-12","2","2","asdasd","0","732","2012-06-12 16:00:23");
INSERT INTO gz_makan_harian VALUES("107","707133","543988","66","bed 2","2012-06-12","2","1","siang","0","732","2012-06-12 16:06:00");
INSERT INTO gz_makan_harian VALUES("108","707133","543988","66","4","2012-06-13","1","1","zxcz","0","732","2012-06-13 09:36:55");
INSERT INTO gz_makan_harian VALUES("109","707133","543988","66","3","2012-06-14","2","3","asd","0","732","2012-06-14 11:55:34");
INSERT INTO gz_makan_harian VALUES("110","707133","543988","66","","2012-06-15","1","3","bubur ayam","0","732","2012-06-15 15:25:16");
INSERT INTO gz_makan_harian VALUES("111","707424","809731","66","","2012-06-15","1","1","Nasi SOP","0","732","2012-06-15 15:25:39");
INSERT INTO gz_makan_harian VALUES("112","707133","543988","66","2","2012-06-19","1","1","zxc","0","732","2012-06-19 11:27:46");
INSERT INTO gz_makan_harian VALUES("113","707424","809731","66","3","2012-06-19","1","3","asda","0","732","2012-06-19 11:27:56");
INSERT INTO gz_makan_harian VALUES("114","707424","809731","66","3","2012-06-19","3","2","asda","0","732","2012-06-19 11:29:55");
INSERT INTO gz_makan_harian VALUES("115","707424","809731","66","3","2012-06-19","2","5","asdadada","0","732","2012-06-19 14:12:47");
INSERT INTO gz_makan_harian VALUES("116","707133","543988","66","4E","2012-06-22","1","1","Nasi sayur ","0","732","2012-06-22 10:12:48");
INSERT INTO gz_makan_harian VALUES("117","709918","809788","154","bed 1","2012-07-23","2","3","zxcxz","0","732","2012-07-23 15:09:01");
INSERT INTO gz_makan_harian VALUES("118","709918","809788","154","bed 1","2012-07-23","1","3","zxcxz1211","0","732","2012-07-23 16:27:06");
INSERT INTO gz_makan_harian VALUES("119","710424","807746","154","asdas","2012-07-23","1","3","dsadsad","0","732","2012-07-23 16:10:49");
INSERT INTO gz_makan_harian VALUES("120","709937","810419","154","zxc","2012-07-23","1","1","zxc1212dsfsdf","0","732","2012-07-23 16:29:07");
INSERT INTO gz_makan_harian VALUES("121","707424","809731","66","bed 2","2012-07-23","2","1","gak pake lama","0","732","2012-07-23 16:38:22");
INSERT INTO gz_makan_harian VALUES("122","707424","809731","66","bed 2","2012-07-23","2","1","gak pake lama","0","732","2012-07-23 16:38:22");
INSERT INTO gz_makan_harian VALUES("123","707133","543988","66","bed2","2012-07-23","2","1","adas","0","732","2012-07-23 16:45:23");
INSERT INTO gz_makan_harian VALUES("124","707424","809731","66","2","2012-07-26","2","2","asaa","0","732","2012-07-26 09:11:36");
INSERT INTO gz_makan_harian VALUES("125","707133","543988","66","3","2012-08-06","1","3","kuah banyak","0","732","2012-08-06 12:31:20");
INSERT INTO gz_makan_harian VALUES("126","707567","806929","164","bed 1","2012-11-16","1","1","tanpa sayur","0","732","2012-11-16 14:47:42");
INSERT INTO gz_makan_harian VALUES("127","702799","809685","66","23","2012-11-16","1","2","zxc","0","732","2012-11-16 15:31:17");
INSERT INTO gz_makan_harian VALUES("128","707567","806929","164","1","2012-12-14","1","1","121","0","732","2012-12-14 10:52:45");
INSERT INTO gz_makan_harian VALUES("129","707567","806929","164","bed 1","2012-12-17","1","1","zxc","0","732","2012-12-17 10:08:56");
INSERT INTO gz_makan_harian VALUES("130","707567","806929","164","bed 1","2012-12-17","2","5","lewt pipa coy","0","732","2012-12-17 10:42:13");
INSERT INTO gz_makan_harian VALUES("131","707567","806929","164","bed 1","2012-12-17","3","2","","0","732","2012-12-17 10:43:38");
INSERT INTO gz_makan_harian VALUES("132","700180","403746","155","2","2012-12-17","1","1","","0","732","2012-12-17 15:02:03");
INSERT INTO gz_makan_harian VALUES("133","700180","403746","155","p","2012-12-21","1","1","","0","732","2012-12-27 13:31:49");
INSERT INTO gz_makan_harian VALUES("134","700180","403746","155","p","2012-12-21","2","1","jin","0","732","2012-12-27 13:32:14");
INSERT INTO gz_makan_harian VALUES("135","700180","403746","155","p","2012-12-21","3","1","","0","732","2012-12-27 13:32:27");
INSERT INTO gz_makan_harian VALUES("136","707567","806929","164","8","2012-12-21","1","1","","0","732","2012-12-27 13:32:41");
INSERT INTO gz_makan_harian VALUES("137","707567","806929","164","8","2012-12-21","2","1","","0","732","2012-12-27 13:32:44");
INSERT INTO gz_makan_harian VALUES("138","707567","806929","164","8","2012-12-21","3","1","","0","732","2012-12-27 13:32:46");
INSERT INTO gz_makan_harian VALUES("139","706855","444044","10","k","2012-12-21","1","1","","0","732","2012-12-27 14:16:40");
INSERT INTO gz_makan_harian VALUES("140","706855","444044","10","k","2012-12-21","2","1","","0","732","2012-12-27 14:16:43");
INSERT INTO gz_makan_harian VALUES("141","706855","444044","10","k","2012-12-21","3","1","","0","732","2012-12-27 14:16:46");
INSERT INTO gz_makan_harian VALUES("142","700180","403746","155","bed 2","2013-02-05","1","1","cepetan","0","732","2013-02-05 11:27:53");
INSERT INTO gz_makan_harian VALUES("143","707567","806929","164","4","2013-02-05","1","3","adasd","0","732","2013-02-05 11:40:15");
INSERT INTO gz_makan_harian VALUES("144","707047","763737","157","6","2013-02-05","1","5","gfdgf","0","0","2013-02-05 13:45:37");
INSERT INTO gz_makan_harian VALUES("145","709204","663129","159","3","2013-02-05","1","3","asdasd","0","0","2013-02-05 13:49:52");
INSERT INTO gz_makan_harian VALUES("146","706548","94685","163","3","2013-02-05","1","4","okok","0","0","2013-02-05 14:39:53");
INSERT INTO gz_makan_harian VALUES("147","706855","444044","10","3","2013-02-05","1","3","bebek","0","0","2013-02-05 14:46:40");
INSERT INTO gz_makan_harian VALUES("148","700180","403746","155","2","2013-02-12","1","1","zxzc","0","732","2013-02-12 13:15:26");
INSERT INTO gz_makan_harian VALUES("149","707567","806929","164","1","2013-02-12","1","2","asdasd","0","732","2013-02-12 13:16:41");
INSERT INTO gz_makan_harian VALUES("150","700180","403746","155","4","2013-02-11","1","2","asda","0","732","2013-02-12 13:19:14");
INSERT INTO gz_makan_harian VALUES("151","707133","543988","66","2","2013-10-07","1","3","test","0","0","2013-10-08 15:34:58");
INSERT INTO gz_makan_harian VALUES("153","707133","543988","66","2","2013-10-07","3","5","test","0","0","2013-10-08 15:35:08");
INSERT INTO gz_makan_harian VALUES("154","350","123","317","1","2014-02-17","1","1","","0","0","2014-02-17 11:10:55");
INSERT INTO gz_makan_harian VALUES("155","350","123","317","1","2014-02-17","2","1","","0","0","2014-02-17 11:11:06");
INSERT INTO gz_makan_harian VALUES("156","1220","295","325","3","2014-02-17","1","1","","0","0","2014-02-17 11:11:34");
INSERT INTO gz_makan_harian VALUES("157","351","183","343","1","2014-03-10","1","2","DM 1900 Kal","0","0","2014-03-10 13:41:40");
INSERT INTO gz_makan_harian VALUES("158","351","183","343","1","2014-03-10","2","2","DM 1900 Kalori","0","0","2014-03-10 13:42:08");
INSERT INTO gz_makan_harian VALUES("159","351","183","343","1","2014-03-10","3","2","DM 1900 Kalori","0","0","2014-03-10 13:42:26");
INSERT INTO gz_makan_harian VALUES("160","394","216","311","2","2014-03-11","1","3","zxcxzczxcz","0","0","2014-03-11 14:05:42");
INSERT INTO gz_makan_harian VALUES("161","652","293","325","5","2014-03-13","1","1","makan lunak diit jantung 1800 kalori","0","0","2014-03-13 12:54:13");
INSERT INTO gz_makan_harian VALUES("162","555","203","317","4","2014-03-13","1","1","ML ","0","0","2014-03-13 12:54:30");
INSERT INTO gz_makan_harian VALUES("163","646","254","325","2","2014-03-13","1","1","ML TKTP ","0","0","2014-03-13 12:54:52");
INSERT INTO gz_makan_harian VALUES("164","491","215","317","3","2014-03-13","1","1","ML","0","0","2014-03-13 12:55:04");
INSERT INTO gz_makan_harian VALUES("165","647","247","325","3","2014-03-13","1","1","ML DM 1900 KALORI ","0","0","2014-03-13 12:55:27");
INSERT INTO gz_makan_harian VALUES("166","648","209","325","4","2014-03-13","1","1","ML TKTP 1500 KALORI ","0","0","2014-03-13 12:55:51");
INSERT INTO gz_makan_harian VALUES("167","483","212","317","1","2014-03-13","1","1","BS","0","0","2014-03-13 12:56:03");
INSERT INTO gz_makan_harian VALUES("168","644","253","317","5","2014-03-13","1","1","ML ","0","0","2014-03-13 12:56:17");
INSERT INTO gz_makan_harian VALUES("169","645","257","325","1","2014-03-13","1","1","ML ","0","0","2014-03-13 12:56:29");
INSERT INTO gz_makan_harian VALUES("170","652","293","325","5","2014-03-13","2","1","ML DIIT JANTUNG 1800 KALORI","0","0","2014-03-13 12:57:14");
INSERT INTO gz_makan_harian VALUES("171","802","344","317","2","2014-03-14","1","2","tktp","0","0","2014-03-14 09:23:20");
INSERT INTO gz_makan_harian VALUES("172","802","344","317","2","2014-03-14","2","2","tktp","0","0","2014-03-14 09:24:37");
INSERT INTO gz_makan_harian VALUES("173","652","293","325","5","2014-03-14","1","2","diit jantung 1800 kalori","0","0","2014-03-14 09:25:23");
INSERT INTO gz_makan_harian VALUES("174","652","293","325","5","2014-03-14","2","2","dj 1800 kal","0","0","2014-03-14 09:26:03");
INSERT INTO gz_makan_harian VALUES("175","555","203","317","4","2014-03-14","1","2","","0","0","2014-03-14 09:27:58");
INSERT INTO gz_makan_harian VALUES("176","555","203","317","4","2014-03-14","2","2","","0","0","2014-03-14 09:28:10");
INSERT INTO gz_makan_harian VALUES("177","646","254","325","2","2014-03-14","1","2","tktp 1750","0","0","2014-03-14 09:28:51");
INSERT INTO gz_makan_harian VALUES("178","646","254","325","2","2014-03-14","2","2","tktp 1750 ","0","0","2014-03-14 09:29:13");
INSERT INTO gz_makan_harian VALUES("179","491","215","317","3","2014-03-14","1","2","","0","0","2014-03-14 09:29:28");
INSERT INTO gz_makan_harian VALUES("180","491","215","317","3","2014-03-14","2","2","","0","0","2014-03-14 09:29:38");
INSERT INTO gz_makan_harian VALUES("181","647","247","325","3","2014-03-14","1","2","dm dj 1900","0","0","2014-03-14 09:30:15");
INSERT INTO gz_makan_harian VALUES("182","647","247","325","3","2014-03-14","2","2","dm dj 1900 kal ","0","0","2014-03-14 09:31:03");
INSERT INTO gz_makan_harian VALUES("183","648","209","325","4","2014-03-14","1","2","tktp","0","0","2014-03-14 09:32:36");
INSERT INTO gz_makan_harian VALUES("184","648","209","325","4","2014-03-14","2","2","tktp","0","0","2014-03-14 09:32:50");
INSERT INTO gz_makan_harian VALUES("185","483","212","317","1","2014-03-14","1","2","","0","0","2014-03-14 09:33:38");
INSERT INTO gz_makan_harian VALUES("186","483","212","317","1","2014-03-14","2","2","","0","0","2014-03-14 09:33:55");
INSERT INTO gz_makan_harian VALUES("187","644","253","317","5","2014-03-14","1","2","","0","0","2014-03-14 09:34:12");
INSERT INTO gz_makan_harian VALUES("188","644","253","317","5","2014-03-14","2","2","","0","0","2014-03-14 09:34:30");
INSERT INTO gz_makan_harian VALUES("189","645","257","325","1","2014-03-14","1","2","","0","0","2014-03-14 09:34:58");
INSERT INTO gz_makan_harian VALUES("190","645","257","325","1","2014-03-14","2","2","","0","0","2014-03-14 09:35:10");
INSERT INTO gz_makan_harian VALUES("191","1083","477","321","1","2014-03-15","1","5","","0","0","2014-03-15 07:17:25");
INSERT INTO gz_makan_harian VALUES("192","2377","816","313","2","2014-03-23","3","2","BB 1200 kal","0","0","2014-03-23 12:28:56");
INSERT INTO gz_makan_harian VALUES("193","2983","984","348","5","2014-03-23","3","0","NB (U/PENUNGGU)","0","0","2014-03-23 12:29:15");
INSERT INTO gz_makan_harian VALUES("199","28149","5994","341","2","2014-06-01","1","2","NT DM ","0","0","2014-06-02 08:53:23");
INSERT INTO gz_makan_harian VALUES("201","28005","5979","311","1","2014-06-01","2","3","","0","0","2014-06-02 08:57:33");
INSERT INTO gz_makan_harian VALUES("202","28005","5979","311","1","2014-06-01","1","3","","0","0","2014-06-02 08:57:20");
INSERT INTO gz_makan_harian VALUES("203","28005","5979","311","1","2014-06-01","3","3","","0","0","2014-06-02 08:57:40");
INSERT INTO gz_makan_harian VALUES("204","28149","5994","341","2","2014-06-01","2","2","NT DM","0","0","2014-06-02 08:53:30");
INSERT INTO gz_makan_harian VALUES("205","28149","5994","341","2","2014-06-01","3","2","NT DM ","0","0","2014-06-02 08:53:42");
INSERT INTO gz_makan_harian VALUES("206","26015","556","388","3","2014-06-01","1","3","BB DL RS","0","0","2014-06-02 08:55:03");
INSERT INTO gz_makan_harian VALUES("207","26015","556","388","3","2014-06-01","2","3","BB DL RS","0","0","2014-06-02 08:55:20");
INSERT INTO gz_makan_harian VALUES("208","26015","556","388","3","2014-06-01","3","3","BB DL RS","0","0","2014-06-02 08:55:32");
INSERT INTO gz_makan_harian VALUES("209","25849","1498","341","0","2014-06-01","1","3","BB RS DM CAIR ORAL DIABETASOL RG","0","0","2014-06-02 08:58:46");
INSERT INTO gz_makan_harian VALUES("210","25849","1498","341","0","2014-06-01","2","3","BB RS DM RG","0","0","2014-06-02 09:02:52");
INSERT INTO gz_makan_harian VALUES("211","25849","1498","341","0","2014-06-01","3","3","BB RS DM RG ","0","0","2014-06-02 09:03:13");
INSERT INTO gz_makan_harian VALUES("212","26810","5812","340","2","2014-06-01","1","3","BB","0","0","2014-06-02 09:03:30");
INSERT INTO gz_makan_harian VALUES("213","26810","5812","340","2","2014-06-01","2","3","BB","0","0","2014-06-02 09:03:36");
INSERT INTO gz_makan_harian VALUES("214","26810","5812","340","2","2014-06-01","3","3","BB","0","0","2014-06-02 09:03:44");
INSERT INTO gz_makan_harian VALUES("215","27535","5917","343","3","2014-06-01","1","3","BB RG","0","0","2014-06-02 09:04:33");
INSERT INTO gz_makan_harian VALUES("216","27535","5917","343","3","2014-06-01","2","3","BB RG","0","0","2014-06-02 09:04:37");
INSERT INTO gz_makan_harian VALUES("217","27535","5917","343","3","2014-06-01","3","3","BB RG","0","0","2014-06-02 09:04:40");
INSERT INTO gz_makan_harian VALUES("218","25816","4701","388","1","2014-06-01","1","3","BB","0","0","2014-06-02 09:04:54");
INSERT INTO gz_makan_harian VALUES("219","25816","4701","388","1","2014-06-01","2","3","BB","0","0","2014-06-02 09:04:58");
INSERT INTO gz_makan_harian VALUES("220","25816","4701","388","1","2014-06-01","3","3","BB","0","0","2014-06-02 09:05:03");
INSERT INTO gz_makan_harian VALUES("221","26995","5837","343","1","2014-06-01","1","3","BB RS 1700 KAL","0","0","2014-06-02 09:05:32");
INSERT INTO gz_makan_harian VALUES("222","26995","5837","343","1","2014-06-01","2","3","BB RS 1700 KAL ","0","0","2014-06-02 09:05:41");
INSERT INTO gz_makan_harian VALUES("223","26995","5837","343","1","2014-06-01","3","3","BB RS 1700 KAL","0","0","2014-06-02 09:05:56");
INSERT INTO gz_makan_harian VALUES("224","27283","5881","343","2","2014-06-01","1","2","NT RS","0","0","2014-06-02 09:06:24");
INSERT INTO gz_makan_harian VALUES("225","27283","5881","343","2","2014-06-01","2","2","NT RS","0","0","2014-06-02 09:06:37");
INSERT INTO gz_makan_harian VALUES("226","27283","5881","343","2","2014-06-01","3","2","NT RS","0","0","2014-06-02 09:06:46");
INSERT INTO gz_makan_harian VALUES("227","27534","5899","341","1","2014-06-01","1","1","NB","0","0","2014-06-02 09:07:24");
INSERT INTO gz_makan_harian VALUES("228","27534","5899","341","1","2014-06-01","2","1","NB","0","0","2014-06-02 09:07:31");
INSERT INTO gz_makan_harian VALUES("229","27534","5899","341","1","2014-06-01","3","1","NB","0","0","2014-06-02 09:07:36");
INSERT INTO gz_makan_harian VALUES("230","26484","4498","341","5","2014-06-01","1","2","NT RS","0","0","2014-06-02 09:08:17");
INSERT INTO gz_makan_harian VALUES("231","26484","4498","341","5","2014-06-01","2","2","NT RS","0","0","2014-06-02 09:08:26");
INSERT INTO gz_makan_harian VALUES("232","26484","4498","341","5","2014-06-01","3","2","NT RS","0","0","2014-06-02 09:08:37");
INSERT INTO gz_makan_harian VALUES("233","26558","5743","342","5","2014-06-01","1","2","NT","0","0","2014-06-02 09:08:51");
INSERT INTO gz_makan_harian VALUES("234","26558","5743","342","5","2014-06-01","2","2","NT","0","0","2014-06-02 09:08:59");
INSERT INTO gz_makan_harian VALUES("235","26558","5743","342","5","2014-06-01","3","2","NT","0","0","2014-06-02 09:09:05");
INSERT INTO gz_makan_harian VALUES("236","26529","5718","341","0","2014-06-01","1","3","BB RS","0","0","2014-06-02 09:09:36");
INSERT INTO gz_makan_harian VALUES("237","26529","5718","341","0","2014-06-01","2","3","BB RS","0","0","2014-06-02 09:09:39");
INSERT INTO gz_makan_harian VALUES("238","26529","5718","341","0","2014-06-01","3","3","BB RS","0","0","2014-06-02 09:09:46");
INSERT INTO gz_makan_harian VALUES("239","24886","5516","311","4","2014-06-01","1","2","NT DM","0","0","2014-06-02 09:13:11");
INSERT INTO gz_makan_harian VALUES("240","24886","5516","311","4","2014-06-01","2","2","NT DM ","0","0","2014-06-02 09:13:19");
INSERT INTO gz_makan_harian VALUES("241","24886","5516","311","4","2014-06-01","3","2","NT DM ","0","0","2014-06-02 09:13:36");
INSERT INTO gz_makan_harian VALUES("242","28064","5990","340","1","2014-06-01","1","2","NT DM ","0","0","2014-06-02 09:14:07");
INSERT INTO gz_makan_harian VALUES("243","28064","5990","340","1","2014-06-01","2","2","NT DM ","0","0","2014-06-02 09:14:16");
INSERT INTO gz_makan_harian VALUES("244","28064","5990","340","1","2014-06-01","3","2","NT DM ","0","0","2014-06-02 09:14:28");
INSERT INTO gz_makan_harian VALUES("245","25287","5575","340","5","2014-06-01","1","2","NT","0","0","2014-06-02 09:14:50");
INSERT INTO gz_makan_harian VALUES("246","25287","5575","340","5","2014-06-01","2","2","NT","0","0","2014-06-02 09:14:59");
INSERT INTO gz_makan_harian VALUES("247","25287","5575","340","5","2014-06-01","3","2","NT","0","0","2014-06-02 09:15:07");
INSERT INTO gz_makan_harian VALUES("248","27042","5854","311","2","2014-06-01","1","1","NB DM","0","0","2014-06-02 09:15:35");
INSERT INTO gz_makan_harian VALUES("249","27042","5854","311","2","2014-06-01","2","1","NB DM","0","0","2014-06-02 09:15:43");
INSERT INTO gz_makan_harian VALUES("250","27042","5854","311","2","2014-06-01","3","1","NB DM","0","0","2014-06-02 09:15:50");
INSERT INTO gz_makan_harian VALUES("252","28534","6091","377","3","2014-06-02","1","1","TKTP","0","0","2014-06-02 18:05:45");
INSERT INTO gz_makan_harian VALUES("253","28534","6091","377","3","2014-06-02","2","1","TKTP","0","0","2014-06-02 18:06:56");
INSERT INTO gz_makan_harian VALUES("254","28534","6091","377","3","2014-06-02","3","1","TKTP","0","0","2014-06-02 18:07:09");
INSERT INTO gz_makan_harian VALUES("255","28594","5645","333","2","2014-06-02","1","1","TKTP","0","0","2014-06-02 18:07:48");
INSERT INTO gz_makan_harian VALUES("256","28594","5645","333","2","2014-06-02","2","1","TKTP","0","0","2014-06-02 18:07:55");
INSERT INTO gz_makan_harian VALUES("257","28594","5645","333","2","2014-06-02","3","1","TKTP","0","0","2014-06-02 18:08:03");
INSERT INTO gz_makan_harian VALUES("258","28101","629","136","4","2014-06-02","1","1","TKTP","0","0","2014-06-02 18:08:10");
INSERT INTO gz_makan_harian VALUES("259","27460","5868","334","1","2014-06-02","1","1","TKTP","0","0","2014-06-02 18:08:20");
INSERT INTO gz_makan_harian VALUES("260","28101","629","136","4","2014-06-02","2","1","TKTP","0","0","2014-06-02 18:11:09");
INSERT INTO gz_makan_harian VALUES("261","28101","629","136","4","2014-06-02","3","1","TKTP","0","0","2014-06-02 18:11:16");
INSERT INTO gz_makan_harian VALUES("262","27460","5868","334","1","2014-06-02","2","1","TKTP","0","0","2014-06-02 18:11:21");
INSERT INTO gz_makan_harian VALUES("263","27460","5868","334","1","2014-06-02","3","1","TKTP","0","0","2014-06-02 18:11:27");
INSERT INTO gz_makan_harian VALUES("264","29697","6267","348","3","2014-06-06","1","1","TKTP","0","0","2014-06-06 14:32:15");
INSERT INTO gz_makan_harian VALUES("265","258694","1178","14","1","2020-02-07","1","11","","0","0","2020-02-07 15:09:09");
INSERT INTO gz_makan_harian VALUES("266","261026","2161","14","1","2020-02-20","1","10","500 kalori","0","0","2020-02-20 08:21:24");
INSERT INTO gz_makan_harian VALUES("267","261742","71497","25","3","2020-02-20","1","14","","0","0","2020-02-20 08:22:18");
INSERT INTO gz_makan_harian VALUES("268","261743","58294","21","2","2020-02-20","1","14","","0","0","2020-02-20 08:26:35");
INSERT INTO gz_makan_harian VALUES("269","263815","26727","15","2","2020-02-28","1","2","1600 kalori","0","0","2020-02-28 15:25:28");
INSERT INTO gz_makan_harian VALUES("270","263815","26727","15","2","2020-02-28","2","14","mau operaSI","0","0","2020-02-28 15:25:39");
INSERT INTO gz_makan_harian VALUES("271","263815","26727","15","2","2020-02-28","3","8","NORMAL 300 KALORI","0","0","2020-02-28 15:25:56");



DROP TABLE gz_makan_tamu;

CREATE TABLE `gz_makan_tamu` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tgl` date DEFAULT NULL,
  `no_minta` varchar(20) DEFAULT NULL,
  `ms_tipe_makanan` tinyint(1) unsigned DEFAULT '1' COMMENT '1=nasi,2=snack,3=air minum',
  `qty` double DEFAULT '1',
  `ket` text,
  `dikirim` tinyint(1) unsigned DEFAULT '0',
  `tipe` tinyint(1) unsigned DEFAULT '0',
  `user_act` bigint(20) unsigned DEFAULT '0',
  `tgl_act` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

INSERT INTO gz_makan_tamu VALUES("8","2011-12-16","GZ/MNT/2011-12/0001","3","5","Untuk meeting hari ini jam 11 siang","1","0","609","2011-12-16 14:03:59");
INSERT INTO gz_makan_tamu VALUES("9","2011-12-16","GZ/MNT/2011-12/0001","2","5","Untuk meeting hari ini jam 11 siang","0","0","609","2011-12-16 14:03:59");
INSERT INTO gz_makan_tamu VALUES("10","2011-12-16","GZ/MNT/2011-12/0001","1","5","Untuk meeting hari ini jam 11 siang","0","0","609","2011-12-16 14:03:59");
INSERT INTO gz_makan_tamu VALUES("11","2011-12-16","GZ/MNT/2011-12/0001","2","10","Untuk meeting hari ini jam 11 siang","0","0","609","2011-12-16 14:03:59");
INSERT INTO gz_makan_tamu VALUES("12","2011-12-29","GZ/MNT/2011-12/0002","1","5","Menjalani","0","1","609","2011-12-29 14:55:36");
INSERT INTO gz_makan_tamu VALUES("13","2011-12-29","GZ/MNT/2011-12/0002","3","8","Menjalani","0","1","609","2011-12-29 14:55:36");
INSERT INTO gz_makan_tamu VALUES("14","2011-12-29","GZ/MNT/2011-12/0002","2","5","Menjalani","0","1","609","2011-12-29 14:55:36");
INSERT INTO gz_makan_tamu VALUES("15","2012-01-16","GZ/MNT/2012-01/0001","1","5","Untuk tamu dari jombang nanti siang jam 13:00","0","0","979","2012-01-16 09:58:18");
INSERT INTO gz_makan_tamu VALUES("16","2012-01-16","GZ/MNT/2012-01/0001","3","10","Untuk tamu dari jombang nanti siang jam 13:00","0","0","979","2012-01-16 09:58:18");
INSERT INTO gz_makan_tamu VALUES("24","2012-01-18","GZ/MNT/2012-01/0002","1","5","Untuk Meeting Siang Ini","0","0","979","2012-01-18 16:17:59");
INSERT INTO gz_makan_tamu VALUES("25","2012-01-18","GZ/MNT/2012-01/0002","2","5","Untuk Meeting Siang Ini","0","0","979","2012-01-18 16:17:59");
INSERT INTO gz_makan_tamu VALUES("26","2012-06-01","GZ/MNT/2012-06/0001","1","2","tes","0","0","732","2012-06-01 15:49:17");
INSERT INTO gz_makan_tamu VALUES("27","2012-06-01","GZ/MNT/2012-06/0002","2","3","gaha","0","0","732","2012-06-01 15:59:23");



DROP TABLE gz_ms_bahan;

CREATE TABLE `gz_ms_bahan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(5) DEFAULT NULL,
  `nama` varchar(75) DEFAULT NULL,
  `ket` text,
  `kalori` double unsigned DEFAULT '0',
  `protein` double unsigned DEFAULT '0',
  `lemak` double unsigned DEFAULT '0',
  `KH` double unsigned DEFAULT '0',
  `jenis` tinyint(1) DEFAULT '0' COMMENT '1=kering,2=basah',
  `tipe` tinyint(1) unsigned DEFAULT '1' COMMENT '1=bahan,2=komponenmenu',
  `aktif` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=latin1;

INSERT INTO gz_ms_bahan VALUES("1","001","Beras","-","0","0","0","0","1","1","1");
INSERT INTO gz_ms_bahan VALUES("2","002","Tepung Beras","-","0","0","0","0","1","1","1");
INSERT INTO gz_ms_bahan VALUES("3","003","Tepung Hongwe","-","0","0","0","0","1","1","1");
INSERT INTO gz_ms_bahan VALUES("4","004","Tepung Teriguh","-","0","0","0","0","1","1","1");
INSERT INTO gz_ms_bahan VALUES("5","005","Gula Pasir","gula pasir","0","0","0","0","1","1","1");
INSERT INTO gz_ms_bahan VALUES("7","202","Nasi Tim / BK","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("8","203","Bubur Cacah","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("9","204","Bubur Tepung","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("10","205","Kentucky","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("11","206","Bandeng Goreng","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("12","207","Rempeyek","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("13","208","Tempe Mendoan","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("14","209","Makanan Lewat Pipa (MLP)","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("15","210","Gimbal Udang","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("16","211","Minuman Teh","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("17","212","Minuman Kopi","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("25","006","Daun Teh kotak","Pucuk..pucuk","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("26","007","Kopi Bubuk","","0","0","0","0","1","1","1");
INSERT INTO gz_ms_bahan VALUES("27","008","Susu FCM","-","0","0","0","0","1","1","1");
INSERT INTO gz_ms_bahan VALUES("28","009","Kacang Tanah","","0","0","0","0","1","1","1");
INSERT INTO gz_ms_bahan VALUES("29","010","Kacang Hijau","","0","0","0","0","1","1","1");
INSERT INTO gz_ms_bahan VALUES("30","011","Macaroni","","0","0","0","0","1","1","1");
INSERT INTO gz_ms_bahan VALUES("32","013","Dada Ayam","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("33","014","Ayam Potong","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("34","015","Hati Sapi","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("35","016","Bandeng Segar","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("36","017","Bandeng Presto","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("37","018","Telur Ayam","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("38","019","Telur Asin","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("39","020","Telur Puyuh","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("40","021","Tempe","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("41","022","Tahu","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("42","023","Otak","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("43","024","Kebuk / Paru","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("44","025","Kekian","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("45","026","Bakso","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("46","027","Sosis","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("47","028","Udang","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("48","029","Cecek","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("49","030","Rempelo Ati","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("50","031","Pindang Tongkol","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("51","032","Kacang Panjang","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("52","033","Wortel","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("53","034","Manisah","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("54","035","Manisah Rajang","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("56","036","Gambas","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("57","037","Terong","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("58","038","Bayam","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("59","039","Kangkung","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("60","040","Buncis","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("61","041","Sawi Hijau","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("62","042","Toge","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("63","043","Kubis","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("64","044","Blomkol","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("65","045","Kentang","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("66","046","Janten","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("67","047","Pisang","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("68","048","Pepaya","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("69","049","Melon","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("70","050","Semangka","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("71","051","Rambutan","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("72","052","Jeruk","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("73","053","Apel","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("74","054","Nanas","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("75","213","Minuman Susu","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("76","214","MLP / Susu Telur","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("77","215","Bubur susu","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("78","216","Bumbu Pecel","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("81","219","Minuman Kacang Hijau","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("82","220","Sup Macaroni","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("83","221","Scutel Macaroni","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("86","224","Bubur tepung / BS","Lauk Utama","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("87","225","Rolade","Lauk Utama","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("88","226","Gadon","Lauk Utama","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("89","227","Telur puyuh sembunyi","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("90","228","Telur sembunyi","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("91","229","Soto ayam","Lauk Utama","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("94","232","Ayam filet","Lauk Ekstra","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("95","233","Koloke","Lauk Ekstra","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("96","234","Chiken Nugets","Lauk Ekstra","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("102","240","Sambel goreng ati   kentang","Lauk Ekstra","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("109","247","orak arik","Lauk Ekstra","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("110","248","Dadar telur","Lauk Ekstra","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("111","249","Bali / Opor","Lauk Ekstra","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("115","253","Sate","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("116","254","Sambel goreng","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("118","256","Tempe Goreng","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("119","257","Tempe bacem","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("120","258","Tempe Orem-orem","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("122","260","Tempe asem-manis","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("123","261","Tempe Oseng-oseng","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("124","262","Tempe Kering","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("125","263","Tempe sambel goreng","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("126","264","Tahu goreng","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("127","265","Tahu bacem","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("128","266","Tahu asem manis","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("129","267","Tahu oseng - oseng","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("130","268","Tahu sambel goreng","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("131","269","Tahu terik","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("132","270","Otak Goreng","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("133","271","Otak pepes/botok","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("134","272","Kakap filet goreng tepung","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("135","273","Kakap filet asem manis","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("136","274","Kebuk/paru goreng","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("137","275","Kebuk/paru soto/semur","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("139","277","Mie goreng / bihun goreng","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("140","278","Bakso kuah","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("142","280","Capcay","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("143","281","Bakso goreng tepung","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("145","283","Sosis goreng","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("146","284","Sosis oseng-oseng","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("147","285","Udang gimbal/peyek","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("148","286","Udang oseng / sambel goreng","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("149","287","Udang goreng tepung","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("150","288","Cecek sambel goreng","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("151","289","Rempelo ati botok","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("152","290","sambel goreng Rempelo ati ","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("153","291","Rempelo ati goreng","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("154","292","Pindang tongkol pepes","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("155","293","Pindang tongkol bb sarden","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("157","295","Oseng-oseng kacang","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("158","296","Lodeh","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("159","297","Kacang panjang podomoro","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("164","302","Sambel goreng wortel sawi","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("165","303","Oseng-oseng wortel","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("166","304","Sup wortel buncis","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("167","305","Cah sayuran","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("169","307","Sambel goreng wortel manisah","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("171","309","Rawon","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("173","311","Bobor Manisah","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("174","312","Manisah podo moro","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("175","313","Sayur asem","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("176","314","Sayur bening","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("177","315","Sambel goreng manisah rajang","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("178","316","Sup gambas","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("179","317","Terong lodeh","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("180","318","Sayur bening bayam","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("181","319","Bobor bayam","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("182","320","Cah bayam","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("183","321","Cah kangkung","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("184","322","Kangung podomoro","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("185","323","Pecel","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("188","326","Buncis oseng","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("191","329","Cah sawi hijau","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("192","330","Cah toge","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("195","333","Urapan","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("197","335","Soto","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("198","336","Sup sayuran","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("199","337","Kare","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("202","340","Sup","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("203","341","Sambel goreng kentang","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("205","343","Perkedel kentang","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("206","344","Oseng - oseng janten","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("207","345","Buah pisang","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("208","346","Buah pepaya","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("210","348","Buah melon","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("211","349","Es buah","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("212","350","Buah semangka","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("213","351","Buah rambutan","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("214","352","Buah jeruk","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("215","353","Buah Apel","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("217","355","Bumbu","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("218","356","Karamel","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("219","357","Minuman","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("220","055","Nutrisari","","0","0","0","0","1","1","1");
INSERT INTO gz_ms_bahan VALUES("221","358","Minuman Nutrisari","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("223","056","Kakap Filet","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("224","360","Kakap filet goreng manis","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("226","361","Bandeng Segar","Lauk Utama","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("227","362","Daging","Lauk utama","0","0","0","0","1","2","1");
INSERT INTO gz_ms_bahan VALUES("228","363","Daging","","0","0","0","0","2","1","1");
INSERT INTO gz_ms_bahan VALUES("230","365","Ayam Potong","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("231","366","Hati Sapi","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("233","367","Bandeng Pristo","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("234","368","Telur Ayam","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("235","369","Telur Asin","","0","0","0","0","0","2","1");
INSERT INTO gz_ms_bahan VALUES("236","057","Bubur Ayam","tes","0","0","0","0","1","1","1");
INSERT INTO gz_ms_bahan VALUES("237","370","Tongseng","Siip tenan iki rek!!!","2500","1000","4500","21","0","2","1");
INSERT INTO gz_ms_bahan VALUES("240","364","Laila Canggung","??","0","0","0","0","2","1","1");



DROP TABLE gz_ms_bahan_aset;

CREATE TABLE `gz_ms_bahan_aset` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ms_bahan_id` bigint(20) unsigned DEFAULT '0',
  `ms_barang_aset_id` bigint(20) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ms_bahan_id` (`ms_bahan_id`),
  KEY `ms_barang_aset_id` (`ms_barang_aset_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO gz_ms_bahan_aset VALUES("1","1","15120");
INSERT INTO gz_ms_bahan_aset VALUES("3","1","13920");
INSERT INTO gz_ms_bahan_aset VALUES("4","0","0");
INSERT INTO gz_ms_bahan_aset VALUES("5","36","13799");
INSERT INTO gz_ms_bahan_aset VALUES("6","35","13799");



DROP TABLE gz_ms_group;

CREATE TABLE `gz_ms_group` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(8) DEFAULT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `ket` varchar(150) DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `kode` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO gz_ms_group VALUES("1","001","PETUGAS DAPUR","Petugas Dapur","1");
INSERT INTO gz_ms_group VALUES("3","002","KEPALA INSTALASI","PN","1");
INSERT INTO gz_ms_group VALUES("4","003","IT TEAM","Unit IT","1");
INSERT INTO gz_ms_group VALUES("5","004","Tim Lo","Team terbaik RSUD","1");



DROP TABLE gz_ms_group_akses;

CREATE TABLE `gz_ms_group_akses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ms_group_id` bigint(20) unsigned DEFAULT NULL,
  `ms_menu_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=latin1;

INSERT INTO gz_ms_group_akses VALUES("5","1","10");
INSERT INTO gz_ms_group_akses VALUES("6","1","12");
INSERT INTO gz_ms_group_akses VALUES("7","1","11");
INSERT INTO gz_ms_group_akses VALUES("8","1","13");
INSERT INTO gz_ms_group_akses VALUES("9","3","2");
INSERT INTO gz_ms_group_akses VALUES("10","3","3");
INSERT INTO gz_ms_group_akses VALUES("11","3","4");
INSERT INTO gz_ms_group_akses VALUES("12","3","5");
INSERT INTO gz_ms_group_akses VALUES("13","3","6");
INSERT INTO gz_ms_group_akses VALUES("14","3","7");
INSERT INTO gz_ms_group_akses VALUES("15","3","19");
INSERT INTO gz_ms_group_akses VALUES("16","3","8");
INSERT INTO gz_ms_group_akses VALUES("18","3","10");
INSERT INTO gz_ms_group_akses VALUES("19","3","12");
INSERT INTO gz_ms_group_akses VALUES("20","3","11");
INSERT INTO gz_ms_group_akses VALUES("21","3","13");
INSERT INTO gz_ms_group_akses VALUES("22","3","22");
INSERT INTO gz_ms_group_akses VALUES("23","3","16");
INSERT INTO gz_ms_group_akses VALUES("24","3","17");
INSERT INTO gz_ms_group_akses VALUES("25","3","20");
INSERT INTO gz_ms_group_akses VALUES("26","3","21");
INSERT INTO gz_ms_group_akses VALUES("27","3","15");
INSERT INTO gz_ms_group_akses VALUES("28","3","18");
INSERT INTO gz_ms_group_akses VALUES("29","1","22");
INSERT INTO gz_ms_group_akses VALUES("30","1","16");
INSERT INTO gz_ms_group_akses VALUES("31","1","17");
INSERT INTO gz_ms_group_akses VALUES("32","1","20");
INSERT INTO gz_ms_group_akses VALUES("33","1","21");
INSERT INTO gz_ms_group_akses VALUES("34","1","15");
INSERT INTO gz_ms_group_akses VALUES("35","1","18");
INSERT INTO gz_ms_group_akses VALUES("37","4","2");
INSERT INTO gz_ms_group_akses VALUES("38","4","3");
INSERT INTO gz_ms_group_akses VALUES("39","4","4");
INSERT INTO gz_ms_group_akses VALUES("40","4","5");
INSERT INTO gz_ms_group_akses VALUES("41","4","6");
INSERT INTO gz_ms_group_akses VALUES("42","4","7");
INSERT INTO gz_ms_group_akses VALUES("43","4","19");
INSERT INTO gz_ms_group_akses VALUES("44","4","8");
INSERT INTO gz_ms_group_akses VALUES("46","4","10");
INSERT INTO gz_ms_group_akses VALUES("47","4","12");
INSERT INTO gz_ms_group_akses VALUES("48","4","11");
INSERT INTO gz_ms_group_akses VALUES("49","4","13");
INSERT INTO gz_ms_group_akses VALUES("51","4","22");
INSERT INTO gz_ms_group_akses VALUES("52","4","16");
INSERT INTO gz_ms_group_akses VALUES("54","4","20");
INSERT INTO gz_ms_group_akses VALUES("55","4","15");
INSERT INTO gz_ms_group_akses VALUES("56","4","21");
INSERT INTO gz_ms_group_akses VALUES("57","4","18");
INSERT INTO gz_ms_group_akses VALUES("58","4","23");
INSERT INTO gz_ms_group_akses VALUES("59","4","24");
INSERT INTO gz_ms_group_akses VALUES("60","4","25");
INSERT INTO gz_ms_group_akses VALUES("61","4","26");
INSERT INTO gz_ms_group_akses VALUES("62","4","27");
INSERT INTO gz_ms_group_akses VALUES("63","4","28");
INSERT INTO gz_ms_group_akses VALUES("64","4","29");
INSERT INTO gz_ms_group_akses VALUES("65","4","1");
INSERT INTO gz_ms_group_akses VALUES("66","4","9");
INSERT INTO gz_ms_group_akses VALUES("67","4","14");
INSERT INTO gz_ms_group_akses VALUES("68","4","30");
INSERT INTO gz_ms_group_akses VALUES("69","4","31");
INSERT INTO gz_ms_group_akses VALUES("70","4","32");
INSERT INTO gz_ms_group_akses VALUES("71","4","33");
INSERT INTO gz_ms_group_akses VALUES("76","5","1");
INSERT INTO gz_ms_group_akses VALUES("78","5","2");
INSERT INTO gz_ms_group_akses VALUES("79","5","4");
INSERT INTO gz_ms_group_akses VALUES("80","5","23");
INSERT INTO gz_ms_group_akses VALUES("81","5","24");
INSERT INTO gz_ms_group_akses VALUES("82","5","30");
INSERT INTO gz_ms_group_akses VALUES("83","5","33");
INSERT INTO gz_ms_group_akses VALUES("85","4","17");
INSERT INTO gz_ms_group_akses VALUES("86","4","34");



DROP TABLE gz_ms_group_petugas;

CREATE TABLE `gz_ms_group_petugas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ms_group_id` bigint(20) unsigned DEFAULT NULL,
  `ms_pegawai_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

INSERT INTO gz_ms_group_petugas VALUES("1","1","967");
INSERT INTO gz_ms_group_petugas VALUES("2","1","968");
INSERT INTO gz_ms_group_petugas VALUES("6","3","364");
INSERT INTO gz_ms_group_petugas VALUES("28","3","644");
INSERT INTO gz_ms_group_petugas VALUES("29","4","609");
INSERT INTO gz_ms_group_petugas VALUES("30","4","979");
INSERT INTO gz_ms_group_petugas VALUES("31","4","732");
INSERT INTO gz_ms_group_petugas VALUES("32","4","139");
INSERT INTO gz_ms_group_petugas VALUES("33","4","987");
INSERT INTO gz_ms_group_petugas VALUES("38","4","985");
INSERT INTO gz_ms_group_petugas VALUES("39","4","966");
INSERT INTO gz_ms_group_petugas VALUES("40","5","410");



DROP TABLE gz_ms_menu;

CREATE TABLE `gz_ms_menu` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(10) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `level` tinyint(3) unsigned DEFAULT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `parent_kode` varchar(10) DEFAULT NULL,
  `islast` tinyint(1) unsigned DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

INSERT INTO gz_ms_menu VALUES("1","1","MASTER","#","0","0","","0","1");
INSERT INTO gz_ms_menu VALUES("2","11","PENGGUNA","/simrs/gizi/master/pengguna.php","1","1","1","1","1");
INSERT INTO gz_ms_menu VALUES("4","12","BAHAN MAKANAN","/simrs/gizi/master/bhn_mkn.php?tipe=1","1","1","1","1","1");
INSERT INTO gz_ms_menu VALUES("9","2","PELAYANAN","#","0","0","","0","1");
INSERT INTO gz_ms_menu VALUES("10","21","JADWAL MENU","/simrs/gizi/master/jadwal_menu.php","1","9","2","1","1");
INSERT INTO gz_ms_menu VALUES("12","22","PERMINTAAN MAKAN","#","1","9","2","1","1");
INSERT INTO gz_ms_menu VALUES("14","3","LAPORAN","#","0","0","","0","1");
INSERT INTO gz_ms_menu VALUES("16","32","JADWAL MENU","/simrs/gizi/report/jadwalmenu.php","1","14","3","1","1");
INSERT INTO gz_ms_menu VALUES("17","33","PERMINTAAN MAKAN","/simrs/gizi/report/permintaanMakan.php","1","14","3","1","1");
INSERT INTO gz_ms_menu VALUES("22","31","STANDART PORSI","/simrs/gizi/report/standartPorsi.php","1","14","3","1","1");
INSERT INTO gz_ms_menu VALUES("23","13","KOMPONEN MENU","/simrs/gizi/master/bhn_mkn.php?tipe=2","1","1","1","1","1");
INSERT INTO gz_ms_menu VALUES("24","14","STANDART PORSI","/simrs/gizi/master/standart_porsi.php","1","1","1","1","1");
INSERT INTO gz_ms_menu VALUES("25","221","UNTUK PASIEN","/simrs/gizi/pelayanan/mintaPasien.php","2","12","22","1","1");
INSERT INTO gz_ms_menu VALUES("26","222","UNTUK TAMU/RAPAT","/simrs/gizi/pelayanan/mintaTamu.php?e=0","2","12","22","1","1");
INSERT INTO gz_ms_menu VALUES("27","331","UNTUK PASIEN","/simrs/gizi/report/makanPasien.php","2","17","33","1","1");
INSERT INTO gz_ms_menu VALUES("28","332","UNTUK TAMU/RAPAT","/simrs/gizi/report/makanTamu.php?e=2","2","17","33","1","1");
INSERT INTO gz_ms_menu VALUES("29","223","KIRIM UNTUK TAMU/RAPAT","/simrs/gizi/pelayanan/mintaTamu.php?e=1","2","12","22","1","1");
INSERT INTO gz_ms_menu VALUES("30","15","LINK ASET","/simrs/gizi/master/link_aset.php","1","1","1","1","1");
INSERT INTO gz_ms_menu VALUES("31","224","UNTUK PETUGAS","/simrs/gizi/pelayanan/mintaTamu.php?e=2","2","17","22","1","1");
INSERT INTO gz_ms_menu VALUES("32","333","UNTUK PETUGAS","/simrs/gizi/report/makanTamu.php?e=1","2","17","33","1","1");
INSERT INTO gz_ms_menu VALUES("33","16","JENIS MAKANAN","/simrs/gizi/master/jns_mkn.php","1","1","1","1","1");
INSERT INTO gz_ms_menu VALUES("34","34","PERKIRAAN BAHAN","/simrs/gizi/report/perkiraan_bahan.php","1","14","3","1","1");



DROP TABLE gz_ms_menu_bahan;

CREATE TABLE `gz_ms_menu_bahan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ms_menu_makan_id` bigint(20) unsigned DEFAULT '0',
  `ms_bahan_id` bigint(20) unsigned DEFAULT '0',
  `qty` double unsigned DEFAULT '1',
  `ket` text,
  `aktif` tinyint(1) unsigned DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO gz_ms_menu_bahan VALUES("1","10","1","1","","1");
INSERT INTO gz_ms_menu_bahan VALUES("2","10","2","1","","1");
INSERT INTO gz_ms_menu_bahan VALUES("3","10","3","1","","1");



DROP TABLE gz_ms_menu_jenis;

CREATE TABLE `gz_ms_menu_jenis` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(8) DEFAULT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `ket` varchar(150) DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `kode` (`kode`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

INSERT INTO gz_ms_menu_jenis VALUES("1","NASI","Nasi Non Diet","Makan Non Diet","0");
INSERT INTO gz_ms_menu_jenis VALUES("2","TIM/BK","Nasi Tim / Bubur Kasar","Nasi Tim / Bubur Kasar","0");
INSERT INTO gz_ms_menu_jenis VALUES("3","CACAH","Bubur Cacah","Bubur Cacah","0");
INSERT INTO gz_ms_menu_jenis VALUES("4","BS","Bubur Saring","Bubur Saring","0");
INSERT INTO gz_ms_menu_jenis VALUES("5","MLP","Makanan Lewat Pipa","","0");
INSERT INTO gz_ms_menu_jenis VALUES("7","MLA","Makanan Lewat Atap",":D Wow","0");
INSERT INTO gz_ms_menu_jenis VALUES("8","NB","Nasi Biasa","Nasi Biasa","1");
INSERT INTO gz_ms_menu_jenis VALUES("9","NT","Nasi Tim","Nasi Tim","1");
INSERT INTO gz_ms_menu_jenis VALUES("10","BS","Bubur Saring","Bubur Saring","1");
INSERT INTO gz_ms_menu_jenis VALUES("11","BB","Bubur Biasa","Bubur Biasa","1");
INSERT INTO gz_ms_menu_jenis VALUES("12","BC","Bubur Cair","Bubur Cair","1");
INSERT INTO gz_ms_menu_jenis VALUES("13","TB","Tim Baby","Tim Baby","1");
INSERT INTO gz_ms_menu_jenis VALUES("14","PU","Puasa","Puasa","1");



DROP TABLE gz_ms_menu_jenis_03072014;

CREATE TABLE `gz_ms_menu_jenis_03072014` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(8) DEFAULT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `ket` varchar(150) DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `kode` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

INSERT INTO gz_ms_menu_jenis_03072014 VALUES("1","NASI","Nasi Non Diet","Makan Non Diet","1");
INSERT INTO gz_ms_menu_jenis_03072014 VALUES("2","TIM/BK","Nasi Tim / Bubur Kasar","Nasi Tim / Bubur Kasar","1");
INSERT INTO gz_ms_menu_jenis_03072014 VALUES("3","CACAH","Bubur Cacah","Bubur Cacah","1");
INSERT INTO gz_ms_menu_jenis_03072014 VALUES("4","BS","Bubur Saring","Bubur Saring","1");
INSERT INTO gz_ms_menu_jenis_03072014 VALUES("5","MLP","Makanan Lewat Pipa","","1");
INSERT INTO gz_ms_menu_jenis_03072014 VALUES("7","MLA","Makanan Lewat Atap",":D Wow","1");



DROP TABLE gz_ms_menu_makan;

CREATE TABLE `gz_ms_menu_makan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(20) DEFAULT NULL,
  `nama` varchar(75) DEFAULT NULL,
  `level` tinyint(3) unsigned DEFAULT '1',
  `parent_id` bigint(20) unsigned DEFAULT '0',
  `parent_kode` varchar(20) DEFAULT NULL,
  `is_last` tinyint(1) unsigned DEFAULT '1',
  `aktif` tinyint(1) unsigned DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

INSERT INTO gz_ms_menu_makan VALUES("1","01","Makan Non Diet","1","0","","0","1");
INSERT INTO gz_ms_menu_makan VALUES("2","01.01","Lodeh + Ayam Goreng","2","1","01","1","1");
INSERT INTO gz_ms_menu_makan VALUES("3","01.02","Sop Buntut","2","1","01","1","1");
INSERT INTO gz_ms_menu_makan VALUES("4","01.03","Soto Ayam","2","1","01","1","1");
INSERT INTO gz_ms_menu_makan VALUES("7","01.04","Soto Daging","2","1","01","1","1");
INSERT INTO gz_ms_menu_makan VALUES("9","02","Makan Diet","1","0","","0","1");
INSERT INTO gz_ms_menu_makan VALUES("10","02.01","Bubur Ayam","2","9","02","1","1");
INSERT INTO gz_ms_menu_makan VALUES("11","02.02","Nasi Tim","2","9","02","1","1");
INSERT INTO gz_ms_menu_makan VALUES("12","03","Makan Diet Khusus","1","0","","0","1");
INSERT INTO gz_ms_menu_makan VALUES("13","03.01","Nasi Putih + Abon","2","12","03","1","1");



DROP TABLE gz_ms_satuan;

CREATE TABLE `gz_ms_satuan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `satuan` varchar(30) DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO gz_ms_satuan VALUES("1","gr","1");
INSERT INTO gz_ms_satuan VALUES("2","gr/butir","1");



DROP TABLE gz_ms_standart_porsi;

CREATE TABLE `gz_ms_standart_porsi` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ms_bhn_makan_id` bigint(20) unsigned DEFAULT '0',
  `ms_komponen_menu_id` bigint(20) unsigned DEFAULT '0' COMMENT '1=kering,2=basah',
  `ms_satuan_id` bigint(20) unsigned DEFAULT '0' COMMENT '1=bahan,2=komponenmenu',
  `berat` double unsigned DEFAULT '0',
  `ket` text,
  `aktif` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=282 DEFAULT CHARSET=latin1;

INSERT INTO gz_ms_standart_porsi VALUES("2","1","7","1","75","","1");
INSERT INTO gz_ms_standart_porsi VALUES("5","1","8","1","50","","1");
INSERT INTO gz_ms_standart_porsi VALUES("6","2","9","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("7","2","10","1","10","","1");
INSERT INTO gz_ms_standart_porsi VALUES("8","2","11","1","5","","1");
INSERT INTO gz_ms_standart_porsi VALUES("9","2","12","1","10","","1");
INSERT INTO gz_ms_standart_porsi VALUES("10","2","13","1","10","","1");
INSERT INTO gz_ms_standart_porsi VALUES("11","3","14","1","10","","1");
INSERT INTO gz_ms_standart_porsi VALUES("12","4","15","1","15","","1");
INSERT INTO gz_ms_standart_porsi VALUES("13","5","219","1","15","","1");
INSERT INTO gz_ms_standart_porsi VALUES("14","5","217","1","2.5","","1");
INSERT INTO gz_ms_standart_porsi VALUES("15","5","218","1","20","","1");
INSERT INTO gz_ms_standart_porsi VALUES("16","25","16","1","2.5","","1");
INSERT INTO gz_ms_standart_porsi VALUES("17","26","17","1","20","","1");
INSERT INTO gz_ms_standart_porsi VALUES("18","220","221","1","5","","1");
INSERT INTO gz_ms_standart_porsi VALUES("19","27","75","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("20","27","76","1","15","","1");
INSERT INTO gz_ms_standart_porsi VALUES("21","27","77","1","15","","1");
INSERT INTO gz_ms_standart_porsi VALUES("22","28","78","1","10","","1");
INSERT INTO gz_ms_standart_porsi VALUES("23","28","79","1","5","","1");
INSERT INTO gz_ms_standart_porsi VALUES("24","28","80","1","5","","1");
INSERT INTO gz_ms_standart_porsi VALUES("25","29","81","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("26","30","82","1","5","","1");
INSERT INTO gz_ms_standart_porsi VALUES("27","30","83","1","20","","1");
INSERT INTO gz_ms_standart_porsi VALUES("28","31","84","1","50","Lauk Utama","1");
INSERT INTO gz_ms_standart_porsi VALUES("29","31","85","1","50","Lauk Utama","1");
INSERT INTO gz_ms_standart_porsi VALUES("30","31","86","1","25","Lauk Utama","1");
INSERT INTO gz_ms_standart_porsi VALUES("31","31","87","1","40","Lauk Utama","1");
INSERT INTO gz_ms_standart_porsi VALUES("32","31","222","1","25","Lauk Utama","1");
INSERT INTO gz_ms_standart_porsi VALUES("33","31","88","1","40","Lauk Utama","1");
INSERT INTO gz_ms_standart_porsi VALUES("34","31","89","1","40","","1");
INSERT INTO gz_ms_standart_porsi VALUES("36","32","91","1","75","Lauk Utama","1");
INSERT INTO gz_ms_standart_porsi VALUES("37","32","92","1","50","Lauk Utama","1");
INSERT INTO gz_ms_standart_porsi VALUES("38","32","93","1","50","Lauk Utama","1");
INSERT INTO gz_ms_standart_porsi VALUES("39","32","94","1","75","Lauk Ekstra","1");
INSERT INTO gz_ms_standart_porsi VALUES("40","32","95","1","75","Lauk Ekstra","1");
INSERT INTO gz_ms_standart_porsi VALUES("41","32","96","1","50","Lauk Ekstra","1");
INSERT INTO gz_ms_standart_porsi VALUES("42","32","97","1","50","Lauk Ekstra","1");
INSERT INTO gz_ms_standart_porsi VALUES("43","33","98","1","100","Lauk Utama","1");
INSERT INTO gz_ms_standart_porsi VALUES("44","33","99","1","100","Lauk Utama","1");
INSERT INTO gz_ms_standart_porsi VALUES("45","34","100","1","50","Lauk Utama","1");
INSERT INTO gz_ms_standart_porsi VALUES("46","34","101","1","50","Lauk Utama","1");
INSERT INTO gz_ms_standart_porsi VALUES("47","34","102","1","25","Lauk Utama","1");
INSERT INTO gz_ms_standart_porsi VALUES("48","35","103","1","90","Lauk Utama","1");
INSERT INTO gz_ms_standart_porsi VALUES("49","35","104","1","90","Lauk Utama","1");
INSERT INTO gz_ms_standart_porsi VALUES("50","36","105","1","50","Lauk Utama","1");
INSERT INTO gz_ms_standart_porsi VALUES("51","36","106","1","50","Lauk Utama","1");
INSERT INTO gz_ms_standart_porsi VALUES("52","37","107","2","60","Lauk Utama","1");
INSERT INTO gz_ms_standart_porsi VALUES("53","37","108","2","60","Lauk Utama","1");
INSERT INTO gz_ms_standart_porsi VALUES("54","37","109","1","15","Lauk Ekstra","1");
INSERT INTO gz_ms_standart_porsi VALUES("55","37","110","1","30","Lauk Ekstra","1");
INSERT INTO gz_ms_standart_porsi VALUES("56","37","111","1","30","Lauk Ekstra","1");
INSERT INTO gz_ms_standart_porsi VALUES("57","37","112","1","15","RSU(15) , PAV(30)","1");
INSERT INTO gz_ms_standart_porsi VALUES("58","38","113","1","60","Lauk Utama","1");
INSERT INTO gz_ms_standart_porsi VALUES("59","38","114","1","60","Lauk Utama","1");
INSERT INTO gz_ms_standart_porsi VALUES("60","39","115","1","30","","1");
INSERT INTO gz_ms_standart_porsi VALUES("61","39","116","1","30","","1");
INSERT INTO gz_ms_standart_porsi VALUES("62","39","117","1","10","","1");
INSERT INTO gz_ms_standart_porsi VALUES("63","40","118","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("64","40","119","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("65","40","120","1","30","","1");
INSERT INTO gz_ms_standart_porsi VALUES("67","40","122","1","30","","1");
INSERT INTO gz_ms_standart_porsi VALUES("68","40","124","1","30","","1");
INSERT INTO gz_ms_standart_porsi VALUES("69","40","125","1","30","","1");
INSERT INTO gz_ms_standart_porsi VALUES("70","41","126","1","40","","1");
INSERT INTO gz_ms_standart_porsi VALUES("71","41","127","1","40","","1");
INSERT INTO gz_ms_standart_porsi VALUES("72","41","128","1","40","","1");
INSERT INTO gz_ms_standart_porsi VALUES("73","41","129","1","40","","1");
INSERT INTO gz_ms_standart_porsi VALUES("74","41","130","1","40","","1");
INSERT INTO gz_ms_standart_porsi VALUES("75","41","131","1","40","","1");
INSERT INTO gz_ms_standart_porsi VALUES("76","42","132","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("77","42","133","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("78","223","134","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("79","223","135","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("80","43","136","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("81","43","137","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("82","44","138","1","15","","1");
INSERT INTO gz_ms_standart_porsi VALUES("83","45","139","1","10","","1");
INSERT INTO gz_ms_standart_porsi VALUES("85","45","144","1","10","","1");
INSERT INTO gz_ms_standart_porsi VALUES("86","45","141","1","10","","1");
INSERT INTO gz_ms_standart_porsi VALUES("87","45","143","1","20","","1");
INSERT INTO gz_ms_standart_porsi VALUES("88","46","144","1","10","","1");
INSERT INTO gz_ms_standart_porsi VALUES("89","46","145","1","20","","1");
INSERT INTO gz_ms_standart_porsi VALUES("90","46","146","1","10","","1");
INSERT INTO gz_ms_standart_porsi VALUES("91","47","147","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("92","47","148","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("93","47","149","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("94","48","150","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("95","49","151","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("96","49","152","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("97","50","154","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("98","50","155","1","30","","1");
INSERT INTO gz_ms_standart_porsi VALUES("99","51","156","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("100","51","157","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("101","51","158","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("102","51","159","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("103","51","160","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("104","51","161","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("105","52","162","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("106","52","163","1","75","","1");
INSERT INTO gz_ms_standart_porsi VALUES("107","52","164","1","75","","1");
INSERT INTO gz_ms_standart_porsi VALUES("108","52","166","1","75","","1");
INSERT INTO gz_ms_standart_porsi VALUES("110","52","167","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("111","52","168","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("112","52","169","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("113","52","170","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("114","53","171","1","75","","1");
INSERT INTO gz_ms_standart_porsi VALUES("115","53","172","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("116","53","173","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("117","53","174","1","30","","1");
INSERT INTO gz_ms_standart_porsi VALUES("118","53","175","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("119","53","176","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("120","54","177","1","40","","1");
INSERT INTO gz_ms_standart_porsi VALUES("121","56","178","1","75","","1");
INSERT INTO gz_ms_standart_porsi VALUES("122","57","179","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("123","58","180","1","50","","1");
INSERT INTO gz_ms_standart_porsi VALUES("124","58","181","1","50","","1");
INSERT INTO gz_ms_standart_porsi VALUES("125","58","182","1","75","","1");
INSERT INTO gz_ms_standart_porsi VALUES("126","59","183","1","75","","1");
INSERT INTO gz_ms_standart_porsi VALUES("127","59","184","1","30","","1");
INSERT INTO gz_ms_standart_porsi VALUES("128","59","185","1","30","","1");
INSERT INTO gz_ms_standart_porsi VALUES("129","59","186","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("130","60","187","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("131","60","188","1","35","Buncis dari kota malang","1");
INSERT INTO gz_ms_standart_porsi VALUES("132","60","189","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("133","61","201","1","50","","1");
INSERT INTO gz_ms_standart_porsi VALUES("134","61","191","1","50","Sawi hijau mengandung banyak Protein","1");
INSERT INTO gz_ms_standart_porsi VALUES("135","62","192","1","15","Keterangan","1");
INSERT INTO gz_ms_standart_porsi VALUES("136","62","80","1","15","","1");
INSERT INTO gz_ms_standart_porsi VALUES("137","62","185","1","10","","1");
INSERT INTO gz_ms_standart_porsi VALUES("138","62","161","1","10","","1");
INSERT INTO gz_ms_standart_porsi VALUES("139","62","112","1","10","","1");
INSERT INTO gz_ms_standart_porsi VALUES("140","63","197","1","15","","1");
INSERT INTO gz_ms_standart_porsi VALUES("141","63","162","1","15","","1");
INSERT INTO gz_ms_standart_porsi VALUES("142","63","189","1","15","","1");
INSERT INTO gz_ms_standart_porsi VALUES("143","64","167","1","20","","1");
INSERT INTO gz_ms_standart_porsi VALUES("144","64","142","1","20","","1");
INSERT INTO gz_ms_standart_porsi VALUES("145","64","144","1","20","","1");
INSERT INTO gz_ms_standart_porsi VALUES("146","65","116","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("147","65","112","1","15","","1");
INSERT INTO gz_ms_standart_porsi VALUES("148","65","205","1","30","","1");
INSERT INTO gz_ms_standart_porsi VALUES("149","66","206","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("150","67","207","1","100","","1");
INSERT INTO gz_ms_standart_porsi VALUES("151","68","208","1","125","","1");
INSERT INTO gz_ms_standart_porsi VALUES("153","69","210","1","125","","1");
INSERT INTO gz_ms_standart_porsi VALUES("155","70","212","1","125","","1");
INSERT INTO gz_ms_standart_porsi VALUES("156","71","213","1","100","","1");
INSERT INTO gz_ms_standart_porsi VALUES("157","72","157","1","100","","1");
INSERT INTO gz_ms_standart_porsi VALUES("158","33","158","1","75","","1");
INSERT INTO gz_ms_standart_porsi VALUES("159","74","211","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("173","1","6","1","100","","1");
INSERT INTO gz_ms_standart_porsi VALUES("174","28","12","1","5","","1");
INSERT INTO gz_ms_standart_porsi VALUES("175","228","227","1","50","","1");
INSERT INTO gz_ms_standart_porsi VALUES("176","228","8","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("177","228","86","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("178","228","87","1","40","","1");
INSERT INTO gz_ms_standart_porsi VALUES("179","228","88","1","40","","1");
INSERT INTO gz_ms_standart_porsi VALUES("180","228","89","1","40","","1");
INSERT INTO gz_ms_standart_porsi VALUES("181","228","90","1","50","","1");
INSERT INTO gz_ms_standart_porsi VALUES("182","32","8","1","50","","1");
INSERT INTO gz_ms_standart_porsi VALUES("183","32","86","1","50","","1");
INSERT INTO gz_ms_standart_porsi VALUES("184","32","83","1","50","","1");
INSERT INTO gz_ms_standart_porsi VALUES("186","35","226","1","90","","1");
INSERT INTO gz_ms_standart_porsi VALUES("187","34","231","1","50","","1");
INSERT INTO gz_ms_standart_porsi VALUES("188","36","233","1","50","Bandengnya yang banyak ya","1");
INSERT INTO gz_ms_standart_porsi VALUES("189","37","234","1","60","","1");
INSERT INTO gz_ms_standart_porsi VALUES("190","37","197","1","30","","1");
INSERT INTO gz_ms_standart_porsi VALUES("191","38","235","1","60","","1");
INSERT INTO gz_ms_standart_porsi VALUES("192","39","90","1","10","","1");
INSERT INTO gz_ms_standart_porsi VALUES("193","40","13","1","30","","1");
INSERT INTO gz_ms_standart_porsi VALUES("194","40","123","1","30","","1");
INSERT INTO gz_ms_standart_porsi VALUES("195","40","116","1","30","","1");
INSERT INTO gz_ms_standart_porsi VALUES("196","223","224","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("197","44","142","1","15","","1");
INSERT INTO gz_ms_standart_porsi VALUES("198","45","202","1","10","","1");
INSERT INTO gz_ms_standart_porsi VALUES("199","45","142","1","10","","1");
INSERT INTO gz_ms_standart_porsi VALUES("200","46","202","1","10","","1");
INSERT INTO gz_ms_standart_porsi VALUES("201","48","116","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("202","49","116","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("203","49","153","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("204","51","175","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("205","51","174","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("206","51","185","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("207","51","195","1","25","","1");
INSERT INTO gz_ms_standart_porsi VALUES("208","52","198","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("209","52","82","1","75","","1");
INSERT INTO gz_ms_standart_porsi VALUES("210","52","165","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("211","52","142","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("212","52","199","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("213","53","158","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("214","53","116","1","40","","1");
INSERT INTO gz_ms_standart_porsi VALUES("215","57","158","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("216","58","176","1","50","","1");
INSERT INTO gz_ms_standart_porsi VALUES("217","59","175","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("218","60","198","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("219","60","199","1","35","","1");
INSERT INTO gz_ms_standart_porsi VALUES("220","53","142","2","33","fyfyutyt","1");
INSERT INTO gz_ms_standart_porsi VALUES("221","62","175","1","15","","1");
INSERT INTO gz_ms_standart_porsi VALUES("222","62","195","1","10","","1");
INSERT INTO gz_ms_standart_porsi VALUES("223","62","197","1","10","","1");
INSERT INTO gz_ms_standart_porsi VALUES("224","63","198","1","15","","1");
INSERT INTO gz_ms_standart_porsi VALUES("225","63","199","1","15","","1");
INSERT INTO gz_ms_standart_porsi VALUES("226","64","202","1","20","","1");
INSERT INTO gz_ms_standart_porsi VALUES("227","65","197","1","15","","1");
INSERT INTO gz_ms_standart_porsi VALUES("228","37","94","2","5","","1");
INSERT INTO gz_ms_standart_porsi VALUES("229","25","233","1","20","daun teh pilihan..pucuk pucuk","1");
INSERT INTO gz_ms_standart_porsi VALUES("230","33","230","1","2342","wrdfwe","1");
INSERT INTO gz_ms_standart_porsi VALUES("232","58","111","2","2","qeqwe","0");
INSERT INTO gz_ms_standart_porsi VALUES("233","1","6","1","2","","1");
INSERT INTO gz_ms_standart_porsi VALUES("234","1","111","2","3","wre","1");
INSERT INTO gz_ms_standart_porsi VALUES("235","1","140","2","600","beras kok satuannya butir?","1");
INSERT INTO gz_ms_standart_porsi VALUES("236","35","140","2","302","bakso apa ini y?..","1");
INSERT INTO gz_ms_standart_porsi VALUES("239","58","140","1","45","Bayam popeye","1");
INSERT INTO gz_ms_standart_porsi VALUES("240","1","6","2","500","ttt","1");
INSERT INTO gz_ms_standart_porsi VALUES("243","48","6","1","99","7","1");
INSERT INTO gz_ms_standart_porsi VALUES("245","32","6","1","44","444","1");
INSERT INTO gz_ms_standart_porsi VALUES("246","1","6","1","0","g","1");
INSERT INTO gz_ms_standart_porsi VALUES("247","1","6","1","0","h","1");
INSERT INTO gz_ms_standart_porsi VALUES("248","35","6","1","9","jj","1");
INSERT INTO gz_ms_standart_porsi VALUES("249","48","6","1","8","jjj","1");
INSERT INTO gz_ms_standart_porsi VALUES("250","48","94","1","20","","1");
INSERT INTO gz_ms_standart_porsi VALUES("252","66","6","1","12","","1");
INSERT INTO gz_ms_standart_porsi VALUES("254","25","6","1","12","wwq","1");
INSERT INTO gz_ms_standart_porsi VALUES("257","25","6","1","88","888","1");
INSERT INTO gz_ms_standart_porsi VALUES("270","73","140","1","22","2222","0");
INSERT INTO gz_ms_standart_porsi VALUES("273","48","111","1","66","ujtyuty","1");
INSERT INTO gz_ms_standart_porsi VALUES("275","73","230","1","45","dsfgdf121212","1");
INSERT INTO gz_ms_standart_porsi VALUES("276","45","230","1","50","Bakso Kotak","1");
INSERT INTO gz_ms_standart_porsi VALUES("278","5","233","1","200","gula dan pasir","1");
INSERT INTO gz_ms_standart_porsi VALUES("280","64","94","1","90","enaaak","1");
INSERT INTO gz_ms_standart_porsi VALUES("281","33","10","1","90","","1");



DROP TABLE gz_ms_unit;

CREATE TABLE `gz_ms_unit` (
  `id` bigint(20) unsigned NOT NULL,
  `kelas` varchar(30) DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT '1',
  `id_kelas_billing` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO gz_ms_unit VALUES("1","RI Kelas I","1","2");
INSERT INTO gz_ms_unit VALUES("2","RI Kelas II","1","3");
INSERT INTO gz_ms_unit VALUES("3","RI Kelas III","1","4");
INSERT INTO gz_ms_unit VALUES("4","PAVILYUN","1","5");



DROP TABLE gz_siklus_jadwal_menu;

CREATE TABLE `gz_siklus_jadwal_menu` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `hari` bigint(31) DEFAULT NULL,
  `pasiso` tinyint(1) unsigned DEFAULT '1' COMMENT '1=pagi,2=siang,3=sore',
  `ms_menu_jenis_id` bigint(20) DEFAULT '0',
  `ms_komp_menu_id` bigint(20) unsigned DEFAULT '0',
  `qty` double unsigned DEFAULT '1',
  `ms_unit_id` bigint(20) unsigned DEFAULT '0',
  `user_act` bigint(20) unsigned DEFAULT '0',
  `tgl_act` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=latin1;

INSERT INTO gz_siklus_jadwal_menu VALUES("34","1","1","1","8","1","1","732","2012-12-27 13:25:16");
INSERT INTO gz_siklus_jadwal_menu VALUES("35","1","1","1","17","1","1","732","2012-12-27 13:25:16");
INSERT INTO gz_siklus_jadwal_menu VALUES("36","1","1","1","77","1","1","732","2012-12-27 13:25:16");
INSERT INTO gz_siklus_jadwal_menu VALUES("37","1","2","3","7","1","1","732","2012-12-27 13:25:36");
INSERT INTO gz_siklus_jadwal_menu VALUES("38","1","2","3","12","1","1","732","2012-12-27 13:25:36");
INSERT INTO gz_siklus_jadwal_menu VALUES("39","1","2","3","13","1","1","732","2012-12-27 13:25:36");
INSERT INTO gz_siklus_jadwal_menu VALUES("40","1","3","3","9","1","1","732","2012-12-27 13:25:51");
INSERT INTO gz_siklus_jadwal_menu VALUES("41","1","3","3","10","1","1","732","2012-12-27 13:25:51");
INSERT INTO gz_siklus_jadwal_menu VALUES("42","1","3","3","11","1","1","732","2012-12-27 13:25:51");
INSERT INTO gz_siklus_jadwal_menu VALUES("43","1","1","3","9","1","2","732","2012-12-27 13:26:44");
INSERT INTO gz_siklus_jadwal_menu VALUES("44","1","1","3","89","1","2","732","2012-12-27 13:26:44");
INSERT INTO gz_siklus_jadwal_menu VALUES("45","1","1","3","91","1","2","732","2012-12-27 13:26:44");
INSERT INTO gz_siklus_jadwal_menu VALUES("46","1","2","3","8","1","2","732","2012-12-27 13:27:04");
INSERT INTO gz_siklus_jadwal_menu VALUES("47","1","2","3","13","1","2","732","2012-12-27 13:27:04");
INSERT INTO gz_siklus_jadwal_menu VALUES("48","1","2","3","76","1","2","732","2012-12-27 13:27:04");
INSERT INTO gz_siklus_jadwal_menu VALUES("49","1","3","3","8","1","2","732","2012-12-27 13:27:15");
INSERT INTO gz_siklus_jadwal_menu VALUES("50","1","3","3","13","1","2","732","2012-12-27 13:27:15");
INSERT INTO gz_siklus_jadwal_menu VALUES("51","1","3","3","76","1","2","732","2012-12-27 13:27:15");
INSERT INTO gz_siklus_jadwal_menu VALUES("52","1","3","3","234","1","2","732","2012-12-27 13:27:15");
INSERT INTO gz_siklus_jadwal_menu VALUES("53","1","3","3","235","1","2","732","2012-12-27 13:27:15");
INSERT INTO gz_siklus_jadwal_menu VALUES("54","1","3","3","237","1","2","732","2012-12-27 13:27:15");
INSERT INTO gz_siklus_jadwal_menu VALUES("56","1","1","3","7","1","3","732","2012-12-27 13:28:10");
INSERT INTO gz_siklus_jadwal_menu VALUES("57","1","1","3","10","1","3","732","2012-12-27 13:28:10");
INSERT INTO gz_siklus_jadwal_menu VALUES("58","1","1","3","12","1","3","732","2012-12-27 13:28:10");
INSERT INTO gz_siklus_jadwal_menu VALUES("59","1","1","3","237","1","3","732","2012-12-27 13:28:10");
INSERT INTO gz_siklus_jadwal_menu VALUES("63","1","1","1","7","1","4","732","2012-12-27 16:43:15");
INSERT INTO gz_siklus_jadwal_menu VALUES("64","1","1","1","11","1","4","732","2012-12-27 16:43:15");
INSERT INTO gz_siklus_jadwal_menu VALUES("65","1","1","1","13","1","4","732","2012-12-27 16:43:15");
INSERT INTO gz_siklus_jadwal_menu VALUES("66","1","2","1","7","1","4","732","2012-12-27 16:43:26");
INSERT INTO gz_siklus_jadwal_menu VALUES("67","1","2","1","10","1","4","732","2012-12-27 16:43:26");
INSERT INTO gz_siklus_jadwal_menu VALUES("68","1","2","1","11","1","4","732","2012-12-27 16:43:26");
INSERT INTO gz_siklus_jadwal_menu VALUES("69","1","3","1","7","1","4","732","2012-12-27 16:43:35");
INSERT INTO gz_siklus_jadwal_menu VALUES("70","1","3","1","8","1","4","732","2012-12-27 16:43:35");
INSERT INTO gz_siklus_jadwal_menu VALUES("71","1","3","1","14","1","4","732","2012-12-27 16:43:35");
INSERT INTO gz_siklus_jadwal_menu VALUES("72","2","1","1","7","1","1","732","2012-12-28 14:27:31");
INSERT INTO gz_siklus_jadwal_menu VALUES("73","2","1","1","155","1","1","732","2012-12-28 14:27:31");
INSERT INTO gz_siklus_jadwal_menu VALUES("74","2","1","1","173","1","1","732","2012-12-28 14:27:31");
INSERT INTO gz_siklus_jadwal_menu VALUES("75","2","2","1","8","1","1","732","2012-12-28 15:44:46");
INSERT INTO gz_siklus_jadwal_menu VALUES("76","2","2","1","143","1","1","732","2012-12-28 15:44:46");
INSERT INTO gz_siklus_jadwal_menu VALUES("77","2","2","1","145","1","1","732","2012-12-28 15:44:46");
INSERT INTO gz_siklus_jadwal_menu VALUES("78","2","2","1","146","1","1","732","2012-12-28 15:44:46");
INSERT INTO gz_siklus_jadwal_menu VALUES("82","2","3","1","8","1","1","732","2012-12-28 15:45:34");
INSERT INTO gz_siklus_jadwal_menu VALUES("83","2","3","1","11","1","1","732","2012-12-28 15:45:34");
INSERT INTO gz_siklus_jadwal_menu VALUES("84","2","3","1","12","1","1","732","2012-12-28 15:45:34");
INSERT INTO gz_siklus_jadwal_menu VALUES("85","2","3","1","14","1","1","732","2012-12-28 15:45:34");
INSERT INTO gz_siklus_jadwal_menu VALUES("89","2","1","1","8","1","2","732","2012-12-28 15:54:56");
INSERT INTO gz_siklus_jadwal_menu VALUES("90","2","1","1","17","1","2","732","2012-12-28 15:54:56");
INSERT INTO gz_siklus_jadwal_menu VALUES("91","2","1","1","91","1","2","732","2012-12-28 15:54:56");
INSERT INTO gz_siklus_jadwal_menu VALUES("92","2","2","2","8","1","2","732","2012-12-28 16:14:27");
INSERT INTO gz_siklus_jadwal_menu VALUES("93","2","2","2","230","1","2","732","2012-12-28 16:14:27");
INSERT INTO gz_siklus_jadwal_menu VALUES("94","2","2","2","237","1","2","732","2012-12-28 16:14:27");
INSERT INTO gz_siklus_jadwal_menu VALUES("95","2","3","1","8","1","2","732","2012-12-28 16:15:40");
INSERT INTO gz_siklus_jadwal_menu VALUES("96","2","3","1","152","1","2","732","2012-12-28 16:15:40");
INSERT INTO gz_siklus_jadwal_menu VALUES("97","2","3","1","153","1","2","732","2012-12-28 16:15:40");



