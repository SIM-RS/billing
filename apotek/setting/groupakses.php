<div id="divtab3">
<!--form name="form1" method="post" action="" target="_SELF">
<input name="act" id="act" type="hidden" value="tambah"-->
<table width="925" border="0" cellspacing="0" cellpadding="2" align="center">  
	<tr>
		<td colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td width="8%">&nbsp;</td>
		<td width="15%" align="right">Group akses : </td>
		<td width="46%">
		   <select id="cmbGroup" name="cmbGroup" class="txtinput" onchange="setGroup('<?php echo $_SERVER['HTTP_HOST'];?>',this.value)"></select>
               <span id="isSave"></span>
		</td>
		<td width="23%">&nbsp;</td>
		<td width="8%">&nbsp;</td>
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
		<td align="center" colspan="3">
              <div id="divtree3">
               <?php include('grouptree.php');?>
              </div>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="5">&nbsp;</td>
	</tr>
</table>
<!--/form-->
</div>