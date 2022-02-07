<?php 
include("../sesi.php");
// Koneksi ================================= 
include("../koneksi/konek.php");
//==========================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$tgllll = gmdate('d-m-Y',mktime(date('H')+7));
$thhhh 	= explode("-",$tgllll);
$blnNow = $thhhh[1];
$thnNow = $thhhh[2];
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//$tgltrans1=$_REQUEST["tgltrans"];
$tgltrans1=mysqli_real_escape_string($konek,$_REQUEST["tgltrans"]);
$tgltrans=explode("-",$tgltrans1);
$thtr=$tgltrans[2];

$tgltrans=$tgltrans[2]."-".$tgltrans[1]."-".$tgltrans[0];
//$nokw=$_REQUEST["nokw"];
$nokw=mysqli_real_escape_string($konek,$_REQUEST["nokw"]);
$kso_id=$_REQUEST["ksoid2"];
$tgltrans1=mysqli_real_escape_string($konek,$_REQUEST["$tgltrans"]);
//echo $kso_id."----------- <br />";
if (($kso_id!="0")&&($kso_id!="")) {
	$kso=1;
	//$kso_id=$kso_id;
}else{
	$kso=0;
	$kso_id=0;
}
//$idunit = $_SESSION["ses_idunit"];
$nokwPrint=$nokw;
//$fdata=$_REQUEST["fdata"];
$fdata=mysqli_real_escape_string($konek,$_REQUEST["fdata"]);
//$no_penjualan=$_REQUEST['nokw'];
$no_penjualan=mysqli_real_escape_string($konek,$_REQUEST["nokw"]);
//$no_kunj=$_REQUEST['no_kunj'];
$no_kunj=mysqli_real_escape_string($konek,$_REQUEST["no_kunj"]);
if (trim($no_kunj)=="") $no_kunj="0";
//$NoRM=$_REQUEST['NoRM'];
$NoRM=mysqli_real_escape_string($konek,$_REQUEST["NoRM"]);
//$NoResep=$_REQUEST['NoResep'];
$NoResep=mysqli_real_escape_string($konek,$_REQUEST["NoResep"]);
//$nm_pasien=$_REQUEST['nm_pasien'];
$nm_pasien=mysqli_real_escape_string($konek,$_REQUEST["nm_pasien"]);
//$txtalamat=$_REQUEST['txtalamat'];
$txtalamat=mysqli_real_escape_string($konek,$_REQUEST["txtalamat"]);
$shft=$shift;
//$subtotal=str_replace(".","",$_REQUEST['subtotal']);
$subtotal=str_replace(".","",mysqli_real_escape_string($konek,$_REQUEST["subtotal"]));
//$embalage=$_REQUEST['embalage'];
$embalage=mysqli_real_escape_string($konek,$_REQUEST["embalage"]);
//$embalage=0;
//$jasa_resep=$_REQUEST['jasa_resep'];
$jasa_resep=mysqli_real_escape_string($konek,$_REQUEST["jasa_resep"]);
//$jasa_resep=0;
//$tot_harga=str_replace(".","",$_REQUEST['tot_harga']);
$tot_harga=str_replace(".","",mysqli_real_escape_string($konek,$_REQUEST["hargatot"]));
$ppn_nilai=str_replace(".","",mysqli_real_escape_string($konek,$_REQUEST["txtppn"]));
$harga_ppn=str_replace(".","",mysqli_real_escape_string($konek,$_REQUEST["tot_harga"]));
$jenis_kunjungan=str_replace(".","",mysqli_real_escape_string($konek,$_REQUEST["jenis_kunjungan"]));
//$dokter=$_REQUEST['dokter'];
$dokter=mysqli_real_escape_string($konek,$_REQUEST["dokter"]);
//$ruangan=$_REQUEST['ruangan'];
$ruangan=mysqli_real_escape_string($konek,$_REQUEST["ruangan"]);
$cara_bayar= 2; // $_REQUEST['cara_bayar'];
//echo $cara_bayar."----------- <br />";
//$chk_kso=$_REQUEST['chk_kso'];
$chk_kso=mysqli_real_escape_string($konek,$_REQUEST["chk_kso"]);
//======================Tanggalan==========================
//$kepemilikan_id=$_REQUEST["kepemilikan_id"];
$kepemilikan_id=mysqli_real_escape_string($konek,$_REQUEST["kepemilikan_id"]);
if ($kepemilikan_id=="") $kepemilikan_id=mysqli_real_escape_string($konek,$_SESSION["kepemilikan_id"]);
//Paging,Sorting dan Filter======
//$page=$_REQUEST["page"];
$page=mysqli_real_escape_string($konek,$_REQUEST["page"]);
$defaultsort="UNIT_ID";
//$sorting=$_REQUEST["sorting"];
$sorting=mysqli_real_escape_string($konek,$_REQUEST["sorting"]);
//$filter=$_REQUEST["filter"];
$filter=mysqli_real_escape_string($konek,$_REQUEST["filter"]);
//===============================
$sql="SELECT * FROM a_retur_biaya";
$rs=mysqli_query($konek,$sql);
$biaya_retur=0;
//$no_bayar = $_REQUEST['nobayar'];
$no_bayar=mysqli_real_escape_string($konek,$_REQUEST["nobayar"]);

//$o_dijamin = (!empty($_REQUEST['o_dijamin']))?$_REQUEST['o_dijamin']:'0';
$oj=mysqli_real_escape_string($konek,$_REQUEST["o_dijamin"]);
$o_dijamin = (!empty($oj))?$oj:'0';
// $ppn = 0; //decyber_ppn
$ppn = 10;

if($jenis_kunjungan == 3){
	$ppn = 0;
	$ppn_nilai = 0;
	$tot_harga = $harga_ppn;
}

if(in_array($kso_id, array(2/*,3,13*/))){
	$ppn = 0;
	$ppn_nilai = 0;
	$tot_harga = $harga_ppn;
}

if($cara_bayar == '1'){
	$o_dijamin = "0";
}
// if ($cara_bayar=="4") $nutang=($tot_harga+$ppn_nilai); else $nutang=0;
if($cara_bayar=="4" || $cara_bayar=="2"){
	if($o_dijamin == '1'){
		$nutang = 0;
	} else {
		$nutang = ($tot_harga+$ppn_nilai);
	}
} else {
	$nutang = 0;
}

$kronis = "0";
if(mysqli_real_escape_string($konek,$_POST['kronis']) != ""){
	//$kronis = $_POST['kronis'];
	$kronis=mysqli_real_escape_string($konek,$_REQUEST["kronis"]);
}
if ($rows=mysqli_fetch_array($rs)) $biaya_retur=$rows['biaya_potong'];

//Aksi Save, Edit Atau Delete =========================================
//$act=$_REQUEST['act']; // Jenis Aksi
$act=mysqli_real_escape_string($konek,$_REQUEST["act"]);
//echo $act;

if(empty($nm_pasien) && $act == 'save'){
	echo "<script type='text/javascript'> alert('Maaf Data Penjualan Anda Tidak Lengkap Silahkan Lakukan Kembali Transaksi Anda!'); </script>";
	$act = "";
	
	$bookID2 = array();
	$arfdata2=explode("**",$fdata);
	for ($i=0;$i<count($arfdata2);$i++){
		$dBooking2 = explode("|",$arfdata2[$i]);
		if($dBooking2[0]!=""){
			$bookID2[] = $dBooking2[0];
		}
		//$arfvalue=explode("|",$arfdata[$i]);
	}
	
	$sql = "DELETE
			FROM a_booking_obat
			WHERE bookID IN (".implode(',',$bookID2).")";
	//echo $sql." ---- Delete Booking Kosong Parameter<br>";
	$rs1=mysqli_query($konek,$sql);
}

