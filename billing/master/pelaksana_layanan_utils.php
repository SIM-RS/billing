<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//untuk tab2
$idUser=$_REQUEST["idUser"];
$id=$_REQUEST["id"];
$nip=$_REQUEST["nip"];
$sip=$_REQUEST["sip"];
$nama=$_REQUEST["nama"];
$tmpLhr=$_REQUEST["tmpLhr"];
$tglLhr=tglSQL($_REQUEST["tglLhr"]);
$alamat=$_REQUEST["alamat"];				
$tlp=$_REQUEST["tlp"];
$hp=$_REQUEST["hp"];
$sex=$_REQUEST["sex"];
$agama=$_REQUEST["agama"];
$cmbStatus=$_REQUEST["cmbStatus"];
$peg=$_REQUEST["peg"];
$peg2=$_REQUEST["peg2"];
$spe=$_REQUEST["spe"];
$flag=$_REQUEST["flag"];

//$unit=$_REQUEST["unitId"];
$uid=$_REQUEST["uid"];
$pass=$_REQUEST["pass"];
$conPass=$_REQUEST["conPass"];
$aktif=$_REQUEST["chAktif"];
$userId = $_REQUEST['userId'];
//

$stref=8;

switch(strtolower($_REQUEST['act'])){
	case 'tambah':		
		switch(strtolower($_REQUEST['grd'])){
			case 'tab1':
				$sqlTambah="insert into b_ms_reference (nama,stref,aktif,flag)
				values('".$_REQUEST['spe']."','".$stref."','".$_REQUEST['aktif']."','$flag')";		
				$rs=mysql_query($sqlTambah);		
				break;
			case 'tab2':
				$sqlTambah="insert into b_ms_pegawai (username,pwd,spesialisasi_id,nip,sip,nama,sex,agama,tmpt_lahir,tgl_lahir,alamat,telp,hp,staplikasi,pegawai_status_id,pegawai_jenis,tgl_act,user_act,aktif,flag)
				values('$uid',password('$pass'),'$spe','$nip','$sip','$nama','$sex','$agama','$tmpLhr','$tglLhr','$alamat','$tlp','$hp','$cmbStatus','$peg','$peg2',now(),'$idUser','$aktif','$flag')";
				$rs=mysql_query($sqlTambah);
				$sqlPegId = "SELECT MAX(id) AS id FROM b_ms_pegawai order by id desc limit 1";
				$rsPeg = mysql_query($sqlPegId);
				$rwPeg = mysql_fetch_array($rsPeg);
				$idPeg = $rwPeg['id'];
				//$sqlUnit = "INSERT INTO b_ms_pegawai_unit (unit_id,ms_pegawai_id) values('".$_REQUEST['unitId']."','".$idPeg."')";
				//$rsUnit=mysql_query($sqlUnit);
				break;
			case 'tab3b':
				$id=explode(",",$_REQUEST['id']);
				for($i=0;$i<(sizeof($id)-1);$i++){
                              $sqlCek="select * from b_ms_pegawai_unit where ms_pegawai_id='".$id[$i]."' and unit_id='".$_REQUEST['unitId']."'";                              
					$rsCek=mysql_query($sqlCek);
					if(mysql_num_rows($rsCek)==0){
						$sqlTambah="insert into b_ms_pegawai_unit (ms_pegawai_id,unit_id,flag) values('".$id[$i]."','".$_REQUEST['unitId']."','".$_REQUEST['flag']."')";
						$rs=mysql_query($sqlTambah);
					}
				}				
				break;
		}
		//echo $sqlTambah."<br/>";
		//$rs=mysql_query($sqlTambah);
		break;
	case 'hapus':
		switch(strtolower($_REQUEST['grd'])){
			case 'tab1':
				$sqlHapus="SELECT id FROM b_ms_pegawai mp WHERE spesialisasi_id='".$_REQUEST['rowid']."' LIMIT 1";
				$rsHapus=mysql_query($sqlHapus);
				if (mysql_num_rows($rsHapus)>0){
				}else{
					$sqlHapus="delete from b_ms_reference where id='".$_REQUEST['rowid']."'";
					mysql_query($sqlHapus);
				}
				break;
			case 'tab2':
				$sqlHapus="SELECT t.id FROM b_tindakan t WHERE t.user_id='".$_REQUEST['rowid']."' LIMIT 1";
				$rsHapus=mysql_query($sqlHapus);
				if (mysql_num_rows($rsHapus)>0){
				}else{
					$sqlHapus="SELECT tda.id FROM b_tindakan_dokter_anastesi tda WHERE tda.dokter_id='".$_REQUEST['rowid']."' LIMIT 1";
					$rsHapus=mysql_query($sqlHapus);
					if (mysql_num_rows($rsHapus)>0){
					}else{
						$sqlHapus="delete from b_ms_pegawai where id='".$_REQUEST['rowid']."'";
						mysql_query($sqlHapus);
					}
				}
				break;
			case 'tab3b':
				$id=explode(",",$_REQUEST['id']);
				for($i=0;$i<(sizeof($id)-1);$i++){
				   $sqlHapus="delete from b_ms_pegawai_unit where id='".$id[$i]."'";
				   mysql_query($sqlHapus);
				}
				break;
		}
		break;
	case 'simpan':
		switch(strtolower($_REQUEST['grd'])){
			case 'tab1':
				$sqlSimpan="update b_ms_reference set nama='".$_REQUEST['spe']."',stref='".$stref."',aktif='".$_REQUEST['aktif']."',flag='".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";		
				break;
			case 'tab2':
				$sqlSimpan="update b_ms_pegawai set username='$uid',";
				$sqlSimpan.=($pass!='')?"pwd=password('$pass'),":"";
				$sqlSimpan.="spesialisasi_id='$spe',nip='$nip', sip='$sip', nama='$nama',sex='$sex',agama='$agama',tmpt_lahir='$tmpLhr',tgl_lahir='$tglLhr',alamat='$alamat',telp='$tlp',hp='$hp',staplikasi='$cmbStatus',pegawai_status_id='$peg',pegawai_jenis='$peg2',tgl_act=now(),user_act=$idUser,aktif='$aktif',flag='$flag' where id='$id'";		
				break;
		}
		//echo $sqlSimpan."<br/>";
		$rs=mysql_query($sqlSimpan);
		break;
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=$filter[0]." like '%".$filter[1]."%'";
}
if ($sorting==""){
	switch(strtolower($_REQUEST['grd'])){
		case 'tab1':
			$sorting="nama"; //default sort
		break;
		case 'tab2':
			$sorting="nama"; //default sort
		break;
		case 'tab3a':
			$sorting="nama";
			break;
		case 'tab3b':
			$sorting="nama";
			break;
	}
}
switch(strtolower($_REQUEST['grd'])){
	case 'tab1':
		$sql="SELECT id,nama,IF(aktif=1,'Aktif','Tidak') AS aktif, flag FROM b_ms_reference where stref=8 ".(($filter!='')?"and $filter":"")." order by ".$sorting;
		break;
	case 'tab2':
		$sql="SELECT * from (SELECT a.id,nip,sip,a.nama,a.sex,a.agama,a.tmpt_lahir,a.staplikasi,a.spesialisasi_id,b_ms_reference.nama as snama,
			a.tgl_lahir,a.alamat,a.telp,a.hp,a.pegawai_status_id,a.username,a.aktif,a.pegawai_jenis
			FROM b_ms_pegawai a 
			left JOIN b_ms_reference ON b_ms_reference.id = a.spesialisasi_id) as t1 ".(($filter!='')?"where $filter":"")." order by ".$sorting;
		break;
	case 'tab3b':
		$sql="SELECT b.id,p.nama FROM b_ms_pegawai_unit b 
