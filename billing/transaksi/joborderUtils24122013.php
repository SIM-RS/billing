<?php 
include("../koneksi/konek.php");
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="b.id";
$defaultsort1="kode";
$defaultsort2="kodebarang";
$defaultsortX="jo.id";
$sorting=$_REQUEST["sorting"];
$sorting1=$_REQUEST["sorting"];
$sorting2=$_REQUEST["sorting"];
$sortingX=$_REQUEST["sorting"];
//$sortingX=" jo.".$sortingX."";
$filter=$_REQUEST["filter"];

$tipe=$_REQUEST["tipe"];
if($tipe=="txtAlat"){$job=" AND jo.tipe_jo=0";$job2=0;}elseif($tipe=="txtLaundry"){$job=" AND jo.tipe_jo=1";$job2=1;}

$ptgz=$_REQUEST["ptgz"];
$petugas=$_REQUEST["petugas"];
//$z=mysql_num_rows(mysql_query("select * from b_ms_group_petugas where ms_group_id=55 and ms_pegawai_id='".$petugas."'"));
$z=$_REQUEST["asal"];
if($z==1){
$ptgs="where 0=0 ";
}else{
$ptgs="where mgp.ms_pegawai_id='".$petugas."' ";	
}

$tipeJo=$_REQUEST["tipejo"];
$tipeJob=" and jo.tipe_jo='".$tipeJo."' ";

$stOrd=$_GET['stOrd'];
if($stOrd!=null){$st=" and jo.status_jo like '%".$stOrd."%'";}else{$st=" and 0=0";}

//$bln=$_GET['bln'];
$blnX=$_GET['bln'];
if($blnX!=null){$bln=$blnX;}else{$bln=date('m');}
if($bln!=null){$b=" and MONTH(jo.tgl_jo) = '".$bln."'";}else{$b=" and 0=0";}

//$thn=$_GET['thn'];
$thnX=$_GET['thn'];
if($thnX!=null){$thn=$thnX;}else{$thn=date('Y');}
if($thn!=null){$t=" and YEAR(jo.tgl_jo) = '".$thn."'";}else{$t=" and 0=0";}


//===============================
$kd=$_GET['kd'];
$nm=$_GET['nm'];
$id=$_GET['id'];
$msg="";
//===============================
switch(strtolower($_REQUEST['act'])){
	case 'simpan':
		$sql1="INSERT INTO ask_ms_tindakan (kode,nama) VALUES ('$kd','$nm')";
		mysql_query($sql1);
		break;
	case 'update':
		$sql2="UPDATE ask_ms_tindakan SET kode='$kd',nama='$nm' WHERE id='$id'";
		mysql_query($sql2);
		break;
	case 'hapus':
		$sql3="DELETE FROM ask_ms_tindakan WHERE id='$id'";
		mysql_query($sql3);
		break;
}
$idNic=$_GET['idNic'];
$idTind=$_GET['idTind'];
$id1=$_GET['id'];

$idUnit=$_GET['idUnit'];
$idAlat=$_GET['idAlat'];
$kdOrder=$_GET['kdOrder'];

$tglOrder=$_GET['tglOrder'];
$Or=explode("-",$tglOrder);
$tglOrder=$Or[2]."-".$Or[1]."-".$Or[0];
$tglSelesai=$_GET['tglSelesai'];
$Sel=explode("-",$tglSelesai);
$tglSelesai=$Sel[2]."-".$Sel[1]."-".$Sel[0];

$tipeOrder=$_GET['tipeOrder'];
$statusOrder=$_GET['statusOrder'];
if($statusOrder==1){
$stats="NOW()";
}else{$stats="''";}

$jmlh=$_GET['jmlh'];
$idPtgs=$_GET['idPtgs'];

	//$z=mysql_num_rows(mysql_query("select * from b_ms_group_petugas where ms_group_id=55 and ms_pegawai_id='".$idPtgs."'"));
	//ms_group_id=6  ->  Hanya petugas CSSD Laundry yg bisa buka
	$z=$_REQUEST["asal"];
	if($z==1){ 
	$veri="'".$idPtgs."'";
	}else{$veri="''";}