switch ($act){
	case "save":
	//==Cek apakah transaksi ini telah ada pada datanase====
	$sqlCek="select NO_PENJUALAN,USER_ID,date_format(TGL,'%Y-%m-%d') as TGL from a_penjualan where NO_PENJUALAN='$no_penjualan' AND UNIT_ID=$idunit and YEAR(TGL)=$thtr";
	//echo $sqlCek."<br>";
	$exeCek=mysqli_query($konek,$sqlCek);
	$hitung=mysqli_num_rows($exeCek);
	//echo $hitung."<br>";
	
	$sTgl = 'SELECT CURDATE() AS tgl';
	$qTgl = mysqli_query($konek,$sTgl);
	$dTgl = mysqli_fetch_array($qTgl);
	$tgltrans = $dTgl['tgl'];
	
	$bookID = array();
	$racikSet = array();
		
	if ($hitung >0){
		if ($rows1=mysqli_fetch_array($exeCek)){
			$cuserid=$rows1['USER_ID'];
			$ctgl=$rows1['TGL'];
		}
		if (($cuserid==$iduser) && ($ctgl==$tgltrans)){
			echo "<script>alert('Maaf, No. Transaksi dg nomor $no_penjualan telah ada pada database, silahkan lakukan transaksi lagi'); window.location = 'main.php?f=../transaksi/penjualan.php'</script>";
		} else {
			
			$cekNo = "select MAX(nomor) NO_PENJUALAN from a_no_penjualan_log where unit_id=$idunit and tahun=$thtr"; //order by id DESC limit 1
			//echo $cekNo."<br>";
			$qcekNo = mysqli_query($konek,$cekNo);
			$dcekNo = mysqli_fetch_array($qcekNo);
			$sql="select MAX(CAST(NO_PENJUALAN AS UNSIGNED)) AS NO_PENJUALAN from a_penjualan where UNIT_ID=$idunit and YEAR(TGL)=$thtr";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			$rows=mysqli_fetch_array($rs);
			$cNo_Penjualan=$rows['NO_PENJUALAN'];
			/* if ((int)substr($cNo_Penjualan,0,1)==$idunit){
				$cNo_Penjualan=substr($cNo_Penjualan,1,(strlen($cNo_Penjualan)-1));
			} */
			
			if ((int)substr($cNo_Penjualan,0,-6)==$idunit){
				$cNo_Penjualan = substr($cNo_Penjualan,-6); //substr($cNo_Penjualan,1,(strlen($cNo_Penjualan)-1));
			}
			
			if(!empty($dcekNo['NO_PENJUALAN'])){
				if(((int)$dcekNo['NO_PENJUALAN']) > ((int)$cNo_Penjualan)){
					$nokw=(int)$dcekNo["NO_PENJUALAN"]+1;
				} else if(((int)$dcekNo['NO_PENJUALAN']) < ((int)$cNo_Penjualan)){
					$nokw=(int)$cNo_Penjualan+1;
				} else {
					$nokw=(int)$dcekNo["NO_PENJUALAN"]+1;
				}
			} else {
				$nokw=(int)$cNo_Penjualan+1;
			}
			//echo $nokw."<br>";
			$updateNO = "insert into a_no_penjualan_log(nomor,unit_id,tahun) value('{$nokw}','$idunit','$thtr')";
			$qNO = mysqli_query($konek,$updateNO) or die (mysqli_error()." | 162");
			$idNomor = mysqli_insert_id($konek);
			
			$sqlNomor = "select nomor from a_no_penjualan_log where id = '{$idNomor}'";
			
			$qNomor = mysqli_query($konek,$sqlNomor);
			$dNomor = mysqli_fetch_array($qNomor);
			
			if(!empty($dNomor['nomor'])){
				$nokw = (int)$dNomor['nomor'];
			}
			
			$nokwstr=(string)$nokw;
			if (strlen($nokwstr)<6){
				for ($i=0;$i<(6-strlen($nokwstr));$i++) $nokw="0".$nokw;
			}else{
				$nokw=$nokwstr;
			}
			
			$nokw=$idunit.$nokw;
			$no_penjualan=$nokw;
			$nokwPrint=$no_penjualan;
			
			// $arfdata=explode("**",$fdata);
			$arfdata=explode("**",$fdata);
			for ($i=0;$i<count($arfdata);$i++){
				$dBooking = explode("|",$arfdata[$i]);
				if($dBooking[0]!=""){
					$bookID[] = $dBooking[0];
					$racikSet[$dBooking[0]] = $dBooking[1];
				}
				//$arfvalue=explode("|",$arfdata[$i]);
			}
			
			
			/* for ($i=0;$i<count($arfdata);$i++)
			{
				$arfvalue=explode("|",$arfdata[$i]); */
			$iurPasien = 0;
			foreach($bookID as $val){
				$isRacik = $racikSet[$val];
				$sqlBooking = "select * from a_booking_obat where bookID = '{$val}'";
				//echo $sqlBooking."<br />";
				$queryB = mysqli_query($konek,$sqlBooking);
				$dBooking = mysqli_fetch_object($queryB);
				$arfvalue=explode("|",$dBooking->detail);
				if ($kepemilikan_id!=$arfvalue[8]){
					$sql="call gd_mutasi($idunit,$idunit,0,'$no_penjualan',$arfvalue[0],$arfvalue[8],$kepemilikan_id,$arfvalue[1],2,$iduser,1,'$tgltrans','$tglact')";
					//echo $sql."<br>";
					$rs=mysqli_query($konek,$sql);
				}
				$jml=$arfvalue[1];
			
				$harga_px = $harga_kso = 0;
				if($kso_id == '1'  || $o_dijamin=='0'){
					$harga_px = $arfvalue[2];
					$harga_kso = 0;
				} else {
					$harga_kso = $arfvalue[2];
					$harga_px = 0;
				}					
				if($harga_px != 0){
					$tmpnutang = $jml*$harga_px;
				}
				if($tmpnutang != 0) {
					$iurPasien += $tmpnutang;
				}
				
				//harga rata2
				$hrg = "select rata2 from a_stok where unit_id=$idunit AND obat_id=".$arfvalue[0]." ";
				$hrg1 = mysqli_query($konek,$hrg);
				$hrg2 = mysqli_fetch_array($hrg1);
				$rata2 = $hrg2['rata2'];
					
				
				$sql="select SQL_NO_CACHE * from a_penerimaan ap where OBAT_ID=".$arfvalue[0]." and UNIT_ID_TERIMA=$idunit and KEPEMILIKAN_ID=$kepemilikan_id and QTY_STOK>0 and ap.STATUS=1 order by TANGGAL,ID";
				//echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
				$done="false";
				while (($rows=mysqli_fetch_array($rs))&&($done=="false"))
				{
					$cstok=$rows['QTY_STOK'];
					$cid=$rows['ID'];
					if ($cstok>=$jml)
					{
						$done="true";
						$sql="update a_penerimaan set QTY_STOK=QTY_STOK-$jml where ID=$cid";
						//echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);
						// echo $kso_id." - 213";
						
						$sql="insert into a_penjualan(PENERIMAAN_ID,UNIT_ID,USER_ID,JENIS_PASIEN_ID,KSO,KSO_ID,TGL,TGL_ACT,NO_PENJUALAN,NO_KUNJUNGAN,NO_PASIEN,NO_RESEP,DOKTER,RUANGAN,SHIFT,CARA_BAYAR,QTY_JUAL,QTY,BIAYA_RETUR,HARGA_NETTO_AWAL,HARGA_NETTO,HARGA_SATUAN,HARGA_KSO,HARGA_PX,SUB_TOTAL,SUM_SUB_TOTAL,EMBALAGE,JASA_RESEP,HARGA_TOTAL,STATUS,NAMA_PASIEN,ALAMAT,UTANG,RACIKAN,KRONIS,DIJAMIN,PPN,PPN_NILAI,HARGA_TOTAL_PPN) values($cid,$idunit,$iduser,$kepemilikan_id,$kso,$kso_id,'$tgltrans',NOW(),'$no_penjualan','$no_kunj','$NoRM','$NoResep','$dokter','$ruangan',$shft,$cara_bayar,$jml,$jml,$biaya_retur,$arfvalue[9],$rata2,$arfvalue[2],$harga_kso,$harga_px,$arfvalue[3],$subtotal,$embalage,$jasa_resep,$tot_harga,1,'$nm_pasien','$txtalamat',$nutang,$isRacik,'$kronis','$o_dijamin','{$ppn}','{$ppn_nilai}','{$harga_ppn}')";
						//echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);
						if (mysqli_errno($konek)>0){
							$sql="update a_penerimaan set QTY_STOK=QTY_STOK+$jml where ID=$cid";
							//echo $sql."<br>";
							$rs1=mysqli_query($konek,$sql);
						}
					}else{
						$jml=$jml-$cstok;
						$sql="update a_penerimaan set QTY_STOK=0 where ID=$cid";
						//echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);
						// echo $kso_id." - 235";
						
						$sql="insert into a_penjualan(PENERIMAAN_ID,UNIT_ID,USER_ID,JENIS_PASIEN_ID,KSO,KSO_ID,TGL,TGL_ACT,NO_PENJUALAN,NO_KUNJUNGAN,NO_PASIEN,NO_RESEP,DOKTER,RUANGAN,SHIFT,CARA_BAYAR,QTY_JUAL,QTY,BIAYA_RETUR,HARGA_NETTO_AWAL,HARGA_NETTO,HARGA_SATUAN,HARGA_KSO,HARGA_PX,SUB_TOTAL,SUM_SUB_TOTAL,EMBALAGE,JASA_RESEP,HARGA_TOTAL,STATUS,NAMA_PASIEN,ALAMAT,UTANG,RACIKAN,KRONIS,DIJAMIN,PPN,PPN_NILAI,HARGA_TOTAL_PPN) values($cid,$idunit,$iduser,$kepemilikan_id,$kso,$kso_id,'$tgltrans',NOW(),'$no_penjualan','$no_kunj','$NoRM','$NoResep','$dokter','$ruangan',$shft,$cara_bayar,$cstok,$cstok,$biaya_retur,$arfvalue[9],$rata2,$arfvalue[2],$harga_kso,$harga_px,$arfvalue[3],$subtotal,$embalage,$jasa_resep,$tot_harga,1,'$nm_pasien','$txtalamat',$nutang,$isRacik,'$kronis','$o_dijamin','{$ppn}','{$ppn_nilai}','{$harga_ppn}')";
						//echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);
						if (mysqli_errno($konek)>0){
							$sql="update a_penerimaan set QTY_STOK=QTY_STOK+$cstok where ID=$cid";
							//echo $sql."<br>";
							$rs1=mysqli_query($konek,$sql);
						}
					}
				}
				
				if (mysqli_errno($konek)<=0){
					$sql = "DELETE
							FROM a_booking_obat
							WHERE bookID = '{$val}'";
					//echo $sql." ---- Delete Booking 2<br>";
					$rs1=mysqli_query($konek,$sql);
				}
			}
			
			if($iurPasien > 0){
				$sql_ = "update a_penjualan
						SET UTANG = $iurPasien
						where NO_PENJUALAN = '{$no_penjualan}'
						  and UNIT_ID = '{$idunit}'
						  and NO_PASIEN = '{$NoRM}'
						  and NO_KUNJUNGAN = '{$no_kunj}'
						  and TGL = '{$tgltrans}'";
				$query_ = mysqli_query($konek,$sql_) or die (mysqli_error($konek));
			}
			
			if (mysqli_errno($konek)<=0){
				$sql = "UPDATE {$dbbilling}.b_pelayanan p
						SET p.dilayani = 1
						WHERE p.id = '{$no_kunj}'
						  and p.dilayani = 0";
				$rs1=mysqli_query($konek,$sql);
			}
		}
	}else{
	//==jika tidak ada pada database, lakukan insert===
		//echo "arfdata=".$fdata."<br>";
		if ((int)substr($no_penjualan,0,-6)==$idunit){
			$cNo_Penjualan = (int)substr($no_penjualan,-6); //substr($cNo_Penjualan,1,(strlen($cNo_Penjualan)-1));
		}
			
		$updateNO = "insert into a_no_penjualan_log(nomor,unit_id,tahun) value('{$cNo_Penjualan}','$idunit','$thtr')";
		$qNO = mysqli_query($konek,$updateNO) or die (mysqli_error()." | 245");
		$idNomor = mysqli_insert_id($konek);//
		
		$sqlNomor = "select nomor from a_no_penjualan_log where id = '{$idNomor}'";
		//echo $sqlNomor;
		$qNomor = mysqli_query($konek,$sqlNomor);
		$dNomor = mysqli_fetch_array($qNomor);
		
		if(!empty($dNomor['nomor'])){
			$nokw = (int)$dNomor['nomor'];
		}
		
		$nokwstr=(string)$nokw;
		if (strlen($nokwstr)<6){
			for ($i=0;$i<(6-strlen($nokwstr));$i++) $nokw="0".$nokw;
		}else{
			$nokw=$nokwstr;
		}
		
		$nokw=$idunit.$nokw;
		$no_penjualan=$nokw;
		$nokwPrint=$no_penjualan;
		//echo "no_kw=".$no_penjualan."<br>";
		$arfdata=explode("**",$fdata);
		for ($i=0;$i<count($arfdata);$i++){
			$dBooking = explode("|",$arfdata[$i]);
			if($dBooking[0]!=""){
				$bookID[] = $dBooking[0];
				$racikSet[$dBooking[0]] = $dBooking[1];
			}
			//$arfvalue=explode("|",$arfdata[$i]);
		}
		//print_r($bookID);
		//print_r($racikSet);
		$totalSemua = 0;
		$iurPasien = 0;
		foreach($bookID as $val){
			$isRacik = $racikSet[$val];
			$sqlBooking = "select * from a_booking_obat where bookID = '{$val}'";
			//echo $sqlBooking."<br />";
			$queryB = mysqli_query($konek,$sqlBooking);
			$dBooking = mysqli_fetch_object($queryB);
			$arfvalue=explode("|",$dBooking->detail);
			// $arfvalue=explode("|",$arfdata[$i]);
			if ($kepemilikan_id!=$arfvalue[8]){
				$sql="call gd_mutasi($idunit,$idunit,0,'$no_penjualan',$arfvalue[0],$arfvalue[8],$kepemilikan_id,$arfvalue[1],2,$iduser,1,'$tgltrans','$tglact')";
				//echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
			}
			$jml=$arfvalue[1];
			
			$harga_px = $harga_kso = 0;
			if($kso_id == '1'  || $o_dijamin=='0'){
				$harga_px = $arfvalue[2];
				$harga_kso = 0;
			} else {
				$harga_kso = $arfvalue[2];
				$harga_px = 0;
			}					
			if($harga_px != 0){
				$tmpnutang = $jml*$harga_px;
			}
			if($tmpnutang != 0) {
				$iurPasien += $tmpnutang;
			}
			
			
			//harga rata2
			$hrg = "select rata2 from a_stok where unit_id=$idunit AND obat_id=".$arfvalue[0]." ";
			//echo $hrg."<br>";
			$hrg1 = mysqli_query($konek,$hrg);
			$hrg2 = mysqli_fetch_array($hrg1);
			$rata2 = $hrg2['rata2'];
			
			
			$sql="select SQL_NO_CACHE * from a_penerimaan ap where OBAT_ID=".$arfvalue[0]." and UNIT_ID_TERIMA=$idunit and KEPEMILIKAN_ID=$kepemilikan_id and QTY_STOK>0 and ap.STATUS=1 order by TANGGAL,ID";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			$done="false";
			while (($rows=mysqli_fetch_array($rs))&&($done=="false"))
			{
				$cstok=$rows['QTY_STOK'];
				$cid=$rows['ID'];
				if ($cstok>=$jml)
				{
					$done="true";
					$sql="update a_penerimaan set QTY_STOK=QTY_STOK-$jml where ID=$cid";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
					// echo $kso_id." - 311";
						
					$sql="insert into a_penjualan(PENERIMAAN_ID,UNIT_ID,USER_ID,JENIS_PASIEN_ID,KSO,KSO_ID,TGL,TGL_ACT,NO_PENJUALAN,NO_KUNJUNGAN,NO_PASIEN,NO_RESEP,DOKTER,RUANGAN,SHIFT,CARA_BAYAR,QTY_JUAL,QTY,BIAYA_RETUR,HARGA_NETTO_AWAL,HARGA_NETTO,HARGA_SATUAN,HARGA_KSO,HARGA_PX,SUB_TOTAL,SUM_SUB_TOTAL,EMBALAGE,JASA_RESEP,HARGA_TOTAL,STATUS,NAMA_PASIEN,ALAMAT,UTANG,RACIKAN,KRONIS,DIJAMIN,PPN,PPN_NILAI,HARGA_TOTAL_PPN) values($cid,$idunit,$iduser,$kepemilikan_id,$kso,$kso_id,'$tgltrans',NOW(),'$no_penjualan','$no_kunj','$NoRM','$NoResep','$dokter','$ruangan',$shft,$cara_bayar,$jml,$jml,$biaya_retur,$arfvalue[9],$rata2,$arfvalue[2],$harga_kso,$harga_px,$arfvalue[3],$subtotal,$embalage,$jasa_resep,$tot_harga,1,'$nm_pasien','$txtalamat',$nutang,$isRacik,'$kronis','$o_dijamin','{$ppn}','{$ppn_nilai}','{$harga_ppn}')";
				////echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
					if (mysqli_errno($konek)>0){
						$sql="update a_penerimaan set QTY_STOK=QTY_STOK+$jml where ID=$cid";
						//echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);
					}
				}else{
					$jml=$jml-$cstok;
					$sql="update a_penerimaan set QTY_STOK=0 where ID=$cid";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
					// echo $kso_id." - 333";
					/* $harga_px = $harga_kso = 0;
					if($kso_id == '1' || $o_dijamin=='0'){
						$harga_px = $arfvalue[2];
						$harga_kso = 0;
					} else {
						$harga_kso = $arfvalue[2];
						$harga_px = 0;
					} */
					
					$sql="insert into a_penjualan(PENERIMAAN_ID,UNIT_ID,USER_ID,JENIS_PASIEN_ID,KSO,KSO_ID,TGL,TGL_ACT,NO_PENJUALAN,NO_KUNJUNGAN,NO_PASIEN,NO_RESEP,DOKTER,RUANGAN,SHIFT,CARA_BAYAR,QTY_JUAL,QTY,BIAYA_RETUR,HARGA_NETTO_AWAL,HARGA_NETTO,HARGA_SATUAN,HARGA_KSO,HARGA_PX,SUB_TOTAL,SUM_SUB_TOTAL,EMBALAGE,JASA_RESEP,HARGA_TOTAL,STATUS,NAMA_PASIEN,ALAMAT,UTANG,RACIKAN,KRONIS,DIJAMIN,PPN,PPN_NILAI,HARGA_TOTAL_PPN) values($cid,$idunit,$iduser,$kepemilikan_id,$kso,$kso_id,'$tgltrans',NOW(),'$no_penjualan','$no_kunj','$NoRM','$NoResep','$dokter','$ruangan',$shft,$cara_bayar,$cstok,$cstok,$biaya_retur,$arfvalue[9],$rata2,$arfvalue[2],$harga_kso,$harga_px,$arfvalue[3],$subtotal,$embalage,$jasa_resep,$tot_harga,1,'$nm_pasien','$txtalamat',$nutang,$isRacik,'$kronis','$o_dijamin','{$ppn}','{$ppn_nilai}','{$harga_ppn}')";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
					if (mysqli_errno($konek)>0){
						$sql="update a_penerimaan set QTY_STOK=QTY_STOK+$cstok where ID=$cid";
						//echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);
					}
				}
				$totalSemua += $subtotal2;
			}
			
			if (mysqli_errno($konek)<=0){
				$sql = "DELETE
						FROM a_booking_obat
						WHERE bookID = '{$val}'";
				//echo $sql." ---- Delete Booking 2<br>";
				$rs1=mysqli_query($konek,$sql);
			}
		}
		
		if($iurPasien > 0){
			$sql_ = "update a_penjualan
					SET UTANG = $iurPasien
					where NO_PENJUALAN = '{$no_penjualan}'
					  and UNIT_ID = '{$idunit}'
					  and NO_PASIEN = '{$NoRM}'
					  and NO_KUNJUNGAN = '{$no_kunj}'
					  and TGL = '{$tgltrans}'";
			$query_ = mysqli_query($konek,$sql_) or die (mysqli_error($konek));
		}
		if (mysqli_errno($konek)<=0){
			$sql = "UPDATE {$dbbilling}.b_pelayanan p
					SET p.dilayani = 1
					WHERE p.id = '{$no_kunj}'
					  and p.dilayani = 0";
			$rs1=mysqli_query($konek,$sql);
		}
	}
	
	/* Simpan Pembayaran */
	if($cara_bayar == '1'){
		//$bayar = str_replace('.','',$_REQUEST["bayar"]);
		$bayar = str_replace('.','',mysqli_real_escape_string($konek,$_REQUEST["bayar"]));
		$totalSemua = 0;
		$sBYR = "SELECT SUM(ap.QTY_JUAL*ap.HARGA_SATUAN) total, PPN_NILAI
					FROM a_penjualan ap
					WHERE ap.NO_PENJUALAN = '{$no_penjualan}'
						AND ap.UNIT_ID = '{$idunit}'
						AND ap.USER_ID = '{$iduser}'
						AND ap.CARA_BAYAR = '{$cara_bayar}'
						AND ap.TGL = '{$tgltrans}'
						AND ap.NO_KUNJUNGAN = '{$no_kunj}'
						AND ap.NO_PASIEN = '{$NoRM}'";
		$qBYR = mysqli_query($konek,$sBYR);
		$dBYR = mysqli_fetch_array($qBYR);
		if($jenis_kunjungan != 3){
			$totalSemua = $dBYR['total']+$dBYR['PPN_NILAI'];
		} else {
			$totalSemua = $dBYR['total'];
		}
		
		$kembali = $bayar-$totalSemua; //str_replace('.','',$_REQUEST["kembali"]);
		$tot_harga = $totalSemua;
		
		// get the last no bayar
		$depan = "";
		$sNBayar = "SELECT IFNULL(MAX(ku.NOBAYAR),0) maxno
						   /* IFNULL(MAX(CAST(SUBSTRING_INDEX(ku.NO_BAYAR,'/',-1) AS UNSIGNED)),0) maxno2 */
					FROM a_kredit_utang ku
					WHERE ku.NO_BAYAR IS NOT NULL 
					  OR ku.NOBAYAR IS NOT NULL
					  AND YEAR(ku.TGL_BAYAR) = YEAR(NOW())";
		$qNBayar = mysqli_query($konek,$sNBayar) or die(mysqli_error());
		$dNbayar = mysqli_fetch_array($qNBayar);
		if((int)$dNbayar['maxno'] > 0){
			$no_bayar2 = (int)$dNbayar['maxno']+1;
			$depan = "";
			
			if(strlen($no_bayar2)<6)
				for($i=0; $i<(6-strlen($no_bayar2)); $i++) 
					$depan .= 0;
			else $depan = "";
			
			//$no_bayar = "PY/".$thnNow."-".$blnNow."/".$depan.$no_bayar2;
			$no_bayar = "PY".$thnNow.$depan.$no_bayar2;
		} else {
			$no_bayar2 = 1;
			//$no_bayar = "PY/".$thnNow."-".$blnNow."/000001";
			$no_bayar = "PY".$thnNow."000001";
		}
		
		//$shift = $_SESSION["shift"];
		$shift = mysqli_real_escape_string($Konek,$_SESSION["shift"]);
		
		$sql = "INSERT INTO a_kredit_utang(NO_BAYAR, UNIT_ID, USER_ID, SHIFT, TGL_BAYAR, FK_NO_PENJUALAN, BAYAR_UTANG,
											TOTAL_HARGA, BAYAR, KEMBALI, CARA_BAYAR, NORM, NO_PELAYANAN, NOBAYAR)
				VALUES ('{$no_bayar}', '{$idunit}', '{$iduser}', '{$shift}', NOW(), '{$no_penjualan}', 0, '{$tot_harga}', '{$bayar}', '{$kembali}', '{$cara_bayar}', '{$NoRM}', '{$no_kunj}', '{$no_bayar2}');";
		$query = mysqli_query($konek,$sql) or die (mysqli_error());
				  
		$sql_ = "UPDATE a_penjualan
					SET SUDAH_BAYAR = 1,
						TGL_BAYAR = DATE(NOW()),
						TGL_BAYAR_ACT = NOW(),
						USER_ID_BAYAR = '{$iduser}'
					WHERE NO_PENJUALAN = '{$no_penjualan}'
					  AND UNIT_ID = '{$idunit}'
					  AND USER_ID = '{$iduser}'
					  AND CARA_BAYAR = '{$cara_bayar}'
					  AND TGL = '{$tgltrans}'
					  AND NO_KUNJUNGAN = '{$no_kunj}'
					  AND NO_PASIEN = '{$NoRM}'";
		$query_ = mysqli_query($konek,$sql_) or die (mysqli_error());
	}
	break;
}
//Aksi Save, Edit, Delete Berakhir ====================================

