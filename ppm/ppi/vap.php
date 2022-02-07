<?php
include '../templates/header.php';

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
]
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">VAP</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <button type="button" id="modalPemantauan" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#tambahModal">Tambah</button>
            <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#tambahIrsModal" onclick="isiTable('vap-data-table','tampil_jumlah_vap',$('#bulan-irs').val(),$('#tahun-irs').val());">Tambah Pasien Vap</button>
            <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#exampleModal">Laporan Pemantauan Vap</button>
            <button type="button" id="lihat-grafik2" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#graphicModal" value="utils.php|graphVap">Grafik</button>
        </div>
    </div>
</div>
<input type="hidden" name="user_id" id="user_id" value="<?= $_SESSION['userId'] ?>">

<div class="card mt-2">
    <div class="card-header">
        Data Kateter Pasien
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <label for="">No Rm Pasien</label>
                <div class="input-group">
                    <input type="text" name="no_rm" id="no_rm" class="form-control">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" id="cari_pasien" type="button" data-toggle="modal" data-target="#pasienCari">Cari</button>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Nama Pasien</label>
                    <input type="text" name="nama_pasien" readonly id="nama_pasien" class="form-control">
                </div>
            </div>
        </div>
        <input type="hidden" name="id_pasien" id="id_pasien">
        <input type="hidden" name="id_kunjungan" id="id_kunjungan">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="">Bulan</label>
                    <select name="bulan" id="bulan" class="form-control">
                        <?php foreach ($bulan as $key => $val) : ?>
                            <option value="<?= $key ?>" <?= $key == date('m') ? 'selected' : '' ?>><?= $val ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Tahun</label>
                    <select name="tahun" id="tahun" class="form-control">
                        <?php for ($i = 2020 - 5; $i <= date('Y'); $i++) { ?>
                            <option value="<?= $i ?>" <?= $i == date('Y') ? 'selected' : '' ?>><?= $i ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <button class="btn btn-sm btn-primary" id="lihat-data">Lihat</button>
        <div id="table-data"></div>
    </div>
</div>
</div>

<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Data Pemantauan Vap</h5>
                <button onclick="btnCloseButtonClick()" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="infus-form">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Ruangan</label>
                                <select name="ruangan" id="ruangan" class="form-control">
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">JHV</label>
                                <select name="jhv" id="jhv" class="form-control">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <input type="text" name="keterangan" id="keterangan" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Vap</label>
                                <select name="vap" id="vap" class="form-control">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button onclick="btnCloseButtonClick()" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-success" name="actInpus" id="actInpus" type="button" value="simpan-vap">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
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
                <form action="vap/LapVap.php" method="post" target="_blank">
                    <div class="form-group">
                        <label for="">Ruangan</label>
                        <select name="ruangan" id="ruangan-rep" class="form-control">
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Bulan</label>
                                    <select name="bulan" id="bulan-rep" class="form-control">
                                        <?php foreach ($bulan as $key => $val) : ?>
                                            <option value="<?= $key ?>" <?= $key == date('m') ? 'selected' : '' ?>><?= $val ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Tahun</label>
                                    <select name="tahun" id="tahun-rep" class="form-control">
                                        <?php for ($i = 2020 - 5; $i <= date('Y'); $i++) { ?>
                                            <option value="<?= $i ?>" <?= $i == date('Y') ? 'selected' : '' ?>><?= $i ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-success" type="submit" name="act" value="excell">Excell</button>
                    <button class="btn btn-sm btn-primary" type="submit">Lihat</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahIrsModal" tabindex="-1" aria-labelledby="tambahIrsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahIrsModalLabel">Tambah Pasien Vap</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="infeksi-operasi">
                    <div class="form-group">
                        <label for="">Ruangan</label>
                        <select name="ruangan" id="ruangan-irs" class="form-control">
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Bulan</label>
                                <select name="bulan-irs" id="bulan-irs" class="form-control">
                                    <?php foreach ($bulan as $key => $val) : ?>
                                        <option value="<?= $key ?>" <?= $key == date('m') ? 'selected' : '' ?>><?= $val ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Tahun</label>
                                <select name="tahun-irs" id="tahun-irs" class="form-control">
                                    <?php for ($i = 2020 - 5; $i <= date('Y'); $i++) { ?>
                                        <option value="<?= $i ?>" <?= $i == date('Y') ? 'selected' : '' ?>><?= $i ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Jumlah Pasien Vap</label>
                        <input type="text" name="irs" id="irs" class="form-control">
                    </div>
                </form>
                <div id="vap-data-table"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-success" name="actIrs" id="actIrs" type="button" value="simpan">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="graphicModal" tabindex="-1" aria-labelledby="graphicModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="graphicModalLabel"></h5>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Filter
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <button type="button" id="bulan-filter" class="dropdown-item">Bulan</button>
                        <button type="button" id="triwulan-filter" class="dropdown-item">Triwulan</button>
                        <button type="button" id="tahun-filter" class="dropdown-item">Tahun</button>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="bulan-filter-form">
                    <label for="">Bulan</label>
                    <select id="form-filter-bulan" class="form-control form-control-sm">
                        <?php foreach ($bulan as $key => $val) : ?>
                            <option value="<?= $key ?>" <?= $key == date('m') ? 'selected' : '' ?>><?= $val ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div id="triwulan-filter-form" style="display: none;">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Bulan Awal</span>
                        </div>
                        <select id="form-filter-bulan-awal" class="form-control form-control">
                            <?php foreach ($bulan as $key => $val) : ?>
                                <option value="<?= $key ?>" <?= $key == date('m') ? 'selected' : '' ?>><?= $val ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="input-group-prepend">
                            <span class="input-group-text">Bulan Akhir</span>
                        </div>
                        <select id="form-filter-bulan-akhir" class="form-control form-control">
                            <?php foreach ($bulan as $key => $val) : ?>
                                <option value="<?= $key ?>" <?= $key == date('m') ? 'selected' : '' ?>><?= $val ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div id="tahun-filter-form">
                    <label for="">Tahun</label>
                    <select id="form-filter-tahun" class="form-control form-control-sm">
                        <?php for ($i = 2020 - 5; $i <= date('Y'); $i++) { ?>
                            <option value="<?= $i ?>" <?= $i == date('Y') ? 'selected' : '' ?>><?= $i ?></option>
                        <?php } ?>
                    </select>
                </div>
                <button class="btn btn-primary btn-sm mt-2" id="btn-grafik2">Lihat</button>
                <div style="width:100%;height:40%" style="text-align:center;">
                    <canvas id="myChart2"></canvas>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="pasienCari" tabindex="-1" aria-labelledby="pasienCariLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-sm table-bordered">
            <tr>
                <th>Nama</th>
                <th>Tanggal Kunjungan</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <tbody id="table-pasien-cari">
                
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" id="btn-close" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>
    function pilihPasien(val){
        let data = val.split('|');
        $('#id_pasien').val(data[0]);
        $('#id_kunjungan').val(data[1])
        $('#nama_pasien').val(data[2]);
        $('#lihat-data').trigger('click');
        $('#btn-close').trigger('click');
    }
    $('#actIrs').on('click',function(){
        let id_pasien = $('#id_pasien').val();
        let ruangan = $('#ruangan-irs').val();
        let tahunIrs = $('#tahun-irs').val();
        let bulanIrs = $('#bulan-irs').val();
        let userId = $('#user_id').val();
        let vap = $('#irs').val();

        $.ajax({
            url : 'utils.php',
            method : 'post',
            data : {
                ruangan : ruangan,
                tahun : tahunIrs,
                bulan : bulanIrs,
                user_id : userId,
                vap_jumlah : vap,
                act : 'simpan-irs-vap',
            },
            dataType : 'json',
            success:function(data){
                if(data.status == 200){
                    alert('Berhasil memasukan data!');
                    isiTable('vap-data-table','tampil_jumlah_vap',$('#bulan-irs').val(),$('#tahun-irs').val());
                    $('#irs').val('');
                }else{
                    alert('Gagal Memasukan Data');
                }
            }
        });
    });

    $('#cari_pasien').on('click', function() {
        let noRm = $('#no_rm').val();
        if (noRm == '') return alert('Harap masukan no rm pasien terlebih dahulu')
        $.ajax({
            url: 'utils.php',
            method: 'post',
            data: {
                no_rm: noRm,
                act: 'cari_pasien'
            },
            success: function(data) {
               $('#table-pasien-cari').html(data);
            }
        });
    });

    $('#lihat-data').on('click', function() {
        let id = $('#id_pasien').val();
        let bulan = $('#bulan').val();
        let tahun = $('#tahun').val();
        if (id == '') return alert('Harap masukan pasien terlebih dahulu')
        $.ajax({
            url: 'utils.php',
            method: 'post',
            data: {
                id_pasien: id,
                bulan: bulan,
                tahun: tahun,
                act: 'tampil_pasien_vap',
            },
            success: function(data) {
                $('#table-data').html(data);
            }
        });
    });

    $('#actInpus').on('click', function() {
        let id_pasien = $('#id_pasien').val();
        let ruangan = $('#ruangan').val();
        let tanggal = $('#tanggal').val();
        let vap = $('#vap').val();
        let keterangan = $('#keterangan').val();
        let userId = $('#user_id').val();
        let id_kunjungan =$('#id_kunjungan').val();
        let jhv = $('#jhv').val();
        if (id_pasien == '') return alert('Harap masukan pasien terlebih dahulu');
        let id = $('#id').val();
        let act = $(this).val();

        $.ajax({
            url: 'utils.php',
            method: 'post',
            data: {
                id: id,
                pasien_id: id_pasien,
                ruangan: ruangan,
                vap: vap,
                tanggal: tanggal,
                keterangan: keterangan,
                id_kunjungan : id_kunjungan,
                user_id : userId,
                jhv : jhv,
                act: act,
            },
            dataType: 'json',
            success: function(data) {
                if (data.status == 200) {
                    alert('Berhasil '+ (act == 'simpan-vap' ? 'memasukan' : 'update') +' data');
                    document.getElementById('infus-form').reset();
                    $('#lihat-data').trigger('click');
                } else {
                    alert('Gagal '+ (act == 'simpan-vap' ? 'memasukan' : 'update') +' data');
                    document.getElementById('infus-form').reset();
                }
            }

        });
    });

    function deleteInfusData(val) {
        if (confirm("Yakin ingin menghapus data ini ?")) {
            $.ajax({
                url: 'utils.php',
                method: 'post',
                data: {
                    id: val,
                    act: 'delete-vap',
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == 200) {
                        alert('Data berhasil dihapus');
                        $('#lihat-data').trigger('click');
                    } else {
                        alert('Data gagal dihapus');
                    }
                }
            });
        }
    }
    renderChart2([], []);
    var myChart;

    function renderChart2(data,labels, title = '-') {
        var ctx = document.getElementById("myChart2").getContext('2d');
        if (myChart) myChart.destroy();
        myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: title,
                    backgroundColor: 'rgb(2, 117, 216,0.3)',
                    borderColor: 'rgb(2, 117, 216)',
                    data: data,
                }],
            },
        });
    }
    function deleteInfeksiData(val) {
        if (confirm("Yakin ingin menghapus data ini ?")) {
            $.ajax({
                url: 'utils.php',
                method: 'post',
                data: {
                    id: val,
                    act: 'delete-jml-vap',
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == 200) {
                        alert('Data berhasil dihapus');
                        isiTable('vap-data-table','tampil_jumlah_vap',$('#bulan-irs').val(),$('#tahun-irs').val());
                    } else {
                        alert('Data gagal dihapus');
                    }
                }
            });
        }
    }

     $('#bulan-irs').on('change',function(){
        isiTable('vap-data-table','tampil_jumlah_vap',$('#bulan-irs').val(),$('#tahun-irs').val(),$('#ruangan-irs').val());
    });

    $('#tahun-irs').on('change',function(){
        isiTable('vap-data-table','tampil_jumlah_vap',$('#bulan-irs').val(),$('#tahun-irs').val(),$('#ruangan-irs').val());
    });

    $('#ruangan-irs').on('change',function(){
        isiTable('vap-data-table','tampil_jumlah_vap',$('#bulan-irs').val(),$('#tahun-irs').val(),$('#ruangan-irs').val());
    });

    function editInfusData(val){
        let dataEdit = val.split('|');
        $('#id').val(dataEdit[0]);
        $('#ruangan').val(dataEdit[1]);
        $('#tanggal').val(dataEdit[2]);
        $('#vap').val(dataEdit[3]);
        $('#keterangan').val(dataEdit[4]);
        $('#jhv').val(dataEdit[5]);
        $('#actInpus').val('update-vap');
        $('#actInpus').html('Update');  
        $('#modalPemantauan').trigger('click');
    }
    function btnCloseButtonClick(){
        $('#actInpus').val('simpan-vap');
          $('#actInpus').html('Save');
        document.getElementById('infus-form').reset();
    }
</script>
<?php
include '../templates/footer.php';
?>