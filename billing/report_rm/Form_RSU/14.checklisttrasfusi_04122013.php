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
FROM b_ceklist_transfusi
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
<title>Check List Transfusi</title>
</head>
<?
//include "setting.php";
?>
<body>
<form>
<table width="800" border="0" style="font:12px tahoma;">
  <tr>
    <td><table width="508" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
      <tr>
        <td width="124">Nama Pasien</td>
        <td width="173">:
          <?=$dP['nama'];?></td>
        <td width="75">&nbsp;</td>
        <td width="102">&nbsp;</td>
      </tr>
      <tr>
        <td>Tanggal Lahir</td>
        <td>:
          <?=tglSQL($dP['tgl_lahir']);?></td>
        <td>Usia</td>
        <td>:
          <?=$dP['usia'];?>
          Thn</td>
      </tr>
      <tr>
        <td>No. RM</td>
        <td>:
          <?=$dP['no_rm'];?>
        </td>
        <td>No Registrasi </td>
        <td>:____________</td>
      </tr>
      <tr>
        <td>Ruang Rawat/Kelas</td>
        <td>:
          <?=$dP['nm_unit'];?>
          / <?=$dP['nm_kls'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>:
          <?=$dP['alamat'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4">(Tempelkan Sticker Identitas Pasien)</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td style="font:bold 16px tahoma;">CHECK LIST TRANSFUSI</td>
  </tr>
  <tr>
    <td style="border:1px solid #000000;"><table width="800" border="0">
      <tr>
        <td width="66">DPJP</td>
        <td width="724" style="border-bottom:px solid #000000;">:
          <?=$d['dpjp'];?></td>
      </tr>
      <tr>
        <td colspan="2"><table cellspacing="0" cellpadding="0" border="1" style="border-collapse:collapse; border:0px;">
         
          <tr height="70">
            <td height="70" width="24"><div align="center"><strong>No</strong></div></td>
            <td width="368"><div align="center"><strong>Kegiatan</strong></div></td>
            <td width="113"><div align="center"><strong>Ya</strong></div></td>
            <td colspan="2" width="278"><div align="center"><strong>Nama    &amp; TTD</strong></div></td>
          </tr>
          <?php 
	  $isi=explode(",",$d['list']);
	  ?>
          <tr height="70">
            <td height="70"><div align="center">1</div></td>
            <td>Surat persetujuan    transfusi sudah di tandatangan</td>
            <td align="center"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[0]==1) { echo "checked='checked'";}?> />
              <label for="checkbox"></label></td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr height="70">
            <td height="70"><div align="center">2</div></td>
            <td>Nama pasien pada kantong    darah dan kartu darah sesuai</td>
            <td align="center"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[1]==2) { echo "checked='checked'";}?> />
              <label for="checkbox2"></label></td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr height="70">
            <td height="70"><div align="center">3</div></td>
            <td>Golongan darah di kantong    darah dan kartu darah sesuai</td>
            <td align="center"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[2]==3) { echo "checked='checked'";}?> />
              <label for="checkbox3"></label></td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr height="70">
            <td height="70"><div align="center">4</div></td>
            <td>Nomor kantong darah dan    nomor kartu darah sesuai</td>
            <td align="center"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[3]==4) { echo "checked='checked'";}?> />
              <label for="checkbox4"></label></td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr height="70">
            <td height="70"><div align="center">5</div></td>
            <td>Jenis darah sesuai dengan    pesanan dokter</td>
            <td align="center"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[4]==5) { echo "checked='checked'";}?> />
              <label for="checkbox5"></label></td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr height="70">
            <td height="70"><div align="center">6</div></td>
            <td>Darah belum kadaluarsa</td>
            <td align="center"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[5]==6) { echo "checked='checked'";}?> />
              <label for="checkbox6"></label></td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr height="70">
            <td height="70"><div align="center">7</div></td>
            <td>Cross cek item 1-6    dilakukan oleh dua orang dokter/perawat</td>
            <td align="center"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[6]==7) { echo "checked='checked'";}?> />
              <label for="checkbox7"></label></td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr height="70">
            <td height="70"><div align="center">8</div></td>
            <td>Nacl 0.9% 25-100cc sebelum    transfusi</td>
            <td align="center"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[7]==8) { echo "checked='checked'";}?> />
              <label for="checkbox8"></label></td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr height="70">
            <td height="70"><div align="center">9</div></td>
            <td>Mengukur S/N/TD/P sebelum    transfusi diberikan&nbsp;</td>
            <td align="center"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[8]==9) { echo "checked='checked'";}?> />
              <label for="checkbox9"></label></td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr height="70">
            <td height="70"><div align="center">10</div></td>
            <td>Mengukur S/N/TD/P 15 menit    setelah transfusi diberikan&nbsp;</td>
            <td align="center"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[9]==10) { echo "checked='checked'";}?> />
              <label for="checkbox10"></label></td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr height="70">
            <td height="70"><div align="center">11</div></td>
            <td>Kontrol tetes darah</td>
            <td align="center"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[10]==11) { echo "checked='checked'";}?> />
              <label for="checkbox11"></label></td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr height="25">
            <td height="85"><div align="center">12</div></td>
            <td><table width="324" border="0">
                <tr>
                  <td width="152" rowspan="4">Reaksi    transfusi darah </td>
                  <td width="28">-</td>
                  <td width="130">Menggigil</td>
                  </tr>
                <tr>
                  <td>-</td>
                  <td>Panas</td>
                  </tr>
                <tr>
                  <td>-</td>
                  <td>Shock</td>
                  </tr>
                <tr>
                  <td>-</td>
                  <td>Gatal</td>
                  </tr>
              </table></td>
            <td align="center"><input disabled="disabled" type="checkbox" name="checkbox" value="checkbox" <? if($isi[11]==12) { echo "checked='checked'";}?> />
              <label for="checkbox12"></label></td>
            <td colspan="2">&nbsp;</td>
          </tr>
          
        </table></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><table cellspacing="0" cellpadding="0">
          <col width="25" />
          <col width="55" />
          <col width="12" />
          <col width="22" />
          <col width="27" />
          <col width="106" />
          <col width="27" />
          <col width="109" />
          <col width="31" span="4" />
          <col width="33" span="2" />
          <col width="68" />
          <col width="158" />
          <tr height="20">
            <td height="20" width="25"></td>
            <td width="55"></td>
            <td width="12"></td>
            <td width="22"></td>
            <td width="27"></td>
            <td width="106"></td>
            <td width="27"></td>
            <td width="109"></td>
            <td width="31"></td>
            <td width="31"></td>
            <td width="31"></td>
            <td width="31"></td>
            <td width="33"></td>
            <td colspan="3" width="259"><div align="center">Medan, <?php echo date("j F Y")?></div></td>
          </tr>
          <tr height="20">
            <td colspan="6" height="20"><div align="center">Penanggung Jawab</div></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="3"><div align="center">Dokter Ruangan/Jaga</div></td>
          </tr>
          <tr height="20">
            <td height="20"></td>
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
            <td><div align="center"></div></td>
            <td><div align="center"></div></td>
            <td><div align="center"></div></td>
          </tr>
          <tr height="20">
            <td height="20"></td>
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
            <td><div align="center"></div></td>
            <td><div align="center"></div></td>
            <td><div align="center"></div></td>
          </tr>
          <tr height="20">
            <td height="20"></td>
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
            <td><div align="center"></div></td>
            <td><div align="center"></div></td>
            <td><div align="center"></div></td>
          </tr>
          <tr height="20">
            <td height="20"></td>
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
            <td><div align="center"></div></td>
            <td><div align="center"></div></td>
            <td><div align="center"></div></td>
          </tr>
          <tr height="20">
            <td colspan="6" height="20"><div align="center"><strong>(<?=$dP['nama'];?>)</strong></div></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="3"><div align="center"><strong>(<?=$dP['dr_rujuk'];?>)</strong></div></td>
          </tr>
          <tr height="20">
            <td colspan="6" height="20"><div align="center">Nama jelas dan Tanda    tangan</div></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="3"><div align="center">Nama jelas dan Tanda tangan</div></td>
          </tr>
          <tr height="20">
            <td colspan="6" height="20">&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr height="20">
            <td colspan="6" height="20"><input type="button" name="bt_cetak" id="bt_cetak" value="Cetak" onclick="window.print()" /></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td colspan="3">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
