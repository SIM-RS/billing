<?php
include("../../koneksi/konek.php");
include("../function/form.php");
// include("../sesi.php");

if (isset($_REQUEST['pdf'])) {
    $dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
    $sql = "SELECT
            pd.*,
            pa.*,
            k.tgl as tanggal_kunjungan,
            p.tgl as tanggal_pelayanan,
            u.nama as nama_tempat_layanan,
            peg.nama as nama_petugas,
            agama.agama as agama,
            ped.nama as pendidikam,
            pk.nama as pekerjaan,
            kw.nama as kewarganegaraan 
        FROM
            rm_2_3_p_anak pd
            LEFT JOIN b_kunjungan k ON k.id = pd.id_kunjungan
            LEFT JOIN b_pelayanan p ON p.id = pd.id_pelayanan
            LEFT JOIN b_ms_unit u ON u.id = p.unit_id
            LEFT JOIN b_ms_pegawai peg ON peg.id = pd.petugas_anamnesa
            LEFT JOIN b_ms_pasien pa ON pa.id = k.pasien_id
            LEFT JOIN b_ms_pendidikan ped ON pd.id = pa.pendidikan_id
            LEFT JOIN b_ms_agama as agama ON agama.id = pa.agama
            LEFT JOIN b_ms_pekerjaan as pk ON pk.id = pa.pekerjaan_id
            LEFT JOIN b_ms_kewarganegaraan as kw ON kw.id = pa.id_kw
        WHERE
            pd.id = {$_REQUEST['pdf']}";
$data = mysql_fetch_assoc(mysql_query($sql));

} else {
    $sql = "SELECT
            pd.*,
            pa.*,
            k.tgl as tanggal_kunjungan,
            p.tgl as tanggal_pelayanan,
            u.nama as nama_tempat_layanan,
            peg.nama as nama_petugas,
            agama.agama as agama,
            ped.nama as pendidikam,
            pk.nama as pekerjaan,
            kw.nama as kewarganegaraan 
        FROM
            rm_2_3_p_anak pd
            LEFT JOIN b_kunjungan k ON k.id = pd.id_kunjungan
            LEFT JOIN b_pelayanan p ON p.id = pd.id_pelayanan
            LEFT JOIN b_ms_unit u ON u.id = p.unit_id
            LEFT JOIN b_ms_pegawai peg ON peg.id = pd.petugas_anamnesa
            LEFT JOIN b_ms_pasien pa ON pa.id = k.pasien_id
            LEFT JOIN b_ms_pendidikan ped ON pd.id = pa.pendidikan_id
            LEFT JOIN b_ms_agama as agama ON agama.id = pa.agama
            LEFT JOIN b_ms_pekerjaan as pk ON pk.id = pa.pekerjaan_id
            LEFT JOIN b_ms_kewarganegaraan as kw ON kw.id = pa.id_kw
        WHERE
            pd.id = {$_REQUEST['id']}";
$data = mysql_fetch_assoc(mysql_query($sql));

}

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


$keluarga = cetakRiwayatPenyakit($data['riwayat_penyakit_keluarga']);
$penyakit = cetakRiwayatPenyakit($data['riwayat_penyakit']);

