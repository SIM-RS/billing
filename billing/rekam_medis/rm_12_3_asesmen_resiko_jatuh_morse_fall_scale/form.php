<?php
	use yii\helpers\Html;
	include '../function/form.php';
	include '../../koneksi/konek.php';
	$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
  $no = 1; $i = 1; $t = 1;

    function checked($data) {
      if (isset($_REQUEST['cetak']) || isset($_REQUEST['pdf']) || isset($_REQUEST['id'])) {

        if ($data != "n") {
          return "checked";
        }
      }
    }

  if (isset($_REQUEST['cetak'])) {
    $print_mode = true;
    echo "<script>window.print();</script>";
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_12_2_resiko_jatuh_morse_fall_scale WHERE id = '{$_REQUEST['cetak']}'"));
    $arr = [];
    $arr2 = [];
    $all = $data['all_data'];
    $all2 = $data['all_data_2'];
    $str = "";
    $str2 = "";

    for ($q=0; $q < strlen($all); $q++) { 

      if ($all[$q] != "|") {
        $str .= $all[$q];
      } else {
        array_push($arr, $str);
        $str = "";
      }
    }

    for ($y=0; $y < strlen($all2); $y++) { 

      if ($all2[$y] != "|") {
        $str2 .= $all2[$y];
      } else {
        array_push($arr2, $str2);
        $str2 = "";
      }
    }

  }

  if (isset($_REQUEST['pdf'])) {
    $print_mode = true;
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_12_2_resiko_jatuh_morse_fall_scale WHERE id = '{$_REQUEST['pdf']}'"));
    $arr = [];
    $arr2 = [];
    $all = $data['all_data'];
    $all2 = $data['all_data_2'];
    $str = "";
    $str2 = "";

    for ($q=0; $q < strlen($all); $q++) { 

      if ($all[$q] != "|") {
        $str .= $all[$q];
      } else {
        array_push($arr, $str);
        $str = "";
      }
    }

    for ($y=0; $y < strlen($all2); $y++) { 

      if ($all2[$y] != "|") {
        $str2 .= $all2[$y];
      } else {
        array_push($arr2, $str2);
        $str2 = "";
      }
    }

  }

  if (isset($_REQUEST['id'])) {
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_12_2_resiko_jatuh_morse_fall_scale WHERE id = '{$_REQUEST['id']}'"));
    $arr = [];
    $arr2 = [];
    $all = $data['all_data'];
    $all2 = $data['all_data_2'];
    $str = "";
    $str2 = "";

    for ($q=0; $q < strlen($all); $q++) { 

      if ($all[$q] != "|") {
        $str .= $all[$q];
      } else {
        array_push($arr, $str);
        $str = "";
      }
    }


    for ($y=0; $y < strlen($all2); $y++) { 

      if ($all2[$y] != "|") {
        $str2 .= $all2[$y];
      } else {
        array_push($arr2, $str2);
        $str2 = "";
      }
    }
    
  }

  if (isset($_REQUEST['idx'])) {
    date_default_timezone_set("Asia/Jakarta");
      $id_kunj = (int)$_REQUEST["id_kunjungan"];
      $sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$id_kunj'"));
      $tgl_act = date('Y-m-d H:i:s');
      $keputusan = $_REQUEST["keputusan"];
      $str = ""; $str2 = "";
      $t = 1; $w = 1;
      $j = $_REQUEST['count'];
      $q = $_REQUEST['count2'];

    while ($t <= $j) {

        $myData = mysql_real_escape_string($_REQUEST["check_{$t}"]);

        if ($myData == "") {
            $str .= "n";
            $str .= "|";
        } else {
            $str .= $myData;
            $str .= "|";
        }
        
        $t++;
    }

    while ($w <= $q) {

        $myData = mysql_real_escape_string($_REQUEST["checks_{$w}"]);

        if ($myData == "") {
            $str2 .= "n";
            $str2 .= "|";
        } else {
            $str2 .= $myData;
            $str2 .= "|";
        }
        
        $w++;
    }

      $data = [
          'id_kunjungan' => mysql_real_escape_string($_REQUEST['id_kunjungan']),
          'id_pelayanan' => mysql_real_escape_string($_REQUEST['id_pelayanan']),
          'tgl_act' => date('Y-m-d H:i:s'),
          'id_user' => mysql_real_escape_string($_REQUEST["cmbDokSemua"]),
          'petugas_asesmen' => mysql_real_escape_string($_REQUEST["petugas_asesmen"]),
          'all_data' => $str,
          'all_data_2' => $str2
      ];

      $hasil = mysql_query("UPDATE rm_12_2_resiko_jatuh_morse_fall_scale 
            SET
            id_pasien = '{$dataPasien['id']}',
            id_kunjungan = '{$data['id_kunjungan']}',
            id_pelayanan = '{$data['id_pelayanan']}',
            id_user = '{$data['id_user']}',
            petugas_asesmen = '{$data['petugas_asesmen']}',
            tgl_act = '{$data['tgl_act']}',
            all_data = '{$data['all_data']}',
            all_data_2 = '{$data['all_data_2']}'
            WHERE 
            id = {$_REQUEST['idx']}");
      
      echo "<script>window.location.href='index.php?idKunj=".$_REQUEST['idKunj']."&idPel=".$_REQUEST['idPel']."&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['idUser']."&tmpLay=".$_REQUEST['tmpLay']."'</script>";
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
      width:100%;
      cursor :default;
      text-align:center;
    }
	</style>
  <script src="../html2pdf/ppdf.js"></script>
</head>

<body id="pdf-area">
	<div class="container bg-white" style="padding: 10px">
		<div class="row">

				<div class="col-6 text-center"><br><br><br><br>
				<img src="../logors1.png">
			</div>
			<div class="col-6" style="padding:40px">
				<div style="float: right">RM 12.3 / PHCM</div>
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

		<hr class="bg-dark" style="margin-top:-25px"><br>
		<div style="height:5px;background-color:black;width:100%;margin-bottom:10px;margin-top:-35px"></div>
		<h4 class="text-center">ASESMEN RISIKO JATUH MORSE FALL SCALE <br>
( Usia > 14 tahun sampai usia 60 tahun) 

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
  
		<table border="1px" style="width:100%" class="text-center">
<thead>
  <tr>
    <th colspan="3">TANGGAL</th>
    <th colspan="3"></th>
    <th colspan="3"></th>
    <th colspan="3"></th>
    <th colspan="3"></th>
  </tr>
</thead>
<tbody>
  <tr>
    <th colspan="3">SHIFT</th>
    <th>P</th>
    <th>S</th>
    <th>M</th>
    <th>P</th>
    <th>S</th>
    <th>M</th>
    <th>P</th>
    <th>S</th>
    <th>M</th>
    <th>P</th>
    <th>S</th>
    <th>M</th>
  </tr>
  <tr>
    <th>INDIKATOR</th>
    <th>KATEGORI</th>
    <th>SKOR</th>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td rowspan="2">Riwayat jatuh</td>
    <td>Pernah jatuh 3 bulan terakhir</td>
    <td>25</td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="25" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="25" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="25" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="25" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="25" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="25" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="25" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="25" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="25" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="25" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="25" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="25" ></td>
  </tr>
  <tr>
    <td>Tidak pernah jatuh</td>
    <td>0</td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
  </tr>
  <tr>
    <td rowspan="2">Diagnosis medis &gt; 1</td>
    <td>Terdapat &gt; 1 diagnosa medis</td>
    <td>15</td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
  </tr>
  <tr>
    <td>Hanya 1 diagnosa medis</td>
    <td>0</td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
  </tr>
  <tr>
    <td rowspan="3">Alat bantu jalan</td>
    <td>Berjalan dengan berpegangan pda furniture untuk menopang</td>
    <td>30</td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="30" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="30" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="30" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="30" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="30" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="30" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="30" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="30" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="30" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="30" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="30" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="30" ></td>
  </tr>
  <tr>
    <td>Berjalan menggunakan kruk tongkat atau walker</td>
    <td>15</td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
  </tr>
  <tr>
    <td>Berjalan normal tirah baring tidak bergerak</td>
    <td>0</td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
  </tr>
  <tr>
    <td rowspan="2">Menggunakan infus</td>
    <td>Menggunakan infus</td>
    <td>15</td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
  </tr>
  <tr>
    <td>Tidak diinfus</td>
    <td>0</td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
  </tr>
  <tr>
    <td rowspan="3">Cara berjalan</td>
    <td>Terganggu</td>
    <td>20</td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="20" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="20" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="20" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="20" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="20" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="20" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="20" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="20" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="20" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="20" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="20" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="20" ></td>
  </tr>
  <tr>
    <td>Lemah</td>
    <td>10</td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="10" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="10" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="10" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="10" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="10" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="10" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="10" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="10" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="10" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="10" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="10" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="10" ></td>
  </tr>
  <tr>
    <td>Normal, tirah baring, tidak bergerak</td>
    <td>0</td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
  </tr>
  <tr>
    <td rowspan="2">Status mental</td>
    <td>Lupa keterbatasan</td>
    <td>15</td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="15" ></td>
  </tr>
  <tr>
    <td>Mengetahui kemampuan diri</td>
    <td>0</td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;$i++;?>" value="0" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" class="check" name="check_<?=$i;?>" value="0" ></td>
    <input type="hidden" name="count" value="<?=$i;?>">
  </tr>
  <tr>
    <th colspan="2">TOTAL SKOR</th>
    <td></td>
    <td id="total_1"></td>
    <td id="total_2"></td>
    <td id="total_3"></td>
    <td id="total_4"></td>
    <td id="total_5"></td>
    <td id="total_6"></td>
    <td id="total_7"></td>
    <td id="total_8"></td>
    <td id="total_9"></td>
    <td id="total_10"></td>
    <td id="total_11"></td>
    <td id="total_12"></td>
  </tr>
  <tr>
    <td colspan="2"><b>Kategori resiko jatuh (diisi R, S atau T)</b><br>0-24=Rendah (R), 25-44=Sedang (S), &gt;=45=Tinggi (T)<br></td>
    <td></td>
    <td><input type="text" class="inv" value="" readonly="" id="kat_1" name="kat_1"></td>
    <td><input type="text" class="inv" value="" readonly="" id="kat_2" name="kat_2"></td>
    <td><input type="text" class="inv" value="" readonly="" id="kat_3" name="kat_3"></td>
    <td><input type="text" class="inv" value="" readonly="" id="kat_4" name="kat_4"></td>
    <td><input type="text" class="inv" value="" readonly="" id="kat_5" name="kat_5"></td>
    <td><input type="text" class="inv" value="" readonly="" id="kat_6" name="kat_6"></td>
    <td><input type="text" class="inv" value="" readonly="" id="kat_7" name="kat_7"></td>
    <td><input type="text" class="inv" value="" readonly="" id="kat_8" name="kat_8"></td>
    <td><input type="text" class="inv" value="" readonly="" id="kat_9" name="kat_9"></td>
    <td><input type="text" class="inv" value="" readonly="" id="kat_10" name="kat_10"></td>
    <td><input type="text" class="inv" value="" readonly="" id="kat_11" name="kat_11"></td>
    <td><input type="text" class="inv" value="" readonly="" id="kat_12" name="kat_12"></td>
  </tr>
  <tr>
    <th colspan="2">Beri tanda cek (√) untuk kriteria dibawah ini</th>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td colspan="2">Pemberian terapi yang berdampak pasien beresiko jatuh</td>
    <td>√</td>
    <td><input type="checkbox" <?=checked($arr2[$t-1])?> value="1" name="checks_<?=$t;$t++;?>"></td>
    <td><input type="checkbox" <?=checked($arr2[$t-1])?> value="1" name="checks_<?=$t;$t++;?>"></td>
    <td><input type="checkbox" <?=checked($arr2[$t-1])?> value="1" name="checks_<?=$t;$t++;?>"></td>
    <td><input type="checkbox" <?=checked($arr2[$t-1])?> value="1" name="checks_<?=$t;$t++;?>"></td>
    <td><input type="checkbox" <?=checked($arr2[$t-1])?> value="1" name="checks_<?=$t;$t++;?>"></td>
    <td><input type="checkbox" <?=checked($arr2[$t-1])?> value="1" name="checks_<?=$t;$t++;?>"></td>
    <td><input type="checkbox" <?=checked($arr2[$t-1])?> value="1" name="checks_<?=$t;$t++;?>"></td>
    <td><input type="checkbox" <?=checked($arr2[$t-1])?> value="1" name="checks_<?=$t;$t++;?>"></td>
    <td><input type="checkbox" <?=checked($arr2[$t-1])?> value="1" name="checks_<?=$t;$t++;?>"></td>
    <td><input type="checkbox" <?=checked($arr2[$t-1])?> value="1" name="checks_<?=$t;$t++;?>"></td>
    <td><input type="checkbox" <?=checked($arr2[$t-1])?> value="1" name="checks_<?=$t;$t++;?>"></td>
    <td><input type="checkbox" <?=checked($arr2[$t-1])?> value="1" name="checks_<?=$t;$t++;?>"></td>
  </tr>
  <tr>
    <td colspan="2">Intervensi manajemen resiko jatuh<br>(Edukasi, pencegahan jatuh, gelang resiko, tanda di TT)<br></td>
    <td>√</td>
    <td><input type="checkbox" <?=checked($arr2[$t-1])?> value="1" name="checks_<?=$t;$t++;?>"></td>
    <td><input type="checkbox" <?=checked($arr2[$t-1])?> value="1" name="checks_<?=$t;$t++;?>"></td>
    <td><input type="checkbox" <?=checked($arr2[$t-1])?> value="1" name="checks_<?=$t;$t++;?>"></td>
    <td><input type="checkbox" <?=checked($arr2[$t-1])?> value="1" name="checks_<?=$t;$t++;?>"></td>
    <td><input type="checkbox" <?=checked($arr2[$t-1])?> value="1" name="checks_<?=$t;$t++;?>"></td>
    <td><input type="checkbox" <?=checked($arr2[$t-1])?> value="1" name="checks_<?=$t;$t++;?>"></td>
    <td><input type="checkbox" <?=checked($arr2[$t-1])?> value="1" name="checks_<?=$t;$t++;?>"></td>
    <td><input type="checkbox" <?=checked($arr2[$t-1])?> value="1" name="checks_<?=$t;$t++;?>"></td>
    <td><input type="checkbox" <?=checked($arr2[$t-1])?> value="1" name="checks_<?=$t;$t++;?>"></td>
    <td><input type="checkbox" <?=checked($arr2[$t-1])?> value="1" name="checks_<?=$t;$t++;?>"></td>
    <td><input type="checkbox" <?=checked($arr2[$t-1])?> value="1" name="checks_<?=$t;$t++;?>"></td>
    <td><input type="checkbox" <?=checked($arr2[$t-1])?> value="1" name="checks_<?=$t;?>"></td>
    <input type="hidden" name="count2" value="<?=$t;?>">
  </tr>
  <tr>
    <td colspan="2">Nama perawat / bidan yang melakukan asesmen <br><br><br>
      <?php if(isset($_REQUEST['cetak'])): ?>
                <select style="display:none" name="cmbDokSemua" id="cmbDokSemua"></select>
                <?php echo mysql_fetch_assoc(mysql_query("SELECT nama FROM b_ms_pegawai WHERE id = {$data['id_user']}"))['nama']; ?>
              <?php else: ?>
                <select class="form-control" name="cmbDokSemua" id="cmbDokSemua"></select>
              <?php endif; ?>
    </td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</tbody>
</table><br><br><br>

<?php if(isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])): ?>
	&nbsp;
