<?php 
if($_POST['excel']=='excel'){
header("Content-type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="penerimaan_pasien.xls"');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/JavaScript" language="JavaScript" src="../../theme/js/formatPrint.js"></script>
<title>.: Laporan Tindakan Setelah KRS :.</title>
</head>

<body>
<?php
	//session_start();
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$txtJam1=$_REQUEST['txtJam1'];
	$txtJam2=$_REQUEST['txtJam2'];
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	
	$sqlUnit1 = "SELECT nama,inap FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	$inap = $rwUnit1['inap'];
	
if($_REQUEST['TmpLayanan']!=0){
	$sqlUnit2 = "SELECT nama,inap FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	$fTmpLay = " AND p.unit_id=".$_REQUEST['TmpLayanan'];
	$inap = $rwUnit2['inap'];
}else
	$fTmpLay = " AND p.jenis_layanan=".$_REQUEST['JnsLayanan'];

	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);

if($_REQUEST['cmbKsr']!=0){
	
	$fKsr = " AND b.user_act=".$_REQUEST['cmbKsr'];
}

if($_REQUEST['StatusPas']!=0){
	$sqlKso = "SELECT id,nama from b_ms_kso where id = ".$_REQUEST['StatusPas'];
	$rsKso = mysql_query($sqlKso);
	$rwKso = mysql_fetch_array($rsKso);
	$fKso = " AND k.kso_id = ".$_REQUEST['StatusPas'];
}
$kasir = $_REQUEST['cmbKasir2'];
$nmKasir = $_REQUEST['cmbKsrAll'];

$qKsr = "SELECT id, nama FROM b_ms_unit WHERE id = '".$kasir."'";
$rsKsr = mysql_query($qKsr);
$rwKsr = mysql_fetch_array($rsKsr);

$sqlKasir = "SELECT id, nama FROM b_ms_pegawai WHERE id = '".$nmKasir."'";
$rsKasir = mysql_query($sqlKasir);
$rwKasir = mysql_fetch_array($rsKasir);
?>
<table id="tblPrint" width="1000" border="0" cellspacing="0" cellpadding="0" align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td colspan="2"><b>Rumah Sakit Umum Daerah Kabupaten Sidoarjo<br />Jl. Mojopahit 667 Sidoarjo<br />Telepon (031) 8961649<br />Sidoarjo</b></td>
  </tr>
  <tr>
    <td colspan="2" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase;"><b>Laporan Tindakan Yang Dientri Setelah KRS<br />Periode <?php echo $tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2]?></b></td>
  </tr>
  <tr>
    <td width="50%">&nbsp;</td>
	<td align="right">Yang Mencetak&nbsp;:&nbsp;<b><?php echo $rwPeg['nama'];?></b></td>
  </tr>
  <tr>
    <td width="50%">&nbsp;</td>
	<td align="right">Tgl Cetak:&nbsp;<?php echo $date_now;?>&nbsp;Jam:&nbsp;<?php echo $jam?></td>
  </tr>
  <tr>
  	<td colspan="2">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
			<tr style="text-align:center; font-weight:bold;">
				<td width="3%" height="30" style="border-top:1px solid; border-bottom:1px solid;">No</td>
				<td width="7%" style="border-top:1px solid; border-bottom:1px solid;">Tgl KRS</td>
                <td width="7%" style="border-top:1px solid; border-bottom:1px solid;">Tgl Kunj</td>
				<td width="13%" style="border-top:1px solid; border-bottom:1px solid;">Tempat Layanan</td>
				<td width="6%" style="border-top:1px solid; border-bottom:1px solid;">No.RM</td>
				<td width="15%" style="border-top:1px solid; border-bottom:1px solid;" align="left">Nama Pasien</td>
				<td width="15%" style="border-top:1px solid; border-bottom:1px solid;" align="left">Status</td>
				<td width="7%" style="border-top:1px solid; border-bottom:1px solid;" align="center">Tgl Entry Pasca KRS</td>
				<td width="15%" style="border-top:1px solid; border-bottom:1px solid;" align="left">Nama Layanan/Tindakan</td>
				<td width="6%" style="border-top:1px solid; border-bottom:1px solid;" align="center">Jumlah</td>
				<td width="11%" style="border-top:1px solid; border-bottom:1px solid;" align="left">User Entry</td>
			</tr>
            <?php
			if($nmKasir==0){
				$fKasir = "";
			}else{
				$fKasir = "AND k.user_act_pulang = '".$nmKasir."'";
			}
			
			$sUnit="SELECT 
				  mu.id,
				  mu.nama,
				  t.id as idtind
				FROM
				  (SELECT * FROM b_tindakan WHERE DATE_FORMAT(tgl_act,'%Y-%m-%d %H:%i') BETWEEN '".$tglAwal2." ".$txtJam1."' AND '".$tglAkhir2." ".$txtJam2."') t
				  INNER JOIN b_pelayanan p 
				    ON p.id = t.pelayanan_id
				  INNER JOIN b_ms_unit mu 
				    ON mu.id = p.unit_id
				  INNER JOIN b_kunjungan k 
				    ON k.id = p.kunjungan_id
				  INNER JOIN b_ms_pasien mp 
				    ON mp.id = p.pasien_id
				  INNER JOIN b_ms_pegawai peg 
				    ON peg.id = t.user_act
				  INNER JOIN b_ms_kso kso 
				    ON kso.id=k.kso_id
				  INNER JOIN b_ms_tindakan_kelas tk 
				    ON tk.id = t.ms_tindakan_kelas_id
				  INNER JOIN b_ms_kelas kel 
				    ON tk.ms_kelas_id=kel.id
				  INNER JOIN b_ms_tindakan tin 
				    ON tin.id = tk.ms_tindakan_id 
				WHERE t._krs = 1 AND p.sudah_krs=1 $fKso
				GROUP BY mu.id 
				ORDER BY mu.nama ";
			//echo $sUnit."<br/>";
			$qUnit=mysql_query($sUnit);
			while($rwUnit=mysql_fetch_array($qUnit)){
			?>
            <tr>
            	<td colspan="11" style="font-weight:bold;"><?php echo $rwUnit['nama']; ?></td>
            </tr>
			<?php
            /* $sKRS="SELECT 
						mu.id,
						mu.nama
					  FROM
						(SELECT 
						  * 
						FROM
						  b_kunjungan 
						WHERE pulang = 1 AND DATE(tgl_pulang) BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."' AND TIME_FORMAT(tgl_pulang,'%H:%i') BETWEEN '$txtJam1' AND '$txtJam2') k 
						INNER JOIN b_ms_pasien ps ON ps.id=k.pasien_id
						INNER JOIN b_ms_kso kso ON kso.id=k.kso_id
						INNER JOIN b_ms_pegawai pg ON pg.id = k.user_act_pulang
						INNER JOIN b_ms_unit mu ON mu.id = k.unit_pulang  
					  WHERE 
						0=0
						$fKso
					GROUP BY mu.id
					ORDER BY mu.nama"; */
			$sKRS="SELECT * 
					FROM(
					SELECT
					p.tgl_krs AS a, t.tgl_act AS b, 
					DATE_FORMAT(p.tgl_krs,'%d-%m-%Y %H:%i') AS tgl_krs,
					/* DATE_FORMAT(p.tgl_krs,'%d-%m-%Y') AS tgl_krs, */
					/* DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl_kunj, */
					DATE_FORMAT(k.tgl_act,'%d-%m-%Y %H:%i') AS tgl_kunj,
					u.nama AS unit, 
					mp.no_rm, 
					mp.nama AS pasien, 
					kso.nama AS kso,
					DATE_FORMAT(t.tgl_act,'%d-%m-%Y %H:%i') AS tgl_entri,
					tin.nama AS tindakan,
					peg.nama AS user_entri,
					t.biaya AS jml 
					FROM (SELECT * FROM b_tindakan WHERE DATE_FORMAT(tgl_act,'%Y-%m-%d %H:%i') BETWEEN '".$tglAwal2." ".$txtJam1."' AND '".$tglAkhir2." ".$txtJam2."') t
					INNER JOIN b_pelayanan p ON p.id = t.pelayanan_id
					INNER JOIN b_ms_unit u ON u.id = p.unit_id
					INNER JOIN b_kunjungan k ON k.id = p.kunjungan_id
					INNER JOIN b_ms_pasien mp ON mp.id = p.pasien_id
					INNER JOIN b_ms_pegawai peg ON peg.id = t.user_act
					INNER JOIN b_ms_kso kso ON kso.id=k.kso_id
					INNER JOIN b_ms_tindakan_kelas tk ON tk.id = t.ms_tindakan_kelas_id
					INNER JOIN b_ms_kelas kel ON tk.ms_kelas_id=kel.id
					INNER JOIN b_ms_tindakan tin ON tin.id = tk.ms_tindakan_id
					WHERE t._krs = 1 AND p.sudah_krs = 1 $fKso AND p.unit_id = '".$rwUnit['id']."'
					) AS tbl
					ORDER BY tbl.a, tbl.b;";
			//echo $sKRS."<br/>";
			$qKRS=mysql_query($sKRS);
			$no=1;
			while($rwKRS=mysql_fetch_array($qKRS)){
			?>
			<tr>
				<td valign="top" style="text-align:center;"><?php echo $no;?></td>
				<td style="text-align:center"><?php echo $rwKRS['tgl_krs'];?></td>
				<td style="text-align:center"><?php echo $rwKRS['tgl_kunj'];?></td>
                <td style="text-align:center"><?php echo $rwKRS['unit'];?></td>
				<td style="text-align:center"><?php echo $rwKRS['no_rm'];?></td>
				<td style="text-transform:uppercase;"><?php echo $rwKRS['pasien'];?></td>
				<td style="text-align:left"><?php echo $rwKRS['kso'];?></td>
				<td style="text-align:center"><?php echo $rwKRS['tgl_entri'];?></td>
				<td style="text-transform:uppercase;"><?php echo $rwKRS['tindakan'];?></td>
				<td style="text-align:right"><?php echo number_format($rwKRS['jml'],0,",",".");?></td>
				<td style="text-align:left">&nbsp;<?php echo $rwKRS['user_entri'];?></td>
			</tr>
            <?php
			$no++;
			}
			
			}
			?>
		</table>
	</td>
  </tr>
  <tr>
  	<td colspan="2" style="border-top:1px solid;">&nbsp;</td>
  </tr>
  <tr style="display:none">
  	<td>&nbsp;</td>
	<td align="right">Tgl Cetak:&nbsp;<?php echo $date_now;?>&nbsp;Jam:&nbsp;<?php echo $jam?></td>
  </tr>
  <tr style="display:none">
  	<td>&nbsp;</td>
	<td align="right">Yang Mencetak</td>
  </tr>
  <tr>
  	<td colspan="2" height="50">&nbsp;</td>
  </tr>
  <tr style="display:none">
  	<td>&nbsp;</td>
	<td align="right"><b><?php echo $rwPeg['nama'];?></b></td>
  </tr>
  <?php
  mysql_close($konek);
  ?>
  <tr>
  	<td colspan="2">
	 <tr id="trTombol">
       <td colspan="3" class="noline" align="center">
			<input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
            </td>
    </tr>
	</td>
  </tr>
</table>
</body>
<script type="text/JavaScript">
function cetak(tombol){
	tombol.style.visibility='hidden';
	if(tombol.style.visibility=='hidden'){
		window.print();
		window.close();
	}
}
</script>
</html>
