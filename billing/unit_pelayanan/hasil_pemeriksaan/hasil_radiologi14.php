<?php
session_start();
include '../../koneksi/konek.php';
$idPel=$_REQUEST['idPel'];
$idKunj=$_REQUEST['idKunj'];
$id_rad=$_REQUEST['id'];
$cmbTipeHasilRad=$_REQUEST['cmbTipeHasilRad'];

$Pwidth=850;
$K1width=140;
$K2width=10;
$K3width=240;
$K4width=140;
$K5width=10;
$K6width=310;
if($cmbTipeHasilRad=="2"){
	header("Content-type: application/vnd.ms-word");
	header("Content-Disposition:attachment; filename='hasilRad.doc'");
	//$K2width=5;
	//$K5width=5;
	$K6width=350;
}elseif ($cmbTipeHasilRad=="1"){
	ob_start();
	$Pwidth=800;
	$K1width=120;
	$K2width=5;
	$K3width=240;
	$K4width=120;
	$K5width=5;
	$K6width=310;
}

$date_now=gmdate('d-m-Y H:i',mktime(date('H')+7));

$month = array('','Januari','Februari','Maret','April','Mei',"Juni",'Juli','Agustus','September','Oktober','November','Desember');
$bulan = (isset($_GET['bulan']) && !empty($_GET['bulan']) ? $_GET['bulan'] : date('m') );
$tahun = (isset($_GET['tahun']) && !empty($_GET['tahun']) ? $_GET['tahun'] : date('Y') );

if($bulan < 10){
	$bln = str_replace("0","",$bulan);
}else{
	$bln = $bulan;
}

if($bulan=='01' || $bulan=='03' || $bulan=='05' || $bulan=='07' || $bulan=='08' || $bulan=='10' || $bulan=='12'){
	$tgl = 31;
}else if($bulan == '02'){
	if(($tahun%4 == 0) && ($tahun%100 != 0)){
		$tgl = 29;
	}else{
		$tgl = 28;
	}
}else{
	$tgl = 30;
}


$sqlPas="SELECT 
  a.hasil,
  a.judul,
  a.ket_klinis,
  a.kesimpulan,
  c.no_lab,
  DATE_FORMAT(c.tgl_act,'%d-%m-%Y %H:%i') AS tgl_kunjungan,
  DATE_FORMAT(a.tgl_act,'%d-%m-%Y %H:%i') AS tgl_act,
  DATE_FORMAT(b.tgl_act,'%d-%m-%Y %H:%i') AS tgl,
  e.nama AS pasien,
  DATE_FORMAT(e.tgl_lahir,'%d-%m-%Y') AS tgl_lahir,
  e.no_rm,
  d.umur_thn,
  g.nama,
  f.nama AS dpeng,
  h.nama AS drad,
  mt.nama AS nama_tindakan,
  kso.nama AS status,
  mk.nama AS hakkelas
FROM
  b_hasil_rad a 
  INNER JOIN b_tindakan b 
    ON a.tindakan_id = b.id 
  INNER JOIN b_pelayanan c 
    ON c.id = b.pelayanan_id 
  INNER JOIN b_kunjungan d 
    ON d.id = c.kunjungan_id
  INNER JOIN b_ms_kso kso
    ON kso.id = d.kso_id
  INNER JOIN b_ms_kelas mk
    ON mk.id = d.kso_kelas_id 
  INNER JOIN b_ms_pasien e 
    ON e.id = c.pasien_id 
  LEFT JOIN b_ms_pegawai f 
    ON f.id = c.dokter_id 
  INNER JOIN b_ms_unit g 
    ON g.id = c.unit_id_asal 
  INNER JOIN b_ms_pegawai h 
    ON h.id = a.user_id
  INNER JOIN b_tindakan t 
      ON t.id = a.tindakan_id
  INNER JOIN b_ms_tindakan_kelas mtk 
      ON mtk.id = t.ms_tindakan_kelas_id 
  INNER JOIN b_ms_tindakan mt 
      ON mt.id = mtk.ms_tindakan_id WHERE a.id = '".$id_rad."'";
