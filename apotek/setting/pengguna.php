<?php
session_start();
include("../sesi.php");
include("../koneksi/konek.php");
?>
<?php
	//session_start();
	$userId = $_SESSION['userId'];
	convert_var($userId);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="../theme/mod1.css">
<link rel="stylesheet" type="text/css" href="../theme/tab-view.css" />
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script type="text/javascript" src="../theme/js/tab-view.js"></script>
<script type="text/javascript" src="../theme/js/ajax.js"></script>
<title>Form Setting Pengguna</title>
</head>
<body>
<script>
var arrRange=depRange=[];
</script>
<iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<div align="center">
<?php
	
	//include("../header1.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	
	$sql = "SELECT RIGHT(MAX(kode),3) AS kode FROM a_group";
	$rs = mysqli_query($konek,$sql);
	$rw = mysqli_fetch_array($rs);
?>
<p class="jdltable">SETTING PETUGAS / OPERATOR</p>
<table align="center" width="1000" border="0" cellpadding="0" cellspacing="1" class="tabel" >
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><div class="TabView" id="TabView" style="width:960px; height:550px;"></div></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<!--table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
  <tr height="30">
  	<td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" class="btninput" /></td>
	<td>&nbsp;</td>
	<td align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" class="btninput"/></a>&nbsp;</td>
  </tr>
</table-->
</div>
<div id="popGrPet" style="display:none;" class="popup">
<table width="1000" align="center" cellpadding="3" cellspacing="0">
<tr>
	<td>
		<table width="100%" align="center" cellpadding="3" cellspacing="0">
		<tr>
			<td>Username</td>
			<td>&nbsp;:&nbsp;<input name="nama_user" type="text" id="nama_user" class="txtinput" size="35" >
            <input name="kode_user" id="kode_user" type="hidden" value="">
            </td>
		</tr>
		<tr>
			<td>Password</td>
			<td>&nbsp;:&nbsp;<input name="kata_kunci" type="password" id="kata_kunci" class="txtinput" size="35" value="" ></td>
		</tr>
		<tr>
			<td>Unit</td>
			<td>&nbsp;:&nbsp;<select name="unit" id="unit">
              <?
	  $qry = "select * from a_unit where UNIT_ISAKTIF=1";
	  $exe = mysqli_query($konek,$qry);
	  while($show= mysqli_fetch_array($exe)){
	  ?>
              <option id="<?=$show['UNIT_ID']."U";?>" value="<?=$show['UNIT_ID'];?>">
                <?=$show['UNIT_NAME'];?>
              </option>
              <? }?>
            </select></td>
		</tr>
		<tr>
			<td>Kategori</td>
			<td>&nbsp;:&nbsp;<select name="kategori_user" id="kategori_user">
              <?
	  $qry = "select * from a_user_kategori";
	  $exe = mysqli_query($konek,$qry);
	  while($show= mysqli_fetch_array($exe)){
	  ?>
             	<option id="<?=$show['id_kategori']."K";?>" value="<?=$show['id_kategori'];?>">
                <?=$show['nama_kategori'];?>
              </option>
              <? }?>
            </select> 
           </td>
		</tr>
        <tr>
			<td>Status</td>
			<td>&nbsp;:&nbsp;<select name="isaktif" id="isaktif" class="txtinput">
              <option id="1A" value="1">Aktif</option>
              <option id="0A" value="0">Tidak Aktif</option>
            </select>
           </td>
		</tr>
        <tr>
			<td colspan="2" align="center">
			<input type="hidden" id="txtId1" name="txtId1" />
			<input type="hidden" id="txtIdPeg" name="txtIdPeg" />
			<button id="sim" name="sim" value="simpan" type="button" style="cursor:pointer" class="popup_closebox" onclick="act1(this.value)"><img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Simpan</button>&nbsp;&nbsp;<button type="button" id="batal" name="batal" class="popup_closebox" onclick="gaksido()"><img src="../icon/back.png" width="20" align="absmiddle" />&nbsp;&nbsp;Batal</button></td>
		</tr>
		</table>
	</td>
