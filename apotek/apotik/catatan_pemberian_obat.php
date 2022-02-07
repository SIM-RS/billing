<?php 
include("../sesi.php"); 
?>
<style>
.jdl1{
font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:16px;
font-weight:bold;
}

.jdl2{
font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:13px;
font-weight:bold;
}

.txtnormal{
font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:12px;
}

.isikiri{
border-bottom:1px solid;
border-left:1px solid;
border-right:1px solid;
font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:11px;
}
.isi{
border-bottom:1px solid;
border-right:1px solid;
font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:11px;
}
.headerKiri{
border-bottom:1px solid;
border-left:1px solid;
border-right:1px solid;
border-top:1px solid;
font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:14px;
font-weight:bold;
text-wrap:normal;
text-align:center;
}
.header{
border-bottom:1px solid;
border-right:1px solid;
border-top:1px solid;
font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:14px;
font-weight:bold;
text-align:center;
}
.headerTengah{
border-bottom:1px solid;
border-right:1px solid;
border-top:0px solid;
font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:14px;
font-weight:bold;
text-align:center;
}
.headerLoop{
border-top:1px solid;
border-right:1px solid;
font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:14px;
font-weight:bold;
text-align:center;
}

</style>
<?php
function tglSQL($tgl){
   $t=explode(" ",$tgl);
   $t=explode("-",$t[0]);
   $t=$t[2].'-'.$t[1].'-'.$t[0];
   return $t;
}

include("../koneksi/konek.php");

$kunjungan_id = $_REQUEST['kunjungan_id'];
$idunit = $_REQUEST['idunit'];

if($idunit=='0'){
	$fUnit = "";
}
else{
	$fUnit = " AND UNIT_ID=".$idunit;
}

$sql="SELECT DISTINCT
  DATE_FORMAT(k.tgl, '%Y-%m-%d') tgl1,
  DATE_FORMAT(k.tgl_pulang, '%Y-%m-%d') tgl2,
  DATE_FORMAT(k.tgl, '%d-%m-%Y') tgl_masuk,
  DATE_FORMAT(k.tgl_pulang, '%d-%m-%Y') tgl_keluar,
  mp.no_rm,
  mp.nama nama,
  k.umur_thn,
  k.no_anggota,
  k.no_sjp,
  GROUP_CONCAT(DISTINCT md.nama SEPARATOR '; ') diagnosa,
  GROUP_CONCAT(DISTINCT pg.nama SEPARATOR '|') dokter,
  IF(pk.keadaan_keluar LIKE '%sembuh%','1','0') S,
  IF(pk.keadaan_keluar LIKE '%rujuk%','1','0') R,
  IF(pk.keadaan_keluar LIKE '%kontrol%','1','0') P,  
  IF(pk.keadaan_keluar LIKE '%meninggal%','1','0') M,
  u.nama ruangan,
  pk.cara_keluar,
  pk.keadaan_keluar
FROM
  $dbbilling.b_kunjungan k 
  INNER JOIN $dbbilling.b_ms_pasien mp 
    ON k.pasien_id = mp.id 
  INNER JOIN $dbbilling.b_pelayanan p 
    ON k.id = p.kunjungan_id 
  INNER JOIN $dbbilling.b_diagnosa d 
    ON d.kunjungan_id = k.id 
  INNER JOIN $dbbilling.b_ms_diagnosa md 
    ON md.id = d.ms_diagnosa_id 
  INNER JOIN $dbbilling.b_ms_pegawai pg 
    ON pg.id = p.dokter_id
  INNER JOIN $dbbilling.b_pasien_keluar pk
    ON pk.kunjungan_id = k.id
  INNER JOIN $dbbilling.b_ms_unit u
    ON u.id = k.unit_id
WHERE k.id = '".$kunjungan_id."'";
$queri=mysqli_query($konek,$sql);
$row=mysqli_fetch_array($queri);
$dokter = $row['dokter'];
$tgl1 = $row['tgl1'];
$tgl2 = $row['tgl2'];

if($tgl2==''){
	$fTgl = " WHERE TGL >= '".$row['tgl1']."'";	
}
else{
	$fTgl = " WHERE TGL BETWEEN '".$row['tgl1']."' AND '".$row['tgl2']."'";
}

