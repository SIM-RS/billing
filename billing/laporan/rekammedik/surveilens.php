<?php
if($_POST['isExcel']=='yes'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="surveilens.xls"');
}

    include("../../koneksi/konek.php");
    
    $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
    $waktu = $_POST['cmbWaktu'];
    if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        $waktu = "AND DATE(d.tgl) = '$tglAwal2' ";
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
        $bln = $_POST['cmbBln'];
        $thn = $_POST['cmbThn'];
        $waktu = "AND month(d.tgl) = '$bln' AND year(d.tgl) = '$thn' ";        
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = "AND DATE(d.tgl) between '$tglAwal2' and '$tglAkhir2' ";
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" class="isi">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Laporan STP</title>
<style>
.border{
border:1px solid;
}
.jdlkiri{
border:1px solid;
font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:14px;
}
.jdl{
border-bottom:1px solid;
border-top:1px solid;
border-right:1px solid;
font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:14px;
}
.isikiri{
border-bottom:1px solid;
border-left:1px solid;
border-right:1px solid;
font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:12px;
}
.isi{
border-bottom:1px solid;
border-right:1px solid;
font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:12px;
}
.mainTdKiri{
border-bottom:1px solid;
border-left:1px solid;
border-top:1px solid;
font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:14px;
}
.mainTdTengah{
border-bottom:1px solid; 
border-top:1px solid;
font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:14px;
}
.mainTdKanan{
border-top:1px solid;
border-right:1px solid;
border-bottom:1px solid;
font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:14px;
}
.rsud{
font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:16px;
font-style:italic;
}
.txtKecil{
font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:13px;
}
.txtKecil1{
font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:11px;
}
.textJdl{
text-decoration:underline; 
font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:20px; 
font-weight:bold;
text-transform:uppercase;
text-align:center;
}

.textJdl1{
font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:18px; 
font-weight:bold;
text-transform:uppercase;
text-align:center;
}
.txt{
font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:16px;
}
.txt2{
font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:14px;
}
.jdlDlmBold{font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:16px;
font-weight:bold;
text-transform:uppercase;
border-bottom:1px solid;
border-top:1px solid;
border-right:1px solid;
}
.jdlDlm{font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:16px;
text-transform:uppercase;
border-bottom:1px solid;
border-top:1px solid;
border-right:1px solid;
}
.rotate{
writing-mode: tb-rl;
-webkit-transform: rotate(270deg);	
-moz-transform: rotate(270deg);
-ms-transform: rotate(270deg);
-o-transform: rotate(270deg);
transform: rotate(270deg);
width: 100px;
}
.txt2Bold{
font-family:Geneva, Arial, Helvetica, sans-serif;
font-size:14px;
font-weight:bold;
}
</style>
</head>
<body>
<form id="formSur" name="formSur" action="surveilens_detil.php" target="_new" method="post">
<input type="hidden" id="cmbWaktu" name="cmbWaktu" value="<?php echo $_POST['cmbWaktu']; ?>" />
<input type="hidden" id="tglAwal2" name="tglAwal2" value="<?php echo $_POST['tglAwal2']; ?>" />
<input type="hidden" id="tglAwal" name="tglAwal" value="<?php echo $_POST['tglAwal']; ?>" />
<input type="hidden" id="tglAkhir" name="tglAkhir" value="<?php echo $_POST['tglAkhir']; ?>" />
<input type="hidden" id="cmbBln" name="cmbBln" value="<?php echo $_POST['cmbBln']; ?>" />
<input type="hidden" id="cmbThn" name="cmbThn" value="<?php echo $_POST['cmbThn']; ?>" />
<input type="hidden" id="cmbJenisLayanan" name="cmbJenisLayanan" value="<?php echo $_POST['cmbJenisLayanan']; ?>" />
<input type="hidden" id="cmbTempatLayanan" name="cmbTempatLayanan" value="<?php echo $_POST['cmbTempatLayanan']; ?>" />
<input type="hidden" id="sur" name="sur" />
<input type="hidden" id="kolom" name="kolom" />

