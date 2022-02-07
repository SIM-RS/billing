<?php
    use yii\helpers\Html;

    include '../function/form.php';
    include '../../koneksi/konek.php';
    include 'funct.php';
  $dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
  $no_rm = $dataPasien['no_rm'];
  $rm = [];
  for ($v=0; $v < strlen($no_rm); $v++) {
      array_push($rm, $no_rm[$v]);
  }

  $i = 1; $j = 1;

    if (isset($_REQUEST['idx'])) {
        date_default_timezone_set("Asia/Jakarta");
        $id_kunj = (int)$_REQUEST["id_kunjungan"];
        $sql = mysql_fetch_assoc(mysql_query("SELECT pasien_id FROM b_kunjungan WHERE id = '$id_kunj'"));
        $tgl_act = date('Y-m-d H:i:s');
        $count_1 = $_REQUEST['count_i'];
        $str_slide_1 = "";
        $count_2 = $_REQUEST['count_j'];
        $str_slide_2 = "";

        for ($r=1; $r < $count_1; $r++) {
            $myData = $_REQUEST["slide1_{$r}"];

            if ($myData == "") {
                $str_slide_1 .= "#";
                $str_slide_1 .= "|";
            } else {
                $str_slide_1 .= $myData;
                $str_slide_1 .= "|";
            }
        }

        for ($g=1; $g < $count_2; $g++) {
            $myData = $_REQUEST["slide2_{$g}"];

            if ($myData == "") {
                $str_slide_2 .= "#";
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
      
        mysql_query("UPDATE rm_16_pasien_pulang 
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

    if (isset($_REQUEST['pdf'])) {
        $print_mode = true;
        $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_16_pasien_pulang WHERE id = '{$_REQUEST['pdf']}'"));
        $dataSlide1 = $data['slide_1'];
        $arr_slide1 = [];
        $str_1 = "";
        $dataSlide2 = $data['slide_2'];
        $arr_slide2 = [];
        $str_2 = "";

        for ($z=0; $z < strlen($dataSlide1); $z++) {
            if ($dataSlide1[$z] != "|") {
                if ($dataSlide1[$z] == "#") {
                    $str_1 .= "";
                } else {
                    $str_1 .= $dataSlide1[$z];
                }
            } else {
                array_push($arr_slide1, $str_1);
                $str_1 = "";
            }
        }

        for ($y=0; $y < strlen($dataSlide2); $y++) {
            if ($dataSlide2[$y] != "|") {
                if ($dataSlide2[$y] == "#") {
                    $str_2 .= "";
                } else {
                    $str_2 .= $dataSlide2[$y];
                }
            } else {
                array_push($arr_slide2, $str_2);
                $str_2 = "";
            }
        }
    }


    if (isset($_REQUEST['cetak'])) {
        $print_mode = true;
        echo "<script>window.print();</script>";
        $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_16_pasien_pulang WHERE id = '{$_REQUEST['cetak']}'"));
        $dataSlide1 = $data['slide_1'];
        $arr_slide1 = [];
        $str_1 = "";
        $dataSlide2 = $data['slide_2'];
        $arr_slide2 = [];
        $str_2 = "";

        for ($z=0; $z < strlen($dataSlide1); $z++) {
            if ($dataSlide1[$z] != "|") {
                if ($dataSlide1[$z] == "#") {
                    $str_1 .= "";
                } else {
                    $str_1 .= $dataSlide1[$z];
                }
            } else {
                array_push($arr_slide1, $str_1);
                $str_1 = "";
            }
        }

        for ($y=0; $y < strlen($dataSlide2); $y++) {
            if ($dataSlide2[$y] != "|") {
                if ($dataSlide2[$y] == "#") {
                    $str_2 .= "";
                } else {
                    $str_2 .= $dataSlide2[$y];
                }
            } else {
                array_push($arr_slide2, $str_2);
                $str_2 = "";
            }
        }
    }
  
  

    if (isset($_REQUEST['id'])) {
        $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_16_pasien_pulang WHERE id = '{$_REQUEST['id']}'"));
        $dataSlide1 = $data['slide_1'];
        $arr_slide1 = [];
        $str_1 = "";
        $dataSlide2 = $data['slide_2'];
        $arr_slide2 = [];
        $str_2 = "";

        for ($z=0; $z < strlen($dataSlide1); $z++) {
            if ($dataSlide1[$z] != "|") {
                $str_1 .= $dataSlide1[$z];
            } else {
                array_push($arr_slide1, $str_1);
                $str_1 = "";
            }
        }

        for ($y=0; $y < strlen($dataSlide2); $y++) {
            if ($dataSlide2[$y] != "|") {
                $str_2 .= $dataSlide2[$y];
            } else {
                array_push($arr_slide2, $str_2);
                $str_2 = "";
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
    .bordered{
      border:1px solid black;
      width:20px;
      height:20px;
    }
    ul{
      list-style-type:none;
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
				<div style="float: right">RM 16 / PHCM</div>
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
									<?php if ($dataPasien["sex"] == "L"): ?>
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
		<div style="height:5px;background-color:black;width:100%;margin-bottom:10px;margin-top:-35px"></div><br>
		<h4 class="text-center"><span style="border-bottom:2px solid black;">RESUME MEDIS PASIEN PULANG</span><div>MEDICAL DISCHARGE SUMMARY</div>
</h4><br>

<?php if (isset($_REQUEST['id'])): ?>
  <form action="" method="POST">
	<input type="hidden" name="idx" value="<?= $_REQUEST['id']; ?>">
<?php else:?>
  <form action="utils.php" method="POST">
<?php endif; ?>

	<input type="hidden" name="id_kunjungan" value="<?= $_REQUEST['idKunj']; ?>">
	<input type="hidden" name="id_pelayanan" value="<?= $_REQUEST['idPel']; ?>">
	<input type="hidden" name="id_user" value="<?= $_REQUEST['idUser']; ?>">
	<input type="hidden" name="tmpLay" value="<?= $_REQUEST['tmpLay']; ?>">
		
  <table border="1px" class="text-left" style="width:100%">
    <tr>
      <td colspan="2">
        <div class="row">
          <div class="col-6">
            <table>
              <tr>
                <td>No. Rekam Medis</td>
                <td>:</td>
                <td>
                  <span class="bordered">&emsp;<?=$rm[0]?>&emsp;</span>
                  <span class="bordered">&emsp;<?=$rm[1]?>&emsp;</span>
                  <span class="bordered">&emsp;<?=$rm[2]?>&emsp;</span>
                  <span class="bordered">&emsp;<?=$rm[3]?>&emsp;</span>
                  <span class="bordered">&emsp;<?=$rm[4]?>&emsp;</span>
                  <span class="bordered">&emsp;<?=$rm[5]?>&emsp;</span>
                  <span class="bordered">&emsp;<?=$rm[6]?>&emsp;</span>
                  <span class="bordered">&emsp;<?=$rm[7]?>&emsp;</span>
                </td>
              </tr>
              <tr>
                <td colspan="3">Medical Record Number</td>
              </tr>
            </table>
          </div>

          <div class="col-6">
            <table>
              <tr>
                <td>Tanggal Masuk RS</td>
                <td>:</td>
                <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "date", "");$i++;?></td>
              </tr>
              <tr>
                <td colspan="3">Admitted</td>
              </tr>
            </table>
          </div>

        </div>
      </td>
    </tr>

    <tr>
      <td colspan="2">
        <div class="row">
          <div class="col-6">
            <table>
              <tr>
                <td>Nama Pasien</td>
                <td>:</td>
                <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
              </tr>
              <tr>
                <td colspan="3">Patient Name</td>
              </tr>
            </table>
          </div>

          <div class="col-6">
            <table>
              <tr>
                <td>Tanggal Keluar RS</td>
                <td>:</td>
                <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "date", "");$i++;?></td>
              </tr>
              <tr>
                <td colspan="3">Date of Discharge</td>
              </tr>
            </table>
          </div>

        </div>
      </td>
    </tr>

    <tr>
      <td colspan="2">
        <div class="row">
          <div class="col-6">
            <table>
              <tr>
                <td>Nama Orang Tua / Suami/ Istri </td>
                <td>:</td>
                <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "date", "");$i++;?></td>
              </tr>
              <tr>
                <td colspan="3">Family Name</td>
              </tr>
            </table>
          </div>

          <div class="col-6">
            <table>
              <tr>
                <td>Jenis kelamin</td>
                <td>:</td>
                <td>
                  <?=radio($arr_slide1[$i-1], "slide1_{$i}", "radio", "");$i++;?>
                </td>
              </tr>
              <tr>
                <td colspan="3">Sex</td>
              </tr>
            </table>
          </div>

        </div>
      </td>
    </tr>

    <tr>
      <td colspan="2">
        <div class="row">
          <div class="col-6">
            <table>
              <tr>
                <td>Tanggal Lahir</td>
                <td>:</td>
                <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "date", "");$i++;?></td>
              </tr>
              <tr>
                <td colspan="3">Date Of Birthday</td>
              </tr>
            </table>
          </div>

          <div class="col-6">
            <table>
              <tr>
                <td>Kelas / Kamar</td>
                <td>:</td>
                <td><?=input($arr_slide1[$i-1], "slide1_{$i}", "date", "");$i++;?></td>
              </tr>
              <tr>
                <td colspan="3">Class / Room</td>
              </tr>
            </table>
          </div>

        </div>
      </td>
    </tr>

    <tr>
      <td colspan="2">Alasan Dirawat (Reason Treated) :<br><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    </tr>
    <tr>
      <td colspan="2">Pemeriksaan Fisik ( Physical  Examination) :<br><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
    </tr>
    <tr>
      <td colspan="2">
        Pemeriksaan Penunjang Diagnosis ( Other Examination Result ) : <br>
        <?=checkInput($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?>&nbsp;Labotarium : <?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?><br>

        <?=checkInput($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?>&nbsp;Rontgen : <?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?><br>

        <?=checkInput($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?>&nbsp;CT SCAN&emsp;
        <?=checkInput($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?>&nbsp;USG&emsp;
        <?=checkInput($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?>&nbsp;EKG&emsp;
        <?=checkInput($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?>&nbsp;CTG&emsp;
        <?=checkInput($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?>&nbsp;Echocardiography&emsp;
        <?=checkInput($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?>&nbsp;Treadmill&emsp;
        <?=checkInput($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?>&nbsp;Gastroscopy&emsp;
        <?=checkInput($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?>&nbsp;Colonoscopy<br>
        <?=checkInput($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?>&nbsp;EMG&emsp;
        <?=checkInput($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?>&nbsp;OAE&emsp;
        <?=checkInput($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?>&nbsp;EEG&emsp;
        <?=checkInput($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?>&nbsp;Lain-lain :<?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?>

      </td>
    </tr>

    <tr>
      <td>Diagnosis Primer ( Primary Diagnose) :<br><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
      <td>Kode ICD 10 :<br><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    </tr>
    <tr>
      <td>Diagnosis Sekunder & Diagnosis Penyerta ( Secondary Diagnose & Comorbid Diagnose)  :<br><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
      <td>Kode ICD 10 :<br><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    </tr>
    <tr>
      <td>Tindakan/ Prosedur Bedah ( Medical/ Surgical Procedures ) :<br><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?></td>
      <td>Kode ICD 9 CM :<br><?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "");$i++;?></td>
    </tr>

    <tr>
      <td colspan="2">
        Terapi/ Pengobatan  (Terapy/ Treatment ) :<?=input($arr_slide1[$i-1], "slide1_{$i}", "text", "form-control");$i++;?><br>
        Selama Dirawat :<br><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?><br>
        Setelah Dirawat :<br><?=area($arr_slide1[$i-1], "slide1_{$i}", "");$i++;?><br>
        <input type="hidden" name="count_i" value="<?=$i;?>">
      </td>
    </tr>

  </table>

<br><br>

  </div><br><br>

  <div class="container bg-white" style="padding: 10px">
    
    <table border="1px" style="width:100%">
      <tr>
        <td>
        <b>Instruksi/ Tindak Lanjut ( Instruction/ Follow Up/ Medical Advice ) : Rencana Kontrol Tgl : <?=input($arr_slide2[$j-1], "slide2_{$j}", "date", "");$j++;?></b><br><br>
        
        <div>
          <span>Perawatan dirumah:</span>
          <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Tidak&emsp;
          <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Ada&emsp;
          <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Home visite/Care&emsp;
          <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Perawatan lanjutan&emsp;
          <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Perawatan luka&emsp;
          <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Pengobatan lanjutan
        </div><br><br>

        <div>
          <span>Rencana pemeriksaan penunjang :</span>
          <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Laboratorium&emsp;
          <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Radiologi&emsp;
          <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Lain –lain&emsp;
          <?=input($arr_slide2[$j-1], "slide2_{$j}", "text", "");$j++;?>
        </div><br><br>

        <div>
            <div class="row">
              <div class="col-2">Kebutuhan Edukasi  :</div>
              
              <div class="col-10">
                <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Penyakit&emsp;
                <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Obat dan efek samping obat&emsp;
                <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Diet&emsp;
                <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Aktifitas dan istirahat dirumah &emsp;
                <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;hygiene<br>
                <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Perawatan luka dirumah&emsp;
                <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Perawatan ibu dan bayi&emsp;
                <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Nyeri<br>
                <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Pertolongan mendesak&emsp;
                <?=input($arr_slide2[$j-1], "slide2_{$j}", "text", "");$j++;?><br>
                <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Lain- lain&emsp;
                <?=input($arr_slide2[$j-1], "slide2_{$j}", "text", "");$j++;?><br>
              </div>
            </div>
                
        </div><br><br>

        </td>
      </tr>

      <tr>
        <td>
          <b>Keadaan Akhir Perawatan ( Discharge Condition ) :</b><br><br>
          <div class="row">
            <?=radio2($arr_slide2[$j-1], "slide2_{$j}", "radio", "");$j++;?>
        </div>
        <br><br>
         <div>
            <div class="row">
              <div class="col-2">Keadaan saat pulang :</div>
              
              <div class="col-10">
                KU : <?=input($arr_slide2[$j-1], "slide2_{$j}", "text", "");$j++;?>,&nbsp;
                Kesadaran : <?=input($arr_slide2[$j-1], "slide2_{$j}", "text", "");$j++;?>,&nbsp;
                TD : <?=input($arr_slide2[$j-1], "slide2_{$j}", "text", "");$j++;?>mmHg,&nbsp;
                Nadi : <?=input($arr_slide2[$j-1], "slide2_{$j}", "text", "");$j++;?>x/menit,<br><br>
                Suhu : <?=input($arr_slide2[$j-1], "slide2_{$j}", "text", "");$j++;?>°C,&nbsp;
                Pernafasan : <?=input($arr_slide2[$j-1], "slide2_{$j}", "text", "");$j++;?>x/ mnt,
              </div>
            </div><br><br>
            <div>
            <div class="row">
              <div class="col-2">Mobilisasi saat pulang :</div>
              
              <div class="col-10">
                <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Mandiri&emsp;
                <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Dibantu Sebagian&emsp;
                <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Dibantu penuh ,Alat bantu :&emsp;
                <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Tongkat&emsp;
                <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Kursi Roda&emsp;
                <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Brancard&emsp;<br>
                <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Walker&emsp;
                <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Lain-lain&nbsp;
                <?=input($arr_slide2[$j-1], "slide2_{$j}", "text", "");$j++;?>
              </div>
            </div><br><br>

            <div>
            <div class="row">
              <div class="col-2">Alat kes. yang terpasang :</div>
              
              <div class="col-10">
                <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Tidak Ada&emsp;
                <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;IV catheter&emsp;
                <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Dobel lumen&emsp;
                <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;NGT&emsp;
                <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Oksigen&emsp;
                <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Catheter urine&emsp;
                <?=checkInput($arr_slide2[$j-1], "slide2_{$j}", "");$j++;?>&nbsp;Lain-lain&nbsp;
                <?=input($arr_slide2[$j-1], "slide2_{$j}", "text", "");$j++;?>
              </div>
            </div><br><br>

        <b>Penyakit Berhubungan Dengan ( Related  Diseases ) :</b><br><br>
        
        <div class="row">
          <?=radio3($arr_slide2[$j-1], "slide2_{$j}", "radio", "");$j++;?>
        </div>
        <br><br>

        </td>
      </tr>

      <tr>
        <td colspan="2"><br><br><br><br><br><br>
          <?=input($arr_slide2[$j-1], "slide2_{$j}", "text", "");$j++;?><br>
          <input type="hidden" name="count_j" value="<?=$j;?>">
          Tanda Tangan & Nama Jelas Dokter<br>
          Attending Doctors Name And Signature
        </td>
      </tr>

    </table><br><br>

        <?php if (isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])): ?>
  &nbsp;
<?php elseif (isset($_REQUEST['id'])): ?>
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
  <?php if (isset($_REQUEST["pdf"])): ?>
		let identifier = '<?=$dataPasien["nama"]?>';
		printPDF('RM 16 '+identifier);
	<?php endif; ?>
  </script>
</body>

</html>