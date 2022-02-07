<?php 
//session_start();
// Koneksi =================================
include("../koneksi/konek.php");
//==========================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
$tgltrans1=$_REQUEST["tgltrans"];
$tgltrans=explode("-",$tgltrans1);
$thtr=$tgltrans[2];
$tgltrans=$tgltrans[2]."-".$tgltrans[1]."-".$tgltrans[0];
$rdata = $_REQUEST["rdata"];
$unit_id = $_REQUEST["unit"];
$nama_pasien = str_replace("'","\'",$_REQUEST["nPas"]);
//$nama_pasien = $_REQUEST["nPas"];
$userAct = $_REQUEST["user"];
$act = $_REQUEST["act"];
//no_kujungan*|*obatid|qty|harga_satuan|subtotal|hargatotal|0|0|hargatotal|kepemilikan|harga_satuan_netto|racik|jamin_kso {patern}
			//	  0		1		2			3		 4		5 6		7			8				9			10		11

$data = explode("*|*",$rdata);
$bookID = $_REQUEST['bookingID'];
$no_kunj = $data[0];
$detail = explode("|",$data[1]);
$obatid = $detail[0];
$qty	= $detail[1];
$kpem	= $detail[8];
$idBook = "";

function cekObat($unit_id,$kpem,$obatid,$bookID,$stat='insert'){
	global $konek;
	if($stat == 'insert'){
		$fstat = "";
	} else {
		$fstat = " AND bookID <> '{$bookID}'";
	}

	$get = "SELECT OBAT_ID, SUM(qty_stok) AS stok, KEPEMILIKAN_ID 
			FROM a_stok 
			WHERE unit_id 			= '{$unit_id}' 
			  AND kepemilikan_id 	= '{$kpem}' 
			  AND OBAT_ID 			= '{$obatid}'";
	$qGet = mysqli_query($konek,$get);
	$dGet = mysqli_fetch_object($qGet);
	
	$book = "SELECT obat_id, sum(qty) jml 
			FROM a_booking_obat 
			WHERE obat_id 			= '{$obatid}' 
			  AND unit_id 			= '{$unit_id}'
			  AND kepemilikan_id 	= '{$kpem}' 
			  {$fstat}
			GROUP BY obat_id";
	$qBook = mysqli_query($konek,$book);
	$dBook = mysqli_fetch_object($qBook);
	
	$stok_ada = ($dGet->stok - ($dBook->jml*1));
	//echo $dGet->stok ."-". $dBook->jml ." ||".$stat."|| ";
	return $stok_ada;
}