<table width="1340" cellpadding="0" cellspacing="0" align="center">
<tr>
	<td class="txt" align="center" height="104" valign="top" colspan="2">SURVEILENS TERPADU PENYAKIT BERBASIS RUMAH SAKIT SENTINEL<br />
    (KASUS BARU)<br /><?php echo $txtTmpt; ?><br /><?php echo $Periode; ?></td>
</tr>
<tr>
	<td width="106" class="txt2">Propinsi</td>
    <td width="1232" class="txt2">:&nbsp;BANTEN</td>
</tr>
<tr>
	<td class="txt2">Kota</td>
    <td class="txt2">:&nbsp;MEDAN</td>
</tr>
<tr>
	<td>Rumah Sakit</td>
    <td class="txt2">:&nbsp;RS PELINDO I</td>
</tr>
</table>
<br />
<table cellspacing="0" cellpadding="0" align="center" width="1400">
  <tr height="17">
    <td rowspan="3" height="68" width="61" class="jdlkiri" align="center">No</td>
    <td rowspan="3" width="213" class="jdl" align="center">Jenis Penyakit</td>
    <td colspan="30" class="jdl" align="center">RS <?php echo $txtJudul; ?></td>
  </tr>
  <tr height="17">
    <td colspan="24" height="17" align="center" class="isi">GOLONGAN UMUR ( Tahun )</td>
    <td colspan="2" height="17" align="center" class="isi">Total</td>
    <td rowspan="2" width="64" align="center" class="isi">Total Kunjungan</td>
    <td rowspan="2" width="62" align="center" class="isi">Meninggal</td>
  </tr>
  <tr height="17">
    <td colspan="2" height="17" class="isi" align="center" width="25">0-7Hr</td>
    <td colspan="2" class="isi" align="center" width="25">8-28Hr</td>
    <td colspan="2" class="isi" align="center" width="25">&lt;1</td>
    <td colspan="2" class="isi" align="center" width="25">1-4</td>
    <td colspan="2" class="isi" align="center" width="25">5-9</td>
    <td colspan="2" class="isi" align="center" width="25">10-14</td>
    <td colspan="2" class="isi" align="center" width="25">15-19</td>
    <td colspan="2" class="isi" align="center" width="25">20-44</td>
    <td colspan="2" class="isi" align="center" width="25">45-54</td>
    <td colspan="2" class="isi" align="center" width="25">55-59</td>
    <td colspan="2" class="isi" align="center" width="25">60-69</td>
    <td colspan="2" class="isi" align="center" width="25">70+</td>
    <td width="63" align="center" class="isi" >L</td>
    <td width="60" align="center" class="isi" >P</td>
  </tr>
  <tr height="18">
    <td height="18" align="center" class="isikiri">1</td>
    <td align="center" class="isi">2</td>
    <td colspan="2" class="isi" align="center">3</td>
    <td colspan="2" class="isi" align="center">4</td>
    <td colspan="2" class="isi" align="center">5</td>
    <td colspan="2" class="isi" align="center">6</td>
    <td colspan="2" class="isi" align="center">7</td>
    <td colspan="2" class="isi" align="center">8</td>
    <td colspan="2" class="isi" align="center">9</td>
    <td colspan="2" class="isi" align="center">10</td>
    <td colspan="2" class="isi" align="center">11</td>
    <td colspan="2" class="isi" align="center">12</td>
    <td colspan="2" class="isi" align="center">13</td>
    <td colspan="2" class="isi" align="center">14</td>
    <td class="isi" align="center">15</td>
    <td align="center" class="isi">16</td>
    <td align="center" class="isi">17</td>
    <td align="center" class="isi">18</td>
  </tr>
  <?php
  $sSur="SELECT
		id,
		nama 
		FROM b_ms_diagnosa_surveilens
		ORDER BY id";
  $qSur=mysql_query($sSur);		
  
  //echo $sql."<br>";

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

