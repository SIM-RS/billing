<?php
include '../../templates/header3.php';
$title = 'EVALUASI ATAU ANALISA SURVEY PELAKSANAAN KEPATUHAN CUCI TANGAN';
$thData = ['No','Tanggal Survey','Nama Ruangan','Action'];
$namaTable = "ppi_evaluasi_cuci_tangan";
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
                                <label for="">Tanggal Survey</label>
                                <input type="date" id="tgl_survey" class="form-control">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Nama Petugas</label>
                                <select name="dokter2" id="dokter2" class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-12">
                           <table class="table table-striped mt-2 table-sm">
                                <tr class="text-center">
                                    <th>ASPEK</th>
                                    <th>YA</th>
                                    <th>TIDAK</th>
                                </tr>
                                <tr>
                                    <td>Kepatuhan Cuci Tangan</td>
                                    <td><input type="number" value="0" class="pilihan"></td>
                                    <td><input type="number" value="0" class="pilihan"></td>
                                </tr>
                                <tr>
                                    <td>Sebelum kontak dengan pasien (n=10)</td>
                                    <td><input type="number" value="0" class="pilihan"></td>
                                    <td><input type="number" value="0" class="pilihan"></td>
                                </tr>
                                <tr>
                                    <td>Setelah kontak dengan pasien (n=10)</td>
                                    <td><input type="number" value="0" class="pilihan"></td>
                                    <td><input type="number" value="0" class="pilihan"></td>
                                </tr>
                                <tr>
                                    <td>Sebelum tindakan aseptic (n=10)</td>
                                    <td><input type="number" value="0" class="pilihan"></td>
                                    <td><input type="number" value="0" class="pilihan"></td>
                                </tr>
                                <tr>
                                    <td>Setelah kontak dengan cairan tubuh </td>
                                    <td><input type="number" value="0" class="pilihan"></td>
                                    <td><input type="number" value="0" class="pilihan"></td>
                                </tr>
                                <tr>
                                    <td>Setelah kontak dengan lingkungan pasien</td>
                                    <td><input type="number" value="0" class="pilihan"></td>
                                    <td><input type="number" value="0" class="pilihan"></td>
                                </tr>
                           </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="btnCloseButtonClick()">Close</button>
                <button class="btn btn-success" name="btn-act" id="btn-act" type="button" value="simpan-evaluasi-cuci-tangan">Save</button>
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
                        </div>
                    </div>
                    <input type="hidden" name="id_petugas" id="id_petugas">
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
        let tgl_kejadian = $('#tgl_survey').val();
        let nama_petugas = $('#dokter2').val();
        let pilihan = document.querySelectorAll(".pilihan");
        let ya = "";let tidak = "";
        let act = $(this).val();
        for (let i = 0; i < pilihan.length; i=i+2) {
            ya += pilihan[i].value + "|";
            tidak += pilihan[i+1].value + "|";
        }
        $.ajax({
            url : '../utils.php',
            method : 'post',
            data : {
                id : id,
                ruangan : ruangan,
                ya : ya,
                tidak : tidak,
                tgl_kejadian : tgl_kejadian,
                id_dokter : nama_petugas,
                act : act,
            },
            dataType:'json',
            success:function(data){
                if(data.status == 200){
                    if(act == "simpan-evaluasi-cuci-tangan")
                        alert('Berhasil menambah data!');
                    else
                        alert('Berhasil edit data!');
                    resetForm('form-input');
                    btnCloseButtonClick();
                    $('#lihat-data').trigger('click');
                }else{
                    if(act == "simpan-evaluasi-cuci-tangan")
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
        $('#dokter2').val(arrData[2]);
        $('#tgl_survey').val(arrData[3]);
        let inputs = document.querySelectorAll(".pilihan");
        let q = 0;
        for (let index = 4; index < 10; index++) {
            inputs[q].value = arrData[index];
            inputs[q+1].value = arrData[index+7];
            q=q+2;
        }
        $('#btn-act').val("edit-evaluasi-cuci-tangan");
        $('#btn-act').html("Edit");
        $('#modalPemantauan').trigger('click');
    }

    function btnCloseButtonClick(){
        resetForm('form-input');
        $('#btn-act').val("simpan-evaluasi-cuci-tangan");
        $('#btn-act').html("Save");
    }
</script>

<?php
include '../../templates/footer.php';
?>