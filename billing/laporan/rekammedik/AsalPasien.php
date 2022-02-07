<?php
session_start();
include("../../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Asal Pasien Rawat Jalan - P. ANAK</title>
</head>

<body style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
<?php
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));

	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$waktu = $_POST['cmbWaktu'];
	if($waktu == 'Harian'){
		$tglAwal = explode('-',$_REQUEST['tglAwal2']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		$waktu = " and k.tgl = '$tglAwal2' ";
		$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
	}
	else if($waktu == 'Bulanan'){
		$bln = $_POST['cmbBln'];
		$thn = $_POST['cmbThn'];
		$waktu = " and month(k.tgl) = '$bln' and year(k.tgl) = '$thn' ";
		$Periode = "Bulan $arrBln[$bln] Tahun $thn";
	}
	else{
		$tglAwal = explode('-',$_REQUEST['tglAwal']);
		$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
		//echo $arrBln[$tglAwal[1]];
		$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
		$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
		$waktu = " and k.tgl between '$tglAwal2' and '$tglAkhir2' ";
		
		$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
	}
	
	$sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);

	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	
	$sqlKso = "SELECT id,nama from b_ms_kso where id = '".$_REQUEST['StatusPas']."'";
	$rsKso = mysql_query($sqlKso);
	$rwKso = mysql_fetch_array($rsKso);
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);

?>
<table width="925" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="7" style="font-size:13px;"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" align="center" height="50" style="font-size:15px;"><b>Laporan Asal Pasien Berdasarkan Penjamin Pasien <?php if($rwKso['nama']=="") echo 'Semua'; else echo $rwKso['nama'] ?><br />Jenis Layanan <?php echo $rwUnit1['nama']; ?> - Tempat Layanan <?php if($rwUnit2['nama']=="") echo 'Semua'; else echo $rwUnit2['nama'] ?><br /><?php echo $Periode;?></b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" align="right">Yang Mencetak :&nbsp;<?php echo $rwPeg['nama'];?>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" align="right">Tanggal Cetak :&nbsp;<?php echo $date_now;?>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7">
	<table border="0" cellpadding="0" cellspacing="0" width="925">
		<tr>
			<td>&nbsp;</td>
			<td colspan="6">&nbsp;JUMLAH/CARA MASUK</td>
		  </tr>
		  <tr>
			<td width="200" height="28" style=" border-bottom:1px solid;">&nbsp;STATUS PASIEN</td>
			<?php
					$fKso = '';
					if($_REQUEST['StatusPas']!=0) {
						$fKso = " AND k.kso_id = ".$_REQUEST['StatusPas'];
					}
					/*if($_REQUEST['TmpLayanan']==0) {
						$fTmp = " k.jenis_layanan = '".$_REQUEST['JnsLayanan']."' ";
					}
					else {
						$fTmp = " k.unit_id = '".$_REQUEST['TmpLayanan']."' ";
					}*/
					$sqlCM = "SELECT k.asal_kunjungan, ar.nama
							FROM b_kunjungan k
							INNER JOIN b_ms_asal_rujukan ar ON ar.id = k.asal_kunjungan
							WHERE k.unit_id = '".$_REQUEST['TmpLayanan']."' $fKso
							$waktu GROUP BY ar.nama
							ORDER BY ar.nama";
					$rsCM = mysql_query($sqlCM);
					$col = 0;
					while($rwCM = mysql_fetch_array($rsCM)) {
						$col++;
			?>
			<td width="80" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid; text-align:right;"><?php echo $rwCM['nama'];?>&nbsp;</td>
			<?php
				}
			?>
			<td width="80" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid; text-align:right; border-right:1px solid;">TOTAL&nbsp;</td>
		  </tr>
		  <?php
		  		$sqlAK = "SELECT b_ms_kso.id, b_ms_kso.nama
						FROM b_ms_kso
						INNER JOIN b_kunjungan k ON k.kso_id = b_ms_kso.id
						INNER JOIN b_ms_asal_rujukan ar ON ar.id = k.asal_kunjungan
						where k.unit_id = '".$_REQUEST['TmpLayanan']."' $fKso $waktu
						group by b_ms_kso.id";
				$rsAK = mysql_query($sqlAK);
				$ttlTot = 0;
				while($rwAK = mysql_fetch_array($rsAK)) {
					$tot=0;
		  ?>
		  <tr>
			<td style="border-left:1px solid; border-bottom:1px solid;" height="20">&nbsp;<?php echo $rwAK['nama']; ?></td>
		  <?php 
				$rsCM = mysql_query($sqlCM);
                                $j = 0;
                                while($rwCM = mysql_fetch_array($rsCM)) {
                                    $sqlJml = "select count(k.id) as jml from b_kunjungan k
                                        where kso_id = '".$rwAK['id']."' and asal_kunjungan = '".$rwCM['asal_kunjungan']."'
                                        and k.unit_id = '".$_REQUEST['TmpLayanan']."'
					$waktu";
                                    $rsJml = mysql_query($sqlJml);
                                    $rwJml = mysql_fetch_array($rsJml);
                                    $tot = $tot+$rwJml['jml'];
                                    $jml[$j] += $rwJml['jml'];
                                    $j++;
                                    ?>
                            <td style="border-left:1px solid; border-bottom:1px solid; text-align:right;">&nbsp;<?php if($rwJml['jml']=="") echo 0; else echo $rwJml['jml'];?>&nbsp;</td>
                                    <?php
                                }
                                $ttlTot += $tot;
                                ?>
                            <td style="border-left:1px solid; border-bottom:1px solid; text-align:right; border-right:1px solid;"><?php echo $tot;?>&nbsp;</td>
                        </tr>
                            <?php
                        }mysql_free_result($rsCM);
			mysql_free_result($rsJml);
                        ?>
                        <tr>
                            <td style="border-left:1px solid; text-align:right; border-bottom:1px solid;" height="20">&nbsp;</td>
                            <?php
                            for($i=0; $i<$col; $i++){
                                ?>
                            <td style="border-left:1px solid; text-align:right; border-bottom:1px solid;" height="20"><?php echo $jml[$i]?>&nbsp;</td>
                                <?php

                            }
                            ?>
                            <td style="border-left:1px solid; text-align:right; border-bottom:1px solid; border-right:1px solid;"><?php echo $ttlTot;?>&nbsp;</td>
                        </tr>
	</table>	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr id="trTombol">
        <td colspan="7" class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
<?php
	mysql_free_result($rsUnit1);
	mysql_free_result($rsUnit2);
	mysql_free_result($rsKso);
	mysql_free_result($rsPeg);
	mysql_close($konek);
?>
</html>
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
