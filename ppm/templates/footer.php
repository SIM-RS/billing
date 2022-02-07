</main>
</div>
</div>

<script>
    var tipe = 1;

    $('#triwulan-filter').click(function() {
        $('#bulan-filter-form').hide();
        $('#triwulan-filter-form').show();
        tipe = 2;
    });

    $('#bulan-filter').click(function() {
        $('#triwulan-filter-form').hide();
        $('#bulan-filter-form').show();
        tipe = 1
    });

    $('#tahun-filter').click(function() {
        $('#triwulan-filter-form').hide();
        $('#bulan-filter-form').hide();
        tipe = 3;
    });

    $('#lihat-grafik').on('click', function() {
        let val = $(this).val();
        $('#btn-grafik').val(val);
    });

    $('#lihat-grafik2').on('click', function() {
        let val = $(this).val();
        $('#btn-grafik2').val(val);
    });

    $('#btn-grafik').on('click',function(){
        let dataVal = $(this).val().split('|');
        let bulan = $('#form-filter-bulan').val();

        let bulanAwal = $('#form-filter-bulan-awal').val();
        let bulanAkhir = $('#form-filter-bulan-akhir').val();

        let tahun = $('#form-filter-tahun').val();
        $.ajax({
            url : dataVal[0],
            method : 'post',
            data : {
                tipe : tipe,
                bulanAwal : bulanAwal,
                bulanAkhir : bulanAkhir,
                bulan : bulan,
                tahun : tahun,
                act : dataVal[1],
            },
            dataType: 'json',
            success:function(data){
                renderChart(data.data.jbr,data.data.kd,data.label,data.title,data.title2);
            }
        });
    });

    $('#btn-grafik2').on('click',function(){
        let dataVal = $(this).val().split('|');
        let bulan = $('#form-filter-bulan').val();

        let bulanAwal = $('#form-filter-bulan-awal').val();
        let bulanAkhir = $('#form-filter-bulan-akhir').val();

        let tahun = $('#form-filter-tahun').val();
        $.ajax({
            url : dataVal[0],
            method : 'post',
            data : {
                tipe : tipe,
                bulanAwal : bulanAwal,
                bulanAkhir : bulanAkhir,
                bulan : bulan,
                tahun : tahun,
                act : dataVal[1],
            },
            dataType: 'json',
            success:function(data){
                renderChart2(data.data,data.label,data.title);
            }
        });
    });
    getListCombo('ruangan');
    getListCombo('ruangan-rep');
    getListCombo('ruangan-irs');
    getListCombo('ruangan-infeksi');
    getListCombo('ruangan-jenis');
    getListCombo('ipcn-print','getIpcn');
    getListCombo('dokter','getDokter');
    function deleteDataPmkp(id){
        let namaTable = $('#nama_table').val();
        if(confirm('Yakin ingin menghapus data ini?')){
            $.ajax({
                url:'../utils.php',
                method:'post',
                data : {
                    id : id,
                    nama_table : namaTable,
                    act : 'delete',
                },
                dataType:'json',
                success:function(data){
                    if(data.status == 200){
                        alert('Berhasil menghapus data!');
                        $('#lihat-data').trigger('click');
                    }else
                        alert('Gagal menghapus data!');
                }
            });
        }
    }

    function deleteDataMirm(id){
        let namaTable = $('#nama_table').val();
        if(confirm('Yakin ingin menghapus data ini?')){
            $.ajax({
                url:'utils.php',
                method:'post',
                data : {
                    id : id,
                    nama_table : namaTable,
                    act : 'delete',
                },
                dataType:'json',
                success:function(data){
                    if(data.status == 200){
                        alert('Berhasil menghapus data!');
                        $('#lihat-data').trigger('click');
                    }else
                        alert('Gagal menghapus data!');
                }
            });
        }
    }

    function resetForm(id){
        document.getElementById(id).reset();
    }
</script>

</body>

</html>