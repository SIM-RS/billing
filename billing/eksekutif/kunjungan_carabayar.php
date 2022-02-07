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
	if($tmpLay==0){
		$fUnit = "b_ms_unit.id = '".$jnsLay."'";
	}else{
		$fUnit = "b_ms_unit.id = '".$tmpLay."'";
	}
	
	$cmbWaktu = $_REQUEST['cmbWaktu'];
	$arrBln = array('1'=>'Januari','2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	
	$qUn = "SELECT id, nama FROM b_ms_unit WHERE $fUnit ";
	$sUn = mysql_query($qUn);
	$wUn = mysql_fetch_array($sUn);
	
	if($tmpLay==0){
		$fTmp = "AND b_pelayanan.jenis_layanan = '".$jnsLay."'";
	}else{
		$fTmp = "AND b_pelayanan.unit_id = '".$tmpLay."'";
	}
?>
<html>
    <style>
        .jdl{
            text-transform:uppercase;
            font-size:large;
            font-weight:bold;
        }
        .tblJdl
        {
            text-align:center;
            border-top:1px solid #000000;
            border-bottom:1px solid #000000;
            border-left:1px solid #000000;
            font-weight:bold;
			background-color:#00FF00;
        }
        .tblJdlBwh
        {
            text-align:center;            
            border-bottom:1px solid #000000;
            border-left:1px solid #000000;
            font-weight:bold;
			background-color:#00FF00;
        }
        .tblJdlKn
        {
            text-align:center;
            border-top:1px solid #000000;
            border-bottom:1px solid #000000;
            border-left:1px solid #000000;
            font-weight:bold;
            border-right:1px solid #000000;
			background-color:#00FF00;
        }
        .tblIsi
        {
            border-bottom:1px solid #000000;
            border-left:1px solid #000000;
            padding:1px 1px 1px 2px;
        }
        .tblIsiKn
        {
            border-bottom:1px solid #000000;
            border-left:1px solid #000000;
            border-right:1px solid #000000;
        }
    </style>
    <head>
        <title>.: Rekapitulasi Data Kunjungan Berdasarkan Cara Bayar :.</title>
    </head>
    <body>
        <table width="800" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
            <tr>
				<td><b><?=$namaRS;?><br /><?=$alamatRS;?><br />Telepon <?=$tlpRS;?><br /><?=$kotaRS;?></b></td>
			</tr>
			<tr>
                <td align="center" class="jdl" height="75"><?php echo "kunjungan&nbsp;".$wUn['nama']."&nbsp;berdasarkan cara bayar<br>".$thn;?></td>
            </tr>
            <tr>
                <td align="center">
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
								if($tmpLay==0){
									$fTmp = "b_pelayanan.jenis_layanan = '".$jnsLay."'";
								}else{
									$fTmp = "b_pelayanan.unit_id = '".$tmpLay."'";
								}
								$sql = "SELECT b_ms_kso.id, b_ms_kso.nama FROM b_kunjungan INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id INNER JOIN b_ms_kso ON b_ms_kso.id = b_pelayanan.kso_id WHERE $fTmp GROUP BY b_ms_kso.id ";
								$rs = mysql_query($sql);
								$no = 1;
								while($rw = mysql_fetch_array($rs))
								{
									$sql1 = "SELECT COUNT(t.pasien_id) AS jml FROM (SELECT b_pelayanan.pasien_id FROM b_kunjungan INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id INNER JOIN b_ms_kso ON b_ms_kso.id = b_pelayanan.kso_id WHERE YEAR(b_pelayanan.tgl)='".$thn."' AND $fTmp AND b_ms_kso.id = '".$rw['id']."' GROUP BY b_pelayanan.id) AS t";
									if($bln!=''){
										$sql1.=" AND MONTH(b_pelayanan.tgl)=$bln";
									}
									$rs1 = mysql_query($sql1);
									$rw1 = mysql_fetch_array($rs1);
									
									$sql2 = "SELECT COUNT(t.pasien_id) AS jml FROM (SELECT b_pelayanan.pasien_id FROM b_kunjungan INNER JOIN b_pelayanan ON b_kunjungan.id = b_pelayanan.kunjungan_id INNER JOIN b_ms_kso ON b_ms_kso.id = b_pelayanan.kso_id WHERE YEAR(b_pelayanan.tgl)=($thn-1) AND $fTmp AND b_ms_kso.id = '".$rw['id']."' GROUP BY b_pelayanan.id) AS t";
									if($bln!=''){
										$sql2.=" AND MONTH(b_pelayanan.tgl)=$bln";
									}
									$rs2 = mysql_query($sql2);
									$rw2 = mysql_fetch_array($rs2);
						?>
                        <tr>
                            <td class="tblIsi" align="center" width="5%"><?php echo $no;?></td>
                            <td class="tblIsi" style="text-transform:uppercase;" width="35%">&nbsp;<?php echo $rw['nama']?></td>
                            <td class="tblIsi" width="15%" style="text-align:right; padding-right:20px;"><?php echo number_format($rw1['jml'],0,",",".");?></td>
                            <td class="tblIsi" width="15%" style="text-align:right; padding-right:20px;"><?php echo number_format($rw2['jml'],0,",",".");?></td>
                            <td class="tblIsi" width="10%" style="text-align:center; color:<?php echo ($rw1['jml']<$rw2['jml'])?'#990000':(($rw1['jml']>$rw2['jml'])?'#000099':'#009933');?>">
							<?php
								if($rw1['jml']<$rw2['jml']){
									echo 'Naik';
									$selisih=$rw2['jml']-$rw1['jml'];
								}
								else if($rw1['jml']>$rw2['jml']){
									echo 'Turun';
									$selisih=$rw1['jml']-$rw2['jml'];
								}
								else{
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
                            <td class="tblIsi" colspan="2" align="right" style="background-color:#FFFF00; font-weight:bold;">TOTAL&nbsp;</td>
                            <td class="tblIsi" style="background-color:#FFFF00; font-weight:bold; text-align:right; padding-right:20px;"><?php echo number_format($tot1,0,",",".");?></td>
                            <td class="tblIsi" style="background-color:#FFFF00; font-weight:bold; text-align:right; padding-right:20px;"><?php echo number_format($tot2,0,",",".");?></td>
                             <td class="tblIsi" style="background-color:#FFFF00; font-weight:bold; text-align:center;">
                            <?php
                            if($tot1<$tot2){
                                echo 'Naik';
                                $selisih=$tot2-$tot1;
                            }
                            else if($tot1>$tot2){
                                echo 'Turun';
                                $selisih=$tot1-$tot2;
                            }
                            else{
                                echo 'Tetap';
                                $selisih=0;
                            }
                            ?></td>
                            <td class="tblIsiKn" style="background-color:#FFFF00; font-weight:bold; text-align:right; padding-right:20px;"><?php  echo number_format($selisih/$tot1*100,2,",",".");?>&nbsp;%</td>    
                        </tr>
                    </table>                </td>
            </tr>
        </table>
    </body>
</html>