//echo $sqlPas."<br>";
$rs1 = mysql_query($sqlPas);
//echo mysql_error();
$rw = mysql_fetch_array($rs1);
//$drPeng = str_replace('Dr','dr',$rw['dpeng']); 
//$drRad = str_replace('Dr','dr',$rw['drad']); 
?>
<?php 
if ($cmbTipeHasilRad=="0"){
?>
<link type="text/css" rel="stylesheet" href="../../theme/print.css" />
<?php
}
?>
<style type="text/css">
p {
	margin-top:3px;
	margin-bottom:3px;
}
</style>
 <table align="center" width="<?php echo $Pwidth; ?>" border="0" cellspacing="0" cellpadding="0" style="font-weight:bold;margin-top:200px;">
  <tr>
  	<td align="center" style="font-size:18px;">HASIL PEMERIKSAAN RADIOLOGI</td>
  </tr>
  <!--tr>
  	<td align="center" style="font-size:14px;">No. Photo : <?php echo $rw["no_lab"]; ?></td>
  </tr-->
  <tr>
  	<td align="center">
        <table style="font-size:16px;text-align:left;" cellpadding="0" cellspacing="0" align="center">
          <tr>
            <td style="font-size:18px">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td style="font-size:18px">&nbsp;</td>
            <td  style="font-size:18px">&nbsp;</td>
            <td>&nbsp;</td>
            <td style="font-size:18px">&nbsp;</td>
          </tr>
          <tr>
            <td width="<?php echo $K1width; ?>">&nbsp;&nbsp;Tgl. Kunjung </td>
            <td width="<?php echo $K2width; ?>" align="center">:</td>
            <td width="<?php echo $K3width; ?>">&nbsp;<?php echo $rw['tgl_kunjungan'];?></td>
            <td width="<?php echo $K4width; ?>">Rujukan Dari</td>
            <td width="<?php echo $K5width; ?>">:</td>
            <td width="<?php echo $K6width; ?>">&nbsp;<?php echo $rw['nama'];?></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;No. RM</td>
            <td align="center">:</td>
            <td>&nbsp;<?php echo strtoupper($rw['no_rm']); ?></td>
            <td>Dokter Pengirim</td>
            <td>:</td>
            <td>&nbsp;<?php echo $rw['dpeng'];?></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;Nama Pasien </td>
            <td align="center">:</td>
            <td>&nbsp;<?php echo $rw['pasien'];?></td>
            <td>Tgl. Periksa</td>
            <td>:</td>
            <td>&nbsp;<?php echo $rw['tgl'];?></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;Tgl. Lahir</td>
            <td align="center">:</td>
            <td>&nbsp;<?php echo $rw['tgl_lahir'];?></td>
            <td>Tgl. Hasil</td>
            <td>:</td>
            <td>&nbsp;<?php echo $rw['tgl_act'];?></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;Status Px</td>
            <td align="center">:</td>
            <td>&nbsp;<?php echo $rw['status'];?></td>
            <td>Radiolog</td>
            <td>:&nbsp;</td>
            <td>&nbsp;<?php echo $rw['drad'];?></td>
          </tr>
          <tr>
            <td>&nbsp;&nbsp;Hak Kelas</td>
            <td align="center">:</td>
            <td>&nbsp;<?php echo $rw['hakkelas'];?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <!--tr>
            <td>&nbsp;&nbsp;</td>
            <td align="center"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr-->
      </table>
    </td>
  </tr>
  <tr>
  	<td style="font-size:12px; padding-left:16px; max-width:900px; word-wrap:break-word"><?php echo stripslashes($rw['hasil']);?></td>
  </tr>
  <!--tr>
  	<td>
    	<table cellpadding="0" cellspacing="0" align="center" border="0">
        	<tr>
				<?php
                     
                        $sqlPet = "select nama from b_ms_pegawai where id = $_SESSION[userId]";
                        $dt = mysql_query($sqlPet);
                        $rt = mysql_fetch_array($dt);
                        ?>
                <td width="510" style="font-weight:bold;font-size:12px"><br/></td>
                <td width="290" style="font-size:12px;padding-right:30px;" align="center"><p>Sidoarjo, <?php echo $date_now;?><br/>
                    Radiolog, </p>
                    <br/><br/><br/>&nbsp;&nbsp;
                    ( <?php echo $rw['drad'];?> )</td>
            </tr>
        </table>
	</td>
  </tr-->
<?php 
if($cmbTipeHasilRad=="0"){
?>
  <tr id="trTombol">
    <td class="noline" align="center"><input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
        <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>    </td>
  </tr>
<?php 
}
?>
</table>
<?php 
if($cmbTipeHasilRad=="0"){
?>
<script type="text/JavaScript">
	function cetak(tombol){
		tombol.style.visibility='collapse';
		if(tombol.style.visibility=='collapse'){
			if(confirm('Anda Yakin Mau Mencetak Hasil Radiologi ?')){
				setTimeout('window.print()','1000');
				setTimeout('window.close()','2000');
			}
			else{
				tombol.style.visibility='visible';
			}

		}
	}
</script>
<?php 
}elseif($cmbTipeHasilRad=="1"){
	$content = ob_get_clean();
	require_once(dirname(__FILE__).'/../../include/html2pdf/html2pdf.class.php');
	try
	{
		$width_in_mm = 8.5 * 25.4;
		$height_in_mm = 14 * 25.4;
		//$html2pdf = new HTML2PDF('P', array($width_in_mm, $height_in_mm), 'en', true, 'UTF-8', array(1, 1, 1, 1));
		$html2pdf = new HTML2PDF('P', 'A4', 'en');
		$html2pdf->setDefaultFont("arial");
		//$html2pdf->addFont('calibri', '', 'calibri');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output('HasilRadiologi_'.$rw['no_rm'].'.pdf','D');
	}
	catch(HTML2PDF_exception $e) {
		echo $e;
		exit;
	}
}
?>