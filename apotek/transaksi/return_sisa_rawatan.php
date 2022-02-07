<?php 
// Koneksi =================================
include("../sesi.php"); 
include("../koneksi/konek.php");
//==========================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$th=explode("-",mysqli_real_escape_string($konek,$tgl));


$tgl2="$th[2]-$th[1]-$th[0]";
$bulan=(int)$th[1];

//$tgltrans1=$_REQUEST["tglminta"];
$tgltrans1=mysqli_real_escape_string($konek,$_REQUEST["tglminta"]);
$tgltrans=explode("-",$tgltrans1);

$tglminta=$tgltrans[2]."-".$tgltrans[1]."-".$tgltrans[0];
//$no_minta=$_REQUEST["no_minta"];
$no_minta=mysqli_real_escape_string($konek,$_REQUEST["no_minta"]);
$no_minta_cetak=$no_minta;
//$fdata=$_REQUEST["fdata"];
$fdata=mysqli_real_escape_string($konek,$_REQUEST["fdata"]);
//$idminta=$_REQUEST["idminta"];
$idminta=mysqli_real_escape_string($konek,$_REQUEST["idminta"]);
//$isview=$_REQUEST["isview"];
$isview=mysqli_real_escape_string($konek,$_REQUEST["isview"]);
//======================Tanggalan==========================
//$idgudang=$_SESSION["ses_id_gudang"];
$idgudang=mysqli_real_escape_string($konek,$_REQUEST["ses_id_gudang"]);
//$unit_tujuan=$_REQUEST["unit_tujuan"];

//$kepemilikan_id=$_REQUEST["kpid"];
$kepemilikan_id=mysqli_real_escape_string($konek,$_REQUEST["kpid"]);
//if ($kepemilikan_id=="") $kepemilikan_id=$_SESSION["kepemilikan_id"];
//Paging,Sorting dan Filter======
//$page=$_REQUEST["page"];
$page=mysqli_real_escape_string($konek,$_REQUEST["page"]);
$defaultsort="UNIT_ID";
//$sorting=$_REQUEST["sorting"];
$sorting=mysqli_real_escape_string($konek,$_REQUEST["sorting"]);
//$filter=$_REQUEST["filter"];
$filter=mysqli_real_escape_string($konek,$_REQUEST["filter"]);
//===============================

//Aksi Save, Edit Atau Delete =========================================
//$act=$_REQUEST['act']; // Jenis Aksi
$act=mysqli_real_escape_string($konek,$_REQUEST["act"]);
//echo $act;

