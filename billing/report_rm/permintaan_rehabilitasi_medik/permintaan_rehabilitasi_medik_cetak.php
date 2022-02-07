<?php
//session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUser'];
$sqlP="SELECT p.*,bk.no_reg,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,
CONCAT((CONCAT((CONCAT((CONCAT(p.alamat,' RT.',p.rt)),' RW.',p.rw)),', Desa ',w.nama)),', Kecamatan ',wi.nama) alamat_,
k.cara_keluar, a.bb as bb2, a.tb as tb2, IFNULL(pg.nama,'-') AS dr_rujuk, pg.id as kode
FROM b_pelayanan pl 
INNER JOIN b_kunjungan bk ON pl.kunjungan_id=bk.id
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_wilayah w
 ON p.desa_id = w.id
LEFT JOIN b_ms_wilayah wi
 ON p.kec_id = wi.id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_pasien_keluar k ON k.pelayanan_id=pl.id
LEFT JOIN anamnese a ON a.KUNJ_ID=pl.kunjungan_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$sqlKm="SELECT tk.tgl_in,tk.tgl_out FROM b_tindakan_kamar tk 
LEFT JOIN b_pelayanan p ON p.id=tk.pelayanan_id
WHERE tk.pelayanan_id='$idPel';";
$dK=mysql_fetch_array(mysql_query($sqlKm));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));
?>
<?php

$dG=mysql_fetch_array(mysql_query("select * from b_ms_permintaan_rehabilitasi_medik where id='$_REQUEST[id]'"));
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
<title>Permintaan Pemeriksaan Diagnostik</title>
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
<body onload="enable_text(false)">
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
<form name="form1" id="form1">
                <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="id" id="id"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
