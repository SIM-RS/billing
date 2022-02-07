<?php
session_start();
include("../sesi.php");
?>
<table width="850" border="0">  
   <tr>
      <td align="center">
         <fieldset>
            <legend>Tindakan</legend>
         <div id="gridAkomodasiKiri" style="width:400px; height:300px;"></div>
		<div id="pagingAkomodasiKiri" style="width:410px;margin-top:20px;"></div>
            </fieldset>
      </td>
      <td align="center">  
      <input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="40" tabindex="3" value="<?php echo $flag; ?>"/>       
        <input type="button" id="btnRightAkomodasi" value="" onclick="pindahAkomodasiKanan()" class="tblRight"/>
        <br>
         <input type="button" id="btnLeftAkomodasi" value="" onclick="pindahAkomodasiKiri()" class="tblLeft"/>
      </td>
      <td align="center">
         <fieldset><legend>
	   Paket Akomodasi :
	   <select id="cmbKsoAkomodasi" class="txtinput" onchange="loadAkomodasi()"></select>
	   </legend>
          <div id="gridAkomodasi" style="width:400px; height:300px;"></div>
		<div id="pagingAkomodasi" style="width:410px;margin-top:20px;"></div>
            </fieldset>
      </td>
   </tr>
</table>