$nokw="000001";
$cekNo = "select MAX(nomor) NO_PENJUALAN from a_no_penjualan_log where unit_id=$idunit and tahun=$th[2]"; //order by id DESC limit 1
//echo $cekNo."<br>";
$qcekNo = mysqli_query($konek,$cekNo);
$dcekNo = mysqli_fetch_array($qcekNo);
$sql="select MAX(CAST(NO_PENJUALAN AS UNSIGNED)) AS NO_PENJUALAN from a_penjualan where UNIT_ID=$idunit and YEAR(TGL)=$th[2]";
//echo $sql."<br>";
$rs=mysqli_query($konek,$sql);
$rows=mysqli_fetch_array($rs);
$cNo_Penjualan=$rows['NO_PENJUALAN'];
//echo " | ".substr($cNo_Penjualan,0,-6).'| lalalal';
if ((int)substr($cNo_Penjualan,0,-6)==$idunit){
	$cNo_Penjualan = substr($cNo_Penjualan,-6); //substr($cNo_Penjualan,1,(strlen($cNo_Penjualan)-1));
}
if(!empty($cNo_Penjualan)){
	if(((int)$dcekNo['NO_PENJUALAN']) > ((int)$cNo_Penjualan)){
		$nokw=(int)$dcekNo["NO_PENJUALAN"]+1;
	} else if(((int)$dcekNo['NO_PENJUALAN']) < ((int)$cNo_Penjualan)){
		$nokw=(int)$cNo_Penjualan+1;
	} else {
		$nokw=(int)$dcekNo["NO_PENJUALAN"]+1;
	}
} else {
	$nokw=(int)$cNo_Penjualan+1;
}

$nokwstr=(string)$nokw;
if (strlen($nokwstr)<6){
	for ($i=0;$i<(6-strlen($nokwstr));$i++) $nokw="0".$nokw;
}else{
	$nokw=$nokwstr;
}

$nokw=$idunit.$nokw;

mysqli_free_result($rs);
?>
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<!-- Script Pop Up Window -->
<script language="javascript">
var win = null;
function NewWindow(mypage,myname,w,h,scroll){
LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings =
'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
win = window.open(mypage,myname,settings)
}
</script>
<!-- Script Pop Up Window Berakhir -->
<?php
	$sCBayar = "Select * from a_cara_bayar where id = 2";
	$qCBayar = mysqli_query($konek,$sCBayar);
	$dCBayar = mysqli_fetch_array($qCBayar);
	$biaya_kredit = $dCBayar['biaya'];
?>
<script language="JavaScript" type="text/JavaScript">
<!--
/*function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
*/
var RowIdx;
var fKeyEnt;
var keyCari;
var linking;
var kelasObat = 0;
function suggest(e,par){
	var keywords=par.value;
	var tbl = document.getElementById('tblJual');
	var jmlRow = tbl.rows.length;
	var i;
	/* if(kelas_obat.value){
		kelasObat = kelas_obat.value;
	} */
	if (jmlRow > 4){
		i=par.parentNode.parentNode.rowIndex-2;
	}else{
		i=0;	
	}
	//if(keywords==""){
	if(keywords.length<2){
		document.getElementById('divobat').style.display='none';
	}else{
		var key;
		if(window.event) {
		  key = window.event.keyCode; 
		}
		else if(e.which) {
		  key = e.which;
		}
		if (key==38 || key==40){
			var tblRow=document.getElementById('tblObat').rows.length;
			if (tblRow>0){
				if (key==38 && RowIdx>0){
					RowIdx=RowIdx-1;
					document.getElementById(RowIdx+1).className='itemtableReq';
					if (RowIdx>0) document.getElementById(RowIdx).className='itemtableMOverReq';
				}else if (key==40 && RowIdx<tblRow){
					RowIdx=RowIdx+1;
					if (RowIdx>1) document.getElementById(RowIdx-1).className='itemtableReq';
					document.getElementById(RowIdx).className='itemtableMOverReq';
				}
			}
		}else if (key==13){
			if (RowIdx>0){
				if (fKeyEnt==false){
					fSetObat(document.getElementById(RowIdx).lang);
				}else{
					fKeyEnt=false;
				}
			}
		}else if (key!=27 && key!=37 && key!=39 && key!=9){
			fKeyEnt=false;
			if (key==123){
				RowIdx=0;
				Request('../transaksi/obatlistjual.php?aKepemilikan=0&aHarga='+document.getElementById('kepemilikan_id').value+'&idunit=<?php echo $idunit; ?>&ksoid='+document.getElementById('kso_id').value+'&aKeyword='+keywords+'&no='+i+'&kelas='+kelasObat , 'divobat', '', 'GET' );
				
				linking = '../transaksi/obatlistjual.php?aKepemilikan=0&aHarga='+document.getElementById('kepemilikan_id').value+'&idunit=<?php echo $idunit; ?>&ksoid='+document.getElementById('kso_id').value+'&aKeyword='+keywords+'&no='+i+'&kelas=';
			}else if (key==120){
				//alert(RowIdx);
			}else{
				RowIdx=0;
				Request('../transaksi/obatlistjual.php?aKepemilikan='+document.getElementById('kepemilikan_id').value+'&aHarga='+document.getElementById('kepemilikan_id').value+'&idunit=<?php echo $idunit; ?>&ksoid='+document.getElementById('kso_id').value+'&aKeyword='+keywords+'&no='+i+'&kelas='+kelasObat , 'divobat', '', 'GET' );
				
				linking = '../transaksi/obatlistjual.php?aKepemilikan='+document.getElementById('kepemilikan_id').value+'&aHarga='+document.getElementById('kepemilikan_id').value+'&idunit=<?php echo $idunit; ?>&ksoid='+document.getElementById('kso_id').value+'&aKeyword='+keywords+'&no='+i+'&kelas=';
			}
			if (document.getElementById('divobat').style.display=='none') fSetPosisi(document.getElementById('divobat'),par);
			document.getElementById('divobat').style.display='block';
		}
	}
}

function gantiKelas(par, urlA = ""){
	//alert(linking+par);
	if(urlA!=""){
		Request(urlA+par, 'divobat', '', 'GET' );
	}
	urlA = "";
}

function suggest1(e,par,ap){
	var keywords=par.value;
	//if(keywords==""){
	//	if (document.forms[0].chkNonPasien.checked==true){
	//		document.getElementById('divpasien').style.display='none';
	//	}else{
		if ((keywords.length<4)&&(ap==1)){
			document.getElementById('divpasien').style.display='none';
		}else if (keywords==""){
			document.getElementById('divpasien').style.display='none';
		}else{
			var key;
			if(window.event) {
			  key = window.event.keyCode; 
			}
			else if(e.which) {
			  key = e.which;
			}
			if (key==38 || key==40){
				var tblRow=document.getElementById('tblPasien').rows.length;
				if (tblRow>0){
					if (key==38 && RowIdx>0){
						RowIdx=RowIdx-1;
						document.getElementById(RowIdx+1).className='itemtableReq';
						if (RowIdx>0) document.getElementById(RowIdx).className='itemtableMOverReq';
					}else if (key==40 && RowIdx<tblRow){
						RowIdx=RowIdx+1;
						if (RowIdx>1) document.getElementById(RowIdx-1).className='itemtableReq';
						document.getElementById(RowIdx).className='itemtableMOverReq';
					}
				}
			}else if (key==13){
				if (RowIdx>0){
					if (fKeyEnt==false){
						fSetPasien(document.getElementById(RowIdx).lang,ap);
					}else{
						fKeyEnt=false;
					}
				}
			}else if (key!=27 && key!=37 && key!=39 && key!=9){
				RowIdx=0;
				fKeyEnt=false;
				document.getElementById('divpasien').innerHTML='';
				if (ap==1){
					Request('../transaksi/pasienlist.php?aKeyword='+keywords, 'divpasien', '', 'GET' );
				}else{
					Request('../transaksi/dokterlist.php?aKeyword='+keywords, 'divpasien', '', 'GET' );
				}
				if (document.getElementById('divpasien').style.display=='none') fSetPosisi(document.getElementById('divpasien'),par);
				document.getElementById('divpasien').style.display='block';
			}
		}
//	}
}

function suggest2(e,par,ap){
var keywords=par.value;
var key;
	if(window.event) {
	  key = window.event.keyCode; 
	}
	else if(e.which) {
	  key = e.which;
	}
	if ((keywords=="")||(key==27)){
		document.getElementById('divpasien').style.display='none';
	}else if (key==13){
		if (document.getElementById('divpasien').style.display=='none'){
			document.getElementById('divpasien').innerHTML='';
			Request('../transaksi/pasienlist.php?aKeyword='+keywords, 'divpasien', '', 'GET' );
			fSetPosisi(document.getElementById('divpasien'),par);
			document.getElementById('divpasien').style.display='block';
		}else{
			if (RowIdx>0){
				if (fKeyEnt==false){
					fSetPasien(document.getElementById(RowIdx).lang,1);
				}else{
					fKeyEnt=false;
				}
			}
		}
	}else if (key==38 || key==40){
		var tblRow=document.getElementById('tblPasien').rows.length;
		if (tblRow>0){
			if (key==38 && RowIdx>0){
				RowIdx=RowIdx-1;
				document.getElementById(RowIdx+1).className='itemtableReq';
				if (RowIdx>0) document.getElementById(RowIdx).className='itemtableMOverReq';
			}else if (key==40 && RowIdx<tblRow){
				RowIdx=RowIdx+1;
				if (RowIdx>1) document.getElementById(RowIdx-1).className='itemtableReq';
				document.getElementById(RowIdx).className='itemtableMOverReq';
			}
		}
	}
}

function cari(e,par,ap){
var keywords=par.value;
var key;
	if(window.event) {
	  key = window.event.keyCode; 
	}
	else if(e.which) {
	  key = e.which;
	}
	if ((keywords=="")||(key==27)){
		document.getElementById('divpasien').style.display='none';
	}else if (key==13){
		if (document.getElementById('divpasien').style.display=='none'){
			RowIdx=0;
			fKeyEnt=false;
			keyCari=keywords;
			document.getElementById('divpasien').innerHTML='';
			if (ap==1){
				Request('../transaksi/pasienlist.php?aKeyword='+keywords+'&unit='+<?php echo $idunit;?>, 'divpasien', '', 'GET' );
			}else if (ap==2){
				Request('../transaksi/pasienlist.php?aKeyword='+keywords+'&unit='+<?php echo $idunit;?>+'&aPar=ok', 'divpasien', '', 'GET' );
			}
			fSetPosisi(document.getElementById('divpasien'),par);
			document.getElementById('divpasien').style.display='block';
		}else{
			if (RowIdx>0){
				if (fKeyEnt==false){
					fSetPasien(document.getElementById(RowIdx).lang,1);
				}else{
					fKeyEnt=false;
				}
			}else{
				fKeyEnt=false;
				if (keyCari!=keywords){
					keyCari=keywords;
					if (ap==1){
						Request('../transaksi/pasienlist.php?aKeyword='+keywords+'&unit='+<?php echo $idunit;?>, 'divpasien', '', 'GET' );
					}else if (ap==2){
						Request('../transaksi/pasienlist.php?aKeyword='+keywords+'&unit='+<?php echo $idunit;?>+'&aPar=ok', 'divpasien', '', 'GET' );
					}
				}
			}
		}
	}else if (key==38 || key==40){
		var tblRow=document.getElementById('tblPasien').rows.length;
		if (tblRow>0){
			if (key==38 && RowIdx>0){
				RowIdx=RowIdx-1;
				document.getElementById(RowIdx+1).className='itemtableReq';
				if (RowIdx>0) document.getElementById(RowIdx).className='itemtableMOverReq';
			}else if (key==40 && RowIdx<tblRow){
				RowIdx=RowIdx+1;
				if (RowIdx>1) document.getElementById(RowIdx-1).className='itemtableReq';
				document.getElementById(RowIdx).className='itemtableMOverReq';
			}
		}
	}
}

