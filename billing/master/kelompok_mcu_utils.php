<?php 
include("../koneksi/konek.php"); 
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
}else {
    header("Content-type: text/xml");
}

$grd = $_REQUEST['grd'];

$sortDefault = "ORDER BY tindakan ASC";
$sorting = "";

if($_REQUEST['sorting'] != ''){
	$sorting = "ORDER BY " . $_REQUEST['sorting'];
}

$filterSql = "";
$page=$_REQUEST["page"];
$filter = "";
if($_REQUEST['filter'] != ''){
$filter = explode('|', mysql_real_escape_string($_REQUEST['filter']));
$filterSql = " WHERE {$filter[0]} LIKE '%{$filter[1]}%'";
}
$act = $_REQUEST['act'];
$nama_kelompok = mysql_real_escape_string($_REQUEST['nama_kelompok']);
$aktif = mysql_real_escape_string($_REQUEST['aktif']);

$unitId = $_REQUEST['unitId'];
$idKelompokMcu = mysql_real_escape_string($_REQUEST['idKelompokMcu']);
$idTindakanKelas = mysql_real_escape_string($_REQUEST['idTindakanKelas']);
$user_id = mysql_real_escape_string($_REQUEST['user_id']);
$dokter_id = mysql_real_escape_string($_REQUEST['dokterId']);
$type_dokter = mysql_real_escape_string($_REQUEST['dokterPengganti']);
$dataArr = explode(',',$idTindakanKelas);
$idTempatLayanan = mysql_real_escape_string($_REQUEST['id_tempat_layanan']);
switch ($act) {
	case "tambahKelompok":
		$sql = "INSERT INTO b_ms_mcu_kelompok(nama_kelompok,aktif,tanggal_act,flag) VALUES('{$nama_kelompok}',{$aktif},now(),1)";
		if(mysql_query($sql)){
			$dataBalik = [
				'status' => 1,
				'msg' => 'Berhasil memasukan data',
			];
			echo json_encode($dataBalik);
			exit();
		}else{
			$dataBalik = [
				'status' => 0,
				'msg' => 'Gagal memasukan data',
			];
			echo json_encode($dataBalik);
			exit();
		}
		break;
	case "updateData":
		$sql = "UPDATE b_ms_mcu_kelompok set nama_kelompok = '{$nama_kelompok}',aktif = {$aktif},flag = 1 WHERE id = {$idKelompokMcu}";
		if(mysql_query($sql)){
			$dataBalik = [
				'status' => 1,
				'msg' => 'Berhasil update data',
			];
			echo json_encode($dataBalik);
			exit();
		}else{
			$dataBalik = [
				'status' => 0,
				'msg' => 'Gagal update data',
			];
			echo json_encode($dataBalik);
			exit();
		}
		break;
	case "deleteKelompok":
		$sql = "DELETE FROM b_ms_mcu_kelompok WHERE id = {$idKelompokMcu}";
		$sqlKelompokTindakan = "DELETE FROM b_ms_mcu_kelompok_tindakan WHERE id_mcu_kelompok = {$idKelompokMcu}";
		if(mysql_query($sql) && mysql_query($sqlKelompokTindakan)){
			$dataBalik = [
				'status' => 1,
				'msg' => 'Berhasil hapus data',
			];
			echo json_encode($dataBalik);
			exit();
		}else{
			$dataBalik = [
				'status' => 0,
				'msg' => 'Gagal hapus data',
			];
			echo json_encode($dataBalik);
			exit();
		}
		break;
	case "tambahKelompokTindakan":
		for($i = 0; $i < sizeof($dataArr)-1; $i++){

		$sqlCek = "SELECT * FROM b_ms_mcu_kelompok_tindakan WHERE id_tindakan_kelas = {$dataArr[$i]} AND id_tmpt_layanan = {$unitId} AND id_mcu_kelompok = {$idKelompokMcu}";
			echo $sqlCek;
			if(mysql_num_rows(mysql_query($sqlCek)) > 0) continue;

			$sql = "INSERT INTO b_ms_mcu_kelompok_tindakan(id_mcu_kelompok,id_tindakan_kelas,id_tmpt_layanan,tanggal_act,user_id,dokter_id,type_dokter)VALUES({$idKelompokMcu},{$dataArr[$i]},{$unitId},now(),{$user_id},{$dokter_id},{$type_dokter})";
			mysql_query($sql);	
		}
		break;
	case "deleteKelompokTindakan" :
		for($i = 0; $i < sizeof($dataArr)-1; $i++){
			$sql = "DELETE FROM b_ms_mcu_kelompok_tindakan WHERE id = {$dataArr[$i]}";
			mysql_query($sql);	
		}
		break;
	case "tambahTempatLayanan" :
		$sqlCheck = "SELECT * FROM b_ms_mcu_kelompok_tempat_layanan WHERE id_tempat_layanan = {$idTempatLayanan} AND id_kelompok_mcu = {$idKelompokMcu}";
		if(mysql_num_rows(mysql_query($sqlCheck)) > 0){
			$sql = "DELETE FROM b_ms_mcu_kelompok_tempat_layanan WHERE id_tempat_layanan = {$idTempatLayanan} AND id_kelompok_mcu = {$idKelompokMcu}";
			if(mysql_query($sql)){
				$dataBalik = [
					'status' => 1,
					'msg' => 'Berhasil uncheck data',
				];
				echo json_encode($dataBalik);
				exit();
			}else{
				$dataBalik = [
					'status' => 0,
					'msg' => 'Gagal uncheck data',
				];
				echo json_encode($dataBalik);
				exit();
			}
		}else{
			$sql = "INSERT INTO b_ms_mcu_kelompok_tempat_layanan(id_tempat_layanan,id_kelompok_mcu,tanggal_act) VALUES({$idTempatLayanan},{$idKelompokMcu},now())";		
			if(mysql_query($sql)){
				$dataBalik = [
					'status' => 1,
					'msg' => 'Berhasil memasukan data',
				];
				echo json_encode($dataBalik);
				exit();
			}else{
				$dataBalik = [
					'status' => 0,
					'msg' => 'Gagal memasukan data',
				];
				echo json_encode($dataBalik);
				exit();
			}
		}
		
		break;
	default:
		// code...
		break;
}

