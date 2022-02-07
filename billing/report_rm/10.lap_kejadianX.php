<?php
session_start();
include("../sesi.php");
include("../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUser'];
$id=$_REQUEST['id'];
//$sqlP = "select * from b_ms_pengawasan_khusus_bayi where id='$id' ";
//$usr=mysql_fetch_array(mysql_query("select nama from b_ms_pegawai where id='$idUser'"));
$sqlP="SELECT pn.*,ps.nama_ortu as nama2,pg.nama as nama3,ps.no_rm as norm,d.nama as unit,DATE_FORMAT(pn.tgl, '%d-%m-%Y') tgl, DATE_FORMAT(pn.jam, '%d-%m-%Y') jam, DATE_FORMAT(pn.jam, '%H:%i:%s') jam
FROM b_ms_laporan_kejadian pn
LEFT JOIN b_pelayanan p ON p.id=pn.pelayanan_id
LEFT JOIN b_ms_pasien ps ON ps.id=p.pasien_id
LEFT JOIN b_ms_pegawai pg ON pg.id=p.user_act
LEFT JOIN b_ms_unit d ON d.id=p.unit_id 
WHERE pn.id='$id';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUser'"));
{
/*$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));*/
?>
<?
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>LAPORAN KEJADIAN</title>
</head>
<?
include "setting.php";
?>
<body>
<table width="699" border="0" style="font:bold 12px tahoma;">
  <tr>
    <td colspan="3">Tim Keselamatan Pasien </td>
  </tr>
  <tr>
    <td width="379">RS PELINDO I </td>
    <td width="128">Unit / Ruangan </td>
    <td width="177">: <?=$kamar;?> Kelas <?=$kelas;?></td>
  </tr>
</table>
<br />
<table width="700" border="0" style="font:bold 12px tahoma;">
  <tr>
    <td width="694" align="center">RAHASIA, TIDAK BOLEH DIFOTOCOPY,DILAPORKAN 2 X 24 JAM</td>
  </tr>
</table>
<br />
<table width="700" border="0" style="font:bold 18px tahoma;">
  <tr>
    <td width="694" align="center">LAPORAN KEJADIAN </td>
  </tr>
</table>
<br />
<table width="700" border="0" style="font:12px tahoma;">
  <tr>
    <td width="31" align="center"><b>1</b></td>
    <td colspan="3"><b>Identitas Pasien</b></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="28">&nbsp;</td>
    <td width="136">&nbsp;</td>
    <td width="487">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Nama</td>
    <td>: <?=$nama;?> Umur : <?=$umur;?> Th &nbsp;&nbsp;Reg/RM : <?=$noRM;?> </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Jenis Kelamin</td>
    <td>: <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($sex=='L') { echo "checked='checked'";}?> /> 
      Laki-laki&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox"  <? if($sex=='P') { echo "checked='checked'";}?>/> 
      Perempuan</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Alamat</td>
    <td>:  <?=$alamat;?></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Tanggal Masuk RS </td>
    <td>: 
    <?=$tglawalKunj;?> Jam : <?=$jamawalKunj;?> </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Diagnosa Medis</td>
    <td>: 
    <?=$diag;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Dokter yang merawat </td>
    <td>: 
    <?=$dP['nama3']?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td align="center"><b>2</b></td>
    <td colspan="2"><b>Pokok Masalah (Kejadian)</b></td>
    <td>:  <?=$dP['pokok_masalah']?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>3</strong></td>
    <td colspan="2"><b>Kronologis Kejadian</b></td>
    <td>: </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top" colspan="3" style="border:1px solid #000000;" height="300"><?=$dP['kronologis']?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><b>4</b></td>
    <td colspan="2"><b>Jenis Kejadian</b></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if ($dP['jenis_kejadian']=='Kejadian Nyaris Cedera/KNC (Near Miss)') { echo "checked='checked'";}?> />
    Kejadian Nyaris Cedera/KNC (Near Miss)</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if ($dP['jenis_kejadian']=='Kejadian tidak diharapkan/ KTD (Adverse Event)') { echo "checked='checked'";}?> />
Kejadian tidak diharapkan/ KTD (Adverse Event)</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>5</strong></td>
    <td colspan="3"><b>Orang yang melaporkan kejadian</b></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if ($dP['pelapor']=='Pasien') { echo "checked='checked'";}?> />
      Pasien&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if ($dP['pelapor']=='Karyawan') { echo "checked='checked'";}?> /> 
      Karyawan
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if ($dP['pelapor']=='Pengunjung') { echo "checked='checked'";}?> /> 
Pengunjung
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if ($dP['pelapor']=='Pendamoing') { echo "checked='checked'";}?> /> 
Pendamoing
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>6</strong></td>
    <td colspan="3"><b>Kejadian mengenai</b></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if ($dP['pelapor']=='Pasien') { echo "checked='checked'";}?> />
Pasien&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if ($dP['kejadian_mengenai']=='Karyawan') { echo "checked='checked'";}?> />
Karyawan
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if ($dP['kejadian_mengenai']=='Pengunjung') { echo "checked='checked'";}?> />
Pengunjung
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if ($dP['kejadian_mengenai']=='Pendamoing') { echo "checked='checked'";}?> />
Pendamoing
&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>7</strong></td>
    <td colspan="3"><b>Tanggal dan waktu kejadian </b></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3"><strong>Tanggal :</strong> 
    <?=$dP['tgl']?> <strong>Waktu :</strong>    <?=$dP['jam']?></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>8</strong></td>
    <td colspan="2"><b>Tempat kejadian</b></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3"><strong>Unit kerja  :</strong> 
    <?=$dP['unit_kerja']?> <strong>Lokasi Kejadian:</strong>    <?=$dP['lokasi_kejadian']?></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>9</strong></td>
    <td colspan="2"><b>Akibat kejadian</b></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if ($dP['akibat_kejadian']=='Kematian') { echo "checked='checked'";}?>/>
Kematian&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input disabled="disabled" type="checkbox" name="checkbox2" value="checkbox" <? if ($dP['akibat_kejadian']=='Timbul Cidera') { echo "checked='checked'";}?>/> 
Timbul Cedera
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <? if ($dP['akibat_kejadian']=='Timbul Kecacatan') { echo "checked='checked'";}?>/>
Timbul Kecacatan</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if ($dP['akibat_kejadian']=='Perlu Perawatan RS') { echo "checked='checked'";}?>/>
Perlu Perawatan RS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if ($dP['akibat_kejadian']=='Perpanjang Perawatan') { echo "checked='checked'";}?>/>
Perpanjangan Perawatan &nbsp;&nbsp;
<input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if ($dP['akibat_kejadian']=='Lain-Lain') { echo "checked='checked'";}?>/>
Lain-Lain</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>10</strong></td>
    <td colspan="3"><b>Apakah kejadian yang sama pernah terjadi ditempat ini</b> </td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="2"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if ($dP['kejadian_sama']=='Tidak') { echo "checked='checked'";}?>/> 
      Tidak</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if ($dP['kejadian_sama']=='Ya') { echo "checked='checked'";}?> /> 
      Jika Ya, sudah berapa kali ? <?=$dP['jumlah_kejadian']?> Kali</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><strong>11</strong></td>
    <td colspan="3"><b>Tindakan yang dilakukan segera setelah kejadian dan hasilnya</b></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td valign="top" style="border:1px solid #000000;" height="100" colspan="3"><?=$dP['tindakan']?></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3">tindakan dilakukan oleh: <?=$dP['nama3']?> (Dokter umum, Spesialis, Perawat/Lainnya)</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3"><table width="572" border="1" bordercolor="#000000" style="border-collapse:collapse;">
      <tr>
        <td width="121" height="30">Penerima Laporan </td>
        <td width="163">:____________</td>
        <td width="103">Pengirim Laporan </td>
        <td width="157">: <?=$dP['nama3']?></td>
      </tr>
      <tr>
        <td height="30">Tanda Tangan </td>
        <td>:____________</td>
        <td>Tanda Tangan</td>
        <td>:_______________</td>
      </tr>
      <tr>
        <td height="30">Tanggal Menerima </td>
        <td>:____________</td>
        <td>Tanggal Melapor </td>
        <td>:_______________</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">*</td>
    <td colspan="3"><b>Grading Resiko Kejadian</b> </td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3"><input disabled="disabled" type="checkbox" name="checkbox237" value="checkbox" <? if ($dP['grading_resiko']=='Biru') { echo "checked='checked'";}?>/> 
      Biru
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input disabled="disabled" type="checkbox" name="checkbox2323" value="checkbox" <? if ($dP['grading_resiko']=='Hijau') { echo "checked='checked'";}?>/>
Hijau
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input disabled="disabled" type="checkbox" name="checkbox2333" value="checkbox" <? if ($dP['grading_resiko']=='Kuning') { echo "checked='checked'";}?>/>
Kuning
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input disabled="disabled" type="checkbox" name="checkbox2343" value="checkbox" <? if ($dP['grading_resiko']=='Merah') { echo "checked='checked'";}?>/>
Merah
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">*</td>
    <td colspan="3">Diisi oleh atasan pelapor</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    </tr><tr id="trTombol">
        <td class="noline" colspan="5" align="right">
          <div align="center">
            <input name="button" type="button" id="btnPrint" onclick="cetak(document.getElementById('trTombol'));" value="Print"/>
            <input name="button" type="button" id="btnTutup" onclick="window.close();" value="Tutup"/>
            </div></td></tr><tr>
        <td colspan="3">&nbsp;</td>
      </tr>
</table>
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
</html>
