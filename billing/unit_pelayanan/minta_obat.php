<?php 
// Koneksi =================================
include("../sesi.php"); 
include("../koneksi/konek.php");
//==========================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
$bulan=(int)$th[1];
$tgltrans1=$_REQUEST["tglminta"];
$tgltrans=explode("-",$tgltrans1);
$tglminta=$tgltrans[2]."-".$tgltrans[1]."-".$tgltrans[0];
$no_minta=$_REQUEST["no_minta"];
$no_minta_cetak=$no_minta;
$fdata=$_REQUEST["fdata"];
$idminta=$_REQUEST["idminta"];
$isview=$_REQUEST["isview"];
$iduser=$_SESSION['userId'];
$kodeunit = explode("/",$no_minta);
$kodeunit = $kodeunit[0];
$testDigit = (int)$tgltrans[1];
//======================Tanggalan==========================
$idgudang=$_SESSION["ses_id_gudang"];
$unit_tujuan=$_REQUEST["unit_tujuan"];
$kepemilikan_id=$_REQUEST["kpid"];
//if ($kepemilikan_id=="") $kepemilikan_id=$_SESSION["kepemilikan_id"];
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="UNIT_ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$idunit=$_REQUEST["cmbTmpLay"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

//echo $testDigit." tes saja";
//echo $_REQUEST["no_minta"]." tes aja >>".$no_minta_cetak;
if($idunit=="" && isset($_REQUEST['no_minta']) && $act!="save")
{
	$sql1="SELECT * FROM $dbapotek.a_minta_obat WHERE no_bukti = '".$_REQUEST['no_minta']."'";
	$rs1=mysql_query($sql1);
	$dq1=mysql_fetch_array($rs1);
	$idunit = $dq1['unit_id'];
}

if($idunit!="" && isset($_REQUEST['act']))
{
	$sql2="SELECT * FROM b_ms_unit WHERE id = $idunit";
	$rs2=mysql_query($sql2);
	$dq2=mysql_fetch_array($rs2);
	$namaunit = $dq2['nama'];
	
	$query3 = "SELECT unit_id FROM $dbapotek.a_unit WHERE unit_billing = $idunit";
	$rs3=mysql_query($query3);
	$dq3=mysql_fetch_array($rs3);
	$idunit = $dq3['unit_id'];
}

