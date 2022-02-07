<?php
include '../../koneksi/konek.php';
$date_now = gmdate('d-m-Y',mktime(date('H')+7));
$time_now = gmdate('H:i',mktime(date('H')+7));

$pelayanan_id = $_REQUEST['idPel'];
$kunjungan_id = $_REQUEST['idKunj'];
$idUser = $_REQUEST['idUsr'];

$sqlEdit = "SELECT *, DATE_FORMAT(tgl_rawat, '%d-%m-%Y') as tglRawat, DATE_FORMAT(tgl_pindah, '%d-%m-%Y') as tglPindah,
			TIME_FORMAT(tgl_rawat, '%H:%i') as timeRawat, TIME_FORMAT(tgl_pindah, '%H:%i') as timePindah
			FROM b_serah_terima_pindah_ruang 
			WHERE pelayanan_id = '{$pelayanan_id}' AND kunjungan_id = '{$kunjungan_id}'";
$rowEdit = mysql_fetch_array(mysql_query($sqlEdit));
$cekEdit = mysql_num_rows(mysql_query($sqlEdit));
if($cekEdit == 0){
	$tglRawat = $date_now;
	$tglPindah = $date_now;
	$timeRawat = $time_now;
	$timePindah = $time_now;
}else{
	$tglRawat = $rowEdit['tglRawat'];
	$tglPindah = $rowEdit['tglPindah'];
	$timeRawat = $rowEdit['timeRawat'];
	$timePindah = $rowEdit['timePindah'];
}

$DID = ($rowEdit['indikasi'] == 'DID')?'checked':'';
$APK = ($rowEdit['indikasi'] == 'APK')?'checked':'';

$alatbantu = explode(',',$rowEdit['alatbantu']);
$cekAlatBantu = ($alatbantu[0]==1)?'disabled':'';

$ya = ($rowEdit['tindakan_operasi'] == 'ya')?'checked':'';
$tidak = ($rowEdit['tindakan_operasi'] == 'tidak')?'checked':'';
$jenis = ($rowEdit['tindakan_operasi'] == 'jenis')?'checked':'';

$mobilisasi = explode(',',$rowEdit['mobilisasi']);

$selfcare = ($rowEdit['tingkat_ketergantungan'] == 'selfcare')?'checked':'';
$partialcare = ($rowEdit['tingkat_ketergantungan'] == 'partialcare')?'checked':'';
$totalcare = ($rowEdit['tingkat_ketergantungan'] == 'totalcare')?'checked':'';

$radiologi = explode(',',$rowEdit['radiologi']);
$cekRadiologi = ($radiologi[0]==0)?'disabled':'';
$thorax = ($radiologi[1]==0)?'disabled':'';
$ctscan = ($radiologi[2]==0)?'disabled':'';

$diagnostik = explode(',',$rowEdit['diagnostik']);
$cekDiagnostik = ($diagnostik[0]==0)?'disabled':'';
$echo = ($diagnostik[1]==0)?'disabled':'';
$eeg = ($diagnostik[2]==0)?'disabled':'';
$usg = ($diagnostik[3]==0)?'disabled':'';
$laboratorium = ($rowEdit['laboratorium'] == '')?'':'checked';
$labInput = ($laboratorium == 'checked')?'':'disabled';

