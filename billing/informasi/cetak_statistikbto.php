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

$tahun=$_REQUEST['tahun'];

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



//$sqlBed = "SELECT SUM(kmr.jumlah_tt) tt FROM b_ms_kamar kmr WHERE 1=1 AND unit_id<>72 $fKmr ";
$sqlBed = "SELECT SUM(kmr.jumlah_tt) tt FROM b_ms_kamar kmr WHERE 1=1 AND unit_id<>72";
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
<title>Laporan Statistik BTO</title>
</head>

<body>
	<div align="center" style="background-color:#FFFFFF; width:1023px">
		<table width="970" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td class="textJdl1">BTO TAHUN <?= $tahun ?> RS PHCM</td>
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
		<? } ?>
			
		</table>
		<?php //strtotime('2016-10'); ?>
		<table align="center" cellpadding="10" cellspacing="0" width="800">
			<tr>
				<td class="jdlkiri" width="50" align="center">No</td>
				<td class="jdl" width="100" align="center">Bulan</td>
				<td class="jdl" width="450" align="center">BOR = Jumlah Hari Rawat / Jumlah TT x Jumlah Hari dalam 1 Periode</td>
				<td class="jdl" align="center">Nilai</td>
			</tr>
			<?php
			$bln=date('m');
			
			function bulan($b){
				switch ($b){
					case 1:
						$bulan = "Januari";
						break;
					case 2:
						$bulan = "Februari";
						break;
					case 3:
						$bulan = "Maret";
						break;
					case 4:
						$bulan = "April";
						break;
					case 5:
						$bulan = "Mei";
						break;
					case 6:
						$bulan = "Juni";
						break;
					case 7:
						$bulan = "Juli";
						break;
					case 8:
						$bulan = "Agustus";
						break;
					case 9:
						$bulan = "September";
						break;
					case 10:
						$bulan = "Oktober";
						break;
					case 11:
						$bulan = "November";
						break;
					case 12:
						$bulan = "Desember";
						break;
				}
				return $bulan;
			}
			$i=1;
			
			while($i<=12){
				if($i<=$bln or $tahun!==date('Y')){
					$number = cal_days_in_month(CAL_GREGORIAN, $i, $tahun);
					$j=1;
					
                    $jlh=0;
                    $jpasien=0;
					if(strlen($i)==1){
						$in='0'.$i;
					}else{
						$in=$i;
					}
					while($j<=$number){
						if(strlen($j)==1){
							$jn='0'.$j;
						}else{
							$jn=$j;
						}
						$d = $tahun."-".$in."-".$jn;
						//and (date(b.tgl_out)>='$d' or k.tgl_pulang IS NULL or date(k.tgl_pulang)>='$d') and year(b.tgl_in)";
						$jumlah = "select count(*) as count 
							from b_pelayanan a left join b_tindakan_kamar b on a.id=b.pelayanan_id 
							LEFT JOIN b_kunjungan k ON a.kunjungan_id = k.id
								where date(b.tgl_in)<='$d'
								and (DATE(IFNULL(b.tgl_out,k.tgl_pulang))>='$d' or k.tgl_pulang IS NULL 
                                or date(k.tgl_pulang)>='$d')";
                        
						$queryjumlah=mysql_query($jumlah);
						$rowjumlah=mysql_fetch_assoc($queryjumlah);
						
                        $jlh=$jlh+$rowjumlah['count'];
                        
                        $jlhpasien = "select count(*) as count 
                                from b_pelayanan a left join b_tindakan_kamar b on a.id=b.pelayanan_id 
                                LEFT JOIN b_kunjungan k ON a.kunjungan_id = k.id
                                    where (DATE(IFNULL(b.tgl_out,k.tgl_pulang)) ='$d' 
                                    or date(k.tgl_pulang)='$d')";
                                    
                        $queryjlhpasien=mysql_query($jlhpasien);
                        $rowjlhpasien=mysql_fetch_assoc($queryjlhpasien);
                        $jpasien=$jpasien+$rowjlhpasien['count'];
						$j=$j+1;
					}
					//$jumlahttperiode = $nilaiD * $number;
                    //$nilai = $jumlahttperiode-$jlh/$jlhpasien;
                    $nilai=($jlhpasien/$nilaiD)*(365/$j);
			?>
			<tr>
				<td class="isikiri"><?= $i ?></td>
				<td class="isi"><?= bulan($i) ?></td>
				<td class="isi"><?= $jpasien." / ".$nilaiD." x 365 / ".$j; ?></td>
				<td class="isi"><?= number_format($nilai,2)." %" ?></td>
			</tr>
				<?php
				}
					$i=$i+1;
				}
				?>
			<tr>
				<td colspan="3" align="right">
				<div style="center">Medan,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= bulan(date('m')); ?> <?= date('Y'); ?><br>
				PT. PRIMA HUSADA CIPTA MEDAN<br>
				DIREKTUR<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				Dr.YUSMARDIANNIE, M.Kes
				</div>
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