<?
include("../sesi.php");
include("../koneksi/konek.php");
$tglctk=gmdate('d-m-Y H:i',mktime(date('H')+7));
$tgl=gmdate('d-m-Y H:i:s',mktime(date('H')+7));
$username=$_REQUEST['user'];
$idunit=$_GET["sunit"];
//echo $idunit;
$no_bukti=$_GET['no_bukti'];
//echo $no_bukti;
$unit_tujuan=$_GET['unit_tujuan'];
//echo $unit_tujuan;
$sql="select tgl_act from a_pinjam_obat where no_bukti='$no_bukti'";
//echo $sql;
$rs=mysql_query($sql);
$show=mysql_fetch_array($rs);
$tgl1=date("d/m/y H:i:s",strtotime($show['tgl_act']));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<style type="text/css">
<!--
.style2 {font-size: 12px}
-->
</style>
<title>Sistem Informasi Apotek <?=$namaRS;?></title>
</head>

<body>
<div id="idArea" style="display:block">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
  <table width="84%" border="0" cellpadding="1" cellspacing="0" align="center">
  <tr> `
              <td colspan="4" align="center" class="">PEMINJAMAN 
                OBAT </td>
	</tr>
				<tr> 
                <td width="129" class="style2">Unit Peminjam&nbsp;</td>
                <td width="153" class="style2">: <?php $qry = "select * from a_unit where UNIT_ID='$idunit'";
				$exe = mysql_query($qry);
	  			$show= mysql_fetch_array($exe);
				echo $show['UNIT_NAME']; ?></td>
				<td width="164" class="style2">No. Permintaan</td>
                <td width="240" class="style2">: <?php echo $no_bukti; ?></td>
              </tr>
              <tr> 
				<td class="style2">Unit Tujuan </td>
                <td class="style2">:<?php echo $unit_tujuan; ?>				</td>
				<td width="129" class="style2">Tanggal&nbsp; </td>
                <td class="style2">:<?php echo $tgl1;?> </td>
              </tr>
  </table>
			  <table width="90%" border="0" cellpadding="1" cellspacing="0">
  <tr class="headtable">  
      <td width="8%" class="tblheaderkiri">No</td>
      <td width="17%" class="tblheader" id="OBAT_KODE" >Kode Obat</td>
      <td width="27%" class="tblheader" id="OBAT_NAMA">Obat</td>
      <td width="17%" class="tblheader" id="OBAT_SATUAN_KECIL">Satuan</td>
      <td width="21%" class="tblheader" id="NAMA">Kepemilikan</td>
      <td width="10%" class="tblheader" id="qty">Qty</td>
         </tr>
	<?php
	$sq="select a_obat.OBAT_ID,a_obat.OBAT_KODE,a_obat.OBAT_NAMA,a_obat.OBAT_SATUAN_KECIL,a_kepemilikan.NAMA,qty,(select NAMA from a_kepemilikan where a_kepemilikan.ID=a_pinjam_obat.kepemilikan_id_asal) namaasal,a_pinjam_obat.no_bukti from $dbapotek.a_pinjam_obat left join $dbapotek.a_obat on a_pinjam_obat.obat_id=a_obat.OBAT_ID left join $dbapotek.a_kepemilikan on a_pinjam_obat.kepemilikan_id=a_kepemilikan.ID where no_bukti='$no_bukti'";
	echo $sq;
	//$sq="select t1.*,ake.NAMA as NAMA1 from (select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,$dbapotek.a_unit.UNIT_NAME,am.*,date_format(am.tgl,'%d/%m/%Y') as tgl1,NAMA from $dbapotek.a_pinjam_obat am inner join $dbapotek.a_obat ao on am.obat_id=ao.OBAT_ID inner join $dbapotek.a_kepemilikan ak on am.kepemilikan_id=ak.ID Inner Join $dbapotek.a_unit ON am.unit_tujuan = a_unit.UNIT_ID where am.unit_id=$idunit ) as t1 inner join $dbapotek.a_kepemilikan ake on t1.kepemilikan_id_asal=ake.ID"
	$qr=mysql_query($sq);
	while($show=mysql_fetch_array($qr)){
	$p++;
	?>   
    <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
      <td class="tdisikiri" align="center" style="font-size:12px;"><? echo $p?></td>
      <td class="tdisi" align="center" style="font-size:12px;"><?php echo $show['OBAT_KODE']; ?></td>
      <td class="tdisi" align="left" style="font-size:12px;"><?php echo $show['OBAT_NAMA']; ?></td>
      <td class="tdisi" align="center" style="font-size:12px;"><?php echo $show['OBAT_SATUAN_KECIL']; ?></td>
      <td class="tdisi" align="center" style="font-size:12px;"><?php echo $show['NAMA']; ?></td>
      <td class="tdisi" align="center" style="font-size:12px;"><?php echo $show['qty']; ?></td>
    </tr>
	<? } ?>
	<tr>
	  <td align="left" colspan="2">
	  <!--a href="#" value="Print kwitansi penjualan ini" onClick="window.print()" class="navText"-->
		<BUTTON type="button" value="Print kwitansi penjualan ini" onClick="window.print()"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle" onClick="document.getElementById('idArea').style.display='block'"></BUTTON>
		<!--/a-->
	  </td><td colspan="4" align="right" style='padding-right:25px;><b>&raquo;Tgl Cetak:</b><?php echo  $tglctk;?> <b>- User:</b> <? echo $username; ?></td></tr>
  </table>
</div>
</body>
</html>
