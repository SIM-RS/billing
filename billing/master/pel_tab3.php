<?php
	
	include("../sesi.php");

?>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="4" height="20">&nbsp;</td>
  </tr>
  
  <tr>
    <td width="425"></td>
    <td width="16"></td>
    <td width="58">Jenis     </td>
    <td width="367">:
      <select name="select" class="txtinput" id="cmbJnsLay" onchange="isiTmpLay();">
    </select></td>
  </tr>
  <tr>
	  <td>	  </td>
	  <td></td>
	  <td>
	     Tempat</td>
      <td>: 
        <select name="select2" class="txtinput" id="TmpLayanan" lang="" onchange="ubahUnit();">
      </select>    <input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="45" tabindex="3" value="<?php echo $flag; ?>"/>  </td>
  </tr>
			
			
  <tr><td colspan="4">&nbsp;</td></tr>
  <tr>
    <td>		
		<div id="gridboxtab3a" style="width:425px; height:250px; background-color:white; overflow:hidden;"></div>
		<div id="pagingtab3a" style="width:425px;"></div>	</td>
    <td align="center">	
	<input type="button" id="btnRight" value="" onclick="pindahKanan()" class="tblRight"/>
	<br>
	<input type="button" id="btnLeft" value="" onclick="pindahKiri()" class="tblLeft"/>    </td>
    <td colspan="2">		
		<div id="gridboxtab3b" style="width:425px; height:250px; background-color:white; overflow:hidden;"></div>
		<div id="pagingtab3b" style="width:425px;"></div>	</td>
  </tr>
</table>
