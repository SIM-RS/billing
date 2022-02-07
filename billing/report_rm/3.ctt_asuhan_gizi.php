<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>catatan asuhan gizi</title>
<style type="text/css">
<!--
.style1 {font-size: 18px}
-->
</style>
</head>
<?
include "setting.php";
$dG=mysql_fetch_array(mysql_query("select * from b_fom_asuhan_gizi where id='$_REQUEST[id]'"));
?>
<body>
<table width="775" border="0" cellpadding="4" style="font:12px tahoma;">
  <tr>
    <td width="153"><div align="right">Nama Pasien </div></td>
    <td width="9">:</td>
    <td width="299"><?=$nama;?></td>
  </tr>
  <tr>
    <td><div align="right">Tanggal Lahir </div></td>
    <td> : </td>
    <td><?=$tgl;?> Usia : <?=$umur;?></td>
  </tr>
  <tr>
    <td><div align="right">No. RM </div></td>
    <td>:</td>
    <td><?=$noRM;?></td>
  </tr>
  <tr>
    <td><div align="right">Ruang Rawat/Kelas </div></td>
    <td>:</td>
    <td><?=$kamar;?> / <?=$kelas;?></td>
  </tr>
  <tr>
    <td><div align="right">Alamat</div></td>
    <td>:</td>
    <td><?=$alamat;?></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">CATATAN ASUHAN GIZI </td>
  </tr>
  
  <tr>
    <td colspan="3"><table width="766" height="758" border="1" bordercolor="#000000" cellpadding="3" style="border-collapse:collapse;">
      <tr>
        <td height="51" colspan="2"><div align="center" class="style1">1.  ASSESMENT / MONITORING / REASSESMENT</div></td>
        <td width="298"><div align="center" class="style1">EVALUASI</div></td>
      </tr>
      <tr>
        <td width="158" height="88">a. Antropometri </td>
        <td width="288"><?=$dG['antropometri'];?></td>
        <td><?=$dG['antropometri_eval'];?></td>
      </tr>
      <tr>
        <td height="87">b. Biokimia </td>
        <td><?=$dG['biokimia'];?></td>
        <td><?=$dG['biokimia_eval'];?></td>
      </tr>
      <tr>
        <td height="81">c. Fisik-Klinis </td>
        <td><?=$dG['fisik'];?></td>
        <td><?=$dG['fisik_eval'];?></td>
      </tr>
      <tr>
        <td height="80">d. Riwayat Gizi </td>
        <td><?=$dG['riwayat_gizi'];?></td>
        <td><?=$dG['riwayat_gizi_eval'];?></td>
      </tr>
      <tr>
        <td height="86">e. Riwayat Personal </td>
        <td><?=$dG['riwayat_personal'];?></td>
        <td><?=$dG['riwayat_personal_eval'];?></td>
      </tr>
      <tr>
        <td height="86">2.DIAGNOSA GIZI (domain intake, klinis, behaviour)</td>
        <td colspan="2"><?=$dG['diagnosa_gizi'];?></td>
        </tr>
      <tr>
        <td height="89">3.INTERVENSI ( Jenis, bentuk, komposisi dan route diet) </td>
        <td colspan="2"><?=$dG['intervensi'];?></td>
        </tr>
      <tr>
        <td height="88">4. RENCANA MONEV </td>
        <td colspan="2"><?=$dG['rencana_monev'];?></td>
        </tr>
    </table></td>
  </tr>
  
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">Medan, <?=date('j ').getBulan(date('m')).date(' Y')?></td>
  </tr>
  <tr>
    <td colspan="3">Ahli Gizi : </td>
  </tr>
  <tr>
    <td height="55" colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><strong>(<u><?=$usr['nama'];?></u>)</strong></td>
  </tr>
  <tr>
    <td colspan="3">Tanda Tangan dan Nama Jelas </td>
  </tr>
  
    <tr id="trTombol">
    <td colspan="3" align="center"><input type="submit" name="button" id="button" value="Cetak" onclick="cetak(document.getElementById('trTombol'));" />
   									<input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/></td>
  </tr>
</table>
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