<?
include("../../sesi.php");
?>
<title>Rekapitulasi Register Pasien</title>
<body style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">

<?php
    include ("../../koneksi/konek.php");
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
        
    $sqlUnit1 = "SELECT id,nama,kode FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayananJln']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	
	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayananBukanInap']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
        
    $unit = "b_pelayanan.unit_id = '".$rwUnit2['id']."' " ;
	
	$sqlKso = "SELECT id,nama from b_ms_kso where id = '".$_REQUEST['StatusPas']."'";
	$rsKso = mysql_query($sqlKso);
	$rwKso = mysql_fetch_array($rsKso);
	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);

?>
<style>
    .kiri
    {
        border-left:1px solid;
        border-bottom:1px solid;
    }
    .kanan
    {
        border-left:1px solid;
        border-bottom:1px solid;
        border-right:1px solid;
        text-align:right;
		padding-right:40px;
    }
</style>
<?php
        
?>
<table border="0" cellpadding="0" cellspacing="0" width="750" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
    <tr>
        <td align="center" colspan="7" style="text-transform:uppercase; font-weight:bold; font-size:14px" height="70" valign="top">rekapitulasi register pasien rawat jalan<br>POLI : <?php echo $rwUnit2['nama']; ?>&nbsp;&nbsp;&nbsp;<?php echo $Periode;?><br><?=$namaRS?></td>
    </tr>
    <tr>
        <td colspan="2" style="border-bottom:2px solid;"><b>(<?php echo $_REQUEST['cmbWaktu'];?>)</b></td>
        <td colspan="5" style="border-bottom:2px solid;">&nbsp;</td>
    </tr>
    <tr><td colspan="7">&nbsp;</td></tr>
    <tr style="font-weight:bold;">
        <td width="5%" align="center" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid;">NO</td>
        <td width="25%" align="center" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid;">URAIAN</td>
        <td width="15%" align="center" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">JUMLAH</td>
        <td width="10%">&nbsp;</td>
        <td width="5%" align="center" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid;">NO</td>
        <td width="25%" align="center" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid;">URAIAN</td>
        <td width="15%" align="center" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">JUMLAH</td>
    </tr>
    <tr>
        <td class="kiri">&nbsp;1</td>
        <td class="kiri">&nbsp;Jumlah Pasien</td>
        <?php
           $q1 = "SELECT COUNT(id) AS jml 
				FROM (SELECT b_kunjungan.id 
				FROM b_kunjungan 
				INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id 
				WHERE $unit $waktu) AS q1";
            $rs1 = mysql_query($q1);
            $rw1 = mysql_fetch_array($rs1);
			$totJumPas = $rw1['jml'];
      		mysql_free_result($rs1);
        ?>
        <td class="kanan">&nbsp;<?php if($rw1['jml']==0) echo ""; else echo $rw1['jml'];?></td>
        <td>&nbsp;</td>
        <td class="kiri">&nbsp;5</td>
        <td class="kiri">&nbsp;Jenis Kasus</td>
        <td class="kanan">&nbsp;</td>
    </tr>
    <tr>
        <td class="kiri">&nbsp;2</td>
        <td class="kiri">&nbsp;Cara Kunjungan</td>
        <td class="kanan">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="kiri">&nbsp;5.1</td>
        <td class="kiri">&nbsp;Baru</td>
        <?php
            $q51 = "SELECT COUNT(pasien_id) AS jml FROM (SELECT b_kunjungan.id AS pasien_id
                    FROM b_kunjungan
                    INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                    INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id = b_pelayanan.id
                    WHERE b_pasien_keluar.kasus = '1' 
                    AND $unit $waktu GROUP BY b_pasien_keluar.id) AS jml";
            $rs51 = mysql_query($q51);
            $rw51 = mysql_fetch_array($rs51);
      		mysql_free_result($rs51);
        ?>
        <td class="kanan">&nbsp;<?php if($rw51['jml']==0) echo ""; else echo $rw51['jml'];?></td>
    </tr>
    <tr>
        <td class="kiri">&nbsp;2.1</td>
        <td class="kiri">&nbsp;Kunjungan Baru</td>
        <?php
            $q21 = "SELECT COUNT(b_kunjungan.id) AS jml FROM b_kunjungan
					INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
					INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id_asal
					WHERE b_kunjungan.isbaru = '1' AND $unit $waktu AND b_ms_unit.parent_id = '76'";
            $rs21 = mysql_query($q21);
            $rw21 = mysql_fetch_array($rs21);
      		mysql_free_result($rs21);
        ?>
        <td class="kanan">&nbsp;<?php if($rw21['jml']==0) echo ""; else echo $rw21['jml'];?></td>
        <td>&nbsp;</td>
        <td class="kiri">&nbsp;5.2</td>
        <td class="kiri">&nbsp;Lama</td>
        <?php
            $q52 = "SELECT COUNT(pasien_id) AS jml FROM (SELECT b_kunjungan.id AS pasien_id
                    FROM b_kunjungan
                    INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                    INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id = b_pelayanan.id
                    WHERE b_pasien_keluar.kasus = '0' 
                    AND $unit $waktu GROUP BY b_pasien_keluar.id) AS jml";
            $rs52 = mysql_query($q52);
            $rw52 = mysql_fetch_array($rs52);
      		mysql_free_result($rs52);
        ?>
        <td class="kanan">&nbsp;<?php if($rw52['jml']==0) echo ""; else echo $rw52['jml'];?></td>
    </tr>
    <tr>
        <td class="kiri">&nbsp;2.2</td>
        <td class="kiri">&nbsp;Kunjungan Ulang</td>
        <?php
            $q22 = "SELECT COUNT(b_kunjungan.id) AS jml FROM b_kunjungan
					INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
					INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id_asal
					WHERE b_kunjungan.isbaru = '0' AND $unit $waktu AND b_ms_unit.parent_id = '76'";
            $rs22 = mysql_query($q22);
            $rw22 = mysql_fetch_array($rs22);
      		mysql_free_result($rs22);
        ?>
        <td class="kanan">&nbsp;<?php if($rw22['jml']==0) echo ""; else echo $rw22['jml'];?></td>
        <td>&nbsp;</td>
        <td class="kiri" rowspan="2">&nbsp;6</td>
        <td class="kiri" rowspan="2">&nbsp;Cara Pembayaran/<br>&nbsp;Kelompok Pasien</td>
        <td class="kanan" rowspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td class="kiri">&nbsp;2.3</td>
        <td class="kiri">&nbsp;Kunj Konsultasi</td>
        <td class="kanan">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="kiri" rowspan="2">&nbsp;</td>
        <td class="kiri">&nbsp;1. Antar Poliklinik</td>
        <?php
            $q231 = "SELECT COUNT(b_kunjungan.id) AS jml FROM b_kunjungan
					INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
					INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id_asal
					WHERE $unit $waktu AND b_ms_unit.inap = '0' AND b_ms_unit.parent_id <> '76'";
            $rs231 = mysql_query($q231);
            $rw231 = mysql_fetch_array($rs231);
      		mysql_free_result($rs231);
        ?>
        <td class="kanan">&nbsp;<?php if($rw231['jml']==0) echo ""; else echo $rw231['jml'];?></td>
        <td>&nbsp;</td>
        <td class="kiri">&nbsp;6.1</td>
        <td class="kiri">&nbsp;Umum</td>
        <?php
            $q61 = "SELECT COUNT(pasien_id) AS jml FROM (SELECT b_kunjungan.id AS pasien_id
                    FROM b_kunjungan
                    INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                    WHERE b_pelayanan.kso_id = '1'
                    AND $unit $waktu) AS jml ";
            $rs61 = mysql_query($q61);
            $rw61 = mysql_fetch_array($rs61);
      		mysql_free_result($rs61);
        ?>
        <td class="kanan">&nbsp;<?php if($rw61['jml']==0) echo ""; else echo $rw61['jml'];?></td>
    </tr>
    <tr>
        <td class="kiri">&nbsp;2. Dari Rawat Inap</td>
        <?php
            $q232 = "SELECT COUNT(b_kunjungan.id) AS jml FROM b_kunjungan
					INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
					INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id_asal
					WHERE b_ms_unit.inap = '1' AND $unit $waktu";
            $rs232 = mysql_query($q232);
            $rw232 = mysql_fetch_array($rs232);
      		mysql_free_result($rs232);
        ?>
        <td class="kanan">&nbsp;<?php if($rw232['jml']==0) echo ""; else echo $rw232['jml'];?></td>
        <td>&nbsp;</td>
        <td class="kiri">&nbsp;6.2</td>
        <td class="kiri">&nbsp;Askes</td>
        <td class="kanan">&nbsp;</td>
    </tr>
    <tr>
        <td class="kiri">&nbsp;3</td>
        <td class="kiri">&nbsp;Asal Pasien</td>
        <td class="kanan">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="kiri" rowspan="2">&nbsp;</td>
        <td class="kiri">&nbsp;1. Askes Sosial/PNS</td>
        <?php
            $q621 = "SELECT COUNT(pasien_id) AS jml FROM (SELECT b_kunjungan.id AS pasien_id
                    FROM b_kunjungan
                    INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                    WHERE b_pelayanan.kso_id = '4'
                    AND $unit $waktu) AS jml";
            $rs621 = mysql_query($q621);
            $rw621 = mysql_fetch_array($rs621);
      		mysql_free_result($rs621);
        ?>
        <td class="kanan">&nbsp;<?php if($rw621['jml']==0) echo ""; else echo $rw621['jml'];?></td>
    </tr>
    <tr>
        <td class="kiri">&nbsp;3.1</td>
        <td class="kiri">&nbsp;Bidan</td>
        <?php
            $q31 = "SELECT COUNT(b_kunjungan.id) AS jml, b_kunjungan.asal_kunjungan, 
					b_ms_asal_rujukan.nama 
					FROM b_kunjungan
					INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
					INNER JOIN b_ms_asal_rujukan ON b_ms_asal_rujukan.id = b_kunjungan.asal_kunjungan
					WHERE b_ms_asal_rujukan.id = '1' AND $unit $waktu
					GROUP BY b_kunjungan.asal_kunjungan";
            $rs31 = mysql_query($q31);
            $rw31 = mysql_fetch_array($rs31);
      		mysql_free_result($rs31);
        ?>
        <td class="kanan">&nbsp;<?php if($rw31['jml']==0) echo ""; else echo $rw31['jml'];?></td>
        <td>&nbsp;</td>
        <td class="kiri">&nbsp;2. Askes Komersial/Swasta</td>
        <?php
            $q622 = "SELECT COUNT(pasien_id) AS jml FROM (SELECT b_kunjungan.id AS pasien_id
                    FROM b_kunjungan
                    INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                    WHERE b_pelayanan.kso_id = '6'
                    AND $unit $waktu) AS jml";
            $rs622 = mysql_query($q622);
            $rw622 = mysql_fetch_array($rs622);
      		mysql_free_result($rs622);
        ?>
        <td class="kanan">&nbsp;<?php if($rw622['jml']==0) echo ""; else echo $rw622['jml'];?></td>
    </tr>
    <tr>
        <td class="kiri">&nbsp;3.2</td>
        <td class="kiri">&nbsp;BP Jamsostek</td>
        <?php
            $q32 = "SELECT COUNT(b_kunjungan.id) AS jml, b_kunjungan.asal_kunjungan, 
					b_ms_asal_rujukan.nama 
					FROM b_kunjungan
					INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
					INNER JOIN b_ms_asal_rujukan ON b_ms_asal_rujukan.id = b_kunjungan.asal_kunjungan
					WHERE b_ms_asal_rujukan.id = '2' AND $unit $waktu
					GROUP BY b_kunjungan.asal_kunjungan";
            $rs32 = mysql_query($q32);
            $rw32 = mysql_fetch_array($rs32);
      		mysql_free_result($rs32);
        ?>
        <td class="kanan">&nbsp;<?php if($rw32['jml']==0) echo ""; else echo $rw32['jml'];?></td>
        <td>&nbsp;</td>
        <td class="kiri">&nbsp;6.3</td>
        <td class="kiri">&nbsp;Jamkesmas</td>
        <?php
            $q623 = "SELECT COUNT(pasien_id) AS jml FROM (SELECT b_kunjungan.id AS pasien_id
                    FROM b_kunjungan
                    INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                    WHERE b_pelayanan.kso_id = '38' AND $unit $waktu) AS jml";
            $rs623 = mysql_query($q623);
            $rw623 = mysql_fetch_array($rs623);
      		mysql_free_result($rs623);
        ?>
        <td class="kanan">&nbsp;</td>
    </tr>
    <tr>
      <td class="kiri">&nbsp;3.3</td>
        <td class="kiri">&nbsp;Datang Sendiri</td>
        <?php
            $q33 = "SELECT COUNT(b_kunjungan.id) AS jml, b_kunjungan.asal_kunjungan, 
					b_ms_asal_rujukan.nama 
					FROM b_kunjungan
					INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
					INNER JOIN b_ms_asal_rujukan ON b_ms_asal_rujukan.id = b_kunjungan.asal_kunjungan
					WHERE b_ms_asal_rujukan.id = '3' AND $unit $waktu
					GROUP BY b_kunjungan.asal_kunjungan";
            $rs33 = mysql_query($q33);
            $rw33 = mysql_fetch_array($rs33);
      		mysql_free_result($rs33);
        ?>
        <td class="kanan">&nbsp;<?php if($rw33['jml']==0) echo ""; else echo $rw33['jml'];?></td>
      <td>&nbsp;</td>
      <td class="kiri">&nbsp;</td>
      <td class="kiri">&nbsp;1. Jamkesmas DB</td>
      <td class="kanan">&nbsp;
          <?php if($rw623['jml']==0) echo ""; else echo $rw623['jml'];?></td>
      <?php
            $q624 = "SELECT COUNT(pasien_id) AS jml FROM (SELECT b_kunjungan.id AS pasien_id
                    FROM b_kunjungan
                    INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                    WHERE b_pelayanan.kso_id = '46' AND $unit $waktu) AS jml";
            $rs624 = mysql_query($q624);
            $rw624 = mysql_fetch_array($rs624);
      		mysql_free_result($rs624);
        ?>
    </tr>
    <tr>
        <td class="kiri">&nbsp;3.4</td>
        <td class="kiri">&nbsp;Dokter Perusahaan</td>
        <?php
            $q34 = "SELECT COUNT(b_kunjungan.id) AS jml, b_kunjungan.asal_kunjungan, 
					b_ms_asal_rujukan.nama 
					FROM b_kunjungan
					INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
					INNER JOIN b_ms_asal_rujukan ON b_ms_asal_rujukan.id = b_kunjungan.asal_kunjungan
					WHERE b_ms_asal_rujukan.id = '4' AND $unit $waktu
					GROUP BY b_kunjungan.asal_kunjungan";
            $rs34 = mysql_query($q34);
            $rw34 = mysql_fetch_array($rs34);
      		mysql_free_result($rs34);
        ?>
        <td class="kanan">&nbsp;<?php if($rw34['jml']==0) echo ""; else echo $rw34['jml'];?></td>
      <td>&nbsp;</td>
      <td class="kiri">&nbsp;</td>
      <td class="kiri">&nbsp;2. Jamkesmas Non DB (JAMKESDA)</td>
      <td class="kanan">&nbsp;
          <?php if($rw624['jml']==0) echo ""; else echo $rw624['jml'];?></td>
      <?php
            $q625 = "SELECT COUNT(pasien_id) AS jml FROM (SELECT b_kunjungan.id AS pasien_id
                    FROM b_kunjungan
                    INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                    WHERE b_pelayanan.kso_id = '39' AND $unit $waktu) AS jml";
            $rs625 = mysql_query($q625);
            $rw625 = mysql_fetch_array($rs625);
      		mysql_free_result($rs625);
        ?>
    </tr>
    <tr>
        <td class="kiri">&nbsp;3.5</td>
        <td class="kiri">&nbsp;Dokter RS</td>
        <?php
            $q35 = "SELECT COUNT(b_kunjungan.id) AS jml, b_kunjungan.asal_kunjungan, 
					b_ms_asal_rujukan.nama 
					FROM b_kunjungan
					INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
					INNER JOIN b_ms_asal_rujukan ON b_ms_asal_rujukan.id = b_kunjungan.asal_kunjungan
					WHERE b_ms_asal_rujukan.id = '5' AND $unit $waktu
					GROUP BY b_kunjungan.asal_kunjungan";
            $rs35 = mysql_query($q35);
            $rw35 = mysql_fetch_array($rs35);
      		mysql_free_result($rs35);
        ?>
        <td class="kanan">&nbsp;<?php if($rw35['jml']==0) echo ""; else echo $rw35['jml'];?></td>
        <td>&nbsp;</td>
        <td class="kiri">&nbsp;</td>
        <td class="kiri">&nbsp;3. Jamkesmas Non DB (SKTM)</td>
        <td class="kanan">&nbsp;
            <?php if($rw625['jml']==0) echo ""; else echo $rw625['jml'];?></td>
      <?php
            $q626 = "SELECT COUNT(pasien_id) AS jml FROM (SELECT b_kunjungan.id AS pasien_id
                    FROM b_kunjungan
                    INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                    WHERE b_pelayanan.kso_id = '53' AND $unit $waktu) AS jml";
            $rs626 = mysql_query($q626);
            $rw626 = mysql_fetch_array($rs626);
      		mysql_free_result($rs626);
        ?>
    </tr>
    <tr>
        <td class="kiri">&nbsp;3.6</td>
        <td class="kiri">&nbsp;Dokter Swasta</td>
        <?php
            $q36 = "SELECT COUNT(b_kunjungan.id) AS jml, b_kunjungan.asal_kunjungan, 
					b_ms_asal_rujukan.nama 
					FROM b_kunjungan
					INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
					INNER JOIN b_ms_asal_rujukan ON b_ms_asal_rujukan.id = b_kunjungan.asal_kunjungan
					WHERE b_ms_asal_rujukan.id = '6' AND $unit $waktu
					GROUP BY b_kunjungan.asal_kunjungan";
            $rs36 = mysql_query($q36);
            $rw36 = mysql_fetch_array($rs36);
      		mysql_free_result($rs36);
        ?>
        <td class="kanan">&nbsp;<?php if($rw36['jml']==0) echo ""; else echo $rw36['jml'];?></td>
        <td>&nbsp;</td><td class="kiri">&nbsp;</td>
        <td class="kiri">&nbsp;4. Jamkesmas Non DB (Jampersal)</td>
        <td class="kanan">&nbsp;
            <?php if($rw626['jml']==0) echo ""; else echo $rw626['jml'];?></td>
        <?php
            $q631 = "SELECT COUNT(pasien_id) AS jml FROM (SELECT b_kunjungan.id AS pasien_id
                    FROM b_kunjungan
                    INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                    WHERE b_pelayanan.kso_id = '2'
                    AND $unit $waktu) AS jml";
            $rs631 = mysql_query($q631);
            $rw631 = mysql_fetch_array($rs631);
      		mysql_free_result($rs631);
        ?>
    </tr>
    
    <tr>
        <td class="kiri">&nbsp;</td>
        <td class="kiri">&nbsp;</td>
        
        <td class="kanan">&nbsp;</td>
        <td>&nbsp;</td><td class="kiri">&nbsp;</td>
        <td class="kiri">&nbsp;5. Jamkesmas Non DB (Pasuruan)</td>
        <td class="kanan">&nbsp;
        <?php
            $q635 = "SELECT COUNT(pasien_id) AS jml FROM (SELECT b_kunjungan.id AS pasien_id
                    FROM b_kunjungan
                    INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                    WHERE b_pelayanan.kso_id = '64'
                    AND $unit $waktu) AS jml";
            $rs635 = mysql_query($q635);
            $rw635 = mysql_fetch_array($rs635);
      		mysql_free_result($rs635);
        ?>
            <?php if($rw635['jml']==0) echo ""; else echo $rw635['jml'];?></td>
        
    </tr>
    
    <tr>
        <td class="kiri">&nbsp;3.7</td>
        <td class="kiri">&nbsp;IGD RS</td>
        <?php
            $q37 = "SELECT COUNT(b_kunjungan.id) AS jml, b_kunjungan.asal_kunjungan, 
					b_ms_asal_rujukan.nama 
					FROM b_kunjungan
					INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
					INNER JOIN b_ms_asal_rujukan ON b_ms_asal_rujukan.id = b_kunjungan.asal_kunjungan
					WHERE b_ms_asal_rujukan.id = '7' AND $unit $waktu
					GROUP BY b_kunjungan.asal_kunjungan";
            $rs37 = mysql_query($q37);
            $rw37 = mysql_fetch_array($rs37);
      		mysql_free_result($rs37);
        ?>
        <td class="kanan">&nbsp;<?php if($rw37['jml']==0) echo ""; else echo $rw37['jml'];?></td>
        <td>&nbsp;</td>
        <td class="kiri">&nbsp;6.4</td>
        <td class="kiri">&nbsp;PT Jamsostek</td>
        <td class="kanan">&nbsp;</td>
        <?php
            $q632 = "SELECT COUNT(pasien_id) AS jml FROM (SELECT b_kunjungan.id AS pasien_id
                    FROM b_kunjungan
                    INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                    WHERE b_pelayanan.kso_id = '16'
                    AND $unit $waktu) AS jml";
            $rs632 = mysql_query($q632);
            $rw632 = mysql_fetch_array($rs632);
      		mysql_free_result($rs632);
        ?>
    </tr>
    <tr>
        <td class="kiri">&nbsp;3.8</td>
        <td class="kiri">&nbsp;Kamar Bersalin</td>
        <?php
            $q38 = "SELECT COUNT(b_kunjungan.id) AS jml, b_kunjungan.asal_kunjungan, 
					b_ms_asal_rujukan.nama 
					FROM b_kunjungan
					INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
					INNER JOIN b_ms_asal_rujukan ON b_ms_asal_rujukan.id = b_kunjungan.asal_kunjungan
					WHERE b_ms_asal_rujukan.id = '8' AND $unit $waktu
					GROUP BY b_kunjungan.asal_kunjungan";
            $rs38 = mysql_query($q38);
            $rw38 = mysql_fetch_array($rs38);
      		mysql_free_result($rs38);
        ?>
        <td class="kanan">&nbsp;<?php if($rw38['jml']==0) echo ""; else echo $rw38['jml'];?></td>
        <td>&nbsp;</td>
        <td class="kiri">&nbsp;</td>
        <td class="kiri">&nbsp;1. JPKM</td>
        <td class="kanan">&nbsp;
            <?php if($rw631['jml']==0) echo ""; else echo $rw631['jml'];?></td>
        <?php
            $q633 = "SELECT COUNT(pasien_id) AS jml FROM (SELECT b_kunjungan.id AS pasien_id
                    FROM b_kunjungan
                    INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
                    WHERE b_pelayanan.kso_id = '34'
                    AND $unit $waktu) AS jml";
            $rs633 = mysql_query($q633);
            $rw633 = mysql_fetch_array($rs633);
      		mysql_free_result($rs633);
        ?>
    </tr>
    <tr>
        <td class="kiri">&nbsp;3.9</td>
        <td class="kiri">&nbsp;Kepolisian RI</td>
        <?php
            $q39 = "SELECT COUNT(b_kunjungan.id) AS jml, b_kunjungan.asal_kunjungan, 
					b_ms_asal_rujukan.nama 
					FROM b_kunjungan
					INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
					INNER JOIN b_ms_asal_rujukan ON b_ms_asal_rujukan.id = b_kunjungan.asal_kunjungan
					WHERE b_ms_asal_rujukan.id = '9' AND $unit $waktu
					GROUP BY b_kunjungan.asal_kunjungan";
            $rs39 = mysql_query($q39);
            $rw39 = mysql_fetch_array($rs39);
      		mysql_free_result($rs39);
        ?>
        <td class="kanan">&nbsp;<?php if($rw39['jml']==0) echo ""; else echo $rw39['jml'];?></td>
        <td>&nbsp;</td>
        <td class="kiri">&nbsp;</td>
        <td class="kiri">&nbsp;2. Trauma Centre/JKK</td>
        <td class="kanan">&nbsp;
            <?php if($rw632['jml']==0) echo ""; else echo $rw632['jml'];?></td>
    </tr>
    <tr>
        <td class="kiri">&nbsp;3.10</td>
        <td class="kiri">&nbsp;Poli RS</td>
        <?php
            $q310 = "SELECT COUNT(b_kunjungan.id) AS jml, b_kunjungan.asal_kunjungan, 
					b_ms_asal_rujukan.nama 
					FROM b_kunjungan
					INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
					INNER JOIN b_ms_asal_rujukan ON b_ms_asal_rujukan.id = b_kunjungan.asal_kunjungan
					WHERE b_ms_asal_rujukan.id = '10' AND $unit $waktu
					GROUP BY b_kunjungan.asal_kunjungan";
            $rs310 = mysql_query($q310);
            $rw310 = mysql_fetch_array($rs310);
      		mysql_free_result($rs310);
        ?>
        <td class="kanan">&nbsp;<?php if($rw310['jml']==0) echo ""; else echo $rw310['jml'];?></td>
        <td>&nbsp;</td>
        <td class="kiri">&nbsp;</td>
        <td class="kiri">&nbsp;3. Karyawan PT Jamsostek</td>
        <td class="kanan">&nbsp;
            <?php if($rw633['jml']==0) echo ""; else echo $rw633['jml'];?></td>
    </tr>
    
    <tr>
        <td class="kiri">&nbsp;3.11</td>
        <td class="kiri">&nbsp;Puskesmas</td>
        <?php
            $q311 = "SELECT COUNT(b_kunjungan.id) AS jml, b_kunjungan.asal_kunjungan, 
					b_ms_asal_rujukan.nama 
					FROM b_kunjungan
					INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
					INNER JOIN b_ms_asal_rujukan ON b_ms_asal_rujukan.id = b_kunjungan.asal_kunjungan
					WHERE b_ms_asal_rujukan.id = '11' AND $unit $waktu
					GROUP BY b_kunjungan.asal_kunjungan";
            $rs311 = mysql_query($q311);
            $rw311 = mysql_fetch_array($rs311);
      		mysql_free_result($rs311);
        ?>
        <td class="kanan">&nbsp;<?php if($rw311['jml']==0) echo ""; else echo $rw311['jml'];?></td>
        <td>&nbsp;</td>
        <td class="kiri">&nbsp;6.5</td>
        <td valign="top" class="kiri">&nbsp;KSO PT Lain</td>
        <td valign="top" class="kanan" id="totalKsoPT">&nbsp;</td>
    </tr>
    <tr>
        <td class="kiri">&nbsp;3.12</td>
        <td class="kiri">&nbsp;Rawat Inap</td>
        <?php
            $q312 = "SELECT COUNT(b_kunjungan.id) AS jml, b_kunjungan.asal_kunjungan, 
					b_ms_asal_rujukan.nama 
					FROM b_kunjungan
					INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
					INNER JOIN b_ms_asal_rujukan ON b_ms_asal_rujukan.id = b_kunjungan.asal_kunjungan
					WHERE b_ms_asal_rujukan.id = '12' AND $unit $waktu
					GROUP BY b_kunjungan.asal_kunjungan";
            $rs312 = mysql_query($q312);
            $rw312 = mysql_fetch_array($rs312);
      		mysql_free_result($rs312);
        ?>
        <td class="kanan">&nbsp;<?php if($rw312['jml']==0) echo ""; else echo $rw312['jml'];?></td>
        <td>&nbsp;</td>
        <td rowspan="11" class="kiri">&nbsp;</td>
        <td colspan="2" rowspan="11" valign="top" class="kiri" style="border-right:1px solid;">
        			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<?php
						$sql = "SELECT b_ms_kso.id, b_ms_kso.nama FROM b_pelayanan INNER JOIN b_ms_kso ON b_ms_kso.id = b_pelayanan.kso_id WHERE $unit $waktu AND (b_ms_kso.id <> 1 AND b_ms_kso.id <> 4 AND b_ms_kso.id <> 6 AND b_ms_kso.id <> 38 AND b_ms_kso.id <> 39 AND b_ms_kso.id <> 46 AND b_ms_kso.id <> 2 AND b_ms_kso.id <> 16 AND b_ms_kso.id <> 34 AND b_ms_kso.id <> 5 AND b_ms_kso.id <> 53 AND b_ms_kso.id <> 64) GROUP BY b_ms_kso.id";
						$rs = mysql_query($sql);
						$no = 1;
						$totKSOPT=0;
						while($rw = mysql_fetch_array($rs))
						{
							$sqlK = "SELECT COUNT(pasien_id) AS jml FROM (SELECT b_kunjungan.id AS pasien_id FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id WHERE b_pelayanan.kso_id = '".$rw['id']."' AND $unit $waktu) AS jml";
							$rsK = mysql_query($sqlK);
							$rwK = mysql_fetch_array($rsK);
							mysql_free_result($rsK);
				?>
				<tr>
					<td width="63%" style="border-bottom:1px solid; border-right:1px solid;">&nbsp;<?php echo $no.'.&nbsp;'.$rw['nama'];?></td>
					<td width="37%" style="border-bottom:1px solid; padding-right:40px; text-align:right">&nbsp;<?php echo $rwK['jml'];?></td>
				</tr>
				<?php 	
						$totKSOPT = $totKSOPT + $rwK['jml'];
						$no++;
						}	mysql_free_result($rs);
				?>
			</table>		</td>
    </tr>
    <tr>
        <td class="kiri">&nbsp;3.13</td>
        <td class="kiri">&nbsp;RS Lain</td>
        <?php
            $q313 = "SELECT COUNT(b_kunjungan.id) AS jml, b_kunjungan.asal_kunjungan, 
					b_ms_asal_rujukan.nama 
					FROM b_kunjungan
					INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
					INNER JOIN b_ms_asal_rujukan ON b_ms_asal_rujukan.id = b_kunjungan.asal_kunjungan
					WHERE b_ms_asal_rujukan.id = '13' AND $unit $waktu
					GROUP BY b_kunjungan.asal_kunjungan";
            $rs313 = mysql_query($q313);
            $rw313 = mysql_fetch_array($rs313);
      		mysql_free_result($rs313);
        ?>
        <td class="kanan">&nbsp;<?php if($rw313['jml']==0) echo ""; else echo $rw313['jml'];?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="kiri" rowspan="2" valign="top">&nbsp;4</td>
        <td class="kiri" rowspan="2">&nbsp;Keadaan Pasien Setelah<br>&nbsp;di Poliklinik/UGD
        <td class="kanan" rowspan="2" id="totPasPol">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <?php
	$totPasPol = 0;
	?>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="kiri">&nbsp;4.1</td>
        <td class="kiri">&nbsp;Dirawat</td>
        <?php
            $q41 = "SELECT COUNT(b_kunjungan.id) AS jml, b_ms_cara_keluar.nama
					FROM b_kunjungan
					INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
					INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id = b_pelayanan.id
					INNER JOIN b_ms_cara_keluar ON b_ms_cara_keluar.nama = b_pasien_keluar.cara_keluar
					WHERE b_ms_cara_keluar.id = '6' AND $unit $waktu";
            $rs41 = mysql_query($q41);
            $rw41 = mysql_fetch_array($rs41);
      		mysql_free_result($rs41);
			$totPasPol = $totPasPol + $rw41['jml'];
        ?>
        <td class="kanan">&nbsp;<?php if($rw41['jml']==0) echo ""; else echo $rw41['jml'];?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="kiri">&nbsp;4.2</td>
        <td class="kiri">&nbsp;Dirujuk</td>
        <?php
            $q42 = "SELECT COUNT(b_kunjungan.id) AS jml, b_ms_cara_keluar.nama
					FROM b_kunjungan
					INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
					INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id = b_pelayanan.id
					INNER JOIN b_ms_cara_keluar ON b_ms_cara_keluar.nama = b_pasien_keluar.cara_keluar
					WHERE b_ms_cara_keluar.id = '3' AND $unit $waktu";
            $rs42 = mysql_query($q42);
            $rw42 = mysql_fetch_array($rs42);
      		mysql_free_result($rs42);
			$totPasPol = $totPasPol + $rw42['jml'];
        ?>
        <td class="kanan">&nbsp;<?php if($rw42['jml']==0) echo ""; else echo $rw42['jml'];?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="kiri">&nbsp;4.3</td>
        <td class="kiri">&nbsp;Atas Permintaan Sendiri</td>
        <?php
            $q43 = "SELECT COUNT(b_kunjungan.id) AS jml, b_ms_cara_keluar.nama
					FROM b_kunjungan
					INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
					INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id = b_pelayanan.id
					INNER JOIN b_ms_cara_keluar ON b_ms_cara_keluar.nama = b_pasien_keluar.cara_keluar
					WHERE b_ms_cara_keluar.id = '1' AND $unit $waktu";
            $rs43 = mysql_query($q43);
            $rw43 = mysql_fetch_array($rs43);
      		mysql_free_result($rs43);
			$totPasPol = $totPasPol + $rw43['jml'];
        ?>
        <td class="kanan">&nbsp;<?php if($rw43['jml']==0) echo ""; else echo $rw43['jml'];?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="kiri">&nbsp;4.4</td>
        <td class="kiri">&nbsp;Pulang</td>
        <?php
            $q44 = "SELECT COUNT(b_kunjungan.id) AS jml, b_ms_cara_keluar.nama
					FROM b_kunjungan
					INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
					INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id = b_pelayanan.id
					INNER JOIN b_ms_cara_keluar ON b_ms_cara_keluar.nama = b_pasien_keluar.cara_keluar
					WHERE b_ms_cara_keluar.id = '2' AND $unit $waktu";
            $rs44 = mysql_query($q44);
            $rw44 = mysql_fetch_array($rs44);
      		mysql_free_result($rs44);
			$totPasPol = $totPasPol + $rw44['jml'];
        ?>
        <td class="kanan">&nbsp;<?php if($rw44['jml']==0) echo ""; else echo $rw44['jml'];?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="kiri">&nbsp;4.5</td>
        <td class="kiri">&nbsp;Mati di Poli/UGD</td>
        <?php
            $q45 = "SELECT COUNT(b_kunjungan.id) AS jml, b_ms_cara_keluar.nama
					FROM b_kunjungan
					INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
					INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id = b_pelayanan.id
					INNER JOIN b_ms_cara_keluar ON b_ms_cara_keluar.nama = b_pasien_keluar.cara_keluar
					WHERE b_ms_cara_keluar.id = '5' AND $unit $waktu";
            $rs45 = mysql_query($q45);
            $rw45 = mysql_fetch_array($rs45);
      		mysql_free_result($rs45);
			$totPasPol = $totPasPol + $rw45['jml'];
        ?>
        <td class="kanan">&nbsp;<?php if($rw45['jml']==0) echo ""; else echo $rw45['jml'];?></td>
        <td>&nbsp;</td>
        
        
    </tr>
    <tr>
        <td class="kiri">&nbsp;4.6</td>
        <td class="kiri">&nbsp;Melarikan Diri</td>
		<?php
            $q46 = "SELECT COUNT(b_kunjungan.id) AS jml, b_ms_cara_keluar.nama
					FROM b_kunjungan
					INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
					INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id = b_pelayanan.id
					INNER JOIN b_ms_cara_keluar ON b_ms_cara_keluar.nama = b_pasien_keluar.cara_keluar
					WHERE b_ms_cara_keluar.id = '4' AND $unit $waktu";
            $rs46 = mysql_query($q46);
            $rw46 = mysql_fetch_array($rs46);
      		mysql_free_result($rs46);
			$totPasPol = $totPasPol + $rw46['jml'];
        ?>
        <td class="kanan">&nbsp;<?php if($rw46['jml']==0) echo ""; else echo $rw46['jml'];?></td>
        <td>&nbsp;</td>
    </tr>
    
    <tr>
        <td class="kiri">&nbsp;4.7</td>
        <td class="kiri">&nbsp;Pasien tidak berkunjung ke Poli</td>
        <td class="kanan" id="totTdkPasPol">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>   
    <tr>
        <td colspan="5">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="5">&nbsp;</td>
        <td colspan="2">&nbsp;<?=$kotaRS?>, <?php echo $date_now;?></td>
    </tr>
    <tr>
        <td colspan="5" style="height:30;">&nbsp;</td>
        <td colspan="2">&nbsp;Ka Poli&nbsp;<?php echo $rwUnit2['nama']; ?></td>
    </tr>
    <tr style="height:50">
        <td colspan="5">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="5">&nbsp;</td>
        <td style="border-bottom:1px solid;">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr style="height:30">
        <td colspan="7">&nbsp;</td>
    </tr>
    <tr id="trTombol">
        <td colspan="7" class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
    </tr>
    <tr>
        <td colspan="7">&nbsp;</td>
    </tr>
</table>
<?php
      mysql_free_result($rsUnit1);
      mysql_free_result($rsUnit2);
      mysql_free_result($rsKso);
      mysql_free_result($rsPeg);
	  mysql_close($konek);
	  
	  $totTdkPasPol = $totJumPas-$totPasPol;
	  
?>
<script type="text/JavaScript">
document.getElementById('totalKsoPT').innerHTML = '&nbsp;<?php if($totKSOPT==0) echo ""; else echo $totKSOPT; ?>';
//document.getElementById('totPasPol').innerHTML = '&nbsp;<?php //if($totPasPol==0) echo ""; else echo $totPasPol; ?>';
document.getElementById('totTdkPasPol').innerHTML = '&nbsp;<?php if($totTdkPasPol==0) echo ""; else echo $totTdkPasPol; ?>';
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