switch ($act){
	case "save":
		$sql="SELECT * FROM $dbapotek.a_minta_obat WHERE unit_id='$idunit' AND no_bukti='$no_minta' LIMIT 1";
		$rs=mysql_query($sql);
		
		if ($rows=mysql_fetch_array($rs)){
			$cusr=$rows["user_id"];
			if ($cusr==$iduser){
				//duplicate entry or refreshed
				echo "<script>alert('Permintaan Dgn No Tersebut Sudah Ada !');</script>";
			}else{
				//$sql="select * from a_minta_obat where unit_id=$idunit and month(tgl)=$bulan and year(tgl)=$th[2] order by permintaan_id desc limit 1";
				$sql="SELECT * FROM (SELECT * FROM $dbapotek.a_minta_obat WHERE unit_id=$idunit AND MONTH(tgl)=$bulan AND YEAR(tgl)=$th[2] AND no_bukti LIKE '".$kodeunit."/UP/".$th[2]."-".$testDigit."/%') AS t1 ORDER BY no_bukti DESC LIMIT 1";
				$rs1=mysql_query($sql);
				if ($rows1=mysql_fetch_array($rs1)){
					$no_minta=$rows1["no_bukti"];
					$ctmp=explode("/",$no_minta);
					$dtmp=$ctmp[3]+1;
					$ctmp=$dtmp;
					for ($i=0;$i<(4-strlen($dtmp));$i++) $ctmp="0".$ctmp;
					$no_minta="$kodeunit/UP/$th[2]-".$testDigit."/$ctmp";
				}else{
					$no_minta="$kodeunit/UP/$th[2]-".$testDigit."/0001";
				}
				$no_minta_cetak=$no_minta;
				//echo $fdata."tes";
				$arfdata=explode("**",$fdata);
				for ($i=0;$i<count($arfdata);$i++){
					$arfvalue=explode("|",$arfdata[$i]);
					$sql="insert into $dbapotek.a_minta_obat(unit_id,unit_tujuan,user_id,no_bukti,obat_id,kepemilikan_id,qty,qty_terima,tgl,tgl_act,status) values('$idunit','$unit_tujuan','$iduser','$no_minta','$arfvalue[0]','$kepemilikan_id','$arfvalue[1]','0','$tglminta','$tglact',0)";
					//echo $sql."<br>";
					$rs=mysql_query($sql);
				}
			}
		}else{
			$arfdata=explode("**",$fdata);
			for ($i=0;$i<count($arfdata);$i++){
				$arfvalue=explode("|",$arfdata[$i]);
				$sql="insert into $dbapotek.a_minta_obat(unit_id,unit_tujuan,user_id,no_bukti,obat_id,kepemilikan_id,qty,qty_terima,tgl,tgl_act,status) values('$idunit','$unit_tujuan','$iduser','$no_minta',$arfvalue[0],'$kepemilikan_id','$arfvalue[1]','0','$tglminta','$tglact',0)";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				if($rs == FALSE){
				echo mysql_error();
				}
			}
		}
		/*echo "<script>location='?f=list_minta_obat.php'</script>";*/
		//header("Location: ?f=list_minta_obat.php");
		break;
/* 	case "edit":
		$sql="update a_unit set UNIT_NAME='$unit_name',UNIT_TIPE='$unit_tipe',UNIT_ISAKTIF=$unit_isaktif where UNIT_ID=$unit_id";
		//echo $sql;
		$rs=mysql_query($sql);
		break;
*/
	case "delete":
		$sql="select ID from $dbapotek.a_penerimaan where FK_MINTA_ID=$idminta and UNIT_ID_TERIMA=$idunit and TIPE_TRANS=1";
		$rs=mysql_query($sql);
		if ($rows=mysql_fetch_array($rs)){
			echo "<script>alert('Data Tdk Boleh Dihapus Karena Permintaan Obat Tersebut Sudah Dikirim !');</script>";
		}else{
			$sql="delete from $dbapotek.a_minta_obat where permintaan_id=$idminta";
			$rs1=mysql_query($sql);
			//echo $sql;
		}
		break;
}
/*
$qry="select * from a_kepemilikan where AKTIF=1";
$exe=mysql_query($qry);
$sela="";
$i=0;
while($show=mysql_fetch_array($exe)){
	$sela .="sel.options[$i] = new Option('".$show['NAMA']."', '".$show['ID']."');";
	$i++;
}
*/
//Aksi Save, Edit, Delete Berakhir ====================================
// cek no_permintaan
//$sql="select * from a_minta_obat where unit_id=$idunit and month(tgl)=$bulan and year(tgl)=$th[2] order by permintaan_id desc limit 1";
$sql="SELECT * FROM (SELECT * FROM $dbapotek.a_minta_obat WHERE unit_id=122 AND MONTH(tgl)=$bulan AND YEAR(tgl)=$th[2] AND no_bukti LIKE '$kodeunit/UP/$th[2]-$th[1]/%') AS t1 ORDER BY no_bukti DESC LIMIT 1";
//echo $sql."<br>";
$rs1=mysql_query($sql);
if ($rows1=mysql_fetch_array($rs1)){
	$no_minta=$rows1["no_bukti"];
	$ctmp=explode("/",$no_minta);
	$dtmp=$ctmp[3]+1;
	$ctmp=$dtmp;
	for ($i=0;$i<(4-strlen($dtmp));$i++) $ctmp="0".$ctmp;
	//$no_minta="$kodeunit/UP/$th[2]-$th[1]/$ctmp";
}else{
	//$no_minta="$kodeunit/UP/$th[2]-$th[1]/0001";
}
//echo $no_minta."<br>";
//mysql_free_result($rs1);
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<link rel="stylesheet" href="apotik.css" type="text/css" />
<style>
.tblheader, .tblheaderkiri{
background: url(../images/images/nav-bg.png) repeat-x scroll 0 0 transparent;
}
</style>
<script language="JavaScript" type="text/JavaScript">
<!--
/*function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
*/
var RowIdx;
var fKeyEnt;
function evLang(){
			//alert(jQuery("#cmbTmpLay").val()+"\n"+<? echo $th[2];?>+"\n"+<? echo $th[1];?>+"\n"+<? echo $bulan;?>);

			jQuery("#load1").load("getMinta.php?idunit="+jQuery("#cmbTmpLay").val()+"&th2="+<? echo $th[2];?>+"&th1="+<? echo $th[1];?>+"&bulan="+<? echo $bulan;?>);
			//alert(document.getElementById('cmbTmpLay').value);
            //document.getElementById('cmbTmpLay').lang=document.getElementById('cmbTmpLay').value;
            //alert(document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang);
            inap=document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang;
            //alert(inap);
			/*========= tambahan tarik aktif jika Kamar Jenazah & Ambulan ===========*/
			if (document.getElementById('cmbTmpLay').value==122 || document.getElementById('cmbTmpLay').value==123 || document.getElementById('cmbJnsLay').value==57){
				document.getElementById('btnFilter').style.display = 'inline-table';
			}else{
				document.getElementById('btnFilter').style.display = 'none';
			}
			/*========= tambahan tarik aktif jika Kamar Jenazah & Ambulan ===========*/
            txtTgl=document.getElementById('txtTgl').value;
            cmbTmpLay=document.getElementById('cmbTmpLay').value;
            cmbDilayani=document.getElementById('cmbDilayani').value;
            cekInap(inap);
		if(inap == 1){
			document.getElementById('cmbDilayani').innerHTML = "<option value='0' selected='selected'>BELUM</option><option value='1'>SUDAH</option><option value=''>SEMUA</option><option value='-1'>SUDAH KELUAR</option>";
		}else{
			document.getElementById('cmbDilayani').innerHTML = "<option value='0' selected='selected'>BELUM</option><option value='1'>SUDAH</option><option value=''>SEMUA</option>";
		}

            //document.getElementById('cmbTmpLay').lang=document.getElementById('cmbTmpLay').value;
            //alert(document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang);
            unitId=document.getElementById('cmbTmpLay').value;
            jenisUnitId=document.getElementById('cmbJnsLay').value;
			
            //unitId=document.getElementById('cmbTmpLay').value;
            jenisUnitId=document.getElementById('cmbJnsLay').value;
            showGrid();
            isiCombo('cmbDok',unitId,'','cmbDokRujukUnit');
            isiCombo('cmbRS');
            isiCombo('cmbDok',unitId,'','cmbDokRujukRS');
            if(document.getElementById('cmbJnsLay').options[document.getElementById('cmbJnsLay').options.selectedIndex].lang=='1'){
                isiCombo('cmbCaraKeluar','','','cmbCaraKeluar',gantiCaraKeluar);
            }
            else{
                isiCombo('cmbCaraKeluar','APS','','cmbCaraKeluar',gantiCaraKeluar);
            }
			isiCombo('cmbIsiDataRM',document.getElementById('cmbTmpLay').value,'','cmbIsiDataRM',evCmbDataRM);
			cekLab(document.getElementById('cmbJnsLay').value);
        }

