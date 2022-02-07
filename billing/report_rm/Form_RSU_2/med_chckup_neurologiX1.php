<?php 
include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUser'];
$idx=$_REQUEST['id'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit, bk.no_reg, IF(p.alamat <> '',CONCAT(p.alamat,' RT. ',p.rt,' RW. ',p.rw, ' Desa ',bw.nama,' Kecamatan ',wi.nama),'-') AS almt_lengkap, pg.nama as nama2
FROM b_pelayanan pl 
INNER JOIN b_kunjungan bk ON pl.kunjungan_id = bk.id
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
INNER JOIN b_ms_wilayah bw ON p.desa_id = bw.id
INNER JOIN b_ms_wilayah wi
		ON p.kec_id = wi.id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$dt=mysql_fetch_array(mysql_query("select * from b_ms_check_neurologi where id='$idx'"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Medical Checkup Status Neurologi</title>
<style>

.gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:200px;
	}
.textArea{ width:100%;}
</style>
</head>

<body>
<table width="200" border="0">
  <tr>
    <td>
      
    <table cellspacing="0" cellpadding="">
      <tr>
        <td width="72" align="left" valign="top"><img src="lap_med_chckup_stat_bdh_wnta_clip_image003.png" alt="" width="350" height="105" />
          <table cellpadding="0" cellspacing="0">
            <tr>
              <td width="72"></td>
            </tr>
          </table></td>
        <td colspan="9" align="right"><table width="316" border="0" style="font:12px tahoma; border:1px solid #000;">
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
            <td><span class="gb"><?=$dP['no_rm']?></span>&nbsp;No.Registrasi:&nbsp;<?=$dP['no_reg']?></td>
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
            <td><span class="gb"><?=$dP['almt_lengkap']?></span></td>
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
        <td colspan="6"><b>LAPORAN MEDICAL CHECK UP STATUS NEUROLOGI</b></td>
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
    <td>
    <table width="818" cellpadding="2" cellspacing="0" style="font:12px tahoma; border:1px solid #000;">
      <tr>
        <td width="19">&nbsp;</td>
        <td width="147" style="font-weight:bold;">ANAMNESA</td>
        <td width="12">&nbsp;</td>
        <td colspan="5"></td>
        <td width="16">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">Keluhan</td>
        <td valign="top">:</td>
        <td colspan="5"><?=$dt['keluhan']?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td style="font-weight:bold;">PEMERIKSAAN</td>
        <td></td>
        <td colspan="5"></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td >Kesadaran</td>
        <td>:</td>
        <td colspan="5"><label for="txtSadar">
          <?=$dt['kesadaran']?>
        </label></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td valign="top">Tanda-tanda rangsang selaput otak</td>
        <td valign="top">:</td>
        <td colspan="5" valign="top"><label for="txtJVP">
          <?=$dt['selaput_otak']?>
        </label></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td valign="top">Tanda -tanda peninggian tekanan intrakranial</td>
        <td valign="top">:</td>
        <td colspan="5" valign="top"><?=$dt['intrakranial']?>          <label for="txtParu"></label></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td valign="top">Syaraf - syaraf otak</td>
        <td valign="top">:</td>
        <td colspan="5"><?=$dt['syaraf_otak']?>          <label for="txtJantung"></label></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td valign="top">Sistem Motorik</td>
        <td valign="top">:</td>
        <td colspan="5"><?=$dt['motorik']?>          <label for="txtHati"></label></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td valign="top">Refleks Patologis</td>
        <td valign="top">:</td>
        <td colspan="5"><?=$dt['patologis']?>          <label for="txtLimpa"></label></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td valign="top">Sistem Sensorik</td>
        <td valign="top">:</td>
        <td colspan="5"><?=$dt['sensorik']?>          <label for="txtLain"></label></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td valign="top">Sistem Otonom</td>
        <td valign="top">:</td>
        <td colspan="5"><?=$dt['otonom']?>          <label for="txtEdema"></label></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td valign="top">Sistem Luhur</td>
        <td valign="top">:</td>
        <td colspan="5"><?=$dt['luhur']?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td valign="top" >Lain -lain</td>
        <td valign="top">:</td>
        <td colspan="5"><?=$dt['lain_lain']?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td valign="top" >EEG</td>
        <td valign="top">:</td>
        <td colspan="5"><?=$dt['eeg']?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top" >Diagnosa</td>
        <td valign="top">:</td>
        <td colspan="5" valign="top"><table width="95%" border="0">
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
        <td valign="top">&nbsp;</td>
        <td valign="top" >Anjuran</td>
        <td valign="top">:</td>
        <td colspan="5"><?=$dt['anjuran']?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5"></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="5"></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td width="316"></td>
        <td colspan="4">Tanggal/Date  :<span class="gb">
          <?=tgl_ina(date('Y-m-d'));?>
        </span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
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
        <td colspan="3">Dokter yang memeriksa,</td>
        <td width="70"></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td width="67"></td>
        <td width="67"></td>
        <td width="66"></td>
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
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3" align="center"><strong><?=$dP['nama2']?></strong></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
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
      </tr>
    </table></td>
  </tr>
   <tr id="trTombol">
        <td class="noline" align="center" colspan="11">     
           <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" />
          <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/></td>
   </tr>
</table>
</body>
</html>

<script type="text/JavaScript">
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