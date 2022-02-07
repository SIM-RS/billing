<?php

include '../koneksi/konek.php';

//get data kunjungan pada bulan 1
$sqlGetTindakan = "SELECT
bp.unit_id,
bt.* 
FROM
b_tindakan bt
LEFT JOIN b_pelayanan bp ON bp.id = bt.pelayanan_id
WHERE
bt.kso_id != 1 
AND bt.tgl BETWEEN '2021-01-11' 
AND '2021-01-31'
AND bp.unit_id not in (237,33,184,185,183,186)
ORDER BY
bt.kunjungan_id ASC";
$query = mysql_query($sqlGetTindakan);
$count = 0;
while($rows = mysql_fetch_array($query)){
    if($rows['ms_tindakan_kelas_id'] == 0) continue;
    //cek apakah dia sudah sama dengan harga multitarif
    $queryMsTindakanKelas = mysql_query("SELECT ms_tindakan_id FROM b_ms_tindakan_kelas WHERE id = {$rows['ms_tindakan_kelas_id']}");
    $ms_tindakan_id = mysql_fetch_assoc($queryMsTindakanKelas);
    //get harga kelas
    if(mysql_num_rows($queryMsTindakanKelas) > 0){
        
        $queryTindakanKelas = mysql_query("SELECT bmtk.* FROM b_ms_tindakan_kelas bmtk
        INNER JOIN b_ms_tindakan_unit bmu ON bmu.ms_tindakan_kelas_id = bmtk.id WHERE bmtk.ms_tindakan_id = {$ms_tindakan_id['ms_tindakan_id']} AND bmtk.kso_id = {$rows['kso_id']} AND bmtk.aktif = 1 AND bmu.ms_unit_id = {$rows['unit_id']}");
        
        $tindakanKelas = mysql_fetch_assoc($queryTindakanKelas);
        
        if(mysql_num_rows($queryTindakanKelas) == 0){
            $queryTindakanKelas = mysql_query("SELECT id,tarip FROM b_ms_tindakan_kelas WHERE ms_tindakan_id = {$ms_tindakan_id['ms_tindakan_id']} AND kso_id = 1 AND aktif = 1");
            $tindakanKelas = mysql_fetch_assoc($queryTindakanKelas);
        }
        
        if($tindakanKelas['id'] != $rows['ms_tindakan_kelas_id']){
            echo $rows['kunjungan_id'].'<br>';
            mysql_query("UPDATE b_tindakan SET biaya = {$tindakanKelas['tarip']},biaya_kso = {$tindakanKelas['tarip']},ms_tindakan_kelas_id = {$tindakanKelas['id']} WHERE id = {$rows['id']} AND tgl BETWEEN '2021-01-11' AND '2021-01-31' AND flag = 1");
            ++$count;
        }
    }
}

echo '<br><br>'.$count;