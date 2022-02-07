<?php
include '../autoload.php';
include '../templates/headerlap.php';

$konek = new Connection();
$id_pasien = $_REQUEST['id_pasien'];
$id_kunjungan = $_REQUEST['id_kunjungan'];

$dataRuangan = $konek->rawQuery("SELECT
nm.nama_ruangan,
p.nama,
p.tgl_lahir,
p.no_rm
FROM
ppi_perkembangan_pasien_terintegrasi pi
INNER JOIN ppi_ruangan nm ON nm.id = pi.id_ruangan
LEFT JOIN rspelindo_billing.b_ms_pasien p ON p.id = pi.id_pasien
WHERE
id_kunjungan = {$id_kunjungan}")->fetch_assoc();

function tr($label, $val)
{
    $html = '<tr">';
    $html .= '<th align="left" width="10%">' . $label . '</th>';
    $html .= '<td align="left">:</td>';
    $html .= '<td align="left">' . $val . '</td>';
    $html .= '</tr>';

    return $html;
}

function tr2($label, $val)
{
    $html = '<tr>';
    $html .= '<th align="left">' . $label . '</th>';
    $html .= '<td align="left">:</td>';
    $html .= '<td align="left">' . $val . '</td>';
    $html .= '</tr>';
    return $html;
}

function convertTanggal($val)
{
    if ($val == '') {
        return $val;
    }
    $date = explode('-', $val);
    $tanggal = $date[2] . '/' . $date[1] . '/' . $date[0];
    return $tanggal;
}

function jamMulai($val)
{
    $jam = explode(' ', $val);
    $jamBalik = $jam[1];
    return $jamBalik;
}

function tglMulai($val)
{
    $date = explode(' ', $val);
    $dateBalik = explode('-', $date[0]);
    $dateReturn = $dateBalik[2] . '/' . $dateBalik[1] . '/' . $dateBalik[0];
    return $dateReturn;
}

$suhu = explode('|', $data['suhu']);

//Riwayat Penyakit Keluarga
$rw_keluarga = explode('|', $data['riwayat_penyakit_keluarga']);
$keluarga = '';
$rw_keluarga = removeJikaKosong($rw_keluarga);
for ($i = 0; $i < sizeof($rw_keluarga); $i++) {
    $keluarga .= $i == sizeof($rw_keluarga) - 1 ? $rw_keluarga[$i] : $rw_keluarga[$i] . ', ';
}

function removeJikaKosong($data)
{
    $arrTemp = [];
    for ($i = 0; $i < sizeof($data); $i++) {
        if ($data[$i] == "") {
            continue;
        } else {
            array_push($arrTemp, $data[$i]);
        }
    }
    return $arrTemp;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;

        }

        table th,
        td {
            border-collapse: collapse;
        }
    </style>
    <script src="../html2pdf/ppdf.js"></script>
    <script src="../html2pdf/pdf.js"></script>
</head>

<body id="pdf-area">
    <table style="width:100%">
        <tr>
            <td>
                <img src="../logors1.png" alt="" style="height : 70px; width:220px;">
            </td>
            <td align="right">
                <table style="border:1px solid;">
                    <?= tr2('Nama', $dataRuangan['nama']) ?>
                    <?= tr2('Tgl.Lahir', convertTanggal($dataRuangan['tgl_lahir']) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $data['sex']) ?>
                    <?= tr2('No.RM', $dataRuangan['no_rm']) ?>
                </table>
            </td>
        </tr>
    </table>
    <hr>
    <hr>
    <table style="width: 100%;">
        <tr>
            <td style="text-align: center;">
                <b>CATATAN PERKEMBANGAN PASIEN TERINTEGRASI</b>
            </td>
        </tr>
    </table>
    <br>
    <br>
    <table style="width: 100%;">
        <tr>
            <td width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Halaman ke : </td>
            <td width="50%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ruangan : <?= $dataRuangan['nama_ruangan'] ?></td>
        </tr>
    </table>
    <br>
    <table border="1" class="table table-bordered">
        <tr>
            <th class="text-center">Tanggal dan Waktu</th>
            <th class="text-center">Profesional Pemberi Asuhan</th>
            <th class="text-center">HASIL ASESMEN-IAR PENATALAKSANAAN PASIEN</th>
            <th class="text-center">INSTRUKSI PPA TERMASUK PASKA BEDAH</th>
            <th class="text-center">REVIEW & VERIFIKASI DPJP</th>
        </tr>
        <?php
        $sql = "SELECT * FROM ppi_perkembangan_pasien_terintegrasi WHERE id_pasien = {$id_pasien} AND id_kunjungan = {$id_kunjungan}";
        $data = $konek->rawQuery($sql);
        while ($rows = $data->fetch_assoc()) {
            echo "<tr>";
                echo "<td>" . $rows['tanggal'] . "</td>";
                echo "<td>" . $rows['pemberi_asuhan'] . "</td>";
                echo '<td>S = ' . $rows['s'] . '<br>O = ' . $rows['o'] . '<br>A= ' . $rows['a'] . '<br>P = ' . $rows['p'] . '</td>';
                echo '<td>' . $rows['instruksi_ppa'] . '</td>';
                echo '<td>' . $rows['review_verifikasi_dpjp'] . '</td>';
            echo "<tr>";
        }
        ?>
    </table>
    <script>
        <?php if (isset($_REQUEST["pdf"])) : ?>
            let identifier = '<?= $data['nama'] ?>';
            printPDF('RM 2.2 ' + identifier);
        <?php else : ?>
            window.print();
        <?php endif; ?>
    </script>
</body>

</html>