<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: PESANAN POST CATHETERISASI :.</title>
</head>
<?
include "setting.php";
$pos="select * from lap_pesanan_pos where pelayanan_id='$idPel' and kunjungan_id='$idKunj' and pesanan_id='".$_REQUEST['id']."'";
$isi=mysql_fetch_array(mysql_query($pos));
?>
<body>
<table width="800" border="0" style="font:12px tahoma;">
  <tr>
    <td><table width="528" border="1" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse;">
      <tr>
        <td width="124">Nama Pasien</td>
        <td width="173">: <?=$nama;?></td>
        <td width="75">&nbsp;</td>
        <td width="104">&nbsp;</td>
      </tr>
      <tr>
        <td>Tanggal Lahir</td>
        <td>: <?=$tgl;?></td>
        <td>Usia</td>
        <td>: <?=$umur;?> Thn</td>
      </tr>
      <tr>
        <td>No. RM</td>
        <td>: <?=$noRM;?></td>
        <td>No Registrasi </td>
        <td>: <?=$noreg;?></td>
      </tr>
      <tr>
        <td>Ruang Rawat/Kelas</td>
        <td>: <?=$kamar;?> / <?=$kelas;?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>: <?=$alamat;?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<br />
<span style="font:bold 18px tahoma;">PESANAN POST CATHETERISASI</span><br />
<table width="800" border="1" cellpadding="4" bordercolor="#000000" style="font:12px tahoma; border-collapse:collapse;">
  <tr>
    <td><table width="800" border="0" cellpadding="4">
      <tr>
        <td width="39">&nbsp;</td>
        <td width="116">&nbsp;</td>
        <td width="613">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Tanggal</td>
        <td>: <?=tglSQL($isi["tgl"])?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Dokter</td>
        <td>: <?=$dokter?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Diagnosa</td>
        <td>: <?php $sqlD="SELECT GROUP_CONCAT(md.nama) AS diag FROM b_diagnosa d
