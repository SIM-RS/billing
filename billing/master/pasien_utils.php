<?php
$userId=$_GET['userId'];
include("../koneksi/konek.php");
include("../sesi.php");
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$grd = $_REQUEST["grd"];

echo $wew;
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="id desc";
$sorting=$_REQUEST["sorting"];
$saringan='';
$filter=$_REQUEST["filter"];

//=================================================================
$idPasien = $_REQUEST['idPasien'];
$idKsoPasien = $_REQUEST['idKsoPasien'];
$noRm =$_REQUEST['noRm'];
$ktp = $_REQUEST['ktp'];
$nama = $_REQUEST['nama']; 
$namaOrtu = $_REQUEST['namaOrtu']; 
$namaSuTri = $_REQUEST['namaSuTri'];
$gender = $_REQUEST['gender']; 
$pend = $_REQUEST['pend']; 
$pek = $_REQUEST['pek'];
$agama = $_REQUEST['agama'];
$tglLhr = tglSQL($_REQUEST['tglLhr']); 
$thn = $_REQUEST['thn']; 
$bln = $_REQUEST['bln']; 
$alamat = $_REQUEST['alamat'];
$telp = $_REQUEST['telp'];
$rt = $_REQUEST['rt'];
$rw = $_REQUEST['rw'];
$prop = $_REQUEST['prop']; 
$kab = $_REQUEST['kab']; 
$statusPas = $_REQUEST['statusPas']; 
$kec =$_REQUEST['kec']; 
$desa = $_REQUEST['desa']; 
$noAnggota = $_REQUEST['noAnggota']; 
$hakKelas = $_REQUEST['hakKelas']; 
$statusPenj = $_REQUEST['statusPenj'];
$darah = $_REQUEST['darah'];

