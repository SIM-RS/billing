<?php
include '../../templates/header3.php';
$title = 'LAPORAN ANGKA KEJADIAN PETUGAS TERTUSUK JARUM <br /> (NEEDLE STICK INJURY) <br /> RUMAH SAKIT UMUM ANDHIKA';
$thData = ['No','Tanggal Tertusuk','Area Tertusuk','Ruangan','Tindak Lanjut','Action'];
$namaTable = "ppi_laporan_tertusuk_jarum";
$act = "tampil_data_tertusuk_jarum";
$laporan = "laporan.php";
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= $title ?></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" id="modalPemantauan" data-toggle="modal" data-target="#tambahModal">Tambah</button>
            <button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#exampleModal">Laporan</button>
        </div>
    </div>
</div>

<?php
    include '../form-laporan-tertusuk-jarum.php';
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
                        <label for="">Ruangan</label>
                        <select name="ruangan" id="ruangan" class="form-control">
                        </select>
                    </div>
                    </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Tanggal Kejadian</label>
                                <input type="date" id="tgl_kejadian" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Nama Petugas</label>
                                <select name="dokter2" id="dokter2" class="form-control"></select>
                            </div>
                            <div class="form-group">
                                <label for="">Jenis Kejadian</label>
                                <input type="text" id="jenis_kejadian" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Jam Kejadian</label>
                                <input type="time" id="jam_kejadian" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Area Yang Tertusuk</label>
                                <textarea id="area" cols="30" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Tindak Lanjut</label>
                                <textarea id="tindak" cols="30" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="btnCloseButtonClick()">Close</button>
                <button class="btn btn-success" name="btn-act" id="btn-act" type="button" value="simpan-laporan-tertusuk-jarum">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
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
                            <div class="col-6">
                        <div class="form-group">
                        <label for="">Ruangan</label>
                        <select name="id_ruangan" id="ruangan2" class="form-control">
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


<script>
    getListCombo('ruangan2');
    getListCombo('dokter2','getDokter');
    $('#btn-act').on('click',function(){
        let ruangan = $('#ruangan').val();
        let id = $('#id').val();
        let tgl_kejadian = $('#tgl_kejadian').val();
        let nama_petugas = $('#dokter2').val();
        let jenis_kejadian = $('#jenis_kejadian').val();
        let jam = $('#jam_kejadian').val();
        let area = $('#area').val();
        let tindak = $('#tindak').val();
        let act = $(this).val();
        $.ajax({
            url : '../utils.php',
            method : 'post',
            data : {
                id : id,
                ruangan : ruangan,
                tgl_kejadian : tgl_kejadian,
                id_dokter : nama_petugas,
                jenis_kejadian : jenis_kejadian,
                jam : jam,
                area : area,
                tindak : tindak,
                act : act,
            },
            dataType:'json',
            success:function(data){
                if(data.status == 200){
                    if(act == "simpan-laporan-tertusuk-jarum")
                        alert('Berhasil menambah data!');
                    else
                        alert('Berhasil edit data!');
                    resetForm('form-input');
                    btnCloseButtonClick();
                    $('#lihat-data').trigger('click');
                }else{
                    if(act == "simpan-laporan-tertusuk-jarum")
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
        $('#ruangan').val(arrData[1]);
        $('#tgl_kejadian').val(arrData[2]);
        $('#jam_kejadian').val(arrData[3]);
        $('#dokter2').val(arrData[4]);
        $('#jenis_kejadian').val(arrData[5]);
        $('#area').val(arrData[6]);
        $('#tindak').val(arrData[7]);
        $('#btn-act').val("edit-laporan-tertusuk-jarum");
        $('#btn-act').html("Edit");
        $('#modalPemantauan').trigger('click');
    }

    function btnCloseButtonClick(){
        resetForm('form-input');
        $('#btn-act').val("simpan-laporan-tertusuk-jarum");
        $('#btn-act').html("Save");
    }
</script>

<?php
include '../../templates/footer.php';
?>