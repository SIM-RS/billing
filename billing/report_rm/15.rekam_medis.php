<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>rekam medis</title>
</head>
<?
include "setting.php";
$sql="select * from b_fom_rekam_medis_hd where id = '$_GET[id]'"; //echo $sql;
$hasil=mysql_query($sql);
$data=mysql_fetch_array($hasil);

$isi_chk=explode(",",$data['isi']);
?>
<body>
<table width="800" border="0" style="font:12px tahoma;">
  <tr>
    <td><table width="528" border="1" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse;">
      <tr>
        <td height="100" valign="bottom"><span style="font:bold 20px tahoma;">REKAM MEDIS HEMODIALISA</span></td>
        </tr>
      
    </table></td>
  </tr>
</table>
<br />
<table width="799" border="0" cellpadding="4" style="font:12px tahoma;">
  <tr>
    <td width="146">Nama</td>
    <td width="181">: <?=$nama;?> </td>
    <td width="106">Tanggal</td>
    <td colspan="3">: <?=tglSQL($data['tgl'])?></td>
    </tr>
  <tr>
    <td>Umur</td>
    <td>: <?=$umur;?> Th </td>
    <td>HD ke </td>
    <td colspan="2">:  
      <label for="hd_ke"></label>
      <?=$data['hd_ke']?></td>
    <td width="107">&nbsp;</td>
  </tr>
  <tr>
    <td>No.Rekam Medis </td>
    <td>: <?=$noRM;?> </td>
    <td>Mesin</td>
    <td colspan="3">: 
      <label for="mesin"></label>
      <?=$data['mesin']?></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Dialiser Type </td>
    <td colspan="2">:  
      <label for="type"></label>
      <?=$data['type']?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Pemeriksaan Pre HD</td>
    <td>&nbsp;</td>
    <td>Jenis HD </td>
    <td width="124">: 
    <input type="radio" name="radio[0]" id="radio[]" disabled="disabled" <?php if($data['jenis_hd']=='1'){echo "checked='checked'";}?>/>
    Single use </td>
    <td width="73">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;
      <input type="radio" name="radio[0]" id="radio[]" disabled="disabled" <?php if($data['jenis_hd']=='2'){echo "checked='checked'";}?>/>
    Reuse ke </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>TD Tidur</td>
    <td>: 
      <label for="td_tidur"></label>
      <?=$data['td_tidur']?>
mmHg</td>
    <td>Heparinasi</td>
    <td>&nbsp;
      <input type="radio" name="radio[0]" id="radio[]" disabled="disabled" <?php if($data['jenis_hd']=='3'){echo "checked='checked'";}?>/>
    Kontinue &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
    <td>Dosis Awal </td>
    <td>: 
      <label for="dosis_awal1"></label>
      <?=$data['dosis_awal1']?>
u </td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;Duduk</td>
    <td>:  
      <?=$data['duduk']?>
      mmHg</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Dosis Lanjut </td>
    <td>: 
      <?=$data['dosis_lanjut']?>
u /jam </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Dosis Awal </td>
    <td>: 
      <?=$data['dosis_awal2']?>
      u </td>
  </tr>
  <tr>
    <td>Nadi</td>
    <td>: 
      <?=$data['nadi']?>
x/mnt </td>
    <td>Lama HD </td>
    <td>: 
      <?=$data['lama_hd']?>
&nbsp;Jam </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Respirasi</td>
    <td>: 
      <?=$data['respirasi']?>
x/mnt </td>
    <td>Mulai jam </td>
    <td>: <?=$data['jam_mulai']?></td>
    <td>Selesai Jam :</td>
    <td><?=$data['jam_selesai']?></td>
    </tr>
  <tr>
    <td>Suhu</td>
    <td>: 
      <?=$data['suhu']?>&deg; C </td>
    <td>Priming Volume</td>
    <td>: 
      <?=$data['p_volume']?>
      ml </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Priming Keluar</td>
    <td>: 
      <?=$data['p_keluar']?>
      ml </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Keluhan</td>
    <td colspan="5">: <label for="keluhan"></label>
      <?=$data['keluhan']?></td>
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
    <td>BB Standart (Dry Wight)</td>
    <td>:  
      <?=$data['bbs']?>
      kg </td>
    <td>Lain-lain</td>
    <td colspan="2">: 
      <?=$data['lain']?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>BB Pre HD</td>
    <td>: 
      <?=$data['bbpre']?>
kg </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>BB Post HD yang lalu</td>
    <td>: 
      <?=$data['bbpo']?>
kg </td>
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
    <td>Sarana Hubungan Sirkulasi</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="radio" name="radio[1]" id="radio[]" disabled="disabled" <?php if($data['sarana']=='1'){echo "checked='checked'";}?> />
    Cimino</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="radio" name="radio[1]" id="radio[]" disabled="disabled" <?php if($data['sarana']=='2'){echo "checked='checked'";}?> />
  Double / Triple Lumen </td>
    <td>&nbsp;</td>
    <td>Perawat I </td>
    <td colspan="3">: 
      <?=$data['perawat1']?></td>
    </tr>
  <tr>
    <td><input type="radio" name="radio[1]" id="radio[]" disabled="disabled" <?php if($data['sarana']=='3'){echo "checked='checked'";}?> />
