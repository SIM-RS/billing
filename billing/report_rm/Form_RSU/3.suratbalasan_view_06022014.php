<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Surat Balasan</title>
</head>
<?
include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUser'];
/*$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.dokter_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));*/
include "setting.php";
$query="select b.* FROM
  lap_srt_balasan b where b.id='".$_REQUEST['id']."'";
	$is=mysql_fetch_array(mysql_query($query));
?>
<style>
.gb{
	border-bottom:1px solid #000000;
}
textarea{
font:12px tahoma;
width:100%;
height:100%;
}
input[type='text']{
font:12px tahoma;
}
</style>
<link rel="stylesheet" type="text/css" href="../CRUD_Form_RSUD/setting.css" />
<link type="text/css" rel="stylesheet" href="../../theme/mod.css">
<script src="../CRUD_Form_RSUD/js/jquery-1.8.3.js"></script>
<script src="../CRUD_Form_RSUD/js/jquery.form.js"></script>
<script language="JavaScript" src="../../theme/js/mod.js"></script>
<script language="JavaScript" src="../../theme/js/dsgrid.js"></script>
<script language="JavaScript" src="../../unit_pelayanan/iframe.js"></script>
<body id="body">

<form id="from_balasan" method="post" action="3.suratbalasan_act.php">
<div>
<table width="766" border="0" style="font:12px tahoma;">
  <tr>
    <td width="379" style="font:bold 15px tahoma;" valign="bottom">SURAT BALASAN<br/>REFERRAL REPLAY</td>
    <td width="379" style="font:bold 15px tahoma;"><table width="418" border="0" style="font:12px tahoma; border:1px solid #000;">
      <tr>
        <td width="158">Nama Pasien</td>
        <td width="13">:</td>
        <td width="231"><span class="gb"><?=$nama?></span>&nbsp;&nbsp;<span <?php if($sex=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($sex=='P'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>P</span></td>
        </tr>
      <tr>
        <td>Tanggal Lahir</td>
        <td>:</td>
        <td><span class="gb"><?=$lahir?></span> /Usia: <span class="gb"><?=$umur?></span> Th</td>
        </tr>
      <tr>
        <td>No. R.M.</td>
        <td>:</td>
        <td><span class="gb"><?=$noRM?></span>&nbsp;No.Registrasi: <?=$no_reg?></td>
        </tr>
      <tr>
        <td>Ruang Rawat / Kelas</td>
        <td>:</td>
        <td><span class="gb"><?=$kamar?>/
          <?=$kelas?></span></td>
        </tr>
      <tr>
        <td>Alamat</td>
        <td>:</td>
        <td><span class="gb"><?=$alamat?></span></td>
        </tr>
      </table></td>
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
        <td height="20" width="27">&nbsp;</td>
        <td width="64"></td>
        <td width="20"></td>
        <td width="138">
          <input type="hidden" name="id" id="id" size="5" />
          <input type="hidden" name="act" id="act" size="5" />
          <input type="hidden" name="kunjungan_id" id="kunjungan_id" size="5" value="<?php echo $_REQUEST['idKunj']; ?>" />
          <input type="hidden" name="pelayanan_id" id="pelayanan_id" size="5" value="<?php echo $_REQUEST['idPel']; ?>" />
          <input type="hidden" name="idUsr" id="idUsr" size="5" value="<?php echo $_REQUEST['idUsr']; ?>" /></td>
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
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>Kepada&nbsp;</td>
        <td></td>
        <td></td>
        <td>:</td>
        <td colspan="5" class="gb"><?=$dr_rujuk?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>To</td>
        <td></td>
        <td></td>
        <td></td>
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
        <td>Dari</td>
        <td></td>
        <td></td>
        <td>:</td>
        <td colspan="5" class="gb"><?=$dokter?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>From</td>
        <td></td>
        <td></td>
        <td></td>
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
        <td colspan="7">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="7">Dengan hormat, </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="9">Sesuai  permohonan konsultasi, pada kasus ini dijumpai</td>
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
        <td colspan="3">Pemeriksaan</td>
        <td>:</td>
        <td colspan="8" rowspan="3" valign="top"><u><?=$is['pemeriksaan']?></u></td>
        <td></td>
        </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3">Examination</td>
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
        <td colspan="3" rowspan="2">Diagnosa<br/>Diagnosis</td>
        <td rowspan="2" valign="top">:</td>
        <td colspan="8" rowspan="2" style="margin:0; padding:0;" valign="top" ><table width="100%" border="0">
          <?php $sqlD="SELECT md.nama FROM b_diagnosa d
LEFT JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
LEFT JOIN b_kunjungan k ON k.id=d.kunjungan_id
WHERE k.id ='$idKunj';";
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
        <td></td>
        </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
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
        <td colspan="3">Saran Terapi</td>
        <td>:</td>
        <td colspan="8" rowspan="3" valign="top"><u><?=$is['terapi']?></u></td>
        <td></td>
        </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3">Adviced Therapy</td>
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
        <td colspan="3" rowspan="2">Tindakan khusus<br/>Special Procedure</td>
        <td rowspan="2" valign="top">:</td>
        <td colspan="8" rowspan="2" style="margin:0; padding:0;" valign="top">
          <table width="100%" border="0">
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
        <td></td>
        </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
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
        <td colspan="3">Terimakasih kerjasamanya</td>
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
        </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="3">Thank you for your    cooperation</td>
        <td></td>
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
        <td>Tanggal/Date</td>
        <td>:</td>
        <td colspan="4" class="gb"><?php echo tgl_ina(date("Y-m-d"))?></td>
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
        <td>Jam/Time</td>
        <td>:</td>
        <td colspan="4" class="gb"><?=date('h:i:s');?></td>
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
        <td colspan="6"><div align="center">Dokter yang merawat,</div></td>
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
        <td colspan="6"><div align="center">Attending Doctor,</div></td>
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
        <td colspan="6"><div align="center">(<b><u><?=$dokter?></u></b>)</div></td>
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
      </table></td>
  </tr>
  <tr>
  <td colspan="2" align="center">
  <div align="center"><tr id="trTombol">
        <td class="noline" colspan="5" align="right"><input id="btnPrint" type="button" value="Print" onClick="cetak(document.getElementById('trTombol'));"/>
                <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/></td>
      </tr></div>
  </tr>
</table></div>
</form>

</body>
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
<?php 
mysql_close($konek);
?>
</html>
