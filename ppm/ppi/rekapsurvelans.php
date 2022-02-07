<?php
require '../autoload.php';
require '../templates/headerlap.php';
if($_REQUEST['act'] == "excell"){
    header("Content-type: application/vnd.ms-excel");
    header('Content-Disposition: attachment; filename="LAP PPI PEMASANGAN INFUS.xls"');
}

$konek = new Connection();
function pemakaianAlat($bulan,$tahun,$ruangan,$field,$table,$konek){
    $sql = "SELECT SUM({$field}) as banyak FROM {$table} WHERE MONTH(tanggal) = {$bulan} AND YEAR(tanggal) = {$tahun} AND ruangan = {$ruangan}";
    $data = $konek->rawQuery($sql)->fetch_assoc();
    return $data['banyak'] == null ? 0 : $data['banyak'];
}

function infeksiPlebitis($bulan,$tahun,$ruangan,$konek){
    $sql = "SELECT COUNT(pasien_id) as banyak FROM ppi_infus WHERE MONTH(tanggal) = {$bulan} AND YEAR(tanggal) = {$tahun} AND ruangan = {$ruangan} AND kp = 1 GROUP BY pasien_id";
    $data = $konek->rawQuery($sql)->fetch_assoc();
    return $data['banyak'] == null ? 0 : $data['banyak'];
}

function pasienHariVap($bulan,$tahun,$ruangan,$konek){
    $sql = "SELECT SUM(vap) as banyak FROM ppi_vap WHERE MONTH(tanggal) = {$bulan} AND ruangan = {$ruangan} AND YEAR(tanggal) = {$tahun}";
    $data = $konek->rawQuery($sql)->fetch_assoc();
    return $data['banyak'] == null ? 0 : $data['banyak'];
}

function pasienInfeksiVap($bulan,$tahun,$ruangan,$konek){
    $sql = "SELECT jumlah_vap as banyak FROM ppi_vap_jumlah WHERE bulan = {$bulan} AND ruangan = {$ruangan} AND tahun = {$tahun}";
    $data = $konek->rawQuery($sql)->fetch_assoc();
    return $data['banyak'] == null ? 0 : $data['banyak'];
}

function pasienIrsKateter($bulan,$tahun,$ruangan,$konek){
    $sql = $konek->rawQuery("SELECT irs FROM ppi_pasien_irs WHERE bulan = {$bulan} AND tahun = {$tahun} AND ruangan = {$ruangan}")->fetch_assoc();
    return $sql['irs'] == null ? 0 : $sql['irs'];
}

function ido($bulan,$tahun,$ruangan,$konek){
    $sql = $konek->rawQuery("SELECT SUM(jumlah_jenis_operasi) as banyak FROM ppi_jenis_operasi WHERE bulan = {$bulan} AND tahun = {$tahun} AND ruangan = {$ruangan} GROUP BY bulan,tahun")->fetch_assoc();
    return $sql['banyak'] == null ? 0 : $sql['banyak'];
}

function pasienOperasi($bulan,$tahun,$ruangan,$konek){
    $sql = $konek->rawQuery("SELECT COUNT(pasien_id) as banyak FROM ppi_operasi WHERE MONTH(tanggal) = {$bulan} AND YEAR(tanggal) = {$tahun} AND ruangan = {$ruangan} GROUP BY pasien_id")->fetch_assoc();
    return $sql['banyak'] == null ? 0 : $sql['banyak'];
}

function pasienTirahBaring($bulan,$tahun,$ruangan,$konek){
    $sql = $konek->rawQuery("SELECT SUM(jbr) as banyak FROM ppi_bedres WHERE MONTH(tanggal) = {$bulan} AND YEAR(tanggal) = {$tahun} AND ruangan = {$ruangan}")->fetch_assoc();
    return $sql['banyak'] == null ? 0 : $sql['banyak'];
}

function pasienDecubitus($bulan,$tahun,$ruangan,$konek){
     $sql = $konek->rawQuery("SELECT COUNT(kd) as banyak FROM ppi_bedres WHERE MONTH(tanggal) = {$bulan} AND YEAR(tanggal) = {$tahun} AND ruangan = {$ruangan} AND kd = 1 GROUP BY pasien_id")->fetch_assoc();
    return $sql['banyak'] == null ? 0 : $sql['banyak'];   
}


