<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="am.no_bukti";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$level = ($_REQUEST['level']=='')?1:$_REQUEST['level'];
$kodeAk=$_REQUEST["kodeAk"];
$nama = $_REQUEST['nama'];
$nama = str_replace(chr(5),'&',$nama);
$no_bukti = $_REQUEST['param1'];
$idunit = $_REQUEST['param2'];
$bulan = $_REQUEST['bln'];
$ta = $_REQUEST['th'];
$idunit = $_REQUEST['unit_id'];

if($_GET['ktgr'] == 4){
    $cakupan = $_GET['cakupan'];
}
else{
    $cakupan = 0;
}
//===============================
$statusProses='';
$alasan='';

$queryUnit = "SELECT unit_id FROM $dbapotek.a_unit WHERE unit_billing = $idunit";
$runit = mysql_query($queryUnit); 
$dunit = mysql_fetch_array($runit);
$idunit = $dunit['unit_id'];
if($idunit=="")
{
	$idunit=0;
}

if($_REQUEST['proses']=="del")
{
	$sql="delete from $dbapotek.a_minta_obat where no_bukti='$no_bukti' and unit_id=$idunit";
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
		$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
	}
	
	if ($sorting==""){
		$sorting=$defaultsort;
	}
	
$sql="SELECT DISTINCT 
  am.no_bukti,
  DATE_FORMAT(am.tgl, '%d/%m/%Y') AS tgl1,
  a_unit.UNIT_NAME,
  a_unit.UNIT_ID,
  am.unit_id AS id_minta,
  k.NAMA,
  STATUS,
  IF(STATUS = 0,'Menunggu',IF(STATUS = 1,'Dikirm','Diterima')) AS STATUS1
FROM
  $dbapotek.a_minta_obat am 
  INNER JOIN $dbapotek.a_unit 
    ON am.unit_tujuan = a_unit.UNIT_ID 
  INNER JOIN $dbapotek.a_kepemilikan k 
    ON am.kepemilikan_id = k.ID 
	where am.unit_id=$idunit and month(am.tgl)=$bulan and year(am.tgl)=$ta ".$filter." order by ".$sorting;
	
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
	/*$gubah = "<img src='../icon/edit.gif' border='0' width='16' height='16' align='absmiddle' class='proses' title='Klik Untuk Melihat Detail Permintaan' onClick='location=\"minta_terima_obat1.php?no_minta=<?php echo $rows['no_bukti']; ?>&unit_tujuan=<?php echo $rows['UNIT_ID']; ?>&tglminta=<?php echo $rows['tgl1']; ?>&isview=true&bulan=<?php echo $bulan; ?>&ta=<?php echo $ta; ?>;\">";*/
	$gubah = "<img src='../icon/edit.gif' border='0' width='16' height='16' align='absmiddle' class='proses' title='Klik Untuk Melihat Detail Permintaan' onClick=location='minta_terima_obat1.php?no_minta=$rows[no_bukti]&unit_tujuan=$rows[UNIT_ID]&tglminta=$rows[tgl1]&isview=true&bulan=$bulan&ta=$ta' />";
	$ghapus = "<img src='../icon/hapus.gif' border='0' width='16' height='16' align='absmiddle' class='proses' title='Klik Untuk Menghapus Permintaan' onClick=hapus_minta('$rows[STATUS]','$rows[no_bukti]','$rows[id_minta]')>";
		$i++;
		$dt.=$rows["id"].'|'.$rows['jenis_layanan'].'|'.$rows['parent_id'].'|'.$rows['kode_ak'].chr(3).number_format($i,0,",","").chr(3).$rows["tgl1"].chr(3).$rows["no_bukti"].chr(3).$rows["UNIT_NAME"].chr(3).$rows["NAMA"].chr(3).$rows["STATUS1"].chr(3).$gubah."|".$ghapus.chr(6);
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