<?
include("../sesi.php");
?>
<?php
	//session_start();
	$userId = $_SESSION['userId'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
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
	include("../header1.php");
	include("../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	
	$sql = "SELECT RIGHT(MAX(kode),3) AS kode FROM b_ms_group";
	$rs = mysqli_query($konek,$sql);
	$rw = mysqli_fetch_array($rs);
?>
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;DETAIL PASIEN</td>
	</tr>
</table>
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
<table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
  <tr height="30">
  	<td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" class="btninput" /></td>
	<td>&nbsp;</td>
	<td align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" class="btninput"/></a>&nbsp;</td>
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
	   
	   OpenWnd('settingaplikasi_treeview.php?'+qstr_ma_sak,800,500,'msma',true);
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
	mTab.setTabCaptionWidth("192,192,192,192,192");
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
		Request ( 'http://'+addrs+'/simrs-tangerang/billing/setting/grouptree.php?gid='+val , 'divtree3', '', 'GET');
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
	
	function tampil(){
		//tab5.loadURL("tmptlayanan_utils.php?grdtab5=true&idPeg="+document.getElementById('txtIdPeg').value,"","GET");
		setTimeout("document.getElementById('spanSuk').innerHTML=''",'1000');
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
		tab2.baseURL("pengguna_utils.php?grdtab2=true");
		tab2.Init();
		
		tab4=new DSGridObject("gridboxgrp");
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
		tab4.Init();
		//alert("petugas_utils.php?grdgrp=true&saring=true&id="+document.getElementById('cmbgroup').value);
		isiCombo('cmbGroup','','','cmbGroup');
		
		tab5=new DSGridObject("gridboxtab5");
		tab5.setHeader("DATA HAK AKSES PEGAWAI");
		tab5.setColHeader("NO,,KODE,NAMA TEMPAT LAYANAN");
		tab5.setIDColHeader(",,Kode,Nama");
		tab5.setColWidth("50,25,75,150");
		tab5.setCellAlign("center,center,left,left");
		tab5.setCellType("txt,chk,txt,txt");
		tab5.setCellHeight(20);
		tab5.setImgPath("../icon");
		tab5.setIDPaging("pagingtab5");
		tab5.attachEvent("onRowClick","ambilDatatab5");
		//tab5.onLoaded(cbkDKlik);
		tab5.baseURL("tmptlayanan_utils.php?grdtab5=true&idPeg="+document.getElementById('txtIdPeg').value);
		tab5.Init();
	}
	
	
	function pilih()
	{
		tab4.loadURL("petugas_utils.php?grdgrp=true&saring=true&id="+document.getElementById('cmbgroup').value,"","GET");
	}
	
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
			var kode = document.getElementById("txtKode").value;
			var nama = document.getElementById("txtNm").value;
			var ket = document.getElementById("txtKet").value;
			if(document.getElementById("chAktif").checked==true)
			{
				var aktif=1;
			}
			else
			{
				var aktif=0;
			}
			
			var pegId = document.getElementById("PegId").value;
			var idgroup = document.getElementById("cmbgroup2").value;
			var nip = document.getElementById("txtnip").value;
			var nama = document.getElementById("txtnama").value;
			//var inisial = document.getElementById("txtinisial").value;
			var tmptlhr = document.getElementById("txttmptlhr").value;
			var tgllhr = document.getElementById("txttgllhr").value;
			var alamat = document.getElementById("txtalamat").value;
			var tlp = document.getElementById("txttlp").value;
			var sex = document.getElementById("cmbgender").value;
			var agama = document.getElementById("cmbagama").value;
			var staplikasi = document.getElementById("cmbStatus").value;
			var spe = (staplikasi=='1')?'0':document.getElementById("cmbSpe").value;
			var jenis = document.getElementById("cmbjns").value;
			var status = document.getElementById("cmbsts").value;
			var group = document.getElementById("cmbgroup2").value;
			var username = document.getElementById("txtusrnm").value;
			var password = document.getElementById("txtpwd").value;
			var groupGrid = document.getElementById("cmbgroup").value;
				
			switch(id)
		 	{
				case 'btnSimpanGroup':
				//alert("pengguna_utils.php?grdtab2=true&act="+action+"&smpn="+id+"&id="+idGroup+"&kode=<?php echo $rw['kode']; ?>&nama="+nama+"&ket="+ket+"&aktif="+aktif);
				tab2.loadURL("pengguna_utils.php?grdtab2=true&act="+action+"&smpn="+id+"&id="+idGroup+"&kode=<?php echo $rw['kode']; ?>&nama="+nama+"&ket="+ket+"&aktif="+aktif+"&userId=<?php echo $userId;?>","","GET");
				document.getElementById("txtKode").value = '';
				document.getElementById("txtNm").value = '';
				document.getElementById("txtKet").value = '';
				document.getElementById("chAktif").checked = false;
				break;
				
				case 'btnSimpanPetugas':
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
		var p ="id_group*-*"+(tab2.getRowId(tab2.getSelRow()))+"*|*txtKode*-*"+tab2.cellsGetValue(tab2.getSelRow(),2)+"*|*txtNm*-*"+tab2.cellsGetValue(tab2.getSelRow(),3)+"*|*txtKet*-*"+tab2.cellsGetValue(tab2.getSelRow(),4)+
		"*|*chAktif*-*"+((tab2.cellsGetValue(tab2.getSelRow(),5)=='Aktif')?'true':'false')+
		"*|*btnSimpanGroup*-*Simpan*|*btnHapusGroup*-*false";
		fSetValue(window,p);
		
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
		var rowidtab2 = document.getElementById("id_group").value;
		var rowidtab4 = document.getElementById("PegId").value;
		//var rowidDiag = document.getElementById("id_diag").value;
		
		switch(id)
		{
			case 'btnHapusGroup':
			if(confirm("Anda yakin menghapus Group "+tab2.cellsGetValue(tab2.getSelRow(),3)))
			{
				tab2.loadURL("pengguna_utils.php?grdtab2=true&act=hapus&hps="+id+"&rowid="+rowidtab2,"","GET");
			}
				document.getElementById("txtKode").value = '';
				document.getElementById("txtNm").value = '';
				document.getElementById("txtKet").value = '';
				document.getElementById("chAktif").checked = false;
				break;
			
			case 'btnHapusPetugas':
			if(confirm("Anda yakin menghapus Petugas "+tab4.cellsGetValue(tab4.getSelRow(),3)))
			{
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
			var p="id_group*-**|*txtKode*-**|*txtNm*-**|*txtKet*-**|*chAktif*-*true*|*btnSimpanGroup*-*Tambah*|*btnHapusGroup*-*true";
			fSetValue(window,p);
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
	
</script>
</html>
