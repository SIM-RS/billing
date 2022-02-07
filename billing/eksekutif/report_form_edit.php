<?php
	session_start();
	include "../sesi.php";
	include_once("../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
?>
<div id="popup_div1" class="popup" style="width:500px;display:none;">
    <div style="float:right; cursor:pointer" class="popup_closebox">
        <img src="../icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
		<br>
    <form id="form1" action="KinOperPendftrnPasienBaru.php" method="post" target="_blank">
	<input id="user_act" name="user_act" type="hidden" value="<?php echo $_SESSION['userId']?>" />
		<fieldset>
			<legend>Kriteria Laporan</legend>
				<table width="450" align="center">
					<tr>
						<td colspan="4" style="text-align:left; padding-left:150px;"><select id="cmbWaktu" name="cmbWaktu" class="txtinput" onchange="setBln(this.value)">
						<option></option>						
						<option value="Bulanan">Bulanan</option>
						<option value="Tahunan">Tahunan</option>
						</select></td>
					</tr>
					<tr>
					  	<td width="25%" align="right"><div id="trBlnAwal" style="display:none">
								<select class="txtinput" id="cmbBlnAwal" name="cmbBlnAwal" onchange="bulanan()"><option></option></select>
							</div></td>
						<td width="15%"><div id="trThnAwal" style="display:none">
								<select class="txtinput" id="cmbThnAwal" name="cmbThnAwal"><option></option></select>
							</div></td>
						<td width="20%"><div id="trBlnAkhir" style="display:none">
								<select class="txtinput" id="cmbBlnAkhir" name="cmbBlnAkhir" onchange="bulanan()"><option></option></select>
							</div></td>
						<td width="40%"><div id="trThnAkhir" style="display:none">
								<select class="txtinput" id="cmbThnAkhir" name="cmbThnAkhir"><option></option></select>
							</div>						</td>
					</tr>                    
					<tr>
						<td colspan="4" align="center">
						<div id="trTahunan" style="display:none">
						<select class="txtinput" id="cmbThn" name="cmbThn"><option></option></select>&nbsp;</div></td>
					</tr>
					<tr id="trJnsLay">
					  	<td colspan="2" align="right">Jenis Layanan</td>
						<td colspan="2">&nbsp;<select name="JnsLayanan" id="JnsLayanan" tabindex="26" class="txtinput" onchange="change()">
					    </select></td>
					</tr>
					<tr id="rwTmpLay">
					  	<td colspan="2" align="right">Tempat Layanan</td>
						<td colspan="2">&nbsp;<select name="TmpLayanan" id="TmpLayanan" tabindex="27" class="txtinput">
					    </select></td>
					</tr>
					<tr id="trJnsInap">
					  	<td colspan="2" align="right">Jenis Layanan</td>
						<td colspan="2">&nbsp;<select name="JnsLayananInapSaja" id="JnsLayananInapSaja" tabindex="26" class="txtinput" onchange="change()">
					    </select></td>
					</tr>
					<tr id="rwTmpInap">
					  	<td colspan="2" align="right">Tempat Layanan</td>
						<td colspan="2">&nbsp;<select name="TmpLayananInapSaja" id="TmpLayananInapSaja" tabindex="27" class="txtinput">
					    </select></td>
					</tr>
					<tr id='trKso'>
					  	<td colspan="2" align="right">Status Pasien</td>
						<td colspan="2">&nbsp;<select name="StatusPas" id="StatusPas" tabindex="22" class="txtinput">
					    </select></td>
					</tr>
					<tr>
						<td colspan="4"><input type="submit" value="Tampilkan" style="float:right" /></td>
					</tr>
				</table>
		</fieldset>
    </form>
</div>