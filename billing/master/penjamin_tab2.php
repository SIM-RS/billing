<?php
session_start();
include("../sesi.php");
?>
<table width="850" border="0">  
   <tr>
      <td align="center">
         <fieldset>
            <legend>Layanan Pada Rumah Sakit</legend>
         <div id="gridbox2" style="width:400px; height:300px; background-color:white;"></div>		
		<div id="paging2" style="width:410px;margin-top:20px;"></div>
            </fieldset>
      </td>
      <td align="center"> <input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="40" tabindex="3" value="<?php echo $flag; ?>"/>        
        <input type="button" id="btnRight" value="" onclick="pindahKanan()" class="tblRight"/>
        <br>
         <input type="button" id="btnLeft" value="" onclick="pindahKiri()" class="tblLeft"/>
      </td>
      <td align="center">
         <fieldset><legend>Layanan Tidak Dijamin : <select id="cmbKso" class="txtinput" onchange="loadLayananTdkJamin()"></select></legend>
          <div id="gridbox3" style="width:400px; height:300px; background-color:white;"></div>		
		<div id="paging3" style="width:410px;margin-top:20px;"></div>
            </fieldset>
      </td>
   </tr>
</table>