switch($act){
	case "booking":
		if($bookID==""){
			$stokS = cekObat($unit_id,$kpem,$obatid,$bookID);
			//die($stokS.' ----- '.$qty;
			if($stokS >= $qty){
				$sql = "insert into a_booking_obat(obat_id, qty, detail, tgltrans, user_act, tgl_act, nama_pasien, unit_id, kepemilikan_id)
					values('{$obatid}','{$qty}','".$data[1]."','{$tgltrans}','{$userAct}','{$tglact}','{$nama_pasien}','{$unit_id}','{$kpem}')";
					// no_kunjungan, '{$no_kunj}',
				$query = mysqli_query($konek,$sql);
				$idBook = mysqli_insert_id($konek);
			} else {
				die('stokTD|Maaf stok obat tidak mencukupi!|'.$stokS);
			}
		} else {
			$getS = "select qty from a_booking_obat where bookID = '{$bookID}'";
			$qgetS = mysqli_query($konek,$getS);
			$dStok = mysqli_fetch_object($qgetS);
				
			$stokS = cekObat($unit_id,$kpem,$obatid,$bookID,'update');
			
			if($stokS >= $qty){
				$sql = "UPDATE a_booking_obat
						SET
						  /* no_kunjungan = 'no_kunjungan', */
						  obat_id = '{$obatid}',
						  qty = '{$qty}',
						  detail = '".$data[1]."',
						  tgltrans = '{$tgltrans}',
						  user_act = '{$userAct}',
						  tgl_act = '{$tglact}',
						  nama_pasien = '{$nama_pasien}',
						  unit_id = '{$unit_id}',
						  kepemilikan_id = '{$kpem}'
						WHERE bookID = '{$bookID}';";
				$query = mysqli_query($konek,$sql);
				$succ = mysqli_affected_rows($konek);
				$idBook = $bookID;
			} else {
				die('stokTDU|Maaf stok obat tidak mencukupi!|'.$stokS.'|'.$dStok->qty);
			}
		}
		break;
	case "delBook":
		if($bookID!=""){
			$sql = "DELETE
					FROM a_booking_obat
					WHERE bookID = '{$bookID}'";
			mysqli_query($konek,$sql) or die (mysqli_error());
		}
		break;
	case "resBook":
		$tmpBookID = explode(',',$bookID);
		$jml = count($tmpBookID);
		$where = "WHERE bookID = '{$bookID}'";
		if($jml > 1){
			$where = "WHERE bookID in ({$bookID})";
		}
		if($jml>0){
			$sql = "DELETE
					FROM a_booking_obat
					{$where}";
			mysqli_query($konek,$sql) or die (mysqli_error());
		}
		break;
	case "cekBook":
		// Parameter
		$bayar = $_REQUEST['bayar']*1;
		$kembali = $_REQUEST['kembali']*1;
		if($kembali < 0) { die('minus'); }
		
		/* $sql = "select count(bookID) dstat from a_booking_obat where bookID = '{$bookID}'";
		$query = mysqli_query($konek,$sql);
		$data = mysqli_fetch_array($query);
		if($data['dstat'] == '0'){
			$idBook = 'kosong';
		} else {
			$idBook = 'ada';
		} */
		
		// Gabung dengan act(cekStok) 
		$cekdataTmp	= explode(']-[',$_REQUEST['cekdata']);
		//print_r($cekdataTmp);
		$jml = array();
		$stAda = array();
		$totGlo = $i = 0;
		$subTot = 0;
		foreach($cekdataTmp as $val){
			$cekdata	= explode('|',$val);
			//print_r($cekdata);
			$obatid 	= $cekdata[0];
			$qty		= $cekdata[3]*1;
			$kpem		= $cekdata[2];
			$rowke		= $cekdata[4];
			$bookID_	= $cekdata[5];
			$tmpharnet	= str_replace('.','',$cekdata[6]);
			$harnet		= str_replace(',','.',tmpharnet);
			$subTot 	= $qty*($harnet*1);
			$totGlo 	+= $subTot;
			
			$sql = "select count(bookID) dstat from a_booking_obat where bookID = '{$bookID_}'";
			$query = mysqli_query($konek,$sql);
			$data = mysqli_fetch_array($query);
			if($data['dstat'] == '0'){
				die('kosong');
			}
			
			$stokS = cekObat($unit_id,$kpem,$obatid,$bookID_,'update');
			if($stokS < $qty){
				$jml[$i]	= $rowke;
				$stAda[$i]	= $stokS;
				$i++;
			}
		}
		$minus = $bayar-$totGlo;
		if($minus < 0){
			die('minus');
		}
		
		if(count($jml) > 0){
			die('stokTD|Maaf stok obat tidak mencukupi!|'.$stAda[0]."|".$jml[0]);
		} else {
			die('lanjut');
		}
		//end Gabung
		
		break;
	case "cek":
		$sql = "select bookID, obat_id, no_kunjungan from a_booking_obat where obat_id = '{$obatid}' AND no_kunjungan = '{$no_kunj}'";
		$query = mysqli_query($konek,$sql);
		$jml = mysqli_num_rows($query);
		if($jml>0){
			$data = mysqli_fetch_array($query);
			$sql = "UPDATE a_booking_obat
					SET
					  /* no_kunjungan = 'no_kunjungan', */
					  obat_id = '{$obatid}',
					  qty = '{$qty}',
					  detail = '".$data[1]."',
					  tgltrans = '{$tgltrans}',
					  user_act = '{$userAct}',
					  tgl_act = '{$tglact}',
					  nama_pasien = '{$nama_pasien}',
					  unit_id = '{$unit_id}'
					WHERE bookID = '".$data['bookID']."';";
			$query = mysqli_query($konek,$sql);
			$succ = mysqli_affected_rows($konek);
			$idBook = $data['bookID'];
		}
		break;
	case "cekStok":
		$cekdataTmp	= explode(']-[',$_REQUEST['cekdata']);
		//print_r($cekdataTmp);
		$jml = array();
		$stAda = array();
		$i = 0;
		foreach($cekdataTmp as $val){
			$cekdata	= explode('|',$val);
			//print_r($cekdata);
			$obatid 	= $cekdata[0];
			$qty		= $cekdata[3];
			$kpem		= $cekdata[2];
			$rowke		= $cekdata[4];
			$bookID		= $cekdata[5];
			
			$stokS = cekObat($unit_id,$kpem,$obatid,$bookID,'update');
			if($stokS < $qty){
				$jml[$i]	= $rowke;
				$stAda[$i]	= $stokS;
				$i++;
			}
		}
		//print_r($jml);
		if(count($jml) > 0){
			die('stokTD|Maaf stok obat tidak mencukupi!|'.$stAda[0]."|".$jml[0]);
		} else {
			die('lanjut');
		}
		break;
}
echo $idBook;
?>