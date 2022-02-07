<?php
	session_start();
	include("../koneksi/konek.php");
	include("../is_mobile.php");
	$iduser = $_SESSION["iduser"];
	$iduser_jual = $_REQUEST["iduser_jual"];
	$tglact=gmdate('d/m/Y H:i:s',mktime(date('H')+7));
	$tglNow=gmdate('d-m-Y',mktime(date('H')+7));
	
	$idunit=$_GET["sunit"];
	$no_penjualan=$_GET['no_penjualan'];
	$no_pasien=$_GET['no_pasien'];
	if($_REQUEST['bayar'] == '1'){
		$bayar = '1';
	} else {
		$bayar = '0';
	}
	$mobile = $_REQUEST['mobile'];
	$viewdel='true'; //$_GET['viewdel'];
	if ($iduser!=1510 && $iduser!=732 && $iduser!=1512) $viewdel="false";
	$tgl=$_GET['tgl'];
	$u="select UNIT_NAME from a_unit where UNIT_ID=$idunit";
	$rsu=mysqli_query($konek,$u) or die(mysqli_error($konek));
	$row=mysqli_fetch_array($rsu);
	$apname=$row['UNIT_NAME'];
	
	$shft = $_REQUEST['SHIFT'];
	$isMobile = ismobile();
	if($isMobile == '1'){
		$sMob = "INSERT INTO a_penjualan_mobile (NO_RM, UNIT_ID, NO_PENJUALAN, TGL_PENJUALAN, USER_ID, SHIFT)
				VALUES ('{$no_pasien}', '{$idunit}', '{$no_penjualan}', '{$tgl}', '{$iduser}', '{$shft}');";
		$qMob = mysqli_query($konek,$sMob) or die(mysqli_error($konek)." - Proses Mobile");
	}
	
	if ($iduser_jual!=""){
		$sql="SELECT ap.*
				FROM a_penjualan ap
				INNER JOIN a_return_penjualan rp
				   ON rp.idpenjualan = ap.ID
				LEFT JOIN a_kredit_utang ku
				   ON ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN
				  and ku.UNIT_ID = ap.UNIT_ID
				WHERE ap.UNIT_ID=$idunit 
					AND ap.QTY_RETUR>0 
					AND ap.NO_PENJUALAN='$no_penjualan' 
					AND ap.NO_PASIEN='$no_pasien' 
					AND ap.TGL='$tgl' 
					AND ap.USER_ID=$iduser_jual
					AND IFNULL(ku.TGL_BAYAR, ap.TGL_ACT) > rp.tgl_retur";
	}else{
		$sql="SELECT ap.*
				FROM a_penjualan ap
				INNER JOIN a_return_penjualan rp
				   ON rp.idpenjualan = ap.ID
				LEFT JOIN a_kredit_utang ku
				   ON ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN
				  and ku.UNIT_ID = ap.UNIT_ID
				WHERE ap.UNIT_ID=$idunit 
					AND ap.QTY_RETUR>0 
					AND ap.NO_PENJUALAN='$no_penjualan' 
					AND ap.NO_PASIEN='$no_pasien' 
					AND ap.TGL='$tgl'
					AND IFNULL(ku.TGL_BAYAR, ap.TGL_ACT) > rp.tgl_retur";
	}
	//echo $sql;
	$rs=mysqli_query($konek,$sql);
	$ada_retur=mysqli_num_rows($rs);
	$retur='';

	if ($rows=mysqli_fetch_array($rs)){
		$retur=$rows['NO_RETUR'];
		$tglretur=date("d/m/Y H:i",strtotime($rows['TGL_RETUR']));
	}
	
	function kekata($x) {
		$x = abs($x);
		$angka = array("", "satu", "dua", "tiga", "empat", "lima",
		"enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($x <12) {
		  $temp = " ". $angka[$x];
		} else if ($x <20) {
		  $temp = kekata($x - 10). " belas";
		} else if ($x <100) {
		  $temp = kekata($x/10)." puluh". kekata($x % 10);
		} else if ($x <200) {
		  $temp = " seratus" . kekata($x - 100);
		} else if ($x <1000) {
		  $temp = kekata($x/100) . " ratus" . kekata($x % 100);
		} else if ($x <2000) {
		  $temp = " seribu" . kekata($x - 1000);
		} else if ($x <1000000) {
		  $temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
		} else if ($x <1000000000) {
		  $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
		} else if ($x <1000000000000) {
		  $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
		} else if ($x <1000000000000000) {
		  $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
		}      
		return $temp;
	}
	function terbilang($x, $style=4) {
		if($x<0) {
		  $hasil = "minus ". trim(kekata($x));
		} else {
		  $hasil = trim(kekata($x));
		}      
		switch ($style) {
		  case 1:
			  $hasil = strtoupper($hasil);
			  break;
		  case 2:
			  $hasil = strtolower($hasil);
			  break;
		  case 3:
			  $hasil = ucwords($hasil);
			  break;
		  default:
			  $hasil = ucfirst($hasil);
			  break;
		}      
		return $hasil;
	}
