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
        return "<input name='{$name}' class='{$class}' type='{$type}' />";
      } else {
        return "<input class='{$class}' name='{$name}' type='{$type}' value='{$data}' />";
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

  function radio($data, $name, $type, $class){

    if (isset($_REQUEST['id']) || isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])) {
        if ($data == "1") {
          return "<input type='radio' checked value='1' name='antro_6'>&nbsp;kurang =< 18.5,&emsp;&emsp;<input type='radio' value='2' name='antro_6'>&nbsp;normal&nbsp;=&nbsp;18,5-25<br>
                    <input type='radio' value='3' name='antro_6'>&nbsp;overweight&nbsp;=<&nbsp;25–27,&emsp;&emsp;<input type='radio' value='4' name='antro_6'>&nbsp;obesitas&nbsp;>=&nbsp;27";
        } elseif($data == "2") {
          return "<input type='radio' value='1' name='antro_6'>&nbsp;kurang =< 18.5,&emsp;&emsp;<input checked type='radio' value='2' name='antro_6'>&nbsp;normal&nbsp;=&nbsp;18,5-25<br>
                    <input type='radio' value='3' name='antro_6'>&nbsp;overweight&nbsp;=<&nbsp;25–27,&emsp;&emsp;<input type='radio' value='4' name='antro_6'>&nbsp;obesitas&nbsp;>=&nbsp;27";
        } elseif($data == "3") {
          return "<input type='radio' value='1' name='antro_6'>&nbsp;kurang =< 18.5,&emsp;&emsp;<input type='radio' value='2' name='antro_6'>&nbsp;normal&nbsp;=&nbsp;18,5-25<br>
                    <input checked type='radio' value='3' name='antro_6'>&nbsp;overweight&nbsp;=<&nbsp;25–27,&emsp;&emsp;<input type='radio' value='4' name='antro_6'>&nbsp;obesitas&nbsp;>=&nbsp;27";
        } else {
          return "<input type='radio' value='1' name='antro_6'>&nbsp;kurang =< 18.5,&emsp;&emsp;<input type='radio' value='2' name='antro_6'>&nbsp;normal&nbsp;=&nbsp;18,5-25<br>
                    <input type='radio' value='3' name='antro_6'>&nbsp;overweight&nbsp;=<&nbsp;25–27,&emsp;&emsp;<input checked type='radio' value='4' name='antro_6'>&nbsp;obesitas&nbsp;>=&nbsp;27";
        }
    } else {
      return "<input type='radio' value='1' name='antro_6'>&nbsp;kurang =< 18.5,&emsp;&emsp;<input type='radio' value='2' name='antro_6'>&nbsp;normal&nbsp;=&nbsp;18,5-25<br>
                    <input type='radio' value='3' name='antro_6'>&nbsp;overweight&nbsp;=<&nbsp;25–27,&emsp;&emsp;<input type='radio' value='4' name='antro_6'>&nbsp;obesitas&nbsp;>=&nbsp;27";
    }
    
  }

	if (isset($_REQUEST['cetak'])) {
		$print_mode = true;
		echo "<script>window.print();</script>";
		$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_15_asuhan_gizi_dewasa WHERE id = '{$_REQUEST['cetak']}'"));
		$arr_antro = []; $str_antro = "";
    $arr_gizi = []; $str_gizi = "";
		$antro_data = $data['antropometri'];
    $riwayat_gizi_b = $data['riwayat_gizi_b'];
		for ($q=0; $q < strlen($antro_data); $q++) { 

			if ($antro_data[$q] != "|") {
				$str_antro .= $antro_data[$q];
			} else {
				array_push($arr_antro, $str_antro);
				$str_antro = "";
			}
		}

    for ($s=0; $s < strlen($riwayat_gizi_b); $s++) { 


      if ($riwayat_gizi_b[$s] != "|") {
        $str_gizi .= $riwayat_gizi_b[$s];

      } else {
        array_push($arr_gizi, $str_gizi);
        $str_gizi = "";

      }

    }


  }
  
  if (isset($_REQUEST['pdf'])) {
    $print_mode = true;
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_15_asuhan_gizi_dewasa WHERE id = '{$_REQUEST['pdf']}'"));
    $arr_antro = [];
    $str_antro = "";
    $arr_gizi = [];
    $str_gizi = "";
    $antro_data = $data['antropometri'];
    $riwayat_gizi_b = $data['riwayat_gizi_b'];
    for ($q=0; $q < strlen($antro_data); $q++) {
        if ($antro_data[$q] != "|") {
            $str_antro .= $antro_data[$q];
        } else {
            array_push($arr_antro, $str_antro);
            $str_antro = "";
        }
    }

    for ($s=0; $s < strlen($riwayat_gizi_b); $s++) {
        if ($riwayat_gizi_b[$s] != "|") {
            $str_gizi .= $riwayat_gizi_b[$s];
        } else {
            array_push($arr_gizi, $str_gizi);
            $str_gizi = "";
        }
    }
}


	if (isset($_REQUEST['id'])) {
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_15_asuhan_gizi_dewasa WHERE id = '{$_REQUEST['id']}'"));
    $arr_antro = []; $str_antro = "";
    $arr_gizi = []; $str_gizi = "";
    $antro_data = $data['antropometri'];
    $riwayat_gizi_b = $data['riwayat_gizi_b'];

    for ($q=0; $q < strlen($antro_data); $q++) { 


      if ($antro_data[$q] != "|") {
        $str_antro .= $antro_data[$q];

      } else {
        array_push($arr_antro, $str_antro);
        $str_antro = "";

      }

    }

    for ($s=0; $s < strlen($riwayat_gizi_b); $s++) { 


      if ($riwayat_gizi_b[$s] != "|") {
        $str_gizi .= $riwayat_gizi_b[$s];

      } else {
        array_push($arr_gizi, $str_gizi);
        $str_gizi = "";

      }

    }

	}

	if (isset($_REQUEST['idx'])) {
		  date_default_timezone_set("Asia/Jakarta");
	    $id_kunj = (int)$_REQUEST["id_kunjungan"];
	    $sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$id_kunj'"));
	    $tgl_act = date('Y-m-d H:i:s');
      $str_antro = "";
      $str_riwayat_gizi_b = "";

    for ($i=1; $i < 7; $i++) { 

        $data = mysql_real_escape_string($_REQUEST["antro_{$i}"]);

        if ($data == "") {
            $str_antro .= "n";
            $str_antro .= "|";        
        } else {
            $str_antro .= $data;
            $str_antro .= "|";
        }
    }

    for ($a=1; $a < 17; $a++) { 

        $data = mysql_real_escape_string($_REQUEST["riwayat_gizi_b_{$a}"]);

        if ($data == "") {
            $str_riwayat_gizi_b .= "n";
            $str_riwayat_gizi_b .= "|";        
        } else {
            $str_riwayat_gizi_b .= $data;
            $str_riwayat_gizi_b .= "|";
        }
    }
	    $data = [
	        'id_kunjungan' => mysql_real_escape_string($_REQUEST['id_kunjungan']),
	        'id_pelayanan' => mysql_real_escape_string($_REQUEST['id_pelayanan']),
	        'tgl_act' => date('Y-m-d H:i:s'),
          'id_user' => mysql_real_escape_string($_REQUEST["id_user"]),
          'nama_ahli' => mysql_real_escape_string($_REQUEST["nama_ahli"]),
          'tgl' => mysql_real_escape_string($_REQUEST["tgl"]),
          'diagnosa_medis' => mysql_real_escape_string($_REQUEST["diagnosa"]),
          'antropometri' => $str_antro,
          'biokimia' => mysql_real_escape_string($_REQUEST["biokimia"]),
          'klinis' => mysql_real_escape_string($_REQUEST["klinis"]),
          'riwayat_gizi_a' => mysql_real_escape_string($_REQUEST["riwayat_gizi_a"]),
          'riwayat_gizi_b' => $str_riwayat_gizi_b,
          'riwayat_personil' => mysql_real_escape_string($_REQUEST["riwayat_personil"]),
          'diagnosis_masalah' => mysql_real_escape_string($_REQUEST["diagnosis_masalah"]),
          'intervensi_gizi' => mysql_real_escape_string($_REQUEST["intervensi_gizi"]),
          'evaluasi' => mysql_real_escape_string($_REQUEST["evaluasi"])
	    ];

	    mysql_query("UPDATE rm_15_asuhan_gizi_dewasa 
	    			SET
            id_pasien = '{$dataPasien['id']}',
			    	id_kunjungan = '{$data['id_kunjungan']}',
			    	id_pelayanan = '{$data['id_pelayanan']}',
            tgl_act = '{$data['tgl_act']}',
			    	id_user = '{$data['id_user']}',
            nama_ahli = '{$data['nama_ahli']}',
            tgl = '{$data['tgl']}',
            diagnosa_medis = '{$data['diagnosa_medis']}',
            antropometri = '{$data['antropometri']}',
            biokimia = '{$data['biokimia']}',
            klinis = '{$data['klinis']}',
            riwayat_gizi_a = '{$data['riwayat_gizi_a']}',
            riwayat_gizi_b = '{$data['riwayat_gizi_b']}',
            riwayat_personil = '{$data['riwayat_personil']}',
            diagnosis_masalah = '{$data['diagnosis_masalah']}',
            intervensi_gizi = '{$data['intervensi_gizi']}',
            evaluasi = '{$data['evaluasi']}'
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
</head>

<body id="pdf-area">
	<div class="container bg-white" style="padding: 10px">
		<div class="row">

				<div class="col-6 text-center"><br><br><br><br>
				<img src="../logors1.png">
			</div>
			<div class="col-6" style="padding:40px">
				<div style="float: right">RM 15 / PHCM</div>
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
		<h4 class="text-center">ASUHAN GIZI DEWASA
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
        <td class="text-left"><b>A. Antropometri :</b></td>
      </tr>
      <tr>
        <td>
          <div class="row">
            <div class="col-6">
              <table class="text-left">
                <tr>
                  <td>BB</td>
                  <td>:</td>
                  <td><?= input($arr_antro[0], "antro_1", "text", ""); ?> kg</td>
                </tr>
                <tr>
                  <td>TB</td>
                  <td>:</td>
                  <td><?= input($arr_antro[1], "antro_2", "text", ""); ?> cm</td>
                </tr>
                <tr>
                  <td>LLA</td>
                  <td>:</td>
                  <td><?= input($arr_antro[2], "antro_3", "text", ""); ?> cm</td>
                </tr>
                <tr>
                  <td>Tinggi Lutut</td>
                  <td>:</td>
                  <td><?= input($arr_antro[3], "antro_4", "text", ""); ?> cm</td>
                </tr>
              </table>
            </div>
            <div class="col-6">
              <table class="text-left">
                <tr>
                  <td colspan="4">Indeks Massa Tubuh = BB dalam kg dibagi (TB dalam meter)²</td>
                </tr>
                <tr>
                  <td>IMT</td>
                  <td>:</td>
                  <td><?= input($arr_antro[4], "antro_5", "text", ""); ?> kg/m²</td>
                </tr>
                <tr>
                  <td>IMT</td>
                  <td>:</td>
                  <td>
                    <?= radio($arr_antro[5], "", "", ""); ?>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td class="text-left"><b>B. Biokimia :</b></td>
      </tr>
      <tr>
        <td><?= area($data["biokimia"], "biokimia", ""); ?></td>
      </tr>
      <tr>
        <td class="text-left"><b>C. Klinis/Fisik :</b></td>
      </tr>
      <tr>
        <td><?= area($data["klinis"], "klinis", ""); ?></td>
      </tr>
      <tr>
        <td class="text-left"><b>D. Riwayat Gizi  :</b></td>
      </tr>
      <tr>
        <td><?= area($data["riwayat_gizi_a"], "riwayat_gizi_a", ""); ?></td>
      </tr>
      <tr>
        <td>
          <table border="1px" style="width: 100%" class="text-center" >
            <tr>
              <td rowspan="2">qZat Gizi</td>
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
              <td><?= input($arr_gizi[0], "riwayat_gizi_b_1", "text", ""); ?></td>
              <td><?= input($arr_gizi[1], "riwayat_gizi_b_2", "text", ""); ?></td>
              <td><?= input($arr_gizi[2], "riwayat_gizi_b_3", "text", ""); ?></td>
              <td><?= input($arr_gizi[3], "riwayat_gizi_b_4", "text", ""); ?></td>
            </tr>
            <tr>
              <td>Protein (gram)</td>
              <td><?= input($arr_gizi[4], "riwayat_gizi_b_5", "text", ""); ?></td>
              <td><?= input($arr_gizi[5], "riwayat_gizi_b_6", "text", ""); ?></td>
              <td><?= input($arr_gizi[6], "riwayat_gizi_b_7", "text", ""); ?></td>
              <td><?= input($arr_gizi[7], "riwayat_gizi_b_8", "text", ""); ?></td>
            </tr>
            <tr>
              <td>Lemak (gram)</td>
              <td><?= input($arr_gizi[8], "riwayat_gizi_b_9", "text", ""); ?></td>
              <td><?= input($arr_gizi[9], "riwayat_gizi_b_10", "text", ""); ?></td>
              <td><?= input($arr_gizi[10], "riwayat_gizi_b_11", "text", ""); ?></td>
              <td><?= input($arr_gizi[11], "riwayat_gizi_b_12", "text", ""); ?></td>
            </tr>
            <tr>
              <td>Karbohidrat (gram)</td> 
              <td><?= input($arr_gizi[12], "riwayat_gizi_b_13", "text", ""); ?></td>
              <td><?= input($arr_gizi[13], "riwayat_gizi_b_14", "text", ""); ?></td>
              <td><?= input($arr_gizi[14], "riwayat_gizi_b_15", "text", ""); ?></td>
              <td><?= input($arr_gizi[15], "riwayat_gizi_b_16", "text", ""); ?></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td class="text-left">
          <b>E. Riwayat Personil</b><br>
          <?= area($data["riwayat_personil"], "riwayat_personil", ""); ?>
        </td>
      </tr>
    </table>
<br><br><br>

<br><br>

<br>

		</div>
	</div><br><br>
	
<div class="container bg-white" style="padding: 10px">

  <table style="width:100%" class="text-center" border="1">
    <tr>
      <td><b>II. DIAGNOSIS GIZI / MASALAH</b></td>
    </tr>
    <tr>
      <td><?= area($data["diagnosis_masalah"], "diagnosis_masalah", ""); ?></td>
    </tr>
    <tr>
      <td><b>III. INTERVENSI GIZI</b></td>
    </tr>
    <tr>
      <td><?= area($data["intervensi_gizi"], "intervensi_gizi", ""); ?></td>
    </tr>
    <tr>
      <td><b>IV. MONITORING DAN EVALUASI</b></td>
    </tr>
    <tr>
      <td><?= area($data["evaluasi"], "evaluasi", ""); ?></td>
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
<br><br>

  </div>

  <script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
  <script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>
  <script src="../../theme/bs/bootstrap.min.js"></script>
  <script>
    <?php if(isset($_REQUEST["pdf"])): ?>
      let identifier = '<?=$dataPasien['nama']?>';
      printPDF('RM 15 '+identifier);
    <?php endif; ?>
  </script>
</body>

</html>