<?php
include '../../autoload.php';
include '../../templates/headerlap.php';

$konek = new Connection();

$bulanAwal = $_REQUEST['bulan-awal'];
$bulanAkhir = $_REQUEST['bulan-akhir'];

$printOutPutPeriode = tanggalUbah($bulanAwal) . tanggalUbah($bulanAkhir); 

if ($_REQUEST['act'] == "excell") {
    header("Content-type: application/vnd.ms-excel");
    header('Content-Disposition: attachment; filename="REKAP INFEKSI OPERASI ' . $bulanData[$_REQUEST['bulan']] . ' ' . $_REQUEST['tahun'] . '.xlsx"');
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


<table class="table table-bordered table-sm">
    <tr>
        <th class="tengah" colspan="6">REKAP PENUNDAAN OPERASI ELEKTIF</th>
    </tr>
    <tr>
        <th class="tengah" colspan="6">RSU PRIMAs</th>
    </tr>
    <tr>
        <?php getTd(6) ?>
    </tr>
    <tr>
        <?php getTd(6) ?>
    </tr>
    <tr>
        <th colspan="2">PERIODE : <?= $printOutPutPeriode ?></th>
    </tr>
    <tr>
        <th rowspan="2">No</th>
        <th rowspan="2">Nama Pasien</th>
        <th rowspan="2">No Rm</th>
        <th rowspan="2">Jenis Operasi</th>
        <th colspan="2">Infeksi</th>
    </tr>
    <tr>
        <th>Ya</th>
        <th>Tidak</th>
    </tr>
    <?php
        $no = 0;
        $data = $konek->rawQuery("SELECT 
        p.nama,
        p.no_rm,
        pa.jenis_operasi,
        pa.pilihan
    FROM 
        ppi_infeksi_operasi_pmkp pa
        LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = pa.id_pasien
    WHERE
        pa.tanggal_pemantauan BETWEEN '{$bulanAwal}' AND '{$bulanAkhir}'");
        while($rows = $data->fetch_assoc()){
            echo "<tr>";
                echo "<td>".++$no."</td>";
                echo "<td>".$rows['nama']."</td>";
                echo "<td>".$rows['no_rm']."</td>";
                echo "<td>".$rows['jenis_operasi']."</td>";
                if($rows['pilihan'] == 'ya'){
                    echo "<td>ya</td>";
                    echo "<td></td>";
                }else{
                    echo "<td></td>";
                    echo "<td>tidak</td>";
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
function tanggalUbah($tgl){
    $tanggal = explode('-',$tgl);
    return $tanggal[2] . '/' . $tanggal[1] . '/' . $tanggal[0];
}
?>