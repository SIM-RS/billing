<?php 
session_start();
// Koneksi =================================
include("../koneksi/konek.php");
include('../theme/numberConversion.php');
//============================================
//===============TANGGALAN===================
$tgl_act=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$tgllll=gmdate('d-m-Y',mktime(date('H')+7));
$thhhh=explode("-",$tgllll);
$blnNow = $thhhh[1];
$thnNow = $thhhh[2];
$tglSkrg=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tglSkrg);
$tgla="01-".$th[1]."-".$th[2];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0"?substr($th[1],1,1):$th[1]);
$bulan=explode("|",$bulan);
//$bulan=mysqli_real_escape_string($konek,implode(",",$bulan);
//echo $bulan;
//$bulan=implode("'|'", array_map(mysqli_real_escape_string($konek,$bulan))); 

convert_var($blnNow,$thnNow,$tgla,$ta);

$tgl_s = $_REQUEST['tgl_s'];
$tgl_bayar = $_REQUEST['tgl_bayar'];
$tgl_stm = explode('-',$tgl_s);
$tgl_se = $tgl_stm[2]."-".$tgl_stm[1]."-".$tgl_stm[0];

$tgl_d = $_REQUEST['tgl_d'];
$tgl_dtm = explode('-',$tgl_d);
$tgl_de = $tgl_dtm[2]."-".$tgl_dtm[1]."-".$tgl_dtm[0];

//convert_var($tgl_s,$tgl_bayar,$tgl_stm,$tgl_d,$tgl_se);
//convert_var($tgl_dtm,$tgl_de);
//=========================================
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$id=$_REQUEST['id'];
$no_penjualan=$_REQUEST['no_penjualan'];
$no_penjualan2=$_REQUEST['no_penjualan2'];

convert_var($id,$no_penjualan,$no_penjualan2);

$no_pembayaran=$_REQUEST['no_bayar'];
$no_pembayaran2=$_REQUEST['no_pembayaran'];

$nama_pasien=$_REQUEST['nama_pasien'];
//$nama_pasien1=str_replace("'","''",$nama_pasien);
$nama_pasien1=addslashes($nama_pasien);
$no_pasien=$_REQUEST['no_pasien'];


convert_var(no_pembayaran,$no_pembayaran2,$nama_pasien,$nama_pasien1,$no_pasien);

//convert_var($id,$no_penjualan,$no_penjualan2,$no_pembayaran,$no_pembayaran2);
//$nama_pasien1=str_replace('\"','"',$nama_pasien1);

if(strlen($no_penjualan) < 6 && $no_penjualan != ""){
	$p = strlen($no_penjualan);
	$nol = "";
	for($i=0; $i < (6-$p); $i++){
		$nol .= "0";
	}
	$no_penjualan = $nol.$no_penjualan;
}
//echo $no_penjualan." -----";

$act_bayar=$_REQUEST['act'];
$idPel=$_REQUEST['idPel'];
$noKwitansi = "";
$status=1;
//====================================================================

//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="ku.TGL_BAYAR ASC";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$display_spn_bayar='none';	
$act=$_REQUEST['act']; 
$act_bayar=$_REQUEST['act_bayar']; 
$dijamin=$_REQUEST['jaminTot']; 


convert_var($act_bayar,$idPel,$page,$sorting,$filter);
convert_var($act,$act_bayar,$dijamin);
// Jenis Aksi
//echo $act."<br>";