if($_REQUEST['grdTindCic']=='1'){
	switch(strtolower($_REQUEST['act1'])){
		case 'simpan':
			$sql5="SELECT * FROM $dbcssd.cssd_job_order WHERE unit_id = '$idUnit' AND barang_id = '$idAlat' AND user_jo = '$idPtgs' AND status_jo <> 3";
			//echo $sql5;
			$rs1=mysql_query($sql5);
			if (mysql_num_rows($rs1)>0){
				$msg="Data sudah ada";
			}else{
				$sql1="INSERT INTO $dbcssd.cssd_job_order 
(tgl_jo,no_jo,unit_id,barang_id,qty,tgl_act_jo,user_jo,tipe_jo) VALUES 
('$tglOrder','$kdOrder','$idUnit','$idAlat','$jmlh',NOW(),'$idPtgs','$job2')";
				//echo $sql1;
				mysql_query($sql1);
				$img="";
			}
			break;
		case 'simpan2':
			$sql5="SELECT * FROM $dbcssd.cssd_job_order WHERE unit_id = '$idUnit' AND barang_id = '$idAlat' AND user_jo = '$idPtgs' AND tipe_jo=1 AND status_jo <> 3";
			//echo $sql5;
			$rs1=mysql_query($sql5);
			if (mysql_num_rows($rs1)>0){
				$msg="Data sudah ada";
			}else{
				$sql1="INSERT INTO $dbcssd.cssd_job_order 
(tgl_jo,no_jo,unit_id,barang_id,qty,tgl_act_jo,user_jo,tipe_jo) VALUES 
('$tglOrder','$kdOrder','$idUnit','$idAlat','$jmlh',NOW(),'$idPtgs','1')";
				//echo $sql1;
				mysql_query($sql1);
				$img="";
			}
			break;
		case 'update':
			$sql2="UPDATE $dbcssd.cssd_job_order SET
tgl_jo='$tglOrder',
no_jo='$kdOrder',
unit_id='$idUnit',
barang_id='$idAlat',
qty='$jmlh',
tipe_jo='$job2',
tgl_act_jo=NOW()
WHERE id='$id1'";
			//echo $sql2;
			mysql_query($sql2);
			break;
		case 'hapus':
			$sql3="DELETE FROM $dbcssd.cssd_job_order WHERE id='$id1'";
			mysql_query($sql3);
			break;
	}
}

/*if($statusOrder==0)
{$jo=1;
}elseif($statusOrder==1)
{$jo=2;
}*/
$jo=$statusOrder;

$kdWo=$_GET['kdWo'];

if($_REQUEST['cssd']=='1'){
$upd="UPDATE $dbcssd.cssd_job_order SET
no_wo='$kdWo',
status_jo='$jo',
user_act=$veri,
tgl_selesai='$tglSelesai',
tgl_selesai_act=$stats,
tgl_act_jo=NOW()
WHERE id='$id1'";
	//echo $upd;
	mysql_query($upd);
}

if ($sorting==""){
	$sorting=$defaultsort;
}
if ($sorting1==""){
	$sorting1=$defaultsort1;
}
if ($sorting2==""){
	$sorting2=$defaultsort2;
}
if ($sortingX==""){
	$sortingX=$defaultsortX;
}