<table width="766" border="0" style="font:12px tahoma;">
  <tr>
    <td width="379" valign="bottom">&nbsp;</td>
    <td width="379" rowspan="6"><table width="496" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
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
        <td>:
          <?=$dP['no_reg'];?></td>
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
        <td>:
          <?=$dP['alamat_'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4" align="center">(Tempelkan Sticker Identitas Pasien)</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td valign="bottom">&nbsp;</td>
  </tr>
  <tr>
    <td valign="bottom">RS PELINDO I</td>
  </tr>
  <tr>
    <td valign="bottom">&nbsp;</td>
  </tr>
  <tr>
    <td valign="bottom">&nbsp;</td>
  </tr>
  <tr>
    <td valign="bottom"><span style="font:bold 15px tahoma;">PERMINTAAN REHABILITASI MEDIK</span></td>
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
        <td height="20">&nbsp;</td>
        <td width="64"></td>
        <td width="20"></td>
        <td width="138"></td>
        <td width="20"></td>
        <td width="64"></td>
        <td width="51"></td>
        <td></td>
        <td></td>
        <td width="92"></td>
        <td width="49"></td>
        <td width="58"></td>
        <td width="54"></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20" width="27">&nbsp;</td>
        <td colspan="6">Kode Dokter Pengirim : 
          <?=$dP['kode'];?></td>
        <td width="99"></td>
        <td width="13"></td>
        <td style="border:1px solid #000" colspan="4">No. Formulir :
          <label for="textfield"></label>
          <?=$dG['formulir'];?></td>
        <td width="37"></td>
      </tr>
      <?php 
	  $nilai=explode(",",$dG['cek']);
	  ?>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="7">Permohonan yang diminta harap di coret:
          <input disabled="disabled" id="c_chk[]" type="checkbox" name="c_chk[0]" value="1" <? if($nilai[0]=='1') { echo "checked='checked'";}?> />
          <label for="checkbox">cito</label>
          <input disabled="disabled" id="c_chk[]" type="checkbox" name="c_chk[1]" value="2" <? if($nilai[1]=='2') { echo "checked='checked'";}?> />
          <label for="checkbox4">biasa</label></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3">Diagnosa / Keterangan Klinik:</td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="12"><table width="100%" border="0">
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
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><strong>TERAPI / MODALITAS</strong></td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" id="c_chk[]" type="checkbox" name="c_chk[2]" value="3" <? if($nilai[2]=='3') { echo "checked='checked'";}?> />
          <label for="checkbox5">Short Wave Diathermy</label></td>
        <td colspan="3">&nbsp;</td>
        <td colspan="4"><input disabled="disabled" id="c_chk[]" type="checkbox" name="c_chk[3]" value="4" <? if($nilai[3]=='4') { echo "checked='checked'";}?> />
          <label for="checkbox4">Parafin Bath</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled"id="c_chk[]" type="checkbox" name="c_chk[4]" value="5" <? if($nilai[4]=='5') { echo "checked='checked'";}?> />
          <label for="checkbox6">Electrical Stimulation</label></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="4"><input disabled="disabled" id="c_chk[]" type="checkbox" name="c_chk[5]" value="6" <? if($nilai[5]=='6') { echo "checked='checked'";}?> />
          <label for="checkbox5">Interferensial</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" id="c_chk[]" type="checkbox" name="c_chk[6]" value="7" <? if($nilai[6]=='7') { echo "checked='checked'";}?> />
          <label for="checkbox7">Ultrasonic Therapy</label></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="4"><input disabled="disabled" id="c_chk[]" type="checkbox" name="c_chk[7]" value="8" <? if($nilai[7]=='8') { echo "checked='checked'";}?> />
          <label for="checkbox6">TENS</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" id="c_chk[]" type="checkbox" name="c_chk[8]" value="9" <? if($nilai[8]=='9') { echo "checked='checked'";}?> />
          <label for="checkbox">Micro Wave Diathhermy</label></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="4"><input disabled="disabled" id="c_chk[]" type="checkbox" name="c_chk[9]" value="10" <? if($nilai[9]=='10') { echo "checked='checked'";}?> />
          <label for="checkbox7">Suction</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" id="c_chk[]" type="checkbox" name="c_chk[10]" value="11" <? if($nilai[10]=='11') { echo "checked='checked'";}?> />
          <label for="checkbox2">Infra Red Radiation</label></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="4"><input disabled="disabled" id="c_chk[]" type="checkbox" name="c_chk[11]" value="12" onclick="enable_text(this.checked)" <? if($nilai[11]=='12') { echo "checked='checked'";}?> />
          <label for="textfield2"></label>
          <?=$dG['isi'];?>
          <label for="checkbox8"></label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" id="c_chk[]" type="checkbox" name="c_chk[12]" value="13" <? if($nilai[12]=='13') { echo "checked='checked'";}?> />
          <label for="checkbox3">Traksi Cervical/Lumbal</label></td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><strong>NEBULIZER</strong></td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" id="c_chk[]" type="checkbox" name="c_chk[13]" value="14" <? if($nilai[13]=='14') { echo "checked='checked'";}?> />
          <label for="checkbox44">Chest Phisio Therapy (CPT)</label></td>
        <td colspan="3">&nbsp;</td>
        <td colspan="4"><input disabled="disabled" id="c_chk[]" type="checkbox" name="c_chk[14]" value="15" <? if($nilai[14]=='15') { echo "checked='checked'";}?> />
          <label for="checkbox24">Micromist Nebulizer Anak</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="5"><input disabled="disabled" id="c_chk[]" type="checkbox" name="c_chk[15]" value="16" <? if($nilai[15]=='16') { echo "checked='checked'";}?> />
          <label for="checkbox43">Nebulizer + Chest Phisio Therapy (CPT)</label></td>
        <td>&nbsp;</td>
        <td colspan="4"><input disabled="disabled" id="c_chk[]" type="checkbox" name="c_chk[16]" value="17" <? if($nilai[16]=='17') { echo "checked='checked'";}?> />
          Micromist Nebulizer Dewasa</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" id="c_chk[]" type="checkbox" name="c_chk[17]" value="18" <? if($nilai[17]=='18') { echo "checked='checked'";}?> />
          <label for="checkbox13">1 Modalitas, Nebulizer, CPT</label></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="4"><input disabled="disabled" id="c_chk[]" type="checkbox" name="c_chk[18]" value="19" <? if($nilai[18]=='19') { echo "checked='checked'";}?> />
          <label for="checkbox22">Suction Cateler</label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="4">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><strong>KOMBINASI/PAKET</strong></td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" id="c_chk[]" type="checkbox" name="c_chk[19]" value="20" <? if($nilai[19]=='20') { echo "checked='checked'";}?> />
          <label for="checkbox53">Paket 2 alat</label></td>
        <td colspan="3">&nbsp;</td>
        <td colspan="4">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="5"><input disabled="disabled" id="c_chk[]" type="checkbox" name="c_chk[20]" value="21" <? if($nilai[20]=='21') { echo "checked='checked'";}?> />
          <label for="checkbox50">Paket 3 alat</label></td>
        <td>&nbsp;</td>
        <td colspan="4">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3"><input disabled="disabled" id="c_chk[]" type="checkbox" name="c_chk[21]" value="22" <? if($nilai[21]=='22') { echo "checked='checked'";}?> />
          <label for="checkbox48">Paket 4 alat</label></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="4">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="4"><label for="textfield4"></label>
          <label for="checkbox19"></label></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td colspan="4">Medan, <?=date('j ').getBulan(date('m')).date(' Y')?></td>
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
        <td colspan="4">&nbsp;Pukul : 
          <?=date('h:i:s');?></td>
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
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
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
        <td align="center" colspan="4">(<strong><u>
          <?=$dP['dr_rujuk'];?>
        </u></strong>)<br>Tanda Tangan</td>
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
      
      <div id="trTombol" align="center"><input type="submit" name="button" id="button" value="Cetak" onclick="cetak(document.getElementById('trTombol'));" />
   									<input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/></div>
      
      </td>
  </tr>
  
</table>
</form>
</div>

<div id="tampil_data" align="center"></div>
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