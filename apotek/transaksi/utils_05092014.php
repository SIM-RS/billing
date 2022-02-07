<?php
//include("../sesi.php");
include("../koneksi/konek.php");
$grd = $_REQUEST["grd"];
$grdDet = $_REQUEST['grdDet'];
$idunit = $_REQUEST['idunit'];
$idpel = $_REQUEST['idpel'];
$idunitRujuk = $_REQUEST['idunitRujuk'];
$newIdCarabayar = $_REQUEST['newIdCarabayar'];
$newIdKepemilikan = $_REQUEST['newIdKepemilikan'];
$iduser = $_REQUEST['iduser'];
$shft = $_REQUEST['shift'];
$val="";
$th=explode("-",$_REQUEST['tanggal']);
$tgl2="$th[2]-$th[1]-$th[0]";
$idResep = $_REQUEST['resepId'];
$setBulan = $_REQUEST['setBulan'];
$bulan = $_REQUEST['bulan'];
$tahun = $_REQUEST['tahun'];

$txtH = $_REQUEST['txtH'];
$txtT = $_REQUEST['txtT'];
$txtK = $_REQUEST['txtK'];
$txtP = $_REQUEST['txtP'];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort=" gab.id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//$res;
//===============================


if($_REQUEST['cek']=='true'){
	$que = "select 
	DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(mp.tgl_lahir, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(mp.tgl_lahir, '00-%m-%d')) umur,
	DATE_FORMAT(mp.tgl_lahir, '%d-%m-%Y') tgl_lahir,mp.no_rm,mp.no_ktp,mp.telp,mp.sex,mp.nama,
	CONCAT((CONCAT((CONCAT((CONCAT(mp.alamat,' RT.',mp.rt)),' RW.',mp.rw)),', Desa ',w.nama)),', Kecamatan ',wi.nama,', ',wii.nama) alamat_
	from $dbbilling.b_ms_pasien mp
	LEFT JOIN $dbbilling.b_ms_wilayah w ON mp.desa_id = w.id
	LEFT JOIN $dbbilling.b_ms_wilayah wi ON mp.kec_id = wi.id
	LEFT JOIN $dbbilling.b_ms_wilayah wii ON mp.kab_id = wii.id
	 where mp.id='".$_REQUEST['id_patient']."'";
	$queLab = mysqli_fetch_array(mysqli_query($konek,$que));
	//echo $que;							
?>
<script>
	//jQuery("#namapatient").val("<?php echo $queLab['nama'];?>");
	document.getElementById('namapatient').value="<?php echo $queLab['nama'];?>";
	//jQuery("#btnIsiDataRM19").show();
</script>
<?php
}


