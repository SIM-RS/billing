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
    header('Content-Disposition: attachment; filename="LAP PPI PEMANTAUAU PLEBITIS '.$bulanArr[$_REQUEST['bulan']] . ' '.$_REQUEST['tahun'].'.xls"');
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

$sqlRuangan = $konek->rawQuery("SELECT * FROM ppi_ruangan WHERE id = {$ruangan}")->fetch_assoc();

$bulanCetak = "";
foreach($bulanArr as $key => $val){
    if($key == $bulan){
        $bulanCetak = $val;
        break;
    }
}

$arrData = [];
for($i = 0; $i < $inc; $i++){
    array_push($arrData,['jhc'=>0,'kateter'=>0]);
}
if($inc == 29) $colspanTanggal = 58;
else if($inc == 28) $colspanTanggal = 56;
else if($inc == 30) $colspanTanggal = 60;
else if($inc == 31) $colspanTanggal = 62;
?>
<table border="1" class="table table-bordered table-sm">
    <tr>
        <th colspan="68" style="vertical-align: middle;text-align:center;text-transform:uppercase">LEMBAR PEMANTAUAN PASIEN YANG KATETER<br>BULAN <?= $bulanCetak . ' ' . $tahun ?></th>
    </tr>
    <tr>
        <td>Ruangan</td>
        <td>:</td>
        <td colspan="66"><?= $sqlRuangan['nama_ruangan'] ?></td>
    </tr>
    <tr>
        <th colspan="68"></th>
    </tr>
    <tr>
        <th rowspan="3" style="vertical-align: middle;text-align:center;">No</th>
        <th rowspan="3" style="vertical-align: middle;text-align:center;">Nama</th>
        <th colspan="<?= $colspanTanggal ?>" style="vertical-align: middle;text-align:center;">Tanggal</th>
        <th rowspan="3" style="vertical-align: middle;text-align:center;">Total JHC</th>
        <th rowspan="3" style="vertical-align: middle;text-align:center;">Total ISK</th>
        <th rowspan="3" style="vertical-align: middle;text-align:center;">Diagnosa dan Ket Plg</th>
    </tr>
    <tr>
        <?php for ($i = 1; $i <= $inc; $i++) echo "<th colspan='2' style='text-align:center'>" . $i . "</th>"; ?>
    </tr>
    <tr>
        <?php for ($i = 1; $i <= $inc; $i++) echo "<th align='center'>JHC</th><th align='center'>ISK</th>"; ?>
    </tr>
    <?php
    $arrAngkaKejadianPlebitis = [];
    $sql = "SELECT * FROM (SELECT * FROM (SELECT p.nama,p.no_rm,i.pasien_id,i.keterangan FROM ppi_kateter i LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = i.pasien_id WHERE MONTH(i.tanggal) = {$_REQUEST['bulan']} AND YEAR(i.tanggal) = {$_REQUEST['tahun']} AND ruangan = '{$_REQUEST['ruangan']}' ORDER BY i.tanggal DESC) as j GROUP BY pasien_id) as q ORDER BY nama";
    $data = $konek->rawQuery($sql);
    $no = 0;
    while ($rows = $data->fetch_assoc()) {
        $totalJhi = 0;
        $totalKp = 0;
        echo "<tr>";
            echo "<td>".++$no."</td>";
            echo "<td>" . $rows['nama'] . '/' . $rows['no_rm'] . "</td>";
            for ($i = 1; $i <= $inc; $i++) {
                $sql = "SELECT * FROM ppi_kateter WHERE YEAR(tanggal) = {$_REQUEST['tahun']} AND MONTH(tanggal) = {$_REQUEST['bulan']} AND DAY(tanggal) = {$i} AND pasien_id = {$rows['pasien_id']}";
                $dataOutput = $konek->rawQuery($sql)->fetch_assoc();
                $dataRows = $konek->rawQuery($sql)->num_rows;
                if($dataRows > 0){
                    echo "<td style='vertical-align: middle;text-align:center;'>".$dataOutput['jhc']."</td>";
                    echo "<td style='vertical-align: middle;text-align:center;'>".$dataOutput['kateter']."</td>";
                    $arrData[$i-1]['jhc'] += $dataOutput['jhc'];
                    $arrData[$i-1]['kateter'] += $dataOutput['kateter'];
                    $totalJhi += $dataOutput['jhc'];
                    $totalKp += $dataOutput['kateter'];
                }else{
                    echo "<td></td>";
                    echo "<td></td>";
                }
            }
            echo '<td>'.$totalJhi.'</td>';
            echo '<td>'.$totalKp.'</td>';
            echo "<td>".$rows['keterangan']."</td>";
        echo "</tr>";
    }
    echo '<tr>';
            echo '<td colspan="2" style="vertical-align: middle;text-align:center;">ISK</td>';
    $banyakKpJhi = 0;
    for($i = 0; $i < sizeof($arrData); $i++) {
            echo '<td>0</td>';
            echo '<td>'.$arrData[$i]['kateter'].'</td>';
            $banyakKpJhi+= ($arrData[$i]['kateter']);
    }
            echo '<td colspan="3" style="vertical-align: middle;text-align:center;">'.$banyakKpJhi.'</td>';
    echo '</tr>';

    echo '<tr>';
            echo '<td colspan="2" style="vertical-align: middle;text-align:center;">Jumlah hari kateter</td>';
    $banyakJhi = 0;
    for($i = 0; $i < sizeof($arrData); $i++) {
            echo '<td colspan="2" style="vertical-align: middle;text-align:center;">'.$arrData[$i]['jhc'].'</td>';
            $banyakJhi += $arrData[$i]['jhc'];
    }
            echo '<td colspan="3" style="vertical-align: middle;text-align:center;">'.$banyakJhi.'</td>';
    echo '</tr>';

    echo '<tr>';
            echo '<td colspan="2" style="vertical-align: middle;text-align:center;">Jumlah Kejadian ISK</td>';
    $banyakKp = 0;
    for($i = 0; $i < sizeof($arrData); $i++) {
            echo '<td colspan="2" style="vertical-align: middle;text-align:center;">'.$arrData[$i]['kateter'].'</td>';
            $banyakKp += $arrData[$i]['kateter'];
    }
            echo '<td colspan="3" style="vertical-align: middle;text-align:center;">'.$banyakKp.'</td>';
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

