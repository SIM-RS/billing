<?php
session_start();
include("../sesi.php");
?>
<title>.: Kwitansi Pembayaran :.</title>
<?php
		include("../koneksi/konek.php");
		$date_now=gmdate('d-m-Y',mktime(date('H')+7));
		
		$jenis = $_REQUEST['jenis'];
		$dokter = $_REQUEST['dokter'];
		$tglAwal = $_REQUEST['tglAwal'];
		$tglAkhir = $_REQUEST['tglAkhir'];
		
		$namaBulan = array ('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
		if($jenis=='0'){
			$ifJenis = "WHERE mt.klasifikasi_id='11'";
			$ifTitle1 = "JASA<br>RUMAH SAKIT";
			$ifTitle2 = "JASA<br>PERAWAT";
			$judul = 'PELAYANAN DOKTER POLI PAVILYUN';
		}
		elseif($jenis=='1'){
			$ifJenis = "WHERE (mt.klasifikasi_id='13' OR mt.klasifikasi_id='14') ";
			$ifTitle1 = "FEE FOR<br>SERVICE";
			$ifTitle2 = "Pph Ps 21<br>2.5%";
			$judul = 'KONSUL/VISITE DOKTER PAVILYUN';
		}
		elseif($jenis=='2'){
			$ifJenis="WHERE (mt.klasifikasi_id<>'11' OR mt.klasifikasi_id<>'13' OR mt.klasifikasi_id<>'14')";
			$judul = 'TINDAKAN';
		}
                
                $sDok="SELECT nama FROM b_ms_pegawai WHERE id='$dokter'";
		$rsDok=mysql_query($sDok);
		$rwDok=mysql_fetch_array($rsDok);
		
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
		<td colspan="2" height="70" valign="middle" style="font-size:14px; text-align:center; text-transform:uppercase; font-weight:bold;">kwitansi pembayaran<br>jasa <?php echo $judul;?></td>
	</tr>
	<tr>
		<td width="50%" height="30" style="padding-left:20px; font-weight:bold;">Dokter : <?php echo $rwDok['nama'];?></td>
		<td width="50%" style="padding-right:20px; text-align:right; font-weight:bold;">Per Tanggal: <?php echo $tglAkhir;?></td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr>
					<td class="jdl" height="28" width="3%">NO</td>
					<td class="jdl" width="18%">NAMA PASIEN</td>
					<td class="jdl" width="7%">NO RM</td>
					<td class="jdl" width="9%">KSO</td>
					<td class="jdl" width="7%" style="text-align:center;<?php echo $jenis==0?"display:none;":'';?>">MRS</td>
					<td class="jdl" width="7%" style="text-align:center;<?php echo $jenis==0?"display:none;":'';?>">KRS</td>
					<td class="jdl" width="5%">JML KUNJ.</td>
					<td class="jdl" width="11%">NILAI JASA</td>
					<td class="jdl" width="11%"><?php echo $ifTitle1;?></td>
					<td class="jdl" width="11%"><?php echo $ifTitle2;?></td>
					<td class="jdlKn" width="11%">DITERIMA BERSIH</td>
				</tr>
				<?php
				if($jenis==0){
					$sql="
						SELECT * FROM (SELECT t2.id,t2.pasien_id, p.no_rm, p.nama AS pasien, o.nama AS kso,t2.tgl, t2.tgl_pulang, SUM(t2.nilai) AS nilai, SUM(t2.jml) AS jml
						FROM (
						SELECT t1.id,t1.pasien_id,t1.kso_id,t1.tgl, t1.tgl_pulang, SUM(t1.nilai) AS nilai, SUM(t1.jml) AS jml
						FROM (SELECT k.id,k.pasien_id,l.unit_id,l.unit_id_asal,k.tgl,DATE(k.tgl_pulang) AS tgl_pulang,SUM(t.biaya) AS nilai,COUNT(t.biaya) AS jml,
						t.ms_tindakan_kelas_id,t.kso_id
						FROM b_kunjungan k
						INNER JOIN b_pelayanan l ON l.kunjungan_id = k.id
						INNER JOIN b_tindakan t ON t.pelayanan_id = l.id
						INNER JOIN (SELECT COUNT(l.id) AS jml,k.id FROM b_kunjungan k
									INNER JOIN b_pelayanan l ON l.kunjungan_id=k.id
									INNER JOIN b_ms_unit u ON u.id=l.unit_id
									INNER JOIN b_ms_unit n ON n.id=l.unit_id_asal
									WHERE (u.parent_id=50 OR n.parent_id=50) AND (l.tgl BETWEEN '".tglSQL($tglAwal)."' AND '".tglSQL($tglAkhir)."') GROUP BY k.id) AS c ON c.id=k.id
						WHERE t.user_id = '$dokter' AND t.tgl_bayar_pav ='".tglSQL($tglAkhir)."'   
						AND t.tgl_bayar_pav IS NOT NULL AND (c.jml>0) GROUP BY t.id) AS t1
						INNER JOIN b_ms_tindakan_kelas tk ON tk.id=t1.ms_tindakan_kelas_id
						INNER JOIN b_ms_tindakan mt ON mt.id = tk.ms_tindakan_id
						INNER JOIN b_ms_unit u ON u.id=t1.unit_id
						INNER JOIN b_ms_unit n ON n.id=t1.unit_id_asal $ifJenis  
						GROUP BY t1.ms_tindakan_kelas_id,t1.pasien_id) AS t2
						INNER JOIN b_ms_pasien p ON p.id=t2.pasien_id
						INNER JOIN b_ms_kso o ON o.id=t2.kso_id
						GROUP BY t2.id) AS t3 ORDER BY pasien";
					
				}else if($jenis==1){
						$sql="SELECT * FROM (SELECT t2.id,t2.pasien_id, p.no_rm, p.nama AS pasien, o.nama AS kso,t2.tgl, t2.tgl_pulang, SUM(t2.nilai) AS nilai, SUM(t2.jml) AS jml
						FROM (
						SELECT t1.id,t1.pasien_id,t1.kso_id,t1.tgl, t1.tgl_pulang, SUM(t1.nilai) AS nilai, SUM(t1.jml) AS jml
						FROM (SELECT k.id,k.pasien_id,l.unit_id,l.unit_id_asal,k.tgl,DATE(k.tgl_pulang) AS tgl_pulang,SUM(t.biaya_pasien+t.biaya_kso) AS nilai,COUNT(t.biaya_pasien) AS jml,
						t.ms_tindakan_kelas_id,t.kso_id
						FROM b_kunjungan k
						INNER JOIN b_pelayanan l ON l.kunjungan_id = k.id
						INNER JOIN b_tindakan t ON t.pelayanan_id = l.id
						INNER JOIN (SELECT COUNT(l.id) AS jml,k.id FROM b_kunjungan k
									INNER JOIN b_pelayanan l ON l.kunjungan_id=k.id
									INNER JOIN b_ms_unit u ON u.id=l.unit_id
									INNER JOIN b_ms_unit n ON n.id=l.unit_id_asal
									WHERE (u.parent_id=50 OR n.parent_id=50) AND (l.tgl BETWEEN '".tglSQL($tglAwal)."' AND '".tglSQL($tglAkhir)."') GROUP BY k.id) AS c ON c.id=k.id
						WHERE t.user_id = '$dokter' AND t.tgl_bayar_pav ='".tglSQL($tglAkhir)."'   
						AND t.tgl_bayar_pav IS NOT NULL AND (c.jml>0) GROUP BY t.id) AS t1
						INNER JOIN b_ms_tindakan_kelas tk ON tk.id=t1.ms_tindakan_kelas_id
						INNER JOIN b_ms_tindakan mt ON mt.id = tk.ms_tindakan_id
						INNER JOIN b_ms_unit u ON u.id=t1.unit_id
						INNER JOIN b_ms_unit n ON n.id=t1.unit_id_asal $ifJenis  
						GROUP BY t1.ms_tindakan_kelas_id,t1.pasien_id) AS t2
						INNER JOIN b_ms_pasien p ON p.id=t2.pasien_id
						INNER JOIN b_ms_kso o ON o.id=t2.kso_id
						GROUP BY t2.id) AS t3 ORDER BY pasien";			
				}
				//echo $sql."<br>";
				
				$rs=mysql_query($sql);echo mysql_error();
				$jmltitle1 = 0;
				$jmltitle2 = 0;
				$jmlbersih = 0;
				$jml_jml = 0;
				$jml_nilai = 0;
				//$jml_fee = 0;
				//$jml_pph = 0;
				//$jml_tot = 0;
				while($rw=mysql_fetch_array($rs)){
					$i++;
					if($jenis==0){
						$title1 = $rw['nilai']*15/100;
						$title2 = ($rw['nilai'] - $title1)*5/100;
						$bersih = ($rw['nilai'] - $title1)*95/100;
						$jmltitle1 += $title1;
						$jmltitle2 += $title2;
						$jmlbersih += $bersih;
					}
					else if($jenis==1){
						$title1 = $rw['nilai']*84/100;
						$title2 = $title1*2.5/100;
						$bersih = $title1-$title2;
						$jmltitle1 += $title1;
						$jmltitle2 += $title2;
						$jmlbersih += $bersih;
					}
				?>
				<tr>
					<td class="isi" align="center"><?php echo $i;?></td>
					<td class="isi" align="left" style="text-transform:uppercase;font-family:Arial, Helvetica, sans-serif;font-weight:bold; font-size:8px;"><?php echo $rw['pasien'];?>&nbsp;</td>
					<td class="isi" align="center" ><?php echo $rw['no_rm'];?>&nbsp;</td>
					<td class="isi" align="center" style="text-transform:uppercase;font-family:Arial, Helvetica, sans-serif;font-weight:bold; font-size:8px;"><?php echo $rw['kso'];?>&nbsp;</td>
					<td class="isi" style="text-align:center;<?php echo $jenis==0?"display:none;":'';?>"><?php echo tglSQL($rw['tgl']);?>&nbsp;</td>
					<td class="isi" style="text-align:center;<?php echo $jenis==0?"display:none;":'';?>"><?php echo tglSQL($rw['tgl_pulang']);?>&nbsp;</td>
					<td class="isi" align="center"><?php echo $rw['jml']; $jml_jml+=$rw['jml'];?>&nbsp;</td>
					<td class="isi" align="right"><?php echo number_format($rw['nilai'],0,'','.'); $jml_nilai+=$rw['nilai'];?>&nbsp;</td>
					<td class="isi" align="right"><?php echo number_format($title1,0,",",".")?>&nbsp;</td>
					<td class="isi" align="right"><?php echo number_format($title2,0,",",".")?>&nbsp;</td>
					<td class="isiKn" align="right"><?php echo number_format($bersih,0,",",".")?>&nbsp;</td>
				</tr>
				<?php
				}
				?>
				<tr>
					<td height="25" colspan="4" align="right" class="isi" style="font-weight:bold;">TOTAL&nbsp;</td>
					<td height="25" colspan="2" align="right" style="text-align:center; border-bottom:1px solid #000000;<?php echo $jenis==0?"display:none;":'';?>">&nbsp;</td>
					<td class="isi" align="center" style="font-weight:bold;"><?php echo $jml_jml;?>&nbsp;</td>
					<td class="isi" align="right" style="font-weight:bold;"><?php echo number_format($jml_nilai,0,'','.');?>&nbsp;</td>
					<td class="isi" align="right" style="font-weight:bold;"><?php echo number_format($jmltitle1,0,'','.');?>&nbsp;</td>
					<td class="isi" align="right" style="font-weight:bold;"><?php echo number_format($jmltitle2,0,'','.');?>&nbsp;</td>
					<td class="isiKn" align="right" style="font-weight:bold;"><?php echo number_format($jmlbersih,0,'','.');?>&nbsp;</td>
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
		<td style="text-align:center; text-transform:uppercase; font-weight:bold;"><?php echo $rwDok['nama'];?></td>
	</tr>
</table>
