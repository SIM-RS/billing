<?php
session_start();
include '../inc/koneksi.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='../../index.php';
                        </script>";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ADMINISTRATOR -- Sistem Informasi Manajemen Rumah Sakit</title>
<link type="text/css" href="../inc/menu/menu.css" rel="stylesheet" />
<script type="text/javascript" src="../js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="../inc/menu/menu.js"></script> 
</head>

<body>
	
        <div id="wrapper">
            <div id="header">
				<?php include("../inc/header.php");?>
            </div>
            
          <div id="topmenu">
                 <?php include("../inc/menu/menu.php"); ?>
          </div>
            
            <div id="content">
			
<center>
<iframe height="72" width="130" name="sort" id="sort"
src="../theme/dsgrid_sort.php" scrolling="no"
frameborder="0"
style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
   
		
        <table width="1000" align="center" cellpadding="0" cellspacing="0" class="tbl">
<tr>
	<td align="left">
		<table border="0" cellpadding="0" cellspacing="0" class="tbl" width="50%" align="center">
		<tr>
			<td>&nbsp;</td>
		</tr>
        <tr>
			<td align="center" style="font-size:18px; font-weight:bold; font-family:'Comic Sans MS', cursive">.: Setting Hak Akses Menu :.</td>
		</tr>
        <tr>
			<td>&nbsp;</td>
		</tr>
        <tr>
			<td>Nama Modul :&nbsp;
            <select id="cmbModul" onchange="loadTab()">         	
                <?php
				$sql="select * from ms_modul order by id";
				$kueri=mysql_query($sql);
				while($modul=mysql_fetch_array($kueri)){
				?>
                <option value="<?php echo $modul['id']; ?>"><?php echo $modul['nama']; ?></option>
                <?php
				}
				?>            
            </select>
            </td>
		</tr>
        <tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td align="left">
			<table width="100%" align="left" cellspacing="0" cellpadding="0">
			<tr>
				<td align="left"><div id="a_tabbar" style="width:1000px; height:500px; display:block;"></div></td>
			</tr>
			</table>
			
			</td>
		</tr>
		</table>
		</td>
	</tr>
    <tr>
				<td height="28" background="../images/main-bg.png" style="background-repeat:repeat-x;">&nbsp;</td>
			</tr>
</table>
<div id="popGrPet" style="display:none; width:429px" class="popup">
<table width="409" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
<tr>
	<td width="159" class="font">Nama Pegawai</td>
	<td width="248"><input type="text" id="namaPeg" class="txtinput2" name="namaPeg" size="35" /></td>
</tr>
<tr>
	<td class="font">User Name</td>
	<td><input type="text" id="user" name="user" size="35" class="txtinput2" /></td>
</tr>
<tr>
	<td class="font">Password</td>
	<td><input type="password" id="pass" name="pass" size="35" class="txtinput2" /></td>
</tr>
<tr>
	<td class="font">Password Konfirmasi</td>
	<td><input type="password" id="passKon" name="passKon" size="35" class="txtinput2" /></td>
</tr>
<tr>
	<td>&nbsp;</td>
	<td height="50" valign="bottom"><button id="sim" name="sim" value="simpan" type="button" style="cursor:pointer" onclick="cekPass()"><img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Simpan</button>  <button type="button" id="batal" name="batal" class="popup_closebox" onclick="gaksido()" style="cursor:pointer"><img src="../icon/back.png" width="20" align="absmiddle" />&nbsp;&nbsp;Batal</button></td>
</tr>
</table>
</div>
		

			    </center>   
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
<div id="tempor" style="display:none"></div>
</body>
</html>
<script language="javascript">
function loadTab(){
	var tab = tabbar.getActiveTab();
	if(tab=='a0'){
		tabbar.forceLoad(tab,"settingaplikasi.php?modul="+document.getElementById('cmbModul').value);
	}
	else if(tab=='a1'){
		tabbar.forceLoad(tab,"group.php?modul="+document.getElementById('cmbModul').value);
	}
	else if(tab=='a2'){
		tabbar.forceLoad(tab,"group_akses.php?modul="+document.getElementById('cmbModul').value);
	}
	else if(tab=='a3'){
		tabbar.forceLoad(tab,"group_petugas.php?modul="+document.getElementById('cmbModul').value);
	}
}

