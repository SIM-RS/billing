<?php
include 'header.php';
$sql = "SELECT
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
$query = mysqli_query($konek, $sql);
$sql2 = "SELECT HARGA_TOTAL_PPN,NAMA_PASIEN FROM (".$sql.") AS TBL";
$fetch = mysqli_fetch_array(mysqli_query($konek,$sql2));
?>
<div class="container">
    <h4><?= $fetch['NAMA_PASIEN'] ?></h4>
    <table class="table table-bordered">
        <tr>
            <th>Nama Obat</th>
            <th>Qty</th>
            <th>Harga Satuan</th>
            <th>Sub Total</th>
        </tr>
        <?php
        $total = 0;
        while ($rows = mysqli_fetch_assoc($query)) {
            echo "<tr>";
            echo "<td>" . $rows['OBAT_NAMA'] . "</td>";
            echo "<td>" . $rows['QTY'] . "</td>";
            echo "<td>" . (($rows['HARGA_SATUAN'] / 110) * 100) . "</td>";
            echo "<td>" . ($rows['QTY'] * (($rows['HARGA_SATUAN'] / 110) * 100)) . "</td>";
            echo "</tr>";
            $total += ($rows['QTY'] * (($rows['HARGA_SATUAN'] / 110) * 100));
        }
        $total += $total * 0.1;
        ?>
        <tr class="<?= (int)$total == (int)$fetch['HARGA_TOTAL_PPN'] ? "bg-success" : "bg-warning" ?>">
            <th colspan="2" align="right">Total</th>
            <td><?= $total ?></td>
            <td><?= $fetch['HARGA_TOTAL_PPN'] ?></td>
        </tr>
    </table>
    <form action="ubah.php" method="post">
        <input type="hidden" name="no_penjualan" value="<?= $_REQUEST['no_penjualan'] ?>">
        <button type="submit" class="btn btn-success">Ubah</button>
    </form>
</div>
<?php
include 'footer.php';
?>