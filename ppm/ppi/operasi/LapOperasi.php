<?php
require '../../autoload.php';
require '../../templates/headerlap.php';
$konek = new Connection();
$ruangan = $_REQUEST['ruangan'];
$bulan = $_REQUEST['bulan'];
$tahun = $_REQUEST['tahun'];
$inc = 0;

$bulanArr = [
    1 => 'JANUARI',
    2 => 'PEBRUARI',
    3 => 'MARET',
    4 => 'APRIL',
    5 => 'MEI',
    6 => 'JUNI',
    7 => 'JULI',
    8 => 'AGUSTUS',
    9 => 'SEPTEMBER',
    10 => 'OKTOBER',
    11 => 'NOPEMBER',
    12 => 'DESEMBER',
];

if($_REQUEST['act'] == "excell"){
    header("Content-type: application/vnd.ms-excel");
    header('Content-Disposition: attachment; filename="LAP PPI PEMANTAUAU OPERASI '.$bulanArr[$_REQUEST['bulan']] . ' '.$_REQUEST['tahun'].'.xls"');
}


if ($bulan == 1 || $bulan == 3 || $bulan == 5 || $bulan == 7 || $bulan == 8 || $bulan == 10 || $bulan == 12) {
    $inc = 31;
} else if ($bulan == 4 || $bulan == 6 || $bulan == 9 || $bulan == 11) {
    $inc = 30;
} else if ($bulan == 2) {
    if ($tahun % 100 == 0 && $tahun % 400 == 0 && $tahun % 4 == 0) {
        $inc = 29;
    } else {
        $inc = 28;
    }
}



$bulanCetak = "";
foreach($bulanArr as $key => $val){
    if($key == $bulan){
        $bulanCetak = $val;
        break;
    }
}

$sqlRuangan = $konek->rawQuery("SELECT * FROM ppi_ruangan WHERE id = {$_REQUEST['ruangan']}")->fetch_assoc();

$arrData = [];
for($i = 0; $i < $inc; $i++){
    array_push($arrData,['operasi'=>0]);
}
?>
<table border="1" class="table table-bordered table-sm">
    <tr>
        <th colspan="35" style="vertical-align: middle;text-align:center;text-transform:uppercase">LEMBAR PEMANTAUAN PASIEN YANG OPERASI<br>BULAN <?= $bulanCetak . ' ' . $tahun ?></th>
    </tr>
    <tr>
        <td>Ruangan</td>
        <td>:</td>
        <td colspan="33"><?= $sqlRuangan['nama_ruangan'] ?></td>
    </tr>
    <tr>
        <th></th>
    </tr>
    <tr>
        <th colspan="2">A. Pasien Yang Operasi</th>
    </tr>
    <tr>
        <th></th>
    </tr>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <?php for($i = 1; $i <= $inc; $i++) echo "<th style='vertical-align: middle;text-align:center;'>".$i."</th>"; ?>
        <th>Total</th>
        <th>Keterangan</th>
    </tr>

    <?php
    $arrAngkaKejadianPlebitis = [];
    //get data pasien terlebih dahulu di dalam table
    $sql = "SELECT * FROM (SELECT * FROM (SELECT p.nama,p.no_rm,i.pasien_id,i.keterangan FROM ppi_operasi i LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = i.pasien_id WHERE MONTH(i.tanggal) = {$_REQUEST['bulan']} AND YEAR(i.tanggal) = {$_REQUEST['tahun']} AND ruangan = '{$_REQUEST['ruangan']}' ORDER BY i.tanggal DESC) as j GROUP BY pasien_id) as q ORDER BY nama";

    $data = $konek->rawQuery($sql);
    $no = 0;

    while ($rows = $data->fetch_assoc()) {
        $totalRow = 0;
        echo "<tr>";
            echo "<td>".++$no."</td>";
            echo "<td>" . $rows['nama'] . '/' . $rows['no_rm'] . "</td>";
            //lakukan perulangan untuk di sesuaikan dengan tanggal pasin di layani
            for ($i = 1; $i <= $inc; $i++) {
                
                $sql = "SELECT * FROM ppi_operasi WHERE YEAR(tanggal) = {$_REQUEST['tahun']} AND MONTH(tanggal) = {$_REQUEST['bulan']} AND DAY(tanggal) = {$i} AND pasien_id = {$rows['pasien_id']} AND ruangan = '{$_REQUEST['ruangan']}'";
                
                $dataOutput = $konek->rawQuery($sql)->fetch_assoc();
                $dataRows = $konek->rawQuery($sql)->num_rows;

                //jika pasien  nya ada pada tanggal sesuai perulangan maka tampilkan
                if($dataRows > 0){
                    echo "<td style='vertical-align: middle;text-align:center;'>".$dataOutput['operasi']."</td>";
                    $arrData[$i-1]['operasi'] += $dataOutput['operasi'];
                }else{
                    echo "<td></td>";
                }
                $totalRow += $dataOutput['operasi'];
            }
            echo '<td>'.$totalRow.'</td>';
            echo '<td>'.$rows['keterangan'].'</td>';
        echo "</tr>";
    }
    echo '<tr>';
            echo '<td colspan="2" style="vertical-align: middle;text-align:center;">Total</td>';
    $totalAll = 0;
    for($i = 0; $i < sizeof($arrData); $i++) {
            echo '<td>'.$arrData[$i]['operasi'].'</td>';
            $totalAll += $arrData[$i]['operasi'];
    }
        echo '<td>'.$totalAll.'</td>';
    echo '</tr>';
    ?>
</table>
<div id="trTombol">
    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
    <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
</div>

<script type="text/JavaScript">
    function cetak(tombol){
        tombol.style.display='none';
        if(tombol.style.display=='none'){
        window.print();
        window.close();
        }
    }
</script>