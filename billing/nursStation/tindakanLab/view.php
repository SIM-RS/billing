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
	/* function kintil($id){
		$kintil = "SELECT count(tindakan_lab_id) AS jml FROM b_tindakan_lab 
					WHERE pelayanan_id = '".$_REQUEST['idPel']."' AND kunjungan_id = '".$_REQUEST['idKunj']."' AND pemeriksaan_id = '$id'";
		$kintil2 = mysql_fetch_array(mysql_query($kintil));
		return $kintil2['jml'];
	} */
	function cekParent($id, $param){
	if($param == 'paren'){
		$celuk = "IF(k.parent_id=0,p.kelompok_lab_id,k.parent_id) AS paren";
		$group = "k.parent_id";
	} elseif($param == 'paren2'){
		$celuk = "p.kelompok_lab_id  AS paren";
		$group = "p.kelompok_lab_id";
	} elseif($param == 'anak'){
		$celuk = "p.id AS paren";
		$group = "p.id";
	}
		$sqlPar = "SELECT $celuk FROM b_tindakan_lab t
					LEFT JOIN b_ms_pemeriksaan_lab p
					ON p.id = SUBSTRING_INDEX(t.pemeriksaan_id,'|',1)
					LEFT JOIN b_ms_kelompok_lab k
					ON k.id = p.kelompok_lab_id
					WHERE t.pelayanan_id = '$id' and p.aktif = 1
					GROUP BY $group";
		$queryPar = mysql_query($sqlPar);
		$data = array();
		while($rowPar = mysql_fetch_array($queryPar)){
			$data[] = $rowPar['paren'];
		}
		return $data;
	}
	//$cekAct = 0;
	function cekEdit($id){
		//$edit = "";
		/*$sqlCE = "SELECT pemeriksaan_id FROM b_tindakan_lab 
				  WHERE pelayanan_id = '".$_REQUEST['idPel']."' AND kunjungan_id = '".$_REQUEST['idKunj']."' AND pemeriksaan_id = '{$id}'";*/
		$sqlCE = "SELECT pemeriksaan_id FROM b_tindakan_lab 
				  WHERE pelayanan_id = '".$_REQUEST['idPel']."' AND pemeriksaan_id = '{$id}'";
		$queryCE = mysql_num_rows(mysql_query($sqlCE));
		if($queryCE > 0){
			$edit = " select: true,";
			$aaa = "checked";
			//$cekAct += 1;
		}else{
			$edit = "";
			$aaa = "";
		}
		return $edit."|".$aaa;
	}
	
	function cekSub($idSub){
		$sqlCek = "SELECT id,kode,nama_kelompok as nama
					FROM
					b_ms_kelompok_lab where parent_id = $idSub AND LEVEL<>0
					UNION
					SELECT id,kode,nama 
					from b_ms_pemeriksaan_lab
					where kelompok_lab_id = $idSub and aktif = 1";
		
		$jumCek = mysql_num_rows(mysql_query($sqlCek));
		return $jumCek;
	}
	
	function colorCek($idSub){
		$sqlCek = "SELECT COUNT(id) jml FROM b_ms_normal_lab WHERE id_pemeriksaan_lab = '{$idSub}'";
		$jumCek = mysql_fetch_array(mysql_query($sqlCek));
		return $jumCek['jml'];
	}
	
	function treeSub($id){
		$sqlSub = "SELECT id,id as idx,kode,nama_kelompok as nama, 1 as nm
					FROM
					b_ms_kelompok_lab where parent_id = $id AND LEVEL<>0
					UNION
					SELECT 0 as id,id as idx,kode,nama, 2 as nm
					from b_ms_pemeriksaan_lab
					where kelompok_lab_id = $id and aktif = 1";
		
		$jum = mysql_num_rows(mysql_query($sqlSub));
		$i = 1;
		if($jum != 0){
			$querySub = mysql_query($sqlSub);
			while($dataSub = mysql_fetch_array($querySub)){
				$edit = cekEdit($dataSub['idx']."|".$dataSub['nm']);
				$edit2 = explode('|',$edit);
				$expand = '';
				$children = '';
				$ctup = '';
				$jumSub = cekSub($dataSub['idx']);
				$koma = '';
				if($jumSub > 0){
					$expand = ', unselectable: false, expand: false,'.$edit2[0];
					$children = 'children:[ ';
					$ctup = ']';
				} else {
					$expand = ', unselectable: false, '.$edit2[0];
				}
				if($i != $jum){
					$koma = ',';
				}
				$kintil = cekParent($_REQUEST['idPel'],'paren2');
				if(in_array($dataSub['idx'],$kintil) == 1){
					/* $kuro = kintil($dataSub['idx']."|".$dataSub['nm']);
					//echo $kuro;
					if($kuro == 1){ */
					if($edit2[0] != ''){
						$test = '<input type=\'checkbox\' '.$edit2[1].' />&nbsp;';
					}else{
						$test = '<img src=\'../../icon/tree-view.png\' />&nbsp;&nbsp;';
					}
				}else{
					$test = '<input type=\'checkbox\' '.$edit2[1].' />&nbsp;';
				}
				$status = 1;
				$color = '"'.$test.$dataSub['nama'].'"';
				if($dataSub['nm']=='2'){
					$cekColor = colorCek($dataSub['idx']);
					if($cekColor != 0){
						$color = '"'.$test.$dataSub['nama'].'"';
					} else {
						$color ='"'.$test.'<span style=\'color:red;\'>'.$dataSub['nama'].'</span>"';
						$status = 0;
					}
				}
				echo '{title: '.$color.', key: "'.$dataSub['nm'].'||'.$status.'"'.$expand;
				echo $children;
				treeSub($dataSub['id']);
				echo $ctup.'}'.$koma.'';
				$i++;
			}
		}
		//return $edit[1];
	}
	
	$sql = "SELECT id,kode,nama_kelompok as nama
			FROM
			b_ms_kelompok_lab where parent_id=0";
	$jumParent = mysql_num_rows(mysql_query($sql));
	$query = mysql_query($sql);	
	$j = 1;
	while($data = mysql_fetch_array($query)){
		//$edit = explode('|',cekEdit($data['id']));
		$edit = cekEdit($data['id']."|1");
		$edit3 = explode('|',$edit);
		$expand = '';
		$children = '';
		$ctup = '';
		$koma = '';
		$jumSub = cekSub($data['id']);
		if($jumSub > 0){
			$expand = ', unselectable: false, expand: false,'.$edit3[0];
			$children = 'children:[ ';
			$ctup = ']';
		}
		if($j != $jumParent){
			$koma = ',';
		}
		$kintil = cekParent($_REQUEST['idPel'],'paren');
		if(in_array($data['id'],$kintil) == 1){
			/* $kuro = kintil($data['id']."|1");
			//echo  $kuro;
			if($kuro == 1){ */
			if($edit3[0] != ''){
				$test = '<input type=\'checkbox\' '.$edit3[1].' />&nbsp;';
			}else{
				$test = '<img src=\'../../icon/tree-view.png\' />&nbsp;&nbsp;';
			}
		}else{
			$test = '<input type=\'checkbox\' '.$edit3[1].' />&nbsp;';
		}
		echo '{title: "'.$test.$data['nama'].'", key: "'.$data['id'].'|1||1"'.$expand;
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
	//$sGet = "SELECT GROUP_CONCAT(pemeriksaan_id) as pemeriksaan_id FROM b_tindakan_lab 
	//		 WHERE pelayanan_id = '".$_REQUEST['idPel']."' AND kunjungan_id = '".$_REQUEST['idKunj']."'";
	$sGet = "SELECT GROUP_CONCAT(pemeriksaan_id) as pemeriksaan_id FROM b_tindakan_lab 
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