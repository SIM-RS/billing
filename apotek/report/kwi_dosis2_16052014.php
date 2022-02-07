<?php
session_start();

$iduser = $_SESSION["iduser"];
$iduser_jual = $_REQUEST["iduser_jual"];

include("../koneksi/konek.php");
$idunit=$_GET["sunit"];
//echo $idunit;
$no_penjualan=$_GET['no_penjualan'];
//echo $no_penjualan;
$no_resep=$_GET['no_resep'];
$no_pasien=$_GET['no_pasien'];
$idpel=$_GET['idpel'];
$tgl=$_GET['tgl'];
//$tgl1=explode("-",$tgl);
//$tgl=$tgl1[2]."-".$tgl1[1]."-".$tgl1[0];
$u="select UNIT_NAME from a_unit where UNIT_ID=$idunit";
//echo $u;
$rsu=mysqli_query($konek,$u);
$row=mysqli_fetch_array($rsu);
$apname=$row['UNIT_NAME'];
if ($iduser_jual!=""){
	$sql="SELECT * FROM a_penjualan WHERE UNIT_ID=$idunit AND QTY_RETUR>0 AND NO_PENJUALAN='$no_penjualan' AND NO_PASIEN='$no_pasien' AND TGL='$tgl' AND USER_ID=$iduser_jual";
}else{
	$sql="SELECT * FROM a_penjualan WHERE UNIT_ID=$idunit AND QTY_RETUR>0 AND NO_PENJUALAN='$no_penjualan' AND NO_PASIEN='$no_pasien' AND TGL='$tgl'";
}
//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
$ada_retur=mysqli_num_rows($rs);
$retur='';
if ($rows=mysqli_fetch_array($rs)){
	$retur=$rows['NO_RETUR'];
	$tglretur=date("d/m/Y H:i",strtotime($rows['TGL_RETUR']));
}
?>
<html>
<head>
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</script>
<style type="text/css">
<!--
body{
margin-left:0;
}
.style1 {
font-family: "Courier New", Courier, monospace;
font-size:12px;}
.style2 {
font-family: "Courier New", Courier, monospace;
font-size:14px;}
-->
</style>
</head>

<body>
<script>
var arrRange=depRange=[];
</script>

<!-- UNTUK DI PRINT OUT -->
<div id="idArea" style="display:block;">
	<?php
	//if ($_POST['no_penjualan']<>"") $no_kunj=$_POST['no_penjualan']; else $no_kunj=0;
	/*if ($iduser_jual!=""){
		$qrySingle="SELECT a_penjualan.*,a_mitra.NAMA AS kso_nama,a_kepemilikan.NAMA,a_user.username,UNIT_NAME from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_unit on a_unit.UNIT_ID=a_penjualan.RUANGAN Left Join a_user on a_penjualan.USER_ID=a_user.kode_user LEFT JOIN a_mitra ON a_penjualan.KSO_ID=a_mitra.IDMITRA WHERE a_penjualan.NO_PENJUALAN='$no_penjualan' and a_penjualan.UNIT_ID=$idunit AND a_penjualan.NO_PASIEN='$no_pasien' AND a_penjualan.TGL='$tgl' AND a_penjualan.USER_ID=$iduser_jual";
	}else{*/
		$qrySingle="SELECT DISTINCT r.no_resep,mp.nama,
DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(mp.tgl_lahir, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(mp.tgl_lahir, '00-%m-%d')) umur,
DATE_FORMAT(mp.tgl_lahir, '%d-%m-%Y') tgl_lahir,mp.no_ktp,mp.telp,mp.sex,
		mp.no_rm,r.alamat,r.dokter_nama dokter,mu.nama poli,
		CONCAT((CONCAT((CONCAT((CONCAT(mp.alamat,' RT.',mp.rt)),' RW.',mp.rw)),', Desa ',w.nama)),', Kecamatan ',wi.nama,', ',wii.nama) alamat_, r.iter
FROM $dbbilling.b_resep r INNER JOIN $dbbilling.b_pelayanan p ON r.id_pelayanan=p.id
INNER JOIN $dbbilling.b_kunjungan k ON p.kunjungan_id=k.id INNER JOIN $dbbilling.b_ms_pasien mp ON k.pasien_id=mp.id
	LEFT JOIN $dbbilling.b_ms_wilayah w
		ON mp.desa_id = w.id
	LEFT JOIN $dbbilling.b_ms_wilayah wi
		ON mp.kec_id = wi.id
	LEFT JOIN $dbbilling.b_ms_wilayah wii
		ON mp.kab_id = wii.id
INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id=mu.id 
WHERE r.tgl='$tgl' AND r.apotek_id='$idunit' AND r.no_resep='$no_resep' 
AND r.id_pelayanan='$idpel' AND r.no_rm='$no_pasien'";
	//}
	$exeSingle=mysqli_query($konek,$qrySingle);
	//echo $qrySingle;
	$showSingle=mysqli_fetch_array($exeSingle);
	
	?>
	<!--link rel="stylesheet" href="../theme/print.css" type="text/css"/-->
    <!--table width="421" border="0" class="style1">
      <tr>
        <td width="429"-->
		
  <table width="1000" height="113" border="0" align="left" cellpadding="0" cellspacing="0" class="style1">
    <tr class="style1"> 
      <td height="45" colspan="3" class="style1" style="font-size:16px"> <b>PEMERINTAH KOTA TANGERANG<br><b>RSUD Tangerang<br>
        Jl.Jend. Sudirman&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<?php echo $apname; ?><br>
        RESEP ELEKTRONIK</b> 
        <hr size="1" color="#000000"></td>
    </tr>
    <!--tr> 
      <td width="168">No. Kwitansi </td>
      <td width="382" colspan="2">: <?php echo $showSingle['NO_PENJUALAN']; ?><?php if ($ada_retur>0){?>&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<? echo $retur; ?><?php }?></td>
    </tr>
    <tr> 
      <td width="168">Tanggal</td>
      <td colspan="2">: <?php echo date("d/m/Y",strtotime($showSingle['TGL']))." ".date("H:i",strtotime($showSingle['TGL_ACT'])); if ($ada_retur>0){echo "  -  ".$tglretur;} ?></td>
    </tr-->
    <tr> 
      <td width="180">No. Resep</td>
      <td colspan="2">: <?php echo $showSingle['no_resep']; ?></td>
    </tr>
    <tr > 
      <td>No Rekam Medis</td>
      <td colspan="2">: <?php echo $showSingle['no_rm']; ?></td>
    </tr>
    <tr> 
      <td >Nama Pasien </td>
      <td colspan="2" >: <?php echo $showSingle['nama']; ?>&nbsp;</td>
    </tr>
    <tr>
      <td >Umur</td>
      <td colspan="2" >: <?php echo $showSingle['umur']; ?>&nbsp;</td>
    </tr>
    <tr>
      <td >Tgl Lahir</td>
      <td colspan="2" >: <?php echo $showSingle['tgl_lahir']; ?></td>
    </tr>
    <tr>
      <td >Alamat</td>
      <td colspan="2" >: <?php echo $showSingle['alamat_']; ?>&nbsp;</td>
    </tr>
    <!--tr> 
      <td >Jenis Pasien</td>
      <td colspan="2" >: <?php echo $showSingle['NAMA']." / ".$showSingle['kso_nama']; ?></td>
    </tr-->
    <tr>
      <td >No. KTP</td>
      <td colspan="2" >: <?php echo $showSingle['no_ktp']; ?>&nbsp;</td>
    </tr>
    <tr>
      <td >No. Telp.</td>
      <td colspan="2" >: <?php echo $showSingle['telp']; ?>&nbsp;</td>
    </tr>
    <tr>
      <td >Jenis Kelamin</td>
      <td colspan="2" >: <?php echo $showSingle['sex']; ?>&nbsp;</td>
    </tr>
    <tr> 
      <td >Dokter</td>
      <td colspan="2" >: <?php echo $showSingle['dokter']; ?></td>
    </tr>
    <tr> 
      <td >Poli</td>
      <td colspan="2" >: <?php echo $showSingle['poli']; ?></td>
    </tr>
    <tr> 
      <td >Iter</td>
      <td colspan="2" >: <?php echo $showSingle['iter']; ?></td>
    </tr>
    <tr> 
      <td >&nbsp;</td>
      <td colspan="2" >&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="3" ><table width="1000" border="0" cellpadding="0" cellspacing="0" align="left">
          <?php 
		  	/*if ($iduser_jual!=""){
				$sqlPrint="SELECT NO_PENJUALAN,TGL_ACT,NO_KUNJUNGAN,NO_PASIEN,NAMA_PASIEN,JENIS_PASIEN_ID,a_obat.OBAT_NAMA, a_obat.OBAT_SATUAN_KECIL,HARGA_SATUAN,SUB_TOTAL,SUM(a_penjualan.QTY) AS QTY,SUM(a_penjualan.QTY_JUAL) AS QTY_JUAL,SUM(a_penjualan.QTY_RETUR) AS QTY_RETUR FROM a_penjualan INNER JOIN a_penerimaan ON a_penjualan.PENERIMAAN_ID = a_penerimaan.ID INNER JOIN a_obat ON a_penerimaan.OBAT_ID = a_obat.OBAT_ID WHERE a_penjualan.NO_PENJUALAN='$no_penjualan' AND a_penjualan.UNIT_ID=$idunit AND a_penjualan.NO_PASIEN='$no_pasien' AND a_penjualan.TGL='$tgl' AND a_penjualan.USER_ID=$iduser_jual GROUP BY NO_PENJUALAN,TGL,NO_KUNJUNGAN,NO_PASIEN,NAMA_PASIEN,JENIS_PASIEN_ID,a_obat.OBAT_NAMA, a_obat.OBAT_SATUAN_KECIL,HARGA_SATUAN ORDER BY a_penjualan.ID";
			}else{*/
				$sqlPrint="SELECT $dbbilling.b_resep.id,$dbapotek.a_obat.OBAT_ID, $dbapotek.a_obat.OBAT_KODE, $dbapotek.a_obat.OBAT_NAMA, 
