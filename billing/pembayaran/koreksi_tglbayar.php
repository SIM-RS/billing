<?php
    session_start();
    include("../sesi.php");
    include("../koneksi/konek.php");

    $userId = $_SESSION['userId'];
    if(!isset($userId) || $userId == '' || $userId !== '732'){
        header('location:../index.php');
    }

    if (isset($_POST['cari'])) {
        $date1 = $_POST['date1'];
        $date2 = $_POST['date2'];
        $custom_between = "AND b.tgl BETWEEN '$date1' AND '$date2'";
    } else {
        $custom_between = "AND b.tgl BETWEEN '".date('Y-m-d')."' AND '".date('Y-m-d')."'";
    }

    $sqll = "
    SELECT gb.id, gb.no_kwitansi, gb.nm_kasir, SUM(gb.nilai) nilai, gb.nilai nilaiBayar,
        gb.jam, gb.tgl, gb.kwi, gb.no_rm, gb.tgl_kunjung, gb.tgl_setor, gb.st_setor, 
        gb.pasien, gb.kso, IFNULL(gb.ak_ms_unit_id,0) ak_ms_unit_id,
        SUM(gb.`81001`) AS `81001`,
        SUM(gb.`81002`) AS `81002`,
        SUM(gb.`81003`) AS `81003`,
        SUM(gb.`81004`) AS `81004`,
        SUM(gb.`81005`) AS `81005`,
        SUM(gb.`81006`) AS `81006`,
        SUM(gb.`81007`) AS `81007`,
        SUM(gb.`81008`) AS `81008`,
        SUM(gb.`81009`) AS `81009`,
        SUM(gb.`81010`) AS `81010`,
        SUM(gb.`81099`) AS `81099`,
        SUM(gb.`41499`) AS `41499`,
        SUM(gb.PPN_NILAI) PPN_NILAI, gb.pegawai_id, gb.pegawai_nama, gb.bayar_ulang
    FROM (SELECT b.id, b.no_kwitansi, 
        bt.tindakan_id, bt.tipe, 
        SUM(bt.nilai) nilai, b.nilai nilaiBayar,
        TIME_FORMAT(b.tgl_act, '%H:%i') AS jam,
        DATE_FORMAT(b.tgl, '%d-%m-%Y') AS tgl,
        DATE_FORMAT(k.tgl, '%d-%m-%Y') AS tgl_kunjung,
        DATE_FORMAT(b.disetor_tgl,'%d-%m-%Y') AS tgl_setor,
        b.bayar_ulang,
        IF(DATE(b.disetor_tgl)='0000-00-00' OR b.disetor_tgl IS NULL,'0','1') AS st_setor,
        b.no_kwitansi AS kwi,
        peg.nama AS nm_kasir,
        pas.no_rm,
        pas.nama AS pasien,
        kso.nama AS kso,
        t.ak_ms_unit_id,
        SUM(CASE WHEN t.ak_ms_unit_id = 2 THEN IF(t.biaya_utip>0,bt.nilai-t.biaya_utip,bt.nilai) ELSE 0 END) AS `81001`,
        SUM(CASE WHEN t.ak_ms_unit_id = 3 THEN IF(t.biaya_utip>0,bt.nilai-t.biaya_utip,bt.nilai) ELSE 0 END) AS `81002`,
        SUM(CASE WHEN t.ak_ms_unit_id = 4 THEN IF(t.biaya_utip>0,bt.nilai-t.biaya_utip,bt.nilai) ELSE 0 END) AS `81003`,
        SUM(CASE WHEN t.ak_ms_unit_id = 5 THEN IF(t.biaya_utip>0,bt.nilai-t.biaya_utip,bt.nilai) ELSE 0 END) AS `81004`,
        SUM(CASE WHEN t.ak_ms_unit_id = 6 THEN IF(t.biaya_utip>0,bt.nilai-t.biaya_utip,bt.nilai) ELSE 0 END) AS `81005`,
        SUM(CASE WHEN t.ak_ms_unit_id = 7 THEN IF(t.biaya_utip>0,bt.nilai-t.biaya_utip,bt.nilai) ELSE 0 END) AS `81006`,
        SUM(CASE WHEN t.ak_ms_unit_id = 8 THEN IF(t.biaya_utip>0,bt.nilai-t.biaya_utip,bt.nilai) ELSE 0 END) AS `81007`,
        SUM(CASE WHEN t.ak_ms_unit_id = 9 THEN IF(t.biaya_utip>0,bt.nilai-t.biaya_utip,bt.nilai) ELSE 0 END) AS `81008`,
        SUM(CASE WHEN t.ak_ms_unit_id = 10 THEN IF(t.biaya_utip>0,bt.nilai-t.biaya_utip,bt.nilai) ELSE 0 END) AS `81009`,
        SUM(CASE WHEN t.ak_ms_unit_id = 11 THEN IF(t.biaya_utip>0,bt.nilai-t.biaya_utip,bt.nilai) ELSE 0 END) AS `81010`,
        SUM(CASE WHEN IFNULL(t.ak_ms_unit_id,0) IN (12,0) THEN IF(t.biaya_utip>0,bt.nilai-t.biaya_utip,bt.nilai) ELSE 0 END) AS `81099`,
        SUM(CASE WHEN t.biaya_utip > 0 THEN t.biaya_utip ELSE 0 END) AS `41499`,
        0 AS PPN_NILAI, peg.id AS pegawai_id, peg.nama AS pegawai_nama
    FROM b_bayar_tindakan bt
    LEFT JOIN b_tindakan t ON t.id = bt.tindakan_id
    INNER JOIN b_bayar b ON b.id = bt.bayar_id
    INNER JOIN b_kunjungan k ON k.id = b.kunjungan_id
    INNER JOIN b_ms_pasien pas ON pas.id = k.pasien_id
    INNER JOIN b_ms_kso kso ON kso.id = k.kso_id
    INNER JOIN b_ms_unit u ON u.id = b.unit_id
    INNER JOIN b_ms_pegawai peg ON peg.id = b.user_act 
    WHERE bt.tipe = 0 AND b.flag = '1'
        $custom_between
    GROUP BY b.id
    UNION
    SELECT b.id, b.no_kwitansi, 
        bt.tindakan_id, bt.tipe, 
        SUM(bt.nilai) nilai, b.nilai nilaiBayar,
        TIME_FORMAT(b.tgl_act, '%H:%i') AS jam,
        DATE_FORMAT(b.tgl, '%d-%m-%Y') AS tgl,
        DATE_FORMAT(k.tgl, '%d-%m-%Y') AS tgl_kunjung,
        DATE_FORMAT(b.disetor_tgl,'%d-%m-%Y') AS tgl_setor,
        b.bayar_ulang,
        IF(DATE(b.disetor_tgl)='0000-00-00' OR b.disetor_tgl IS NULL,'0','1') AS st_setor,
        b.no_kwitansi AS kwi,
        peg.nama AS nm_kasir,
        pas.no_rm,
        pas.nama AS pasien,
        kso.nama AS kso,
        9 AS ak_ms_unit_id,
        0 AS `81001`,
        0 AS `81002`,
        0 AS `81003`,
        0 AS `81004`,
        0 AS `81005`,
        0 AS `81006`,
        0 AS `81007`,
        SUM(bt.nilai) AS `81008`,
        0 AS `81009`,
        0 AS `81010`,
        tk.retribusi AS `81099`,
        0 AS `41499`,
        0 AS PPN_NILAI, peg.id AS pegawai_id, peg.nama AS pegawai_nama
    FROM b_bayar_tindakan bt
    INNER JOIN b_bayar b ON b.id = bt.bayar_id
    INNER JOIN b_kunjungan k ON k.id = b.kunjungan_id
    INNER JOIN b_ms_pasien pas ON pas.id = k.pasien_id
    INNER JOIN b_ms_kso kso ON kso.id = k.kso_id
    INNER JOIN b_ms_unit u ON u.id = b.unit_id
    INNER JOIN b_ms_pegawai peg ON peg.id = b.user_act 
    INNER JOIN b_tindakan_kamar tk ON tk.id = bt.tindakan_id
    WHERE bt.tipe = 1 AND b.flag = '1'
        $custom_between
    GROUP BY b.id
    UNION
    SELECT b.id, b.no_kwitansi, 
        bt.tindakan_id, bt.tipe, 
        SUM(bt.nilai) nilai, b.nilai nilaiBayar,
        TIME_FORMAT(b.tgl_act, '%H:%i') AS jam,
        DATE_FORMAT(b.tgl, '%d-%m-%Y') AS tgl,
        DATE_FORMAT(k.tgl, '%d-%m-%Y') AS tgl_kunjung,
        DATE_FORMAT(b.disetor_tgl,'%d-%m-%Y') AS tgl_setor,
        b.bayar_ulang,
        IF(DATE(b.disetor_tgl)='0000-00-00' OR b.disetor_tgl IS NULL,'0','1') AS st_setor,
        b.no_kwitansi AS kwi,
        peg.nama AS nm_kasir,
        pas.no_rm,
        pas.nama AS pasien,
        kso.nama AS kso,
        8 AS ak_ms_unit_id,
        0 AS `81001`,
        0 AS `81002`,
        0 AS `81003`,
        0 AS `81004`,
        0 AS `81005`,
        0 AS `81006`,
        SUM(bt.nilai) AS `81007`,
        0 AS `81008`,
        0 AS `81009`,
        0 AS `81010`,
        0 AS `81099`,
        0 AS `41499`,
        FLOOR(IFNULL(SUM(bt.nilai),0) * ap.PPN/100) AS PPN_NILAI, peg.id AS pegawai_id, peg.nama AS pegawai_nama
    FROM b_bayar_tindakan bt
    LEFT JOIN rspelindo_apotek.a_penjualan ap ON ap.ID = bt.tindakan_id
    INNER JOIN b_bayar b ON b.id = bt.bayar_id
    INNER JOIN b_kunjungan k ON k.id = b.kunjungan_id
    INNER JOIN b_ms_pasien pas ON pas.id = k.pasien_id
    INNER JOIN b_ms_kso kso ON kso.id = k.kso_id
    INNER JOIN b_ms_unit u ON u.id = b.unit_id
    INNER JOIN b_ms_pegawai peg ON peg.id = b.user_act 
    WHERE bt.tipe = 2 AND b.flag = '1'
        $custom_between
    GROUP BY ap.NO_KUNJUNGAN,ap.NO_PENJUALAN,ap.UNIT_ID,ap.USER_ID,ap.KSO_ID,ap.NO_PASIEN) AS gb
    GROUP BY gb.id
    ORDER BY gb.id
        ";
    // echo $sqll;
    $sql = mysql_query($sqll);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Koreksi Tgl Bayar</title>
    <link rel="stylesheet" href="datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="datatables/bootstrap.css">
    <link rel="stylesheet" href="datatables/datatables.min.css">
    <!-- datapicker -->
    <link href="datatables/datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet" media="screen">
