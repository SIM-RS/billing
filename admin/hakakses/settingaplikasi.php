
<form name="form1" method="post" action="" target="_SELF">
<input id="act" name="act" value="tambah" type="hidden"/>
<div id="Table_01">

<table width="925" border="0" cellspacing="1" cellpadding="2" align="center">  
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
    	<td colspan="5" style="text-transform:uppercase; font-weight:bold; font-size:18px" align="center"><?php echo $modl['nama']; ?></td>
    </tr>
    <tr>
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td width="5%">&nbsp;</td>
		<td width="10%" align="right" class="font">Menu Induk &nbsp;</td>
		<td width="45%">
			<input id="txtParentKode"  name="txtParentKode" type="text" size="5" maxlength="20" style="text-align:center" value="" readonly="true" class="txtinput3">
            <input id="txtParentNama"  name="txtParentNama" type="text" size="25" maxlength="50" style="text-align:left" value="" readonly="true" class="txtinput3">
            <img id="img3" alt="tree" title='daftar menu' width="" style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absmiddle" onClick="forOpenTree();" />             
			<input type="hidden" id="txtLevel" title="level" name="txtLevel" size="5" />
			<input type="hidden" id="txtParentId" title="parent id" name="txtParentId" size="5" />
			<input type="hidden" id="txtParentLvl" name="txtParentLvl" size="6" />
            <input type="hidden" id="txtModul" name="txtModul" size="6" value="<?php echo $_REQUEST['modul']; ?>" />
		</td>
		<td width="20%">&nbsp;</td>
		<td width="5%">&nbsp;</td>
	</tr>  
	<tr>
		<td height="30">&nbsp;</td>
		<td align="right" class="font">Kode &nbsp;</td>
		<td class="font">
			<input id="txtId" name="txtId" type="hidden" />
			<input type="text" id="txtKode" name="txtKode" size="10"  class="txtinput3"/>
			&nbsp;&nbsp;Nama&nbsp;<input type="text" id="txtNama" name="txtNama" size="22" class="txtinput3"/>
		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
		<tr>
		<td>&nbsp;</td>
		<td align="right" class="font">Url &nbsp;</td>
		<td>
			<input type="text" id="txtUrl" name="txtUrl" size="45" class="txtinput3"/>
		</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>  
	<tr>
		<td height="37">&nbsp;</td>
		<td>&nbsp;</td>
		<td>
			<!--<input type="submit" id="btnSimpanSetting" name="btnSimpanSetting" value="Tambah"/>
			<input type="button" id="btnHapusSetting" name="btnHapusSetting" value="Hapus" onclick="delet();" disabled="disabled"/>
			<input type="button" id="btnBatalSetting" name="btnBatalSetting" value="Batal" onclick="batalSetting()"/>-->
            
            <button type="button" id="btnSimpanSetting" name="btnSimpanSetting" value="Tambah" onclick="rikues()" style="cursor:pointer"><img src="../icon/add.gif" align="absmiddle" width="20" />&nbsp;Tambah</button>&nbsp;&nbsp;
			<button type="button" id="btnBatalSetting" name="btnBatalSetting" value="Batal" onclick="batalSetting()" style="cursor:pointer"><img src="../icon/back.png" align="absmiddle" width="20" />&nbsp;Batal</button>&nbsp;&nbsp;
			<button type="button" id="btnHapusSetting" name="btnHapusSetting" value="Hapus" onclick="delet()" disabled="disabled" style="cursor:pointer"><img src="../icon/delete2.gif" align="absmiddle" width="20" />&nbsp;Hapus</button>
			<span id="spanProc"></span>
		</td>
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
		<td align="left" colspan="3">
        <span id="output">&nbsp;</span>	
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="left" colspan="3">
        <div id="div3" class="divtree">	
			<?php
			//include('settingaplikasi_tree.php');
			?>
         </div>
		</td>
	</tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
