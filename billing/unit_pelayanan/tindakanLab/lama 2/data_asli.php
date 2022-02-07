<script type="text/javascript">
	var treeData = [
<?php
	include("../../koneksi/konek.php");
	//$cekAct = 0;
	function cekEdit($id){
		//$edit = "";
		$sqlCE = "SELECT pemeriksaan_id FROM b_tindakan_lab 
				  WHERE pelayanan_id = '".$_REQUEST['idPel']."' AND kunjungan_id = '".$_REQUEST['idKunj']."' AND pemeriksaan_id = '{$id}'";
		$queryCE = mysql_num_rows(mysql_query($sqlCE));
		if($queryCE > 0){
			$edit = " select: true,";
			//$cekAct += 1;
		}
		return $edit;
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
				$expand = '';
				$children = '';
				$ctup = '';
				$jumSub = cekSub($dataSub['idx']);
				$koma = '';
				if($jumSub > 0){
					$expand = ', expand: false,'.$edit;
					$children = 'children:[ ';
					$ctup = ']';
				} else {
					$expand = ', '.$edit;
				}
				if($i != $jum){
					$koma = ',';
				}
				
				$status = 1;
				$color = '"'.$dataSub['nama'].'"';
				if($dataSub['nm']==2){
					$cekColor = colorCek($dataSub['idx']);
					if($cekColor != 0){
						$color = '"'.$dataSub['nama'].'"';
					} else {
						$color ='"<span style=\'color:red;\'>'.$dataSub['nama'].'</span>"';
						$status = 0;
					}
				}
				
				echo '{title: '.$color.', key: "'.$dataSub['idx'].'|'.$dataSub['nm'].'||'.$status.'"'.$expand;
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
		$expand = '';
		$children = '';
		$ctup = '';
		$koma = '';
		$jumSub = cekSub($data['id']);
		if($jumSub > 0){
			$expand = ', expand: false,'.$edit;
			$children = 'children:[ ';
			$ctup = ']';
		}
		if($j != $jumParent){
			$koma = ',';
		}
		echo '{title: "'.$data['nama'].'", key: "'.$data['id'].'|1||1"'.$expand;
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
			selectMode: 3,			
			children: treeData,
			onSelect: function(select, node) {
				// Get a list of all selected nodes, and convert to a key array:
				var selKeys = $.map(node.tree.getSelectedNodes(), function(node){
					return node.data.key;
				});
				$("#key").val(selKeys.join(","));
				//$("#echoSelection3").text(selKeys.join(", "));
				
				/* // Get a list of all selected TOP nodes
				var selRootNodes = node.tree.getSelectedNodes(true);
				// ... and convert to a key array:
				var selRootKeys = $.map(selRootNodes, function(node){
					return node.data.key;
				});
				$("#echoSelectionRoots3").text(selRootNodes.join(", "));
				$("#echoSelectionRootKeys3").text(selRootKeys.join(", ")); */
			},
			onClick: function(node, event) {
				if( node.getEventTargetType(event) == "title" )
					node.toggleSelect();		
			},		
			onKeydown: function(node, event) {
				if( event.which == 32 ) {
					node.toggleSelect();
					return false;
				}
			}
			// The following options are only required, if we have more than one tree on one page:
			/* initId: "treeData",
			cookieId: "dynatree-Cb3",
			idPrefix: "dynatree-Cb3-" */
		});
		$("#treeTindakanLab").dynatree("option", "fx", { height: "toggle", duration: 200 });
	});
	
	function simpan(){
		//alert('Under Construction');
		var act = jQuery('#act').val();
		if(act == 'save'){
			parent.getidRujukTindakanLab($('#key').val());
		}else if(act == 'edit'){ 
			act = "Update";
			jQuery("#tindakanLab").ajaxSubmit
			({
				success:function(msg)
				{
					if(msg=='sukses')
					{
						alert('Data berhasil di '+act);
						parent.document.getElementById('div_popup_iframe').popup.hide();
					}
					else if(msg=='gagal')
					{
						alert('Data gagal di '+act);
						parent.document.getElementById('div_popup_iframe').popup.hide();
					}
					else
					{
						alert('Data sudah lewat 1 hari, jadi tidak boleh diganti!');
						parent.document.getElementById('div_popup_iframe').popup.hide();
					}
				},
			});
			return false
		}
	}
<?
	$sGet = "SELECT GROUP_CONCAT(pemeriksaan_id) as pemeriksaan_id FROM b_tindakan_lab 
			 WHERE pelayanan_id = '".$_REQUEST['idPel']."' AND kunjungan_id = '".$_REQUEST['idKunj']."'";
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