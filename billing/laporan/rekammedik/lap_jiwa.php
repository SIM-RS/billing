<?php
session_start();
include("../../sesi.php");

if($_POST['isExcel']=='yes'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="lap_jiwa.xls"');
}

?>
<title>.: Laporan Kegiatan Kesehatan Jiwa :.</title>
<?php
    include ("../../koneksi/konek.php");
    $date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$semester = $_POST['cmbTri'];
	$thn = $_POST['cmbThnTri'];
	if($_POST['cmbTri']=='1'){
		$bln = "TRIBULAN I : JANUARI - MARET";
		$waktu = " AND MONTH(p.tgl) BETWEEN '1' AND '3' ";
		$tahun = " AND YEAR(p.tgl)='".$thn."' ";
	}elseif($_POST['cmbTri']=='2'){
		$bln = "TRIBULAN II : APRIL - JUNI";
		$waktu = " AND MONTH(p.tgl) BETWEEN '4' AND '6' ";
		$tahun = " AND YEAR(p.tgl)='".$thn."' ";
	}elseif($_POST['cmbTri']=='3'){
		$bln = "TRIBULAN III : JULI - SEPTEMBER";
		$waktu = " AND MONTH(p.tgl) BETWEEN '7' AND '9' ";
		$tahun = " AND YEAR(p.tgl)='".$thn."' ";
	}else{
		$bln = "TRIBULAN IV : OKTOBER - DESEMBER";
		$waktu = " AND MONTH(p.tgl) BETWEEN '10' AND '12' ";
		$tahun = " AND YEAR(p.tgl)='".$thn."' ";
	} 
    
    $jnsLay = $_REQUEST['JnsLayanan'];
    $tmpLay = $_REQUEST['TmpLayananPsi'];
    
    
    $sqlUnit = "SELECT id,nama FROM b_ms_unit WHERE id = '".$tmpLay."'";
    $rsUnit = mysql_query($sqlUnit);
    $rwUnit = mysql_fetch_array($rsUnit);
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
    $rsPeg = mysql_query($sqlPeg);
    $rwPeg = mysql_fetch_array($rsPeg);
	
	/*
	no 1 : 	F20(F20.0)
			F21,F22.0,F23(F23.0,F23.1,F23.2),F25
	*/
	//Psikosis
	$sql="SELECT IFNULL(SUM(IF(pk.kasus=1,1,0)),0) baru,IFNULL(SUM(IF(pk.kasus=1,0,1)),0) lama 
FROM (SELECT * FROM (SELECT *,REPLACE(kode,' ','') kode1 FROM b_ms_diagnosa) md 
WHERE md.kode1 LIKE 'F20%' OR md.kode1 LIKE 'F21%' OR md.kode1 LIKE 'F22%' 
OR md.kode1 LIKE 'F23%' OR md.kode1 LIKE 'F25%') d1
INNER JOIN b_diagnosa_rm d ON d1.id=d.ms_diagnosa_id
INNER JOIN b_pelayanan p ON d.pelayanan_id=p.id
LEFT JOIN b_pasien_keluar pk ON p.id=pk.pelayanan_id
WHERE p.unit_id='".$tmpLay."' ".$tahun.$waktu;
	//echo $sql."<br>";
	$rs=mysql_query($sql);
	$rw=mysql_fetch_array($rs);
	$psikosis_baru=$rw['baru'];
	$psikosis_lama=$rw['lama'];
	//Psikosis Rujukan Pusk
	$sql="SELECT IFNULL(SUM(IF(pk.kasus=1,1,0)),0) baru,IFNULL(SUM(IF(pk.kasus=1,0,1)),0) lama 
