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
					<h2>.: Master Barang :.</h2>
				</div><br/>
				
				<div style="margin: 0 0 10px 0;">
					<div style="float: left;">
						
					</div>
					
					<div style="float: right;">
						<a href="barang_tambah.php"><img alt="tambah" src="../images/tambah.png"/></a>&nbsp;&nbsp;
						<a href="#" id="ubah"><img alt="ubah" src="../images/edit.png"/></a>&nbsp;&nbsp;
						<a href="#" id="hapus"><img alt="hapus" src="../images/hapus.png"/></a>
					</div>
				</div><br/>
				
				<input type="hidden" id="id"/>
				<div id="grid"></div>
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

Ext.onReady(function (){
	function rowClick()
	{  	
		jQuery('#id').val(grid.getSelRowId());
	}
	
	grid = new extGrid('grid');        
	grid.setTitle('.: Master Barang :.');
	grid.setHeader('No,Kode,Nama Barang');
	grid.setColId('no,kode,nama');
	grid.setColType('string,string,string');
	grid.setColWidth('30,100,250');
	grid.setColAlign('center,center,left');
	grid.setWidthHeight('100%', 300);
	grid.setClickEvent(rowClick);
	grid.baseURL('barang_grid.php');                                    
	grid.init();
});

jQuery(function(){
	
	jQuery('#ubah').click(function(){
		location = 'barang_edit.php?id=' + id;
	});
	
	jQuery('#hapus').click(function(){
		if (jQuery.trim(jQuery('#id').val()) == '')
			alert('Pilih Master Unit terlebih dahulu.');
		else
		{
			
		}
	});
	
});

</script>

