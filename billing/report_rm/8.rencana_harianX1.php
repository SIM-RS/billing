<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>rencana harian</title>
</head>
<?
include "setting.php";
include "../koneksi/konek.php";

?>
<body>
<table width="910" border="0">
  <tr>
    <td><table width="800" border="0" cellpadding="4" style="font:12px tahoma;">
      <tr>
        <td width="92">Tanggal</td>
        <td width="698">&nbsp;</td>
      </tr>
    </table>
      <br />
      <table width="800" border="1" cellpadding="4" bordercolor="#000000" style="font:12px tahoma; border-collapse:collapse;">
        <tr align="center">
          <td>Dinas Pagi<br />
            PP/NIC</td>
          <td>Room</td>
          <td>Dinas Sore <br />
            PP/NIC</td>
          <td>Room</td>
          <td>Dinas Malam <br />
            PP/NIC</td>
          <td>Room</td>
        </tr>
        <tr>
          <td>1</td>
          <td>&nbsp;</td>
          <td>1</td>
          <td>&nbsp;</td>
          <td>1</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>2</td>
          <td>&nbsp;</td>
          <td>2</td>
          <td>&nbsp;</td>
          <td>2</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>3</td>
          <td>&nbsp;</td>
          <td>3</td>
          <td>&nbsp;</td>
          <td>3</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>4</td>
          <td>&nbsp;</td>
          <td>4</td>
          <td>&nbsp;</td>
          <td>4</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>5</td>
          <td>&nbsp;</td>
          <td>5</td>
          <td>&nbsp;</td>
          <td>5</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>6</td>
          <td>&nbsp;</td>
          <td>6</td>
          <td>&nbsp;</td>
          <td>6</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <br />
      <table width="800" border="1" cellpadding="4" bordercolor="#000000" style="font:12px tahoma; border-collapse:collapse;">
        <tr align="center">
          <td>Kamar / TT</td>
          <td>Nama Pasien</td>
          <td>Diagnosa Medis / Diagnosa inap</td>
          <td>Infuse</td>
          <td>Rencana Pagi</td>
          <td>Rencana Sore</td>
          <td>Rencana Malam</td>
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
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
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
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <br />
      <table width="800" border="1" cellpadding="4" bordercolor="#000000" style="font:12px tahoma; border-collapse:collapse;">
        <tr align="center">
          <td>Kamar / TT</td>
          <td>Nama Pasien</td>
          <td>Diagnosa Medis / Diagnosa inap</td>
          <td>Infuse</td>
          <td>Rencana Pagi</td>
          <td>Rencana Sore</td>
          <td>Rencana Malam</td>
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
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
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
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      <br />
      <table width="800" border="0" cellpadding="4" style="font:12px tahoma;">
        <tr align="center">
          <td width="109">&nbsp;</td>
          <td width="116">PP Malam </td>
          <td width="118">PP Pagi </td>
          <td width="109">PP Malam </td>
          <td width="110">PP Pagi </td>
          <td width="119">PP Malam </td>
          <td width="89">PP Pagi </td>
        </tr>
        <tr valign="bottom" align="center">
          <td height="88">&nbsp;</td>
          <td>(____________)</td>
          <td>(____________)</td>
          <td>(____________)</td>
          <td>(____________)</td>
          <td>(____________)</td>
          <td>(____________)</td>
        </tr>
      </table>
    <p></p></td>
  </tr>
  <tr>
    </tr><tr id="trTombol">
        <td class="noline" colspan="5" align="right"><div align="center">
          <input name="button" type="button" id="btnPrint" onclick="cetak(document.getElementById('trTombol'));" value="Print"/>
          <input name="button2" type="button" id="btnTutup" onclick="window.close();" value="Tutup"/>
        </div></td>
      </tr><tr><td><div align="center"></div></td>
  </tr>
  <tr>
    </tr><tr id="trTombol"></tr><tr id="trTombol">
        <td class="noline" colspan="5" align="right">&nbsp;</td>
    </tr><tr>
      <td>&nbsp;</td>
    </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
<script type="text/JavaScript">

        function cetak(tombol){
            tombol.style.visibility='collapse';
            if(tombol.style.visibility=='collapse'){
                if(confirm('Anda Yakin Mau Mencetak ?')){
                    setTimeout('window.print()','1000');
                    setTimeout('window.close()','2000');
                }
                else{
                    tombol.style.visibility='visible';
                }

            }
        }
    </script>
	<?php 
mysql_close($konek);
?>
</html>
