<?php
	use yii\helpers\Html;
	include '../function/form.php';
	include '../../koneksi/konek.php';
	$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
  $no = 1; $i = 1;
  
  function inputSelect($name, $data){
    if (isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])) {
        if ($data == "0") {
        $html = "<input readonly class='selects inv' name='check_{$name}' value='0'>";
        return $html;
      } else {
        $html = "<input readonly class='selects inv' name='check_{$name}' value='{$data}'>";
        return $html;
      }
    } else {
      if ($data == "0") {
        $html = "<select onchange='changed()' class='selects' name='check_{$name}' required><option value='0'>0</option><option value='7'>7</option></select>";
        return $html;
      } else {
        $html = "<select onchange='changed()' class='selects' name='check_{$name}' required><option value='7'>7</option><option value='0'>0</option></select>";
        return $html;
      }
    }
}

function inputD($name, $data){
    if (isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])) {
        if ($data == "0") {
        $html = "";
        return $html;
      } else {
        $html = $data;
        return $html;
      }
    } else {
      if ($data == "0") {
        $html = "<input type='date' name='{$name}'>";
        return $html;
      } else {
        $html = "<input type='date' value='{$data}' name='{$name}'>";
        return $html;
      }
    }
}

		function checked($data) {
			if (isset($_REQUEST['cetak']) || isset($_REQUEST['pdf']) || isset($_REQUEST['id'])) {
				if ($data != "0") {
				return "checked";
				}
      }
		}

	if (isset($_REQUEST['cetak'])) {
		$print_mode = true;
		echo "<script>window.print();</script>";
		$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_12_2_resiko_jatuh_geriatri WHERE id = '{$_REQUEST['cetak']}'"));
		$arr = [];
		$all = $data['all_data'];
		$str_tgl = "";
    $arr_tgl = [];
    $all_tgl = $data['tgl'];

    for ($t=0; $t < strlen($all_tgl); $t++) { 

      if ($all_tgl[$t] != "|") {
        $str_tgl .= $all_tgl[$t];
      } else {
        array_push($arr_tgl, $str_tgl);
        $str_tgl = "";
      }
    }

		for ($q=0; $q < strlen($all); $q++) { 

			if ($all[$q] != "|") {
				$str .= $all[$q];
			} else {
				array_push($arr, $str);
				$str = "";
			}
		}

  }
  
  if (isset($_REQUEST['pdf'])) {
    $print_mode = true;
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_12_2_resiko_jatuh_geriatri WHERE id = '{$_REQUEST['pdf']}'"));
    $arr = [];
    $all = $data['all_data'];
    $str_tgl = "";
    $arr_tgl = [];
    $all_tgl = $data['tgl'];

    for ($t=0; $t < strlen($all_tgl); $t++) {
        if ($all_tgl[$t] != "|") {
            $str_tgl .= $all_tgl[$t];
        } else {
            array_push($arr_tgl, $str_tgl);
            $str_tgl = "";
        }
    }

    for ($q=0; $q < strlen($all); $q++) {
        if ($all[$q] != "|") {
            $str .= $all[$q];
        } else {
            array_push($arr, $str);
            $str = "";
        }
    }
}


	if (isset($_REQUEST['id'])) {
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_12_2_resiko_jatuh_geriatri WHERE id = '{$_REQUEST['id']}'"));
    $arr = [];
		$all = $data['all_data'];
		$str = "";
    $str_tgl = "";
    $arr_tgl = [];
    $all_tgl = $data['tgl'];

    for ($t=0; $t < strlen($all_tgl); $t++) { 

      if ($all_tgl[$t] != "|") {
        $str_tgl .= $all_tgl[$t];
      } else {
        array_push($arr_tgl, $str_tgl);
        $str_tgl = "";
      }
    }

		for ($q=0; $q < strlen($all); $q++) { 

			if ($all[$q] != "|") {
				$str .= $all[$q];
			} else {
				array_push($arr, $str);
				$str = "";
			}
		}
    
	}

	if (isset($_REQUEST['idx'])) {
		date_default_timezone_set("Asia/Jakarta");
	    $id_kunj = (int)$_REQUEST["id_kunjungan"];
	    $sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$id_kunj'"));
	    $tgl_act = date('Y-m-d H:i:s');
	    $keputusan = $_REQUEST["keputusan"];
      $str = ""; $str_tgl = "";

      $t = 1;
      $j = $_REQUEST['count'];

    while ($t <= $j) {

        $myData = mysql_real_escape_string($_REQUEST["check_{$t}"]);

        if ($myData == "") {
            $str .= "0";
            $str .= "|";
        } else {
            $str .= $myData;
            $str .= "|";
        }
        
        $t++;
    }

    for ($e=1; $e < 5; $e++) {
    $myData = mysql_real_escape_string($_REQUEST["tgl_{$e}"]);

    if ($myData == "") {
        $str_tgl .= "0";
        $str_tgl .= "|";
    } else {
        $str_tgl .= $myData;
        $str_tgl .= "|";
    }
}


	    $data = [
	        'id_kunjungan' => mysql_real_escape_string($_REQUEST['id_kunjungan']),
	        'id_pelayanan' => mysql_real_escape_string($_REQUEST['id_pelayanan']),
	        'tgl_act' => date('Y-m-d H:i:s'),
          'id_user' => mysql_real_escape_string($_REQUEST["cmbDokSemua"]),
          'petugas_asesmen' => mysql_real_escape_string($_REQUEST["petugas_asesmen"]),
          'all_data' => $str,
          'tgl' => $str_tgl
	    ];

	    $hasil = mysql_query("UPDATE rm_12_2_resiko_jatuh_geriatri 
	    			SET
            id_pasien = '{$dataPasien['id']}',
			    	id_kunjungan = '{$data['id_kunjungan']}',
			    	id_pelayanan = '{$data['id_pelayanan']}',
			    	id_user = '{$data['id_user']}',
            petugas_asesmen = '{$data['petugas_asesmen']}',
            tgl_act = '{$data['tgl_act']}',
            all_data = '{$data['all_data']}',
            tgl = '{$data['tgl']}'
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
				<div style="float: right">RM 12.2 / PHCM</div>
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
		<h4 class="text-center">ASESMEN RISIKO JATUH GERIATRI ( Usia > 60 tahun )<br>
Ontario Modified  Stratufy- Sydney Scoring
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
		<table border="1px" style="width: 100%" class="text-center">
<thead>
  <tr>
    <th rowspan="2">No</th>
    <th rowspan="2">Parameter</th>
    <th rowspan="2">Skrining</th>
    <th rowspan="2">Keterangan Nilai</th>
    <th colspan="3"><?=inputD('tgl_1', $arr_tgl[0]);?></th>
    <th colspan="3"><?=inputD('tgl_2', $arr_tgl[1]);?></th>
    <th colspan="3"><?=inputD('tgl_3', $arr_tgl[2]);?></th>
    <th colspan="3"><?=inputD('tgl_4', $arr_tgl[3]);?></th>
  </tr>
  <tr>
    <td>P</td>
    <td>S</td>
    <td>M</td>
    <td>P</td>
    <td>S</td>
    <td>M</td>
    <td>P</td>
    <td>S</td>
    <td>M</td>
    <td>P</td>
    <td>S</td>
    <td>M</td>
  </tr>
</thead>
<tbody>
  <tr>
    <td rowspan="2">1</td>
    <td rowspan="2">Riwayat jatuh</td>
    <td>Apakah pasien datang ke RS karena jatuh?</td>
    <td rowspan="2">Salah satu jawaban Ya = 6</td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="6" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="6" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="6" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="6" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="6" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="6" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="6" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="6" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="6" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="6" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="6" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="6" ></td>
  </tr>
  <tr>
    <td>Jika Tidak, apakah pasien mengalami jatuh dalam 2 bulan terakhir ?</td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="6" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="6" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="6" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="6" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="6" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="6" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="6" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="6" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="6" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="6" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="6" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="6" ></td>
  </tr>
  <tr>
    <td rowspan="3">2</td>
    <td rowspan="3">Status Mental</td>
    <td>Apakah pasien mengalami  delirium? ( tidak dapat membuat keputusan, pola pikir tidak terorganisir, gangguan daya ingat )</td>
    <td rowspan="3">Salah satu jawaban Ya = 14</td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
  </tr>
  <tr>
    <td>Apakah pasien disorientasi? (salah menyebutkan waktu, tempat, atau orang )</td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
  </tr>
  <tr>
    <td>Apakah pasien mengalami agitasi? (ketakutan, gelisah, dan cemas )</td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="14" ></td>
  </tr>
  <tr>
    <td rowspan="3">3</td>
    <td rowspan="3">Penglihatan</td>
    <td>Apakah pasien memakai kacamata?</td>
    <td rowspan="3">Salah satu jawaban Ya   = 1</td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
  </tr>
  <tr>
    <td>Apakah pasien mengeluh adanya penglihatan buram ?</td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
  </tr>
  <tr>
    <td>Apakah pasien mempunyai glukoma, katarak atau degenerasi makula ? </td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
  </tr>
  <tr>
    <td>4</td>
    <td>Kebiasaan Berkemih</td>
    <td>Apakah terdapat perubahan perilaku berkemih ? (frekuensi, urgensi, inkontinensia, nokturia)</td>
    <td>Ya = 2</td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
  </tr>
  <tr>
    <td>5<br></td>
    <td>Transfer (dari tempat tidur ke kursi dan kembali)</td>
    <td>Mandiri (boleh menggunakan alat bantu jalan ) :                     nilai =  0
Memerlukan bantuan (1 org)/ dalam pengawasan :         nilai =  1
Memerlukan bantuan ( 2 org) :                       
                                              nilai =  2
Tidak dapat duduk dengan se- imbang (bantuan total ) :  nilai = 3
</td>
    <td rowspan="2">Jumlahkan nilai transfer + mobilitas

Nilai total  0-3, beri skor    = 0

Nilai total  4-6, beri skor    = 7
</td>
    <td rowspan="2"><?= inputSelect($i, $arr[$i-1]);$i++; ?></td>
    <td rowspan="2"><?= inputSelect($i, $arr[$i-1]);$i++; ?></td>
    <td rowspan="2"><?= inputSelect($i, $arr[$i-1]);$i++; ?></td>
    <td rowspan="2"><?= inputSelect($i, $arr[$i-1]);$i++; ?></td>
    <td rowspan="2"><?= inputSelect($i, $arr[$i-1]);$i++; ?></td>
    <td rowspan="2"><?= inputSelect($i, $arr[$i-1]);$i++; ?></td>
    <td rowspan="2"><?= inputSelect($i, $arr[$i-1]);$i++; ?></td>
    <td rowspan="2"><?= inputSelect($i, $arr[$i-1]);$i++; ?></td>
    <td rowspan="2"><?= inputSelect($i, $arr[$i-1]);$i++; ?></td>
    <td rowspan="2"><?= inputSelect($i, $arr[$i-1]);$i++; ?></td>
    <td rowspan="2"><?= inputSelect($i, $arr[$i-1]);$i++; ?></td>
    <td rowspan="2"><?= inputSelect($i, $arr[$i-1]); ?> <input type="hidden" name="count" value="<?=$i;?>"></td>
  </tr>
  <tr>
    <td>6</td>
    <td>Mobilitas</td>
    <td>Mandiri (boleh menggunakan alat bantu jalan ) :                      nilai =  0
Berjalan dg bantuan 1 org :nilai = 1
Menggunakan kursi roda : nilai = 2
Imobilisasi :                           nilai = 3
</td>
  </tr>
  <tr>
    <td colspan="4">Total Skor</td>
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
  	<td colspan="4">Nama petugas yang melakukan asesmen <br><br>

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
  </tr>
</tbody>
</table>

<br>

<b>Keterangan :   Skor 0-5 = Risiko rendah ,    Skor 6-16  = Risiko sedang ,     Skor > 16 =  Risiko tinggi </b><br><br><br>

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

    function changed() {
		let checkboxes = document.querySelectorAll("input[type=checkbox]");
		let selects = document.querySelectorAll(".selects");
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
      total1 += parseInt(selects[0].value);
      total2 += parseInt(selects[1].value);
      total3 += parseInt(selects[2].value);
      total4 += parseInt(selects[3].value);
      total5 += parseInt(selects[4].value);
      total6 += parseInt(selects[5].value);
      total7 += parseInt(selects[6].value);
      total8 += parseInt(selects[7].value);
      total9 += parseInt(selects[8].value);
      total10 += parseInt(selects[9].value);
      total11 += parseInt(selects[10].value);
      total12 += parseInt(selects[11].value);
  
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
    }
    }

    <?php if(isset($_REQUEST["pdf"])): ?>
      const pdf = document.getElementById("pdf-area");
      var opt = {
          margin: 0,
          filename: "RM 12.2 <?=$dataPasien["nama"]?>.pdf",
          image: { type: "png", quality: 1 },
          html2canvas: { scale: 1 },
          jsPDF: { unit: "in", format: "A4", orientation: "landscape" }
      };
      html2pdf().from(pdf).set(opt).save();
    <?php endif; ?>
	</script>

</body>

</html>