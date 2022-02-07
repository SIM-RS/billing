<?php 
include("../koneksi/konek.php");
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="kode";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================


$sql = "SELECT RIGHT(MAX(kode),3) AS kode FROM b_ms_kso";
$rs = mysql_query($sql);
$rw = mysql_fetch_array($rs);

$kodebr = $rw['kode'] + 1;
$kodebr = sprintf("%03d",$kodebr);
$kodebr = "PENJ".$kodebr ;




switch(strtolower($grd)){
	case '1':
		switch(strtolower($_REQUEST['act'])){
			case 'tambah':
				echo $sqlTambah="insert into b_ms_kso (kode,nama,kepemilikan_id,alamat,telp,fax,kontak,aktif,margin_hjual,flag)
					values('".$kodebr."','".$_REQUEST['nama']."','".$_REQUEST['kpid']."','".$_REQUEST['alamat']."','".$_REQUEST['telp']."','".$_REQUEST['fax']."','".$_REQUEST['kontak']."','".$_REQUEST['caktif']."','".$_REQUEST['margin']."','".$_REQUEST['flag']."')";
				$rs=mysql_query($sqlTambah);
				break;
			case 'hapus':
				$sqlHapus="delete from b_ms_kso where id='".$_REQUEST['rowid']."'";
				mysql_query($sqlHapus);
				break;
			case 'simpan':
				$sqlSimpan = "UPDATE b_ms_kso SET  kode='".$_REQUEST['kode']."',nama='".$_REQUEST['nama']."',kepemilikan_id='".$_REQUEST['kpid']."',alamat='".$_REQUEST['alamat']."',telp='".$_REQUEST['telp']."',fax='".$_REQUEST['fax']."',kontak='".$_REQUEST['kontak']."',aktif='".$_REQUEST['caktif']."', margin_hjual = '".$_REQUEST['margin']."', flag = '".$_REQUEST['flag']."' WHERE id='".$_REQUEST['id']."'";	
				$rs=mysql_query($sqlSimpan);
				break;
		}
		break;
	case '3':
		$id=explode(",",$_REQUEST['id']);
		switch(strtolower($_REQUEST['act'])){
			case 'tambah':
				for($i=0;$i<(sizeof($id)-1);$i++){
					$sqlCek="select * from b_ms_tindakan_tdk_jamin where b_ms_tindakan_id='".$id[$i]."' and b_ms_kso_id='".$_REQUEST['ksoId']."'";
					$rsCek=mysql_query($sqlCek);
					if(mysql_num_rows($rsCek)==0){
						$sqlTambah="insert into b_ms_tindakan_tdk_jamin (b_ms_tindakan_id,b_ms_kso_id,flag)
							values('".$id[$i]."','".$_REQUEST['ksoId']."','".$_REQUEST['flag']."')";
						$rs=mysql_query($sqlTambah);
					}
				}
				break;
			case 'hapus':
				for($i=0;$i<(sizeof($id)-1);$i++){
					$sqlHapus="delete from b_ms_tindakan_tdk_jamin where id='".$id[$i]."'";
					mysql_query($sqlHapus);
				}
				break;
			
		}
		break;
	case '5':		
		switch(strtolower($_REQUEST['act'])){
			case 'tambah':
				$sqlTambah="insert into b_ms_kso_paket_hp (b_ms_kso_id,b_ms_kelas_id,jaminan,flag) values ('".$_REQUEST['ksoId']."','".$_REQUEST['kelas']."','".$_REQUEST['nilai']."','".$_REQUEST['flag']."')";
				mysql_query($sqlTambah);
				break;
			case 'simpan':
				$sqlSimpan="update b_ms_kso_paket_hp set b_ms_kso_id='".$_REQUEST['ksoId']."'
				,b_ms_kelas_id='".$_REQUEST['kelas']."',jaminan='".$_REQUEST['nilai']."', flag = '".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";
				//echo $sqlSimpan."</br>";
				mysql_query($sqlSimpan);
				break;
			case 'hapus':
				$sqlHapus="delete from b_ms_kso_paket_hp where id='".$_REQUEST['rowid']."'";
				mysql_query($sqlHapus);
				break;
		}
		break;
	case '6':
		switch(strtolower($_REQUEST['act'])){
			case 'tambah':
				$sqlTambah="insert into b_ms_kso_paket (kso_id,nama,nilai,paket,instalasi,frekuensi,flag) values ('".$_REQUEST['ksoId']."','".$_REQUEST['nama']."','".$_REQUEST['nilai']."','".$_REQUEST['status']."','".$_REQUEST['instal']."','".$_REQUEST['frekuensi']."','".$_REQUEST['flag']."')";
				mysql_query($sqlTambah);
				break;
			case 'simpan':
				$sqlSimpan="update b_ms_kso_paket set kso_id='".$_REQUEST['ksoId']."'
				,nama='".$_REQUEST['nama']."',nilai='".$_REQUEST['nilai']."'
				,paket='".$_REQUEST['status']."',instalasi='".$_REQUEST['instal']."'
				,frekuensi='".$_REQUEST['frekuensi']."', flag = '".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";
				mysql_query($sqlSimpan);
				break;
			case 'hapus':
				$sqlHapus="delete from b_ms_kso_paket where id='".$_REQUEST['rowid']."'";
				mysql_query($sqlHapus);
				break;
		}
		break;
	case '8':
		$id=explode(",",$_REQUEST['id']);
		switch(strtolower($_REQUEST['act'])){
			case 'tambah':
				for($i=0;$i<(sizeof($id)-1);$i++){
					$sqlCek="select * from b_ms_kso_paket_detail where ms_tindakan_id='".$id[$i]."' and kso_paket_id='".$_REQUEST['paketId']."'";
					$rsCek=mysql_query($sqlCek);
					if(mysql_num_rows($rsCek)==0){
						$sqlTambah="insert into b_ms_kso_paket_detail (ms_tindakan_id,kso_paket_id,flag)
							values('".$id[$i]."','".$_REQUEST['paketId']."','".$_REQUEST['flag']."')";
						$rs=mysql_query($sqlTambah);
					}
				}
				break;
			case 'hapus':
				for($i=0;$i<(sizeof($id)-1);$i++){
					$sqlHapus="delete from b_ms_kso_paket_detail where id='".$id[$i]."'";
					mysql_query($sqlHapus);
				}
				break;
			
		}
		break;
	case '10':
		$id=explode(",",$_REQUEST['id']);
		switch(strtolower($_REQUEST['act'])){
			case 'tambah':
				for($i=0;$i<(sizeof($id)-1);$i++){
					$sqlCek="select * from b_ms_kso_luar_paket where ms_tindakan_id='".$id[$i]."' and kso_id='".$_REQUEST['ksoId']."'";
					$rsCek=mysql_query($sqlCek);
					if(mysql_num_rows($rsCek)==0){
						$sqlTambah="insert into b_ms_kso_luar_paket (ms_tindakan_id,kso_id,flag)
							values('".$id[$i]."','".$_REQUEST['ksoId']."','".$_REQUEST['flag']."')";
						$rs=mysql_query($sqlTambah);
					}
				}
				break;
			case 'hapus':
				for($i=0;$i<(sizeof($id)-1);$i++){
					$sqlHapus="delete from b_ms_kso_luar_paket where id='".$id[$i]."'";
					mysql_query($sqlHapus);
				}
				break;
			case 'editbiaya':
				$sqlEditBiaya="update b_ms_kso_luar_paket set nilai='".$_REQUEST['biaya']."', flag = '".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";
				mysql_query($sqlEditBiaya);
				break;
		}
		break;
	case '12':
		$id=explode(",",$_REQUEST['id']);
		switch(strtolower($_REQUEST['act'])){
			case 'tambah':
				for($i=0;$i<(sizeof($id)-1);$i++){
					$sqlCek="select * from b_ms_kso_pakomodasi where ms_tindakan_id='".$id[$i]."' and ms_kso_id='".$_REQUEST['ksoId']."'";
					$rsCek=mysql_query($sqlCek);
					if(mysql_num_rows($rsCek)==0){
						$sqlTambah="insert into b_ms_kso_pakomodasi (ms_tindakan_id,ms_kso_id,flag)
							values('".$id[$i]."','".$_REQUEST['ksoId']."','".$_REQUEST['flag']."')";
						$rs=mysql_query($sqlTambah);
					}
				}
				break;
			case 'hapus':
				for($i=0;$i<(sizeof($id)-1);$i++){
					$sqlHapus="delete from b_ms_kso_pakomodasi where id='".$id[$i]."'";
					mysql_query($sqlHapus);
				}
				break;
			case 'editbiaya':
				$sqlEditBiaya="update b_ms_kso_luar_paket set nilai='".$_REQUEST['biaya']."', flag = '".$_REQUEST['flag']."' where id='".$_REQUEST['id']."'";
				mysql_query($sqlEditBiaya);
				break;
		}
		break;
		case '20':
		switch(strtolower($_REQUEST['act'])){
			case 'update':
				$sqlSimpan = "UPDATE b_ms_kso_pasien SET instansi_id='".$_REQUEST['instansi_id']."',no_anggota='".$_REQUEST['no_anggota']."',st_anggota='".$_REQUEST['st_anggota']."',nama_peserta='".$_REQUEST['nama_peserta']."',tgl_act=now(), flag = '".$_REQUEST['flag']."' WHERE id='".$_REQUEST['id']."'";	
				$rs=mysql_query($sqlSimpan);
				break;
		}
		break;
		case '21':
		switch(strtolower($_REQUEST['act'])){
			case 'tambah':		
				$sqlTambah="insert into b_ms_instansi (kode,nama,alamat,kota,telp,aktif,flag)
					values('".$_REQUEST['kode']."','".$_REQUEST['nama']."','".$_REQUEST['alamat']."','".$_REQUEST['kota']."','".$_REQUEST['telp']."','".$_REQUEST['aktif']."','".$_REQUEST['flag']."')";
				$rs=mysql_query($sqlTambah);
				break;
			case 'hapus':
				$sqlCek="SELECT * from b_ms_kso_pasien where instansi_id='".$_REQUEST['instansiId']."'";
				$rsCek=mysql_query($sqlCek);
				if (mysql_num_rows($rsCek)>0){
					
				}else{
					$sqlHapus="delete from b_ms_instansi where id='".$_REQUEST['instansiId']."'";
					mysql_query($sqlHapus);
				}
				break;
			case 'simpan':
				$sqlSimpan = "UPDATE b_ms_instansi SET kode='".$_REQUEST['kode']."',nama='".$_REQUEST['nama']."',alamat='".$_REQUEST['alamat']."',kota='".$_REQUEST['kota']."',telp='".$_REQUEST['telp']."',aktif='".$_REQUEST['aktif']."', flag = '".$_REQUEST['flag']."' WHERE id='".$_REQUEST['instansiId']."'";	
				$rs=mysql_query($sqlSimpan);
				break;
		}
		break;
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" where ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	if($grd==2 ||$grd==3|| $grd==4|| $grd==5|| $grd==6|| $grd==7|| $grd==8|| $grd==9|| $grd==10|| $grd==11|| $grd==12 || $grd==20){
		$defaultsort="nama";
	}
	$sorting=$defaultsort;
}

