<?php
include("../../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="kode";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$idunit = $_REQUEST['idunit'];
$ischecked = $_REQUEST['ischecked'];
$cabang = ($_REQUEST['cabang'] > 0) ? $_REQUEST['cabang'] : 1 ;
//===============================
$statusProses='';
$alasan='';
$grd = $_REQUEST['grd'];
$id_unit = $_REQUEST['id_unit'];
$id_user = $_REQUEST['id_user'];
$id_kunjungan = $_REQUEST['id_kunjungan'];
$id_pelayanan = $_REQUEST['id_pelayanan'];
$host = 'http://'.$_SERVER['HTTP_HOST'].'/simrs-pelindo/billing/';

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

	switch($grd){
		case "rm":
			$sql="SELECT * FROM b_ms_rekam_medis";
		break;
		case "rmUnit":
			$sql = "SELECT * FROM b_ms_rekam_medis";
		break;
		case "getRm":
			$sql = "SELECT rm.nama_rm,rm.link FROM b_ms_rm_unit ru LEFT JOIN b_ms_rekam_medis rm ON rm.id = ru.id_rm WHERE id_unit = {$id_unit}";
		break;
		default:
			$sql="SELECT * FROM (SELECT mu.id,mu.kode,mu.nama,mu1.nama jenis_layanan,IF(mu.inap=1,'Ya','Tidak') AS inap 
			FROM b_ms_unit mu INNER JOIN b_ms_unit mu1 ON mu.parent_id=mu1.id 
			WHERE mu.kategori=2 AND mu.level=2 AND mu.aktif=1 AND mu.cabang_id = '{$cabang}') AS gab".$filter." ORDER BY ".$sorting;
		break;
	}
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

	switch($grd){
		case "rm":
			while($rows = mysql_fetch_assoc($rs)){
				$i++;
				$btn = "<button class='btn btn-sm btn-danger' style='height:20px;font-size:9px;' type='button' onclick='deleteRm(this.value)' value = '".$rows['id']."'>Hapus</button>";
				$dt .= $rows['id'].'|'.$rows['nama_rm'].'|'.$rows['link'].chr(3).$rows['nama_rm'].chr(3).$rows['link'].chr(3).$btn.chr(6);
			}
		break;
		case "rmUnit":
			while($rows = mysql_fetch_assoc($rs)){
				$i++;
				$val = $id_unit.'|'.$rows['id_rm'];
				$sqlCheck = mysql_query("SELECT * FROM b_ms_rm_unit WHERE id_unit = {$id_unit} AND id_rm = {$rows['id']}");
				if(mysql_num_rows($sqlCheck) > 0) $checked = 'checked';
				else $checked = '';
				$dt .= $id_unit.'|'.$rows['id'].chr(3)."<input type='checkbox' value='".$id_unit.'|'.$rows['id']."' ".$checked." onclick='addRmUnit(this,this.value)'>".chr(3).$rows['nama_rm'].chr(6);
			}
			break;
		case "getRm":
			while($rows = mysql_fetch_assoc($rs)){
				if($rows['nama_rm'] == '') continue;
				echo "<div class='col-4'>";
					$tambahan = "?idKunj=".$id_kunjungan."&idPel=".$id_pelayanan."&idUser=".$id_user."&tmpLay=".$id_unit;
					echo "<a href='".$host.$rows['link'].$tambahan."' target='_blank' class='btn btn-sm btn-primary'>".$rows['nama_rm']."</a>";
				echo "</div>";
			}
			exit;
		break;
		default:
			while ($rows=mysql_fetch_array($rs)){
				$i++;
				$stchecked="";
				$sql="SELECT * FROM b_ms_unit_loket WHERE id_loket=".$_REQUEST["idloket"]." AND id_unit_layanan=".$rows["id"];
				$rscheck=mysql_query($sql);
				if (mysql_num_rows($rscheck)>0){
					$stchecked="checked='checked'";
				}
				$btn = "<button class='btn btn-success btn-sm' style='height:20px;font-size:9px;' type='button' onclick='loadRmUnit(this.value)' value='".$rows['id']."' data-target='#rmUnit' data-toggle='modal'>SETUP RM</button>";
				$dt.=$rows["id"].chr(3).$rows["kode"].chr(3).$rows["nama"].chr(3).$rows["jenis_layanan"].chr(3).$rows["inap"].chr(3).$btn.chr(6);
			}
		break;
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