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
		$fJns = "Jenis Layanan";
	}else{
		$fUnit = "b_ms_unit.id = '".$tmpLay."'";
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
			height:30;
			font-size:12px;
        }
        .tblJdlBwh
        {
            text-align:center;            
            border-bottom:1px solid #FFFFFF;
            border-left:1px solid #FFFFFF;
            font-weight:bold;
			background-color:#00FF00;
			height:30;
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
			height:30;
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
        <title>.: Rekapitulasi Data Kunjungan Pasien :.</title>
		<!-- untuk ajax-->
		<script type="text/javascript" src="../theme/js/ajax.js"></script>
		<!-- end untuk ajax-->
    </head>
    <body>
        <table width="800" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
            <tr>
				<td><b><?=$namaRS;?><br /><?=$alamatRS;?><br />Telepon <?=$tlpRS;?><br /><?=$kotaRS;?></b><br></td>
			</tr>
			<tr>
                <td align="center" class="jdl" height="100" valign="top"><?php echo "rekapitulasi data kunjungan pasien<br>".$fJns."&nbsp;".$wUn['nama']."<br>TAHUN ".$thn;?></td>
            </tr>
            <tr>
                <td align="center">
				<?php if($cmbWaktu=='Tahunan'){?>
				<div id="tahunan">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                        <tr>
                            <td class="tblJdl" rowspan="2" align="center" width="5%">NO</td>
                            <td class="tblJdl" rowspan="2" align="center" width="35%">URAIAN</td>
                            <td class="tblJdl" colspan="2" align="center">TAHUN</td>
                            <td class="tblJdl" rowspan="2" align="center">TREN</td>
                            <td class="tblJdlKn" rowspan="2" align="center">%</td>
                        </tr>
                        <tr>
                            <td class="tblJdlBwh" align="center"><?php echo $thn-1;?></td>
                            <td class="tblJdlBwh" align="center"><?php echo $thn;?></td>
                        </tr>
                        <tr>
                            <td class="tblIsi" align="center">1.</td>
                            <td class="tblIsi" height="30">KUNJUNGAN BARU</td>
                            <?php
                            if($tmpLay==0){
								$fTmp = "AND b_pelayanan.jenis_layanan = '".$jnsLay."'";
							}else{
								$fTmp = "AND b_pelayanan.unit_id = '".$tmpLay."'";
							}
                            $sql1="SELECT SUM(IF(b_kunjungan.isbaru=1,1,0)) AS baru,
								SUM(IF(b_kunjungan.isbaru=0,1,0)) AS lama,COUNT(b_kunjungan.isbaru) AS total 
								FROM b_kunjungan 
								INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
								WHERE YEAR(b_pelayanan.tgl)='".$thn."' $fTmp";
                            // echo $sql1."<br>";
							$rs1=mysql_query($sql1);
                            $rw1=mysql_fetch_array($rs1);
                            
                            $sql2="SELECT SUM(IF(b_kunjungan.isbaru=1,1,0)) AS baru,
								SUM(IF(b_kunjungan.isbaru=0,1,0)) AS lama,COUNT(b_kunjungan.isbaru) AS total 
								FROM b_kunjungan 
								INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
								WHERE YEAR(b_pelayanan.tgl)=($thn-1) $fTmp";    
                            $rs2=mysql_query($sql2);
                            $rw2=mysql_fetch_array($rs2);
                            ?>
                            <td class="tblIsi" style="text-align:right; padding-right:20px;" width="15%"><?php echo number_format($rw2['baru'],0,",",".");?></td>
                            <td class="tblIsi" style="text-align:right; padding-right:20px;" width="15%"><?php echo number_format($rw1['baru'],0,",",".");?></td>
                            <td class="tblIsi" width="10%" style="text-align:center; color:<?php if($rw1['baru']<$rw2['baru']){ echo '#FF0000';}else if($rw1['baru']>$rw2['baru']){ echo '#0000FF';}else{ echo '#FF00FF';}?> ">
                            <?php
                            if($rw2['baru']<$rw1['baru']){
                                echo 'Naik';
                                $selisih=$rw1['baru']-$rw2['baru'];
                            }
                            else if($rw2['baru']>$rw1['baru']){
                                echo 'Turun';
                                $selisih=$rw2['baru']-$rw1['baru'];
                            }
                            else{
                                echo 'Tetap';
                                $selisih=0;
                            }
                            ?></td>
                            <td class="tblIsiKn" width="20%" style="text-align:right; padding-right:15px;"><?php  echo @number_format($selisih/$rw1['baru']*100,2,",",".");?>&nbsp;%</td>                            
                        </tr>
                        <tr>
                            <td class="tblIsi" align="center">2.</td>
                            <td class="tblIsi" height="30">KUNJUNGAN LAMA</td>
                            <?php
                           
                            ?>
                            <td class="tblIsi" style="text-align:right; padding-right:20px;"><?php echo number_format($rw2['lama'],0,",",".");?></td>
                            <td class="tblIsi" style="text-align:right; padding-right:20px;"><?php echo number_format($rw1['lama'],0,",",".");?></td>
                            <td class="tblIsi" style="text-align:center; color:<?php if($rw1['lama']<$rw2['lama']){ echo '#FF0000';}else if($rw1['lama']>$rw2['lama']){ echo '#0000FF';}else{ echo '#FF00FF';}?>">
                            <?php
                            if($rw2['lama']<$rw1['lama']){
                                echo 'Naik';
                                $selisih=$rw1['lama']-$rw2['lama'];
                            }
                            else if($rw2['lama']>$rw1['lama']){
                                echo 'Turun';
                                $selisih=$rw2['lama']-$rw1['lama'];
                            }
                            else{
                                echo 'Tetap';
                                $selisih=0;
                            }
                            ?></td>
                            <td class="tblIsiKn" style="text-align:right; padding-right:15px;"><?php  echo @number_format($selisih/$rw1['lama']*100,2,",",".");?>&nbsp;%</td>                       
                        </tr>
                        <tr>
                            <td height="25" class="tblIsi" colspan="2" align="right" style="background-color:#FFFF00; font-weight:bold;">JUMLAH&nbsp;</td>
                            <td class="tblIsi" style="background-color:#FFFF00; text-align:right; padding-right:20px; font-weight:bold;"><?php echo number_format($rw2['total'],0,",",".");?></td>
                            <td class="tblIsi" style="background-color:#FFFF00; text-align:right; padding-right:20px; font-weight:bold;"><?php echo number_format($rw1['total'],0,",",".");?></td>
                             <td class="tblIsi" style="background-color:#FFFF00; font-weight:bold; text-align:center; color:<?php if($rw1['total']<$rw2['total']){ echo '#FF0000';}else if($rw1['total']>$rw2['total']){ echo '#0000FF';}else{ echo '#FF00FF';}?>">
                            <?php
                            if($rw2['total']<$rw1['total']){
                                echo 'Naik';
                                $selisih=$rw1['total']-$rw2['total'];
                            }
                            else if($rw2['total']>$rw1['total']){
                                echo 'Turun';
                                $selisih=$rw2['total']-$rw1['total'];
                            }
                            else{
                                echo 'Tetap';
                                $selisih=0;
                            }
                            ?></td>
                            <td class="tblIsiKn" style="background-color:#FFFF00; font-weight:bold; text-align:right; padding-right:15px;"><?php echo @number_format($selisih/$rw1['total']*100,2,",",".");?>&nbsp;%</td>    
                        </tr>
                    </table>
					<button style="float:right;" onClick="showGrafik('tahunan');">Lihat Grafik</button>
				</div>
				<?php } else {?>
				<div id="bulanan">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
					<tr>
						<td class="tblJdl" align="center" width="5%">NO</td>
						<td class="tblJdl" align="center" width="25%">URAIAN</td>
						<?php 
							if($tmpLay==0){
								$fTmp = "b_pelayanan.jenis_layanan = '".$jnsLay."'";
							}else{
								$fTmp = "b_pelayanan.unit_id = '".$tmpLay."'";
							}
							$qBln = "SELECT MONTH(b_pelayanan.tgl) AS bulan FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id WHERE $fTmp AND YEAR(b_pelayanan.tgl)='$thn' GROUP BY MONTH(b_pelayanan.tgl) ORDER BY MONTH(b_pelayanan.tgl)"; 
							$rsBln = mysql_query($qBln);
							$col = 0;
							while($rwBln = mysql_fetch_array($rsBln))
							{
								$bln = $rwBln['bulan'];
								$col++;
						?>
						<td class="tblJdlKn" align="center" style="text-transform:uppercase;"><?php echo $arrBln[$bln]; ?></td>
						<?php }?>
					</tr>
					<tr>
						<td class="tblIsi" align="center">1</td>
						<td class="tblIsi" height="25">&nbsp;KUNJUNGAN BARU</td>
						<?php
								$rsBln = mysql_query($qBln);
								$j = 0;
								while($rwBln = mysql_fetch_array($rsBln)) {
								
								$qBr = "SELECT COUNT(b_pelayanan.id) AS jml FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id 
WHERE MONTH(b_pelayanan.tgl)='".$rwBln['bulan']."'  AND YEAR(b_pelayanan.tgl)='$thn' AND $fTmp AND b_kunjungan.isbaru=1";
								$sBr = mysql_query($qBr);
								$wBr = mysql_fetch_array($sBr);
								$jml[$j] += $wBr['jml'];
								$j++;
						?>
						<td class="tblIsiKn" align="center"><?php echo $wBr['jml'];?></td>
						<?php 	} ?>
					</tr>
					<tr>
						<td class="tblIsi" align="center">2</td>
						<td class="tblIsi" height="25">&nbsp;KUNJUNGAN LAMA</td>
						<?php
								$rsBln = mysql_query($qBln);
								$j = 0;
								while($rwBln = mysql_fetch_array($rsBln)) {
								
								$qLm = "SELECT COUNT(b_pelayanan.id) AS jml FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id 
WHERE MONTH(b_pelayanan.tgl)='".$rwBln['bulan']."'  AND YEAR(b_pelayanan.tgl)='$thn' AND $fTmp AND b_kunjungan.isbaru=0";
								$sLm = mysql_query($qLm);
								$wLm = mysql_fetch_array($sLm);
								$jml[$j] += $wLm['jml'];
								$j++;
						?>
						<td class="tblIsiKn" align="center"><?php echo $wLm['jml'];?></td>
						<?php 	} ?>
					</tr>
					<tr>
						<td class="tblIsi" colspan="2" align="right" style="background-color:#FFFF00; font-weight:bold;">JUMLAH&nbsp;</td>
						<?php
				  			for($i=0; $i<$col; $i++){
						?>
						<td height="25" class="tblIsiKn" style="background-color:#FFFF00; font-weight:bold; text-align:center;"><?php echo $jml[$i]?></td>
						<?php	}	?>
					</tr>
				</table>
				<button style="float:right;" onClick="showGrafik('bulanan');">Lihat Grafik</button>
				
				</div>
				<?php }?>
                </td>
            </tr>
        </table>		
    </body>
	<script>
		function showGrafik(par){			
			window.open('grafik.php?periode='+par+'&thn=<?php echo $thn;?>'+'&tmp=<?php echo $wUn['nama']?>'+'&tmpLay=<?php echo $tmpLay?>'+'&jnsLay=<?php echo $jnsLay?>','_blank');
		}
	</script>
</html>