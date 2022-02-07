<?php
	require_once("setting.php");
	$kelas_id = $_REQUEST["kelas_id"];
	$idKunj=$_REQUEST['idKunj'];
	$jeniskasir=$_REQUEST['jenisKasir'];
	$idPel=$_REQUEST['idPel'];
	$inap=$_REQUEST['inap'];
	$all = $_REQUEST['all'];
	$idUser=$_REQUEST['idUser'];
	
	$sql = "select * from b_form_indikatormutu where pelayanan_id = '$idPel' AND kunjungan_id = '$idKunj'";
	$query = mysql_num_rows(mysql_query($sql));
	$update = 0;
	$act = "Save";
	
	if($query > 0){
		$update = 1;
		$act = "Update";
		$isi = mysql_fetch_array(mysql_query($sql));
		$ugdlengkap = explode("||",$isi['ugd']);
		$subugd = explode(",",$ugdlengkap[1]);
		
		$obatjalan = explode("||",$isi['obatjalan']);
		$subobat = explode(',',$obatjalan[1]);
		
		$dokterrawat = explode("||",$isi['dokterrawat']);
		$subdokter = explode(',',$dokterrawat[1]);
		
		$tirahbaring = explode("||",$isi['tirahbaring']);
		
		$dekubitus = explode("||",$isi['dekubitus']);
		$subdeku = explode(",",$dekubitus[2]);
		$lastdeku = explode('_',$subdeku[5]);
		
		$transfusi = explode("||",$isi['transfusi']);
		
		$icu = explode("||",$isi['icu']);
		
		$operasi = explode("||",$isi['operasi']);
		$subope1 = explode("_",$operasi[1]);
		
		$subope2 = explode("&",$operasi[2]);
		$subope21 = explode(",",$subope2[1]);
		$lastsub21 = explode("_",$subope21[2]);
		
		$subope3 = explode("&",$operasi[3]);
		$subope31 = explode("-",$subope3[1]);
		
		$apendik = explode('||',$isi['apendik']);
		$subapendik = explode('_',$apendik[1]);
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Checklist Indikator Mutu</title>
</head>
<?
//include "setting.php";
?>
<style>
.kotak{
border:1px solid #000000;
width:20px;
height:20px;
text-align:center;
font-size:16px;
}
</style>
<body>
<table width="800" border="0" style="font:12px tahoma;">
  <tr>
    <td><table width="512" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
      <tr>
        <td width="124">Nama Pasien</td>
        <td width="173">:
          <?=$nama;?></td>
        <td width="75">&nbsp;</td>
        <td width="88">&nbsp;</td>
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
          <?=$noRM;?>
        </td>
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
        <td colspan="3">: <?=$alamat;?></td>
      </tr>
      <tr>
        <td colspan="4">(Tempelkan Sticker Identitas Pasien)</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table cellspacing="1" cellpadding="0" style="border:1px solid  #000000;">
      <col width="19" />
      <col width="375" />
      <col width="21" />
      <col width="9" />
      <col width="22" />
      <col width="24" />
      <col width="21" />
      <col width="8" />
      <col width="15" />
      <col width="24" />
      <col width="31" />
      <col width="19" />
      <col width="6" />
      <col width="77" />
      <col width="20" />
      <col width="7" />
      <col width="96" />
      <col width="20" />
      <col width="7" />
      <col width="35" />
      <tr height="20">
        <td height="20" width="19"></td>
        <td width="375"></td>
        <td width="21"></td>
        <td width="9"></td>
        <td width="22"></td>
        <td width="24"></td>
        <td width="21"></td>
        <td width="8"></td>
        <td width="15"></td>
        <td width="24"></td>
        <td width="31"></td>
        <td width="19"></td>
        <td width="6"></td>
        <td width="77"></td>
        <td width="20"></td>
        <td width="7"></td>
        <td width="96"></td>
        <td width="20"></td>
        <td width="7"></td>
        <td width="35"></td>
      </tr>
      <tr height="20">
        <td height="20" align="center">1</td>
        <td>Apakah pemeriksaan di UGD lengkap?</td>
        <td><div class="kotak"><?=($ugdlengkap[0]=='1')?"&#10004;":"";?></div></td>
        <td></td>
        <td>Ya</td>
        <td></td>
        <td><div class="kotak"><?=($ugdlengkap[0]=='0')?"&#10004;":"";?></div></td>
        <td></td>
        <td colspan="2">Tidak</td>
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
        <td height="20"></td>
        <td>(anamnesa/pemeriksaan diagnostik, sesuai klinis&nbsp;</td>
        <td colspan="9">Bila tidak lengkap yaitu&hellip;&hellip;.</td>
        <td><div class="kotak"><?=($subugd[0]==1)?"&#10004;":"";?></div></td>
        <td></td>
        <td>Anamnesa</td>
        <td><div class="kotak"><?=($subugd[1]==1)?"&#10004;":"";?></div></td>
        <td></td>
        <td>Laboratorium</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td>pasien )</td>
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
        <td><div class="kotak"><?=($subugd[2]==1)?"&#10004;":"";?></div></td>
        <td></td>
        <td>Radiologi</td>
        <td><div class="kotak"><?=($subugd[3]==1)?"&#10004;":"";?></div></td>
        <td></td>
        <td>EKG</td>
        <td><div class="kotak"><?=($subugd[4]==1)?"&#10004;":"";?></div></td>
        <td></td>
        <td>dll</td>
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
        <td height="20" align="center">2</td>
        <td>Apakah pasien sebelumnya pernah berobat jalan</td>
        <td><div class="kotak"><?=($obatjalan[0]=='1')?'&#10004;':'';?></div></td>
        <td></td>
        <td>Ya</td>
        <td></td>
        <td><div class="kotak"><?=($obatjalan[0]=='0')?'&#10004;':'';?></div></td>
        <td></td>
        <td colspan="2">Tidak</td>
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
        <td height="20"></td>
        <td>di RS Pelindo I kurang dari 3 hari yang lalu?</td>
        <td colspan="7">Bila jawaban ya, di</td>
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
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td><div class="kotak"><?=($subobat[0]=='1')?'&#10004;':'';?></div></td>
        <td></td>
        <td colspan="2">UGD</td>
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
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td><div class="kotak"><?=($subobat[1]=='1')?'&#10004;':'';?></div></td>
        <td></td>
        <td colspan="3">Poliklinik</td>
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
        <td>&nbsp;</td>
      </tr>
      <tr height="10">
        <td height="10"></td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" align="center">3</td>
        <td>Apakah dokter yang merawat dihubungi kurang dari</td>
        <td><div class="kotak"><?=($dokterrawat[0] == '1')?'&#10004;':'';?></div></td>
        <td></td>
        <td>Ya</td>
        <td></td>
        <td><div class="kotak"><?=($dokterrawat[0] == '0')?'&#10004;':'';?></div></td>
        <td></td>
        <td colspan="2">Tidak</td>
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
        <td height="20"></td>
        <td>30 menit sejak pasien masuk unit rawat inap?</td>
        <td colspan="12">Kapan dokter datang sejak dihubungi</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td><div class="kotak"><?=($subdokter[0] == '1')?'&#10004;':'';?></div></td>
        <td></td>
        <td colspan="4">0 -30 menit</td>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><?=($subdokter[2] == '1')?'&#10004;':'';?></div></td>
        <td></td>
        <td colspan="2">61-90 menit</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="8">
        <td height="8"></td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td><div class="kotak"><?=($subdokter[1] == '1')?'&#10004;':'';?></div></td>
        <td></td>
        <td colspan="5">31 - 60 menit</td>
        <td></td>
        <td></td>
        <td><div class="kotak"><?=($subdokter[3] == '1')?'&#10004;':'';?></div></td>
        <td></td>
        <td colspan="2">91-120 menit</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="7">
        <td height="7"></td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td><div class="kotak"><?=($subdokter[4] == '1')?'&#10004;':'';?></div></td>
        <td></td>
        <td colspan="5">&gt; 120 menit</td>
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
        <td>&nbsp;</td>
      </tr>
      <tr height="6">
        <td height="6"></td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" align="center">4</td>
        <td>Apakah karena keadaan umumnya pasien tirah</td>
        <td><div class="kotak"><?=($tirahbaring[0] == '1')?'&#10004;':'';?></div></td>
        <td></td>
        <td>Ya</td>
        <td></td>
        <td><div class="kotak"><?=($tirahbaring[0] == '0')?'&#10004;':'';?></div></td>
        <td></td>
        <td colspan="2">Tidak</td>
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
        <td height="20"></td>
        <td>baring?</td>
        <td colspan="15">Bila jawaban ya, sebutkan    penyebab/diagnosa : <b><?=$tirahbaring[1];?></b></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="8">
        <td height="8"></td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" align="center">5</td>
        <td>Apakah pasien terdapat luka dekubitus</td>
        <td><div class="kotak"><?=($dekubitus[0] == '1')?"&#10004;":'';?></div></td>
        <td></td>
        <td>Ya</td>
        <td></td>
        <td><div class="kotak"><?=($dekubitus[0] == '0')?"&#10004;":'';?></div></td>
        <td></td>
        <td colspan="2">Tidak</td>
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
        <td height="20"></td>
        <td></td>
        <td colspan="9">Bila jawaban ya, terjadi di</td>
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
        <td height="20"></td>
        <td></td>
        <td><div class="kotak"><?=($dekubitus[1] == '1')?"&#10004;":'';?></div></td>
        <td></td>
        <td>RS</td>
        <td></td>
        <td><div class="kotak"><?=($dekubitus[1] == '0')?"&#10004;":'';?></div></td>
        <td></td>
        <td colspan="3">Luar RS</td>
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
        <td height="20"></td>
        <td></td>
        <td colspan="9">Lokasi (bila jawaban ya)</td>
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
        <td height="20"></td>
        <td></td>
        <td><div class="kotak"><?=($subdeku[0] == '1')?"&#10004;":'';?></div></td>
        <td></td>
        <td colspan="3">Bokong</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><?=($subdeku[1] == '1')?"&#10004;":'';?></div></td>
        <td></td>
        <td>Punggung</td>
        <td><div class="kotak"><?=($subdeku[2] == '1')?"&#10004;":'';?></div></td>
        <td></td>
        <td>Siku</td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="6">
        <td height="6"></td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td><div class="kotak"><?=($subdeku[3] == '1')?"&#10004;":'';?></div></td>
        <td></td>
        <td colspan="3">Mata kaki</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><div class="kotak"><?=($subdeku[4] == '1')?"&#10004;":'';?></div></td>
        <td></td>
        <td>Tumit</td>
        <td><div class="kotak"><?=($lastdeku[0] == '1')?"&#10004;":'';?></div></td>
        <td></td>
        <td>Lain-lain : <b><?=($lastdeku[0] == '1')?$lastdeku[1]:'';?></b></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="9">
        <td height="9"></td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" align="center">6</td>
        <td>Apakah pasien dilakukan transfusi?</td>
        <td><div class="kotak"><?=($transfusi[0] == '1')?"&#10004;":'';?></div></td>
        <td></td>
        <td>Ya</td>
        <td></td>
        <td><div class="kotak"><?=($transfusi[0] == '0')?"&#10004;":'';?></div></td>
        <td></td>
        <td colspan="2">Tidak</td>
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
        <td height="20"></td>
        <td></td>
        <td colspan="13">Bila jawaban ya, adakah reaksi post    transfusi?</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td><div class="kotak"><?=($transfusi[1] == '1')?"&#10004;":'';?></div></td>
        <td></td>
        <td>Ya</td>
        <td></td>
        <td><div class="kotak"><?=($transfusi[1] == '0')?"&#10004;":'';?></div></td>
        <td></td>
        <td colspan="2">Tidak</td>
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
        <td height="20"></td>
        <td></td>
        <td colspan="9">Bila jawaban ya, berupa:</td>
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
        <td height="20"></td>
        <td></td>
        <td><div class="kotak"><?=($transfusi[2] == '1')?"&#10004;":'';?></div></td>
        <td></td>
        <td colspan="12">Penyulit karena golongan darah    tidak cocok</td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="9">
        <td height="9"></td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td><div class="kotak"><?=($transfusi[2] == '0')?"&#10004;":'';?></div></td>
        <td></td>
        <td colspan="9">Terjadi infeksi nosokomial</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="7">
        <td height="7"></td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" align="center">7</td>
        <td>Apakah pasien pindah ke ICU/ICCU setelah&nbsp;</td>
        <td><div class="kotak"><?=($icu[0] == '1')?"&#10004;":'';?></div></td>
        <td></td>
        <td>Ya</td>
        <td></td>
        <td><div class="kotak"><?=($icu[0] == '0')?"&#10004;":'';?></div></td>
        <td></td>
        <td colspan="2">Tidak</td>
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
        <td height="20"></td>
        <td>dirawat diruangan kurang dari 2 jam?</td>
        <td colspan="10">Bila ya, masuk rawat melalui:</td>
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
        <td height="20"></td>
        <td></td>
        <td><div class="kotak"><?=($icu[1] == '1')?"&#10004;":'';?></div></td>
        <td></td>
        <td colspan="2">UGD</td>
        <td><div class="kotak"><?=($icu[1] == '0')?"&#10004;":'';?></div></td>
        <td></td>
        <td colspan="6">Praktek dokter</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="7">
        <td height="7"></td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" align="center">8</td>
        <td>Apakah pasien dilakukan operasi elektif?</td>
        <td><div class="kotak"><?=($operasi[0] == '1')?"&#10004":'';?></div></td>
        <td></td>
        <td>Ya</td>
        <td></td>
        <td><div class="kotak"><?=($operasi[0] == '0')?"&#10004":'';?></div></td>
        <td></td>
        <td colspan="2">Tidak</td>
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
        <td height="20"></td>
        <td></td>
        <td colspan="15">Apakah terjadi infeksi luka operasi    bersih pada operasi elektif</td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td><div class="kotak"><?=($subope1[0] == '1')?"&#10004;":'';?></div></td>
        <td></td>
        <td colspan="6">Ya, jenis operasi : <b><?=($subope1[0] == '1')?$subope1[1]:'';?></b></td>
        <td></td>
        <td><div class="kotak"><?=($subope1[0] == '0')?"&#10004;":'';?></div></td>
        <td></td>
        <td>Tidak</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td colspan="15">Apakah terjadi komplikasi pasca    operasi elektif (diluar infeksi</td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td colspan="5">nosokomial?</td>
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
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td colspan="6">Bila jawaban ya:</td>
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
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td><div class="kotak"><?=($subope21[0] == '1')?"&#10004;":'';?></div></td>
        <td></td>
        <td colspan="7">Sistem sirkulasi darah</td>
        <td><div class="kotak"><?=($subope21[1] == '1')?"&#10004;":'';?></div></td>
        <td></td>
        <td colspan="4">Sistem pernafasan</td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="8">
        <td height="8"></td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td><div class="kotak"><?=($lastsub21[0] == '1')?"&#10004;":'';?></div></td>
        <td></td>
        <td colspan="7">Lain-lain : <b><?=($lastsub21[0] == '1')?$lastsub21[1]:'';?></b></td>
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
        <td height="20"></td>
        <td></td>
        <td colspan="15">Apakah tindakan operasi elektif    dilakukan setelah masa</td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td colspan="7">tunggu &gt; 24 jam?</td>
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
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td><div class="kotak"><?=($subope3[0] == '1')?"&#10004;":'';?></div></td>
        <td></td>
        <td>Ya</td>
        <td></td>
        <td><div class="kotak"><?=($subope3[0] == '0')?"&#10004;":'';?></div></td>
        <td></td>
        <td colspan="2">Tidak</td>
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
        <td height="20"></td>
        <td></td>
        <td colspan="9">Bila jawan ya alasan</td>
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
        <td height="20"></td>
        <td></td>
        <td colspan="9">Jenis operasi : <b><?=$subope31[1]?></b></td>
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
        <td height="20" align="center">9</td>
        <td>Apakah pasien dilakukan operasi apendiktomi</td>
        <td><div class="kotak"><?=($apendik[0]=='1')?'&#10004;':'';?></div></td>
        <td></td>
        <td>Ya</td>
        <td></td>
        <td><div class="kotak"><?=($apendik[0]=='0')?'&#10004;':'';?></div></td>
        <td></td>
        <td colspan="2">Tidak</td>
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
        <td height="20"></td>
        <td></td>
        <td colspan="15">Bila jawaban ya, apakah dilakukan    pemeriksaan PA?</td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td></td>
        <td><div class="kotak"><?=($subapendik[0]=='1')?'&#10004;':'';?></div></td>
        <td></td>
        <td colspan="7">Ya, hasil : <b><?=($subapendik[0]=='1')?$subapendik[1]:'';?></b></td>
        <td><div class="kotak"><?=($subapendik[0]=='0')?'&#10004;':'';?></div></td>
        <td></td>
        <td colspan="4">Tidak, Alasan : <?=($subapendik[0]=='0')?$subapendik[1]:'';?></td>
        <td></td>
        <td></td>
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
        <td></td>
        <td></td>
        <td colspan="4">Medan, <?=date('d - m - Y')?></td>
        <td></td>
        <td></td>
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
        <td></td>
        <td></td>
        <td colspan="7">Diisi oleh:</td>
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
        <td></td>
        <td></td>
        <td colspan="7">( <u style="font-weight:bold;"><?=$namaUser?></u> )</td>
      </tr>
    </table></td>
  </tr>
  <tr>
  <td align="center"><button type="button" onclick="window.print()">Cetak</button>
	<button type="button" onclick="window.close()">Tutup</button></td>
  </tr>
</table>
</body>
</html>