$sDokter="SELECT DISTINCT 
		  GROUP_CONCAT(DISTINCT ap.DOKTER SEPARATOR '|') dokter 
		FROM
		  $dbbilling.b_pelayanan p 
		  INNER JOIN 
			(SELECT 
			  * 
			FROM
			  $dbapotek.a_penjualan $fTgl $fUnit) ap 
			ON ap.NO_KUNJUNGAN = p.id 
		  INNER JOIN $dbapotek.a_penerimaan pn 
			ON pn.ID = ap.PENERIMAAN_ID 
		WHERE p.kunjungan_id = '".$kunjungan_id."'";
$qDokter=mysqli_query($konek,$sDokter);
$rDoks=mysqli_fetch_array($qDokter);
$rDok=$rDoks['dokter'];
?>
<title>CATATAN PEMBERIAN OBAT</title><table width="1200" cellspacing="0" cellpadding="0">
  <tr height="20">
    <td height="20" width="26">&nbsp;</td>
    <td width="161">&nbsp;</td>
    <td width="168">&nbsp;</td>
    <td width="54">&nbsp;</td>
    <td width="34">&nbsp;</td>
    <td colspan="3" align="center" class="jdl1">CATATAN PEMBERIAN OBAT</td>
    <td width="16">&nbsp;</td>
    <td width="71">&nbsp;</td>
    <td width="350">&nbsp;</td>
    <td width="42">&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="24" colspan="4" class="jdl2"><?=$namaRS;?></td>
    <td>&nbsp;</td>
    <td colspan="3" align="center" class="jdl2">(CPO)</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20" colspan="2" class="txtnormal">Kode :</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3" align="center">________________________</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="19">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="124">&nbsp;</td>
    <td width="89">&nbsp;</td>
    <td width="63">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td class="txtnormal">Nama Pasien</td>
    <td colspan="2" class="txtnormal">: <?php echo $row['nama']; ?></td>
    <td>&nbsp;</td>
    <td class="txtnormal">Masuk Tanggal</td>
    <td class="txtnormal">: <?php echo $row['tgl_masuk']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="txtnormal">Diagnosa</td>
    <td colspan="2" rowspan="2" valign="top" class="txtnormal">: <?php echo $row['diagnosa']; ?></td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td class="txtnormal">Umur</td>
    <td colspan="2" class="txtnormal">: <?php echo $row['umur_thn']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td class="txtnormal">No. Peserta</td>
    <td colspan="2" class="txtnormal">: <?php echo $row['no_anggota']; ?></td>
    <td>&nbsp;</td>
    <td class="txtnormal">Keluar Tanggal/Kead.</td>
    <td class="txtnormal">: <?php echo $row['tgl_keluar']; ?></td>
    <td class="txtnormal"><span id="txtS" style="font-weight:<?php if($row['S']=='1') echo "bold"; else "normal"; ?>">S</span> / <span id="txtR" style="font-weight:<?php if($row['R']=='1') echo "bold"; else "normal"; ?>">R</span> / <span id="txtP" style="font-weight:<?php if($row['P']=='1') echo "bold"; else "normal"; ?>">P</span> / <span id="txtM" style="font-weight:<?php if($row['M']=='1') echo "bold"; else "normal"; ?>">M</span></td>
    <td>&nbsp;</td>
    <td class="txtnormal">Dokter</td>
    <td class="txtnormal" rowspan="4" style="vertical-align:top">:
    <table width="99%" cellpadding="0" cellspacing="0" style="float:right">
    <?php
	$l_dokter = explode("|",$rDok);
	for($i=0;$i<count($l_dokter);$i++){
	?>
    <tr>
    	<td width="8%" align="center" class="txtnormal"><?php echo ($i+1)."."; ?></td>
        <td width="92%" align="left" class="txtnormal"><?php echo $l_dokter[$i]; ?></td>
    </tr>
    <?php
	}
	?>
    </table>
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td class="txtnormal">Ruangan</td>
    <?php
	$sRuangan="SELECT 
				  GROUP_CONCAT(mu.nama SEPARATOR '; ') AS tempat 
				FROM
				  $dbbilling.b_kunjungan k 
				  INNER JOIN $dbbilling.b_pelayanan p 
					ON k.id = p.kunjungan_id 
				  INNER JOIN $dbbilling.b_ms_unit mu 
					ON mu.id = p.unit_id 
				WHERE k.id = '".$kunjungan_id."' 
				ORDER BY p.tgl";
	$qRuangan=mysqli_query($konek,$sRuangan);
	$rRuangan=mysqli_fetch_array($qRuangan);
	$ruangan=$rRuangan['tempat'];
	?>
    <td colspan="2" class="txtnormal">: <?php echo $ruangan; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td class="txtnormal">No. MR</td>
    <td colspan="2" class="txtnormal">: <?php echo $row['no_rm']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td class="txtnormal">Surat Jaminan Perawatan&nbsp;</td>
    <td colspan="2" class="txtnormal">: Nomor <?php echo $row['no_sjp']; ?></td>
    <td class="txtnormal">Dari</td>
    <td>&nbsp;</td>
    <td class="txtnormal">Kode :</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="1200" cellspacing="0" cellpadding="0">
  <tr height="20">
    <td rowspan="4" height="80" width="66" class="headerKiri">R/No</td>
    <td rowspan="4" width="269" class="header">Nama Obat</td>
    <td rowspan="4" width="85" class="header">Dosis</td>
    <td rowspan="4" width="65" class="header">D/ND</td>
    <?php
  $sUnit="SELECT DISTINCT 
  ap.TGL,
  DATE_FORMAT(ap.TGL,'%d/%m/%Y') tgl_label,
  au.UNIT_ID,
  au.UNIT_NAME 
