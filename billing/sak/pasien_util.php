<?php 
session_start();
$userIdAskep=$_SESSION['userIdAskep'];
include("../koneksi/konek.php");
$grd = $_REQUEST["grd"];
//====================================================================
$unitId = $_REQUEST["unitId"];
$tanggal = tglSQL($_REQUEST["tanggal"]);
$tgl = tglSQL($_REQUEST["tgl"]);
$IdPel = $_REQUEST["IdPel"];
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="pasien";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

$pelayanan_id=$_REQUEST['id_pel'];
$pasien_id=$_REQUEST['id_pas'];
$kamar_id=$_REQUEST['id_kamar'];
$tgl=tglSQL($_REQUEST['tgl']);
$pasiso=$_REQUEST['pasiso'];
$ms_menu_jenis_id=$_REQUEST['makanan'];
$ket=$_REQUEST['ket'];
$bed=$_REQUEST['bed'];
$diterima=0;
$user_act=$userIdAskep;
$id=$_REQUEST['id'];
		
switch(strtolower($_REQUEST['act'])){
	case 'view_tgl':
		$sql="SELECT DATE_FORMAT(tgl,'%d-%m-%Y') AS tgl,DATE_FORMAT(tgl_act,'%H:%i:%s') AS jam FROM ask_diagnosa WHERE pelayanan_id='$IdPel'";
		$rs=mysql_query($sql);
		$tgljam=gmdate('d-m-Y H:i:s',mktime(date('H')+7));
		if ($rw=mysql_fetch_array($rs)){
			$tgljam=$rw["tgl"]." ".$rw["jam"];
		}
		echo $tgljam;
		return;
		break;
	case 'hapus':
		$sql="delete from $dbgizi.gz_makan_harian where id='$id'";
		mysql_query($sql);
		break;
	case 'simpan':
	 	$cek="select * from $dbgizi.gz_makan_harian where pelayanan_id='$pelayanan_id' and tgl='$tanggal' and pasiso='$pasiso'";
		$kueri=mysql_query($cek);
		if(mysql_num_rows($kueri)==0){
			$sql="insert into $dbgizi.gz_makan_harian (pelayanan_id,pasien_id,kamar_id,tgl,pasiso,ms_menu_jenis_id,ket,diterima,user_act,tgl_act,kode_bed) values ('$pelayanan_id','$pasien_id','$kamar_id','$tanggal','$pasiso','$ms_menu_jenis_id','$ket','$diterima','$user_act',now(),'$bed')";
			mysql_query($sql);	
		}
		break;
	case 'update':
		$sql="update $dbgizi.gz_makan_harian set ms_menu_jenis_id='$ms_menu_jenis_id',ket='$ket',user_act='$user_act',tgl_act=now(),kode_bed='$bed' where pelayanan_id='$pelayanan_id' and tgl='$tanggal' and pasiso='$pasiso'";
		mysql_query($sql);
		break;
}

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}

$sql="SELECT *
FROM (SELECT
        mp.id,
        pl.id        idpel,
		pl.id_kamar,
		pl.ms_id_kamar,
        mp.no_rm,
        mp.id     AS id_pasien,
        mp.nama   AS pasien,
        DATE_FORMAT(pl.tgl_in,'%d-%m-%Y %H:%i')    tgl_in,
        pl.tgl_in    tgl,
        mp.alamat,
        pl.nama,
		pl.kelas,
		pl.kamar,
		pl.no_bed
      FROM (SELECT
              p.*,
              tk.tgl_in,
			  tk.no_bed,
              k.pasien_id    pas_id,
			  tk.kamar_id AS id_kamar,
              kso.nama,
			  kl.nama      as kelas,
			  km.id		   as ms_id_kamar,
			  km.nama      as kamar
            FROM b_pelayanan p
              INNER JOIN b_tindakan_kamar tk
                ON p.id = tk.pelayanan_id
              INNER JOIN b_kunjungan k
                ON p.kunjungan_id = k.id
              INNER JOIN b_ms_kso kso
                ON p.kso_id = kso.id
			  inner join b_ms_kelas kl
                on kl.id = tk.kelas_id
			  inner join b_ms_kamar km
			    on km.id = tk.kamar_id
            WHERE tk.aktif = 1
                AND (date(k.tgl_pulang) > '$tanggal'
                      OR k.tgl_pulang IS NULL)
                AND (date(tk.tgl_out) > '$tanggal'
                      OR tk.tgl_out IS NULL)
                AND p.unit_id = '$unitId'
				AND p.dilayani=1) AS pl
        INNER JOIN b_ms_pasien mp
          ON pl.pas_id = mp.id) AS gab
  LEFT JOIN (SELECT mh.id id_makan_harian, mh.pelayanan_id id_pel, mh.pasien_id id_pas, mh.tgl, mh.kode_bed, 
(SELECT b.id FROM $dbgizi.gz_makan_harian a INNER JOIN $dbgizi.gz_ms_menu_jenis b ON a.ms_menu_jenis_id = b.id 
WHERE a.pasiso = 1 AND a.pelayanan_id = mh.pelayanan_id AND a.tgl = mh.tgl ORDER BY a.id DESC LIMIT 1) pagi, 
(SELECT b.id FROM $dbgizi.gz_makan_harian a INNER JOIN $dbgizi.gz_ms_menu_jenis b ON a.ms_menu_jenis_id = b.id 
WHERE a.pasiso = 2 AND a.pelayanan_id = mh.pelayanan_id AND a.tgl = mh.tgl ORDER BY a.id DESC LIMIT 1) siang, 
(SELECT b.id FROM $dbgizi.gz_makan_harian a INNER JOIN $dbgizi.gz_ms_menu_jenis b ON a.ms_menu_jenis_id = b.id 
WHERE a.pasiso = 3 AND a.pelayanan_id = mh.pelayanan_id AND a.tgl = mh.tgl ORDER BY a.id DESC LIMIT 1) sore FROM $dbgizi.gz_makan_harian mh 
WHERE mh.tgl = '$tanggal' GROUP BY mh.pelayanan_id) AS makan ON makan.id_pel = gab.idpel $filter ORDER BY $sorting";
//echo $sql."<br>";
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

