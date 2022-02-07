<?php
//session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUser'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,
k.cara_keluar, a.bb as bb2, a.tb as tb2, IFNULL(pg.nama,'-') AS dr_rujuk,a.TENSI as tekanan_darah, a.suhu as suhu2, bk.no_reg,
CONCAT((CONCAT((CONCAT((CONCAT(p.alamat,' RT.',p.rt)),' RW.',p.rw)),', Desa ',w.nama)),', Kecamatan ',wi.nama) alamat_
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_pasien_keluar k ON k.pelayanan_id=pl.id
LEFT JOIN anamnese a ON a.KUNJ_ID=pl.kunjungan_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
INNER JOIN b_kunjungan bk ON pl.kunjungan_id = bk.id 
LEFT JOIN b_ms_wilayah w
		ON p.desa_id = w.id
	LEFT JOIN b_ms_wilayah wi
		ON p.kec_id = wi.id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$sqlKm="SELECT tk.tgl_in,tk.tgl_out FROM b_tindakan_kamar tk 
LEFT JOIN b_pelayanan p ON p.id=tk.pelayanan_id
WHERE tk.pelayanan_id='$idPel';";
$dK=mysql_fetch_array(mysql_query($sqlKm));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));
?>
<?php

$dG=mysql_fetch_array(mysql_query("select * from b_laporan_faal_paru where id='$_REQUEST[id]'"));
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
<title>Permohonan Konsultasi</title>
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
<div align="left" id="form_in" style="display:block;">
<form name="form1" id="form1" action="2.permohonankonsultasi_act.php">
                <input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUsr" value="<?=$idUsr?>" />
    			<input type="hidden" name="id" id="id"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
