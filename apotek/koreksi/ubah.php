<?php
include '../koneksi/konek.php';
$sql = "SELECT
        p.ID,
        o.OBAT_NAMA,
        p.QTY,
        p.HARGA_SATUAN,
        p.SUB_TOTAL,
        p.SUM_SUB_TOTAL,
        p.HARGA_TOTAL,
        p.PPN_NILAI,
        p.HARGA_TOTAL_PPN,
        p.NAMA_PASIEN,
        p.TGL
        FROM a_penjualan p
        LEFT JOIN rspelindo_billing.b_pelayanan pel ON pel.id = p.NO_KUNJUNGAN
        LEFT JOIN rspelindo_billing.b_kunjungan k ON k.id = pel.kunjungan_id
        LEFT JOIN a_penerimaan pen ON p.PENERIMAAN_ID = pen.ID
        LEFT JOIN a_obat o ON o.OBAT_ID = pen.OBAT_ID
        WHERE 
        p.KSO_ID = 2
        AND p.TGL BETWEEN '2020-12-01' AND '2020-12-19'
        AND pel.jenis_kunjungan = 1
        AND p.NO_PENJUALAN = '{$_REQUEST["no_penjualan"]}'";
$query = mysqli_query($konek,$sql);
$queryUpdate = mysqli_query($konek,$sql);
$total = 0;
$arr = [];
while($rows = mysqli_fetch_assoc($query)){
    $hargaSatuan = (($rows['HARGA_SATUAN'] / 110) * 100);
    $subTotal = ($rows['QTY'] * (($rows['HARGA_SATUAN'] / 110) * 100));
    $total += $subTotal;
    array_push($arr,[$hargaSatuan,$subTotal]);
}
$ppn = 10;
$ppnNilai = $total * 0.1;
$i = 0;
while($rows = mysqli_fetch_assoc($queryUpdate)){
    mysqli_query($konek,"UPDATE a_penjualan SET HARGA_SATUAN = {$arr[$i][0]}, HARGA_KSO = {$arr[$i][0]}, SUB_TOTAL = {$arr[$i][1]}, SUM_SUB_TOTAL = {$total}, HARGA_TOTAL = {$total}, PPN = {$ppn}, PPN_NILAI = {$ppnNilai} WHERE ID = {$rows['ID']}");
    $i++;
}
?>