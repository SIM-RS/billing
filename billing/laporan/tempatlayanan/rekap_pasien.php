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
        $waktu = " AND pl.tgl = '$tglAwal2' ";
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }else if($waktu == 'Bulanan'){
        $bln = $_POST['cmbBln'];
        $thn = $_POST['cmbThn'];
        $waktu = " AND month(pl.tgl) = '$bln' and year(pl.tgl) = '$thn' ";
        $Periode = "Bulan $arrBln[$bln] Tahun $thn";
    }else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //echo $arrBln[$tglAwal[1]];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = " AND pl.tgl between '$tglAwal2' and '$tglAkhir2' ";
        
        $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
    
    $jnsLay = $_REQUEST['JnsLayanan'];
    $tmpLay = $_REQUEST['TmpLayananJalan'];
    $stsPas = $_REQUEST['StatusPas'];
    
    $qJns = mysql_query("SELECT id, nama FROM b_ms_unit WHERE id = '".$jnsLay."'");
    $rwJns = mysql_fetch_array($qJns);
    
    $qTmp = mysql_query("SELECT id, nama FROM b_ms_unit WHERE id = '".$tmpLay."'");
    $rwTmp = mysql_fetch_array($qTmp);
    
    $qSts = mysql_query("SELECT id, nama FROM b_ms_kso WHERE id = '".$stsPas."'");
    $rwSts = mysql_fetch_array($qSts);
?>
<title>.: Rekapitulasi Data Pasien :.</title>
<style>
    .jdl{
        border-top:1px solid #FFFFFF;
        border-bottom:1px solid #FFFFFF;
        background-color:#00FF00;
        border-left:1px solid #FFFFFF;
        font-weight:bold;
        text-transform:uppercase;
        height:30;
        text-align:center;
    }
</style>
<table width="750" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
    <tr>
        <td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
    </tr>
    <tr>
        <td align="center" height="100" valign="top" style="font-size:14px; text-transform:uppercase; font-weight:bold;">rekapitulasi data pasien<br>jenis layanan <?php echo $rwJns['nama'];?><br>tempat layanan <?php if($tmpLay==0) echo "SEMUA"; else echo $rwTmp['nama'];?><br>penjamin pasien <?php if($stsPas==0) echo "SEMUA"; else echo $rwSts['nama'];?><br><?php echo $Periode;?></td>
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                <tr>
                    <td width="5%" class="jdl">no</td>
                    <td width="15%" class="jdl">tgl kunjungan</td>
                    <td width="10%" class="jdl">no mr</td>
                    <td width="30%" class="jdl">nama</td>
                    <td width="40%" class="jdl" style="border-right:1px solid #FFFFFF;">alamat</td>
                </tr>
                <?php
                        if($tmpLay==0){
                            $fUnit = "mu.parent_id = '".$jnsLay."'";
                        }else{
                            $fUnit = "mu.id = '".$tmpLay."'";
                        }
                        if($stsPas!=0) $fKso = "AND pl.kso_id = '".$stsPas."'";
                        /*$qTempat = "SELECT b_ms_unit.id, b_ms_unit.nama, COUNT(b_kunjungan.id) AS jml FROM b_kunjungan
                                    INNER JOIN b_ms_unit ON b_ms_unit.id = b_kunjungan.unit_id
                                    WHERE $fUnit $fKso $waktu GROUP BY b_ms_unit.id ORDER BY b_ms_unit.nama";*/
						$qTempat = "SELECT mu.id, mu.nama 
									FROM b_kunjungan k INNER JOIN b_pelayanan pl ON k.id=pl.kunjungan_id
									INNER JOIN b_ms_unit mu ON mu.id = pl.unit_id 
									WHERE $fUnit $fKso $waktu 
									GROUP BY mu.id ORDER BY mu.nama";
						//echo $qTempat."<br>";
                        $sTempat = mysql_query($qTempat);
						$jmlPas=0;
                        while($wTempat = mysql_fetch_array($sTempat))
                        {
                ?>
                <tr>
                    <td colspan="5" style="padding-left:10px; font-weight:bold; text-decoration:underline; text-transform:uppercase;" height="25" valign="bottom"><?php echo $wTempat['nama'];?></td>
                </tr>
                <?php
                        /*$qKso = "SELECT b_ms_kso.id, b_ms_kso.nama FROM b_kunjungan
                                INNER JOIN b_ms_kso ON b_ms_kso.id = b_kunjungan.kso_id
                                WHERE b_kunjungan.unit_id = '".$wTempat['id']."' $fKso $waktu GROUP BY b_ms_kso.id ORDER BY b_ms_kso.nama";*/
						$qKso = "SELECT kso.id, kso.nama 
									FROM b_kunjungan k INNER JOIN b_pelayanan pl ON k.id=pl.kunjungan_id
									INNER JOIN b_ms_kso kso ON kso.id = pl.kso_id 
									WHERE pl.unit_id='".$wTempat['id']."' $fKso $waktu 
									GROUP BY kso.id ORDER BY kso.nama";
						
                        $sKso = mysql_query($qKso);
                        while($wKso = mysql_fetch_array($sKso))
                        {
                ?>
                <tr>
                    <td colspan="5" style="padding-left:50px; font-weight:bold; text-transform:uppercase;" height="25" valign="bottom"><?php echo $wKso['nama']?></td>
                </tr>
                <?php
                        /*$qKunj = "SELECT DATE_FORMAT(b_kunjungan.tgl,'%d-%m-%Y') AS tgl, b_ms_pasien.no_rm, b_ms_pasien.nama, b_ms_pasien.alamat FROM b_ms_pasien
                                    INNER JOIN b_kunjungan ON b_kunjungan.pasien_id=b_ms_pasien.id
                                    WHERE b_kunjungan.unit_id='".$wTempat['id']."' AND b_kunjungan.kso_id='".$wKso['id']."' $waktu
                                    GROUP BY b_kunjungan.id ORDER BY b_kunjungan.id";*/
                        $qKunj = "SELECT DATE_FORMAT(pl.tgl,'%d-%m-%Y') AS tgl, mp.no_rm, mp.nama, mp.alamat FROM b_ms_pasien mp
                                    INNER JOIN b_kunjungan k ON k.pasien_id=mp.id INNER JOIN b_pelayanan pl ON k.id=pl.kunjungan_id
                                    WHERE pl.unit_id='".$wTempat['id']."' AND pl.kso_id='".$wKso['id']."' $waktu
                                    ORDER BY pl.id";
                        $sKunj = mysql_query($qKunj);
                        $no = 1;
                        while($wKunj = mysql_fetch_array($sKunj))
                        {                        
                ?>
                <tr>
                    <td style="text-align:center;"><?php echo $no;?></td>
                    <td style="text-align:center;"><?php echo $wKunj['tgl'];?></td>
                    <td style="text-align:center;"><?php echo $wKunj['no_rm'];?></td>
                    <td style="padding-left:5px; text-transform:uppercase;"><?php echo $wKunj['nama'];?></td>
                    <td style="padding-left:5px; text-transform:uppercase;"><?php echo $wKunj['alamat'];?></td>
                </tr>
                <?php
                        $no++;
                        }
						$jmlPas+=$no-1;
                        }
                       
                ?>
                <tr>
                    <td colspan="5" height="30" style="font-size:14px; color:#FF00FF; padding-left:10px;"><b>TOTAL PASIEN : <?php echo $jmlPas;?></b></td>
                </tr>
                <?php
                        }
                ?>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
</table>