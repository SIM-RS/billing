<?php
	session_start();
	include "../sesi.php";
	$userId = $_SESSION['userId'];
	$jnsLay = $_REQUEST['JnsLayanan'];
	$tmpLay = $_REQUEST['TmpLayanan'];
    $bln = $_REQUEST['cmbBln'];
    $thn = $_REQUEST['cmbThn'];
	$stsPas = $_REQUEST['StatusPas'];
    include("../koneksi/konek.php");
		$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	if($tmpLay==0){
		$fUnit = "b_ms_unit.id = '".$jnsLay."'";
	}else{
		$fUnit = "b_ms_unit.id = '".$tmpLay."'";
	}
	
	if($stsPas!=0){
		$fKso = " AND b_pelayanan.kso_id = '".$stsPas."'";
	}
	$cmbWaktu = $_REQUEST['cmbWaktu'];
	$arrBln = array('1'=>'Januari','2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	
	$qUn = "SELECT id, nama FROM b_ms_unit WHERE $fUnit ";
	$sUn = mysql_query($qUn);
	$wUn = mysql_fetch_array($sUn);
	
	$qKso = "SELECT id, nama FROM b_ms_kso WHERE id='".$stsPas."' ";
	$sKso = mysql_query($qKso);
	$wKso = mysql_fetch_array($sKso);
	
	if($tmpLay==0){
		$fTmp = "b_pelayanan.jenis_layanan = '".$jnsLay."'";
		$fJns = "Jenis Layanan";
	}else{
		$fTmp = "b_pelayanan.unit_id = '".$tmpLay."'";
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
            border-bottom:1px solid #FFFFFF;
            border-left:1px solid #FFFFFF;
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
            font-weight:bold;
            border-right:1px solid #FFFFFF;
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
        <title>.: Rekapitulasi Data Kunjungan Berdasarkan Jenis Pembayaran :.</title>
    </head>
    <body>
        <table width="1200" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
             <tr>
				<td><b><?=$namaRS;?><br /><?=$alamatRS;?><br />Telepon <?=$tlpRS;?><br /><?=$kotaRS;?></b><br></td>
			</tr>
			<tr>
                <td align="center" class="jdl" height="100" valign="top"><?php echo "pola 10 besar penyakit<br>".$fJns."&nbsp;".$wUn['nama']."<br>TAHUN ".$thn;?></td>
            </tr>
			<tr>
				<td>
					<?php if($cmbWaktu=='Tahunan'){?>
					<div id="tahunan">
						<table width="80%" border="0" cellpadding="0" cellspacing="0" align="center">
							<tr>
								<td width="48%" valign="top">
									<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
									<tr>
										<td height="30" colspan="3" style="text-align:center; font-weight:bold; background-color:#FFFF00;">TAHUN <?php echo $thn-1;?></td>
									</tr>
									<tr>
										<td width="10%">&nbsp;</td>
										<td width="60%">&nbsp;</td>
										<td width="30%">&nbsp;</td>
									</tr>
									<tr>
										<td style="text-align:center;" class="tblJdl">NO</td>
										<td style="text-align:center;" class="tblJdl" height="25">JENIS PENYAKIT</td>
										<td style="text-align:center;" class="tblJdlKn">JUMLAH PASIEN</td>
									</tr>
									<?php
											$sql1 = "SELECT b_ms_diagnosa.id, b_ms_diagnosa.nama, COUNT(b_diagnosa.pelayanan_id) AS jml FROM b_pelayanan INNER JOIN b_diagnosa ON b_diagnosa.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_diagnosa ON b_diagnosa.ms_diagnosa_id = b_ms_diagnosa.id WHERE $fTmp $fKso AND YEAR(b_diagnosa.tgl)=($thn-1) GROUP BY b_ms_diagnosa.id ORDER BY COUNT(b_diagnosa.pelayanan_id) DESC LIMIT 10 ";
											$rs1 = mysql_query($sql1);
											$no = 1;
											while($rw1 = mysql_fetch_array($rs1))
											{
									?>
									<tr>
										<td class="tblIsi" align="center"><?php echo $no;?></td>
										<td style="padding-left:5px; text-transform:uppercase;" class="tblIsi" height="20"><?php echo $rw1['nama']?></td>
										<td style="text-align:right; padding-right:20px;" class="tblIsiKn"><?php echo number_format($rw1['jml'],0,",",".")?></td>
									</tr>
									<?php 	
											$no++;
											}	
									?>
									<tr>
										<td colspan="3" style="border-top:1px solid #00FF00">&nbsp;</td>
									</tr>
									</table>
								</td>
								<td width="4%">&nbsp;</td>
								<td width="48%" valign="top">
								<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
									<tr>
										<td height="30" colspan="3" style="text-align:center; font-weight:bold; background-color:#00FFFF;">TAHUN <?php echo $thn;?></td>
									</tr>
									<tr>
										<td width="10%">&nbsp;</td>
										<td width="60%">&nbsp;</td>
										<td width="30%">&nbsp;</td>
									</tr>
									<tr>
										<td style="text-align:center;" class="tblJdl">NO</td>
										<td style="text-align:center;" class="tblJdl" height="25">JENIS PENYAKIT</td>
										<td style="text-align:center;" class="tblJdlKn">JUMLAH PASIEN</td>
									</tr>
									<?php
											if($tmpLay==0){
												$fTmp = "b_pelayanan.jenis_layanan = '".$jnsLay."'";
											}else{
												$fTmp = "b_pelayanan.unit_id = '".$tmpLay."'";
											}
											$sql2 = "SELECT b_ms_diagnosa.id, b_ms_diagnosa.nama, COUNT(b_diagnosa.pelayanan_id) AS jml FROM b_pelayanan INNER JOIN b_diagnosa ON b_diagnosa.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_diagnosa ON b_diagnosa.ms_diagnosa_id = b_ms_diagnosa.id WHERE $fTmp $fKso AND YEAR(b_diagnosa.tgl)=$thn GROUP BY b_ms_diagnosa.id ORDER BY COUNT(b_diagnosa.pelayanan_id) DESC LIMIT 10 ";
											$rs2 = mysql_query($sql2);
											$no = 1;
											while($rw2 = mysql_fetch_array($rs2))
											{
									?>
									<tr>
										<td style="text-align:center" class="tblIsi"><?php echo $no;?></td>
										<td style="padding-left:5px" class="tblIsi" height="20"><?php echo $rw2['nama']?></td>
										<td style="text-align:right; padding-right:20px;" class="tblIsiKn"><?php echo number_format($rw2['jml'],0,",",".")?></td>
									</tr>
									<?php 	
											$no++;
											}	
									?>
									<tr>
										<td colspan="3" style="border-top:1px solid #00FF00">&nbsp;</td>
									</tr>
									</table>
								</td>
							</tr>					
						</table>
					</div>
					<?php } else {?>
					<div id="bulanan">
						<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
							<tr>
								<td height="25" style="text-align:center; font-weight:bold; background-color:#9966FF;">TAHUN <?php echo $thn;?></td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td>
									<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
										<tr>
											<td class="tblJdl" align="center" height="30" width="5%">NO</td>
											<td class="tblJdl" align="center" width="30%">JENIS PENYAKIT</td>
											<?php 
												$qBln = "SELECT MONTH(b_diagnosa.tgl) AS bulan FROM b_pelayanan INNER JOIN b_diagnosa ON b_diagnosa.pelayanan_id=b_pelayanan.id WHERE $fTmp $fKso AND YEAR(b_diagnosa.tgl)='$thn' GROUP BY MONTH(b_diagnosa.tgl) ORDER BY YEAR(b_diagnosa.tgl)"; 
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
										<?php
												$sqlCr = "SELECT b_ms_diagnosa.id, b_ms_diagnosa.nama, COUNT(b_diagnosa.pelayanan_id) AS jml  FROM b_pelayanan INNER JOIN b_diagnosa ON b_diagnosa.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_diagnosa ON b_diagnosa.ms_diagnosa_id = b_ms_diagnosa.id WHERE $fTmp $fKso AND YEAR(b_diagnosa.tgl)='$thn' GROUP BY b_ms_diagnosa.id ORDER BY COUNT(b_diagnosa.pelayanan_id) DESC LIMIT 10";
												$rsCr = mysql_query($sqlCr);
												$no = 1;
												while($rwCr = mysql_fetch_array($rsCr))
												{
										?>
										<tr>
											<td class="tblIsi" align="center"><?php echo $no;?></td>
											<td class="tblIsi" style="text-transform:uppercase;" height="20">&nbsp;<?php echo $rwCr['nama'];?></td>
											<?php
												$rsBln = mysql_query($qBln);
												$j = 0;
												while($rwBln = mysql_fetch_array($rsBln)) {
													$qJml = "SELECT COUNT(b_diagnosa.pelayanan_id) AS jml FROM b_pelayanan INNER JOIN b_diagnosa ON b_diagnosa.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_diagnosa ON b_diagnosa.ms_diagnosa_id = b_ms_diagnosa.id WHERE $fTmp $fKso AND MONTH(b_diagnosa.tgl)='".$rwBln['bulan']."' AND YEAR(b_diagnosa.tgl)='$thn' AND b_ms_diagnosa.id='".$rwCr['id']."'";
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
											<td class="tblIsi" colspan="2" align="right" style="background-color:#FFFF00; font-weight:bold;">JUMLAH&nbsp;</td>
											<?php
												for($i=0; $i<$col; $i++){
											?>
											<td class="tblIsiKn" height="25" style="background-color:#FFFF00; font-weight:bold; text-align:center;"><?php echo $jml[$i]?></td>
											<?php	}	?>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div>
					<?php } ?>
					<!--input style="float: right" type="button" id="print_graph" value="Lihat Grafik" onClick="window.open('grafik_10penyakit.php?thn=<?php echo $thn;?>'+'&tmpLay=<?php echo $tmpLay?>'+'&jnsLay=<?php echo $jnsLay?>&waktu=<?php echo $cmbWaktu;?>','_blank');" /-->
				</td>
			</tr>
        </table>
    </body>
</html>