<title>.: Kwitansi Pembayaran :.</title>
<?php
		include("../sesi.php");
		include("../koneksi/konek.php");
		$date_now=gmdate('d-m-Y',mktime(date('H')+7));
?>
<style>
	.jdl
	{
		text-align:center;
		border-top:1px solid #000000;
		border-bottom:1px solid #000000;
		border-left:1px solid #000000;
		font-weight:bold;
	}
	.jdlKn
	{
		text-align:center;
		border-top:1px solid #000000;
		border-bottom:1px solid #000000;
		border-left:1px solid #000000;
		font-weight:bold;
		border-right:1px solid #000000;
	}
	.isi
	{
		border-bottom:1px solid #000000;
		border-left:1px solid #000000;
	}
	.isiKn
	{
		border-bottom:1px solid #000000;
		border-left:1px solid #000000;
		border-right:1px solid #000000;
	}
</style>
<table width="800" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td colspan="2" height="70" valign="top" style="font-size:14px; text-align:center; text-transform:uppercase; font-weight:bold;">kwitansi pembayaran<br>jasa konsul/visite dokter</td>
	</tr>
	<tr>
		<td width="50%" height="30" style="padding-left:20px; font-weight:bold;">Dokter : </td>
		<td width="50%" style="padding-right:20px; text-align:right; font-weight:bold;">Periode : </td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr>
					<td class="jdl" height="28" width="3%">NO</td>
					<td class="jdl" width="20%">NAMA PASIEN</td>
					<td class="jdl" width="7%">NO RM</td>
					<td class="jdl" width="10%">KSO</td>
					<td class="jdl" width="9%">TGL MASUK</td>
					<td class="jdl" width="9%">TGL PULANG</td>
					<td class="jdl" width="6%">JML KUNJUNGAN</td>
					<td class="jdl" width="10%">NILAI JASA</td>
					<td class="jdl" width="9%">FREE SERVICE</td>
					<td class="jdl" width="9%">Pph21 (2.5%)</td>
					<td class="jdlKn" width="8%">DITERIMA</td>
				</tr>
				<tr>
					<td class="isi">&nbsp;</td>
					<td class="isi">&nbsp;</td>
					<td class="isi">&nbsp;</td>
					<td class="isi">&nbsp;</td>
					<td class="isi">&nbsp;</td>
					<td class="isi">&nbsp;</td>
					<td class="isi">&nbsp;</td>
					<td class="isi">&nbsp;</td>
					<td class="isi">&nbsp;</td>
					<td class="isi">&nbsp;</td>
					<td class="isiKn">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="6" class="isi" align="right" height="25" style="font-weight:bold;">TOTAL&nbsp;</td>
					<td class="isi" style="font-weight:bold;">&nbsp;</td>
					<td class="isi" style="font-weight:bold;">&nbsp;</td>
					<td class="isi" style="font-weight:bold;">&nbsp;</td>
					<td class="isi" style="font-weight:bold;">&nbsp;</td>
					<td class="isiKn" style="font-weight:bold;">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td style="text-align:center;" height="100" valign="top"><?=$kotaRS;?>, <?php echo $date_now;?><br />Penerima,</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>
