<?php 
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="nama";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$id=$_GET['id'];
$idPasien=$_REQUEST['idPasien'];
$idKunj=$_REQUEST['idKunj'];
$jnsRwt=$_REQUEST['jnsRwt'];
//===============================

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
}

if($jnsRwt=='0'){
			/*
            $cek="SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
            WHERE b_pelayanan.kunjungan_id='$idKunj' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1";
            $rsCek=mysql_query($cek);
            if(mysql_num_rows($rsCek)>0){
                $sql="SELECT t.id,t.ms_tindakan_kelas_id,t.pelayanan_id,m.nama AS jenis ,
                l.unit_id,u.parent_id,u.nama AS unit,t.tgl,mt.nama AS tindakan,
                tk.ms_kelas_id,mk.nama AS kelas,t.qty AS jumlah, t.biaya,t.biaya_kso,t.biaya_pasien,t.bayar_pasien,t.verifikasi 
                FROM b_tindakan t 
                INNER JOIN b_kunjungan k ON k.id=t.kunjungan_id 
                INNER JOIN b_pelayanan l ON t.pelayanan_id = l.id 
                LEFT JOIN b_ms_unit n ON l.unit_id_asal = n.id 
                LEFT JOIN b_ms_unit u ON u.id=l.unit_id
                LEFT JOIN b_ms_unit m ON m.id=u.parent_id
                INNER JOIN b_ms_tindakan_kelas tk ON tk.id=t.ms_tindakan_kelas_id 
                INNER JOIN b_ms_tindakan mt ON mt.id=tk.ms_tindakan_id 
                INNER JOIN b_ms_kelas mk ON mk.id=tk.ms_kelas_id 
                WHERE ( n.parent_id <> 44 AND n.inap = 0
                AND l.unit_id IN( SELECT mu.id FROM b_ms_unit mu
                WHERE mu.inap = 0 AND mu.parent_id <> 44) AND k.id='$idKunj') AND
                l.id<(SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
                WHERE b_pelayanan.kunjungan_id='$idKunj' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1) ORDER BY mt.nama,t.id";
            }
            else{
                $sql="SELECT t.id,t.ms_tindakan_kelas_id,t.pelayanan_id,m.nama AS jenis ,
                l.unit_id,u.parent_id,u.nama AS unit,t.tgl,mt.nama AS tindakan,
                tk.ms_kelas_id,mk.nama AS kelas,t.qty AS jumlah, t.biaya,t.biaya_kso,t.biaya_pasien,t.bayar_pasien,t.verifikasi 
                FROM b_tindakan t 
                INNER JOIN b_kunjungan k ON k.id=t.kunjungan_id 
                INNER JOIN b_pelayanan l ON t.pelayanan_id = l.id 
                LEFT JOIN b_ms_unit n ON l.unit_id_asal = n.id 
                LEFT JOIN b_ms_unit u ON u.id=l.unit_id
                LEFT JOIN b_ms_unit m ON m.id=u.parent_id
                INNER JOIN b_ms_tindakan_kelas tk ON tk.id=t.ms_tindakan_kelas_id 
                INNER JOIN b_ms_tindakan mt ON mt.id=tk.ms_tindakan_id 
                INNER JOIN b_ms_kelas mk ON mk.id=tk.ms_kelas_id 
                WHERE ( n.parent_id <> 44 AND n.inap = 0
                AND l.unit_id IN( SELECT mu.id FROM b_ms_unit mu
                WHERE mu.inap = 0 AND mu.parent_id <> 44) AND k.id='$idKunj')";
            }
			*/
			$sql="SELECT t.id,t.ms_tindakan_kelas_id,t.pelayanan_id,m.nama AS jenis ,
                l.unit_id,u.parent_id,u.nama AS unit,t.tgl,mt.nama AS tindakan,
                tk.ms_kelas_id,mk.nama AS kelas,t.qty AS jumlah, t.biaya,t.biaya_kso,t.biaya_pasien,t.bayar_pasien,t.verifikasi 
                FROM b_tindakan t 
                INNER JOIN b_kunjungan k ON k.id=t.kunjungan_id 
                INNER JOIN b_pelayanan l ON t.pelayanan_id = l.id 
                LEFT JOIN b_ms_unit n ON l.unit_id_asal = n.id 
                LEFT JOIN b_ms_unit u ON u.id=l.unit_id
                LEFT JOIN b_ms_unit m ON m.id=u.parent_id
                INNER JOIN b_ms_tindakan_kelas tk ON tk.id=t.ms_tindakan_kelas_id 
                INNER JOIN b_ms_tindakan mt ON mt.id=tk.ms_tindakan_id 
                INNER JOIN b_ms_kelas mk ON mk.id=tk.ms_kelas_id 
                WHERE l.jenis_kunjungan=1 AND k.id='$idKunj'";
        }
        elseif($jnsRwt=='1'){
			/*
            $sql="SELECT t.id,t.ms_tindakan_kelas_id,t.pelayanan_id,n.nama AS jenis ,
            p.unit_id,mu.parent_id,mu.nama AS unit,t.tgl,mt.nama AS tindakan,
            tk.ms_kelas_id,mk.nama AS kelas,t.qty AS jumlah, t.biaya,t.biaya_kso,t.biaya_pasien,t.bayar_pasien,t.verifikasi
            FROM b_pelayanan p 
            INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
            INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
            LEFT JOIN b_ms_unit n ON n.id=mu.parent_id
            INNER JOIN b_ms_tindakan_kelas tk ON tk.id=t.ms_tindakan_kelas_id
            INNER JOIN b_ms_tindakan mt ON mt.id = tk.ms_tindakan_id
            INNER JOIN b_ms_kelas mk ON mk.id=tk.ms_kelas_id 
            WHERE p.kunjungan_id='$idKunj' 
            AND p.id>=(SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
            WHERE b_pelayanan.kunjungan_id='$idKunj' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1) ORDER BY mt.nama,t.id";
			*/
			$sql="SELECT t.id,t.ms_tindakan_kelas_id,t.pelayanan_id,n.nama AS jenis ,
            p.unit_id,mu.parent_id,mu.nama AS unit,t.tgl,mt.nama AS tindakan,
            tk.ms_kelas_id,mk.nama AS kelas,t.qty AS jumlah, t.biaya,t.biaya_kso,t.biaya_pasien,t.bayar_pasien,t.verifikasi
            FROM b_pelayanan p 
            INNER JOIN b_ms_unit mu ON p.unit_id=mu.id
            INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
            LEFT JOIN b_ms_unit n ON n.id=mu.parent_id
            INNER JOIN b_ms_tindakan_kelas tk ON tk.id=t.ms_tindakan_kelas_id
            INNER JOIN b_ms_tindakan mt ON mt.id = tk.ms_tindakan_id
            INNER JOIN b_ms_kelas mk ON mk.id=tk.ms_kelas_id 
            WHERE p.kunjungan_id='$idKunj' 
            AND p.jenis_kunjungan=3 ORDER BY mt.nama,t.id";
        }
        elseif($jnsRwt=='2'){
			/*
            $sql="SELECT t.id,t.ms_tindakan_kelas_id,t.pelayanan_id,m.nama AS jenis ,
            p.unit_id,mu.parent_id,mu.nama AS unit,t.tgl,mt.nama AS tindakan,
            tk.ms_kelas_id,mk.nama AS kelas,t.qty AS jumlah, t.biaya,t.biaya_kso,t.biaya_pasien,t.bayar_pasien,t.verifikasi
            FROM b_tindakan t 
            INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id
            INNER JOIN b_ms_unit mu ON p.unit_id_asal=mu.id
            INNER JOIN b_ms_unit n ON p.unit_id=n.id
            LEFT JOIN b_ms_unit m ON m.id=n.parent_id
            INNER JOIN b_ms_tindakan_kelas tk ON tk.id=t.ms_tindakan_kelas_id 
            INNER JOIN b_ms_tindakan mt ON mt.id=tk.ms_tindakan_id 
            INNER JOIN b_ms_kelas mk ON mk.id=tk.ms_kelas_id 
            WHERE (mu.parent_id = 44 AND mu.inap = 0 
            AND p.unit_id NOT IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=1) 
            OR p.unit_id IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=0 AND u.parent_id = 44)) AND p.kunjungan_id='$idKunj'";
			*/
			
			$sql="SELECT t.id,t.ms_tindakan_kelas_id,t.pelayanan_id,m.nama AS jenis ,
            p.unit_id,mu.parent_id,mu.nama AS unit,t.tgl,mt.nama AS tindakan,
            tk.ms_kelas_id,mk.nama AS kelas,t.qty AS jumlah, t.biaya,t.biaya_kso,t.biaya_pasien,t.bayar_pasien,t.verifikasi
            FROM b_tindakan t 
            INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id
            INNER JOIN b_ms_unit mu ON p.unit_id_asal=mu.id
            INNER JOIN b_ms_unit n ON p.unit_id=n.id
            LEFT JOIN b_ms_unit m ON m.id=n.parent_id
            INNER JOIN b_ms_tindakan_kelas tk ON tk.id=t.ms_tindakan_kelas_id 
            INNER JOIN b_ms_tindakan mt ON mt.id=tk.ms_tindakan_id 
            INNER JOIN b_ms_kelas mk ON mk.id=tk.ms_kelas_id 
            WHERE p.jenis_kunjungan=2 AND p.kunjungan_id='$idKunj' ORDER BY t.id";
        }