function fSubmit(){
	document.getElementById('btnSimpan').disabled = true;
	var cdata='';
	var ctemp;
	var sx1,sx2,sx3,sx4,sx5,sx6,sx7;
	var bayarC = 2; // document.getElementById('cara_bayar').value;
	var hasilcek = '';
	// document.getElementById('kurangcek').value = '';
	
	if(bayarC == '1'){
		if(document.getElementById('bayar').value == '0' || document.getElementById('bayar').value == ''){
			alert('Silahkan isi terlebih dahulu data bayar pasien!');
			document.getElementById('bayar').focus();
			document.getElementById('bayar').select();
			document.getElementById('btnSimpan').disabled = false;
			return false;
		} else {
			var bayarN = document.getElementById('bayar').value.split('.').join("");
			var totalN = document.getElementById('tot_harga').value.split('.').join("");
			if((bayarN*1) < (totalN*1)){
				alert('Maaf, Nilai Bayar Tidak Boleh Lebih Kecil dari Total Harga!');
				document.getElementById('btnSimpan').disabled = false;
				return false;
			}
		}
	}
	
	document.getElementById('kso_id').disabled = false;
	document.getElementById('ruangan').disabled = false;
	document.getElementById('no_kunj').disabled = false;
	document.getElementById('txtalamat').disabled = false;
	document.getElementById('nm_pasien').disabled = false;
	document.getElementById('kepemilikan_id').disabled = false;
	/* if(document.getElementById('no_kunj').value == "" && bayarC != '1'){
		alert('Maaf, Pasien non Rumah Sakit Tidak Dapat Melakukan Pembelian Secara Kredit atau Paket!');
		document.getElementById('btnSimpan').disabled = false;
		return false;
	} */
	
	if(no_kunj.value != "" && (dokter.value == '-' || dokter.value == ''  ) && document.getElementById('ruangan').value !=8 ){
		alert("Maaf, field Dokter harus di isi!");
		dokter.value = "";
		dokter.focus();
		document.getElementById('kso_id').disabled = true;s
		document.getElementById('ruangan').disabled = true;
		document.getElementById('no_kunj').disabled = true;
		document.getElementById('txtalamat').disabled = true;
		document.getElementById('nm_pasien').disabled = true;
		document.getElementById('kepemilikan_id').disabled = true;
		document.getElementById('btnSimpan').disabled = false;
	} else {
		if (confirm('Apakah Data Sudah Benar?')){
			if (document.forms[0].obatid.length){
				for (var i=0;i<document.forms[0].obatid.length;i++){
					if((document.forms[0].txtJml[i].value == "" || document.forms[0].txtJml[i].value == "0") && document.forms[0].obatid[i].value != ""){
						document.getElementById('kso_id').disabled = true;
						document.getElementById('ruangan').disabled = true;
						document.getElementById('no_kunj').disabled = true;
						document.getElementById('txtalamat').disabled = true;
						document.getElementById('nm_pasien').disabled = true;
						document.getElementById('kepemilikan_id').disabled = true;
						document.getElementById('btnSimpan').disabled = false;
						alert("Maaf data obat anda belum lengkap!");
						window.setTimeout(function (){
							if(document.forms[0].obatid[i].value == ""){
								document.forms[0].txtObat[i].focus();
							} else {
								document.forms[0].txtJml[i].focus();
							}
						}, 0);
						return false;
					}
					if(document.forms[0].bookID[i].value == "" && document.forms[0].obatid[i].value != ""){
						document.getElementById('kso_id').disabled = true;
						document.getElementById('ruangan').disabled = true;
						document.getElementById('no_kunj').disabled = true;
						document.getElementById('txtalamat').disabled = true;
						document.getElementById('nm_pasien').disabled = true;
						document.getElementById('kepemilikan_id').disabled = true;
						document.getElementById('btnSimpan').disabled = false;
						alert("Maaf sedang dalam proses pengecekan, silahkan coba beberapa saat lagi untuk menyimpan!");
						return false;
					}
				}
			} else {
				if((document.forms[0].txtJml.value == "" || document.forms[0].txtJml.value == "0")){
				 //&& document.forms[0].obatid.value != ""
					document.getElementById('kso_id').disabled = true;
					document.getElementById('ruangan').disabled = true;
					document.getElementById('no_kunj').disabled = true;
					document.getElementById('txtalamat').disabled = true;
					document.getElementById('nm_pasien').disabled = true;
					document.getElementById('kepemilikan_id').disabled = true;
					document.getElementById('btnSimpan').disabled = false;
					alert("Maaf data obat anda belum lengkap!");
					window.setTimeout(function (){
						if(document.forms[0].obatid.value == ""){
							document.forms[0].txtObat.focus();
						} else {
							document.forms[0].txtJml.focus();
						}
					}, 0);
					return false;
				}
				if(document.forms[0].bookID.value == "" && document.forms[0].obatid.value != ""){
					document.getElementById('kso_id').disabled = true;
					document.getElementById('ruangan').disabled = true;
					document.getElementById('no_kunj').disabled = true;
					document.getElementById('txtalamat').disabled = true;
					document.getElementById('nm_pasien').disabled = true;
					document.getElementById('kepemilikan_id').disabled = true;
					document.getElementById('btnSimpan').disabled = false;
					alert("Maaf sedang dalam proses pengecekan, silahkan coba beberapa saat lagi untuk menyimpan!");
					return false;
				}
			}
			
			if (document.forms[0].obatid.length){
				for (var i=0;i<document.forms[0].obatid.length;i++){
					idBooking = document.forms[0].bookID[i].value;
					if (document.forms[0].racik[i].checked==true){
						sx6="1";
					} else {
						sx6="0";
					}
					cdata += idBooking+"|"+sx6+'**';
				}
				if (cdata!=''){
					cdata=cdata.substr(0,cdata.length-2);
				} else {
					document.forms[0].txtObat[i].focus();
					alert('Pilih Obat Terlebih Dahulu !');
					document.getElementById('btnSimpan').disabled = false;
					return false;
				}
			} else {
				idBooking = document.forms[0].bookID.value;
				if (document.forms[0].racik.checked==true){
					sx6="1";
				} else {
					sx6="0";
				}
				cdata += idBooking+"|"+sx6+'**';
			}
			//alert(cdata);
			document.forms[0].fdata.value=cdata;
			//document.getElementById('btnSimpan').disabled=true;
			var cekdata = "";
			if (document.forms[0].obatid.length){
				var DbookID = document.forms[0].bookID[0].value;
				var bayar = document.getElementById('bayar').value;
				var kembali = document.getElementById('kembali').value;
				var unit_ID = "<?php echo $idunit; ?>";
				
				for (var i=0;i<document.forms[0].obatid.length;i++){
					var DbookID2 = document.forms[0].bookID[i].value;
					var obatid 	= document.forms[0].obatid[i].value;
					var qty		= document.forms[0].txtJml[i].value;
					var kpem	= document.forms[0].kpid[i].value;
					var HarNet	= document.forms[0].txtHargaNetto[i].value;
					var numrowS	= (i+3);
					if(obatid!=""){
						cekdata += obatid+'|'+kpem+'|'+qty+'|'+numrowS+'|'+DbookID2+'|'+HarNet+']-[';
					}
				}
				if (cekdata!=''){
					cekdata=cekdata.substr(0,cekdata.length-3);
				}
				
				var act = 'cekBook';
				var urlBook = "../transaksi/booked_utils.php";
				var data = "bookingID="+DbookID+'&act='+act+'&cekdata='+cekdata+"&unit="+unit_ID+"bayar="+bayar+"&kembali="+kembali+"&user=<?php echo $_SESSION['iduser']; ?>";
				request2("POST", urlBook, data, function(hasilx){
					if(hasilx == 'kosong'){
						globdis = true;
						document.getElementById('btnSimpan').disabled = true;
						alert("Maaf pelayanan anda telah melebihi batas waktu 1 jam, silahkan reset dan isi kembali data penjualan anda!");
					} else if(hasilx == 'minus'){
						globdis = true;
						alert('Maaf, Nilai Bayar Tidak Boleh Lebih Kecil dari Total Harga!');
						document.getElementById('btnSimpan').disabled = false;
						document.getElementById('bayar').focus();
						document.getElementById('bayar').select();
					} else {
						var param = hasilx.split('|');
						if(param[0]=='stokTD'){
							alert(param[1]);
							var bariss = param[3];
							var tbl = document.getElementById('tblJual');
							var tds = tbl.rows[bariss].getElementsByTagName('td');
							tds[3].innerHTML = param[2];
							document.forms[0].txtJml[(bariss-3)].value = '';
							document.forms[0].txtJml[(bariss-3)].focus();
							document.forms[0].txtJml[(bariss-3)].select();
							document.getElementById('bayar').value = 0;
							document.getElementById('kembali').value = 0;
							document.getElementById('btnSimpan').disabled = false;
							return false;
						} else {
							document.forms[0].submit();
						}
					}
				}, numrowS, act);
			} else {
				var DbookID = document.forms[0].bookID.value;
				var bayar = document.getElementById('bayar').value;
				var kembali = document.getElementById('kembali').value;
				var unit_ID = "<?php echo $idunit; ?>";
				var obatid 	= document.forms[0].obatid.value;
				var qty		= document.forms[0].txtJml.value;
				var kpem	= document.forms[0].kpid.value;
				var HarNet	= document.forms[0].txtHargaNetto.value;
				var numrowS	= 3;
				cekdata += obatid+'|'+kpem+'|'+qty+'|'+numrowS+'|'+DbookID+'|'+HarNet;
				
				var act = 'cekBook';
				var urlBook = "../transaksi/booked_utils.php";
				var data = "bookingID="+DbookID+'&act='+act+'&cekdata='+cekdata+"&unit="+unit_ID+"bayar="+bayar+"&kembali="+kembali+"&user=<?php echo $_SESSION['iduser']; ?>";
				request2("POST", urlBook, data, function(hasilx){
					if(hasilx == 'kosong'){
						globdis = true;
						document.getElementById('btnSimpan').disabled = true;
						alert("Maaf pelayanan anda telah melebihi batas waktu 1 jam, silahkan reset dan isi kembali data penjualan anda!");
					} else if(hasilx == 'minus'){
						globdis = true;
						alert('Maaf, Nilai Bayar Tidak Boleh Lebih Kecil dari Total Harga!');
						document.getElementById('bayar').focus();
						document.getElementById('bayar').select();
						document.getElementById('btnSimpan').disabled = false;
					} else {
						var param = hasilx.split('|');
						if(param[0]=='stokTD'){
							alert(param[1]);
							var tbl = document.getElementById('tblJual');
							var tds = tbl.rows[numrowS].getElementsByTagName('td');
							tds[3].innerHTML = param[2];					
							document.forms[0].txtJml.value = '';
							document.forms[0].txtJml.focus();
							document.forms[0].txtJml.select();
							document.getElementById('bayar').value = 0;
							document.getElementById('kembali').value = 0;
							document.getElementById('btnSimpan').disabled = false;
							return false;
						} else {
							document.forms[0].submit();
						}
					}
				}, numrowS, act);
			}
		}
	}
	/* if (document.forms[0].obatid.length){
		for (var i=0;i<document.forms[0].obatid.length;i++){
			if ((document.forms[0].txtJml[i].value=="")||(document.forms[0].txtJml[i].value=="0")){
				document.forms[0].txtJml[i].focus();
				alert('Isikan Jumlah Obat Yg Mau Dijual !');
				return false;
			}
			ctemp=document.forms[0].obatid[i].value.split('|');
			if ((ctemp[1]*1)<(document.forms[0].txtJml[i].value*1)){
				document.forms[0].txtObat[i].focus();
				alert('Stok Obat Kurang !');
				return false;
			}
			if (document.forms[0].racik[i].checked==true){
				sx6="1";
			}else{
				sx6="0";
			}
			sx1=document.forms[0].txtHarga[i].value;
			sx2=document.forms[0].txtSubTot[i].value;
			sx3=document.forms[0].subtotal.value;
			sx4=document.forms[0].tot_harga.value;
			sx5=document.forms[0].txtHargaNetto[i].value;
			sx7=document.forms[0].bayar.value;
			while (sx1.indexOf(".")>-1){
				sx1=sx1.replace(".","");
			}
			while (sx2.indexOf(".")>-1){
				sx2=sx2.replace(".","");
			}
			while (sx3.indexOf(".")>-1){
				sx3=sx3.replace(".","");
			}
			while (sx4.indexOf(".")>-1){
				sx4=sx4.replace(".","");
			}
			while (sx5.indexOf(".")>-1){
				sx5=sx5.replace(".","");
			}
			cdata +=ctemp[0]+'|'+document.forms[0].txtJml[i].value+'|'+sx1+'|'+sx2+'|'+sx3+'|'+document.forms[0].embalage.value+'|'+document.forms[0].jasa_resep.value+'|'+sx4+'|'+document.forms[0].kpid[i].value+'|'+sx5+'|'+sx6+'**';
		}
		if (cdata!=''){
			cdata=cdata.substr(0,cdata.length-2);
		}else{
			document.forms[0].txtObat[i].focus();
			alert('Pilih Obat Terlebih Dahulu !');
			return false;
		}
	}else{
		if (document.forms[0].obatid.value==""){
			document.forms[0].txtObat.focus();
			alert('Pilih Obat Terlebih Dahulu !');
			return false;
		}
		if ((document.forms[0].txtJml.value=="")||(document.forms[0].txtJml.value=="0")){
			document.forms[0].txtJml.focus();
			alert('Isikan Jumlah Obat Yg Mau Dijual !');
			return false;
		}
		ctemp=document.forms[0].obatid.value.split('|');
		if ((ctemp[1]*1)<(document.forms[0].txtJml.value*1)){
			document.forms[0].txtObat.focus();
			alert('Stok Obat Kurang !');
			return false;
		}
		if (document.forms[0].racik.checked==true){
			sx6="1";
		}else{
			sx6="0";
		}
		sx1=document.forms[0].txtHarga.value;
		sx2=document.forms[0].txtSubTot.value;
		sx3=document.forms[0].subtotal.value;
		sx4=document.forms[0].tot_harga.value;
		sx5=document.forms[0].txtHargaNetto.value;
		sx7=document.forms[0].bayar.value;
		while (sx1.indexOf(".")>-1){
			sx1=sx1.replace(".","");
		}
		while (sx2.indexOf(".")>-1){
			sx2=sx2.replace(".","");
		}
		while (sx3.indexOf(".")>-1){
			sx3=sx3.replace(".","");
		}
		while (sx4.indexOf(".")>-1){
			sx4=sx4.replace(".","");
		}
		while (sx5.indexOf(".")>-1){
			sx5=sx5.replace(".","");
		}
		
		cdata=ctemp[0]+'|'+document.forms[0].txtJml.value+'|'+sx1+'|'+sx2+'|'+sx3+'|'+document.forms[0].embalage.value+'|'+document.forms[0].jasa_resep.value+'|'+sx4+'|'+document.forms[0].kpid.value+'|'+sx5+'|'+sx6;
	}
	//alert(cdata);
	//alert(document.forms[0].kso_id.value);
	document.forms[0].fdata.value=cdata; */
	/* cara_bayar_ = 2; //(document.forms[0].cara_bayar.value*1);
	nilaibayar = document.forms[0].bayar.value;
	nilaibayar = nilaibayar.replace(/\./g,'');
	if(cara_bayar_ == 1 && ((nilaibayar*1) < (sx4*1))){
		alert('Maaf Nilai Bayar Tidak Boleh Lebih Kecil dari Total Harga!');
		document.forms[0].bayar.value = 0;
		document.forms[0].kembali.value = 0;
		document.getElementById('bayar').focus();
		document.getElementById('bayar').select();
	} else {
		if (confirm('Apakah Data Sudah Benar?')){
			document.getElementById('kso_id').disabled = false;
			document.getElementById('ruangan').disabled = false;
			document.getElementById('btnSimpan').disabled=true;
			document.forms[0].submit();
		}
	} */
}

