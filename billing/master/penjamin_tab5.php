<?php
session_start();
include("../sesi.php");
?>
<table width="850" border="0">  
   <tr>
      <td align="center">
         <fieldset>
            <legend>Tindakan</legend>
         <div id="gridbox9" style="width:400px; height:300px;"></div>
		<div id="paging9" style="width:410px;margin-top:20px;"></div>
            </fieldset>
      </td>
      <td align="center">  
      <input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="40" tabindex="3" value="<?php echo $flag; ?>"/>       
        <input type="button" id="btnRight" value="" onclick="pindahLuarPaketKanan()" class="tblRight"/>
        <br>
         <input type="button" id="btnLeft" value="" onclick="pindahLuarPaketKiri()" class="tblLeft"/>
      </td>
      <td align="center">
         <fieldset><legend>
	   Tindakan di luar paket :
	   <select id="cmbKsoLuarPaket" class="txtinput" onchange="loadLuarPaket()"></select>
	   </legend>
          <div id="gridbox10" style="width:400px; height:300px;"></div>
		<div id="paging10" style="width:410px;margin-top:20px;"></div>
            </fieldset>
      </td>
   </tr>
</table>