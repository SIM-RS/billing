<?php
include("../koneksi/konek.php");
include("../include/variable.inc.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="b.byr_tgl DESC, s.siswa_nama ASC";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$id = $_REQUEST['rowid'];
//echo $tgl."<br>";
$grd = $_REQUEST['grd'];
//echo $grd."<br>";
//$kasir = $_REQUEST['kasir'];
$tanggal = $_REQUEST['tanggal'];
//$tglP = tglSQL($tanggal);
$tanggalSlip = $_REQUEST['tanggalSlip'];
$no_slip = $_REQUEST['no_slip'];
$posting = $_REQUEST['posting'];
$idUser = $_REQUEST['idUser'];

$bayar_id = $_REQUEST['bayar_id'];
//===============================
// external parameter goes here
//===============================
$statusProses='';
$alasan='';
switch(strtolower($_REQUEST['act'])) {
    case 'verifikasi':
		//$noSlip=$_REQUEST["noSlip"];
		$fdata=$_REQUEST["fdata"];
		$arfdata=explode(chr(6),$fdata);
		/*echo "<script>alert('$arfdata[0],$arfdata[1]');</script>";*/
		if ($posting==0)
		{
			for ($i=0;$i<count($arfdata);$i++)
			{
				$cdata=explode(chr(5),$arfdata[$i]);
				$idBayar=$cdata[0];
				$nilai=$cdata[1];
				
				$sql = "update db_rspendidikan.ku_bayar AS b
						SET b.verifikasi = 1,
							b.user_verifikasi = {$idUser},
							b.tgl_verifikasi = NOW()
						where b.byr_id = {$idBayar}";
				//echo $sql."<br>";
				$query = mysql_query($sql);
				/* if(mysql_affected_rows() > 0){
					echo "Proses Verifikasi Data Berhasil!";
				} else {
					echo "Proses Verifikasi Data Gagal!";
				} */
				// put your verification code in here
			}
		}
		else
		{
			for ($i=0;$i<count($arfdata);$i++)
			{
				$cdata=explode(chr(5),$arfdata[$i]);
				$idBayar=$cdata[0];
				$nilai=$cdata[1];
					
				// put your verification code in here
			}			
		}
		if(mysql_errno() <= 0){
			echo "sukses";
		} else {
			echo "gagal";
		}
		return;
        break;
}

	if($statusProses=='Error') {
		$dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act'])."|".$alasan;
	}
	
    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
    }

    if ($sorting=="") {
        $sorting=$defaultsort;
    }
	
    if ($grd == "penerimaanDiklit") {
		$fkasir="";
		if ($kasir==0){
			$fkasir="";
		}
		
		//$fTgl=tglSQL($tanggal);
		$fTgl = "";
		if($tanggalSlip != ""){
			$fTgl = "AND b.byr_tgl = '".tglSQL($tanggalSlip)."'";
		}
		
		$fnoslip = "";
		if($no_slip!=""){
			$fnoslip = "AND b.byr_kode = '{$no_slip}'";
		}
		
		if ($posting==0){
			$sql = "SELECT DISTINCT b.byr_id,b.byr_tgl,b.byr_kode,b.siswa_id,b.byr_thn,b.byr_bln,j.byrjns,
							b.byrjns_id,b.nilai,s.siswa_nama,s.siswa_npm,ks.sbdana,mu.user_nama 
					FROM db_rspendidikan.ku_bayar  b 
					INNER JOIN db_rspendidikan.siswa s ON b.siswa_id = s.siswa_id 
					INNER JOIN db_rspendidikan.ku_jenisbayar j ON b.byrjns_id = j.byrjns_id 
					LEFT JOIN db_rspendidikan.ku_sbdana ks ON b.sbdana_id = ks.sbdana_id
					LEFT JOIN db_rspendidikan.ms_user mu ON b.petugas_id = mu.user_id
					WHERE 0=0 {$filter} {$fnoslip} {$fTgl} AND b.verifikasi = 0
					ORDER BY ".$sorting;
		} else {
			$sql = "SELECT DISTINCT b.byr_id,b.byr_tgl,b.byr_kode,b.siswa_id,b.byr_thn,b.byr_bln,j.byrjns,
						b.byrjns_id,b.nilai,s.siswa_nama,s.siswa_npm,ks.sbdana,mu.user_nama 
				FROM db_rspendidikan.ku_bayar  b 
				INNER JOIN db_rspendidikan.siswa s ON b.siswa_id = s.siswa_id 
				INNER JOIN db_rspendidikan.ku_jenisbayar j ON b.byrjns_id = j.byrjns_id 
				LEFT JOIN db_rspendidikan.ku_sbdana ks ON b.sbdana_id = ks.sbdana_id
				LEFT JOIN db_rspendidikan.ms_user mu ON b.petugas_id = mu.user_id
				WHERE 0=0 {$filter} {$fnoslip} {$fTgl} AND b.verifikasi = 1
				ORDER BY ".$sorting;
		}
		
		/* $sqlSum = "select ifnull(sum(nilai),0) as totnilai from (".$sql.") sql36";
		$rsSum = mysql_query($sqlSum);
		$rwSum = mysql_fetch_array($rsSum); */
		$stot = 0;
    } elseif ($grd=="loadkasir"){
		$dt='<option value="0">SEMUA</option>';
		//$sqlKasir="SELECT mp.id,mp.nama FROM (SELECT DISTINCT user_act FROM ".$dbbilling.".b_bayar b WHERE b.tgl='".tglSQL($tanggal)."') AS bb INNER JOIN ".$dbbilling.".b_ms_pegawai mp ON bb.user_act=mp.id ORDER BY mp.nama";
		$sqlKasir="SELECT mp.id,mp.nama FROM (SELECT DISTINCT user_act FROM ".$dbbilling.".b_bayar b WHERE DATE(b.disetor_tgl)='".tglSQL($tanggalSlip)."') AS bb INNER JOIN ".$dbbilling.".b_ms_pegawai mp ON bb.user_act=mp.id ORDER BY mp.nama";
		//echo $sqlKasir."<br>";
		$qTmp = mysql_query($sqlKasir);
		while($wTmp = mysql_fetch_array($qTmp))
		{
			$dt.='<option value="'.$wTmp["id"].'">'.$wTmp["nama"].'</option>';
		}
		echo $dt;
		return;
	}
    
    //echo $sql."<br>";
    $rs=mysql_query($sql);
    $jmldata=mysql_num_rows($rs);
    if ($page=="" || $page=="0") $page=1;
    $tpage=($page-1)*$perpage;
    if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
    if ($page>1) $bpage=$page-1; else $bpage=1;
    if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
    $sql=$sql." limit $tpage,$perpage";
    //echo $sql;

    $rs=mysql_query($sql);
    $i=($page-1)*$perpage;
    $dt=$totpage.chr(5);
