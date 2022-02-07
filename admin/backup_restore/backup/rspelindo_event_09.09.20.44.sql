DROP TABLE pengaturan;

CREATE TABLE `pengaturan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kecepatan` int(11) NOT NULL,
  `warna_bg` varchar(20) NOT NULL,
  `warna_teks` varchar(20) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

INSERT INTO pengaturan VALUES("1","10","Black","White");



DROP TABLE slider;

CREATE TABLE `slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `tanggal` date NOT NULL,
  `tgl` varchar(50) NOT NULL,
  `tgl_siap` date NOT NULL,
  `image` text NOT NULL,
  `flag` int(1) NOT NULL COMMENT '0=default, 1=event',
  `status` int(11) DEFAULT NULL,
  `refresh` int(1) NOT NULL COMMENT '0 = ''sudah'', 1 = ''Belum/Akan direfresh''',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

INSERT INTO slider VALUES("71","Struktur Kepala Manusia","RS Prima Husada Cipta Medan Mengucapkan Selamat Menunaikan Ibadah Puasa 1440 H","2019-02-07","2019-02-07 - 2019-02-08","0000-00-00","13966.jpg","0","1","0");
INSERT INTO slider VALUES("73","Tips Agar Tubuh Tetap Sehat di Bulan Puasa","RS Prima Husada Cipta Medan Mengucapkan Selamat Menunaikan Ibadah Puasa 1440 H","2019-02-09","2019-02-15 - 2019-02-15","0000-00-00","Health-HD-Desktop-Wallpaper-29842.jpg","0","1","0");



DROP TABLE teks_berjalan;

CREATE TABLE `teks_berjalan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teks` text NOT NULL,
  `tanggal` date NOT NULL,
  `status` int(1) NOT NULL,
  `flag` int(1) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;




