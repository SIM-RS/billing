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
<table width="712" border="0" cellpadding="5" cellspacing="2" style="font:12px tahoma;">
  <tr>
    <td height="66" colspan="5"><table width="528" border="1" align="right" cellpadding="4" bordercolor="#000000" style="border-collapse:collapse;">
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
  <tr>
    <td colspan="5">CHECK LIST PERSIAPAN PASIEN CATHETERISASI</td>
  </tr>
  <tr>
    <td width="109">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Tanggal</td>
    <td colspan="2">:&nbsp;<?=tglSql($dt['tgl_list']);?></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Dokter</td>
    <td colspan="2">:&nbsp;<?=$dokter;?></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Teknik Tindakan</td>
    <td colspan="2">:&nbsp;<?=$dt['tindakan'];?></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Riwayat Penyakit</td>
    <td colspan="2">:&nbsp;<?=$identitas["RPS"];?></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>TB</td>
    <td width="97">:&nbsp;<?=$identitas['TB'];?></td>
    <td width="307">BB :&nbsp;<?=$identitas['BB'];?></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td width="40"><b>Ya</b></td>
    <td width="97"><b>Tidak</b></td>
  </tr>
  <tr>
    <td colspan="3" height="30">1. Penderita dan keluarga dijelaskan tentang prosedur tindakan</td>
    <td ><input type="checkbox" name="checkbox" value="checkbox" disabled="disabled" <?php if($list[0]==1){echo ' checked="checked"';}?> /></td>
    <td><input type="checkbox" name="checkbox18" value="checkbox" disabled="disabled" <?php if($list[0]==0){echo ' checked="checked"';}?>/></td>
  </tr>
  <tr>
    <td colspan="3" height="30">2. Surat Ijin Tindakan (Informed Consent)</td>
    <td><input type="checkbox" name="checkbox2" value="checkbox" disabled="disabled" <?php if($list[1]==1){echo ' checked="checked"';}?>/></td>
    <td><input type="checkbox" name="checkbox19" value="checkbox" disabled="disabled" <?php if($list[1]==0){echo ' checked="checked"';}?>/></td>
  </tr>
  <tr>
    <td colspan="3" height="30">3. Beritahu Petugas kasir dengan__</td>
    <td><input type="checkbox" name="checkbox3" value="checkbox" disabled="disabled" <?php if($list[2]==1){echo ' checked="checked"';}?>/></td>
    <td><input type="checkbox" name="checkbox20" value="checkbox" disabled="disabled" <?php if($list[2]==0){echo ' checked="checked"';}?>/></td>
  </tr>
  <tr>
    <td colspan="3" height="30">4. Periksa EKG terbaru</td>
    <td><input type="checkbox" name="checkbox4" value="checkbox" disabled="disabled" <?php if($list[3]==1){echo ' checked="checked"';}?>/></td>
    <td><input type="checkbox" name="checkbox21" value="checkbox" disabled="disabled" <?php if($list[3]==0){echo ' checked="checked"';}?>/></td>
  </tr>
  <tr>
    <td colspan="3" height="30">5. Periksa Lab : Hematologi lengkap, GDS, Ureum, Kreatinin, BT, CT, INR, CCT, HBsAg, </td>
    <td><input type="checkbox" name="checkbox5" value="checkbox" disabled="disabled" <?php if($list[4]==1){echo ' checked="checked"';}?>/></td>
    <td><input type="checkbox" name="checkbox22" value="checkbox" disabled="disabled" <?php if($list[4]==0){echo ' checked="checked"';}?>/></td>
  </tr>
  <tr>
    <td colspan="3" height="30">&nbsp;&nbsp;&nbsp;Anti HIV, Anti HCV (Sesuai Instruksi dokter)</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" height="30">6. Pasang IV line pada tangan kiri (RL/Nacl sesuai instruksi dokter</td>
    <td><input type="checkbox" name="checkbox7" value="checkbox" disabled="disabled" <?php if($list[5]==1){echo ' checked="checked"';}?>/></td>
    <td><input type="checkbox" name="checkbox23" value="checkbox" disabled="disabled" <?php if($list[5]==0){echo ' checked="checked"';}?>/></td>
  </tr>
  <tr>
    <td colspan="3" height="30">7. Puasa 2 jam untuk tindakan cath dan PTCA (Obat-obat tetap diberikan</td>
    <td><input type="checkbox" name="checkbox8" value="checkbox" disabled="disabled" <?php if($list[6]==1){echo ' checked="checked"';}?>/></td>
    <td><input type="checkbox" name="checkbox24" value="checkbox" disabled="disabled" <?php if($list[6]==0){echo ' checked="checked"';}?>/></td>
  </tr>
  <tr>
    <td colspan="3" height="30">8. Puasa 6 jam untuk tindakan DSA, TAE</td>
    <td><input type="checkbox" name="checkbox6" value="checkbox" disabled="disabled" <?php if($list[7]==1){echo ' checked="checked"';}?>/></td>
    <td><input type="checkbox" name="checkbox25" value="checkbox" disabled="disabled" <?php if($list[7]==0){echo ' checked="checked"';}?>/></td>
  </tr>
  <tr>
    <td colspan="3" height="30">9. Cukur pada lipatan paha kanan /kiri</td>
    <td><input type="checkbox" name="checkbox9" value="checkbox" disabled="disabled" <?php if($list[8]==1){echo ' checked="checked"';}?>/></td>
    <td><input type="checkbox" name="checkbox26" value="checkbox" disabled="disabled" <?php if($list[8]==0){echo ' checked="checked"';}?>/></td>
  </tr>
  <tr>
    <td colspan="3" height="30">10. Cukur pada pergelangan tangan kanan (Radial/ Brachial)</td>
    <td><input type="checkbox" name="checkbox10" value="checkbox" disabled="disabled" <?php if($list[9]==1){echo ' checked="checked"';}?>/></td>
    <td><input type="checkbox" name="checkbox27" value="checkbox" disabled="disabled" <?php if($list[9]==0){echo ' checked="checked"';}?>/></td>
  </tr>
  <tr>
    <td colspan="3" height="30">11. Cukur pada daerah dada kiri dan kanan untuk tindakan PPM</td>
    <td><input type="checkbox" name="checkbox11" value="checkbox" disabled="disabled" <?php if($list[10]==1){echo ' checked="checked"';}?>/></td>
    <td><input type="checkbox" name="checkbox28" value="checkbox" disabled="disabled" <?php if($list[10]==0){echo ' checked="checked"';}?>/></td>
  </tr>
  <tr>
    <td colspan="3" height="30">12. Daftarkan pasien pada petugas Cath-Lab/ ICCU dengan__</td>
    <td><input type="checkbox" name="checkbox12" value="checkbox" disabled="disabled" <?php if($list[11]==1){echo ' checked="checked"';}?>/></td>
    <td><input type="checkbox" name="checkbox29" value="checkbox" disabled="disabled" <?php if($list[11]==0){echo ' checked="checked"';}?>/></td>
  </tr>
  <tr>
    <td colspan="3" height="30">13. Pasien diturunkan sudah memakai baju tindakan</td>
    <td><input type="checkbox" name="checkbox13" value="checkbox" disabled="disabled" <?php if($list[12]==1){echo ' checked="checked"';}?>/></td>
    <td><input type="checkbox" name="checkbox30" value="checkbox" disabled="disabled" <?php if($list[12]==0){echo ' checked="checked"';}?>/></td>
  </tr>
  <tr>
    <td colspan="3" height="30">14. Sebelum diturunkan ke ruang cath lab, beritahu pasien untuk BAB atau BAK</td>
    <td><input type="checkbox" name="checkbox14" value="checkbox" disabled="disabled" <?php if($list[13]==1){echo ' checked="checked"';}?>/></td>
    <td><input type="checkbox" name="checkbox31" value="checkbox" disabled="disabled" <?php if($list[13]==0){echo ' checked="checked"';}?>/></td>
  </tr>
  <tr>
    <td colspan="3" height="30">15. File baru atau lama dan hasil penunjang lainnya disertakan</td>
    <td><input type="checkbox" name="checkbox15" value="checkbox" disabled="disabled" <?php if($list[14]==1){echo ' checked="checked"';}?>/></td>
    <td><input type="checkbox" name="checkbox32" value="checkbox" disabled="disabled" <?php if($list[14]==0){echo ' checked="checked"';}?>/></td>
  </tr>
  <tr>
    <td colspan="3" height="30">16. Pastikan  pasien tidak sedang menstruasi, bila ya konfirmasi ke dokter operator.</td>
    <td><input type="checkbox" name="checkbox16" value="checkbox" disabled="disabled" <?php if($list[15]==1){echo ' checked="checked"';}?>/></td>
    <td><input type="checkbox" name="checkbox33" value="checkbox" disabled="disabled" <?php if($list[15]==0){echo ' checked="checked"';}?>/></td>
  </tr>
  <tr>
    <td colspan="3" height="30">17. Tanyakan riwayat alergi.</td>
    <td><input type="checkbox" name="checkbox17" value="checkbox" disabled="disabled" <?php if($list[16]==1){echo ' checked="checked"';}?>/></td>
    <td><input type="checkbox" name="checkbox34" value="checkbox" disabled="disabled" <?php if($list[16]==0){echo ' checked="checked"';}?>/></td>
  </tr>
  <tr>
    <td colspan="3" height="30">18. Obat-obatan yang diberikan diruangan :</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" height="30"><?=$dt['obat'];?></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">Medan,&nbsp;<?=tgl_ina(date("Y-m-d"));?></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">Yang Menyerahkan </td>
    <td colspan="2" align="center">Yang Menerima </td>
  </tr>
  <tr>
    <td height="97" colspan="3" valign="bottom"><strong>(<u><?=$usr['nama']?></u>)</strong></td>
    <td colspan="2" align="center" valign="bottom">(_______________)</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">Note : untuk tindakan PPM,pasien dipasang kateter/kondom </td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<br />
<table width="714" border="0">
  <tr id="trTombol">
    <td width="708" align="center">
	<input type="submit" name="button" id="button" value="Cetak" onclick="cetak(document.getElementById('trTombol'));" />
   									<input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
	</td>
  </tr>
</table>
</body>
</html>
<script>
    function cetak(tombol){
        tombol.style.visibility='collapse';
        if(tombol.style.visibility=='collapse'){
            if(confirm('Anda yakin mau mencetak ?')){
                /*setTimeout('window.print()','1000');
                setTimeout('window.close()','2000');*/
				window.print();
                window.close();
            }
            else{
                tombol.style.visibility='visible';
            }

        }
    }

</script>