<table width="766" border="0" style="font:12px tahoma;">
  <tr>
    <td width="760"><table width="496" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
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
        <td>:&nbsp;<?=$dP['no_reg'];?></td>
      </tr>
      <tr>
        <td>Ruang Rawat/Kelas</td>
        <td>:
          <?=$dP['nm_unit'];?>/
          <?=$dP['nm_kls'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td colspan="2">:
          <?=$dP['alamat_'];?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" align="center">(Tempelkan Sticker Identitas Pasien)</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td style="font:bold 15px tahoma;">LAPORAN MEDICAL CHECK UP</td>
  </tr>
  <tr>
    <td style="font:bold 15px tahoma;">PEMERIKSAAN FAAL PARU</td>
  </tr>
  <tr>
    <td><table cellspacing="0" cellpadding="2" style="border:1px solid #000000;">
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
        <td height="20" width="27">&nbsp;</td>
        <td width="64"></td>
        <td width="20"></td>
        <td width="138"></td>
        <td width="20"></td>
        <td width="64"></td>
        <td width="51"></td>
        <td width="99"></td>
        <td width="13"></td>
        <td width="92"></td>
        <td width="49"></td>
        <td width="58"></td>
        <td width="54"></td>
        <td width="37"></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="2">Berat Badan</td>
        <td>&nbsp;</td>
        <td>:</td>
        <td colspan="2"><label for="textfield"></label>
          <?=$dP['bb2'];?><label for="dokter"></label>          Kg</td>
        <td colspan="3">Tinggi Badan</td>
        <td colspan="3">:
          <?=$dP['tb2'];?>          Cm</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="2">Suhu Tubuh</td>
        <td></td>
        <td>:</td>
        <td colspan="2"><label for="textfield3">
          <?=$dP['suhu2'];?>
          </label>          Cm</td>
        <td colspan="3">Tekanan Darah</td>
        <td colspan="3">:
          <?=$dP['tekanan_darah'];?>          <label for="textfield4"></label>          mmHg</td>
        <td></td>
      </tr>
      <tr height="">
        <td>&nbsp;</td>
        <td colspan="2"></td>
        <td></td>
        <td></td>
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
        <td>&nbsp;</td>
        <td colspan="9"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td>&nbsp;</td>
        <td colspan="3" valign="top">Keterangan Klinik</td>
        <td valign="top">:</td>
        <td colspan="8" ><?=$dG['keterangan'];?></td>
        <td></td>
      </tr>
      <tr height="20">
        <td>&nbsp;</td>
        <td colspan="3"></td>
        <td></td>
        <td colspan="8" ><label for="keluhan"></label></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="12"><table width="678" border="1" align="center" style="border-collapse:collapse">
          <tr>
            <td width="363" align="center"><strong>HASIL PEMERIKSAAN</strong></td>
            <td width="105" align="center"><strong>MEANS</strong></td>
            <td width="78" align="center"><strong>PR</strong></td>
            <td width="104" align="center"><strong>% PR</strong></td>
          </tr>
          <tr>
            <td>FCV</td>
            <td align="center"><?=$dG['means1'];?></td>
            <td align="center"><?=$dG['pr1'];?></td>
            <td align="center"><?=$dG['p1'];?></td>
          </tr>
          <tr>
            <td>FEV 1</td>
            <td align="center"><?=$dG['means2'];?></td>
            <td align="center"><?=$dG['pr2'];?></td>
            <td align="center"><?=$dG['p2'];?></td>
          </tr>
          <tr>
            <td>FCV1 / FVC %</td>
            <td align="center"><?=$dG['means3'];?></td>
            <td align="center"><?=$dG['pr3'];?></td>
            <td align="center"><?=$dG['p3'];?></td>
          </tr>
          <tr>
            <td>PEF 25 - 75</td>
            <td align="center"><?=$dG['means4'];?></td>
            <td align="center"><?=$dG['pr4'];?></td>
            <td align="center"><?=$dG['p4'];?></td>
          </tr>
          <tr>
            <td>PEF</td>
            <td align="center"><?=$dG['means5'];?></td>
            <td align="center"><?=$dG['pr5'];?></td>
            <td align="center"><?=$dG['p5'];?></td>
          </tr>
          <tr>
            <td>FEF 25 %</td>
            <td align="center"><?=$dG['means6'];?></td>
            <td align="center"><?=$dG['pr6'];?></td>
            <td align="center"><?=$dG['p6'];?></td>
          </tr>
          <tr>
            <td>FEF 50 %</td>
            <td align="center"><?=$dG['means7'];?></td>
            <td align="center"><?=$dG['pr7'];?></td>
            <td align="center"><?=$dG['p7'];?></td>
          </tr>
          <tr>
            <td>FEF 75 %</td>
            <td align="center"><?=$dG['means8'];?></td>
            <td align="center"><?=$dG['pr8'];?></td>
            <td align="center"><?=$dG['p8'];?></td>
          </tr>
        </table></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3"></td>
        <td></td>
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
        <td>NORMAL</td>
        <td></td>
        <td>OBSRUKSI</td>
        <td>&nbsp;</td>
        <td colspan="2">RESTRIKSI</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3" valign="top">Kesan</td>
        <td valign="top">:</td>
        <td colspan="4" valign="top" ><?=$dG['kesan'];?></td>
        <td ><p>
          <input disabled="disabled" type="radio" name="checkbox3" value="1" <? if ($dG['obstruksi']=='1') { echo "checked='checked'";}?> />
          <label for="radio"></label>
          Ringan</p>
          <p>
            <input disabled="disabled" type="radio" name="checkbox3" value="2" <? if ($dG['obstruksi']=='2') { echo "checked='checked'";}?>
            <label for="radio2"></label>
            Sedang </p>
          <p>
              <input disabled="disabled" type="radio" name="checkbox3" value="3" <? if ($dG['obstruksi']=='3') { echo "checked='checked'";}?>
              <label for="radio3">Berat</label>
          </p></td>
        <td ><p>&nbsp;</p>
          <p>&nbsp;</p></td>
        <td colspan="2" ><p>
          <input disabled="disabled" type="radio" name="checkbox" value="1" <? if ($dG['restriksi']=='1') { echo "checked='checked'";}?>
          <label for="radio4"></label>
          Ringan</p>
          <p>
            <input disabled="disabled" type="radio" name="checkbox" value="2" <? if ($dG['restriksi']=='2') { echo "checked='checked'";}?>
            <label for="radio5"></label>
            Sedang </p>
          <p>
            <input disabled="disabled" type="radio" name="checkbox" value="3" <? if ($dG['restriksi']=='3') { echo "checked='checked'";}?>
            <label for="radio6">Berat</label>
          </p></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3"></td>
        <td></td>
        <td colspan="8" >&nbsp;</td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3" valign="top">Anjuran</td>
        <td valign="top">:</td>
        <td colspan="5" ><?=$dG['anjuran'];?></td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
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
        <td>Tanggal/<em>Date</em></td>
        <td>:</td>
        <td colspan="4" class="gb">&nbsp;<?=tgl_ina(date('Y-m-d'));?></td>
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
        <td>Jam/<em>Time</em></td>
        <td>:</td>
        <td colspan="4" class="gb">&nbsp;<?=date('h:i:s');?></td>
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
        <td colspan="6"><div align="center">Dokter yang memeriksa,</div></td>
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
        <td colspan="6"><div align="center">(<strong><?=$dP['dr_rujuk'];?></strong>)</div></td>
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
        <td colspan="6"><div align="center">Name and signature</div></td>
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
    
    <tr id="trTombol">
        <td class="noline" align="center" colspan="11">     
           <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" />
          <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/></td>
   </tr>
                
    </td>
  </tr>
  
</table>
</form>
</div>

</body>
</html>

<script>
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