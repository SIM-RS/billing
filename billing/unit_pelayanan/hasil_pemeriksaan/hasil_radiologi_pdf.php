<?php
ob_start();
session_start();
include '../../koneksi/konek.php';
$idPel=$_REQUEST['idPel'];
$idKunj=$_REQUEST['idKunj'];
$id_rad=$_REQUEST['id'];

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
      ON mt.id = mtk.ms_tindakan_id WHERE a.id = ".$id_rad."
";
//echo $sqlPas."<br>";
$rs1 = mysql_query($sqlPas);
//echo mysql_error();
$rw = mysql_fetch_array($rs1);
//$drPeng = str_replace('Dr','dr',$rw['dpeng']); 
//$drRad = str_replace('Dr','dr',$rw['drad']); 

?>
 <table align="center" width="900" border="0" cellspacing="0" cellpadding="0" style="font-weight:bold;margin-top:200px;">
  <tr>
  	<td align="center" style="font-size:14px;">HASIL PEMERIKSAAN RADIOLOGI</td>
  </tr>
  <!--tr>
  	<td align="center" style="font-size:14px;">No. Photo : <?php echo $rw["no_lab"]; ?></td>
  </tr-->
  <tr>
  	<td align="center">
        <table style="font-size:11px;text-align:left;" cellpadding="0" cellspacing="0" align="center">
          <tr>
            <td style="font-size:18px">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td style="font-size:18px">&nbsp;</td>
            <td  style="font-size:18px">&nbsp;</td>
            <td>&nbsp;</td>
            <td style="font-size:18px">&nbsp;</td>
          </tr>
          <tr>
            <td width="110">&nbsp;&nbsp;Tgl. Kunjungan </td>
            <td width="10" align="center">:</td>
            <td width="300">&nbsp;<?php echo $rw['tgl_kunjungan'];?></td>
            <td width="110">Rujukan Dari</td>
            <td width="10">:</td>
            <td width="240">&nbsp;<?php echo $rw['nama'];?></td>
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
            <td>Tgl. Pemeriksaan</td>
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
            <td>&nbsp;&nbsp;Status Pasien</td>
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
          <tr>
            <td>&nbsp;&nbsp;</td>
            <td align="center"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
      </table>
    </td>
  </tr>
  <tr>
  	<td style="font-size:11px; padding-left:18px; max-width:900px; word-wrap:break-word"><?php echo stripslashes($rw['hasil']);?></td>
  </tr>
</table>
<?php
$content = ob_get_clean();
require_once(dirname(__FILE__).'/../../include/html2pdf/html2pdf.class.php');
try
{
	$width_in_mm = 8.5 * 25.4;
	$height_in_mm = 14 * 25.4;
	$html2pdf = new HTML2PDF('P', array($width_in_mm, $height_in_mm), 'en', true, 'UTF-8', array(4, 4, 4, 4));
	$html2pdf->setDefaultFont("arial");
	//$html2pdf->addFont('calibri', '', 'calibri');
	$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
	$html2pdf->Output('HasilRadiologi_'.$rw['no_rm'].'.pdf','D');
}
catch(HTML2PDF_exception $e) {
	echo $e;
	exit;
}
?>