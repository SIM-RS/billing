<?php
include("../koneksi/konek.php");
session_start();
?>
<script language="JavaScript">
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
   window.mm_menu_0814123211_0 = new Menu("root", 210, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   //mm_menu_0814123211_0.addMenuItem("RINCIAN TINDAKAN Px UMUM","cetakRincian(0);");
   mm_menu_0814123211_0.addMenuItem("RINCIAN TINDAKAN RJ KSO Px","cetakRincian(7);");
   mm_menu_0814123211_0.addMenuItem("RINCIAN TINDAKAN RI KSO Px","cetakRincian(8);");
   mm_menu_0814123211_0.addMenuItem("RINCIAN TINDAKAN RJ+RI KSO Px","cetakRincian(9);");
   mm_menu_0814123211_0.addMenuItem("RINCIAN RJ+RI KSO Px DETAIL","cetakRincian(11);");
   mm_menu_0814123211_0.addMenuItem("RINCIAN TINDAKAN RJ KSO","cetakRincian(1);");
   mm_menu_0814123211_0.addMenuItem("RINCIAN TINDAKAN RI KSO","cetakRincian(3);");
   mm_menu_0814123211_0.addMenuItem("RINCIAN TINDAKAN RJ+RI KSO","cetakRincian(4);");
   mm_menu_0814123211_0.addMenuItem("RINCIAN RJ+RI KSO DETAIL","cetakRincian(10);");
   mm_menu_0814123211_0.addMenuItem("RINCIAN TINDAKAN [LAB]","cetakRincian(2);");
   mm_menu_0814123211_0.addMenuItem("RINCIAN TINDAKAN [RAD]","cetakRincian(5);");
   mm_menu_0814123211_0.addMenuItem("RINCIAN TINDAKAN [HD]","cetakRincian(6);");
   mm_menu_0814123211_0.addMenuItem("RINCIAN PEMAKAIAN OBAT","cetakRincian(12);");
   mm_menu_0814123211_0.addMenuItem("RINCIAN TINDAKAN + OBAT","cetakRincian(13);");
   mm_menu_0814123211_0.addMenuItem("KUITANSI INAP","cetakRincian(14);");

   window.mm_menu_0814123211_1 = new Menu("root", 250, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_1.addMenuItem("RINCIAN TINDAKAN SEMUA","RincianTagihan(0);");
   mm_menu_0814123211_1.addMenuItem("RINCIAN TINDAKAN RJ/IGD","cetakRincian(1);");
   mm_menu_0814123211_1.addMenuItem("RINCIAN TINDAKAN RI","cetakRincian(2);");
   
   window.mm_menu_0814123211_2 = new Menu("root", 500, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_2.addMenuItem("LAPORAN POLI PAVILYUN","cetakLaporan(0);");
   mm_menu_0814123211_2.addMenuItem("LAPORAN JASA VISITE","cetakLaporan(1);");
   mm_menu_0814123211_2.addMenuItem("LAPORAN TINDAKAN OPERATIF","cetakLaporan(2);");
   mm_menu_0814123211_2.addMenuItem("LAPORAN TINDAKAN NON OPERATIF","cetakLaporan(3);");
   mm_menu_0814123211_2.addMenuItem("LAPORAN TINDAKAN OPERATIF SELAIN DOKTER","cetakLaporan(4);");
   mm_menu_0814123211_2.addMenuItem("LAPORAN TINDAKAN NON OPERATIF SELAIN DOKTER","cetakLaporan(5);");
   mm_menu_0814123211_2.addMenuItem("LAPORAN TINDAKAN PERSALINAN NORMAL & ABNORMAL TANPA DOKTER ANAK","cetakLaporan(6);");
   mm_menu_0814123211_2.addMenuItem("LAPORAN TINDAKAN PERSALINAN ABNORMAL DENGAN DOKTER ANAK","cetakLaporan(7);");
   mm_menu_0814123211_2.addMenuItem("LAPORAN TINDAKAN PERSALINAN SELAIN DOKTER","cetakLaporan(8);");

   window.mm_menu_0814123211_3 = new Menu("root", 170, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_3.addMenuItem("KWITANSI INAP","tagihan(0);");
   mm_menu_0814123211_3.addMenuItem("KWITANSI KURANG BAYAR","tagihan(1);");
   mm_menu_0814123211_3.addMenuItem("KWITANSI TITIPAN","tagihan(2);");
  
  <?php
  $sMenu="select distinct a.* from b_ms_menu_report_rm a
  inner join b_ms_menu_report_rm b on a.id=b.parent_id
  inner join b_ms_menu_report_rm_akses c on b.id=c.menu_id
   where a.aktif=1 and a.level=1 and c.pegawai_id=".$_SESSION['userId']." and b.jenis=0 order by a.kode";
  $qMenu=mysql_query($sMenu);
  $no_m=0;
  while($rwMenu=mysql_fetch_array($qMenu)){
  ?>
  window.mm_menu_0814123211_4_<?php echo $no_m; ?> = new Menu("<?php echo $rwMenu['nama']; ?>", 400, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
  <?php
  $sSub="select a.*, if(a.nomor_dokumen is null or a.nomor_dokumen='','',concat('[',a.nomor_dokumen,'] ')) as nomor_dokumen from b_ms_menu_report_rm a 
  inner join b_ms_menu_report_rm_akses b on a.id=b.menu_id 
  where a.aktif=1 and a.level=2 and a.parent_id=".$rwMenu['id']." and b.pegawai_id=".$_SESSION['userId']." order by a.nomor_dokumen";
  $qSub=mysql_query($sSub);
  $no_s=1;
  while($rwSub=mysql_fetch_array($qSub)){
  
  if($rwSub['tipe']==1){
  ?>
  mm_menu_0814123211_4_<?php echo $no_m; ?>.addMenuItem("<?php echo $rwSub['nomor_dokumen']; ?><?php echo $rwSub['nama']; ?>","load_popup_iframe('<?php echo $rwSub['legend']; ?>','<?php echo $rwSub['link']; ?>')");
  <?php
  }
  else if($rwSub['tipe']==2){
  ?>
  mm_menu_0814123211_4_<?php echo $no_m; ?>.addMenuItem("<?php echo $rwSub['nomor_dokumen']; ?><?php echo $rwSub['nama']; ?>","ReportRm('<?php echo $rwSub['link']; ?>')");
  <?php
  }
  else if($rwSub['tipe']==3){
  ?>
  mm_menu_0814123211_4_<?php echo $no_m; ?>.addMenuItem("<?php echo $rwSub['nomor_dokumen']; ?><?php echo $rwSub['nama']; ?>","<?php echo $rwSub['link']; ?>");
  <?php
  }
  $no_s++;
  }
  $no_m++;
  }
  ?>
  
  window.mm_menu_0814123211_4 = new Menu("root", 210, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
  <?php
  $sMenu="select distinct a.* from b_ms_menu_report_rm a
  inner join b_ms_menu_report_rm b on a.id=b.parent_id
  inner join b_ms_menu_report_rm_akses c on b.id=c.menu_id
   where a.aktif=1 and a.level=1 and c.pegawai_id=".$_SESSION['userId']." and b.jenis=0 order by a.kode";
  $qMenu=mysql_query($sMenu);
  $no_m=0;
  while($rwMenu=mysql_fetch_array($qMenu)){
  ?>
  mm_menu_0814123211_4.addMenuItem(mm_menu_0814123211_4_<?php echo $no_m; ?>,"location='#'");
  <?php
  $no_m++;
  }
  ?>
  mm_menu_0814123211_4.childMenuIcon = "../icon/arrows.gif";
  
  
  
	/*
	 window.mm_menu_0814123211_5 = new Menu("root", 210, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 2, true, true);
   	mm_menu_0814123211_5.addMenuItem("SP Inap","window.open('krs.php','_blank');");
   	mm_menu_0814123211_5.addMenuItem("Surat Ket. Meninggal","cetak_mati();");
   	mm_menu_0814123211_5.addMenuItem("Check List Pasien Pulang","checkList();");
   	mm_menu_0814123211_5.addMenuItem("Surat Rujukan","cetakRincian(9);");
	*/
	
    mm_menu_0814123211_4.writeMenus();
} 
</script>