<style type="text/css">

.jk {
	background-image: -moz-linear-gradient(top, #E9E9E1, #EDECE7);
}
.style2 {
	color: #005500;
	font-size: 18px;
}
.bekgron{
	background-image:url('images/images/content.jpg');
	background-repeat:no-repeat;
}
</style>

<table bgcolor="#EAF0F0" id="Table_01" width="1000" height="400" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="593" height="374" class="bekgron">&nbsp;</td>
	  <td width="407" height="374" valign="top"><?php include "menu-loginn.php";?></td>
  </tr>
</table>
<script>
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