$riwayat_persalinan = explode('|',$data['riwayat_persalinan']);
$riwayat_nutrisi = explode('|',$data['riwayat_nutrisi']);
$mata = explode('|',$data['mata']);
$tht = explode('|',$data['tht']);
$leher = explode('|',$data['leher']);
$dirawat_ruang = explode('|',$data['dirawat_ruang']);

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
                    <?= tr2('Nama', $data['nama']) ?>
                    <?= tr2('Tgl.Lahir', convertTanggal($data['tgl_lahir']) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $data['sex']) ?>
                    <?= tr2('No.RM', $data['no_rm']) ?>
                </table>
            </td>
        </tr>
    </table>
    <hr>
    <hr>
    <table style="width: 100%;">
        <tr>
            <td style="text-align: center;">
                <b>PENGKAJIAN AWAL MEDIS <br> PENYAKIT ANAK </b><br>
                (Dilengkapi dalam waktu 2 jam pertama pasien masuk IRJ)
            </td>
        </tr>
    </table>
    <div style="border:1px solid;">
        <table style="width:100%" class="table table-bordered">
            <tr>
                <td style="border-bottom:1px solid;">
                    <table style="width: 100%">
                        <td><?= 'Tanggal : ' . tglMulai($data['tanggal_anamnesa']) ?></td>
                        <td><?= 'Jam : ' . $data['jam_anamnesa'] ?></td>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="width:100%;">
                        <?= tr('Anamnesa', $data['anamnesa']) ?>
                        <tr>
                            <th align="left" colspan="3">IDENTITAS PASIEN</th>
                        </tr>
                        <?= tr('Agama', $data['agama']) ?>
                        <?= tr('Pendidikan', $data['pendidikam']) ?>
                        <?= tr('Pekerjaan', $data['pekerjaan']) ?>
                        <?= tr('Kewarganegaraan', $data['kewarganegaraan']) ?>
                        <?= tr('ALERGI TERHADAP', $data['alergi_terhadap']) ?>
                    </table>
                </td>
            </tr>
        </table>
        <table style="width:100%;text-align:left;">
            <tr>
                <th>KELUHAN UTAMA</th>
            </tr>
            <tr>
                <td>
                    <?= $data['keluhan_utama'] ?>
                </td>
            </tr>
        </table>
        <table style="width:100%;text-align:left;">
            <tr>
                <th>RIWAYAT PENYAKIT DAHULU DAN RIWAYAT PENGOBATAN</th>
            </tr>
            <tr>
                <td>
                    <table style="width:100%;border-collapse:collapse;" border="1">
                        <tr>
                            <th align="center">Riwayat Penyakit Dahulu (tahun)</th>
                            <th align="center">Riwayat Penyakit Pengobatan</th>
                        </tr>
                        <tr>
                            <td><?= $data['riwayat_penyakit_dahulu'] ?></td>
                            <td><?= $data['riwayat_pengobatan'] ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <th>Riwayat Penyakit Keluarga</th>
            </tr>
            <tr>
                <td>
                    <?= $keluarga ?>
                </td>
            </tr>
        </table>

        <table style="width:100%;text-align:left;">
            <tr>
                <th><u>TANDA-TANDA VITAL :</u></th>
            </tr>
            <tr>
                <td>
                    <table style="width:100%;text-align:left;">
                        <tr>
                            <td width=15%>TB :</td>
                            <td><?= $data['tinggi_badan'] ?> cm</td>
                            <td width=15%>LK : </td>
                            <td><?= $data['lingkar_kepala'] ?> cm</td>
                            <td width=15%>Tensi</td>
                            <td><?= $data['tensi'] ?> mmHg</td>
                        </tr>
                        <tr>
                            <td width=15%>Nadi : </td>
                            <td><?= $data['nadi'] ?> x/I</td>
                            <td width=15%>Temperatur  :</td>
                            <td><?= $data['temperatur'] ?></td>
                        </tr>
                        <tr>
                            <td width=15%>Pernapasan :</td>
                            <td><?= $data['pernapasan'] . ' x/i' ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div style="border:1px solid; width:100% ;">
        <table>
            <tr>
                <td>Riwayat Imunisasi </td>
                <td><?= $data['riwayat_imunisasi'] ?></td>
            </tr>
        </table>
    </div>

    <div style="border:1px solid; width:100%; text-align:left; ">
        <table>
            <tr>
                <td>Riwayat Persalinan : <?= $riwayat_persalinan[0] ?></td>
            </tr>
            <tr>
                <td>&emsp; a. Ditolong oleh: <?= $riwayat_persalinan[1] ?></td>
            </tr>
            <tr>
                <td>&emsp; b. BB: <?= $riwayat_persalinan[2] ?>&emsp;PB: <?= $riwayat_persalinan[3] ?>&emsp;LK: <?= $riwayat_persalinan[4] ?></td>
            </tr>
            <tr>
                <td>&emsp; c.    Keadaan saat lahir: <?= $riwayat_persalinan[5] ?></td>
            </tr>
        </table>
    </div>
    <div style="border:1px solid; width:100%; text-align:left; ">
        <table>
            <tr>
                <td>Riwayat Nutrisi:</td>
            </tr>
            <tr>
                <td>&emsp; a) ASI: <?= $riwayat_nutrisi[0] ?></td>
            </tr>
            <tr>
                <td>&emsp; b) Susu Formula: <?= $riwayat_nutrisi[1] ?></td>
            </tr>
            <tr>
                <td>&emsp; c) Bubur Susu: <?= $riwayat_nutrisi[2] ?></td>
            </tr>
            <tr>
                <td>&emsp; d) Nasi tim: <?= $riwayat_nutrisi[3] ?></td>
            </tr>
            <tr>
                <td>&emsp; e) Makanan Dewasa: <?= $riwayat_nutrisi[4] ?></td>
            </tr>
        </table>
        <table>
            <tr>
                <td>Riwayat Tumbuh Kembang: </td>
                <td> <?= $data['riwayat_tumbuh_kembang'] ?></td>
            </tr>
            <tr>
        </table>
    </div>
    <div style="border: 1px solid; width:100%; text-align:left;">
        <b style="text-transform: uppercase; font-size:18px;">Pemeriksaan Fisik</b><br>
        Pemeriksaan Umum: <br><br>
        <div style="margin-left: 30px">
            Kepala : <?= $data['kepala'] ?><br>
            Mata : Konjungtiva pucat <?= $mata[0] ?>, hiperemi <?= $mata[1] ?>&emsp;sekret <?= $mata[2] ?><br>
            Sklera Ikterik <?= $mata[3] ?>, Pupil isokor: <?= $mata[4] ?>, Reflek cahaya Oedema: <?= $mata[5] ?><br>
            <table>
                <tr>
                    <td valign="top">THT : </td>
                    <td>
                        Telinga <?= $tht[0] ?>&emsp;Hidung <?= $tht[6] ?><br>
                        Tenggorokan <?= $tht[1] ?>&emsp;faring <?= $tht[4] ?> Tonsil <?= $tht[5] ?><br>
                        Lidah <?= $tht[2] ?>&emsp;Bibir <?= $tht[3] ?>&emsp;
                    </td>
                </tr>
            </table>
            Leher : JVP : <?= $leher[0] ?>&emsp;Pembesaran Kelenjar : <?= $leher[1] ?> Ukuran : <?= $leher[2] ?><br>
            Thoraks : <?= $data['thoraks'] ?><br>
            <table>
                <tr>
                    <td>
                        - Cor :
                    </td>
                    <td><?= $data['cor'] ?></td>
                </tr>
                <tr>
                    <td>
                        - Pulmo :
                    </td>
                    <td><?= $data['pulmo'] ?></td>
                </tr>
                <tr>
                    <td>
                        Abdomen :
                    </td>
                    <td><?= $data['abdomen'] ?></td>
                </tr>
                <tr>
                    <td>
                        - Hepar :
                    </td>
                    <td><?= $data['hepar'] ?></td>
                </tr>
                <tr>
                    <td>
                        - Lien :
                    </td>
                    <td><?= $data['lien'] ?></td>
                </tr>
                <tr>
                    <td>
                        - Massa :
                    </td>
                    <td><?= $data['massa'] ?></td>
                </tr>
            </table>
            Ekstremitas: <?= $data['ekstremitas'] ?>
        </div>
    </div>

    <div style="border: 1px solid; width:100%; text-align:left;">
    </div>
    <div style="border: 1px solid; width:100%; text-align:left;">
        <table style="width:100%;border-collapse:collapse;">
            <tr>
                <th>DIAGNOSA KERJA</th>
            </tr>
            <tr>
                <td><?= $data['diagnosa_kerja'] ?></td>
            </tr>
            <tr>
                <th>DIAGNOSA BANDING</th>
            </tr>
            <tr>
                <td><?= $data['diagnosa_differential'] ?></td>
            </tr>
        </table>
    </div>
    <div style="border: 1px solid; width:100%; text-align:left;">
        <table>
            <tr>
                <th>RENCANA KERJA</th>
            </tr>
            <tr>
                <td><?= $data['rencana_kerja'] ?></td>
            </tr>
        </table>
    </div>
    <div style="border: 1px solid; width:100%; text-align:left;">
        <b> DISPOSISI</b>
        <p>
            Boleh pulang Jam Keluar : <?= $data['jam_keluar'] ?> Wib<br>
            Kontrol Poliklinik <?= $data['kontrol_poliklinik'] ?>
        </p>
        <p>
            <table>
                <tr>
                    <td valign="top">Dirawat Ruang : </td>
                    <td>
                        Ruangan :  <?= $dirawat_ruang[0] ?><br>
                    </td>
                </tr>
            </table>
           Konsul <?= $dirawat_ruang[1] ?> Devisi/Dept <?= $dirawat_ruang[2] ?>
        </p>
    </div>
    <div style="width:100%; text-align:left;"><br>
        <div style="text-align: right;">
        <p style="padding-left: 2px">
                        Belawan, .................................................. <br><br><br><br><br><br><br><br>
                        (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)<br>
                        Tanda tangan nama DPJP&nbsp;&nbsp;&nbsp;&nbsp;
                    </p>
                    </div>
    </div>
    <script>
        <?php if (isset($_REQUEST["pdf"])): ?>
            let identifier = '<?=$dataPasien["nama"]?>';
            printPDF('RM 2.3 '+identifier);
        <?php endif; ?>
    </script>
</body>

</html>