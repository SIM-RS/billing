<?php
include '../../autoload.php';
include '../../templates/headerlap.php';

$konek = new Connection();

$tahun = $_REQUEST['tahun'];
$bulan = $bulanData[$_REQUEST['bulan']];
$bln = 1;
if ($_REQUEST['act'] == "excell") {
    header("Content-type: application/vnd.ms-excel");
    header('Content-Disposition: attachment; filename="EVALUASI ATAU ANALISA SURVEY PELAKSANAAN KEPATUHAN CUCI TANGAN' . $bulanData[$_REQUEST['bulan']] . ' ' . $_REQUEST['tahun'] . '.xlsx"');
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
$row = 1;
$dateAwal = setDate(1,$_REQUEST['bulan'],$tahun);
$dateAkhir = setDate(6,$_REQUEST['bulan'],$tahun);

$dateAwal2 = setDate(7,$_REQUEST['bulan'],$tahun);
$dateAkhir2 = setDate(12,$_REQUEST['bulan'],$tahun);

$dateAwal3 = setDate(13,$_REQUEST['bulan'],$tahun);
$dateAkhir3 = setDate(18,$_REQUEST['bulan'],$tahun);

$dateAwal4 = setDate(19,$_REQUEST['bulan'],$tahun);
$dateAkhir4 = setDate(24,$_REQUEST['bulan'],$tahun);

$dateAwal5 = setDate(25,$_REQUEST['bulan'],$tahun);
$dateAkhir5 = setDate(30,$_REQUEST['bulan'],$tahun);

$dateAwal6 = setDate(31,$_REQUEST['bulan'],$tahun);
// $dateAkhir6 = setDate(30,$_REQUEST['bulan'],$tahun);
$id_petugas = $_REQUEST['id_petugas'];
?>

<style>
    .tengah {
        vertical-align: middle;
        text-align: center;
    }
</style>
<h3 style="text-align:center">
    EVALUASI ATAU ANALISA SURVEY PELAKSANAAN KEPATUHAN CUCI TANGAN
</h3>
<table border="1" class="table table-bordered table-sm">
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal}' 
            AND '{$dateAkhir}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                echo "<td colspan='2'>Nama  / Ruangan : ".$rows['ruangan']."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal}' 
            AND '{$dateAkhir}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                echo "<td colspan='2'>Tgl Survey : ".$rows['tgl_survey']."</td>";
            }
        ?>
    </tr>
    <tr>
        <th class="tengah" rowspan='2'>NO</th>
        <th class="tengah" rowspan='2'>ASPEK YG DINILAI</th>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal}' 
            AND '{$dateAkhir}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                echo    "<th colspan='2' class='text-center'>"
                        .explode("-", $rows["tgl_survey"])[2].
                        "</th>";
                $bln++;
            }
        ?>
    </tr>
    <tr>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal}' 
            AND '{$dateAkhir}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                echo    "<td class='text-center'>Ya</td>
                        <td class='text-center'>Tidak</td>";
            }
        ?>
        
    </tr>
    <tr>
        <td>1</td>
        <td>Kepatuhan Cuci Tangan</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal}' 
            AND '{$dateAkhir}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[0]."</td>";
                echo    "<td class='text-center'>".$tidak[0]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>2</td>
        <td>Sebelum kontak dengan pasien (n=10)</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal}' 
            AND '{$dateAkhir}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[1]."</td>";
                echo    "<td class='text-center'>".$tidak[1]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>3</td>
        <td>Setelah kontak dengan pasien (n=10)</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal}' 
            AND '{$dateAkhir}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[2]."</td>";
                echo    "<td class='text-center'>".$tidak[2]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>4</td>
        <td>Sebelum tindakan aseptic (n=10)</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal}' 
            AND '{$dateAkhir}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[3]."</td>";
                echo    "<td class='text-center'>".$tidak[3]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>5</td>
        <td>Setelah kontak dengan cairan tubuh </td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal}' 
            AND '{$dateAkhir}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[4]."</td>";
                echo    "<td class='text-center'>".$tidak[4]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>6</td>
        <td>Setelah kontak dengan lingkungan pasien</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal}' 
            AND '{$dateAkhir}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[5]."</td>";
                echo    "<td class='text-center'>".$tidak[5]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td class="text-center" colspan="2">Total</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal}' 
            AND '{$dateAkhir}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);$yaTotal=0;
                $tidak = explode("|", $rows["tidak"]);$tidakTotal=0;
                for ($i = 0; $i < 6; $i++) {
                    $yaTotal += $ya[$i];
                    $tidakTotal += $tidak[$i];
                }
                echo    "<th class='text-center'>".$yaTotal."</th>";
                echo    "<th class='text-center'>".$tidakTotal."</th>";
            }
        ?>
    </tr>
