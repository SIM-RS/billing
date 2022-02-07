<?php
session_start();
include ("../../koneksi/konek.php");
include("../../sesi.php");
//session_start();
//=====================================
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
	
$stsPas=$_REQUEST['StatusPas'];
if($stsPas != 0) {
    $fKso = " AND pl.kso_id = $stsPas ";
    $qJnsLay=mysql_query("select nama from b_ms_kso where id=".$stsPas);
    $rwJnsLay=mysql_fetch_array($qJnsLay);
}
$jnsLayanan = $_REQUEST['JnsLayanan'];
$tmpLayanan=$_REQUEST['TmpLayanan'];
if($tmpLayanan == 0) {
    $id = $jnsLayanan;
    $fTmp = " p.jenis_layanan = $jnsLayanan ";
}
else {
    $fTmp = " p.unit_id = $tmpLayanan ";
}

$qUnit = "SELECT id, nama FROM b_ms_unit WHERE id = '".$tmpLayanan."'";
$rsUnit = mysql_query($qUnit);
$rwUnit = mysql_fetch_array($rsUnit);
$qUn = "SELECT nama FROM b_ms_unit WHERE id = '".$jnsLayanan."'";
$rsUn = mysql_query($qUn);
$rwUn = mysql_fetch_array($rsUn);
$qUsr = mysql_query("select nama from b_ms_pegawai where id=".$_SESSION['userId']);
$rwUsr = mysql_fetch_array($qUsr);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Rekap Kunjungan</title>
    </head>

    <body>
        <table width="750" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
            <tr>
                <td colspan="2"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
            </tr>
            <tr>
                <td height="70" colspan="2" align="center" style="font-size: 14px; font-weight:bold; text-transform:uppercase;" valign="top">
                    LAPORAN KUNJUNGAN <?php echo $rwUnit['nama']; ?>
                    <br/><?php echo $Periode;?>&nbsp;</td>
            </tr>
            <tr>
                <td width="45%" align="left" style="font-weight:bold">&nbsp;
                    Penjamin Pasien&nbsp;:&nbsp;
                    <?php
                    if($stsPas==0) echo 'Semua';
                    else echo $rwJnsLay['nama'];
                    ?>
                </td>
                <td width="55%" height="30" align="right" style="font-weight:bold; padding-right:20px;">
                    Yang Mencetak&nbsp;:&nbsp;<?php echo $rwUsr['nama']?>&nbsp;
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                        <tr>
				<td height="28" width="30%" style="font-size: 12px; border-bottom:#00FF00 solid 1px; border-top:#00FF00 1px solid; font-weight:bold; text-transform:uppercase;">&nbsp;Jenis Layanan</td>
				<td width="30%" style="font-size: 12px; border-bottom:#00FF00 solid 1px; border-top:#00FF00 1px solid; font-weight:bold; text-transform:uppercase;">&nbsp;Tempat Layanan Asal</td>
				<td width="20%" align="center" style="font-size: 12px; border-bottom:#00FF00 solid 1px; border-top:#00FF00 1px solid; font-weight:bold; text-transform:uppercase;">&nbsp;Jml Pasien</td>
				<td width="20%" align="right" style="font-size: 12px; border-bottom:#00FF00 solid 1px; border-top:#00FF00 1px solid; font-weight:bold; text-transform:uppercase; padding-right:10px;">&nbsp;Tarif RS</td>
                        </tr>
                        <?php
                         $qTmp = "SELECT up.nama AS nama_jenis, up.id
								FROM b_pelayanan pl INNER JOIN b_ms_unit u ON pl.unit_id_asal = u.id
								INNER JOIN b_ms_unit up ON u.parent_id = up.id
								INNER JOIN b_tindakan t ON t.pelayanan_id = pl.id
								WHERE pl.unit_id = '".$tmpLayanan."' $waktu $fKso
								GROUP BY up.nama";
			$rsTmp = mysql_query($qTmp);
			while($rwTmp = mysql_fetch_array($rsTmp))
			{
			?>
                        <tr>
				<td colspan="4">&nbsp;<b><?php echo $rwTmp['nama_jenis'];?></b></td>
			</tr>
                        <?php
                         	$query = "SELECT j.nama, COUNT(j.id) AS jml, SUM(j.biaya) AS biaya FROM (SELECT u.nama, pl.id, SUM(t.biaya) AS biaya FROM b_kunjungan k INNER JOIN b_pelayanan pl ON pl.kunjungan_id=k.id
INNER JOIN b_ms_unit u ON u.id = pl.unit_id_asal 
LEFT JOIN b_tindakan t ON t.pelayanan_id = pl.id WHERE pl.unit_id = '".$rwUnit['id']."'
					AND u.parent_id = '".$rwTmp['id']."' $waktu $fKso GROUP BY pl.id) AS j GROUP BY j.nama";
                            $qAsal = mysql_query($query);
                            $sTotPas=0;
                            $sTotBiaya=0;
                            $sTotBayar=0;
                            $sTotUtang=0;
                            while($rwAsal = mysql_fetch_array($qAsal))
			    {
                        ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td style="text-transform:uppercase">&nbsp;<?php echo $rwAsal['nama'];?>                            </td>
                            <td style="text-align:right; padding-right:50px;">
                            <?php echo $rwAsal['jml'];?>                            </td>
                            <td align="right" style="padding-right:10px;">
                            <?php echo number_format($rwAsal['biaya'],0,",",".");?>&nbsp;                            </td>
                        </tr>
                        <?php
                                $sTotPas+=$rwAsal['jml'];
                                $sTotBiaya+=$rwAsal['biaya'];
                            }
                            ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td style="font-weight:bold; text-align:right; padding-right:10px;">Subtotal</td>
                            <td style="border-top:#FF0000 solid 1px; text-align:right; padding-right:50px; font-weight:bold;">
                            <?php echo $sTotPas?>                            </td>
                            <td align="right" style="border-top:#FF0000 solid 1px; font-weight:bold; padding-right:10px;">
                            <?php echo number_format($sTotBiaya,0,",",".")?>&nbsp;                            </td>
                        </tr>
						<tr><td colspan="4">&nbsp;</td></tr>
                            <?php
                            $totPas+=$sTotPas;
                            $totBiaya+=$sTotBiaya;
                        }
                        ?>
                        <tr height="30">
                            <td style="border-top:#FF0000 solid 1px; border-bottom:#FF0000 1px solid;">&nbsp;</td>
                            <td style="border-top:#FF0000 solid 1px; border-bottom:#FF0000 1px solid; font-weight:bold; text-align:right; padding-right:10px;">TOTAL</td>
                            <td align="right" style="border-top:#FF0000 solid 1px; border-bottom:#FF0000 1px solid; font-weight:bold; padding-right:50px;">
                            <?php echo $totPas;?>                            </td>
                            <td align="right" style="border-top:#FF0000 solid 1px; border-bottom:#FF0000 1px solid; font-weight:bold; padding-right:10px;">
                            <?php echo number_format($totBiaya,0,",",".");?>&nbsp;                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr id="trTombol">
        <td colspan="2" class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
        </td>
    </tr>
        </table>
    </body>
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
