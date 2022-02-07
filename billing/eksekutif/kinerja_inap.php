<?php
session_start();
include "../sesi.php";
?>
<?php
//session_start();
include("../koneksi/konek.php");
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
$userId = $_SESSION['userId'];
$jnsLay = $_REQUEST['JnsLayananInapSaja'];
$tmpLay = $_REQUEST['TmpLayananInapSaja'];
$bln = $_REQUEST['cmbBln'];
$thn = $_REQUEST['cmbThn'];
if($tmpLay==0) {
    $fUnit = "b_ms_unit.id = '".$jnsLay."'";
    $fUnit2 = "b_ms_unit.parent_id = '".$jnsLay."'";
    $fTmp = "b_pelayanan.jenis_layanan = '".$jnsLay."'";
	$fJns = "Jenis Layanan";
	
}else {
    $fUnit = "b_ms_unit.id = '".$tmpLay."'";
    $fUnit2 = "b_ms_unit.id = '".$tmpLay."'";
    $fTmp = "b_pelayanan.unit_id = '".$tmpLay."'";
	$fJns = "Tempat Layanan";
}

$qUn = "SELECT id, nama FROM b_ms_unit WHERE $fUnit ";
$sUn = mysql_query($qUn);
$wUn = mysql_fetch_array($sUn);

$cmbWaktu = $_REQUEST['cmbWaktu'];
$arrBln = array('1'=>'Januari','2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');