</tr>
</table>
</div>
</body>
<script>
	var qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
	var spesialisasi=0;
	function forSimpan(){
		simpanSetting(document.getElementById('btnSimpanSetting').value,document.getElementById('txtSusun').value,'');
	}
	function forHapus(){
	   hapusSetting(document.getElementById('btnHapusSetting').value,document.getElementById('txtSusun').value,'');
	}
	function forOpenTree(){
	   
	   OpenWnd('settingaplikasi_treeview.php?'+qstr_ma_sak,800,500,'msma',true);//is
	}
	function openUserINACBG(){
	   
	   OpenWnd('inacbg_user.php',700,500,'msma',true);
	}
   
	function isiCombo(id,val,defaultId,targetId){	
			if(targetId=='' || targetId==undefined){
				targetId=id;
			}
			Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET');			
		}
	function setTgl(ev,par){
		//alert(ev.which);
            var tmp = par.value;
            var tmpSplit = tmp.split('-');
            for(var i=0; i<tmpSplit.length; i++){
                if(isNaN(tmpSplit[i]) == true){
                    alert('Masukan tanggal berupa angka!');
                    par.value = '';
                    return;
                }
            }
            
	    if(ev.which!='8' || ev.which!='46'){
		if(tmp.length == 2){
			if(tmp<=31){				
				par.value = tmp+'-';
			}else{
				alert('Tanggal jangan melebihi 31!');
				par.value = 31+'-';
			}
		}
		else if(tmp.length == 5){
			if(parseInt(tmp.substr(3,2))<=12){
				par.value = tmp+'-';
			}else{
				alert('Bulan jangan melebihi 12!');
				tmp = tmp.substr(0,3);
				par.value = tmp+12+'-';
			}
		}
		else if(tmp.length == 10){
			//gantiUmur();
		}
		else if(tmp.length > 10){
			par.value = tmp.substr(0,(tmp.length-1));
		}
	    }
        }
	
	var mTab=new TabView("TabView");
	mTab.setTabCaption("SETTING APLIKASI,GROUP KARYAWAN,HAK AKSES,PETUGAS,TEMPAT LAYANAN");
	mTab.setTabCaptionWidth("192,192,192,192,0");
	mTab.setTabDisplay("true,true,true,true,false,0");
	mTab.onLoaded(showgrid);
	mTab.setTabPage("settingaplikasi.php,grupkaryawan.php,groupakses.php,petugas.php,tmptlayanan.php");
	
	var tab2;
	//var tmptlay;
	
	var actTree;
	function loadtree(p,act,par)
	{		
		var a=p.split("*-*");
		//alert(a[0]+'act='+act+'&par='+par+'&gid='+document.getElementById(a[2]).value);
		if(act=='Tambah' || act=='Simpan' || act=='Hapus'){
			actTree=act;
			Request ( a[0]+'act='+act+'&par='+par+'&gid='+document.getElementById(a[2]).value+a[3]+'&cnt='+a[4] , a[1], '', 'GET',berhasil,'no');
		}
		else{			
			Request ( a[0]+'act='+act+'&par='+par+'&gid='+document.getElementById(a[2]).value+a[3]+'&cnt='+a[4] , a[1], '', 'GET');
			//isiCombo('cmbGroup','','','cmbGroup');
		}
	}
	function berhasil(){
		batalSetting();		
		alert(actTree+' Berhasil!');
	}
	function setGroup(addrs,val){
		Request ( 'http://'+addrs+'<?php echo $base_addr; ?>/apotek/setting/grouptree.php?gid='+val , 'divtree3', '', 'GET');
	}
	
	function ambilDatatab5(){
		var dicentang = tab5.getRowId(tab5.getSelRow()).split('|');
		dicentang = dicentang[1];
		/*var aslinya = 0;
		if(tab5.obj.childNodes[0].childNodes[parseInt(tab5.getSelRow())-1].childNodes[1].childNodes[0].checked)
			aslinya = 1;*/
		//if(dicentang != aslinya){
			var act;
			var idPeg = document.getElementById('txtIdPeg').value; // -> id pegawai
			var idPegUn = tab5.getRowId(parseInt(tab5.getSelRow()-1)+1).split('|'); // -> id unit
			
			if(tab5.obj.childNodes[0].childNodes[parseInt(tab5.getSelRow())-1].childNodes[1].childNodes[0].checked){
				act = 'tambah';
			}
			else{
				act = 'hapus';
			}
			//alert('tmptlayanan_utils.php?grdtab5=false&act='+act+'&id='+idPegUn[0]+'&idPeg='+idPeg);
			//tab5.loadURL("tmptlayanan_utils.php?grdtab5=false&act="+act+"&id="+idPegUn+"&idPeg="+idPeg,"","GET");spanSuk,tampil
			Request('tmptlayanan_utils.php?grdtab5=false&act='+act+'&id='+idPegUn[0]+'&idPeg='+idPeg,'spanSuk','','GET',tampil);
		//}
	}
	
	function ambilDatatab6(){
		var dicentang = tab6.getRowId(tab6.getSelRow()).split('|');
		dicentang = dicentang[1];
		/*var aslinya = 0;
		if(tab5.obj.childNodes[0].childNodes[parseInt(tab5.getSelRow())-1].childNodes[1].childNodes[0].checked)
			aslinya = 1;*/
		//if(dicentang != aslinya){
			var act;
			var idPeg = document.getElementById('txtIdPeg').value; // -> id pegawai
			var idPegUn = tab6.getRowId(parseInt(tab6.getSelRow()-1)+1).split('|'); // -> id unit
			
			if(tab6.obj.childNodes[0].childNodes[parseInt(tab6.getSelRow())-1].childNodes[1].childNodes[0].checked){
				act = 'tambah';
			}
			else{
				act = 'hapus';
			}
			//alert('tmptlayanan_utils.php?grdtab5=false&act='+act+'&id='+idPegUn[0]+'&idPeg='+idPeg);
			//tab5.loadURL("tmptlayanan_utils.php?grdtab5=false&act="+act+"&id="+idPegUn+"&idPeg="+idPeg,"","GET");spanSuk,tampil
			Request('menu_report_rm_util.php?grdtab6=false&act='+act+'&id='+idPegUn[0]+'&idPeg='+idPeg,'spanSukRM','','GET',tampil);
		//}
	}
	
	function tampil(){
		//tab5.loadURL("tmptlayanan_utils.php?grdtab5=true&idPeg="+document.getElementById('txtIdPeg').value,"","GET");
		setTimeout("document.getElementById('spanSuk').innerHTML=''",'1000');
		setTimeout("document.getElementById('spanSukRM').innerHTML='&nbsp;'",'1000');
	}
	
		
	/*var idPegUn='';
	function masuk()
	{
		if(document.getElementById('txtnm').value=='' )
		{
			alert('silakan pilih petugas dahulu!');
		}
		else
		{
			for(var i=0;i<tab5.obj.childNodes[0].rows.length;i++)
			{
				if(tab5.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked)
				{
					idPegUn+=tab5.getRowId(parseInt(i)+1)+',';	
				}
			}
			//alert(idPegUn);
			var idPeg=document.getElementById('txtIdPeg').value;
			if(idPegUn=='')
			{
				alert("Silakan pilih unit!");
			}
			else
			{
				//alert("tmptlayanan_utils.php?grdtab5=true&act=tambah&id="+idPegUn+"&idPeg="+idPeg);
				tab5.loadURL("tmptlayanan_utils.php?grdtab5=true&act=tambah&id="+idPegUn+"&idPeg="+idPeg+"&userId=<?php echo $userId;?>","","GET");
				idPegUn='';
			}
		}
		
	}*/
	
	function goFilterAndSort(grd){		
            if(grd=="gridboxtab2"){			
			tab2.loadURL("pengguna_utils.php?grdtab2=true&filter="+tab2.getFilter()+"&sorting="+tab2.getSorting()+"&page="+tab2.getPage(),"","GET");
		}
		else if(grd=="gridboxgrp"){			
			tab4.loadURL("petugas_utils.php?grdgrp=true&saring=true&id="+document.getElementById('cmbgroup').value+"&filter="+tab4.getFilter()+"&sorting="+tab4.getSorting()+"&page="+tab4.getPage(),"","GET");
		}
		else if(grd=="gridboxtab5"){			
			tab5.loadURL("tmptlayanan_utils.php?grdtab5=true&idPeg="+document.getElementById('txtIdPeg').value+"&filter="+tab5.getFilter()+"&sorting="+tab5.getSorting()+"&page="+tab5.getPage(),"","GET");
		}
		else if(grd=="gridboxtab6"){			
			tab6.loadURL("menu_report_rm_util.php?grdtab6=true&idPeg="+document.getElementById('txtIdPeg').value+"&filter="+tab6.getFilter()+"&sorting="+tab6.getSorting()+"&page="+tab6.getPage(),"","GET");
		}
		else if (grd=="grid1"){
			//alert("group_petugasUtils.php?grd=1&idGroup="+document.getElementById('group').value+"&filter="+gd1.getFilter()+"&sorting="+gd1.getSorting()+"&page="+gd1.getPage());
			gd1.loadURL("group_petugasUtils.php?grd=1&idGroup="+document.getElementById('group').value+"&filter="+gd1.getFilter()+"&sorting="+gd1.getSorting()+"&page="+gd1.getPage(),"","GET");
		}
		else if (grd=="grid2"){
			gd2.loadURL("group_petugasUtils.php?grd=2&idGroup="+document.getElementById('group').value+"&filter="+gd2.getFilter()+"&sorting="+gd2.getSorting()+"&page="+gd2.getPage(),"","GET");
		}
      }
		
		function konfirmasi(key,val){
		var tangkap,proses,tombolSimpan,tombolHapus;
		//alert(val);
			if (val!=undefined && val!='' && val!='*|*'){
				tangkap=val.split("*|*");
				isiCombo('cmbGroup','','','cmbGroup');
				isiCombo('cmbGroup','','','group');
				
				/*if(tangkap[0]=='tambah'){
					alert("Data berhasil disimpan...");
				}else{
					alert("Data berhasil diubah...");
				}*/
			}
		}   

	function showgrid()
	{
		tab2=new DSGridObject("gridboxtab2");
		tab2.setHeader("DATA GROUP");
		tab2.setColHeader("NO,KODE,NAMA,KETERANGAN,STATUS AKTIF");
		tab2.setIDColHeader(",kode,nama,,");
		tab2.setColWidth("50,75,120,150,75");
		tab2.setCellAlign("center,left,left,left,center");
		tab2.setCellHeight(20);
		tab2.setImgPath("../icon");
		tab2.setIDPaging("pagingtab2");
		tab2.attachEvent("onRowClick","ambilDataTab2");
		//tab2.onLoaded(konfirmasi);
		tab2.baseURL("pengguna_utils.php?grdtab2=true");
		tab2.Init();
		<!--==========================================dari rizal =========================================-->
		gd1 = new DSGridObject("grid1");
		gd1.setColHeader("&nbsp;,No,User Name,Nama");
		gd1.setIDColHeader(",,username,nama");
		gd1.setColWidth("30,40,90,300");
		gd1.setCellAlign("center,center,left,left");
		gd1.setCellType("txt,txt,txt,txt");
		gd1.setCellHeight(20);
		gd1.setImgPath("icon");
		gd1.setIDPaging("paging1");
		gd1.attachEvent("onRowClick","ambil1");
		gd1.baseURL("group_petugasUtils.php?grd=1&idGroup="+document.getElementById('group').value);
		gd1.Init();
		
		gd2 = new DSGridObject("grid2");
		//gd2.setHeader(" ",false);
		gd2.setColHeader("&nbsp;,No,User Name,Nama");
		gd2.setIDColHeader(",,username,nama");
		gd2.setColWidth("30,40,90,300");
		gd2.setCellAlign("center,center,left,left");
		gd2.setCellType("txt,txt,txt,txt");
		gd2.setCellHeight(20);
		gd2.setImgPath("icon");
		gd2.setIDPaging("paging2");
		gd2.attachEvent("onRowClick","ambil2");
		gd2.baseURL("group_petugasUtils.php?grd=2&idGroup="+document.getElementById('group').value);
		gd2.Init();
<!------------------------------------------------------------------------------------------------------------------------------>		
		/*tab4=new DSGridObject("gridboxgrp");
		tab4.setHeader("DATA PEGAWAI DALAM GROUP DI ATAS");
		tab4.setColHeader("NO,NIP,NAMA,AKTIF,LOGIN,GROUP");
		tab4.setIDColHeader(",nip,nama,,,kode");
		tab4.setColWidth("50,150,150,50,50,75");
		tab4.setCellAlign("center,left,left,center,center,center");
		tab4.setCellHeight(20);
		tab4.setImgPath("../icon");
		tab4.setIDPaging("paginggrp");
		tab4.attachEvent("onRowClick","ambilDatagrp");
		tab4.baseURL("petugas_utils.php?grdgrp=true&saring=true&id="+document.getElementById('cmbgroup').value);
		tab4.Init();*/
		//alert("petugas_utils.php?grdgrp=true&saring=true&id="+document.getElementById('cmbgroup').value);
		isiCombo('cmbGroup','','','cmbGroup');
		
		tab5=new DSGridObject("gridboxtab5");
		tab5.setHeader("DATA HAK AKSES PEGAWAI");
		tab5.setColHeader("NO,,KODE,TIPE,NAMA TEMPAT LAYANAN");
		tab5.setIDColHeader(",,UNIT_KODE,TIPE,UNIT_NAME");
		tab5.setColWidth("50,100,100,100,500");
		tab5.setCellAlign("center,center,left,left,left");
		tab5.setCellType("txt,chk,txt,txt,txt");
		tab5.setCellHeight(20);
		tab5.setImgPath("../icon");
		tab5.setIDPaging("pagingtab5");
		tab5.attachEvent("onRowClick","ambilDatatab5");
		//tab5.onLoaded(cbkDKlik);
		tab5.baseURL("tmptlayanan_utils.php?grdtab5=true&idPeg="+document.getElementById('txtIdPeg').value);
		tab5.Init();
		
		tab6=new DSGridObject("gridboxtab6");
		tab6.setHeader("DATA HAK AKSES REPORT RM");
		tab6.setColHeader("NO,,KODE,NAMA REPORT RM");
		tab6.setIDColHeader(",,kode,nama");
		tab6.setColWidth("50,100,100,500");
		tab6.setCellAlign("center,center,left,left");
		tab6.setCellType("txt,chk,txt,txt");
		tab6.setCellHeight(20);
		tab6.setImgPath("../icon");
		tab6.setIDPaging("pagingtab6");
		tab6.attachEvent("onRowClick","ambilDatatab6");
		tab6.baseURL("menu_report_rm_util.php?grdtab6=true&idPeg="+document.getElementById('txtIdPeg').value);
		tab6.Init();
	}
	
	function cmb(val){
	var cmb=document.getElementById('group').value;
		//alert("group_petugasUtils.php?grd=1");
		gd2.loadURL("group_petugasUtils.php?grd=2&idGroup="+cmb,"","GET");
		gd1.loadURL("group_petugasUtils.php?grd=1&idGroup="+cmb,"","GET");
	}
	
	/*function pilih()
	{
		tab4.loadURL("petugas_utils.php?grdgrp=true&saring=true&id="+document.getElementById('cmbgroup').value,"","GET");
	}*/
	
	function set(val)
	{
		if(val=='2' || val=='1')
		{
			document.getElementById('tr').style.visibility = 'visible';
		}
		else
		{
			document.getElementById('tr').style.visibility = 'collapse';
		}
		
	}
	
	function simpan(action,id,cek)
	{
		//alert(action);
		//if(ValidateForm(cek,'ind'))
		//{
			var idGroup = document.getElementById("id_group").value;
			var kode = document.getElementById("txtKodeg").value;
			var namag = document.getElementById("txtNm").value;
			var ket = document.getElementById("txtKet").value;
			if(document.getElementById("chAktif").checked==true)
			{
				var aktif=1;
			}
			else
			{
				var aktif=0;
			}
			
			var pegId,idgroup,nip,nama;
			//var inisial = document.getElementById("txtinisial").value;
			var tmptlhr,tgllhr,alamat,tlp,sex,agama,staplikasi,spe;
			var jenis,status,group,username,password,groupGrid;
				
			switch(id)
		 	{
				case 'btnSimpanGroup':
				//alert("pengguna_utils.php?grdtab2=true&act="+action+"&smpn="+id+"&id="+idGroup+"&kode="+kode+"&nama="+namag+"&ket="+ket+"&aktif="+aktif+"&userId=<?php echo $userId;?>");
				tab2.loadURL("pengguna_utils.php?grdtab2=true&act="+action+"&smpn="+id+"&id="+idGroup+"&kode="+kode+"&nama="+namag+"&ket="+ket+"&aktif="+aktif+"&userId=<?php echo $userId;?>","","GET");
				document.getElementById("txtKodeg").value = '';
				document.getElementById("txtNm").value = '';
				document.getElementById("txtKet").value = '';
				document.getElementById("chAktif").checked = false;
				batal("btnBatalGroup");
				break;
				
				case 'btnSimpanPetugas':
					idgroup = document.getElementById("cmbgroup2").value;
					pegId = document.getElementById("PegId").value;
					nip = document.getElementById("txtnip").value;
					nama = document.getElementById("txtnama").value;
					tmptlhr = document.getElementById("txttmptlhr").value;
					tgllhr = document.getElementById("txttgllhr").value;
					alamat = document.getElementById("txtalamat").value;
					tlp = document.getElementById("txttlp").value;
					sex = document.getElementById("cmbgender").value;
					agama = document.getElementById("cmbagama").value;
					staplikasi = document.getElementById("cmbStatus").value;
					spe = (staplikasi=='1')?'0':document.getElementById("cmbSpe").value;
					jenis = document.getElementById("cmbjns").value;
					status = document.getElementById("cmbsts").value;
					group = document.getElementById("cmbgroup2").value;
					username = document.getElementById("txtusrnm").value;
					password = document.getElementById("txtpwd").value;
					groupGrid = document.getElementById("cmbgroup").value;
				//alert("petugas_utils.php?grdgrp=true&id="+document.getElementById('cmbgroup').value+"&act="+action+"&rowid="+pegId+"&idgroup="+idgroup+"&groupGrid="+groupGrid+"&nip="+nip+"&nama="+nama+"&tmpt_lahir="+tmptlhr+"&tgl_lahir="+tgllhr+"&alamat="+alamat+"&telp="+tlp+"&sex="+sex+"&agama="+agama+"&staplikasi="+staplikasi+"&spesialisasi_id="+spe+"&pegawai_jenis="+jenis+"&pegawai_status_id="+status+"&kodegroup="+group+"&username="+username+"&pwd="+password+"&userId=<?php echo $userId;?>");
				tab4.loadURL("petugas_utils.php?grdgrp=true&id="+document.getElementById('cmbgroup').value+"&act="+action+"&rowid="+pegId+"&idgroup="+idgroup+"&groupGrid="+groupGrid+"&nip="+nip+"&nama="+nama+"&tmpt_lahir="+tmptlhr+"&tgl_lahir="+tgllhr+"&alamat="+alamat+"&telp="+tlp+"&sex="+sex+"&agama="+agama+"&staplikasi="+staplikasi+"&spesialisasi_id="+spe+"&pegawai_jenis="+jenis+"&pegawai_status_id="+status+"&kodegroup="+group+"&username="+username+"&pwd="+password+"&userId=<?php echo $userId;?>","","GET");
				document.getElementById("txtnip").value = '';
				document.getElementById("txtnama").value = '';
				//document.getElementById("txtinisial").value = '';
				document.getElementById("txttmptlhr").value = '';
				document.getElementById("txttgllhr").value = '';
				document.getElementById("txtalamat").value = '';
				document.getElementById("txttlp").value = '';
				document.getElementById("cmbgender").value = '';
				document.getElementById("cmbagama").value = '';
				document.getElementById("cmbStatus").value = '';
				document.getElementById("cmbSpe").value = '';
				document.getElementById("cmbjns").value = '';
				document.getElementById("cmbsts").value = '';
				document.getElementById("cmbgroup2").value = '';
				document.getElementById("txtusrnm").value = '';
				document.getElementById("txtpwd").value = '';
				break;
		 	}
		//}
	}
	
	function ambilDataTab2()
	{
		var p ="id_group*-*"+(tab2.getRowId(tab2.getSelRow()))+"*|*txtKodeg*-*"+tab2.cellsGetValue(tab2.getSelRow(),2)+"*|*txtNm*-*"+tab2.cellsGetValue(tab2.getSelRow(),3)+"*|*txtKet*-*"+tab2.cellsGetValue(tab2.getSelRow(),4)+
		"*|*chAktif*-*"+((tab2.cellsGetValue(tab2.getSelRow(),5)=='Aktif')?'true':'false')+
		"*|*btnSimpanGroup*-*Simpan*|*btnHapusGroup*-*false";
		fSetValue(window,p);
		
	}
	
	function ambil2(){
		document.getElementById('idGrdClick').value='2';
		var idx=gd2.getRowId(gd2.getSelRow()).split("|");
		document.getElementById('idPeg').value=document.getElementById('txtId1').value=document.getElementById("txtIdPeg").value=idx[0];
		//alert(gd2.cellsGetValue(gd2.getSelRow(),3));
		if(gd2.cellsGetValue(gd2.getSelRow(),3)==''){
			mTab.setTabDisplay("true,true,true,true,false,3");
			mTab.setTabCaptionWidth("192,192,192,192,0");
		}else{
			//document.getElementById('txtnmRM').value=document.getElementById('txtnm').value=gd2.cellsGetValue(gd2.getSelRow(),4);
			document.getElementById('txtnm').value=gd2.cellsGetValue(gd2.getSelRow(),4);
			mTab.setTabDisplay("true,true,true,true,true,3");
			mTab.setTabCaptionWidth("192,192,192,192,192");
		}
		tab5.loadURL("tmptlayanan_utils.php?grdtab5=true&idPeg="+idx[0],"","GET");
		//tab6.loadURL("menu_report_rm_util.php?grdtab6=true&idPeg="+idx[0],"","GET");
		//fSetValue(window,p);
		//set(sisipan[14]);
	}
	
	function ambilDatagrp()
	{
		if(tab4.cellsGetValue(tab4.getSelRow(),3)=='')
		{
			mTab.setTabDisplay("true,true,true,true,false,0");
			
		}
		else
		{
			mTab.setTabDisplay("true,true,true,true,true,3");
		}
		//alert(tab4.getRowId(tab4.getSelRow()));
		var sisipan = tab4.getRowId(tab4.getSelRow()).split('|');
		var p ="PegId*-*"+sisipan[0]+"*|*txtnip*-*"+tab4.cellsGetValue(tab4.getSelRow(),2)+
		"*|*txtnama*-*"+tab4.cellsGetValue(tab4.getSelRow(),3)+"*|*txttmptlhr*-*"+sisipan[1]+
		"*|*txttgllhr*-*"+sisipan[2]+"*|*txtalamat*-*"+sisipan[3]+"*|*txttlp*-*"+sisipan[4]+
		"*|*cmbgender*-*"+sisipan[5]+"*|*cmbagama*-*"+sisipan[6]+"*|*cmbStatus*-*"+sisipan[14]+
		"*|*cmbSpe*-*"+sisipan[7]+"*|*cmbjns*-*"+sisipan[8]+"*|*cmbsts*-*"+sisipan[9]+"*|*txtusrnm*-*"+sisipan[9]+"*|*cmbgroup2*-*"+sisipan[13]+"*|*txtusrnm*-*"+sisipan[11]+"*|*btnSimpanPetugas*-*Simpan*|*btnHapusPetugas*-*false";
		//alert(p);
		document.getElementById("txtIdPeg").value = sisipan[0];
		document.getElementById("txtnm").value = tab4.cellsGetValue(tab4.getSelRow(),3);
		tab5.loadURL("tmptlayanan_utils.php?grdtab5=true&idPeg="+document.getElementById('txtIdPeg').value,"","GET");
		/*var saveKom = new newRequest();
		saveKom.xmlhttp.open("GET","tmptlayanan_ajax.php?idPeg="+document.getElementById("txtId").value);
		saveKom.xmlhttp.onreadystatechange=function(){
			if(saveKom.xmlhttp.readyState==4){
				var hsl = saveKom.xmlhttp.responseText;
				alert(hsl);
				document.getElementById('txtnm').value = hsl;
			}
		}
		//tmptlay = sisipan[0];*/
		fSetValue(window,p);
		set(sisipan[14]);
	}
	
	function hapus(id)
	{
		var rowidtab2,rowidtab4;
		//var rowidDiag = document.getElementById("id_diag").value;
		
		switch(id)
		{
			case 'btnHapusGroup':
			if(confirm("Anda yakin menghapus Group "+tab2.cellsGetValue(tab2.getSelRow(),3)))
			{
				rowidtab2 = document.getElementById("id_group").value;
				tab2.loadURL("pengguna_utils.php?grdtab2=true&act=hapus&hps="+id+"&rowid="+rowidtab2,"","GET");
			}
				document.getElementById("txtKodeg").value = '';
				document.getElementById("txtNm").value = '';
				document.getElementById("txtKet").value = '';
				document.getElementById("chAktif").checked = false;
				batal("btnBatalGroup");
				break;
			
			case 'btnHapusPetugas':
			if(confirm("Anda yakin menghapus Petugas "+tab4.cellsGetValue(tab4.getSelRow(),3)))
			{
				rowidtab4 = document.getElementById("PegId").value;
				tab4.loadURL("petugas_utils.php?grdgrp=true&act=hapus&hps="+id+"&rowid="+rowidtab4+"&id="+document.getElementById('cmbgroup').value,"","GET");
			}
				document.getElementById("txtnip").value = '';
				document.getElementById("txtnama").value = '';
				//document.getElementById("txtinisial").value = '';
				document.getElementById("txttmptlhr").value = '';
				document.getElementById("txttgllhr").value = '';
				document.getElementById("txtalamat").value = '';
				document.getElementById("txttlp").value = '';
				document.getElementById("cmbgender").value = '';
				document.getElementById("cmbagama").value = '';
				document.getElementById("cmbStatus").value = '';
				document.getElementById("cmbSpe").value = '';
				document.getElementById("cmbjns").value = '';
				document.getElementById("cmbsts").value = '';
				document.getElementById("cmbgroup2").value = '';
				document.getElementById("txtusrnm").value = '';
				document.getElementById("txtpwd").value = '';
				break;
		}
	}
	
	function batal(id)
	{
		switch(id)
		{
			case 'btnBatalGroup':
			var p="id_group*-**|*txtKodeg*-**|*txtNm*-**|*txtKet*-**|*chAktif*-*true*|*btnSimpanGroup*-*Tambah*|*btnHapusGroup*-*true";
			fSetValue(window,p);
			isiCombo('cmbGroup','','','cmbGroup');
			isiCombo('cmbGroup','','','group');
			break;
			
			case 'btnBatalPetugas':
			var p = "PegId*-**|*txtnip*-**|*txtnama*-**|*txttmptlhr*-**|*txttgllhr*-**|*txtalamat*-**|*txttlp*-**|*txtusrnm*-**|*txtpwd*-**|*btnSimpanPetugas*-*Tambah*|*btnHapusPetugas*-*true";
			fSetValue(window,p);
			break;
		}
	}
	
	function simpanAkses(gid,id){
		Request('groupakses_utils.php?gid='+gid+"&id="+id,'isSave','','GET');
	}
	
	
	function simpanSetting(action,p)
	{		
		var parentKode = document.getElementById("txtParentKode").value;
		var kode = document.getElementById("txtKode").value;
		var nama = document.getElementById("txtNama").value;
		var url = encodeURIComponent(document.getElementById("txtUrl").value);
		var id = document.getElementById("txtId").value;
		var level = document.getElementById("txtLevel").value;
		var parentId = document.getElementById("txtParentId").value;
		var parentLvl = document.getElementById("txtParentLvl").value;
		//alert('settingaplikasi_utils.php?parentKode='+parentKode+'&kode='+kode+'&nama='+nama+'&url='+url+'&id='+id+'&level='+level+'&parentId='+parentId+'&parentLvl='+parentLvl);
		var par='&parentKode='+parentKode+'&kode='+kode+'&nama='+nama+'&url='+url+'&id='+id+'&level='+level+'&parentId='+parentId+'&parentLvl='+parentLvl;
		loadtree(p,action,par);
		//Request('settingaplikasi_utils.php?act='+action+'&parentKode='+parentKode+'&kode='+kode+'&nama='+nama+'&url='+url+'&id='+id+'&level='+level+'&parentId='+parentId+'&parentLvl='+parentLvl,'spanProc','','GET');
	}
	
	function hapusSetting(action,p)
	{
		var id = document.getElementById("txtId").value;
		var par='&id='+id;
		if(confirm("Apakah Anda Yakin Ingin Menghapus Data?")){
			loadtree(p,action,par);
		}
		//Request('settingaplikasi_utils.php?act=hapus&id='+id,'spanProc','','GET');
	}
	
	function batalSetting(){
		document.getElementById("txtParentKode").value='';
		document.getElementById("txtKode").value='';
		document.getElementById("txtNama").value='';
		document.getElementById("txtUrl").value='';
		document.getElementById("txtId").value='';
		document.getElementById("txtLevel").value='';
		document.getElementById("txtParentId").value='';
		document.getElementById("txtParentLvl").value='';
		document.getElementById("btnSimpanSetting").value='Tambah';
		document.getElementById("btnHapusSetting").disabled=true;
		document.getElementById("btnBatalSetting").disabled=true;
	}	