//print_r($qty_satuan);
function currency($angka){
	$rupiah = number_format($angka,0,",",".");
	return $rupiah;
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

switch ($act){
	
	case "save":
		$iuser = $_SESSION["iduser"];
		$bayar = $_REQUEST['bayarTagihan'];
		$utang = $_REQUEST['utang'];
		$totalTagihan = $_REQUEST['hargaTot'];
		$ishift = $_SESSION["shift"];
		$sisa_akhir=(int)$bayar - (int)$utang;
		$tgl_s = $_REQUEST['tgl_s'];
		$tgl_stm = explode('-',$tgl_s);
		$tgl_se = $tgl_stm[2]."-".$tgl_stm[1]."-".$tgl_stm[0];
		$tgl_d = $_REQUEST['tgl_d'];
		$tgl_dtm = explode('-',$tgl_d);
		$tgl_de = $tgl_dtm[2]."-".$tgl_dtm[1]."-".$tgl_dtm[0];
		$depan = "";
		
		$sNBayar = "SELECT IFNULL(MAX(ku.NOBAYAR),0) maxno
						   /* IFNULL(MAX(CAST(SUBSTRING_INDEX(ku.NO_BAYAR,'/',-1) AS UNSIGNED)),0) maxno2 */
					FROM a_kredit_utang ku
					WHERE ku.NO_BAYAR IS NOT NULL 
					  OR ku.NOBAYAR IS NOT NULL
					  AND YEAR(ku.TGL_BAYAR) = YEAR(NOW())";
		$qNBayar = mysqli_query($konek,$sNBayar) or die(mysqli_error($konek));
		$dNbayar = mysqli_fetch_array($qNBayar);
		if((int)$dNbayar['maxno'] > 0){
			$no_bayar2 = (int)$dNbayar['maxno']+1;
			$depan = "";
			if(strlen($no_bayar2)<6){
				for($i=0; $i<(6-strlen($no_bayar2)); $i++){
					$depan .= 0;
				}
			} else {
				$depan = "";
			}
			//$no_bayar = "PY/".$thnNow."-".$blnNow."/".$depan.$no_bayar2;
			$no_bayar = "PY".$thnNow.$depan.$no_bayar2;
		} else {
			$no_bayar2 = 1;
			//$no_bayar = "PY/".$thnNow."-".$blnNow."/000001";
			$no_bayar = "PY".$thnNow."000001";
		}
		
		$str_no_bayar=$no_bayar;
		//echo $str_no_bayar."<br>";
		
		$sql_get = "SELECT DISTINCT NO_KUNJUNGAN, CARA_BAYAR, UNIT_ID 
					FROM a_penjualan 
					where NO_PENJUALAN = '{$no_penjualan}' 
					   /* AND UNIT_ID = '{$idunit}' */
					   AND NO_PASIEN = '{$no_pasien}'
					   AND NAMA_PASIEN='{$nama_pasien1}'
					   AND SUDAH_BAYAR=0
					   AND CARA_BAYAR <> 1
					   AND DIJAMIN = 0
					   /* AND DATE_FORMAT(TGL,'%Y-%m-%d') BETWEEN '{$tgl_se}' AND '{$tgl_de}'*/";
		//echo $sql_get."<br /><br />";
		$query_get = mysqli_query($konek,$sql_get);
		$data_get = mysqli_fetch_array($query_get);
		$no_pelayanan = $data_get['NO_KUNJUNGAN'];
		$cara_bayar = $data_get['CARA_BAYAR'];
		$ku_unit_id = $data_get['UNIT_ID'];
		
		$noKwitansi = $no_bayar;
		
		if(strpos($no_penjualan2,'|')==true){
		
			$data = explode("|",$no_penjualan2); 
			$j = count($data)-1;
			
			for($i=0;$i<$j;$i++)
			{
				$dt = explode("*",$data[$i]);

				$sql = "INSERT INTO a_kredit_utang(NO_BAYAR, UNIT_ID, USER_ID, SHIFT, TGL_BAYAR, FK_NO_PENJUALAN, BAYAR_UTANG, TOTAL_HARGA, BAYAR, KEMBALI, CARA_BAYAR, NORM, NO_PELAYANAN, NOBAYAR)
				VALUES ('{$no_bayar}', 
				'$dt[1]', 
				
				'{$iuser}', '{$ishift}', NOW(), '$dt[0]', '{$totalTagihan}', '{$totalTagihan}', '{$bayar}', '{$sisa_akhir}', '{$cara_bayar}', '{$no_pasien}', '{$no_pelayanan}','{$no_bayar2}');";
				//	echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
				
				
				$sql="UPDATE a_penjualan 
					  SET /* CARA_BAYAR=1, */
						  UTANG=0,
						  SUDAH_BAYAR = 1,
						  TGL_BAYAR = DATE(NOW()),
						  TGL_BAYAR_ACT = NOW(),
						  USER_ID_BAYAR = '{$iuser}'
					  WHERE/* UNIT_ID='$idunit' AND */ 
						NO_PENJUALAN='$dt[0]' 
						AND NO_PASIEN='{$no_pasien}'
						AND TGL='$dt[2]'
						/*AND NAMA_PASIEN='{$nama_pasien1}'
						AND TGL BETWEEN '{$tgl_se}' AND '{$tgl_de}'*/";
				
				//echo $sql."<br>";
				$rs=mysqli_query($konek,$sql) or die(mysqli_error($konek));
			}
		}else{
			
			$sql = "INSERT INTO a_kredit_utang(NO_BAYAR, UNIT_ID, USER_ID, SHIFT, TGL_BAYAR, FK_NO_PENJUALAN, BAYAR_UTANG, TOTAL_HARGA, BAYAR, KEMBALI, CARA_BAYAR, NORM, NO_PELAYANAN, NOBAYAR)
					VALUES ('{$no_bayar}', '{$ku_unit_id}', '{$iuser}', '{$ishift}', NOW(), '{$no_penjualan}', '{$totalTagihan}', '{$totalTagihan}', '{$bayar}', '{$sisa_akhir}', '{$cara_bayar}', '{$no_pasien}', '{$no_pelayanan}','{$no_bayar2}');";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
				
			$sql="UPDATE a_penjualan 
						  SET /* CARA_BAYAR=1, */
							  UTANG=0,
							  SUDAH_BAYAR = 1,
							  TGL_BAYAR = DATE(NOW()),
							  TGL_BAYAR_ACT = NOW(),
							  USER_ID_BAYAR = '{$iuser}'
						  WHERE
						  /* UNIT_ID='$idunit' AND */
							NO_PENJUALAN='{$no_penjualan}' 
							AND NO_PASIEN='{$no_pasien}'
							AND TGL='$dt[2]'
							/*AND NAMA_PASIEN='{$nama_pasien1}' AND TGL BETWEEN '{$tgl_se}' AND '{$tgl_de}'*/";
					
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql) or die(mysqli_error($konek));
		}
		
		echo "<script type='text/javascript'>location='?f=../transaksi/pembayaran_pasien&no_pembayaran={$no_bayar}&tgl_s={$tgl_s}&tgl_d={$tgl_d}&act_bayar=bayar'</script>";
		
		break; 
}

