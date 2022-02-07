<div style=" margin-top:50px; margin-left:50px;">
<?php
	include("koneksi/konek.php");
	if(!isset($_SESSION['userId'])){
		header('location:../index.php');
 ?>

<!--table width="274" height="155" border="0" cellpadding="2" cellspacing="0" style="font:bold 12px tahoma; background:url(images/login.png) no-repeat;  color:#FFFFFF;">
<form id="formLogin" action="login_proc.php" method="post" onSubmit="return cekLogin();">
  <tr>
    <td height="32" colspan="3" style="font:bold 14px tahoma; color:#FFFFFF;text-align:center;">LOGIN FORM </td>
    </tr>
  <tr>
    <td width="22">&nbsp;</td>
	<td width="73" height="27">Username</td>
	<td width="299">: 
	  <input class="txtinputan" type="text" tabindex="1" size="20" id="txtUser_billing" name="txtUser_billing" value="" onFocus="if(this.value == 'User ID') this.value='';" onBlur="if(this.value=='') this.value = 'User ID'" style="padding:3px;" /></td>
    </tr>
  <tr>
    <td width="22">&nbsp;</td>
	<td width="73" height="26">Password</td>
	<td>: 
	  <input class="txtinputan" tabindex="2" type="password" size="20" id="txtPass_billing" name="txtPass_billing" value=""  style="padding:3px;"/></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
	<td height="37">&nbsp;</td>
	<td>&nbsp; <input class="btninputan" tabindex="3" type="submit" value="Login" style="border:1px solid #FF6600; background:#FF9900; color:#FFFFFF; padding:3px 4px; font:bold 12px tahoma; cursor:pointer;" /></td>
    </tr>
</form>
</table-->


<?php
}
else
{
?>
<div style="width:264px; height:120px; background:url(images/login.png) no-repeat; padding:20px; color:#FFFFFF; font: 14px tahoma;">
<span>Selamat datang <b><?php echo $_SESSION['userName'];?></b> <!--button onClick="location='logout_proc.php'">Logout</button-->
<br />
<br />
	<style type="text/css">
		.links{
			color:#fff;
			text-decoration:none;
		}
		.links:hover{
			color:yellow;
		}
	</style>
<?php
	if($_SESSION['userId']=='732'){
		$date_now = gmdate('Y-m-d');
		$sql = "SELECT user_act
				FROM b_login_user_log
				WHERE DATE(tgl_act) = '{$date_now}' /* CURDATE() */ 
					AND user_act <> 732
				GROUP BY user_act";
		$query = mysql_query($sql);
		$login = $logout = array();
		while($data = mysql_fetch_array($query)){
			$sql2 = "SELECT `type`, user_act
					FROM b_login_user_log
					WHERE user_act = '".$data['user_act']."'
					ORDER BY tgl_act DESC
					LIMIT 1";
			$query2 = mysql_query($sql2);
			$subdata = mysql_fetch_array($query2);
			if($subdata['type'] == 1){
				$login[] = $subdata['user_act'];
			} else {
				$logout[] = $subdata['user_act'];
			}
		}
	
		//echo "User Online hari ini : <b>".count($login)." Pegawai</b><br />";
		//echo "User Log Out hari ini : <b>".count($logout)." Pegawai</b><br />";
		//echo "<p style='text-align:right; margin-right:40px; font-weight:bold;' ><a class='links' target='_blank' href='list_user.php'>Detail >></a></p>";
	}
?>
</span>
</div>
<?
if($_SESSION['group'] != 49 && $_SESSION['spesialis'] != 0)
{
?>
<div style="width:350px; background-color:#4376A9; height:150px; border:1px solid #999; color:#FFFFFF; overflow-y:scroll; display:none">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td align="center" colspan="4" style="border:1px solid #FF9;"><font size="-3" color="#FFFFFF">DAFTAR PASIEN BELUM TERLAYANI</font></td>
</tr>
<?
$i = 1;
for($jj=0;$jj<count($_SESSION['unit_tmp']);$jj++)
{
	$query1 = "SELECT b.id, b.nama, b.no_rm, a.id AS pelayanan_id, a.kunjungan_id FROM b_pelayanan a INNER JOIN b_ms_pasien b ON a.pasien_id = b.id INNER JOIN b_ms_unit ab ON a.unit_id = ab.id AND ab.inap = 0
WHERE a.unit_id = ".$_SESSION['unit_tmp'][$jj]." AND a.dilayani = 0 AND a.tgl = CURDATE()";
	$rquery1 = mysql_query($query1);
	while($dquery1 = mysql_fetch_array($rquery1))
	{
?>
<tr>
<td width="5%" align="center"><font size="-3" color="#FFFFFF">&nbsp;<? echo $i;?></font></td>
<td width="35%" align="left"><font size="-3" color="#FFFFFF">&nbsp;<? echo $dquery1['nama'];?></font></td>
<td width="30%" align="center"><span style="vertical-align:top"><a href="javascript:void(0)" onClick="tampil1('<? echo $dquery1['id'];?>','<? echo $dquery1['pelayanan_id'];?>','<? echo $dquery1['kunjungan_id'];?>')"><font size="-3" color="#FFFFFF">REKAM MEDIS</font></a></span></td>
<td width="30%" align="center"><span style="vertical-align:top"><a href="javascript:void(0)" onClick="tampil2('<? echo $dquery1['id'];?>','<? echo $dquery1['pelayanan_id'];?>','<? echo $dquery1['kunjungan_id'];?>')"><font size="-3" color="#FFFFFF">RESUME MEDIS</font></a></span></td>
</tr>
<?
	$i++;
	}
}
?>
<?
for($jj=0;$jj<count($_SESSION['unit_tmp']);$jj++)
{
	 $query1 = "SELECT b.id, b.nama, b.no_rm, a.id AS pelayanan_id, a.kunjungan_id FROM b_pelayanan a INNER JOIN b_ms_pasien b ON a.pasien_id = b.id INNER JOIN b_ms_unit ab ON a.unit_id = ab.id AND ab.inap = 1 INNER JOIN b_kunjungan k ON k.id = a.kunjungan_id INNER JOIN b_tindakan_kamar tk ON tk.pelayanan_id = a.id WHERE a.unit_id = ".$_SESSION['unit_tmp'][$jj]." AND a.dilayani = 0 AND k.pulang = 0 AND a.batal = 0 AND tk.tgl_out IS NULL";
	$rquery1 = mysql_query($query1);
	while($dquery1 = mysql_fetch_array($rquery1))
	{
?>
<tr>
<td width="5%" align="center"><font size="-3" color="#FFFFFF">&nbsp;<? echo $i;?></font></td>
<td width="35%" align="left"><font size="-3" color="#FFFFFF">&nbsp;<? echo $dquery1['nama'];?></font></td>
<td width="30%" align="center"><span style="vertical-align:top"><a href="javascript:void(0)" onClick="tampil1('<? echo $dquery1['id'];?>','<? echo $dquery1['pelayanan_id'];?>','<? echo $dquery1['kunjungan_id'];?>')"><font size="-3" color="#FFFFFF">REKAM MEDIS</font></a></span></td>
<td width="30%" align="center"><span style="vertical-align:top"><a href="javascript:void(0)" onClick="tampil2('<? echo $dquery1['id'];?>','<? echo $dquery1['pelayanan_id'];?>','<? echo $dquery1['kunjungan_id'];?>')"><font size="-3" color="#FFFFFF">RESUME MEDIS</font></a></span></td>
</tr>
<?
	$i++;
	}
}
?>
</table>
</div>
<div style="display:none"><font size="-3">Jumlah Pasien Belum Dilayani : <font size="-3" color="#FF0000"><b><? echo $i-1;?></b></font> </</font></div>
<div style="width:264px; height:10px; padding:20px; color:#FFFFFF; font: 14px tahoma;">
&nbsp;
</div>
<?php
}
}
?>
</div>