switch ($act){
	case "save":
		$sql="SELECT * FROM a_penerimaan WHERE UNIT_ID_TERIMA=$idunit AND NOBUKTI='$no_minta' LIMIT 1";
		$rs=mysqli_query($konek,$sql);
		if ($rows=mysqli_fetch_array($rs)){
			$cusr=$rows["USER_ID_TERIMA"];
			if ($cusr==$iduser){
				//duplicate entry or refreshed
				echo "<script>alert('Penerimaan Dgn No Tersebut Sudah Ada !');</script>";
			}else{
				$nokw="0001";
				$cekNo = "select MAX(nomor) no_bukti from a_no_penerimaan_log where unit_id=$idunit AND bulan=$th[1] and tahun=$th[2]"; //order by id DESC limit 1
				$qcekNo = mysqli_query($konek,$cekNo);
				if($qcekNo){
					$dcekNo = mysqli_fetch_array($qcekNo);
				}
				$sql="select NOTERIMA from a_penerimaan where UNIT_ID_TERIMA=$idunit and NOTERIMA like '$kodeunit/RTN/$th[2]-$th[1]/%' 
					order by NOTERIMA desc limit 1";
				//echo $sql."<br>";
				$rs = mysqli_query($konek,$sql);
				$rows = mysqli_fetch_array($rs);
				$noBukti=explode('/',$rows["NOTERIMA"]);
				$no_bukti=(int)$noBukti[3];
				if(!is_null($dcekNo['no_bukti'])){
					if(((int)$dcekNo['no_bukti']) > ((int)$no_bukti)){
						$nokw=(int)$dcekNo["no_bukti"]+1;
					} else if(((int)$dcekNo['no_bukti']) < ((int)$no_bukti)){
						$nokw=(int)$no_bukti+1;
					} else {
						$nokw=(int)$dcekNo["no_bukti"]+1;
					}
				} else {
					$nokw=(int)$no_bukti+1;
				}
				
				$updateNO = "insert into a_no_penerimaan_log(nomor,unit_id,bulan,tahun) value('{$nokw}','$idunit','$th[1]','$th[2]')";
				$qNO = mysqli_query($konek,$updateNO) or die (mysqli_error($konek));
				$idNomor = mysqli_insert_id($konek);
				
				$sqlNomor = "select nomor from a_no_penerimaan_log where id = '{$idNomor}'";
				$qNomor = mysqli_query($konek,$sqlNomor);
				$dNomor = mysqli_fetch_array($qNomor);
				
				if(!empty($dNomor['nomor'])){
					$nokw = (int)$dNomor['nomor'];
				}
				
				$nokwstr=(string)$nokw;
				if (strlen($nokwstr)<4){
					for ($i=0;$i<(4-strlen($nokwstr));$i++) $nokw="0".$nokw;
				}else{
					$nokw=$nokwstr;
				}
				$no_minta="$kodeunit/RTN/$th[2]-$th[1]/".$nokw;
				// End No Minta Baru
				
				$no_minta_cetak=$no_minta;
				
				
				
				
				$arfdata=explode("**",$fdata);
				for ($i=0;$i<count($arfdata);$i++){
				
				$hrg = "select IFNULL(COUNT(id),0),IFNULL(qty_stok,0) qty_stok ,IFNULL(nilai,0) nilai ,IFNULL(rata2,0) rata2 from a_stok where unit_id=$idunit AND obat_id=".$arfvalue[0]." ";
				$hrg1 = mysqli_query($konek,$hrg);
				$hrg2 = mysqli_fetch_array($hrg1);
				$a_rata = $hrg2['rata2'];
				if($a_rata==0){
					$a_rata2 = $arfvalue[3];
				}else{
					$a_rata2 = $hrg2['rata2'];
				}
				
				
					$arfvalue=explode("|",$arfdata[$i]);
					//$sql="insert into a_minta_obat(unit_id,unit_tujuan,user_id,no_bukti,obat_id,kepemilikan_id,qty,qty_terima,tgl,tgl_act,status) values($idunit,$unit_tujuan,$iduser,'$no_minta',$arfvalue[0],$kepemilikan_id,$arfvalue[1],0,'$tglminta','$tglact',0)";
					//echo $sql."<br>";
					// $rs=mysqli_query($konek,$sql);
					
					$sql="INSERT INTO a_penerimaan(OBAT_ID,ID_LAMA,FK_MINTA_ID,PBF_ID,UNIT_ID_KIRIM,UNIT_ID_TERIMA,KEPEMILIKAN_ID,USER_ID_KIRIM,USER_ID_TERIMA,NOKIRIM,NOTERIMA,NOBUKTI,TANGGAL_ACT,TANGGAL,TGL_TERIMA_ACT,TGL_TERIMA,TGL_J_TEMPO,HARI_J_TEMPO,BATCH,EXPIRED,QTY_KEMASAN,KEMASAN,QTY_PER_KEMASAN,QTY_SATUAN,QTY_SATUAN_LAMA,QTY_STOK,QTY_RETUR,HARGA_BELI_TOTAL,HARGA_BELI_SATUAN,DISKON,DISKON_RP,DISKON_TYPE,EXTRA_DISKON,DISKON_TOTAL,KET,NILAI_PAJAK,JENIS,TIPE_TRANS,STATUS,SUMBER_DANA,RATA2_UNIT_KIRIM,RATA2_UNIT_TERIMA,SATUAN)
  VALUES($arfvalue[0],'','','','',$idunit,$kepemilikan_id,$iduser,$iduser,'','$no_minta','$no_minta',NOW(),'$tglminta',NOW(),'$tglminta','','','','','','','',$arfvalue[1],'',$arfvalue[1],0,$arfvalue[1]*$a_rata2,$a_rata2,0,0,0,0,0,'',0,0,11,1,'',$a_rata2,$a_rata2,'$arfvalue[2]')";
				 //echo $sql;
				  $rs=mysqli_query($konek,$sql);
  
		 		
		 			
				}
			}
		}else{
			/* No Minta Baru */
			$nokw="0001";
			$cekNo = "select MAX(nomor) no_bukti from a_no_penerimaan_log where unit_id=$idunit AND bulan=$th[1] and tahun=$th[2]"; //order by id DESC limit 1
			$qcekNo = mysqli_query($konek,$cekNo);
			if($qcekNo){
				$dcekNo = mysqli_fetch_array($qcekNo);
			}
			$sql="select NOTERIMA from a_penerimaan where UNIT_ID_TERIMA=$idunit and NOTERIMA like '$kodeunit/RTN/$th[2]-$th[1]/%' 
					order by NOTERIMA desc limit 1";
			//echo $sql."<br>";
			$rs = mysqli_query($konek,$sql);
			$rows = mysqli_fetch_array($rs);
			$noBukti=explode('/',$rows["NOTERIMA"]);
			$no_bukti=(int)$noBukti[3];
			if(!is_null($dcekNo['no_bukti'])){
				if(((int)$dcekNo['no_bukti']) > ((int)$no_bukti)){
					$nokw=(int)$dcekNo["no_bukti"]+1;
				} else if(((int)$dcekNo['no_bukti']) < ((int)$no_bukti)){
					$nokw=(int)$no_bukti+1;
				} else {
					$nokw=(int)$dcekNo["no_bukti"]+1;
				}
			} else {
				$nokw=(int)$no_bukti+1;
			}
			
			$updateNO = "insert into a_no_penerimaan_log(nomor,unit_id,bulan,tahun) value('{$nokw}','$idunit','$th[1]','$th[2]')";
			$qNO = mysqli_query($konek,$updateNO) or die (mysqli_error($konek));
			$idNomor = mysqli_insert_id($konek);
			
			$sqlNomor = "select nomor from a_no_penerimaan_log where id = '{$idNomor}'";
			$qNomor = mysqli_query($konek,$sqlNomor);
			$dNomor = mysqli_fetch_array($qNomor);
			
			if(!empty($dNomor['nomor'])){
				$nokw = (int)$dNomor['nomor'];
			}
			
			$nokwstr=(string)$nokw;
			if (strlen($nokwstr)<4){
				for ($i=0;$i<(4-strlen($nokwstr));$i++) $nokw="0".$nokw;
			}else{
				$nokw=$nokwstr;
			}
			$no_minta="$kodeunit/RTN/$th[2]-$th[1]/".$nokw;
			// End No Minta Baru
			
			$no_minta_cetak=$no_minta;
			
			
			
			
			$arfdata=explode("**",$fdata);
			for ($i=0;$i<count($arfdata);$i++){
				$arfvalue=explode("|",$arfdata[$i]);
				
				$hrg = "select IFNULL(COUNT(id),0),IFNULL(qty_stok,0) qty_stok ,IFNULL(nilai,0) nilai ,IFNULL(rata2,0) rata2 from a_stok where unit_id=$idunit AND obat_id=".$arfvalue[0]." ";
				$hrg1 = mysqli_query($konek,$hrg);
				$hrg2 = mysqli_fetch_array($hrg1);
				$a_rata = $hrg2['rata2'];
				if($a_rata==0){
					$a_rata2 = $arfvalue[3];
				}else{
					$a_rata2 = $hrg2['rata2'];
				}
				
				
				//$sql="insert into a_minta_obat(unit_id,unit_tujuan,user_id,no_bukti,obat_id,kepemilikan_id,qty,qty_terima,tgl,tgl_act,status) values($idunit,$unit_tujuan,$iduser,'$no_minta',$arfvalue[0],$kepemilikan_id,$arfvalue[1],0,'$tglminta','$tglact',0)";
				//echo $sql."<br>";
				//$rs=mysqli_query($konek,$sql);
				
				$sql="INSERT INTO a_penerimaan(OBAT_ID,ID_LAMA,FK_MINTA_ID,PBF_ID,UNIT_ID_KIRIM,UNIT_ID_TERIMA,KEPEMILIKAN_ID,USER_ID_KIRIM,USER_ID_TERIMA,NOKIRIM,NOTERIMA,NOBUKTI,TANGGAL_ACT,TANGGAL,TGL_TERIMA_ACT,TGL_TERIMA,TGL_J_TEMPO,HARI_J_TEMPO,BATCH,EXPIRED,QTY_KEMASAN,KEMASAN,QTY_PER_KEMASAN,QTY_SATUAN,QTY_SATUAN_LAMA,QTY_STOK,QTY_RETUR,HARGA_BELI_TOTAL,HARGA_BELI_SATUAN,DISKON,DISKON_RP,DISKON_TYPE,EXTRA_DISKON,DISKON_TOTAL,KET,NILAI_PAJAK,JENIS,TIPE_TRANS,STATUS,SUMBER_DANA,RATA2_UNIT_KIRIM,RATA2_UNIT_TERIMA,SATUAN)
  VALUES($arfvalue[0],'','','','',$idunit,$kepemilikan_id,$iduser,$iduser,'','$no_minta','$no_minta',NOW(),'$tglminta',NOW(),'$tglminta','','','','','','','',$arfvalue[1],'',$arfvalue[1],0,$arfvalue[1]*$a_rata2,$a_rata2,0,0,0,0,0,'',0,0,11,1,'',$a_rata2,$a_rata2,'$arfvalue[2]')";
				// echo $sql;
				  $rs=mysqli_query($konek,$sql);
				
			}
		}
		
		break;

	case "delete":
		$sql="select ID from a_penerimaan where FK_MINTA_ID=$idminta and UNIT_ID_TERIMA=$idunit and TIPE_TRANS=1";
		$rs=mysqli_query($konek,$sql);
		if ($rows=mysqli_fetch_array($rs)){
			echo "<script>alert('Data Tdk Boleh Dihapus Karena Permintaan Obat Tersebut Sudah Dikirim !');</script>";
		}else{
			$sql="delete from a_minta_obat where permintaan_id=$idminta";
			$rs1=mysqli_query($konek,$sql);
			//echo $sql;
		}
		break;
}
/*
$qry="select * from a_kepemilikan where AKTIF=1";
$exe=mysqli_query($konek,$qry);
$sela="";
$i=0;
while($show=mysqli_fetch_array($exe)){
	$sela .="sel.options[$i] = new Option('".$show['NAMA']."', '".$show['ID']."');";
	$i++;
}
*/
//Aksi Save, Edit, Delete Berakhir ====================================
//$sql="select * from a_minta_obat where unit_id=$idunit and month(tgl)=$bulan and year(tgl)=$th[2] order by permintaan_id desc limit 1";
/* $sql="SELECT * FROM (SELECT * FROM a_minta_obat WHERE unit_id=$idunit AND MONTH(tgl)=$bulan AND YEAR(tgl)=$th[2] AND no_bukti LIKE '$kodeunit/UP/$th[2]-$th[1]/%') AS t1 ORDER BY no_bukti DESC LIMIT 1";
//echo $sql."<br>";
$rs1=mysqli_query($konek,$sql);
if ($rows1=mysqli_fetch_array($rs1)){
	$no_minta=$rows1["no_bukti"];
	$ctmp=explode("/",$no_minta);
	$dtmp=$ctmp[3]+1;
	$ctmp=$dtmp;
	for ($i=0;$i<(4-strlen($dtmp));$i++) $ctmp="0".$ctmp;
	$no_minta="$kodeunit/UP/$th[2]-$th[1]/$ctmp";
}else{
	$no_minta="$kodeunit/UP/$th[2]-$th[1]/0001";
} */
//echo $no_minta."<br>";
//mysqli_free_result($rs1);

