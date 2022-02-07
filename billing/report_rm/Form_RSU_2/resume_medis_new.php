<?php
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$idx=$_REQUEST['id'];
$sqlP="SELECT p.*,bk.no_reg,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,
k.cara_keluar,
CONCAT((CONCAT((CONCAT((CONCAT(p.alamat,' RT.',p.rt)),' RW.',p.rw)),', Desa ',w.nama)),', Kecamatan ',wi.nama) alamat_,
DATE_FORMAT(bk.tgl_pulang,'%Y-%m-%d') AS tgl_keluarP, bmk.nama as nm_kso
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
LEFT JOIN b_ms_kso bmk ON pl.kso_id = bmk.id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$sqlKm="SELECT tk.tgl_in,tk.tgl_out, bk.tgl FROM b_tindakan_kamar tk 
LEFT JOIN b_pelayanan p ON p.id=tk.pelayanan_id
INNER JOIN b_kunjungan bk on bk.id = p.kunjungan_id
WHERE tk.pelayanan_id='$idPel';";
$dK=mysql_fetch_array(mysql_query($sqlKm));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));
$takadaygabadi="select *, DATE_FORMAT(tgl_lanjut,'%d-%m-%Y') AS lanjut1 from b_fom_resum_medis_new where id='$idx'";
$dRM=mysql_fetch_array(mysql_query($takadaygabadi));
$sql11="SELECT b.*, pp.nama AS nama_usr FROM b_fom_resum_medis_new b
LEFT JOIN b_ms_pegawai pp ON pp.id=b.user_act
WHERE b.id='$idx'";
$dRM1=mysql_fetch_array(mysql_query($sql11));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LAPORAN RESUM MEDIS</title>

    <style>
        .gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:80px;
	}
.textArea{ width:97%;}
        </style>

</head>