function fSetBatalFr(){
	/* var tbl = document.getElementById('tblJual');
	document.getElementById('kso_id').disabled = false;
	document.getElementById('ruangan').disabled = false;
	var jmlRow = tbl.rows.length;
	if (jmlRow > 4){
		for (var i=jmlRow;i>4;i--){
			tbl.deleteRow(i-1);
		}
	}
	document.form1.txtObat.focus(); */
	var bookingID = [];
	//document.form1.bookID
	//alert(jmlRow);
	if (document.forms[0].obatid.length){
		for (var i=0;i<document.forms[0].obatid.length;i++){
			if(document.forms[0].bookID[i].value!=""){
				bookingID[i] = document.forms[0].bookID[i].value;
			}
		}
	} else {
		if(document.forms[0].bookID.value!=""){
			bookingID[0] = document.forms[0].bookID.value;
		}
	}
	//alert(bookingID[1]);
	if(bookingID.length>0){
		var act = "resBook";
		var urlBook = "../transaksi/booked_utils.php";
		var data = "bookingID="+bookingID.join(',')+"&act="+act;
		request2("GET", urlBook, data, BatalFr, rowKe, act);
	} else {
		BatalFr();
	}
}

function BatalFr(){
	var tbl = document.getElementById('tblJual');
	var jmlRow = tbl.rows.length;
	if (jmlRow > 4){
		for(var i=jmlRow;i>4;i--){
			tbl.deleteRow(i-1);
		}
	}
	var cBayar = 2; // document.getElementById('cara_bayar').value;
	if(cBayar != '1'){
		var paramm = "&cara_bayar="+cBayar;
	} else {
		var paramm = "";
	}
	// document.forms[0].txtObat.focus();
	location='?f=../transaksi/penjualan.php'; // +paramm;
}

function HitungSubTot(par){
//var tbl = document.getElementById('tblJual');
var i=par.parentNode.parentNode.rowIndex;
var p;
var q,r;
	//alert(i);
	if (i==3){
		if (document.form1.txtJml.length){
			if (document.form1.txtJml[i-3].value==""){
				return false;
			}
			q=document.form1.txtHarga[i-3].value;
			r=document.form1.txtJml[i-3].value;
			while (q.indexOf(".")>-1){
				q=q.replace(".","");
			}
	/*		while (r.indexOf(".")>-1){
				r=r.replace(".","");
			}
	*/
			p=parseFloat(q)*parseFloat(r);
			//p=(document.form1.txtHarga[i-3].value*1)*(document.form1.txtJml[i-3].value*1);
			document.form1.txtSubTot[i-3].value=FormatNumberFloor(parseInt(p.toString()),".");
			//document.form1.txtSubTot[i-3].value=(document.form1.txtHarga[i-3].value*1)*(document.form1.txtJml[i-3].value*1);
		}else{
			if (document.form1.txtJml.value==""){
				return false;
			}
			q=document.form1.txtHarga.value;
			r=document.form1.txtJml.value;
			while (q.indexOf(".")>-1){
				q=q.replace(".","");
			}
	/*		while (r.indexOf(".")>-1){
				r=r.replace(".","");
			}
	*/
			p=parseFloat(q)*parseFloat(r);
			document.form1.txtSubTot.value=FormatNumberFloor(parseInt(p.toString()),".");
			//document.form1.txtSubTot.value=(document.form1.txtHarga.value*1)*(document.form1.txtJml.value*1).toPrecision(2);
		}
	}else{
		if (document.form1.txtJml[i-3].value==""){
			return false;
		}
		q=document.form1.txtHarga[i-3].value;
		r=document.form1.txtJml[i-3].value;
		while (q.indexOf(".")>-1){
			q=q.replace(".","");
		}
/*		while (r.indexOf(".")>-1){
			r=r.replace(".","");
		}
*/
		p=parseFloat(q)*parseFloat(r);
		//p=(document.form1.txtHarga[i-3].value*1)*(document.form1.txtJml[i-3].value*1);
		document.form1.txtSubTot[i-3].value=FormatNumberFloor(parseInt(p.toString()),".");
		//document.form1.txtSubTot[i-3].value=(document.form1.txtHarga[i-3].value*1)*(document.form1.txtJml[i-3].value*1);
	}
	HitungTot();
}

function HitungTot(){
var q;
	if (document.form1.txtSubTot.length){
		var cStot=0;
		for (var i=0;i<document.form1.txtSubTot.length;i++){
			//alert(document.form1.txtSubTot[i].value);
			q=document.form1.txtSubTot[i].value;
			while (q.indexOf(".")>-1){
				q=q.replace(".","");
			}
			cStot +=parseInt(q);
		}
		document.form1.subtotal.value=FormatNumberFloor(cStot,".");
		//alert(cStot);
	}else{
		q=document.form1.txtSubTot.value;
		while (q.indexOf(".")>-1){
			q=q.replace(".","");
		}
		document.form1.subtotal.value=FormatNumberFloor(parseInt(q),".");
		cStot=parseInt(q);
	}
	//cStot=(document.form1.subtotal.value*1)+(document.form1.embalage.value*1)+(document.form1.jasa_resep.value*1);
	//document.form1.tot_harga.value=(document.form1.subtotal.value*1)+(document.form1.embalage.value*1)+(document.form1.jasa_resep.value*1);
if(document.getElementById('jenis_kunjungan').value == 3 || document.getElementById('kso_id').value == 2 /*|| document.getElementById('kso_id').value == 3 || document.getElementById('kso_id').value == 13*/ ){
		tot_ppn = parseInt(cStot);
	} else {
		
		document.form1.hargatot.value=FormatNumberFloor(cStot,".");
		var ppn = parseInt(cStot*(10/100));
		document.form1.txtppn.value = ppn;
		var tot_ppn = parseInt(cStot + ppn);
	}
	document.form1.tot_harga.value=FormatNumberFloor(tot_ppn,".");
}

function fBayar(){

var r,s,t;
	r=document.forms[0].bayar.value;
	s=document.forms[0].tot_harga.value;
	while (r.indexOf(".")>-1){
		r=r.replace(".","");
	}
	while (s.indexOf(".")>-1){
		s=s.replace(".","");
	}
	/* if(r < s){
		alert('Nilai Bayar Tidak Boleh Lebih Kecil dari Total Harga!');
		document.forms[0].bayar.value = 0;
	} else { */
		t=parseFloat(r)-parseFloat(s);
		document.forms[0].bayar.value=FormatNumberFloor(parseInt(r),".");
		document.forms[0].kembali.value=FormatNumberFloor(t,".");
	//}
}

function AddRow(e,par){
var key;
	if(window.event) {
	  key = window.event.keyCode; 
	}
	else if(e.which) {
	  key = e.which;
	}
	//alert(key);
	if (key==13){
		addRowToTable();
	}else{
		HitungSubTot(par);
	}
}

// Last updated 2006-02-21
function addRowToTable()
{
//use browser sniffing to determine if IE or Opera (ugly, but required)
	var isIE = false;
	if(navigator.userAgent.indexOf('MSIE')>0){isIE = true;}
//	alert(navigator.userAgent);
//	alert(isIE);
  var tbl = document.getElementById('tblJual');
  var lastRow = tbl.rows.length;
  // if there's no header row in the table, then iteration = lastRow + 1
  var iteration = lastRow;
  var row = tbl.insertRow(lastRow);
  	//row.id = 'row'+(iteration-1);
  	row.className = 'itemtable';
	//row.setAttribute('class', 'itemtable');
	row.onmouseover = function(){this.className='itemtableMOver';};
	row.onmouseout = function(){this.className='itemtable';};
	//row.setAttribute('onMouseOver', "this.className='itemtableMOver'");
	//row.setAttribute('onMouseOut', "this.className='itemtable'");
  
  // left cell
  var cellLeft = row.insertCell(0);
  var textNode = document.createTextNode(iteration-2);
  cellLeft.className = 'tdisikiri';
  cellLeft.appendChild(textNode);
  
  // right cell
  var cellRight = row.insertCell(1);
  var el;
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'obatid';
  }else{
  	el = document.createElement('<input name="obatid"/>');
  }
  el.type = 'hidden';
  el.value = '';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'kpid';
  }else{
  	el = document.createElement('<input name="kpid"/>');
  }
  el.type = 'hidden';
  el.value = '';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtObat';
	el.setAttribute('OnKeyUp', "suggest(event,this);");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="txtObat" onkeyup="suggest(event, this);" autocomplete="off" />');
  }
  el.type = 'text';
  //el.id = 'txtObat'+(iteration-1);
  el.size = 42;
  //el.className = 'txtinput';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'obatBill';
	el.setAttribute('onclick', "listObat(event,this);");
  }else{
  	el = document.createElement('<input name="obatBill" onclick="listObat(event,this);"/>');
  }
  el.type = 'button';
  el.value = 'List Obat';
  //el.id = 'txtObat'+(iteration-1);
  //el.size = 63;
  //el.className = 'txtinput';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'bookID';
	el.setAttribute('id', "bookID");
  }else{
  	el = document.createElement('<input name="bookID" id="bookID" value=""/>');
  }
  el.type = 'hidden'; //hidden
  //el.id = 'txtObat'+(iteration-1);
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
/*
  cellLeft = row.insertCell(2);
  textNode = document.createTextNode('-');
*/
  cellLeft = row.insertCell(2);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'racik';
  }else{
  	el = document.createElement('<input name="racik" />');
  }
  el.type = 'checkbox';
  
  cellLeft.className = 'tdisi';
  cellLeft.appendChild(el);
  //cellLeft.appendChild(textNode);

  cellLeft = row.insertCell(3);
  textNode = document.createTextNode('-');

  cellLeft.className = 'tdisi';
  cellLeft.appendChild(textNode);

  // right cell
  cellRight = row.insertCell(4);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtHargaNetto';
	el.setAttribute('readonly', "true");
  }else{
  	el = document.createElement('<input name="txtHargaNetto" readonly="true" />');
  }
  el.type = 'text';
  //el.id = 'txtHarga'+(iteration-1);
  el.size = 14;
  el.className = 'txtright';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(5);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtJml';
	el.setAttribute('onKeyUp', "AddRow(event,this)");
	el.setAttribute('onblur', "booked(this)");
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="txtJml" onblur="booked(this)" onKeyUp="AddRow(event,this)" autocomplete="off" />');
  }
  el.type = 'text';
  //el.id = 'txtJml'+(iteration-1);
  el.size = 4;
  el.className = 'txtcenter';

  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(6);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtHarga';
	el.setAttribute('readonly', "true");
  }else{
  	el = document.createElement('<input name="txtHarga" readonly="true" />');
  }
  el.type = 'text';
  //el.id = 'txtHarga'+(iteration-1);
  el.size = 14;
  el.className = 'txtright';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(7);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'txtSubTot';
  	el.setAttribute('readonly', "true");
  }else{
  	el = document.createElement('<input name="txtSubTot" readonly="true" />');
  }
  el.type = 'text';
  //el.id = 'txtSubTot'+(iteration-1);
  el.size = 17;
  el.className = 'txtright';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(8);
  if(!isIE){
  	el = document.createElement('img');
  	el.setAttribute('onClick','if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}');
  }else{
  	el = document.createElement('<img name="img" onClick="if (confirm(\'Yakin Ingin Menghapus Data?\')){removeRowFromTable(this);}"/>');
  }
  el.src = '../icon/del.gif';
  el.border = "0";
  el.width = "16";
  el.height = "16";
  el.className = 'proses';
  el.align = "absmiddle";
  el.title = "Klik Untuk Menghapus";
  
//  cellRight.setAttribute('class', 'tdisi');
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  document.forms[0].txtObat[iteration-3].focus();

  // select cell
/*  var cellRightSel = row.insertCell(2);
  var sel = document.createElement('select');
  sel.name = 'selRow';
  sel.id = 'selRow'+iteration;
  sel.options[0] = new Option('text zero', 'value0');
  sel.options[1] = new Option('text one', 'value1');
  cellRightSel.appendChild(sel);
*/
}

function keyPressTest(e, obj){
  var validateChkb = document.getElementById('chkValidateOnKeyPress');
  if (validateChkb.checked) {
    var displayObj = document.getElementById('spanOutput');
    var key;
    if(window.event) {
      key = window.event.keyCode; 
    }
    else if(e.which) {
      key = e.which;
    }
    var objId;
    if (obj != null) {
      objId = obj.id;
    } else {
      objId = this.id;
    }
    displayObj.innerHTML = objId + ' : ' + String.fromCharCode(key);
  }
}

function removeRowFromTable(cRow)
{
	var tbl = document.getElementById('tblJual');
	var jmlRow = tbl.rows.length;
	if (jmlRow > 4){
		var i=cRow.parentNode.parentNode.rowIndex;
		rowKe = (i*1)-3;
		var bookingID = document.forms[0].bookID[rowKe].value;
		if(bookingID!=""){
			var act = "delBook";
			var urlBook = "../transaksi/booked_utils.php";
			var data = "bookingID="+bookingID+"&act="+act;
			request2("GET", urlBook, data, "", rowKe, act);
		}
		
		//if (i>2){
		tbl.deleteRow(i);
		var lastRow = tbl.rows.length;
		for (var i=3;i<lastRow;i++){
			var tds = tbl.rows[i].getElementsByTagName('td');
			tds[0].innerHTML=i-2;
		}
		HitungTot();
	} else {
		var i=cRow.parentNode.parentNode.rowIndex;
		//rowKe = (i*1)-3;
		//alert(rowKe);
		var bookingID = document.forms[0].bookID.value;
		if(bookingID!=""){
			var act = "delBook";
			var urlBook = "../transaksi/booked_utils.php";
			var data = "bookingID="+bookingID+"&act="+act;
			request2("GET", urlBook, data, "", rowKe, act);
		}
		
		document.forms[0].txtJml.value = "";
		document.forms[0].obatid.value="";
		document.forms[0].kpid.value="";
		document.forms[0].txtObat.value="";
		document.forms[0].txtSubTot.value = "";
		document.forms[0].subtotal.value = 0;
		document.forms[0].tot_harga.value = 0;
		tds = tbl.rows[3].getElementsByTagName('td');
		tds[3].innerHTML = "&nbsp;";
		document.forms[0].txtHargaNetto.value="";
		document.forms[0].txtHarga.value="";
		document.forms[0].hargatot.value="";
		document.forms[0].txtppn.value="";
		document.forms[0].racik.checked = false;
		document.forms[0].bookID.value = "";
	}
}

