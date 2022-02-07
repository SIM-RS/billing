<?php
    include '../function/form.php';
    include '../../koneksi/konek.php';
    $dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
    $IdPel = $_REQUEST["idPel"];
    // $dbaskep
//     $sql="SELECT
//   c.id,
//   c.tgl_lahir,
//   c.no_rm,
//   c.nama,
//   b.umur_thn,
//   b.umur_bln,
//   c.sex
// FROM b_pelayanan a
//   LEFT JOIN b_kunjungan b
//     ON a.kunjungan_id = b.id
//   LEFT JOIN b_ms_pasien c
//     ON b.pasien_id = c.id WHERE a.id='".$IdPel."' GROUP BY c.id";
    // $q=mysql_query($sql);
    // $dataPasien=mysql_fetch_assoc($q);

    // $query = mysql_query("SELECT 
    // soap.tgl,
    // soap.user_id,
    // soap.ket_S, 
    // soap.ket_O, 
    // soap.ket_A, 
    // soap.ket_P, 
    // peg.nama AS userAct
    // FROM {$dbaskep}.ask_soap soap 
    // LEFT JOIN b_ms_pegawai peg ON soap.user_act = peg.id 
    // LEFT JOIN b_ms_pegawai peg ON soap.user_id = peg.id  
    // WHERE soap.pelayanan_id = {$IdPel}");

    $ruanganQ = mysql_query("SELECT 
    kmr.nama 
    FROM  b_tindakan_kamar t_kmr 
    LEFT JOIN b_ms_kamar kmr ON kmr.id = t_kmr.kamar_id
    WHERE t_kmr.pelayanan_id = '{$IdPel}'");

    $ruangan = mysql_fetch_assoc($ruanganQ);

    function getAllIdPel($id) {
      $arrData = [];
      $dataPel = mysql_query("SELECT id FROM b_pelayanan WHERE kunjungan_id = '${id}'");

      while ($ids = mysql_fetch_assoc($dataPel)) {
        array_push($arrData, $ids['id']);
      }
      return $arrData;
    }


function getRm8($idKunj) {
  $myArray = [];

  foreach (getAllIdPel($idKunj) as $value) {
    $dataRM = mysql_query("SELECT 
      soap.*, peg.nama AS nama_id, peg2.nama AS nama_act
      FROM rspelindo_askep.ask_soap soap
      LEFT JOIN b_ms_pegawai peg ON peg.id = soap.user_id
      LEFT JOIN b_ms_pegawai peg2 ON peg2.id = soap.user_act
      WHERE soap.pelayanan_id = '${value}'");

    while ($ids = mysql_fetch_assoc($dataRM)) {
      $arr = [
        'tgl' => $ids['tgl'],
        'ket_S' => $ids['ket_S'],
        'ket_O' => $ids['ket_O'],
        'ket_A' => $ids['ket_A'],
        'ket_P' => $ids['ket_P'],
        'nama_act' => $ids['nama_act'],
        'nama_id' => $ids['nama_id'],
      ];
      array_push($myArray, $arr);
    }
  }

  foreach ($myArray as $value) {
    echo "<tr>";

      echo "<td>";
        echo $value['tgl'];
      echo "</td>";

      echo "<td>";
        echo $value['nama_act'];
      echo "</td>";

      echo "<td>";
        echo $value['ket_S'];
      echo "<hr>";

        echo $value['ket_O'];
      echo "<hr>";

        echo $value['ket_A'];
      echo "<hr>";

        echo $value['ket_P'];
      echo "</td>";

      echo "<td>";
        echo "&nbsp;";
      echo "</td>";

      echo "<td>";
        echo $value['nama_id'];
      echo "</td>";

        echo "</tr>";
  }

}
?>

<html>
    <head>
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../favicon.png">
        <title>CATATAN PASIEN TERINTEGRASI</title>
        <script src="../html2pdf/ppdf.js"></script>
	      <link rel="stylesheet" href="../../theme/bs/bootstrap.min.css">
        <style>
          @media print {
            #print {
              display:none;
            }
          }
          th {
            /* font-size:15px; */
            padding:5px;
          }
      </style>
    </head>
<body style="padding:10px;">
<center>
<br>
  <button id='print' class='btn btn-info' onclick="javascript:pdf()">Cetak PDF</button>
  <button id='print' class='btn btn-info' onclick="window.print()">Cetak</button>
</center>
  <div id="pdf-area" style="margin: auto;">
	<div class="container bg-white" style="padding: 10px">
		<div class="row">
				<div class="col-6 text-center"><br><br><br>
				<img src="../logors1.png">
			</div>
			<div class="col-6" style="padding:40px">
				<div style="float: right">RM 8 / PHCM</div>
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
</div>

  <br><br>
  <hr class="bg-dark" style="margin-top:-25px"><br>
	<div style="height:5px;background-color:black;width:100%;margin-bottom:10px;margin-top:-35px"></div><br>
  <center><h3>CATATAN PASIEN TERINTEGRASI</h3></center>
  
  <div class="box-pasien" style="float: left; padding-left: 200px;">
    <b>Halaman Ke : 1</b> 
  </div>
  <div class="box-pasien" style="float: right; padding-right: 200px;">
    <b>Ruangan : <?=$ruangan["nama"]?></b> 
  </div>
  <br><br>
  <center>
   <table border="1"  style="margin: auto;width:100%;" class="text-center">
                <tr>
                  <th>Tanggal dan waktu</th>
                  <th>Profesional pemberi asuhan</th>
                  <th>Hasil Asesmen-IAR Penatalaksanaan pasien</th>
                  <th>Instruksi PPA Termasuk Pasca Bedah</th>
                  <th>Review & Verifikasi DPJP</th>
                </tr>
                
                <?php getRm8($_REQUEST['idKunj']); ?>
  </table>
  </center>
<script>
    function pdf() {
      const pdf = document.getElementById("pdf-area");
          var opt = {
              margin: 0,
              filename: "RM 8 <?= $dataPasien["nama"]; ?>.pdf",
              image: { type: "JPEG", quality: 1 },
              html2canvas: { scale: 1 },
              jsPDF: { unit: "in", format: "a4", orientation: "landscape" }
          };
      html2pdf().from(pdf).set(opt).save();
    }
</script>