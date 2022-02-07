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
<?php
    include("../../koneksi/konek.php");
    $date_now=gmdate('d-m-Y',mktime(date('H')+7));
    $jam = date("G:i");

    $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
    $waktu = $_POST['cmbWaktu'];
    if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        $waktu = " AND b_pelayanan.tgl = '$tglAwal2' ";
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
        $bln = $_POST['cmbBln'];
        $thn = $_POST['cmbThn'];
        $waktu = " AND MONTH(b_pelayanan.tgl) = '$bln' AND YEAR(b_pelayanan.tgl) = '$thn' ";
        $Periode = "Bulan $arrBln[$bln] Tahun $thn";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //echo $arrBln[$tglAwal[1]];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = " AND b_pelayanan.tgl BETWEEN '$tglAwal2' and '$tglAkhir2' ";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }

    $sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
    $rsPeg = mysql_query($sqlPeg);
    $rwPeg = mysql_fetch_array($rsPeg);
    
    $jnsLay = $_REQUEST['JnsLayananInap'];
    $tmpLay = $_REQUEST['TmpLayananInap'];
    
	$qJns = mysql_query("SELECT id, nama FROM b_ms_unit WHERE id = '$jnsLay'");
    $rwJns = mysql_fetch_array($qJns);
	
	if($tmpLay != '0'){
		$fUnit = "b_pelayanan.unit_id_asal='".$tmpLay."'";
		$qTmp = mysql_query("SELECT id, nama FROM b_ms_unit WHERE id = '$tmpLay'");
		$rwTmp = mysql_fetch_array($qTmp);
		$tmpNama = $rwTmp['nama'];
	} else {
		$fUnit = "0 = 0";
		$tmpNama = "SEMUA";
	}    
?>
<title>.: Laporan Pasien MRS :.</title>
<style>
    .jdl{
        border-top:1px solid #FFFFFF;
        border-bottom:1px solid #FFFFFF;
        font-size:12px;
        font-weight:bold;
        height:30;
        text-align:center;
        background-color:#00FF00;
        border-right:1px solid #FFFFFF;
    }
</style>
<table width="1000" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
    <tr>
        <td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
    </tr>
    <tr>
        <td style="text-transform:uppercase; font-size:14px; font-weight:bold; text-align:center;" height="70" valign="top">data pasien rawat inap<br>asal tempat layanan <?php echo $tmpNama;?> <u><?php echo $rwJns['nama'];?></u> <br><?php echo $Periode;?></td>
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                <tr>
                    <td class="jdl" width="5%">NO</td>
                    <td class="jdl" width="8%">NO.RM</td>
                    <td class="jdl" width="17%">NAMA</td>
                    <td class="jdl" width="20%">ALAMAT</td>
                    <td class="jdl" width="10%">UMUR</td>
                    <td class="jdl" width="5%">L/P</td>
                    <td class="jdl" width="15%">CARA BAYAR</td>
                    <td class="jdl" width="20%">DIAGNOSA</td>
                </tr>
                <?php
                    $sql = "SELECT b_ms_unit.id, b_ms_unit.nama, COUNT(b_pelayanan.id) AS jml FROM b_pelayanan
                            INNER JOIN b_ms_unit ON b_ms_unit.id=b_pelayanan.unit_id
                            WHERE $fUnit $waktu
                            AND b_ms_unit.penunjang=0 AND b_ms_unit.inap=1
                            GROUP BY b_ms_unit.id
                            ORDER BY b_ms_unit.nama";
                    $rs = mysql_query($sql);
                    $tot = 0;
                    while($rw = mysql_fetch_array($rs))
                    {
                ?>
                <tr>
                    <td colspan="8" height="30" valign="bottom" style="padding-left:5px; font-weight:bold; text-decoration:underline; text-transform:uppercase; color:#FF00FF"><?php echo $rw['nama'];?></td>
                </tr>
                <?php
                        $qDt = "SELECT b_ms_pasien.id AS pasien_id, b_pelayanan.id AS pelayanan_id, b_ms_pasien.no_rm, b_ms_pasien.nama AS pasien, b_kunjungan.alamat AS alamat,
                                b_kunjungan.umur_thn, b_kunjungan.umur_bln,  b_kunjungan.umur_hr,b_ms_pasien.sex, b_ms_kso.nama AS kso
                                FROM b_ms_pasien
                                INNER JOIN b_kunjungan ON b_kunjungan.pasien_id=b_ms_pasien.id
                                INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
                                INNER JOIN b_ms_kso ON b_ms_kso.id=b_pelayanan.kso_id
                                WHERE b_pelayanan.unit_id='".$rw['id']."' AND $fUnit $waktu GROUP BY b_pelayanan.id";
                        $rsDt = mysql_query($qDt);
                        $no = 1;
                        while($rwDt = mysql_fetch_array($rsDt))
                        {
                ?>
                <tr valign="top">
                    <td style="text-align:center;" height=20><?php echo $no;?>.</td>
                    <td style="text-align:center; text-transform:uppercase;"><?php echo $rwDt['no_rm'];?></td>
                    <td style="text-transform:uppercase;"><?php echo $rwDt['pasien'];?>&nbsp;</td>
                    <td style="text-transform:uppercase; padding-left:5px;"><?php echo $rwDt['alamat'];?></td>
                    <td style="text-align:right;"><?php if($rwDt['umur_thn']==0) echo $rwDt['umur_bln'].' bln'; else if($rwDt['umur_bln']==0) echo $rwDt['umur_thn'].' thn'; else echo $rwDt['umur_thn'].' thn '.$rwDt['umur_bln'].' bln'.$rwDt['umur_hr'].'hr';?>&nbsp;</td>
                    <td style="text-align:center;"><?php echo $rwDt['sex'];?></td>
                    <td style="text-align:center;"><?php echo $rwDt['kso'];?></td>
                    <td style="text-transform:uppercase; padding-left:5px;">
                    <?php
                        $qDiag = "SELECT b_ms_diagnosa.id, b_ms_diagnosa.nama
                                FROM b_diagnosa_rm INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id
                                WHERE b_diagnosa_rm.pelayanan_id='".$rwDt['pelayanan_id']."' GROUP BY b_ms_diagnosa.id";
                        $sDiag = mysql_query($qDiag);
                        while($wDiag = mysql_fetch_array($sDiag))
                        {
                            echo '- '.$wDiag['nama'].'<br>';
                        }
                    ?></td>
                </tr>
                <?php
                        $no++;
                        }
                        $tot = $tot + $rw['jml'];
                    }
                ?>
                <tr>
                    <td height="40" valign="bottom" colspan="8" style="font-weight:bold; font-size:16px; padding-left:20px; color:#FF00FF">TOTAL: <?php echo $tot;?> Pasien</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td style="text-align:right">Tgl Cetak:&nbsp;<?php echo $date_now.'&nbsp;Jam:&nbsp;'.$jam?>&nbsp;</td>
    </tr>
    <tr>
        <td height="50" valign="top" style="text-align:right">Yang Mencetak,&nbsp;</td>
    </tr>
    <tr>
        <td style="text-align:right; text-transform:uppercase;"><b><?php echo $rwPeg['nama'];?></b>&nbsp;</td>
    </tr>
    <tr id="trTombol">
        <td class="noline" align="center">
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
<script type="text/JavaScript">        
    function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
            window.print();
            window.close();
        }
    }
</script>