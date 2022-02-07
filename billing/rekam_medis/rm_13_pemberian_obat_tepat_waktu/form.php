<?php
	use yii\helpers\Html;
	include '../function/form.php';
	include '../../koneksi/konek.php';
	include 'funct.php';
	$dataPasien = getIndetitasPasien($_REQUEST['idKunj']);
	$alergi = mysql_query("SELECT *  FROM b_riwayat_alergi WHERE pasien_id = {$dataPasien['id']}");
	$i = 1;
	$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_13_pemberian_obat_tepat_waktu WHERE id = '{$_REQUEST['cetak']}'"));


	if (isset($_REQUEST['id'])) {
		$data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_13_pemberian_obat_tepat_waktu WHERE id = '{$_REQUEST['id']}'"));
		$data_all = $data['data'];
		$arr_data = []; $str = "";
		for ($w=0; $w < strlen($data_all); $w++) { 
			if ($data_all[$w] != "|") {
				$str .= $data_all[$w];
			} else {
				array_push($arr_data, $str);
				$str = "";
			}
		}

	}

	if (isset($_REQUEST['idx'])) {
		
		$iCount = mysql_real_escape_string($_REQUEST['i']);
		$str = "";
		for ($i=1; $i < $iCount; $i++) { 
			$data = mysql_real_escape_string($_REQUEST["slide_{$i}"]);
			if ($data == "") {
				$str .= "#";
				$str .= "|";
			} else {
				$str .= $data;
				$str .= "|";
			}
		}

		$data = [
			'id_pasien' => $dataPasien['id'],
			'id_kunjungan' => mysql_real_escape_string($_REQUEST['id_kunjungan']),
			'id_pelayanan' => mysql_real_escape_string($_REQUEST['id_pelayanan']),
			'tgl_act' => date('Y-m-d H:i:s'),
			'id_user' => mysql_real_escape_string($_REQUEST["id_user"]),
			'data' => $str
		];
		
		mysql_query("UPDATE rm_13_pemberian_obat_tepat_waktu 
	    			SET
            		id_pasien = '{$data['id_pasien']}',
			    	id_kunjungan = '{$data['id_kunjungan']}',
			    	id_pelayanan = '{$data['id_pelayanan']}',
            		tgl_act = '{$data['tgl_act']}',
			    	id_user = '{$data['id_user']}',
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
		body, input{
			font-size:14px;
		}
		.inv{
			background-color: : transparent;
			outline-color: none;
			cursor: default;
			border: 0px;
			text-align: center;
		}
		td {
			padding: 5px;
		}
	</style>
	<script src="../html2pdf/ppdf.js"></script>
	<?php 
		if (isset($_REQUEST['cetak'])) {
    $print_mode = true;
    echo "<script>window.print();</script>";
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_13_pemberian_obat_tepat_waktu WHERE id = '{$_REQUEST['cetak']}'"));
        
    $data_all = $data['data'];
    $arr_data = [];
    $str = "";
    for ($w=0; $w < strlen($data_all); $w++) {
        if ($data_all[$w] != "|") {
            $str .= $data_all[$w];
        } else {
            array_push($arr_data, $str);
            $str = "";
        }
    }
}

    if (isset($_REQUEST['pdf'])) {
        $print_mode = true;
        $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_13_pemberian_obat_tepat_waktu WHERE id = '{$_REQUEST['pdf']}'"));
        
        $data_all = $data['data'];
        $arr_data = [];
        $str = "";
        for ($w=0; $w < strlen($data_all); $w++) {
            if ($data_all[$w] != "|") {
                $str .= $data_all[$w];
            } else {
                array_push($arr_data, $str);
                $str = "";
            }
        }
    }

	?>
</head>

<body id="pdf-area">

	<div style="padding:10px;">
		<div class="row" style="padding:20px">
			<div class="col-6 text-center"><br><br>
				<img src="../logors1.png">
			</div>
			<div class="col-6" style="padding:10px">
				<div style="float: right">RM 13 / PHCM</div>
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

		<br>
		<hr class="bg-dark" style="margin-top:-25px"><br>
		<div style="height:5px;background-color:black;width:100%;margin-bottom:10px;margin-top:-35px"></div>
		<center><h2>Tabel Pemberian Obat Tepat Waktu</h2></center>

		<div style="border:1px solid black;width:25%;margin-bottom:20px;">
			<div class="col-12" >
				<table style="width:100%">
					<tr style="border-bottom:1px solid black">
						<td>Alergi Obat </td>
						<td>:</td>
						<td>
							<?php if(mysql_num_rows($alergi) >= 1): ?>
								Ya
							<?php else: ?>
								Tidak
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td>Jika Ya</td>
						<td>:</td>
						<td>
							<?php if(mysql_num_rows($alergi) >= 1): ?>
								<?php while($row = mysql_fetch_assoc($alergi)): ?>
									<?php echo $row['riwayat_alergi'] . "<br>"?>
								<?php endwhile; ?>
							<?php else: ?>
									....................................
							<?php endif; ?>
						</td>
					</tr>
				</table>
			</div>
		</div>

<?php if(isset($_REQUEST['id'])): ?>
  <form method="POST">
	<input type="hidden" name="idx" value="<?= $_REQUEST['id']; ?>">
<?php else:?>
  <form action="utils.php" method="POST">
<?php endif; ?>

	<input type="hidden" name="id_kunjungan" value="<?= $_REQUEST['idKunj']; ?>">
	<input type="hidden" name="id_pelayanan" value="<?= $_REQUEST['idPel']; ?>">
	<input type="hidden" name="id_user" value="<?= $_REQUEST['idUser']; ?>">
	<input type="hidden" name="tmpLay" value="<?= $_REQUEST['tmpLay']; ?>">

		<table class="text-center" border="1px" style="font-size:10px">
			<tr>
				<td>Nama Obat</td>
				<td >Signa</td>
				<td >Rute</td>
				<td >Paraf Dokter</td>
				<td colspan="8">Tanggal : <?= input($arr_data[$i-1], "slide_{$i}", "date", "", "");$i++; ?></td>
				<td colspan="8">Tanggal : <?= input($arr_data[$i-1], "slide_{$i}", "date", "", "");$i++; ?></td>
				<td colspan="8">Tanggal : <?= input($arr_data[$i-1], "slide_{$i}", "date", "", "");$i++; ?></td>
			</tr>
			<tr>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td>Jam</td>
				<td>Perawat</td>
				<td>Jam</td>
				<td>Perawat</td>
				<td>Jam</td>
				<td>Perawat</td>
				<td>Jam</td>
				<td>Perawat</td>
				<td>Jam</td>
				<td>Perawat</td>
				<td>Jam</td>
				<td>Perawat</td>
				<td>Jam</td>
				<td>Perawat</td>
				<td>Jam</td>
				<td>Perawat</td>
				<td>Jam</td>
				<td>Perawat</td>
				<td>Jam</td>
				<td>Perawat</td>
				<td>Jam</td>
				<td>Perawat</td>
				<td>Jam</td>
				<td>Perawat</td>
			</tr>
			
			<?php for($e = 4; $e < 25; $e++): ?>
				<tr>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "text", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "text", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "text", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "text", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "time", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "text", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "time", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "text", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "time", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "text", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "time", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "text", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "time", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "text", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "time", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "text", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "time", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "text", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "time", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "text", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "time", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "text", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "time", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "text", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "time", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "text", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "time", "", "");$i++; ?></td>
					<td ><?= input($arr_data[$i-1], "slide_{$i}", "text", "", "");$i++; ?></td>
				</tr>
			<?php endfor; ?>
			</table><br>
			<input type="hidden" name="i" value="<?=$i;?>">
<?php if(isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])): ?>
	&nbsp;
<?php elseif(isset($_REQUEST['id'])): ?>
	<button type="submit" class="btn btn-primary">Ganti</button>
	</form>
<?php else:?>
	<button type="submit" id="tmbh" class="btn btn-success">Simpan</button>
	</form>
<?php endif; ?>
	
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>
	<script src="../../theme/bs/bootstrap.min.js"></script>
	<script>
		<?php if(isset($_REQUEST["pdf"])): ?>
		const pdf = document.getElementById("pdf-area");
		var opt = {
			margin: 0,
			filename: "RM 13 <?=$dataPasien["nama"]?>.pdf",
			image: { type: "png" },
			html2canvas: { scale: 1 },
			jsPDF: { unit: "pt", format: "a4", orientation: "landscape" }
		};
		html2pdf().from(pdf).set(opt).save();
		<?php endif; ?>
	</script>
</body>

</html>