<?php 
//include("../sesi.php");
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

$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$minta_id=$_REQUEST['minta_id'];
$sql="SELECT unit_billing FROM a_unit WHERE UNIT_ID=$idunit";
$rs=mysqli_query($konek,$sql);
$rw=mysqli_fetch_array($rs);
$idunitBilling=$rw["unit_billing"];

$nokw=$_REQUEST["nokw"];
$kso_id=$_REQUEST["kso_id"];
if (($kso_id!="0")&&($kso_id!="")) {
	$kso=1;
	//$kso_id=$_REQUEST["kso_id"];
}else{
	$kso=0;
	$kso_id=0;
}
$nokwPrint=$nokw;
$fdata=$_REQUEST["fdata"];
$no_penjualan=$_REQUEST['nokw'];
$no_kunj=$_REQUEST['no_kunj'];
$NoRM=$_REQUEST['NoRM'];
$NoResep=$_REQUEST['NoResep'];
$nm_pasien=$_REQUEST['nm_pasien'];
$txtalamat=$_REQUEST['txtalamat'];
$shft=$shift;
$subtotal=str_replace(".","",$_REQUEST['subtotal']);
$embalage=$_REQUEST['embalage'];
//$embalage=0;
$jasa_resep=$_REQUEST['jasa_resep'];
//$jasa_resep=0;
$tot_harga=str_replace(".","",$_REQUEST['tot_harga']);
$dokter=$_REQUEST['dokter'];
$ruangan=$_REQUEST['ruangan'];
$cara_bayar=$_REQUEST['cara_bayar'];
if ($cara_bayar=="4") $nutang=$tot_harga; else $nutang=0;
$chk_kso=$_REQUEST['chk_kso'];
//======================Tanggalan==========================
$kepemilikan_id=$_REQUEST["kepemilikan_id"];
//if ($kepemilikan_id=="") $kepemilikan_id=$_SESSION["kepemilikan_id"];

//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="UNIT_ID";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$sql="SELECT * FROM a_retur_biaya";
$rs=mysqli_query($konek,$sql);
$biaya_retur=0;
if ($rows=mysqli_fetch_array($rs)) $biaya_retur=$rows['biaya_potong'];

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