switch(strtolower($_REQUEST['act']))
{
  case 'tambah':
	$res="";
	$sqlTambah = "UPDATE $dbbilling.b_resep SET status = '1' WHERE id = '".$_REQUEST['idRes']."'";
	//echo $sqlTambah."<br>";
	$rs=mysqli_query($konek,$sqlTambah);
	if (mysqli_errno($konek)>0){
		$res="gagal";
	}
	echo $res;
	return;
  break;
  case 'editobat':
  	$fdata = explode("|",$_REQUEST['fdata']);
	$sql = "SELECT *,CURDATE() tgltrans,NOW() tgl_act FROM $dbbilling.b_resep WHERE id = '".$fdata[0]."'";
	//echo $sql."<br>";
	$rs=mysqli_query($konek,$sql);
	$rw=mysqli_fetch_array($rs);
	$no_penjualan=$rw["no_resep"];
	$tqty=$rw["qty"];
	$tgltrans=$rw["tgltrans"];
	$tglact=$rw["tgl_act"];
	if ($rw["kepemilikan_id"]!=$fdata[2]){
		$sql="call gd_mutasi($idunit,$idunit,0,'$no_penjualan',$fdata[1],$fdata[2],".$rw["kepemilikan_id"].",$tqty,2,$iduser,1,'$tgltrans','$tglact')";
		//echo $sql."<br>";
		$rs1=mysqli_query($konek,$sql);
	}
	$sql = "UPDATE $dbbilling.b_resep SET obat_id=$fdata[1],harga_netto=$fdata[3],harga_satuan=$fdata[4] WHERE id = '".$fdata[0]."'";
	//echo $sql."<br>";
	$rs=mysqli_query($konek,$sql);
  break;
  case 'kirimunit':
 	$sql = "UPDATE $dbbilling.b_resep SET apotek_id=$idunitRujuk WHERE no_resep = '".$_REQUEST['no_resep']."' AND no_rm='".$_REQUEST['no_rm']."' AND id_pelayanan='".$_REQUEST['IdPel']."' AND status < '2'";
	//echo $sql."<br>";
	$rs=mysqli_query($konek,$sql);
  break;
  case 'ubahcarabayar':
 	$sql = "UPDATE $dbbilling.b_resep SET cara_bayar=$newIdCarabayar WHERE no_resep = '".$_REQUEST['no_resep']."' AND no_rm='".$_REQUEST['no_rm']."' AND id_pelayanan='".$_REQUEST['IdPel']."' AND status < '2'";
	//echo $sql."<br>";
	$rs=mysqli_query($konek,$sql);
  break;
  case 'simpan':
  	$no_kunj = $_REQUEST['idPel'];
	$NoRM = $_REQUEST['no_rm'];
	$NoResep = $_REQUEST['no_resep'];
	$subtotal = $_REQUEST['subtotal'];
	$sql="SELECT DISTINCT r.no_resep,r.no_rm,IFNULL(m.IDMITRA,2) kso_id,r.cara_bayar,r.kepemilikan_id,r.dokter_nama,
			r.nama_pasien,r.alamat,u.unit_billing,IFNULL(u.UNIT_ID,0) UNIT_ID,CURDATE() tgl,NOW() tgl_act 
			FROM $dbbilling.b_resep r INNER JOIN $dbbilling.b_pelayanan p ON r.id_pelayanan=p.id
			LEFT JOIN $dbapotek.a_unit u ON p.unit_id=u.unit_billing
			LEFT JOIN $dbapotek.a_mitra m ON r.kso_id=m.kso_id_billing 
			WHERE r.apotek_id=$idunit AND r.id_pelayanan=$no_kunj AND r.no_rm='$NoRM' 
			AND r.no_resep='$NoResep' AND r.tgl='$tgl2' AND u.UNIT_ISAKTIF=1";
	//echo $sql."<br>";
	$rs1=mysqli_query($konek,$sql);
	$rw1=mysqli_fetch_array($rs1);
	$kso_id=$rw1["kso_id"];
	$kso=1;
	//if ($kso_id<>2) $kso=1;
	$kp_id=$rw1["kepemilikan_id"];
	$tgltrans=$rw1["tgl"];
	$tgl_act=$rw1["tgl_act"];
	$artgl_act=explode("-",$tgltrans);
	$cara_bayar=$rw1["cara_bayar"];
	$nm_pasien=str_replace("'","''",$rw1["nama_pasien"]);
	$nm_pasien=str_replace('"','""',$nm_pasien);
	$txtalamat=str_replace("'","''",$rw1["alamat"]);
	$txtalamat=str_replace('"','""',$txtalamat);
	$ruangan=$rw1["UNIT_ID"];
	$dokter=str_replace("'","''",$rw1["dokter_nama"]);
	$dokter=str_replace('"','""',$dokter);
	
	$embalage=0;
	$jasa_resep=0;
	$tot_harga=$subtotal+$embalage+$jasa_resep;
	$nutang=0;
	$biaya_retur=0;
			
	//$sql="select MAX(NO_PENJUALAN) AS NO_PENJUALAN from a_penjualan where UNIT_ID=$idunit and YEAR(TGL)=$thtr";
	$nokw="000001";
	$cekNo = "select MAX(CAST(NO_PENJUALAN AS SIGNED)) NO_PENJUALAN from a_no_penjualan_log where unit_id=$idunit and tahun=$artgl_act[0]"; //order by id DESC limit 1
	$qcekNo = mysqli_query($konek,$cekNo);
	$dcekNo = mysqli_fetch_array($qcekNo);
	//echo mysqli_num_rows($qcekNo);
	//if(mysqli_num_rows($qcekNo)>0){	
		//$rs=mysqli_query($konek,$cekNo);
	//} else {
	$sql="select NO_PENJUALAN from $dbapotek.a_penjualan where UNIT_ID=$idunit and YEAR(TGL)=$artgl_act[0] ORDER BY ID DESC LIMIT 1";
	//echo $sql."<br>";
	$rs=mysqli_query($konek,$sql);
	//}
	//$no_kunj="0";
	//$shft=1;
	$rows=mysqli_fetch_array($rs);
	if(!empty($dcekNo['NO_PENJUALAN'])){
		if(((int)$dcekNo['NO_PENJUALAN']) > ((int)$rows['NO_PENJUALAN'])){
			$nokw=(int)$dcekNo["NO_PENJUALAN"]+1;
		} else if(((int)$dcekNo['NO_PENJUALAN']) < ((int)$rows['NO_PENJUALAN'])){
			$nokw=(int)$rows["NO_PENJUALAN"]+1;
		} else {
			$nokw=(int)$dcekNo["NO_PENJUALAN"]+1;
		}
	} else {
		$nokw=(int)$rows["NO_PENJUALAN"]+1;
	}
	/* if ($rows=mysqli_fetch_array($rs)){
		//$shft=$rows["SHIFT"];
		$nokw=(int)$rows["NO_PENJUALAN"]+1; */
		$nokwstr=(string)$nokw;
		if (strlen($nokwstr)<6){
			for ($i=0;$i<(6-strlen($nokwstr));$i++) $nokw="0".$nokw;
		}else{
			$nokw=$nokwstr;
		}
		$updateNO = "insert into a_no_penjualan_log(NO_PENJUALAN,unit_id,tahun) value('{$nokw}','$idunit','$artgl_act[0]')";
		mysqli_query($konek,$updateNO) or die (mysqli_error($konek));
	//}
	
	$no_penjualan=$nokw;
	$nokwPrint=$no_penjualan;
	//echo "no_kw=".$no_penjualan."<br>";

	$val=$no_penjualan."|".$NoRM."|".$tgltrans;

	$fdata = $_REQUEST['fdata'];
	$arfdata=explode("*|*",$fdata);
	$berha = 0;
	for ($j=0;$j<count($arfdata);$j++){
			$data=explode("|",$arfdata[$j]);
			//print_r($data);
			/*$sqlTambah = "UPDATE $dbbilling.b_resep SET status = '2' WHERE id = '".$data[0]."'";
			//echo $sqlTambah."<br>";
			$rs=mysqli_query($konek,$sqlTambah);
			if (mysqli_errno($konek)==0){*/
			$hSatuan=$data[1];
			$hNetto=$data[2];
			$qty=$data[3];
			$obat_id=$data[5];
			$isRacikan=$data[6];
			
			$sql="select * from $dbbilling.b_resep WHERE id = '".$data[0]."'";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			$rw=mysqli_fetch_array($rs);
			$ketDosis=str_replace("'","''",$rw["ket_dosis"]);
			$ketDosis=str_replace('"','""',$ketDosis);
			//die(mysqli_error($konek));
			if($kp_id!=$data[4]){
				$sql="call gd_mutasi($idunit,$idunit,0,'$no_penjualan',$obat_id,$data[4],$kp_id,$qty,2,$iduser,1,'$tgltrans','$tgl_act')";
				//echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
			}

			$sql="select SQL_NO_CACHE * from a_penerimaan ap where OBAT_ID=".$obat_id." and UNIT_ID_TERIMA=$idunit and KEPEMILIKAN_ID=".$kp_id." and QTY_STOK>0 and ap.STATUS=1 order by TANGGAL,ID";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql) or die(mysqli_error($konek));
			$done="false";
			$jml=$qty;
			//$success=1;
			$cid=0;
			$tglJualFix = 'NOW()';
			if($_REQUEST['tglJual'] != ''){
				$tglJual = explode('-',$_REQUEST['tglJual']);
				$tgltrans = $tglJual[2].'-'.$tglJual[1].'-'.$tglJual[0];
				$jamNow=gmdate('H:i:s',mktime(date('H')+7));
				//$tglJualFix = "'".$tglJual[2].'-'.$tglJual[1].'-'.$tglJual[0].' '.$jamNow."'";
			}
			//echo "Jenis_Pasien=".$kp_id."<br>";
			$idInsert = array();
			while (($rows=mysqli_fetch_array($rs))&&($done=="false"))
			{
				$cstok=$rows['QTY_STOK'];
				$cid=$rows['ID'];
				if ($cstok>=$jml){
					$done="true";
					$sql="update $dbapotek.a_penerimaan set QTY_STOK=QTY_STOK-$jml where ID=$cid";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
					$sql="insert into $dbapotek.a_penjualan(PENERIMAAN_ID,UNIT_ID,USER_ID,JENIS_PASIEN_ID,KSO,KSO_ID,TGL,TGL_ACT,NO_PENJUALAN,NO_KUNJUNGAN,NO_PASIEN,NO_RESEP,DOKTER,RUANGAN,SHIFT,CARA_BAYAR,QTY_JUAL,QTY,BIAYA_RETUR,HARGA_NETTO,HARGA_SATUAN,SUB_TOTAL,SUM_SUB_TOTAL,EMBALAGE,JASA_RESEP,HARGA_TOTAL,KET_DOSIS,STATUS,NAMA_PASIEN,ALAMAT,UTANG,RACIKAN,textH,textT,textK,textP) values
					($cid,$idunit,$iduser,$kp_id,$kso,$kso_id,'$tgltrans',$tglJualFix,'$no_penjualan','$no_kunj','$NoRM','$NoResep','$dokter','$ruangan',$shft,$cara_bayar,$jml,$jml,$biaya_retur,$hNetto,$hSatuan,$jml*$hSatuan,$subtotal,$embalage,$jasa_resep,$tot_harga,'$ketDosis',1,'$nm_pasien','$txtalamat',$nutang,$isRacikan,'$txtH','$txtT','$txtK','$txtP')";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
					$idInsert[]=mysql_insert_id();
					if (mysqli_errno($konek)>0){
						$success=0;
						$sql="update $dbapotek.a_penerimaan set QTY_STOK=QTY_STOK+$jml where ID=$cid";
						//echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);
					} else {
						$success=1;
					}
				}else{
					$jml=$jml-$cstok;
					$sql="update $dbapotek.a_penerimaan set QTY_STOK=0 where ID=$cid";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
					$sql="insert into $dbapotek.a_penjualan(PENERIMAAN_ID,UNIT_ID,USER_ID,JENIS_PASIEN_ID,KSO,KSO_ID,TGL,TGL_ACT,NO_PENJUALAN,NO_KUNJUNGAN,NO_PASIEN,NO_RESEP,DOKTER,RUANGAN,SHIFT,CARA_BAYAR,QTY_JUAL,QTY,BIAYA_RETUR,HARGA_NETTO,HARGA_SATUAN,SUB_TOTAL,SUM_SUB_TOTAL,EMBALAGE,JASA_RESEP,HARGA_TOTAL,KET_DOSIS,STATUS,NAMA_PASIEN,ALAMAT,UTANG,RACIKAN,textH,textT,textK,textP) values
					($cid,$idunit,$iduser,$kp_id,$kso,$kso_id,'$tgltrans',$tglJualFix,'$no_penjualan','$no_kunj','$NoRM','$NoResep','$dokter','$ruangan',$shft,$cara_bayar,$cstok,$cstok,$biaya_retur,$hNetto,$hSatuan,$cstok*$hSatuan,$subtotal,$embalage,$jasa_resep,$tot_harga,'$ketDosis',1,'$nm_pasien','$txtalamat',$nutang,$isRacikan,'$txtH','$txtT','$txtK','$txtP')";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
					$idInsert[]=mysql_insert_id();
					if (mysqli_errno($konek)>0){
						$success=0;
						$sql="update $dbapotek.a_penerimaan set QTY_STOK=QTY_STOK+$cstok where ID=$cid";
						//echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);
					} else {
						$success=1;
					}
				}
			}
			
			if ($success==1){
				$sqlTambah = "SELECT ID FROM $dbapotek.a_penjualan WHERE USER_ID=$iduser AND UNIT_ID=$idunit AND PENERIMAAN_ID=$cid";
				//echo $sqlTambah."<br>";
				$rs1=mysqli_query($konek,$sqlTambah);
				$rw1=mysqli_fetch_array($rs1);
				$IdPenjualan=$idInsert[0];//$rw1['ID'];
				$sqlTambah = "UPDATE $dbbilling.b_resep SET status = '2', penjualan_id='$IdPenjualan' WHERE id = '".$data[0]."'";
				//echo $sqlTambah."<br>";
				$rs1=mysqli_query($konek,$sqlTambah);
				$berha += 1;
				$success = 0;
			}
			
			$idInsert = array();
		//}
	}
	if($berha > 0){
		echo "Resep Berhasil Disimpan";
	} else {
		die(mysqli_error($konek));
	}
  break;
  case 'hapus':
  $sqlHapus="UPDATE $dbbilling.b_resep SET status = '0' WHERE id = '".$_REQUEST['idRes']."'";
  $rs=mysqli_query($konek,$sqlHapus);
  if (mysqli_errno($konek)>0){
  	$res="gagal";
  }
	echo $res;
	return;
  break;   
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
	if($_REQUEST['status'] == "1"){
		$sorting = " gab.nama_pasien";
	}
}

