<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>monitoring ESO</title>
<style type="text/css">
<!--
.style2 {font-size: 10px}
-->
</style>
<?
include "setting.php";
?>
</head>

<body>
<table width="755" border="0" cellpadding="4" style="font:12px tahoma;">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"><table width="407" border="0" cellpadding="4" style="border:1px solid #000000;">
      <tr>
        <td width="117">Nama Pasien </td>
        <td width="8">:</td>
        <td width="260"><?=$nama;?> (<?=$sex;?>)</td>
      </tr>
      <tr>
        <td>Tanggal Lahir </td>
        <td>:</td>
        <td><?=$tgl;?>  /Usia : <?=$umur;?> th </td>
      </tr>
      <tr>
        <td>No. RM </td>
        <td>:</td>
        <td><?=$noRM;?> No. Registrasi :_________ </td>
      </tr>
      <tr>
        <td>Ruang rawat/Kelas </td>
        <td>:</td>
        <td><?=$kamar;?> / <?=$kelas;?></td>
      </tr>
      <tr>
        <td height="23">Alamat</td>
        <td>:</td>
        <td><?=$alamat;?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="172">&nbsp;</td>
    <td width="12">&nbsp;</td>
    <td width="155">&nbsp;</td>
    <td width="189">&nbsp;</td>
    <td width="205">&nbsp;</td>
  </tr>
  <tr>
    <td>Tanggal Lahir </td>
    <td>:</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Jenis Kelamin </td>
    <td>:</td>
    <td><input type="checkbox" name="checkbox" value="checkbox" /> 
      Laki-laki </td>
    <td><input type="checkbox" name="checkbox2" value="checkbox" /> 
      Perempuan </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Jika Perempuan </td>
    <td>:</td>
    <td><input type="checkbox" name="checkbox3" value="checkbox" /> 
    Hamil </td>
    <td><input type="checkbox" name="checkbox4" value="checkbox" />
    Tidak Hamil </td>
    <td> <input type="checkbox" name="checkbox5" value="checkbox" />
      Tidak Tahu </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>PENYAKIT UTAMA </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Kesudahan</td>
    <td>:</td>
    <td><input type="checkbox" name="checkbox6" value="checkbox" />
      Sembuh</td>
    <td><input type="checkbox" name="checkbox62" value="checkbox" />
      Alergi</td>
    <td><input type="checkbox" name="checkbox63" value="checkbox" />
      Faktor Industri </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="checkbox" name="checkbox64" value="checkbox" />
      Meninggal</td>
    <td><input type="checkbox" name="checkbox65" value="checkbox" />
      Kondisi Medis lainnya </td>
    <td><input type="checkbox" name="checkbox66" value="checkbox" />
      Faktor Kimia dan Lain-lain </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">Penyakit/ kondisi lain yang menyertai : </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="checkbox" name="checkbox67" value="checkbox" />
      Gangguan Ginjal </td>
    <td><input type="checkbox" name="checkbox69" value="checkbox" />
      Alergi</td>
    <td><input type="checkbox" name="checkbox611" value="checkbox" />
      Faktor industri </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="checkbox" name="checkbox68" value="checkbox" />
      Gangguan Hati </td>
    <td><input type="checkbox" name="checkbox610" value="checkbox" />
      Kondisi Medis lainnya </td>
    <td><input type="checkbox" name="checkbox612" value="checkbox" />
      Faktor Kimia dan lain-lain </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">EFEK SAMPING OBAT (E.S.O) </td>
  </tr>
  <tr>
    <td colspan="5">Bentuk Manifestasi E.S.O yang terjadi: </td>
  </tr>
  <tr>
    <td colspan="5"><p>_____________________________________________________________________________________________</p>    </td>
  </tr>
  <tr>
    <td colspan="5">_____________________________________________________________________________________________</td>
  </tr>
  <tr>
    <td colspan="5">Saat / Tanggal mulai terjadi : </td>
  </tr>
  <tr>
    <td colspan="5">_____________________________________________________________________________________________</td>
  </tr>
  <tr>
    <td colspan="5">_____________________________________________________________________________________________</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>Kesudahan E.S.O</td>
    <td>:</td>
    <td><input type="checkbox" name="checkbox682" value="checkbox" />
      Sembuh</td>
    <td><input type="checkbox" name="checkbox683" value="checkbox" />
      Meninggal</td>
    <td><input type="checkbox" name="checkbox684" value="checkbox" />
      Sembuh dengan gejala sisa </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="checkbox" name="checkbox685" value="checkbox" />
      Belum sembuh </td>
    <td><input type="checkbox" name="checkbox686" value="checkbox" />
      Tidak Tahu </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">Riwayat E.S.O yang pernah dialami : </td>
  </tr>
  <tr>
    <td colspan="5">______________________________________________________________________________________________</td>
  </tr>
  <tr>
    <td colspan="5">______________________________________________________________________________________________</td>
  </tr>
  <tr>
    <td colspan="5">OBAT ________________________________________________________________________________________</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><table width="759" border="1" bordercolor="#000000" style="border-collapse:collapse;">
      <tr>
        <td width="26" rowspan="2" bgcolor="#CCCCCC" >No</td>
        <td width="128" rowspan="2" bgcolor="#CCCCCC"><div align="center">Nama Obat </div></td>
        <td width="77" rowspan="2" bgcolor="#CCCCCC"><div align="center">Bentuk Sedian</div></td>
        <td width="77" rowspan="2" bgcolor="#CCCCCC"><div align="center">Obat Yang dicurigai </div></td>
        <td height="23" colspan="4" bgcolor="#CCCCCC"><div align="center">Pemberian</div></td>
        <td width="167" rowspan="2" bgcolor="#CCCCCC"><div align="center">Indikasi Penggunaan </div></td>
      </tr>
      <tr>
        <td width="61" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="56" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="53" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="56" bgcolor="#CCCCCC">&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">Keterangan tambahan : </td>
    <td rowspan="12"><table width="218" height="208" border="0" style="border:1px solid #000000;">
      <tr>
        <td width="212">Medan, ________________ </td>
      </tr>
      <tr>
        <td><div align="center">Pelapor</div></td>
      </tr>
      <tr>
        <td height="112">&nbsp;</td>
      </tr>
      <tr>
        <td><div align="center">(______________________)</div></td>
      </tr>
      <tr>
        <td height="21"><div align="center">Nama &amp; Tanda Tangan </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4"><span class="style2">(misalnya kecepatan efek samping obat, reaksi setelah obat dihentikan, pengobatan yang diberikan untuk mengatasi E.S.O)</span> </td>
  </tr>
  <tr>
    <td colspan="4">________________________________________________________________</td>
  </tr>
  <tr>
    <td colspan="4">________________________________________________________________</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">Data Labolatorium : </td>
  </tr>
  <tr>
    <td colspan="4"><span class="style2">(Bila ada)</span> </td>
  </tr>
  <tr>
    <td colspan="4">________________________________________________________________</td>
  </tr>
  <tr>
    <td colspan="4">________________________________________________________________</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><input type="checkbox" name="checkbox7" value="checkbox" />
      Beri tanda centang (v) pada jawaban yang dipilih </td>
  </tr>
  <tr>
    <td colspan="4">*Diisi oleh bagian farmasi </td>
  </tr>
</table>
</body>
</html>