switch ($act){
	case "save":
	if ($kepemilikan_id=="") $kepemilikan_id=1;
	//==Cek apakah transaksi ini telah ada pada datanase====
	$sqlCek="select NO_PENJUALAN,USER_ID,date_format(TGL,'%Y-%m-%d') as TGL from a_penjualan where NO_PENJUALAN='$no_penjualan' AND UNIT_ID=$idunit and YEAR(TGL)=$thtr";
	//echo $sqlCek."<br>";
	$exeCek=mysqli_query($konek,$sqlCek);
	$hitung=mysqli_num_rows($exeCek);
	//echo $hitung."<br>";
	if ($hitung >0){
		if ($rows1=mysqli_fetch_array($exeCek)){
			$cuserid=$rows1['USER_ID'];
			$ctgl=$rows1['TGL'];
		}
		if (($cuserid==$iduser) && ($ctgl==$tgltrans)){
			echo "<script>alert('Maaf, No. Transaksi dg nomor $no_penjualan telah ada pada database, silahkan lakukan transaksi lagi')</script>";
		}else{
		//==jika tidak ada pada database, lakukan insert===
			//$sql="select MAX(NO_PENJUALAN) AS NO_PENJUALAN from a_penjualan where UNIT_ID=$idunit and YEAR(TGL)=$thtr";
			$sql="select NO_PENJUALAN from a_penjualan where UNIT_ID=$idunit and YEAR(TGL)=$thtr ORDER BY ID DESC LIMIT 1";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			$nokw="000001";
			//$no_kunj="0";
			//$shft=1;
			if ($rows=mysqli_fetch_array($rs)){
				//$shft=$rows["SHIFT"];
				$nokw=(int)$rows["NO_PENJUALAN"]+1;
				$nokwstr=(string)$nokw;
				if (strlen($nokwstr)<6){
					for ($i=0;$i<(6-strlen($nokwstr));$i++) $nokw="0".$nokw;
				}else{
					$nokw=$nokwstr;
				}
			}
			$no_penjualan=$nokw;
			$nokwPrint=$no_penjualan;
			//echo "no_kw=".$no_penjualan."<br>";
//==============================
			$arfdata=explode("**",$fdata);
			for ($i=0;$i<count($arfdata);$i++)
			{
				$arfvalue=explode("|",$arfdata[$i]);
				if ($kepemilikan_id!=$arfvalue[8]){
					$sql="call gd_mutasi($idunit,$idunit,0,'$no_penjualan',$arfvalue[0],$arfvalue[8],$kepemilikan_id,$arfvalue[1],2,$iduser,1,'$tgltrans','$tglact')";
					//echo $sql."<br>";
					$rs=mysqli_query($konek,$sql);
				}
				$sql="select SQL_NO_CACHE * from a_penerimaan ap where OBAT_ID=".$arfvalue[0]." and UNIT_ID_TERIMA=$idunit and KEPEMILIKAN_ID=$kepemilikan_id and QTY_STOK>0 and ap.STATUS=1 order by TANGGAL,ID";
				//echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
				$done="false";
				$jml=$arfvalue[1];
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
						$sql="insert into a_penjualan(PENERIMAAN_ID,UNIT_ID,USER_ID,JENIS_PASIEN_ID,KSO,KSO_ID,TGL,TGL_ACT,NO_PENJUALAN,NO_KUNJUNGAN,NO_PASIEN,NO_RESEP,DOKTER,RUANGAN,SHIFT,CARA_BAYAR,QTY_JUAL,QTY,BIAYA_RETUR,HARGA_NETTO,HARGA_SATUAN,SUB_TOTAL,SUM_SUB_TOTAL,EMBALAGE,JASA_RESEP,HARGA_TOTAL,STATUS,NAMA_PASIEN,ALAMAT,UTANG,RACIKAN) values($cid,$idunit,$iduser,$kepemilikan_id,$kso,$kso_id,'$tgltrans',NOW(),'$no_penjualan','$no_kunj','$NoRM','$NoResep','$dokter','$ruangan',$shft,$cara_bayar,$jml,$jml,$biaya_retur,$arfvalue[9],$arfvalue[2],$arfvalue[3],$subtotal,$embalage,$jasa_resep,$tot_harga,1,'$nm_pasien','$txtalamat',$nutang,$arfvalue[10])";
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
						$sql="insert into a_penjualan(PENERIMAAN_ID,UNIT_ID,USER_ID,JENIS_PASIEN_ID,KSO,KSO_ID,TGL,TGL_ACT,NO_PENJUALAN,NO_KUNJUNGAN,NO_PASIEN,NO_RESEP,DOKTER,RUANGAN,SHIFT,CARA_BAYAR,QTY_JUAL,QTY,BIAYA_RETUR,HARGA_NETTO,HARGA_SATUAN,SUB_TOTAL,SUM_SUB_TOTAL,EMBALAGE,JASA_RESEP,HARGA_TOTAL,STATUS,NAMA_PASIEN,ALAMAT,UTANG,RACIKAN) values($cid,$idunit,$iduser,$kepemilikan_id,$kso,$kso_id,'$tgltrans',NOW(),'$no_penjualan','$no_kunj','$NoRM','$NoResep','$dokter','$ruangan',$shft,$cara_bayar,$cstok,$cstok,$biaya_retur,$arfvalue[9],$arfvalue[2],$arfvalue[3],$subtotal,$embalage,$jasa_resep,$tot_harga,1,'$nm_pasien','$txtalamat',$nutang,$arfvalue[10])";
						//echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);
						if (mysqli_errno($konek)>0){
							$sql="update a_penerimaan set QTY_STOK=QTY_STOK+$cstok where ID=$cid";
							//echo $sql."<br>";
							$rs1=mysqli_query($konek,$sql);
						}
					}
				}
			}
			
			$sql="UPDATE $dbbilling.b_pelayanan set dilayani=1 where id=".$_REQUEST['idpel'];
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
		}
	}else{
	//==jika tidak ada pada database, lakukan insert===
		//echo "arfdata=".$fdata."<br>";
		$nokwPrint=$no_penjualan;
		//echo "no_kw=".$no_penjualan."<br>";
		$arfdata=explode("**",$fdata);
		for ($i=0;$i<count($arfdata);$i++)
		{
			$arfvalue=explode("|",$arfdata[$i]);
			if ($kepemilikan_id!=$arfvalue[8]){
				$sql="call gd_mutasi($idunit,$idunit,0,'$no_penjualan',$arfvalue[0],$arfvalue[8],$kepemilikan_id,$arfvalue[1],2,$iduser,1,'$tgltrans','$tglact')";
				//echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
			}
			$sql="select SQL_NO_CACHE * from a_penerimaan ap where OBAT_ID=".$arfvalue[0]." and UNIT_ID_TERIMA=$idunit and KEPEMILIKAN_ID=$kepemilikan_id and QTY_STOK>0 and ap.STATUS=1 order by TANGGAL,ID";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			$done="false";
			$jml=$arfvalue[1];
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
					$sql="insert into a_penjualan(PENERIMAAN_ID,UNIT_ID,USER_ID,JENIS_PASIEN_ID,KSO,KSO_ID,TGL,TGL_ACT,NO_PENJUALAN,NO_KUNJUNGAN,NO_PASIEN,NO_RESEP,DOKTER,RUANGAN,SHIFT,CARA_BAYAR,QTY_JUAL,QTY,BIAYA_RETUR,HARGA_NETTO,HARGA_SATUAN,SUB_TOTAL,SUM_SUB_TOTAL,EMBALAGE,JASA_RESEP,HARGA_TOTAL,STATUS,NAMA_PASIEN,ALAMAT,UTANG,RACIKAN) values($cid,$idunit,$iduser,$kepemilikan_id,$kso,$kso_id,'$tgltrans',NOW(),'$no_penjualan','$no_kunj','$NoRM','$NoResep','$dokter','$ruangan',$shft,$cara_bayar,$jml,$jml,$biaya_retur,$arfvalue[9],$arfvalue[2],$arfvalue[3],$subtotal,$embalage,$jasa_resep,$tot_harga,1,'$nm_pasien','$txtalamat',$nutang,$arfvalue[10])";
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
					$sql="insert into a_penjualan(PENERIMAAN_ID,UNIT_ID,USER_ID,JENIS_PASIEN_ID,KSO,KSO_ID,TGL,TGL_ACT,NO_PENJUALAN,NO_KUNJUNGAN,NO_PASIEN,NO_RESEP,DOKTER,RUANGAN,SHIFT,CARA_BAYAR,QTY_JUAL,QTY,BIAYA_RETUR,HARGA_NETTO,HARGA_SATUAN,SUB_TOTAL,SUM_SUB_TOTAL,EMBALAGE,JASA_RESEP,HARGA_TOTAL,STATUS,NAMA_PASIEN,ALAMAT,UTANG,RACIKAN) values($cid,$idunit,$iduser,$kepemilikan_id,$kso,$kso_id,'$tgltrans',NOW(),'$no_penjualan','$no_kunj','$NoRM','$NoResep','$dokter','$ruangan',$shft,$cara_bayar,$cstok,$cstok,$biaya_retur,$arfvalue[9],$arfvalue[2],$arfvalue[3],$subtotal,$embalage,$jasa_resep,$tot_harga,1,'$nm_pasien','$txtalamat',$nutang,$arfvalue[10])";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
					if (mysqli_errno($konek)>0){
						$sql="update a_penerimaan set QTY_STOK=QTY_STOK+$cstok where ID=$cid";
						//echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);
					}
				}
			}
		}
			
		$sql="UPDATE $dbbilling.b_pelayanan set dilayani=1 where id=".$_REQUEST['idpel'];
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
	}
	break;
}

