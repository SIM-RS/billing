<?php
include("../../koneksi/konek.php");
include("../function/form.php");

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
            rm_2_4_p_obgin pd
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
            rm_2_4_p_obgin pd
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

$no = 1;
$query = mysql_query("SELECT * FROM tb_riwayat_kehamilan WHERE id_pasien = {$data['id_pasien']}");

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

$riwayat_menstruasi = explode("|", $data['riwayat_menstruasi']);
$riwayat_perkawinan = explode("|", $data['riwayat_perkawinan']);
$riwayat_pemakaian_alat_kontrasepsi = explode("|", $data['riwayat_pemakaian_alat_kontrasepsi']);
$riwayat_hamil_ini = explode("|", $data['riwayat_hamil_ini']);
$riwayat_penyakit_yang_lalu = explode("|", $data['riwayat_penyakit_yang_lalu']);
$mata = explode("|", $data['mata']);
$extermitas = explode("|", $data['extermitas']);
$mamae = explode("|", $data['mamae']);
$inspeksi = explode("|", $data['inspeksi']);
$palpasi = explode("|", $data['palpasi']);
$inspeksi_anogenital = explode("|", $data['inspeksi_anogenital']);
$auskultasi = explode("|", $data['auskultasi']);

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
                        <?= tr('ALERGI TERHADAP', $data['alergi_terhadap']) ?>
                    </table>
                </td>
            </tr>
        </table>

        <div style="border: 1px solid; width:100%; text-align:left;"><div>

        <table style="width:100%;text-align:left;" >
            <tr>
                <th>1. Keluhan Utama</th>
            </tr>
            <tr>
                <td>
                    &emsp;<?= $data['keluhan_utama'] ?>
                </td>
            </tr>
        </table>
        <table style="width:100%;text-align:left;">
            <tr>
                <th>2. Riwayat Penyakit sekarang</th>
            </tr>
            <tr>
                <td>
                    &emsp;<?= $data['riwayat_penyakit_sekarang'] ?>
                </td>
            </tr>
        </table>
        <table style="width:100%;text-align:left;">
            <tr>
                <th>3. Riwayat menstruasi</th>
            </tr>
            <tr>
                <td>
                    &emsp;•	menarche  umur: <?=$riwayat_menstruasi[0]?> Tahun&emsp;siklus: <?=$riwayat_menstruasi[1]?> hari,&emsp;• <?=$riwayat_menstruasi[2]?> <br>
                    &emsp;&emsp;&emsp;lama : <?=$riwayat_menstruasi[3]?> hari, <br>
                    &emsp;•	volume : <?=$riwayat_menstruasi[4]?> cc&emsp;keluhan saat haid : <?=$riwayat_menstruasi[5]?>
                </td>
            </tr>
        </table>
        <table style="width:100%;text-align:left;">
            <tr>
                <th>4. Riwayat perkawinan</th>
            </tr>
            <tr>
                <td>
                    &emsp;• Status : <?=$riwayat_perkawinan[0]?> <br>
                    &emsp;•	Umur waktu pertama kawin : <?=$riwayat_perkawinan[1]?>
                </td>
            </tr>
        </table>
        <table style="width:100%;text-align:left;">
            <tr>
                <th>5. Riwayat kehamilan, persalinan dan nifas yang lalu</th>
            </tr>
            <tr>
                <td>
                    <table class="text-center" border="1px" width="100%">
        <tr>
            <td rowspan="3">No</td>
            <td rowspan="3">Tgl Partus</td>
            <td colspan="3">Umur Hamil</td>
            <td rowspan="3">Jenis Partus</td>
            <td colspan="2">Penolong</td>
            <td colspan="3">Anak</td>
            <td colspan="3">Keadaan anak Sekarang</td>
            <td rowspan="3">Keterangan / Komplikasi</td>
        </tr>
        <tr>
            <td rowspan="2">Abortus</td>
            <td rowspan="2">Prematur</td>
            <td rowspan="2">Aterm</td>
            <td rowspan="2">Nakes</td>
            <td rowspan="2">Non</td>
            <td colspan="2">JK</td>
            <td rowspan="2">BBL</td>
            <td colspan="2">Hidup</td>
            <td rowspan="2">Meninggal</td>
        </tr>
        <tr>
            <td>♂</td>
            <td>♀</td>
            <td>Normal</td>
            <td>Cacat</td>
        </tr>
        <?php while($row = mysql_fetch_assoc($query)):?>
            <tr>
                <td><?=$no;$no++;?></td>
                <td><?=$row['tgl_partus'];?></td>
                <td><?=$row['abortus'];?></td>
                <td><?=$row['prematur'];?></td>
                <td><?=$row['aterm'];?></td>
                <td><?=$row['jenis_partus'];?></td>
                <td><?=$row['nakes'];?></td>
                <td><?=$row['non'];?></td>
                <?php if($row['jk'] == "perempuan"): ?>
                    <td><input readonly onclick="return false;" type="checkbox" /></td>
                    <td><input readonly onclick="return false;" type="checkbox" checked /></td>
                <?php else: ?>
                    <td><input readonly onclick="return false;" type="checkbox" checked /></td>
                    <td><input readonly onclick="return false;" type="checkbox" /></td>
                <?php endif; ?>
                <td><?=$row['non'];?></td>
                <td><?=$row['normal'];?></td>
                <td><?=$row['cacat'];?></td>
                <td><?=$row['meninggal'];?></td>
                <td><?=$row['ket'];?></td>
            </tr>
        <?php endwhile; ?>
    </table>
                </td>
            </tr>
        </table>
        <table style="width:100%;text-align:left;">
            <tr>
                <th>6. Riwayat pemakaian alat kontrasepsi :</th>
            </tr>
            <tr>
                <td>
                    &emsp;• <?=$riwayat_pemakaian_alat_kontrasepsi[0]?>, jenis : <?=$riwayat_pemakaian_alat_kontrasepsi[1]?>&emsp;lama pemakaian : <?= $riwayat_pemakaian_alat_kontrasepsi[2]?>
                </td>
            </tr>
        </table>
        <table style="width:100%;text-align:left;">
            <tr>
                <th>7. Riwayat hamil ini :</th>
            </tr>
            <tr>
                <td>
                    &emsp;1)	Hari pertama haid terakhir : <?=$riwayat_hamil_ini[0]?>&emsp;Tafsiran partus : <?=$riwayat_hamil_ini[1]?>&emsp; <br>
                    &emsp;2)	Ante Natal Care : • <?=$riwayat_hamil_ini[2]?> <br>
                    &emsp;3)	Frekuensi : • <?=$riwayat_hamil_ini[3]?>&emsp;Imunisasi  TT : • <?=$riwayat_hamil_ini[4]?> <br>
                    &emsp;4)	Keluhan saat hamil    : <?=$riwayat_hamil_ini[5]?>
                </td>
            </tr>
        </table>
        <table style="width:100%;text-align:left;">
            <tr>
                <th>8. Riwayat penyakit yang lalu / operasi :</th>
            </tr>
            <tr>
                <td>
                    &emsp;• <?=$riwayat_penyakit_yang_lalu[0]?> <br>
                    &emsp;Pernah dirawat : • <?=$riwayat_penyakit_yang_lalu[1]?>,&emsp;alasan dirawat: <?=$riwayat_penyakit_yang_lalu[2]?>&emsp;tanggal: <?=$riwayat_penyakit_yang_lalu[3]?> <br>
                    &emsp;Pernah dioperasi : • <?=$riwayat_penyakit_yang_lalu[4]?>,&emsp;jenis operasi : <?=$riwayat_penyakit_yang_lalu[5]?> tanggal: <?=$riwayat_penyakit_yang_lalu[6]?>&emsp;di : <?=$riwayat_penyakit_yang_lalu[7]?>
                </td>
            </tr>
        </table>
        <table style="width:100%;text-align:left;">
            <tr>
                <th>9. Riwayat penyakit keluarga :</th>
            </tr>
            <tr>
                <td>
                    &emsp;• <?=$data['riwayat_penyakit_keluarga']?>
                </td>
            </tr>
        </table>
        <table style="width:100%;text-align:left;">
            <tr>
                <th>10.	Riwayat penyakit gynekologi :</th>
            </tr>
            <tr>
                <td>
                    &emsp;• <?=$data['riwayat_penyakit_gynekologi']?>
                </td>
            </tr>
        </table>
        </div>
        </div>
    </table>
    </div>
    <br>

    <div style="border:1px solid;">
        <table width="100%">
            <tr>
                <td class="text-left" colspan="2"><b>DATA OBJEKTIF</b></td>
            </tr>
        </table>
        <div style="border: 1px solid; width:100%; text-align:left;"><div>
        <table width="100%">
            <tr>
                <td class="text-left" colspan="2">1. Pemeriksaan umum :</td>
            </tr>
            <tr>
                <td>
                    &emsp;Kesadaran : <?=$data['kesadaran']?>&emsp;BB : <?=$data['berat_badan']?> kg&emsp;TB : <?=$data['tinggi_badan']?> cm <br>
                    &emsp;TD : <?=$data['td']?> mmHg,&emsp;Nadi  : <?=$data['nadi']?> / mnt,&emsp;Pernafasan : <?=$data['pernapasan']?> / mnt&emsp;Suhu : <?=$data['suhu']?> &deg;C
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td class="text-left" colspan="2">2. Pemeriksaan fisik :</td>
            </tr>
            <tr>
                <td>
                    &emsp;•	Mata           : Konjunctiva  :  • <?=$mata[0]?>&emsp;sclera : • <?=$mata[1]?><br>
                    &emsp;•	Leher          : Tyroid           : • <?=$data['leher']?><br>
                    &emsp;•	Dada           : Jantung : <?=$data['dada']?><br>
                    &emsp;•	Paru            : <?=$data['paru']?><br>
                    &emsp;•	Mamae       : bentuk          : • <?=$mamae[0]?>, <br>
                    &emsp;&emsp;putting susu   • <?=$mamae[1]?> <br>
                    &emsp;&emsp;Pengeluaran    : • <?=$mamae[2]?><br>
                    &emsp;&emsp;Kebersihan      : • <?=$mamae[3]?> <br>
                    &emsp;&emsp;kelainan           : • <?=$mamae[4]?> <br>
                    &emsp;•	Extermitas  : tungkai    :  • <?=$extermitas[0]?>&emsp;edema : <?=$extermitas[2]?>&emsp;refleks : • <?=$extermitas[1]?>
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td class="text-left" colspan="2">3. Pemeriksaan khusus :</td>
            </tr>
            <tr>
                <td>
                    &emsp;a. Abdomen<br>
                    &emsp;&emsp;<b>*Inspeksi :</b><br>
                    &emsp;•	Luka bekas operasi : • <?=$inspeksi[0]?><br>
                    &emsp;•	Arah pembesaran :  • <?=$inspeksi[1]?><br>
                    &emsp;•	kelainan:  • <?=$inspeksi[2]?><br><br>
                    &emsp;&emsp;<b>*Palpasi :</b><br>
                    &emsp;•	tinggi fundus uteri : <?=$palpasi[0]?> cm&emsp;taksiran berat janin : <?=$palpasi[12]?> gram<br>
                    &emsp;•	letak punggung :  • <?=$palpasi[1]?><br>
                    &emsp;•	presentasi : • <?=$palpasi[2]?>,<br>
                    &emsp;•	bagian terendah : <?=$palpasi[3]?>&emsp;osborn test : • <?=$palpasi[4]?><br>
                    &emsp;•	kontraksi uterus :   • <?=$palpasi[5]?>,&emsp; His <?=$palpasi[6]?> / 10 mnt, <br>
                    &emsp;&emsp;lama <?=$palpasi[7]?> detik<br>
                    &emsp;•	kelainan : • <?=$palpasi[8]?> <br>
                    &emsp;•	teraba massa : • <?=$palpasi[9]?>,&emsp;ukuran : <?=$palpasi[10]?> cm<br><br>
                    &emsp;<b>*Auskultasi :</b>bising usus : • <?=$auskultasi[0]?> DJJ : <?=$auskultasi[1]?> / mnt<br>
                    &emsp;<?=$auskultasi[2]?>
                    <div style="border: 1px solid; width:100%; text-align:left;"><div>
                    &emsp;b. Anogenital<br>
                    &emsp;<b>*Inspeksi : </b><br>
                    &emsp;Pengeluaran pervaginam : • <?=$inspeksi_anogenital[0]?> <br>
                    &emsp;•	Lochea:   • <?=$inspeksi_anogenital[1]?><br>
                    &emsp;•	Volume        : <?=$inspeksi_anogenital[2]?> cc&emsp;berbau: • <?=$inspeksi_anogenital[3]?><br>
                    &emsp;•	perinium:   • <?=$inspeksi_anogenital[4]?>;&emsp;derajat <?=$inspeksi_anogenital[5]?><br>
                    &emsp;•	jahitan:   • <?=$inspeksi_anogenital[6]?><br>
                    <b>*Inspekulo vagina :</b><br>
                    &emsp;Vagina:<br>
                    &emsp;kelainan:  • <?=$inspeksi_anogenital[7]?><br><br>
                    &emsp;Hymen :  • <?=$inspeksi_anogenital[8]?><br><br>
                    &emsp;Portio : • <?=$inspeksi_anogenital[9]?><br><br>
                    &emsp;Vagina toucher : oleh <?=$inspeksi_anogenital[10]?>&emsp;Tgl :<?=$inspeksi_anogenital[11]?>&emsp;jam : <?=$inspeksi_anogenital[12]?> WIB<br><br>
                    &emsp;Pembukaan : <?=$inspeksi_anogenital[13]?> cm,&emsp;effacement : <?=$inspeksi_anogenital[14]?>,&emsp; terbawah: <?=$inspeksi_anogenital[15]?>,<br><br>
                    &emsp;Cervix : <?=$inspeksi_anogenital[16]?><br><br>
                    &emsp;Cavum douglasi<br><br>
                    &emsp;&emsp;Pemeriksaan panggul : Promont : <?=$inspeksi_anogenital[17]?>&emsp;Linea Innom : <?=$inspeksi_anogenital[18]?><br>
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    sacrum : <?=$inspeksi_anogenital[19]?>&emsp;Spin Isch : <?=$inspeksi_anogenital[20]?><br>
                    &emsp;Kesan Panggul : <?=$inspeksi_anogenital[21]?><br><br>
                    <div style="border: 1px solid; width:100%; text-align:left;"><div>
                    <b>HASIL PEMERIKSAAN PENUNJANG:</b>
                    <div style="border: 1px solid; width:100%; text-align:left;"><div>
                    <table border="1px" width="100%">
                        <tr>
                            <td class="text-center" width="50%">
                                <center><u><b>USG</b></u><br>
                                <?=$data['usg']?>
                                </center>
                            </td>
                            <td class="text-center" width="50%">
                                <center><u><b>Laboratorium</b></u><br>
                                <?=$data['laboratorium']?>
                                </center>
                            </td>
                        </tr>
                    </table>
                    <div style="border: 1px solid; width:100%; text-align:left;"><div>
                    <b>TERAPI/ TINDAKAN :</b><br>
                    <?=$data['terapi_tindakan']?><br><br>
                    <div style="border: 1px solid; width:100%; text-align:left;"><div>
                    <b>RENCANA KERJA :</b><br>
                    <?=$data['rencana_kerja']?><br><br>
                    <div style="border: 1px solid; width:100%; text-align:left;"><div>
                    <b>DISPOSISI</b><br>
                    <table width="100%">
                        <tr>
                            <td width="50%">
                                Kontrol Poliklinik : <?=$data['kontrol_poliklinik']?><br>
                                Dirawat di ruang :  : <?=$data['dirawat_ruang']?><br>
                                Kelas : <?=$data['kelas']?>
                            </td>
                            <td width="50%">
                                Tanggal: <?=$data['tanggal']?>
                            </td>
                        </tr>
                    </table>
                    <div style="border: 1px solid; width:100%; text-align:left;"><div>
                    <table width="100%">
                        <tr>
                            <td width="50%">
                                &nbsp;
                            </td>
                            <td width="50%">
                                <br><br><br>
                                MEDAN,............................................<br><br><br><br><br><br>
                                Tanda tangan dan nama Dokter DPJP
                                <br><br><br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <>
        <?php if(isset($_REQUEST["pdf"])): ?>
            let identifier = '<?=$data['nama']?>';
            printPDF('RM 2.4 '+identifier);
        <?php endif; ?>
    </>
</body>

</html>