?>
<html>
<head>
	<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<style type="text/css">
		#kott{
			border:1px solid #000;
			padding:5px;
			position:absolute;
			top:12px;
			right:5px;
		}
		#content{
			width:260px;
			
		}
		#head-content{
			width:100%;
			margin-bottom:5px;
			
		}
		#head-content-detil{
			width:100%;
			margin-bottom:5px;
		}
		#head-content-left, #head-content-right{
			width:50%;
			max-width:50%;
			margin-bottom:5px;
		}
		#head-content-left{
			float:left;
		}
		#head-content-right{
			float:right;
			text-align:right;
		}
		.clear{
			clear:both;
		}
		#head-table{
			border-collapse:collapse;
			margin-bottom:5px;
			padding:0px;			width:100%;

		}
		.border{
			border-top:1px solid #000;
			border-bottom:1px solid #000;
		}
		.border-top{
			border-top:1px solid #000;
		}
		.border-bottom{
			border-bottom:1px solid #000;
		}
		.border-dashed{
			border-bottom:1px dashed #000;
		}
	</style>
	<script type="text/JavaScript">
		var applet = null;
		
		function jzebraReady() {}

		function jzebraDoneFinding() {}
		
		function jzebraDonePrinting() {
		   if (applet.getException() != null) {
			  return alert('Error:' + applet.getExceptionMessage());
		   }
		   window.close();
		}
		
		function deteksiPrinter() {	    
			 applet = document.jzebra;
			 if (applet != null) {           
				applet.findPrinter();
				applet.getPrinter();
				applet.setEncoding("UTF-8");
			 }
		}
		
		function printz(){
			//var applet = document.jzebra;
			if (applet != null) {			
				<?php 	
					printHeader();					
					$hasil = printDataObat();					
					printFooter($hasil);
					
					function printHeader(){	
						global $konek;
						$unit = $_REQUEST["sunit"];
						$iduser_jual = $_REQUEST["iduser_jual"];
						$qnamaUnit="select UNIT_NAME from a_unit where UNIT_ID=$unit";
						$hasil=mysqli_query($konek,$qnamaUnit);
						$rowDataUnit=mysqli_fetch_array($hasil);
						$namaUnit=$rowDataUnit['UNIT_NAME'];
						
						$noPenjualan = $_REQUEST['no_penjualan'];
						$noPasien = $_REQUEST['no_pasien'];
						$tanggal = $_REQUEST['tgl'];
						if($_REQUEST['bayar'] == '1'){
							$bayar = '1';
						} else {
							$bayar = '0';
						}
						/* if ($iduser_jual!=""){
							$qSingle="SELECT a_penjualan.*,a_mitra.NAMA AS kso_nama,a_kepemilikan.NAMA,a_user.username,UNIT_NAME,a_cara_bayar.nama as cb from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_unit on a_unit.UNIT_ID=a_penjualan.RUANGAN Left Join a_user on a_penjualan.USER_ID=a_user.kode_user LEFT JOIN a_mitra ON a_penjualan.KSO_ID=a_mitra.IDMITRA left join a_cara_bayar on a_penjualan.cara_bayar=a_cara_bayar.id WHERE a_penjualan.NO_PENJUALAN='$noPenjualan' and a_penjualan.UNIT_ID=$unit AND a_penjualan.NO_PASIEN='$noPasien' AND a_penjualan.TGL='$tanggal' AND a_penjualan.USER_ID=$iduser_jual";
						}else{
							$qSingle="SELECT a_penjualan.*,a_mitra.NAMA AS kso_nama,a_kepemilikan.NAMA,a_user.username,UNIT_NAME,a_cara_bayar.nama as cb from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_unit on a_unit.UNIT_ID=a_penjualan.RUANGAN Left Join a_user on a_penjualan.USER_ID=a_user.kode_user LEFT JOIN a_mitra ON a_penjualan.KSO_ID=a_mitra.IDMITRA left join a_cara_bayar on a_penjualan.cara_bayar=a_cara_bayar.id WHERE a_penjualan.NO_PENJUALAN='$noPenjualan' and a_penjualan.UNIT_ID=$unit AND a_penjualan.NO_PASIEN='$noPasien' AND a_penjualan.TGL='$tanggal'";
						} */
						
						if ($iduser_jual!=""){
							$qSingle="SELECT a_penjualan.*,a_mitra.NAMA AS kso_nama,a_kepemilikan.NAMA,a_user.username,UNIT_NAME,a_cara_bayar.nama as cb, a_cara_bayar.id as cb_id from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_unit on a_unit.UNIT_ID=a_penjualan.RUANGAN Left Join a_user on a_penjualan.USER_ID=a_user.kode_user LEFT JOIN a_mitra ON a_penjualan.KSO_ID=a_mitra.IDMITRA left join a_cara_bayar on a_penjualan.cara_bayar=a_cara_bayar.id WHERE a_penjualan.NO_PENJUALAN='$noPenjualan' and a_penjualan.UNIT_ID=$unit AND a_penjualan.NO_PASIEN='$noPasien' AND a_penjualan.TGL='$tanggal' AND a_penjualan.USER_ID=$iduser_jual";
						}else{
							$qSingle="SELECT a_penjualan.*,a_mitra.NAMA AS kso_nama,a_kepemilikan.NAMA,a_user.username,UNIT_NAME,a_cara_bayar.nama as cb, a_cara_bayar.id as cb_id from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_unit on a_unit.UNIT_ID=a_penjualan.RUANGAN Left Join a_user on a_penjualan.USER_ID=a_user.kode_user LEFT JOIN a_mitra ON a_penjualan.KSO_ID=a_mitra.IDMITRA left join a_cara_bayar on a_penjualan.cara_bayar=a_cara_bayar.id WHERE a_penjualan.NO_PENJUALAN='$noPenjualan' and a_penjualan.UNIT_ID=$unit AND a_penjualan.NO_PASIEN='$noPasien' AND a_penjualan.TGL='$tanggal'";
						}
						
						$rSingle = mysqli_query($konek,$qSingle);
						$rowSingle = mysqli_fetch_array($rSingle);
						
						if ($iduser_jual!=""){
							$sql="SELECT * 
									FROM a_penjualan 
									WHERE UNIT_ID=$unit AND QTY_RETUR>0 
										AND NO_PENJUALAN='$noPenjualan'
										AND NO_PASIEN='$noPasien' 
										AND TGL='$tanggal' 
										AND USER_ID=$iduser_jual";
						}else{
							$sql="SELECT * 
									FROM a_penjualan 
									WHERE UNIT_ID=$unit AND QTY_RETUR>0 
										AND NO_PENJUALAN='$noPenjualan' 
										AND NO_PASIEN='$noPasien' 
										AND TGL='$tanggal'";
						}

						$rs=mysqli_query($konek,$sql);
						$ada_retur=mysqli_num_rows($rs);
						
						$retur='';

						if ($rows=mysqli_fetch_array($rs)){
							$retur=$rows['NO_RETUR'];
							$tglretur=date("d/m/Y H:i",strtotime($rows['TGL_RETUR']));
						}
						
						echo "applet.append(\"\\x1B\\x40\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\"\\x1B\\x30\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\"\\x1B\\x67\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\"\\x1B\\x6C\\x01\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\"\\x1B\\x51\\x3C\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\"\\x1B\\x43\\x2C\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\"\\x1B\\x78\\x30\")"; echo chr(59);echo "\n\t\t\t";	
						echo "applet.append(\"\\n\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\"RS PELINDO\\n\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\"JL.Stasiun No. 95                 $namaUnit\\n\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\"----------------------------------------------------\\n\")"; echo chr(59);echo "\n\t\t\t";
						$noKwitansi = $rowSingle['NO_PENJUALAN'];
						
						/* if ($ada_retur>0){
							echo "applet.append(\"No. Retur     : $retur      Ref. Kwitansi : $noKwitansi\\n\")"; echo chr(59);echo "\n\t\t\t";
						}
						else { */
							//echo "applet.append(\"No. Penjualan/Tgl  : $noKwitansi/".date("d-m-Y",strtotime($showSingle['TGL']))." ".date("H:i",strtotime($showSingle['TGL_ACT']))."\\n\")"; echo chr(59);echo "\n\t\t\t";
						//}
						
						echo "applet.append(\"No.Penjualan  : $noKwitansi\\n\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\"Tgl.Penjualan : ".date("d-m-Y",strtotime($rowSingle['TGL']))." ".date("H:i",strtotime($rowSingle['TGL_ACT']))."/".$rowSingle['username']."\\n\")"; echo chr(59);echo "\n\t\t\t";
						$namaPasien = $rowSingle['NAMA_PASIEN'];
						$noPasien = $rowSingle['NO_PASIEN'];					
						echo "applet.append(\"Pasien/No. RM : $namaPasien/$noPasien\\n\")"; echo chr(59);echo "\n\t\t\t";
						$alamat = $rowSingle['ALAMAT'];
						echo "applet.append(\"Alamat        : $alamat\\n\")"; echo chr(59);echo "\n\t\t\t";
						$dokter = $rowSingle['DOKTER'];
						echo "applet.append(\"Dokter        : $dokter\\n\")"; echo chr(59);echo "\n\t\t\t";
						$ruang = $rowSingle['UNIT_NAME'];
						echo "applet.append(\"Ruang         : $ruang\\n\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\"----------------------------------------------------\\n\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\" No   Nama Obat                  Jumlah      Nilai  \\n\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\"----------------------------------------------------\\n\")"; echo chr(59);echo "\n\t\t\t";
					 }
					
					function printFooter($hasil) {	
						global $konek;
						// print_r($hasil);
						$iduser_jual = $_REQUEST["iduser_jual"];						
						$no_penjualan=$_GET['no_penjualan'];
						$no_pasien=$_GET['no_pasien'];		
						$unit = $_GET["sunit"];						
						$tanggal = $_GET['tgl'];
						$totPx = $hasil[2];
						$dijamin = $hasil[1];
						$ppn_nilai = $hasil[3];
						if($_REQUEST['bayar'] == '1'){
							$bayar = '1';
						} else {
							$bayar = '0';
						}
						if ($iduser_jual!=""){
							$sql="SELECT * FROM a_penjualan WHERE UNIT_ID=$unit AND QTY_RETUR>0 AND NO_PENJUALAN='$no_penjualan' AND NO_PASIEN='$no_pasien' AND TGL='$tanggal' AND USER_ID=$iduser_jual";
						}else{
							$sql="SELECT * FROM a_penjualan WHERE UNIT_ID=$unit AND QTY_RETUR>0 AND NO_PENJUALAN='$no_penjualan' AND NO_PASIEN='$no_pasien' AND TGL='$tanggal'";
						}	
						

						$cekretur=mysqli_query($konek,$sql);
						$ada_retur=mysqli_num_rows($cekretur);
						$retur="";
						
						if ($rows=mysqli_fetch_array($cekretur)){
							$retur=$rows['NO_RETUR'];
							$tglretur=date("d/m/Y H:i",strtotime($rows['TGL_RETUR']));
						}
													
						/* if($ada_retur){ 
							echo "applet.append(\"             Nilai sebelum retur      : "; 
						}
						else
						{ */
							echo "applet.append(\"                   Total              : "; 
						//}
						
						$nilaai = $hasil[0];
						$nilai_sebelum_retur = number_format($nilaai,0,",","."); 
						$spasiNilaiTotal = 12 - strlen((string)$nilai_sebelum_retur);	
						
						for($j=0;$j<$spasiNilaiTotal;$j++){
									echo " ";
						}
						echo "$nilai_sebelum_retur"; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";	
						
						if($ppn_nilai > 0){
							echo "applet.append(\"                 PPN 10%              : "; 
							$nilai_ppn = number_format($ppn_nilai,0,",","."); 
							$spasiNilaiTotal = 12 - strlen((string)$nilai_ppn);	
							
							for($j=0;$j<$spasiNilaiTotal;$j++){
										echo " ";
							}
							echo $nilai_ppn; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";	
							
							echo "applet.append(\"             Nilai Total              : "; 
							$total_nilai_ppn = number_format(($nilaai+$ppn_nilai),0,",","."); 
							$spasiNilaiTotal = 12 - strlen((string)$total_nilai_ppn);	
							
							for($j=0;$j<$spasiNilaiTotal;$j++){
										echo " ";
							}
							echo $total_nilai_ppn; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";	
						}
						
						if($dijamin == '1'){
							echo "applet.append(\"             Dijamin KSO              : "; 
							$nilaai = $hasil[0];
							$nilai_sebelum_retur = number_format(($nilaai-$totPx),0,",","."); 
							$spasiNilaiTotal = 12 - strlen((string)$nilai_sebelum_retur);	
							
							for($j=0;$j<$spasiNilaiTotal;$j++){
										echo " ";
							}
							echo "$nilai_sebelum_retur"; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";
							
							echo "applet.append(\"             Tagihan Pasien           : "; 
							$nilaai = $hasil[0];
							$nilai_sebelum_retur = number_format($totPx,0,",","."); 
							$spasiNilaiTotal = 12 - strlen((string)$nilai_sebelum_retur);	
							
							for($j=0;$j<$spasiNilaiTotal;$j++){
										echo " ";
							}
							echo "$nilai_sebelum_retur"; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";
						}
			
												
						echo "applet.append(\"----------------------------------------------------\\n\")"; echo chr(59);echo "\n\t\t\t";
						
						
						$qnamaUnit="select UNIT_NAME from a_unit where UNIT_ID=$unit";
						$hasil=mysqli_query($konek,$qnamaUnit);
						$rowDataUnit=mysqli_fetch_array($hasil);
						$namaUnit=$rowDataUnit['UNIT_NAME'];		
						
				
						if ($iduser_jual!=""){
							$qrySingle="SELECT a_penjualan.*,a_mitra.NAMA AS kso_nama,a_kepemilikan.NAMA,a_user.username,UNIT_NAME,a_cara_bayar.nama as cb, a_cara_bayar.id as cb_id, a_penjualan.KRONIS from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_unit on a_unit.UNIT_ID=a_penjualan.RUANGAN Left Join a_user on a_penjualan.USER_ID=a_user.kode_user LEFT JOIN a_mitra ON a_penjualan.KSO_ID=a_mitra.IDMITRA left join a_cara_bayar on a_penjualan.cara_bayar=a_cara_bayar.id WHERE a_penjualan.NO_PENJUALAN='$no_penjualan' and a_penjualan.UNIT_ID=$unit AND a_penjualan.NO_PASIEN='$no_pasien' AND a_penjualan.TGL='$tanggal' AND a_penjualan.USER_ID=$iduser_jual";
						}else{
							$qrySingle="SELECT a_penjualan.*,a_mitra.NAMA AS kso_nama,a_kepemilikan.NAMA,a_user.username,UNIT_NAME,a_cara_bayar.nama as cb, a_cara_bayar.id as cb_id, a_penjualan.KRONIS from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_unit on a_unit.UNIT_ID=a_penjualan.RUANGAN Left Join a_user on a_penjualan.USER_ID=a_user.kode_user LEFT JOIN a_mitra ON a_penjualan.KSO_ID=a_mitra.IDMITRA left join a_cara_bayar on a_penjualan.cara_bayar=a_cara_bayar.id WHERE a_penjualan.NO_PENJUALAN='$no_penjualan' and a_penjualan.UNIT_ID=$unit AND a_penjualan.NO_PASIEN='$no_pasien' AND a_penjualan.TGL='$tanggal'";
						}
						//echo $qrySingle;
						//mysqli_free_result($exeSingle);
						$exeSingle=mysqli_query($konek,$qrySingle);	
						$showSingle=mysqli_fetch_array($exeSingle);
						//echo "<br /><br /> -".$showSingle['cb_id']."<br /><br />";
						if($bayar == '1' || $showSingle['cb_id'] == '1'){
							$sBayar_ = "SELECT 
										  ap.NO_PASIEN noRM,
										  IFNULL(ku.NO_BAYAR,ap.NO_PENJUALAN) no_bayar,
										  ap.NO_PENJUALAN no_penjualan,
										  IFNULL(IF(ku.BAYAR<>0,ku.BAYAR,ku.BAYAR_UTANG),ap.HARGA_TOTAL) bayar_,
										  ku.BAYAR bayar,
										  IFNULL(ku.KEMBALI,0) kembali
										FROM
										  a_penjualan ap
										LEFT JOIN (SELECT ku2.FK_NO_PENJUALAN, SUM(ku2.BAYAR_UTANG) BAYAR_UTANG, ku2.BAYAR, ku2.KEMBALI, ku2.NORM, ku2.NO_BAYAR, 
														ku2.NO_PELAYANAN, ku2.TGL_BAYAR, ku2.TOTAL_HARGA, ku2.UNIT_ID, ku2.USER_ID, ku2.CARA_BAYAR
													FROM a_kredit_utang ku2
													WHERE ku2.FK_NO_PENJUALAN = '{$no_penjualan}'
														AND ku2.UNIT_ID = '{$unit}'
													GROUP BY ku2.FK_NO_PENJUALAN, ku2.UNIT_ID) ku
										   ON ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN
										  and ku.UNIT_ID = ap.UNIT_ID
										WHERE ap.NO_PENJUALAN = '{$no_penjualan}' 
										  AND ap.UNIT_ID = '{$unit}'
										  AND ap.TGL = '{$tanggal}'
										  AND ap.CARA_BAYAR NOT IN (2,4)
										GROUP BY ap.NO_PENJUALAN";
										
							$sBayar = "SELECT ap.NO_PASIEN noRM,
										  IFNULL(ku.NO_BAYAR, ap.NO_PENJUALAN) no_bayar,
										  ap.NO_PENJUALAN no_penjualan,
										  IFNULL(
											IF(
											  ku.BAYAR <> 0,
											  ku.BAYAR,
											  ku.BAYAR_UTANG
											),
											ap.HARGA_TOTAL
										  ) bayar_,
										  ku.BAYAR bayar,
										  IFNULL(ku.KEMBALI, 0) kembali 
										FROM a_penjualan ap
										LEFT JOIN a_kredit_utang ku
										   ON ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN
										  AND DATE(ku.TGL_BAYAR) = DATE(ap.TGL_BAYAR_ACT)
										  AND ku.NORM = ap.NO_PASIEN
										  AND ku.NO_PELAYANAN = ap.NO_KUNJUNGAN
										WHERE ap.NO_PENJUALAN = '{$no_penjualan}'
										  AND ap.UNIT_ID = '{$unit}'
										  AND ap.TGL = '{$tanggal}'
										  AND ap.CARA_BAYAR NOT IN (2, 4)
										GROUP BY ap.NO_PENJUALAN";
							//echo $sBayar."<br /><br />";
							$qBayar = mysqli_query($konek,$sBayar);
							$dBayar = mysqli_fetch_array($qBayar);
							
							echo "applet.append(\"                   Bayar              : "; 
							$nilai_bayar = number_format($dBayar['bayar_'],0,",","."); 
							$spasiNilaiBayar = 12 - strlen((string)$nilai_bayar);	
							for($j=0;$j<$spasiNilaiBayar;$j++){
										echo " ";
							}
							echo $nilai_bayar; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";
							
							echo "applet.append(\"                 Kembali              : "; 
							//$dBayar['kembali']
							$nilai_kembali = number_format(($dBayar['bayar_']-$nilaai),0,",","."); 
							$spasiNilaiKembali = 12 - strlen((string)$nilai_kembali);	
							
							for($j=0;$j<$spasiNilaiKembali;$j++){
										echo " ";
							}
							echo $nilai_kembali; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";
						}
						echo "applet.append(\"\\n\")"; echo chr(59); echo "\n\t\t\t";
						$status = $showSingle['kso_nama'];/* ."/".$showSingle['cb'];   */  
						if($showSingle['cb_id'] == '2' || $showSingle['cb_id'] == '4'){
							echo "applet.append(\"Status : $status";
							if($showSingle['KRONIS'] == '2'){
								echo " / PAKET";
							} else if($showSingle['KRONIS'] == '1'){
								echo " / KRONIS";
							}
							echo "\\n\")";
							echo chr(59); echo "\n\t\t\t";
						}
					
						
						if($bayar == '1' || $showSingle['cb_id'] == '1') {
							$join = "";
							$where_byr = $where = "AND ap.CARA_BAYAR NOT IN (2,4)";
							$select_byr = "IFNULL(bp.no_bayar, CONCAT('PY/',ap.NO_PENJUALAN)) nomer,
											IFNULL(bp.user_act,ap.USER_ID) userID,
											DATE_FORMAT(IFNULL(bp.tgl_act,ap.TGL_ACT),'%d-%m-%Y %H:%i:%s') tgl";
			
				
							
							$sql = "SELECT ku.NO_BAYAR nomer, DATE_FORMAT(ku.TGL_BAYAR,'%d-%m-%Y %H:%i:%s') tgl, u.username
							FROM a_kredit_utang ku
							INNER JOIN a_penjualan ap
							   ON ap.NO_PENJUALAN = ku.FK_NO_PENJUALAN
							  AND ap.NO_KUNJUNGAN = ku.NO_PELAYANAN
							  AND ap.UNIT_ID = ku.UNIT_ID
							  AND DATE(ku.TGL_BAYAR) = DATE(ap.TGL_BAYAR_ACT)
							  /*AND ap.TGL_ACT <= ku.TGL_BAYAR*/
							INNER JOIN a_user u
							   ON u.kode_user = ku.USER_ID
							WHERE ku.FK_NO_PENJUALAN = '{$no_penjualan}' 
							  AND ap.UNIT_ID = '{$unit}'
							  AND ap.TGL = '{$tanggal}'";
							$query = mysqli_query($konek,$sql);
							$dQuery = mysqli_fetch_array($query);
							if($dQuery['nomer'] == ""){
								$sql = "SELECT ap.NO_PENJUALAN nomer, DATE_FORMAT(ap.TGL_ACT,'%d-%m-%Y %H:%i:%s') tgl, u.username
										FROM a_penjualan ap
										INNER JOIN a_user u
										   ON u.kode_user = ap.USER_ID
										WHERE ap.NO_PENJUALAN = '{$no_penjualan}'
										  AND ap.UNIT_ID = '{$unit}'
										  AND ap.TGL = '{$tanggal}'";
								$query = mysqli_query($konek,$sql);
								$dQuery = mysqli_fetch_array($query);
							}
							
							$detil_ = $dQuery['nomer']." / ".$dQuery['tgl']." / ".$dQuery['username'];
							$spasiDetil_ = 50 - strlen((string)$detil_);
							$kosong_ = "";
							for($j=0;$j<$spasiDetil_;$j++){
								$kosong_ .= " ";
							}
							echo "applet.append(\"- ".$detil_.$kosong_." -\\n\")";
							echo chr(59); echo "\n\t\t\t";
							
						}
						
						if($showSingle['cb_id'] == '1' || $bayar == '1'){
							echo "applet.append(\"- Bukti Pembayaran ini juga berlaku sebagai kwitansi -\\n\")"; 		
							echo chr(59); echo "\n\t\t\t";
						}
						echo "applet.append(\"\\x0C\")"; echo chr(59); echo "\n\t\t\t";         //FF
						echo "applet.append(\"\\x1B\\x40\")"; echo chr(59); echo "\n\t\t\t";
						
						echo "applet.print()"; echo chr(59); 
					 }
					
					function printDataObat() {
						global $konek;
						$noPenjualan = $_GET['no_penjualan'];
						$unit = $_GET["sunit"];
						$noPasien = $_GET['no_pasien'];
						$tanggal = $_GET['tgl'];
						$harga_total=0;
						$nilai_retur=0;
						$totPx_ = 0;
						$dijamin = 0;
						$iduser_jual = $_REQUEST["iduser_jual"];
						
				
						
						if ($iduser_jual!=""){
						
							
							$sqlObat = "SELECT NO_PENJUALAN, TGL_ACT, NO_KUNJUNGAN, NO_PASIEN, NAMA_PASIEN, JENIS_PASIEN_ID, o.OBAT_NAMA,
									  o.OBAT_SATUAN_KECIL, SUM(ap.QTY_JUAL*ap.HARGA_SATUAN) total_awal, SUM(ap.QTY_JUAL*ap.HARGA_SATUAN) total_px,
									  SUM(ap.QTY_RETUR*ap.HARGA_SATUAN) total_retur,
									  SUM(ap.QTY) AS QTY, SUM(ap.QTY_JUAL) AS QTY_JUAL, SUM(ap.QTY_RETUR) AS QTY_RETUR, ap.DIJAMIN, ap.PPN_NILAI
									FROM
									  a_penjualan ap
									  INNER JOIN a_penerimaan a_p
										ON ap.PENERIMAAN_ID = a_p.ID 
									  INNER JOIN a_obat o
										ON a_p.OBAT_ID = o.OBAT_ID 
									WHERE ap.NO_PENJUALAN = '{$noPenjualan}' 
									  AND ap.UNIT_ID = '{$unit}' 
									  AND ap.NO_PASIEN = '{$noPasien}' 
									  AND ap.TGL = '{$tanggal}' 
									  AND ap.USER_ID = '{$iduser_jual}' 
									GROUP BY ap.NO_PENJUALAN, o.OBAT_ID
									ORDER BY ap.ID";
						}else{
							
							
							$sqlObat = "SELECT NO_PENJUALAN, TGL_ACT, NO_KUNJUNGAN, NO_PASIEN, NAMA_PASIEN, JENIS_PASIEN_ID, o.OBAT_NAMA,
									  o.OBAT_SATUAN_KECIL, SUM(ap.QTY_JUAL*ap.HARGA_SATUAN) total_awal, SUM(ap.QTY_JUAL*ap.HARGA_SATUAN) total_px,
									  SUM(ap.QTY_RETUR*ap.HARGA_SATUAN) total_retur,
									  SUM(ap.QTY) AS QTY, SUM(ap.QTY_JUAL) AS QTY_JUAL, SUM(ap.QTY_RETUR) AS QTY_RETUR, ap.DIJAMIN, ap.PPN_NILAI
									FROM
									  a_penjualan ap
									  INNER JOIN a_penerimaan a_p
										ON ap.PENERIMAAN_ID = a_p.ID 
									  INNER JOIN a_obat o
										ON a_p.OBAT_ID = o.OBAT_ID 
									WHERE ap.NO_PENJUALAN = '{$noPenjualan}' 
									  AND ap.UNIT_ID = '{$unit}' 
									  AND ap.NO_PASIEN = '{$noPasien}' 
									  AND ap.TGL = '{$tanggal}' 
									GROUP BY ap.NO_PENJUALAN, o.OBAT_ID
									ORDER BY ap.ID";
						}
						
						//echo $sqlObat;
						$resultObat=mysqli_query($konek,$sqlObat);
						$k=mysqli_num_rows($resultObat);
						$i=0;					
						
						if ($iduser_jual!=""){
							$sql="SELECT * FROM a_penjualan WHERE UNIT_ID=$unit AND QTY_RETUR>0 AND NO_PENJUALAN='$noPenjualan' AND NO_PASIEN='$noPasien' AND TGL='$tanggal' AND USER_ID=$iduser_jual";
						}else{
							$sql="SELECT * FROM a_penjualan WHERE UNIT_ID=$unit AND QTY_RETUR>0 AND NO_PENJUALAN='$noPenjualan' AND NO_PASIEN='$noPasien' AND TGL='$tanggal'";
						}
						//echo $sql."----------------------------------";
						$rs=mysqli_query($konek,$sql);
						$ada_retur=mysqli_num_rows($rs);
						$ppn_nilai = $adaSisaNamaObat = 0;
						
						while ($k > 0){			//untuk cek jumlah halaman
							/* if ($ada_retur){
								//$k -= 18;
								$baris = 18;
							}
							else { */
								//$k -= 20;
								$baris = 15;
							//}
							while($baris > 0 && $k > 0){
								$showPrint = mysqli_fetch_array($resultObat);
								$ppn_nilai = $showPrint['PPN_NILAI'];
								$i++;
								$k--;
								$no= (string)$i;
								$baris--;
								//lebar field no = 6 
								if( strlen($no) == 2 ){					//jika panjang nomer = 2 digit
									echo "applet.append(\" $no.  "; 
								} 
								else {									//jika panjang nomer = 1 digit
									echo "applet.append(\"  $no.  ";
								}
								//lebar field Nama obat 26
								$namaObat = $showPrint['OBAT_NAMA'];
								$spasiNamaObat = 26 - strlen($namaObat);		//cek panjang obat					
								
								//lebar field jumlah obat 7
								$jumlahJual = $showPrint['QTY_JUAL'];
								$jumlahRetur = $showPrint['QTY_RETUR'];
								$jumlah = $showPrint['QTY_JUAL']; //$showPrint['QTY'];
								//lebar field nilai 12					
								
													//tidak ada retur
									if ($spasiNamaObat>=0){		//nama obat tidak melebihi panjang kolom
										echo "$namaObat";  
										for($j=0;$j<$spasiNamaObat;$j++){
											echo " ";
										}
										$spasiJumlahObat = 7 - strlen($jumlah);
										for($j=0;$j<$spasiJumlahObat;$j++){
											echo " ";
										}
										echo "$jumlah ";
										
										$nilai = $showPrint['total_awal']; //$jumlahJual * $showPrint['HARGA_SATUAN'];
										$totPx_ += $showPrint['total_px'];
										$harga_total += $nilai;
										$nilai = number_format($nilai,0,',','.');
										$spasiNilai = 12 - strlen($nilai);
										for($j=0;$j<$spasiNilai;$j++){
											echo " ";
										}
										echo $nilai; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";	
									} 
									else{						//nama obat melebihi panjang kolom
										$baris--;
										$pecahNamaObat = str_split($namaObat, 26);
										
										echo $pecahNamaObat[0];
										$spasiJumlahObat = 7 - strlen($jumlah);
										for($j=0;$j<$spasiJumlahObat;$j++){
											echo " ";
										}
										echo "$jumlah ";
										$nilai = $showPrint['total_awal']; //$jumlahJual * $showPrint['HARGA_SATUAN'];
										$totPx_ += $showPrint['total_px'];
										$harga_total += $nilai;
										$nilai = number_format($nilai,0,',','.');
										$spasiNilai = 12 - strlen($nilai);
										for($j=0;$j<$spasiNilai;$j++){
											echo " ";
										}
										echo $nilai; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";	
										if ($baris > 0){									
											echo "applet.append(\"      "; echo $pecahNamaObat[1]; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";
										}
										else
											$adaSisaNamaObat = 1;
									}
									$dijamin = $showPrint['DIJAMIN'];
								//}				
							}
							if($k>0){					//print lembar pertama								
								echo "applet.append(\"----------------------------------------------------\\n\")"; echo chr(59);echo "\n\t\t\t";
								echo "applet.append(\"\\x0C\")"; echo chr(59); echo "\n\t\t\t";         //FF
								echo "applet.append(\"\\x1B\\x40\")"; echo chr(59); echo "\n\t\t\t";
								echo "applet.print()"; echo chr(59);
								//print lembar berikutnya
								echo "applet.append(\"lanjutan\\n\")";	echo chr(59); echo "\n\t\t\t";
								printHeader();
								if($adaSisaNamaObat == 1){
									echo "applet.append(\"      "; echo $pecahNamaObat[1]; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";
									$adaSisaNamaObat = 0;
								}
							}
						}
												
						if ($baris>0) {			//tambah enter agar jumlah baris mencapai 20 baris
							for($j=0;$j<$baris;$j++){
								echo "applet.append(\"\\n\")"; echo chr(59); echo "\n\t\t\t";
							}							 
						}
						echo "applet.append(\"----------------------------------------------------\\n\")"; echo chr(59);echo "\n\t\t\t";
						$hasil = array($harga_total, $dijamin, $totPx_, $ppn_nilai);
						return $hasil;
					 }			
					
				?>  
			}
		}	
	</script>
	
