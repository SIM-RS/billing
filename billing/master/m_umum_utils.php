<?php 
include("../koneksi/konek.php");
$grd=$_REQUEST["grd"];
$grd1=$_REQUEST["grd1"];
$grd2=$_REQUEST["grd2"];
$grd3=$_REQUEST["grd3"];
$grd4=$_REQUEST["grd4"];
$grd5=$_REQUEST["grd5"];
$grd6=$_REQUEST["grd6"];
$grd7=$_REQUEST["grd7"];
$grd8=$_REQUEST["grd8"];
$grd9=$_REQUEST["grd9"];
$grd10=$_REQUEST["grd10"];
$grd11=$_REQUEST["grd11"];
$grd12=$_REQUEST["grd12"];
$grd13=$_REQUEST["grd13"];

$grdJK=$_REQUEST["grdJK"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="nama";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

switch(strtolower($_REQUEST['act']))
{
	case 'tambah':
		switch($_REQUEST["ref"])
		{
			case 'Pendidikan':
				$sqlTambah="insert into b_ms_pendidikan (nama,aktif,flag) values('".$_REQUEST['nama']."','".$_REQUEST['aktif']."','".$_REQUEST['flag']."')";
				break;
			
			case 'Pekerjaan':
				$sqlTambah="insert into b_ms_pekerjaan (nama,aktif,flag) values('".$_REQUEST['nama']."','".$_REQUEST['aktif']."','".$_REQUEST['flag']."')";
				break;
				
			case 'Agama':
				$sqlTambah = "INSERT INTO b_ms_agama (agama,aktif,flag) values('".$_REQUEST['agm']."','".$_REQUEST['aktif']."','".$_REQUEST['flag']."')";
				break;
				
			case 'Asal Rujukan':
				$sqlTambah="insert into b_ms_asal_rujukan (nama,aktif,flag) values('".$_REQUEST['nama']."','".$_REQUEST['aktif']."','".$_REQUEST['flag']."')";
				break;
				
			case 'Tujuan Rujukan':
				$sqlTambah="insert into b_ms_tujuan_rujukan (nama,aktif,flag) values('".$_REQUEST['nama']."','".$_REQUEST['aktif']."','".$_REQUEST['flag']."')";
				break;
			
			case 'Cara Keluar':
				$sqlTambah="insert into b_ms_cara_keluar (nama,aktif,flag) values('".$_REQUEST['nama']."','".$_REQUEST['aktif']."','".$_REQUEST['flag']."')";
				break;
			
			case 'Keadaan Keluar':
				$sqlTambah="insert into b_ms_keadaan_keluar (nama,aktif,flag) values('".$_REQUEST['nama']."','".$_REQUEST['aktif']."','".$_REQUEST['flag']."')";
				break;
			
			case 'Cara Bayar':
				$sqlTambah="insert into b_ms_cara_bayar (nama,aktif,flag) values('".$_REQUEST['nama']."','".$_REQUEST['aktif']."','".$_REQUEST['flag']."')";
				break;
			
			case 'Daftar Puskesmas':
				$sqlTambah="insert into b_ms_daftar_puskesmas (nama,aktif,flag) values('".$_REQUEST['nama']."','".$_REQUEST['aktif']."','".$_REQUEST['flag']."')";
				break;
			
			case 'Daftar RS Lain':
				$sqlTambah="insert into b_ms_asal_rumahsakit (nama,aktif,flag) values('".$_REQUEST['nama']."','".$_REQUEST['aktif']."','".$_REQUEST['flag']."')";
				break;
			
			case 'Daftar Dokter Non RS':
				$sqlTambah="insert into b_ms_dokter_nonrs (nama,aktif,flag) values('".$_REQUEST['nama']."','".$_REQUEST['aktif']."','".$_REQUEST['flag']."')";
				break;
				
			case 'Layanan Lain-Lain':
				$sqlTambah="insert into b_ms_layanan_lain (nama,aktif,flag) values('".$_REQUEST['nama']."','".$_REQUEST['aktif']."','".$_REQUEST['flag']."')";
				break;
				
			case 'Jenis Kepegawaian':
				$sqlTambah="insert into b_ms_pegawai_jenis (Nama,aktif,flag) values('".$_REQUEST['nama']."','".$_REQUEST['aktif']."','".$_REQUEST['flag']."')";
				break;
			
			/*case 'Kelompok Pegawai':
				$sqlTambah="insert into b_ms_kelompok (kode,nama,aktif) values('".$_REQUEST['kode']."','".$_REQUEST['nama']."','".$_REQUEST['aktif']."')";
				break;
			
			case 'Data Pegawai':
				$sqlTambah="insert into b_ms_pegawai (unit_id,username,pwd,kelompok_id,nip,nama,sex,agama,tgl_lahir,alamat,telp,hp,marital,nama_ortu,alamat_ortu,nama_suami_istri,aktif)	values('".$_REQUEST['cmbunit']."','".$_REQUEST['user']."','".$_REQUEST['pwd']."','".$_REQUEST['klp']."','".$_REQUEST['nip']."','".$_REQUEST['nama']."','".$_REQUEST['sex']."','".$_REQUEST['agm']."','".tglSQL($_REQUEST['lahir'])."','".$_REQUEST['almt']."','".$_REQUEST['tlp']."','".$_REQUEST['hp']."','".$_REQUEST['stskwn']."','".$_REQUEST['ortu']."','".$_REQUEST['almt_ortu']."','".$_REQUEST['nmsi']."','".$_REQUEST['aktif']."')";
				break;*/
		}
		$rs=mysql_query($sqlTambah);
		break;
		
	case 'simpan':
		switch($_REQUEST["ref"])
		{
			case 'Pendidikan':
				$sqlUpdate="update b_ms_pendidikan set nama='".$_REQUEST['nama']."',aktif='".$_REQUEST['aktif']."',flag='".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";	
				break;
				
			case 'Pekerjaan':
				$sqlUpdate="update b_ms_pekerjaan set nama='".$_REQUEST['nama']."',aktif='".$_REQUEST['aktif']."',flag='".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";	
				break;
			
			case 'Agama':
				$sqlUpdate = "update b_ms_agama SET agama='".$_REQUEST['agm']."',aktif='".$_REQUEST['aktif']."',flag='".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";
				break;
				
			case 'Asal Rujukan':
				$sqlUpdate="update b_ms_asal_rujukan set nama='".$_REQUEST['nama']."',aktif='".$_REQUEST['aktif']."',flag='".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";	
				break;
			
			case 'Tujuan Rujukan':
				$sqlUpdate="update b_ms_tujuan_rujukan set nama='".$_REQUEST['nama']."',aktif='".$_REQUEST['aktif']."',flag='".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";	
				break;
			
			case 'Cara Keluar':
				$sqlUpdate="update b_ms_cara_keluar set nama='".$_REQUEST['nama']."',aktif='".$_REQUEST['aktif']."',flag='".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";	
				break;
			
			case 'Keadaan Keluar':
				$sqlUpdate="update b_ms_keadaan_keluar set nama='".$_REQUEST['nama']."',aktif='".$_REQUEST['aktif']."',flag='".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";	
				break;
			
			case 'Cara Bayar':
				$sqlUpdate="update b_ms_cara_bayar set nama='".$_REQUEST['nama']."',aktif='".$_REQUEST['aktif']."',flag='".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";	
				break;
			
			case 'Daftar Puskesmas':
				$sqlUpdate="update b_ms_daftar_puskesmas set nama='".$_REQUEST['nama']."',aktif='".$_REQUEST['aktif']."',flag='".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";	
				break;
				
				case 'Daftar RS Lain':
				$sqlUpdate="update b_ms_asal_rumahsakit set nama='".$_REQUEST['nama']."',aktif='".$_REQUEST['aktif']."',flag='".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";	
				break;
			
			case 'Daftar Dokter Non RS':
				$sqlUpdate="update b_ms_dokter_nonrs set nama='".$_REQUEST['nama']."',aktif='".$_REQUEST['aktif']."',flag='".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";	
				break;
				
			case 'Layanan Lain-Lain':
				$sqlUpdate="update b_ms_layanan_lain set nama='".$_REQUEST['nama']."',aktif='".$_REQUEST['aktif']."',flag='".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";	
				break;
				
			case 'Jenis Kepegawaian':
				$sqlUpdate="update b_ms_pegawai_jenis set Nama='".$_REQUEST['nama']."',aktif='".$_REQUEST['aktif']."',flag='".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";	
				break;
			
			/*case 'Kelompok Pegawai':
				$sqlUpdate="update b_ms_kelompok set kode='".$_REQUEST['kode']."',nama='".$_REQUEST['nama']."',aktif='".$_REQUEST['aktif']."' where id='".$_REQUEST['id']."'";
				break;
			
			case 'Data Pegawai':
				$sqlUpdate="update b_ms_pegawai set unit_id='".$_REQUEST['cmbunit']."',username='".$_REQUEST['user']."',pwd='".$_REQUEST['pwd']."',kelompok_id='".$_REQUEST['klp']."',nip='".$_REQUEST['nip']."',nama='".$_REQUEST['nama']."',sex='".$_REQUEST['sex']."',agama='".$_REQUEST['agm']."',tgl_lahir='".tglSQL($_REQUEST['lahir'])."',alamat='".$_REQUEST['almt']."',telp='".$_REQUEST['tlp']."',hp='".$_REQUEST['hp']."',marital='".$_REQUEST['stskwn']."',nama_ortu='".$_REQUEST['ortu']."',alamat_ortu='".$_REQUEST['almt_ortu']."',nama_suami_istri='".$_REQUEST['nmsi']."',aktif='".$_REQUEST['aktif']."' where id='".$_REQUEST['id']."'";
				break;*/
		}
		$rs=mysql_query($sqlUpdate);
		break;
		
	case 'hapus':
		switch($_REQUEST["ref"])
		{
			case 'Pendidikan':
				$sqlHapus="delete from b_ms_pendidikan where id='".$_REQUEST['rowid']."'";
				break;
			
			case 'Pekerjaan':
				$sqlHapus="delete from b_ms_pekerjaan where id='".$_REQUEST['rowid']."'";
				break;
				
			case 'Agama':
				$sqlHapus="delete from b_ms_agama where id='".$_REQUEST['rowid']."'";
				break;
			
			case 'Asal Rujukan':
				$sqlHapus="delete from b_ms_asal_rujukan where id='".$_REQUEST['rowid']."'";
				break;
				
			case 'Tujuan Rujukan':
				$sqlHapus="delete from b_ms_tujuan_rujukan where id='".$_REQUEST['rowid']."'";
				break;
				
			case 'Cara Keluar':
				$sqlHapus="delete from b_ms_cara_keluar where id='".$_REQUEST['rowid']."'";
				break;
			
			case 'Keadaan Keluar':
				$sqlHapus="delete from b_ms_keadaan_keluar where id='".$_REQUEST['rowid']."'";
				break;
			
			case 'Cara Bayar':
				$sqlHapus="delete from b_ms_cara_bayar where id='".$_REQUEST['rowid']."'";
				break;
			
			case 'Daftar Puskesmas':
				$sqlHapus="delete from b_ms_daftar_puskesmas where id='".$_REQUEST['rowid']."'";
				break;
				
			case 'Daftar RS Lain':
				$sqlHapus="delete from b_ms_asal_rumahsakit where id='".$_REQUEST['rowid']."'";
				break;
			
			case 'Daftar Dokter Non RS':
				$sqlHapus="delete from b_ms_dokter_nonrs where id='".$_REQUEST['rowid']."'";
				break;
				
			case 'Layanan Lain-Lain':
				$sqlHapus="delete from b_ms_layanan_lain where id='".$_REQUEST['rowid']."'";
				break;
				
			case 'Jenis Kepegawaian':
				$sqlHapus="delete from b_ms_pegawai_jenis where id='".$_REQUEST['rowid']."'";
				break;
			
			/*case 'Kelompok Pegawai':
				$sqlHapus="delete from b_ms_kelompok where id='".$_REQUEST['rowid']."'";
				break;
			
			case 'Data Pegawai':
				$sqlHapus="delete from b_ms_pegawai where id='".$_REQUEST['rowid']."'";
				break;*/
		}
		mysql_query($sqlHapus);
		break;
		
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}
if($sorting==""){
	if($grd2!='true'){
		$sorting=$defaultsort;
	}
	else{
		$sorting='agama';
	}
}

if($grd == "true")
{
	$sql = "SELECT id,nama,if(aktif=1,'Aktif','Tidak') as aktif FROM b_ms_pendidikan ".$filter." order by ".$sorting;	
}
elseif($grd1 == "true")
{
	$sql = "SELECT id,nama,if(aktif=1,'Aktif','Tidak') as aktif FROM b_ms_pekerjaan ".$filter." order by ".$sorting;	
}
elseif($grd2 == "true")
{
	$sql = "SELECT id,agama,if(aktif=1,'Aktif','Tidak') as aktif FROM b_ms_agama ".$filter." order by ".$sorting;	
}
elseif($grd3 == "true")
{
	$sql = "SELECT id,nama,if(aktif=1,'Aktif','Tidak') as aktif FROM b_ms_asal_rujukan ".$filter." order by ".$sorting;	
}
elseif($grd4 == "true")
{
	$sql = "SELECT id,nama,if(aktif=1,'Aktif','Tidak') as aktif FROM b_ms_tujuan_rujukan ".$filter." order by ".$sorting;	
}
elseif($grd5 == "true")
{
	$sql = "SELECT id,nama,if(aktif=1,'Aktif','Tidak') as aktif FROM b_ms_cara_keluar ".$filter." order by ".$sorting;	
}
elseif($grd6 == "true")
{
	$sql = "SELECT id,nama,if(aktif=1,'Aktif','Tidak') as aktif FROM b_ms_keadaan_keluar ".$filter." order by ".$sorting;	
}
elseif($grd7 == "true")
{
	$sql = "SELECT id,nama,if(aktif=1,'Aktif','Tidak') as aktif FROM b_ms_cara_bayar ".$filter." order by ".$sorting;	
}
elseif($grd8 == "true")
{
	$sql = "SELECT id,nama,if(aktif=1,'Aktif','Tidak') as aktif FROM b_ms_daftar_puskesmas ".$filter." order by ".$sorting;	
}

elseif($grd9 == "true")
{
	$sql = "SELECT id,nama,if(aktif=1,'Aktif','Tidak') as aktif FROM b_ms_asal_rumahsakit ".$filter." order by ".$sorting;	
}

elseif($grd10 == "true")
{
	$sql = "SELECT id,nama,if(aktif=1,'Aktif','Tidak') as aktif FROM b_ms_dokter_nonrs ".$filter." order by ".$sorting;	
}
elseif($grd11 == "true")
{
	$sql = "SELECT id,nama,if(aktif=1,'Aktif','Tidak') as aktif FROM b_ms_layanan_lain ".$filter." order by ".$sorting;	
}
elseif($grdJK == "true")
{
	$sql = "SELECT id,Nama as nama,if(aktif=1,'Aktif','Tidak') as aktif FROM b_ms_pegawai_jenis ".$filter." order by ".$sorting;	
}

/*elseif($grd12 == "true")
{
	$sql = "SELECT id,kode,nama,if(aktif=1,'Aktif','Tidak') as aktif FROM b_ms_kelompok ".$filter." order by ".$sorting;
}
elseif($grd13 == "true")
{
	$sql = "SELECT id,unit_id,username,pwd,kelompok_id,nip,nama,sex,agama,tgl_lahir,alamat,telp,hp,marital,nama_ortu,alamat_ortu,nama_suami_istri,if(aktif=1,'Aktif','Tidak') as aktif FROM b_ms_pegawai ".$filter." order by ".$sorting;
}*/


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

if($grd == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["nama"].chr(3).$rows["aktif"].chr(6);
	}
}
elseif($grd1 == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["nama"].chr(3).$rows["aktif"].chr(6);
	}
}
elseif($grd2 == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["agama"].chr(3).$rows["aktif"].chr(6);
	}
}
elseif($grd3 == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["nama"].chr(3).$rows["aktif"].chr(6);
	}
}
elseif($grd4 == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["nama"].chr(3).$rows["aktif"].chr(6);
	}
}
elseif($grd5 == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["nama"].chr(3).$rows["aktif"].chr(6);
	}
}
elseif($grd6 == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["nama"].chr(3).$rows["aktif"].chr(6);
	}
}
elseif($grd7 == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["nama"].chr(3).$rows["aktif"].chr(6);
	}
}
elseif($grd8 == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["nama"].chr(3).$rows["aktif"].chr(6);
	}
}