</table>

<br><br>

<table border="1" class="table table-bordered table-sm">
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal2}' 
            AND '{$dateAkhir2}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                echo "<td colspan='2'>Nama  / Ruangan : ".$rows['ruangan']."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal2}' 
            AND '{$dateAkhir2}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                echo "<td colspan='2'>Tgl Survey : ".$rows['tgl_survey']."</td>";
            }
        ?>
    </tr>
    <tr>
        <th class="tengah" rowspan='2'>NO</th>
        <th class="tengah" rowspan='2'>ASPEK YG DINILAI</th>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal2}' 
            AND '{$dateAkhir2}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                echo    "<th colspan='2' class='text-center'>"
                        .explode("-", $rows["tgl_survey"])[2].
                        "</th>";
                $bln++;
            }
        ?>
    </tr>
    <tr>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal2}' 
            AND '{$dateAkhir2}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                echo    "<td class='text-center'>Ya</td>
                        <td class='text-center'>Tidak</td>";
            }
        ?>
        
    </tr>
    <tr>
        <td>1</td>
        <td>Kepatuhan Cuci Tangan</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal2}' 
            AND '{$dateAkhir2}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[0]."</td>";
                echo    "<td class='text-center'>".$tidak[0]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>2</td>
        <td>Sebelum kontak dengan pasien (n=10)</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal2}' 
            AND '{$dateAkhir2}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[1]."</td>";
                echo    "<td class='text-center'>".$tidak[1]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>3</td>
        <td>Setelah kontak dengan pasien (n=10)</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal2}' 
            AND '{$dateAkhir2}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[2]."</td>";
                echo    "<td class='text-center'>".$tidak[2]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>4</td>
        <td>Sebelum tindakan aseptic (n=10)</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal2}' 
            AND '{$dateAkhir2}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[3]."</td>";
                echo    "<td class='text-center'>".$tidak[3]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>5</td>
        <td>Setelah kontak dengan cairan tubuh </td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal2}' 
            AND '{$dateAkhir2}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[4]."</td>";
                echo    "<td class='text-center'>".$tidak[4]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>6</td>
        <td>Setelah kontak dengan lingkungan pasien</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal2}' 
            AND '{$dateAkhir2}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[5]."</td>";
                echo    "<td class='text-center'>".$tidak[5]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td class="text-center" colspan="2">Total</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal2}' 
            AND '{$dateAkhir2}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);$yaTotal=0;
                $tidak = explode("|", $rows["tidak"]);$tidakTotal=0;
                for ($i = 0; $i < 6; $i++) {
                    $yaTotal += $ya[$i];
                    $tidakTotal += $tidak[$i];
                }
                echo    "<th class='text-center'>".$yaTotal."</th>";
                echo    "<th class='text-center'>".$tidakTotal."</th>";
            }
        ?>
    </tr>
</table>

<br><br>

