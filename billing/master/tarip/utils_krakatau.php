<?php
include '../../sesi.php';
include '../../koneksi/konek.php';
include '../../Excell/reader.php';


$getData = basename($_FILES['tindakanTarif']['name']);
move_uploaded_file($_FILES['tindakanTarif']['tmp_name'], $getData);

$user = $_SESSION['user_id'];

$reader = new Spreadsheet_Excel_Reader();

$reader->read($_FILES['tindakanTarif']['name']);

$reader->setUTFEncoder('iconv');
$reader->setOutputEncoding('UTF-8');

$sheet = $reader->sheets[0];
$rows = $sheet['numRows'];
$cols = $sheet['numCols'];
$ret = array();
$nameField = ['', 'id_tindakan', 'nama_tindakan', 'id_kso', 'nama_kso', 'id_tmpt_layanan', 'nama_tmpt_layanan'];
$count = 0;
for ($i = 2; $i <= $rows; $i++) {
    $line = array("tarif_kelas" => array());
    for ($j = 1; $j <= $cols; $j++) {

        // Ini untuk ngecek apakah datanya ada di sell tersebut atau tidak
        if (isset($sheet['cells'][$i])) {
            if ($j <= 6) {
                $line[$nameField[$j]] = $sheet['cells'][$i][$j];
            } else {
                if ($sheet['cells'][$i][$j + 1] == '' || $sheet['cells'][$i][$j + 1] == NULL) $count++;
                array_push(
                    $line['tarif_kelas'],
                    array(
                        "id_kelas" => $sheet['cells'][$i][$j],
                        "tarip" => $sheet['cells'][$i][$j + 1]
                    )
                );
                $j++;
            }
        } else {
            echo "gabisa{$i} {$j}";
        }
    }
    if ($count == 19) {
        $count = 0;
        continue;
    }

    $ret[] = $line;

    if ($limit != 0 && count($ret) >= $limit) {
        break;
    }
    $count = 0;
}

$sql = [];
for ($i = 0; $i < sizeof($ret); $i++) {
    //get kode unit
    $getUnit = mysql_fetch_assoc(mysql_query("SELECT kode FROM b_ms_unit WHERE id = {$ret[$i]['id_tmpt_layanan']}"));
    foreach ($ret[$i]['tarif_kelas'] as $val) {
        if ($val['tarip'] == '' || $val['tarip'] == 0) continue;
        //lakukan pengecekan apakah sudah pernah di input datanya
        $sqlCek = "SELECT id,tarip FROM b_ms_tindakan_kelas WHERE ms_tindakan_id = {$ret[$i]['id_tindakan']} AND ms_kelas_id = {$val['id_kelas']} AND kso_id = {$ret[$i]['id_kso']}";
        $query = mysql_query($sqlCek);
        if (mysql_num_rows($query) > 0) {
            //jika sudah cek lagi harganya apakah harga nya beda atau sama
            $fetch  = mysql_fetch_array($query);
            if ($fetch['tarip'] != $val['tarip']) {
                //jika sama update tarip datanya
                mysql_query("UPDATE b_ms_tindakan_kelas SET tarip = {$val['tarip']} WHERE id = {$fetch['id']}");
                continue;
            } else {
                $queryCekAdaAtauTidak = mysql_query("SELECT * FROM b_ms_tindakan_unit WHERE ms_tindakan_kelas_id = {$fetch['id']} AND ms_unit_id = {$ret[$i]['id_tmpt_layanan']} AND flag = 2");
                if (mysql_num_rows($queryCekAdaAtauTidak) == 0) {
                    mysql_query("INSERT INTO b_ms_tindakan_unit(ms_tindakan_kelas_id,ms_unit_id,kode_unit,flag)VALUES({$fetch['id']},{$ret[$i]['id_tmpt_layanan']},'{$getUnit['kode']}',2)");
                }
                continue;
            }
        }
        if (mysql_query("INSERT INTO b_ms_tindakan_kelas(ms_tindakan_id,ms_kelas_id,tarip,kso_id,user_act)VALUES({$ret[$i]['id_tindakan']},{$val['id_kelas']},{$val['tarip']},{$ret[$i]['id_kso']},{$user})")) {
            $idTindakanKelas = mysql_insert_id();
            mysql_query("INSERT INTO b_ms_tindakan_unit(ms_tindakan_kelas_id,ms_unit_id,kode_unit,flag)VALUES({$idTindakanKelas},{$ret[$i]['id_tmpt_layanan']},'{$getUnit['kode']}',2)");
        }
    }
}

unlink($_FILES['tindakanTarif']['name']);
?>
<script>
    // alert('berhasil memasukan atau update ' + <?= $count ?> + ' data | gagal memasukan ' +  <?= $gagal ?> + ' data');
    window.location = 'index_krakatau.php';
</script>