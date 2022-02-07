<?php
include '../../autoload.php';
include '../../templates/headerlap.php';

$konek = new Connection();

$tahun = $_REQUEST['tahun'];
$bulan = $bulanData[$_REQUEST['bulan']];
$ruangan = $_REQUEST['ruangan'];


if ($_REQUEST['act'] == "excell") {
    header("Content-type: application/vnd.ms-excel");
    header('Content-Disposition: attachment; filename="ANGKA KEPUASAN PASIEN RAWAT INAP ' . $bulanData[$_REQUEST['bulan']] . ' ' . $_REQUEST['tahun'] . '.xlsx"');
}

$inc = 0;
if ($_REQUEST['bulan'] == 1 || $_REQUEST['bulan'] == 3 || $_REQUEST['bulan'] == 5 || $_REQUEST['bulan'] == 7 || $_REQUEST['bulan'] == 8 || $_REQUEST['bulan'] == 10 || $_REQUEST['bulan'] == 12) {
    $inc = 31;
} else if ($_REQUEST['bulan'] == 4 || $_REQUEST['bulan'] == 6 || $_REQUEST['bulan'] == 9 || $_REQUEST['bulan'] == 11) {
    $inc = 30;
} else if ($_REQUEST['bulan'] == 2) {
    if ($tahun % 100 == 0 && $tahun % 400 == 0 && $tahun % 4 == 0) {
        $inc = 29;
    } else {
        $inc = 28;
    }
}

?>

<style>
    .tengah {
        vertical-align: middle;
        text-align: center;
    }
</style>

<table border="1" class="table table-bordered table-sm">
    <tr>
        <th class="tengah" colspan="17">ANGKA KEPUASAN PASIEN RAWAT INAP RSU ANDHIKA</th>
    </tr>
    <tr>
        <?php getTd(17) ?>
    </tr>
    <tr>
        <th colspan="17">BULAN : <?= $bulan ?></th>
    </tr>
    <tr>
        <th class="tengah" rowspan="2" colspan="2">KEPUASAN</th>
        <th class="tengah" colspan="15">TANGGAL</th>
    </tr>
    <tr>
        <?php getTd(15,0,true) ?>
    </tr>
    <tr>
        <td colspan="2">YA</td>
        <?php 
            for($i = 1; $i <= 15; $i++){
                $bulanFilter = sprintf("%02d", $_REQUEST['bulan']);
$date = setDate($i,$bulanFilter,$tahun);
                $banyak = $konek->rawQuery("SELECT COUNT(id_pasien) AS banyak FROM ppi_kepuasan_pasien WHERE tanggal_pemantauan = '{$date}' AND pilihan = 'ya'")->fetch_assoc();
                echo '<td>'.$banyak['banyak'].'</td>';
            } 
        ?>
    </tr>
    <tr>
        <td colspan="2">TIDAK</td>
        <?php 
            for($i = 1; $i <= 15; $i++){
                $bulanFilter = sprintf("%02d", $_REQUEST['bulan']);
$date = setDate($i,$bulanFilter,$tahun);
                $banyak = $konek->rawQuery("SELECT COUNT(id_pasien) AS banyak FROM ppi_kepuasan_pasien WHERE tanggal_pemantauan = '{$date}' AND pilihan = 'tidak'")->fetch_assoc();
                echo '<td>'.$banyak['banyak'].'</td>';
            } 
        ?>
    </tr>
    <tr>
        <td colspan="2">TOTAL</td>
        <?php
            for($i = 1; $i <= 15; $i++){
                $bulanFilter = sprintf("%02d", $_REQUEST['bulan']);
$date = setDate($i,$bulanFilter,$tahun);
                $banyak1 = $konek->rawQuery("SELECT COUNT(id_pasien) AS banyak FROM ppi_kepuasan_pasien WHERE tanggal_pemantauan = '{$date}' AND pilihan = 'ya'")->fetch_assoc();
                $banyak2 = $konek->rawQuery("SELECT COUNT(id_pasien) AS banyak FROM ppi_kepuasan_pasien WHERE tanggal_pemantauan = '{$date}' AND pilihan = 'tidak'")->fetch_assoc();
                echo '<td>'.($banyak1['banyak'] + $banyak2['banyak']).'</td>';
            } 
        ?>
    </tr>
    <tr>
        <td colspan="17"><br></td>
    </tr>
    <tr>
        <td colspan="17"><br></td>
    </tr>
