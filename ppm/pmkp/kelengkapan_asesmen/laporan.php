<?php
include '../../autoload.php';
include '../../templates/headerlap.php';

$konek = new Connection();

$tahun = $_REQUEST['tahun'];
$bulan = $bulanData[$_REQUEST['bulan']];
$ruangan = $_REQUEST['ruangan'];

//get Ruangan
$data = $konek->rawQuery("SELECT nama_ruangan FROM ppi_ruangan WHERE id = {$ruangan}")->fetch_assoc();

if ($_REQUEST['act'] == "excell") {
    header("Content-type: application/vnd.ms-excel");
    header('Content-Disposition: attachment; filename="LAP KELENGKAPAN ASESMEN ' . $bulanData[$_REQUEST['bulan']] . ' ' . $_REQUEST['tahun'] . '.xlsx"');
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
        <th class="tengah" colspan="36">KELENGKAPAN ASSESMENT 1X24 JAM PASIEN RAWAT INAP RSU PRIMA</th>
    </tr>
    <tr>
        <th class="tengah" colspan="36">TAHUN <?= $tahun ?></th>
    </tr>
    <tr><?php getTd(36) ?></tr>
    <tr>
        <td colspan="2">UNIT/RUANGAN</td>
        <td colspan="3"><?= $data['nama_ruangan'] ?></td>
        <?php getTd(31) ?>
    </tr>
    <tr>
        <th class="tengah" rowspan="4">No</th>
        <th class="tengah" rowspan="4">Nama Pasien</th>
        <th class="tengah" rowspan="4">No. RM</th>
        <th class="tengah" rowspan="4">Nama DPJP</th>
        <th class="tengah" rowspan="4">Tanggal Masuk Rawat</th>
        <th class="tengah" rowspan="4">Tanggal Pulang</th>
        <th class="tengah" colspan="30">Bulan : <?= $bulan ?></th>
    </tr>
    <tr>
        <?php getTd(15, 2, true) ?>
    </tr>
    <tr>
        <?php getTd(15, 2, false, 'REKAM MEDIS') ?>
    </tr>
    <tr>
        <?php getTdKedua(15, 0, ['LENGKAP', 'TDK LENGKAP']) ?>
    </tr>
    <?php
    $dateAwal = setDate(1,$_REQUEST['bulan'],$tahun);
    $dateAkhir = setDate(15,$_REQUEST['bulan'],$tahun);
    $dataPasien = $konek->rawQuery("SELECT
        p.nama Nama_Pasien,
        p.no_rm No_Rm,
        pe.nama as Nama_Dokter,
        k.tgl Tanggal_Masuk,
        k.tgl_pulang as Tanggal_Pulang,
        pa.tanggal_pemantauan,
        pa.pilihan as Diagnosa
    FROM
        rspelindo_billing.b_kunjungan k
        INNER JOIN ppi_kelengkapan_asesmen pa ON pa.id_kunjungan = k.id
        LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = pa.id_pasien
        LEFT JOIN rspelindo_billing.b_ms_pegawai pe ON pe.id = pa.id_dokter
    WHERE
        pa.id_ruangan = {$ruangan} AND pa.tanggal_pemantauan BETWEEN '{$dateAwal}' AND '{$dateAkhir}'");
    $no = 0;
    while($rows = $dataPasien->fetch_assoc()){
        echo "<tr>";
            echo "<td>".++$no."</td>";
            echo "<td>".$rows['Nama_Pasien']."</td>";
            echo "<td>".$rows['No_Rm']."</td>";
            echo "<td>".$rows['Nama_Dokter']."</td>";
            echo "<td>".$rows['Tanggal_Masuk']."</td>";
            echo "<td>".$rows['Tanggal_Pulang']."</td>";
            for($i = 1; $i <= 15; $i++){
                $bulanFilter = sprintf("%02d", $_REQUEST['bulan']);
$date = setDate($i,$bulanFilter,$tahun);
                if($rows['tanggal_pemantauan'] == $date){
                    if($rows['Diagnosa'] == 'lengkap'){
                        echo "<td>Lengkap</td>";
                        echo "<td></td>";
                    }else{
                        echo "<td></td>";
                        echo "<td>Tidak Lengkap</td>";
                    }
                }else{
                    echo "<td></td>";
                    echo "<td></td>";
                }
            }
        echo "</tr>";
    }
    ?>
    <tr><?php getTd(1, 36) ?></tr>
    <tr><?php getTd(1, 36) ?></tr>
</table>

<table border="1" class="table table-bordered table-sm">
    <tr>
        <th class="tengah" colspan="36">KELENGKAPAN ASSESMENT 1X24 JAM PASIEN RAWAT INAP RSU PRIMA</th>
    </tr>
    <tr>
        <th class="tengah" colspan="36">TAHUN <?= $tahun ?></th>
    </tr>
    <tr><?php getTd(36) ?></tr>
    <tr>
        <td colspan="2">UNIT/RUANGAN</td>
        <td colspan="3"><?= $data['nama_ruangan'] ?></td>
        <?php getTd(31) ?>
    </tr>
    <tr>
        <th class="tengah" rowspan="4">No</th>
        <th class="tengah" rowspan="4">Nama Pasien</th>
        <th class="tengah" rowspan="4">No. RM</th>
        <th class="tengah" rowspan="4">Nama DPJP</th>
        <th class="tengah" rowspan="4">Tanggal Masuk Rawat</th>
        <th class="tengah" rowspan="4">Tanggal Pulang</th>
        <th class="tengah" colspan="30">Bulan : <?= $bulan ?></th>
    </tr>
    <tr>
        <?php rangeTd(2, 16, $inc) ?>
    </tr>
    <tr>
        <?php getTd(15, 2, false, 'REKAM MEDIS') ?>
    </tr>
    <tr>
        <?php getTdKedua(15, 0, ['LENGKAP', 'TDK LENGKAP']) ?>
    </tr>
    <?php
    $dateAwal = setDate(16,$_REQUEST['bulan'],$tahun);
    $dateAkhir = setDate($inc,$_REQUEST['bulan'],$tahun);
    $dataPasien = $konek->rawQuery("SELECT
        p.nama Nama_Pasien,
        p.no_rm No_Rm,
        pe.nama as Nama_Dokter,
        k.tgl Tanggal_Masuk,
        k.tgl_pulang as Tanggal_Pulang,
        pa.tanggal_pemantauan,
        pa.pilihan as Diagnosa
    FROM
        rspelindo_billing.b_kunjungan k
        INNER JOIN ppi_kelengkapan_asesmen pa ON pa.id_kunjungan = k.id
        LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = pa.id_pasien
        LEFT JOIN rspelindo_billing.b_ms_pegawai pe ON pe.id = pa.id_dokter
    WHERE
        pa.id_ruangan = {$ruangan} AND pa.tanggal_pemantauan BETWEEN '{$dateAwal}' AND '{$dateAkhir}'");
    $no = 0;
    while($rows = $dataPasien->fetch_assoc()){
        echo "<tr>";
            echo "<td>".++$no."</td>";
            echo "<td>".$rows['Nama_Pasien']."</td>";
            echo "<td>".$rows['No_Rm']."</td>";
            echo "<td>".$rows['Nama_Dokter']."</td>";
            echo "<td>".$rows['Tanggal_Masuk']."</td>";
            echo "<td>".$rows['Tanggal_Pulang']."</td>";
            for($i = 16; $i <= $inc; $i++){
                $bulanFilter = sprintf("%02d", $_REQUEST['bulan']);
$date = setDate($i,$bulanFilter,$tahun);
                if($rows['tanggal_pemantauan'] == $date){
                    if($rows['Diagnosa'] == 'lengkap'){
                        echo "<td>Lengkap</td>";
                        echo "<td></td>";
                    }else{
                        echo "<td></td>";
                        echo "<td>Tidak Lengkap</td>";
                    }
                }else{
                    echo "<td></td>";
                    echo "<td></td>";
                }
            }
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