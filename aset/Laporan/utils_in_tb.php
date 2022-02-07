<?php 
session_start();
set_time_limit(5000);
include("../koneksi/konek.php");
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
date_default_timezone_set("Asia/Jakarta");
$tgl1=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl1);
$bulan=$_REQUEST['bln'];
if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1]; 
$ta=$_REQUEST['thn'];
if ($ta=="") $ta=$th[2];
//$bln = $_REQUEST['bln'];
//$thn = $_REQUEST['thn'];
$act = $_REQUEST['act'];
$ttp = $_REQUEST['ttp'];
$tipe = $_REQUEST["tipe"];
if($act=='add'){
$qw = mysql_query("select barang_id from tutup_buku where 
barang_id in (select idbarang from as_ms_barang where tipe='$tipe' and islast=1) 
and bln = '$bulan' AND thn = '$ta' ");
$dr = mysql_num_rows($qw);
if($dr > 0 && $ttp==0){
	echo "1";
}else{
if($ttp==1){
//echo ("delete from tutup_buku where bln='$bulan' and thn='$ta'");
mysql_query("delete from tutup_buku where bln='$bulan' and thn='$ta' and barang_id in 
(select idbarang from as_ms_barang where tipe='$tipe' and islast=1)");
}
$sqlup = mysql_query("select idbarang from as_ms_barang where tipe='$tipe' and islast = 1 order by kodebarang");
//echo "select idbarang from as_ms_barang where islast = 1 order by kodebarang<br>";
while($rows = mysql_fetch_array($sqlup)){
   $bln1 = $bln = $bulan;
	$thn1 = $thn = $ta;
	$bln = $bln-1;
	if($bln==0)
	{
	$bln = 12;
	$thn = $thn-1;
	}
    $dr = "select saldo_jml AS awal_jml,saldo_nilai AS awal_nilai from tutup_buku where thn='$thn' AND bln='$bln' AND barang_id = '".$rows['idbarang']."'";
//echo $dr."<br>";
	$dr1 = mysql_query($dr);
	$dr2 = mysql_fetch_array($dr1);
	if($dr2['awal_jml']=='') $dr2['awal_jml']=0;
	if($dr2['awal_nilai']=='') $dr2['awal_nilai']=0;
	
	$drt = "select sum(jml_masuk) AS masuk_jml,sum(jml_keluar) AS keluar_jml,sum(nilai_masuk) AS masuk_nilai,sum(nilai_keluar) AS keluar_nilai from as_kstok where YEAR(waktu)='$thn1' AND MONTH(waktu)='$bln1' AND barang_id = '".$rows['idbarang']."'";
//echo $drt."<br>";	
	$dr1t = mysql_query($drt);
	$dr2t = mysql_fetch_array($dr1t);
	if($dr2t['masuk_jml']=='') $dr2t['masuk_jml']=0;
	if($dr2t['masuk_nilai']=='') $dr2t['masuk_nilai']=0;
	if($dr2t['keluar_jml']=='') $dr2t['keluar_jml']=0;
	if($dr2t['keluar_nilai']=='') $dr2t['keluar_nilai']=0;
	
	$jml_saldo = $dr2['awal_jml']+$dr2t['masuk_jml']-$dr2t['keluar_jml'];
	$nilai_saldo = $dr2['awal_nilai']+$dr2t['masuk_nilai']-$dr2t['keluar_nilai'];
	$sqlIns="insert into user_log (log_user,log_time,log_action,log_query,log_ip) values ('".$_SESSION['id_user']."',sysdate(),'Insert Tutup Buku','insert into tutup_buku values('',$ta,$bulan,".$rows['idbarang'].",".$dr2['awal_jml'].",".$dr2['awal_nilai'].",".$dr2t['masuk_jml'].",".$dr2t['masuk_nilai'].",".$dr2t['keluar_jml'].",".$dr2t['keluar_nilai'].",$jml_saldo,$nilai_saldo,sysdate(),$_SESSION[id_user])','".$_SERVER['REMOTE_ADDR']."')";
		mysql_query($sqlIns);
		
 $sqlin = "insert into tutup_buku values('','$ta','$bulan','".$rows['idbarang']."','".$dr2['awal_jml']."','".$dr2['awal_nilai']."','".$dr2t['masuk_jml']."','".$dr2t['masuk_nilai']."','".$dr2t['keluar_jml']."','".$dr2t['keluar_nilai']."','$jml_saldo','$nilai_saldo',sysdate(),'$_SESSION[id_user]')";
//echo $sqlin."<br>";
//break; 
 mysql_query($sqlin);
}
//echo 'ok';
}
}
?>