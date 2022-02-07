<?php
include '../sesi.php';
// is valid users
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
$r_formatlap = $_POST["formatlap"];

switch ($r_formatlap) {
    case "XLS" :
        Header("Content-Type: application/vnd.ms-excel");
        break;
    case "WORD" :
        Header("Content-Type: application/msword");
        break;
    default :
        Header("Content-Type: text/html");
        break;
}

if(($_GET['tgl1'] != '' && isset($_GET['tgl2']))&&($_GET['tgl1'] != '' && isset($_GET['tgl2']))) {
    
$tg1 = explode('-', $_GET['tgl1']);
$tg1 = $tg1[2].'-'.$tg1[1].'-'.$tg1[0];
$tg2 = explode('-', $_GET['tgl2']);
$tg2 = $tg2[2].'-'.$tg2[1].'-'.$tg2[0];
$sql = "SELECT po.id,date_format(tgl_po,'%d-%m-%Y') as tgl_po,judul,no_po,namarekanan,date_format(exp_kirim,'%d-%m-%Y') exp_kirim,SUM(total) AS total
        FROM as_po po INNER JOIN as_ms_rekanan rek ON po.vendor_id=rek.idrekanan                 
        WHERE tgl_po between '".$tg1."' and '".$tg2."' group by tgl_po,no_po
        ORDER BY date(tgl_po),no_po;";
    //$rs1 = mysql_query($sql);
    //$res = mysql_affected_rows();
    //if($res > 0) {        
    //    $rows1 = mysql_fetch_array($rs1);
    //    mysql_free_result($rs1);
    //}
    //echo $sql;
}

?>
<html>
    <head>
        <title>REKAP PO BULANAN</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link href="../theme/report.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
	<table width="1000" border="0" cellpadding="1" cellspacing="0" style="font:14px Verdana, Arial, Helvetica, sans-serif">
	    <tr id="trCetak">
		<td>
		    <input type="button" value="CETAK" onClick="cetak()"/>
		    <input type="button" value="TUTUP" onClick="window.close()"/>
		</td>
	    </tr>
	    <tr>
		<td align="center" style="font:bold 14px Verdana, Arial, Helvetica, sans-serif">DAFTAR PO<br /></td>
	    </tr>
	    <tr>
		<td align="center" style="font:bold 14px Verdana, Arial, Helvetica, sans-serif">Periode <?php  echo $_GET['tgl1']; ?> s/d  <?php echo $_GET['tgl2'];?><br />
		<!--td align="center"><strong><font size="4" face="Times New Roman, Times, serif">
		Bulan <?php  echo getnamabulan($bln_po,0); ?>   <?php echo $thn_po;?></font><br /--></strong>
		</td>
	    </tr>
	    <tr></tr>
	    
	</table>
	    
	<tr><br/></tr>
	<tr><br/></tr>
	    
	<table border=1 cellspacing="0" cellpadding="4" class="GridStyle" width="1000">
            <tr align="center" valign="top" bgcolor="#CCCCCC" class="HeaderBW">
                <td width="20"><font size="-2"><br />No</font></td>
                <td width="50"><font size="-2"><br />Tanggal PO</font></td>
                <td width="140"><font size="-2"><br />No PO</font> </td>
		<td width="300"><font size="-2"><br />Judul</font> </td>
                <td width="150"><font size="-2"><br />Rekanan</font></td>
		<td width="50"><font size="-2"><br />Exp Kirim</font> </td>
		<td width="80"><font size="-2"><br />Nilai</font> </td>
            </tr>
            
            <tr align="center" valign="top" bgcolor="#FFFFCC" class="SubHeaderBW">
                <td height="10"><font size="-2">1</font></td>
                <td height="10"><font size="-2">2</font></td>
                <td height="10"><font size="-2">3</font></td>
                <td height="10"><font size="-2">4</font></td>
		<td height="10"><font size="-2">5</font></td>
		<td height="10"><font size="-2">6</font></td>
		<td height="10"><font size="-2">7</font></td>
            </tr>
	    <?php
		$rs = mysql_query($sql);
		if (mysql_affected_rows() > 0) { // Iterating through record
		    $j = 0;
                    while ($rows = mysql_fetch_array($rs)) {
                    $j++;
	    ?>
            
		    <tr class="<?php //echo $rowStyle ?>" valign="top">
			<td align="center"><?php echo $j;?></td>
			<td align="left"><div align="center"><?php echo $rows["tgl_po"];?></div></td>
			<td align="left"><?php echo $rows["no_po"]; ?></td>
			<td align="left"><?php echo $rows["judul"]; ?></td>
			<td align="left" class="<?php echo $cellStyle ?>"><div align="center"><?php echo $rows["namarekanan"];?></div></td>
			<td align="center"><?php echo $rows["exp_kirim"]; ?></td>
			<td align="right"><?php 
					echo number_format($rows['total'],0,",",".");
					//echo $rows["total"]; 
			?></td>
		    </tr>
		    <?php  } // end while  ?>
		<?php  } // end if  ?>
    </table>

	
	<script>
	    function cetak(){		
		document.getElementById('trCetak').style.visibility='hidden';
		window.print();
		window.close();				
	    }
	</script>
</body>
</html>