<body>
<table width="805" border="0">
  <tr>
    <td width="799"><table cellspacing="0" cellpadding="0" width="100%">
      <col width="72" />
      <col width="46" />
      <col width="126" />
      <col width="17" />
      <col width="64" span="5" />
      <col width="79" />
       <tr>
        <td width="350" align="center" valign="top" colspan="10">
        	<font size="+1"><b>RUMAH SAKIT PELINDO I<br />KOTA MEDAN</b></font> <br />
            <font size="+0"><b>Jl. Pulau Putri Raya, Kel Kelapa indah - kota tangerang <br /> Telp. 021-5997 0200 - 59997 0201, Fax 021 5997 0202</b></font> 
        </td>
      </tr>
      <tr>
        <td width="350" align="right" valign="top" colspan="9">
			<!--<div style="border:solid 1px #000; text-align:center; width:100Px;">RAHASIA</div>		-->
            &nbsp;
        </td>
        <td align="center" valign="top" style="border:1px solid #000;">
			<!--<div style="border:solid 1px #000; text-align:center; width:100Px;">RAHASIA</div>		-->
            RAHASIA
        </td>
      </tr>
      <tr>
        <td style="height:1px;">&nbsp;</td>
        <td style="height:1px;">&nbsp;</td>
        <td style="height:1px;">&nbsp;</td>
        <td style="height:1px;">&nbsp;</td>
        <td style="height:1px;">&nbsp;</td>
        <td style="height:1px;">&nbsp;</td>
        <td style="height:1px;">&nbsp;</td>
        <td style="height:1px;">&nbsp;</td>
        <td style="height:1px;">&nbsp;</td>
        <td style="height:1px;">&nbsp;</td>
     </tr>
      <!--<tr>
        <td width="350" align="left" valign="top"><img src="lap_med_chckup_stat_bdh_wnta_clip_image003.png" alt="" width="350" height="105" />
          <table cellpadding="0" cellspacing="0">
            <tr>
              <td width="72"></td>
            </tr>
          </table></td>
        <td colspan="9" align="right"><table width="316" border="0" style="font:12px tahoma; border:1px solid #000;">
          <tr>
            <td width="116">Nama Pasien</td>
            <td width="10">:</td>
            <td width="174"><span class="gb"><?=$dP['nama']?></span>&nbsp;&nbsp;<span <?php if($dP['sex']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($dP['sex']=='P'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>P</span></td>
          </tr>
          <tr>
            <td>Tanggal Lahir</td>
            <td>:</td>
            <td><span class="gb"><?=tglSQL($dP['tgl_lahir'])?></span> /Usia: <span class="gb"><?=$dP['usia']?></span> Th</td>
          </tr>
          <tr>
            <td>No. R.M.</td>
            <td>:</td>
            <td><span class="gb"><?=$dP['no_rm']?></span>&nbsp;&nbsp;No.Registrasi: <?=$dP['no_reg']?></td>
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
            <td><span class="gb"><?=$dP['alamat_']?></span></td>
          </tr>
        </table></td>
        </tr>-->
      <tr>
        <td></td>
        <td width="35"></td>
        <td width="95"></td>
        <td width="12"></td>
        <td width="48"></td>
        <td width="48"></td>
        <td width="48"></td>
        <td width="48"></td>
        <td width="48"></td>
        <td width="120"></td>
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
        <td align="center" colspan="4" style="border:1px solid #000;"><font size="+2"><b>RESUME MEDIS</b></font></td>
        <td colspan="2" align="center" style="border:1px solid #000; border-left:none;">NRM :<? //$dP['no_rm']?></td>
         <td align="center" style="border:1px solid #000; border-left:none;">&nbsp;<b><?=substr($dP['no_rm'],0,2)?></b></td>
        <td align="center" style="border:1px solid #000; border-left:none;">&nbsp;<b><?=substr($dP['no_rm'],2,2)?></b></td>
        <td align="center" style="border:1px solid #000; border-left:none;">&nbsp;<b><?=substr($dP['no_rm'],4,2)?></b></td>
        <td align="center" style="border:1px solid #000; border-left:none; border-top::none;">&nbsp;<b><?=substr($dP['no_rm'],6,2)?></b></td>
     </tr>
     <tr>
        <td align="left" colspan="4" style="border:1px solid #000; border-top:none;">Nama Pasien : <?=$dP['nama']?></td>
        <td colspan="3" align="left" style="border:1px solid #000; border-left:none; border-top:none;">Tgl Lahir : <span><?=tglSQL($dP['tgl_lahir'])?></span></td>
        <td align="left"  style="border:1px solid #000; border-left:none; border-top:none;">Umur : <span><?=$dP['usia']?></span></td>
        <td align="left" colspan="2" style="border:1px solid #000; border-left:none; border-top:none;">Jenis Kelamin : <span <?php if($dP['sex']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($dP['sex']=='P'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>P</span></td>
     </tr>
     <tr>
        <td align="left" colspan="3" style="border:1px solid #000; border-top:none;">Tanggal Masuk : <?=tglSQL($dK['tgl'])?></td>
        <td colspan="4" align="left" style="border:1px solid #000; border-left:none; border-top:none;">Tanggal Keluar: <?=tglSQL($dP['tgl_keluarP'])?></td>
        <td align="left" colspan="3" style="border:1px solid #000; border-left:none; border-top:none;">Ruang Rawat Terakhir : <?=$dP['nm_unit'];?></td>
     </tr>
     <tr>
        <td align="left" colspan="3" style="border:1px solid #000; border-top:none;">Penanggung Pembayaran : <?=$dP['nm_kso'];?></td>
        <td colspan="7" align="left" style="border:1px solid #000; border-left:none; border-top:none;">Diagnosis/Masalah Waktu Masuk : <?=$dRM['dmasuk'];?></td>
     </tr>
    </table></td>
  </tr>
  <tr>
    <td>
    <table style="font:12px tahoma; border:1px solid #000;">
    <tr>
    <td width="853"><table cellspacing="0" cellpadding="0">
      <col width="21" span="36" />
      <!--<tr>
        <td width="7">&nbsp;</td>
        <td colspan="5">Tanggal    Masuk :</td>
        <td width="17">&nbsp;</td>
        <td colspan="8" class="gb"><?=tglSQL($dK['tgl_in'])?></td>
        <td width="7">&nbsp;</td>
        <td colspan="5">Tanggal    Keluar :</td>
        <td colspan="9" class="gb"><?=tglSQL($dK['tgl_out'])?></td>
        <td width="5">&nbsp;</td>
        <td width="5">&nbsp;</td>
        <td width="21">&nbsp;</td>
        <td width="53">&nbsp;</td>
        <td width="10">&nbsp;</td>
        <td width="21">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="5"><em>Admission Date</em></td>
        <td></td>
        <td width="63"></td>
        <td width="20"></td>
        <td width="11"></td>
        <td width="11"></td>
        <td width="10"></td>
        <td width="10"></td>
        <td width="7"></td>
        <td width="25"></td>
        <td></td>
        <td colspan="5"><em>Discharge Date</em></td>
        <td width="5"></td>
        <td width="7"></td>
        <td width="16"></td>
        <td width="16"></td>
        <td width="16"></td>
        <td width="16"></td>
        <td width="16"></td>
        <td width="56"></td>
        <td width="7"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="42"></td>
        <td width="17"></td>
        <td width="17"></td>
        <td width="13"></td>
        <td width="8"></td>
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
        <td width="35"></td>
        <td width="11"></td>
        <td width="11"></td>
        <td width="11"></td>
        <td width="35"></td>
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
      <tr>
        <td>&nbsp;</td>
        <td colspan="4">Alasan Pulang</td>
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
      <tr>
        <td>&nbsp;</td>
        <td colspan="5">Discharge Reason</td>
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
      <tr>
        <td>&nbsp;</td>
        <td align="right"><input type="checkbox" name="checkbox" id="checkbox" disabled="disabled" <?php if(strtolower($dP['cara_keluar'])=='atas ijin dokter'){ echo 'checked="checked"';}?>/></td>
        <td colspan="3">Pulang</td>
        <td></td>
        <td><input type="checkbox" name="checkbox" id="checkbox" disabled="disabled"  <?php if(strtolower($dP['cara_keluar'])=='pulang paksa'){ echo 'checked="checked"';}?>/></td>
        <td colspan="4">Pulang Paksa</td>
        <td></td>
        <td></td>
        <td><input type="checkbox" name="checkbox" id="checkbox" disabled="disabled" <?php if(strtolower($dP['cara_keluar'])=='dirujuk'){ echo 'checked="checked"';}?>/></td>
        <td colspan="5">Pindah RS Lain</td>
        <td></td>
        <td></td>
        <td></td>
        <td><input type="checkbox" name="checkbox" id="checkbox" disabled="disabled" <?php if(strtolower($dP['cara_keluar'])=='APS'){ echo 'checked="checked"';}?>/></td>
        <td colspan="6">Perawatan di Rumah</td>
        <td></td>
        <td><input type="checkbox" name="checkbox" id="checkbox" disabled="disabled" <?php if(strtolower($dP['cara_keluar'])=='meninggal'){ echo 'checked="checked"';}?>/></td>
        <td colspan="3">Meninggal</td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td colspan="2"><em>Home</em></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="6"><em>Againts hospitalize</em></td>
        <td></td>
        <td colspan="8"><em>Tranferred to other    hospital</em></td>
        <td></td>
        <td colspan="4"><em>Home Care</em></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3"><em>Date</em></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
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
      <tr>
        <td>&nbsp;</td>
        <td colspan="7" valign="top">Anamnesis<br/><em>Anamnese</em></td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26"><table width="100%" border="0">
          <?php $sqlA="SELECT KU FROM anamnese a WHERE a.PEL_ID='".$idPel."' AND a.KUNJ_ID='".$idKunj."';";
$exA=mysql_query($sqlA);
while($dA=mysql_fetch_array($exA)){
?>
          <tr>
            <td class="gb"><?=$dA['KU']?></td>
            </tr>
          <?php }?>  
          </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="26" >&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="8">Riwayat Perjalanan    Penyakit<br/><em>History of Illness(es)</em></td>
        <td>:</td>
        <td colspan="26"><table width="100%" border="0">
          <?php $sqlA="SELECT KU FROM anamnese a WHERE a.PEL_ID='".$idPel."' AND a.KUNJ_ID='".$idKunj."';";
$exA=mysql_query($sqlA);
while($dA=mysql_fetch_array($exA)){
?>
          <tr>
            <td class="gb"><?=$dA['KUz']?>-</td>
            </tr>
          <?php }?>  
          </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="26">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7" valign="top">Pemeriksaan Fisik<br/><em>Physical Examination</em></td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26"><table width="100%" border="0">
          <?php $sqlA="SELECT KU FROM anamnese a WHERE a.PEL_ID='".$idPel."' AND a.KUNJ_ID='".$idKunj."';";
$exA=mysql_query($sqlA);
while($dA=mysql_fetch_array($exA)){
?>
          <tr>
            <td class="gb"><?=$dA['KUz']?>-</td>
            </tr>
          <?php }?>  
          </table>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="26" >&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7">Penemuan Kinik(Lab, Rontgen, dll)<br/><em>Clinical Findings</em></td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26"><table width="100%" border="0">
          <?php $sqlA="SELECT KU FROM anamnese a WHERE a.PEL_ID='".$idPel."' AND a.KUNJ_ID='".$idKunj."';";
$exA=mysql_query($sqlA);
while($dA=mysql_fetch_array($exA)){
?>
          <tr>
            <td class="gb"><?=$dA['KUz']?>-</td>
            </tr>
          <?php }?>  
          </table>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="26" >&nbsp;</td>
      </tr>-->
      <tr>
        <td>&nbsp;</td>
        <td colspan="7" valign="top">Ringkasan Riwayat Penyakit</td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26" valign="top"><?=$dRM['rpenyakit'];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7" valign="top">Pemeriksaan Fisik</td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26" valign="top"><?=$dRM['pemeriksaanf'];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7" valign="top">Pemeriksaan Penunjang / Diagnostik Terpenting</td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26" valign="top"><?=$dRM['ppenunjang'];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7" valign="top">Terapi/Pengobatan selama dirumah sakit</td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26" valign="top"><?=$dRM['terapip'];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7" valign="top">Hasil Konsultasi</td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26" valign="top"><?=$dRM['hkonsultasi'];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7" valign="top">Diagnosa Utama</td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26" style="margin:0; padding:0;"><table width="100%" border="0">
        <tr>
            <td width="78%">&nbsp;</td>
            <td width="22%" align="center" style="">ICD10</td>
       </tr>
       <tr>
            <td width="78%">&nbsp;</td>
            <td width="22%" align="center" style="">&nbsp;</td>
       </tr>
          <?php $sqlD="SELECT IF(md.nama IS NULL,d.diagnosa_manual,md.nama) AS nama,md.dg_kode, md1.kode, d.diagnosa_id
FROM b_diagnosa d
LEFT JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
LEFT JOIN b_diagnosa_rm rm ON rm.diagnosa_id = d.diagnosa_id
LEFT JOIN b_ms_diagnosa md1 ON rm.ms_diagnosa_id = md1.id
WHERE d.pelayanan_id='$idPel' AND d.primer = 1;";
//echo $sqlD."<br>";
$exD=mysql_query($sqlD);
while($dD=mysql_fetch_array($exD)){
?>
          <tr>
            <td class="gb">
				<?
					$queryB = "SELECT diagnosa_manual FROM b_diagnosa WHERE diag_banding_id = ".$dD['diagnosa_id']."";
					$ExqueryB = mysql_query($queryB);
                	echo $dD['nama'];
					while($DqueryB = mysql_fetch_array($ExqueryB))
					{
						echo "/".$DqueryB['diagnosa_manual'];
					}
				?>
            </td>
            <td align="center" class="gb" style=""><?=$dD['kode']?></td>
            </tr>
          <?php }?>  
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7" valign="top">Diagnosa Sekunder</td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26" style="margin:0; padding:0;"><table width="100%" border="0">
          <?php $sqlD="SELECT IF(md.nama IS NULL,d.diagnosa_manual,md.nama) AS nama,md.dg_kode, md1.kode, d.diagnosa_id
FROM b_diagnosa d
LEFT JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
LEFT JOIN b_diagnosa_rm rm ON rm.diagnosa_id = d.diagnosa_id
LEFT JOIN b_ms_diagnosa md1 ON rm.ms_diagnosa_id = md1.id
WHERE d.pelayanan_id='$idPel' AND d.primer = 0 AND d.diag_banding_id = 0;";
//echo $sqlD."<br>";
$exD=mysql_query($sqlD);
while($dD=mysql_fetch_array($exD)){
?>
          <tr>
            <td class="gb">
				<?
					$queryB = "SELECT diagnosa_manual FROM b_diagnosa WHERE diag_banding_id = ".$dD['diagnosa_id']."";
					$ExqueryB = mysql_query($queryB);
                	echo $dD['nama'];
					while($DqueryB = mysql_fetch_array($ExqueryB))
					{
						echo "/".$DqueryB['diagnosa_manual'];
					}
				?>
            </td>
            <td align="center" class="gb" style=""><?=$dD['kode']?></td>
            </tr>
          <?php }?>  
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="26" >&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7" valign="top">Tindakan / Prosedur</td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26" style="margin:0; padding:0;"><table width="100%" border="0">
          <?php /*$sqlT="select * from
        (SELECT t.id, t.qty, t.biaya, t.qty * t.biaya as subtotal, t.kunjungan_id, t.ms_tindakan_kelas_id, t.pelayanan_id, t.ket, t.unit_act, tk.tarip, tin.nama
        , tin.kode,ifnull(p.nama,'-') as dokter,t.ms_tindakan_unit_id,t.user_id,k.nama as kelas, t.type_dokter,t.tgl_act as tanggal, tin.klasifikasi_id, peg.nama AS petugas, icd.kode_icd_9cm
	FROM b_tindakan t
	INNER JOIN b_pelayanan pl ON pl.id = t.pelayanan_id
	INNER JOIN b_ms_tindakan_kelas tk ON tk.id = t.ms_tindakan_kelas_id
	INNER JOIN b_ms_kelas k ON tk.ms_kelas_id=k.id
	INNER JOIN b_ms_tindakan tin ON tin.id = tk.ms_tindakan_id
	LEFT JOIN b_ms_pegawai p ON p.id=t.user_id
	LEFT JOIN b_ms_pegawai peg ON peg.id=t.user_act
	LEFT JOIN b_tindakan_icd9cm icd ON t.id = icd.b_tindakan_id
	WHERE t.pelayanan_id = '".$idPel."') as gab";*/
	/* $sqlT="select * from
        (SELECT DISTINCT tin.nama, tin.kode, icd.kode_icd_9cm 
	FROM b_tindakan t
	INNER JOIN b_pelayanan pl ON pl.id = t.pelayanan_id AND t.user_id = pl.dokter_tujuan_id
	INNER JOIN b_ms_tindakan_kelas tk ON tk.id = t.ms_tindakan_kelas_id
	INNER JOIN b_ms_kelas k ON tk.ms_kelas_id=k.id
	INNER JOIN b_ms_tindakan tin ON tin.id = tk.ms_tindakan_id
	LEFT JOIN b_ms_pegawai p ON p.id=t.user_id
	LEFT JOIN b_ms_pegawai peg ON peg.id=t.user_act
	LEFT JOIN b_tindakan_icd9cm icd ON t.id = icd.b_tindakan_id
	WHERE((t.pelayanan_id = '".$idPel."') OR (pl.kunjungan_id = '".$idKunj."' 
AND pl.unit_id IN ('63','72'))) AND tin.id NOT IN (74,3076,3090,2333) and tin.kel_tindakan_id NOT IN (61,304)) as gab"; */
	/*$sqlT="select * from
        (SELECT DISTINCT tin.nama, tin.kode, icd.kode_icd_9cm 
	FROM b_tindakan t
	INNER JOIN b_pelayanan pl ON pl.id = t.pelayanan_id
	INNER JOIN b_ms_tindakan_kelas tk ON tk.id = t.ms_tindakan_kelas_id
	INNER JOIN b_ms_kelas k ON tk.ms_kelas_id=k.id
	INNER JOIN b_ms_tindakan tin ON tin.id = tk.ms_tindakan_id
	LEFT JOIN b_ms_pegawai p ON p.id=t.user_id
	LEFT JOIN b_ms_pegawai peg ON peg.id=t.user_act
	LEFT JOIN b_tindakan_icd9cm icd ON t.id = icd.b_tindakan_id
	WHERE pl.kunjungan_id = '".$idKunj."' 
AND (pl.unit_id IN ('63','72','65') OR tin.id in (1003,530,945,739,530,388,396,738,458,524,541,539,548,540,326,50,1200,1022,95,36921528,1735,1736,1737,1738,1739,1743,1746,1747,1748,1756,1757,1758,1759,3167,3691,1732,1733,1734,1740,1741,1742,1744,1745,1749,1750,1751,1752,1753,2363,2364,3109,100,331,1055,982,13,972,763,1694,1695,1696,91,90,94,326,1038,1039,95,994)) AND tin.id NOT IN (74,3076,3090,2333) and tin.kel_tindakan_id NOT IN (61,304)) as gab";*/
	$sqlT = "SELECT * FROM (SELECT DISTINCT tin.nama, tin.kode, icd.kode_icd_9cm 
FROM b_tindakan t INNER JOIN b_pelayanan pl ON pl.id = t.pelayanan_id AND pl.jenis_kunjungan = 3
INNER JOIN b_ms_tindakan_kelas tk ON tk.id = t.ms_tindakan_kelas_id 
INNER JOIN b_ms_kelas k ON tk.ms_kelas_id=k.id 
INNER JOIN b_ms_tindakan tin ON tin.id = tk.ms_tindakan_id 
LEFT JOIN b_ms_pegawai p ON p.id=t.user_id  AND p.spesialisasi_id <> 0
INNER JOIN b_ms_pegawai peg ON peg.id=t.user_act and peg.spesialisasi_id <> 0
LEFT JOIN b_tindakan_icd9cm icd ON t.id = icd.b_tindakan_id 
WHERE pl.kunjungan_id = '".$idKunj."' AND tin.id NOT IN (61,67,68,69,70,71,72,73,74,967,968,1008,1029,3076,3089,3090,3091,3092,3182,3183,3184)) AS gab ORDER BY nama;";
	//echo $sqlT."<br>";
$exT=mysql_query($sqlT);
$jml = mysql_num_rows($exT);
if($jml > 0)
{
	?>
    	<tr>
        	<td>&nbsp;</td>
            <td>ICD 9CM</td>
        </tr>
    <?
}
while($dT=mysql_fetch_array($exT)){
?>
          <tr>
            <td class="gb"><?=$dT['nama']?></td>
            <td class="gb"><?=$dT['kode_icd_9cm']?></td>
            </tr>
          <?php }?>  
          <tr>
            <td class="gb">&nbsp;</td>
            <td class="gb">&nbsp;</td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="26">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7" valign="top">Alergi (reaksi obat)</td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26" valign="top"><?=$dRM['alergi'];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7" valign="top">Hasil Laboratorium belum selesai (pending)</td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26" valign="top"><?=$dRM['hasillab'];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7" valign="top">Diet</td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26" valign="top"><?=$dRM['diet'];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7" valign="top">Intruksi/Anjuran dan Edukasi (<i>Follow up</i>)</td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26" valign="top"><?=$dRM['anjuran']?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="6">Kondisi Waktu Keluar</td>
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
        <td>&nbsp;</td>
        <td align="right"><input type="checkbox" name="checkbox" id="checkbox" disabled="disabled" <?php if(strtolower($dP['cara_keluar'])=='atas ijin dokter'){ echo 'checked="checked"';}?>/></td>
        <td colspan="3">Sembuh</td>
        <td></td>
        <td><input type="checkbox" name="checkbox" id="checkbox" disabled="disabled" <?php if(strtolower($dP['cara_keluar'])=='dirujuk'){ echo 'checked="checked"';}?>/></td>
        <td colspan="4">Pindah RS Lain</td>
        <td><input type="checkbox" name="checkbox" id="checkbox" disabled="disabled"  <?php if((strtolower($dP['cara_keluar'])=='pulang paksa') || (strtolower($dP['cara_keluar'])=='aps')){ echo 'checked="checked"';}?>/></td>
        <td colspan="8">Pulang Atas Permintaan Sendiri</td>
        <td></td>
        <td><input type="checkbox" name="checkbox" id="checkbox" disabled="disabled" <?php if(strtolower($dP['cara_keluar'])=='meninggal'){ echo 'checked="checked"';}?>/></td>
        <td colspan="6">Meninggal</td>
        <td></td>
        <td><input type="checkbox" name="checkbox" id="checkbox" disabled="disabled" <?php if((strtolower($dP['cara_keluar'])!='atas ijin dokter') && (strtolower($dP['cara_keluar'])!='dirujuk') && (strtolower($dP['cara_keluar'])!='pulang paksa') && (strtolower($dP['cara_keluar'])!='meninggal') && (strtolower($dP['cara_keluar'])!='aps')){ echo 'checked="checked"';}?>/></td>
        <td colspan="3">&nbsp;<?
		if((strtolower($dP['cara_keluar']) != "dirujuk") && (strtolower($dP['cara_keluar']) != "atas ijin dokter") && (strtolower($dP['cara_keluar']) != "aps") && (strtolower($dP['cara_keluar']) != "pulang paksa") && (strtolower($dP['cara_keluar']) != "meninggal"))
		{
        	echo strtolower($dP['cara_keluar']);
		}
		?></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="8">Pengobatan Dilanjutkan</td>
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
        <td>&nbsp;</td>
        <td align="right"><input type="checkbox" name="pol1" id="pol1" class="ck12" onclick="cekKl(this.id);" value="1" disabled="disabled" <?php if(strtolower($dRM['dilanjutkan'])=='1'){ echo 'checked="checked"';}?>/></td>
        <td colspan="3">Poli Klinik</td>
        <td></td>
        <td><input type="checkbox" name="RSL" id="RSL" class="ck12" onclick="cekKl(this.id);" value="2" disabled="disabled" <?php if(strtolower($dRM['dilanjutkan'])=='2'){ echo 'checked="checked"';}?>/></td>
        <td colspan="4">Rs. Lain</td>
        <td></td>
        <td></td>
        <td><input type="checkbox" name="puskesmas" id="puskesmas" class="ck12" onclick="cekKl(this.id);" value="3" disabled="disabled" <?php if(strtolower($dRM['dilanjutkan'])=='3'){ echo 'checked="checked"';}?>/></td>
        <td colspan="5">Puskesmas</td>
        <td></td>
        <td></td>
        <td></td>
        <td><input type="checkbox" name="drluar" id="drluar" class="ck12" onclick="cekKl(this.id);" value="4" disabled="disabled" <?php if(strtolower($dRM['dilanjutkan'])=='4'){ echo 'checked="checked"';}?>/></td>
        <td colspan="6">Dokter luar</td>
        <td></td>
        <td><input type="checkbox" name="lll1" id="lll1" class="ck12" onclick="cekKl(this.id);" value="5" disabled="disabled" <?php if($dRM['dilanjutkan']!='1' && $dRM['dilanjutkan']!='2' && $dRM['dilanjutkan']!='3' && $dRM['dilanjutkan']!='4' && $dRM['dilanjutkan']!='' && $dRM['dilanjutkan']!=' '){ echo 'checked="checked"';}?>/></td>
        <td colspan="3">
        <input type="text" class="inputan" id="lain" disabled="disabled" name="lain" <?php if($dRM['dilanjutkan']!='1' && $dRM['dilanjutkan']!='2' && $dRM['dilanjutkan']!='3' && $dRM['dilanjutkan']!='4' && $dRM['dilanjutkan']!='' && $dRM['dilanjutkan']!=' '){ echo 'value="$dRM[dilanjutkan]"';}?> />
        </td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="8">Tanggal Kontrol poliklinik :</td>
        <td><?=$dRM['lanjut1']?></td>
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
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="26">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="34" align="center"><strong>TERAPI PULANG</strong></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  	</tr>
    <tr>
    <td align="center">
    <div id="inObat">
    <table width="781" border="1" id="tblObat" cellpadding="2" style="border-collapse:collapse;">
       <tr>
         <td rowspan="2" align="center">Nama Obat</td>
         <td rowspan="2" align="center">Jumlah</td>
         <td rowspan="2" align="center">Dosis</td>
         <td rowspan="2" align="center">Frekuensi</td>
         <td rowspan="2" align="center">Cara Pemberian</td>
         <td colspan="6" align="center">Jam Pemberian</td>
         <td rowspan="2" align="center">Petunjuk Khusus</td>
       </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        </tr>
        <?php
		if($dRM[0]==""){$ini="1a";}else{$ini=$dRM[0];} 
		$sqlD=mysql_query("SELECT * FROM b_fom_resum_medis_detail_new WHERE resum_medis_id='$ini'");
		while($dtD=mysql_fetch_array($sqlD)){
				$txt_jam=explode('|',$dtD['jam_pemberian']);
		?>
      <tr>
        <td align="center"><?=$dtD['nama_obat']?></td>
        <td align="center"><?=$dtD['jml']?></td>
        <td align="center"><?=$dtD['dosis']?></td>
        <td align="center"><?=$dtD['frekuensi']?></td>
        <td align="center"><?=$dtD['cara_beri']?></td>
        <td align="center"><?=$txt_jam[0]?></td>
        <td align="center"><?=$txt_jam[1]?></td>
        <td align="center"><?=$txt_jam[2]?></td>
        <td align="center"><?=$txt_jam[3]?></td>
        <td align="center"><?=$txt_jam[4]?></td>
        <td align="center"><?=$txt_jam[5]?></td>
        <td align="center"><?=$dtD['petunjuk']?></td>
        </tr>
        <?php }?>
    </table>
    </div>
    </td>
  	</tr>
  	<tr>
    <td><table cellspacing="0" cellpadding="0">
   
      <tr>
        <td width="21">&nbsp;</td>
        <td width="21"></td>
        <td width="21"></td>
        <td width="21"></td>
        <td width="21"></td>
        <td width="21"></td>
        <td width="21"></td>
        <td width="21"></td>
        <td width="21"></td>
        <td width="21"></td>
        <td width="21"></td>
        <td width="21"></td>
        <td width="21"></td>
        <td width="21"></td>
        <td width="21"></td>
        <td width="21"></td>
        <td width="21"></td>
        <td width="21"></td>
        <td width="21"></td>
        <td width="21"></td>
        <td width="21"></td>
        <td width="21"></td>
        <td width="21"></td>
        <td width="21"></td>
        <td colspan="11">Tanggal : 
		<?
			if($dP['tgl_keluarP']=="")
			{
        		echo tgl_ina(date('Y-m-d'));
			}else{
				echo tgl_ina($dP['tgl_keluarP']);
			}
		?>
        </td>
        <td width="21">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="11">Jam : <?=date('H:i:s')?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="11"><strong>Dokter  yang merawat</strong></td>
        <td>&nbsp;</td>
      </tr>
      <!--<tr>
        <td>&nbsp;</td>
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

        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="11">Attending Doctor</td>
        <td>&nbsp;</td>
      </tr>-->
      <tr>
        <td>&nbsp;</td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td width="105"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td width="21"></td>
        <td width="21"></td>
        <td width="21"></td>
        <td width="21"></td>
        <td width="21"></td>
        <td width="21"></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
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
      <tr>
        <td>&nbsp;</td>
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
      <tr>
        <td>&nbsp;</td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="11" align="center">(<?=$dRM1['nama_usr'];?>)</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
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
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="9">Tanda Tangan &amp; Nama    Lengkap</td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
     <!-- <tr>
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
        <td colspan="7"><strong><em>Signature &amp; full Name</em></strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>-->
      <?php
        	$queryReg = "SELECT b.nama FROM b_kunjungan a
							INNER JOIN b_ms_pegawai b ON a.user_act = b.id
							WHERE a.id = '".$_REQUEST['idKunj']."';";
			$dqueryReg = mysql_fetch_array(mysql_query($queryReg));
			$querCoding = "SELECT DISTINCT b.nama FROM b_diagnosa_rm a
				 			INNER JOIN b_pelayanan b1 ON a.pelayanan_id = b1.id
							INNER JOIN b_ms_pegawai b ON a.user_act = b.id 
							WHERE a.kunjungan_id = '".$_REQUEST['idKunj']."' AND b1.jenis_kunjungan = 3 ORDER BY a.id DESC;";
			$dquerCoding = mysql_fetch_array(mysql_query($querCoding));
			
		?>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7">Lembar 1 : Pasien</td>
        <td></td>
        <td></td>
        <td colspan="26" align="right">&nbsp; Printed By : <? echo $_SESSION['nm_pegawai'];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7">Lembar 2 : Rekam Medis</td>
        <td></td>
        <td></td>
        <td colspan="26" align="right">&nbsp; Registration By : <? echo $dqueryReg['nama'];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7">Lembar 3 : Penjamin</td>
        <td></td>
        <td></td>
        <td colspan="26" align="right">&nbsp;
        Coding By : <? echo $dquerCoding['nama'];?> <br />
        Dokter By : <? echo $dRM1['nama_usr'];//$_SESSION['nm_pegawai']; ?>
        </td>
      </tr>
    </table>
    </td>
  	</tr>
    </table>
    </td>
  </tr>
  <tr>
  	<td>
    	<span style="font-size:14px">
        Resume Elektronik Ini Syah Tanpa Tanda Tangan <br />
        UU Praktek Kedokteran No. 29/2004 Penjelasan Pasal 46(3)
        </span>
    </td>
  </tr>
   <tr id="trTombol">
  <td align="center">
  <input type="submit" name="button" id="button" value="Cetak" onclick="cetak(document.getElementById('trTombol'));" />
   									<input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
  </td>
  </tr>
</table>
</body>
</html>
<script>
    function cetak(tombol){
        tombol.style.visibility='collapse';
        if(tombol.style.visibility=='collapse'){
            if(confirm('Anda yakin mau mencetak ?')){
                /*setTimeout('window.print()','1000');
                setTimeout('window.close()','2000');*/
				window.print();
                window.close();
            }
            else{
                tombol.style.visibility='visible';
            }

        }
    }

</script>