</table>

<table border="1" class="table table-bordered table-sm">
    <tr>
        <th colspan="17">Bulan : <?= $bulan ?></th>
    </tr>
    <tr>
        <th class="tengah" rowspan="2" colspan="2">KEPUASAN</th>
        <th class="tengah" colspan="15">Tanggal</th>
    </tr>
    <tr>
        <?php rangeTd(1,16,$inc) ?>
    </tr>
    <tr>
        <td colspan="2">YA</td>
        <?php 
            for($i = 16; $i <= $inc; $i++){
                $bulanFilter = sprintf("%02d", $_REQUEST['bulan']);
$date = setDate($i,$bulanFilter,$tahun);
                $banyak = $konek->rawQuery("SELECT COUNT(id_pasien) AS banyak FROM ppi_kepuasan_pasien WHERE tanggal_pemantauan = '{$date}' AND pilihan = 'ya'")->fetch_assoc();
                echo '<td>'.$banyak['banyak'].'</td>';
            } 
        ?>
    </tr>
    <tr>
        <td colspan="2">TIDAK</td>
        <?php 
            for($i = 16; $i <= $inc; $i++){
                $bulanFilter = sprintf("%02d", $_REQUEST['bulan']);
$date = setDate($i,$bulanFilter,$tahun);
                $banyak = $konek->rawQuery("SELECT COUNT(id_pasien) AS banyak FROM ppi_kepuasan_pasien WHERE tanggal_pemantauan = '{$date}' AND pilihan = 'tidak'")->fetch_assoc();
                echo '<td>'.$banyak['banyak'].'</td>';
            } 
        ?>
    </tr>
    <tr>
        <td colspan="2">TOTAL</td>
        <?php
            for($i = 16; $i <= $inc; $i++){
                $bulanFilter = sprintf("%02d", $_REQUEST['bulan']);
$date = setDate($i,$bulanFilter,$tahun);
                $banyak1 = $konek->rawQuery("SELECT COUNT(id_pasien) AS banyak FROM ppi_kepuasan_pasien WHERE tanggal_pemantauan = '{$date}' AND pilihan = 'ya'")->fetch_assoc();
                $banyak2 = $konek->rawQuery("SELECT COUNT(id_pasien) AS banyak FROM ppi_kepuasan_pasien WHERE tanggal_pemantauan = '{$date}' AND pilihan = 'tidak'")->fetch_assoc();
                echo '<td>'.($banyak1['banyak'] + $banyak2['banyak']).'</td>';
            } 
        ?>
    </tr>
    <tr>
        <td colspan="17"><br></td>
    </tr>
    <tr>
        <td colspan="17"><br></td>
    </tr>
</table>


<?php
include '../../templates/footer.php';
function getTd($banyak, $colspan = 0, $angka = false, $text = '')
{
    if ($text !== '')
        for ($i = 0; $i < $banyak; ++$i) echo '<td class="tengah" colspan="' . $colspan . '">' . $text . '</td>';
    else if ($angka == true && $text === '')
        for ($i = 1; $i <= $banyak; ++$i) echo '<td class="tengah" colspan="' . $colspan . '">' . $i . '</td>';
    else
        for ($i = 0; $i < $banyak; ++$i) echo '<td class="tengah" colspan="' . $colspan . '"><br></td>';
}
function getTdKedua($banyak, $colspan = 0, $text = [])
{
    for ($i = 0; $i < $banyak; ++$i) {
        for ($j = 0; $j < sizeof($text); ++$j)
            echo '<td class="tengah" colspan="' . $colspan . '">' . $text[$j] . '</td>';
    }
}
function rangeTd($colspan = 0, $angka1 = 0, $angka2 = 0)
{
    for ($i = $angka1; $i <= $angka2; ++$i) echo '<td class="tengah" colspan="' . $colspan . '">' . $i . '</td>';
}
function setDate($hari,$bulan,$tahun){
    return $tahun . '-' . $bulan . '-' . sprintf("%02d",$hari);
}
?>