function fSetObat(par){
var tpar=par;
var cdata;
var tbl = document.getElementById('tblJual');
var tds,f;
	while (tpar.indexOf(String.fromCharCode(5))>0){
		tpar=tpar.replace(String.fromCharCode(5),"'");
	}
	while (tpar.indexOf(String.fromCharCode(3))>0){
		tpar=tpar.replace(String.fromCharCode(3),'"');
	}
	cdata=tpar.split("*|*");
	var biaya_kredit = <?php echo (int)$biaya_kredit; ?>; //document.forms[0].cara_bayar.options[document.forms[0].cara_bayar.options.selectedIndex].lang)
	f=parseFloat(cdata[4])+((parseFloat(cdata[4])-parseFloat(cdata[9])) * parseFloat(biaya_kredit/100));
	//alert(f);
	if ((cdata[0]*1)==0){
		document.forms[0].obatid.value=cdata[1]+'|'+cdata[5];
		document.forms[0].kpid.value=cdata[7];
		document.forms[0].txtObat.value=cdata[2];
		tds = tbl.rows[3].getElementsByTagName('td');
		//document.forms[0].txtHarga.value=FormatNum(f,2);
		document.forms[0].txtHargaNetto.value=FormatNumberFloor(parseInt(cdata[9]),".");
		document.forms[0].txtHarga.value=FormatNumberFloor(parseInt(f),".");
		document.forms[0].txtJml.focus();
	}else{
		var w;
		for (var x=0;x<document.forms[0].obatid.length-1;x++){
			w=document.forms[0].obatid[x].value.split('|');
			//alert(cdata[1]+'-'+w[0]);
			if (cdata[1]==w[0]){
				fKeyEnt=true;
				alert("Obat Tersebut Sudah Ada");
				return false;
			}
		}
		document.forms[0].obatid[(cdata[0]*1)-1].value=cdata[1]+'|'+cdata[5];
		document.forms[0].kpid[(cdata[0]*1)-1].value=cdata[7];
		document.forms[0].txtObat[(cdata[0]*1)-1].value=cdata[2];
		tds = tbl.rows[(cdata[0]*1)+2].getElementsByTagName('td');
		//alert((cdata[0]*1)+2);
		//document.forms[0].txtHarga[(cdata[0]*1)-1].value=FormatNum(f,2);
		document.forms[0].txtHargaNetto[(cdata[0]*1)-1].value=FormatNumberFloor(parseInt(cdata[9]),".");
		document.forms[0].txtHarga[(cdata[0]*1)-1].value=FormatNumberFloor(parseInt(f),".");
		document.forms[0].txtJml[(cdata[0]*1)-1].focus();
	}
	//tds[2].innerHTML=cdata[3];
	tds[3].innerHTML=cdata[5];

	document.getElementById('divobat').style.display='none';
	linking = "";
}

function fPilihIur(obj){
var keywords='';
	//alert(obj.id);
	Request('../transaksi/obatlist_iur.php?aKepemilikan='+document.getElementById('kepemilikan_id').value+'&aHarga='+document.getElementById('kepemilikan_id').value+'&idunit=<?php echo $idunit; ?>&aKeyword='+keywords , 'divobat_iur', '', 'GET' );
	document.getElementById('divobat_iur').style.display='block';
}

function fSetObatIur(p){
	//alert(p);
	document.getElementById('divobat_iur').style.display='none';
}

function fObatIurClose(){
	document.getElementById('divobat_iur').style.display='none';
}

function fSetPasien(par,ap){
	var tpar=par;
	var cdata;
	var x;
	while (tpar.indexOf(String.fromCharCode(5))>0){
		tpar=tpar.replace(String.fromCharCode(5),"'");
	}
	while (tpar.indexOf(String.fromCharCode(3))>0){
		tpar=tpar.replace(String.fromCharCode(3),'"');
	}
	cdata=tpar.split("*|*");
	document.getElementById('divpasien').style.display='none';
	if (ap==1){
		document.forms[0].NoRM.value=cdata[0];
		document.forms[0].nm_pasien.value=cdata[1];
		document.forms[0].txtalamat.value=cdata[7];
		document.forms[0].jenis_kunjungan.value=cdata[8];
		document.forms[0].dokter.value=cdata[4];
		document.forms[0].no_kunj.value=cdata[2];
		document.forms[0].NoResep.focus();
		document.forms[0].kso_id.disabled = true;
		document.forms[0].ruangan.disabled = true;
		//document.forms[0].kepemilikan_id.disabled = true;
		//alert(cdata[8]);
		//alert(cdata[5]);
		
		//if(cdata[3]=='PENJ005'){
					
		//}
		// alert(cdata[3]);
		if(cdata[3]=='PENJ004' /*|| cdata[3]=='PENJ009' || cdata[3]=='PENJ012'*/ ){
			// alert(cdata[3]);
			document.getElementById('jenis_kunjungan').value=3;
			document.getElementById('trTOTHAR').style.display = "none";
			document.getElementById('trppn').style.display = "none";
			document.getElementById('trLine').style.display = "none";
			document.getElementById('labelPPN').innerHTML = "TOTAL HARGA";
		} else {
			document.getElementById('jenis_kunjungan').value=1;
			document.getElementById('trTOTHAR').style.display = "table-row";
			document.getElementById('trppn').style.display = "table-row";
			document.getElementById('trLine').style.display = "table-row";
			document.getElementById('labelPPN').innerHTML = "TOTAL + PPN";
		}
		
		if(cdata[8] == 3){
			document.getElementById('jenis_kunjungan').value=3;
			document.getElementById('trTOTHAR').style.display = "none";
			document.getElementById('trppn').style.display = "none";
			document.getElementById('trLine').style.display = "none";
			document.getElementById('labelPPN').innerHTML = "TOTAL HARGA";
		}
		
		for (var i=0;i<document.forms[0].ruangan.length;i++){
			//alert(document.forms[0].ruangan.options[i].lang);
			if (document.forms[0].ruangan.options[i].lang==cdata[5]){
				//alert("ketemu");
				//x=document.forms[0].kso_id.options[i].lang;
				document.forms[0].ruangan.options[i].selected=true;
				//fSetValue(window,'kepemilikan_id*-*'+x);
			}
		}
		
		for (var i=0;i<document.forms[0].kso_id.length;i++){
			//alert(document.forms[0].kso_id.options[i].id);
			// alert(cdata[3]);
			if (document.forms[0].kso_id.options[i].id==cdata[3]){
				//alert("ketemu");
				x=document.forms[0].kso_id.options[i].lang;
				document.forms[0].kso_id.options[i].selected=true;
				//alert(document.forms[0].kso_id.options[i].value);
				if(document.forms[0].kso_id.options[i].value == 2){
					fSelChange(2);
					var carabayar = 1;
				} else {
					var carabayar = 2;
					fSelChange(cdata[3]);
				}
				//alert(document.forms[0].kso_id.options[i].value);
			/*	if(document.forms[0].kso_id.options[i].value == 3 || document.forms[0].kso_id.options[i].value == 13){
					document.getElementById('trTOTHAR').style.display = "none";
					document.getElementById('trppn').style.display = "none";
					document.getElementById('trLine').style.display = "none";
					document.getElementById('labelPPN').innerHTML = "TOTAL HARGA";
					//alert('ppn');
				} */
				
				//alert(x+' - '+document.forms[0].kepemilikan_id.value);
				if ((document.forms[0].kepemilikan_id.value!=x)&&(document.forms[0].obatid.length)){
					window.location='?f=../transaksi/penjualan.php'
				}else{
					if (i==0 || i==1){
						//fSetValue(window,'kepemilikan_id*-*'+x+'*|*cara_bayar*-*1');
						fSetValue(window,'kepemilikan_id*-*'+x/* +'*|*cara_bayar*-*'+carabayar */);
					}else{
						fSetValue(window,'kepemilikan_id*-*'+x/* +'*|*cara_bayar*-*'+carabayar */);
						
					}
					fCaraBayar(2); //
				}
				
			}
		}
	
	}else{
		document.forms[0].dokter.value=par;
		document.forms[0].NoResep.focus();
	}
	
}

function fSetNonPasien(){
	//alert(document.forms[0].chkNonPasien.checked);
	if (document.forms[0].chkNonPasien.checked==true){
		document.forms[0].NoRM.value="";
		document.forms[0].nm_pasien.value="";
		document.forms[0].txtalamat.value="";
		document.forms[0].dokter.value="";
		document.forms[0].no_kunj.value="";
		document.forms[0].NoResep.value="";
		document.forms[0].kepemilikan_id.options[0].selected=true;
		document.forms[0].ruangan.options[0].selected=true;
		document.forms[0].kso_id.options[0].selected=true;
		document.forms[0].txtObat.focus();
		document.getElementById('divpasien').style.display='none';
	}
}

function SetFocus1(e,o,par){
var tmp=par.split("|");
var keyp;
var pos;
	if(window.event) {
	  keyp = window.event.keyCode; 
	}
	else if(e.which) {
	  keyp = e.which;
	}
	//alert(keyp);
	if ((keyp==37)&&(tmp[0]!="")){
		if (o.createTextRange) {
			var r = document.selection.createRange().duplicate();
			r.moveEnd('character', o.value.length);
			if (r.text == '') pos=o.value.length;
			else pos=o.value.lastIndexOf(r.text);
		} else pos=o.selectionStart;
		if (pos==0){
			document.getElementById(tmp[0]).focus();
		}
	}else if((keyp==38)&&(tmp[1]!="")){
		document.getElementById(tmp[1]).focus();
	}else if((keyp==39)&&(tmp[2]!="")){
		if (o.createTextRange) {
			var r = document.selection.createRange().duplicate();
			r.moveStart('character', -o.value.length);
			pos=r.text.length;
		} else pos=o.selectionEnd;
		if (pos==o.value.length){
			document.getElementById(tmp[2]).focus();
		}
	}else if((keyp==40)&&(tmp[3]!="")){
		document.getElementById(tmp[3]).focus();
	}
}

function listObat(e,par){
	document.getElementById('divobat').style.display='none';

	var baris;
	var tbl = document.getElementById('tblJual');
	var jmlRow = tbl.rows.length;
	var key;
	if(window.event) {
	  key = window.event.keyCode; 
	}
	else if(e.which) {
	  key = e.which;
	}
	//var i=par.parentNode.parentNode.rowIndex;
	if (jmlRow > 4){
		//alert(jmlRow);
		baris = par.parentNode.parentNode.rowIndex;
	} else {
		baris = "-";
	}
	//alert(baris);
	//divobat.style.display='none';
	/* if (key==123){
		OpenWnd('../../apotek/transaksi/list_obat_bill.php?idunit=<?php echo $idunit; ?>&kepemilikan=0&baris='+baris,800,500,'msma',true);
	} else { */
		OpenWnd('../../apotek/transaksi/list_obat_all.php?idunit=<?php echo $idunit; ?>&kepemilikan='+document.getElementById('kepemilikan_id').value+'&baris='+baris+'&actB=plang&carabayar=<?php echo (int)$biaya_kredit; ?>',800,500,'msma',true);
	//}
	//document.forms[0].cara_bayar.options[document.forms[0].cara_bayar.options.selectedIndex].lang
}
</script>
<style type="text/css">
<!--
.style1 {font-family: "Courier New", Courier, monospace}
-->
</style>
<script>
var arrRange=depRange=[];
</script>
<!-- Script Pop Up Window -->
<script language="javascript">
var win = null;
function NewWindow(mypage,myname,w,h,scroll){
LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings =
'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
win = window.open(mypage,myname,settings)
}
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js" 
	src="../theme/popcjs.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div id="divobat" align="left" style="position:absolute; z-index:1; left: 100px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
<div id="divpasien" align="left" style="position:absolute; z-index:1; left: 200px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
<div id="divobat_iur" align="left" style="position:absolute; z-index:1; left: 100px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
<div align="center">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
  <input name="fdata" id="fdata" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	  <table width="99%" border="0">
	  	<tr>
			<td>
  <div id="input" style="display:block" align="center"> 
            <?php 
