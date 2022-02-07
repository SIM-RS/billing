<?php
session_start();
include("../sesi.php");
?>
<title>.: Pembagian Pembayaran :.</title>
<?php
		include("../koneksi/konek.php");
		$date_now=gmdate('d-m-Y',mktime(date('H')+7));
		
		$jenis = $_REQUEST['jenis'];				
		$bln = $_REQUEST['bln'];
		$thn = $_REQUEST['thn'];
		$namaBulan = array ('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');		
            if($jenis=='4'){
                $ifJenis="AND (mt.klasifikasi_id<>'11' AND mt.klasifikasi_id<>'13' AND mt.klasifikasi_id<>'14') AND (u.parent_id='62' AND n.parent_id='50')";
				$judul = 'OPERATIF';				
            }
            else if($jenis=='5'){
				$ifJenis="AND (mt.klasifikasi_id<>'11' AND mt.klasifikasi_id<>'13' AND mt.klasifikasi_id<>'14') AND ((u.parent_id='50' AND g.spesialisasi_id <> 0) OR ( u.parent_id='68' AND n.parent_id='50' ))";
                $judul = 'NON OPERATIF';
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
		<td colspan="2" height="70" valign="top" style="font-size:14px; text-align:center; text-transform:uppercase; font-weight:bold;">Pembagian jasa tindakan<br><?php echo $judul;?> selain dokter</td>
	</tr>
	<tr>
		<td width="50%" height="30" style="padding-left:20px; font-weight:bold;"></td>
		<td width="50%" style="padding-right:20px; text-align:right; font-weight:bold;">Periode : <?php echo $namaBulan[$bln]." ".$thn;?></td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr>
					<td class="jdl" height="28" rowspan="2" width="3%">NO</td>
					<td class="jdl" width="20%" rowspan="2" >NAMA PASIEN</td>
					<td class="jdl" width="7%" rowspan="2">NO RM</td>
					<td class="jdl" width="10%" rowspan="2">KSO</td>
					<td class="jdl" width="7%" rowspan="2">MRS</td>
					<td class="jdl" width="7%" rowspan="2">KRS</td>
					<td class="jdl" width="7%" rowspan="2">JML TINDAKAN</td>
					<td class="jdlKn" width="30%" colspan="<?php if($jenis=='4'){echo '3';}else{echo '2';}?>">NILAI JASA TINDAKAN UNTUK</td>					
				</tr>
				<tr>
				     <td class="jdl" width="10%">KEBERSAMAAN</td>
					<td class="jdlKn" width="10%">MANAGEMEN</td>
					<?php if($jenis=='4'){echo '<td class="jdlKn" width="10%">ASISTEN</td>';}else{echo '';}?>
                                     
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
                LEFT JOIN b_tindakan_dokter_anastesi da ON da.tindakan_id=t.id
				INNER JOIN b_ms_pegawai g ON g.id=t.user_id				
				WHERE year(t.tgl_bayar_pav)='".$thn."' AND month(t.tgl_bayar_pav)='".$bln."' 
				AND t.tgl_bayar_pav IS NOT NULL $ifJenis GROUP BY t.id  order by pasien) as t1 group by t1.pasien";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				$jml_jml = 0;
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
					<td class="isi" align="center"><?php echo $rw['jml']; $jml_jml+=$rw['jml'];?>&nbsp;</td>
					<td class="isi" align="right">
					   <?php						
						  $kebersamaan=(80/100*$rw['nilai'])*6/100;								
                                echo number_format($kebersamaan,0,'','.'); $jml_kebersamaan+=$kebersamaan;
                            ?>&nbsp;
					</td>
					<td class="isiKn" align="right">
                            <?php						
						  $managemen=(80/100*$rw['nilai'])*10/100;								
                                echo number_format($managemen,0,'','.'); $jml_managemen+=$managemen;
                            ?>&nbsp;
                         </td><?php
                        if($jenis=='4'){
                            echo '<td class="isiKn" align="right">';
                            $asisten=(80/100*$rw['nilai'])*10/100;								
                            echo number_format($asisten,0,'','.'); $jml_asisten+=$asisten;
                            echo '&nbsp;</td>';
                        }else{
                            echo '';
                        }
                           ?>				
				</tr>
				<?php
				}
				?>
				<tr>
					<td colspan="6" class="isi" align="right" height="25" style="font-weight:bold;">TOTAL&nbsp;</td>
					<td class="isi" align="center" style="font-weight:bold;"><?php echo $jml_jml;?>&nbsp;</td>
					<td class="isi" align="right" style="font-weight:bold;"><?php echo number_format($jml_kebersamaan,0,'','.');?>&nbsp;</td>
					<td class="isiKn" align="right" style="font-weight:bold;"><?php echo number_format($jml_managemen,0,'','.');?>&nbsp;</td>
					<?php if($jenis=='4'){
                        echo '<td class="isiKn" align="right" style="font-weight:bold;">';
                        echo number_format($jml_asisten,0,'','.');
                        echo '&nbsp;</td>';
                    }
                    else{
                       echo ''; 
                    }?>
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