<!--===================================================Petugas From Rizal=======================================================-->	
var data='';
function kirimkanan(){
data='';
	for(var r = 0; r<gd1.getMaxRow();r++){
		var px = "cekbok"+r; 
		if(document.getElementById(px).checked){
			data += document.getElementById(px).value+"|";
		}
	}
}

function kirimkiri(){
data='';
	for(var r = 0; r<gd2.getMaxRow();r++){
		var px = "ngecek"+r; 
		if(document.getElementById(px).checked){
			data += document.getElementById(px).value+"|";
		}
	}
}

function kanan(){
	kirimkanan();
	gd1.loadURL("group_petugasUtils.php?act=kanan&grd=1&idGroup="+document.getElementById('group').value+"&data="+data,'','GET');
	setTimeout('cmb()', 1000);
}

function kiri(){
	kirimkiri();
	gd2.loadURL("group_petugasUtils.php?act=kiri&grd=2&idGroup="+document.getElementById('group').value+"&data="+data,'','GET');
	gd2.loadURL("group_petugasUtils.php?act=kiri&grd=2&idGroup="+document.getElementById('group').value,"","GET")
	setTimeout('cmb()', 1000);
}

function ambil1(){
//alert("");
var sisip=gd1.getRowId(gd1.getSelRow()).split("|");
var id=document.getElementById('idPeg').value=document.getElementById('txtId1').value=sisip[0];
	document.getElementById('idGrdClick').value='1';
	document.getElementById('nama_user').value = sisip[2];
	document.getElementById("kata_kunci").value = sisip[1];
	document.getElementById('unit').value = sisip[3]+"U";
	document.getElementById("kategori_user").value = sisip[4]+"K";
	document.getElementById("isaktif").value = sisip[5]+"A";
	document.getElementById("sim").value = "update";
}

