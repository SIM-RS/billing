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
		if($jenis=='2'){
                    $ifJenis="WHERE (mt.klasifikasi_id<>'11' AND mt.klasifikasi_id<>'13' AND mt.klasifikasi_id<>'14') AND (u.id<>58 AND u.id<>59 AND u.id<>61 AND u.id<>19 AND u.parent_id<>27) AND (u.parent_id='62' OR u.id='47')";
				$judul = 'TINDAKAN OPERATIF';
				$sql_spe = "SELECT spesialisasi_id FROM b_ms_pegawai WHERE id='$dokter'";
				$rs_spe = mysql_query($sql_spe);
				$rw_spe = mysql_fetch_array($rs_spe);
				if($rw_spe['spesialisasi_id']=='42'){
						$spesialisasi='anastesi';
				}else{
						$spesialisasi='operator';
				}
                }
		else if($jenis=='3'){
				$ifJenis="WHERE (mt.klasifikasi_id<>'11' AND mt.klasifikasi_id<>'13' AND mt.klasifikasi_id<>'14') AND (u.id<>58 AND u.id<>59 AND u.id<>61 AND u.id<>19 AND u.parent_id<>27) AND g.spesialisasi_id <> 0 AND u.parent_id<>'62' AND u.id<>'47' ";
		    $judul = 'TINDAKAN NON OPERATIF';
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
		<td colspan="2" height="70" valign="top" style="font-size:14px; text-align:center; text-transform:uppercase; font-weight:bold;">kwitansi pembayaran<br>jasa <?php echo $judul;?></td>
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
					<td class="jdl" width="20%">NAMA PASIEN</td>
					<td class="jdl" width="7%">NO RM</td>
					<td class="jdl" width="10%">KSO</td>
					<td class="jdl" width="7%">MRS</td>
					<td class="jdl" width="7%">KRS</td>
					<td class="jdl" width="7%">JML TINDAKAN</td>
					<td class="jdl" width="10%">NILAI JASA TINDAKAN</td>
					<td class="jdl" width="10%">FEE SERVICE</td>
					<td class="jdl" width="10%">Pph 21 (2.5%)</td>
					<td class="jdlKn" width="15%">DITERIMA</td>
				</tr>				
				<?php
				$sql="
                SELECT * FROM (SELECT t2.id,t2.pasien_id, p.no_rm, p.nama AS pasien, o.nama AS kso,t2.tgl, t2.tgl_pulang, SUM(t2.nilai) AS nilai, SUM(t2.jml) AS jml
						FROM (
						SELECT t1.id,t1.pasien_id,t1.kso_id,t1.tgl, t1.tgl_pulang, SUM(t1.nilai) AS nilai, SUM(t1.jml) AS jml
						FROM (SELECT k.id,k.pasien_id,l.unit_id,l.unit_id_asal,k.tgl,DATE(k.tgl_pulang) AS tgl_pulang,SUM(t.biaya_pasien+t.biaya_kso) AS nilai,COUNT(t.biaya_pasien) AS jml,
						t.ms_tindakan_kelas_id,t.kso_id,t.user_id
						FROM b_kunjungan k
						INNER JOIN b_pelayanan l ON l.kunjungan_id = k.id
						INNER JOIN b_tindakan t ON t.pelayanan_id = l.id
                        LEFT JOIN b_tindakan_dokter_anastesi da ON da.tindakan_id=t.id
						INNER JOIN (SELECT COUNT(l.id) AS jml,k.id FROM b_kunjungan k
									INNER JOIN b_pelayanan l ON l.kunjungan_id=k.id
									INNER JOIN b_ms_unit u ON u.id=l.unit_id
									INNER JOIN b_ms_unit n ON n.id=l.unit_id_asal
									WHERE (u.parent_id=50 OR n.parent_id=50) AND (l.tgl BETWEEN '".tglSQL($tglAwal)."' AND '".tglSQL($tglAkhir)."') GROUP BY k.id) AS c ON c.id=k.id
						WHERE (t.user_id = '$dokter' OR da.dokter_id='$dokter') AND t.tgl_bayar_pav ='".tglSQL($tglAkhir)."'   
						AND t.tgl_bayar_pav IS NOT NULL AND (c.jml>0) GROUP BY t.id) AS t1
						INNER JOIN b_ms_tindakan_kelas tk ON tk.id=t1.ms_tindakan_kelas_id
						INNER JOIN b_ms_tindakan mt ON mt.id = tk.ms_tindakan_id
						INNER JOIN b_ms_unit u ON u.id=t1.unit_id
						INNER JOIN b_ms_unit n ON n.id=t1.unit_id_asal
                        INNER JOIN b_ms_pegawai g ON g.id=t1.user_id $ifJenis  
						GROUP BY t1.ms_tindakan_kelas_id,t1.pasien_id) AS t2
						INNER JOIN b_ms_pasien p ON p.id=t2.pasien_id
						INNER JOIN b_ms_kso o ON o.id=t2.kso_id
						GROUP BY t2.id) AS t3 ORDER BY pasien";
                
                /*"SELECT t1.id,t1.pasien_id, p.no_rm, p.nama as pasien, o.nama as kso,t1.tgl, t1.tgl_pulang, SUM(t1.nilai) AS nilai, SUM(t1.jml) as jml
					FROM (SELECT k.id,k.pasien_id,l.unit_id,l.unit_id_asal,k.tgl,date(k.tgl_pulang) as tgl_pulang,SUM(t.bayar_pasien) as nilai,count(t.bayar_pasien) as jml,
					t.ms_tindakan_kelas_id,t.kso_id,t.user_id
					FROM b_kunjungan k
					INNER JOIN b_pelayanan l ON l.kunjungan_id = k.id
					INNER JOIN b_tindakan t ON t.pelayanan_id = l.id
                    LEFT JOIN b_tindakan_dokter_anastesi da ON da.tindakan_id=t.id
					INNER JOIN (SELECT COUNT(l.id) AS jml,k.id FROM b_kunjungan k
								INNER JOIN b_pelayanan l ON l.kunjungan_id=k.id
								INNER JOIN b_ms_unit u ON u.id=l.unit_id
								INNER JOIN b_ms_unit n ON n.id=l.unit_id_asal
								WHERE (u.parent_id=50 OR n.parent_id=50) AND (l.tgl BETWEEN '".tglSQL($tglAwal)."' AND '".tglSQL($tglAkhir)."') GROUP BY k.id) AS c ON c.id=k.id
					WHERE (t.user_id = '$dokter' OR da.dokter_id='$dokter') AND t.tgl_bayar_pav ='".tglSQL($tglAkhir)."'   
					AND t.tgl_bayar_pav IS NOT NULL AND (c.jml>0) GROUP BY k.id  ) AS t1
					INNER JOIN b_ms_pasien p ON p.id=t1.pasien_id
					INNER JOIN b_ms_tindakan_kelas tk ON tk.id=t1.ms_tindakan_kelas_id
					INNER JOIN b_ms_tindakan mt ON mt.id = tk.ms_tindakan_id
					INNER JOIN b_ms_unit u ON u.id=t1.unit_id
					INNER JOIN b_ms_unit n ON n.id=t1.unit_id_asal
                    INNER JOIN b_ms_pegawai g ON g.id=t1.user_id		
					INNER JOIN b_ms_kso o ON o.id=t1.kso_id $ifJenis 
					GROUP BY pasien_id order by pasien";*/
                   
                
				//echo $sql."<br>";
				$rs=mysql_query($sql);                
				$jml_jml = 0;
				$jml_nilai = 0;
				$jml_fee = 0;
				$jml_pph = 0;
				$jml_tot = 0;
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
					<td class="isi" align="center"><?php echo $rw['jml']; $jml_jml+=$rw['jml'];?>&nbsp;</td>
					<td class="isi" align="right">
						<?php
						if($jenis=='2'){
								$nilai=80/100*$rw['nilai'];
								if($spesialisasi=='anastesi'){
										$nilai=17/100*$nilai;
								}elseif($spesialisasi=='operator'){
										$nilai=57/100*$nilai;
								}
						}elseif($jenis=='3'){
								$nilai=70/100*$rw['nilai'];
						}
						echo number_format($nilai,0,'','.'); $jml_nilai+=$nilai; ?>&nbsp;
					</td>
					<td class="isi" align="right"><?php $feeService=($nilai*81/100); echo number_format($feeService,0,'','.'); $jml_fee+=$feeService;?>&nbsp;</td>
					<td class="isi" align="right"><?php $pph=($feeService*2.5/100);  echo number_format($pph,0,'','.'); $jml_pph+=$pph;?>&nbsp;</td>
					<td class="isiKn" align="right"><?php $tot=($feeService-$pph); echo number_format($tot,0,'','.'); $jml_tot+=$tot;?>&nbsp;</td>
				</tr>
				<?php
				}
				?>
				<tr>
					<td colspan="6" class="isi" align="right" height="25" style="font-weight:bold;">TOTAL&nbsp;</td>
					<td class="isi" align="center" style="font-weight:bold;"><?php echo $jml_jml;?>&nbsp;</td>
					<td class="isi" align="right" style="font-weight:bold;"><?php echo number_format($jml_nilai,0,'','.');?>&nbsp;</td>
					<td class="isi" align="right" style="font-weight:bold;"><?php echo number_format($jml_fee,0,'','.');?>&nbsp;</td>
					<td class="isi" align="right" style="font-weight:bold;"><?php echo number_format($jml_pph,0,'','.');?>&nbsp;</td>
					<td class="isiKn" align="right" style="font-weight:bold;"><?php echo number_format($jml_tot,0,'','.');?>&nbsp;</td>
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
