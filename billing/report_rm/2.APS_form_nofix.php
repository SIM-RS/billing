<?php
session_start();
include("../sesi.php");
include("../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,
k.cara_keluar
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../jquery.js"></script>
        <script type="text/javascript" src="../jquery.form.js"></script>
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
                    src="../theme/dsgrid_sort.php" scrolling="no"
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
                <form name="form1" id="form1" action="resume_medis_act.php">
                <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="txtId" id="txtId"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
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
            <td><span class="gb"><?=$dP['no_rm']?></span>&nbsp;&nbsp;No.Registrasi:_____</td>
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
        <td align="center"><b>RESUME MEDIS <br/><em>SUMMARY LETTER</em></b></td>
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
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="7" valign="top">Diagnosa Akhir<br/><em>Final Diagnosis</em></td>
        <td></td>
        <td valign="top">:</td>
        <td colspan="26" style="margin:0; padding:0;"><table width="100%" border="0">
        <tr>
            <td width="78%" class="gb">&nbsp;</td>
            <td width="22%" align="center" class="gb" style="border-left:1px solid #000;">CODE</td>
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
            <td align="center" class="gb" style="border-left:1px solid #000;"><?=$dD['kode']?></td>
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
        <td colspan="26" valign="top"><textarea name="txt_anjuran" rows="5" class="textArea" id="txt_anjuran" ></textarea></td>
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
        <td align="center" valign="middle"><img alt="del" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);setDisable('del')}"></td>
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
        <td colspan="11">Tanggal/<em>Date</em> :</td>
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
        <td colspan="11">Jam/<em>Time</em> :</td>
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
                    <td width="45%">
                        <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="tambah(this.value);" class="tblTambah"/>
                      <input type="button" id="btnHapus" name="btnHapus" value="Edit" onclick="edit();" class="tblTambah"/>
                        <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus();" class="tblHapus"/>
                  </td>
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
				$("#form1").ajaxSubmit({
					  success:function(msg)
					  {
						alert(msg);
						batal();
						goFilterAndSort();
					  },
					});
			
            }
        }
        
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

        function ambilData(){		
            var sisip = a.getRowId(a.getSelRow()).split('|');
			$('#txt_anjuran').val(a.cellsGetValue(a.getSelRow(),3));
			$('#txtId').val(sisip[0]);
			$('#inObat').load("form_input_obat.php?id="+sisip[0]);
			$('#act').val('edit');
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
            a.loadURL("resum_medis_util.php?filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&idPel=<?=$idPel?>","","GET");
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("Data Resum Medis");
        a.setColHeader("NO,NO RM,Anjuran,TGL INPUT,PENGGUNA");
        a.setIDColHeader(",no_rm,,,");
        a.setColWidth("50,100,300,80,100");
        a.setCellAlign("center,center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        //a.onLoaded(konfirmasi);
        a.baseURL("resum_medis_util.php?idPel=<?=$idPel?>");
        a.Init();
		
		function tambah(){
			resetF();
			$('#form_in').slideDown(1000,function(){
		toggle();
		});
			
			}
		
		function cetak(){
		 var rowid = document.getElementById("txtId").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
			if(rowid==''){
					alert("Pilih data terlebih dahulu");
				}else{	
		window.open("resume_medis.php?id="+rowid+"&idPel=<?=$idPel?>&idKunj=<?=$idKunj?>&idPasien=<?=$idPsn?>&idUser=<?=$idUsr?>","_blank");
				}
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
    </script>
    
</html>