/*function editPop(){
	if(document.getElementById('idPeg').value=='' || document.getElementById('idPeg').value==null){
		alert("Pilih dulu data yang akan di edit !")
	}else{
		new Popup('popGrPet',null,{modal:true,position:'center',duration:1});
		document.getElementById('popGrPet').popup.show();
		var sisip=gd1.getRowId(gd1.getSelRow()).split("|");
		document.getElementById("pass").value=sisip[1];
		document.getElementById("passKon").value=sisip[1];
		document.getElementById('namaPeg').value=gd1.cellsGetValue(gd1.getSelRow(),4);
		document.getElementById("user").value=gd1.cellsGetValue(gd1.getSelRow(),3);
		document.getElementById('sim').value="update";
		document.getElementById('sim').innerHTML='<img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Ubah';
	}
}
*/
function del(){
	//var idPeg=document.getElementById('txtId1').value;
	var txtId1 = document.getElementById('txtId1').value;
	if(document.getElementById('txtId1').value=='' || document.getElementById('txtId1').value==null){
		alert("Pilih dulu data yang akan di hapus !")
	}else{
	if(confirm("Apakah anda yakin ingin menghapus data ini ?"))
	gd1.loadURL("group_petugasUtils.php?grd=1&act=hapus&txtId="+txtId1,"","GET");/* 
	document.getElementById('namaPeg').value='';
	document.getElementById('idPeg').value='';
	document.getElementById("pass").value='';
	document.getElementById("passKon").value='';
	document.getElementById("user").value=''; 
	document.getElementById('sim').value='simpan';
	document.getElementById('sim').innerHTML='<img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Simpan';*/
	gaksido();
	}
}