function suggest(e,par){
var keywords=par.value;//alert(keywords);
	//alert(par.offsetLeft);
  //alert(par.value);
  //var id = par.id;
 //alert(document.getElementById(id).style.left);
  var tbl = document.getElementById('tblJual');
  var jmlRow = tbl.rows.length;
  var i;
  if (jmlRow > 4){
  	i=par.parentNode.parentNode.rowIndex-2;
  }else{
  	i=0;	
  }
  //alert(jmlRow+'-'+i);
	if(keywords==""){
		document.getElementById('divobat').style.display='none';
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
			var tblRow=document.getElementById('tblObat').rows.length;
			if (tblRow>0){
				//alert(RowIdx);
				if (key==38 && RowIdx>0){
					RowIdx=RowIdx-1;
					document.getElementById(RowIdx+1).className='itemtableReq';
					if (RowIdx>0) document.getElementById(RowIdx).className='itemtableMOverReq';
				}else if (key==40 && RowIdx<tblRow){
					RowIdx=RowIdx+1;
					if (RowIdx>1) document.getElementById(RowIdx-1).className='itemtableReq';
					document.getElementById(RowIdx).className='itemtableMOverReq';
				}
			}
		}else if (key==13){
			if (RowIdx>0){
				if (fKeyEnt==false){
					fSetObat(document.getElementById(RowIdx).lang);
				}else{
					fKeyEnt=false;
				}
			}
		}else if (key!=27 && key!=37 && key!=39){
			RowIdx=0;
			fKeyEnt=false;
			Request('obatlist_minta.php?aKeyword='+keywords+'&idunit='+document.forms[0].unit_tujuan.value+'&aKepemilikan='+document.forms[0].kpid.value+'&no='+i , 'divobat', '', 'GET' );
			if (document.getElementById('divobat').style.display=='none') fSetPosisi_apotek(document.getElementById('divobat'),par);
			document.getElementById('divobat').style.display='block';
		}
	}
}

function isiCombo1(id,val,defaultId,targetId,evloaded){
	//alert(id+"-1 \n"+val+"-2 \n"+defaultId+"-3 \n"+targetId+"-4 \n"+evloaded);

            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            if(document.getElementById(targetId)==undefined){
                alert('Elemen target dengan id: \''+targetId+'\' tidak ditemukan!');
            }else{
                Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
            }
}

function cekLab(a){
		if(a==57){
			/*mTab.setTabCaption2("DIAGNOSA,TINDAKAN,RESEP,PEMAKAIAN BHP,HASIL LAB");
			//mTab.setTabPage("diagnosa.php,tindakan.php,resep.php,pemakaian_bhp.php,laborat.php");
			mTab.setTabDisplay("true,true,true,true,true,3");
			document.getElementById('tab_laborat').style.display='block';
			document.getElementById('tab_radiologi').style.display='none';*/
		}
		else if(a==60){
			/*mTab.setTabCaption2("DIAGNOSA,TINDAKAN,RESEP,PEMAKAIAN BHP,HASIL RADIOLOGI");
			//mTab.setTabPage("diagnosa.php,tindakan.php,resep.php,pemakaian_bhp.php,radiologi.php");
			mTab.setTabDisplay("true,true,true,true,true,3");
			document.getElementById('tab_radiologi').style.display='block';
			document.getElementById('tab_laborat').style.display='none';*/
		}
		else{
			//mTab.setTabDisplay("true,true,true,true,false,0");
			//document.getElementById('tab_laborat').style.display='none';
			//document.getElementById('tab_radiologi').style.display='none';
		}
	}

function cekInap(label){
            //alert(label);
            if(label=='1'){
                /*document.getElementById('trTgl').style.visibility='collapse';
                document.getElementById('trDilayani').style.visibility='visible';
                document.getElementById('btnSetKamar').style.display='inline';
                document.getElementById('btnMRS').disabled=true;
                document.getElementById('btnVer').style.display='inline';
				document.getElementById('btnDarah').style.display='inline';
                document.getElementById('btnRujukRS').disabled=false;*/
            }
            else{
                /*document.getElementById('trTgl').style.visibility='visible';
                document.getElementById('trDilayani').style.visibility='visible';
                document.getElementById('btnSetKamar').style.display='none';
                document.getElementById('btnMRS').disabled=false;
                document.getElementById('btnVer').style.display='none';
				document.getElementById('btnDarah').style.display='none';
                document.getElementById('btnRujukRS').disabled=false;*/
            }
        }
		