/* No Minta Baru */
$nokw="0001";
$cekNo = "select MAX(nomor) no_bukti from a_no_penerimaan_log where unit_id=$idunit AND bulan=$th[1] and tahun=$th[2]"; //order by id DESC limit 1
$qcekNo = mysqli_query($konek,$cekNo);
if($qcekNo){
	$dcekNo = mysqli_fetch_array($qcekNo);
}
//$sql="select MAX(CAST(NO_PENJUALAN AS UNSIGNED)) AS NO_PENJUALAN from a_penjualan where UNIT_ID=$idunit and YEAR(TGL)=$th[2]";
$sql="select NOTERIMA from a_penerimaan where UNIT_ID_TERIMA=$idunit and NOTERIMA like '$kodeunit/RTN/$th[2]-$th[1]/%' 
					order by NOTERIMA desc limit 1";
//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
$rows=mysqli_fetch_array($rs);
$noBukti=explode('/',$rows["NOTERIMA"]);
$no_bukti=(int)$noBukti[3];
if(!is_null($dcekNo['no_bukti'])){
	if(((int)$dcekNo['no_bukti']) > ((int)$no_bukti)){
		$nokw=(int)$dcekNo["no_bukti"]+1;
	} else if(((int)$dcekNo['no_bukti']) < ((int)$no_bukti)){
		$nokw=(int)$no_bukti+1;
	} else {
		$nokw=(int)$dcekNo["no_bukti"]+1;
	}
} else {
	$nokw=(int)$no_bukti+1;
}

