<?php
	include("../koneksi/konek.php");
	include("../sesi.php");
	session_start();
	$iduser = $_SESSION["iduser"];
	$iduser_jual = $_REQUEST["iduser_jual"];
	$tglact=gmdate('d/m/Y H:i:s',mktime(date('H')+7));
	$tglNow=gmdate('d-m-Y',mktime(date('H')+7));
	
	$idunit=$_GET["sunit"];
	$no_penjualan=$_GET['no_penjualan'];
	$no_retur = $_GET['no_retur'];
	$no_pasien=$_GET['no_pasien'];
	$viewdel=$_GET['viewdel'];
	if ($iduser!=133 && $iduser!=225 && $iduser!=226 && $iduser!=223 && $iduser!=7 && $iduser!=499) $viewdel="false";
	$tgl=$_GET['tgl'];
	$u="select UNIT_NAME from a_unit where UNIT_ID=$idunit";
	$rsu=mysqli_query($konek,$u);
	$row=mysqli_fetch_array($rsu);
	$apname=$row['UNIT_NAME'];

	if ($iduser_jual!=""){
		$sql="SELECT * FROM a_penjualan WHERE /*UNIT_ID=$idunit AND */ QTY_RETUR>0 AND NO_PENJUALAN='$no_penjualan' AND NO_PASIEN='$no_pasien' AND TGL='$tgl' AND USER_ID=$iduser_jual";
	}else{
		$sql="SELECT * FROM a_penjualan WHERE /*UNIT_ID=$idunit AND */QTY_RETUR>0 AND NO_PENJUALAN='$no_penjualan' AND NO_PASIEN='$no_pasien' AND TGL='$tgl'";
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
		 
		function printjZebra() {
			//var applet = document.jzebra;
			if (applet != null) {			
				<?php 					
					printHeader();					
					$hasil = printDataObat();					
					printFooter($hasil);
					
					function printHeader(){
						global $konek;
						$unit = $_GET["sunit"];
						$iduser_jual = $_REQUEST["iduser_jual"];
						$qnamaUnit="select UNIT_NAME from a_unit where UNIT_ID=$unit";
						$hasil=mysqli_query($konek,$qnamaUnit);
						$rowDataUnit=mysqli_fetch_array($hasil);
						$namaUnit=$rowDataUnit['UNIT_NAME'];
						
						$noPenjualan = $_GET['no_penjualan'];
						$noPasien = $_GET['no_pasien'];
						$tanggal = $_GET['tgl'];
						$no_retur = $_GET['no_retur'];
						if ($iduser_jual!=""){
							$fuserID = "AND ap.USER_ID = '{$iduser_jual}'";
							/* $qSingle="SELECT a_penjualan.*,a_mitra.NAMA AS kso_nama,a_kepemilikan.NAMA,a_user.username,UNIT_NAME,a_cara_bayar.nama as cb from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_unit on a_unit.UNIT_ID=a_penjualan.RUANGAN Left Join a_user on a_penjualan.USER_ID=a_user.kode_user LEFT JOIN a_mitra ON a_penjualan.KSO_ID=a_mitra.IDMITRA left join a_cara_bayar on a_penjualan.cara_bayar=a_cara_bayar.id WHERE a_penjualan.NO_PENJUALAN='$noPenjualan' and a_penjualan.UNIT_ID=$unit AND a_penjualan.NO_PASIEN='$noPasien' AND a_penjualan.TGL='$tanggal' AND a_penjualan.USER_ID=$iduser_jual"; */
							
							$qSingle = "SELECT DATE_FORMAT(rp.tgl_retur,'%d-%m-%Y %H:%i:%s') tgl_retur, rp.no_retur, 
											   ap.NO_PENJUALAN, ap.NAMA_PASIEN, ap.NO_PASIEN, u.username, ap.ALAMAT, ap.DOKTER,
											   un.UNIT_NAME, m.NAMA kso_nama, rp.tgl_retur tglRet
											FROM a_return_penjualan rp
											INNER JOIN a_penjualan ap
											   ON ap.ID = rp.idpenjualan
											INNER JOIN a_penerimaan p
											   ON p.ID = ap.PENERIMAAN_ID
											INNER JOIN a_obat o
											   ON o.OBAT_ID = p.OBAT_ID
											INNER JOIN a_user u
											   ON u.kode_user = rp.userid_retur
											LEFT JOIN a_unit un
											   ON un.UNIT_ID = ap.RUANGAN
											inner join a_mitra m
											   on m.IDMITRA = ap.KSO_ID
											WHERE ap.NO_PENJUALAN = '{$noPenjualan}'
											  AND rp.no_retur = '{$no_retur}'
											  /*AND ap.UNIT_ID = '{$unit}'*/
											  and rp.unit_id_return = '{$unit}'
											  AND ap.TGL = '{$tanggal}'
											  AND ap.USER_ID = '{$iduser_jual}'
											  AND ap.NO_PASIEN = '{$noPasien}'
											  {$fuserID}
											GROUP BY ap.NO_PASIEN";
						}else{
							$fuserID = "";
							/* $qSingle="SELECT a_penjualan.*,a_mitra.NAMA AS kso_nama,a_kepemilikan.NAMA,a_user.username,UNIT_NAME,a_cara_bayar.nama as cb from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_unit on a_unit.UNIT_ID=a_penjualan.RUANGAN Left Join a_user on a_penjualan.USER_ID=a_user.kode_user LEFT JOIN a_mitra ON a_penjualan.KSO_ID=a_mitra.IDMITRA left join a_cara_bayar on a_penjualan.cara_bayar=a_cara_bayar.id WHERE a_penjualan.NO_PENJUALAN='$noPenjualan' and a_penjualan.UNIT_ID=$unit AND a_penjualan.NO_PASIEN='$noPasien' AND a_penjualan.TGL='$tanggal'"; */
							
							$qSingle = "SELECT DATE_FORMAT(rp.tgl_retur,'%d-%m-%Y %H:%i:%s') tgl_retur, rp.no_retur, 
											   ap.NO_PENJUALAN, ap.NAMA_PASIEN, ap.NO_PASIEN, u.username, ap.ALAMAT, ap.DOKTER,
											   un.UNIT_NAME, m.NAMA kso_nama, rp.tgl_retur tglRet
											FROM a_return_penjualan rp
											INNER JOIN a_penjualan ap
											   ON ap.ID = rp.idpenjualan
											INNER JOIN a_penerimaan p
											   ON p.ID = ap.PENERIMAAN_ID
											INNER JOIN a_obat o
											   ON o.OBAT_ID = p.OBAT_ID
											INNER JOIN a_user u
											   ON u.kode_user = rp.userid_retur
											LEFT JOIN a_unit un
											   ON un.UNIT_ID = ap.RUANGAN
											inner join a_mitra m
											   on m.IDMITRA = ap.KSO_ID
											WHERE ap.NO_PENJUALAN = '{$noPenjualan}'
											  AND rp.no_retur = '{$no_retur}'
											 /* AND ap.UNIT_ID = '{$unit}' */
											 and rp.unit_id_return = '{$unit}'
											  AND ap.TGL = '{$tanggal}'
											  AND ap.NO_PASIEN = '{$noPasien}'
											  {$fuserID}
											GROUP BY ap.NO_PASIEN";
						}
						//echo $qrySingle;
						$rSingle = mysqli_query($konek,$qSingle);
						$rowSingle = mysqli_fetch_array($rSingle);
						
						/* if ($iduser_jual!=""){
							$sql="SELECT * FROM a_penjualan WHERE UNIT_ID=$unit AND QTY_RETUR>0 AND NO_PENJUALAN='$noPenjualan' AND NO_PASIEN='$noPasien' AND TGL='$tanggal' AND USER_ID=$iduser_jual";
						}else{
							$sql="SELECT * FROM a_penjualan WHERE UNIT_ID=$unit AND QTY_RETUR>0 AND NO_PENJUALAN='$noPenjualan' AND NO_PASIEN='$noPasien' AND TGL='$tanggal'";
						} */

						/* $rs=mysqli_query($konek,$sql);
						$ada_retur=mysqli_num_rows($rs); */
						
						$retur='';

						/* if ($rows=mysqli_fetch_array($rs)){
							$retur=$rows['NO_RETUR'];
							$tglretur=date("d/m/Y H:i",strtotime($rows['TGL_RETUR']));
						} */
						
						echo "applet.append(\"\\x1B\\x40\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\"\\x1B\\x30\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\"\\x1B\\x67\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\"\\x1B\\x6C\\x01\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\"\\x1B\\x51\\x3C\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\"\\x1B\\x43\\x2C\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\"\\x1B\\x78\\x30\")"; echo chr(59);echo "\n\t\t\t";	
						echo "applet.append(\"\\n\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\"RSUD BANGIL\\n\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\"Jl. Raya Raci Bangil - Pasuruan     $namaUnit\\n\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\"----------------------------------------------------\\n\")"; echo chr(59);echo "\n\t\t\t";
						$noKwitansi = $rowSingle['no_retur'];
						
						echo "applet.append(\"No. Retur     : $noKwitansi\\n\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\"Tgl. Retur    : ".$rowSingle['tgl_retur']." / ".$rowSingle['username']."\\n\")"; 
						echo chr(59);echo "\n\t\t\t";

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
						$iduser_jual = $_REQUEST["iduser_jual"];						
						$no_penjualan=$_GET['no_penjualan'];
						$no_pasien=$_GET['no_pasien'];		
						$unit = $_GET["sunit"];						
						$tanggal = $_GET['tgl'];					
						$no_retur = $_GET['no_retur'];
						$totRet = ($hasil[2] > 0)? $hasil[2] : $hasil[0];
						
						if ($iduser_jual!=""){
							$fuserID = "AND ap.USER_ID = '{$iduser_jual}'";
							/* $qSingle="SELECT a_penjualan.*,a_mitra.NAMA AS kso_nama,a_kepemilikan.NAMA,a_user.username,UNIT_NAME,a_cara_bayar.nama as cb from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_unit on a_unit.UNIT_ID=a_penjualan.RUANGAN Left Join a_user on a_penjualan.USER_ID=a_user.kode_user LEFT JOIN a_mitra ON a_penjualan.KSO_ID=a_mitra.IDMITRA left join a_cara_bayar on a_penjualan.cara_bayar=a_cara_bayar.id WHERE a_penjualan.NO_PENJUALAN='$noPenjualan' and a_penjualan.UNIT_ID=$unit AND a_penjualan.NO_PASIEN='$noPasien' AND a_penjualan.TGL='$tanggal' AND a_penjualan.USER_ID=$iduser_jual"; */
							
							$qSingle = "SELECT DATE_FORMAT(rp.tgl_retur,'%d-%m-%Y %H:%i:%s') tgl_retur, rp.no_retur, 
											   ap.NO_PENJUALAN, ap.NAMA_PASIEN, ap.NO_PASIEN, u.username, ap.ALAMAT, ap.DOKTER,
											   un.UNIT_NAME, m.NAMA kso_nama, rp.tgl_retur tglRet
											FROM a_return_penjualan rp
											INNER JOIN a_penjualan ap
											   ON ap.ID = rp.idpenjualan
											INNER JOIN a_penerimaan p
											   ON p.ID = ap.PENERIMAAN_ID
											INNER JOIN a_obat o
											   ON o.OBAT_ID = p.OBAT_ID
											INNER JOIN a_user u
											   ON u.kode_user = rp.userid_retur
											LEFT JOIN a_unit un
											   ON un.UNIT_ID = ap.RUANGAN
											inner join a_mitra m
											   on m.IDMITRA = ap.KSO_ID
											WHERE ap.NO_PENJUALAN = '{$no_penjualan}'
											  AND rp.no_retur = '{$no_retur}'
											 /* AND ap.UNIT_ID = '{$unit}'*/
											 and rp.unit_id_return = '{$unit}'
											  AND ap.TGL = '{$tanggal}'
											  AND ap.USER_ID = '{$iduser_jual}'
											  AND ap.NO_PASIEN = '{$no_pasien}'
											  {$fuserID}
											GROUP BY ap.NO_PASIEN";
						}else{
							$fuserID = "";
							/* $qSingle="SELECT a_penjualan.*,a_mitra.NAMA AS kso_nama,a_kepemilikan.NAMA,a_user.username,UNIT_NAME,a_cara_bayar.nama as cb from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_unit on a_unit.UNIT_ID=a_penjualan.RUANGAN Left Join a_user on a_penjualan.USER_ID=a_user.kode_user LEFT JOIN a_mitra ON a_penjualan.KSO_ID=a_mitra.IDMITRA left join a_cara_bayar on a_penjualan.cara_bayar=a_cara_bayar.id WHERE a_penjualan.NO_PENJUALAN='$noPenjualan' and a_penjualan.UNIT_ID=$unit AND a_penjualan.NO_PASIEN='$noPasien' AND a_penjualan.TGL='$tanggal'"; */
							
							$qSingle = "SELECT DATE_FORMAT(rp.tgl_retur,'%d-%m-%Y %H:%i:%s') tgl_retur, rp.no_retur, 
											   ap.NO_PENJUALAN, ap.NAMA_PASIEN, ap.NO_PASIEN, u.username, ap.ALAMAT, ap.DOKTER,
											   un.UNIT_NAME, m.NAMA kso_nama, rp.tgl_retur tglRet
											FROM a_return_penjualan rp
											INNER JOIN a_penjualan ap
											   ON ap.ID = rp.idpenjualan
											INNER JOIN a_penerimaan p
											   ON p.ID = ap.PENERIMAAN_ID
											INNER JOIN a_obat o
											   ON o.OBAT_ID = p.OBAT_ID
											INNER JOIN a_user u
											   ON u.kode_user = rp.userid_retur
											LEFT JOIN a_unit un
											   ON un.UNIT_ID = ap.RUANGAN
											inner join a_mitra m
											   on m.IDMITRA = ap.KSO_ID
											WHERE ap.NO_PENJUALAN = '{$no_penjualan}'
											  AND rp.no_retur = '{$no_retur}'
											/*  AND ap.UNIT_ID = '{$unit}' */
											and rp.unit_id_return = '{$unit}'
											  AND ap.TGL = '{$tanggal}'
											  AND ap.NO_PASIEN = '{$no_pasien}'
											  {$fuserID}
											GROUP BY ap.NO_PASIEN";
						}
						//echo $qSingle;
						$rSingle = mysqli_query($konek,$qSingle);
						$showSingle = mysqli_fetch_array($rSingle);
						
						if ($iduser_jual!=""){
							$fuserID = "AND ap.USER_ID = '{$iduser_jual}'";
							$sql="SELECT * FROM a_penjualan WHERE UNIT_ID=$unit AND QTY_RETUR>0 AND NO_PENJUALAN='$no_penjualan' AND NO_PASIEN='$no_pasien' AND TGL='$tanggal' AND USER_ID=$iduser_jual";
						}else{
							$fuserID = "";
							$sql="SELECT * FROM a_penjualan WHERE UNIT_ID=$unit AND QTY_RETUR>0 AND NO_PENJUALAN='$no_penjualan' AND NO_PASIEN='$no_pasien' AND TGL='$tanggal'";
						}	
						
						/*
						$cekretur=mysqli_query($konek,$sql);
						$ada_retur=mysqli_num_rows($cekretur);
						$retur="";
						
						if ($rows=mysqli_fetch_array($cekretur)){
							$retur=$rows['NO_RETUR'];
							$tglretur=date("d/m/Y H:i",strtotime($rows['TGL_RETUR']));
						}
													
						if($ada_retur){ 
							echo "applet.append(\"             Nilai sebelum retur      : "; 
						}
						else
						{*/
						
						echo "applet.append(\"             Total Retur              : "; 
						//}
						
						
						$nilai_sebelum_retur = number_format($hasil[0],0,",","."); 
						$spasiNilaiTotal = 12 - strlen((string)$nilai_sebelum_retur);	
						
						for($j=0;$j<$spasiNilaiTotal;$j++){
									echo " ";
						}
						echo "$nilai_sebelum_retur"; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";
						
						/* get nilai sudah bayar */
						$sudahB_ = "SELECT IF(IFNULL(ku.TOTAL_HARGA,0) <> 0, ku.TOTAL_HARGA, ku.BAYAR_UTANG) TOTAL_HARGA, ku.TGL_BAYAR, 
							IFNULL(ku.NO_BAYAR, ap.NO_PENJUALAN) NO_BAYAR
						FROM a_penjualan ap
						LEFT JOIN (SELECT ku2.FK_NO_PENJUALAN, SUM(ku2.BAYAR_UTANG) BAYAR_UTANG, ku2.BAYAR, ku2.KEMBALI, ku2.NORM, ku2.NO_BAYAR, 
								ku2.NO_PELAYANAN, ku2.TGL_BAYAR, ku2.TOTAL_HARGA, ku2.UNIT_ID, ku2.USER_ID, ku2.CARA_BAYAR
							   FROM a_kredit_utang ku2
							   WHERE ku2.NORM = '{$no_pasien}'
							   GROUP BY ku2.FK_NO_PENJUALAN, ku2.UNIT_ID) ku
						   ON ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN
						  and ku.UNIT_ID = ap.UNIT_ID
						WHERE ap.NO_PENJUALAN = '{$no_penjualan}'
						  AND DATE_FORMAT(ku.TGL_BAYAR,'%d-%m-%Y %H:%i:%s') < '".$showSingle['tgl_retur']."'
						  AND ap.CARA_BAYAR IN (2,4)
						  AND ap.KRONIS = 0
						  AND ap.UNIT_ID = '{$unit}'
						  AND ap.TGL = '{$tanggal}'
						  AND ap.NO_PASIEN = '{$no_pasien}'
						  {$fuserID}
						GROUP BY ap.NO_PENJUALAN";
						
						$sudahB = "SELECT 
								  IF( IFNULL(ku.TOTAL_HARGA, 0) <> 0, ku.TOTAL_HARGA, ku.BAYAR_UTANG ) TOTAL_HARGA,
								  ku.TGL_BAYAR, IFNULL(ku.NO_BAYAR, ap.NO_PENJUALAN) NO_BAYAR 
								FROM
								  a_penjualan ap 
								  LEFT JOIN (SELECT * FROM a_kredit_utang ku2 WHERE ku2.NORM = '{$no_pasien}') ku 
									ON ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN 
									AND DATE(ku.TGL_BAYAR) = DATE(ap.TGL_BAYAR_ACT)
									/*AND ku.TGL_BAYAR >= ap.TGL_ACT*/
									AND ku.NORM = ap.NO_PASIEN 
									AND ku.NO_PELAYANAN = ap.NO_KUNJUNGAN 
									AND ku.UNIT_ID = ap.UNIT_ID
								WHERE ap.NO_PENJUALAN = '{$no_penjualan}'
								  /*AND DATE_FORMAT(ku.TGL_BAYAR,'%d-%m-%Y %H:%i:%s') < '".$showSingle['tgl_retur']."'*/
								  AND ku.TGL_BAYAR < '".$showSingle['tglRet']."'
								  AND ap.KRONIS = 0 
								  AND ap.CARA_BAYAR IN (2,4)
								  AND ap.UNIT_ID = '{$unit}'
								  AND ap.TGL = '{$tanggal}'
								  AND ap.NO_PASIEN = '{$no_pasien}'
								  {$fuserID}
								GROUP BY ku.NO_BAYAR";
						$qsudahB1 = mysqli_query($konek,$sudahB);
						if(mysqli_num_rows($qsudahB1) > 0){
							$dsudahB1 = mysqli_fetch_array($qsudahB1);
							$sudahByr = ($dsudahB1['TOTAL_HARGA'] != "")? $dsudahB1['TOTAL_HARGA'] : "0";
							$tglSdhByr = $dsudahB1['TGL_BAYAR'];
							$no_bayar = $dsudahB1['NO_BAYAR'];
						} else {
							$sudahB_ = "SELECT IF(IFNULL(ku.TOTAL_HARGA,0) <> 0, ku.TOTAL_HARGA, IF(ku.BAYAR_UTANG <> 0, ku.BAYAR_UTANG, ap.HARGA_TOTAL)) TOTAL_HARGA,
								IFNULL(ku.TGL_BAYAR,ap.TGL_ACT) TGL_BAYAR, IFNULL(ku.NO_BAYAR, ap.NO_PENJUALAN) NO_BAYAR
							FROM a_penjualan ap
							LEFT JOIN (SELECT ku2.FK_NO_PENJUALAN, SUM(ku2.BAYAR_UTANG) BAYAR_UTANG, ku2.BAYAR, ku2.KEMBALI, ku2.NORM, ku2.NO_BAYAR, 
									ku2.NO_PELAYANAN, ku2.TGL_BAYAR, ku2.TOTAL_HARGA, ku2.UNIT_ID, ku2.USER_ID, ku2.CARA_BAYAR
								   FROM a_kredit_utang ku2
								   WHERE ku2.NORM = '{$no_pasien}'
								   GROUP BY ku2.FK_NO_PENJUALAN, ku2.UNIT_ID) ku
							   ON ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN
							  and ku.UNIT_ID = ap.UNIT_ID
							WHERE ap.NO_PENJUALAN = '{$no_penjualan}'
							  AND DATE_FORMAT(ku.TGL_BAYAR,'%d-%m-%Y %H:%i:%s') < '".$showSingle['tgl_retur']."'
							  AND ap.CARA_BAYAR = 1
							  AND ap.UNIT_ID = '{$unit}'
							  AND ap.TGL = '{$tanggal}'
							  AND ap.NO_PASIEN = '{$no_pasien}'
							  {$fuserID}
							GROUP BY ap.NO_PENJUALAN";
							
							$sudahB = "SELECT IF( IFNULL(ku.TOTAL_HARGA, 0) <> 0, ku.TOTAL_HARGA, IF( ku.BAYAR_UTANG <> 0, ku.BAYAR_UTANG,
										  ap.HARGA_TOTAL ) ) TOTAL_HARGA,
									  IFNULL(ku.TGL_BAYAR, ap.TGL_ACT) TGL_BAYAR, IFNULL(ku.NO_BAYAR, ap.NO_PENJUALAN) NO_BAYAR 
									FROM
									  a_penjualan ap 
									  LEFT JOIN (SELECT * FROM a_kredit_utang ku2 WHERE ku2.NORM = '{$no_pasien}') ku 
										ON ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN 
										AND DATE(ku.TGL_BAYAR) = DATE(ap.TGL_BAYAR_ACT)
										/*AND ku.TGL_BAYAR >= ap.TGL_ACT*/
										AND ku.NORM = ap.NO_PASIEN 
										AND ku.NO_PELAYANAN = ap.NO_KUNJUNGAN 
										AND ku.UNIT_ID = ap.UNIT_ID 
									WHERE ap.NO_PENJUALAN = '{$no_penjualan}'
									  /*AND DATE_FORMAT(ku.TGL_BAYAR,'%d-%m-%Y %H:%i:%s') < '".$showSingle['tgl_retur']."'*/
									  AND ku.TGL_BAYAR < '".$showSingle['tglRet']."'
									  AND ap.CARA_BAYAR = 1 
									 /* AND ap.UNIT_ID = '{$unit}' */
									 
									  AND ap.TGL = '{$tanggal}' 
									  AND ap.NO_PASIEN = '{$no_pasien}' 
									  {$fuserID}
									GROUP BY ap.NO_PENJUALAN";
							$qsudahB2 = mysqli_query($konek,$sudahB);
							$dsudahB2 = mysqli_fetch_array($qsudahB2);
							$sudahByr = ($dsudahB2['TOTAL_HARGA'] != "")? $dsudahB2['TOTAL_HARGA'] : "0";
							$tglSdhByr = $dsudahB2['TGL_BAYAR'];
							$no_bayar = $dsudahB2['NO_BAYAR'];
						}
						
						//echo $sudahB;
						
						/* cek retur sebelumnya */
						if($tglSdhByr != ""){
							$sretCek = "SELECT rp.nilai, rp.tgl_retur
										FROM a_return_penjualan rp
										INNER JOIN a_penjualan ap
										   ON ap.ID = rp.idpenjualan
										WHERE ap.NO_PENJUALAN = '{$no_penjualan}'
										 /* AND ap.UNIT_ID = '{$unit}' */
										 and rp.unit_id_return = '{$unit}'
										  AND ap.TGL = '{$tanggal}'
										  AND ap.NO_PASIEN = '{$no_pasien}'
										  {$fuserID}
										  AND rp.tgl_retur > '{$tglSdhByr}'
										  AND DATE_FORMAT(rp.tgl_retur,'%d-%m-%Y %H:%i:%s') < '".$showSingle['tgl_retur']."'
										  AND rp.no_retur <> '".$showSingle['no_retur']."'";
							$qretCek = mysqli_query($konek,$sretCek);
							if(mysqli_num_rows($qretCek) > 0){
								$dretCek = mysqli_fetch_array($qretCek);
								if($dretCek['nilai'] != ""){
									$retBefor = $dretCek['nilai'];
								} else {
									$retBefor = 0;
								}
							}
						} else {
							$retBefor = 0;
						}
						$sudahByr -= $retBefor;
						$balik = 0;
						if((int)$sudahByr > 0){
							$balik = $totRet;
						}
						echo "applet.append(\"----------------------------------------------------\\n\")"; echo chr(59);echo "\n\t\t\t";
						//echo "applet.append(\"             Sudah Bayar              : "; 
						/* echo "applet.append(\"             Total Bayar Awal         : "; 
						//echo number_format($sudahByr,0,",",".");
						$nBayar = number_format($sudahByr,0,",","."); 
						$spasiNilaiTotal = 12 - strlen((string)$nBayar);	
						
						for($j=0;$j<$spasiNilaiTotal;$j++){
									echo " ";
						}
						echo "$nBayar"; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";
						
						//$totalSRet = $nBayar-$nilai_sebelum_retur;
						echo "applet.append(\"             Total Sesudah Retur      : "; 
						//echo number_format($sudahByr,0,",",".");
						$totalSRet = number_format(($sudahByr-$hasil[0]),0,",","."); 
						$spasiNilaiTotal = 12 - strlen((string)$totalSRet);	
						
						for($j=0;$j<$spasiNilaiTotal;$j++){
									echo " ";
						}
						echo "$totalSRet"; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";
						
						echo "applet.append(\"----------------------------------------------------\\n\")"; echo chr(59);echo "\n\t\t\t"; */
						echo "applet.append(\"             Pengembalian             : "; 
						//echo number_format($balik,0,",",".");
						$nBalik = number_format($balik,0,",","."); 
						$spasiNilaiTotal = 12 - strlen((string)$nBalik);	
						
						for($j=0;$j<$spasiNilaiTotal;$j++){
									echo " ";
						}
						echo "$nBalik"; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";
						
						/* if($ada_retur){
							echo "applet.append(\"             Nilai Retur              : ";
							$nilai_retur = $hasil[1];
							$nilai_retur = number_format($nilai_retur,0,",",".");
							$spasiNilaiRetur = 12 - strlen((string)$nilai_retur);
							for($j=0;$j<$spasiNilaiRetur;$j++){
								echo " ";
							}
							echo $nilai_retur; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";
							echo "applet.append(\"             Nilai sesudah retur      : ";
							$nilai_sesudah_retur = $hasil[0] - $hasil[1];
							$nilai_sesudah_retur = number_format($nilai_sesudah_retur,0,",",".");
							$spasiNilaiTotal = 12 - strlen((string)$nilai_sesudah_retur);
							for($j=0;$j<$spasiNilaiTotal;$j++){
								echo " ";
							}
							echo $nilai_sesudah_retur; echo "\\n"; echo "\")"; echo chr(59); echo "\n\t\t\t";
						 } */
												
						echo "applet.append(\"----------------------------------------------------\\n\")"; echo chr(59);echo "\n\t\t\t";
						echo "applet.append(\"No. Penjualan : $no_penjualan\\n\")"; echo chr(59); echo "\n\t\t\t";
						echo "applet.append(\"No. Pembayaran : $no_bayar\\n\")"; echo chr(59); echo "\n\t\t\t";
						if($balik > 0){
							echo "applet.append(\"- Uang Pengembalian dapat diambil di bagian keuangan -\\n\")"; echo chr(59);echo "\n\t\t\t";
						}
						/* $qnamaUnit="select UNIT_NAME from a_unit where UNIT_ID=$unit";
						$hasil=mysqli_query($konek,$qnamaUnit);
						$rowDataUnit=mysqli_fetch_array($hasil);
						$namaUnit=$rowDataUnit['UNIT_NAME'];		
						
						if ($iduser_jual!=""){
							$qrySingle="SELECT a_penjualan.*,a_mitra.NAMA AS kso_nama,a_kepemilikan.NAMA,a_user.username,UNIT_NAME,a_cara_bayar.nama as cb from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_unit on a_unit.UNIT_ID=a_penjualan.RUANGAN Left Join a_user on a_penjualan.USER_ID=a_user.kode_user LEFT JOIN a_mitra ON a_penjualan.KSO_ID=a_mitra.IDMITRA left join a_cara_bayar on a_penjualan.cara_bayar=a_cara_bayar.id WHERE a_penjualan.NO_PENJUALAN='$no_penjualan' and a_penjualan.UNIT_ID=$unit AND a_penjualan.NO_PASIEN='$no_pasien' AND a_penjualan.TGL='$tanggal' AND a_penjualan.USER_ID=$iduser_jual";
						}else{
							$qrySingle="SELECT a_penjualan.*,a_mitra.NAMA AS kso_nama,a_kepemilikan.NAMA,a_user.username,UNIT_NAME,a_cara_bayar.nama as cb from a_penjualan Inner Join a_kepemilikan ON a_penjualan.JENIS_PASIEN_ID = a_kepemilikan.ID Left Join a_unit on a_unit.UNIT_ID=a_penjualan.RUANGAN Left Join a_user on a_penjualan.USER_ID=a_user.kode_user LEFT JOIN a_mitra ON a_penjualan.KSO_ID=a_mitra.IDMITRA left join a_cara_bayar on a_penjualan.cara_bayar=a_cara_bayar.id WHERE a_penjualan.NO_PENJUALAN='$no_penjualan' and a_penjualan.UNIT_ID=$unit AND a_penjualan.NO_PASIEN='$no_pasien' AND a_penjualan.TGL='$tanggal'";
						}
												
						
						//mysqli_free_result($exeSingle);
						$exeSingle=mysqli_query($konek,$qrySingle);	
						$showSingle=mysqli_fetch_array($exeSingle);
												
						$status = $showSingle['kso_nama']."/".$showSingle['cb'];    
						echo "applet.append(\"Status/bayar : $status\\n\")"; echo chr(59); echo "\n\t\t\t";
						$tanggal = date("d/m/Y",strtotime($showSingle['TGL']))." ".date("H:i",strtotime($showSingle['TGL_ACT']));
						echo "applet.append(\"Tanggal      : $tanggal";
						if ($ada_retur){
							echo " - ".$tglretur; echo "\\n\")"; echo chr(59); echo "\n\t\t\t";
						}
						else {
							echo "\\n\")"; echo chr(59); echo "\n\t\t\t";
						}
						$petugas = $showSingle['username'];
						echo "applet.append(\"Petugas      : $petugas\\n\")"; echo chr(59); echo "\n\t\t\t";
						if($showSingle['cb']=="TUNAI"){
							echo "applet.append(\"- Bukti Pembayaran ini juga berlaku sebagai kwitansi -\\n\")"; 		
							echo chr(59); echo "\n\t\t\t";
						} */
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
						$iduser_jual = $_REQUEST["iduser_jual"];
						$no_retur = $_GET['no_retur'];
						
						if ($iduser_jual!=""){
							$sqlPrint = "SELECT DATE_FORMAT(rp.tgl_retur,'%d-%m-%Y %H:%i:%s') tgl_retur, rp.userid_retur, rp.no_retur, 
											ap.NO_PENJUALAN, o.OBAT_ID, o.OBAT_NAMA, SUM(rp.qty_retur) qty_retur, SUM(rp.nilai) nilai,
											SUM(rp.nilai_balik_px) nilai_px, u.username, rp.balik_uang, rp.tgl_retur tglRet
										FROM a_return_penjualan rp
										INNER JOIN a_penjualan ap
										   ON ap.ID = rp.idpenjualan
										INNER JOIN a_penerimaan p
										   ON p.ID = ap.PENERIMAAN_ID
										INNER JOIN a_obat o
										   ON o.OBAT_ID = p.OBAT_ID
										INNER JOIN a_user u
										   ON u.kode_user = rp.userid_retur
										WHERE /*ap.NO_PENJUALAN = '{$noPenjualan}'
										  AND */
										  rp.no_retur = '{$no_retur}'
										 /* AND ap.UNIT_ID = '{$unit}' */
										 and rp.unit_id_return = '{$unit}'
										  AND ap.NO_PASIEN = '{$noPasien}'
										  AND ap.USER_ID = '{$iduser_jual}'
										GROUP BY o.OBAT_ID";
						}else{
							$sqlPrint = "SELECT DATE_FORMAT(rp.tgl_retur,'%d-%m-%Y %H:%i:%s') tgl_retur, rp.userid_retur, rp.no_retur, 
											ap.NO_PENJUALAN, o.OBAT_ID, o.OBAT_NAMA, SUM(rp.qty_retur) qty_retur, SUM(rp.nilai) nilai,
											SUM(rp.nilai_balik_px) nilai_px, u.username, rp.balik_uang, rp.tgl_retur tglRet
										FROM a_return_penjualan rp
										INNER JOIN a_penjualan ap
										   ON ap.ID = rp.idpenjualan
										INNER JOIN a_penerimaan p
										   ON p.ID = ap.PENERIMAAN_ID
										INNER JOIN a_obat o
										   ON o.OBAT_ID = p.OBAT_ID
										INNER JOIN a_user u
										   ON u.kode_user = rp.userid_retur
										WHERE /*ap.NO_PENJUALAN = '{$noPenjualan}'
										  AND */rp.no_retur = '{$no_retur}'
										 /* AND ap.UNIT_ID = '{$unit}' */
										 and rp.unit_id_return = '{$unit}'
										  AND ap.NO_PASIEN = '{$noPasien}'
										
										GROUP BY o.OBAT_ID";
						}
						// echo $sqlPrint;
						$resultObat=mysqli_query($konek,$sqlPrint) or die (mysqli_error($konek));
						$k=mysqli_num_rows($resultObat);
						$i=0;
						$totRet = $totPx = 0;
					
						
						while ($k > 0){			//untuk cek jumlah halaman
							$baris = 16;
							while($baris > 0 && $k > 0){
								$showPrint = mysqli_fetch_array($resultObat);
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
								$namaObat = str_replace('"','\"',$namaObat);
								$spasiNamaObat = 26 - strlen($namaObat);		//cek panjang obat					
								
								//lebar field jumlah obat 7
								$jumlah = $showPrint['qty_retur'];

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
									
									$nilai = $showPrint['nilai'];
									$totPx += $showPrint['nilai_px'];
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
									$nilai = $showPrint['nilai'];
									$totPx += $showPrint['nilai_px'];
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
						$hasil = array($harga_total, $nilai_retur, $totPx);
						return $hasil;
					 }			
					
				?>  
			}
		}	
	</script>
	<style type="text/css">
		#kott{ border:1px solid #000; padding:5px; position:absolute; top:12px; right:5px; }
		#content{ width:550px; }
		#head-content{ width:100%; border-bottom:1px solid #000; margin-bottom:5px; }
		#head-content-detil{ width:100%; margin-bottom:5px; }
		#head-content-left, #head-content-right{ width:50%; max-width:50%; margin-bottom:5px;}
		#head-content-left{ float:left; }
		#head-content-right{ float:right; text-align:right; }
		.clear{ clear:both; }
		#head-table{ border-collapse:collapse; margin-bottom:5px; padding:0px; width:100%; }
		.border{ border-top:1px solid #000; border-bottom:1px solid #000; }
		.border-top{ border-top:1px solid #000; }
		.border-bottom{ border-bottom:1px solid #000; }
		.border-dashed{ border-bottom:1px dashed #000; }
	</style>
</head>

<!--body-->
<body onLoad="deteksiPrinter()">
	<applet name="jzebra" code="jzebra.PrintApplet.class" archive="./jzebra.jar" width="0px" height="0px"></applet>

	<div id="idArea" style="display:block;">
		<?php	
			
			if ($iduser_jual!=""){
				$qrySingle = "SELECT DATE_FORMAT(rp.tgl_retur,'%d-%m-%Y %H:%i:%s') tgl_retur, rp.no_retur, 
								   ap.NO_PENJUALAN, ap.NAMA_PASIEN, ap.NO_PASIEN, u.username, ap.ALAMAT, ap.DOKTER,
								   un.UNIT_NAME, m.NAMA kso_nama, rp.tgl_retur tglRet
								FROM a_return_penjualan rp
								INNER JOIN a_penjualan ap
								   ON ap.ID = rp.idpenjualan
								INNER JOIN a_penerimaan p
								   ON p.ID = ap.PENERIMAAN_ID
								INNER JOIN a_obat o
								   ON o.OBAT_ID = p.OBAT_ID
								INNER JOIN a_user u
								   ON u.kode_user = rp.userid_retur
								LEFT JOIN a_unit un
								   ON un.UNIT_ID = ap.RUANGAN
								inner join a_mitra m
								   on m.IDMITRA = ap.KSO_ID
								WHERE /*ap.NO_PENJUALAN = '{$no_penjualan}'
								  AND */rp.no_retur = '{$no_retur}'
								 /* AND ap.UNIT_ID = '{$idunit}' */
								 and rp.unit_id_return = '{$idunit}'
								  AND ap.TGL = '{$tgl}'
								  AND ap.USER_ID = '{$iduser_jual}'
								  AND ap.NO_PASIEN = '{$no_pasien}'
								GROUP BY ap.NO_PASIEN";
			}else{
				$qrySingle = "SELECT DATE_FORMAT(rp.tgl_retur,'%d-%m-%Y %H:%i:%s') tgl_retur, rp.no_retur, 
								   ap.NO_PENJUALAN, ap.NAMA_PASIEN, ap.NO_PASIEN, u.username, ap.ALAMAT, ap.DOKTER,
								   un.UNIT_NAME, m.NAMA kso_nama, rp.tgl_retur tglRet
								FROM a_return_penjualan rp
								INNER JOIN a_penjualan ap
								   ON ap.ID = rp.idpenjualan
								INNER JOIN a_penerimaan p
								   ON p.ID = ap.PENERIMAAN_ID
								INNER JOIN a_obat o
								   ON o.OBAT_ID = p.OBAT_ID
								INNER JOIN a_user u
								   ON u.kode_user = rp.userid_retur
								LEFT JOIN a_unit un
								   ON un.UNIT_ID = ap.RUANGAN
								left join a_mitra m
								   on m.IDMITRA = ap.KSO_ID
								WHERE /*ap.NO_PENJUALAN = '{$no_penjualan}'
								  AND*/ rp.no_retur = '{$no_retur}'
								 /* AND ap.UNIT_ID = '{$idunit}' */
								 and rp.unit_id_return = '{$idunit}'
								  AND ap.TGL = '{$tgl}'
								  AND ap.NO_PASIEN = '{$no_pasien}'
								GROUP BY ap.NO_PASIEN";
			}
		//	echo $qrySingle;
			$exeSingle=mysqli_query($konek,$qrySingle);	
			$showSingle=mysqli_fetch_array($exeSingle);	
			$qty_retur=$showSingle['QTY_RETUR'];	
			$htot=0;
			$njual=$showSingle['NO_PENJUALAN'];	
		?>	
	<div id="content">

		<div id="head-content-detil">
			<table  width="500" height="113" border="0" align="left" cellpadding="0" cellspacing="0" class="style1">
                <tr>
                    <td colspan="3">
                        <table width="340" border="0" align="left" cellpadding="0" cellspacing="0" class="style1" >
                            <td><?php echo $namaRS;?><br><?php echo $alamatRS;?> - <?php echo $kotaRS; ?>&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<?php echo $apname; ?> <hr size="1" color="#000000"></td>
                          
                            </td>
                        </table>
                       
                    </td>
                </tr>
				<tr>
					<td width="120">No. Retur</td>
					<td>: &nbsp;</td>
					<td><?php echo $showSingle['no_retur']; ?></td>
				</tr>
				<tr>
					<td width="">Tgl. Retur</td>
					<td>:</td>
					<td><?php echo $showSingle['tgl_retur']." / ".$showSingle['username']; ?></td>
				</tr>
				<tr>
					<td>Pasien/No. RM</td>
					<td>:</td>
					<td><?php echo $showSingle['NAMA_PASIEN']." / "; echo ($showSingle['NO_PASIEN']!="")? $showSingle['NO_PASIEN'] : "-"; ?></td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td>:</td>
					<td><?php echo $showSingle['ALAMAT']; ?></td>
				</tr>
				<tr>
					<td>Dokter</td>
					<td>:</td>
					<td><?php echo ($showSingle['DOKTER']!="")?$showSingle['DOKTER']:"-"; ?></td>
				</tr>
				<tr>
					<td>Ruang</td>
					<td>:</td>
					<td><?php echo ($showSingle['UNIT_NAME']!="")?$showSingle['UNIT_NAME']:"-"; ?></td>
				</tr>
                <tr>
                	<td colspan="3">
                    	<table width="500" border="0" cellpadding="0" cellspacing="0" align="left" class="style2">
                            <tr>
                                <td class='border' align='center'>No</td>
                                <td class='border' align='left'>Nama Obat</td>
                                <td class='border' align='center'>Jumlah</td>
                                <td class='border' align='center'>Nilai</td>
                            </tr>
                            <?php 
                                if ($iduser_jual!=""){
                                    $fuserID = "AND ap.USER_ID = '{$iduser_jual}'";
                                    $sqlPrint = "SELECT DATE_FORMAT(rp.tgl_retur,'%d-%m-%Y %H:%i:%s') tgl_retur, rp.userid_retur, rp.no_retur, 
                                                    ap.NO_PENJUALAN, o.OBAT_ID, o.OBAT_NAMA, SUM(rp.qty_retur) qty_retur, SUM(rp.nilai) nilai, 
                                                    SUM(rp.nilai_balik_px) nilai_px, u.username, rp.balik_uang
                                                FROM a_return_penjualan rp
                                                INNER JOIN a_penjualan ap
                                                   ON ap.ID = rp.idpenjualan
                                                INNER JOIN a_penerimaan p
                                                   ON p.ID = ap.PENERIMAAN_ID
                                                INNER JOIN a_obat o
                                                   ON o.OBAT_ID = p.OBAT_ID
                                                INNER JOIN a_user u
                                                   ON u.kode_user = rp.userid_retur
                                                WHERE /*ap.NO_PENJUALAN = '{$no_penjualan}'
                                                  AND */ rp.no_retur = '{$no_retur}'
                                                 /* AND ap.UNIT_ID = '{$idunit}' */
                                                  and rp.unit_id_return = '{$idunit}'
                                               
                                                  AND ap.NO_PASIEN = '{$no_pasien}'
                                                 
                                                GROUP BY o.OBAT_ID";
                                }else{
                                    $fuserID = "";
                                    $sqlPrint = "SELECT DATE_FORMAT(rp.tgl_retur,'%d-%m-%Y %H:%i:%s') tgl_retur, rp.userid_retur, rp.no_retur, 
                                                    ap.NO_PENJUALAN, o.OBAT_ID, o.OBAT_NAMA, SUM(rp.qty_retur) qty_retur, SUM(rp.nilai) nilai, 
                                                    SUM(rp.nilai_balik_px) nilai_px, u.username, rp.balik_uang
                                                FROM a_return_penjualan rp
                                                INNER JOIN a_penjualan ap
                                                   ON ap.ID = rp.idpenjualan
                                                INNER JOIN a_penerimaan p
                                                   ON p.ID = ap.PENERIMAAN_ID
                                                INNER JOIN a_obat o
                                                   ON o.OBAT_ID = p.OBAT_ID
                                                INNER JOIN a_user u
                                                   ON u.kode_user = rp.userid_retur
                                                WHERE ap.NO_PENJUALAN = '{$no_penjualan}'
                                                  AND rp.no_retur = '{$no_retur}'
                                                 /* AND ap.UNIT_ID = '{$idunit}' */
                                                 and rp.unit_id_return = '{$idunit}'
                                                  AND ap.NO_PASIEN = '{$no_pasien}'
                                               
                                                GROUP BY o.OBAT_ID";
                                }
								// echo $sqlPrint;
                                $exePrint=mysqli_query($konek,$sqlPrint);
                                $k=mysqli_num_rows($exePrint);
                                $i=1;
                                $totRet = $totPx = 0;
                                while($showPrint=mysqli_fetch_array($exePrint)){
                                    echo"
                                        <tr>
                                            <td width='36' align='center'>".$i++.".</td>
                                            <td>".$showPrint['OBAT_NAMA']."</td>
                                            <td align='center' width='36' >".$showPrint['qty_retur']."</td>
                                            <td align='right' width='90' >".number_format($showPrint['nilai'],0,",",".")."&nbsp;&nbsp;</td>
                                        </tr>
                                    ";
                                    $totRet += $showPrint['nilai'];
                                    $totPx += $showPrint['nilai_px'];
                                } 
                            ?>
                            <tr class="border-top" align="right"> 
                                <td colspan="3">Total Retur :</td>
                                <td><?php echo number_format($totRet,0,",","."); ?>&nbsp;&nbsp;</td>
                            </tr>
                            <?php
                                /* get nilai sudah bayar */
                                $sudahB_ = "SELECT IF(IFNULL(ku.TOTAL_HARGA,0) <> 0, ku.TOTAL_HARGA, ku.BAYAR_UTANG) TOTAL_HARGA, ku.TGL_BAYAR, 
                                    IFNULL(ku.NO_BAYAR, ap.NO_PENJUALAN) NO_BAYAR
                                FROM a_penjualan ap
                                LEFT JOIN (SELECT ku2.FK_NO_PENJUALAN, SUM(ku2.BAYAR_UTANG) BAYAR_UTANG, ku2.BAYAR, ku2.KEMBALI, ku2.NORM, ku2.NO_BAYAR, 
                                        ku2.NO_PELAYANAN, ku2.TGL_BAYAR, ku2.TOTAL_HARGA, ku2.UNIT_ID, ku2.USER_ID, ku2.CARA_BAYAR
                                       FROM a_kredit_utang ku2
                                       WHERE ku2.NORM = '{$no_pasien}'
                                       GROUP BY ku2.FK_NO_PENJUALAN, ku2.UNIT_ID) ku
                                   ON ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN
                                  and ku.UNIT_ID = ap.UNIT_ID
                                WHERE ap.NO_PENJUALAN = '{$no_penjualan}'
                                  AND DATE_FORMAT(ku.TGL_BAYAR,'%d-%m-%Y %H:%i:%s') < '".$showSingle['tglRet']."'
                                  AND ap.CARA_BAYAR IN (1,2,4)
                                  AND ap.KRONIS = 0
                                  AND ap.UNIT_ID = '{$idunit}'
                                  AND ap.TGL = '{$tgl}'
                                  AND ap.NO_PASIEN = '{$no_pasien}'
                                  {$fuserID}
                                GROUP BY ap.NO_PENJUALAN";
                                
                                $sudahB = "SELECT 
                                              IF( IFNULL(ku.TOTAL_HARGA, 0) <> 0, ku.TOTAL_HARGA, ku.BAYAR_UTANG ) TOTAL_HARGA,
                                              ku.TGL_BAYAR, IFNULL(ku.NO_BAYAR, ap.NO_PENJUALAN) NO_BAYAR 
                                            FROM
                                              a_penjualan ap 
                                              LEFT JOIN (SELECT * FROM a_kredit_utang ku2 WHERE ku2.NORM = '{$no_pasien}') ku 
                                                ON ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN 
                                                AND DATE(ku.TGL_BAYAR) = DATE(ap.TGL_BAYAR_ACT)
                                                /*AND ku.TGL_BAYAR >= ap.TGL_ACT*/
                                                AND ku.NORM = ap.NO_PASIEN 
                                                AND ku.NO_PELAYANAN = ap.NO_KUNJUNGAN 
                                                AND ku.UNIT_ID = ap.UNIT_ID
                                            WHERE ap.NO_PENJUALAN = '{$no_penjualan}'
                                              AND ku.TGL_BAYAR < '".$showSingle['tglRet']."'
                                              /* AND ap.KRONIS = 0  */
                                              AND ap.CARA_BAYAR IN (2,4)
                                              AND ap.UNIT_ID = '{$idunit}'
                                              AND ap.TGL = '{$tgl}'
                                              AND ap.NO_PASIEN = '{$no_pasien}'
                                              {$fuserID}
                                            GROUP BY ku.NO_BAYAR";
                                $qsudahB1 = mysqli_query($konek,$sudahB);
                                if(mysqli_num_rows($qsudahB1) > 0){
                                    $dsudahB1 = mysqli_fetch_array($qsudahB1);
                                    $sudahByr = ($dsudahB1['TOTAL_HARGA'] != "")? $dsudahB1['TOTAL_HARGA'] : "0";
                                    $tglSdhByr = $dsudahB1['TGL_BAYAR'];
                                    $no_bayar = $dsudahB1['NO_BAYAR'];
                                } else {
                                    $sudahB_ = "SELECT IF(IFNULL(ku.TOTAL_HARGA,0) <> 0, ku.TOTAL_HARGA, IF(ku.BAYAR_UTANG <> 0, ku.BAYAR_UTANG, ap.HARGA_TOTAL)) TOTAL_HARGA,
                                        IFNULL(ku.TGL_BAYAR,ap.TGL_ACT) TGL_BAYAR, IFNULL(ku.NO_BAYAR, ap.NO_PENJUALAN) NO_BAYAR
                                    FROM a_penjualan ap
                                    LEFT JOIN (SELECT ku2.FK_NO_PENJUALAN, SUM(ku2.BAYAR_UTANG) BAYAR_UTANG, ku2.BAYAR, ku2.KEMBALI, ku2.NORM, ku2.NO_BAYAR, 
                                            ku2.NO_PELAYANAN, ku2.TGL_BAYAR, ku2.TOTAL_HARGA, ku2.UNIT_ID, ku2.USER_ID, ku2.CARA_BAYAR
                                           FROM a_kredit_utang ku2
                                           WHERE ku2.NORM = '{$no_pasien}'
                                           GROUP BY ku2.FK_NO_PENJUALAN, ku2.UNIT_ID) ku
                                       ON ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN
                                      and ku.UNIT_ID = ap.UNIT_ID
                                    WHERE ap.NO_PENJUALAN = '{$no_penjualan}'
                                      /*AND DATE_FORMAT(ku.TGL_BAYAR,'%d-%m-%Y %H:%i:%s') < '".$showSingle['tglRet']."'*/
                                      AND ku.TGL_BAYAR < '".$showSingle['tglRet']."'
                                      AND ap.CARA_BAYAR = 1
                                      AND ap.UNIT_ID = '{$idunit}'
                                      AND ap.TGL = '{$tgl}'
                                      AND ap.NO_PASIEN = '{$no_pasien}'
                                      {$fuserID}
                                    GROUP BY ap.NO_PENJUALAN";
                                    
                                    $sudahB = "SELECT IF( IFNULL(ku.TOTAL_HARGA, 0) <> 0, ku.TOTAL_HARGA, IF( ku.BAYAR_UTANG <> 0, ku.BAYAR_UTANG,
                                                      ap.HARGA_TOTAL ) ) TOTAL_HARGA,
                                                  IFNULL(ku.TGL_BAYAR, ap.TGL_ACT) TGL_BAYAR, IFNULL(ku.NO_BAYAR, ap.NO_PENJUALAN) NO_BAYAR 
                                                FROM
                                                  a_penjualan ap 
                                                  LEFT JOIN (SELECT * FROM a_kredit_utang ku2 WHERE ku2.NORM = '{$no_pasien}') ku 
                                                    ON ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN 
                                                    AND DATE(ku.TGL_BAYAR) = DATE(ap.TGL_BAYAR_ACT)
                                                    /*AND ku.TGL_BAYAR >= ap.TGL_ACT*/
                                                    AND ku.NORM = ap.NO_PASIEN 
                                                    AND ku.NO_PELAYANAN = ap.NO_KUNJUNGAN 
                                                    AND ku.UNIT_ID = ap.UNIT_ID 
                                                WHERE ap.NO_PENJUALAN = '{$no_penjualan}'
                                                  AND ku.TGL_BAYAR < '".$showSingle['tglRet']."'
                                                  AND ap.CARA_BAYAR = 1 
                                                  AND ap.UNIT_ID = '{$idunit}'
                                                  AND ap.TGL = '{$tgl}' 
                                                  AND ap.NO_PASIEN = '{$no_pasien}' 
                                                  {$fuserID}
                                                GROUP BY ap.NO_PENJUALAN";
                                    $qsudahB2 = mysqli_query($konek,$sudahB);
                                    $dsudahB2 = mysqli_fetch_array($qsudahB2);
                                    $sudahByr = ($dsudahB2['TOTAL_HARGA'] != "")? $dsudahB2['TOTAL_HARGA'] : "0";
                                    $tglSdhByr = $dsudahB2['TGL_BAYAR'];
                                    $no_bayar = $dsudahB2['NO_BAYAR'];
                                }
                                
                                //echo $sudahB;
                                
                                /* cek retur sebelumnya */
                                if($tglSdhByr != ""){
                                    $sretCek = "SELECT rp.nilai, rp.tgl_retur
                                                FROM a_return_penjualan rp
                                                INNER JOIN a_penjualan ap
                                                   ON ap.ID = rp.idpenjualan
                                                WHERE ap.NO_PENJUALAN = '{$no_penjualan}'
                                                  AND ap.UNIT_ID = '{$idunit}'
                                                  AND ap.TGL = '{$tgl}'
                                                  AND rp.tgl_retur > '{$tglSdhByr}'
                                                  AND DATE_FORMAT(rp.tgl_retur,'%d-%m-%Y %H:%i:%s') < '".$showSingle['tgl_retur']."'
                                                  AND rp.no_retur <> '".$showSingle['no_retur']."'";
                                    $qretCek = mysqli_query($konek,$sretCek);
                                    if(mysqli_num_rows($qretCek) > 0){
                                        $dretCek = mysqli_fetch_array($qretCek);
                                        if($dretCek['nilai'] != ""){
                                            $retBefor = $dretCek['nilai'];
                                        } else {
                                            $retBefor = 0;
                                        }
                                    }
                                } else {
                                    $retBefor = 0;
                                }
                                $sudahByr -= $retBefor;
                                $balik = 0;
                                if((int)$sudahByr > 0){
                                    if($totPx > 0){
                                        $balik = $totPx;
                                    } else {
                                        $balik = $totRet;
                                    }
                                }
                            ?>
                            <?php if($sudahByr > 0){ ?>
                            <!--tr align="right" <?php if($sudahByr == '0') echo 'class="border-bottom"';?>>
                                <td colspan="3">Total Bayar Awal :</td>
                                <td><?php echo number_format($sudahByr,0,",","."); ?>&nbsp;&nbsp;</td>
                            </tr>
                            <tr align="right">
                                <td colspan="3">Total Setelah Retur :</td>
                                <?php $totalSesudah = $sudahByr-$totRet; ?>
                                <td><?php echo number_format($totalSesudah,0,",","."); ?>&nbsp;&nbsp;</td>
                            </tr-->
                            <tr align="right" class="border-bottom border-top">
                                <td colspan="3">Pengembalian :</td>
                                <td><?php echo number_format($balik,0,",","."); ?>&nbsp;&nbsp;</td>
                            </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table>
                            <tr style="font-size:12px; display:none">
                                <td width="168">No. Penjualan</td>
                                <td>:</td>
                                <td><?php echo $no_penjualan; ?></td>
                            </tr>
                            <tr style="font-size:12px;">
                                <td width="168">No. Pembayaran</td>
                                <td>:</td>
                                <td><?php 
                                    if($sudahByr != 0){
                                        echo $no_bayar;
                                    }
                                ?></td>
                            </tr>
                            <?php if($balik > 0){ ?>
                            <tr>
                                <td colspan="3">- Uang Pengembalian dapat diambil di bagian keuangan -</td>
                            </tr>
                            <?php } ?>
                        </table>
                    </td>
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
	<table width="500" align="left">
	<tr>
		<td width="50%" align="left">
			<BUTTON type="button" onClick="document.getElementById('btn').style.display='none';/*window.print();window.close();*/window.printjZebra();"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">Cetak</BUTTON>
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