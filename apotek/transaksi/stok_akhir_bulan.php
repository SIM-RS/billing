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
convert_var($idunit);

$obat_id=$_REQUEST['obat_id'];
$kepemilikan_id=$_REQUEST['kepemilikan_id'];
$idminmax=$_REQUEST['idminmax'];
$smin=$_REQUEST['smin'];
$smax=$_REQUEST['smax'];
convert_var($obat_id,$kepemilikan_id,$idminmax,$smin,$smax);

$bl=date('m');
$th = date("Y");
convert_var($bl,$th);

$bulan=$_REQUEST['bulan'];
$tahun=$_REQUEST['tahun'];
$unit=$_REQUEST['idunit'];
convert_var($bulan,$tahun,$unit);

if ($bulan==""){ $bln=$bl;$fbulan=" AND cs.bulan='$bl'"; }else{ $bln=$bulan;$fbulan=" AND cs.bulan='$bulan'";}
if ($tahun==""){ $thn=$th;$ftahun=" AND cs.tahun='$th'"; }else{ $thn=$tahun;$ftahun=" AND cs.tahun='$tahun'";}
if ($unit==""){ $funit=" AND cs.unit_id=$idunit1"; }else{ $funit=" AND cs.unit_id=$unit";}

convert_var($fbulan,$ftahun,$funit);

$kelas=$_REQUEST['kelas'];
$golongan=$_REQUEST['golongan'];
$jenis=$_REQUEST['jenis'];
$kategori=$_REQUEST['kategori'];
$bentuk=$_REQUEST['bentuk'];

convert_var($kelas,$golongan,$jenis,$kategori);

if ($kelas=="") $fkelas=""; else $fkelas=" AND kls.KLS_KODE LIKE '".$kelas."%'";
if ($golongan=="") $fgolongan=""; else $fgolongan=" AND ao.OBAT_GOLONGAN='$golongan'";
if ($jenis=="") $fjenis=""; else $fjenis=" AND ao.OBAT_KELOMPOK=$jenis";
if ($kategori=="") $fkategori=""; else $fkategori=" AND ao.OBAT_KATEGORI=$kategori";
if ($bentuk=="") $fbentuk=""; else $fbentuk=" AND ao.OBAT_BENTUK='$bentuk'";


