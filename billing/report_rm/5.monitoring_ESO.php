<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>monitoring ESO</title>
<style type="text/css">
<!--
.style2 {font-size: 10px}
.kotak{ padding:1px; border:1px solid #333; width:16px; height:16px; text-align:center; vertical-align:middle; display:inline-table;}
-->
</style>
<?
include "setting.php";
$dG=mysql_fetch_array(mysql_query("select * from b_fom_monitoring_eso where id='$_REQUEST[id]'"));
$penyakit=explode(',',$dG['penyakit']);
?>
</head>

<body>
<table width="755" border="0" cellpadding="4" style="font:12px tahoma;">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"><table width="407" border="0" cellpadding="4" style="border:1px solid #000000;">
      <tr>
        <td width="117">Nama Pasien </td>
        <td width="8">:</td>
        <td width="260"><?=$nama;?> (<?=$sex;?>)</td>
      </tr>
      <tr>
        <td>Tanggal Lahir </td>
        <td>:</td>
        <td><?=$tgl;?>  /Usia : <?=$umur;?> th </td>
      </tr>
      <tr>
        <td>No. RM </td>
        <td>:</td>
        <td><?=$noRM;?> No. Registrasi : <?=$no_reg?> </td>
      </tr>
      <tr>
        <td>Ruang rawat/Kelas </td>
        <td>:</td>
        <td><?=$kamar;?> / <?=$kelas;?></td>
      </tr>
      <tr>
        <td height="23">Alamat</td>
        <td>:</td>
        <td><?=$alamat;?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="172">&nbsp;</td>
    <td width="12">&nbsp;</td>
    <td width="155">&nbsp;</td>
    <td width="189">&nbsp;</td>
    <td width="205">&nbsp;</td>
  </tr>
  <tr>
    <td>Tanggal Lahir </td>
    <td>:</td>
    <td><?=$tgl?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Jenis Kelamin </td>
    <td>:</td>
    <td><div class="kotak"><?php if($sex=='L'){echo '&radic;';}else{echo '&nbsp;';}?></div> 
      Laki-laki </td>
    <td><div class="kotak"><?php if($sex=='P'){echo '&radic;';}else{echo '&nbsp;';}?></div>
      Perempuan </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Jika Perempuan </td>
    <td>:</td>
    <td><div class="kotak"><?php if($dG['status_perempuan']=='Hamil'){echo '&radic;';}else{echo '&nbsp;';}?></div> 
    Hamil </td>
    <td><div class="kotak"><?php if($dG['status_perempuan']=='Tidak Hamil'){echo '&radic;';}else{echo '&nbsp;';}?></div> 
    Tidak Hamil </td>
    <td><div class="kotak"><?php if($dG['status_perempuan']=='Tidak Tahu'){echo '&radic;';}else{echo '&nbsp;';}?></div> 
      Tidak Tahu </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>PENYAKIT UTAMA </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Kesudahan</td>
    <td>:</td>
    <td><div class="kotak"><?php if($dG['kesudahan']=='Sembuh'){echo '&radic;';}else{echo '&nbsp;';}?></div>
      Sembuh</td>
    <td><div class="kotak"><?php if($dG['kesudahan']=='Alergi'){echo '&radic;';}else{echo '&nbsp;';}?></div>
      Alergi</td>
    <td><div class="kotak"><?php if($dG['kesudahan']=='Faktor Industri'){echo '&radic;';}else{echo '&nbsp;';}?></div>
      Faktor Industri </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div class="kotak"><?php if($dG['kesudahan']=='Meninggal'){echo '&radic;';}else{echo '&nbsp;';}?></div>
      Meninggal</td>
    <td><div class="kotak"><?php if($dG['kesudahan']=='Kondisi Medis'){echo '&radic;';}else{echo '&nbsp;';}?></div>
      Kondisi Medis lainnya </td>
    <td><div class="kotak"><?php if($dG['kesudahan']=='Faktor Kimia'){echo '&radic;';}else{echo '&nbsp;';}?></div>
      Faktor Kimia dan Lain-lain </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">Penyakit/ kondisi lain yang menyertai : </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div class="kotak"><?php if($penyakit[0]=='1'){echo '&radic;';}else{echo '&nbsp;';}?></div>
      Gangguan Ginjal </td>
    <td><div class="kotak"><?php if($penyakit[1]=='2'){echo '&radic;';}else{echo '&nbsp;';}?></div>
      Alergi</td>
    <td><div class="kotak"><?php if($penyakit[2]=='3'){echo '&radic;';}else{echo '&nbsp;';}?></div>
      Faktor industri </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div class="kotak"><?php if($penyakit[3]=='4'){echo '&radic;';}else{echo '&nbsp;';}?></div>
      Gangguan Hati </td>
    <td><div class="kotak"><?php if($penyakit[4]=='5'){echo '&radic;';}else{echo '&nbsp;';}?></div>
      Kondisi Medis lainnya </td>
    <td><div class="kotak"><?php if($penyakit[5]=='6'){echo '&radic;';}else{echo '&nbsp;';}?></div>
      Faktor Kimia dan lain-lain </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">EFEK SAMPING OBAT (E.S.O) </td>
  </tr>
  <tr>
    <td colspan="5">Bentuk Manifestasi E.S.O yang terjadi: </td>
  </tr>
  <tr>
    <td colspan="5"><p><?=$dG['manifestasi']?></p>    </td>
  </tr>
  <tr>
    <td colspan="5">Saat / Tanggal mulai terjadi : </td>
  </tr>
  <tr>
    <td colspan="5"><?=$dG['saat']?></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td>Kesudahan E.S.O</td>
    <td>:</td>
    <td><div class="kotak"><?php if($dG['kesudahan_eso']=='Sembuh'){echo '&radic;';}else{echo '&nbsp;';}?></div>
      Sembuh</td>
    <td><div class="kotak"><?php if($dG['kesudahan_eso']=='Meninggal'){echo '&radic;';}else{echo '&nbsp;';}?></div>
      Meninggal</td>
    <td><div class="kotak"><?php if($dG['kesudahan_eso']=='Gejala Sisa'){echo '&radic;';}else{echo '&nbsp;';}?></div>
      Sembuh dengan gejala sisa </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div class="kotak"><?php if($dG['kesudahan_eso']=='Belum Sembuh'){echo '&radic;';}else{echo '&nbsp;';}?></div>
      Belum sembuh </td>
    <td><div class="kotak"><?php if($dG['kesudahan_eso']=='Tidak Tahu'){echo '&radic;';}else{echo '&nbsp;';}?></div>
      Tidak Tahu </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">Riwayat E.S.O yang pernah dialami : </td>
  </tr>
  <tr>
    <td colspan="5"><?=$dG['riwayat_eso']?></td>
  </tr>
  <tr>
    <td colspan="5">OBAT </td>
  </tr>
  <tr>
    <td colspan="5"><table width="759" border="1" cellpadding="3" bordercolor="#000000" style="border-collapse:collapse;">
      <tr>
        <td width="26" rowspan="2" align="center" bgcolor="#CCCCCC" >No</td>
        <td width="128" rowspan="2" bgcolor="#CCCCCC"><div align="center">Nama Obat </div></td>
        <td width="77" rowspan="2" bgcolor="#CCCCCC"><div align="center">Bentuk Sedian</div></td>
        <td width="77" rowspan="2" bgcolor="#CCCCCC"><div align="center">Obat Yang dicurigai </div></td>
        <td height="23" colspan="4" bgcolor="#CCCCCC"><div align="center">Pemberian</div></td>
        <td width="167" rowspan="2" bgcolor="#CCCCCC"><div align="center">Indikasi Penggunaan </div></td>
      </tr>
      <tr>
        <td width="61" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="56" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="53" bgcolor="#CCCCCC">&nbsp;</td>
        <td width="56" bgcolor="#CCCCCC">&nbsp;</td>
        </tr>
        <?php 
		$sqD=mysql_query("select * from b_fom_monitoring_eso_detail where monitoring_eso_id='$dG[id]'");
		$no=1;
		while($dGD=mysql_fetch_array($sqD)){
			$txt_jam=explode('|',$dGD['pemberian']);
		?>
      <tr>
        <td align="center"><?=$no?></td>
        <td><?=$dGD['nama_obat']?></td>
        <td><?=$dGD['bentuk']?></td>
        <td><?=$dGD['obat_curigai']?></td>
        <td align="center"><?=$txt_jam[0]?></td>
        <td align="center"><?=$txt_jam[1]?></td>
        <td align="center"><?=$txt_jam[2]?></td>
        <td align="center"><?=$txt_jam[3]?></td>
        <td><?=$dGD['indikasi']?></td>
      </tr>
      <?php $no++; }?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">Keterangan tambahan : </td>
    <td rowspan="10"><table width="218" height="208" border="0" style="border:1px solid #000000;">
      <tr>
        <td width="212">Medan, <?php echo tgl_ina(date("Y-m-d"))?></td>
      </tr>
      <tr>
        <td><div align="center">Pelapor</div></td>
      </tr>
      <tr>
        <td height="112">&nbsp;</td>
      </tr>
      <tr>
        <td><div align="center">(______________________)</div></td>
      </tr>
      <tr>
        <td height="21"><div align="center">Nama &amp; Tanda Tangan </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="4"><span class="style2">(misalnya kecepatan efek samping obat, reaksi setelah obat dihentikan, pengobatan yang diberikan untuk mengatasi E.S.O)</span> </td>
  </tr>
  <tr>
    <td colspan="4"><?=$dG['ket_tambahan']?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">Data Labolatorium : </td>
  </tr>
  <tr>
    <td colspan="4"><span class="style2">(Bila ada)</span> </td>
  </tr>
  <tr>
    <td colspan="4"><?=$dG['data_lab']?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">Beri tanda centang (&radic;) pada jawaban yang dipilih </td>
  </tr>
  <tr>
    <td colspan="4">*Diisi oleh bagian farmasi </td>
  </tr>
    <tr>
    <td colspan="5" align="center"><div align="center"><tr id="trTombol">
        <td class="noline" colspan="5" align="right"><input id="btnPrint" type="button" value="Print" onClick="cetak(document.getElementById('trTombol'));"/>
                <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/></td>
      </tr></div></td>
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