FROM
  $dbbilling.b_pelayanan p 
  INNER JOIN 
    (SELECT 
      * 
    FROM
      $dbapotek.a_penjualan $fTgl $fUnit) ap 
    ON ap.NO_KUNJUNGAN = p.id 
  INNER JOIN $dbapotek.a_penerimaan pn 
    ON pn.ID = ap.PENERIMAAN_ID 
  INNER JOIN $dbapotek.a_unit au 
    ON au.UNIT_ID = ap.UNIT_ID 
WHERE p.kunjungan_id = '".$kunjungan_id."' 
ORDER BY ap.TGL,au.UNIT_NAME";
  $qUnit=mysqli_query($konek,$sUnit);
  $jml=mysqli_num_rows($qUnit);
  //$j=0;
  $data=array();
  while($rUnit=mysqli_fetch_array($qUnit)){
  	$temp = array($rUnit['TGL'],$rUnit['UNIT_ID'],$rUnit['UNIT_NAME'],$rUnit['tgl_label']);
	array_push($data,$temp);
  }
  ?>
  <?php
  for($i=0;$i<$jml;$i++){
  ?>
    <td colspan="4" class="headerLoop">Tgl</td>
  <?php
  }
  ?>
    <td colspan="2" rowspan="2" class="header">Jumlah</td>
    <td rowspan="4" width="141" class="header">Keterangan</td>
  </tr>
  <tr height="20">
  <?php
  for($i=0;$i<$jml;$i++){
  ?>
    <td colspan="4" height="20" class="headerTengah"><?php echo $data[$i][3]; ?></td>
  <?php
  }
  ?>
  </tr>
  <tr height="20">
  <?php
  for($i=0;$i<$jml;$i++){
  ?>
    <td colspan="4" height="20" class="headerTengah">Unit : <?php echo $data[$i][2]; ?></td>
  <?php
  }
  ?>
    <td width="85" class="headerTengah" rowspan="2">QTY</td>
    <td width="96" class="headerTengah" rowspan="2">Nilai</td>
  </tr>
  <tr height="20">
  <?php
  for($i=0;$i<$jml;$i++){
  ?>
    <td width="61" height="20" class="headerTengah">P</td>
    <td width="110" class="headerTengah">Si</td>
    <td width="110" class="headerTengah">Sr</td>
    <td width="110" class="headerTengah">M</td>
  <?php
  }
  ?>
  </tr>
  <tr height="20">
    <td height="20" class="isikiri" align="center" bgcolor="#999999">1</td>
    <td class="isi" align="center" bgcolor="#999999">2</td>
    <td class="isi" align="center" bgcolor="#999999">3</td>
    <td class="isi" align="center" bgcolor="#999999">4</td>
    <?php
	$nH = 4;
    for($i=0;$i<$jml;$i++){
    ?>
    <td class="isi" align="center" bgcolor="#999999"><?php $nH++; echo $nH; ?></td>
    <td class="isi" align="center" bgcolor="#999999"><?php $nH++; echo $nH; ?></td>
    <td class="isi" align="center" bgcolor="#999999"><?php $nH++; echo $nH; ?></td>
    <td class="isi" align="center" bgcolor="#999999"><?php $nH++; echo $nH; ?></td>
    <?php
	}
	?>
    <td class="isi" align="center" bgcolor="#999999"><?php $nH++; echo $nH; ?></td>
    <td class="isi" align="center" bgcolor="#999999"><?php $nH++; echo $nH; ?></td>
    <td class="isi" align="center" bgcolor="#999999"><?php $nH++; echo $nH; ?></td>
  </tr>
  <?php
  $sObat="SELECT DISTINCT 
  ao.OBAT_ID,
  ao.OBAT_NAMA,
  ao.OBAT_DOSIS
