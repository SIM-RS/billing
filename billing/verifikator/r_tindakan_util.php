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

/*
if($jnsRwt=='0'){
            $cek="SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
            WHERE b_pelayanan.kunjungan_id='$idKunj' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1";
            $rsCek=mysql_query($cek);
            if(mysql_num_rows($rsCek)>0){
                $sql="SELECT tbl1.*	FROM (SELECT t.id,bt.id AS bayar_tindakan_id,t.ms_tindakan_kelas_id,t.pelayanan_id,m.nama AS jenis ,
                l.unit_id,u.parent_id,u.nama AS unit,t.tgl,mt.nama AS tindakan,
                tk.ms_kelas_id,mk.nama AS kelas,t.qty AS jumlah, t.biaya,t.biaya_kso,t.biaya_pasien,t.bayar_pasien,bt.nilai AS bayar_tindakan,t.verifikasi 
                FROM b_tindakan t 
                INNER JOIN b_kunjungan k ON k.id=t.kunjungan_id 
                INNER JOIN b_pelayanan l ON t.pelayanan_id = l.id 
                LEFT JOIN b_ms_unit n ON l.unit_id_asal = n.id 
                LEFT JOIN b_ms_unit u ON u.id=l.unit_id
                LEFT JOIN b_ms_unit m ON m.id=u.parent_id
                INNER JOIN b_ms_tindakan_kelas tk ON tk.id=t.ms_tindakan_kelas_id 
                INNER JOIN b_ms_tindakan mt ON mt.id=tk.ms_tindakan_id 
                INNER JOIN b_ms_kelas mk ON mk.id=tk.ms_kelas_id
				INNER JOIN b_bayar_tindakan bt ON bt.tindakan_id = t.id
                WHERE ( n.parent_id <> 44 AND n.inap = 0
                AND l.unit_id IN( SELECT mu.id FROM b_ms_unit mu
                WHERE mu.inap = 0 AND mu.parent_id <> 44) AND k.id='$idKunj' AND bt.tipe = 0) AND
                l.id<(SELECT b_pelayanan.id FROM b_pelayanan INNER JOIN b_ms_unit ON b_pelayanan.unit_id=b_ms_unit.id 
                WHERE b_pelayanan.kunjungan_id='$idKunj' AND b_ms_unit.inap=1 ORDER BY b_pelayanan.id LIMIT 1) ORDER BY mt.nama,t.id) AS tbl1 
				  LEFT JOIN 
					(SELECT 
					  bayar_tindakan_id 
					FROM
					  b_return) AS tbl2 
					ON tbl1.bayar_tindakan_id = tbl2.bayar_tindakan_id 
				WHERE tbl2.bayar_tindakan_id IS NULL";
            }
            else{
                $sql="SELECT tbl1.*	FROM (SELECT t.id,bt.id AS bayar_tindakan_id,t.ms_tindakan_kelas_id,t.pelayanan_id,m.nama AS jenis ,
                l.unit_id,u.parent_id,u.nama AS unit,t.tgl,mt.nama AS tindakan,
                tk.ms_kelas_id,mk.nama AS kelas,t.qty AS jumlah, t.biaya,t.biaya_kso,t.biaya_pasien,t.bayar_pasien,bt.nilai AS bayar_tindakan,t.verifikasi 
                FROM b_tindakan t 
                INNER JOIN b_kunjungan k ON k.id=t.kunjungan_id 
                INNER JOIN b_pelayanan l ON t.pelayanan_id = l.id 
                LEFT JOIN b_ms_unit n ON l.unit_id_asal = n.id 
                LEFT JOIN b_ms_unit u ON u.id=l.unit_id
                LEFT JOIN b_ms_unit m ON m.id=u.parent_id
                INNER JOIN b_ms_tindakan_kelas tk ON tk.id=t.ms_tindakan_kelas_id 
                INNER JOIN b_ms_tindakan mt ON mt.id=tk.ms_tindakan_id 
                INNER JOIN b_ms_kelas mk ON mk.id=tk.ms_kelas_id
				INNER JOIN b_bayar_tindakan bt ON bt.tindakan_id = t.id
                WHERE ( n.parent_id <> 44 AND n.inap = 0
                AND l.unit_id IN( SELECT mu.id FROM b_ms_unit mu
                WHERE mu.inap = 0 AND mu.parent_id <> 44) AND k.id='$idKunj' AND bt.tipe = 0)) AS tbl1 
				  LEFT JOIN 
					(SELECT 
					  bayar_tindakan_id 
					FROM
					  b_return) AS tbl2 
					ON tbl1.bayar_tindakan_id = tbl2.bayar_tindakan_id 
				WHERE tbl2.bayar_tindakan_id IS NULL";
            }
        }
        elseif($jnsRwt=='1'){
            $sql="SELECT 
				  tbl1.* 
				FROM
				  (SELECT 
					t.id,
					bt.id AS bayar_tindakan_id,
					t.ms_tindakan_kelas_id,
					t.pelayanan_id,
					n.nama AS jenis,
					p.unit_id,
					mu.parent_id,
					mu.nama AS unit,
					t.tgl,
					mt.nama AS tindakan,
					tk.ms_kelas_id,
					mk.nama AS kelas,
					t.qty AS jumlah,
					t.biaya,
					t.biaya_kso,
					t.biaya_pasien,
					t.bayar_pasien,
					bt.nilai AS bayar_tindakan,
					t.verifikasi 
				  FROM
					b_pelayanan p 
					INNER JOIN b_ms_unit mu 
					  ON p.unit_id = mu.id 
					INNER JOIN b_tindakan t 
					  ON p.id = t.pelayanan_id 
					LEFT JOIN b_ms_unit n 
					  ON n.id = mu.parent_id 
					INNER JOIN b_ms_tindakan_kelas tk 
					  ON tk.id = t.ms_tindakan_kelas_id 
					INNER JOIN b_ms_tindakan mt 
					  ON mt.id = tk.ms_tindakan_id 
					INNER JOIN b_ms_kelas mk 
					  ON mk.id = tk.ms_kelas_id 
					INNER JOIN b_bayar_tindakan bt 
					  ON bt.tindakan_id = t.id 
				  WHERE p.kunjungan_id = '$idKunj' 
					AND bt.tipe = 0 
					AND p.id >= 
					(SELECT 
					  b_pelayanan.id 
					FROM
					  b_pelayanan 
					  INNER JOIN b_ms_unit 
						ON b_pelayanan.unit_id = b_ms_unit.id 
					WHERE b_pelayanan.kunjungan_id = '$idKunj' 
					  AND b_ms_unit.inap = 1 
					ORDER BY b_pelayanan.id 
					LIMIT 1) 
				  ORDER BY mt.nama,
					t.id) AS tbl1 
				  LEFT JOIN 
					(SELECT 
					  bayar_tindakan_id 
					FROM
					  b_return) AS tbl2 
					ON tbl1.bayar_tindakan_id = tbl2.bayar_tindakan_id 
				WHERE tbl2.bayar_tindakan_id IS NULL";
        }
        elseif($jnsRwt=='2'){
            $sql="SELECT tbl1.*	FROM
				  (SELECT t.id,bt.id AS bayar_tindakan_id,t.ms_tindakan_kelas_id,t.pelayanan_id,m.nama AS jenis ,
            p.unit_id,mu.parent_id,mu.nama AS unit,t.tgl,mt.nama AS tindakan,
            tk.ms_kelas_id,mk.nama AS kelas,t.qty AS jumlah, t.biaya,t.biaya_kso,t.biaya_pasien,t.bayar_pasien,bt.nilai AS bayar_tindakan,t.verifikasi
            FROM b_tindakan t 
            INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id
            INNER JOIN b_ms_unit mu ON p.unit_id_asal=mu.id
            INNER JOIN b_ms_unit n ON p.unit_id=n.id
            LEFT JOIN b_ms_unit m ON m.id=n.parent_id
            INNER JOIN b_ms_tindakan_kelas tk ON tk.id=t.ms_tindakan_kelas_id 
            INNER JOIN b_ms_tindakan mt ON mt.id=tk.ms_tindakan_id 
            INNER JOIN b_ms_kelas mk ON mk.id=tk.ms_kelas_id
			INNER JOIN b_bayar_tindakan bt ON bt.tindakan_id = t.id
            WHERE (mu.parent_id = 44 AND mu.inap = 0 
            AND p.unit_id NOT IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=1) 
            OR p.unit_id IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=0 AND u.parent_id = 44)) AND p.kunjungan_id='$idKunj' AND bt.tipe = 0) AS tbl1 LEFT JOIN (SELECT 
					  bayar_tindakan_id 
					FROM
					  b_return) AS tbl2 
					ON tbl1.bayar_tindakan_id = tbl2.bayar_tindakan_id 
				WHERE tbl2.bayar_tindakan_id IS NULL";
        }
*/

