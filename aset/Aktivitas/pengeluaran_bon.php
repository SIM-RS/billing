<?php 
include '../sesi.php';
include '../koneksi/konek.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='$def_loc';
                        </script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../theme/report.css" rel="stylesheet" type="text/css" />
<title>Pengeluaran Bon</title>
</head>
<?php 
$no_po=$_REQUEST['id']; 
$no_po=explode('|',$no_po);
$tgl=$no_po[0];
$tgl=explode("-",$tgl);
$tgl=$tgl[2]."-".$tgl[1]."-".$tgl[0];
$no=$no_po[1];
$untuk=$no_po[5];
?>

<body>
<table width="789" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td colspan="4" style="font-size:large" align="center"><strong>PENGELUARAN BON<br />
	  <br />
	</strong></td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
	<td width="183" rowspan="7" ><img src="barcodeCreator.php?txt=<?php echo $no; ?>"></td>
</tr>
<tr>
	<td width="105">Tanggal</td>
	<td width="459">:&nbsp;<?php echo $tgl ?>&nbsp;</td>
	
</tr>
<tr><td colspan="2">&nbsp;</td></tr>

<tr>
	<td>Nomor</td>
	<td>:&nbsp;<?php echo $no ?></td>
	
</tr>
<tr><td colspan="2">&nbsp;</td></tr>

<tr>
	<td>Peruntukan</td>
	<td>:&nbsp;<?php echo $untuk ?>&nbsp;</td>
	
</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr>
	<td colspan="5"><p>&nbsp;</p></td>
</tr>
</table>
<table width="789" border="1" align="center" cellpadding="" cellspacing="" class="GridStyle" >
<tr class="HeaderBW" bgcolor="#CCCCCC">
	<td width="36" align="center">No</td>
	<td width="108" align="center">Kode Barang</td>
	<td width="261" align="center">Nama Barang</td>
	<td width="90" align="center">Uraian</td>
	<td width="105" align="center">Satuan</td>
	<td width="53" align="center">Jumlah Bon</td>
	<td width="57" align="center">Stok</td>
	<td width="61" align="center">Jumlah Keluar</td>
</tr>
<tr>
<?php 
$tgl=$no_po[0];
$no_bon=$no_po[1];
$i=1;
$sql="SELECT
  klr_id,
  k.barang_id,
  kodebarang,
  namabarang,
  jml_klr,
  k.jumlah_keluar,
  satuan,
  klr_uraian
FROM as_keluar k
  INNER JOIN as_ms_barang b
    ON k.barang_id = b.idbarang
WHERE tgl_transaksi = '$tgl'
    AND kode_transaksi = '$no_bon'";
	$rs=mysql_query($sql);
	while($r=mysql_fetch_array($rs)){
	$sql1="SELECT jml_sisa FROM as_kstok  WHERE barang_id='".$r['barang_id']."' ORDER BY stok_id DESC limit 1";
	$rs1=mysql_query($sql1);
	$rows1=mysql_fetch_array($rs1);
	$rows1['jml_sisa'];
?>
	<td align="center"><?php echo $i ?></td>
	<td align="center"><?php echo $r['kodebarang'] ?></td>
	<td><?php echo $r['namabarang'] ?></td>
	<td><?php echo $r['klr_uraian'] ?>&nbsp;</td>	
	<td align="center"><?php echo $r['satuan'] ?>&nbsp;</td>
	<td align="center"><?php echo $r['jml_klr'] ?>&nbsp;</td>
	<td align="center"><?php echo $rows1['jml_sisa']; ?>&nbsp;</td>
	<td align="center"><?php if($r['jumlah_keluar']!='') echo $r['jumlah_keluar']; else echo '0' ?></td>
</tr>
<?php 
$i++;
}
?>

</table>
<table width="789" align="center" cellpadding="0" cellspacing="0">
<tr><td colspan="2" ><p>&nbsp;</p>
  </td></tr>
  <tr> 
	<td width="379" align="right">&nbsp;</td>
	<td align="center"><?=$kotaRS;?>, <?php echo date("d-M-Y") ?></td>
  </tr>
  <tr> 
  	<td align="center"><p><strong>NAMA PENERIMA</strong></p>
    <p>&nbsp;</p></td>
	<td width="368" align="center"><p><strong>PETUGAS GUDANG</strong></p>
    <p>&nbsp;</p></td>
  </tr>
    <tr> 
  	<td align="center" height="30" ><br /><strong><?php echo strtoupper($untuk); ?></strong></td>
	<td  align="center" height="30" ><br /><strong><?php echo strtoupper($no_po[4]) ?></strong></td>
  </tr>
  <tr>
	<td align="center" ><hr style="width:120px;"/></td>
	<td align="center" ><hr style="width:120px;"/></td>
  </tr>
  <tr>
  	<td align="center"><strong>NIP. ............................</strong></td>
	<td align="center"><p><strong>NIP. ............................</strong></td>
	<tr><td>&nbsp;</td>
	</tr>
  </tr>
  <tr id="trCetak" height="30">
  	<td colspan="2" align="center" valign="bottom" height="30">
    <button type="button" onClick="cetak();" style="cursor: pointer"><img src="../icon/printer.png"  border="0"  width="16" height="16" align="absmiddle" />&nbsp;&nbsp;Cetak&nbsp;&nbsp;                            </button>
	<button type="reset" onClick="window.close();" style="cursor: pointer">
                                <img alt="cancel" src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" />
                                &nbsp; Tutup &nbsp;&nbsp;&nbsp;
      </button>
    </td>
 </tr>
</table>
</body>
<script>
	function cetak(){		
	document.getElementById('trCetak').style.visibility='hidden';
	window.print();
	window.close();				
	}
	</script>
</html>