$nokwstr=(string)$nokw;
if (strlen($nokwstr)<4){
	for ($i=0;$i<(4-strlen($nokwstr));$i++) $nokw="0".$nokw;
}else{
	$nokw=$nokwstr;
}
$no_minta="$kodeunit/RTN/$th[2]-$th[1]/".$nokw;
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
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
function suggest(e,par){
var keywords=par.value;//alert(keywords);
	//alert(par.offsetLeft);
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
			Request('../transaksi/obatlist_rtn.php?aKeyword='+keywords+'&aKepemilikan='+document.forms[0].kpid.value+'&no='+i+'&idunit='+<?php echo $idunit; ?> , 'divobat', '', 'GET' );
			if (document.getElementById('divobat').style.display=='none') fSetPosisi(document.getElementById('divobat'),par);
			document.getElementById('divobat').style.display='block';
		}
	}
}

function fSubmit(){
var cdata='';
var ctemp;
	if (document.forms[0].no_minta.value==""){
		alert('Isikan No Permintaan Terlebih Dahulu !');
		document.forms[0].no_minta.focus();
		return false;		
	}
	if (document.forms[0].obatid.length){
		for (var i=0;i<document.forms[0].obatid.length;i++){
			ctemp=document.forms[0].obatid[i].value;
			if (document.forms[0].obatid[i].value==""){
				alert('Pilih Obat Terlebih Dahulu !');
				document.forms[0].txtObat[i].focus();
				return false;		
			}
			
			if (document.forms[0].txtJml[i].value==""){
				alert('Qty obat masih kosong !');
				document.forms[0].txtJml[i].focus();
				return false;		
			}
			
			if (document.forms[0].txtHarga[i].value=="0"){
				alert('Silahkan Masukkan Harga Obat !');
				document.forms[0].txtHarga[i].focus();
				return false;		
			}
						
			cdata +=ctemp+'|'+document.forms[0].txtJml[i].value+'|'+document.forms[0].txtSatuan[i].value+'|'+document.forms[0].txtHarga[i].value+'**';
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
		if (document.forms[0].txtJml.value==""){
			alert('Qty obat masih kosong !');
			document.forms[0].txtJml.focus();
			return false;		
		}
		if (document.forms[0].txtHarga.value=="0"){
			alert('Silahkan Masukkan Harga Obat !');
			document.forms[0].txtHarga.focus();
			return false;		
		}
		ctemp=document.forms[0].obatid.value;
/*		if ((ctemp[1]*1)<(document.forms[0].txtJml.value*1)){
			document.forms[0].txtObat.focus();
			alert('Stok Obat Kurang !');
			return false;
		}
*/
		cdata=ctemp+'|'+document.forms[0].txtJml.value+'|'+document.forms[0].txtSatuan.value+'|'+document.forms[0].txtHarga.value;
	}
	//alert(cdata);
	document.forms[0].fdata.value=cdata;
	document.getElementById('btnSimpan').disabled=true;
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
  el.size = 75;
  el.className = 'txtinput';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  cellRight = row.insertCell(3);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtSatuan';
	el.setAttribute('onKeyUp', "");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="txtSatuan" onKeyUp="" autocomplete="off" />');
  }
  el.type = 'text';
  el.size = 13;
  el.className = 'txtcenter';

 cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  cellLeft = row.insertCell(4);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtHarga';
	el.setAttribute('onKeyUp', "AddRow(event,this)");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="txtHarga" onKeyUp="" autocomplete="off" />');
  }
  el.type = 'text';
  el.size = 20;
  el.className = 'txtright';
  
    cellLeft.className = 'tdisi';
   cellLeft.appendChild(el);

  cellRight = row.insertCell(5);
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
  cellRight = row.insertCell(6);
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
		document.forms[0].txtSatuan.value=cdata[3];
		document.forms[0].txtHarga.value=cdata[7];
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
		document.forms[0].txtSatuan[(cdata[0]*1)-1].value=cdata[3];
		document.forms[0].txtHarga[(cdata[0]*1)-1].value=cdata[7];
		tds = tbl.rows[(cdata[0]*1)+2].getElementsByTagName('td');
		//document.forms[0].txtHarga[(cdata[0]*1)-1].value=cdata[4];
		document.forms[0].txtJml[(cdata[0]*1)-1].focus();
	}
 	tds[1].innerHTML=cdata[4];
	//tds[3].innerHTML=cdata[3];

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
<div id="divobat" align="left" style="position:absolute; z-index:1; left: 10px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
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
			  $sql="Select UNIT_NAME From a_unit where UNIT_ID='$unit_tujuan'";
			 // echo $sql;
			  $exe=mysqli_query($konek,$sql);
			  $rows=mysqli_fetch_array($exe);
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
		    $sql="select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,am.permintaan_id,am.qty,am.qty_terima,NAMA,if (sum(t1.QTY_SATUAN) is null,0,sum(t1.QTY_SATUAN)) as qty_kirim from a_minta_obat am inner join a_obat ao on am.obat_id=ao.OBAT_ID inner join a_kepemilikan ak on am.kepemilikan_id=ak.ID left join (select ap.* from a_penerimaan ap inner join a_minta_obat ami on ap.FK_MINTA_ID=ami.permintaan_id where ami.no_bukti='$no_minta_cetak' and ap.UNIT_ID_TERIMA=$idunit and ap.TIPE_TRANS=1) as t1 on am.permintaan_id=t1.FK_MINTA_ID where am.unit_id=$idunit and am.no_bukti='$no_minta_cetak'".$filter." group by am.permintaan_id order by ".$sorting;
	
		  $rs=mysqli_query($konek,$sql);
		  $i=0;
		  //$i=($page-1)*$perpage;
		  $arfvalue="";
		  while ($rows=mysqli_fetch_array($rs)){
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
		  mysqli_free_result($rs);
		  ?>
	  </table>
	</div>

	<?php if ($act=="save"){?>
  <p align="center"><strong>Return Obat Sisa Rawatan  : <?php echo $no_minta_cetak; ?> 
    Sudah Disimpan</strong></p>
	<?php }?>
	<p align="center">
	<!--a class="navText" href='#' onclick='PrintArea("idArea","#")'
	<BUTTON type="button" onClick="PrintArea('idArea','#')"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak 
    Permintaan&nbsp;&nbsp;</BUTTON>
	-->
	&nbsp;
    <BUTTON type="button" onClick="location='?f=../apotik/list_return_sisa_rawatan.php&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Daftar 
    Return Obat Sisa Rawatan &nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
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
            <table width="50%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
              <tr> 
                <td width="125">Unit&nbsp; </td>
                <td>: <?php echo $namaunit; ?></td>
              </tr>
              <tr> 
                <td width="125">Tanggal&nbsp; </td>
                <td>: 
                  <input name="tglminta" type="text" id="tglminta" size="11" maxlength="10" readonly="true" value="<?php echo $tgl;?>" class="txtcenter" /> 
                  <input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" <?php echo $DisableBD; ?> onClick="gfPop.fPopCalendar(this.form.tglminta,depRange);" /></td>
              </tr>
              <tr> 
                <td>No. Penerimaan</td>
                <td>: 
                  <input name="no_minta" type="text" class="txtinput" id="no_minta" value="<?php echo $no_minta; ?>" size="25" maxlength="30" readonly="true" ></td>
              </tr>
              <tr>
                <td>Kepemilikan</td>
                <td>:
                  <select name="kpid" id="kpid">
                    <?php
					$qry = "SELECT * FROM a_kepemilikan WHERE AKTIF=1";
					$exe = mysqli_query($konek,$qry);
					while($show= mysqli_fetch_array($exe)){
					?>
                    <option value="<?php echo $show['ID'];?>"><?php echo $show['NAMA'];?></option>
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
              <td colspan="7" align="center" class="jdltable"><hr></td>
            </tr>
            <tr> 
              <td colspan="6" align="center" class="jdltable"> RETURN OBAT SISA RAWATAN </td>
              <td align="right" valign="bottom"><input type="button" value="+" onClick="addRowToTable();" /></td>
            </tr>
            <tr class="headtable"> 
              <td width="25" height="25" class="tblheaderkiri">No</td>
              <td width="100" height="25" class="tblheader">Kode Obat</td>
              <td height="25" class="tblheader">Nama Obat</td>
              <td width="100" height="25" class="tblheader">Satuan</td>
              <td width="50" class="tblheader">Harga</td>
              <td width="50" height="25" class="tblheader">Qty</td>
              <td width="30" height="25" class="tblheader">Proses</td>
            </tr>
            <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'"> 
              <td class="tdisikiri">1</td>
              <td class="tdisi">-</td>
              <td class="tdisi" align="left"> <input name="obatid" type="hidden" value=""> 
                <input type="text" name="txtObat" class="txtinput" size="75" onKeyUp="suggest(event,this);" autocomplete="off" /></td>
              <td class="tdisi"> <input type="text" name="txtSatuan" class="txtcenter" size="13" onKeyUp="" autocomplete="off" /></td>
              <td class="tdisi"><input  type="text" name="txtHarga" class="txtright" size="20" onKeyUp="" autocomplete="off" /></td>
              <td class="tdisi" width="40"> <input type="text" name="txtJml" class="txtcenter" size="7" onKeyUp="AddRow(event,this)" autocomplete="off" /></td>
              <td width="40" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);}"></td>
            </tr>
          </table>
		</td>
	</tr>
</table>
		<p align="center">
            <BUTTON id="btnSimpan" type="button" onClick="fSubmit();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>
            &nbsp;<BUTTON type="reset" onClick="location='?f=../apotik/list_return_sisa_rawatan.php'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
          </p>
<?php } ?>
</form>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>