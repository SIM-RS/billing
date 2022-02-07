<?php
session_start();
include '../../inc/koneksi.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='../../../index.php';
                        </script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ADMINISTRATOR -- Sistem Informasi Manajemen Rumah Sakit</title>
<link type="text/css" href="../../inc/menu/menu2.css" rel="stylesheet" />
<script type="text/javascript" src="../../inc/menu/jquery.js"></script>
<script type="text/javascript" src="../../inc/menu/menu.js"></script>                
</head>

<body>
        <div id="wrapper">
            <div id="header">
				<?php include("../../inc/header.php");?>
            </div>
			<div id="topmenu">
			     <?php include("../../inc/menu/menu.php"); ?>
			</div>
			<div id="content" align="center">
			<br/>
				<div align="center" style="background-color:#A7C942;width:700px;height:30px;border:2px solid #98BF21;font-size:18px; font-weight:bold; font-family:'Comic Sans MS', cursive; color:#FFF">
				.: Report Customer Care :.
				</div>
				<div align="center" style="background-color:#EAF2D3;width:700px;min-height:100px;border:2px solid #98BF21;border-top:0;padding-top:5px;">
					<table>
						<tr>
							<td>Bulan</td>
							<td>
								<select id="bulan">
									<option value="01" <?=date('m')=='01'?"Selected":null;?>>Januari</option>
									<option value="02" <?=date('m')=='02'?"Selected":null;?>>Februari</option>
									<option value="03" <?=date('m')=='03'?"Selected":null;?>>Maret</option>
									<option value="04" <?=date('m')=='04'?"Selected":null;?>>April</option>
									<option value="05" <?=date('m')=='05'?"Selected":null;?>>Mei</option>
									<option value="06" <?=date('m')=='06'?"Selected":null;?>>Juni</option>
									<option value="07" <?=date('m')=='07'?"Selected":null;?>>Juli</option>
									<option value="08" <?=date('m')=='08'?"Selected":null;?>>Agustus</option>
									<option value="09" <?=date('m')=='09'?"Selected":null;?>>September</option>
									<option value="10" <?=date('m')=='10'?"Selected":null;?>>Oktober</option>
									<option value="11" <?=date('m')=='11'?"Selected":null;?>>November</option>
									<option value="12" <?=date('m')=='12'?"Selected":null;?>>Desember</option>
								</select>
							</td>
							<td>&nbsp;Tahun</td>
							<td>
								<select id="tahun">
									<?php
										$years=range(date('Y')-5,date('Y')+1);
										foreach ($years as $year)
										{
											echo "<option value=\"".$year."\" ".(date('Y')==$year?"Selected":null).">".$year."</option>";
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="4" align="center"><br><button id="Openfile" type="button">Submit</button></td>
						</tr>
					</table>
				</div>
				<br>
			</div>
            <div id="footer">
				<?php
					$query = mysql_query("SELECT pegawai.pegawai_id, pegawai.nama,
						pgw_jabatan.id, pgw_jabatan.jbt_id,
						ms_jabatan_pegawai.id, ms_jabatan_pegawai.nama_jabatan
						FROM pegawai
						INNER JOIN pgw_jabatan ON pgw_jabatan.pegawai_id = pegawai.pegawai_id
						LEFT JOIN ms_jabatan_pegawai ON ms_jabatan_pegawai.id = pgw_jabatan.jbt_id
						WHERE pegawai.pegawai_id=".$_SESSION['user_id']);
					$i=0;
					$pegawai='';
					$jabatan='';
					while($row = mysql_fetch_array($query)){
						if($i==0)
							$pegawai = $row['nama'];
						if($i>0)
							$jabatan .= ", ";
						$jabatan .= $row['nama_jabatan'];	
						$i++; 
					}
				?>
               	<div style="float:left;">Nama: <span style="color:brown"><?php echo $pegawai;?></span></div>
				<div style="float:right;"> <span style="color:brown;"><?=$jabatan?></span> : Jabatan</div>
            </div>
            
        </div>
</body>
</html>

<script language="javascript" type="text/javascript">


$(function(){
	
	$('#Openfile').live('click',function(){
		window.open('report.php?bulan='+$('#bulan').val()+'&tahun='+$('#tahun').val());
	});	

});

</script>