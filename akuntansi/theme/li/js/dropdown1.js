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
   mm_menu_0814123211_0.addMenuItem("Laporan Jurnal","location='?f=../report/laporan.php&it=1'");
/* mm_menu_0814123211_0.addMenuItem("Laporan Buku Besar","location='?f=../report/laporan.php&it=2'");
   mm_menu_0814123211_0.addMenuItem("Laporan Neraca","location='?f=../report/laporan.php&it=3'");
*/
   window.mm_menu_0814123211_2 = new Menu("root", 135, 25, "verdana", 11,"#003366", "#FF6600", "#6C9DC1", "#ffffff","left", "middle", 3, 0, 810, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_2.addMenuItem("Laporan Jurnal","location='?f=../report/laporan.php&it=1&iunit=0|ITS'");
   mm_menu_0814123211_2.addMenuItem("Laporan Buku Besar","location='?f=../report/laporan.php&it=2&iunit=0|ITS'");
   mm_menu_0814123211_2.addMenuItem("Laporan Neraca","location='?f=../report/laporan.php&it=3&iunit=0|ITS'");

   window.mm_menu_0814123211_1 = new Menu("root", 135, 25, "verdana", 11,"#003366", "#FF6600", "#71C1AF", "#ffffff","left", "middle", 3, 0, 810, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_1.addMenuItem("Meminjam Obat","location='?f=list_pinjam_obat.php'");
   //mm_menu_0814123211_1.addMenuItem("Menerima Pinjaman","location='?f=list_pinjam_terima.php'");
   mm_menu_0814123211_1.addMenuItem("Menerima Pinjaman","location='#'");
   mm_menu_0814123211_1.addMenuItem("Dipinjam Unit Lain","location='?f=list_dipinjam.php'");
   //mm_menu_0814123211_1.addMenuItem("Mengembalikan Obat","location='?f=list_kembali.php'");
   mm_menu_0814123211_1.addMenuItem("Mengembalikan Obat","location='#'");
   //mm_menu_0814123211_1.addMenuItem("Menerima Kembalian","location='?f=list_kembali_terima.php'");
   mm_menu_0814123211_1.addMenuItem("Menerima Kembalian","location='#'");
   
   window.mm_menu_0814123211_3 = new Menu("root", 135, 25, "verdana", 11,"#003366", "#FF6600", "#71C1AF", "#ffffff","left", "middle", 3, 0, 810, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_3.addMenuItem("Unit A1.1","location='?f=../master/unit'");
   mm_menu_0814123211_3.addMenuItem("PBF A1.2","location='?f=../master/pbf'");
   mm_menu_0814123211_3.addMenuItem("Bentuk A1.3","location='?f=../master/bentuk'");
   mm_menu_0814123211_3.addMenuItem("Satuan A1.4","location='?f=../master/satuan'");
   mm_menu_0814123211_3.addMenuItem("Jenis Obat A1.5","location='?f=../master/kelas'");
   mm_menu_0814123211_3.addMenuItem("Principle A1.6","location='?f=../master/pabrik'");
   mm_menu_0814123211_3.addMenuItem("KSO A1.7","location='?f=../master/mitra'");
   mm_menu_0814123211_3.addMenuItem("Obat A1.8","location='?f=../master/obat'");
   mm_menu_0814123211_3.addMenuItem("Harga Obat A1.9","location='?f=../master/harga'");
   mm_menu_0814123211_3.addMenuItem("User A1.10","location='?f=../master/user'");

   mm_menu_0814123211_1.writeMenus();
} 