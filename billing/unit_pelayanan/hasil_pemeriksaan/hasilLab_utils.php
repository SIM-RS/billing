<?php 
include("../../koneksi/konek.php");
$grd=$_REQUEST["grd"];
/*$tipePeriksaLab=$_REQUEST['tipePeriksaLab'];
if ($tipePeriksaLab=="") $tipePeriksaLab=1;*/
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$statusProses='';
switch(strtolower($_REQUEST['act']))
{
	case 'tambah':
		switch($_REQUEST["smpn"])
		{
			case 'btnSimpanHsl':
				$sCek="select * from b_hasil_lab where id_pelayanan='".$_REQUEST['pelayanan_id']."' and id_normal='".$_REQUEST['normal']."'";
				$qCek=mysql_query($sCek);
				if(mysql_num_rows($qCek)==0){
					$sqlTambah="insert into b_hasil_lab (id_pelayanan,id_kunjungan,id_tindakan,id_normal,hasil,ket,dokter_id,tgl_act,user_act) 
					values('".$_REQUEST['pelayanan_id']."','".$_REQUEST['kunjungan_id']."','".$_REQUEST['idTind']."','".$_REQUEST['normal']."','".$_REQUEST['hasil']."','".$_REQUEST['ket']."','".$_REQUEST['user_actD']."',now(),'".$_REQUEST['user_act']."')";
					$rs=mysql_query($sqlTambah);
				}
				else{
					$statusProses='Error';
					$msg='Data sudah ada !';	
				}
				break;
			case 'btnSimpanHslLab':
				// Permintaan pemeriksaan dari master Pemeriksaan
				if ($tipe_periksa_lab==0){
					$sCek="insert into b_hasil_lab (id_pelayanan,id_kunjungan,id_normal,ket,tgl_act,user_act)
					SELECT t.pelayanan_id,'".$_REQUEST['kunjungan_id']."',nlab.id AS id_normal,nlab.ket,NOW(),'".$_REQUEST['user_actD']."'
						FROM b_ms_normal_lab nlab 
						INNER JOIN b_ms_pemeriksaan_lab mplab ON nlab.id_pemeriksaan_lab=mplab.id
						INNER JOIN b_tindakan_lab t ON mplab.id = SUBSTRING_INDEX(t.pemeriksaan_id, '|', 1) AND SUBSTRING_INDEX(t.pemeriksaan_id, '|', -1) <> 1
						INNER JOIN b_ms_kelompok_lab kel ON mplab.kelompok_lab_id=kel.id
						INNER JOIN b_ms_kelompok_lab mklab ON mplab.kelompok_lab_id=mklab.id INNER JOIN b_ms_satuan_lab mslab ON nlab.id_satuan=mslab.id
						LEFT JOIN b_hasil_lab bhl ON bhl.id_pelayanan=t.pelayanan_id AND bhl.id_normal=nlab.id 
						WHERE t.pelayanan_id='".$_REQUEST['pelayanan_id']."' AND t.tindakan_lab_id in(".$_REQUEST['idSimpan'].") AND lp = '".$_REQUEST['jk']."' AND bhl.id IS NULL";
					$qCek=mysql_query($sCek);
				}
				// Permintaan pemeriksaan dari master Tindakan
				else{
					// Insert Tindakan
					$sql="SELECT p.id,p.unit_id,p.jenis_kunjungan,p.kunjungan_id,k.kelas_id kunj_kelas_id,
						p.is_paviliun,p.kso_id,k.kso_kelas_id,p.kelas_id
						FROM b_pelayanan p INNER JOIN b_kunjungan k ON p.kunjungan_id=k.id WHERE p.id='".$_REQUEST['pelayanan_id']."'";
					//echo $sql."<br>";
					$rsPel=mysql_query($sql);
					$rwPel=mysql_fetch_array($rsPel);
					$unitId=$rwPel["unit_id"];
					$jenisKunj=$rwPel["jenis_kunjungan"];
					$kunjId=$rwPel["kunjungan_id"];
					$kelasId=$rwPel["kelas_id"];
					$kunj_kelas_id=$rwPel["kunj_kelas_id"];
					$is_paviliun=$rwPel["is_paviliun"];
					$kso_id=$rwPel["kso_id"];
					$kso_kelas_id=$rwPel["kso_kelas_id"];
					
					/* $sCek="SELECT mtk.id,mtk.ms_tindakan_id,mtk.tarip,IF($kso_id<>1,mtk.tarip,0) biayaKSO,IF($kso_id=1,mtk.tarip,0) biayaPx
						FROM b_ms_tindakan_kelas mtk 
						WHERE mtk.ms_tindakan_id IN (".$_REQUEST['idSimpan'].") AND mtk.ms_kelas_id='$kelasId'"; */
					$sCek = "SELECT mtk.id,mtk.ms_tindakan_id,mtk.tarip,IF(1<>1,mtk.tarip,0) biayaKSO,IF($kso_id=1,mtk.tarip,0) biayaPx
							FROM b_ms_tindakan_kelas mtk
							WHERE mtk.ms_tindakan_id IN (".$_REQUEST['idSimpan'].") AND mtk.ms_kelas_id = '{$kelasId}'";
					$rsCek=mysql_query($sCek);
					if(mysql_num_rows($rsCek) <= 0){
						$sCek = "SELECT mtk.id,mtk.ms_tindakan_id,mtk.tarip,IF(1<>1,mtk.tarip,0) biayaKSO,IF($kso_id=1,mtk.tarip,0) biayaPx
							FROM b_ms_tindakan_kelas mtk
							WHERE mtk.ms_tindakan_id IN (".$_REQUEST['idSimpan'].") AND mtk.ms_kelas_id = '1'";
						$rsCek=mysql_query($sCek);
					}
					// echo $sCek;
					// echo mysql_num_rows($rsCek);
					while ($rwCek=mysql_fetch_array($rsCek)){
						$mtkId=$rwCek["id"];
						$mtId=$rwCek["ms_tindakan_id"];
						$biaya=$rwCek["tarip"];
						$biayaKSO=$rwCek["biayaKSO"];
						$biayaPx=$rwCek["biayaPx"];
						//Cek sdh ada tindakan tsb di pelayanan yg sama
						$sCek="SELECT id FROM b_tindakan WHERE pelayanan_id='".$_REQUEST['pelayanan_id']."' 
							AND ms_tindakan_kelas_id='$mtkId'";
						//echo $sCek."<br>";
						$rsIn=mysql_query($sCek);
						//Jika blm ada tindakan tsb -> insert ke b_tindakan
						if (mysql_num_rows($rsIn)==0){
							// Insert Tindakan
							$sCek="INSERT INTO b_tindakan(ms_tindakan_kelas_id,ms_tindakan_unit_id,jenis_kunjungan,
								kunjungan_id,kunjungan_kelas_id,is_paviliun,pelayanan_id,kso_id,kso_kelas_id,
								kelas_id,tgl,qty,biaya,biaya_kso,biaya_pasien,user_id,tgl_act,user_act,unit_act)
								VALUES($mtkId,$unitId,$jenisKunj,$kunjId,'$kunj_kelas_id','$is_paviliun','".$_REQUEST['pelayanan_id']."',
								$kso_id,$kso_kelas_id,$kelasId,CURDATE(),1,$biaya,$biayaKSO,$biayaPx,
								'".$_REQUEST['user_actD']."',NOW(),'".$_REQUEST['user_act']."',$unitId)";
							//echo $sCek."<br>";
							$rsIn=mysql_query($sCek);
							// echo mysql_errno().' mysql error';
							if (mysql_errno()==0){
								$idTind=mysql_insert_id();
								
								// Insert Hasil Pemeriksaan
								$sCek="insert into b_hasil_lab (id_pelayanan,id_kunjungan,id_tindakan,id_normal,ket,dokter_id,tgl_act,user_act)
								SELECT
								  '".$_REQUEST['pelayanan_id']."'      AS idPel,
								  '".$_REQUEST['kunjungan_id']."'    AS idKunj,
								  $idTind	AS idTind,
								  nlab.id AS id_normal,
								  nlab.ket,
								  '".$_REQUEST['user_actD']."'    AS dokterId,
								  NOW(),
								  '".$_REQUEST['user_act']."'    AS idUser
								FROM b_ms_tindakan_pemeriksaan_lab mtpl
								  INNER JOIN b_ms_normal_lab nlab
									ON mtpl.ms_pemeriksaan_id = nlab.id_pemeriksaan_lab
								  LEFT JOIN b_hasil_lab bhl
									ON bhl.id_pelayanan = '".$_REQUEST['pelayanan_id']."'
									  AND bhl.id_tindakan <> $idTind
									  AND bhl.id_normal = nlab.id
								WHERE mtpl.ms_tindakan_id = '$mtId'
									AND nlab.lp = '".$_REQUEST['jk']."'
									AND nlab.aktif = 1
									AND bhl.id IS NULL";
								echo $sCek."<br>";
								$qCek=mysql_query($sCek);
								mysql_errno().' mysql error';
							}
						}
					}
				}
				if (mysql_errno()==0){
					//$sqlUbah="update b_pelayanan set sudah_labrad = '1' where id = '".$_REQUEST['pelayanan_id']."' ";
					//$rs=mysql_query($sqlUbah);
					// Update Status Pelayanan = 1
					$sUpdt="UPDATE b_pelayanan SET dilayani=1, sudah_labrad = '1' WHERE id='".$_REQUEST['pelayanan_id']."'";
					//echo $sCek."<br>";
					$rsUpdt=mysql_query($sUpdt);
				}
				else{
					$statusProses='Error';
					$msg='Data Gagal Ditambah !';	
				}
				break;
			case 'btnSimpanHslRad':
				$sql="SELECT p.id,p.unit_id,p.jenis_kunjungan,p.kunjungan_id,k.kelas_id kunj_kelas_id,
					p.is_paviliun,p.kso_id,k.kso_kelas_id,p.kelas_id
					FROM b_pelayanan p INNER JOIN b_kunjungan k ON p.kunjungan_id=k.id WHERE p.id='".$_REQUEST['pelayanan_id']."'";
				$rsPel=mysql_query($sql);
				$rwPel=mysql_fetch_array($rsPel);
				$unitId=$rwPel["unit_id"];
				$jenisKunj=$rwPel["jenis_kunjungan"];
				$kunjId=$rwPel["kunjungan_id"];
				$kelasId=$rwPel["kelas_id"];
				$kunj_kelas_id=$rwPel["kunj_kelas_id"];
				$is_paviliun=$rwPel["is_paviliun"];
				$kso_id=$rwPel["kso_id"];
				$kso_kelas_id=$rwPel["kso_kelas_id"];
				
				$sCek="INSERT INTO b_tindakan(ms_tindakan_kelas_id,ms_tindakan_unit_id,jenis_kunjungan,
					kunjungan_id,kunjungan_kelas_id,is_paviliun,pelayanan_id,kso_id,kso_kelas_id,
					kelas_id,tgl,qty,biaya,biaya_kso,biaya_pasien,user_id,tgl_act,user_act,unit_act)
					SELECT id,$unitId,$jenisKunj,$kunjId,'$kunj_kelas_id','$is_paviliun','".$_REQUEST['pelayanan_id']."',
					$kso_id,$kso_kelas_id,$kelasId,CURDATE(),1,mtk.tarip,IF($kso_id<>1,mtk.tarip,0),IF($kso_id=1,mtk.tarip,0),
					'".$_REQUEST['user_actD']."',NOW(),'".$_REQUEST['user_act']."',$unitId
					FROM b_ms_tindakan_kelas mtk 
					WHERE mtk.ms_tindakan_id IN (".$_REQUEST['idSimpan'].") AND mtk.ms_kelas_id='$kelasId'";
				$rsIn=mysql_query($sCek);	
				if (mysql_errno()>0){
					$statusProses='Error';
					$msg='Data Gagal Ditambah !';	
				}
				break;
		}
		//echo mysql_error();
		break;
	
	case 'simpan':
		switch($_REQUEST["smpn"])
		{
			case 'btnSimpanHsl':
				$sqlUpdate="update b_hasil_lab set id_tindakan='".$_REQUEST['idTind']."',id_normal='".$_REQUEST['normal']."',hasil='".$_REQUEST['hasil']."',ket='".$_REQUEST['ket']."',user_act='".$_REQUEST['user_act']."' where id='".$_REQUEST['id']."'";
				break;
		}
		$rs=mysql_query($sqlUpdate);
		break;
		
	case 'hapus':
		switch($_REQUEST["hps"])
		{
			case 'btnHapusHsl':
				$sqlHapus="delete from b_hasil_lab where id='".$_REQUEST['rowid']."'";
				break;
		}
		mysql_query($sqlHapus);
		break;
		
}

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act'])."*|*".$_REQUEST["smpn"]."*|*".$_REQUEST["hps"]."*|*".$msg;
}
else{

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
}