IF($dbbilling.b_resep.racikan=0,$dbbilling.b_resep.qty,CONCAT('Racikan ',$dbbilling.b_resep.racikan,' (',$dbbilling.b_resep.qty,' @',
$dbbilling.b_resep.qty_bahan,' ',$dbbilling.b_resep.satuan,')')) AS racikan,$dbbilling.b_resep.racikan isRacikan, 
IF($dbbilling.b_resep.racikan=0,$dbbilling.b_resep.qty,0) qty,$dbbilling.b_resep.kepemilikan_id,$dbbilling.b_resep.status,
$dbbilling.b_resep.id_pelayanan,$dbbilling.b_resep.no_rm,$dbbilling.b_resep.no_resep,$dbbilling.b_resep.ket_dosis,
IF(IF($dbbilling.b_resep.racikan = 0,$dbbilling.b_resep.qty,0)<>0,if($dbbilling.b_resep.qty <= $dbapotek.a_penjualan.QTY_JUAL,'DET','NEDET'),'-') isi 
FROM $dbbilling.b_resep INNER JOIN $dbapotek.a_obat ON $dbapotek.a_obat.OBAT_ID=$dbbilling.b_resep.obat_id
LEFT JOIN $dbapotek.a_penjualan ON $dbapotek.a_penjualan.ID =  $dbbilling.b_resep.penjualan_id 
WHERE $dbbilling.b_resep.tgl='$tgl' AND $dbbilling.b_resep.apotek_id='$idunit' AND $dbbilling.b_resep.no_resep='$no_resep' 
AND $dbbilling.b_resep.id_pelayanan='$idpel' AND $dbbilling.b_resep.no_rm='$no_pasien' AND $dbbilling.b_resep.racikan = 0";
			//}
			//echo $sqlPrint;
			$exePrint=mysqli_query($konek,$sqlPrint);
			$k=mysqli_num_rows($exePrint);
			$i=1;
			$z=0;
			while($showPrint=mysqli_fetch_array($exePrint))
			{
			?>
          <tr> 
            <td width="36" valign="top" align="left" class="style1"><?php echo $i++ ?></td>
            <td width="250" valign="top" class="style1"><?php echo $showPrint['OBAT_NAMA']; ?><br/>(<?php echo $showPrint['isi']; ?>)</td>
            <td width="350" valign="top" align="left" class="style1"><?php echo $showPrint['racikan']; ?></td>
            <td align="left" valign="top" class="style1"><?php echo $showPrint['ket_dosis']; ?></td>
          </tr>
          <? $z++;} ?>
          
         <? 
          $sqlPrint="SELECT $dbbilling.b_resep.id, $dbbilling.b_resep.obat_manual as OBAT_NAMA,
