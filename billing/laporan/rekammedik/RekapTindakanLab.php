<?php
session_start();
include("../../sesi.php");
?>
<title>Rekapitulasi Tindakan Laboratorium</title>
<?php
    include("../../koneksi/konek.php");
    $date_now=gmdate('d-m-Y',mktime(date('H')+7));
    $jam = date("G:i");

    $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
    
    $waktu = $_POST['cmbWaktu'];
    if($waktu == 'Harian'){
            $tglAwal = explode('-',$_REQUEST['tglAwal2']);
            $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
            $waktu = " and b_pelayanan.tgl = '$tglAwal2' ";
            $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }
    else if($waktu == 'Bulanan'){
            $bln = $_POST['cmbBln'];
            $thn = $_POST['cmbThn'];
            $waktu = " and month(b_pelayanan.tgl) = '$bln' and year(b_pelayanan.tgl) = '$thn' ";
            $Periode = "Bulan $arrBln[$bln] Tahun $thn";
    }
    else{
            $tglAwal = explode('-',$_REQUEST['tglAwal']);
            $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
            //echo $arrBln[$tglAwal[1]];
            $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
            $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
            $waktu = " and b_pelayanan.tgl between '$tglAwal2' and '$tglAkhir2' ";
            
            $Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
    }
	
	$jnsLay = $_REQUEST['JnsLayanan'];
	$tmpLay = $_REQUEST['TmpLayanan'];
	$stsPas = $_REQUEST['StatusPas'];
	
    $sqlUnit1 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$jnsLay."'";
    $rsUnit1 = mysql_query($sqlUnit1);
    $rwUnit1 = mysql_fetch_array($rsUnit1);

    $sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$tmpLay."'";
    $rsUnit2 = mysql_query($sqlUnit2);
    $rwUnit2 = mysql_fetch_array($rsUnit2);

    $sqlKso = "SELECT id,nama from b_ms_kso where id = '".$stsPas."'";
    $rsKso = mysql_query($sqlKso);
    $rwKso = mysql_fetch_array($rsKso);

    $sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
    $rsPeg = mysql_query($sqlPeg);
    $rwPeg = mysql_fetch_array($rsPeg);
