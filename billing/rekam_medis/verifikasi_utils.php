<?php
include("../koneksi/konek.php");
include '../loket/forAkun.php';
$pelayanan_id = $_REQUEST['pelayanan_id'];
$act = $_REQUEST['act'];
if($act == 'verifikasi'){
    $uVer="update b_pelayanan set verifikasi='1',verifikator='".$_REQUEST['verifikator']."' where id='$pelayanan_id'";
    $rsUVer=mysql_query($uVer);
    if($rsUVer){
        $uTin="update b_tindakan set verifikasi='1' where pelayanan_id='$pelayanan_id'";
        mysql_query($uTin);
        
        $uTinKam="update b_tindakan_kamar set verifikasi='1' where pelayanan_id='$pelayanan_id'";
        mysql_query($uTinKam);
        
        $sql = "select t.id,p.unit_id from b_tindakan t inner join b_pelayanan p on t.pelayanan_id = p.id where p.id = '$pelayanan_id'";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_array($rs)){
            $uTinKam="update akuntansi.jurnal set status=1 where no_kw='".$row['id'].".".$row['unit_id']."'";
            mysql_query($uTinKam);
        }
    }
    
    $sVer="SELECT verifikasi,pg.nama AS verifikator FROM b_pelayanan p 
    INNER JOIN b_ms_pegawai pg ON p.verifikator=pg.id
    WHERE p.id='$pelayanan_id'";
    $rsVer=mysql_query($sVer);
    $rwVer=mysql_fetch_array($rsVer);	
    
    if($rwVer['verifikasi']=='1'){
        echo "VERIFIKASI (sudah)";
    }
    else{
        echo "VERIFIKASI (belum)";
    }
}
?>