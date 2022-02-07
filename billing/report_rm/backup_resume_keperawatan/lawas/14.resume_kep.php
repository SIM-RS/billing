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
$sqlP="SELECT * FROM b_fom_resume_keperawatan
WHERE id='$_REQUEST[id]'";
$dP=mysql_fetch_array(mysql_query($sqlP));
$usr=mysql_fetch_array(mysql_query("select * from b_fom_resume_kep_terapi_pulang where resume_kep_id='$_REQUEST[id]'"));
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
<title>resume kep</title>
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
<table width="755" border="0" cellpadding="4" style="font:12px tahoma; border:1px solid #000 ;">
  <tr>
    <td width="185">&nbsp;</td>
    <td width="4">&nbsp;</td>
    <td width="158">&nbsp;</td>
    <td colspan="2" rowspan="5" align="right"><table width="383" border="0" cellpadding="4" style="border:1px solid #000000;">
      <tr>
        <td width="110">Nama Pasien </td>
        <td width="7">:</td>
        <td width="232"><?=$nama;?> (<?=$sex;?>)</td>
      </tr>
      <tr>
        <td>Tanggal Lahir </td>
        <td>:</td>
        <td><?=$tgl;?> /Usia : <?=$umur;?> th </td>
      </tr>
      <tr>
        <td>No. RM </td>
        <td>:</td>
        <td><?=$noRM;?> No. Registrasi :________ </td>
      </tr>
      <tr>
        <td>Ruang Rawat/Kelas </td>
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
    <td>&nbsp;</td>
    <td width="4">&nbsp;</td>
    <td width="158">&nbsp;</td>
  </tr>
  <tr>
    <td height="28">&nbsp;</td>
    <td width="4">&nbsp;</td>
    <td width="158">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="158" height="32">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" rowspan="2">RESUME KEPERAWATAN<br/>SUMMARY LETTER<br/>DIISI OLEH PERAWAT / BIDAN</td>
  </tr>
  <tr>
    <td width="204">&nbsp;</td>
    <td width="246">&nbsp;</td>
  </tr>
  <tr>
    <td>Keadaan saat pulang</td>
    <td>:</td>
    <td colspan="3">
    <table>
    <tr>
    <td width="223">
    Tekanan darah 
    <?=$dP['tekanan_darah']?>
    mmHg </td>
    <td width="173">
    Pernafasan 
    <?=$dP['pernafasan']?>
    X/menit
    </td>
    <td width="133">
    Nadi 
    <?=$dP['nadi']?>
    X/menit
    </td>
    <td width="74">
    Suhu 
    <?=$dP['suhu']?>
    &deg;C
    </td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td>Diet / Nutrisi</td>
    <td>:</td>
    <td colspan="3">
    <table width="625">
    <tr>
    <td width="77">
    <input type="checkbox" name="checkbox" value="checkbox" <? if ($dP['nutrisi']=='1') { echo "checked='checked'";}?> />Oral
    </td>
    <td width="141">
    <input type="checkbox" name="checkbox2" value="checkbox" <? if ($dP['nutrisi']=='2') { echo "checked='checked'";}?> />NGT
    </td>
    <td width="264">
    <input type="checkbox" name="checkbox9" value="checkbox" <? if ($dP['nutrisi']=='3') { echo "checked='checked'";}?> />    
    Diet Khusus, Jelaskan
    <?=$dP['_diet']?></td>
    <td width="123">
    <input type="checkbox" name="checkbox12" value="checkbox" <? if ($dP['nutrisi']=='4') { echo "checked='checked'";}?> />
    Batas cairan
    <?=$dP['_batas']?></td>
    </tr>
     </table>
</td>
  </tr>
  <tr>
    <td>B.A.B.</td>
    <td>:</td>
    <td colspan="3">
    <table width="625">
    <tr>
    <td width="77"><input type="checkbox" name="checkbox3" value="checkbox" <? if ($dP['bab']=='1') { echo "checked='checked'";}?> />Normal
    </td>
    <td width="152"><input type="checkbox" name="checkbox4" value="checkbox" <? if ($dP['bab']=='2') { echo "checked='checked'";}?> />Ileostomy/coloctomy
    </td>
    <td width="169"><input type="checkbox" name="checkbox5" value="checkbox" <? if ($dP['bab']=='3') { echo "checked='checked'";}?> />Inkontinensia Urine
    </td>
    <td width="207"><input type="checkbox" name="checkbox11" value="checkbox" <? if ($dP['bab']=='4') { echo "checked='checked'";}?> />Inkontinensia Alvi
    </td>
    </tr>
    </table>
