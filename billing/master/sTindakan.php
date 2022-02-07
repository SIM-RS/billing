<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" type="text/css" href="../theme/tab-view.css" />
<script type="text/javascript" src="../theme/js/tab-view.js"></script>
<script type="text/javascript" src="../theme/js/ajax.js"></script>
<script type="text/javascript" src="../include/jquery/jquery-1.9.1.js"></script>

 <!--dibawah ini diperlukan untuk menampilkan popup-->
     <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
     <script type="text/javascript" src="../theme/prototype.js"></script>
     <script type="text/javascript" src="../theme/effects.js"></script>
     <script type="text/javascript" src="../theme/popup.js"></script>
 <!--diatas ini diperlukan untuk menampilkan popup-->
<title>Master TIndakan</title>
</head>

<body>
<div align="center">
<?php
	include("../koneksi/konek.php");
	include("../header1.php");
	$user_id=$_SESSION['userId'];
	$unit_id=$_SESSION['unitId'];
?>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/dsgrid_sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;FORM TARIF TINDAKAN</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" class="tabel">  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center"><div class="TabView" id="TabView" style="width: 950px; height: 650px;"></div></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>
  <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
  <tr height="30">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
</body>
<script>
var mTab=new TabView("TabView");
mTab.setTabCaption("MASTER TINDAKAN ICD 9 CM, MASTER TINDAKAN PEMERIKSAAN,KELOMPOK PENDAPATAN TINDAKAN,KELOMPOK MCU");
mTab.setTabCaptionWidth("200,250,250,200");
mTab.onLoaded(showgrid);
mTab.setTabPage("tin_inacbg.php,tindakan_tab.php,tindakan_ak.php,kelompok_mcu.php");
//mTab.
var tab1;
var tab2;
var tab3a;
var a;
var b;
var tindA,tindAK,kmcu,ktmcu,ktmcu2,tmpt;
var idTin='';
function pindah(param = 'r'){
	var idTin = "";
	var actAK = "tambah";
	switch(param){
		case 'r':
			for(var i=0;i<tindA.obj.childNodes[0].rows.length;i++){
				//alert(tindA.obj.childNodes[0].rows.length)
				if(tindA.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
					var getBaris=tindA.getRowId(parseInt(i)+1).split("|");
					var barisId=getBaris[0];
					idTin+=barisId+',';	
				}
			}
			//alert(idTin);		
			actAK = "tambah";
			break;
		case 'l':
			for(var i=0;i<tindAK.obj.childNodes[0].rows.length;i++){
				if(tindAK.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
					var getBaris=tindAK.getRowId(parseInt(i)+1).split("|");
					var barisId=getBaris[0];
					idTin+=barisId+',';	
				}
			}
			//alert(idTin);
			actAK = "hapus";
			break;
	}
	
	if(idTin == ''){
		alert("Silakan pilih tindakan unit!");
	} else {
		tindAK.loadURL("tindakan_ak_utils.php?grd=2&act="+actAK+"&id="+idTin+"&pendapatan="+document.getElementById('pendapatan').value, "", "GET");
		tindA.loadURL("tindakan_ak_utils.php?grd=1&pendapatan="+document.getElementById('pendapatan').value,"","GET");
		idTin='';
	}
}
/*function isiCombo(id,val,defaultId,targetId,evloaded)
        {
            if(targetId=='' || targetId==undefined)
            {
                targetId=id;
            }
            Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,id,'','GET',evloaded);
        }*/

//====================================Tambahan Tindakan Function Baru==============================================

