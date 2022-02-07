<?php
/*$hostname_conn = "localhost";
//$hostname_conn = "192.168.1.2";
$database_conn = "billing";
$username_conn = "root";
$password_conn = "root";
//$password_conn = "rsudsda";

$konek=mysql_connect($hostname_conn,$username_conn,$password_conn);
mysql_select_db($database_conn,$konek);*/

include '../koneksi/konek.php';
$idunit=$_REQUEST["idunit"];

$date_now=gmdate('Y-m-d',mktime(date('H')+7));
/*function tglSQL($tgl){
   $t=explode(" ",$tgl);
   $t=explode("-",$t[0]);
   $t=$t[2].'-'.$t[1].'-'.$t[0];
   return $t;
}*/
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$saringan='';
$dilayani="";
$no_rm = $_REQUEST['no_rm'];
$filter=$_REQUEST["filter"];
$act = $_GET['act'];
//===============================
$statusProses='';
$grd3 = $_REQUEST['grd3'];
$grd = strtolower($_REQUEST["grd"]);

if($_REQUEST['loadRunTxt']=='true') {
	$sql="SELECT keterangan FROM b_running_text ORDER BY urutan";
	$rs=mysql_query($sql);
	$txt="";
	while ($rw=mysql_fetch_array($rs)){
		$txt .=$rw["keterangan"]."&nbsp;&nbsp;&nbsp;";
	}
	echo $txt;
	return;
}

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act']);
}
else {
    if($_REQUEST['saring']=='true') {
        if($_REQUEST['inap']=='1') {
			/*if($_REQUEST['dilayani']=='-1'){
				$saringan=" where (k.pulang=1 and date(k.tgl_pulang) = '".tglSQL($_REQUEST['saringan'])."' or (pl.dilayani = 2 and date(pl.tgl_krs)='".tglSQL($_REQUEST['saringan'])."')) and pl.unit_id='".$_REQUEST['idunit']."'";
			// or (pl.dilayani=2 and date(tk.tgl_out) = '".tglSQL($_REQUEST['saringan'])."')
			}
			else{*/
				$saringan=" where k.pulang=0 and pl.unit_id='".$_REQUEST['idunit']."'";
				/*if($_REQUEST['dilayani']=='1') {
					$dilayani=" and pl.dilayani=1 AND tk.tgl_out IS NULL "; //sudah dilayani
				}
				elseif($_REQUEST['dilayani']=='0') {*/
					$dilayani=" and pl.dilayani=0 AND tk.tgl_out IS NULL "; //belum dilayani
				/*}
				else {
					$dilayani=" and (pl.dilayani=0 OR pl.dilayani=1) AND tk.tgl_out IS NULL "; //belum+sudah dilayani
				}*/
	    	//}
        }
        else {
            $saringan=" where pl.tgl = '$date_now' and pl.unit_id='".$_REQUEST['idunit']."' and pl.dilayani=0 ";
        }
    }else{
        $saringan=" where pl.tgl = '$date_now' ";
    }

    if ($sorting=="") {
        $sorting="no_antrian";
    }

    if($grd == "true") {
			$sql="SELECT distinct * from (SELECT p.id, pl.id AS idp, p.no_rm,p.nama,p.sex,pl.no_antrian, p.alamat,
				(SELECT nama FROM b_ms_wilayah WHERE id = p.desa_id) desa, 
				(SELECT nama FROM b_ms_wilayah WHERE id = p.kec_id) kec,
				(SELECT nama FROM b_ms_wilayah WHERE id = p.kab_id) kab,
				(SELECT nama FROM b_ms_wilayah WHERE id = p.prop_id) prop,
				(SELECT IF(kategori=1,nama,CONCAT('Dirujuk dari: ',nama)) FROM b_ms_unit WHERE id = pl.unit_id_asal) AS asalunit,
				(SELECT nama FROM b_ms_unit WHERE id = pl.unit_id) unit,
				DATE_FORMAT(pl.tgl_act,'%d-%m-%Y %H:%i') AS tgl_act,
				IFNULL(kso.nama,'UMUM') AS namakso
				FROM b_ms_pasien p 
				INNER JOIN b_kunjungan k ON k.pasien_id = p.id
				INNER JOIN b_pelayanan pl ON k.id = pl.kunjungan_id
				inner join b_ms_unit u on pl.unit_id = u.id
				LEFT JOIN b_ms_kso kso ON kso.id = k.kso_id
				".$saringan." ".$dilayani.") as gab ".$filter." order by ".$sorting;
		//}
    }
    else if($grd == 'tarik'){
		$sorting="idp";
		if ($idunit=="") $idunit="1";
		$saringan .=" AND u.parent_id=$idunit";
       $sql="SELECT distinct * from (SELECT p.id, pl.id AS idp, p.no_rm,p.nama,p.sex,pl.no_antrian,p.alamat,if(pl.dilayani=1,'SUDAH','BELUM') as status_dilayani, 
(SELECT nama FROM b_ms_wilayah WHERE id = p.desa_id) desa, 
(SELECT nama FROM b_ms_wilayah WHERE id = p.kec_id) kec,
(SELECT nama FROM b_ms_wilayah WHERE id = p.kab_id) kab,
(SELECT nama FROM b_ms_wilayah WHERE id = p.prop_id) prop,
u.nama unit,
DATE_FORMAT(pl.tgl_act,'%d-%m-%Y %H:%i') AS tgl_act,
IFNULL(kso.nama,'UMUM') AS namakso
FROM b_ms_pasien p 
INNER JOIN b_kunjungan k ON k.pasien_id = p.id
INNER JOIN b_pelayanan pl ON k.id = pl.kunjungan_id
INNER JOIN b_ms_unit u ON pl.unit_id=u.id
LEFT JOIN b_ms_kso kso ON kso.id = pl.kso_id ".$saringan.") as gab ".$filter." order by ".$sorting;
    }else if($grd3 == "true"){
		$sql = "SELECT b_ms_unit.id, nama, count(b_kunjungan.id) as jml FROM b_ms_unit 
				inner join b_kunjungan ON b_kunjungan.unit_id = b_ms_unit.id
				WHERE parent_id=1 and b_kunjungan.tgl = '$date_now'
				group by b_ms_unit.id
				order by nama";
	}
    
   	//echo $sql."<br>";
    $rs=mysql_query($sql);    
    $jmldata=mysql_num_rows($rs);
	$perpage=17;
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
            $sisip = $rows['id']."|".$rows['idp']."|".$rows['idk'];
            $i++;
            $dt.=$rows['id'].chr(3).$rows["no_antrian"].chr(3).$rows["no_rm"].chr(3).$rows["nama"].chr(3).$rows["namakso"].chr(6);
        }
    }
    else if($grd == "tarik"){
        while ($rows=mysql_fetch_array($rs)) {
            $sisip = $rows['id']."|".$rows['idp']."|".$rows['idk'];
            $i++;
            $dt.=$sisip.chr(3).$i.chr(3).$rows["no_rm"].chr(3).$rows["nama"].chr(3).$rows["namakso"].chr(3).$rows['unit'].chr(3).$rows['status_dilayani'].chr(6);
        }
    }
    else if($grd3 == "true"){
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
            $dt.=$rows['id'].chr(3).$i.chr(3).$rows["nama"].chr(3).$rows["jml"].chr(6);
        }
    }

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act'])."*|*";
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