tabbar = new dhtmlXTabBar("a_tabbar", "top");
tabbar.setSkin('dhx_skyblue');
tabbar.setImagePath("../theme/codebase/imgs/");
tabbar.enableAutoSize(false, true);
tabbar.addTab("a0", "Setting Menu", "120px");
tabbar.addTab("a1", "Group", "120px");
tabbar.addTab("a2", "Group Akses", "120px");
tabbar.addTab("a3", "Group Petugas", "120px");
tabbar.setTabActive("a0");
tabbar.setHrefMode("ajax-html");
tabbar.setContentHref("a0", "settingaplikasi.php?modul="+document.getElementById('cmbModul').value);
tabbar.setContentHref("a1", "group.php?modul="+document.getElementById('cmbModul').value);
tabbar.setContentHref("a2", "group_akses.php?modul="+document.getElementById('cmbModul').value);
tabbar.setContentHref("a3", "group_petugas.php?modul="+document.getElementById('cmbModul').value);
tabbar.attachEvent("onSelect", function(id){
switch(id){
case 'a0':
	tabbar.setContentHref("a0", "settingaplikasi.php?modul="+document.getElementById('cmbModul').value);
	break;
case 'a1':
	tabbar.setContentHref("a1", "group.php?modul="+document.getElementById('cmbModul').value);
	break;
case 'a2':
	tabbar.setContentHref("a2", "group_akses.php?modul="+document.getElementById('cmbModul').value);
	break;
case 'a3':
	tabbar.setContentHref("a3", "group_petugas.php?modul="+document.getElementById('cmbModul').value);
	break;
}
return true;
}); 

var username_baru = false;
var tempUser = '';
function popup1(i){
	var data=document.getElementById('idexts'+i).value.split('|');
	//var data=gdy.getSelRowId('idexts').split('|');
	document.getElementById('idPeg').value=data[0];
	document.getElementById('user').value=data[1];
	tempUser=data[1];
	if(data[1]==''){
		username_baru = true;
	}
	else{
		username_baru = false;
	}
	document.getElementById('namaPeg').value=data[2];
	document.getElementById("pass").value='';
	document.getElementById("passKon").value='';
	new Popup('popGrPet',null,{modal:true,position:'center',duration:1});
	document.getElementById('popGrPet').popup.show();
}
function cekPass(){
	//alert(document.getElementById('pass').value+"|"+document.getElementById('passKon').value);
	if(document.getElementById('pass').value != document.getElementById('passKon').value){
		alert('Password tidak sama');
		return false;
	}
	//act1();
	//function( vUrl , vTarget, vForm, vMethod,evl,noload,targetWindow) 
	Request("cekUserName.php?username="+document.getElementById('user').value,'tempor','','GET',hasile,'noLoad');
}

function hasile(){
	var dat = document.getElementById('tempor').innerHTML;
	//alert('hasil='+dat);
	if(tempUser==document.getElementById('user').value){
		username_baru=false;
	}
	else{
		username_baru=true;
	}
	if(dat=='1' && username_baru==true){
		alert("Username '"+document.getElementById('user').value+"' sudah ada...");
	}
	else{
		act1();
	}
}
function act1(){
	
	var user=document.getElementById("user").value;
	var pass=document.getElementById("pass").value;
	var idPeg=document.getElementById('idPeg').value;
	//alert("group_petugasUtils.php?action=add&grd=2&idGroup="+document.getElementById('group').value+"&idPeg="+idPeg+"&user="+user+"&pass="+pass);
	gdy.loadURL("group_petugasUtils.php?action=add&grd=2&idGroup="+document.getElementById('group').value+"&idPeg="+idPeg+"&user="+user+"&pass="+pass,'','GET');
	document.getElementById('popGrPet').popup.hide();
	//setTimeout("cmd()",1000);
}
function gaksido(){
	document.getElementById('namaPeg').value='';
	document.getElementById('idPeg').value='';
	document.getElementById("pass").value='';
	document.getElementById("passKon").value='';
	document.getElementById("user").value='';
	document.getElementById('sim').value='simpan';
	document.getElementById('sim').innerHTML='<img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Simpan';
}
</script>

