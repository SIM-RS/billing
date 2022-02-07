<?php
require '../../autoload.php';
require '../../templates/headerlap.php';
if($_REQUEST['act'] == "excell"){
    header("Content-type: application/vnd.ms-excel");
    header('Content-Disposition: attachment; filename="LAP PPI PEMASANGAN INFUS.xls"');
}

$konek = new Connection();
function pasienPlebitis($bulan,$tahun,$ruangan,$konek){
    $sql = "SELECT COUNT(pasien_id) as banyak FROM (SELECT * FROM ppi_infus WHERE MONTH(tanggal) = {$bulan} AND YEAR(tanggal) = {$tahun} AND ruangan = {$ruangan} GROUP BY pasien_id) as q";
    $data = $konek->rawQuery($sql)->fetch_assoc();
    return $data['banyak'];
}
function pasienHariPlebitis($bulan,$tahun,$ruangan,$konek){
    $sql = "SELECT SUM(jhi) as banyak FROM ppi_infus WHERE MONTH(tanggal) = {$bulan} AND ruangan = {$ruangan} AND YEAR(tanggal) = {$tahun}";
    $data = $konek->rawQuery($sql)->fetch_assoc();
    return $data['banyak'] == null ? 0 : $data['banyak'];
}
function pasienPlebitisJumlah($bulan,$tahun,$ruangan,$konek){
    $sql = "SELECT COUNT(pasien_id) as banyak FROM ppi_infus WHERE MONTH(tanggal) = {$bulan} AND ruangan = {$ruangan} AND kp = 1 AND YEAR(tanggal) = {$tahun}";
    $data = $konek->rawQuery($sql)->fetch_assoc();
    return $data['banyak'];
}
function table($bulan1,$bulan2,$bulan3,$triwulan,$tahun,$konek){
    $bulanArr = [
        1 => 'JANUARI',
        2 => 'PEBRUARI',
        3 => 'MARET',
        4 => 'APRIL',
        5 => 'MEI',
        6 => 'JUNI',
        7 => 'JULI',
        8 => 'AGUSTUS',
        9 => 'SEPTEMBER',
        10 => 'OKTOBER',
        11 => 'NOPEMBER',
        12 => 'DESEMBER',
    ];
    $bulanArr2 = [
        1 => 'JAN',
        2 => 'PEB',
        3 => 'MAR',
        4 => 'APR',
        5 => 'MEI',
        6 => 'JUN',
        7 => 'JUL',
        8 => 'AGST',
        9 => 'SEP',
        10 => 'OKT',
        11 => 'NOP',
        12 => 'DES',
    ];
    echo 'Angka Plebitis Bulan '.$bulanArr[$bulan1].','.$bulanArr[$bulan2].','.$bulanArr[$bulan3]. ' ' . $tahun;
    echo '<table border="1" class="table table-bordered table-sm">
    <tr>
        <th rowspan="2" style="text-align:center;vertical-align:middle">No</th>
        <th rowspan="2" style="text-align:center;vertical-align:middle">Ruang</th>
        <th colspan="3" style="text-align:center;vertical-align:middle">Px Terpasang Infus</th>
        <th colspan="3" style="text-align:center;vertical-align:middle">Hari Terpasang Infus</th>
        <th colspan="3" style="text-align:center;vertical-align:middle">Positip Plebitis</th>
    </tr>
    <tr>
        <th style="text-align:center;vertical-align:middle">'.$bulanArr2[$bulan1].'</th>
        <th style="text-align:center;vertical-align:middle">'.$bulanArr2[$bulan2].'</th>
        <th style="text-align:center;vertical-align:middle">'.$bulanArr2[$bulan3].'</th>
        <th style="text-align:center;vertical-align:middle">'.$bulanArr2[$bulan1].'</th>
        <th style="text-align:center;vertical-align:middle">'.$bulanArr2[$bulan2].'</th>
        <th style="text-align:center;vertical-align:middle">'.$bulanArr2[$bulan3].'</th>
        <th style="text-align:center;vertical-align:middle">'.$bulanArr2[$bulan1].'</th>
        <th style="text-align:center;vertical-align:middle">'.$bulanArr2[$bulan2].'</th>
        <th style="text-align:center;vertical-align:middle">'.$bulanArr2[$bulan3].'</th>
    </tr>';
    $no = 0;
    $arr = [0,0,0,0,0,0,0,0,0];
    $data = $konek->rawQuery("SELECT * FROM ppi_ruangan");
    while($rows = $data->fetch_assoc()){
        $banyak = $konek->rawQuery("SELECT * FROM ppi_infus WHERE YEAR(tanggal) = {$tahun} AND ruangan = {$rows['id']}")->fetch_row();
        if($banyak <= 0 ) continue ;
        echo "<tr>";
            echo "<td style='text-align:center;vertical-align:middle'>".++$no."</td>";
            echo "<td style='text-align:center;vertical-align:middle'>".$rows['nama_ruangan']."</td>";
            echo "<td style='text-align:center;vertical-align:middle'>".pasienPlebitis($bulan1,$tahun,$rows['id'],$konek)."</td>";
            echo "<td style='text-align:center;vertical-align:middle'>".pasienPlebitis($bulan2,$tahun,$rows['id'],$konek)."</td>";
            echo "<td style='text-align:center;vertical-align:middle'>".pasienPlebitis($bulan3,$tahun,$rows['id'],$konek)."</td>";

            echo "<td style='text-align:center;vertical-align:middle'>".pasienHariPlebitis($bulan1,$tahun,$rows['id'],$konek)."</td>";
            echo "<td style='text-align:center;vertical-align:middle'>".pasienHariPlebitis($bulan2,$tahun,$rows['id'],$konek)."</td>";
            echo "<td style='text-align:center;vertical-align:middle'>".pasienHariPlebitis($bulan3,$tahun,$rows['id'],$konek)."</td>";
            
            echo "<td style='text-align:center;vertical-align:middle'>".pasienPlebitisJumlah($bulan1,$tahun,$rows['id'],$konek)."</td>";
            echo "<td style='text-align:center;vertical-align:middle'>".pasienPlebitisJumlah($bulan2,$tahun,$rows['id'],$konek)."</td>";
            echo "<td style='text-align:center;vertical-align:middle'>".pasienPlebitisJumlah($bulan3,$tahun,$rows['id'],$konek)."</td>";
            
            $arr[0] += pasienPlebitis($bulan1,$tahun,$rows['id'],$konek);
            $arr[1] += pasienPlebitis($bulan2,$tahun,$rows['id'],$konek);
            $arr[2] += pasienPlebitis($bulan3,$tahun,$rows['id'],$konek);
            $arr[3] += pasienHariPlebitis($bulan1,$tahun,$rows['id'],$konek);
            $arr[4] += pasienHariPlebitis($bulan2,$tahun,$rows['id'],$konek);
            $arr[5] += pasienHariPlebitis($bulan3,$tahun,$rows['id'],$konek);
            $arr[6] += pasienPlebitisJumlah($bulan1,$tahun,$rows['id'],$konek);
            $arr[7] += pasienPlebitisJumlah($bulan2,$tahun,$rows['id'],$konek);
            $arr[8] += pasienPlebitisJumlah($bulan3,$tahun,$rows['id'],$konek);

        echo "</tr>";
    }
    echo '<tr>';
        echo "<td colspan='2'>Total</td>"; 
        for($i = 0; $i < sizeof($arr); $i++){
            echo '<td>'.$arr[$i] . '</td>';
        }
    echo '</tr>';
    echo '</table>';
    if(($arr[3]+$arr[4]+$arr[5]) == 0){
        $hasil = 0;
    }else{
        $hasil = (($arr[6]+$arr[7]+$arr[8])/($arr[3]+$arr[4]+$arr[5])) * 1000;
    }
    echo '<table class="table table-borderless table-sm text-left">';
        echo '<tr>';
            echo '<td>Triwulan ' . $triwulan . ' tahun ' . $tahun . ' :';
        echo '</tr>';
        echo '<tr>';
            echo '<td>Jumlah pasien terpasang infus : '.($arr[0]+$arr[1]+$arr[2]).'</td>';
        echo '</tr>';
        echo '<tr>';
            echo '<td>Jumlah Hari Pasien pemasangan infus : '.($arr[3]+$arr[4]+$arr[5]).'</td>';
        echo '</tr>';
        echo '<tr>';
            echo '<td>Ditemukan tanda tanda plebitis : '.($arr[6]+$arr[7]+$arr[8]).'</td>';
        echo '</tr>';
        echo '<tr>';
            echo '<td>Laju plebitis : '.($arr[6]+$arr[7]+$arr[8]).'/'.($arr[3]+$arr[4]+$arr[5]).' X 1000 = ' .$hasil.'</td>';
        echo '</tr>';
    echo '</table>';
}

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-6 text-center">
            <?php table(1,2,3,'I',$_REQUEST['tahun'],$konek) ?>
            <?php table(7,8,9,'III',$_REQUEST['tahun'],$konek) ?>
        </div>
        <div class="col-6 text-center">
            <?php table(4,5,6,'II',$_REQUEST['tahun'],$konek) ?>
            <?php table(10,11,12,'IV',$_REQUEST['tahun'],$konek) ?>
        </div>
    </div>
    
</div>
<div id="trTombol">
    <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
    <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
</div>

<script type="text/JavaScript">
    function cetak(tombol){
        tombol.style.display='none';
        if(tombol.style.display=='none'){
        window.print();
        window.close();
        }
    }
</script>
<?php
require '../../templates/footer.php';
?>
