function MM_showMenu(menu, x, y, child, imgname) {
	if (!window.mmWroteMenu) return;
	MM_clearTimeout();
	if (menu) {
		var obj = FIND(imgname) || document.images[imgname] || document.links[imgname] || document.anchors[imgname];
		x = moveXbySlicePos (x, obj);
		y = moveYbySlicePos (y, obj);
	}
	if (document.layers) {
		if (menu) {
			var l = menu.menuLayer || menu;
			l.top = l.left = 1;
			hideActiveMenus();
			if (this.visibility) l = this;
			window.ActiveMenu = l;
		} else {
			var l = child;
		}
		if (!l) return;
		for (var i=0; i<l.layers.length; i++) { 			   
			if (!l.layers[i].isHilite) l.layers[i].visibility = "inherit";
			if (l.layers[i].document.layers.length > 0) MM_showMenu(null, "relative", "relative", l.layers[i]);
		}
		if (l.parentLayer) {
			if (x != "relative") l.parentLayer.left = x || window.pageX || 0;
			if (l.parentLayer.left + l.clip.width > window.innerWidth) l.parentLayer.left -= (l.parentLayer.left + l.clip.width - window.innerWidth);
			if (y != "relative") l.parentLayer.top = y || window.pageY || 0;
			if (l.parentLayer.isContainer) {
				l.Menu.xOffset = window.pageXOffset;
				l.Menu.yOffset = window.pageYOffset;
				l.parentLayer.clip.width = window.ActiveMenu.clip.width +2;
				l.parentLayer.clip.height = window.ActiveMenu.clip.height +2;
				if (l.parentLayer.menuContainerBgColor && l.Menu.menuBgOpaque ) l.parentLayer.document.bgColor = l.parentLayer.menuContainerBgColor;
			}
		}
		l.visibility = "inherit";
		if (l.Menu) l.Menu.container.visibility = "inherit";
	} else if (FIND("menuItem0")) {
		var l = menu.menuLayer || menu;	
		hideActiveMenus();
		if (typeof(l) == "string") l = FIND(l);
		window.ActiveMenu = l;
		var s = l.style;
		s.visibility = "inherit";
		if (x != "relative") {
			s.pixelLeft = x || (window.pageX + document.body.scrollLeft) || 0;
			s.left = s.pixelLeft + 'px';
		}
		if (y != "relative") {
			s.pixelTop = y || (window.pageY + document.body.scrollTop) || 0;
			s.top = s.pixelTop + 'px';
		}
		l.Menu.xOffset = document.body.scrollLeft;
		l.Menu.yOffset = document.body.scrollTop;
	}
	if (menu) window.activeMenus[window.activeMenus.length] = l;
	MM_clearTimeout();
}
function mmLoadMenus() {
   window.mm_menu_0814123211_3 = new Menu("root", 135, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_3.addMenuItem("A1.1 Unit","location='?f=../master/unit'");
   mm_menu_0814123211_3.addMenuItem("A1.2 PBF","location='?f=../master/pbf'");
   mm_menu_0814123211_3.addMenuItem("A1.3 Bentuk","location='?f=../master/bentuk'");
   mm_menu_0814123211_3.addMenuItem("A1.4 Satuan","location='?f=../master/satuan'");
   mm_menu_0814123211_3.addMenuItem("A1.5 Jenis Obat","location='?f=../master/kelas'");
   mm_menu_0814123211_3.addMenuItem("A1.6 Principle","location='?f=../master/pabrik'");
   mm_menu_0814123211_3.addMenuItem("A1.7 KSO","location='?f=../master/mitra'");
   mm_menu_0814123211_3.addMenuItem("A1.8 Obat ","location='?f=../master/obat'");
   mm_menu_0814123211_3.addMenuItem("A1.9 Harga Obat","location='?f=../master/harga'");
   mm_menu_0814123211_3.addMenuItem("A1.10 User","location='?f=../master/user'");
   mm_menu_0814123211_3.addMenuItem("A1.11 Pegawai","location='?f=../master/pegawai'");
   mm_menu_0814123211_3.addMenuItem("A1.12 Batas Expired","location='?f=../master/batas_expired'");
   mm_menu_0814123211_3.addMenuItem("A1.13 Kepemilikan","location='?f=../master/kepemilikan'");
   mm_menu_0814123211_3.addMenuItem("A1.14 BHP Askes","location='?f=../master/bhp_askes'");
   
   window.mm_menu_0814123212_3 = new Menu("root", 180, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123212_3.addMenuItem("A2.1 Pembelian Ke PBF","location='?f=../gudang/penerimaan&tipe=1'");
   mm_menu_0814123212_3.addMenuItem("A2.2 Konsinyasi/Hibah/Return","location='?f=../gudang/penerimaan&tipe=2'");
   /*mm_menu_0814123212_3.addMenuItem("A2.3 Koreksi Penerimaan","location='?f=../gudang/penerimaan&tipe=3'");*/

	window.mm_menu_0814123211_2_1 = new Menu("A8.12 Pemda", 160, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_2_1.addMenuItem("A8.12.1 Kartu Barang","location='?f=../report/kartu_barang.php'");
   mm_menu_0814123211_2_1.addMenuItem("A8.12.2 Pengadaan","location='?f=../report/pengadaan.php'");
   mm_menu_0814123211_2_1.addMenuItem("A8.12.3 Persediaan","location='#'");
   mm_menu_0814123211_2_1.addMenuItem("A8.12.4 Mutasi","location='#'");

	window.mm_menu_0814123211_2_2 = new Menu("A8.6 Penjualan Apotik", 160, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_2_2.addMenuItem("A8.6.1 Penjualan Obat","location='?f=../gudang/list_penjualan.php'");
   mm_menu_0814123211_2_2.addMenuItem("A8.6.2 Rekap Penjualan","location='?f=../apotik/sum_pendapatan.php'");
   mm_menu_0814123211_2_2.addMenuItem("A8.6.3 Buku Penjualan","location='?f=../apotik/buku_penjualan.php'");
   mm_menu_0814123211_2_2.addMenuItem("A8.6.4 Kelompok Harga","location='?f=../apotik/penjualan_perKelHarga.php'");
   mm_menu_0814123211_2_2.addMenuItem("A8.6.5 Resep Ruangan","location='?f=../floorstock/rpt_pemakaian_ruangan.php'");
   mm_menu_0814123211_2_2.addMenuItem("A8.6.6 Penjualan Unit","location='?f=../apotik/list_penjualan.php'");

	window.mm_menu_0814123211_2_3 = new Menu("A8.7 Pengeluaran FS", 190, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_2_3.addMenuItem("A8.7.1 Detail Pengeluaran FS","location='?f=../floorstock/list_pembelian.php&idunit=20'");
   mm_menu_0814123211_2_3.addMenuItem("A8.7.2 Rekap Pengeluaran FS","location='?f=../floorstock/rpt_pemakaian_ruangan.php&idunit=20'");

	window.mm_menu_0814123211_2_4 = new Menu("A8.5 Return Obat", 160, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_2_4.addMenuItem("A8.5.1 Retur ke PBF","location='?f=../gudang/obat_kepbf.php'");
   mm_menu_0814123211_2_4.addMenuItem("A8.5.2 Retur dari Unit","location='?f=../gudang/retur_unit.php'");

	window.mm_menu_0814123211_2_5 = new Menu("A8.1 Stok", 150, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left","middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_2_5.addMenuItem("A8.1.1 Stok Per Unit","location='?f=../transaksi/stok_view.php'");
   mm_menu_0814123211_2_5.addMenuItem("A8.1.2 Stok Seluruh Unit","location='?f=../master/stokall.php'");
   mm_menu_0814123211_2_5.addMenuItem("A8.1.3 Stok Opname","location='?f=../report/rpt_opname.php'");
   mm_menu_0814123211_2_5.addMenuItem("A8.1.4 Stok < Stok Min","location='?f=../report/stok_minimum.php'");
   mm_menu_0814123211_2_5.addMenuItem("A8.1.5 Stok Akhir Bulan","location='?f=../transaksi/stok_akhir_bulan.php'");

	window.mm_menu_0814123211_2_6 = new Menu("A8.2 Pemakaian", 150, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_2_6.addMenuItem("A8.2.1 Per Unit","location='?f=../transaksi/jual_view_qty.php'");
   mm_menu_0814123211_2_6.addMenuItem("A8.2.2 All Unit","location='?f=../master/jualall_qty.php'");

	window.mm_menu_0814123211_2_7 = new Menu("A8.3 Penerimaan", 150, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_2_7.addMenuItem("A8.2.1 Pembelian","location='?f=../gudang/penerimaan_detail_report'");
   mm_menu_0814123211_2_7.addMenuItem("A8.2.2 Hibah/Konsinyasi/Return","location='?f=../gudang/penerimaan_detail_report'");

	window.mm_menu_0814123211_2_8 = new Menu("A8.4 Pengeluaran", 180, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_2_8.addMenuItem("A8.4.1 Obat","location='?f=../gudang/list_mutasi.php'");
   mm_menu_0814123211_2_8.addMenuItem("A8.4.2 NAPZA","location='?f=../report/rpt_napza.php'");
   mm_menu_0814123211_2_8.addMenuItem("A8.4.3 Obat Tak Terlayani","location='?f=../gudang/permintaan_tak_terlayani.php'");

	window.mm_menu_0814123211_2_9 = new Menu("A8.8 Obat", 180, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left","middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_2_9.addMenuItem("A8.8.1 Pemantauan Obat","location='?f=../transaksi/rpt_obat_terlayani.php'");
   mm_menu_0814123211_2_9.addMenuItem("A8.8.2 Daftar Obat Expired","location='?f=../apotik/list_expired.php'");
   mm_menu_0814123211_2_9.addMenuItem("A8.8.3 Fast Moving","location='?f=../master/fast_moving.php&tipe=1'");
   mm_menu_0814123211_2_9.addMenuItem("A8.8.4 Slow Moving","location='?f=../master/fast_moving.php&tipe=2'");
   //mm_menu_0814123211_2_9.addMenuItem("A8.8.5 Stok Akhir Bulan","location='?f=../transaksi/stok_akhir_bulan.php'");

	window.mm_menu_0814123211_2 = new Menu("root", 160, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_2.addMenuItem(mm_menu_0814123211_2_5,"location='#'");
   mm_menu_0814123211_2.addMenuItem(mm_menu_0814123211_2_6,"location='#'");
   mm_menu_0814123211_2.addMenuItem("A8.3 Penerimaan Obat","location='?f=../gudang/penerimaan_detail_report'");
   mm_menu_0814123211_2.addMenuItem(mm_menu_0814123211_2_8,"location='#'");
   mm_menu_0814123211_2.addMenuItem(mm_menu_0814123211_2_4,"location='#'");
   mm_menu_0814123211_2.addMenuItem(mm_menu_0814123211_2_2,"location='#'");
   mm_menu_0814123211_2.addMenuItem(mm_menu_0814123211_2_3,"location='#'");
   mm_menu_0814123211_2.addMenuItem(mm_menu_0814123211_2_9,"location='#'");
   mm_menu_0814123211_2.addMenuItem("A8.9 Mutasi Obat","location='?f=../transaksi/rpt_mutasi.php'");
   mm_menu_0814123211_2.addMenuItem("A8.10 Pindah Kepemilikan","location='?f=../transaksi/rpt_pindah_kepemilikan.php'");
   mm_menu_0814123211_2.addMenuItem("A8.11 Realisasi PO","location='?f=../report/realisasi_po.php'");
   mm_menu_0814123211_2.addMenuItem(mm_menu_0814123211_2_1,"location='#'");
   mm_menu_0814123211_2.childMenuIcon = "../icon/arrows.gif";

	window.mm_menu_0814123211_0_1 = new Menu("B8.1 Stok", 150, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_0_1.addMenuItem("B8.1.1 Stok Per Unit","location='?f=../transaksi/stok_view.php'");
   mm_menu_0814123211_0_1.addMenuItem("B8.1.2 Stok Seluruh Unit","location='?f=../master/stokall.php'");
   mm_menu_0814123211_0_1.addMenuItem("B8.1.3 Stok Opname","location='?f=../report/rpt_opname.php'");
   mm_menu_0814123211_0_1.addMenuItem("B8.1.4 Stok < Stok Min","location='?f=../report/stok_minimum.php'");
   mm_menu_0814123211_0_1.addMenuItem("B8.1.5 Stok Akhir Bulan","location='?f=../transaksi/stok_akhir_bulan.php'");
   
   	window.mm_menu_0814123211_0_2 = new Menu("B8.2 Pemakaian", 180, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_0_2.addMenuItem("B8.2.1 Pemakaian Per Unit","location='?f=../transaksi/jual_view_qty.php'");
   mm_menu_0814123211_0_2.addMenuItem("B8.2.2 Pemakaian All Unit","location='?f=../master/jualall_qty.php'");
   mm_menu_0814123211_0_2.addMenuItem("A8.2.3 Obat Ruangan","location='?f=../apotik/pemakaian_obat_ruangan.php'");

   	window.mm_menu_0814123211_0_3 = new Menu("B8.3 Penjualan/Pendapatan", 180, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_0_3.addMenuItem("B8.3.1 Penjualan Unit","location='?f=../apotik/list_penjualan.php'");
   mm_menu_0814123211_0_3.addMenuItem("B8.3.2 Kelompok Harga","location='?f=../apotik/penjualan_perKelHarga.php'");
   mm_menu_0814123211_0_3.addMenuItem("B8.3.3 Buku Penjualan","location='?f=../apotik/buku_penjualan.php'");
   mm_menu_0814123211_0_3.addMenuItem("B8.3.4 Summary Pendapatan","location='?f=../apotik/sum_pendapatan.php'");
   
   	window.mm_menu_0814123211_0_4 = new Menu("B8.4 Permintaan", 150, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_0_4.addMenuItem("B8.4.1 Obat","location='?f=../apotik/permintaan_obat.php'");
   mm_menu_0814123211_0_4.addMenuItem("B8.4.2 Tak Terlayani","location='?f=../apotik/permintaan_tak_terlayani.php'");
   
   	window.mm_menu_0814123211_0_5 = new Menu("B8.6 Pengeluaran", 150, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_0_5.addMenuItem("B8.6.1 Obat","location='?f=../gudang/list_mutasi.php'");
   mm_menu_0814123211_0_5.addMenuItem("B8.6.2 NAPZA","location='?f=../report/rpt_napza.php'");

   	window.mm_menu_0814123211_0_6 = new Menu("B8.7 Obat", 190, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_0_6.addMenuItem("B8.7.1 Pemantauan Obat","location='?f=../transaksi/rpt_obat_terlayani.php'");
   mm_menu_0814123211_0_6.addMenuItem("B8.7.2 Harga Obat","location='?f=../master/harga.php&isview=1'");
   mm_menu_0814123211_0_6.addMenuItem("B8.7.3 Daftar Obat Expired","location='?f=../apotik/list_expired.php'");
   mm_menu_0814123211_0_6.addMenuItem("B8.7.4 Cat. Pengambilan Obat","location='?f=../apotik/rpt_cpo.php'");

   window.mm_menu_0814123211_1 = new Menu("root", 160, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_1.addMenuItem("B4.1 Meminjam Obat","location='?f=list_pinjam_obat.php'");
   mm_menu_0814123211_1.addMenuItem("B4.2 Menerima Pinjaman","location='?f=list_pinjam_terima.php'");
   //mm_menu_0814123211_1.addMenuItem("Menerima Pinjaman","location='#'");
   mm_menu_0814123211_1.addMenuItem("B4.3 Meminjamkan Obat","location='?f=list_dipinjam.php'");
   //mm_menu_0814123211_1.addMenuItem("Mengembalikan Obat","location='?f=list_kembali.php'");
   mm_menu_0814123211_1.addMenuItem("B4.4 Mengembalikan Obat","location='?f=../transaksi/list_kembali.php'");
   //mm_menu_0814123211_1.addMenuItem("Menerima Kembalian","location='?f=list_kembali_terima.php'");
   mm_menu_0814123211_1.addMenuItem("B4.5 Menerima Kembalian","location='?f=../transaksi/list_kembali_terima.php'");

   window.mm_menu_0814123211_0 = new Menu("root", 180, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_0.addMenuItem(mm_menu_0814123211_0_1,"location='#'");
   mm_menu_0814123211_0.addMenuItem(mm_menu_0814123211_0_2,"location='#'");
   mm_menu_0814123211_0.addMenuItem(mm_menu_0814123211_0_3,"location='#'");
   mm_menu_0814123211_0.addMenuItem("B8.4 Return Penjualan","location='?f=../apotik/list_retur_penjualan.php'");
   mm_menu_0814123211_0.addMenuItem(mm_menu_0814123211_0_4,"location='#'");
   mm_menu_0814123211_0.addMenuItem("B8.5 Penerimaan Obat","location='?f=../apotik/list_meminjam.php'");
   mm_menu_0814123211_0.addMenuItem(mm_menu_0814123211_0_5,"location='#'");
   mm_menu_0814123211_0.addMenuItem(mm_menu_0814123211_0_6,"location='#'");
   mm_menu_0814123211_0.addMenuItem("B8.8 Resep Pasien","location='?f=../apotik/list_resep_pasien.php'");
   mm_menu_0814123211_0.addMenuItem("B8.9 Mutasi Obat","location='?f=../transaksi/rpt_mutasi.php'");
   mm_menu_0814123211_0.childMenuIcon = "../icon/arrows.gif";

window.mm_menu_0814123211_4 = new Menu("root", 170, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_4.addMenuItem("D6.1 Stok Per Unit","location='?f=../transaksi/stok_view.php'");
   mm_menu_0814123211_4.addMenuItem("D6.2 Stok Seluruh Unit","location='?f=../master/stokall.php'");
   mm_menu_0814123211_4.addMenuItem("D6.3 Pemakaian Per Unit","location='?f=../transaksi/jual_view_qty.php'");
   mm_menu_0814123211_4.addMenuItem("D6.4 Pemakaian All Unit","location='?f=../master/jualall_qty.php'");
   mm_menu_0814123211_4.addMenuItem("D6.5 Pengeluaran Obat","location='?f=../floorstock/list_pembelian.php'");
   mm_menu_0814123211_4.addMenuItem("D6.6 Stok Opname","location='?f=../report/rpt_opname.php'");
   mm_menu_0814123211_4.addMenuItem("D6.7 Mutasi Obat","location='?f=../transaksi/rpt_mutasi.php'");
   mm_menu_0814123211_4.addMenuItem("D6.8 Stok < Stok Min","location='?f=../report/stok_minimum.php'");
   mm_menu_0814123211_4.addMenuItem("D6.9 Daftar Obat Expired","location='?f=../apotik/list_expired.php'");
   mm_menu_0814123211_4.addMenuItem("D6.10 Pemakaian Ruangan","location='?f=../floorstock/rpt_pemakaian_ruangan.php&idunit=20'");
   mm_menu_0814123211_4.addMenuItem("D6.11 Pem. Obat Ruangan","location='?f=../floorstock/pemakaian_obat_ruangan.php'");
   mm_menu_0814123211_4.addMenuItem("D6.12 Stok Akhir Bulan","location='?f=../transaksi/stok_akhir_bulan.php'");
   
   window.mm_menu_0814123211_5 = new Menu("root", 150, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_5.addMenuItem("A6.1 Pinjam","location='?f=list_pinjam_obat.php'");
   mm_menu_0814123211_5.addMenuItem("A6.2 Kembali","location='?f=../transaksi/list_kembali_intern.php'");

   window.mm_menu_0814123211_6 = new Menu("root", 150, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_6.addMenuItem("C3.1 Stok Per Unit","location='main.php?f=../transaksi/stok_view.php'");
   mm_menu_0814123211_6.addMenuItem("C3.2 Stok Seluruh Unit","location='main.php?f=../master/stokall.php'");
   mm_menu_0814123211_6.addMenuItem("C3.3 SPPH/Perencanaan","location='main.php?f=list_spph.php'");
   mm_menu_0814123211_6.addMenuItem("C3.4 Penjualan Apotek","location='main.php?f=../gudang/list_penjualan.php'");
   mm_menu_0814123211_6.addMenuItem("C3.5 Stok Akhir Bulan","location='main.php?f=../transaksi/stok_akhir_bulan.php'");
   
      window.mm_menu_0814123211_7_1 = new Menu("E6.3 Produksi Obat", 150, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7, true, true, true, 0, true, true);
   mm_menu_0814123211_7_1.addMenuItem("E6.3.1 Bahan Produksi","location='?f=bahan_produksi.php'");
   mm_menu_0814123211_7_1.addMenuItem("E6.3.2 Hasil Produksi","location='?f=hasil_produksi.php'");
   
      window.mm_menu_0814123211_7 = new Menu("root", 170, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, 3, 0,true, true, true, 0, true, true);
   mm_menu_0814123211_7.addMenuItem("E6.1 Stok Per Unit","location='?f=../transaksi/stok_view.php'");
   mm_menu_0814123211_7.addMenuItem("E6.2 Stok Seluruh Unit","location='?f=../master/stokall.php'");
   mm_menu_0814123211_7.addMenuItem(mm_menu_0814123211_7_1,"location='#'");
   mm_menu_0814123211_7.addMenuItem("E6.4 Pengeluaran Obat","location='?f=../gudang/list_mutasi.php'");
   //mm_menu_0814123211_7.addMenuItem("E6.5 Pemakaian Obat","location='?f=../transaksi/jual_view_qty.php'");
   mm_menu_0814123211_7.addMenuItem("E6.5 Stok Opname","location='?f=../report/rpt_opname.php'");
   mm_menu_0814123211_7.addMenuItem("E6.6 Mutasi Obat","location='?f=../transaksi/rpt_mutasi.php'");
   mm_menu_0814123211_7.addMenuItem("E6.7 Stok < Stok Min","location='?f=../report/stok_minimum.php'");
   mm_menu_0814123211_7.addMenuItem("E6.8 Daftar Obat Expired","location='?f=../apotik/list_expired.php'");
   mm_menu_0814123211_7.addMenuItem("E6.9 Stok Akhir Bulan","location='?f=../transaksi/stok_akhir_bulan.php'");
   mm_menu_0814123211_7.childMenuIcon = "../icon/arrows.gif";

    window.mm_menu_0814123211_8 = new Menu("root", 170, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_8.addMenuItem("E1.1 Permintaan Ke Gudang","location='?f=../apotik/list_minta_obat.php'");
   mm_menu_0814123211_8.addMenuItem("E1.2 Permintaan Dari Unit","location='?f=../gudang/list_permintaan.php'");
   
    window.mm_menu_0814123211_9 = new Menu("root", 90, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_9.addMenuItem("E7.1 Pinjam","location='?f=../gudang/list_pinjam_obat.php'");
   mm_menu_0814123211_9.addMenuItem("E7.2 Kembali","location='?f=../transaksi/list_kembali_intern.php'");
   
  window.mm_menu_0814123211_10 = new Menu("root", 150, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_10.addMenuItem("A5.1 Retur Ke PBF","location='?f=../transaksi/obat_kepbf.php'");
   mm_menu_0814123211_10.addMenuItem("A5.2 Retur Dari Unit","location='?f=../gudang/retur_dr_unit.php'");
    
	window.mm_menu_0814123211_11 = new Menu("root", 90, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_11.addMenuItem("A6.1 Pinjam","location='?f=../gudang/list_pinjam_obat.php'");
   mm_menu_0814123211_11.addMenuItem("A6.2 Kembali","location='?f=../transaksi/list_kembali_intern.php'");
   
   
   	window.mm_menu_0814123211_12 = new Menu("root", 150, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_12.addMenuItem("A1.1 Stok Per Unit","location='?f=../transaksi/stok_view.php'");
   mm_menu_0814123211_12.addMenuItem("A1.2 Stok Seluruh Unit","location='?f=../master/stokall.php'");
   mm_menu_0814123211_12.addMenuItem("A1.3 Stok < Stok Min","location='?f=../report/stok_minimum.php'");
   
   window.mm_menu_0814123211_14 = new Menu("root", 180, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_14.addMenuItem("B3.1 Penjualan Langsung","location='?f=../transaksi/penjualan.php'");
   mm_menu_0814123211_14.addMenuItem("B3.2 Konsul dari Billing","location='?f=../transaksi/konsulBilling.php'");
   mm_menu_0814123211_14.addMenuItem("B3.3 Resep dari Billing","location='?f=../transaksi/penjualanBilling.php'");
   
   	window.mm_menu_0814123211_13 = new Menu("root", 180, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_13.addMenuItem("A3.1 Pemakaian Per Unit","location='?f=../transaksi/jual_view_qty.php'");
   mm_menu_0814123211_13.addMenuItem("A3.2 Pemakaian All Unit","location='?f=../master/jualall_qty.php'");
   
    window.mm_menu_0814123211_15 = new Menu("root", 170, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_15.addMenuItem("A.1.1 Penerimaan Obat","location='?f=../gudang/penerimaan_detail_report.php'");
   mm_menu_0814123211_15.addMenuItem("A.1.2 Penjualan Apotek","location='?f=../apotik/list_penjualan.php'");
   mm_menu_0814123211_15.addMenuItem("A.1.3 Summary Pendapatan","location='?f=../apotik/sum_pendapatan.php'");
   mm_menu_0814123211_15.writeMenus();
} 