//byr_tgl,no_induk,siswa_nama,byr_kode,byrjns,byr_thn,nilai,sbdana,usr,
    if ($grd == "penerimaanDiklit") {
		if ($posting==0){
			while ($rows=mysql_fetch_array($rs)) {
				$i++;
				//echo $rows["byr_id"]."-------";
				$checkbox = $rows["byr_id"]."|".$rows["nilai"];
				$dt.=$rows["byr_id"]."|".$rows["nilai"].chr(3).number_format($i,0,",",".").chr(3).$rows["byr_tgl"].chr(3).$rows["siswa_npm"].chr(3).$rows["siswa_nama"].chr(3).$rows["byr_kode"].chr(3).$rows["byrjns"].chr(3).$rows["byr_thn"].chr(3).number_format($rows["nilai"],0,",",".").chr(3).$rows["sbdana"].chr(3).$rows["user_nama"].chr(3).$checkbox.chr(6);
			}
		}else{
			while ($rows=mysql_fetch_array($rs)) {
				$i++;
				//$checkbox = "<input type='checkbox'  disabled='disabled' id='check".$rows["byr_id"]."' value='".$rows["byr_id"]."|".$rows["nilai"]."'/>";
				$checkbox = $rows["byr_id"]."|".$rows["nilai"].'" disabled=disabled';
				$dt.=$rows["byr_id"]."|".$rows["nilai"].chr(3).number_format($i,0,",",".").chr(3).$rows["byr_tgl"].chr(3).$rows["siswa_npm"].chr(3).$rows["siswa_nama"].chr(3).$rows["byr_kode"].chr(3).$rows["byrjns"].chr(3).$rows["byr_thn"].chr(3).number_format($rows["nilai"],0,",",".").chr(3).$rows["sbdana"].chr(3).$rows["user_nama"].chr(3).$checkbox.chr(6);
			}
		}
    }

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5); //.$_REQUEST['act']."|".$grd."|".number_format($stot,0,",",".")."|".$posting;
        $dt=str_replace('"','\"',$dt);
    }else{
        $dt=$dt.chr(5); //.$_REQUEST['act']."|".$grd."|".number_format($stot,0,",",".")."|".$posting;
        $dt=str_replace('"','\"',$dt);
	}
    mysql_free_result($rs);
	
	mysql_close($konek);
	///
	header("Cache-Control: no-cache, must-revalidate" );
	header("Pragma: no-cache" );
	if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
		header("Content-type: application/xhtml+xml");
	}else {
		header("Content-type: text/xml");
	}
	echo $dt;
?>