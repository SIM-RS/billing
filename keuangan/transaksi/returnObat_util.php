<?php
session_start();
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$saringan='';
$filter=$_REQUEST["filter"];
//===============================
$act = strtolower(($_REQUEST['act']));


    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
    }
    if ($sorting=="") {
        $sorting="rp.tgl_retur ASC"; //default sort
    }

	$tempat = $_REQUEST["tempat"];
	$kso = $_REQUEST["kso"];
	$farmasi = $_REQUEST["farmasi"];
	$posting = $_REQUEST["posting"];
	$tanggals = tglSQL($_REQUEST['tanggals']);
	$tanggald = tglSQL($_REQUEST['tanggald']);
	
	
	$fdata=$_REQUEST['fdata'];
	switch($act){
    	case 'bayar':
			$tgllll=gmdate('d-m-Y',mktime(date('H')+7));
			$thhhh=explode("-",$tgllll);
			$blnNow = $thhhh[1];
			$thnNow = $thhhh[2];
			$arfdata=explode('*||*',$fdata);
			//print_r($arfdata);
			for ($i=0;$i < count($arfdata);$i++){
				$sNBayar = "SELECT IFNULL(MAX(ku.no_balik),0) maxno
					FROM {$dbapotek}.a_pengembalian_uang ku
					WHERE ku.no_pengembalian IS NOT NULL 
					  OR ku.no_balik IS NOT NULL
					  AND YEAR(ku.tgl_act) = YEAR(NOW())";
				$qNBayar = mysql_query($sNBayar);
				$dNbayar = mysql_fetch_array($qNBayar);
				if((int)$dNbayar['maxno'] > 0){
					$no_balik = (int)$dNbayar['maxno']+1;
					$depan = "";
					if(strlen($no_balik)<6){
						for($j=0; $j<(6-strlen($no_balik)); $j++){
							$depan .= 0;
						}
					} else {
						$depan = "";
					}
					$no_pengembalian = "RP".$thnNow.$depan.$no_balik;
				} else {
					$no_balik = 1;
					$no_pengembalian = "RP".$thnNow."000001";
				}
				
				$cdata=explode('|',$arfdata[$i]);
				$ishift = '0';
				$no_penjualan = $cdata[0];
				$no_retur = $cdata[1];
				$tot_balik = $cdata[2];
				$no_pasien = $cdata[3];
				$no_pelayanan = $cdata[4];
				$unit_id = $cdata[5];
				$tgl = $cdata[6];
				$iduser = $_SESSION['id'];
				
				$sqlPeng = "INSERT INTO {$dbapotek}.a_pengembalian_uang (no_penjualan, no_retur, no_balik, no_pengembalian, unit_id, nilai, tgl_act, user_act, no_rm, no_pelayanan, shift, status) VALUES ('{$no_penjualan}','{$no_retur}','{$no_balik}','{$no_pengembalian}','0','{$tot_balik}',NOW(),'{$iduser}','{$no_pasien}','{$no_pelayanan}','{$ishift}', 1)";
				//echo $sqlPeng."<br /><br />";
				$queryPeng = mysql_query($sqlPeng) or die (mysql_error());
				
				$sUpret = "UPDATE {$dbapotek}.a_return_penjualan rp
							INNER JOIN {$dbapotek}.a_penjualan ap
							   ON ap.ID = rp.idpenjualan
							SET rp.bayar = 1
							WHERE rp.no_retur = '{$no_retur}'
							  AND rp.balik_uang = 1
							  AND ap.NO_PENJUALAN = '{$no_penjualan}' 
							  AND ap.UNIT_ID = '{$unit_id}' 
							  AND ap.NO_PASIEN = '{$no_pasien}' 
							  AND ap.TGL = '{$tgl}'
							  AND rp.bayar = 0";
				//echo $sUpret."<br /><br />";
				$queryUpret = mysql_query($sUpret) or die (mysql_error());
			}
			//echo " +----------------------- ";
			break;
	}
	if($posting == '0'){
		$flunas = "AND rp.bayar = 0";
	} else {
		$flunas = "AND rp.bayar = 1";
	}
	if($farmasi == '0'){
		$ffar = "";
	} else {
		$ffar = "AND ap.UNIT_ID = '{$farmasi}'";
	}
	if($kso == '0'){
		$fkso = "";
	} else {
		$fkso = "AND ap.KSO_ID = '{$kso}'";
	}
	if($tempat == "0"){
		$funit = "";
	} else {
		$funit = "AND ap.RUANGAN = '{$tempat}'";
	}
	if($tanggals != "" && $tanggald != ""){
		$ftgl = "AND DATE(rp.tgl_retur) BETWEEN '{$tanggals} 00:00:00' AND '{$tanggald} 23:59:59'";
	}
	$sql = "SELECT ap.NO_KUNJUNGAN, ap.NO_PENJUALAN, ap.TGL, ap.UNIT_ID, ap.KSO_ID, ap.NO_PASIEN, ap.NAMA_PASIEN, 
				   rp.no_retur, DATE_FORMAT(rp.tgl_retur,'%d-%m-%Y %H:%i:%s') tgl_retur, SUM(rp.nilai) nilai, rp.userid_retur,
				   u.UNIT_NAME farmasi, r.UNIT_NAME ruangan, m.NAMA statuspx
			FROM {$dbapotek}.a_return_penjualan rp
			INNER JOIN {$dbapotek}.a_penjualan ap
			   ON ap.ID = rp.idpenjualan
			INNER JOIN {$dbapotek}.a_unit u
			   ON u.UNIT_ID = ap.UNIT_ID
			LEFT JOIN {$dbapotek}.a_unit r
			   ON r.UNIT_ID = ap.RUANGAN
			INNER JOIN {$dbapotek}.a_mitra m
			   ON m.IDMITRA = ap.KSO_ID
			WHERE rp.balik_uang = 1
			  {$flunas} {$ffar} {$funit} {$fkso} {$ftgl} {$filter}
			GROUP BY rp.no_retur, ap.NO_PENJUALAN
			ORDER BY $sorting";
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

	while($rows=mysql_fetch_array($rs)){
		//NO,NO RETUR,TGL RETUR,NORM,NAMA PASIEN,NILAI RETURN,BAYAR,UNIT FARMASI,TEMPAT LAYANAN,STATUS PX
//('{$no_penjualan}','{$no_retur}','{$no_balik}','{$no_pengembalian}','{$idunit}','{$tot_balik}',NOW(),'{$iduser}','{$no_pasien}','{$no_pelayanan}','{$ishift}')
		$i++;
		$param = $rows['NO_PENJUALAN']."|".$rows['no_retur']."|".$rows['nilai']."|".$rows['NO_PASIEN']."|".$rows['NO_KUNJUNGAN']."|".$rows['UNIT_ID']."|".$rows['TGL'];
		$dt.=$param.chr(3).$i.chr(3).$rows["no_retur"].chr(3).$rows["tgl_retur"].chr(3).$rows["NO_PASIEN"].chr(3).$rows["NAMA_PASIEN"].chr(3).number_format($rows["nilai"],0,",",".").chr(3)."0".chr(3).$rows["farmasi"].chr(3).$rows["ruangan"].chr(3).$rows["statuspx"].chr(6);
	}

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5).''."*|*";
        $dt=str_replace('"','\"',$dt);
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