switch ($grd) {
	case "kelompokMcu":
		$sql = "SELECT * FROM b_ms_mcu_kelompok {$filterSql}";
		break;
	case "kelompokTindakanMcu":
		$sql = "SELECT
					* 
				FROM
					(
					SELECT
						mk.id,
						mk.id_tindakan_kelas,
						mk.id_tmpt_layanan,
						tk.ms_tindakan_id,
						tk.ms_kelas_id,
						t.nama AS tindakan,
						kt.nama AS kelompok,
						kl.nama AS klasifikasi,
						k.nama AS kelas,
						tk.tarip,
						tk.nama_penjamin 
					FROM
					  b_ms_mcu_kelompok_tindakan mk
						INNER JOIN ( SELECT mtk.*, k.nama AS nama_penjamin FROM b_ms_tindakan_kelas mtk LEFT JOIN b_ms_kso k ON mtk.kso_id = k.id ) AS tk ON mk.id_tindakan_kelas = tk.id
						INNER JOIN b_ms_tindakan t ON tk.ms_tindakan_id = t.id
						INNER JOIN b_ms_kelompok_tindakan kt ON t.kel_tindakan_id = kt.id
						INNER JOIN b_ms_klasifikasi kl ON t.klasifikasi_id = kl.id
						INNER JOIN b_ms_kelas k ON tk.ms_kelas_id = k.id 
					WHERE
					mk.id_tmpt_layanan = {$unitId} 
					AND mk.id_mcu_kelompok = {$idKelompokMcu}
					) AS t1 ".$filterSql . $sortDefault;
		break;
	case "dataTindakan" : 
			$sql = "SELECT
						* 
					FROM
						(
						SELECT
							tk1.kode AS kodetk,
							tk1.id,
							tk1.nama_penjamin,
							tk1.ms_tindakan_id,
							tk1.ms_kelas_id,
							t.nama AS tindakan,
							k.nama AS kelas,
							kt.nama AS kelompok,
							kl.nama AS klasifikasi,
							tk1.kode_tindakan,
							tk1.tarip 
						FROM
							(
							SELECT
								* 
							FROM
								(
								SELECT
									tk.*,
									tmptu.*,
									p.nama AS nama_penjamin 
								FROM
									b_ms_tindakan_kelas tk
									LEFT JOIN b_ms_kso p ON p.id = tk.kso_id
									LEFT JOIN ( SELECT tu.id_tindakan_kelas FROM b_ms_mcu_kelompok_tindakan tu WHERE tu.id_tmpt_layanan = {$unitId} ) AS tmptu ON tk.id = tmptu.id_tindakan_kelas

								) AS t1
								WHERE id NOT IN (SELECT id_tindakan_kelas FROM b_ms_mcu_kelompok_tindakan WHERE id_mcu_kelompok = {$idKelompokMcu})  
							) tk1
							INNER JOIN b_ms_tindakan t ON tk1.ms_tindakan_id = t.id
							INNER JOIN b_ms_kelompok_tindakan kt ON t.kel_tindakan_id = kt.id
							INNER JOIN b_ms_klasifikasi kl ON t.klasifikasi_id = kl.id
							INNER JOIN b_ms_kelas k ON tk1.ms_kelas_id = k.id 
						) AS t2 ".$filterSql ." ORDER BY tindakan";
		break;
	case "dataTempatLayanan" :
		$sql = "SELECT
					* 
				FROM
					(
					SELECT
						mu.id,
						mu.kode,
						mu.nama,
						mu1.nama jenis_layanan,
					IF
						( mu.inap = 1, 'Ya', 'Tidak' ) AS inap 
					FROM
						b_ms_unit mu
						INNER JOIN b_ms_unit mu1 ON mu.parent_id = mu1.id 
					WHERE
						mu.kategori = 2 
						AND mu.LEVEL = 2 
						AND mu.aktif = 1 
					AND mu.cabang_id = 1 
					) AS gab ". $filterSql;
		break;
	default:
		// code...
		break;
}