</td>
  </tr>
  <tr>
    <td>B.A.K.</td>
    <td>:</td>
    <td colspan="3">
    <table width="626">
    <tr>
    <td width="76">
    <input type="checkbox" name="checkbox8" value="checkbox" <? if ($dP['bak']=='1') { echo "checked='checked'";}?> />Normal
    </td>
    <td width="538">
    <input type="checkbox" name="checkbox10" value="checkbox" <? if ($dP['bak']=='2') { echo "checked='checked'";}?> />
    Katerer, tgl pemasangan terakhir
    <?=$dP['_tgl']?></td>
    </tr>
    </table>
</td>
  </tr>
  <tr>
    <td>DIISI OLEH BIDAN</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Kontraksi Uterus</td>
    <td>&nbsp;</td>
    <td colspan="3">
    <table width="626">
    <tr>
    <td width="76">
    <input type="checkbox" name="checkbox6" value="checkbox" <? if ($dP['kontraksi']=='1') { echo "checked='checked'";}?> />Tidak
    </td>
    <td width="97">
    <input type="checkbox" name="checkbox62" value="checkbox" <? if ($dP['kontraksi']=='2') { echo "checked='checked'";}?> />Baik
    </td>
    <td width="437">
    Tinggi Fundus Uteri
      <?=$dP['_tinggi']?></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td>Vulva</td>
    <td>&nbsp;</td>
    <td colspan="3">
    <table width="628">
    <tr>
    <td width="76">
    <input type="checkbox" name="checkbox64" value="checkbox" <? if ($dP['vulva']=='1') { echo "checked='checked'";}?> />Bersih
    </td>
    <td width="91">
    <input type="checkbox" name="checkbox65" value="checkbox" <? if ($dP['vulva']=='2') { echo "checked='checked'";}?>/>Kotor
    </td>
    <td width="85">
    <input type="checkbox" name="checkbox66" value="checkbox" <? if ($dP['vulva']=='3') { echo "checked='checked'";}?>/>Bengkak
    </td>
    <td width="129">
    <input type="checkbox" name="checkbox15" value="checkbox" <? if ($dP['vulva']=='4') { echo "checked='checked'";}?>/>Luka perineum
    </td>
    <td width="108">
    <input type="checkbox" name="checkbox16" value="checkbox" <? if ($dP['vulva']=='5') { echo "checked='checked'";}?>/>Kering
    </td>
    <td width="109">
    <input type="checkbox" name="checkbox17" value="checkbox" <? if ($dP['vulva']=='6') { echo "checked='checked'";}?>/>Basah
    </td>
    </tr>
    </table>
</td>
  </tr>
  <tr>
    <td>Lochea</td>
    <td>&nbsp;</td>
    <td colspan="3">
    <table>
    <tr>
    <td width="77">
    <input type="checkbox" name="checkbox13" value="checkbox" <? if ($dP['lochea']=='1') { echo "checked='checked'";}?>/>Banyak
    </td>
    <td width="111">
    <input type="checkbox" name="checkbox14" value="checkbox" <? if ($dP['lochea']=='2') { echo "checked='checked'";}?>/>Sedikit
    </td>
    <td width="213">
    Warna :
      <?=$dP['_warna']?></td>
    <td width="205">
    Bau :
      <?=$dP['_bau']?></td>
    </tr>
    </table>
