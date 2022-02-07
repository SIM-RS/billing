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
mp.nama nmPas,
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
<style>
	table td{
		font-size:22px;
	}
</style>
<table width="100%" id="tabelview" border="0" style="border-collapse:collapse; font:14px tahoma black;" cellspacing="0" cellpadding="0">
<tbody>
  <tr>
  	<td>&nbsp;</td>
    <td width="81%">&nbsp;</td>
  </tr>
  <tr style="visibility:hidden">
    <td width="19%">&nbsp;</td>
    <td>
    <table width="100%">
      <tr>
        <td align="center" style="font:24px tahoma black;"><strong>RADIOLOGI RUMAH SAKIT PELINDO I<br/>
          KOTA MEDAN</strong></td>
      </tr>
      <tr>
        <td align="center">JL.Stasiun, 92, Belawan - Kota Medan<br/>
          Telp.: 021 5997 0200 - 59997 0201, Fax : 021 5997 0202<br/></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
  	<td colspan="2">
    <table cellpadding="0" cellspacing="0">
    
    </table>
    </td>
  </tr>
  <tr>
  <td height="100"></td>
  </tr>
  <tr>
    <td colspan="2">
    <table width="100%">
    	<tr>
			<td width="25%">No. RM</td>
            <td width="1%">:</td>
            <td width="30%"><?php echo $rw['no_rm']?></td>
			<td width="20%">RUANGAN</td>
            <td width="1%">:</td>
            <td id="nmUnit2"><?php echo $rw['nmUnit']?></td>
    	</tr>
	 	<tr>
	 		<td>NAMA / JENIS KELAMIN</td>
            <td width="1%">:</td>
            <td><?php echo $rw['nmPas'].' / '.(strtolower($rw['sex'])=='l'?'L':'P');?></td>
			<td>TANGGAL</td>
            <td width="1%">:</td>
            <td id="tgljam2"><?php echo $rw['tgljam']?></td>
    	</tr>
		<tr>
	 		<td>UMUR</td>
            <td width="1%">:</td>
            <td style="text-transform:uppercase"><?php echo $rw['th'].' tahun '.$rw['bl'].' bulan';?></td>
            <td>PENJAMIN</td>
            <td>:</td>
            <td><?php echo $rw['nmKso']; ?></td>
    	</tr>
		<tr>
	 		<td>PENGIRIM</td>
            <td width="1%">:</td>
            <td id="pengirim"><?php echo $rw['pengirim'];?></td>
    	</tr>
		<tr>
	 		<td valign="top">DIAGNOSA</td>
            <td width="1%" valign="top">:</td>
            <td id="ket"><?php echo $rw['ket'];?></td>
    	</tr>
	</table></td>
	<tr><td colspan="2"><table width="100%">
	<tr><td>&nbsp;<br/></td></tr>
	<tr><td><?php echo 'Ts. Yth. '.$rw['pengirim'] ?></td></tr>
	<tr><td>&nbsp;<br/>&nbsp;<br/></td></tr>
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
	<tr><td id="hasilRad"><?php echo $dt['hasil']?></td></tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
	<tr><td>&nbsp;<br/>Salam sejawat,<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/><span id="nmDokter"><?php echo $dt['nama']?></span></td></tr>
	</table></td></tr>
  </tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr id="trTombol">
                <td height="24" colspan="3" align="center" valign="top" class="noline">
            
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <!--input id="btnExpExcl" type="button" value="Export > Excell" onClick="window.location = '?idKunj=<?php echo $idKunj; ?>&idPel=<?php echo $idPel; ?>&excel=yes';"/-->
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>                
            
                </td>
            </tr>
            </tbody>
            <tfoot>
            	<tr>
      				<td colspan="2" style="font-style:italic">Tgl / waktu hasil baca dokter : <span id="bacaTgl"><?php echo $dt['tgl_baca']; ?></span></td>
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
        }

    }
}
</script>