<table border="1" class="table table-bordered table-sm">
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal3}' 
            AND '{$dateAkhir3}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                echo "<td colspan='2'>Nama  / Ruangan : ".$rows['ruangan']."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal3}' 
            AND '{$dateAkhir3}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                echo "<td colspan='2'>Tgl Survey : ".$rows['tgl_survey']."</td>";
            }
        ?>
    </tr>
    <tr>
        <th class="tengah" rowspan='2'>NO</th>
        <th class="tengah" rowspan='2'>ASPEK YG DINILAI</th>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal3}' 
            AND '{$dateAkhir3}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                echo    "<th colspan='2' class='text-center'>"
                        .explode("-", $rows["tgl_survey"])[2].
                        "</th>";
                $bln++;
            }
        ?>
    </tr>
    <tr>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal3}' 
            AND '{$dateAkhir3}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                echo    "<td class='text-center'>Ya</td>
                        <td class='text-center'>Tidak</td>";
            }
        ?>
        
    </tr>
    <tr>
        <td>1</td>
        <td>Kepatuhan Cuci Tangan</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal3}' 
            AND '{$dateAkhir3}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[0]."</td>";
                echo    "<td class='text-center'>".$tidak[0]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>2</td>
        <td>Sebelum kontak dengan pasien (n=10)</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal3}' 
            AND '{$dateAkhir3}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[1]."</td>";
                echo    "<td class='text-center'>".$tidak[1]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>3</td>
        <td>Setelah kontak dengan pasien (n=10)</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal3}' 
            AND '{$dateAkhir3}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[2]."</td>";
                echo    "<td class='text-center'>".$tidak[2]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>4</td>
        <td>Sebelum tindakan aseptic (n=10)</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal3}' 
            AND '{$dateAkhir3}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[3]."</td>";
                echo    "<td class='text-center'>".$tidak[3]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>5</td>
        <td>Setelah kontak dengan cairan tubuh </td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal3}' 
            AND '{$dateAkhir3}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[4]."</td>";
                echo    "<td class='text-center'>".$tidak[4]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>6</td>
        <td>Setelah kontak dengan lingkungan pasien</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal3}' 
            AND '{$dateAkhir3}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[5]."</td>";
                echo    "<td class='text-center'>".$tidak[5]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td class="text-center" colspan="2">Total</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal3}' 
            AND '{$dateAkhir3}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);$yaTotal=0;
                $tidak = explode("|", $rows["tidak"]);$tidakTotal=0;
                for ($i = 0; $i < 6; $i++) {
                    $yaTotal += $ya[$i];
                    $tidakTotal += $tidak[$i];
                }
                echo    "<th class='text-center'>".$yaTotal."</th>";
                echo    "<th class='text-center'>".$tidakTotal."</th>";
            }
        ?>
    </tr>
</table>

<br><br>

<table border="1" class="table table-bordered table-sm">
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal4}' 
            AND '{$dateAkhir4}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                echo "<td colspan='2'>Nama  / Ruangan : ".$rows['ruangan']."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal4}' 
            AND '{$dateAkhir4}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                echo "<td colspan='2'>Tgl Survey : ".$rows['tgl_survey']."</td>";
            }
        ?>
    </tr>
    <tr>
        <th class="tengah" rowspan='2'>NO</th>
        <th class="tengah" rowspan='2'>ASPEK YG DINILAI</th>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal4}' 
            AND '{$dateAkhir4}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                echo    "<th colspan='2' class='text-center'>"
                        .explode("-", $rows["tgl_survey"])[2].
                        "</th>";
                $bln++;
            }
        ?>
    </tr>
    <tr>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal4}' 
            AND '{$dateAkhir4}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                echo    "<td class='text-center'>Ya</td>
                        <td class='text-center'>Tidak</td>";
            }
        ?>
        
    </tr>
    <tr>
        <td>1</td>
        <td>Kepatuhan Cuci Tangan</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal4}' 
            AND '{$dateAkhir4}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[0]."</td>";
                echo    "<td class='text-center'>".$tidak[0]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>2</td>
        <td>Sebelum kontak dengan pasien (n=10)</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal4}' 
            AND '{$dateAkhir4}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[1]."</td>";
                echo    "<td class='text-center'>".$tidak[1]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>3</td>
        <td>Setelah kontak dengan pasien (n=10)</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal4}' 
            AND '{$dateAkhir4}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[2]."</td>";
                echo    "<td class='text-center'>".$tidak[2]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>4</td>
        <td>Sebelum tindakan aseptic (n=10)</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal4}' 
            AND '{$dateAkhir4}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[3]."</td>";
                echo    "<td class='text-center'>".$tidak[3]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>5</td>
        <td>Setelah kontak dengan cairan tubuh </td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal4}' 
            AND '{$dateAkhir4}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[4]."</td>";
                echo    "<td class='text-center'>".$tidak[4]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>6</td>
        <td>Setelah kontak dengan lingkungan pasien</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal4}' 
            AND '{$dateAkhir4}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[5]."</td>";
                echo    "<td class='text-center'>".$tidak[5]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td class="text-center" colspan="2">Total</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal4}' 
            AND '{$dateAkhir4}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);$yaTotal=0;
                $tidak = explode("|", $rows["tidak"]);$tidakTotal=0;
                for ($i = 0; $i < 6; $i++) {
                    $yaTotal += $ya[$i];
                    $tidakTotal += $tidak[$i];
                }
                echo    "<th class='text-center'>".$yaTotal."</th>";
                echo    "<th class='text-center'>".$tidakTotal."</th>";
            }
        ?>
    </tr>