FROM (SELECT * FROM (SELECT *,REPLACE(kode,' ','') kode1 FROM b_ms_diagnosa) md 
WHERE md.kode1 LIKE 'F20%' OR md.kode1 LIKE 'F21%' OR md.kode1 LIKE 'F22%' 
OR md.kode1 LIKE 'F23%' OR md.kode1 LIKE 'F25%') d1
INNER JOIN b_diagnosa_rm d ON d1.id=d.ms_diagnosa_id
INNER JOIN b_pelayanan p ON d.pelayanan_id=p.id
LEFT JOIN b_pasien_keluar pk ON p.id=pk.pelayanan_id
INNER JOIN b_kunjungan k ON p.kunjungan_id=k.id
WHERE p.unit_id='".$tmpLay."' AND k.asal_kunjungan=13 ".$tahun.$waktu;
	//echo $sql."<br>";
	$rs=mysql_query($sql);
	$rw=mysql_fetch_array($rs);
	$psikosis_baru_pusk=$rw['baru'];
	$psikosis_lama_pusk=$rw['lama'];
	//Psikosis dirujuk ke RSJ
	$sql="SELECT IFNULL(SUM(IF(pk.kasus=1,1,0)),0) baru,IFNULL(SUM(IF(pk.kasus=1,0,1)),0) lama 
FROM (SELECT * FROM (SELECT *,REPLACE(kode,' ','') kode1 FROM b_ms_diagnosa) md 
WHERE md.kode1 LIKE 'F20%' OR md.kode1 LIKE 'F21%' OR md.kode1 LIKE 'F22%' 
OR md.kode1 LIKE 'F23%' OR md.kode1 LIKE 'F25%') d1
INNER JOIN b_diagnosa_rm d ON d1.id=d.ms_diagnosa_id
INNER JOIN b_pelayanan p ON d.pelayanan_id=p.id
LEFT JOIN b_pasien_keluar pk ON p.id=pk.pelayanan_id
INNER JOIN b_ms_tujuan_rujukan mtr ON pk.rs_id=mtr.id
WHERE p.unit_id='".$tmpLay."' AND LEFT(mtr.nama,3)='RSJ' ".$tahun.$waktu;
	//echo $sql."<br>";
	$rs=mysql_query($sql);
	$rw=mysql_fetch_array($rs);
	$psikosis_baru_RSJ=$rw['baru'];
	$psikosis_lama_RSJ=$rw['lama'];
	//Napza
	$sql="SELECT IFNULL(SUM(IF(pk.kasus=1,1,0)),0) baru,IFNULL(SUM(IF(pk.kasus=1,0,1)),0) lama 
FROM (SELECT * FROM (SELECT *,REPLACE(kode,' ','') kode1 FROM b_ms_diagnosa) md 
WHERE md.kode1 LIKE 'F10%' OR md.kode1 LIKE 'F11%' OR md.kode1 LIKE 'F12%' 
OR md.kode1 LIKE 'F13%' OR md.kode1 LIKE 'F14%' OR md.kode1 LIKE 'F15%' 
OR md.kode1 LIKE 'F16%' OR md.kode1 LIKE 'F17%' OR md.kode1 LIKE 'F18%' OR md.kode1 LIKE 'F19%') d1
INNER JOIN b_diagnosa_rm d ON d1.id=d.ms_diagnosa_id
INNER JOIN b_pelayanan p ON d.pelayanan_id=p.id
LEFT JOIN b_pasien_keluar pk ON p.id=pk.pelayanan_id
WHERE p.unit_id='".$tmpLay."' ".$tahun.$waktu;
	//echo $sql."<br>";
	$rs=mysql_query($sql);
	$rw=mysql_fetch_array($rs);
	$napza_baru=$rw['baru'];
	$napza_lama=$rw['lama'];
	//Retardasi
	$sql="SELECT IFNULL(SUM(IF(pk.kasus=1,1,0)),0) baru,IFNULL(SUM(IF(pk.kasus=1,0,1)),0) lama 
FROM (SELECT * FROM (SELECT *,REPLACE(kode,' ','') kode1 FROM b_ms_diagnosa) md 
WHERE md.kode1 LIKE 'F70%' OR md.kode1 LIKE 'F71%' OR md.kode1 LIKE 'F72%' OR md.kode1 LIKE 'F73%') d1
INNER JOIN b_diagnosa_rm d ON d1.id=d.ms_diagnosa_id
INNER JOIN b_pelayanan p ON d.pelayanan_id=p.id
LEFT JOIN b_pasien_keluar pk ON p.id=pk.pelayanan_id
WHERE p.unit_id='".$tmpLay."' ".$tahun.$waktu;
	//echo $sql."<br>";
	$rs=mysql_query($sql);
	$rw=mysql_fetch_array($rs);
	$retardasi_baru=$rw['baru'];
	$retardasi_lama=$rw['lama'];
	//Epilepsi
	$sql="SELECT IFNULL(SUM(IF(pk.kasus=1,1,0)),0) baru,IFNULL(SUM(IF(pk.kasus=1,0,1)),0) lama 
