<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<?php
include "setting.php";
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,kk.no_reg as no_reg2
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_kunjungan kk ON kk.id=pl.kunjungan_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$dt=mysql_fetch_array(mysql_query("SELECT 
  a.*
FROM
  lap_surveilan_infeksi_noso a
WHERE id = '$_GET[id]'"));

$antib_alasan=explode('*|-',$dt['antib_alasan']);
		$jenis1=explode('*|-',$dt['jenis1']);
		$jenis2=explode('*|-',$dt['jenis2']);
		$jenis3=explode('*|-',$dt['jenis3']);
		$ruang1=explode('*|-',$dt['ruang1']);
		$ruang2=explode('*|-',$dt['ruang2']);
		$ruang3=explode('*|-',$dt['ruang3']);
		$catheter=explode('*|-',$dt['catheter']);
		$urine_catheter=explode('*|-',$dt['urine_catheter']);
		$ngt=explode('*|-',$dt['ngt']);
		$cvc=explode('*|-',$dt['cvc']);
		$ett=explode('*|-',$dt['ett']);
		$lain=explode('*|-',$dt['lain']);
?>
<body>
<table border="0" style="font:12px tahoma;">
  <tr>
    <td width="711"><table cellspacing="0" cellpadding="0">
      <col width="28" />
      <col width="75" />
      <col width="50" span="2" />
      <col width="12" />
      <col width="25" />
      <col width="78" />
      <col width="110" />
      <col width="50" span="2" />
      <col width="113" />
      <col width="116" />
      <tr>
        <td width="28"></td>
        <td width="75"></td>
        <td width="50"></td>
        <td width="50"></td>
        <td width="12"></td>
        <td width="25"></td>
        <td width="78"></td>
        <td align="left" valign="top"><table cellpadding="0" cellspacing="0">
          <tr>
              <td width="110"></td>
              </tr>
        </table></td>
        <td colspan="4" rowspan="6" align="left" valign="top"><table width="390" border="0" cellpadding="4" style="border:1px solid #000000;">
        <tr>
          <td width="102">Nama Pasien </td>
          <td width="5">:</td>
          <td width="249"> <?=$nama;?> (<?=$sex;?>)</td>
        </tr>
        <tr>
          <td>Tanggal Lahir </td>
          <td>:</td>
          <td> <?=$tgl;?> /Usia : <?=$umur;?> th </td>
        </tr>
        <tr>
          <td>No. RM </td>
          <td>:</td>
          <td><?=$noRM;?> No. Registrasi :
            <?=$dP['no_reg2'];?></td>
        </tr>
        <tr>
          <td>Ruang rawat/Kelas </td>
          <td>:</td>
          <td><?=$kamar;?> / <?=$kelas;?></td>
        </tr>
        <tr>
          <td height="22">Alamat</td>
          <td>:</td>
          <td><?=$alamat;?></td>
        </tr>
            </table></td>
        </tr>
      <tr>
        <td colspan="7" rowspan="5" valign="bottom">PEMERINTAH    KOTA MEDAN<br/><br/>
        RUMAH    SAKIT PELINDO I<br/><br/>
        SURVEILAN    INFEKSI NOSOKOMIAL<br/>&nbsp;</td>
        <td width="110"></td>
        </tr>
      <tr>
        <td></td>
        </tr>
      <tr>
        <td></td>
        </tr>
      <tr>
        <td></td>
        </tr>
      <tr>
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
        <td></td>
        </tr>
      <tr>
        <td>1.</td>
        <td colspan="3">Pemakaian antibiotik</td>
        <td>:</td>
        <td>&nbsp;</td>
        <td colspan="2"><span <?php if($antib_alasan[0]!=1){echo 'style="text-decoration:line-through"';}?>>Ada</span> / <span <?php if($antib_alasan[0]!=2){echo 'style="text-decoration:line-through"';}?>>Tidak ada</span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">Alasan    : <span <?php if($antib_alasan[1]!=1){echo 'style="text-decoration:line-through"';}?>>Profilaksasi</span> / <span <?php if($antib_alasan[1]!=2){echo 'style="text-decoration:line-through"';}?>>Pengobatan</span></td>
        </tr>
      <tr>
        <td>2.</td>
        <td colspan="2">Nama / Jenis</td>
        <td></td>
        <td>:</td>
        <td>1.</td>
        <td colspan="2"><u><?=$jenis1[0]?></u></td>
        <td colspan="2">Mulai tgl</td>
        <td><u><?=$jenis1[1]?></u></td>
        <td>s/d <u><?=$jenis1[2]?></u></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>2.</td>
        <td colspan="2"><u><?=$jenis2[0]?></u></td>
        <td colspan="2">Mulai tgl</td>
        <td><u><?=$jenis2[1]?></u></td>
        <td>s/d <u><?=$jenis2[2]?></u></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>3.</td>
        <td colspan="2"><u><?=$jenis3[0]?></u></td>
        <td colspan="2">Mulai tgl</td>
        <td><u><?=$jenis3[1]?></u></td>
        <td>s/d <u><?=$jenis3[2]?></u></td>
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
        </tr>
      <tr>
        <td colspan="3">Tempat    dirawat :</td>
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
        <td>1.</td>
        <td colspan="4">Ruang : <u><?=$ruang1[0]?></u></td>
        <td></td>
        <td colspan="3">tgl <u><?=$ruang1[1]?></u> s/d tgl <u><?=$ruang1[2]?></u></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>2.</td>
        <td colspan="4">Ruang : <u><?=$ruang2[0]?></u></td>
        <td></td>
        <td colspan="3">tgl <u><?=$ruang2[1]?></u> s/d tgl <u><?=$ruang2[2]?></u></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>3.</td>
        <td colspan="4">Ruang : <u><?=$ruang3[0]?></u></td>
        <td></td>
        <td colspan="3">tgl <u><?=$ruang3[1]?></u> s/d tgl <u><?=$ruang3[2]?></u></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
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
        </tr>
      <tr>
        <td colspan="4">Tanggal    keluar / meninggal</td>
        <td></td>
        <td></td>
        <td colspan="3"> : <u><?=$tgl_keluar?></u></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2">Sebab    keluar</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3"> : <u><?=$cara_keluar?></u></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2">Diagnosa    akhir</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3"> : <u><?=$diag?></u></td>
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
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table cellspacing="0" cellpadding="0" border="1">
      <col width="28" />
      <col width="75" />
      <col width="50" span="2" />
      <col width="12" />
      <col width="25" />
      <col width="78" />
      <col width="110" />
      <col width="50" span="2" />
      <col width="113" />
      <col width="116" />
      <tr>
        <td width="103" colspan="2" style="text-align: center">Tindakan</td>
        <td width="50" style="text-align: center">P</td>
        <td width="50" style="text-align: center">L</td>
        <td width="115" colspan="3" style="text-align: center">Alasan</td>
        <td width="110" style="text-align: center">Nama Jelas</td>
        <td width="50" style="text-align: center">P</td>
        <td width="50" style="text-align: center">L</td>
        <td width="113" style="text-align: center">Alasan</td>
        <td width="116" style="text-align: center">Nama Jelas</td>
        </tr>
      <tr>
        <td colspan="2">IV    Catheter</td>
        <td><?=$catheter[0]?></td>
        <td><?=$catheter[1]?></td>
        <td colspan="3"><?=$catheter[2]?></td>
        <td><?=$catheter[3]?></td>
        <td><?=$catheter[4]?></td>
        <td><?=$catheter[5]?></td>
        <td><?=$catheter[6]?></td>
        <td><?=$catheter[7]?></td>
      </tr>
      <tr>
        <td colspan="2">Urine Catheter</td>
        <td><?=$urine_catheter[0]?></td>
        <td><?=$urine_catheter[1]?></td>
        <td colspan="3"><?=$urine_catheter[2]?></td>
        <td><?=$urine_catheter[3]?></td>
        <td><?=$urine_catheter[4]?></td>
        <td><?=$urine_catheter[5]?></td>
        <td><?=$urine_catheter[6]?></td>
        <td><?=$urine_catheter[7]?></td>
      </tr>
      <tr>
        <td>NGT</td>
        <td>&nbsp;</td>
        <td><?=$ngt[0]?></td>
        <td><?=$ngt[1]?></td>
        <td colspan="3"><?=$ngt[2]?></td>
        <td><?=$ngt[3]?></td>
        <td><?=$ngt[4]?></td>
        <td><?=$ngt[5]?></td>
        <td><?=$ngt[6]?></td>
        <td><?=$ngt[7]?></td>
        </tr>
      <tr>
        <td colspan="2">CVC</td>
        <td><?=$cvc[0]?></td>
        <td><?=$cvc[1]?></td>
        <td colspan="3"><?=$cvc[2]?></td>
        <td><?=$cvc[3]?></td>
        <td><?=$cvc[4]?></td>
        <td><?=$cvc[5]?></td>
        <td><?=$cvc[6]?></td>
        <td><?=$cvc[7]?></td>
        </tr>
      <tr>
        <td colspan="2">Ventilator / ETT</td>
        <td><?=$ett[0]?></td>
        <td><?=$ett[1]?></td>
        <td colspan="3"><?=$ett[2]?></td>
        <td><?=$ett[3]?></td>
        <td><?=$ett[4]?></td>
        <td><?=$ett[5]?></td>
        <td><?=$ett[6]?></td>
        <td><?=$ett[7]?></td>
        </tr>
      <tr>
        <td colspan="2">Lain - lain</td>
        <td><?=$lain[0]?></td>
        <td><?=$lain[1]?></td>
        <td colspan="3"><?=$lain[2]?></td>
        <td><?=$lain[3]?></td>
        <td><?=$lain[4]?></td>
        <td><?=$lain[5]?></td>
        <td><?=$lain[6]?></td>
        <td><?=$lain[7]?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table cellspacing="0" cellpadding="0">
      <tr>
        <td width="28"></td>
        <td width="75"></td>
        <td width="50"></td>
        <td width="50"></td>
        <td width="12"></td>
        <td width="25"></td>
        <td width="78"></td>
        <td width="110"></td>
        <td width="50"></td>
        <td width="50"></td>
        <td width="113"></td>
        <td width="116"></td>
        </tr>
      <tr>
        <td colspan="7">Catatan    : IV catheter, lama pemasangan 3 hari</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td colspan="7">          Urine catheter, lama pemasangan 7    hari (sylicon 1 bulan)</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td colspan="6">          NGT, lama pemasangan 14 hari</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td colspan="2">          P, pasang</td>
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
        <td colspan="2">          L, lepas</td>
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
        <td colspan="2">Kriteria    Plebitis</td>
        <td colspan="5">0 : Tidak ada tanda    plebitis</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="5">1 : Merah atau sakit bila    ditekan</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="6">2 : Merah, sakit bila    ditekan, oedema</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="7">3 : Merah, sakit bila    ditekan, oedema dan vena mengeras</td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="9">4 : Merah, sakit bila    ditekan, oedema, vena mengeras dan timbul pus</td>
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
        <td></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    </tr><tr id="trTombol">
        <td class="noline" colspan="5" align="right"><div align="center">
          <input name="button" type="button" id="btnPrint" onclick="cetak(document.getElementById('trTombol'));" value="Print"/>
          <input name="button2" type="button" id="btnTutup" onclick="window.close();" value="Tutup"/>
        </div></td>
      </tr><tr><td><div align="center"></div></td>
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
</html>