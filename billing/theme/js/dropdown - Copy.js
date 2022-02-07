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
   mm_menu_0814123211_0.addMenuItem("RINCIAN TINDAKAN Px UMUM","cetakRincian(0);");
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

  
	
   window.mm_menu_0814123211_4_0 = new Menu("REPORT 1", 210, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
   mm_menu_0814123211_4_0.addMenuItem("1. INFORM KONSEN","isInform_Konsen(1)");
   //mm_menu_0814123211_4_0.addMenuItem("2. APS","ReportRm(2)");
   mm_menu_0814123211_4_0.addMenuItem("3. CATATAN ASUHAN GIZI","load_popup_iframe('CATATAN ASUHAN GIZI','../report_rm/3.ctt_asuhan_gizi_form.php')");
   mm_menu_0814123211_4_0.addMenuItem("4. SURAT KENAL LAHIR","ReportRm(4);");
   mm_menu_0814123211_4_0.addMenuItem("5. MONITORING E.S.O","load_popup_iframe('MONITORING E.S.O','../report_rm/5.monitoring_ESO_form.php')");
   mm_menu_0814123211_4_0.addMenuItem("6. CHECK LIST CATCH","load_popup_iframe('CHECK LIST CATCH','../report_rm/6.check_list_cath_form.php')");
   //mm_menu_0814123211_4_0.addMenuItem("7. RUJUKAN","ReportRm(7);");
   mm_menu_0814123211_4_0.addMenuItem("8. RENCANA HARIAN PERAWAT","ReportRm(8);");
   mm_menu_0814123211_4_0.addMenuItem("9. CHECKLIST TERIMA PASIEN","ReportRm(9);");
   mm_menu_0814123211_4_0.addMenuItem("10. LAP KEJADIAN","load_popup_iframe('LAPORAN KEJADIAN','../report_rm/10.lap_kejadian_form.php')");
   mm_menu_0814123211_4_0.addMenuItem("11. PESANAN POST CATH","load_popup_iframe('PESANAN POST CATH','../report_rm/11.pesanan_pos.php')");
   mm_menu_0814123211_4_0.addMenuItem("12. PERSETUJUAN TRANSFUSI","load_popup_iframe('PERSETUJUAN TRANSFUSI','../report_rm/persetujuan_transfusi/index.php')");
   mm_menu_0814123211_4_0.addMenuItem("13. CHECKLIST PENGKAJIAN","load_popup_iframe('CHECKLIST PENGKAJIAN KEPERAWATAN','../report_rm/13. checklist_pengkajian_kep_form.php')");
   mm_menu_0814123211_4_0.addMenuItem("14. RESUME KEPERAWATAN","load_popup_iframe('RESUME KEPERAWATAN','../report_rm/14.resume_kep_form.php')");//("14. RESUME KEP","ReportRm(14);");
   mm_menu_0814123211_4_0.addMenuItem("15. REKAM MEDIS HD","ReportRm(15);");
   mm_menu_0814123211_4_0.addMenuItem("16. CHART ICU","ReportRm(16);");
   mm_menu_0814123211_4_0.addMenuItem("17. OBS HARIAN BAYI","ReportRm(17);");
   
    window.mm_menu_0814123211_4_1 = new Menu("REPORT 2", 210, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
	mm_menu_0814123211_4_1.addMenuItem("1. SURAT BALASAN","load_popup_iframe('SURAT BALASAN','../report_rm/Form_RSU/3.suratbalasan.php')");
	mm_menu_0814123211_4_1.addMenuItem("2. CHECKLIST TERIMA PASIEN","ReportRm(9)");
	mm_menu_0814123211_4_1.addMenuItem("3. CHECKLIST INDIKATOR MUTU","load_popup_iframe('CHECKLIST INDIKATOR MUTU','list_indikator_mutu/form_indikator_mutu.php')");
	mm_menu_0814123211_4_1.addMenuItem("4. PROSEDUR PEMBEDAHAN","load_popup_iframe('PROSEDUR PEMBEDAHAN','../report_rm/prosedur_pembedahan/main.php')");
	
	window.mm_menu_0814123211_4_3 = new Menu("REPORT 3", 210, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
	mm_menu_0814123211_4_3.addMenuItem("1. PENOLAKAN TIND.MEDIS","isTolakMedis()");
	mm_menu_0814123211_4_3.addMenuItem("2. SURAT KET.PEMERIKSA MATA","isPeriksaMata()");
	mm_menu_0814123211_4_3.addMenuItem("3. RESEP KACAMATA","isResepMata()");
	mm_menu_0814123211_4_3.addMenuItem("4. MEDICAL CHEKUP(BDH WANITA)","isBdhWanita()");
	mm_menu_0814123211_4_3.addMenuItem("5. MEDICAL CHEKUP(DENTAL)","isBdhDental()");
	mm_menu_0814123211_4_3.addMenuItem("6. RESUM MEDIS","isResumMedis()");
	mm_menu_0814123211_4_3.addMenuItem("7. PENGAWASAN KHUSUS BAYI","isPgwsBayi()");
	mm_menu_0814123211_4_3.addMenuItem("8. NEONEATUS DISCHARGE","isNeonatus()");
	mm_menu_0814123211_4_3.addMenuItem("9. PENGKAJIAN LUKA","isPenkajianLuka()");
	
	window.mm_menu_0814123211_4_2 = new Menu("REPORT 4", 210, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
	mm_menu_0814123211_4_2.addMenuItem("1. TRAVELING PATIENT INFORMASI","load_popup_iframe('TRAVELING PATIENT INFORMASI','../report_rm/CRUD_Form_RSUD/1.traveling_patient_informasi.php')");
	mm_menu_0814123211_4_2.addMenuItem("2. RIW.PENYAKIT DAN PMR.JASMANI","load_popup_iframe('RIWAYAT PENYAKIT DAN PEMERIKSAAN JASMANI','../report_rm/CRUD_Form_RSUD/2.riwayat_penyakit.php')");
	mm_menu_0814123211_4_2.addMenuItem("3. SURAT PENGANTAR RAWAT","load_popup_iframe('SURAT PENGANTAR RAWAT','../report_rm/CRUD_Form_RSUD/3.sr_pengantar_rawat.php')");
	mm_menu_0814123211_4_2.addMenuItem("4. FORM KEG.AMBULANCE PASIEN","alert('ok')");
	mm_menu_0814123211_4_2.addMenuItem("5. PERSETUJUAN TIND.MEDIK","alert('ok')");
	mm_menu_0814123211_4_2.addMenuItem("6. FORM KEG.AMBULANCE","alert('ok')");
	
	window.mm_menu_0814123211_4_4 = new Menu("REPORT 5", 210, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
	mm_menu_0814123211_4_4.addMenuItem("1. SERAH TERIMA BAYI","load_popup_iframe('SERAH TERIMA BAYI','../report_rm/form_tuk_rsud/serah_terima_bayi_pulang.php')");
	mm_menu_0814123211_4_4.addMenuItem("2. CAT. PEMBERIAN EDUKASI","load_popup_iframe('CATATAN PEMBERIAN EDUKASI','../report_rm/form_tuk_rsud/catatan_pemberian_edukasi.php')");
	mm_menu_0814123211_4_4.addMenuItem("3. SURVEILAN INFEKSI NOSOKOMIAL","alert('ok')");
	mm_menu_0814123211_4_4.addMenuItem("4. SUBJECTIVE GLOBAL ASESSMENT","alert('ok')");
	mm_menu_0814123211_4_4.addMenuItem("5. CAT. KEPERAWATAN PERI OPERATIF","alert('ok')");
	   
    window.mm_menu_0814123211_4 = new Menu("root", 210, 25, "verdana", 11,"#003366", "#FF6600", "#64CCFC", "#ffffff","left", "middle", 3, 0, 100, -5, 7,true, true, true, 0, true, true);
	mm_menu_0814123211_4.addMenuItem(mm_menu_0814123211_4_0,"location='#'");
	mm_menu_0814123211_4.addMenuItem(mm_menu_0814123211_4_1,"location='#'");
	mm_menu_0814123211_4.addMenuItem(mm_menu_0814123211_4_3,"location='#'");
	mm_menu_0814123211_4.addMenuItem(mm_menu_0814123211_4_2,"location='#'");
	mm_menu_0814123211_4.addMenuItem(mm_menu_0814123211_4_4,"location='#'");
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