FROM (SELECT * FROM (SELECT *,REPLACE(kode,' ','') kode1 FROM b_ms_diagnosa) md 
WHERE md.kode1 LIKE 'G40%') d1
INNER JOIN b_diagnosa_rm d ON d1.id=d.ms_diagnosa_id
INNER JOIN b_pelayanan p ON d.pelayanan_id=p.id
LEFT JOIN b_pasien_keluar pk ON p.id=pk.pelayanan_id
WHERE p.unit_id='".$tmpLay."' ".$tahun.$waktu;
	//echo $sql."<br>";
	$rs=mysql_query($sql);
	$rw=mysql_fetch_array($rs);
	$epilepsi_baru=$rw['baru'];
	$epilepsi_lama=$rw['lama'];
	//G Jiwa Lain
	$sql="SELECT IFNULL(SUM(IF(pk.kasus=1,1,0)),0) baru,IFNULL(SUM(IF(pk.kasus=1,0,1)),0) lama 
FROM (SELECT * FROM (SELECT *,REPLACE(kode,' ','') kode1 FROM b_ms_diagnosa) md 
WHERE md.kode1 LIKE 'F30%' OR md.kode1 LIKE 'F31%' OR md.kode1 LIKE 'F32%' OR md.kode1 LIKE 'F33%' OR md.kode1 LIKE 'F34%') d1
INNER JOIN b_diagnosa_rm d ON d1.id=d.ms_diagnosa_id
INNER JOIN b_pelayanan p ON d.pelayanan_id=p.id
LEFT JOIN b_pasien_keluar pk ON p.id=pk.pelayanan_id
WHERE p.unit_id='".$tmpLay."' ".$tahun.$waktu;
	//echo $sql."<br>";
	$rs=mysql_query($sql);
	$rw=mysql_fetch_array($rs);
	$g_jiwa_lain_baru=$rw['baru'];
	$g_jiwa_lain_lama=$rw['lama'];
	//Geriatri Dementia
	$sql="SELECT IFNULL(SUM(IF(pk.kasus=1,1,0)),0) baru,IFNULL(SUM(IF(pk.kasus=1,0,1)),0) lama 
FROM (SELECT * FROM (SELECT *,REPLACE(kode,' ','') kode1 FROM b_ms_diagnosa) md 
WHERE md.kode1 LIKE 'F00%' OR md.kode1 LIKE 'F01%' OR md.kode1 LIKE 'F02%' OR md.kode1 LIKE 'F03%') d1
INNER JOIN b_diagnosa_rm d ON d1.id=d.ms_diagnosa_id
INNER JOIN b_pelayanan p ON d.pelayanan_id=p.id
LEFT JOIN b_pasien_keluar pk ON p.id=pk.pelayanan_id
WHERE p.unit_id='".$tmpLay."' ".$tahun.$waktu;
	//echo $sql."<br>";
	$rs=mysql_query($sql);
	$rw=mysql_fetch_array($rs);
	$dementia_baru=$rw['baru'];
	$dementia_lama=$rw['lama'];
	//Neurosis
	$sql="SELECT IFNULL(SUM(IF(pk.kasus=1,1,0)),0) baru,IFNULL(SUM(IF(pk.kasus=1,0,1)),0) lama 
FROM (SELECT * FROM (SELECT *,REPLACE(kode,' ','') kode1 FROM b_ms_diagnosa) md 
WHERE md.kode1 LIKE 'F40%' OR md.kode1 LIKE 'F41%' OR md.kode1 LIKE 'F42%' OR md.kode1 LIKE 'F43%' 
OR md.kode1 LIKE 'F44%' OR md.kode1 LIKE 'F45%' OR md.kode1 LIKE 'F48%') d1
INNER JOIN b_diagnosa_rm d ON d1.id=d.ms_diagnosa_id
INNER JOIN b_pelayanan p ON d.pelayanan_id=p.id
LEFT JOIN b_pasien_keluar pk ON p.id=pk.pelayanan_id
WHERE p.unit_id='".$tmpLay."' ".$tahun.$waktu;
	//echo $sql."<br>";
	$rs=mysql_query($sql);
	$rw=mysql_fetch_array($rs);
	$neurosis_baru=$rw['baru'];
	$neurosis_lama=$rw['lama'];
