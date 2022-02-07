<?php 
include "../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUser'];
$idx=$_REQUEST['id'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,kk.no_reg as no_reg2,
IF(
    p.alamat <> '',
    CONCAT(
      p.alamat,
      ' RT. ',
      p.rt,
      ' RW. ',
      p.rw,
      ' Desa ',
      bw.nama,
      ' Kecamatan ',
      wi.nama, ' ', wil.nama
    ),
    '-'
  ) AS almt_lengkap 
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_kunjungan kk ON kk.id=pl.kunjungan_id
LEFT JOIN b_ms_wilayah bw ON p.desa_id = bw.id 
LEFT JOIN b_ms_wilayah wi ON p.kec_id = wi.id 
LEFT JOIN b_ms_wilayah wil ON wil.id = p.kab_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$dt=mysql_fetch_array(mysql_query("SELECT 
  lo.*,bmp.nama AS dokter
FROM
  b_ms_lap_operasi lo 
  LEFT JOIN b_ms_pegawai bmp 
    ON bmp.id = lo.dokter AND bmp.spesialisasi_id<>0 AND bmp.spesialisasi LIKE '%anestesi%' where lo.id='$idx'"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LAPORAN OPERASI</title>
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
        <td width="72" align="left" valign="top"><!--img src="lap_med_chckup_stat_bdh_wnta_clip_image003.png" alt="" width="350" height="105" /-->
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
            <td><span class="gb"><?=$dP['no_rm']?></span>&nbsp;No.Registrasi: 
              <?=$dP['no_reg2'];?></td>
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
		  <tr>
            <td colspan="3" align="center"><p><strong>(Tempelkan Stiker Identitas Pasien)</strong></p></td>
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
    </table></td>
  </tr>
  <tr>
    <td>
    <table width="803" border="0" cellpadding="3" cellspacing="0">
	<tr>
        <td colspan="3" style="border-bottom:1px solid #000;"></td>
      </tr>
            <tr>
              <td width="276" style="border-bottom:1px solid #000;">Tanggal Operasi : 
                <?=tgl_ina($dt['tgl_operasi']);?></td>
              <td width="252" style="border-bottom:1px solid #000;">Dimulai Jam : 
                <?=$dt['jam_mulai'];?></td>
              <td width="261" style="border-bottom:1px solid #000;">Selesai Jam : 
                <?=$dt['jam_selesai'];?></td>
            </tr>
            <tr>
              <td colspan="3"  style="border-bottom:1px solid #000;">Kamar Operasi : 
                <input disabled="disabled" type="radio" name="chkOpr" id="chkOpr1" <?php if($dt['kamar']==1){echo "checked='checked'";}?> />&nbsp;OK1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input disabled="disabled" type="radio" name="chkOpr" id="chkOpr2" <?php if($dt['kamar']==2){echo "checked='checked'";}?> />&nbsp;OK2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input disabled="disabled" type="radio" name="chkOpr" id="chkOpr3" <?php if($dt['kamar']==3){echo "checked='checked'";}?> />&nbsp;OK3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input disabled="disabled" type="radio" name="chkOpr" id="chkOpr4" <?php if($dt['kamar']==4){echo "checked='checked'";}?> />&nbsp;OK4&nbsp;&nbsp;&nbsp;</td>
              </tr>
			<tr>
              <td align="center">Dr. Operator</td>
			  <td align="center">Asisten Operator</td>
			  <td align="center">Perawat</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
			  <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
			  <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="center">(_____________________________)</td>
              <td align="center">(_____________________________)</td>
			  <td align="center">(_____________________________)</td>
            </tr>
			<tr>
        <td colspan="3" style="border-bottom:1px solid #000;"></td>
      </tr>
            <tr>
              <td  style="border-bottom:1px solid #000;">Diagnosa Pra Bedah</td>
              <td colspan="2"  style="border-bottom:1px solid #000;">: 
                <?=$dt['diagnosa_pra'];?></td>
              </tr>
            <tr>
              <td>Golongan Operasi</td>
              <td colspan="2">&nbsp;</td>
              </tr>
            <tr>
              <td colspan="3">
              <input disabled="disabled" type="radio" name="chkGolOpr" id="chkGolOpr1" <?php if($dt['gol_opr']==1){echo "checked='checked'";}?> />&nbsp;&nbsp;&nbsp;Khusus&nbsp;&nbsp;&nbsp;
              <input disabled="disabled" type="radio" name="chkGolOpr" id="chkGolOpr2" <?php if($dt['gol_opr']==2){echo "checked='checked'";}?> />&nbsp;&nbsp;&nbsp;Besar&nbsp;&nbsp;&nbsp;
              <input disabled="disabled" type="radio" name="chkGolOpr" id="chkGolOpr3" <?php if($dt['gol_opr']==3){echo "checked='checked'";}?> />&nbsp;&nbsp;&nbsp;Sedang&nbsp;&nbsp;&nbsp;
              <input disabled="disabled" type="radio" name="chkGolOpr" id="chkGolOpr4" <?php if($dt['gol_opr']==4){echo "checked='checked'";}?> />&nbsp;&nbsp;&nbsp;kecil&nbsp;&nbsp;&nbsp;</td>
              </tr>
            <tr>
              <td>Jenis Operasi</td>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3" >
              <input disabled="disabled" type="radio" name="chkJnsOpr" id="chkJnsOpr1" <?php if($dt['jns_operasi']==1){echo "checked='checked'";}?> />&nbsp;&nbsp;&nbsp;Elektif&nbsp;&nbsp;&nbsp;
              <input disabled="disabled" type="radio" name="chkJnsOpr" id="chkJnsOpr2" <?php if($dt['jns_operasi']==2){echo "checked='checked'";}?> />&nbsp;&nbsp;&nbsp;Cito&nbsp;&nbsp;&nbsp;</td>
              </tr>
            <tr>
              <td>Dokter Anastesi</td>
              <td colspan="2">: 
                <?=$dt['dokter']?></td>
            </tr>
            <tr>
              <td>Anastesi:</td>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3">
              <input disabled="disabled" type="radio" name="chkAnas" id="chkAnas1" <?php if($dt['anestesi']==1){echo "checked='checked'";}?> />&nbsp;&nbsp;&nbsp;Umum&nbsp;&nbsp;&nbsp;
              <input disabled="disabled" type="radio" name="chkAnas" id="chkAnas2" <?php if($dt['anestesi']==2){echo "checked='checked'";}?> />&nbsp;&nbsp;&nbsp;Spinal&nbsp;&nbsp;&nbsp;
              <input disabled="disabled" type="radio" name="chkAnas" id="chkAnas3" <?php if($dt['anestesi']==3){echo "checked='checked'";}?> />&nbsp;&nbsp;&nbsp;Lokal&nbsp;&nbsp;&nbsp;
              <input disabled="disabled" type="radio" name="chkAnas" id="chkAnas4" <?php if($dt['anestesi']==4){echo "checked='checked'";}?> />&nbsp;&nbsp;&nbsp;Lain-Lain
          &nbsp;&nbsp;&nbsp;&nbsp;           <?=$dt['anastesi_lain']?>       </td>
              </tr>
            <tr>
              <td>Diagnosa Pasca Bedah</td>
              <td colspan="2">: 
                <label for="txtPasca"></label>
                <?=$dt['diagnosa_pasca']?></td>
            </tr>
			<?php $tindakan=explode('|',$dt['tindakan']);?>
            <tr>
              <td valign="top" >Tindakan Bedah</td>
              <td colspan="2" align="left">&nbsp;<div style="width:20px; float:left"> I.</div>&nbsp;<?=$tindakan[0];?>
                </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="2">&nbsp;<div style="width:20px; float:left"> II.</div>&nbsp;<?=$tindakan[1];?>
                &nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td colspan="2">&nbsp;<div style="width:20px; float:left"> III.</div>&nbsp;<?=$tindakan[2];?>
                &nbsp;</td>
            </tr>
            <tr>
              <td style="border-bottom:1px solid #000;">&nbsp;</td>
              <td colspan="2" style="border-bottom:1px solid #000;">&nbsp;<div style="width:20px; float:left"> IV.</div>&nbsp;<?=$tindakan[3];?>
                &nbsp;</td>
            </tr>
            <tr>
              <td colspan="3"><strong>Uraian Pembedahan:</strong></td>
              </tr>
            <tr>
              <td colspan="3"  style="border-bottom:1px solid #000;">(Uraian mulai dari bagian tubuh yang dioperasi,cara,penemuan-penemuan,tindakan yang dilakukan,explorasi yang dilakukan, drain yang digunakan, indikasi dan tindakan macam dengan cara penjahitan dengan lengkap dan jelas).<br/>
                <label for="txtUraian"></label>
                <?=$dt['uraian']?></td>
            </tr>
            <tr>
              <td colspan="3">Jaringan yang dikirim ke Histopatologi</td>
            </tr>
            <tr>
              <td colspan="3"><input disabled="disabled" type="radio" name="chkJaringan" id="chkJaringan1" <?php if($dt['jaringan']==1){echo "checked='checked'";}?> />&nbsp;&nbsp;Ya&nbsp;&nbsp; 
                  <input disabled="disabled" type="radio" name="chkJaringan" id="chkJaringan2" <?php if($dt['jaringan']==0){echo "checked='checked'";}?> />&nbsp;&nbsp;Tidak&nbsp;&nbsp; 
                </td>
            </tr>
            <tr>
              <td colspan="2" valign="top">Macam Jaringan : 
                <label for="txtJaringan"></label>
                <?=$dt['macam_jaringan']?></td>
              <td>Tanggal: <?php echo tgl_ina(date("Y-m-d"))?><br/>Pukul: 
                <?=date('h:i:s');?>
              <br/>Dokter Ahli Bedah<br/></td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
              <td align="center">(_____________________________)</td>
            </tr>
            <tr>
              <td colspan="2">&nbsp;</td>
              <td align="center">Nama dan Tanda Tangan</td>
            </tr>
          </table></td>
  </tr>
  <tr>
  <td align="center"><div align="center"><tr id="trTombol">
        <td class="noline" colspan="5" align="right"><input id="btnPrint" type="button" value="Print" onClick="cetak(document.getElementById('trTombol'));"/>
                <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/></td>
      </tr></div>
  </td>
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