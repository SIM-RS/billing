<?php
include("../koneksi/konek.php");
include '../loket/forAkun.php';
$tindakan_id = $_REQUEST['tindakan_id'];
$value = $_REQUEST['value'];
$verifikator = $_REQUEST['verifikator'];
$act = $_REQUEST['act'];
$kamar=$_REQUEST['kamar'];

if($act == 'verifikasi'){
    if($kamar==''){
        $uTin="update b_tindakan set verifikasi='$value', verifikator='$verifikator' where id='$tindakan_id'";
        mysql_query($uTin);
        
        $sql = "select t.id,p.unit_id from b_tindakan t inner join b_pelayanan p on t.pelayanan_id = p.id where t.id = '$tindakan_id'";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_array($rs)){
            $uTinKam="update akuntansi.jurnal set status=1 where no_kw='".$row['id'].".".$row['unit_id']."'";
            mysql_query($uTinKam);
        }
        
        $cekVer="select t.verifikasi from b_tindakan t where t.verifikasi<>$value and t.pelayanan_id=(select pelayanan_id from b_tindakan where id='$tindakan_id')";
        $rsCekVer=mysql_query($cekVer);
        if(mysql_num_rows($rsCekVer)==0){
            $sql2 = "select t.verifikasi from b_tindakan_kamar t  where t.verifikasi='0' and t.pelayanan_id = (select pelayanan_id from b_tindakan where id='$tindakan_id')";
            $rs2 = mysql_query($sql2);
            if(mysql_num_rows($rs2)==0){
                $uVerP="update b_pelayanan set verifikasi='$value',verifikator='$verifikator' where id=(select pelayanan_id from b_tindakan where id='$tindakan_id')";
                $rsUVerP=mysql_query($uVerP);
            }
        }
        
        $cekVerPel="select p.verifikasi from b_pelayanan p where p.verifikasi<>$value and p.kunjungan_id=(select kunjungan_id from b_tindakan where id='$tindakan_id')";
        $rsCekVerPel=mysql_query($cekVerPel);
        if(mysql_num_rows($rsCekVerPel)==0){
            $uVerK="update b_kunjungan set verifikasi='$value' where id=(select kunjungan_id from b_tindakan where id='$tindakan_id')";
            $rsUVerK=mysql_query($uVerK);
        }
        
        $sVer="select verifikasi from b_tindakan where id='$tindakan_id'";
        $rsVer=mysql_query($sVer);
        $rwVer=mysql_fetch_array($rsVer);	
        
        if($rwVer['verifikasi']=='1'){
            echo "VERIFIKASI BERHASIL";
        }
        else{
            echo "VERIFIKASI BATAL!";
        }
    }else{
        $uTinKam="update b_tindakan_kamar set verifikasi='$value' where id='$tindakan_id'";
        mysql_query($uTinKam);
        
        $sql = "select t.id,p.unit_id from b_tindakan_kamar t inner join b_pelayanan p on t.pelayanan_id = p.id where t.id = '$tindakan_id'";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_array($rs)){
            $uTinKam="update akuntansi.jurnal set status=1 where no_kw='".$row['id'].".".$row['unit_id']."'";
            mysql_query($uTinKam);
        }
        
        $cekVer="select t.verifikasi from b_tindakan_kamar t where t.verifikasi<>$value and t.pelayanan_id=(select pelayanan_id from b_tindakan_kamar where id='$tindakan_id')";
        $rsCekVer=mysql_query($cekVer);
        if(mysql_num_rows($rsCekVer)==0){
            $sql2 = "select t.verifikasi from b_tindakan t  where t.verifikasi<>$value and t.pelayanan_id = (select pelayanan_id from b_tindakan_kamar where id='$tindakan_id')";
            $rs2 = mysql_query($sql2);
            if(mysql_num_rows($rs2)==0){
                $uVerP="update b_pelayanan set verifikasi='$value',verifikator='$verifikator' where id=(select pelayanan_id from b_tindakan_kamar where id='$tindakan_id')";
                $rsUVerP=mysql_query($uVerP);
            }
        }
        
        $cekVerPel="select p.verifikasi from b_pelayanan p where p.verifikasi<>$value and p.kunjungan_id=(select p.kunjungan_id from b_pelayanan p inner join b_tindakan_kamar t on t.pelayanan_id=p.id where t.id='$tindakan_id')";
        $rsCekVerPel=mysql_query($cekVerPel);
        if(mysql_num_rows($rsCekVerPel)==0){
            $uVerK="update b_kunjungan set verifikasi='$value' where id=(select p.kunjungan_id from b_pelayanan p inner join b_tindakan_kamar t on t.pelayanan_id=p.id where t.id='$tindakan_id')";
            $rsUVerK=mysql_query($uVerK);
        }
        
        $sVer="select verifikasi from b_tindakan_kamar where id='$tindakan_id'";
        $rsVer=mysql_query($sVer);
        $rwVer=mysql_fetch_array($rsVer);	
        
        if($rwVer['verifikasi']=='1'){
            echo "VERIFIKASI BERHASIL";
        }
        else{
            echo "VERIFIKASI BATAL!";
        }
        
    }
}
else if($act == 'cekVerifikasi'){
    
    $kunjId=$_REQUEST['kunjId'];
    $jnsRwt=$_REQUEST['jnsRwt'];
    $nmJnsRwt='';
    if($jnsRwt=='0'){
        $nmJnsRwt='RAWAT JALAN';
        $jnsKunj='1';
         /*$cek="SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
            WHERE b_pelayanan.kunjungan_id='$kunjId' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1";
            //echo $cek."<br>";
            $rsCek=mysql_query($cek);
            if(mysql_num_rows($rsCek)>0){
                $tambahan="AND l.id<(SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
                WHERE b_pelayanan.kunjungan_id='$kunjId' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1)";
            }
            else{
                $tambahan="";
            }
        
        $sql="SELECT SUM(IF(t.verifikasi='0',1,0)) AS belum,SUM(IF(t.verifikasi='1',1,0)) AS sudah,COUNT(t.verifikasi) AS total
            FROM b_tindakan t 
            INNER JOIN b_kunjungan k ON k.id=t.kunjungan_id 
            INNER JOIN b_pelayanan l ON t.pelayanan_id = l.id 
            LEFT JOIN b_ms_unit n ON l.unit_id_asal = n.id 
            WHERE ( n.parent_id <> 44 AND n.inap = 0 
            AND l.unit_id IN( SELECT mu.id FROM b_ms_unit mu
            WHERE mu.inap = 0 AND mu.parent_id <> 44) AND k.id='$kunjId') $tambahan";*/
        $sql="SELECT SUM(IF(t.verifikasi='0',1,0)) AS belum,SUM(IF(t.verifikasi='1',1,0)) AS sudah,COUNT(t.verifikasi) AS total
            FROM b_tindakan t 
            INNER JOIN b_pelayanan l ON t.pelayanan_id = l.id 
            WHERE l.jenis_kunjungan='$jnsKunj' AND l.kunjungan_id='$kunjId'";
            $rs=mysql_query($sql);
            //echo $sql."<br>";
            $rw=mysql_fetch_array($rs);            
            if($rw['total']>0){
                if($rw['belum']>0){
                    echo "VERIFIKASI ".$nmJnsRwt." (belum)";
                }
                else if($rw['sudah']==$rw['total']){
                    echo "VERIFIKASI ".$nmJnsRwt." (sudah)";
                }
            }
            else 
            {
                echo "TIDAK ADA DATA ".$nmJnsRwt;
            }
    }
    else if($jnsRwt=='1'){
        $nmJnsRwt='RAWAT INAP';
		$jnsKunj='3';
        /*$sql="SELECT SUM(IF(t.verifikasi='0',1,0)) AS belum,SUM(IF(t.verifikasi='1',1,0)) AS sudah,COUNT(t.verifikasi) AS total      
                FROM b_pelayanan p
                INNER JOIN b_ms_unit u ON u.id=p.unit_id
                INNER JOIN b_kunjungan k ON k.id=p.kunjungan_id
                INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
                WHERE p.kunjungan_id='$kunjId'
                AND p.id>=(SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
                WHERE b_pelayanan.kunjungan_id='$kunjId' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1)";*/
        $sql="SELECT SUM(IF(t.verifikasi='0',1,0)) AS belum,SUM(IF(t.verifikasi='1',1,0)) AS sudah,COUNT(t.verifikasi) AS total      
                FROM b_pelayanan p
                INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
                WHERE p.kunjungan_id='$kunjId' AND p.jenis_kunjungan='$jnsKunj'";
        $rs=mysql_query($sql);
        $rw=mysql_fetch_array($rs);
        /*$sql2="SELECT SUM(IF(tk.verifikasi='0',1,0)) AS belum,SUM(IF(tk.verifikasi='1',1,0)) AS sudah,COUNT(tk.verifikasi) AS total 
                FROM b_pelayanan p 
                INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
                WHERE p.kunjungan_id='$kunjId' 
                AND p.id>=(SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
                WHERE b_pelayanan.kunjungan_id='$kunjId' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1)";*/
        $sql2="SELECT SUM(IF(tk.verifikasi='0',1,0)) AS belum,SUM(IF(tk.verifikasi='1',1,0)) AS sudah,COUNT(tk.verifikasi) AS total 
                FROM b_pelayanan p 
                INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
                WHERE p.kunjungan_id='$kunjId' AND p.jenis_kunjungan='$jnsKunj'";
        $rs2=mysql_query($sql2);        
        $rw2=mysql_fetch_array($rs2);
        if(($rw2['total']>0)||($rw['total']>0)){
            if(($rw2['belum']>0) || ($rw['belum']>0)){
                echo "VERIFIKASI ".$nmJnsRwt." (belum)";
            }
            else if(($rw2['sudah']==$rw2['total']) && ($rw2['sudah']==$rw2['total'])){
                echo "VERIFIKASI ".$nmJnsRwt." (sudah)";
            }
        }
        else{
            echo "TIDAK ADA DATA ".$nmJnsRwt;
        }
    }
    else if($jnsRwt=='2'){
        $nmJnsRwt='IGD';
		$jnsKunj='2';
        $sql="SELECT SUM(IF(t.verifikasi='0',1,0)) AS belum,SUM(IF(t.verifikasi='1',1,0)) AS sudah,COUNT(t.verifikasi) AS total
        FROM b_tindakan t 
        INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id
        WHERE p.jenis_kunjungan='$jnsKunj' AND p.kunjungan_id='$kunjId'";
        $rs=mysql_query($sql);
        $rw=mysql_fetch_array($rs);
        if($rw['total']>0){
            if($rw['belum']>0){
                echo "VERIFIKASI ".$nmJnsRwt." (belum)";
            }
            else if($rw['sudah']==$rw['total']){
                echo "VERIFIKASI ".$nmJnsRwt." (sudah)";
            }
        }else{
            echo "TIDAK ADA DATA ".$nmJnsRwt;
        }
    }
}
else if($act == 'cekVerifikator'){
    $kunjId=$_REQUEST['kunjId'];
    $jnsRwt=$_REQUEST['jnsRwt'];
    if($jnsRwt=='0'){
		$jnsKunj='1';
        /*$cek="SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
           WHERE b_pelayanan.kunjungan_id='$kunjId' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1";
        $rsCek=mysql_query($cek);
        if(mysql_num_rows($rsCek)>0){
            $tambahan="AND l.id<(SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
            WHERE b_pelayanan.kunjungan_id='$kunjId' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1)";
        }
        else{
            $tambahan="";
        }
        $sql="SELECT distinct l.verifikator,w.nama FROM b_pelayanan l
        INNER JOIN b_ms_pegawai w ON l.verifikator=w.id
        INNER JOIN b_ms_unit u ON u.id=l.unit_id
        INNER JOIN b_ms_unit n ON n.id=l.jenis_layanan
        INNER JOIN b_ms_unit m ON m.id=l.unit_id_asal
        WHERE ( m.parent_id <> 44 AND n.inap = 0 
        AND l.unit_id IN( SELECT mu.id FROM b_ms_unit mu
        WHERE mu.inap = 0 AND mu.parent_id <> 44) AND l.kunjungan_id='$kunjId') $tambahan";*/
        $sql="SELECT distinct l.verifikator,w.nama FROM b_pelayanan l
        INNER JOIN b_ms_pegawai w ON l.verifikator=w.id
        WHERE l.jenis_kunjungan='$jnsKunj' AND l.kunjungan_id='$kunjId'";
    }else if($jnsRwt=='1'){
		$jnsKunj='3';
        /*$sql="SELECT distinct l.verifikator,w.nama
            FROM b_pelayanan l
            INNER JOIN b_ms_pegawai w ON l.verifikator=w.id
            INNER JOIN b_ms_unit u ON u.id=l.unit_id
            INNER JOIN b_ms_unit n ON n.id=l.jenis_layanan
            INNER JOIN b_ms_unit m ON m.id=l.unit_id_asal
            WHERE l.kunjungan_id='$kunjId' 
            AND l.id>=(SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
            WHERE b_pelayanan.kunjungan_id='$kunjId' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1)";*/
        $sql="SELECT distinct l.verifikator,w.nama
            FROM b_pelayanan l
            INNER JOIN b_ms_pegawai w ON l.verifikator=w.id
            WHERE l.kunjungan_id='$kunjId' AND l.jenis_kunjungan='$jnsKunj'";
    }else if($jnsRwt=='2'){
		$jnsKunj='2';
        /*$sql="SELECT distinct l.verifikator,w.nama
            FROM b_pelayanan l
            INNER JOIN b_ms_pegawai w ON l.verifikator=w.id
            INNER JOIN b_ms_unit u ON u.id=l.unit_id
            INNER JOIN b_ms_unit n ON n.id=l.jenis_layanan
            INNER JOIN b_ms_unit m ON m.id=l.unit_id_asal
            WHERE ( m.parent_id = 44 AND n.inap = 0 
            AND l.unit_id NOT IN( SELECT mu.id FROM b_ms_unit mu WHERE mu.inap = 1)
            OR l.unit_id IN (SELECT u.id FROM b_ms_unit u WHERE u.inap=0 AND u.parent_id = 44)) AND l.kunjungan_id='$kunjId'";*/
        $sql="SELECT distinct l.verifikator,w.nama
            FROM b_pelayanan l
            INNER JOIN b_ms_pegawai w ON l.verifikator=w.id
            WHERE l.kunjungan_id='$kunjId' AND l.jenis_kunjungan='$jnsKunj'";
    }
    
    $sql.=" AND l.verifikasi='1'";
    //echo $sql;
    $rs=mysql_query($sql);
    $jml=mysql_num_rows($rs);
    $no=1;
    while($rw=mysql_fetch_array($rs)){
        echo $rw['nama'];
        if($jml>1 && $no<($jml-1)){
            echo ',';
        }
    }
}
else if($act == 'setPelAs'){    
    $kunjId=$_REQUEST['kunjId'];
    $jnsRwt=$_REQUEST['jnsRwt'];
    
    if($jnsRwt==0){
        $cek="SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
           WHERE b_pelayanan.kunjungan_id='$kunjId' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1";
        $rsCek=mysql_query($cek);
        if(mysql_num_rows($rsCek)>0){
            $tambahan="AND l.id<(SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
            WHERE b_pelayanan.kunjungan_id='$kunjId' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1)";
        }
        else{
            $tambahan="";
        }
        $sql="SELECT l.id,l.unit_id,l.unit_id_asal,u.nama as unit,m.nama as asal,l.tgl,l.kelas_id,l.kso_id FROM b_pelayanan l       
        INNER JOIN b_ms_unit u ON u.id=l.unit_id
        INNER JOIN b_ms_unit n ON n.id=l.jenis_layanan
        INNER JOIN b_ms_unit m ON m.id=l.unit_id_asal
        WHERE ( m.parent_id <> 44 AND n.inap = 0 
        AND l.unit_id IN( SELECT mu.id FROM b_ms_unit mu
        WHERE mu.inap = 0 AND mu.parent_id <> 44) AND l.kunjungan_id='$kunjId') $tambahan";
    }
    else if($jnsRwt==1){
    $sql="SELECT l.id,l.unit_id,l.unit_id_asal,u.nama as unit,n.nama as asal,l.tgl,l.kelas_id,l.kso_id FROM b_pelayanan l 
        INNER JOIN b_ms_unit u ON u.id=l.unit_id
        INNER JOIN b_ms_unit n ON n.id=l.unit_id_asal
        where l.kunjungan_id='$kunjId'
         AND l.id>=(SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
            WHERE b_pelayanan.kunjungan_id='$kunjId' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1)";
    }
    else if($jnsRwt==2){
        $sql="SELECT l.id,l.unit_id,l.unit_id_asal,u.nama as unit,m.nama as asal,l.tgl,l.kelas_id,l.kso_id FROM b_pelayanan l            
            INNER JOIN b_ms_unit u ON u.id=l.unit_id
            INNER JOIN b_ms_unit n ON n.id=l.jenis_layanan
            INNER JOIN b_ms_unit m ON m.id=l.unit_id_asal
            WHERE ( m.parent_id = 44 AND n.inap = 0 
            AND l.unit_id NOT IN( SELECT mu.id FROM b_ms_unit mu WHERE mu.inap = 1)
            OR l.unit_id IN (SELECT u.id FROM b_ms_unit u WHERE u.inap=0 AND u.parent_id = 44)) AND l.kunjungan_id='$kunjId'";
    }
    $rs=mysql_query($sql);
    ?>
    <option value=""> Pilih Pelayanan</option>    
    <?php
    while($rw=mysql_fetch_array($rs)){        
        ?>
        <option value="<?php echo $rw['id'].'|'.$rw['unit_id'].'|'.$rw['unit_id_asal'].'|'.$rw['tgl'].'|'.$rw['kelas_id'].'|'.$rw['kso_id'];?>"><?php echo 'tgl: '.tglSQL($rw['tgl']).' | unit: '.$rw['unit'];?></option>
        <?php
    }
}
?>