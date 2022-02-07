<?php
session_start();
include '../inc/koneksi.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='../../index.php';
                        </script>";
}

$modul=$_POST["modul"];
$parent_id=$_POST["parent_id"];
$kode=$_POST["kode"];
$level=$_POST["level"]+1;
$namax=$_POST["namax"];
$urlx=nl2br($_POST["urlx"]);
$status=$_POST["status"];
/*
$sql="INSERT INTO ms_menu (kode,nama,url,level,parent_id,islast,modul_id,aktif) 
	  VALUES 			  ('$kode','$namax','$urlx','$level','$parent_id','0','$modul','$status')";
if(!empty($level)&&!empty($parent_id)){	  
 	mysql_query($sql);
 	//echo $sql;
 }
*/
?>
<form id="form1" name="form1" method="post" action="settingaplikasi_utils.php" target="_SELF">
  <table width="920" border="0">
  <tr>
    <td width="21" scope="col">&nbsp;</td>
    <td width="130" scope="col">&nbsp;</td>
    <td width="15" scope="col">&nbsp;</td>
    <td width="709" scope="col">&nbsp;</td>
    <td width="23" scope="col">&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td>Parent Kode</td>
	<td>:</td>
	<td><label>
	  <input type="text" id="kode_parent" name="kode_parent" readonly="readonly" value="">
	  <input type="text" id="parent_id" name="parent_id" readonly="readonly" value=""/>
	  <input type="text" id="level" name="level" readonly="readonly" value=""/>
	  <img alt="tree" title='Struktur tree kode barang' style="cursor:pointer" border=0 src="/simrs-pelindo/sdm/images/view_tree.gif" align="absbottom" onClick="OpenWnd('tree.php?<?php echo 'par=kode_parent*parent_id*level*kode&modul_id='; ?>'+document.getElementById('cmbModul').value,800,500,'msma',true)">  
	</label></td>
	<td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td>Kode</td>
	<td>:</td>
	<td><input type="text" id="kode" name="kode" value="" maxlength="50" /></td>
	<td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td>Nama Menu </td>
	<td>:</td>
	<td><label>
	  <input name="namax" type="text" id="namax" size="30" />
	</label></td>
	<td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td>Url</td>
	<td>:</td>
	<td><input type="text" name="urlx" id="urlx" size="35" /></td>
	<td>&nbsp;</td>
  </tr>
  
  <tr>
	<td>&nbsp;</td>
	<td>Status</td>
	<td>:</td>
	<td><select name="status" id="status">
	  <option value="1">Aktif</option>
	  <option value="0">Tidak Aktif</option>
	</select>                </td>
	<td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td><label>
	  <input name="simpan" type="submit" id="simpan" value="Simpan" />
	</label></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td colspan="3">
	 <div style="border-color:#96CADE; height:350px">	
		<?php
		include('settingaplikasi_tree.php');
		?>
	 </div>	</td>
	<td>&nbsp;</td>
  </tr>
</table>

</form>

