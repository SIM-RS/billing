<?php
session_start();
include '../../koneksi/konek.php';
$idPel=$_REQUEST['idPel'];
$idKunj=$_REQUEST['idKunj'];
$idUser=$_REQUEST['idUser'];
$idPasien=$_REQUEST['idPasien'];
$id=$_REQUEST['id'];

if($_REQUEST['excel']=="yes"){
header("Content-type: application/vnd.ms-excel");
header("Content--Disposition:attachment; filename='hasilLab.xls'");
}
$que1="select *
from b_ms_pegawai
where id='$idUser'";
$usr=mysql_fetch_array(mysql_query($que1));
$que2="SELECT bp.nama as nama_pasien, lik.saksi, bmp.`nama`
FROM b_pelayanan p
INNER JOIN b_ms_pasien bp ON p.pasien_id = bp.id
LEFT JOIN `lap_inform_konsen` lik ON lik.`pelayanan_id`=p.`id`
LEFT JOIN `b_ms_pegawai` bmp ON bmp.`id` = p.`user_act`
WHERE p.id='$idPel'";
$usr2=mysql_fetch_array(mysql_query($que2));
$que3="SELECT saksi
FROM b_ms_latih_jantung
WHERE id='$id'";
$usr3=mysql_fetch_array(mysql_query($que3));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SURAT PERSETUJUAN</title>
</head>

<body>
<table cellspacing="0" cellpadding="0" style="border:1px solid #000000">
  <col width="36" />
  <col width="23" span="2" />
  <col width="64" span="7" />
  <col width="120" />
  
  <tr height="20">
    <td colspan="11" align="left" valign="top"><table cellpadding="0" cellspacing="0" style="border:outset #000000">
      <tr>
        
        <td><img src="b.png" width="360" height="62" /></td><td><img src="c.png" width="330" height="80" /></td>
      </tr>
  </table>  </tr>
  
  <tr height="20">
    <td height="20">&nbsp;</td>
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
  <tr height="20">
    <td height="20">&nbsp;</td>
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
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td colspan="10">Saya yang bertanda tangan di bawah    ini, memberikan ijin kepada dr. <strong><?php echo $usr['nama'];?></strong></td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td colspan="10">untuk    melakukan uji latih jantung berbeban atas diri saya, guna Penilaian Fungsi    dan Kapasitas jantung,</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td colspan="4">paru dan pembuluh darah</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td colspan="9">Saya telah memahami penjelasan yang    diberikan kepada saya sebagai berikut :</td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td>1.</td>
    <td colspan="8">Bahwa    saya akan berjalan/berlari/diinfus obat pada alat uji latih jantung ini    dengan kecepatan</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td colspan="8">derajat    kemiringan dari  lantai berpijak atau    beban yang semakin meningkat setiap 2-3 menit</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td colspan="8">sampai    pada batas yang telah ditargetkan, kelelahan, sesak napas, nyeri dada dan    gejala lainnya </td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td colspan="6">atau sampai dihentikan oleh petugas    (perawat atau dokter)</td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td>2.</td>
    <td colspan="8">Bahwa    resiko uji latih dapat berupa perubahan irama jantung, kemungkinan perubahan    tekanan </td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td colspan="8">darah    yang berlebihan yang dapat menyebabkan pingsan atau serangan jantung.</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td>3.</td>
    <td colspan="8">Bahwa    petugas akan melakukan upaya untuk meminimalkan kemungkinan di atas    dengan </td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td colspan="4">peralatan yang ada di rumah sakit.</td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td>4.</td>
    <td colspan="7">Bahwa tidak ada jaminan atau garansi    akan hasil dari uji latih ini.</td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td colspan="5">Medan, <?php echo tgl_ina(date("Y-m-d"));?></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td colspan="5">(<strong><u> <?php echo $usr2['nama_pasien'];?> </u></strong>)</td>
    <td></td>
    <?
	$saksi =explode('*|*',$usr2['saksi']);
	?>
    <td colspan="3">(<strong><u><?=$saksi[0]?></u></strong>)</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
    <td></td>
    <td colspan="5">Nama &amp; Tanda Tangan Pasien</td>
    <td></td>
    <td colspan="3">Nama &amp;    Tanda Tangan Saksi</td>
  </tr>
  <tr height="20">
    <td height="20">&nbsp;</td>
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
  <tr height="20">
    <td height="20"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="20">
    <td height="20"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="20">
    <td height="20"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="20">
    <td height="20"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="20">
    <td height="20"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="20">
    <td height="20"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr height="20">
    <td height="20" colspan="11" align="center"> (<strong><u> <?php echo $usr2['nama'];?></u></strong> )</td>
  </tr>
  <tr height="20">
    <td height="20" colspan="11"><div align="center">Nama &amp; Tanda Tangan Dokter</div></td>
  </tr>
  <tr height="20">
    <td height="20" colspan="11"></td>
  </tr>
  <tr id="trTombol">
        <td class="noline" align="center" colspan="11">
                    
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" />
              <input id="btnTutup" type="button" value="Tutup" onClick="tutup();"/>
                </td>
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
			
function liat(){
		window.open("surat_ket_periksa_mata_view.php?id=<?=$idx?>&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idUser=<?=$idUser?>","_blank");
	}
function tutup(){
	window.close();
	}
        </script>
</html>