//Aksi Save, Edit, Delete Berakhir ============================================
?>
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<script language="JavaScript" src="../theme/js/jquery.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" type="text/css" href="../theme/popup.css" />
<script type="text/javascript" src="../theme/prototype.js"></script>
<script type="text/javascript" src="../theme/effects.js"></script>
<script type="text/javascript" src="../theme/popup.js"></script>
<script type="text/javascript" src="../theme/apotik.css"></script>

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

<script language="JavaScript" type="text/JavaScript">


function list_pen(chk,nopen,nopas,nilai,napas,unit_id,kso,tgl){
	
	var awal = document.getElementById('no_penjualan2').value;
	var x = document.getElementById('no_penjualan2').value;
	//var y = document.getElementById('no_bayar').value;
	var cnapas=napas.replace(String.fromCharCode(5),"'");;
	   
	if(chk==true){	
		
		document.getElementById('nama_pasien').value=cnapas;
		document.getElementById('no_penjualan').value=nopen;
		document.getElementById('no_pasien').value=nopas;
		
		var nilai_awal = document.getElementById('hargaTot').value;
		var new_nilai = parseInt(nilai_awal)+parseInt(nilai);
		document.getElementById('hargaTot').value = new_nilai;
		document.getElementById('utang').value = new_nilai;
		document.getElementById('bayarTagihan').value = new_nilai;
		if(kso==2){
			document.getElementById('jaminTot').value = 0;
		}else{
			document.getElementById('jaminTot').value = new_nilai;
		}
		
		var new_nopen = nopen+"*"+unit_id+"*"+tgl+"|";
		document.getElementById('no_penjualan2').value = x+new_nopen;
		
		
		
		//var new_nobayar = y+"|";
		//document.getElementById('no_bayar').value = "<?php echo $no_bayar;?>";

		
	}else{
		
		var nilai_awal = document.getElementById('hargaTot').value;
		var new_nilai = parseInt(nilai_awal)-parseInt(nilai);
		document.getElementById('hargaTot').value = new_nilai;
		document.getElementById('utang').value = new_nilai;
		document.getElementById('bayarTagihan').value = new_nilai;
		if(kso==2){
			document.getElementById('jaminTot').value = 0;
		}else{
			document.getElementById('jaminTot').value = new_nilai;
		}
		
		var x = nopen+"*"+unit_id+"*"+tgl+"|";
		var new_nopen = awal.replace(x,"");
		document.getElementById('no_penjualan2').value = new_nopen
		
    }
		
}

function klikAll(chk)
{
	//alert(chk)
	jQuery('input.chk[type=checkbox]').each(function () {
	//alert(this.checked);
	   if(this.checked != chk)
	   {
			this.click();
	   }
   });
  
}


var RowIdx;
var fKeyEnt;
function getPenj(e,par){
		var key;
		if(window.event) {
		  key = window.event.keyCode; 
		}
		else if(e.which) {
		  key = e.which;
		}
		if(key == 13){
			if(par == ""){
				alert("Masukkan No Penjualan Terlebih Dahulu!");
				return false;
			} else {
				location='?f=../transaksi/pembayaran_pasien&no_penjualan='+par+'&tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value;
			}
		}
}