$displayInput="none";
$displayData="block";

if($act=='' && $_REQUEST['idpel']!=''){
	$displayInput="block";
	$displayData="none";

	$sq = "SELECT
	  p.id,
	  ps.no_rm,
	  ps.nama     nama_pasien,
	  ps.alamat,
	  ps.rt,
	  ps.rw,
	  (SELECT
		 nama
	   FROM ".$dbbilling.".b_ms_wilayah
	   WHERE id = ps.desa_id)    desa,
	  (SELECT
		 nama
	   FROM ".$dbbilling.".b_ms_wilayah
	   WHERE id = ps.kec_id)    kec,
	  (SELECT
		 nama
	   FROM ".$dbbilling.".b_ms_wilayah
	   WHERE id = ps.kab_id)    kab,
	  u.id        id_unit,
	  u.nama      nama_unit,
	  kp.ID       id_kepemilikan,
	  kp.NAMA     nama_kepemilikan,
	  kso.id      id_kso,
	  kso.nama    nama_kso,
	  pg.nama     nama_dokter
	FROM ".$dbbilling.".b_pelayanan p
	  INNER JOIN ".$dbbilling.".b_ms_pasien ps
		ON p.pasien_id = ps.id
	  INNER JOIN ".$dbbilling.".b_ms_kso kso
		ON kso.id = p.kso_id
	  LEFT JOIN ".$dbapotek.".a_kepemilikan kp
		ON kso.kepemilikan_id = kp.ID
	  INNER JOIN ".$dbbilling.".b_ms_unit u
		ON u.id = p.unit_id_asal
	  INNER JOIN ".$dbbilling.".b_ms_pegawai pg
		ON pg.id = p.dokter_id
	WHERE p.id = ".$_REQUEST['idpel'];
	//echo $sq."<br>";
	$kueri = mysqli_query($konek,$sq);
	$data = mysqli_fetch_array($kueri);
	//$kepemilikan_id=$data["id_kepemilikan"];
	if ($kepemilikan_id=="") $kepemilikan_id=$data["id_kepemilikan"];
	$ruangan=$data["id_unit"];
	$kso_id=$data["id_kso"];
	if ($kso_id==1){
		$cara_bayar=1;
	}else{
		$cara_bayar=2;
	}
	//echo $ruangan."<br>";
	//==========================================
	//Aksi Save, Edit, Delete Berakhir ====================================
	//$sql="select MAX(NO_PENJUALAN) AS NO_PENJUALAN from a_penjualan where UNIT_ID=$idunit and YEAR(TGL)=$th[2]";
	$sql="SELECT NO_PENJUALAN FROM a_penjualan WHERE UNIT_ID=$idunit AND YEAR(TGL)<=$th[2] ORDER BY ID DESC LIMIT 1";
	//$sql="SELECT NO_PENJUALAN FROM a_penjualan WHERE UNIT_ID=$idunit AND YEAR(TGL)=$th[2] ORDER BY ID DESC LIMIT 1";
	//echo $sql;
	$rs=mysqli_query($konek,$sql);
	$nokw="000001";
	$no_kunj="";
	//$shft=1;
	if ($rows=mysqli_fetch_array($rs)){
		//$shft=$rows["SHIFT"];
		$nokw=(int)$rows["NO_PENJUALAN"]+1;
		$nokwstr=(string)$nokw;
		if (strlen($nokwstr)<6){
			for ($i=0;$i<(6-strlen($nokwstr));$i++) $nokw="0".$nokw;
		}
	}
	mysqli_free_result($rs);
}
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
function suggest(e,par){
var keywords=par.value;//alert(keywords);
	//alert(par.offsetLeft);
  var tbl = document.getElementById('tblJual');
  var jmlRow = tbl.rows.length;
  var i;
  if (jmlRow > 4){
  	i=par.parentNode.parentNode.rowIndex-2;
  }else{
  	i=0;	
  }
  //alert(jmlRow+'-'+i);
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
		//alert(key);
		if (key==38 || key==40){
			var tblRow=document.getElementById('tblObat').rows.length;
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
				Request('../transaksi/obatlistjual.php?aKepemilikan=0&aHarga='+document.getElementById('kepemilikan_id').value+'&idunit=<?php echo $idunit; ?>&aKeyword='+keywords+'&no='+i , 'divobat', '', 'GET' );
			}else if (key==120){
				alert(RowIdx);
			}else{
				RowIdx=0;
				Request('../transaksi/obatlistjual.php?aKepemilikan='+document.getElementById('kepemilikan_id').value+'&aHarga='+document.getElementById('kepemilikan_id').value+'&idunit=<?php echo $idunit; ?>&aKeyword='+keywords+'&no='+i , 'divobat', '', 'GET' );
			}
			if (document.getElementById('divobat').style.display=='none') fSetPosisi(document.getElementById('divobat'),par);
			document.getElementById('divobat').style.display='block';
		}
	}
}