FROM
  $dbbilling.b_pelayanan p 
  INNER JOIN 
    (SELECT 
      * 
    FROM
      $dbapotek.a_penjualan $fTgl $fUnit) ap 
    ON ap.NO_KUNJUNGAN = p.id 
  INNER JOIN $dbapotek.a_penerimaan pn 
    ON pn.ID = ap.PENERIMAAN_ID 
  INNER JOIN $dbapotek.a_obat ao 
    ON ao.OBAT_ID = pn.OBAT_ID 
  INNER JOIN $dbapotek.a_unit au 
    ON au.UNIT_ID = ap.UNIT_ID 
WHERE p.kunjungan_id = '".$kunjungan_id."' 
ORDER BY ao.OBAT_NAMA";
  $qObat=mysqli_query($konek,$sObat);
  $no=0;
  $totQTY=0;
  $totNilai=0;
  while($rObat=mysqli_fetch_array($qObat)){
  $totO = 0;
  $totN = 0;
  $no++;
  ?>
  <tr height="20">
    <td height="20" class="isikiri" align="center"><?php echo $no; ?></td>
    <td class="isi">&nbsp;<?php echo $rObat['OBAT_NAMA']; ?></td>
    <td class="isi">&nbsp;<?php echo $rObat['OBAT_DOSIS']; ?></td>
    <td class="isi">&nbsp;</td>
    <?php
  	for($i=0;$i<$jml;$i++){
		$sJum="SELECT 
  au.UNIT_NAME,
  au.UNIT_ID,
  ao.OBAT_NAMA,
  ap.SUB_TOTAL AS HARGA_TOTAL,
  IFNULL(SUM(IF(ap.SHIFT = '1', ap.QTY, 0)),0) P,
  IFNULL(SUM(IF(ap.SHIFT = '2', ap.QTY, 0)),0) Si,
  IFNULL(SUM(IF(ap.SHIFT = '0', ap.QTY, 0)),0) Sr,
  IFNULL(SUM(IF(ap.SHIFT = '3', ap.QTY, 0)),0) M 
FROM
  $dbbilling.b_pelayanan p 
  INNER JOIN 
    (SELECT 
      * 
    FROM
      $dbapotek.a_penjualan $fTgl $fUnit) ap 
    ON ap.NO_KUNJUNGAN = p.id 
  INNER JOIN $dbapotek.a_penerimaan pn 
    ON pn.ID = ap.PENERIMAAN_ID 
  INNER JOIN $dbapotek.a_obat ao 
    ON ao.OBAT_ID = pn.OBAT_ID 
  INNER JOIN $dbapotek.a_unit au 
    ON au.UNIT_ID = ap.UNIT_ID 
WHERE p.kunjungan_id = '".$kunjungan_id."' 
  AND ao.OBAT_ID = ".$rObat['OBAT_ID']." 
  AND au.UNIT_ID = ".$data[$i][1]."
  AND ap.TGL = '".$data[$i][0]."'";
        //echo $sJum."<br>";
  		$qJum=mysqli_query($konek,$sJum);
		$rJum=mysqli_fetch_array($qJum);
		$totO = $totO + $rJum['P'] + $rJum['Si'] + $rJum['Sr'] + $rJum['M'];
		$totN = $totN + $rJum['HARGA_TOTAL'];
  	?>
    <td class="isi" align="center"><?php if($rJum['P']=='0') echo "&nbsp;"; else echo $rJum['P']; ?></td>
    <td class="isi" align="center"><?php if($rJum['Si']=='0') echo "&nbsp;"; else echo $rJum['Si']; ?></td>
    <td class="isi" align="center"><?php if($rJum['Sr']=='0') echo "&nbsp;"; else echo $rJum['Sr']; ?></td>
    <td class="isi" align="center"><?php if($rJum['M']=='0') echo "&nbsp;"; else echo $rJum['M']; ?></td>
    <?php
	}
	?>
    <td class="isi" align="center"><?php if($totO=='0'){ echo "&nbsp;"; }else{ echo $totO; } $totQTY= $totQTY+$totO; ?></td>
    <td class="isi" align="right" style="padding-right:5px;"><?php if($totN=='0'){ echo "&nbsp;"; }else{ echo number_format($totN,0,',','.'); } $totNilai=$totNilai+$totN; ?></td>
    <td class="isi" align="center">&nbsp;</td>
  </tr>
  <?php
  }
  ?>
  <tr height="20">
    <td height="20" class="isikiri" bgcolor="#999999">&nbsp;</td>
    <td class="isi" bgcolor="#999999">&nbsp;</td>
    <td class="isi" bgcolor="#999999">&nbsp;</td>
    <td class="isi" bgcolor="#999999">&nbsp;</td>
    <?php
  	for($i=0;$i<$jml;$i++){
  	?>
    <td class="isi" bgcolor="#999999">&nbsp;</td>
    <td class="isi" bgcolor="#999999">&nbsp;</td>
    <td class="isi" bgcolor="#999999">&nbsp;</td>
    <td class="isi" bgcolor="#999999">&nbsp;</td>
    <?php
	}
	?>
    <td class="isi" align="center" style="font-weight:bold" bgcolor="#999999"><?php echo number_format($totQTY,0,',','.'); ?></td>
    <td class="isi" align="right" style="padding-right:5px; font-weight:bold" bgcolor="#999999"><?php echo number_format($totNilai,0,',','.'); ?></td>
    <td class="isi" bgcolor="#999999">&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20" class="isikiri">&nbsp;</td>
    <td class="isi" style="font-weight:bold">Tanda Tangan Peserta / Keluarga</td>
    <td class="isi">&nbsp;</td>
    <td class="isi">&nbsp;</td>
    <?php
    for($i=0;$i<$jml;$i++){
    ?>
    <td class="isi">&nbsp;</td>
    <td class="isi">&nbsp;</td>
    <td class="isi">&nbsp;</td>
    <td class="isi">&nbsp;</td>
    <?php
	}
	?>
    <td class="isi">&nbsp;</td>
    <td class="isi">&nbsp;</td>
    <td class="isi">&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20" class="isikiri">&nbsp;</td>
    <td class="isi" style="font-weight:bold">Mengetahui Petugas</td>
    <td class="isi">&nbsp;</td>
    <td class="isi">&nbsp;</td>
    <?php
  	for($i=0;$i<$jml;$i++){
  	?>
    <td class="isi">&nbsp;</td>
    <td class="isi">&nbsp;</td>
    <td class="isi">&nbsp;</td>
    <td class="isi">&nbsp;</td>
    <?php
	}
	?>
    <td class="isi">&nbsp;</td>
    <td class="isi">&nbsp;</td>
    <td class="isi">&nbsp;</td>
  </tr>
</table>
<table width="1200" cellspacing="0" cellpadding="0">
<tr>
	<td width="98">&nbsp;</td>
    <td width="98">&nbsp;</td>
    <td width="98">&nbsp;</td>
    <td width="466">&nbsp;</td>
    <td width="301">&nbsp;</td>
    <td width="137">&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center" class="txtnormal" style="font-weight:bold">Ka. Ruangan</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center">( ............................ )</td>
    <td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
</table>
<script>
</script>