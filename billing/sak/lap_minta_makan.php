<?php
session_start();
$userIdAskep=$_SESSION['userIdAskep'];
include("../koneksi/konek.php");
//====================================================================
$unitId = $_REQUEST["unit_id"];
$tgl = tglSQL($_REQUEST["tgl"]);
$tanggal = $_REQUEST["tgl"];
$IdPel = $_REQUEST["id_pelayanan"];
$sqlPel = mysql_query("SELECT mu.id,mu.nama,mu.kode FROM $dbbilling.b_ms_unit mu WHERE id = '$IdPel'");
$rwPel = mysql_fetch_array($sqlPel);
$IdKmr = $_REQUEST["id_kamar"];
$sqlKmr = mysql_query("SELECT mu.id,mu.nama,mu.kode FROM $dbbilling.b_ms_unit mu WHERE id = '$IdKmr'");
$rwKmr = mysql_fetch_array($sqlKmr);
//====================================================================
if($_GET['export']==1)
{
header("Content-type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="Laporan Permintaan Makanan Pasien.xls"');
}
?>
<style>
	.tbl{
		font-family:Tahoma; 
		font-size:12px;
	}
	.jdlno{
		font-size:20px;
		text-transform:uppercase;
		font-weight:bold;
		height:30px;
		text-decoration:underline;
		text-align:center;
	}
	.jdlsub{
		font-size:12px;
		text-transform:uppercase;
		text-align:left;
	}
	.kiri{
		 border-bottom:1px solid #000000;
		 border-left:1px solid #000000;
		 padding-left:5px;
	}
	.kanan{
		 border-bottom:1px solid #000000; 
		 border-left:1px solid #000000;
		 border-right:1px solid #000000;
		 padding-left:5px;
	}
	.jdkiri{
		 border-bottom:1px solid #000000; 
		 border-top:1px solid #000000;
		 border-left:1px solid #000000;
	}
	.jdbwh{
		border-bottom:1px solid #000000;
		border-left:1px solid #000000;
	}
	.jdbwhkanan{
		border-bottom:1px solid #000000;
		border-left:1px solid #000000;
		border-right:1px solid #000000;
	}
	.jdkanan{
		 border-bottom:1px solid #000000; 
		 border-top:1px solid #000000;
		 border-left:1px solid #000000;
		 border-right:1px solid #000000;
	}
	@media print {
		#noprint {
			display:none;
		}
	}
</style>
<title>Laporan Permintaan Makan Pasien</title>
<table class="tbl" align="center" border="0" cellpadding="0"cellspacing="0" width="1000">
<tr>
	<td class="jdlno" align="center" colspan="3" height="50">LAPORAN PERMINTAAN MAKAN PASIEN<br /></td>
</tr>
<tr>
	<td class="jdlsub" width="15%">Tanggal</td>
	<td class="jdlsub">: <?php echo $tanggal ?></td>
	<td width="50%">&nbsp;</td>
</tr>
<tr>
	<td class="jdlsub">Jenis Layanan</td>
	<td class="jdlsub">: <?php echo $rwPel['nama'] ?></td>
	<td width="50%">&nbsp;</td>
</tr>
<tr>
	<td class="jdlsub">Tempat Layanan</td>
	<td class="jdlsub">: <?php echo $rwKmr['nama'] ?></td>
	<td width="50%">&nbsp;</td>
