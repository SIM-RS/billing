<?php 
include('../inc/koneksi.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<!--====================popup======================================-->
		<link rel="stylesheet" type="text/css" href="../theme/li/popup.css" />
		<script type="text/javascript" src="../theme/li/prototype.js"></script>
		<script type="text/javascript" src="../theme/li/effects.js"></script>
		<script type="text/javascript" src="../theme/li/popup.js"></script>
<body>
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
				<td width="428" align="right">
				  <input type="hidden" id="idPeg" name="idPeg" />				</td>
                <td width="60">&nbsp;</td>
                <td width="311" class="font">Group Akses : <select id="group" name="group" class="txtinput2" onchange="cmb(this.value)">
				</select></td>
			    <td width="113" class="font" align="right"><button onclick="cetak_petugas();">Cetak Data</button></td>
			</tr>
			<tr>
				<td align="center">
					<fieldset style="border-color:#D9E0E0; border:0px;">
						<table width="300" align="center">
						<tr>
							<td>
								<input type="hidden" id="tampung" name="tampung" />
								<input type="hidden" id="txtId1" name="txtId1" />
								<div id="gridx" style=" width:420px; height:400px"></div>
								<div id="paging1" style=" width:420px;display:none"></div>							</td>
						</tr>
						</table>
					</fieldset>				</td>
				<td align="center"><div style="width:60px">
					<!--<button type="button" id="kanan" name="kanan" style="cursor:pointer" onclick="kanan()"><img src="../icon/go.png" width="24" /></button><br/><br/>
					<button type="button" id="kiri" name="kiri" style="cursor:pointer" onclick="kiri()" ><img src="../icon/go2.png" width="24" /></button><br/><br/>-->
                <img id="gb1" src="../images/forward_button.png" width="50" style="cursor:pointer" onclick="kanan()" onmouseover="mosover(this.id)" onmouseout="mosout(this.id)" title="Pindah kekanan ..." />
                <br><br>
                <img id="gb2" src="../images/forward_button2.png" width="50" style="cursor:pointer" onmouseover="mosover(this.id)" onmouseout="mosout(this.id)"  onclick="kiri()"  title="Pindah kekiri ..." />
                </div>				</td>
				<td colspan="2" align="center">
					<fieldset style="border-color:#D9E0E0; border:0px;">
						<table width="300" align="center">
						<tr>
							<td>
								<div id="gridy" style=" width:420px; height:400px"></div>
								<div id="paging2" style=" width:420px; display:none"></div>							</td>
						</tr>
						</table>
					</fieldset>				</td>
			</tr>
			</table>
			</fieldset>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	</table>
	</td>
</tr>
</table>
</div>
</body>
</html>
<script language="javascript">
var idModul = '<?php echo $_REQUEST['modul']; ?>';
Request('../combo_utils.php?id=cmbGroup&value='+document.getElementById('cmbModul').value+'&defaultId=','group','','GET',cmb,'NoLoad');

function mosover(id){
	if(id=='gb1'){
		document.getElementById(id).src= '../images/forward_buttonUp.png';
		document.getElementById(id).width = 60;
	}
	if(id=='gb2'){
		document.getElementById(id).src= '../images/forward_buttonUp2.png';
		document.getElementById(id).width = 60;
	}
}
function mosout(id){
	if(id=='gb1'){
		document.getElementById(id).src= '../images/forward_button.png';
		document.getElementById(id).width = 50;
	}
	if(id=='gb2'){
		document.getElementById(id).src= '../images/forward_button2.png';
		document.getElementById(id).width = 50;
	}
}

gdx = new extGrid("gridx");        
gdx.setTitle(".: Daftar Pegawai :.");
gdx.setHeader("&nbsp;,No,User Name,Nama, Jenis");
gdx.setColId("CEK,NO,user_name,NAMA,NAMA_JENIS");
gdx.setColType("string,string,string,string,string");
gdx.setColAlign("center,center,left,left,left");
gdx.setColWidth("30,50,100,180,150");
gdx.setWidthHeight(420,395);
gdx.setClickEvent(ambilx);
//alert("group_petugasUtils.php?grd=1&idModul="+idModul+"&kode=true&saring=true&sharing=");
gdx.baseURL("group_petugasUtils.php?grd=1&idModul="+idModul+"&kode=true&saring=true&sharing=");                                    
gdx.init();
//grid 2=========================
gdy = new extGrid("gridy");        
gdy.setTitle(".: Daftar Pegawai :.");
gdy.setHeader("&nbsp;,No,User Name,Nama,Setting");
gdy.setColId("CEK,NO,user_name,NAMA,SETTING");
gdy.setColType("string,string,string,string,string");
gdy.setColWidth("30,40,80,150,105");
gdy.setColAlign("center,center,left,left,center");
gdy.setWidthHeight(420,395);
gdy.setClickEvent(ambily);
gdy.baseURL("group_petugasUtils.php?grd=2&idGroup="+document.getElementById('group').value+"&kode=true&saring=true&sharing=");                
gdy.init();


function ambilx(){}
function ambily(){
//var tab = tabbar.getActiveTab(); //alert(tab)
var a = gdy.getSelRowId('idexts').split('|'); //alert(a[0]);
document.getElementById('idPeg').value = a[0];
document.getElementById('namax').value = a[1];
//tabbar.forceLoad("a4","tmptlayanan.php?modul="+document.getElementById('cmbModul').value+"&idPeg="+document.getElementById('idPeg').value);

}

function cmb(){
	var cmb=document.getElementById('group').value;
	gdy.reload("group_petugasUtils.php?grd=2&idGroup="+cmb+"&kode=true&saring=true&sharing=");
}

function cmb2(){
	var cmb=document.getElementById('group').value;
	gdx.reload("group_petugasUtils.php?grd=1&idModul="+idModul+"&idGroup="+cmb+"&kode=true&saring=true&sharing=");
}

var data='';
function kirimkanan(){
data='';
var cek=0;
	for(var r = 0; r<gdx.getMaxRow();r++){
		var px = "cekbok_"+r; 
		if(document.getElementById(px).checked){
			cek = 1;
			data += document.getElementById(px).value+"|";
		}
	}
	
	if(cek==0){
		alert('Pilih/centang pegawai');
	}
}
function kirimkiri(){
data='';
var cek=0;
	for(var r = 0; r<gdy.getMaxRow();r++){
		var px = "cekbok2_"+r; 
		if(document.getElementById(px).checked){
			cek = 1;
			data += document.getElementById(px).value+"|";
		}
	}
	
	if(cek==0){
		alert('Pilih/centang pegawai');
	}
}
function kanan(){
	kirimkanan();
	gdx.loadURL("group_petugasUtils.php?act=kanan&grd=1&idModul="+idModul+"&idGroup="+document.getElementById('group').value+"&data="+data,'','GET');
	setTimeout('cmb()', 1000);
}


function kiri(){
	kirimkiri();
	gdy.loadURL("group_petugasUtils.php?act=kiri&grd=2&idGroup="+document.getElementById('group').value+"&data="+data,'','GET');
	setTimeout('cmb2()', 1000);
}

function cetak_petugas()
{
	var group_id = document.getElementById('group').value;
	var group_nama = document.getElementById('group').options[document.getElementById('group').selectedIndex].text;
	
	var modul_id = document.getElementById('cmbModul').value;
	var modul_nama = document.getElementById('cmbModul').options[document.getElementById('cmbModul').selectedIndex].text;
	
	var url = "cetak_petugas.php?group_id="+group_id+"&group_nama="+group_nama+"&modul_id="+modul_id+"&modul_nama="+modul_nama;
	OpenWnd(url,1000,700,'Petugas di Group Aplikasi',true);
}
</script>
