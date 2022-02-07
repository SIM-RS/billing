<?php 
include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUser'];
$idx=$_REQUEST['id'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk,l.nama AS nama2,
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
  ) AS almt_lengkap ,
l.alamat AS alamat2,l.ktp AS ktp2,h.nama_hubungan AS hubungan2,l.hubungan,l.tgl_lahir as tgl_lahir2,l.jenis_kelamin as jenis_kelamin2,l.umur as umur2,l.telp as telp2,l.saksi as saksi2
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
LEFT JOIN lap_inform_konsen l ON l.pelayanan_id=pl.id
LEFT JOIN b_ms_hubungan h ON h.id=l.hubungan
LEFT JOIN b_ms_wilayah bw ON p.desa_id = bw.id 
LEFT JOIN b_ms_wilayah wi ON p.kec_id = wi.id 
LEFT JOIN b_ms_wilayah wil ON wil.id = p.kab_id

WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$dt=mysql_fetch_array(mysql_query("select * from b_fom_tolak_tind_medis where id='$idx'"));
$usr=mysql_fetch_array(mysql_query("select * from b_ms_pegawai where id='$idUsr'"));
$dG=mysql_fetch_array(mysql_query("select * from b_fom_tolak_tind_medis where id='$_REQUEST[id]'"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Penolakan Tindakan Medis</title>
<style>

.gb{
	border-bottom:1px solid #000000;
}
.inputan1 {width:200px;
}
.textArea1 {width:100%;}
</style>
</head>

<body>
<table width="200" align="center">
  <tr>
    <td><table cellspacing="0" cellpadding="0">
      <col width="11" />
      <col width="22" />
      <col width="182" />
      <col width="18" />
      <col width="64" span="4" />
      <col width="35" />
      <col width="132" />
      <col width="11" />
      <tr>
        <td width="11" align="left" valign="top"><img src="penolakan_tind_medis_clip_image003.png" alt="" width="700" height="75" />
          <table cellpadding="0" cellspacing="0">
            <tr>
              <td width="11"></td>
            </tr>
          </table></td>
        <td width="22"></td>
        <td width="182"></td>
        <td width="18"></td>
        <td width="64"></td>
        <td width="64"></td>
        <td width="64"></td>
        <td width="64"></td>
        <td width="35"></td>
        <td width="132"></td>
        <td width="11"></td>
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
        <td></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table cellspacing="0" cellpadding="2" style="font:12px tahoma; border:1px solid #000;">
      <col width="11" />
      <col width="22" />
      <col width="182" />
      <col width="18" />
      <col width="64" span="4" />
      <col width="35" />
      <col width="132" />
      <col width="11" />
      <tr>
        <td width="3">&nbsp;</td>
        <td width="13">&nbsp;</td>
        <td width="179">&nbsp;</td>
        <td width="9">&nbsp;</td>
        <td width="59">&nbsp;</td>
        <td width="59">&nbsp;</td>
        <td width="58">&nbsp;</td>
        <td width="50">&nbsp;</td>
        <td width="44">&nbsp;</td>
        <td width="150">&nbsp;</td>
        <td width="9">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="4">Saya yang bertanda tangan    di bawah ini :</td>
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
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">Nama</td>
        <td>:</td>
        <td colspan="6"><?=$dP['nama2']?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">Umur / Kelamin</td>
        <td>:</td>
        <td colspan="6"><?=$dP['umur2']?>
          Jenis Kelamin:
          <label for="jenis_kelamin2"></label>
        <span <?php if($dP['jenis_kelamin2']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>Laki-Laki</span> / <span <?php if($dP['jenis_kelamin2']=='P'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>Perempuan</span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2" valign="top">Alamat</td>
        <td valign="top">:</td>
        <td colspan="6"><?=$dP[alamat2]?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">Bukti diri / KTP</td>
        <td>:</td>
        <td colspan="4"><?=$dP['ktp2']?></td>
        <td>Telp.&nbsp;</td>
        <td><?=$dP['telp2']?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="6">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="6">Dengan ini menyatakan    dengan sesungguhnya telah menyatakan :</td>
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
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="9" align="center"><b>PENOLAKAN</b></td>
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
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="4">Untuk dilakukan Tindakan    Medis berupa** :</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="9"><label for="txt_tind"></label>
          <textarea name="alasan" cols="100" rows="5" disabled="disabled" id="alasan"><?=$dG['tindakan']?>
          </textarea></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="9">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="9" valign="middle">Terhadap
          <?=$dP['hubungan2']?>
          saya *),    dengan</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">Nama</td>
        <td>:</td>
        <td colspan="6" class="gb"><label for="txt_nama"></label>
            <?=$dP['nama']?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2" >Umur / Kelamin</td>
        <td>:</td>
        <td colspan="6" class="gb"><?=$dP['usia'];?>
          Thn, <span <?php if($dP['sex']=='L'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>L</span> / <span <?php if($dP['sex']=='P'){echo 'style="padding:0px 2px 0px 2px; border:1px #000 solid;"';}?>>P</span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2" valign="top">Alamat</td>
        <td valign="top">:</td>
        <td colspan="6" class="gb"><?=$dP['almt_lengkap'];?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="4">&nbsp;</td>
        <td>Telp.&nbsp;</td>
        <td class="gb"><?=$dP['telp'];?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">Bukti diri / KTP</td>
        <td>:</td>
        <td colspan="6" class="gb"><?=$dP['no_ktp'];?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">Di&nbsp; rawat di</td>
        <td>:</td>
        <td colspan="6" class="gb"><input name="txt_rawat" type="text" class="inputan1" id="txt_rawat" style="display:none" value="<?=$_POST['txt_rawat']?>"/>
            <?=$dP['nm_unit'];?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">No. Rekam Medis</td>
        <td>:</td>
        <td colspan="6" class="gb"><input name="txt_rekam" type="text" class="inputan1" id="txt_rekam" style="display:none" value="<?=$_POST['txt_rekam']?>"/>
            <?=$dP['no_rm'];?></td>
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
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="8">Saya juga telah    menyatakan dengan sesungguhnya dengan tanpa paksaan bahwa saya :</td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>a.</td>
        <td colspan="9" rowspan="2">Telah    diberikan informasi dan penjelasan serta peringatan akan bahaya, resiko serta    kemungkinan - kemungkinan yangtimbul apabila tidak    dilakukan tindakan medis berupa **</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
        <td colspan="8"><textarea name="textarea" cols="100" rows="5" disabled="disabled" id="textarea"><?=$dG['resiko']?>
          </textarea></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>b.</td>
        <td colspan="6">Telah saya pahami    sepenuhnya informasi dan penjelasan yang diberikan dokter.</td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>c.</td>
        <td colspan="9">Atas    tanggung jawab dan risiko saya sendiri tetap menolak untuk dilakukan tindakan    medis yang dianjurkan dokter.</td>
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
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td colspan="4"><div align="right">Medan, <span class="gb"> <?php echo tgl_ina(date("Y-m-d"))?> </span> &nbsp;Jam <span class="gb">
          <?=date('h:i:s');?>
        </span></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td colspan="4">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td>Saksi - saksi</td>
        <td></td>
        <td colspan="3"><div align="center">Dokter</div></td>
        <td colspan="3" align="center">Yang membuat pernyataan</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td>Tanda Tangan</td>
        <td></td>
        <td colspan="3"><div align="center">Tanda Tangan</div></td>
        <td colspan="3" align="center">&nbsp;Tanda Tangan</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>1.</td>
        <td class="gb">&nbsp;</td>
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
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><?php list($saksi1, $saksi22) = explode('*|*', $dP['saksi2']); ?></td>
        <td><div align="center">(
          <?=$saksi1?>
          )</div></td>
        <td></td>
        <td colspan="3"><div align="center">(
          <?=$dP['dr_rujuk'];?>
          )</div></td>
        <td colspan="3" align="center">(<span class="gb">
          <?=$dP['nama2']?>
        </span>)</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td><div align="center">nama jelas &amp; tanda tangan</div></td>
        <td></td>
        <td colspan="3"><div align="center">nama jelas &amp; tanda tangan</div></td>
        <td colspan="3" align="center">nama jelas &amp; tanda tangan</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>2.</td>
        <td class="gb">&nbsp;</td>
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
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td><div align="center">(
          <?=$saksi22?>
          )</div></td>
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
        <td>nama jelas &amp; tanda tangan</td>
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
        <td colspan="10"><p>&nbsp;</p>
          <p>&nbsp;&nbsp;*)    Coret yang tidak perlu&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; **) isi    dengan jenis tindakan medis yang akan dilakukan</p>
          <p>&nbsp;</p></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
   <tr>
  <td align="center">
  <div align="center"><tr id="trTombol">
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