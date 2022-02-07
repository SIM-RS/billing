<?
include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk, a.ku as ku2, a.kesadaran as kes2,
a.bb as bb2, a.tensi as tensi2, a.rr as rr2, a.suhu as suhu2, a.nadi as nadi2
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN anamnese a ON a.KUNJ_ID=pl.kunjungan_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
//include "setting.php";
?>
<?php

$dG=mysql_fetch_array(mysql_query("select * from b_ms_penolakan_pemberian_darah where id='$_REQUEST[id]'"));
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
        <script type="text/javascript" src="../js/jquery.timeentry.js"></script>
<script>
$(function () 
{
	$('#jam').timeEntry({show24Hours: true, showSeconds: true});
});
</script>
        <script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>
<title>Form Penolakan Pemberian Darah</title>
<style type="text/css">
<!--
.style3 {font-size: 18px}
-->
</style>
</head>
<style>
        .gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:80px;
	}
.textArea{ width:97%;}
body{background:#FFF;}
        .style5 {font-size: 12}
.style6 {font-size: 12px}
</style>
<title>resume kep</title>
<?
//include "setting2.php";
?>

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
<div id="tampil_input" style="display:block">
<form id="form1" name="form1" action="form_penolakan_pemberian_darah_act.php">

<input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="id" id="id"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
<table width="800" border="0" style="font:12px tahoma;">
  <tr>
    <td width="336"><img src="../catatan_pelaksanaan_transfusi/lambang.png" width="278" height="30" /></td>
    <td width="515"><table width="310" align="right" cellpadding="0" cellspacing="0" style="border:1px solid #000000; font:12px tahoma;">
      <col width="64" />
      <col width="92" />
      <col width="9" />
      <col width="64" span="3" />
      <tr height="20">
        <td width="13" height="20"></td>
        <td width="143">NRM</td>
        <td width="9">:</td>
        <td colspan="3"><?=$dP['no_rm'];?></td>
        </tr>
      <tr height="20">
        <td height="20"></td>
        <td>Nama</td>
        <td>:</td>
        <td colspan="3"><?=$dP['nama'];?></td>
        </tr>
      <tr height="20">
        <td height="20"></td>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td width="64"><span <?php if($dP['sex']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($dP['sex']=='P'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>P</span></td>
        <td width="64"></td>
        <td width="64"></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>Tanggal Lahir</td>
        <td>:</td>
        <td colspan="3"><?=tglSQL($dP['tgl_lahir']);?></td>
        </tr>
      <tr height="20">
        <td height="20"></td>
        <td colspan="5">(Mohon diisi atau tempelkan stiker jika ada)</td>
      </tr>
      </table></td>
  </tr>
  <tr>
    <td colspan="2" style="font:bold 16px tahoma;"><table cellspacing="0" cellpadding="0" style="border:1px solid #000000; font:12px tahoma;">
      <col width="64" />
      <col width="85" />
      <col width="64" span="5" />
      <col width="82" />
      <col width="64" span="3" />
      <tr height="20">
        <td height="20" width="1"></td>
        <td width="5"></td>
        <td width="62"></td>
        <td width="4"></td>
        <td width="17"></td>
        <td width="4"></td>
        <td width="62"></td>
        <td width="4"></td>
        <td width="4"></td>
        <td width="4"></td>
        <td width="114"></td>
        <td colspan="2"></td>
        <td width="116"></td>
        <td width="13"></td>
        <td width="24"></td>
        <td></td>
        <td width="79"></td>
        <td width="4"></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td colspan="18"><div align="center" class="style4"><strong>FORMULIR PENOLAKAN PEMBERIAN DARAH DAN PRODUK    DARAH</strong></div></td>
        <td width="31"></td>
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
        <td colspan="2"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td colspan="7">Nama Pasien</td>
        <td>:</td>
        <td colspan="3">&nbsp;<?=$dP['nama'];?></td>
        <td>No. Rekan Medik </td>
        <td colspan="3">:
          <?=$dP['no_rm'];?></td>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td colspan="7">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td colspan="7">Tanggal lahir</td>
        <td>:</td>
        <td colspan="3">&nbsp;<?=tglSQL($dP['tgl_lahir']);?></td>
        <td>Jenis Kalamin</td>
        <td colspan="4">: <span <?php if($dP['sex']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>Laki-Laki</span> / <span <?php if($dP['sex']=='P'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>Perempuan</span></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td colspan="7">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width="81"></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td colspan="7">Diagnosa</td>
        <td>:</td>
        <td colspan="3">
          <table width="100%" border="0">
            <?php $sqlD="SELECT md.nama FROM b_diagnosa d
LEFT JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
LEFT JOIN b_kunjungan k ON k.id=d.kunjungan_id
WHERE d.pelayanan_id='$idPel';";
$exD=mysql_query($sqlD);
while($dD=mysql_fetch_array($exD)){
?>
            <tr>
              <td ><?=$dD['nama']?></td>
              </tr>
            <?php }?>
            <tr>
              <td >&nbsp;</td>
              </tr>
          </table></td>
        <td></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td colspan="9">Saya yang bertanda tangan di bawah ini,</td>
        <td colspan="2">&nbsp;</td>
        <td></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td colspan="8">&nbsp;</td>
        <td colspan="8">&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td colspan="5">Nama</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>:</td>
        <td colspan="8">
<label for="textfield"></label>
          <?=$dG['nama1']?></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td colspan="8">&nbsp;</td>
        <td>&nbsp;</td>
        <td width="38">&nbsp;</td>
        <td width="131">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="4">&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td colspan="7">Tanggal Lahir/Umur</td>
        <td>:</td>
        <td>
<label for="textfield"></label>
<?=tglSQL($dG['tgl_lahir'])?>
          </td>
        <td colspan="7"> &nbsp;/&nbsp;Umur :&nbsp;<?=$dG['umur']?>
          &nbsp;Tahun,<!--&nbsp;&nbsp;<input type="text" style="text-align:center;" value="0" name="Bln" id="Bln" size="3" tabindex="12" onKeyUp="gantiTgl(this.id)"/>&nbsp;Bln
                        &nbsp;&nbsp;<input type="text" style="text-align:center;" value="0" name="hari" id="hari" size="3" tabindex="12" onKeyUp="gantiTgl(this.id)"/>&nbsp;Hr-->          &nbsp;&nbsp;Jenis Kelamin:
          <label for="jenis_kelamin"></label>
          <?=$dG['jenis_kelamin']?></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td colspan="8">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td colspan="6">Alamat</td>
        <td>&nbsp;</td>
        <td>:</td>
        <td colspan="7" rowspan="2"><label for="textfield2"></label>
          <textarea disabled="disabled" name="alamat" cols="40" id="alamat"><?=$dG['alamat']?>
          </textarea></td>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td colspan="8">&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td colspan="8">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td colspan="5">No. Telp</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>:</td>
        <td colspan="7"><label for="textfield3"></label>
          <?=$dG['no_telp']?>          No. KTP/SIM: 
          <label for="textfield4"></label>
          <?=$dG['no_ktp']?></td>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td colspan="8">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td colspan="12">Hubungan dengan pihak yang diwakili &nbsp;        : 
          <label for="select2"></label>
          <?=$dG['hubungan']?></td>
        <td colspan="3"><label for="jenis_kelamin"></label></td>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td colspan="10">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
      </tr>
      <?php 
	  $isi=explode(",",$dG['sehingga']);
	  ?>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td align="justify" colspan="17">telah membaca atau dibacakan keterangan pada <strong>form edukasi transfusi darah</strong> dan telah dijelaskan hal-hal terkait mengenai<br />
          prosedur transfusi darah yang akan dilakukan terhadap diri saya sendiri /    pihak yang saya wakili *), sehingga saya,</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td align="justify" colspan="17">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td align="justify" colspan="17"><label>
          <input disabled="disabled" type="checkbox" id="c_chk[]" name="c_chk[0]" value="1" <? if($isi[0]=='1') { echo "checked='checked'";}?> />
        </label>
Memahami alasan saya / pihak yang saya wakili    memerlukan darah dan produk darah</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td align="justify" colspan="17"><label>
          <input disabled="disabled" name="c_chk[1]" type="checkbox" id="c_chk[]" value="2" <? if($isi[1]=='2') { echo "checked='checked'";}?> />
        </label>
memahami resiko yang mungkin terjadi saat atau    sesudah pelaksanaan pemberian darah dan produk darah</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td align="justify" colspan="17"><label>
          <input disabled="disabled"name="c_chk[2]" type="checkbox" id="c_chk[]" value="3" <? if($isi[2]=='3') { echo "checked='checked'";}?> />
        </label>
memahami alternatif pemberian darah    dan produk darah</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td align="justify" colspan="17">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td align="justify" colspan="17">dan saya menyatakan untuk</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td align="justify" colspan="17">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20" colspan="20" align="center"><strong>TIDAK SETUJU</strong></td>
        </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td align="justify" colspan="17">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td align="justify" colspan="17">atas pemberian darah dan produk    darah terhadap diri saya sendiri / pihak yang saya wakili, dengan alasan:</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td colspan="17" rowspan="2" align="justify"><label for="textfield5"></label>
          <textarea disabled="disabled" name="alasan" cols="70" id="alasan"><?=$dG['alasan']?></textarea></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td align="justify" colspan="9">Tanggal:
          <label for="textfield6"></label>
          <?=tglSQL($dG['tgl'])?></td>
        <td align="justify">Jam</td>
        <td colspan="3" align="justify">:
          <label for="textfield7"></label>
          <?=$dG['jam']?></td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td align="justify" colspan="17">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td colspan="8" align="justify"><strong>Yang menyatakan</strong></td>
        <td colspan="2" align="center"><strong>Dokter</strong></td>
        <td align="center">&nbsp;</td>
        <td colspan="2" align="center"><strong>Saksi 1</strong></td>
        <td colspan="5" align="center"><strong>Saksi 2</strong></td>
        </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td colspan="7" align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td colspan="7" align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td colspan="7" align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td colspan="7" align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td colspan="7" align="justify">(
          <?=$dG['nama1']?>
          )</td>
        <td align="justify">&nbsp;</td>
        <td colspan="2" align="center"><?=$dP['dr_rujuk'];?></td>
        <td align="center">&nbsp;</td>
        <td colspan="2" align="center"><label for="textfield9"></label>
          <?=$dG['saksi1']?></td>
        <td colspan="5" align="center"><label for="textfield8"></label>
          <?=$dG['saksi2']?></td>
        </tr>
      <tr height="20">
        <td height="20"></td>
        <td>&nbsp;</td>
        <td colspan="7" align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td colspan="2" align="center">&nbsp;</td>
        <td align="justify"><label for="textfield6"></label></td>
        <td align="justify"><label for="textfield7"></label></td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td align="justify">&nbsp;</td>
        <td></td>
      </tr>
      </table></td>
  </tr>
  <tr>
    <td colspan="2"><table width="800" border="0" align="center">
      <tr>
        <td width="790"></td>
      </tr>
      <tr>
        <td align="center"><button onclick="window.print()" type="button">Print</button>&nbsp;
	<button onclick="window.close()" type="button">Close</button></td>
      </tr>
      </table></td>
  </tr>
</table>
</form>
</div>
<div id="tampil_data" align="center"></div>
</body>
</html>