</table>

<br><br>

<table border="1" class="table table-bordered table-sm">
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal5}' 
            AND '{$dateAkhir5}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                echo "<td colspan='2'>Nama  / Ruangan : ".$rows['ruangan']."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal5}' 
            AND '{$dateAkhir5}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                echo "<td colspan='2'>Tgl Survey : ".$rows['tgl_survey']."</td>";
            }
        ?>
    </tr>
    <tr>
        <th class="tengah" rowspan='2'>NO</th>
        <th class="tengah" rowspan='2'>ASPEK YG DINILAI</th>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal5}' 
            AND '{$dateAkhir5}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                echo    "<th colspan='2' class='text-center'>"
                        .explode("-", $rows["tgl_survey"])[2].
                        "</th>";
                $bln++;
            }
        ?>
    </tr>
    <tr>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal5}' 
            AND '{$dateAkhir5}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                echo    "<td class='text-center'>Ya</td>
                        <td class='text-center'>Tidak</td>";
            }
        ?>
        
    </tr>
    <tr>
        <td>1</td>
        <td>Kepatuhan Cuci Tangan</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal5}' 
            AND '{$dateAkhir5}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[0]."</td>";
                echo    "<td class='text-center'>".$tidak[0]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>2</td>
        <td>Sebelum kontak dengan pasien (n=10)</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal5}' 
            AND '{$dateAkhir5}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[1]."</td>";
                echo    "<td class='text-center'>".$tidak[1]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>3</td>
        <td>Setelah kontak dengan pasien (n=10)</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal5}' 
            AND '{$dateAkhir5}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[2]."</td>";
                echo    "<td class='text-center'>".$tidak[2]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>4</td>
        <td>Sebelum tindakan aseptic (n=10)</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal5}' 
            AND '{$dateAkhir5}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[3]."</td>";
                echo    "<td class='text-center'>".$tidak[3]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>5</td>
        <td>Setelah kontak dengan cairan tubuh </td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal5}' 
            AND '{$dateAkhir5}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[4]."</td>";
                echo    "<td class='text-center'>".$tidak[4]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>6</td>
        <td>Setelah kontak dengan lingkungan pasien</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal5}' 
            AND '{$dateAkhir5}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[5]."</td>";
                echo    "<td class='text-center'>".$tidak[5]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td class="text-center" colspan="2">Total</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey BETWEEN '{$dateAwal5}' 
            AND '{$dateAkhir5}' ORDER BY tgl_survey");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);$yaTotal=0;
                $tidak = explode("|", $rows["tidak"]);$tidakTotal=0;
                for ($i = 0; $i < 6; $i++) {
                    $yaTotal += $ya[$i];
                    $tidakTotal += $tidak[$i];
                }
                echo    "<th class='text-center'>".$yaTotal."</th>";
                echo    "<th class='text-center'>".$tidakTotal."</th>";
            }
        ?>
    </tr>