function gaksido(){

//nipR,namaR,tmpLahirR,tglLahirR,almtR,noTlpR,sexR,agamaR,status,SpeR,cmbjnsR,cmbstsR,cmbgroup2R,userNameR,passR
	document.getElementById('user_id_inacbg').value='';
	document.getElementById('nipR').value='';
	document.getElementById('namaR').value='';
	document.getElementById("tmpLahirR").value='';
	//document.getElementById("tglLahirR").value='';
	document.getElementById("almtR").value='';
	document.getElementById('noTlpR').value='';
	document.getElementById('tlpR').value='';
	//document.getElementById('sexR').value='';
	//document.getElementById("agamaR").value='';
	document.getElementById("statusR").value='1';
	//document.getElementById("SpeR").value='';
	//document.getElementById('cmbjnsR').value='';
	//document.getElementById('cmbstsR').value='';
	//document.getElementById("cmbgroup2R").value='';
	document.getElementById("userNameR").value='';
	document.getElementById("passR").value='';
	document.getElementById('sim').value='simpan';
	document.getElementById('sim').innerHTML='<img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Simpan';
}
	
function popup1(){
	bersih1();
	new Popup('popGrPet',null,{modal:true,position:'center',duration:1});
	document.getElementById('popGrPet').popup.show();
}