//-------------------------------------------------
$statusProses='';
$msg='';
$cek1="SELECT * FROM b_ms_pasien WHERE no_rm = '$noRm'";
//$cek2="SELECT * FROM b_ms_pasien WHERE no_rm = '$noRm' AND nama = '$nama'";
switch(strtolower($_REQUEST['act'])) {
    /*case 'cek':
		$que="SELECT * FROM b_ms_pasien WHERE no_rm = '$noRm'";
		$isi=mysql_query($que);
		$row = mysql_fetch_array($isi);
		$isi=$row['no_rm'];
		
		printf("%07s",$isi);
		mysql_free_result($que);
		return;
		break;*/
	case 'getnorm':
    //$query = "select max(no_rm)+1 as no_rm from b_ms_pasien";
        $query="select max(no_rm)+1 as next_no_rm from $dbbilling.b_ms_pasien";
        $rs = mysql_query($query);
        $row = mysql_fetch_array($rs);
        //echo $row['no_rm'];
        printf("%07s",$row['next_no_rm']);
        return;
        break;
    case 'tambah':
			$cek1=mysql_num_rows(mysql_query($cek1));
            if($cek1==0){
			$sqlTambah="insert into $dbbilling.b_ms_pasien (no_rm,nama,sex,agama,tgl_lahir,alamat,rt,rw,desa_id,kec_id,kab_id,prop_id,telp,pendidikan_id,pekerjaan_id,nama_ortu,nama_suami_istri,user_act,tgl_act,no_ktp,gol_darah,flag) values('$noRm','$nama','$gender','$agama','$tglLhr','$alamat','$rt','$rw','$desa','$kec','$kab','$prop','$telp','$pend','$pek','$namaOrtu','$namaSuTri','$userId','$tglact','$ktp','$darah','$flag')";
            $rs=mysql_query($sqlTambah);
           	if (mysql_errno()<=0){
				$cariidpas="select id from $dbbilling.b_ms_pasien where no_rm='".$noRm."' order by id desc limit 1";
				$qq=mysql_query($cariidpas);
				$rows=mysql_fetch_array($qq);
				$idpas = $rows['id'];
				
				$namaPeserta=$nama;
				switch ($statusPenj){
					case "Anak Ke 1":
						$namaPeserta=$namaOrtu;
						break;
					case "Anak Ke 2":
						$namaPeserta=$namaOrtu;
						break;
				}
				
				$sqlTambah="insert into $dbbilling.b_ms_kso_pasien (kso_id,pasien_id,kelas_id,no_anggota,aktif,st_anggota,nama_peserta,tgl_act,flag)
					values('$statusPas','$idpas','$hakKelas','$noAnggota','1','$statusPenj','$namaPeserta','$tglact','$flag')";
				$rs=mysql_query($sqlTambah);
           		if (mysql_errno()>0){
					 $statusProses="Error";
					 $msg='Gagal Menyimpan Data Pasien KSO !';
				}
			}else{
				 $statusProses="Error";
				 $msg='Gagal Menyimpan Data Pasien !';
			}
			}else{
				 $statusProses="Error";
				 $msg='Data No RM Pasien Sudah Ada !';
			}
        break;
    case 'simpan':
			$namaPeserta=$nama;
			switch ($statusPenj){
				case "Anak Ke 1":
					$namaPeserta=$namaOrtu;
					break;
				case "Anak Ke 2":
					$namaPeserta=$namaOrtu;
					break;
			}
			
			/*$cek2=mysql_num_rows(mysql_query($cek2));
            if($cek2==0){*/
            $sqlSimpan="update $dbbilling.b_ms_kso_pasien set kso_id='$statusPas',
	    kelas_id='$hakKelas',no_anggota='$noAnggota',aktif='1',st_anggota='$statusPenj',nama_peserta='$namaPeserta',tgl_act='$tglact',flag='$flag' where id='$idKsoPasien'";
            mysql_query($sqlSimpan);
           	if (mysql_errno()<=0){
				$sqlUpdate="update $dbbilling.b_ms_pasien set nama='$nama',sex='$gender',agama='$agama',tgl_lahir='$tglLhr',alamat='$alamat',rt='$rt',rw='$rw',desa_id='$desa',kec_id='$kec',kab_id='$kab',prop_id='$prop',no_ktp='$ktp',telp='$telp',pendidikan_id='$pend',pekerjaan_id='$pek',nama_ortu='$namaOrtu',nama_suami_istri='$namaSuTri',user_act='$userId',tgl_act='$tglact',gol_darah='$darah',flag='$flag' where id=$idPasien";
				//echo $sqlUpdate."<br>";
				mysql_query($sqlUpdate);
           		if (mysql_errno()>0){
					 $statusProses="Error";
					 $msg='Gagal Menyimpan Data Pasien !';
				}
			}else{
				 $statusProses="Error";
				 $msg='Gagal Menyimpan Data Pasien KSO !';
			}
			/*}else{
				 $statusProses="Error";
				 $msg='Data Pasien Sudah Ada !';
			}*/
		break;
    case 'hapus':
		$sqlCek="SELECT id FROM $dbbilling.b_kunjungan WHERE pasien_id='".$idPasien."' LIMIT 1";
		$rsCek=mysql_query($sqlCek);
		if (mysql_num_rows($rsCek)<=0){
			$sqlHapus="delete from $dbbilling.b_ms_kso_pasien where id='".$idKsoPasien."'";
			if(mysql_query($sqlHapus)){
				$statusProses="";
				$sqlHapusPas="delete from $dbbilling.b_ms_pasien where id='".$idPasien."'";
				if(mysql_query($sqlHapusPas)){
					 $statusProses="";
				}
				else{
					 $statusProses="Error";
					 $msg='Gagal Menghapus Data Pasien !';
				}
			}
			else{
				 $statusProses="Error";
				 $msg='Gagal Menghapus Data Pasien KSO !';
			}
		}else{
			$statusProses="Error";
			$msg='Pasien Sudah Pernah Berkunjung, Jadi Tidak Boleh Dihapus !';
		}
		break;
}

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act'])."|".$msg;
}
else {
    //$asalLoket = $_GET['asalLoket'];
    if($_REQUEST['saring']=='true') {
        $saringan=" WHERE k.kso_id= '".$_REQUEST['saringan']."' ";
    }

    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
    }

    if ($sorting=="") {
        $sorting=$defaultsort;
    }

    if($grd == "true") {
	
        $sql="select * from (SELECT p.id AS pasien_id,p.no_rm,p.nama,p.alamat,p.rt,p.rw,
	p.tgl_lahir,p.desa_id,p.kec_id,
	p.kab_id,p.prop_id,p.no_ktp,p.nama_ortu,p.nama_suami_istri,p.sex,p.pendidikan_id,p.pekerjaan_id,p.agama,p.telp,
	s.nama AS penjamin,k.id,k.kso_id,k.kelas_id,k.no_anggota,k.st_anggota,l.nama as kelas,p.gol_darah FROM $dbbilling.b_ms_kso_pasien k
INNER JOIN $dbbilling.b_ms_pasien p ON k.pasien_id=p.id
INNER JOIN $dbbilling.b_ms_kso s ON k.kso_id=s.id
INNER JOIN $dbbilling.b_ms_kelas l ON k.kelas_id=l.id
".$saringan." AND p.flag = '$flag') as gab ".$filter." order by ".$sorting;
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

    if($grd == "true") {
        while ($rows=mysql_fetch_array($rs)) {
            $sisipan = $rows['id'].
	    "|".$rows['pasien_id'].
	    "|".$rows['no_rm'].
	    "|".$rows['alamat'].
	    "|".$rows['rt'].
	    "|".$rows['rw'].
	    "|".$rows['nama'].
	    "|".tglSQL($rows['tgl_lahir']).
	    "|".$rows['desa_id'].
	    "|".$rows['kec_id'].
	    "|".$rows['kab_id'].
	    "|".$rows['prop_id'].
	    "|".$rows['nama_ortu'].
	    "|".$rows['nama_suami_istri'].
	    "|".$rows['sex'].
	    "|".$rows['pendidikan_id'].
	    "|".$rows['pekerjaan_id'].
	    "|".$rows['agama'].
	    "|".$rows['telp'].
	    "|".$rows['no_anggota'].
	    "|".$rows['kso_id'].
	    "|".$rows['kelas_id'].
		"|".$rows['no_ktp'].
		"|".$rows['st_anggota'].
		"|".$rows['gol_darah'];
	   
            $i++;
            $dt.=$sisipan.chr(3).$i.chr(3).$rows['no_rm'].chr(3).$rows["nama"].chr(3).tglSQL($rows['tgl_lahir']).chr(3).$rows["penjamin"].chr(3).$rows["kelas"].chr(3).$rows["alamat"]." RT. ".$rows["rt"]." RW. ".$rows['rw'].chr(6);
            //$rows["id"]
        }
    }

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act'])."|".$msg;
        $dt=str_replace('"','\"',$dt);
    }

    mysql_free_result($rs);
}
mysql_close($konek);
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
}else {
    header("Content-type: text/xml");
}
echo $dt;
?>