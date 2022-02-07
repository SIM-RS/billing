<?php 
include("../koneksi/konek.php");
$grd = strtolower($_REQUEST["grd"]);
$grd1 = strtolower($_REQUEST["grd1"]);
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
if($grd=="true")
	$defaultsort="nobukti";
else
	$defaultsort="kunjungan_id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$userId = $_REQUEST['userId'];
$ksoId = $_REQUEST['ksoId'];
$bayarIGD = $_REQUEST['bayarIGD'];
$jaminan_kso = $_REQUEST['jaminan_kso'];
if ($jaminan_kso=="") $jaminan_kso=0;
$tglact=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$tgl = tglSQL($_REQUEST['tgl']); 
//===============================

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
			$statusProses='Fine';
			if ($_REQUEST['tipe']=="1"){
				$sqlTambah="insert into b_bayar (kunjungan_id,kasir_id,nobukti,tgl,dibayaroleh,tagihan,nilai,jaminan_kso,keringanan,titipan,tgl_act,user_act,tipe)
					values('".$_REQUEST['idKunj']."','".$_REQUEST['idKasir']."','".$_REQUEST['nobukti']."','".$tgl."','".$_REQUEST['dibayaroleh']."',0,0,0,'".$_REQUEST['nilai']."','".$jaminan_kso."','$tglact','$userId',".$_REQUEST['tipe'].")";
				$rs=mysql_query($sqlTambah);
			}elseif ($_REQUEST['tipe']=="0"){
				$sqlTambah="insert into b_bayar (kunjungan_id,kasir_id,nobukti,tgl,dibayaroleh,tagihan,nilai,jaminan_kso,keringanan,titipan,tgl_act,user_act,tipe)
					values('".$_REQUEST['idKunj']."','".$_REQUEST['idKasir']."','".$_REQUEST['nobukti']."','".$tgl."','".$_REQUEST['dibayaroleh']."','".$_REQUEST['tagihan']."','".$_REQUEST['nilai']."','".$jaminan_kso."','".$_REQUEST['keringanan']."','".$_REQUEST['titipan']."','$tglact','$userId',".$_REQUEST['tipe'].")";
				//echo $sqlTambah."<br>";
				$rs=mysql_query($sqlTambah);
				if (mysql_errno()==0){
					if ($_REQUEST['titipan']>0){
						$sql="SELECT * FROM b_bayar WHERE kunjungan_id='".$_REQUEST['idKunj']."' AND kasir_id='".$_REQUEST['idKasir']."' AND titipan_terpakai<titipan AND tipe=1 order by id";
						$rs=mysql_query($sql);
						$titipan=$_REQUEST['titipan'];
						$ok="false";
						
						while (($rows=mysql_fetch_array($rs)) && ($ok=="false")){
							$cid=$rows['id'];
							$ctitip=$rows['titipan']-$rows['titipan_terpakai'];
							if ($titipan<=$ctitip){
								$ok="true";
								$sql="UPDATE b_bayar SET titipan_terpakai=titipan_terpakai+$titipan WHERE id=$cid";
							}else{
								$titipan=$titipan-$ctitip;
								$sql="UPDATE b_bayar SET titipan_terpakai=titipan_terpakai+$ctitip WHERE id=$cid";
							}
							$rs1=mysql_query($sql);
						}
					}
					
					$sqlBayar = "SELECT * FROM b_bayar WHERE kunjungan_id = '".$_REQUEST['idKunj']."' AND nobukti = '".$_REQUEST['nobukti']."' AND user_act = $userId ORDER BY id DESC LIMIT 1";
					echo $sqlBayar."<br>";
					$rsBayar = mysql_query($sqlBayar);
					if (mysql_num_rows($rsBayar)>0){
						$rwBayar = mysql_fetch_array($rsBayar);
						$idBayar = $rwBayar['id'];
						//echo $sqlBayar;
						
						if($_REQUEST['jenisKasir']=='0'){
							$idUnitAmbulan=0;
							$idUnitJenazah=0;
							$sql="SELECT * FROM b_ms_reference WHERE stref=26";
							$rsRef=mysql_query($sql);
							if ($rwRef=mysql_fetch_array($rsRef)){
								$idUnitAmbulan=$rwRef["nama"];
							}
							$sql="SELECT * FROM b_ms_reference WHERE stref=27";
							$rsRef=mysql_query($sql);
							if ($rwRef=mysql_fetch_array($rsRef)){
								$idUnitJenazah=$rwRef["nama"];
							}
							
							/*if ($ksoId=="1"){
								if ($bayarIGD=="0"){
									$sqlTind = "SELECT t.* FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND (p.unit_id=45 OR p.unit_id_asal=45) AND p.unit_id<>$idUnitAmbulan AND p.unit_id<>$idUnitJenazah AND mu.inap=0 AND t.bayar < (t.biaya*t.qty) ORDER BY t.tgl_act";
								}elseif ($bayarIGD=="2"){
									$sqlTind = "SELECT t.* FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND p.unit_id=$idUnitAmbulan AND mu.inap=0 AND t.bayar < (t.biaya*t.qty) ORDER BY t.tgl_act";
								}elseif ($bayarIGD=="3"){
									$sqlTind = "SELECT t.* FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND p.unit_id=$idUnitJenazah AND mu.inap=0 AND t.bayar < (t.biaya*t.qty) ORDER BY t.tgl_act";
								}else{
									if ($_REQUEST['idKasir']==127){
										$sqlTind = "SELECT t.* FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND p.unit_id<>$idUnitAmbulan AND p.unit_id<>$idUnitJenazah AND t.ms_tindakan_kelas_id=7513 AND t.bayar < (t.biaya*t.qty) ORDER BY t.tgl_act";
									}else{
										$sqlTind = "SELECT t.* FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND p.unit_id<>$idUnitAmbulan AND p.unit_id<>$idUnitJenazah AND t.bayar < (t.biaya*t.qty) ORDER BY t.tgl_act";
									}
								}
							}else{*/
								if ($bayarIGD=="0"){
									$sqlTind = "SELECT t.* FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND (p.unit_id=45 OR p.unit_id_asal=45) AND p.unit_id<>$idUnitAmbulan AND p.unit_id<>$idUnitJenazah AND mu.inap=0 AND t.bayar_pasien < (t.biaya_pasien*t.qty) ORDER BY t.tgl_act";
								}elseif ($bayarIGD=="2"){
									$sqlTind = "SELECT t.* FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND p.unit_id=$idUnitAmbulan AND mu.inap=0 AND t.bayar_pasien < (t.biaya_pasien*t.qty) ORDER BY t.tgl_act";
								}elseif ($bayarIGD=="3"){
									$sqlTind = "SELECT t.* FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND p.unit_id=$idUnitJenazah AND mu.inap=0 AND t.bayar_pasien < (t.biaya_pasien*t.qty) ORDER BY t.tgl_act";
								}else{
									if ($_REQUEST['idKasir']==127){
										$sqlTind = "SELECT t.* FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND p.unit_id<>$idUnitAmbulan AND p.unit_id<>$idUnitJenazah AND t.ms_tindakan_kelas_id=7513 AND t.bayar_pasien < (t.biaya_pasien*t.qty) ORDER BY t.tgl_act";
									}else{
										$sqlTind = "SELECT t.* FROM b_tindakan t INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND p.unit_id<>$idUnitAmbulan AND p.unit_id<>$idUnitJenazah AND t.bayar_pasien < (t.biaya_pasien*t.qty) ORDER BY t.tgl_act";
									}
								}
							//}
						}else{
							/*if ($ksoId=="1"){
								$sqlTind = "SELECT * FROM b_tindakan WHERE pelayanan_id='".$_REQUEST['idPel']."' AND bayar < (biaya*qty) ORDER BY tgl_act";
							}else{*/
								$sqlTind = "SELECT * FROM b_tindakan WHERE pelayanan_id='".$_REQUEST['idPel']."' AND (biaya_pasien*qty) > bayar_pasien ORDER BY tgl_act";
							//}
						}
						//echo $sqlTind."<br>";
						$rsTind = mysql_query($sqlTind);
						$ok = 'true';
						$nilai = $_REQUEST['nilai']+$_REQUEST['titipan'];
						$keringanan=($_REQUEST['keringanan']=="")?0:$_REQUEST['keringanan'];

						while(($rwTind = mysql_fetch_array($rsTind)) && ($ok == 'true'))
						{
							$tindId = $rwTind['id'];
							$kso_id = $rwTind['kso_id'];
							$biaya = ($rwTind['biaya_pasien'] * $rwTind['qty']) - $rwTind['bayar_pasien'];
							/*if ($ksoId=="1"){
								$biaya = ($rwTind['biaya'] * $rwTind['qty']) - $rwTind['bayar'];
							}*/
							
							$nilai = $nilai - $biaya;
							if($nilai >= 0 )
							{
								$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai) VALUES('$idBayar','$tindId','$kso_id','$biaya')";
								//echo $sqlIn."<br>";
								$rsIn = mysql_query($sqlIn);
								
								if (mysql_errno()==0){
									$sqlUp = "UPDATE b_tindakan SET bayar = bayar + $biaya,bayar_pasien=bayar_pasien+$biaya, lunas = 1 WHERE id = $tindId";
									//echo $sqlUp."<br>";
									$rsUp = mysql_query($sqlUp);
								}else{
									$ok = 'false';
									$statusProses='Error';
								}
							}
							else
							{
								$lunas=0;
								if (($nilai+$keringanan)>=0){
									$lunas=1;
									$keringanan=$keringanan+$nilai;
								}
								$nilai = $nilai + $biaya;
								
								$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai) VALUES('$idBayar','$tindId','$kso_id','$nilai')";
								//echo $sqlIn."<br>";
								$rsIn = mysql_query($sqlIn);
								
								if (mysql_errno()==0){
									$sqlUp = "UPDATE b_tindakan SET bayar = bayar + $nilai,bayar_pasien=bayar_pasien+$nilai, lunas = $lunas WHERE id = $tindId";
									//echo $sqlUp."<br>";
									$rsUp = mysql_query($sqlUp);
								}else{
									$ok = 'false';
									$statusProses='Error';
								}
								$nilai=0;
							}
						}
						
						if ($ok == 'true'){
							if($_REQUEST['jenisKasir']=='0'){
								//if ($ksoId!="1"){
									$sqlTind = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe) SELECT $idBayar,id,kso_id,0,0 FROM b_tindakan WHERE kunjungan_id='".$_REQUEST['idKunj']."' AND biaya_pasien=0 
			AND id NOT IN (SELECT tindakan_id FROM b_bayar_tindakan bt INNER JOIN b_bayar b ON bt.bayar_id=b.id WHERE b.kunjungan_id='".$_REQUEST['idKunj']."') 
			ORDER BY tgl_act";
									$rsTind = mysql_query($sqlTind);
								//}
							}else{
								//if ($ksoId!="1"){
									$sqlTind = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe) SELECT $idBayar,id,kso_id,0,0 FROM b_tindakan WHERE kunjungan_id='".$_REQUEST['idKunj']."' AND pelayanan_id='".$_REQUEST['idPel']."' AND biaya_pasien = 0 ORDER BY tgl_act";
									$rsTind = mysql_query($sqlTind);
								//}
							}
							//echo $sqlTind."<br>";
							if(($_REQUEST['jenisKasir']=='0') && ($bayarIGD=="1")){
								$sqlkamar="SELECT * FROM (SELECT b.id,b.kso_id,IF(b.tgl_out IS NULL,0,1) AS tgl_out,IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_pasien-bayar,
	(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*beban_pasien-bayar) AS biaya,
	IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in))),
	(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))) AS qty_hari 
	FROM b_tindakan_kamar b INNER JOIN b_pelayanan p ON b.pelayanan_id=p.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' 
	AND beban_pasien>0 AND b.aktif=1) AS t WHERE t.biaya>0";
								//echo $sqlkamar."<br>";
								$rsKamar=mysql_query($sqlkamar);
								//echo "nilai=".$nilai."<br>";
								$isInap=1;
								while(($rwKamar=mysql_fetch_array($rsKamar)) && ($ok == 'true')){
									$isInap=1;
									$tglout="";
									$tindId = $rwKamar['id'];
									$kso_id = $rwKamar['kso_id'];
									$biaya = $rwKamar['biaya'];
									$nilai = $nilai - $biaya;
									if($nilai >= 0 )
									{
										
										if ($rwKamar['tgl_out']==0){
											$tglout=",tgl_out=now()";
										}
										
										$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe) VALUES('$idBayar','$tindId','$kso_id','$biaya','1')";
										//echo $sqlIn."<br>";
										$rsIn = mysql_query($sqlIn);
										
										if (mysql_errno()==0){
											$sqlUp = "UPDATE b_tindakan_kamar SET bayar = bayar + $biaya,bayar_pasien=bayar_pasien+$biaya, lunas = 1".$tglout." WHERE id = $tindId";
											//echo $sqlUp."<br>";
											$rsUp = mysql_query($sqlUp);
										}else{
											$ok = 'false';
											$statusProses='Error';
										}
									}
									else
									{
										$lunas=0;
										if (($nilai+$keringanan)>=0){
											$lunas=1;
											$tglout=",tgl_out=now()";
											$keringanan=$keringanan+$nilai;
										}
										$nilai = $nilai + $biaya;
										
										$sqlIn = "INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe) VALUES('$idBayar','$tindId','$kso_id','$nilai','1')";
										//echo $sqlIn."<br>";
										$rsIn = mysql_query($sqlIn);
										
										if (mysql_errno()==0){
											$sqlUp = "UPDATE b_tindakan_kamar SET bayar = bayar + $nilai,bayar_pasien=bayar_pasien+$nilai, lunas = $lunas".$tglout." WHERE id = $tindId";
											//echo $sqlUp."<br>";
											$rsUp = mysql_query($sqlUp);
										}else{
											$ok = 'false';
											$statusProses='Error';
										}
									}
								}
								
								$sql="UPDATE b_tindakan_kamar tk INNER JOIN b_pelayanan p ON tk.pelayanan_id=p.id SET tk.tgl_out=NOW() 
	WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND tk.aktif=1 AND tk.tgl_out IS NULL";
								//echo $sql."<br>";
								$rsIn = mysql_query($sql);
								
								//$sql="SELECT * FROM b_kunjungan WHERE id='".$_REQUEST['idKunj']."' AND tgl_pulang IS NULL";
								$sql="SELECT k.id FROM b_kunjungan k INNER JOIN b_pelayanan p ON k.id=p.kunjungan_id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
