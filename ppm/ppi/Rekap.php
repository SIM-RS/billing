<?php 
require '../templates/header.php';
$bulan = [
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

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">REKAP</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <button onclick="setAction(this.value)" data-toggle="modal" data-target="#exampleModal" type="button" value="<?= $BASE_URL ?>/ppi/bedres/rekapdecubitus.php" class="btn btn-sm btn-primary">Laporan Angka Decubitus</button>
        <button onclick="setAction(this.value)" data-toggle="modal" data-target="#exampleModal" type="button" value="<?= $BASE_URL ?>/ppi/infus/rekapplebitis.php" class="btn btn-sm btn-primary">Laporan Angka Plebitis</button>
        <button onclick="setAction(this.value)" data-toggle="modal" data-target="#exampleModal" type="button" value="<?= $BASE_URL ?>/ppi/operasi/rekapoperasi.php" class="btn btn-sm btn-primary">Laporan Angka Operasi</button>
        <button onclick="setAction(this.value)" data-toggle="modal" data-target="#exampleModal" type="button" value="<?= $BASE_URL ?>/ppi/kateter/rekapcateter.php" class="btn btn-sm btn-primary">Laporan Angka Cateter</button>
        <button onclick="setAction(this.value)" data-toggle="modal" data-target="#exampleModal" type="button" value="<?= $BASE_URL ?>/ppi/iadp/rekapiadp.php" class="btn btn-sm btn-primary">Laporan Angka IADP</button>
        <button onclick="setAction(this.value)" data-toggle="modal" data-target="#exampleModal" type="button" value="<?= $BASE_URL ?>/ppi/vap/rekapvap.php" class="btn btn-sm btn-primary">Laporan Angka VAP</button>
        <button onclick="setAction(this.value)" data-toggle="modal" data-target="#exampleModal" type="button" value="<?= $BASE_URL ?>/ppi/rekapsurvelans.php" class="btn btn-sm btn-primary">Laporan Suvelans</button>
        <button data-toggle="modal" data-target="#hais" type="button" class="btn btn-sm btn-primary">Laporan Hais</button>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="rekap" action="" method="post" target="_blank">
                    <div class="form-group">
                        <label for="">Tahun</label>
                        <select name="tahun" id="tahun" class="form-control">
                            <?php for ($i = 2020 - 5; $i <= date('Y'); $i++) { ?>
                                <option value="<?= $i ?>" <?= $i == date('Y') ? 'selected' : '' ?>><?= $i ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button  class="btn btn-sm btn-success" type="submit" name="act" value="excell">Excell</button>
                    <button  class="btn btn-sm btn-primary" type="submit">Lihat</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="hais" tabindex="-1" aria-labelledby="haisLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="haisLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="rekap" action="rekaphais.php" method="post" target="_blank">
                    <div class="form-group">
                        <select name="filter" id="filter" class="form-control">
                            <option value="1">Bulanan</option>
                            <option value="2">Triwulan I</option>
                            <option value="3">Triwulan II</option>
                            <option value="4">Triwulan III</option>
                            <option value="5">Triwulan IV</option>
                            <option value="6">Semester I</option>
                            <option value="7">Semester II</option>
                            <option value="8">Tahunan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="bulan" id="bulan" class="form-control">
                        <?php foreach ($bulan as $key => $val) : ?>
                            <option value="<?= $key ?>" <?= $key == date('m') ? 'selected' : '' ?>><?= $val ?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tahun</label>
                        <select name="tahun-hais" id="tahun-hais" class="form-control">
                            <?php for ($i = 2020 - 5; $i <= date('Y'); $i++) { ?>
                                <option value="<?= $i ?>" <?= $i == date('Y') ? 'selected' : '' ?>><?= $i ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button  class="btn btn-sm btn-success" type="submit" name="act" value="excell">Excell</button>
                    <button  class="btn btn-sm btn-primary" type="submit">Lihat</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    function setAction(val){
        console.log(val);
        document.getElementById('rekap').action = val;
    }
    $('#filter').on('change',function(){
        if($(this).val() == 1){
            $('#bulan').show();
        }else{
            $('#bulan').hide();
        }
    });
</script>
<?php require '../templates/footer.php' ?>