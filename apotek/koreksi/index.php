<?php
    include 'header.php';
    $sql = "SELECT
                p.HARGA_SATUAN,
                p.SUB_TOTAL,
                p.SUM_SUB_TOTAL,
                p.HARGA_TOTAL,
                p.PPN_NILAI,
                p.HARGA_TOTAL_PPN,
                p.NAMA_PASIEN,
                p.TGL,
                p.NO_PENJUALAN
            FROM a_penjualan p
            LEFT JOIN rspelindo_billing.b_pelayanan pel ON pel.id = p.NO_KUNJUNGAN
            LEFT JOIN rspelindo_billing.b_kunjungan k ON k.id = pel.kunjungan_id
            WHERE 
                p.KSO_ID = 2
                AND p.TGL BETWEEN '2020-12-01' AND '2020-12-19'
                AND pel.jenis_kunjungan = 1
                AND p.PPN = 0
            GROUP BY
                p.NO_PENJUALAN";
    $query = mysqli_query($konek,$sql);
?>
<div class="container">
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama Pasien</th>
            <th>No Penjualan</th>
            <th>Tgl Penjualan</th>
            <th>Total Harga</th>
            <th>Action</th>
        </tr>
        <?php
            $no = 0;
            while($rows = mysqli_fetch_assoc($query)){
                echo "<tr>";
                    echo "<td>".++$no."</td>";
                    echo "<td>".$rows['NAMA_PASIEN']."</td>";
                    echo "<td>".$rows['NO_PENJUALAN']."</td>";
                    echo "<td>".$rows['TGL']."</td>";
                    echo "<td>".number_format($rows['HARGA_TOTAL_PPN'],0,",",".")."</td>";
                    echo "<td><a href='view.php?no_penjualan=".$rows['NO_PENJUALAN']."&tgl=".$rows['TGL']."' class='btn btn-danger btn-sm' target='_blank'>View</a></td>";
                echo "</tr>";
            }
        ?>
    </table>
</div>
<?php
include 'footer.php';
?>