switch($grd){
	case "1":
		$sql="SELECT * FROM (SELECT kso.id,kso.kepemilikan_id,k.NAMA kepemilikan,kso.kode,kso.nama,kso.alamat,kso.telp,kso.fax,
				kso.kontak,kso.aktif caktif,IF(kso.aktif=1,'Ya','Tidak') aktif, kso.margin_hjual
				FROM b_ms_kso kso 
				LEFT JOIN $dbapotek.a_kepemilikan k ON kso.kepemilikan_id=k.ID) gab ".$filter." order by ".$sorting;
		break;
	case "2":
		$sql="select * from (SELECT t.id,t.nama,kt.nama as kelompok,kl.nama as klasifikasi FROM b_ms_tindakan t 
left join (select b_ms_tindakan_id,id from b_ms_tindakan_tdk_jamin where b_ms_kso_id='".$_REQUEST['ksoId']."') as tj on tj.b_ms_tindakan_id=t.id
inner join b_ms_kelompok_tindakan kt on t.kel_tindakan_id=kt.id
inner join b_ms_klasifikasi kl on t.klasifikasi_id=kl.id
where tj.id is null) as t1 ".$filter." order by ".$sorting;
		break;
	case "3":
		$sql="select * from (select tj.id,t.nama,kt.nama as kelompok,kl.nama as klasifikasi FROM b_ms_tindakan_tdk_jamin tj