?>
<html>
    <style>
        .jdl{
            text-transform:uppercase;
            font-size:large;
            font-weight:bold;
			color:#990000;
        }
        .tblJdl
        {
            text-align:center;
            border-top:1px solid #FFFFFF;
            border-bottom:1px solid #FFFFFF;
            border-left:1px solid #FFFFFF;
            font-weight:bold;
            background-color:#00FF00;
        }
        .tblJdlBwh
        {
            text-align:center;            
            border-bottom:1px solid #FFFFFF;
            border-left:1px solid #FFFFFF;
            font-weight:bold;
            background-color:#00FF00;
        }
        .tblJdlKn
        {
            text-align:center;
            border-top:1px solid #FFFFFF;
            border-bottom:1px solid #FFFFFF;
            border-left:1px solid #FFFFFF;
            font-weight:bold;
            border-right:1px solid #FFFFFF;
            background-color:#00FF00;
        }
        .tblIsi
        {
            border-bottom:1px solid #FFFFFF;
            border-left:1px solid #FFFFFF;
            padding:1px 1px 1px 2px;
        }
        .tblIsiKn
        {
            border-bottom:1px solid #FFFFFF;
            border-left:1px solid #FFFFFF;
            border-right:1px solid #FFFFFF;
        }
    </style>
    <head>
        <title>.: Kinerja Instalasi Rawat Inap :.</title>
    </head>
    <body>
        <table width="1200" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
            <tr>
                <td><b><?=$namaRS;?><br /><?=$alamatRS;?><br />Telepon <?=$tlpRS;?><br /><?=$kotaRS;?></b></td>
            </tr>
            <tr>
                <td align="center" class="jdl" height="100" valign="top"><?php echo "kinerja instalasi rawat inap<br>".$fJns."&nbsp;".$wUn['nama']."<br>TAHUN ".$thn;?></td>
            </tr>
            <tr>
                <td>
                    <?php if($cmbWaktu=='Tahunan') {?>
                    <div id="tahunan">
                        <table width="90%" align="center" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                            <tr>
                                <td width="45%">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                                        <tr>
                                            <td height="30" colspan="3" style="text-align:center; font-weight:bold; background-color:#00FFFF; font-size:12px;">Pasien Meninggal < 48 Jam</td>
                                        </tr>
                                        <tr>
                                            <td width="60%">&nbsp;</td>
                                            <td width="20%">&nbsp;</td>
                                            <td width="20%">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2" style="text-align:center;" class="tblJdl">UNIT KERJA</td>
                                            <td height="25" colspan="2" style="text-align:center;" class="tblJdlKn">TAHUN</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center;" class="tblJdlBwh"><?php echo $thn-1;?></td>
                                            <td style="text-align:center;" class="tblJdlBwh"><?php echo $thn;?></td>
                                        </tr>
                                            <?php
                                            echo $qUnit = "SELECT * FROM b_ms_unit WHERE $fUnit2 AND b_ms_unit.aktif=1 AND b_ms_unit.inap=1";
                                            $sUnit = mysql_query($qUnit);
                                            $tLm = 0;
                                            $tBr = 0;
                                            while($wUnit = mysql_fetch_array($sUnit)) {
                                                $sql1 = "SELECT COUNT(b_pelayanan.id) AS jml FROM b_pasien_keluar
INNER JOIN b_pelayanan ON b_pelayanan.id = b_pasien_keluar.pelayanan_id WHERE b_pasien_keluar.keadaan_keluar LIKE 'Meninggal < 48 Jam' AND b_pelayanan.unit_id = '".$wUnit['id']."' AND YEAR(b_pasien_keluar.tgl_act) = $thn ";
                                                if($bln!='') {
                                                    $sql1.=" AND MONTH(b_pasien_keluar.tgl_act)=$bln";
                                                }
                                                $rs1 = mysql_query($sql1);
                                                $rw1 = mysql_fetch_array($rs1);

                                                $sql2 = "SELECT COUNT(b_pelayanan.id) AS jml FROM b_pasien_keluar
INNER JOIN b_pelayanan ON b_pelayanan.id = b_pasien_keluar.pelayanan_id WHERE b_pasien_keluar.keadaan_keluar LIKE 'Meninggal < 48 Jam' AND b_pelayanan.unit_id = '".$wUnit['id']."' AND YEAR(b_pasien_keluar.tgl_act) = ($thn-1) ";
                                                if($bln!='') {
                                                    $sql2.=" AND MONTH(b_pasien_keluar.tgl_act)=$bln";
                                                }
                                                $rs2 = mysql_query($sql2);
                                                $rw2 = mysql_fetch_array($rs2);
                                                ?>
                                        <tr>
                                            <td style="padding-left:5px; text-transform:uppercase;" class="tblIsi" height="20"><?php echo $wUnit['nama']?></td>
                                            <td style="text-align:center;" class="tblIsi"><?php echo number_format($rw2['jml'],0,",",".");?></td>
                                            <td style="text-align:center;" class="tblIsiKn"><?php echo number_format($rw1['jml'],0,",",".");?></td>
                                        </tr>
        <?php
                                                $tLm = $tLm + $rw2['jml'];
                                                $tBr = $tBr + $rw1['jml'];
                                            }
                                            ?>
                                        <tr style="background-color:#FFFF00; font-weight:bold;">
                                            <td height="25" class="tblIsi">&nbsp;TOTAL</td>
                                            <td align="center" class="tblIsi"><?php echo number_format($tLm,0,",",".");?></td>
                                            <td align="center" class="tblIsiKn"><?php echo number_format($tBr,0,",",".");?></td>
                                        </tr>
                                    </table>							</td>
                                <td width="10%">&nbsp;</td>
                                <td width="45%">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                                        <tr>
                                            <td height="25" colspan="3" style="text-align:center; font-weight:bold; background-color:#00FFFF; font-size:12px;">Pasien Meninggal > 48 Jam</td>
                                        </tr>
                                        <tr>
                                            <td width="60%">&nbsp;</td>
                                            <td width="20%">&nbsp;</td>
                                            <td width="20%">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2" style="text-align:center;" class="tblJdl">UNIT KERJA</td>
                                            <td height="25" colspan="2" style="text-align:center;" class="tblJdlKn">TAHUN</td>
                                        </tr>
                                        <tr>
                                            <td align="center" class="tblJdlBwh"><?php echo $thn-1;?></td>
                                            <td align="center" class="tblJdlBwh"><?php echo $thn;?></td>
                                        </tr>
    <?php
                                            $qUnit1 = "SELECT * FROM b_ms_unit WHERE $fUnit2 AND b_ms_unit.aktif=1 AND b_ms_unit.inap=1";
                                            $sUnit1 = mysql_query($qUnit1);
                                            $tLm2 = 0;
                                            $tBr2 = 0;
                                            while($wUnit1 = mysql_fetch_array($sUnit1)) {
                                                $sql11 = "SELECT COUNT(b_pelayanan.id) AS jml FROM b_pasien_keluar
INNER JOIN b_pelayanan ON b_pelayanan.id = b_pasien_keluar.pelayanan_id WHERE b_pasien_keluar.keadaan_keluar LIKE 'Meninggal > 48 Jam' AND b_pelayanan.unit_id = '".$wUnit1['id']."' AND YEAR(b_pasien_keluar.tgl_act) = $thn ";
                                                if($bln!='') {
                                                    $sql11.=" AND MONTH(b_pasien_keluar.tgl_act)=$bln";
                                                }
                                                $rs11 = mysql_query($sql11);
                                                $rw11 = mysql_fetch_array($rs11);

                                                $sql21 = "SELECT COUNT(b_pelayanan.id) AS jml FROM b_pasien_keluar
INNER JOIN b_pelayanan ON b_pelayanan.id = b_pasien_keluar.pelayanan_id WHERE b_pasien_keluar.keadaan_keluar LIKE 'Meninggal > 48 Jam' AND b_pelayanan.unit_id = '".$wUnit1['id']."' AND YEAR(b_pasien_keluar.tgl_act) = ($thn-1) ";
                                                if($bln!='') {
                                                    $sql21.=" AND MONTH(b_pasien_keluar.tgl_act)=$bln";
                                                }
                                                $rs21 = mysql_query($sql21);
                                                $rw21 = mysql_fetch_array($rs21);
                                                ?>
                                        <tr>
                                            <td height="20" class="tblIsi" style="padding-left:5px; text-transform:uppercase;"><?php echo $wUnit1['nama']?></td>
                                            <td style="text-align:center;" class="tblIsi"><?php echo number_format($rw21['jml'],0,",",".");?></td>
                                            <td style="text-align:center;" class="tblIsiKn"><?php echo number_format($rw11['jml'],0,",",".");?></td>
                                        </tr>
        <?php
        $tLm2 = $tLm2 + $rw21['jml'];
                                                $tBr2 = $tBr2 + $rw11['jml'];
                                            }
                                            ?>
                                        <tr style="background-color:#FFFF00; font-weight:bold;">
                                            <td height="25" class="tblIsi">&nbsp;TOTAL</td>
                                            <td align="center" class="tblIsi"><?php echo number_format($tLm2,0,",",".");?></td>
                                            <td align="center" class="tblIsiKn"><?php echo number_format($tBr2,0,",",".");?></td>
                                        </tr>
                                    </table>							</td>
                            </tr>
                        </table>
                    </div>
    <?php } else {?>
                    <div id="bulanan">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                            <tr>
                                <td height="30" style="text-align:center; font-weight:bold; background-color:#00FFFF; font-size:12px;">Pasien Meninggal < 48 Jam</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                                        <tr>
                                            <td width="30%" style="text-align:center;" class="tblJdl">UNIT KERJA</td>
    <?php
    $qBln = "SELECT MONTH(b_pasien_keluar.tgl_act) AS bulan FROM b_pelayanan INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id WHERE $fTmp AND YEAR(b_pasien_keluar.tgl_act)='$thn' AND b_pasien_keluar.keadaan_keluar LIKE '%meninggal' GROUP BY MONTH(b_pasien_keluar.tgl_act)";
                                                $rsBln = mysql_query($qBln);
                                                $col = 0;
                                                while($rwBln = mysql_fetch_array($rsBln)) {
                                                    $bln = $rwBln['bulan'];
                                                    $col++;
                                                    ?>
                                            <td height="25" style="text-align:center;" class="tblJdl"><?php echo $arrBln[$bln]; ?></td>
                                                    <?php } ?>
                                        </tr>
    <?php
                                                $qUnit = "SELECT * FROM b_ms_unit WHERE $fUnit2 AND b_ms_unit.aktif=1 AND b_ms_unit.inap=1";
    $sUnit = mysql_query($qUnit);
                                            $tLm = 0;
                                            $tBr = 0;
                                            while($wUnit = mysql_fetch_array($sUnit)) {
                                                ?>
                                        <tr>
                                            <td style="padding-left:5px; text-transform:uppercase;" class="tblIsi" height="20"><?php echo $wUnit['nama']?></td>
                                                <?php
                                                $rsBln = mysql_query($qBln);
        $j = 0;
        while($rwBln = mysql_fetch_array($rsBln)) {
                                                        $qJml = "SELECT COUNT(t.id) AS jml
													FROM (SELECT b_pelayanan.id, b_pelayanan.tgl, b_pelayanan.tgl_krs, b_tindakan_kamar.tgl_in, b_tindakan_kamar.tgl_out,
													IF(b_tindakan_kamar.status_out=0,
													(IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)=0,1,
													DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in))),
													(IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)=0,0,
													DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)))) AS qtyHari
													FROM b_pelayanan INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
													INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id
													WHERE b_pelayanan.unit_id='".$wUnit['id']."' AND b_pasien_keluar.keadaan_keluar LIKE '%meninggal'
													AND YEAR(b_pasien_keluar.tgl_act)='$thn'
													AND MONTH(b_pasien_keluar.tgl_act)='".$rwBln['bulan']."') AS t
													WHERE t.qtyHari<=2";
                                                        //echo $qJml."<br>";
                                                        $rsJml = mysql_query($qJml);
                                                        $rwJml = mysql_fetch_array($rsJml);
                                                        $jml1[$j] += $rwJml['jml'];
                                                        $j++;
                                                        ?>
                                            <td class="tblIsi" style="text-align:center;"><?php echo $rwJml['jml'];?></td>
                                                        <?php
                                                    }
                                                    ?>
                                        </tr>
                                                    <?php
                                                    $no++;
                                                }
    ?>
                                        <tr style="background-color:#FFFF00; font-weight:bold">
                                            <td height="25" class="tblIsi">&nbsp;TOTAL</td>
                                            <?php
                                            for($i=0; $i<$col; $i++) {
        ?>
                                            <td align="center" class="tblIsi"><?php echo $jml1[$i]?></td>
                                                    <?php	}	?>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="50" valign="top"><button style="float:right;" onClick="window.open('grafik_meninggal1.php?thn=<?php echo $thn;?>'+'&tmp=<?php echo $wUn['nama']?>'+'&tmpLay=<?php echo $tmpLay?>'+'&jnsLay=<?php echo $jnsLay?>','_blank');">Lihat Grafik</button></td>
                            </tr>
                            <tr>
                                <td height="30" style="text-align:center; font-weight:bold; background-color:#00FFFF; font-size:12px;">Pasien Meninggal > 48 Jam</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                                        <tr>
                                            <td width="30%" style="text-align:center;" class="tblJdl">UNIT KERJA</td>
    <?php
    $qBln = "SELECT MONTH(b_pasien_keluar.tgl_act) AS bulan FROM b_pelayanan INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id WHERE $fTmp AND YEAR(b_pasien_keluar.tgl_act)='$thn' AND b_pasien_keluar.keadaan_keluar LIKE '%meninggal' GROUP BY MONTH(b_pasien_keluar.tgl_act)";
    $rsBln = mysql_query($qBln);
    $col = 0;
                                                while($rwBln = mysql_fetch_array($rsBln)) {
                                                    $bln = $rwBln['bulan'];
                                                    $col++;
                                                    ?>
                                            <td height="25" style="text-align:center;" class="tblJdl"><?php echo $arrBln[$bln]; ?></td>
                                                    <?php } ?>
                                        </tr>
                                                <?php
                                                $qUnit = "SELECT * FROM b_ms_unit WHERE $fUnit2 AND b_ms_unit.aktif=1 AND b_ms_unit.inap=1";
    $sUnit = mysql_query($qUnit);
                                                $tLm = 0;
    $tBr = 0;
                                            while($wUnit = mysql_fetch_array($sUnit)) {
                                                ?>
                                        <tr>
                                            <td style="padding-left:5px; text-transform:uppercase;" class="tblIsi"><?php echo $wUnit['nama']?></td>
                                                <?php
                                                $rsBln = mysql_query($qBln);
                                                $j = 0;
                                                while($rwBln = mysql_fetch_array($rsBln)) {
            $qJml = "SELECT COUNT(t.id) AS jml FROM
													(SELECT b_pelayanan.id, b_pelayanan.tgl, b_pelayanan.tgl_krs,
													b_tindakan_kamar.tgl_in, b_tindakan_kamar.tgl_out,
													IF(b_tindakan_kamar.status_out=0,
													(IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)=0,1,
													DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in))),
													(IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)=0,0,
													DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out,NOW()),b_tindakan_kamar.tgl_in)))) AS qtyHari
													FROM b_pelayanan
													INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id
													INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id
													WHERE b_pelayanan.unit_id='".$wUnit['id']."' AND b_pasien_keluar.keadaan_keluar
													LIKE '%meninggal' AND YEAR(b_pasien_keluar.tgl_act)='$thn' AND MONTH(b_pasien_keluar.tgl_act)='".$rwBln['bulan']."') AS t WHERE t.qtyHari>2";
                                                        $rsJml = mysql_query($qJml);
                                                        $rwJml = mysql_fetch_array($rsJml);
                                                        $jml2[$j] += $rwJml['jml'];
                                                        $j++;
                                                        ?>
                                            <td style="text-align:center;" class="tblIsi"><?php echo $rwJml['jml'];?></td>
                                                        <?php
                                                    }
                                                    ?>
                                        </tr>
                                                    <?php
        $no++;
                                                }
                                                ?>
                                        <tr style="background-color:#FFFF00; font-weight:bold;">
                                            <td height="25" class="tblIsi">&nbsp;TOTAL</td>
                                            <?php
                                            for($i=0; $i<$col; $i++) {
                                                ?>
                                            <td align="center" class="tblIsi"><?php echo $jml2[$i]?></td>
        <?php	}	?>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="50" valign="top"><button style="float:right;" onClick="window.open('grafik_meninggal2.php?thn=<?php echo $thn;?>'+'&tmp=<?php echo $wUn['nama']?>'+'&tmpLay=<?php echo $tmpLay?>'+'&jnsLay=<?php echo $jnsLay?>','_blank');">Lihat Grafik</button></td>
                            </tr>
                        </table>
                    </div>
    <?php } ?>
                </td>
            </tr>
        </table>
    </body>
</html>