<?php
include("../../koneksi/konek.php");
include("../function/form.php");
// include("../sesi.php");

if (isset($_REQUEST['pdf'])) {
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
            rm_2_7_p_bedah pd
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
            rm_2_7_p_bedah pd
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

echo "<script>window.print()</script>";
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

$pemeriksaanFisik = explode('||',$data['pemeriksaan_fisik']);

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
    < src="../html2pdf/ppdf.js"></>
	< src="../html2pdf/pdf.js"></>
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
                <b>PENGKAJIAN AWAL MEDIS <br> BEDAH </b><br>
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
                        <?= tr('Pendidikan', $data['pendidikan']) ?>
                        <?= tr('Pekerjaan', $data['pekerjaan']) ?>
                        <?= tr('Kewarganegaraan', $data['kewarganegaraan']) ?>
                        <?= tr('ALERGI TERHADAP', $data['alergi']) ?>
                    </table>
                </td>
            </tr>
        </table>
        <table style="width:100%;text-align:left;">
            <tr>
                <th>Keluhan Utama</th>
            </tr>
            <tr>
                <td>
                    <?= $data['keluhan_utama'] ?>
                </td>
            </tr>
        </table>
        <table style="width:100%;text-align:left;">
            <tr>
                <th>Riwayat Penyakit sekarang</th>
            </tr>
            <tr>
                <td>
                    <?= $data['riwayat_penyakit_sekarang'] ?>
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
            <tr>
                <th>Riwayat Pekerjaan, Sosial ekonomi,psikologi,dan kebiasaan</th>
            </tr>
            <tr>
                <td><?= $data['riwayat_pekerjaan'] ?></td>
            </tr>
        </table>

        <table style="width:100%;text-align:left;">
            <tr>
                <th>Tanda Tanda Vital</th>
            </tr>
            <tr>
                <td>
                    <table style="width:100%;text-align:left;">
                        <tr>
                            <th width=15%>Keadaan Umum : </th>
                            <td><?= $data['keadaan_umum'] ?></td>
                            <th width=15%>Gizi : </th>
                            <td><?= $data['gizi'] ?></td>
                            <th width=15%></th>
                            <td></td>
                        </tr>
                        <tr>
                            <th width=15%>GCS : </th>
                            <td><?= $data['gcs'] ?></td>
                            <th width=15%>Tindakan Resusitasi :</th>
                            <td><?= $data['tindakan_resusitasi'] ?></td>
                            <th width=15%>BB : </th>
                            <td><?= $data['berat_badan'] . ' Kg' ?></td>
                        </tr>
                        <tr>
                            <th width=15%>TB :</th>
                            <td><?= $data['tinggi_badan'] . ' cm' ?></td>
                            <th width=15%>Tensi : </th>
                            <td><?= $data['tensi'] . ' mmHg' ?></td>
                            <th width=15%>Suhu Axita/Rectal : </th>
                            <td><?= $suhu[0] . '&#8451' . '/' . $suhu[1] . '&#8451' ?></td>
                        </tr>
                        <tr>
                            <th width=15%>Nadi : </th>
                            <td><?= $data['nadi'] . ' x/mnt' ?></td>
                            <th width=15%>Respirasi : </th>
                            <td><?= $data['respirasi'] . ' x/mnt' ?></td>
                            <th width=15%>Saturasi O<sub>2</sub> : </th>
                            <td><?= $data['saturasi'] . '%' . ' pada : ' . $data['saturasi_pada'] ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div style="border:1px solid; width:100% ;">
        <table>
            <tr>
                <th>Riwayat Penyakit</th>
            </tr>
            <tr>
                <td><?= $penyakit ?></td>
            </tr>
        </table>
    </div>

    <div style="border:1px solid; width:100%; text-align:left; ">
        <table>
            <tr>
                <th>Riwayat Operasi : </th>
                <td><?= $data['riwayat_operasi'] ?></td>
            </tr>
            <tr>
                <th>Riwayat Transfusi : </th>
                <td>
                    <?= $data['riwayat_transfusi'] . ' Reaksi Transfusi : ' . $data['reaksi_transfusi'] ?>
                </td>
            </tr>
        </table>
    </div>
    <div style="border: 1px solid; width:100%; text-align:left;">
        <b style="text-transform: uppercase; font-size:18px;">Pemeriksaan Fisik</b>
        <table>
            <?php
                for($i = 0; $i < sizeof($pemeriksaanFisik); $i++){
                    $dataPemeriksaanFisik = explode('|', $pemeriksaanFisik[$i]);
                    
                    echo "<tr>
                            <th>".$dataPemeriksaanFisik[0]."</th>
                            <td>".$dataPemeriksaanFisik[1] ."</td>
                        </tr>";
                }
            ?>
        </table>
    </div>

    <div style="border: 1px solid; width:100%; text-align:left;">
        <table style="width:100%;border-collapse:collapse;">
            <tr>
                <th style="border-right:1px solid;" width=50% align="">STATUS LOKALIS</th>
                <th>SKEMA</th>
            </tr>
            <tr>
                <td style="border-right:1px solid;"><?= $data['status_lokasi'] ?></td>
                <td><?= $data['skema'] ?></td>
            </tr>
        </table>
    </div>
    <div style="border: 1px solid; width:100%; text-align:left;">
        <table>
            <tr>
                <th>PEMERIKSAAN PENUNJANG(Laboraturium,EKG,X - Ray,Lain - lain):</th>
            </tr>
            <tr>
                <td><?= $data['pemeriksaan_penunjang'] ?></td>
            </tr>
        </table>
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
                <th>DIAGNOSA DIFFERENTIAL</th>
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
        <table>
            <tr>
                <th>HASIL PEMBEDAHAN</th>
            </tr>
            <tr>
                <td><?= $data['hasil_pembedahan'] ?></td>
            </tr>
        </table>
    </div>
    <div style="border: 1px solid; width:100%; text-align:left;">
        <u>DISPOSISI</u>
        <p>
            Boleh pulang Jam Keluar : ..... Wib Tanggal : .................<br>
            Kontrol Poliklinik Tidak / Ya ................................. Tanggal : .................
        </p>
        <p>
            Dirawat Ruang : ..............<br>
            Kelas : ...............
        </p>
    </div>
    <div style="width:100%; text-align:left;">
        <table style="width:100%;border-collapse:collapse;" border="1">
            <tr>
                <td valign="top" rowspan="2">
                    <b>REKOMENDASI (SARAN)<b>
                    <p>
                        <?= $data['saran'] ?>
                    </p>
                </td>
                <td>
                    <b>CATATAN PENTING<b>
                    <p>
                        <?= $data['catatan_penting'] ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th>
                    <p style="padding-left: 2px">
                        Medan <br><br><br><br><br><br><br><br>
                        (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)<br>
                        Tanda tangan nama DPJP
                    </p>
                </th>
            </tr>
        </table>
    </div>
    <>
        <?php if(isset($_REQUEST["pdf"])): ?>
            let identifier = '<?=$data['nama']?>';
            printPDF('RM 2.7 '+identifier);
        <?php endif; ?>
    </>
</body>

</html>