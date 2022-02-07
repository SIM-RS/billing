<?php
session_start();
include("../sesi.php");
?>
<?php
include ("../koneksi/konek.php");
$idKunj=$_REQUEST['idKunj'];
$idUnit=$_REQUEST['idUnit'];

$qUnit="SELECT nama,parent_id idParent,
		   (SELECT nama from b_ms_unit where id=idParent) jnsLay
		   FROM b_ms_unit where id=$idUnit";
$rsUnit=mysql_query($qUnit);
$rwUnit=mysql_fetch_array($rsUnit);

$qry="SELECT no_rm,mk.nama kelas,mp.nama pasien,
DATE_FORMAT(mp.tgl_lahir,'%d-%m-%Y') tgl_lahir,kso.nama,
mp.sex,DATE_FORMAT(tk.tgl_in,'%d-%m-%Y') tgl_in,
DATE_FORMAT(tk.tgl_out,'%d-%m-%Y') tgl_out,
pk.cara_keluar,IF(tk.status_out=0,IF(tk.tgl_out IS NULL,IF(DATEDIFF(NOW(),tk.tgl_in)=0,1,DATEDIFF(NOW(),tk.tgl_in)), IF(DATEDIFF(tk.tgl_out,tk.tgl_in)=0,1,DATEDIFF(tk.tgl_out,tk.tgl_in))),
IF(tk.tgl_out IS NULL,DATEDIFF(NOW(),tk.tgl_in), DATEDIFF(tk.tgl_out,tk.tgl_in))) los,p.id pelId,(SELECT SUM(qty * (biaya_kso+biaya_pasien))
FROM b_tindakan WHERE pelayanan_id=pelId) bTind,tk.tarip,tk.beban_kso,tk.beban_pasien, mk. nama AS kelas
FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id
INNER JOIN b_ms_kelas mk ON p.kelas_id=mk.id
INNER JOIN b_ms_kso kso ON k.kso_id=kso.id
INNER JOIN b_tindakan_kamar tk ON tk.pelayanan_id=p.id
LEFT JOIN b_pasien_keluar pk ON pk.kunjungan_id=k.id
WHERE k.id=$idKunj AND p.unit_id=$idUnit";
//echo $qry."<br>";
$rst=mysql_query($qry);
$rw=mysql_fetch_array($rst);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Formulir Verifikasi (Inap) :.</title>
</head>

