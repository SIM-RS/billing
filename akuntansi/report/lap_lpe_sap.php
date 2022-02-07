<?php
   include('../koneksi/konek.php');
   $sql = "select * from lap_lpe_sap order by kode";
   $hasil = mysql_query($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:LAPORAN PERUBAHAN EKUITAS:.</title>
</head>

<body>
<form>
	<table width="87%">
  		<tr>
    		<td align="center" width="1166" style="font-weight:bold;">RSUD ...............................</td>
  		</tr><tr>
    		<td align="center" width="1166" style="font-weight:bold;">...........................................</td>
  		</tr><tr>
    		<td height="30" colspan="3" align="center" style="font-size:14px;font-weight:bold;">LAPORAN PERUBAHAN EKUITAS</td>
  		</tr><tr>  
    		<td colspan="3" align="center" style="font-size:14px;font-weight:bold;">TRIWULAN 1 TAHUN 2013</td>
  		</tr><tr>
    		<td height="10" align="center" style="font-size:12px;font-weight:bold;">(Dinyatakan dalam rupiah)</td>
  		</tr>
  </table>
  <table width="85%" border="0" cellpadding="0" cellspacing="0">
   <thead>  
     <tr>
       	<td align="center" width="44" style="border-bottom:#000000 solid 1px;"></td>
       	<td align="center" width="346" style="border-bottom:#000000 solid 1px;"></td>
        <td align="center" width="252" style="border-bottom:#000000 solid 1px;"></td>
        <td align="center" width="282" style="border-bottom:#000000 solid 1px;"></td>
        <td align="center" width="252" style="border-bottom:#000000 solid 1px;"></td>
     </tr><tr>
     	<td align="center" width="41" style="border-bottom:double; font-weight:bold;">No</td>
        <td align="center" width="332" style="border-bottom:double; font-weight:bold;">Uraian</td>
        <td align="center" width="253" style="border-bottom:double; font-weight:bold;">Catatan Nomor</td>
        <td align="center" width="230" style="border-bottom:double; font-weight:bold;">TW 1</td>
        <td align="center" width="245" style="border-bottom:double; font-weight:bold;">S/D TW 1</td>
     </tr>
   </thead>
<?php
   	while ($t = mysql_fetch_row($hasil)){
?>  
    <tbody> 
     <!--<tr>
       	<td align="center" width="44"></td>
       	<td align="center" width="10">&nbsp;</td>
        <td align="center" width="346"></td>
        <td align="center" width="6">&nbsp;</td>
        <td align="center" width="252"></td>
        <td align="center" width="9">&nbsp;</td>
        <td align="center" width="282"></td>
        <td align="center" width="9">&nbsp;</td>
        <td align="center" width="252"></td>
     </tr>--><tr>
       	<td align="center" width="41"><?php echo $t['2'];?></td>
       	<td align="left" width="332"><?php echo $t['3'];?></td>
        <td align="center" width="253"></td>
        <td align="center" width="230"></td>
        <td align="center" width="245"></td>
     </tr>
<?php
   	}
?>        
     </tbody>
        <tr>
          	<td align="center" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
          	<td align="left" style="border-bottom:#000000 solid 1px;"></td>
          	<td align="center" style="border-bottom:#000000 solid 1px;"></td>
          	<td align="center" style="border-bottom:#000000 solid 1px;"></td>
          	<td align="center" style="border-bottom:#000000 solid 1px;"></td>
        </tr><tr>
          	<td align="center" style="border-bottom:double"></td>
          	<td align="left" style="border-bottom:double"></td>
          	<td align="center" style="border-bottom:double"></td>
          	<td align="center" style="border-bottom:double"></td>
          	<td align="center" style="border-bottom:double"></td>
        </tr>
	</table>
</form>
</body>
</html>