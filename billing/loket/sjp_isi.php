<?php
include("../koneksi/konek.php");
//include("../sesi.php");
$user_id = $_REQUEST['userId'];
$hid_kunjungan_id = $_REQUEST['hid_kunjungan_id'];
$sql="SELECT
  DATE_FORMAT(k.tgl_sjp,'%d-%m-%Y')    tgl_sjp,
  DATE_FORMAT(k.tgl,'%d-%m-%Y')    tgl,
  DATE_FORMAT(ps.tgl_lahir,'%d-%m-%Y')    tgl_lahir,
  ps.no_rm,
  ps.nama,
  k.nama_peserta,
  k.status_penj,
  IF(ps.sex='L','Laki-laki','Perempuan')    gender,
  k.no_anggota,
  k.no_sjp,
  u.nama         AS unit,
  CONCAT(md.kode,' - ',md.nama)    diag,
  mkp.kode_ppk
FROM (SELECT *
      FROM b_kunjungan
      WHERE id = '$hid_kunjungan_id') k
  INNER JOIN b_ms_pasien ps
    ON k.pasien_id = ps.id
  INNER JOIN b_ms_unit u
    ON k.unit_id = u.id
  LEFT JOIN b_ms_diagnosa md
    ON k.diag_awal = md.id
  LEFT JOIN b_ms_kso_pasien mkp
    ON ps.id = mkp.pasien_id";
$kueri=mysql_query($sql);
$rows=mysql_fetch_array($kueri);
?>
<style>
body{
	margin:0;
}

.fontSJP{
	font-size:20px;
	font-family:Tahoma, Geneva, sans-serif;
	height:28px;
}
</style>
<table width="1600" cellpadding="0" cellspacing="0" style="padding-top:2px;padding-bottom:2px;">
  <tr>
    <td width="76" height="74">&nbsp;</td>
    <td width="358">&nbsp;</td>
    <td width="34">&nbsp;</td>
    <td width="81">&nbsp;</td>
    <td width="160">&nbsp;</td>
    <td width="85"></td>
    <td width="75" class="fontSJP" style="visibility:hidden">&nbsp;</td>
    <td width="652" class="fontSJP">&nbsp;</td>
    <td width="77">&nbsp;</td>
  </tr>
  <tr>
    <td width="76">&nbsp;</td>
    <td width="358">&nbsp;</td>
    <td width="34">&nbsp;</td>
    <td width="81">&nbsp;</td>
    <td width="160" align="center" class="fontSJP"><?=$namaRS?></td>
    <td width="85"></td>
    <td width="75" class="fontSJP">&nbsp;</td>
    <td width="652" class="fontSJP">&nbsp;&nbsp;<b><?php echo $rows['no_sjp']; ?></b></td>
    <td width="77">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td class="fontSJP">&nbsp;</td>
    <td height="20" class="fontSJP">&nbsp;&nbsp;<?php echo $rows['tgl_sjp']; ?></td>
    <td></td>
  </tr>
</table>
<table width="1600" cellpadding="0" cellspacing="0" style="padding-top:2px;padding-bottom:2px;">
  <tr>
    <td width="46" height="50"></td>
    <td width="28"></td>
    <td width="197"></td>
    <td width="230"></td>
    <td width="149"></td>
    <td width="37"></td>
    <td width="211"></td>
    <td width="174"></td>
    <td width="73"></td>
    <td width="135"></td>
    <td width="187" class="fontSJP">&nbsp;</td>
    <td width="131" class="fontSJP">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="fontSJP">&nbsp;</td>
    <td class="fontSJP">&nbsp;</td>
    <td colspan="2" class="fontSJP">&nbsp;&nbsp;<?php echo $rows['no_anggota']; ?></td>
    <td class="fontSJP">&nbsp;</td>
    <td class="fontSJP">&nbsp;</td>
    <td colspan="3" class="fontSJP">&nbsp;&nbsp;<?php echo $rows['unit']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td class="fontSJP">&nbsp;</td>
    <td class="fontSJP">&nbsp;</td>
    <td colspan="2" class="fontSJP">&nbsp;&nbsp;<?php echo $rows['nama']; ?></td>
    <td class="fontSJP">&nbsp;</td>
    <td class="fontSJP">&nbsp;</td>
    <td class="fontSJP">&nbsp;</td>
    <td colspan="2" class="fontSJP">&nbsp;&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td class="fontSJP">&nbsp;</td>
    <td class="fontSJP">&nbsp;</td>
    <td colspan="2" class="fontSJP">&nbsp;&nbsp;<?php echo $rows['tgl_lahir']; ?></td>
    <td></td>
    <td></td>
    <td class="fontSJP">&nbsp;</td>
    <td colspan="2" class="fontSJP">&nbsp;&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td class="fontSJP">&nbsp;</td>
    <td class="fontSJP">&nbsp;</td>
    <td colspan="2" class="fontSJP">&nbsp;&nbsp;<?php echo $rows['gender']; ?></td>
    <td class="fontSJP">&nbsp;</td>
    <td class="fontSJP">&nbsp;</td>
    <td colspan="3" class="fontSJP">&nbsp;&nbsp;</td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td class="fontSJP">&nbsp;</td>
    <td class="fontSJP">&nbsp;</td>
    <td height="20" colspan="2" class="fontSJP">&nbsp;&nbsp;<?php echo $rows['no_rm']; ?></td>
    <td class="fontSJP">&nbsp;</td>
    <td class="fontSJP">&nbsp;</td>
    <td colspan="3" class="fontSJP">&nbsp;&nbsp;</td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td class="fontSJP">&nbsp;</td>
    <td class="fontSJP">&nbsp;</td>
    <td colspan="2" class="fontSJP">&nbsp;&nbsp;<?php echo $rows['diag']; ?></td>
    <td></td>
    <td></td>
    <td></td>
    <td colspan="3" class="fontSJP">&nbsp;<?php echo date('d-m-Y'); ?></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td class="fontSJP">&nbsp;</td>
    <td colspan="2" class="fontSJP">&nbsp;&nbsp;</td>
    <td></td>
    <td align="center" class="fontSJP">&nbsp;</td>
    <td></td>
    <td></td>
    <td colspan="2" align="center" class="fontSJP">&nbsp;</td>
    <td></td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td colspan="3" rowspan="3" style="vertical-align:top">&nbsp;</td>
    <td></td>
    <td></td>
    <td align="center">&nbsp;</td>
    <td></td>
    <td></td>
    <td colspan="2" align="center">&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>
<table width="914">
	<tr>
    	<td height="20"></td>
    </tr>
	<tr id="trTombol">
    	<td width="906" align="center">
        <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
		<input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
        </td>
    </tr>
</table>
<script type="text/JavaScript">
    function cetak(tombol){
        tombol.style.visibility='collapse';
        if(tombol.style.visibility=='collapse'){
               window.print();
               window.close();
        }
    }
</script>