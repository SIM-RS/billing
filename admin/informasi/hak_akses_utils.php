<?php
session_start();
include '../inc/koneksi.php';
if(!isset($_SESSION['userId']) || $_SESSION['userId'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='../../index.php';
                        </script>";
}
// header("Content-type: application/vnd.ms-excel");
// header('Content-Disposition: attachment; filename="Matrics User Priviledge.xls"');
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Informasi User</title>
	<link type="text/css" href="../inc/menu/menu.css" rel="stylesheet" />
	<script type="text/javascript" src="../js/jquery-1.7.2.js"></script>
	<style type="text/css">
		body{ font-size:11px !important; font-family:Tahoma !important; 
			overflow-x: scroll;
			overflow-y: scroll;
		}
		#userAksesList {border-collapse:collapse; width:100%;}
		#userAksesList th, #userAksesList td{ border:1px solid #000; padding:5px; }
		#userAksesList th{ background: #6396C9; color: #fff; }
		#wrap{ margin:0px auto; width:100%; }
	</style>
</head>
<body align="center">
	<?php
		$fuser = (!empty($_REQUEST['user']) ? " AND p.nama like '%".$_REQUEST['user']."%'" : "");
		$fmodul = (!empty($_REQUEST['modul']) ? " AND g.modul_id = '".$_REQUEST['modul']."'" : "");
		$fmodul2 = (!empty($_REQUEST['modul']) ? " AND id = '".$_REQUEST['modul']."'" : "");
		$arrModul = array();
		$arrAkses = array();
		$qModul = mysql_query("SELECT * FROM ms_modul where 0=0 {$fmodul2} ORDER BY nama ASC");
		if($qModul && mysql_num_rows($qModul) > 0){
			while($modul = mysql_fetch_object($qModul)){
				$arrModul[$modul->id]['name'] = $modul->nama;
				$arrModul[$modul->id]['count'] = 0;
			}
			
			$sAkses = "SELECT g.id, g.nama, g.kode, g.ket, m.id modul, m.kode modulKode, m.nama modulName
						FROM ms_group g
						INNER JOIN ms_modul m ON m.id = g.modul_id
						WHERE g.aktif = 1 {$fmodul}
						ORDER BY m.nama ASC, g.nama ASC";
			$qAkses = mysql_query($sAkses);
			if($qAkses && mysql_num_rows($qAkses) > 0){
				while($akses = mysql_fetch_object($qAkses)){
					$arrModul[$akses->modul]['count'] += 1;
					$arrAkses[$akses->modul][$akses->id] = array('name' => $akses->nama, 'id' => $akses->id);
				}
			}
		}
	?>
	<table id="userAksesList" align="center">
		<thead>
			<tr>
				<th rowspan="2" style="min-width:20px">NO.</th>
				<th rowspan="2" style="min-width:200px" >PETUGAS</th>
				<?php
					foreach($arrModul as $val){
						echo "<th colspan='".$val['count']."'>".strtoupper($val['name'])."</th>";
					}
				?>
			</tr>
			<tr>
				<?php
					$aksesList = array();
					foreach($arrModul as $key => $val){
						$data = $arrAkses[$key];
						foreach($data as $val){
							echo "<th style='min-width:100px; max-width:100px'>".strtoupper($val['name'])."</th>";
							$aksesList['hak-'.$val['id']] = $val['name'];
						}
					}
				?>
			</tr>
		</thead>
		<tbody>
			<?php
				$sql = "SELECT gp.ms_group_id, gp.ms_pegawai_id, g.modul_id, p.id, p.nama, p.username, GROUP_CONCAT(gp.ms_group_id) akses
						FROM rspelindo_billing.b_ms_pegawai p
						LEFT JOIN ms_group_petugas gp ON gp.ms_pegawai_id = p.id
						LEFT JOIN ms_group g ON g.id = gp.ms_group_id
						WHERE 0 = 0 {$fuser} {$fmodul}
						GROUP BY p.id
						ORDER BY p.nama";
				$query = mysql_query($sql);
				$no = 1;
				if($query && mysql_num_rows($query) > 0){
					while($userList = mysql_fetch_object($query)){
						echo "<tr>";
						echo "<td align='right' style='min-width:20px'>".$no++."</td>";
						echo "<td style='min-width:200px'>".ucwords(strtolower($userList->nama))."</td>";
						$listAkses = explode(',',$userList->akses);
						foreach($aksesList as $key => $val){
							if(in_array(str_replace('hak-','',$key),$listAkses))
								echo "<td style='min-width:100px; background:#FAD133;'></td>";
							else
								echo "<td style='min-width:100px'></td>";
						}
						echo "</tr>";
					}
				}
			?>
		</tbody>
	</table>
</body>
</html>