function evLang2(){
			jQuery("#load1").load("getMinta.php?idunit="+jQuery("#cmbTmpLay").val()+"&th2="+<? echo $th[2];?>+"&th1="+<? echo $th[1];?>+"&bulan="+<? echo $bulan;?>);
			var selCmbDilayani=0;
			if (document.getElementById('cmbDilayani')) selCmbDilayani=document.getElementById('cmbDilayani').options.selectedIndex;
			if (selCmbDilayani>2) selCmbDilayani=0;
	    	//tentangTarik();
			/*========= tambahan tarik aktif jika Kamar Jenazah & Ambulan ===========*/
			if (document.getElementById('cmbTmpLay').value==122 || document.getElementById('cmbTmpLay').value==123 || document.getElementById('cmbJnsLay').value==57){
				document.getElementById('btnFilter').style.display = 'inline-table';
			}else{
				document.getElementById('btnFilter').style.display = 'none';
			}
			/*========= tambahan tarik aktif jika Kamar Jenazah & Ambulan ===========*/
            inap=document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang;
			//alert(inap);
			if(inap == 1){
				document.getElementById('btnMRS').style.display = 'none';
				document.getElementById('UpdStatusPx').style.display = 'inline-table';
				document.getElementById('cmbDilayani').innerHTML = "<option value='0' selected='selected'>BELUM</option><option value='1'>SUDAH</option><option value=''>SEMUA</option><option value='-1'>SUDAH KELUAR</option>";
			}
			else{
				document.getElementById('btnMRS').style.display = 'inline-table';
				if (document.getElementById('cmbJnsLay').value==44){
					document.getElementById('UpdStatusPx').style.display = 'inline-table';
				}else{
					document.getElementById('UpdStatusPx').style.display = 'none';
				}
				document.getElementById('cmbDilayani').innerHTML = "<option value='0' selected='selected'>BELUM</option><option value='1'>SUDAH</option><option value=''>SEMUA</option>";
			}
			//alert(selCmbDilayani);
			document.getElementById('cmbDilayani').options.selectedIndex=selCmbDilayani;
			if('<?php echo isset($_POST['sentPar'])?>' == 0){
				document.getElementById('txtFilter').value = "";
			}
			else if('<?php echo isset($_POST['sentPar'])?>' == 1){
				var sentPar = "<?php echo $_POST['sentPar']?>".split('*|*');
				document.getElementById('cmbDilayani').value = sentPar[4];
			}
            txtTgl=document.getElementById('txtTgl').value;
            cmbTmpLay=document.getElementById('cmbTmpLay').value;
            cmbDilayani=document.getElementById('cmbDilayani').value;
            //document.getElementById('cmbTmpLay').lang=document.getElementById('cmbTmpLay').value;
            //alert(document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang);
            unitId=document.getElementById('cmbTmpLay').value;
            jenisUnitId=document.getElementById('cmbJnsLay').value;
            cekInap(inap);
            saring();
            isiCombo('cmbDok',unitId,'','cmbDokRujukUnit');
            isiCombo('cmbRS');
            isiCombo('cmbDok',unitId,'','cmbDokRujukRS');
            if(document.getElementById('cmbJnsLay').options[document.getElementById('cmbJnsLay').options.selectedIndex].lang=='1'){
                isiCombo('cmbCaraKeluar','','','cmbCaraKeluar',gantiCaraKeluar);
            }
            else{
                isiCombo('cmbCaraKeluar','APS','','cmbCaraKeluar',gantiCaraKeluar);
            }
            isiCombo('cmbDok',unitId,'','cmbDokTind');
            isiCombo('cmbDok',unitId,'','cmbDokDiag');
            isiCombo('cmbDok',unitId,'','cmbDokResep');
			
			/*
			if(jenisUnitId==27){
			}
			*/
        }

function fSubmit(){
var cdata='';
var ctemp;
//	alert(document.forms[0].fdata.value);
	if (document.forms[0].no_minta.value==""){
		alert('Isikan No Permintaan Terlebih Dahulu !');
		document.forms[0].no_minta.focus();
		return false;		
	}
	if (document.forms[0].obatid.length){
		for (var i=0;i<document.forms[0].obatid.length;i++){
			ctemp=document.forms[0].obatid[i].value;
/*			if ((ctemp[1]*1)<(document.forms[0].txtJml[i].value*1)){
				document.forms[0].txtObat[i].focus();
				alert('Stok Obat Kurang !');
				return false;
			}
*/
			if (document.forms[0].obatid[i].value==""){
				alert('Pilih Obat Terlebih Dahulu !');
				document.forms[0].txtObat[i].focus();
				return false;		
			}			
			cdata +=ctemp+'|'+document.forms[0].txtJml[i].value+'**';
		}
		if (cdata!='') cdata=cdata.substr(0,cdata.length-2);
/*		for (var i=0;i<document.forms[0].obatid.length-1;i++){
			for (var j=i+1;j<document.forms[0].obatid.length-1;j++){
				
			}
			//alert(document.forms[0].obatid[i].value+'-'+document.forms[0].txtJml[i].value+'-'+document.forms[0].txtHarga[i].value);		
		}
*/
	}else{
		if (document.forms[0].obatid.value==""){
			alert('Pilih Obat Terlebih Dahulu !');
			document.forms[0].txtObat.focus();
			return false;		
		}
		ctemp=document.forms[0].obatid.value;
/*		if ((ctemp[1]*1)<(document.forms[0].txtJml.value*1)){
			document.forms[0].txtObat.focus();
			alert('Stok Obat Kurang !');
			return false;
		}
*/
		cdata=ctemp+'|'+document.forms[0].txtJml.value;
	}
	//alert(cdata);
	document.forms[0].fdata.value=cdata;
	//alert(document.forms[0].fdata.value+"-"+document.forms[0].act.value+"-"+document.forms[0].unit_tujuan.value);
	document.getElementById('btnSimpan').disabled=true;
	//alert(document.getElementById("no_minta").value);
	document.forms[0].submit();
}

function fSetBatalFr(){
  var tbl = document.getElementById('tblJual');
  var jmlRow = tbl.rows.length;
  //alert(jmlRow);
  if (jmlRow > 4){
	  for (var i=jmlRow;i>4;i--){
		tbl.deleteRow(i-1);
	  }
  }
	document.form1.txtObat.focus();
}

function HitungSubTot(par){
//var tbl = document.getElementById('tblJual');
var i=par.parentNode.parentNode.rowIndex;
	//alert(i);
	if (i==3){
		document.form1.txtSubTot.value=(document.form1.txtHarga.value*1)*(document.form1.txtJml.value*1);
	}else{
		document.form1.txtSubTot[i-3].value=(document.form1.txtHarga[i-3].value*1)*(document.form1.txtJml[i-3].value*1);
	}
	HitungTot();
}