//paginatiaon
$query = mysql_query($sql);
$jumlahData = mysql_num_rows($query);

if($page == "" || $page == 0) $page = 1;

$totalPage = ($page - 1) * $perpage;

if($jumlahData % $perpage > 0) $totalpage = floor($jumlahData / $perpage) + 1;
else $totalpage = floor($jumlahData / $perpage);

if($page > 1) $bpage = $page - 1; else $bpage = 1;
if($page < $totalpage) $npage = $page + 1; else $npage = $totalpage;

$sql = $sql . " LIMIT $totalPage,$perpage";
$query = mysql_query($sql);
$i = ($page - 1) * $perpage;

$data = $totalpage.chr(5);

switch ($grd) {
	case "kelompokMcu":
		while($rows = mysql_fetch_assoc($query)){
			$i++;
			$aktif = "";
			if($rows['aktif'] == 1) $aktif = "Aktif";
			else $aktif = "Tidak Aktif"; 
			$data .= $rows['id'].'|'.$rows['nama_kelompok'].'|'.$rows['aktif'].chr(3).$i.chr(3).$rows['nama_kelompok'].chr(3).$aktif.chr(6);
		}
		break;
	case "kelompokTindakanMcu":
		while ($rows=mysql_fetch_array($query))
		{
			$i++;
	            $sisipan = $rows["id"]."|".$rows["id_tindakan_kelas"]."|".$rows["ms_kelas_id"]."|".$rows["ms_tindakan_id"]."|".$rows["id_tmpt_layanan"];
			$data .= $sisipan.chr(3)."0".chr(3).$rows["tindakan"].chr(3).$rows["nama_penjamin"].chr(3).$rows["kelas"].chr(3).number_format($rows["tarip"],2,',','.').chr(3).$rows["kelompok"].chr(3).$rows["klasifikasi"].chr(6);
		}
		break;
	case "dataTindakan" :
		while ($rows=mysql_fetch_array($query))
		{
			$i++;
	            $sisipan=$rows["id"]."|".$rows["ms_tindakan_id"]."|".$rows["kode_tindakan"];
			$data .= $sisipan.chr(3)."0".chr(3).$rows["tindakan"].chr(3).$rows["nama_penjamin"].chr(3).$rows["kelas"].chr(3).number_format($rows["tarip"],2,',','.').chr(3).$rows["kelompok"].chr(3).$rows["klasifikasi"].chr(6);
		}
		break;
	case "dataTempatLayanan" :
		while ($rows = mysql_fetch_array($query)){
			$i++;
			$stchecked="";
			$sql="SELECT * FROM b_ms_mcu_kelompok_tempat_layanan WHERE id_kelompok_mcu=".$idKelompokMcu." AND id_tempat_layanan=".$rows["id"];
			echo $sql;
			$rscheck=mysql_query($sql);
			if (mysql_num_rows($rscheck)>0){
				$stchecked="checked='checked'";
			}
			$data .= $rows["id"].chr(3)."<input type='checkbox' ".$stchecked." value='$rows[id]' onclick='updateTempatLayanan(this.value)' />".chr(3).$rows["kode"].chr(3).$rows["nama"].chr(3).$rows["jenis_layanan"].chr(3).$rows["inap"].chr(6);
		}
		break;
	default:
		// code...
		break;
}

if ($data != $totalpage.chr(5))
{
	$data = substr($data,0,strlen($data)-1);
	$data = str_replace('"','\"',$data);
}

echo $data;
?>