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

$date_now=gmdate('d-m-Y',mktime(date('H')+7));

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
$txtHasilAsli=stripslashes($rw['hasil']);
$txtHasil=$txtHasilAsli;
$ArrtxtHasil=explode("\n",$txtHasil);
$txtHasilHeight=((count($ArrtxtHasil)+1)*20);
if ($cmbTipeHasilRad=="1"){
	$txtHasil=str_replace(chr(10),"<br>",$txtHasil);
	$txtHasil=str_replace(" ","<span style='color:#FFFFFF'>_</span>",$txtHasil);
}
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
<script type="text/JavaScript">
var applet = null;

function jzebraReady() {}

function jzebraDoneFinding() {}

function jzebraDonePrinting() {
   if (applet.getException() != null) {
	  return alert('Error:' + applet.getExceptionMessage());
   }
   window.close();
}

function deteksiPrinter() {	    
	 applet = document.jzebra;
	 if (applet != null) {           
		applet.findPrinter();
		applet.getPrinter();
		applet.setEncoding("UTF-8");
	 }
}
	 
function printjZebra(){
	//var applet = document.jzebra;
	if (applet != null) {
	<?php 
		echo "applet.append(\"\\x1B\\x40\")"; echo chr(59);echo "\n\t\t\t";//ESC @ Initial Printer
		echo "applet.append(\"\\x1B\\x32\")"; echo chr(59);echo "\n\t\t\t";//ESC 2
		echo "applet.append(\"\\x1B\\x67\")"; echo chr(59);echo "\n\t\t\t";//ESC g -> Select 15cpi
		echo "applet.append(\"\\x1B\\x6C\\x05\")"; echo chr(59);echo "\n\t\t\t";//ESC l -> Set Left margin
		echo "applet.append(\"\\x1B\\x51\\x05\")"; echo chr(59);echo "\n\t\t\t";//ESC Q -> Set Right margin
		//echo "applet.append(\"\\x1B\\x43\\x2C\")"; echo chr(59);echo "\n\t\t\t";//ESC C -> Set Page Length In Lines
		echo "applet.append(\"\\x1B\\x43\\x42\")"; echo chr(59);echo "\n\t\t\t";//ESC C -> Set Page Length In Lines
		echo "applet.append(\"\\x1B\\x78\\x30\")"; echo chr(59);echo "\n\t\t\t";//ESC x -> Select LQ or Draft
		for ($i=0;$i<6;$i++){
			echo "applet.append(\"\\n\")"; echo chr(59);echo "\n\t\t\t";
		}
		echo "applet.append(\"                                             HASIL PEMERIKSAAN RADIOLOGI\\n\")"; echo chr(59);echo "\n\t\t\t";
		echo "applet.append(\"\\n\")"; echo chr(59);echo "\n\t\t\t";
		echo "applet.append(\"".StrAddSpace("Tgl. Kunjung",16).": ".StrAddSpace($rw['tgl_kunjungan'],47).StrAddSpace("Rujukan Dari",16).": ".StrAddSpace($rw['nama'],27)."\\n\")"; echo chr(59);echo "\n\t\t\t";
		echo "applet.append(\"".StrAddSpace("No. RM",16).": ".StrAddSpace($rw['no_rm'],47).StrAddSpace("Dokter Pengirim",16).": ".StrAddSpace($rw['dpeng'],27)."\\n\")"; echo chr(59);echo "\n\t\t\t";
		echo "applet.append(\"".StrAddSpace("Nama Pasien",16).": ".StrAddSpace($rw['pasien'],47).StrAddSpace("Tgl. Periksa",16).": ".StrAddSpace($rw['tgl'],27)."\\n\")"; echo chr(59);echo "\n\t\t\t";
		echo "applet.append(\"".StrAddSpace("Tgl. Lahir",16).": ".StrAddSpace($rw['tgl_lahir'],47).StrAddSpace("Tgl. Hasil",16).": ".StrAddSpace($rw['tgl_act'],27)."\\n\")"; echo chr(59);echo "\n\t\t\t";
		echo "applet.append(\"".StrAddSpace("Status Px",16).": ".StrAddSpace($rw['status'],47).StrAddSpace("Hak Kelas",16).": ".StrAddSpace($rw['hakkelas'],27)."\\n\")"; echo chr(59);echo "\n\t\t\t";
		//echo "applet.append(\"".StrAddSpace("Hak Kelas",16).": ".StrAddSpace($rw['hakkelas'],47)."\\n\")"; echo chr(59);echo "\n\t\t\t";
		echo "applet.append(\"\\n\")"; echo chr(59);echo "\n\t\t\t";
		$strGaris="";
		for ($i=0;$i<56;$i++){
			$strGaris .="- ";
		}
		echo "applet.append(\"".$strGaris."\\n\")"; echo chr(59);echo "\n\t\t\t";
		echo "applet.append(\"Uraian Hasil Pemeriksaan\\n\")"; echo chr(59);echo "\n\t\t\t";
		echo "applet.append(\"".$strGaris."\\n\")"; echo chr(59);echo "\n\t\t\t";
		for ($i=0;$i<count($ArrtxtHasil);$i++){
			echo "applet.append(\"".$ArrtxtHasil[$i]."\\n\")"; echo chr(59);echo "\n\t\t\t";
		}
		for ($i=0;$i<(37-count($ArrtxtHasil));$i++){
			echo "applet.append(\"\\n\")"; echo chr(59);echo "\n\t\t\t";
		}
		echo "applet.append(\"".$strGaris."\\n\")"; echo chr(59);echo "\n\t\t\t";
		echo "applet.append(\"\\n\")"; echo chr(59);echo "\n\t\t\t";
		$pjgTtd=97;
		echo "applet.append(\"".StrAddSpaceBefore("Sidoarjo, $date_now",$pjgTtd)."\\n\")"; echo chr(59);echo "\n\t\t\t";
		for ($i=0;$i<4;$i++){
			echo "applet.append(\"\\n\")"; echo chr(59);echo "\n\t\t\t";
		}
		$pjgDok=strlen($rw['drad']);
		if ($pjgDok>20){
			$pjgDok=$pjgTtd+floor(($pjgDok-20)/2)+1;
		}else{
			$pjgDok=$pjgTtd-floor((20-$pjgDok)/2);
		}
		echo "applet.append(\"".StrAddSpaceBefore("( ".$rw['drad']." )",$pjgDok)."\\n\")"; echo chr(59);echo "\n\t\t\t";
		echo "applet.append(\"\\x0C\")"; echo chr(59); echo "\n\t\t\t";
		echo "applet.append(\"\\x1B\\x40\")"; echo chr(59); echo "\n\t\t\t";
		
		echo "applet.print()"; echo chr(59);
		
		function StrAddSpace($str,$strlength){
			$spaceCount=$strlength - strlen($str);
			for ($i=0;$i<$spaceCount;$i++){
				$str .=" ";
			}
			return $str;
		}
		
		function StrAddSpaceBefore($str,$strlength){
			$spaceCount=$strlength - strlen($str);
			for ($i=0;$i<$spaceCount;$i++){
				$str=" ".$str;
			}
			return $str;
		}
	?>
	}
}
</script>
<body onLoad="deteksiPrinter()">
<applet name="jzebra" code="jzebra.PrintApplet.class" archive="./jzebra.jar" width="0px" height="0px"></applet>
 <table align="center" width="<?php echo $Pwidth; ?>" border="0" cellspacing="0" cellpadding="0" style="font-weight:bold;margin-top:200px;">
  <tr>
  	<td align="center" style="font-size:16px;">HASIL PEMERIKSAAN RADIOLOGI</td>
  </tr>
  <!--tr>
  	<td align="center" style="font-size:14px;">No. Photo : <?php echo $rw["no_lab"]; ?></td>
  </tr-->
  <tr>
  	<td align="center">
        <table style="font-size:14px;text-align:left;" cellpadding="0" cellspacing="0" align="center">
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
            <td>Hak Kelas</td>
            <td>:&nbsp;</td>
            <td>&nbsp;<?php echo $rw['hakkelas'];?></td>
          </tr>
          <!--tr>
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
  	<td>&nbsp;</td>
  </tr>
  <tr>
  	<!--td style="font-size:14px; padding-left:16px; max-width:900px; word-wrap:break-word"><?php echo $txtHasil;?></td-->
    <td style="font-size:14px; padding-left:16px; max-width:900px; word-wrap:break-word">
    <?php 
	if ($cmbTipeHasilRad=="1" || $cmbTipeHasilRad=="2"){
		echo $txtHasil;
	}else{
	?>
    <textarea readonly="readonly" style="width:800px;height:<?php echo $txtHasilHeight; ?>px;border:hidden;font-size:16px;"><?php echo $txtHasil;?></textarea>
    <?php 
	}
	?>
    </td>
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
    <td class="noline" align="center">
        <select id="cmbPrinter">
        	<option value="0">Printer Dot Matrix</option>
            <option value="1">Printer Deskjet</option>
        </select>
        <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak();"/>
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
	function cetak(){
		var tombol = document.getElementById('trTombol');
		tombol.style.visibility='collapse';
		if(tombol.style.visibility=='collapse'){
			if(confirm('Anda Yakin Mau Mencetak Hasil Radiologi ?')){
				if (document.getElementById('cmbPrinter').value=="1"){
					setTimeout('window.print()','1000');
					setTimeout('window.close()','2000');
				}else{
					printjZebra();
					//setTimeout('window.close()','2000');
				}
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
</body>