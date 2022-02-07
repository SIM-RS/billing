<?php
	use yii\helpers\Html;
	include '../function/form.php';
	include '../../koneksi/konek.php';
	include 'funct.php';
	$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
	$i = 1;

	if(isset($_REQUEST['id'])) {
    	$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_15_2_monitoring_makanan WHERE id = '{$_REQUEST['id']}'"));
		$slideData = $data['data']; $str = ""; $arr_slide1 = [];

		for ($q=0; $q < strlen($slideData); $q++) { 
		
			if ($slideData[$q] != "|") {
				$str .= $slideData[$q];
			} else {
				array_push($arr_slide1, $str);
				$str = "";
			}
			
		}

	} 
	if(isset($_REQUEST['idx'])) {

		$count = mysql_real_escape_string($_REQUEST["count"]);
		$str_data = "";

		for ($index = 1; $index < $count; $index++) {
			$data = mysql_real_escape_string($_REQUEST["slide1_{$index}"]);
			if ($data != "") {
				$str_data .= $data;
				$str_data .= "|";
			} else {
				$str_data .= "#";
				$str_data .= "|";
			}
		}

		$data = [
        'id_pasien' => $dataPasien['id'],
        'id_kunjungan' => mysql_real_escape_string($_REQUEST['id_kunjungan']),
        'id_pelayanan' => mysql_real_escape_string($_REQUEST['id_pelayanan']),
        'tgl_act' => date('Y-m-d H:i:s'),
        'data' => $str_data,
        'id_user' => mysql_real_escape_string($_REQUEST["cmbDokSemua"]),
        'tgl_msk' => mysql_real_escape_string($_REQUEST["tgl_msk"]),
        'diet' => mysql_real_escape_string($_REQUEST["diet"]),
        'diagnosa' => mysql_real_escape_string($_REQUEST["diagnosa"]),
    ];

	    mysql_query("UPDATE rm_15_2_monitoring_makanan 
	    			SET
            		id_pasien = '{$dataPasien['id']}',
			    	id_kunjungan = '{$data['id_kunjungan']}',
			    	id_pelayanan = '{$data['id_pelayanan']}',
            		tgl_act = '{$data['tgl_act']}',
			    	id_user = '{$data['id_user']}',
					data = '{$data['data']}',
					tgl_msk = '{$data['tgl_msk']}',
					diagnosa = '{$data['diagnosa']}',
					diet = '{$data['diet']}'
					WHERE 
					id = {$_REQUEST['idx']}");
      
	    echo "<script>window.location.href='index.php?idKunj=".$_REQUEST['idKunj']."&idPel=".$_REQUEST['idPel']."&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['idUser']."&tmpLay=".$_REQUEST['tmpLay']."'</script>";
	}

	if (isset($_REQUEST['cetak'])) {
		$print_mode = true;
		echo "<script>window.print();</script>";
		$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_15_2_monitoring_makanan WHERE id = '{$_REQUEST['cetak']}'"));
		$slideData = $data['data']; $str = ""; $arr_slide1 = [];

		for ($q=0; $q < strlen($slideData); $q++) { 
		
			if ($slideData[$q] != "|") {
				$str .= $slideData[$q];
			} else {
				array_push($arr_slide1, $str);
				$str = "";
			}
			
		}
  }
  
  if (isset($_REQUEST['pdf'])) {
    $print_mode = true;
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_15_2_monitoring_makanan WHERE id = '{$_REQUEST['pdf']}'"));
    $slideData = $data['data'];
    $str = "";
    $arr_slide1 = [];

    for ($q=0; $q < strlen($slideData); $q++) {
        if ($slideData[$q] != "|") {
            $str .= $slideData[$q];
        } else {
            array_push($arr_slide1, $str);
            $str = "";
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
 
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../../theme/bs/bootstrap.min.css">
	<title>Document</title>
	<style type="text/css">
		td{
			font-size: 12.5px;
			padding: 10px;
		}
    .inv {
      background-color: transparent;
      border :none;
      cursor :default;
    }
	</style>
  <script src="../html2pdf/ppdf.js"></script>
  <script src="../html2pdf/pdf.js"></script>
</head>

<body id="pdf-area">
		<div class="row">

				<div class="col-6 text-center"><br><br><br><br>
				<img src="../logors1.png">
			</div>
			<div class="col-6" style="padding:40px">
				<div style="float: right">RM 15.2 / PHCM</div>
				<br>
				<div id="box" class="row" style="border: 1px solid black;padding:10px">
					<div class="col-9">
						<table>
							<tr>
								<td>Nama</td>
								<td>:</td>
								<td><?= $dataPasien["nama"]; ?></td>
							</tr>
							<tr>
								<td>Tgl. Lahir</td>
								<td>:</td>
								<td><?= $dataPasien["tgl_lahir"]; ?></td>
							</tr>
							<tr>
								<td>No. RM</td>
								<td>:</td>
								<td><?= $dataPasien["no_rm"]; ?></td>
							</tr>
						</table>
					</div> 

					<div class="col-3">
						<table>
							<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
							<tr>
								<td>
									<?php if($dataPasien["sex"] == "L"): ?>
										L
									<?php else: ?>
										P
									<?php endif; ?>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>

		<h4 class="text-center">CATATAN MONITORING MAKANAN / DIET PASIEN
</h4><br>

	<?php if(isset($_REQUEST['id'])): ?>
  <form action="" method="POST">
	<input type="hidden" name="idx" value="<?= $_REQUEST['id']; ?>">
<?php else:?>
  <form action="utils.php" method="POST">
<?php endif; ?>

	<input type="hidden" name="id_kunjungan" value="<?= $_REQUEST['idKunj']; ?>">
	<input type="hidden" name="id_pelayanan" value="<?= $_REQUEST['idPel']; ?>">
	<input type="hidden" name="id_user" value="<?= $_REQUEST['idUser']; ?>">
	<input type="hidden" name="tmpLay" value="<?= $_REQUEST['tmpLay']; ?>">

<div class="row text-center">
    <div class="col-4">
      Tanggal Masuk : <?=input($data['tgl_msk'], "tgl_msk", "date", "form-control")?>
    </div>
    <div class="col-4">
      Diagnosa : <?=area($data['diagnosa'], "diagnosa", "");?>
    </div>
    <div class="col-4">
      Diet : <?=area($data['diet'], "diet", "");?>
    </div>
</div><br><br>

<table style="width:100%;font-size:12px" class="text-center" border="1px">
<thead>
  <tr>
    <th rowspan="3">TGL</th>
    <th rowspan="3">SHIFT</th>
    <th colspan="5">PORSI YANG DIHABISKAN</th>
    <th colspan="2">NILAI GIZI</th>
    <th rowspan="3">ALASAN TIDAK HABIS</th>
    <th rowspan="3">EVALUASI</th>
    <th rowspan="3">TINDAK LANJUT</th>
    <th rowspan="3">PETUGAS</th>
  </tr>
  <tr>
    <th rowspan="2">MAK<br>POKOK<br></th>
    <th colspan="2">LAUK</th>
    <th rowspan="2">SAYUR</th>
    <th rowspan="2">BUAH</th>
    <th rowspan="2">ENERGI<br>(KKAL)<br></th>
    <th rowspan="2">PROTEIN<br>(GRAM)<br></th>
  </tr>
  <tr>
    <th>HEWANI</th>
    <th>NABATI</th>
  </tr>
</thead>
<tbody>
  <tr>
    <td rowspan="3"><?=input($arr_slide1[$i-1], "slide1_{$i}", "date", "");$i++;?></td>
    <td>Pagi</td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td rowspan="21">
    <?php if(isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])): ?>
                <select style="display:none" name="cmbDokSemua" id="cmbDokSemua"></select>
                <?php echo mysql_fetch_assoc(mysql_query("SELECT nama FROM b_ms_pegawai WHERE id = {$data['id_user']}"))['nama']; ?>
              <?php else: ?>
                <select class="form-control" name="cmbDokSemua" id="cmbDokSemua"></select>
              <?php endif; ?>
              </td>
  </tr>
  <tr>
    <td>Siang</td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
  </tr>
  <tr>
    <td>Malam</td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
  </tr>
  <tr>
    <td rowspan="3"><?=input($arr_slide1[$i-1], "slide1_{$i}", "date", "");$i++;?></td>
    <td>Pagi</td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
  </tr>
  <tr>
    <td>Siang</td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
  </tr>
  <tr>
    <td>Malam</td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
  </tr>
  <tr>
    <td rowspan="3"><?=input($arr_slide1[$i-1], "slide1_{$i}", "date", "");$i++;?></td>
    <td>Pagi</td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
  </tr>
  <tr>
    <td>Siang</td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
  </tr>
  <tr>
    <td>Malam</td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
  </tr>
  <tr>
    <td rowspan="3"><?=input($arr_slide1[$i-1], "slide1_{$i}", "date", "");$i++;?></td>
    <td>Pagi</td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
  </tr>
  <tr>
    <td>Siang</td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
  </tr>
  <tr>
    <td>Malam</td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
  </tr>
  <tr>
    <td rowspan="3"><?=input($arr_slide1[$i-1], "slide1_{$i}", "date", "");$i++;?></td>
    <td>Pagi</td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
  </tr>
  <tr>
    <td>Siang</td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
  </tr>
  <tr>
    <td>Malam</td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
  </tr>
  <tr>
    <td rowspan="3"><?=input($arr_slide1[$i-1], "slide1_{$i}", "date", "");$i++;?></td>
    <td>Pagi</td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
  </tr>
  <tr>
    <td>Siang</td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
  </tr>
  <tr>
    <td>Malam</td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
  </tr>
  <tr>
    <td rowspan="3"><?=input($arr_slide1[$i-1], "slide1_{$i}", "date", "");$i++;?></td>
    <td>Pagi</td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
  </tr>
  <tr>
    <td>Siang</td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
  </tr>
  <tr>
    <td>Malam</td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=inputSelect("slide1_{$i}", $arr_slide1[$i-1]);$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    <td><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
	<input type="hidden" name="count" value="<?=$i;?>">
  </tr>
</tbody>
</table>

<br>

<div class="row">
	<div class="col-1">
		Keterangan:
	</div>

	<div class="col-11">
		Porsi yang dihabiskan (untuk makanan pokok, lauk, sayur, buah dan snack dinilai persentase porsi yang dihabiskan). <br>									
		Diberi nilai 1   = habis 100% ,   3/4 =  habis 75% ,    1/2  = habis 50% ,   0 = tidak dimakan
	</div>
</div>

<br><br>

  <?php if(isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])): ?>
  &nbsp;
