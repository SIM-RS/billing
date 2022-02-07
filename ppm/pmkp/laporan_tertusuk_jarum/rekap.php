<?php
include '../../autoload.php';
include '../../templates/headerlap.php';

$konek = new Connection();

$tahun = $_REQUEST['tahun'];
$bulan = $bulanData[$_REQUEST['bulan']];

if ($_REQUEST['act'] == "excell") {
    header("Content-type: application/vnd.ms-excel");
    header('Content-Disposition: attachment; filename="LAPORAN ANGKA KEJADIAN PETUGAS TERTUSUK JARUM' . $bulanData[$_REQUEST['bulan']] . ' ' . $_REQUEST['tahun'] . '.xlsx"');
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

$id_ruangan = $_REQUEST['id_ruangan'];
$nama_ruangan = $konek->rawQuery("SELECT 
    nama_ruangan 
    FROM
    ppi_ruangan 
    WHERE id = '{$id_ruangan}'");

?>

<style>
    .tengah {
        vertical-align: middle;
        text-align: center;
    }
</style>
<h3 style="text-align:center">
    LAPORAN ANGKA KEJADIAN PETUGAS TERTUSUK JARUM 
    <br> (NEEDLE STICK INJURY)
    <br> RUMAH SAKIT UMUM ANDHIKA
</h3>
UNIT/RUANGAN : <?= $nama_ruangan->fetch_assoc()["nama_ruangan"]; ?>
<table border="1" class="table table-bordered table-sm">
    <tr>
        <th class="tengah">NO</th>
        <th class="tengah">TGL KEJADIAN</th>
        <th class="tengah">JAM KEJADIAN</th>
        <th class="tengah">NAMA PETUGAS</th>
        <th class="tengah">JENIS KEJADIAN</th>
        <th class="tengah">AREA YANG TERTUSUK</th>
        <th class="tengah">TINDAK LANJUT</th>
    </tr>
    <?php
    $dateAwal = setDate(1,$_REQUEST['bulan'],$tahun);
    $dateAkhir = setDate(15,$_REQUEST['bulan'],$tahun);
    $dataPasien = $konek->rawQuery("SELECT 
    ppi_ruangan.nama_ruangan AS ruangan, 
    rspelindo_billing.b_ms_pegawai.nama AS nama_petugas, 
    ppi_laporan_tertusuk_jarum.* 
    FROM ppi_laporan_tertusuk_jarum 
    LEFT JOIN rspelindo_billing.b_ms_pegawai ON  rspelindo_billing.b_ms_pegawai.id = ppi_laporan_tertusuk_jarum.id_petugas 
    LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_laporan_tertusuk_jarum.id_ruangan WHERE ppi_laporan_tertusuk_jarum.id_ruangan = '{$id_ruangan}' AND ppi_laporan_tertusuk_jarum.tgl_kejadian BETWEEN '{$dateAwal}' AND '{$dateAkhir}'");

    $no = 0;
    while($rows = $dataPasien->fetch_assoc()){
        echo "<tr>";
            echo "<td>".++$no."</td>";
            echo "<td>".$rows['tgl_kejadian']."</td>";
            echo "<td>".$rows['jam_kejadian']."</td>";
            echo "<td>".$rows['nama_petugas']."</td>";
            echo "<td>".$rows['jenis_kejadian']."</td>";
            echo "<td>".$rows['area']."</td>";
            echo "<td>".$rows['tindak']."</td>";
        echo "</tr>";
    }
    ?>
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