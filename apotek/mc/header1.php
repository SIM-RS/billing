<?php
include("../sesi.php");
$wktnow=gmdate('H:i:s',mktime(date('H')+7));
$wkttgl=gmdate('d/m/Y',mktime(date('H')+7));
$url=split("/",$_SERVER['REQUEST_URI']);
$imgpath="/".$url[1]."/images";
$iunit=$_SESSION['username'];
//=============================
?>
<table width="1000" border="0" cellspacing="0" cellpadding="0">
  <tr class="H">
  	<td width="155" bgcolor="#4E98C8"><img src="../images/kopKiri.jpg" width="166" height="100"></td>
	<td align="right" bgcolor="#4E98C8">
	<table width="637" border="0" align="center" id="menuatas">
      <tr style="border-right:#FFFFFF">
        <td align="right"><a class="navText" href="spph.php">C1. SPPH &laquo;</a></td>
        <td width="23" rowspan="4" align="center" id style="border-right:1px solid #FFFFFF; border-left:1px solid #FFFFFF">&nbsp;</td>
        <td align="left"><a class="navText" href="po.php">&raquo; C2. Purchase Order</a></td>
      </tr>
      <tr>
        <td align="right"><a class="navText" id="link2" width="300" style="cursor:pointer;" onMouseOver="MM_showMenu(window.mm_menu_0814123211_6,50,0,null,'link2');" onMouseOut="MM_startTimeout();"> C3. Laporan &laquo;</a></td>
        <td align="left"><!--a class="navText" href="harga.php">&raquo; C4. Harga Obat & Alkes</a--></td>
      </tr>
      <tr>
        <td align="right"><!--a class="navText" href="#"> C5. Laporan &laquo;</a--></td>
        <td align="left"><!--a class="navText" href="list_hps_obat.php">&raquo; C6. Penghapusan Obat </a--></td>
      </tr>
      <tr>
        <td width="300">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
<table width="100%" border="0">
  <tr>
    <td width="50%" style="float:left; padding-left:10px; font:12px arial; color:#FFFF00"><i> Tanggal: <?php echo $wkttgl; ?></i>
	&nbsp;&nbsp;&nbsp;&nbsp;Login: <b><?=strtoupper($username); ?></b>
	&nbsp;&nbsp;&nbsp;&nbsp;
	Unit: <b><?php echo strtoupper($namaunit); ?></b>
	</td>
    <td width="50%" align="right" style="padding-right:10px;">
	<button type="button" onClick="if (confirm('Anda Yakin Ingin Logout?')){location='../index.php';}" style=" font:bold 11px Verdana;"><img src="../icon/logout.gif"> Logout</button>
	</td>
  </tr>
</table>
</td>
	<td width="167" bgcolor="#4E98C8"><img src="../images/kopKanan.jpg" width="166" height="100"></td>
  </tr>
  <tr class="H">
  	<td height="25" colspan="6" id="dateformat">
	<marquee scrolldelay="150" style="text-transform:uppercase">
	SISTEM FARMASI <?=$namaRS;?>
	</marquee>
	</td>
	</tr>
</table>