if($sorting==''){
	if($grd=="true" || $grd1=="true"){		
		$defaultsort="id";
	}
	else{
		$defaultsort="nama";
	}
	$sorting=$defaultsort;
}
//echo $grd.'123';

if($grd == "true")
{
	if($_REQUEST['pelayanan_id']==''){
		$_REQUEST['pelayanan_id']=0;
	}
	/*$sql = 'SELECT a.*,b.nama,CONCAT(a.hasil," ",d.nama_satuan) AS hasilc,CONCAT(CONCAT(c.normal1," - ",c.normal2)," ",d.nama_satuan) AS normal,g.nama as dok,a.ket 
			FROM b_hasil_lab a
			INNER JOIN b_ms_tindakan b ON b.id=a.id_tindakan
			INNER JOIN b_ms_normal_lab c ON c.id=a.id_normal
			INNER JOIN b_ms_satuan_lab d ON d.id=c.id_satuan
			INNER JOIN b_kunjungan e ON e.id=a.id_kunjungan
			INNER JOIN b_pelayanan f ON f.id=a.id_pelayanan 
			INNER JOIN b_ms_pegawai g ON g.id=a.user_act where 0=0 and f.id='.$_REQUEST['pelayanan_id']." ".$filter." order by ".$sorting;*/
    if($_REQUEST["smpn"] == "btnSimpanHslRad") {
        $sql="select * from
        (SELECT t.id, t.qty, t.biaya, t.qty * t.biaya as subtotal, t.kunjungan_id, t.ms_tindakan_kelas_id, t.pelayanan_id, t.ket, t.unit_act, tk.tarip, tin.nama
        , tin.kode,ifnull(p.nama,'-') as dokter,t.ms_tindakan_unit_id,t.user_id,k.nama as kelas, t.type_dokter,t.tgl_act as tanggal, tin.klasifikasi_id, peg.nama AS petugas,t.user_act
	FROM b_tindakan t
	INNER JOIN b_pelayanan pl ON pl.id = t.pelayanan_id
	INNER JOIN b_ms_tindakan_kelas tk ON tk.id = t.ms_tindakan_kelas_id
	INNER JOIN b_ms_kelas k ON tk.ms_kelas_id=k.id
	INNER JOIN b_ms_tindakan tin ON tin.id = tk.ms_tindakan_id
	LEFT JOIN b_ms_pegawai p ON p.id=t.user_id
	LEFT JOIN b_ms_pegawai peg ON peg.id=t.user_act
	WHERE t.pelayanan_id = '".$_REQUEST['pelayanan_id']."') as gab";
    }
	else{
		$sql="SELECT 
			a.*,b.nama,
			/* CONCAT(a.hasil,' ',d.nama_satuan) AS hasilc, */
			IF((a.hasil IS NULL OR a.hasil = ''),'',CONCAT(a.hasil,' ',d.nama_satuan)) AS hasilc,
			CONCAT(CONCAT(c.normal1,' - ',c.normal2),' ',d.nama_satuan) AS normal,
			g.nama AS dok,
			a.ket,
			b.id AS ms_pemeriksaan_lab_id 
			FROM b_hasil_lab a INNER JOIN b_ms_normal_lab c ON c.id=a.id_normal 
			INNER JOIN b_ms_satuan_lab d ON d.id=c.id_satuan INNER JOIN b_ms_pemeriksaan_lab b ON c.id_pemeriksaan_lab=b.id 
			LEFT JOIN b_ms_pegawai g ON g.id=a.dokter_id 
			WHERE 0=0 AND a.id_pelayanan='".$_REQUEST['pelayanan_id']."' ".$filter." ORDER BY ".$sorting;
	}
}

