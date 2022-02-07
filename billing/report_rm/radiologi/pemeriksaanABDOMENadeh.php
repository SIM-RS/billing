<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>FORM PEMERIKSAAN CT SCAN ABDOMEN</title>
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
$dG=mysql_fetch_array(mysql_query("select a.*, DATE_FORMAT(a.tgl_datang, '%W') hari, DATE_FORMAT(a.tgl_datang, '%d %M %Y') tgltok from b_ms_periksa_abdomen a where a.id='$_REQUEST[id]'"));
?>
<body>
<table width="639" border="0" cellpadding="4" style="font:12px tahoma;">
  <tr>
    <td colspan="3" align="center" style="font-weight:bold
    ">FORMULIR PERJANJIAN<br/>PEMERIKSAAN CT SCAN ABDOMEN</td>
    </tr>
  <tr>
    <td colspan="3" style="font-weight:bold
    ">BAGIAN RADIOLOGI</td>
  </tr>
  <tr>
    <td width="234" align="left">Nama Pasien</td>
    <td width="13">:</td>
    <td width="360"><?=$dP['nama']?>&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">Harap datang di Bagian Radiologi Pada,</td>
  </tr>
  <tr>
    <td>Hari / Tanggal</td>
    <td>:</td>
    <td><label for="txtTgl"></label>
    <?=getHari($dG['hari']).", ".$dG['tgltok']?></td>
  </tr>
  
  <tr>
    <td>Jam</td>
    <td>:</td>
    <td><label for="txtJam"></label>
    <?=$dG['jam_datang']?></td>
  </tr>
  
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">Untuk pemeriksaan CT SCAN ABDOMEN:</td>
  </tr>
  <tr>
    <td colspan="3"><ol>
      <li>Pasien puasa 6 jam sebelum pemeriksaan.</li>
      <li>Pasien Harap mengambil bahan kontras barium (barium khusus CT SCAN)</li>
      <li> Cara pemberian
         
         bahan kontras tersebut sebagai berikut :
        <ol type="A">
          <li>Minum sebanyak 150 cc pada jam : 
            <?=$dG['jam_siap1']?>
          </li>
          <li>Minum sebanyak 150 cc pada jam : 
            <?=$dG['jam_siap2']?>
          </li>
         <li>Minum sebanyak 150 cc pada jam : 
           <?=$dG['jam_siap3']?>
         </li>
          <li>Kocok dahulu bahan kontras barium sebelum minum</li>
         </ol>
        </li>
     
       
     
    </ol></td>
  </tr>
  <tr>
    <td colspan="3" align="left">NB : Untuk pasien rawat inap mohon pasang VIGO No. 18 dan Three Way Buntut</td>
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
    <td align="right">&nbsp;<strong>(<u><?= $usr['nama'];?></u>)</strong></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr id="trTombol">
    <td colspan="3" align="center"><input type="submit" name="button" id="button" value="Cetak" onclick="cetak(document.getElementById('trTombol'));" />
   									<input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/></td>
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