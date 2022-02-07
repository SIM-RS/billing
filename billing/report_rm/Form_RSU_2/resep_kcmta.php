<?php 
include "../../koneksi/konek.php";
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUsr=$_REQUEST['idUser'];
$idx=$_REQUEST['id'];
$sqlP="SELECT p.*,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit
FROM b_pelayanan pl 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
$dt=mysql_fetch_array(mysql_query("select * from b_fom_resep_kcmata where id='$idx'"));

$spher=explode(',',$dt['spher']);
$cyl=explode(',',$dt['cyl']);
$axis=explode(',',$dt['axis']);
$prism=explode(',',$dt['prism']);
$base=explode(',',$dt['base']);
$spher2=explode(',',$dt['spher_2']);
$cyl2=explode(',',$dt['cyl_2']);
$axis2=explode(',',$dt['axis_2']);
$prism2=explode(',',$dt['prism_2']);
$base2=explode(',',$dt['base_2']);
$jpupil=explode(',',$dt['jarak_pupil']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Resep Kacamata</title>
<style>
.header{ font-weight:bold; background:#999; color:#000;}
.gb {	border-bottom:1px solid #000000;
}
.gb{
	border-bottom:1px solid #000000;
}
.inputan{
	width:200px;
	}
.gb1 {	border-bottom:1px solid #000000;
}
</style>
</head>

<body>
<table width="200" border="0">
  <tr>
    <td><table cellspacing="0" cellpadding="0">
      <col width="57" />
      <col width="10" />
      <col width="51" span="10" />
      <col width="72" />
      <tr>
        <td colspan="13" width="649" align="center"><b>RESEP KACA MATA</b></td>
      </tr>
      <tr>
        <td colspan="13" width="649" align="left" valign="top"><img width="480" height="149" src="resep_kcmta_clip_image007.png" alt="tes mata.jpg,tes mata.jpg" />
          <table cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="13">&nbsp;</td>
            </tr>
            <tr>
              <td style="display:none" colspan="13" width="649">Monofocus / Bifocus</td>
            </tr>
          </table></td>
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
        <td></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table cellspacing="0" cellpadding="3" style="font:12px tahoma; border-collapse:collapse;" border="1">
      <col width="57" />
      <col width="10" />
      <col width="51" span="10" />
      <col width="72" />
      <tr class="header">
        <td colspan="2" width="67">&nbsp;</td>
        <td width="51" align="center">Spher</td>
        <td width="51" align="center">Cyl</td>
        <td width="51" align="center">Axis</td>
        <td width="51" align="center">Prism</td>
        <td width="51" align="center">Base</td>
        <td width="51" align="center">Spher</td>
        <td width="51" align="center">Cyl</td>
        <td width="51" align="center">Axis</td>
        <td width="51" align="center">Prism</td>
        <td width="51" align="center">Base</td>
        <td width="72" align="center">Jarak Pupil</td>
      </tr>
      <tr>
        <td colspan="2">Jauh</td>
        <td align="center"><?=$spher[0];?></td>
        <td align="center"><?=$cyl[0];?></td>
        <td align="center"><?=$axis[0];?></td>
        <td align="center"><?=$prism[0];?></td>
        <td align="center"><?=$base[0];?></td>
        <td align="center"><?=$spher2[0];?></td>
        <td align="center"><?=$cyl2[0];?></td>
        <td align="center"><?=$axis2[0];?></td>
        <td align="center"><?=$prism2[0];?></td>
        <td align="center"><?=$base2[0];?></td>
        <td align="center"><?=$jpupil[0];?></td>
      </tr>
      <tr>
        <td colspan="2">Dekat</td>
        <td align="center"><?=$spher[1];?></td>
        <td align="center"><?=$cyl[1];?></td>
        <td align="center"><?=$axis[1];?></td>
        <td align="center"><?=$prism[1];?></td>
        <td align="center"><?=$base[1];?></td>
        <td align="center"><?=$spher2[1];?></td>
        <td align="center"><?=$cyl2[1];?></td>
        <td align="center"><?=$axis2[1];?></td>
        <td align="center"><?=$prism2[1];?></td>
        <td align="center"><?=$base2[1];?></td>
        <td align="center"><?=$jpupil[1];?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table cellspacing="0" cellpadding="0" style="font:12px tahoma;">
      <col width="57" />
      <col width="10" />
      <col width="51" span="10" />
      <col width="72" />
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
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td width="57"></td>
        <td width="10"></td>
        <td width="51"></td>
        <td width="51"></td>
        <td width="51"></td>
        <td width="51"></td>
        <td width="51"></td>
        <td width="51"></td>
        <td width="51"></td>
        <td colspan="4" width="225">Medan,
          <?php echo tgl_ina(date("Y-m-d"))?>
        </td>
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
        <td colspan="4" align="center">Dokter,</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>Nama</td>
        <td>:</td>
        <td colspan="5" class="gb"><?=$dP['nama']?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>Umur</td>
        <td>:</td>
        <td colspan="5" class="gb"><?=$dP['usia']?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>:</td>
        <td colspan="5" class="gb"><?=$dP['alamat']?></td>
        <td></td>
        <td></td>
        <td colspan="4" align="center">(……………………………………………)</td>
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
        <td colspan="4" align="center">Nama &amp; Tanda Tangan</td>
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