//echo $sql."<br>";
$rs=mysql_query($sql);
//echo mysql_error();
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
		$sLink="SELECT 
		ms_tindakan_id 
		FROM 
		b_ms_tindakan_pemeriksaan_lab
		WHERE ms_pemeriksaan_id='".$rows['ms_pemeriksaan_lab_id']."'";
		$qLink=mysql_query($sLink);
		$rwLink=mysql_fetch_array($qLink);
		
		$i++;
		//$dtx = $rows["id"]."|".$rows["nama"]."|".$rows["hasil"]."|".$rows["id_tindakan"]."|".$rows["id_normal"]."|".$rows["normal"]."|".$rows["user_act"]."|".$rows["ket"];
		$dtx = $rows["id"]."|".$rows["nama"]."|".$rows["hasil"]."|".$rwLink["ms_tindakan_id"]."|".$rows["id_normal"]."|".$rows["normal"]."|".$rows["user_act"]."|".$rows["ket"];
		$dt.=$dtx.chr(3).$i.chr(3).$rows["tgl_act"].chr(3).$rows["nama"].chr(3).$rows["hasilc"].chr(3).$rows["normal"].chr(3).$rows["ket"].chr(3).$rows["dok"].chr(6);
	}
}

if ($dt!=$totpage.chr(5))
{
	$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act'])."*|*".$_REQUEST["smpn"]."*|*".$_REQUEST["hps"]."*|*".$dt_temp;
	$dt=str_replace('"','\"',$dt);
}else{
	$dt=$totpage.chr(5).chr(5).strtolower($_REQUEST['act'])."*|*".$_REQUEST["smpn"]."*|*".$_REQUEST["hps"]."*|*".$dt_temp;
}

mysql_free_result($rs);
mysql_close($konek);
}
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")){
	header("Content-type: application/xhtml+xml");
}else{
	header("Content-type: text/xml");
}
echo $dt;
?>