Tunnel</td>
    <td>&nbsp;</td>
    <td>Perawat II </td>
    <td colspan="3">: 
      <?=$data['perawat2']?></td>
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
    <td colspan="6"><div id="inObat">
      <table align="center" width="747" border="1" id="datatable" cellpadding="2" style="border-collapse:collapse;">
        <tr>
          <td width="158" align="center"><strong>Jam</strong></td>
          <td width="38" align="center"><strong>TD</strong></td>
          <td width="61" align="center"><strong>Nadi</strong></td>
          <td width="54" align="center"><strong>Respirasi</strong></td>
          <td width="30" align="center"><strong>Suhu</strong></td>
          <td width="46" align="center"><strong>Heparin</strong></td>
          <td width="33" align="center"><strong>TMP</strong></td>
          <td width="39" align="center"><strong>AP/VP</strong></td>
          <td width="33" align="center"><strong>QB</strong></td>
          <td width="33" align="center"><strong>UFR</strong></td>
          <td width="33" align="center"><strong>UFG</strong></td>
          <td width="89" align="center"><strong>Keterangan</strong></td>
          </tr>
    <?php
		$sql=mysql_query("SELECT * FROM b_fom_rekam_medis_hd_t1 WHERE rekam_medis_id='$_GET[id]' order by id");
		while($dt=mysql_fetch_array($sql)){
	?>
        <tr>
          <td><?=$dt['jam']?>&nbsp;</td>
          <td align="center"><?=$dt['tdd']?>&nbsp;</td>
          <td align="center"><?=$dt['nadi_t1']?>&nbsp;</td>
          <td align="center"><?=$dt['respirasi_t1']?>&nbsp;</td>
          <td align="center"><?=$dt['suhu_t1']?>&nbsp;</td>
          <td align="center"><?=$dt['heparin']?>&nbsp;</td>
          <td align="center"><?=$dt['tmp']?>&nbsp;</td>
          <td align="center"><?=$dt['ap']?>&nbsp;</td>
          <td align="center"><?=$dt['qb']?>&nbsp;</td>
          <td align="center"><?=$dt['ufr']?>&nbsp;</td>
          <td align="center"><?=$dt['ufg']?>&nbsp;</td>
          <td align="center"><?=$dt['keterangan']?>&nbsp;</td>
          </tr>
     <?php
		}
     ?>
        </table>
      </div></td>
  </tr>
  <tr>
    <td colspan="6">INSTRUKSI DOKTER</td>
  </tr>
  <tr>
    <td colspan="6"><table width="800" border="0" cellpadding="4">
      <tr>
        <td colspan="6"><div id="inObat2"><table width="740" border="1" align="center" cellpadding="2" id="datatable2" style="border-collapse:collapse;">
          <tr>
            <td width="63" align="center"><strong>Jam</strong></td>
            <td width="471" align="center"><strong>Saran Dokter</strong></td>
            <td width="178" align="center"><strong>TTD/Nama Perawat</strong></td>
            </tr>
    <?php
		$sql2=mysql_query("SELECT * FROM b_fom_rekam_medis_hd_t2 WHERE rekam_medis_id='$_GET[id]' order by id");
		while($dt2=mysql_fetch_array($sql2)){
	?>
          <tr>
            <td valign="middle"><?=$dt2['jam2']?>&nbsp;</td>
            <td align="center"><?=$dt2['saran']?>&nbsp;</td>
            <td align="center">&nbsp;</td>
            </tr>
    <?php
		}
	?>
          </table></div></td>
        </tr>
      <tr>
        <td colspan="2">Pemeriksaan Post HD :</td>
        <td colspan="2">Intake Cairan</td>
        <td colspan="2">Output Cairan</td>
        </tr>
      <tr>
        <td width="114">TD Tidur</td>
        <td width="199">: 
          <?=$data['td_tidur2']?>
          mmHg</td>
        <td width="97">Sisa Priming</td>
        <td width="91">: 
          <?=$data['sisa']?>
          ml</td>
        <td width="107">Urine</td>
        <td width="129">: 
          <?=$data['urine']?>
          ml</td>
        </tr>
      <tr>
        <td>TD Duduk</td>
        <td>: 
          <?=$data['duduk2']?>
          mmHg</td>
        <td>Infus</td>
        <td>: 
          <?=$data['infus']?>
          ml</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>Nadi</td>
        <td>: 
          <?=$data['nadi2']?>
          x/menit</td>
        <td>Transfusi</td>
        <td>: 
          <?=$data['tran']?>
          ml</td>
        <td>Muntah</td>
        <td>: 
          <?=$data['muntah']?>
          ml</td>
        </tr>
      <tr>
        <td>Respirasi</td>
        <td>: 
          <?=$data['respirasi2']?>
          x/menit</td>
        <td>Bilas</td>
        <td>: 
          <?=$data['bilas']?>
          ml</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>Suhu</td>
        <td>: 
          <?=$data['suhu2']?>          &deg;c</td>
        <td style="border-bottom:1px solid #000000;">Minum</td>
        <td style="border-bottom:1px solid #000000;">: 
          <?=$data['minum']?>
          ml</td>
        <td style="border-bottom:1px solid #000000;">UF</td>
        <td style="border-bottom:1px solid #000000;">: 
          <?=$data['uf']?>
          ml</td>
        </tr>
      <tr>
        <td>Keluhan</td>
        <td>: 
          <?=$data['keluhan2']?></td>
        <td>Jumlah</td>
        <td>: 
          <?=$data['jumlah']?>
          ml</td>
        <td>Jumlah</td>
        <td>: 
          <?=$data['jumlah2']?>
          ml</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Total Balance </td>
        <td>: 
          <?=$data['total']?>
