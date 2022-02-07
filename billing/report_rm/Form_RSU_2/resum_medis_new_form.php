<?php
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
//echo $idKunj."<br>";
$sqlP="SELECT p.*,bk.no_reg,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,
k.cara_keluar, DATE_FORMAT(bk.tgl_pulang,'%Y-%m-%d') AS tgl_keluarP, bmk.nama as nm_kso
FROM b_pelayanan pl
INNER JOIN b_kunjungan bk ON pl.kunjungan_id=bk.id and bk.id=$idKunj
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_pasien_keluar k ON k.pelayanan_id=pl.id
LEFT JOIN b_ms_kso bmk ON pl.kso_id = bmk.id
WHERE pl.id='$idPel';";
//echo $sqlP."<br>";
$dP=mysql_fetch_array(mysql_query($sqlP));
$sqlKm="SELECT tk.tgl_in,tk.tgl_out, bk.tgl FROM b_tindakan_kamar tk 
LEFT JOIN b_pelayanan p ON p.id=tk.pelayanan_id and kunjungan_id = $idKunj
INNER JOIN b_kunjungan bk on bk.id = p.kunjungan_id and bk.id=$idKunj
WHERE tk.pelayanan_id='$idPel';";
$dK=mysql_fetch_array(mysql_query($sqlKm));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../../theme/mod.css" />
        <script type="text/javascript" language="JavaScript" src="../../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../../theme/js/dsgrid.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../../jquery.js"></script>
        <script type="text/javascript" src="../../jquery.form.js"></script>
        <script type="text/javascript" language="javascript" src="../../loket/jquery.maskedinput.js"></script>
        <!-- end untuk ajax-->
        <title>RESUM MEDIS</title>
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
    <body>
        <div align="center">
            <?php
           // include("../../header1.php");
            ?>
            <iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
          <!--  <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;FORM RESUM MEDIS</td>
                </tr>
            </table>-->
            <table width="1000" border="0" cellspacing="0" cellpadding="2" align="center" >
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="3" align="center"><div id="form_in" style="display:none;">
                <form name="form1" id="form1" action="resume_medis_new_act.php">
                <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="txtId" id="txtId"/>
                <input type="hidden" id="report" name="report" value="<?php echo $_REQUEST['report'];?>" />
    			<input type="hidden" name="act" id="act" value="tambah"/>
                <input type="hidden" name="lanjut1" id="lanjut1" value=""/>
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
            <td><span class="gb"><?=$dP['alamat']?></span></td>
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
        <td align="left" colspan="3" style="border:1px solid #000; border-top:none;">Penanggung Pembayaran : <?=$dP['nm_kso']?><input type="text" name="pJawabPem" id="pJawabPem" class="inputan" style="display:none;" /></td>
        <td colspan="7" align="left" style="border:1px solid #000; border-left:none; border-top:none;">Diagnosis/Masalah Waktu Masuk : <input type="text" name="DWaktuMasuk" id="DWaktuMasuk" size="40" /></td>
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
            <td class="gb"><?=$dA['KUz']?></td>
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
            <td class="gb"><?=$dA['KUz']?></td>
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
            <td class="gb"><?=$dA['KUz']?></td>
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
        <td colspan="26" valign="top"><textarea name="txt_riwayat_pen" rows="5" class="textArea" id="txt_riwayat_pen" ></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7" valign="top">Pemeriksaan Fisik</td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26" valign="top"><textarea name="txt_pemeriksaan_fisik" rows="5" class="textArea" id="txt_pemeriksaan_fisik" ></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7" valign="top">Pemeriksaan Penunjang / Diagnostik Terpenting</td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26" valign="top"><textarea name="txt_pemeriksaan" rows="5" class="textArea" id="txt_pemeriksaan" ></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7" valign="top">Terapi/Pengobatan selama dirumah sakit</td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26" valign="top"><textarea name="txt_terapi" rows="5" class="textArea" id="txt_terapi" ></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7" valign="top">Hasil Konsultasi</td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26" valign="top"><textarea name="txt_hasil_konsul" rows="5" class="textArea" id="txt_hasil_konsul" ></textarea></td>
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
	WHERE ((t.pelayanan_id = '".$idPel."') OR (pl.kunjungan_id = '".$idKunj."' 
AND pl.unit_id IN ('63','72'))) AND tin.id NOT IN (74,3076,3090,2333) and tin.kel_tindakan_id NOT IN (61,304)) as gab"; */
	/*$sqlT="select * from
        (SELECT DISTINCT tin.nama, tin.kode, icd.kode_icd_9cm 
	FROM b_tindakan t
	INNER JOIN b_pelayanan pl ON pl.id = t.pelayanan_id
	INNER JOIN b_ms_tindakan_kelas tk ON tk.id = t.ms_tindakan_kelas_id
	INNER JOIN b_ms_kelas k ON tk.ms_kelas_id=k.id
	INNER JOIN b_ms_tindakan tin ON tin.id = tk.ms_tindakan_id
	LEFT JOIN b_ms_pegawai p ON p.id=t.user_id
	LEFT JOIN b_ms_pegawai peg ON peg.id=t.user_act and peg.spesialisasi_id <> 0
	LEFT JOIN b_tindakan_icd9cm icd ON t.id = icd.b_tindakan_id
	WHERE pl.kunjungan_id = '".$idKunj."' 
AND (pl.unit_id IN ('63','72','65') OR tin.id in (1003, 530,945,739,530,388,396,738,458,524,541,539,548,540,326,50,1200,1022,95,3692,1528,1735,1736,1737,1738,1739,1743,1746,1747,1748,1756,1757,1758,1759,3167,3691,1732,1733,1734,1740,1741,1742,1744,1745,1749,1750,1751,1752,1753,2363,2364,3109,100,331,1055,982,13,972,763,1694,1695,1696,91,90,94,326,1038,1039,95,994)) AND tin.id NOT IN (74,3076,3090,2333) and tin.kel_tindakan_id NOT IN (61,304)) as gab";*/
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
        <td colspan="26" valign="top"><textarea name="txt_alergi" rows="5" class="textArea" id="txt_alergi" ></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7" valign="top">Hasil Laboratorium belum selesai (pending)</td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26" valign="top"><textarea name="txt_hasil_lab" rows="5" class="textArea" id="txt_hasil_lab" ></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7" valign="top">Diet</td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26" valign="top"><textarea name="txt_diet" rows="5" class="textArea" id="txt_diet" ></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7" valign="top">Intruksi/Anjuran dan Edukasi (<i>Follow up</i>)</td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26" valign="top"><textarea name="txt_anjuran" rows="5" class="textArea" id="txt_anjuran" ></textarea></td>
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
        <td><input type="checkbox" name="checkbox" id="checkbox" disabled="disabled"  <?php if(strtolower($dP['cara_keluar'])=='pulang paksa'){ echo 'checked="checked"';}?>/></td>
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
        <td align="right"><input type="checkbox" name="pol1" id="pol1" class="ck12" onclick="cekKl(this.id);" value="1"/></td>
        <td colspan="3">Poli Klinik</td>
        <td></td>
        <td><input type="checkbox" name="RSL" id="RSL" class="ck12" onclick="cekKl(this.id);" value="2"/></td>
        <td colspan="4">Rs. Lain</td>
        <td></td>
        <td></td>
        <td><input type="checkbox" name="puskesmas" id="puskesmas" class="ck12" onclick="cekKl(this.id);" value="3"/></td>
        <td colspan="5">Puskesmas</td>
        <td></td>
        <td></td>
        <td></td>
        <td><input type="checkbox" name="drluar" id="drluar" class="ck12" onclick="cekKl(this.id);" value="4"/></td>
        <td colspan="6">Dokter luar</td>
        <td></td>
        <td><input type="checkbox" name="lll1" id="lll1" class="ck12" onclick="cekKl(this.id);" value="5"/></td>
        <td colspan="3">
        <input type="text" class="inputan" id="lain" disabled="disabled" name="lain" />
        </td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="8">Tanggal Kontrol poliklinik :</td>
        <td><input type="text" class="inputan" id="tglPoli" name="tglPoli" /></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
        <td colspan="13" align="right"><input type="button" name="button" id="button" value="Tambah" onClick="addRowToTable();return false;"/></td>
        </tr>
      <tr>
        <td rowspan="2" align="center">Nama Obat</td>
        <td rowspan="2" align="center">Jumlah</td>
        <td rowspan="2" align="center">Dosis</td>
        <td rowspan="2" align="center">Frekuensi</td>
        <td rowspan="2" align="center">Cara Pemberian</td>
        <td colspan="6" align="center">Jam Pemberian</td>
        <td rowspan="2" align="center">Petunjuk Khusus</td>
        <td rowspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        </tr>
      <tr>
        <td align="center"><label for="txt_obat[]"></label>
          <input name="txt_obat[]" type="text" class="inputan" id="txt_obat[]" /></td>
        <td align="center"><input name="txt_jumlah[]" type="text" id="txt_jumlah[]" size="5" /></td>
        <td align="center"><input name="txt_dosis[]" type="text" id="txt_dosis[]" size="5" /></td>
        <td align="center"><input name="txt_frek[]" type="text" id="txt_frek[]" size="5" /></td>
        <td align="center"><input name="txt_beri[]" type="text" class="inputan" id="txt_beri[]" /></td>
        <td align="center"><input name="txt_jam1[]" type="text" id="txt_jam1[]" size="5" /></td>
        <td align="center"><input name="txt_jam2[]" type="text" id="txt_jam2[]" size="5" /></td>
        <td align="center"><input name="txt_jam3[]" type="text" id="txt_jam3[]" size="5" /></td>
        <td align="center"><input name="txt_jam4[]" type="text" id="txt_jam4[]" size="5" /></td>
        <td align="center"><input name="txt_jam5[]" type="text" id="txt_jam5[]" size="5" /></td>
        <td align="center"><input name="txt_jam6[]" type="text" id="txt_jam6[]" size="5" /></td>
        <td align="center"><input name="txt_petunjuk[]" type="text" class="inputan" id="txt_petunjuk[]" /></td>
        <td align="center" valign="middle"><img alt="del" src="../../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del')}"></td>
      </tr>
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
     <!-- <tr>
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
        <td colspan="11">(                                            )</td>
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
      <!--<tr>
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
       <tr>
        <td>&nbsp;</td>
        <td colspan="7">Lembar 1 : Pasien</td>
        <td></td>
        <td></td>
        <td colspan="26">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7">Lembar 2 : Rekam Medis</td>
        <td></td>
        <td></td>
        <td colspan="26">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7">Lembar 3 : Penjamin</td>
        <td></td>
        <td></td>
        <td colspan="26">&nbsp;</td>
      </tr>
    </table></td>
  	</tr>
    </table>
    </td>
  </tr>