function suggest1(e,par,ap){
var keywords=par.value;//alert(keywords);
	//alert(par);
  //alert(jmlRow+'-'+i);
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
			//alert(key);
			if (key==38 || key==40){
				var tblRow=document.getElementById('tblPasien').rows.length;
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
				Request('../transaksi/pasienlist.php?aKeyword='+keywords, 'divpasien', '', 'GET' );
			}else if (ap==2){
				Request('../transaksi/pasienlist.php?aKeyword='+keywords+'&aPar=ok', 'divpasien', '', 'GET' );
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
						Request('../transaksi/pasienlist.php?aKeyword='+keywords, 'divpasien', '', 'GET' );
					}else if (ap==2){
						Request('../transaksi/pasienlist.php?aKeyword='+keywords+'&aPar=ok', 'divpasien', '', 'GET' );
					}
				}
			}
		}
	}else if (key==38 || key==40){
		var tblRow=document.getElementById('tblPasien').rows.length;
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
	}
}

function fSubmit(){
var cdata='';
var ctemp;
var sx1,sx2,sx3,sx4,sx5,sx6;
	document.forms[0].kepemilikan_id.disabled=false;
	document.forms[0].kso_id.disabled=false;
	document.forms[0].ruangan.disabled=false;
	
	if (document.forms[0].obatid.length){
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
			//alert(sx6);
			sx1=document.forms[0].txtHarga[i].value;
			sx2=document.forms[0].txtSubTot[i].value;
			sx3=document.forms[0].subtotal.value;
			sx4=document.forms[0].tot_harga.value;
			sx5=document.forms[0].txtHargaNetto[i].value;
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
	document.forms[0].fdata.value=cdata;
	if (confirm('Apakah Data Sudah Benar?')){
		document.forms[0].submit();
	}
}

function fSetBatalFr(){
  var tbl = document.getElementById('tblJual');
  var jmlRow = tbl.rows.length;
  //alert(jmlRow);
  if (jmlRow > 4){
	  for (var i=jmlRow;i>4;i--){
		tbl.deleteRow(i-1);
	  }
  }
	document.form1.txtObat.focus();
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
	document.form1.tot_harga.value=FormatNumberFloor(cStot,".");
	
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
	
	t=parseFloat(r)-parseFloat(s);
	document.forms[0].bayar.value=FormatNumberFloor(parseInt(r),".");
	document.forms[0].kembali.value=FormatNumberFloor(t,".");
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
  el.size = 63;
  el.className = 'txtinput';

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
	el.setAttribute('autocomplete', "off");
  }else{
  	el = document.createElement('<input name="txtJml" onKeyUp="AddRow(event,this)" autocomplete="off" />');
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
  //if (i>2){
	  tbl.deleteRow(i);
	  var lastRow = tbl.rows.length;
	  for (var i=3;i<lastRow;i++){
		var tds = tbl.rows[i].getElementsByTagName('td');
		tds[0].innerHTML=i-2;
	  }
	  HitungTot();
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
	f=parseFloat(cdata[4])+((parseFloat(cdata[4])-parseFloat(cdata[9])) * parseFloat(document.forms[0].cara_bayar.options[document.forms[0].cara_bayar.options.selectedIndex].lang)/100);
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
		//document.forms[0].txtHarga[(cdata[0]*1)-1].value=FormatNum(f,2);
		document.forms[0].txtHargaNetto[(cdata[0]*1)-1].value=FormatNumberFloor(parseInt(cdata[9]),".");
		document.forms[0].txtHarga[(cdata[0]*1)-1].value=FormatNumberFloor(parseInt(f),".");
		document.forms[0].txtJml[(cdata[0]*1)-1].focus();
	}
	//tds[2].innerHTML=cdata[3];
	tds[3].innerHTML=cdata[5];

	document.getElementById('divobat').style.display='none';
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
		document.forms[0].dokter.value=cdata[4];
		document.forms[0].no_kunj.value=cdata[2];
		document.forms[0].NoResep.focus();
		//alert(cdata[3]);
		//alert(cdata[5]);
		for (var i=0;i<document.forms[0].kso_id.length;i++){
			//alert(document.forms[0].kso_id.options[i].id);
			if (document.forms[0].kso_id.options[i].id==cdata[3]){
				//alert("ketemu");
				x=document.forms[0].kso_id.options[i].lang;
				document.forms[0].kso_id.options[i].selected=true;
				//alert(x+' - '+document.forms[0].kepemilikan_id.value);
				if ((document.forms[0].kepemilikan_id.value!=x)&&(document.forms[0].obatid.length)){
					window.location='?f=../transaksi/konsulBilling.php&idpel=<?php echo $_REQUEST['idpel']; ?>';
				}else{
					if (i==0){
						fSetValue(window,'kepemilikan_id*-*'+x+'*|*cara_bayar*-*1');
					}else{
						fSetValue(window,'kepemilikan_id*-*'+x+'*|*cara_bayar*-*2');
					}
				}
			}
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
	src="../theme/dsgrid_sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div id="divobat" align="left" style="position:absolute; z-index:1; left: 100px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
<div id="divpasien" align="left" style="position:absolute; z-index:1; left: 200px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
<div align="center">
	<form name="form1" method="post" action="">
        <input name="act" id="act" type="hidden" value="save">
        <input name="fdata" id="fdata" type="hidden" value="">
        <input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
        <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
        <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
        <div id="input" style="display:<?php echo $displayInput; ?>" align="center">
        <table width="99%" border="0">
            <tr>
                <td>
                <div align="center">
                <table width="75%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
                  <tr> 
                    <td width="121">Tanggal&nbsp; </td>
                    <td width="259"><input name="tgltrans" type="text" id="tgltrans" size="11" maxlength="10" value="<?php echo $tgl;?>" class="txtcenter" readonly="true" />
                      <input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" <?php echo $DisableBD; ?> onClick="gfPop.fPopCalendar(this.form.tgltrans,depRange);" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shift <input name="shft" type="text" id="shft" size="2" maxlength="1" value="<?php echo $shft;?>" class="txtcenter" readonly="true" /></td>
                    <td width="98">No. Kwitansi</td>
                    <td width="232"><input name="nokw" type="text" id="nokw" size="6" maxlength="6" value="<?php echo $nokw;?>" class="txtinput" readonly="true" /></td>
                  </tr>
                  <tr> 
                    <td>Nama Pasien</td>
                    <td><input name="nm_pasien" type="text" id="nm_pasien" readonly="readonly" class="txtinput" size="35" value="<?php echo $data['nama_pasien']; ?>" onKeyUp="cari(event,this,1);" autocomplete="off" tabindex="0"></td>
                    <td>Alamat</td>
                    <td><input name="txtalamat" type="text" id="txtalamat" class="txtinput" size="40" value="<?php echo $data['alamat']; ?>"></td>
                  </tr>
                  <tr> 
                    <td>No Rekam Medis</td>
                    <td><input name="NoRM" type="text" id="NoRM" readonly="readonly" class="txtinput" size="15" value="<?php echo $data['no_rm']; ?>" onKeyUp="cari(event,this,2);" autocomplete="off"> 
                    </td>
                    <td>No. Resep</td>
                    <td><input name="NoResep" type="text" id="NoResep" class="txtinput" size="15" value="" onKeyDown="SetFocus1(event,this,'NoRM|||kepemilikan_id');" autocomplete="off"></td>
                  </tr>
                  <tr> 
                    <td>No. Kunjungan</td>
                    <td><input name="no_kunj" type="text" id="no_kunj" readonly="readonly" class="txtinput" size="25" value="<?php echo $data['id']; ?>" onKeyDown="SetFocus1(event,this,'|NoRM|kepemilikan_id|dokter');" ></td>
                    <td>Jenis Pasien</td>
                    <td><select name="kepemilikan_id" id="kepemilikan_id" class="txtinput" onChange="location='?f=../transaksi/konsulBilling.php&idpel=<?php echo $_REQUEST['idpel']; ?>&kepemilikan_id='+this.value">
                        <?
                          $qry="Select * from a_kepemilikan where aktif=1";
                          $exe=mysqli_query($konek,$qry);
                          while($show=mysqli_fetch_array($exe)){ 
                        ?>
                        <option value="<?=$show['ID'];?>" class="txtinput"<?php if ($kepemilikan_id==$show['ID']) echo " selected";?>> 
                        <?=$show['NAMA'];?>
                        </option>
                        <? }?>
                      </select></td>
                  </tr>
                  <tr> 
                    <td>Dokter</td>
                    <td><input name="dokter" type="text" id="dokter" value="<?php echo $data['nama_dokter']; ?>" class="txtinput" size="35" autocomplete="off" onKeyUp="suggest1(event,this,2);" ></td>
                    <td>Ruangan</td>
                    <td><select name="ruangan" id="ruangan" class="txtinput" disabled="disabled" onChange="">
                        <option value="0" class="txtinput">Pilih Ruangan</option>
                        <?php
                          $qry="select * from a_unit where UNIT_TIPE=3 AND UNIT_ISAKTIF=1 order by UNIT_ID";
                          $exe=mysqli_query($konek,$qry);
                          while($show=mysqli_fetch_array($exe)){ 
                        ?>
                        <option value="<?php echo $show['UNIT_ID']; ?>" class="txtinput" lang="<?php echo $show['unit_billing']; ?>"<?php if ($ruangan==$show['unit_billing']) echo ' selected="selected"';?>><?php echo $show['UNIT_NAME']; ?></option>
                        <?php }?>
                      </select></td>
                  </tr>
                  <tr> 
                    <td>KSO / Mitra</td>
                    <td><select name="kso_id" id="kso_id" class="txtinput" disabled="disabled" onChange="fSelChange(this);">
                        <option value="2" lang="1" id="NON" class="txtinput"<?php if ($kso_id==2) echo "selected";?>>UMUM</option>
                        <?php
                          $qry="select * from a_mitra where idmitra<>2 and aktif=1 order by nama";
                          $exe=mysqli_query($konek,$qry);
                          while($show=mysqli_fetch_array($exe)){ 
                        ?>
                        <option value="<?php echo $show['IDMITRA']; ?>" lang="<?php echo $show['KEPEMILIKAN_ID']; ?>" id="<?php echo $show['KODE_MITRA']; ?>" class="txtinput"<?php if ($kso_id==$show['kso_id_billing']) echo " selected";?>><?php echo $show['NAMA']; ?></option>
                        <?php }?>
                      </select></td>
                    <td>Cara Bayar</td>
                    <td><select name="cara_bayar" id="cara_bayar" class="txtinput">
                        <?php
                          $qry="Select * from a_cara_bayar where aktif=1";
                          $exe=mysqli_query($konek,$qry);
                          while($show=mysqli_fetch_array($exe)){ 
                        ?>
                        <option value="<?php echo $show['id'];?>" class="txtinput" lang="<?php echo $show['biaya'];?>"<?php if ($cara_bayar==$show['id']) echo " selected";?>> 
                        <?php echo $show['nama'];?>
                        </option>
                        <?php }?>
                      </select></td>
                  </tr>
                </table>
                </div>
                  <table id="tblJual" width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
                    <tr> 
                      <td colspan="9" align="center" class="jdltable"><hr></td>
                    </tr>
                    <tr> 
                      <td colspan="8" align="center" class="jdltable">DAFTAR PENJUALAN</td>
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
                      <td class="tdisi" align="left"><input name="obatid" type="hidden" value="">
                        <input name="kpid" type="hidden" value=""> 
                        <input type="text" name="txtObat" id="txtObat" class="txtinput" size="63" onKeyUp="suggest(event,this);" autocomplete="off" /></td>
                      <td class="tdisi" width="80"><input type="checkbox" name="racik" id="racik" /></td>
                      <td class="tdisi">-</td>
                      <td class="tdisi"><input type="text" name="txtHargaNetto" class="txtright" readonly="true" size="14" /></td>
                      <td class="tdisi" width="30"><input type="text" name="txtJml" id="txtJml" class="txtcenter" size="4" onKeyUp="AddRow(event,this)" autocomplete="off" /></td>
                      <td class="tdisi" width="50"><input type="text" name="txtHarga" class="txtright" readonly="true" size="14" /></td>
                      <td class="tdisi" width="70"><input type="text" name="txtSubTot" class="txtright" readonly="true" size="17" /></td>
                      <td class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){removeRowFromTable(this);}"></td>
                    </tr>
                  </table>
                <table width="99%" border="0" cellpadding="0" cellspacing="0" align="center" class="txtinput">
                  <input name="subtotal" type="hidden" id="subtotal" size="12" value="0" class="txtright" readonly="true" />
                  <input name="embalage" type="hidden" id="embalage" size="12" value="0" class="txtright" onKeyUp="HitungTot()" />
                  <input name="jasa_resep" type="hidden" id="jasa_resep" size="12" value="0" class="txtright" onKeyUp="HitungTot()" />
                  <tr> 
                    <td width="718">&nbsp;</td>
                    <td width="97">TOTAL HARGA</td>
                    <td> 
                      <input name="tot_harga" type="text" id="tot_harga" size="17" value="0" class="txtright" readonly="true" />
                    </td>
                  </tr>
                  <tr> 
                    <td>&nbsp;</td>
                    <td>BAYAR</td>
                    <td><input name="bayar" type="text" id="bayar" size="17" value="0" class="txtright" onKeyUp="fBayar();" /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>KEMBALI</td>
                    <td><input name="kembali" type="text" id="kembali" size="17" value="0" class="txtright" readonly="true" /></td>
                  </tr>
                </table>
                <br><div align="center"><p align="center"><BUTTON type="button" style="cursor:pointer" onClick="if (ValidateForm('tgltrans,shft,nokw,nm_pasien','ind')){fSubmit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>
                      <!--a class="navText" href="../report/kwi_retur.php?no_penjualan=<?php echo $nokwPrint;?>&sunit=<?php echo $idunit; ?>&no_pasien=<?php echo $NoRM; ?>&tgl=<?php echo $tgltrans; ?>" onClick="NewWindow(this.href,'name','560','500','yes');return false"> 
                      <BUTTON  type="button" <?php  if($act<>'save') echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak 
                      Penjualan</BUTTON>
                      </a-->
                       <BUTTON type="button" style="cursor:pointer" onClick="fSetBatalFr();window.location='../apotik/main.php?f=../transaksi/konsulBilling.php'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
                      </p></div>
                </td>
            </tr>
        </table>
        </div>
        <div align="center" style="display:<?php echo $displayData; ?>" id="div_data">
        <input type="hidden" id="id_pel" name="id_pel"  />
            <table width="950" border="0" cellpadding="0" cellspacing="0" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">
                <tr>
                    <td height="30">&nbsp;</td>
                </tr>
                <tr>
                    <td height="50">Status Dilayani: 
                    <select id="cmbDilayani" class="txtinput" onchange="ubahTgl()">
                        <option value="0" selected="selected">BELUM</option>
                        <option value="1">SUDAH</option>
                        <option value="">SEMUA</option>
                    </select>&nbsp;&nbsp;&nbsp;Tanggal&nbsp;
                    <input name="txtTgl" type="text" id="txtTgl" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl?>" /> 
              <input type="button" name="btnTgl" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange,ubahTgl);" /><div style="width:500; float:right; vertical-align:top" align="right"><button type="button" id="cross" name="cross" style="cursor:pointer" onClick="window.location='../apotik/main.php?f=../transaksi/konsulBilling.php&idpel='+document.getElementById('id_pel').value" disabled="disabled"><img src="../icon/article.gif" width="20" align="absmiddle"/>&nbsp;Pelayanan Resep</button><!--a class="navText" href="../report/kwi_retur.php?no_penjualan=<?php echo $nokwPrint;?>&sunit=<?php echo $idunit; ?>&no_pasien=<?php echo $NoRM; ?>&tgl=<?php echo $tgltrans; ?>" onClick="NewWindow(this.href,'name','560','500','yes');return false"--> 
		  <BUTTON id="btnCetakKw" type="button" onclick="CetakKw();" <?php if($act<>'save') echo "disabled='disabled'"; ?>><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Cetak 
          Penjualan</BUTTON>
          <!--/a--></div></td>
                </tr>
                <tr>
                    <td align="center">
                    <div id="gridbox" style="width:950px; height:300px; background-color:white;"></div>
                    <div id="paging" style="width:950px;"></div>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>
	</form>
