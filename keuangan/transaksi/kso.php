<?php 
	include("../sesi.php");
	include("../koneksi/konek.php"); 
	$kso = $_REQUEST['kso'];
	$bln = $_REQUEST['bln'];
	$thn = $_REQUEST['thn'];
	$tipe = $_REQUEST['type'];
	
	$qK = "SELECT $dbbilling.b_ms_kso.nama FROM $dbbilling.b_ms_kso WHERE $dbbilling.b_ms_kso.id = '".$kso."'";
	$rK = mysql_query($qK);
	$rwK = mysql_fetch_array($rK);

	if($_REQUEST['act']=="save")
	{
		$qIn = "INSERT INTO $dbbilling.b_bayar(kunjungan_id,tagihan,nilai,dibayaroleh) VALUES('".$rw['kunjungan_id']."','".$rw['total']."','".$_REQUEST['txtBayar']."','".$rwK['nama']."')";
		$rsIn = mysql_query($qIn);
		break;
	}
	switch($tipe){
        case '1'://pembayaran kso
		?>
		<form id="formKso">
			<input id="act" name="act" value="save" type="hidden">								
			<table  width="880" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:10px; background-color:#ffffff;">
				<?php
					$sql = "SELECT DATE_FORMAT($dbbilling.b_kunjungan.tgl,'%d-%m-%Y') AS tgl, 
			$dbbilling.b_kunjungan.id AS kunjungan_id, $dbbilling.b_ms_pasien.nama AS pasien, $dbbilling.b_tindakan.biaya_kso, $dbbilling.b_tindakan_kamar.beban_kso, 
			$dbbilling.b_tindakan.biaya_kso+$dbbilling.b_tindakan_kamar.beban_kso AS total
			FROM $dbbilling.b_ms_pasien
			INNER JOIN $dbbilling.b_kunjungan ON $dbbilling.b_kunjungan.pasien_id = $dbbilling.b_ms_pasien.id
			INNER JOIN $dbbilling.b_pelayanan ON $dbbilling.b_pelayanan.kunjungan_id = $dbbilling.b_kunjungan.id
			INNER JOIN $dbbilling.b_tindakan ON $dbbilling.b_tindakan.pelayanan_id = $dbbilling.b_pelayanan.id
			INNER JOIN $dbbilling.b_tindakan_kamar ON $dbbilling.b_tindakan.pelayanan_id = $dbbilling.b_tindakan_kamar.pelayanan_id
			WHERE $dbbilling.b_kunjungan.kso_id = '".$kso."' AND (MONTH($dbbilling.b_kunjungan.tgl) = '".$bln."' AND YEAR($dbbilling.b_kunjungan.tgl) = '".$thn."')
			GROUP BY $dbbilling.b_ms_pasien.id
			ORDER BY $dbbilling.b_ms_pasien.id";
					$rs = mysql_query($sql);
					$no = 1;
					$height = 20;
					while($rw = mysql_fetch_array($rs))
					{
				?>
				<tr>
					<td width="5%" style="text-align:center"><?php echo $no;?></td>
					<td width="10%" style="text-align:center"><?php echo $rw['tgl']?></td>
					<td width="33%" style="text-transform:uppercase">&nbsp;<?php echo $rw['pasien']?></td>
					<?php
						$qUn = "SELECT $dbbilling.b_ms_unit.nama
			FROM $dbbilling.b_kunjungan
			INNER JOIN $dbbilling.b_pelayanan ON $dbbilling.b_pelayanan.kunjungan_id = $dbbilling.b_kunjungan.id
			INNER JOIN $dbbilling.b_ms_unit ON $dbbilling.b_ms_unit.id = $dbbilling.b_pelayanan.unit_id
			WHERE $dbbilling.b_kunjungan.id = '".$rw['kunjungan_id']."'";
						$rsUn = mysql_query($qUn);
					?>
					<td width="37%" >(<?php while($rwUn = mysql_fetch_array($rsUn)){ echo $rwUn['nama']?>,<?php }?>)</td>
					<td width="10%" style="text-align:right"><?php echo number_format($rw['total'],0,",",".")?>&nbsp;</td>
					<td width="5%" style="text-align:center;vertical-align:middle;">
						<input id="txtBayar_<?php echo $no;?>" name="txtBayar_<?php echo $no;?>" size="8" style="text-align:right; height:20px;" class="txtright">
						<input id="bayarId" name="bayarId" type="hidden">
						<input id="kunjId_<?php echo $no;?>" name="kunjId_<?php echo $no;?>" type="hidden" value="<?php echo $rw['kunjungan_id']?>">
						<?php
						$qTin="SELECT id,biaya_pasien FROM $dbbilling.b_tindakan WHERE kunjungan_id='".$rw['kunjungan_id']."'";
						$rsTin=mysql_query($qTin);
						$tin='';
						while($rwTin=mysql_fetch_array($rsTin)){
							$tin.=$rwTin['id']."|";
						}
						?>
						<input id="txtTin_<?php echo $no;?>" name="txtTin_<?php echo $no;?>" type="hidden" value="<?php echo $tin?>">
					</td>
				</tr>
				<?php
					$no++;
					$height += 20;
					}
				?>
			</table>
			<input type="hidden" id="txtJml" name="txtJml" value="<?php echo ($no-1)?>"/>
		</form>
		<?php
		//echo chr(3).$height;
		break;
        case '2'://farmasi
        case '5'://cssd
        case '3'://kamar jenazah
        case '4'://kantin
        case '6'://jasa parkir
        case '7'://sewa iklan		
		echo '1';
		break;
        default :
            break;
	}
	mysql_close($konek);
?>