</td>
  </tr>
  <tr>
    <td colspan="5">_______________________________________________________________________________________________________________________</td>
  </tr>
  <tr>
    <td>Luka-luka Operasi</td>
    <td>:</td>
    <td colspan="3">
    <table>
    <tr>
    <td width="86">
    <input type="checkbox" name="checkbox67" value="checkbox" <? if ($dP['luka']=='1') { echo "checked='checked'";}?> />Bersih
    </td>
    <td width="141">
    <input type="checkbox" name="checkbox69" value="checkbox" <? if ($dP['luka']=='2') { echo "checked='checked'";}?> />Kering
    </td>
    <td width="385">
    <input type="checkbox" name="checkbox611" value="checkbox" <? if ($dP['luka']=='3') { echo "checked='checked'";}?> />
    Ada cairan dari lika, jelaskan
    <?=$dP['_cairan']?></td>
    </tr>
    </table>
     </td>
  </tr>
  <tr>
    <td>Transfer &amp; Mobilisasi</td>
    <td>:</td>
    <td colspan="3">
    <table>
    <tr>
    <td width="85">
    <input type="checkbox" name="checkbox68" value="checkbox" <? if ($dP['transfer']=='1') { echo "checked='checked'";}?> />Mandiri
    </td>
    <td width="142">
    <input type="checkbox" name="checkbox610" value="checkbox" <? if ($dP['transfer']=='2') { echo "checked='checked'";}?> />Dibantu sebagian
    </td>
    <td width="384">
    <input type="checkbox" name="checkbox612" value="checkbox" <? if ($dP['transfer']=='3') { echo "checked='checked'";}?> />Dibantu penuh
    </td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td>Alat bantu</td>
    <td>:</td>
    <td colspan="3">
    <table>
    <tr>
    <td width="85">
    <input type="checkbox" name="checkbox18" value="checkbox" <? if ($dP['alat']=='1') { echo "checked='checked'";}?>/>Tongkat
    </td>
    <td width="142">
    <input type="checkbox" name="checkbox19" value="checkbox" <? if ($dP['alat']=='2') { echo "checked='checked'";}?>/>Kursi Roda
    </td>
    <td width="174">
    <input type="checkbox" name="checkbox20" value="checkbox" <? if ($dP['alat']=='3') { echo "checked='checked'";}?>/>Troley/Kereta Dorong
    </td>
    <td width="207">
    <input type="checkbox" name="checkbox21" value="checkbox" <? if ($dP['alat']=='4') { echo "checked='checked'";}?>/>    
    Lain-lain
    <?=$dP['_lain']?></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">EDUKASI/ PENYULUHAN KESEHATAN YANG SUDAH DIBERIKAN<?php $edukasi=explode(",",$dP["edukasi"]);?> </td>
  </tr>
  <tr>
    <td colspan="5">
    <table>
    <tr><td width="15"></td>
    <td width="189"><input type="checkbox" name="checkbox682" value="checkbox" <? if($edukasi[0]=='Penyakit dan pengobatan') { echo "checked='checked'";}?>/>
      Penyakit dan pengobatan    
    </td>
    <td width="189"><input type="checkbox" name="checkbox682" value="checkbox" <? if($edukasi[1]=='Perawatan dirumah') { echo "checked='checked'";}?> />
      Perawatan dirumah    
    </td>
    <td width="194"><input type="checkbox" name="checkbox682" value="checkbox" <? if($edukasi[2]=='Perawatan ibu dan bayi') { echo "checked='checked'";}?>/>
      Perawatan ibu dan bayi
    </td>
    <td width="226"><input type="checkbox" name="checkbox682" value="checkbox" <? if($edukasi[3]=='Mengatasi Nyeri') { echo "checked='checked'";}?>/>
      Mengatasi Nyeri
    </td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">
    <table>
    <tr><td width="14"></td>
    <td width="191"><input type="checkbox" name="checkbox682" value="checkbox" <? if($edukasi[4]=='Perawatan Luka') { echo "checked='checked'";}?>/>
      Perawatan Luka
    </td>
    <td width="389"><input type="checkbox" name="checkbox682" value="checkbox" <? if($edukasi[5]=='Persiapan lingkungan dan fasilitas untuk perawatan di rumah') { echo "checked='checked'";}?>/>
      Persiapan lingkungan dan fasilitas untuk perawatan di rumah
    </td>
    <td width="223"><input type="checkbox" name="checkbox682" value="checkbox" <? if($edukasi[6]=='Nasehat Keluarga Berencana') { echo "checked='checked'";}?>/>
      Nasehat Keluarga Berencana
    </td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">DIAGNOSA KEPERAWATAN SELAMA DIRAWAT</td>
  </tr>
  <tr>
    <td colspan="5">
    <table>
    <tr>
    <td width="418">
    1.
      <?=$dP['diagnosa1']?></td>
    <td width="407">
    2.
      <?=$dP['diagnosa2']?></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">ANJURAN</td>
  </tr>
  <tr>
    <td colspan="5">
    <table>
    <tr>
    <td width="412">
    1.
      <?=$dP['anjuran1']?></td>
    <td width="413">
    3.
      <?=$dP['anjuran3']?></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">
    <table>
    <tr>
    <td width="412">
    2.
    <?=$dP['anjuran2']?></td>
    <td width="413">
    4.
    <?=$dP['anjuran4']?></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">BARANG DAN HASIL PEMERIKSAAN YANG DISERAHKAN KEPADA KELUARGA</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">
    <table>
    <tr>
    <td width="27">1</td>
    <td width="153">Hasil Lab</td>
    <td width="9">:</td>
    <td width="100"><?=$dP['lab']?> 
      Lembar</td>
    <td width="26">5</td>
    <td width="150">Surat Asuransi</td>
    <td width="12">:</td>
    <td width="117"><?=$dP['surat_a']?></td>
    <td width="206">Hasil Pemeriksaan diluar RS</td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">
    <table>
    <tr>
    <td width="30">&nbsp;</td>
    <td width="150">Foto Rontgen</td>
    <td width="11">:</td>
    <td width="105"><?=$dP['foto']?>
      Lembar</td>
    <td width="19">&nbsp;</td>
    <td width="149">Summary pasien pulang</td>
    <td width="13">:</td>
    <td width="119"><?=$dP['summary']?></td>
    <td width="204">1.
      <?=$dP['hasil1']?></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">
    <table>
    <tr>
    <td width="31">&nbsp;</td>
    <td width="149">CT Scan</td>
    <td width="10">:</td>
    <td width="106"><?=$dP['scan']?>
      Lembar</td>
    <td width="20">&nbsp;</td>
    <td width="148">Buku Bayi</td>
    <td width="13">:</td>
    <td width="120"><?=$dP['buku']?></td>
    <td width="203">2.
      <?=$dP['hasil2']?></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">
    <table>
    <tr>
    <td width="31">&nbsp;</td>
    <td width="149">MRI/MRA</td>
    <td width="9">:</td>
    <td width="107"><?=$dP['mri']?>
      Lembar</td>
    <td width="19">&nbsp;</td>
    <td width="150">Kartu Golongan Darah Bayi</td>
    <td width="12">:</td>
    <td width="120"><?=$dP['kartu']?></td>
    <td width="203">3.
      <?=$dP['hasil3']?></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">
    <table>
    <tr>
    <td width="29">&nbsp;</td>
    <td width="151">Hasil USG</td>
    <td width="9">:</td>
    <td width="107"><?=$dP['usg']?>
      Lembar</td>
    <td width="18">&nbsp;</td>
    <td width="151">Surat keterangan Lahir</td>
    <td width="12">:</td>
    <td width="119"><?=$dP['skl']?></td>
    <td width="204">4.
      <?=$dP['hasil4']?></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">
    <table>
    <tr>
    <td width="27">&nbsp;</td>
    <td width="155">Surat Keterangan Sakit</td>
    <td width="9">:</td>
    <td width="89"><?=$dP['surat']?></td>
    <td width="37">&nbsp;</td>
    <td width="148">Bayi diserahkan oleh</td>
    <td width="12">:</td>
    <td width="119"><?=$dP['serah']?></td>
    <td width="204">5.
      <?=$dP['hasil5']?></td>
    </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td colspan="5">
    <table>
    <tr>
    <td width="5">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td width="5">&nbsp;</td>
    <td width="297">&nbsp;</td>
    <td width="149">Lain-lain</td>
    <td width="11">:</td>
    <td width="122"><?=$dP['lain']?></td>
    <td width="201">&nbsp;</td>
    </tr>
    </table>
    </td>
  </tr>
  
  <tr>
    <td>TERAPI PULANG</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="5"><table width="100%" border="1" bordercolor="#000000" style="border-collapse:collapse;">
      <tr>
        <td width="22" rowspan="2" bgcolor="#CCCCCC">No</td>
        <td width="144" rowspan="2" bgcolor="#CCCCCC"><div align="center">Nama Obat </div></td>
        <td width="87" rowspan="2" bgcolor="#CCCCCC"><div align="center">Jumlah</div></td>
        <td width="85" rowspan="2" bgcolor="#CCCCCC"><div align="center">Dosis</div></td>
        <td width="93" rowspan="2" bgcolor="#CCCCCC"><div align="center">Frekuensi</div></td>
        <td width="96" rowspan="2" bgcolor="#CCCCCC"><div align="center">Cara Pemberian</div></td>
        <td height="23" colspan="6" bgcolor="#CCCCCC"><div align="center">Jam Pemberian</div></td>
        <td width="168" rowspan="2" bgcolor="#CCCCCC"><div align="center">Petunjuk khusus</div></td>
      </tr>
      <tr>
        <td width="55" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="55" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="55" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="55" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="55" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="55" bgcolor="#CCCCCC">&nbsp;</td>
        </tr>
        <?php 
		$sqD=mysql_query("select * from b_fom_resume_kep_terapi_pulang where resume_kep_id ='$dP[id]'");
		$no=1;
		while($dGD=mysql_fetch_array($sqD)){
		$txt_jam=explode('|',$dGD['jam_pemberian']);
		?>
      <tr>
        <td align="center"><?=$no?></td>
        <td><?=$dGD['nama_obat']?></td>
        <td align="center"><?=$dGD['jml']?></td>
        <td><?=$dGD['dosis']?></td>
        <td><?=$dGD['frekuensi']?></td>
        <td><?=$dGD['cara_beri']?></td>
        <td align="center"><?=$txt_jam[0]?></td>
        <td align="center"><?=$txt_jam[1]?></td>
        <td align="center"><?=$txt_jam[2]?></td>
        <td align="center"><?=$txt_jam[3]?></td>
        <td align="center"><?=$txt_jam[4]?></td>
        <td align="center"><?=$txt_jam[5]?></td>
        <td><?=$dGD['petunjuk']?></td>
      </tr>
      <?php $no++; }?>
    </table></td>
  </tr>
  <tr>
    <td>KONTROL KEMBALI TANGGAL</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">
    <table border="1" bordercolor="#000000" style="border-collapse:collapse;">
    <tr>
    <td width="20" bgcolor="#CCCCCC">No</td>
    <td width="93" bgcolor="#CCCCCC"><div align="center">Tanggal</div></td>
    <td width="80" bgcolor="#CCCCCC"><div align="center">Hari</div></td>
    <td width="76" bgcolor="#CCCCCC"><div align="center">Jam</div></td>
    <td width="194" bgcolor="#CCCCCC"><div align="center">Nama Dokter</div></td>
    </tr>
    <?php 
		$sqD2=mysql_query("select * from b_fom_resume_kep_kontrol where resume_kep_id ='$dP[id]'");
		$no=1;
		while($dGD2=mysql_fetch_array($sqD2)){
		//$txt_jam=explode('|',$dGD['jam_pemberian']);
		?>
    <tr>
      <td align="center"><?=$no?></td>
      <td><?=$dGD['tgl']?></td>
      <td><?=$dGD['hari']?></td>
      <td><?=$dGD['jam']?></td>
      <td><?=$dGD['dokter']?></td>
    </tr>
    <?php $no++; }?>
    </table>
    </td>
    <td></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td colspan="5">
      <table>
        <tr>
          <td width="65"></td>
          <td width="345">
            Perawat Yang Menyerahkan
          </td>
          <td width="362">
            Dokter yang merawat/ ruangan
          </td>
          <td width="225">
            Yang Menerima,
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td height="76" colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">
      <table>
        <tr>
          <td width="68"></td>
          <td width="353">
            Nama Jelas & tanda tangan
          </td>
          <td width="326"><?=$dokter;?></td>
          <td width="250">
            Nama Jelas & tanda tangan
          </td>
        </tr>
      </table>
    </td>
  </tr>
  
</table>
<tr>
    <td width="708" align="center">
	<button onclick="window.print()" type="button">Print</button>&nbsp;
	<button onclick="window.close()" type="button">Close</button>
	</td>
  </tr>
</body>
</html>