</div>
<script>
	var url,cnokwPrint,cNoRM,ctgltrans;
	function CetakKw(){
		if (document.getElementById('cmbDilayani').value==0){
			cnokwPrint="<?php echo $nokwPrint;?>";
			cNoRM="<?php echo $NoRM;?>";
			ctgltrans="<?php echo $tgltrans;?>";
		}
		url="../report/kwi_retur.php?no_penjualan="+cnokwPrint+"&sunit=<?php echo $idunit; ?>&no_pasien="+cNoRM+"&tgl="+ctgltrans;
		NewWindow(url,'name','560','500','yes');
	}

	function ubahTgl(){
		if (document.getElementById('cmbDilayani').value==0){
			document.getElementById('btnCetakKw').style.display="inline-table";
		}else{
			document.getElementById('btnCetakKw').style.display="none";
		}
		//alert("../transaksi/konsulBilling_utils.php?grd=true&tanggal="+document.getElementById('txtTgl').value+"&status="+document.getElementById('cmbDilayani').value+"&idunitBilling=<?php echo $idunitBilling; ?>");
		r.loadURL("../transaksi/konsulBilling_utils.php?grd=true&tanggal="+document.getElementById('txtTgl').value+"&status="+document.getElementById('cmbDilayani').value+"&idunitBilling=<?php echo $idunitBilling; ?>","","GET");
	}
	
	function ambilData(){
		//var no_resep = r.cellsGetValue(r.getSelRow(),2);
		//alert(r.getMaxRow()+' - '+r.getMaxPage());
		if (r.getMaxPage()>0){
			var sisip = r.getRowId(r.getSelRow()).split('|');
			document.getElementById('id_pel').value = sisip[0];
			//alert(document.getElementById('id_pel').value);
			document.getElementById('cross').disabled = false;
			
			/*if (document.getElementById('cmbDilayani').value!=0){
				cnokwPrint='';
				cNoRM='';
				ctgltrans='';
			}*/
		}else{
			document.getElementById('cross').disabled = true;
		}
	}
	
	function tampil(){
		var data = document.getElementById('spanSuk').innerHTML.split('<?php echo '0'.chr(5);?>');
		//alert(data[0]);
		document.getElementById('spanSuk').innerHTML = data[0];
		setTimeout(document.getElementById('spanSuk').innerHTML,'1000');
	}
	
	function goFilterAndSort(grd){
	var url;
		//alert(grd);
		if (grd=="gridbox"){
			url="../transaksi/konsulBilling_utils.php?grd=true&tanggal="+document.getElementById('txtTgl').value+"&status="+document.getElementById('cmbDilayani').value+"&idunitBilling=<?php echo $idunitBilling; ?>"+"&filter="+r.getFilter()+"&sorting="+r.getSorting()+"&page="+r.getPage();
			//alert(url);
			r.loadURL(url,"","GET");
		}
	}
	
	var fReload;
	function AutoReload(){
		goFilterAndSort("gridbox");
		fReload=setTimeout("AutoReload()",120000);
	}
	
	function pelayananResep(){
		window.location='../apotik/main.php?f=../transaksi/konsulBilling.php&idpel='+document.getElementById('id_pel').value;
	}
	
	r=new DSGridObject("gridbox");
	r.setHeader("DATA PASIEN");
	r.setColHeader("NO,NO RM,NAMA PASIEN,TEMPAT LAYANAN,KEPEMILIKAN,PENJAMIN PASIEN,DOKTER");
	r.setIDColHeader(",no_rm,nama_pasien,nama_unit,,,");
	r.setColWidth("30,80,200,150,90,180,200");
	r.setCellAlign("center,center,left,center,center,center,left");
	r.setCellType("txt,txt,txt,txt,txt,txt,txt");
	r.setCellHeight(20);
	r.setImgPath("../icon");
	r.setIDPaging("paging");
	r.attachEvent("onRowClick","ambilData");
	r.attachEvent("onRowDblClick","pelayananResep");
	r.onLoaded(ambilData);
	r.baseURL("../transaksi/konsulBilling_utils.php?grd=true&tanggal="+document.getElementById('txtTgl').value+"&status="+document.getElementById('cmbDilayani').value+"&idunitBilling=<?php echo $idunitBilling; ?>");
	r.Init();
	
	fReload=setTimeout("AutoReload()",120000);