ml</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>BB Pulang</td>
        <td>: 
          <label for="bb_pulang"></label>
          <?=$data['bb_pulang']?>
&nbsp;Kg </td>
        <td>Perawat I </td>
        <td colspan="3">: 
          <?=$data['perawat11']?></td>
        </tr>
      <tr>
        <td>Penekanan</td>
        <td>: 
          <label for="penekanan"></label>
          <?=$data['penekanan']?>
&nbsp;Menit </td>
        <td>Perawat II</td>
        <td colspan="3">: 
          <?=$data['perawat22']?></td>
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
    <td colspan="6">&nbsp;</td>
  </tr>
</table>
<br />
<table width="1358" border="0" cellpadding="4" style="font:12px tahoma;">
  <tr>
    <td colspan="2">PENGKAJIAN</td>
    <td width="101">&nbsp;</td>
    <td width="106">&nbsp;</td>
    <td colspan="2">DIAGNOSA KEPERAWATAN </td>
    <td width="353">RENCANA DAN IMPLEMENTASI KEPERAWATAN</td>
    <td colspan="2">EVALUASI</td>
  </tr>
  <tr>
    <td width="21">A.</td>
    <td width="166">Respiratori</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="124">(
      <input type="checkbox" name="checkbox[0]" value="1" id="checkbox[]" disabled="disabled" <? if($isi_chk[0]=='1') { echo "checked='checked'";}?>/>
      <label for="checkbox"></label>) Aktual</td>
    <td width="134">(      
      <input type="checkbox" name="checkbox[1]" value="2" id="checkbox[]" disabled="disabled" <? if($isi_chk[1]=='2') { echo "checked='checked'";}?>/>
      <label for="checkbox2"></label>      ) Resiko </td>
    <td>(
      <input type="checkbox" name="checkbox[2]" value="3" id="checkbox[]" disabled="disabled" <? if($isi_chk[2]=='3') { echo "checked='checked'";}?>/>
      <label for="checkbox36"></label>
      ) Hitung Frekuensi dan irama pernafasan</td>
    <td width="7">&nbsp;</td>
    <td width="254">(
      <input type="checkbox" name="checkbox[3]" value="4" id="checkbox[]" disabled="disabled" <? if($isi_chk[3]=='4') { echo "checked='checked'";}?>/>
      <label for="checkbox74"></label>
      ) Pernafasan &plusmn; 20 x/m setelah </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>1. Tingkat Kesadaran </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[4]" value="5" id="checkbox[]" disabled="disabled" <? if($isi_chk[4]=='5') { echo "checked='checked'";}?>/>
      <label for="checkbox37"></label>
      ) Beri posisi semi fowler jika tidak ada kontra indikasi</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HD &le; 2 jam</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(CM)</td>
    <td>(Apatis)</td>
    <td>&nbsp;</td>
    <td colspan="2">(
      <input type="checkbox" name="checkbox[5]" value="6" id="checkbox[]" disabled="disabled" <? if($isi_chk[5]=='6') { echo "checked='checked'";}?>/>
      <label for="checkbox3"></label>) Gangguan pola nafas yang tidak efektif</td>
    <td>(
      <input type="checkbox" name="checkbox[6]" value="7" id="checkbox[]" disabled="disabled" <? if($isi_chk[6]=='7') { echo "checked='checked'";}?>/>
      <label for="checkbox38"></label>
      ) Berikan O2 sesuai kebutuhan</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[7]" value="8" id="checkbox[]" disabled="disabled" <? if($isi_chk[7]=='8') { echo "checked='checked'";}?>/>
      <label for="checkbox75"></label>
      ) Therapy O2, stop jam ke <?=$data['stop_jam']?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(Somnolen)</td>
    <td>(Comateus)</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[8]" value="9" id="checkbox[]" disabled="disabled" <? if($isi_chk[8]=='9') { echo "checked='checked'";}?>/>
      <label for="checkbox39"></label>
      ) Anjurkan nafas dalam teratur dan batuk efektif</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[9]" value="10" id="checkbox[]" disabled="disabled" <? if($isi_chk[9]=='10') { echo "checked='checked'";}?>/>
      <label for="checkbox76"></label>
      ) Tekanan darah post HD</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">Keterangan = 
      <?=$data['ket_res']?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[10]" value="11" id="checkbox[]" disabled="disabled" <? if($isi_chk[10]=='11') { echo "checked='checked'";}?>/>
      <label for="checkbox40"></label>
      ) Program HD sesuai kebutuhan pasien</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp; TD :
      <?=$data['td2']?>
      mmHg&nbsp;&nbsp; N :
      <?=$data['n2']?>
      mmHg</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>TD : 
      <label for="td"></label>
      <?=$data['td']?>      
      mmHg</td>
    <td colspan="2">N :
      <?=$data['n']?>
      x/mnt</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[11]" value="12" id="checkbox[]" disabled="disabled" <? if($isi_chk[11]=='12') { echo "checked='checked'";}?>/>
      <label for="checkbox41"></label>
      ) Lakukan ultrafiltrasi lebih banyak di jam pertama</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp; P &nbsp;&nbsp;:
      <?=$data['p2']?>
      x/m&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;S :
      <?=$data['s2']?>      &deg;c</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>P &nbsp;&nbsp;: 
      <?=$data['p']?>      
        x/mnt</td>
    <td colspan="2">S : 
      <?=$data['s']?>
      &deg;c</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[12]" value="13" id="checkbox[]" disabled="disabled" <? if($isi_chk[12]=='13') { echo "checked='checked'";}?>/>
      <label for="checkbox42"></label>
      ) Observasi vital sign ( on HD )</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[13]" value="14" id="checkbox[]" disabled="disabled" <? if($isi_chk[13]=='14') { echo "checked='checked'";}?>/>
      <label for="checkbox77"></label>
      ) Kolaborasi dengan dokter</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" height="30">Keterangan = 
      <?=$data['ket_res2']?></td>
    <td height="30">&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[14]" value="15" id="checkbox[]" disabled="disabled" <? if($isi_chk[14]=='15') { echo "checked='checked'";}?>/>
      <label for="checkbox43"></label>
      ) Kolaborasi dengan dokter</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>2. Edema </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[15]" value="16" id="checkbox[]" disabled="disabled" <? if($isi_chk[15]=='16') { echo "checked='checked'";}?>/>
      <label for="checkbox44"></label>
      ) Lakukan pemeriksaan AGD, SE, &amp; ureum, creatinin</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[16]" value="17" id="checkbox[]" disabled="disabled" <? if($isi_chk[16]=='17') { echo "checked='checked'";}?>/>
      <label for="checkbox4"></label>
      ) Tidak Ada </td>
    <td>(
      <input type="checkbox" name="checkbox[17]" value="18" id="checkbox[]" disabled="disabled" <? if($isi_chk[17]=='18') { echo "checked='checked'";}?>/>
      <label for="checkbox6"></label>
      ) Anasarka </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[18]" value="19" id="checkbox[]" disabled="disabled" <? if($isi_chk[18]=='19') { echo "checked='checked'";}?>/>
      <label for="checkbox45"></label>
      ) Therapy &nbsp;&nbsp;: 1. 
      <label for="textfield15"></label>
      <?=$data['therapy']?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[19]" value="20" id="checkbox[]" disabled="disabled" <? if($isi_chk[19]=='20') { echo "checked='checked'";}?>/>
      <label for="checkbox5"></label>
      ) Extrimitas</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. 
      <label for="textfield16"></label>
       <?=$data['therapy2']?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" height="30">Keterangan = 
      <?=$data['ket_res3']?></td>
    <td height="30">&nbsp;</td>
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
    <td>B.</td>
    <td>Makan dan Minum </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[20]" value="21" id="checkbox[]" disabled="disabled" <? if($isi_chk[20]=='21') { echo "checked='checked'";}?>/>
      <label for="checkbox21"></label>
      ) Aktual</td>
    <td>(
      <input type="checkbox" name="checkbox[21]" value="22" id="checkbox[]" disabled="disabled" <? if($isi_chk[21]=='22') { echo "checked='checked'";}?>/>
      <label for="checkbox22"></label>
      ) Resiko </td>
    <td>(
      <input type="checkbox" name="checkbox[22]" value="23" id="checkbox[]" disabled="disabled" <? if($isi_chk[22]=='23') { echo "checked='checked'";}?>/>
      <label for="checkbox46"></label>
      ) Timbang BB ( Pre dan Post HD )</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[23]" value="24" id="checkbox[]" disabled="disabled" <? if($isi_chk[23]=='24') { echo "checked='checked'";}?>/>
      <label for="checkbox78"></label>
      ) Cairan yang masuk selama HD</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>1. Diit</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[24]" value="25" id="checkbox[]" disabled="disabled" <? if($isi_chk[24]=='25') { echo "checked='checked'";}?>/>
      <label for="checkbox47"></label>
      ) Batasi intake cairan selama on HD</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp; (
      <input type="checkbox" name="checkbox[25]" value="26" id="checkbox[]" disabled="disabled" <? if($isi_chk[25]=='26') { echo "checked='checked'";}?>/>
      <label for="checkbox79"></label>
      ) &lt;500 ml &nbsp;&nbsp;&nbsp;&nbsp; (
      <input type="checkbox" name="checkbox[26]" value="27" id="checkbox[]" disabled="disabled" <? if($isi_chk[26]=='27') { echo "checked='checked'";}?>/>
      <label for="checkbox80"></label>
      ) 500-1000 ml </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>2. Cairan </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">(
      <input type="checkbox" name="checkbox[27]" value="28" id="checkbox[]" disabled="disabled" <? if($isi_chk[27]=='28') { echo "checked='checked'";}?>/>
      <label for="checkbox23"></label>
      ) Kelebihan volume cairan dalam tubuh</td>
    <td>(
      <input type="checkbox" name="checkbox[28]" value="29" id="checkbox[]" disabled="disabled" <? if($isi_chk[28]=='29') { echo "checked='checked'";}?>/>
      <label for="checkbox48"></label>
      ) Anjurkan batasi intake cairan ( 24 jam )</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[29]" value="30" id="checkbox[]" disabled="disabled" <? if($isi_chk[29]=='30') { echo "checked='checked'";}?>/>
      <label for="checkbox81"></label>
      ) Program HD</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">(
      <input type="checkbox" name="checkbox[30]" value="31" id="checkbox[]" disabled="disabled" <? if($isi_chk[30]=='31') { echo "checked='checked'";}?>/>
      <label for="checkbox7"></label>
      ) 500 s/d 1000 cc / 24 jam</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[31]" value="32" id="checkbox[]" disabled="disabled" <? if($isi_chk[31]=='32') { echo "checked='checked'";}?>/>
      <label for="checkbox49"></label>
      ) Program HD sesuai kebutuhan pasien</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp; 1 waktu  &nbsp;&nbsp;&nbsp;&nbsp; (
      <input type="checkbox" name="checkbox[32]" value="33" id="checkbox[]" disabled="disabled" <? if($isi_chk[32]=='33') { echo "checked='checked'";}?>/>
      <label for="checkbox82"></label>
      ) 2-4 jam</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" height="30">Keterangan = 
      <?=$data['ket_manmin']?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[33]" value="34" id="checkbox[]" disabled="disabled" <? if($isi_chk[33]=='34') { echo "checked='checked'";}?>/>
      <label for="checkbox50"></label>
      ) Kolaborasi dengan dokter</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (
      <input type="checkbox" name="checkbox[34]" value="35" id="checkbox[]" disabled="disabled" <? if($isi_chk[34]=='35') { echo "checked='checked'";}?>/>
      <label for="checkbox83"></label>
      ) 4-5 jam</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>3. Nafsu Makan </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td> (
      <input type="checkbox" name="checkbox[35]" value="36" id="checkbox[]" disabled="disabled" <? if($isi_chk[35]=='36') { echo "checked='checked'";}?>/>
      <label for="checkbox51"></label>
      ) Lakukan pemeriksaan laboratorium ( albumin dan Hb )</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (
      <input type="checkbox" name="checkbox[36]" value="37" id="checkbox[]" disabled="disabled" <? if($isi_chk[36]=='37') { echo "checked='checked'";}?>/>
      <label for="checkbox84"></label>
      ) &le; 3 liter</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[37]" value="38" id="checkbox[]" disabled="disabled" <? if($isi_chk[37]=='38') { echo "checked='checked'";}?>/>
      <label for="checkbox8"></label>
      ) Baik </td>
    <td>(
      <input type="checkbox" name="checkbox[38]" value="39" id="checkbox[]" disabled="disabled" <? if($isi_chk[38]=='39') { echo "checked='checked'";}?>/>
      <label for="checkbox9"></label>
      ) Kurang </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td> (
      <input type="checkbox" name="checkbox[39]" value="40" id="checkbox[]" disabled="disabled" <? if($isi_chk[39]=='40') { echo "checked='checked'";}?>/>
      <label for="checkbox52"></label>
      ) Therapy  &nbsp;&nbsp;: 1. 
      <?=$data['therapy3']?></td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (
      <input type="checkbox" name="checkbox[40]" value="41" id="checkbox[]" disabled="disabled" <? if($isi_chk[40]=='41') { echo "checked='checked'";}?>/>
      <label for="checkbox85"></label>
      ) 3-5 liter</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" height="30">Keterangan = 
      <?=$data['ket_manmin2']?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. 
      <?=$data['therapy4']?></td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (
      <input type="checkbox" name="checkbox[41]" value="42" id="checkbox[]" disabled="disabled" <? if($isi_chk[41]=='42') { echo "checked='checked'";}?>/>
      <label for="checkbox86"></label>
      ) &le; 200 m</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>4. Perdarahan </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">(
      <input type="checkbox" name="checkbox[42]" value="43" id="checkbox[]" disabled="disabled" <? if($isi_chk[42]=='43') { echo "checked='checked'";}?>/>
      <label for="checkbox24"></label>
      ) Resiko perubahan hemodinamik</td>
    <td>(
      <input type="checkbox" name="checkbox[43]" value="44" id="checkbox[]" disabled="disabled" <? if($isi_chk[43]=='44') { echo "checked='checked'";}?>/>
      <label for="checkbox53"></label>
      ) Observasi vital sign</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (
      <input type="checkbox" name="checkbox[44]" value="45" id="checkbox[]" disabled="disabled" <? if($isi_chk[44]=='45') { echo "checked='checked'";}?>/>
      <label for="checkbox87"></label>
      ) 200-250 ml/m</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[45]" value="46" id="checkbox[]" disabled="disabled" <? if($isi_chk[45]=='46') { echo "checked='checked'";}?>/>
      <label for="checkbox10"></label>
      ) Gusi </td>
    <td>(
      <input type="checkbox" name="checkbox[46]" value="47" id="checkbox[]" disabled="disabled" <? if($isi_chk[46]=='47') { echo "checked='checked'";}?>/>
      <label for="checkbox11"></label>
      ) Menstruasi </td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;&nbsp;&nbsp; &nbsp;dan kardiovaskuler</td>
    <td>(
      <input type="checkbox" name="checkbox[47]" value="48" id="checkbox[]" disabled="disabled" <? if($isi_chk[47]=='48') { echo "checked='checked'";}?>/>
      <label for="checkbox54"></label>
      ) Drip NaCl 0.9 % sesuai kebutuhan</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[48]" value="49" id="checkbox[]" disabled="disabled" <? if($isi_chk[48]=='49') { echo "checked='checked'";}?>/>
      <label for="checkbox88"></label>
      ) Kolaborasi dengan dokter</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" height="30">Keterangan = 
      <?=$data['ket_manmin3']?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[49]" value="50" id="checkbox[]" disabled="disabled" <? if($isi_chk[49]=='50') { echo "checked='checked'";}?>/>
      <label for="checkbox55"></label>
      ) Atur posisi datar / tidur tanpa bantal</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;.................................................</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">(
      <input type="checkbox" name="checkbox[50]" value="51" id="checkbox[]" disabled="disabled" <? if($isi_chk[50]=='51') { echo "checked='checked'";}?>/>
      <label for="checkbox25"></label>
      ) Resiko perdarahan</td>
    <td>(
      <input type="checkbox" name="checkbox[51]" value="52" id="checkbox[]" disabled="disabled" <? if($isi_chk[51]=='52') { echo "checked='checked'";}?>/>
      <label for="checkbox56"></label>
      ) Kolaborasi dengan dokter</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;.................................................</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[52]" value="53" id="checkbox[]" disabled="disabled" <? if($isi_chk[52]=='53') { echo "checked='checked'";}?>/>
      <label for="checkbox57"></label>
      ) Therapy  &nbsp;&nbsp;: 1. 
      <?=$data['therapy5']?></td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;.................................................</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. 
      <?=$data['therapy6']?></td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;.................................................</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[53]" value="54" id="checkbox[]" disabled="disabled" <? if($isi_chk[53]=='54') { echo "checked='checked'";}?>/>
      <label for="checkbox58"></label>
      ) Pembenan heparin minimal</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[54]" value="55" id="checkbox[]" disabled="disabled" <? if($isi_chk[54]=='55') { echo "checked='checked'";}?>/>
      <label for="checkbox94"></label>
      ) Tidak ada perdarahan </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" height="30">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[55]" value="56" id="checkbox[]" disabled="disabled" <? if($isi_chk[55]=='56') { echo "checked='checked'";}?>/>
      <label for="checkbox59"></label>
      ) Jika HD tanpa heparin, bilas dengan NaCl 0.9 %</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[56]" value="57" id="checkbox[]" disabled="disabled" <? if($isi_chk[56]=='57') { echo "checked='checked'";}?>/>
      <label for="checkbox93"></label>
      ) Ada perdarahan </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[57]" value="58" id="checkbox[]" disabled="disabled" <? if($isi_chk[57]=='58') { echo "checked='checked'";}?>/>
      <label for="checkbox60"></label>
      ) Observasi keluhan pasien on HD</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(
      <input type="checkbox" name="checkbox[58]" value="59" id="checkbox[]" disabled="disabled" <? if($isi_chk[58]=='59') { echo "checked='checked'";}?>/>
      <label for="checkbox92"></label>
      ) Kolaborasi dengan dokter</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[59]" value="60" id="checkbox[]" disabled="disabled" <? if($isi_chk[59]=='60') { echo "checked='checked'";}?>/>
      <label for="checkbox61"></label>
      ) Kolaborasi dengan dokter</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;th/.......................................</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td> (
      <input type="checkbox" name="checkbox[60]" value="61" id="checkbox[]" disabled="disabled" <? if($isi_chk[60]=='61') { echo "checked='checked'";}?>/>
      <label for="checkbox62"></label>
      ) Therapy  &nbsp;&nbsp;: 1. 
      <?=$data['therapy7']?></td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...........................................</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. 
      <?=$data['therapy8']?></td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...........................................</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" height="30">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>C.</td>
    <td>Kulit / Turgor </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[61]" value="62" id="checkbox[]" disabled="disabled" <? if($isi_chk[61]=='62') { echo "checked='checked'";}?>/>
      <label for="checkbox26"></label>
      ) Aktual</td>
    <td>(
      <input type="checkbox" name="checkbox[62]" value="63" id="checkbox[]" disabled="disabled" <? if($isi_chk[62]=='63') { echo "checked='checked'";}?>/>
      <label for="checkbox27"></label>
      ) Resiko </td>
    <td>(
      <input type="checkbox" name="checkbox[63]" value="64" id="checkbox[]" disabled="disabled" <? if($isi_chk[63]=='64') { echo "checked='checked'";}?>/>
      <label for="checkbox63"></label>
      ) Jelaskan tentang gangguan integritas kulit</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[64]" value="65" id="checkbox[]" disabled="disabled" <? if($isi_chk[64]=='65') { echo "checked='checked'";}?>/>
      <label for="checkbox91"></label>
      ) Pasien mengerti setelah dijelaskan </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[65]" value="66" id="checkbox[]" disabled="disabled" <? if($isi_chk[65]=='66') { echo "checked='checked'";}?>/>
      <label for="checkbox12"></label>
      ) Elastis </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[66]" value="67" id="checkbox[]" disabled="disabled" <? if($isi_chk[66]=='67') { echo "checked='checked'";}?>/>
      <label for="checkbox64"></label>
      ) Anjurkan HD rutin sesuai dengan instruksi dokter</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;tentang gangguan kulit</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[67]" value="68" id="checkbox[]" disabled="disabled" <? if($isi_chk[67]=='68') { echo "checked='checked'";}?>/>
      <label for="checkbox13"></label>
      ) Tidak Elastis </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">(
      <input type="checkbox" name="checkbox[68]" value="69" id="checkbox[]" disabled="disabled" <? if($isi_chk[68]=='69') { echo "checked='checked'";}?>/>
      <label for="checkbox28"></label>
      ) Gangguan Integritas kulit</td>
    <td>(
      <input type="checkbox" name="checkbox[69]" value="70" id="checkbox[]" disabled="disabled" <? if($isi_chk[69]=='70') { echo "checked='checked'";}?>/>
      <label for="checkbox65"></label>
      ) Kolaborasi dengan dokter</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" height="30">Keterangan =
      <?=$data['ket_kulit']?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td> (
      <input type="checkbox" name="checkbox[70]" value="71" id="checkbox[]" disabled="disabled" <? if($isi_chk[70]=='71') { echo "checked='checked'";}?>/>
      <label for="checkbox66"></label>
      ) Therapy  &nbsp;&nbsp;: 1. 
      <?=$data['therapy9']?></td>
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
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. 
      <?=$data['therapy10']?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>D.</td>
    <td>Eliminasi</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[71]" value="72" id="checkbox[]" disabled="disabled" <? if($isi_chk[71]=='72') { echo "checked='checked'";}?>/>
      <label for="checkbox30"></label>
      ) Aktual</td>
    <td>(
      <input type="checkbox" name="checkbox[72]" value="73" id="checkbox[]" disabled="disabled" <? if($isi_chk[72]=='73') { echo "checked='checked'";}?> />
      <label for="checkbox29"></label>
      ) Resiko </td>
    <td>(
      <input type="checkbox" name="checkbox[73]" value="74" id="checkbox[]" disabled="disabled" <? if($isi_chk[73]=='74') { echo "checked='checked'";}?>/>
      <label for="checkbox67"></label>
      ) Berikan penjelasan tentang perubahan eliminasi ( BAK / BAB) </td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[74]" value="75" id="checkbox[]" disabled="disabled" <? if($isi_chk[74]=='75') { echo "checked='checked'";}?>/>
      <label for="checkbox90"></label>
      ) Pasien mengerti setelah dijelaskan </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>1. BAK </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp; pada pasien</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;tentang perubahan BAK / BAB</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[75]" value="76" id="checkbox[]" disabled="disabled" <? if($isi_chk[75]=='76') { echo "checked='checked'";}?>/>
      <label for="checkbox14"></label>
      ) Anuri </td>
    <td>(
      <input type="checkbox" name="checkbox[76]" value="77" id="checkbox[]" disabled="disabled" <? if($isi_chk[76]=='77') { echo "checked='checked'";}?>/>
      <label for="checkbox15"></label>
      ) Oliguri </td>
    <td>&nbsp;</td>
    <td colspan="2">(
      <input type="checkbox" name="checkbox[77]" value="78" id="checkbox[]" disabled="disabled" <? if($isi_chk[77]=='78') { echo "checked='checked'";}?>/>
      <label for="checkbox31"></label>
      ) Perubahan eliminasi BAK</td>
    <td>(
      <input type="checkbox" name="checkbox[78]" value="79" id="checkbox[]" disabled="disabled" <? if($isi_chk[78]=='79') { echo "checked='checked'";}?>/>
      <label for="checkbox68"></label>
      ) Anjurkan makan tinggi serat</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" height="30">Keterangan =
      <?=$data['ket_eli']?></td>
    <td colspan="2">(
      <input type="checkbox" name="checkbox[79]" value="80" id="checkbox[]" disabled="disabled" <? if($isi_chk[79]=='80') { echo "checked='checked'";}?>/>
      <label for="checkbox32"></label>
      ) Perubahan eliminasi BAB</td>
    <td>(
      <input type="checkbox" name="checkbox[80]" value="81" id="checkbox[]" disabled="disabled" <? if($isi_chk[80]=='81') { echo "checked='checked'";}?>/>
      <label for="checkbox69"></label>
      ) Anjurkan kepada pasien mobilisasi aktif semampunya</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>2. BAB</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[81]" value="82" id="checkbox[]" disabled="disabled" <? if($isi_chk[81]=='82') { echo "checked='checked'";}?>/>
      <label for="checkbox70"></label>
      ) Kolaborasi dengan dokter</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[82]" value="83" id="checkbox[]" disabled="disabled" <? if($isi_chk[82]=='83') { echo "checked='checked'";}?>/>
      <label for="checkbox16"></label>
      ) Normal </td>
    <td>(
      <input type="checkbox" name="checkbox[83]" value="84" id="checkbox[]" disabled="disabled" <? if($isi_chk[83]=='84') { echo "checked='checked'";}?>/>
      <label for="checkbox17"></label>
      ) Kostipasi </td>
    <td>(
      <input type="checkbox" name="checkbox[84]" value="85" id="checkbox[]" disabled="disabled" <? if($isi_chk[84]=='85') { echo "checked='checked'";}?>/>
      <label for="checkbox18"></label>
      ) Diare </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td> (
      <input type="checkbox" name="checkbox[85]" value="86" id="checkbox[]" disabled="disabled" <? if($isi_chk[85]=='86') { echo "checked='checked'";}?>/>
      <label for="checkbox66"></label>
      ) Therapy  &nbsp;&nbsp;: 1.
  <?=$data['therapy11']?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3" height="30">Keterangan =
      <?=$data['ket_eli2']?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.
      <?=$data['therapy12']?></td>
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
    <td>E.</td>
    <td>Tidur dan Istirahat </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[86]" value="87" id="checkbox[]" disabled="disabled" <? if($isi_chk[86]=='87') { echo "checked='checked'";}?>/>
      <label for="checkbox33"></label>
      ) Aktual</td>
    <td>(
      <input type="checkbox" name="checkbox[87]" value="88" id="checkbox[]" disabled="disabled" <? if($isi_chk[87]=='88') { echo "checked='checked'";}?>/>
      <label for="checkbox34"></label>
      ) Resiko </td>
    <td>(
      <input type="checkbox" name="checkbox[88]" value="89" id="checkbox[]" disabled="disabled" <? if($isi_chk[88]=='89') { echo "checked='checked'";}?>/>
      <label for="checkbox71"></label>
      ) Berikan penjelasan tentang gangguan istirahat ( tidur ) </td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[89]" value="90" id="checkbox[]" disabled="disabled" <? if($isi_chk[89]=='90') { echo "checked='checked'";}?>/>
      <label for="checkbox89"></label>
      ) Pasien mengerti setelah dijelaskan </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[90]" value="91" id="checkbox[]" disabled="disabled" <? if($isi_chk[90]=='91') { echo "checked='checked'";}?>/>
      <label for="checkbox19"></label>
      ) Normal </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp; pada pasien</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;tentang gangguan tidur</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[91]" value="92" id="checkbox[]" disabled="disabled" <? if($isi_chk[91]=='92') { echo "checked='checked'";}?>/>
      <label for="checkbox20"></label>
      ) Sulit tidur </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">(
      <input type="checkbox" name="checkbox[92]" value="93" id="checkbox[]" disabled="disabled" <? if($isi_chk[92]=='93') { echo "checked='checked'";}?>/>
      <label for="checkbox35"></label>
      ) Gangguan istirahat tidur</td>
    <td>(
      <input type="checkbox" name="checkbox[93]" value="94" id="checkbox[]" disabled="disabled" <? if($isi_chk[93]=='94') { echo "checked='checked'";}?>/>
      <label for="checkbox72"></label>
      ) Kaji pola istirahat ( tidur ) pasien</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">Keterangan =
      <?=$data['ket_tdristrht']?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>(
      <input type="checkbox" name="checkbox[94]" value="95" id="checkbox[]" disabled="disabled" <? if($isi_chk[94]=='95') { echo "checked='checked'";}?>/>
      <label for="checkbox73"></label>
      ) Kolaborasi dengan dokter</td>
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
    <td> (
      <input type="checkbox" name="checkbox[95]" value="96" id="checkbox[]" disabled="disabled" <? if($isi_chk[95]=='96') { echo "checked='checked'";}?>/>
      <label for="checkbox66"></label>
      ) Therapy  &nbsp;&nbsp;: 1.
  <?=$data['therapy13']?></td>
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
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.
      <?=$data['therapy14']?></td>
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
  <tr id="trTombol">
    <td colspan="9" align="center"><div align="center"><span class="noline">
      <input name="button" type="button" id="btnPrint" onclick="cetak(document.getElementById('trTombol'));" value="Print/Cetak" />
      <input name="button" type="button" id="btnTutup" onclick="tutup();" value="Tutup"/>
    </span></div></td>
    </tr>
</table>
</body>
<script type="text/JavaScript">

            function cetak(tombol){
                tombol.style.visibility='collapse';
                if(tombol.style.visibility=='collapse'){
                    if(confirm('Cetak permintaan Pemeriksaan Lab  ?')){
                        setTimeout('window.print()','1000');
                        setTimeout('window.close()','2000');
                    }
                    else{
                        tombol.style.visibility='visible';
                    }

                }
            }
			
function tutup(){
	window.close();
	}
        </script>
</html>