<?php elseif(isset($_REQUEST['id'])): ?>
	<button type="submit" class="btn btn-primary">Ganti</button>
	</form>
<?php else:?>
	<button type="submit" class="btn btn-success">Simpan</button>
	</form>
<?php endif; ?>

<div style="text-align: right"><img style="width: 350px" class="text-right" src="../../images/alamat.jpg"></div>

<br>

		</div>
	</div>
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>
	<script src="../../theme/bs/bootstrap.min.js"></script>
  <script type="text/javascript">
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
  changed();

  function validCat() {
      for (var e = 1; e < 13; e++) {
        let isi = parseInt(document.getElementById("total_"+e).innerHTML);

        if ((isi > -1) && (isi < 25)) {
          document.getElementById('kat_'+e).value = "R";
        } else if((isi > 24) && (isi < 45)) {
          document.getElementById('kat_'+e).value = "S";
        } else {
          document.getElementById('kat_'+e).value = "T";
        }

      }
    }

    function changed() {
    let checkboxes = document.querySelectorAll(".check");
    let total1 = 0; let total2 = 0; let total3 = 0; let total4 = 0; let total5 = 0; let total6 = 0; let total7 = 0; let total8 = 0; let total9 = 0; let total10 = 0; let total11 = 0; let total12 = 0;

    for (var i = 0; i < checkboxes.length; i++) {
      if (checkboxes[i].checked) {
        let count = (i+1) % 12;
        if (count == 1 || i == 0) {
          total1 += parseInt(checkboxes[i].value);
        } else if (count == 2 || i == 1) {
          total2 += parseInt(checkboxes[i].value);
        } else if (count == 3 || i == 2) {
          total3 += parseInt(checkboxes[i].value);
        } else if (count == 4 || i == 3) {
          total4 += parseInt(checkboxes[i].value);
        } else if (count == 5 || i == 4) {
          total5 += parseInt(checkboxes[i].value);
        } else if (count == 6 || i == 5) {
          total6 += parseInt(checkboxes[i].value);
        } else if (count == 7 || i == 6) {
          total7 += parseInt(checkboxes[i].value);
        } else if (count == 8 || i == 7) {
          total8 += parseInt(checkboxes[i].value);
        } else if (count == 9 || i == 8) {
          total9 += parseInt(checkboxes[i].value);
        } else if (count == 10 || i == 9) {
          total10 += parseInt(checkboxes[i].value);
        } else if (count == 11 || i == 10) {
          total11 += parseInt(checkboxes[i].value);
        } else if (count == 0) {
          total12 += parseInt(checkboxes[i].value);
        }
      }
    }
      addAll();
    

    function addAll() {
  
      document.getElementById("total_1").innerHTML = total1;
      document.getElementById("total_2").innerHTML = total2;
      document.getElementById("total_3").innerHTML = total3;
      document.getElementById("total_4").innerHTML = total4;
      document.getElementById("total_5").innerHTML = total5;
      document.getElementById("total_6").innerHTML = total6;
      document.getElementById("total_7").innerHTML = total7;
      document.getElementById("total_8").innerHTML = total8;
      document.getElementById("total_9").innerHTML = total9;
      document.getElementById("total_10").innerHTML = total10;
      document.getElementById("total_11").innerHTML = total11;
      document.getElementById("total_12").innerHTML = total12;

      validCat();

    }

    

    }

    <?php if(isset($_REQUEST["pdf"])): ?>
      const pdf = document.getElementById("pdf-area");
      var opt = {
          margin: 0,
          filename: "RM 12.3 <?=$dataPasien["nama"]?>.pdf",
          image: { type: "png", quality: 1 },
          html2canvas: { scale: 1 },
          jsPDF: { unit: "in", format: "letter", orientation: "landscape" }
      };
      html2pdf().from(pdf).set(opt).save();
    <?php endif; ?>
  </script>
</body>

</html>