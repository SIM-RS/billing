<?php
	use yii\helpers\Html;
	include '../function/form.php';
	include '../../koneksi/konek.php';
	$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
  $no = 1; $i = 1;

  function area($data, $name, $class){

    if (isset($_REQUEST['id'])) {

      if ($data == "" || $data == "n") {
        return "<textarea class='form-control {$class}' name='{$name}'></textarea>";
      } else {
        return "<textarea class='form-control {$class}' name='{$name}'>{$data}</textarea>";
      }

    } elseif(isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])) {
      if ($data == "" || $data == "n") {
        return "";
      } else {
        return $data;
      }
    } else {
      return "<textarea class='form-control {$class}' name='{$name}'></textarea>";
    }
    
  }
  
  function input($data, $name, $type, $class){

    if (isset($_REQUEST['id'])) {

      if ($data == "" || $data == "n") {
        return "<input required='' name='{$name}' class='{$class}' type='{$type}' />";
      } else {
        return "<input required='' class='{$class}' name='{$name}' type='{$type}' value='{$data}' />";
      }

    } elseif(isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])) {
      if ($data == "" || $data == "n") {
        return "";
      } else {
        return $data;
      }
    } else {
      return "<input class='{$class}' name='{$name}' type='{$type}'/>";
    }
    
  }

	if (isset($_REQUEST['cetak'])) {
		$print_mode = true;
		echo "<script>window.print();</script>";
		$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_15_1_asuhan_gizi_anak WHERE id = '{$_REQUEST['cetak']}'"));
    $str_antro = ""; $data_antro = $data['antropometri']; $arr_antro = [];
    $str_gizi = ""; $data_gizi = $data['asesmen_gizi_ket']; $arr_gizi = [];
    $str_asupan = ""; $data_asupan = $data['asupan']; $arr_gizi_b = [];
    $str_slide = ""; $data_slide_2 = $data['slide_2_datas']; $arr_2 = [];

     for ($e=0; $e < strlen($data_antro); $e++) { 
      $myData = $data_antro[$e];
      if ($myData != "|") {
        $str_antro .= $myData;   
      } else {
        array_push($arr_antro, $str_antro);
        $str_antro = "";
      }
     }

     for ($r=0; $r < strlen($data_gizi); $r++) { 
      $myData = $data_gizi[$r];
      if ($myData != "|") {
        $str_gizi .= $myData;   
      } else {
        array_push($arr_gizi, $str_gizi);
        $str_gizi = "";
      }
     }

     for ($t=0; $t < strlen($data_slide_2); $t++) { 
      $myData = $data_slide_2[$t];
      if ($myData != "|") {
        $str_slide .= $myData;   
      } else {
        array_push($arr_2, $str_slide);
        $str_slide = "";
      }
     }

     for ($y=0; $y < strlen($data_asupan); $y++) { 
      $myData = $data_asupan[$y];
      if ($myData != "|") {
        $str_asupan .= $myData;   
      } else {
        array_push($arr_gizi_b, $str_asupan);
        $str_asupan = "";
      }
     }


  }
  
  if (isset($_REQUEST['pdf'])) {
    $print_mode = true;
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_15_1_asuhan_gizi_anak WHERE id = '{$_REQUEST['pdf']}'"));
    $str_antro = "";
    $data_antro = $data['antropometri'];
    $arr_antro = [];
    $str_gizi = "";
    $data_gizi = $data['asesmen_gizi_ket'];
    $arr_gizi = [];
    $str_asupan = "";
    $data_asupan = $data['asupan'];
    $arr_gizi_b = [];
    $str_slide = "";
    $data_slide_2 = $data['slide_2_datas'];
    $arr_2 = [];

    for ($e=0; $e < strlen($data_antro); $e++) {
        $myData = $data_antro[$e];
        if ($myData != "|") {
            $str_antro .= $myData;
        } else {
            array_push($arr_antro, $str_antro);
            $str_antro = "";
        }
    }

    for ($r=0; $r < strlen($data_gizi); $r++) {
        $myData = $data_gizi[$r];
        if ($myData != "|") {
            $str_gizi .= $myData;
        } else {
            array_push($arr_gizi, $str_gizi);
            $str_gizi = "";
        }
    }

    for ($t=0; $t < strlen($data_slide_2); $t++) {
        $myData = $data_slide_2[$t];
        if ($myData != "|") {
            $str_slide .= $myData;
        } else {
            array_push($arr_2, $str_slide);
            $str_slide = "";
        }
    }

    for ($y=0; $y < strlen($data_asupan); $y++) {
        $myData = $data_asupan[$y];
        if ($myData != "|") {
            $str_asupan .= $myData;
        } else {
            array_push($arr_gizi_b, $str_asupan);
            $str_asupan = "";
        }
    }
}


	if (isset($_REQUEST['id'])) {
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_15_1_asuhan_gizi_anak WHERE id = '{$_REQUEST['id']}'"));
    $str_antro = ""; $data_antro = $data['antropometri']; $arr_antro = [];
    $str_gizi = ""; $data_gizi = $data['asesmen_gizi_ket']; $arr_gizi = [];
    $str_asupan = ""; $data_asupan = $data['asupan']; $arr_gizi_b = [];
    $str_slide = ""; $data_slide_2 = $data['slide_2_datas']; $arr_2 = [];

     for ($e=0; $e < strlen($data_antro); $e++) { 
      $myData = $data_antro[$e];
      if ($myData != "|") {
        $str_antro .= $myData;   
      } else {
        array_push($arr_antro, $str_antro);
        $str_antro = "";
      }
     }

     for ($r=0; $r < strlen($data_gizi); $r++) { 
      $myData = $data_gizi[$r];
      if ($myData != "|") {
        $str_gizi .= $myData;   
      } else {
        array_push($arr_gizi, $str_gizi);
        $str_gizi = "";
      }
     }

     for ($t=0; $t < strlen($data_slide_2); $t++) { 
      $myData = $data_slide_2[$t];
      if ($myData != "|") {
        $str_slide .= $myData;   
      } else {
        array_push($arr_2, $str_slide);
        $str_slide = "";
      }
     }

     for ($y=0; $y < strlen($data_asupan); $y++) { 
      $myData = $data_asupan[$y];
      if ($myData != "|") {
        $str_asupan .= $myData;   
      } else {
        array_push($arr_gizi_b, $str_asupan);
        $str_asupan = "";
      }
     }

  }

	if (isset($_REQUEST['idx'])) {
		  date_default_timezone_set("Asia/Jakarta");
	    $id_kunj = (int)$_REQUEST["id_kunjungan"];
	    $sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$id_kunj'"));
	    $tgl_act = date('Y-m-d H:i:s');
      $str_antro = ""; $str_gizi_ket = ""; $str_asupan = ""; $str_2 = "";

      for ($i=1; $i < 12; $i++) { 
          $myData = mysql_real_escape_string($_REQUEST["antro_{$i}"]);
          $str_antro .= $myData;
          $str_antro .= "|";
      }

      for ($j=1; $j < 5; $j++) { 
          $myData = mysql_real_escape_string($_REQUEST["gizi_{$j}"]);
          $str_gizi_ket .= $myData;
          $str_gizi_ket .= "|";
      }

      for ($k=1; $k < 17; $k++) { 
          $myData = mysql_real_escape_string($_REQUEST["riwayat_gizi_b_{$k}"]);
          if ($myData == "") {
              $str_asupan .= "n";
              $str_asupan .= "|";  
          } else {
              $str_asupan .= $myData;
              $str_asupan .= "|";    
          }
          
      }

      for ($l=1; $l < 4; $l++) { 
          $myData = mysql_real_escape_string($_REQUEST["slide_{$l}"]);
          if ($myData == "") {
              $str_2 .= "n";
              $str_2 .= "|";  
          } else {
              $str_2 .= $myData;
              $str_2 .= "|";    
          }
      }

	    $data = [
        'id_pasien' => $sql['pasien_id'],
        'id_kunjungan' => mysql_real_escape_string($_REQUEST['id_kunjungan']),
        'id_pelayanan' => mysql_real_escape_string($_REQUEST['id_pelayanan']),
        'tgl_act' => date('Y-m-d H:i:s'),
        'id_user' => mysql_real_escape_string($_REQUEST["id_user"]),
        'tgl' => mysql_real_escape_string($_REQUEST["tgl"]),
        'diagnosa_medis' => mysql_real_escape_string($_REQUEST["diagnosa"]),
        'antropometri' => $str_antro,
        'asesmen_gizi_ket' => $str_gizi_ket,
        'asupan' => $str_asupan,
        'slide_2_datas' => $str_2,
        'nama_ahli' => mysql_real_escape_string($_REQUEST["nama_ahli"])
    ];

	    mysql_query("UPDATE rm_15_1_asuhan_gizi_anak 
	    			SET
            id_pasien = '{$dataPasien['id']}',
			    	id_kunjungan = '{$data['id_kunjungan']}',
			    	id_pelayanan = '{$data['id_pelayanan']}',
            tgl_act = '{$data['tgl_act']}',
			    	id_user = '{$data['id_user']}',
            tgl = '{$data['tgl']}',
            diagnosa_medis = '{$data['diagnosa_medis']}',
            antropometri = '{$data['antropometri']}',
            asesmen_gizi_ket = '{$data['asesmen_gizi_ket']}',
            asupan = '{$data['asupan']}',
            slide_2_datas = '{$data['slide_2_datas']}',
            nama_ahli = '{$data['nama_ahli']}'
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
      cursor :default;
    }
	</style>
  <script src="../html2pdf/ppdf.js"></script>
  <script src="../html2pdf/pdf.js"></script>
</head>

<body id="pdf-area">
	<div class="container bg-white" style="padding: 10px">
		<div class="row">

				<div class="col-6 text-center"><br><br><br><br>
				<img src="../logors1.png">
			</div>
			<div class="col-6" style="padding:40px">
				<div style="float: right">RM 15.1 / PHCM</div>
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
		<h4 class="text-center">ASUHAN GIZI ANAK
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
      <tr>
        <td class="text-left">Tanggal : <?= input($data['tgl'], "tgl", "date", ""); ?><br>
          <br>Diagnosa Medis : <?= input($data['diagnosa_medis'], "diagnosa", "text", "w-50"); ?>
        </td>
      </tr>
      <tr>
        <td class="text-center"><b>I. ASESMEN GIZI</b></td>
      </tr>
      <tr>
        <td>
          <table border="1" style="width: 100%">
            <tr>
              <th class="text-left">A. Antropometri</th>
              <th>Persentase berdasarkan grafik</th>
            </tr>
            <tr class="text-left">
              <td>
                <div class="row">
                  <div class="col-5">
                    BB : <?= input($arr_antro[0], "antro_1", "text", ""); ?>gram <br><br>
                    TB : <?= input($arr_antro[1], "antro_2", "text", ""); ?>cm <br><br>
                    LLA : <?= input($arr_antro[2], "antro_3", "text", ""); ?>cm <br><br>
                    LK : <?= input($arr_antro[3], "antro_4", "text", ""); ?>cm <br><br>
                    BB ideal : <?= input($arr_antro[4], "antro_5", "text", ""); ?>gram <br>
                  </div>
                  <div class="col-7">
                    &emsp;BB / U : ( BB dalam kg, Umur dalam bulan )<br><br>
                  &emsp;TB / U  :  ( TB dalam cm, Umur dalam bulan )<br><br>
                  &emsp;BB/TB :  ( BB dalam kg,  TB dalam cm )<br><br>
                  &emsp;LLA/U :  ( LLA dalam cm, Umur dalam bulan <br><br>
                  &emsp;HA : (Hasil Akhir) <?= input($arr_antro[5], "antro_6", "text", ""); ?> th <?= input($arr_antro[6], "antro_7", "text", ""); ?> bln
                  </div>
                </div>
              </td>
              <td>
                <?= input($arr_antro[7], "antro_8", "text", ""); ?>%<br><br>
                <?= input($arr_antro[8], "antro_9", "text", ""); ?>%<br><br>
                <?= input($arr_antro[9], "antro_10", "text", ""); ?>%<br><br>
                <?= input($arr_antro[10], "antro_11", "text", ""); ?>%<br><br>
                Dilihat dari grafik
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td class="text-left"><b>B. Biokimia :</b></td>
      </tr>
      <tr>
        <td><?= area($arr_gizi[0], "gizi_1", ""); ?></td>
      </tr>
      <tr>
        <td class="text-left"><b>C. Klinis/Fisik :</b></td>
      </tr>
      <tr>
        <td><?= area($arr_gizi[1], "gizi_2", ""); ?></td>
      </tr>
      <tr>
        <td class="text-left"><b>D. Riwayat Gizi  :</b></td>
      </tr>
      <tr>
        <td><?= area($arr_gizi[2], "gizi_3", ""); ?></td>
      </tr>
      <tr>
        <td>
          <table border="1px" style="width: 100%" class="text-center" >
            <tr>
              <td rowspan="2">Zat Gizi</td>
              <td colspan="3">Total Asupan</td>
              <td rowspan="2">Perhitungan Kebutuhan :</td>
            </tr>
            <tr>
              <td>SMRS</td>
              <td>Kebutuhan</td>
              <td>%</td>
            </tr>
            <tr>
              <td>Energi (kkal)</td>
              <td><?= input($arr_gizi_b[0], "riwayat_gizi_b_1", "text", ""); ?></td>
              <td><?= input($arr_gizi_b[1], "riwayat_gizi_b_2", "text", ""); ?></td>
              <td><?= input($arr_gizi_b[2], "riwayat_gizi_b_3", "text", ""); ?></td>
              <td><?= input($arr_gizi_b[3], "riwayat_gizi_b_4", "text", ""); ?></td>
            </tr>
            <tr>
              <td>Protein (gram)</td>
              <td><?= input($arr_gizi_b[4], "riwayat_gizi_b_5", "text", ""); ?></td>
              <td><?= input($arr_gizi_b[5], "riwayat_gizi_b_6", "text", ""); ?></td>
              <td><?= input($arr_gizi_b[6], "riwayat_gizi_b_7", "text", ""); ?></td>
              <td><?= input($arr_gizi_b[7], "riwayat_gizi_b_8", "text", ""); ?></td>
            </tr>
            <tr>
              <td>Lemak (gram)</td>
              <td><?= input($arr_gizi_b[8], "riwayat_gizi_b_9", "text", ""); ?></td>
              <td><?= input($arr_gizi_b[9], "riwayat_gizi_b_10", "text", ""); ?></td>
              <td><?= input($arr_gizi_b[10], "riwayat_gizi_b_11", "text", ""); ?></td>
              <td><?= input($arr_gizi_b[11], "riwayat_gizi_b_12", "text", ""); ?></td>
            </tr>
            <tr>
              <td>Karbohidrat (gram)</td> 
              <td><?= input($arr_gizi_b[12], "riwayat_gizi_b_13", "text", ""); ?></td>
              <td><?= input($arr_gizi_b[13], "riwayat_gizi_b_14", "text", ""); ?></td>
              <td><?= input($arr_gizi_b[14], "riwayat_gizi_b_15", "text", ""); ?></td>
              <td><?= input($arr_gizi_b[15], "riwayat_gizi_b_16", "text", ""); ?></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td class="text-left">
          <b>E. Riwayat Personil</b><br>
          <?= area($arr_gizi[3], "gizi_4", ""); ?>
        </td>
      </tr>
    </table>
<br><br><br>


<br>

		</div>
	</div><br><br>
	
<div class="container bg-white" style="padding: 10px">

  <table style="width:100%" class="text-center" border="1">
    <tr>
      <td><b>II. DIAGNOSIS GIZI / MASALAH</b></td>
    </tr>
    <tr>
      <td><?= area($arr_2[0], "slide_1", ""); ?></td>
    </tr>
    <tr>
      <td><b>III. INTERVENSI GIZI</b></td>
    </tr>
    <tr>
      <td><?= area($arr_2[1], "slide_2", ""); ?></td>
    </tr>
    <tr>
      <td><b>IV. MONITORING DAN EVALUASI</b></td>
    </tr>
    <tr>
      <td><?= area($arr_2[2], "slide_3", ""); ?></td>
    </tr>
    <tr>
      <td class="text-left">
        Tanda Tangan dan Nama Jelas Ahli Gizi <br><br><br><br>
        (&nbsp;<?= input($data["nama_ahli"], "nama_ahli", "", ""); ?>&nbsp;)
      </td>
    </tr>
  </table><br><br>

  <?php if(isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])): ?>
  &nbsp;
<?php elseif(isset($_REQUEST['id'])): ?>
  <button type="submit" class="btn btn-primary">Ganti</button>
  </form>
<?php else:?>
  <button type="submit" class="btn btn-success">Simpan</button>
  </form>
<?php endif; ?>

<br><br>

  </div>

  <script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
  <script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>
  <script src="../../theme/bs/bootstrap.min.js"></script>
  <script>
    <?php if (isset($_REQUEST["pdf"])): ?>
      let identifier = '<?=$dataPasien['nama']?>';
      printPDF('RM 15.1 '+identifier);
    <?php endif; ?>
  </script>
</body>

</html>