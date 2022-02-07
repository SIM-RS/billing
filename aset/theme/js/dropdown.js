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
   window.mm_menu_0814123211_0 = new Menu("root", 180, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_0.addMenuItem("Info User","location='/simrs-tangerang/aset/Sistem/info_user.php'");
   mm_menu_0814123211_0.addMenuItem("Ganti Password","location='/simrs-tangerang/aset/Sistem/change_password.php'");
   mm_menu_0814123211_0.addMenuItem("Manajemen User","location='/simrs-tangerang/aset/Sistem/m_user.php'");
   mm_menu_0814123211_0.addMenuItem("Setting Global","location='/simrs-tangerang/aset/Sistem/setting_global.php'");
   
   window.mm_menu_0814123211_1 = new Menu("root", 160, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_1.addMenuItem("Kode Brg","location='/simrs-tangerang/aset/Tabel/kode_brg.php'");
   mm_menu_0814123211_1.addMenuItem("Kode Brg (tree)","location='#'");
   mm_menu_0814123211_1.addMenuItem("Unit Kerja","location='/simrs-tangerang/aset/Tabel/unit.php'");
   mm_menu_0814123211_1.addMenuItem("Unit Kerja (tree)","location='#'");
   mm_menu_0814123211_1.addMenuItem("Gedung","location='/simrs-tangerang/aset/Tabel/gedung.php'");
   mm_menu_0814123211_1.addMenuItem("Sumber Dana","location='/simrs-tangerang/aset/Tabel/smbrDana.php'");
   mm_menu_0814123211_1.addMenuItem("Ruangan","location='/simrs-tangerang/aset/Tabel/ruangan.php'");
   mm_menu_0814123211_1.addMenuItem("Rekanan","location='/simrs-tangerang/aset/Tabel/rekanan.php'");

	window.mm_menu_0814123211_2_1 = new Menu("Transaksi", 130, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_2_1.addMenuItem("Perolehan","location='/simrs-tangerang/aset/Aktivitas/perolehan.php'");
   mm_menu_0814123211_2_1.addMenuItem("Perubahan","location='/simrs-tangerang/aset/Aktivitas/perubahan.php'");
   mm_menu_0814123211_2_1.addMenuItem("Penghapusan","location='/simrs-tangerang/aset/Aktivitas/penghapusan.php'");
   
   window.mm_menu_0814123211_2_2 = new Menu("Data Seri", 130, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_2_2.addMenuItem("KIB Tanah","location='/simrs-tangerang/aset/Aktivitas/tanah.php'");
   mm_menu_0814123211_2_2.addMenuItem("KIB Alat/Mesin","location='/simrs-tangerang/aset/Aktivitas/mesin.php'");
   mm_menu_0814123211_2_2.addMenuItem("KIB Gedung","location='/simrs-tangerang/aset/Aktivitas/gedung.php'");
   mm_menu_0814123211_2_2.addMenuItem("KIB Jalan/Irigasi","location='/simrs-tangerang/aset/Aktivitas/jalan.php'");
   mm_menu_0814123211_2_2.addMenuItem("KIB Aset Tetap","location='/simrs-tangerang/aset/Aktivitas/aset.php'");
   mm_menu_0814123211_2_2.addMenuItem("KIB Konstruksi","location='/simrs-tangerang/aset/Aktivitas/konstruksi.php'");
   
	window.mm_menu_0814123211_2 = new Menu("root", 160, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_2.childMenuIcon = "../icon/arrows.gif";
   mm_menu_0814123211_2.addMenuItem(mm_menu_0814123211_2_1,"location='?f='");
   mm_menu_0814123211_2.addMenuItem(mm_menu_0814123211_2_2,"location='?f='");

   window.mm_menu_0814123211_3 = new Menu("root", 135, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_3.addMenuItem("K I B","location='/simrs-tangerang/aset/Laporan/kib.php'");
   mm_menu_0814123211_3.addMenuItem("Buku Inventaris","location='?f='");
   mm_menu_0814123211_3.addMenuItem("Mutasi Barang","location='?f='");
   
  mm_menu_0814123211_3.writeMenus();
   
} 