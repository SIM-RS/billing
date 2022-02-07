<?php
$BASE_URL = 'http://' . $_SERVER['HTTP_HOST'] . '/simrs-pelindo/ppm';
$BASE_URL2 = 'http://' . $_SERVER['HTTP_HOST'] . '/simrs-pelindo/portal.php';
include '../../../billing/sesi.php';
$bulanData = [
  1 => 'Januari',
  2 => 'Pebruari',
  3 => 'Maret',
  4 => 'April',
  5 => 'Mei',
  6 => 'Juni',
  7 => 'Juli',
  8 => 'Agustus',
  9 => 'September',
  10 => 'Oktober',
  11 => 'Nopember',
  12 => 'Desember',
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MODUL PPM</title>
  <link rel="stylesheet" type="text/css" href="<?= $BASE_URL ?>/assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?= $BASE_URL ?>/assets/plugins/fontawesome/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="<?= $BASE_URL ?>/assets/css/dashboard.css">
  <script src="<?= $BASE_URL ?>/assets/plugins/Chart.js-master/dist2/Chart.bundle.min.js"></script>
  <script src="<?= $BASE_URL ?>/assets/js/jquery-3.3.1.min.js"></script>
  <script src="<?= $BASE_URL ?>/assets/js/popper.min.js"></script>
  <script src="<?= $BASE_URL ?>/assets/js/bootstrap.min.js"></script>
  <script>
    function getListCombo(id, act = 'getRuangan') {
      $.ajax({
        url: '../utils.php',
        method: 'post',
        data: {
          act: act,
        },
        dataType: 'json',
        success: function(data) {
          for (let j = 0; j < data.length; j++) {
            let option = Object.entries(data[j]);
            for (let i = 0; i < option.length; i++) {
              $('#' + id).append("<option value='" + option[i][0] + "'>" + option[i][1] + "</option>")
            }
          }
        }
      });
    }

    function isiTable(id, act, bulan, tahun, ruangan = 1) {
      $.ajax({
        url: '../utils.php',
        method: 'post',
        data: {
          tahun: tahun,
          bulan: bulan,
          ruangan: ruangan,
          act: act,
        },
        success: function(data) {
          $('#' + id).html(data);
        }
      });
    }
  </script>
</head>

<body>
  <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">MODUL PPM</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav px-3">
      <li class="nav-item text-nowrap">
        <a class="nav-link" href="<?= $BASE_URL2 ?>">Portal</a>
      </li>
    </ul>
  </nav>
  <div class="container-fluid">
    <div class="row">
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="sidebar-sticky pt-3">
          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-1 mb-1 text-muted">
            <span>MASTER</span>
            <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
              <span data-feather="plus-circle"></span>
            </a>
          </h6>
          <ul class="nav flex-column mb-2">
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>/master/ruangan.php" class="nav-link">Ruangan</a>
            </li>
            <li class="nav-item">
              <a href="<?= $BASE_URL ?>/master/ipcn.php" class="nav-link">IPCN</a>
            </li>
          </ul>
          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-1 mb-1 text-muted">
            <span style="font-size: 24px;">PPI</span>
            <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
              <span data-feather="plus-circle"></span>
            </a>
          </h6>
          <ul class="nav flex-column mb-2">
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/ppi/infus.php">
                <span data-feather="file-text"></span>
                Plebitis
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/ppi/bedres.php">
                <span data-feather="file-text"></span>
                Bedrest
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/ppi/kateter.php">
                <span data-feather="file-text"></span>
                Kateter
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/ppi/operasi.php">
                <span data-feather="file-text"></span>
                Operasi
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/ppi/vap.php">
                <span data-feather="file-text"></span>
                Vap
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/ppi/iadp.php">
                <span data-feather="file-text"></span>
                Iadp
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/ppi/rekap.php">
                <span data-feather="file-text"></span>
                Rekap Laporan
              </a>
            </li>
          </ul>
          <h5 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-1 mb-1 text-muted">
            <span style="font-size: 24px;">PMKP</span>
            <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
              <span data-feather="plus-circle"></span>
            </a>
          </h5>
          <ul class="nav flex-column mb-2">
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/pmkp/angka_kesalahan_input">
                <span data-feather="file-text"></span>
                Angka Kesalahan Input
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/pmkp/asesmen_pasien">
                <span data-feather="file-text"></span>
                Asesmen Pasien
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/pmkp/assesment_pasien_jatuh">
                <span data-feather="file-text"></span>
                Asesmen Pasien Jatuh
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/pmkp/checklist_keselamatan_pasien_operasi">
                <span data-feather="file-text"></span>
                Cheklist Keselamatan Pasie Operasi
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/pmkp/infeksi_operasi">
                <span data-feather="file-text"></span>
                Infeksi Operasi
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/pmkp/kelengkapan_asesmen">
                <span data-feather="file-text"></span>
                Kelengkapan Asesmen
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/pmkp/kelengkapan_resep_obat">
                <span data-feather="file-text"></span>
                Kelengkapan Resep Obat
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/pmkp/kepatuhan_jam_visite_dokter">
                <span data-feather="file-text"></span>
                Kepatuhan Jam Visite Dokter
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/pmkp/kepuasan_pasien_dan_keluarga">
                <span data-feather="file-text"></span>
                Kepuasan Pasien dan Keluarga
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/pmkp/ketepatan_waktu_lapor">
                <span data-feather="file-text"></span>
                Ketepatan Waktu Lapor
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/pmkp/komunikasi_efektif">
                <span data-feather="file-text"></span>
                Komunikasi Efektif
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/pmkp/obat_sesuai_formalium">
                <span data-feather="file-text"></span>
                Obat Sesuai Formalium
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/pmkp/pemberian_obat_sesuai_resep">
                <span data-feather="file-text"></span>
                Pemberian Obat Sesuai Resep
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/pmkp/pembatalan_operasi">
                <span data-feather="file-text"></span>
                Pembatalan Operasi
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/pmkp/penanganan_obat">
                <span data-feather="file-text"></span>
                Penanganan Obat
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/pmkp/presentase_sc">
                <span data-feather="file-text"></span>
                Presentase SC
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/pmkp/waktu_tanggap_gawat_darurat">
                <span data-feather="file-text"></span>
                Waktu Tanggap GD
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/pmkp/waktu_tunggu_hasil_radiologi">
                <span data-feather="file-text"></span>
                Waktu Tunggu Hasil Radiologi
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/pmkp/waktu_tunggu_rawat_jalan">
                <span data-feather="file-text"></span>
                Waktu tunggu rawat jalan
              </a>
            </li>
          </ul>
          <h5 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-1 mb-1 text-muted">
            <span style="font-size: 24px;">MIRM</span>
            <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
              <span data-feather="plus-circle"></span>
            </a>
          </h5>
          <ul class="nav flex-column mb-2">
            <li class="nav-item">
              <a class="nav-link" href="<?= $BASE_URL ?>/mirm/index.php">
                <span data-feather="file-text"></span>
                Catatan Pasien Terintegrasi
              </a>
            </li>
          </ul>
        </div>
      </nav>
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">