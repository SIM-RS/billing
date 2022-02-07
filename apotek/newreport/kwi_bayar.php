<?php
	session_start();
	include("../koneksi/konek.php");
	$namaRS = $_SESSION["namaP"];
	$alamatRS = $_SESSION["alamatP"];
	$kotaRS = $_SESSION["kotaP"];
	$iduser = $_SESSION["iduser"];
	$iduser_jual = $_REQUEST["iduser_jual"];
	$tglact=gmdate('d/m/Y H:i:s',mktime(date('H')+7));
	$tglNow=gmdate('d-m-Y',mktime(date('H')+7));
	
	$idunit=$_GET["sunit"];
	$no_penjualan=$_GET['no_penjualan'];
	$no_pasien=$_GET['no_pasien'];
	$no_bayar=$_GET['no_bayar'];
	if($_REQUEST['bayar'] == '1'){
		$bayar = '1';
	} else {
		$bayar = '0';
	}
	$viewdel=$_GET['viewdel'];
	if ($iduser!=133 && $iduser!=225 && $iduser!=226 && $iduser!=223 && $iduser!=7 && $iduser!=499) $viewdel="false";
	$tgl=$_GET['tgl'];
	$u="select UNIT_NAME from a_unit where UNIT_ID=$idunit";
	//echo $u."<br>";
	$rsu=mysqli_query($konek,$u) or die(mysqli_error($konek));
	$row=mysqli_fetch_array($rsu);
	$apname=$row['UNIT_NAME'];

	if ($iduser_jual!=""){
		$sql="SELECT ap.*
				FROM a_penjualan ap
				INNER JOIN a_return_penjualan rp
				   ON rp.idpenjualan = ap.ID
				LEFT JOIN a_kredit_utang ku
				   ON ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN
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
		function printZebra() {
			//var applet = document.jzebra;
			if (applet != null) {			
				<?php 					
					printHeader();					
					$hasil = printDataObat();					
					printFooter($hasil);
					
					function printHeader(){		
						global $konek, $dbbilling;
						$unit = $_GET["sunit"];
						$iduser_jual = $_REQUEST["iduser_jual"];
						$qnamaUnit="select UNIT_NAME from a_unit where UNIT_ID=$unit";
						$hasil=mysqli_query($konek,$qnamaUnit);
						$rowDataUnit=mysqli_fetch_array($hasil);
						$namaUnit=$rowDataUnit['UNIT_NAME'];
						
						$noPenjualan = $_GET['no_penjualan'];
						$noPasien = $_GET['no_pasien'];
						$tanggal = $_GET['tgl'];
						$no_bayar=$_GET['no_bayar'];
						
						if($_REQUEST['bayar'] == '1'){
							$bayar = '1';
						} else {
							$bayar = '0';
						}
						if ($iduser_jual!=""){
							$qSingle="SELECT a_penjualan.*,a_mitra.NAMA AS kso_nama,a_kepemilikan.NAMA,a_user.username,UNIT_NAME,a_cara_bayar.nama as cb, a_cara_bayar.id as cb_id, a_penjualan.DIJAMIN 
							from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_unit on a_unit.UNIT_ID=a_penjualan.RUANGAN Left Join a_user on a_penjualan.USER_ID=a_user.kode_user LEFT JOIN a_mitra ON a_penjualan.KSO_ID=a_mitra.IDMITRA left join a_cara_bayar on a_penjualan.cara_bayar=a_cara_bayar.id WHERE a_penjualan.NO_PENJUALAN='$noPenjualan' and a_penjualan.UNIT_ID=$unit AND a_penjualan.NO_PASIEN='$noPasien' AND a_penjualan.TGL='$tanggal' AND a_penjualan.USER_ID=$iduser_jual";
						}else{
							$qSingle="SELECT a_penjualan.*,a_mitra.NAMA AS kso_nama,a_kepemilikan.NAMA,a_user.username,UNIT_NAME,a_cara_bayar.nama as cb, a_cara_bayar.id as cb_id, a_penjualan.DIJAMIN 
							from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_unit on a_unit.UNIT_ID=a_penjualan.RUANGAN Left Join a_user on a_penjualan.USER_ID=a_user.kode_user LEFT JOIN a_mitra ON a_penjualan.KSO_ID=a_mitra.IDMITRA left join a_cara_bayar on a_penjualan.cara_bayar=a_cara_bayar.id WHERE a_penjualan.NO_PENJUALAN='$noPenjualan' and a_penjualan.UNIT_ID=$unit AND a_penjualan.NO_PASIEN='$noPasien' AND a_penjualan.TGL='$tanggal'";
						}
						
						$rSingle = mysqli_query($konek,$qSingle);
						$rowSingle = mysqli_fetch_array($rSingle);
						
						/* cek bayar */
						$sByrC_ = "SELECT ku.NO_BAYAR, DATE_FORMAT(ku.TGL_BAYAR, '%d-%m-%Y %H:%i:%s') TGL_BAYAR, ku.USER_ID, 
										 IF(ku.IS_AKTIF = 1, u.username, peg.nama) username
									FROM (SELECT ku2.NORM, ku2.NO_PELAYANAN, IFNULL(ku2.NO_BAYAR, ku2.FK_NO_PENJUALAN) NO_BAYAR, ku2.NO_BAYAR no_byr, 
									  ku2.FK_NO_PENJUALAN, ku2.CARA_BAYAR, ku2.UNIT_ID, SUM(ku2.BAYAR_UTANG), ku2.BAYAR,
									  ku2.KEMBALI, ku2.TOTAL_HARGA, ku2.TGL_BAYAR, IF(ku2.SHIFT = 0, '-', ku2.SHIFT) SHIFT, ku2.USER_ID, 
									  ku2.BILLING_BAYAR_OBAT_ID, ku2.IS_AKTIF
									FROM a_kredit_utang ku2
									GROUP BY ku2.FK_NO_PENJUALAN, ku2.UNIT_ID) ku
									LEFT JOIN a_user u 
									   ON u.kode_user = ku.USER_ID 
									LEFT JOIN $dbbilling.b_ms_pegawai peg
									   ON peg.id = ku.USER_ID
									INNER JOIN a_penjualan ap
									   ON ap.NO_PENJUALAN = ku.FK_NO_PENJUALAN
									  AND ku.UNIT_ID = ap.UNIT_ID
									WHERE ku.NO_BAYAR = '{$no_bayar}'
									  AND ap.NO_PENJUALAN = '{$noPenjualan}'
									  AND ap.UNIT_ID = '{$unit}'
									  AND ap.TGL = '{$tanggal}'
									GROUP BY ku.NO_BAYAR";
									
						$sByrC = "SELECT ku.NO_BAYAR, DATE_FORMAT(ku.TGL_BAYAR, '%d-%m-%Y %H:%i:%s') TGL_BAYAR, ku.USER_ID,
									  IF(ku.IS_AKTIF = 1, u.username, peg.nama) username 
									FROM a_kredit_utang ku
									INNER JOIN a_penjualan ap
									   ON ap.NO_PENJUALAN = ku.FK_NO_PENJUALAN
									  AND ap.UNIT_ID = ku.UNIT_ID
									  AND ap.NO_KUNJUNGAN = ku.NO_PELAYANAN
									  AND ap.NO_PASIEN = ku.NORM
									LEFT JOIN a_user u 
									   ON u.kode_user = ku.USER_ID 
									LEFT JOIN $dbbilling.b_ms_pegawai peg 
									   ON peg.id = ku.USER_ID 
									WHERE ku.NO_BAYAR = '{$no_bayar}'
									  AND ap.NO_PENJUALAN = '{$noPenjualan}'
									  AND ap.UNIT_ID = '{$unit}'
									  AND ap.TGL = '{$tanggal}'
									GROUP BY ku.NO_BAYAR";
						$qByrC = mysqli_query($konek,$sByrC);
						$dByrC = mysqli_fetch_array($qByrC);
						
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
						$noBayar = $dByrC['NO_BAYAR'];
						/* if ($ada_retur>0){
							echo "applet.append(\"No. Retur     : $retur      Ref. Kwitansi : $noKwitansi\\n\")"; echo chr(59);echo "\n\t\t\t";
						}
						else { */
						echo "applet.append(\"No Pembayaran  : $noBayar\\n\")"; echo chr(59);echo "\n\t\t\t";
						//}
						echo "applet.append(\"Tgl Pembayaran : ".$dByrC['TGL_BAYAR']."/".$dByrC['username']."\\n\")"; echo chr(59);echo "\n\t\t\t";
						$namaPasien = $rowSingle['NAMA_PASIEN'];
						$noPasien = $rowSingle['NO_PASIEN'];					
						echo "applet.append(\"Pasien/No. RM  : $namaPasien/$noPasien\\n\")"; echo chr(59);echo "\n\t\t\t";
						$alamat = $rowSingle['ALAMAT'];
						echo "applet.append(\"Alamat         : $alamat\\n\")"; echo chr(59);echo "\n\t\t\t";
						$dokter = $rowSingle['DOKTER'];
						echo "applet.append(\"Dokter         : $dokter\\n\")"; echo chr(59);echo "\n\t\t\t";
						$ruang = $rowSingle['UNIT_NAME'];
						echo "applet.append(\"Ruang          : $ruang\\n\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\"----------------------------------------------------\\n\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\" No   Nama Obat                  Jumlah      Nilai  \\n\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\"----------------------------------------------------\\n\")"; echo chr(59);echo "\n\t\t\t";
					}
					
					function printFooter($hasil) {
						global $konek, $dbbilling;
						$iduser_jual = $_REQUEST["iduser_jual"];						
						$no_penjualan=$_GET['no_penjualan'];
						$no_pasien=$_GET['no_pasien'];		
						$unit = $_GET["sunit"];						
						$tanggal = $_GET['tgl'];					
						$no_bayar=$_GET['no_bayar'];
						$ppn_nilai = $hasil[4];
						
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
						
						$nilai_sebelum_retur = number_format($hasil[0],0,",","."); 
						$spasiNilaiTotal = 12 - strlen((string)$nilai_sebelum_retur);	
						
						for($j=0;$j<$spasiNilaiTotal;$j++){
									echo " ";
						}
						echo "$nilai_sebelum_retur"; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";
						
						if($ppn_nilai > 0){
							echo "applet.append(\"                 PPN 10%              : "; 
							$ppnNilai = number_format($ppn_nilai,0,",","."); 
							$spasiNilaiTotal = 12 - strlen((string)$ppnNilai);	
							
							for($j=0;$j<$spasiNilaiTotal;$j++){
										echo " ";
							}
							echo "$ppnNilai"; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";
							
							echo "applet.append(\"             Nilai Total              : "; 
							$nilai_ppn = number_format(($hasil[0]+$ppn_nilai),0,",","."); 
							$spasiNilaiTotal = 12 - strlen((string)$nilai_ppn);	
							
							for($j=0;$j<$spasiNilaiTotal;$j++){
										echo " ";
							}
							echo "$nilai_ppn"; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";
							echo "applet.append(\"----------------------------------------------------\\n\")"; echo chr(59);echo "\n\t\t\t";
						}
						
						if($hasil[2] > 0){
							echo "applet.append(\"             Dijamin KSO              : "; 
							$nilai_dijamin = number_format($hasil[2],0,",","."); 
							$spasiNilaiDijamin = 12 - strlen((string)$nilai_dijamin);	
							
							for($j=0;$j<$spasiNilaiDijamin;$j++){
										echo " ";
							}
							echo "$nilai_dijamin"; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";
							
							echo "applet.append(\"             Biaya Pasien             : "; 
							$nilai_px = number_format($hasil[3]+$ppn_nilai,0,",","."); 
							$spasiNilaiPx = 12 - strlen((string)$nilai_px);	
							
							for($j=0;$j<$spasiNilaiPx;$j++){
										echo " ";
							}
							echo "$nilai_px"; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";
							echo "applet.append(\"----------------------------------------------------\\n\")"; echo chr(59);echo "\n\t\t\t";
						}
						
						$qnamaUnit="select UNIT_NAME from a_unit where UNIT_ID=$unit";
						$hasil=mysqli_query($konek,$qnamaUnit);
						$rowDataUnit=mysqli_fetch_array($hasil);
						$namaUnit=$rowDataUnit['UNIT_NAME'];					
												
						if ($iduser_jual!=""){
							$fuserID = "AND ap.USER_ID = '{$iduser_jual}'";
							$qrySingle="SELECT a_penjualan.*,a_mitra.NAMA AS kso_nama,a_kepemilikan.NAMA,a_user.username,UNIT_NAME,a_cara_bayar.nama as cb, a_cara_bayar.id as cb_id, a_penjualan.DIJAMIN 
							from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_unit on a_unit.UNIT_ID=a_penjualan.RUANGAN Left Join a_user on a_penjualan.USER_ID=a_user.kode_user LEFT JOIN a_mitra ON a_penjualan.KSO_ID=a_mitra.IDMITRA left join a_cara_bayar on a_penjualan.cara_bayar=a_cara_bayar.id WHERE a_penjualan.NO_PENJUALAN='$no_penjualan' and a_penjualan.UNIT_ID=$unit AND a_penjualan.NO_PASIEN='$no_pasien' AND a_penjualan.TGL='$tanggal' AND a_penjualan.USER_ID=$iduser_jual GROUP BY a_penjualan.NO_PENJUALAN";
						}else{
							$fuserID = "";
							$qrySingle="SELECT a_penjualan.*,a_mitra.NAMA AS kso_nama,a_kepemilikan.NAMA,a_user.username,UNIT_NAME,a_cara_bayar.nama as cb, a_cara_bayar.id as cb_id, a_penjualan.DIJAMIN 
							from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_unit on a_unit.UNIT_ID=a_penjualan.RUANGAN Left Join a_user on a_penjualan.USER_ID=a_user.kode_user LEFT JOIN a_mitra ON a_penjualan.KSO_ID=a_mitra.IDMITRA left join a_cara_bayar on a_penjualan.cara_bayar=a_cara_bayar.id WHERE a_penjualan.NO_PENJUALAN='$no_penjualan' and a_penjualan.UNIT_ID=$unit AND a_penjualan.NO_PASIEN='$no_pasien' AND a_penjualan.TGL='$tanggal' GROUP BY a_penjualan.NO_PENJUALAN";
						}
						
						//mysqli_free_result($exeSingle);
						$exeSingle=mysqli_query($konek,$qrySingle);	
						$showSingle=mysqli_fetch_array($exeSingle);
						
						if($bayar == '1'){
							if($showSingle['cb_id'] == '2' || $showSingle['cb_id'] == '4'){
								$sBayar = "SELECT 
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
														GROUP BY ku2.FK_NO_PENJUALAN, ku2.UNIT_ID) ku
											   ON ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN
											 /* AND ku.UNIT_ID = ap.UNIT_ID*/
											WHERE ap.NO_PENJUALAN = '{$no_penjualan}' 
											 /* AND ap.UNIT_ID = '{$unit}'*/
											  AND ap.TGL = '{$tanggal}'
											  AND ((ap.CARA_BAYAR = 2 /* AND ap.KSO_ID <> '88' */)
											   OR (ap.CARA_BAYAR = 4))
											  /* AND ap.CARA_BAYAR in (2,4)
											  AND ap.KSO_ID <> 88 */";
											  
								$sBayar = "SELECT *
										FROM (SELECT ap.NO_PASIEN noRM,
												  IFNULL(ku.NO_BAYAR, ap.NO_PENJUALAN) no_bayar,
												  ap.NO_PENJUALAN no_penjualan,
												  IFNULL( IF(ku.BAYAR <> 0, ku.BAYAR, ku.BAYAR_UTANG), ap.HARGA_TOTAL ) bayar_,
												  ku.BAYAR bayar,
												  IFNULL(ku.KEMBALI, 0) kembali 
												FROM a_penjualan ap
												INNER JOIN a_kredit_utang ku
												   ON ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN
												 /* AND ku.UNIT_ID = ap.UNIT_ID*/
												  AND ku.NO_PELAYANAN = ap.NO_KUNJUNGAN
												  AND ku.NORM = ap.NO_PASIEN
												WHERE ap.NO_PENJUALAN = '{$no_penjualan}' 
												 /* AND ap.UNIT_ID = '{$unit}' */
												  AND ap.TGL = '{$tanggal}'
												  AND ap.CARA_BAYAR IN (2,4)) t1
										GROUP BY t1.no_bayar";
							} else {
								$sBayar = "SELECT 
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
														GROUP BY ku2.FK_NO_PENJUALAN, ku2.UNIT_ID) ku
											   ON ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN
											  AND ku.UNIT_ID = ap.UNIT_ID
											WHERE ap.NO_PENJUALAN = '{$no_penjualan}' 
											  AND ap.UNIT_ID = '{$unit}'
											  AND ap.TGL = '{$tanggal}'
											  AND ap.CARA_BAYAR NOT IN (2,4)";
							}
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
							$nilai_kembali = number_format($dBayar['kembali'],0,",","."); 
							$spasiNilaiKembali = 12 - strlen((string)$nilai_kembali);	
							
							for($j=0;$j<$spasiNilaiKembali;$j++){
										echo " ";
							}
							echo $nilai_kembali; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";
						}
						echo "applet.append(\"\\n\")"; echo chr(59); echo "\n\t\t\t";
						
						/* cek bayar */
						$sByrC = "SELECT ku.NO_BAYAR, DATE_FORMAT(ku.TGL_BAYAR, '%d-%m-%Y %H:%i:%s') TGL_BAYAR, ku.USER_ID,
									  IF(ku.IS_AKTIF = 1, u.username, peg.nama) username 
									FROM a_kredit_utang ku
									INNER JOIN a_penjualan ap
									   ON ap.NO_PENJUALAN = ku.FK_NO_PENJUALAN
									  AND ap.UNIT_ID = ku.UNIT_ID
									  AND ap.NO_KUNJUNGAN = ku.NO_PELAYANAN
									  AND ap.NO_PASIEN = ku.NORM
									LEFT JOIN a_user u 
									   ON u.kode_user = ku.USER_ID 
									LEFT JOIN $dbbilling.b_ms_pegawai peg 
									   ON peg.id = ku.USER_ID 
									WHERE ku.NO_BAYAR = '{$no_bayar}'
									  AND ap.NO_PENJUALAN = '{$no_penjualan}'
									  AND ap.UNIT_ID = '{$unit}'
									  AND ap.TGL = '{$tanggal}'
									  {$fuserID}
									GROUP BY ku.NO_BAYAR";
						
						$qByrC = mysqli_query($konek,$sByrC);
						$dByrC = mysqli_fetch_array($qByrC);
						
						$sRetC = "SELECT GROUP_CONCAT(DISTINCT(t1.no_retur) SEPARATOR ', ') no_retur
									FROM (SELECT 
											  rp.no_retur,
											  rp.userid_retur,
											  DATE_FORMAT(rp.tgl_retur, '%d-%m-%Y %H:%i:%s') tgl 
											FROM
											  a_return_penjualan rp 
											  INNER JOIN a_penjualan ap 
												ON ap.ID = rp.idpenjualan 
											WHERE ap.NO_PENJUALAN = '{$no_penjualan}' 
											  AND ap.UNIT_ID = '{$unit}' 
											  AND ap.TGL = '{$tanggal}'
											  {$fuserID}
											  AND DATE_FORMAT(rp.tgl_retur,'%d-%m-%Y %H:%i:%s') < '".$dByrC['TGL_BAYAR']."') t1";
						$qRetC = mysqli_query($konek,$sRetC);
						$dRetC = mysqli_fetch_array($qRetC);
						echo "applet.append(\"No. Penjualan    : ";
						echo $no_penjualan; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";
						echo "applet.append(\"No. Retur        : ";
						echo $dRetC['no_retur']; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";
						//$status = $showSingle['kso_nama'];/* ."/".$showSingle['cb'];   */  
						//echo "applet.append(\"Status : $status\\n\")"; echo chr(59); echo "\n\t\t\t";
						//$tanggal = date("d/m/Y",strtotime($showSingle['TGL']))." ".date("H:i",strtotime($showSingle['TGL_ACT']));
						//echo "applet.append(\"Tanggal      : $tanggal";
						/* if ($ada_retur){
							echo " - ".$tglretur; echo "\\n\")"; echo chr(59); echo "\n\t\t\t";
						}
						else { */
							//echo "\\n\")"; echo chr(59); echo "\n\t\t\t";
						//}
						//$petugas = $showSingle['username'];
						//echo "applet.append(\"Petugas      : $petugas\\n\")"; echo chr(59); echo "\n\t\t\t";
						//if($showSingle['cb']=="TUNAI"){
						echo "applet.append(\"- Bukti Pembayaran ini juga berlaku sebagai kwitansi -\\n\")"; 		
						echo chr(59); echo "\n\t\t\t";
						//}
						echo "applet.append(\"\\x0C\")"; echo chr(59); echo "\n\t\t\t";         //FF
						echo "applet.append(\"\\x1B\\x40\")"; echo chr(59); echo "\n\t\t\t";
						
						echo "applet.print()"; echo chr(59); 
					 }
					
					function printDataObat() {
						global $konek, $dbbilling;
						$noPenjualan = $_GET['no_penjualan'];
						$unit = $_GET["sunit"];
						$noPasien = $_GET['no_pasien'];
						$tanggal = $_GET['tgl'];
						$harga_total=0;
						$nilai_retur=0;
						$iduser_jual = $_REQUEST["iduser_jual"];
						$no_bayar=$_GET['no_bayar'];
						
						if($_REQUEST['bayar'] == '1'){
							$bayar = '1';
						} else {
							$bayar = '0';
						}
						
						
						if ($iduser_jual!=""){
							
							$sqlObat= "SELECT NO_PENJUALAN, TGL_ACT, NO_KUNJUNGAN, NO_PASIEN, NAMA_PASIEN, JENIS_PASIEN_ID, a_p.OBAT_ID,
										  o.OBAT_NAMA, o.OBAT_SATUAN_KECIL, SUM( ap.QTY_JUAL * HARGA_SATUAN ) total_awal,
										  SUM(ap.QTY) AS QTY, SUM(ap.QTY_JUAL) AS QTY_JUAL, SUM(ap.QTY_RETUR) AS QTY_RETUR, ap.HARGA_SATUAN, 
										  SUM(ap.QTY_JUAL*ap.HARGA_KSO) AS dijamin_kso,
										  SUM(ap.QTY_JUAL*ap.HARGA_PX) AS iur_px,
										  ap.PPN_NILAI
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
										  AND ap.USER_ID= '{$iduser_jual}'
										GROUP BY ap.NO_PENJUALAN, o.OBAT_ID
										ORDER BY ap.ID";
						}else{
							
							$sqlObat= "SELECT NO_PENJUALAN, TGL_ACT, NO_KUNJUNGAN, NO_PASIEN, NAMA_PASIEN, JENIS_PASIEN_ID, a_p.OBAT_ID,
										  o.OBAT_NAMA, o.OBAT_SATUAN_KECIL, SUM( ap.QTY_JUAL * HARGA_SATUAN ) total_awal,
										  SUM(ap.QTY) AS QTY, SUM(ap.QTY_JUAL) AS QTY_JUAL, SUM(ap.QTY_RETUR) AS QTY_RETUR, ap.HARGA_SATUAN, 
										  SUM(ap.QTY_JUAL*ap.HARGA_KSO) AS dijamin_kso,
										  SUM(ap.QTY_JUAL*ap.HARGA_PX) AS iur_px,
										  ap.PPN_NILAI
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
						
						/* cek bayar */
						
						
						$sByrC = "SELECT ku.NO_BAYAR, DATE_FORMAT(ku.TGL_BAYAR, '%d-%m-%Y %H:%i:%s') TGL_BAYAR, ku.USER_ID,
									  IF(ku.IS_AKTIF = 1, u.username, peg.nama) username 
									FROM a_kredit_utang ku
									INNER JOIN a_penjualan ap
									   ON ap.NO_PENJUALAN = ku.FK_NO_PENJUALAN
									  AND ap.UNIT_ID = ku.UNIT_ID
									  AND ap.NO_KUNJUNGAN = ku.NO_PELAYANAN
									  AND ap.NO_PASIEN = ku.NORM
									LEFT JOIN a_user u 
									   ON u.kode_user = ku.USER_ID 
									LEFT JOIN $dbbilling.b_ms_pegawai peg 
									   ON peg.id = ku.USER_ID 
									WHERE ku.NO_BAYAR = '{$no_bayar}'
									  AND ap.NO_PENJUALAN = '{$noPenjualan}'
									  AND ap.UNIT_ID = '{$unit}'
									  AND ap.TGL = '{$tanggal}'
									  {$fuserID}
									GROUP BY ku.NO_BAYAR";
						
						$qByrC = mysqli_query($konek,$sByrC);
						$dByrC = mysqli_fetch_array($qByrC);
						
						if ($iduser_jual!=""){
							$fuserID = "AND ap.USER_ID = '{$iduser_jual}'";
							$sql="SELECT * FROM a_penjualan WHERE UNIT_ID=$unit AND QTY_RETUR>0 AND NO_PENJUALAN='$noPenjualan' AND NO_PASIEN='$noPasien' AND TGL='$tanggal' AND USER_ID=$iduser_jual";
						}else{
							$fuserID = "";
							$sql="SELECT * FROM a_penjualan WHERE UNIT_ID=$unit AND QTY_RETUR>0 AND NO_PENJUALAN='$noPenjualan' AND NO_PASIEN='$noPasien' AND TGL='$tanggal'";
						}

						$rs=mysqli_query($konek,$sql);
						$ada_retur=mysqli_num_rows($rs);
						$adaSisaNamaObat = 0;
						
						while ($k > 0){			//untuk cek jumlah halaman
							/* if ($ada_retur){
								//$k -= 18;
								$baris = 18;
							}
							else { */
								//$k -= 20;
								$baris = 14;
							//}
							$dijaminKso = $iurPx = 0;
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
								//$jumlahRetur = $showPrint['QTY_RETUR'];
								$jumlah = $showPrint['QTY'];
								//lebar field nilai 12					
								
								if($ada_retur>0){		//ada retur
										
									$sReturG = "SELECT rp.no_retur, rp.userid_retur, DATE_FORMAT( rp.tgl_retur, '%d-%m-%Y %H:%i:%s' ) tgl,
												  SUM(rp.qty_retur) qty_retur, ap.HARGA_SATUAN, SUM((rp.qty_retur) * ap.HARGA_SATUAN) total_retur,
												  p.OBAT_ID, SUM(rp.qty_retur*ap.HARGA_KSO) as ret_kso, SUM(rp.qty_retur*ap.HARGA_PX) as ret_px
												FROM
												  a_return_penjualan rp 
												  INNER JOIN a_penjualan ap 
													ON ap.ID = rp.idpenjualan 
												  INNER JOIN a_penerimaan p 
													ON p.ID = ap.PENERIMAAN_ID 
												WHERE ap.NO_PENJUALAN = '{$noPenjualan}' 
												  AND ap.UNIT_ID = '{$unit}' 
												  AND ap.TGL = '{$tanggal}' 
												  {$fuserID}
												  AND DATE_FORMAT( rp.tgl_retur, '%d-%m-%Y %H:%i:%s' ) < '".$dByrC['TGL_BAYAR']."'
												  AND p.OBAT_ID = '".$showPrint['OBAT_ID']."'";
										
									$qReturG = mysqli_query($konek,$sReturG);
									$dReturG = mysqli_fetch_array($qReturG);
									
									$jumlahRetur = $dReturG['qty_retur'];
									$retKso = $retPx = 0;
									if ($spasiNamaObat >= 0) {				//nama obat tidak melebihi panjang kolom
										echo "$namaObat";  
										for($j=0;$j<$spasiNamaObat;$j++){
											echo " ";
										}
										$jumlahObat = $jumlahJual-$jumlahRetur;
										$spasiJumlahObat = 7 - strlen($jumlahObat);
										for($j=0;$j<$spasiJumlahObat;$j++){
											echo " ";
										}
										echo "$jumlahObat";			
										//$harga_total += $jumlahJual * $showPrint['HARGA_SATUAN'];
										//$nilai_retur += $jumlahRetur * $showPrint['HARGA_SATUAN'];
										$nilai_retur += $dReturG['total_retur'];
										$nilai = $showPrint['total_awal'] - $dReturG['total_retur'];
										$harga_total += $nilai;
										$nilai = number_format($nilai,0,',','.');
										$spasiNilai = 12 - strlen($nilai);
										for($j=0;$j<$spasiNilai;$j++){
											echo " ";
										}
										echo $nilai; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";
									}
									else {								//nama obat melebihi panjang kolom
										$baris--;
										$pecahNamaObat = str_split($namaObat, 26);
										echo "$pecahNamaObat[0]";  
										$jumlahObat = $jumlahJual-$jumlahRetur; //$jumlahJual."-".$jumlahRetur."=".$jumlah;
										$spasiJumlahObat = 7 - strlen($jumlahObat);
										for($j=0;$j<$spasiJumlahObat;$j++){
											echo " ";
										}
										echo "$jumlahObat ";		
										
										//$harga_total += $jumlahJual * $showPrint['HARGA_SATUAN'];
										$nilai_retur += $dReturG['total_retur']; //$jumlahRetur * $showPrint['HARGA_SATUAN'];
										$nilai = $showPrint['total_awal'] - $dReturG['total_retur']; //($jumlahJual - $jumlahRetur) * $showPrint['HARGA_SATUAN'];
										$harga_total += $nilai;										
										$nilai = number_format($nilai,0,',','.');
										$spasiNilai = 12 - strlen($nilai);
										for($j=0;$j<$spasiNilai;$j++){
											echo " ";
										}
										echo $nilai; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";
																				
										if ($baris > 0)	{								
											echo "applet.append(\"      "; echo $pecahNamaObat[1]; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";
										}
										else
											$adaSisaNamaObat = 1;
									}
									$retKso = $showPrint['dijamin_kso'] - $dReturG['ret_kso'];
									$retPx = $showPrint['iur_px'] - $dReturG['ret_px'];
									$dijaminKso += $retKso;
									$iurPx += $retPx;
								}
								else {			//tidak ada retur
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
									$dijaminKso += $showPrint['dijamin_kso'];
									$iurPx += $showPrint['iur_px'];									
								}							
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
						$hasil = array($harga_total, $nilai_retur, $dijaminKso, $iurPx, $ppn_nilai);
						return $hasil;
					 }			
					
				?>  
			}
		}	
	</script>
	<style type="text/css">
		#kott{
			border:1px solid #000;
			padding:5px;
			position:absolute;
			top:12px;
			right:5px;
		}
		#content{
			width:550px;
		}
		#head-content{
			width:100%;
			border-bottom:1px solid #000;
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
			padding:0px;
			width:100%;
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
</head>
<body>
<!--body onLoad="deteksiPrinter()">
	<applet name="jzebra" code="jzebra.PrintApplet.class" archive="./jzebra.jar" width="0px" height="0px"></applet-->

