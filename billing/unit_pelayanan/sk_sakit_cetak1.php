<?php
session_start();
include '../koneksi/konek.php';
$idPel=$_REQUEST['idPel'];
$idKunj=$_REQUEST['idKunj'];
$idUser=$_REQUEST['idUser'];
$jml=$_REQUEST['jml'];
$jns1=$_REQUEST['jns1'];
$id=$_REQUEST['id'];

if($_REQUEST['excel']=="yes"){
header("Content-type: application/vnd.ms-excel");
header("Content--Disposition:attachment; filename='hasilLab.xls'");
}

$sqlPas="SELECT DISTINCT 
  no_rm,
  mp.nama nmPas,
  mp.alamat,
  mp.rt,
  mp.rw,
  CASE
    mp.sex 
    WHEN 'P' 
    THEN 'P' 
    ELSE 'L' 
  END AS sex,
  CONCAT(
    DATE_FORMAT(p.tgl, '%d-%m-%Y'),
    ' ',
    DATE_FORMAT(p.tgl_act, '%H:%i')
  ) tgljam,
  DATE_FORMAT(
    IFNULL(p.tgl_krs, NOW()),
    '%d-%m-%Y %H:%i'
  ) tglP,
  mp.desa_id,
  mp.kec_id,
  (SELECT 
    nama 
  FROM
    b_ms_wilayah 
  WHERE id = mp.kec_id) nmKec,
  (SELECT 
    nama 
  FROM
    b_ms_wilayah 
  WHERE id = mp.desa_id) nmDesa,
  k.kso_id,
  k.kso_kelas_id,
  p.kelas_id,
  p.no_lab,
  mp.tgl_lahir,
  k.umur_thn,
  k.id,
  p.id,
  DATE_FORMAT(CURDATE(), '%d %M %Y') AS tgl1,
  DATE_FORMAT(
    DATE_ADD(CURDATE(), INTERVAL 2 DAY),
    '%d %M %Y'
  ) AS tgl2 
FROM
  b_kunjungan k 
  INNER JOIN b_ms_pasien mp 
    ON k.pasien_id = mp.id 
  INNER JOIN b_pelayanan p 
    ON k.id = p.kunjungan_id 
