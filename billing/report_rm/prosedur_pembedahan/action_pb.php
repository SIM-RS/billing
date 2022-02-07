<?php
	include("../../koneksi/konek.php");
	function satu($a,$b){
		switch($a){
			case 'ugdlengkap': $n = 5;
						break;
		}
		for($i=1;$i<=$n;$i++){
			if($b[$i] == 1){
				if($i != $n){
					$result .= $b[$i].",";
				} else {
					$result .= $b[$i];
				}
			} else {
				if($i != $n){
					$result .= "0,";
				} else {
					$result .= "0";
				}
			}
		}
		return $result;
	}
	
	function tanggal($a){
		if($a != ''){
			$tglA = explode('-',$a);
			$tglH = $tglA[2].'-'.$tglA[1].'-'.$tglA[0];
		}
		return $tglH;
	}
	
	function isiData($a,$b){
		$idx = explode('|',$b);
		if($a == 1){
			$isiAkhir = $a.'|'.$_REQUEST[$idx[0]].'|'.$_REQUEST[$idx[1]];
		} else {
			$isiAkhir = '0||';
		}
		return $isiAkhir;
	}
	$datetime = date("Y-m-d H:i:s");
	$idKunj = $_REQUEST['idKunjBedah'];
	$idPel = $_REQUEST['idPelBedah'];
	$inap = $_REQUEST['inapBedah'];
	$idUser = $_REQUEST['idUserBedah'];
	$idBedah = $_REQUEST['idBedah'];
	$act = $_REQUEST['actBedah'];
	
	/* $sql = "select idBedah from b_form_prosedur_bedah where pelayanan_id = '$idPel' AND kunjungan_id = '$idKunj' AND idBedah = $idBedah";
	$cek = mysql_num_rows(mysql_query($sql)); */
	
	$operasi = $_REQUEST['operasi'];
	$tglawal = explode('-',$_REQUEST['tgl_operasi']);
	$tgloperasi = $tglawal[2].'-'.$tglawal[1].'-'.$tglawal[0];
	$jenisOperasi = $_REQUEST['jenisKotor'].'|'.$_REQUEST['jenisBesar'];
	$preOperasi = $_REQUEST['preOperasi'];
	$LamaOperasi = $_REQUEST['durasi'];
	$ILO = isiData($_REQUEST['ILO'],'hariILO|tglILO');
	$ISK = isiData($_REQUEST['ISK'],'hariISK|tglISK');
	$ILI = isiData($_REQUEST['ILI'],'hariILI|tglILI');
	$VAP = isiData($_REQUEST['VAP'],'hariVAP|tglVAP');
	$bakteri = isiData($_REQUEST['bakteri'],'haribakteri|tglbakteri');
	$bitus = isiData($_REQUEST['bitus'],'haribitus|tglbitus');	
	$idSubBedah = $_REQUEST['idSubBedah'];
	$idNo = $_REQUEST['idNo'];
	$tglBalutan = $_REQUEST['tglBalutan'];
	$GantiBalutan = $_REQUEST['GantiBalutan'];
	$ketBalutan = $_REQUEST['ketBalutan'];
	$namaBalutan = $_REQUEST['namaBalutan'];
	$idDel = $_REQUEST['idDel'];
	$type = $_REQUEST['type'];
	
	//print_r($tglBalutan);
	
	switch($type){
	case 'delete':
		$sqlUtama = "delete from b_form_prosedur_bedah where idBedah = $idBedah";
		$sqlSub = "delete from b_form_sub_prosedur_bedah where idBedah = $idBedah";
		
		$DelUtama = mysql_query($sqlUtama);
		$DelSub = mysql_query($sqlSub);
	break;
	}
	
	switch($act){
	case 'save':
		$sql = "insert into b_form_prosedur_bedah values(NULL, '$idPel', '$idKunj', '$operasi', '$tgloperasi', '$jenisOperasi', '$preOperasi', '$LamaOperasi', '$ILO', '$ISK', '$ILI', '$VAP', '$bakteri', '$bitus', '$datetime', '$idUser')";
		$hasil = mysql_query($sql);
		$idBaru = mysql_insert_id();
		$n = count($idNo);
		for($i=0;$i<=($n-1);$i++){
			$sql = "insert into b_form_sub_prosedur_bedah values(NULL, '".tanggal($tglBalutan[$idNo[$i]])."', '".$GantiBalutan[$idNo[$i]]."', '".$ketBalutan[$idNo[$i]]."', '".$namaBalutan[$idNo[$i]]."','$idBaru')";
			//echo $sql."<br/>";
			$hasilSub = mysql_query($sql);
		}
	break;
	case 'update':
		$sql = "UPDATE b_form_prosedur_bedah
			    SET
					operasi = '$operasi',
					tglOperasi = '$tgloperasi',
					JenisOperasi = '$jenisOperasi',
					PreOperasi = '$preOperasi',
					LamaOperasi = '$LamaOperasi',
					ILO = '$ILO',
					ISK = '$ISK',
					ILI = '$ILI',
					VAP = '$VAP',
					Bakteri = '$bakteri',
					Dekubitus = '$bitus',
					tgl_act = '$datetime',
					user_act = '$idUser'
				WHERE
					idBedah = $idBedah";
		$hasil = mysql_query($sql);
		if($idDel != ''){
			$idDel = substr($idDel,0,strlen($idDel)-1);
			$sqlDel = "Delete FROM b_form_sub_prosedur_bedah WHERE idSubBedah IN ($idDel)";
			$hasilDel = mysql_query($sqlDel);
		}
		$n = count($idNo);
		for($i=0;$i<=($n-1);$i++){
			if($idSubBedah[$i] == ''){
				$sqlInsert = "insert into b_form_sub_prosedur_bedah values(NULL, '".tanggal($tglBalutan[$idNo[$i]])."', '".$GantiBalutan[$idNo[$i]]."', '".$ketBalutan[$idNo[$i]]."', '".$namaBalutan[$idNo[$i]]."','$idBedah')";
				$hasilInsert = mysql_query($sqlInsert);
			} else {
				$sqlUpdate = "update b_form_sub_prosedur_bedah
							   set
								tglBalutan = '".tanggal($tglBalutan[$idNo[$i]])."',
								balutan = '".$GantiBalutan[$idNo[$i]]."',
								keterangan = '".$ketBalutan[$idNo[$i]]."',
								namaJelas = '".$namaBalutan[$idNo[$i]]."'
							   where idSubBedah = '".$idSubBedah[$i]."'";
				$hasilUpdate = mysql_query($sqlUpdate);
			}
		}
	break;
}
if($hasil){
	echo "sukses";
}else{
	echo "gagal";
}
?>