$fSta = "AND $dbbilling.b_resep.status = '2'";
$qpenj=",IFNULL((SELECT NO_PENJUALAN FROM $dbapotek.a_penjualan ap WHERE ap.NO_KUNJUNGAN=$dbbilling.b_resep.id_pelayanan 
AND ap.UNIT_ID='$idunit' AND ap.NO_PASIEN=$dbbilling.b_resep.no_rm AND ap.NO_RESEP=$dbbilling.b_resep.no_resep LIMIT 1),0) n_penj,
(SELECT TGL FROM $dbapotek.a_penjualan ap WHERE ap.NO_KUNJUNGAN=$dbbilling.b_resep.id_pelayanan 
AND ap.UNIT_ID='$idunit' AND ap.NO_PASIEN=$dbbilling.b_resep.no_rm AND ap.NO_RESEP=$dbbilling.b_resep.no_resep LIMIT 1) tgltrans";

$dis=" disabled='disabled'";
$fgroup = ", ap.no_penjualan";
if($_REQUEST['status'] == "0"){
	$fSta = "AND $dbbilling.b_resep.status < '2'";
	$qpenj=",0 n_penj,'' tgltrans";
	$dis="";
	$fgroup = '';
}

if($grd == "true")
{
	/*$sql = "SELECT * FROM (SELECT $dbbilling.b_resep.id,$dbbilling.b_resep.dokter_nama, $dbbilling.b_resep.id_pelayanan, $dbbilling.b_resep.no_resep, $dbbilling.b_resep.no_rm, $dbbilling.b_resep.nama_pasien,$dbbilling.b_ms_unit.nama AS unit, 
$dbapotek.a_kepemilikan.NAMA AS kepemilikan, $dbbilling.b_ms_kso.nama AS kso, $dbapotek.a_cara_bayar.id cara_bayar_id, $dbapotek.a_cara_bayar.nama cara_bayar, $dbapotek.a_kepemilikan.ID AS kepemilikanId".$qpenj."
FROM $dbbilling.b_resep
INNER JOIN $dbapotek.a_kepemilikan ON $dbbilling.b_resep.kepemilikan_id=$dbapotek.a_kepemilikan.ID
INNER JOIN $dbapotek.a_cara_bayar ON $dbbilling.b_resep.cara_bayar=$dbapotek.a_cara_bayar.id
INNER JOIN $dbbilling.b_pelayanan ON $dbbilling.b_resep.id_pelayanan=$dbbilling.b_pelayanan.id
INNER JOIN $dbbilling.b_ms_unit ON $dbbilling.b_ms_unit.id=$dbbilling.b_pelayanan.unit_id
INNER JOIN $dbbilling.b_ms_kso ON $dbbilling.b_ms_kso.id=$dbbilling.b_resep.kso_id
WHERE $dbbilling.b_resep.tgl='$tgl2' AND $dbbilling.b_resep.apotek_id='$idunit' ".$fSta." GROUP BY $dbbilling.b_resep.no_resep,$dbbilling.b_resep.no_rm,$dbbilling.b_resep.cara_bayar,$dbbilling.b_resep.id_pelayanan) AS gab $filter ORDER BY ".$sorting;*/
	/* $sql = "SELECT * FROM (SELECT $dbbilling.b_resep.id,$dbbilling.b_resep.dokter_nama, $dbbilling.b_resep.id_pelayanan, $dbbilling.b_resep.no_resep, $dbbilling.b_resep.no_rm, $dbbilling.b_resep.nama_pasien,$dbbilling.b_ms_unit.nama AS unit, 
$dbapotek.a_kepemilikan.NAMA AS kepemilikan, $dbbilling.b_ms_kso.nama AS kso, $dbapotek.a_cara_bayar.id cara_bayar_id, $dbapotek.a_cara_bayar.nama cara_bayar, $dbapotek.a_kepemilikan.ID AS kepemilikanId".$qpenj.", 
DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(mp.tgl_lahir, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(mp.tgl_lahir, '00-%m-%d')) umur,
DATE_FORMAT(mp.tgl_lahir, '%d-%m-%Y') tgl_lahir,mp.no_ktp,mp.telp,mp.sex,$dbbilling.b_resep.alamat,k.pasien_id,
CONCAT((CONCAT((CONCAT((CONCAT(mp.alamat,' RT.',mp.rt)),' RW.',mp.rw)),', Desa ',w.nama)),', Kecamatan ',wi.nama,', ',wii.nama) alamat_, $dbbilling.b_resep.iter
FROM $dbbilling.b_resep
LEFT JOIN $dbbilling.b_pelayanan p ON $dbbilling.b_resep.id_pelayanan=p.id
INNER JOIN $dbbilling.b_kunjungan k ON p.kunjungan_id=k.id 
INNER JOIN $dbbilling.b_ms_pasien mp ON k.pasien_id=mp.id
LEFT JOIN $dbbilling.b_ms_wilayah w ON mp.desa_id = w.id
LEFT JOIN $dbbilling.b_ms_wilayah wi ON mp.kec_id = wi.id
LEFT JOIN $dbbilling.b_ms_wilayah wii ON mp.kab_id = wii.id
INNER JOIN $dbapotek.a_kepemilikan ON $dbbilling.b_resep.kepemilikan_id=$dbapotek.a_kepemilikan.ID
INNER JOIN $dbapotek.a_cara_bayar ON $dbbilling.b_resep.cara_bayar=$dbapotek.a_cara_bayar.id
INNER JOIN $dbbilling.b_pelayanan ON $dbbilling.b_resep.id_pelayanan=$dbbilling.b_pelayanan.id
INNER JOIN $dbbilling.b_ms_unit ON $dbbilling.b_ms_unit.id=$dbbilling.b_pelayanan.unit_id
INNER JOIN $dbbilling.b_ms_kso ON $dbbilling.b_ms_kso.id=$dbbilling.b_resep.kso_id
WHERE $dbbilling.b_resep.tgl='$tgl2' AND $dbbilling.b_resep.apotek_id='$idunit' ".$fSta." GROUP BY $dbbilling.b_resep.no_resep,$dbbilling.b_resep.no_rm,$dbbilling.b_resep.cara_bayar,$dbbilling.b_resep.id_pelayanan) AS gab $filter ORDER BY ".$sorting; */
	
	/* $ftgl0 = "$dbbilling.b_resep.tgl='$tgl2'";
	$ftgl1 = "DATE_FORMAT(p.TGL, '%Y-%m-%d') = '$tgl2'";
	if($setBulan == 1){
		$ftgl0 = "YEAR($dbbilling.b_resep.tgl)='$tahun' AND MONTH($dbbilling.b_resep.tgl)='$bulan'";
		$ftgl1 = "YEAR(p.TGL)='$tahun' AND MONTH(p.TGL)='$bulan'";
	} */
	
	$ftgl0 = "$dbbilling.b_resep.tgl='$tgl2'";
	$ftgl1 = "DATE_FORMAT(p.TGL_ACT, '%Y-%m-%d') = '$tgl2'";
	if($setBulan == 1){
		$ftgl0 = "YEAR($dbbilling.b_resep.tgl)='$tahun' AND MONTH($dbbilling.b_resep.tgl)='$bulan'";
		$ftgl1 = "YEAR(p.TGL_ACT)='$tahun' AND MONTH(p.TGL_ACT)='$bulan'";
	}
	
	if($_REQUEST['status'] == "0"){
		$sql = "SELECT * 
				FROM
				  (SELECT 
					$dbbilling.b_resep.id,
					$dbbilling.b_resep.dokter_nama,
					$dbbilling.b_resep.id_pelayanan,
					$dbbilling.b_resep.no_resep,
					$dbbilling.b_resep.no_rm,
					$dbbilling.b_resep.nama_pasien,
					$dbbilling.b_resep.diagnosa_id,
					$dbbilling.b_ms_unit.nama AS unit,
					rspelindo_apotek.a_kepemilikan.NAMA AS kepemilikan,
					$dbbilling.b_ms_kso.nama AS kso,
					rspelindo_apotek.a_cara_bayar.id cara_bayar_id,
					rspelindo_apotek.a_cara_bayar.nama cara_bayar,
					rspelindo_apotek.a_kepemilikan.ID AS kepemilikanId,
					IFNULL(ap.NO_PENJUALAN, 0) n_penj,
					(SELECT 
					  TGL 
					FROM
					  rspelindo_apotek.a_penjualan ap 
					WHERE ap.NO_KUNJUNGAN = $dbbilling.b_resep.id_pelayanan 
					  AND ap.UNIT_ID = '{$idunit}' 
					  AND ap.NO_PASIEN = $dbbilling.b_resep.no_rm 
					  AND ap.NO_RESEP = $dbbilling.b_resep.no_resep 
					LIMIT 1) tgltrans,
					DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(mp.tgl_lahir, '%Y') - (
					  DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(mp.tgl_lahir, '00-%m-%d')
					) umur,
					DATE_FORMAT(mp.tgl_lahir, '%d-%m-%Y') tgl_lahir,
					mp.no_ktp,
					mp.telp,
					mp.sex,
					$dbbilling.b_resep.alamat,
					k.pasien_id,
					CONCAT( ( CONCAT( ( CONCAT( (CONCAT(mp.alamat, ' RT.', mp.rt)), ' RW.', mp.rw ) ), ', Desa ', w.nama ) ), ', Kecamatan ', wi.nama, ', ', wii.nama ) alamat_,
					$dbbilling.b_resep.iter,
					$dbbilling.b_resep.id_pelayanan NOKUNJUNGAN,
					DATE_FORMAT($dbbilling.b_resep.tgl, '%d-%m-%Y') tglll
				  FROM
					$dbbilling.b_resep 
					LEFT JOIN rspelindo_apotek.a_penjualan ap
					  ON ap.NO_KUNJUNGAN = $dbbilling.b_resep.id_pelayanan 
						AND ap.UNIT_ID = '{$idunit}' 
						AND ap.NO_PASIEN = $dbbilling.b_resep.no_rm 
						AND ap.NO_RESEP = $dbbilling.b_resep.no_resep 
					LEFT JOIN $dbbilling.b_pelayanan p 
					  ON $dbbilling.b_resep.id_pelayanan = p.id 
					INNER JOIN $dbbilling.b_kunjungan k 
					  ON p.kunjungan_id = k.id 
					INNER JOIN $dbbilling.b_ms_pasien mp 
					  ON k.pasien_id = mp.id 
					LEFT JOIN $dbbilling.b_ms_wilayah w 
					  ON mp.desa_id = w.id 
					LEFT JOIN $dbbilling.b_ms_wilayah wi 
					  ON mp.kec_id = wi.id 
					LEFT JOIN $dbbilling.b_ms_wilayah wii 
					  ON mp.kab_id = wii.id 
					INNER JOIN rspelindo_apotek.a_kepemilikan 
					  ON $dbbilling.b_resep.kepemilikan_id = rspelindo_apotek.a_kepemilikan.ID 
					INNER JOIN rspelindo_apotek.a_cara_bayar 
					  ON $dbbilling.b_resep.cara_bayar = rspelindo_apotek.a_cara_bayar.id 
					INNER JOIN $dbbilling.b_pelayanan 
					  ON $dbbilling.b_resep.id_pelayanan = $dbbilling.b_pelayanan.id 
					INNER JOIN $dbbilling.b_ms_unit 
					  ON $dbbilling.b_ms_unit.id = $dbbilling.b_pelayanan.unit_id 
					INNER JOIN $dbbilling.b_ms_kso 
					  ON $dbbilling.b_ms_kso.id = $dbbilling.b_resep.kso_id 
				  WHERE {$ftgl0} AND $dbbilling.b_resep.apotek_id='$idunit' ".$fSta."
				  GROUP BY $dbbilling.b_resep.no_resep,
					$dbbilling.b_resep.no_rm,
					$dbbilling.b_resep.cara_bayar,
					$dbbilling.b_resep.id_pelayanan{$fgroup}/* , 
					ap.no_penjualan */) AS gab $filter ORDER BY ".$sorting;
	} else {
		$sql = "SELECT *
				FROM
				(SELECT 
				  NULL id,
				  p.DOKTER dokter_nama,
				  p.NO_KUNJUNGAN id_pelayanan,
				  p.NO_RESEP no_resep,
				  p.NO_PASIEN no_rm,
				  p.NAMA_PASIEN nama_pasien,
				  t1.nama unit,
				  k.NAMA kepemilikan,
				  t1.ksoNm kso,
				  p.CARA_BAYAR cara_bayar_id,
				  cb.nama cara_bayar,
				  k.ID kepemilikanId,
				  p.NO_PENJUALAN n_penj,
				  p.TGL tgltrans,
				  DATE_FORMAT(p.TGL, '%d-%m-%Y') tglll,
				  t1.umur,
				  t1.tgl_lahir,
				  t1.no_ktp,
				  t1.telp,
				  t1.sex,
				  p.ALAMAT alamat,
				  t1.pasien_id,
				  t1.alamat_,
				  NULL iter,
				  p.NO_KUNJUNGAN NOKUNJUNGAN
				FROM
				  $dbapotek.a_penjualan p 
				  INNER JOIN a_penerimaan pe 
					ON pe.ID = p.PENERIMAAN_ID 
				  INNER JOIN a_kepemilikan k 
					ON k.ID = pe.KEPEMILIKAN_ID 
				  INNER JOIN 
					(SELECT 
					  pel.id,
					  pel.unit_id,
					  u.nama,
					  kso.nama ksoNm,
					  pel.pasien_id,
					  DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(mp.tgl_lahir, '%Y') - (
						DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(mp.tgl_lahir, '00-%m-%d')
					  ) umur,
					  DATE_FORMAT(mp.tgl_lahir, '%d-%m-%Y') tgl_lahir,
					  mp.no_ktp,
					  mp.telp,
					  mp.sex,
					  CONCAT((CONCAT((CONCAT((CONCAT(mp.alamat, ' RT.', mp.rt)),' RW.',mp.rw)),', Desa ',w.nama)),', Kecamatan ',wi.nama,', ',wii.nama) alamat_
					FROM
					  $dbbilling.b_pelayanan pel 
					  LEFT JOIN $dbbilling.b_ms_unit u 
						ON u.id = pel.unit_id 
					  LEFT JOIN $dbbilling.b_ms_kso kso 
						ON kso.id = pel.kso_id 
					  INNER JOIN $dbbilling.b_ms_pasien mp 
						ON mp.id = pel.pasien_id 
					  LEFT JOIN $dbbilling.b_ms_wilayah w 
						ON mp.desa_id = w.id 
					  LEFT JOIN $dbbilling.b_ms_wilayah wi 
						ON mp.kec_id = wi.id 
					  LEFT JOIN $dbbilling.b_ms_wilayah wii 
						ON mp.kab_id = wii.id) t1 
					ON t1.id = p.NO_KUNJUNGAN 
				  INNER JOIN a_cara_bayar cb 
					ON cb.id = p.CARA_BAYAR 
				WHERE {$ftgl1}
				  AND p.UNIT_ID = '$idunit' 
				GROUP BY p.NO_RESEP,
				  p.NO_PASIEN,
				  p.NO_PENJUALAN,
				  p.NO_KUNJUNGAN) AS gab {$filter} 
				ORDER BY ".$sorting;
	}
}elseif($grdDet == "true"){
	if($_REQUEST['status'] == "0"){
		$sql="SELECT $dbbilling.b_resep.id,$dbbilling.b_resep.dokter_nama,IFNULL($dbapotek.a_obat.OBAT_ID,0) OBAT_ID, $dbapotek.a_obat.OBAT_KODE, IFNULL($dbapotek.a_obat.OBAT_NAMA,$dbbilling.b_resep.obat_manual) OBAT_NAMA, IF($dbbilling.b_resep.racikan=0,'-',IF($dbbilling.b_resep.obat_id=0,'Racikan',CONCAT('Racikan ',$dbbilling.b_resep.racikan,' (',$dbbilling.b_resep.qty,' @',$dbbilling.b_resep.qty_bahan,' ',$dbbilling.b_resep.satuan,')'))) as racikan,$dbbilling.b_resep.racikan isRacikan,
IF($dbbilling.b_resep.racikan=0,$dbbilling.b_resep.qty,IF($dbbilling.b_resep.obat_id=0,$dbbilling.b_resep.qty,0)) qty,$dbbilling.b_resep.racikan as racikan2,$dbbilling.b_resep.kepemilikan_id,$dbbilling.b_resep.status,$dbbilling.b_resep.id_pelayanan,$dbbilling.b_resep.no_rm,$dbbilling.b_resep.no_resep,$dbbilling.b_resep.ket_dosis, concat('(',$dbbilling.b_ms_bobat.nama,')') as nm_bentuk, IF(sdtd = 1,'dtd','') AS dtd
FROM $dbbilling.b_resep 
LEFT JOIN $dbapotek.a_obat ON $dbapotek.a_obat.OBAT_ID=$dbbilling.b_resep.obat_id
LEFT JOIN $dbbilling.b_ms_bobat on $dbbilling.b_resep.id_bentuk = $dbbilling.b_ms_bobat.id
WHERE $dbbilling.b_resep.tgl='$tgl2' AND $dbbilling.b_resep.apotek_id='$idunit' AND $dbbilling.b_resep.no_resep='".$_REQUEST['no_resep']."' AND $dbbilling.b_resep.id_pelayanan='$idpel' AND $dbbilling.b_resep.no_rm='".$_REQUEST['no_rm']."' ".$fSta;
	}else{
		$sql="SELECT ap.ID id,p.OBAT_ID,o.OBAT_KODE,o.OBAT_NAMA,IF(ap.RACIKAN=0,'-','&radic;') AS racikan,
ap.RACIKAN isRacikan,SUM(ap.QTY) qty,p.KEPEMILIKAN_ID kepemilikan_id,2 status,ap.NO_KUNJUNGAN id_pelayanan,
ap.NO_PASIEN no_rm,ap.NO_RESEP no_resep,ap.KET_DOSIS ket_dosis,ap.HARGA_NETTO,ap.HARGA_SATUAN, ap.textH, ap.textT, ap.textK, ap.textP
FROM $dbapotek.a_penjualan ap 
INNER JOIN $dbapotek.a_penerimaan p ON ap.PENERIMAAN_ID=p.ID
INNER JOIN $dbapotek.a_obat o ON p.OBAT_ID=o.OBAT_ID 
INNER JOIN $dbapotek.a_kepemilikan k ON p.KEPEMILIKAN_ID=k.ID
WHERE ap.NO_PENJUALAN='".$_REQUEST['no_penj']."' AND ap.UNIT_ID='$idunit' 
AND ap.NO_PASIEN='".$_REQUEST['no_rm']."' 
AND ap.TGL='".$_REQUEST['tgltrans']."' 
GROUP BY p.OBAT_ID,p.KEPEMILIKAN_ID";
	}
}
if($grd!='' || $grdDet != ''){
//echo $sql."<br>";
$perpage = 100;
$rs=mysqli_query($konek,$sql);
$jmldata=mysqli_num_rows($rs);
if ($page=="" || $page=="0") $page=1;
$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
$sql=$sql." limit $tpage,$perpage";
//echo $sql;
$sql2=$sql;
$rs=mysqli_query($konek,$sql);
$i=($page-1)*$perpage;
$dt=$totpage.chr(5);
$j=0;
if($grd == "true")
{
	$rows2=mysqli_num_rows(mysqli_query($konek,$sql2));
	while ($rows=mysqli_fetch_array($rs))
	{
		$i++;
		$j++;
		
		$cCaraBayar=$rows["cara_bayar"];
		$diagnosa = '';
		if ($_REQUEST['status'] == "0"){
			$cCaraBayar="<span id='cBayar-$j' style='text-decoration:underline' title='Klik Untuk Mengubah Cara Bayar Pasien' onclick='UbahCaraBayar(this);'>".$rows["cara_bayar"]."</span>";
			
			$sDiag = "SELECT IFNULL(d.diagnosa_manual,md.nama) AS nama
						FROM $dbbilling.b_diagnosa d 
						LEFT JOIN $dbbilling.b_ms_diagnosa md
						ON md.id = d.ms_diagnosa_id
						WHERE d.diagnosa_id = '".$rows["diagnosa_id"]."'";
			$qDiag = mysqli_query($konek,$sDiag) or die (mysqli_error($konek));
			$diag = mysqli_fetch_array($qDiag);
			$diagnosa = $diag['nama'];
		} else {
			$sDiag = "SELECT GROUP_CONCAT(IFNULL(d.diagnosa_manual,md.nama) SEPARATOR ', ') AS nama
						FROM $dbbilling.b_diagnosa d 
						LEFT JOIN $dbbilling.b_ms_diagnosa md
						ON md.id = d.ms_diagnosa_id
						WHERE d.pelayanan_id = '".$rows["id_pelayanan"]."'
						GROUP BY d.pelayanan_id";
			$qDiag = mysqli_query($konek,$sDiag) or die (mysqli_error($konek));
			$diag = mysqli_fetch_array($qDiag);
			$diagnosa = $diag['nama'];
		}
		//echo $sDiag;
		//$infoPasien="<span id='pasiens' style='text-decoration:underline' title='Klik Untuk Melihat Detail Pasien' onclick='detailPasien(".$rows["nama_pasien"].",".$rows["sex"].",".$rows["umur"].",".$rows["tgl_lahir"].",".$rows["telp"].",".$rows["no_ktp"].",".$rows["no_rm"].");'>DETAIL</span>";
		$infoPasien="<span id='pasiens' style='text-decoration:underline' title='Klik Untuk Melihat Detail Pasien' onclick='detailPasien(".$rows["pasien_id"].",".$rows2.");'>DETAIL PASIEN</span>";
		
		$HTKP="<span id='pasiens' style='text-decoration:underline' title='Klik Untuk Melihat HTKP' onclick='detailHTKP(".$rows["NOKUNJUNGAN"].",".$rows["pasien_id"].",".$rows["n_penj"].");'>HTKP</span>"; // $rows["no_resep"]
		
		$sisip=$rows["id"].'|'.$rows["kepemilikanId"]."|".$rows["no_resep"]."|".$rows["no_rm"]."|".$rows["id_pelayanan"]."|".$rows["n_penj"]."|".$rows["tgltrans"]."|".$rows["cara_bayar_id"]."|".$rows["nama_pasien"]."|".$rows["sex"]."|".$rows["umur"]."|".$rows["tgl_lahir"]."|".$rows["alamat_"]."|".$rows["telp"]."|".$rows["no_ktp"]."|".$rows["no_rm"]."|".$rows["tglll"]."|".$diagnosa; //."|".$rows["txtH"]."|".$rows["txtT"]."|".$rows["txtK"]."|".$rows["txtP"]
		$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["no_resep"].chr(3).$rows["no_rm"].chr(3).$rows["nama_pasien"].chr(3).$rows["unit"].chr(3).$rows["dokter_nama"].chr(3).$cCaraBayar.chr(3).$rows["kepemilikan"].chr(3).$rows["kso"].chr(3).$infoPasien.chr(3).$rows["iter"].chr(3).$HTKP.chr(6);
	}
}elseif($grdDet == "true")
{
	while ($rows=mysqli_fetch_array($rs))
	{
		$i++;
		$j++;
		if($_REQUEST['status'] == "0"){
			$sqlHarga="SELECT FLOOR(HARGA_JUAL_SATUAN) HARGA_JUAL_SATUAN,FLOOR(HARGA_BELI_SATUAN) HARGA_BELI_SATUAN FROM a_harga WHERE OBAT_ID=".$rows["OBAT_ID"]." AND KEPEMILIKAN_ID=".$rows["kepemilikan_id"]." ORDER BY HARGA_JUAL_SATUAN DESC LIMIT 1";
			$rsHarga=mysqli_query($konek,$sqlHarga);
			$rwHarga=mysqli_fetch_array($rsHarga);
			$hSatuan=$rwHarga["HARGA_JUAL_SATUAN"];
			$hNetto=$rwHarga["HARGA_BELI_SATUAN"];
		}else{
			$hSatuan=$rows["HARGA_SATUAN"];
			$hNetto=$rows["HARGA_NETTO"];
		}
	
		$sqlHarga="SELECT IFNULL(SUM(qty_stok),0) stok FROM $dbapotek.a_stok WHERE unit_id=$idunit AND obat_id=".$rows["OBAT_ID"]." AND kepemilikan_id=".$rows["kepemilikan_id"];
		//echo $sqlHarga."<br /><br />";
		$rsHarga=mysqli_query($konek,$sqlHarga);
		$rwHarga=mysqli_fetch_array($rsHarga);
		
		if(count(explode('.',$rwHarga["stok"]))>=2){
			$hStok = number_format($rwHarga["stok"],2);
		} else {
			$hStok = $rwHarga["stok"];
		}
		//echo number_format($hStok,0,",",".")."<br /><br />";
		
		$cedit="";
		if($rows["status"]!=0){
			$ch = " checked='checked'";
			if ($rows["status"]==1){
				$cedit="&nbsp;|&nbsp;<img src='../icon/edit.gif' border='0' width='16' height='16' align='absmiddle' title='Klik Untuk Mengubah Resep' onclick=EditObat('".$rows["id"]."|".$rows["kepemilikan_id"]."|".$rows["qty"]."|".$i."') />";
			}
			
			$cqtyRsp=$rows["qty"];
		}else{
			$ch = "";
			$cedit="&nbsp;|&nbsp;<img src='../icon/edit.gif' border='0' width='16' height='16' align='absmiddle' title='Klik Untuk Mengubah Resep' onclick=EditObat('".$rows["id"]."|".$rows["kepemilikan_id"]."|".$rows["qty"]."|".$i."|".$rows["nm_bentuk"]."') />";
			
			$cqtyRsp="<span id='qtyRsp-$i' style='text-decoration:underline' title='Klik Untuk Mengubah Jumlah Obat Yg Diambil Pasien' onclick='UbahQtyRsp(this,$rows[qty],$rows[racikan2]);'>".$rows["qty"]."</span>";
		}
		//$cqtyRsp="<span id='qtyRsp$i' title='Klik Untuk Mengubah Jumlah Obat Yg Diambil Pasien' onclick='tes();'>".$rows["qty"]."</span>";
		//$sisip=$rows["id"]."|".$hSatuan."|".$hNetto."|".$rows["qty"]."|".$rows["kepemilikan_id"]."|".$rows["OBAT_ID"]."|".$rows["isRacikan"];
		
		$sisip=$rows["id"]."|".$hSatuan."|".$hNetto."|".$rows["qty"]."|".$rows["kepemilikan_id"]."|".$rows["OBAT_ID"]."|".$rows["isRacikan"]."|".$rows["textH"]."|".$rows["textT"]."|".$rows["textK"]."|".$rows["textP"];
		
		$d="<input type='checkbox' id='ch".$rows["id"]."'".$dis.$ch." title='Centang Untuk Melayani Resep' onclick='CheckedObat($j);' />".$cedit;
		
		if($rows["OBAT_ID"]==0)
		{
			$ket = $rows["qty"]." ".$rows["racikan"];
			$jml = "<span id='qtyRsp-$i' style='text-decoration:underline' title='Klik Untuk Mengubah Jumlah Obat Yg Diambil Pasien' onclick='UbahQtyRsp(this,$rows[qty],$rows[racikan2]);'>0</span>";
		}else{
			$ket = $rows["racikan"];
			$jml = $cqtyRsp;
		}
		
		$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["OBAT_NAMA"].chr(3).$rows["ket_dosis"].chr(3).$ket." ".$rows["nm_bentuk"]." ".$rows["dtd"].chr(3).$hStok.chr(3).number_format($hNetto,0,",",".").chr(3).$jml.chr(3).number_format($hSatuan,0,",",".").chr(3).number_format(($hSatuan*$rows["qty"]),0,",",".").chr(3).$d.chr(6);
	}
}

if ($dt!=$totpage.chr(5)){
	$dt=substr($dt,0,strlen($dt)-1);
	$dt=str_replace('"','\"',$dt);
}

if ($grd == "true"){
	$dt.=chr(5).$val;
}

mysqli_free_result($rs);
mysqli_close($konek);

header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")){
	header("Content-type: application/xhtml+xml");
}else{
	header("Content-type: text/xml");
}

echo $dt;
}
?>