</script>
<script>
	document.forms[0].NoResep.focus();
	
	//document.getElementById('kso_id').value = <?php echo $data['id_kso']; ?>;
	//document.getElementById('kepemilikan_id').value = <?php echo $kepemilikan_id; ?>;
	//document.getElementById('ruangan').value = <?php echo $data['id_unit']; ?>;
	//document.getElementById('cara_bayar').value = <?php echo $data['id_kso']; ?>;
	
function fSelChange(obj){
	//alert(obj.options[obj.options.selectedIndex].id);
	//alert(obj.options[obj.options.selectedIndex].lang);
	if (document.forms[0].obatid.length){
		//fSetValue(window,'kepemilikan_id*-*'+obj.options[obj.options.selectedIndex].lang);
		window.location="?f=../transaksi/konsulBilling.php&idpel=<?php echo $_REQUEST['idpel']; ?>";
	}else{
		if (obj.value=="2"){
			fSetValue(window,'kepemilikan_id*-*'+obj.options[obj.options.selectedIndex].lang+'*|*cara_bayar*-*1');
		}else{
			fSetValue(window,'kepemilikan_id*-*'+obj.options[obj.options.selectedIndex].lang+'*|*cara_bayar*-*2');
		}
	}
}

//fSelChange(document.getElementById('kso_id'));
</script>
<?php 
mysqli_close($konek);
?>