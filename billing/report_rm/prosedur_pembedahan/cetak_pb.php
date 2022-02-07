<?php
	include('../../koneksi/konek.php');
	$idKunj=$_REQUEST['idKunj'];
	$idPel=$_REQUEST['idPel'];
	$idUser = $_REQUEST['idUser'];
	$idBedah = $_REQUEST['idBedah'];
	
	function tanggal($a){
		if($a != ''){
			$tglA = explode('-',$a);
			$tglH = $tglA[2].'-'.$tglA[1].'-'.$tglA[0];
		}
		return $tglH;
	}
	
	function adaTidak($b){
		if($b == '1'){
			$result = '<b>Ada</b> / <strike>Tidak Ada</strike>';
		} else {
			$result = '<strike>Ada</strike> / <b>Tidak Ada</b>';
		}
		return $result;
	}
	
	$sqluser = "SELECT nama FROM b_ms_pegawai WHERE `id` = '$idUser'";
	$isiuser = mysql_fetch_array(mysql_query($sqluser));
	$namaUser = $isiuser['nama'];
	
	$sqlBedah = "select * from b_form_prosedur_bedah where idBedah = '$idBedah'";
	//echo $sqlBedah;
	$data = mysql_fetch_array(mysql_query($sqlBedah));
	$jOperasi = explode('|',$data['JenisOperasi']);
	$jenis1 = ($jOperasi[0] == 1)?"(<b>Bersih</b> / <strike>Kotor</strike>)":"(<strike>Bersih</strike> / <b>Kotor</b>)";
	$jenis2 = ($jOperasi[1] == 1)?"(<b>Besar</b> / <strike>Kecil</strike>)":"(<strike>Besar</strike> / <b>Kecil</b>)";
	$PreOperasi = ($data['PreOperasi'] == 1)?"<b>Cukur</b> / <strike>Tidak Cukur</strike>":"<strike>Cukur</strike> / <b>Tidak Cukur</b>";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prosedur pembedahan</title>
</head>

