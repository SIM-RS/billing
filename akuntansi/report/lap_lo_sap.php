<?php
   include('../koneksi/konek.php');
   $sql = "select * from lap_lo_sap order by kode";
   $hasil = mysql_query($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:LAPORAN OPERASIONAL:.</title>
</head>

<body>
<form>
  <table width="65%">
    <tr>
      <td align="center" width="858" style="font-weight:bold;">RSUD ...............................</td>
    </tr><tr>
      <td align="center" width="858" style="font-weight:bold;">...........................................</td>
    </tr><tr>
      <td height="20" colspan="3" align="center" style="font-size:14px;font-weight:bold;">LAPORAN OPERASIONAL</td>
    </tr><tr>  
      <td colspan="3" align="center" style="font-size:14px;font-weight:bold;">TRIWULAN 1 TAHUN 2013</td>
    </tr><tr>
      <td height="10" align="center" style="font-size:12px;font-weight:bold;">(Dinyatakan dalam rupiah)</td>
    </tr>
  </table>
  <table width="65%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
    <thead> 
     <tr>
        <td align="center" width="26" style="border-bottom:double; font-weight:bold;">No</td>
        <td align="center" width="191" style="border-bottom:double; font-weight:bold;">Uraian</td>
        <td align="center" width="105" style="border-bottom:double; font-weight:bold;">Catatan Nomor</td>
        <td align="center" width="105" style="border-bottom:double; font-weight:bold;">TW 1</td>
        <td align="center" width="206" style="border-bottom:double; font-weight:bold;">S/D TW 1</td>
     </tr>
    </thead> 
<?php
   	while ($t = mysql_fetch_array($hasil)){
?> 
   <tbody> 	
      <tr>
        <td align="center" width="26"><?php echo $t['no'];?></td>
        <td align="left" width="191"><?php echo $t['nama'];?></td>
        <td align="center" width="105">&nbsp;</td>
        <td align="center" width="105">&nbsp;</td>
        <td align="center" width="206">&nbsp;</td>
      </tr>
<?php
	}
?>
   </tbody>    
      <tr>
        <td align="center">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center" style="border-bottom:double">&nbsp;</td>
        <td align="center" style="border-bottom:double">&nbsp;</td>
      </tr>
</table>
</form>
</body>
</html>