</tr>
<tr>
	<td align="center" colspan="3">
	<table class="tbl" align="center" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed">
	<tr bgcolor="#CCC" align="center" style="text-transform:uppercase; font-weight:bold; height:30;">
		<td rowspan="2" class="jdkiri" width="3%">NO</td>
		<td rowspan="2" class="jdkiri" width="6%">NO RM</td>
		<td rowspan="2" class="jdkiri" width="15%">NAMA PASIEN</td>
        <td rowspan="2" class="jdkiri">DIAGNOSA</td>
        <td rowspan="2" class="jdkiri" width="7%">KELAS</td>
        <td rowspan="2" class="jdkiri" width="10%">LANTAI / KAMAR / BED</td>
		<td colspan="2" class="jdkiri" width="15%">PAGI</td>
		<td colspan="2" class="jdkiri" width="15%">SIANG</td>
		<td colspan="2" class="jdkanan" width="15%">SORE</td>
	</tr>
	<tr bgcolor="#EEE" align="center" style="text-transform:uppercase;font-size:11; font-weight:bold;">
		<td class="jdbwh" width="6%">Makan</td>
		<td class="jdbwh" width="9%">Keterangan</td>
		<td class="jdbwh" width="5%">Makan</td>
		<td class="jdbwh" width="9%">Keterangan</td>
		<td class="jdbwh" width="5%">Makan</td>
		<td class="jdbwhkanan" width="12%">Keterangan</td>
	</tr>
	<?php
	/*
    $sql="SELECT *
FROM (SELECT
        mp.id,
        pl.id        idpel,
		pl.id_kamar,
        mp.no_rm,
        mp.id     AS id_pasien,
        mp.nama   AS pasien,
        DATE_FORMAT(pl.tgl_in,'%d-%m-%Y %H:%i')    tgl_in,
        pl.tgl_in    tgl,
        mp.alamat,
        pl.nama
      FROM (SELECT
              p.*,
              tk.tgl_in,
              k.pasien_id    pas_id,
			  tk.kamar_id AS id_kamar,
              kso.nama
            FROM $dbbilling.b_pelayanan p
              INNER JOIN $dbbilling.b_tindakan_kamar tk
                ON p.id = tk.pelayanan_id
              INNER JOIN $dbbilling.b_kunjungan k
                ON p.kunjungan_id = k.id
              INNER JOIN $dbbilling.b_ms_kso kso
                ON p.kso_id = kso.id
            WHERE tk.aktif = 1
                AND (k.tgl_pulang > '$tgl'
                      OR k.tgl_pulang IS NULL)
                AND (tk.tgl_out > '$tgl'
                      OR tk.tgl_out IS NULL)
                AND p.unit_id = '$unitId') AS pl
        INNER JOIN $dbbilling.b_ms_pasien mp
          ON pl.pas_id = mp.id) AS gab
  LEFT JOIN (SELECT
			   mh.id           id_makan_harian,
               mh.pasien_id    id_pas,
			   mh.tgl,
               (SELECT
                  b.id
                FROM $dbgizi.gz_makan_harian a
                  INNER JOIN $dbgizi.gz_ms_menu_jenis b
                    ON a.ms_menu_jenis_id = b.id
                WHERE a.pasiso = 1
                    AND a.pasien_id = mh.pasien_id AND a.tgl = mh.tgl)    pagi,
               (SELECT
                  b.id
                FROM $dbgizi.gz_makan_harian a
                  INNER JOIN $dbgizi.gz_ms_menu_jenis b
                    ON a.ms_menu_jenis_id = b.id
                WHERE a.pasiso = 2
                    AND a.pasien_id = mh.pasien_id AND a.tgl = mh.tgl)    siang,
               (SELECT
                  b.id
                FROM $dbgizi.gz_makan_harian a
                  INNER JOIN $dbgizi.gz_ms_menu_jenis b
                    ON a.ms_menu_jenis_id = b.id
                WHERE a.pasiso = 3
                    AND a.pasien_id = mh.pasien_id AND a.tgl = mh.tgl)    sore
             FROM $dbgizi.gz_makan_harian mh WHERE mh.tgl = '$tgl'
             GROUP BY mh.pasien_id) AS makan
    ON makan.id_pas = gab.id_pasien ORDER BY gab.pasien";
	*/
	$sql = "SELECT *