?>
<style>
	.jdl{
		border-right:1px solid #FFFFFF;
		border-bottom:1px solid #FFFFFF;
		height:30;
		font-size:12px;
		text-transform:uppercase;
		text-align:center;
	}
</style>
<table width="800" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td style="text-align:center; font-weight:bold; text-transform:uppercase; font-size:14px;" height="75" valign="top">laporan kegiatan kesehatan jiwa<br />tempat layanan <u><?php echo $rwUnit['nama'];?></u><br /><?php echo $bln.'&nbsp;'.$thn;?></td>
  </tr>
  <tr>
    <td><table width="100%" border="1" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; border-collapse:collapse">
      <tr>
        <td height="30" align="center" style="font-size:14px;text-transform:uppercase">no</td>
        <td align="center" style="font-size:14px;text-transform:uppercase">jenis kegiatan</td>
        <td align="center" style="font-size:14px;text-transform:uppercase">jumlah</td>
      </tr>
      
      <tr>
        <td height="22" style="text-align:center;" bgcolor="#FFCCFF">1</td>
        <td style="text-align:center;" bgcolor="#FFCCFF">2</td>
        <td style="text-align:center;" bgcolor="#FFCCFF">3</td>
      </tr>
      <tr>
        <td height="22" width="5%" style="text-align:center;">1</td>
        <td width="75%" style="padding-left:5px;">Jumlah penderita baru psikosis yang ditemukan/diobati</td>
        <td width="20%" style="text-align:center;"><?php echo number_format($psikosis_baru,0,",","."); ?></td>
      </tr>
      <tr>
        <td height="22" align="center">2</td>
        <td style="padding-left:5px;">Jumlah penderita baru penyalahgunaan obat/narkotika yang ditemukan/diobati</td>
        <td style="text-align:center;"><?php echo number_format($napza_baru,0,",","."); ?></td>
      </tr>
      <tr>
        <td height="22" align="center">3</td>
        <td style="padding-left:5px;">Jumlah penderita baru retardasi mental yang ditemukan/diobati</td>
        <td style="text-align:center;"><?php echo number_format($retardasi_baru,0,",","."); ?></td>
      </tr>
      <tr>
        <td height="22" style="text-align:center;">4</td>
        <td style="padding-left:5px;">Jumlah penderita baru epilepsi yang ditemukan/diobati</td>
        <td style="text-align:center;"><?php echo number_format($epilepsi_baru,0,",","."); ?></td>
      </tr>
      <tr>
        <td height="22" style="text-align:center;">5</td>
        <td style="padding-left:5px;">Jumlah penderita baru gangguan jiwa lain yang ditemukan/diobati:</td>
        <td style="text-align:center;"><?php echo number_format($g_jiwa_lain_baru,0,",","."); ?></td>
      </tr>
      <tr style="display:none">
        <td height="22" style="text-align:center;">&nbsp;</td>
        <td style="padding-left:5px;">-&nbsp;Gangguan jiwa lain</td>
        <td style="text-align:center;"><?php echo number_format($g_jiwa_lain_baru,0,",","."); ?></td>
      </tr>
      <tr style="display:none">
        <td height="22" style="text-align:center;">&nbsp;</td>
        <td style="padding-left:5px;">-&nbsp;Geriatri dementia</td>
        <td style="text-align:center;"><?php echo number_format($dementia_baru,0,",","."); ?></td>
      </tr>
      <tr>
        <td height="22" style="text-align:center;">6</td>
        <td style="padding-left:5px;">Jumlah penderita lama psikosis/neorosis yang diobati</td>
        <td style="text-align:center;"><?php echo number_format($psikosis_lama,0,",",".")." / ".number_format($neurosis_lama,0,",","."); ?></td>
      </tr>
      <tr>
        <td height="22" style="text-align:center;">7</td>
        <td style="padding-left:5px;">Jumlah penderita lama penyalahgunaan obat, narkotika</td>
        <td style="text-align:center;"><?php echo number_format($napza_lama,0,",","."); ?></td>
      </tr>
      <tr>
        <td height="22" style="text-align:center;">8</td>
        <td style="padding-left:5px;">Jumlah penderita lama epilepsi/gangguan jiwa lain yang diobati</td>
        <td style="text-align:center;"><?php echo number_format($epilepsi_lama,0,",",".")." / ".number_format($g_jiwa_lain_lama,0,",","."); ?></td>
      </tr>
      <tr>
        <td height="22" style="text-align:center;">9</td>
        <td style="padding-left:5px;">Jumlah kunjungan pusk dalam rangka tindak lanjut perawatan pembinaan penderita psikosis</td>
        <td style="text-align:center;"><?php echo number_format(($psikosis_baru_pusk+psikosis_lama_pusk),0,",","."); ?></td>
      </tr>
      <tr>
        <td height="22" style="text-align:center;">10</td>
        <td style="padding-left:5px;">Jumlah penderita psikosis yang dirujuk kerumah sakit jiwa</td>
        <td style="text-align:center;"><?php echo number_format(($psikosis_baru_RSJ+$psikosis_lama_RSJ),0,",","."); ?></td>
      </tr>
      <tr>
        <td height="22" style="text-align:center;">11</td>
        <td style="padding-left:5px;">Jumlah pertemuan oordinasi penanganan penderita psikosis (lintas sektoral)</td>
        <td style="text-align:center;"><?php echo number_format(($psikosis_baru+$psikosis_lama),0,",","."); ?></td>
      </tr>
      <tr>
        <td height="22" style="text-align:center;">12</td>
        <td style="padding-left:5px;">Jumlah penderita lama psikosis</td>
        <td style="text-align:center;"><?php echo number_format($psikosis_lama,0,",","."); ?></td>
      </tr>
      <tr>
        <td height="22" style="text-align:center;">13</td>
        <td style="padding-left:5px;">Jumlah penderita lama neurosis/baru neurosis</td>
        <td style="text-align:center;"><?php echo number_format($neurosis_lama,0,",",".")." / ".number_format($neurosis_baru,0,",","."); ?></td>
      </tr>
      <tr>
        <td height="22" style="text-align:center;">14</td>
        <td style="padding-left:5px;">Jumlah penderita lama penyalahgunaan obat/narkotik </td>
        <td style="text-align:center;"><?php echo number_format($napza_lama,0,",","."); ?></td>
      </tr>
      <tr>
        <td height="22" style="text-align:center;">15</td>
        <td style="padding-left:5px;">Jumlah penderita lama epilepsi </td>
        <td style="text-align:center;"><?php echo number_format($epilepsi_lama,0,",","."); ?></td>
      </tr>
      <tr>
        <td height="22" style="text-align:center;">16</td>
        <td style="padding-left:5px;">Jumlah penderita lama gangguan jiwa lain</td>
        <td style="text-align:center;"><?php echo number_format($g_jiwa_lain_lama,0,",","."); ?></td>
      </tr>
      <tr style="display:none">
        <td height="22" style="text-align:center;">&nbsp;</td>
        <td style="padding-left:5px;">-&nbsp;Gangguan jiwa lain</td>
        <td style="text-align:center;"><?php echo number_format($g_jiwa_lain_lama,0,",","."); ?></td>
      </tr>
      <tr style="display:none">
        <td height="22" style="text-align:center;">&nbsp;</td>
        <td style="padding-left:5px;">-&nbsp;Geriatri dementia</td>
        <td style="text-align:center;"><?php echo number_format($dementia_lama,0,",","."); ?></td>
      </tr>
      <tr>
        <td height="22" style="text-align:center;">17</td>
        <td style="padding-left:5px;">Jumlah penderita lama retardasi mental </td>
        <td style="text-align:center;"><?php echo number_format($retardasi_lama,0,",","."); ?></td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
		<td style="padding-top:5px; font-size:12px;" align="right">
			Printed By : <?php echo $rwPeg['nama']; ?>
		</td>
	</tr>
  <tr id="trTombol">
    <td align="center"><input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<script type="text/JavaScript">

/* try{	
formatF4();
}catch(e){
window.location='../../addon/jsprintsetup.xpi';
} */
    function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
		/* try{
			mulaiPrint();
		}
		catch(e){
			window.print();
		} */
		window.print();
		window.close();
        }
    }
</script>
