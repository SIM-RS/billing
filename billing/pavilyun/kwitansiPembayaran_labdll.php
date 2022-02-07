<?php
session_start();
include("../sesi.php");
?>
<title>.: Pembagian Pembayaran :.</title>
<?php
		include("../koneksi/konek.php");
		$date_now=gmdate('d-m-Y',mktime(date('H')+7));
				
		$namaBulan = array ('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');		
		$judul = array (58=>'LAB PK',59=>'LAB TA',61=>'RADIOLOGI',27=>'PERAWAT RAWAT INAP',19=>'GIZI');
		$unit = $_REQUEST['unit'];
		$tglAwal = $_REQUEST['tglAwal'];
		$tglAkhir = $_REQUEST['tglAkhir'];
		
		if($unit=='27'){
			$plus="AND t.user_id = '581' AND (u.parent_id='$unit' OR n.parent_id='50')";
		}else{
			$plus="AND (u.id='$unit' AND n.parent_id='50')";
		}
		
		switch($unit){
			case '58'://LAB PK
				$persen_tindakan=25/100;
				$persen_fee=77/100;
				$persen_kebersamaan=6/100;
				$persen_managemen=17/100;
				break;
			case '59'://LAB PA
				$persen_tindakan=40/100;
				$persen_fee=77/100;
				$persen_kebersamaan=6/100;
				$persen_managemen=17/100;
				break;
			case '61'://RADIOLOGI
				$persen_tindakan=30/100;
				$persen_fee=77/100;
				$persen_kebersamaan=6/100;
				$persen_managemen=17/100;
				break;
			case '27'://PERAWAT RAWAT INAP
				$persen_tindakan=100/100;
				$persen_fee=74/100;
				$persen_kebersamaan=6/100;
				$persen_managemen=20/100;
				break;
			case '19'://GIZI
				$persen_tindakan=20/100;
				$persen_fee=76/100;
				$persen_kebersamaan=6/100;
				$persen_managemen=18/100;
				break;
		}
?>
<style>
	.jdl
	{
		text-align:center;
		border-top:1px solid #000000;
		border-bottom:1px solid #000000;
		border-left:1px solid #000000;
		font-weight:bold;
	}
	.jdlKn
	{
		text-align:center;
		border-top:1px solid #000000;
		border-bottom:1px solid #000000;
		border-left:1px solid #000000;
		font-weight:bold;
		border-right:1px solid #000000;
	}
	.isi
	{
		border-bottom:1px solid #000000;
		border-left:1px solid #000000;
		padding:1px 1px 1px 2px;
	}
	.isiKn
	{
		border-bottom:1px solid #000000;
		border-left:1px solid #000000;
		border-right:1px solid #000000;
	}