<?php elseif(isset($_REQUEST['id'])): ?>
  <button type="submit" class="btn btn-primary">Ganti</button>
  </form>
<?php else:?>
  <button type="submit" class="btn btn-success">Simpan</button>
  </form>
<?php endif; ?>

  <script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
  <script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>
  <script src="../../theme/bs/bootstrap.min.js"></script>
  <script>

    <?php if(isset($_REQUEST['id'])): ?>
			isiCombo('cmbDokSemua',2,<?=$data['id_user']?>,'');
		<?php else: ?>
			isiCombo('cmbDokSemua',2,732,'');
		<?php endif; ?>

	function gantiDokter(comboDokter,statusCek,disabel){
		if(statusCek==true){
			isiCombo('cmbDokPengganti',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokTind',refreshDok);
			isiCombo('cmbDokPengganti',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokRujukUnit,cmbDokRujukDokter,cmbDokRujukRS,cmbDokDiag,cmbDokResep,cmbDokAnamnesa,cmbDokSOAPIER,cmbDokRad');
		}
		else{
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokTind',refreshDok);
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokRujukUnit,cmbDokRujukDokter,cmbDokRujukRS,cmbDokDiag,cmbDokResep,cmbDokAnamnesa,cmbDokSOAPIER,cmbDokRad');
		}
	}

	function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
			var idArr = targetId.split(',');
			var longArr = idArr.length;
			if(longArr > 1){
				for(var nr = 0; nr < longArr; nr++)
					if(document.getElementById(idArr[nr])==undefined){
						alert('Elemen target dengan id: \''+idArr[nr]+'\' tidak ditemukan!');
						return false;
					}
			}
			else{
				if(document.getElementById(targetId)==undefined){
					alert('Elemen target dengan id: \''+targetId+'\' tidak ditemukan!');
					return false;
				}
			}
			
			if(targetId=='cmbDokterUnit')
			{
				Request('../../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId+"&cabang=1",targetId,'','GET',evloaded);
			}else{
				Request('../../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId+"&cabang=1",targetId,'','GET',evloaded);
			}
     }

     <?php if (isset($_REQUEST["pdf"])): ?>
      const pdf = document.getElementById("pdf-area");
      var opt = {
          margin: 0,
          filename: "RM 15.2 <?=$dataPasien["nama"]?>.pdf",
          image: { type: "png", quality: 1 },
          html2canvas: { scale: 1 },
          jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
      };
      html2pdf().from(pdf).set(opt).save();
    <?php endif; ?>
  </script>
</body>

</html>