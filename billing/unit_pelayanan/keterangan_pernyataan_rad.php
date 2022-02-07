<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
include '../koneksi/konek.php';
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
$jam = date("G:i");

$idPel=( $_REQUEST['idPel'] !="" && isset($_REQUEST['idPel']) ? $_REQUEST['idPel'] : "0" );
$idKunj=($_REQUEST['idKunj']!="" && isset($_REQUEST['idKunj']) ? $_REQUEST['idKunj'] : "0" );

$arrHr = array('0'=>'Minggu','1'=>'Senin', '2'=>'Selasa', '3'=>'Rabu', '4'=>'Kamis', '5'=>'Jumat', '6'=>'Sabtu');

$sqlPas="SELECT 
no_rm,
mp.nama nmPas,
mp.sex,
GROUP_CONCAT(DISTINCT md.nama) as diag,
concat(date_format(p.tgl,'%w')) hari,
CONCAT(DATE_FORMAT(p.tgl,'%d-%m-%Y')) tgljam,
DATE_FORMAT(mp.tgl_lahir,'%d-%m-%Y') tglL,
k.umur_thn th,
k.umur_bln bl,
p.ket
FROM b_kunjungan k 
INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id 
INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
LEFT JOIN b_ms_kelas mk ON k.kso_kelas_id=mk.id 
INNER JOIN b_ms_kso kso ON k.kso_id=kso.id
left join b_ms_unit un on un.id=p.unit_id_asal
left join b_diagnosa diag on diag.pelayanan_id=p.id
left join b_ms_diagnosa md on md.id = diag.ms_diagnosa_id
left join b_ms_pegawai peg on peg.id = diag.user_id
WHERE p.id='$idPel'";
//echo $sqlPas."<br>";
$rs1 = mysql_query($sqlPas);
//echo mysql_error();
$rw = mysql_fetch_array($rs1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Keterangan Pernyataan</title>
<style>
	.kotak{ border:1px solid #000000;
	}
</style>
</head>
<body>
<table width="100%" border="0" style="font:14px tahoma black; border-collapse:collapse;" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%"><tr><td width="30%">Hari / Tanggal</td><td width="1%">:</td><td><?php echo $arrHr[$rw['hari']].' / '.$rw['tgljam']?></td></tr>
	<tr><td width="30%">Nama Lengkap</td><td width="1%">:</td><td><?php echo $rw['nmPas']?></td></tr>
	<tr><td width="30%">Tanggal Lahir / Umur</td><td width="1%">:</td><td><?php echo  $rw['tglL'].' / '.$rw['th'].' thn '.$rw['bl'].' bln';?></td></tr>
	<tr><td width="30%">No. RM</td><td width="1%">:</td><td><?php echo $rw['no_rm']?></td></tr>
	<tr><td width="30%">Diagnosa Pemeriksaan Radiologi</td><td width="1%">:</td><td><?php echo $rw['ket']?></td></tr>
	<tr><td width="30%">Pemeriksaan Radiologi</td><td width="1%">:</td><td>&nbsp;</td></tr>
	<?php
	$rad="SELECT mkt.nama AS namakelompok, mt.nama AS tindakan 
		FROM
		  b_tindakan_rad t 
		  INNER JOIN b_ms_tindakan mt 
			ON mt.id = t.pemeriksaan_id 
		  INNER JOIN b_ms_kelompok_tindakan mkt 
			ON mkt.id = mt.kel_tindakan_id
		WHERE t.pelayanan_id='$idPel' AND klasifikasi_id = 6";
	$queryRad = mysql_query($rad);
	while ($rd = mysql_fetch_array($queryRad)){
	$i++;
	?>
	<tr><td colspan="2"></td><td><?php echo $i.'. '.$rd['tindakan']; ?></td></tr>
	<?php }?>
	</table></td>
  </tr>
  <tr><td>&nbsp;</td></tr>
  <tr>
  <td><strong>Keterangan Pernyataan diisi oleh Pasien/Keluarga</strong></td>
  </tr>
  <tr><td>Dengan ini saya menyatakan bahwa :</td></tr>
  <tr>
  	<td><table width="100%"><tr><td width="5%">1. </td><td width="5%" class="kotak"></td><td>Saya telah diberikan penjelasan tentang pemeriksaan yang akan dilakukan</td></tr>
	<tr><td width="5%">2. </td><td width="5%" class="kotak"></td><td>Saya telah diberikan injeksi bahan kontras :</td></tr>
	<tr><td width="5%">3. </td><td width="5%" class="kotak"></td><td>Saya dalam keadaan tidak hamil (untuk wanita usia 15-50 tahun)</td></tr>
	<tr><td width="5%">4. </td><td width="5%" class="kotak"></td><td>Saya dalam keadaan hamil dan sudah diberikan penjelasan tentang resiko dan</td></tr>
	<tr><td colspan="2"></td><td>efek samping tindakan radiologi (untuk wanita usia 15-50 tahun)</td></tr>
  		</table>
  	</td>
  </tr>
  <tr><td><u>Petunjuk</u> : beri tanda silang pada kotak di atas yang dipilih</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr>
  <td><table width="100%"><tr><td width="30%" align="center">Medan,<?php echo $date_now;?></td><td></td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr align="center"><td>(<?php echo $rw['nmPas']?>)</td>
	<td></td></tr>
  		</table>
  	</td>	
  </tr>
  <tr>
  	<td>&nbsp;</td>
  </tr>
  <tr id="trTombol">
                <td height="24" colspan="3" align="center" valign="top" class="noline">
            
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <!--input id="btnExpExcl" type="button" value="Export > Excell" onClick="window.location = '?idKunj=<?php echo $idKunj; ?>&idPel=<?php echo $idPel; ?>&excel=yes';"/-->
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
                </td>
            </tr>
</table>
</body>
</html>
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