<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
include '../koneksi/konek.php';
$idPel=( $_REQUEST['idPel'] !="" && isset($_REQUEST['idPel']) ? $_REQUEST['idPel'] : "0" );
$idKunj=($_REQUEST['idKunj']!="" && isset($_REQUEST['idKunj']) ? $_REQUEST['idKunj'] : "0" );
$id_hasil_rad=$_REQUEST['id_hasil_rad'];

$sqlPas="SELECT 
no_rm,
lcase(mp.nama) nmPas,
mp.alamat, 
mp.rt,
mp.rw,
mp.sex,
mk.nama kelas,
GROUP_CONCAT(DISTINCT md.nama) as diag,
peg.nama as dokter,
kso.nama nmKso,
DATE_FORMAT(p.tgl,'%d-%m-%Y') tgljam, 
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
WHERE p.id='$idPel'";

$rs1 = mysql_query($sqlPas);
mysql_error();
$rw = mysql_fetch_array($rs1);

$sql = "select unit_id from b_pelayanan where id = {$idPel}";
$radCek = mysql_fetch_object(mysql_query($sql));
$rad = $radCek->unit_id;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Rincian Hasil Radiologi :.</title>
<script type="text/javascript" src="../theme/jquery-ui/js/jquery-1.8.3.js"></script>
<script type="text/javascript">
	$(function(){
		var radcek = <?php echo $rad; ?>;
		//alert('hasil_radiologi_utils.php?idPel='+$('#idPelRad').val());
		if(radcek == 61){
			$('#HslRad').load('hasil_radiologi_utils.php?par=cekH&idPel=<?php echo $idPel; ?>');
		} else {
			$('#HslRad').load('hasil_radiologi_utils.php?par=cekH&idPel='+$('#idPelRad').val());
		}
		//$('#coba').load('hasil_radiologi_utils.php?idPel='+$('#idPelRad').val());
	});
	function getHasil(par){
		$('#HslRad').load('hasil_radiologi_utils.php?par=cekH&idPel='+par);
	}
	
	function setHasil(){
		var radcek = <?php echo $rad; ?>;
		var idRad = $('#HslRad').val();
		var idPely = $('#idPelRad').val();
		$('#tabelview').css('display','block');
		$('#hasilRad').load('hasil_radiologi_utils.php?par=getH&idHRad='+idRad);
		$('#bacaTgl').load('hasil_radiologi_utils.php?par=getTgl&idHRad='+idRad);
		if(radcek == 61){
			$('#code').load('hasil_radiologi_utils.php?par=getKetPeng&idPel=<?php echo $idPel; ?>');
		} else {
			$('#code').load('hasil_radiologi_utils.php?par=getKetPeng&idPel='+idPely);
		}
		return false;
	}
</script>
<style type="text/css">
	#tabelview{
		display:none;
	}
	#tabelview td{
		font-size:16px;
		text-transform:capitalize;
	}
</style>
<style type="text/css" media="print,screen" >
thead {
    display:table-header-group;
}
tbody {
    display:table-row-group;
}
</style>
</head>

<body>
<?php
	if($rad!=61){
		//echo $sql = "SELECT id, DATE_FORMAT(tgl_act,'%d-%m-%Y %H:%i:%s') tgl FROM b_pelayanan WHERE kunjungan_id = {$idKunj} AND unit_id = 61";
		$sql = "SELECT id, DATE_FORMAT(tgl_act,'%d-%m-%Y / %H:%i') tgl FROM b_pelayanan WHERE kunjungan_id = {$idKunj} AND unit_id = 61";
		$query = mysql_query($sql);
?>
	<select name="idPelRad" id="idPelRad" onchange="getHasil(this.value)">
		<?php
		while($radH = mysql_fetch_object($query)){
			echo "<option value='".$radH->id."'>Radiologi [".$radH->tgl."]</option>";
		}
		?>
	</select>
<?php
	}
?>
	<select name="HslRad" id="HslRad" style="min-width:100px" ></select>
	<button name="btnView" id="btnView" onclick="setHasil()">Lihat</button>
