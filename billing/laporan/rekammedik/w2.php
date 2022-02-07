<?php
if($_POST['isExcel']=='yes'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="W2.xls"');
}

include("../../koneksi/konek.php");
$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
$waktu = $_POST['cmbWaktu'];
if($waktu == 'Harian'){
	$tglAwal = explode('-',$_REQUEST['tglAwal2']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	$waktu = "AND DATE(p.tgl) = '$tglAwal2' ";
	$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
}else if($waktu == 'Bulanan'){
	$bln = $_POST['cmbBln'];
	$thn = $_POST['cmbThn'];
	$waktu = "AND month(p.tgl) = '$bln' AND year(p.tgl) = '$thn' ";        
	$Periode = "Bulan $arrBln[$bln] Tahun $thn";
}else{
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	$waktu = "AND DATE(p.tgl) between '$tglAwal2' and '$tglAkhir2' ";
	$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
}

$JnsLayanan = $_REQUEST['cmbJenisLayanan'];
$TmpLayanan = $_REQUEST['cmbTempatLayanan'];

if($TmpLayanan==0){
	if($JnsLayanan==1){
		$fUnit = "AND p.jenis_kunjungan=3";
		$txtTmpt = "RAWAT INAP - SEMUA";
		$txtJudul = "Rawat Inap";
	}
	else{
		$fUnit = "AND p.jenis_kunjungan<>3";
		$txtTmpt = "RAWAT JALAN - SEMUA";
		$txtJudul = "Rawat Jalan";
	}
}
else{
	$sTmp = "SELECT nama FROM b_ms_unit WHERE id=".$TmpLayanan;
	$qTmp = mysql_query($sTmp);
	$rwTmp = mysql_fetch_array($qTmp);
	$txtTmp = $rwTmp['nama'];
	$fUnit = " AND p.unit_id = ".$TmpLayanan;
	
	if($JnsLayanan==1){
		$txtTmpt = "RAWAT INAP - ".$txtTmp;
	}
	else{
		$txtTmpt = "RAWAT JALAN - ".$txtTmp;
	}
}

	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
    $rsPeg = mysql_query($sqlPeg);
    $rwPeg = mysql_fetch_array($rsPeg);

$date_now=gmdate('d-m-Y',mktime(date('H')+7));
$jam = date("G:i");
?>
<title>Laporan W2</title>

<form id="formW2" name="formW2" action="w2_detil.php" target="_new" method="post">
<input type="hidden" id="cmbWaktu" name="cmbWaktu" value="<?php echo $_POST['cmbWaktu']; ?>" />
<input type="hidden" id="tglAwal2" name="tglAwal2" value="<?php echo $_POST['tglAwal2']; ?>" />
<input type="hidden" id="tglAwal" name="tglAwal" value="<?php echo $_POST['tglAwal']; ?>" />
<input type="hidden" id="tglAkhir" name="tglAkhir" value="<?php echo $_POST['tglAkhir']; ?>" />
<input type="hidden" id="cmbBln" name="cmbBln" value="<?php echo $_POST['cmbBln']; ?>" />
<input type="hidden" id="cmbThn" name="cmbThn" value="<?php echo $_POST['cmbThn']; ?>" />
<input type="hidden" id="cmbJenisLayanan" name="cmbJenisLayanan" value="<?php echo $_POST['cmbJenisLayanan']; ?>" />
<input type="hidden" id="cmbTempatLayanan" name="cmbTempatLayanan" value="<?php echo $_POST['cmbTempatLayanan']; ?>" />
<input type="hidden" id="kec" name="kec" />
<input type="hidden" id="kolom" name="kolom" />

<table width="100%" border="0">
  <tr align="center">
    <td colspan="3"><strong>LAPORAN WABAH<br /><?php echo $Periode; ?><br /><?php echo $txtTmpt; ?></strong></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr align="right">
    <td colspan="3">Jml Persalinan : <?php ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					Jml Kelahiran Hidup : <?php ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; w2	</td>
  </tr>
  <tr>
    <td colspan="3"><table width="100%" border="1" style="border-collapse:collapse">
  <tr align="center" style="background:#999">
    <td rowspan="3" style="border:1px solid black">No</td>
    <td rowspan="3" style="border:1px solid black">Kecamatan</td>
    <td colspan="4" style="border:1px solid black">Diare</td>
    <td colspan="2" rowspan="2" style="border:1px solid black">DBD</td>
    <td colspan="2" rowspan="2" style="border:1px solid black">Polio/AFP</td>
    <td colspan="2" rowspan="2" style="border:1px solid black">Difteri</td>
    <td colspan="4" style="border:1px solid black">Campak</td>
    <td colspan="2" style="border:1px solid black">Pneumonia</td>
    <td colspan="2" rowspan="2" style="border:1px solid black">Tetanus<br>Neo</td>
    <td colspan="2" rowspan="2" style="border:1px solid black">Gizi Buruk </td>
    <td colspan="2" rowspan="2" style="border:1px solid black">TB Positif </td>
    <td rowspan="3" style="border:1px solid black">Kematian<br>Bayi</td>
    <td rowspan="3" style="border:1px solid black">Kematian<br>Neo</td>
    <td rowspan="3" style="border:1px solid black">ILI</td>
  </tr>
  <tr align="center" style="background:#999">
    <td colspan="2" style="border:1px solid black"><5Th</td>
    <td colspan="2" style="border:1px solid black">>5Th</td>
    <td colspan="2" style="border:1px solid black"><5Th</td>
    <td colspan="2" style="border:1px solid black">>5Th</td>
    <td colspan="2" style="border:1px solid black"><5Th</td>
    </tr>
  <tr align="center" style="background:#999">
    <td style="border:1px solid black">P</td>
    <td style="border:1px solid black">M</td>
    <td style="border:1px solid black">P</td>
    <td style="border:1px solid black">M</td>
    <td style="border:1px solid black">P</td>
    <td style="border:1px solid black">M</td>
    <td style="border:1px solid black">P</td>
    <td style="border:1px solid black">M</td>
    <td style="border:1px solid black">P</td>
    <td style="border:1px solid black">M</td>
    <td style="border:1px solid black">P</td>
    <td style="border:1px solid black">M</td>
    <td style="border:1px solid black">P</td>
    <td style="border:1px solid black">M</td>
    <td style="border:1px solid black">P</td>
    <td style="border:1px solid black">M</td>
    <td style="border:1px solid black">P</td>
    <td style="border:1px solid black">M</td>
    <td style="border:1px solid black">P</td>
    <td style="border:1px solid black">M</td>
    <td style="border:1px solid black">P</td>
    <td style="border:1px solid black">M</td>
    </tr>
  <tr align="center" style="background:#999">
    <td style="border:1px solid black">1</td>
    <td style="border:1px solid black">2</td>
    <td style="border:1px solid black">3</td>
    <td style="border:1px solid black">4</td>
    <td style="border:1px solid black">5</td>
    <td style="border:1px solid black">6</td>
    <td style="border:1px solid black">7</td>
    <td style="border:1px solid black">8</td>
    <td style="border:1px solid black">9</td>
    <td style="border:1px solid black">10</td>
    <td style="border:1px solid black">11</td>
    <td style="border:1px solid black">12</td>
    <td style="border:1px solid black">13</td>
    <td style="border:1px solid black">14</td>
    <td style="border:1px solid black">15</td>
    <td style="border:1px solid black">16</td>
    <td style="border:1px solid black">17</td>
    <td style="border:1px solid black">18</td>
    <td style="border:1px solid black">19</td>
    <td style="border:1px solid black">20</td>
    <td style="border:1px solid black">21</td>
    <td style="border:1px solid black">22</td>
    <td style="border:1px solid black">23</td>
    <td style="border:1px solid black">24</td>
    <td style="border:1px solid black">25</td>
    <td style="border:1px solid black">26</td>
    <td style="border:1px solid black">27</td>
  </tr>
  <?php
/*  $sKota="SELECT
	id,
	nama
	FROM b_ms_wilayah
	WHERE LEVEL=3 AND parent_id='51506'
	UNION
	SELECT
	0,
	'LAINNYA'";*/  // KOTA MEDAN
  //$sKota="SELECT id,nama FROM b_ms_wilayah WHERE id='51523'";
    $sKota="SELECT
	id, nama, CONCAT('1',nama) AS tmpn
	FROM b_ms_wilayah
	WHERE LEVEL=3 AND parent_id='51506' AND id = 51507
	UNION
	SELECT id, nama, nama FROM b_ms_wilayah AS tmpn WHERE LEVEL=3 AND parent_id='51506' AND id NOT IN (51507)
	order by tmpn";
  $qKota=mysql_query($sKota);
  
  	$tot3=0;
	$tot4=0;
	$tot5=0;
	$tot6=0;
	$tot7=0;
	$tot8=0;
	$tot9=0;
	$tot10=0;
	$tot11=0;
	$tot12=0;
	$tot13=0;
	$tot14=0;
	$tot15=0;
	$tot16=0;
	$tot17=0;
	$tot18=0;
	$tot19=0;
	$tot20=0;
	$tot21=0;
	$tot22=0;
	$tot23=0;
	$tot24=0;
	$tot25=0;
	$tot26=0;
	$tot27=0;
  
  $no=0;
  while($rwKota=mysql_fetch_array($qKota)){
  	$no++;
	
	if($rwKota['id']=='0'){
		$fKota="WHERE kec.parent_id<>'51506'";	
	}
	else{
		$fKota="WHERE kec.id='".$rwKota['id']."'";
	}
	
	/*$sql="SELECT 
	 Diare 
  SUM(IF(mdg.DG_KODE = '005' AND k.umur_hr < 5, 1, NULL)) AS col3,
  SUM(IF(mdg.DG_KODE = '005' AND k.umur_hr < 5 AND pk.cara_keluar = 'Meninggal', 1, NULL)) AS col4,
  SUM(IF(mdg.DG_KODE = '005' AND k.umur_hr > 5, 1, NULL)) AS col5,
  SUM(IF(mdg.DG_KODE = '005' AND k.umur_hr > 5 AND pk.cara_keluar = 'Meninggal', 1, NULL)) AS col6,
   DBD 
  SUM(IF(mdg.DG_KODE = '032.1', 1, NULL)) AS col7,
  SUM(IF(mdg.DG_KODE = '032.1' AND pk.cara_keluar = 'Meninggal', 1, NULL)) AS col8,
   Polio 
  SUM(IF(mdg.DG_KODE = '028', 1, NULL)) AS col9,
  SUM(IF(mdg.DG_KODE = '028' AND pk.cara_keluar = 'Meninggal', 1, NULL)) AS col10,
   Difteri 
  SUM(IF(mdg.DG_KODE = '014', 1, NULL)) AS col11,
  SUM(IF(mdg.DG_KODE = '014' AND pk.cara_keluar = 'Meninggal', 1, NULL)) AS col12,
   Campak 
  SUM(IF(mdg.DG_KODE = '035' AND k.umur_hr < 5, 1, NULL)) AS col13,
  SUM(IF(mdg.DG_KODE = '035' AND k.umur_hr < 5 AND pk.cara_keluar = 'Meninggal', 1, NULL)) AS col14,
  SUM(IF(mdg.DG_KODE = '035' AND k.umur_hr > 5, 1, NULL)) AS col15,
  SUM(IF(mdg.DG_KODE = '035' AND k.umur_hr > 5 AND pk.cara_keluar = 'Meninggal', 1, NULL)) AS col16,
   Pneumonia 
  SUM(IF(mdg.DG_KODE = 'I69' AND k.umur_hr < 5, 1, NULL)) AS col17,
  SUM(IF(mdg.DG_KODE = 'I69' AND k.umur_hr < 5 AND pk.cara_keluar = 'Meninggal', 1, NULL)) AS col18,
   Tetanus Neo 
  SUM(IF(mdg.DG_KODE = '012', 1, NULL)) AS col19,
  SUM(IF(mdg.DG_KODE = '012' AND pk.cara_keluar = 'Meninggal', 1, NULL)) AS col20,
   Gizi Buruk 
  SUM(IF(mdg.DG_KODE = 'I08', 1, NULL)) AS col21,
  SUM(IF(mdg.DG_KODE = 'I08' AND pk.cara_keluar = 'Meninggal', 1, NULL)) AS col22,
   TB Positif 
  SUM(IF(mdg.DG_KODE = '007.0', 1, NULL)) AS col23,
  SUM(IF(mdg.DG_KODE = '007.0' AND pk.cara_keluar = 'Meninggal', 1, NULL)) AS col24,
   Kematian Bayi 
  SUM(IF(k.umur_hr >= 0 AND k.umur_hr <= 28 AND pk.cara_keluar = 'Meninggal', 1, NULL)) AS col25,
   Kematian Neo 
  SUM(IF(pk.cara_keluar = 'Meninggal', 1, NULL)) AS col26,
   ILI 
  SUM(IF(mdg.DG_KODE IN ('I68','I68.0'), 1, NULL)) AS col27
FROM
  (SELECT 
    * 
  FROM
    b_ms_diagnosa 
  WHERE aktif = 1) AS md
  INNER JOIN b_ms_diagnosa_gol mdg
    ON mdg.DG_KODE = md.dg_kode 
  INNER JOIN b_diagnosa_rm d 
    ON d.ms_diagnosa_id = md.id 
  INNER JOIN b_pelayanan p 
    ON p.id = d.pelayanan_id 
  INNER JOIN b_kunjungan k 
    ON k.id = p.kunjungan_id 
  INNER JOIN b_ms_pasien ps 
    ON ps.id = p.pasien_id
  INNER JOIN b_ms_wilayah kec
    ON kec.id=ps.kec_id
  LEFT JOIN b_pasien_keluar pk
    ON pk.pelayanan_id = p.id
$fKota 
AND mdg.DG_KODE IN ('005','032.1','028','014','035','I69','012','I08','007.0','I68','I68.0')
$fUnit
$waktu
GROUP BY kec.id
ORDER BY kec.nama";*/

	$sql="SELECT 
	/* Diare */
  SUM(IF(md.kode LIKE 'A09%' AND k.umur_thn < 5, 1, NULL)) AS col3,
  SUM(IF(md.kode LIKE 'A09%' AND k.umur_thn < 5 AND pk.cara_keluar = 'Meninggal', 1, NULL)) AS col4,
  SUM(IF(md.kode LIKE 'A09%' AND k.umur_thn > 5, 1, NULL)) AS col5,
  SUM(IF(md.kode LIKE 'A09%' AND k.umur_thn > 5 AND pk.cara_keluar = 'Meninggal', 1, NULL)) AS col6,
  /* DBD */
  SUM(IF(md.kode LIKE 'A91%', 1, NULL)) AS col7,
  SUM(IF(md.kode LIKE 'A91%' AND pk.cara_keluar = 'Meninggal', 1, NULL)) AS col8,
  /* Polio */
  SUM(IF(md.kode LIKE 'A80.9%', 1, NULL)) AS col9,
  SUM(IF(md.kode LIKE 'A80.9%' AND pk.cara_keluar = 'Meninggal', 1, NULL)) AS col10,
  /* Difteri */
  SUM(IF(md.kode LIKE 'A36%', 1, NULL)) AS col11,
  SUM(IF(md.kode LIKE 'A36%' AND pk.cara_keluar = 'Meninggal', 1, NULL)) AS col12,
  /* Campak */
  SUM(IF(md.kode LIKE 'B05%' AND k.umur_thn < 5, 1, NULL)) AS col13,
  SUM(IF(md.kode LIKE 'B05%' AND k.umur_thn < 5 AND pk.cara_keluar = 'Meninggal', 1, NULL)) AS col14,
  SUM(IF(md.kode LIKE 'B05%' AND k.umur_thn >= 5, 1, NULL)) AS col15,
  SUM(IF(md.kode LIKE 'B05%' AND k.umur_thn >= 5 AND pk.cara_keluar = 'Meninggal', 1, NULL)) AS col16,
  /* Pneumonia */
  SUM(IF((md.kode LIKE 'J18%' OR md.kode LIKE 'J12%') AND k.umur_thn < 5, 1, NULL)) AS col17,
  SUM(IF((md.kode LIKE 'J18%' OR md.kode LIKE 'J12%') AND k.umur_thn < 5 AND pk.cara_keluar = 'Meninggal', 1, NULL)) AS col18,
  /* Tetanus Neo */
  SUM(IF(md.kode LIKE 'A33%', 1, NULL)) AS col19,
  SUM(IF(md.kode LIKE 'A33%' AND pk.cara_keluar = 'Meninggal', 1, NULL)) AS col20,
  /* Gizi Buruk */
  SUM(IF((md.kode BETWEEN 'E40' AND 'E46') OR md.kode LIKE 'E40%', 1, NULL)) AS col21,
  SUM(IF(((md.kode BETWEEN 'E40' AND 'E46') OR md.kode LIKE 'E40%') AND pk.cara_keluar = 'Meninggal', 1, NULL)) AS col22,
  /* TB Positif */
  SUM(IF((md.kode = 'A15') OR (md.kode = 'A15.0'), 1, NULL)) AS col23,
  SUM(IF(((md.kode = 'A15') OR (md.kode = 'A15.0')) AND pk.cara_keluar = 'Meninggal', 1, NULL)) AS col24,
  /* Kematian Bayi */
  SUM(IF(k.umur_thn >= 0 AND k.umur_thn <= 28 AND pk.cara_keluar = 'Meninggal', 1, NULL)) AS col25,
  /* Kematian Neo */
  SUM(IF(pk.cara_keluar = 'Meninggal', 1, NULL)) AS col26,
  /* ILI */
  /*SUM(IF(mdg.DG_KODE IN ('I68','I68.0'), 1, NULL)) AS col27*/
  CONCAT('') AS col27
FROM
  (SELECT 
    * 
  FROM
    b_ms_diagnosa 
  WHERE aktif = 1) AS md
  /*INNER JOIN b_ms_diagnosa_gol mdg
    ON mdg.DG_KODE = md.dg_kode*/ 
  INNER JOIN b_diagnosa_rm d 
    ON d.ms_diagnosa_id = md.id 
  INNER JOIN b_pelayanan p 
    ON p.id = d.pelayanan_id 
  INNER JOIN b_kunjungan k 
    ON k.id = p.kunjungan_id 
  INNER JOIN b_ms_pasien ps 
    ON ps.id = p.pasien_id
  INNER JOIN b_ms_wilayah kec
    ON kec.id=ps.kec_id
  LEFT JOIN b_pasien_keluar pk
    ON pk.pelayanan_id = p.id
$fKota 
/*AND mdg.DG_KODE IN ('005','032.1','028','014','035','I69','012','I08','007.0','I68','I68.0')*/
$fUnit
$waktu
AND d.kasus_baru = 1
GROUP BY kec.id
ORDER BY kec.nama";
//echo $sql."<br>";
  $queri=mysql_query($sql);
  $rows=mysql_fetch_array($queri);

$tot3=$tot3+$rows['col3'];
$tot4=$tot4+$rows['col4'];
$tot5=$tot5+$rows['col5'];
$tot6=$tot6+$rows['col6'];
$tot7=$tot7+$rows['col7'];
$tot8=$tot8+$rows['col8'];
$tot9=$tot9+$rows['col9'];
$tot10=$tot10+$rows['col10'];
$tot11=$tot11+$rows['col11'];
$tot12=$tot12+$rows['col12'];
$tot13=$tot13+$rows['col13'];
$tot14=$tot14+$rows['col14'];
$tot15=$tot15+$rows['col15'];
$tot16=$tot16+$rows['col16'];
$tot17=$tot17+$rows['col17'];
$tot18=$tot18+$rows['col18'];
$tot19=$tot19+$rows['col19'];
$tot20=$tot20+$rows['col20'];
$tot21=$tot21+$rows['col21'];
$tot22=$tot22+$rows['col22'];
$tot23=$tot23+$rows['col23'];
$tot24=$tot24+$rows['col24'];
$tot25=$tot25+$rows['col25'];
$tot26=$tot26+$rows['col26'];
$tot27=$tot27+$rows['col27'];
  ?>
  <tr>
    <td align="center"><?php echo $no; ?></td>
    <td>&nbsp;<?php echo $rwKota['nama']; ?></td>
    <td align="center">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwKota['id']; ?>,3)"><?php echo $rows['col3']; ?></a></td>
    <td align="center">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwKota['id']; ?>,4)"><?php echo $rows['col4']; ?></a></td>
    <td align="center">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwKota['id']; ?>,5)"><?php echo $rows['col5']; ?></a></td>
    <td align="center">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwKota['id']; ?>,6)"><?php echo $rows['col6']; ?></a></td>
    <td align="center">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwKota['id']; ?>,7)"><?php echo $rows['col7']; ?></a></td>
    <td align="center">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwKota['id']; ?>,8)"><?php echo $rows['col8']; ?></a></td>
    <td align="center">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwKota['id']; ?>,9)"><?php echo $rows['col9']; ?></a></td>
    <td align="center">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwKota['id']; ?>,10)"><?php echo $rows['col10']; ?></a></td>
    <td align="center">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwKota['id']; ?>,11)"><?php echo $rows['col11']; ?></a></td>
    <td align="center">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwKota['id']; ?>,12)"><?php echo $rows['col12']; ?></a></td>
    <td align="center">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwKota['id']; ?>,13)"><?php echo $rows['col13']; ?></a></td>
    <td align="center">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwKota['id']; ?>,14)"><?php echo $rows['col14']; ?></a></td>
    <td align="center">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwKota['id']; ?>,15)"><?php echo $rows['col15']; ?></a></td>
    <td align="center">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwKota['id']; ?>,16)"><?php echo $rows['col16']; ?></a></td>
    <td align="center">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwKota['id']; ?>,17)"><?php echo $rows['col17']; ?></a></td>
    <td align="center">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwKota['id']; ?>,18)"><?php echo $rows['col18']; ?></a></td>
    <td align="center">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwKota['id']; ?>,19)"><?php echo $rows['col19']; ?></a></td>
    <td align="center">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwKota['id']; ?>,20)"><?php echo $rows['col20']; ?></a></td>
    <td align="center">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwKota['id']; ?>,21)"><?php echo $rows['col21']; ?></a></td>
    <td align="center">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwKota['id']; ?>,22)"><?php echo $rows['col22']; ?></a></td>
    <td align="center">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwKota['id']; ?>,23)"><?php echo $rows['col23']; ?></a></td>
    <td align="center">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwKota['id']; ?>,24)"><?php echo $rows['col24']; ?></a></td>
    <td align="center">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwKota['id']; ?>,25)"><?php echo $rows['col25']; ?></a></td>
    <td align="center">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwKota['id']; ?>,26)"><?php //echo $rows['col26']; ?></a></td>
    <td align="center">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwKota['id']; ?>,27)"><?php echo $rows['col27']; ?></a></td>
  </tr>
  <?php
  }
  ?>
  <tr>
    <td colspan="2" align="center"><strong>JUMLAH</strong></td>
    <td align="center">&nbsp;<?php echo $tot3; ?></td>
    <td align="center">&nbsp;<?php echo $tot4; ?></td>
    <td align="center">&nbsp;<?php echo $tot5; ?></td>
    <td align="center">&nbsp;<?php echo $tot6; ?></td>
    <td align="center">&nbsp;<?php echo $tot7; ?></td>
    <td align="center">&nbsp;<?php echo $tot8; ?></td>
    <td align="center">&nbsp;<?php echo $tot9; ?></td>
    <td align="center">&nbsp;<?php echo $tot10; ?></td>
    <td align="center">&nbsp;<?php echo $tot11; ?></td>
    <td align="center">&nbsp;<?php echo $tot12; ?></td>
    <td align="center">&nbsp;<?php echo $tot13; ?></td>
    <td align="center">&nbsp;<?php echo $tot14; ?></td>
    <td align="center">&nbsp;<?php echo $tot15; ?></td>
    <td align="center">&nbsp;<?php echo $tot16; ?></td>
    <td align="center">&nbsp;<?php echo $tot17; ?></td>
    <td align="center">&nbsp;<?php echo $tot18; ?></td>
    <td align="center">&nbsp;<?php echo $tot19; ?></td>
    <td align="center">&nbsp;<?php echo $tot20; ?></td>
    <td align="center">&nbsp;<?php echo $tot21; ?></td>
    <td align="center">&nbsp;<?php echo $tot22; ?></td>
    <td align="center">&nbsp;<?php echo $tot23; ?></td>
    <td align="center">&nbsp;<?php echo $tot24; ?></td>
    <td align="center">&nbsp;<?php echo $tot25; ?></td>
    <td align="center">&nbsp;<?php echo "0";//echo $tot26; ?></td>
    <td align="center">&nbsp;<?php echo $tot27; ?></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="20%"><i>Tanggal diterima<br>Dinkes Kota Tgr</i></td>
        <td style="border:1px solid black" width="20%">&nbsp;</td>
        <td width="5%">&nbsp;</td>
      </tr>
    </table></td>
    <td><table width="100%" border="0">
        <tr><td width="20%">&nbsp;</td>
          <td>Mengetahui,<br>
          Direktur RS .................... </td>
        </tr>
      </table></td>
    <td><table width="100%" border="0">
  <tr>
    <td width="20%">&nbsp;</td>
    <td>Medan, <?php echo $date_now; ?><br>
      Pelaksana Survelian</td>
  </tr>
</table>
</td>
  </tr>
  <tr>
  	<td colspan="3">&nbsp;</td>
  </tr>
  <tr>
		<td colspan="3" style="border-top:1px solid #000; padding-top:5px; font-size:13px;" align="right">
			Printed By : <?php echo $rwPeg['nama']; ?>
		</td>
	</tr>
</table>
</form>
<script>
function fSubmit(kec,kolom){
	document.formW2.kec.value=kec;
	document.formW2.kolom.value=kolom;
	document.formW2.submit();	
}
</script>