</table>
             </form>   
             <div align="center"><input type="button" name="bt_save" id="bt_save" class="tblTambah" value="Simpan" onclick="return simpan()" />&nbsp;
  <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/></div>
                </div></td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="45%"><?php
                   // if($_REQUEST['report']!=1){
					?>
                        <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Edit" onclick="edit();" class="tblTambah"/>
                        <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>
                  <?php //}?></td>
                    <td width="20%"><button type="button" id="btnTree" name="btnTree" value="Tampilan Tree" onclick="cetak()" class="tblViewTree" >Cetak</button></td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="left" colspan="3">
                        <div id="gridbox" style="width:900px; height:300px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:900px;"></div></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
  <!--    <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
                <tr>
                    <td height="30">&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;"/></td>
                    <td></td>
                    <td align="right">
                        <a href="<?=$host?>/simrs-tangerang/billing/index.php">
                            <input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;"/>
                        </a>&nbsp;
                    </td>
        </tr>
          </table>-->
        </div>
    </body>
<script type="text/javascript">

		function toggle() {
    parent.alertsize(document.body.scrollHeight);
}


        function simpan(action){
            if(ValidateForm('txt_anjuran','ind')){
				if(document.getElementById("lll1").checked == true)
				{
					document.getElementById("lanjut1").value = document.getElementById("lain").value;
				}else if(document.getElementById("pol1").checked == true){
					document.getElementById("lanjut1").value = 1;
				}else if(document.getElementById("RSL").checked == true){
					document.getElementById("lanjut1").value = 2;
				}else if(document.getElementById("puskesmas").checked == true){
					document.getElementById("lanjut1").value = 3;
				}else if(document.getElementById("drluar").checked == true){
					document.getElementById("lanjut1").value = 4;
				}
				
				//alert(document.getElementById("lanjut1").value);
				//return false;
				$("#form1").ajaxSubmit({
					  success:function(msg)
					  {
						//alert(msg);
						batal();
						goFilterAndSort();
					  },
					});
			
            }
        }
		
		jQuery(document).ready(function(){
			jQuery("#tglPoli").mask("99-99-9999");
		});
		
        
        function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            Request('../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
        }

        //isiCombo('cakupan','','','cakupan','');

        function setCakupan(val){
            if(val == 4){
                document.getElementById('tr_cakupan').style.display = 'table-row';
            }
            else{
                document.getElementById('tr_cakupan').style.display = 'none';
            }
        }
		
		function urldecode(str) {
  return decodeURIComponent((str + '')
    .replace(/%(?![\da-f]{2})/gi, function() {
      // PHP tolerates poorly formed escape sequences
      return '%25';
    })
    .replace(/\+/g, '%20'));
}

        function ambilData(){		
			jQuery(".ck12").removeAttr("checked");
			document.getElementById("lain").value = "";
			document.getElementById("lain").disabled = true;
		
            var sisip = a.getRowId(a.getSelRow()).split('|');
			$('#txt_anjuran').val(a.cellsGetValue(a.getSelRow(),3));
			$('#txtId').val(sisip[0]);
			$('#inObat').load("form_input_obat_new.php?id="+sisip[0]);
			$('#act').val('edit');
			$('#jns').val(urldecode(sisip[2]));
			jQuery("#pJawabPem").val(urldecode(sisip[3]));
			
			jQuery("#DWaktuMasuk").val(urldecode(sisip[4]));
			jQuery("#txt_riwayat_pen").val(urldecode(sisip[5]));
			jQuery("#txt_pemeriksaan_fisik").val(urldecode(sisip[6]));
			
			jQuery("#txt_pemeriksaan").val(urldecode(sisip[7]));
			jQuery("#txt_terapi").val(urldecode(sisip[8]));
			jQuery("#txt_hasil_konsul").val(urldecode(sisip[9]));
			
			jQuery("#txt_alergi").val(urldecode(sisip[10]));
			jQuery("#txt_hasil_lab").val(urldecode(sisip[11]));
			jQuery("#txt_diet").val(urldecode(sisip[12]));
			
			if(urldecode(sisip[13])==1)
			{
				document.getElementById("pol1").checked = true;
			}else if(urldecode(sisip[13])==2){
				document.getElementById("RSL").checked = true;
			}else if(urldecode(sisip[13])==3){
				document.getElementById("puskesmas").checked = true;
			}else if(urldecode(sisip[13])==4){
				document.getElementById("drluar").checked = true;
			}else{
				document.getElementById("lll1").checked = true;
				document.getElementById("lain").disabled = false;
				document.getElementById("lain").value = urldecode(sisip[13]);
			}
			
			jQuery("#tglPoli").val(urldecode(sisip[14]));
			
			//var p="jns*-*"+sisip[2]+"";
			//fSetValue(window,p);
        }

        function hapus(){
            var rowid = document.getElementById("txtId").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(rowid==''){
					alert("Pilih data terlebih dahulu");
				}else if(confirm("Anda yakin menghapus data ini ?")){
					$('#act').val('hapus');
					$("#form1").ajaxSubmit({
					  success:function(msg)
					  {
						alert(msg);
						resetF();
						goFilterAndSort();
					  },
					});
				}

        }
		
		function edit(){
            var rowid = document.getElementById("txtId").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(rowid==''){
					alert("Pilih data terlebih dahulu");
				}else{
					$('#act').val('edit');
					$('#form_in').slideDown(1000,function(){
		toggle();
		});
				}

        }

        function batal(){
			resetF();
			$('#form_in').slideUp(1000,function(){
		toggle();
		});
        }
		
		function resetF(){
			$('#act').val('tambah');
			$('#txtId').val('');
			$('#txt_anjuran').val('');
			$('#pJawabPem').val('');
			$('#DWaktuMasuk').val('');
			$('#txt_riwayat_pen').val('');
			$('#txt_pemeriksaan_fisik').val('');
			$('#txt_pemeriksaan').val('');
			$('#txt_terapi').val('');
			$('#txt_hasil_konsul').val('');
			$('#txt_alergi').val('');
			$('#txt_hasil_lab').val('');
			$('#txt_diet').val('');
			$('#tglPoli').val('');
			jQuery(".ck12").removeAttr('checked');
            $('#inObat').load("form_input_obat_new.php");
			//centang(1,'L')
			}


        function konfirmasi(key,val){
            //alert(val);
            /*var tangkap=val.split("*|*");
            var proses=tangkap[0];
            var alasan=tangkap[1];
            if(key=='Error'){
                if(proses=='hapus'){				
                    alert('Tidak bisa menambah data karena '+alasan+'!');
                }              

            }
            else{
                if(proses=='tambah'){
                    alert('Tambah Berhasil');
                }
                else if(proses=='simpan'){
                    alert('Simpan Berhasil');
                }
                else if(proses=='hapus'){
                    alert('Hapus Berhasil');
                }
            }*/

        }

        function goFilterAndSort(grd){
            //alert("tmpt_layanan_utils.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
            a.loadURL("resum_medis_new_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>&idUsr=<?=$idUsr?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Resum Medis");
        a.setColHeader("NO,NO RM,Anjuran,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",no_rm,,,");
        a.setColWidth("50,100,300,80,100");
        a.setCellAlign("center,center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("resum_medis_new_util.php?idPel=<?=$idPel?>&idUsr=<?=$idUsr?>");
        a.Init();
		
		function tambah(){
			resetF();
			$('#form_in').slideDown(1000,function(){
		toggle();
		});
			
			}
		
		function cetak(){
		 var rowid = document.getElementById("txtId").value;
		 if(rowid==""){
				var rowidx =a.getRowId(a.getSelRow()).split('|');
				rowid=rowidx[0];
			 }
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			//if(rowid==''){
//					alert("Pilih data terlebih dahulu");
//				}else{	
		window.open("resume_medis_new.php?report="+document.getElementById("report").value+"&id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
				//}
		}
		
function centang(tes,tes2){
		 var checkbox = document.form1.elements['rad_thd'];
		 var checkboxlp = document.form1.elements['rad_lp'];
		 
		 if ( checkbox.length > 0 )
		{
		 for (i = 0; i < checkbox.length; i++)
			{
			  if (checkbox[i].value==tes)
			  {
			   checkbox[i].checked = true;
			  }
		  }
		}
		if ( checkboxlp.length > 0 )
		{
		 for (i = 0; i < checkboxlp.length; i++)
			{
			  if (checkboxlp[i].value==tes2)
			  {
			   checkboxlp[i].checked = true;
			  }
		  }
		}
	}
	
	
 function cekKl(a)
 {
	 if(a=="lll1")
	 {
		 document.getElementById("lain").value = "";
		 document.getElementById("lain").disabled = false;
	 }else{
		 document.getElementById("lain").value = "";
		 document.getElementById("lain").disabled = true;
	 }
	 jQuery(".ck12").removeAttr('checked');
	 document.getElementById(a).checked = true;
 }
	
 function addRowToTable()
        {
            //use browser sniffing to determine if IE or Opera (ugly, but required)
            var isIE = false;
            if(navigator.userAgent.indexOf('MSIE')>0){
                isIE = true;
            }
            //	alert(navigator.userAgent);
            //	alert(isIE);
            var tbl = document.getElementById('tblObat');
            var lastRow = tbl.rows.length;
            // if there's no header row in the table, then iteration = lastRow + 1
            var iteration = lastRow;
            var row = tbl.insertRow(lastRow);
            //row.id = 'row'+(iteration-1);
            row.className = 'itemtableA';
            //row.setAttribute('class', 'itemtable');
            row.onmouseover = function(){this.className='itemtableAMOver';};
            row.onmouseout = function(){this.className='itemtableA';};
            //row.setAttribute('onMouseOver', "this.className='itemtableMOver'");
            //row.setAttribute('onMouseOut', "this.className='itemtable'");

           /* // left cell
            var cellLeft = row.insertCell(0);
            var textNode = document.createTextNode(iteration-2);
            cellLeft.className = 'tdisikiri';
            cellLeft.appendChild(textNode);

            // right cell
            cellLeft = row.insertCell(1);
            textNode = document.createTextNode('-');
            cellLeft.className = 'tdisi';
            cellLeft.appendChild(textNode);*/

            // right cell
            var cellRight = row.insertCell(0);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_obat[]';
                el.id = 'txt_obat[]';
            }else{
                el = document.createElement('<input name="txt_obat[]"/>');
            }
            el.type = 'text';
            el.className = 'inputan';
            el.value = '';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

            if("<?php echo $edit;?>" == true){
                //generate id
                if(!isIE){
                    el = document.createElement('input');
                    el.name = 'id';
                    el.id = 'id';
                }else{
                    el = document.createElement('<input name="id" id="id" />');
                }
                el.type = 'text';
                cellRight.className = 'tdisi';
                cellRight.appendChild(el);
            }

 // right cell
            var cellRight = row.insertCell(1);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_jumlah[]';
                el.id = 'txt_jumlah[]';
            }else{
                el = document.createElement('<input name="txt_jumlah[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;
            

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(2);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_dosis[]';
                el.id = 'txt_dosis[]';
            }else{
                el = document.createElement('<input name="txt_dosis[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(3);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_frek[]';
                el.id = 'txt_frek[]';
            }else{
                el = document.createElement('<input name="txt_frek[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;
            

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(4);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_beri[]';
                el.id = 'txt_beri[]';
            }else{
                el = document.createElement('<input name="txt_beri[]"/>');
            }
            el.type = 'text';
            el.value = '';
            el.className = 'inputan';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(5);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_jam1[]';
                el.id = 'txt_jam1[]';
            }else{
                el = document.createElement('<input name="txt_jam1[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(6);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_jam2[]';
                el.id = 'txt_jam2[]';
            }else{
                el = document.createElement('<input name="txt_jam2[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(7);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_jam3[]';
                el.id = 'txt_jam3[]';
            }else{
                el = document.createElement('<input name="txt_jam3[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(8);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_jam4[]';
                el.id = 'txt_jam4[]';
            }else{
                el = document.createElement('<input name="txt_jam4[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(9);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_jam5[]';
                el.id = 'txt_jam5[]';
            }else{
                el = document.createElement('<input name="txt_jam5[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
// right cell
            var cellRight = row.insertCell(10);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_jam6[]';
                el.id = 'txt_jam6[]';
            }else{
                el = document.createElement('<input name="txt_jam6[]"/>');
            }
            el.type = 'text';
            el.value = '';
			el.size = 5;

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);

// right cell
            var cellRight = row.insertCell(11);
            var el;
            var tree;
            //generate obatid
            if(!isIE){
                el = document.createElement('input');
                el.name = 'txt_petunjuk[]';
                el.id = 'txt_petunjuk[]';
            }else{
                el = document.createElement('<input name="txt_petunjuk[]"/>');
            }
            el.type = 'text';
            el.value = '';
            el.className = 'inputan';

            cellRight.className = 'tdisi';
            cellRight.appendChild(el);
			
 // right cell
                cellRight = row.insertCell(12);
                if(!isIE){
                    el = document.createElement('img');
                    el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);setDisable("del")}');
                }else{
                    el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}"/>');
                }
                el.src = '../../icon/del.gif';
                el.border = "0";
                el.width = "16";
                el.height = "16";
                el.className = 'proses';
                el.align = "absmiddle";
                el.title = "Klik Untuk Menghapus";

                //  cellRight.setAttribute('class', 'tdisi');
                cellRight.className = 'tdisi';
                cellRight.appendChild(el);

                //document.forms[0].txt_obat[iteration-3].focus();

                /*  // select cell
  var cellRightSel = row.insertCell(2);
  var sel = document.createElement('select');
  sel.name = 'satuan';
  sel.className = "txtinput";
  //sel.id = 'selRow'+iteration;
<?php
//echo $sel;
?>
//  sel.options[0] = new Option('text zero', 'value0');
//  sel.options[1] = new Option('text one', 'value1');
  cellRightSel.appendChild(sel);
                 */
        //document.getElementById('btnSimpan').disabled = true;
    }
function removeRowFromTable(cRow)
	{
        var tbl = document.getElementById('tblObat');
        var jmlRow = tbl.rows.length;
        if (jmlRow > 4)
		{
            var i=cRow.parentNode.parentNode.rowIndex;
            //if (i>2){
            tbl.deleteRow(i);
            var lastRow = tbl.rows.length;
            for (var i=3;i<lastRow;i++)
			{
                var tds = tbl.rows[i].getElementsByTagName('td');
                //tds[0].innerHTML=i-2;
            }
        }
    }
    </script>
    
</html>
