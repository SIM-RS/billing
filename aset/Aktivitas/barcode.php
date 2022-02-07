<?php 
include '../sesi.php';
include "../koneksi/konek.php";
$no_po=$_GET['no_po'];
$no_gudang=$_GET['no_gudang'];
$tgl_penerimaan=$_GET['tgl'];
if($_GET['opt'] == 'edit') {
    $sql = "select q1.*,namabarang,kodebarang from
            (SELECT pe.*, po.no_po, qty_satuan, satuan,harga_satuan,po.qty_terima
            FROM as_masuk pe inner join as_po po on pe.po_id = po.id
            where pe.no_gudang = '$no_gudang' and po.no_po = '$no_po'
            order by pe.msk_id) as q1
            INNER JOIN as_ms_barang b ON b.idbarang = q1.barang_id";
    //no_po, tgl, tgl_j_tempo, hari_j_tempo, qty_kemasan, qty_kemasan_terima, kemasan, harga_kemasan, qty_perkemasan, qty_satuan, qty_pakai, qty_satuan_terima, satuan, harga_beli_total, harga_beli_satuan, diskon, extra_diskon, diskon_total, ket, nilai_pajak, jenis, termasuk_ppn, status, user_act, tgl_act
}
else {
    if($no_po != '') {
        $sql = "select q1.*,q1.uraian as msk_uraian ,b.namabarang,b.kodebarang from (SELECT *
            FROM as_po po
            where po.no_po = '$no_po' and status = 0
            order by po.id) as q1
            INNER JOIN as_ms_barang b ON b.idbarang = q1.ms_barang_id";
    }    
}
$rs=mysql_query($sql);

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../default.css"/>
<title>.: Data Penerimaan Barang :.</title>
<style>

@font-face {
    font-family: barcode;
    src: url(http://<?php echo $_SERVER['SERVER_ADDR']."/".$_SERVER["PATH_INFO"];?>code128.ttf);
    font-style:normal;
}
.barcodefont{
    font-family: barcode;
    font-size:70px;
}
</style>
</head>
<body>
<table align="center" cellpadding="0" cellspacing="0" width="800">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td align="center">KODE BARCODE </td>
</tr>
<tr>
	<td align="center">DATA PENERIMAAN BARANG </td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>

<tr>
	<td>&nbsp;</td>
</tr>
</table>
<table align="center" width="800" cellpadding="0" cellspacing="0" bgcolor="#FFFBF0">

<?php 
while($rows=mysql_fetch_array($rs)){
echo "
<tr class='itemtableA'>
	<td class='tdisikiri' align='left'>
        <table border=0 cellpadding=2 cellspacing=0>
            <tr><td class='barcodefont' ><img src='barcodeCreator.php?txt=$rows[kodebarang]' /></td></tr>     
            <tr><td class='barcodefont' ><img src='barcodeCreator.php?txt=$tgl_penerimaan' /></td></tr>            
            <tr><td class='barcodefont' ><img src='barcodeCreator.php?txt=$no_po' /></td></tr>            
        </table><hr>
    </td>
</tr>";
}
?>
</table>
</body>
</html>
