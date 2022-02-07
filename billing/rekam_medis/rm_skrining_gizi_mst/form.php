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
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_15_6_skrining_gizi_mst WHERE id = '{$_REQUEST['cetak']}'"));

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
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_15_6_skrining_gizi_mst WHERE id = '{$_REQUEST['pdf']}'"));

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
    $data = mysql_fetch_assoc(mysql_query("SELECT * FROM rm_15_6_skrining_gizi_mst WHERE id = '{$_REQUEST['id']}'"));
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
          'id_user' => mysql_real_escape_string($_REQUEST["cmbDokSemua"]),
          'data' => $str
	  ];

      $hasil = mysql_query("UPDATE rm_15_6_skrining_gizi_mst 
            SET
            id_kunjungan = '{$data['id_kunjungan']}',
            id_pelayanan = '{$data['id_pelayanan']}',
            id_user = '{$data['id_user']}',
            tgl_act = '{$data['tgl_act']}',
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
        td {
            padding:10px;
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
				<div style="float: right">RM 15.5 / PHCM</div>
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
		<div style="height:5px;background-color:black;width:100%;margin-bottom:70px;margin-top:-35px"></div>
		<center><h2>SKRINING GIZI “MST”</h2>
        <h4>(untuk dewasa)</h4></center><br><br>

        <table width="100%" border="1px">
            <tr>
                <th class="text-center">PERTANYAAN</th>
                <th class="text-center">SKOR</th>
            </tr>
            <tr>
                <td>
                Apakah pasien mengalami penurunan berat badan yang tidak direncanakan / tidak diinginkan dalam 6 bulan terakhir ? <br><br>
                <input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> class="selects" onchange="changed()" type="checkbox" value="0"> Tidak <br><br>
                <input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> class="selects" onchange="changed()" type="checkbox" value="2"> Tidak yakin (ada tanda baju menjadi lebih longgar) <br><br>
                <input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> type="checkbox" value="1"> Ya, ada penurunan berat badan sebanyak : <br><br>
                <div style="margin-left:50px"> 
                    <input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> class="selects" onchange="changed()" type="checkbox" value="1"> 1 – 5 Kg <br><br>
                    <input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> class="selects" onchange="changed()" type="checkbox" value="2"> 6 – 10 Kg <br><br>
                    <input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> class="selects" onchange="changed()" type="checkbox" value="3"> 11– 15 Kg <br><br>
                    <input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> class="selects" onchange="changed()" type="checkbox" value="4"> > 15 Kg <br><br>
                    <input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> class="selects" onchange="changed()" type="checkbox" value="2"> Tidak tahu berapa penurunannya
                </div>
                </td>
                <td class="text-center">
                    <br><br>
                    0 <br><br>
                    2 <br><br>
                    <br><br>
                    1<br><br>
                    2<br><br>
                    3<br><br>
                    4<br><br>
                    2
                </td>
            </tr>
            <tr>
                <td>
                Apakah asupan makan pasien berkurang karena penurunan nafsu makan / kesulitan menerima makanan ?
                <br><br>
                <input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> class="selects" onchange="changed()" type="checkbox" value="0"> Tidak <br><br>
                <input name="data_<?=$i;?>" <?=checked($arr_data[$i-1]);$i++;?> class="selects" onchange="changed()" type="checkbox" value="1"> Ya
                </td>
                <td class="text-center">
                    <br><br><br>
                    0 <br><br>
                    1 <br><br>
                </td>
            </tr>
            <tr>
                <th>TOTAL SKOR</th>
                <th class="text-center" id="total"></th>
            </tr>
            <tr>
                <td colspan="2">Bila skor ≥ 2, pasien beresiko malnutrisi, konsul keahli gizi</td>
            </tr>
                
        </table><br><br>

        <div class="row">
            <div class="col-6 text-center">
            Ahli gizi / dietesien <br><br><br><br><br>
            ( <?=input($arr_data[$i-1], "data_{$i}", "", "", "");$i++;?> )
            </div>
            <div class="col-6 text-center">
            Perawat yang melakukan skrining <br><br><br><br><br>
            ( <?php if(isset($_REQUEST['cetak']) || isset($_REQUEST['pdf'])): ?>
                <select style="display:none" name="cmbDokSemua" id="cmbDokSemua"></select>
                <?php echo mysql_fetch_assoc(mysql_query("SELECT nama FROM b_ms_pegawai WHERE id = {$data['id_user']}"))['nama']; ?>
              <?php else: ?>
                <select name="cmbDokSemua" id="cmbDokSemua"></select>
              <?php endif; ?> )
            </div>
        </div><br><br>
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

    function changed() {
    let checkboxes = document.querySelectorAll(".selects");
    let total = 0;

    for (var i = 0; i < checkboxes.length; i++) {
      if (checkboxes[i].checked) {
		  total += parseInt(checkboxes[i].value);
      }
    }
		document.getElementById("total").innerHTML = total;
	}
	
	<?php if (isset($_REQUEST["pdf"])): ?>
        let identifier = '<?=$dataPasien['nama']?>';
         printPDF('RM 15.5 '+identifier);
    <?php endif; ?>
	</script>
</body>

</html>