LEFT JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
LEFT JOIN b_kunjungan k ON k.id=d.kunjungan_id
WHERE d.pelayanan_id='$idPel';";
$exD=mysql_fetch_array(mysql_query($sqlD));
echo $exD['diag'];
?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="800" border="0" cellpadding="4">
      <tr>
        <td width="37">&nbsp;</td>
        <td colspan="2"><b>Instruksi</b></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td width="19">1</td>
        <td width="712"> Periksa Tanda-tanda vital </td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><table width="617" border="1" bordercolor="#000000" style="border-collapse:collapse;">
          <tr>
            <td width="163">Post Tindakan</td>
            <td width="104" align="center">30 menit </td>
            <td width="101" align="center">1 jam </td>
            <td width="113" align="center">2 jam </td>
            <td width="102" align="center">3 jam </td>
          </tr>
          <tr>
            <td>a. Tensi </td>
            <td style="text-align:center;"><u><?=$isi["tensi1"]?></u></td>
            <td style="text-align:center;"><u><?=$isi["tensi2"]?></u></td>
            <td style="text-align:center;"><u><?=$isi["tensi3"]?></u></td>
            <td style="text-align:center;"><u><?=$isi["tensi4"]?></u></td>
          </tr>
          <tr>
            <td>b. Nadi </td>
            <td style="text-align:center;"><u><?=$isi["nadi1"]?></u></td>
            <td style="text-align:center;"><u><?=$isi["nadi2"]?></u></td>
            <td style="text-align:center;"><u><?=$isi["nadi3"]?></u></td>
            <td style="text-align:center;"><u><?=$isi["nadi4"]?></u></td>
          </tr>
          <tr>
            <td>c. Suhu </td>
            <td style="text-align:center;"><u><?=$isi["suhu1"]?></u></td>
            <td style="text-align:center;"><u><?=$isi["suhu2"]?></u></td>
            <td style="text-align:center;"><u><?=$isi["suhu3"]?></u></td>
            <td style="text-align:center;"><u><?=$isi["suhu4"]?></u></td>
          </tr>
          <tr>
            <td>d. RR </td>
            <td style="text-align:center;"><u><?=$isi["rr1"]?></u></td>
            <td style="text-align:center;"><u><?=$isi["rr2"]?></u></td>
            <td style="text-align:center;"><u><?=$isi["rr3"]?></u></td>
            <td style="text-align:center;"><u><?=$isi["rr4"]?></u></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>2</td>
        <td>Buat rekaman EKG terbaru, tanggal <u><?=tglSQL($isi["tgl2"])?></u></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>3</td>
        <td>Infus <u><?=$isi["infus"]?></u></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>4</td>
        <td>Oksigen <u><?=$isi["oksigen"]?></u>Liter</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>5</td>
        <td>Obat-obatan yang diberikan di ruang cath lab</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>a. <u><?=$isi["obat1"]?></u></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>b. <u><?=$isi["obat2"]?></u></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>c. <u><?=$isi["obat3"]?></u></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>d. <u><?=$isi["obat4"]?></u></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>a.</td>
        <td>Perawatan Post Tindakan Radial</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>*Dengan Nichiban / Radstat</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Nichiban / Radstat dilonggarkan jam <u><?=$isi["jam"]?></u></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- 1 jam kemudian jika tidak ada tanda-tanda perdarahan pada pergelangan tangan, nichiban/radstat</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Jika masih ada tanda-tanda perdarahan pada pergelangan tangan, nichiban/radstat direkatkan kembali seperti semula</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Pergelangan tangan kanan/kiri tidak boleh ditekuk sampai jam <u><?=$isi["jam2"]?></u></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Bekas luka tusuk ditutup dengan hansaplast</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>*Dengan TR-Bank</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Udara di TR-Bank dikurangi 2 CC</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- 1 Jam kemudian TR-Band boleh dilepas</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Jika masih ada tanda-tanda perdarahan pada pergelangan tangan, udara yang dikeluarkan dari TR-Band dimasukkan kembali</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Pergelangan tangan kanan/kiri tidak boleh ditekuk sampai jam <u><?=$isi["jam3"]?></u></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Bekas luka tusuk ditutup dengan hansaplast</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>

      <tr>
        <td width="37">&nbsp;</td>
        <td width="19">b.</td>
        <td width="712">Perawatan Post Tindakan dari Brachialis</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Siku tangan tidak boleh ditekuk sampai jam <u><?=$isi["jam4"]?></u></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Elastis verband dilepas jam <u><?=$isi["jam5"]?></u></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Bekas luka tusuk ditutup dengan hansaplast</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Untuk tindakan post PCI, cek ACT/PT/APTT jam <u><?=$isi["jam6"]?></u> Bila hasil normal snealth boleh dilepas</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>

      <tr>
        <td>&nbsp;</td>
        <td>c.</td>
        <td>Perawatan Post Tindakan dari Femoral</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Kaki kanan / kiri tidak boleh ditekuk sampai jam <u><?=$isi["jam7"]?></u></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Elastis Verban dilepas jam <u><?=$isi["jam8"]?></u></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Pasien boleh mobilisasi pelan-pelan jam <u><?=$isi["jam9"]?></u></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Bekas luka tusuk ditutup dengan hansaplast</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Periksa daerah inguinal kanan/kiri</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Periksa nadi dorsalis pedis kanan/ kiri</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>- Untuk tindakan post PCI, cek ACT/PT/APTT jam <u><?=$isi["jam10"]?></u> Bila hasil normal snealth boleh dilepas</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>d.</td>
        <td>Pasien boleh langsung makan/minum setelah selesai tindakan.</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2"><b><u>Perhatian</u></b></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>1.</td>
        <td>Bila terjadi perdarahan/ hematom dibekas luka tusuk tempat kateterisasi, tekan dengan tiga jari</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>dibagian proximalny selama 10-15 menit.</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>2.</td>
        <td>Lapor ke dokter Operator/ Dokter jaga bila :&quot;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>a. Masih terus berdarah</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>b. Hypotensi</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>c. Bradycardia</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>d. Arythmia</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>e. Distress/ kesakitan</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>f. Febris/ menggigil</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>g. Sesak</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><table width="622" border="0">
          <tr align="center">
            <td width="297">Petugas Cath-Lab</td>
            <td width="315">Penerima Pasien</td>
          </tr>
          <tr>
            <td height="73">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr align="center">
            <td>(<strong><u><?php echo $usr['nama'];?></u></strong>)</td>
            <td>(_____________________)</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr id="trTombol">
        <td class="noline" align="center">
                    
                    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));" />
              <input id="btnTutup" type="button" value="Tutup" onClick="tutup();"/>
    </td>
  </tr>
</table>
</body>
<script type="text/JavaScript">

            function cetak(tombol){
                tombol.style.visibility='collapse';
                if(tombol.style.visibility=='collapse'){
                    if(confirm('Anda Yakin Mau Mencetak PESANAN POST CATHETERISASI ?')){
                        setTimeout('window.print()','1000');
                        setTimeout('window.close()','2000');
                    }
                    else{
                        tombol.style.visibility='visible';
                    }

                }
            }
			
function tutup(){
	window.close();
	}
        </script>
</html>