<div id="idArea" style="display:block;">
		<?php	
			if ($iduser_jual!=""){
				$qrySingle="SELECT a_penjualan.*,a_mitra.NAMA AS kso_nama,a_kepemilikan.NAMA,a_user.username,UNIT_NAME,a_cara_bayar.nama as cb, a_cara_bayar.id as cb_id/* , a_penjualan.DIJAMIN */
				from a_penjualan left Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_unit on a_unit.UNIT_ID=a_penjualan.RUANGAN Left Join a_user on a_penjualan.USER_ID=a_user.kode_user LEFT JOIN a_mitra ON a_penjualan.KSO_ID=a_mitra.IDMITRA left join a_cara_bayar on a_penjualan.cara_bayar=a_cara_bayar.id WHERE a_penjualan.NO_PENJUALAN='$no_penjualan' and a_penjualan.UNIT_ID=$idunit AND a_penjualan.NO_PASIEN='$no_pasien' AND a_penjualan.TGL='$tgl' AND a_penjualan.USER_ID=$iduser_jual GROUP BY a_penjualan.NO_PENJUALAN";
			}else{
				$qrySingle="SELECT a_penjualan.*,a_mitra.NAMA AS kso_nama,a_kepemilikan.NAMA,a_user.username,UNIT_NAME,a_cara_bayar.nama as cb, a_cara_bayar.id as cb_id/* , a_penjualan.DIJAMIN */
				from a_penjualan left Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_unit on a_unit.UNIT_ID=a_penjualan.RUANGAN Left Join a_user on a_penjualan.USER_ID=a_user.kode_user LEFT JOIN a_mitra ON a_penjualan.KSO_ID=a_mitra.IDMITRA left join a_cara_bayar on a_penjualan.cara_bayar=a_cara_bayar.id WHERE a_penjualan.NO_PENJUALAN='$no_penjualan' and a_penjualan.UNIT_ID=$idunit AND a_penjualan.NO_PASIEN='$no_pasien' AND a_penjualan.TGL='$tgl' GROUP BY a_penjualan.NO_PENJUALAN";
			}
			//echo $qrySingle;
			$exeSingle=mysqli_query($konek,$qrySingle) or die(mysqli_error($konek)." - 880");	
			$showSingle=mysqli_fetch_array($exeSingle);	
			$qty_retur=$showSingle['QTY_RETUR'];	
			$htot=0;
			$njual=$showSingle['NO_PENJUALAN'];	
			
			/* cek bayar */
			
						
			$sByrC = "SELECT ku.NO_BAYAR, DATE_FORMAT(ku.TGL_BAYAR, '%d-%m-%Y %H:%i:%s') TGL_BAYAR, ku.USER_ID,
						  IF(ku.IS_AKTIF = 1, u.username, peg.nama) username 
						FROM a_kredit_utang ku
						INNER JOIN a_penjualan ap
						   ON ap.NO_PENJUALAN = ku.FK_NO_PENJUALAN
						/*  AND ap.UNIT_ID = ku.UNIT_ID*/
						  AND ap.NO_KUNJUNGAN = ku.NO_PELAYANAN
						  AND ap.NO_PASIEN = ku.NORM
						LEFT JOIN a_user u 
						   ON u.kode_user = ku.USER_ID 
						LEFT JOIN bangil_billing.b_ms_pegawai peg 
						   ON peg.id = ku.USER_ID 
						WHERE ku.NO_BAYAR = '{$no_bayar}'
						  AND ap.NO_PENJUALAN = '{$no_penjualan}'
						  AND ap.UNIT_ID = '{$idunit}'
						  AND ap.TGL = '{$tgl}'
						GROUP BY ku.NO_BAYAR";
			//echo $sByrC;
			$qByrC = mysqli_query($konek,$sByrC);
			$dByrC = mysqli_fetch_array($qByrC);
		?>	
	<div id="content">
		<div id="head-content">
			<!--div id="head-content-left">RSUD SIDOARJO<br>Jl.Majapahit No.667 Sidoarjo</div>
			<div id="head-content-right"><?php echo $apname; ?></div>
			<div class="clear"></div-->
			<table id="head-table">
				<td><?php echo $namaRS; ?><br><?php echo $alamatRS;?> - <?php echo $kotaRS; ?></td>
				<td valign="bottom" align="right"><?php echo $apname; ?></td>
			</table>
		</div>
		<div id="head-content-detil">
			<table id="head-table">
				<tr>
					<td width="168">No. Pembayaran</td>
					<td>:</td>
					<td><?php echo $dByrC['NO_BAYAR']; ?></td>
				</tr>
				<tr>
					<td width="168">Tgl. Pembayaran</td>
					<td>:</td>
					<td><?php echo $dByrC['TGL_BAYAR']." / ".$dByrC['username']; ?></td>
				</tr>
				<tr>
					<td>Pasien/No. RM</td>
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
			
			<table id="head-table">
				<tr>
					<td class='border' align='center' width="50">No</td>
					<td class='border' align='left' width="">Nama Obat</td>
					<td class='border' align='center' width="100">Jumlah</td>
					<td class='border' align='center' width="120">Nilai</td>
				</tr>
				<?php 
					if ($iduser_jual!=""){
						$fuserID = "AND ap.USER_ID = '{$iduser_jual}'";
						
						$sqlPrint= "SELECT NO_PENJUALAN, TGL_ACT, NO_KUNJUNGAN, NO_PASIEN, NAMA_PASIEN, JENIS_PASIEN_ID, a_p.OBAT_ID,
						  o.OBAT_NAMA, o.OBAT_SATUAN_KECIL, SUM( ap.QTY_JUAL * HARGA_SATUAN ) total_awal,
						  SUM(ap.QTY) AS QTY, SUM(ap.QTY_JUAL) AS QTY_JUAL, SUM(ap.QTY_RETUR) AS QTY_RETUR, SUM(ap.QTY_JUAL*ap.HARGA_KSO) AS dijamin_kso,ap.EMBALAGE,
						  SUM(ap.QTY_JUAL*ap.HARGA_PX) AS iur_px, ap.PPN_NILAI
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
						  $fuserID
						GROUP BY ap.NO_PENJUALAN, o.OBAT_ID";						
					}else{
						$fuserID = "";
						
						$sqlPrint= "SELECT NO_PENJUALAN, TGL_ACT, NO_KUNJUNGAN, NO_PASIEN, NAMA_PASIEN, JENIS_PASIEN_ID, a_p.OBAT_ID,
						  o.OBAT_NAMA, o.OBAT_SATUAN_KECIL, SUM( ap.QTY_JUAL * HARGA_SATUAN ) total_awal,
						  SUM(ap.QTY) AS QTY, SUM(ap.QTY_JUAL) AS QTY_JUAL, SUM(ap.QTY_RETUR) AS QTY_RETUR, 
						  SUM(ap.QTY_JUAL*ap.HARGA_KSO) AS dijamin_kso,ap.EMBALAGE,
						  SUM(ap.QTY_JUAL*ap.HARGA_PX) AS iur_px, ap.PPN_NILAI
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
						  $fuserID
						GROUP BY ap.NO_PENJUALAN, o.OBAT_ID";
					}
					//echo $sqlPrint;
					$exePrint=mysqli_query($konek,$sqlPrint) or die (mysqli_error($konek)." -  1038");
					$k=mysqli_num_rows($exePrint);
					$i=1;
					$dijamin_kso = $iur_px = $retTot = $ppn_nilai = 0;
					//echo $ada_retur;
				while($showPrint=mysqli_fetch_array($exePrint)){
					$ppn_nilai = $showPrint['PPN_NILAI'];
					if ($ada_retur>0 && $bayar == '1'){
						$sReturG = "SELECT rp.no_retur, rp.userid_retur, DATE_FORMAT( rp.tgl_retur, '%d-%m-%Y %H:%i:%s' ) tgl,
									  SUM(rp.qty_retur) qty_retur, ap.HARGA_SATUAN, SUM((rp.qty_retur) * ap.HARGA_SATUAN) total_retur,
									  p.OBAT_ID, SUM(rp.qty_retur*ap.HARGA_KSO) as ret_kso, SUM(rp.qty_retur*ap.HARGA_PX) as ret_px
									FROM
									  a_return_penjualan rp 
									  INNER JOIN a_penjualan ap 
										ON ap.ID = rp.idpenjualan 
									  INNER JOIN a_penerimaan p 
										ON p.ID = ap.PENERIMAAN_ID 
									WHERE ap.NO_PENJUALAN = '{$no_penjualan}' 
									  AND ap.UNIT_ID = '{$idunit}' 
									  AND ap.TGL = '{$tgl}' 
									  {$fuserID}
									  AND DATE_FORMAT( rp.tgl_retur, '%d-%m-%Y %H:%i:%s' ) < '".$dByrC['TGL_BAYAR']."'
									  AND p.OBAT_ID = '".$showPrint['OBAT_ID']."'";
						//echo $sReturG."<br /><br />";
						$qReturG = mysqli_query($konek,$sReturG) or die(mysqli_error($konek));
						$ret_kso = $ret_px = 0;
						$dReturG = mysqli_fetch_array($qReturG);
						$retTot = ($dReturG['total_retur']*1);
				?>
				<tr> 
					<td align="center"><?php echo $i++; ?></td>
					<td ><?php echo $showPrint['OBAT_NAMA']; ?></td>
					<td align="center"><?php echo ((int)$showPrint['QTY_JUAL'] - (int)$dReturG['qty_retur']); ?></td>
					<!--td align="right" class="style1"><?php echo number_format($showPrint['HARGA_SATUAN'],0,',','.'); ?></td-->
					<?php
						$jTot = (($showPrint['total_awal']*1)+$showPrint['EMBALAGE']) - ($dReturG['total_retur']*1);
						$htot+=$jTot;
						$ret_kso = $showPrint['dijamin_kso'] - $dReturG['ret_kso'];
						$ret_px = $showPrint['iur_px'] - $dReturG['ret_px'];
						
						$dijamin_kso += $ret_kso;
						$iur_px += $ret_px;
					?>
					<td align="right"><?php echo number_format($jTot,0,',','.'); ?>&nbsp;&nbsp;</td>
				</tr>
				<?php 	
					} else {
				?>
				<tr> 
					<td align="center"><?php echo $i++ ?></td>
					<td ><?php echo $showPrint['OBAT_NAMA']; ?></td>
					<td align="center"><?php echo $showPrint['QTY_JUAL']; ?></td>
					<!--td width="50" align="right" class="style1"><?php echo number_format($showPrint['total_awal'],0,',','.'); ?></td-->
					<td align="right"> <!--?php if ($i>$k){?>style="border-bottom:1px dashed #999999"<-?php }?--><?php echo number_format($showPrint['total_awal']+$showPrint['EMBALAGE'],0,',','.');//echo number_format(floor($showPrint['QTY_JUAL'] * $showPrint['HARGA_SATUAN']),0,',','.'); ?>&nbsp;&nbsp;</td>
				</tr>
				<?php 
						$htot += $showPrint['total_awal']+$showPrint['EMBALAGE']; //floor($showPrint['QTY_JUAL'] * $showPrint['HARGA_SATUAN']);
						$dijamin_kso += $showPrint['dijamin_kso'];
						$iur_px += $showPrint['iur_px'];
					}
				} 
				$class = "border-top";
				if($ppn_nilai > 0){
					$class = "";
				?>
					<tr align="right" class="border-top"> 
						<td colspan="3">Total :</td>
						<td><?php echo number_format($htot,0,",","."); ?>&nbsp;&nbsp;</td>
					</tr>
					<tr align="right"> 
						<td colspan="3">PPN 10% :</td>
						<td><?php echo number_format($ppn_nilai,0,",","."); ?>&nbsp;&nbsp;</td>
					</tr>
				<?php } ?>
				<tr align="right" class="<?php echo $class; ?>"> 
					<td colspan="3">Total Tagihan :</td>
					<td><?php echo number_format($htot+$ppn_nilai,0,",","."); ?>&nbsp;&nbsp;</td>
				</tr>
				<?php
				if($showSingle['DIJAMIN'] == '1'){
				?>
				<tr align="right" class="border-top"> 
					<td colspan="3">Dijamin KSO :</td>
					<td><?php echo number_format($dijamin_kso,0,",","."); ?>&nbsp;&nbsp;</td>
				</tr>	
				<tr align="right" class="border-top" style="font-weight:bold;"> 
					<td colspan="3">Tagihan Pasien :</td>
					<td><?php echo number_format($iur_px,0,",","."); ?>&nbsp;&nbsp;</td>
				</tr>	
				<?php
				}
					
					if($bayar == '1'){
						if($showSingle['cb_id'] == '2' || $showSingle['cb_id'] == '4'){
							$sBayar = "SELECT *
										FROM (SELECT ap.NO_PASIEN noRM,
												  IFNULL(ku.NO_BAYAR, ap.NO_PENJUALAN) no_bayar,
												  ap.NO_PENJUALAN no_penjualan,
												  IFNULL( IF(ku.BAYAR <> 0, ku.BAYAR, ku.BAYAR_UTANG), ap.HARGA_TOTAL ) bayar_,
												  ku.BAYAR bayar,
												  IFNULL(ku.KEMBALI, 0) kembali 
												FROM a_penjualan ap
												INNER JOIN a_kredit_utang ku
												   ON ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN
												/*  AND ku.UNIT_ID = ap.UNIT_ID */
												  AND ku.NO_PELAYANAN = ap.NO_KUNJUNGAN
												  AND ku.NORM = ap.NO_PASIEN
												WHERE ap.NO_PENJUALAN = '{$no_penjualan}' 
												/*  AND ap.UNIT_ID = '{$idunit}' */ 
												  AND ap.TGL = '{$tgl}' 
												  AND ap.CARA_BAYAR IN (2,4)) t1
										GROUP BY t1.no_bayar";
						} else {
							$sBayar = "SELECT 
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
													GROUP BY ku2.FK_NO_PENJUALAN, ku2.UNIT_ID) ku
										   ON ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN
										 /* AND ku.UNIT_ID = ap.UNIT_ID */
										WHERE ap.NO_PENJUALAN = '{$no_penjualan}' 
										/  AND ap.UNIT_ID = '{$idunit}' */
										  AND ap.TGL = '{$tgl}'
										  AND ap.CARA_BAYAR NOT IN (2,4)";
						}
						//echo $sBayar."<br /><br />";
						$qBayar = mysqli_query($konek,$sBayar);
						$dBayar = mysqli_fetch_array($qBayar);
				?>
				<tr align="right" class="border-top">
					<td colspan="3">Bayar :</td>
					<td><?php echo number_format($dBayar['bayar_'],0,",","."); ?>&nbsp;&nbsp;</td>
				</tr>
				<tr align="right" class='border-bottom'>
					<td colspan="3">Kembali :</td>
					<td><?php echo number_format(($dBayar['bayar_']-($htot+$ppn_nilai)),0,",","."); ?><!--<?php echo number_format($dBayar['kembali'],0,",","."); ?>-->&nbsp;&nbsp;</td>
				</tr>
				<?php } ?>
			</table>
			
			<table id="head-table" style="font-size:11px;">
				<tr>
					<td width="100">No. Penjualan</td>
					<td width="10">:</td>
					<td><?php echo $njual; ?></td>
				</tr>
				<?php 
					$sRetC = "SELECT GROUP_CONCAT(DISTINCT(t1.no_retur) SEPARATOR ', ') no_retur
								FROM (SELECT 
										  rp.no_retur,
										  rp.userid_retur,
										  DATE_FORMAT(rp.tgl_retur, '%d-%m-%Y %H:%i:%s') tgl 
										FROM
										  a_return_penjualan rp 
										  INNER JOIN a_penjualan ap 
											ON ap.ID = rp.idpenjualan 
										WHERE ap.NO_PENJUALAN = '{$no_penjualan}' 
										  AND ap.UNIT_ID = '{$idunit}' 
										  AND ap.TGL = '{$tgl}'
										  {$fuserID}
										  AND DATE_FORMAT(rp.tgl_retur,'%d-%m-%Y %H:%i:%s') < '".$dByrC['TGL_BAYAR']."') t1";
					$qRetC = mysqli_query($konek,$sRetC);
					$dRetC = mysqli_fetch_array($qRetC);
				?>
				<tr>
					<td>No. Retur</td>
					<td>:</td>
					<td><?php echo $dRetC['no_retur']; ?></td>
				</tr>
			</table>
			
		<!-- Tak Terpakai -->
		<?php if($bayar == '123') { ?>
			<table id="head-table" style="font-size:11px;">
				<tr>
					<td width="20px">No.</td>
					<td>No. Transaksi</td>
					<td>User</td>
					<td>Tgl/Jam</td>
				</tr>
				<?php	
					if($showSingle['cb_id'] == '2' || $showSingle['cb_id'] == '4'){
						$join = "INNER JOIN a_kredit_utang ku
									ON ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN";
						$where = "AND ap.CARA_BAYAR IN (2,4) 
								  AND ku.TGL_BAYAR < rp.tgl_retur
								  AND ap.KSO_ID <> 88";
								  
						/* syarat bayar bukan kredit/piutang lain */
						$select_byr = "IFNULL(bp.no_bayar, CONCAT('PY/',ku.FK_NO_PENJUALAN)) nomer,
									   IFNULL(bp.user_act,ku.USER_ID) userID,
									   DATE_FORMAT(IFNULL(bp.tgl_act,ku.TGL_BAYAR),'%d-%m-%Y %H:%i:%s') tgl";
						$where_byr = "AND ap.CARA_BAYAR IN (2,4)";
					} else {						
						/* syarat bayar tunai */
						$join = "";
						$where_byr = $where = "AND ap.CARA_BAYAR NOT IN (2,4)";
						$select_byr = "IFNULL(bp.no_bayar, CONCAT('PY/',ap.NO_PENJUALAN)) nomer,
									   IFNULL(bp.user_act,ap.USER_ID) userID,
									   DATE_FORMAT(IFNULL(bp.tgl_act,ap.TGL_ACT),'%d-%m-%Y %H:%i:%s') tgl";
					}
					$sDet_ = "SELECT DISTINCT {$select_byr}
							FROM a_penjualan ap
							LEFT JOIN a_bayar_pasien bp
							   ON bp.no_penjualan = ap.NO_PENJUALAN
							{$join}
							WHERE ap.NO_PENJUALAN = '{$no_penjualan}'
							  AND ap.UNIT_ID = '{$idunit}'
							  {$where_byr}
							UNION
							SELECT concat('RT/',rp.no_retur) no_retur, rp.userid_retur, 
							  DATE_FORMAT(rp.tgl_retur,'%d-%m-%Y %H:%i:%s') tgl
							FROM a_return_penjualan rp
							INNER JOIN a_penjualan ap
							   ON ap.ID = rp.idpenjualan
							WHERE ap.NO_PENJUALAN = '{$no_penjualan}'
							  AND ap.UNIT_ID = '{$idunit}'
							UNION
							SELECT DISTINCT IFNULL(pu.no_pengembalian, CONCAT('RP/',rp.no_retur)) no_pengembalian,
							  IFNULL(pu.user_act,rp.userid_retur) user_act,
							  DATE_FORMAT(IFNULL(pu.tgl_act,rp.tgl_retur),'%d-%m-%Y %H:%i:%s') tgl
							FROM a_return_penjualan rp
							INNER JOIN a_penjualan ap
							   ON ap.ID = rp.idpenjualan
							{$join}
							LEFT JOIN a_pengembalian_uang pu
							   ON pu.no_penjualan = ap.NO_PENJUALAN
							  AND pu.no_retur = rp.no_retur
							WHERE ap.NO_PENJUALAN = '{$no_penjualan}'
							  AND ap.UNIT_ID = '{$idunit}'
							  {$where}";
					
					$sDet = "SELECT DISTINCT IFNULL( ku.NO_BAYAR, CONCAT('PY/', ap.NO_PENJUALAN)) nomer,
							  IFNULL(ku.USER_ID, ap.USER_ID) userID,
							  DATE_FORMAT(IFNULL(ku.TGL_BAYAR, ap.TGL_ACT), '%d-%m-%Y %H:%i:%s') tgl 
							FROM
							  a_penjualan ap 
							  LEFT JOIN a_kredit_utang ku 
								ON ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN 
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
							  {$where} */";
					//echo $sDet;
					$qDet = mysqli_query($konek,$sDet);
					if(mysqli_num_rows($qDet) > 0){
						$no = 1;
						while($dDet = mysqli_fetch_array($qDet)){
							$sUser = "select username from a_user where kode_user = '".$dDet['userID']."'";
							$qUser = mysqli_query($konek,$sUser);
							$dUser = mysqli_fetch_array($qUser);
							echo "<tr><td align='center'>{$no}.</td><td>".$dDet['nomer']."</td><td>".$dUser['username']."</td><td>".$dDet['tgl']."</td></tr>";
							$no++;
						}
					}
				?>
				<tr></tr>
			</table>
		<?php } ?>
		<!-- End Tak Terpakai -->
		
			<table id="head-table">
				<!--tr>
					<td width="168">Status</td>
					<td>:</td>
					<td><?php echo $showSingle['kso_nama']; ?></td>
				</tr>
				<tr>
					<td width="168">Tanggal Cetak</td>
					<td>:</td>
					<td><?php echo $tglact; ?></td>
				</tr>
				<tr>
					<td width="168">Petugas</td>
					<td>:</td>
					<td><?php echo $showSingle['username']; ?></td>
				</tr-->
				<tr>
					<td colspan="3">- Bukti Pembayaran Ini Juga Berlaku Sebagai Kwitansi</td>
				</tr>
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
			<BUTTON type="button" onClick="document.getElementById('btn').style.display='none';window.print();/*window.printZebra();*/window.close();"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">Cetak</BUTTON>
		</td>
		<td width="50%" align="right">
			<?php 
				if(($showSingle['cb_id'] == '2' || $showSingle['cb_id'] == '4') && $ada_retur <= '0' && $dBayar['bayar_'] <= '0' && date("d-m-Y",strtotime($showSingle['TGL'])) == $tglNow ){
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