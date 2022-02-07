<?php 
include('../inc/koneksi.php');

$modul_id = $_REQUEST['modul'];
?>

<div id="Table_01">
<table width="1000" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td align="center">
		<table width="900" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td>&nbsp;</td>
		</tr>
        <?php
		include("../inc/koneksi.php");
		$sql="select * from ms_modul where id=".$_REQUEST['modul'];
		$kueri=mysql_query($sql);
		$modl=mysql_fetch_array($kueri);
		mysql_free_result($kueri);
		mysql_close($conn);
		?>
        <tr>
			<td style="text-transform:uppercase; font-weight:bold; font-size:18px" align="center"><?php echo $modl['nama']; ?></td>
		</tr>
        <tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
		<td>
			<fieldset  style="border-color:#D9E0E0; border:0px;">
			<table width="900" align="center">
			<tr>
				<!--td align="right">
					<input type="hidden" id="idPeg" name="idPeg" />
					<img src="../icon/edit_add.png" style="cursor:pointer" width="20" onclick="popup1()" title="add pegawai" />&nbsp;&nbsp;
					<img src="../icon/gtk_edit.png" style="cursor:pointer" width="20" onclick="editPop()" title="edit pegawai" />&nbsp;&nbsp;
					<img src="../icon/erase.png" style="cursor:pointer" width="20" onclick="del()" title="hapus pegawai" />
				</td-->
                <td align="center">
				<table align="center" cellpadding="2" cellspacing="2" width="500">
				<tr>
					<td class="font">Kode</td>
					<td><input type="text" id="kodes" name="kodes" class="txtinput3"></td>
				</tr>
				<tr>
					<td class="font">Nama</td>
					<td><input type="text" id="nama" name="nama" class="txtinput3"></td>
				</tr>
				<tr>
					<td class="font">Keterangan</td>
					<td><textarea id="ket" name="ket" class="txtinput2"></textarea></td>
				</tr>
				<tr>
					<td class="font">Status</td>
					<td><input type="checkbox" id="statuse" name="statuse">&nbsp;Aktif</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  </tr>
				<tr>
					<td>&nbsp;</td>
					<td><button id="simpans" onclick="simpan()" style="cursor:pointer" ><img src="../icon/add.gif" width="20" align="absmiddle" />&nbsp;Simpan</button>
                        <button id="batal" onclick="kosong()" style="cursor:pointer"><img src="../icon/back.png" width="20" align="absmiddle" />Batal</button>
						<button id="hapus" onclick="hapus()" style="cursor:pointer"><img src="../icon/delete.gif" width="20" align="absmiddle" />Hapus</button>					</td>
				</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td align="center">
					<fieldset style="border-color:#D9E0E0; border:0px;">
						<input type="hidden" id="tampung" name="tampung" />
                        <input type="hidden" id="mid" name="mid" />
						<input type="hidden" id="txtId1" name="txtId1" /><br />
						<div id="grid1" style=" width:840px; height:450px"></div>
						<div id="paging1" style=" width:840px"></div>
					</fieldset>
				</td>
			</tr>
			</table>
			</fieldset>
		</td>
	</tr>
	</table>
	</td>
</tr>
</table>
</div>

<script language="javascript" type="text/javascript">

gd1 = new extGrid("grid1");        
gd1.setTitle(".: Daftar Grup :.");
gd1.setHeader("&nbsp,No,Kode,Nama,Keterangan,Status");
gd1.setColId(",NO,KODE,NAMA,KET,STATUS");
gd1.setColType("string,string,string,string,string,string");
gd1.setColWidth(",30,100,220,260,70");
gd1.setWidthHeight(700,400);
gd1.setClickEvent(ambilid);
gd1.baseURL("extgridgrp.php?modul=<?php echo $modul_id ?>&kode=true&saring=true&sharing=");                                    
gd1.init();