switch($grd){
	case "alat":
		if ($filter!=""){
			$filter=explode("|",$filter);
			$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
		}
		/*$sql="SELECT id,kode,nama FROM ask_ms_tindakan".$filter." order by ".$sorting2;*/
		$sql="SELECT mb.idbarang, mb.kodebarang, mb.namabarang, mb.idsatuan
FROM $dbcssd.cssd_ms_alat ma
LEFT JOIN $dbaset.as_ms_barang mb
ON mb.idbarang = ma.idbarang ".$filter." ORDER BY ".$sorting2;
		break;
	case "unit":
		if ($filter!=""){
			$filter=explode("|",$filter);
			$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
		}
		/*$sql="SELECT b.id,a.id id_tindakan,c.id idNic,a.kode kdTind,a.nama nmTind,c.kode kdNic,c.nama nmNic FROM ask_ms_tindakan a INNER JOIN ask_ms_tindakan_nic b ON a.id=b.ms_tindakan_id INNER JOIN ask_ms_nic c ON b.ms_nic_id=c.id".$filter." order by ".$sorting;*/
		$sql="SELECT 
    mu.id,
    mu.kode,
    mu.nama 
  FROM
    b_ms_unit mu 
    LEFT JOIN b_ms_pegawai_unit pu 
      ON pu.unit_id = mu.id  
  WHERE mu.islast = 1 
    AND mu.level = 2 
    AND mu.kategori = 2
    AND pu.ms_pegawai_id = ".$ptgz.$filter." ORDER BY ".$sorting1;
		//echo $sql;
		break;
	case "order":
		if ($filter!=""){
			$filter=explode("|",$filter);
			$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
		}
		/*$sql="SELECT id,kode,nama FROM ask_ms_nic WHERE level=1".$filter." order by ".$sorting1;*/
		$sql="SELECT  jo.id idjo, jo.no_wo, DATE_FORMAT(jo.tgl_jo, '%d-%m-%Y') tgl_jo, DATE_FORMAT(jo.tgl_selesai, '%d-%m-%Y') tgl_selesai, jo.no_jo, jo.unit_id, IF(jo.tipe_jo = 0, 'Alat Kedokteran', 'Pakaian') tipe, jo.tipe_jo, jo.barang_id, jo.qty, jo.tgl_act_jo, jo.user_jo, jo.tgl_selesai_act, jo.user_act, IF(jo.status_jo = 0, 'Permohonan', IF(jo.status_jo = 1, 'Proses', IF(jo.status_jo = 2, 'Selesai', 'Dikirim'))) status, jo.status_jo, mb.kodebarang, mb.namabarang, mu.kode, mu.nama, p.nama namauser
FROM $dbcssd.cssd_job_order jo
LEFT JOIN $dbcssd.cssd_ms_alat ma
ON ma.idbarang = jo.barang_id
LEFT JOIN $dbaset.as_ms_barang mb
ON mb.idbarang = ma.idbarang
LEFT JOIN b_ms_unit mu
ON mu.id = jo.unit_id
LEFT JOIN b_ms_group_petugas mgp
ON mgp.ms_pegawai_id = jo.user_jo
LEFT JOIN b_ms_pegawai p
ON p.id = mgp.ms_pegawai_id ".$ptgs.$filter.$st.$job.$b.$t." ORDER BY ".$sortingX;
		echo $sql;
		break;
	case "order2":
		if ($filter!=""){
			$filter=explode("|",$filter);
			$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
		}
		/*$sql="SELECT id,kode,nama FROM ask_ms_nic WHERE level=1".$filter." order by ".$sorting1;*/
		$sql="SELECT  jo.id idjo, jo.no_wo, DATE_FORMAT(jo.tgl_jo, '%d-%m-%Y') tgl_jo, DATE_FORMAT(jo.tgl_selesai, '%d-%m-%Y') tgl_selesai, jo.no_jo, jo.unit_id, IF(jo.tipe_jo = 0, 'Alat Kedokteran', 'Pakaian') tipe, jo.tipe_jo, jo.barang_id, jo.qty, jo.tgl_act_jo, jo.user_jo, jo.tgl_selesai_act, jo.user_act, IF(jo.status_jo = 0, 'Permohonan', IF(jo.status_jo = 1, 'Proses', IF(jo.status_jo = 2, 'Selesai', 'Dikirim'))) status, jo.status_jo, mb.kodebarang, mb.namabarang, mu.kode, mu.nama, p.nama namauser
FROM $dbcssd.cssd_job_order jo
LEFT JOIN $dbcssd.cssd_ms_alat ma
ON ma.idbarang = jo.barang_id
LEFT JOIN $dbaset.as_ms_barang mb
ON mb.idbarang = ma.idbarang
LEFT JOIN b_ms_unit mu
ON mu.id = jo.unit_id
LEFT JOIN b_ms_group_petugas mgp
ON mgp.ms_pegawai_id = jo.user_jo
LEFT JOIN b_ms_pegawai p
ON p.id = mgp.ms_pegawai_id ".$ptgs.$filter.$st.$job.$b.$t." ORDER BY ".$sortingX;
		//echo $sql;
		break;
}
//echo $sql."<br>";
$perpage=100;
$rs=mysql_query($sql);
$jmldata=mysql_num_rows($rs);
if ($page=="" || $page=="0") $page=1;
$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
$sql=$sql." limit $tpage,$perpage";
$rs=mysql_query($sql);
$i=($page-1)*$perpage;
$dt=$totpage.chr(5);

