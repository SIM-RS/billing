<?php
include_once '../templates/header.php';
$dataBulan = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'Nopember', 12 => 'Desember'];

$bulan = date('m');

if ($bulan == 1 || $bulan == 3 || $bulan == 5 || $bulan == 7 || $bulan == 8 || $bulan == 10 || $bulan == 12) {
    $inc = 31;
} else if ($bulan == 4 || $bulan == 6 || $bulan == 9 || $bulan == 11) {
    $inc = 30;
} else if ($bulan == 2) {
    if ($tahun % 100 == 0 && $tahun % 400 == 0 && $tahun % 4 == 0) {
        $inc = 29;
    } else {
        $inc = 28;
    }
}
$tglAwal = '2019-07-01';
$tglAkhir = '2019-07' . '-' . 31;
?>
<input type="hidden" name="tglAwal" id="tglAwal" value="<?= $tglAwal ?>">
<input type="hidden" name="tglAkhir" id="tglAkhir" value="<?= $tglAkhir ?>">
<div class="container-fluid p-0">
    <div class="position-relative">
        <div class="card border-0">
            <div class="card-body bg-primary card-bg-height"></div>
        </div>
        <div id="loadPage" class="container bg-dark position-absolute bg-light p-2 card-center">
            <div class="row">
                <div class="col-3">
                    <div class="card text-white bg-primary border-0">
                        <div class="card-header border-0">
                            Pendapatan <span id="pendapatan-time"></span>
                        </div>
                        <div class="card-body">
                            <span id="pendapatan-all"></span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card text-white bg-danger border-0">
                        <div class="card-header border-0">
                            Biaya <span id="biaya-time"></span>
                        </div>
                        <div class="card-body">
                            <span id="biaya-all"></span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card text-white bg-success border-0">
                        <div class="card-header border-0">
                            Laba <span id="laba-time"></span>
                        </div>
                        <div class="card-body">
                            <span id="laba-all"></span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card text-white bg-warning border-0">
                        <div class="card-header border-0">
                            Pelayanan <span id="pelayanan-time"></span>
                        </div>
                        <div class="card-body">
                            <span id="pelayanan-all"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-6">
                    <button class="btn btn-primary btn-sm" onclick="filterChart('getPendapatan|api.php|Pendapatan')" data-bs-toggle="modal" data-bs-target="#exampleModal">Filter</button>
                    <div style="width:auto;margin:auto;" style="text-align:center;">
                        <canvas width="200" height="100" style="height: 100px;width:200px;" id="myChart"></canvas>
                    </div>
                </div>
                <div class="col-6">
                    <button class="btn btn-danger btn-sm" onclick="filterChart('getBiaya|api.php|Biaya')" data-bs-toggle="modal" data-bs-target="#exampleModal">Filter</button>
                    <div style="width:auto;margin:auto;" style="text-align:center;">
                        <canvas width="200" height="100" style="height: 100px;width:200px;" id="myChartBiaya"></canvas>
                    </div>
                </div>
                <div class="col-12">
                    <br><br><br>
                </div>
                <div class="col-6">
                    <button class="btn btn-success btn-sm" onclick="filterChart('getLaba|api.php|Laba')" data-bs-toggle="modal" data-bs-target="#exampleModal">Filter</button>
                    <div style="width:auto;margin:auto;" style="text-align:center;">
                        <canvas width="200" height="100" style="height: 100px;width:200px;" id="myChartLaba"></canvas>
                    </div>
                </div>
                <div class="col-6">
                    <button class="btn btn-warning btn-sm" onclick="filterChart('getPelayanan|api.php|Pelayanan')" data-bs-toggle="modal" data-bs-target="#exampleModal">Filter</button>
                    <div style="width:auto;margin:auto;" style="text-align:center;">
                        <canvas width="200" height="100" style="height: 100px;width:200px;" id="myChartPelayanan"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="container position-absolute card-center2 text-white text-center w-100 mb-2">
            <h3>RUMAH SAKIT</h3>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Filter</h5>
                <button type="button" onclick="document.getElementId('renderBtn').value = ''" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <select style="width: 300px;" name="type-filter" id="type-filter" class="form-control float-right">
                    <option value="1">Periode</option>
                    <option value="2">Tahun</option>
                    <option value="3">Bulan</option>
                </select>
                <div id="periode">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Tanggal Awal</span>
                        </div>
                        <input type="date" id="tanggal-awal" aria-label="First name" class="form-control">
                    </div>
                    <div class="input-group mt-1">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Tanggal Akhir</span>
                        </div>
                        <input type="date" id="tanggal-akhir" aria-label="Last name" class="form-control">
                    </div>
                </div>
                <div id="tahun" style="display: none;">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Tahun</span>
                        </div>
                        <select name="tahun" id="tahun-filter" class="form-control">
                            <?php for ($i = date('Y'); $i >= date('Y') - 4; $i--) {
                                echo '<option value="' . $i . '">' . $i . '</option>';
                            } ?>
                        </select>
                    </div>
                </div>
                <div id="bulan" style="display: none;">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Bulan</span>
                        </div>
                        <select name="bulan" id="bulan-filter" class="form-control">
                            <?php foreach ($dataBulan as $key => $val) {
                                echo '<option value="' . $key . '">' . $val . '</option>';
                            } ?>
                        </select>
                        <div class="input-group-prepend">
                            <span class="input-group-text">Tahun</span>
                        </div>
                        <select name="tahun" id="tahun-filter-bulan" class="form-control">
                            <?php for ($i = date('Y'); $i >= date('Y') - 4; $i--) {
                                echo '<option value="' . $i . '">' . $i . '</option>';
                            } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="document.getElementById('renderBtn').value = ''" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="renderBtn" type="button" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </div>
</div>
<?php
include_once '../templates/footer.php';
?>