elseif($grd9 == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["nama"].chr(3).$rows["aktif"].chr(6);
	}
}
elseif($grd10 == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["nama"].chr(3).$rows["aktif"].chr(6);
	}
}
elseif($grd11 == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["nama"].chr(3).$rows["aktif"].chr(6);
	}
}
elseif($grdJK == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["nama"].chr(3).$rows["aktif"].chr(6);
	}
}

/*elseif($grd12 == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3).$i.chr(3).$rows["kode"].chr(3).$rows["nama"].chr(3).$rows["aktif"].chr(6);
	}
	
}
elseif($grd13 == "true")
{
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["nip"].chr(3).$rows["nama"].chr(3).$rows["sex"].chr(3).$rows["agama"].chr(3).$rows["tgl_lahir"].chr(3).$rows["alamat"].chr(3).$rows["telp"].chr(3).$rows["hp"].chr(3).$rows["marital"].chr(3).$rows["nama_ortu"].chr(3).$rows["alamat_ortu"].chr(3).$rows["nama_suami_istri"].chr(3).$rows["username"].chr(3).$rows["pwd"].chr(3).$rows["unit_id"].chr(3).$rows["kelompok_id"].chr(3).$rows["aktif"].chr(6);
	}
	
}*/


if ($dt!=$totpage.chr(5))
{
	$dt=substr($dt,0,strlen($dt)-1);
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