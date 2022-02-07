<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$id = $_REQUEST['rowid'];
$idTrans=$_REQUEST['cmbPend'];
$ksoId=$_REQUEST['ksoId'];
$tgl=tglSQL($_REQUEST['txtTgl']);
$noBukti=$_REQUEST['txtNoBu'];
$nilai=$_REQUEST['nilai'];
$ket=$_REQUEST['txtArea'];
$bln=$_REQUEST['bln'];
$thn=$_REQUEST['thn'];
$tipe = $_REQUEST['tipe'];
$userId=$_REQUEST['userId'];
$kunj_id = $_REQUEST['kunjungan_id'];
$pel_id = $_REQUEST['pelayanan_id'];
$txtBayar=explode("|",$_REQUEST['txtBayar']);
$txtTin=explode("*",$_REQUEST['txtTin']);
$kunjId=explode("|",$_REQUEST['kunjId']);
$kso = $_REQUEST['kso'];
$ckso = $kso;
$grid = $_REQUEST['grid'];
$jenis_layanan = $_REQUEST['jenis_layanan'];
$unit_id = $_REQUEST['unit_id'];
$inap = $_REQUEST['inap'];
//===============================
$statusProses='';
$alasan='';
$waktu = $_REQUEST['waktu'];
switch($waktu) {
    case 'harian':
        $waktu = " and b.tgl = '$tgl' ";
        $tgl_k = "if(tk.tgl_out>='".$tgl."',1,0)";
        break;
    case 'periode':
        $tglAwal = tglSQL($_REQUEST['tglAwal']);
        $tglAkhir = tglSQL($_REQUEST['tglAkhir']);
        $waktu = " and b.tgl between '$tglAwal' and '$tglAkhir' ";
        $tgl_k = "if(tk.tgl_out>='$tglAwal' and tk.tgl_out<='$tglAkhir',1,0)";
        //'".$tglAkhir."'
        break;
    case 'bulan':
        $waktu = " AND (MONTH(b.tgl) = '".$bln."' AND YEAR(b.tgl) = '".$thn."') ";
        $tgl_k = "if(month(tk.tgl_out)>$bln,1,if(month(tk.tgl_out)=$bln,1,0))";
        //last_day('$thn-$bln-01')
        break;
}

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act'])."*|*".$alasan;
}else{
    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
    }

    if ($sorting=="") {
        $sorting=$defaultsort;
    }
    if($grid == 1) {
		  if($kso == 0){
			 $kso = "";
		  }
		  else{
			 if($inap == 1){
				$ksoP = " and p.kso_id = '$kso' ";
			 }
			 $kso = " AND t.kso_id='$kso' ";
		  }

		  if($inap == 0){
			 //non-inap
			 $sql = "SELECT * FROM (SELECT k.id,t2.unit_id,DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tglK,DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') AS tglP,
mp.no_rm,mp.nama pasien,mu.nama AS unit,SUM(t2.nilai) bayar
FROM (SELECT t1.*,p.kunjungan_id,p.unit_id FROM (SELECT bt.* FROM $dbbilling.b_bayar b INNER JOIN $dbbilling.b_bayar_tindakan bt ON b.id=bt.bayar_id 
WHERE bt.tipe=0 AND bt.nilai>0 $waktu) AS t1 INNER JOIN $dbbilling.b_tindakan t ON t1.tindakan_id=t.id
INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id WHERE p.unit_id='$unit_id' $kso) AS t2
INNER JOIN $dbbilling.b_ms_unit mu ON t2.unit_id=mu.id INNER JOIN $dbbilling.b_kunjungan k ON t2.kunjungan_id=k.id
INNER JOIN $dbbilling.b_ms_pasien mp ON k.pasien_id=mp.id GROUP BY k.id) AS t3 $filter order by $sorting";
		  }
		  else{
			 //inap
			$sql="SELECT * FROM (SELECT k.id,t2.*,DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tglK,DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') AS tglP,mp.no_rm,mp.nama AS pasien,
mu.nama unit FROM (SELECT t1.kunjungan_id,$unit_id AS unit_id,IFNULL(SUM(t1.nilai),0) AS bayar 
FROM (SELECT bt.id,b.kunjungan_id,bt.nilai FROM $dbbilling.b_bayar b INNER JOIN $dbbilling.b_bayar_tindakan bt ON b.id=bt.bayar_id 
INNER JOIN $dbbilling.b_tindakan t ON bt.tindakan_id=t.id INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
WHERE bt.tipe=0 $waktu $kso AND p.unit_id='$unit_id'
UNION
SELECT bt.id,b.kunjungan_id,bt.nilai FROM $dbbilling.b_bayar b INNER JOIN $dbbilling.b_bayar_tindakan bt ON b.id=bt.bayar_id 
INNER JOIN $dbbilling.b_tindakan_kamar t ON bt.tindakan_id=t.id INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
WHERE bt.tipe=1 $waktu $ksoP AND p.unit_id='$unit_id') AS t1 GROUP BY t1.kunjungan_id) AS t2 
INNER JOIN $dbbilling.b_kunjungan k ON t2.kunjungan_id=k.id INNER JOIN $dbbilling.b_ms_pasien mp ON k.pasien_id=mp.id 
INNER JOIN $dbbilling.b_ms_unit mu ON t2.unit_id=mu.id) AS t3 $filter order by $sorting";
		  }
	}else if($grid == 2) {
		  if($inap == 0){
            $sql = "SELECT date_format(t.tgl,'%d-%m-%Y') AS tgl,mt.nama AS tindakan,u.nama as unit,t.biaya as biayaRS,t.biaya_kso,t.biaya_pasien
				,t.bayar,t.bayar_kso,t.bayar_pasien,pg.nama AS dokter,t.qty,ua.nama as unit_asal
				FROM $dbbilling.b_tindakan t
				  INNER JOIN $dbbilling.b_pelayanan p
				    ON t.pelayanan_id = p.id
				    INNER JOIN $dbbilling.b_ms_pegawai pg ON t.user_id = pg.id
				    INNER JOIN $dbbilling.b_ms_tindakan_kelas tk ON t.ms_tindakan_kelas_id = tk.id
				    INNER JOIN $dbbilling.b_ms_tindakan mt ON tk.ms_tindakan_id = mt.id
				    inner join $dbbilling.b_ms_unit u on p.unit_id = u.id
				    inner join $dbbilling.b_ms_unit ua on p.unit_id_asal = ua.id
				WHERE p.id = '$pel_id' $waktu";
		  }
		  else{
			$sql="SELECT t.pelayanan_id,t.kunjungan_id,DATE_FORMAT('$tgl','%d-%m-%Y') AS tgl,mt.nama tindakan,mu.nama unit,
u.nama as unit_asal,mp.nama dokter,t.qty,t.biaya*t.qty AS biayaRS,t.biaya_kso*t.qty AS biaya_kso,
t.biaya_pasien*t.qty AS biaya_pasien,t.bayar,t.bayar_kso,t.bayar_pasien
FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
INNER JOIN $dbbilling.b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id
INNER JOIN $dbbilling.b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id
INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id=mu.id
INNER JOIN $dbbilling.b_ms_unit u ON p.unit_id_asal = u.id
LEFT JOIN $dbbilling.b_ms_pegawai mp ON t.user_id=mp.id
WHERE t.pelayanan_id='$pel_id' AND t.kso_id='$kso' AND t.tgl='$tgl'
UNION
SELECT * FROM (SELECT t1.id pelayanan_id,t1.kunjungan_id,DATE_FORMAT('$tgl','%d-%m-%Y') AS tgl,
'Kamar' tindakan,t1.unit,t1.unit_asal,'' dokter,IF(t1.status_out=0,IF(t1.tgl_out IS NULL,1,IF(DATEDIFF(t1.tgl_out,t1.tgl_in)=0,1,IF(DATE(t1.tgl_out)='$tgl',0,1))),
IF(t1.tgl_out IS NULL,1,IF(DATEDIFF(t1.tgl_out,'$tgl')=0,0,1))) AS qty,
t1.tarip biayaRS,t1.beban_kso biaya_kso,t1.beban_pasien biaya_pasien,t1.bayar,t1.bayar_kso,t1.bayar_pasien
FROM (SELECT p.kunjungan_id,p.id,p.unit_id_asal,mu.nama unit,u.nama as unit_asal,tk.tgl_in,IFNULL(tk.tgl_out,k.tgl_pulang) AS tgl_out,
tk.tarip,tk.beban_kso,tk.beban_pasien,tk.bayar,tk.bayar_kso,tk.bayar_pasien,tk.status_out 
FROM $dbbilling.b_tindakan_kamar tk INNER JOIN $dbbilling.b_pelayanan p ON tk.pelayanan_id=p.id
INNER JOIN $dbbilling.b_kunjungan k ON p.kunjungan_id=k.id
INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id=mu.id
INNER JOIN $dbbilling.b_ms_unit u ON p.unit_id_asal = u.id
WHERE p.id='$pel_id' AND DATE(tk.tgl_in)<='$tgl' AND (DATE(tk.tgl_out) >='$tgl' OR tk.tgl_out IS NULL) 
AND (DATE(k.tgl_pulang) >='$tgl' OR k.tgl_pulang IS NULL) AND p.kso_id='$kso' AND tk.aktif=1) AS t1) AS t2 WHERE t2.qty>0";
		  }
    }
    
    if($grid == 1){
	   $sqlPlus = "select ifnull(sum(bayar),0) as totBayar from (".$sql.") sql36";
	   //echo $sqlPlus."<br>";
	   $rsPlus = mysql_query($sqlPlus);
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
    $unit_asal = '';

    if($grid == 1) {
		while ($rows=mysql_fetch_array($rs)) {
        	$i++;
			$dt.=$rows["id"]."|".$rows["unit_id"].chr(3).number_format($i,0,",","").chr(3).$rows["tglK"].chr(3).$rows["tglP"].chr(3).$rows["no_rm"].chr(3).$rows["pasien"].chr(3).$rows["unit"].chr(3).$rows["bayar"].chr(6);
        }
    }
    else if($grid == 2) {
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
			if($tipe == 4){
				$unit_asal = chr(3).$rows['unit_asal'];
			}
			
			$tPerda=$rows["biayaRS"];
			if ($ckso=="1"){
				$tKSO=0;
				$tPx=$tPerda;
				$tIur=0;
			}else{
				$tKSO=$rows["biaya_kso"];
				$tPx=0;
				$tIur=$rows["biaya_pasien"];
			}
			$tSelisih=$tPerda-($tKSO+$tPx+$tIur);
			
            $dt .= $rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["tgl"].chr(3).$rows["unit"].$unit_asal.chr(3).$rows["tindakan"].chr(3).$rows["dokter"].chr(3).$tPerda.chr(3).$tPx.chr(3).$tKSO.chr(3).$tIur.chr(3).$tSelisih.chr(6);
        }
    }

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5);
        $dt=str_replace('"','\"',$dt);
    }
    
    if($grid == 1){
	   if(mysql_num_rows($rsPlus) > 0){
		  $rowPlus = mysql_fetch_array($rsPlus);
		  if($rowPlus['totBayar']!=0){
			 $dt = $dt.number_format($rowPlus['totBayar'],0,",",".");
		  }
		  mysql_free_result($rsPlus);
	   }
    }
    mysql_free_result($rs);
}
mysql_close($konek);
///
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
}else {
    header("Content-type: text/xml");
}
echo $dt;
//*/
?>