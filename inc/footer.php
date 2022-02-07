<?php
	include './inc/koneksi.php';
	$user = $_SESSION['userid'];
	
//	$sql = "SELECT pegawai_id, user_name, nama FROM pegawai WHERE pegawai_id = '".$user."'";
	/*ms_jabatan_pegawai.id, ms_jabatan_pegawai.nama_jabatan*/
	$sql = "SELECT pegawai.pegawai_id, pegawai.nama,
				pgw_jabatan.id, pgw_jabatan.jbt_id,
				ms_jabatan_pegawai.id, ms_jabatan_pegawai.nama_jabatan
			FROM pegawai
			INNER JOIN pgw_jabatan ON pgw_jabatan.pegawai_id = pegawai.pegawai_id
			LEFT JOIN ms_jabatan_pegawai ON ms_jabatan_pegawai.id = pgw_jabatan.jbt_id
			WHERE pegawai.pegawai_id = '".$user."'";
//	echo "<br/><br/>".$user;
/*	$sql = "SELECT pegawai.pegawai_id, pegawai.nama,
				pgw_jabatan.id, pgw_jabatan.jbt_id,
				ms_jabatan_pegawai.id, ms_jabatan_pegawai.nama_jabatan,
				a_ms_group_petugas.id,
				a_ms_group.nama AS hakakses
			FROM pegawai
			INNER JOIN pgw_jabatan ON pgw_jabatan.pegawai_id = pegawai.pegawai_id
			INNER JOIN ms_jabatan_pegawai ON ms_jabatan_pegawai.id = pgw_jabatan.jbt_id
			INNER JOIN a_ms_group_petugas ON a_ms_group_petugas.ms_pegawai_id = pegawai.pegawai_id
			INNER JOIN a_ms_group ON a_ms_group.id = a_ms_group_petugas.ms_group_id"; */
	
	$query = mysql_query($sql);
	$i=0;
	while($row = mysql_fetch_array($query)){

?>
<link href="../inc/css/style.css" rel="stylesheet" type="text/css">

<table width="100%">
	<tr>
		<td width="2%">&nbsp;</td>
		<td align="left">
			<?php
				if($i==0){

//				echo "<font size='2'><b style='text-decoration:normal'>Login as : </b>";
				echo "<font size='2'><b style='text-decoration:normal'>Login : </b>";
				echo "<b style='color:blue;text-decoration:normal'>".$row['nama']."</b></font>";
				
				}
			?>
		</td>
		<td align="right">
			<?php
				if($i==0){
					
				echo "<font size='2'><b style='color:blue;text-decoration:normal'>".$row['nama_jabatan']."</b>";
				echo "<b style='text-decoration:normal'> : Jabatan</b></font>";
				
				}
			?>
		</td>
		<td width="2%">&nbsp;</td>
	</tr>
</table>

<?php $i++; } ?>