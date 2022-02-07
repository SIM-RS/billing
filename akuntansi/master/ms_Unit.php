<?php 
$edit=$_REQUEST['edit'];
//echo "edit = ".$edit;
?>
<html>
<head>
<title>Master Data Mata Anggaran</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/simkeu.css" type="text/css" />
</head>
<body>
<div align="center">
  <form name="form1" method="post" action="">
  <input name="idma" id="idma" type="hidden" value="">
<?php 
if ($edit!="false"){
?>
  <div id="input" style="display:block">
      <p class="jdltable">Setup Data Unit Pengguna </p>
    <table width="60%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
      <tr>
      <td width="33%">Kode Unit </td>
      <td width="2%">:</td>
      <td width="65%"><input name="kode_ma" type="text" id="kode_ma" size="12" maxlength="15"></td>
    </tr>
    <tr>
      <td>Nama Unit </td>
      <td>:</td>
      <td><textarea name="ma" cols="50" id="ma"></textarea></td>
    </tr>
    <!--tr>
      <td>Status Kegiatan</td>
      <td>:</td>
      <td><input name="status" type="checkbox" id="status" checked>
        Aktif</td>
    </tr-->
  </table>
  <p><BUTTON><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>&nbsp;&nbsp;<BUTTON type="reset"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
  </div>
  <p><br>
      <span class="jdltable">Daftar Unit Pengguna </span>
    <table width="75%" border="0" cellspacing="0" cellpadding="4">
      <tr class="headtable">
        <td width="5%" class="tblheaderkiri">No</td>
        <td width="17%" class="tblheader">Kode </td>
        <td width="78%" class="tblheader">Unit Pengguna</td>
        <td class="tblheader" colspan="2">Proses</td>
      </tr>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri">1</td>
        <td height="17" width="95"><div align="left">00</div></td>
        <td width="171"><div align="left">FAKULTAS</div></td>
        <td width="30" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';fSetValue(window,'idma*-*3*|*kode_ma*-*51*|*ma*-*BELANJA PEGAWAI');"></td>
        <td width="30" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data ?')){}"></td>
      </tr>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri">2</td>
        <td height="17"><div align="left">001</div></td>
        <td><div align="left">FMIPA</div></td>
        <td class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';fSetValue(window,'idma*-*3*|*kode_ma*-*511111*|*ma*-*Belanja Gaji Pokok PNS');"></td>
        <td class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data ?')){}"></td>
      </tr>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri">3</td>
        <td height="17"><div align="left">00101</div></td>
        <td><div align="left">FMIPA REGULER</div></td>
        <td class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';fSetValue(window,'idma*-*3*|*kode_ma*-*511125*|*ma*-*Belanja Tunjangan PPh PNS');"></td>
        <td class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data ?')){}"></td>
      </tr>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri">4</td>
        <td height="17"><div align="left">0010101</div></td>
        <td><div align="left">FMIPA REGULER S1</div></td>
        <td class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';fSetValue(window,'idma*-*3*|*kode_ma*-*511126*|*ma*-*Belanja Tunjangan Beras PNS');"></td>
        <td class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data ?')){}"></td>
      </tr>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri">5</td>
        <td height="17"><div align="left">0010102</div></td>
        <td><div align="left">FMIPA REGULER D3</div></td>
        <td class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';fSetValue(window,'idma*-*3*|*kode_ma*-*xxxxxx*|*ma*-*Rekening BNI an Rektor');"></td>
        <td class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data ?')){}"></td>
      </tr>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri">6</td>
        <td height="17"><div align="left">00102</div></td>
        <td><div align="left">FMIPA EKSTENSI</div></td>
        <td class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';fSetValue(window,'idma*-*3*|*kode_ma*-*xxxxxy*|*ma*-*Rekening PR2');"></td>
        <td class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data ?')){}"></td>
      </tr>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'">
        <td class="tdisikiri">7</td>
        <td height="17"><div align="left">00103</div></td>
        <td><div align="left">FMIPA PASCA</div></td>
        <td class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';fSetValue(window,'idma*-*3*|*kode_ma*-*xxxxxu*|*ma*-*Rekening FTSP');"></td>
        <td class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data ?')){}"></td>
      </tr>
    </table>
    </p>
    <?php 
}else{
?>
<p><br>
      <span class="jdltable">Daftar Unit Pengguna </span>
    <table width="75%" border="0" cellspacing="0" cellpadding="4">
      <tr class="headtable"> 
        <td width="5%" class="tblheaderkiri">No</td>
        <td width="17%" class="tblheader">Kode </td>
        <td width="78%" class="tblheader">Unit Pengguna </td>
      </tr>
      <tr class="itemtable" style="cursor:pointer;" title="Klik Untuk Memilih Mata Anggaran" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'" onClick="fSetValue(window.opener,'idma*-*3*|*kode_ma*-*51');window.close();">
        <td class="tdisikiri">1</td>
        <td height="17" width="17%"><div align="left">00</div></td>
        <td width="78%"><div align="left">FAKULTAS</div></td>
      </tr>
      <tr class="itemtable" style="cursor:pointer;" title="Klik Untuk Memilih Mata Anggaran"  onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'" onClick="fSetValue(window.opener,'idma*-*3*|*kode_ma*-*511111');window.close();">
        <td class="tdisikiri">2</td>
        <td height="17"><div align="left">001</div></td>
        <td><div align="left">FMIPA</div></td>
      </tr>
      <tr class="itemtable" style="cursor:pointer;" title="Klik Untuk Memilih Mata Anggaran"  onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'" onClick="fSetValue(window.opener,'idma*-*3*|*kode_ma*-*511125');window.close();">
        <td class="tdisikiri">3</td>
        <td height="17"><div align="left">00101</div></td>
        <td><div align="left">FMIPA REGULER</div></td>
      </tr>
      <tr class="itemtable" style="cursor:pointer;" title="Klik Untuk Memilih Mata Anggaran"  onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'" onClick="fSetValue(window.opener,'idma*-*3*|*kode_ma*-*511126');window.close();">
        <td class="tdisikiri">4</td>
        <td height="17"><div align="left">0010101</div></td>
        <td><div align="left">FMIPA REGULER S1</div></td>
      </tr>
      <tr class="itemtable" style="cursor:pointer;" title="Klik Untuk Memilih Mata Anggaran"  onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'" onClick="fSetValue(window.opener,'idma*-*3*|*kode_ma*-*xxxxxx');window.close();">
        <td class="tdisikiri">5</td>
        <td height="17"><div align="left">0010102</div></td>
        <td><div align="left">FMIPA REGULER D3</div></td>
      </tr>
      <tr class="itemtable" style="cursor:pointer;" title="Klik Untuk Memilih Mata Anggaran"  onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'" onClick="fSetValue(window.opener,'idma*-*3*|*kode_ma*-*xxxxxy');window.close();">
        <td class="tdisikiri">6</td>
        <td height="17"><div align="left">00102</div></td>
        <td><div align="left">FMIPA EKSTENSI</div></td>
      </tr>
      <tr class="itemtable" style="cursor:pointer;" title="Klik Untuk Memilih Mata Anggaran"  onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'" onClick="fSetValue(window.opener,'idma*-*3*|*kode_ma*-*xxxxxu');window.close();">
        <td class="tdisikiri">7</td>
        <td height="17"><div align="left">00103</div></td>
        <td><div align="left">FMIPA PASCA</div></td>
      </tr>
    </table>
  </p>
<?php 
}
?>
</form>
</div>
</body>
</html>
