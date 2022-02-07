<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>TIMEOUT CHECKLIST</title>
<style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style3 {font-size: 14px}
-->
</style>
</head>
<?
include("../../koneksi/konek.php");
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUsr'];
$id=$_REQUEST['id'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
//include "setting.php";
$sql2="SELECT * FROM b_timeout_checklist where pelayanan_id='$idPel' AND id='$id'";
$dP2=mysql_fetch_array(mysql_query($sql2));
$list=explode(',',$dP2['list_perawatan']);
$cek=explode(',',$dP2['list_dokter_bedah']);
?>
<style>
.gb{
	border-bottom:1px solid #000000;
}
</style>
<body>
<div>
<table width="806" border="0" style="font:12px tahoma">
  <tr>
    <td width="800" align="left"><table width="810" border="0">
      <tr>
        <td width="337" height="100">&nbsp;</td>
        <td width="453" rowspan="2"><table width="457" border="0" style="border:1px solid #000000">
      <tr>
        <td width="108">Nama Pasien </td>
        <td colspan="3">: 
          <?=$dP['nama'];?></td>
        </tr>
      <tr>
        <td>Tanggal Lahir </td>
        <td>: 
          <?=tglSQL($dP['tgl_lahir']);?></td>
        <td width="85">&nbsp;</td>
        <td width="85">&nbsp;</td>
      </tr>
      <tr>
        <td>Jenis Kelamin</td>
        <td> : 
          <?=$dP['sex'];?></td>
        <td>Usia</td>
        <td>:
          <?=$dP['usia'];?> Tahun</td>
      </tr>
      <tr>
        <td>No R.M </td>
        <td>: 
          <?=$dP['no_rm'];?></td>
        <td>No registrasi </td>
        <td>:_________</td>
      </tr>
      <tr>
        <td>Ruang Rawat/Kelas</td>
        <td colspan="3">: 
          <?=$dP['nm_unit'];?> / 
          <?=$dP['nm_kls'];?></td>
        </tr>
      <tr>
        <td height="20">Alamat</td>
        <td colspan="3">: 
          <?=$dP['alamat'];?></td>
        </tr>
      <tr>
        <td height="21" colspan="4"><div align="center">(Tempelkan sticker identitas pasien)</div></td>
        </tr>
    </table></td>
      </tr>
      <tr>
        <td height="20"><span class="style1">TIME OUT CHECK LIST</span></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="798" border="0" style="border-collapse:collapse">
      <tr>
        <td height="34" colspan="5" style="border-left:1px solid #000000;border-top:1px solid #000000;border-right:1px solid #000000;"><span class="style3">Tanggal Tindakan / Prosedur</span></td>
        </tr>
      <tr>
        <td height="22" colspan="3" style="border-left:1px solid #000000;border-top:1px solid #000000;"><div align="center"><strong>RUANG PERSIAPAN </strong></div></td>
        <td colspan="2" style="border-top:1px solid #000000;border-right:1px solid #000000;"><div align="center"><strong>Perawatan</strong></div></td>
        </tr>
      <tr>
        <td style="border-left:1px solid #000000;border-top:1px solid #000000;">&nbsp;</td>
        <td colspan="2" style="border-top:1px solid #000000;">&nbsp;</td>
        <td style="border-top:1px solid #000000;"><div align="center">Ya</div></td>
        <td style="border-top:1px solid #000000;border-right:1px solid #000000;"><div align="center">Tidak</div></td>
      </tr>
      <tr>
        <td width="13" style="border-left:1px solid #000000;">1.</td>
        <td colspan="2">Verifikasi Identitas pasien (gelang identitas, catatan, dan pasien)</td>
        <td width="71"><div align="center">
          <input disabled="disabled" type="checkbox" name="checkbox2" value="checkbox" <?php if($list[0]==1){echo ' checked="checked"';}?>/>
        </div></td>
        <td width="70" style="border-right:1px solid #000000;"><div align="center">
          <input disabled="disabled" type="checkbox" name="checkbox16" value="checkbox" <?php if($list[0]==0){echo ' checked="checked"';}?>/>
        </div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">2.</td>
        <td colspan="2">Kelengkapan Informed Consent</td>
        <td><div align="center">
          <input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <?php if($list[1]==1){echo ' checked="checked"';}?>/>
        </div></td>
        <td style="border-right:1px solid #000000;"><div align="center">
          <input disabled="disabled" type="checkbox" name="checkbox15" value="checkbox" <?php if($list[1]==0){echo ' checked="checked"';}?>/>
        </div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">3.</td>
        <td colspan="2">&quot;Marking&quot; area operasi sesuai dengan prosedur</td>
        <td><div align="center">
          <input disabled="disabled" type="checkbox" name="checkbox3" value="checkbox" <?php if($list[2]==1){echo ' checked="checked"';}?>/>
        </div></td>
        <td style="border-right:1px solid #000000;"><div align="center">
          <input disabled="disabled" type="checkbox" name="checkbox14" value="checkbox" <?php if($list[2]==0){echo ' checked="checked"';}?>/>
        </div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">4.</td>
        <td colspan="2">Pengkajian pre operasi dan kelengkapan check list</td>
        <td><div align="center">
          <input disabled="disabled" type="checkbox" name="checkbox4" value="checkbox" <?php if($list[3]==1){echo ' checked="checked"';}?>/>
        </div></td>
        <td style="border-right:1px solid #000000;"><div align="center">
          <input disabled="disabled" type="checkbox" name="checkbox13" value="checkbox" <?php if($list[3]==0){echo ' checked="checked"';}?>/>
        </div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">5.</td>
        <td colspan="2">Riwayat fisik dan rencana operasi oleh dokter bedah (tanggal terakhir)</td>
        <td><div align="center">
          <input disabled="disabled" type="checkbox" name="checkbox5" value="checkbox" <?php if($list[4]==1){echo ' checked="checked"';}?> />
        </div></td>
        <td style="border-right:1px solid #000000;"><div align="center">
          <input disabled="disabled" type="checkbox" name="checkbox12" value="checkbox" <?php if($list[4]==0){echo ' checked="checked"';}?> />
        </div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">6.</td>
        <td colspan="2">Adanya pengkaijan Pre Anaesthesi dan Informed Consent Anastesi</td>
        <td><div align="center">
          <input disabled="disabled" type="checkbox" name="checkbox6" value="checkbox" <?php if($list[5]==1){echo ' checked="checked"';}?> />
        </div></td>
        <td style="border-right:1px solid #000000;"><div align="center">
          <input disabled="disabled" type="checkbox" name="checkbox11" value="checkbox" <?php if($list[5]==0){echo ' checked="checked"';}?> />
        </div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">7.</td>
        <td colspan="2">Dokumen Laboratorium, radiology, dan test lain yang diperlukan</td>
        <td><div align="center">
          <input disabled="disabled" type="checkbox" name="checkbox7" value="checkbox" <?php if($list[6]==1){echo ' checked="checked"';}?> />
        </div></td>
        <td style="border-right:1px solid #000000;"><div align="center">
          <input disabled="disabled" type="checkbox" name="checkbox10" value="checkbox" <?php if($list[6]==0){echo ' checked="checked"';}?> />
        </div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">8.</td>
        <td colspan="2">Tersedia alat khusus dan obat - obatan yang diperlukan dan siap digunakan</td>
        <td><div align="center">
          <input disabled="disabled" type="checkbox" name="checkbox8" value="checkbox" <?php if($list[7]==1){echo ' checked="checked"';}?> />
        </div></td>
        <td style="border-right:1px solid #000000;"><div align="center">
          <input disabled="disabled" type="checkbox" name="checkbox9" value="checkbox" <?php if($list[7]==0){echo ' checked="checked"';}?> />
        </div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td width="309">&nbsp;</td>
        <td width="321">&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td colspan="4" style="border-right:1px solid #000000;">Perawat di Ruang Pre - Operasi :</td>
        </tr>
      <tr>
        <td height="46" style="border-left:1px solid #000000;">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td>..........................................</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td> &nbsp;&nbsp;(Nama dan Tanda Tangan)</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000; border-bottom:1px solid #000000;">&nbsp;</td>
        <td style="border-bottom:1px solid #000000;">&nbsp;</td>
        <td style="border-bottom:1px solid #000000;">&nbsp;</td>
        <td style="border-bottom:1px solid #000000;">&nbsp;</td>
        <td style="border-bottom:1px solid #000000; border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" style="border-left:1px solid #000000; border-bottom:1px solid #000000;"><div align="center"><strong>TIME - OUT DI KAMAR OPERASI</strong></div></td>
        <td colspan="2" style="border-right:1px solid #000000; border-bottom:1px solid #000000;"><div align="center"><strong>Dokter Bedah</strong></div></td>
        </tr>
      <tr>
        <td colspan="5" style="border-left:1px solid #000000; border-right:1px solid #000000;"><em>Sebelum dimulainya prosedur semua anggota team yang akan mengopersi pasien tersebut hadir dan memperhatikan proses &quot; TIME OUT&quot; dipimpin oleh dokter bedah.</em></td>
        </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="center">Ya</div></td>
        <td style="border-right:1px solid #000000;"><div align="center">Tidak</div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">1.</td>
        <td colspan="2">Anggota Team memastikan nama pasien, prosedur dan area yang dioperasi</td>
        <td><div align="center">
          <input disabled="disabled" type="checkbox" name="checkbox42" value="checkbox" <?php if($cek[0]==1){echo ' checked="checked"';}?> />
        </div></td>
        <td style="border-right:1px solid #000000;"><div align="center">
          <input disabled="disabled" type="checkbox" name="checkbox43" value="checkbox" <?php if($cek[0]==0){echo ' checked="checked"';}?> />
        </div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td colspan="2">(Informed Consent, gelang nama dan formulir pre operasi )</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">2.</td>
        <td>Dokter Bedah Menjelaskan antisipasi terhadap </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td>a. Komplikasi</td>
        <td> : 
          <?=$dP2['komplikasi_kamar'];?></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td>b. Perkiraan kehilangan darah (mL)</td>
        <td>: <?=$dP2['kehilangan_darah'];?> ml</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td>c. Rencana penempatan setelah operasi</td>
        <td>: <?=$dP2['r_pemindahan_pasien'];?></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">3.</td>
        <td>Antibiotik Profilaksis</td>
        <td>: 
          <?=$dP2['antibiotik'];?></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">4.</td>
        <td>Alergi Obat</td>
        <td>: 
          <?=$dP2['alergi'];?></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000";>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" style="border-left:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid #000000;"><table width="800" border="0">
          <tr>
            <td><div align="center">Dokter Bedah</div></td>
            <td><div align="center">Dokter Anastesi</div></td>
            <td><div align="center">Perawat Sirkulasi</div></td>
          </tr>
          <tr>
            <td height="48"><div align="center"></div></td>
            <td><div align="center"></div></td>
            <td><div align="center"></div></td>
          </tr>
          <tr>
            <td><div align="center">...........................................</div></td>
            <td><div align="center">...........................................</div></td>
            <td><div align="center">...........................................</div></td>
          </tr>
          <tr>
            <td><div align="center">(Nama dan Tanda Tangan)</div></td>
            <td><div align="center">(Nama dan Tanda Tangan)</div></td>
            <td><div align="center">(Nama dan Tanda Tangan)</div></td>
          </tr>
          <tr>
            <td><div align="center"></div></td>
            <td><div align="center"></div></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        </tr>
      
      <tr>
        <td colspan="3" style="border-left:1px solid #000000; border-bottom:1px solid #000000;"><div align="center"><strong>SEBELUM KELUAR KAMAR OPERASI</strong></div></td>
        <td colspan="2" style="border-bottom:1px solid #000000; border-right:1px solid #000000;"><div align="center"><strong>Dokter Bedah</strong></div></td>
        </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="center">Ya</div></td>
        <td style="border-right:1px solid #000000;"><div align="center">Tidak</div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">1.</td>
        <td>Tindakan yang dilakukan sesuai rencana</td>
        <td>&nbsp;</td>
        <td><div align="center">
          <input disabled="disabled" type="checkbox" name="checkbox422" value="checkbox" <?php if($cek[1]==1){echo ' checked="checked"';}?> />
        </div></td>
        <td style="border-right:1px solid #000000;"><div align="center">
          <input disabled="disabled" type="checkbox" name="checkbox424" value="checkbox" <?php if($cek[1]==0){echo ' checked="checked"';}?> />
        </div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">2.</td>
        <td>Penghitungan kassa, jarum, instrumen sudah benar</td>
        <td>&nbsp;</td>
        <td><div align="center">
          <input disabled="disabled" type="checkbox" name="checkbox423" value="checkbox" <?php if($cek[2]==1){echo ' checked="checked"';}?> />
        </div></td>
        <td style="border-right:1px solid #000000;"><div align="center">
          <input disabled="disabled" type="checkbox" name="checkbox425" value="checkbox" <?php if($cek[2]==0){echo ' checked="checked"';}?> />
        </div></td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">3.</td>
        <td>Pemindahan pasien ke :</td>
        <td>: 
          <?=$dP2['pemindahan_pasien'];?></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">4.</td>
        <td>Komplikasi</td>
        <td>: 
          <?=$dP2['komplikasi_sebelum'];?></td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" style="border-left:1px solid #000000; border-right:1px solid #000000;"><table width="800" border="0">
          <tr>
            <td><div align="center">Dokter Bedah</div></td>
            <td><div align="center">Dokter Anastesi</div></td>
            <td><div align="center">Perawat Sirkulasi</div></td>
          </tr>
          <tr>
            <td height="48"><div align="center"></div></td>
            <td><div align="center"></div></td>
            <td><div align="center"></div></td>
          </tr>
          <tr>
            <td><div align="center">...........................................</div></td>
            <td><div align="center">...........................................</div></td>
            <td><div align="center">...........................................</div></td>
          </tr>
          <tr>
            <td><div align="center">(Nama dan Tanda Tangan)</div></td>
            <td><div align="center">(Nama dan Tanda Tangan)</div></td>
            <td><div align="center">(Nama dan Tanda Tangan)</div></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td style="border-left:1px solid #000000;">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-right:1px solid #000000;">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" style="border-left:1px solid #000000;  border-right:1px solid #000000;">Beri tanda <img src="centang.png" width="14" height="19" />Pada kotak yang tersedia </td>
        </tr>
      <tr>
        <td colspan="5" align="right" style="border-left:1px solid #000000;  border-right:1px solid #000000;"></td>
      </tr>
      <tr id="trTombol">
        <td class="noline" colspan="5" align="right" style="border-left:1px solid #000000; border-bottom:1px solid #000000; border-right:1px solid #000000;"><input id="btnPrint" type="button" value="Print" onClick="cetak(document.getElementById('trTombol'));"/>
                <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/></td>
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
</div>
<?php 
mysql_close($konek);
?>
</html>
