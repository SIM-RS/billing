<script type="text/javascript">
	var treeData = [
<?php
	include("../../koneksi/konek.php");
	$kelasId = $_REQUEST['kelasId'];
	//$tipe_periksa_lab=0;
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
	
	function cekSub($idSub,$tipe){
		//if($_REQUEST['awal']==1){
		if($tipe==0){
			$sqlCek = "SELECT id,kode,nama_kelompok as nama
					FROM
					b_ms_kelompok_lab where parent_id = $idSub AND LEVEL<>0
					UNION
					SELECT id,kode,nama 
					from b_ms_pemeriksaan_lab
					where kelompok_lab_id = $idSub and aktif = 1";
		}elseif($tipe==1){
			$sqlCek = "SELECT id,kode,nama FROM b_ms_tindakan 
			
			
			WHERE kel_tindakan_id = $idSub AND aktif=1";
		}else{
			$sqlCek = "select id, kode, nama_kelompok as nama
						from b_ms_kelompok_tindakan_pemeriksaan_lab
						where parent_id = '$idSub' and level <> 1
						UNION
						SELECT
						  mt.id,
						  mt.kode,
						  mt.nama
						FROM b_ms_tindakan mt
						  INNER JOIN b_ms_kelompok_tindakan_pemeriksaan_lab_tind mktplt
							ON mt.id = mktplt.ms_tind_id
						WHERE mktplt.ms_kel_tind_lab_id = '$idSub'
							AND mktplt.aktif = 1
							AND mt.aktif = 1
						ORDER BY nama";
		}
		//echo $sqlCek."<br>";
		$jumCek = mysql_num_rows(mysql_query($sqlCek));
		return $jumCek;
	}
	
	function colorCek($idSub,$tipe){
		//$sqlCek = "SELECT COUNT(id) jml FROM b_ms_normal_lab WHERE id_pemeriksaan_lab = '{$idSub}'";
		//if($_REQUEST['awal']==1){
		if($tipe==0){
			$sqlCek = "SELECT COUNT(id) jml FROM b_ms_pemeriksaan_lab WHERE id = $idSub AND isDalam = 1";	
		}else{
			$sqlCek = "SELECT COUNT(id) jml FROM b_ms_pemeriksaan_lab WHERE id = $idSub AND isDalam = 1";	
		}
		
		$jumCek = mysql_fetch_array(mysql_query($sqlCek));
		return $jumCek['jml'];
	}
	
	function treeSub($id,$tipe){
		global $kelasId;
		//if($_REQUEST['awal']==1){
		if($tipe==0){
			$sqlSub = "SELECT id,id as idx,kode,nama_kelompok as nama, 1 as nm
					FROM
					b_ms_kelompok_lab where parent_id = $id AND LEVEL<>0
					UNION
					SELECT 0 as id,id as idx,kode,nama, 2 as nm
					from b_ms_pemeriksaan_lab
					where kelompok_lab_id = $id and aktif = 1";
		}elseif($tipe==1){
			$sqlSub = "SELECT 0 AS id, id AS idx, '' kode, nama, 2 as nm
					FROM  b_ms_tindakan 
					WHERE kel_tindakan_id = $id AND aktif=1";
		}else{
			$sqlSub = "SELECT
						  0 AS id,
						  mt.id AS idx,
						  mt.kode,
						  mt.nama,
						  2 AS nm
						FROM b_ms_tindakan mt
						  INNER JOIN b_ms_kelompok_tindakan_pemeriksaan_lab_tind mktplt
							ON mt.id = mktplt.ms_tind_id
						WHERE mktplt.ms_kel_tind_lab_id = '$id'
							AND mktplt.aktif = 1
							AND mt.aktif = 1
						UNION
						select id, id as idx, kode, nama_kelompok as nama, 1 as nm
						from b_ms_kelompok_tindakan_pemeriksaan_lab
						where parent_id = '$id' AND level <> 1
						ORDER BY nama";
		}
		//echo $sqlSub."<br>";
		$jum = mysql_num_rows(mysql_query($sqlSub));
		$i = 1;
		if($jum != 0){
			$querySub = mysql_query($sqlSub);
			while($dataSub = mysql_fetch_array($querySub)){
				$edit = cekEdit($dataSub['idx']."|".$dataSub['nm']);
				$expand = '';
				$children = '';
				$ctup = '';
				$jumSub = cekSub($dataSub['idx'],$tipe);
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
					//$cekColor = colorCek($dataSub['idx']);
					$idKelas = 1;
					$ksoId = $_REQUEST['ksoId'];
					if($kelasId != 1){
						$idKelas = '1,'.$kelasId;
					}
					$sHarga = "SELECT tarip FROM b_ms_tindakan_kelas 
								WHERE ms_tindakan_id = '".$dataSub['idx']."' AND ms_kelas_id in ({$idKelas})
								ORDER BY ms_kelas_id DESC";
								// echo $sHarga;
					
					//Perubahan harga terhadap penjamin *melly
					//namun masih ada kendala, dimana semua harga jadi mengikuti tindakan yang sudah diatur
					// $sHarga = "SELECT tarip FROM b_ms_tindakan_kelas 
					// 			WHERE ms_tindakan_id = '".$dataSub['idx']."' AND kso_id = $ksoId AND ms_kelas_id in ({$idKelas})
					// 			ORDER BY ms_kelas_id DESC";
					$qHarga = mysql_query($sHarga);
					if(mysql_num_rows($qHarga) > 0){
						$dHarga = mysql_fetch_array($qHarga);
						$harga = $dHarga['tarip'];
					}
					$color = '"'.$dataSub['nama'].' [Rp '.$harga.']"';
					/*
					if($cekColor != 0){
						$color = '"'.$dataSub['nama'].'"';
					} else {
						$color ='"<span style=\'color:red;\'>'.$dataSub['nama'].'</span>"';
						$status = 0;
					}
					*/
				}
				
				echo '{title: '.$color.', key: "'.$dataSub['idx'].'|'.$dataSub['nm'].'||'.$status.'"'.$expand;
				echo $children;
				treeSub($dataSub['id'],$tipe);
				echo $ctup.'}'.$koma.'';
				$i++;
			}
		}
		//return $edit[1];
	}
	
	//if($_REQUEST['awal']==1){
	if($tipe_periksa_lab==0){
		$sql = "SELECT id,kode,nama_kelompok as nama
			FROM
			b_ms_kelompok_lab where parent_id=0";
	}elseif($tipe_periksa_lab==1){
		$sql = "SELECT id,'' kode,nama FROM b_ms_kelompok_tindakan WHERE ms_klasifikasi_id=5 AND aktif = 1 AND is_baru=1";
	}else{
		$sql = "SELECT id,kode,nama_kelompok AS nama FROM b_ms_kelompok_tindakan_pemeriksaan_lab WHERE aktif = 1 AND parent_id = 0";
	}
	// echo $sql."<br>";
	$query = mysql_query($sql);	
	$jumParent = mysql_num_rows($query);
	$j = 1;
	while($data = mysql_fetch_array($query)){
		//$edit = explode('|',cekEdit($data['id']));
		$edit = cekEdit($data['id']."|1");
		$expand = '';
		$children = '';
		$ctup = '';
		$koma = '';
		$jumSub = cekSub($data['id'],$tipe_periksa_lab);
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
		$edit2 = treeSub($data['id'],$tipe_periksa_lab);
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
						alert('Data berhasil di '+act+""+msg);
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
<?php
	//if($_REQUEST['awal']==1){
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
