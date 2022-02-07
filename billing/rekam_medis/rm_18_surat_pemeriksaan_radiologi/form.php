<?php
	use yii\helpers\Html;
	include '../function/form.php';
	include '../../koneksi/konek.php';
	$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
  $i = 1;

    function checked($data) {
      if (isset($_REQUEST['cetak']) || isset($_REQUEST['pdf']) || isset($_REQUEST['id'])) {
        if ($data != "n") {
          return "checked";
        }
      }
    }

    function checkInput($data, $name, $class) {

      if (isset($_REQUEST['id']) || isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])) {

        if ($data == "" || $data == "0") {
          return "<input class='{$class}' name='{$name}' value='1' type='checkbox'>";
        } else {
          return "<input class='{$class}' type='checkbox' value='1' name='{$name}' checked>";
        }

    } else {
      return "<input class='{$class}' name='{$name}' value='1' type='checkbox'>";
    }

  }

  function area($data, $name, $class){

    if (isset($_REQUEST['id'])) {

      if ($data == "" || $data == "0") {
        return "<textarea class='form-control {$class}' name='{$name}'></textarea>";
      } else {
        return "<textarea class='form-control {$class}' name='{$name}'>{$data}</textarea>";
      }

    } elseif(isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])) {
      if ($data == "" || $data == "0") {
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

      if ($data == "" || $data == "0") {
        return "<input name='{$name}' class='{$class}' type='{$type}' />";
      } else {
        return "<input class='{$class}' name='{$name}' type='{$type}' value='{$data}' />";
      }

    } elseif(isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])) {
      if ($data == "" || $data == "0") {
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
		$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_18_pemeriksaan_radiologi WHERE id = '{$_REQUEST['cetak']}'"));
    $dataSlide1 = $data['slide_1']; $arr_slide_1 = []; $str_1 = "";
    $dataSlide2 = $data['slide_2']; $arr_slide_2 = []; $str_2 = "";
    for ($z=0; $z < strlen($dataSlide1); $z++) { 
      if ($dataSlide1[$z] != "|") {
        $str_1 .= $dataSlide1[$z];
      } else {
        array_push($arr_slide_1, $str_1);
        $str_1 = "";
      }
    }

    for ($y=0; $y < strlen($dataSlide2); $y++) { 
      if ($dataSlide2[$y] != "|") {
        $str_2 .= $dataSlide2[$y];
      } else {
        array_push($arr_slide_2, $str_2);
        $str_2 = "";
      }
    }

  }
  
  if (isset($_REQUEST['pdf'])) {
		$print_mode = true;
		$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_18_pemeriksaan_radiologi WHERE id = '{$_REQUEST['pdf']}'"));
    $dataSlide1 = $data['slide_1']; $arr_slide_1 = []; $str_1 = "";
    $dataSlide2 = $data['slide_2']; $arr_slide_2 = []; $str_2 = "";
    for ($z=0; $z < strlen($dataSlide1); $z++) { 
      if ($dataSlide1[$z] != "|") {
        $str_1 .= $dataSlide1[$z];
      } else {
        array_push($arr_slide_1, $str_1);
        $str_1 = "";
      }
    }

    for ($y=0; $y < strlen($dataSlide2); $y++) { 
      if ($dataSlide2[$y] != "|") {
        $str_2 .= $dataSlide2[$y];
      } else {
        array_push($arr_slide_2, $str_2);
        $str_2 = "";
      }
    }

	}

	if (isset($_REQUEST['id'])) {
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_18_pemeriksaan_radiologi WHERE id = '{$_REQUEST['id']}'"));
    $dataSlide1 = $data['slide_1']; $arr_slide_1 = []; $str_1 = "";
    $dataSlide2 = $data['slide_2']; $arr_slide_2 = []; $str_2 = "";
    for ($z=0; $z < strlen($dataSlide1); $z++) { 
      if ($dataSlide1[$z] != "|") {
        $str_1 .= $dataSlide1[$z];
      } else {
        array_push($arr_slide_1, $str_1);
        $str_1 = "";
      }
    }

    for ($y=0; $y < strlen($dataSlide2); $y++) { 
      if ($dataSlide2[$y] != "|") {
        $str_2 .= $dataSlide2[$y];
      } else {
        array_push($arr_slide_2, $str_2);
        $str_2 = "";
      }
    }

	}

	if (isset($_REQUEST['idx'])) {
		  date_default_timezone_set("Asia/Jakarta");
	    $id_kunj = (int)$_REQUEST["id_kunjungan"];
	    $sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$id_kunj'"));
	    $tgl_act = date('Y-m-d H:i:s');
      $str_slide_1 = "";
      $count_2 = $_REQUEST['count_slide_2']; $str_slide_2 = "";

      for ($o=1; $o < 11; $o++) { 
          $myData = $_REQUEST["slide_{$o}"];

          if ($myData == "") {
              $str_slide_1 .= "0";
              $str_slide_1 .= "|";
          } else {
              $str_slide_1 .= $myData;
              $str_slide_1 .= "|";
          }
      }

      for ($i=1; $i < $count_2; $i++) { 
          $myData = $_REQUEST["slide_2_{$i}"];

          if ($myData == "") {
              $str_slide_2 .= "0";
              $str_slide_2 .= "|";
          } else {
              $str_slide_2 .= $myData;
              $str_slide_2 .= "|";
          }
      }

      $data = [
        'id_pasien' => $sql['pasien_id'],
        'id_kunjungan' => mysql_real_escape_string($_REQUEST['id_kunjungan']),
        'id_pelayanan' => mysql_real_escape_string($_REQUEST['id_pelayanan']),
        'tgl_act' => date('Y-m-d H:i:s'),
        'id_user' => mysql_real_escape_string($_REQUEST["id_user"]),
        'slide_1' => $str_slide_1,
        'slide_2' => $str_slide_2
      ];

	    mysql_query("UPDATE rm_18_pemeriksaan_radiologi 
	    			SET
            id_pasien = '{$data['id_pasien']}',
			    	id_kunjungan = '{$data['id_kunjungan']}',
			    	id_pelayanan = '{$data['id_pelayanan']}',
            tgl_act = '{$data['tgl_act']}',
			    	id_user = '{$data['id_user']}',
            slide_1 = '{$data['slide_1']}',
            slide_2 = '{$data['slide_2']}'
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
				<div style="float: right">RM 18 / PHCM</div>
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
		<h4 class="text-center">HASIL PEMERIKSAAN RADIOLOGI
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
		
  <table>
    <tr>
      <td>NAMA</td>
      <td>:</td>
      <td><?= input($arr_slide_1[0], "slide_1", "text", ""); ?></td>
    </tr>
    <tr>
      <td>No.RM</td>
      <td>:</td>
      <td><?= input($arr_slide_1[1], "slide_2", "text", ""); ?></td>
    </tr>
    <tr>
      <td>UMUR/ KELAMIN</td>
      <td>:</td>
      <td><?= input($arr_slide_1[2], "slide_3", "text", ""); ?> Thn / <?= input($arr_slide_1[3], "slide_4", "text", ""); ?></td>
    </tr>
    <tr>
      <td>BAGIAN</td>
      <td>:</td>
      <td><?= input($arr_slide_1[4], "slide_5", "text", ""); ?></td>
    </tr>
    <tr>
      <td>PEMERIKSAAN</td>
      <td>:</td>
      <td><?= input($arr_slide_1[5], "slide_6", "text", ""); ?></td>
    </tr>
    <tr>
      <td>TGL PEMERIKSAAN</td>
      <td>:</td>
      <td><?= input($arr_slide_1[6], "slide_7", "text", ""); ?></td>
    </tr>
    <tr>
      <td>TS. YTH</td>
      <td>:</td>
      <td>Dr. <?= input($arr_slide_1[7], "slide_8", "text", ""); ?></td>
    </tr>
    <tr>
      <td><b>Hasil Pemeriksaan :</b></td>
    </tr>
    <tr>
      <td colspan="3"><?= area($arr_slide_1[8], "slide_9", "form-control"); ?></td>
    </tr>
    <tr>
      <td><b>Kesan :</b></td>
    </tr>
    <tr>
      <td colspan="3"><?= area($arr_slide_1[9], "slide_10", "form-control"); ?></td>
    </tr>
  </table><br><br>
  <div class="container">Belawan, <br>
      Salam Sejawat <br><br><br><br><br>
Dr. RAHMAWAN B.SpRad <br>
AHLI RADIOLOGI
</div>

<br><br>
<div style="text-align: right"><img style="width: 350px" class="text-right" src="../../images/alamat.jpg"></div>

  </div>
  <br><br><br>

<div class="container bg-white" style="padding: 10px">
    <div class="row">

        <div class="col-6 text-center"><br><br><br><br>
        <img src="../logors1.png">
      </div>
      <div class="col-6" style="padding:40px">
        <div style="float: right">RM 18 / PHCM</div>
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
    <h4 class="text-center">SURAT PERMINTAAN PEMERIKSAAN RADIOLOGI
</h4><br>
<div class="container"><b>Kepada Yth. Dokter Spesialis Radiologi, <br>
Mohon Pemeriksaan Radiologi 
</b></div><br>
  
<div class="container">
  <table border="1" style="width: 100%" class="text-center">
  <tr>
    <th>Klinis</th>
    <td><?= input($arr_slide_2[$i-1], "slide_2_{$i}", "text", "form-control"); $i++;?></td>
  </tr>
  <tr>
    <th>Diagnosa</th>
    <td><?= input($arr_slide_2[$i-1], "slide_2_{$i}", "text", "form-control"); $i++;?></td>
  </tr>
</table>
</div>

<br><br>
<div class="container row">
  
  <div class="col-6">
    <b>1. KEPALA</b><br>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;SCEDELL AP/ Lat</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;AP/Lat</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Nasal Bone</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Bilateral</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Mandibula Cercvical</div><br>

   <b>2. THORAX</b><br>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Thorax AP / PA</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Thorax AP / Lat</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Thoracal AP / Lat</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Clavicula</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Clavicula Bilateral</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Lumbascaral</div><br>

   <b>3. ABDOMEN</b><br>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;BNO (denganpersiapan)</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Abdomen Polos</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Abdomen 3 posisi</div><br>

   <b>4. EXTREMITAS ATAS</b><br>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Manus AP / Obliq Art</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Manus Bilateral</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Bone Age</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Wrist Joint AP/ Lat</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Wrist Joint Bilateral Antebrachii AP / Lat</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Antebrachii Bilateral</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Elbow Joint AP / Lat</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Humerus AP / Lat</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Shoulder Joint</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Shoulder Joint Bilateral</div><br>

  </div>

  <div class="col-6">
    <b>5. EKSTREMITAS BAWAH</b><br>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;PedisAp / Obliq</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Pedis Bilateral</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Calcaneus Axial / Lat</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Ankle Joint AP/ Lat</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Ankle Joint Bilateral</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Cruris AP / Lat</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Cruris Bilateral</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Genu Bilateral</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Femur AP/ Lat</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Femur Bilateral</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Pelvic</div><br>

   <b>6. PEMERIKSAAN KHUSUS</b><br>      
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;BNO-IVP</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;CT Scan</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Endoscopy</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;Colonoscopy</div>
   <div><?=checkInput($arr_slide_2[$i-1], "slide_2_{$i}", ""); $i++;?>&nbsp;EEG</div>

  </div><br>

</div>

<div class="text-right">
    Belawan,&nbsp;<?=input($arr_slide_2[$i-1], "slide_2_{$i}", "text", "");$i++;?><br><br>
    Dokter yang mengirim :&nbsp;<br><br>
    (&nbsp;<?=input($arr_slide_2[$i-1], "slide_2_{$i}", "text", "");$i++;?>&nbsp;)
    <input type="hidden" name="count_slide_2" value="<?=$i;?>">
  </div>

<br><br>
<div style="text-align: right"><img style="width: 350px" class="text-right" src="../../images/alamat.jpg"></div>

  <?php if(isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])): ?>
  &nbsp;
<?php elseif(isset($_REQUEST['id'])): ?>
  <button type="submit" class="btn btn-primary">Ganti</button>
  </form>
<?php else:?>
  <button type="submit" class="btn btn-success">Simpan</button>
  </form>
<?php endif; ?>

  </div>

  <script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
  <script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>
  <script src="../../theme/bs/bootstrap.min.js"></script>
  <script>
    <?php if(isset($_REQUEST["pdf"])): ?>
      let identifier = '<?=$dataPasien["nama"]?>';
      printPDF('RM 18 '+identifier);
    <?php endif; ?>
  </script>
</body>

</html>