/*			include("../koneksi/konekMssql.php");
			if($NoRM=$_REQUEST['NoRM']=="") $NoRM=xxx; else $NoRM=$_REQUEST['NoRM'];
			$qryTMPasien="SELECT * FROM TMPasien where NoRM='$NoRM'";
			//echo $qryTMPasien;
			$rsTMPasien=mssql_query($qryTMPasien);
			$rowsTMPasien=mssql_fetch_array($rsTMPasien);
			$vnama=$rowsTMPasien['Nama'];
*/
			?>
            <table width="95%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
              <tr> 
                <td width="121">Tanggal&nbsp; </td>
                <td width="259"><input name="tgltrans" type="text" id="tgltrans" size="11" maxlength="10" value="<?php echo $tgl;?>" class="txtcenter" readonly />
                  <input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" <?php echo $DisableBD; ?> onClick="gfPop.fPopCalendar(this.form.tgltrans,depRange);" />
				  
				  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shift <?php if($shft==1){echo 'Pagi';}elseif($shift==2){echo 'Siang';}else{echo 'Malam';} ?><input name="shft" type="text" id="shft" size="2" maxlength="1" value="<?php echo $shft;?>" class="txtcenter" readonly style="display:none" /></td>
                <td width="98">No. Kwitansi</td>
                <td width="232"><input name="nokw" type="text" id="nokw" size="10" maxlength="6" value="<?php echo $nokw;?>" class="txtinput" readonly /></td>
              </tr>
              <tr> 
                <!--<td>No Rekam Medis</td>
                <td>
					<input name="NoRM" type="text" id="NoRM" class="txtinput" size="15" value="" onKeyUp="cari(event,this,2);" autocomplete="off">
					<input type="hidden" id="jenis_kunjungan" value="1" name="jenis_kunjungan"/>
				</td>-->
                <td>Alamat</td>
                <td><input name="txtalamat" type="text" id="txtalamat" class="txtinput" size="40" value=""></td>
              </tr>
              <tr> 
                <td>Nama Pasien</td>
                <td><!--a class="navText" href="../transaksi/daftarPasien.php?NoRM=<?php //echo $NoRM;?>" onClick="NewWindow(../transaksi/daftarPasien.php,'name','1000','400','yes');return false"-->
                  <!--button type="button" class="txtinput" onClick="NewWindow('../transaksi/daftarPasien.php?NoRM='+NoRM.value,'name','1000','400','yes');return false "> 
                  <img src="../icon/go.png" height="16" width="16" border="0"/></button-->
                  <!--/a-->
                <input name="nm_pasien" type="text" id="nm_pasien" class="txtinput" size="35" value="" onKeyUp="cari(event,this,1);" autocomplete="off" tabindex="0"></td>
                <td>No. Resep</td>
                <td><input name="NoResep" type="text" id="NoResep" class="txtinput" size="15" value="" onKeyDown="SetFocus1(event,this,'NoRM|||kepemilikan_id');" autocomplete="off"></td>
              </tr>
              <tr> 
                <td>No. Kunjungan</td>
                <td><input name="no_kunj" type="text" id="no_kunj" class="txtinput" size="25" value="" onKeyDown="SetFocus1(event,this,'|NoRM|kepemilikan_id|dokter');" ></td>
                <td>Jenis Pasien</td>
                <td>
					<select name="kepemilikan_id" id="kepemilikan_id" class="txtinput">
						<?
						  $qry="Select * from a_kepemilikan where aktif=1";
						  $exe=mysqli_query($konek,$qry);
						  while($show=mysqli_fetch_array($exe)){ 
						?>
						<option value="<?=$show['ID'];?>" class="txtinput"<?php if ($kepemilikan_id==$show['ID']) echo " selected";?>> 
						<?=$show['NAMA'];?>
						</option>
						<? }?>
					</select>
					<!--onChange="location='?f=../transaksi/penjualan.php&kepemilikan_id='+this.value+'&kso_id='+kso_id.value+'&chk_kso=true'"-->
				</td>
              </tr>
              <tr> 
                <td>Dokter</td>
                <td><input name="dokter" type="text" id="dokter" class="txtinput" size="35" onKeyUp="suggest1(event,this,2);" autocomplete="off" ></td>
                <!--<td>Ruangan</td>
                <td><select name="ruangan" id="ruangan" class="txtinput" onChange="fSelChange2(this);">
                    <option value="0" class="txtinput">Pilih Ruangan</option>
                    <?
					  $qry="select * from a_unit where UNIT_TIPE in (2,3) AND UNIT_ISAKTIF=1 order by UNIT_ID";
					  $exe=mysqli_query($konek,$qry);
					  while($show=mysqli_fetch_array($exe)){ 
					?>
                    <option value="<?php echo $show['UNIT_ID']; ?>" class="txtinput" lang="<?php echo $show['kdunitfar']; ?>"<?php if ($ruangan==$show['UNIT_ID']) echo "selected";?>><?php echo $show['UNIT_NAME']; ?></option>
                    <? }?>
                  </select></td>-->
              </tr>
              <tr> 
                <td>KSO / Mitra</td>
                <td><select name="ksoid2" id="kso_id" class="txtinput" onChange="fSelChange(this);">
                    <?php
					  $qry="select * from a_mitra where aktif=1 order by idmitra";
					  $exe=mysqli_query($konek,$qry);
					  while($show=mysqli_fetch_array($exe)){ 
					?>
                    <option value="<?php echo $show['IDMITRA']; ?>" lang="<?php echo $show['KEPEMILIKAN_ID']; ?>" id="<?php echo $show['KODE_MITRA']; ?>" class="txtinput"<?php if ($kso_id==$show['IDMITRA']) echo "selected";?>><?php echo $show['NAMA']; ?></option>
                    <?php }?>
                  </select>
				  <!--option value="0" class="txtinput">Pilih KSO</option-->
                    <!--option value="2" lang="1" id="NON" class="txtinput"<?php //if ($kso_id==2) echo "selected";?>>UMUM WARGA</option>
                    <option value="7" lang="1" id="NONW" class="txtinput"<?php //if ($kso_id==7) echo "selected";?>>UMUM NON WARGA</option-->
					</td>
                <td><!-- Cara Bayar--></td>
                <td><!--select name="cara_bayar" id="cara_bayar" class="txtinput" onChange="fCaraBayar(this.value)">
                    <?php
					  $qry="Select * from a_cara_bayar where aktif=1";
					  $exe=mysqli_query($konek,$qry);
					  while($show=mysqli_fetch_array($exe)){ 
					?>
                    <option value="<?php echo $show['id'];?>" class="txtinput" lang="<?php echo $show['biaya'];?>"<?php if ($cara_bayar==$show['id']) echo " selected";?>> 
                    <?php echo $show['nama'];?>
                    </option>
                    <?php }?>
                  </select--></td>
              </tr>
			  <tr id="trtipe_resep_bpjs" > <!-- style="<?php echo "display:table-row;"; //$display_trtipe_resep_bpjs; ?>" -->
                <td>Jenis Resep</td>
                <td id="isian_jresep">
					
				</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
			  <tr id="tr_dijamin" style="display:none;"> <!-- style="<?php echo "display:table-row;"; //$display_trtipe_resep_bpjs; ?>" -->
                <td style="color:blue;">Resep Dijamin KSO?</td>
                <td id="isian_dijamin">
					<input type="checkbox" name="o_dijamin" id="o_dijamin" value="1" onclick="jaminKSO(this.checked);" /><label for="o_dijamin" style="cursor:pointer;">Ya</label>
				</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
  </div>
          <table id="tblJual" width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
            <tr> 
              <td colspan="9" align="center" class="jdltable"><hr></td>
            </tr>
            <tr> 
              <td colspan="8" align="center" class="jdltable">
				<!--span style="float:left; display:inline; font-weight:normal; font-size:12px;">
					&nbsp; Kelas Terapi Obat : 
					<select name="kelas_obat" id="kelas_obat" style="width:150px" onchange="gantiKelas(this.value,linking)">
						<option value="0">SEMUA</option>
						<?php
							/* $sqlK = "SELECT * FROM a_kelas k ORDER BY k.KLS_KODE ASC";
							$queK = mysqli_query($konek,$sqlK);
							while($dataK = mysql_fetch_object($queK)){
								echo "<option value='".$dataK->KLS_ID."'>".$dataK->KLS_NAMA."</option>";
							} */
						?>
					</select>
				</span-->
				<span style="display:inline;">
					DAFTAR PENJUALAN
				</span>
			  </td>
              <td align="right" valign="bottom"><input type="button" value="+" onClick="addRowToTable();" /></td>
            </tr>
            <tr class="headtable"> 
              <td width="25" class="tblheaderkiri">No</td>
              <td class="tblheader">Nama Obat</td>
              <td width="75" class="tblheader">Racikan</td>
              <td width="55" class="tblheader">Stok</td>
              <td class="tblheader">Hrg Netto</td>
              <td width="30" class="tblheader">Jml</td>
              <td width="100" class="tblheader">Hrg<br>
                Satuan</td>
              <td width="120" class="tblheader">Subtotal</td>
              <td class="tblheader" width="30">Proses</td>
            </tr>
            <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
              <td class="tdisikiri" width="25">1</td>
              <td class="tdisi" align="center">
				<input name="obatid" type="hidden" value="">
                <input name="kpid" type="hidden" value=""> 
                <input type="text" name="txtObat" id="txtObat" size="42" onKeyUp="suggest(event,this);" autocomplete="off" />
				<input type="button" name="obatBill" value="List Obat" onclick="listObat(event,this)" />
				<input type="hidden" name="bookID" id="bookID" value=""/>
			  </td>
              <td class="tdisi" width="80"><input type="checkbox" name="racik" id="racik" /></td>
              <td class="tdisi">-</td>
              <td class="tdisi"><input type="text" name="txtHargaNetto" class="txtright" readonly size="14" /></td>
              <td class="tdisi" width="30"><input type="text" name="txtJml" id="txtJml" class="txtcenter" size="4" onKeyUp="AddRow(event,this)" onblur="booked(this)" autocomplete="off" /></td>
              <td class="tdisi" width="50"><input type="text" name="txtHarga" class="txtright" readonly size="14" /></td>
              <td class="tdisi" width="70"><input type="text" name="txtSubTot" class="txtright" readonly size="17" /></td>
              <td class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);}"></td>
            </tr>
          </table>
  
    </table>
    <table width="99%" border="0" cellpadding="0" cellspacing="0" align="center" class="txtinput">
      <input name="subtotal" type="hidden" id="subtotal" size="12" value="0" class="txtright" readonly />
      <input name="embalage" type="hidden" id="embalage" size="12" value="0" class="txtright" onKeyUp="HitungTot()" />
      <input name="jasa_resep" type="hidden" id="jasa_resep" size="12" value="0" class="txtright" onKeyUp="HitungTot()" />
      <!--tr> 
        <td>EMBALAGE</td>
        <td><input name="embalage" type="text" id="embalage" size="12" value="0" class="txtright" onKeyUp="HitungTot()" /></td>
      </tr>
      <tr> 
        <td>JASA RESEP</td>
        <td><input name="jasa_resep" type="text" id="jasa_resep" size="12" value="0" class="txtright" onKeyUp="HitungTot()" /></td>
      </tr-->
      <tr id="trTOTHAR"> 
        <td width="703">&nbsp;</td>
		<td width="191">TOTAL</td>
        <td width="201"> 
          <input name="hargatot" type="text" id="hargatot" size="17" value="0" class="txtright" readonly />
        </td>
      </tr>
	  <tr id="trppn"> 
        <td width="703">&nbsp;</td>
		<td width="191">PPN 10%</td>
        <td width="201"> 
          <input name="txtppn" type="text" id="txtppn" size="17" value="0" class="txtright" readonly />
        </td>
      </tr>
	  <tr id="trLine">
		<td width="703">&nbsp;</td>
		<td width="191">&nbsp;</td>
		<td><span><hr width="135px" style="display:inline-block"></hr>+</span></td>
	  </tr>
	  <tr> 
        <td width="703">&nbsp;</td>
		<td width="191"><span id="labelPPN">TOTAL + PPN</span></td>
        <td width="201"> 
          <input name="tot_harga" type="text" id="tot_harga" size="17" value="0" class="txtright" readonly />
        </td>
      </tr>
	  <tr>
	  	<td colspan="3">&nbsp;</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
	  	<td colspan="2">
			<table id="pembayaran-resep" border="0" cellpadding="0" cellspacing="0" align="center" class="txtinput" style="display:block;" >
				<tr>
					<?php
						$sNBayar = "SELECT IFNULL(MAX(ku.NOBAYAR),0) maxno
										   /* IFNULL(MAX(CAST(SUBSTRING_INDEX(ku.NO_BAYAR,'/',-1) AS UNSIGNED)),0) maxno2 */
									FROM a_kredit_utang ku
									WHERE ku.NO_BAYAR IS NOT NULL 
									  OR ku.NOBAYAR IS NOT NULL
									  AND YEAR(ku.TGL_BAYAR) = YEAR(NOW())";
						$qNBayar = mysqli_query($konek,$sNBayar) or die(mysqli_error());
						$dNbayar = mysqli_fetch_array($qNBayar);
						if((int)$dNbayar['maxno'] > 0){
							$no_bayar2 = (int)$dNbayar['maxno']+1;
							$depan = "";
							
							if(strlen($no_bayar2)<6)
								for($i=0; $i<(6-strlen($no_bayar2)); $i++) 
									$depan .= 0;
							else $depan = "";
							
							//$no_bayar = "PY/".$thnNow."-".$blnNow."/".$depan.$no_bayar2;
							$no_bayar = "PY".$thnNow.$depan.$no_bayar2;
						} else {
							$no_bayar2 = 1;
							//$no_bayar = "PY/".$thnNow."-".$blnNow."/000001";
							$no_bayar = "PY".$thnNow."000001";
						}
					?>
					<td width="97">NO BAYAR</td>
					<td><input type="text" id="nobayar" size="17" readonly value="<?php echo $no_bayar; ?>" style="text-align:center;"/></td>
				</tr>
				<tr> 
					<td>BAYAR</td>
					<td><input name="bayar" type="text" id="bayar" size="17" value="0" class="txtright" onKeyUp="fBayar();" /></td>
				</tr>
				<tr>
					<td>KEMBALI</td>
					<td><input name="kembali" type="text" id="kembali" size="17" value="0" class="txtright" readonly /></td>
				</tr>
			</table>
		</td>
	  </tr>
    </table>
	<br><div align="center"><p align="center"><BUTTON id="btnSimpan" type="button" onClick="if (ValidateForm('tgltrans,shft,nokw,nm_pasien','ind')){fSubmit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>
          <BUTTON type="reset" onClick="fSetBatalFr();"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Reset&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
          <!--a class="navText" href="../report/kwi.php?no_penjualan=<?php //echo $nokwPrint;?>&sunit=<?php //echo $idunit; ?>" onClick="NewWindow(this.href,'name','560','500','yes');return false"--> 
          <a class="navText" href="../newreport/kwi_jual.php?no_penjualan=<?php echo $nokwPrint;?>&sunit=<?php echo $idunit; ?>&no_pasien=<?php echo $NoRM; ?>&tgl=<?php echo $tgltrans; ?>" onClick="NewWindow(this.href,'name','560','500','yes');return false"> 
		  <BUTTON  type="button" <?php  if($act<>'save') echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak 
          Penjualan</BUTTON>
          </a>
          <a class="navText" onClick="previewKwitansi()">
          <BUTTON  type="button"><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Preview</BUTTON>
          </a>
          </p></div>
		</td>
	</tr>
</table>
</form>
</div>
<script>
	document.forms[0].nm_pasien.focus();
	fCaraBayar(2);
	
function fSelChange2(obj){
	var kso = document.getElementById('kso_id').value;
    if(kso == 2 /*|| kso == 3 || kso == 13*/){
		document.getElementById('jenis_kunjungan').value=3;
		document.getElementById('trTOTHAR').style.display = "none";
		document.getElementById('trppn').style.display = "none";
		document.getElementById('trLine').style.display = "none";
		document.getElementById('labelPPN').innerHTML = "TOTAL HARGA";
		return false;
	 }
	
	obj1=obj.value;
	if(obj1== 183 || obj1 == 184 || obj1 == 185 || obj1 == 186 || obj1 == 162) {
	//alert('aaa');
	    document.getElementById('jenis_kunjungan').value=3;
		document.getElementById('trTOTHAR').style.display = "none";
		document.getElementById('trppn').style.display = "none";
		document.getElementById('trLine').style.display = "none";
		document.getElementById('labelPPN').innerHTML = "TOTAL HARGA";
	
		
	} else {
		document.getElementById('jenis_kunjungan').value=1;
		document.getElementById('trTOTHAR').style.display = "table-row";
		document.getElementById('trppn').style.display = "table-row";
		document.getElementById('trLine').style.display = "table-row";
		document.getElementById('labelPPN').innerHTML = "TOTAL + PPN";
		
	}
	
	
	

	
}


	
function fSelChange(obj){
	//alert(obj);
	//alert(obj.options[obj.options.selectedIndex].id);
	//alert(obj.options[obj.options.selectedIndex].lang);
	var tkso,tkpid,tcarabayar;
	// document.getElementById('jenis_kunjungan').value=1;
	tkso = obj.value;
	/* if(tkso == 2){
		tkpid='PENJ005';
	}else{ */
	//	tkpid = obj.options[obj.options.selectedIndex].lang;
	//}
	// alert(obj);
	/*if(  tkso == 3 || tkso == 13 || tkso == 2 || obj=='PENJ004' || obj=='PENJ009' || obj=='PENJ012){*/
	if(tkso == 2 || obj=='PENJ004'){
		document.getElementById('jenis_kunjungan').value=3;
		document.getElementById('trTOTHAR').style.display = "none";
		document.getElementById('trppn').style.display = "none";
		document.getElementById('trLine').style.display = "none";
		document.getElementById('labelPPN').innerHTML = "TOTAL HARGA";
	} else {
		document.getElementById('jenis_kunjungan').value=1;
		document.getElementById('trTOTHAR').style.display = "table-row";
		document.getElementById('trppn').style.display = "table-row";
		document.getElementById('trLine').style.display = "table-row";
		document.getElementById('labelPPN').innerHTML = "TOTAL + PPN";
		
		var inrung = document.getElementById('ruangan').value;
		if(inrung== 183 || inrung == 184 || inrung== 185 || inrung== 186 || inrung== 162) {
		//alert('aaa');
			document.getElementById('jenis_kunjungan').value=3;
			document.getElementById('trTOTHAR').style.display = "none";
			document.getElementById('trppn').style.display = "none";
			document.getElementById('trLine').style.display = "none";
			document.getElementById('labelPPN').innerHTML = "TOTAL HARGA";
		
			
		} else {
			document.getElementById('jenis_kunjungan').value=1;
			document.getElementById('trTOTHAR').style.display = "table-row";
			document.getElementById('trppn').style.display = "table-row";
			document.getElementById('trLine').style.display = "table-row";
			document.getElementById('labelPPN').innerHTML = "TOTAL + PPN";
			
		}
	}
	
	
	var jk = document.getElementById('jenis_kunjungan').value;
	if(jk == 3){
		document.getElementById('jenis_kunjungan').value=3;
		document.getElementById('trTOTHAR').style.display = "none";
		document.getElementById('trppn').style.display = "none";
		document.getElementById('trLine').style.display = "none";
		document.getElementById('labelPPN').innerHTML = "TOTAL HARGA";
	}
	
	if (document.forms[0].kso_id.value==<?php echo $id_mitra_bpjs; ?>){
		document.getElementById('tr_dijamin').style.display = 'table-row';
		document.getElementById('o_dijamin').checked = true;
		var iJResep = '<select name="kronis" id="kronis" class="txtinput">'+
				'<option value="0" class="txtinput">INACBG</option>'+
                '<option value="1" class="txtinput">KRONIS</option>'+
                '<option value="2" class="txtinput">PAKET</option>'+
			    '</select>';
	} else if (document.forms[0].kso_id.value == 1) {
		document.getElementById('tr_dijamin').style.display = 'none';
		document.getElementById('o_dijamin').checked = false;
		var iJResep = '<input type="checkbox" value="2" name="kronis" id="kronis"/><label for="kronis">Paket</label>';
	} else {
		document.getElementById('tr_dijamin').style.display = 'table-row';
		document.getElementById('o_dijamin').checked = true;
		var iJResep = '<input type="checkbox" value="2" name="kronis" id="kronis"/><label for="kronis">Paket</label>';
	}
	
	
	document.getElementById('isian_jresep').innerHTML = iJResep;
	
	if (document.forms[0].obatid.length){
		//fSetValue(window,'kepemilikan_id*-*'+obj.options[obj.options.selectedIndex].lang);
		window.location="?f=../transaksi/penjualan.php&kepemilikan_id="+tkpid+"&kso_id="+obj.value+'&chk_kso=true';
	}else{
		if (obj.value=="2" || obj.value=="7"){
			//fSetValue(window,'kepemilikan_id*-*'+obj.options[obj.options.selectedIndex].lang+'*|*cara_bayar*-*1');
			fSetValue(window,'kepemilikan_id*-*'+tkpid/* +'*|*cara_bayar*-*2' */);
			fCaraBayar(2);
		}else{
			fSetValue(window,'kepemilikan_id*-*'+tkpid/* +'*|*cara_bayar*-*2' */);
			fCaraBayar(2);
		}
	}
	
	
}

