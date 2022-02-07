<?php
session_start();
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="rt.NO_RETUR DESC";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$level = ($_REQUEST['level']=='')?1:$_REQUEST['level'];
$kodeAk=$_REQUEST["kodeAk"];
$nama = $_REQUEST['nama'];
$nama = str_replace(chr(5),'&',$nama);
$idretur = $_REQUEST['idretur'];
$no_retur = $_REQUEST['noretur'];
$penerimaan_id = $_REQUEST['peneid'];
$bulan = $_REQUEST['bln'];
$ta = $_REQUEST['th'];
$idunit = $_REQUEST['unit_id'];
$idUser = $_SESSION['userId'];
if($idunit=="")
{
	$idunit = $_REQUEST['param2'];
}

if($_GET['ktgr'] == 4){
    $cakupan = $_GET['cakupan'];
}
else{
    $cakupan = 0;
}
//===============================
$statusProses='';
$alasan='';

/* if($_REQUEST['proses']!="del")
{
	$queryUnit = "SELECT unit_id FROM $dbapotek.a_unit WHERE unit_billing = $idunit";
	$runit = mysql_query($queryUnit); 
	$dunit = mysql_fetch_array($runit);
	$idunit = $dunit['unit_id'];
	if($idunit=="")
	{
		$idunit=0;
	}
} */


//echo $_REQUEST['proses']."masuk";
if($_REQUEST['proses']=="del"){
	$sretur = "select * from $dbapotek.a_retur_togudang where NO_RETUR='$no_retur' and ID_RETUR='$idretur'";
	$qretur = mysql_query($sretur);
	$dretur = mysql_fetch_array($qretur);
	$sUpdate = "UPDATE a_penerimaan SET
				WHERE ID = ".$dretur['PENERIMAAN_ID'];
	$sql="update $dbapotek.a_retur_togudang 
	set STATDEL = 1 and USERDEL = '$idUser'
	where NO_RETUR='$no_retur' and ID_RETUR='$idretur'";
	$rs=mysql_query($sql);
}
switch(strtolower($_REQUEST['act'])){
	case 'tambah':
		mysql_query("select * from b_ms_unit where kode='".$_REQUEST['parentKode'].$_REQUEST['kode']."'");
		if(mysql_affected_rows()==0){
			$sqlTambah="insert into b_ms_unit (kode,kode_ak,nama,level,parent_id,parent_kode,ket,kategori,jenis_layanan,inap,aktif)
				values('".$_REQUEST['parentKode'].$_REQUEST['kode']."','$kodeAk','$nama','".$level."','".$_REQUEST['parentId']."','".$_REQUEST['parentKode']."','".$_REQUEST['ket']."','".$_REQUEST['ktgr']."','$cakupan','".$_REQUEST['inap']."','".$_REQUEST['aktif']."')";
			//echo $sqlTambah."<br/>";
			$rs=mysql_query($sqlTambah);
			
			$cekLast="select islast from b_ms_unit where parent_id='".$_REQUEST['parentId']."'";
			$rsLast=mysql_query($cekLast);
			$rwLast=mysql_fetch_array($rsLast);
			if($rwLast['islast']=='1'){
				$updtLast="update b_ms_unit set islast=0 where id='".$_REQUEST['parentId']."'";
				mysql_query($updtLast);
			}
		}
		break;
	case 'hapus':
		$sqlAnak="select id from b_ms_unit where parent_id='".$_REQUEST['rowid']."'";
		$rsAnak=mysql_query($sqlAnak);
		if(mysql_num_rows($rsAnak)>0){
			$statusProses='Error';
			$alasan="masih memiliki anak";
		}else{		
			$sqlParent="select parent_id from b_ms_unit where id='".$_REQUEST['rowid']."'";
			$rsParent=mysql_query($sqlParent);
			$rwParent=mysql_fetch_array($rsParent);
			
			$sqlHapus="delete from b_ms_unit where id='".$_REQUEST['rowid']."'";
			mysql_query($sqlHapus);
			
			$cekLast="select islast from b_ms_unit where parent_id='".$rwParent['parent_id']."'";
			$rsLast=mysql_query($cekLast);
			if(mysql_num_rows($rsLast)==0){
				$updtLast="update b_ms_unit set islast=1 where id='".$rwParent['parent_id']."'";
				mysql_query($updtLast);
			}
		}
		break;
	case 'simpan':
		$sqlParent="select parent_id from b_ms_unit where id='".$_REQUEST['id']."'";
		$rsParent=mysql_query($sqlParent);
		$rwParent=mysql_fetch_array($rsParent);
		if($rwParent['parent_id']==$_REQUEST['parentId']){
			$sqlSimpan="update b_ms_unit set kode='".$_REQUEST['parentKode'].$_REQUEST['kode']."',kode_ak='$kodeAk',nama='$nama',level='".$level."',
                                parent_kode='".$_REQUEST['parentKode']."',ket='".$_REQUEST['ket']."',kategori='".$_REQUEST['ktgr']."',inap='".$_REQUEST['inap']."'
                                ,aktif='".$_REQUEST['aktif']."', jenis_layanan='$cakupan' where id='".$_REQUEST['id']."'";
		}else{
			$sqlSimpan="update b_ms_unit set kode='".$_REQUEST['parentKode'].$_REQUEST['kode']."',kode_ak='$kodeAk',nama='$nama',level='".$level."',
                                parent_id='".$_REQUEST['parentId']."', parent_kode='".$_REQUEST['parentKode']."',ket='".$_REQUEST['ket']."',kategori='".$_REQUEST['ktgr']."'
                                ,inap='".$_REQUEST['inap']."',aktif='".$_REQUEST['aktif']."',jenis_layanan='$cakupan' where id='".$_REQUEST['id']."'";
			
			$cekLast="select islast from b_ms_unit where parent_id='".$_REQUEST['parentId']."'";
			$rsLast=mysql_query($cekLast);
			$rwLast=mysql_fetch_array($rsLast);
			if($rwLast['islast']=='1'){
				$updtLast="update b_ms_unit set islast=0 where id='".$_REQUEST['parentId']."'";
				mysql_query($updtLast);
			}
			
			$cekLastParentLama="select * from b_ms_unit where parent_id='".$rwParent['parent_id']."'";
			$rsLastParentLama=mysql_query($cekLastParentLama);
			if(mysql_num_rows($rsLastParentLama)<=0){
				$updtLast="update b_ms_unit set islast=1 where id='".$rwParent['parent_id']."'";
				mysql_query($updtLast);
			}
		}
		
		$rs=mysql_query($sqlSimpan);
		break;
}