function suggest(e,par,opt){
var keywords=par.value;//alert(keywords);
	if(keywords==""){
		document.getElementById('divobat').style.display='none';
	}else{
		var key;
		if(window.event) {
		  key = window.event.keyCode; 
		}
		else if(e.which) {
		  key = e.which;
		}
		//alert(key);
		if (key==38 || key==40){
			var tblRow=document.getElementById('pasienlist_penj').rows.length;
			if (tblRow>0){
				//alert(RowIdx);
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
			if ((fKeyEnt==false) && (keywords.length>2)){
				RowIdx=0;
				fKeyEnt=true;
				Request('../transaksi/listbayarpasien.php?aKepemilikan=0&aKeyword='+keywords+'&opt='+opt+'&tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value+'&idunit=<?php echo $idunit; ?>', 'divobat', '', 'GET' );
				fSetPosisi(document.getElementById('divobat'),par);
				document.getElementById('divobat').style.display='block';
			}else{
				if (RowIdx>0){
					if (fKeyEnt==true){
						fSetObat(document.getElementById(RowIdx).lang);
						fKeyEnt=false;
					//}else{
					//	fKeyEnt=false;
					}
				}
			}
		}else if (key!=27 && key!=37 && key!=39){
			//RowIdx=0;
			fKeyEnt=false;
			/*Request('../transaksi/pasienlist_penj.php?aKepemilikan=0&aKeyword='+keywords+'&idunit=<?php echo $idunit; ?>&aOpt='+opt, 'divobat', '', 'GET' );
			if (document.getElementById('divobat').style.display=='none') fSetPosisi(document.getElementById('divobat'),par);
			document.getElementById('divobat').style.display='block';*/
		}
		document.getElementById('hargaTot').value = "0";
		document.getElementById('jaminTot').value = "0";
		document.getElementById('utang').value = "0";
		document.getElementById('no_penjualan2').value = "";
		document.getElementById('bayarT').disabled = false;
	}
}


function cek(par,opt){
var keywords=par.value;//alert(keywords);

		var key;
	
	//	alert(key);
	
				RowIdx=0;
				fKeyEnt=true;
				Request('../transaksi/listbayarpasien.php?aKepemilikan=0&aKeyword='+keywords+'&opt='+opt+'&tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value+'&idunit=<?php echo $idunit; ?>', 'divobat', '', 'GET' );
				fSetPosisi(document.getElementById('divobat'),par);
				document.getElementById('divobat').style.display='block';
			
		
		document.getElementById('hargaTot').value = "0";
		document.getElementById('jaminTot').value = "0";
		document.getElementById('utang').value = "0";
		document.getElementById('bayarT').disabled = false;
		document.getElementById('no_penjualan').focus();
	
}



function suggest2(e,par){
var keywords=par.value;//alert(keywords);
	if(keywords==""){
		document.getElementById('divobat').style.display='none';
	}else{
		var key;
		if(window.event) {
		  key = window.event.keyCode; 
		}
		else if(e.which) {
		  key = e.which;
		}
		//alert(key);
		if (key==38 || key==40){
			var tblRow=document.getElementById('pasienlist_penj').rows.length;
			if (tblRow>0){
				//alert(RowIdx);
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
			if ((fKeyEnt==false) && (keywords.length>2)){
				RowIdx=0;
				fKeyEnt=true;
				Request('../transaksi/listbayarpasien_nama.php?aKepemilikan=0&aKeyword='+keywords+'&tgl_s='+tgl_s.value+'&tgl_d='+tgl_d.value+'&idunit=<?php echo $idunit; ?>', 'divobat', '', 'GET' );
				fSetPosisi(document.getElementById('divobat'),par);
				document.getElementById('divobat').style.display='block';
			}else{
				if (RowIdx>0){
					if (fKeyEnt==true){
						fSetObat(document.getElementById(RowIdx).lang);
						fKeyEnt=false;
					//}else{
					//	fKeyEnt=false;
					}
				}
			}
		}else if (key!=27 && key!=37 && key!=39){
			//RowIdx=0;
			fKeyEnt=false;
			
		}
		document.getElementById('hargaTot').value = "0";
		document.getElementById('utang').value = "0";
		document.getElementById('bayarTagihan').value = "0";
		document.getElementById('kembalian').value = "0";
		
	}
}

function divnone(){
	
	//document.getElementById('nobayar').value = <?php echo $no_bayar; ?>;
	document.getElementById('divobat').style.display='none';
	window.setTimeout(function(){
			document.getElementById("bayarTagihan").focus();
		},0);
	
}

function fSetObat(par){
	param = par.split('*|*');
	tgl_s.value = param[5];
	tgl_d.value = param[5];
	location='?f=../transaksi/pembayaran_pasien&no_penjualan='+param[0]+'&tgl_s='+param[5]+'&tgl_d='+param[5];
	//document.getElementById('divobat').style.display='none';
}

function replaceall(str,replace,with_this)
{
	var str_hasil ="";
	var temp;

	for(var i=0;i<str.length;i++) // not need to be equal. it causes the last change: undefined..
	{
		if (str[i] == replace)
		{
			temp = with_this;
		}
		else
		{
			temp = str[i];
		}

		str_hasil += temp;
	}

	return str_hasil;
}

function fSubmit(){
	//alert(bayarTagihan.value);
	if(utang.value == 0){
		alert('Tagihan Telah Terbayar!');
		return false;
	}else if((bayarTagihan.value*1) < (utang.value*1)){
		alert('Maaf Nilai Bayar Tidak Boleh Lebih Kecil Dari Total Tagihan!');
		bayarTagihan.focus();
		bayarTagihan.select();
		return false;
	}
	if(no_pasien.value != '' || no_penjualan.value != ""){ 
		//alert('bisa');
		if(utang.value == '0'){
			alert('Total Tagihan Telah Dibayar Penuh!');
			return false;
		} else if(bayarTagihan.value == "" || bayarTagihan.value == '0'){
			alert("Besaran Pembayaran Tidak Boleh Kosong!");
			bayarTagihan.value = 0;
			bayarTagihan.focus();
			bayarTagihan.select();
		} else if(bayarTagihan.value != "" || bayarTagihan.value != '0'){
			document.forms[0].submit();
		}
		
		//location='?f=../transaksi/pembayaran_pasien&no_penjualan='+no_penjualan.value; 
	} else {
		alert('Silahkan Masukkan No Penjualan Terlebih Dahulu!');
		return false;
	}
	
	
	document.getElementById('no_penjualan2').value = "";
	document.getElementById('hargaTot').value = "";
	document.getElementById('jaminTot').value = "";
	document.getElementById('utang').value = "";
	document.getElementById('act_bayar').value = "bayar";
	
	document.getElementById('bayarTagihan').value = "";
	document.getElementById('kembalian').value = "";
	
	
}
function fReset(){
	document.getElementById('no_penjualan2').value = "";
	document.getElementById('hargaTot').value = "";
	document.getElementById('utang').value = "";
	document.getElementById('jaminTot').value = "";
	
	document.getElementById('bayarTagihan').value = "";
	document.getElementById('kembalian').value = "";
	document.getElementById('no_pasien').value = "";
	document.getElementById('no_penjualan').value = "";
	document.getElementById('nama_pasien').value = "";
	document.getElementById('tmpLay').value = "";
	document.getElementById('bayarT').disabled = true;
}


function hapusBay(par){
	if(confirm('Yakin ingin menghapus pembayaran?')){
		document.getElementById('act').value = "del";
		document.getElementById('idHps').value = par;
		
		document.forms[0].submit();
	}
}


function hapus(val){


	if(confirm('Yakin Mau Menghapus Data ini'))
		{
			var url = "../transaksi/delete_bayar.php?val="+val;
			//alert(url);
			 jQuery.get(url,function(x){
				if(x=='sukses')
				{
			   alert('Hapus Berhasil');
					// jQuery("gridbox").load("../transaksi/bayar_utils.php?grd=true&tanggal_bayar="+document.getElementById('tanggal_bayar').value);
					a1.loadURL("../transaksi/bayar_utils.php?grd=true&tanggal_bayar="+document.getElementById('tanggal_bayar').value,"","GET");
				}else{
					alert('Gagal Hapus');;
				}
				
			});
		}
		else
		{
		}
	
	
}

function cetak(tipe,par,jamin){
	switch(tipe){
		case "kwitansi":
			param = par.split('|');
			noByr = param[0];
			idUnit = param[1];
			noJual = param[2];
			
			NewWindow('../transaksi/cetakKwi_bayar.php?noKwitansi='+noByr+'&idunit='+idUnit+'&no_penjualan='+noJual,'KwitansiBayar','815','500','yes')
			break;
		case "rincian":
		    noJual=document.getElementById('c_penjualan').value;
			param = par.split('|');
			NewWindow('../newreport/kwi_bayar.php?no_penjualan='+noJual+'&sunit='+param[1]+'&no_pasien='+param[2]+'&tgl='+param[3]+'&iduser_jual='+param[4]+'&bayar=1&no_bayar='+param[5],'Nota Pembayaran',580,500,'yes');
			break;
		case "struk":
			param = par.split('|');
			NewWindow('../newreport/kwi_struk.php?no_bayar='+param[0],'Nota Pembayaran',580,500,'yes');
			break;
		case "rekap":
		   // noJual=document.getElementById('c_penjualan').value
			param = par.split('|');
			NewWindow('../newreport/kwi_rekap.php?no_bayar='+param[0]+'&jamin='+0,'Nota Pembayaran',1200,500,'yes');
			break;
		case "rekap_kso":
		   // noJual=document.getElementById('c_penjualan').value
			param = par.split('|');
			NewWindow('../newreport/kwi_rekap.php?no_bayar='+param[0]+'&jamin='+1+'&nopasien='+document.getElementById('no_pasien').value,'Nota Pembayaran',1200,500,'yes');
			break;
	}
}
</script>
<script>
var arrRange=depRange=[];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs1.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>

<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<?php 
$cstr="";
for ($i = 0; $i < count($no_penjualan); $i++)
{
	//echo strpos($cstr,$no_penjualan[$i])."<br>";
	//echo $cstr."--".$no_penjualan[$i]."<br>";
	if (strpos($cstr,$no_penjualan[$i])<=0) $cstr .="|".$no_penjualan[$i];
}
?>
<style type="text/css">
	.style1 { font-family: "Courier New", Courier, monospace; font-size:14px; }
	#kiri{
		width:90%;
		padding:10px;
		font-size:12px;
		text-align:center;
	}
	#kanan{
		width:40%;
	}
	#kanan table{
		font-size:12px;
		font-weight:bold;
	}
	#kanan table td{
		padding:3px;
	}
	#clear{
		clear:both;
	}
	.inputan{
		border:0px;
		font-weight:bold;
		letter-spacing:2px;
		text-align:right;
		font-size:13px;
		
		
		
	}
	#kotak{
		border: 1px solid #000;
		padding:5px;
		font-weight:bold;
		display:inline-block;
		min-width:150px;
		text-align:right;
	}
	.btn{
	color:#FFF;
	}
	.btn:disabled{
	color:#F00;
	}
