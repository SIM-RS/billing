<?php
	$idKunj=$_REQUEST['idKunj'];
	$idPel=$_REQUEST['idPel'];
	$idUser = $_REQUEST['idUsr'];
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Form Prosedur Pembedahan</title>
		<link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
		<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
		<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
		<script type="text/JavaScript" language="JavaScript" src="../../unit_pelayanan/iframe.js"></script>
		<script type="text/JavaScript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>
		<script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
		
		<style type="text/css">
			body{ background:#fff; font-size:12px; font-family:Arial; }
			.formstyle table{ margin-top:10px; border-collapse:collapse; font-size:12px; }
			.formstyle th{ text-align:center; font-weight:bold; background:#ececec; }
			.formstyle table td{ padding:5px; height:auto;}
			.ProsPembedahan td{
				height:auto;
				padding:2px; margin:0px;
			}
			.border td, .border th{ border:1px solid #000; margin:0px; }
			.formstyle input[type="text"]:disabled, .formstyle input[type="number"]:disabled{ background:#ececec; border:1px solid #ececec; }
			.formstyle input[type='text'], .formstyle input[type='number']{ background:#9BBFE8; border:1px solid #808080; padding:2px; }
			.formstyle input[type='text']:focus, .formstyle input[type='number']:focus{ background:#fff; border:1px solid #808080; padding:2px; }
		</style>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				//var h1 = $(document).height();
				jQuery("#popup_iframe",top.document).css({height:328});
				jQuery(".formstyle").load('form_pb.php?idKunj=<?=$idKunj?>&idPel=<?=$idPel?>&idUsr=<?=$idUser?>',{"doh": true});
			});
		
			function disBL(a,b){
				var idTag = a.split('|');
				var i;
				
				for(i = 0; i <= (idTag.length - 1); i++){
					if( b == 'true'){
						jQuery('#'+idTag[i]).prop('disabled', b);
					} else {
						jQuery('#'+idTag[i]).removeAttr('disabled');
					}
					/* if( i != (idTag.length-1) && b == 'true'){
						$('#'+idTag[i]).val('');
					} */
				}
				//jQuery('#'+a).prop('disabled', b);
				//return false;
			}
		</script>
	</head>
	<body>
	<iframe height="193" width="168" name="gToday:normal:agenda.js"
			id="gToday:normal:agenda.js" src="../../theme/popcjs.php" scrolling="no" frameborder="1"
			style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
	</iframe>
	<iframe height="72" width="130" name="sort"
		id="sort"
		src="../../theme/dsgrid_sort.php" scrolling="no"
		frameborder="0"
		style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
	</iframe>
	<center><b style="font-size:20px;">PROSEDUR PEMBEDAHAN</b></center>
	<div class="formstyle" style="width:95%; display:none; margin:10px auto; background:#fff; border:1px solid #000;">
		<? //include("form_pb.php"); ?>
	</div>
	<center>
		<div style="width:750px; text-align:center;">
			<div style="width:100%; text-align:right;">
				<button name="tambahPB" id="tambahPB" onclick="tambahPB();">
					<img src="../../icon/edit_add.png" alt="" style="width:15px;"/> Tambah
				</button>
			</div>
			<div id="gridboxPB" style="width:750px; height:230px; background-color:white; overflow:hidden;"></div>
			<div id="pagingPB" style="width:750px;"></div>
		</div>
	</center>
	<script type="text/javascript">
		function tambahPB(){
			$(".formstyle").slideDown(1000,function(){
				toggle();
				var h = ($(document).height()+50);
				//$("#popup_iframe").css("height", h+'px');
				jQuery("#popup_iframe",top.document).css({height:h});
			});
			jQuery(".formstyle").load('form_pb.php?idKunj=<?=$idKunj?>&idPel=<?=$idPel?>&idUsr=<?=$idUser?>',{"doh": true});
			$('#tambahPB').css('display','none');
		}
		function cetakData(id){
			var idKunj = jQuery('#idKunjBedah').val();
			var idPel = jQuery('#idPelBedah').val();
			var idUser = jQuery('#idUserBedah').val();
			if(confirm('Cetak Laporan ?')){
				window.open('cetak_pb.php?idBedah='+id+'&idKunj='+idKunj+'&idPel='+idPel+'&idUser='+idUser);
			}
		}

		function editData(id){
			var idKunj = jQuery('#idKunjBedah').val();
			var idPel = jQuery('#idPelBedah').val();
			var idUser = jQuery('#idUserBedah').val();
			$('#tambahPB').css('display','inline');
			//$(".formstyle").css('display','block');
			//toggle();
			$(".formstyle").slideDown(1000,function(){toggle();});
			$(".formstyle").load('form_pb.php?idBedah='+id+'&idKunj='+idKunj+'&idPel='+idPel+'&idUsr=<?=$idUser?>');
		}

		function deleteData(id){
			if(confirm('Anda yakin ingin menghapus data ini ?')){
				jQuery.ajax({
					type: 'post',
					data: 'type=delete&idBedah='+id,
					url: 'action_pb.php',
					success: function(msg){
						alert("Data Berhasil Di Hapus");
						PB1.loadURL("pb_utils.php","","GET");				
					}
				});
			}
		}
		
		function goFilterAndSort(grd){
			if (grd=="gridboxPB"){
				PB1.loadURL("pb_utils.php?"+PB1.getFilter()+"&sorting="+PB1.getSorting()+"&page="+PB1.getPage(),"","GET");
			}
		}
		
		var PB1=new DSGridObject("gridboxPB");
		PB1.setHeader("DATA PROSEDUR PEMBEDAHAN");
		PB1.setColHeader("NO,OPERASI,TANGGAL,JENIS OPERASI,PRE OPERASI,LAMA OPERASI,ACTION");
		PB1.setIDColHeader(",operasi,tglOperasi,JenisOperasi,PreOperasi,LamaOperasi,");
		PB1.setColWidth("30,200,80,100,100,60,100");
		PB1.setCellAlign("center,left,center,center,center,center,center");
		PB1.setCellHeight(20);
		PB1.setImgPath("../../icon");
		PB1.setIDPaging("pagingPB");
		//PB1.attachEvent("onRowClick","ambilData");
		PB1.baseURL("pb_utils.php");
		PB1.Init();
	</script>
	</body>
</html>