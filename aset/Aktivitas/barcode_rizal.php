<?php 
include '../sesi.php';
include "../koneksi/konek.php";
$no_po=$_GET['no_po'];
if($_GET['act'] == 'edit') {
    $sql = "select q1.*,namabarang,kodebarang from
            (SELECT pe.*, po.no_po, qty_satuan, satuan,harga_satuan,po.qty_terima
            FROM as_masuk pe inner join as_po po on pe.po_id = po.id
            where pe.no_gudang = '$terima_po[0]' and po.no_po = '$terima_po[1]'
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
    
    src: url(code128.ttf);
    
    font-style:normal;

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
<tr class="headtable">
	<td width="48" align="center"  class="tblheaderkiri">No</td>
	<td width="135" align="center" class="tblheader">No Penerimaan</td>
	<td width="95" align="center"  class="tblheader">Kode Barang</td>
	<td width="393" align="center" class="tblheader">Nama Barang</td>
	<td width="127" align="center" class="tblheader">Barcode</td>
	
</tr>
<?php 
while($rows=mysql_fetch_array($rs)){
echo "
<tr class='itemtableA'>
	<td class='tdisikiri' align='center'>
        <table border=0 cellpadding=2>
            <tr><td><font face='barcode'>$no_po</font></td></tr>
        </table>
    </td>
</tr>";
}
?>
</table>
</body>
</html>
