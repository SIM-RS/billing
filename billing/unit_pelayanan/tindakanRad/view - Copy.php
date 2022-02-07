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
	.clear{
		clear:both;
	}
	ul.dynatree-container img {
		height: 11px;
		margin-top: 2px;
		margin-left: 4px;
		vertical-align: top;
		width: 11px;
		border:0.5px solid #6D7C89;
	}
</style>
<script type="text/javascript">
	var treeData = [
<?php
	include("../../koneksi/konek.php");
	//$cekAct = 0;
	function cekParent($id){
		$sqlPar = "SELECT mkt.id FROM b_tindakan_rad t 
					  INNER JOIN b_ms_tindakan mt ON mt.id = t.pemeriksaan_id 
					  INNER JOIN b_ms_kelompok_tindakan mkt ON mkt.id = mt.kel_tindakan_id 
					WHERE t.pelayanan_id = '$id'
					GROUP BY mkt.id";
		$queryPar = mysql_query($sqlPar);
		$data = array();
		while($rowPar = mysql_fetch_array($queryPar)){
			$data[] = $rowPar['id'];
		}
		return $data;
	}
	function cekEdit($id){
		//$edit = "";
/*		$sqlCE = "SELECT pemeriksaan_id FROM b_tindakan_rad 
				  WHERE pelayanan_id = '".$_REQUEST['idPel']."' AND kunjungan_id = '".$_REQUEST['idKunj']."' AND pemeriksaan_id = '{$id}'";*/
		$sqlCE = "SELECT pemeriksaan_id FROM b_tindakan_rad 
				  WHERE pelayanan_id = '".$_REQUEST['idPel']."' AND pemeriksaan_id = '{$id}'";
		$queryCE = mysql_num_rows(mysql_query($sqlCE));
		if($queryCE > 0){
			$edit = " select: true,";
			$aaa = "checked";
			//$cekAct += 1;
		}
		return $edit."|".$aaa;
	}
	
	function cekSub($idSub){
		/*
		$sqlCek = "SELECT DISTINCT mt.id,mt.nama 
					FROM b_ms_tindakan mt
					INNER JOIN b_ms_tindakan_kelas mtk ON mt.id=mtk.ms_tindakan_id
					INNER JOIN b_ms_tindakan_unit mtu ON mtu.ms_tindakan_kelas_id=mtk.id
					INNER JOIN b_ms_klasifikasi mk ON mk.id=mt.klasifikasi_id
					INNER JOIN b_ms_kelompok_tindakan mkt ON mkt.id=mt.kel_tindakan_id
					WHERE mtu.ms_unit_id=61 AND mt.kel_tindakan_id=$idSub ORDER BY mt.nama";
		*/
		$sqlCek = "SELECT DISTINCT mt.id,mt.nama 
					FROM b_ms_tindakan mt
					INNER JOIN b_ms_klasifikasi mk ON mk.id=mt.klasifikasi_id
					INNER JOIN b_ms_kelompok_tindakan mkt ON mkt.id=mt.kel_tindakan_id
					WHERE mt.kel_tindakan_id=$idSub ORDER BY mt.nama";
		$jumCek = mysql_num_rows(mysql_query($sqlCek));
		return $jumCek;
	}
	function colorCek($idSub){
		$sqlCek = "SELECT COUNT(id) jml FROM b_ms_tindakan_kelas WHERE ms_tindakan_id = '{$idSub}'";
		$jumCek = mysql_fetch_array(mysql_query($sqlCek));
		return $jumCek['jml'];
	}
	function treeSub($id){
		/*
		$sqlSub = "SELECT DISTINCT mt.id,mt.nama 
					FROM b_ms_tindakan mt
					INNER JOIN b_ms_tindakan_kelas mtk ON mt.id=mtk.ms_tindakan_id
					INNER JOIN b_ms_tindakan_unit mtu ON mtu.ms_tindakan_kelas_id=mtk.id
					INNER JOIN b_ms_klasifikasi mk ON mk.id=mt.klasifikasi_id
					INNER JOIN b_ms_kelompok_tindakan mkt ON mkt.id=mt.kel_tindakan_id
					WHERE mtu.ms_unit_id=61 AND mt.kel_tindakan_id=$id ORDER BY mt.nama";
		*/
		$sqlSub = "SELECT DISTINCT mt.id,mt.nama 
					FROM b_ms_tindakan mt
					INNER JOIN b_ms_klasifikasi mk ON mk.id=mt.klasifikasi_id
					INNER JOIN b_ms_kelompok_tindakan mkt ON mkt.id=mt.kel_tindakan_id
					WHERE mt.kel_tindakan_id=$id ORDER BY mt.nama";
		$jum = mysql_num_rows(mysql_query($sqlSub));
		$i = 1;
		if($jum != 0){
			$querySub = mysql_query($sqlSub);
			while($dataSub = mysql_fetch_array($querySub)){
				$edit = explode('|',cekEdit($dataSub['id']));
				$expand = '';
				$children = '';
				$ctup = '';
				$jumSub = cekSub($dataSub['id']);
				$koma = '';
				if($jumSub > 0){
					$expand = ', expand: false,'.$edit[0];
					$children = 'children:[ ';
					$ctup = ']';
				} else {
					$expand = ', '.$edit[0];
				}
				if($i != $jum){
					$koma = ',';
				}
				//if($edit[1] != 0){
				$status = 1;
					$cekColor = colorCek($dataSub['id']);
					if($cekColor != 0){
						$color = '"<input type=\'checkbox\' '.$edit[1].' />&nbsp;'.$dataSub['nama'].'"';
					} else {
						$color ='"<input type=\'checkbox\' '.$edit[1].' />&nbsp;<span style=\'color:red;\'>'.$dataSub['nama'].'</span>"';
						$status = 0;
					}
				//} else {
					//$color = '"'.$dataSub['nama'].'"';
				//}
				echo '{title: '.$color.', key: "'.$dataSub['id'].'||'.$status.'"'.$expand;
				echo $children;
				treeSub($dataSub['id']);
				echo $ctup.'}'.$koma.'';
				$i++;
			}
		}
		return $edit[1];
	}
	
	$sql = "SELECT id,nama FROM b_ms_kelompok_tindakan WHERE ms_klasifikasi_id='6'";
	//$sql = "select * from b_ms_kelompok_lab where parent_id = 0";
	$jumParent = mysql_num_rows(mysql_query($sql));
	$query = mysql_query($sql);	
	$j = 1;
	while($data = mysql_fetch_array($query)){
		$edit = explode('|',cekEdit($data['id']));
		$expand = '';
		$children = '';
		$ctup = '';
		$koma = '';
		$jumSub = cekSub($data['id']);
		if($jumSub > 0){
			$expand = ', expand: false,'.$edit[0];
			$children = 'children:[ ';
			$ctup = ']';
		}
		if($j != $jumParent){
			$koma = ',';
		}
		$kintil = cekParent($_REQUEST['idPel']);
		if(in_array($data['id'],$kintil) == 1){
			if($edit[1] == ''){
				$test = '<img src=\'../../icon/tree-view.png\' />&nbsp;&nbsp;';
			}else{
				$test = '<input type=\'checkbox\' '.$edit[1].' />&nbsp;';
			}
		}else{
			$test = '<input type=\'checkbox\' '.$edit[1].' />&nbsp;';
		}
		echo '{title: "'.$test.$data['nama'].'", key: "'.$data['id'].'||1"'.$expand;
		echo $children;
		$edit2 = treeSub($data['id']);
		echo $ctup.' }'.$koma.' ';
		$j++;
	}
?>
	];
	$(function(){		
		$('#treeTindakanLab').dynatree({	
			checkbox: false,
			selectMode: 3,
			children: treeData,
			disabled: true
		});
		$("#treeTindakanLab").dynatree("option", "fx", { height: "toggle", duration: 200 });
	});
	
<?
	/*$sGet = "SELECT GROUP_CONCAT(pemeriksaan_id) as pemeriksaan_id FROM b_tindakan_rad 
			 WHERE pelayanan_id = '".$_REQUEST['idPel']."' AND kunjungan_id = '".$_REQUEST['idKunj']."'";*/
	$sGet = "SELECT GROUP_CONCAT(pemeriksaan_id) as pemeriksaan_id FROM b_tindakan_rad 
			 WHERE pelayanan_id = '".$_REQUEST['idPel']."'";
	/*$nGet = mysql_num_rows($sGet);
	if($nGet != 0){		*/
		$qGet = mysql_query($sGet);
		$dGet = mysql_fetch_array($qGet);
	/*}*/
		//$data = substr($data,0,strlen($data)-1);
?>
	$(document).ready(function(){
		$('#key').val('<?=$dGet['pemeriksaan_id']?>');
	});
</script>
