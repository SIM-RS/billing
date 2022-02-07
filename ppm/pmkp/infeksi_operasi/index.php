<?php
include '../../templates/header3.php';
$title = 'Infeksi Operasi';
$thData = ['No','Nama','Tanggal Operasi','Jenis Operasi','Infeksi Operasi','Tanggal Infeksi Operasi','Action'];
$namaTable = "ppi_infeksi_operasi_pmkp";
$act = "tampil_data_infeksi_operasi";
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
                                <label for="">Ruangan</label>
                                <select name="ruangan" id="ruangan" class="form-control">
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Operasi</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal infeksi</label>
                                <input type="date" name="tanggal-infeksi" id="tanggal-infeksi" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="">Dokter</label>
                                <select name="dokter" id="dokter" class="form-control"></select>
                            </div>
                            <div class="form-group">
                                <label for="">Jenis Operasi</label>
                                <select name="jenis_operasi" id="jenis_operasi" class="form-control">
                                    <option value="ob">OB</option>
                                    <option value="obt">OBT</option>
                                    <option value="ok">OK</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Infeksi</label>
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
                <button class="btn btn-success" name="btn-act" id="btn-act" type="button" value="simpan-infeksi-operasi">Save</button>
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
                                    <label for="">Bulan Awal</label>
                                    <input type="date" name="bulan-awal" id="bulan-awal" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                            <div class="form-group">
                                    <label for="">Bulan Akhir</label>
                                    <input type="date" name="bulan-akhir" id="bulan-akhir" class="form-control">
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

<?php include '../form-laporan.php' ?>

<script>
    $('#btn-act').on('click',function(){
        let id = $('#id').val();
        let ruangan = $('#ruangan').val();
        let id_pasien = $('#id_pasien').val();
        let id_kunjungan = $('#id_kunjungan').val();
        let id_dokter = $('#dokter').val();
        let user_id = $('#user_id').val();
        let tanggal = $('#tanggal').val();
        let tanggal_infeksi = $('#tanggal-infeksi').val();
        let pilihan = $('#pilihan').val();
        let jenisOperasi = $('#jenis_operasi').val();
        let act = $(this).val();
        $.ajax({
            url : '../utils.php',
            method : 'post',
            data : {
                id : id,
                ruangan : ruangan,
                id_pasien : id_pasien,
                id_kunjungan : id_kunjungan,
                id_dokter : id_dokter,
                user_id : user_id,
                tanggal : tanggal,
                tanggal_infeksi : tanggal_infeksi,
                pilihan : pilihan,
                jenis_operasi : jenisOperasi,
                act : act,
            },
            dataType:'json',
            success:function(data){
                if(data.status == 200){
                    if(act == "simpan-infeksi-operasi")
                        alert('Berhasil menambah data!');
                    else
                        alert('Berhasil edit data!');
                    resetForm('form-input');
                    $('#lihat-data').trigger('click');
                }else{
                    if(act == "simpan-infeksi-operasi")
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
        $('#tanggal').val(arrData[2]);
        $('#jenis_operasi').val(arrData[3]);
        $('#tanggal-infeksi').val(arrData[4]);
        $('#pilihan').val(arrData[5]);
        $('#dokter').val(arrData[6]);
        $('#btn-act').val("edit-infeksi-operasi");
        $('#btn-act').html("Edit");
        $('#modalPemantauan').trigger('click');
    }

    function btnCloseButtonClick(){
        resetForm('form-input');
        $('#btn-act').val("simpan-infeksi-operasi");
        $('#btn-act').html("Save");
    }
</script>

<?php
include '../../templates/footer.php';
?>