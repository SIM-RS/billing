<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
include("../koneksi/konek.php");
$iduser=$_SESSION['userId'];

$stmp="SELECT distinct m.id,m.nama,m.inap FROM (SELECT distinct b.unit_id FROM b_ms_pegawai_unit b
            where ms_pegawai_id=".$iduser.") as t1
            inner join b_ms_unit u on t1.unit_id=u.id
            inner join b_ms_unit m on u.parent_id=m.id WHERE m.kategori=2 AND m.id='$_REQUEST[jnsLay]' order by nama";
$qtmp=mysql_query($stmp);
$rtmp=mysql_fetch_array($qtmp);

$bulan = $_REQUEST['bulan'];
$tahun = $_REQUEST['tahun'];
$bln = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'Nopember','12'=>'Desember');
$uni = "select * from $dbapotek.a_unit where kdunitfar='$_REQUEST[tmpLay]'";
$k = mysql_query($uni);
$dunit = mysql_fetch_array($k);
$idunit=$dunit['UNIT_ID'];

if($_GET['pil']=='lap')
{
header("Content-type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="Laporan Stok Opname BHP.xls"');
}

?>
<style type="text/css">
table{
	border-collapse:collapse;
}
#header{
	font-family:Helvetica,Sans-Serif;font-size:13px;font-weight:bold;font-style:italic;
}
#jdlatas{
	font-family:Helvetica,Sans-Serif;font-size:12px;font-weight:bold;font-style:italic;
}
#judul{
	font-family:Helvetica,Sans-Serif;font-size:16px;font-weight:bold;
}
#tjudul{
	font-family:Helvetica,Sans-Serif;font-size:14px;font-weight:bold;
}
#tsubjudul{
	font-family:Helvetica,Sans-Serif;font-size:12px;font-weight:bold;
}
#tisi{
	font-family:Helvetica,Sans-Serif;font-size:11px;
}
@media print{
	#noprint{
		display:none;
	}
}
</style>
<title>Laporan Stok Opname BHP</title>
<body>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="800">
	<tr>
		<td align="left" colspan="5" id="header">
			<?=$namaRS?><br>
			<?=$alamatRS?><br>
			Telepon <?=$tlpRS?><br>
			<?=$kotaRS?><br><hr>
		</td>
	</tr>
	<tr align="left">
		<td width="15%">Jenis Layanan</td>
		<td id="jdlatas" width="25%">: <?php echo $rtmp['nama']; ?></td>
		<td width="25%">&nbsp;</td>
		<td width="10%">Bulan</td>
		<td width="25%">: <?php echo $bln[$bulan]; ?></td>
	</tr>
	<tr align="left">
		<td>Tempat Layanan</td>
		<td id="jdlatas">: <?php echo $dunit['UNIT_NAME']; ?></td>
		<td width="25%">&nbsp;</td>
		<td>Tahun</td>
		<td>: <?php echo $tahun; ?></td>
	</tr>
	<tr>
		<td align="center" colspan="5" id="judul"><br>LAPORAN STOK OPNAME BHP</td>
	</tr>
</table>
<table align="center" border="1" cellpadding="0" cellspacing="1" width="800" style="margin-top:10px">
	<tr>
		<td align="center" colspan="5" bgcolor="#CCC" id="tjudul">STOK OPNAME BHP</td>
	</tr>
	<tr align="center" bgcolor="#CECECE">
		<td id="tsubjudul" width="50">NO</td>
		<td id="tsubjudul" width="100">KODE OBAT</td>
		<td id="tsubjudul" width="300">NAMA OBAT</td>
		<td id="tsubjudul" width="250">KEPEMILIKAN</td>
		<td id="tsubjudul">STOK</td>
	</tr>
	<?php
	$sql="SELECT tbl1.*,IF (aso.adjust IS NULL, 0, aso.adjust) AS adjust,IF (aso.adjust IS NULL, 0, 1) AS sdh_so 
			FROM (SELECT au.UNIT_ID,au.UNIT_NAME,au.kdunitfar,ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ap.KEPEMILIKAN_ID,
			ak.NAMA,ap.stok,ap.HARGA_BELI_SATUAN,ap.DISKON,ap.NILAI_PAJAK FROM $dbapotek.a_obat ao
			INNER JOIN (SELECT OBAT_ID,SUM(QTY_STOK) stok,KEPEMILIKAN_ID,UNIT_ID_TERIMA,HARGA_BELI_SATUAN,DISKON,NILAI_PAJAK
					FROM $dbapotek.a_penerimaan WHERE UNIT_ID_TERIMA = ".$idunit." AND QTY_STOK > 0 GROUP BY OBAT_ID) ap 
				ON ao.OBAT_ID = ap.OBAT_ID
			INNER JOIN $dbapotek.a_kepemilikan ak ON ak.ID = ap.KEPEMILIKAN_ID
			INNER JOIN $dbapotek.a_unit au ON au.UNIT_ID = ap.UNIT_ID_TERIMA WHERE ao.OBAT_ISAKTIF=1
		  ORDER BY ao.OBAT_NAMA) AS tbl1
			INNER JOIN (SELECT DISTINCT idobat,kepemilikan_id,opname,adjust,qty,tgl
				FROM $dbapotek.a_stok_opname WHERE idunit = ".$idunit." AND MONTH(tgl) = '".$bulan."' AND YEAR(tgl) = '".$tahun."') AS aso
				ON aso.idobat = tbl1.OBAT_ID
		  AND aso.kepemilikan_id = tbl1.KEPEMILIKAN_ID";
	$qstok=mysql_query($sql);
	$i=1;
	while($rstok=mysql_fetch_array($qstok)){
	?>
	<tr id="tisi">
		<td align="center">&nbsp;<?php echo $i; ?></td>
		<td align="center">&nbsp;<?php echo $rstok['OBAT_KODE']; ?></td>
		<td>&nbsp;<?php echo $rstok['OBAT_NAMA']; ?></td>
		<td>&nbsp;<?php echo $rstok['NAMA']; ?></td>
		<td align="center">&nbsp;<?php echo $rstok['stok']; ?></td>
	</tr>
	<?php
	$i++;
	}
	?>
</table>
<?php
if($_GET['pil']!='lap')
{
?>
<div align="center" id="noprint" width="800" style="padding-top:50px">
<button type="button" style="cursor:pointer" onClick="cetak()">Print/Cetak</button>
<button style="cursor:pointer" onClick="exprot()">Export To Excell</button>
<button style="cursor:pointer" onClick="window.close();">Close/Tutup</button>
</div>
</body>
<script type="text/javascript">
function cetak(){
	window.print();
}
function exprot(){
	location = 'lap_stok_opname_bhp.php?jnsLay=<?php echo $_REQUEST['jnsLay']; ?>&tmpLay=<?php echo $_REQUEST['tmpLay']; ?>&bulan=<?php echo $_REQUEST['bulan']; ?>&tahun=<?php echo $_REQUEST['tahun']; ?>&pil=lap';
}
</script>
<?php
}
?>