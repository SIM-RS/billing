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
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_poli_gigi WHERE id = '{$_REQUEST['cetak']}'"));
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
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_poli_gigi WHERE id = '{$_REQUEST['id']}'"));
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
          'data' => $str
	  ];

      $hasil = mysql_query("UPDATE rm_poli_gigi 
            SET
            id_kunjungan = '{$data['id_kunjungan']}',
            id_pelayanan = '{$data['id_pelayanan']}',
            tgl_act = '{$data['tgl_act']}',
            id_user = '{$data['id_user']}',
			      data = '{$data['data']}'
            WHERE 
            id = {$_REQUEST['idx']}");
      
      echo "<script>window.location.href='index.php?idKunj=".$_REQUEST['idKunj']."&idPel=".$_REQUEST['idPel']."&idPasien=".$_REQUEST['idPasien']."&idUser=".$_REQUEST['idUser']."&tmpLay=".$_REQUEST['tmpLay']."'</script>";
  }

  if (isset($_REQUEST['pdf'])) {
    echo '';
    $print_mode = true;
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_poli_gigi WHERE id = '{$_REQUEST['pdf']}'"));
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

?>

<!DOCTYPE html>
<html lang="en">
 
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../../theme/bs/bootstrap.min.css">
	<title>Document</title>
	<style type="text/css">
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
	<div class="container bg-white" style="padding:25px">
		<div class="row">
			<div class="col-6 text-center"><br><br>
				<img src="../logors1.png">
			</div>
			<div class="col-6" style="padding:15px">
					
				<div style="float: right">RM 2.8 / PHCM</div>
				<br>
				<div id="box" class="row" style="border: 1px solid black;padding:15px">
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

		<hr class="bg-dark" style="margin-top:-1px">
		<div style="height:5px;background-color:black;width:100%;margin-top:-12px;margin-bottom:10px"></div><br>
		<center><h2>PENGKAJIAN AWAL MEDIS</h2><h2>GIGI DAN MULUT</h2></center>
		<div>

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
<div class="row">
  <div class="col-6">
      <b>Tanggal : <?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?></b>
  </div>
    <div class="col-6">
      <b>Jam : <?=input($arr_data[$i-1], "data_{$i}", "time", "", "");$i++;?> WIB</b>
    </div>
</div><br>
  
<table width="100%">
    <tr>
      <td><u><b>ANAMNESA</b></u></td>
      <td>:</td>
      <td>( <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Pasien&emsp;
            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Keluarga&emsp;
            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Teman&emsp;
            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Lainnya : 
            <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
       )</td>
    </tr>
    <tr>
      <td colspan="2"><br><b>IDENTITAS PASIEN</b></td>
    </tr>
    <tr>
      <td><b>Agama</b></td>
      <td>:</td>
      <td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Islam&emsp;
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Protestan&emsp;
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Katolik&emsp;
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>>Budha&emsp;
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Hindu&emsp;
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>>  Lain-lain</td>
    </tr>
    <tr>
      <td><b>Pendidikan</b></td>
      <td>:</td>
      <td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak Ada&emsp;
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> SD&emsp;
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> SMP&emsp;
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> SMA&emsp;
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> PT</td>
    </tr>
    <tr>
      <td><b>Pekerjaan</b></td>
      <td>:</td>
      <td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak bekerja&emsp;
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> PNS&emsp;
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> TNI/Polri&emsp;
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Swasta&emsp;
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> lain-lain
    </tr>
    <tr>
      <td><b>Kewarganegaraan</b></td>
      <td>:</td>
      <td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> WNI&emsp;
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> WNA
    </tr>
    <tr>
      <td><b>Suku</b></td>
      <td>:</td>
      <td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Melayu&emsp;
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Batak&emsp;
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Jawa&emsp;
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> lain lain : 
      <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
    </tr>
    <tr>
      <td><b>Pantangan</b></td>
      <td>:</td>
      <td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> ada 
      <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> tidak ada 
      <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
    </tr>
    <tr>
      <td><b>Nilai Kepercayaan</b></td>
      <td>:</td>
      <td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> ada 
      <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> tidak ada 
      <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
    </tr>
    <tr>
      <td colspan="2"><u><b>DATA MEDIK</b></u></td>
    </tr>
    <tr>
      <td colspan="3">
        <table style="margin-left:50px">
          <tr>
            <td>1. Golongan Darah</td>
            <td>:</td>
            <td><?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?></td>
          </tr>
          <tr>
            <td>2. Tekanan Darah</td>
            <td>:</td>
            <td><?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> / 
            <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> 
            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Hypertensi / 
            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Hypotensi / 
            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Normal</td>
          </tr>
          <tr>
            <td>3. Penyakit Jantung</td>
            <td>:</td>
            <td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak Ada / 
            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ada</td>
          </tr>
          <tr>
            <td>4. Diabetes</td>
            <td>:</td>
            <td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak Ada / 
            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ada</td>
          </tr>
          <tr>
            <td>5. Haemopilia </td>
            <td>:</td>
            <td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak Ada / 
            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ada</td>
          </tr>
          <tr>
            <td>6.	Hepar</td>
            <td>:</td>
            <td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak Ada / 
            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ada</td>
          </tr>
          <tr>
            <td>7.	Gastritis</td>
            <td>:</td>
            <td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak Ada / 
            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ada</td>
          </tr>
          <tr>
            <td>8.	Penyakit lainnya</td>
            <td>:</td>
            <td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak Ada / 
            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ada</td>
          </tr>
          <tr>
            <td>9.	Alergi terhadap obat-obatan</td>
            <td>:</td>
            <td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak Ada / 
            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ada 
            <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
            </td>
          </tr>
          <tr>
            <td>10.	Alergi terhadap makanan</td>
            <td>:</td>
            <td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak Ada / 
            <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ada</td>
          </tr>
        </table>
      </td>
    </tr>
</table><br>

<h4><u> PEMERIKSAAN ODONTOGRAM :</u></h4>
<table border="1px" width="100%">
    <?php $n1=11;$n2=21;$n3=51;$n4=61; for($num=1;$num<9;$num++): ?>
      <tr class="text-center">
      <?php if($n3 != 56): ?>
        <td width="25%"><?=$n1 . " [" . $n3 . "]";$n1++;$n3++?></td>
        <td width="25%"><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
        <td width="25%"><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
        <td width="25%"><?="[" . $n4 . "] " . $n2;$n2++;$n4++;?></td>
        <?php else: ?>
        <td width="25%"><?=$n1;$n1++;?></td>
        <td width="25%"><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
        <td width="25%"><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
        <td width="25%"><?=$n2;$n2++;?></td>
        <?php endif; ?>
      </tr>
    <?php endfor; ?>
</table>
</div>

<br><br>
<div style="text-align: right"><img style="width: 350px" class="text-right" src="../../images/alamat.jpg"></div>
<br><br>
<br><br>
<br><br>
<img src="../../images/gigi.jpg" width='100%'>
<br><br>

<table border="1px" width="100%">
    <?php $n1=48;$n2=38;$n3=85;$n4=75; for($num=1;$num<9;$num++): ?>
      <tr class="text-center">
      <?php if($n1 >= 46): ?>
        <td width="25%"><?=$n1;$n1--;?></td>
        <td width="25%"><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
        <td width="25%"><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
        <td width="25%"><?=$n2;$n2--;?></td>
        <?php else: ?>
        <td width="25%"><?=$n1 . " [" . $n3 . "]";$n1--;$n3--?></td>
        <td width="25%"><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
        <td width="25%"><?=input($arr_data[$i-1], "data_{$i}", "text", "form-control", "");$i++;?></td>
        <td width="25%"><?="[" . $n4 . "] " . $n2;$n2--;$n4--;?></td>
        <?php endif; ?>
      </tr>
    <?php endfor; ?>
</table><br>

<table>
    <tr>
      <td>Occlusi</td>
      <td>:</td>
      <td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Normal Bite / 
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Cross Bite / 
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Deep Bite</td>
    </tr>
    <tr>
      <td>Torus Palatinus</td>
      <td>:</td>
      <td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak Ada / 
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Kecil / 
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Sedang / 
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Besar / 
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Multiple</td>
    </tr>
    <tr>
      <td>Torus Mandibularis</td>
      <td>:</td>
      <td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak ada / 
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> sisi kiri / 
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> sisi kanan / 
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> kedua sisi</td>
    </tr>
    <tr>
      <td>Palatum</td>
      <td>:</td>
      <td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Dalam / 
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Sedang / 
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Rendah</td>
    </tr>
    <tr>
      <td>Diastema</td>
      <td>:</td>
      <td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak Ada/ 
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ada:  (dijelaskan dimana dan berapa lebarnya) <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?></td>
    </tr>
    <tr>
      <td>Gigi Anomali</td>
      <td>:</td>
      <td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Tidak Ada / 
      <input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> Ada: (dijelaskan gigi yang mana, dan bentuknya) <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?></td>
    </tr>
    <tr>
      <td>Lain-lain</td>
      <td>:</td>
      <td><input type="checkbox" value="1" name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?>> (hal-hal yang tidak tercakup diatas) <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> <br>
      D : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> M : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?> F : <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?></td>
    </tr>
</table>

<div>
    Jumlah photo yang diambil <?=input($arr_data[$i-1], "data_{$i}", "number", "", "");$i++;?> (digital/intraoral)* <br>
    Jumlah rontgen photo yang diambil <?=input($arr_data[$i-1], "data_{$i}", "number", "", "");$i++;?> (Dental/PA/OPG/Ceph)* <br><br>
    <table width="100%" border='1px'>
      <tr class="text-center">
        <td style="pdding:20px">
          <div class="row">
            <div class="col-4">
              DIPERIKSA OLEH <br><br><br><br><br> drg <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
            </div>
            <div class="col-4">
              TANGGAL PEMRIKSAAN <br><br><br><br><br> <?=input($arr_data[$i-1], "data_{$i}", "date", "", "");$i++;?>
            </div>
            <div class="col-4">
              TANDA TANGAN PEMERIKSA <br><br><br><br><br> <?=input($arr_data[$i-1], "data_{$i}", "text", "", "");$i++;?>
            </div>
          </div>          
        </td>
      </tr>
    </table>
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

	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery-1.9.1.js"></script>
	<script type="text/JavaScript" language="JavaScript" src="../../include/jquery/jquery.form.js"></script>
    <script type="text/JavaScript" language="JavaScript" src="../../theme/js/mod.js"></script>
    <script type="text/javascript" src="../../theme/js/ajax.js"></script>
	<script src="../../theme/bs/bootstrap.min.js"></script>
    <script>
      <?php if(isset($_REQUEST["pdf"])): ?>
        let identifier = '<?=$dataPasien["nama"]?>';
        printPDF('RM 2.8 '+identifier);
      <?php endif; ?>
    </script>
</body>

</html>