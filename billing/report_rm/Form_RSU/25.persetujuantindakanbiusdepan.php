<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Persetujuan Tindakan Bius Depan</title>
</head>
<?
include "setting.php";

	$sql="SELECT DISTINCT 
  peg.nama AS dokter, z.*, peg2.nama AS user_log
FROM
  b_kunjungan k 
  INNER JOIN b_pelayanan p 
    ON k.id = p.kunjungan_id
  LEFT JOIN b_tindakan bmt 
    	ON k.id = bmt.kunjungan_id 
    	AND p.id = bmt.pelayanan_id 
  LEFT JOIN b_ms_pegawai peg 
    	ON peg.id = bmt.user_act
  INNER JOIN persetujuan_tind_bius z
  	ON z.pelayanan_id = p.id
  LEFT JOIN b_ms_pegawai peg2 
    	ON peg2.id = z.user_act
WHERE k.id='$idKunj' AND p.id='$idPel' AND z.bius_id='".$_REQUEST['id']."'";
$rs=mysql_fetch_array(mysql_query($sql));
?>
<body>
<table width="800" border="0" style="font:12px tahoma;">
  <tr>
    <td><table width="528" border="1" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse;">
      <tr>
        <td width="124">Nama Pasien</td>
        <td width="173">:
          <?=$nama;?></td>
        <td width="75">&nbsp;</td>
        <td width="104">&nbsp;</td>
      </tr>
      <tr>
        <td>Tanggal Lahir</td>
        <td>:
          <?=$tgl;?></td>
        <td>Usia</td>
        <td>:
          <?=$umur;?>
          Thn</td>
      </tr>
      <tr>
        <td>No. RM</td>
        <td>:
          <?=$noRM;?>        </td>
        <td>No Registrasi </td>
        <td>: <?=$no_reg;?></td>
      </tr>
      <tr>
        <td>Ruang Rawat/Kelas</td>
        <td>:
          <?=$kamar;?>
            <?=$kelas;?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>:
          <?=$alamat;?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">(Tempelkan Sticker Identitas Pasien)</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="font:bold 14px tahoma;">PERSETUJUAN TINDAKAN PEMBIUSAN</td>
  </tr>
  <tr>
    <td style="border:1px solid #000000;"><table cellspacing="2" cellpadding="2">
      <col width="18" />
      <col width="20" />
      <col width="29" />
      <col width="138" />
      <col width="70" />
      <col width="64" />
      <col width="51" />
      <col width="99" />
      <col width="13" />
      <col width="92" />
      <col width="49" />
      <col width="58" />
      <col width="54" />
      <col width="47" />
      <tr height="20">
        <td height="20" width="11">&nbsp;</td>
        <td width="16"></td>
        <td width="35"></td>
        <td width="166"></td>
        <td width="68"></td>
        <td width="56"></td>
        <td width="41"></td>
        <td width="79"></td>
        <td width="3"></td>
        <td width="91"></td>
        <td width="44"></td>
        <td width="52"></td>
        <td width="48"></td>
        <td width="50"></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td>I.</td>
        <td colspan="2">Consent</td>
        <td></td>
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
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td colspan="4">Bersama ini    saya:  <u><?=$dokter?></u></td>
        <td colspan="8">(Dr. Yang Melakukan Pre    op) meminta consent dan wewenang untuk</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td colspan="5">melakukan pembiusan umum    / spinal / epidural / lokal</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td colspan="4">untuk procedur pembedahan    / pengobatan</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td colspan="2">I, <u><?=$dokter?></u></td>
        <td colspan="9">hereby requet consent to    authorize the administration of general/spinal/local anesthesia during the</td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td colspan="3">pending    procedure/operation/treatment</td>
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
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td colspan="6">Adapun alternatif untuk    pembiusan ini adalah: <strong><?=$rs["alterI1"]?></strong></td>
        <td colspan="2">Alternatif lain :</td>
        <td colspan="4"><strong><?=$rs["alterI2"]?></strong></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td colspan="6">Other alternative for    anaesthesia is: <strong><?=$rs["alterE1"]?></strong></td>
        <td colspan="5">Other    Alternative: <strong><?=$rs["alterE2"]?></strong></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td>II.</td>
        <td colspan="2">Risiko</td>
        <td></td>
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
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td>Risk</td>
        <td></td>
        <td></td>
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
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td align="right">1</td>
        <td colspan="11">Saya menyadari bahwa    pelayanan di Rumah Sakit ini merupakan suatu team approach (termasuk dokter    dan perawat</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="10">anestasi) dan    bahwasannya anestesi untuk tindakan operasi ini akan dilakukan atau dibawah    pengawasan:</td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="11">I understand that a team    approach to anesthesia care (including physician dan nurse anesthesia    assistance) is used at this hospital</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="7">and that anesthesia for    my operation will be provided by / or under the supervision of</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="2">Dr <u><?=$dokter?></u>.</td>
        <td>Sp An</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="5">Dokter yang melaksanakan    anestesi / Anesthesiologist</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td align="right">2</td>
        <td colspan="11">Saya menyadari dan    mengerti sepenuhnya penjelasan dokter spesialis anestesi bahwa jenis    pembiusan apapun yang&nbsp;</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="11">dilakukan selalu    mengandung konsekwensi dan resiko. Resiko potensial yang mungkin terjadi    termasuk perubahan</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="11">tekanan darah, reaksi    obat (alergi), henti jantung, kerusakan otak, kelumpuhan, kerusakan saraf    bahkan kematian.&nbsp;</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="8">Saya menyadari hal ini    dan resiko serta komplikasi lain yang juga mungkin dapat terjadi.</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="11">I understand that,    regardless of the type of anesthesia used, there are a number of risk and    consequences that may occur. The risks</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="9">include but are not    limited to changes in blood pressure, drug reactions, cardiac arrest, brain    damage, paralysis, nerve</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="7">damage and death. I    understand that these or other risks or complications may occur.</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td align="right">3</td>
        <td colspan="11">Saya menyadari dan    mengerti bahwa dalam praktek ilmu kedokteran, bukan merupakan ilmu    pengetahuan yang pasti</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="11">(exact science) dan saya    menyadari tidak seorangpun dapat menjanjikan atau menjamin sesuatu yang    berhubungan</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="4">dengan tindakan medis    termasuk pembiusan</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="10">I am aware that the    practice of anaesthesiologi, medicine and surgery is not an exact science and    acknowledge that no one has</td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="9">given to me any promises    or guarantees regarding the effectiveness or risk relating to the    administration of anesthesia</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td align="right">4</td>
        <td colspan="11">Saya menyadari dan    mengerti bahwa obat-obatan yang saya dapatkan sebelum prosedur pembedahan dan    pembiusan</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="11">dapat saja menimbulkan    komplikasi bagi pembiusan dan pembedahan. Oleh karena itu sudah kewajiban dan    tanggung</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="11">jawab saya untuk    memberikan informasi kepada dokter semua obat-obatan yang saya minum,    termasuk aspirin,</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="7">kontrasepsi, obat-obatan    flu, narkotik, marijuana, kokain dan lain-lain.</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="11">I understand that any in    my medication I am taking may cause complications with anesthesia and    surgery, I acknowledge that it is my</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="10">responsibility and in my    best interest, to inform my physicians of any medications I am taking    including but not limited to aspirin,</td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="5">contraceptives, cold    remedies, narcotics, marijuana and cocaine.</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
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
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td align="right">5</td>
        <td colspan="11">Saya sudah membaca    formulir ini secara teliti, mengerti dan menyetujui penjelasan tentang    tindakan yang akan&nbsp;</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="11">dilakukan termasuk    kemungkinan komplikasi-komplikasi yang mungkin terjadi. Oleh sebab itu saya    menyatakan</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="5">mengerti isinya dan    menerima persyaratan yang tercantum.</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="11">I have read this form    carefully and / or it has been fully explained to me and I certify that I    understand its contents and I accept its</td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="10">term. My    anaesthesiologist has discussed with me and my family the anesthesia plan and    applicable alternatives. All my</td>
        <td></td>
      </tr>
      <tr height="25">
        <td height="25">&nbsp;</td>
        <td></td>
        <td></td>
        <td colspan="3">questions have been    answered to my satisfaction.</td>
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
      <td align="center"><div align="center"><tr id="trTombol">
        <td class="noline" colspan="5" align="right"><input id="btnPrint" type="button" value="Print" onClick="cetak(document.getElementById('trTombol'));"/>
                <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/></td>
      </tr></div>
  </td>
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
