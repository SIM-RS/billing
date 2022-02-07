<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_REQUEST['idunit'];
$idunit1=$_SESSION["ses_idunit"];
if ($idunit=="") $idunit=$idunit1;
$obat_id=$_REQUEST['obat_id'];
$kepemilikan_id=$_REQUEST['kepemilikan_id'];
$idminmax=$_REQUEST['idminmax'];
$smin=$_REQUEST['smin'];
$smax=$_REQUEST['smax'];
$kelas=$_REQUEST['kelas'];if ($kelas=="") $fkelas=""; else $fkelas=" AND kls.KLS_KODE LIKE '".$kelas."%'";
$golongan=$_REQUEST['golongan'];if ($golongan=="") $fgolongan=""; else $fgolongan=" AND ao.OBAT_GOLONGAN='$golongan'";
$jenis=$_REQUEST['jenis'];if ($jenis=="") $fjenis=""; else $fjenis=" AND ao.OBAT_KELOMPOK=$jenis";
$kategori=$_REQUEST['kategori'];if ($kategori=="") $fkategori=""; else $fkategori=" AND ao.OBAT_KATEGORI=$kategori";
$stok_S = $_REQUEST['stok_S'];

$date_skr=explode('-',$tgl);


$cmbBln = $_REQUEST['cmbBln'];
$cmbThn = $_REQUEST['cmbThn'];

if(!isset($cmbBln))
{
	$cmbBln = $date_skr[1];
	$cmbThn = $date_skr[2];
}
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="ao.OBAT_NAMA,ak.ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

switch ($act){
	case "save":
		if ($idminmax!=""){
			if ($idminmax=="0")
				$sql="insert into a_min_max_stok(obat_id,kepemilikan_id,unit_id,min_stok,max_stok) VALUES($obat_id,$kepemilikan_id,$idunit,$smin,$smax)";
			else
				$sql="update a_min_max_stok set min_stok=$smin,max_stok=$smax where min_max_id=$idminmax";
			$rs=mysqli_query($konek,$sql);
		}
		break;
	case "edit":
		if ($stok1>$stok){
			$selisih=$stok1-$stok;
			$sql="select * from a_penerimaan where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id and UNIT_ID_TERIMA=$idunit and QTY_STOK>0 order by TANGGAL,ID";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			$ok="false";
			while (($rows=mysqli_fetch_array($rs)) && ($ok=="false")){
				$qty=$rows["QTY_STOK"];
				$cid=$rows["ID"];
				if ($qty>$selisih){
					$ok=="true";
					$sql="update a_penerimaan set QTY_STOK=QTY_STOK-$selisih where ID=$cid";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);					
				}else{
					$selisih=$selisih-$qty;
					$sql="update a_penerimaan set QTY_STOK=0 where ID=$cid";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);										
				}
			}
		}else{
			$selisih=$stok-$stok1;
			$sql="select * from a_penerimaan where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id and UNIT_ID_TERIMA=$idunit and QTY_STOK>0 order by TANGGAL,ID desc limit 1";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			if ($rows=mysqli_fetch_array($rs)){
				$cid=$rows["ID"];
				$sql="update a_penerimaan set QTY_STOK=QTY_STOK+$selisih where ID=$cid";
				//echo $sql;
				$rs1=mysqli_query($konek,$sql);					
			}
		}
		break;
}
//Aksi Save, Edit, Delete Berakhir ============================================

$date_now=gmdate('d-m-Y',mktime(date('H')+7));
$date_skr=explode('-',$date_now);
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />

<script>
	function PrintArea(idArea,fileTarget){
	//alert(document.getElementById('cmbBln').options[document.getElementById('cmbBln').options.selectedIndex].lang);
	document.getElementById("bln").innerHTML = document.getElementById('cmbBln').options[document.getElementById('cmbBln').options.selectedIndex].lang;
	document.getElementById("thn").innerHTML = document.getElementById("cmbThn").value;
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(idArea).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	//winpopup.print();
	//winpopup.close();
}

function setBln(){
	document.getElementById('cmbBln').innerHTML =
			'<option value="01" lang="Januari">Januari</option>'+
			'<option value="02" lang="Februari">Februari</option>'+
			'<option value="03" lang="Maret">Maret</option>'+
			'<option value="04" lang="April">April</option>'+
			'<option value="05" lang="Mei">Mei</option>'+
			'<option value="06" lang="Juni">Juni</option>'+
			'<option value="07" lang="Juli">Juli</option>'+
			'<option value="08" lang="Agustus">Agustus</option>'+
			'<option value="09" lang="September">September</option>'+
			'<option value="10" lang="Oktober">Oktober</option>'+
			'<option value="11" lang="Nopember">Nopember</option>'+
			'<option value="12" lang="Desember">Desember</option>';
			var thSkr='<?php echo $date_skr[2];?>';
			var thAwal=thSkr*1-5;
			var thAkhir=thSkr*1+6;
			for(thAwal;thAwal<thAkhir;thAwal++)
			{				
				document.getElementById('cmbThn').innerHTML = 
				document.getElementById('cmbThn').innerHTML+'<option value='+thAwal+'>'+thAwal+'</option>';
			}
			
			document.getElementById('cmbBln').value = '<?php echo $cmbBln;?>';	
			document.getElementById('cmbThn').value = '<?php echo $cmbThn;?>';
			//document.getElementById('cmbThn').value = thSkr;
			
}

			
</script>