//-----------Tambahan utk PopUp---------------//
	function detailRA(){
		gRA.loadURL('klasifikasi_util.php','','GET');
		new Popup('divRiwayatAlergi',null,{modal:true,position:'center',duration:1});
    	document.getElementById('divRiwayatAlergi').popup.show();	
	}
	
	function closeRA(){
		//Request('klasifikasi_util.php?act=view_last','hsl_RA_terakhir','','GET',loadRATerakhir,'noLoad');
		document.getElementById('divRiwayatAlergi').popup.hide();
		location.reload();
	}
	
	function ganti111()
	{
		gRB.loadURL('kelompok_util.php?klasifikasi='+document.getElementById("klasi").value,'','GET');
	}
	
	function batalRA(){
		document.getElementById('status').checked=false;
		document.getElementById('kode_klasifikasi').value='';
		document.getElementById('txtRiwayatAlergi').value='';
		document.getElementById('id_klasifikasi').value='';
		document.getElementById('btnSimpanRA').value='tambah';
		document.getElementById('btnSimpanRA').innerHTML="<img src='../icon/edit_add.png' height='16' width='16' style='position:absolute;' /><span style='margin-left:20px;'>Add</span>";
		document.getElementById('btnDeleteRA').disabled=true;	
	}
	
	function ambilRA(){
		var sisip=gRA.getRowId(gRA.getSelRow()).split("|");
		var cek = sisip[3];
		if(cek==1){document.getElementById('status').checked=true;}
		else{document.getElementById('status').checked=false;}
		document.getElementById('kode_klasifikasi').value=sisip[2];
		document.getElementById('txtRiwayatAlergi').value=sisip[1];
		document.getElementById('id_klasifikasi').value=sisip[0];
		document.getElementById('btnSimpanRA').value='simpan';
		document.getElementById('btnSimpanRA').innerHTML="<img src='../icon/save.gif' height='16' width='16' style='position:absolute;' /><span style='margin-left:20px;'>Save</span>";
		document.getElementById('btnDeleteRA').disabled=false;	
	}
	
	function deleteRA(){
		var	id_klasifikasi=document.getElementById('id_klasifikasi').value;
		gRA.loadURL('klasifikasi_util.php?act=hapus&id_klasifikasi='+id_klasifikasi,'','GET');
		batalRA();	
	}
	var status;
	function saveRA(act){
		if(document.getElementById('status').checked==true){
		status=1}else{status=0;};
		var kode_klasifikasi=document.getElementById('kode_klasifikasi').value;
		var txtRiwayatAlergi=document.getElementById('txtRiwayatAlergi').value;
		var	id_klasifikasi=document.getElementById('id_klasifikasi').value;
		gRA.loadURL('klasifikasi_util.php?act='+act+'&txtRiwayatAlergi='+txtRiwayatAlergi+'&id_klasifikasi='+id_klasifikasi+'&kode_klasifikasi='+kode_klasifikasi+'&status='+status,'','GET');
		batalRA();
	}
	
	/*function loadRATerakhir(){
		document.getElementById('txtRA').innerHTML = document.getElementById('hsl_RA_terakhir').innerHTML;	
	}*/
	
	function detailRB(){
		gRB.loadURL('kelompok_util.php?klasifikasi='+document.getElementById("klasi").value,'','GET');
		new Popup('divKelompok',null,{modal:true,position:'center',duration:1});
    	document.getElementById('divKelompok').popup.show();	
	}
	
	function closeRB(){
		//Request('klasifikasi_util.php?act=view_last','hsl_RA_terakhir','','GET',loadRATerakhir,'noLoad');
		document.getElementById('divKelompok').popup.hide();
		location.reload();
	}
	
	function batalRB(){
		//isiCombo('klasi','',1, 'klasi', '');
		document.getElementById('status_tindakan').checked=false;
		document.getElementById('kode_kelompok').value='';
		document.getElementById('kelompok_tindakan').value='';
		document.getElementById('id_kelompok').value='';
		document.getElementById('btnSimpanRB').value='tambah';
		document.getElementById('btnSimpanRB').innerHTML="<img src='../icon/edit_add.png' height='16' width='16' style='position:absolute;' /><span style='margin-left:20px;'>Add</span>";
		document.getElementById('btnDeleteRB').disabled=true;	
	}
	
	function ambilRB(){
		var sisip=gRB.getRowId(gRB.getSelRow()).split("|");
		var cek = sisip[3];
		if(cek==1){document.getElementById('status_tindakan').checked=true;}
		else{document.getElementById('status_tindakan').checked=false;}
		var ini=sisip[4];
		document.getElementById('klasi').value=ini;
		//isiCombo('klasi','',ini, 'klasi', '');
		document.getElementById('kode_kelompok').value=sisip[2];
		document.getElementById('kelompok_tindakan').value=sisip[1];
		document.getElementById('id_kelompok').value=sisip[0];
		document.getElementById('btnSimpanRB').value='simpan';
		document.getElementById('btnSimpanRB').innerHTML="<img src='../icon/save.gif' height='16' width='16' style='position:absolute;' /><span style='margin-left:20px;'>Save</span>";
		document.getElementById('btnDeleteRB').disabled=false;	
	}
	
	function deleteRB(){
		var	id_kelompok=document.getElementById('id_kelompok').value;
		gRB.loadURL('kelompok_util.php?act=hapus&id_kelompok='+id_kelompok,'','GET');
		batalRB();	
	}
	var status2;
	function saveRB(act){
		if(document.getElementById('status_tindakan').checked==true){
		status2=1}else{status2=0;};
		var klasi=document.getElementById('klasi').value;
		var kode_kelompok=document.getElementById('kode_kelompok').value;
		var kelompok_tindakan=document.getElementById('kelompok_tindakan').value;
		var	id_kelompok=document.getElementById('id_kelompok').value;
		gRB.loadURL('kelompok_util.php?act='+act+'&kelompok_tindakan='+kelompok_tindakan+'&id_kelompok='+id_kelompok+'&kode_kelompok='+kode_kelompok+'&klasi='+klasi+'&status='+status2+'&klasifikasi='+document.getElementById("klasi").value,'','GET');
		batalRB();
	}
	//----------------------------------------//
        function getRadioValue(nameRadio){
            for(var i=1;i<=document.getElementsByName(nameRadio).length;i++){
                if(document.getElementById(nameRadio+i).checked){
                    //alert(document.getElementById(nameRadio+i).value);
                    if(document.getElementById(nameRadio+i).value=='0'){
                        document.getElementById('thHarga').innerHTML='(%)Prosentase';
                        for(var j=0;j<document.getElementsByName('hrgkom').length;j++){
                            document.getElementById('hrgkom_'+j).style.display='none';
                            document.getElementById('prokom_'+j).style.display='block';
                        }
                        //document.getElementById('txtTarif').value=0;
                        document.getElementById('txtTarif').readOnly=false;
                    }
                    else{
                        document.getElementById('thHarga').innerHTML='Harga';
                        for(var j=0;j<document.getElementsByName('hrgkom').length;j++){
                            document.getElementById('hrgkom_'+j).style.display='block';
                            document.getElementById('prokom_'+j).style.display='none';
                        }
                        //document.getElementById('txtTarif').value=0;
                        document.getElementById('txtTarif').readOnly=true;

                    }
                }
            }

        }

        //////////////////fungsi untuk kelas tindakan////////////////////////
        function isiCombo(id,val,defaultId,targetId){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
			// alert(targetId);
            //alert('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET');
            Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET');
        }
		function isiComboPenjamin(id,val,defaultId,targetId,evloaded){
		
		if(targetId=='' || targetId==undefined){
			targetId=id;
		}
		if(document.getElementById(targetId)==undefined){
			alert('Elemen target dengan id: \''+targetId+'\' tidak ditemukan!');
		}else{
			Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
		}
		
	}
        isiCombo('cmbKlasi');
        //isiCombo('cmbKelTin','1');
		//var aaa1 = document.getElementById('cmbKlasi').value;
		isiCombo('cmbKelTin','5');
        function getTarif(){
            new Popup('div_tarif',null,{modal:true,position:'center',duration:0.5});
            document.getElementById('div_tarif').popup.show();
        }
        function setTarif()
        {
            document.getElementById('txtTarif').value = total();
        }

        function total(){
			<?
			$sql3 = "SELECT id,kode,nama,tarip_default,tarip_prosen,aktif FROM b_ms_komponen where aktif=1";
                    $rs3 = mysql_query($sql3);
                    $i= mysql_num_rows($rs3);
             ?>
            var getI=<?php echo $i;?>;
            var jml=0;i=0;
            if(document.getElementById('chkSetTarif2').checked){
                while(i<getI){
                    if(document.getElementById('komp_'+i).checked==true){
                        jml+=parseInt(document.getElementById('hrgkom_'+i).value);
                    }
                    i++;
                }
                i=0;
                while(i<getI){
                    if(document.getElementById('komp_'+i).checked==true){
                        document.getElementById('prokom_'+i).value=parseInt(document.getElementById('hrgkom_'+i).value)/jml*100;
                        //alert(document.getElementById('prokom_'+i).value);
                    }
                    i++;
                }
            }
            else{
                while(i<getI){
                    if(document.getElementById('komp_'+i).checked==true){
                        document.getElementById('hrgkom_'+i).value=parseInt(document.getElementById('prokom_'+i).value)/100*parseInt(document.getElementById('txtTarif').value);
                    }
                    i++;
                }
                jml=parseInt(document.getElementById('txtTarif').value);
            }
            return jml;
        }

        function simpanKom(id,harga,prosen){
            //alert(id+" "+harga);
            //alert("tindakan_kls_utils.php?act=simpanKomponen&id="+id+"&harga="+harga);
            var saveKom = new newRequest();
            //alert("tindakan_kls_utils.php?act=simpanKomponen&id="+id+"&harga="+harga+"&prosen="+prosen+"&user_id=<?php echo $user_id; ?>"); 
            saveKom.xmlhttp.open("GET","tindakan_kls_utils.php?act=simpanKomponen&id="+id+"&harga="+harga+"&prosen="+prosen+"&user_id=<?php echo $user_id; ?>");
            saveKom.xmlhttp.onreadystatechange=function(){
                if(saveKom.xmlhttp.readyState==4){
                    var hsl = saveKom.xmlhttp.responseText;
                    if(hsl==1){
                        alert('update harga sukses');
                        setTarif();
                    }
                    else if(hsl==-1){
                        alert('update harga gagal');
                    }
                    else{
                        alert(hsl);
                    }
                }
            }
            saveKom.xmlhttp.send(null);
        }

        function simpanKelas(action)
        {
            var id = document.getElementById("txtIdKls").value;
            var kls = document.getElementById("cmbKls").value;
            var retribusi = document.getElementById("cmbRetriKls").value;
            var penjamin = document.getElementById("cmbPenjamin").value;
            var tarif = document.getElementById("txtTarif").value;
            //var tarifAskes = document.getElementById('txtTarifAskes').value;

            var i=0,j=0;
            var param='';
            var getI=<?php echo $i;?>;
            while(i<getI){
                if(document.getElementById('komp_'+i).checked==true){
                    param+=document.getElementById('komp_'+i).value+'|'+document.getElementById('hrgkom_'+i).value+'|'+document.getElementById('prokom_'+i).value+'-';
                }
                i++;
            }
            if(param!=''){
                param=param.substr(0,param.length-1);
            }

            if(document.getElementById("isAktifKls").checked == true)
            {
                var aktif = 1;
            }
            else
            {
                var aktif = 0;
            }

			if(document.getElementById("txtManual").checked == true)
            {
                var manual = 1;
            }
            else
            {
                var manual = 0;
            }
            
			b.loadURL("tindakan_kls_utils.php?grd=true&act="+action+"&id="+id+"&tindId="+document.getElementById('txtId').value+"&kls="+kls+"&tarif="+tarif+"&aktif="+aktif+"&retribusi="+retribusi+"&param="+param+"&penjamin="+penjamin+"&manual="+manual+"&user_id=<?php echo $user_id; ?>","","GET");
            //+"&tarifAskes="+tarifAskes
            batalKelas();
        }

        function ambilDataKelas()
        {
            batalKelas();
            var terima=b.getRowId(b.getSelRow()).split('#');
            for(var i=3;i<terima.length;i++){
                var t=terima[i].split("|");
                for(var j=0;j<document.getElementsByName('chKom').length;j++){
                    if(document.getElementById('komp_'+j).value==t[1]){
                        document.getElementById('hrgkom_'+j).value=t[2];
                        document.getElementById('prokom_'+j).value=t[3];
                        document.getElementById('komp_'+j).checked=true;
                    }
                }
			if (b.cellsGetValue(b.getSelRow(),7) == 'Tidak') {
				document.getElementById('txtManual').checked = false;
			} else {
				document.getElementById('txtManual').checked = true;
			}
            }

            var p="txtIdKls*-*"+terima[0]+"*|*cmbKls*-*"+terima[1]+"*|*cmbRetriKls*-*"+terima[2]+"*|*cmbPenjamin*-*"+terima[3]+"*|*txtTarif*-*"+b.cellsGetValue(b.getSelRow(),5)+"*|*isAktifKls*-*"+((b.cellsGetValue(b.getSelRow(),6)=='Aktif')?'true':'false')+"*|*btnSimpanKls*-*Simpan*|*btnHapusKls*-*false";
            //+"*|*txtTarifAskes*-*"+b.cellsGetValue(b.getSelRow(),5)
            // alert(p);
            fSetValue(window,p);
        }

        function hapusKelas()
        {
            var rowid = document.getElementById("txtIdKls").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
            if(confirm("Anda yakin menghapus Tindakan Kelas "+b.cellsGetValue(b.getSelRow(),3)))
            {
                b.loadURL("tindakan_kls_utils.php?grd=true&act=hapus&rowid="+rowid+"&tindId="+document.getElementById('txtId').value,"","GET");
            }
            batalKelas();

        }

        function batalKelas()
        {
            var par='';
            var i=0;
            var getI=<?php echo $i;?>;
            while(i<getI){
                par+="*|*komp_"+i+"*-*false*|*hrgkom_"+i+"*-*"+document.getElementById('hrgkom_'+i).lang;
                i++;
            }

            var p="txtIdKls*-**|*cmbKls*-**|*txtTarif*-*0"+par+"*|*isAktifKls*-*true*|*btnSimpanKls*-*Tambah*|*btnHapusKls*-*true";
            //*|*txtTarifAskes*-*0
            //alert(p);
            fSetValue(window,p);
        }
        ///////////////////////////////////////////////////////////////////

        //////////////////fungsi untuk tindakan////////////////////////
		function simpan1(action)
		{
			if(action=="Tambah")
			{
				var parent = document.getElementById("par").value;
			 	var code = document.getElementById("code").value;
			 	var nm = document.getElementById("nama").value;
				 //alert("");
				 //tab1.loadURL("tininacbg_utils.php?grd=true&smpn=inacbg&act="+action+"&parent="+parent+"&code="+code+"&nm="+nm);
				 tab1.loadURL("tininacbg_utils.php?grd=true&smpn=inacbg&act="+action+"&parent="+parent+"&code="+code+"&nm="+nm,"","GET");
				 batal1();	
			}else if(action=="Simpan"){
				var parent = document.getElementById("par").value;
			 	var code = document.getElementById("code").value;
			 	var nm = document.getElementById("nama").value;
				var aui = document.getElementById("idSatuan").value;
				
				tab1.loadURL("tininacbg_utils.php?grd=true&smpn=inacbg&act="+action+"&parent="+parent+"&code="+code+"&nm="+nm+"&aui="+aui,"","GET");
     			batal1();
			}
		}
        function simpan(action)
        {
            if(ValidateForm('txtKode,txtNama,isAktif','ind'))
            {
                var id = document.getElementById("txtId").value;
				var icd9cm = document.getElementById("txtICD9cm").value;
                var kode = document.getElementById("txtKode").value;
                var nama = document.getElementById("txtNama").value;
                var kodeAskes = document.getElementById("txtKodeAskes").value;
                var namaAskes = document.getElementById("txtNamaAskes").value;
                var klas_id = document.getElementById("cmbKlasi").value;
                var kel_id = document.getElementById("cmbKelTin").value;
                var unit_id = '<?php echo $unit_id;?>';
                if(document.getElementById("isAktif").checked == true)
                {
                    var aktif = 1;
                }
                else
                {
                    var aktif = 0;
                }

                a.loadURL("tindakan_utils.php?grd=true&act="+action+"&id="+id+"&unit="+unit_id+"&kode="+kode+"&nama="+nama+"&kodeAskes="+kodeAskes+"&namaAskes="+namaAskes+"&klasId="+klas_id+"&kelTinId="+kel_id+"&aktif="+aktif+"&icd9cm="+icd9cm,"","GET");
                batal();
                /*
                        document.getElementById("txtKode").value = '';
                        document.getElementById("txtNama").value = '';
                        document.getElementById("cmbKlasi").value = '';
                        document.getElementById("cmbKelTin").value = '';
                        document.getElementById("isAktif").checked = false;
                 */
            }
        }

        function ambilData()
        {
            var sisip=a.getRowId(a.getSelRow()).split("|");
            var p="txtICD9cm*-*"+sisip[5]+"*|*txtId*-*"+sisip[0]+"*|*txtKode*-*"+a.cellsGetValue(a.getSelRow(),2)+"*|*txtNama*-*"+a.cellsGetValue(a.getSelRow(),3)+"*|*txtKodeAskes*-*"+sisip[3]+"*|*txtNamaAskes*-*"+sisip[4]+"*|*cmbKlasi*-*"+sisip[2]+"*|*isAktif*-*"+((a.cellsGetValue(a.getSelRow(),6)=='Aktif')?'true':'false')+"*|*btnSimpan1*-*Simpan*|*btnHapus1*-*false";
			//document.getElementById("btnSimpan").value = "Simpan";
			//document.getElementById("btnSimpan").disabled = false;
            fSetValue(window,p);
            //isiCombo('cmbKlasi', '', sisip[2], 'cmbKlasi', '');
            isiCombo('cmbKelTin', sisip[2], sisip[1], 'cmbKelTin', '');
			console.log(sisip);
        }
		
		var tmpPKode;
		function ambilData1()
        {
			//alert("");
            var sisip=tab1.getRowId(tab1.getSelRow()).split("|");
            var p="par*-*"+sisip[1]+"*|*code*-*"+sisip[2]+"*|*nama*-*"+sisip[3]+"*|*idSatuan*-*"+sisip[0]+"*|*btnSimpan*-*Simpan*|*btnHapus*-*false";
			document.getElementById("par").value = sisip[1];
			tmpPKode = sisip[1];
			//document.getElementById("btnSimpan").value = "Simpan";
			//document.getElementById("btnSimpan").disabled = false;
            //alert(p);
            fSetValue(window,p);
            //isiCombo('cmbKlasi', '', sisip[2], 'cmbKlasi', '');
            //isiCombo('cmbKelTin', sisip[2], sisip[1], 'cmbKelTin', '');
        }

        function hapus()
        {
            var rowid = document.getElementById("txtId").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
            if(confirm("Anda yakin menghapus Tindakan "+a.cellsGetValue(a.getSelRow(),3)))
            {
                a.loadURL("tindakan_utils.php?grd=true&act=hapus&rowid="+rowid,"","GET");
            }
            batal();
        }
		
		function hapus1()
        {
			 var parent = document.getElementById("par").value;
			 var code = document.getElementById("code").value;
			 var nm = document.getElementById("nama").value;
			 var aui = document.getElementById("idSatuan").value;
			 //alert("");
			 //tab1.loadURL("tininacbg_utils.php?grd=true&smpn=inacbg&act="+action+"&parent="+parent+"&code="+code+"&nm="+nm);
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
            if(confirm("Anda yakin menghapus?"))
            {
				tab1.loadURL("tininacbg_utils.php?grd=true&hps=inacbg&act=hapus&aui="+aui,"","GET");
			 	batal1();
            }
            //batal();
        }

        function batal()
        {
			var p="txtICD9cm*-**|*txtId*-**|*txtKode*-**|*txtNama*-**|*txtKodeAskes*-**|*txtNamaAskes*-**|*isAktif*-*true*|*btnSimpan1*-*Tambah*|*btnHapus1*-*true";
            fSetValue(window,p);
        }
		
		function batal1()
        {
            var p="par*-**|*code*-**|*nama*-**|*btnSimpan*-*Tambah*|*btnHapus*-*true";
            fSetValue(window,p);
        }

        function goToKelas(){
            //alert('tes');
            var sisip=a.getRowId(a.getSelRow()).split("|");
            document.getElementById("txtId").value=sisip[0];
            document.getElementById("tind").innerHTML=a.cellsGetValue(a.getSelRow(),3);
            document.getElementById('div_kelas').style.display='block';
            document.getElementById('div_tindakan').style.display='none';
            b.loadURL("tindakan_kls_utils.php?grd=true&tindId="+document.getElementById('txtId').value,"","GET");
        }
        //////////////////////////////////////////////////////////////////

        /* function goFilterAndSort(grd){
            //alert(grd);
            if (grd=="gridbox"){
                a.loadURL("tindakan_utils.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
            }else if (grd=="gridbox2"){
                b.loadURL("tindakan_kls_utils.php?grd=true&tindId="+document.getElementById('txtId').value+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage(),"","GET");
            }
        } */
