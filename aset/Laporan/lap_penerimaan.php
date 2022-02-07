<?php
session_start();
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
	<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
	<link type="text/css" rel="stylesheet" href="../default.css"/>
	<title>.: Laporan Penerimaan Barang :.</title>
</head>

<body>
	<div align="center">
		<?php
		include '../header.php';
		?>
		<table width="1000" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0">
			<tr>
				<td style="padding-top: 10px;" align="center">
					<form action="lap_penerimaan_view.php" method="post" target="_blank">
						<table width="600" border="0" cellspacing="0" cellpadding="4">
							<tr align="center">
								<td colspan="2" class="header">
									<strong><font size="2">Laporan Penerimaan Barang</font></strong>
								</td>
							</tr>
							<tr>
								<td class="label" width="139"><strong>Unit / Satuan Kerja </strong></td>
								<td class="content" width="439">
									<?php
									$sq = mysql_query("select namadepartemen,kodedepartemen,dir_nama,dir_nip,pengurus_nama,pengurus_nip from as_setting");
									$t = mysql_fetch_array($sq);
									?>										   
									<input type="text" class="txtmustfilled" readonly value="<?php echo $t['kodedepartemen'];?>"/>
									<input type="text" class="txtmustfilled" readonly value="<?php echo $t['namadepartemen'];?>"/>								
								</td>
							</tr>
							<tr>
								<td class="label"><strong>Tahun </strong></td>
								<td class="content">
									<select name="tahun" class="txt" tabindex="1">
										<?php
										$tahun = date('Y');
										for($i = $tahun-5; $i <= $tahun; $i++){
											echo '<option value="'.$i.'" '.($i == $tahun ? 'selected' : '').'>'.$i.'</option>';
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="label"><strong>Bulan </strong></td>
								<td class="content">
									<select name="bulan" class="txt" tabindex="2">
										<?php
										$bulan = date('n');
										$arr_bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
										for($i = 1; $i <= 12; $i++){
											echo '<option value="'.str_pad($i,2,0,STR_PAD_LEFT).'" '.($i == $bulan ? 'selected' : '').'>'.$arr_bulan[$i].'</option>';
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="label"><strong>Format Laporan </strong></td>
								<td class="content"><select name="format" class="txt" tabindex="3">
										<option value="HTML">HTML</option>
										<option value="XLS">EXCEL</option>
									</select>
								</td>	
							</tr>
							<tr align="center">
								<td colspan="2" class="header2">
									<input type="submit" name="submit" value="Tampilkan" onClick="" />
								</td>
							</tr>
						</table>
					</form>
				</td>
			</tr>
			<tr>
				<td>
					<?php
					include '../footer.php';
					?>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>