</style>
<div id="divobat" align="left" style="position:absolute; z-index:1; left: 700px; width:700px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
<div align="center"> 
  <div id="input" style="display:block">
    <p class="jdltable">Pembayaran Obat</p>
	<form name="form1" method="post" action="">
		<input name="act" id="act" type="hidden" value="save">
        <input name="act_bayar" id="act_bayar" type="hidden" value="">
		<input name="idHps" id="idHps" type="hidden" value="save">
		<input name="page" id="page" type="hidden" value="">
		<input type="hidden" name="sorting" id="sorting" value="">
		<input type="hidden" name="filter" id="filter" value="">
        
	<div id="outer">
		<div id="kiri" style="width:900px; margin:auto; padding:15px; background:#D5F99D; border:1px solid #339900; text-align:center;">
		
			<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0" class="txtinput">
				<tr style="display:none;">
					<td height="25">Data mulai tgl </td>
					<td>:</td>
					<td colspan="5">
						<input name="tgl_s" id="tgl_s" size="11" maxlength="10" readonly 
                        value=""
                         class="txtcenter" />
                         
						<input type="button" name="ButtonTgl" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_s,depRange);" />
						&nbsp; s/d &nbsp;
						<input name="tgl_d" id="tgl_d" size="11" maxlength="10" readonly 
                        value="" class="txtcenter" />
						<input type="button" name="ButtonTgl" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(this.form.tgl_d,depRange);" />
					</td>
				</tr>
				<tr>
                
					<td><span style="display:none">Unit Pelayanan</span></td>
					<td><span style="display:none">:</span></td>
					<td colspan="2"><span style="display:none">
						<select name="unitID" id="unitID" disabled >
				
						</select>
                        </span>
					</td>
					<?php
						$sNBayar = "SELECT IFNULL(MAX(ku.NOBAYAR),0) maxno
									/* IFNULL(MAX(CAST(SUBSTRING_INDEX(ku.NO_BAYAR,'/',-1) AS UNSIGNED)),0) maxno2 */
									FROM a_kredit_utang ku
									WHERE ku.NO_BAYAR IS NOT NULL 
									  OR ku.NOBAYAR IS NOT NULL
									  AND YEAR(ku.TGL_BAYAR) = YEAR(NOW())";
									  
						$qNBayar = mysqli_query($konek,$sNBayar) or die(mysqli_error($konek));
						$dNbayar = mysqli_fetch_array($qNBayar);
						if((int)$dNbayar['maxno'] > 0){
							$no_bayar = (int)$dNbayar['maxno']+1;
							$depan = "";
							if(strlen($no_bayar)<6){
								for($i=0; $i<(6-strlen($no_bayar)); $i++){
									$depan .= 0;
								}
							} else {
								$depan = "";
							}
							$no_bayar = "PY".$thnNow.$depan.$no_bayar;
						} else {
							$no_bayar = "PY".$thnNow."000001";
						}

					?>
					<td width="98">&nbsp;</td>
					<td width="20">&nbsp;</td>
					<td width="205">&nbsp;</td>
				</tr>
				<tr>
					<td width="158">No. Bayar</td>
					<td width="24">:</td>
					<td colspan="2"><input type="text" value="<?php echo $no_bayar; ?>" name="no_bayar" id="no_bayar" size="20" readonly /></td>
					<!-- suggest(event,this); -->
					<td width="98">Total Biaya</td>
					<td width="20">:</td>
					<td align="right">
						<input type="text" class="inputan" value="" name="hargaTot" id="hargaTot" size="13" readonly />
					</td>
				</tr>
				<tr>
				  <td height="25">No Penjualan</td>
				  <td>:</td>
				  <td colspan="2" ><input name="no_penjualan" size="10" id="no_penjualan" class="txtinput" onKeyUp="suggest(event,this,3)" value="" autocomplete="off">
                    <input name="no_penjualan2" size="10" id="no_penjualan2" class="txtinput" onKeyUp="getPenj(event,this.value)" value="" autocomplete="off" type="hidden">
