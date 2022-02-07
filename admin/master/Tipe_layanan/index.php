<?php
session_start();
include '../../inc/koneksi.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='../../../index.php';
                        </script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ADMINISTRATOR -- Sistem Informasi Manajemen Rumah Sakit</title>
<link type="text/css" href="../../inc/menu/menu2.css" rel="stylesheet" />
<script type="text/javascript" src="../../inc/menu/jquery.js"></script>
<script type="text/javascript" src="../../inc/menu/menu.js"></script>                
</head>

<body>
        <div id="wrapper">
            <div id="header">
				<?php include("../../inc/header.php");?>
            </div>
			<div id="topmenu">
			     <?php include("../../inc/menu/menu.php"); ?>
			</div>
			<div id="content" align="center">
				<iframe height="72" width="130" name="sort" id="sort"
				src="../theme/dsgrid_sort.php" scrolling="no"
				frameborder="0"
				style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
				</iframe>
				<div style="text-align:center; font-size:18px; font-weight:bold; font-family:'Comic Sans MS', cursive">.: Tipe Customer Care :.</div>
				<br>
				<div id="panel" align="right" style="width:700px;">
				<input id="txtid" type="hidden">
					<img id="tambah" src="../../icon/add.gif" width="20" height="20" title="Tambah" style="cursor:pointer;">&nbsp;&nbsp;
					<img id="edit" src="../../icon/edit.gif" width="20" height="20" title="Ubah" style="cursor:pointer;">&nbsp;&nbsp;
					<img id="delete" src="../../icon/delete.gif" width="20" height="20" title="Hapus" style="cursor:pointer;">
				</div>
				<div align="center" id="grid"></div>
				<div align="center" id="paging"></div>
				<div id="form_input" style="display:none;">
					<form id="form_tipe">
					<input type="hidden" id="act" name="act" value="add">
					<input type="hidden" id="complain_id" name="complain_id" value="">
						<table>
							<tr>
								<td>Unit</td>
								<td>:</td>
								<td><select id="unit_id" name="complainunit">
								<?php
									$sql="SELECT mu.`idunit`, mu.`namaunit`
											FROM
											  rspelindo_hcr.`ms_jabatan_pegawai` mjp 
											  INNER JOIN rspelindo_hcr.pgw_jabatan pj 
											    ON pj.`JBT_ID` = mjp.`ID`  
											  INNER JOIN rspelindo_hcr.`ms_unit` mu
											    ON mu.`idunit` = pj.`UNIT_ID` 
											WHERE mjp.`JABATAN_PENGESAH` IN (6,5,1,7) AND mjp.`ID` NOT IN (2,3,6,7,85)";
									$rs=mysql_query($sql);
									while($rows=mysql_fetch_array($rs))
									{
										echo "<option value=\"".$rows['idunit']."\">".$rows['namaunit']."</option>";
									}
								?>
								</select></td>
							</tr>
							<tr>
								<td>Keterangan</td>
								<td>:</td>
								<td><input type="text" id="complainket" name="complainket" size="30"></td>
							</tr>
							<tr>
								<td>Type</td>
								<td>:</td>
								<td>
									<select id="complaintype" name="complaintype">
										<option value="Default" selected>Default</option>
										<option value="Person">Orang</option>
										<option value="Facility">Fasilitas</option>
									</select>&nbsp;<img src="../../images/question-mark.jpeg" style="vertical-align:middle;cursor:pointer;" title="Default untuk normal, Orang untuk pegawai, Fasilitas untuk master fasilitas"/>
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td><button type="submit">Submit</button>&nbsp;<button type="reset" id="cancel">Back</button></td>
							</tr>
						</table>
					</form>
				</div>
				<br>
			</div>
            <div id="footer">
				<?php
					$query = mysql_query("SELECT pegawai.pegawai_id, pegawai.nama,
						pgw_jabatan.id, pgw_jabatan.jbt_id,
						ms_jabatan_pegawai.id, ms_jabatan_pegawai.nama_jabatan
						FROM pegawai
						INNER JOIN pgw_jabatan ON pgw_jabatan.pegawai_id = pegawai.pegawai_id
						LEFT JOIN ms_jabatan_pegawai ON ms_jabatan_pegawai.id = pgw_jabatan.jbt_id
						WHERE pegawai.pegawai_id=".$_SESSION['user_id']);
					$i=0;
					$pegawai='';
					$jabatan='';
					while($row = mysql_fetch_array($query)){
						if($i==0)
							$pegawai = $row['nama'];
						if($i>0)
							$jabatan .= ", ";
						$jabatan .= $row['nama_jabatan'];	
						$i++; 
					}
				?>
               	<div style="float:left;">Nama: <span style="color:brown"><?php echo $pegawai;?></span></div>
				<div style="float:right;"> <span style="color:brown;"><?=$jabatan?></span> : Jabatan</div>
            </div>
            
        </div>
</body>
</html>

<script language="javascript" type="text/javascript">

gd1 = new extGrid("grid");        
gd1.setTitle(".: Daftar  :.");
gd1.setHeader("&nbsp,No,Nama Unit,Keterangan,Tipe,Status");
gd1.setColId(",NO,namaunit,complainket,complaintype,complainaktif");
gd1.setColType("string,string,string,string,string,string");
gd1.setColWidth(",50,250,150,150,100");
gd1.setWidthHeight(700,400);
gd1.setClickEvent(ambilid);
gd1.baseURL("utils.php?type=grid");                                    
gd1.init();

$(function(){
	$('#tambah').live('click',function(){
		$('#grid').hide();
		$('#panel').hide();
		$('#form_input').show();
	});

	$('#edit').live('click',function(){
		if ($('#txtid').val()!="")
		{
			$.ajax({
				type: 'post',
				url: 'utils.php',
				data: 'type=CRUD&act=read&id='+$('#txtid').val(),
				success: function(data){
					var data=data.split('||');
					$('#grid').hide();
					$('#panel').hide();
					$('#form_input').show(function(){
						$('#act').val('update');
						$('#complain_id').val(data[0]);
						$('#unit_id').val(data[2]);
						$('#complainket').val(data[1]);
						$('#complaintype').val(data[3]);
					});
				}
			});
			return false;
		}else{
			alert ('Silahkan Pilih data terlebih dahulu');
		}
	});
	
	$('#delete').live('click',function(){
		if ($('#txtid').val()!="")
		{
			confirm('Apakah anda yakin menghapus data ini?')
			{
				$.ajax({
					type: 'post',
					url: 'utils.php',
					data: 'type=CRUD&act=delete&id='+$('#txtid').val(),
					success: function(data){
						gd1.reload();
					}
				});
			}
		}else{
			alert ('Silahkan Pilih data terlebih dahulu');
		}
	});
	
	$('#cancel').live('click',function(){
		$('form')[0].reset();
		$('#grid').show();
		$('#panel').show();
		$('#form_input').hide();
		return false;
	});
	
	$('#form_tipe').submit(function(){
		$.ajax({
			type: 'POST',
			url: 'utils.php',
			data: 'type=CRUD&'+$(this).serialize(),
			success : function(data){
				if (data=='sukses')
				{
					alert("Berhasil");
					$('#cancel').click();
					gd1.reload();
				}else{
					alert("Gagal");
				}
			}
		});
		return false;
	});
});

function ambilid(){
	var a = gd1.getSelRowId('idext');
	var data = a.split("|");
	$('#txtid').val(data[0]);
}

function goFilterAndSort(abc){
	gd1.loadURL("utils.php.php?type=grid&filter="+gd1.getFilter()+"&sorting="+gd1.getSorting()+"&page="+gd1.getPage(),"","GET");
}

</script>