function act1(parameter){
	var nama_user = document.getElementById('nama_user').value;
	var kata_kunci = document.getElementById("kata_kunci").value;
	var unit1 = document.getElementById('unit').value;
	var kategori_user = document.getElementById("kategori_user").value;
	var isaktif = document.getElementById("isaktif").value;
	var txtId1 = document.getElementById("txtId1").value;
	/*var almtR = document.getElementById("almtR").value;
	var noTlpR = document.getElementById('noTlpR').value;
	var sexR = document.getElementById('sexR').value;
	var agamaR = document.getElementById("agamaR").value;
	var statusR = document.getElementById("statusR").value;
	var SpeR = document.getElementById("SpeR").value;
	var cmbjnsR = document.getElementById('cmbjnsR').value;
	var cmbstsR = document.getElementById('cmbstsR').value;
	//var cmbgroup2R = document.getElementById("cmbgroup2R").value;
	var userNameR = document.getElementById("userNameR").value;
	var passR = document.getElementById("passR").value;
	var tlpR = document.getElementById("tlpR").value;
	var txtId = document.getElementById("txtId1").value;*/
	
	//if (statusR=='1') SpeR='0';
	
	gd1.loadURL("group_petugasUtils.php?grd=1&act="+parameter+"&nama_user="+nama_user+"&kata_kunci="+kata_kunci+"&unit="+unit1+"&kategori_user="+kategori_user+"&isaktif="+isaktif+"&txtId="+txtId1,"","GET");
	//gd1.loadURL("group_petugasUtils.php?grd=1&idGroup="+document.getElementById('group').value+"&act="+parameter+"&niP="+niP+"&namaR="+namaR+"&tmpLahirR="+tmpLahirR+"&tglLahirR="+tglLahirR+"&almtR="+almtR+"&noTlpR="+noTlpR+"&sexR="+sexR+"&agamaR="+agamaR+"&statusR="+statusR+"&SpeR="+SpeR+"&cmbjnsR="+cmbjnsR+"&cmbstsR="+cmbstsR+"&userNameR="+userNameR+"&passR="+passR+"&tlpR="+tlpR+"&txtId="+txtId+"&userId=<?php echo $userId; ?>&user_id_inacbg="+user_id_inacbg,"","GET");
	//alert("group_petugasUtils.php?grd=1&idGroup="+document.getElementById('group').value+"&act="+parameter+"&niP="+niP+"&namaR="+namaR+"&tmpLahirR="+tmpLahirR+"&tglLahirR="+tglLahirR+"&almtR="+almtR+"&noTlpR="+noTlpR+"&sexR="+sexR+"&agamaR="+agamaR+"&statusR="+statusR+"&SpeR="+SpeR+"&cmbjnsR="+cmbjnsR+"&cmbstsR="+cmbstsR+"&cmbgroup2R="+cmbgroup2R+"&userNameR="+userNameR+"&passR="+passR+"&tlpR="+tlpR+"&txtId="+txtId);
}

