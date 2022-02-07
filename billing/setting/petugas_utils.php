<?php
include("../koneksi/konek.php");
$grdgrp=$_REQUEST['grdgrp'];
$id=$_REQUEST['id'];

//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="kode";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$userId = $_REQUEST['userId'];
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$tgl = tglSQL($_REQUEST['tgl_lahir']); 
$aktif = 1;
//===============================


switch(strtolower($_REQUEST['act'])){
	case 'tambah':
		$kode = explode('|',$_REQUEST['pegawai_jenis']);
		$agama = explode('|',$_REQUEST['agama']);
		$pegStatus = explode('|',$_REQUEST['pegawai_status_id']);
		$sqlTambah = "INSERT INTO b_ms_pegawai (nip,nama,tmpt_lahir,tgl_lahir,alamat,telp,sex,agama,kode_agama,staplikasi,spesialisasi_id,pegawai_jenis,kode_jenis,pegawai_status_id,peg_status_kode,username,pwd,tgl_act,user_act,aktif)
		values('".$_REQUEST['nip']."','".$_REQUEST['nama']."','".$_REQUEST['tmpt_lahir']."','".$tgl."','".$_REQUEST['alamat']."','".$_REQUEST['telp']."','".$_REQUEST['sex']."','".$agama[0]."','".$agama[1]."','".$_REQUEST['staplikasi']."',
		'0','".$kode[0]."','".$kode[1]."','".$pegStatus[0]."','".$pegStatus[1]."','".$_REQUEST['username']."',password('".$_REQUEST['pwd']."'),'".$tglact."','".$userId."','".$aktif."')";
		$rs=mysql_query($sqlTambah);
		$sqlPegId = "SELECT MAX(id) AS id FROM b_ms_pegawai order by id desc limit 1";
		$rsPeg = mysql_query($sqlPegId);
		$rwPeg = mysql_fetch_array($rsPeg);
		$idPeg = $rwPeg['id'];
		$sqlGrp = "INSERT INTO b_ms_group_petugas (ms_group_id,ms_pegawai_id) values('".$_REQUEST['idgroup']."','".$idPeg."')";
		$rsGrp=mysql_query($sqlGrp);
		break;
		
	case 'simpan':
		$sqlSimpan="UPDATE b_ms_pegawai SET nip = '".$_REQUEST['nip']."', nama = '".$_REQUEST['nama']."', tmpt_lahir = '".$_REQUEST['tmpt_lahir']."', tgl_lahir = '".$tgl."', alamat = '".$_REQUEST['alamat']."',
		telp = '".$_REQUEST['telp']."', sex = '".$_REQUEST['sex']."', agama = '".$_REQUEST['agama']."', staplikasi = '".$_REQUEST['staplikasi']."',pegawai_jenis = '".$_REQUEST['pegawai_jenis']."',
		pegawai_status_id = '".$_REQUEST['pegawai_status_id']."', username = '".$_REQUEST['username']."'".($_REQUEST['pwd']!=""?",pwd = password('".$_REQUEST['pwd']."')":"")." WHERE id = '".$_REQUEST['rowid']."'";
		//echo $sqlSimpan."<br>";
		$rs=mysql_query($sqlSimpan);
		$sqlGrpUp = "UPDATE b_ms_group_petugas SET ms_group_id = '".$_REQUEST['kodegroup']."' where ms_pegawai_id = '".$_GET['rowid']."' and ms_group_id='".$_GET['id']."'";
		$rs = mysql_query($sqlGrpUp);
		break;
		
	case 'hapus':
		$sqlHapus="delete from b_ms_group_petugas where ms_pegawai_id='".$_REQUEST['rowid']."'";
		mysql_query($sqlHapus);
		$sqlHapus="delete from b_ms_pegawai where id='".$_REQUEST['rowid']."'";
		mysql_query($sqlHapus);
		break;
	
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}

if($grdgrp == "true")
{
	$sql="select * from (SELECT p.id as pegId, p.nip, p.nama, p.aktif, p.kode AS kdpegawai, gp.kode, p.tmpt_lahir, p.tgl_lahir, p.alamat, p.telp, p.sex, p.agama, p.staplikasi, p.spesialisasi_id, p.pegawai_jenis,
		p.pegawai_status_id, g.kode as kodegroup, p.username, p.pwd, g.id as groupId
		FROM b_ms_pegawai p
		INNER JOIN b_ms_group_petugas gp ON gp.ms_pegawai_id = p.id
		INNER JOIN b_ms_group g ON g.id = gp.ms_group_id
		WHERE g.id = '".$id."') as t1".$filter." ORDER BY ".$sorting;
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

if($grdgrp == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$sisipan=$rows['pegId']."|".$rows['tmpt_lahir']."|".tglSQL($rows['tgl_lahir'])."|".$rows['alamat']."|".$rows['telp']."|".$rows['sex']."|".$rows['agama']."|".$rows['spesialisasi_id']."|".$rows['pegawai_jenis']."|".$rows['pegawai_status_id']."|".$rows['kodegroup']."|".$rows['username']."|".$rows['pwd']."|".$rows['groupId']."|".$rows['staplikasi'];
		$dt.=$sisipan.chr(3).number_format($i,0,",","").chr(3).$rows["nip"].chr(3).$rows["nama"].chr(3).$rows["aktif"].chr(3).$rows[""].chr(3).$rows["kode"].chr(6);
	}
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