IF($dbbilling.b_resep.racikan=0,$dbbilling.b_resep.qty,CONCAT('Racikan ',$dbbilling.b_resep.racikan,' (',$dbbilling.b_resep.qty,' @',
$dbbilling.b_resep.qty_bahan,' ',$dbbilling.b_resep.satuan,')')) AS racikan,$dbbilling.b_resep.racikan isRacikan, 
IF($dbbilling.b_resep.racikan=0,$dbbilling.b_resep.qty,0) qty,$dbbilling.b_resep.kepemilikan_id,$dbbilling.b_resep.status,
$dbbilling.b_resep.id_pelayanan,$dbbilling.b_resep.no_rm,$dbbilling.b_resep.no_resep,$dbbilling.b_resep.ket_dosis,
IF(IF($dbbilling.b_resep.racikan = 0,0,$dbbilling.b_resep.qty)<>0,if($dbbilling.b_resep.qty <= $dbapotek.a_penjualan.QTY_JUAL,'DET','NEDET'),'-') isi 
FROM $dbbilling.b_resep
LEFT JOIN $dbapotek.a_penjualan ON $dbapotek.a_penjualan.ID =  $dbbilling.b_resep.penjualan_id 
WHERE $dbbilling.b_resep.tgl='$tgl' AND $dbbilling.b_resep.apotek_id='$idunit' AND $dbbilling.b_resep.no_resep='$no_resep' 
AND $dbbilling.b_resep.id_pelayanan='$idpel' AND $dbbilling.b_resep.no_rm='$no_pasien' AND {$dbbilling}.b_resep.obat_manual <> ''";
			//}
			//echo $sqlPrint;
			$exePrint=mysqli_query($konek,$sqlPrint);
			$k=mysqli_num_rows($exePrint);
			//$i=1;
			$z=0;
			while($showPrint=mysqli_fetch_array($exePrint))
			{
			?>
          <tr> 
            <td width="36" valign="top" align="left" class="style1"><?php echo $i++ ?></td>
            <td width="250" valign="top" class="style1"><?php echo $showPrint['OBAT_NAMA']; ?><br/>(<?php echo $showPrint['isi']; ?>)</td>
            <td width="350" valign="top" align="left" class="style1"><?php echo $showPrint['racikan']; ?></td>
            <td align="left" valign="top" class="style1"><?php echo $showPrint['ket_dosis']; ?></td>
          </tr>
          <? $z++;} ?>
          
          <tr> 
            <td width="36" valign="top" align="left" class="style1">&nbsp;</td>
            <td width="250" valign="top" class="style1">&nbsp;</td>
            <td width="350" valign="top" align="left" class="style1">&nbsp;</td>
            <td align="left" valign="top" class="style1">&nbsp;</td>
          </tr>
          <?php 
		  	/*if ($iduser_jual!=""){
				$sqlPrint="SELECT NO_PENJUALAN,TGL_ACT,NO_KUNJUNGAN,NO_PASIEN,NAMA_PASIEN,JENIS_PASIEN_ID,a_obat.OBAT_NAMA, a_obat.OBAT_SATUAN_KECIL,HARGA_SATUAN,SUB_TOTAL,SUM(a_penjualan.QTY) AS QTY,SUM(a_penjualan.QTY_JUAL) AS QTY_JUAL,SUM(a_penjualan.QTY_RETUR) AS QTY_RETUR FROM a_penjualan INNER JOIN a_penerimaan ON a_penjualan.PENERIMAAN_ID = a_penerimaan.ID INNER JOIN a_obat ON a_penerimaan.OBAT_ID = a_obat.OBAT_ID WHERE a_penjualan.NO_PENJUALAN='$no_penjualan' AND a_penjualan.UNIT_ID=$idunit AND a_penjualan.NO_PASIEN='$no_pasien' AND a_penjualan.TGL='$tgl' AND a_penjualan.USER_ID=$iduser_jual GROUP BY NO_PENJUALAN,TGL,NO_KUNJUNGAN,NO_PASIEN,NAMA_PASIEN,JENIS_PASIEN_ID,a_obat.OBAT_NAMA, a_obat.OBAT_SATUAN_KECIL,HARGA_SATUAN ORDER BY a_penjualan.ID";
			}else{*/
				$sqlPrint2="SELECT $dbbilling.b_resep.racikan 