</table>

<br><br>

<table border="1" class="table table-bordered table-sm">
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey AND tgl_survey = '{$dateAwal6}'");

            while($rows = $dataPasien->fetch_assoc()){
                echo "<td colspan='2'>Nama  / Ruangan : ".$rows['ruangan']."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey AND tgl_survey = '{$dateAwal6}'");

            while($rows = $dataPasien->fetch_assoc()){
                echo "<td colspan='2'>Tgl Survey : ".$rows['tgl_survey']."</td>";
            }
        ?>
    </tr>
    <tr>
        <th class="tengah" rowspan='2'>NO</th>
        <th class="tengah" rowspan='2'>ASPEK YG DINILAI</th>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey AND tgl_survey = '{$dateAwal6}'");

            while($rows = $dataPasien->fetch_assoc()){
                echo    "<th colspan='2' class='text-center'>"
                        .explode("-", $rows["tgl_survey"])[2].
                        "</th>";
                $bln++;
            }
        ?>
    </tr>
    <tr>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey AND tgl_survey = '{$dateAwal6}'");

            while($rows = $dataPasien->fetch_assoc()){
                echo    "<td class='text-center'>Ya</td>
                        <td class='text-center'>Tidak</td>";
            }
        ?>
        
    </tr>
    <tr>
        <td>1</td>
        <td>Kepatuhan Cuci Tangan</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey AND tgl_survey = '{$dateAwal6}'");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[0]."</td>";
                echo    "<td class='text-center'>".$tidak[0]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>2</td>
        <td>Sebelum kontak dengan pasien (n=10)</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey AND tgl_survey = '{$dateAwal6}'");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[1]."</td>";
                echo    "<td class='text-center'>".$tidak[1]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>3</td>
        <td>Setelah kontak dengan pasien (n=10)</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey AND tgl_survey = '{$dateAwal6}'");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[2]."</td>";
                echo    "<td class='text-center'>".$tidak[2]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>4</td>
        <td>Sebelum tindakan aseptic (n=10)</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey AND tgl_survey = '{$dateAwal6}'");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[3]."</td>";
                echo    "<td class='text-center'>".$tidak[3]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>5</td>
        <td>Setelah kontak dengan cairan tubuh </td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey AND tgl_survey = '{$dateAwal6}'");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[4]."</td>";
                echo    "<td class='text-center'>".$tidak[4]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td>6</td>
        <td>Setelah kontak dengan lingkungan pasien</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey AND tgl_survey = '{$dateAwal6}'");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);
                $tidak = explode("|", $rows["tidak"]);
                echo    "<td class='text-center'>".$ya[5]."</td>";
                echo    "<td class='text-center'>".$tidak[5]."</td>";
            }
        ?>
    </tr>
    <tr>
        <td class="text-center" colspan="2">Total</td>
        <?php
            $dataPasien = $konek->rawQuery("SELECT 
            ppi_ruangan.nama_ruangan AS ruangan, 
            ppi_evaluasi_cuci_tangan.* 
            FROM ppi_evaluasi_cuci_tangan 
            LEFT JOIN ppi_ruangan ON ppi_ruangan.id = ppi_evaluasi_cuci_tangan.id_ruangan 
            WHERE ppi_evaluasi_cuci_tangan.id_petugas = '{$id_petugas}' 
            AND ppi_evaluasi_cuci_tangan.tgl_survey AND tgl_survey = '{$dateAwal6}'");

            while($rows = $dataPasien->fetch_assoc()){
                $ya = explode("|", $rows["ya"]);$yaTotal=0;
                $tidak = explode("|", $rows["tidak"]);$tidakTotal=0;
                for ($i = 0; $i < 6; $i++) {
                    $yaTotal += $ya[$i];
                    $tidakTotal += $tidak[$i];
                }
                echo    "<th class='text-center'>".$yaTotal."</th>";
                echo    "<th class='text-center'>".$tidakTotal."</th>";
            }
        ?>
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