function ambilid(){
	var a = gd1.getSelRowId('idext');
	var data = a.split("|");
	//alert(data);
	document.getElementById('mid').value = data[0]
	document.getElementById('kodes').value = data[1];
	document.getElementById('nama').value = data[2];
	document.getElementById('ket').value = data[3];
	document.getElementById('simpans').value = "Update";
	document.getElementById('simpans').innerHTML ='<img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Update';
	//document.getElementById('status').checked = true;
	if(data[4]==1){
		document.getElementById('statuse').checked = true;
	}else{
		document.getElementById('statuse').checked = false;
		}
}

function simpan(){
	//var ii=document.getElementById('statuse').checked;
	if(document.getElementById('nama').value=='' || document.getElementById('kodes').value==''){
		alert("Mohon Mengisi Data dengan Lengkap!!");
	}else{
		var istat=0;
		if(document.getElementById('statuse').checked==true){
		 istat=1;
		}
		var xx="&isi="+document.getElementById('kodes').value+"|"+document.getElementById('nama').value+"|"+document.getElementById('ket').value+"|"	+istat+"|"+document.getElementById('mid').value;
		if(document.getElementById('simpans').value =="Update"){
			gd1.loadURL("extgridgrp.php?act=update"+xx+"&modul=<?php echo $modul_id ?>&kode=true&saring=true&sharing=");
			kosong();
		}else{
			//alert("extgridgrp.php?act=simpan"+xx+"&modul=<?php echo $modul_id ?>&kode=true&saring=true&sharing=");
			gd1.loadURL("extgridgrp.php?act=simpan"+xx+"&modul=<?php echo $modul_id ?>&kode=true&saring=true&sharing=","",true);
			kosong();
		}
	}
}

function hapus(){
	var ihapus=document.getElementById('mid').value
	if(ihapus==''){
		alert("Anda Belum Memilih Data Untuk Dihapus");
	}else{
		var answer = confirm ("Apakah Ingin Menghapus Item ini?")
		if (answer)
		gd1.loadURL("extgridgrp.php?act=hapus&mid="+ihapus+"&modul=<?php echo $modul_id ?>&kode=true&saring=true&sharing=");
		
	}
}

function kosong(){
	document.getElementById('mid').value='';
	document.getElementById('kodes').value = '';
	document.getElementById('nama').value = '';
	document.getElementById('ket').value = '';
	document.getElementById('simpans').innerHTML ='<img src="../icon/add.gif" width="20" align="absmiddle" />&nbsp;Simpan';
}


function goFilterAndSort(abc){
	gd1.loadURL("extgridgrp.php?grd=1&idGroup="+document.getElementById('group').value+"&filter="+gd1.getFilter()+"&sorting="+gd1.getSorting()+"&page="+gd1.getPage(),"","GET");
}

function editPop(){
	if(document.getElementById('idPeg').value=='' || document.getElementById('idPeg').value==null){
		alert("Pilih dulu data yang akan di edit !")
	}else{
		new Popup('popGrPet',null,{modal:true,position:'center',duration:1});
		document.getElementById('popGrPet').popup.show();
		var sisip=gd1.getRowId(gd1.getSelRow()).split("|");
		/* document.getElementById("pass").value=sisip[1];
		document.getElementById("passKon").value=sisip[1]; */
		document.getElementById('namaPeg').value=gd1.cellsGetValue(gd1.getSelRow(),4);
		document.getElementById("user").value=gd1.cellsGetValue(gd1.getSelRow(),3);
		document.getElementById('sim').value="update";
		document.getElementById('sim').innerHTML='<img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Ubah';
	}
}
function del(){
	var idPeg=document.getElementById('idPeg').value;
	if(document.getElementById('idPeg').value=='' || document.getElementById('idPeg').value==null){
		alert("Pilih dulu data yang akan di hapus !")
	}else{
	if(confirm("Apkah anda yakin ingin menghapus data ini ?"))
	gd1.loadURL("extgridgrp.php?grd=1&act=hapus&idPeg="+idPeg,"","GET");
	document.getelementById('namaPeg').value='';
	document.getElementById('idPeg').value='';
	document.getElementById('sim').value='simpan';
	document.getElementById('sim').innerHTML='<img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Simpan';
	}
	kosong();
}

</script>