convert_var($fkelas,$fgolongan,$fjenis,$fkategori);
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="ao.OBAT_NAMA,ak.NAMA";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
convert_var($page,$sorting,$filter,$act);
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
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<script>
	function PrintArea(idArea,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(idArea).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
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
<p><span class="jdltable">DAFTAR STOK AKHIR BULAN OBAT / ALKES</span> 
      <table>
        <tr> 
          <td align="center" class="txtinput">Akhir Bulan</td>
          <td align="center" class="txtinput">: 
            <select name="bulan" id="bulan" class="txtinput" onChange="location='?f=../transaksi/stok_akhir_bulan.php&idunit='+idunit.value+'&bulan='+bulan.value+'&tahun='+tahun.value+'&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value+'&kategori='+kategori.value+'&bentuk='+bentuk.value">
              <option value="01" class="txtinput" <?php if($bln=='01'){ echo "selected"; $tBln = "Januari"; } ?> >Januari</option>
              <option value="02" class="txtinput" <?php if($bln=='02'){ echo "selected"; $tBln = "Februari"; } ?> >Februari</option>
              <option value="03" class="txtinput" <?php if($bln=='03'){ echo "selected"; $tBln = "Maret"; } ?> >Maret</option>
              <option value="04" class="txtinput" <?php if($bln=='04'){ echo "selected"; $tBln = "April"; } ?> >April</option>
              <option value="05" class="txtinput" <?php if($bln=='05'){ echo "selected"; $tBln = "Mei"; } ?> >Mei</option>
              <option value="06" class="txtinput" <?php if($bln=='06'){ echo "selected"; $tBln = "Juni"; } ?> >Juni</option>
              <option value="07" class="txtinput" <?php if($bln=='07'){ echo "selected"; $tBln = "Juli"; } ?> >Juli</option>
              <option value="08" class="txtinput" <?php if($bln=='08'){ echo "selected"; $tBln = "Agustus"; } ?> >Agustus</option>
              <option value="09" class="txtinput" <?php if($bln=='09'){ echo "selected"; $tBln = "September"; } ?> >September</option>
              <option value="10" class="txtinput" <?php if($bln=='10'){ echo "selected"; $tBln = "Oktober"; } ?> >Oktober</option>
              <option value="11" class="txtinput" <?php if($bln=='11'){ echo "selected"; $tBln = "Nopember"; } ?> >Nopember</option>
              <option value="12" class="txtinput" <?php if($bln=='12'){ echo "selected"; $tBln = "Desember"; } ?> >Desember</option>
            </select>
            &nbsp;
            <select name="tahun" id="tahun" class="txtinput" onChange="location='?f=../transaksi/stok_akhir_bulan.php&idunit='+idunit.value+'&bulan='+bulan.value+'&tahun='+tahun.value+'&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value+'&kategori='+kategori.value+'&bentuk='+bentuk.value">
              <?php
			  for($i=$th-5;$i<=$th;$i++){
			  ?>
              <option value="<?php echo $i; ?>" class="txtinput" <?php if($thn==$i){ echo "selected"; } ?> ><?php echo $i; ?></option>
              <?php
			  }
			  ?>
            </select></td>
        </tr>
        <tr> 
          <td align="center" class="txtinput">Unit </td>
          <td align="center" class="txtinput">: 
            <select name="idunit" id="idunit" class="txtinput" onChange="location='?f=../transaksi/stok_akhir_bulan.php&idunit='+idunit.value+'&bulan='+bulan.value+'&tahun='+tahun.value+'&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value+'&kategori='+kategori.value+'&bentuk='+bentuk.value">
              <option value="0" class="txtinput">ALL UNIT</option>
              <?php
		  $qry="select * from a_unit where UNIT_TIPE<>3 and UNIT_TIPE<>4 and UNIT_TIPE<>7 and UNIT_TIPE<>8 and UNIT_ISAKTIF=1 AND UNIT_ID NOT IN(8,9)";
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
            <select name="kelas" id="kelas" class="txtinput" onChange="location='?f=../transaksi/stok_akhir_bulan.php&idunit='+idunit.value+'&bulan='+bulan.value+'&tahun='+tahun.value+'&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value+'&kategori='+kategori.value+'&bentuk='+bentuk.value">
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
          <td align="center" class="txtinput">Kategori</td>
          <td align="center" class="txtinput">:
            <select name="kategori" id="kategori" class="txtinput" onChange="location='?f=../transaksi/stok_akhir_bulan.php&idunit='+idunit.value+'&bulan='+bulan.value+'&tahun='+tahun.value+'&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value+'&kategori='+kategori.value+'&bentuk='+bentuk.value">
            <option value="" class="txtinput"<?php if ($kategori==""){echo " selected";$f1="SEMUA";}?>>SEMUA</option>
              <?php 
			  $j1="SEMUA";
			  $sql="select * from a_obat_kategori";
			  $rs=mysqli_query($konek,$sql);
			  while ($rows=mysqli_fetch_array($rs)){
			  ?>
              <option value="<?php echo $rows['id']; ?>" class="txtinput"<?php if ($kategori==$rows['id']){echo " selected";$f1=$rows['kategori'];}?>><?php echo $rows['kategori']; ?></option>
              <?php }?>
            </select></td>
        </tr>
        <tr> 
          <td align="center" class="txtinput">Golongan </td>
          <td align="center" class="txtinput">: 
            <select name="golongan" id="golongan" class="txtinput" onChange="location='?f=../transaksi/stok_akhir_bulan.php&idunit='+idunit.value+'&bulan='+bulan.value+'&tahun='+tahun.value+'&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value+'&kategori='+kategori.value+'&bentuk='+bentuk.value">
              <option value="" class="txtinput"<?php if ($golongan==""){echo " selected";$g1="SEMUA";}?>>SEMUA</option>
              <option value="N" class="txtinput"<?php if ($golongan=="N"){echo " selected";$g1="Narkotika";}?>>Narkotika</option>
              <option value="P" class="txtinput"<?php if ($golongan=="P"){echo " selected";$g1="Pethidine";}?>>Pethidine</option>
              <option value="M" class="txtinput"<?php if ($golongan=="M"){echo " selected";$g1="Morphine";}?>>Morphine</option>
              <option value="Psi" class="txtinput"<?php if ($golongan=="Psi"){echo " selected";$g1="Psikotropika";}?>>Psikotropika</option>
              <option value="B" class="txtinput"<?php if ($golongan=="B"){echo " selected";$g1="Obat Bebas";}?>>Obat 
              Bebas</option>
              <option value="BT" class="txtinput"<?php if ($golongan=="BT"){echo " selected";$g1="Bebas Terbatas";}?>>Bebas 
              Terbatas</option>
              <option value="K" class="txtinput"<?php if ($golongan=="K"){echo " selected";$g1="Obat Keras";}?>>Obat 
              Keras</option>
              <option value="AK" class="txtinput"<?php if ($golongan=="AK"){echo " selected";$g1="Alkes";}?>>Alkes</option>
            </select></td>
        </tr>
        <tr>
          <td align="center" class="txtinput">Bentuk</td>
          <td align="center" class="txtinput">: 
            <select name="bentuk" id="bentuk" class="txtinput" onChange="location='?f=../transaksi/stok_akhir_bulan.php&idunit='+idunit.value+'&bulan='+bulan.value+'&tahun='+tahun.value+'&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value+'&kategori='+kategori.value+'&bentuk='+bentuk.value">
              <option value="" class="txtinput"<?php if ($kategori==""){echo " selected";$f1="SEMUA";}?>>SEMUA</option>
              <?php 
			  $j1="SEMUA";
			  $sql="select * from a_bentuk";
			  $rs=mysqli_query($konek,$sql);
			  while ($rows=mysqli_fetch_array($rs)){
			  ?>
              <option value="<?php echo $rows['BENTUK']; ?>" class="txtinput"<?php if ($bentuk==$rows['BENTUK']){echo " selected";$f1=$rows['BENTUK'];}?>><?php echo $rows['BENTUK']; ?></option>
              <?php }?>
            </select></td>
        </tr>
        <tr> 
          <td align="center" class="txtinput">Jenis</td>
          <td align="center" class="txtinput">: 
            <select name="jenis" id="jenis" class="txtinput" onChange="location='?f=../transaksi/stok_akhir_bulan.php&idunit='+idunit.value+'&bulan='+bulan.value+'&tahun='+tahun.value+'&kelas='+kelas.value+'&golongan='+golongan.value+'&jenis='+jenis.value+'&kategori='+kategori.value+'&bentuk='+bentuk.value">
              <option value="" class="txtinput">SEMUA</option>
              <?php 
			  $j1="SEMUA";
			  $sql="select * from a_obat_jenis";
			  $rs=mysqli_query($konek,$sql);
			  while ($rows=mysqli_fetch_array($rs)){
			  ?>
			  <option value="<?php echo $rows['obat_jenis_id']; ?>" class="txtinput"<?php if ($jenis==$rows['obat_jenis_id']){echo " selected";$j1=$rows['obat_jenis'];}?>><?php echo $rows['obat_jenis']; ?></option>
              <?php }?>
            </select></td>
        </tr>
      </table>
      
      <?php 
	  if($idunit=='0'){
	  ?>
      <table width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="25" height="25" class="tblheaderkiri">No</td>
          <td class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Obat</td>
          <td width="100" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="unit1" width="36" class="tblheader">GD</td>
          <td id="unit2" width="36" class="tblheader">AP-RS</td>
          <!-- 
            Ismul 5/08/2019
          <td id="unit3" width="36" class="tblheader">AP-KR</td>
          <td id="unit4" width="36" class="tblheader">DP-BICT</td> -->
          <td id="unit12" width="36" class="tblheader">PR</td>
          <td id="unit17" width="36" class="tblheader">FS</td>
          <td id="total" width="41" class="tblheader">Total</td>
          <td id="ntotal" width="51" class="tblheader">Nilai</td>
        </tr>
        <?php 
		$jfilter="";
	  if ($filter!=""){
	  	$jfilter=$filter;
	  	$filter=explode("|",$filter);
	  	$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	/*$sql="SELECT 
  ao.OBAT_NAMA,
  ak.NAMA,
  SUM(IF(cs.unit_id = 1, cs.qty_stok, 0)) AS GD,
  SUM(IF(cs.unit_id = 2, cs.qty_stok, 0)) AS AP1,
  SUM(IF(cs.unit_id = 3, cs.qty_stok, 0)) AS AP2,
  SUM(IF(cs.unit_id = 4, cs.qty_stok, 0)) AS AP3,
  SUM(IF(cs.unit_id = 5, cs.qty_stok, 0)) AS AP4,
  SUM(IF(cs.unit_id = 6, cs.qty_stok, 0)) AS AP5,
  SUM(IF(cs.unit_id = 100, cs.qty_stok, 0)) AS AP6,
  SUM(IF(cs.unit_id = 101, cs.qty_stok, 0)) AS AP7,
  SUM(IF(cs.unit_id = 97, cs.qty_stok, 0)) AS AP8,
  SUM(IF(cs.unit_id = 11, cs.qty_stok, 0)) AS AP10,
  SUM(IF(cs.unit_id = 12, cs.qty_stok, 0)) AS AP11,
  SUM(IF(cs.unit_id = 17, cs.qty_stok, 0)) AS PR,
  SUM(IF(cs.unit_id = 20, cs.qty_stok, 0)) AS FS,
  SUM(cs.qty_stok) AS total,
  SUM(FLOOR(cs.nilai)) AS ntotal 
FROM
  a_rpt_current_stok cs 
  INNER JOIN a_obat ao 
    ON ao.OBAT_ID = cs.obat_id 
  INNER JOIN a_unit au 
    ON au.UNIT_ID = cs.unit_id 
  INNER JOIN a_kepemilikan ak 
    ON ak.ID = cs.kepemilikan_id
  LEFT JOIN a_kelas kls
    ON ao.KLS_ID=kls.KLS_ID 
WHERE  0=0 $fbulan $ftahun $filter $fkelas $fgolongan $fjenis $fkategori 
GROUP BY ao.OBAT_ID,
  ak.ID 
ORDER BY $sorting";*/
	$sql="SELECT 
  ao.OBAT_NAMA,
  ak.NAMA,
  SUM(IF(cs.unit_id = 12, cs.qty_akhir, 0)) AS GD,
  SUM(IF(cs.unit_id = 7, cs.qty_akhir, 0)) AS AP_RS,
  /*

  ISMUL 5/08/2019 
  SUM(IF(cs.unit_id = 8, cs.qty_akhir, 0)) AS AP_KR,
  SUM(IF(cs.unit_id = 9, cs.qty_akhir, 0)) AS AP_BICT,
  */
  SUM(IF(cs.unit_id = 16, cs.qty_akhir, 0)) AS PR,
  SUM(IF(cs.unit_id = 14, cs.qty_akhir, 0)) AS FS,
  
  SUM(cs.qty_akhir) total,
		  SUM(FLOOR(cs.nilai_akhir)) ntotal 
		FROM
		  a_rpt_mutasi cs 
  
  
  INNER JOIN a_obat ao 
    ON ao.OBAT_ID = cs.obat_id 
  INNER JOIN a_unit au 
    ON au.UNIT_ID = cs.unit_id 
  INNER JOIN a_kepemilikan ak 
    ON ak.ID = cs.kepemilikan_id
  LEFT JOIN a_kelas kls
    ON ao.KLS_ID=kls.KLS_ID 
WHERE  0=0 $fbulan $ftahun $filter $fkelas $fgolongan $fjenis $fkategori $fbentuk AND cs.UNIT_ID NOT IN(8,9)
GROUP BY ao.OBAT_ID,
  ak.ID 
ORDER BY $sorting";
	 //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql2=$sql." limit $tpage,$perpage";
	//echo $sql2;
	  $rs=mysqli_query($konek,$sql2);
	  $i=($page-1)*$perpage;
	  $arfvalue="";
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;		
		
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td align="left" class="tdisi"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi"><?php echo $rows['NAMA']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['GD']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['AP_RS']; ?></td>
          <!-- 
            Ismul 5/08/2019
          <td align="right" class="tdisi"><?php echo $rows['AP_KR']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['AP_BICT']; ?></td> -->
          <td align="right" class="tdisi"><?php echo $rows['PR']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['FS']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['total']; ?></td>
          <td align="right" class="tdisi"><?php echo number_format($rows['ntotal'],0,",","."); ?></td>
        </tr>
        <?php 
	  }
	  $jml_tot=0;
	  mysqli_free_result($rs);
	  //$sql2="select sum(ntotal) as jml_tot from vstokall as v,a_kepemilikan as m,a_obat as o where o.OBAT_ID=v.obat_id and m.ID=v.kepemilikan_id".$filter;
	  $sql2="select if (sum(p2.ntotal) is null,0,sum(p2.ntotal)) as jml_tot from (".$sql.") as p2";
	  //echo $sql2."<br>";
	  $rs=mysqli_query($konek,$sql2);
	  $show=mysqli_fetch_array($rs);
	  $jml_tot=$show['jml_tot'];
	  ?>
        <tr> 
          <td colspan="4"><span class="style1">Ket:GD=Gudang; AP=Apotik; PR=Produksi; 
            FS=Floor Stock;</span></td>
          <td colspan="4" align="right"><span class="style1"><strong>Nilai Total 
            :&nbsp;&nbsp;</strong></span></td>
          <td colspan="2" align="right"><span class="style1"><strong><?php echo number_format($jml_tot,0,",","."); ?></strong></span></td>
        </tr>
        <tr> 
          <td colspan="2" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="6" align="left"><div align="left" class="textpaging">Ke 
              Halaman: 
              <input type="text" name="keHalaman" id="keHalaman" class="txtcenter" size="2" autocomplete="off">
              <button type="button" style="cursor:pointer" onClick="act.value='paging';page.value=+keHalaman.value;document.form1.submit();"><IMG SRC="../icon/go.png" border="0" width="10" height="15" ALIGN="absmiddle"></button>
            </div></td>
          <td colspan="3" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;          </td>
        </tr>
        <tr> 
          <td colspan="11" align="center"><BUTTON type="button" onClick='PrintArea("idArea","#")' <?php  if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle" onClick="document.getElementById('idArea').style.display='block'">&nbsp;Cetak 
            Stok </BUTTON> <BUTTON type="button" <?php  if($jmldata==0) echo "disabled='disabled'"; ?> onClick="OpenWnd('../transaksi/stokall_akhir_bulan_Excell.php?filter=<?php echo $jfilter; ?>&sorting=<?php echo $sorting; ?>&idunit=<?php echo $idunit; ?>&nunit1=<?php echo $nunit1; ?>&bulan=<?php echo $bln; ?>&tbulan=<?php echo $tBln; ?>&tahun=<?php echo $thn; ?>&kelas=<?php echo $kelas; ?>&golongan=<?php echo $golongan; ?>&jenis=<?php echo $jenis; ?>&kategori=<?php echo $kategori; ?>',600,450,'childwnd',true);"><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export ke File Excell</BUTTON></td>
        </tr>
      </table>
      
      
      <?php
	  }else{
	  ?>
      
      	  
      <table width="98%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            Obat </td>
          <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Obat </td>
          <td id="NAMA" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="qty_stok" width="65" class="tblheader" onClick="ifPop.CallFr(this);">Stok</td>
          <td id="nilai" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Nilai</td>
        </tr>
        <?php 
	  $jfilter="";
	  if ($filter!=""){
	  	$jfilter=$filter;
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;

        $sql = "SELECT 
		  ao.OBAT_ID,
		  ao.OBAT_KODE,
		  ao.OBAT_NAMA,
		  ak.NAMA,
		  SUM(cs.qty_akhir) qty_stok,
		  SUM(FLOOR(cs.nilai_akhir)) nilai 
		FROM
		  a_rpt_mutasi cs 
		  INNER JOIN a_obat ao 
			ON ao.OBAT_ID = cs.obat_id 
		  INNER JOIN a_unit au 
			ON au.UNIT_ID = cs.unit_id 
		  INNER JOIN a_kepemilikan ak 
			ON ak.ID = cs.kepemilikan_id
		  LEFT JOIN a_kelas kls
            ON ao.KLS_ID=kls.KLS_ID 
		WHERE 0=0 $fbulan $ftahun $funit $filter $fkelas $fgolongan $fjenis $fkategori $fbentuk
		GROUP BY ao.OBAT_ID,ak.ID
		ORDER BY $sorting";
	//  echo $sql;
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql2=$sql." limit $tpage,$perpage";
      
	  $rs=mysqli_query($konek,$sql2);
	  $i=($page-1)*$perpage;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td height="20" class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi"><?php echo $rows['qty_stok'];?></td>
          <td class="tdisi" align="right"><?php echo number_format($rows['nilai'],0,",",".");?></td>
        </tr>
        <?php 
	  }
	  
	  $ntotal=0;
	  $sql2="select if (sum(p2.nilai) is null,0,sum(p2.nilai)) as ntotal from (".$sql.") as p2";
	  //echo $sql2."<br>";
	  $rs=mysqli_query($konek,$sql2);
	  if ($rows=mysqli_fetch_array($rs)) $ntotal=$rows['ntotal'];
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="5" class="txtright"><strong>Nilai Total :</strong></td>
          <td align="right" class="txtright"><strong><?php echo number_format($ntotal,0,",","."); ?></strong></td>
        </tr>
        <tr> 
          <td colspan="2" align="left"><div align="left" class="textpaging">&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="1" align="left"><div align="left" class="textpaging">Ke Halaman:
		  <input type="text" name="keHalaman" id="keHalaman" class="txtcenter" size="2" autocomplete="off">
		  <button type="button" style="cursor:pointer" onClick="act.value='paging';page.value=+keHalaman.value;document.form1.submit();"><IMG SRC="../icon/go.png" border="0" width="10" height="15" ALIGN="absmiddle"></button></div></td>
          <td colspan="3" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
          </td>
        </tr>
        <tr> 
          <td colspan="6" align="center"> <BUTTON type="button" onClick='PrintArea("idArea","#")' <?php  if($jmldata==0) echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle" onClick="document.getElementById('idArea').style.display='block'">&nbsp;Cetak 
            Stok </BUTTON>&nbsp;<BUTTON type="button" <?php  if($jmldata==0) echo "disabled='disabled'"; ?> onClick="OpenWnd('../transaksi/stok_akhir_bulan_Excell.php?filter=<?php echo $jfilter; ?>&sorting=<?php echo $sorting; ?>&idunit=<?php echo $idunit; ?>&nunit1=<?php echo $nunit1; ?>&bulan=<?php echo $bln; ?>&tbulan=<?php echo $tBln; ?>&tahun=<?php echo $thn; ?>&kelas=<?php echo $kelas; ?>&golongan=<?php echo $golongan; ?>&jenis=<?php echo $jenis; ?>&kategori=<?php echo $kategori; ?>&bentuk=<?php echo $bentuk; ?>',600,450,'childwnd',true);"><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export ke File Excell</BUTTON></td>
        </tr>
      </table>
      
      <?php
	  }
	  ?>
    </div>
    <div id="idArea" style="display:none">
    <?php
	if($idunit=='0'){
	?>
    <link rel="stylesheet" href="../theme/print.css" type="text/css" />
	<p align="center"><span class="jdltable">DAFTAR STOK AKHIR BULAN OBAT / ALKES</span> 	
      <table>
        <tr> 
          <td align="center" class="txtinput">Akhir Bulan </td>
          <td align="center" class="txtinput">: <?php echo $tBln." ".$thn; ?></td>
        </tr>
        <tr> 
          <td align="center" class="txtinput">Unit </td>
          <td align="center" class="txtinput">: ALL UNIT</td>
        </tr>
        <tr> 
          <td align="center" class="txtinput">Kelas </td>
          <td align="center" class="txtinput">: <?php echo $k1; ?></td>
        </tr>
        <tr>
          <td align="center" class="txtinput">Kategori</td>
          <td align="center" class="txtinput">: <?php echo $f1; ?></td>
        </tr>
        <tr> 
          <td align="center" class="txtinput">Golongan </td>
          <td align="center" class="txtinput">: <?php echo $g1; ?></td>
        </tr>
        <tr> 
          <td align="center" class="txtinput">Jenis</td>
          <td align="center" class="txtinput">: <?php echo $j1; ?></td>
        </tr>
      </table>
     <table width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="25" height="25" class="tblheaderkiri">No</td>
          <td class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Obat</td>
          <td width="100" class="tblheader" id="NAMA" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="unit1" width="36" class="tblheader">GD</td>
          <td id="unit2" width="36" class="tblheader">AP-RS</td>
          <!-- <td id="unit3" width="36" class="tblheader">AP-IGD</td>
          <td id="unit113" width="36" class="tblheader">DP-OK</td> -->
          <td id="unit17" width="36" class="tblheader">PR</td>
          <!-- <td id="unit116" width="36" class="tblheader">FS-RJ</td> -->
          <td id="unit20" width="36" class="tblheader">FS</td>
          <td id="total" width="41" class="tblheader">Total</td>
          <td id="ntotal" width="51" class="tblheader">Nilai</td>
        </tr>
        <?php 
	  $rs=mysqli_query($konek,$sql);
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;		
		
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td align="left" class="tdisi"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi"><?php echo $rows['NAMA']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['GD']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['AP_RS']; ?></td>
         <!--  <td align="right" class="tdisi"><?php echo $rows['AP_IGD']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['DP_OK']; ?></td> -->
          <td align="right" class="tdisi"><?php echo $rows['PR']; ?></td>
          <!-- <td align="right" class="tdisi"><?php echo $rows['FS_RJ']; ?></td> -->
          <td align="right" class="tdisi"><?php echo $rows['FS']; ?></td>
          <td align="right" class="tdisi"><?php echo $rows['total']; ?></td>
          <td align="right" class="tdisi"><?php echo number_format($rows['ntotal'],0,",","."); ?></td>
        </tr>
        <?php 
	  }
	  $jml_tot=0;
	  mysqli_free_result($rs);
	  //$sql2="select sum(ntotal) as jml_tot from vstokall as v,a_kepemilikan as m,a_obat as o where o.OBAT_ID=v.obat_id and m.ID=v.kepemilikan_id".$filter;
	  $sql2="select if (sum(p2.ntotal) is null,0,sum(p2.ntotal)) as jml_tot from (".$sql.") as p2";
	  //echo $sql2."<br>";
	  $rs=mysqli_query($konek,$sql2);
	  $show=mysqli_fetch_array($rs);
	  $jml_tot=$show['jml_tot'];
	  ?>
        <tr> 
          <td colspan="4"><span class="style1">Ket:GD=Gudang; AP=Apotik; PR=Produksi; 
            FS=Floor Stock;</span></td>
          <td colspan="4" align="right"><span class="style1"><strong>Nilai Total 
            :&nbsp;&nbsp;</strong></span></td>
          <td colspan="2" align="right"><span class="style1"><strong><?php echo number_format($jml_tot,0,",","."); ?></strong></span></td>
        </tr>
    <?php
	}else{
	?>
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
<p align="center"><span class="jdltable">DAFTAR STOK AKHIR BULAN OBAT / ALKES</span> 
		
      <table>
        <tr> 
          <td align="center" class="txtinput">Akhir Bulan </td>
          <td align="center" class="txtinput">: <?php echo $tBln." ".$thn; ?></td>
        </tr>
        <tr> 
          <td align="center" class="txtinput">Unit </td>
          <td align="center" class="txtinput">: <?php echo $nunit1; ?></td>
        </tr>
         <tr> 
          <td align="center" class="txtinput">Kelas </td>
          <td align="center" class="txtinput">: <?php echo $k1; ?></td>
        </tr>
        <tr>
          <td align="center" class="txtinput">Kategori</td>
          <td align="center" class="txtinput">: <?php echo $f1; ?></td>
        </tr>
        <tr> 
          <td align="center" class="txtinput">Golongan </td>
          <td align="center" class="txtinput">: <?php echo $g1; ?></td>
        </tr>
        <tr> 
          <td align="center" class="txtinput">Jenis</td>
          <td align="center" class="txtinput">: <?php echo $j1; ?></td>
        </tr>
      </table>
      <table width="98%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            Obat </td>
          <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Obat </td>
          <td id="NAMA" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="QTY_STOK" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Stok</td>
          <td id="nilai" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Nilai</td>
        </tr>
        <?php 
	  //echo $sql;
		$rs=mysqli_query($konek,$sql);
	  $i=0;
	  while ($rows=mysqli_fetch_array($rs)){
	  	$i++;		
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td height="20" align="center" class="tdisikiri" style="font-size:12px;"><?php echo $i; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
          <td align="center" class="tdisi" style="font-size:12px;"><?php echo $rows['qty_stok'];?></td>
          <td class="tdisi" align="right" style="font-size:12px;"><?php echo number_format($rows['nilai'],0,",",".");?></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  ?>
        <tr> 
          <td colspan="5" class="txtright"><strong>Nilai Total :</strong></td>
          <td align="right" class="txtright"><strong><?php echo number_format($ntotal,0,",","."); ?></strong></td>
        </tr>
	  </table>
      <?php
	}
	  ?>
	  
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