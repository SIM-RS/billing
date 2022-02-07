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

$tglPajan = $date_now;
$tglLap = $date_now;
$timePajan = $time_now;
$timeLap = $time_now;

?>
<table width=100% cellspacing=0 cellpadding=0 style='border:.5pt solid windowtext;'>
<tr>
<td>
<form id="insiden_pajan" name="insiden_pajan" action="action.php" method="post">
	<table width=100% cellspacing=0 cellpadding=0 style='border-collapse:collapse; font:12px tahoma;'>
		<tr>
			<td colspan="3">
				<table width=100% cellspacing=0 cellpadding=1 style='border-collapse:collapse; font:12px tahoma;'>
					<tr>
						<td colspan="3" style="padding-left:5px; padding-top:5px;">Petunjuk Pengisian :</td>
					</tr>
					<tr>
						<td width="170" style="padding-left:5px;">Formulir terdiri dari 4 lembar : </td>
						<td width="260">Lembar 1 (putih) ke Poli Pegawai atau IGD</td>
						<td>Lembar 3 (biru) ke K3RS</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>Lembar 2 (merah) ke PPIRS</td>
						<td>Lembar 4 (kuning) Arsip Ruangan</td>
					</tr>
					<tr>
						<td colspan="3" style="padding-left:5px;">Isilah dengan lengkap nomor telepon yang bisa dihubungi</td>
					</tr>
					<tr>
						<td colspan="3" style="padding-left:5px;">*) Klik yang dipilih</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3" style="padding-left:5px; padding-right:5px;"><hr /><hr /></td>
		</tr>
		<tr>
			<td width="100" style="padding-left:5px;">Tanggal Pajanan</td>
			<td>:</td>
			<td>
				<input type="text" name="tgl_pajan" id="tgl_pajan" size="9" value="<?=$tglPajan?>" readonly />
				<input type="button" style='width:25px;' id="btnTglPajan" name="btnTglPajan" disabled="disabled" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('tgl_pajan'),depRange);" />
				&nbsp;Jam : 
				<input type="text" name="jam_pajan" id="jam_pajan" size="4" value="<?php echo $timePajan;?>" readonly />
				<input type="checkbox" id="chkPajan" name="chkPajan" onclick="setPajanManual()"/><label for="chkPajan">set manual</label>
			</td>
		</tr>
		<tr>
			<td style="padding-left:5px;">Tanggal Laporan</td>
			<td>:</td>
			<td>
				<input type="text" name="tgl_lap" id="tgl_lap" size="9" value="<?=$tglLap?>" readonly />
				<input type="button" style='width:25px;' id="btnTglLap" name="btnTglLap" disabled="disabled" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('tgl_lap'),depRange);" />
				&nbsp;Jam : 
				<input type="text" name="jam_lap" id="jam_lap" size="4" value="<?php echo $timeLap;?>" readonly />
				<input type="checkbox" id="chkLap" name="chkLap" onclick="setLapManual()"/><label for="chkLap">set manual</label>
			</td>
		</tr>
		<tr>
			<td colspan="3" style="padding-left:5px; padding-top:15px; font-weight:bold;">Identitas Korban</td>
		</tr>
		<tr>
			<td colspan="3" style="padding-left:15px;">
				<table width=100% cellspacing=0 cellpadding=1 style='border-collapse:collapse; font:12px tahoma;'>
					<tr>
						<td>Nama</td>
						<td>:</td>
						<td><input type="text" name="namaKorban" id="namaKorban" />&nbsp;</td>
						<td>No Telp</td>
						<td>:</td>
						<td><input type="text" name="tlpKorban" id="tlpKorban" /></td>
					</tr>
					<tr>
						<td>Pekerjaan</td>
						<td>:</td>
						<td><input type="text" name="kerjaKorban" id="kerjaKorban" />&nbsp;</td>
						<td>Tempat Kejadian</td>
						<td>:</td>
						<td><input type="text" name="tempatKorban" id="tempatKorban" /></td>
					</tr>
					<tr>
						<td>Atasan Langsung</td>
						<td>:</td>
						<td><input type="text" name="atasanKorban" id="atasanKorban" />&nbsp;</td>
						<td>No Telp Atasan</td>
						<td>:</td>
						<td><input type="text" name="tlpAtasan" id="tlpAtasan" /></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3" style="padding-left:5px; padding-top:15px; font-weight:bold;">Route Pajanan :</td>
		</tr>
		<tr>
			<td colspan="3" style="padding-left:5px;">
				<table width=100% cellspacing=0 cellpadding=1 style='border-collapse:collapse; font:12px tahoma;'>
					<tr height="25">
						<td width="80" style="padding-left:10px;">
							<input type="checkbox" class="css-checkbox" id="jarumsuntik" name="route[1]" value="1" />
							<label for="jarumsuntik" class="css-label lite-green-check">&nbsp;Tusukan Jarum Suntik</label>
						</td>
						<td width="50">
							<input type="checkbox" class="css-checkbox" id="gigitan" name="route[2]" value="1" />
							<label for="gigitan" class="css-label lite-green-check">&nbsp;Gigitan</label>
						</td>
						<td width="200">
							<input type="checkbox" class="css-checkbox" id="mulut" name="route[3]" value="1" />
							<label for="mulut" class="css-label lite-green-check">&nbsp;Mulut</label>
						</td>
					</tr>
					<tr height="25">
						<td style="padding-left:10px;">
							<input type="checkbox" class="css-checkbox" id="lukakulit" name="route[4]" value="1" />
							<label for="lukakulit" class="css-label lite-green-check">&nbsp;Luka Pada Kulit</label>
						</td>
						<td>
							<input type="checkbox" class="css-checkbox" id="mata" name="route[5]" value="1" />
							<label for="mata" class="css-label lite-green-check">&nbsp;Mata</label>
						</td>
						<td>
							<input type="checkbox" class="css-checkbox" id="routelain" name="route[6]" value="1" />
							<label for="routelain" class="css-label lite-green-check">&nbsp;Lain-lain</label>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3" style="padding-left:5px; padding-top:15px; font-weight:bold;">Sumber Pajanan :</td>
		</tr>
		<tr>
			<td colspan="3" style="padding-left:5px;">
				<table width=100% cellspacing=0 cellpadding=1 style='border-collapse:collapse; font:12px tahoma;'>
					<tr height="25">
						<td width="85" style="padding-left:10px;">
							<input type="checkbox" class="css-checkbox" id="darah" name="sumber[1]" value="1" />
							<label for="darah" class="css-label lite-green-check">&nbsp;Darah</label>
						</td>
						<td width="85">
							<input type="checkbox" class="css-checkbox" id="sputum" name="sumber[2]" value="1" />
							<label for="sputum" class="css-label lite-green-check">&nbsp;Sputum</label>
						</td>
						<td width="85">
							<input type="checkbox" class="css-checkbox" id="airliur" name="sumber[3]" value="1" />
							<label for="airliur" class="css-label lite-green-check">&nbsp;Air Liur</label>
						</td>
						<td width="85">
							<input type="checkbox" class="css-checkbox" id="feses" name="sumber[4]" value="1" />
							<label for="feses" class="css-label lite-green-check">&nbsp;Feses</label>
						</td>
						<td>
							<input type="checkbox" class="css-checkbox" id="sumberlain" name="sumber[5]" value="1" onclick="showSumberLain()" />
							<label for="sumberlain" class="css-label lite-green-check">&nbsp;Lain-lain (sebutkan)</label>
							<span id="spanSLain" style='<?=($sumber[4] == 0)?'display:none;':''?> vertical-align:middle; padding-left:5px;'>
								<input type="text" id="sumberTextLain" name="sumberTextLain" />
							</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3" style="padding-left:5px; padding-top:15px; font-weight:bold;">Bagian tubuh yang terpajan sebut secara jelas :</td>
		</tr>
		<tr>
			<td colspan="3" style="padding-left:15px; padding-top:3px;">
				<textarea name="textBagianTubuh" id="textBagianTubuh" cols="97" rows="2"></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="3" style="padding-left:5px; padding-top:15px; font-weight:bold;">Kronologis kejadian :</td>
		</tr>
		<tr>
			<td colspan="3" style="padding-left:15px; padding-top:3px;">
				<textarea name="textKronologi" id="textKronologi" cols="97" rows="2"></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="3" style="padding-left:5px; padding-top:10px;">
				<table width=100% cellspacing=0 cellpadding=1 style='border-collapse:collapse; font:12px tahoma;'>
					<tr height="25">
						<td width="150">Imunisasi Hepatitis B</td>
						<td width="120">
							<input type="checkbox" class="css-checkbox" id="sudahImun" name="imunisasi" value="1" />
							<label for="sudahImun" class="css-label lite-green-check">&nbsp;Sudah</label>
						</td>
						<td colspan="2">
							<input type="checkbox" class="css-checkbox" id="belumImun" name="imunisasi" value="0" />
							<label for="belumImun" class="css-label lite-green-check">&nbsp;Belum</label>
						</td>
					</tr>
					<tr height="25">
						<td width="150">Alat Pelindung</td>
						<td width="120">
							<input type="checkbox" class="css-checkbox" id="alatDipakai" name="alat" value="1" />
							<label for="alatDipakai" class="css-label lite-green-check">&nbsp;Dipakai</label>
						</td>
						<td width="120">
							<input type="checkbox" class="css-checkbox" id="alatTidak" name="alat" value="0" />
							<label for="alatTidak" class="css-label lite-green-check">&nbsp;Tidak</label>
						</td>
						<td>
							<input type="checkbox" class="css-checkbox" id="alatJenis" name="alat" value="2" onclick="jenisLain()" />
							<label for="alatJenis" class="css-label lite-green-check">&nbsp;Jenis</label>
							<span id="spanAlat" style='<?=($alat[2] == 0)?'display:none;':''?> vertical-align:middle; padding-left:5px;'>
								<input type="text" id="textJenis" name="textJenis" />
							</span>
						</td>
					</tr>
					<tr height="25">
						<td width="150">Pertolongan Pertama</td>
						<td width="120">
							<input type="checkbox" class="css-checkbox" id="tolongAda" name="tolong" value="1" />
							<label for="tolongAda" class="css-label lite-green-check">&nbsp;Ada</label>
						</td>
						<td colspan="2">
							<input type="checkbox" class="css-checkbox" id="tolongTidak" name="tolong" value="0" />
							<label for="tolongTidak" class="css-label lite-green-check">&nbsp;Tidak</label>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3" style="padding-left:5px; font-weight:bold; padding-top:10px;">
				<input type="hidden" id="bahanInfeksius" name="bahanInfeksius" value="" />
				Pasien sumber darah/bahan infeksius 
				( <a href="javascript:void(0)" id="pasTahu" style="text-decoration:none;">diketahui</a> / 
				  <a href="javascript:void(0)" id="pasTidak" style="text-decoration:none;">tidak diketahui</a> *)
			</td>
		</tr>
		<tr>
			<td colspan="3" style="padding-left:5px; padding-top:5px;">Pemeriksaan serologi</td>
		</tr>
		<tr>
			<td colspan="3" style="padding-left:15px; padding-top:10px;">
				<table width=100% cellspacing=0 cellpadding=1 style='border-collapse:collapse; font:12px tahoma;'>
					<tr>
						<td width="250">
							<input type="hidden" id="textHIV" name="textHIV" value="" />
							<input type="checkbox" class="css-checkbox" id="hiv" name="hiv" value="1" onclick="showAntiHIV()" />
							<label for="hiv" class="css-label lite-green-check">&nbsp;Anti HIV</label>
							<span id="antiHIV" style="vertical-align:middle; font-weight:bold;"></span>
						</td>
						<td width="250">
							<input type="hidden" id="textHbsag" name="textHbsag" value="" />
							<input type="checkbox" class="css-checkbox" id="hbsag" name="hbsag" value="1" onclick="showHbsag()" />
							<label for="hbsag" class="css-label lite-green-check">&nbsp;HbSAg</label>
							<span id="antiHbsag" style="vertical-align:middle; font-weight:bold;"></span>
						</td>
						<td>
							<input type="hidden" id="textHCV" name="textHCV" value="" />
							<input type="checkbox" class="css-checkbox" id="hcv" name="hcv" value="1" onclick="showAntiHCV()" />
							<label for="hcv" class="css-label lite-green-check">&nbsp;Anti HCV</label>
							<span id="antiHCV" style="vertical-align:middle; font-weight:bold;"></span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3" style="text-align:center; padding-top:15px;">
				<input type="hidden" id="idKunj" name="idKunj" value="<?=$kunjungan_id?>" />
				<input type="hidden" id="idPel" name="idPel" value="<?=$pelayanan_id?>" />
				<input type="hidden" id="idUsr" name="idUsr" value="<?=$idUser?>" />
				<input type="text" id="actPajan" name="actPajan" value="<?=($cekEdit == 0)?'save':'edit'?>" />
				<input type="button" style='cursor:pointer;' value="<?=($cekEdit == 0)?'Save':'Update'?>" onclick="prosesPajan()" />
				&nbsp;&nbsp;
				<input type="button" style='cursor:pointer;' value="Cetak" onclick="" />
			</td>
		</tr>
	</table>
</form>
</td>
</tr>
</table>