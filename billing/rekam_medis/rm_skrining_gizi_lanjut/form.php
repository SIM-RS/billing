<?php
	use yii\helpers\Html;
	include '../function/form.php';
	include '../../koneksi/konek.php';
	include 'funct.php';
	$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
	$i = 1;
	
	if (isset($_REQUEST['cetak'])) {
    $print_mode = true;
    echo "<script>window.print();</script>";
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_15_6_skrining_gizi_lanjut WHERE id = '{$_REQUEST['cetak']}'"));
    $BB = $data['BB']; $TB = $data['TB']; $IMT = $data['IMT']; $TL = $data['tinggi_lutut']; $LLA = $data['LLA'];

	$arr_data = [];
  $all = $data['data'];
	$str = "";

	for ($r=0; $r < strlen($all); $r++) { 
		if ($all[$r] != "|") {
			$str .= $all[$r];
		} else {
			array_push($arr_data, $str);
			$str = "";
		}
	}

  }

  if (isset($_REQUEST['pdf'])) {
    $print_mode = true;
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_15_6_skrining_gizi_lanjut WHERE id = '{$_REQUEST['pdf']}'"));
    $BB = $data['BB']; $TB = $data['TB']; $IMT = $data['IMT']; $TL = $data['tinggi_lutut']; $LLA = $data['LLA'];

	$arr_data = [];
  $all = $data['data'];
	$str = "";

	for ($r=0; $r < strlen($all); $r++) { 
		if ($all[$r] != "|") {
			$str .= $all[$r];
		} else {
			array_push($arr_data, $str);
			$str = "";
		}
	}

  }

  if (isset($_REQUEST['id'])) {
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_15_6_skrining_gizi_lanjut WHERE id = '{$_REQUEST['id']}'"));
    $arr_data = [];
    $all = $data['data'];
	  $str = "";
    $BB = $data['BB']; $TB = $data['TB']; $IMT = $data['IMT']; $TL = $data['tinggi_lutut']; $LLA = $data['LLA'];
    
	for ($r=0; $r < strlen($all); $r++) { 
		if ($all[$r] != "|") {
			$str .= $all[$r];
		} else {
			array_push($arr_data, $str);
			$str = "";
		}
	}
    var_dump($arr_data);
  }

  if (isset($_REQUEST['idx'])) {
	date_default_timezone_set("Asia/Jakarta");
	$tgl_act = date('Y-m-d H:i:s');
	$str = ""; 
    $q = mysql_real_escape_string($_REQUEST['i']);

    for ($e=1; $e < $q; $e++) {
        $data = mysql_real_escape_string($_REQUEST["data_{$e}"]);
        if ($data != "") {
            $str .= $data;
            $str .= "|";
        } else {
            $str .= "#";
            $str .= "|";
		}
	}

      $data = [
          'id_kunjungan' => mysql_real_escape_string($_REQUEST['id_kunjungan']),
          'id_pelayanan' => mysql_real_escape_string($_REQUEST['id_pelayanan']),
          'tgl_act' => date('Y-m-d H:i:s'),
          'id_user' => mysql_real_escape_string($_REQUEST["id_user"]),
          'BB' => mysql_real_escape_string($_REQUEST["BB"]),
          'IMT' => mysql_real_escape_string($_REQUEST["IMT"]),
          'TB' => mysql_real_escape_string($_REQUEST["TB"]),
          'tinggi_lutut' => mysql_real_escape_string($_REQUEST["TL"]),
          'LLA' => mysql_real_escape_string($_REQUEST["LLA"]),
          'data' => $str
	  ];

      $hasil = mysql_query("UPDATE rm_15_6_skrining_gizi_lanjut 
            SET
            id_kunjungan = '{$data['id_kunjungan']}',
            id_pelayanan = '{$data['id_pelayanan']}',
            id_user = '{$data['id_user']}',
            tgl_act = '{$data['tgl_act']}',
            BB = '{$data['BB']}',
            TB = '{$data['TB']}',
            IMT = '{$data['IMT']}',
            tinggi_lutut = '{$data['tinggi_lutut']}',
            LLA = '{$data['LLA']}',
			      data = '{$data['data']}'
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
		.inv{
			background-color: : transparent;
			outline-color: none;
			cursor: default;
			border: 0px;
			text-align: center;
		}
    td{
      padding:20px;
    }
	</style>
  <script src="../html2pdf/ppdf.js"></script>
  <script src="../html2pdf/pdf.js"></script>
</head>

<body id="pdf-area">

	<div style="padding:10px;">
		<div class="row" style="padding:20px">
			<div class="col-6 text-center"><br><br>
				<img src="../logors1.png">
			</div>
			<div class="col-6" style="padding:10px">
				<div style="float: right">RM 15.6 / PHCM</div>
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
		<br>
		<hr class="bg-dark" style="margin-top:-25px"><br>
		<div style="height:5px;background-color:black;width:100%;margin-bottom:50px;margin-top:-35px"></div>
		<center><h2>SKRINING GIZI LANJUT</h2></center><br>

        <table width="100%" border="1px">
            <tr>
              <td>
                Diagnosis Medis : <br>
                BB : <?=input($BB, "BB", "number", "", "");?> kg&emsp;
                TB : <?=input($TB, "TB", "number", "", "");?> cm&emsp;
                IMT : <?=input($IMT, "IMT", "number", "", "");?> kg/m²&emsp; <br><br>
                Tinggi Lutut : <?=input($TL, "TL", "number", "", "");?> cm&emsp;
                LLA : <?=input($LLA, "LLA", "number", "", "");?> cm&emsp;
              </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <td>
                <div class="row">
                  <div class="col-8">
                    1.&emsp;Skor IMT <br>
                    <div style="margin-left:50px">
                    <div class="row">
                      <?=radio1($arr_data[$i-1], "data_{$i}");$i++;?>
                    </div>
                    </div>
                  </div>
                  <div class="col-4 text-center">
                    Skor <br>
                    ( <span id="total1"></span> )
                  </div>
                </div><br><br>

                <div class="row">
                  <div class="col-8">
                    2.&emsp;Skor kehilangan BB yang tidak direncanakan 3-6 bulan terakhir <br>
                    <div style="margin-left:50px">
                    <div class="row">
                      <?=radio2($arr_data[$i-1], "data_{$i}");$i++;?>
                    </div>
                    </div>
                  </div>
                  <div class="col-4 text-center">
                    <br>
                    ( <span id="total2"></span> )
                  </div>
                </div><br><br>

                <div class="row">
                  <div class="col-8">
                    3.&emsp;Skor efek penyakit akut <br>
                    <div style="margin-left:50px">
                    <div class="row">
                    <?=radio3($arr_data[$i-1], "data_{$i}");$i++;?>
                    </div>
                    </div>
                  </div>
                </div><br><br>

                <div>Jumlah skor keseluruhan = <b><span id="total"></span></b></div><br>
                <div>Hasil</div>
                <div style="margin-left:50px">
                  0&emsp;: beresiko rendah; ulangi skrining setiap 7 hari <br>

                  1&emsp;: Resiko rendah ; monitoring asupan selama 3 hari. Jika ada peningkatan,   lanjutkan pengkajian dan ulangi skrining setiap 7 hari <br>

                  >2&nbsp;: 

                </div>

              </td>
            </tr>
        </table><br>

        <div>
          Tanggal  : <?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?> <br>
          Tanda tangan, <br><br><br><br>
          ( <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> ) <br><br>
          Dietisien/ahli gizi ruangan
        </div>

<input type="hidden" name="i" value="<?=$i;?>">

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
	
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>
	<script src="../../theme/bs/bootstrap.min.js"></script>
	<script>
	changed1();

    function changed1() {
    let checkboxes = document.querySelectorAll(".in1");
    let total = 0; let total1 = 0; let total2 = 0;

    for (var i = 0; i < checkboxes.length; i++) {
      if (checkboxes[i].checked) {
		  total += parseInt(checkboxes[i].value);
      
      }
    }
    if (checkboxes[0].checked) {
        total1 += parseInt(checkboxes[0].value);
      } else if (checkboxes[1].checked) {
        total1 += parseInt(checkboxes[1].value);
      } else if (checkboxes[2].checked) {
        total1 += parseInt(checkboxes[2].value);
      } 
      if (checkboxes[3].checked) {
        total2 += parseInt(checkboxes[3].value);
      } else if (checkboxes[4].checked) {
        total2 += parseInt(checkboxes[4].value);
      } else if (checkboxes[5].checked) {
        total2 += parseInt(checkboxes[5].value);
      }
		document.getElementById("total").innerHTML = total;
		document.getElementById("total1").innerHTML = total1;
		document.getElementById("total2").innerHTML = total2;
    }

    <?php if (isset($_REQUEST["pdf"])): ?>
        let identifier = '<?=$dataPasien['nama']?>';
         printPDF('RM 15.6 '+identifier);
    <?php endif; ?>
	</script>
</body>

</html>