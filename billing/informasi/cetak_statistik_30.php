<?php
session_start();
if(!isset($_SESSION['userId']))
{
	header('Location: ../index.php');
}else{
error_reporting(E_ALL^(E_NOTICE | E_WARNING));	
include("../koneksi/konek.php"); 

$jenis = $_REQUEST['jns'];
$unit = $_REQUEST['tmp'];
$tgl1 = $_REQUEST['tgl1'];
$tgl2 = $_REQUEST['tgl2'];
$t1 = tglSQL($tgl1);
$t2 = tglSQL($tgl2);


if($unit == 0){
	$fUnit = "";
}else{
	$fUnit = "AND p.unit_id = ".$unit;
}
		  
$A = "SELECT
IFNULL(SUM(x),0) AS A 
FROM
(SELECT
*, 
(DATEDIFF(x2,x1)+1) AS x
FROM
(SELECT 
	t1.pelayanan_id, 
	DATE(t1.tgl_in) tgl_in,
	DATE(t1.tgl_out) tgl_out,
	IF(DATE(t1.tgl_in)<'".$t1."','".$t1."',DATE(t1.tgl_in)) AS x1,
	IF(DATE(IFNULL(t1.tgl_out,t1.tgl_pulang))>'".$t2."' OR IFNULL(t1.tgl_out,t1.tgl_pulang) IS NULL,'".$t2."',DATE(t1.tgl_out)) AS x2
  FROM
	(SELECT 
		tk.*,
		k.tgl_pulang 
	  FROM
		b_tindakan_kamar tk 
		INNER JOIN b_pelayanan p ON tk.pelayanan_id = p.id
		INNER JOIN b_kunjungan k ON p.kunjungan_id = k.id
	  WHERE tk.aktif = 1 
		$fUnit 
		AND ((DATE(tk.tgl_in) BETWEEN '".$t1."' AND '".$t2."') OR (DATE(IFNULL(tk.tgl_out,k.tgl_pulang)) BETWEEN '".$t1."' AND '".$t2."') OR IFNULL(tk.tgl_out,k.tgl_pulang) IS NULL)
	) AS t1 
) AS t2
) AS t3";
//echo $A."<br>";
$qA = mysql_query($A);
$nA = mysql_fetch_array($qA);

$B = "SELECT 
IFNULL(SUM(hr),0) AS B
FROM
(SELECT
IF(DATEDIFF(tgl_out,tgl_in)=0,1,DATEDIFF(tgl_out,tgl_in)) AS hr
FROM
(SELECT 
	t1.pelayanan_id, 
	DATE(t1.tgl_in) tgl_in,
	DATE(IFNULL(t1.tgl_out,t1.tgl_pulang)) tgl_out
FROM
	(SELECT 
		tk.*,
		k.tgl_pulang 
	  FROM
		b_tindakan_kamar tk 
		INNER JOIN b_pelayanan p ON tk.pelayanan_id = p.id
		INNER JOIN b_kunjungan k ON p.kunjungan_id = k.id
	  WHERE tk.aktif = 1 
		$fUnit 
		AND (DATE(IFNULL(tk.tgl_out,k.tgl_pulang)) BETWEEN '".$t1."' AND '".$t2."')
	) AS t1 
) AS t2
) AS t3";
//echo $B."<br>";
$qB = mysql_query($B);
$nB = mysql_fetch_array($qB);

$C = "SELECT 
COUNT(tk.id) AS C
FROM 
b_tindakan_kamar tk
INNER JOIN b_pelayanan p ON tk.pelayanan_id = p.id
INNER JOIN b_kunjungan k ON p.kunjungan_id = k.id
WHERE tk.aktif=1 
$fUnit 
AND (DATE(IFNULL(tk.tgl_out,k.tgl_pulang)) BETWEEN '".$t1."' AND '".$t2."')";
//echo $C."<br>";
$qC = mysql_query($C);
$nC = mysql_fetch_array($qC);

$E = "SELECT DATEDIFF('".$t2."','".$t1."')+1 AS E";
//echo $E."<br>";
$qE = mysql_query($E);
$nE = mysql_fetch_array($qE);
// ==================================================================================

$nilaiA = $nA['A'];
$nilaiB = $nB['B'];
$nilaiC = $nC['C'];
$nilaiD = $_REQUEST['jmlB'];
$nilaiE = $nE['E'];

$bor = ($nilaiA / ($nilaiD * $nilaiE)) * 100;
$alos = $nilaiB / $nilaiC;
$bto = $nilaiC / $nilaiD;
$toi = (($nilaiD * $nilaiE) - $nilaiA) / $nilaiC;

require_once("../tools/phpChart/conf.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="style_statistik.css">
<title>Laporan Statistik BOR, ALOS, BTO dan TOI</title>
</head>

<body>
	<div align="center" style="background-color:#FFFFFF; width:1023px">
		<table width="970" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td class="textJdl1">Laporan Statistik BOR, ALOS, BTO dan TOI</td>
			</tr>
		</table>
		<?php
			if($unit == 0){
				$unitNm = "";
			}else{
				$unitNm = "where id = ".$unit;
			}
			$j="select nama from b_ms_unit where id='$jenis'";
			$jj=mysql_query($j);
			$jn=mysql_fetch_array($jj);
			$u="select nama from b_ms_unit ".$unitNm;
			$uu=mysql_query($u);
			$un=mysql_fetch_array($uu);
		?>
		
		<p>&nbsp;</p>

		<table width="800" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td width="130" align="left">Jenis Layanan</td>
				<td>: <? echo $jn['nama'] ?></td>
			</tr>
			<tr>
				<td align="left">Tempat Layanan</td>
				<td>: <? if($unit == 0) echo "SEMUA"; else echo $un['nama'] ?></td>
			</tr>
			<tr>
				<td align="left">Periode</td>
				<td>: <? echo $tgl1." s/d ".$tgl2 ?></td>
			</tr>
		</table>
		
		<table align="center" cellpadding="0" cellspacing="0" width="800">
			<tr>
				<td class="jdlkiri" width="50" align="center">No</td>
				<td class="jdl" width="450" align="center">Laporan</td>
				<td class="jdl" width="200" align="center">Nilai</td>
			</tr>
			<tr>

				<td class="isikiri" align="center">1</td>
				<td class="isi">&nbsp;BOR (Bed Occupancy Rate)</td>
				<td class="isi" align="right"><?php echo round($bor,2)." %" ?>&nbsp;&nbsp;</td>
			</tr>
			<tr>

				<td class="isikiri" align="center">2</td>
				<td class="isi">&nbsp;ALOS (Average Length of Stay)</td>
				<td class="isi" align="right"><?php echo number_format($alos,2,",",".") ?>&nbsp;&nbsp;</td>
			</tr>
            <tr>

				<td class="isikiri" align="center">3</td>
				<td class="isi">&nbsp;BTO (Bed Turn Over)</td>
				<td class="isi" align="right"><?php echo number_format($bto,2,",",".") ?>&nbsp;&nbsp;</td>
			</tr>
			<tr>

				<td class="isikiri" align="center">4</td>
				<td class="isi">&nbsp;TOI (Turn Over Interval)</td>
				<td class="isi" align="right"><?php echo number_format($toi,2,",",".") ?>&nbsp;&nbsp;</td>
			</tr>
            <tr>
            	<td colspan="3">&nbsp;</td>
            </tr>
            <tr>
            	<td colspan="3" align="center">
					<div id="chartBJ" style="margin:20px auto;">
						<?php
							
							/* 
								Batasan nilai efisien
									BOR – 75%-85%
									TOI – 1-3 hari
									AvLOS – 3-12 hari
									BTO >30
								
								BOR 75, 85, 90
							*/
						  
							// Garis Bor
							$l1 = array(array(0,0,null),array(50,50,'50%'));
							$l2 = array(array(0,0,null),array(40,60,'60%'));
							$l3 = array(array(0,0,null),array(30,70,'70%'));
							$l4 = array(array(0,0,null),array(20,80,'80%'));
							$l5 = array(array(0,0,null),array(10,90,'90%'));
							
							/* $l1 = array(array(0,0,null),array(11,7));
							$l2 = array(array(0,0,null),array(11,12));
							$l3 = array(array(0,0,null),array(11,20));
							$l4 = array(array(0,0,null),array(9,31));
							$l5 = array(array(0,0,null),array(5,31)); */
							
							// Garis Efisiensi
							$e1 = array(array(1,3,null),array(1,32,null),array(3,32,null),array(3,9,null));
							$e2 = array(array(3,9,null),array(1,3,null));
							/* $e2 = array(array(1,3,null),array(1,12,null));
							$e3 = array(array(3,9,null),array(3,12,null)); */
							
							$namaLay = ($unit == 0)?"SEMUA" : $un['nama'];
							$label = number_format($toi,2,".","").", ".number_format($alos,2,".","");
							
							// Hasil array(toi,los)
							$b1 = array(array($toi,$alos,$label));
							$nox = $noy = array();
							for($x=0;$x<=11;$x++){
								$nox[] = array($x,$x);
							}
							
							for($y=0;$y<=31;$y++){
								$noy[] = array($y,$y);
							}
							
							$pc = new C_PhpChartX(array($l1,$l2,$l3,$l4,$l5,$e1,$e2,$b1),'chart1');
							$pc->set_title(array('text'=>'Grafik Barber Johnson'));
							$pc->add_plugins(array('cursor','pointLabels','barRenderer','categoryAxisRenderer','canvasTextRenderer'),true);
							$pc->set_animate(true);
							$pc->set_axes(array(
												'yaxis'=>array(
																'autoscale'=>true,
																'padMin'=>1.0,
																'ticks'=>$noy,
																'max'=>31,
																'min'=>0,
																'label'=>'LOS'
																),
												/* 'xaxis'=>array(
																'autoscale'=>true,
																'padMin'=>0,
																'label'=>'TOI'
																) */
												'xaxis'=>array(
																'padMin'=>1.0, 
																'ticks'=>$nox,
																'max'=>11,
																'min'=>0,
																'autoscale'=>false,
																'label'=>'TOI'
																)
												)
										 );
							$pc->set_legend(array('show'=>true));
							$pc->set_series_default(array('showMarker'=>false, 'shadow'=>false));
							$pc->add_series(array('label'=>'BOR 50%'));
							$pc->add_series(array('label'=>'BOR 60%'));
							$pc->add_series(array('label'=>'BOR 70%'));
							$pc->add_series(array('label'=>'BOR 80%'));
							$pc->add_series(array('label'=>'BOR 90%'));
							$pc->add_series(array('label'=>'Efisiensi','color'=>'red'));
							$pc->add_series(array('showLabel'=>false,'label'=>'','color'=>'red'));
							$pc->add_series(array('showMarker'=>true,'label'=>$namaLay));
							
							/* $pc->set_cursor(array(
								'show'=>true,
								'zoom'=>true,
								'looseZoom'=>true)); */
							$pc->draw(600,600);   
									
						?>
					</div>
				</td>
            </tr>
            <tr>
            	<td colspan="3">
                <table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                    	<td colspan="3" style="font-weight:bold">Keterangan :</td>
                        <td width="2%">&nbsp;</td>
                        <td width="4%">&nbsp;</td>
                        <td width="60%">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td colspan="3">Jumlah hari perawatan rumah sakit</td>
                        <td width="2%">=</td>
                        <td width="4%" align="right"><?php echo $nilaiA; ?></td>
                        <td width="60%">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td colspan="3">Jumlah lama dirawat</td>
                        <td width="2%">=</td>
                        <td width="4%" align="right"><?php echo $nilaiB; ?></td>
                        <td width="60%">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td colspan="3">Jumlah pasien keluar (Hidup + Mati)</td>
                        <td width="2%">=</td>
                        <td width="4%" align="right"><?php echo $nilaiC; ?></td>
                        <td width="60%">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td colspan="3">Jumlah tempat tidur</td>
                        <td width="2%">=</td>
                        <td width="4%" align="right"><?php echo $nilaiD; ?></td>
                        <td width="60%">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td colspan="3">Jumlah hari dalam satu periode</td>
                        <td width="2%">=</td>
                        <td width="4%" align="right"><?php echo $nilaiE; ?></td>
                        <td width="60%">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td width="7%">&nbsp;</td>
                        <td width="2%">&nbsp;</td>
                        <td width="25%">&nbsp;</td>
                        <td width="2%">&nbsp;</td>
                        <td width="4%">&nbsp;</td>
                        <td width="60%">&nbsp;</td>
                    </tr>
                    <tr>
                    	<td width="7%" valign="top">BOR</td>
                        <td width="2%" valign="top">=</td>
                        <td colspan="4">Jumlah hari perawatan rumah sakit / Jumlah tempat tidur x Jumlah hari dalam satu periode x 100 %</td>
                    </tr>
                    <tr>
                    	<td width="7%" valign="top">ALOS</td>
                        <td width="2%" valign="top">=</td>
                        <td colspan="4">Jumlah Lama Dirawat / Jumlah Pasien Keluar (hidup + mati)</td>
                    </tr>
                    <tr>
                    	<td width="7%" valign="top">BTO</td>
                        <td width="2%" valign="top">=</td>
                        <td colspan="4">Jumlah pasien keluar (hidup + mati) / Jumlah tempat tidur</td>
                    </tr>
                    <tr>
                    	<td width="7%" valign="top">TOI</td>
                        <td width="2%" valign="top">=</td>
                        <td colspan="4">(Jumlah tempat tidur x Jumlah hari dalam satu periode) - Jumlah hari perawatan rumah sakit / Jumlah pasien keluar (hidup + mati)</td>
                    </tr>
                    <tr>
                    	<td>&nbsp;</td>
                    </tr>
                </table>
                </td>
            </tr>
            <tr id="trTombol">
            	<td colspan="3">
                <div align="center">
				<button type="button" id="ctk" name="ctk" onclick="cetak(document.getElementById('trTombol'));" style="cursor:pointer">
				<img src="../icon/printer.png" width="16" align="absmiddle" />&nbsp;Cetak
				</button>&nbsp;&nbsp;
				<button type="button" id="close" name="close" style="cursor:pointer" onclick="window.close()">
				<img src="../icon/del.gif" width="16" align="absmiddle" />&nbsp;Close
				</button>
				</div>
                </td>
            </tr>
		</table>
	</div>
</body>
</html>
<script type="text/JavaScript">
function cetak(tombol){
    tombol.style.visibility='collapse';
    if(tombol.style.visibility=='collapse'){
        if(confirm('Anda Yakin Mau Mencetak Halaman Ini ?')){
            setTimeout('window.print()','1000');
            setTimeout('window.close()','2000');
        }
        else{
            tombol.style.visibility='visible';
        }
    }
}
</script>
<? } ?>