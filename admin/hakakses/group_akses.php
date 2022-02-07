<div id="Table_01">
<table align="center" cellpadding="0" cellspacing="0" width="1000">
<tr>
    <td align="center">
    <table width="900">
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
        <td align="left">
        <fieldset  style="border-color:#D9E0E0; border:0px;">
        <table>
        <tr>
            <td class="font">Group Akses</td>
            <td>
                <select id="cmbGroup" name="cmbGroup" class="txtinput2" onchange="setGroup('<?php echo $_SERVER['HTTP_HOST'];?>',this.value)"></select>
                <span id="isSave"></span>
            </td>
        </tr>
        </table>
        </fieldset>
        </td>
    </tr>
    <tr>
        <td height="500" valign="top">
            <div id="divtree3" class="divtree2">
            <?php include('group_aksesTree.php');?>
            </div>
        </td>
    </tr>
    </table>
    </td>
</tr>
</table>
</div>
<script language="javascript">
function isiCombo(id,val,defaultId,targetId){	
	if(targetId=='' || targetId==undefined){
		targetId=id;
	}

	Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET');			
}
function setGroup(addrs,val){
	Request ( 'http://'+addrs+'/simrs-pelindo/admin/hakakses/group_aksesTree.php?gid='+val+'&modul='+document.getElementById('cmbModul').value , 'divtree3', '', 'GET');
	//alert('http://'+addrs+'/simrs/askep/master/group_aksesTree.php?gid='+val , 'divtree3')
}
//isiCombo('cmbGroup',document.getElementById('cmbModul').value,'','cmbGroup');
Request('../combo_utils.php?id=cmbGroup&value='+document.getElementById('cmbModul').value,'cmbGroup','','GET',lodtri);

function lodtri(){
	Request ( 'http://<?php echo $_SERVER['HTTP_HOST']; ?>/simrs-pelindo/admin/hakakses/group_aksesTree.php?gid='+document.getElementById('cmbGroup').value+'&modul='+document.getElementById('cmbModul').value , 'divtree3', '', 'GET');
}

var actTree;
function loadtree(p,act,par)
{		
var a=p.split("*-*");
	if(act=='Tambah' || act=='Simpan' || act=='Hapus'){
		actTree=act;
		Request ( a[0]+'act='+act+'&par='+par+'&gid='+document.getElementById(a[2]).value+a[3]+'&cnt='+a[4] , a[1], '', 'GET',berhasil,'no');
	}
	else{			
		Request ( a[0]+'act='+act+'&par='+par+'&gid='+document.getElementById(a[2]).value+a[3]+'&cnt='+a[4] , a[1], '', 'GET');
	}
}
function simpanAkses(gid,id){
	//alert('group_aksesUtil.php?gid='+gid+"&id="+id);
	Request('group_aksesUtil.php?gid='+gid+"&id="+id,'isSave','','GET',kler,'noLoad');
	
}
function kler(){
	setTimeout('ilang()',1000);
}
function ilang(){
	document.getElementById('isSave').innerHTML = '';
}
</script>