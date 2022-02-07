<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Check List Terima Pasien Inap</title>
</head>
<?
//include "setting.php";
?>
<style>
.gb{
	border-bottom:1px solid #000000;
}
</style>
<body>
<table width="824" border="0" style="font:12px tahoma;">
  <tr>
    <td width="818"><table width="496" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
      <tr>
        <td width="124">Nama Pasien</td>
        <td width="173">:
          <?=$nama;?></td>
        <td width="75">&nbsp;</td>
        <td width="104">&nbsp;</td>
      </tr>
      <tr>
        <td>Tanggal Lahir</td>
        <td>:
          <?=$tgl;?></td>
        <td>Usia</td>
        <td>:
          <?=$umur;?>
          Thn</td>
      </tr>
      <tr>
        <td>No. RM</td>
        <td>:
          <?=$noRM;?>        </td>
        <td>No Registrasi </td>
        <td>:____________</td>
      </tr>
      <tr>
        <td>Ruang Rawat/Kelas</td>
        <td>:
          <?=$kamar;?>
            <?=$kelas;?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>:
          <?=$alamat;?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">(Tempelkan Sticker Identitas Pasien)</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td style="font:bold 15px tahoma;">&nbsp;</td>
  </tr>
  <tr>
    <td style="font:bold 15px tahoma;">CHECK LIST PENERIMAAN PASIEN RAWAT INAP</td>
  </tr>
  <tr>
    <td><table cellspacing="0" cellpadding="2" style="border:1px solid #000000;">
      <col width="27" span="2" />
      <col width="20" />
      <col width="298" />
      <col width="20" />
      <col width="34" />
      <col width="58" />
      <col width="99" />
      <col width="13" />
      <col width="92" />
      <col width="49" />
      <col width="43" />
      <col width="70" />
      <col width="37" />
      <tr height="20">
        <td height="20" width="15" style="border-bottom:1px solid #000000;"><div align="center">No</div></td>
        <td colspan="10" style="border:1px solid #000000; border-top:0px; border-right:0px;"><div align="center">Kegiatan</div></td>
        <td colspan="3" style="border-bottom:1px solid #000000; border-left:1px solid #000000;">&nbsp;</td>
        </tr>
      <tr height="20">
        <td height="20" align="right">1</td>
        <td colspan="9">Pemberian informasi rawat inap</td>
        <td width="163"></td>
        <td width="2" style="border-left:1px solid #000000">&nbsp;</td>
        <td width="43"></td>
        <td width="40"></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td width="11">a.</td>
        <td colspan="8">Informasi tentang hak dan kewajiban    pasien</td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td style="border:1px solid #000000;">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="8">(lembar informasi hak dan kewajiban    pasien&nbsp; dapat dibaca pada masing-masing    ruangan pasien</td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>b.</td>
        <td colspan="8">Informasi tentang perawat yang    merawat hari ini&nbsp;</td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td style="border:1px solid #000000;">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="8">(Keterangan nama perawat yang    bertugas terletak pada dinding dekat tempat tidur pasien)</td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>c.</td>
        <td colspan="8">Informasi tentang catatan    perkembangan kondisi pasien, dan rencana asuhan keperawatan/ asuhan</td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td style="border:1px solid #000000;">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="8">Kebidanan</td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>d.</td>
        <td colspan="8">Informasi tentang waktu konsultasi</td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td style="border:1px solid #000000;">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>e.</td>
        <td colspan="8">Informasi tentang persiapan pasien    pulang</td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td style="border:1px solid #000000; border-top:0px;">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20" colspan="11" class="gb">&nbsp;</td>
        <td height="20" class="gb" style="border-left:1px solid #000000">&nbsp;</td>
        <td height="20" class="gb">&nbsp;</td>
        <td height="20" class="gb">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td width="340"></td>
        <td width="84"></td>
        <td width="1"></td>
        <td width="1"></td>
        <td width="1"></td>
        <td width="7"></td>
        <td width="13"></td>
        <td width="39"></td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20" align="right">2</td>
        <td colspan="3">Kegiatan rutin keperwatan :</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>-</td>
        <td colspan="8">Waktu pemberian obat sesuai jadwal</td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td style="border:1px solid #000000;">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>-</td>
        <td colspan="8">Check infus setiap 2 jam (bila    terpasang infus) sesuai dengan kondisi pasien</td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td style="border:1px solid #000000; border-top:0px;">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>-</td>
        <td colspan="8">Observasi tanda-tanda vital 3 x    sehari atau sesuai kondisi pasien</td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td style="border:1px solid #000000; border-top:0px;">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>-</td>
        <td colspan="8">Jadwal memandikan pasien 2 x sehari    jam 05.00 WIB dan Jam 16.00 WIB</td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td style="border:1px solid #000000; border-top:0px;">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>-</td>
        <td colspan="9">Jadwal ganti linen kelas 1,2,3, 3    kali seminggu (sarung bantal dan stick taken setiap hari) untuk VIP, VVIP</td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td style="border:1px solid #000000; border-top:0px;">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="8">dan President Suite diganti setiap    hari</td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20" colspan="11" class="gb">&nbsp;</td>
        <td height="20" class="gb" style="border-left:1px solid #000000">&nbsp;</td>
        <td height="20" class="gb">&nbsp;</td>
        <td height="20" class="gb">&nbsp;</td>
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
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20" align="right">3</td>
        <td colspan="9">Jadwal makan, Snack dan adanya menu    pilihan untuk kelas 1, VIP, VVIP dan President Suite</td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td style="border:1px solid #000000;">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20" colspan="11" class="gb">&nbsp;</td>
        <td height="20" class="gb" style="border-left:1px solid #000000">&nbsp;</td>
        <td height="20" class="gb">&nbsp;</td>
        <td height="20" class="gb">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="6"></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20" align="right">4</td>
        <td colspan="7">Tata tertib ruang rawat inap, antara    lain:</td>
        <td></td>
        <td></td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>-</td>
        <td colspan="6">Jam berkunjung keluarga :</td>
        <td></td>
        <td></td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td style="border:1px solid #000000;">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="6">Pagi : 11.00 - 13.00 WIB</td>
        <td></td>
        <td></td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="6">Sore : 18.00 - 20.00 WIB</td>
        <td></td>
        <td></td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>-</td>
        <td colspan="6">Selama dalam masa perawatan, pasien    harus menggunakan gelang identitas pasien</td>
        <td></td>
        <td></td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td style="border:1px solid #000000;">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>-</td>
        <td colspan="6">Dilarang merokok dilingkungan Rumah    Sakit</td>
        <td></td>
        <td></td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td style="border:1px solid #000000; border-top:0px;">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>-</td>
        <td colspan="6">Keluarga/penunggu pasien tidak    diperkenakan duduk diatas tempat tidur</td>
        <td></td>
        <td></td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td style="border:1px solid #000000; border-top:0px;">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>-</td>
        <td colspan="9">Tidak diperkenankan membawa dan    menyimpan barang berharga, alat elektronik, tikar, kasur, bantal dll</td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td style="border:1px solid #000000; border-top:0px;">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="6">(Resiko kehilangan ditanggung    pasien/keluarga)</td>
        <td></td>
        <td></td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>-</td>
        <td colspan="9">Setiap pasien mendapatkan kartu    penunggu (1 orang) kecuali VIP, VVIP, President Suite, khususnya&nbsp;</td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td style="border:1px solid #000000;">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td colspan="6">&nbsp;ruangan bayi dan perinatologi tidak    diperkenankanmenunggu didalam ruangan</td>
        <td></td>
        <td></td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" colspan="11" class="gb">&nbsp;</td>
        <td height="20" class="gb" style="border-left:1px solid #000000">&nbsp;</td>
        <td height="20" class="gb">&nbsp;</td>
        <td height="20" class="gb">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="5"></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20" align="right">5</td>
        <td colspan="10">Kegiatan rutin house keeping:    kebersihan ruangan (menyapu, mengepel, membuang sampah, mengantar koran)</td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td style="border:1px solid #000000;">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20" colspan="11" class="gb">&nbsp;</td>
        <td height="20" class="gb" style="border-left:1px solid #000000">&nbsp;</td>
        <td height="20" class="gb">&nbsp;</td>
        <td height="20" class="gb">&nbsp;</td>
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
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20" align="right">6</td>
        <td colspan="7">Mengorientasikan fasilitas ruangan    dan cara penggunaannya fasilitas kamar seperti:</td>
        <td></td>
        <td></td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>-</td>
        <td colspan="6">cara pemakaian tempat tidur, telepon    dan remote TV, lampu tidur, lemari pakaian</td>
        <td></td>
        <td></td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td style="border:1px solid #000000;">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>-</td>
        <td colspan="7">cara penggunaan bel pasien dan bel    keadaan darurat dikamar mandi dan kamar pasien</td>
        <td></td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td style="border:1px solid #000000; border-top:0px;">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>-</td>
        <td colspan="5">cara penggunaan shower dikamar mandi    (air panas dan dingin)</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td style="border:1px solid #000000; border-top:0px;">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20" colspan="11" class="gb">&nbsp;</td>
        <td height="20" class="gb" style="border-left:1px solid #000000">&nbsp;</td>
        <td height="20" class="gb">&nbsp;</td>
        <td height="20" class="gb">&nbsp;</td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3">Medan,</td>
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
        <td height="20">&nbsp;</td>
        <td colspan="3">Pasien/ keluarga,</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="4">Perawat yang memberikan informasi</td>
        <td></td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3">(&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;..&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;)</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="4">(&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;..&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;)</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3">Tanda tangan dan nama jelas</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="4">Tanda tangan dan nama jelas</td>
        <td></td>
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
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
