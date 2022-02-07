<?php
require '../templates/header.php';
require '../function/connection.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">IPCN</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <button type="button" id="tambahData" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#tambahModal">Tambah</button>
        </div>
    </div>
</div>

<table class="table table-sm table-striped">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Action</th>
    </tr>
    <tbody id="data-ruangan">
        
    </tbody>
</table>

<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah</h5>
                <button type="button" onclick="resetForm()" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="id">
                <div class="form-group">
                    <label for="">Nama</label>
                    <input type="text" name="nama_ipcn" id="nama_ipcn" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="resetForm()" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-act" value="simpanIpcn">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
	renderData();
    $('#btn-act').click(function() {
        let id = $('#id').val();
        let namaRuangan = $('#nama_ipcn').val();
        let act = $(this).val();
        let alertM = "menambah";
        if (act == 'editIpcn') alertM = "mengubah";

        if(namaRuangan == '' || namaRuangan == undefined) return alert('Form di isi terlebih dahulu');
        $.ajax({
            url: 'utils.php',
            method: 'post',
            data: {
                id: id,
                nama: namaRuangan,
                act: act,
            },
            dataType: 'json',
            success: function(data) {
                if (data == 200) {
                    alert('Berhasil ' + alertM + ' data');
                    renderData();
                } else {
                    alert('Gagal ' + alertM + ' data');
                }
                $('.close').trigger('click');
                resetForm();
            }
        });
    });

    function renderData() {
        $.ajax({
            url: 'utils.php',
            method: 'post',
            data: {
                act: 'getDataIpcn',
            },
            success: function(data) {
                $('#data-ruangan').html(data);
            }
        })
    }

    function deleteData(val) {
        if (confirm('Yakin Ingin Menghapus Data Ini ?')) {
            $.ajax({
                url: 'utils.php',
                method: 'post',
                data: {
                    id: val,
                    act: 'deleteIpcn',
                },
                dataType: 'json',
                success: function(data) {
                    if (data == 200) {
                        alert('Berhasil hapus data');
                        renderData();
                    } else {
                        alert('Gagal hapus data');
                    }
                }
            });
        }
    }

    function edit(val) {
        let dataVal = val.split('|');
        $('#id').val(dataVal[0]);
        $('#nama_ipcn').val(dataVal[1]);
        $('#btn-act').val('editIpcn');
        $('#tambahData').trigger('click');
    }

    function resetForm() {
        $('#id').val('');
        $('#nama_ipcn').val('');
        $('#btn-act').val('simpanIpcn');
    }
</script>

<?php
require '../templates/footer.php'
?>