function fCaraBayar(param){

	switch((param*1)){
		case 1:
			document.getElementById('pembayaran-resep').style.display = 'block';
			break;
		case 2:
			document.getElementById('pembayaran-resep').style.display = 'none';
			break;
	}
}

function previewKwitansi(){
	var tmp='';
	var id_obat='';
	var i=0;
	if(document.forms[0].obatid.length==undefined){
		id_obat=document.forms[0].obatid.value.split('|');
		tmp+=id_obat[0]+String.fromCharCode(3)+document.forms[0].kpid.value+String.fromCharCode(3)+document.forms[0].txtJml.value+String.fromCharCode(5);
	}
	else{
		for(i=0;i<document.forms[0].obatid.length;i++){
			id_obat=document.forms[0].obatid[i].value.split('|');
			tmp+=id_obat[0]+String.fromCharCode(3)+document.forms[0].kpid[i].value+String.fromCharCode(3)+document.forms[0].txtJml[i].value+String.fromCharCode(5);	
		}
	}
	
	
	var no_kwitansi = document.getElementById('nokw').value;
	var tgltrans = document.getElementById('tgltrans').value;
	var no_resep = document.getElementById('NoResep').value;
	var no_rm = document.getElementById('NoRM').value;
	var nama_pasien = document.getElementById('nm_pasien').value;
	var alamat = document.getElementById('txtalamat').value;
	var jenis_pasien = document.getElementById('kepemilikan_id').value;
	var dokter = document.getElementById('dokter').value;
	var poli = document.getElementById('ruangan').value;
	var kso = document.getElementById('kso_id').value;
	
	var val = "&no_kwitansi="+no_kwitansi+"&tgltrans="+tgltrans+"&no_resep="+no_resep+"&no_rm="+no_rm+"&nama_pasien="+nama_pasien+"&alamat="+alamat+"&jenis_pasien="+jenis_pasien+"&dokter="+dokter+"&poli="+poli+"&kso="+kso;
	
	var url = "../report/pre_kwi_retur.php?sunit=<?php echo $idunit; ?>&val="+val+"&fdata="+tmp;
	//alert(url);
	NewWindow(url,'name','560','500','yes');
	return false;
}


//ajax save and get data
var rowKe = "";
var globdis = false;
function getRequestObject2(){
    var o = null;
    if(window.XMLHttpRequest){
        o = new XMLHttpRequest();
    }else if(window.ActiveXObject){
        try{
            o = new ActiveXObject('Msxml2.XMLHTTP');
        }catch(e1){
            try{
                o = new ActiveXObject('Microsoft.XMLHTTP');
            }catch(e2){

            }
        }
    }
    return o;
}

var cek__ = 0;
function request2(method, adress, sendData, callback, numRow, act){
	//alert(rowKe);
    var o = getRequestObject2();
    var async = (callback!==null);
	var balik = 0;
    if(method === 'GET'){
        if(sendData!=null){adress+="?"+sendData;}
        o.open(method, adress, async);
        o.send(null);
    }else if(method === 'POST'){
        o.open(method, adress, async);
        o.setRequestHeader('Content-Type' , 'application/x-www-form-urlencoded');
        o.send(sendData);
    }
    if(async){
        o.onreadystatechange = function (){
            if(o.readyState==4&&o.status==200){
				//alert(numRow);
				var tbl = document.getElementById('tblJual');
				if(act == 'booking'){
					var isis = o.responseText.split('|');
					if(isis.length == 1){
						if(!document.forms[0].obatid.length){
							document.forms[0].bookID.value = o.responseText;
						} else {
							document.forms[0].bookID[rowKe].value = o.responseText;
						}
						
						if(globdis == true){
							document.getElementById('btnSimpan').disabled = true;
						} else {
							document.getElementById('btnSimpan').disabled = false;
						}
						cek__ = 0;
					} else {
						if(isis[0] == 'stokTD'){
							alert(isis[1]);
							//alert(rowKe);
							//alert(document.forms[0].obatid.length);
							if(!document.forms[0].obatid.length){
								var tds = tbl.rows[3].getElementsByTagName('td');
								tds[3].innerHTML = isis[2];
								document.forms[0].txtJml.value = "";
								document.forms[0].txtJml.focus();
							} else {
								var tds = tbl.rows[rowKe+3].getElementsByTagName('td');
								tds[3].innerHTML = isis[2];
								document.forms[0].txtJml[rowKe].value = "";
								document.forms[0].txtJml[rowKe].focus();
							}
							cek__ = 1;
						} else if(isis[0] == 'stokTDU'){
							alert(isis[1]);
							if(!document.forms[0].obatid.length){
								var tds = tbl.rows[3].getElementsByTagName('td');
								tds[3].innerHTML = isis[2];
								document.forms[0].txtJml.value = isis[3];
								document.forms[0].txtJml.focus();
							} else {
								var tds = tbl.rows[rowKe+3].getElementsByTagName('td');
								tds[3].innerHTML = isis[2];
								document.forms[0].txtJml[rowKe].value = isis[3];
								document.forms[0].txtJml[rowKe].focus();
							}
							cek__ = 1;
						}
						cek__ = 1;
						var barisN = tbl.rows.length;
						//alert(document.forms[0].obatid.length);
						if((barisN-1)>3 && document.forms[0].obatid[(barisN-4)].value == ""){
							tbl.deleteRow(barisN-1);
						}
					}
				} /* else if(act == 'cekBook'){
					if(o.responseText == 'kosong'){
						document.getElementById('btnSimpan').disabled = true;
						alert("Maaf pelayanan anda telah melebihi batas waktu 1 jam, silahkan reset dan isi kembali data penjualan anda!");
						balik = 1;
					} else {
						balik = 0;
					}
				} */
				//document.getElementById("hasilSementara").innerHTML = o.responseText;
				if(callback!=undefined && typeof(callback)=='function'){
					callback(o.responseText);
				}
            }else if(o.readyState==4&&o.status!=200){
                //Error
				req[pos].xmlhttp.abort();
            }
        };
    }
	/* if(balik == 1){
		return false;
	} */
    if(async){
		return ;
	} else {
		return o.responseText;
	}
}

//end ajax save and get data

// function save booked obat onblur
var cek;
function booked(par,racik="no"){
	//document.getElementById('btnSimpan').disabled=true;
	var cdata='';
	var ctemp;
	var idRow = 0;
	var DbookID = "";
	var tbl = document.getElementById('tblJual');
	var jmlRow = tbl.rows.length;
	//alert(jmlRow);
	var sx1,sx2,sx3,sx4,sx5,sx6,sx7,sx8;
	var idRow=par.parentNode.parentNode.rowIndex;
	var kosongObat;
	//save to table
	if(idRow!=0){
		rowKe = idRow;
	} else {
		rowKe = document.getElementById('barisKe').value;
	}
	if(rowKe > 0){
		if(!document.forms[0].obatid.length){
			rowKe = (rowKe*1)-3;
			if(document.forms[0].obatid.value!=""){
				DbookID = document.forms[0].bookID.value;
				if ((document.forms[0].txtJml.value=="")||(document.forms[0].txtJml.value=="0")){
					//document.forms[0].txtJml.focus();
					//alert('Isikan Jumlah Obat Yg Mau Dijual !');
					return false;
				}
				ctemp=document.forms[0].obatid.value.split('|');
				if ((ctemp[1]*1)<(document.forms[0].txtJml.value*1)){
					alert('Stok Obat Tidak Mencukupi!');
					document.forms[0].txtJml.value = "";
					if(jmlRow>4){
						tbl.deleteRow(jmlRow-1);
					}
					//document.forms[0].txtJml.focus();
					window.setTimeout(function (){
						document.forms[0].txtJml.focus();
					}, 0);
					return false;
				}
				sx1=document.forms[0].txtHarga.value;
				sx2=document.forms[0].txtSubTot.value;
				sx3=document.forms[0].subtotal.value;
				sx4=document.forms[0].tot_harga.value;
				sx5=document.forms[0].txtHargaNetto.value;
				if (document.forms[0].racik.checked==true){ sx6="1"; } else { sx6="0"; }
				//alert(sx6);
				// sx7=document.forms[0].jamin_kso.value;
				while (sx1.indexOf(".")>-1){ sx1=sx1.replace(".",""); }
				while (sx2.indexOf(".")>-1){ sx2=sx2.replace(".",""); }
				while (sx3.indexOf(".")>-1){ sx3=sx3.replace(".",""); }
				while (sx4.indexOf(".")>-1){ sx4=sx4.replace(".",""); }
				while (sx5.indexOf(".")>-1){ sx5=sx5.replace(".",""); }
				// while (sx7.indexOf(".")>-1){ sx7=sx7.replace(".",""); }
				cdata=ctemp[0]+'|'+document.forms[0].txtJml.value+'|'+sx1+'|'+sx2+'|'+sx3+'|'+document.forms[0].embalage.value+'|'+document.forms[0].jasa_resep.value+'|'+sx4+'|'+document.forms[0].kpid.value+'|'+sx5+'|'+sx6; //+'|'+sx7;//+'**';
				kosongObat = false;
			} else {
				kosongObat = true;
			}
		} else {
			rowKe = (rowKe*1)-3;
			if(document.forms[0].obatid[rowKe].value!=""){
				DbookID = document.forms[0].bookID[rowKe].value;
				if ((document.forms[0].txtJml[rowKe].value=="")||(document.forms[0].txtJml[rowKe].value=="0")){
					//document.forms[0].txtJml[rowKe].focus();
					//alert('Isikan Jumlah Obat Yg Mau Dijual !');
					return false;
				}
				ctemp=document.forms[0].obatid[rowKe].value.split('|');
				if ((ctemp[1]*1)<(document.forms[0].txtJml[rowKe].value*1)){
					alert('Stok Obat Tidak Mencukupi !');
					document.forms[0].txtJml[rowKe].value = "";
					//document.forms[0].txtJml[rowKe].focus();
					if(rowKe != (jmlRow-4) && document.forms[0].txtJml[(jmlRow-4)].value == ''){
						tbl.deleteRow(jmlRow-1);
					}
					if(!document.forms[0].obatid.length){
						window.setTimeout(function (){
							document.forms[0].txtJml.focus();
						}, 0);
					} else {
						window.setTimeout(function (){
							document.forms[0].txtJml[rowKe].focus();
						}, 0);
					}
					return false;
				}
				sx1=document.forms[0].txtHarga[rowKe].value;
				sx2=document.forms[0].txtSubTot[rowKe].value;
				sx3=document.forms[0].subtotal.value;
				sx4=document.forms[0].tot_harga.value;
				sx5=document.forms[0].txtHargaNetto[rowKe].value;
				if (document.forms[0].racik[rowKe].checked==true){ sx6="1"; } else { sx6="0"; }
				// sx7=document.forms[0].jamin_kso[rowKe].value;
				while (sx1.indexOf(".")>-1){ sx1=sx1.replace(".",""); }
				while (sx2.indexOf(".")>-1){ sx2=sx2.replace(".",""); }
				while (sx3.indexOf(".")>-1){ sx3=sx3.replace(".",""); }
				while (sx4.indexOf(".")>-1){ sx4=sx4.replace(".",""); }
				while (sx5.indexOf(".")>-1){ sx5=sx5.replace(".",""); }
				// while (sx7.indexOf(".")>-1){ sx7=sx7.replace(".",""); }
				cdata=ctemp[0]+'|'+document.forms[0].txtJml[rowKe].value+'|'+sx1+'|'+sx2+'|'+sx3+'|'+document.forms[0].embalage.value+'|'+document.forms[0].jasa_resep.value+'|'+sx4+'|'+document.forms[0].kpid[rowKe].value+'|'+sx5+'|'+sx6; //+'|'+sx7;//+'**';
				kosongObat = false;
			} else {
				kosongObat = true;
			}
		}
		
		var no_kujungan = document.forms[0].no_kunj.value;
		var rdata = no_kujungan+"*|*"+cdata; //+"*|*"+DbookID
		var tglT =  document.forms[0].tgltrans.value;
		var nPas =  document.forms[0].nm_pasien.value;

		//alert(rdata);
		var act = "booking";
		//if(racik == "cek"){ act = "cek"; }
		var urlBook = "../transaksi/booked_utils.php";
		var data = "rdata="+rdata+"&tgltrans="+tglT+"&act="+act+"&bookingID="+DbookID+"&nPas="+nPas+"&unit=<?php echo $idunit; ?>"+"&user=<?php echo $_SESSION['iduser']; ?>";
	
		kosong = ValidateForm('tgltrans,shft,nokw,nm_pasien','ind');
		if(kosong == false){
			if(!document.forms[0].obatid.length){
				document.forms[0].txtJml.value = "";
			} else {
				document.forms[0].txtJml[rowKe].value = "";
			}
			document.getElementById('NoRM').focus();
		} else if(kosong == true && kosongObat == false) {
			request2("GET", urlBook, data, "", rowKe, act);
			document.getElementById('bayar').value = 0;
			document.getElementById('kembali').value = 0;
		}
		 /* function(){
				document.getElementById('btnSimpan').disabled=false;
			} */
	}
//end save to table
}
// end function save booked obat onblur

fSelChange(document.getElementById('kso_id'));
</script>
<?php 
mysqli_close($konek);
?>