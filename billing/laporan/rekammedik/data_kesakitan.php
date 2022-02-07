<?php
	session_start();
	include("../../sesi.php");
	
	if($_POST['isExcel']=='yes'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="data_kesakitan.xls"');
	}

	
	include("../../koneksi/konek.php");
    $date_now=gmdate('d-m-Y',mktime(date('H')+7));

    $arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
    $waktu = $_POST['cmbWaktu'];
    if($waktu == 'Harian'){
        $tglAwal = explode('-',$_REQUEST['tglAwal2']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        $waktu = " AND b_diagnosa_rm.tgl = '$tglAwal2' ";
        $Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
    }
    else if($waktu == 'Bulanan'){
        $bln = $_POST['cmbBln'];
        $thn = $_POST['cmbThn'];
        $waktu = " AND MONTH(b_diagnosa_rm.tgl) = '$bln' AND YEAR(b_diagnosa_rm.tgl) = '$thn' ";
        $Periode = "Bulan $arrBln[$bln] Tahun $thn";
    }
    else{
        $tglAwal = explode('-',$_REQUEST['tglAwal']);
        $tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
        //echo $arrBln[$tglAwal[1]];
        $tglAkhir = explode('-',$_REQUEST['tglAkhir']);
        $tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
        $waktu = " AND b_diagnosa_rm.tgl between '$tglAwal2' AND '$tglAkhir2' ";
        
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
<style>
    .jdl{
        font-size:12px;
        font-weight:bold;
        border-top:1px solid;
        border-bottom:1px solid;
        border-left:1px solid;
        background-color:#00FF00;
        height:30;
        text-align:center;
    }
    .jdlKn{
        font-size:12px;
        font-weight:bold;
        border-top:1px solid;
        border-bottom:1px solid;
        border-left:1px solid;
        border-right:1px solid;
        height:30;
        text-align:center;
        background-color:#00FF00;
    }
    .jdldlm{
        border-left:1px solid;
        border-bottom:1px solid;
        height:30;
        text-align:center;
        font-weight:bold;
    }
    .isi{
        border-left:1px solid;
        border-bottom:1px solid;
    }
    .isiKn{
        border-left:1px solid;
        border-bottom:1px solid;
        border-right:1px solid;
    }
</style>
<title>.: Data Kesakitan Program Kesehatan Jiwa :.</title>

<table width="1200" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
    <tr>
        <td><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
    </tr>
    <tr>
        <td valign="top" height="70" style="text-transform:uppercase; font-weight:bold; font-size:14px; text-align:center;">laporan bulanan data kesakitan program kesehatan jiwa (form b)<br><?php echo $Periode;?></td>
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                <tr>
                    <td rowspan=3 class=jdl>No</td>
                    <td rowspan=3 class=jdl>Jenis Penyakit</td>
                    <td colspan=16 class=jdlKn>Jumlah Kasus dan Jumlah Kunjungan Kasus/Golongan Umur</td>
                </tr>
                <tr>
                    <td colspan=2 class=jdldlm style="background-color:#00FF00;">0-6 th</td>
                    <td colspan=2 class=jdldlm style="background-color:#00FF00;">7-14 th</td>
                    <td colspan=2 class=jdldlm style="background-color:#00FF00;">15-18th</td>
                    <td colspan=2 class=jdldlm style="background-color:#00FF00;">19-44 th</td>
                    <td colspan=2 class=jdldlm style="background-color:#00FF00;">45-59 th</td>
                    <td colspan=2 class=jdldlm style="background-color:#00FF00;">60-69 th</td>
                    <td colspan=2 class=jdldlm style="background-color:#00FF00;">> 70 th</td>
                    <td colspan=2 class=jdldlm style="border-right:1px solid; background-color:#00FF00;">Total</td>
                </tr>
                <tr>
                    <td class=jdldlm style="text-align:center; background-color:#FFFF00;">B</td>
                    <td class=jdldlm style="text-align:center; background-color:#FFFF00;">L</td>
                    <td class=jdldlm style="text-align:center; background-color:#FFFF00;">B</td>
                    <td class=jdldlm style="text-align:center; background-color:#FFFF00;">L</td>
                    <td class=jdldlm style="text-align:center; background-color:#FFFF00;">B</td>
                    <td class=jdldlm style="text-align:center; background-color:#FFFF00;">L</td>
                    <td class=jdldlm style="text-align:center; background-color:#FFFF00;">B</td>
                    <td class=jdldlm style="text-align:center; background-color:#FFFF00;">L</td>
                    <td class=jdldlm style="text-align:center; background-color:#FFFF00;">B</td>
                    <td class=jdldlm style="text-align:center; background-color:#FFFF00;">L</td>
                    <td class=jdldlm style="text-align:center; background-color:#FFFF00;">B</td>
                    <td class=jdldlm style="text-align:center; background-color:#FFFF00;">L</td>
                    <td class=jdldlm style="text-align:center; background-color:#FFFF00;">B</td>
                    <td class=jdldlm style="text-align:center; background-color:#FFFF00;">L</td>
                    <td class=jdldlm style="text-align:center; background-color:#FFFF00;">B</td>
                    <td class=jdldlm style="text-align:center; border-right:1px solid; background-color:#FFFF00;">L</td>
                </tr>
                <tr>
                    <td class=isi width=6% style="padding-left:5px;" height=25>F00#</td>
                    <td class=isi width=30% style="padding-left:5px;">Gangguan Mental Organik</td>
                    <?php
                        $sql1 = "SELECT SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=0 AND b_kunjungan.umur_thn<=6),1,0)) AS B1,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=0 AND b_kunjungan.umur_thn<=6),1,0)) AS L1,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=7 AND b_kunjungan.umur_thn<=14),1,0)) AS B2,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=7 AND b_kunjungan.umur_thn<=14),1,0)) AS L2,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=18),1,0)) AS B3,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=18),1,0)) AS L3,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=19 AND b_kunjungan.umur_thn<=44),1,0)) AS B4,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=19 AND b_kunjungan.umur_thn<=44),1,0)) AS L4,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=59),1,0)) AS B5,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=59),1,0)) AS L5,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=60 AND b_kunjungan.umur_thn<=69),1,0)) AS B6,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=60 AND b_kunjungan.umur_thn<=69),1,0)) AS L6,
                                SUM(IF(b_pasien_keluar.kasus=1 AND b_kunjungan.umur_thn>=70,1,0)) AS B7,
                                SUM(IF(b_pasien_keluar.kasus=0 AND b_kunjungan.umur_thn>=70,1,0)) AS L7,
                                SUM(IF(b_pasien_keluar.kasus=1,1,0)) AS totB,
                                SUM(IF(b_pasien_keluar.kasus=0,1,0)) AS totL
                                FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
                                INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
                                INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id 
								INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
                                WHERE (b_ms_diagnosa.kode LIKE 'F00%') AND b_pelayanan.unit_id='12' $waktu";
                        $rs1 = mysql_query($sql1);
                        $rw1 = mysql_fetch_array($rs1);
                    ?>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw1['B1']=="" || $rw1['B1']==0) echo "&nbsp;"; else echo $rw1['B1'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw1['L1']=="" || $rw1['L1']==0) echo "&nbsp;"; else echo $rw1['L1'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw1['B2']=="" || $rw1['B2']==0) echo "&nbsp;"; else echo $rw1['B2'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw1['L2']=="" || $rw1['L2']==0) echo "&nbsp;"; else echo $rw1['L2'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw1['B3']=="" || $rw1['B3']==0) echo "&nbsp;"; else echo $rw1['B3'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw1['L3']=="" || $rw1['L3']==0) echo "&nbsp;"; else echo $rw1['L3'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw1['B4']=="" || $rw1['B4']==0) echo "&nbsp;"; else echo $rw1['B4'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw1['L4']=="" || $rw1['L4']==0) echo "&nbsp;"; else echo $rw1['L4'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw1['B5']=="" || $rw1['B5']==0) echo "&nbsp;"; else echo $rw1['B5'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw1['L5']=="" || $rw1['L5']==0) echo "&nbsp;"; else echo $rw1['L5'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw1['B6']=="" || $rw1['B6']==0) echo "&nbsp;"; else echo $rw1['B6'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw1['L6']=="" || $rw1['L6']==0) echo "&nbsp;"; else echo $rw1['L6'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw1['B7']=="" || $rw1['B7']==0) echo "&nbsp;"; else echo $rw1['B7'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw1['L7']=="" || $rw1['L7']==0) echo "&nbsp;"; else echo $rw1['L7'];?></td>
                    <td class=isi width=4% style="text-align:center; font-weight:bold;"><?php if($rw1['totB']=="" || $rw1['totB']==0) echo "&nbsp;"; else echo $rw1['totB'];?></td>
                    <td class=isiKn width=4% style="text-align:center; font-weight:bold;"><?php if($rw1['totL']=="" || $rw1['totL']==0) echo "&nbsp;"; else echo $rw1['totL'];?></td>
                </tr>
                <tr>
                    <td class=isi style="padding-left:5px;" height=25>F10#</td>
                    <td class=isi style="padding-left:5px;">Gangguan Penggunaan NAPZA</td>
                    <?php
                        $sql2 = "SELECT SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=0 AND b_kunjungan.umur_thn<=6),1,0)) AS B1,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=0 AND b_kunjungan.umur_thn<=6),1,0)) AS L1,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=7 AND b_kunjungan.umur_thn<=14),1,0)) AS B2,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=7 AND b_kunjungan.umur_thn<=14),1,0)) AS L2,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=18),1,0)) AS B3,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=18),1,0)) AS L3,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=19 AND b_kunjungan.umur_thn<=44),1,0)) AS B4,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=19 AND b_kunjungan.umur_thn<=44),1,0)) AS L4,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=59),1,0)) AS B5,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=59),1,0)) AS L5,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=60 AND b_kunjungan.umur_thn<=69),1,0)) AS B6,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=60 AND b_kunjungan.umur_thn<=69),1,0)) AS L6,
                                SUM(IF(b_pasien_keluar.kasus=1 AND b_kunjungan.umur_thn>=70,1,0)) AS B7,
                                SUM(IF(b_pasien_keluar.kasus=0 AND b_kunjungan.umur_thn>=70,1,0)) AS L7,
                                SUM(IF(b_pasien_keluar.kasus=1,1,0)) AS totB,
                                SUM(IF(b_pasien_keluar.kasus=0,1,0)) AS totL
                                FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
                                INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
                                INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id 
								INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
                                WHERE (b_ms_diagnosa.kode LIKE 'F10%') AND b_pelayanan.unit_id='12' $waktu";
                        $rs2 = mysql_query($sql2);
                        $rw2 = mysql_fetch_array($rs2);
                    ?>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw2['B1']=="" || $rw2['B1']==0) echo "&nbsp;"; else echo $rw2['B1'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw2['L1']=="" || $rw2['L1']==0) echo "&nbsp;"; else echo $rw2['L1'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw2['B2']=="" || $rw2['B2']==0) echo "&nbsp;"; else echo $rw2['B2'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw2['L2']=="" || $rw2['L2']==0) echo "&nbsp;"; else echo $rw2['L2'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw2['B3']=="" || $rw2['B3']==0) echo "&nbsp;"; else echo $rw2['B3'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw2['L3']=="" || $rw2['L3']==0) echo "&nbsp;"; else echo $rw2['L3'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw2['B4']=="" || $rw2['B4']==0) echo "&nbsp;"; else echo $rw2['B4'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw2['L4']=="" || $rw2['L4']==0) echo "&nbsp;"; else echo $rw2['L4'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw2['B5']=="" || $rw2['B5']==0) echo "&nbsp;"; else echo $rw2['B5'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw2['L5']=="" || $rw2['L5']==0) echo "&nbsp;"; else echo $rw2['L5'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw2['B6']=="" || $rw2['B6']==0) echo "&nbsp;"; else echo $rw2['B6'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw2['L6']=="" || $rw2['L6']==0) echo "&nbsp;"; else echo $rw2['L6'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw2['B7']=="" || $rw2['B7']==0) echo "&nbsp;"; else echo $rw2['B7'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw2['L7']=="" || $rw2['L7']==0) echo "&nbsp;"; else echo $rw2['L7'];?></td>
                    <td class=isi width=4% style="text-align:center; font-weight:bold;"><?php if($rw2['totB']=="" || $rw2['totB']==0) echo "&nbsp;"; else echo $rw2['totB'];?></td>
                    <td class=isiKn width=4% style="text-align:center; font-weight:bold;"><?php if($rw2['totL']=="" || $rw2['totL']==0) echo "&nbsp;"; else echo $rw2['totL'];?></td>
                </tr>
                <tr>
                    <td class=isi style="padding-left:5px;" height=25>F20#</td>
                    <td class=isi style="padding-left:5px;">Skizofrenia dan Gangguan Psikotik Kronik Lain</td>
                    <?php
                        $sql3 = "SELECT SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=0 AND b_kunjungan.umur_thn<=6),1,0)) AS B1,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=0 AND b_kunjungan.umur_thn<=6),1,0)) AS L1,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=7 AND b_kunjungan.umur_thn<=14),1,0)) AS B2,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=7 AND b_kunjungan.umur_thn<=14),1,0)) AS L2,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=18),1,0)) AS B3,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=18),1,0)) AS L3,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=19 AND b_kunjungan.umur_thn<=44),1,0)) AS B4,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=19 AND b_kunjungan.umur_thn<=44),1,0)) AS L4,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=59),1,0)) AS B5,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=59),1,0)) AS L5,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=60 AND b_kunjungan.umur_thn<=69),1,0)) AS B6,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=60 AND b_kunjungan.umur_thn<=69),1,0)) AS L6,
                                SUM(IF(b_pasien_keluar.kasus=1 AND b_kunjungan.umur_thn>=70,1,0)) AS B7,
                                SUM(IF(b_pasien_keluar.kasus=0 AND b_kunjungan.umur_thn>=70,1,0)) AS L7,
                                SUM(IF(b_pasien_keluar.kasus=1,1,0)) AS totB,
                                SUM(IF(b_pasien_keluar.kasus=0,1,0)) AS totL
                                FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
                                INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
                                INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id 
								INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
                                WHERE (b_ms_diagnosa.kode LIKE 'F20%') 
								AND b_pelayanan.unit_id='12' $waktu";
                        $rs3 = mysql_query($sql3);
                        $rw3 = mysql_fetch_array($rs3);
                    ?>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw3['B1']=="" || $rw3['B1']==0) echo "&nbsp;"; else echo $rw3['B1'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw3['L1']=="" || $rw3['L1']==0) echo "&nbsp;"; else echo $rw3['L1'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw3['B2']=="" || $rw3['B2']==0) echo "&nbsp;"; else echo $rw3['B2'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw3['L2']=="" || $rw3['L2']==0) echo "&nbsp;"; else echo $rw3['L2'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw3['B3']=="" || $rw3['B3']==0) echo "&nbsp;"; else echo $rw3['B3'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw3['L3']=="" || $rw3['L3']==0) echo "&nbsp;"; else echo $rw3['L3'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw3['B4']=="" || $rw3['B4']==0) echo "&nbsp;"; else echo $rw3['B4'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw3['L4']=="" || $rw3['L4']==0) echo "&nbsp;"; else echo $rw3['L4'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw3['B5']=="" || $rw3['B5']==0) echo "&nbsp;"; else echo $rw3['B5'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw3['L5']=="" || $rw3['L5']==0) echo "&nbsp;"; else echo $rw3['L5'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw3['B6']=="" || $rw3['B6']==0) echo "&nbsp;"; else echo $rw3['B6'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw3['L6']=="" || $rw3['L6']==0) echo "&nbsp;"; else echo $rw3['L6'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw3['B7']=="" || $rw3['B7']==0) echo "&nbsp;"; else echo $rw3['B7'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw3['L7']=="" || $rw3['L7']==0) echo "&nbsp;"; else echo $rw3['L7'];?></td>
                    <td class=isi width=4% style="text-align:center; font-weight:bold;"><?php if($rw3['totB']=="" || $rw3['totB']==0) echo "&nbsp;"; else echo $rw3['totB'];?></td>
                    <td class=isiKn width=4% style="text-align:center; font-weight:bold;"><?php if($rw3['totL']=="" || $rw3['totL']==0) echo "&nbsp;"; else echo $rw3['totL'];?></td>
                </tr>
                <tr>
                    <td class=isi style="padding-left:5px;" height=25>F23</td>
                    <td class=isi style="padding-left:5px;">Gangguan Psikotik Akut</td>
                    <?php
                        $sql4 = "SELECT SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=0 AND b_kunjungan.umur_thn<=6),1,0)) AS B1,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=0 AND b_kunjungan.umur_thn<=6),1,0)) AS L1,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=7 AND b_kunjungan.umur_thn<=14),1,0)) AS B2,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=7 AND b_kunjungan.umur_thn<=14),1,0)) AS L2,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=18),1,0)) AS B3,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=18),1,0)) AS L3,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=19 AND b_kunjungan.umur_thn<=44),1,0)) AS B4,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=19 AND b_kunjungan.umur_thn<=44),1,0)) AS L4,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=59),1,0)) AS B5,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=59),1,0)) AS L5,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=60 AND b_kunjungan.umur_thn<=69),1,0)) AS B6,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=60 AND b_kunjungan.umur_thn<=69),1,0)) AS L6,
                                SUM(IF(b_pasien_keluar.kasus=1 AND b_kunjungan.umur_thn>=70,1,0)) AS B7,
                                SUM(IF(b_pasien_keluar.kasus=0 AND b_kunjungan.umur_thn>=70,1,0)) AS L7,
                                SUM(IF(b_pasien_keluar.kasus=1,1,0)) AS totB,
                                SUM(IF(b_pasien_keluar.kasus=0,1,0)) AS totL
                                FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
                                INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
                                INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id 
								INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
                                WHERE (b_ms_diagnosa.kode LIKE 'F23%') AND b_pelayanan.unit_id='12' $waktu";
                        $rs4 = mysql_query($sql4);
                        $rw4 = mysql_fetch_array($rs4);
                    ?>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw4['B1']=="" || $rw4['B1']==0) echo "&nbsp;"; else echo $rw4['B1'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw4['L1']=="" || $rw4['L1']==0) echo "&nbsp;"; else echo $rw4['L1'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw4['B2']=="" || $rw4['B2']==0) echo "&nbsp;"; else echo $rw4['B2'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw4['L2']=="" || $rw4['L2']==0) echo "&nbsp;"; else echo $rw4['L2'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw4['B3']=="" || $rw4['B3']==0) echo "&nbsp;"; else echo $rw4['B3'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw4['L3']=="" || $rw4['L3']==0) echo "&nbsp;"; else echo $rw4['L3'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw4['B4']=="" || $rw4['B4']==0) echo "&nbsp;"; else echo $rw4['B4'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw4['L4']=="" || $rw4['L4']==0) echo "&nbsp;"; else echo $rw4['L4'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw4['B5']=="" || $rw4['B5']==0) echo "&nbsp;"; else echo $rw4['B5'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw4['L5']=="" || $rw4['L5']==0) echo "&nbsp;"; else echo $rw4['L5'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw4['B6']=="" || $rw4['B6']==0) echo "&nbsp;"; else echo $rw4['B6'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw4['L6']=="" || $rw4['L6']==0) echo "&nbsp;"; else echo $rw4['L6'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw4['B7']=="" || $rw4['B7']==0) echo "&nbsp;"; else echo $rw4['B7'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw4['L7']=="" || $rw4['L7']==0) echo "&nbsp;"; else echo $rw4['L7'];?></td>
                    <td class=isi width=4% style="text-align:center; font-weight:bold;"><?php if($rw4['totB']=="" || $rw4['totB']==0) echo "&nbsp;"; else echo $rw4['totB'];?></td>
                    <td class=isiKn width=4% style="text-align:center; font-weight:bold;"><?php if($rw4['totL']=="" || $rw4['totL']==0) echo "&nbsp;"; else echo $rw4['totL'];?></td>
                </tr>
                <tr>
                    <td class=isi style="padding-left:5px;" height=25>F31</td>
                    <td class=isi style="padding-left:5px;">Gangguan Bipolar</td>
                    <?php
                        $sql5 = "SELECT SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=0 AND b_kunjungan.umur_thn<=6),1,0)) AS B1,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=0 AND b_kunjungan.umur_thn<=6),1,0)) AS L1,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=7 AND b_kunjungan.umur_thn<=14),1,0)) AS B2,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=7 AND b_kunjungan.umur_thn<=14),1,0)) AS L2,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=18),1,0)) AS B3,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=18),1,0)) AS L3,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=19 AND b_kunjungan.umur_thn<=44),1,0)) AS B4,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=19 AND b_kunjungan.umur_thn<=44),1,0)) AS L4,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=59),1,0)) AS B5,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=59),1,0)) AS L5,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=60 AND b_kunjungan.umur_thn<=69),1,0)) AS B6,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=60 AND b_kunjungan.umur_thn<=69),1,0)) AS L6,
                                SUM(IF(b_pasien_keluar.kasus=1 AND b_kunjungan.umur_thn>=70,1,0)) AS B7,
                                SUM(IF(b_pasien_keluar.kasus=0 AND b_kunjungan.umur_thn>=70,1,0)) AS L7,
                                SUM(IF(b_pasien_keluar.kasus=1,1,0)) AS totB,
                                SUM(IF(b_pasien_keluar.kasus=0,1,0)) AS totL
                                FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
                                INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
                                INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id 
								INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
                                WHERE  (b_ms_diagnosa.kode LIKE 'F31%') AND b_pelayanan.unit_id='12' $waktu";
                        $rs5 = mysql_query($sql5);
                        $rw5 = mysql_fetch_array($rs5);
                    ?>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw5['B1']=="" || $rw5['B1']==0) echo "&nbsp;"; else echo $rw5['B1'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw5['L1']=="" || $rw5['L1']==0) echo "&nbsp;"; else echo $rw5['L1'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw5['B2']=="" || $rw5['B2']==0) echo "&nbsp;"; else echo $rw5['B2'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw5['L2']=="" || $rw5['L2']==0) echo "&nbsp;"; else echo $rw5['L2'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw5['B3']=="" || $rw5['B3']==0) echo "&nbsp;"; else echo $rw5['B3'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw5['L3']=="" || $rw5['L3']==0) echo "&nbsp;"; else echo $rw5['L3'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw5['B4']=="" || $rw5['B4']==0) echo "&nbsp;"; else echo $rw5['B4'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw5['L4']=="" || $rw5['L4']==0) echo "&nbsp;"; else echo $rw5['L4'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw5['B5']=="" || $rw5['B5']==0) echo "&nbsp;"; else echo $rw5['B5'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw5['L5']=="" || $rw5['L5']==0) echo "&nbsp;"; else echo $rw5['L5'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw5['B6']=="" || $rw5['B6']==0) echo "&nbsp;"; else echo $rw5['B6'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw5['L6']=="" || $rw5['L6']==0) echo "&nbsp;"; else echo $rw5['L6'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw5['B7']=="" || $rw5['B7']==0) echo "&nbsp;"; else echo $rw5['B7'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw5['L7']=="" || $rw5['L7']==0) echo "&nbsp;"; else echo $rw5['L7'];?></td>
                    <td class=isi width=4% style="text-align:center; font-weight:bold;"><?php if($rw5['totB']=="" || $rw5['totB']==0) echo "&nbsp;"; else echo $rw5['totB'];?></td>
                    <td class=isiKn width=4% style="text-align:center; font-weight:bold;"><?php if($rw5['totL']=="" || $rw5['totL']==0) echo "&nbsp;"; else echo $rw5['totL'];?></td>
                </tr>
                <tr>
                    <td class=isi style="padding-left:5px;" height=25>F32#</td>
                    <td class=isi style="padding-left:5px;">Gangguan Depresif</td>
                    <?php
                        $sql6 = "SELECT SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=0 AND b_kunjungan.umur_thn<=6),1,0)) AS B1,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=0 AND b_kunjungan.umur_thn<=6),1,0)) AS L1,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=7 AND b_kunjungan.umur_thn<=14),1,0)) AS B2,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=7 AND b_kunjungan.umur_thn<=14),1,0)) AS L2,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=18),1,0)) AS B3,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=18),1,0)) AS L3,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=19 AND b_kunjungan.umur_thn<=44),1,0)) AS B4,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=19 AND b_kunjungan.umur_thn<=44),1,0)) AS L4,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=59),1,0)) AS B5,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=59),1,0)) AS L5,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=60 AND b_kunjungan.umur_thn<=69),1,0)) AS B6,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=60 AND b_kunjungan.umur_thn<=69),1,0)) AS L6,
                                SUM(IF(b_pasien_keluar.kasus=1 AND b_kunjungan.umur_thn>=70,1,0)) AS B7,
                                SUM(IF(b_pasien_keluar.kasus=0 AND b_kunjungan.umur_thn>=70,1,0)) AS L7,
                                SUM(IF(b_pasien_keluar.kasus=1,1,0)) AS totB,
                                SUM(IF(b_pasien_keluar.kasus=0,1,0)) AS totL
                                FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
                                INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
                                INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id 
								INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
                                WHERE (b_ms_diagnosa.kode LIKE 'F32%') AND b_pelayanan.unit_id='12' $waktu";
                        $rs6 = mysql_query($sql6);
                        $rw6 = mysql_fetch_array($rs6);
                    ?>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw6['B1']=="" || $rw6['B1']==0) echo "&nbsp;"; else echo $rw6['B1'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw6['L1']=="" || $rw6['L1']==0) echo "&nbsp;"; else echo $rw6['L1'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw6['B2']=="" || $rw6['B2']==0) echo "&nbsp;"; else echo $rw6['B2'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw6['L2']=="" || $rw6['L2']==0) echo "&nbsp;"; else echo $rw6['L2'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw6['B3']=="" || $rw6['B3']==0) echo "&nbsp;"; else echo $rw6['B3'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw6['L3']=="" || $rw6['L3']==0) echo "&nbsp;"; else echo $rw6['L3'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw6['B4']=="" || $rw6['B4']==0) echo "&nbsp;"; else echo $rw6['B4'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw6['L4']=="" || $rw6['L4']==0) echo "&nbsp;"; else echo $rw6['L4'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw6['B5']=="" || $rw6['B5']==0) echo "&nbsp;"; else echo $rw6['B5'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw6['L5']=="" || $rw6['L5']==0) echo "&nbsp;"; else echo $rw6['L5'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw6['B6']=="" || $rw6['B6']==0) echo "&nbsp;"; else echo $rw6['B6'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw6['L6']=="" || $rw6['L6']==0) echo "&nbsp;"; else echo $rw6['L6'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw6['B7']=="" || $rw6['B7']==0) echo "&nbsp;"; else echo $rw6['B7'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw6['L7']=="" || $rw6['L7']==0) echo "&nbsp;"; else echo $rw6['L7'];?></td>
                    <td class=isi width=4% style="text-align:center; font-weight:bold;"><?php if($rw6['totB']=="" || $rw6['totB']==0) echo "&nbsp;"; else echo $rw6['totB'];?></td>
                    <td class=isiKn width=4% style="text-align:center; font-weight:bold;"><?php if($rw6['totL']=="" || $rw6['totL']==0) echo "&nbsp;"; else echo $rw6['totL'];?></td>
                </tr>
                <tr>
                    <td class=isi style="padding-left:5px;" height=25>F40#</td>
                    <td class=isi style="padding-left:5px;">Gangguan Neurotik</td>
                    <?php
                        $sql7 = "SELECT SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=0 AND b_kunjungan.umur_thn<=6),1,0)) AS B1,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=0 AND b_kunjungan.umur_thn<=6),1,0)) AS L1,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=7 AND b_kunjungan.umur_thn<=14),1,0)) AS B2,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=7 AND b_kunjungan.umur_thn<=14),1,0)) AS L2,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=18),1,0)) AS B3,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=18),1,0)) AS L3,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=19 AND b_kunjungan.umur_thn<=44),1,0)) AS B4,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=19 AND b_kunjungan.umur_thn<=44),1,0)) AS L4,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=59),1,0)) AS B5,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=59),1,0)) AS L5,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=60 AND b_kunjungan.umur_thn<=69),1,0)) AS B6,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=60 AND b_kunjungan.umur_thn<=69),1,0)) AS L6,
                                SUM(IF(b_pasien_keluar.kasus=1 AND b_kunjungan.umur_thn>=70,1,0)) AS B7,
                                SUM(IF(b_pasien_keluar.kasus=0 AND b_kunjungan.umur_thn>=70,1,0)) AS L7,
                                SUM(IF(b_pasien_keluar.kasus=1,1,0)) AS totB,
                                SUM(IF(b_pasien_keluar.kasus=0,1,0)) AS totL
                                FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
                                INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
                                INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id 
								INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
                                WHERE (b_ms_diagnosa.kode LIKE 'F40%') AND b_pelayanan.unit_id='12' $waktu";
                        $rs7 = mysql_query($sql7);
                        $rw7 = mysql_fetch_array($rs7);
                    ?>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw7['B1']=="" || $rw7['B1']==0) echo "&nbsp;"; else echo $rw7['B1'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw7['L1']=="" || $rw7['L1']==0) echo "&nbsp;"; else echo $rw7['L1'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw7['B2']=="" || $rw7['B2']==0) echo "&nbsp;"; else echo $rw7['B2'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw7['L2']=="" || $rw7['L2']==0) echo "&nbsp;"; else echo $rw7['L2'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw7['B3']=="" || $rw7['B3']==0) echo "&nbsp;"; else echo $rw7['B3'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw7['L3']=="" || $rw7['L3']==0) echo "&nbsp;"; else echo $rw7['L3'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw7['B4']=="" || $rw7['B4']==0) echo "&nbsp;"; else echo $rw7['B4'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw7['L4']=="" || $rw7['L4']==0) echo "&nbsp;"; else echo $rw7['L4'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw7['B5']=="" || $rw7['B5']==0) echo "&nbsp;"; else echo $rw7['B5'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw7['L5']=="" || $rw7['L5']==0) echo "&nbsp;"; else echo $rw7['L5'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw7['B6']=="" || $rw7['B6']==0) echo "&nbsp;"; else echo $rw7['B6'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw7['L6']=="" || $rw7['L6']==0) echo "&nbsp;"; else echo $rw7['L6'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw7['B7']=="" || $rw7['B7']==0) echo "&nbsp;"; else echo $rw7['B7'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw7['L7']=="" || $rw7['L7']==0) echo "&nbsp;"; else echo $rw7['L7'];?></td>
                    <td class=isi width=4% style="text-align:center; font-weight:bold;"><?php if($rw7['totB']=="" || $rw7['totB']==0) echo "&nbsp;"; else echo $rw7['totB'];?></td>
                    <td class=isiKn width=4% style="text-align:center; font-weight:bold;"><?php if($rw7['totL']=="" || $rw7['totL']==0) echo "&nbsp;"; else echo $rw7['totL'];?></td>
                </tr>
                <tr>
                    <td class=isi style="padding-left:5px;" height=25>F70</td>
                    <td class=isi style="padding-left:5px;">Gangguan Mental</td>
                    <?php
                        $sql8 = "SELECT SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=0 AND b_kunjungan.umur_thn<=6),1,0)) AS B1,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=0 AND b_kunjungan.umur_thn<=6),1,0)) AS L1,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=7 AND b_kunjungan.umur_thn<=14),1,0)) AS B2,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=7 AND b_kunjungan.umur_thn<=14),1,0)) AS L2,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=18),1,0)) AS B3,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=18),1,0)) AS L3,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=19 AND b_kunjungan.umur_thn<=44),1,0)) AS B4,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=19 AND b_kunjungan.umur_thn<=44),1,0)) AS L4,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=59),1,0)) AS B5,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=59),1,0)) AS L5,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=60 AND b_kunjungan.umur_thn<=69),1,0)) AS B6,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=60 AND b_kunjungan.umur_thn<=69),1,0)) AS L6,
                                SUM(IF(b_pasien_keluar.kasus=1 AND b_kunjungan.umur_thn>=70,1,0)) AS B7,
                                SUM(IF(b_pasien_keluar.kasus=0 AND b_kunjungan.umur_thn>=70,1,0)) AS L7,
                                SUM(IF(b_pasien_keluar.kasus=1,1,0)) AS totB,
                                SUM(IF(b_pasien_keluar.kasus=0,1,0)) AS totL
                                FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
                                INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
                                INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id 
								INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
                                WHERE (b_ms_diagnosa.kode LIKE 'F70%') AND b_pelayanan.unit_id='12' $waktu";
                        $rs8 = mysql_query($sql8);
                        $rw8 = mysql_fetch_array($rs8);
                    ?>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw8['B1']=="" || $rw8['B1']==0) echo "&nbsp;"; else echo $rw8['B1'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw8['L1']=="" || $rw8['L1']==0) echo "&nbsp;"; else echo $rw8['L1'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw8['B2']=="" || $rw8['B2']==0) echo "&nbsp;"; else echo $rw8['B2'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw8['L2']=="" || $rw8['L2']==0) echo "&nbsp;"; else echo $rw8['L2'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw8['B3']=="" || $rw8['B3']==0) echo "&nbsp;"; else echo $rw8['B3'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw8['L3']=="" || $rw8['L3']==0) echo "&nbsp;"; else echo $rw8['L3'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw8['B4']=="" || $rw8['B4']==0) echo "&nbsp;"; else echo $rw8['B4'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw8['L4']=="" || $rw8['L4']==0) echo "&nbsp;"; else echo $rw8['L4'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw8['B5']=="" || $rw8['B5']==0) echo "&nbsp;"; else echo $rw8['B5'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw8['L5']=="" || $rw8['L5']==0) echo "&nbsp;"; else echo $rw8['L5'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw8['B6']=="" || $rw8['B6']==0) echo "&nbsp;"; else echo $rw8['B6'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw8['L6']=="" || $rw8['L6']==0) echo "&nbsp;"; else echo $rw8['L6'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw8['B7']=="" || $rw8['B7']==0) echo "&nbsp;"; else echo $rw8['B7'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw8['L7']=="" || $rw8['L7']==0) echo "&nbsp;"; else echo $rw8['L7'];?></td>
                    <td class=isi width=4% style="text-align:center; font-weight:bold;"><?php if($rw8['totB']=="" || $rw8['totB']==0) echo "&nbsp;"; else echo $rw8['totB'];?></td>
                    <td class=isiKn width=4% style="text-align:center; font-weight:bold;"><?php if($rw8['totL']=="" || $rw8['totL']==0) echo "&nbsp;"; else echo $rw8['totL'];?></td>
                </tr>
                <tr>
                    <td class=isi style="padding-left:5px;" height=25>F80-90#</td>
                    <td class=isi style="padding-left:5px;">Gangguan Kesehatan Jiwa Anak dan Remaja</td>
                    <?php
                        $sql9 = "SELECT SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=0 AND b_kunjungan.umur_thn<=6),1,0)) AS B1,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=0 AND b_kunjungan.umur_thn<=6),1,0)) AS L1,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=7 AND b_kunjungan.umur_thn<=14),1,0)) AS B2,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=7 AND b_kunjungan.umur_thn<=14),1,0)) AS L2,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=18),1,0)) AS B3,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=18),1,0)) AS L3,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=19 AND b_kunjungan.umur_thn<=44),1,0)) AS B4,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=19 AND b_kunjungan.umur_thn<=44),1,0)) AS L4,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=59),1,0)) AS B5,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=59),1,0)) AS L5,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=60 AND b_kunjungan.umur_thn<=69),1,0)) AS B6,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=60 AND b_kunjungan.umur_thn<=69),1,0)) AS L6,
                                SUM(IF(b_pasien_keluar.kasus=1 AND b_kunjungan.umur_thn>=70,1,0)) AS B7,
                                SUM(IF(b_pasien_keluar.kasus=0 AND b_kunjungan.umur_thn>=70,1,0)) AS L7,
                                SUM(IF(b_pasien_keluar.kasus=1,1,0)) AS totB,
                                SUM(IF(b_pasien_keluar.kasus=0,1,0)) AS totL
                                FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
                                INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
                                INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id 
								INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
                                WHERE (b_ms_diagnosa.kode BETWEEN 'F80' AND 'F90' OR b_ms_diagnosa.kode LIKE 'F90%') AND b_pelayanan.unit_id='12' $waktu";
                        $rs9 = mysql_query($sql9);
                        $rw9 = mysql_fetch_array($rs9);
                    ?>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw9['B1']=="" || $rw9['B1']==0) echo "&nbsp;"; else echo $rw9['B1'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw9['L1']=="" || $rw9['L1']==0) echo "&nbsp;"; else echo $rw9['L1'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw9['B2']=="" || $rw9['B2']==0) echo "&nbsp;"; else echo $rw9['B2'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw9['L2']=="" || $rw9['L2']==0) echo "&nbsp;"; else echo $rw9['L2'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw9['B3']=="" || $rw9['B3']==0) echo "&nbsp;"; else echo $rw9['B3'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw9['L3']=="" || $rw9['L3']==0) echo "&nbsp;"; else echo $rw9['L3'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw9['B4']=="" || $rw9['B4']==0) echo "&nbsp;"; else echo $rw9['B4'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw9['L4']=="" || $rw9['L4']==0) echo "&nbsp;"; else echo $rw9['L4'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw9['B5']=="" || $rw9['B5']==0) echo "&nbsp;"; else echo $rw9['B5'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw9['L5']=="" || $rw9['L5']==0) echo "&nbsp;"; else echo $rw9['L5'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw9['B6']=="" || $rw9['B6']==0) echo "&nbsp;"; else echo $rw9['B6'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw9['L6']=="" || $rw9['L6']==0) echo "&nbsp;"; else echo $rw9['L6'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw9['B7']=="" || $rw9['B7']==0) echo "&nbsp;"; else echo $rw9['B7'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw9['L7']=="" || $rw9['L7']==0) echo "&nbsp;"; else echo $rw9['L7'];?></td>
                    <td class=isi width=4% style="text-align:center; font-weight:bold;"><?php if($rw9['totB']=="" || $rw9['totB']==0) echo "&nbsp;"; else echo $rw9['totB'];?></td>
                    <td class=isiKn width=4% style="text-align:center; font-weight:bold;"><?php if($rw9['totL']=="" || $rw9['totL']==0) echo "&nbsp;"; else echo $rw9['totL'];?></td>
                </tr>
                <tr>
                    <td class=isi style="padding-left:5px;" height=25>G40#</td>
                    <td class=isi style="padding-left:5px;">Epilepsi</td>
                    <?php
                         $sql10 = "SELECT SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=0 AND b_kunjungan.umur_thn<=6),1,0)) AS B1,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=0 AND b_kunjungan.umur_thn<=6),1,0)) AS L1,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=7 AND b_kunjungan.umur_thn<=14),1,0)) AS B2,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=7 AND b_kunjungan.umur_thn<=14),1,0)) AS L2,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=18),1,0)) AS B3,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=15 AND b_kunjungan.umur_thn<=18),1,0)) AS L3,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=19 AND b_kunjungan.umur_thn<=44),1,0)) AS B4,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=19 AND b_kunjungan.umur_thn<=44),1,0)) AS L4,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=59),1,0)) AS B5,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=45 AND b_kunjungan.umur_thn<=59),1,0)) AS L5,
                                SUM(IF(b_pasien_keluar.kasus=1 AND (b_kunjungan.umur_thn>=60 AND b_kunjungan.umur_thn<=69),1,0)) AS B6,
                                SUM(IF(b_pasien_keluar.kasus=0 AND (b_kunjungan.umur_thn>=60 AND b_kunjungan.umur_thn<=69),1,0)) AS L6,
                                SUM(IF(b_pasien_keluar.kasus=1 AND b_kunjungan.umur_thn>=70,1,0)) AS B7,
                                SUM(IF(b_pasien_keluar.kasus=0 AND b_kunjungan.umur_thn>=70,1,0)) AS L7,
                                SUM(IF(b_pasien_keluar.kasus=1,1,0)) AS totB,
                                SUM(IF(b_pasien_keluar.kasus=0,1,0)) AS totL
                                FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id
                                INNER JOIN b_diagnosa_rm ON b_diagnosa_rm.pelayanan_id=b_pelayanan.id
                                INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id=b_diagnosa_rm.ms_diagnosa_id 
								INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
                                WHERE (b_ms_diagnosa.kode LIKE 'G40%') AND b_pelayanan.unit_id='12' $waktu";
                        $rs10 = mysql_query($sql10);
                        $rw10 = mysql_fetch_array($rs10);
                    ?>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw10['B1']=="" || $rw10['B1']==0) echo "&nbsp;"; else echo $rw10['B1'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw10['L1']=="" || $rw10['L1']==0) echo "&nbsp;"; else echo $rw10['L1'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw10['B2']=="" || $rw10['B2']==0) echo "&nbsp;"; else echo $rw10['B2'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw10['L2']=="" || $rw10['L2']==0) echo "&nbsp;"; else echo $rw10['L2'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw10['B3']=="" || $rw10['B3']==0) echo "&nbsp;"; else echo $rw10['B3'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw10['L3']=="" || $rw10['L3']==0) echo "&nbsp;"; else echo $rw10['L3'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw10['B4']=="" || $rw10['B4']==0) echo "&nbsp;"; else echo $rw10['B4'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw10['L4']=="" || $rw10['L4']==0) echo "&nbsp;"; else echo $rw10['L4'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw10['B5']=="" || $rw10['B5']==0) echo "&nbsp;"; else echo $rw10['B5'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw10['L5']=="" || $rw10['L5']==0) echo "&nbsp;"; else echo $rw10['L5'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw10['B6']=="" || $rw10['B6']==0) echo "&nbsp;"; else echo $rw10['B6'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw10['L6']=="" || $rw10['L6']==0) echo "&nbsp;"; else echo $rw10['L6'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw10['B7']=="" || $rw10['B7']==0) echo "&nbsp;"; else echo $rw10['B7'];?></td>
                    <td class=isi width=4% style="text-align:center;"><?php if($rw10['L7']=="" || $rw10['L7']==0) echo "&nbsp;"; else echo $rw10['L7'];?></td>
                    <td class=isi width=4% style="text-align:center; font-weight:bold;"><?php if($rw10['totB']=="" || $rw10['totB']==0) echo "&nbsp;"; else echo $rw10['totB'];?></td>
                    <td class=isiKn width=4% style="text-align:center; font-weight:bold;"><?php if($rw10['totL']=="" || $rw10['totL']==0) echo "&nbsp;"; else echo $rw10['totL'];?></td>
                </tr>
            </table>
        </td>
    </tr>
	<tr>
		<td style="padding-top:5px; font-size:12px;" align="right">
			Printed By : <?php echo $rwPeg['nama']; ?>
		</td>
	</tr>
    <tr>
        <td style="text-decoration:underline; font-weight:bold; padding-left:20px;" height=30 valign="bottom">Keterangan :</td>
    </tr>
    <tr>
        <td style="padding-left:50px; font-weight:bold;">B : Baru<br>L : Lama</td>
    </tr>
</table>