FROM (SELECT
        mp.id,
        pl.id          idpel,
        pl.id_kamar,
        mp.no_rm,
        mp.id       AS id_pasien,
        mp.nama     AS pasien,
        DATE_FORMAT(pl.tgl_in,'%d-%m-%Y %H:%i')    tgl_in,
        pl.tgl_in      tgl,
        mp.alamat,
        pl.nama,
        pl.kelas,
		pl.kamar,
		pl.lantai,
		pl.no_bed
      FROM (SELECT
              p.*,
              tk.tgl_in,
			  tk.no_bed,
              k.pasien_id     pas_id,
              tk.kamar_id  AS id_kamar,
              kso.nama,
              kl.nama      as kelas,
			  km.nama      as kamar,
			  km.lantai	   as lantai
            FROM $dbbilling.b_pelayanan p
              INNER JOIN $dbbilling.b_tindakan_kamar tk
                ON p.id = tk.pelayanan_id
              INNER JOIN $dbbilling.b_kunjungan k
                ON p.kunjungan_id = k.id
              INNER JOIN $dbbilling.b_ms_kso kso
                ON p.kso_id = kso.id
              inner join $dbbilling.b_ms_kelas kl
                on kl.id = tk.kelas_id
			  inner join $dbbilling.b_ms_kamar km
			    on km.id = tk.kamar_id
            WHERE tk.aktif = 1
                AND (k.tgl_pulang > '$tgl'
                      OR k.tgl_pulang IS NULL)
                AND (tk.tgl_out > '$tgl'
                      OR tk.tgl_out IS NULL)
                AND p.unit_id = '$unitId'
				AND p.dilayani=1) AS pl
        INNER JOIN $dbbilling.b_ms_pasien mp
          ON pl.pas_id = mp.id) AS gab
  LEFT JOIN (SELECT mh.id id_makan_harian, mh.pelayanan_id id_pel, mh.pasien_id id_pas, mh.tgl, mh.kode_bed, 
(SELECT b.id FROM $dbgizi.gz_makan_harian a INNER JOIN $dbgizi.gz_ms_menu_jenis b ON a.ms_menu_jenis_id = b.id 
WHERE a.pasiso = 1 AND a.pelayanan_id = mh.pelayanan_id AND a.tgl = mh.tgl ORDER BY a.id DESC LIMIT 1) pagi, 
(SELECT b.id FROM $dbgizi.gz_makan_harian a INNER JOIN $dbgizi.gz_ms_menu_jenis b ON a.ms_menu_jenis_id = b.id 
WHERE a.pasiso = 2 AND a.pelayanan_id = mh.pelayanan_id AND a.tgl = mh.tgl ORDER BY a.id DESC LIMIT 1) siang, 
(SELECT b.id FROM $dbgizi.gz_makan_harian a INNER JOIN $dbgizi.gz_ms_menu_jenis b ON a.ms_menu_jenis_id = b.id 
WHERE a.pasiso = 3 AND a.pelayanan_id = mh.pelayanan_id AND a.tgl = mh.tgl ORDER BY a.id DESC LIMIT 1) sore FROM $dbgizi.gz_makan_harian mh 
WHERE mh.tgl = '$tgl' GROUP BY mh.pelayanan_id) AS makan
    ON makan.id_pas = gab.id_pasien
