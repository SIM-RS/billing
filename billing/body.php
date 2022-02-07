<style type="text/css">

.jk {
	background-image: -moz-linear-gradient(top, #E9E9E1, #EDECE7);
}
.style2 {
	color: #005500;
	font-size: 18px;
}

</style>
<table bgcolor="#EAF0F0" id="Table_01" width="1000" height="400" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td rowspan="8" width="600" height="371" background="images/images/content.jpg">&nbsp;</td>
		<td colspan="2" width="87" height="66">&nbsp;</td>
		<td colspan="2">
                    <img src="images/images/body_03.gif" width="165" height="66" alt="">
                </td>
		<td colspan="3" width="120" height="66">&nbsp;</td>
		<td rowspan="9" width="25" height="399">&nbsp;</td>
		<td>
                    <img src="images/images/spacer.gif" width="1" height="66" alt="">
                </td>
	</tr>
	<tr>
		<td colspan="3" width="160" height="62">&nbsp;</td>
		<td colspan="4">
			<img src="images/images/body_07.gif" width="212" height="62" alt=""></td>
		<td>
			<img src="images/images/spacer.gif" width="1" height="62" alt=""></td>
	</tr>
	<tr>
		<td colspan="3" rowspan="2" width="160" height="21">&nbsp;</td>
		<td colspan="3">
			<img src="images/images/body_09.gif" width="181" height="9" alt=""></td>
		<td rowspan="5">
			<img src="images/images/body_10.gif" width="31" height="153" alt=""></td>
		<td>
			<img src="images/images/spacer.gif" width="1" height="9" alt=""></td>
	</tr>
	<tr>
		<td colspan="2">
			<img src="images/images/body_11.gif" width="99" height="12" alt=""></td>
		<td rowspan="2">
			<img src="images/images/body_12.gif" width="82" height="41" alt=""></td>
		<td>
			<img src="images/images/spacer.gif" width="1" height="12" alt=""></td>
	</tr>
	<tr>
		<td rowspan="3">
			<img src="images/images/body_13.gif" width="17" height="132" alt=""></td>
		<td colspan="4" rowspan="3" width="242" height="132" class="jk">
			<table border="0" cellpadding="0" cellspacing="0" class="jk">
			<tr>
			  <td width="242" height="129">
		
			<?php
                    if(!isset($_SESSION['userId'])){
                 ?>
			<form id="formLogin" action="login_proc.php" method="post" onsubmit="return cekLogin();">
			  <table align="center" width="230" border="0">
			  	<tr>
				<td height="20" colspan="3" class="style2">Login</td>
				</tr>
                <tr>
                  <td width="63">User Id </td>
                  <td width="10">&nbsp;</td>
                  <td width="152"><input class="txtinputan" type="text" size="10" id="txtUser" name="txtUser" value="" onfocus="if(this.value == 'User ID') this.value='';" onblur="if(this.value=='') this.value = 'User ID'" />
                  &nbsp;</td>
                </tr>		    
                <tr>
                  <td>Password</td>
                  <td>&nbsp;</td>
                  <td><input class="txtinputan" type="password" size="10" id="txtPass" name="txtPass" value="" />
                  &nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td><input class="btninputan" type="submit" value="login" />&nbsp;</td>
                </tr>
		   
              </table>
			  </form>
			  
			 <?php
                    }
                    else{
                       ?>
			   <span>Selamat datang <?php echo $_SESSION['userName'];?><br />
                     <button onclick="location='logout_proc.php'">Logout</button></span>
			      <?php
                              }
                    ?>
			  </td>
			</tr>
			<tr>
				<td width="242" height="3" background="images/images/line_03.gif"></td>
			</tr>
			</table>	
		</td>
		<td>
			<img src="images/images/spacer.gif" width="1" height="29" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="images/images/body_15.gif" width="82" height="51" alt=""></td>
		<td>
			<img src="images/images/spacer.gif" width="1" height="51" alt=""></td>
	</tr>
	<tr>
		<td width="82" height="52">
		<table border="0" cellpadding="0" cellspacing="0"  class="jk">
			<tr>
				<td width="82" height="49"></td>
			</tr>
			<tr>
				<td width="82" height="3" background="images/images/line_03.gif"></td>
			</tr>
		  </table>	
		</td>
		<td>
			<img src="images/images/spacer.gif" width="1" height="52" alt=""></td>
	</tr>
	<tr>
		<td colspan="7" rowspan="2" width="372" height="118">&nbsp;</td>
		<td><img src="images/images/spacer.gif" width="1" height="90" alt=""></td>
	</tr>
	<tr>
		<td width="600" height="28">&nbsp;</td>
		<td>
			<img src="images/images/spacer.gif" width="1" height="28" alt=""></td>
	</tr>
	<tr>
		<td height="2">
			<img src="images/images/spacer.gif" width="600" height="1" alt=""></td>
		<td>
			<img src="images/images/spacer.gif" width="17" height="1" alt=""></td>
		<td>
			<img src="images/images/spacer.gif" width="70" height="1" alt=""></td>
		<td>
			<img src="images/images/spacer.gif" width="73" height="1" alt=""></td>
		<td>
			<img src="images/images/spacer.gif" width="92" height="1" alt=""></td>
		<td>
			<img src="images/images/spacer.gif" width="7" height="1" alt=""></td>
		<td>
			<img src="images/images/spacer.gif" width="82" height="1" alt=""></td>
		<td>
			<img src="images/images/spacer.gif" width="31" height="1" alt=""></td>
		<td>
			<img src="images/images/spacer.gif" width="28" height="1" alt=""></td>
		<td></td>
	</tr>
</table>
<script type="text/JavaScript">
function cekLogin(){	
    if(document.getElementById('txtUser').value==''){
	  alert('Silakan isi username!');
	  return false;
    }
    else{
	  return true;
    }
}
</script>
