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
		$sqlCE = "SELECT GROUP_CONCAT(pemeriksaan_id) as idCek FROM b_tindakan_lab 
				  WHERE pelayanan_id = '{$idPel}' AND kunjungan_id = '{$idKunj}'";
		$queryCE = mysql_fetch_array(mysql_query($sqlCE));
		return $queryCE['idCek'];
	}
	$idCek = getIdCek();
	
	function cekSub($idSub){
		$sqlCek = "select * from b_ms_f_pemeriksaan_lab where parent_id = $idSub";
		$jumCek = mysql_num_rows(mysql_query($sqlCek));
		return $jumCek;
	}
	function treeSub($id){
		$sqlSub = "select * from b_ms_f_pemeriksaan_lab where parent_id = $id";
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
	
	$sql = "SELECT lab.`nama` FROM b_tindakan_lab btl
			INNER JOIN b_ms_f_pemeriksaan_lab lab
				ON btl.`pemeriksaan_id` = lab.`id`
			WHERE pelayanan_id = '{$idPel}' AND kunjungan_id = '{$idKunj}'
			ORDER BY parent_id";
	$query = mysql_query($sql);
	while($data = mysql_fetch_array($query)){
		echo "<div class='coba'>".$data['nama']."</div>";
	}
?>
