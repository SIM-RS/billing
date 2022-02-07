<?php 
include("../sesi.php"); 
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tglctk=gmdate('d/m/Y H:i',mktime(date('H')+7));
$tgl_act=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_REQUEST["ses_idunit"];
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$minta_id=$_REQUEST['minta_id'];
$no_minta=$_REQUEST['no_minta'];
$no_gdg=$_REQUEST['no_gdg'];
$iunit_krm=$_REQUEST['iunit_krm'];
$idunit_krm=$_REQUEST['idunit_krm'];
$no_terima=$_REQUEST['no_terima'];
$no_terima1=$_REQUEST['no_terima'];
$tgl_terima=$_REQUEST['tgl_terima'];
$tgl_terima1=$_REQUEST['tgl_terima'];
$iduser = $_REQUEST["iduser"];
if ($tgl_terima!=""){
	$tgl_terima=explode("-",$tgl_terima);
	$tgl_terima=$tgl_terima[2]."-".$tgl_terima[1]."-".$tgl_terima[0];
}
$isview=$_REQUEST['isview'];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="am.tgl,am.permintaan_id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

$qkdunit = "SELECT * FROM dbapotek_tangerang.a_unit WHERE unit_id = $idunit";
$rqkdunit = mysql_query($qkdunit);
$dqkdunit = mysql_fetch_array($rqkdunit);
$kodeunit = $dqkdunit['UNIT_KODE'];

