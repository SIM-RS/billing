<?php
include("../koneksi/konek.php");
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
$noBukti=$_REQUEST['txtNoBu'];
$nilai=$_REQUEST['nilai'];
$ket=$_REQUEST['txtArea'];
$bln=$_REQUEST['bln'];
$thn=$_REQUEST['thn'];
$tipe = $_REQUEST['tipe'];
$userId=$_REQUEST['userId'];
$kunj_id = $_REQUEST['kunjungan_id'];
$pel_id = $_REQUEST['pelayanan_id'];
$txtBayar=explode("|",$_REQUEST['txtBayar']);
$txtTin=explode("*",$_REQUEST['txtTin']);
$kunjId=explode("|",$_REQUEST['kunjId']);
$kso = $_REQUEST['kso'];
$grid = $_REQUEST['grid'];
$jenis_layanan = $_REQUEST['jenis_layanan'];
$unit_id = $_REQUEST['unit_id'];
$inap = $_REQUEST['inap'];

//===============================
$statusProses='';
$alasan='';
/*$waktu = $_REQUEST['waktu'];
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
}*/
$waktu = " AND (MONTH(t.tgl) = '".$bln."' AND YEAR(t.tgl) = '".$thn."') ";
switch(strtolower($_REQUEST['act'])) {
    case 'tambah':
        if($idTrans!="1") {
            mysql_query("select * from k_transaksi where id='$id'");
            if(mysql_affected_rows()==0) {
                $sqlTambah="insert into k_transaksi (id_trans,tgl,no_bukti,nilai,ket,tgl_act,user_act)
					values('$idTrans','$tgl','$noBukti','$nilai','$ket',now(),'$userId')";
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
                    $sqlTambah="insert into k_transaksi (id_trans,tgl,no_bukti,kso_id,kunjungan_id,nilai,ket,tgl_act,user_act)
						values('$idTrans','$tgl','$noBukti','$ksoId','".$kunjId[$i]."','".$txtBayar[$i]."','$ket',now(),'$userId')";
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
                        $qDetail="insert into k_transaksi_detail (transaksi_id,tindakan_id,nilai,tipe)
						values('".$rwTrans['id']."','".$rwTin['id']."','".$rwTin['biaya_kso']."','0')";
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
                        $qDetail="insert into k_transaksi_detail (transaksi_id,tindakan_id,nilai,tipe)
						values('".$rwTrans['id']."','".$rwTinKam['id']."','".$rwTin['bayar_kso']."','1')";
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
            $sqlSimpan="update k_transaksi set id_trans='$idTrans',tgl='$tgl',no_bukti='$noBukti',nilai='$nilai',ket='$ket',tgl_act=now()
                    where id='$id'";
            $rs=mysql_query($sqlSimpan);
        }
        else {
            $statusProses="Error";
            $alasan="Data tidak ditemukan!";
        }
        break;
    case 'bayar_kso':
	   $kunj_id = explode(',',$kunj_id);
	   $nilai = explode(',',$nilai);
	   $items = count($kunj_id);
	   $jenis_layanan = explode(',',$jenis_layanan);
	   $unit_id = explode(',',$unit_id);
	   for($i=0; $i<$items; $i++){
		  $sql = "select id from k_transaksi where kunjungan_id = '".$kunj_id[$i]."'";
		  $rs = mysql_query($sql);
		  $res = mysql_num_rows($rs);
		  if($res <= 0){
			 //echo '<br><br>'.
			 $sql = "insert into k_transaksi (tgl,no_bukti,jenis_layanan,unit_id,kso_id,kunjungan_id,nilai,tgl_act,user_act) values
				    ('$tgl','$noBukti','".$jenis_layanan[$i]."','".$unit_id[$i]."','".$kunj_id[$i]."','".$nilai[$i]."',now(),'$userId')";
			 mysql_query($sql);
			 //echo '<br>'.
			 $sql = "select max(id) as id from k_transaksi";
			 $rs = mysql_query($sql);
			 $row = mysql_fetch_array($rs);
			 $kt_id = $row['id'];
			 
			 //echo '<br>'.
			 $sql = "select t.id,biaya_kso from $dbbilling.b_kunjungan k
				inner join $dbbilling.b_pelayanan p on k.id = p.kunjungan_id
				inner join $dbbilling.b_tindakan t on p.id = t.pelayanan_id
				where k.id = '".$kunj_id[$i]."'";
			 $rs = mysql_query($sql);
			 while($row=mysql_fetch_array($rs)){
				$t_id = $row['id'];
				$nilai = $row['biaya_kso'];
				//echo '<br>'.
				$sql = "update $dbbilling.b_tindakan set bayar = '$nilai', bayar_kso = '$nilai'
					   , lunas=1 where id = '$t_id'";
				mysql_query($sql);
				//echo '<br>'.
				$sql = "insert into k_transaksi_detail (transaksi_id,tindakan_id,nilai)
				    values ('$kt_id','$t_id','$nilai')";
				mysql_query($sql);
			 }
		  }
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
            $sorting = 'tgl';
        }
    }
    if($grid == 1) {
	   if($tipe!=4){
		  if($kso == 0){
			 $kso = "";
			 $ksoP = "";
		  }
		  else{
			 if($tipe == 2){
				$ksoP = " and p.kso_id = '$kso' ";
			 }
			 $kso = " AND t.kso_id='$kso' ";
		  }
	   }
        if($tipe == '1') {
            //rawat jalan
            $sql = "select * from (select k.id,u.nama as unit,date_format(k.tgl,'%d-%m-%Y') as tgl,date_format(k.tgl_pulang,'%d-%m-%Y') as tgl_p,ps.no_rm,ps.nama as pasien,t1.* from (SELECT gab.pelayanan_id,SUM(gab.biayaRS) AS biayaRS,SUM(gab.biaya_kso) AS biaya_kso,SUM(gab.biaya_pasien) AS biaya_pasien,
                    SUM(gab.bayar_kso) AS bayar_kso,SUM(gab.bayar_pasien) AS bayar_pasien
					, if(gab.kso_id=1,if(bayar_pasien > 0,'Sudah','Belum'),if(bayar_kso > 0,'Sudah','Belum')) as sudah FROM
                    (SELECT DISTINCT t.kso_id,t.id,t.pelayanan_id,(qty*biaya) AS biayaRS,(qty*biaya_kso) AS biaya_kso,(qty*biaya_pasien) AS biaya_pasien,
                    bayar_kso,bayar-bayar_kso AS bayar_pasien,p.kunjungan_id
                    FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
                    INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id_asal=mu.id
                    WHERE (mu.parent_id <> 44 and mu.inap = 0 and p.unit_id IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=0 and u.parent_id <> 44)) $kso $waktu
                    ) AS gab GROUP BY gab.kunjungan_id
                    ) t1
                    inner join $dbbilling.b_pelayanan p on p.id = t1.pelayanan_id
                    inner join $dbbilling.b_kunjungan k on p.kunjungan_id = k.id
                    inner join $dbbilling.b_ms_pasien ps on ps.id = k.pasien_id
                    inner join $dbbilling.b_ms_unit u on u.id = p.unit_id) t1 $filter order by $sorting";
        }
        else if($tipe == '2') {
            //rawat inap
		  $sql = "SELECT *
				    FROM (SELECT
						  k.id,
						  DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,
						  DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') AS tgl_p,
						  ps.no_rm,
						  ps.nama AS pasien,
						  SUM(t.biayaRS) AS biayaRS,
						  SUM(t.biaya_kso) AS biaya_kso,
						  SUM(t.biaya_pasien) AS biaya_pasien,
						  SUM(t.bayar_kso) AS bayar_kso,
						  SUM(t.bayar_pasien) AS bayar_pasien,
						  IFNULL(mt.nama,'Kamar') AS tindakan,
						  u.nama AS unit,
						  p.id AS pelayanan_id,
						  pg.nama AS dokter,
						  t.qty,sudah
						FROM (SELECT
							   ms_tindakan_kelas_id,
							   pelayanan_id,
							   t.tgl,
							   qty
							 , if(t.kso_id=1,if(bayar_pasien > 0,'Sudah','Belum'),if(bayar_kso > 0,'Sudah','Belum')) as sudah
							   ,biaya*qty AS biayaRS,
							   biaya_kso*qty AS biaya_kso,
							   biaya_pasien*qty AS biaya_pasien,
							   bayar,
							   bayar_kso,
							   bayar_pasien,
							   user_id
							 FROM $dbbilling.b_tindakan t
							   INNER JOIN $dbbilling.b_pelayanan p
								ON t.pelayanan_id = p.id
							   INNER JOIN $dbbilling.b_ms_unit mu
								ON p.unit_id_asal = mu.id
							 WHERE (mu.inap = 1
								    OR p.unit_id IN(SELECT
												  u.id
												FROM $dbbilling.b_ms_unit u
												WHERE u.inap = 1))
								$kso $waktu
								UNION SELECT
														  0 AS ms_tindakan_kelas_id,
														  pelayanan_id,
														  '$tgl' AS tgl,
														  1 AS qty
														  , if(p.kso_id=1,if(bayar_pasien > 0,'Sudah','Belum'),if(bayar_kso > 0,'Sudah','Belum')) as sudah
														  ,tarip AS biayaRS,
														  beban_kso AS biaya_kso,
														  beban_pasien AS biaya_pasien,
														  bayar,
														  bayar_kso,
														  IF((DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in) * tk.beban_pasien > tk.bayar_pasien), IF (DATEDIFF('$tgl',tk.tgl_in) * tk.beban_pasien <= tk.bayar_pasien,tk.beban_pasien,0),tk.beban_pasien) AS bayar_pasien,
														  0 AS user_id
														FROM $dbbilling.b_tindakan_kamar tk
														  INNER JOIN $dbbilling.b_pelayanan p
														    ON tk.pelayanan_id = p.id
														WHERE date(tk.tgl_in) <= last_day('$thn-$bln-01') $ksoP 
														    AND (date(tk.tgl_out) >= '$thn-$bln-01'
																OR tk.tgl_out IS NULL)) t
						  INNER JOIN $dbbilling.b_pelayanan p
						    ON t.pelayanan_id = p.id
						  LEFT JOIN $dbbilling.b_ms_pegawai pg
						    ON t.user_id = pg.id
						  LEFT JOIN $dbbilling.b_ms_tindakan_kelas tk
						    ON t.ms_tindakan_kelas_id = tk.id
						  LEFT JOIN $dbbilling.b_ms_tindakan mt
						    ON tk.ms_tindakan_id = mt.id
						  INNER JOIN $dbbilling.b_ms_unit u
						    ON p.unit_id = u.id
					 INNER JOIN $dbbilling.b_kunjungan k
					   ON p.kunjungan_id = k.id
					 INNER JOIN $dbbilling.b_ms_pasien ps
					   ON ps.id = k.pasien_id
					    GROUP BY k.id) t1
				    ORDER BY tgl";
        }
        else if($tipe == '3') {
            //igd
		  
             $sql = "select * from (select k.id,u.nama as unit,date_format(k.tgl,'%d-%m-%Y') as tgl,DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') AS tgl_p,ps.no_rm,ps.nama as pasien,t1.* from (SELECT gab.pelayanan_id,SUM(gab.biayaRS) AS biayaRS,SUM(gab.biaya_kso) AS biaya_kso,SUM(gab.biaya_pasien) AS biaya_pasien,qty,
                    SUM(gab.bayar_kso) AS bayar_kso,SUM(gab.bayar_pasien) AS bayar_pasien
							 , if(gab.kso_id=1,if(bayar_pasien > 0,'Sudah','Belum'),if(bayar_kso > 0,'Sudah','Belum')) as sudah FROM
                    (SELECT DISTINCT t.kso_id,t.id,p.kunjungan_id,t.pelayanan_id,(qty*biaya) AS biayaRS,(qty*biaya_kso) AS biaya_kso,(qty*biaya_pasien) AS biaya_pasien,qty,
                    bayar_kso,bayar-bayar_kso AS bayar_pasien
                    FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
                    INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id_asal=mu.id
                    WHERE (mu.parent_id = 44 and mu.inap = 0 and p.unit_id not IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=1) or p.unit_id IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=0 and u.parent_id = 44)) $kso $waktu
                    ) AS gab GROUP BY gab.kunjungan_id
                    ) t1
                    inner join $dbbilling.b_pelayanan p on p.id = t1.pelayanan_id
                    inner join $dbbilling.b_kunjungan k on p.kunjungan_id = k.id
                    inner join $dbbilling.b_ms_pasien ps on ps.id = k.pasien_id
                    inner join $dbbilling.b_ms_unit u on u.id = p.unit_id) t1 $filter order by $sorting";
        }
	   else if($tipe == '4'){
		  if($kso == 0){
			 $kso = "";
		  }
		  else{
			 if($inap == 1){
				$ksoP = " and p.kso_id = '$kso' ";
			 }
			 $kso = " AND t.kso_id='$kso' ";
		  }
		  if($inap == 0){
			 //non-inap
			 $sql = "select * from (select k.id,u.nama as unit,date_format(k.tgl,'%d-%m-%Y') as tgl,DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') AS tgl_p,ps.no_rm,ps.nama as pasien,t1.* from (SELECT gab.pelayanan_id,SUM(gab.biayaRS) AS biayaRS,SUM(gab.biaya_kso) AS biaya_kso,SUM(gab.biaya_pasien) AS biaya_pasien,
				    SUM(gab.bayar_kso) AS bayar_kso,SUM(gab.bayar_pasien) AS bayar_pasien
				    , if(t1.kso_id=1,if(bayar_pasien > 0,'Sudah','Belum'),if(bayar_kso > 0,'Sudah','Belum')) as sudah FROM
				    (SELECT DISTINCT t.id,t.pelayanan_id,(qty*biaya) AS biayaRS,(qty*biaya_kso) AS biaya_kso,(qty*biaya_pasien) AS biaya_pasien,
				    bayar_kso,bayar-bayar_kso AS bayar_pasien
				    FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
				    INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id=mu.id
				    WHERE mu.id='$unit_id' $kso $waktu
				    ) AS gab GROUP BY gab.pelayanan_id
				    ) t1
				    inner join $dbbilling.b_pelayanan p on p.id = t1.pelayanan_id
				    inner join $dbbilling.b_kunjungan k on p.kunjungan_id = k.id
				    inner join $dbbilling.b_ms_pasien ps on ps.id = k.pasien_id
				    inner join $dbbilling.b_ms_unit u on u.id = p.unit_id group by k.id) t1 $filter order by $sorting";
		  }
		  else{
			 //inap
		  $sql = "SELECT *
				    FROM (SELECT
						  k.id,
						  DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,
						  DATE_FORMAT(k.tgl_pulang,'%d-%m-%Y') AS tgl_p,
						  ps.no_rm,
						  ps.nama AS pasien,
						  SUM(t.biayaRS) AS biayaRS,
						  SUM(t.biaya_kso) AS biaya_kso,
						  SUM(t.biaya_pasien) AS biaya_pasien,
						  SUM(t.bayar_kso) AS bayar_kso,
						  SUM(t.bayar_pasien) AS bayar_pasien,
						  IFNULL(mt.nama,'Kamar') AS tindakan,
						  u.nama AS unit,
						  p.id AS pelayanan_id,
						  pg.nama AS dokter,
						  t.qty
						FROM (SELECT
							   ms_tindakan_kelas_id,
							   pelayanan_id,
							   t.tgl,
							   qty,
							   biaya*qty AS biayaRS,
							   biaya_kso*qty AS biaya_kso,
							   biaya_pasien*qty AS biaya_pasien,
							   bayar,
							   bayar_kso,
							   bayar_pasien,
							   user_id
							 FROM $dbbilling.b_tindakan t
							   INNER JOIN $dbbilling.b_pelayanan p
								ON t.pelayanan_id = p.id
							   INNER JOIN $dbbilling.b_ms_unit mu
								ON p.unit_id_asal = mu.id
							 WHERE p.unit_id = '$unit_id'
								$kso
								$waktu UNION SELECT
											 0 AS ms_tindakan_kelas_id,
											 pelayanan_id,
											 '$tgl' AS tgl,
											 1 AS qty,
											 tarip AS biayaRS,
											 beban_kso AS biaya_kso,
											 beban_pasien AS biaya_pasien,
											 bayar,
											 bayar_kso,
											 IF((DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in) * tk.beban_pasien > tk.bayar_pasien), IF (DATEDIFF('$tgl',tk.tgl_in) * tk.beban_pasien <= tk.bayar_pasien,tk.beban_pasien,0),tk.beban_pasien) AS bayar_pasien,
											 0 AS user_id
										    FROM $dbbilling.b_tindakan_kamar tk
											 INNER JOIN $dbbilling.b_pelayanan p
											   ON tk.pelayanan_id = p.id
										    WHERE p.unit_id = '$unit_id' $ksoP
											 and date(tk.tgl_in) <= last_day('$thn-$bln-01')
											 AND (date(tk.tgl_out) >= '$thn-$bln-01'
												 and tk.tgl_out is not null) t
						  INNER JOIN $dbbilling.b_pelayanan p
						    ON t.pelayanan_id = p.id
						  LEFT JOIN $dbbilling.b_ms_pegawai pg
						    ON t.user_id = pg.id
						  LEFT JOIN $dbbilling.b_ms_tindakan_kelas tk
						    ON t.ms_tindakan_kelas_id = tk.id
						  LEFT JOIN $dbbilling.b_ms_tindakan mt
						    ON tk.ms_tindakan_id = mt.id
						  INNER JOIN $dbbilling.b_ms_unit u
						    ON p.unit_id = u.id
					 INNER JOIN $dbbilling.b_kunjungan k
					   ON p.kunjungan_id = k.id
					 INNER JOIN $dbbilling.b_ms_pasien ps
					   ON ps.id = k.pasien_id
					    GROUP BY p.id) t1 $filter
				    ORDER BY tgl";
		  }
	   }
    }
    else if($grid == 2) {
	   if($tipe!=4){
		  if($kso == 0){
			 $kso = "";
			 $ksoP = "";
		  }
		  else{
			 if($tipe == 2){
				$ksoP = " and p.kso_id = '$kso' ";
			 }
			 $kso = " AND t.kso_id='$kso' ";
		  }
	   }
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
				$kso $waktu and p.kunjungan_id = '$kunj_id') AS gab GROUP BY gab.id) t1
                    inner join $dbbilling.b_pelayanan p on p.id = t1.pelayanan_id
                    inner join $dbbilling.b_kunjungan k on p.kunjungan_id = k.id
                    inner join $dbbilling.b_ms_pasien ps on ps.id = k.pasien_id
                    inner join $dbbilling.b_ms_unit u on u.id = p.unit_id) t1 $filter order by $sorting";
        }
        else if($tipe == '2') {
            //rawat inap
		  $sql = "SELECT *
				    FROM (SELECT
						  DATE_FORMAT(t.tgl,'%d-%m-%Y') AS tgl,
						  ifnull(mt.nama,'Kamar') AS tindakan,
						  u.nama AS unit,
						  t.biayaRS,t.qty,
						  t.biaya_kso,
						  t.biaya_pasien,
						  t.bayar,
						  t.bayar_kso,
						  t.bayar_pasien, p.id,
						  pg.nama AS dokter
						FROM (SELECT
							   ms_tindakan_kelas_id,
							   pelayanan_id,
							   t.tgl,
							   qty,
							   biaya*qty as biayaRS,
							   biaya_kso*qty as biaya_kso,
							   biaya_pasien*qty as biaya_pasien,
							   bayar,
							   bayar_kso,
							   bayar_pasien,
							   t.user_id
							 FROM $dbbilling.b_tindakan t inner join $dbbilling.b_pelayanan p on t.pelayanan_id = p.id
							 inner join $dbbilling.b_ms_unit mu on p.unit_id_asal = mu.id
							 WHERE p.kunjungan_id = $kunj_id and (mu.inap = 1
								    OR p.unit_id IN(SELECT
												  u.id
												FROM $dbbilling.b_ms_unit u
												WHERE u.inap = 1))
								$waktu $kso UNION SELECT
                                                0 AS ms_tindakan_kelas_id,
                                                pelayanan_id,
                                                '$tgl' AS tgl,
                                                1 AS qty,
                                                tarip AS biayaRS,
                                                beban_kso AS biaya_kso,
                                                beban_pasien AS biaya_pasien,
                                                bayar,
                                                bayar_kso,
                                                bayar_pasien,
                                                0 AS user_id
                                              FROM $dbbilling.b_tindakan_kamar tk inner join $dbbilling.b_pelayanan p on tk.pelayanan_id = p.id
                                              WHERE p.kunjungan_id = $kunj_id
                                                  AND date(tk.tgl_in) <= last_day('$thn-$bln-01') $ksoP 
										AND (date(tk.tgl_out) >= '$thn-$bln-01'
                                                        OR date(tk.tgl_out) IS NULL)) t
								INNER JOIN $dbbilling.b_pelayanan p
								  ON t.pelayanan_id = p.id
								LEFT JOIN $dbbilling.b_ms_pegawai pg
								  ON t.user_id = pg.id
								LEFT JOIN $dbbilling.b_ms_tindakan_kelas tk
								  ON t.ms_tindakan_kelas_id = tk.id
								LEFT JOIN $dbbilling.b_ms_tindakan mt
								  ON tk.ms_tindakan_id = mt.id
								INNER JOIN $dbbilling.b_ms_unit u
								  ON p.unit_id = u.id) t1";
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
				$kso $waktu and p.kunjungan_id = '$kunj_id') AS gab GROUP BY gab.id) t1
                    inner join $dbbilling.b_pelayanan p on p.id = t1.pelayanan_id
                    inner join $dbbilling.b_kunjungan k on p.kunjungan_id = k.id
                    inner join $dbbilling.b_ms_pasien ps on ps.id = k.pasien_id
                    inner join $dbbilling.b_ms_unit u on u.id = p.unit_id) t1 $filter order by $sorting";
		  
	   }
    }
    /*$sql="SELECT t.id,t.tgl,t.no_bukti,t.id_trans,mt.nama AS jenis_pendapatan,t.nilai,t.ket FROM k_transaksi t
                INNER JOIN k_ms_transaksi mt ON mt.id=t.id_trans
			 WHERE mt.tipe='1' and MONTH(t.tgl)='$bln' AND YEAR(t.tgl)='$thn' $tipe ".$filter." order by ".$sorting;*/

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

    if($grid == 1) {
            while ($rows=mysql_fetch_array($rs)) {
                $i++;
			 if($tipe != 4){
				if($tipe == 1){
				    $sqlX = "SELECT DISTINCT mu.nama
                    FROM $dbbilling.b_tindakan t
				INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
				INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id = mu.id
                    WHERE (mu.parent_id <> 44 and mu.inap = 0 and p.unit_id IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=0 and u.parent_id <> 44))
				$kso $waktu and p.kunjungan_id = '".$rows["id"]."'";
				}
				else if($tipe == 2){
				    $sqlX = "SELECT *
				    FROM (SELECT
						  u.nama
						FROM (SELECT distinct
							   pelayanan_id
							 FROM $dbbilling.b_tindakan t inner join $dbbilling.b_pelayanan p on t.pelayanan_id = p.id
							 inner join $dbbilling.b_ms_unit mu on mu.id = p.unit_id_asal
							 WHERE p.kunjungan_id = '".$rows["id"]."' $kso
								$waktu and (mu.inap = 1
								    OR p.unit_id IN(SELECT
												  u.id
												FROM $dbbilling.b_ms_unit u
												WHERE u.inap = 1))
								UNION SELECT distinct
                                                pelayanan_id
                                              FROM $dbbilling.b_tindakan_kamar tk inner join $dbbilling.b_pelayanan p on tk.pelayanan_id = p.id
                                              WHERE p.kunjungan_id = '".$rows["id"]."' $ksoP
									   and date(tk.tgl_in) <= last_day('$thn-$bln-01')
									   AND (date(tk.tgl_out) >= '$thn-$bln-01'
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
					    $waktu and p.kunjungan_id = '".$rows["id"]."'";
					    //AND t.kso_id='$kso'
				}
				$rsX = mysql_query($sqlX);
				while($rowsX = mysql_fetch_array($rsX)){
				    $tmpLay .= $rowsX['nama'].', ';
				}
				$tmpLay = substr($tmpLay,0,strlen($tmpLay)-2);
			 }
			 else{
				$tmpLay = $rows['unit'];
			 }
                $dt.=$rows["id"].'|'.$rows['pelayanan_id'].'|'.$rows['jenis_layanan'].'|'.$rows['unit_id'].chr(3).number_format($i,0,",","").chr(3).$rows["tgl"].chr(3).$rows["tgl_p"].chr(3).$rows["no_rm"].chr(3).$rows["pasien"].chr(3).$tmpLay.chr(3).$rows["sudah"].chr(3).$rows["biayaRS"].chr(3).$rows["biaya_kso"].chr(3).$rows["biaya_pasien"].chr(3).$rows["biaya_kso"].chr(3).$rows["bayar_pasien"].chr(6);
                $tmpLay = '';
        }
    }
    else if($grid == 2) {
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
            $dt .= $rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["tgl"].chr(3).$rows["unit"].chr(3).$rows["tindakan"].chr(3).$rows["qty"].chr(3).$rows["dokter"].chr(3).$rows["biayaRS"].chr(3).$rows["biaya_kso"].chr(3).$rows["biaya_pasien"].chr(3).$rows["biaya_kso"].chr(3).$rows["bayar_pasien"].chr(6);
        }
    }

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']);
        $dt=str_replace('"','\"',$dt);
    }
    mysql_free_result($rs);
}
mysql_close($konek);
///
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    //header("Content-type: application/xhtml+xml");
}else {
    //header("Content-type: text/xml");
}
echo $dt;
//*/
?>