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

if($jenis==''){

	$fUnit="";
	$fKmr = "";

}else{

	if($unit == 0){
		$fUnit = "";
	}else{
		if($jenis!=0){
			$fUnit = "AND p.unit_id = ".$unit;
			$fKmr = " AND kmr.unit_id = ".$unit;
		}else{
			$fUnit = "AND mk.`id_group_kamar` = ".$unit;
			$fKmr = " AND kmr.id_group_kamar = ".$unit;
		}
	}

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
		INNER JOIN `b_ms_kamar` mk ON tk.`kamar_id` = mk.`id`
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
		INNER JOIN `b_ms_kamar` mk ON tk.`kamar_id` = mk.`id`
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
INNER JOIN `b_ms_kamar` mk ON tk.`kamar_id` = mk.`id`
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



$sqlBed = "SELECT SUM(kmr.jumlah_tt) tt FROM b_ms_kamar kmr WHERE 1=1 AND unit_id<>72 $fKmr ";
//echo $sqlBed;
$qBed = mysql_query($sqlBed);
$nBed = mysql_fetch_array($qBed);





$nilaiA = $nA['A'];
$nilaiB = $nB['B'];
$nilaiC = $nC['C'];
//$nilaiD = $_REQUEST['jmlB'];
$nilaiD = $nBed['tt'];
$nilaiE = $nE['E'];

$bor = ($nilaiA / ($nilaiD * $nilaiE)) * 100;
$alos = $nilaiB / $nilaiC;
$bto = $nilaiC / $nilaiD;
$toi = (($nilaiD * $nilaiE) - $nilaiA) / $nilaiC;
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

		<p>&nbsp;</p>

		<table width="800" align="center" cellpadding="0" cellspacing="0">
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
			//echo $u;
			$uu=mysql_query($u);
			$un=mysql_fetch_array($uu);
			$g="select nama from b_ms_group_kamar where id='$unit'";
			$gg=mysql_query($g);
			$gn=mysql_fetch_array($gg);
			
			
		?>
		<?php if($jenis!=''){ ?>
			<tr id="tr">
				<td width="130" align="left">Jenis Layanan</td>
				<td>: <? if($jenis == 0) echo "RAWAT INAP"; else echo $jn['nama'] ?></td>
			</tr>
			<tr id="tr">
				<td align="left">Tempat Layanan</td>
				<td>: <? if($jenis == 0) echo $gn['nama']; else echo $un['nama'] ?></td>
			</tr>
		<? } ?>
			<tr>
				<td align="left" width="130">Periode</td>
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