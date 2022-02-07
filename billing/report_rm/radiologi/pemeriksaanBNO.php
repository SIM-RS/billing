<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PEMERIKSAAN BNO / IVP</title>
<style type="text/css">
<!--
.style1 {font-size: 18px}
-->
</style>
</head>
<?
include("../../koneksi/konek.php");
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUser'];
$idx=$_REQUEST['id'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));
$dG=mysql_fetch_array(mysql_query("select *,DATE_FORMAT(tgl_datang ,'%d %M %Y') AS tgl_prt, DATE_FORMAT(tgl_datang,'%W') AS hari from b_ms_periksa_bno where id='$_REQUEST[id]'"));
?>
<body>
<table width="775" border="0" cellpadding="4" style="font:12px tahoma;">
  <tr>
    <td colspan="3" align="center" style="font-weight:bold
    ">FORMULIR PERJANJIAN<br/>PEMERIKSAAN BNO / IVP</td>
    </tr>
  <tr>
    <td colspan="3" style="font-weight:bold
    ">BAGIAN RADIOLOGI</td>
  </tr>
  <tr>
    <td width="235" align="left">Nama Pasien</td>
    <td width="401">:&nbsp;<?=$dP['nama']?></td>
    <td width="107">&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">Harap datang di Bagian Radiologi Pada,</td>
  </tr>
  <tr>
    <td>Hari / Tanggal</td>
    <td>:&nbsp;<?=getHari($dG['hari']).", ".tgl_ina($dG['tgl_datang']);?> </td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>Jam</td>
    <td>:&nbsp;<?=$dG['jam_datang']?></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">Untuk Pemeriksaan BNO / IVP dengan persiapan sebagai berikut :</td>
  </tr>
  <tr>
    <td colspan="3"><ol>
      <li>Sehari sebelum pemeriksaan dilakukan pasien dianjurkan makan makanan lunak yang mudah dicerna seperti : bubur + kecap + abon atau buah-buahan. Sebaiknya makanan yang berserat seperti : daging, sayuran dilunakkan.</li>
      <li>Jam 
        <?=$dG['jam_siap1']?> 
WIB makan terakhir.</li>
      <li>Jam 
        <?=$dG['jam_siap2']?> 
WIB makan terakhir/minum dulkolax 6 tablet atau garam inggris 30 gram.</li>
        <li>Jam 
          <?=$dG['jam_siap3']?> 
WIB minum terakhir, selanjutnya puasa sampai pemeriksaan dilaksanakan.</li>
    <li>Jam 
        <?=$dG['jam_siap4']?> 
pasien datang ke Bagian Radiologi RS PELINDO I (dalam keadaan puasa, dan dianjurkan selama berpuasa tidak banyak bicara / tidak merokok).</li>
       </ol></td>
  </tr>
  <tr>
    <td colspan="3" align="right">Medan, <?=tgl_ina(date('Y-m-d'))?></td>
  </tr>
  <tr>
    <td colspan="3" align="right">Petugas Radiologi,</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
	<td colspan="2" align="right">&nbsp;</td>
    <td align="center">&nbsp;<?= $usr['nama'];?></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr id="trTombol">
    <td colspan="3" align="center"><input type="button" name="cetak" id="cetak" value="Cetak" onclick="cetak(document.getElementById('trTombol'));" /></td>
  </tr>
</table>
</body>
</html>
<script>
    function cetak(tombol){
        tombol.style.visibility='collapse';
        if(tombol.style.visibility=='collapse'){
            if(confirm('Anda yakin mau mencetak ?')){
                setTimeout('window.print()','1000');
                setTimeout('window.close()','2000');
            }
            else{
                tombol.style.visibility='visible';
            }

        }
    }

</script>
