<?php
	include('../koneksi/konek.php');
	include('../sesi.php');
	//Paging,Sorting dan Filter======
	$page=$_REQUEST["page"];
	$defaultsort="tglKun";
	$sorting=$_REQUEST["sorting"];
	$filter=$_REQUEST["filter"];
	$waktu = $_REQUEST["waktu"];
	//===============================
	//===============================
	$kso 	= $_REQUEST['kso'];
	$grid 	= $_REQUEST['grid'];
	$tgl 	= tglSQL($_REQUEST['txtTgl']);
	$tgl2 	= tglSQL($_REQUEST['txtTgl2']);
	//===============================
	
	$fkso="";
	if ($kso!="0"){
		$fkso=" AND k.kso_id='$kso'";
	}
	
	if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
    }

    if ($sorting=="") {
        $sorting = $defaultsort;
    }

	switch($waktu){
		case "harian":
			$fwaktu = " AND tglDel = '{$tgl}'";
			break;
		case "periode":
			$fwaktu = " AND tglDel BETWEEN '{$tgl}' AND '{$tgl2}'";
			break;
		case "bulan":
			$bln = $_REQUEST['bln'];
			$thn = $_REQUEST['thn'];
			$fwaktu = " AND MONTH(tglDel) = '{$bln}' AND YEAR(tglDel) = '{$thr}'";
			break;
	}
	
	switch($grid){
		case "1":
			$sql = "SELECT * FROM (SELECT k.id, k.tgl tglKun, pas.no_rm, pas.nama, pas.alamat, u.nama kunjungan, kso.nama ksoNama, 
						DATE(k.act_time) tglDel, IFNULL(SUM(t.biaya),0) biayaRS, IFNULL(SUM(t.biaya_kso),0) biayaKSO, 
						IFNULL(SUM(t.biaya_pasien),0) biayaPx
					FROM $dbbilling.b_kunjungan_act k
					INNER JOIN $dbbilling.b_ms_pasien pas ON pas.id = k.pasien_id
					INNER JOIN $dbbilling.b_ms_unit u ON u.id = k.unit_id
					INNER JOIN $dbbilling.b_ms_kso kso ON kso.id = k.kso_id
					LEFT JOIN $dbbilling.b_tindakan_act t ON t.kunjungan_id = k.id
					WHERE k.act_tipe = 1 AND pas.flag = '$flag' {$fkso}
					GROUP BY k.id) tb
					WHERE 0 = 0 {$fwaktu} {$filter}
					GROUP BY id
					ORDER BY {$sorting}";
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
	
	switch($grid){
		case "1":
			while ($rows=mysql_fetch_array($rs)) {
				$i++;			
				$sisip=$rows["id"]."|".$rows["tglKun"];
				$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).tglSQL($rows["tglDel"]).chr(3).tglSQL($rows["tglKun"]).chr(3).$rows["no_rm"].chr(3).$rows["nama"].chr(3).$rows['alamat'].chr(3).$rows['ksoNama'].chr(3).$rows['kunjungan'].chr(3).number_format($rows['biayaRS'],0,",",".").chr(3).number_format($rows['biayaKSO'],0,",",".").chr(3).number_format($rows['biayaPx'],0,",",".").chr(6);
			}
			break;
	}
	
	if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5);
        $dt=str_replace('"','\"',$dt);
    }else{
		$dt = $dt.chr(5).number_format($totPer,0,",",".").chr(3).number_format($totPas,0,",",".").chr(3).number_format($totKso,0,",",".").chr(3).number_format($totbayarPas,0,",",".").chr(3).number_format($totPiutangPx,0,",",".").chr(3).$alasan;
	}
    
    mysql_free_result($rs);
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