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
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_12_1_resiko_jatuh_anak WHERE id = '{$_REQUEST['cetak']}'"));
    $arr = []; $arr2 = [];
    $all = $data['all_data'];
    $all_tgl = $data['all_tgl'];
    $str2 = "";

    for ($q=0; $q < strlen($all); $q++) { 

      if ($all[$q] != "|") {
        $str .= $all[$q];
      } else {
        array_push($arr, $str);
        $str = "";
      }
    }

    for($r=0; $r < strlen($all_tgl); $r++) {
      
      if ($all_tgl[$r] != "|") {
        $str2 .= $all_tgl[$r];
      } else {
        array_push($arr2, $str2);
        $str2 = "";
      }
    
    }

  }

  if (isset($_REQUEST['id'])) {
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_12_1_resiko_jatuh_anak WHERE id = '{$_REQUEST['id']}'"));
    $arr = []; $arr2 = [];
    $all = $data['all_data'];
    $str = ""; $str2 = "";
    $all_tgl = $data['all_tgl'];

    for ($q=0; $q < strlen($all); $q++) { 

      if ($all[$q] != "|") {
        $str .= $all[$q];
      } else {
        array_push($arr, $str);
        $str = "";
      }
    }

    for($r=0; $r < strlen($all_tgl); $r++) {
      
      if ($all_tgl[$r] != "|") {
        $str2 .= $all_tgl[$r];
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
      $t = 1; $all_tgl = "";
      $j = $_REQUEST['count'];

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

    for ($z=1; $z < 5; $z++) { 
        $myData = mysql_real_escape_string($_REQUEST["tgl_{$z}"]);

        if ($myData == "") {
            $all_tgl .= "n";
            $all_tgl .= "|";
        } else {
            $all_tgl .= $myData;
            $all_tgl .= "|";
        }

    }

      $data = [
          'id_kunjungan' => mysql_real_escape_string($_REQUEST['id_kunjungan']),
          'id_pelayanan' => mysql_real_escape_string($_REQUEST['id_pelayanan']),
          'tgl_act' => date('Y-m-d H:i:s'),
          'id_user' => mysql_real_escape_string($_REQUEST["cmbDokSemua"]),
          'petugas_asesmen' => mysql_real_escape_string($_REQUEST["petugas_asesmen"]),
          'all_data' => $str,
          'all_tgl' => $all_tgl,
      ];


      $hasil = mysql_query("UPDATE rm_12_1_resiko_jatuh_anak 
            SET
            id_pasien = '{$dataPasien['id']}',
            id_kunjungan = '{$data['id_kunjungan']}',
            id_pelayanan = '{$data['id_pelayanan']}',
            id_user = '{$data['id_user']}',
            petugas_asesmen = '{$data['petugas_asesmen']}',
            tgl_act = '{$data['tgl_act']}',
            all_tgl = '{$data['all_tgl']}',
            all_data = '{$data['all_data']}'
            WHERE 
            id = {$_REQUEST['idx']}");
      

      echo "<script>window.location.href='index.php?idKunj=".$_REQUEST['idKunj']."&idPel=".$_REQUEST['idPel']."&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['idUser']."&tmpLay=".$_REQUEST['tmpLay']."'</script>";
  }

  if (isset($_REQUEST['pdf'])) {
    $print_mode = true;
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_12_1_resiko_jatuh_anak WHERE id = '{$_REQUEST['pdf']}'"));
    $arr = [];
    $arr2 = [];
    $all = $data['all_data'];
    $all_tgl = $data['all_tgl'];
    $str2 = "";

    for ($q=0; $q < strlen($all); $q++) {
        if ($all[$q] != "|") {
            $str .= $all[$q];
        } else {
            array_push($arr, $str);
            $str = "";
        }
    }

    for ($r=0; $r < strlen($all_tgl); $r++) {
        if ($all_tgl[$r] != "|") {
            $str2 .= $all_tgl[$r];
        } else {
            array_push($arr2, $str2);
            $str2 = "";
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
				<div style="float: right">RM 12.1 / PHCM</div>
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
		<h4 class="text-center"><b>ASESMEN RISIKO JATUH ANAK ( HUMPTY DUMTY )</b>

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
    <th rowspan="2">PARAMETER</th>
    <th rowspan="2">KRITERIA</th>
    <th>TGL</th>
    <th colspan="3">
      <?php if(isset($_REQUEST['id']) || isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])): ?>
      <?php if($arr2[0] == "n"): ?>
        &nbsp;
      <?php else: ?>
        <?= $arr2[0] ?>
      <?php endif; ?>
    <?php else: ?>
      <input type="date" name="tgl_1">
    <?php endif; ?>
    </th>

    <th colspan="3">
      <?php if(isset($_REQUEST['id']) || isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])): ?>
      <?php if($arr2[1] == "n"): ?>
        &nbsp;
      <?php else: ?>
        <?= $arr2[1] ?>
      <?php endif; ?>
    <?php else: ?>
      <input type="date" name="tgl_2">
    <?php endif; ?>
  </th>

    <th colspan="3">
      <?php if(isset($_REQUEST['id']) || isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])): ?>
      <?php if($arr2[2] == "n"): ?>
        &nbsp;
      <?php else: ?>
        <?= $arr2[2] ?>
      <?php endif; ?>
    <?php else: ?>
      <input type="date" name="tgl_3">
    <?php endif; ?>
  </th>

    <th colspan="3">
      <?php if(isset($_REQUEST['id']) || isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])): ?>
      <?php if($arr2[3] == "n"): ?>
        &nbsp;
      <?php else: ?>
        <?= $arr2[3] ?>
      <?php endif; ?>
    <?php else: ?>
      <input type="date" name="tgl_4">
    <?php endif; ?>
  </th>

  </tr>
  <tr>
    <td>SKOR</td>
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
    <td>S<br></td>
    <td>M</td>
  </tr>
