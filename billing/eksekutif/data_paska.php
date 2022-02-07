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
		$fJns = "Jenis Layanan";
	}else{
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
        <title>.: Rekapitulasi Data Paska Kunjungan :.</title>
    </head>
    <body>
        <table width="800" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
            <tr>
				<td><b><?=$namaRS;?><br /><?=$alamatRS;?><br />Telepon <?=$tlpRS;?><br /><?=$kotaRS;?></b><br></td>
			</tr>
			<tr>
                <td align="center" class="jdl" height="100" valign="top"><?php echo "rekapitulasi data paska kunjungan pasien<br>".$fJns."&nbsp;".$wUn['nama']."<br>TAHUN ".$thn;?></td>
            </tr>
            <tr>
                <td align="center">
				<?php if($cmbWaktu=='Tahunan'){?>
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
								$sql = "SELECT b_ms_cara_keluar.id, b_ms_cara_keluar.nama FROM b_ms_cara_keluar";
								$rs = mysql_query($sql);
								$no = 1;
								$tot1=0;
								$tot2=0;
								while($rw = mysql_fetch_array($rs))
								{
									
									$sql1="SELECT COUNT(b_pasien_keluar.pelayanan_id) AS jml FROM b_pasien_keluar INNER JOIN b_ms_cara_keluar ON b_ms_cara_keluar.nama = b_pasien_keluar.cara_keluar INNER JOIN b_pelayanan ON b_pasien_keluar.pelayanan_id = b_pelayanan.id WHERE b_ms_cara_keluar.id = '".$rw['id']."' $fTmp AND DATE_FORMAT(b_pasien_keluar.tgl_act,'%Y')=".($thn-1);    
									if($bln!=''){
										$sql1.=" AND MONTH(tgl)=$bln";
									}
									$rs1=mysql_query($sql1);
									$rw1=mysql_fetch_array($rs1);
									
									$sql2="SELECT COUNT(b_pasien_keluar.pelayanan_id) AS jml FROM b_pasien_keluar INNER JOIN b_ms_cara_keluar ON b_ms_cara_keluar.nama = b_pasien_keluar.cara_keluar INNER JOIN b_pelayanan ON b_pasien_keluar.pelayanan_id = b_pelayanan.id WHERE b_ms_cara_keluar.id = '".$rw['id']."' $fTmp AND DATE_FORMAT(b_pasien_keluar.tgl_act,'%Y')=$thn";   
									if($bln!=''){
										$sql2.=" AND MONTH(b_pasien_keluar.tgl_act)=$bln";
									}
									$rs2=mysql_query($sql2);
									$rw2=mysql_fetch_array($rs2);
						?>
                        <tr>
                            <td class="tblIsi" align="center" width="5%"><?php echo $no;?></td>
                            <td class="tblIsi" style="text-transform:uppercase;" width="35%" height="25"><?php echo $rw['nama']?></td>
                            <td class="tblIsi" width="15%" style="text-align:right; padding-right:15px;"><?php echo number_format($rw1['jml'],0,",",".");?></td>
                            <td class="tblIsi" width="15%" style="text-align:right; padding-right:15px;"><?php echo number_format($rw2['jml'],0,",",".");?></td>
                            <td class="tblIsi" width="10%" style="text-align:center; color:<?php if($rw1['jml']<$rw2['jml']){ echo '#FF0000';}else if($rw1['jml']>$rw2['jml']){ echo '#0000FF';}else{ echo '#FF00FF';}?>">
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
                            <td class="tblIsiKn" width="20%" style="text-align:right; padding-right:15px;"><?php  if($selisih==0) echo "0"; else if($rw1['jml']==0) echo number_format($selisih*100,0,",","."); else echo number_format($selisih/$rw1['jml']*100,2,",",".");?>&nbsp;%</td>                            
                        </tr>
						<?php
								$no++;
								$tot1=$tot1 + $rw1['jml'];
								$tot2=$tot2 + $rw2['jml'];
								}
						?>
                        <tr>
                            <td class="tblIsi" colspan="2" align="right" height="25" style="background-color:#FFFF00; font-weight:bold;">JUMLAH&nbsp;</td>
                            <td class="tblIsi" style="background-color:#FFFF00; font-weight:bold; text-align:right; padding-right:15px;"><?php echo number_format($tot1,0,",",".");?></td>
                            <td class="tblIsi" style="background-color:#FFFF00; font-weight:bold; text-align:right; padding-right:15px;"><?php echo number_format($tot2,0,",",".");?></td>
                             <td class="tblIsi" style="background-color:#FFFF00; font-weight:bold; text-align:center; color:<?php if($tot1<$tot2){ echo '#FF0000';}else if($tot1>$tot2){ echo '#0000FF';}else{ echo '#FF00FF';}?>">
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
                            <td class="tblIsiKn" style="background-color:#FFFF00; font-weight:bold; text-align:right; padding-right:15px;"><?php  if($tot1=="0") echo number_format($selisih*100,0,",","."); else echo number_format($selisih/$tot1*100,2,",",".");?>&nbsp;%</td>    
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
								$qBln = "SELECT DATE_FORMAT(b_pasien_keluar.tgl_act,'%m') AS bulan FROM b_kunjungan INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id INNER JOIN b_pasien_keluar ON b_pasien_keluar.pelayanan_id = b_pelayanan.id WHERE $fTmp AND DATE_FORMAT(b_pasien_keluar.tgl_act,'%Y')='$thn' GROUP BY DATE_FORMAT(b_pasien_keluar.tgl_act,'%m') ORDER BY DATE_FORMAT(b_pasien_keluar.tgl_act,'%m')"; 
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
								$sqlCr = "SELECT b_ms_cara_keluar.id, b_ms_cara_keluar.nama FROM b_ms_cara_keluar";
								$rsCr = mysql_query($sqlCr);
								$no = 1;
								while($rwCr = mysql_fetch_array($rsCr))
								{
						?>
						<tr>
							<td class="tblIsi" align="center"><?php echo $no;?></td>
							<td class="tblIsi" style="text-transform:uppercase;" height="25">&nbsp;<?php echo $rwCr['nama'];?></td>
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
							<td class="tblIsi" colspan="2" align="right" height="25" style="background-color:#FFFF00; font-weight:bold;">JUMLAH&nbsp;</td>
							<?php
								for($i=0; $i<$col; $i++){
							?>
							<td class="tblIsiKn" style="background-color:#FFFF00; font-weight:bold; text-align:center;"><?php echo $jml[$i]?></td>
							<?php	}	?>
						</tr>
					</table>
				<button style="float:right;" onClick="showGrafik('bulanan');">Lihat Grafik</button>
				</div>
				<?php } ?>
                </td>
            </tr>
        </table>
		<script>
			function showGrafik(par){
				window.open('grafik_paska.php?periode='+par+'&thn=<?php echo $thn;?>'+'&tmp=<?php echo $wUn['nama']?>'+'&tmpLay=<?php echo $tmpLay?>'+'&jnsLay=<?php echo $jnsLay?>','_blank');
			}
		</script>
    </body>
</html>