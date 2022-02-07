<?php
include('../../koneksi/konek.php');
include('../../sesi.php');
if($_POST['isExcel']=='yes'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="form_RL5.1.xls"');
}

$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
$rsPeg = mysql_query($sqlPeg);
$rwPeg = mysql_fetch_array($rsPeg);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {
	font-size: 14px;
	font-weight: bold;
}
-->
</style>
</head>

<body><table width="700" border="0" style="border-collapse:collapse; font:12px arial">
  <tr>
    <td><table width="100%" border="0" style="border-collapse:collapse">
      <tr>
        <td width="9%" rowspan="2" style="border-bottom:2px solid #000000"><img src="logo-bakti-husada.jpg" width="55" height="60" /></td>
        <td width="59%" height="30"><span class="style1">Formulir RL 5.1</span></td>
        <td width="32%" rowspan="2" style="border-bottom:2px solid #000000"><img src="pojok.png" /></td>
      </tr>
      <tr>
        <td height="30" style="border-bottom:2px solid #000000"><span class="style1">PENGUNJUNG RUMAH SAKIT </span></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="11%"><strong>Kode RS </strong></td>
        <td width="2%"><strong>:</strong></td>
        <td width="87%">&nbsp;</td>
      </tr>
      <tr>
        <td><strong>Nama RS </strong></td>
        <td><strong>:</strong></td>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td><strong>Bulan</strong></td>
        <td><strong>:</strong></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><strong>Tahun</strong></td>
        <td><strong>:</strong></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="60%" border="1" style="border-collapse:collapse">
      <tr>
        <td width="10%"><div align="center"><strong>NO</strong></div></td>
        <td width="70%"><div align="center"><strong>JENIS KEGIATAN  </strong></div></td>
        <td width="30%"><div align="center"><strong>JUMLAH</strong></div></td>
        </tr>
      <tr bgcolor="#CCCCCC">
        <td><div align="center"><strong>1</strong></div></td>
        <td><div align="center"><strong>2</strong></div></td>
        <td><div align="center"><strong>3</strong></div></td>
        </tr>
      <tr>
        <td><div align="center"><strong>1</strong></div></td>
        <td><strong>Pengunjung Baru </strong></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td><div align="center"><strong>2</strong></div></td>
        <td><strong>Pengunjung Lama </strong></td>
        <td>&nbsp;</td>
        </tr>
    <tr id="trTombol" style="border-bottom:none; border-left:none; border-right:none;">
        <td colspan="7" class="noline" align="center">&nbsp;</td>
    </tr>
       <tr id="trTombol">
        <td colspan="7" class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Export Excel" onClick="toExcel();"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
    </tr>
    </table></td>
  </tr>
  <tr>
		<td style="border-top:1px solid #000; padding-top:5px; font-size:12px;" align="right">
			Printed By : <?php echo $rwPeg['nama']; ?>
		</td>
	</tr>
</table>

</body>
</html>
<script type="text/JavaScript">
document.getElementById('totalKsoPT').innerHTML = '&nbsp;<?php if($totKSOPT==0) echo ""; else echo $totKSOPT; ?>';
//document.getElementById('totPasPol').innerHTML = '&nbsp;<?php //if($totPasPol==0) echo ""; else echo $totPasPol; ?>';
document.getElementById('totTdkPasPol').innerHTML = '&nbsp;<?php if($totTdkPasPol==0) echo ""; else echo $totTdkPasPol; ?>';
/* try{	
formatF4();
}catch(e){
window.location='../../addon/jsprintsetup.xpi';
} */
    function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
		/* try{
			mulaiPrint();
		}
		catch(e){
			window.print();
		} */
		window.print();
		window.close();
        }
    }
	function toExcel()
	{
		var cmbWaktu = "<? echo $_REQUEST['cmbWaktu']?>";
		var cmbBln = "<? echo $_REQUEST['cmbBln']?>";
		var cmbThn = "<? echo $_REQUEST['cmbThn']?>";
		var tglAwal = "<? echo $_REQUEST['tglAwal']?>";
		var tglAkhir = "<? echo $_REQUEST['tglAkhir']?>";
		var JnsLayananJln = "<? echo $_REQUEST['JnsLayananJln']?>";
		var TmpLayananBukanInap = "<? echo $_REQUEST['TmpLayananBukanInap']?>";
		var StatusPas = "<? echo $_REQUEST['StatusPas']?>";
		var user_act = "<? echo $_REQUEST['user_act']?>";
		var tglAwal2 = "<? echo $_REQUEST['tglAwal2']?>";
		
		location = 'rekapitulasi_register.php?isExcel=yes&cmbWaktu='+cmbWaktu+'&cmbBln='+cmbBln+'&cmbThn='+cmbThn+'&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir+'&JnsLayananJln='+JnsLayananJln+'&TmpLayananBukanInap='+TmpLayananBukanInap+'&StatusPas='+StatusPas+'&user_act='+user_act+'&tglAwal2='+tglAwal2;
	}
</script>