inner join b_ms_tindakan t on tj.b_ms_tindakan_id=t.id 
inner join b_ms_kelompok_tindakan kt on t.kel_tindakan_id=kt.id
inner join b_ms_klasifikasi kl on t.klasifikasi_id=kl.id
where b_ms_kso_id='".$_REQUEST['ksoId']."') as gab ".$filter." order by ".$sorting;
		break;
	case "4":
		$sql="select * from (select mk.id,mk.nama from b_ms_kelas mk
left join 
(select kk.id,kk.b_ms_kelas_id from b_ms_kso_kelas kk where kk.b_ms_kso_id='".$_REQUEST['ksoId']."') as t1
on t1.b_ms_kelas_id=mk.id
where t1.id is null) as gab ".$filter." order by ".$sorting;
		break;
	case "5":
		$sql="select * from (SELECT kp.id,kp.b_ms_kelas_id,k.nama,kp.jaminan,kp.b_ms_kso_id
FROM b_ms_kso_paket_hp kp
inner join b_ms_kelas k on kp.b_ms_kelas_id=k.id 
where b_ms_kso_id='".$_REQUEST['ksoId']."') as gab ".$filter." order by ".$sorting;
		break;
	case "6":
		$sql="select * from (SELECT id,kso_id,nama,nilai,if(paket='0','Global',if(paket='1','Per Item Paket',null)) as paket,
		if(instalasi='0','Bebas',if(instalasi='1','Rawat Inap',if(instalasi='2','Non Rawat Inap',null))) as instalasi,
		if(frekuensi='0','Harian',if(frekuensi='1','Bebas',null)) as frekuensi FROM b_ms_kso_paket b  where kso_id='".$_REQUEST['ksoId']."') as gab ".$filter." order by ".$sorting;
		break;
	case "7":
		$sql="select * from (select t.id,t.nama,kt.nama as kelompok,kl.nama as klasifikasi
		from b_ms_tindakan t
		inner join b_ms_kelompok_tindakan kt on t.kel_tindakan_id=kt.id
		inner join b_ms_klasifikasi kl on t.klasifikasi_id=kl.id
		left join (SELECT d.ms_tindakan_id,d.id FROM b_ms_kso_paket_detail d
		inner join b_ms_kso_paket p on p.id=d.kso_paket_id
		where d.kso_paket_id='".$_REQUEST['paketId']."' ) as t1 on t1.ms_tindakan_id=t.id where t1.id is  null) as gab ".$filter." order by ".$sorting;
		break;
	case "8":
		$sql="select * from (SELECT d.id,t.nama,kt.nama as kelompok,kl.nama as klasifikasi
		FROM b_ms_kso_paket_detail d
		inner join b_ms_kso_paket p on p.id=d.kso_paket_id
		inner join b_ms_tindakan t on t.id=d.ms_tindakan_id
		inner join b_ms_kelompok_tindakan kt on t.kel_tindakan_id=kt.id
		inner join b_ms_klasifikasi kl on t.klasifikasi_id=kl.id
		where d.kso_paket_id='".$_REQUEST['paketId']."') as gab ".$filter." order by ".$sorting;
		break;
	case "9":
		$sql="select * from (SELECT t.id,t.nama,kt.nama as kelompok,kl.nama as klasifikasi
	FROM b_ms_tindakan t
	inner join b_ms_kelompok_tindakan kt on t.kel_tindakan_id=kt.id
	inner join b_ms_klasifikasi kl on t.klasifikasi_id=kl.id
