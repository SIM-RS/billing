<?php
include("../koneksi/konek.php"); 
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

$statusProses='Fine';
//===============================

$idUser = $_REQUEST["idUser"];
$grd = $_REQUEST["grd"];
$kasir = $_REQUEST["kasir"];
$posting = $_REQUEST["posting"];
$act = $_REQUEST["act"];
$fdata = $_REQUEST["fdata"];
$tanggalAsli=$_REQUEST['tanggal'];
$tanggalan = explode('-',$_REQUEST['tanggal']);
$tanggal = $tanggalan[2].'-'.$tanggalan[1].'-'.$tanggalan[0];
$tglAwal = explode('-',$_REQUEST['tglAwal']);
$tanggalAwal = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
$tanggalAkhir = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];

$actUnverifikasi="";

switch ($act){
	case "loadkasir":
		$dt='<option value="0">SEMUA</option>';
		$qTmp = mysql_query("SELECT
									DISTINCT
									d.id, 
									d.nama
									FROM b_bayar a 
									INNER JOIN b_ms_pegawai d ON d.id=a.disetor_oleh
									WHERE a.disetor = 1 AND DATE(a.disetor_tgl)='".$tanggal."'
									ORDER BY d.nama");
		while($wTmp = mysql_fetch_array($qTmp))
		{
			$dt.='<option value="'.$wTmp["id"].'">'.$wTmp["nama"].'</option>';
		}
		echo $dt;
		return;
		break;
	case "verifikasi":
		$cdata=explode(chr(5),$fdata);		
		for ($i=0;$i<count($cdata);$i++)
		{
			$id_bayar=$cdata[$i];
			$sql="UPDATE b_bayar SET verifikasi_setor=1,verifikasi_setor_tgl=NOW(),verifikasi_setor_oleh='".$idUser."' WHERE id='".$id_bayar."'";
			//echo $sql."<br>";
			$rsPost=mysql_query($sql);
			if (mysql_errno()<=0)
			{
			
			}
			else
			{
				$statusProses='Error';
			}
		}
		break;
}

if($statusProses=='Error') 
{
	$dt="0".chr(5).chr(4).chr(5).$_REQUEST['act'];
}
else 
{


if ($filter!="") 
{
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting=="") 
	$sorting="no_kwitansi";
	
$sql = "SELECT * FROM 
(SELECT 
a.id,
a.kunjungan_id,
d.nama AS nm_pegawai,
DATE_FORMAT(a.disetor_tgl,'%d-%m-%Y %H:%i') as tgl_setor,
a.kasir_id,
c.no_rm,
c.nama,
a.no_kwitansi,
a.tgl,
a.tagihan,
a.nilai,
kso.nama as kso,
a.verifikasi_setor 
FROM b_bayar a 
INNER JOIN b_kunjungan b ON b.id=a.kunjungan_id
INNER JOIN b_ms_pasien c ON b.pasien_id=c.id 
INNER JOIN b_ms_pegawai d ON d.id=a.disetor_oleh
INNER JOIN b_ms_kso kso ON kso.id=a.kso_id
WHERE a.disetor = 1 AND a.verifikasi_setor='".$_REQUEST['posting']."' AND DATE(a.disetor_tgl)='".$tanggal."') AS tbl $filter ORDER BY ".$sorting;
					
//echo $sql."<br>";
$rs=mysql_query($sql);
//echo mysql_error();
$jmldata=mysql_num_rows($rs);
if ($page=="" || $page=="0") $page=1;
$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
$xsql=$sql;
$sql=$sql." limit $tpage,$perpage";
//echo $sql;

$rs=mysql_query($sql);
$i=($page-1)*$perpage;
$dt=$totpage.chr(5);

$ntot=0;
while ($rows=mysql_fetch_array($rs)) 
{
	$sTot="select IFNULL(SUM(nilai),0) AS total FROM (".$xsql.") AS gab";
	$qTot=mysql_query($sTot);
	$rwTot=mysql_fetch_array($qTot);
	$subTotal=$rwTot['total'];
	
	$i++;
	$nilai=$rows["nilai"];
	$sisip=$rows["id"];
	$dt.=$sisip.chr(3).$i.chr(3).$rows["tgl_setor"].chr(3).$rows["nm_pegawai"].chr(3).$rows["no_kwitansi"].chr(3).$rows["no_rm"].chr(3).
	$rows["nama"].chr(3).$rows["kso"].chr(3).number_format($nilai,0,",",".").chr(3).$rows["verifikasi_setor"].chr(6);
}	
	
if ($dt!=$totpage.chr(5)) {
	$dt=substr($dt,0,strlen($dt)-1).chr(5).$_REQUEST['act'].chr(1).number_format($subTotal,0,',','.');
	$dt=str_replace('"','\"',$dt);
}else{
	$dt="0".chr(5).chr(5).$_REQUEST['act'].chr(1).number_format($subTotal,0,',','.');
}

mysql_free_result($rs);
}
mysql_close($konek);

header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) 
{
 	header("Content-type: application/xhtml+xml");
}
else
{
 	header("Content-type: text/xml");
}
echo $dt;
?>