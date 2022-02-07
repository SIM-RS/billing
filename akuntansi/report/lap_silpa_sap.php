<?php
   include('../koneksi/konek.php');
   $sql = "select * from lap_silpa_sap order by kode";
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
  <table width="86%">
  	<tr>
    	<td align="center" width="1152" style="font-weight:bold;">RSUD ...............................</td>
  	</tr><tr>
    	<td align="center" width="1152" style="font-weight:bold;">...........................................</td>
  	</tr><tr>
    	<td height="30" colspan="3" align="center" style="font-size:14px;font-weight:bold;">LAPORAN PERUBAHAN EKUITAS</td>
 	</tr><tr>  
    	<td colspan="3" align="center" style="font-size:14px;font-weight:bold;">TRIWULAN 1 TAHUN 2013</td>
  	</tr><tr>
    	<td align="center" style="font-size:12px;font-weight:bold;">(Dinyatakan dalam rupiah)</td>
  	</tr>
  </table>
  <table width="86%" border="0" cellpadding="0" cellspacing="0">
    <tr>
       <td align="center" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
       <td align="center" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
       <td align="center" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
       <td align="center" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
       <td align="center" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
     </tr><tr>
     	<td align="center" width="64" style="border-bottom:double; font-weight:bold;">No</td>
        <td align="center" width="446" style="border-bottom:double; font-weight:bold;">Uraian</td>
        <td align="center" width="223" style="border-bottom:double; font-weight:bold;">Catatan Nomor</td>
        <td align="center" width="191" style="border-bottom:double; font-weight:bold;">TW 1</td>
        <td align="center" width="196" style="border-bottom:double; font-weight:bold;">S/D TW 1</td>
     </tr><tr>
     	<td align="center" width="64">&nbsp;</td>
        <td align="center" width="446">&nbsp;</td>
        <td align="center" width="223">&nbsp;</td>
        <td align="center" width="191">&nbsp;</td>
        <td align="center" width="196">&nbsp;</td>
     </tr>
<?php
	$no=1;
   	while ($t = mysql_fetch_row($hasil)){
?> 
	<tr>
		<td align="center" width="64"><?=$no;?></td>
		<td align="left" width="446"><?php echo $t['2'];?></td>
		<td align="center" width="223">&nbsp;</td>
		<td align="center" width="191">&nbsp;</td>
		<td align="center" width="196">&nbsp;</td>
	</tr>
<?php
	$no++;
	}
?>   
	<tr>
       <td align="center" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
       <td align="left" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
       <td align="center" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
       <td align="center" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
       <td align="center" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
	</tr><tr>
       <td align="center" style="border-bottom:double">&nbsp;</td>
       <td align="left" style="border-bottom:double">&nbsp;</td>
       <td align="center" style="border-bottom:double">&nbsp;</td>
       <td align="center" style="border-bottom:double">&nbsp;</td>
       <td align="center" style="border-bottom:double">&nbsp;</td>
    </tr>     
  </table>
</form>
</body>
</html>