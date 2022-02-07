<?php
session_start();
include("../../sesi.php");
?>
<title>.: Laporan Penerimaan (Seluruh Pasien)</title>
<?php
    include("../../koneksi/konek.php");
    $date_now=gmdate('d-m-Y',mktime(date('H')+7));
    $jam = date("G:i");

    $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
    $waktu = $_POST['cmbWaktu'];
    if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //$waktu = " AND b_pelayanan.tgl = '$tglAwal2' ";
		$waktu = " AND b.tgl='$tglAwal2'";
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }
    else if($waktu == 'Bulanan'){
        $bln = $_POST['cmbBln'];
        $thn = $_POST['cmbThn'];
        //$waktu = " AND month(b_pelayanan.tgl) = '$bln' AND year(b_pelayanan.tgl) = '$thn' ";
		$waktu = " AND MONTH(b.tgl)='$bln' AND YEAR(b.tgl)='$thn'";
        $Periode = "Bulan $arrBln[$bln] Tahun $thn";
    }
    else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //echo $arrBln[$tglAwal[1]];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        //$waktu = " AND b_pelayanan.tgl between '$tglAwal2' AND '$tglAkhir2' ";
		 $waktu = " AND b.tgl BETWEEN '$tglAwal2' AND '$tglAkhir2'";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
    
    $jnsLay = $_REQUEST['JnsLayanan'];
    $tmpLay = $_REQUEST['TmpLayanan'];
    $stsPas = $_REQUEST['StatusPas'];
    
    $sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$jnsLay."'";
    $rsUnit1 = mysql_query($sqlUnit1);
    $rwUnit1 = mysql_fetch_array($rsUnit1);

    $sqlUnit2 = "SELECT id,nama,inap FROM b_ms_unit WHERE id = '".$tmpLay."'";
    $rsUnit2 = mysql_query($sqlUnit2);
    $rwUnit2 = mysql_fetch_array($rsUnit2);
    
    /*$sqlKso = "SELECT id,nama from b_ms_kso where id = '".$stsPas."'";
    $rsKso = mysql_query($sqlKso);
    $rwKso = mysql_fetch_array($rsKso);*/
    
    $sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
    $rsPeg = mysql_query($sqlPeg);
    $rwPeg = mysql_fetch_array($rsPeg);