function HitungTot(){
	if (document.form1.txtSubTot.length){
		var cStot=0;
		for (var i=0;i<document.form1.txtSubTot.length;i++){
			//alert(document.form1.txtSubTot[i].value);
			cStot +=(document.form1.txtSubTot[i].value*1);
		}
		document.form1.subtotal.value=cStot;
		//alert(cStot);
	}else{
		document.form1.subtotal.value=document.form1.txtSubTot.value;
	}
		document.form1.tot_harga.value=(document.form1.subtotal.value*1)+(document.form1.embalage.value*1)+(document.form1.jasa_resep.value*1);
}

function AddRow(e,par){
var key;
	if(window.event) {
	  key = window.event.keyCode; 
	}
	else if(e.which) {
	  key = e.which;
	}
	//alert(key);
	if (key==13){
		addRowToTable();
//	}else{
//		HitungSubTot(par);
	}
}

// Last updated 2006-02-21
function addRowToTable()
{
//use browser sniffing to determine if IE or Opera (ugly, but required)
	var isIE = false;
	if(navigator.userAgent.indexOf('MSIE')>0){isIE = true;}
//	alert(navigator.userAgent);
//	alert(isIE);
  var tbl = document.getElementById('tblJual');
  var lastRow = tbl.rows.length;
  // if there's no header row in the table, then iteration = lastRow + 1
  var iteration = lastRow;
  var row = tbl.insertRow(lastRow);
  	//row.id = 'row'+(iteration-1);
  	row.className = 'itemtableA';
	//row.setAttribute('class', 'itemtable');
	row.onmouseover = function(){this.className='itemtableAMOver';};
	row.onmouseout = function(){this.className='itemtableA';};
	//row.setAttribute('onMouseOver', "this.className='itemtableMOver'");
	//row.setAttribute('onMouseOut', "this.className='itemtable'");
  
  // left cell
  var cellLeft = row.insertCell(0);
  var textNode = document.createTextNode(iteration-2);
  cellLeft.className = 'tdisikiri';
  cellLeft.appendChild(textNode);
  
  // right cell
  cellLeft = row.insertCell(1);
  textNode = document.createTextNode('-');
  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);
  
  // right cell
  var cellRight = row.insertCell(2);
  var el;
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'obatid';
  }else{
  	el = document.createElement('<input name="obatid"/>');
  }
  el.type = 'hidden';
  el.value = '';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtObat';
	el.setAttribute('OnKeyUp', "suggest(event,this);");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="txtObat" onkeyup="suggest(event, this);" autocomplete="off" />');
  }
  el.type = 'text';
  //el.id = 'txtObat'+(iteration-1);
  el.size = 103;
  el.className = 'txtinput';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  cellLeft = row.insertCell(3);
  textNode = document.createTextNode('-');

  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);
  // select cell
/*  cellRight = row.insertCell(4);
  var sel;
  if(!isIE){
  	sel = document.createElement('select');
  	sel.name = 'kp_id';
  }else{
  	sel = document.createElement('<select name="kp_id" />');
  }	
  sel.className = "txtinput";
  //sel.id = 'selRow'+iteration;
  <?php echo $sela; ?>
  cellRight.className = 'tdisi';
  cellRight.appendChild(sel);
*/
  // right cell
  cellRight = row.insertCell(4);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtJml';
	el.setAttribute('onKeyUp', "AddRow(event,this)");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="txtJml" onKeyUp="AddRow(event,this)" autocomplete="off" />');
  }
  el.type = 'text';
  el.size = 7;
  el.className = 'txtcenter';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(5);
  if(!isIE){
  	el = document.createElement('img');
  	el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}');
  }else{
  	el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}"/>');
  }
  el.src = '../icon/del.gif';
  el.border = "0";
  el.width = "16";
  el.height = "16";
  el.className = 'proses';
  el.align = "absmiddle";
  el.title = "Klik Untuk Menghapus";
  
//  cellRight.setAttribute('class', 'tdisi');
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  document.forms[0].txtObat[iteration-3].focus();

  // select cell
/*  var cellRightSel = row.insertCell(2);
  var sel = document.createElement('select');
  sel.name = 'selRow';
  sel.id = 'selRow'+iteration;
  sel.options[0] = new Option('text zero', 'value0');
  sel.options[1] = new Option('text one', 'value1');
  cellRightSel.appendChild(sel);
*/
}

function keyPressTest(e, obj){
  var validateChkb = document.getElementById('chkValidateOnKeyPress');
  if (validateChkb.checked) {
    var displayObj = document.getElementById('spanOutput');
    var key;
    if(window.event) {
      key = window.event.keyCode; 
    }
    else if(e.which) {
      key = e.which;
    }
    var objId;
    if (obj != null) {
      objId = obj.id;
    } else {
      objId = this.id;
    }
    displayObj.innerHTML = objId + ' : ' + String.fromCharCode(key);
  }
}
function removeRowFromTable(cRow)
{
  var tbl = document.getElementById('tblJual');
  var jmlRow = tbl.rows.length;
  if (jmlRow > 4){
  	var i=cRow.parentNode.parentNode.rowIndex;
  //if (i>2){
	  tbl.deleteRow(i);
	  var lastRow = tbl.rows.length;
	  for (var i=3;i<lastRow;i++){
		var tds = tbl.rows[i].getElementsByTagName('td');
		tds[0].innerHTML=i-2;
	  }
	  //HitungTot();
  }
}

