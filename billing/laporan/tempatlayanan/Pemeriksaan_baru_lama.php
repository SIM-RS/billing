<?php
session_start();
include("../../sesi.php");
?>
<?php 
if($_POST['export']=='excel'){
header("Content-type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="Lap Buku Register Pasien.xls"');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Laporan Pemeriksaan Pasien :.</title>
</head>

<body style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
<?php
	include("../../koneksi/konek.php");
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');

$waktu = $_POST['cmbWaktu'];
if($waktu == 'Harian'){
	$tglAwal = explode('-',$_REQUEST['tglAwal2']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	$waktu = " and pl.tgl = '$tglAwal2' ";
	$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
}
else if($waktu == 'Bulanan'){
	$bln = $_POST['cmbBln'];
	$thn = $_POST['cmbThn'];
	$waktu = " and month(pl.tgl) = '$bln' and year(pl.tgl) = '$thn' ";
	$Periode = "Bulan $arrBln[$bln] Tahun $thn";
}
else{
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	//echo $arrBln[$tglAwal[1]];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	$waktu = " and pl.tgl between '$tglAwal2' and '$tglAkhir2' ";
	
	$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
}
	
	$sqlJnsLay = "SELECT nama FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsJnsLay = mysql_query($sqlJnsLay);
	$rwJnsLay = mysql_fetch_array($rsJnsLay);
	
if($_REQUEST['TmpLayanan']!=0){
	$sqlTmpLay = "SELECT nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsTmpLay = mysql_query($sqlTmpLay);
	$rwTmpLay = mysql_fetch_array($rsTmpLay);
	$fUnit = " AND mu.id=".$_REQUEST['TmpLayanan'];
}else
	$fUnit = " AND mu.parent_id=".$_REQUEST['JnsLayanan'];
	
$stsPas=$_REQUEST['StatusPas'];
	if($stsPas != 0) {
    	$fKso = " AND pl.kso_id = $stsPas ";
	}


?>
	<table width="800" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td align="left" style="font-weight:bold; font-size:13px"><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td align="center" style="font-weight:bold; font-size:15px">LAPORAN PEMERIKASAAN/TINDAKAN <?php echo $rwTmpLay['nama']?><br/><?php echo $Periode;?></td>
		</tr>
		<tr>
			<td>
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td width="35%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid; border-top:#000000 solid 1px">Pemerikasaan / Tindakan</td>
						<td width="15%" align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid; border-top:#000000 solid 1px">Jumlah</td>
					</tr>
					<?
						$query = "SELECT mt.nama AS tindakan, SUM(t.qty) AS jml FROM b_ms_tindakan mt
								INNER JOIN b_ms_tindakan_kelas tk ON tk.ms_tindakan_id = mt.id
								INNER JOIN b_tindakan t ON t.ms_tindakan_kelas_id = tk.id
								INNER JOIN b_pelayanan pl ON pl.id = t.pelayanan_id
								INNER JOIN b_kunjungan k ON k.id = pl.kunjungan_id
								WHERE pl.unit_id = '".$_REQUEST['TmpLayanan']."'
								$waktu GROUP BY mt.nama";
						$exec = mysql_query($query);
						while($dquery = mysql_fetch_array($exec))
						{
							?>
                            	<tr>
                                    <td>&nbsp;<?php echo $dquery['tindakan'];?></td>
                                    <td align="center"><?php echo $dquery['jml'];?></td>
                                </tr>
                            <?
						}
                    ?>
					<tr><td colspan="4" height="30">&nbsp;</td></tr>
					<tr id="trTombol">
        <td colspan="4" class="noline" align="center">
        <?php 
            if($_POST['export']!='excel'){
        ?>
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
         <?php 
            }
         ?>
        </td>
    </tr>
				</table>
			</td>
		</tr>
	</table>
</body>
<?php
	mysql_free_result($rsJnsLay);
	mysql_free_result($rsTmpLay);
	mysql_close($konek);
?>
</html>
<script type="text/JavaScript">

/*try{	
formatF4();
}catch(e){
window.location='../../addon/jsprintsetup.xpi';
}*/
    function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
		/*try{
			mulaiPrint();
		}
		catch(e){
			window.print();
		}*/
		window.print();
		window.close();
        }
    }
</script>