ORDER BY lantai,kamar";
	$rs=mysql_query($sql);
	$jmldata=mysql_num_rows($rs);
	$i=1;

	while ($rows=mysql_fetch_array($rs))
	{
		if($rows['pagi']==''){
			$isuk = 0; 
		}
		else{
			$isuk  = $rows['pagi'];
		}
		if($rows['siang']==''){
			$awan = 0; 
		}
		else{
			$awan  = $rows['siang'];
		}
		if($rows['sore']==''){
			$sure = 0; 
		}
		else{
			$sure  = $rows['sore'];
		}
	
		$pagi="SELECT
	  mmj.id,
	  mmj.kode,
	  mmj.nama,
	  mh.id id_menu_harian,
	  if(mh.ket='','',CONCAT('(',mh.ket,')')) ket
	FROM $dbgizi.gz_makan_harian mh
	  INNER JOIN $dbgizi.gz_ms_menu_jenis mmj
		ON mh.ms_menu_jenis_id = mmj.id
	WHERE mh.pasien_id = ".$rows['id_pasien']."
		AND mh.ms_menu_jenis_id = ".$isuk." AND mh.tgl = '$tgl'";
		$siang="SELECT
	  mmj.id,
	  mmj.kode,
	  mmj.nama,
	  mh.id id_menu_harian,
	  if(mh.ket='','',CONCAT('(',mh.ket,')')) ket
	FROM $dbgizi.gz_makan_harian mh
	  INNER JOIN $dbgizi.gz_ms_menu_jenis mmj
		ON mh.ms_menu_jenis_id = mmj.id
	WHERE mh.pasien_id = ".$rows['id_pasien']."
		AND mh.ms_menu_jenis_id =".$awan." AND mh.tgl = '$tgl'";
		$sore="SELECT
	  mmj.id,
	  mmj.kode,
	  mmj.nama,
	  mh.id id_menu_harian,
	  if(mh.ket='','',CONCAT('(',mh.ket,')')) ket
	FROM $dbgizi.gz_makan_harian mh
	  INNER JOIN $dbgizi.gz_ms_menu_jenis mmj
		ON mh.ms_menu_jenis_id = mmj.id
	WHERE mh.pasien_id = ".$rows['id_pasien']."
		AND mh.ms_menu_jenis_id =".$sure." AND mh.tgl = '$tgl'";
		$qpagi=mysql_query($pagi);
		$qsiang=mysql_query($siang);
		$qsore=mysql_query($sore);
		$dpagi=mysql_fetch_array($qpagi);
		$dsiang=mysql_fetch_array($qsiang);
		$dsore=mysql_fetch_array($qsore);
		
		$bed = "";
		if($rows['kode_bed']==''){
			//$bed = "";
			$bed = " / ".$rows['no_bed'];
		}
		else{
			$bed = " / ".$rows['kode_bed'];
		}
		
		$sqld = "SELECT
		  md.id,
		  md.nama
		FROM $dbbilling.b_ms_diagnosa md
		  INNER JOIN $dbbilling.b_diagnosa d
			ON d.ms_diagnosa_id = md.id where d.pelayanan_id = '".$rows['idpel']."'";
		$kue = mysql_query($sqld);
		$diagnosa = "";
        while($diag=mysql_fetch_array($kue)){
			$diagnosa = $diagnosa." - ".$diag['nama']."<br>";
		}
	?>
	<tr>
		<td class="kiri"><?php echo $i; ?>&nbsp;</td>
		<td class="kiri"><?php echo $rows['no_rm'] ?>&nbsp;</td>
		<td class="kiri"><?php echo $rows['pasien'] ?>&nbsp;</td>
        <td class="kiri"><?php echo $diagnosa; ?>&nbsp;</td>
        <td class="kiri"><?php echo $rows['kelas']; ?>&nbsp;</td>
        <td class="kiri"><?php echo "Lt. ".$rows['lantai']." / ".$rows['kamar'].$bed; ?>&nbsp;</td>
		<td class="kiri"><?php echo $dpagi['nama'] ?>&nbsp;</td>
		<td class="kiri"><?php echo $dpagi['ket'] ?>&nbsp;</td>
		<td class="kiri"><?php echo $dsiang['nama'] ?>&nbsp;</td>
		<td class="kiri"><?php echo $dsiang['ket'] ?>&nbsp;</td>
		<td class="kiri"><?php echo $dsore['nama'] ?>&nbsp;</td>
		<td class="kanan"><?php echo $dsore['ket'] ?>&nbsp;</td>
	</tr>
	<?php
	//$dt.=$rows["id"]."|".$rows["idpel"]."|".$rows['id_kamar']."|".$rows['id_makan_harian'].chr(3).$rows["no_rm"].chr(3).$rows["pasien"].chr(3).$pa.chr(3).$si.chr(3).$so.chr(6);
	$i++;
	}
	?>
	</table>
	</td>
</tr>
</table>
<?php
if($_GET['export']!=1){
?>
<p>&nbsp;</p>
<div id="noprint" align="center">
	<button type="button" id="expexcel" name="expexcel" onclick="exporte();" style="cursor:pointer; display:none;"><img src="../icon/excel.gif" width="20" height="20" style="vertical-align:middle" />&nbsp;Export to Excel</button>&nbsp;&nbsp;
	<button type="button" id="close" name="close" onclick="window.close()" style="cursor:pointer"><img src="../icon/delete.gif" width="20" height="20" style="vertical-align:middle" />&nbsp;Tutup</button>
	<button type="button" id="ctk" name="ctk" onclick="window.print()" style="cursor:pointer"><img src="../icon/printButton.jpg" width="20" height="20" style="vertical-align:middle" />&nbsp;Cetak</button>
</div>
<script language="javascript">

function exporte() {
	if ("<?php echo $jmldata;?>" > 0) 
	{
	location = ('lap_minta_makan.php?tgl=<?php echo $tgl?>&unit_id=<?php echo $unitId?>&id_pelayanan=<?php echo $IdPel?>&id_kamar=<?php echo $IdKmr?>&export=1');
	}
	else
	{
	alert('Tidak ada data.');
	}
}
</script>

<?php
}else{
}
mysql_free_result($rs);
mysql_close($konek);

?>