WHERE k.id='".$_REQUEST['idKunj']."' AND mu.inap=1 AND p.dilayani>0 AND k.tgl_pulang IS NULL";
								//echo $sql."<br>";
								$rsIn = mysql_query($sql);
								if (mysql_num_rows($rsIn)>0){
									$sql="UPDATE b_kunjungan SET tgl_pulang=NOW(),pulang=1 WHERE id='".$_REQUEST['idKunj']."'";
									//echo $sql."<br>";
									$rsIn = mysql_query($sql);
								}
								
								if ($ok == 'true'){
									//if ($ksoId!="1"){
										$sql="INSERT INTO b_bayar_tindakan(bayar_id,tindakan_id,kso_id,nilai,tipe) SELECT $idBayar,b.id,b.kso_id,0,1 FROM b_tindakan_kamar b INNER JOIN b_pelayanan p ON b.pelayanan_id=p.id WHERE p.kunjungan_id='".$_REQUEST['idKunj']."' AND beban_pasien=0";
										//echo $sql."<br>";
										$rsIn = mysql_query($sql);
									//}
								}
							}
						}
					}else{
						$statusProses='Error';
					}
				}else{
					$statusProses='Error';
				}
			}
			break;
	case 'hapus':
		$sqlHapus="delete from b_bayar where id='".$_REQUEST['rowid']."'";
		mysql_query($sqlHapus);
		$sqlHapus="UPDATE b_tindakan t,b_bayar_tindakan bt SET t.bayar=t.bayar-bt.nilai,t.bayar_pasien=t.bayar_pasien-bt.nilai,t.lunas=0 WHERE t.id=bt.tindakan_id AND bt.bayar_id='".$_REQUEST['rowid']."' AND bt.tipe=0 AND bt.nilai>0";
		mysql_query($sqlHapus);
		$sqlHapus="UPDATE b_tindakan_kamar t,b_bayar_tindakan bt SET t.bayar=t.bayar-bt.nilai,t.bayar_pasien=t.bayar_pasien-bt.nilai,t.lunas=0 WHERE t.id=bt.tindakan_id AND bt.bayar_id='".$_REQUEST['rowid']."' AND bt.tipe=1 AND bt.nilai>0";
		mysql_query($sqlHapus);
		$sqlHapus="delete from b_bayar_tindakan where bayar_id='".$_REQUEST['rowid']."'";
		mysql_query($sqlHapus);
		break;
	case 'simpan':
		$sqlSimpan="update b_bayar set kunjungan_id='".$_REQUEST['idKunj']."',kasir_id='".$_REQUEST['idKasir']."',tgl='".$tgl."',dibayaroleh='".$_REQUEST['dibayaroleh']."',nobukti='".$_REQUEST['nobukti']."',nilai='".$_REQUEST['nilai']."',tgl_act='$tglact',user_act='$userId' where id='".$_REQUEST['idBayar']."'";		
		$rs=mysql_query($sqlSimpan);
		break;
}

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act']);
}
else {
	if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
	}
	
	if ($sorting==""){
		$sorting=$defaultsort;
	}
	
	if(strtolower($grd) == "true")
	{
		$sql="select * from (SELECT b.id,b.kunjungan_id,b.kasir_id,u.nama,b.nobukti,DATE(b.tgl) as tgl,b.dibayaroleh,b.tagihan,b.nilai,b.jaminan_kso,b.keringanan,b.titipan,b.tgl_act,b.user_act,b.tipe FROM b_bayar b
	inner join b_ms_pegawai u on b.user_act=u.id WHERE b.kunjungan_id = '".$_REQUEST['idKunj']."' AND b.kasir_id='".$_REQUEST['idKasir']."') as gab order by gab.id desc";
	}
	elseif(strtolower($grd1)=="true")
	{
		if ($_REQUEST['idPel']==""){
			$sql="SELECT * FROM (SELECT t.id,kunjungan_id,mt.kode kdTind,mt.nama nmTind,mk.nama nmKls,biaya*qty subTot,biaya,
	qty cTind,ket,mp.nama konsul FROM b_tindakan t INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id 
	INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id INNER JOIN b_ms_kelas mk ON mtk.ms_kelas_id=mk.id 
	LEFT JOIN b_ms_pegawai mp ON t.user_id=mp.id WHERE kunjungan_id=".$_REQUEST['idKunj']." 
	UNION 
	SELECT tk.id,p.kunjungan_id,mk.kode kdTind,mk.nama nmTind,mKls.nama nmKls,
	IF(tk.status_out=0,(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tgl_in)+1)*tk.tarip,(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tgl_in))*tk.tarip) subTot,
	tk.tarip biaya,IF(tk.status_out=0,(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tgl_in)+1),(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tgl_in))) cTind,'','' 
	FROM b_tindakan_kamar tk INNER JOIN b_pelayanan p ON tk.pelayanan_id=p.id INNER JOIN b_ms_kamar mk ON tk.kamar_id=mk.id 
	INNER JOIN b_ms_kelas mKls ON tk.kelas_id=mKls.id WHERE kunjungan_id=".$_REQUEST['idKunj']." AND tk.aktif=1) AS gab $filter order by $sorting";
		}else{
			$sql="SELECT t.id,t.kunjungan_id,mt.kode kdTind,mt.nama nmTind,mk.nama nmKls,biaya*qty subTot,biaya,
	qty cTind,t.ket,mp.nama konsul FROM b_tindakan t INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id 
	INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id INNER JOIN b_ms_kelas mk ON mtk.ms_kelas_id=mk.id 
	LEFT JOIN b_ms_pegawai mp ON t.user_id=mp.id INNER JOIN b_ms_unit mu ON t.unit_act=mu.id WHERE t.pelayanan_id=".$_REQUEST['idPel']." ORDER BY t.id";
		}
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
	
	if(strtolower($grd) == "true")
	{
		while ($rows=mysql_fetch_array($rs))
		{
			$i++;
			$sisipan = $rows["id"]."|".$rows["kunjungan_id"]."|".$rows["tagihan"]."|".$rows["keringanan"]."|".$rows["titipan"]."|".$rows["tipe"]."|".$rows["nilai"]."|".$rows["jaminan_kso"];
			$dt.=$sisipan.chr(3).number_format($i,0,",","").chr(3).$rows["nobukti"].chr(3).tglSQL($rows["tgl"]).chr(3).(($rows["tipe"]==0)?$rows["nilai"]:$rows["titipan"]).chr(3).$rows["dibayaroleh"].chr(3).$rows["nama"].chr(3).(($rows["tipe"]==0)?"Pembayaran":"Titipan").chr(6);
		}
	}elseif($grd1=="true")
	{
		while ($rows=mysql_fetch_array($rs))
		{
			$i++;
			$dt.=$rows['id'].chr(3).number_format($i,0,",","").chr(3).$rows["kdTind"].chr(3).$rows["nmTind"].chr(3).$rows["nmKls"].chr(3).$rows["biaya"].chr(3).$rows["cTind"].chr(3).$rows["subTot"].chr(3).$rows["konsul"].chr(3).$rows["ket"].chr(6);
		}
	}
	
	if ($dt!=$totpage.chr(5)){
			$dt=substr($dt,0,strlen($dt)-1).chr(5).strtolower($_REQUEST['act']);
			$dt=str_replace('"','\"',$dt);
		}
	
		mysql_free_result($rs);
}
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