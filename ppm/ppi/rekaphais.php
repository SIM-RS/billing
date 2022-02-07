<?php
require '../autoload.php';
require '../templates/headerlap.php';
if($_REQUEST['act'] == "excell"){
    header("Content-type: application/vnd.ms-excel");
    header('Content-Disposition: attachment; filename="LAP PPI PEMASANGAN INFUS.xls"');
}
$konek = new Connection();
$bulanArr = [
    1 => 'Januari',
    2 => 'Pebruari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'Nopember',
    12 => 'Desember',
];
$filter = "";
$filter2 = "";
$tahun = $_REQUEST['tahun-hais'];
$bulan = $_REQUEST['bulan'];
if($_REQUEST['filter'] == 1){
	$filter = " WHERE MONTH(tanggal) = {$bulan} AND YEAR(tanggal) = {$_REQUEST['tahun-hais']} ";
	$filter2 = " WHERE bulan = {$bulan} AND tahun = {$tahun} ";
	$cetakInfo = $bulanArr[$bulan] . ' ' . $tahun;
}else if($_REQUEST['filter'] >= 2 && $_REQUEST['filter'] <= 5){
	if($_REQUEST['filter'] == 2){
		$filter = " WHERE MONTH(tanggal) >= 1 AND MONTH(tanggal) <= 3 AND YEAR(tanggal) = {$_REQUEST['tahun-hais']} ";
		$filter2 = " WHERE bulan >= 1 AND bulan <= 3 AND tahun = {$tahun} ";
		$cetakInfo = "Januari S/D MARET";
	}else if($_REQUEST['filter'] == 3){
		$filter = " WHERE MONTH(tanggal) >= 4 AND MONTH(tanggal) <= 6 AND YEAR(tanggal) = {$_REQUEST['tahun-hais']} ";
		$filter2 = " WHERE bulan >= 4 AND bulan <= 6 AND tahun = {$tahun} ";
		$cetakInfo = "April S/D Juni";


	}else if($_REQUEST['filter'] == 4){
		$filter = " WHERE MONTH(tanggal) >= 7 AND MONTH(tanggal) <= 9 AND YEAR(tanggal) = {$_REQUEST['tahun-hais']} ";
		$filter2 = " WHERE bulan >= 7 AND bulan <= 9 AND tahun = {$tahun} ";
		$cetakInfo = "Juli S/D September";


	}else if($_REQUEST['filter'] == 5){
		$filter = " WHERE MONTH(tanggal) >= 10 AND MONTH(tanggal) <= 12 AND YEAR(tanggal) = {$_REQUEST['tahun-hais']} ";
		$filter2 = " WHERE bulan >= 10 AND bulan <= 12 AND tahun = {$tahun} ";
		$cetakInfo = "Oktober S/D Desember";

	}
}else if($_REQUEST['filter'] == 6){
	$filter = " WHERE MONTH(tanggal) >= 1 AND MONTH(tanggal) <= 6 AND YEAR(tanggal) = {$_REQUEST['tahun-hais']} ";
	$filter2 = " WHERE bulan >= 1 AND bulan <= 6 AND tahun = {$tahun} ";
	$cetakInfo = "Semester I " . $tahun;
}else if($_REQUEST['filter'] == 7){
	$filter = " WHERE MONTH(tanggal) >= 7 AND MONTH(tanggal) <= 12 AND YEAR(tanggal) = {$_REQUEST['tahun-hais']} ";
	$filter2 = " WHERE bulan >= 7 AND bulan <= 12 AND tahun = {$tahun} ";
	$cetakInfo = "Semester II " . $tahun;
}else if($_REQUEST['filter'] == 8){
	$filter = " WHERE YEAR(tanggal) = {$_REQUEST['tahun-hais']} ";
	$filter2 = " WHERE tahun = {$tahun} ";
	$cetakInfo = $tahun;

}
?>
<table border="1" class="table table-bordered table-sm">
    <tr>
        <th colspan="18" style="vertical-align: middle;text-align:center;text-transform:uppercase">FORMULIR PELAPORAN HEALTHCARE ASSOCIATED INFECTIONS<br>RUMAH SAKIT PRIMA HUSADA CIPTA MEDAN</th>
    </tr>
    <tr>
    	<th></th>
    </tr>
    <tr>
    	<th colspan="3"><?= $cetakInfo ?></th>
    </tr>
    <tr>
    	<td></td>
    </tr>
    <tr>
    	<th style="vertical-align: middle;text-align:center;" rowspan="3">NO</th>
    	<th style="vertical-align: middle;text-align:center;" rowspan="3">UNIT PELAYANAN</th>
    	<th style="vertical-align: middle;text-align:center;" colspan="16" >JENIS HAIS</th>  
    </tr>
    <tr>
    	<th style="vertical-align: middle;text-align:center;" colspan="3">ISK</th>
    	<th style="vertical-align: middle;text-align:center;" colspan="3">IDO</th>
    	<th style="vertical-align: middle;text-align:center;" colspan="3">VAP</th>
    	<th style="vertical-align: middle;text-align:center;" colspan="3">PLEBITIS</th>
    	<th style="vertical-align: middle;text-align:center;" colspan="3">IADP</th>
    </tr>
    <tr>
    	<th style="vertical-align: middle;text-align:center;">Jumlah Kejadian Infeksi</th>
    	<th style="vertical-align: middle;text-align:center;">Hari Pemakaian Kateter</th>
    	<th style="vertical-align: middle;text-align:center;">%<sub>0</sub></th>
    	
    	<th style="vertical-align: middle;text-align:center;">Jumlah Kejadian Infeksi</th>
    	<th style="vertical-align: middle;text-align:center;">Jumlah Pasien Operasi</th>
    	<th style="vertical-align: middle;text-align:center;">%</th>

    	<th style="vertical-align: middle;text-align:center;">Jumlah Kejadian Infeksi</th>
    	<th style="vertical-align: middle;text-align:center;">Hari Pemakaian ETT</th>
    	<th style="vertical-align: middle;text-align:center;">%<sub>0</sub></th>
    	
    	<th style="vertical-align: middle;text-align:center;">Jumlah Kejadian Infeksi</th>
    	<th style="vertical-align: middle;text-align:center;">Hari Pemakaian IV Line</th>
    	<th style="vertical-align: middle;text-align:center;">%<sub>0</sub></th>
    	<th style="vertical-align: middle;text-align:center;">%</th>

    	<th style="vertical-align: middle;text-align:center;">Jumlah Kejadian Infeksi</th>
    	<th style="vertical-align: middle;text-align:center;">Hari Pemakaian CVP</th>
    	<th style="vertical-align: middle;text-align:center;">%<sub>0</sub></th>
    </tr>
    <?php
    	$sqlRuangan = "SELECT * FROM ppi_ruangan";
    	$data = $konek->rawQuery($sqlRuangan);
    	$no = 0;
    	$arr = ['infeksi_isk'=>0,'hari_isk'=>0,'infeksi_ido'=>0,'hari_ido'=>0,'infeksi_plebitis'=>0,'hari_plebitis'=>0,'hari_vap'=>0,'infeksi_vap'=>0,'hari_iadp'=>0,'infeksi_iadp'=>0];

    	while($rows = $data->fetch_assoc()){
    		echo '<tr>';
	    	$sqlPlebitis = $konek->rawQuery("SELECT SUM(jhi) as jisk FROM ppi_infus $filter AND ruangan = {$rows['id']}")->fetch_assoc();
	    	$sqlInfeksi = $konek->rawQuery("SELECT COUNT(kp) as jkp FROM ppi_infus $filter AND ruangan = {$rows['id']} AND kp = 1 GROUP BY pasien_id")->fetch_assoc();

	    	$sqlIdo = $konek->rawQuery("SELECT SUM(jumlah_jenis_operasi) as jjp FROM ppi_jenis_operasi $filter2 AND ruangan = {$rows['id']}")->fetch_assoc();

	    	$sqlIskInfeksiIdo = $konek->rawQuery("SELECT SUM(jumlah_infeksi_operasi) as jip FROM ppi_infeksi_operasi $filter2 AND ruangan = {$rows['id']}")->fetch_assoc();

	    	$sqlIsk = $konek->rawQuery("SELECT SUM(kateter) as jbr FROM ppi_kateter $filter AND ruangan = {$rows['id']}")->fetch_assoc();
	    	$sqlIskInfeksi = $konek->rawQuery("SELECT irs as jd FROM ppi_pasien_irs $filter2 AND ruangan = {$rows['id']}")->fetch_assoc();

            $sqlVap = $konek->rawQuery("SELECT SUM(vap) as vap FROM ppi_vap $filter AND ruangan = {$rows['id']}")->fetch_assoc();
            $sqlVapInfeksi = $konek->rawQuery("SELECT jumlah_vap FROM ppi_vap_jumlah $filter2 AND ruangan = {$rows['id']}")->fetch_assoc();

            $sqlIadp = $konek->rawQuery("SELECT SUM(iadp) as iadp FROM ppi_iadp $filter AND ruangan = {$rows['id']}")->fetch_assoc();
            $sqlInfeksiIadp = $konek->rawQuery("SELECT irs FROM ppi_pasien_irs_idp $filter2 AND ruangan = {$rows['id']}")->fetch_assoc();

	    	echo "<td>".++$no."</td>";
	    	echo "<td>".$rows['nama_ruangan']."</td>";
	   
	    	echo "<td>".($sqlIskInfeksi['jd'] == null ? 0 : $sqlIskInfeksi['jd'])."</td>";
	    	echo "<td>".($sqlIsk['jbr'] == null ? 0 : $sqlIsk['jbr'])."</td>";
	    	
	    	$arr['infeksi_isk'] += $sqlIskInfeksi['jd'];
	    	$arr['hari_isk'] += $sqlIskInfeksi['jbr'];


	    	if($sqlIsk['jbr'] > 0){
		    	echo "<td>".(sprintf("%.2f",(($sqlIskInfeksi['jd'] / $sqlIsk['jbr']) * 1000)))."</td>";    		
	    	}else{
	    		echo "<td>0</td>";
	    	}
	    	
	    	echo "<td>".($sqlIskInfeksiIdo['jip'] == null ? 0 : $sqlIskInfeksiIdo['jip'])."</td>";
	    	echo "<td>".($sqlIdo['jjp'] == null ? 0 : $sqlIdo['jjp'])."</td>";

	    	$arr['infeksi_ido'] += $sqlIskInfeksiIdo['jip'];
	    	$arr['hari_ido'] += $sqlIdo['jjp'];

	    	if($sqlIdo['jjp'] > 0){
		    	echo "<td>".(sprintf("%.2f",(($sqlIskInfeksiIdo['jip'] / $sqlIdo['jjp']) * 100)))."</td>";    		
	    	}else{
	    		echo "<td>0</td>";
	    	}

	    	echo "<td>".($sqlVapInfeksi['jumlah_vap'] == null ? 0 : $sqlVapInfeksi['jumlah_vap'])."</td>";
	    	echo "<td>".($sqlVap['vap'] == null ? 0 : $sqlVap['vap'])."</td>";
	    	if($sqlVap['vap'] > 0){
                echo "<td>".(sprintf("%.2f",(($sqlVapInfeksi['jumlah_vap'] / $sqlVap['vap']) * 100)))."</td>";          
            }else{
                echo "<td>0</td>";
            }

            $arr['infeksi_vap'] += $sqlVapInfeksi['jumlah_vap'];
            $arr['hari_vap'] += $sqlVap['vap'];

	    	echo "<td>".($sqlInfeksi['jisk'] == null ? 0 : $sqlInfeksi['jisk'])."</td>";
	    	echo "<td>".($sqlPlebitis['jkp'] == null ? 0 : $sqlPlebitis['jkp'])."</td>";

	    	$arr['infeksi_plebitis'] += $sqlIskInfeksiIdo['jisk'];
	    	$arr['hari_plebitis'] += $sqlIdo['jkp'];

	    	if($sqlPlebitis['jkp'] > 0){
		    	echo "<td>".(sprintf("%.2f",(($sqlInfeksi['jisk'] / $sqlPlebitis['jisk']) * 1000)))."</td>";    		
		    	echo "<td>".(sprintf("%.2f",(($sqlInfeksi['jisk'] / $sqlPlebitis['jisk']) * 100)))."</td>";    		
	    	}else{
	    		echo "<td>0</td>";
	    		echo "<td>0</td>";
	    	}

			echo "<td>".($sqlInfeksiIadp['irs'] == null ? 0 : $sqlInfeksiIadp['irs'])."</td>";
            echo "<td>".($sqlIadp['iadp'] == null ? 0 : $sqlIadp['iadp'])."</td>";
            if($sqlIadp['iadp'] > 0){
                echo "<td>".(sprintf("%.2f",(($sqlInfeksiIadp['irs'] / $sqlIadp['iadp']) * 100)))."</td>";          
            }else{
                echo "<td>0</td>";
            }

            $arr['infeksi_iadp'] += $sqlInfeksiIadp['irs'];
            $arr['hari_iadp'] += $sqlIadp['iadp'];
    	}
    ?>
    <tr>
    	<td colspan="2">Jumlah</td>
    	<td><?= $arr['infeksi_isk'] ?></td>
    	<td><?= $arr['hari_isk'] ?></td>
    	<?php
	    	if($arr['hari_isk'] > 0){
		    	echo "<td>".(sprintf("%.2f",(($arr['infeksi_isk'] / $arr['hari_isk']) * 100)))."</td>";    		
	    	}else{
	    		echo "<td>0</td>";
	    	}
    	?>
    	<td><?= $arr['infeksi_ido'] ?></td>
    	<td><?= $arr['hari_ido'] ?></td>
    	<?php
	    	if($arr['hari_ido'] > 0){
		    	echo "<td>".(sprintf("%.2f",(($arr['infeksi_ido'] / $arr['hari_ido']) * 100)))."</td>";    		
	    	}else{
	    		echo "<td>0</td>";
	    	}
    	?>
    	
        <td><?= $arr['infeksi_vap'] ?></td>
        <td><?= $arr['hari_vap'] ?></td>
        <?php
            if($arr['hari_vap'] > 0){
                echo "<td>".(sprintf("%.2f",(($arr['infeksi_vap'] / $arr['hari_vap']) * 1000)))."</td>";         
            }else{
                echo "<td>0</td>";
            }
        ?>

    	<td><?= $arr['infeksi_plebitis'] ?></td>
    	<td><?= $arr['hari_plebitis'] ?></td>
    	<?php
	    	if($arr['hari_plebitis'] > 0){
		    	echo "<td>".(sprintf("%.2f",(($arr['infeksi_plebitis'] / $arr['hari_plebitis']) * 1000)))."</td>"; 
		    	echo "<td>".(sprintf("%.2f",(($arr['infeksi_plebitis'] / $arr['hari_plebitis']) * 100)))."</td>";    		   		
	    	}else{
	    		echo "<td>0</td>";
	    		echo "<td>0</td>";
	    	}
    	?>
    	<td><?= $arr['infeksi_iadp'] ?></td>
        <td><?= $arr['hari_iadp'] ?></td>
        <?php
            if($arr['hari_iadp'] > 0){
                echo "<td>".(sprintf("%.2f",(($arr['infeksi_iadp'] / $arr['hari_iadp']) * 1000)))."</td>";         
            }else{
                echo "<td>0</td>";
            }
        ?>
    </tr>
    <tr>
        <td colspan="18"></td>
    </tr>
    <tr>
        <td colspan="18"></td>
    </tr>
    <tr>
        <td colspan="18"></td>
    </tr>
    <tr>
        <td></td>
        <td style="vertical-align: middle;text-align:center;" colspan="3">Mengetahui</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="vertical-align: middle;text-align:center;" colspan="5">Dibuat Oleh</td>
    </tr>
    <tr>
        <td></td>
        <td style="vertical-align: middle;text-align:center;" colspan="3">Kepala RS Prima Husada Cipta Medan</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>

        <td style="vertical-align: middle;text-align:center;" colspan="5">IPCN PPI RS Prima Husada Cipta Medan</td>
    </tr>
    <tr>
        <td colspan="18"></td>
    </tr>
    <tr>
        <td colspan="18"></td>
    </tr>
    <tr>
        <td colspan="18"></td>
    </tr>
    <tr>
        <td></td>
        <td style="vertical-align: middle;text-align:center;" colspan="3">Dr. Ausvin Geniusman Komaini, MH.Kes</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>

        <td style="vertical-align: middle;text-align:center;" colspan="5">Raudah, S.Kep.Ns</td>
    </tr>
</table>
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
require '../templates/footer.php'
?>