<body>
<table align="center" width="900" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="50" colspan="2" align="center" style="font-size:18px; font-weight:bold">FORMULIR VERIFIKASI ( <?php echo $rwUnit['jnsLay']?> )</td>
  </tr>
  <tr>
    <td height="30" colspan="2" style="font-weight:bold; border-bottom:#000000 1px solid; "><span>Nama RS : <?=$namaRS?></span><span style="margin-left:150px">Kode RS : 3515015</span><span style="margin-left:150px">Kelas RS : B </span></td>
  </tr>
  <tr>
    <td colspan="2" style="font-weight:bold">Identitas Pasien</td>
  </tr>
  <tr>
    <td colspan="2">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td width="23%">Nomor Rekam Medik</td>
				<td width="2%">:</td>
				<td width="75%">&nbsp;<?php echo $rw['no_rm']?></td>
			</tr>
			<tr>
				<td width="23%">Nama Lengkap </td>
				<td width="2%">:</td>
				<td width="75%">&nbsp;<?php echo $rw['pasien']?><span style="margin-left:100px">( <?php echo $rw['sex']?> )</span></td>
			</tr>
			<tr>
				<td width="23%">Tanggal Lahir </td>
				<td width="2%">:</td>
				<td width="75%">&nbsp;<?php echo $rw['tgl_lahir']?></td>
			</tr>
			<tr>
				<td colspan="3" style="font-weight:bold">Data Klaim / Grouping </td>
			</tr>
			<tr>
				<td width="23%">Model Pembayaran </td>
				<td width="2%">:</td>
				<td width="75%">&nbsp;<?php echo $rw['nama'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kelas : <?php echo $rw['kelas']?></td>
			</tr>
			<tr>
				<td width="23%">Nomor SKP </td>
				<td width="2%">:</td>
				<td width="75%">&nbsp;</td>
			</tr>
			<tr>
				<td width="23%">Kelas Perawatan </td>
				<td width="2%">:</td>
				<td width="75%">&nbsp;<?php echo $rw['kelas']?></td>
			</tr>
			<tr>
				<td width="23%">LOS (Length Of Stay ) </td>
				<td width="2%">:</td>
				<td width="75%">&nbsp;<?php echo $rw['los']?></td>
			</tr>
			<tr>
				<td width="23%">Tanggal Masuk </td>
				<td width="2%">:</td>
				<td width="75%">&nbsp;<?php echo $rw['tgl_in']?></td>
			</tr>
			<tr>
				<td width="23%">Tanggal Keluar </td>
				<td width="2%">:</td>
				<td width="75%">&nbsp;<?php echo $rw['tgl_out']?></td>
			</tr>
			<tr>
				<td width="23%">Cara Keluar </td>
				<td width="2%">:</td>
				<td width="75%">&nbsp;<?php echo $rw['cara_keluar']?></td>
			</tr>
			<tr>
				<td width="23%">Berat Lahir </td>
				<td width="2%">:</td>
				<td width="75%"></td>
			</tr>
			<tr>
				<td width="23%">Total Biaya </td>
				<td width="2%">:</td>
				<td width="75%">
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center" style="border:#000000 1px solid">Biaya Perawatan</td>
						<td align="center" style="border:#000000 1px solid; border-left:none">Biaya Obat</td>
						<td align="center" style="border:#000000 1px solid; border-left:none">Biaya PMI</td>
						<td align="center" style="border:#000000 1px solid; border-left:none">Total</td>
					</tr>
					<tr>
						<td align="right" style="border:#000000 1px solid; border-top:none"><?php echo number_format((($rw['beban_kso']+$rw['beban_pasien'])*$rw['los'] )+$rw['bTind'],2,",",".")?>&nbsp;</td>
						<td align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
						<td align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
						<td align="center" style="border-bottom:#000000 1px solid; border-right:#000000 1px solid">&nbsp;</td>
					</tr>
					</table>			  </td>
			</tr>
			<tr>
				<td width="23%">Surat Rujukan </td>
				<td width="2%">:</td>
				<td width="75%"></td>
			</tr>
			<tr>
				<td width="23%">BHP Khusus </td>
				<td width="2%">:</td>
				<td width="75%"></td>
			</tr>
			<tr>
				<td width="23%">Pengesahan Seventy Level 3* </td>
				<td width="2%">:</td>
				<td width="75%"></td>
			</tr>
			<tr>
				<td width="23%">Diagnosa Utama </td>
				<td width="2%">:</td>
				<td width="75%"><?php $qDiag=mysql_query("SELECT md.nama,md.kode FROM b_diagnosa d INNER JOIN b_ms_diagnosa md ON d.ms_diagnosa_id=md.id WHERE pelayanan_id=".$rw['pelId']." AND primer=1");
				while($rwDiag=mysql_fetch_array($qDiag)){
					echo $rwDiag['nama'];
				?><span style="margin-left:80px">Kode : <?php echo $rwDiag['kode']?></span><br/>
				<?php }?></td>
			</tr>
			<tr>
				<td width="23%">Diagnosa Sekunder </td>
				<td width="2%">:</td>
				<td width="75%"><?php $qDiag=mysql_query("SELECT md.nama,md.kode FROM b_diagnosa d INNER JOIN b_ms_diagnosa md ON d.ms_diagnosa_id=md.id WHERE pelayanan_id=".$rw['pelId']." AND primer=0");
				while($rwDiag=mysql_fetch_array($qDiag)){
					echo $rwDiag['nama'];
				?><span style="margin-left:80px">Kode : <?php echo $rwDiag['kode']?></span><br/>
				<?php }?></td>
			</tr>
			<tr>
				<td width="23%">Tindakan </td>
				<td width="2%">:</td>
				<td width="75%"><?php $qTind=mysql_query("SELECT mt.nama,mt.kode FROM b_tindakan t INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id WHERE t.pelayanan_id=".$rw['pelId']);
				while($rwDTind=mysql_fetch_array($qTind)){
					echo $rwDTind['nama'];
				?><span style="margin-left:80px">Kode : <?php echo $rwDTind['kode']?></span><br/>
				<?php }?></td>
			</tr>
		</table>	</td>
  </tr>
  <tr>
    <td width="452" style="font-size:10px">1. Diisi Oleh Ruang / Poli<br/>2. Dibuat Rangkap Dua<br/>3. Diserahkan Bersamaan Dengan Berkas RM / Klaim<br/>&nbsp;<br/>C2.d.ARM.Feb.Formulir Veriv.RI</td>
    <td width="448" align="right"><?=$kotaRS?>, &nbsp;&nbsp;&nbsp;<?php echo gmdate('F Y',mktime(date('H')+7))?><br/>Dokter Penanggung Jawab<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>(__________________)</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
    <tr id="trTombol">
        <td colspan="2" class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
        </td>
    </tr>
</table>
<script type="text/JavaScript">

	function cetak(tombol){
		tombol.style.visibility='collapse';
		if(tombol.style.visibility=='collapse'){
			if(confirm('Anda Yakin Mau Mencetak Verifikasi Inap ?')){
				setTimeout('window.print()','1000');
				setTimeout('window.close()','2000');
			}
			else{
				tombol.style.visibility='visible';
			}

		}
	}
</script>

</body>
</html>
<?php 
mysql_close($konek);
?>