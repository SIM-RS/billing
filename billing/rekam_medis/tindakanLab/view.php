<script type="text/javascript">
	var treeData = [
<?php
	include("../../koneksi/konek.php");
	$cekAct = 0;
	function cekEdit($id){
		//$edit = "";
		$sqlCE = "SELECT pemeriksaan_id FROM b_tindakan_lab 
				  WHERE pelayanan_id = '".$_REQUEST['idPel']."' AND kunjungan_id = '".$_REQUEST['idKunj']."' AND pemeriksaan_id = '{$id}'";
		$queryCE = mysql_num_rows(mysql_query($sqlCE));
		if($queryCE > 0){
			$edit = " select: true,";
			$cekAct += 1;
		}
		return $edit."|".$cekAct;
	}
	
	function cekSub($idSub){
		$sqlCek = "select * from b_ms_f_pemeriksaan_lab where parent_id = $idSub";
		$jumCek = mysql_num_rows(mysql_query($sqlCek));
		return $jumCek;
	}
	function treeSub($id){
		$sqlSub = "select * from b_ms_f_pemeriksaan_lab where parent_id = $id";
		$jum = mysql_num_rows(mysql_query($sqlSub));
		$i = 1;
		if($jum != 0){
			$querySub = mysql_query($sqlSub);
			while($dataSub = mysql_fetch_array($querySub)){
				$edit = explode('|',cekEdit($dataSub['id']));
				$expand = ',unselectable: true';
				$children = '';
				$ctup = '';
				$jumSub = cekSub($dataSub['id']);
				$koma = '';
				if($jumSub > 0){
					$expand = ', unselectable: true,  expand: true,'.$edit[0];
					$children = 'children:[ ';
					$ctup = ']';
				} else {
					$expand = ', unselectable: true, '.$edit[0];
				}
				if($i != $jum){
					$koma = ',';
				}
				echo '{title: "'.$dataSub['kode']." - ".$dataSub['nama'].'", key: "'.$dataSub['id'].'"'.$expand;
				echo $children;
				treeSub($dataSub['id']);
				echo $ctup.'}'.$koma.'';
				$i++;
			}
		}
		return $edit[1];
	}
	
	$sql = "select * from b_ms_f_pemeriksaan_lab where parent_id = 0";
	$jumParent = mysql_num_rows(mysql_query($sql));
	$query = mysql_query($sql);	
	$j = 1;
	while($data = mysql_fetch_array($query)){
		$edit = explode('|',cekEdit($data['id']));
		$expand = ', unselectable: true';
		$children = '';
		$ctup = '';
		$koma = '';
		$jumSub = cekSub($data['id']);
		if($jumSub > 0){
			$expand = ', unselectable: true, expand: true,'.$edit[0];
			$children = 'children:[ ';
			$ctup = ']';
		}
		if($j != $jumParent){
			$koma = ',';
		}
		echo '{title: "'.$data['kode']." - ".$data['nama'].'", key: "'.$data['id'].'"'.$expand;
		echo $children;
		$edit2 = treeSub($data['id']);
		echo $ctup.' }'.$koma.' ';
		$j++;
	}
?>
	];
	$(function(){		
		$('#treeTindakanLab').dynatree({	
			checkbox: true,
			children: treeData
		});
		$("#treeTindakanLab").dynatree("option", "fx", { height: "toggle", duration: 200 });
	});
	
</script>