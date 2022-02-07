<?php
require '../../autoload.php';
require '../../templates/headerlap.php';
if($_REQUEST['act'] == "excell"){
    header("Content-type: application/vnd.ms-excel");
    header('Content-Disposition: attachment; filename="LAP PPI PEMASANGAN INFUS.xls"');
}

$konek = new Connection();
function pasienJenis($bulan,$tahun,$ruangan,$jenis,$konek){
    $sql = "SELECT jumlah_jenis_operasi as banyak FROM ppi_jenis_operasi WHERE bulan = {$bulan} AND tahun = {$tahun} AND ruangan = {$ruangan} AND jenis_operasi = '{$jenis}'";
    $data = $konek->rawQuery($sql)->fetch_assoc();
    return $data['banyak'] == null ? 0 : $data['banyak'];
}
function pasienInfeksi($bulan,$tahun,$ruangan,$jenis,$konek){
    $sql = "SELECT jumlah_infeksi_operasi as banyak FROM ppi_infeksi_operasi WHERE bulan = {$bulan} AND tahun = {$tahun} AND ruangan = {$ruangan} AND infeksi_operasi = '{$jenis}'";
    $data = $konek->rawQuery($sql)->fetch_assoc();
    return $data['banyak'] == null ? 0 : $data['banyak'];
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
    echo 'Angka Infeksi Saluran Kemih Bulan '.$bulanArr[$bulan1].','.$bulanArr[$bulan2].','.$bulanArr[$bulan3]. ' ' . $tahun;
    echo '<table border="1" class="table table-bordered table-sm">
    <tr>
        <th rowspan="3" style="text-align:center;vertical-align:middle">No</th>
        <th rowspan="3" style="text-align:center;vertical-align:middle">Ruang</th>
        <th colspan="9" style="text-align:center;vertical-align:middle">Jenis Operasi</th>
        <th colspan="9" style="text-align:center;vertical-align:middle">Infeksi Luka Operasi</th>
    </tr>
    <tr>
        <th colspan="3" style="text-align:center;vertical-align:middle">'.$bulanArr[$bulan1].'</th>
        <th colspan="3" style="text-align:center;vertical-align:middle">'.$bulanArr[$bulan2].'</th>
        <th colspan="3" style="text-align:center;vertical-align:middle">'.$bulanArr[$bulan3].'</th>
        <th colspan="3" style="text-align:center;vertical-align:middle">'.$bulanArr[$bulan1].'</th>
        <th colspan="3" style="text-align:center;vertical-align:middle">'.$bulanArr[$bulan2].'</th>
        <th colspan="3" style="text-align:center;vertical-align:middle">'.$bulanArr[$bulan3].'</th>
    </tr>
    <tr>
        <th>OB</tH>
        <th>OBT</tH>
        <th>OK</tH>
        <th>OB</tH>
        <th>OBT</tH>
        <th>OK</tH>
        <th>OB</tH>
        <th>OBT</tH>
        <th>OK</tH>

        <th>ILD</tH>
        <th>ILK</tH>
        <th>ILS</tH>
        <th>ILD</tH>
        <th>ILK</tH>
        <th>ILS</tH>
        <th>ILD</tH>
        <th>ILK</tH>
        <th>ILS</tH>

    </tr>';
    $jmlOperasi = 0;
    $jmlilo = 0;
    $no = 0;
    $arr = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
    $data = $konek->rawQuery("SELECT * FROM ppi_ruangan");
    while($rows = $data->fetch_assoc()){
        $banyak = $konek->rawQuery("SELECT * FROM ppi_bedres WHERE YEAR(tanggal) = {$tahun} AND ruangan = {$rows['id']}")->fetch_row();
        if($banyak <= 0 ) continue ;
        echo "<tr>";
            echo "<td style='text-align:center;vertical-align:middle'>".++$no."</td>";
            echo "<td style='text-align:center;vertical-align:middle'>".$rows['nama_ruangan']."</td>";
            echo "<td style='text-align:center;vertical-align:middle'>".pasienJenis($bulan1,$tahun,$rows['id'],'OB',$konek)."</td>";
            echo "<td style='text-align:center;vertical-align:middle'>".pasienJenis($bulan1,$tahun,$rows['id'],'OBT',$konek)."</td>";
            echo "<td style='text-align:center;vertical-align:middle'>".pasienJenis($bulan1,$tahun,$rows['id'],'OK',$konek)."</td>";

            echo "<td style='text-align:center;vertical-align:middle'>".pasienJenis($bulan2,$tahun,$rows['id'],'OB',$konek)."</td>";
            echo "<td style='text-align:center;vertical-align:middle'>".pasienJenis($bulan2,$tahun,$rows['id'],'OBT',$konek)."</td>";
            echo "<td style='text-align:center;vertical-align:middle'>".pasienJenis($bulan2,$tahun,$rows['id'],'OK',$konek)."</td>";
            
            echo "<td style='text-align:center;vertical-align:middle'>".pasienJenis($bulan3,$tahun,$rows['id'],'OB',$konek)."</td>";
            echo "<td style='text-align:center;vertical-align:middle'>".pasienJenis($bulan3,$tahun,$rows['id'],'OBT',$konek)."</td>";
            echo "<td style='text-align:center;vertical-align:middle'>".pasienJenis($bulan3,$tahun,$rows['id'],'OK',$konek)."</td>";

            echo "<td style='text-align:center;vertical-align:middle'>".pasienInfeksi($bulan1,$tahun,$rows['id'],'ILD',$konek)."</td>";
            echo "<td style='text-align:center;vertical-align:middle'>".pasienInfeksi($bulan1,$tahun,$rows['id'],'ILK',$konek)."</td>";
            echo "<td style='text-align:center;vertical-align:middle'>".pasienInfeksi($bulan1,$tahun,$rows['id'],'ILS',$konek)."</td>";

            echo "<td style='text-align:center;vertical-align:middle'>".pasienInfeksi($bulan2,$tahun,$rows['id'],'ILD',$konek)."</td>";
            echo "<td style='text-align:center;vertical-align:middle'>".pasienInfeksi($bulan2,$tahun,$rows['id'],'ILK',$konek)."</td>";
            echo "<td style='text-align:center;vertical-align:middle'>".pasienInfeksi($bulan2,$tahun,$rows['id'],'ILS',$konek)."</td>";
            
            echo "<td style='text-align:center;vertical-align:middle'>".pasienInfeksi($bulan3,$tahun,$rows['id'],'ILD',$konek)."</td>";
            echo "<td style='text-align:center;vertical-align:middle'>".pasienInfeksi($bulan3,$tahun,$rows['id'],'ILK',$konek)."</td>";
            echo "<td style='text-align:center;vertical-align:middle'>".pasienInfeksi($bulan3,$tahun,$rows['id'],'ILS',$konek)."</td>";
            
            $arr[0] += pasienJenis($bulan1,$tahun,$rows['id'],'OB',$konek);
            $arr[1] += pasienJenis($bulan1,$tahun,$rows['id'],'OBT',$konek);
            $arr[2] += pasienJenis($bulan1,$tahun,$rows['id'],'OK',$konek);
            $arr[3] += pasienJenis($bulan2,$tahun,$rows['id'],'OB',$konek);
            $arr[4] += pasienJenis($bulan2,$tahun,$rows['id'],'OBT',$konek);
            $arr[5] += pasienJenis($bulan2,$tahun,$rows['id'],'OK',$konek);
            $arr[6] += pasienJenis($bulan3,$tahun,$rows['id'],'OB',$konek);
            $arr[7] += pasienJenis($bulan3,$tahun,$rows['id'],'OBT',$konek);
            $arr[8] += pasienJenis($bulan2,$tahun,$rows['id'],'OK',$konek);

            $arr[9] += pasienInfeksi($bulan1,$tahun,$rows['id'],'ILD',$konek);
            $arr[10] += pasienInfeksi($bulan1,$tahun,$rows['id'],'ILK',$konek);
            $arr[11] += pasienInfeksi($bulan1,$tahun,$rows['id'],'ILS',$konek);
            $arr[12] += pasienInfeksi($bulan2,$tahun,$rows['id'],'ILD',$konek);
            $arr[13] += pasienInfeksi($bulan2,$tahun,$rows['id'],'ILK',$konek);
            $arr[14] += pasienInfeksi($bulan2,$tahun,$rows['id'],'ILS',$konek);
            $arr[15] += pasienInfeksi($bulan3,$tahun,$rows['id'],'ILD',$konek);
            $arr[16] += pasienInfeksi($bulan3,$tahun,$rows['id'],'ILK',$konek);
            $arr[17] += pasienInfeksi($bulan2,$tahun,$rows['id'],'ILS',$konek);

        echo "</tr>";
    }
    echo '<tr>';
        echo "<td colspan='2'>Total</td>"; 
        for($i = 0; $i < sizeof($arr); $i++){
            if($i <= 8){
                $jmlOperasi += $arr[$i];
            }else{
                $jmlilo += $arr[$i];
            }
            echo '<td>'.$arr[$i] . '</td>';
        }
    echo '</tr>';
    echo '</table>';
    if($jmlOperasi == 0){
        $hasil = 0;
    }else{
        $hasil = ($jmlOperasi/$jmlilo) * 1000;
    }
    echo '<table class="table table-borderless table-sm text-left">';
        echo '<tr>';
            echo '<td>Triwulan ' . $triwulan . ' tahun ' . $tahun . ' :';
        echo '</tr>';
        echo '<tr>';
            echo '<td>Jumlah pasien operasi: '.$jmlOperasi.'</td>';
        echo '</tr>';
        echo '<tr>';
            echo '<td>Jumlah pasien positif : '.$jmlilo.'</td>';
        echo '</tr>';
        echo '<tr>';
            echo '<td></td>';
        echo '</tr>';
        echo '<tr>';
            echo '<td>Laju ILO : '.($jmlilo).'/'.($jmlOperasi).' X 1000 = ' .$hasil.'</td>';
        echo '</tr>';
    echo '</table>';
}

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 text-center">
            <?php table(1,2,3,'I',$_REQUEST['tahun'],$konek) ?>
        </div>
        <div class="col-12 text-center">
            <?php table(4,5,6,'II',$_REQUEST['tahun'],$konek) ?>
        </div>
        <div class="col-12">
            <?php table(7,8,9,'III',$_REQUEST['tahun'],$konek) ?>
        </div>
        <div class="col-12">
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
