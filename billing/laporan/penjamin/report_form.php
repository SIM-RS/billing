<?php 
	//include("../../sesi.php");
	include_once("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
?>

<div id="popup_div1" class="popup" style="width:500px;display:none;">
    <div style="float:right; cursor:pointer" class="popup_closebox">
        <img src="../../icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
		<br>
    <form id="form1" name="form1" action="kunjungan_pasien.php" method="post" target="_blank">
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
						</div>
						</td>
					</tr>
					<tr>
					  <td colspan="2" align="center">
					  <div id="trPeriode" style="display:none">
					  Periode : <input size="10" value="<?php echo $date_now;?>" class="txtcenter" id="tglAwal" name="tglAwal" readonly="readonly"/>&nbsp;<input type="button" class="btninput" id="btnTglAwal" name="btnTgl" value=" V " onClick="gfPop.fPopCalendar(document.getElementById('tglAwal'),depRange);" />&nbsp;s.d.&nbsp;<input size="10" value="<?php echo $date_now;?>" class="txtcenter" id="tglAkhir" name="tglAkhir" />&nbsp;
						<input type="button" class="btninput" id="btnTglAkhir" name="btnTgl2" value=" V " onclick="gfPop.fPopCalendar(document.getElementById('tglAkhir'),depRange);" />
						</div>
						</td>
					</tr>
					<tr id="rwJnsLay">
						<td width="40%" align="right">Jenis Layanan</td>
						<td width="60%">&nbsp;<select name="JnsLayanan" id="JnsLayanan" tabindex="26" class="txtinput" onchange="isiCombo1('TmpLayananBukanInap',this.value)"></select></td>
					</tr>
					<tr id="rwJnsLayInap">
						<td width="40%" align="right">Jenis Layanan</td>
						<td width="60%">&nbsp;<select name="JnsLayananDenganInap" id="JnsLayananDenganInap" tabindex="26" class="txtinput" onchange="isiCombo1('TmpLayananInapSaja',this.value)"></select></td>
					</tr>
                    <tr id="trJenisM">
						<td align="right">Jenis Layanan</td>
						<td>&nbsp;<select id="cmbJenisLayananM" name="cmbJenisLayananM" class="txtinput" onchange="changeM()">
							<option value="1">RAWAT JALAN</option>
							<option value="3">RAWAT INAP</option>
                            <option value="2">RAWAT DARURAT</option>
						</select>
					</tr>
                    <tr id="trTempatM">
						<td align="right">Tempat Layanan</td>
						<td>&nbsp;<select id="cmbTempatLayananM" name="cmbTempatLayananM" class="txtinput"></select>
					</tr>
					<tr id="rwTmpLay">
						<td width="40%" height="25" align="right">Tempat Layanan</td>
					  <td width="60%">&nbsp;<select name="TmpLayananBukanInap" id="TmpLayananBukanInap" tabindex="27" class="txtinput"></select></td>
					</tr>
					<tr id="rwTmpLayInap">
						<td width="40%" height="25" align="right">Tempat Layanan</td>
					  <td width="60%">&nbsp;<select name="TmpLayananInapSaja" id="TmpLayananInapSaja" tabindex="27" class="txtinput"></select></td>
					</tr>
					<tr>
						<td width="40%" align="right">Status Pasien</td>
						<td width="60%">&nbsp;<select name="StatusPas0" id="StatusPas0" tabindex="22" class="txtinput"></select>					</td>
					</tr>
					<!--tr>
						<td align="right">ICD X</td>
						<td><input size="16" id="txtIcdx" name="txticdx" class="txtinput"/></td>
					</tr>
					<tr>
						<td align="right">ICD IX</td>
						<td><input size="16" id="txtIcdix" name="txtIcdix" class="txtinput"/></td>
					</tr-->
					<tr>
                    	<td>&nbsp;</td>
						<td align="right">&nbsp;&nbsp;<input type="button" value="Tampilkan" onclick="fSubmit()" />&nbsp; <input type="button" value="import to excel" id="btnExcelN" onclick="zxc()" />&nbsp;
                        <input id="btnExpExcl" type="button" value="Export --> Excell" style="display:none" onClick="window.open('../klaimInap_Excell.php?JnsLayananDenganInap='+JnsLayananDenganInap.value+'&TmpLayananInapSaja='+TmpLayananInapSaja.value+'&cmbWaktu='+cmbWaktu.value+'&cmbBln='+cmbBln.value+'&cmbThn='+cmbThn.value+'&tglAwal='+tglAwal.value+'&tglAkhir='+tglAkhir.value+'&tglAwal2='+tglAwal2.value+'&StatusPas0='+StatusPas0.value);"/>
						<input id="btnExpExclKSO" type="button" value="Export --> Excell" style="display:none" onClick="window.open('dftr_verifikasi_jalan_inap.php?isExcel=yes&cmbJenisLayananM='+cmbJenisLayananM.value+'&cmbTempatLayananM='+cmbTempatLayananM.value+'&cmbWaktu='+cmbWaktu.value+'&cmbBln='+cmbBln.value+'&cmbThn='+cmbThn.value+'&tglAwal='+tglAwal.value+'&tglAkhir='+tglAkhir.value+'&tglAwal2='+tglAwal2.value+'&StatusPas0='+StatusPas0.value+'&user_act=<?php echo $_SESSION['userId']?>');"/>
						</td>
					</tr>
				</table>
                <input type="hidden" id="tipe_lap" name="tipe_lap" />
                <input type="hidden" name="export" id="export" value=""  />
		</fieldset>
    </form>
</div>
<script>
function zxc(){
	document.form1.export.value = 'excel';
	document.form1.submit();
	document.form1.export.value = '';
}
function fSubmit(){
	if(document.getElementById('tipe_lap').value=='9'){
		/*
		if(document.getElementById('cmbJenisLayananM').value=='3'){
			document.form1.action='dftr_verifikasi_inap.php';
		}
		else{
			document.form1.action='dftr_verifikasi_jalan.php';
		}
		*/
		document.form1.action='dftr_verifikasi_jalan_inap.php';
	}
	document.form1.submit();
}
</script>