<?
include '../sesi.php';
?>
<?php 
	include '../koneksi/konek.php'; 
	if(isset($_POST['data'])){
	$data=$_POST['data'];
	$user=$_POST['user'];
	$arrdata=explode("|",$data);
	$sqldel=mysql_query("delete from as_akses where user_id='$user'");
	for($i=0;$i<count($arrdata);$i++){
		$temp=explode("-",$arrdata[$i]);
		
		if($temp[1]==1){
			$sqlIns="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Setting Hak Akses','insert into as_akses (user_id,menu_id) values($user,$arrdata[$i])','".$_SERVER['REMOTE_ADDR']."')";
					mysql_query($sqlIns);
			$sql="insert into as_akses (user_id,menu_id) values('$user','$arrdata[$i]')";    
		}else{
			$sqlIns2="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Setting Hak Akses','insert into as_akses (user_id,menu_id) values($user,NULL)','".$_SERVER['REMOTE_ADDR']."')";
					mysql_query($sqlIns2);
			$sql="insert into as_akses (user_id,menu_id) values('$user',NULL)";
		}
		
		mysql_query($sql);
		echo mysql_error();
	}
	//echo "ok";
	}
?>
<!--html xmlns="http://www.w3.org/1999/xhtml"-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
	<script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
	<script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
	<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
	<link type="text/css" rel="stylesheet" href="../default.css"/>
	<title>Setting Akses Menu</title>
</head>

<body onLoad="cek_user()">
    <div align="center">
        <?php
        include '../header.php';
        ?>
        <div align="center">
            <form id="form1" method="post" name="form1" action="" onSubmit="save();">
<input type="hidden" name="data" id="data"/>
<table width="1000" cellpadding="0" cellspacing="0" bgcolor="#FFFBF0" align="center">
<tr height="100">
			<td width="20%" style="text-align:right">User Name</td>
			<td width="5%" style="text-align:center">:</td>
			<td width="75%">
			<select name="user" id="user" class="txtinput" onChange="window.location='setting_menu_akses.php?id='+this.value;">
			<?php 
            $usr=$_GET['id'];
			$rs=mysql_query("select username,userid,id from as_ms_user where status = 1 order by username");
			$flag=0;
			while($rows=mysql_fetch_array($rs)){
				if($flag=0 and $usr=='')
				$usr=$row['id'];
			?>
			<option value="<?php echo $rows['id'] ?>"<?php if($usr==$rows['id']) echo 'selected' ?>><?php echo $rows['username'] ?></option>
			<?php } ?>
			</select></td>
		</tr>
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
	<td colspan="3" align="center">
		<table width="700" align="center" cellpadding="0" cellspacing="0" >
			<tr>
				<td align="center" colspan="4" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px">.: Daftar Menu :.</td>
			</tr>
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
			<tr class="headtable" height="30">
				<td width="54" align="center" class="tblheaderkiri">No</td>
			  <td width="70" align="center" class="tblheader"><input type="checkbox" name="chkall" id="chkall" onClick="checkAll(this)" 
style="cursor:pointer" title="Pilih Semua" /></td>
				<td width="139" align="center" class="tblheader">Kode Menu</td>
				<td width="435" align="center" class="tblheader">Menu Pengguna</td>
			</tr> 
			<?php $no=0; 
				//$id=$_REQUEST['id'];
				$sql="SELECT m.*,IF(T1.menu_id=m.id,1,0) NL FROM as_menu m LEFT JOIN 
				(SELECT user_id,a.menu_id FROM as_ms_user u 
				INNER JOIN as_akses a ON u.id=a.user_id WHERE u.id='$usr') T1
				ON m.id=T1.menu_id GROUP BY m.mn_kode ORDER BY mn_kode; ";
				$rs=mysql_query($sql);
                $i=0;
				while($rw=mysql_fetch_array($rs)){
				$id=$rw['id'];
                $checked="";
                if($rw['NL']==1)$checked="checked='checked'";
				?>
			<tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'" height="20">
				<td class="tdisikiri" align="center"><?php echo ++$i; ?></td>
				
				<td class="tdisi" align="center"> <input type="checkbox" id="chk" name="chk" <?php echo $checked;?> value="<?php echo $id ?>" /></td>
				<td align="center" class="tdisi" ><?php echo $rw['mn_kode'] ?>&nbsp;</td>
				<td class="tdisi" align="left" style="vertical-align:middle"><?php echo $rw['mn_menu'];?>&nbsp;</td>
			</tr>
			<? } ?>
			<tr>
				<td align="center" colspan="4"><button name="save" type="button" onClick="kirim();" style="cursor: pointer">
                 <img alt="save" src="../icon/save.gif" border="0"  width="16" height="16" align="absmiddle" />&nbsp;&nbsp;Simpan&nbsp;&nbsp;</button>			
				 
				 <!--button type="reset" onClick="location='pengeluaranBon.php'" style="cursor: pointer">
                                <img alt="cancel" src="../icon/cancel.gif" border="0" width="16" height="16" align="absmiddle" />
                                &nbsp;
                                &nbsp;Batal&nbsp;&nbsp;&nbsp
			    </button--> </td>
				 </tr>
		</table>	
	</td>
</tr>
 <tr>
                    <td colspan="10">
                        <?php
                        include '../footer.php';
                        ?>                    </td>
                </tr>
</table>
</form>
        </div>
    </div>
</body>
<script language="javascript">
 function kirim(){
    var data_submit = new Array();
    var chk=document.getElementsByName('chk');
    //alert(chk.length);
    for(var i=0;i<chk.length;i++){
        if(chk[i].checked){
            //data_submit+=chk[i].value;
            data_submit.push(chk[i].value+"-1");
            //if(i<chk.length)data_submit+="|";    
        }else{
            data_submit.push(chk[i].value+"-0");
        }
        
    }
    if(data_submit.length>0){
        document.getElementById('data').value=data_submit.join("|");
        document.getElementById('form1').submit();
    }else{
        alert("");//peringatan datakosong    
    }
    
 /*
if(document.forms[0].chk.lenght){
	var max =document.length;
	 for(var i=0; i<max; i++){ // looping sebanyak max
        document.forms[0].chk[i].checked == true
		document.getElementById('form1').submit();
		}
	}else{
		document.forms[0].chk[i].checked==false
	}*/
} 

function checkAll(par)
{
	var semany = document.forms[0].chk.length;
	if(semany == undefined)
	{
		document.forms[0].chk.checked = par.checked;
	}
	else
	{
		for(var i=0; i<semany; i++)
		{
			document.forms[0].chk[i].checked = par.checked;
		}
	}
}

function cek_user()
{
	<?
	if(isset($_REQUEST['id']))
	{
	}
	else
	{
	?>
	var id_user = document.getElementById('user').value;
	window.location = "setting_menu_akses.php?id="+id_user;
	<?
	}
	?>
}
</script>
<!--/html-->