left join (select ms_tindakan_id,id from b_ms_kso_luar_paket where kso_id='".$_REQUEST['ksoId']."') as tj on tj.ms_tindakan_id=t.id where tj.id is null) as t1 ".$filter." order by ".$sorting;
		break;
	case "10":
		$sql="select * from (SELECT tj.id,t.nama,kt.nama as kelompok,kl.nama as klasifikasi,tj.nilai
	FROM b_ms_kso_luar_paket tj	
	inner join b_ms_tindakan t on tj.ms_tindakan_id=t.id
	inner join b_ms_kelompok_tindakan kt on t.kel_tindakan_id=kt.id
	inner join b_ms_klasifikasi kl on t.klasifikasi_id=kl.id
	where kso_id='".$_REQUEST['ksoId']."') as gab ".$filter." order by ".$sorting;
		break;
	case "11":
		$sql="select * from (SELECT t.id,t.nama,kt.nama as kelompok,kl.nama as klasifikasi
	FROM b_ms_tindakan t
	inner join b_ms_kelompok_tindakan kt on t.kel_tindakan_id=kt.id
	inner join b_ms_klasifikasi kl on t.klasifikasi_id=kl.id
left join (SELECT ms_tindakan_id,id FROM b_ms_kso_pakomodasi WHERE ms_kso_id='".$_REQUEST['ksoId']."') as tj on tj.ms_tindakan_id=t.id where tj.id is null) as t1 ".$filter." order by ".$sorting;
		break;
	case "12":
		$sql="select * from (SELECT tj.id,t.nama,kt.nama as kelompok,kl.nama as klasifikasi
	FROM b_ms_kso_pakomodasi tj	
	inner join b_ms_tindakan t on tj.ms_tindakan_id=t.id
	inner join b_ms_kelompok_tindakan kt on t.kel_tindakan_id=kt.id
	inner join b_ms_klasifikasi kl on t.klasifikasi_id=kl.id
	where ms_kso_id='".$_REQUEST['ksoId']."') as gab ".$filter." order by ".$sorting;
		break;
	case "20":
	/*$sql="select * from (SELECT b_ms_kso_pasien.id, b_ms_pasien.no_rm, b_ms_pasien.nama, b_ms_pasien.alamat, IF(b_ms_instansi.nama IS NULL,'-',b_ms_instansi.nama) AS instansi,
b_ms_kso_pasien.nama_peserta, b_ms_kso_pasien.no_anggota, b_ms_kso_pasien.st_anggota
FROM b_ms_kso_pasien
INNER JOIN b_ms_pasien ON b_ms_pasien.id=b_ms_kso_pasien.pasien_id
LEFT JOIN b_ms_instansi ON b_ms_instansi.id = b_ms_kso_pasien.instansi_id
WHERE b_ms_kso_pasien.kso_id='".$_REQUEST['ksoId']."') as gab ".$filter." order by ".$sorting;*/
		$sql="SELECT * FROM (SELECT kso_p.id, b_ms_pasien.no_rm, b_ms_pasien.nama, b_ms_pasien.alamat, 
