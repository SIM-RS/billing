<?php
include("../koneksi/konek.php");
session_start();
include("../sesi.php");
//include '../loket/forAkun.php';
//====================================================================
//Paging,Sorting dan Filter======

$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

$grd = $_REQUEST["grd"];
$idPel = $_REQUEST["idPel"];
$kunj_id=$_REQUEST['kunjId'];
$jenisKB=$_REQUEST['jenisKB'];
$baru=$_REQUEST['baru'];
$binaan=$_REQUEST['binaan'];
$kbgagal=$_REQUEST['kbgagal'];
$efek=$_REQUEST['efek'];
$komplikasi=$_REQUEST['komplikasi'];
$gantiKB=$_REQUEST['gantiKB'];
$KBdari=$_REQUEST['KBdari'];
$KBke=$_REQUEST['KBke'];
$infertil=$_REQUEST['infertil'];
$id=$_REQUEST['id'];
$date=gmdate("Y-m-d H:i:s");
$id_user=$_REQUEST['userId'];
$statusProses='';
switch(strtolower($_REQUEST['act'])) {
    case 'tambah':
		$ins="INSERT INTO b_kb (kunjungan_id,pelayanan_id,ms_kb_id,baru,kb_binaan,kb_gagal,efek_samping,komplikasi,ganti_cara,ganti_dari,ganti_ke,infertil,tgl_act,user_act,flag) VALUES ('$kunj_id','$idPel','$jenisKB','$baru','$binaan','$kbgagal','$efek','$komplikasi','$gantiKB','$KBdari','$KBke','$infertil',NOW(),'$id_user','$flag')";
		//echo $ins."<br>";
		$r=mysql_query($ins);
    	break;
		case "update":
		$up="UPDATE  b_kb SET ms_kb_id='$jenisKB', baru='$baru', kb_binaan='$binaan', kb_gagal='$kbgagal', efek_samping='$efek',komplikasi='$komplikasi',ganti_cara='$gantiKB',ganti_dari='$KBdari',ganti_ke='$KBke',infertil='$infertil',flag='$flag' WHERE id='$id'";
		mysql_query($up);
		break;
		case "hapus":
		$del="DELETE FROM b_kb WHERE id='$id'";
		mysql_query($del);
		break;
}

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act']);
}
else {
    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
    }
    if ($sorting=="") {
        $sorting='id_napza_master';
    }

    if($grd == "grdIsiDataRM"){
		$sql="SELECT kb.*,mkb.kb jenis,efek.efeksamping_kompilkasi efek_samping,kompli.efeksamping_kompilkasi komplikasi,
			IF (kb.ganti_cara=0,'-',CONCAT('dari ',mkb1.kb,', ke',mkb2.kb)) gantiKB 
			FROM b_kb kb LEFT JOIN b_ms_kb mkb ON kb.ms_kb_id=mkb.id 
			LEFT JOIN b_ms_kb_efeksamping_komplikasi efek ON kb.efek_samping=efek.id
			LEFT JOIN b_ms_kb_efeksamping_komplikasi kompli ON kb.komplikasi=kompli.id
			LEFT JOIN b_ms_kb mkb1 ON kb.ganti_dari=mkb1.id LEFT JOIN b_ms_kb mkb2 ON kb.ganti_ke=mkb2.id
			WHERE kb.pelayanan_id='".$idPel."'";
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

    if($grd == "grdIsiDataRM") {
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
            $sisip=$rows["id"]."|".$rows["ms_kb_id"]."|".$rows["baru"]."|".$rows["kb_binaan"]."|".$rows["kb_gagal"]."|".$rows["efek_samping"]."|".$rows["komplikasi"]."|".$rows["ganti_cara"]."|".$rows["ganti_dari"]."|".$rows["ganti_ke"]."|".$rows["infertil"];
			
			$infertil="-";
			if ($rows["infertil"]==1){
				$infertil="Ditangani";
			}elseif ($rows["infertil"]==2){
				$infertil="Dirujuk";
			}
			
			$peserta="Lama";
			if ($rows["baru"]==1){
				$peserta="Baru";
			}
			
			$binaan="Tidak";
			if ($rows["binaan"]==1){
				$binaan="Ya";
			}
			
			$kbgagal="-";
			if ($rows["kb_gagal"]==1){
				$kbgagal="Ya";
			}
			
            $dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["jenis"].chr(3).$peserta.chr(3).$binaan.chr(3).$kbgagal.chr(3).$rows["efek_samping"].chr(3).$rows["komplikasi"].chr(3).$rows["gantiKB"].chr(3).$infertil.chr(6);
        }
    }

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']);
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