</thead>
<tbody>
  <tr>
    <td rowspan="4">Umur</td>
    <td>Dibawah 3 tahun</td>
    <td>4</td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
  </tr>
  <tr>
    <td>3-7 tahun</td>
    <td>3</td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
  </tr>
  <tr>
    <td>7-13 tahun</td>
    <td>2</td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
  </tr>
  <tr>
    <td>&gt; 13 tahun</td>
    <td>1</td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
  </tr>
  <tr>
    <td rowspan="2">Jenis Kelamin</td>
    <td>Laki-Laki</td>
    <td>2</td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
  </tr>
  <tr>
    <td>Perempuan</td>
    <td>1</td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
  </tr>
  <tr>
    <td rowspan="4">Diagnosa</td>
    <td>Diagnosa terkait Neurologi</td>
    <td>4</td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
  </tr>
  <tr>
    <td>Perubahan dalam oksigenasi (masalah saluran nafas, dehidrasi anemia, anoreksia, sinkop/sakit kepala dll)</td>
    <td>3</td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
  </tr>
  <tr>
    <td>Kelainan psikis/perilaku</td>
    <td>2</td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
  </tr>
  <tr>
    <td>Diagnosis lain</td>
    <td>1</td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
  </tr>
  <tr>
    <td rowspan="3">Gangguan Kognitif</td>
    <td>Tidak sadar terhadap keterbatasan</td>
    <td>3</td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
  </tr>
  <tr>
    <td>Lupa keterbatasan</td>
    <td>2</td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
  </tr>
  <tr>
    <td>Mengetahui kemampuan diri</td>
    <td>1</td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
  </tr>
  <tr>
    <td rowspan="4">Faktor Lingkungan</td>
    <td>Riwayat jatuh dari TT saat bayi / anak</td>
    <td>4</td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="4" ></td>
  </tr>
  <tr>
    <td>Pasien mengunakan alat bantu / box / mebel</td>
    <td>3</td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
  </tr>
  <tr>
    <td>Pasien berada di tempat tidur</td>
    <td>2</td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
  </tr>
  <tr>
    <td>pasien diluar di ruang rawat</td>
    <td>1</td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
  </tr>
  <tr>
    <td rowspan="3">Respon terhadap operasi/obat penenang/efek anestesi<br></td>
    <td>Dalam 24 jam</td>
    <td>3</td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
  </tr>
  <tr>
    <td>Dalam 48 jam<br></td>
    <td>2</td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
  </tr>
  <tr>
    <td>&gt; 48 jam</td>
    <td>1</td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
  </tr>
  <tr>
    <td rowspan='3'>Penggunaan obat</td>
    <td>Bermacam – macam obat yang digunakan : obat sedative (kecuali pasien ICU yang menggunakan sedasi dan paralisis ), hipnotik , barbiturate, fenotiazin, antidepresan, laksans/diuretika, narkotik </td>
    <td>3</td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="3" ></td>
  </tr>
  <tr>
    <td>Salah satu dari pengobatan diatas</td>
    <td>2</td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="2" ></td>
  </tr>
  <tr>
    <td>Pengobatan lain</td>
    <td>1</td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;$i++;?>" value="1" ></td>
    <td><input type="checkbox" class="check" onchange="changed()" <?= checked($arr[$i-1]); ?> id="check_<?=$i;?>" name="check_<?=$i;?>" value="1" ></td>
  </tr>
  <input type="hidden" name="count" value='<?=$i;?>'>
  <tr>
    <td colspan="2">TOTAL SKOR</td>
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
    <td colspan="2">Kategori resiko jatuh (diisi R, S atau T)<br>1-6 = rendah (R), 7-11 = sedang (S) dan &gt; 12 = tinggi (T)<br></td>
    <td></td>
    <td><input type="tezt" class="inv" value="" id="kat_1"></td>
    <td><input type="tezt" class="inv" value="" id="kat_2"></td>
    <td><input type="tezt" class="inv" value="" id="kat_3"></td>
    <td><input type="tezt" class="inv" value="" id="kat_4"></td>
    <td><input type="tezt" class="inv" value="" id="kat_5"></td>
    <td><input type="tezt" class="inv" value="" id="kat_6"></td>
    <td><input type="tezt" class="inv" value="" id="kat_7"></td>
    <td><input type="tezt" class="inv" value="" id="kat_8"></td>
    <td><input type="tezt" class="inv" value="" id="kat_9"></td>
    <td><input type="tezt" class="inv" value="" id="kat_10"></td>
    <td><input type="tezt" class="inv" value="" id="kat_11"></td>
    <td><input type="tezt" class="inv" value="" id="kat_12"></td>
  </tr>
  <tr> 
    <td colspan="3">Nama perawat yang melakukan asesmen <br><br>
    <?php if(isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])): ?>
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

        if ((isi > 0) && (isi < 7)) {
          document.getElementById('kat_'+e).value = "R";
        } else if((isi > 7) && (isi < 13)) {
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
          filename: "RM 12.1 <?=$dataPasien["nama"]?>.pdf",
          image: { type: "png", quality: 1 },
          html2canvas: { scale: 1 },
          jsPDF: { unit: "in", format: "letter", orientation: "landscape" }
      };
      html2pdf().from(pdf).set(opt).save();
    <?php endif; ?>
  </script>
</body>

</html>