if($statusProses=='Error'){	
	$dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act'])."*|*".$alasan;
}
else{

	if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
	}
	
	if ($sorting==""){
		$sorting=$defaultsort;
	}
	
/* $sql="SELECT DISTINCT 
  am.no_bukti,
  DATE_FORMAT(am.tgl, '%d/%m/%Y') AS tgl1,
  a_unit.UNIT_NAME,
  a_unit.UNIT_ID,
  am.unit_id AS id_minta,
  k.NAMA,
  STATUS,
  IF(STATUS = 0,'Menunggu',IF(STATUS = 1,'Dikirm','Diterima')) AS STATUS1,
  u.unit_billing
FROM
  $dbapotek.a_minta_obat am 
  INNER JOIN $dbapotek.a_unit 
    ON am.unit_tujuan = a_unit.UNIT_ID 
  INNER JOIN {$dbapotek}.a_unit u
    ON u.UNIT_ID = am.unit_id
  INNER JOIN $dbapotek.a_kepemilikan k 
    ON am.kepemilikan_id = k.ID 
	where am.unit_id=$idunit and month(am.tgl)=$bulan and year(am.tgl)=$ta ".$filter." order by ".$sorting; */
	$sunit = "select UNIT_ID,UNIT_KODE from $dbapotek.a_unit u where u.unit_billing = $idunit";
	$qunit = mysql_query($sunit);
	$jml = mysql_num_rows($qunit);
	if($jml>0){
		$unitId = mysql_fetch_array($qunit);
		if($unitId['UNIT_ID'] != 0){
			$idunit = $unitId['UNIT_ID'];
		}
	}
	  
	$sql = "SELECT 
			  rt.*,
			  u.UNIT_NAME,
			  o.OBAT_NAMA,
			  k.NAMA 
			FROM
			  {$dbapotek}.a_retur_togudang rt
			  INNER JOIN {$dbapotek}.a_obat o
				ON rt.OBAT_ID = o.OBAT_ID 
			  INNER JOIN {$dbapotek}.a_unit u
				ON rt.UNIT_ID = u.UNIT_ID 
			  INNER JOIN {$dbapotek}.a_kepemilikan k 
				ON rt.KEPEMILIKAN_ID = k.ID 
			WHERE rt.UNIT_ID = '{$idunit}'
			  AND MONTH(rt.TGL_RETUR) = '{$bulan}'
			  AND YEAR(rt.TGL_RETUR) = '{$ta}' 
			  $filter
			  /* AND STATDEL = 0 */
			ORDER BY {$sorting}";
	
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
	/*$gubah = "<img src='../icon/edit.gif' border='0' width='16' height='16' align='absmiddle' class='proses' title='Klik Untuk Melihat Detail Permintaan' onClick='location='?f=../apotik/minta_obat.php&no_minta=$rows['no_bukti']&unit_tujuan=$rows['UNIT_ID']; ?>&tglminta=<?php echo $rows['tgl1']; ?>&isview=true&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>';">";*/
	$bulan = 8;
	$ta = 2013;
	while ($rows=mysql_fetch_array($rs)){
	//$sUnit = 'select * from b_unit';
	/*$gubah = "<img src='../icon/edit.gif' border='0' width='16' height='16' align='absmiddle' class='proses' title='Klik Untuk Melihat Detail Permintaan' onClick='location=\"minta_terima_obat1.php?no_minta=<?php echo $rows['no_bukti']; ?>&unit_tujuan=<?php echo $rows['UNIT_ID']; ?>&tglminta=<?php echo $rows['tgl1']; ?>&isview=true&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>;\">";*/
	//$gubah = "<img src='../icon/edit.gif' border='0' width='16' height='16' align='absmiddle' class='proses' title='Klik Untuk Melihat Detail Permintaan' onClick=location='minta_terima_obat1.php?no_minta=$rows[no_bukti]&unit_tujuan=$rows[UNIT_ID]&tglminta=$rows[tgl1]&isview=true&bulan=$bulan&ta=$ta' />";
	
		$gubah = "<img src='../icon/edit.gif' border='0' width='16' height='16' align='absmiddle' class='proses' title='Klik Untuk Melihat Detail Permintaan' onClick=location='minta_obat2.php?no_minta=$rows[no_bukti]&cmbTmpLay=$rows[unit_billing]&unit_tujuan=$rows[UNIT_ID]&tglminta=$rows[tgl1]&isview=true&bulan=$bulan&ta=$ta' />";
		$ghapus = "<img src='../icon/hapus.gif' border='0' width='16' height='16' align='absmiddle' class='proses' title='Klik Untuk Menghapus Permintaan' onClick=hapus_minta('$rows[ID_RETUR]','$rows[NO_RETUR]','$rows[PENERIMAAN_ID]')>";
		
		$css = "style='color:black'";
		if($rows['STATUS'] == 1){
			$css = "style='color:blue; font-weight:bold;'";
		}
		
		//echo $rows['TGL_RETUR'].'---------------';
		$dateT = explode('-',$rows['TGL_RETUR']);
		$i++;
		$pros = $gubah."|".$ghapus;
		$dt.=$rows["ID_RETUR"].'|'.$rows['TGL_RETUR'].chr(3)."<font {$css}>".number_format($i,0,",","").'</font>'.chr(3)."<font {$css}>".$dateT[2].'-'.$dateT[1].'-'.$dateT[0].'</font>'.chr(3)."<font {$css}>".$rows['NO_RETUR'].'</font>'.chr(3)."<font {$css}>".$rows['OBAT_NAMA'].'</font>'.chr(3)."<font {$css}>".$rows["NAMA"].'</font>'.chr(3)."<font {$css}>".$rows['QTY'].'</font>'.chr(3)."<font {$css}>".$rows['ALASAN'].'</font>'.chr(6);//.$ghapus.chr(6);
	}
	
	if ($dt!=$totpage.chr(5)){
		$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']);
		$dt=str_replace('"','\"',$dt);
	}
	mysql_free_result($rs);
}
mysql_close($konek);
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")){
	header("Content-type: application/xhtml+xml");
}else{
	header("Content-type: text/xml");
}
echo $dt;
?>