</head>
<body onLoad="setBln()">
<script language="javascript">
var win = null;
function NewWindow(mypage,myname,w,h,scroll){
LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings =
'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
win = window.open(mypage,myname,settings)
}
</script>

<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
  <input name="idminmax" id="idminmax" type="hidden" value="">
  <input name="smin" id="smin" type="hidden" value="">
  <input name="smax" id="smax" type="hidden" value="">
  <input name="obat_id" id="obat_id" type="hidden" value="">
  <input name="kepemilikan_id" id="kepemilikan_id" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
    <div id="listma" style="display:block">
<p><span class="jdltable">LAPORAN PENERIMAAN DAN LEMBAR PEMAKAIAN OBAT <br> (LPLPO) <br></span> 
      <table>
        <tr> 
          <td align="center" class="txtinput">Unit </td>
          <td align="center" class="txtinput">: 
            <select name="idunit" id="idunit" class="txtinput" onChange="location='?f=../transaksi/LPLPO.php&id_unit='+idunit.value+'&kelas='+kelas.value+'&cmbBln='+cmbBln.value+'&cmbThn='+cmbThn.value">
              <?php
		  $qry="select * from a_unit where UNIT_TIPE<>3 and UNIT_TIPE<>4 and UNIT_TIPE<>7 and UNIT_ISAKTIF=1";
		  $exe=mysqli_query($konek,$qry);
		  $i=0;
		  while($show=mysqli_fetch_array($exe)){ 
		  	$i++;
			if (($idunit=="")&&($i==1)) $idunit=$show['UNIT_ID'];
		  ?>
              <option value="<?=$show['UNIT_ID'];?>" class="txtinput"<?php if ($idunit==$show['UNIT_ID']) {echo "selected"; $nunit1=$show['UNIT_NAME'];}?>> 
              <?php echo $show['UNIT_NAME'];?></option>
              <? }?>
            </select></td>
        </tr>
        <tr> 
          <td align="center" class="txtinput">Kelas </td>
          <td align="center" class="txtinput">: 
            <select name="kelas" id="kelas" class="txtinput" onChange="location='?f=../transaksi/LPLPO.php&id_unit='+idunit.value+'&kelas='+kelas.value+'&cmbBln='+cmbBln.value+'&cmbThn='+cmbThn.value">
              <option value="" class="txtinput"<?php if ($kelas=="") echo " selected";?>>SEMUA</option>
              <?
			  $k1="SEMUA";
		  $qry="SELECT * FROM a_kelas ORDER BY KLS_KODE";
		  $exe=mysqli_query($konek,$qry);
		  while($show=mysqli_fetch_array($exe)){ 
		  	$lvl=$show["KLS_LEVEL"];
			$tmp="";
			for ($i=1;$i<$lvl;$i++) $tmp .="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$tmp .=$show['KLS_NAMA'];
		  ?>
              <option value="<?=$show['KLS_KODE'];?>" class="txtinput"<?php if ($kelas==$show['KLS_KODE']){echo " selected";$k1=$show['KLS_NAMA'];}?>><?php echo $tmp;?></option>
              <? }?>
            </select></td>
        </tr>
		<tr>
			<td align="center" class="txtinput">Periode</td>
			<td align="center" class="txtinput">:
				<select class="txtinput" id="cmbBln" name="cmbBln" onChange="location='?f=../transaksi/LPLPO.php&id_unit='+idunit.value+'&kelas='+kelas.value+'&cmbBln='+cmbBln.value+'&cmbThn='+cmbThn.value"><option></option></select>&nbsp;<select class="txtinput" id="cmbThn" name="cmbThn" onChange="location='?f=../transaksi/LPLPO.php&id_unit='+idunit.value+'&kelas='+kelas.value+'&cmbBln='+cmbBln.value+'&cmbThn='+cmbThn.value">
				</select>
			</td>
		</tr>
		<tr id="sumberdana">
			<td align="center" class="txtinput">Sumber Dana</td>
			<td align="center" class="txtinput">:
				<select name="sumber_dana" id="sumber_dana" onChange="location='?f=../transaksi/stok_view.php&idunit='+idunit.value+'&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value+'&kategori='+kategori.value+'&stok_S='+stok_S.value+'&sumberdana='+sumber_dana.value">
					<option value="0" >SEMUA</option>
					<?php
						$sql = "SELECT sd.id, sd.nama, sd.tahun
								FROM a_penerimaan ap
								INNER JOIN a_sumber_dana sd
								   ON sd.id = ap.SUMBER_DANA
								GROUP BY ap.SUMBER_DANA
								ORDER BY sd.nama ASC";
						$query = mysqli_query($konek,$sql);
						while($data = mysqli_fetch_object($query)){
							if($_REQUEST['sumberdana']==$data->id){
								$cek = "selected";
							} else {
								$cek = '';
							}
							echo "<option value='".$data->id."' {$cek} >".$data->nama." ".$data->tahun."</option>";
						}
						$sql = "";
					?>
				</select>
			</td>
		</tr>
		<script type="text/javascript">
			//alert(idunit.value);
			if(idunit.value != '1'){
				document.getElementById('sumberdana').style.display = "none";
			} else {
				
			}
		</script>
      </table>	  
      <table width="98%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td rowspan="2" width="30" height="25" class="tblheaderkiri">No</td>
          <td rowspan="2" id="OBAT_KODE" class="tblheader" onClick="ifPop.CallFr(this);">Nama Barang </td>
          <td rowspan="2" id="OBAT_KODE" class="tblheader" onClick="ifPop.CallFr(this);">Nama Generik </td>
          <td rowspan="2" id="OBAT_KODE" class="tblheader" onClick="ifPop.CallFr(this);">Satuan </td>
          <td rowspan="2" id="OBAT_NAMA" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Stok Awal </td>
          <td colspan="5" id="kategori" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Penerimaan</td>
          <td rowspan="2" id="NAMA" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Persediaan</td>
          <td rowspan="2" id="QTY_STOK" width="65" class="tblheader" onClick="ifPop.CallFr(this);">Pemakaian</td>
          <td rowspan="2" width="65" class="tblheader">Sisa Stok </td>
          <td rowspan="2" width="65" class="tblheader">Stok Opname </td>
          <td rowspan="2" id="nilai" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Ket</td>
        </tr>
        <tr class="headtable"> 
          <td width="50" height="25" class="tblheaderkiri">APBD</td>
          <td id="OBAT_KODE" class="tblheader">APBD-P</td>
          <td id="OBAT_KODE" class="tblheader">BLUD</td>
          <td id="OBAT_KODE" class="tblheader">LAIN</td>
          <td id="OBAT_KODE" class="tblheader">JUMLAH</td>
        </tr>
        <tr class="headtable"> 
          <td width="50" height="25" class="tblheaderkiri">1</td>
          <td id="OBAT_KODE" class="tblheader">2</td>
          <td id="OBAT_KODE" class="tblheader">3</td>
          <td id="OBAT_KODE" class="tblheader">4</td>
          <td id="OBAT_KODE" class="tblheader">5</td>
          <td id="OBAT_KODE" class="tblheader">6</td>
          <td id="OBAT_KODE" class="tblheader">7</td>
          <td id="OBAT_KODE" class="tblheader">8</td>
          <td id="OBAT_KODE" class="tblheader">9</td>
          <td id="OBAT_KODE" class="tblheader">10</td>
          <td id="OBAT_KODE" class="tblheader">11</td>
          <td id="OBAT_KODE" class="tblheader">12</td>
          <td id="OBAT_KODE" class="tblheader">13</td>
          <td id="OBAT_KODE" class="tblheader">14</td>
          <td id="OBAT_KODE" class="tblheader">15</td>
        </tr>
        <?php 
	  $jfilter="";
	  if ($filter!=""){
	  	$jfilter=$filter;
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  /*$sql="SELECT ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ak.ID,ak.NAMA,ap.QTY_STOK,ap.nilai 
FROM (SELECT OBAT_ID,KEPEMILIKAN_ID,SUM(QTY_STOK) AS QTY_STOK,IF(TIPE_TRANS=4,SUM(FLOOR(QTY_STOK*HARGA_BELI_SATUAN)),SUM(FLOOR((QTY_STOK*HARGA_BELI_SATUAN-(DISKON*QTY_STOK*HARGA_BELI_SATUAN/100)) * 1.1))) AS nilai 
FROM a_penerimaan WHERE UNIT_ID_TERIMA=$idunit AND STATUS=1 AND QTY_STOK>0 
GROUP BY OBAT_ID,KEPEMILIKAN_ID) AS ap INNER JOIN a_obat ao ON ap.OBAT_ID=ao.OBAT_ID INNER JOIN a_kepemilikan ak ON ap.KEPEMILIKAN_ID=ak.ID 
LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID WHERE ao.OBAT_ISAKTIF=1".$filter.$fkelas.$fgolongan.$fjenis.$fkategori." 
ORDER BY ".$sorting;*/
		$fil = " AND ap.QTY_STOK<>0";
		if($_REQUEST['stok_S']=='0'){
			$fil = " AND ap.QTY_STOK=0";
		}
		if($_REQUEST['idunit']!='1' || $_REQUEST['sumberdana']=='0'){
			$sumber_dana = "";
			$sd = "";
		} else {
			$sumber_dana = " AND sd.id = ".$_REQUEST['sumberdana'];
			$sd = " AND SUMBER_DANA = ".$_REQUEST['sumberdana'];
		}
		
	  /*$sql="SELECT ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ok.kategori,ak.ID,ak.NAMA,ap.QTY_STOK,ap.nilai 
FROM (SELECT OBAT_ID,KEPEMILIKAN_ID,SUM(QTY_STOK) AS QTY_STOK,SUM(IF(((TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100) OR (NILAI_PAJAK<=0)),(/* FLOOR (QTY_STOK*HARGA_BELI_SATUAN * (1 - (`DISKON` / 100)))),(/* FLOOR((QTY_STOK*HARGA_BELI_SATUAN-(DISKON*QTY_STOK*HARGA_BELI_SATUAN/100)) * 1.1)))) AS nilai, SUMBER_DANA 
FROM a_penerimaan WHERE UNIT_ID_TERIMA=$idunit AND STATUS=1 AND QTY_STOK>=0 {$sd} 
GROUP BY OBAT_ID,KEPEMILIKAN_ID) AS ap INNER JOIN a_obat ao ON ap.OBAT_ID=ao.OBAT_ID INNER JOIN a_kepemilikan ak ON ap.KEPEMILIKAN_ID=ak.ID 
LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID
LEFT JOIN a_obat_kategori ok ON ok.id = ao.OBAT_KATEGORI
LEFT JOIN a_sumber_dana sd ON sd.id = ap.SUMBER_DANA
WHERE ao.OBAT_ISAKTIF=1".$fil.$filter.$fkelas.$fgolongan.$fjenis.$fkategori.$sumber_dana." 
ORDER BY ".$sorting;*/
		
		$sql="SELECT ao.OBAT_NAMA,ak.NAMA,ok.kategori,ao.obat_satuan_kecil,arpt.* 
FROM (SELECT * FROM a_rpt_mutasi WHERE BULAN=$cmbBln AND TAHUN=$cmbThn AND UNIT_ID=$idunit) AS arpt 
INNER JOIN (SELECT * FROM a_obat WHERE OBAT_ISAKTIF=1) ao ON arpt.OBAT_ID=ao.OBAT_ID 
INNER JOIN a_kepemilikan ak ON arpt.KEPEMILIKAN_ID=ak.ID 
LEFT JOIN a_kelas kls ON ao.KLS_ID=kls.KLS_ID  
LEFT JOIN a_obat_kategori ok ON ok.id = ao.OBAT_KATEGORI
ORDER BY ao.OBAT_NAMA,ak.ID";
		
		//echo $sql;
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql2=$sql." limit $tpage,$perpage";

		//echo $sql2."-".$jmldata;
		
	  $rs=mysqli_query($konek,$sql2);
	  $i=($page-1)*$perpage;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		
		$sql11="SELECT tmp.OBAT_ID,tmp.KEPEMILIKAN_ID,STOK_AFTER AS QTY_AKHIR,NILAI_TOTAL AS NILAI_AKHIR,
				SUM(IF (ap.SUMBER_DANA=1,IF (DEBET IS NULL,0,DEBET),0)) AS SAPBD, 
				SUM(IF (ap.SUMBER_DANA=6,IF (DEBET IS NULL,0,DEBET),0)) AS SAPBDP,
				SUM(IF (ap.SUMBER_DANA=7,IF (DEBET IS NULL,0,DEBET),0)) AS SBLUD, 
				SUM(IF (ap.SUMBER_DANA NOT IN (1,6,7),IF (DEBET IS NULL,0,DEBET),0)) AS SLAIN, 
				SUM(IF ((tipetrans=6 OR tipetrans=7),IF (KREDIT IS NULL,0,IF(KREDIT=0,0,KREDIT * -1)),0)) AS rt_in,
				SUM(IF (((tipetrans=6 OR tipetrans=7) AND ap.SUMBER_DANA=1),IF (KREDIT IS NULL,0,IF(KREDIT=0,0,KREDIT * -1)),0)) AS rt_inAPBD,
				SUM(IF (((tipetrans=6 OR tipetrans=7) AND ap.SUMBER_DANA=6),IF (KREDIT IS NULL,0,IF(KREDIT=0,0,KREDIT * -1)),0)) AS rt_inAPBDP,
				SUM(IF (((tipetrans=6 OR tipetrans=7) AND ap.SUMBER_DANA=7),IF (KREDIT IS NULL,0,IF(KREDIT=0,0,KREDIT * -1)),0)) AS rt_inBLUD,
				SUM(IF (((tipetrans=6 OR tipetrans=7) AND ap.SUMBER_DANA NOT IN (1,6,7)),IF (KREDIT IS NULL,0,IF(KREDIT=0,0,KREDIT * -1)),0)) AS rt_inLain
				FROM (SELECT * FROM a_kartustok 
				WHERE UNIT_ID=$idunit AND TGL_ACT 
				BETWEEN '$cmbThn-$cmbBln-01' AND '$cmbThn-$cmbBln-31' AND tipetrans IN (0,1,2,6,7) AND obat_id='$rows[OBAT_ID]' ORDER BY TGL_ACT DESC,ID DESC) AS tmp
				LEFT JOIN a_penerimaan ap ON tmp.fkid=ap.ID LEFT JOIN a_sumber_dana asd ON ap.SUMBER_DANA = asd.id
				GROUP BY tmp.OBAT_ID,tmp.KEPEMILIKAN_ID";
				$rs11=mysqli_query($konek,$sql11);
				$rows11=mysqli_fetch_array($rs11);
				
				$inAPBD=$rows11['SAPBD']+$rows1['rt_inAPBD'];
				$inAPBDP=$rows11['SAPBDP']+$rows1['rt_inAPBDP'];
				$inBLUD=$rows11['SBLUD']+$rows1['rt_inBLUD'];
				$inLAIN=$rows11['SLAIN']+$rows1['rt_inLain'];
				$total=$inAPBD+$inAPBDP+$inBLUD+$inLAIN;
				
				$dataB[$i] = array(
					"no"=>$i,
					"nm1"=>$rows['OBAT_NAMA'],
					"nm2"=>$rows['OBAT_NAMA'],
					"satuan"=>$rows['obat_satuan_kecil'],
					"qty_awal"=>$rows['QTY_AWAL'],
					"inapbd"=>$inAPBD,
					"inapbdp"=>$inAPBDP,
					"inblud"=>$inBLUD,
					"inlain"=>$inLAIN,
					"stotal"=>$total,
					"gtotal"=>$total+$rows['QTY_AWAL'],
					"keluar"=>$rows['JUAL']+$rows['UNIT_OUT']+$rows['RETURN_OUT']+$rows['MILIK_OUT']+$rows['HAPUS'],
					"qty_akhir"=>$rows['QTY_AKHIR'],
					"adjust"=>$rows['ADJUST']
				);
	  ?>
      	<tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        	<td height="20" class="tdisikiri"><?php echo $i; ?></td>
            <td class="tdisi"><?php echo $rows['OBAT_NAMA']; ?></td>
            <td class="tdisi"><?php echo $rows['OBAT_NAMA']; ?></td>
            <td class="tdisi"><?php echo $rows['obat_satuan_kecil']; ?></td>
            <td class="tdisi"><?php echo $rows['QTY_AWAL']; ?></td>
            
            <td class="tdisi"><?php echo $inAPBD; ?></td>
            <td class="tdisi"><?php echo $inAPBDP; ?></td>
            <td class="tdisi"><?php echo $inBLUD; ?></td>
            <td class="tdisi"><?php echo $inLAIN; ?></td>
            <td class="tdisi"><?php echo $total; ?></td>
            <td class="tdisi"><?php echo $total+$rows['QTY_AWAL']; ?></td>
            
            <td class="tdisi"><?php echo $rows['JUAL']+$rows['UNIT_OUT']+$rows['RETURN_OUT']+$rows['MILIK_OUT']+$rows['HAPUS']; ?></td>
            <td class="tdisi"><?php echo $total+$rows['QTY_AWAL']-($rows['JUAL']+$rows['UNIT_OUT']+$rows['RETURN_OUT']+$rows['MILIK_OUT']+$rows['HAPUS'])+$rows['ADJUST']; ?></td>
            <td class="tdisi"><?php echo $rows['ADJUST']; ?></td>
            <td class="tdisi">&nbsp;</td>
        </tr>
        <!--<tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td height="20" class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi"><?php echo $rows['kategori']; ?></td>
          <td class="tdisi"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi"><a href="../master/kartu_stok.php?obat_id=<?php echo $cid;?>&kepemilikan_id=<?php echo $ckpid;?>&unit_id=<?php echo $idunit; ?>" onClick="NewWindow(this.href,'name','900','500','yes');return false"><?php echo $rows['QTY_STOK'];?></a></td>
          <td class="tdisi"><span title="Klik Untuk Mengubah Data Stok Minimum" class="minmax" onClick="<?php if ($idunit==$idunit1){?>var vsmin = prompt('Masukkan Stok Minimum', '<?php echo $stokmin; ?>');if (vsmin!=null){document.getElementById('idminmax').value='<?php echo $idminmax; ?>';document.getElementById('smin').value=vsmin;document.getElementById('smax').value='<?php echo $stokmax; ?>';document.getElementById('kepemilikan_id').value='<?php echo $ckpid; ?>';document.getElementById('obat_id').value='<?php echo $cid; ?>';document.forms[0].submit();}<?php }else{?>alert('Anda Tidak Boleh Mengubah Data Stok Minimum Unit Lain');<?php }?>"><?php echo $stokmin;?></span></td>
          <td class="tdisi"><span title="Klik Untuk Mengubah Data Stok Minimum" class="minmax" onClick="<?php if ($idunit==$idunit1){?>var vsmax = prompt('Masukkan Stok Maximum', '<?php echo $stokmax; ?>');if (vsmax!=null){document.getElementById('idminmax').value='<?php echo $idminmax; ?>';document.getElementById('smin').value='<?php echo $stokmin; ?>';document.getElementById('smax').value=vsmax;document.getElementById('kepemilikan_id').value='<?php echo $ckpid; ?>';document.getElementById('obat_id').value='<?php echo $cid; ?>';document.forms[0].submit();}<?php }else{?>alert('Anda Tidak Boleh Mengubah Data Stok Maximum Unit Lain');<?php }?>"><?php echo $stokmax;?></span></td>
          <td class="tdisi" align="right"><?php echo number_format($rows['nilai'],0,",",".");?></td>
        </tr>-->
        <?php 
	  }
	  $ntotal=0;
	  //$sql2="select if (sum(p2.nilai) is null,0,sum(p2.nilai)) as ntotal from (".$sql.") as p2";
	  //echo $sql2."<br>";
	  //$rs=mysqli_query($konek,$sql2);
	  //if ($rows=mysqli_fetch_array($rs)) $ntotal=$rows['ntotal'];
	  //mysqli_free_result($rs);
	  ?>
        <!--<tr> 
          <td colspan="12" class="txtright"><strong>Nilai Total :</strong></td>
          <td align="right" class="txtright"><strong><?php echo number_format($ntotal,0,",","."); ?></strong></td>
        </tr>-->
        <tr> 
          <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="8" align="left"><div align="left" class="textpaging">Ke Halaman:
		  <input type="text" name="keHalaman" id="keHalaman" class="txtcenter" size="2" autocomplete="off">
		  <button type="button" style="cursor:pointer" onClick="act.value='paging';page.value=+keHalaman.value;document.form1.submit();"><IMG SRC="../icon/go.png" border="0" width="10" height="15" ALIGN="absmiddle"></button></div></td>
          <td colspan="5" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
          </td>
        </tr>
        <tr> 
          <td colspan="16" align="center"> <BUTTON type="button" onClick='PrintArea("idArea","#")' <?php  if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle" onClick="document.getElementById('idArea').style.display='block'">&nbsp;Cetak 
            Stok </BUTTON>&nbsp;<BUTTON type="button" <?php  if($jmldata==0) echo "disabled='disabled'"; ?> onClick="OpenWnd('../transaksi/stok_view_Excell.php?filter=<?php echo $jfilter; ?>&sorting=<?php echo $sorting; ?>&idunit=<?php echo $idunit; ?>&nunit1=<?php echo $nunit1; ?>&kelas=<?php echo $kelas; ?>&golongan=<?php echo $golongan; ?>&jenis=<?php echo $jenis; ?>&kategori=<?php echo $kategori; ?>&k1=<?php echo $k1; ?>&g1=<?php echo $g1; ?>&j1=<?php echo $j1; ?>&f1=<?php echo $f1; ?>&stok_S=<?php echo $stok_S; ?>',600,450,'childwnd',true);"><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export ke File Excell</BUTTON></td>
        </tr>
      </table>
    </div>
	<div id="idArea" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
