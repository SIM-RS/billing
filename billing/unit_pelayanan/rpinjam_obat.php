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
$sql="select tgl_act from $dbapotek.a_pinjam_obat where no_bukti='$no_bukti'";
//echo $sql;
$rs=mysql_query($sql);
$show=mysql_fetch_array($rs);
$tgl1=date("d/m/y H:i:s",strtotime($show['tgl_act']));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../theme/print.css" type="text/css" />
<title>Sistem Informasi Apotek <?=$namaRS;?></title>
</head>

<body>
  <table width="90%" border="0" cellpadding="1" cellspacing="0">
	<tr> `
        <td colspan="4" style="text-align:center; padding-bottom:5px;">PEMINJAMAN OBAT </td>
	</tr>
	<tr> 
        <td width="100" style="font-size:12px; padding-left:100px;">Unit Peminjam&nbsp;</td>
        <td width="200" style="font-size:12px;">: 
			<?php 
				$qry = "SELECT * FROM $dbapotek.a_unit WHERE unit_billing ='$idunit'";
				$exe = mysql_query($qry);
	  			$show= mysql_fetch_array($exe);
				echo $show['UNIT_NAME']; ?>
		</td>
		<td width="110" style="font-size:12px;">No. Permintaan</td>
        <td width="240" style="font-size:12px;">: <?php echo $no_bukti; ?></td>
    </tr>
    <tr> 
		<td style="font-size:12px; padding-left:100px; padding-bottom:5px;">Unit Tujuan </td>
		<td style="font-size:12px;">: <?php echo $unit_tujuan; ?></td>
		<td width="129" style="font-size:12px;">Tanggal&nbsp; </td>
		<td style="font-size:12px;">: <?php echo $tgl1;?> </td>
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
	$sq = "SELECT 
			  a_obat.OBAT_ID,
			  a_obat.OBAT_KODE,
			  a_obat.OBAT_NAMA,
			  a_obat.OBAT_SATUAN_KECIL,
			  a_kepemilikan.NAMA,
			  qty,
			  (SELECT 
				NAMA 
			  FROM
				$dbapotek.a_kepemilikan 
			  WHERE a_kepemilikan.ID = a_pinjam_obat.kepemilikan_id_asal) namaasal,
			  a_pinjam_obat.no_bukti 
			FROM
			  $dbapotek.a_pinjam_obat 
			  LEFT JOIN $dbapotek.a_obat 
				ON a_pinjam_obat.obat_id = a_obat.OBAT_ID 
			  LEFT JOIN $dbapotek.a_kepemilikan 
				ON a_pinjam_obat.kepemilikan_id = a_kepemilikan.ID 
			WHERE no_bukti = '$no_bukti'";
	//echo $sq;
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
  </table>
  <table width="90%">
  	<tr id="trTombol">
		<td class="noline" align="center" style="padding-top:5px;">
		   <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
		   <input id="btnTutup" type="button" value="Tutup" onClick="window.close()" />
		</td>
    </tr>
  </table>
</body>
  <script>
        function cetak(tombol){
            tombol.style.visibility='hidden';
            if(!window.print()){
				tombol.style.visibility='visible';
			}
        }
   </script>