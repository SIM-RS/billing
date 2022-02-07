<?php 
	//include_once("koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
?>
<div id="popup_div1" class="popup" style="width:500px;display:block;">
    <div style="float:right; cursor:pointer" class="popup_closebox" onclick="resetF()">
        <img src="http://<?php echo $_SERVER['HTTP_HOST']?>/simrs/keuangan/icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
		<br>
    <form id="form1" name="form1" action="pendapatan.php" method="post" target="_blank">
	<input id="user_act" name="user_act" type="hidden" value="<?php echo $_SESSION['userId']?>" />
    <input id="isPavilyun" name="isPavilyun" type="hidden" value="" />
    <input id="isFarmasi" name="isFarmasi" type="hidden" value="" />
    <input id="excell" name="excell" type="hidden" value="0" />
		<fieldset>
			<legend>Kriteria Laporan</legend>
				<table width="450" align="center">
					<tr id="trJReport" style="visibility:collapse">
                    	<td align="right">Jenis Laporan :&nbsp;</td>
						<td align="left"><select id="cmbJReport" name="cmbJReport" class="txtinput" onchange="fJReportChange(this.value)">
						<option value="0" selected="selected">Rekap&nbsp;</option>
						<option value="1">Detail&nbsp;</option>
						</select></td>
					</tr>
					<tr id="trWaktu">
                    	<td align="right">Waktu :&nbsp;</td>
						<td align="left"><select id="cmbWaktu" name="cmbWaktu" class="txtinput" onchange="setBln(this.value)">
						<option value="Harian" selected="selected">Harian</option>
						<option value="Bulanan">Bulanan</option>
						<option value="Rentang Waktu">Rentang Waktu</option>
						</select></td>
					</tr>
					<tr id="trHarian" style="visibility:visible">
                    	<td align="right">Tanggal :&nbsp;</td>
						<td align="left">
						<input size="10" value="<?php echo $date_now;?>" class="txtcenter" id="tglAwal2" name="tglAwal2" readonly="readonly"/>&nbsp;<input type="button" class="btninput" id="btnTglAwal" name="btnTgl" value=" V " onClick="gfPop.fPopCalendar(document.getElementById('tglAwal2'),depRange);" />
						</td>
					</tr>
					<tr id="trBulan" style="visibility:collapse">
                    	<td align="right">Bulan :&nbsp;</td>
						<td align="left">
						<select class="txtinput" id="cmbBln" name="cmbBln"></select>&nbsp;<select class="txtinput" id="cmbThn" name="cmbThn"></select>
						</td>
					</tr>
					<tr id="trPeriode" style="visibility:collapse">
                      <td align="right">Periode :&nbsp;</td>
					  <td align="left">
					  <input size="10" value="<?php echo $date_now;?>" class="txtcenter" id="tglAwal" name="tglAwal" readonly="readonly"/>&nbsp;
					  <input type="button" class="btninput" id="btnTglAwal" name="btnTgl" value=" V " onClick="gfPop.fPopCalendar(document.getElementById('tglAwal'),depRange);" />
					  s.d.
					  <input size="10" value="<?php echo $date_now;?>" class="txtcenter" id="tglAkhir" name="tglAkhir" readonly />&nbsp;
						<input type="button" class="btninput" id="btnTglAkhir" name="btnTgl2" value=" V " onclick="gfPop.fPopCalendar(document.getElementById('tglAkhir'),depRange);" />
						</td>
					</tr>
					<tr id="rwJnsTransaksi">
						<td align="right">Jenis Transaksi :&nbsp;</td>
						<td><select id="cmbJnsPend" name="cmbJnsPend" class="txtinput">
						</select></td>
					</tr>
                    <tr id="rwTipeTransaksi" style="visibility:collapse">
						<td align="right">Tipe Transaksi :&nbsp;</td>
						<td><select id="cmbTipeTrans" name="cmbTipeTrans" class="txtinput">
                        <option value="0">SEMUA</option>
                        <option value="1">Penerimaan</option>
                        <option value="2">Pengeluaran</option>
						</select></td>
					</tr>
					<tr id="rwTipeTransaksi2" style="visibility:collapse">
						<td align="right">Tipe Transaksi&nbsp;</td>
						<td><select id="cmbTipeTransObat" name="cmbTipeTransObat" class="txtinput">
                        <option value="0">SEMUA</option>
                        <option value="1">Sudah Dikembalikan</option>
                        <option value="2">Belum Dikembalikan</option>
						</select></td>
					</tr>
					<tr id="rwKso">
						<td align="right">Penjamin :&nbsp;</td>
						<td><select id="cmbKsoRep" name="cmbKsoRep" onchange="fKlaimChange()" class="txtinput">
						</select></td>
					</tr>
					<tr id="trKlaim" style="visibility:collapse">
                    	<td align="right">Data Klaim :&nbsp;</td>
						<td align="left"><select id="cmbKlaim" style="max-width:285px;" name="cmbKlaim" class="txtinput">
						<option value="0" selected="selected"> - </option>
						</select></td>
					</tr>
					<tr>
						<td colspan="2">
                            <input type="button" value="Export Excell" style="float:right" onclick="fSubmitReport();" />
                        	<input type="submit" value="Tampilkan" style="float:right" />
                        </td>
					</tr>
				</table>
		</fieldset>
    </form>
</div>