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
CONCAT((CONCAT((CONCAT((CONCAT(p.alamat,' RT.',p.rt)),' RW.',p.rw)),', Desa ',w.nama)),', Kecamatan ',wi.nama) alamat_
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
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$sqlKm="SELECT tk.tgl_in,tk.tgl_out FROM b_tindakan_kamar tk 
LEFT JOIN b_pelayanan p ON p.id=tk.pelayanan_id
WHERE tk.pelayanan_id='$idPel';";
$dK=mysql_fetch_array(mysql_query($sqlKm));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));
$takadaygabadi="select * from b_fom_resum_medis where id='$idx'";
$dRM=mysql_fetch_array(mysql_query($takadaygabadi));
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
    <td width="799"><table cellspacing="0" cellpadding="0">
      <col width="72" />
      <col width="46" />
      <col width="126" />
      <col width="17" />
      <col width="64" span="5" />
      <col width="79" />
      <tr>
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
        </tr>
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
        <td align="center"><b>RESUME MEDIS <?php if($dRM['jns']==1){echo "RAWAT INAP";}else{echo "RAWAT JALAN";}?><br/><em>SUMMARY LETTER <?php if($dRM['jns']==1){echo "INPATIENT";}else{echo "OUTPATIENT";}?></em></b></td>
        <td colspan="9" align="center">&nbsp;</td>
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
    <table style="font:12px tahoma; border:1px solid #000;">
    <tr>
    <td width="853"><table cellspacing="0" cellpadding="0">
      <col width="21" span="36" />
      <tr>
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
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7" valign="top">Diagnosa Akhir<br/><em>Final Diagnosis</em></td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26" style="margin:0; padding:0;"><table width="100%" border="0">
        <tr>
            <td width="78%" class="gb">&nbsp;</td>
            <?php
                    if($_REQUEST['report']==1){
					?>
            <td width="22%" align="center" class="gb" style="border-left:1px solid #000;">CODE</td>
            <?php }else{?>
            <td width="22%" >&nbsp;</td>
            <?php }?>
            </tr>
          <?php $sqlD="SELECT md.nama,md.dg_kode,md.kode FROM b_diagnosa d
LEFT JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
LEFT JOIN b_kunjungan k ON k.id=d.kunjungan_id
WHERE d.pelayanan_id='$idPel';";
$exD=mysql_query($sqlD);
while($dD=mysql_fetch_array($exD)){
?>
          <tr>
            <td class="gb"><?=$dD['nama']?></td>
            <?php
                    if($_REQUEST['report']==1){
					?>
            <td align="center" class="gb" style="border-left:1px solid #000;"><?=$dD['kode']?></td>
            <?php }else{?>
            <td >&nbsp;</td>
            <?php }?>
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
        <td colspan="7" valign="top">Tindakan Operatif<br/><em>Operative Procedure</em></td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26" style="margin:0; padding:0;"><table width="100%" border="0">
          <?php $sqlT="select * from
        (SELECT t.id, t.qty, t.biaya, t.qty * t.biaya as subtotal, t.kunjungan_id, t.ms_tindakan_kelas_id, t.pelayanan_id, t.ket, t.unit_act, tk.tarip, tin.nama
        , tin.kode,ifnull(p.nama,'-') as dokter,t.ms_tindakan_unit_id,t.user_id,k.nama as kelas, t.type_dokter,t.tgl_act as tanggal, tin.klasifikasi_id, peg.nama AS petugas
	FROM b_tindakan t
	INNER JOIN b_pelayanan pl ON pl.id = t.pelayanan_id
	INNER JOIN b_ms_tindakan_kelas tk ON tk.id = t.ms_tindakan_kelas_id
	INNER JOIN b_ms_kelas k ON tk.ms_kelas_id=k.id
	INNER JOIN b_ms_tindakan tin ON tin.id = tk.ms_tindakan_id
	LEFT JOIN b_ms_pegawai p ON p.id=t.user_id
	LEFT JOIN b_ms_pegawai peg ON peg.id=t.user_act
	WHERE t.pelayanan_id = '".$idPel."') as gab";
$exT=mysql_query($sqlT);
while($dT=mysql_fetch_array($exT)){
?>
          <tr>
            <td class="gb"><?=$dT['nama']?></td>
            </tr>
          <?php }?>  
          <tr>
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
        <td colspan="7" valign="top">Anjuran/Rencana/Kontrol Selanjutnya<br/><em>Follow-up</em></td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26" valign="top"><?=$dRM['anjuran']?></td>
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
		$sqlD=mysql_query("SELECT * FROM b_fom_resum_medis_detail WHERE resum_medis_id='$ini'");
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
        <td colspan="11">Tanggal/<em>Date</em> : <?=tgl_ina(date('Y-m-d'))?></td>
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
        <td colspan="11">Jam/<em>Time</em> : <?=date('H:i:s')?></td>
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
        <td colspan="11">Attending Doctor</td>
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
      </tr>
    </table></td>
  	</tr>
    </table>
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