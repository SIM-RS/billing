<?php
session_start();
include("../sesi.php");
//session_start();
include '../koneksi/konek.php';
$idPel=$_REQUEST['idPel'];
$idKunj=$_REQUEST['idKunj'];
$que="SELECT 
no_rm,
mp.nama nmPas,
mp.alamat, 
mp.rt,
mp.rw,
mp.sex,
mk.nama kelas,
GROUP_CONCAT(DISTINCT md.nama) as diag,
peg.nama as dokter,
kso.nama nmKso,
DATE_FORMAT(p.tgl,'%d %M %Y') tgljam, 
DATE_FORMAT(IFNULL(p.tgl_krs,NOW()),'%d-%m-%Y %H:%i') tglP, 
mp.desa_id,
mp.kec_id, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.kec_id) nmKec, 
(SELECT nama FROM b_ms_wilayah WHERE id=mp.desa_id) nmDesa, 
k.kso_id,
k.kso_kelas_id,
p.kelas_id,
un.nama nmUnit,
k.umur_thn th,
k.umur_bln bl,
peng.nama as pengirim,
p.ket
FROM b_kunjungan k 
INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id 
INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id
LEFT JOIN b_ms_kelas mk ON k.kso_kelas_id=mk.id 
INNER JOIN b_ms_kso kso ON k.kso_id=kso.id
left join b_ms_unit un on un.id=p.unit_id_asal
LEFT join b_diagnosa diag on diag.pelayanan_id=p.id
left join b_ms_diagnosa md on md.id = diag.ms_diagnosa_id
LEFT join b_ms_pegawai peg on peg.id = diag.user_id
left join b_ms_pegawai peng on peng.id = p.dokter_id
WHERE p.id='".$idPel."'";
$isi=mysql_fetch_array(mysql_query($que));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title> .: Radiologi :. </title>
<style type="text/css">
  .kotak {
    border-radius: 30px 30px 30px 30px;
	-moz-border-radius: 30px 30px 30px 30px; 
	-webkit-border-radius: 30px 30px 30px 30px; 
	border: 2px solid #000000;
	padding:10px;
	font:bold;
	}
</style>
</head>
<body>
<table width="400" height="200" border="0" style="font:12px Times New Roman black">
<tr>
	<td>
    <div class="kotak">
	<table width="100%" height="100%" border="0" style="border-collapse:collapse" >
	<tr>
		<td width="40%">No. RM</td><td width="1%">:</td><td>&nbsp;<?=$isi['no_rm']?></td>
	</tr>
	<tr>
		<td>NAMA</td><td>:</td><td>&nbsp;<?=$isi['nmPas']." (".$isi['sex'].")"?></td>
	</tr>
	<tr>
		<td>UMUR</td><td>:</td><td>&nbsp;<?=$isi['th']." tahun ".$isi['bl']." bulan"?></td>
	</tr>
	<tr>
		<td>TGL PEMERIKSAAN</td><td>:</td><td>&nbsp;<?=$isi['tgljam']?></td>
	</tr>
	<tr>
		<td>Dr. PENGIRIM</td><td>:</td><td>&nbsp;<?=$isi['pengirim']?></td>
	</tr>
	<tr>
		<td>RUANGAN</td><td>:</td><td>&nbsp;<?=$isi['nmUnit']?></td>
	</tr>
	<tr>
		<td valign="top">PEMERIKSAAN</td><td valign="top">:</td><td><table>
        <?php
        $sql="SELECT DISTINCT tin.nama FROM b_tindakan t
		INNER JOIN b_pelayanan pl ON pl.id = t.pelayanan_id
		INNER JOIN b_ms_tindakan_kelas tk ON tk.id = t.ms_tindakan_kelas_id
		INNER JOIN b_ms_kelas k ON tk.ms_kelas_id=k.id
		INNER JOIN b_ms_tindakan tin ON tin.id = tk.ms_tindakan_id 
		WHERE t.pelayanan_id = '".$idPel."';";
		$isi=mysql_query($sql);
		$i=1;
		while($data=mysql_fetch_array($isi)){
		?>
        <tr>
        <td><?php echo $i.". ".$data['nama'];?>&nbsp;</td>
        </tr>
        <?php $i++;}?>
        </table></td>
	</tr>
	</table></div>
	</td>
</tr>
<tr id="trTombol">
                <td height="24" align="center" valign="top" class="noline">
            
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