//====================================Tambahan Tindakan Function Baru==============================================		

function goFilterAndSort(grd){	
	if(grd=="gridboxtab1"){
		//alert("tarif_tempat_layanan_utils.php?grd=1&unitId="+document.getElementById('cmbUnit').value+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
		tab1.loadURL("tininacbg_utils.php?grd=true&filter="+tab1.getFilter()+"&sorting="+tab1.getSorting()+"&page="+tab1.getPage(),"","GET");
	}
	else if(grd=="gridboxtab2"){
		//alert("tarif_tempat_layanan_utils.php?grd=1&unitId="+document.getElementById('cmbUnit').value+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
		tab2.loadURL("labSatuan_utils.php?grd1=true&filter="+tab2.getFilter()+"&sorting="+tab2.getSorting()+"&page="+tab2.getPage(),"","GET");
	}
	else if(grd=="gridboxtab3"){
		//alert("tarif_tempat_layanan_utils.php?grd=1&unitId="+document.getElementById('cmbUnit').value+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
		tab3.loadURL("labSatuan_utils.php?grd2=true&filter="+tab3.getFilter()+"&sorting="+tab3.getSorting()+"&page="+tab3.getPage(),"","GET");
	}
	else if(grd=="gridboxtab4"){
		//alert("tarif_tempat_layanan_utils.php?grd=1&unitId="+document.getElementById('cmbUnit').value+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
		tab4.loadURL("labSatuan_utils.php?grd1=true&filter="+tab4.getFilter()+"&sorting="+tab4.getSorting()+"&page="+tab4.getPage(),"","GET");
	}
	else if(grd=="gridboxtab5"){
		//alert("tarif_tempat_layanan_utils.php?grd=1&unitId="+document.getElementById('cmbUnit').value+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
		tab5.loadURL("labSatuan_utils.php?grd4=true&filter="+tab5.getFilter()+"&sorting="+tab5.getSorting()+"&page="+tab5.getPage(),"","GET");
	}else if (grd=="gridbox"){
        a.loadURL("tindakan_utils.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
    }else if (grd=="gridbox2"){
        b.loadURL("tindakan_kls_utils.php?grd=true&tindId="+document.getElementById('txtId').value+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage(),"","GET");
    } else if (grd=="gridboxtindakan"){
		tindA.loadURL("tindakan_ak_utils.php?grd=1&pendapatan="+document.getElementById('pendapatan').value+"&filter="+tindA.getFilter()+"&sorting="+tindA.getSorting()+"&page="+tindA.getPage(),"","GET");
	} else if (grd=="gridboxtindakanak"){
		tindAK.loadURL("tindakan_ak_utils.php?grd=2&pendapatan="+document.getElementById('pendapatan').value+"&filter="+tindAK.getFilter()+"&sorting="+tindAK.getSorting()+"&page="+tindAK.getPage(),"","GET");
	}else if(grd == "grdKelompokTindakanMcu"){
		ktmcu.loadURL("kelompok_mcu_utils.php?grd=dataTindakan&filter="+ktmcu.getFilter()+"&sorting="+ktmcu.getSorting()+"&page="+ktmcu.getPage()+"&idKelompokMcu="+document.getElementById('idKelompokMcu').value+"&unitId="+document.getElementById('cmbUnitKelMcu').value,"","GET");
	}
}

function cek_all(a){
	if(a=='chk_b'){
		if(document.getElementById(a).checked){
			for(var i=0;i<tindA.obj.childNodes[0].rows.length;i++){	
				tindA.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = true;		
			}
		}
		else{
			for(var i=0;i<tindA.obj.childNodes[0].rows.length;i++){	
				tindA.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = false;		
			}
		}
	}
	else if(a=='chk_c'){
		if(document.getElementById(a).checked){
			for(var i=0;i<tindAK.obj.childNodes[0].rows.length;i++){	
				tindAK.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = true;		
			}
		}
		else{
			for(var i=0;i<tindAK.obj.childNodes[0].rows.length;i++){	
				tindAK.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = false;		
			}
		}
	}else if(a == 'chk_ktmcu'){
		if(document.getElementById(a).checked){
			for(var i=0;i<tindAK.obj.childNodes[0].rows.length;i++){	
				tindAK.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = true;		
			}
		}
		else{
			for(var i=0;i<tindAK.obj.childNodes[0].rows.length;i++){	
				tindAK.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked = false;		
			}
		}
	}
}

function loadGridAK(ini){
	tindAK.loadURL("tindakan_ak_utils.php?grd=2&pendapatan="+ini.value ,"","GET");
}

function showgrid()
{
	isiCombo('TmpLayanan',document.getElementById('cmbJnsLayKelMcu').value,'','cmbUnitKelMcu',ubahUnit)

	ktmcu = new DSGridObject("grdKelompokTindakanMcu");
	ktmcu.setHeader("DATA TINDAKAN");	
	ktmcu.setColHeader("<input type='checkbox' id='chk_ktmcu' onchange='cek_all(this.id)' />,Nama Tindakan,Nama Penjamin,Kelas,Tarif,Kelompok,Klasifikasi");
	ktmcu.setIDColHeader(",tindakan,nama_penjamin,kelas,tarip,kelompok,klasifikasi");
	ktmcu.setColWidth("20,250,150,100,100,100,100");
	ktmcu.setCellAlign("left,left,left,center,right,center,center");
	ktmcu.setCellType("chk,txt,txt,txt,txt,txt,txt");
	ktmcu.setCellHeight(20);
	ktmcu.setImgPath("../icon");
	ktmcu.setIDPaging("pagingGrdKelompokTindakanMcu");
	//ktmcu.attachEvent("onRowClick","ambilTindakanKelas");	
	ktmcu.baseURL("kelompok_mcu_utils.php?grd=dataTindakan&unitId="+document.getElementById('cmbUnitKelMcu').value);
	ktmcu.Init();

	tmpt=new DSGridObject("gridboxTempatLayanan");
    tmpt.setHeader("UNIT PELAYANAN");
    tmpt.setColHeader(",KODE,NAMA,JENIS LAYANAN,STATUS INAP");
    tmpt.setIDColHeader(",kode,nama,,");
    tmpt.setColWidth("50,100,300,250,100");
    tmpt.setCellAlign("center,center,left,center,center");
    tmpt.setCellHeight(20);
    tmpt.setImgPath("../icon");
    tmpt.setIDPaging("pagingTempatLayanan");
    //tmpt.attachEvent("onRowClick","ambilData");
    //tmpt.onLoaded(konfirmasi);

	ktmcu2 = new DSGridObject("grdKelompokTindakanMcuKanan");
	ktmcu2.setHeader("DATA TINDAKAN");	
	ktmcu2.setColHeader("<input type='checkbox' id='chk_ktmcu2' onchange='cek_all(this.id)' />,Nama Tindakan,Nama Penjamin,Kelas,Tarif,Kelompok,Klasifikasi");
	ktmcu2.setIDColHeader(",tindakan,nama_penjamin,kelas,tarip,kelompok,klasifikasi");
	ktmcu2.setColWidth("20,250,150,100,100,100,100");
	ktmcu2.setCellAlign("left,left,left,center,right,center,center");
	ktmcu2.setCellType("chk,txt,txt,txt,txt,txt,txt");
	ktmcu2.setCellHeight(20);
	ktmcu2.setImgPath("../icon");
	ktmcu2.setIDPaging("pagingGrdKelompokTindakanMcuKanan");
	//ktmcu2.attachEvent("onRowClick","ambilTindakanKelas");	
	ktmcu2.baseURL("kelompok_mcu_utils.php?grd=kelompokTindakanMcu&unitId="+document.getElementById('cmbUnitKelMcu').value);
	ktmcu2.Init();

	kmcu = new DSGridObject('gridBoxMcuKelompok');
	kmcu.setHeader("DATA KELOMPOK MCU");
	kmcu.setColHeader("NO,NAMA KELOMPOK,AKTIF");
	kmcu.setIDColHeader(",nama_kelompok,");
	kmcu.setColWidth("20,250,100");
	kmcu.setCellAlign("right,left,center");
	kmcu.setCellType("txt,txt,txt");
	kmcu.setImgPath("../icon");
	kmcu.setIDPaging("pagingMcuKelompok");
	kmcu.attachEvent("onRowClick","ambilDataKelompokMcu");
	kmcu.baseURL("kelompok_mcu_utils.php?grd=kelompokMcu");
	kmcu.Init();

	tindA=new DSGridObject("gridboxtindakan");
	tindA.setHeader("DATA TINDAKAN");	
	tindA.setColHeader("<input type='checkbox' id='chk_b' onchange='cek_all(this.id)' />,Nama Tindakan,Kelompok,Klasifikasi");
	tindA.setIDColHeader(",tindakan,kelompok,klasifikasi");
	tindA.setColWidth("20,250,150,100");
	tindA.setCellAlign("left,left,center,center");
	tindA.setCellType("chk,txt,txt,txt");
	tindA.setCellHeight(20);
	tindA.setImgPath("../icon");
	tindA.setIDPaging("pagingtindakan");
	tindA.baseURL("tindakan_ak_utils.php?grd=1&pendapatan="+document.getElementById('pendapatan').value);
	tindA.Init();
	
	tindAK=new DSGridObject("gridboxtindakanak");
	tindAK.setHeader("DATA KELOMPOK PENDAPATAN TINDAKAN");	
	tindAK.setColHeader("<input type='checkbox' id='chk_c' onchange='cek_all(this.id)' />,Nama Tindakan,Kelompok,Klasifikasi");
	tindAK.setIDColHeader(",tindakan,kelompok,klasifikasi");
	tindAK.setColWidth("20,250,150,100");
	tindAK.setCellAlign("left,left,center,center");
	tindAK.setCellType("chk,txt,txt,txt");
	tindAK.setCellHeight(20);
	tindAK.setImgPath("../icon");
	tindAK.setIDPaging("pagingtindakanak");
	tindAK.baseURL("tindakan_ak_utils.php?grd=2&pendapatan="+document.getElementById('pendapatan').value);
	tindAK.Init();
	
	tab1=new DSGridObject("gridboxtab1");
	tab1.setHeader("MASTER TINDAKAN ICD 9 CM");	
	tab1.setColHeader("NO,KODE,NAMA,INDUK");
	tab1.setIDColHeader(",m.code,m.str,");
	tab1.setColWidth("50,80,400,200");
	tab1.setCellAlign("center,center,left,left");
	tab1.setCellHeight(20);
	tab1.setImgPath("../icon");
	tab1.setIDPaging("pagingtab1");
	tab1.attachEvent("onRowClick","ambilData1");
	tab1.baseURL("tininacbg_utils.php?grd=true");
	tab1.Init();
	
	 a=new DSGridObject("gridbox");
     a.setHeader("DATA TINDAKAN");
     a.setColHeader("NO,KODE,TINDAKAN,KLASIFIKASI,KELOMPOK,STATUS AKTIF,KODE ICD9CM");
     a.setIDColHeader(",kode,nama,klasifikasi,kelompok,,");
     a.setColWidth("40,75,450,100,150,75,75");
     a.setCellAlign("center,center,left,center,center,center,center");
     a.setCellHeight(20);
     a.setImgPath("../icon");
     a.setIDPaging("paging");
     a.attachEvent("onRowClick","ambilData");
     a.baseURL("tindakan_utils.php?grd=true");
     a.Init();

     b=new DSGridObject("gridbox2");
     b.setHeader("DATA TINDAKAN KELAS");
     b.setColHeader("NO,PENJAMIN,TINDAKAN,KELAS,TARIF,STATUS AKTIF,MANUAL AKTIF");
     b.setIDColHeader(",nama_penjamin,tind,kls,,,");
     b.setColWidth("30,200,300,100,80,75,75");
     b.setCellAlign("center,left,left,center,right,center,center");
     //,TARIF ASKES,80,right
     b.setCellHeight(20);
     b.setImgPath("../icon");
     b.setIDPaging("paging2");
     b.attachEvent("onRowClick","ambilDataKelas");
     //b.onLoaded(ambilDataKelas);
     b.baseURL("tindakan_kls_utils.php?grd=true&tindId=0");
     b.Init();
	 
	 gRA=new DSGridObject("gbRA");
	gRA.setHeader("DAFTAR KLASIFIKASI");
	gRA.setColHeader("NO,KODE,NAMA,STATUS");
	gRA.setIDColHeader(",kode,nama,");
	gRA.setColWidth("30,50,150,80");
	gRA.setCellAlign("center,left,left,left");
	gRA.setCellHeight(20);
	gRA.setImgPath("../icon");
	gRA.setIDPaging("pgRA");
	gRA.attachEvent("onRowClick","ambilRA");
	gRA.baseURL("klasifikasi_util.php");
	gRA.Init();
	
	gRB=new DSGridObject("gbRB");
	gRB.setHeader("DAFTAR KELOMPOK TINDAKAN");
	gRB.setColHeader("NO,KLASIFIKASI,KODE,NAMA,STATUS");
	gRB.setIDColHeader(",,kode,nama,");
	gRB.setColWidth("30,100,100,150,80");
	gRB.setCellAlign("center,left,left,left,left");
	gRB.setCellHeight(20);
	gRB.setImgPath("../icon");
	gRB.setIDPaging("pgRB");
	gRB.attachEvent("onRowClick","ambilRB");
	gRB.baseURL("kelompok_util.php?klasifikasi="+document.getElementById("klasi").value);
	gRB.Init();
	/*tab2=new DSGridObject("gridboxtab2");
	tab2.setHeader("NORMAL HASIL LABORATORIUM");	
	tab2.setColHeader("NO,NAMA PEMERIKSAAN,JENIS KELAMIN,NORMAL,METODE");
	tab2.setIDColHeader(",nama,normal,satuan,metode");
	tab2.setColWidth("50,250,100,150,100");
	tab2.setCellAlign("center,left,center,center,left");
	tab2.setCellHeight(20);
	tab2.setImgPath("../icon");
	tab2.setIDPaging("pagingtab2");
	tab2.attachEvent("onRowClick","ambilDataTrf");
	tab2.baseURL("labSatuan_utils.php?grd1=true");
	tab2.Init();*/
	
	/*tab3=new DSGridObject("gridboxtab3");
	tab3.setHeader("MASTER KELOMPOK LABORATORIUM");	
	tab3.setColHeader("NO,KODE,NAMA KELOMPOK");
	tab3.setIDColHeader(",kode,nama");
	tab3.setColWidth("50,100,400");
	tab3.setCellAlign("center,center,left");
	tab3.setCellHeight(20);
	tab3.setImgPath("../icon");
	tab3.setIDPaging("pagingtab3");
	tab3.attachEvent("onRowClick","ambilDataKel");
	tab3.baseURL("labSatuan_utils.php?grd2=true");
	tab3.Init();*/
	
	
	/*tab4=new DSGridObject("gridboxtab4");
	tab4.setHeader("DATA PEMERIKSAAN LABORATORIUM");	
	tab4.setColHeader("NO,NAMA PEMERIKSAAN");
	tab4.setIDColHeader(",nama");
	tab4.setColWidth("50,400");
	tab4.setCellAlign("center,left");
	tab4.setCellHeight(20);
	tab4.setImgPath("../icon");
	tab4.setIDPaging("pagingtab4");
	tab4.attachEvent("onRowClick","ambilDataPem");
	tab4.baseURL("labSatuan_utils.php?grd3=true&kelId="+document.getElementById("kelIdlab").value);
	tab4.Init();*/
	
	//isiCombo('kelIdlab','','','',fill);
	 isiCombo('cmbKlasi');
        //isiCombo('cmbKelTin','1');
		//var aaa1 = document.getElementById('cmbKlasi').value;
	isiCombo('cmbKelTin','5');
	
	/*tab5=new DSGridObject("gridboxtab5");
	tab5.setHeader("MASTER PAKET LABORATORIUM");	
	tab5.setColHeader("NO,NAMA PAKET,STATUS AKTIF");
	tab5.setIDColHeader(",nama,");
	tab5.setColWidth("50,400,200");
	tab5.setCellAlign("center,left,center");
	tab5.setCellHeight(20);
	tab5.setImgPath("../icon");
	tab5.setIDPaging("pagingtab5");
	tab5.attachEvent("onRowClick","ambilDataPaket");
	tab5.baseURL("labSatuan_utils.php?grd4=true");
	tab5.Init();
	*/
	
}

//buang
	/*var actTree;
	function loadtree(p,act,par)
	{
		//alert(p);
		var a=p.split("*-*");
		if(act=='Tambah' || act=='Simpan' || act=='Hapus'){
			actTree=act;
			Request (a[0]+'act='+act+'&par='+par+a[3]+'&cnt='+a[4] , a[1], '', 'GET');
		}
		else{			
			Request (a[0]+'act='+act+'&par='+par+a[3]+'&cnt='+a[4] , a[1], '', 'GET');
		}
	}
*/
	/*function simpan(action,id,cek)
	{
		//alert(document.getElementById('btntree').value);
		if(ValidateForm(cek,'ind'))
		{
			var idSatuan = document.getElementById("idSatuan").value;
			var namaSatuan = document.getElementById("satuan").value;
			
			//var idPaket = document.getElementById("idPaket").value;
			//var paket = document.getElementById("paket").value;
			
			var idtind = document.getElementById("tindakan_id").value;
			var lp = document.getElementById("lp").value;
			var satuan = document.getElementById("satid").value;
			var nilai1 = document.getElementById("normal1").value;
			var nilai2 = document.getElementById("normal2").value;
			var idnormal = document.getElementById("id_normal").value;
			var metode = document.getElementById("metode").value;
			
			var kel = document.getElementById("kel").value;
			var idKel = document.getElementById("idKel").value;
			var kode = document.getElementById("kode").value;
			var kode_kel = document.getElementById("kode_kel").value;
			var level = document.getElementById("level").value;
			var parent = document.getElementById("parent").value;
			
			var kelIdlab = document.getElementById("kelIdlab").value;
			var txtTindPem = document.getElementById("txtTindPem").value;
			var idPem = document.getElementById("idPem").value;
			
			
			var aktifSatuan = 0;
			//var aktifPaket = 0;
			if(document.getElementById('aktifSatuan').checked==true)
			{
				aktifSatuan = 1;
			}
			//if(document.getElementById('akTifPaket').checked==true)
			//{
			//	aktifPaket = 1;
			//}
			
			//alert(id);
			switch(id)
			{	
				case 'btnSimpanKel':
					//alert(document.getElementById('btntree').value);
					if (document.getElementById('btntree').value=='View Tree'){
						tab3.loadURL("labSatuan_utils.php?grd2=true&act="+action+"&smpn="+id+"&id="+idKel+"&kel="+kel+"&kode="+kode+"&kode_kel="+kode_kel+"&parent="+parent+"&level="+level,"","GET");
					}else{
						tab3.loadURL("labSatuan_utils.php?grd2=true&act="+action+"&smpn="+id+"&id="+idKel+"&kel="+kel+"&kode="+kode+"&kode_kel="+kode_kel+"&parent="+parent+"&level="+level,"","GET");
						var par="&smpn="+id+"&id="+idKel+"&kel="+kel+"&kode="+kode+"&kode_kel="+kode_kel+"&parent="+parent+"&level="+level;
						loadtree(document.getElementById('txtSusun').value,action,par);
						//alert ("a");
					}
					//var p="idKel*-**|*kel*-**|*btnSimpanKel*-*Tambah*|*btnHapusKel*-*true";
					//fSetValue(window,p);
					batal('btnBatalKel');
					isiCombo('kelIdlab');
					break;
				case 'btnSimpan':
				//alert("labSatuan_utils.php?grd=true&act="+action+"&smpn="+id+"&id="+idSatuan+"&nama="+namaSatuan+"&aktif="+aktifSatuan);
				tab1.loadURL("labSatuan_utils.php?grd=true&act="+action+"&smpn="+id+"&id="+idSatuan+"&nama="+namaSatuan+"&aktif="+aktifSatuan,"","GET");
				var p="idSatuan*-**|*satuan*-**|*aktifSatuan*-*false*|*btnSimpan*-*Tambah*|*btnHapus*-*true";
				fSetValue(window,p);
				//batal();
				break;
				
				case 'btnSimpanPaket':
				//alert("labSatuan_utils.php?grd4=true&act="+action+"&smpn="+id+"&id="+idPaket+"&nama="+paket+"&aktif="+aktifPaket);
				tab5.loadURL("labSatuan_utils.php?grd4=true&act="+action+"&smpn="+id+"&id="+idPaket+"&nama="+paket+"&aktif="+aktifPaket,"","GET");
				var p="idPaket*-**|*paket*-**|*aktifPaket*-*false*|*btnSimpanPaket*-*Tambah*|*btnHapusPaket*-*true";
				fSetValue(window,p);
				//batal();
				break;
				
				case 'btnSimpanTrf':
				//alert("labSatuan_utils.php?grd1=true&act="+action+"&smpn="+id+"&id="+idnormal+"&metode="+metode+"&tindakan="+idtind+"&satuan="+satuan+"&lp="+lp+"&nilai1="+nilai1+"&nilai2="+nilai2);
				tab2.loadURL("labSatuan_utils.php?grd1=true&act="+action+"&smpn="+id+"&id="+idnormal+"&metode="+metode+"&tindakan="+idtind+"&satuan="+satuan+"&lp="+lp+"&nilai1="+nilai1+"&nilai2="+nilai2,"","GET");
				var idtind = document.getElementById("tindakan_id").value="";
				var lp = document.getElementById("lp").selectedIndex=0;
				var satuan = document.getElementById("satid").selectedIndex=0;
				var nilai1 = document.getElementById("normal1").value="";
				var nilai2 = document.getElementById("normal2").value="";
				var idnormal = document.getElementById("id_normal").value="";
				document.getElementById("txtTind").value="";
				var metode = document.getElementById("metode").value="";
				var p="btnSimpanTrf*-*Tambah*|*btnHapusTrf*-*true";	
				fSetValue(window,p);
				//batal();
				break;
				
				case 'btnSimpanPem':
					//alert("labSatuan_utils.php?grd3=true&act="+action+"&smpn="+id+"&id="+idPem+"&kelId="+kelIdlab+"&txtTindPem="+txtTindPem);
					tab4.loadURL("labSatuan_utils.php?grd3=true&act="+action+"&smpn="+id+"&id="+idPem+"&kelId="+kelIdlab+"&txtTindPem="+txtTindPem,"","GET");
					var p="txtTindPem*-**|*idPem*-**|*btnSimpanPem*-*Tambah*|*btnHapusPem*-*true";
					fSetValue(window,p);
				break;
			
			}
		}
	}*/

	/*function ambilData()
	{
		var p="idSatuan*-*"+(tab1.getRowId(tab1.getSelRow()))+"*|*satuan*-*"+tab1.cellsGetValue(tab1.getSelRow(),2)+"*|*aktifSatuan*-*"+((tab1.cellsGetValue(tab1.getSelRow(),3)=='Aktif')?'true':'false')+"*|*btnSimpan*-*Simpan*|*btnHapus*-*false";
		fSetValue(window,p);
	}*/
	
	/*function ambilDataKel(){
		var sisip=tab3.getRowId(tab3.getSelRow()).split("|");
		var p = "idKel*-*"+sisip[0]+"*|*parent*-*"+sisip[1]+"*|*kode*-*"+sisip[2]+"*|*kode_kel*-*"+tab3.cellsGetValue(tab3.getSelRow(),2)+"*|*kel*-*"+tab3.cellsGetValue(tab3.getSelRow(),3)+"*|*btnSimpanKel*-*Simpan*|*btnHapusKel*-*false";
		fSetValue(window,p);
	}
	
	function ambilDataPem(){
		var idx = tab4.getRowId(tab4.getSelRow());
		//alert(idx);
		var sp = idx.split("|");
		var p = "idPem*-*"+sp[0]+"*|*txtTindPem*-*"+sp[1]+"*|*btnSimpanPem*-*Simpan*|*btnHapusPem*-*false";
		fSetValue(window,p);
	}
	
	function ambilDataTrf()
	{
		var idx = tab2.getRowId(tab2.getSelRow());
		var sp = idx.split("|");
		var p="id_normal*-*"+sp[0]+"*|*tindakan_id*-*"+sp[1]+"*|*txtTind*-*"+sp[2]+"*|*lp*-*"+sp[3]+"*|*satid*-*"+sp[4]+"*|*normal1*-*"+sp[5]+"*|*normal2*-*"+sp[6]+"*|*metode*-*"+sp[7]+"*|*btnSimpanTrf*-*Simpan*|*btnHapusTrf*-*false";
		fSetValue(window,p);
	}
	
	
	function hapus(id)
	{
		var rowid = document.getElementById("idSatuan").value;
		//var rowidPaket = document.getElementById("idPaket").value;
		var rowidTrf = document.getElementById("id_normal").value; 
		var rowidKel = document.getElementById("idKel").value;  
		var rowidPem = document.getElementById("idPem").value;  
		
		switch(id)
		{
			case 'btnHapus':
			if(confirm("Anda yakin menghapus Satuan "+tab1.cellsGetValue(tab1.getSelRow(),2)))
			{
				tab1.loadURL("labSatuan_utils.php?grd=true&act=hapus&hps="+id+"&rowid="+rowid,"","GET");
			}
				document.getElementById("satuan").value = '';
				document.getElementById("idSatuan").value = '';
				document.getElementById('aktifSatuan').checked = false;
			var p="idSatuan*-**|*satuan*-**|*aktifSatuan*-*false*|*btnSimpan*-*Tambah*|*btnHapus*-*true";
			fSetValue(window,p);
				break;
			
			case 'btnHapusPaket':
			if(confirm("Anda yakin menghapus Paket "+tab5.cellsGetValue(tab5.getSelRow(),2)))
			{
				tab5.loadURL("labSatuan_utils.php?grd4=true&act=hapus&hps="+id+"&rowid="+rowidPaket,"","GET");
			}
				document.getElementById("paket").value = '';
				document.getElementById("idPaket").value = '';
				document.getElementById('aktifPaket').checked = false;
			var p="idPaket*-**|*paket*-**|*aktifPaket*-*false*|*btnSimpanPaket*-*Tambah*|*btnHapusPaket*-*true";
			fSetValue(window,p);
				break;
			
			case 'btnHapusTrf':
			if(confirm("Anda yakin menghapus Normal "+tab2.cellsGetValue(tab2.getSelRow(),2)))
			{
				tab2.loadURL("labSatuan_utils.php?grd1=true&act=hapus&hps="+id+"&rowid="+rowidTrf,"","GET");
			}
			var idtind = document.getElementById("tindakan_id").value="";
			var lp = document.getElementById("lp").selectedIndex=0;
			var satuan = document.getElementById("satid").selectedIndex=0;
			var nilai1 = document.getElementById("normal1").value="";
			var nilai2 = document.getElementById("normal2").value="";
			var idnormal = document.getElementById("id_normal").value="";
			var metode = document.getElementById("metode").value="";
			document.getElementById("txtTind").value="";
			var p="btnSimpanTrf*-*Tambah*|*btnHapusTrf*-*true";			
			break;
			
			case 'btnHapusKel':
				if(confirm("Anda yakin menghapus Kelompok "+tab3.cellsGetValue(tab3.getSelRow(),2)))
			{
				tab3.loadURL("labSatuan_utils.php?grd2=true&act=hapus&hps="+id+"&rowid="+rowidKel,"","GET");
			}
			var p="idKel*-**|*kel*-**|*kode_kel*-**|*kode*-**|*parent*-**|*btnSimpanKel*-*Tambah*|*btnHapusKel*-*true";
			fSetValue(window,p);
			isiCombo('kelIdlab');
			break;
			
			case 'btnHapusPem':
			if(confirm("Anda yakin menghapus data "+tab4.cellsGetValue(tab4.getSelRow(),2)))
			{
				tab4.loadURL("labSatuan_utils.php?grd3=true&act=hapus&hps="+id+"&rowid="+rowidPem+"&kelId="+document.getElementById("kelIdlab").value,"","GET");
			}
			batal('btnBatalPem');
			break;
		}
	}
	
	function fill(){
		var kelIdlab = document.getElementById("kelIdlab").value;
		tab4.loadURL("labSatuan_utils.php?grd3=true&kelId="+kelIdlab,"","GET");
		batal('btnBatalPem');
	}	
	
	function batal(id)
	{
		switch(id)
		{
			case 'btnBatal':
			var p="idSatuan*-**|*satuan*-**|*aktifSatuan*-*false*|*btnSimpan*-*Tambah*|*btnHapus*-*true";
			fSetValue(window,p);
			break;
			
			case 'btnBatalTrf':
				var idtind = document.getElementById("tindakan_id").value="";
				var lp = document.getElementById("lp").selectedIndex=0;
				var satuan = document.getElementById("satid").selectedIndex=0;
				var nilai1 = document.getElementById("normal1").value="";
				var nilai2 = document.getElementById("normal2").value="";
				var idnormal = document.getElementById("id_normal").value="";
				document.getElementById("txtTind").value="";
				document.getElementById("metode").value="";
				var p="btnSimpanTrf*-*Tambah*|*btnHapusTrf*-*true";
				fSetValue(window,p);
				break;
			case 'btnBatalKel':
				var p="idKel*-**|*kode_kel*-**|*kode*-**|*kel*-**|*level*-*0*|*btnSimpanKel*-*Tambah*|*btnHapusKel*-*true";
				fSetValue(window,p);
				break;
			case 'btnBatalPem':
				var p="txtTindPem*-**|*idPem*-**|*btnSimpanPem*-*Tambah*|*btnHapusPem*-*true";
				fSetValue(window,p);
			break;
			
		}	
	}*/
	
	/*var RowIdx1;
	var fKeyEnt1;
	function suggest1(e,par){
		var keywords=par.value;//alert(keywords);
		if(keywords=="" || keywords.length<2){
			document.getElementById('divtindakan').style.display='none';
		}else{
			var key;
			if(window.event) {
				key = window.event.keyCode;
			}
			else if(e.which) {
				key = e.which;
			}
			//alert(key);
			if (key==38 || key==40){
				var tblRow=document.getElementById('tblTindakan').rows.length;
				if (tblRow>0){
					//alert(RowIdx1);
					if (key==38 && RowIdx1>0){
						RowIdx1=RowIdx1-1;
						document.getElementById('lstTind'+(RowIdx1+1)).className='itemtableReq';
						if (RowIdx1>0) document.getElementById('lstTind'+RowIdx1).className='itemtableMOverReq';
					}
					else if (key == 40 && RowIdx1 < tblRow){
						RowIdx1=RowIdx1+1;
						if (RowIdx1>1) document.getElementById('lstTind'+(RowIdx1-1)).className='itemtableReq';
						document.getElementById('lstTind'+RowIdx1).className='itemtableMOverReq';
					}
				}
			}else if (key==13){
				//alert('masuk tindakan');
				if (RowIdx1>0){
					if (fKeyEnt1==false){
						fSetTindakan(document.getElementById('lstTind'+RowIdx1).lang);
					}
					else{
						fKeyEnt1=false;
					}
				}
			}else if (key!=27 && key!=37 && key!=39){
				RowIdx1=0;
				fKeyEnt1=false;
				var all=0;
				if(key==123){
					all=1;
				}
				//alert("tindakanlist.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&kelasId="+getIdKelas+"&unitId="+((document.getElementById('chkTind').checked==true)?document.getElementById('tmpLay').value:unitId));
				Request("tindakanlist.php?x=1&aKeyword="+keywords, 'divtindakan', '', 'GET');
				if (document.getElementById('divtindakan').style.display=='none')
					fSetPosisi(document.getElementById('divtindakan'),par);
				document.getElementById('divtindakan').style.display='block';
			}
		}
	}
	
	function suggest2(e,par){
		var keywords=par.value;//alert(keywords);
		if(keywords=="" || keywords.length<2){
			document.getElementById('divtindakan1').style.display='none';
		}else{
			var key;
			if(window.event) {
				key = window.event.keyCode;
			}
			else if(e.which) {
				key = e.which;
			}
			//alert(key);
			if (key==38 || key==40){
				var tblRow=document.getElementById('tblTindakan').rows.length;
				if (tblRow>0){
					//alert(RowIdx1);
					if (key==38 && RowIdx1>0){
						RowIdx1=RowIdx1-1;
						document.getElementById('lstTind'+(RowIdx1+1)).className='itemtableReq';
						if (RowIdx1>0) document.getElementById('lstTind'+RowIdx1).className='itemtableMOverReq';
					}
					else if (key == 40 && RowIdx1 < tblRow){
						RowIdx1=RowIdx1+1;
						if (RowIdx1>1) document.getElementById('lstTind'+(RowIdx1-1)).className='itemtableReq';
						document.getElementById('lstTind'+RowIdx1).className='itemtableMOverReq';
					}
				}
			}else if (key==13){
				//alert('masuk tindakan');
				if (RowIdx1>0){
					if (fKeyEnt1==false){
						fSetTindakan(document.getElementById('lstTind'+RowIdx1).lang);
					}
					else{
						fKeyEnt1=false;
					}
				}
			}else if (key!=27 && key!=37 && key!=39){
				RowIdx1=0;
				fKeyEnt1=false;
				var all=0;
				if(key==123){
					all=1;
				}
				//alert("tindakanlist.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&kelasId="+getIdKelas+"&unitId="+((document.getElementById('chkTind').checked==true)?document.getElementById('tmpLay').value:unitId));
				Request("tindakanlist.php?x=2&aKeyword="+keywords, 'divtindakan1', '', 'GET');
				if (document.getElementById('divtindakan1').style.display=='none')
					fSetPosisi(document.getElementById('divtindakan1'),par);
				document.getElementById('divtindakan1').style.display='block';
			}
		}
	}
	
	/*function fSetTindakan(value){
		var dt = value.split("|");
		document.getElementById("tindakan_id").value=dt[0];
		document.getElementById("txtTind").value=dt[1];
		document.getElementById("divtindakan").style.display="none";
	}
	function fSetTindakan1(value){
		var dt = value.split("|");
		document.getElementById("tindakan_idKel").value=dt[0];
		document.getElementById("txtTindKel").value=dt[1];
		document.getElementById("divtindakan1").style.display="none";
	}*/
	/*function tree12(a,id){
	if(a.value=="View Tree"){
		document.getElementById('gridboxtab3').style.display="none";
		document.getElementById('pagingtab3').style.display="none";
		document.getElementById('tree').style.display="block";
		a.value="View Table";
		//alert(id);
		//alert("tree");
	var idKel = document.getElementById("idKel").value;
	var kel = document.getElementById("kel").value;
	var kode = document.getElementById("kode").value;
	var kode_kel = document.getElementById("kode_kel").value;
	var level = document.getElementById("level").value;
	var parent = document.getElementById("parent").value;
		var par="&smpn="+id+"&id="+idKel+"&kel="+kel+"&kode="+kode+"&kode_kel="+kode_kel+"&parent="+parent+"&level="+level;
		var action="";
		loadtree(document.getElementById('txtSusun').value,action,par);
	}else{
		document.getElementById('gridboxtab3').style.display="block";
		document.getElementById('pagingtab3').style.display="block";
		document.getElementById('tree').style.display="none";
		a.value="View Tree";
	}
	}
	function upKode(){
		OpenWnd('kelLab_tree.php?par=kode*level*parent',800,500,'msma',true)
		//window.open("kelLab_tree.php?kode*level*parent");
	}
	function setValue(a){
		//alert(a);
		var x = a.split("|");
		document.getElementById("kode").value=x[0];
		document.getElementById("level").value=x[1];
		document.getElementById("parent").value=x[2];
	}*/

	/**
	 * @author ismul
	 * Kelompok Tindakan Mcu
	 */

	function ambilDataKelompokMcu() {
		let id = kmcu.getRowId(kmcu.getSelRow()).split("|");
		document.getElementById('deleteKelompokMcu').disabled = false;
		document.getElementById('idKelompokMcu').value = id[0];
		document.getElementById('nama_kelompok').value = id[1];
		if(id[2] == 1){
			document.getElementById('Kelompok_mcu_aktif').checked = true;
		}else{
			document.getElementById('Kelompok_mcu_aktif').checked = false;
		}
		document.getElementById('simpanKelompokMcu').innerHTML = 'Update';
		document.getElementById('simpanKelompokMcu').value = 'updateData';
		document.getElementById('deleteKelompokMcu').disabled = false;
	}

	function batalKelompokMcu(){
		document.getElementById('simpanKelompokMcu').innerHTML = 'Tambah';
		document.getElementById('simpanKelompokMcu').value = 'tambahKelompok';
		document.getElementById('deleteKelompokMcu').disabled = true;
		document.getElementById('formKelompokMcu').reset();
	}

	function refreshGridKelompokMcu(){
		let idKelompokMcu = document.getElementById('idKelompokMcu').value;
		kmcu.baseURL("kelompok_mcu_utils.php?grd=kelompokMcu&idKelompokMcu="+idKelompokMcu);
		kmcu.Init();
		tmpt.baseURL("kelompok_mcu_utils.php?grd=dataTempatLayanan&idKelompokMcu="+idKelompokMcu);
	    tmpt.Init();

	}

	function tampilKelompokMcuTindakan(){
		let idKelompokMcu = document.getElementById('idKelompokMcu').value; 
		document.getElementById('kelompokMcu').style.display = 'none';
		document.getElementById('kelompokTindakanMcu').style.display = 'block';
		ktmcu2.loadURL("kelompok_mcu_utils.php?grd=kelompokTindakanMcu&unitId="+document.getElementById('cmbUnitKelMcu').value+"&idKelompokMcu="+idKelompokMcu+"&user_id=<?php echo $user_id; ?>", "", "GET");
		ktmcu.loadURL("kelompok_mcu_utils.php?grd=dataTindakan&unitId="+document.getElementById('cmbUnitKelMcu').value+"&idKelompokMcu="+idKelompokMcu,"","GET");
		isiCombo('TmpLayanan',document.getElementById('cmbJnsLayKelMcu').value,'','cmbUnitKelMcu',ubahUnit);
		isiCombo('cmbDok',189,'<?php echo $user_id; ?>','cmbDokTind');
	}

	function tampilKonsulUnit(){
		let idKelompokMcu = document.getElementById('idKelompokMcu').value;
		document.getElementById('kelompokMcu').style.display = 'none';
		document.getElementById('kelompokTindakanMcu').style.display = 'none';
		document.getElementById('kelompokTempatLayanan').style.display = 'block';
		tmpt.baseURL("kelompok_mcu_utils.php?grd=dataTempatLayanan&idKelompokMcu="+idKelompokMcu);
	    tmpt.Init();
	}

	function kembaliAwal() {
		document.getElementById('kelompokMcu').style.display = 'block';
		document.getElementById('kelompokTindakanMcu').style.display = 'none';
		document.getElementById('kelompokTempatLayanan').style.display = 'none';
	}

	function saveData(val){
		let namaKelompok = document.getElementById('nama_kelompok').value;
		let aktif = document.getElementById('Kelompok_mcu_aktif').checked ? 1 : 0;
		let idKelompokMcu = document.getElementById('idKelompokMcu').value;
		if(namaKelompok == '') return alert('Harap isi nama kelompok!');
		jQuery.ajax({
			url:'kelompok_mcu_utils.php',
			method : 'post',
			data: {
				nama_kelompok : namaKelompok,
				aktif : aktif,
				idKelompokMcu : idKelompokMcu,
				act : val,
			},
			dataType : 'json',
			success:function(data){
				if(data.status == 1){
					alert('Berhasil memasukan data!');
					document.getElementById('formKelompokMcu').reset();
					refreshGridKelompokMcu();
					batalKelompokMcu();
				}else{
					alert('Gagal memasukan data!');
				}
			}
		});
	}

	function deleteData(){
		let id = document.getElementById('idKelompokMcu').value;
		if(confirm('Yakin ingin menghapius kelompok tindakan ' + document.getElementById('nama_kelompok').value + '?')){
			jQuery.ajax({
				url:'kelompok_mcu_utils.php',
				method:'post',
				data:{
					idKelompokMcu : id,
					act : 'deleteKelompok'
				},
				dataType:'json',
				success:function(data){
					if(data.status == 1){
						alert(data.msg);
						refreshGridKelompokMcu();
						batalKelompokMcu();
					}else{
						alert(data.msg);
					}
				}
			});
		}
	}

	function ubahUnit(){
		isiCombo('cmbDok',document.getElementById('cmbUnitKelMcu').value,'<?php echo $user_id; ?>','cmbDokTind');
		ktmcu.loadURL("kelompok_mcu_utils.php?grd=dataTindakan&unitId="+document.getElementById('cmbUnitKelMcu').value+"&idKelompokMcu="+document.getElementById('idKelompokMcu').value,"","GET");
		ktmcu2.loadURL("kelompok_mcu_utils.php?grd=kelompokTindakanMcu&unitId="+document.getElementById('cmbUnitKelMcu').value+"&idKelompokMcu="+document.getElementById('idKelompokMcu').value,"","GET");
	}

	function pindahKanan(){
		let idTin = '';
		let idKelompokMcu = document.getElementById('idKelompokMcu').value;
		let dokterPengganti = document.getElementById('chkDokterPenggantiTind').checked ? 1 : 0;
		let dokterId = document.getElementById('cmbDokTind').value;	
		for(var i=0;i<ktmcu.obj.childNodes[0].rows.length;i++){
			//alert(ktmcu.obj.childNodes[0].rows.length)
			if(ktmcu.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
				var getBaris=ktmcu.getRowId(parseInt(i)+1).split("|");
				var barisId=getBaris[0];
				//if(i != (ktmcu.obj.childNodes[0].rows.length-1)){
					idTin+=barisId+',';	
				//} else {
				//	idTin+=barisId;	
				//}
			}
		}
		//alert(idTin);		
		if(idTin==''){
			alert("Silakan pilih tindakan!");
		}
		else{
			var sisip=ktmcu.getRowId(ktmcu.getSelRow()).split("|");
			ktmcu2.loadURL("kelompok_mcu_utils.php?grd=kelompokTindakanMcu&act=tambahKelompokTindakan&idTindakanKelas="+idTin+"&unitId="+document.getElementById('cmbUnitKelMcu').value+"&idKelompokMcu="+idKelompokMcu+"&user_id=<?php echo $user_id; ?>"+"&dokterId="+dokterId+"&dokterPengganti="+dokterPengganti, "", "GET");
			ktmcu.loadURL("kelompok_mcu_utils.php?grd=dataTindakan&unitId="+document.getElementById('cmbUnitKelMcu').value+"&idKelompokMcu="+idKelompokMcu,"","GET");
			idTin='';
		}
	}

	function pindahKiri(){
		let idTin = '';	
		for(var i=0;i<ktmcu2.obj.childNodes[0].rows.length;i++){
			//alert(ktmcu.obj.childNodes[0].rows.length)
			if(ktmcu2.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
				var getBaris=ktmcu2.getRowId(parseInt(i)+1).split("|");
				var barisId=getBaris[0];
				//if(i != (ktmcu.obj.childNodes[0].rows.length-1)){
					idTin+=barisId+',';	
				//} else {
				//	idTin+=barisId;	
				//}
			}
		}
		//alert(idTin);		
		if(idTin==''){
			alert("Silakan pilih tindakan!");
		}
		else{
			var sisip=ktmcu2.getRowId(ktmcu2.getSelRow()).split("|");
			let idKelompokMcu = document.getElementById('idKelompokMcu').value; 
			ktmcu2.loadURL("kelompok_mcu_utils.php?grd=kelompokTindakanMcu&act=deleteKelompokTindakan&idTindakanKelas="+idTin+"&unitId="+document.getElementById('cmbUnitKelMcu').value+"&idKelompokMcu="+idKelompokMcu+"&user_id=<?php echo $user_id; ?>", "", "GET");
			idTin='';
		}
	}


	function gantiDokter(comboDokter,statusCek,disabel){
		if(statusCek==true){
			isiCombo('cmbDokPengganti',document.getElementById('cmbUnitKelMcu').value,'<?php echo $user_id; ?>','cmbDokTind');
		}
		else{
			isiCombo('cmbDok',document.getElementById('cmbUnitKelMcu').value,'<?php echo $user_id; ?>','cmbDokTind');
		}
		document.getElementById('chkDokterPenggantiRad').checked = statusCek;
	}

	function updateTempatLayanan(val){
		let idKelompokMcu = document.getElementById('idKelompokMcu').value;
		jQuery.ajax({
			url : 'kelompok_mcu_utils.php',
			method : 'post',
			data : {
				idKelompokMcu : idKelompokMcu,
				id_tempat_layanan : val,
				act : 'tambahTempatLayanan',
			},
			dataType : 'json',
			success:function(data){
				if(data.status == 1){
					alert(data.msg);
					refreshGridKelompokMcu();
					batalKelompokMcu();
				}else{
					alert(data.msg);
				}
			}
		});
	}

	// function setSemDokter(id1)
	// {
	// 	jQuery("#cmbDokDiag").val(id1);
	// 	// jQuery("#cmbDokTind").val(id1);
	// 	jQuery("#cmbDokRujukRS").val(id1);
	// 	jQuery("#cmbDokRujukUnit").val(id1);
	// 	jQuery("#cmbDokResep").val(id1);
	// 	jQuery("#cmbDokHsl").val(id1);
	// 	jQuery("#cmbDokHslRad").val(id1);
	// 	//alert(id1+"\n"+jQuery("#cmbDokTind").val(id1));
	// }
	
</script>

</html>
