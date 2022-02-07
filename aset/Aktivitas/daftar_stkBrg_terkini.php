<?php 
include '../sesi.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>
        alert('Session anda habis atau anda belum login, silakan login ulang.');
        window.location = '/simrs-tangerang/aset/';
        </script>";
}
include '../koneksi/konek.php'; 

$r_formatlap = $_REQUEST["format"];

switch ($r_formatlap) {
    case "XLS" :
        Header("Content-Type: application/vnd.ms-excel");
        break;
    case "WORD" :
        Header("Content-Type: application/msword");
        break;
    default :
        Header("Content-Type: text/html");
        break;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.:Laporan Stok Pakai Habis:.</title>
</head>
<style>
.judulheaderkiri{
border-bottom:1px solid;
border-left:1px solid;
border-top:1px solid;
border-right:1px solid;

font:bold;
}
.isiheader{
border-bottom:1px solid;
border-top:1px solid;
border-right:1px solid;

font:bold;
}
.subisiheader{
border-bottom:1px solid;
border-right:1px solid;

font:bold;
}
.isikiri{
border-bottom:1px solid #000000;
border-left:1px solid #000000;
border-right:1px solid #000000;

}
.isi{
border-bottom:1px solid;
border-right:1px solid;

}
</style>
<script language="javascript">
function Cetak(){
	window.print();
}
</script>
<body onload="window.open='daftar_stkBrg_terkini.php';">

<button type="button" id="ctk" name="ctk" onclick="Cetak()" style="cursor:pointer"><img src="../icon/printer.png" width="20" height="20"style="vertical-align:middle" />&nbsp;&nbsp;Cetak</button>
<button type="button" id="ttp" name="ttp" onclick="window.close()" style="cursor:pointer"><img src="../icon/del.gif" width="20" height="20" style="vertical-align:middle" />&nbsp;&nbsp;Tutup</button>

<table width="721" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td width="719" align="center" style="font:Verdana, Arial, Helvetica, sans-serif large bold">DAFTAR STOK BARANG PAKAI HABIS<br />Tanggal&nbsp;:&nbsp;<?php echo date('d-m-Y')."&nbsp;Jam&nbsp;:&nbsp;".date('H:i:s') ?> </td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
		<table width="711" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td width="61" class="judulheaderkiri" align="center">No</td>
			<td width="135" class="isiheader" align="center">Kode Barang</td>
			<td width="319" class="isiheader" align="center">Nama Barang</td>
			<td width="83" class="isiheader" align="center">Jml Stok</td>
			<td width="111" class="isiheader" align="center">Nilai</td>
		</tr>
		<?php 
			$no=1;
			$sql="select * from as_ms_barang where tipe=2 order by kodebarang";
			$rs=mysql_query($sql);
			$i=0;
			while($row=mysql_fetch_array($rs)){
			if($row['islast']==1){
				$sqlKst="select * from as_kstok where barang_id='".$row['idbarang']."' order by waktu desc limit 1";
				$rsKst=mysql_query($sqlKst);
				$rows=mysql_fetch_array($rsKst);
				$ttl+=$rows['nilai_masuk'];
			}
			
			/* if($row['islast']!=$t){
			//if($i==0){
				$a="blue";
			
			$t = $row['islast'];
			} */
			//$i++;
		?>
		<tr>
			<td class="isikiri" align="center" ><?php echo $no; ?></td>
			<td class="isi"><?php echo $row['kodebarang']; ?></td>
			<td class="isi" <?php if($row['islast']==1) echo "style='color:#0033CC'"?>><?php echo $row['namabarang'] ?></td>
			<td class="isi" align="center"><?php echo $rows['jml_sisa'] ?></td>
			<td class="isi"  align="right"><?php echo number_format($rows['nilai_masuk'],0,',','.') ?></td>
		</tr>
		<?php 
		//$a++;
		$no++;
		}
		?>
		<tr>
			<td colspan="4" align="right" class="isikiri">Total:&nbsp;</td>
			<td align="right" class="isi"><?php echo number_format($ttl,0,',','.') ?></td>
		</tr>
	  </table>
	</td>
</tr>
</table>
</body>
<script>
window.open='daftar_stkBrg_terkini.php';
</script>
</html>
