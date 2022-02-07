<?php
//session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUser'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,
k.cara_keluar, a.bb as bb2, a.tb as tb2, IFNULL(pg.nama,'-') AS dr_rujuk,
CONCAT((CONCAT((CONCAT((CONCAT(p.alamat,' RT.',p.rt)),' RW.',p.rw)),', Desa ',w.nama)),', Kecamatan ',wi.nama) alamat_, ku.no_reg as no_reg2
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_pasien_keluar k ON k.pelayanan_id=pl.id
LEFT JOIN anamnese a ON a.KUNJ_ID=pl.kunjungan_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN b_ms_wilayah w
		ON p.desa_id = w.id
	LEFT JOIN b_ms_wilayah wi
		ON p.kec_id = wi.id
LEFT JOIN b_kunjungan ku
    ON ku.id=pl.kunjungan_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$sqlKm="SELECT tk.tgl_in,tk.tgl_out FROM b_tindakan_kamar tk 
LEFT JOIN b_pelayanan p ON p.id=tk.pelayanan_id
WHERE tk.pelayanan_id='$idPel';";
$dK=mysql_fetch_array(mysql_query($sqlKm));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));
?>
<?php

$dG=mysql_fetch_array(mysql_query("select * from b_vaccination where id='$_REQUEST[id]'"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
        <script type="text/javascript" language="JavaScript" src="../../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../../jquery.js"></script>
        <script type="text/javascript" src="../../jquery.form.js"></script>
        <script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>
<title>VACCINATION SCREENING</title>
<style>
        .gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:80px;
	}
.textArea{ width:97%;}
body{background:#FFF;}
        </style>
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
<iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
             <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js" src="../../theme/popcjs.php" scrolling="no" frameborder="1"
                style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe> 
<div id="form_in" style="display:block;">
<form name="form1" id="form1" action="2.permohonankonsultasi_act.php">
    <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="id" id="id"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
<table width="766" border="0" style="font:12px tahoma;">
  <tr>
    <td width="379" valign="bottom"><span style="font:bold 15px tahoma;">VACCINATION SCREENING</span></td>
    <td width="379"><table width="496" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
      <tr>
        <td width="124">Nama Pasien</td>
        <td width="173">:
          <?=$dP['nama'];?></td>
        <td width="75"><span <?php if($dP['sex']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($dP['sex']=='P'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>P</span></td>
        <td width="104">&nbsp;</td>
        </tr>
      <tr>
        <td>Tanggal Lahir</td>
        <td>:
          <?=tglSQL($dP['tgl_lahir']);?></td>
        <td>Usia</td>
        <td>:
          <?=$dP['usia'];?>
          &nbsp;Thn</td>
        </tr>
      <tr>
        <td>No. RM</td>
        <td>:
          <?=$dP['no_rm'];?></td>
        <td>No Registrasi </td>
        <td>: <?=$dP['no_reg2'];?></td>
        </tr>
      <tr>
        <td>Ruang Rawat/Kelas</td>
        <td>:
          <?=$dP['nm_unit'];?>
          /
          <?=$dP['nm_kls'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>Alamat</td>
        <td colspan="2">:
          <?=$dP['alamat_'];?></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4" align="center">(Tempelkan Sticker Identitas Pasien)</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td colspan="2"><table cellspacing="0" cellpadding="2" style="border:1px solid #000000;">
      <col width="27" />
      <col width="64" />
      <col width="20" />
      <col width="138" />
      <col width="20" />
      <col width="64" />
      <col width="51" />
      <col width="99" />
      <col width="13" />
      <col width="92" />
      <col width="49" />
      <col width="58" />
      <col width="54" />
      <col width="37" />
      <tr height="20">
        <td height="20" width="21">&nbsp;</td>
        <td width="60"></td>
        <td width="20"></td>
        <td width="125"></td>
        <td width="16"></td>
        <td width="57"></td>
        <td width="59"></td>
        <td width="74"></td>
        <td width="11"></td>
        <td width="82"></td>
        <td width="43"></td>
        <td width="51"></td>
        <td width="47"></td>
        <td width="36"></td>
        </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3">Tanggal Pelaksanaan Vaksinasi<br>
          <em>Date of vaccination</em></td>
        <td>:</td>
        <td colspan="5"><label for="dokter"></label>
          <label for="textfield"></label>
          <?=tglSQL($dG['tgl']);?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
      <tr height="">
        <td colspan="14" style="border-bottom:1px solid #000">&nbsp;</td>
        </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="12">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="6">1. Apakah anda sakit hari ini ?<br>
          <em>&nbsp;&nbsp;&nbsp;&nbsp;Are you suffering from any illness at the moment ?</em></td>
        <td>&nbsp;</td>
        <td colspan="2"><label for="checkbox">
          <input disabled="disabled" type="radio" name="radio[0]" id="radio[]" value="1" <? if ($dG['sakit']=='1') { echo "checked='checked'";}?> />
        Ya / <em>Yes</em></label></td>
        <td colspan="2"><input disabled="disabled" type="radio" name="radio[0]" id="radio[]" value="2" <? if ($dG['sakit']=='2') { echo "checked='checked'";}?> />
          <label for="checkbox2">Tidak / <em>No</em></label></td>
        <td>&nbsp;</td>
        <td></td>
        </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="6">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="6">2. Penyakit apa yang pernah atau saat ini Anda derita?<br />
          <em>&nbsp;&nbsp;&nbsp;What illness/disease have you suffered before or currently ?</em></td>
        <td>&nbsp;</td>
        <td colspan="6"><label for="textfield2"></label>
          <?=$dG['derita'];?></td>
        </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="6">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="6">3. Adakah terapi/obat yang secara rutin/dalam jangka lama<br />
        &nbsp;&nbsp;&nbsp;&nbsp;yang anda dapatkan?<br />
          <em>&nbsp;&nbsp;&nbsp;&nbsp;Are you taking any routine theraphi/medication ?</em></td>
        <td>&nbsp;</td>
        <td colspan="2"><label for="checkbox5">
          <input disabled="disabled" type="radio" name="radio[1]" id="radio[]" value="1" <? if ($dG['terapi']=='1') { echo "checked='checked'";}?> />
          Ya / <em>Yes</em></label></td>
        <td colspan="2"><input disabled="disabled" type="radio" name="radio[1]" id="radio[]" value="2" <? if ($dG['terapi']=='2') { echo "checked='checked'";}?> />
          <label for="checkbox4">Tidak / <em>No</em></label></td>
        <td>&nbsp;</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="6">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;Jika Ya, Sebutkan<br />
          <em>&nbsp;&nbsp;&nbsp;&nbsp;If yes, mention</em></td>
        <td>&nbsp;</td>
        <td colspan="6"><label for="textfield3"></label>
          <?=$dG['sebut'];?></td>
        </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="6">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="6">4. Pilih sesuai kondisi kesehatan anda<br />
          <em>&nbsp;&nbsp;&nbsp;&nbsp;Choose according to your medical condition</em></td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;* Alergi Obat / <em>Drug Allergy</em></td>
        <td>&nbsp;</td>
        <td colspan="2"><label for="checkbox5">
          <input disabled="disabled" type="radio" name="radio[2]" id="radio[]" value="1" <? if ($dG['obat']=='1') { echo "checked='checked'";}?> />
          Ya / <em>Yes</em></label></td>
        <td colspan="2"><input disabled="disabled" type="radio" name="radio[2]" id="radio[]" value="2" <? if ($dG['obat']=='2') { echo "checked='checked'";}?> />
          <label for="checkbox4">Tidak / <em>No</em></label></td>
        <td>&nbsp;</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;* Alergi Makanan (telur/protein) /<br /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>Allergy of food (egg/protein)</em></td>
        <td>&nbsp;</td>
        <td colspan="2"><label for="checkbox6">
          <input disabled="disabled" type="radio" name="radio[3]" id="radio[]" value="1" <? if ($dG['makanan']=='1') { echo "checked='checked'";}?> />
          Ya / <em>Yes</em></label></td>
        <td colspan="2"><input disabled="disabled" type="radio" name="radio[3]" id="radio[]" value="2" <? if ($dG['makanan']=='2') { echo "checked='checked'";}?> />
          <label for="checkbox6">Tidak / <em>No</em></label></td>
        <td>&nbsp;</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;* Alergi Reaksi imunisasi sebelumnya /<br />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <em>Allergy Immunization rection previously</em></td>
        <td>&nbsp;</td>
        <td colspan="2"><label for="checkbox7">
          <input disabled="disabled" type="radio" name="radio[4]" id="radio[]" value="1" <? if ($dG['reaksi']=='1') { echo "checked='checked'";}?> />
          Ya / <em>Yes</em></label></td>
        <td colspan="2"><input disabled="disabled" type="radio" name="radio[4]" id="radio[]" value="2" <? if ($dG['reaksi']=='2') { echo "checked='checked'";}?> />
          <label for="checkbox7">Tidak / <em>No</em></label></td>
        <td>&nbsp;</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="6">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="6">5. Wanita: Apakah kondisi saat ini dalam keadan hamil atau<br />
          &nbsp;&nbsp;&nbsp;&nbsp;kemungkinan akan atau berencana hamil dalam beberapa<br />
          &nbsp;&nbsp;&nbsp;&nbsp;bulan berikut ?<br />
          <em>&nbsp;&nbsp;&nbsp;&nbsp;Female: Are you pregnant, or planning to get pregnant</em><br />
          <em>&nbsp;&nbsp;&nbsp;&nbsp;in the next few mounths ?</em></td>
        <td>&nbsp;</td>
        <td colspan="2"><label for="checkbox8">
          <input disabled="disabled" type="radio" name="radio[5]" id="radio[]" value="1" <? if ($dG['wanita']=='1') { echo "checked='checked'";}?> />
          Ya / <em>Yes</em></label></td>
        <td colspan="2"><input disabled="disabled" type="radio" name="radio[5]" id="radio[]" value="2" <? if ($dG['wanita']=='2') { echo "checked='checked'";}?> />
          <label for="checkbox8">Tidak / <em>No</em></label></td>
        <td>&nbsp;</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="6">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="6">6. Apakah anda pernah mendapat vaksinasi dalam 4 minggu<br />
          &nbsp;&nbsp;&nbsp;&nbsp;sebelum ini ?<br />
          <em>&nbsp;&nbsp;&nbsp;&nbsp;Have you reseived any vaccination in the previous </em><br />
          <em>&nbsp;&nbsp;&nbsp;&nbsp;4 mounth ?</em></td>
        <td>&nbsp;</td>
        <td colspan="2"><label for="checkbox9">
          <input disabled="disabled" type="radio" name="radio[6]" id="radio[]" value="1" <? if ($dG['vaksinasi']=='1') { echo "checked='checked'";}?> />
          Ya / <em>Yes</em></label></td>
        <td colspan="2"><input disabled="disabled" type="radio" name="radio[6]" id="radio[]" value="2" <? if ($dG['vaksinasi']=='2') { echo "checked='checked'";}?> />
          <label for="checkbox9">Tidak / <em>No</em></label></td>
        <td>&nbsp;</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="6">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="6">7. Riwayat vaksinasi sebelumnya, jika &quot;Ya&quot; sebutkan<br />
          <em>&nbsp;&nbsp;&nbsp;&nbsp;Vaccination history, please provide detail</em><br /></td>
        <td>&nbsp;</td>
        <td colspan="6"><?=$dG['riwayat'];?></td>
        </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="6">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
        <td colspan="2">Tanggal /<em>Date</em></td>
        <td colspan="4" >:&nbsp;<?php echo tgl_ina(date("Y-m-d"))?></td>
        </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td colspan="2">Jam /<em>Time</em></td>
        <td colspan="4" >: 
          <?=date('h:i:s');?></td>
        </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3" align="center">Diisi oleh/<em>Signed by</em></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="6"><div align="center">Diketahui / <em>Acknowledged</em></div></td>
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
        <td colspan="3" align="center">(
          <strong><u><?=$dP['nama'];?></u></strong>
          )</td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="6"><div align="center">(<strong><u><?=$dP['dr_rujuk'];?></u></strong>)</div></td>
        <td></td>
        </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3" align="center">Nama & Tanda Tangan<br /><em>Name and signature</em></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="6" align="center">Nama &amp; Tanda Tangan<br />
          <em>Name and signature</em></td>
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
      </table>
      
      <tr id="trTombol">
        <td class="noline"	 align="center" colspan="11">     
           <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" 

/>
          <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/></td>
   </tr>
      
      </td>
  </tr>
  
</table>
</form>
</div>

</body>
</html>

<script>
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
