<?
include "../../koneksi/konek.php";
$id=$_REQUEST['id'];
$idPsn=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$idPel=$_REQUEST['idPel'];
$idUser=$_REQUEST['idUser'];
$sqlP="SELECT p.*,bk.no_reg,TIMESTAMPDIFF(YEAR,p.tgl_lahir,CURDATE()) AS usia,mk.nama AS nm_kls,u.nama AS nm_unit,IFNULL(pg.nama,'-') AS dr_rujuk, a.ku as ku2, a.kesadaran as kes2,
a.bb as bb2, a.tensi as tensi2, a.rr as rr2, a.suhu as suhu2, a.nadi as nadi2
FROM b_pelayanan pl 
INNER JOIN b_kunjungan bk ON pl.kunjungan_id=bk.id 
LEFT JOIN b_ms_pasien p ON p.id=pl.pasien_id
LEFT JOIN b_ms_kelas mk ON mk.id=pl.kelas_id
LEFT JOIN b_ms_unit u ON u.id=pl.unit_id
LEFT JOIN anamnese a ON a.KUNJ_ID=pl.kunjungan_id
LEFT JOIN b_ms_pegawai pg ON pg.id=pl.user_act
WHERE pl.id='$idPel';";
$dP=mysql_fetch_array(mysql_query($sqlP));
//include "setting.php";
?>
<?
$sql="SELECT *, DATE_FORMAT(tgl, '%d-%m-%Y') tgl2
FROM b_ceklist_salurancerna
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
<title>Ceklist Pelayanan Endoskopi Saluran Cerna</title>
<style type="text/css">
<!--
.style3 {font-size: 18px}
-->
</style>
</head>
<?
//include "setting.php";
?>
<body>
<form>
<table width="800" border="0" style="font:12px tahoma;">
  <tr>
    <td width="346"><p class="style3">&nbsp;</p>
      <p class="style3">&nbsp;</p>
      <p class="style3">&nbsp;</p>
      <p class="style3">CEKLIST    PELAYANAN ENDOSKOPI SALURAN CERNA</p></td>
    <td width="513"><table width="508" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse; border:1px solid #000000;">
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
        <td>:&nbsp;<?=$dP['no_reg'];?></td>
        </tr>
      <tr>
        <td>Ruang Rawat/Kelas</td>
        <td>:
          <?=$dP['nm_unit'];?>
          /
          <?=$dP['nm_kls'];?></td>
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
    <td colspan="2" style="border:1px solid #000000;"><table width="800" border="0">
      <tr>
        <td width="790"><div align="left">
          <table width="855" height="950" cellpadding="0" cellspacing="0" font:"12px tahoma;">
            <col width="64" />
            <col width="102" />
            <col width="254" />
            <col width="11" />
            <col width="190" />
            <tr height="20">
              <td height="20">&nbsp;</td>
              <td colspan="2">&nbsp;</td>
              <td></td>
              <td width="507"></td>
              </tr>
            <tr height="20">
              <td width="20" height="20">&nbsp;</td>
              <td colspan="2"><span class="style7">Tanggal <span class="style5">
                <?=$d['tgl2'];?>
                </span></span></td>
              <td width="74"></td>
              <td></td>
              </tr>
            <tr height="20">
              <td height="20"></td>
              <td colspan="2"></td>
              <td></td>
              <td></td>
              </tr>
            <tr height="20">
              <td height="20"></td>
              <td colspan="2"><strong>PRE-TINDAKAN</strong></td>
              <td></td>
              <td></td>
              </tr>
            <tr height="20">
              <td height="20"></td>
              <td colspan="2"></td>
              <td></td>
              <td></td>
              </tr>
            <tr height="20">
              <td height="20"><span class="style4">.</span> <strong>I</strong></td>
              <td width="150"><span class="style5"><strong>Data Demografi </strong></span></td>
              <td width="102">&nbsp;</td>
              <td></td>
              <td><span class="style5">Dr. Pengirim: 
                <?=$dP['dr_rujuk'];?>
                </span></td>
              </tr>
            <tr height="20">
              <td height="20"></td>
              <td colspan="2"></td>
              <td></td>
              <td></td>
              </tr>
            <tr height="20">
              <td height="20">&nbsp;</td>
              <td colspan="4"><span class="style5">Identitas : </span><span class="style5">
                <?=$d['identitas'];?>
                </span></td>
              </tr>
            <tr height="20">
              <td height="20"></td>
              <td colspan="2"></td>
              <td></td>
              <td></td>
              </tr>
            <tr height="20">
              <td height="20"><span class="style4">.</span> <strong>II</strong></td>
              <td colspan="2"><span class="style7">Nama Tindakan</span></td>
              <td></td>
              <td></td>
              </tr>
            <tr height="20">
              <td height="20"></td>
              <td colspan="2"></td>
              <td></td>
              <td></td>
              </tr>
            <tr height="20">
              <td height="20"></td>
              <td colspan="2"><span class="style5">a. Gastroskopi</span></td>
              <td colspan="2"><span class="style5">
                <?=$d['gastroskopi'];?>
                </span></td>
              </tr>
            <tr height="20">
              <td height="20"></td>
              <td colspan="2"><span class="style5">b. Kolonoskopi</span></td>
              <td colspan="2"><span class="style5">
                <?=$d['klonoskopi'];?>
                </span></td>
              </tr>
            <tr height="20">
              <td height="20"></td>
              <td colspan="2"><span class="style5">c. Ligasi / STE VE&nbsp;</span></td>
              <td colspan="2"><label></label>
                <span class="style5">
                  <?=$d['ligasi'];?>
                  </span></td>
              </tr>
            <tr height="20">
              <td height="20"></td>
              <td colspan="2"><span class="style5">d. Polipectomy Gastroskopi&nbsp;</span></td>
              <td colspan="2"><label></label>
                <span class="style5">
                  <?=$d['polipectomy_gastroskopi'];?>
                  </span></td>
              </tr>
            <tr height="20">
              <td height="20"></td>
              <td colspan="2"><span class="style5">e. Kauterisasi Gastroskopi&nbsp;</span></td>
              <td colspan="2"><label></label>
                <span class="style5">
                  <?=$d['kauterisasi_gastroskopi'];?>
                  </span></td>
              </tr>
            <tr height="20">
              <td height="20"></td>
              <td colspan="2"><span class="style5">f. ST Hemoroid&nbsp;</span></td>
              <td colspan="2"><label></label>
                <span class="style5">
                  <?=$d['st_hemoroid'];?>
                  </span></td>
              </tr>
            <tr height="20">
              <td height="20"></td>
              <td colspan="2"><span class="style5">g. Safari Bouginane / Dilatasi Esofagus&nbsp;</span></td>
              <td colspan="2"><label></label>
                <span class="style5">
                  <?=$d['safary_bouginage'];?>
                  </span></td>
              </tr>
            <tr height="20">
              <td height="20"></td>
              <td colspan="2"><span class="style5">h. Kolonoskopi &amp; STH&nbsp;</span></td>
              <td colspan="2"><span class="style5">
                <?=$d['kolonoskopi_sth'];?>
                </span></td>
              </tr>
            <tr height="20">
              <td height="20"></td>
              <td colspan="2"><span class="style5">i. Polipectomy / hautensasi Klolon&nbsp;</span></td>
              <td colspan="2"><label></label>
                <span class="style5">
                  <?=$d['polipectomi_hautensasi_kolon'];?>
                  </span></td>
              </tr>
            <tr height="20">
              <td height="20"></td>
              <td colspan="2"><span class="style5">j. Heat Probe Vikuskager / Ovodeni&nbsp;</span></td>
              <td colspan="2"><span class="style5">
                <?=$d['heat_probe_vikusgaster'];?>
                </span></td>
              </tr>
            <tr height="20">
              <td height="32"></td>
              <td colspan="2"></td>
              <td></td>
              <td></td>
              </tr>
            <tr height="20">
              <td height="20"><span class="style9">.</span><strong> III</strong></td>
              <td colspan="2"><p class="style7">Diagnosa Medis</p></td>
              <td></td>
              <td></td>
              </tr>
            <tr height="20">
              <td height="20"></td>
              <td colspan="4"><table width="100%" border="0">
                <?php $sqlD="SELECT md.nama FROM b_diagnosa d
