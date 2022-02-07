<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="tgl,id";
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
        $waktu = " and t.tgl = '$tgl' ";
        $tgl_k = "if(tk.tgl_out>='".$tgl."',1,0)";
        break;
    case 'periode':
        $tglAwal = tglSQL($_REQUEST['tglAwal']);
        $tglAkhir = tglSQL($_REQUEST['tglAkhir']);
        $waktu = " and t.tgl between '$tglAwal' and '$tglAkhir' ";
        $tgl_k = "if(tk.tgl_out>='$tglAwal' and tk.tgl_out<='$tglAkhir',1,0)";
        //'".$tglAkhir."'
        break;
    case 'bulan':
        $waktu = " AND (MONTH(t.tgl) = '".$bln."' AND YEAR(t.tgl) = '".$thn."') ";
        $tgl_k = "if(month(tk.tgl_out)>$bln,1,if(month(tk.tgl_out)=$bln,1,0))";
        //last_day('$thn-$bln-01')
        break;
}

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act'])."*|*".$alasan;
}
else {
    if ($filter!="") {
        $filter=explode("|",$filter);
        //if($tipe != 'lain2') {
            $filter=" where ".$filter[0]." like '%".$filter[1]."%'";
        /*}
        else {
            $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
        }*/
    }

    if ($sorting=="") {
        $sorting=$defaultsort;
        /*if($tipe != 'lain2') {
            $sorting = 'tgl';
        }*/
    }
    if($grid == 1) {
		if($tipe == '1') {
            //rawat jalan
            $sql = "SELECT * FROM (SELECT k.id,DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') AS tgl_p,
ps.no_rm,ps.nama AS pasien,t.* FROM (SELECT b.kunjungan_id,SUM(t.qty*t.biaya) AS biayaRS,SUM(bt.nilai) AS bayar_pasien 
FROM $dbbilling.b_bayar b INNER JOIN $dbbilling.b_bayar_tindakan bt ON b.id=bt.bayar_id INNER JOIN $dbbilling.b_tindakan t ON bt.tindakan_id=t.id
INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id_asal=mu.id 
WHERE (mu.parent_id <> 44 AND mu.inap = 0 AND p.unit_id IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=0 AND u.parent_id <> 44)) 
AND t.kso_id='$kso' AND b.tgl='$tgl' AND bt.tipe=0 AND bt.nilai>0 GROUP BY b.kunjungan_id) AS t
INNER JOIN $dbbilling.b_kunjungan k ON t.kunjungan_id=k.id INNER JOIN $dbbilling.b_ms_pasien ps ON k.pasien_id=ps.id) AS t1 $filter order by $sorting";
        }
        else if($tipe == '2') {
            //rawat inap
		  $sql = "SELECT * FROM (SELECT k.id,DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') AS tgl_p,
ps.no_rm,ps.nama AS pasien,t.* FROM (SELECT t1.kunjungan_id,SUM(biayaRS) AS biayaRS,SUM(bayar_pasien) AS bayar_pasien 
FROM (SELECT b.kunjungan_id,bt.id,bt.tipe,t.qty*t.biaya AS biayaRS,bt.nilai AS bayar_pasien 
FROM $dbbilling.b_bayar b INNER JOIN $dbbilling.b_bayar_tindakan bt ON b.id=bt.bayar_id INNER JOIN $dbbilling.b_tindakan t ON bt.tindakan_id=t.id
INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id_asal=mu.id 
INNER JOIN $dbbilling.b_ms_unit mu1 ON p.unit_id=mu1.id 
WHERE ((mu.inap = 1 AND mu1.inap=0) OR (mu.id=63 AND mu1.inap=0) OR mu1.inap=1) 
AND t.kso_id='$kso' AND b.tgl='$tgl' AND bt.tipe=0 AND bt.nilai>0
UNION
SELECT b.kunjungan_id,bt.id,bt.tipe,
IF(t.status_out=0,IF(DATEDIFF(IF(t.tgl_out IS NULL,'$tgl',IF(t.tgl_out>'$tgl','$tgl',t.tgl_out)),t.tgl_in)=0,1,
DATEDIFF(IF(t.tgl_out IS NULL,'$tgl',IF(t.tgl_out>'$tgl','$tgl',t.tgl_out)),t.tgl_in)),
DATEDIFF(IF(t.tgl_out IS NULL,'$tgl',IF(t.tgl_out>'$tgl','$tgl',t.tgl_out)),t.tgl_in))*t.tarip AS biayaRS,
bt.nilai AS bayar_pasien 
FROM $dbbilling.b_bayar b INNER JOIN $dbbilling.b_bayar_tindakan bt ON b.id=bt.bayar_id INNER JOIN $dbbilling.b_tindakan_kamar t ON bt.tindakan_id=t.id
INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id=mu.id 
WHERE mu.inap = 1 AND p.kso_id='$kso' AND b.tgl='$tgl' AND bt.tipe=1 AND bt.nilai>0) AS t1 GROUP BY t1.kunjungan_id) AS t
INNER JOIN $dbbilling.b_kunjungan k ON t.kunjungan_id=k.id INNER JOIN $dbbilling.b_ms_pasien ps ON k.pasien_id=ps.id) AS t1 $filter
				    ORDER BY $sorting";
        }
        else if($tipe == '3') {
            //igd
            $sql = "SELECT * FROM (SELECT k.id,DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') AS tgl_p,
ps.no_rm,ps.nama AS pasien,t.* FROM (SELECT b.kunjungan_id,SUM(t.qty*t.biaya) AS biayaRS,SUM(bt.nilai) AS bayar_pasien 
FROM $dbbilling.b_bayar b INNER JOIN $dbbilling.b_bayar_tindakan bt ON b.id=bt.bayar_id INNER JOIN $dbbilling.b_tindakan t ON bt.tindakan_id=t.id
INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id_asal=mu.id 
INNER JOIN $dbbilling.b_ms_unit mu1 ON p.unit_id=mu1.id 
WHERE ((mu.parent_id = 44 AND mu1.inap = 0 AND mu1.parent_id<>44) OR (mu1.parent_id=44 AND mu1.inap=0)) 
AND t.kso_id='$kso' AND b.tgl='$tgl' AND bt.tipe=0 AND bt.nilai>0 GROUP BY b.kunjungan_id) AS t
INNER JOIN $dbbilling.b_kunjungan k ON t.kunjungan_id=k.id INNER JOIN $dbbilling.b_ms_pasien ps ON k.pasien_id=ps.id) AS t1 $filter order by $sorting";
        }
        else if($tipe == '4') {
		  /*if($kso == 0){
			 $kso = "";
		  }
		  else{
			 if($inap == 1){
				$ksoP = " and p.kso_id = '$kso' ";
			 }
			 //$kso = " AND t.kso_id='$kso' ";
		  }*/
		  if($inap == 0){
			 //non-inap
			 $sql = "SELECT * FROM (SELECT k.id,DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') AS tgl_p,
ps.no_rm,ps.nama AS pasien,t.* FROM (SELECT b.kunjungan_id,mu.nama AS unit,SUM(t.qty*t.biaya) AS biayaRS,SUM(bt.nilai) AS bayar_pasien 
FROM $dbbilling.b_bayar b INNER JOIN $dbbilling.b_bayar_tindakan bt ON b.id=bt.bayar_id INNER JOIN $dbbilling.b_tindakan t ON bt.tindakan_id=t.id
INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id=mu.id 
WHERE p.unit_id='$unit_id' AND t.kso_id='$kso' AND b.tgl='$tgl' AND bt.tipe=0 AND bt.nilai>0 GROUP BY b.kunjungan_id) AS t
INNER JOIN $dbbilling.b_kunjungan k ON t.kunjungan_id=k.id INNER JOIN $dbbilling.b_ms_pasien ps ON k.pasien_id=ps.id) AS t1 $filter order by $sorting";
		  }
		  else{
			 //inap
		  $sql = "SELECT * FROM (SELECT k.id,DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') AS tgl_p,
ps.no_rm,ps.nama AS pasien,t.* FROM (SELECT t1.kunjungan_id,t1.unit,SUM(t1.biayaRS) AS biayaRS,SUM(t1.bayar_pasien) AS bayar_pasien 
FROM (SELECT t.id,bt.tipe,b.kunjungan_id,mu.nama AS unit,t.qty*t.biaya AS biayaRS,bt.nilai AS bayar_pasien 
FROM $dbbilling.b_bayar b INNER JOIN $dbbilling.b_bayar_tindakan bt ON b.id=bt.bayar_id INNER JOIN $dbbilling.b_tindakan t ON bt.tindakan_id=t.id
INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id=mu.id 
WHERE p.unit_id='$unit_id' AND t.kso_id='$kso' AND b.tgl='$tgl' AND bt.tipe=0 AND bt.nilai>0
UNION
SELECT t.id,bt.tipe,b.kunjungan_id,mu.nama AS unit,DATEDIFF(IF(t.tgl_out IS NULL,'$tgl',IF(t.tgl_out>'$tgl','$tgl',t.tgl_out)),t.tgl_in)*t.tarip AS biayaRS,bt.nilai AS bayar_pasien 
FROM $dbbilling.b_bayar b INNER JOIN $dbbilling.b_bayar_tindakan bt ON b.id=bt.bayar_id INNER JOIN $dbbilling.b_tindakan_kamar t ON bt.tindakan_id=t.id
INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id=mu.id 
WHERE p.unit_id='$unit_id' AND p.kso_id='$kso' AND b.tgl='$tgl' AND bt.tipe=1 AND bt.nilai>0) AS t1 GROUP BY t1.kunjungan_id) AS t
INNER JOIN $dbbilling.b_kunjungan k ON t.kunjungan_id=k.id INNER JOIN $dbbilling.b_ms_pasien ps ON k.pasien_id=ps.id) AS t1 $filter ORDER BY $sorting";
		  }
        }
    }
    else if($grid == 2) {
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
		  $sql = "SELECT *
				    FROM (SELECT
						  DATE_FORMAT('$tgl','%d-%m-%Y') AS tgl,
						  ifnull(mt.nama,'Kamar') AS tindakan,
						  u.nama AS unit,
						  t.biaya as biayaRS,
						  t.biaya_kso,
						  t.biaya_pasien,
						  t.bayar,
						  t.bayar_kso,
						  t.bayar_pasien, p.id,
						  pg.nama AS dokter,ua.nama as unit_asal
						FROM (SELECT
							   ms_tindakan_kelas_id,
							   pelayanan_id,
							   t.tgl,
							   qty,
							   biaya*qty as biaya,
							   biaya_kso*qty as biaya_kso,
							   biaya_pasien*qty as biaya_pasien,
							   bayar,
							   bayar_kso,
							   bayar_pasien,
							   user_id
							 FROM $dbbilling.b_tindakan t inner join $dbbilling.b_pelayanan p on t.pelayanan_id = p.id
							 WHERE p.id = '$pel_id'
								AND t.tgl = '$tgl' UNION SELECT
                                                0 AS ms_tindakan_kelas_id,
                                                pelayanan_id,
                                                '$tgl' AS tgl,
                                                1 AS qty,
                                                tarip AS biaya,
                                                beban_kso AS biaya_kso,
                                                beban_pasien AS biaya_pasien,
                                                bayar,
                                                bayar_kso,
                                                bayar_pasien,
                                                0 AS user_id
                                              FROM $dbbilling.b_tindakan_kamar tk inner join $dbbilling.b_pelayanan p on tk.pelayanan_id = p.id
                                              WHERE p.id = '$pel_id'
                                                  AND tk.tgl_in <= '$tgl'
                                                  AND (tk.tgl_out >= '$tgl'
                                                        OR tk.tgl_out IS NULL)) t
								INNER JOIN $dbbilling.b_pelayanan p
								  ON t.pelayanan_id = p.id
								LEFT JOIN $dbbilling.b_ms_pegawai pg
								  ON t.user_id = pg.id
								LEFT JOIN $dbbilling.b_ms_tindakan_kelas tk
								  ON t.ms_tindakan_kelas_id = tk.id
								LEFT JOIN $dbbilling.b_ms_tindakan mt
								  ON tk.ms_tindakan_id = mt.id
				    inner join $dbbilling.b_ms_unit ua on p.unit_id_asal = ua.id
								INNER JOIN $dbbilling.b_ms_unit u
								  ON p.unit_id = u.id) t1";
		  }
    }
    
    if($grid == 1){
	   $sqlPlus = "select sum(biayaRS) as totPer,sum(bayar_pasien) as totPas from (".$sql.") sql36";
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
			 if($tipe != 4){
				if($tipe == 1){
					//rawat jalan
					$sqlX = "SELECT DISTINCT mu1.nama 
FROM $dbbilling.b_bayar b INNER JOIN $dbbilling.b_bayar_tindakan bt ON b.id=bt.bayar_id 
INNER JOIN $dbbilling.b_tindakan t ON bt.tindakan_id=t.id
INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id_asal=mu.id
INNER JOIN $dbbilling.b_ms_unit mu1 ON p.unit_id=mu1.id  
WHERE (mu.parent_id <> 44 AND mu.inap = 0 AND p.unit_id IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=0 AND u.parent_id <> 44)) 
AND t.kso_id='$kso' AND b.tgl='$tgl' AND bt.tipe=0 AND b.kunjungan_id='".$rows["id"]."'";
				}
				else if($tipe == 2){
					//rawat inap
				    $sqlX = "SELECT DISTINCT t1.nama 
FROM (SELECT DISTINCT mu1.nama 
FROM $dbbilling.b_bayar b INNER JOIN $dbbilling.b_bayar_tindakan bt ON b.id=bt.bayar_id INNER JOIN $dbbilling.b_tindakan t ON bt.tindakan_id=t.id
INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id_asal=mu.id 
INNER JOIN $dbbilling.b_ms_unit mu1 ON p.unit_id=mu1.id 
WHERE ((mu.inap = 1 AND mu1.inap=0) OR (mu.id=63 AND mu1.inap=0) OR mu1.inap=1) 
AND t.kso_id='$kso' AND b.tgl='$tgl' AND bt.tipe=0 AND bt.nilai>0 AND b.kunjungan_id='".$rows["id"]."'
UNION
SELECT DISTINCT mu.nama 
FROM $dbbilling.b_bayar b INNER JOIN $dbbilling.b_bayar_tindakan bt ON b.id=bt.bayar_id INNER JOIN $dbbilling.b_tindakan_kamar t ON bt.tindakan_id=t.id
INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id=mu.id 
WHERE mu.inap = 1 AND p.kso_id='$kso' AND b.tgl='$tgl' AND bt.tipe=1 AND bt.nilai>0 AND b.kunjungan_id='".$rows["id"]."') AS t1";
				}
				else if($tipe == 3){
					//igd
				    $sqlX = "SELECT DISTINCT mu1.nama 
FROM $dbbilling.b_bayar b INNER JOIN $dbbilling.b_bayar_tindakan bt ON b.id=bt.bayar_id INNER JOIN $dbbilling.b_tindakan t ON bt.tindakan_id=t.id
INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id_asal=mu.id 
INNER JOIN $dbbilling.b_ms_unit mu1 ON p.unit_id=mu1.id 
WHERE ((mu.parent_id = 44 AND mu1.inap = 0 AND mu1.parent_id<>44) OR (mu1.parent_id=44 AND mu1.inap=0)) 
AND t.kso_id='$kso' AND b.tgl='$tgl' AND bt.tipe=0 AND bt.nilai>0 AND b.kunjungan_id='".$rows["id"]."'";
					    //AND t.kso_id='$kso'
				}

				$rsX = mysql_query($sqlX);
				while($rowsX = mysql_fetch_array($rsX)){
				    $tmpLay .= $rowsX['nama'].', ';
				}
				$tmpLay = substr($tmpLay,0,strlen($tmpLay)-2);
			 }else{
			 	$tmpLay = $rows['unit'];
			 }
			 
                $dt.=$rows["id"].'|'.$rows['pelayanan_id'].chr(3).number_format($i,0,",","").chr(3).$rows["tgl"].chr(3).$rows["tgl_p"].chr(3).$rows["no_rm"].chr(3).$rows["pasien"].chr(3).$tmpLay.$unit_asal.chr(3).$rows["biayaRS"].chr(3).$rows["bayar_pasien"].chr(3).($rows["biayaRS"]-($rows["bayar_pasien"])).chr(6);
                $tmpLay = '';
          }
    }
    else if($grid == 2) {
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
		  if($tipe == 4){
			 $unit_asal = chr(3).$rows['unit_asal'];
		  }
            $dt .= $rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["tgl"].chr(3).$rows["unit"].$unit_asal.chr(3).$rows["tindakan"].chr(3).$rows["dokter"].chr(3).$rows["biayaRS"].chr(3).$rows["biaya_kso"].chr(3).$rows["biaya_pasien"].chr(3).($rows["biayaRS"]-($rows["biaya_kso"]+$rows["biaya_pasien"])).chr(3).$rows["bayar_kso"].chr(3).$rows["bayar_pasien"].chr(6);
        }
    }

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']);
        $dt=str_replace('"','\"',$dt);
    }
    
    if($grid == 1){
	   if(mysql_num_rows($rsPlus) > 0){
		  $rowPlus = mysql_fetch_array($rsPlus);
		  if($rowPlus['totPer']!=0 && $grid == 1){
			 $dt = $dt.number_format($rowPlus['totPer'],0,",",".").chr(3).number_format($rowPlus['totPas'],0,",",".");
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