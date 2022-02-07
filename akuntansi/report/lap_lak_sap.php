<?php
   include('../koneksi/konek.php');
   $sql = "select * from lap_lak_sap order by kode";
   $hasil = mysql_query($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:LAPORAN ARUS KAS:.</title>
</head>

<body>
<form>
  <table width="80%">
  	<tr>
    	<td align="center" width="1056" style="font-weight:bold;">RSUD ...............................</td>
  	</tr><tr>
    	<td align="center" width="1056" style="font-weight:bold;">...........................................</td>
  	</tr><tr>
    	<td height="30" colspan="3" align="center" style="font-size:16px;font-weight:bold;">LAPORAN ARUS KAS</td>
  	</tr><tr>  
    	<td colspan="3" align="center" style="font-size:16px;font-weight:bold;">TRIWULAN 1 TAHUN 2013</td>
  	</tr><tr>
    	<td align="center" style="font-size:12px;font-weight:bold;">(Dinyatakan dalam rupiah)</td>
  	</tr>
  </table>
  <table width="80%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
    <thead>
     <tr>
     	<td align="center" width="59" style="border-bottom:double; border-top:#000 solid 1px;font-weight:bold;">No</td>
        <td align="center" style="border-bottom:double; border-top:#000 solid 1px; font-weight:bold;">Uraian</td>
        <td align="center" width="162" style="border-bottom:double; border-top:#000 solid 1px; font-weight:bold;">Catatan Nomor</td>
        <td align="center" width="139" style="border-bottom:double; border-top:#000 solid 1px; font-weight:bold;">TW 1</td>
        <td align="center" width="181" style="border-bottom:double; border-top:#000 solid 1px; font-weight:bold;">S/D TW 1</td>
     </tr>
	</thead>
<?php
   	while ($t = mysql_fetch_array($hasil)){
?>         	
	<tbody>
		<tr>
        	<td align="center" style="font-weight:bold;"><strong><?php echo $t['2'];?></strong></td>
        	<td style="font-weight:bold; padding-left:<?php echo(25*($t['level']-3))."px"?>" align="left"><?php echo $t['3'];?></td>
            <td align="center" width="162"></td>
            <td align="center" width="139"></td>
            <td align="center" width="181"></td>
        </tr>
<?php
	}
?>        
        <tr>
            <td align="center">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="center"></td>
            <td align="right" style="border-bottom:double; border-top:#000 solid 1px;"">&nbsp;</td>
            <td align="right" style="border-bottom:double; border-top:#000 solid 1px;"">&nbsp;</td>
        </tr>
	</table>
</form>
</body>
</html>