?>
<table width="800" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
    <tr>
        <td colspan="2"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
    </tr>
    <tr>
        <td colspan="2" height="70" valign="top" style="text-align:center; text-transform:uppercase; font-weight:bold; font-size:14px;">laporan penerimaan (seluruh pasien) <?php echo $rwUnit1['nama']?> - <?php echo $rwUnit2['nama']?><br><?php echo $Periode;?></td>
    </tr>
    <tr>
        <td height="30" width="50%" style="font-weight:bold">&nbsp;Tempat Layanan:&nbsp;<?php echo $rwUnit2['nama'];?></td>
        <td width="50%" style="text-align:right">Yang Mencetak:&nbsp;<b><?php echo $rwPeg['nama']?></b>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                <tr style="font-weight:bold;">
                    <td width="10%" height="30" style="border-bottom:1px solid; border-top:1px solid;">Status Pasien</td>
                    <td width="15%" style="border-bottom:1px solid; border-top:1px solid;">Tgl. Bayar</td>
                    <td width="15%" style="border-bottom:1px solid; border-top:1px solid;">Tgl. Kunjungan</td>
                    <td width="10%" style="border-bottom:1px solid; border-top:1px solid;">No. RM</td>
                    <td width="30%" style="border-bottom:1px solid; border-top:1px solid; padding-left:10px;">Nama</td>
                    <td width="20%" style="text-align:right; border-bottom:1px solid; border-top:1px solid; padding-right:10px;">Penerimaan</td>
                </tr>
				<?php 
					if ($stsPas==0){
						$sqlKso1 = "SELECT DISTINCT kso.id,kso.nama 
FROM b_bayar b INNER JOIN b_bayar_tindakan bt ON b.id=bt.bayar_id
INNER JOIN b_tindakan t ON bt.tindakan_id=t.id INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id
INNER JOIN b_ms_kso kso ON t.kso_id=kso.id
WHERE p.unit_id='$tmpLay' $waktu AND bt.tipe=0 AND bt.nilai>0 GROUP BY p.id";
					}else{
						$sqlKso1 = "SELECT id,nama from b_ms_kso where id = '".$stsPas."'";
					}
					$rsKso1 = mysql_query($sqlKso1);
					while ($rwKso1 = mysql_fetch_array($rsKso1)){
				?>
                <tr>
                    <td colspan="6" style="font-weight:bold; text-decoration:underline;">&nbsp;<?php echo $rwKso1['nama']; ?></td>
                </tr>
                <?php
						if ($rwUnit2['inap']==1){
							$sql = "SELECT t2.*,DATE_FORMAT(t2.tgl,'%d-%m-%Y') AS tglBayar,DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tglKunjungan,mp.no_rm,mp.nama 
FROM (SELECT t1.id,t1.kunjungan_id,t1.user_act,t1.tgl,t1.id idp,SUM(t1.nilai) AS nilai
FROM (SELECT b.id,b.kunjungan_id,b.user_act,b.tgl,p.id idp,SUM(bt.nilai) AS nilai 
FROM b_bayar b INNER JOIN b_bayar_tindakan bt ON b.id=bt.bayar_id INNER JOIN b_tindakan t ON bt.tindakan_id=t.id 
INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id 
WHERE p.unit_id='$tmpLay' $waktu AND t.kso_id='".$rwKso1['id']."' AND bt.tipe=0 AND bt.nilai>0 GROUP BY p.id
UNION 
SELECT b.id,b.kunjungan_id,b.user_act,b.tgl,p.id idp,SUM(bt.nilai) AS nilai 
FROM b_bayar b INNER JOIN b_bayar_tindakan bt ON b.id=bt.bayar_id INNER JOIN b_tindakan_kamar t ON bt.tindakan_id=t.id 
INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id 
WHERE p.unit_id='$tmpLay' $waktu AND p.kso_id='".$rwKso1['id']."' AND bt.tipe=1 AND bt.nilai>0 GROUP BY p.id) AS t1 GROUP BY t1.id) AS t2 
INNER JOIN b_kunjungan k ON t2.kunjungan_id=k.id INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id";
						}else{
							$sql = "SELECT t1.*,DATE_FORMAT(t1.tgl,'%d-%m-%Y') AS tglBayar,DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tglKunjungan,mp.no_rm,mp.nama 
FROM (SELECT b.id,b.kunjungan_id,b.user_act,b.tgl,p.id idp,SUM(bt.nilai) AS nilai 
FROM b_bayar b INNER JOIN b_bayar_tindakan bt ON b.id=bt.bayar_id
INNER JOIN b_tindakan t ON bt.tindakan_id=t.id INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id 
WHERE p.unit_id='$tmpLay' $waktu AND t.kso_id='".$rwKso1['id']."' AND bt.tipe=0 AND bt.nilai>0 GROUP BY p.id) AS t1 
INNER JOIN b_kunjungan k ON t1.kunjungan_id=k.id INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id";
						}
                        $rs = mysql_query($sql);
                        $no = 1;
                        $total = 0;
                        while($rw = mysql_fetch_array($rs))
                        {
                ?>
                <tr>
                    <td style="padding-left:30px;"><?php echo $no;?></td>
                    <td>&nbsp;<?php echo $rw['tglBayar'];?></td>
                    <td>&nbsp;<?php echo $rw['tglKunjungan'];?></td>
                    <td>&nbsp;<?php echo $rw['no_rm'];?></td>
                    <td style="text-transform:uppercase; padding-left:10px;">&nbsp;<?php echo $rw['nama'];?></td>
                    <td style="padding-right:10px; text-align:right;"><?php echo number_format($rw['nilai'],0,",",".");?></td>
                </tr>
                <?
							$no++;
							$total = $total + $rw['nilai'];
                        }
						mysql_free_result($rs);
                ?>
                <tr>
                    <td height="30" style="border-bottom:1px solid; border-top:1px solid;">&nbsp;</td>
                    <td style="border-bottom:1px solid; border-top:1px solid;">&nbsp;</td>
                    <td style="border-bottom:1px solid; border-top:1px solid;">&nbsp;</td>
                    <td style="border-bottom:1px solid; border-top:1px solid;">&nbsp;</td>
                    <td style="text-align:right; font-weight:bold; border-bottom:1px solid; border-top:1px solid;">Sub Total&nbsp;</td>
                    <td style="text-align:right; font-weight:bold; padding-right:10px; border-bottom:1px solid; border-top:1px solid;"><?php echo number_format($total,0,",",".");?></td>
                </tr>
                <?php 
				}
				?>
            </table>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td height="70" valign="top" align="right">Tgl. Cetak:&nbsp;<?php echo $date_now.'&nbsp;Jam:&nbsp;'.$jam;?>&nbsp;<br>Yang Mencetak,</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right"><b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
    </tr>
    <tr id="trTombol">
        <td class="noline" align="center" colspan="2">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
    </tr>
</table>
<?php
    mysql_free_result($rsUnit1);
    mysql_free_result($rsUnit2);
    //mysql_free_result($rsKso);
    mysql_free_result($rsPeg);
    mysql_close($konek);
?>
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