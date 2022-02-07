<?php 
	//include("../../sesi.php");
	include_once("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
?>

<div id="popup_div1" class="popup" style="width:500px;display:none;">
    <div style="float:right; cursor:pointer" class="popup_closebox">
        <img src="../../icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
		<br>
    <form id="form1" action="KinOperPendftrnPasienBaru.php" method="post" target="_blank">
	<input id="user_act" name="user_act" type="hidden" value="<?php echo $_SESSION['userId']?>" />
		<fieldset>
			<legend>Kriteria Laporan</legend>
				<table width="450" align="center">
					<tr>
						<td colspan="2" align="center"><select id="cmbWaktu" name="cmbWaktu" class="txtinput" onchange="setBln(this.value)">
						<option></option>
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
					<tr>
						<td width="40%" align="right">Jenis Layanan</td>
						<td width="60%">&nbsp;<select name="JnsLayanan" id="JnsLayanan" tabindex="26" class="txtinput" onchange="isiCombo1('TmpLayanan',this.value)"></select></td>
					</tr>
					<tr id="rwTmpLay">
						<td width="40%" align="right">Tempat Layanan</td>
						<td width="60%">&nbsp;<select name="TmpLayanan" id="TmpLayanan" tabindex="27" class="txtinput"></select></td>
					</tr>
					<tr>
						<td width="40%" align="right">Status Pasien</td>
						<td width="60%">&nbsp;<select name="StatusPas" id="StatusPas" tabindex="22" class="txtinput"></select></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" value="Tampilkan" style="float:right" /></td>
					</tr>
				</table>
		</fieldset>
    </form>
</div>