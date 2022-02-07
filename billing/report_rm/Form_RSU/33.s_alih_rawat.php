<?php
//session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUser'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,
k.cara_keluar, a.bb as bb2, a.tb as tb2, IFNULL(pg.nama,'-') AS dr_rujuk, IFNULL(pg2.nama,'-') as drnya, Ifnull(pg2.spesialisasi,'-') spec,l.nama AS nama2,l.alamat AS alamat2,l.ktp AS ktp2,h.nama_hubungan AS hubungan2,l.hubungan,l.tgl_lahir as tgl_lahir2,l.jenis_kelamin as jenis_kelamin2,l.umur as umur2,l.telp as telp2, (GROUP_CONCAT(md.nama)) as diag
FROM b_pelayanan pl
INNER JOIN b_kunjungan ku ON pl.kunjungan_id=ku.id
LEFT JOIN b_diagnosa di ON di.kunjungan_id=ku.id
LEFT JOIN b_ms_diagnosa md ON md.id=di.ms_diagnosa_id 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_pasien_keluar k ON k.pelayanan_id=pl.id
LEFT JOIN anamnese a ON a.KUNJ_ID=pl.kunjungan_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN b_ms_pegawai pg2 ON pg2.id=pl.dokter_id
LEFT JOIN lap_inform_konsen l ON l.pelayanan_id=pl.id
LEFT JOIN b_ms_hubungan h ON h.id=l.hubungan
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$sqlKm="SELECT tk.tgl_in,tk.tgl_out FROM b_tindakan_kamar tk 
LEFT JOIN b_pelayanan p ON p.id=tk.pelayanan_id
WHERE tk.pelayanan_id='$idPel';";
$dK=mysql_fetch_array(mysql_query($sqlKm));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUser'"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Surat Alih Rawat</title>
</head>
<?php
include "setting_alih.php";
$dd="select fr.*,bmpi.nama as drganti,bmpi.spesialisasi as drgantispec from b_fom_alih_rawat fr LEFT JOIN b_ms_pegawai bmpi ON bmpi.id=fr.id_dokter_pengganti where fr.id='$_REQUEST[id]'";
$assd=mysql_query($dd);
$dG=mysql_fetch_array($assd);
//echo $dd;
?>
<body>
<table width="766" border="0" align="center" style="font:12px tahoma;">
  <tr>
    <td width="760"><table width="473" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
      <tr>
        <td colspan="4" style="font:bold 15px tahoma;"><center><strong>SURAT PERMINTAAN</strong></center></td>
        </tr>
      <tr>
        <td colspan="4" style="font:bold 15px tahoma;"><center><strong>ALIH RAWAT</strong></center></td>
	  </tr>
    </table></td>
  </tr>
  <tr>
    <td style="font:bold 15px tahoma;">&nbsp;</td>
  </tr>
  <tr>
    <td><table align="center" cellpadding="2" cellspacing="0" style="border:1px solid #000000;">
      <col width="64" />
      <col width="20" />
      <col width="132" />
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
        <td height="20" colspan="13">Saya yang bertanda tangan dibawah ini : </td>
        </tr>
      <tr height="20">
        <td width="64" height="20">&nbsp;</td>
        <td colspan="2">Nama</td>
        <td width="20">:</td>
        <td colspan="8"><?=$dP['nama2']?>
            </input>
          / <span <?php if($dP['jenis_kelamin2']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>Laki-Laki</span> / <span <?php if($dP['jenis_kelamin2']=='P'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>Perempuan</span></td>
        <td width="37">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2">Umur</td>
        <td>:</td>
        <td colspan="8"><?=$dP['umur2']?>
            </input></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2">No. KTP</td>
        <td>:</td>
        <td colspan="8"><?=$dP['ktp2']?>
            </input></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2">Alamat</td>
        <td>:</td>
        <td colspan="8"><?=$dP[alamat2]?></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2">No. Telpon</td>
        <td>:</td>
        <td colspan="8"><?=$dP['telp2']?>
            </input></td>
        <td>&nbsp;</td>
      </tr>
      <!--tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2">Tanggal Skrining</td>
        <td>:</td>
        <td colspan="8" class="gb"><?=$dG['tgl2'];?></td>
        <td>&nbsp;</td>
      </tr-->
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td width="152"></td>
        <td></td>
        <td></td>
        <td width="64"></td>
        <td width="51"></td>
        <td width="99"></td>
        <td width="13"></td>
        <td width="92"></td>
        <td width="49"></td>
        <td width="58"></td>
        <td width="54"></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" colspan="13">Dalam hal ini bertindak atas nama atau mewakili :
          <?=$dP['hubungan2']?></td>
        </tr>
      <tr height="20">
        <td height="20" colspan="13">&nbsp;</td>
        </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2">Nama</td>
        <td>:</td>
        <td colspan="8"><?=$dP['nama']?></td>
        <td>&nbsp;</td>
      </tr>
	  <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2">No R.M</td>
        <td>:</td>
        <td colspan="8"><?=$dP['no_rm']?></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2">Umur</td>
        <td>:</td>
        <td colspan="8"><?=$dP['usia']?></td>
        <td>&nbsp;</td>
      </tr>
	  <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2">Kelas / Kamar</td>
        <td>:</td>
        <td colspan="8"><?=$dP['nm_unit'];?>
  &nbsp;/&nbsp;
  <?=$dP['nm_kls'];?></td>
        <td>&nbsp;</td>
      </tr>
	  <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2">Dokter yang Merawat </td>
        <td>:</td>
        <td colspan="8"><?=$dP['drnya']?></td>
        <td>&nbsp;</td>
      </tr>
	  <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2">Diagnosa klinis </td>
        <td>:</td>
        <td colspan="8"><?=$dP['diag']?></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="11"></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" colspan="12">Bermaksud mengajukan permintaan ALIH RAWAT DOKTER untuk pasien tersebut diatas selama perawatan </td>
        <td>&nbsp;</td>
      </tr>
	  <tr height="20">
        <td height="20" colspan="12">di RS PELINDO I, sebagai berikut :</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="11" class="gb">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td colspan="2">Dokter yang <strong>Merawat</strong> saat ini </td>
        <td colspan="4">:&nbsp;<?=$dr_rujuk?></td>
        <td colspan="6" class="gb"><?="Spesialis : ".$dr_rujuk_spec?></td>
        <td>&nbsp;</td>
      </tr>
	  <tr height="20">
        <td colspan="2">Dokter <strong>Pengganti</strong></td>
        <td colspan="4">:&nbsp;<?=$dG['drganti'];?></td>
        <td colspan="6" class="gb"><?="Spesialis : ".$dG['drgantispec']?></td>
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" colspan="12">Alasan mengganti dokter yang merawat adalah : </td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" colspan="12"><?=$dG['alasan'];?></td>
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" colspan="12">Apabila nanti terjadi sesuatu dikarenakan surat permintaan Alih Rawat Dokter yang merwat ini, maka</td>
        <td>&nbsp;</td>
      </tr>
	  <tr height="20">
        <td height="20" colspan="12">Saya membebaskan pihak RS PELINDO I dari segala tuntutan dan tanggung jawab</td>
        <td>&nbsp;</td>
      </tr>
	  <tr height="20">
        <td height="20" colspan="12">Demikian permintaan ini diajukan, untuk mendapat tanggapan dari pihak RS PELINDO I</td>
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3"> Medan, <?php echo tgl_ina(date("Y-m-d"))?></td>
		<td>&nbsp;</td>
        <td>&nbsp;</td>
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
        <td colspan="3">Pasien / Penanggung Jawab</td>
		<td>&nbsp;</td>
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20" colspan="3"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3"><center><strong>(<?=$dG['nm_w'];?>)</strong></center></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td colspan="3" height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3"><center>Nama dan Tanda Tangan</center></td>
        <td></td>
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
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
        <td>&nbsp;</td>
      </tr>
	  <tr>
    <td colspan="13" align="center"><div align="center"><tr id="trTombol">
        <td class="noline" colspan="5" align="right"><input id="btnPrint" type="button" value="Print" onClick="cetak(document.getElementById('trTombol'));"/>
                <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/></td>
      </tr></div></td>
  </tr>
    </table></td>
  </tr>
</table>
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
