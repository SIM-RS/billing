<?php
include("../koneksi/konek.php");
include("../sesi.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="t.id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$id = $_REQUEST['rowid'];
$idTrans=$_REQUEST['cmbPend'];
$ksoId=$_REQUEST['ksoId'];
$tgl=tglSQL($_REQUEST['txtTgl']);
//echo $tgl."<br>";
$noBukti=$_REQUEST['txtNoBu'];
$nilai=$_REQUEST['nilai'];
$ket=$_REQUEST['txtArea'];
$bln=$_REQUEST['bln'];
$thn=$_REQUEST['thn'];
$tipe = $_REQUEST['tipe'];
$bayar = $_REQUEST['bayar'];
$userId=$_REQUEST['userId'];
$kunj_id = $_REQUEST['kunjungan_id'];
$pel_id = $_REQUEST['pelayanan_id'];
$txtBayar=explode("|",$_REQUEST['txtBayar']);
$txtTin=explode("*",$_REQUEST['txtTin']);
$kunjId=explode("|",$_REQUEST['kunjId']);
$kso = $_REQUEST['kso'];
$ckso = $kso;
$grid = $_REQUEST['grid'];
$jenis_layanan = $_REQUEST['jenis_layanan'];
$unit_id = $_REQUEST['unit_id'];
$inap = $_REQUEST['inap'];
$tipePend = $_REQUEST['tipePend'];
$fbayar="";
$fbayar2="";
if($tipePend==1){
    $fTipe = "AND t.tipe_pendapatan = '1' ";
    $fTipe2 = "AND tk.tipe_pendapatan = '1' ";

	if ($bayar==0){
		$fbayar=" AND t.bayar_pasien=0";
		$fbayar2=" AND tk.bayar_pasien=0";
	}else{
		$fbayar=" AND t.bayar_pasien>0";
		$fbayar2=" AND tk.bayar_pasien>0";
	}
}else{
    $fTipe = "AND t.tipe_pendapatan = '0' ";
    $fTipe2 = "AND tk.tipe_pendapatan = '0' ";
}
//===============================
$statusProses='';
$alasan='';
$waktu = $_REQUEST['waktu'];
switch($waktu) {
    case 'harian':
        $waktu = " and t.tgl = '$tgl' ";
        $tgl_k = "if(tk.tgl_out>='".$tgl."',1,0)";
        break;
    case 'periode':
        $tglAwal = tglSQL($_REQUEST['tglAwal']);
        $tglAkhir = tglSQL($_REQUEST['tglAkhir']);
        $waktu = " and t.tgl between '$tglAwal' and '$tglAkhir' ";
        $tgl_k = "if(tk.tgl_out>='$tglAwal' and tk.tgl_out<='$tglAkhir',1,0)";
        //'".$tglAkhir."'
        break;
    case 'bulan':
        $waktu = " AND (MONTH(t.tgl) = '".$bln."' AND YEAR(t.tgl) = '".$thn."') ";
        $tgl_k = "if(month(tk.tgl_out)>$bln,1,if(month(tk.tgl_out)=$bln,1,0))";
        //last_day('$thn-$bln-01')
        break;
}
switch(strtolower($_REQUEST['act'])) {
    case 'tambah':
        if($idTrans!="1") {
            mysql_query("select * from k_transaksi where id='$id'");
            if(mysql_affected_rows()==0) {
                $sqlTambah="insert into k_transaksi (id_trans,tgl,no_bukti,nilai,ket,tgl_act,user_act,flag)
					values('$idTrans','$tgl','$noBukti','$nilai','$ket',now(),'$userId','$flag')";
                //echo $sqlTambah."<br/>";
                $rs=mysql_query($sqlTambah);
            }else {
                $statusProses="Error";
                $alasan="Data sudah ada!";
            }
        }
        else {
            for($i=0; $i<sizeof($txtBayar)-1;$i++) {
                //echo "->".$txtTin[$i]."<br>";
                mysql_query("select * from k_transaksi where id='$id'");
                if(mysql_affected_rows()==0) {
                    $sqlTambah="insert into k_transaksi (id_trans,tgl,no_bukti,kso_id,kunjungan_id,nilai,ket,tgl_act,user_act,flag)
						values('$idTrans','$tgl','$noBukti','$ksoId','".$kunjId[$i]."','".$txtBayar[$i]."','$ket',now(),'$userId','$flag')";					
                    $rs=mysql_query($sqlTambah);

                    $qTrans="select id from k_transaksi where no_bukti='$noBukti' and user_act='$userId' order by id desc limit 1";
                    $rsTrans=mysql_query($qTrans);
                    $rwTrans=mysql_fetch_array($rsTrans);
                    //echo $qTrans."<br>";

                    $sTin="SELECT id, biaya_kso FROM $dbbilling.b_tindakan WHERE biaya_kso<>'0' AND kunjungan_id='".$kunjId[$i]."'";
                    //echo $sTin."<br>";
                    $rsTin=mysql_query($sTin);
                    $selesai=0;
                    while(($rwTin=mysql_fetch_array($rsTin)) && $selesai==0) {
                        $qDetail="insert into k_transaksi_detail (transaksi_id,tindakan_id,nilai,tipe,flag)
						values('".$rwTrans['id']."','".$rwTin['id']."','".$rwTin['biaya_kso']."','0','$flag')";
                        //echo $qDetail."<br>";
                        $rsDetail=mysql_query($qDetail);
                        if($txtBayar[$i]>0) {
                            $txtBayar[$i]-=$rwTin['biaya_kso'];
                        }else {
                            $selesai=1;
                        }
                    }

                    $sTinKam="SELECT tk.id,tk.bayar_kso FROM $dbbilling.b_tindakan_kamar tk
						INNER JOIN $dbbilling.b_pelayanan p ON p.id=tk.pelayanan_id
						WHERE tk.bayar_kso<>'0' AND p.kunjungan_id='".$kunjId[$i]."'";
                    //echo $sTin."<br>";
                    $rsTinKam=mysql_query($sTinKam);
                    $selesai=0;
                    while(($rwTinKam=mysql_fetch_array($rsTinKam)) && $selesai==0) {
                        $qDetail="insert into k_transaksi_detail (transaksi_id,tindakan_id,nilai,tipe,flag)
						values('".$rwTrans['id']."','".$rwTinKam['id']."','".$rwTin['bayar_kso']."','1','$flag')";
                        //echo $qDetail."<br>";
                        $rsDetail=mysql_query($qDetail);
                        if($txtBayar[$i]>0) {
                            $txtBayar[$i]-=$rwTin['bayar_kso'];
                        }else {
                            $selesai=1;
                        }
                    }
                    mysql_free_result($rsTrans);
                    mysql_free_result($rsTin);
                    mysql_free_result($rsTinKam);
                }
            }
        }
        break;
    case 'hapus':
        $sqlTrans="select id from k_transaksi where id='$id'";
        $rsTrans=mysql_query($sqlTrans);
        if(mysql_num_rows($rsTrans)>0) {
            if($idTrans!='1') {
                $sqlHapus="delete from k_transaksi where id='$id'";
                mysql_query($sqlHapus);
            }else {
                $sqlHapus="delete from k_transaksi_detail where transaksi_id='$id'";
                mysql_query($sqlHapus);
                $sqlHapus2="delete from k_transaksi where id='$id'";
                mysql_query($sqlHapus2);
            }
        }else {
            $statusProses="Error";
            $alasan="Data tidak ditemukan!";
        }
        break;
    case 'simpan':
        $sqlTrans="select * from k_transaksi where id='$id'";
        $rsTrans=mysql_query($sqlTrans);
        if(mysql_num_rows($rsTrans)>0) {
            $sqlSimpan="update k_transaksi set id_trans='$idTrans',tgl='$tgl',no_bukti='$noBukti',nilai='$nilai',ket='$ket',tgl_act=now(), flag = '$flag'
                    where id='$id'";                
            $rs=mysql_query($sqlSimpan);
        }
        else {
            $statusProses="Error";
            $alasan="Data tidak ditemukan!";
        }
        break;
}

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act'])."*|*".$alasan;
}
else {

    if ($filter!="") {
        $filter=explode("|",$filter);
        if($tipe != 'lain2') {
            $filter=" where ".$filter[0]." like '%".$filter[1]."%'";
        }
        else {
            $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
        }
    }

    if ($sorting=="") {
        $sorting=$defaultsort;
        if($tipe != 'lain2') {
            $sorting = 'id';
        }
    }
    if($grid == 1 || $tipe=='lain2') {
        if($tipe=='lain2') {
            /*$sql="SELECT t.id,t.tgl,t.no_bukti,t.id_trans,mt.nama AS jenis_pendapatan,t.nilai,t.ket FROM k_transaksi t
				 INNER JOIN k_ms_transaksi mt ON mt.id=t.id_trans
				 WHERE mt.tipe='1' and MONTH(t.tgl)='$bln' AND YEAR(t.tgl)='$thn' and t.id_trans <> 1 ".$filter." order by ".$sorting;*/
            $sql="SELECT
					  t.id,
					  t.tgl,
					  t.no_bukti,
					  t.id_trans,
					  mt.nama    AS jenis_pendapatan,
					  t.nilai,
					  t.ket
					FROM k_transaksi t
					  INNER JOIN k_ms_transaksi mt
						ON mt.id = t.id_trans
					WHERE mt.tipe = '1'
                        AND t.flag = '$flag'
						AND mt.isManual = 1
						AND MONTH(t.tgl) = '$bln'
						AND YEAR(t.tgl) = '$thn'
						$filter
					ORDER BY ".$sorting;
			//$tipe = " and t.id_trans <> 1 ";
        }
        else if($tipe == '1') {
            //rawat jalan
            $sql = "select * from (select k.id,u.nama as unit,date_format(k.tgl,'%d-%m-%Y') as tgl,DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') AS tgl_p,ps.no_rm,ps.nama as pasien,t1.* from (SELECT gab.pelayanan_id,SUM(gab.biayaRS) AS biayaRS,SUM(gab.biaya_kso) AS biaya_kso,SUM(gab.biaya_pasien) AS biaya_pasien,
                    SUM(gab.bayar_kso) AS bayar_kso,SUM(gab.bayar_pasien) AS bayar_pasien FROM
                    (SELECT DISTINCT t.id,t.pelayanan_id,(qty*biaya) AS biayaRS,(qty*biaya_kso) AS biaya_kso,(qty*biaya_pasien) AS biaya_pasien,
                    bayar_kso,bayar-bayar_kso AS bayar_pasien,p.kunjungan_id
                    FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
                    INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id_asal=mu.id
                    WHERE (mu.parent_id <> 44 and mu.inap = 0 and p.unit_id IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=0 and u.parent_id <> 44)) AND t.kso_id='$kso' AND t.tgl='$tgl' AND p.flag = '$flag'
                    ) AS gab GROUP BY gab.kunjungan_id
                    ) t1
                    inner join $dbbilling.b_pelayanan p on p.id = t1.pelayanan_id
                    inner join $dbbilling.b_kunjungan k on p.kunjungan_id = k.id
                    inner join $dbbilling.b_ms_pasien ps on ps.id = k.pasien_id
                    inner join $dbbilling.b_ms_unit u on u.id = p.unit_id) t1 $filter order by $sorting";
        }
        else if($tipe == '2') {
            //rawat inap
			$sql = "SELECT * FROM (SELECT k.id,t2.pelayanan_id,DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') AS tgl_p,
mp.no_rm,mp.nama AS pasien,SUM(t2.biayaRS) AS biayaRS,SUM(t2.biaya_kso) AS biaya_kso,
SUM(t2.biaya_pasien) AS biaya_pasien,SUM(t2.bayar) bayar,SUM(t2.bayar_kso) bayar_kso,SUM(t2.bayar_pasien) bayar_pasien 
FROM (SELECT t.pelayanan_id,t.kunjungan_id,SUM(t.biaya*t.qty) AS biayaRS,SUM(t.biaya_kso*t.qty) AS biaya_kso,
SUM(t.biaya_pasien*t.qty) AS biaya_pasien,SUM(t.bayar) bayar,SUM(t.bayar_kso) bayar_kso,SUM(t.bayar_pasien) bayar_pasien
FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
WHERE t.kso_id='$kso' AND p.flag = '$flag' AND t.jenis_kunjungan='3' AND t.tgl='$tgl' GROUP BY t.kunjungan_id
UNION
SELECT t1.id pelayanan_id,t1.kunjungan_id,SUM(t1.qty*t1.tarip) biayaRS,SUM(t1.qty*t1.beban_kso) biaya_kso,
SUM(t1.qty*t1.beban_pasien) biaya_pasien,SUM(t1.bayar) bayar,SUM(t1.bayar_kso) bayar_kso,SUM(t1.bayar_pasien) bayar_pasien
FROM (SELECT t1.id,t1.kunjungan_id,IF(t1.status_out=0,IF(t1.tgl_out IS NULL,1,IF(DATEDIFF(t1.tgl_out,t1.tgl_in)=0,1,IF(DATE(t1.tgl_out)='$tgl',0,1))),
IF(t1.tgl_out IS NULL,1,IF(DATEDIFF(t1.tgl_out,'$tgl')=0,0,1))) AS qty,
t1.tarip,t1.beban_kso,t1.beban_pasien,t1.bayar,t1.bayar_kso,t1.bayar_pasien
FROM (SELECT p.kunjungan_id,p.id,p.unit_id_asal,tk.tgl_in,IFNULL(tk.tgl_out,k.tgl_pulang) AS tgl_out,
tk.tarip,tk.beban_kso,tk.beban_pasien,tk.bayar,tk.bayar_kso,tk.bayar_pasien,tk.status_out 
FROM $dbbilling.b_tindakan_kamar tk INNER JOIN $dbbilling.b_pelayanan p ON tk.pelayanan_id=p.id
INNER JOIN $dbbilling.b_kunjungan k ON p.kunjungan_id=k.id
WHERE DATE(tk.tgl_in)<='$tgl' AND (DATE(tk.tgl_out) >='$tgl' OR tk.tgl_out IS NULL) 
AND (DATE(k.tgl_pulang) >='$tgl' OR k.tgl_pulang IS NULL) AND p.kso_id='$kso' AND tk.aktif=1) AS t1) AS t1 
GROUP BY t1.kunjungan_id) AS t2 INNER JOIN $dbbilling.b_kunjungan k ON t2.kunjungan_id=k.id 
INNER JOIN $dbbilling.b_ms_pasien mp ON k.pasien_id=mp.id 
GROUP BY t2.kunjungan_id) AS t3 $filter ORDER BY $sorting";
        }
        else if($tipe == '3') {
            //igd
            $sql = "select * from (select k.id,u.nama as unit,date_format(k.tgl,'%d-%m-%Y') as tgl,DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') AS tgl_p,ps.no_rm,ps.nama as pasien,t1.* from (SELECT gab.pelayanan_id,SUM(gab.biayaRS) AS biayaRS,SUM(gab.biaya_kso) AS biaya_kso,SUM(gab.biaya_pasien) AS biaya_pasien,
                    SUM(gab.bayar_kso) AS bayar_kso,SUM(gab.bayar_pasien) AS bayar_pasien FROM
                    (SELECT DISTINCT t.id,p.kunjungan_id,t.pelayanan_id,(qty*biaya) AS biayaRS,(qty*biaya_kso) AS biaya_kso,(qty*biaya_pasien) AS biaya_pasien,
                    bayar_kso,bayar-bayar_kso AS bayar_pasien
                    FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
                    INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id_asal=mu.id
                    WHERE (mu.parent_id = 44 and mu.inap = 0 and p.unit_id not IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=1) or p.unit_id IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=0 and u.parent_id = 44)) AND t.kso_id='$kso' AND t.tgl='$tgl' AND p.flag = '$flag'
                    ) AS gab GROUP BY gab.kunjungan_id
                    ) t1
                    inner join $dbbilling.b_pelayanan p on p.id = t1.pelayanan_id
                    inner join $dbbilling.b_kunjungan k on p.kunjungan_id = k.id
                    inner join $dbbilling.b_ms_pasien ps on ps.id = k.pasien_id
                    inner join $dbbilling.b_ms_unit u on u.id = p.unit_id) t1 $filter order by $sorting";
        }
        else if($tipe == '4') {
		  if($kso == 0){
			 $kso = "";
			 $ksoP = "";
		  }
		  else{
			 if($inap == 1){
				$ksoP = " and t.kso_id = '$kso' ";
			 }
			 $kso = " AND t.kso_id='$kso' ";
		  }
			
			$sql="SELECT nama FROM $dbbilling.b_ms_unit WHERE id='$unit_id'";
			$rsTmp=mysql_query($sql);
			$rwTmp=mysql_fetch_array($rsTmp);
			$tmpLay1=$rwTmp['nama'];

		  if($inap == 0){
			 //non-inap
			 $sql = "select * from (select k.id,k.pasien_id,u.nama as unit,date_format(k.tgl,'%d-%m-%Y') as tgl,DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') AS tgl_p,ps.no_rm,ps.nama as pasien, ua.nama as unit_asal,t1.* from (SELECT gab.pelayanan_id,SUM(gab.biayaRS) AS biayaRS,SUM(gab.biaya_kso) AS biaya_kso,SUM(gab.biaya_pasien) AS biaya_pasien,
				    SUM(gab.bayar_kso) AS bayar_kso,SUM(gab.bayar_pasien) AS bayar_pasien FROM
				    (SELECT DISTINCT t.id,t.pelayanan_id,(qty*biaya) AS biayaRS,(qty*biaya_kso) AS biaya_kso,(qty*biaya_pasien) AS biaya_pasien,
				    bayar_kso,bayar-bayar_kso AS bayar_pasien
				    FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
				    INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id=mu.id
				    WHERE mu.id='$unit_id' $kso AND p.flag = '$flag' AND t.tgl='$tgl' $fbayar
				    ) AS gab GROUP BY gab.pelayanan_id
				    ) t1
				    inner join $dbbilling.b_pelayanan p on p.id = t1.pelayanan_id
				    inner join $dbbilling.b_kunjungan k on p.kunjungan_id = k.id
				    inner join $dbbilling.b_ms_pasien ps on ps.id = k.pasien_id
				    inner join $dbbilling.b_ms_unit u on u.id = p.unit_id
				    inner join $dbbilling.b_ms_unit ua on ua.id = p.unit_id_asal
				    group by k.id) t1 $filter order by $sorting";
		  }
		  else{
			 //inap
			$sql="SELECT * FROM (SELECT k.id,k.pasien_id,t2.pelayanan_id,DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') AS tgl_p,mp.no_rm,mp.nama AS pasien,
mu.nama unit_asal,SUM(t2.biayaRS) AS biayaRS,SUM(t2.biaya_kso) AS biaya_kso,SUM(t2.biaya_pasien) AS biaya_pasien,
SUM(t2.bayar) AS bayar,SUM(t2.bayar_kso) AS bayar_kso,SUM(t2.bayar_pasien) AS bayar_pasien 
FROM (SELECT pl.id pelayanan_id,pl.kunjungan_id,'$unit_id' AS unit_id,pl.unit_id_asal,SUM(t.qty*t.biaya) biayaRS,SUM(t.qty*t.biaya_kso) biaya_kso,
SUM(t.qty*t.biaya_pasien) biaya_pasien,SUM(t.bayar) bayar,SUM(t.bayar_kso) bayar_kso,SUM(t.bayar_pasien) bayar_pasien
FROM $dbbilling.b_pelayanan pl INNER JOIN $dbbilling.b_tindakan t ON t.pelayanan_id = pl.id 
WHERE pl.unit_id='$unit_id' AND t.tgl = '$tgl' $kso $fbayar GROUP BY pl.id
UNION
SELECT t1.id pelayanan_id,t1.kunjungan_id,'$unit_id' AS unit_id,t1.unit_id_asal,SUM(t1.qty*t1.tarip) biayaRS,SUM(t1.qty*t1.beban_kso) biaya_kso,SUM(t1.qty*t1.beban_pasien) biaya_pasien,
SUM(t1.bayar) bayar,SUM(t1.bayar_kso) bayar_kso,SUM(t1.bayar_pasien) bayar_pasien
FROM (SELECT t1.id,t1.kunjungan_id,t1.unit_id_asal,
IF(t1.status_out=0,IF(t1.tgl_out IS NULL,1,IF(DATEDIFF(t1.tgl_out,t1.tgl_in)=0,1,IF(DATE(t1.tgl_out)='$tgl',0,1))),
IF(t1.tgl_out IS NULL,1,IF(DATEDIFF(t1.tgl_out,'$tgl')=0,0,1))) AS qty,
t1.tarip,t1.beban_kso,t1.beban_pasien,t1.bayar,t1.bayar_kso,t1.bayar_pasien
FROM (SELECT p.id,p.kunjungan_id,p.unit_id_asal,t.tgl_in,IFNULL(t.tgl_out,k.tgl_pulang) AS tgl_out,
t.tarip,t.beban_kso,t.beban_pasien,t.bayar,t.bayar_kso,t.bayar_pasien,t.status_out 
FROM $dbbilling.b_tindakan_kamar t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
INNER JOIN $dbbilling.b_kunjungan k ON k.id=p.kunjungan_id
WHERE p.unit_id='$unit_id' AND p.flag = '$flag' $fbayar AND DATE(t.tgl_in)<='$tgl' AND (DATE(t.tgl_out) >='$tgl' OR t.tgl_out IS NULL) 
AND (DATE(k.tgl_pulang) >='$tgl' OR k.tgl_pulang IS NULL) $ksoP AND t.aktif=1) AS t1) AS t1 GROUP BY t1.id) AS t2
INNER JOIN $dbbilling.b_kunjungan k ON t2.kunjungan_id=k.id INNER JOIN $dbbilling.b_ms_pasien mp ON k.pasien_id=mp.id 
INNER JOIN $dbbilling.b_ms_unit mu ON t2.unit_id_asal=mu.id GROUP BY t2.pelayanan_id) t3 $filter ORDER BY $sorting";
		  }
        }
    }
    else if($grid == 2) {
        if($tipe == '1') {
            //rawat jalan
            $sql = "select * from (select k.id,u.nama as unit,ps.no_rm,ps.nama as pasien,t1.*
				from (SELECT gab.pelayanan_id,SUM(gab.biayaRS) AS biayaRS,SUM(gab.biaya_kso) AS biaya_kso,gab.dokter,gab.tindakan
				,SUM(gab.biaya_pasien) AS biaya_pasien,SUM(gab.bayar_kso) AS bayar_kso,SUM(gab.bayar_pasien) AS bayar_pasien,tgl
				FROM ( SELECT DISTINCT t.id,t.pelayanan_id,(qty*biaya) AS biayaRS,(qty*biaya_kso) AS biaya_kso,(qty*biaya_pasien) AS biaya_pasien,
                    bayar_kso,bayar-bayar_kso AS bayar_pasien,pg.nama AS dokter,t.qty,mt.nama AS tindakan,date_format(t.tgl,'%d-%m-%Y') as tgl
                    FROM $dbbilling.b_tindakan t
				INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
				left JOIN $dbbilling.b_ms_pegawai pg ON t.user_id = pg.id
				INNER JOIN $dbbilling.b_ms_tindakan_kelas tk ON t.ms_tindakan_kelas_id = tk.id
				INNER JOIN $dbbilling.b_ms_tindakan mt ON tk.ms_tindakan_id = mt.id
				INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id_asal = mu.id
                    WHERE (mu.parent_id <> 44 and mu.inap = 0 and p.unit_id IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=0 and u.parent_id <> 44))
				AND t.kso_id='$kso' AND p.flag = '$flag' AND t.tgl='$tgl' and p.kunjungan_id = '$kunj_id') AS gab GROUP BY gab.id) t1
                    inner join $dbbilling.b_pelayanan p on p.id = t1.pelayanan_id
                    inner join $dbbilling.b_kunjungan k on p.kunjungan_id = k.id
                    inner join $dbbilling.b_ms_pasien ps on ps.id = k.pasien_id
                    inner join $dbbilling.b_ms_unit u on u.id = p.unit_id) t1 $filter order by $sorting";
        }
        else if($tipe == '2') {
            //rawat inap
			$sql="SELECT t.pelayanan_id,t.kunjungan_id,DATE_FORMAT('$tgl','%d-%m-%Y') AS tgl,mt.nama tindakan,mu.nama unit,
mp.nama dokter,t.qty,t.biaya*t.qty AS biayaRS,t.biaya_kso*t.qty AS biaya_kso,
t.biaya_pasien*t.qty AS biaya_pasien,t.bayar,t.bayar_kso,t.bayar_pasien
FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
INNER JOIN $dbbilling.b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id
INNER JOIN $dbbilling.b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id
INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id=mu.id
LEFT JOIN $dbbilling.b_ms_pegawai mp ON t.user_id=mp.id
WHERE t.kunjungan_id='$kunj_id' AND t.kso_id='$kso' AND t.jenis_kunjungan='3' AND t.tgl='$tgl'
UNION
SELECT * FROM (SELECT t1.id pelayanan_id,t1.kunjungan_id,DATE_FORMAT('$tgl','%d-%m-%Y') AS tgl,
'Kamar' tindakan,t1.unit,'' dokter,IF(t1.status_out=0,IF(t1.tgl_out IS NULL,1,IF(DATEDIFF(t1.tgl_out,t1.tgl_in)=0,1,IF(DATE(t1.tgl_out)='$tgl',0,1))),
IF(t1.tgl_out IS NULL,1,IF(DATEDIFF(t1.tgl_out,'$tgl')=0,0,1))) AS qty,
t1.tarip biayaRS,t1.beban_kso biaya_kso,t1.beban_pasien biaya_pasien,t1.bayar,t1.bayar_kso,t1.bayar_pasien
FROM (SELECT p.kunjungan_id,p.id,p.unit_id_asal,mu.nama unit,tk.tgl_in,IFNULL(tk.tgl_out,k.tgl_pulang) AS tgl_out,
tk.tarip,tk.beban_kso,tk.beban_pasien,tk.bayar,tk.bayar_kso,tk.bayar_pasien,tk.status_out 
FROM $dbbilling.b_tindakan_kamar tk INNER JOIN $dbbilling.b_pelayanan p ON tk.pelayanan_id=p.id
INNER JOIN $dbbilling.b_kunjungan k ON p.kunjungan_id=k.id
INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id=mu.id
WHERE k.id='$kunj_id' AND p.flag = '$flag' AND DATE(tk.tgl_in)<='$tgl' AND (DATE(tk.tgl_out) >='$tgl' OR tk.tgl_out IS NULL) 
AND (DATE(k.tgl_pulang) >='$tgl' OR k.tgl_pulang IS NULL) AND p.kso_id='$kso' AND tk.aktif=1) AS t1) AS t2 WHERE t2.qty>0";
        }
	   else if($tipe == 3){
            $sql = "select * from (select k.id,u.nama as unit,date_format(k.tgl,'%d-%m-%Y') as tgl,ps.no_rm,ps.nama as pasien,t1.*
				from (SELECT gab.pelayanan_id,SUM(gab.biayaRS) AS biayaRS,SUM(gab.biaya_kso) AS biaya_kso,gab.dokter,gab.tindakan
				,SUM(gab.biaya_pasien) AS biaya_pasien,SUM(gab.bayar_kso) AS bayar_kso,SUM(gab.bayar_pasien) AS bayar_pasien
				FROM ( SELECT DISTINCT t.id,t.pelayanan_id,(qty*biaya) AS biayaRS,(qty*biaya_kso) AS biaya_kso,(qty*biaya_pasien) AS biaya_pasien,
                    bayar_kso,bayar-bayar_kso AS bayar_pasien,pg.nama AS dokter,t.qty,mt.nama AS tindakan
                    FROM $dbbilling.b_tindakan t
				INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
				left JOIN $dbbilling.b_ms_pegawai pg ON t.user_id = pg.id
				INNER JOIN $dbbilling.b_ms_tindakan_kelas tk ON t.ms_tindakan_kelas_id = tk.id
				INNER JOIN $dbbilling.b_ms_tindakan mt ON tk.ms_tindakan_id = mt.id
				INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id_asal = mu.id
				inner join $dbbilling.b_kunjungan k on p.kunjungan_id = k.id
                    WHERE (mu.inap = 0 and p.unit_id not IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=1) or p.unit_id IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=0 and u.parent_id = 44))
				AND t.kso_id='$kso' AND p.flag = '$flag' AND t.tgl='$tgl' and p.kunjungan_id = '$kunj_id') AS gab GROUP BY gab.id) t1
                    inner join $dbbilling.b_pelayanan p on p.id = t1.pelayanan_id
                    inner join $dbbilling.b_kunjungan k on p.kunjungan_id = k.id
                    inner join $dbbilling.b_ms_pasien ps on ps.id = k.pasien_id
                    inner join $dbbilling.b_ms_unit u on u.id = p.unit_id) t1 $filter order by $sorting";
	   }
	   else if($tipe == 4){
		  if($inap == 0){
            $sql = "SELECT t.id,date_format(t.tgl,'%d-%m-%Y') AS tgl,mt.nama AS tindakan,u.nama as unit,t.biaya as biayaRS,t.biaya_kso,t.biaya_pasien
				,t.bayar,t.bayar_kso,t.bayar_pasien,pg.nama AS dokter,t.qty,ua.nama as unit_asal
				FROM $dbbilling.b_tindakan t
				  INNER JOIN $dbbilling.b_pelayanan p
				    ON t.pelayanan_id = p.id
				    LEFT JOIN $dbbilling.b_ms_pegawai pg ON t.user_id = pg.id
				    INNER JOIN $dbbilling.b_ms_tindakan_kelas tk ON t.ms_tindakan_kelas_id = tk.id
				    INNER JOIN $dbbilling.b_ms_tindakan mt ON tk.ms_tindakan_id = mt.id
				    inner join $dbbilling.b_ms_unit u on p.unit_id = u.id
				    inner join $dbbilling.b_ms_unit ua on p.unit_id_asal = ua.id
				WHERE p.id = '$pel_id' AND p.flag = '$flag' $waktu $fbayar AND t.kso_id='$kso'";
		  }
		  else{
			$sql="SELECT t.id,t.pelayanan_id,t.kunjungan_id,DATE_FORMAT('$tgl','%d-%m-%Y') AS tgl,mt.nama tindakan,mu.nama unit,
u.nama as unit_asal,mp.nama dokter,t.qty,t.biaya*t.qty AS biayaRS,t.biaya_kso*t.qty AS biaya_kso,
t.biaya_pasien*t.qty AS biaya_pasien,t.bayar,t.bayar_kso,t.bayar_pasien
FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
INNER JOIN $dbbilling.b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id
INNER JOIN $dbbilling.b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id
INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id=mu.id
INNER JOIN $dbbilling.b_ms_unit u ON p.unit_id_asal = u.id
LEFT JOIN $dbbilling.b_ms_pegawai mp ON t.user_id=mp.id
WHERE t.pelayanan_id='$pel_id' AND p.flag = '$flag' $fbayar AND t.kso_id='$kso' AND t.tgl='$tgl'
UNION
SELECT * FROM (SELECT t1.id,t1.pelayanan_id,t1.kunjungan_id,DATE_FORMAT('$tgl','%d-%m-%Y') AS tgl,
'Kamar' tindakan,t1.unit,t1.unit_asal,'' dokter,IF(t1.status_out=0,IF(t1.tgl_out IS NULL,1,IF(DATEDIFF(t1.tgl_out,t1.tgl_in)=0,1,IF(DATE(t1.tgl_out)='$tgl',0,1))),
IF(t1.tgl_out IS NULL,1,IF(DATEDIFF(t1.tgl_out,'$tgl')=0,0,1))) AS qty,
t1.tarip biayaRS,t1.beban_kso biaya_kso,t1.beban_pasien biaya_pasien,t1.bayar,t1.bayar_kso,t1.bayar_pasien
FROM (SELECT tk.id,p.kunjungan_id,p.id pelayanan_id,p.unit_id_asal,mu.nama unit,u.nama as unit_asal,tk.tgl_in,IFNULL(tk.tgl_out,k.tgl_pulang) AS tgl_out,
tk.tarip,tk.beban_kso,tk.beban_pasien,tk.bayar,tk.bayar_kso,tk.bayar_pasien,tk.status_out 
FROM $dbbilling.b_tindakan_kamar tk INNER JOIN $dbbilling.b_pelayanan p ON tk.pelayanan_id=p.id
INNER JOIN $dbbilling.b_kunjungan k ON p.kunjungan_id=k.id
INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id=mu.id
INNER JOIN $dbbilling.b_ms_unit u ON p.unit_id_asal = u.id
WHERE p.id='$pel_id' $fbayar2 AND DATE(tk.tgl_in)<='$tgl' AND (DATE(tk.tgl_out) >='$tgl' OR tk.tgl_out IS NULL) 
AND (DATE(k.tgl_pulang) >='$tgl' OR k.tgl_pulang IS NULL) AND tk.kso_id='$kso' AND tk.aktif=1) AS t1) AS t2 WHERE t2.qty>0";
		  }
	   }
    }
    
    if($grid == 1){
	   $sqlPlus = "select sum(biayaRS) as totPer,sum(biaya_kso) as totKso,sum(biaya_pasien) as totPas from (".$sql.") sql36";
	   $rsPlus = mysql_query($sqlPlus);
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
    $unit_asal = '';

    if($grid == 1 || $tipe == 'lain2') {
        if($tipe == 'lain2') {
            while ($rows=mysql_fetch_array($rs)) {
                $i++;
                $dt.=$rows["id"]."|".$rows["id_trans"].chr(3).number_format($i,0,",",".").chr(3).tglSQL($rows["tgl"]).chr(3).$rows["no_bukti"].chr(3).$rows["jenis_pendapatan"].chr(3).number_format($rows["nilai"],2,",",".").chr(3).$rows["ket"].chr(6);
            }
        }
        else {
            while ($rows=mysql_fetch_array($rs)) {
                $i++;
			 if($tipe != 4){
				if($tipe == 1){
				    $sqlX = "SELECT DISTINCT mu.nama
                    FROM $dbbilling.b_tindakan t
				INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
				INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id = mu.id
                    WHERE (mu.parent_id <> 44 and mu.inap = 0 and p.unit_id IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=0 and u.parent_id <> 44))
				AND t.kso_id='$kso' AND t.tgl='$tgl' AND p.flag = '$flag' and p.kunjungan_id = '".$rows["id"]."'";
				}
				else if($tipe == 2){
				    $sqlX = "SELECT *
				    FROM (SELECT
						  u.nama
						FROM (SELECT distinct
							   pelayanan_id
							 FROM $dbbilling.b_tindakan t inner join $dbbilling.b_pelayanan p on t.pelayanan_id = p.id
							 inner join $dbbilling.b_ms_unit mu on mu.id = p.unit_id_asal
							 WHERE p.kunjungan_id = '".$rows["id"]."'
								AND t.tgl = '$tgl' and (mu.inap = 1
								    OR p.unit_id IN(SELECT
												  u.id
												FROM $dbbilling.b_ms_unit u
												WHERE u.inap = 1))
								UNION SELECT distinct
                                                pelayanan_id
                                              FROM $dbbilling.b_tindakan_kamar tk inner join $dbbilling.b_pelayanan p on tk.pelayanan_id = p.id
                                              WHERE p.kunjungan_id = '".$rows["id"]."' AND p.flag = '$flag'
                                                  AND date(tk.tgl_in) <= '$tgl'
                                                  AND (date(tk.tgl_out) >= '$tgl'
                                                        OR tk.tgl_out IS NULL)) t
								INNER JOIN $dbbilling.b_pelayanan p
								  ON t.pelayanan_id = p.id
								INNER JOIN $dbbilling.b_ms_unit u
								  ON p.unit_id = u.id) t1";
				}
				else if($tipe == 3){
				    $sqlX = "SELECT DISTINCT u.nama
					   FROM $dbbilling.b_tindakan t
					   INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
					   INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id_asal = mu.id
					   inner join $dbbilling.b_kunjungan k on p.kunjungan_id = k.id
					   inner join $dbbilling.b_ms_unit u on p.unit_id = u.id
					   WHERE (mu.inap = 0 and u.inap = 0
					   and k.unit_id IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=0 and u.parent_id = 44))
					    AND t.tgl='$tgl' AND p.flag = '$flag' and p.kunjungan_id = '".$rows["id"]."'";
					    //AND t.kso_id='$kso'
				}
				
				$rsX = mysql_query($sqlX);
				while($rowsX = mysql_fetch_array($rsX)){
				    $tmpLay .= $rowsX['nama'].', ';
				}
				$tmpLay = substr($tmpLay,0,strlen($tmpLay)-2);
			 }
			 else{
				$unit_asal = chr(3).$rows['unit_asal'];
				$tmpLay = $tmpLay1;
			 }
			 	$tPerda=$rows["biayaRS"];
				if ($ckso=="1"){
					$tKSO=0;
					$tPx=$tPerda;
					$tIur=0;
				}else{
					$tKSO=$rows["biaya_kso"];
					$tPx=0;
					$tIur=$rows["biaya_pasien"];
				}
				$tSelisih=$tPerda-($tKSO+$tPx+$tIur);
				$stSelisih=number_format($tSelisih,0,",",".");
				if ($tSelisih<0){
					$stSelisih="(".number_format(abs($tSelisih),0,",",".").")";
				}
                $dt.=$rows["id"].'|'.$rows['pelayanan_id'].'|'.$rows['pasien_id'].chr(3).number_format($i,0,",","").chr(3).$rows["tgl"].chr(3).$rows["tgl_p"].chr(3).$rows["no_rm"].chr(3).$rows["pasien"].chr(3).$tmpLay.$unit_asal.chr(3).number_format($tPerda,0,",",".").chr(3).number_format($tPx,0,",",".").chr(3).number_format($tKSO,0,",",".").chr(3).number_format($tIur,0,",",".").chr(3).$stSelisih.chr(6);
                $tmpLay = '';
            }
        }
    }
    else if($grid == 2) {
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
			if($tipe == 4){
				$unit_asal = chr(3).$rows['unit_asal'];
			}
			
			$tPerda=$rows["biayaRS"];
			if ($ckso=="1"){
				$tKSO=0;
				$tPx=$tPerda;
				$tIur=0;
			}else{
				$tKSO=$rows["biaya_kso"];
				$tPx=0;
				$tIur=$rows["biaya_pasien"];
			}
			$tSelisih=$tPerda-($tKSO+$tPx+$tIur);
			$stSelisih=number_format($tSelisih,0,",",".");
			if ($tSelisih<0){
				$stSelisih="(".number_format(abs($tSelisih),0,",",".").")";
			}
			
            $dt .= $rows["id"].chr(3).number_format($i,0,",",".").chr(3).$rows["tgl"].chr(3).$rows["unit"].$unit_asal.chr(3).$rows["tindakan"].chr(3).$rows["dokter"].chr(3).number_format($tPerda,0,",",".").chr(3).number_format($tPx,0,",",".").chr(3).number_format($tKSO,0,",",".").chr(3).number_format($tIur,0,",",".").chr(3).$stSelisih.chr(6);
        }
    }

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5);
        $dt=str_replace('"','\"',$dt);
    }
    
    if($grid == 1){
	   if(mysql_num_rows($rsPlus) > 0){
		  $rowPlus = mysql_fetch_array($rsPlus);
		  if($rowPlus['totPer']!=0){
			$totKso=$rowPlus['totKso'];
			$totPer=$rowPlus['totPer'];
			$totPas=0;
			$totIur=$rowPlus['totPas'];
		  	 if ($ckso==1){
			 	$totKso=0;
				$totIur=0;
				$totPas=$totPer;
			 }
			 $totSel=$totPer-($totKso+$totPas+$totIur);
			 $StotSel=number_format($totPer,0,",",".");
			 if ($totSel<0){
			 	$StotSel="(".number_format(abs($totSel),0,",",".").")";
			 }
			 $dt = $dt.number_format($totPer,0,",",".").chr(3).number_format($totPas,0,",",".").chr(3).number_format($totKso,0,",",".").chr(3).number_format($totIur,0,",",".").chr(3).$StotSel;
		  }
		  mysql_free_result($rsPlus);
	   }
    }
    mysql_free_result($rs);
}
mysql_close($konek);
///
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
}else {
    header("Content-type: text/xml");
}
echo $dt;
//*/
?>