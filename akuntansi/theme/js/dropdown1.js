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
   window.mm_menu_0814123211_0 = new Menu("root", 135, 25, "verdana", 11,"#003366", "#FF6600", "#6C9DC1", "#ffffff","left", "middle", 3, 0, 810, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_0.addMenuItem("Laporan Jurnal","location='../unit/main.php?f=../report/laporan.php&it=1'");
   mm_menu_0814123211_0.addMenuItem("Laporan Buku Besar","location='../unit/main.php?f=../report/laporan.php&it=2'");
   mm_menu_0814123211_0.addMenuItem("Laporan Operasional","location='../unit/main.php?f=../report/laporan.php&it=5'");
   mm_menu_0814123211_0.addMenuItem("Laporan Arus Kas","location='../unit/main.php?f=../report/laporan.php&it=4'");
   mm_menu_0814123211_0.addMenuItem("Laporan Neraca","location='../unit/main.php?f=../report/laporan.php&it=3'");

   window.mm_menu_0814123211_2 = new Menu("root", 135, 25, "verdana", 11,"#003366", "#FF6600", "#6C9DC1", "#ffffff","left", "middle", 3, 0, 810, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_2.addMenuItem("Laporan Jurnal","location='../unit/main.php?f=../report/laporan.php&it=1&iunit=0|ITS'");
   mm_menu_0814123211_2.addMenuItem("Laporan Buku Besar","location='../unit/main.php?f=../report/laporan.php&it=2&iunit=0|ITS'");
   mm_menu_0814123211_2.addMenuItem("Laporan Neraca","location='../unit/main.php?f=../report/laporan.php&it=3&iunit=0|ITS'");

   window.mm_menu_0814123211_1 = new Menu("root", 135, 25, "verdana", 10,"#003366", "#FF6600", "#71C1AF", "#ffffff","left", "middle", 3, 0, 810, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_1.addMenuItem("Penerimaan SPP","location='../unit/main.php?f=inputlayanan.php&app=1'");
   mm_menu_0814123211_1.addMenuItem("Penerimaan SPI","location='../unit/main.php?f=inputlayanan.php&app=2'");
   mm_menu_0814123211_1.addMenuItem("Penerimaan Ikoma","location='../unit/main.php?f=inputlayanan.php&app=3'");
   mm_menu_0814123211_1.addMenuItem("Penerimaan AMU","location='../unit/main.php?f=inputlayanan.php&app=4'");
   mm_menu_0814123211_1.addMenuItem("Penerimaan LPM-MMT","location='../unit/main.php?f=inputlayanan.php&app=5'");


	window.mm_menu_0814123211_3_1 = new Menu("Master Suplier", 140, 25, "verdana", 11,"#003366", "#FF6600", "#6C9DC1", "#ffffff","left", "middle", 3, 0, 810, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_3_1.addMenuItem("Suplier Obat","location='../unit/main.php?f=../master/suplier&tipe=1'");
   mm_menu_0814123211_3_1.addMenuItem("Suplier Umum","location='../unit/main.php?f=../master/suplier&tipe=2'");

   window.mm_menu_0814123211_3 = new Menu("root", 175, 25, "verdana", 11,"#003366", "#FF6600", "#6C9DC1", "#ffffff","left", "middle", 3, 0, 810, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_3.addMenuItem("Master Kode Rekening SAP","location='../unit/main.php?f=../master/tree_ms_ma'");
   mm_menu_0814123211_3.addMenuItem("Master Kode Rekening SAK","location='../unit/main.php?f=../master/tree_ms_ma_sak'");
   mm_menu_0814123211_3.addMenuItem("Master Cost/Revenue Center","location='../unit/main.php?f=../master/cost_revenue_center'");
   //mm_menu_0814123211_3.addMenuItem("Master Suplier","location='../unit/main.php?f=../master/suplier'");
   mm_menu_0814123211_3.addMenuItem(mm_menu_0814123211_3_1,"location='#'");
   mm_menu_0814123211_3.addMenuItem("Master User","location='../unit/main.php?f=../master/ms_user'");
   mm_menu_0814123211_3.addMenuItem("Master Jurnal","location='../unit/main.php?f=../master/tree_trans_khusus'");
   mm_menu_0814123211_3.addMenuItem("Setup Jurnal","location='../unit/main.php?f=detail&jurnal=0'");
   mm_menu_0814123211_3.addMenuItem("Lap Arus Kas","location='../unit/main.php?f=../master/lap_arus_kas'");
   mm_menu_0814123211_3.addMenuItem("Master Tipe Rekening","location='../unit/main.php?f=../master/ms_tipe'");
   mm_menu_0814123211_3.childMenuIcon = "../icon/arrows.gif";

window.mm_menu_0814123211_4_1 = new Menu("Transaksi Pendapatan", 140, 25, "verdana", 11,"#003366", "#FF6600", "#6C9DC1", "#ffffff","left", "middle", 3, 0, 810, 20, -20,true, true, true, 0, true, true);
   mm_menu_0814123211_4_1.addMenuItem("Pasien Umum","location='../unit/main.php?f=transaksi&kodepilih=11'");
   mm_menu_0814123211_4_1.addMenuItem("Pasien KSO","location='../unit/main.php?f=transaksi&kodepilih=12'");
   mm_menu_0814123211_4_1.addMenuItem("Px Ditanggung Pemda","location='../unit/main.php?f=transaksi&kodepilih=13'");
   //mm_menu_0814123211_4_1.addMenuItem("Penunjang Non Medis","location='../unit/main.php?f=transaksi&kodepilih=14'");
   //mm_menu_0814123211_4_1.addMenuItem("Penyetoran ke Bank","location='../unit/main.php?f=transaksi&kodepilih=15'");

window.mm_menu_0814123211_4 = new Menu("root", 200, 25, "verdana", 11,"#003366", "#FF6600", "#6C9DC1", "#ffffff","left", "middle", 3, 0, 810, 3, 0,true, true, true, 0, true, true);
   mm_menu_0814123211_4.addMenuItem(mm_menu_0814123211_4_1,"location='#'");
   mm_menu_0814123211_4.addMenuItem("Transaksi Pembelian","location='../unit/main.php?f=transaksi&kodepilih=2'");
   mm_menu_0814123211_4.addMenuItem("Transaksi Pemakaian Bahan","location='../unit/main.php?f=transaksi&kodepilih=3'");
   mm_menu_0814123211_4.addMenuItem("Transaksi Pengeluaran","location='../unit/main.php?f=transaksi&kodepilih=4'");
   mm_menu_0814123211_4.addMenuItem("Transaksi Pemeliharaan","location='../unit/main.php?f=transaksi&kodepilih=6'");
   mm_menu_0814123211_4.addMenuItem("Transaksi Depresiasi","location='../unit/main.php?f=transaksi&kodepilih=7'");
   mm_menu_0814123211_4.addMenuItem("Pendapatan Operasional Lainnya","location='../unit/main.php?f=transaksi&kodepilih=5'");
   mm_menu_0814123211_4.childMenuIcon = "../icon/arrows.gif";

window.mm_menu_0814123211_5_1 = new Menu("Pengurang Pendapatan", 140, 25, "verdana", 11,"#003366", "#FF6600", "#6C9DC1", "#ffffff","left", "middle", 3, 0, 810, 20, -20,true, true, true, 0, true, true);
   mm_menu_0814123211_5_1.addMenuItem("Belum Terbayar","location='../unit/pengurangPendapatan.php?bayar=0'");
   mm_menu_0814123211_5_1.addMenuItem("Sudah Terbayar","location='../unit/pengurangPendapatan.php?bayar=1'");

window.mm_menu_0814123211_5 = new Menu("root", 190, 25, "verdana", 11,"#003366", "#FF6600", "#6C9DC1", "#ffffff","left", "middle", 3, 0, 810, 3, 0,true, true, true, 0, true, true);
   mm_menu_0814123211_5.addMenuItem("Pendapatan Billing","location='../unit/pendapatanBilling.php'");
   mm_menu_0814123211_5.addMenuItem(mm_menu_0814123211_5_1,"location='#'");
   mm_menu_0814123211_5.addMenuItem("Penerimaan Billing","location='../unit/penerimaanBilling.php'");
   mm_menu_0814123211_5.addMenuItem("Penerimaan Klaim KSO","location='../unit/penerimaanKlaim.php'");
   mm_menu_0814123211_5.addMenuItem("Penerimaan Lain-Lain","location='../unit/penerimaanLain.php'");
   mm_menu_0814123211_5.addMenuItem("Pembelian Obat","location='../unit/pembelianObat.php'");
   mm_menu_0814123211_5.addMenuItem("Penjualan Obat","location='../unit/penjualanObat.php'");
   mm_menu_0814123211_5.addMenuItem("Return Penjualan Obat","location='../unit/returnObat.php'");
   mm_menu_0814123211_5.addMenuItem("Pemakaian Floor Stock","location='../unit/pemakaianFS.php'");
   mm_menu_0814123211_5.addMenuItem("Return Obat ke PBF","location='../unit/returPBF.php'");
   mm_menu_0814123211_5.addMenuItem("Penghapusan Obat","location='../unit/hapusObat.php'");
   mm_menu_0814123211_5.addMenuItem("Pembelian Barang Umum/HP","location='../aset/penerimaanBrg.php'");
   mm_menu_0814123211_5.addMenuItem("Pemakaian Barang Umum/HP","location='../aset/pemakaianBPH.php'");
   mm_menu_0814123211_5.addMenuItem("Penghapusan Barang Umum/HP","location='../aset/penghapusan_aset.php'");
   mm_menu_0814123211_5.childMenuIcon = "../icon/arrows.gif";

   mm_menu_0814123211_0.writeMenus();
} 