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
        if($tipe == '1') {
            //rawat jalan
            $sql = "select * from (select k.id,u.nama as unit,date_format(k.tgl,'%d-%m-%Y') as tgl,ps.nama as pasien
					, if(t1.kso_id=1,if(bayar_pasien > 0,'Sudah','Belum'),if(bayar_kso > 0,'Sudah','Belum')) as sudah
					,t1.* from (SELECT kso_id,gab.pelayanan_id,SUM(gab.biayaRS) AS biayaRS,SUM(gab.biaya_kso) AS biaya_kso,SUM(gab.biaya_pasien) AS biaya_pasien,
                    SUM(gab.bayar_kso) AS bayar_kso,SUM(gab.bayar_pasien) AS bayar_pasien FROM
                    (SELECT DISTINCT t.kso_id,t.id,t.pelayanan_id,(qty*biaya) AS biayaRS,(qty*biaya_kso) AS biaya_kso,(qty*biaya_pasien) AS biaya_pasien,
                    bayar_kso,bayar-bayar_kso AS bayar_pasien, if(t.kso_id=1,if(t.bayar_pasien > 0,'Sudah','Belum'),if(t.bayar_kso > 0,'Sudah','Belum')) as sudah
                    FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
                    INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id_asal=mu.id
                    WHERE (mu.parent_id <> 44 and mu.inap = 0
                    and p.unit_id IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=0 and u.parent_id <> 44))
                    AND t.kso_id='$kso' $waktu) AS gab GROUP BY gab.pelayanan_id) t1
                    inner join $dbbilling.b_pelayanan p on p.id = t1.pelayanan_id
                    inner join $dbbilling.b_kunjungan k on p.kunjungan_id = k.id
                    inner join $dbbilling.b_ms_pasien ps on ps.id = k.pasien_id
                    inner join $dbbilling.b_ms_unit u on u.id = p.unit_id) t1 $filter order by $sorting";
                    //AND t.tgl='$tgl'
        }
        else if($tipe == '2') {
            //rawat inap
			/*$tgl_out = " IFNULL(if(tk.tgl_out>last_day('$thn-$bln-01'),last_day('$thn-$bln-01'),tk.tgl_out),curdate()) ";
			$tgl_in = " if(tk.tgl_in<'$thn-$bln-01','$thn-$bln-01',tk.tgl_in) ";*/
            $sql = "select * from (select k.id,u.nama as unit,date_format(k.tgl,'%d-%m-%Y') as tgl,ps.nama as pasien
					, if(t1.kso_id=1,if(bayar_pasien > 0,'Sudah','Belum'),if(bayar_kso > 0,'Sudah','Belum')) as sudah
					,t1.*
					from (SELECT kso_id,gab.pelayanan_id,SUM(gab.biayaRS) AS biayaRS,SUM(gab.biaya_kso) AS biaya_kso,SUM(gab.biaya_pasien) AS biaya_pasien,
                    SUM(gab.bayar_kso) AS bayar_kso,SUM(gab.bayar_pasien) AS bayar_pasien FROM
                    (SELECT DISTINCT t.kso_id,t.id,t.pelayanan_id,(qty*biaya) AS biayaRS,(qty*biaya_kso) AS biaya_kso,(qty*biaya_pasien) AS biaya_pasien,
                    bayar_kso,bayar-bayar_kso AS bayar_pasien, if(t.kso_id=1,if(t.bayar_pasien > 0,'Sudah','Belum'),if(t.bayar_kso > 0,'Sudah','Belum')) as sudah
                    FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
                    INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id_asal=mu.id
                    WHERE (mu.inap=1 OR p.unit_id IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=1)) AND t.kso_id='$kso'
                        AND month(t.tgl) = '$bln' and year(t.tgl) = '$thn'
                    UNION
                    SELECT p.kso_id,tk.id,tk.pelayanan_id
                        ,DATEDIFF(tk.tgl_out,tk.tgl_in) * tarip AS biayaRS
                        ,DATEDIFF(tk.tgl_out,tk.tgl_in) * tk.beban_kso AS biaya_kso
                        ,DATEDIFF(tk.tgl_out,tk.tgl_in) * tk.beban_pasien AS biaya_pasien,
                    tk.bayar_kso
                    ,IF((DATEDIFF(tk.tgl_out,tk.tgl_in) * tk.beban_pasien > tk.bayar_pasien),0,tk.bayar_pasien) AS bayar_pasien
                    , if(p.kso_id=1,if(tk.bayar_pasien > 0,'Sudah','Belum'),if(tk.bayar_kso > 0,'Sudah','Belum')) as sudah
                    FROM $dbbilling.b_tindakan_kamar tk INNER JOIN $dbbilling.b_pelayanan p ON tk.pelayanan_id=p.id
                    WHERE p.kso_id='$kso' AND (month(tk.tgl_in) <= '$bln' and year(tk.tgl_in) <= '$thn')
                    and (month(tk.tgl_out) = '$bln' and year(tk.tgl_out) = '$thn')
					and tk.tgl_out is not null) AS gab
                    GROUP BY gab.pelayanan_id) t1
                    inner join $dbbilling.b_pelayanan p on p.id = t1.pelayanan_id
                    inner join $dbbilling.b_kunjungan k on p.kunjungan_id = k.id
                    inner join $dbbilling.b_ms_pasien ps on ps.id = k.pasien_id
                    inner join $dbbilling.b_ms_unit u on u.id = p.unit_id) t1 $filter order by $sorting";
					/*$tgl_out = " IFNULL(if(tk.tgl_out>last_day('$thn-$bln-01'),last_day('$thn-$bln-01'),tk.tgl_out),curdate()) ";
			$tgl_in = " if(tk.tgl_in<'$thn-$bln-01','$thn-$bln-01',tk.tgl_in) ";
            $sql = "select * from (select k.id,u.nama as unit,date_format(k.tgl,'%d-%m-%Y') as tgl,ps.nama as pasien
					, if(t1.kso_id=1,if(bayar_pasien > 0,'Sudah','Belum'),if(bayar_kso > 0,'Sudah','Belum')) as sudah
					,t1.*
					from (SELECT kso_id,gab.pelayanan_id,SUM(gab.biayaRS) AS biayaRS,SUM(gab.biaya_kso) AS biaya_kso,SUM(gab.biaya_pasien) AS biaya_pasien,
                    SUM(gab.bayar_kso) AS bayar_kso,SUM(gab.bayar_pasien) AS bayar_pasien FROM
                    (SELECT DISTINCT t.kso_id,t.id,t.pelayanan_id,(qty*biaya) AS biayaRS,(qty*biaya_kso) AS biaya_kso,(qty*biaya_pasien) AS biaya_pasien,
                    bayar_kso,bayar-bayar_kso AS bayar_pasien, if(t.kso_id=1,if(t.bayar_pasien > 0,'Sudah','Belum'),if(t.bayar_kso > 0,'Sudah','Belum')) as sudah
                    FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
                    INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id_asal=mu.id
                    WHERE (mu.inap=1 OR p.unit_id IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=1)) AND t.kso_id='$kso'
                        AND month(t.tgl) = '$bln' and year(t.tgl) = '$thn'
                    UNION
                    SELECT p.kso_id,tk.id,tk.pelayanan_id
                        ,DATEDIFF($tgl_out,$tgl_in) * tarip AS biayaRS
                        ,DATEDIFF($tgl_out,$tgl_in) * tk.beban_kso AS biaya_kso
                        ,DATEDIFF($tgl_out,$tgl_in) * tk.beban_pasien AS biaya_pasien,
                    tk.bayar_kso
                    ,IF((DATEDIFF($tgl_out,$tgl_in) * tk.beban_pasien > tk.bayar_pasien),0,tk.bayar_pasien) AS bayar_pasien
                    , if(p.kso_id=1,if(tk.bayar_pasien > 0,'Sudah','Belum'),if(tk.bayar_kso > 0,'Sudah','Belum')) as sudah
                    FROM $dbbilling.b_tindakan_kamar tk INNER JOIN $dbbilling.b_pelayanan p ON tk.pelayanan_id=p.id
                    WHERE p.kso_id='$kso' AND ((month(tk.tgl_in) <= '$bln' and year(tk.tgl_in) <= '$thn')
                    and (month(ifnull(tk.tgl_out,curdate())) >= '$bln' and year(ifnull(tk.tgl_out,curdate())) >= '$thn'))) AS gab
                    GROUP BY gab.pelayanan_id) t1
                    inner join $dbbilling.b_pelayanan p on p.id = t1.pelayanan_id
                    inner join $dbbilling.b_kunjungan k on p.kunjungan_id = k.id
                    inner join $dbbilling.b_ms_pasien ps on ps.id = k.pasien_id
                    inner join $dbbilling.b_ms_unit u on u.id = p.unit_id) t1 $filter order by $sorting";*/
            //IF (DATEDIFF('$tgl',tk.tgl_in) * tk.beban_pasien <= tk.bayar_pasien,tk.beban_pasien,0)
            // AND tk.tgl_in<='$tgl' AND (tk.tgl_out>='$tgl' OR tk.tgl_out IS NULL)
        }
        else if($tipe == '3') {
            //igd
            $sql = "select * from (select k.id,u.nama as unit,date_format(k.tgl,'%d-%m-%Y') as tgl,ps.nama as pasien
					, if(t1.kso_id=1,if(bayar_pasien > 0,'Sudah','Belum'),if(bayar_kso > 0,'Sudah','Belum')) as sudah
					,t1.*
					from (SELECT kso_id,gab.pelayanan_id,SUM(gab.biayaRS) AS biayaRS,SUM(gab.biaya_kso) AS biaya_kso,SUM(gab.biaya_pasien) AS biaya_pasien,
                    SUM(gab.bayar_kso) AS bayar_kso,SUM(gab.bayar_pasien) AS bayar_pasien FROM
                    (SELECT DISTINCT t.kso_id,t.id,t.pelayanan_id,(qty*biaya) AS biayaRS,(qty*biaya_kso) AS biaya_kso,(qty*biaya_pasien) AS biaya_pasien,
                    bayar_kso,bayar-bayar_kso AS bayar_pasien, if(t.bayar_kso > 0,'Sudah','Belum') as sudah
                    FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id
                    INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id_asal=mu.id
                    WHERE (mu.parent_id = 44 and mu.inap = 0 and p.unit_id not IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=1)
                    or p.unit_id IN (SELECT u.id FROM $dbbilling.b_ms_unit u WHERE u.inap=0 and u.parent_id = 44)) AND t.kso_id='$kso' $waktu) AS gab
                    GROUP BY gab.pelayanan_id) t1
                    inner join $dbbilling.b_pelayanan p on p.id = t1.pelayanan_id
                    inner join $dbbilling.b_kunjungan k on p.kunjungan_id = k.id
                    inner join $dbbilling.b_ms_pasien ps on ps.id = k.pasien_id
                    inner join $dbbilling.b_ms_unit u on u.id = p.unit_id) t1 $filter order by $sorting";
        }
    }
    else if($grid == 2) {
        if($tipe == '1' || $tipe == '3') {
            //rawat jalan
            $sql = "SELECT date_format(t.tgl,'%d-%m-%Y') AS tgl,mt.nama AS tindakan,u.nama as unit,t.biaya,t.biaya_kso,t.biaya_pasien
				,t.bayar,t.bayar_kso,t.bayar_pasien,pg.nama AS dokter,t.qty
				FROM $dbbilling.b_tindakan t
				  INNER JOIN $dbbilling.b_pelayanan p
				    ON t.pelayanan_id = p.id
				    left JOIN $dbbilling.b_ms_pegawai pg ON t.user_id = pg.id
				    INNER JOIN $dbbilling.b_ms_tindakan_kelas tk ON t.ms_tindakan_kelas_id = tk.id
				    INNER JOIN $dbbilling.b_ms_tindakan mt ON tk.ms_tindakan_id = mt.id
				    inner join $dbbilling.b_ms_unit u on p.unit_id = u.id
				WHERE p.id = '$pel_id' $waktu";
        }
        else if($tipe == '2') {
            //rawat inap
            $sql = "select t1.* from
					(SELECT t.id,date_format(t.tgl,'%d-%m-%Y') AS tgl,mt.nama AS tindakan,u.nama as unit,t.biaya,t.biaya_kso,t.biaya_pasien
                        ,t.bayar,t.bayar_kso,t.bayar_pasien,pg.nama AS dokter,t.qty
                        FROM $dbbilling.b_tindakan t
                          INNER JOIN $dbbilling.b_pelayanan p
                            ON t.pelayanan_id = p.id
                            left JOIN $dbbilling.b_ms_pegawai pg ON t.user_id = pg.id
                            INNER JOIN $dbbilling.b_ms_tindakan_kelas tk ON t.ms_tindakan_kelas_id = tk.id
                            INNER JOIN $dbbilling.b_ms_tindakan mt ON tk.ms_tindakan_id = mt.id
                            inner join $dbbilling.b_ms_unit u on p.unit_id = u.id
                        WHERE p.id = '$pel_id' $waktu
					union
					SELECT tk.id,date_format(tk.tgl_in,'%d-%m-%Y') AS tgl,'' AS tindakan,u.nama as unit
						,DATEDIFF(tk.tgl_out,tk.tgl_in) * tk.tarip AS biaya
                        ,DATEDIFF(tk.tgl_out,tk.tgl_in) * tk.beban_kso AS biaya_kso
                        ,DATEDIFF(tk.tgl_out,tk.tgl_in) * tk.beban_pasien AS biaya_pasien
						,tk.bayar,tk.bayar_kso
						,IF((DATEDIFF(tk.tgl_out,tk.tgl_in) * tk.beban_pasien > tk.bayar_pasien),0,tk.bayar_pasien) AS bayar_pasien
					    ,'' AS dokter,'' as qty
                        FROM $dbbilling.b_tindakan_kamar tk
                          INNER JOIN $dbbilling.b_pelayanan p
                            ON tk.pelayanan_id = p.id
                            inner join $dbbilling.b_ms_unit u on p.unit_id = u.id
                        WHERE p.id = '$pel_id'  AND (MONTH(tk.tgl_out) = '".$bln."' AND YEAR(tk.tgl_out) = '".$thn."')  and tk.tgl_out is not null) t1 $filter order by $sorting";
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
                $tmpLay = $rows['unit'];
                $dt.=$rows["id"].'|'.$rows['pelayanan_id'].chr(3).number_format($i,0,",","").chr(3).$rows["tgl"].chr(3).$rows["pasien"].chr(3).$tmpLay.chr(3).$rows["sudah"].chr(3).$rows["biayaRS"].chr(3).$rows["biaya_kso"].chr(3).$rows["biaya_pasien"].chr(3).$rows["bayar_kso"].chr(3).$rows["bayar_pasien"].chr(6);
                $tmpLay = '';
        }
    }
    else if($grid == 2) {
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
            $dt .= $rows["id"].chr(3).number_format($i,0,",","").chr(3).$rows["tgl"].chr(3).$rows["unit"].chr(3).$rows["tindakan"].chr(3).$rows["qty"].chr(3).$rows["dokter"].chr(3).$rows["biaya"].chr(3).$rows["biaya_kso"].chr(3).$rows["biaya_pasien"].chr(3).$rows["bayar_kso"].chr(3).$rows["bayar_pasien"].chr(6);
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