inner join b_ms_pegawai p on b.ms_pegawai_id=p.id
where b.unit_id='".$_REQUEST['unitId']."' and spesialisasi_id<>0 ".(($filter!='')?"and $filter":"")." order by ".$sorting;
		break;
	case 'tab3a':
		$sql="select * from (select t1.*,t2.id as id2 from (SELECT p.* FROM b_ms_pegawai p where spesialisasi_id<>0) as t1
left join (SELECT p.* FROM b_ms_pegawai_unit b 
inner join b_ms_pegawai p on b.ms_pegawai_id=p.id
where b.unit_id='".$_REQUEST['unitId']."' and spesialisasi_id<>0) as t2 on t1.id=t2.id) as t3 where id2 is null ".(($filter!='')?"and $filter":"")." order by ".$sorting;
		break;
}

// echo $sql."<br>";
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
switch(strtolower($_REQUEST['grd'])){
	case 'tab1':
		while ($rows=mysql_fetch_array($rs)){
			$i++;
			$dt.=$rows["id"].chr(3).$i.chr(3).$rows["nama"].chr(3).$rows["aktif"].chr(6);
		}
		break;
	case 'tab2':
		while ($rows=mysql_fetch_array($rs)){
			$i++;
			$dt.=$rows["id"]."|".$rows["staplikasi"]."|".$rows["sex"]."|".$rows["agama"]."|".$rows["tmpt_lahir"]."|".tglSQL($rows["tgl_lahir"])."|".$rows["alamat"]."|".$rows["telp"]."|".$rows["hp"]."|".$rows["spesialisasi_id"]."|".$rows["pegawai_status_id"]."|".$rows["unit_id"]."|".$rows["aktif"]."|".$rows["username"]."|".$rows["pegawai_jenis"]."|".
			chr(3).$i.chr(3).$rows["nip"].chr(3).$rows["sip"].chr(3).$rows["nama"].chr(3).$rows["snama"].chr(6);
		}
		break;
	case 'tab3b':
		while ($rows=mysql_fetch_array($rs)){			
			$dt.=$rows["id"].chr(3)."0".chr(3).$rows["nama"].chr(6);
		}
		break;
	case 'tab3a':
		while ($rows=mysql_fetch_array($rs)){			
			$dt.=$rows["id"].chr(3)."0".chr(3).$rows["nama"].chr(6);
		}
		break;
}

if ($dt!=$totpage.chr(5)){
		$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']);
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
