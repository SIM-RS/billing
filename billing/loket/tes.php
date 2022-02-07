<input type="button" onclick="tes()" /><br/>
kalau edit status pasien, cek apakah status pasien sebelumnya sama?<br/>
kalo sama update b_bayar, kalau tidak insert ke b_bayar<br/>
untuk insert ke b_bayar inap = 0,kalo inap = 1 tidak insert ke b_bayar<br/>
kelanjutannya dikasih pilihan untuk update data pasien sebelum diupdate statusnya atau tidak.
<script>
function tes(){


/*
 * insert biaya tindakan jika pindah kelas untuk kso khususnya rawat inap
 */
    if(confirm('apakah yakin?')){
        alert('yakin');
    }
    else{
        if(confirm('serius?')){
            alert('serius');
        }
        else{
            alert('bercanda');
        }
    }
}
</script>