<table width="100%" id="tabelview" border="0" style="border-collapse:collapse; font:16px tahoma black;" cellspacing="0" cellpadding="0">
	<thead>
	  <tr>
		<th colspan="6" height="128">&nbsp;</th>
	  </tr>
	</thead>
	<tbody>
		<tr>
			<td width="25%">No. RM</td>
            <td width="1%">:</td>
            <td width="30%" style="text-transform:capitalize;"><?php echo $rw['no_rm']?></td>
			<td width="20%" style="text-transform:capitalize;">Ruangan</td>
            <td width="1%">:</td>
            <td style="text-transform:capitalize;"><?php echo strtolower($rw['nmUnit']);?></td>
    	</tr>
	 	<tr>
	 		<td style="text-transform:capitalize;">Nama / Jenis Kelamin</td>
            <td width="1%">:</td>
            <td style="text-transform:capitalize;"><?php echo strtolower($rw['nmPas'].' / '.(strtolower($rw['sex'])=='l'?'L':'P'));?></td>
			<td style="text-transform:capitalize;">Tanggal</td>
            <td width="1%">:</td>
            <td style="text-transform:capitalize;"><?php echo $rw['tgljam']?></td>
    	</tr>
		<tr>
	 		<td style="text-transform:capitalize;">Umur</td>
            <td width="1%">:</td>
            <td style="text-transform:capitalize"><?php echo $rw['th'].' tahun '.$rw['bl'].' bulan';?></td>
            <td style="text-transform:capitalize;">Penjamin</td>
            <td>:</td>
            <td style="text-transform:capitalize;"><?php echo strtolower($rw['nmKso']); ?></td>
    	</tr>
		<tr>
	 		<td style="text-transform:capitalize;">Pengirim</td>
            <td width="1%">:</td>
            <td style="text-transform:capitalize;"><?php echo strtolower($rw['pengirim']);?></td>
			<td colspan="3"></td>
    	</tr>
		<tr>
	 		<td valign="top" style="text-transform:capitalize;">Diagnosa</td>
            <td width="1%" valign="top">:</td>
            <td style="text-transform:capitalize;"><?php echo $rw['ket'];?></td>
			<td colspan="3"></td>
    	</tr>
		<tr><td colspan="6">
			<br />
			<?php echo 'Ts. Yth. '.strtolower($rw['pengirim']) ?>
			<br /><br />
			<?php
						$sql ="SELECT 
						hr.*,
						mp.nama,
						DATE_FORMAT(hr.tgl_act,'%d-%m-%Y / %H:%i') as tgl_baca 
						from b_hasil_rad hr 
						left JOIN b_ms_pegawai mp 
					ON mp.id = hr.user_id 
					INNER JOIN b_pelayanan p ON hr.pelayanan_id=p.id
					WHERE hr.id = '".$id_hasil_rad."'";

						//echo $sql;
						$rs=mysql_query($sql);
						$dt = mysql_fetch_array($rs);
			?>
			<br />
			<span id="hasilRad"><?php echo $dt['hasil']?></span>
			<br />
			<br/>Salam sejawat,<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/><span id="nmDokter"><?php echo strtolower($dt['nama'])?></span>
		</td></tr>
 
		<tr><td colspan="6">&nbsp;</td></tr>
		<tr><td colspan="6">&nbsp;</td></tr>
		<tr id="trTombol">
			<td height="24" colspan="6" align="center" valign="top" class="noline">
		<input type="hidden" id="normpacs" name="normpacs" value="" />
		<input type="hidden" id="idpacs" name="idpacs" value="" />
		<input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
		<input id="viewPacs" type="button" value="View Hasil Pacs" onClick="viewHasil(normpacs.value,idpacs.value);"/>
		<!--input id="btnExpExcl" type="button" value="Export > Excell" onClick="window.location = '?idKunj=<?php echo $idKunj; ?>&idPel=<?php echo $idPel; ?>&excel=yes';"/-->
		<input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>                
		
			</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="6" style="font-style:italic">Tgl / waktu hasil baca dokter : <span id="bacaTgl"><?php echo $dt['tgl_baca']; ?></span></td>
		</tr>
	</tfoot>
</table>
<div id="code"></div>
</body>
</html>
<script type="text/JavaScript">
function cetak(tombol){
    tombol.style.visibility='collapse';
	$('#HslRad').css('visibility','collapse');
	$('#btnView').css('visibility','collapse');
	$('#idPelRad').css('visibility','collapse');
	$('#viewPacs').css('visibility','collapse');
    if(tombol.style.visibility=='collapse'){
        if(confirm('Anda Yakin Mau Mencetak Hasil Pemeriksaan ?')){
            setTimeout('window.print()','1000');
            setTimeout('window.close()','2000');
        }
        else{
            tombol.style.visibility='visible';
			$('#HslRad').css('visibility','visible');
			$('#btnView').css('visibility','visible');
			$('#idPelRad').css('visibility','visible');
			$('#viewPacs').css('visibility','visible');
        }

    }
}

function viewHasil(norm,idpacs){
	var url = "<?php echo $base_addr_pacs; ?>"+norm+'/'+idpacs+'/preview.html';
	var h = "700";
	var w = "1010";
	var LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	var TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	if(idpacs != ""){
		window.open(url,'','height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',titlebar=no,toolbar=no,location=no,status=no,menubar=no,resizable');
	} else {
		alert('Hasil Radiologi Tidak Memiliki Hasil Pacs!');
	}
}
</script>