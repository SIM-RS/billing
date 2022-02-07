<?php
include("../../koneksi/konek.php");
//include '../loket/forAkun.php';
//====================================================================
//Paging,Sorting dan Filter======

$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

$grd = $_REQUEST["grd"];
$grd1 = $_REQUEST["grd1"];
$grd2 = $_REQUEST["grd2"];
$grd3 = $_REQUEST["grd3"];
$grd4 = $_REQUEST["grd4"];
$grdRsp1 = $_REQUEST["grdRsp1"];
$grdRsp2 = $_REQUEST["grdRsp2"];
$grdResep = $_REQUEST["grdResep"];
$pelayanan_id = $_REQUEST['pelayanan_id'];
$kunjungan_id = $_REQUEST['kunjungan_id'];
$isDokPengganti=$_REQUEST['isDokPengganti'];
$userId=$_REQUEST['userId'];
$unitId=$_REQUEST['unitId'];
$inap = $_GET['inap'];
$biayaRS = $_REQUEST['biaya'];
$act = $_REQUEST['pullMR'];

$sqlUn = "SELECT unit_id FROM b_pelayanan WHERE id = '".$_REQUEST['pelayanan_id']."'";
$rsUn = mysql_query($sqlUn);
$rwUn = mysql_fetch_array($rsUn);

$sqlDok = "SELECT id, nama FROM b_ms_pegawai WHERE id = '".$_REQUEST['dokter']."'";
$rsDok = mysql_query($sqlDok);
$rwDok = mysql_fetch_array($rsDok);

$statusProses='';
switch(strtolower($_REQUEST['act'])) {
    case 'dok_an':
	   $sql = "SELECT id,nama FROM b_ms_pegawai WHERE spesialisasi_id=42";
	   $rs_an = mysql_query($sql);
	   while($row_an = mysql_fetch_array($rs_an)){
		  ?>
		  <input type="hidden" id="hid_id_an" name="hid_id_an" value="<?php echo $row_an['id'];?>" />
		  <label>
			 <input type="checkbox" id="chk_an_<?php echo $row_an['id'];?>" name="chk_an" /> <?php echo $row_an['nama'];?>
		  </label><br>
		  <?php
	   }
	   return;
	   break;
    case 'tambah':
        switch($_REQUEST["smpn"]) {
            case 'btnSimpanDiag':
				/*-----Simpan Diagnosa-----*/
                $cekKasus="SELECT k.pasien_id,d.ms_diagnosa_id FROM b_diagnosa_rm d
						inner join b_kunjungan k on k.id=d.kunjungan_id
						where k.pasien_id='".$_REQUEST['pasienId']."' and d.ms_diagnosa_id='".$_REQUEST['idDiag']."'";
                $rsKasus=mysql_query($cekKasus);
                if(mysql_num_rows($rsKasus)>0) {
                    $kasusBaru='0';
                }
                else {
                    $kasusBaru='1';
                }
                $sqlTambah="insert into b_diagnosa_rm (ms_diagnosa_id,kunjungan_id,pelayanan_id,tgl,primer,kasus_baru,tgl_act,user_act,user_id,type_dokter) values('".$_REQUEST['idDiag']."','".$kunjungan_id."','".$pelayanan_id."',CURDATE(),'".$_REQUEST['isPrimer']."','".$kasusBaru."',now(),$userId,".$_REQUEST['idDok'].",$isDokPengganti)";
                //echo $sqlTambah."<br/>";
                $rs=mysql_query($sqlTambah);
                $statusProses='Fine';
                $sqlDilayani="update b_pelayanan set dilayani=1 where id='".$pelayanan_id."' and dilayani=0";
                $rsDilayani=mysql_query($sqlDilayani);
                break;
			}
    case 'simpan':
    //echo "update";
        switch($_REQUEST["smpn"]) {
            case 'btnSimpanDiag':
                $sqlUpdate="update b_diagnosa_rm set ms_diagnosa_id='".$_REQUEST['idDiag']."',primer='".$_REQUEST['isPrimer']."',user_act=$userId, user_id=".$_REQUEST['idDok'].",type_dokter='".$isDokPengganti."' where diagnosa_id='".$_REQUEST['id']."'";
		//pelayanan_id='".$pelayanan_id."',tgl=CURDATE(),tgl_act=now(),
                break;
            
        }
        //echo $sqlUpdate."<br/>";
        $rs=mysql_query($sqlUpdate);
        break;

    case 'hapus':
        switch($_REQUEST["hps"]) {
            case 'btnHapusDiag':
                $sqlHapus="delete from b_diagnosa_rm where diagnosa_id='".$_REQUEST['rowid']."'";
                break;
        }
        mysql_query($sqlHapus);
		if (mysql_errno()==0){
			if ($_REQUEST["hps"]=='btnHapusTind'){
				$sqlHapus.=";ket -> ".$cket;
				$sqlDelete=str_replace("'","''",$sqlHapus);
				$sql="INSERT INTO b_log_act(action,query,tgl_act,user_act) VALUES('Menghapus Data Tindakan','$sqlDelete',now(),'$userId')";
				mysql_query($sql);
			}
		}
	//INSYA ALLAH
        break;    
}
mysql_free_result($rsDok);
mysql_free_result($rsUn);
    
if($act == 'tarikMang'){
    echo 'Masuk';
    return;
}

	    
if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act'])."*|*".$_REQUEST["smpn"]."*|*".$_REQUEST["hps"];
}
else {
    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
    }
    if ($sorting=="") {
        $sorting='id';

        /*switch(strtolower($_REQUEST['grd'])){
			case 'tab1':
				$sorting="kode"; //default sort
			break;
			case 'tab2':
				$sorting="nama"; //default sort
			break;
		}*/
    }

    if($grd1 == "true") {
		$sql = "select * from (SELECT d.diagnosa_id as id,d.ms_diagnosa_id,md.kode,md.nama,d.pelayanan_id,
				d.user_id,p.nama as dokter,if(d.primer=1,'Utama','Bukan Utama') as utama, d.type_dokter
				FROM b_diagnosa_rm d 
				INNER JOIN b_ms_diagnosa md ON md.id=d.ms_diagnosa_id
				INNER JOIN b_pelayanan pl ON pl.id = d.pelayanan_id
				INNER JOIN b_ms_pegawai p ON p.id = d.user_id
				WHERE d.pelayanan_id = '".$pelayanan_id."') as gab $filter order by $sorting ";
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

    if($grd1 == "true") {
        while ($rows=mysql_fetch_array($rs)) {
            $sisip=$rows["id"]."|".$rows['user_id']."|".$rows['ms_diagnosa_id']."|".$rows['type_dokter'];
            $i++;
            $dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["kode"].chr(3).$rows["nama"].chr(3).$rows["dokter"].chr(3).$rows["utama"].chr(6);
        }
    }

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act'])."*|*".$_REQUEST["smpn"]."*|*".$_REQUEST["hps"];
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