<p align="center"><span class="jdltable">LAPORAN PENERIMAAN DAN LEMBAR PEMAKAIAN OBAT <br> (LPLPO)</span> 
		
      <table width="1450" cellpadding="0" cellspacing="0" style="padding-left:10px">
        <tr> 
          <td align="left" width="10%" class="txtinput">Nama Instalasi </td>
          <td align="left" class="txtinput">: <?php echo $nunit1; ?></td>
          <td align="right" width="10%" class="txtinput">Bulan </td>
          <td align="right" class="txtinput">: <span id="bln"></span></td>
        </tr>
        <tr> 
          <td align="left" class="txtinput">Nama Rumah Sakir </td>
          <td align="left" class="txtinput">: RSUD KOTA TANGERANG</td>
          <td align="right" width="10%" class="txtinput">Tahun </td>
          <td align="right" class="txtinput">: <span id="thn">1</span></td>
        </tr>
        <tr> 
          <td align="left" class="txtinput">Kota </td>
          <td align="left" class="txtinput">: TANGERANG</td>
          <td align="right" width="10%" class="txtinput">&nbsp; </td>
          <td align="right" class="txtinput">&nbsp;</td>
        </tr>
        <tr> 
          <td align="left" class="txtinput">Propinsi </td>
          <td align="left" class="txtinput">: BANTEN</td>
          <td align="right" width="10%" class="txtinput">&nbsp; </td>
          <td align="right" class="txtinput">&nbsp;</td>
        </tr>
      </table>
      <table width="98%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td rowspan="2" width="30" height="25" class="tblheaderkiri">No</td>
          <td rowspan="2" id="OBAT_KODE" class="tblheader" onClick="ifPop.CallFr(this);">Nama Barang </td>
          <td rowspan="2" id="OBAT_KODE" class="tblheader" onClick="ifPop.CallFr(this);">Nama Generik </td>
          <td rowspan="2" id="OBAT_KODE" class="tblheader" onClick="ifPop.CallFr(this);">Satuan </td>
          <td rowspan="2" id="OBAT_NAMA" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Stok Awal </td>
          <td colspan="5" id="kategori" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Penerimaan</td>
          <td rowspan="2" id="NAMA" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Persediaan</td>
          <td rowspan="2" id="QTY_STOK" width="65" class="tblheader" onClick="ifPop.CallFr(this);">Pemakaian</td>
          <td rowspan="2" width="65" class="tblheader">Sisa Stok </td>
          <td rowspan="2" width="65" class="tblheader">Stok Opname </td>
          <td rowspan="2" id="nilai" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Ket</td>
        </tr>
        <tr class="headtable"> 
          <td width="50" height="25" class="tblheaderkiri">APBD</td>
          <td id="OBAT_KODE" class="tblheader">APBD-P</td>
          <td id="OBAT_KODE" class="tblheader">BLUD</td>
          <td id="OBAT_KODE" class="tblheader">LAIN</td>
          <td id="OBAT_KODE" class="tblheader">JUMLAH</td>
        </tr>
        <tr class="headtable"> 
          <td width="50" height="25" class="tblheaderkiri">1</td>
          <td id="OBAT_KODE" class="tblheader">2</td>
          <td id="OBAT_KODE" class="tblheader">3</td>
          <td id="OBAT_KODE" class="tblheader">4</td>
          <td id="OBAT_KODE" class="tblheader">5</td>
          <td id="OBAT_KODE" class="tblheader">6</td>
          <td id="OBAT_KODE" class="tblheader">7</td>
          <td id="OBAT_KODE" class="tblheader">8</td>
          <td id="OBAT_KODE" class="tblheader">9</td>
          <td id="OBAT_KODE" class="tblheader">10</td>
          <td id="OBAT_KODE" class="tblheader">11</td>
          <td id="OBAT_KODE" class="tblheader">12</td>
          <td id="OBAT_KODE" class="tblheader">13</td>
          <td id="OBAT_KODE" class="tblheader">14</td>
          <td id="OBAT_KODE" class="tblheader">15</td>
        </tr>
        <?php 
	  //echo $sql;
		$rs=mysqli_query($konek,$sql);
	  	$i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
		
		$sql11="SELECT tmp.OBAT_ID,tmp.KEPEMILIKAN_ID,STOK_AFTER AS QTY_AKHIR,NILAI_TOTAL AS NILAI_AKHIR,
				SUM(IF (ap.SUMBER_DANA=1,IF (DEBET IS NULL,0,DEBET),0)) AS SAPBD, 
				SUM(IF (ap.SUMBER_DANA=6,IF (DEBET IS NULL,0,DEBET),0)) AS SAPBDP,
				SUM(IF (ap.SUMBER_DANA=7,IF (DEBET IS NULL,0,DEBET),0)) AS SBLUD, 
				SUM(IF (ap.SUMBER_DANA NOT IN (1,6,7),IF (DEBET IS NULL,0,DEBET),0)) AS SLAIN, 
				SUM(IF ((tipetrans=6 OR tipetrans=7),IF (KREDIT IS NULL,0,IF(KREDIT=0,0,KREDIT * -1)),0)) AS rt_in,
				SUM(IF (((tipetrans=6 OR tipetrans=7) AND ap.SUMBER_DANA=1),IF (KREDIT IS NULL,0,IF(KREDIT=0,0,KREDIT * -1)),0)) AS rt_inAPBD,
				SUM(IF (((tipetrans=6 OR tipetrans=7) AND ap.SUMBER_DANA=6),IF (KREDIT IS NULL,0,IF(KREDIT=0,0,KREDIT * -1)),0)) AS rt_inAPBDP,
				SUM(IF (((tipetrans=6 OR tipetrans=7) AND ap.SUMBER_DANA=7),IF (KREDIT IS NULL,0,IF(KREDIT=0,0,KREDIT * -1)),0)) AS rt_inBLUD,
				SUM(IF (((tipetrans=6 OR tipetrans=7) AND ap.SUMBER_DANA NOT IN (1,6,7)),IF (KREDIT IS NULL,0,IF(KREDIT=0,0,KREDIT * -1)),0)) AS rt_inLain
				FROM (SELECT * FROM a_kartustok 
				WHERE UNIT_ID=$idunit AND TGL_ACT 
				BETWEEN '$cmbThn-$cmbBln-01' AND '$cmbThn-$cmbBln-31' AND tipetrans IN (0,1,2,6,7) AND obat_id='$rows[OBAT_ID]' ORDER BY TGL_ACT DESC,ID DESC) AS tmp
				LEFT JOIN a_penerimaan ap ON tmp.fkid=ap.ID LEFT JOIN a_sumber_dana asd ON ap.SUMBER_DANA = asd.id
				GROUP BY tmp.OBAT_ID,tmp.KEPEMILIKAN_ID";
				$rs11=mysqli_query($konek,$sql11);
				$rows11=mysqli_fetch_array($rs11);
				
				$inAPBD=$rows11['SAPBD']+$rows1['rt_inAPBD'];
				$inAPBDP=$rows11['SAPBDP']+$rows1['rt_inAPBDP'];
				$inBLUD=$rows11['SBLUD']+$rows1['rt_inBLUD'];
				$inLAIN=$rows11['SLAIN']+$rows1['rt_inLain'];
				$total=$inAPBD+$inAPBDP+$inBLUD+$inLAIN;
		
	  ?>
        <!--<tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td height="20" align="center" class="tdisikiri" style="font-size:12px;"><?php echo $i; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $rows['kategori']; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $rows['QTY_STOK'];?></td>
          <td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($rows['nilai'],0,",",".");?></td>
        </tr>-->
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        	<td height="20" class="tdisikiri"><?php echo $i; ?></td>
            <td class="tdisi"><?php echo $rows['OBAT_NAMA']; ?></td>
            <td class="tdisi"><?php echo $rows['OBAT_NAMA']; ?></td>
            <td class="tdisi"><?php echo $rows['obat_satuan_kecil']; ?></td>
            <td class="tdisi"><?php echo $rows['QTY_AWAL']; ?></td>
            
            <td class="tdisi"><?php echo $inAPBD; ?></td>
            <td class="tdisi"><?php echo $inAPBDP; ?></td>
            <td class="tdisi"><?php echo $inBLUD; ?></td>
            <td class="tdisi"><?php echo $inLAIN; ?></td>
            <td class="tdisi"><?php echo $total; ?></td>
            <td class="tdisi"><?php echo $total+$rows['QTY_AWAL']; ?></td>
            
            <td class="tdisi"><?php echo $rows['JUAL']+$rows['UNIT_OUT']+$rows['RETURN_OUT']+$rows['MILIK_OUT']+$rows['HAPUS']; ?></td>
            <td class="tdisi"><?php echo $rows['QTY_AKHIR']; ?></td>
            <td class="tdisi"><?php echo $rows['ADJUST']; ?></td>
            <td class="tdisi">&nbsp;</td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="14" class="txtright"><strong>Nilai Total :</strong></td>
          <td align="right" class="txtright"><strong><?php echo number_format($ntotal,0,",","."); ?></strong></td>
        </tr>
        
        <tr> 
          <td colspan="15" class="txtright">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="4" class="txtinput">Yang Menerima Laporan,</td>
          <td colspan="8" class="txtinput" align="center" style="text-align:center"> Mengetahui,</td>
          <td colspan="3" class="txtinput">Tangerang, <? echo $tglctk;?></td>
        </tr>
        <tr> 
          <td colspan="4" class="txtinput">Ka. Bidang Pelayanan Penunjang</td>
          <td colspan="8" class="txtinput" align="center" style="text-align:center">Kepala Instalasi </td>
          <td colspan="3" class="txtinput">Penanggung jawab Gudang Farmasi <br> RSUD Kota Tangerang</td>
        </tr>
        <tr> 
          <td colspan="15">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="15">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="15">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="4" class="txtinput">dr. H. Hery Suharyanto, MKM</td>
          <td colspan="8" class="txtinput" align="center" style="text-align:center">Laila Shafarina, S.Farm., Apt. </td>
          <td colspan="3" class="txtinput">Arman, S.Farm., Apt.</td>
        </tr>
        <tr> 
          <td colspan="4" class="txtinput">NIP. 19650508 199603 1 003</td>
          <td colspan="8" class="txtinput" align="center" style="text-align:center">NIP. 19790108 201101 2 001</td>
          <td colspan="3" class="txtinput">NIP. 19821013 201101 1 007</td>
        </tr>
	  </table>
	  </div>
</form>
</div>
</body>
<script>
function HProsen(a,b,c,d){
var e;
	//alert(b.value+'|'+c.value+'|'+d.value);
	if (a==1){
		e=b.value*c.value/100;
		d.value=(b.value)*1+e;
	}else if (a==2){
		e=((d.value)*1-(b.value)*1)*100/b.value;
		c.value=e;
	}
}
</script>
</html>
<?php 
mysqli_close($konek);
?>