function table($bulan,$tahun,$konek){
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
    echo '<table class="table table-sm table-bordered" border="1">';
        echo '<tr>';
            echo '<td colspan="2">'.$bulanArr[$bulan] .' '. $tahun.'</td>';
        echo '</tr>';

        echo '<tr>';
            echo '<td style="text-align:center;vertical-align:middle" rowspan="2">NO</td>';
            echo '<td style="text-align:center;vertical-align:middle" rowspan="2">RUANGAN</td>';
            echo '<td style="text-align:center;vertical-align:middle" colspan="2">PEMAKAIAN ALAT</td>';
            echo '<td style="text-align:center;vertical-align:middle" colspan="5">INFEKSI RUMAH SAKIT</td>';
            echo '<td style="text-align:center;vertical-align:middle" rowspan="2" colspan="2">PASIEN OPERASI</td>';
            echo '<td style="text-align:center;vertical-align:middle" rowspan="2">TIRARAH BARING</td>';
            echo '<td style="text-align:center;vertical-align:middle" rowspan="2">DEKUBITUS</td>';
        echo '</tr>';
        echo '<tr>';
            echo '<th>IVL</th>';
            echo '<th>UC</th>';
            echo '<th>ETT</th>';
            echo '<th>PLEBITIS</th>';
            echo '<th>ISK</th>';
            echo '<th>VAP</th>';
            echo '<th>IDO</th>';
        echo '</tr>';

        $data = $konek->rawQuery("SELECT * FROM ppi_ruangan");
        $no = 0;
        $arr = ['ivl'=>0,'uc' =>0,'ett' =>0,'ple' =>0,'isk' =>0,'vap' =>0,'ido' =>0,'po' =>0,'tb' =>0,'d' =>0];
        while($rows = $data->fetch_assoc()){
            echo '<tr>';
                echo '<td>'.++$no.'</td>';
                echo '<td>'.$rows['nama_ruangan'].'</td>';
                echo '<td>'.pemakaianAlat($bulan,$tahun,$rows['id'],'jhi','ppi_infus',$konek).'</td>';
                echo '<td>'.pemakaianAlat($bulan,$tahun,$rows['id'],'kateter','ppi_kateter',$konek).'</td>';
                echo '<td>'.pasienHariVap($bulan,$tahun,$rows['id'],$konek).'</td>';
                echo '<td>'.infeksiPlebitis($bulan,$tahun,$rows['id'],$konek).'</td>';
                echo '<td>'.pasienIrsKateter($bulan,$tahun,$rows['id'],$konek).'</td>';
                echo '<td>'.pasienInfeksiVap($bulan,$tahun,$rows['id'],$konek).'</td>';
                echo '<td>'.ido($bulan,$tahun,$rows['id'],$konek).'</td>';
                echo '<td colspan="2">'.pasienOperasi($bulan,$tahun,$rows['id'],$konek).'</td>';
                echo '<td>'.pasienTirahBaring($bulan,$tahun,$rows['id'],$konek).'</td>';
                echo '<td>'.pasienDecubitus($bulan,$tahun,$rows['id'],$konek).'</td>';
            echo '</tr>';

            $arr['ivl'] += pemakaianAlat($bulan,$tahun,$rows['id'],'jhi','ppi_infus',$konek);
            $arr['uc'] += pemakaianAlat($bulan,$tahun,$rows['id'],'kateter','ppi_kateter',$konek);
            $arr['ett'] += pasienHariVap($bulan,$tahun,$rows['id'],$konek);
            $arr['ple'] += infeksiPlebitis($bulan,$tahun,$rows['id'],$konek);
            $arr['isk'] += pasienIrsKateter($bulan,$tahun,$rows['id'],$konek);
            $arr['vap'] += pasienInfeksiVap($bulan,$tahun,$rows['id'],$konek);
            $arr['ido'] += ido($bulan,$tahun,$rows['id'],$konek);
            $arr['po'] += pasienOperasi($bulan,$tahun,$rows['id'],$konek);
            $arr['tb'] += pasienTirahBaring($bulan,$tahun,$rows['id'],$konek);
            $arr['d'] += pasienDecubitus($bulan,$tahun,$rows['id'],$konek);
        }
        echo '<tr>';
        echo '<td colspan="2">Jumlah</td>';
        foreach ($arr as $key => $val) {
            if($key == 'po') 
                echo '<td colspan="2">'.$val.'</td>';
            else
                echo '<td>'.$val.'</td>';
        }
        echo '</tr>';
        echo '<tr>';
            echo '<td colspan="2">Presentase</td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            if($arr['ivl'] > 0){
                echo '<td>'.sprintf("%.2f",($arr['ple']/$arr['ivl'])*1000).'</td>';            
            }else{
                echo '<td>0</td>';
            }
            if($arr['uc'] > 0){
                echo '<td>'.sprintf("%.2f",($arr['isk']/$arr['uc'])*1000).'</td>';            
            }else{
                echo '<td>0</td>';
            }
            if($arr['ett'] > 0){
                echo '<td>'.sprintf("%.2f",($arr['vap']/$arr['ett'])*1000).'</td>';            
            }else{
                echo '<td>0</td>';
            }
            echo '<td></td>';
            echo '<td colspan="2"></td>';
            echo '<td></td>';
            echo '<td></td>';
        echo '</tr>';
    echo '</table>';

}

?>
<div class="container-fluid">
    <div class="row">
        <table class="table table-sm table-bordered" border="1">
            <tr>
                <th colspan="18" style="text-align:center;vertical-align:middle">LAPORAN BULANAN SURVEILANS INFEKSI RUMAH SAKIT PRIMA HISADA CIPTA MEDAN</th>
            </tr>
        </table>
        <?php for($i = 1; $i <= 12; $i++){ ?>
        <div class="col-12 text-center">
            <?php table($i,$_REQUEST['tahun'],$konek) ?>
        </div>
        <?php } ?>
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
require '../templates/footer.php';
?>