LEFT JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
LEFT JOIN b_kunjungan k ON k.id=d.kunjungan_id
WHERE d.pelayanan_id='$idPel';";
$exD=mysql_query($sqlD);
while($dD=mysql_fetch_array($exD)){
?>
                <tr>
                  <td ><?=$dD['nama']?></td>
                  </tr>
                <?php }?>
                <tr>
                  <td >&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            <tr height="20">
              <td height="20"></td>
              <td colspan="2"></td>
              <td></td>
              <td></td>
              </tr>
            <tr height="20">
              <td height="20"><span class="style9">.</span><strong> IV</strong></td>
              <td colspan="2"><span class="style7">Pemeriksaan Fisik</span></td>
              <td></td>
              <td></td>
              </tr>
            <tr height="20">
              <td height="20"></td>
              <td colspan="2"><span class="style5">a. Keadaan Umum</span></td>
              <td colspan="2">:
                <?=$dP['ku2'];?></td>
              </tr>
            <tr height="20">
              <td height="20"></td>
              <td colspan="2"><span class="style5">b. Kesadaran</span></td>
              <td colspan="2">:
                <label></label>
                <?=$dP['kes2'];?></td>
              </tr>
            <tr height="20">
              <td height="20"></td>
              <td colspan="2"><span class="style5">c. Berat Badan</span></td>
              <td colspan="2">:
                <label></label>
                <?=$dP['bb2'];?></td>
              </tr>
            <tr height="20">
              <td height="20"></td>
              <td colspan="2"><span class="style5">d. Tekanan Darah</span></td>
              <td colspan="2">:
                <?=$dP['tensi2'];?></td>
              </tr>
            <tr height="20">
              <td height="20"></td>
              <td colspan="2"><span class="style5">e. Pernafasan</span></td>
              <td colspan="2">:
                <label></label>
                <?=$dP['rr2'];?></td>
              </tr>
            <tr height="20">
              <td height="20"></td>
              <td colspan="2"><span class="style5">f. Suhu</span></td>
              <td colspan="2">:
                <label></label>
                <?=$dP['suhu2'];?></td>
              </tr>
            <tr height="20">
              <td height="20"></td>
              <td colspan="2"><span class="style5">g. Nadi</span></td>
              <td colspan="2">:
                <label></label>
                <?=$dP['nadi2'];?></td>
              </tr>
            <tr height="20">
              <td height="87"></td>
              <td colspan="2"></td>
              <td></td>
              <td></td>
              </tr>
            </table>
          </div></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td><table cellspacing="0" cellpadding="0">
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
          <tr height="20" id="trTombol">
            <td width="247" height="20"><input type="button" name="bt_cetak" id="bt_cetak" value="Cetak" onclick="cetak(document.getElementById('trTombol'));" /></td>
            <td width="27"></td>
            <td width="109"></td>
            <td width="31"></td>
            <td width="31"></td>
            <td width="31"></td>
            <td width="31"></td>
            <td width="33"></td>
            <td width="259">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</form>
</body>
</html>
<script>
    function cetak(tombol){
        tombol.style.visibility='collapse';
        if(tombol.style.visibility=='collapse'){
            if(confirm('Anda yakin mau mencetak ?')){
                setTimeout('window.print()','1000');
                setTimeout('window.close()','2000');
            }
            else{
                tombol.style.visibility='visible';
            }

        }
    }

</script>