while ($rows=mysql_fetch_array($rs))
{	

	if($rows['pagi']==''){
		$isuk = 0; 
	}
	else{
		$isuk  = $rows['pagi'];
	}
	if($rows['siang']==''){
		$awan = 0; 
	}
	else{
		$awan  = $rows['siang'];
	}
	if($rows['sore']==''){
		$sure = 0; 
	}
	else{
		$sure  = $rows['sore'];
	}

	$pagi="SELECT
  mmj.id,
  mmj.kode,
  mmj.nama,
  mh.id id_menu_harian,
  if(mh.ket='','',CONCAT('(',mh.ket,')')) ket
FROM $dbgizi.gz_makan_harian mh
  INNER JOIN $dbgizi.gz_ms_menu_jenis mmj
    ON mh.ms_menu_jenis_id = mmj.id
WHERE mh.pasien_id = ".$rows['id_pasien']."
    AND mh.ms_menu_jenis_id = ".$isuk." AND mh.tgl = '$tanggal'";
	$siang="SELECT
  mmj.id,
  mmj.kode,
  mmj.nama,
  mh.id id_menu_harian,
  if(mh.ket='','',CONCAT('(',mh.ket,')')) ket
FROM $dbgizi.gz_makan_harian mh
  INNER JOIN $dbgizi.gz_ms_menu_jenis mmj
    ON mh.ms_menu_jenis_id = mmj.id
WHERE mh.pasien_id = ".$rows['id_pasien']."
    AND mh.ms_menu_jenis_id =".$awan." AND mh.tgl = '$tanggal'";
	$sore="SELECT
  mmj.id,
  mmj.kode,
  mmj.nama,
  mh.id id_menu_harian,
  if(mh.ket='','',CONCAT('(',mh.ket,')')) ket
FROM $dbgizi.gz_makan_harian mh
  INNER JOIN $dbgizi.gz_ms_menu_jenis mmj
    ON mh.ms_menu_jenis_id = mmj.id
WHERE mh.pasien_id = ".$rows['id_pasien']."
    AND mh.ms_menu_jenis_id =".$sure." AND mh.tgl = '$tanggal'";
	
	$qpagi=mysql_query($pagi);
	$qsiang=mysql_query($siang);
	$qsore=mysql_query($sore);
	$dpagi=mysql_fetch_array($qpagi);
	$dsiang=mysql_fetch_array($qsiang);
	$dsore=mysql_fetch_array($qsore);
	
	
	$sqld = "SELECT
		  md.id,
		  md.nama
		FROM $dbbilling.b_ms_diagnosa md
		  INNER JOIN $dbbilling.b_diagnosa d
			ON d.ms_diagnosa_id = md.id where d.pelayanan_id = '".$rows['idpel']."'";
		$kue = mysql_query($sqld);
		$diagnosa = "";
        while($diag=mysql_fetch_array($kue)){
			$diagnosa = $diagnosa." - ".$diag['nama']."<br>";
		}
	

	$i++;
	
	$bed = "";
	$no_bed = "";
	if($rows['kode_bed']==''){
		//$bed = "";
		$bed = " - ".$rows['no_bed'];
		$no_bed = $rows['no_bed'];
	}
	else{
		$bed = " - ".$rows['kode_bed'];
		$no_bed = $rows['kode_bed'];
	}
	
	$pa="<input type='text' readonly='readonly' lang='$dpagi[id]|$dpagi[ket]|$dpagi[id_menu_harian]|$rows[kode_bed]' id='pagi_$rows[id]' value='$dpagi[kode] $dpagi[ket]' size='17' onClick='pagi($rows[id],$rows[ms_id_kamar])' />";
	$si="<input type='text' readonly='readonly' lang='$dsiang[id]|$dsiang[ket]|$dsiang[id_menu_harian]|$rows[kode_bed]' id='siang_$rows[id]' value='$dsiang[kode] $dsiang[ket]' size='17' onClick='siang($rows[id],$rows[ms_id_kamar])' />";
	$so="<input type='text' readonly='readonly' lang='$dsore[id]|$dsore[ket]|$dsore[id_menu_harian]|$rows[kode_bed]' id='sore_$rows[id]' value='$dsore[kode] $dsore[ket]' size='17' onClick='sore($rows[id],$rows[ms_id_kamar])' />";
	$dt.=$rows["id"]."|".$rows["idpel"]."|".$rows['id_kamar']."|".$rows['id_makan_harian']."|".$no_bed.chr(3).$rows["no_rm"].chr(3).$rows["pasien"].chr(3).$diagnosa.chr(3).$rows["kelas"].chr(3).$rows["kamar"].$bed.chr(3).$pa.chr(3).$si.chr(3).$so.chr(6);
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