?>
<table width="1000" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
    <tr>
        <td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
    </tr>
    <tr>
        <td height="70" valign="top" style="text-align:center; font-size:14px; text-transform:uppercase; font-weight:bold;">rekapitulasi pemeriksaan <?php echo $rwUnit1['nama'];?> - <?php echo $rwUnit2['nama'];?><br><?php echo $rwKso['nama'];?><br><?php echo $Periode;?></td>
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                <tr style="font-weight:bold;">
                    <td rowspan="2" style="text-align:center; border-bottom:1px solid; border-top:1px solid; border-left:1px solid; border-right:1px solid;">Pemeriksaan/Tindakan</td>
                    <td colspan="11" style="text-align:center; border-bottom:1px solid; border-top:1px solid; border-right:1px solid;" height="28">Asal Tempat Layanan - Rawat Inap</td>
                    <td rowspan="2" style="text-align:center; font-size:14px; border-bottom:1px solid; border-top:1px solid; border-right:1px solid;">&sum;</td>
                </tr>
                <tr style="font-weight:bold; text-align:center">
                    <td style="border-bottom:1px solid; border-right:1px solid;">Tulip</td>
                    <td style="border-bottom:1px solid; border-right:1px solid;">Teratai</td>
                    <td style="border-bottom:1px solid; border-right:1px solid;">Mawar<br />Kuning</td>
                    <td style="border-bottom:1px solid; border-right:1px solid;">Mawar<br />Merah<br />Putih</td>
                    <td style="border-bottom:1px solid; border-right:1px solid;">Mawar<br />Pink</td>
                    <td style="border-bottom:1px solid; border-right:1px solid;">ROI<br />IGD</td>
                    <td style="border-bottom:1px solid; border-right:1px solid;">Pavilyun</td>
                    <td style="border-bottom:1px solid; border-right:1px solid;">Kamar<br />Bersalin</td>
                    <td style="border-bottom:1px solid; border-right:1px solid;">Mawar<br />Hijau</td>
                    <td style="border-bottom:1px solid; border-right:1px solid;">Ruang<br />Isolasi<br />Bayi</td>
                    <td style="border-bottom:1px solid; border-right:1px solid;">IPIT</td>
                </tr>
                <?php
                        $fKso = " AND b_kunjungan.kso_id = '".$stsPas."'";
                        $fUnit = " b_pelayanan.unit_id = '".$tmpLay."'";
                        $sql = "SELECT b_kunjungan.id AS kunjungan_id, 
                                b_pelayanan.id AS pelayanan_id,
                                b_ms_tindakan.id AS tindakan_id, b_ms_tindakan.nama AS tindakan 
                                FROM b_kunjungan
                                INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                                INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
                                INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id
                                INNER JOIN b_ms_tindakan ON b_ms_tindakan_kelas.ms_tindakan_id = b_ms_tindakan.id
                                INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id_asal
                                WHERE $fUnit $fKso $waktu AND b_ms_unit.inap = '1' GROUP BY b_ms_tindakan.id ORDER BY b_ms_tindakan.nama";
                        $rs = mysql_query($sql);
                        $no = 1;
                        $tw1 = 0;
                        $tw2 = 0;
                        $tw3 = 0;
                        $tw4 = 0;
                        $tw5 = 0;
                        $tw6 = 0;
                        $tw7 = 0;
                        $tw8 = 0;
                        $tw9 = 0;
                        $tw10 = 0;
                        $tw11 = 0;
                        $total = 0;
                        while($rw = mysql_fetch_array($rs))
                        {
                            $q1 = "SELECT COUNT(b_tindakan.pelayanan_id) AS jml
                            FROM b_kunjungan
                            INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                            INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
                            INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id
                            INNER JOIN b_ms_tindakan ON b_ms_tindakan_kelas.ms_tindakan_id = b_ms_tindakan.id
                            WHERE $fUnit AND b_ms_tindakan.id = '".$rw['tindakan_id']."' AND (b_pelayanan.unit_id_asal = '37' OR b_pelayanan.unit_id_asal = '103')
                            $waktu $fKso";
                            $s1 = mysql_query($q1);
                            $w1 = mysql_fetch_array($s1);
                            
                            $q2 = "SELECT COUNT(b_tindakan.pelayanan_id) AS jml
                            FROM b_kunjungan
                            INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                            INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
                            INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id
                            INNER JOIN b_ms_tindakan ON b_ms_tindakan_kelas.ms_tindakan_id = b_ms_tindakan.id
                            WHERE $fUnit AND b_ms_tindakan.id = '".$rw['tindakan_id']."' AND (b_pelayanan.unit_id_asal = '38' OR b_pelayanan.unit_id_asal = '102')
                            $waktu $fKso";
                            $s2 = mysql_query($q2);
                            $w2 = mysql_fetch_array($s2);
                            
                            $q3 = "SELECT COUNT(b_tindakan.pelayanan_id) AS jml
                            FROM b_kunjungan
                            INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                            INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
                            INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id
                            INNER JOIN b_ms_tindakan ON b_ms_tindakan_kelas.ms_tindakan_id = b_ms_tindakan.id
                            WHERE $fUnit AND b_ms_tindakan.id = '".$rw['tindakan_id']."' AND (b_pelayanan.unit_id_asal = '39' OR b_pelayanan.unit_id_asal = '101')
                            $waktu $fKso";
                            $s3 = mysql_query($q3);
                            $w3 = mysql_fetch_array($s3);
                            
                            $q4 = "SELECT COUNT(b_tindakan.pelayanan_id) AS jml
                            FROM b_kunjungan
                            INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                            INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
                            INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id
                            INNER JOIN b_ms_tindakan ON b_ms_tindakan_kelas.ms_tindakan_id = b_ms_tindakan.id
                            WHERE $fUnit AND b_ms_tindakan.id = '".$rw['tindakan_id']."' AND b_pelayanan.unit_id_asal = '107' $waktu $fKso";
                            $s4 = mysql_query($q4);
                            $w4 = mysql_fetch_array($s4);
                            
                            $q5 = "SELECT COUNT(b_tindakan.pelayanan_id) AS jml
                            FROM b_kunjungan
                            INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                            INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
                            INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id
                            INNER JOIN b_ms_tindakan ON b_ms_tindakan_kelas.ms_tindakan_id = b_ms_tindakan.id
                            WHERE $fUnit AND b_ms_tindakan.id = '".$rw['tindakan_id']."' AND b_pelayanan.unit_id_asal = '49' $waktu $fKso";
                            $s5 = mysql_query($q5);
                            $w5 = mysql_fetch_array($s5);
                            
                            $q6 = "SELECT COUNT(b_tindakan.pelayanan_id) AS jml
                            FROM b_kunjungan
                            INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                            INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
                            INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id
                            INNER JOIN b_ms_tindakan ON b_ms_tindakan_kelas.ms_tindakan_id = b_ms_tindakan.id
                            WHERE $fUnit AND b_ms_tindakan.id = '".$rw['tindakan_id']."' AND b_pelayanan.unit_id_asal = '112' $waktu $fKso";
                            $s6 = mysql_query($q6);
                            $w6 = mysql_fetch_array($s6);
                            
                            $q7 = "SELECT COUNT(b_tindakan.pelayanan_id) AS jml
                            FROM b_kunjungan
                            INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                            INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
                            INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id
                            INNER JOIN b_ms_tindakan ON b_ms_tindakan_kelas.ms_tindakan_id = b_ms_tindakan.id
                            WHERE $fUnit AND b_ms_tindakan.id = '".$rw['tindakan_id']."' AND (b_pelayanan.unit_id_asal = '51' OR b_pelayanan.unit_id_asal = '56' OR b_pelayanan.unit_id_asal = '98' OR b_pelayanan.unit_id_asal = '99') $waktu $fKso";
                            $s7 = mysql_query($q7);
                            $w7 = mysql_fetch_array($s7);
                            
                            $q8 = "SELECT COUNT(b_tindakan.pelayanan_id) AS jml
                            FROM b_kunjungan
                            INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                            INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
                            INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id
                            INNER JOIN b_ms_tindakan ON b_ms_tindakan_kelas.ms_tindakan_id = b_ms_tindakan.id
                            WHERE $fUnit AND b_ms_tindakan.id = '".$rw['tindakan_id']."' AND b_pelayanan.unit_id_asal = '72' $waktu $fKso";
                            $s8 = mysql_query($q8);
                            $w8 = mysql_fetch_array($s8);
                            
                            $q9 = "SELECT COUNT(b_tindakan.pelayanan_id) AS jml
                            FROM b_kunjungan
                            INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                            INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
                            INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id
                            INNER JOIN b_ms_tindakan ON b_ms_tindakan_kelas.ms_tindakan_id = b_ms_tindakan.id
                            WHERE $fUnit AND b_ms_tindakan.id = '".$rw['tindakan_id']."' AND b_pelayanan.unit_id_asal = '71' $waktu $fKso";
                            $s9 = mysql_query($q9);
                            $w9 = mysql_fetch_array($s9);
                            
                            $q10 = "SELECT COUNT(b_tindakan.pelayanan_id) AS jml
                            FROM b_kunjungan
                            INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                            INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
                            INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id
                            INNER JOIN b_ms_tindakan ON b_ms_tindakan_kelas.ms_tindakan_id = b_ms_tindakan.id
                            WHERE $fUnit AND b_ms_tindakan.id = '".$rw['tindakan_id']."' AND b_pelayanan.unit_id_asal = '73' $waktu $fKso";
                            $s10 = mysql_query($q10);
                            $w10 = mysql_fetch_array($s10);
                            
                            $q11 = "SELECT COUNT(b_tindakan.pelayanan_id) AS jml
                            FROM b_kunjungan
                            INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                            INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
                            INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id
                            INNER JOIN b_ms_tindakan ON b_ms_tindakan_kelas.ms_tindakan_id = b_ms_tindakan.id
                            WHERE $fUnit AND b_ms_tindakan.id = '".$rw['tindakan_id']."' AND (b_pelayanan.unit_id_asal = '33' OR b_pelayanan.unit_id_asal = '34' OR b_pelayanan.unit_id_asal = '36' OR b_pelayanan.unit_id_asal = '70' OR b_pelayanan.unit_id_asal = '35') $waktu $fKso";
                            $s11 = mysql_query($q11);
                            $w11 = mysql_fetch_array($s11);
                            
                            mysql_free_result($s1);
                            mysql_free_result($s2);
                            mysql_free_result($s3);
                            mysql_free_result($s4);
                            mysql_free_result($s5);
                            mysql_free_result($s6);
                            mysql_free_result($s7);
                            mysql_free_result($s8);
                            mysql_free_result($s9);
                            mysql_free_result($s10);
                            mysql_free_result($s11);
		?>
                <tr>
                    <td width="20%" style="padding-left:5px; border-left:1px solid; border-bottom:1px solid; border-right:1px solid; text-transform:uppercase;"><?php echo $no;?>&nbsp;&nbsp;&nbsp;<?php echo $rw['tindakan']?></td>
                    <td width="7%" style="border-bottom:1px solid; border-right:1px solid; text-align:center"><?php echo $w1['jml']?></td>
                    <td width="7%" style="border-bottom:1px solid; border-right:1px solid; text-align:center"><?php echo $w2['jml']?></td>
                    <td width="7%" style="border-bottom:1px solid; border-right:1px solid; text-align:center"><?php echo $w3['jml']?></td>
                    <td width="7%" style="border-bottom:1px solid; border-right:1px solid; text-align:center"><?php echo $w4['jml']?></td>
                    <td width="7%" style="border-bottom:1px solid; border-right:1px solid; text-align:center"><?php echo $w5['jml']?></td>
                    <td width="7%" style="border-bottom:1px solid; border-right:1px solid; text-align:center"><?php echo $w6['jml']?></td>
                    <td width="7%" style="border-bottom:1px solid; border-right:1px solid; text-align:center"><?php echo $w7['jml']?></td>
                    <td width="7%" style="border-bottom:1px solid; border-right:1px solid; text-align:center"><?php echo $w8['jml']?></td>
                    <td width="7%" style="border-bottom:1px solid; border-right:1px solid; text-align:center"><?php echo $w9['jml']?></td>
                    <td width="7%" style="border-bottom:1px solid; border-right:1px solid; text-align:center"><?php echo $w10['jml']?></td>
                    <td width="7%" style="border-bottom:1px solid; border-right:1px solid; text-align:center"><?php echo $w11['jml']?></td>
                    <?php $jml = $w1['jml'] + $w2['jml'] + $w3['jml'] + $w4['jml'] + $w5['jml'] + $w6['jml'] + $w7['jml'] + $w8['jml'] + $w9['jml'] + $w10['jml'] + $w11['jml'];?>
                    <td width="3%" style="border-bottom:1px solid; border-right:1px solid; text-align:center"><?php echo $jml;?></td>
                </tr>
                <?php 
                        $no++;
                        $tw1 = $tw1 + $w1['jml'];
                        $tw2 = $tw2 + $w2['jml'];
                        $tw3 = $tw3 + $w3['jml'];
                        $tw4 = $tw4 + $w4['jml'];
                        $tw5 = $tw5 + $w5['jml'];
                        $tw6 = $tw6 + $w6['jml'];
                        $tw7 = $tw7 + $w7['jml'];
                        $tw8 = $tw8 + $w8['jml'];
                        $tw9 = $tw9 + $w9['jml'];
                        $tw10 = $tw10 + $w10['jml'];
                        $tw11 = $tw11 + $w11['jml'];
                        $total = $total + $jml;
                        }mysql_free_result($rs);
                ?>
                <tr style="font-weight:bold;">
                    <td style="padding-left:5px; border-left:1px solid; border-bottom:1px solid; border-right:1px solid;">&nbsp;TOTAL</td>
                    <td style="border-bottom:1px solid; border-right:1px solid; text-align:center">&nbsp;<?php echo $tw1;?></td>
                    <td style="border-bottom:1px solid; border-right:1px solid; text-align:center">&nbsp;<?php echo $tw2;?></td>
                    <td style="border-bottom:1px solid; border-right:1px solid; text-align:center">&nbsp;<?php echo $tw3;?></td>
                    <td style="border-bottom:1px solid; border-right:1px solid; text-align:center">&nbsp;<?php echo $tw4;?></td>
                    <td style="border-bottom:1px solid; border-right:1px solid; text-align:center">&nbsp;<?php echo $tw5;?></td>
                    <td style="border-bottom:1px solid; border-right:1px solid; text-align:center">&nbsp;<?php echo $tw6;?></td>
                    <td style="border-bottom:1px solid; border-right:1px solid; text-align:center">&nbsp;<?php echo $tw7;?></td>
                    <td style="border-bottom:1px solid; border-right:1px solid; text-align:center">&nbsp;<?php echo $tw8;?></td>
                    <td style="border-bottom:1px solid; border-right:1px solid; text-align:center">&nbsp;<?php echo $tw9;?></td>
                    <td style="border-bottom:1px solid; border-right:1px solid; text-align:center">&nbsp;<?php echo $tw10;?></td>
                    <td style="border-bottom:1px solid; border-right:1px solid; text-align:center">&nbsp;<?php echo $tw11;?></td>
                    <td style="border-bottom:1px solid; border-right:1px solid; text-align:center">&nbsp;<?php echo $total;?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td style="text-align:right; height:70" valign="top">Tgl Cetak:&nbsp;<?php echo $date_now.'&nbsp;Jam:&nbsp;'.$jam;?>&nbsp;<br>Yang Mencetak,</td>
    </tr>
    <tr>
        <td style="text-align:right; font-weight:bold;"><?php echo $rwPeg['nama']?>&nbsp;</td>
    </tr>
    <tr id="trTombol">
        <td class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
    </tr>
</table>
<?php
	mysql_free_result($rsUnit1);
	mysql_free_result($rsUnit2);
	mysql_free_result($rsKso);
	mysql_free_result($rsPeg);
	mysql_close($konek);
?>
<script type="text/JavaScript">
function cetak(tombol){
	tombol.style.visibility='hidden';
	if(tombol.style.visibility=='hidden'){
		window.print();
		window.close();
	}
}
</script>