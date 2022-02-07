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
$txtBayar=explode("|",$_REQUEST['txtBayar']);
$txtTin=explode("*",$_REQUEST['txtTin']);
$kunjId=explode("|",$_REQUEST['kunjId']);
//===============================
$statusProses='';
$alasan='';
switch(strtolower($_REQUEST['act'])){
	case 'tambah':
		if($idTrans!="1"){
			mysql_query("select * from k_transaksi where id='$id'");
			if(mysql_affected_rows()==0){
				$sqlTambah="insert into k_transaksi (id_trans,tgl,no_bukti,nilai,ket,tgl_act,user_act)
					values('$idTrans','$tgl','$noBukti','$nilai','$ket',now(),'$userId')";
				//echo $sqlTambah."<br/>";
				$rs=mysql_query($sqlTambah);			
			}else{
			    $statusProses="Error";
			    $alasan="Data sudah ada!";
			}
		}
		else{
			for($i=0; $i<sizeof($txtBayar)-1;$i++){
				//echo "->".$txtTin[$i]."<br>";
				mysql_query("select * from k_transaksi where id='$id'");
				if(mysql_affected_rows()==0){
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
					while(($rwTin=mysql_fetch_array($rsTin)) && $selesai==0){						
						$qDetail="insert into k_transaksi_detail (transaksi_id,tindakan_id,nilai,tipe)
						values('".$rwTrans['id']."','".$rwTin['id']."','".$rwTin['biaya_kso']."','0')";
						//echo $qDetail."<br>";
						$rsDetail=mysql_query($qDetail);						
						if($txtBayar[$i]>0){
							$txtBayar[$i]-=$rwTin['biaya_kso'];							
						}else{
							$selesai=1;
						}
					}
					
					$sTinKam="SELECT tk.id,tk.bayar_kso FROM $dbbilling.b_tindakan_kamar tk
						INNER JOIN $dbbilling.b_pelayanan p ON p.id=tk.pelayanan_id
						WHERE tk.bayar_kso<>'0' AND p.kunjungan_id='".$kunjId[$i]."'";
					//echo $sTin."<br>";
					$rsTinKam=mysql_query($sTinKam);
					$selesai=0;
					while(($rwTinKam=mysql_fetch_array($rsTinKam)) && $selesai==0){						
						$qDetail="insert into k_transaksi_detail (transaksi_id,tindakan_id,nilai,tipe)
						values('".$rwTrans['id']."','".$rwTinKam['id']."','".$rwTin['bayar_kso']."','1')";
						//echo $qDetail."<br>";
						$rsDetail=mysql_query($qDetail);						
						if($txtBayar[$i]>0){
							$txtBayar[$i]-=$rwTin['bayar_kso'];							
						}else{
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
		if(mysql_num_rows($rsTrans)>0){
			if($idTrans!='1'){
				$sqlHapus="delete from k_transaksi where id='$id'";
				mysql_query($sqlHapus);
			}else{
				$sqlHapus="delete from k_transaksi_detail where transaksi_id='$id'";
				mysql_query($sqlHapus);
				$sqlHapus2="delete from k_transaksi where id='$id'";
				mysql_query($sqlHapus2);
			}
		}else{
                    $statusProses="Error";
                    $alasan="Data tidak ditemukan!";
                }
		break;
	case 'simpan':
		$sqlTrans="select * from k_transaksi where id='$id'";
		$rsTrans=mysql_query($sqlTrans);
		if(mysql_num_rows($rsTrans)>0){		
                    $sqlSimpan="update k_transaksi set id_trans='$idTrans',tgl='$tgl',no_bukti='$noBukti',nilai='$nilai',ket='$ket',tgl_act=now() 
                    where id='$id'";                
                    $rs=mysql_query($sqlSimpan);
                }
                else{
                    $statusProses="Error";
                    $alasan="Data tidak ditemukan!";
                }
		break;
}

if($statusProses=='Error'){	
	$dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act'])."*|*".$alasan;
}
else{

	if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
	}
	
	if ($sorting==""){
		$sorting=$defaultsort;
	}
	$sql="SELECT t.id,t.tgl,t.no_bukti,t.id_trans,mt.nama AS jenis_pendapatan,t.nilai,t.ket FROM k_transaksi t
                INNER JOIN k_ms_transaksi mt ON mt.id=t.id_trans
			 WHERE mt.tipe='1' and MONTH(t.tgl)='$bln' AND YEAR(t.tgl)='$thn' and t.id_trans=1 ".$filter." order by ".$sorting;
	
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
	
	while ($rows=mysql_fetch_array($rs)){
		$i++;
		$dt.=$rows["id"]."|".$rows["id_trans"].chr(3).number_format($i,0,",","").chr(3).tglSQL($rows["tgl"]).chr(3).$rows["no_bukti"].chr(3).$rows["jenis_pendapatan"].chr(3).$rows["nilai"].chr(3).$rows["ket"].chr(6);
	}
	
	if ($dt!=$totpage.chr(5)){
		$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']);
		$dt=str_replace('"','\"',$dt);
	}
	mysql_free_result($rs);
}
mysql_close($konek);
///
header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")){
	header("Content-type: application/xhtml+xml");
}else{
	header("Content-type: text/xml");
}
echo $dt;
//*/
?>