</head>

<body>
    <div class="container mb-4">
        <div class="jumbotron">
            <h1>Data Bayar Selisih</h1>
            <p>
                <?php 
                    if($date1){ 
                        echo 'Periode '. $date1 . ' sampai dengan ' . $date2;
                    } else {
                        echo 'Periode Hari Ini';
                    }
                ?>
            </p>
        </div>

        <!-- Form filter tanggal -->
        <form class="form-inline mb-5" action="" method="POST">
            <label class="my-1 mr-2" for="date1">Filter Tanggal :</label>
            <!-- date picker dari tgl -->
            <input type="text" class="form-control datepicker" name="date1" id="date1" value="<?= ($date1) ? $date1 : '' ?>">
            <!-- date picker sampai dengan tgl -->
            <label class="my-1 mr-2" for="date2">&nbsp; s/d </label>
            <input type="text" class="form-control datepicker" name="date2" id="date2" value="<?= ($date2) ? $date2 : '' ?>">
            <input type="submit" value="cari" name="cari" class="btn btn-primary ml-3" />
        </form>

        <!-- Table Data -->
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <th>No. </th>
                <th>No Kwitansi</th>
                <th>No RM</th>
                <th>Nama Pasien</th>
                <th>Lap. Kasir</th>
                <th>Kwitansi</th>
                <th>Tgl Bayar</th>
                <th>Kasir</th>
                <th>Aksi</th>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php 
                    // == perulangan
                    while ($koreksi = mysql_fetch_array($sql)) :
                        // == sum utk nilai kolom laporan kasir
                        $lap_kasir = $koreksi['81001'] + $koreksi['81002'] + $koreksi['81003'] + $koreksi['81004'] + $koreksi['81005'] + $koreksi['81006'] + $koreksi['81007'] + $koreksi['81008'] + $koreksi['81009'] + $koreksi['81010'] + $koreksi['81099'] + $koreksi['41499'] + $koreksi['PPN_NILAI'];

                        // get nilai bayar dari kwitansi
                        $kwitansi = mysql_fetch_array(mysql_query("SELECT tagihan, nilai FROM b_bayar WHERE no_kwitansi = '".$koreksi['no_kwitansi']."'"));
                        $nilai_kwitansi = (int)$kwitansi['nilai'];

                        // == start echo table data row
                        // == hanya menampilkan yang selisih
                        if ($lap_kasir !== $nilai_kwitansi || $koreksi['bayar_ulang'] == '0') :
                ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $koreksi['no_kwitansi'] ?></td>
                                <td><?= $koreksi['no_rm'] ?></td>
                                <td><?= $koreksi['pasien'] ?></td>
                                <td><?= "Rp " . number_format($lap_kasir,2,',','.') ?></td>
                                <td><?= "Rp " . number_format($nilai_kwitansi,2,',','.') ?></td>
                                <td><?= $koreksi['tgl'] ?></td>
                                <td><?= $koreksi['pegawai_nama'] ?></td>
                                <td>
                                    <!-- Jika bayar_ulang == 0, show tombol konfirmasi sudah bayar -->
                                    <?php if ($koreksi['bayar_ulang'] == '0') : ?>
                                        <a href="koreksi_tglbayarEdit.php?idbayar=<?= $koreksi['id'] ?>&act=upt_status&status=1" class="btn btn-sm btn-success" onclick="return confirm('Konfirmasi sudah bayar?')">Konfirmasi Sudah Bayar</a>
                                    <!-- Jika bayar_ulang kosong, show tombol unbayar sekarang -->
                                    <?php else : ?>
                                        <a href="koreksi_tglbayarEdit.php?idbayar=<?= $koreksi['id'] ?>&act=upt_status&status=0" class="btn btn-sm btn-info" onclick="return confirm('Unbayar sekarang?')">Unbayar Sekarang</a>
                                    <?php endif ?>
                                </td>
                            </tr>
                <?php 
                            $no++;
                        endif;
                        // == end echo table data row
                    endwhile;
                ?>
            </tbody>
        </table>
    </div>
</body>
<script src="datatables/datatables.min.js"></script>
<script src="datatables/datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });

    $(function(){
        $(".datepicker").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
    });
</script>

</html>