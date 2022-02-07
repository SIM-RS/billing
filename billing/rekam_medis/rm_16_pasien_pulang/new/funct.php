<?php
include '../../function/form.php';
include '../../../koneksi/konek.php';
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
      
        echo "<script>window.location.href='index.php?idKunj=".$_REQUEST['idKunj']."&idPel=".$_REQUEST['idPel']."&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['idUser']."&tmpLay=".$_REQUEST['tmpLay']."&id=".$_REQUEST['idx']."'</script>";
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

    function dataKunjungan() {
      $data = mysql_fetch_assoc(mysql_query("SELECT * FROM b_kunjungan WHERE id = '{$_REQUEST['idKunj']}'"));
      return $data;
    }

    function dataKelas() {
      $data = mysql_fetch_assoc(mysql_query("SELECT b_ms_kelas.nama, b_ms_kamar.nama AS nama_kmr
        FROM b_kunjungan
        LEFT JOIN b_ms_kelas ON b_kunjungan.kelas_id = b_ms_kelas.id 
        LEFT JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = {$_REQUEST['idPel']}
        LEFT JOIN b_ms_kamar ON b_ms_kamar.id = b_tindakan_kamar.kamar_id 
        WHERE b_kunjungan.id = '{$_REQUEST['idKunj']}'"));
      return $data;
    }

    function dataDiag($type) {
      switch ($type) {
        case 'primer':
          $data = mysql_query("SELECT b_ms_diagnosa.nama, b_diagnosa.tgl_act
            FROM b_diagnosa 
            LEFT JOIN b_ms_diagnosa ON b_diagnosa.ms_diagnosa_id = b_ms_diagnosa.id 
            WHERE b_diagnosa.primer = '1' AND b_diagnosa.kunjungan_id = {$_REQUEST['idKunj']}");
          break;
        
        default:
          $data = mysql_query("SELECT b_ms_diagnosa.nama, b_diagnosa.tgl_act
            FROM b_diagnosa 
            LEFT JOIN b_ms_diagnosa ON b_diagnosa.ms_diagnosa_id = b_ms_diagnosa.id 
            WHERE b_diagnosa.primer = '0' AND b_diagnosa.kunjungan_id = {$_REQUEST['idKunj']}");
          break;
      }
      return $data;
      
    }

    $MyDataDiag = [
    	'primer' => dataDiag('primer'),
    	'sekunder' => dataDiag('sekunder'),
    ];