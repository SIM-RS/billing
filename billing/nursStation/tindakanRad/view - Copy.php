<style type="text/css">
	.coba{
		float:left;
		width:150px;
		text-align:center;
		padding:5px;
		margin:3px;
		border:1px solid #000;
	}
	.coba:hover{
		background:#ececec;
	}
</style>
<?php
	include("../../koneksi/konek.php");
	$idPel = $_REQUEST['idPel'];
	$idKunj = $_REQUEST['idKunj'];
	
	$cekAct = 0;
	function getIdCek(){
		$sqlCE = "SELECT GROUP_CONCAT(pemeriksaan_id) as idCek FROM b_tindakan_rad 
				  WHERE pelayanan_id = '{$idPel}' AND kunjungan_id = '{$idKunj}'";
		$queryCE = mysql_fetch_array(mysql_query($sqlCE));
		return $queryCE['idCek'];
	}
	$idCek = getIdCek();
	
	function cekSub($idSub){
		$sqlCek = "SELECT DISTINCT mt.id,mt.nama 
					FROM b_ms_tindakan mt
					INNER JOIN b_ms_tindakan_kelas mtk ON mt.id=mtk.ms_tindakan_id
					INNER JOIN b_ms_tindakan_unit mtu ON mtu.ms_tindakan_kelas_id=mtk.id
					INNER JOIN b_ms_klasifikasi mk ON mk.id=mt.klasifikasi_id
					INNER JOIN b_ms_kelompok_tindakan mkt ON mkt.id=mt.kel_tindakan_id
					WHERE mtu.ms_unit_id=61 AND mt.kel_tindakan_id=$idSub ORDER BY mt.nama";
		$jumCek = mysql_num_rows(mysql_query($sqlCek));
		return $jumCek;
	}
	function treeSub($id){
		$sqlSub = "SELECT DISTINCT mt.id,mt.nama 
					FROM b_ms_tindakan mt
					INNER JOIN b_ms_tindakan_kelas mtk ON mt.id=mtk.ms_tindakan_id
					INNER JOIN b_ms_tindakan_unit mtu ON mtu.ms_tindakan_kelas_id=mtk.id
					INNER JOIN b_ms_klasifikasi mk ON mk.id=mt.klasifikasi_id
					INNER JOIN b_ms_kelompok_tindakan mkt ON mkt.id=mt.kel_tindakan_id
					WHERE mtu.ms_unit_id=61 AND mt.kel_tindakan_id=$id ORDER BY mt.nama";
		//echo $sqlSub."<br />";
		$jum = mysql_num_rows(mysql_query($sqlSub));
		$i = 1;
		if($jum != 0){
			$querySub = mysql_query($sqlSub);
			while($dataSub = mysql_fetch_array($querySub)){
				//$edit = explode('|',cekEdit($dataSub['id']));
				//echo $dataSub['level']."---<br />";
				if($dataSub['level'] > 0){
					echo str_repeat('-',$dataSub['level']);
				}
				echo "child-{$id}: ".$dataSub['nama'].'<br />';
				treeSub($dataSub['id']);
				$i++;
			}
		}
		//return $edit[1];
	}
	
	/*$sql = "select * from b_ms_f_pemeriksaan_lab where parent_id = 0";
	$jumParent = mysql_num_rows(mysql_query($sql));
	$query = mysql_query($sql);	
	$j = 1;
	while($data = mysql_fetch_array($query)){
		//$jumSub = cekSub($data['id']);
		echo $j.'. Parent : '.$data['nama']."<br />";
		treeSub($data['id']);
		$j++;
	} */
	
	$sql = "SELECT lab.id, IF(mkt.nama IS NULL,lab.nama,mkt.nama) AS nama
				FROM b_tindakan_rad btl 
				LEFT JOIN b_ms_kelompok_tindakan mkt
					ON mkt.id = btl.pemeriksaan_id
				LEFT JOIN b_ms_tindakan lab 
					ON btl.`pemeriksaan_id` = lab.`id` 
			WHERE pelayanan_id = '{$idPel}' AND kunjungan_id = '{$idKunj}'";
			//ORDER BY parent_id";
	$query = mysql_query($sql);
	while($data = mysql_fetch_array($query)){
		echo "<div class='coba'>".$data['nama']."</div>";
	}
?>
