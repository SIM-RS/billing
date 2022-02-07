<?php 
include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$idx=$_REQUEST['id'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
if(isset($_POST['idPel'])){
	$idPel=$_POST['idPel'];
	$idKunj=$_POST['idKunj'];
	$txt_keluhan=$_POST['txt_keluhan'];
	$txt_umbilical=$_POST['txt_umbilical'];
	$txt_inguinal=$_POST['txt_inguinal'];
	$txt_incisional=$_POST['txt_incisional'];
	$txt_ampula=$_POST['txt_ampula'];
	$txt_hemoroid=$_POST['txt_hemoroid'];
	$rd_grade=$_POST['rd_grade'];
	$txt_polip=$_POST['txt_polip'];
	$txt_sphinter=$_POST['txt_sphinter'];
	$txt_anjuran=$_POST['txt_anjuran'];
	$idUsr=$_POST['idUsr'];
	
		$sql="INSERT INTO b_fom_med_chk_bdh_wnt(pelayanan_id,kunjungan_id,keluhan,umbilical,inguinal,incisional,ampulla_recti,hemoroid,grade,polip,sphiner_ani,anjuran,tgl_act,user_act) VALUES('$idPel','$idKunj','$txt_keluhan','$txt_umbilical','$txt_inguinal','$txt_incisional','$txt_ampula','$txt_hemoroid','$rd_grade','$txt_polip','$txt_sphinter','$txt_anjuran',CURDATE(),'$idUsr')";
		$ex=mysql_query($sql);
		$idx=mysql_insert_id();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Medical Checkup (Bedah Wanita)</title>
<style>

.gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:200px;
	}
.textArea{ width:95%;}
</style>
</head>

<body>
<table width="200" border="0">
  <tr>
    <td>
      
    <table cellspacing="0" cellpadding="">
      <col width="72" />
      <col width="46" />
      <col width="126" />
      <col width="17" />
      <col width="64" span="5" />
      <col width="79" />
      <tr>
        <td width="72" align="left" valign="top"><img src="lap_med_chckup_stat_bdh_wnta_clip_image003.png" alt="" width="350" height="105" />
          <table cellpadding="0" cellspacing="0">
            <tr>
              <td width="72"></td>
            </tr>
          </table></td>
        <td colspan="9"><table width="316" border="0" style="font:12px tahoma; border:1px solid #000;">
          <tr>
            <td width="116">Nama Pasien</td>
            <td width="10">:</td>
            <td width="174"><span class="gb"><?=$dP['nama']?></span>&nbsp;&nbsp;<span <?php if($dP['sex']=='L'){echo 'style="padding:1px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($dP['sex']=='P'){echo 'style="padding:1px; border:1px #000 solid;"';}?>>P</span></td>
          </tr>
          <tr>
            <td>Tanggal Lahir</td>
            <td>:</td>
            <td><span class="gb"><?=$dP['tgl_lahir']?></span> /Usia: <span class="gb"><?=$dP['usia']?></span> Th</td>
          </tr>
          <tr>
            <td>No. R.M.</td>
            <td>:</td>
            <td><span class="gb"><?=$dP['no_rm']?></span>&nbsp;No.Registrasi:_____</td>
          </tr>
          <tr>
            <td>Ruang Rawat / Kelas</td>
            <td>:</td>
            <td><span class="gb"><?=$dP['nm_unit'];?>/
          <?=$dP['nm_kls'];?></span></td>
          </tr>
          <tr>
            <td>Alamat</td>
            <td>:</td>
            <td><span class="gb"><?=$dP['alamat']?></span></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td></td>
        <td width="46"></td>
        <td width="126"></td>
        <td width="17"></td>
        <td width="64"></td>
        <td width="64"></td>
        <td width="64"></td>
        <td width="64"></td>
        <td width="64"></td>
        <td width="79"></td>
      </tr>
      <tr>
        <td></td>
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
      <tr>
        <td></td>
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
      <tr>
        <td colspan="6"><b>LAPORAN MEDICAL CHECK UP STATUS BEDAH (WANITA)</b></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
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
    </table></td>
  </tr>
  <tr>
    <td><form id="form1" name="form1" method="post" action="">
    <input type="hidden" name="idPel" value="<?=$idPel?>" />
    <input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    <input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    <input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    <table cellspacing="0" cellpadding="2" style="font:12px tahoma; border:1px solid #000;">
      <tr>
        <td colspan="2">ANAMNESA</td>
        <td width="110"></td>
        <td width="16"></td>
        <td width="31"></td>
        <td width="159"></td>
        <td width="62"></td>
        <td width="62"></td>
        <td width="61"></td>
        <td width="65"></td>
        <td width="7">&nbsp;</td>
      </tr>
      <tr>
        <td width="74"></td>
        <td width="19"></td>
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
      <tr>
        <td valign="top">Keluhan</td>
        <td valign="top">:</td>
        <td colspan="8"><textarea name="txt_keluhan" cols="45" rows="5" class="textArea" id="txt_keluhan" ><?=$_POST['txt_keluhan']?>
        </textarea></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
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
      <tr>
        <td></td>
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
      <tr>
        <td colspan="2">PEMERIKSAAN</td>
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
      <tr>
        <td></td>
        <td></td>
        <td colspan="3" align="center">Mammae Kanan</td>
        <td></td>
        <td colspan="2" align="center">Mammae Kiri</td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="3" rowspan="5" align="center"><img src="lap_med_chckup_stat_bdh_wnta_clip_image002.png" alt="" width="90" height="80" /></td>
        <td rowspan="5" width="159" align="right">&nbsp;</td>
        <td colspan="2" rowspan="5" align="center"><img src="lap_med_chckup_stat_bdh_wnta_clip_image002.png" alt="" width="90" height="80" /></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
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
      <tr>
        <td></td>
        <td colspan="2">HERNIA   :</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td>Umbilical (+) / (-)</td>
        <td colspan="2" align="center"><input name="txt_umbilical" type="text" style="width:30px;" id="txt_umbilical" placeholder="+/-" value="<?=$_POST['txt_umbilical']?>"/></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td>Inguinal (+) / (-)</td>
        <td colspan="2" align="center"><input name="txt_inguinal" type="text" style="width:30px;" placeholder="+/-" id="txt_inguinal" value="<?=$_POST['txt_inguinal']?>"/></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td>Incisional (+) / (-)</td>
        <td colspan="2" align="center"><input name="txt_incisional" type="text" style="width:30px;" placeholder="+/-" id="txt_incisional"  value="<?=$_POST['txt_incisional']?>"/></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td colspan="2">Rectal Toucher  :</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td>Ampulla Recti</td>
        <td>:</td>
        <td colspan="6"><input name="txt_ampula" type="text" class="inputan" id="txt_ampula" value="<?=$_POST['txt_ampula']?>"/></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td>Hemoroid</td>
        <td>:</td>
        <td><input name="txt_hemoroid" type="text" style="width:30px;" id="txt_hemoroid" value="<?=$_POST['txt_hemoroid']?>" placeholder="+/-"/></td>
        <td colspan="5">Grade&nbsp;&nbsp;&nbsp;&nbsp;<input name="rd_grade" type="radio" value="I" />I&nbsp;&nbsp;&nbsp;<input name="rd_grade" type="radio" value="II" />II&nbsp;&nbsp;&nbsp;<input name="rd_grade" type="radio" value="III" />III&nbsp;&nbsp;&nbsp;<input name="rd_grade" type="radio" value="IV" />IV</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td>Tumor/Polip</td>
        <td>:</td>
        <td><input name="txt_polip" type="text" style="width:30px;" id="txt_polip" value="<?=$_POST['txt_polip']?>" placeholder="+/-"/></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td>Sphinter ani</td>
        <td>:</td>
        <td colspan="6"><input name="txt_sphinter" type="text" class="inputan" id="txt_sphinter" value="<?=$_POST['txt_sphinter']?>"/></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
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
      <tr>
        <td valign="top">DIAGNOSA</td>
        <td valign="top">:</td>
        <td colspan="8" valign="top"><table width="95%" border="0">
        <?php $sqlD="SELECT md.nama FROM b_diagnosa d
LEFT JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
LEFT JOIN b_kunjungan k ON k.id=d.kunjungan_id
WHERE d.pelayanan_id='$idPel';";
$exD=mysql_query($sqlD);
while($dD=mysql_fetch_array($exD)){
?>
          <tr>
            <td class="gb"><?=$dD['nama']?></td>
          </tr>
        <?php }?>  
          <tr>
            <td class="gb">&nbsp;</td>
          </tr>
        </table></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
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
      <tr>
        <td valign="top">ANJURAN</td>
        <td valign="top">:</td>
        <td colspan="8"><textarea name="txt_anjuran" cols="45" rows="5" class="textArea" id="txt_ajuran" ><?=$_POST['txt_anjuran']?>
        </textarea></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
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
      <tr>
        <td></td>
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
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="4">Tanggal/Date  :<span class="gb">
          <?=date('d-m-Y');?>
        </span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="4">Pukul/Time     :<span class="gb">
          <?=date('h:i:s');?>
        </span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3">Dokter yang memeriksa,</td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
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
      <tr>
        <td></td>
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
      <tr>
        <td></td>
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
      <tr>
        <td></td>
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
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3" align="center">(_________________________)</td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3" align="center">Nama &amp; Tanda Tangan</td>
        <td></td>
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
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></form></td></td>
  </tr>
  <tr>
  <td align="center"><input type="button" name="bt_save" id="bt_save" value="Simpan" onclick="return simpan()" />&nbsp;
  <input type="button" name="bt_cetak" id="bt_cetak" value="Cetak" onclick="return cetak()" <?php if(!isset($_POST['idPel'])){ echo 'style="display:none"';} ?>/>
  </td>
  </tr>
</table>
</body>
<script type="text/javascript">
function simpan(){
		if(confirm('Anda yakin menyimpan data ini ?')){
				document.forms[0].submit();
				}
	}
function cetak(){
		window.open("lap_med_chckup_stat_bdh_wnta.php?id=<?=$idx?>&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
	}
</script>
</html>