$sql = "SELECT tbl1.* FROM (SELECT 
	  p.jenis_kunjungan,
	  t.id,
	  bt.id AS bayar_tindakan_id,
	  t.ms_tindakan_kelas_id,
	  t.pelayanan_id,
	  n.nama AS jenis,
	  p.unit_id,
	  mu.parent_id,
	  mu.nama AS unit,
	  t.tgl,
	  mt.nama AS tindakan,
	  tk.ms_kelas_id,
	  mk.nama AS kelas,
	  t.qty AS jumlah,
	  t.biaya,
	  t.biaya_kso,
	  t.biaya_pasien,
	  t.bayar_pasien,
	  bt.nilai AS bayar_tindakan,
	  t.verifikasi 
	FROM
	  b_pelayanan p 
	  INNER JOIN b_ms_unit mu 
		ON p.unit_id = mu.id 
	  INNER JOIN b_tindakan t 
		ON p.id = t.pelayanan_id 
	  LEFT JOIN b_ms_unit n 
		ON n.id = mu.parent_id 
	  INNER JOIN b_ms_tindakan_kelas tk 
		ON tk.id = t.ms_tindakan_kelas_id 
	  INNER JOIN b_ms_tindakan mt 
		ON mt.id = tk.ms_tindakan_id 
	  INNER JOIN b_ms_kelas mk 
		ON mk.id = tk.ms_kelas_id 
	  INNER JOIN b_bayar_tindakan bt 
		ON bt.tindakan_id = t.id 
	WHERE p.kunjungan_id = '$idKunj' 
	  AND p.jenis_kunjungan = '$jnsRwt' 
	ORDER BY mt.nama,
	  t.id) AS tbl1
		LEFT JOIN (SELECT 
					  bayar_tindakan_id 
					FROM
					  b_return) AS tbl2 
					ON tbl1.bayar_tindakan_id = tbl2.bayar_tindakan_id 
				WHERE tbl2.bayar_tindakan_id IS NULL";

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
		$id=$rows['ms_kelas_id']."|".$rows['unit_id']."|".$rows['parent_id']."|".$rows['pelayanan_id']."|".$rows['id']."|".$rows['ms_tindakan_kelas_id']."|".$rows['bayar_tindakan_id'];
		$i++;
		
		$cek = "SELECT * FROM b_return WHERE bayar_tindakan_id=".$rows['bayar_tindakan_id'];
		$kueri = mysql_query($cek);
		$jml = mysql_num_rows($kueri);
		if($jml>0){
			$return = 'checked';
			$val = '1';
		}
		else{
			$return = '';
			$val = '0';
		}
		$return_tindakan = "<input type='checkbox' id='chkReturn_$rows[bayar_tindakan_id]' value='$val' onclick='prosesReturn($rows[bayar_tindakan_id])' $return />";
		$chk = "<input type='checkbox' id='chk_$rows[bayar_tindakan_id]' />";
		$hidden = "<input type='hidden' id='ids' />";
		$dt.=$id.chr(3).$chk.$hidden.chr(3).$rows["jenis"].chr(3).$rows["unit"].chr(3).tglSQL($rows["tgl"]).chr(3).$rows["tindakan"].chr(3).$rows["kelas"].chr(3).$rows["jumlah"].chr(3).$rows["biaya"].chr(3).$rows["biaya_kso"].chr(3).$rows["biaya_pasien"].chr(3).$rows["bayar_tindakan"].chr(6);
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