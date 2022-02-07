<?php
include '../../templates/header3.php';
$title = 'Kepuasan Pasien Dan Keluarga';
$thData = ['No','Nama','Waktu Datang','Waktu Pelayanan','Kepuasan','Action'];
$namaTable = "ppi_kepuasan_pasien";
$act = "tampil_kepuasan_pasien";
$laporan = "laporan.php";
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= $title ?></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" id="modalPemantauan" data-toggle="modal" data-target="#tambahModal">Tambah</button>
            <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#exampleModal">Laporan</button>
            <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#rekapModal">Rekap</button>
        </div>
    </div>
</div>

<?php
    include '../form-pasien.php';
?>

<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah Data <?= $title ?></h5>
                <button type="button" class="close" onclick="btnCloseButtonClick()" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-input">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Tanggal Pelayanan</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Jam Dilayani</label>
                                <input type="time" name="jam_dilayani" id="jam_dilayani" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Pulang Pasien</label>
                                <input type="date" name="tanggal_pulang" id="tanggal_pulang" class="form-control">
                            </div>
                        </div>
                        
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Dokter</label>
                                <select name="dokter" id="dokter" class="form-control"></select>
                            </div>
                            <div class="form-group">
                                <label for="">Kepuasan</label>
                                <select name="pilihan" id="pilihan" class="form-control">
                                    <option value="ya"><?= 'Ya' ?></option>
                                    <option value="tidak"><?= 'Tidak' ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="btnCloseButtonClick()">Close</button>
                <button class="btn btn-success" name="btn-act" id="btn-act" type="button" value="simpan-kepuasan-pasien">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rekapModal" tabindex="-1" aria-labelledby="rekapModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rekapModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="rekap.php" method="post" target="_blank">
                 
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Bulan</label>
                                    <select name="bulan" id="bulan-rep" class="form-control">
                                        <?php foreach ($bulanData as $key => $val) : ?>
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

<?php include '../form-laporan-no-ruangan.php' ?>

<script>
    $('#btn-act').on('click',function(){
        let id = $('#id').val();
        let id_pasien = $('#id_pasien').val();
        let id_kunjungan = $('#id_kunjungan').val();
        let id_dokter = $('#dokter').val();
        let user_id = $('#user_id').val();
        let tanggal = $('#tanggal').val();
        let jam_dilayani = $('#jam_dilayani').val();
        let tanggal_pulang = $('#tanggal_pulang').val();
        let pilihan = $('#pilihan').val();
        let act = $(this).val();
        $.ajax({
            url : '../utils.php',
            method : 'post',
            data : {
                id : id,
                id_pasien : id_pasien,
                id_kunjungan : id_kunjungan,
                id_dokter : id_dokter,
                user_id : user_id,
                tanggal : tanggal,
                jam_dilayani : jam_dilayani,
                tanggal_pulang : tanggal_pulang,
                pilihan : pilihan,
                act : act,
            },
            dataType:'json',
            success:function(data){
                if(data.status == 200){
                    if(act == "simpan-kepuasan-pasien")
                        alert('Berhasil menambah data!');
                    else
                        alert('Berhasil edit data!');
                    resetForm('form-input');
                    $('#lihat-data').trigger('click');
                }else{
                    if(act == "simpan-kepuasan-pasien")
                        alert('Gagal menambah data!');
                    else
                        alert('Gagal mengubah data!');
                }
            }
        })
    });

    function editData(val){

        let arrData = val.split('|');
        $('#id').val(arrData[0]);
        $('#jam_dilayani').val(arrData[1]);
        $('#tanggal').val(arrData[2]);
        $('#pilihan').val(arrData[3]);
        $('#dokter').val(arrData[4]);
           $('#tanggal_pulang').val(arrData[5]);
        $('#btn-act').val("edit-kepuasan-pasien");
        $('#btn-act').html("Edit");
        $('#modalPemantauan').trigger('click');
    }

    function btnCloseButtonClick(){
        resetForm('form-input');
        $('#btn-act').val("simpan-kepuasan-pasien");
        $('#btn-act').html("Save");
    }
</script>

<?php
include '../../templates/footer.php';
?>