switch($grd){
	case "alat":
	while ($rows=mysql_fetch_array($rs)){
		$id=$rows['idbarang']."|".$rows['kodebarang']."|".$rows['namabarang'];
		$i++;
		$dt.=$id.chr(3).$i.chr(3).$rows["kodebarang"].chr(3).$rows["namabarang"].chr(6);
	}
	break;
	case "unit":
	while ($rows=mysql_fetch_array($rs)){
		$id=$rows['id']."|".$rows['kode']."|".$rows['nama'];
		$i++;
		$dt.=$id.chr(3).$i.chr(3).$rows["kode"].chr(3).$rows["nama"].chr(6);
	}
	break;
	case "order":
	while ($rows=mysql_fetch_array($rs)){
		$id=$rows['idjo']."|".$rows['tipe_jo']."|".$rows['kode']."|".$rows['unit_id']."|".$rows['kodebarang']."|".$rows['barang_id']."|".$rows['user_jo']."|".$rows['user_act']."|".$rows['status_jo']."|".$rows['tgl_selesai'];
		$i++;
		$dt.=$id.chr(3).$i.chr(3).$rows["tgl_jo"].chr(3).$rows["no_jo"].chr(3).$rows["nama"].chr(3).$rows["namabarang"].chr(3).$rows["namauser"].chr(3).$rows["qty"].chr(3).$rows["tgl_selesai"].chr(3).$rows["no_wo"].chr(3).$rows["status"].chr(6);
	}
	break;
	case "order2":
	$j=1;
	while ($rows=mysql_fetch_array($rs)){
		$id=$rows['idjo']."|".$rows['status_jo']."|".$rows['tgl_selesai']."|".$rows['no_wo'];
		
		if($rows['status_jo']==0){
		$swt="<a style='cursor:pointer; font-family:Verdana, Arial, Helvetica, sans-serif; color:#0033FF' onClick='proses(".($j).")' title='Proses'><img src='../icon/proses.jpg' width='20' height='20' align='absmiddle'>&nbsp;</a>";}elseif($rows['status_jo']==1){
		$swt="<a style='cursor:pointer; font-family:Verdana, Arial, Helvetica, sans-serif; color:#0033FF' onClick='selesai(".($j).")' title='Selesai'><img src='../icon/end.jpg' width='20' height='20' align='absmiddle'>&nbsp;</a>";}elseif($rows['status_jo']==2){
		$swt="<a style='cursor:pointer; font-family:Verdana, Arial, Helvetica, sans-serif; color:#0033FF' onClick='selesai(".($j).")' title='Selesai'><img src='../icon/send.png' width='20' height='20' align='absmiddle'>&nbsp;</a>";}elseif($rows['status_jo']==3){$swt="Dikirim";}
		$dt.=$id.chr(3).$i.chr(3).$rows["tgl_jo"].chr(3).$rows["no_jo"].chr(3).$rows["tgl_selesai"].chr(3).$rows["no_wo"].chr(3).$rows["nama"].chr(3).$rows["namabarang"].chr(3).$rows["namauser"].chr(3).$rows["qty"].chr(3).$rows["status"].chr(3).$swt.chr(6);
		$j++;
		$i++;
	}
	break;	
}

if ($dt!=$totpage.chr(5)){
	$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act1'])."*|*".$msg;
	$dt=str_replace('"','\"',$dt);
}
mysql_free_result($rs);
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