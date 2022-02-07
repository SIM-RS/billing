<?php
   include('../koneksi/konek.php');
   $sql = "select * from lap_lra_sap order by kode";
   $hasil = mysql_query($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:LAPORAN REALISASI ANGGARAN:.</title>
</head>

<body>
<form>
  <table width="78%">
  	<tr>
    	<td align="center" width="1048" style="font-weight:bold;">RSUD ...............................</td>
  	</tr><tr>
    	<td align="center" width="1048" style="font-weight:bold;">...........................................</td>
  	</tr><tr>
    	<td height="30" colspan="3" align="center" style="font-size:14px;font-weight:bold;">LAPORAN REALISASI ANGGARAN</td>
  	</tr><tr>  
    	<td colspan="3" align="center" style="font-size:14px;font-weight:bold;">TRIWULAN 1 TAHUN 2013</td>
  	</tr><tr>
    	<td align="center" style="font-size:12px;font-weight:bold;">(Dinyatakan dalam rupiah)</td>
  	</tr>
  </table>
  <table width="78%" border="0" cellpadding="1" cellspacing="0">
     <thead>
         <tr>
            <td align="center" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
            <td align="center" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
            <td align="center" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
            <td align="center" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
            <td align="center" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
            <td align="center" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
            <td align="center" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
         </tr><tr>
            <td align="center" width="33" style="border-bottom:double; font-weight:bold;">No</td>
            <td align="center" width="240" style="border-bottom:double; font-weight:bold;">Uraian</td>
            <td align="center" width="121" style="border-bottom:double; font-weight:bold;">Catatan Nomor</td>
            <td align="center" width="115" style="border-bottom:double; font-weight:bold;">Anggaran</td>
            <td align="center" width="151" style="border-bottom:double; font-weight:bold;">Realisasi TW 1</td>
            <td align="center" width="157" style="border-bottom:double; font-weight:bold;">Realisasi Sd. TW 1</td>
            <td align="center" width="186" style="border-bottom:double; font-weight:bold;">Sisa Anggaran</td>
         </tr><tr>
            <td align="center">&nbsp;</td>
            <td align="left">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
        </tr>
    </thead>
<?php
   	while ($t = mysql_fetch_row($hasil)){
?>  	
	<tbody>
		<tr>
          <td align="center" width="33"><?php echo $t['2'];?></td>
          <td align="left" width="240"><?php echo $t['3'];?></td>
          <td align="center" width="121">&nbsp;</td>
          <td align="center" width="115">&nbsp;</td>
          <td align="center" width="151">&nbsp;</td>
          <td align="center" width="157">&nbsp;</td>
          <td align="center" width="186">&nbsp;</td>
        </tr>
<?php
	$no++;
	}
?>
		<tr>
          <td align="center" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
          <td align="center" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
          <td align="center" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
          <td align="center" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
          <td align="center" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
          <td align="center" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
          <td align="center" style="border-bottom:#000000 solid 1px;">&nbsp;</td>
     	</tr><tr>
          <td align="center" style="border-bottom:double">&nbsp;</td>
          <td align="left" style="border-bottom:double">&nbsp;</td>
          <td align="center" style="border-bottom:double">&nbsp;</td>
          <td align="center" style="border-bottom:double">&nbsp;</td>
          <td align="center" style="border-bottom:double">&nbsp;</td>
          <td align="center" style="border-bottom:double">&nbsp;</td>
          <td align="center" style="border-bottom:double">&nbsp;</td>
        </tr>
	</tbody>      
</table>
</form>
</body>
</html>