WHERE k.id='$idKunj' AND p.id='$idPel'";
//echo $sqlPas."<br>";
$rs1 = mysql_query($sqlPas);
//echo mysql_error();
$rw = mysql_fetch_array($rs1);
?>
<?
$sqlP="SELECT *, 
DATE_FORMAT(tgl, '%d-%m-%Y')tgl,
IF(tgl_mulai='0000-00-00','-',DATE_FORMAT(tgl_mulai, '%d-%m-%Y')) AS tgl_mulai,
IF(tgl_akhir='0000-00-00','-',DATE_FORMAT(tgl_akhir, '%d-%m-%Y')) AS tgl_akhir,
IF(tgl_mulai2='0000-00-00','-',DATE_FORMAT(tgl_mulai2, '%d-%m-%Y')) AS tgl_mulai2,
IF(tgl_akhir2='0000-00-00','-',DATE_FORMAT(tgl_akhir2, '%d-%m-%Y')) AS tgl_akhir2,
IF(tgl_per='0000-00-00','-',DATE_FORMAT(tgl_per, '%d-%m-%Y')) AS tgl_per,
DATE_FORMAT(tgl,'%W') AS nm_hari 
FROM b_surat_ket_dokter
WHERE id='$id';";
$dP=mysql_fetch_array(mysql_query($sqlP));
{

?>
<?
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Surat Keterangan sakit</title>
<style type="text/css">
<!--
.style2 {font-size: 10px}
-->
</style>
</head>
<style>
.kotak{
border:1px solid #000000;
}
.kotak2{
border:1px solid #000000;
width:20px;
height:20px;
}
</style>
<body>
<div>
<form id="form1" name="form1" action="sk_sakit_act.php">
<input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUser" value="<?=$idUser?>" />
    			<input type="hidden" name="id" id="id"/>
<table width="800" border="0" style="font:12px tahoma;">
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="0">
      <col width="29" />
      <col width="27" />
      <col width="35" />
      <col width="21" />
      <col width="34" />
      <col width="64" span="8" />
      <tr height="">
        <td style="font:24px bold tahoma" colspan="8" rowspan="3" height="128">RS PELINDO I</td>
        <td colspan="5" width="360">&nbsp;</td>
      </tr>
      <tr height="86">
        <td height="86" colspan="5" align="center" valign="middle" class="kotak" style="font:22px bold tahoma">SURAT KETERANGAN DOKTER</td>
      </tr>
      <tr height="">
        <td colspan="5" height="14">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td align="right"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #000">
      <col width="29" />
      <col width="27" />
      <col width="35" />
      <col width="21" />
      <col width="34" />
      <col width="64" span="10" />
      <tr height="">
        <td height="" colspan="17">&nbsp;</td>
      </tr>
      <tr height="">
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="" colspan="14">Yang    bertandatangan di bawah ini, dokter RS PELINDO I, menerangkan bahwa:</td>
        </tr>
      <tr height="">
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="" colspan="14"><em>To whom its m concert, Doctor of RS PELINDO I that certify</em></td>
        </tr>
      <tr height="21">
        <td width="8"></td>
        <td width="8"></td>
        <td width="8" height="21"></td>
        <td colspan="14"></td>
        </tr>
      <tr height="26">
        <td height="26" colspan="2">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td height="26" colspan="2">Nama Pasien /<em>Name of Patien</em></td>
        <td width="6">:</td>
        <td colspan="11"><?php echo $rw['nmPas'];?></td>
        </tr>
      <tr height="26">
        <td height="26">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td height="26" colspan="2">Jenis Kelamin /<em>Sex</em></td>
        <td>:</td>
        <td colspan="11"><input disabled="disabled" name="checkbox" type="checkbox" id="checkbox" value="L" <? if($rw['sex']=='L'){ echo "checked='checked'";}?> />
          <label for="Laki-Laki">Laki-Laki /<em>Male 
              <input disabled="disabled" name="checkbox" type="checkbox" id="checkbox" value="P" <? if($rw['sex']=='P'){ echo "checked='checked'";}?> />
            Perempuan </em>/<em><em>Female</em></em></label></td>
        </tr>
      <tr height="26">
        <td height="26">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td height="26" colspan="2">No. MR /<em>MR Number</em></td>
        <td>:</td>
        <td colspan="11"><?php echo $rw['no_rm'];?></td>
      </tr>
      <tr height="26">
        <td height="26">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td height="26" colspan="2">Umur /<em>Age</em></td>
        <td>:</td>
        <td colspan="11"><?php echo $rw['umur_thn'];?>&nbsp;Thn</td>
      </tr>
      <tr height="26">
        <td height="26">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td height="26" colspan="2">Alamat /<em>Address</em></td>
        <td>:</td>
        <td colspan="11"><?php echo $rw['alamat'];?>&nbsp;RT <?php echo $rw['rt'];?> / RW <?php echo $rw['rw'];?>, Desa <?php echo $rw['nmDesa'];?>, Kecamatan <?php echo $rw['nmKec'];?></td>
      </tr>
      <tr height="26">
        <td height="26" colspan="17"></td>
        </tr>
      <tr height="">
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="" colspan="14">Adalah benar telah berobat di RS PELINDO I, pada:</td>
        </tr>
      <tr height="">
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="" colspan="13"><em>Has been treat at RS PELINDO I, on</em></td>
        <td height="">&nbsp;</td>
      </tr>
      <tr height="">
        <td></td>
        <td></td>
        <td height=""></td>
        <td colspan="2">&nbsp;</td>
        <td colspan="12">&nbsp;</td>
      </tr>
      <tr height="33">
        <td></td>
        <td></td>
        <td height="33"></td>
        <td colspan="2">Hari /<em>Day</em></td>
        <td>:</td>
        <td colspan="11"><label for="hari"></label>
          <?=getHari($dP['nm_hari']);?>          <label for="hari"></label></td>
        </tr>
      <tr height="33">
        <td></td>
        <td></td>
        <td height="33"></td>
        <td colspan="2">Tanggal /<em>Date</em></td>
        <td>:</td>
        <td colspan="11"><label for="textfield2"></label>
          <?=$dP['tgl']?></td>
        </tr>
      <tr height="10">
        <td></td>
        <td></td>
        <td height="10"></td>
        <td colspan="2">&nbsp;</td>
        <td colspan="12">&nbsp;</td>
      </tr>
      <?php 
	  $isi=explode(",",$dP['pilihan']);
	  ?>
      <tr>
        <td></td>
        <td></td>
        <td height=""></td>
        <td colspan="14"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[0]==1) { echo "checked='checked'";}?> />
          Perlu beristirahat karena sakit selama 
          <label for="istirahat"></label>
          <?=$dP['istirahat']?>
 hari,</td>
        </tr>
      <tr height="">
        <td></td>
        <td></td>
        <td height=""></td>
        <td colspan="14"><label for="sakit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>need to rest due to illness for</em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>days</em></label></td>
        </tr>
      <tr height="15">
        <td></td>
        <td></td>
        <td height=""></td>
        <td height="" colspan="14"></td>
        </tr>
      <tr height="">
        <td></td>
        <td></td>
        <td height=""></td>
        <td colspan="14">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Terhitung mulai tanggal 
          <label for="textfield7"></label>
          <?=$dP['tgl_mulai']?>
          <label for="tgl_per"></label>
          sd
