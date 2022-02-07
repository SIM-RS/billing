<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CHECK LIST PENGKAJIAN KEPERAWATAN</title>
</head>
<?
include "setting.php";
$dt=mysql_fetch_array(mysql_query("SELECT 
  a.*,
  DATE_FORMAT(a.`tgl_tiba`, '%d-%m-%Y') tgl_tiba2,
  DATE_FORMAT(a.`tgl_kaji`, '%d-%m-%Y') tgl_kaji2,
  DATE_FORMAT(a.tgl_cerebral, '%d-%m-%Y') tgl_cerebral2,
  DATE_FORMAT(a.tgl_gas, '%d-%m-%Y') tgl_gas2,
  DATE_FORMAT(a.tgl_jln_nafas, '%d-%m-%Y') tgl_jln_nafas2,
  DATE_FORMAT(a.tgl_termoregulasi, '%d-%m-%Y') tgl_termoregulasi2,
  DATE_FORMAT(a.tgl_keb_nutrisi, '%d-%m-%Y') tgl_keb_nutrisi2,
  DATE_FORMAT(a.tgl_vol_cairan, '%d-%m-%Y') tgl_vol_cairan2,
  DATE_FORMAT(a.tgl_eliminasi_u, '%d-%m-%Y') tgl_eliminasi_u2,
  DATE_FORMAT(a.tgl_eliminasi_a, '%d-%m-%Y') tgl_eliminasi_a2,
  DATE_FORMAT(a.tgl_mobilitas, '%d-%m-%Y') tgl_mobilitas2, 
  DATE_FORMAT(a.tgl_integritas, '%d-%m-%Y') tgl_integritas2,
  DATE_FORMAT(a.tgl_rawat_diri, '%d-%m-%Y') tgl_rawat_diri2,
  DATE_FORMAT(a.tgl_psikiatrik, '%d-%m-%Y') tgl_psikiatrik2,
  DATE_FORMAT(a.tgl_nyeri, '%d-%m-%Y') tgl_nyeri2
FROM
  b_fom_chk_perawat a
WHERE id = '$_GET[id]'"));
?>
<body>
<table width="1087" border="0" cellpadding="4" style="font:12px tahoma">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" rowspan="6"><table width="390" border="0" cellpadding="4" style="border:1px solid #000000;">
        <tr>
          <td width="102">Nama Pasien </td>
          <td width="5">:</td>
          <td width="249"> <?=$nama;?> (<?=$sex;?>)</td>
        </tr>
        <tr>
          <td>Tanggal Lahir </td>
          <td>:</td>
          <td> <?=$tgl;?> /Usia : <?=$umur;?> th </td>
        </tr>
        <tr>
          <td>No. RM </td>
          <td>:</td>
          <td><?=$noRM;?> No. Registrasi :__________ </td>
        </tr>
        <tr>
          <td>Ruang rawat/Kelas </td>
          <td>:</td>
          <td><?=$kamar;?> / <?=$kelas;?></td>
        </tr>
        <tr>
          <td height="22">Alamat</td>
          <td>:</td>
          <td><?=$alamat;?></td>
        </tr>
            </table></td>
  </tr>
  <tr>
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
  </tr>
  <tr>
    <td><strong>CHECK LIST </strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p><strong>PENGKAJIAN KEPERAWATAN</strong></p>    </td>
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
  </tr>
  <tr>
    <td width="186">Tiba diruangan </td>
    <td width="6">:</td>
    <td colspan="2">Tanggal :&nbsp;<?=$dt["tgl_tiba2"]?></td>
    <td colspan="2">Jam :&nbsp;<?=$dt["jam_tiba"]?></td>
    <td width="88">&nbsp;</td>
    <td width="104">&nbsp;</td>
    <td width="105">&nbsp;</td>
    <td width="102">&nbsp;</td>
  </tr>
  <tr>
    <td>Pengkajian tanggal </td>
    <td>:</td>
    <td colspan="2">Tanggal :&nbsp;<?=$dt["tgl_kaji2"]?></td>
    <td colspan="2">Jam :&nbsp;<?=$dt["jam_kaji"]?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>Masuk Melalui </td>
    <td>:</td>
    <td width="102"><span <?php if($dt['melalui']!=1){echo 'style="text-decoration:line-through"';}?>>UGD</span></td>
    <td width="126"><span <?php if($dt['melalui']!=2){echo 'style="text-decoration:line-through"';}?>>Admission</span></td>
    <td width="115"><span <?php if($dt['melalui']!=3){echo 'style="text-decoration:line-through"';}?>>Lain-lain</span></td>
    <td width="111">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Menggunakan</td>
    <td>:</td>
    <td><span <?php if($dt['menggunakan']!=1){echo 'style="text-decoration:line-through"';}?>>Brankard</span></td>
    <td><span <?php if($dt['menggunakan']!=2){echo 'style="text-decoration:line-through"';}?>>Kursi Roda</span></td>
    <td><span <?php if($dt['menggunakan']!=3){echo 'style="text-decoration:line-through"';}?>>Jalan</span></td>
    <td colspan="5">Diantar Oleh&nbsp;<u><?=$dt["diantar"]?></u></td>
  </tr>
  <tr>
    <td height="38">Alat protase yang dipakai <?php $alat_protase=explode("|",$dt["alat_protase"]);?></td>
    <td>:</td>
    <td><span <?php if($alat_protase[0]!=1){echo 'style="text-decoration:line-through"';}?>>Kacamata</span> </td>
    <td><span <?php if($alat_protase[0]!=2){echo 'style="text-decoration:line-through"';}?>>Gigi palsu</span> </td>
    <td><span <?php if($alat_protase[0]!=3){echo 'style="text-decoration:line-through"';}?>>Tongkat</span></td>
    <td colspan="5">Lain-lain&nbsp;<u><?=$alat_protase[1]?></u></td>
  </tr>
  <tr>
    <td>Gelang identitas </td>
    <td>:</td>
    <td><span <?php if($dt['gelang']!=1){echo 'style="text-decoration:line-through"';}?>>Terpasang</span></td>
    <td colspan="2"><span <?php if($dt['gelang']!=2){echo 'style="text-decoration:line-through"';}?>>Belum Terpasang</span> </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Diagnognosa medis </td>
    <td>:</td>
    <td colspan="8">&nbsp;<u><?=$dt["diagnosis"]?></u></td>
  </tr>
  <tr>
    <td>Riwayat penyakit saat ini </td>
    <td>:</td>
    <td colspan="8">&nbsp;<u><?=$dt["penyakit_skg"]?></u></td>
  </tr>
  <tr>
    <td>Riwayat dirawat <?php $dirawat=explode("|",$dt["dirawat"]);?></td>
    <td>:</td>
    <td><span <?php if($dirawat[0]!=2){echo 'style="text-decoration:line-through"';}?>>Tidak</span></td>
    <td><span <?php if($dirawat[0]!=1){echo 'style="text-decoration:line-through"';}?>>Ya</span></td>
    <td colspan="2">Kapan&nbsp;<u><?=$dirawat[1]?></u></td>
    <td colspan="2">Dimana&nbsp;<u><?=$dirawat[2]?></u></td>
    <td colspan="2">Sakit Apa&nbsp;<u><?=$dirawat[3]?></u></td>
  </tr>
  <tr>
    <td>Riwayat pengobatan dirumah </td>
    <td>:</td>
    <td colspan="8">&nbsp;<u><?=$dt["pengobatan"]?></u></td>
  </tr>
  <tr>
    <td>Riwayat alergi<?php $alergi=explode("|",$dt["alergi"]);?></td>
    <td>:</td>
    <td><span <?php if($alergi[0]!=2){echo 'style="text-decoration:line-through"';}?>>Tidak</span></td>
    <td><span <?php if($alergi[0]!=1){echo 'style="text-decoration:line-through"';}?>>Ya</span></td>
    <td colspan="2">Jenis&nbsp;<u><?=$alergi[1]?></u></td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Riwayat Tranfusi <?php $transfusi=explode("|",$dt["tranfusi"]);?></td>
    <td>:</td>
    <td><span <?php if($transfusi[0]!=2){echo 'style="text-decoration:line-through"';}?>>Tidak</span></td>
    <td><span <?php if($transfusi[0]!=1){echo 'style="text-decoration:line-through"';}?>>Ya</span></td>
    <td>Reaksi Alergi </td>
    <td colspan="2"><span <?php if($transfusi[1]!=2){echo 'style="text-decoration:line-through"';}?>>Ada</span></td>
    <td><span <?php if($transfusi[1]!=1){echo 'style="text-decoration:line-through"';}?>>Tidak</span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Riwayat Penyakit Keluarga <?php $penyakit_klg=explode("|",$dt["penyakit_klg"]);
	$penyakit_klg2=explode(",",$penyakit_klg[1]);?></td>
    <td>:</td>
    <td><span <?php if($penyakit_klg[0]!=2){echo 'style="text-decoration:line-through"';}?>>Tidak</span></td>
    <td><span <?php if($penyakit_klg[0]!=1){echo 'style="text-decoration:line-through"';}?>>Ya</span></td>
    <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($penyakit_klg2[0]=='jantung') { echo "checked='checked'";}?> />
    Jantung</td>
    <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($penyakit_klg2[1]=='diabetes') { echo "checked='checked'";}?> />
    Diabetes</td>
    <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($penyakit_klg2[2]=='cancer') { echo "checked='checked'";}?> />
    Cancer</td>
    <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($penyakit_klg2[3]=='hipertensi') { echo "checked='checked'";}?> />
    Hipertensi</td>
    <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($penyakit_klg2[4]=='tbc') { echo "checked='checked'";}?> />
    TBC</td>
    <td><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($penyakit_klg2[5]=='anemia') { echo "checked='checked'";}?> />
    Anemia</td>
  </tr>
  <tr>
    <td>Status Perkawinan </td>
    <td>:</td>
    <td><span <?php if($dt['kawin']!=1){echo 'style="text-decoration:line-through"';}?>>Menikah</span></td>
    <td><span <?php if($dt['kawin']!=2){echo 'style="text-decoration:line-through"';}?>>Belum Menikah</span> </td>
    <td><span <?php if($dt['kawin']!=3){echo 'style="text-decoration:line-through"';}?>>Janda/duda</span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="800" colspan="10"><table width="1082" border="0" style="border-collapse:collapse">
      <tr>
        <td colspan="8" style="border:1px solid #000000"><div align="center">DATA</div></td>
        <td colspan="3"style="border:1px solid #000000"><div align="center">MASALAH</div></td>
        <td style="border:1px solid #000000"><div align="center">TGL DITEMUKAN </div></td>
      </tr>
      <tr>
        <td width="14" style="border-left:1px solid #000000">1</td>
        <td width="124"><strong>GCS</strong></td>
        <td width="132">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td width="131">&nbsp;</td>
        <td width="95">&nbsp;</td>
        <td width="73" style="border-right:1px solid #000000">&nbsp;</td>
        <td width="24">&nbsp;</td>
        <td width="26">&nbsp;</td>
        <td width="178" style="border-right:1px solid #000000">&nbsp;</td>
        <td width="103" style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Motorik</td>
        <td><span <?php if($dt['motorik']!=1){echo 'style="text-decoration:line-through"';}?>>Kuat</span></td>
        <td colspan="2"><span <?php if($dt['motorik']!=2){echo 'style="text-decoration:line-through"';}?>>Lemah</span></td>
        <td><span <?php if($dt['motorik']!=3){echo 'style="text-decoration:line-through"';}?>>Hemiparese</span></td>
        <td><span <?php if($dt['motorik']!=4){echo 'style="text-decoration:line-through"';}?>>Kanan</span></td>
        <td  style="border-right:1px solid #000000"><span <?php if($dt['motorik']!=5){echo 'style="text-decoration:line-through"';}?>>Kiri</span></td>
        <td>&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000000"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($dt['g_cerebral']==1) { echo "checked='checked'";}?> /> 
        Gangguan Fungsi cerebral</td>
        <td style="border-right:1px solid #000000">&nbsp;<u><?=$dt["tgl_cerebral2"]?></u></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Berbicara</td>
        <td><span <?php if($dt['berbicara']!=1){echo 'style="text-decoration:line-through"';}?>>Normal</span></td>
        <td colspan="2"><span <?php if($dt['berbicara']!=2){echo 'style="text-decoration:line-through"';}?>>Apasia</span></td>
        <td><span <?php if($dt['berbicara']!=3){echo 'style="text-decoration:line-through"';}?>>Gagap</span></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td colspan="3" style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Penglihatan</td>
        <td><span <?php if($dt['penglihatan']!=1){echo 'style="text-decoration:line-through"';}?>>Tidak Jelas</span> </td>
        <td colspan="2"><span <?php if($dt['penglihatan']!=2){echo 'style="text-decoration:line-through"';}?>>Jelas</span></td>
        <td><span <?php if($dt['penglihatan']!=3){echo 'style="text-decoration:line-through"';}?>>Kanan</span></td>
        <td><span <?php if($dt['penglihatan']!=4){echo 'style="text-decoration:line-through"';}?>>Kiri</span></td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td colspan="3" style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Pendengaran</td>
        <td><span <?php if($dt['pendengaran']!=2){echo 'style="text-decoration:line-through"';}?>>Tidak jelas</span> </td>
        <td colspan="2"><span <?php if($dt['pendengaran']!=1){echo 'style="text-decoration:line-through"';}?>>Jelas</span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td colspan="3" style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Tinggi Badan </td>
        <td colspan="2">&nbsp;<u><?=$dt["tinggi_badan"]?></u>&nbsp;cm</td>
        <td colspan="3">Berat badan&nbsp;<u><?=$dt["berat_badan"]?></u>&nbsp;kg </td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td colspan="3" style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>TD<?php $TD=explode("|",$dt["TD"]);?></td>
        <td colspan="6" style="border-right:1px solid #000000">&nbsp;<u><?=$TD[0]?></u>&nbsp;mmHg &nbsp;&nbsp;&nbsp; &nbsp; HR&nbsp;<u><?=$TD[1]?></u>&nbsp;x/menit &nbsp;&nbsp; &nbsp;&nbsp;RR&nbsp;<u><?=$TD[2]?></u>&nbsp;x/menit &nbsp; &nbsp;&nbsp;&nbsp;Suhu&nbsp;<u><?=$TD[3]?></u>&nbsp;&deg;C</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Suara Nafas </td>
        <td><span <?php if($dt['suara_nafas']!=1){echo 'style="text-decoration:line-through"';}?>>Vesikuler</span></td>
        <td colspan="2"><span <?php if($dt['suara_nafas']!=2){echo 'style="text-decoration:line-through"';}?>>Ronchi</span></td>
        <td><span <?php if($dt['suara_nafas']!=3){echo 'style="text-decoration:line-through"';}?>>Wheezing</span></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000000"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($dt['g_gas']==1) { echo "checked='checked'";}?> />
          Gangguan Pertukaran gas </td>
        <td style="border-right:1px solid #000000">&nbsp;<u><?=$dt["tgl_gas2"]?></u></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Sputum</td>
        <td><span <?php if($dt['sputum']!=1){echo 'style="text-decoration:line-through"';}?>>Tidak ada</span> </td>
        <td colspan="2"><span <?php if($dt['sputum']!=2){echo 'style="text-decoration:line-through"';}?>>Ada</span></td>
        <td><span <?php if($dt['sputum']!=3){echo 'style="text-decoration:line-through"';}?>>Kental</span></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000000"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($dt['g_jln_nafas']==1) { echo "checked='checked'";}?> />
          Bersihan Jalan Nafas Tidak Efektif </td>
        <td style="border-right:1px solid #000000">&nbsp;<u><?=$dt["tgl_jalan_nafas2"]?></u></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td><span <?php if($dt['sputum']!=4){echo 'style="text-decoration:line-through"';}?>>Putih</span></td>
        <td colspan="2"><span <?php if($dt['sputum']!=5){echo 'style="text-decoration:line-through"';}?>>Kuning</span></td>
        <td><span <?php if($dt['sputum']!=6){echo 'style="text-decoration:line-through"';}?>>Kemerahan</span> </td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000000"><?php $g_termoregulasi=explode("|",$dt['g_termoregulasi']);?><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($g_termoregulasi[0]==1) { echo "checked='checked'";}?> />
          Gangguan termoregulasi</td>
        <td  style="border-right:1px solid #000000">&nbsp;<u><?=$dt["tgl_termoregulasi2"]?></u></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Makan</td>
        <td><span <?php if($dt['makan']!=1){echo 'style="text-decoration:line-through"';}?>>Nafsu</span></td>
        <td colspan="2"><span <?php if($dt['makan']!=2){echo 'style="text-decoration:line-through"';}?>>Kurang</span></td>
        <td><span <?php if($dt['makan']!=3){echo 'style="text-decoration:line-through"';}?>>Tidak ada</span></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><span <?php if($g_termoregulasi[0]!=1){echo 'style="text-decoration:line-through"';}?>>Hypotermi</span></td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td><span <?php if($dt['makan']!=4){echo 'style="text-decoration:line-through"';}?>>Mual</span></td>
        <td colspan="2"><span <?php if($dt['makan']!=5){echo 'style="text-decoration:line-through"';}?>>Muntah</span></td>
        <td><span <?php if($dt['makan']!=6){echo 'style="text-decoration:line-through"';}?>>Sukar Menelan</span> </td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><span <?php if($g_termoregulasi[0]!=2){echo 'style="text-decoration:line-through"';}?>>Hypotermia</span></td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td height="16" style="border-left:1px solid #000000">&nbsp;</td>
        <td>Frekuensi Minum<?php $frek_umum=explode("|",$dt["frek_umum"]);?></td>
        <td colspan="3">&nbsp;<u><?=$frek_umum[0]?></u>&nbsp;x/hari &nbsp;&nbsp;&nbsp;&nbsp;<u><?=$frek_umum[1]?></u>&nbsp;cc/hari </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000000"><?php $g_keb_nutrisi=explode("|",$dt['g_keb_nutrisi']);?><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($g_keb_nutrisi[0]==1) { echo "checked='checked'";}?> />
          Gangguan Kebutuhan Nutrisi </td>
        <td style="border-right:1px solid #000000">&nbsp;<u><?=$dt["tgl_keb_nutrisi2"]?></u></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>BAK<?php $BAK=explode("|",$dt["BAK"]);?></td>
        <td colspan="6" style="border-right:1px solid #000000">Jumlah&nbsp;<u><?=$BAK[0]?></u>&nbsp;cc/hari&nbsp;&nbsp;&nbsp;&nbsp; warna&nbsp;<u><?=$BAK[1]?></u> </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><span <?php if($g_keb_nutrisi[1]!=1){echo 'style="text-decoration:line-through"';}?>>Kekurangan Nutrisi</span> </td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td height="16" style="border-left:1px solid #000000">&nbsp;</td>
        <td>Bila Muntah<?php $muntah=explode("|",$dt["muntah"]);?></td>
        <td colspan="6" style="border-right:1px solid #000000">Frekuensi&nbsp;<u><?=$muntah[0]?></u>&nbsp;x/hari&nbsp;&nbsp;&nbsp;&nbsp; warna&nbsp;<u><?=$muntah[1]?></u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; isi&nbsp;<u><?=$muntah[2]?></u> </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><span <?php if($g_keb_nutrisi[1]!=2){echo 'style="text-decoration:line-through"';}?>>Kelebihan Nutrisi</span> </td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td height="16" style="border-left:1px solid #000000">&nbsp;</td>
        <td>Bila hematemeis<?php $hematemeis=explode("|",$dt["hematemeis"]);?></td>
        <td>&nbsp;<u><?=$hematemeis[0]?></u>&nbsp;x/hari</td>
        <td colspan="2">jumlah&nbsp;<u><?=$hematemeis[1]?></u>&nbsp;x/hari </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td colspan="3" style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Asites</td>
        <td><span <?php if($dt['asites']!=1){echo 'style="text-decoration:line-through"';}?>>Ya</span></td>
        <td colspan="2"><span <?php if($dt['asites']!=2){echo 'style="text-decoration:line-through"';}?>>Tidak</span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000000"><?php $g_vol_cairan=explode("|",$dt['g_vol_cairan']);?><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($g_vol_cairan[0]==1) { echo "checked='checked'";}?> />
          Gangguan Volume cairan </td>
        <td style="border-right:1px solid #000000">&nbsp;<u><?=$dt["tgl_vol_cairan2"]?></u></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Turgor <?php $turgor=explode("|",$dt["turgor"]);?></td>
        <td><span <?php if($turgor[0]!=1){echo 'style="text-decoration:line-through"';}?>>Elastis</span></td>
        <td colspan="2"><span <?php if($turgor[0]!=2){echo 'style="text-decoration:line-through"';}?>>Tidak Elastis</span> </td>
        <td>Lokasi&nbsp;<u><?=$turgor[1]?></u></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><span <?php if($g_vol_cairan[1]!=1){echo 'style="text-decoration:line-through"';}?>>Kelebihan</span></td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Edema<?php $edema=explode("|",$dt["edema"]);?></td>
        <td><span <?php if($edema[0]!=1){echo 'style="text-decoration:line-through"';}?>>Ya</span></td>
        <td colspan="2"><span <?php if($edema[0]!=2){echo 'style="text-decoration:line-through"';}?>>Tidak</span></td>
        <td>Lokasi&nbsp;<u><?=$edema[1]?></u></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><span <?php if($g_vol_cairan[1]!=2){echo 'style="text-decoration:line-through"';}?>>Kekurangan</span></td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>BAB<?php $BAB=explode("|",$dt["BAB"]);?></td>
        <td><span <?php if($BAB[0]!=1){echo 'style="text-decoration:line-through"';}?>>Padat</span></td>
        <td colspan="2"><span <?php if($BAB[0]!=2){echo 'style="text-decoration:line-through"';}?>>Cair</span></td>
        <td>Frekuensi&nbsp;<u><?=$BAB[1]?></u>&nbsp;/hari</td>
        <td colspan="2" style="border-right:1px solid #000000">Jumlah&nbsp;<u><?=$BAB[2]?></u>&nbsp;cc/hari</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Peristaltik</td>
        <td><span <?php if($dt['peristaltik']!=1){echo 'style="text-decoration:line-through"';}?>>Lemah</span></td>
        <td colspan="2"><span <?php if($dt['peristaltik']!=2){echo 'style="text-decoration:line-through"';}?>>Aktif</span></td>
        <td><span <?php if($dt['peristaltik']!=3){echo 'style="text-decoration:line-through"';}?>>Hiperaktif</span></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000000"><?php $g_eliminasi_u=explode("|",$dt['g_eliminasi_u']);?><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($g_eliminasi_u[0]==1) { echo "checked='checked'";}?> />
          Gangguan Pola Eliminasi Urine </td>
        <td style="border-right:1px solid #000000">&nbsp;<u><?=$dt["tgl_eliminasi_u2"]?></u></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Bila melena <?php $melena=explode("|",$dt["melena"]);?></td>
        <td>&nbsp;<u><?=$melena[0]?></u>&nbsp;x/hari</td>
        <td colspan="2">Jumlah&nbsp;<u><?=$melena[1]?></u>&nbsp;/hari</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><span <?php if($g_eliminasi_u[1]!=1){echo 'style="text-decoration:line-through"';}?>>Ratensio Urine</span> </td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Masalah tidur </td>
        <td><span <?php if($dt['masalah_tdr']!=1){echo 'style="text-decoration:line-through"';}?>>Ada</span></td>
        <td colspan="2"><span <?php if($dt['masalah_tdr']!=2){echo 'style="text-decoration:line-through"';}?>>Tidak ada</span> </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><span <?php if($g_eliminasi_u[1]!=2){echo 'style="text-decoration:line-through"';}?>>Inkontinesia</span></td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Bila Fraktur </td>
        <td>Lokasi&nbsp;<u><?=$dt["faktur"]?></u></td>
        <td colspan="2">Terpasang traksi </td>
        <td><span <?php if($dt['traksi']!=1){echo 'style="text-decoration:line-through"';}?>>Ya</span></td>
        <td><span <?php if($dt['traksi']!=2){echo 'style="text-decoration:line-through"';}?>>Tidak</span></td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">Terpasang gibs </td>
        <td><span <?php if($dt['gibs']!=1){echo 'style="text-decoration:line-through"';}?>>Ya</span></td>
        <td><span <?php if($dt['gibs']!=2){echo 'style="text-decoration:line-through"';}?>>Tidak</span></td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000000"><?php $g_eliminasi_a=explode("|",$dt['g_eliminasi_a']);?><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($g_eliminasi_a[0]==1) { echo "checked='checked'";}?> />
          Gangguan Pola Eliminasi Alvi </td>
        <td style="border-right:1px solid #000000">&nbsp;<u><?=$dt["tgl_eliminasi_a2"]?></u></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Resiko jatuh </td>
        <td>score&nbsp;<u><?=$dt["jatuh"]?></u></td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><span <?php if($g_eliminasi_a[1]!=1){echo 'style="text-decoration:line-through"';}?>>Konstipasi</span></td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Terpasang alat invasif <?php $invasif=explode("|",$dt["invasif"]);?></td>
        <td><span <?php if($invasif[0]!=1){echo 'style="text-decoration:line-through"';}?>>Infus</span></td>
        <td colspan="2"><span <?php if($invasif[0]!=2){echo 'style="text-decoration:line-through"';}?>>NGT</span></td>
        <td><span <?php if($invasif[0]!=3){echo 'style="text-decoration:line-through"';}?>>Cateter</span></td>
        <td><span <?php if($invasif[0]!=4){echo 'style="text-decoration:line-through"';}?>>CVP</span></td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><span <?php if($g_eliminasi_a[1]!=2){echo 'style="text-decoration:line-through"';}?>>Diare</span></td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td><span <?php if($invasif[0]!=5){echo 'style="text-decoration:line-through"';}?>>Drain</span></td>
        <td colspan="2"><span <?php if($invasif[0]!=6){echo 'style="text-decoration:line-through"';}?>>ETT</span></td>
        <td>Lain-lain&nbsp;<u><?=$invasif[1]?></u></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td colspan="3" style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Bila terpasang infus </td>
        <td>Lokasi&nbsp;<u><?=$dt["infus"]?></u></td>
        <td width="50">Plebitis<?php $plebitis=explode("|",$dt["plebitis"]);?></td>
        <td width="82"><span <?php if($plebitis[0]!=1){echo 'style="text-decoration:line-through"';}?>>Ya</span></td>
        <td><span <?php if($plebitis[0]!=2){echo 'style="text-decoration:line-through"';}?>>Tidak</span></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000000"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($dt['g_mobilitas']==1) { echo "checked='checked'";}?> />
          Gangguan Mobilitas Fisik </td>
        <td style="border-right:1px solid #000000">&nbsp;<u><?=$dt["tgl_mobilitas2"]?></u></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>Plebitis grade&nbsp;<u><?=$plebitis[1]?></u></td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td colspan="3" style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Kebersihan Mulut </td>
        <td><span <?php if($dt['mulut']!=1){echo 'style="text-decoration:line-through"';}?>>Caries</span></td>
        <td colspan="2"><span <?php if($dt['mulut']!=2){echo 'style="text-decoration:line-through"';}?>>Bau</span></td>
        <td><span <?php if($dt['mulut']!=3){echo 'style="text-decoration:line-through"';}?>>Tidak berbau</span> </td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td colspan="3" style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Gigi palsu </td>
        <td><span <?php if($dt['gigi_palsu']!=1){echo 'style="text-decoration:line-through"';}?>>Ada</span></td>
        <td colspan="2"><span <?php if($dt['gigi_palsu']!=2){echo 'style="text-decoration:line-through"';}?>>Tidak ada</span> </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td colspan="3" style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Kulit<?php $kulit=explode("|",$dt["kulit"]);?></td>
        <td><span <?php if($kulit[0]!=1){echo 'style="text-decoration:line-through"';}?>>Bersih</span></td>
        <td colspan="2"><span <?php if($kulit[0]!=2){echo 'style="text-decoration:line-through"';}?>>Kotor</span></td>
        <td><span <?php if($kulit[0]!=3){echo 'style="text-decoration:line-through"';}?>>Ikterik</span></td>
        <td><span <?php if($kulit[0]!=4){echo 'style="text-decoration:line-through"';}?>>Luka</span></td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000000"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($dt['g_integritas']==1) { echo "checked='checked'";}?> />
          Gangguan Integritas Kulit </td>
        <td style="border-right:1px solid #000000">&nbsp;<u><?=$dt["tgl_integritas2"]?></u></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>Lokasi&nbsp;<u><?=$kulit[1]?></u></td>
        <td colspan="2">Grade&nbsp;<u><?=$kulit[2]?></u></td>
        <td>Ukuran&nbsp;<u><?=$kulit[3]?></u></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td colspan="3" style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Turgor<?php $turgor_2=explode("|",$dt["turgor_2"]);?></td>
        <td><span <?php if($turgor_2[0]!=1){echo 'style="text-decoration:line-through"';}?>>Elastis</span></td>
        <td colspan="2"><span <?php if($turgor_2[0]!=2){echo 'style="text-decoration:line-through"';}?>>Tidak elastis</span> </td>
        <td>Lokasi&nbsp;<u><?=$turgor_2[1]?></u></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td colspan="3" style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Edema<?php $edema_2=explode("|",$dt["edema_2"]);?></td>
        <td><span <?php if($edema_2[0]!=2){echo 'style="text-decoration:line-through"';}?>>Tidak</span></td>
        <td colspan="2"><span <?php if($edema_2[0]!=1){echo 'style="text-decoration:line-through"';}?>>Ya</span></td>
        <td>Lokasi&nbsp;<u><?=$edema_2[1]?></u></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td colspan="3" style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Rambut</td>
        <td><span <?php if($dt['rambut']!=1){echo 'style="text-decoration:line-through"';}?>>Bersih</span></td>
        <td colspan="2"><span <?php if($dt['rambut']!=2){echo 'style="text-decoration:line-through"';}?>>Kotor</span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000000"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($dt['g_rawat_diri']==1) { echo "checked='checked'";}?> />
          Ketidakmampuan merawat diri </td>
        <td style="border-right:1px solid #000000">&nbsp;<?=$dt["rawat_diri2"]?></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Kebiasaan<?php $kebiasaan=explode("|",$dt["kebiasaan"]);?></td>
        <td><span <?php if($kebiasaan[0]!=1){echo 'style="text-decoration:line-through"';}?>>Merokok</span></td>
        <td colspan="2"><span <?php if($kebiasaan[0]!=2){echo 'style="text-decoration:line-through"';}?>>Kopi</span></td>
        <td><span <?php if($kebiasaan[0]!=3){echo 'style="text-decoration:line-through"';}?>>Obat-obatan</span></td>
        <td colspan="2" style="border-right:1px solid #000000">Nama obat&nbsp;<u><?=$kebiasaan[1]?></u></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>Ekspresi emosi </td>
        <td><span <?php if($dt['emosi']!=1){echo 'style="text-decoration:line-through"';}?>>Tenang</span></td>
        <td colspan="2"><span <?php if($dt['emosi']!=2){echo 'style="text-decoration:line-through"';}?>>Cemas</span></td>
        <td><span <?php if($dt['emosi']!=3){echo 'style="text-decoration:line-through"';}?>>Marah</span></td>
        <td><span <?php if($dt['emosi']!=4){echo 'style="text-decoration:line-through"';}?>>Sedih</span></td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" style="border-right:1px solid #000000"><?php $g_psikiatrik=explode("|",$dt['g_psikiatrik']);?><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($g_psikiatrik[0]==1) { echo "checked='checked'";}?> />
          Gangguan Psikiatrik </td>
        <td style="border-right:1px solid #000000">&nbsp;<u><?=$dt["tgl_psikiatrik2"]?></u></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td><span <?php if($dt['emosi']!=5){echo 'style="text-decoration:line-through"';}?>>Takut</span></td>
        <td colspan="2"><span <?php if($dt['emosi']!=6){echo 'style="text-decoration:line-through"';}?>>Senang</span></td>
        <td><span <?php if($dt['emosi']!=7){echo 'style="text-decoration:line-through"';}?>>Menyendiri</span></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><span <?php if($g_psikiatrik[1]!=1){echo 'style="text-decoration:line-through"';}?>>Cemas</span></td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td><span <?php if($dt['emosi']!=8){echo 'style="text-decoration:line-through"';}?>>Agitasi/merusak</span></td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><span <?php if($g_psikiatrik[1]!=2){echo 'style="text-decoration:line-through"';}?>>Depresi</span></td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000"><span <?php if($g_psikiatrik[1]!=3){echo 'style="text-decoration:line-through"';}?>>Perilaku Bunuh Diri</span> </td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000">2</td>
        <td colspan="7" style="border-right:1px solid #000000">Skala Intensitas Nyeri Numerik 0-10 Lokasi&nbsp;<u><?=$dt["skala_nyeri"]?></u></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
        <td style="border-right:1px solid #000000">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="8" style="border-left:1px solid #000000;border-bottom:1px solid #000000;border-right:1px solid #000000;">&nbsp;</td>
        <td style="border-bottom:1px solid #000000">&nbsp;</td>
        <td colspan="2" style="border-bottom:1px solid #000000;border-right:1px solid #000000"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($dt['g_nyeri']==1) { echo "checked='checked'";}?> />
          Gangguan rasa nyaman nyeri </td>
        <td style="border-bottom:1px solid #000000;border-right:1px solid #000000">&nbsp;<u><?=$dt["tgl_nyeri2"]?></u></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="708" align="center">
	<button onclick="window.print()" type="button">Print</button>&nbsp;
	<button onclick="window.close()" type="button">Close</button>
	</td>
  </tr>
</table>
</body>
</html>