function fSetObat(par){
var cdata=par.split("*|*");
var tbl = document.getElementById('tblJual');
var tds;
	//alert(par);
	if ((cdata[0]*1)==0){
		document.forms[0].obatid.value=cdata[1];
		document.forms[0].txtObat.value=cdata[2];
		tds = tbl.rows[3].getElementsByTagName('td');
		//document.forms[0].txtHarga.value=cdata[4];
		document.forms[0].txtJml.focus();
	}else{
/*		var w;
		for (var x=0;x<document.forms[0].obatid.length-1;x++){
			w=document.forms[0].obatid[x].value;
			//alert(cdata[1]+'-'+w);
			if (cdata[1]==w){
				fKeyEnt=true;
				alert("Obat Tersebut Sudah Ada");
				return false;
			}
		}
*/
		document.forms[0].obatid[(cdata[0]*1)-1].value=cdata[1];
		document.forms[0].txtObat[(cdata[0]*1)-1].value=cdata[2];
		tds = tbl.rows[(cdata[0]*1)+2].getElementsByTagName('td');
		//document.forms[0].txtHarga[(cdata[0]*1)-1].value=cdata[4];
		document.forms[0].txtJml[(cdata[0]*1)-1].focus();
	}
	tds[1].innerHTML=cdata[4];
	tds[3].innerHTML=cdata[3];

	document.getElementById('divobat').style.display='none';
}
</script>
</head>
<body onLoad="document.form1.txtObat.focus()">
<script>
	function PrintArea(idArea,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(idArea).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.write("<br><br><br><br><br>");
	winpopup.document.write("<p class='txtinput'  style='padding-right:50px; text-align:right;'>");
	winpopup.document.write("<b>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</b>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
<div id="load1"></div>
<div id="divobat" align="left" style="position:absolute; z-index:1; left: 270px; top: 350px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
<div align="center">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
  <input name="isview" id="isview" type="hidden" value="<?php echo $isview; ?>">
  <input name="idminta" id="idminta" type="hidden" value="">
  <?php if (($act=="save")||($isview=="true")){?>
  <input name="no_minta" id="no_minta" type="hidden" value="<?php echo $no_minta_cetak; ?>">
  <input name="tglminta" id="tglminta" type="hidden" value="<?php echo $tgltrans1; ?>">
  <?php }?>
  <input name="fdata" id="fdata" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
<?php if (($act=="save")||($isview=="true")){?>
<div align="center">
	<div id="idArea" style="display:none">
		<link rel="stylesheet" href="../theme/print.css" type="text/css" />
		  <p align="center"><span class="jdltable">PERMINTAAN OBAT</span> </p>
		  
        <table width="27%" border="0" cellpadding="1" cellspacing="0" class="txtinput" align="center">
          <tr> 
            <td width="162">Unit</td>
            <td width="261">: <?php echo $namaunit; ?></td>
          </tr>
          <tr> 
            <td>Tgl Permintaan</td>
            <td>: <?php echo $tgltrans1;?></td>
          </tr>
          <tr> 
            <td>No Permintaan </td>
            <td>: <?php echo $no_minta_cetak; ?></td>
          </tr>
          <tr> 
            <td>Unit Tujuan </td>
            <td>: 
              <?php
			  if ($unit_tujuan=="") $unit_tujuan=$_REQUEST['unit_tujuan'];
			  $sql="Select UNIT_NAME From $dbapotek.a_unit where UNIT_ID='$unit_tujuan'";
			 // echo $sql;
			  $exe=mysql_query($sql);
			  $rows=mysql_fetch_array($exe);
			  echo $rows['UNIT_NAME'];?>
            </td>
          </tr>
        </table>
		  <table width="99%" border="0" cellpadding="1" cellspacing="0">
		<tr class="headtable"> 
		  <td width="30" height="25" class="tblheaderkiri">No</td>
		  <td id="OBAT_KODE" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
			Obat</td>
		  <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
			Obat</td>
		  <td id="OBAT_SATUAN_KECIL" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
		  <td id="NAMA" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
		  <td id="qty" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty<br>
			Minta</td>
		</tr>
		<?php 
		  if ($filter!=""){
			$filter=explode("|",$filter);
			$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
		  }
		  if ($sorting=="") $sorting=$defaultsort; 
		    $sql="select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,am.permintaan_id,am.qty,am.qty_terima,NAMA,if (sum(t1.QTY_SATUAN) is null,0,sum(t1.QTY_SATUAN)) as qty_kirim from $dbapotek.a_minta_obat am inner join $dbapotek.a_obat ao on am.obat_id=ao.OBAT_ID inner join $dbapotek.a_kepemilikan ak on am.kepemilikan_id=ak.ID left join (select ap.* from $dbapotek.a_penerimaan ap inner join $dbapotek.a_minta_obat ami on ap.FK_MINTA_ID=ami.permintaan_id where ami.no_bukti='$no_minta_cetak' and ap.UNIT_ID_TERIMA=$idunit and ap.TIPE_TRANS=1) as t1 on am.permintaan_id=t1.FK_MINTA_ID where am.unit_id=$idunit and am.no_bukti='$no_minta_cetak'".$filter." group by am.permintaan_id order by ".$sorting;
		  //echo $sql."<br>";
/*			$rs=mysql_query($sql);
			$jmldata=mysql_num_rows($rs);
			if ($page=="" || $page=="0") $page="1";
			$perpage=50;$tpage=($page-1)*$perpage;
			if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
			if ($page>1) $bpage=$page-1; else $bpage=1;
			if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
			$sql=$sql." limit $tpage,$perpage";
			//echo $sql."<br>";
*/
		  $rs=mysql_query($sql);
		  $i=0;
		  //$i=($page-1)*$perpage;
		  $arfvalue="";
		  while ($rows=mysql_fetch_array($rs)){
			$i++;
		  ?>
		<tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
		  <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i; ?></td>
		  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_KODE']; ?></td>
		  <td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['OBAT_NAMA']; ?></td>
		  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
		  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
		  <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['qty']; ?></td>
		  
		</tr>
		<?php 
		  }
		  mysql_free_result($rs);
		  ?>
	  </table>
	</div>
	<?php 
	if ($isview=="true"){
		$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
		$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];	
	?>
	<div style="display:block">
	<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
		<!--link rel="stylesheet" href="../theme/print.css" type="text/css" /-->
		  <p align="center"><span class="jdltable">PERMINTAAN OBAT</span> </p>
		  
        <table width="27%" border="0" cellpadding="1" cellspacing="0" class="tabel" align="center">
          <tr> 
            <td width="162">Unit</td>
            <td width="261">: <?php echo $namaunit; ?></td>
          </tr>
          <tr> 
            <td>Tgl Permintaan</td>
            <td>: <?php echo $tgltrans1;?></td>
          </tr>
          <tr> 
            <td>No Permintaan </td>
            <td>: <?php echo $no_minta_cetak; ?></td>
          </tr>
          <tr> 
            <td>Unit Tujuan </td>
            <td>: 
              <?php
			  if ($unit_tujuan=="") $unit_tujuan=$_REQUEST['unit_tujuan'];
			  $sql="Select UNIT_NAME From $dbapotek.a_unit where UNIT_ID='$unit_tujuan'";
			 // echo $sql;
			  $exe=mysql_query($sql);
			  $rows=mysql_fetch_array($exe);
			  echo $rows['UNIT_NAME'];?>
            </td>
          </tr>
        </table>
		  
        <table width="99%" border="0" cellpadding="1" cellspacing="0">
          <tr class="headtable"> 
            <td width="30" height="25" class="tblheaderkiri">No</td>
            <td id="OBAT_KODE" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
              Obat</td>
            <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama Obat</td>
            <td id="OBAT_SATUAN_KECIL" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
            <td id="NAMA" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
            <td id="qty" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty<br>
              Minta</td>
            <td id="qty" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty 
              Kirim </td>
            <td width="40" class="tblheader">Proses</td>
          </tr>
          <?php 
		  if ($filter!=""){
			$filter=explode("|",$filter);
			$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
		  }
		  if ($sorting=="") $sorting=$defaultsort;
		  $sql="select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,am.permintaan_id,am.qty,am.qty_terima,NAMA,if (sum(t1.QTY_SATUAN) is null,0,sum(t1.QTY_SATUAN)) as qty_kirim from $dbapotek.a_minta_obat am inner join $dbapotek.a_obat ao on am.obat_id=ao.OBAT_ID inner join $dbapotek.a_kepemilikan ak on am.kepemilikan_id=ak.ID left join (select ap.* from $dbapotek.a_penerimaan ap inner join $dbapotek.a_minta_obat ami on ap.FK_MINTA_ID=ami.permintaan_id where ami.no_bukti='$no_minta_cetak' and ap.UNIT_ID_TERIMA=$idunit and ap.TIPE_TRANS=1) as t1 on am.permintaan_id=t1.FK_MINTA_ID where am.unit_id=$idunit and am.no_bukti='$no_minta_cetak'".$filter." group by am.permintaan_id order by ".$sorting;
		  //echo $sql."<br>";
			$rs=mysql_query($sql);
			$jmldata=mysql_num_rows($rs);
			if ($page=="" || $page=="0") $page="1";
			$perpage=50;$tpage=($page-1)*$perpage;
			if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
			if ($page>1) $bpage=$page-1; else $bpage=1;
			if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
			$sql=$sql." limit $tpage,$perpage";
			//echo $sql."<br>";
		  $rs=mysql_query($sql);
		  $i=0;
		  //$i=($page-1)*$perpage;
		  while ($rows=mysql_fetch_array($rs)){
			$i++;
			$cpermintaan_id=$rows['permintaan_id'];
			$iterima=$rows['qty_terima'];
			$cqty_kirim=$rows['qty_kirim'];
			$sql="";
			$arfhapus="act*-*delete*|*idminta*-*".$rows['permintaan_id'];
		  ?>
          <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
            <td class="tdisikiri"><?php echo $i; ?></td>
            <td class="tdisi" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
            <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
            <td class="tdisi" align="center"><?php echo $rows['OBAT_SATUAN_KECIL']; ?>&nbsp;</td>
            <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
            <td class="tdisi" align="center"><?php echo $rows['qty']; ?></td>
            <td class="tdisi" align="center"><?php echo $rows['qty_kirim']; ?></td>
            <td class="tdisi" align="center"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="<?php if ($cqty_kirim<=0){?>if (confirm('Yakin Ingin Menghapus Data?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}<?php }else{?>alert('Obat Yang Diminta Sudah Dikirim, Jadi Tidak Boleh Dihapus !');<?php }?>"></td>
          </tr>
          <?php 
		  }
		  mysql_free_result($rs);
		  ?>
        </table>
		<table width="100%" border="0">
		  <tr> 
			<td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
				<?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
			<td colspan="4" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
			  <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
			  <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
			  <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
			</td>
		  </tr>
		</table>
	</div>
	<?php }?>
	<?php if ($act=="save"){?>
  <p align="center"><strong>Permintaan Obat ke Gudang Dgn No Bukti : <?php echo $no_minta_cetak; ?> 
    Sudah Disimpan</strong></p>
	<?php }?>
	<p align="center">
	<!--a class="navText" href='#' onclick='PrintArea("idArea","#")'-->
	<BUTTON type="button" onClick="PrintArea('idArea','#')"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak 
    Permintaan&nbsp;&nbsp;</BUTTON>
	<!--/a-->
	&nbsp;
    <BUTTON type="button" onClick="location='minta_terima_obat.php'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Daftar 
    Minta Obat &nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
  </p>
</div>
<?php }else{?>
<script>
var arrRange=depRange=[];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
	  <table width="99%" border="1">
	  	<tr>
			<td>
  			<div id="input" style="display:block" align="center"> 
            <table width="50%" border="0" cellpadding="0" cellspacing="0" class="table">
            <tr>
				<td>
					Jenis Layanan
				</td>
				<td width="125">
                :
					<select id="cmbJnsLay" class="txtinput" onChange="cekLab(this.value);cekInap(this.options[this.options.selectedIndex].lang);isiCombo1('cmbTmpLay','<?php echo $_SESSION['userId'];?>,'+this.value,'','cmbTmpLay',evLang2);" >
					<?php
                                            $sql="SELECT distinct m.id,m.nama,m.inap FROM (SELECT distinct b.unit_id FROM b_ms_pegawai_unit b
                                                    where ms_pegawai_id=".$_SESSION['userId'].") as t1
                                                    inner join b_ms_unit u on t1.unit_id=u.id
                                                    inner join b_ms_unit m on u.parent_id=m.id WHERE m.kategori=2 order by nama";
                                            $rs=mysql_query($sql);
                                            while($rw=mysql_fetch_array($rs)) {
                                                ?>
                                            <option value="<?php echo $rw['id'];?>" lang="<?php echo $rw['inap'];?>" ><?php echo $rw['nama'];?></option>
                                                <?php
                                            }
                                            ?>
						</select>
                 </td>
              </tr>
              <tr>
                 <td>
					Tempat Layanan
				 </td>
				 <td>
                 :
				   <select name="cmbTmpLay" id="cmbTmpLay" class="txtinput" lang="" onChange="this.lang=this.value;evLang2();">
					</select>
				 </td>
			  </tr>
              <!--<tr> 
                <td width="125">Unit&nbsp; </td>
                <td>: <?php echo $namaunit; ?></td>
              </tr>-->
              <tr> 
                <td width="125">Tanggal&nbsp; </td>
                <td>: 
                  <input name="tglminta" type="text" id="tglminta" size="11" maxlength="10" readonly="true" value="<?php echo $tgl;?>" class="txtcenter" /> 
                  <input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" <?php echo $DisableBD; ?> onClick="gfPop.fPopCalendar(this.form.tglminta,depRange);" /></td>
              </tr>
              <tr> 
                <td>No. Permintaan</td>
                <td>: 
                  <input name="no_minta" type="text" class="txtinput" id="no_minta" value="<?php echo $no_minta; ?>" size="25" maxlength="30" readonly="true" ></td>
              </tr>
              <tr>
                <td>Kepemilikan</td>
                <td>:
                  <select name="kpid" id="kpid">
                    <?php
					$qry = "SELECT * FROM $dbapotek.a_kepemilikan WHERE AKTIF=1";
					$exe = mysql_query($qry);
					while($show= mysql_fetch_array ($exe)){
					?>
                    <option value="<?php echo $show['ID'];?>"><?php echo $show['NAMA'];?></option>
                    <?php }?>
                  </select></td>
              </tr>
              <tr> 
                <td>Unit Tujuan</td>
                <td>: 
                  <select name="unit_tujuan" id="unit_tujuan">
                    <?php
					$qry = "SELECT * FROM $dbapotek.a_unit WHERE UNIT_TIPE<>3 AND UNIT_TIPE=1 AND UNIT_ISAKTIF=1";
					$exe = mysql_query($qry);
					while($show= mysql_fetch_array ($exe)){
					?>
                    <option value="<?php echo $show['UNIT_ID'];?>"><?php echo $show['UNIT_NAME'];?></option>
                    <?php }?>
                  </select></td>
              </tr>
              <!--tr>
                <td>Unit Tujuan</td>
                <td>: 
                  <select name="unit_tujuan" id="unit_tujuan">
                    <option value="1">GUDANG</option>
                    <option value="17">PRODUKSI</option>
                  </select></td>
              </tr-->
            </table>
  </div>
          <table id="tblJual" width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
            <tr> 
              <td colspan="6" align="center" class="jdltable"><hr></td>
            </tr>
            <tr> 
              <td colspan="5" align="center" class="jdltable"> PERMINTAAN OBAT</td>
              <td align="right" valign="bottom"><input type="button" value="+" onClick="addRowToTable();" /></td>
            </tr>
            <tr class="headtable"> 
              <td width="25" height="25" class="tblheaderkiri">No</td>
              <td width="100" height="25" class="tblheader">Kode Obat</td>
              <td height="25" class="tblheader">Nama Obat</td>
              <td width="100" height="25" class="tblheader">Satuan</td>
              <td width="50" height="25" class="tblheader">Qty</td>
              <td width="30" height="25" class="tblheader">Proses</td>
            </tr>
            <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'"> 
              <td class="tdisikiri">1</td>
              <td class="tdisi">-</td>
              <td class="tdisi" align="left"> <input name="obatid" type="hidden" value=""> 
                <input type="text" name="txtObat" class="txtinput" size="103" onKeyUp="suggest(event,this);" autocomplete="off" /></td>
              <td class="tdisi">-</td>
              <td class="tdisi" width="40"> <input type="text" name="txtJml" class="txtcenter" size="7" onKeyUp="AddRow(event,this)" autocomplete="off" /></td>
              <td width="40" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);}"></td>
            </tr>
          </table>
		</td>
	</tr>
</table>
		<p align="center">
            <BUTTON id="btnSimpan" type="button" onClick="fSubmit();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>
            &nbsp;<BUTTON type="reset" onClick="location='minta_terima_obat.php'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
          </p>
<?php } ?>
</form>
</div>
</body>
</html>
<?php 
mysql_close($konek);
?>