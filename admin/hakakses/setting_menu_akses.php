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
          
		  
		<?php 
			include '../inc/koneksi.php'; 
			session_start();
			if(isset($_POST['data'])){
			$data=$_POST['data'];
			$group=$_POST['group'];
			$modul=$_POST['modul'];
			$arrdata=explode("|",$data);
			
			//$sqldel=mysql_query("delete from ms_grup_akses where grp_id='$group'");
			
				for($i=0;$i<count($arrdata);$i++){
				$temp=explode("-",$arrdata[$i]);
				//print_r($temp);
					$sqldel=mysql_query("delete from ms_grup_akses where grp_id='$group' AND menu_id='".$temp[0]."'");
					
					if($temp[1]==1){
						$sql="insert into ms_grup_akses (grp_id,menu_id) values('$group','".$temp[0]."')";
						mysql_query($sql);
						echo mysql_error();    
					}
				
				}
			//echo "ok";
			//print_r($temp);
			}
		?>

            <form id="form1" method="post" name="form1" action="" onSubmit="save();">
			<input type="hidden" name="data" id="data"/>
				<table width="1000" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" align="center">
					<tr height="100">
						<td width="20%" style="text-align:right">User Group</td>
						<td width="5%" style="text-align:center">:</td>
						<td width="75%">
						<select name="group" id="group" class="txtinput" onChange="window.location='setting_menu_akses.php?id='+ document.getElementById('modul').value+'&idx='+document.getElementById('group').value;">
						<?php 
						$grp_id=$_GET['idx'];
						if($grp_id==''){$grp_id=1;}
						$query=mysql_query("select grp_id, grp_user from ms_grup ");
						while($row=mysql_fetch_array($query)){
						?>
						<option value="<?php echo $row['grp_id'] ?>"<?php if($grp_id==$row['grp_id']) echo 'selected' ?>><?php echo $row['grp_user'] ?></option>
						<?php } ?>
						</select>
						Modul :
						<select name="modul" id="modul" class="txtinput" onChange="window.location='setting_menu_akses.php?id='+ document.getElementById('modul').value+'&idx='+document.getElementById('group').value;">
						<?php 
						$modul_id=$_GET['id'];
						if($modul_id==''){$modul_id=1;}
						$query=mysql_query("select modul_id, modul from ms_modul");
						while($row=mysql_fetch_array($query)){
						?>
						<option value="<?php echo $row['modul_id'] ?>"<?php if($modul_id==$row['modul_id']) echo 'selected' ?>><?php echo $row['modul'] ?></option>
						<?php } ?>
						</select> 
						</td>
					</tr>
					<tr>
						<td colspan="3">&nbsp;</td>
					</tr>
					<tr>
					<td colspan="3" align="center">
							<table width="700" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFBF0">
								<tr>
									<td align="center" colspan="4" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px">.: Daftar Menu :.</td>
								</tr>
								<tr>
									<td colspan="4">&nbsp;</td>
								</tr>
								<tr class="header">
									<td width="54" align="center" class="tblheaderkiri">No</td>
								  	<td width="70" align="center" class="tblheader">
									<input type="checkbox" name="chkall" id="chkall" onClick="checkAll(this)" style="cursor:pointer" title="Pilih Semua" />
									</td>
									<td width="139" align="center" class="tblheader">Kode Menu</td>
									<td width="435" align="center" class="tblheader">Master Menu</td>
									</tr> 
										<?php $no=0; 
												//$id=$_REQUEST['id'];
												/*$sql="SELECT m.*,IF(T1.menu_id=m.id,1,0) NL FROM ms_menu m LEFT JOIN 
												(SELECT user_id,a.menu_id FROM ms_user u 
												INNER JOIN ms_user_akses a ON u.id=a.user_id WHERE u.id='$user') T1
												ON m.id=T1.menu_id WHERE modul_id='$user2' GROUP BY m.kode ORDER BY kode";*/
												$sql="SELECT m.id,m.kode,m.nama,m.level,m.modul_id,IF(n.menu_id=m.id,1,0) NL FROM ms_menu m
													LEFT JOIN (SELECT ga.menu_id,ga.grp_id FROM ms_grup_akses ga WHERE ga.grp_id='$grp_id') n ON n.menu_id=m.id
													WHERE m.modul_id='$modul_id' AND m.aktif='1' GROUP BY m.kode";
												//echo $sql;
												$rs=mysql_query($sql);
												$i=0;
												while($rw=mysql_fetch_array($rs)){
												$id=$rw['id'];
												$checked="";
												if($rw['NL']==1)$checked="checked='checked'";
										?>
								<tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'">
									<td class="tdisikiri" align="center"><?php echo ++$i; ?></td>
							
									<td class="tdisi" align="center"> <input type="checkbox" id="chk" name="chk" <?php echo $checked;?> value="<?php echo $id ?>" /></td>
									<td align="center" class="tdisi" ><?php echo $rw['kode'] ?>&nbsp;</td>
									<td class="tdisi" align="left" style="vertical-align:middle"><?php echo $rw['nama'];?>&nbsp;</td>
								</tr>
												<? } ?>
								<tr>
									<td align="center" colspan="4"><button name="save" type="button" onClick="kirim();" style="cursor: pointer">
										<img alt="save" src="/simrs-pelindo/sdm/icon/Floppy-Small.png" border="0"  width="20" height="20" align="absmiddle" />
										&nbsp;&nbsp;Simpan&nbsp;&nbsp;</button>			
							 
									</td>
								</tr>
							</table>	
						</td>
					</tr>
				</table>
			</form>

			    </center>   
            </div>
            
            <div id="footer">
               	<?php include("../inc/footer.php"); ?>
            </div>
            
        </div>
</body>
</html>

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
    
} 

  function checkAll(par){
	var semany = document.forms[0].chk.length;
	if(semany == undefined){
		document.forms[0].chk.checked = par.checked;
	}else{
		for(var i=0; i<semany; i++){
			document.forms[0].chk[i].checked = par.checked;
		}
	}
}
</script>