&nbsp;
<input type="button" value="&raquo; Check" name="checkbox" onClick="if(no_penjualan.value != ''){ 					
						cek(document.getElementById('no_penjualan'),3);
						} else {
							alert('Silahkan Masukkan No Penjualan Terlebih Dahulu!');
							return false;
						}"  style="cursor:pointer; background:#66CC00; border:1px solid #006600; padding:0px 5px;"/></td>
				  <td style="padding-bottom:5px;">Dijamin</td>
				  <td style="padding-bottom:5px;">:</td>
				  <td style="padding-bottom:5px;" align="right"><input type="text" class="inputan" value="" name="jaminTot" id="jaminTot" size="13" readonly /></td>
			  </tr>
				<tr>
					<td height="25">NoRM</td>
					<td>:</td>
					<td colspan="2" >
						<input name="no_pasien" id="no_pasien" value="" class="txtinput" type="text" autocomplete="off" size="10" onKeyUp="suggest(event,this,1)">
					</td>
					<td width="98" style="padding-bottom:5px;">Sisa Tagihan</td>
					<td width="20" style="padding-bottom:5px;">:</td>
					<td style="padding-bottom:5px;" align="right">
						<input type="text" class="inputan" value="" name="utang" id="utang" size="13" readonly />
                        
					</td>
				
				</tr>
				<script type="text/javascript">
					function cekNilai(par){
						if((par*1) > 0){
							var kembalian = (par*1)-(utang.value*1);
							document.getElementById('kembalian').value = kembalian;
						}
					}
				</script>
				<tr>
					<td width="158">Nama Pasien</td>
					<td width="24">:</td>
					<td colspan="2"><input name="nama_pasien" size="25" id="nama_pasien" value="" class="txtinput" autocomplete="off" onKeyUp="suggest(event,this,2)"></td>
					<!-- suggest(event,this); onKeyUp="getPenj(event,this.value)" -->
					
					<td width="98" style="border-top:1px dashed #000;">Bayar</td>
					<td width="20" style="border-top:1px dashed #000;">:</td>
					<td style="border-top:1px dashed #000; padding-top:5px;" align="right">
                    
						<input type="text" class="inputan" style="border:2px solid blue;" value="" name="bayarTagihan" id="bayarTagihan" size="13" onKeyUp="cekNilai(this.value);" autocomplete="off" />
                        
					</td>
				</tr>
				<tr>
					<td width="158">Tempat Layanan</td>
					<td width="24">:</td>
					<td colspan="2"><input name="tmpLay" size="25" id="tmpLay" value="" class="txtinput" readonly autocomplete="off"></td>
					<!-- suggest(event,this); -->
					<td width="98">Kembalian</td>
					<td width="20">:</td>
					<td style="padding-top:5px;" align="right">
						<input type="text" class="inputan" name="kembalian" id="kembalian" size="13" value="" readonly />
					</td>
				</tr>
				<tr>
				  <td colspan="7" align="right">&nbsp;</td>
			  </tr>
				<tr>
                
                
					<td colspan="7" align="right"> 
					  <input type="button" name="bayarT" id="bayarT" class="btn"  onclick="fSubmit();" value="Bayar" style="cursor:pointer; background:#009900; border:1px solid #006600; padding:3px 5px;"   />
					  <input type="button" name="bayarR" id="bayarR"   onclick="fReset();" value="Reset" class="btn" style="cursor:pointer; background:#009900; border:1px solid #006600; padding:3px 5px;"  />
					  <input type="button" name="cetakStruk" id="cetakStruk" value="Cetak Struk" onclick="cetak('struk','<?php echo $no_pembayaran2; ?>')" class="btn" style="cursor:pointer; background:#009900; border:1px solid #006600; padding:3px 5px;" />
					  <input type="button" name="cetakStruk" id="cetakStruk" value="Cetak Rekap" 
                    onclick="cetak('rekap','<?php echo $no_pembayaran2; ?>')" class="btn" style="cursor:pointer; background:#009900; border:1px solid #006600; padding:3px 5px;" />
					  <input type="button" name="cetakStruk2" id="cetakStruk2" value="Cetak Rekap KSO" 
                    onclick="cetak('rekap_kso','0')" class="btn" style="cursor:pointer; background:#009900; border:1px solid #006600; padding:3px 5px;" />
				    </td>
				</tr>
			
				<tr>
					<td colspan="7" align="center">
					
					</select>
                        
						<!--<input type="button" name="cetakRin" id=="cetakRin" value="Cetak Kwitansi" onclick="cetak('rincian','')" /-->

                      <!--  <input type="button" name="cetakRekap" id="cetakRekap" value="Cetak Rekap Obat" onclick="cetak('rekap','<?php echo $no_pembayaran2."|".$iduser; ?>')" />-->
                        
					</td>
				</tr>
			
			</table>
		</div>
	</div>	  
	<br />
    <div align="left" style="padding-left:25px">
    	<input name="tanggal_bayar" id="tanggal_bayar" size="11" maxlength="10" readonly value="<?php echo $tglSkrg;?>" align="left" class="txtCenter" style="background-color:#6C3"/>   
        <input type="button" name="ButtonTgl2" value=" V " onClick="gfPop.fPopCalendar(this.form.tanggal_bayar,depRange);"  />
        <input type="button" name="lihat" id="lihat" value="Lihat" 
                    onclick="goSort();" class="btn" style="cursor:pointer; background:#66CC00; border:1px solid #006600; padding:0px 5px;" />
    </div>
    <div id="gridbox" style="width:950px; height:300px; background-color:white; overflow:hidden; margin:auto;">
    </div>
    <br />
			<tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
				<td class="tdisikiri"></td>
				<td class="tdisi"></td>
				<td class="tdisi"></td>
				<td class="tdisi" align="right"></td>
			</tr>
		
    </table-->
    </form>
	<?php //echo $no_penjualan." ----"; ?>
  </div>
