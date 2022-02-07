
<script type="text/javascript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

//-->
</script>
<body onLoad="MM_preloadImages('images/menu-login3_14.gif')"

<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<body onLoad="MM_preloadImages('images/menu-login3_14.gif')"><table id="Table_01" width="407" height="375" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td rowspan="5">
			<img src="images/menu-login3_01.gif" width="93" height="374" alt=""></td>
		<td colspan="8">
			<img src="images/menu-login3_02.gif" width="314" height="136" alt=""></td>
	</tr>
	<tr>
		<td rowspan="3">
			<img src="images/menu-login3_03.gif" width="11" height="135" alt=""></td>
		<td>
			<img src="images/menu-login3_04.gif" width="56" height="70" alt=""></td>
		<td colspan="2">
			<img src="images/menu-login3_05.gif" width="143" height="70" alt=""></td>
		<td colspan="2">
			<img src="images/menu-login3_06.gif" width="63" height="70" alt=""></td>
		<td>
			<img src="images/menu-login3_07.gif" width="19" height="70" alt=""></td>
		<td rowspan="3">
			<img src="images/menu-login3_08.gif" width="22" height="135" alt=""></td>
	</tr>
	<tr>
		<td colspan="2" width="188" height="55">
        		
			<?php
                    if(!isset($_SESSION['userId'])){
                 ?>
			<!--form id="formLogin" action="login_proc.php" method="post" onSubmit="return cekLogin();">
				<table width="188" border="0" cellpadding="0" cellspacing="0">
				  <tr>
					<td width="72"><img src="images/menu-login_10.gif" width="72" height="28"></td>
					<td width="10" rowspan="2"><img src="images/menu-login_11.gif" width="6" height="52" alt=""></td>
					<td width="106"><input class="txtinputan" type="text" size="10" id="txtUser_billing" name="txtUser_billing" value="" onFocus="if(this.value == 'User ID') this.value='';" onBlur="if(this.value=='') this.value = 'User ID'" /></td>
				  </tr>
				  <tr>
					<td><img src="images/menu-login_16.gif" width="72" height="24"></td>
					<td><input class="txtinputan" type="password" size="10" id="txtPass_billing" name="txtPass_billing" value="" /></td>
				  </tr>
				</table>
			</form-->
			  
			 <?php
						header('location:../index.php');
                    }
                    else{
                       ?>
			   <span>Selamat datang <?php echo $_SESSION['userName'];?><br />
                     <!--button onClick="location='logout_proc.php'">Logout</button></span-->
			      <?php
                              }
                    ?>
        </td>
  <td colspan="2" width="66" height="55"><a href="login_proc.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image24','','images/menu-login3_14.gif',1)"><img src="images/menu-login_14.gif" name="Image24" width="73" height="52" border="0"></a></td>
  <td colspan="2">
			<img src="images/menu-login3_11.gif" width="27" height="55" alt=""></td>
	</tr>
	<tr>
		<td colspan="6">
			<img src="images/menu-login3_12.gif" width="281" height="10" alt=""></td>
	</tr>
	<tr>
		<td colspan="8">
			<img src="images/menu-login3_13.gif" width="314" height="103" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/spacer.gif" width="93" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="11" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="56" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="132" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="11" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="55" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="8" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="19" height="1" alt=""></td>
		<td>
			<img src="images/spacer.gif" width="22" height="1" alt=""></td>
	</tr>
</table>

                    
<script>
function cekLogin(){	
    if(document.getElementById('txtUser_billing').value==''){
	  alert('Silakan isi username!');
	  return false;
    }
    else{
	  return true;
    }
}
</script>
