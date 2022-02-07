<?php 
	include("../../sesi.php");
	include_once("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
?>

<div id="popup_div1" class="popup" style="width:500px;display:none;">
    <div style="float:right; cursor:pointer" class="popup_closebox">
        <img src="../../icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
		<br>
    <form id="form1" action="japel.php" method="post" target="_blank">
	<input id="user_act" name="user_act" type="hidden" value="<?php echo $_SESSION['userId']?>" />
		<fieldset>
			<legend>Kriteria Laporan</legend>
				<table width="450" align="center">
					<tr>
						<td colspan="2" align="center"><select id="cmbWaktu" name="cmbWaktu" class="txtinput" onchange="setBln(this.value)">
						<option value=""></option>
						<option value="Harian">Harian</option>
						<option value="Bulanan">Bulanan</option>
						<option value="Rentang Waktu">Rentang Waktu</option>
						</select></td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<div id="trHarian" style="display:none">
								<input size="10" value="<?php echo $date_now;?>" class="txtcenter" id="tglAwal2" name="tglAwal2" readonly="readonly"/>&nbsp;<input type="button" class="btninput" id="btnTglAwal" name="btnTgl" value=" V " onClick="gfPop.fPopCalendar(document.getElementById('tglAwal2'),depRange,ubah);" />
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
						<div id="trBulan" style="display:none">
						<select class="txtinput" id="cmbBln" name="cmbBln" onchange="bulanan()"><option></option></select>&nbsp;<select class="txtinput" id="cmbThn" name="cmbThn" onchange="bulanan()"><option></option></select>
						</div></td>
					</tr>
					<tr>
						<td colspan="2" align="center">
						<div id="trPeriode" style="display:none">
						Periode : <input size="10" value="<?php echo $date_now;?>" class="txtcenter" id="tglAwal" name="tglAwal" readonly="readonly"/>&nbsp;<input type="button" class="btninput" id="btnTglAwal" name="btnTgl" value=" V " onClick="gfPop.fPopCalendar(document.getElementById('tglAwal'),depRange);" />&nbsp;s.d.&nbsp;<input size="10" value="<?=$date_now;?>" class="txtcenter" id="tglAkhir" name="tglAkhir" />&nbsp;<input type="button" class="btninput" id="btnTglAkhir" name="btnTgl" value=" V " onClick="gfPop.fPopCalendar(document.getElementById('tglAkhir'),depRange);" />
						</div></td>
					</tr>
					<tr id="rwJnsLay">
						<td align="right">Jenis Layanan</td>
						<td>&nbsp;<select name="JnsLayanan" id="JnsLayanan" tabindex="26" class="txtinput" onchange="change();isiCombo1('cmbKsr',this.value);"></select></td>
					 </tr>
					 <tr id="rwTmpLay">
						<td align="right">Tempat Layanan</td>
						<td>&nbsp;<select name="TmpLayanan" id="TmpLayanan" tabindex="27" class="txtinput" onchange="isiCombo('cmbDokJns',this.value);"></select>
						</td>
					 </tr>
					<tr id="rwJnsLayBr">
						<td align="right">Jenis Layanan</td>
						<td>&nbsp;<select name="JnsLayananBaru" id="JnsLayananBaru" tabindex="26" class="txtinput" onchange="change();"></select></td>
					 </tr>
					 <tr id="rwTmpLayBr">
						<td align="right">Tempat Layanan</td>
						<td>&nbsp;<select name="TmpLayananBaru" id="TmpLayananBaru" tabindex="27" class="txtinput" onchange="isiCombo('cmbDokSemua',this.value);"></select>
						</td>
					 </tr>
					<tr id="JnsPav">
						<td align="right">Jenis Layanan</td>
						<td>&nbsp;<select id="JnsLayananPav" name="JnsLayananPav" class="txtinput" onchange="change()"></select></td>
					</tr>
					<tr id="TmpPav">
						<td align="right">Tempat Layanan</td>
						<td>&nbsp;<select id="TmpLayananPav" name="TmpLayananPav" class="txtinput"></select>
					</tr>
					<tr id="TmpPavInap">
						<td align="right">Tempat Layanan</td>
						<td>&nbsp;<select id="TmpLayananPavInap" name="TmpLayananPavInap" class="txtinput"></select>
					</tr>
					<tr id="rwPelaksana">
						<td align="right">Pelaksana</td>
						<td>&nbsp;<select id="cmbDokJns" name="cmbDokJns" class="txtinput"></select></td>
					</tr>
					<tr id="rwPelaksanaDok">
						<td align="right">Pelaksana</td>
						<td>&nbsp;<select id="cmbDokSemua" name="cmbDokSemua" class="txtinput"></select></td>
					</tr>
					 <tr id="trPenjamin">
						<td width="30%" align="right">Status Pasien</td>
						<td width="70%">&nbsp;<select name="StatusPas" id="StatusPas" tabindex="22" class="txtinput"></select></td>
					</tr>
					<tr id="trPel">
						<td width="30%" align="right">Pelayanan</td>
						<td width="70%">&nbsp;<select id="cmbPel" name="cmbPel" class="txtinput">
							<option value="0">RAWAT JALAN</option>
							<option value="1">RAWAT INAP</option>
						</select></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" value="Tampilkan" style="float:right" /></td>
					</tr>
				</table>
		</fieldset>
    </form>
</div>