<label for="textfield8"></label>
<?=$dP['tgl_akhir']?><label for="note"></label></td>
        </tr>
      <tr height="">
        <td></td>
        <td></td>
        <td height=""></td>
        <td colspan="14"><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From the date of &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;until</em></td>
        </tr>
      <tr height="33">
        <td></td>
        <td></td>
        <td height="33"></td>
        <td colspan="2">&nbsp;</td>
        <td colspan="12">&nbsp;</td>
      </tr>
      <tr height="">
        <td></td>
        <td></td>
        <td height=""></td>
        <td colspan="14"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[1]==2) { echo "checked='checked'";}?> />
          Dirawat inap di RS PELINDO I karena sakit selama 
            <?=$dP['inap']?> 
 hari,</td>
      </tr>
      <tr height="">
        <td></td>
        <td></td>
        <td height=""></td>
        <td colspan="14"><label for="sakit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>has been inpatien at RS PELINDO I due to illness for</em>&nbsp;<em>days</em></label></td>
      </tr>
      <tr height="15">
        <td></td>
        <td></td>
        <td height=""></td>
        <td height="" colspan="14"></td>
      </tr>
      <tr height="">
        <td></td>
        <td></td>
        <td height=""></td>
        <td colspan="14">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Terhitung mulai tanggal 
          <?=$dP['tgl_mulai2']?>
          <label for="textfield7"></label>
          <label for="tgl_per"></label>
          sd
          <label for="textfield8"></label>          <label for="note">
            <?=$dP['tgl_akhir2']?>
          </label></td>
      </tr>
      <tr height="">
        <td></td>
        <td></td>
        <td height=""></td>
        <td colspan="14"><em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;From the date of &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;until</em></td>
      </tr>
      <tr height="33">
        <td></td>
        <td></td>
        <td height="33"></td>
        <td colspan="2">&nbsp;</td>
        <td colspan="12">&nbsp;</td>
      </tr>
      <tr height="">
        <td></td>
        <td></td>
        <td height=""></td>
        <td colspan="14"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[2]==3) { echo "checked='checked'";}?> />
          Perkiraan persalinan tanggal <label for="tgl_per">
            <?=$dP['tgl_per']?>
          </label></td>
      </tr>
      <tr height="">
        <td></td>
        <td></td>
        <td height=""></td>
        <td colspan="14"><label for="sakit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>estimated delivery date</em></label></td>
      </tr>
      <tr height="33">
        <td></td>
        <td></td>
        <td height="33"></td>
        <td colspan="2">&nbsp;</td>
        <td colspan="12">&nbsp;</td>
      </tr>
      <tr height="">
        <td></td>
        <td></td>
        <td height=""></td>
        <td colspan="14">Demikian surat keterangan ini dibuat, agar dapat dipergunakan sebagaimana mestinya.</td>
        </tr>
      <tr height="">
        <td></td>
        <td></td>
        <td height=""></td>
        <td colspan="14"><em>The statement was made to be used properly</em></td>
        </tr>
      <tr height="33">
        <td></td>
        <td></td>
        <td height="33"></td>
        <td colspan="2">&nbsp;</td>
        <td colspan="12">&nbsp;</td>
      </tr>
      <tr height="">
        <td></td>
        <td></td>
        <td height=""></td>
        <td colspan="2">NB:</td>
        <td colspan="12">&nbsp;</td>
      </tr>
      <tr height="">
        <td></td>
        <td></td>
        <td height=""></td>
        <td colspan="14"><em>Notes</em></td>
      </tr>
      <tr height="27">
        <td></td>
        <td></td>
        <td height="27"></td>
        <td colspan="14"><label for="note">
          <?=$dP['note']?>
        </label></td>
      </tr>
      <tr height="33">
        <td></td>
        <td></td>
        <td height="33"></td>
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
        <td colspan="4">Medan, <?php echo gmdate('d F Y',mktime(date('H')+7));?></td>
        </tr>
      <tr height="">
        <td></td>
        <td></td>
        <td height=""></td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td colspan="4">Dokter Pemerikasa,</td>
        </tr>
      <tr height="">
        <td></td>
        <td></td>
        <td height=""></td>
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
        <td colspan="4" align="justify">Phycisian</td>
        </tr>
      <tr height="21">
        <td></td>
        <td></td>
        <td height="21"></td>
        <td width="135"></td>
        <td width="176"></td>
        <td></td>
        <td width="95"></td>
        <td width="1"></td>
        <td width="16"></td>
        <td width="24"></td>
        <td width="1"></td>
        <td width="9"></td>
        <td width="1"></td>
        <td width="1"></td>
        <td width="1"></td>
        <td width="86"></td>
        <td></td>
      </tr>
      <tr height="21">
        <td></td>
        <td></td>
        <td height="21"></td>
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
        <td></td>
      </tr>
      <tr height="21">
        <td></td>
        <td></td>
        <td height="21"></td>
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
        <td></td>
      </tr>
      <tr height="21">
        <td></td>
        <td></td>
        <td height="21"></td>
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
        <td></td>
      </tr>
      <tr height="21">
        <td></td>
        <td></td>
      <?php
			$sqlPet = "select nama from b_ms_pegawai where id = $_REQUEST[idUser]";
			//echo $sqlPet;
			$dt = mysql_query($sqlPet);
			$rt = mysql_fetch_array($dt);
			//echo $pegawai;
			?>
        <td height="21"></td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td colspan="4" align="center"><p><strong><u>(<?php echo $rt['nama'];?>)</u></strong></p></td>
        </tr>
      <tr height="21">
        <td></td>
        <td></td>
        <td height="21"></td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td colspan="4" align="center">&nbsp;</td>
      </tr>
      <tr height="21" id="trCetak">
        <td height="21" colspan="17" align="left"><input type="button" name="bt_cetak" id="bt_cetak" value="Cetak" onclick="cetak()" /></td>
        </tr>
    </table>
    </td>
  </tr>
</table>
</form>
</div>
</body>
</html>
<script>
function cetak(){
	document.getElementById('trCetak').style.display="none";
	window.print();	
}
</script>