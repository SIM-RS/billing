<!-- <?php
/* $url = explode('/',$_SERVER['REQUEST_URI']);//$_SERVER['REQUEST_URI'];
$margin = '';
if(isset($url[4]) && $url[4] != '' || isset($url[3]) && $url[3] != ''){
    $url = '../images/foot.gif';
    $margin = 'margin-top: 10px; ';
}
else{
    $url = 'images/foot.gif';
}

*/
 ?>
<div style="<?php //echo $margin; ?>background-image: url('<?php // echo $url; ?>'); width: 1000px; height: 40px">
	img alt="foot" src="../images/foot.gif" width="1000" height="45" /
</div> -->

<?php
	include './inc/koneksi.php';
	$user = $_SESSION['userid'];
	
/*	$sql = "SELECT p.PEGAWAI_ID, jb.NAMA_JABATAN, us.username FROM pegawai p
		LEFT JOIN ms_jabatan_pegawai jb ON p.ID_JABATAN = jb.ID
		INNER JOIN ms_user us ON p.PEGAWAI_ID = us.pegawai_id
		WHERE username = '".$user."'"; */
	
	$sql = "SELECT pegawai.PEGAWAI_ID, pegawai.user_name, pgw_jabatan.JBT_ID, ms_jabatan_pegawai.ID, ms_jabatan_pegawai.nama_jabatan
			FROM pegawai
			LEFT JOIN pgw_jabatan ON pgw_jabatan.JBT_ID = pegawai.ID_JABATAN
			INNER JOIN ms_jabatan_pegawai ON ms_jabatan_pegawai.ID = pgw_jabatan.ID
			WHERE pegawai.pegawai_id = '".$user."'";
	
	$query = mysql_query($sql);
	
	while($row = mysql_fetch_array($query)){
		if($row['user_name'] == 'admin'){
			$row['NAMA_JABATAN'] = '';
?>
<link href="../inc/css/style.css" rel="stylesheet" type="text/css">

<table width="100%">
	<tr>
		<td width="5%">&nbsp;</td>
		<td align="left">
			<?php
				echo "<font size='2'><b style='text-decoration:normal'>Login as : </b>";
				echo "<b style='color:blue;text-decoration:normal'>".$row['user_name']; $row['NAMA_JABATAN']."</b></font>";											
			?>
		</td>
		<td><a href="logout.php"><div id="apDiv4"></div></a></td>
		<td align="right">
			<?php											
				echo "<font size='2'><b style='text-decoration:normal'>Hak Akses : </b>";
				echo "<b style='color:blue;text-decoration:normal'>---</b></font>";											
			?>
		</td>
		<td width="5%"></td>
	</tr>
</table>

<?php }else{ 
		if($row['NAMA_JABATAN' == 'NULL']){
			$row['NAMA_JABATAN'] = '---';
?>

<table width="100%">
	<tr>
		<td width="5%">&nbsp;</td>
		<td align="left">
			<?php
				echo "<font size='2'><b style='text-decoration:normal'>Login as : </b>";
				echo "<b style='color:blue;text-decoration:normal'>".$row['user_name']." / ".$row['NAMA_JABATAN']."</b></font>";											
			?>
		</td>
		<td><a href="logout.php"><div id="apDiv4"></div></a></td>
		<td align="right">
			<?php											
				echo "<font size='2'><b style='text-decoration:normal'>Hak Akses : </b>";
				echo "<b style='color:blue;text-decoration:normal'>---</b></font>";											
			?>
		</td>
		<td width="5%"></td>
	</tr>
</table>

<?php }}} ?>