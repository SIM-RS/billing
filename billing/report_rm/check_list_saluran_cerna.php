<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CHECK LIST CATH</title>
       <style>
        .gb{
	border-bottom:1px solid #000000;
}
</style>
</head>
<?
include "setting.php";
$dt=mysql_fetch_array(mysql_query("select * from b_fom_cath_form where id='$_GET[id]'"));
$list=explode(',',$dt['list']);
?>
<body>
<table width="795" border="0" align="center" cellpadding="5" cellspacing="2" style="border:1px solid #000000; font:12px tahoma;">
  <tr>
    <td height="66" colspan="9"><table width="528" border="0" align="right" cellpadding="4" bordercolor="#000000" style="border:1px solid #000000; collapse;">
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
          <?=$noRM;?></td>
        <td>No Registrasi </td>
        <td>:____________</td>
      </tr>
      <tr>
        <td>Ruang Rawat/Kelas</td>
        <td>:
          <?=$kamar;?>
          /
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
    </table></td>
  </tr>
  <tr>
    <td colspan="9">CHECK LIST PELAYANAN EDOSKPI SALUTAN CERNA </td>
  </tr>
  <tr>
    <td width="1">&nbsp;</td>
    <td width="20">&nbsp;</td>
    <td width="154">&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Tanggal</td>
    <td colspan="4">:&nbsp;<?=tglSql($dt['tgl_list']);?></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>PRE-TINDAKAN</td>
    <td colspan="4">:&nbsp;<?=$dt['tindakan'];?></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Identitas </td>
    <td colspan="3"><form id="form1" name="form1" method="post" action="">
      <label>
        <input type="text" name="textfield" />
        </label>
    </form>    </td>
    <td width="257"><div align="right">Dr. Pengirim </div></td>
    <td colspan="2">: </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td width="95">&nbsp;</td>
    <td width="72">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>I. </td>
    <td>Nama Tindakan </td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>a. Gastroskopi </td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>b. Kolonoskopi </td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>c. Ligasi / STE VE </td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>d. Polipectomy Gastroskopi </td>
    <td width="8">&nbsp;</td>
    <td width="82">&nbsp;</td>
    <td width="38">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>e. Kauterisasi Gastroskopi </td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>f. ST Hemoroid </td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">g. Safari Bouginane / Dilatasi Esofagus </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>h. Kolonoskopi &amp; STH </td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">i. Polipectomy / hautensasi Klolon </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">j. Heat Probe Vikuskager / Ovodeni </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>III. </td>
    <td>Diagnosa Medis </td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="189">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="6"><form id="form2" name="form2" method="post" action="">
      <label>
      <textarea name="textarea" cols="80" rows="10"> </textarea>
      </label>
    </form>    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>IV.</td>
    <td>Pemeriksaan Fisik </td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>a. Keadaan Umum </td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>b. Kesadaran </td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>c. Berat Badan </td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>d. Tekanan Darah </td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>e. Pernafasan </td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td> f. Suhu  </td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>g. Nadi </td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