switch ($act){
 	case "save":
		$fdata=$_REQUEST['fdata'];
		$arfvalue=explode("**",$fdata);
		$sql="SELECT SQL_NO_CACHE *,UUID() AS cuid FROM dbapotek_tangerang.a_penerimaan WHERE NOKIRIM='$no_gdg' and UNIT_ID_TERIMA=$idunit and TIPE_TRANS=1 AND STATUS=1 LIMIT 1";
		//echo $sql."<br>";
		$rsChk=mysql_query($sql);
		if (mysql_num_rows($rsChk)>0){
			echo "<script>alert('Pengiriman Obat dari Unit Lain dg No Kirim $no_gdg : Sudah Diterima !');</script>";
			exit();
		}else{
			$sql="SELECT SQL_NO_CACHE *,UUID() AS cuid FROM dbapotek_tangerang.a_penerimaan WHERE NOTERIMA='$no_terima' AND USER_ID_TERIMA=$iduser AND TGL_TERIMA='$tgl_terima' AND STATUS=1";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
			$cfkmintaid="";
			if (mysql_num_rows($rs)<=0){
				for ($j=0;$j<count($arfvalue);$j++){
					$arfdata=explode("|",$arfvalue[$j]);
					$cfkmintaid .=$arfdata[2].",";
					$sql="update dbapotek_tangerang.a_minta_obat set status=2,qty_terima=qty_terima+$arfdata[5] where permintaan_id=$arfdata[2]";
					//echo $sql."<br>";
					$rs=mysql_query($sql);
					if ($arfdata[4]>$arfdata[5]){
						$jml=$arfdata[4]-$arfdata[5];
						$jml=0;
						$sql="select SQL_NO_CACHE *,UUID() AS cuid from a_penerimaan where NOKIRIM='$no_gdg' and FK_MINTA_ID=$arfdata[2] and UNIT_ID_TERIMA=$idunit and TIPE_TRANS=1 order by ID";
						//echo $sql."<br>";
						$rs=mysql_query($sql);
						$done=0;
						while ($rows=mysql_fetch_array($rs)){
							$qty=$rows['QTY_SATUAN'];
							$cid=$rows['ID'];
							$pid=$rows['ID_LAMA'];
							$ch_satuan=$rows['HARGA_BELI_SATUAN'];
							$cdiskon=$rows['DISKON'];
							$ctipetrans=$rows['TIPE_TRANS'];
							$cnpajak=$rows['NILAI_PAJAK'];
							if (($cnpajak<=0) || ($ctipetrans==4) || ($ctipetrans==5) || ($ctipetrans==100)){
								$ch_satuan=$ch_satuan * (1-($cdiskon/100));
							}else{
								$ch_satuan=$ch_satuan * (1-($cdiskon/100)) * 1.1;
							}
							
							if ($done==1){
								$sql="update dbapotek_tangerang.a_penerimaan set NOTERIMA='$no_terima',USER_ID_TERIMA=$iduser,TGL_TERIMA_ACT='$tgl_act',TGL_TERIMA='$tgl_terima',STATUS=1,QTY_SATUAN=0,QTY_STOK=0 where ID=$cid";
								//echo $sql."<br>";
								$rs1=mysql_query($sql);
								$sql="update  dbapotek_tangerang.a_penerimaan set QTY_STOK=QTY_STOK+$qty where ID=$pid";
								//echo $sql."<br>";
								$rs1=mysql_query($sql);
								
								$sql="SELECT SQL_NO_CACHE IFNULL(SUM(t1.stok_after),0) AS stok_after,IFNULL(SUM(t1.ntot),0) AS ntot FROM (SELECT SQL_NO_CACHE UUID() AS cuid,IFNULL(QTY_STOK,0) AS stok_after,IFNULL((IF(((NILAI_PAJAK<=0) OR (TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) * 1.1)),0) AS ntot FROM a_penerimaan WHERE OBAT_ID=$arfdata[0] AND KEPEMILIKAN_ID=$arfdata[1] AND UNIT_ID_TERIMA=$idunit_krm AND QTY_STOK>0 AND STATUS=1) AS t1";
								$rs1=mysql_query($sql);
								$cstok_lama=0;
								$cnilai_lama=0;
								if ($rows1=mysql_fetch_array($rs1)){
									$cstok_lama=$rows1['stok_after'];
									$cnilai_lama=$rows1['ntot'];
								}
								//Kartu Stok Pengirim
								$sql="INSERT INTO A_KARTUSTOK (OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID,fkid,tipetrans,HARGA_SATUAN,NILAI_TOTAL) VALUES ($arfdata[0],$arfdata[1],$idunit_krm,'$tgl_terima',NOW(),'$no_terima',$cstok_lama-$qty,0,-$qty,$cstok_lama,'Out(-) $no_gdg - $no_terima',$iduser,$pid,1,$ch_satuan,$cnilai_lama)";
								//echo $sql."<br>";
								$rs1=mysql_query($sql);
								//Stok Pengirim
								$sql="SELECT IFNULL(COUNT(id),0) cAda FROM a_stok WHERE unit_id=$idunit_krm AND obat_id=$arfdata[0] AND kepemilikan_id=$arfdata[1]";
								$rs1=mysql_query($sql);
								$rw1=mysql_fetch_array($rs1);
								if ($rw1["cAda"]>0){
									$sql="UPDATE a_stok SET qty_stok=$cstok_lama,nilai=$cnilai_lama,tgl_act=NOW() WHERE unit_id=$idunit_krm AND obat_id=$arfdata[0] AND kepemilikan_id=$arfdata[1]";
								}else{
									$sql="INSERT INTO a_stok(unit_id,obat_id,kepemilikan_id,qty_stok,nilai,tgl_act) 
									VALUES($idunit_krm,$arfdata[0],$arfdata[1],$cstok_lama,$cnilai_lama,NOW())";
								}
								$rs1=mysql_query($sql);
							}else{
								$jml=$jml+$qty;
								if ($jml>=$arfdata[5]){
									$done=1;
									$selisih=$jml-$arfdata[5];
									if ($selisih>0){
										$sql="update  dbapotek_tangerang.a_penerimaan set NOTERIMA='$no_terima',USER_ID_TERIMA=$iduser,TGL_TERIMA_ACT='$tgl_act',TGL_TERIMA='$tgl_terima',STATUS=1,QTY_SATUAN=QTY_SATUAN-$selisih,QTY_STOK=QTY_STOK-$selisih where ID=$cid";
										//echo $sql."<br>";
										$rs1=mysql_query($sql);
										$sql="update  dbapotek_tangerang.a_penerimaan set QTY_STOK=QTY_STOK+$selisih where ID=$pid";
										//echo $sql."<br>";
										$rs1=mysql_query($sql);
										
										$sql="SELECT SQL_NO_CACHE IFNULL(SUM(t1.stok_after),0) AS stok_after,IFNULL(SUM(t1.ntot),0) AS ntot FROM (SELECT SQL_NO_CACHE UUID() AS cuid,IFNULL(QTY_STOK,0) AS stok_after,IFNULL((IF(((NILAI_PAJAK<=0) OR (TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) * 1.1)),0) AS ntot FROM a_penerimaan WHERE OBAT_ID=$arfdata[0] AND KEPEMILIKAN_ID=$arfdata[1] AND UNIT_ID_TERIMA=$idunit AND QTY_STOK>0 AND STATUS=1) AS t1";
										$rs1=mysql_query($sql);
										$cstok=0;
										$cnilai=0;
										if ($rows1=mysql_fetch_array($rs1)){
											$cstok=$rows1['stok_after'];
											$cnilai=$rows1['ntot'];
										}
										$sql="SELECT SQL_NO_CACHE IFNULL(SUM(t1.stok_after),0) AS stok_after,IFNULL(SUM(t1.ntot),0) AS ntot FROM (SELECT SQL_NO_CACHE UUID() AS cuid,IFNULL(QTY_STOK,0) AS stok_after,IFNULL((IF(((NILAI_PAJAK<=0) OR (TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) * 1.1)),0) AS ntot FROM a_penerimaan WHERE OBAT_ID=$arfdata[0] AND KEPEMILIKAN_ID=$arfdata[1] AND UNIT_ID_TERIMA=$idunit_krm AND QTY_STOK>0 AND STATUS=1) AS t1";
										$rs1=mysql_query($sql);
										$cstok_lama=0;
										$cnilai_lama=0;
										if ($rows1=mysql_fetch_array($rs1)){
											$cstok_lama=$rows1['stok_after'];
											$cnilai_lama=$rows1['ntot'];
										}
										//Kartu Stok Penerima
										$sql="INSERT INTO A_KARTUSTOK (OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID,fkid,tipetrans,HARGA_SATUAN,NILAI_TOTAL) VALUES ($arfdata[0],$arfdata[1],$idunit,'$tgl_terima',NOW(),'$no_terima',$cstok-$qty+$selisih,$qty-$selisih,0,$cstok,'IN $no_gdg - $no_terima',$iduser,$cid,1,$ch_satuan,$cnilai)";
										//echo $sql."<br>";
										$rs1=mysql_query($sql);
										//Kartu Stok Pengirim
										$sql="INSERT INTO A_KARTUSTOK (OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID,fkid,tipetrans,HARGA_SATUAN,NILAI_TOTAL) VALUES ($arfdata[0],$arfdata[1],$idunit_krm,'$tgl_terima',NOW(),'$no_terima',$cstok_lama-$selisih,0,-$selisih,$cstok_lama,'Out(-) $no_gdg - $no_terima',$iduser,$pid,1,$ch_satuan,$cnilai_lama)";
										//echo $sql."<br>";
										$rs1=mysql_query($sql);
										//Stok Penerima
										$sql="SELECT IFNULL(COUNT(id),0) cAda FROM a_stok WHERE unit_id=$idunit AND obat_id=$arfdata[0] AND kepemilikan_id=$arfdata[1]";
										$rs1=mysql_query($sql);
										$rw1=mysql_fetch_array($rs1);
										if ($rw1["cAda"]>0){
											$sql="UPDATE a_stok SET qty_stok=$cstok,nilai=$cnilai,tgl_act=NOW() WHERE unit_id=$idunit AND obat_id=$arfdata[0] AND kepemilikan_id=$arfdata[1]";
										}else{
											$sql="INSERT INTO a_stok(unit_id,obat_id,kepemilikan_id,qty_stok,nilai,tgl_act) 
											VALUES($idunit,$arfdata[0],$arfdata[1],$cstok,$cnilai,NOW())";
										}
										$rs1=mysql_query($sql);
										//Stok Pengirim
										$sql="SELECT IFNULL(COUNT(id),0) cAda FROM a_stok WHERE unit_id=$idunit_krm AND obat_id=$arfdata[0] AND kepemilikan_id=$arfdata[1]";
										$rs1=mysql_query($sql);
										$rw1=mysql_fetch_array($rs1);
										if ($rw1["cAda"]>0){
											$sql="UPDATE a_stok SET qty_stok=$cstok_lama,nilai=$cnilai_lama,tgl_act=NOW() WHERE unit_id=$idunit_krm AND obat_id=$arfdata[0] AND kepemilikan_id=$arfdata[1]";
										}else{
											$sql="INSERT INTO a_stok(unit_id,obat_id,kepemilikan_id,qty_stok,nilai,tgl_act) 
											VALUES($idunit_krm,$arfdata[0],$arfdata[1],$cstok_lama,$cnilai_lama,NOW())";
										}
										$rs1=mysql_query($sql);
									}else{
										$sql="update  dbapotek_tangerang.a_penerimaan set NOTERIMA='$no_terima',USER_ID_TERIMA=$iduser,TGL_TERIMA_ACT='$tgl_act',TGL_TERIMA='$tgl_terima',STATUS=1 where ID=$cid";
										//echo $sql."<br>";
										$rs1=mysql_query($sql);
										
										$sql="SELECT SQL_NO_CACHE IFNULL(SUM(t1.stok_after),0) AS stok_after,IFNULL(SUM(t1.ntot),0) AS ntot FROM (SELECT SQL_NO_CACHE UUID() AS cuid,IFNULL(QTY_STOK,0) AS stok_after,IFNULL((IF(((NILAI_PAJAK<=0) OR (TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) * 1.1)),0) AS ntot FROM a_penerimaan WHERE OBAT_ID=$arfdata[0] AND KEPEMILIKAN_ID=$arfdata[1] AND UNIT_ID_TERIMA=$idunit AND QTY_STOK>0 AND STATUS=1) AS t1";
										$rs1=mysql_query($sql);
										$cstok=0;
										$cnilai=0;
										if ($rows1=mysql_fetch_array($rs1)){
											$cstok=$rows1['stok_after'];
											$cnilai=$rows1['ntot'];
										}
										$sql="INSERT INTO A_KARTUSTOK (OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID,fkid,tipetrans,HARGA_SATUAN,NILAI_TOTAL) VALUES ($arfdata[0],$arfdata[1],$idunit,'$tgl_terima',NOW(),'$no_terima',$cstok-$qty,$qty,0,$cstok,'IN $no_gdg - $no_terima',$iduser,$cid,1,$ch_satuan,$cnilai)";
										//echo $sql."<br>";
										$rs1=mysql_query($sql);
										//Stok Penerima
										$sql="SELECT IFNULL(COUNT(id),0) cAda FROM a_stok WHERE unit_id=$idunit AND obat_id=$arfdata[0] AND kepemilikan_id=$arfdata[1]";
										$rs1=mysql_query($sql);
										$rw1=mysql_fetch_array($rs1);
										if ($rw1["cAda"]>0){
											$sql="UPDATE a_stok SET qty_stok=$cstok,nilai=$cnilai,tgl_act=NOW() WHERE unit_id=$idunit AND obat_id=$arfdata[0] AND kepemilikan_id=$arfdata[1]";
										}else{
											$sql="INSERT INTO a_stok(unit_id,obat_id,kepemilikan_id,qty_stok,nilai,tgl_act) 
											VALUES($idunit,$arfdata[0],$arfdata[1],$cstok,$cnilai,NOW())";
										}
										$rs1=mysql_query($sql);
									}
								}else{
									$sql="update  dbapotek_tangerang.a_penerimaan set NOTERIMA='$no_terima',USER_ID_TERIMA=$iduser,TGL_TERIMA_ACT='$tgl_act',TGL_TERIMA='$tgl_terima',STATUS=1 where ID=$cid";
									//echo $sql."<br>";
									$rs1=mysql_query($sql);
									
									$sql="SELECT SQL_NO_CACHE IFNULL(SUM(t1.stok_after),0) AS stok_after,IFNULL(SUM(t1.ntot),0) AS ntot FROM (SELECT SQL_NO_CACHE UUID() AS cuid,IFNULL(QTY_STOK,0) AS stok_after,IFNULL((IF(((NILAI_PAJAK<=0) OR (TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) * 1.1)),0) AS ntot FROM a_penerimaan WHERE OBAT_ID=$arfdata[0] AND KEPEMILIKAN_ID=$arfdata[1] AND UNIT_ID_TERIMA=$idunit AND QTY_STOK>0 AND STATUS=1) AS t1";
									$rs1=mysql_query($sql);
									$cstok=0;
									$cnilai=0;
									if ($rows1=mysql_fetch_array($rs1)){
										$cstok=$rows1['stok_after'];
										$cnilai=$rows1['ntot'];
									}
									$sql="INSERT INTO A_KARTUSTOK (OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID,fkid,tipetrans,HARGA_SATUAN,NILAI_TOTAL) VALUES ($arfdata[0],$arfdata[1],$idunit,'$tgl_terima',NOW(),'$no_terima',$cstok-$qty,$qty,0,$cstok,'IN $no_gdg - $no_terima',$iduser,$cid,1,$ch_satuan,$cnilai)";
									//echo $sql."<br>";
									$rs1=mysql_query($sql);
									//Stok Penerima
									$sql="SELECT IFNULL(COUNT(id),0) cAda FROM a_stok WHERE unit_id=$idunit AND obat_id=$arfdata[0] AND kepemilikan_id=$arfdata[1]";
									$rs1=mysql_query($sql);
									$rw1=mysql_fetch_array($rs1);
									if ($rw1["cAda"]>0){
										$sql="UPDATE a_stok SET qty_stok=$cstok,nilai=$cnilai,tgl_act=NOW() WHERE unit_id=$idunit AND obat_id=$arfdata[0] AND kepemilikan_id=$arfdata[1]";
									}else{
										$sql="INSERT INTO a_stok(unit_id,obat_id,kepemilikan_id,qty_stok,nilai,tgl_act) 
										VALUES($idunit,$arfdata[0],$arfdata[1],$cstok,$cnilai,NOW())";
									}
									$rs1=mysql_query($sql);
								}
							}
						}
					}else{
						$sql="SELECT SQL_NO_CACHE *,UUID() AS cuid FROM dbapotek_tangerang.a_penerimaan WHERE NOKIRIM='$no_gdg' AND FK_MINTA_ID=$arfdata[2] AND UNIT_ID_TERIMA=$idunit AND TIPE_TRANS=1 ORDER BY ID";
						//echo $sql."<br>";
						$rs=mysql_query($sql);
						while ($rows=mysql_fetch_array($rs)){
							$qty=$rows['QTY_SATUAN'];
							$cid=$rows['ID'];
							//$pid=$rows['ID_LAMA'];
							$ch_satuan=$rows['HARGA_BELI_SATUAN'];
							$cdiskon=$rows['DISKON'];
							$ctipetrans=$rows['TIPE_TRANS'];
							$cnpajak=$rows['NILAI_PAJAK'];
							if (($cnpajak<=0) || ($ctipetrans==4) || ($ctipetrans==5) || ($ctipetrans==100)){
								$ch_satuan=$ch_satuan * (1-($cdiskon/100));
							}else{
								$ch_satuan=$ch_satuan * (1-($cdiskon/100)) * 1.1;
							}

							$sql="update  dbapotek_tangerang.a_penerimaan set NOTERIMA='$no_terima',USER_ID_TERIMA=$iduser,TGL_TERIMA_ACT='$tgl_act',TGL_TERIMA='$tgl_terima',STATUS=1 where ID=$cid";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);

							$sql="SELECT SQL_NO_CACHE IFNULL(SUM(t1.stok_after),0) AS stok_after,IFNULL(SUM(t1.ntot),0) AS ntot FROM (SELECT UUID() AS cuid,IFNULL(QTY_STOK,0) AS stok_after,IFNULL((IF(((NILAI_PAJAK<=0) OR (TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) * 1.1)),0) AS ntot FROM dbapotek_tangerang.a_penerimaan WHERE OBAT_ID=$arfdata[0] AND KEPEMILIKAN_ID=$arfdata[1] AND UNIT_ID_TERIMA=$idunit AND QTY_STOK>0 AND STATUS=1) AS t1";
							$rs1=mysql_query($sql);
							$cstok=0;
							$cnilai=0;
							if ($rows1=mysql_fetch_array($rs1)){
								$cstok=$rows1['stok_after'];
								$cnilai=$rows1['ntot'];
							}
							$sql="INSERT INTO A_KARTUSTOK (OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID,fkid,tipetrans,HARGA_SATUAN,NILAI_TOTAL) VALUES ($arfdata[0],$arfdata[1],$idunit,'$tgl_terima',NOW(),'$no_terima',$cstok-$qty,$qty,0,$cstok,'IN $no_gdg - $no_terima',$iduser,$cid,1,$ch_satuan,$cnilai)";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);
							//Stok Penerima
							$sql="SELECT IFNULL(COUNT(id),0) cAda FROM dbapotek_tangerang.a_stok WHERE unit_id=$idunit AND obat_id=$arfdata[0] AND kepemilikan_id=$arfdata[1]";
							$rs1=mysql_query($sql);
							$rw1=mysql_fetch_array($rs1);
							if ($rw1["cAda"]>0){
								$sql="UPDATE a_stok SET qty_stok=$cstok,nilai=$cnilai,tgl_act=NOW() WHERE unit_id=$idunit AND obat_id=$arfdata[0] AND kepemilikan_id=$arfdata[1]";
							}else{
								$sql="INSERT INTO a_stok(unit_id,obat_id,kepemilikan_id,qty_stok,nilai,tgl_act) 
								VALUES($idunit,$arfdata[0],$arfdata[1],$cstok,$cnilai,NOW())";
							}
							$rs1=mysql_query($sql);
						}
					}
				}
					
				if ($cfkmintaid!=""){
					$cfkmintaid=substr($cfkmintaid,0,strlen($cfkmintaid)-1);
					$sql="SELECT SQL_NO_CACHE *,UUID() AS cuid FROM dbapotek_tangerang.a_penerimaan WHERE NOKIRIM='$no_gdg' AND FK_MINTA_ID NOT IN ($cfkmintaid) AND UNIT_ID_TERIMA=$idunit AND TIPE_TRANS=1";
					//echo $sql."<br>";
					$rs=mysql_query($sql);
					while ($rows=mysql_fetch_array($rs)){
						$qty=$rows['QTY_SATUAN'];
						$cid=$rows['ID'];
						$pid=$rows['ID_LAMA'];
						$cidobat=$rows['OBAT_ID'];
						$cidkp=$rows['KEPEMILIKAN_ID'];
						$ch_satuan=$rows['HARGA_BELI_SATUAN'];
						$cdiskon=$rows['DISKON'];
						$ctipetrans=$rows['TIPE_TRANS'];
						$cnpajak=$rows['NILAI_PAJAK'];
						if (($cnpajak<=0) || ($ctipetrans==4) || ($ctipetrans==5) || ($ctipetrans==100)){
							$ch_satuan=$ch_satuan * (1-($cdiskon/100));
						}else{
							$ch_satuan=$ch_satuan * (1-($cdiskon/100)) * 1.1;
						}
						
						$sql="update  dbapotek_tangerang.a_penerimaan set NOTERIMA='$no_terima',USER_ID_TERIMA=$iduser,TGL_TERIMA_ACT='$tgl_act',TGL_TERIMA='$tgl_terima',STATUS=1,QTY_SATUAN=0,QTY_STOK=0 where ID=$cid";
						//echo $sql."<br>";
						$rs1=mysql_query($sql);
						$sql="update  dbapotek_tangerang.a_penerimaan set QTY_STOK=QTY_STOK+$qty where ID=$pid";
						//echo $sql."<br>";
						$rs1=mysql_query($sql);
						
						$sql="SELECT SQL_NO_CACHE IFNULL(SUM(t1.stok_after),0) AS stok_after,IFNULL(SUM(t1.ntot),0) AS ntot FROM (SELECT SQL_NO_CACHE UUID() AS cuid,IFNULL(QTY_STOK,0) AS stok_after,IFNULL((IF(((NILAI_PAJAK<=0) OR (TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) * 1.1)),0) AS ntot FROM a_penerimaan WHERE OBAT_ID=$cidobat AND KEPEMILIKAN_ID=$cidkp AND UNIT_ID_TERIMA=$idunit_krm AND QTY_STOK>0 AND STATUS=1) AS t1";
						//echo $sql."<br>";
						$rs1=mysql_query($sql);
						$cstok_lama=0;
						$cnilai_lama=0;
						if ($rows1=mysql_fetch_array($rs1)){
							$cstok_lama=$rows1['stok_after'];
							$cnilai_lama=$rows1['ntot'];
						}
						//Kartu Stok Pengirim
						$sql="INSERT INTO A_KARTUSTOK (OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID,fkid,tipetrans,HARGA_SATUAN,NILAI_TOTAL) VALUES ($cidobat,$cidkp,$idunit_krm,'$tgl_terima',NOW(),'$no_terima',$cstok_lama-$qty,0,-$qty,$cstok_lama,'Out(-) $no_gdg - $no_terima',$iduser,$pid,1,$ch_satuan,$cnilai_lama)";
						//echo $sql."<br>";
						$rs1=mysql_query($sql);
						//Stok Pengirim
						$sql="SELECT IFNULL(COUNT(id),0) cAda FROM a_stok WHERE unit_id=$idunit_krm AND obat_id=$cidobat AND kepemilikan_id=$cidkp";
						$rs1=mysql_query($sql);
						$rw1=mysql_fetch_array($rs1);
						if ($rw1["cAda"]>0){
							$sql="UPDATE a_stok SET qty_stok=$cstok_lama,nilai=$cnilai_lama,tgl_act=NOW() WHERE unit_id=$idunit_krm AND obat_id=$cidobat AND kepemilikan_id=$cidkp";
						}else{
							$sql="INSERT INTO a_stok(unit_id,obat_id,kepemilikan_id,qty_stok,nilai,tgl_act) 
							VALUES($idunit_krm,$cidobat,$cidkp,$cstok_lama,$cnilai_lama,NOW())";
						}
						$rs1=mysql_query($sql);
					}
				}			
			}
		}
		break;
}
//Aksi Save, Edit, Delete Berakhir ============================================
$sql="select distinct ap.NOTERIMA,date_format(am.tgl,'%d/%m/%Y') as tgl_minta,date_format(ap.TANGGAL,'%d/%m/%Y') as tgl_gdg,date_format(ap.TGL_TERIMA,'%d/%m/%Y') as tgl_terima from dbapotek_tangerang.a_penerimaan ap inner join dbapotek_tangerang.a_minta_obat am on ap.FK_MINTA_ID=am.permintaan_id where am.no_bukti='$no_minta' and ap.NOKIRIM='$no_gdg' AND ap.UNIT_ID_TERIMA=$idunit";
$rs=mysql_query($sql);
if ($rows=mysql_fetch_array($rs)){
	$tgl_minta=$rows["tgl_minta"];
	$tgl_gdg=$rows["tgl_gdg"];
	$no_terima=$rows["NOTERIMA"];
	$tgl_terima=$rows["tgl_terima"];
}
if ($isview==""){
	$sql="select NOTERIMA from dbapotek_tangerang.a_penerimaan where UNIT_ID_TERIMA=$idunit and NOTERIMA like '$kodeunit/RCV/$th[2]-$th[1]/%' order by NOTERIMA desc limit 1";
	//echo $sql."<br>";
	$rs=mysql_query($sql);
	if ($rows=mysql_fetch_array($rs)){
		$no_terima2=$rows["NOTERIMA"];
		$arno_terima=explode("/",$no_terima2);
		$tmp=$arno_terima[3]+1;
		$ctmp=$tmp;
		for ($i=0;$i<(4-strlen($tmp));$i++) $ctmp="0".$ctmp;
		$no_terima2="$kodeunit/RCV/$th[2]-$th[1]/$ctmp";
	}else{
		$no_terima2="$kodeunit/RCV/$th[2]-$th[1]/0001";
	}
}
?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<script>
	function PrintArea(listma,fileTarget){
	var winpopup=window.open(fileTarget,'winpopup','height=500,width=1000,resizable,scrollbars')
	winpopup.document.write(document.getElementById(listma).innerHTML);
	winpopup.document.write("<p class='txtinput'  style='padding-right:25px; text-align:right;'>");
	winpopup.document.write("<?php echo '<b>&raquo; Tgl Cetak:</b> '.$tglctk.' <b>- User:</b> '.$username; ?>");
	winpopup.document.write("</p>");
	winpopup.document.write("<br><br><br><br><br>");
	winpopup.document.write("<p class='txtinput'  style='padding-right:50px; text-align:right;'>");
	winpopup.document.write("<b>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</b>");
	winpopup.document.write("</p>");
	winpopup.document.close();
	winpopup.print();
	winpopup.close();
}
</script>
<?php if ($act=="save"){?>
<div align="center">
    <div id="listma" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
      
    <p align="center"><span class="jdltable">PENGIRIMAN OBAT DARI <?php echo $iunit_krm; ?></span></p>
	  
    <table width="98%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
      <tr> 
          <td width="119">No Penerimaan</td>
          
        <td width="267">: <?php echo $no_terima1; ?></td>
          <td width="107">No Permintaan</td>
          <td width="237">: <?php echo $no_minta; ?></td>
          
        <td width="78">No Kirim</td>
          <td width="171">: <?php echo $no_gdg; ?></td>
        </tr>
        <tr> 
          <td width="119">Tgl Penerimaan</td>
          
        <td>: <?php echo $tgl_terima1; ?></td>
          <td>Tgl Permintaan</td>
          <td>: <?php echo $tgl_minta; ?></td>
          
        <td>Tgl Kirim</td>
          <td>: <?php echo $tgl_gdg; ?></td>
        </tr>
        <!--tr>
			<td>Unit</td>
			<td>: <?php //echo $nunit; ?></td>
		</tr-->
      </table>
      
    <table width="99%" border="0" cellpadding="1" cellspacing="0">
      <tr class="headtable"> 
        <td width="30" height="25" class="tblheaderkiri">No</td>
        <td id="OBAT_KODE" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
          Obat</td>
        <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
          Obat</td>
        <td id="OBAT_SATUAN_KECIL" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
        <td id="NAMA" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
        <td id="qty" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty<br>
          Minta</td>
        <td id="qty_terima" width="40" class="tblheader" onClick="ifPop.CallFr(this);"> 
          Qty Terima</td>
      </tr>
      <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  //$sql="select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,am.*,date_format(am.tgl,'%d/%m/%Y') as tgl1,NAMA from a_minta_obat am inner join a_obat ao on am.obat_id=ao.OBAT_ID inner join a_kepemilikan ak on am.kepemilikan_id=ak.ID where am.unit_id=$idunit and month(am.tgl)=$bulan and year(am.tgl)=$ta".$filter." order by ".$sorting;
	  $sql="select ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ap.FK_MINTA_ID,ak.ID,ak.NAMA,am.qty,sum(am.qty_terima) as QTY_SATUAN from dbapotek_tangerang.a_penerimaan ap inner join dbapotek_tangerang.a_obat ao on ap.OBAT_ID=ao.OBAT_ID inner join dbapotek_tangerang.a_kepemilikan ak on ap.KEPEMILIKAN_ID=ak.ID inner join dbapotek_tangerang.a_minta_obat am on ap.FK_MINTA_ID=am.permintaan_id where ap.NOKIRIM='$no_gdg' AND am.no_bukti='$no_minta' AND ap.UNIT_ID_TERIMA=$idunit group by ao.OBAT_ID,ao.OBAT_KODE,ak.NAMA,ap.FK_MINTA_ID";
	  //echo $sql."<br>";
		$rs=mysql_query($sql);
/*		$jmldata=mysql_num_rows($rs);
		if ($page=="" || $page=="0") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";
		//echo $sql."<br>";
	  $rs=mysql_query($sql);
	  $i=($page-1)*$perpage;*/
	  $i=0;
	  while ($rows=mysql_fetch_array($rs)){
	  	$i++;
	  ?>
      <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
        <td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_KODE']; ?></td>
        <td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['OBAT_NAMA']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['qty']; ?></td>
        <td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['QTY_SATUAN']; ?></td>
      </tr>
      <?php 
	  }
	  mysql_free_result($rs);
	  ?>
          </table>
    </div>

	
  <p align="center">Pengiriman Obat Dari <span class="jdltable"><?php echo $iunit_krm; ?></span> 
    Dgn No Kirim : <?php echo $no_gdg; ?> Sudah Diterima</p>
	<p align="center">
	<BUTTON type="button" onClick='PrintArea("listma","#")'><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak Penerimaan&nbsp;&nbsp;</BUTTON>&nbsp;
	<BUTTON type="button" onClick="location='terima_obat.php'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Daftar 
    Penerimaan Obat &nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
	</p>
</div>
<?php }else{?>
<script>
var arrRange=depRange=[];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden"> 
</iframe>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center">
  <form name="form1" method="post" action="">
  	<input name="act" id="act" type="hidden" value="save">
	<input name="fdata" id="fdata" type="hidden" value="">
	<input name="isview" id="isview" type="hidden" value="<?php echo $isview; ?>">
	<input name="no_minta" id="no_minta" type="hidden" value="<?php echo $no_minta; ?>">
	<input name="no_gdg" id="no_gdg" type="hidden" value="<?php echo $no_gdg; ?>">
	<input name="iunit_krm" id="iunit_krm" type="hidden" value="<?php echo $iunit_krm; ?>">
    <input name="idunit_krm" id="idunit_krm" type="hidden" value="<?php echo $idunit_krm; ?>">
	<input name="ta" id="ta" type="hidden" value="<?php echo $ta; ?>">
	<input name="bulan" id="bulan" type="hidden" value="<?php echo $bulan; ?>">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
	<?php if ($isview==""){?>
    <div id="listma" style="display:block">
      <p align="center"><span class="jdltable">PENGIRIMAN OBAT DARI <?php echo $iunit_krm; ?></span></p>
	  <table width="98%" border="0" cellpadding="1" cellspacing="0" class="tabel">
        <tr> 
          <td width="119">No Penerimaan</td>
          <td width="264">: 
            <input name="no_terima" type="text" id="no_terima" size="25" maxlength="30" class="txtcenter" value="<?php echo $no_terima2; ?>" readonly="true"></td>
          <td width="107">No Permintaan</td>
          <td width="243">: <?php echo $no_minta; ?></td>
          <td width="72">No Kirim</td>
          <td width="174">: <?php echo $no_gdg; ?></td>
        </tr>
        <tr> 
          <td width="119">Tgl Penerimaan</td>
          <td>: 
            <input name="tgl_terima" type="text" id="tgl_terima" size="11" maxlength="10" readonly="true" class="txtcenter" value="<?php echo $tgl; ?>"> 
            <input type="button" name="ButtonTglExpired" value=" V " class="txtcenter" <?php echo $DisableBD; ?> onClick="gfPop.fPopCalendar(this.form.tgl_terima,depRange);" />
		  </td>
          <td>Tgl Permintaan</td>
          <td>: <?php echo $tgl_minta; ?></td>
          <td>Tgl Kirim</td>
          <td>: <?php echo $tgl_gdg; ?></td>
        </tr>
        <!--tr>
			<td>Unit</td>
			<td>: <?php //echo $nunit; ?></td>
		</tr-->
      </table>
      <table width="99%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            Obat</td>
          <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Obat</td>
          <td id="OBAT_SATUAN_KECIL" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
          <td id="NAMA" width="80" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="qty" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty<br>
            Minta</td>
          <td id="qty_terima" width="40" class="tblheader" onClick="ifPop.CallFr(this);"> 
            Qty Kirim</td>
          <td id="qty_terima" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty 
            Terima </td>
          <td class="tblheader" width="30"><input name="chkall" id="chkall" type="checkbox" value="" title="Pilih Semua" style="cursor:pointer" onClick="fCheckAll(chkall,chkitem)"<?php if ($isview=="true") echo " disabled"; ?>></td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  $sql="select ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ap.FK_MINTA_ID,ak.ID,ak.NAMA,am.qty,sum(ap.QTY_SATUAN) as QTY_SATUAN from dbapotek_tangerang.a_penerimaan ap inner join dbapotek_tangerang.a_obat ao on ap.OBAT_ID=ao.OBAT_ID inner join dbapotek_tangerang.a_kepemilikan ak on ap.KEPEMILIKAN_ID=ak.ID inner join dbapotek_tangerang.a_minta_obat am on ap.FK_MINTA_ID=am.permintaan_id where ap.NOKIRIM='$no_gdg' AND am.no_bukti='$no_minta' AND ap.UNIT_ID_TERIMA=$idunit group by ao.OBAT_ID,ao.OBAT_KODE,ak.NAMA,ap.FK_MINTA_ID";
	  //echo $sql."<br>";
		$rs=mysql_query($sql);
/*		$jmldata=mysql_num_rows($rs);
		if ($page=="" || $page=="0") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";
		//echo $sql."<br>";
	  $rs=mysql_query($sql);
	  $i=($page-1)*$perpage;*/
	  $i=0;
	  while ($rows=mysql_fetch_array($rs)){
	  	$i++;
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['qty']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['QTY_SATUAN']; ?></td>
          <td width="40" align="center" class="tdisi"> 
            <input name="qty_terima" type="text" size="5" maxlength="5" class="txtcenter" value="<?php echo $rows['QTY_SATUAN']; ?>"></td>
          <td width="30" class="tdisi"><input name="chkitem" id="chkitem" type="checkbox" value="<?php echo $rows['OBAT_ID'].'|'.$rows['ID'].'|'.$rows['FK_MINTA_ID'].'|'.$no_gdg.'|'.$rows['QTY_SATUAN']; ?>" style="cursor:pointer"<?php if ($isview=="true") echo " disabled"; ?>></td>
        </tr>
        <?php 
	  }
	  mysql_free_result($rs);
	  ?>
        <!--tr> 
          <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php //echo ($totpage==0?"0":$page); ?> dari <?php //echo $totpage; ?></div></td>
          <td colspan="6" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php //echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php //echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php //echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;          </td>
        </tr-->
      </table>
    </div>
		<p align="center">
            <BUTTON id="btnSimpan" type="button" onClick="if (ValidateForm('no_terima','ind')){fSubmit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Terima&nbsp;&nbsp;</BUTTON>
            &nbsp;<BUTTON type="reset" onClick="location='terima_obat.php'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
    </p>
		<?php }else{?>
	<div id="listma" style="display:block">
		  
      <p align="center"><span class="jdltable">PENGIRIMAN OBAT DARI <?php echo $iunit_krm; ?></span></p>
		  
      <table width="98%" border="0" cellpadding="1" cellspacing="0" class="tabel">
        <tr> 
			  <td width="123">No Penerimaan</td>
			  
			<td width="202">: <?php echo $no_terima; ?></td>
			  <td width="136">No Permintaan</td>
			  <td width="271">: <?php echo $no_minta; ?></td>
			  
          <td width="76">No Kirim</td>
			  <td width="171">: <?php echo $no_gdg; ?></td>
			</tr>
			<tr> 
			  <td width="123">Tgl Penerimaan</td>
			  
			<td>: <?php echo $tgl_terima; ?></td>
			  <td>Tgl Permintaan</td>
			  <td>: <?php echo $tgl_minta; ?></td>
			  
          <td>Tgl Kirim</td>
			  <td>: <?php echo $tgl_gdg; ?></td>
			</tr>
			<!--tr>
				<td>Unit</td>
				<td>: <?php //echo $nunit; ?></td>
			</tr-->
	  </table>
		  
		<table width="99%" border="0" cellpadding="1" cellspacing="0">
		  <tr class="headtable"> 
			<td width="30" height="25" class="tblheaderkiri">No</td>
			<td id="OBAT_KODE" width="71" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
			  Obat</td>
			<td width="200" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Nama 
			  Obat</td>
			<td id="OBAT_SATUAN_KECIL" width="103" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
			<td id="NAMA" width="153" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
			<td id="qty" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty<br>
		    Minta</td>
			<td id="qty_terima" width="57" class="tblheader" onClick="ifPop.CallFr(this);"> 
			  Qty Terima</td>
		  </tr>
		  <?php 
		  if ($filter!=""){
			$filter=explode("|",$filter);
			$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
		  }
		  if ($sorting=="") $sorting=$defaultsort;
		  //$sql="select ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,am.*,date_format(am.tgl,'%d/%m/%Y') as tgl1,NAMA from a_minta_obat am inner join a_obat ao on am.obat_id=ao.OBAT_ID inner join a_kepemilikan ak on am.kepemilikan_id=ak.ID where am.unit_id=$idunit and month(am.tgl)=$bulan and year(am.tgl)=$ta".$filter." order by ".$sorting;
		  $sql="select ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ap.FK_MINTA_ID,ak.ID,ak.NAMA,am.qty,sum(ap.QTY_SATUAN) as QTY_SATUAN from dbapotek_tangerang.a_penerimaan ap inner join dbapotek_tangerang.a_obat ao on ap.OBAT_ID=ao.OBAT_ID inner join dbapotek_tangerang.a_kepemilikan ak on ap.KEPEMILIKAN_ID=ak.ID inner join dbapotek_tangerang.a_minta_obat am on ap.FK_MINTA_ID=am.permintaan_id where ap.NOKIRIM='$no_gdg' AND am.no_bukti='$no_minta' AND ap.UNIT_ID_TERIMA=$idunit group by ao.OBAT_ID,ao.OBAT_KODE,ak.NAMA,ap.FK_MINTA_ID";
		  //echo $sql."<br>";
			$rs=mysql_query($sql);
/*			$jmldata=mysql_num_rows($rs);
			if ($page=="" || $page=="0") $page="1";
			$perpage=50;$tpage=($page-1)*$perpage;
			if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
			if ($page>1) $bpage=$page-1; else $bpage=1;
			if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
			$sql=$sql." limit $tpage,$perpage";
			//echo $sql."<br>";
		  $rs=mysql_query($sql);
		  $i=($page-1)*$perpage;*/
		  $i=0;
	//	  $arfvalue="";
		  while ($rows=mysql_fetch_array($rs)){
			$i++;
	/*		$arfvalue="act*-*edit*|*stok1*-*".$rows['QTY_STOK']."*|*obat_id*-*".$rows['OBAT_ID']."*|*kepemilikan_id*-*".$rows['KEPEMILIKAN_ID']."*|*stok*-*".$rows['QTY_STOK'];
			
			 $arfvalue=str_replace('"',chr(3),$arfvalue);
			 $arfvalue=str_replace("'",chr(5),$arfvalue);
			 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
			
			$arfhapus="act*-*delete*|*minta_id*-*".$rows['permintaan_id'];
	*/
		  ?>
		  <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
			<td class="tdisikiri"><?php echo $i; ?></td>
			<td class="tdisi" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
			<td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
			<td class="tdisi" align="center"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
			<td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
			<td class="tdisi" align="center"><?php echo $rows['qty']; ?></td>
			<td class="tdisi" align="center"><?php echo $rows['QTY_SATUAN']; ?></td>
		  </tr>
		  <?php 
		  }
		  mysql_free_result($rs);
		  ?>
	  </table>
    </div>
	<div id="cetak" style="display:none">
	<link rel="stylesheet" href="../theme/print.css" type="text/css" />
		  
      <p align="center"><span class="jdltable">PENGIRIMAN OBAT DARI <?php echo $iunit_krm; ?></span></p>
		  
      <table width="98%" border="0" cellpadding="1" cellspacing="0" class="txtinput">
        <tr> 
			  <td width="123">No Penerimaan</td>
			  
			<td width="202">: <?php echo $no_terima; ?></td>
			  <td width="136">No Permintaan</td>
			  <td width="272">: <?php echo $no_minta; ?></td>
			  
          <td width="75">No Kirim</td>
			  <td width="171">: <?php echo $no_gdg; ?></td>
			</tr>
			<tr> 
			  <td width="123">Tgl Penerimaan</td>
			  
			<td>: <?php echo $tgl_terima; ?></td>
			  <td>Tgl Permintaan</td>
			  <td>: <?php echo $tgl_minta; ?></td>
			  
          <td>Tgl Kirim</td>
			  <td>: <?php echo $tgl_gdg; ?></td>
			</tr>
			<!--tr>
				<td>Unit</td>
				<td>: <?php //echo $nunit; ?></td>
			</tr-->
	  </table>
		  
		<table width="99%" border="0" cellpadding="1" cellspacing="0">
		  <tr class="headtable"> 
			<td width="30" height="25" class="tblheaderkiri">No</td>
			<td id="OBAT_KODE" width="71" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
			  Obat</td>
			<td width="200" class="tblheader" id="OBAT_NAMA" onClick="ifPop.CallFr(this);">Nama 
			  Obat</td>
			<td id="OBAT_SATUAN_KECIL" width="103" class="tblheader" onClick="ifPop.CallFr(this);">Satuan</td>
			<td id="NAMA" width="153" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
			<td id="qty" width="40" class="tblheader" onClick="ifPop.CallFr(this);">Qty<br>
		    Minta</td>
			<td id="qty_terima" width="57" class="tblheader" onClick="ifPop.CallFr(this);"> 
			  Qty Terima</td>
		  </tr>
		  <?php 
		  $sql="select ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ap.FK_MINTA_ID,ak.ID,ak.NAMA,am.qty,sum(ap.QTY_SATUAN) as QTY_SATUAN from a_penerimaan ap inner join a_obat ao on ap.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on ap.KEPEMILIKAN_ID=ak.ID inner join a_minta_obat am on ap.FK_MINTA_ID=am.permintaan_id where ap.NOKIRIM='$no_gdg' AND ap.UNIT_ID_TERIMA=$idunit group by ao.OBAT_ID,ao.OBAT_KODE,ak.NAMA,ap.FK_MINTA_ID";
		  //echo $sql."<br>";
		  $rs=mysql_query($sql);
	//	  $arfvalue="";
		  $i=0;
		  while ($rows=mysql_fetch_array($rs)){
			$i++;
	/*		$arfvalue="act*-*edit*|*stok1*-*".$rows['QTY_STOK']."*|*obat_id*-*".$rows['OBAT_ID']."*|*kepemilikan_id*-*".$rows['KEPEMILIKAN_ID']."*|*stok*-*".$rows['QTY_STOK'];
			
			 $arfvalue=str_replace('"',chr(3),$arfvalue);
			 $arfvalue=str_replace("'",chr(5),$arfvalue);
			 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
			
			$arfhapus="act*-*delete*|*minta_id*-*".$rows['permintaan_id'];
	*/
		  ?>
		  <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
			<td class="tdisikiri" align="center" style="font-size:12px;"><?php echo $i; ?></td>
			<td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_KODE']; ?></td>
			<td class="tdisi" align="left" style="font-size:12px;"><?php echo $rows['OBAT_NAMA']; ?></td>
			<td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
			<td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['NAMA']; ?></td>
			<td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['qty']; ?></td>
			<td class="tdisi" align="center" style="font-size:12px;"><?php echo $rows['QTY_SATUAN']; ?></td>
		  </tr>
		  <?php 
		  }
		  mysql_free_result($rs);
		  ?>
	  </table>
    </div>
<!--table width="778" border="0">
		  <tr> 
			<td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
				<?php //echo ($totpage==0?"0":$page); ?> dari <?php //echo $totpage; ?></div></td>
			<td colspan="4" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
			  <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php //echo $bpage; ?>';document.form1.submit();"> 
			  <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php //echo $npage; ?>';document.form1.submit();"> 
			  <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php //echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
			</td>
		  </tr>
</table-->


		<p align="center">
            <BUTTON type="button" onClick='PrintArea("cetak","#")'><IMG SRC="../icon/printer.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;&nbsp;Cetak Penerimaan&nbsp;&nbsp;</BUTTON>
            &nbsp;<BUTTON type="button" onClick="location='terima_obat.php'"><IMG SRC="../icon/back.png" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Kembali&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
    </p>
		<?php }?>
</form>
</div>
<?php 
}
?>
</body>
<script>
function fSubmit(){
var cdata='';
var x;
	if (document.form1.chkitem.length){
		for (var i=0;i<document.form1.chkitem.length;i++){
			if (document.form1.chkitem[i].checked==true){
				x=document.form1.chkitem[i].value.split('|');
				if ((x[4]*1)<(document.form1.qty_terima[i].value*1)){
					alert("Qty Terima Tidak Boleh Lebih Dari Qty Kirim, Kelebihan Obat/Alkes Harus Dikembalikan Ke Gudang");
					return false;
				}
				cdata +=document.form1.chkitem[i].value+'|'+document.form1.qty_terima[i].value+'**';
			}
		}
		if (cdata!=""){
			cdata=cdata.substr(0,cdata.length-2);
		}else{
			alert("Pilih Item Obat Yg Mau Diterima Terlebih Dahulu !");
			return false;
		}
	}else{
		if (document.form1.chkitem.checked==false){
			alert("Pilih Item Obat Yg Mau Diterima Terlebih Dahulu !");
			return false;
		}
		x=document.form1.chkitem.value.split('|');
		if ((x[4]*1)<(document.form1.qty_terima.value*1)){
			alert("Qty Terima Tidak Boleh Lebih Dari Qty Kirim, Kelebihan Obat/Alkes Harus Dikembalikan Ke Gudang");
			return false;
		}
		cdata +=document.form1.chkitem.value+'|'+document.form1.qty_terima.value;
	}
	//alert(cdata);
	document.form1.fdata.value=cdata;
	document.getElementById('btnSimpan').disabled=true;
	document.form1.submit();
}
</script>
</html>
<?php 
mysql_close($konek);
?>