</style>
<table width="800" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td colspan="2"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
	</tr>
    <tr>
		<td colspan="2" height="70" valign="top" style="font-size:14px; text-align:center; text-transform:uppercase; font-weight:bold;">Pembagian jasa tindakan<br><?php echo $judul[$unit];?> </td>
	</tr>
	<tr>
		<td width="50%" height="30" style="padding-left:20px; font-weight:bold;"></td>
		<td width="50%" style="padding-right:20px; text-align:right; font-weight:bold;">Per Tanggal: <?php echo $tglAkhir;?></td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr>
					<td class="jdl" height="28" width="3%">NO</td>
					<td class="jdl" width="20%" >NAMA PASIEN</td>
					<td class="jdl" width="7%" >NO RM</td>
					<td class="jdl" width="10%" >KSO</td>
					<td class="jdl" width="7%" >MRS</td>
					<td class="jdl" width="7%" >KRS</td>
					<td class="jdl" width="7%" >FEE OF SERVICE</td>					
				     <td class="jdl" width="10%">KEBERSAMAAN</td>
					<td class="jdlKn" width="10%">MANAGEMEN</td>				
                                     
				</tr>
				<?php
				/*$sql="SELECT k.id,p.no_rm,p.nama as pasien,o.nama as kso,k.tgl,date(k.tgl_pulang) as tgl_pulang,
				SUM(t.biaya) AS tindakan        
				FROM b_ms_pasien p
				INNER JOIN b_kunjungan k ON k.pasien_id=p.id
				INNER JOIN b_pelayanan l ON l.kunjungan_id = k.id
				INNER JOIN b_tindakan t ON t.pelayanan_id = l.id
				INNER JOIN b_ms_tindakan_kelas tk ON tk.id=t.ms_tindakan_kelas_id
				INNER JOIN b_ms_tindakan mt ON mt.id = tk.ms_tindakan_id
				INNER JOIN b_ms_unit u ON u.id=l.unit_id
				INNER JOIN b_ms_unit n ON n.id=l.unit_id_asal
				INNER JOIN b_ms_kso o ON o.id=t.kso_id				
				WHERE t.tgl_bayar_pav ='".tglSQL($tglAkhir)."'  AND mt.klasifikasi_id<>'13' AND mt.klasifikasi_id<>'11' AND mt.klasifikasi_id<>'14' $plus
				AND t.tgl_bayar_pav IS NOT NULL
				GROUP BY k.id  order by pasien";*/
				
				$sql="SELECT * FROM (SELECT t2.id,p.no_rm,p.nama AS pasien,o.nama AS kso,t2.tgl,t2.tgl_pulang,SUM(t2.tindakan) AS tindakan FROM 
				(SELECT t1.id,t1.tgl_pulang,t1.pasien_id,t1.kso_id,t1.tgl,t1.ms_tindakan_kelas_id,SUM(t1.tindakan) AS tindakan FROM 
				(SELECT k.id,k.tgl,DATE(k.tgl_pulang) AS tgl_pulang,l.pasien_id,l.kso_id,t.ms_tindakan_kelas_id,SUM(t.biaya) AS tindakan		
				FROM b_kunjungan k 
				INNER JOIN b_pelayanan l ON l.kunjungan_id = k.id
				INNER JOIN b_tindakan t ON t.pelayanan_id = l.id
				INNER JOIN b_ms_unit u ON u.id=l.unit_id
				INNER JOIN b_ms_unit n ON n.id=l.unit_id_asal
				INNER JOIN (SELECT COUNT(l.id) AS jml,k.id FROM b_kunjungan k
					 INNER JOIN b_pelayanan l ON l.kunjungan_id=k.id
					 INNER JOIN b_ms_unit u ON u.id=l.unit_id
					 INNER JOIN b_ms_unit n ON n.id=l.unit_id_asal
					 WHERE (u.parent_id=50 OR n.parent_id=50) AND (l.tgl BETWEEN '".tglSQL($tglAwal)."' AND '".tglSQL($tglAkhir)."') GROUP BY k.id) AS c ON c.id=k.id
				WHERE t.tgl_bayar_pav ='".tglSQL($tglAkhir)."' $plus
				AND t.tgl_bayar_pav IS NOT NULL ".$filter." GROUP BY t.id) AS t1
				INNER JOIN b_ms_tindakan_kelas tk ON tk.id=t1.ms_tindakan_kelas_id
				INNER JOIN b_ms_tindakan mt ON mt.id = tk.ms_tindakan_id
				WHERE mt.klasifikasi_id<>'13' AND mt.klasifikasi_id<>'11' AND mt.klasifikasi_id<>'14'
				GROUP BY t1.pasien_id) AS t2
				INNER JOIN b_ms_kso o ON o.id=t2.kso_id	    
				INNER JOIN b_ms_pasien p ON p.id=t2.pasien_id
				GROUP BY t2.id) AS t3 ORDER BY pasien";
				
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				$jml_fee = 0;
				$jml_kebersamaan = 0;
				$jml_asisten = 0;				
				while($rw=mysql_fetch_array($rs)){
				$i++;
				?>
				<tr>
					<td class="isi" align="center"><?php echo $i;?></td>
					<td class="isi" align="left"><?php echo $rw['pasien'];?>&nbsp;</td>
					<td class="isi" align="center"><?php echo $rw['no_rm'];?>&nbsp;</td>
					<td class="isi" align="center"><?php echo $rw['kso'];?>&nbsp;</td>
					<td class="isi" align="center"><?php echo tglSQL($rw['tgl']);?>&nbsp;</td>
					<td class="isi" align="center"><?php echo tglSQL($rw['tgl_pulang']);?>&nbsp;</td>
					<td class="isi" align="right">
						<?php						
						  $fee=($rw["tindakan"]*$persen_tindakan)*$persen_fee;								
                                echo number_format($fee,0,'','.'); $jml_fee+=$fee;
                            ?>&nbsp;
					</td>
					<td class="isi" align="right">
					   <?php						
						  $kebersamaan=($rw["tindakan"]*$persen_tindakan)*$persen_kebersamaan;								
                                echo number_format($kebersamaan,0,'','.'); $jml_kebersamaan+=$kebersamaan;
                            ?>&nbsp;
					</td>
					<td class="isiKn" align="right">
                            <?php						
						  $managemen=($rw["tindakan"]*$persen_tindakan)*$persen_managemen;								
                                echo number_format($managemen,0,'','.'); $jml_managemen+=$managemen;
                            ?>&nbsp;
                         </td>		
				</tr>
				<?php
				}
				?>
				<tr>
					<td colspan="6" class="isi" align="right" height="25" style="font-weight:bold;">TOTAL&nbsp;</td>
					<td class="isi" align="center" style="font-weight:bold;"><?php echo $jml_fee;?>&nbsp;</td>
					<td class="isi" align="right" style="font-weight:bold;"><?php echo number_format($jml_kebersamaan,0,'','.');?>&nbsp;</td>
					<td class="isiKn" align="right" style="font-weight:bold;"><?php echo number_format($jml_managemen,0,'','.');?>&nbsp;</td>					
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td style="text-align:center;" height="100" valign="top"><?=$kotaRS?>, <?php echo $date_now;?><br />Penerima,</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>