</div>

<script type="text/javascript">
var a = document.getElementById("utang").value;
var n = document.getElementById("no_penjualan").value;
var j = document.getElementById("jaminTot").value;
//var b = document.getElementById("act_bayar").value;
var b = "<?php echo $dis_bayar; ?>";

//var n2 = document.getElementById("no_penjualan2").value;

	if((a <= 0 || n=="")|| b=='1' || j>0){
		document.getElementById('bayarT').disabled = true;//ture
	} else {
		document.getElementById('bayarT').disabled = false;//false
	}
	<?php if($no_penjualan != "") { ?>
		document.getElementById("bayarTagihan").focus();
		document.getElementById("bayarTagihan").select();
	<?php } ?>
	
	
var a1=new DSGridObject("gridbox");
a1.setHeader("DATA PEMBAYARAN");
a1.setColHeader("NO,TGL BAYAR, NO BAYAR,NO RM, NAMA PASIEN, NILAI, PETUGAS INPUT,HAPUS");
a1.setIDColHeader(",tgl,nobayar,norm,namapasien,nilai,kasir,");
a1.setColWidth("25,140,100,90,130,130,100,60");
a1.setCellAlign("center,center,center,center,left,right,center,center");
a1.setCellHeight(20);
a1.setImgPath("../icon");
//a1.setIDPaging("paging");
a1.attachEvent("onRowClick","setForm");
a1.onLoaded(konfirmasi);
a1.baseURL("../transaksi/bayar_utils.php?grd=true&tanggal_bayar="+document.getElementById('tanggal_bayar').value);
a1.Init();

function setForm(){
	var sisipan=a1.getRowId(a1.getSelRow()).split("|");
	var noByr = sisipan[2];
	var noRm = sisipan[3];
	
	//document.getElementById('cetakStruk2').setAttribute('onclick',"cetak('rekap_kso','"+noByr+"')");
	document.getElementById('no_pasien').value = noRm;
}

function goFilterAndSort(grd){
	if (grd=="gridbox"){
		a1.loadURL("../transaksi/bayar_utils.php?grd=true&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage(),"","GET");
	
	}
}
function goSort(){
a1.loadURL("../transaksi/bayar_utils.php?grd=true&tanggal_bayar="+document.getElementById('tanggal_bayar').value,"","GET");
}
function konfirmasi(key,val){

	if(key=='Error'){
		if(val=='postingReturnJual'){
			alert('Terjadi Error dlm Proses Posting !');
		}
	}else{
		if(val=='postingReturnJual'){
			alert('Proses Posting Berhasil !');
		}
	}
}




</script>
<?php
	mysqli_close($konek);
?>