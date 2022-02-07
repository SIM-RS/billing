<?php
session_start();
include "../sesi.php";
$userId = $_SESSION['userId'];
$jnsLay = $_REQUEST['JnsLayanan'];
$tmpLay = $_REQUEST['TmpLayanan'];
$bln = $_REQUEST['cmbBln'];
$thn = $_REQUEST['cmbThn'];
include("../koneksi/konek.php");
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
if($tmpLay==0) {
    $fUnit = "b_ms_unit.id = '".$jnsLay."'";
}else {
    $fUnit = "b_ms_unit.id = '".$tmpLay."'";
}
$cmbWaktu = $_REQUEST['cmbWaktu'];
$arrBln = array('1'=>'Januari','2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');

$qUn = "SELECT id, nama FROM b_ms_unit WHERE $fUnit ";
$sUn = mysql_query($qUn);
$wUn = mysql_fetch_array($sUn);

if($tmpLay==0) {
    $fTmp = "AND b_pelayanan.jenis_layanan = '".$jnsLay."'";
	$fJns = "Jenis Layanan";
}else {
    $fTmp = "AND b_pelayanan.unit_id = '".$tmpLay."'";
	$fJns = "Tempat Layanan";
}
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
            height:30px;
            font-size:12px;
        }
        .tblJdlBwh
        {
            text-align:center;            
            border-bottom:1px solid #FFFFFF;
            border-left:1px solid #FFFFFF;
            font-weight:bold;
            background-color:#00FF00;
            height:30px;
            font-size:12px;
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
            height:30px;
            font-size:12px;
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
        <title>.: Rekapitulasi Data Kunjungan Berdasarkan Jenis Pembayaran :.</title>
    </head>
    <body>
        <table width="800" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
            <tr>
                <td><b><?=$namaRS;?><br /><?=$alamatRS;?><br />Telepon <?=$tlpRS;?><br /><?=$kotaRS;?></b><br></td>
            </tr>
            <tr>
                <td align="center" class="jdl" height="100" valign="top"><?php echo "REKAPITULASI DATA KUNJUNGAN PASIEN BERDASARKAN JENIS PEMBAYARAN<br>".$fJns."&nbsp;".$wUn['nama']."<br>TAHUN ".$thn;?></td>
            </tr>
            <tr>
                <td align="center">
                    <?php if($cmbWaktu=='Tahunan') {?>
                    <div id="tahunan">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                            <tr>
                                <td class="tblJdl" rowspan="2" align="center">NO</td>
                                <td class="tblJdl" rowspan="2" align="center">URAIAN</td>
                                <td class="tblJdl" colspan="2" align="center">TAHUN</td>
                                <td class="tblJdl" rowspan="2" align="center">TREN</td>
                                <td class="tblJdlKn" rowspan="2" align="center">%</td>
                            </tr>
                            <tr>
                                <td class="tblJdlBwh" align="center"><?php echo $thn-1;?></td>
                                <td class="tblJdlBwh" align="center"><?php echo $thn;?></td>
                            </tr>
                                <?php
                                if($tmpLay==0) {
                                    $fTmp = "b_pelayanan.jenis_layanan = '".$jnsLay."'";
                                }else {
                                    $fTmp = "b_pelayanan.unit_id = '".$tmpLay."'";
                                }
                                $sql = "SELECT b_ms_kso.id, b_ms_kso.nama FROM b_kunjungan INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id INNER JOIN b_ms_kso ON b_ms_kso.id = b_kunjungan.kso_id WHERE $fTmp GROUP BY b_ms_kso.id ";
                                $rs = mysql_query($sql);
                                $no = 1;
                                while($rw = mysql_fetch_array($rs)) {
                                    $sql1 = "SELECT COUNT(t.pasien_id) AS jml FROM (SELECT b_pelayanan.pasien_id FROM b_kunjungan INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id INNER JOIN b_ms_kso ON b_ms_kso.id = b_kunjungan.kso_id WHERE YEAR(b_pelayanan.tgl)='".$thn."' AND $fTmp AND b_ms_kso.id = '".$rw['id']."' GROUP BY b_pelayanan.id) AS t";
                                    $rs1 = mysql_query($sql1);
                                    $rw1 = mysql_fetch_array($rs1);

                                    $sql2 = "SELECT COUNT(t.pasien_id) AS jml FROM (SELECT b_pelayanan.pasien_id FROM b_kunjungan INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id INNER JOIN b_ms_kso ON b_ms_kso.id = b_kunjungan.kso_id WHERE YEAR(b_pelayanan.tgl)=($thn-1) AND $fTmp AND b_ms_kso.id = '".$rw['id']."' GROUP BY b_pelayanan.id) AS t";
                                    $rs2 = mysql_query($sql2);
                                    $rw2 = mysql_fetch_array($rs2);
                                    ?>
                            <tr>
                                <td class="tblIsi" align="center" width="5%"><?php echo $no;?></td>
                                <td class="tblIsi" style="text-transform:uppercase;" width="35%" height="20">&nbsp;<?php echo $rw['nama']?></td>
                                <td class="tblIsi" width="15%" style="text-align:right; padding-right:20px;"><?php echo number_format($rw1['jml'],0,",",".");?></td>
                                <td class="tblIsi" width="15%" style="text-align:right; padding-right:20px;"><?php echo number_format($rw2['jml'],0,",",".");?></td>
                                <td class="tblIsi" width="10%" style="text-align:center; color:<?php if($rw1['jml']<$rw2['jml']){ echo '#FF0000';}else if($rw1['jml']>$rw2['jml']){ echo '#0000FF';}else{ echo '#FF00FF';}?>">
        <?php
                                            if($rw1['jml']<$rw2['jml']) {
                                                echo 'Naik';
                                                $selisih=$rw2['jml']-$rw1['jml'];
                                            }
                                            else if($rw1['jml']>$rw2['jml']) {
                                                echo 'Turun';
                                                $selisih=$rw1['jml']-$rw2['jml'];
                                            }
                                            else {
                                                echo 'Tetap';
                                                $selisih=0;
                                            }
                                            ?></td>
                                <td class="tblIsiKn" width="20%" style="text-align:right; padding-right:20px;"><?php  if($selisih==0) echo "0"; else if($rw1['jml']==0) echo number_format($selisih*100,0,",","."); else echo number_format($selisih/$rw1['jml']*100,2,",",".");?>&nbsp;%</td>
                            </tr>
        <?php
                                    $no++;
                                    $tot1=$tot1 + $rw1['jml'];
                                    $tot2=$tot2 + $rw2['jml'];
                                }
                                ?>
                            <tr>
                                <td class="tblIsi" colspan="2" align="right" style="background-color:#FFFF00; font-weight:bold;" height="25">TOTAL&nbsp;</td>
                                <td class="tblIsi" style="background-color:#FFFF00; font-weight:bold; text-align:right; padding-right:20px;"><?php echo number_format($tot1,0,",",".");?></td>
                                <td class="tblIsi" style="background-color:#FFFF00; font-weight:bold; text-align:right; padding-right:20px;"><?php echo number_format($tot2,0,",",".");?></td>
                                <td class="tblIsi" style="background-color:#FFFF00; font-weight:bold; text-align:center; color:<?php if($tot1<$tot2){ echo '#FF0000';}else if($tot1>$tot2){ echo '#0000FF';}else{ echo '#FF00FF';}?>">
    <?php
                                        if($tot1<$tot2) {
                                            echo 'Naik';
                                            $selisih=$tot2-$tot1;
                                        }
                                        else if($tot1>$tot2) {
                                            echo 'Turun';
                                            $selisih=$tot1-$tot2;
                                        }
                                        else {
                                            echo 'Tetap';
                                            $selisih=0;
                                        }
                                        ?></td>
                                <td class="tblIsiKn" style="background-color:#FFFF00; font-weight:bold; text-align:right; padding-right:20px;"><?php  echo number_format($selisih/$tot1*100,2,",",".");?>&nbsp;%</td>
                            </tr>
                        </table>
                        <button style="float:right;" onClick="showGrafik('tahunan');">Lihat Grafik</button>
                    </div>
    <?php } else {?>
                    <div id="bulanan">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                            <tr>
                                <td class="tblJdl" align="center" height="30" width="5%">NO</td>
                                <td class="tblJdl" align="center" width="30%">URAIAN</td>
    <?php
                                    if($tmpLay==0) {
                                        $fTmp = "b_pelayanan.jenis_layanan = '".$jnsLay."'";
                                    }else {
                                        $fTmp = "b_pelayanan.unit_id = '".$tmpLay."'";
                                    }
                                    $qBln = "SELECT MONTH(b_pelayanan.tgl) AS bulan FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id WHERE $fTmp AND YEAR(b_pelayanan.tgl)='$thn' GROUP BY MONTH(b_pelayanan.tgl) ORDER BY MONTH(b_pelayanan.tgl)";
                                    $rsBln = mysql_query($qBln);
                                    $col = 0;
                                    while($rwBln = mysql_fetch_array($rsBln)) {
                                        $bln = $rwBln['bulan'];
                                        $col++;
                                        ?>
                                <td class="tblJdlKn" align="center" style="text-transform:uppercase;"><?php echo $arrBln[$bln]; ?></td>
                                        <?php }?>
                            </tr>
                                    <?php
                                $sqlCr = "SELECT b_ms_kso.id, b_ms_kso.nama FROM b_kunjungan INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id INNER JOIN b_ms_kso ON b_ms_kso.id = b_kunjungan.kso_id WHERE $fTmp AND YEAR(b_pelayanan.tgl)='$thn' AND b_ms_kso.id NOT IN (4,6) GROUP BY b_ms_kso.id UNION SELECT GROUP_CONCAT( DISTINCT b_ms_kso.id SEPARATOR ',') AS id, b_ms_kso.nama FROM b_kunjungan INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id INNER JOIN b_ms_kso ON b_ms_kso.id = b_kunjungan.kso_id WHERE $fTmp AND YEAR(b_pelayanan.tgl)='$thn' AND b_ms_kso.id IN (4,6) GROUP BY b_ms_kso.nama";
								//echo $sqlCr."<br>";
                                $rsCr = mysql_query($sqlCr);
                                $no = 1;
                                while($rwCr = mysql_fetch_array($rsCr)) {
                                    ?>
                            <tr>
                                <td class="tblIsi" align="center"><?php echo $no;?></td>
                                <td class="tblIsi" style="text-transform:uppercase;" height="20">&nbsp;<?php echo $rwCr['nama'];?></td>
        <?php
                                    $rsBln = mysql_query($qBln);
                                    $j = 0;
                                        while($rwBln = mysql_fetch_array($rsBln)) {
                                            $qJml = "SELECT COUNT(b_kunjungan.id) AS jml FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id WHERE $fTmp AND MONTH(b_pelayanan.tgl)='".$rwBln['bulan']."' AND YEAR(b_pelayanan.tgl)='$thn' AND b_kunjungan.kso_id in(".$rwCr['id'].")";
											//echo $qJml."<br><br>";
                                            $rsJml = mysql_query($qJml);
                                            $rwJml = mysql_fetch_array($rsJml);
                                            $jml[$j] += $rwJml['jml'];
                                            $j++;
                                            ?>
                                <td class="tblIsiKn" align="center"><?php echo $rwJml['jml'];?></td>
                                            <?php
                                        }
        ?>
                            </tr>
                                        <?php
                                        $no++;
    }
                                ?>
                            <tr>
                                <td class="tblIsi" colspan="2" align="right" style="background-color:#FFFF00; font-weight:bold;" height="25">JUMLAH&nbsp;</td>
                                <?php
    for($i=0; $i<$col; $i++) {
        ?>
                                <td class="tblIsiKn" style="background-color:#FFFF00; font-weight:bold; text-align:center;"><?php echo $jml[$i]?></td>
                                        <?php	}	?>
                            </tr>
                        </table>
                        <button style="float:right;" onClick="showGrafik('bulanan');">Lihat Grafik</button>
                    </div>
    <?php	}	?>
                </td> 
            </tr>
        </table>
    </body>
    <script>
        function showGrafik(par){			
            window.open('grafik_jnsBayar.php?periode='+par+'&thn=<?php echo $thn;?>'+'&tmp=<?php echo $wUn['nama']?>'+'&tmpLay=<?php echo $tmpLay?>'+'&jnsLay=<?php echo $jnsLay?>','_blank');
        }
    </script>
</html>