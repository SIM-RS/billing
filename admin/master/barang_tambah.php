<?php

session_start();

include '../inc/koneksi.php';

if ( ! isset($_SESSION['userid']) || $_SESSION['userid'] == '')
{
    echo "<script>
			alert('Anda belum login atau session anda habis, silakan login ulang.');
			window.location = '../../index.php';
		</script>";
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>ADMINISTRATOR -- Sistem Informasi Manajemen Rumah Sakit</title>
		<link type="text/css" href="../inc/menu/menu.css" rel="stylesheet" />
		<script type="text/javascript" src="../js/jquery-1.7.2.js"></script>
		<script type="text/javascript" src="../inc/menu/menu.js"></script> 
	</head>

	<body>
		<iframe height="72" width="130" name="sort" id="sort" src="../theme/dsgrid_sort.php" scrolling="no" frameborder="0"
			style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
		</iframe>
		
		<div id="wrapper">
			<div id="header">
				<?php include("../inc/header.php");?>
			</div>

			<div id="topmenu">
				<?php include("../inc/menu/menu.php"); ?>
			</div>

			<div id="content" style="padding: 20px;">
				<div style="margin: 0 0 10px 0; text-align: center;">
					<h2>.: Tambah Master Barang :.</h2>
				</div><br/>
				
				<div style="width:500px; margin: 0 auto 10px auto;">
					<div style="float: left;">
						
					</div>
					
					<div style="float: right;">
						<input type="button" id="kembali" value="Kembali"/>
					</div>
				</div><br/><br/><br/>
				
				<form id="form">
					<input type="hidden" id="id"/>
					<table cellspacing="10" style="width: 500px; margin: 0 auto; font-size: 12px;">
						<tr>
							<td width="20%">Kode Obat</td>
							<td width="80%"><input type="text"/></td>
						</tr>
						<tr>
							<td>Nama Obat</td>
							<td><input type="text" style="width: 300px;"/></td>
						</tr>
						<tr>
							<td>Dosis</td>
							<td><input type="text"/></td>
						</tr>
						<tr>
							<td>Satuan Kecil</td>
							<td>
								<select name="obat_satuan_kecil" id="obat_satuan_kecil">
									<?php
									$sql = "select * from rspelindo_apotek.a_satuan";
									$query = mysql_query($sql);
									while ($rows = mysql_fetch_array ($query)):
										?>
										<option value="<?php echo $rows['SATUAN']; ?>"><?php echo $rows['SATUAN']; ?></option>
										<?php 
									endwhile;
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<input type="submit" value="Simpan"/>
								<input type="reset" value="Reset"/>
							</td>
						</tr>
					</table>
				</form>
			</div>
			
			<div id="footer">
				<?php
				
				$sql = "select 
					  pegawai.pegawai_id,
					  pegawai.nama,
					  pgw_jabatan.id,
					  pgw_jabatan.jbt_id,
					  ms_jabatan_pegawai.id,
					  ms_jabatan_pegawai.nama_jabatan 
					from
					  rspelindo_hcr.pegawai 
					  inner join rspelindo_hcr.pgw_jabatan 
						on pgw_jabatan.pegawai_id = pegawai.pegawai_id 
					  left join rspelindo_hcr.ms_jabatan_pegawai 
						on ms_jabatan_pegawai.id = pgw_jabatan.jbt_id 
					where pegawai.pegawai_id = {$_SESSION['user_id']}";
				$query = mysql_query($sql);
				
				$pegawai = '';
				$jabatan = '';
				$i = 0;
				while ($row = mysql_fetch_array($query))
				{
					if ($i == 0) $pegawai = $row['nama'];
					if ($i > 0) $jabatan .= ", ";
					
					$jabatan .= $row['nama_jabatan'];
					
					$i++; 
				}
				
				?>
				
				<div style="float:left;">
					Nama: <span style="color:yellow"><?php echo $pegawai; ?></span>
				</div>
				<div style="float:right;">
					<span style="color:yellow;"><?php echo $jabatan; ?></span> : Jabatan
				</div>
			</div>
		</div>
	</body>
</html>

<script>

jQuery(function(){
	
	jQuery('#kembali').click(function(){
		location = 'barang.php';
	});
	
});

</script>