IF(b_ms_instansi.nama IS NULL,'-',b_ms_instansi.nama) AS instansi, kso_p.nama_peserta, 
kso_p.no_anggota, kso_p.st_anggota 
FROM (SELECT * FROM b_ms_kso_pasien WHERE b_ms_kso_pasien.kso_id='".$_REQUEST['ksoId']."') kso_p
INNER JOIN b_ms_pasien ON b_ms_pasien.id=kso_p.pasien_id 
LEFT JOIN b_ms_instansi ON b_ms_instansi.id = kso_p.instansi_id) AS gab ".$filter." order by ".$sorting;
		break;
	case "21":
		$sql="select * from (SELECT id, kode, nama, alamat, kota, telp, aktif FROM b_ms_instansi) as gab ".$filter." order by ".$sorting;
		break;
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

switch($grd){
	case "1":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"]."|".$rows["caktif"]."|".$rows["kepemilikan_id"]."|".$rows['margin_hjual'].chr(3).$rows["kode"].chr(3).$rows["nama"].chr(3).$rows["kepemilikan"].chr(3).$rows["alamat"].chr(3).$rows["telp"].chr(3).$rows["fax"].chr(3).$rows["kontak"].chr(3).$rows["aktif"].chr(6);
	}
	break;

	case "2":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3)."0".chr(3).$rows["nama"].chr(3).$rows["kelompok"].chr(3).$rows["klasifikasi"].chr(6);
	}
	break;
	case "3":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3)."0".chr(3).$rows["nama"].chr(3).$rows["kelompok"].chr(3).$rows["klasifikasi"].chr(6);
	}
	break;
	case "4":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3)."0".chr(3).$rows["nama"].chr(6);
	}
	break;
	case "5":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"]."|".$rows["b_ms_kelas_id"].chr(3).$rows['nama'].chr(3).$rows["jaminan"].chr(6);
	}
	break;
	case "6":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"]."|".$rows["kso_id"].chr(3).$rows["nama"].chr(3).$rows["nilai"].chr(3).$rows["paket"].chr(3).$rows["instalasi"].chr(3).$rows["frekuensi"].chr(6);
	}
	break;
	case "7":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3)."0".chr(3).$rows["nama"].chr(3).$rows["kelompok"].chr(3).$rows["klasifikasi"].chr(6);
	}
	break;
	case "8":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3)."0".chr(3).$rows["nama"].chr(3).$rows["kelompok"].chr(3).$rows["klasifikasi"].chr(6);
	}
	break;
	case "9":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3)."0".chr(3).$rows["nama"].chr(3).$rows["kelompok"].chr(3).$rows["klasifikasi"].chr(6);
	}
	case "10":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3)."0".chr(3).$rows["nama"].chr(3).$rows["kelompok"].chr(3).$rows["klasifikasi"].chr(3).number_format($rows["nilai"],0,",",".").chr(6);
	}
	case "11":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3)."0".chr(3).$rows["nama"].chr(3).$rows["kelompok"].chr(3).$rows["klasifikasi"].chr(6);
	}
	case "12":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3)."0".chr(3).$rows["nama"].chr(3).$rows["kelompok"].chr(3).$rows["klasifikasi"].chr(6);
	}
	case "20":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$dt.=$rows["id"].chr(3).$i.chr(3).$rows["no_rm"].chr(3).$rows["nama"].chr(3).$rows["alamat"].chr(3).$rows["instansi"].chr(3).$rows["nama_peserta"].chr(3).$rows["no_anggota"].chr(3).$rows["st_anggota"].chr(6);
	}
	case "21":
	while ($rows=mysql_fetch_array($rs))
	{
		$i++;
		$cada="0";
		$sql="SELECT * from b_ms_kso_pasien where instansi_id='".$rows["id"]."' LIMIT 1";
		$rschk=mysql_query($sql);
		if (mysql_num_rows($rschk)>0) $cada="1";
		$dt.=$rows["id"]."|".$cada.chr(3).$i.chr(3).$rows["kode"].chr(3).$rows["nama"].chr(3).$rows["alamat"].chr(3).$rows["kota"].chr(3).$rows["telp"].chr(3).$rows["aktif"].chr(6);
	}
}

if ($dt!=$totpage.chr(5)){
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