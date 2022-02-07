<?php
//include("../../sesi.php");
?>
<?php 
	include_once("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
?>

<div id="popup_div1" class="popup" style="width:500px;display:none;">
	<div style="float:right; cursor:pointer" class="popup_closebox" onclick="reset_default()">
		<img src="../../icon/cancel.gif" onclick="sembunyi()" height="16" width="16" align="absmiddle"/>Tutup
	</div>
	<br>
	<form id="form1" name="form1" action="BukuRegisterPasien.php" method="post" target="_blank">
	<input id="user_act" name="user_act" type="hidden" value="<?php echo $_SESSION['userId']?>" />
	<fieldset>
		<legend>Kriteria Laporan</legend>
		<table width="450" align="center">
			<tr id="trPeriodeRpt">
				<td width="40%" align="right">&nbsp;Periode</td>
			    <td width="60%">&nbsp;<select id="cmbWaktu" name="cmbWaktu" class="txtinput" onchange="setBln(this.value)">
						<option></option>
						<option value="Harian">Harian</option>
						<option value="Bulanan">Bulanan</option>
						<option value="Rentang Waktu">Rentang Waktu</option>
					</select></td>
			</tr>
			<tr id="trHarian" style="display:none">
				<td width="40%" align="right">&nbsp;Tanggal</td>
			    <td width="60%">&nbsp;<input size="10" value="<?php echo $date_now;?>" class="txtcenter" id="tglAwal2" name="tglAwal2" readonly="readonly"/>&nbsp;<input type="button" class="btninput" id="btnTglAwal" name="btnTgl" value=" V " onClick="gfPop.fPopCalendar(document.getElementById('tglAwal2'),depRange,ubah);" /></td>
			</tr>
			<tr id="trBulan" style="display:none">
				<td align="right">&nbsp;Bulan</td>
			    <td>&nbsp;<select class="txtinput" id="cmbBln" name="cmbBln" onchange="bulanan()"><option></option></select>&nbsp;<select class="txtinput" id="cmbThn" name="cmbThn" onchange="bulanan()">
							<option></option>
						</select></td>
			</tr>
			<tr id="trPeriode" style="display:none">
				<td colspan="2" align="center">&nbsp;<input size="10" value="<?php echo $date_now;?>" class="txtcenter" id="tglAwal" name="tglAwal" readonly="readonly"/>&nbsp;<input type="button" class="btninput" id="btnTglAwal" name="btnTgl" value=" V " onClick="gfPop.fPopCalendar(document.getElementById('tglAwal'),depRange);" />&nbsp;s.d.&nbsp;<input size="10" value="<?=$date_now;?>" class="txtcenter" id="tglAkhir" name="tglAkhir" />&nbsp;
						<input type="button" class="btninput" id="btnTglAkhir" name="btnTgl2" value=" V " onclick="gfPop.fPopCalendar(document.getElementById('tglAkhir'),depRange);" /></td>
		    </tr>
			<tr id="trInstansi">
			  <td align="right">Instansi</td>
			  <td>&nbsp;<select name="cmbInstansi" id="cmbInstansi" tabindex="26" class="txtinput">
			    </select>			  </td>
		  </tr>
			<tr id="trJns">
				<td align="right">Jenis Layanan</td>
				<td>&nbsp;<select name="JnsLayanan" id="JnsLayanan" tabindex="26" class="txtinput" onchange="change()"></select></td>
			</tr>
			<tr id="trTmp">
				<td height="25" align="right">Tempat Layanan</td>
				<td>&nbsp;<select name="TmpLayanan" id="TmpLayanan" tabindex="27" class="txtinput"></select></td>
			</tr>
			<tr id="trJnsIgd">
				<td align="right">Jenis Layanan</td>
				<td>&nbsp;<select name="JnsLayananIgd" id="JnsLayananIgd" tabindex="26" class="txtinput" onchange="change()"></select></td>
			</tr>
			<tr id="trTmpIgd">
				<td height="25" align="right">Tempat Layanan</td>
				<td>&nbsp;<select name="TmpLayananIgd" id="TmpLayananIgd" tabindex="27" class="txtinput"></select></td>
			</tr>
			<tr id="jnsInap">
				<td align="right">Jenis Layanan</td>
				<td>&nbsp;<select id="JnsLayananInapSaja" name="JnsLayananInapSaja" class="txtinput" onchange="change()"></select>						
			</tr>
			<tr id="tmpInap">
				<td align="right">Tempat Layanan</td>
				<td>&nbsp;<select id="TmpLayananInapSaja" name="TmpLayananInapSaja" class="txtinput"></select>
			</tr>
			<tr id="jnsInap2">
				<td align="right">Jenis Layanan Asal</td>
				<td>&nbsp;<select id="JnsLayananInap" name="JnsLayananInap" class="txtinput" onchange="change()"></select>						
			</tr>
			<tr id="tmpInap2">
				<td align="right">Tempat Layanan Asal</td>
				<td>&nbsp;<select id="TmpLayananInap" name="TmpLayananInap" class="txtinput"></select>
			</tr>
			<tr id="trPMedik">
				<td align="right">Tempat Layanan</td>
				<td>&nbsp;<select id="TmpLayMedik" name="TmpLayMedik" class="txtinput"></select>
			</tr>
			<tr id="trJnsKunj">
				<td align="right">Jenis Kunjungan</td>
				<td>&nbsp;<select id="JnsKunjMedik" name="JnsKunjMedik" class="txtinput">
						<option value="1">RAWAT JALAN</option>
						<option value="2">RAWAT DARURAT</option>
						<option value="3">RAWAT INAP</option>
                	</select>						
			</tr>
			<tr id="trJenis">
				<td align="right">Jenis Layanan</td>
				<td>&nbsp;
					<select id="cmbJenisLayanan" name="cmbJenisLayanan" class="txtinput" onchange="change()">
						<option value="0">RAWAT JALAN</option>
						<option value="1">RAWAT INAP</option>
						<option value="2">PENUNJANG</option>
					</select>
				</td>
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
			<tr id="trTempat">
				<td align="right">Tempat Layanan</td>
				<td>&nbsp;<select id="cmbTempatLayanan" name="cmbTempatLayanan" class="txtinput"></select>
			</tr>
			<tr id="trTmpJln">
				    <td align="right">Tempat Layanan</td>
				    <td>&nbsp;<select id="TmpLayananJalan" name="TmpLayananJalan" class="txtinput"></select>
			</tr>
			<tr id="trDilayani">
				<td align="right">Status Dilayani</td>
				<td>&nbsp;
					<select id="stsDilayani" name="stsDilayani" class="txtinput">
						<option value="2">SEMUA</option>
						<option value="0">BELUM</option>
						<option value="1">SUDAH</option>
					</select>
				</td>
			</tr>
			<tr>
				
				<td align="right"><span id="hideKata" style="display: none;">Status PCR</span></td>
				<td>&nbsp;
					<div id="statusPcr" style="display: none;">
					<select name="statusPcrPasien" id="statusPcrPasien" class="txtinput">
					<option value="1">Sudah Input</option>
					<option value="0">Belum Input</option>
					</select>
					</div>

			</td>
			</tr>
			<tr id="trPenjamin">
				<td align="right">Status Pasien</td>
				<td>&nbsp;<select name="StatusPas" id="StatusPas" tabindex="22" class="txtinput"></select></td>
			</tr>
			<tr>
            	<input type="hidden" name="export" id="export" value=""  />
				<td colspan="2"><!--input type="submit" value="Tampilkan" style="float:right" /-->
				<div style="float:right">
					<button type="submit" id="tampil" style="cursor:pointer">
						<img src="../../icon/zoom_in.png" width="24" align="absmiddle" />&nbsp;Tampilkan</button>&nbsp;
						<button type="button" id="btnExpExcl" style="cursor:pointer" onClick="zxc()">
						<img src="../../icon/excel.png" width="24" align="absmiddle" />&nbsp;Export ke Excel</button>
						<button type="button" style="display: none;" id="btnExpExcl2" style="cursor:pointer" onClick="zxc2()">
						<img src="../../icon/excel.png" width="24" align="absmiddle" />&nbsp;Export ke Excel PCR</button>
						<button type="button" style="display: none;" id="btnExpExcl3" style="cursor:pointer" onClick="zxc3()"><img src="../../icon/excel.png" width="24" align="absmiddle" />&nbsp;Export ke Excel Antigen</button>
							
					</div>
				</td>
			</tr>
		</table>
	</fieldset>
	</form>
</div>
<script>
function zxc(){
	document.form1.export.value = 'excel';
	document.form1.submit();
	document.form1.export.value = '';
}

function zxc2(){
	document.getElementById('form1').action = 'LapLabPcrExcell.php';
	document.form1.submit();
	document.getElementById('form1').action = 'LapLabPcr.php';
}

function zxc3(){
	document.getElementById('form1').action = 'LapLabAntigenExcell.php';
	document.form1.submit();
	document.getElementById('form1').action = 'LapLabAntigen.php';
}

function sembunyi(){
	document.getElementById('btnExpExcl2').style.display = 'none';
	document.getElementById('btnExpExcl3').style.display = 'none';
	document.getElementById('statusPcr').style.display = 'none';
	document.getElementById('hideKata').style.display = 'none';

}
</script>