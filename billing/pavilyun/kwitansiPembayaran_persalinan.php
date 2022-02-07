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
		$bln = $_REQUEST['bln'];
		$thn = $_REQUEST['thn'];
		$namaBulan = array ('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
		if($jenis=='6'){
                    $ifJenis="AND (mt.klasifikasi_id<>'11' AND mt.klasifikasi_id<>'13' AND mt.klasifikasi_id<>'14') AND mt.nama LIKE 'partus%' AND (t.user_id NOT IN (8,9,10,585)) AND (n.parent_id='50' OR u.parent_id='50')";
				$judul = 'TINDAKAN PERSALINAN NORMAL & ABNORMAL TANPA DOKTER ANAK';			
                }
		else if($jenis=='7'){
				$ifJenis="AND (mt.klasifikasi_id<>'11' AND mt.klasifikasi_id<>'13' AND mt.klasifikasi_id<>'14') AND (mt.nama LIKE 'partus%' AND mt.nama NOT LIKE '%normal') AND (t.user_id IN (8,9,10,585)) AND (n.parent_id='50' OR u.parent_id='50')";
		    $judul = 'TINDAKAN PERSALINAN ABNORMAL DENGAN DOKTER ANAK';
            $sql_spe = "SELECT spesialisasi FROM b_ms_pegawai WHERE spesialisasi LIKE '%ANAK%' AND id='$dokter'";
				$rs_spe = mysql_query($sql_spe);
                if(mysql_num_rows($rs_spe)>0){
                    $spesialisasi='anak';
                }
			$sql_spe = "SELECT spesialisasi FROM b_ms_pegawai WHERE spesialisasi LIKE '%OBGYN%' AND id='$dokter'";
				$rs_spe = mysql_query($sql_spe);
                if(mysql_num_rows($rs_spe)>0){
                    $spesialisasi='obgyn';
                }
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
		<td colspan="2" height="70" valign="top" style="font-size:14px; text-align:center; text-transform:uppercase; font-weight:bold;">kwitansi pembayaran<br>jasa <?php echo $judul;?></td>
	</tr>
	<tr>
		<td width="50%" height="30" style="padding-left:20px; font-weight:bold;">Dokter : <?php echo $rwDok['nama'];?></td>
		<td width="50%" style="padding-right:20px; text-align:right; font-weight:bold;">Periode : <?php echo $namaBulan[$bln]." ".$thn;?></td>
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
				$sql="SELECT t1.id,t1.no_rm,t1.pasien,t1.kso,t1.tgl,t1.tgl_pulang,sum(t1.biaya) as nilai,count(t1.jml) as jml
				From (SELECT k.id,p.no_rm,p.nama as pasien,o.nama as kso,k.tgl,date(k.tgl_pulang) as tgl_pulang,t.biaya,t.id as jml
				FROM b_ms_pasien p
				INNER JOIN b_kunjungan k ON k.pasien_id=p.id
				INNER JOIN b_pelayanan l ON l.kunjungan_id = k.id
				INNER JOIN b_tindakan t ON t.pelayanan_id = l.id
				INNER JOIN b_ms_tindakan_kelas tk ON tk.id=t.ms_tindakan_kelas_id
				INNER JOIN b_ms_tindakan mt ON mt.id = tk.ms_tindakan_id
				INNER JOIN b_ms_unit u ON u.id=l.unit_id
				INNER JOIN b_ms_unit n ON n.id=l.unit_id_asal
				INNER JOIN b_ms_kso o ON o.id=t.kso_id				
				INNER JOIN b_ms_pegawai g ON g.id=t.user_id				
				WHERE (t.user_id = '$dokter') AND t.tgl_bayar_pav ='".tglSQL($tglAkhir)."'  
				AND t.tgl_bayar_pav IS NOT NULL $ifJenis GROUP BY t.id  order by pasien) as t1 group by t1.pasien";
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
						if($jenis=='6'){
								$nilai=80/100*$rw['nilai'];
                                $persen_fee=78/100;
						}elseif($jenis=='7'){
								$nilai=80/100*$rw['nilai'];
                                if($spesialisasi=='anak'){
                                    $persen_fee=(66/100);
                                }else if($spesialisasi=='obgyn'){
                                    $persen_fee=(12/100);  
                                }
						}
						echo number_format($nilai,0,'','.'); $jml_nilai+=$nilai; ?>&nbsp;
					</td>
					<td class="isi" align="right"><?php $feeService=($nilai*$persen_fee); echo number_format($feeService,0,'','.'); $jml_fee+=$feeService;?>&nbsp;</td>
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
		<td>&nbsp;</td>
	</tr>
</table>
