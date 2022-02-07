<?php
include("../koneksi/konek.php");
?>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" class="tabel" align="center">
  <tr>
    <td colspan="7" align="center">&nbsp;</td>
  </tr>
  <tr>
  	<td width="5%">&nbsp;</td>
    <td width="15%" align="right">Jenis Layanan</td>
    <td width="25%">&nbsp;<select id="cmbJnsLay2" class="txtinput" onchange="isiTmpLay2();">			 
		  </select></td>
    <td width="10%">&nbsp;</td>
    <td width="20%" align="right">Tempat Layanan</td>
    <td width="20%">&nbsp;<select id="TmpLayanan2" class="txtinput" onchange="ubahUnit2();"></select></td>
  	<td width="5%">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  	<td>&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
	<td align="right">Periode</td>
  	<td colspan="5">&nbsp;<input type="text" class="txtcenterreg" id="tglAwal" size="11" tabindex="22" value="<?php echo date('d-m-Y');?>"/>
		<input type="button" id="buttontglAwal" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('tglAwal'),depRange,ubahUnit2);" />
		sampai
		<input type="text" class="txtcenterreg" id="tglAkhir" size="11" tabindex="22" value="<?php echo date('d-m-Y');?>"/>
		<input type="button" id="buttontglAkhir" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('tglAkhir'),depRange,ubahUnit2);" />
	</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="5">&nbsp;<input type="button" class="txtcenter" value="Generate" onclick="generate()"/>
	</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><img src="../icon/edit.gif" style="cursor:pointer" onclick="editPop()" title="edit pegawai" />
    <img src="../icon/hapus.gif" style="cursor:pointer" onclick="del()" title="hapus pegawai" /></td>
  	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
    <td colspan="5">
		<div id="gridboxtab2" style="width:900px; height:350px; background-color:white; overflow:hidden;"></div>
		<div id="pagingtab2" style="width:900px;"></div>
		</td>
  	<td>&nbsp;</td>
  </tr>
  </table>
  
  