$barang = explode(',',$rowEdit['barang']);
$bukti = explode(',',$rowEdit['bukti']);
$cekBukti = ($bukti[1]==1)?'disabled':'';
?>
<table width=100% cellspacing=0 cellpadding=0 style='border:.5pt solid windowtext;'>
<tr>
<td>
<form id="serahterima" name="serahterima" action="action.php" method="post">
	<table width=100% cellspacing=0 cellpadding=0 style='border-collapse:collapse; font:12px tahoma;'>
		<tr height=5>
			<td colspan=6></td>
		</tr>
		<tr height=25>
			<td width=115 style='padding-left:3pt;'>Tanggal Rawat</td>
			<td width=10>:</td>
			<td>
				<input type="text" id="tgl_rawat" name="tgl_rawat" value="<?=$tglRawat?>" size="9" readonly />
				<input type="button" style='width:25px;' id="btnTglRawat" name="btnTglRawat" disabled="disabled" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('tgl_rawat'),depRange);" />
			</td>
			<td width=130>Tanggal Pindah Ruang</td>
			<td width=10>:</td>
			<td>
				<input type="text" id="tgl_pindah" name="tgl_pindah" value="<?=$tglPindah?>" size="9" readonly />
				<input type="button" style='width:25px;' id="btnTglPindah" name="btnTglPindah" disabled="disabled" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('tgl_pindah'),depRange);" />
			</td>
		</tr>
		<tr>
			<td colspan=2>&nbsp;</td>
			<td>
				<input type="text" id="jam_rawat" name="jam_rawat" size="4" value="<?php echo $timeRawat;?>" readonly />
				<input type="checkbox" id="chkRawat" name="chkRawat" onclick="setRawatManual()"/><label for="chkRawat">set manual</label>
			</td>
			<td colspan=2>&nbsp;</td>
			<td>
				<input type="text" id="jam_pindah" name="jam_pindah" size="4" value="<?php echo $timePindah;?>" readonly />
				<input type="checkbox" id="chkPindah" name="chkPindah" onclick="setPindahManual()"/><label for="chkPindah">set manual</label>		
			</td>
		</tr>
		<tr height=25>
			<td style='padding-left:3pt;'>Dokter DPJP</td>
			<td>:</td>
			<td><input type="text" id="dokter_dpjp" name="dokter_dpjp" value="<?=$rowEdit['dokter_dpjp']?>" /></td>
			<td colspan=3></td>
		</tr>
		<tr height=25>
			<td style='padding-left:3pt;'>Dokter Konsulen</td>
			<td>:</td>
			<td><input type="text" id="dokter_konsul" name="dokter_konsul" value="<?=$rowEdit['dokter_konsul']?>" /></td>
			<td colspan=3></td>
		</tr>
		<tr height=25>
			<td style='padding-left:3pt;'>Indikasi saat pindah</td>
			<td>:</td>
			<td colspan=4>
				<span>
					<input type="radio" id="DID" name="indikasi" value="DID" <?=($cekEdit == 0)?'checked':''?> <?=$DID?> />
					<label for="DID">Dengan Ijin Dokter</label>
				</span>
				<span style='padding-left:100px;'>
					<input type="radio" id="APK" name="indikasi" value="APK" <?=$APK?> />
					<label for="APK">Atas Permintaan Keluarga</label>
				</span>
			</td>
		</tr>
		<tr height=25>
			<td colspan=6 style='padding-top:10pt; padding-left:3pt; font-weight:bold;'>Keadaan Umum Pasien Saat Pindah Ruang</td>
		</tr>
		<tr height=25>
			<td style='padding-left:3pt;'>Kesadaran</td>
			<td>:</td>
			<td><input type="text" id="kesadaran" name="kesadaran" value="<?=$rowEdit['kesadaran']?>" /></td>
			<td colspan=3></td>
		</tr>
		<tr height=25>
			<td style='padding-left:3pt;'>Diagnosa Medis</td>
			<td>:</td>
			<td><input type="text" id="diagnosa" name="diagnosa" value="<?=$rowEdit['diagnosa']?>" /></td>
			<td colspan=3></td>
		</tr>
		<tr height=25>
			<td style='padding-left:3pt;'>Tekanan Darah</td>
			<td>:</td>
			<td><input type="text" id="tekdarah" name="tekdarah" size=10 value="<?=$rowEdit['tekdarah']?>" />&nbsp;MmHg</td>
			<td>Pernafasan</td>
			<td>:</td>
			<td><input type="text" id="pernafasan" name="pernafasan" size=10 value="<?=$rowEdit['pernafasan']?>" />&nbsp;x/menit</td>
		</tr>
		<tr height=25>
			<td style='padding-left:3pt;'>Nadi</td>
			<td>:</td>
			<td><input type="text" id="nadi" name="nadi" size=10 value="<?=$rowEdit['nadi']?>" />&nbsp;x/menit</td>
			<td>Suhu</td>
			<td>:</td>
			<td><input type="text" id="suhu" name="suhu" size=10 value="<?=$rowEdit['suhu']?>" />&nbsp; &#778; C</td>
		</tr>
		<tr height=25>
			<td style='padding-left:3pt;'>Berat Badan</td>
			<td>:</td>
			<td><input type="text" id="beratbadan" name="beratbadan" size=10 value="<?=$rowEdit['beratbadan']?>" />&nbsp;Kg</td>
			<td>Tinggi Badan</td>
			<td>:</td>
			<td><input type="text" id="tinggibadan" name="tinggibadan" size=10 value="<?=$rowEdit['tinggibadan']?>" />&nbsp;Cm</td>
		</tr>
		<tr height=25>
			<td colspan=4 style='padding-top:10pt; padding-left:3pt; font-weight:bold;'>
				<?=ucwords('Alat bantu yang masih terpasang saat pindah ruang')?>
			</td>
		</tr>
		<tr height=25>
			<td colspan=6 style='padding-top:3pt;'>
				<table border=0 cellpadding=0 cellspacing=0 style='border-collapse:collapse; font:12px tahoma;'>
					<tr height=25>
						<td width=200 style='padding-left:10pt;'>
							<input type="checkbox" class="css-checkbox" id="tidakada" name="alatbantu[1]" value="1" <?=($alatbantu[0]==1)?'checked':''?> onclick="tidakAda()" />
							<label for="tidakada" class="css-label lite-green-check">&nbsp;Tidak Ada</label>	
						</td>
						<td width=200>
							<input type="checkbox" class="css-checkbox" id="NGT" name="alatbantu[2]" value="1" <?=$cekAlatBantu?> <?=($alatbantu[1]==1)?'checked':''?> />
							<label for="NGT" class="css-label lite-green-check">&nbsp;NGT</label>	
						</td>
						<td width=300>
							<input type="checkbox" class="css-checkbox" id="karakter" name="alatbantu[3]" value="1" <?=$cekAlatBantu?> <?=($alatbantu[2]==1)?'checked':''?> />
							<label for="karakter" class="css-label lite-green-check">&nbsp;Karakter</label>	
						</td>
					</tr>
					<tr height=30>
						<td style='padding-left:10pt;'>
							<input type="checkbox" class="css-checkbox" id="oksigen" name="alatbantu[4]" value="1" <?=$cekAlatBantu?> <?=($alatbantu[3]==1)?'checked':''?> />
							<label for="oksigen" class="css-label lite-green-check">&nbsp;Oksigen</label>	
						</td>
						<td>
							<input type="checkbox" class="css-checkbox" id="ETT" name="alatbantu[5]" value="1" <?=$cekAlatBantu?> <?=($alatbantu[4]==1)?'checked':''?> />
							<label for="ETT" class="css-label lite-green-check">&nbsp;ETT</label>	
						</td>
						<td>
							<input type="checkbox" class="css-checkbox" id="check_lain" name="alatbantu[6]" value="1" <?=$cekAlatBantu?> <?=($alatbantu[5]==1)?'checked':''?> onclick="showLain()" />
							<label for="check_lain" class="css-label lite-green-check">&nbsp;Lain-lain</label>
							<span id="spLain" style='<?=($alatbantu[5] == 0)?'display:none;':''?> vertical-align:middle; padding-left:5px;'>
								<input type="text" id="alat_bantu_lain" name="alat_bantu_lain" value="<?=$rowEdit['alatbantu_lain']?>" />
							</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr height=25>
			<td colspan=6 style='padding-left:3pt;'>
				<b>Tindakan Operasi</b>
				<span style='vertical-align:middle; padding-left:50px;'>
					<input type="radio" id="ya" name="tindakan_operasi" value="ya" <?=$ya?> />
					<label for="ya" style='padding-right:20px;'>Ya</label>
					<input type="radio" id="tidak" name="tindakan_operasi" value="tidak" <?=($cekEdit == 0)?'checked':''?> <?=$tidak?> />
					<label for="tidak" style='padding-right:20px;'>Tidak</label>
					<input type="radio" id="jenis" name="tindakan_operasi" value="jenis" <?=$jenis?> />
					<label for="jenis">Jenis</label>
				</span>
			</td>
		</tr>
		<tr height=30>
			<td colspan=2 style='padding-top:5pt; padding-left:3pt; font-weight:bold;'>
				<div style='position:absolute; margin-top:-8px;'>Kemampuan Mobilisasi pasien saat pindah</div>
			</td>
			<td colspan=4 style='padding-top:5pt; padding-left:185px;'>
				<input type="checkbox" class="css-checkbox" id="bedrest" name="mobilisasi[1]" value="1" <?=($mobilisasi[0]==1)?'checked':''?> />
				<label for="bedrest" class="css-label lite-green-check" style='padding-right:40px;'>&nbsp;Bedrest</label>
				<input type="checkbox" class="css-checkbox" id="kursi_roda" name="mobilisasi[2]" value="1" <?=($mobilisasi[1]==1)?'checked':''?> />
				<label for="kursi_roda" class="css-label lite-green-check">&nbsp;Kursi Roda</label>
			</td>
		</tr>
		<tr height=35>
			<td colspan=2 style='padding-left:3pt;'>&nbsp;</td>
			<td colspan=4 style='padding-left:185px; height:10px;'>									
				<input type="checkbox" class="css-checkbox" id="tongkat" name="mobilisasi[3]" value="1" <?=($mobilisasi[2]==1)?'checked':''?> />
				<label for="tongkat" class="css-label lite-green-check" style='padding-right:35px;'>&nbsp;Tongkat</label>
				<input type="checkbox" class="css-checkbox" id="check_lain2" name="mobilisasi[4]" value="1" <?=($mobilisasi[3]==1)?'checked':''?> onclick="showLain2()" />
				<label for="check_lain2" class="css-label lite-green-check">&nbsp;Lain-lain</label>
				<span id="spLain2" style='<?=($mobilisasi[3] == 0)?'display:none;':''?> vertical-align:middle; padding-left:5px;'>
					<input type="text" id="mobilisasi_lain" name="mobilisasi_lain" value="<?=$rowEdit['mobilisasi_lain']?>" />
				</span>
			</td>
		</tr>
		<tr height=25>
			<td colspan=6 style='padding-left:3pt;'>
				<b>Tingkat Ketergantungan</b>
				<span style='vertical-align:middle; padding-left:50px;'>
					<input type="radio" id="selfcare" name="tingkat_ketergantungan" value="selfcare" <?=$selfcare?> />
					<label for="selfcare" style='padding-right:20px;'>Selfcare</label>
					<input type="radio" id="partialcare" name="tingkat_ketergantungan" value="partialcare" <?=$partialcare?> />
					<label for="partialcare" style='padding-right:20px;'>Partial Care</label>
					<input type="radio" id="totalcare" name="tingkat_ketergantungan" value="totalcare" <?=$totalcare?> />
					<label for="totalcare">Total Care</label>
				</span>
			</td>
		</tr>
		<tr>
			<td colspan=6 style='padding-top:5pt; padding-left:3pt; font-weight:bold;'>Obat-obatan Yang Masih Dilanjutkan</td>
		</tr>
		<tr>
			<td colspan=6 style='padding-top:5pt; padding-left:10px;'>
				<table border=1 cellpadding=0 cellspacing=0 style='border-collapse:collapse; font:12px tahoma;'>
					<tr>
						<th width=40 height=20>No</th>
						<th width=300>Nama Obat</th>
						<th width=150>Dosis</th>
						<th width=100>Jumlah</th>
						<th width=150>Obat-obat Sisa</th>
						<th width=50>&nbsp;<div style="display:none"><input type="button" style='cursor:pointer;' value="+" class="tambahRow2" /></div></th>
					</tr>
					<tr>
                    <?php
					$sqlCatat2 = "SELECT * FROM b_obat_pindah_ruang WHERE serah_terima_id = '".$rowEdit['serah_terima_id']."' ";
						$queryCatat2 = mysql_fetch_array(mysql_query($sqlCatat2));
					?>
						<td width=40 height=20>&nbsp;<input type="hidden" id="obat_id" name="obat_id" value="<?=$queryCatat2['obat_id']?>" /></td>
						<td width=300><input type="text" class="catatan" id="nama_obat" name="nama_obat" /></td>
						<td width=150><input type="text" class="catatan" id="dosis" name="dosis" /></td>
						<td width=120><input type="text" class="catatan" id="jumlah_obat" name="jumlah_obat" /></td>
						<td width=150><input type="text" class="catatan" id="sisa_obat" name="sisa_obat" /></td>
						<td width=50>&nbsp;</td>
                        <!--<tbody class="catatanRow2">-->
					<? 
						/*$sqlCatat2 = "SELECT * FROM b_obat_pindah_ruang WHERE serah_terima_id = '".$rowEdit['serah_terima_id']."' ";
						$queryCatat2 = mysql_query($sqlCatat2);
						$x=1;
						while($rsCatat2 = mysql_fetch_array($queryCatat2)){
							echo '<tr class="itemRow">
									<input type="hidden" id="rawID2" name="rawID2[]" value="1" />
									<td width=40 height=20 align=center>
									'.$x.'
										<input type="hidden" id="obatID" name="obatID[]" value="'.$rsCatat['obat_id'].'" />&nbsp;
									</td>
									<td width=240><input type="text" class="catatan" id="nama_obat" name="nama_obat[]" value="'.$rsCatat['nama_obat'].'" /></td>
									<td width=240><input type="text" class="catatan" id="dosis" name="dosis[]" value="'.$rsCatat['dosis'].'" /></td>
									<td width=240><input type="text" class="catatan" id="jumlah_obat" name="jumlah_obat[]" value="'.$rsCatat['jumlah_obat'].'" /></td>
									<td width=240><input type="text" class="catatan" id="sisa_obat" name="sisa_obat[]" value="'.$rsCatat['sisa_obat'].'" /></td>
									<td width=50 align=center>
										<img class="hapus2" style="cursor:pointer;" src="../../icon/del.gif" border="0" width="16" height="16" align="absmiddle" title="Klik Untuk Menghapus" />
									</td>
								  </tr>';
						$x++;}*/
					?>
					<!--</tbody>-->
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan=6 style='padding-top:5pt; padding-left:3pt; font-weight:bold;'>Berkas Yang Disertakan</td>
		</tr>
		<tr>
			<td colspan=6 style='padding-top:3px; padding-left:10px;'>
				<table border=0 cellpadding=0 cellspacing=0 style='border-collapse:collapse; font:12px tahoma;'>
					<tr height=30>
						<td>
							<input type="checkbox" class="css-checkbox" id="radiologi" name="radiologi[1]" value="1" <?=($radiologi[0]==1)?'checked':''?> onclick="openRadiologi()" />
							<label for="radiologi" class="css-label lite-green-check">&nbsp;Radiologi :</label>
						</td>
						<td width=350 style='padding-left:10px;'>
							<input type="checkbox" class="css-checkbox" id="thorax" name="radiologi[2]" value="1" <?=$cekRadiologi?> <?=($radiologi[1]==1)?'checked':''?> onclick="openThorax()" />
							<label for="thorax" class="css-label lite-green-check">&nbsp;Thorax</label>
							<span style='vertical-align:middle; padding-left:17px;'>
								Jml <input type="text" id="thorax_input" name="thorax_input" size="4" value="<?=$rowEdit['thorax']?>" <?=$thorax?> /> lembar
							</span>
						</td>
						<td>
							<input type="checkbox" class="css-checkbox" id="diagnostik" name="diagnostik[1]" value="1" <?=($diagnostik[0]==1)?'checked':''?> onclick="openDiagnosa();" />
							<label for="diagnostik" class="css-label lite-green-check">&nbsp;Diagnostik :</label>
						</td>
						<td style='padding-left:10px;'>
							<input type="checkbox" class="css-checkbox" id="echo" name="diagnostik[2]" value="1" <?=$cekDiagnostik?> <?=($diagnostik[1]==1)?'checked':''?> onclick="openEcho()" />
							<label for="echo" class="css-label lite-green-check">&nbsp;Echo</label>
							<span style='vertical-align:middle; padding-left:10px;'>
								Jml <input type="text" id="echo_input" name="echo_input" size="4" value="<?=$rowEdit['echo']?>" <?=$echo?> /> lembar
							</span>
						</td>
					</tr>
					<tr height=30>
						<td></td>
						<td style='padding-left:10px;'>
							<input type="checkbox" class="css-checkbox" id="ctscan" name="radiologi[3]" value="1" <?=$cekRadiologi?> <?=($radiologi[2]==1)?'checked':''?> onclick="openCTscan()" />
							<label for="ctscan" class="css-label lite-green-check">&nbsp;CT Scan</label>
							<span style='vertical-align:middle; padding-left:10px;'>
								Jml <input type="text" id="ctscan_input" name="ctscan_input" size="4" value="<?=$rowEdit['ctscan']?>" <?=$ctscan?> /> lembar
							</span>
						</td>
						<td></td>
						<td style='padding-left:10px;'>
							<input type="checkbox" class="css-checkbox" id="EEG" name="diagnostik[3]" value="1" <?=$cekDiagnostik?> <?=($diagnostik[2]==1)?'checked':''?> onclick="openEEG()" />
							<label for="EEG" class="css-label lite-green-check">&nbsp;EEG</label>
							<span style='vertical-align:middle; padding-left:15px;'>
								Jml <input type="text" id="eeg_input" name="eeg_input" size="4" value="<?=$rowEdit['eeg']?>" <?=$eeg?> /> lembar
							</span>
						</td>
					</tr>
					<tr height=30>
						<td></td>
						<td style='padding-left:10px;'>
							<input type="checkbox" class="css-checkbox" id="check_lain3" name="radiologi[4]" value="1" <?=($radiologi[3]==1)?'checked':''?> onclick="showLain3()" <?=$cekRadiologi?> />
							<label for="check_lain3" class="css-label lite-green-check">&nbsp;Lain-lain</label>
							<span id="spLain3" style='vertical-align:middle; <?=($radiologi[3]==0)?'display:none;':'';?> padding-left:10px;'>
								<input type="text" id="radiologi_lain" name="radiologi_lain" value="<?=$rowEdit['radiologi_lain']?>" />
							</span>
						</td>
						<td></td>
						<td style='padding-left:10px;'>
							<input type="checkbox" class="css-checkbox" id="USG" name="diagnostik[4]" value="1" <?=$cekDiagnostik?> <?=($diagnostik[3]==1)?'checked':''?> onclick="openUSG()" />
							<label for="USG" class="css-label lite-green-check">&nbsp;USG</label>
							<span style='vertical-align:middle; padding-left:14px;'>
								Jml <input type="text" id="usg_input" name="usg_input" size="4" value="<?=$rowEdit['usg']?>" <?=$usg?> /> lembar
							</span>
						</td>
					</tr>
					<tr>
						<td colspan=4 style='padding-top:10px;'>
							<input type="checkbox" class="css-checkbox" id="laboratorium" name="laboratorium" value="1" <?=$laboratorium?> onclick="openLab()" />
							<label for="laboratorium" class="css-label lite-green-check">&nbsp;Laboratorium :</label>
							<span style='vertical-align:middle; padding-left:5px;'>
								Jml <input type="text" id="lab_input" name="lab_input" size="4" value="<?=$rowEdit['laboratorium']?>" <?=$labInput?> /> lembar
							</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan=6 style='padding-top:5pt; padding-left:3pt; font-weight:bold;'>Barang Pribadi Milik Pasien Yang Disertakan</td>
		</tr>
		<tr height=30>
			<td colspan=6 style='padding-top:5pt; padding-left:10px;'>
				<input type="checkbox" class="css-checkbox" id="gigi_palsu" name="barang[1]" value="1" <?=($barang[0]==1)?'checked':''?> />
				<label for="gigi_palsu" class="css-label lite-green-check" style='padding-right:120px;'>&nbsp;Gigi Palsu</label>
				<input type="checkbox" class="css-checkbox" id="check_lain4" name="barang[2]" value="1" <?=($barang[1]==1)?'checked':''?> onclick="showLain4()" />
				<label for="check_lain4" class="css-label lite-green-check">&nbsp;Lain-lain</label>
				<span id="spLain4" style='vertical-align:middle; <?=($barang[1]==0)?'display:none;':''?> padding-left:10px;'>
					<input type="text" id="barang_lain" name="barang_lain" value="<?=$rowEdit['barang_lain']?>" />
				</span>
			</td>
		</tr>
		<tr>
			<td colspan=6 style='padding-top:5pt; padding-left:3pt; font-weight:bold;'>Tanda Bukti Pasien Pindah Ruang</td>
		</tr>
		<tr height=30>
			<td colspan=6 style='padding-top:5pt; padding-left:10px;'>
				<input type="checkbox" class="css-checkbox" id="bukti_ada" name="bukti[1]" value="1" <?=($bukti[0]==1)?'checked':''?> <?=$cekBukti?> />
				<label for="bukti_ada" class="css-label lite-green-check" style='padding-right:152px;'>&nbsp;Ada</label>
				<input type="checkbox" class="css-checkbox" id="bukti_tidak_ada" name="bukti[2]" value="1" <?=($bukti[1]==1)?'checked':''?> onclick="buktiTidakAda()" />
				<label for="bukti_tidak_ada" class="css-label lite-green-check" style='padding-right:120px;'>&nbsp;Tidak Ada</label>
				<input type="checkbox" class="css-checkbox" id="check_lain5" name="bukti[3]" value="1" <?=($bukti[2]==1)?'checked':''?> <?=$cekBukti?> onclick="showLain5()" />
				<label for="check_lain5" class="css-label lite-green-check">&nbsp;Lain-lain</label>
				<span id="spLain5" style='vertical-align:middle; <?=($bukti[2]==0)?'display:none;':''?> padding-left:10px;'>
					<input type="text" id="bukti_lain" name="bukti_lain" value="<?=$rowEdit['bukti_lain']?>" />
				</span>
			</td>
		</tr>
		<tr>
			<td colspan=6 style='padding-top:5pt; padding-left:3pt; font-weight:bold;'>Catatan Khusus / Rencana Tindakan Kep.</td>
		</tr>
		<tr>
			<td colspan=6 style='padding-top:5pt; padding-left:10px;'>
				<table border=1 cellpadding=0 cellspacing=0 style='border-collapse:collapse; font:12px tahoma;'>
					<thead>
					<tr>
						<th width=40 height=20>No</th>
						<th width=240>Pesanan</th>
						<th width=240>Keterangan</th>
						<th width=240>Instruksi</th>
						<th width=50><input type="button" style='cursor:pointer;' value="+" class="tambahRow" /></th>
					</tr>
					</thead>
					<tbody class="catatanRow">
					<? 
						$sqlCatat = "SELECT * FROM b_catatan_pindah_ruang WHERE serah_terima_id = '".$rowEdit['serah_terima_id']."' ";
						$queryCatat = mysql_query($sqlCatat);
						$z=1;
						while($rsCatat = mysql_fetch_array($queryCatat)){
							echo '<tr class="itemRow">
									<input type="hidden" id="rawID" name="rawID[]" value="1" />
									<td width=40 height=20 align=center>
									'.$z.'
										<input type="hidden" id="catatID" name="catatID[]" value="'.$rsCatat['catatan_id'].'" />&nbsp;
									</td>
									<td width=240><input type="text" class="catatan" id="pesanan" name="pesanan[]" value="'.$rsCatat['pesanan'].'" /></td>
									<td width=240><input type="text" class="catatan" id="keterangan" name="keterangan[]" value="'.$rsCatat['keterangan'].'" /></td>
									<td width=240><input type="text" class="catatan" id="instruksi" name="instruksi[]" value="'.$rsCatat['instruksi'].'" /></td>
									<td width=50 align=center>
										<img class="hapus" style="cursor:pointer;" src="../../icon/del.gif" border="0" width="16" height="16" align="absmiddle" title="Klik Untuk Menghapus" />
									</td>
								  </tr>';
						$z++;}
					?>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan=6 align=center style='padding-top:10px;'>
				<input type="hidden" id="idKunj" name="idKunj" value="<?=$kunjungan_id?>" />
				<input type="hidden" id="idPel" name="idPel" value="<?=$pelayanan_id?>" />
				<input type="hidden" id="idUsr" name="idUsr" value="<?=$idUser?>" />
				<input type="hidden" id="deleteCatatan" name="deleteCatatan" />
				<input type="hidden" id="actSerahTerima" name="actSerahTerima" value="<?=($cekEdit == 0)?'save':'edit'?>" />
				<input type="hidden" id="serah_terima_id" name="serah_terima_id" value="<?=$rowEdit['serah_terima_id']?>" />
				<input type="button" style='cursor:pointer;' value="<?=($cekEdit == 0)?'Save':'Update'?>" onclick="prosesSerahTerima()" />
				&nbsp;&nbsp;
				<input type="button" style='cursor:pointer;' value="Cetak" onclick="cetakPindahRuang()" />
			</td>
		</tr>
	</table>
</form>
</td>
</tr>
</table>