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
	
	$qUn = "SELECT id, nama FROM b_ms_unit WHERE $fUnit ";
	$sUn = mysql_query($qUn);
	$wUn = mysql_fetch_array($sUn);
	
	$cmbWaktu = $_REQUEST['cmbWaktu'];
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
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
            border-top:1px solid #FFFFFF;
            border-bottom:1px solid #FFFFFF;
            border-left:1px solid #FFFFFF;
            font-weight:bold;
			background-color:#00FF00;
        }
        .tblJdlBwh
        {
            text-align:center;            
            border-bottom:1px solid #000000;
            border-left:1px solid #000000;
            font-weight:bold;
			background-color:#CCFFFF;
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
        <title>.: Pola Penyakit 10 Besar :.</title>
    </head>
    <body>
        <table width="800" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
             <tr>
				<td><b><?=$namaRS;?><br /><?=$alamatRS;?><br />Telepon <?=$tlpRS;?><br /><?=$kotaRS;?></b></td>
			</tr>
			<tr>
                <td align="center" class="jdl" height="75"><?php echo "pola penyakit 10 besar&nbsp;".$wUn['nama']."<br>".$thn;?></td>
            </tr>
            <tr>
                <td align="center">
				<?php if($cmbWaktu=='Tahunan'){?>
				<div id="tahunan">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
                        <tr>
							<td class="tblJdl" height="25" width="5%">NO</td>
							<td class="tblJdl" width="65%">DIAGNOSA</td>
							<td class="tblJdl" width="15%">JUMLAH</td>
							<td class="tblJdl" width="15%">TREN</td>
						</tr>
						<?php
								if($tmpLay==0){
									$fTmp = "b_ms_unit.parent_id = '".$jnsLay."'";
								}else{
									$fTmp = "b_ms_unit.id = '".$tmpLay."'";
								}
								$sql = "SELECT b_ms_diagnosa.id, b_ms_diagnosa.nama, COUNT(b_diagnosa.diagnosa_id) AS jml FROM b_pelayanan INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id INNER JOIN b_diagnosa ON b_diagnosa.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa.ms_diagnosa_id WHERE YEAR(b_diagnosa.tgl) = '$thn' AND $fTmp GROUP BY b_ms_diagnosa.id ORDER BY COUNT(b_diagnosa.diagnosa_id) DESC LIMIT 10";
								if($bln!=''){
									$sql.=" AND MONTH(b_diagnosa.tgl)=$bln";
								}
								$rs = mysql_query($sql);
								$no = 1;
								$tot = 0;
								while($rw = mysql_fetch_array($rs))
								{
						?>
						<tr>
							<td style="text-align:center"><?php echo $no;?></td>
							<td style="padding-left:10px; text-transform:uppercase;"><?php echo $rw['nama']?></td>
							<td style="text-align:right; padding-right:20px;"><?php echo number_format($rw['jml'],0,",",".")?></td>
							<?php
									$qJml = "SELECT SUM(t.jml) AS tot FROM (SELECT b_ms_diagnosa.id, b_ms_diagnosa.nama, COUNT(b_diagnosa.diagnosa_id) AS jml FROM b_pelayanan INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id INNER JOIN b_diagnosa ON b_diagnosa.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_diagnosa ON b_ms_diagnosa.id = b_diagnosa.ms_diagnosa_id WHERE YEAR(b_diagnosa.tgl) = '$thn' AND $fTmp GROUP BY b_ms_diagnosa.id ORDER BY COUNT(b_diagnosa.diagnosa_id) DESC LIMIT 10) AS t";
									if($bln!=''){
										$qJml.=" AND MONTH(b_diagnosa.tgl)=$bln";
									}
									$sJml = mysql_query($qJml);
									$wJml = mysql_fetch_array($sJml);
							?>
							<td style="padding-right:20px; text-align:right;"><?php echo number_format($rw['jml']/$wJml['tot']*100,2,",",".")?>&nbsp;%</td>
						</tr>
						<?php
								$no++; 
								$tot = $tot + $rw['jml']; 
								}
						?>
						<tr style="font-weight:bold; background-color:#FFFF00">
							<td height="25">&nbsp;</td>
							<td>&nbsp;JUMLAH</td>
							<td style="text-align:right; padding-right:20px;"><?php echo number_format($tot,0,",",".")?></td>
							<td style="padding-right:20px; text-align:right;">100&nbsp;%</td>
						</tr>
                    </table>
				</div>
				<?php } else {?>
				<div id="bulanan">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
						<tr>
							<td class="tblJdl" align="center" height="30" width="5%">NO</td>
							<td class="tblJdl" align="center" width="25%">DIAGNOSA</td>
							<?php 
								if($tmpLay==0){
									$fTmp = "b_pelayanan.jenis_layanan = '".$jnsLay."'";
								}else{
									$fTmp = "b_pelayanan.unit_id = '".$tmpLay."'";
								}
								$qBln = "SELECT DATE_FORMAT(b_pasien_keluar.tgl_act,'%m') AS bulan FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id = b_pelayanan.id WHERE $fTmp AND DATE_FORMAT(b_pasien_keluar.tgl_act,'%Y')='$thn' GROUP BY DATE_FORMAT(b_pasien_keluar.tgl_act,'%m') ORDER BY DATE_FORMAT(b_pasien_keluar.tgl_act,'%Y')"; 
								$rsBln = mysql_query($qBln);
								$col = 0;
								while($rwBln = mysql_fetch_array($rsBln))
								{
									$bln = $rwBln['bulan'];
									$col++;
							?>
							<td class="tblJdlKn" align="center"><?php echo $arrBln[$bln]; ?></td>
							<?php }?>
						</tr>
						<?php
								$sqlCr = "SELECT b_ms_cara_keluar.id, b_ms_cara_keluar.nama FROM b_ms_cara_keluar";
								$rsCr = mysql_query($sqlCr);
								$no = 1;
								while($rwCr = mysql_fetch_array($rsCr))
								{
						?>
						<tr>
							<td class="tblIsi" align="center"><?php echo $no;?></td>
							<td class="tblIsi">&nbsp;<?php echo $rwCr['nama'];?></td>
							<?php
								$rsBln = mysql_query($qBln);
								$j = 0;
								while($rwBln = mysql_fetch_array($rsBln)) {
									$qJml = "SELECT COUNT(b_pasien_keluar.pelayanan_id) AS jml FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id=b_pelayanan.id INNER JOIN b_ms_cara_keluar ON b_ms_cara_keluar.nama=b_pasien_keluar.cara_keluar WHERE $fTmp AND DATE_FORMAT(b_pasien_keluar.tgl_act,'%m')='".$rwBln['bulan']."' AND DATE_FORMAT(b_pasien_keluar.tgl_act,'%Y')='$thn' AND b_ms_cara_keluar.id='".$rwCr['id']."'";
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
							<td class="tblIsiKn" style="background-color:#FFFF00; font-weight:bold; text-align:center;"><?php echo $jml[$i]?></td>
							<?php	}	?>
						</tr>
					</table>
				</div>
				<?php } ?>
                </td>
            </tr>
        </table>
    </body>
</html>