<?
include("../sesi.php");
include("../koneksi/konek.php");
tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$idunit=$_GET["sunit"];
//echo $idunit;
$no_bukti=$_GET['no_bukti'];
//echo $no_bukti;
$sql1="SELECT a_minta_obat.tgl_act,a_unit.UNIT_NAME from a_minta_obat left join a_unit on a_minta_obat.unit_id=a_unit.UNIT_ID where a_minta_obat.no_bukti='$no_bukti'";
$rs1=mysqli_query($konek,$sql1);
$show=mysqli_fetch_array($rs1);
$namaunit=$show['UNIT_NAME'];
$tgl=date("d/m/Y H:i:s",strtotime($show['tgl_act']));
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistem informasi Apotek <?=$namaRS;?></title>
</head>
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.style1 {
font-family: "Courier New", Courier, monospace;
font-size:14px;}
-->
</style>
<body>
<script>
var arrRange=depRange=[];
</script>
<div id="idArea" style="display:block">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
      <p align="center"><span class="jdltable">DAFTAR PERMINTAAN OBAT</span> 
      <table width="359" border="0" cellpadding="1" cellspacing="0" class="txtinput" align="center">
        <tr>
          <td width="108">Unit</td>
          <td width="212">: <?php echo $namaunit; ?></td>
        </tr>
              <tr>
          <td>Tgl Permintaan</td>
          <td>: <?php echo $tgl;?></td>
        </tr>
        <tr>
          <td>No Permintaan </td>
          <td>: <?php echo $no_bukti; ?></td>
        </tr>
  </table>
      <table width="900" border="0" cellpadding="1" cellspacing="0" align="center">
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
	  //$sql="select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,am.*,(am.qty-am.qty_terima) as qty_kirim,date_format(am.tgl,'%d/%m/%Y') as tgl1,NAMA from a_minta_obat am inner join a_obat ao on am.obat_id=ao.OBAT_ID inner join a_kepemilikan ak on am.kepemilikan_id=ak.ID where am.unit_id=$iunit and am.no_bukti='$no_kirim'".$filter." order by ".$sorting;
	  $sql="select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,am.qty,NAMA from a_minta_obat am inner join a_obat ao on am.obat_id=ao.OBAT_ID inner join a_kepemilikan ak on am.kepemilikan_id=ak.ID where am.unit_id='$idunit' and am.no_bukti='$no_bukti'".$filter;
	  //echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="" || $page=="0") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";
		//echo $sql."<br>";
	  $rs=mysqli_query($konek,$sql);
	  $i=($page-1)*$perpage;
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
	  <tr>
	  <td align="left" colspan="2">
	  <!--a href="#" value="Print kwitansi penjualan ini" onClick="window.print()" class="navText"-->
		<BUTTON type="button" value="Print kwitansi penjualan ini" onClick="window.print()"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle" onClick="document.getElementById('idArea').style.display='block'"></BUTTON>
		<!--/a-->
	  </td><td colspan="4" align="right" style="padding-right:25px;"><b>&raquo;Tgl Cetak:</b><?php echo  $tglctk;?></td></tr>
  </table>
</div>
</body>
</html>