</head>
<body onLoad="deteksiPrinter()">
	<applet name="jzebra" code="jzebra.PrintApplet.class" archive="./jzebra.jar" width="0px" height="0px"></applet>

<div id="idArea" style="display:block;">
		<?php	
			if ($iduser_jual!=""){
				$qrySingle="SELECT a_penjualan.*,a_mitra.NAMA AS kso_nama,a_kepemilikan.NAMA,a_user.username,UNIT_NAME,a_cara_bayar.nama as cb, a_cara_bayar.id as cb_id /* , a_penjualan.KRONIS */ from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_unit on a_unit.UNIT_ID=a_penjualan.RUANGAN Left Join a_user on a_penjualan.USER_ID=a_user.kode_user LEFT JOIN a_mitra ON a_penjualan.KSO_ID=a_mitra.IDMITRA left join a_cara_bayar on a_penjualan.cara_bayar=a_cara_bayar.id WHERE a_penjualan.NO_PENJUALAN='$no_penjualan' and a_penjualan.UNIT_ID=$idunit AND a_penjualan.NO_PASIEN='$no_pasien' AND a_penjualan.TGL='$tgl' AND a_penjualan.USER_ID=$iduser_jual";
			}else{
				$qrySingle="SELECT a_penjualan.*,a_mitra.NAMA AS kso_nama,a_kepemilikan.NAMA,a_user.username,UNIT_NAME,a_cara_bayar.nama as cb, a_cara_bayar.id as cb_id /* , a_penjualan.KRONIS */ from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_unit on a_unit.UNIT_ID=a_penjualan.RUANGAN Left Join a_user on a_penjualan.USER_ID=a_user.kode_user LEFT JOIN a_mitra ON a_penjualan.KSO_ID=a_mitra.IDMITRA left join a_cara_bayar on a_penjualan.cara_bayar=a_cara_bayar.id WHERE a_penjualan.NO_PENJUALAN='$no_penjualan' and a_penjualan.UNIT_ID=$idunit AND a_penjualan.NO_PASIEN='$no_pasien' AND a_penjualan.TGL='$tgl'";
			}
			//echo $qrySingle;
			$exeSingle=mysqli_query($konek,$qrySingle) or die (mysqli_error($konek)." - 846");	
			$showSingle=mysqli_fetch_array($exeSingle);	
			$qty_retur=$showSingle['QTY_RETUR'];	
			$htot=0;
			$njual=$showSingle['NO_PENJUALAN'];	
		?>	
	<div id="content">
		<div id="head-content">
			<!--div id="head-content-left">RSUD SIDOARJO<br>Jl.Majapahit No.667 Sidoarjo</div>
			<div id="head-content-right"><?php echo $apname; ?></div>
			<div class="clear"></div-->
			<style>
				.pad {
					width:60px;
				}
			</style>
			<table id="head-table" style="font-size: 12px;">
				<tr>
				<td class="pad" >&nbsp;</td>
				<td width="50"><img src="../../billing/images/logo.png" width="40"/></td>
				<td>RS PELABUHAN MEDAN<br>JL.Stasiun No. 92 Belawan</td>
				</tr>
				<tr>
					<td class="pad" >&nbsp;</td>
					<td valign="bottom" align="right"  colspan="2"><?php echo $apname; ?></td>
				</tr>
			</table>
		</div>
		<div id="head-content-detil">
			<table id="head-table" style="font-size: 12px;">
				<tr style="width:auto">
					<td class="pad" rowspan="6">&nbsp;</td>
					<td class="border-top"  >No</td>
					<td class="border-top" >:</td>
					<td class="border-top" ><?php echo $showSingle['NO_PENJUALAN']; ?></td>
				</tr>
				<tr>
					<td >Tgl</td>
					<td>:</td>
					<td><?php echo date("d-m-Y",strtotime($showSingle['TGL']))." ".date("H:i",strtotime($showSingle['TGL_ACT']))." / ".$showSingle['username']; ?></td>
				</tr>
				<tr>
					<td>Pasien</td>
					<td>:</td>
					<td><?php echo $showSingle['NAMA_PASIEN']." / ".$showSingle['NO_PASIEN']; ?></td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td>:</td>
					<td><?php echo $showSingle['ALAMAT']; ?></td>
				</tr>
				<tr>
					<td>Dokter</td>
					<td>:</td>
					<td><?php echo $showSingle['DOKTER']; ?></td>
				</tr>
				<tr>
					<td>Ruang</td>
					<td>:</td>
					<td><?php echo $showSingle['UNIT_NAME']; ?></td>
				</tr>
			</table>
			
			<table id="head-table" style="font-size: 12px; float:right;">
				<tr>
					<td class="pad" >&nbsp;</td>
					<td class="pad" >&nbsp;</td>
					<td class='border' align='left' width="80" colspan="2">Nama Obat</td>
					<td class='border' align='center' width="50">Jumlah</td>
					<td class='border' align='center' width="100">Nilai</td>
				</tr>
				<?php 
					if ($iduser_jual!=""){
			
						
						$sqlPrint = "SELECT NO_PENJUALAN, TGL_ACT, NO_KUNJUNGAN, NO_PASIEN, NAMA_PASIEN, JENIS_PASIEN_ID, o.OBAT_NAMA,FLOOR((ap.PPN/100) * SUM(ap.QTY_JUAL* ap.HARGA_SATUAN)) PPN_NILAI,DIJAMIN,
									  o.OBAT_SATUAN_KECIL, SUM(ap.QTY_JUAL*ap.HARGA_SATUAN) total_awal, SUM(ap.QTY_JUAL*ap.HARGA_SATUAN) total_px,
									  SUM(ap.QTY_RETUR*ap.HARGA_SATUAN) total_retur,
									  SUM(ap.QTY) AS QTY, SUM(ap.QTY_JUAL) AS QTY_JUAL, SUM(ap.QTY_RETUR) AS QTY_RETUR/* , ap.DIJAMIN */
									FROM
									  a_penjualan ap
									  INNER JOIN a_penerimaan a_p
										ON ap.PENERIMAAN_ID = a_p.ID 
									  INNER JOIN a_obat o
										ON a_p.OBAT_ID = o.OBAT_ID 
									WHERE ap.NO_PENJUALAN = '{$no_penjualan}' 
									  AND ap.UNIT_ID = '{$idunit}' 
									  AND ap.NO_PASIEN = '{$no_pasien}' 
									  AND ap.TGL = '{$tgl}' 
									  AND ap.USER_ID = '{$iduser_jual}' 
									GROUP BY ap.NO_PENJUALAN, o.OBAT_ID
									ORDER BY ap.ID";
						
					}else{
						
						
						$sqlPrint = "SELECT NO_PENJUALAN, TGL_ACT, NO_KUNJUNGAN, NO_PASIEN, NAMA_PASIEN, JENIS_PASIEN_ID, o.OBAT_NAMA,
						FLOOR((ap.PPN/100) * SUM(ap.QTY_JUAL* ap.HARGA_SATUAN)) PPN_NILAI,
						
						
						DIJAMIN,
									  o.OBAT_SATUAN_KECIL, SUM(ap.QTY_JUAL*ap.HARGA_SATUAN) total_awal, SUM(ap.QTY_JUAL*ap.HARGA_SATUAN) total_px,
									  SUM(ap.QTY_RETUR*ap.HARGA_SATUAN) total_retur,
									  SUM(ap.QTY) AS QTY, SUM(ap.QTY_JUAL) AS QTY_JUAL, SUM(ap.QTY_RETUR) AS QTY_RETUR/* , ap.DIJAMIN */
									FROM
									  a_penjualan ap
									  INNER JOIN a_penerimaan a_p
										ON ap.PENERIMAAN_ID = a_p.ID 
									  INNER JOIN a_obat o
										ON a_p.OBAT_ID = o.OBAT_ID 
									WHERE ap.NO_PENJUALAN = '{$no_penjualan}' 
									  AND ap.UNIT_ID = '{$idunit}' 
									  AND ap.NO_PASIEN = '{$no_pasien}' 
									  AND ap.TGL = '{$tgl}' 
									GROUP BY ap.NO_PENJUALAN, o.OBAT_ID
									ORDER BY ap.ID";
					}
					//echo $sqlPrint;
					$exePrint=mysqli_query($konek,$sqlPrint) or die(mysqli_error($konek)." - 947");
					$k=mysqli_num_rows($exePrint);
					$i=1;
					$totPx = 0;
				while($showPrint=mysqli_fetch_array($exePrint)){
				
				if ($ada_retur>0 && $bayar == '1'){
				?>
				<tr> 
					<td class="pad" >&nbsp;</td>
					<td class="pad" >&nbsp;</td>
					<td class="pad" >&nbsp;</td>
					<td colspan="3"><?php echo $i++.". ".$showPrint['OBAT_NAMA']; ?></td>
				</tr>
				<tr>
					<td class="pad" >&nbsp;</td>
					<td class="pad" >&nbsp;</td>
					<td class="pad" >&nbsp;</td>
					<td class="pad" >&nbsp;</td>
					<td align="center"><?php echo $showPrint['QTY']; ?></td>
					<!--td align="right" class="style1"><?php echo number_format($showPrint['HARGA_SATUAN'],0,',','.'); ?></td-->
					<?php
						$jTot = $showPrint['total_awal']; 
						  //floor($showPrint['QTY'] * $showPrint['HARGA_SATUAN']);
						$htot+=$jTot;
						//$ppn_nilai2 +=$showPrint['PPN_NILAI']; 
						//$ppn_nilai =($ppn_nilai2);
						$ppn_nilai = floor(0.1 * $htot);
						
					?>
					<td align="right"><?php echo number_format($jTot,0,',','.'); ?>&nbsp;&nbsp;</td>
				</tr>
				<?php 	
					} else {
				?>
				<tr> 
					<td class="pad" >&nbsp;</td>
					<td class="pad" >&nbsp;</td>
					<td colspan="4"><?php echo $i++ .". ".$showPrint['OBAT_NAMA']; ?></td>
				</tr>
				<tr>
					<td class="pad" >&nbsp;</td>
					<td class="pad" >&nbsp;</td>
					<td class="pad" >&nbsp;</td>
					<td class="pad" >&nbsp;</td>
					<td align="center"><?php echo $showPrint['QTY_JUAL']; ?></td>
					<!--td width="50" align="right" class="style1"><?php echo number_format($showPrint['HARGA_SATUAN'],0,',','.'); ?></td-->
					<td align="right"> <!--?php if ($i>$k){?>style="border-bottom:1px dashed #999999"<-?php }?--><?php echo number_format($showPrint['total_awal'],0,',','.'); //echo number_format(floor($showPrint['QTY_JUAL'] * $showPrint['HARGA_SATUAN']),0,',','.'); ?>&nbsp;&nbsp;</td>
				</tr>
				<?php 
						if($showPrint['DIJAMIN'] == 1){
							$totPx+= $showPrint['total_px'];
						}
						$dijamin = $showPrint['DIJAMIN'];
						$htot+= $showPrint['total_awal'];
						//$ppn_nilai2 +=$showPrint['PPN_NILAI']; 
						//floor($showPrint['QTY_JUAL'] * $showPrint['HARGA_SATUAN']);
						//$ppn_nilai = ($ppn_nilai2);
						$ppn_nilai =floor(0.1 * $htot);
					}
				} 
				?>
				<tr align="right"> 
					<td class="pad" >&nbsp;</td>
					<td class="pad" >&nbsp;</td>
					<td class="border-top" colspan="3">Total Tagihan :</td>
					<td class="border-top"><?php echo number_format($htot,0,",","."); ?>&nbsp;&nbsp;</td>
				</tr>
				<?php if($ppn_nilai>0){ ?>
				<tr align="right" >
					<td class="pad" >&nbsp;</td>
					<td class="pad" >&nbsp;</td>
					<td colspan="3">PPN :</td>
					<td><?php echo number_format($ppn_nilai,0,",","."); ?>&nbsp;&nbsp;</td>
			  	</tr>
				<tr align="right"> 
					<td class="pad" >&nbsp;</td>
					<td class="pad" >&nbsp;</td>
					<td colspan="3">Total Tagihan + PPN :</td>
					<td><?php echo number_format($htot+$ppn_nilai,0,",","."); ?>&nbsp;&nbsp;</td>
				</tr>
			  	<? }?>
			  	
			  	
				
				<?php if($dijamin == '1'){ ?>
				<tr align="right" class="noborder"> 
					<td class="pad" >&nbsp;</td>
					<td class="pad" >&nbsp;</td>
					<td colspan="3">Dijamin KSO :</td>
					<td><?php echo number_format((($htot+$ppn_nilai)),0,",","."); ?>&nbsp;&nbsp;</td>
				</tr>
				<tr align="right" > 
					<td class="pad" >&nbsp;</td>
					<td class="pad" >&nbsp;</td>
					<td class="border-bottom" colspan="3">Tagihan Pasien :</td>
					<td class="border-bottom"><?php echo number_format(0,0,",","."); ?>&nbsp;&nbsp;</td>
				</tr>
				<?php
				}
		
					if($bayar == '1' || $showSingle['cb_id'] == '1'){
					
				
						$sBayar = "SELECT ap.NO_PASIEN noRM,
									  IFNULL(ku.NO_BAYAR, ap.NO_PENJUALAN) no_bayar,
									  ap.NO_PENJUALAN no_penjualan,
									  IFNULL(
										IF(
										  ku.BAYAR <> 0,
										  ku.BAYAR,
										  ku.BAYAR_UTANG
										),
										ap.HARGA_TOTAL
									  ) bayar_,
									  ku.BAYAR bayar,
									  IFNULL(ku.KEMBALI, 0) kembali 
									FROM a_penjualan ap
									LEFT JOIN a_kredit_utang ku
									   ON ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN
									  AND DATE(ku.TGL_BAYAR) = DATE(ap.TGL_BAYAR_ACT)
									  AND ku.NORM = ap.NO_PASIEN
									  AND ku.NO_PELAYANAN = ap.NO_KUNJUNGAN
									WHERE ap.NO_PENJUALAN = '{$no_penjualan}'
									  AND ap.UNIT_ID = '{$idunit}'
									  AND ap.TGL = '{$tgl}'
									  AND ap.CARA_BAYAR NOT IN (2, 4)
									GROUP BY ap.NO_PENJUALAN";
						//echo $sBayar."<br /><br />";
						$qBayar = mysqli_query($konek,$sBayar);
						$dBayar = mysqli_fetch_array($qBayar);
				?>
				<tr align="right" >
					<td class="pad" >&nbsp;</td>
					<td class="pad" >&nbsp;</td>
					<td class="border-top" colspan="3">Bayar :</td>
					<td class="border-top"><?php echo number_format($dBayar['bayar_'],0,",","."); ?>&nbsp;&nbsp;</td>
				</tr>
				<tr align="right"  <?php //echo ($ada_retur>0)? "" : "class='border-bottom'"; ?>>
					<td class="pad" >&nbsp;</td>
					<td class="pad" >&nbsp;</td>
					<td class='border-bottom' colspan="3">Kembali :</td>
					<td class='border-bottom'><?php echo number_format(($dBayar['bayar_']-$htot),0,",","."); ?>&nbsp;&nbsp;</td>
				</tr>
				<?php } ?>
			</table>
			
			<table id="head-table" style="font-size:12px;">
				<?php if($showSingle['cb_id'] == '2' || $showSingle['cb_id'] == '4'){?>
				<tr>
					<td class="pad" >&nbsp;</td>
					<td align="right">Status Px</td>
					<td >:</td>
					<td align="right">
						<?php 
							echo $showSingle['kso_nama']; 
							if($showSingle['KRONIS'] == '2'){
								echo " / PAKET";
							} else if($showSingle['KRONIS'] == '1'){
								echo " / KRONIS";
							}
						?>
					</td>
				</tr>
				<?php } ?>
				<!--tr>
					<td width="168">Tanggal Cetak</td>
					<td>:</td>
					<td><?php echo $tglact; ?></td>
				</tr>
				<tr>
					<td width="168">Petugas</td>
					<td>:</td>
					<td><?php echo $showSingle['username']; ?></td>
				</tr-->
			</table>
		<?php if($bayar == '1' || $showSingle['cb_id'] == '1') { ?>
			<table id="head-table">
			
				<?php	
		
						$join = "";
						$where_byr = $where = "AND ap.CARA_BAYAR NOT IN (2,4)";
						$select_byr = "IFNULL(bp.no_bayar, CONCAT('PY/',ap.NO_PENJUALAN)) nomer,
									   IFNULL(bp.user_act,ap.USER_ID) userID,
									   DATE_FORMAT(IFNULL(bp.tgl_act,ap.TGL_ACT),'%d-%m-%Y %H:%i:%s') tgl";
				
					
				/*	$sDet_ = "SELECT DISTINCT IFNULL( ku.NO_BAYAR, CONCAT('PY/', ap.NO_PENJUALAN)) nomer,
							  IFNULL(ku.USER_ID, ap.USER_ID) userID,
							  DATE_FORMAT(IFNULL(ku.TGL_BAYAR, ap.TGL_ACT), '%d-%m-%Y %H:%i:%s') tgl 
							FROM
							  a_penjualan ap 
							  LEFT JOIN a_kredit_utang ku 
								ON ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN 
							   and ku.UNIT_ID = ap.UNIT_ID
							WHERE ap.NO_PENJUALAN = '{$no_penjualan}' 
							  AND ap.UNIT_ID = '{$idunit}'
							  AND ap.TGL = '{$tgl}'
							/* UNION
							SELECT 
							  CONCAT('RT/', rp.no_retur) no_retur,
							  rp.userid_retur,
							  DATE_FORMAT(rp.tgl_retur,'%d-%m-%Y %H:%i:%s') tgl 
							FROM
							  a_return_penjualan rp 
							  INNER JOIN a_penjualan ap 
								ON ap.ID = rp.idpenjualan 
							WHERE ap.NO_PENJUALAN = '{$no_penjualan}' 
							  AND ap.UNIT_ID = '{$idunit}'
							  AND ap.TGL = '{$tgl}'
							UNION
							SELECT DISTINCT 
							  IFNULL(pu.no_pengembalian,CONCAT('RP/', rp.no_retur)) no_pengembalian,
							  IFNULL(pu.user_act, rp.userid_retur) user_act,
							  DATE_FORMAT(IFNULL(pu.tgl_act, rp.tgl_retur),'%d-%m-%Y %H:%i:%s') tgl 
							FROM
							  a_return_penjualan rp 
							  INNER JOIN a_penjualan ap 
								ON ap.ID = rp.idpenjualan 
							  {$join}
							  LEFT JOIN a_pengembalian_uang pu 
								ON pu.no_penjualan = ap.NO_PENJUALAN 
								AND pu.no_retur = rp.no_retur 
							WHERE ap.NO_PENJUALAN = '{$no_penjualan}' 
							  AND ap.UNIT_ID = '{$idunit}'
							  AND ap.TGL = '{$tgl}'
							  {$where} *//*"; */
					
				
					$sql = "SELECT ku.NO_BAYAR nomer, DATE_FORMAT(ku.TGL_BAYAR,'%d-%m-%Y %H:%i:%s') tgl, u.username
							FROM a_kredit_utang ku
							INNER JOIN a_penjualan ap
							   ON ap.NO_PENJUALAN = ku.FK_NO_PENJUALAN
							  AND DATE(ku.TGL_BAYAR) = DATE(ap.TGL_BAYAR_ACT)
							  /*AND ap.TGL_ACT <= ku.TGL_BAYAR*/
							  AND ap.NO_KUNJUNGAN = ku.NO_PELAYANAN
							  AND ap.UNIT_ID = ku.UNIT_ID
							INNER JOIN a_user u
							   ON u.kode_user = ku.USER_ID
							WHERE ku.FK_NO_PENJUALAN = '{$no_penjualan}' 
							  AND ap.UNIT_ID = '{$idunit}'
							  AND ap.TGL = '{$tgl}'";
					$query = mysqli_query($konek,$sql);
					$dQuery = mysqli_fetch_array($query);
					if($dQuery['nomer'] == ""){
						$sql = "SELECT ap.NO_PENJUALAN nomer, DATE_FORMAT(ap.TGL_ACT,'%d-%m-%Y %H:%i:%s') tgl, u.username
								FROM a_penjualan ap
								INNER JOIN a_user u
								   ON u.kode_user = ap.USER_ID
								WHERE ap.NO_PENJUALAN = '{$no_penjualan}'
								  AND ap.UNIT_ID = '{$idunit}'
								  AND ap.TGL = '{$tgl}'";
						$query = mysqli_query($konek,$sql);
						$dQuery = mysqli_fetch_array($query);
					}
					//echo $sDet_bayar;
					
					echo "<tr><td class='pad'>&nbsp;</td><td>-&nbsp; ".$dQuery['nomer']." / ".$dQuery['tgl']." / ".$dQuery['username']."</td></tr>";
					
				?>
			</table>
		<?php } ?>
			<table id="head-table">
				<?php if($showSingle['cb_id'] == '1' || $bayar == '1'){?>
				<tr>
					<td class="pad" >&nbsp;</td>
					<td colspan="3">
						- Bukti Pembayaran Ini Juga Berlaku Sebagai Kwitansi
					</td>
				</tr>
				<?php } ?>
			</table>
		</div>
	</div>	  