</table>
</div>
</form>
<script>
function rikues(){
	var txtId = document.getElementById('txtId').value;
	var txtKode = document.getElementById('txtKode').value;
	var txtNama = document.getElementById('txtNama').value;
	var txtUrl = document.getElementById('txtUrl').value;
	var txtLevel = document.getElementById('txtLevel').value;
	var txtParentId = document.getElementById('txtParentId').value;
	var txtParentKode = document.getElementById('txtParentKode').value;
	var txtModul = document.getElementById('txtModul').value;
	var op = document.getElementById('act').value;
	
	Request("settingaplikasi_utils.php?txtId="+txtId+"&txtKode="+txtKode+"&txtNama="+txtNama+"&txtUrl="+encodeURIComponent(txtUrl)+"&txtLevel="+txtLevel+"&txtParentId="+txtParentId+"&txtParentKode="+txtParentKode+"&txtModul="+txtModul+"&op="+op,'output','','GET',habisRequest,'noLoad');
	
}

function habisRequest(){
	batalSetting();
	Request("settingaplikasi_tree.php?modul=<?php echo $_REQUEST['modul']; ?>",'div3','','GET',klir,'noLoad');
}

function klir(){
	setTimeout('hilang()',2000);
}
function hilang(){
	document.getElementById('output').innerHTML = '&nbsp;';
}

function forOpenTree(){	
	var qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel*txtKode*txtParentNama&modul=<?php echo $_REQUEST['modul']; ?>";
	OpenWnd('settingaplikasi_treeview.php?'+qstr_ma_sak,800,500,'msma',true);
}

function delet(){
	//alert('masuk');
	//document.getElementById('act').value = 'hapus';
	//document.forms[0].submit();
	var txtId = document.getElementById('txtId').value;
	var txtNama = document.getElementById('txtNama').value;
	var txtModul = document.getElementById('txtModul').value;
	if(confirm('Yakin ingin menghapus menu '+txtNama+' ???')){
		Request("settingaplikasi_utils.php?modul=<?php echo $_REQUEST['modul']; ?>&txtId="+txtId+"&txtModul="+txtModul+"&op=hapus",'output','','GET',habisRequest,'noLoad');
	}
}

function loadtree(p,act,par)
{		
	//alert('asdsadsa');
	var a=p.split("*-*");
	//alert(a[0]+'act='+act+'&par='+par+'&gid='+document.getElementById(a[2]).value);
	Request ( a[0]+'act='+act+'&par='+par+a[3] , a[1], '', 'GET');
	//isiCombo('cmbGroup','','','cmbGroup');
}

function aksi(){
	//alert(document.getElementById('txtId').value);
	//document.getElementById('btnSimpanSetting').value='Update';
	document.getElementById('act').value='update';
	document.getElementById('btnHapusSetting').disabled=false;
	document.getElementById('btnSimpanSetting').innerHTML='<img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Update';
    document.getElementById('btnHapusSetting').innerHTML='<img src="../icon/delete.gif" align="absmiddle" width="20"  />&nbsp;&nbsp;Hapus';
	document.getElementById('img3').style.display = 'none';
	document.getElementById('txtKode').readOnly=true;
}

function batalSetting(){
	document.getElementById('txtParentId').value='';
	document.getElementById('txtParentKode').value='';
	document.getElementById('txtParentNama').value='';
	document.getElementById('txtKode').value='';
	document.getElementById('txtNama').value='';
	document.getElementById('txtUrl').value='';
	document.getElementById('btnSimpanSetting').value='Tambah';
	document.getElementById('act').value='tambah';
	document.getElementById('btnHapusSetting').disabled=true;
	document.getElementById('btnSimpanSetting').innerHTML='<img src="../icon/add.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Tambah';
    document.getElementById('btnHapusSetting').innerHTML='<img src="../icon/delete2.gif" align="absmiddle" width="20"  />&nbsp;&nbsp;Hapus';
	document.getElementById('img3').style.display = 'table-row';
	document.getElementById('txtKode').readOnly = '';
}

Request("settingaplikasi_tree.php?modul=<?php echo $_REQUEST['modul']; ?>",'div3','','GET','','noLoad');
</script>