function bersih1()
{
	document.getElementById('nama_user').value = "";
	document.getElementById('kata_kunci').value = "";
	document.getElementById('sim').value = "simpan";
}

function editPop(){
var sisip;
	if(document.getElementById('txtId1').value=='' || document.getElementById('txtId1').value==null){
		alert("Pilih dulu data yang akan di edit !")
	}else{
		new Popup('popGrPet',null,{modal:true,position:'center',duration:1});
		document.getElementById('popGrPet').popup.show();
		if (document.getElementById('idGrdClick').value=='1'){
			sisip=gd1.getRowId(gd1.getSelRow()).split("|");
			document.getElementById('namaR').value=gd1.cellsGetValue(gd1.getSelRow(),4);
		}else{
			sisip=gd2.getRowId(gd2.getSelRow()).split("|");
			document.getElementById('namaR').value=gd2.cellsGetValue(gd2.getSelRow(),4);
		}
		/*document.getElementById("passR").value='';
		document.getElementById("userNameR").value=sisip[2];
		document.getElementById("nipR").value=sisip[3];
		document.getElementById("agamaR").value=sisip[4];
		document.getElementById("noTlpR").value=sisip[5];
		document.getElementById("tlpR").value=sisip[6];
		document.getElementById("cmbjnsR").value=sisip[7];
		document.getElementById("cmbstsR").value=sisip[8];*/
		//document.getElementById("cmbgroup2R").value=sisip[8];
		if (sisip[14]!='1'){
			document.getElementById("SpeR").value=sisip[9];
			document.getElementById("statusR").value='2';
		}else{
			document.getElementById("statusR").value='1';
		}
		
		StatApChange(sisip[14]);
		document.getElementById("sexR").value=sisip[10];
		document.getElementById("tmpLahirR").value=sisip[11];
		if(sisip[12]!=''){
			var tglR=sisip[12];
			var tgl1R=tglR.split("-");
			var tgl2R=tgl1R[2]+"-"+tgl1R[1]+"-"+tgl1R[0];
			document.getElementById("tglLahirR").value=tgl2R;
		}else
			document.getElementById("tglLahirR").value='';
		document.getElementById('almtR').value=sisip[13];
		document.getElementById('user_id_inacbg').value=sisip[15];
		
		document.getElementById('sim').value="update";
		document.getElementById('sim').innerHTML='<img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Ubah';
	}
}

function StatApChange(p){
	if (p==1){
		document.getElementById("trSpe").style.visibility='collapse';
	}else{
		document.getElementById("trSpe").style.visibility='visible';
	}
}
</script>
</html>
