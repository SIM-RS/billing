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
		<td height="30" style="font-weight:bold; padding-left:10px;">Tempat Layanan Asal Rawat Jalan</td>
	</tr>
    <tr>
        <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                <tr style="font-weight:bold; text-align:center">
		    <td width="250" style="text-align:center; border-bottom:1px solid; border-top:1px solid; border-left:1px solid; border-right:1px solid;">Pemeriksaan / Tindakan</td>
		    <?php
                        $fKso = " AND b_kunjungan.kso_id = '".$stsPas."'";
                        $fUnit = " b_pelayanan.unit_id = '".$tmpLay."'";
			$qInap = "SELECT b_ms_unit.id, b_ms_unit.nama FROM b_kunjungan
				INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
				INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
				INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id_asal
				INNER JOIN b_ms_unit u ON u.id = b_pelayanan.unit_id
				WHERE $fUnit $waktu $fKso AND b_ms_unit.inap = '0'
				AND b_ms_unit.islast = '1'
				AND (b_ms_unit.parent_id <> 76 AND b_ms_unit.parent_id <> 80)
				GROUP BY b_ms_unit.id";
			$sInap = mysql_query($qInap);
			$col = 0;
			while($wInap = mysql_fetch_array($sInap))
			{
			$col++;
		    ?>
                    <td width="80" style="border-bottom:1px solid; border-right:1px solid; border-top:1px solid;"><?php echo $wInap['nama'];?></td>
		    <?php } ?>
		    <td width="50" style="text-align:center; font-size:14px; border-bottom:1px solid; border-top:1px solid; border-right:1px solid;">&sum;</td>
                </tr>
                <?php
                        $sql = "SELECT b_kunjungan.id AS kunjungan_id, 
                                b_pelayanan.id AS pelayanan_id,
                                b_ms_tindakan.id AS tindakan_id, b_ms_tindakan.nama AS tindakan 
                                FROM b_kunjungan
                                INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                                INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
                                INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id
                                INNER JOIN b_ms_tindakan ON b_ms_tindakan_kelas.ms_tindakan_id = b_ms_tindakan.id
                                INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id_asal
                                WHERE $fUnit $fKso $waktu AND b_ms_unit.inap = '0'
				GROUP BY b_ms_tindakan.id ORDER BY b_ms_tindakan.nama";
                        $rs = mysql_query($sql);
                        $no = 1;
                        $ttlTot = 0;
                        while($rw = mysql_fetch_array($rs))
                        {$tot=0;
		?>
                <tr>
                    <td style="padding-left:5px; border-left:1px solid; border-bottom:1px solid; border-right:1px solid; text-transform:uppercase;"><?php echo $no;?>&nbsp;&nbsp;&nbsp;<?php echo $rw['tindakan']?></td>
		    <?php
			$sInap = mysql_query($qInap);
			$j = 0;
			while($wInap = mysql_fetch_array($sInap)){
			    $q1 = "SELECT COUNT(b_tindakan.pelayanan_id) AS jml
				    FROM b_kunjungan
				    INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
				    INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id
				    INNER JOIN b_ms_tindakan_kelas ON b_ms_tindakan_kelas.id = b_tindakan.ms_tindakan_kelas_id
				    INNER JOIN b_ms_tindakan ON b_ms_tindakan_kelas.ms_tindakan_id = b_ms_tindakan.id
				    WHERE $fUnit AND b_ms_tindakan.id = '".$rw['tindakan_id']."' AND b_pelayanan.unit_id_asal = '".$wInap['id']."' $waktu $fKso";
				    $s1 = mysql_query($q1);
				    $w1 = mysql_fetch_array($s1);
				    $tot = $tot+$w1['jml'];
				    $jml[$j] += $w1['jml'];
				    $j++;   
                    ?>
                    <td style="border-bottom:1px solid; border-right:1px solid; text-align:center"><?php echo $w1['jml']?></td>
		    <?php
			    }mysql_free_result($sInap);
			    $ttlTot += $tot;
		    ?>
		    <td style="border-bottom:1px solid; border-right:1px solid; text-align:center">&nbsp;<?php echo $tot;?></td>
                </tr>
                <?php 
                        $no++;
                        }mysql_free_result($rs);
                ?>
                <tr style="font-weight:bold;">
                    <td style="padding-left:5px; border-left:1px solid; border-bottom:1px solid; border-right:1px solid;">&nbsp;TOTAL</td>
		    <?php
			for($i=0; $i<$col; $i++){
		    ?>
                    <td style="border-bottom:1px solid; border-right:1px solid; text-align:center">&nbsp;<?php echo $jml[$i]?></td>
		    <?php
			    }
		    ?>
                    <td style="border-bottom:1px solid; border-right:1px solid; text-align:center">&nbsp;<?php echo $ttlTot;?></td>
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