FROM $dbbilling.b_resep 
WHERE $dbbilling.b_resep.tgl='$tgl' AND $dbbilling.b_resep.apotek_id='$idunit' AND $dbbilling.b_resep.no_resep='$no_resep' 
AND $dbbilling.b_resep.id_pelayanan='$idpel' AND $dbbilling.b_resep.no_rm='$no_pasien' AND $dbbilling.b_resep.racikan <> 0 group by $dbbilling.b_resep.racikan";
			//}
			//echo $sqlPrint;
			$exePrint2=mysqli_query($konek,$sqlPrint2);
			$k2=mysqli_num_rows($exePrint2);
			$i2=1;
			$z2=$z+1;
			while($showPrint2=mysqli_fetch_array($exePrint2))
			{
				
				$sqlPrint3="SELECT $dbbilling.b_resep.id,$dbapotek.a_obat.OBAT_ID, $dbapotek.a_obat.OBAT_KODE, $dbapotek.a_obat.OBAT_NAMA, 
IF($dbbilling.b_resep.racikan=0,$dbbilling.b_resep.qty,CONCAT(' (','@',
$dbbilling.b_resep.qty_bahan,' ',$dbbilling.b_resep.satuan,')')) AS racikan,CONCAT($dbbilling.b_resep.qty) AS racikan2,$dbbilling.b_resep.racikan isRacikan,CONCAT('Racikan ',$dbbilling.b_resep.racikan) isRacikan2, 
IF($dbbilling.b_resep.racikan=0,$dbbilling.b_resep.qty,0) qty,$dbbilling.b_resep.kepemilikan_id,$dbbilling.b_resep.status,
$dbbilling.b_resep.id_pelayanan,$dbbilling.b_resep.no_rm,$dbbilling.b_resep.no_resep,$dbbilling.b_resep.ket_dosis,
IF(IF($dbbilling.b_resep.racikan = 0,0,$dbbilling.b_resep.qty)<>0,if($dbbilling.b_resep.qty <= $dbapotek.a_penjualan.QTY_JUAL,'DET','NEDET'),'-') isi 
FROM $dbbilling.b_resep INNER JOIN $dbapotek.a_obat ON $dbapotek.a_obat.OBAT_ID=$dbbilling.b_resep.obat_id
LEFT JOIN $dbapotek.a_penjualan ON $dbapotek.a_penjualan.ID =  $dbbilling.b_resep.penjualan_id 
WHERE $dbbilling.b_resep.tgl='$tgl' AND $dbbilling.b_resep.apotek_id='$idunit' AND $dbbilling.b_resep.no_resep='$no_resep' 
AND $dbbilling.b_resep.id_pelayanan='$idpel' AND $dbbilling.b_resep.no_rm='$no_pasien' AND $dbbilling.b_resep.racikan='".$showPrint2['racikan']."'";
			//}
			//echo $sqlPrint3;
			$exePrint3=mysqli_query($konek,$sqlPrint3);
			$k3=mysqli_num_rows($exePrint3);
			$i3=1;
			while($showPrint3=mysqli_fetch_array($exePrint3))
			{
			if($i3==1){
			?>
            <tr> 
            <td width="286" colspan="2" align="left" class="style1"><?php echo $z2++." ".$showPrint3['isRacikan2']; ?></td>
            <td width="350" align="left" valign="top" class="style1"><?php echo $showPrint3['racikan2']; ?></td>
            <td align="left" class="style1"><?php echo $showPrint3['ket_dosis']; ?></td>
          </tr>
            <?php }?>
          <tr> 
            <td width="36" align="center" valign="top" class="style1"><?php echo $i3++ ?></td>
            <td width="250" class="style1"><?php echo $showPrint3['OBAT_NAMA']; ?><br/>(<?php echo $showPrint3['isi']; ?>)</td>
            <td width="350" align="left" valign="top" class="style1"><?php echo $showPrint3['racikan']; ?></td>
            <td align="left" class="style1">&nbsp;</td>
          </tr>
          <?php } ?>
		  <tr> 
            <td width="286" colspan="2" align="left" class="style1">&nbsp;</td>
            <td width="350" align="left" class="style1">&nbsp;</td>
            <td align="left" class="style1">&nbsp;</td>
          </tr>		  
		  <?php } ?>
        </table></td>
    </tr>
  </table>
</div>
<div id="btn">
<br>
<table width="550" align="left">
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<tr>
	<td width="50%" align="left">
		<BUTTON type="button" onClick="document.getElementById('btn').style.display='none';window.print();window.close();"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">Cetak Dosis</BUTTON>
	</td>
	<td width="50%" align="right">&nbsp;</td>
</tr>
</table>
</div>
</body>
</html>
