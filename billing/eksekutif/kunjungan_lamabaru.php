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
		$fTmp = "b_ms_unit.parent_id = '".$jnsLay."'";
		$fJns = "Jenis Layanan";
	}else{
		$fTmp = "b_ms_unit.id = '".$tmpLay."'";
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
		font-size:12px;
		height:30;
        }
        .tblJdlBwh
        {
		text-align:center;            
		border-bottom:1px solid #000000;
		border-left:1px solid #000000;
		font-weight:bold;
		background-color:#CCFFFF;
		font-size:12px;
		height:30;
        }
        .tblJdlKn
        {
           	text-align:center;
            border-top:1px solid #FFFFFF;
            border-bottom:1px solid #FFFFFF;
            border-left:1px solid #FFFFFF;
			border-right:1px solid #FFFFFF;
            font-weight:bold;
			background-color:#00FF00;
			font-size:12px;
			height:30;
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
        <title>.: Rekapitulasi Kunjungan :.</title>
    </head>
    <body>
        <table width="1200" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
            <tr>
				<td><b><?=$namaRS;?><br /><?=$alamatRS;?><br />Telepon <?=$tlpRS;?><br /><?=$kotaRS;?></b><br></td>
			</tr>
			<tr>
                <td align="center" class="jdl" height="100" valign="top"><?php echo "rekapitulasi data kunjungan pasien lama baru<br>".$fJns."&nbsp;".$wUn['nama']."<br>TAHUN ".$thn;?></td>
            </tr>
            <tr>
                <td align="center">
			<?php if($cmbWaktu=='Tahunan'){?>
			<div id="tahunan">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
					<tr>
						<td class="tblJdl">NO</td>
						<td class="tblJdl">TEMPAT LAYANAN</td>
						<td class="tblJdl">BARU&nbsp;<?php echo $thn-1;?></td>
						<td class="tblJdl">BARU&nbsp;<?php echo $thn;?></td>
						<td colspan="2" class="tblJdl">TREN</td>
						<td class="tblJdl">LAMA&nbsp;<?php echo $thn-1;?></td>
						<td class="tblJdl">LAMA&nbsp;<?php echo $thn;?></td>
						<td colspan="2" class="tblJdl">TREN</td>
					</tr>
					<?php
							$sql = "SELECT b_ms_unit.id, b_ms_unit.nama FROM b_pelayanan INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id WHERE $fTmp GROUP BY b_ms_unit.id";
							$rs = mysql_query($sql);
							$no = 1;
							$totBrLm = 0;
							$totBrBr = 0;
							$totLmLm = 0;
							$totLmBr = 0;
							while($rw = mysql_fetch_array($rs))
							{
								$sql1="SELECT SUM(IF(b_kunjungan.isbaru=1,1,0)) AS baru,
									SUM(IF(b_kunjungan.isbaru=0,1,0)) AS lama,COUNT(b_kunjungan.isbaru) AS total 
									FROM b_kunjungan 
									INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
									WHERE YEAR(b_pelayanan.tgl)='".$thn."' AND b_pelayanan.unit_id = '".$rw['id']."'";   
								$rs1=mysql_query($sql1);
								$rwBr=mysql_fetch_array($rs1);
								
								$sql2="SELECT SUM(IF(b_kunjungan.isbaru=1,1,0)) AS baru,
									SUM(IF(b_kunjungan.isbaru=0,1,0)) AS lama,COUNT(b_kunjungan.isbaru) AS total 
									FROM b_kunjungan 
									INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id
									WHERE YEAR(b_pelayanan.tgl)=($thn-1)  AND b_pelayanan.unit_id = '".$rw['id']."'";   
								$rs2=mysql_query($sql2);
								$rwLm=mysql_fetch_array($rs2);
								
					?>
					<tr>
						<td style="text-align:center" width="5%"><?php echo $no;?></td>
						<td style="padding-left:5px; text-transform:uppercase;" width="25%" height="20"><?php echo $rw['nama']?></td>
						<td style="text-align:right; padding-right:20px;" width="10%"><?php echo number_format($rwLm['baru'],0,",",".")?></td>
						<td style="text-align:right; padding-right:20px;" width="10%"><?php echo number_format($rwBr['baru'],0,",",".")?></td>
						<td style="padding-right:10px; text-align:right; font-size:larger; font-weight:bold; color:#FF0000" width="5%"><?php
								if($rwLm['baru']<$rwBr['baru']){
									echo '&uarr;';
									$selisih=abs($rwBr['baru']-$rwLm['baru']);
								}
								else if($rwLm['baru']>$rwBr['baru']){
									echo '&darr;';
									$selisih=abs($rwLm['baru']-$rwBr['baru']);
								}
								else{
									echo '&harr;';
									$selisih=0;
								}
						?></td>
						<td style="padding-right:20px; text-align:right;"><?php if($selisih==0) echo "0"; else if($rwLm['baru']==0) echo number_format($selisih*100,0,",","."); else echo number_format($selisih/$rwLm['baru']*100,2,",",".");?>&nbsp;%</td>
						<td style="text-align:right; padding-right:20px;" width="10%"><?php echo number_format($rwLm['lama'],0,",",".")?></td>
						<td style="text-align:right; padding-right:20px;" width="10%"><?php echo number_format($rwBr['lama'],0,",",".")?></td>
						<td style="padding-right:10px; text-align:right; font-size:larger; font-weight:bold; color:#FF0000" width="5%"><?php
								if($rwLm['lama']<$rwBr['lama']){
									echo '&uarr;';
									$selisih=$rwBr['lama']-$rwLm['lama'];
								}
								else if($rwLm['lama']>$rwBr['lama']){
									echo '&darr;';
									$selisih=$rwLm['lama']-$rwBr['lama'];
								}
								else{
									echo '&harr;';
									$selisih=0;
								}
						?></td>
						<td style="padding-right:20px; text-align:right;" width="10%"><?php  if($selisih==0) echo "0"; else if($rwLm['lama']==0) echo number_format($selisih*100,0,",","."); else echo number_format($selisih/$rwLm['lama']*100,2,",",".");?>&nbsp;%</td>
					</tr>
					<?php
							$no++;
							$totBrLm = $totBrLm + $rwLm['baru'];
							$totBrBr = $totBrBr + $rwBr['baru'];
							$totLmLm = $totLmLm + $rwLm['lama'];
							$totLmBr = $totLmBr + $rwBr['lama'];
							}
					?>
					<tr style="background-color:#FFFF00; font-weight:bold;">
						<td height="25" class="tblIsi" align="right" colspan="2">TOTAL&nbsp;</td>
						<td class="tblIsi" style="text-align:right; padding-right:20px;"><?php echo number_format($totBrLm,0,",",".");?></td>
						<td class="tblIsi" style="text-align:right; padding-right:20px;"><?php echo number_format($totBrBr,0,",",".");?></td>
						<td class="tblIsi" style="text-align:right; padding-right:10px;"><?php
							if($totBrLm<$totBrBr){
								echo '&uarr;';
								$selisih=$totBrBr-$totBrLm;
							}
							else if($totBrLm>$totBrBr){
								echo '&darr;';
								$selisih=$totBrLm-$totBrBr;
							}
							else{
								echo '&harr;';
								$selisih=0;
							}
						?></td>
						<td class="tblIsi" style="text-align:right; padding-right:20px;"><?php if($selisih==0) echo "0"; else if($totBrLm==0) echo number_format($selisih*100,0,",","."); else echo number_format($selisih/$totBrLm*100,2,",",".");?>&nbsp;%</td>
						<td class="tblIsi" style="text-align:right; padding-right:20px;"><?php echo number_format($totLmLm,0,",",".");?></td>
						<td class="tblIsi" style="text-align:right; padding-right:20px;"><?php echo number_format($totLmBr,0,",",".");?></td>
						<td class="tblIsi" style="text-align:right; padding-right:10px;"><?php
							if($totLmLm<$totLmBr){
								echo '&uarr;';
								$selisih=$totLmBr-$totLmLm;
							}
							else if($totLmLm>$totLmBr){
								echo '&darr;';
								$selisih=$totLmLm-$totLmBr;
							}
							else{
								echo '&harr;';
								$selisih=0;
							}
						?></td>
						<td class="tblIsiKn" style="text-align:right; padding-right:20px;"><?php if($selisih==0) echo "0"; else if($totLmLm==0) echo number_format($selisih*100,0,",","."); else echo number_format($selisih/$totLmLm*100,2,",",".");?>&nbsp;%</td>
					</tr>
				</table>
				</div>
				<?php } else {?>
				<div id="bulanan">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
						<tr>
							<td colspan="3" height="30" style="background-color:#9933FF; font-weight:bold; text-align:center; font-size:12px;">KUNJUNGAN LAMA <?php echo $thn;?></td>
						</tr>
						<tr>
							<td colspan="3">&nbsp;</td>
						</tr>
						<tr>
							<td>
								<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
								<tr>
									<td class="tblJdl" align="center" width="5%">NO</td>
									<td class="tblJdl" align="center" width="25%">TEMPAT LAYANAN</td>
									<?php 
										if($tmpLay==0){
											$fTmp = "b_pelayanan.jenis_layanan = '".$jnsLay."'";
										}else{
											$fTmp = "b_pelayanan.unit_id = '".$tmpLay."'";
										}
										$qBln = "SELECT MONTH(b_pelayanan.tgl) AS bulan FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id WHERE $fTmp AND YEAR(b_pelayanan.tgl)='$thn' AND b_kunjungan.isbaru=0 GROUP BY MONTH(b_pelayanan.tgl) ORDER BY MONTH(b_pelayanan.tgl)"; 
										$rsBln = mysql_query($qBln);
										$col = 0;
										while($rwBln = mysql_fetch_array($rsBln))
										{
											$bln = $rwBln['bulan'];
											$col++;
									?>
									<td class="tblJdl" align="center" style="text-transform:uppercase;"><?php echo $arrBln[$bln]; ?></td>
									<?php }?>
								</tr>
								<?php
										if($tmpLay==0){
											$sqlCr = "SELECT b_ms_unit.id, b_ms_unit.nama FROM b_pelayanan INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id WHERE b_ms_unit.parent_id = '".$jnsLay."' GROUP BY b_ms_unit.id";
										}else{
											$sqlCr = "SELECT b_ms_unit.id, b_ms_unit.nama FROM b_pelayanan INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id WHERE b_ms_unit.id = '".$tmpLay."' GROUP BY b_ms_unit.id";
										}
										$rsCr = mysql_query($sqlCr);
										$no = 1;
										while($rwCr = mysql_fetch_array($rsCr))
										{
								?>
								<tr>
									<td align="center"><?php echo $no;?></td>
									<td style="text-transform:uppercase;" height="25">&nbsp;<?php echo $rwCr['nama'];?></td>
									<?php
										$rsBln = mysql_query($qBln);
										$j = 0;
										while($rwBln = mysql_fetch_array($rsBln)) {
											$qJml = "SELECT COUNT(b_kunjungan.id) AS jml FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id WHERE MONTH(b_pelayanan.tgl)='".$rwBln['bulan']."' AND YEAR(b_pelayanan.tgl)='".$thn."' AND b_pelayanan.unit_id = '".$rwCr['id']."'  AND b_kunjungan.isbaru=0";
											$rsJml = mysql_query($qJml);
											$rwJml = mysql_fetch_array($rsJml);
											$jml[$j] += $rwJml['jml'];
											$j++;
									?>
									<td align="center"><?php echo $rwJml['jml'];?></td>
									<?php
											}
									?>
								</tr>
								<?php
										$no++;
										}
								?>
								<tr>
									<td colspan="2" align="right" height="25" style="background-color:#FFFF00; font-weight:bold;">JUMLAH&nbsp;</td>
									<?php
										for($i=0; $i<$col; $i++){
									?>
									<td style="background-color:#FFFF00; font-weight:bold; text-align:center;"><?php echo $jml[$i]?></td>
									<?php	}	?>
								</tr>
							</table>
							<button style="float:right;" onClick="window.open('grafik_lmbr1.php?thn=<?php echo $thn;?>'+'&tmp=<?php echo $wUn['nama']?>'+'&tmpLay=<?php echo $tmpLay?>'+'&jnsLay=<?php echo $jnsLay?>','_blank');">Lihat Grafik</button>
						</td>
					</tr>
					<tr>
						<td height="30">&nbsp;</td>
					</tr>
					<tr>
							<td colspan="3" height="30" style="background-color:#9933FF; font-weight:bold; text-align:center; font-size:12px;">KUNJUNGAN BARU <?php echo $thn;?></td>
						</tr>
						<tr>
							<td colspan="3">&nbsp;</td>
						</tr>
						<tr>
							<td>
								<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
								<tr>
									<td class="tblJdl" align="center" width="5%">NO</td>
									<td class="tblJdl" align="center" width="25%">TEMPAT LAYANAN</td>
									<?php 
										if($tmpLay==0){
											$fTmp = "b_pelayanan.jenis_layanan = '".$jnsLay."'";
										}else{
											$fTmp = "b_pelayanan.unit_id = '".$tmpLay."'";
										}
										$qBln = "SELECT MONTH(b_pelayanan.tgl) AS bulan FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id WHERE $fTmp AND YEAR(b_pelayanan.tgl)='$thn' AND b_kunjungan.isbaru=1 GROUP BY MONTH(b_pelayanan.tgl) ORDER BY MONTH(b_pelayanan.tgl)"; 
										$rsBln = mysql_query($qBln);
										$col = 0;
										while($rwBln = mysql_fetch_array($rsBln))
										{
											$bln = $rwBln['bulan'];
											$col++;
									?>
									<td class="tblJdl" align="center" style="text-transform:uppercase;"><?php echo $arrBln[$bln]; ?></td>
									<?php }?>
								</tr>
								<?php
										if($tmpLay==0){
											$sqlCr = "SELECT b_ms_unit.id, b_ms_unit.nama FROM b_pelayanan INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id WHERE b_ms_unit.parent_id = '".$jnsLay."' GROUP BY b_ms_unit.id";
										}else{
											$sqlCr = "SELECT b_ms_unit.id, b_ms_unit.nama FROM b_pelayanan INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id WHERE b_ms_unit.id = '".$tmpLay."' GROUP BY b_ms_unit.id";
										}
										$rsCr = mysql_query($sqlCr);
										$no = 1;
										while($rwCr = mysql_fetch_array($rsCr))
										{
								?>
								<tr>
									<td align="center"><?php echo $no;?></td>
									<td style="text-transform:uppercase;" height="25">&nbsp;<?php echo $rwCr['nama'];?></td>
									<?php
										$rsBln = mysql_query($qBln);
										$j = 0;
										while($rwBln = mysql_fetch_array($rsBln)) {
											$qJml = "SELECT COUNT(b_kunjungan.id) AS jml FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id = b_kunjungan.id WHERE MONTH(b_pelayanan.tgl)='".$rwBln['bulan']."' AND YEAR(b_pelayanan.tgl)='".$thn."' AND b_pelayanan.unit_id = '".$rwCr['id']."'  AND b_kunjungan.isbaru=1";
											$rsJml = mysql_query($qJml);
											$rwJml = mysql_fetch_array($rsJml);
											$jml[$j] += $rwJml['jml'];
											$j++;
									?>
									<td align="center"><?php echo $rwJml['jml'];?></td>
									<?php
											}
									?>
								</tr>
								<?php
										$no++;
										}
								?>
								<tr>
									<td colspan="2" align="right" height="25" style="background-color:#FFFF00; font-weight:bold;">JUMLAH&nbsp;</td>
									<?php
										for($i=0; $i<$col; $i++){
									?>
									<td style="background-color:#FFFF00; font-weight:bold; text-align:center;"><?php echo $jml[$i]?></td>
									<?php	}	?>
								</tr>
							</table>
								<button style="float:right;" onClick="window.open('grafik_lmbr2.php?thn=<?php echo $thn;?>'+'&tmp=<?php echo $wUn['nama']?>'+'&tmpLay=<?php echo $tmpLay?>'+'&jnsLay=<?php echo $jnsLay?>','_blank');">Lihat Grafik</button>
						</td>
					</tr>
					</table>
				</div>
				<?php } ?>
                </td>
            </tr>
        </table>
    </body>
	<script>
		function showGrafik(par){			
			window.open('grafik_lmbr1.php?periode='+par+'&thn=<?php echo $thn;?>'+'&tmp=<?php echo $wUn['nama']?>'+'&tmpLay=<?php echo $tmpLay?>'+'&jnsLay=<?php echo $jnsLay?>','_blank');
		}
	</script>
</html>