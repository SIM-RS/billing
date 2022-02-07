<input type="hidden" name="user_id" id="user_id" value="<?= $_SESSION['userId'] ?>">
<input type="hidden" name="nama_table" id="nama_table" value="<?= $namaTable ?>">
<div class="card mt-2">
    <div class="card-header">
        Data <?= $title ?>
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
                        <?php foreach ($bulanData as $key => $val) : ?>
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
        <button class="btn btn-sm btn-primary" id="lihat-data" value="<?= $act ?>">Lihat</button>
        <table class="table table-sm table-striped mt-2">
            <thead>
                <tr>
                    <?php for($i = 0; $i < sizeof($thData); $i++) echo '<th>'.$thData[$i].'</th>'; ?>
                </tr>
            </thead>
            <tbody id="table-data">

            </tbody>
        </table>
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
            </div>
        </div>
    </div>
</div>
<script>
    $('#cari_pasien').on('click', function() {
        let noRm = $('#no_rm').val();
        if (noRm == '') return alert('Harap masukan no rm pasien terlebih dahulu')
        $.ajax({
            url: '../utils.php',
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
        let id_kunjungan = $('#id_kunjungan').val();
        let namaTable = $('#nama_table').val();
        let act = $(this).val();
        if (id == '') return alert('Harap masukan pasien terlebih dahulu')
        $.ajax({
            url: '../utils.php',
            method: 'post',
            data: {
                id_pasien: id,
                id_kunjungan : id_kunjungan,
                bulan: bulan,
                tahun: tahun,
                nama_table : namaTable,
                act: act,
            },
            success: function(data) {
                $('#table-data').html(data);
            }
        });
    });
    function pilihPasien(val){
        let data = val.split('|');
        $('#id_pasien').val(data[0]);
        $('#id_kunjungan').val(data[1])
        $('#nama_pasien').val(data[2]);
        $('#lihat-data').trigger('click');
        $('#btn-close').trigger('click');
    }
</script>