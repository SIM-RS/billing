<?php
session_start();
include '../../inc/koneksi.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='../../../index.php';
                        </script>";
}
$nmbulan=array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember')
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ADMINISTRATOR -- Sistem Informasi Manajemen Rumah Sakit</title>
<script type="text/javascript" src="../../inc/menu/jquery.js"></script>
<style>
	table, tr, td
	{
		border:1px solid #98BF21;
		border-spacing:0;
	}
	.ganjil{
		background-color:#EAF2D3;
	}
	tbody tr td{
		padding-left:5px;
		color:#000055;
		font:Verdana;
		font-size:14px;
	}
	@media print{@page {size: landscape}};
</style>               
</head>

<body>
	<div style="margin:0 auto;text-align:center;">
		<h1>Report Customer Care</h1>
		<h3>Periode <?php echo $nmbulan[$_REQUEST['bulan']]." ".$_REQUEST['tahun'];?></h3>
	</div>
	<table border="0" width="1200px" style="margin:0 auto">
		<thead style="background-color:#A7C942;color:#fff;font:Arial;font-weight:bold;text-align:center">
		<tr>
			<td width="1%">No</td>
			<td width="150px">Tanggal</td>
			<td width="120px">Pengirim</td>
			<td width="200px">Unit Tujuan</td>
			<td width="120px">Pegawai Tujuan</td>
			<td width="275px">Komplain</td>
			<td width="275px">Saran</td>
		</tr>
		</thead>
		<tbody>
		<?php
				$sql="SELECT DATE_FORMAT(ts.saran_timestamp,'%d-%m-%Y %T') tanggal,IF(LEFT(ts.`saran_from`,3)='KOP',p1.`NAMA`,ka.`anggota_nama`) pengirim,  mu.`namaunit`, IFNULL(p.`nama`,'-') pegawai,ts.`saran_komplain`,ts.`saran_content` FROM rspelindo_saran.`tb_saran` ts
				LEFT JOIN rspelindo_hcr.`pegawai` p ON
				p.`PEGAWAI_ID`= ts.`saran_fk_pegawai`
				INNER JOIN rspelindo_hcr.`ms_unit` mu ON
				mu.`idunit` = ts.`saran_to_unit`
				LEFT JOIN rspelindo_hcr.`pegawai` p1 ON
				p1.`PEGAWAI_ID` = SUBSTR(ts.`saran_from` FROM 4)
				LEFT JOIN rspelindo_ksp.`ksp_anggota` ka ON
				ka.`anggota_id` = SUBSTR(ts.`saran_from` FROM 4)
				WHERE ts.`saran_aktif`=1 and date_format(ts.saran_timestamp,'%m%Y') = ".$_REQUEST['bulan'].$_REQUEST['tahun']."
				GROUP BY ts.`saran_kode`";
				$rs=mysql_query($sql);
				$no=1;
				while($rows=mysql_fetch_array($rs))
				{
					echo "<tr ".($no%2==0?null:"class=\"ganjil\"").">";
						echo "<td valign=\"top\" align=\"center\">".$no."</td>";
						echo "<td valign=\"top\">".$rows[tanggal]."</td>";
						echo "<td valign=\"top\">".ucwords(strtolower($rows[pengirim]))."</td>";
						echo "<td valign=\"top\">".ucwords(strtolower($rows[namaunit]))."</td>";
						echo "<td valign=\"top\">".ucwords(strtolower($rows[pegawai]))."</td>";
						echo "<td valign=\"top\">".ucfirst(strtolower($rows[saran_komplain]))."</td>";
						echo "<td valign=\"top\">".ucfirst(strtolower($rows[saran_content]))."</td>";
					echo "</tr>";
					$no++;	
				}
		?>
		</tbody>
	</table>
	<br />
	<div style="margin:0 auto;" align="center"><button id="pdf"><img src="../../images/pdf16x16.gif" width="12" height="12">&nbsp;Export to Pdf</button>&nbsp;<button id="close">Close</button></div>
</body>
</html>

<script language="javascript" type="text/javascript">

$(function(){
	
	$('#close').live('click',function(){
		window.close();
	});
	$('#pdf').live('click',function(){
		window.close();
	});	

});

</script>