$no=1;
while($rwSur=mysql_fetch_array($qSur)){
	
$sql="SELECT 
  SUM(IF(k.umur_thn = 0 AND k.umur_bln = 0 AND k.umur_hr >= 0 AND k.umur_hr <= 7, 1, NULL)) AS col3,
  SUM(IF(k.umur_thn = 0 AND k.umur_bln = 0 AND k.umur_hr >= 8 AND k.umur_hr <= 28, 1, NULL)) AS col4,
  SUM(IF(k.umur_thn < 1, 1, NULL)) AS col5,
  SUM(IF(k.umur_thn >= 1 AND k.umur_thn <= 4, 1, NULL)) AS col6,
  SUM(IF(k.umur_thn >= 5 AND k.umur_thn <= 9, 1, NULL)) AS col7,
  SUM(IF(k.umur_thn >= 10 AND k.umur_thn <= 14, 1, NULL)) AS col8,
  SUM(IF(k.umur_thn >= 15 AND k.umur_thn <= 19, 1, NULL)) AS col9,
  SUM(IF(k.umur_thn >= 20 AND k.umur_thn <= 44, 1, NULL)) AS col10,
  SUM(IF(k.umur_thn >= 45 AND k.umur_thn <= 54, 1, NULL)) AS col11,
  SUM(IF(k.umur_thn >= 55 AND k.umur_thn <= 59, 1, NULL)) AS col12,
  SUM(IF(k.umur_thn >= 60 AND k.umur_thn <= 69, 1, NULL)) AS col13,
  SUM(IF(k.umur_thn >= 70, 1, NULL)) AS col14,
  SUM(IF(ps.sex = 'L', 1, NULL)) AS col15,
  SUM(IF(ps.sex = 'P', 1, NULL)) AS col16,
  SUM(1) AS col17,
  SUM(IF(pk.cara_keluar = 'Meninggal', 1, NULL)) AS col18
FROM
  (SELECT 
    * 
  FROM
    b_ms_diagnosa 
  WHERE aktif = 1) AS md
  INNER JOIN b_ms_diagnosa_surveilens mds
    ON mds.id = md.surveilens_id 
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
WHERE d.kasus_baru=1 AND d.primer = 1 AND mds.id='".$rwSur['id']."'
$waktu $fUnit
GROUP BY mds.id
ORDER BY mds.id";

//echo $sql."<br/>";
$queri=mysql_query($sql);
$row=mysql_fetch_array($queri);	
	
$tot3=$tot3+$row['col3'];
$tot4=$tot4+$row['col4'];
$tot5=$tot5+$row['col5'];
$tot6=$tot6+$row['col6'];
$tot7=$tot7+$row['col7'];
$tot8=$tot8+$row['col8'];
$tot9=$tot9+$row['col9'];
$tot10=$tot10+$row['col10'];
$tot11=$tot11+$row['col11'];
$tot12=$tot12+$row['col12'];
$tot13=$tot13+$row['col13'];
$tot14=$tot14+$row['col14'];
$tot15=$tot15+$row['col15'];
$tot16=$tot16+$row['col16'];
$tot17=$tot17+$row['col17'];
$tot18=$tot18+$row['col18'];	
?>
  <tr height="17">
    <td height="17" class="isikiri" align="center">&nbsp;<?php echo $no; ?></td>
    <td class="isi">&nbsp;<?php echo $rwSur['nama']; ?></td>
    <td align="center" class="isi" colspan="2">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwSur['id']; ?>,3)"><?php echo $row['col3']; ?></a></td>
    <td align='center' class="isi" colspan="2">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwSur['id']; ?>,4)"><?php echo $row['col4']; ?></a></td>
    <td align='center' class="isi" colspan="2">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwSur['id']; ?>,5)"><?php echo $row['col5']; ?></a></td>
    <td align='center' class="isi" colspan="2">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwSur['id']; ?>,6)"><?php echo $row['col6']; ?></a></td>
    <td align='center' class="isi" colspan="2">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwSur['id']; ?>,7)"><?php echo $row['col7']; ?></a></td>
    <td align='center' class="isi" colspan="2">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwSur['id']; ?>,8)"><?php echo $row['col8']; ?></a></td>
    <td align='center' class="isi" colspan="2">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwSur['id']; ?>,9)"><?php echo $row['col9']; ?></a></td>
    <td align='center' class="isi" colspan="2">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwSur['id']; ?>,10)"><?php echo $row['col10']; ?></a></td>
    <td align='center' class="isi" colspan="2">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwSur['id']; ?>,11)"><?php echo $row['col11']; ?></a></td>
    <td align='center' class="isi" colspan="2">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwSur['id']; ?>,12)"><?php echo $row['col12']; ?></a></td>
    <td align='center' class="isi" colspan="2">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwSur['id']; ?>,13)"><?php echo $row['col13']; ?></a></td>
    <td align='center' class="isi" colspan="2">&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwSur['id']; ?>,14)"><?php echo $row['col14']; ?></a></td>
    <td class="isi" align='center'>&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwSur['id']; ?>,15)"><?php echo $row['col15']; ?></a></td>
    <td class="isi" align='center'>&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwSur['id']; ?>,16)"><?php echo $row['col16']; ?></a></td>
    <td class="isi" align='center'>&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwSur['id']; ?>,17)"><?php echo $row['col17']; ?></a></td>
    <td class="isi" align='center'>&nbsp;<a href="javascript:void(0)" onclick="fSubmit(<?php echo $rwSur['id']; ?>,18)"><?php echo $row['col18']; ?></a></td>
  </tr>
  <?php 
  $no++; 
}
  ?>
  <tr height="17">
    <td height="17" colspan="2" class="isikiri" align="center">JUMLAH</td>
    <td colspan="2" class="isi" align="center"><?php echo $tot3; ?></td>
    <td colspan="2" class="isi" align="center"><?php echo $tot4; ?></td>
    <td colspan="2" class="isi" align="center"><?php echo $tot5; ?></td>
    <td colspan="2" class="isi" align="center"><?php echo $tot6; ?></td>
    <td colspan="2" class="isi" align="center"><?php echo $tot7; ?></td>
    <td colspan="2" class="isi" align="center"><?php echo $tot8; ?></td>
    <td colspan="2" class="isi" align="center"><?php echo $tot9; ?></td>
    <td colspan="2" class="isi" align="center"><?php echo $tot10; ?></td>
    <td colspan="2" class="isi" align="center"><?php echo $tot11; ?></td>
    <td colspan="2" class="isi" align="center"><?php echo $tot12; ?></td>
    <td colspan="2" class="isi" align="center"><?php echo $tot13; ?></td>
    <td colspan="2" class="isi" align="center"><?php echo $tot14; ?></td>
    <td class="isi" align="center"><?php echo $tot15; ?></td>
    <td class="isi" align="center"><?php echo $tot16; ?></td>
    <td class="isi" align="center"><?php echo $tot17; ?></td>
    <td class="isi" align="center"><?php echo $tot18; ?></td>
  </tr>
  <tr>
  	<td colspan="30">&nbsp;</td>
  </tr>
  <tr>
		<td colspan="30" style="border-top:1px solid #000; padding-top:5px; font-size:13px;" align="right">
			Printed By : <?php echo $rwPeg['nama']; ?>
		</td>
	</tr>
  <tr id="trTombol">
     <td colspan="30" class="noline" align="center">
        <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak();"/>
        <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
     </td>
  </tr>
</table>
</form>
</body>
</html>
<script type="text/JavaScript">
function cetak(){
	var tombol=document.getElementById('trTombol').style.visibility='collapse';
	if(tombol=='collapse'){
		window.print();
		window.close(); 
	}
}

function fSubmit(sur,kolom){
	document.formSur.sur.value=sur;
	document.formSur.kolom.value=kolom;
	document.formSur.submit();	
}
</script>