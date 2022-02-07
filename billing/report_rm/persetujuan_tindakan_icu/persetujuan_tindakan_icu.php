<?
include "../../koneksi/konek.php";
$id=$_REQUEST['id'];
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUser'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
//include "setting.php";
?>
<?
$sql="SELECT *
FROM b_persetujuan_tind_icu
WHERE id='$id';";
$d=mysql_fetch_array(mysql_query($sql));
{

?>
<?
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css" />

        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../jquery.js"></script>
        <script type="text/javascript" src="../jquery.form.js"></script>
<title>.: Surat Keterangan Sakit :.</title>
<style>
        .gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:80px;
	}
.textArea{ width:97%;}
body{background:#FFF;}
        </style>
<title>resume kep</title>
<style type="text/css">
<!--
.style2 {font-size: 10px}
-->
</style>
</head>
<script type="text/JavaScript">
            var arrRange = depRange = [];
</script>
<style>
.kotak{
border:1px solid #000000;
}
.kotak2{
border:1px solid #000000;
width:20px;
height:20px;
}
</style>
<body onload="enable_text(false);enable_text2(false);enable_text3(false);">
<iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="1"
                style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
</iframe>
<div id="tampil_input" align="center" style="display:block">
<form id="form1" name="form1" action="sk_sakit_act.php">
<input type="hidden" name="idPel" value="<?=$idPel?>" />
    			<input type="hidden" name="idKunj" value="<?=$idKunj?>" />
    			<input type="hidden" name="idPsn" value="<?=$idPsn?>" />
    			<input type="hidden" name="idUser" value="<?=$idUser?>" />
    			<input type="hidden" name="id" id="id"/>
    			<input type="hidden" name="act" id="act" value="tambah"/>
<table width="800" border="0" style="font:12px tahoma;">
  <tr>
    <td><table width="100%" cellspacing="0" cellpadding="0">
      <col width="29" />
      <col width="27" />
      <col width="35" />
      <col width="21" />
      <col width="34" />
      <col width="64" span="8" />
      <tr height="">
        <td style="font:24px bold tahoma" colspan="8" rowspan="3" height="128">RS PELINDO I</td>
        <td colspan="5" width="438">&nbsp;</td>
      </tr>
      <tr height="86">
        <td height="86" colspan="5" align="center" valign="middle" class="kotak" style="font:22px bold tahoma">PERSETUJUAN TINDAKAN MEDIK DI ICU</td>
      </tr>
      <tr height="">
        <td colspan="5" height="14">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td align="right"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:1px solid #000">
      <col width="29" />
      <col width="27" />
      <col width="35" />
      <col width="21" />
      <col width="34" />
      <col width="64" span="10" />
      <tr height="">
        <td height="" colspan="16">&nbsp;</td>
      </tr>
      <tr height="">
        <td width="4" height="">&nbsp;</td>
        <td width="4" height="">&nbsp;</td>
        <td width="4" height="">&nbsp;</td>
        <td height="" colspan="13">Saya yang bertanda tangan di bawah ini:</td>
        </tr>
      <tr height="">
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="" colspan="13">&nbsp;</td>
      </tr>
      <tr height="26">
        <td height="26" colspan="2">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td width="392" height="26">Nama</td>
        <td width="8">:</td>
        <td colspan="10"><label for="textfield"></label>
          <?=$d['name'];?></td>
      </tr>
      <tr height="26">
        <td height="26">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td height="26">Umur</td>
        <td>:</td>
        <td colspan="10"><label for="alamat"></label>
          <?=$d['age'];?></td>
      </tr>
      <tr height="26">
        <td height="26">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td height="26">Jenis Kelamin</td>
        <td>:</td>
        <td colspan="10"><input disabled="disabled" name="checkbox" type="radio" id="checkbox" value="L" <? if($d['jenis_kelamin']=='L'){ echo "checked='checked'";}?> />
          <label for="Laki-Laki">Laki-Laki  <em>
            <input name="checkbox" disabled="disabled" type="radio" id="checkbox" value="P" <? if($d['jenis_kelamin']=='P'){ echo "checked='checked'";}?> />
            </em>Perempuan</label></td>
      </tr>
      <tr height="26">
        <td height="26">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td height="26">Alamat</td>
        <td>:</td>
        <td colspan="10"><label for="textfield4"></label>
          <?=$d['adress'];?></td>
      </tr>
      <tr height="5">
        <td height="" colspan="16"></td>
        </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td height="20">&nbsp;</td>
        <td height="20">&nbsp;</td>
        <td height="20" colspan="13">Dengan ini menyatakan SETUJU/MENOLAK* dilaksanakan tindakan <label for="textfield5"></label>
          <?=$d['tindakan'];?></td>
      </tr>
      <tr height="26">
        <td height="26" colspan="2">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td height="26">terhadap 
          <?=$d['terhadap'];?> dengan:</td>
        <td>&nbsp;</td>
        <td colspan="10">&nbsp;</td>
      </tr>
      <tr height="26">
        <td height="26" colspan="2">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td height="26">Nama</td>
        <td>:</td>
        <td colspan="10"><?=$dP['nama'];?></td>
      </tr>
      <tr height="26">
        <td height="26">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td height="26">Umur</td>
        <td>:</td>
        <td colspan="10"><?=$dP['usia'];?></td>
      </tr>
      <tr height="26">
        <td height="26">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td height="26">Jenis Kelamin</td>
        <td>:</td>
        <td colspan="10"><input disabled="disabled" name="checkbox2" type="checkbox" id="checkbox2" value="L" <? if($dP['sex']=='L'){ echo "checked='checked'";}?> />
          <label for="Laki-Laki2">Laki-Laki <em>
            <input name="checkbox2" disabled="disabled" type="checkbox" id="checkbox2" value="P" <? if($dP['sex']=='P'){ echo "checked='checked'";}?> />
            </em>Perempuan </label></td>
      </tr>
      <tr height="26">
        <td height="26">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td height="26">Alamat</td>
        <td>:</td>
        <td colspan="10"><?=$dP['alamat'];?></td>
      </tr>
      <tr height="26">
        <td height="26">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td height="26">&nbsp;</td>
        <td height="26">No. MR</td>
        <td>:</td>
        <td colspan="10"><?=$dP['no_rm'];?></td>
      </tr>
      <tr height="10">
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="10" colspan="13">&nbsp;</td>
      </tr>
      <tr height="">
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="" colspan="13">Yang dilaksanakan oleh dokter 
          <label for="textfield3"></label>
          <?=$d['adress'];?></td>
      </tr>
      <tr height="">
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="" colspan="13">&nbsp;</td>
      </tr>
      <tr height="">
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="" colspan="13">Cara kerja, tujuan dan komplikasi serta risiko yang mungkin terjadi dan tindakan tersebut telah dijelaskan pada saya oleh dokter  atas</td>
      </tr>
      <tr height="">
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="" colspan="13">tersebut di atas.</td>
      </tr>
      <tr height="">
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="" colspan="13">&nbsp;</td>
      </tr>
      <tr height="">
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="" colspan="13">Kepada saya juga telah dijelaskan mengenai pilihan tindakan alternatif seperti di bawah ini:</td>
      </tr>
      <tr height="10">
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="" colspan="13">&nbsp;</td>
        </tr>
      <tr height="10">
        <td height="32">&nbsp;</td>
        <td height="32">&nbsp;</td>
        <td height="32">&nbsp;</td>
        <td height="32" colspan="13">1.
          <label for="textfield6"></label>
          <?=$d['alternatif1'];?></td>
        </tr>
      <tr height="10">
        <td height="28">&nbsp;</td>
        <td height="28">&nbsp;</td>
        <td height="28">&nbsp;</td>
        <td height="28" colspan="13">2.
          <label for="textfield9"></label>
          <?=$d['alternatif2'];?></td>
        </tr>
      <tr height="10">
        <td height="35">&nbsp;</td>
        <td height="35">&nbsp;</td>
        <td height="35">&nbsp;</td>
        <td height="35" colspan="13">3.
          <label for="textfield10"></label>
          <?=$d['alternatif3'];?></td>
        </tr>
      <tr height="33">
        <td></td>
        <td></td>
        <td></td>
        <td colspan="13">Saya juga menyatakan mengerti:</td>
      </tr>
      <div id="sakit">
        <tr >
          <td></td>
          <td></td>
          <td height=""></td>
          <td align="justify" colspan="12">1. Bahwa berdasarkan penjelasan dokter di ICU, tindakan apapun yang dilakukan selalu mengandung beberapa konsekuensi &nbsp;&nbsp;&nbsp;dan risiko. Risiko potensial yang terjadi termasuk perubahan tekanan darah, reaksi obat (alergi), henti jantung, kerusakan &nbsp;&nbsp;&nbsp;otak, kelumpuhan, kerusakan saraf, bahkan kematian. Saya menyadari hal ini dan risiko serta komplikasi lain yang mungkin &nbsp;&nbsp;&nbsp;&nbsp;terjadi.</td>
          <td width="76" align="justify">&nbsp;</td>
          </tr>
        <tr height="">
          <td></td>
          <td></td>
          <td height=""></td>
          <td colspan="13"></td>
          </tr>
        <tr height="">
          <td></td>
          <td></td>
          <td height=""></td>
          <td height="" colspan="13"></td>
          </tr>
        <tr height="">
          <td></td>
          <td></td>
          <td height=""></td>
          <td colspan="13"></td>
          </tr>
        <tr height="">
          <td></td>
          <td></td>
          <td height=""></td>
          <td colspan="13">&nbsp;</td>
        </tr>
        <tr height="">
          <td></td>
          <td></td>
          <td height=""></td>
          <td align="justify" colspan="12">2. Bahwa dalam praktek ilmu kedokteran, bukan merupakan ilmu pengetahuan yang pasti (<em>exact science</em>) dan saya &nbsp;&nbsp;&nbsp;&nbsp;menyadari tidak seorangpun dapat menjanjikan atau menjamin sesuatu yang berhubungan dengan tindakan medis ICU</td>
          <td>&nbsp;</td>
          </tr>
      </div>
      <tr height="">
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td colspan="11">&nbsp;</td>
      </tr>
      <tr height="">
        <td></td>
        <td></td>
        <td height=""></td>
        <td align="justify" colspan="12">3. Bahwa obat-obatan yang digunakan sebelum prosedur di ICU dapat saja menimbulkan kompikasi. Oleh karena itu sudah &nbsp;&nbsp;&nbsp;menjadi kewajiban dan tanggung jawab saya untuk memberikan informasi kepada dokter semua obat-obatan yang saya &nbsp;&nbsp;&nbsp;suamisendiri / istri /  / anak / ayah / ibu gunakan. Termasuk aspirin, kontrasepsi, obat-obatan flu, narkotik, marijuana, &nbsp;&nbsp;&nbsp;&nbsp;kokain, dan lain-lain.</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="">
        <td></td>
        <td></td>
        <td height=""></td>
        <td colspan="13">&nbsp;</td>
      </tr>
      <tr height="">
        <td></td>
        <td></td>
        <td height=""></td>
        <td height="" colspan="13"></td>
      </tr>
      <tr height="">
        <td></td>
        <td></td>
        <td height=""></td>
        <td align="justify" colspan="12">4. Bahwa selama pasien dirawat di ICU, dapat dilakukan tindakan-tindakan medis sesuai kondidi pasien berdasarkan &nbsp;&nbsp;&nbsp;&nbsp;pertimbangan medis termasuk intubasi, pemakaian ventilator, kateter vena sental, arteri line serta transfuse darah dan / &nbsp;&nbsp;&nbsp;&nbsp;atau produk-produk darah.</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="">
        <td></td>
        <td></td>
        <td height=""></td>
        <td colspan="13">&nbsp;</td>
      </tr>
      <tr height="">
        <td></td>
        <td></td>
        <td height=""></td>
        <td align="justify" colspan="12">5. Bahwa dokter ICU yang bertugas dapat melakukan konsultasi atau mendapat bantuan dari dokter lain yang berkaitan jika &nbsp;&nbsp;&nbsp;&nbsp;dirasakan perlu.</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="">
        <td></td>
        <td></td>
        <td height=""></td>
        <td colspan="13">&nbsp;</td>
      </tr>
      <tr height="">
        <td></td>
        <td></td>
        <td height=""></td>
        <td align="justify" colspan="12">6. Bahwa apabila staf ICU yang bertugas di ICU mengalami luka tusuk atau terpapar cairan tubuh pasien, pasien setuju untuk &nbsp;&nbsp;&nbsp;&nbsp;diperiksa darahnya.</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="">
        <td></td>
        <td></td>
        <td height=""></td>
        <td colspan="13">&nbsp;</td>
      </tr>
      <tr height="33">
        <td></td>
        <td></td>
        <td></td>
        <td>* Coret yang tidak perlu</td>
        <td colspan="11">&nbsp;</td>
      </tr>
      <tr height="33">
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td colspan="11">&nbsp;</td>
      </tr>
      <tr height="33">
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;</td>
        <td colspan="11">&nbsp;</td>
      </tr>
      <tr height="21">
        <td height="21" colspan="16" align="center">&nbsp;
          <div align="center"><tr id="trTombol">
        <td class="noline" colspan="5" align="right"><input id="btnPrint" type="button" value="Print" onClick="cetak(document.getElementById('trTombol'));"/>
                <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/></td>
      </tr></div></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
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
