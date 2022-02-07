<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>inform konsen</title>
<style type="text/css">
<!--
.style1 {
	font-size: 24px;
	font-weight: bold;
}
.style3 {font-size: 24px}
.style5 {font-size: 16px}
-->

</style>
<?
include "setting.php";
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
?>

<?php
$id = $_GET['id'];
$sql = "SELECT 
          konsen.*,
          p.nama AS dokter
        FROM
          lap_inform_konsen konsen 
          INNER JOIN b_ms_pegawai p 
            ON konsen.dokter_id = p.id 
        WHERE konsen.id = '{$id}' ";
$query = mysql_query($sql);
$konsen = mysql_fetch_assoc($query);

?>

</head>
<script>
function cetak2()
{
	if(confirm('Anda Yakin Mau Mencetak ?')){
       setTimeout('window.print()','1000');
	}
	//window.close();
}
</script>

<body onload="cetak2()">
<table width="902" height="1455" border="0" align="center" cellpadding="4" style="font:12px tahoma;">
  <tr>
    <td colspan="2"><span class="style1">RS PELINDO I </span><span class="style3"><span class="style5">PERSETUJUAN TINDAKAN MEDIK DI <?php echo $unit; ?></span></span> </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Saya yang bertanda tangan dibawah ini : </td>
  </tr>
  <tr>
    <td width="116">Nama  </td>
    <td width="764">:<?php echo $konsen['nama']; ?></td>
  </tr>
  <tr>
    <td>Umur</td>
    <td>:<?php echo $konsen['umur']; ?></td>
  </tr>
  <tr>
    <td>Jenis Kelamin </td>
    <td>:<?php echo $konsen['jenis_kelamin']; ?></td>
  </tr>
  <tr>
    <td>Alamat</td>
    <td>:<?php echo $konsen['alamat']; ?></td>
  </tr>
  <tr>
    <td colspan="2">Dengan ini menyatakan <?php echo ($konsen['status_persetujuan'] == FALSE ? '<strike>SETUJU</strike>' : 'SETUJU') ?>/<?php echo ($konsen['status_persetujuan'] == TRUE ? '<strike>MENOLAK</strike>' : 'MENOLAK') ?>* dilaksanakan tindakan : <?php echo $konsen['tindakan']; ?> </td>
  </tr>
 <!--  <tr>
    <td colspan="2"> __________________________________________________________________________________________</td>
  </tr> -->
  <tr>
    <td colspan="2">terhadap <?php echo ($konsen['hubungan'] == 0 ? 'diri saya sendiri' : '<strike>diri saya sendiri</strike>' ) ?>/<?php echo ($konsen['hubungan'] == 1 ? 'istri' : '<strike>istri</strike>' ) ?>/<?php echo ($konsen['hubungan'] == 2 ? 'suami' : '<strike>suami</strike>' ) ?>/<?php echo ($konsen['hubungan'] == 3 ? 'anak' : '<strike>anak</strike>' ) ?>/<?php echo ($konsen['hubungan'] == 4 ? 'ayah' : '<strike>ayah</strike>' ) ?>/<?php echo ($konsen['hubungan'] == 5 ? 'ibu' : '<strike>ibu</strike>' ) ?> saya dengan:*</td>
  </tr>
  <tr>
    <td>Nama</td>
    <td>: <?=$nama;?></td>
  </tr>
  <tr>
    <td>Umur</td>
    <td>: <?=$umur;?></td>
  </tr>
  <tr>
    <td>Jenis Kelamin </td>
    <td>: <?=$sex;?></td>
  </tr>
  <tr>
    <td>Alamat</td>
    <td>: <?=$alamat;?></td>
  </tr>
  <tr>
    <td>No. Rekam Medis </td>
    <td>: 
    <?=$noRM;?></td>
  </tr>
  <tr>
    <td colspan="2">Yang dilaksanakan oleh <?php echo $konsen['dokter'];  ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Cara kerja, tujuan, dan komplikasi serta resiko yang mungkin terjadi dan tindakan tersebut telah dijelaskan pada saya oleh dokter tersebut diatas</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php list($tindakan1, $tindakan2, $tindakan3) = explode('*|*', $konsen['tindakan_alternatif']) ?>
  <tr>
    <td colspan="2">Kepada saya juga telah dijelaskan mengenai pilihan tindakan alternatif seperti dibawah ini: </td>
  </tr>
  <tr>
    <td colspan="2">1 <?php echo $tindakan1; ?></td>
  </tr>
  <tr>
    <td colspan="2">2 <?php echo $tindakan2; ?></td>
  </tr>
  <tr>
    <td colspan="2">3 <?php echo $tindakan3; ?></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Saya juga mengatakan mengerti : </td>
  </tr>
  <tr>
    <td colspan="2"><div align="justify">1. Bahwa berdasarkan penjelasan dokter di <?php echo $unit; ?>, tindakan apapun yang dilakukan selalu mengandung           beberapa konsekuensi dan resiko. Kemungkinan resiko yang dapat terjadi, termasuk perbahan tekanan darah, reaksi obat (Alergi), Henti jantung, kerusakan otak, kelumpuhan, kerusakan saraf bahkan kematian. Saya menyadari hal ini dan resiko serta komplikasi lain yang mungkin terjadi.</div></td>
  </tr>
  <tr>
    <td colspan="2"><div align="justify">2. Bahwa dalam praktek ilmu kedokteran, bukan merupakan ilmu pengetahuan yang pasti (exact science) dan saya menyadari tidak seorang pun dapat menjanjikan atau menjamin sesuatu yang berhubungan dengan tindakan medis <?php echo $unit; ?>.</div></td>
  </tr>
  <tr>
    <td colspan="2"><div align="justify">3. Bahwa obat-obatan yang digunakan sebelum prosedur di <?php echo $unit; ?> dapat saja menimbulkan komplikasi. Oleh karena itu sudah menjadi kewajiban dan tanggungjawab saya untuk memberikan informasi kepada dokter tentang semua obat-obatan yang saya sendiri /istri/suami/anak/ayah/ibu gunakan. Termasuk aspirin, kontrasepsi, obat-obatan flu, narkotik, marijuana, kokain, dan lain-lain</div></td>
  </tr>
  <tr>
    <td colspan="2">4. Bahwa selama pasien dirawat di <?php echo $unit; ?>, dapat dilakukan tindakan-tindakan medis sesuai kondisi pasien berdasarkan pertimbangan medis termasuk intubasi, pemakaian ventilator,kateter vena sentral, arteri line serta tranfuse darah dan atau produk-produk darah</td>
  </tr>
  <tr>
    <td colspan="2">5. Bahwa dokter <?php echo $unit; ?> yang bertugas dapat melakukan konsultasi atau mendapat bantuan dari dokter lain yang berkaitan jika dirasakan perlu.</td>
  </tr>
  <tr>
    <td colspan="2">6. Bahwa apabila staf <?php echo $unit; ?> yang sedang bertugas mengalami luka tusuk, atau terpapar cairan tubuh pasien, pasien setuju untuk diperiksa darahnya. </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><div align="justify">Saya menyadari dan mengerti sepenuhnya bahwa pada tindakan medis,  berbagai resiko dan komplikasi yang tidak didiskusikan sebelumnya mungkin dapat timbul, saya juga menyadari bahwa selama berlangsungnya tindakan tersebut, ada kemungkinan timbulnya kondisi-kondisi yang tidak terduga dimana hal tersebut memerlukan tindakan-tindakan perluasan yang berhubungan dengan perawatan yang sedang dilakukan, untuk itu saya menyetujui dilakukannya tindakan tersebut apabila diperlukan. </div></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Selanjutnya saya menyadari bahwa tidak ada jaminan atau janji-janji yang diberikan kepada saya sehubungan dengan hasil dan segala tindakan dan/ atau perawatan.</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Demikian pernyataan ini saya buat dengan penuh kesadaran dan tanpa paksaan.</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><div align="right">Medan, <?php echo tgl_ina(date("Y-m-d")) ?></div></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <?php list($saksi1, $saksi2) = explode('*|*', $konsen['saksi']); ?>
    <td height="334" colspan="2"><table width="948" border="0">
      <tr>
        <td width="21">1</td>
        <td width="288"><div align="center">Saksi - saksi </div></td>
        <td width="47">&nbsp;</td>
        <td width="258"><div align="center">Dokter</div></td>
        <td width="39">&nbsp;</td>
        <td width="269"><div align="center">Yang Membuat Pernyataan </div></td>
      </tr>
      <tr>
        <td height="74">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><div align="center"><?php echo strtoupper($saksi1) ?></div></td>
        <td>&nbsp;</td>
        <td><div align="center"><?php echo $konsen['dokter'] ?></div></td>
        <td>&nbsp;</td>
        <td><div align="center"><?php echo strtoupper($konsen['nama']) ?></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><div align="center">
          <p>Tanda Tangan dan Nama Jelas <br />
          </p>
        </div></td>
        <td>&nbsp;</td>
        <td><div align="center">Tanda Tangan dan Nama Jelas <br />
        </div></td>
        <td>&nbsp;</td>
        <td><div align="center">Tanda Tangan dan Nama Jelas <br />
        </div></td>
      </tr>
      <tr>
        <td>2</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="76">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="21">&nbsp;</td>
        <td><div align="center"><?php echo strtoupper($saksi2) ?></div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="21">&nbsp;</td>
        <td><div align="center">Tanda Tangan dan Nama Jelas <br />
        </div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>    </td>
  </tr><tr id="trTombol">
        <td class="noline" colspan="5" align="right"><div align="center">
          <input name="button" type="button" id="btnPrint" onclick="cetak(document.getElementById('trTombol'));" value="Print"/>
          <input name="button2" type="button" id="btnTutup" onclick="window.close();" value="Tutup"/>
        </div></td>
      </tr><tr><td height="334" colspan="2"><p align="center">&nbsp;</p></td>
  </tr>
</table>
<p>&nbsp;</p>
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