<body>
<table width="800" border="0" style="font:12px tahoma;">
  <tr>
    <td style="font:bold 16px tahoma;"><div align="center">PROSEDUR PEMBEDAHAN</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table cellspacing="2" cellpadding="2" style="border:1px solid #000000;">
      <col width="27" />
      <col width="35" />
      <col width="22" />
      <col width="31" />
      <col width="138" />
      <col width="20" />
      <col width="34" />
      <col width="58" />
      <col width="99" />
      <col width="13" />
      <col width="92" />
      <col width="49" />
      <col width="30" />
      <col width="80" />
      <col width="37" />
      <tr height="21">
        <td height="21" width="27">&nbsp;</td>
        <td width="35"></td>
        <td width="22"></td>
        <td width="31"></td>
        <td width="138"></td>
        <td width="20"></td>
        <td width="34"></td>
        <td width="58"></td>
        <td width="99"></td>
        <td width="13"></td>
        <td width="92"></td>
        <td width="49"></td>
        <td width="30"></td>
        <td width="80"></td>
        <td width="37"></td>
      </tr>
      <tr height="20">
        <td height="20" align="right">1</td>
        <td colspan="2">Operasi</td>
        <td></td>
        <td>: <?=$data['operasi']?></td>
        <td>tgl.</td>
        <td colspan="2"><?=tanggal($data['tglOperasi'])?></td>
        <td colspan="5">Jenis operasi <?=$jenis1?>    <?=$jenis2?></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20" align="right">2</td>
        <td colspan="3">Pre Operasi</td>
        <td colspan="2">: <?=$PreOperasi?></td>
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
      <tr height="20">
        <td height="20" align="right">3</td>
        <td colspan="3">Lama Operasi</td>
        <td>: <?=$data['LamaOperasi']?> Jam</td>
        <td colspan="2"></td>
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
        <td></td>
      </tr>

      <tr height="20">
        <td height="20" colspan="15"><table cellspacing="0" cellpadding="0" border="1" style="border-collapse:collapse;border:1px solid #000000;">
          <col width="27" />
          <col width="35" />
          <col width="22" />
          <col width="31" />
          <col width="138" />
          <col width="20" />
          <col width="34" />
          <col width="58" />
          <col width="99" />
          <col width="13" />
          <col width="92" />
          <col width="49" />
          <col width="30" />
          <col width="80" />
          <col width="37" />
          <tr height="20">
            <td colspan="4" height="26" width="115"><div align="center">TANGGAL</div></td>
            <td colspan="4" width="250"><div align="center">GANTI BALUTAN</div></td>
            <td colspan="3" width="204"><div align="center">KETERANGAN</div></td>
            <td colspan="4" width="196"><div align="center">NAMA JELAS</div></td>
          </tr>
		<?php
			$sqlBalutan = "select idSubBedah, DATE_FORMAT(tglBalutan,'%d-%m-%Y') as tanggal, balutan, keterangan, namaJelas, idBedah
								from b_form_sub_prosedur_bedah
								where idBedah = $idBedah";
			$queryBalutan = mysql_query($sqlBalutan);
			while($dataB = mysql_fetch_array($queryBalutan)){
		?>
			<tr height="20">
				<td colspan="4" style="text-align:center;"><?=$dataB['tanggal']?></td>
				<td colspan="4" style="padding:5px;"><?=$dataB['balutan']?></td>
				<td colspan="3" style="padding:5px;"><?=$dataB['keterangan']?></td>
				<td colspan="4" style="padding:5px;"><?=$dataB['namaJelas']?></td>
            </tr>
        <?php
			}
			
			$ILO = explode('|',$data['ILO']);
			$ISK = explode('|',$data['ISK']);
			$ILI = explode('|',$data['ILI']);
			$VAP = explode('|',$data['VAP']);
			$bakteri = explode('|',$data['Bakteri']);
			$bitus = explode('|',$data['Dekubitus']);
		?>
        </table></td>
        </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="4">Komplikasi dan infeksi Nosokamial</td>
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
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td align="right">1</td>
        <td colspan="2">ILO</td>
        <td></td>
        <td>:</td>
        <td colspan="3"><?=adaTidak($ILO[0])?> Hari ke : <?=$ILO[1]?></td>
        <td></td>
        <td colspan="5">Tanggal hasil kultur : <?=tanggal($ILO[2])?></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td align="right">2</td>
        <td colspan="2">ISK</td>
        <td></td>
        <td>:</td>
        <td colspan="3"><?=adaTidak($ISK[0])?> Hari ke : <?=$ISK[1]?></td>
        <td></td>
        <td colspan="5">Tanggal hasil kultur : <?=tanggal($ISK[2])?></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td align="right">3</td>
        <td>ILI</td>
        <td></td>
        <td></td>
        <td>:</td>
         <td colspan="3"><?=adaTidak($ILI[0])?> Hari ke : <?=$ILI[1]?></td>
        <td></td>
        <td colspan="5">Tanggal hasil kultur : <?=tanggal($ILI[2])?></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td align="right">4</td>
        <td colspan="2">VAP</td>
        <td></td>
        <td>:</td>
         <td colspan="3"><?=adaTidak($VAP[0])?> Hari ke : <?=$VAP[1]?></td>
        <td></td>
        <td colspan="5">Tanggal hasil kultur : <?=tanggal($VAP[2])?></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td align="right">5</td>
        <td colspan="3">Bakterinia / sepsis</td>
        <td>:</td>
         <td colspan="3"><?=adaTidak($bakteri[0])?> Hari ke : <?=$bakteri[1]?></td>
        <td></td>
        <td colspan="5">Tanggal hasil kultur : <?=tanggal($bakteri[2])?></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td align="right">6</td>
        <td colspan="3">Dekeubitus</td>
        <td>:</td>
         <td colspan="3"><?=adaTidak($bitus[0])?> Hari ke : <?=$bitus[1]?></td>
        <td></td>
        <td colspan="5">Tanggal hasil kultur : <?=tanggal($bitus[2])?></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20" colspan="5">Perawat    yang bertanggung jawab</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Mengetahui,</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2">Kepala Ruangan</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20" colspan="5">( <u style="font-weight:bold;"><?=$namaUser?></u> )</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td colspan="3">(&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;&hellip;)</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
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
        <td></td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
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
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table cellspacing="0" cellpadding="0">
      <col width="27" />
      <col width="35" />
      <col width="22" />
      <col width="31" />
      <col width="138" />
      <col width="20" />
      <col width="34" />
      <col width="58" />
      <col width="99" />
      <col width="13" />
      <col width="92" />
      <tr height="20">
        <td height="20" colspan="2" width="62"><strong>Catatan</strong></td>
        <td width="22"></td>
        <td width="31"></td>
        <td width="138"></td>
        <td width="20"></td>
        <td width="34"></td>
        <td width="58"></td>
        <td width="99"></td>
        <td width="13"></td>
        <td width="92"></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td colspan="8">Dimasukan pada setiap dokumen medik    pasien (medical record)</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td colspan="8">Diisi oleh perawat yang bertanggung    jawab pada pasien tersebut</td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td colspan="7">Diperiksa oleh perawat pengendali    infeksi setiap hari</td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr height="20">
        <td height="20"></td>
        <td colspan="10">Setelah pasien pulang, formulir    dikirim kebidang PPI RS PELINDO I</td>
      </tr>
    </table></td>
  </tr>
  <tr>
  <td align="center">
  <input type="button" onclick="this.style.display = 'none'; window.print();" value="Cetak" id="bt_cetak" name="bt_cetak">
  </td>
  </tr>
</table>
</body>
</html>