</div>
	<script type="text/javascript">
		function hapusP(){
			if (confirm('Yakin Ingin Menghapus Data Penjualan ?')){
				var alasan = prompt("Masukkan Alasan Hapus Penjualan?", "");
				if (alasan != null) {
					hapuss.disabled=true;
					location='../transaksi/hapus_penjualan.php?no_jual=<?php echo $njual; ?>&no_pasien=<?php echo $no_pasien; ?>&idunit=<?php echo $idunit; ?>&tgl=<?php echo $tgl; ?>&iduser=<?php echo $iduser; ?>&iduser_jual=<?php echo $iduser_jual; ?>&alasan='+alasan;
				}
			}
		}
	</script>
	<div id="btn">
	<br>
	<table width="550" align="left">
	<tr>
		<td width="50%" align="left">
			<BUTTON type="button" onClick="document.getElementById('btn').style.display='none';window.print();"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">Cetak Kwitansi</BUTTON>
		</td>
		<td width="50%" align="right">
			<?php 
				if ($iduser_jual!=""){
					$sqlRet="SELECT * FROM a_penjualan WHERE UNIT_ID=$idunit AND QTY_RETUR>0 AND NO_PENJUALAN='$no_penjualan' AND NO_PASIEN='$no_pasien' AND TGL='$tgl' AND USER_ID=$iduser_jual";
				}else{
					$sqlRet="SELECT * FROM a_penjualan WHERE UNIT_ID=$idunit AND QTY_RETUR>0 AND NO_PENJUALAN='$no_penjualan' AND NO_PASIEN='$no_pasien' AND TGL='$tgl'";
				}
				//echo $sql."----------------------------------";
				$rs=mysqli_query($konek,$sqlRet);
				$ada_retur=mysqli_num_rows($rs);
				//echo $ada_retur;
				//echo $viewdel." == ".(int)$dBayar['bayar_']." == ".$ada_retur." == ".$showSingle['cb_id']." == ".date("d-m-Y",strtotime($showSingle['TGL']))."---".$tglNow;
				if(($showSingle['cb_id'] == '2' || $showSingle['cb_id'] == '4') && (int)$ada_retur <= 0 && (int)$dBayar['bayar_'] <= 0 /*&& date("d-m-Y",strtotime($showSingle['TGL'])) == $tglNow*/ ){
			?>
				<BUTTON type="button" id="hapuss" style="display:<?php if ($viewdel=="true") echo "block"; else echo "none";?>" onClick="hapusP()"
				><IMG SRC="../icon/hapus.gif" border="0" width="16" height="16" ALIGN="absmiddle">Delete</BUTTON>
			<?php
				}
			?>
		</td>
	</tr>
	</table>
	</div>
</body>
</html>