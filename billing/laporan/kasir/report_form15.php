<?php 
//include_once("../../koneksi/konek.php");
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
?>

<div id="popup_div1" class="popup" style="width:500px;display:none;">
    <div style="float:right; cursor:pointer" class="popup_closebox">
        <img alt="cancel" src="../../icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
    <br>
    <form id="form1" name="form1" action="PenerimaanPasien.php" method="post" target="_blank">
        <input id="user_act" name="user_act" type="hidden" value="<?php echo $_SESSION['userId']?>" />
        <fieldset>
            <legend>Kriteria Laporan</legend>
            <table width="450" align="center">
                <tr>
                    <td align="center" colspan="2">
                        <input size="10" value="<?php echo $date_now;?>" class="txtcenter" id="tglAwal" name="tglAwal" readonly="readonly"/>
                        &nbsp;<input type="button" class="btninput" id="btnTglAwal" name="btnTgl" value=" V " onClick="gfPop.fPopCalendar(document.getElementById('tglAwal'),depRange);" />
                        &nbsp;s.d.&nbsp;<input size="10" value="<?php echo $date_now;?>" class="txtcenter" id="tglAkhir" name="tglAkhir" />
                        &nbsp;<input type="button" class="btninput" id="btnTglAkhir" name="btnTgl" value=" V " onClick="gfPop.fPopCalendar(document.getElementById('tglAkhir'),depRange);" />
                    </td>
                </tr>
                <tr id="rwJnsLay">
                    <td align="right" width="30%">Jenis Layanan</td>
                    <td width="70%">&nbsp;<select name="JnsLayanan" id="JnsLayanan" tabindex="26" class="txtinput" onchange="isiCombo1('TmpLayanan',this.value);isiCombo1('cmbKsr',this.value)"></select>
                    </td>
                </tr>
				<tr id="rwJnsLayInap">
                    <td width="40%" align="right">Jenis Layanan</td>
                    <td width="60%">&nbsp;<select name="JnsLayananDenganInap" id="JnsLayananDenganInap" tabindex="26" class="txtinput" onchange="isiCombo1('TmpLayananInapSaja',this.value)"></select></td>
                </tr>
                <tr id="rwTmpLay">
                    <td align="right" width="30%">Tempat Layanan</td>
                    <td width="70%">&nbsp;<select name="TmpLayanan" id="TmpLayanan" tabindex="27" class="txtinput"></select></td>
                </tr>
				<tr id="rwTmpLayInap">
					<td width="40%" height="25" align="right">Tempat Layanan</td>
					<td width="60%">&nbsp;<select name="TmpLayananInapSaja" id="TmpLayananInapSaja" tabindex="27" class="txtinput"></select></td>
				</tr>
				<tr id="rwKasir">
					<td width="30%" align="right">Kasir</td>
					<td width="70%">&nbsp;<select id="cmbKasir2" name="cmbKasir2" class="txtinput" onchange="isiCombo1('nmKsr',this.value)"></select>
				</tr>
				<tr id="rwNamaKasir">
					<td align="right" width="30%">Pelaksana</td>
					<td width="70%">&nbsp;<select id="nmKsr" name="nmKsr" class="txtinput" style="text-transform:uppercase"></select></td>
				</tr>
                <tr id="rwKasir2">
                    <td align="right" width="30%">Kasir</td>
                    <td width="70%">&nbsp;<select id="cmbKsr" name="cmbKsr" class="txtinput"></select>
                    </td>
                </tr>
                <tr id="rwStatusPas">
                    <td width="30%" align="right">Status Pasien</td>
                    <td width="70%">&nbsp;<select name="StatusPas" id="StatusPas" tabindex="22" class="txtinput"></select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="right">
                    <input type="hidden" id="excel" name="excel" value="" />
					<button type="button" id="export" name="export" style="cursor:pointer;float:right" onclick="exl()"  ><img src="../../icon/excel.png" width="16" height="16" align="absmiddle" />&nbsp;Export ke excel</button>&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="submit" value="Tampilkan" style="cursor:pointer;float:right" /></td>
                </tr>
            </table>
        </fieldset>
    </form>
</div>
<script>
function exl(){
/*	document.getElementById('excel').value = 'excel';
	document.getElementById('form1').submit();
	document.getElementById('excel').value = '';*/
	 var target = document.getElementById('form1').target;
	 var tipe = document.getElementById('export').name;
	 var action = document.getElementById('form1').action;
	if(target=='rincian_penerimaan_kasir_rawat_inap_berdasarkan_akhir_layanan')
	{
		document.getElementById('form1').action='Rincian_Penerimaan_Kasir_Rawat_Inap_Berdasarkan_Akhir_Layanan_xls.php';
	}
	if(target=='rekapitulasi_penerimaan_kasir_rawat_inap')
	{
		document.getElementById('form1').action='Rekapitulasi_Penerimaan_Kasir_Rawat_Inap_xls.php';
	}
	if(target=='rincian_per_nama_pasien_penerimaan_rawat_inap')
	{
		document.getElementById('form1').action='Rincian_Per_Nama_Pasien_Penerimaan_Rawat_Inap_xls.php';
	}
	if(target=='rincian_per_nama_pasien_penerimaan_rawat_inap_umum')
	{
		document.getElementById('form1').action='Rincian_Per_Nama_Pasien_Penerimaan_Rawat_Inap_Umum_xls.php';
	}
	if(target=='rincian_per_nama_pasien_penerimaan_rawat_inap_kso2')
	{
		document.getElementById('form1').action='Rincian_Per_Nama_Pasien_Penerimaan_Rawat_Inap_KSO_xls.php';
	}
	document.getElementById('excel').value = 'excel';
	document.getElementById('form1').submit();
	document.getElementById('excel').value = '';
	document.getElementById('form1').action = action;
}
</script>