//echo $sql."<br>";
$perpage=100;
$rs=mysql_query($sql);
$jmldata=mysql_num_rows($rs);
if ($page=="" || $page=="0") $page=1;
$tpage=($page-1)*$perpage;
if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
if ($page>1) $bpage=$page-1; else $bpage=1;
if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
//$sql=$sql." limit $tpage,$perpage";
//$rs=mysql_query($sql);
$i=($page-1)*$perpage;
$dt=$totpage.chr(5);

while ($rows=mysql_fetch_array($rs)){
		$sdhBayar=0;
		if ($rows["bayar_pasien"]>0) $sdhBayar=1;
		$proses = "<img src='../icon/edit.gif' onClick='popupTindakan($sdhBayar)' title='edit tindakan' width='20' style='cursor:pointer' />&nbsp;&nbsp;&nbsp;<img src='../icon/erase.png' width='20' onClick='hapusTindakan($sdhBayar)' title='hapus tindakan' style='cursor:pointer' />";
		$id=$rows['ms_kelas_id']."|".$rows['unit_id']."|".$rows['parent_id']."|".$rows['pelayanan_id']."|".$rows['id']."|".$rows['ms_tindakan_kelas_id'];
		$i++;
		if($rows['verifikasi']==='1'){
			$verif = 'checked';
		}
		if($rows['verifikasi']==='0'){
			$verif = '';
		}
		$verifikasi_tindakan = "<input type='checkbox' id='chkVerTindakan_$rows[id]' onclick='VerifikasiTindakan($rows[id])' $verif/>";
		$dt.=$id.chr(3).$i.chr(3).$rows["jenis"].chr(3).$rows["unit"].chr(3).tglSQL($rows["tgl"]).chr(3).$rows["tindakan"].chr(3).$rows["kelas"].chr(3).$rows["jumlah"].chr(3).$rows["biaya"].chr(3).$rows["biaya_kso"].chr(3).$rows["biaya_pasien"].chr(3).$rows["bayar_pasien"].chr(3).$verifikasi_tindakan.chr(3).$proses.chr(6);
}

if ($dt!=$totpage.chr(5)){
	$dt=substr($dt,0,strlen($dt)-1);
	$dt=str_replace('"','\"',$dt);
}
mysql_free_result($rs);
mysql_close($konek);
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")){
	header("Content-type: application/xhtml+xml");
}else{
	header("Content-type: text/xml");
}
echo $dt;
?>