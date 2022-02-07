<?php 
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="kode";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$tmpLay = $_REQUEST['tmpLay'];
$bulan = $_REQUEST['bulan'];
$tahun = $_REQUEST['tahun'];
$uni = "select UNIT_ID from $dbapotek.a_unit where kdunitfar='$tmpLay'";
$k = mysql_query($uni);
$dunit = mysql_fetch_array($k);

$idunit=$dunit['UNIT_ID'];
$iduser=$_REQUEST['iduser'];
$obat_id=$_REQUEST['obat_id'];
$kepemilikan_id=$_REQUEST['kepemilikan_id'];
$stok=$_REQUEST['stok'];
$sdh_so=$_REQUEST['sdh_so'];
$act=$_REQUEST['act'];

switch ($act){
	case "edit":
			$sql="select SQL_NO_CACHE UUID() AS cuid,ifnull(sum(QTY_STOK),0) as qty_stok from $dbapotek.a_penerimaan where OBAT_ID=$obat_id and UNIT_ID_TERIMA=$idunit and KEPEMILIKAN_ID=$kepemilikan_id and QTY_STOK>0 and STATUS=1";
			$rs=mysql_query($sql);
			$cstok=0;
			if ($rows=mysql_fetch_array($rs)){
				$cstok=$rows['qty_stok'];
			}
			if ($sdh_so=="1"){
				//echo "sdfdsf";
				if ($cstok>$stok){
					$selisih=$cstok-$stok;
					$sql="update a_stok_opname set opname=opname-$selisih,adjust=adjust-$selisih where idunit=$idunit and idobat=$obat_id and kepemilikan_id=$kepemilikan_id and month(tgl)=$bulan and year(tgl)=$tahun";
					//echo $sql."<br>";
					$rs=mysql_query($sql);
					$sql="select * from a_stok_opname where idunit=$idunit and idobat=$obat_id and kepemilikan_id=$kepemilikan_id and month(tgl)=$bulan and year(tgl)=$tahun limit 1";
					//echo $sql."<br>";
					$rs=mysql_query($sql);
					if ($rows=mysql_fetch_array($rs)){
						$cstk=$rows['stok'];
						$cop=$rows['opname'];
						$cadj=$rows['adjust'];
					}
					$sql="select SQL_NO_CACHE *,UUID() AS cuid from a_penerimaan where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id and UNIT_ID_TERIMA=$idunit and QTY_STOK>0 and STATUS=1 order by HARGA_BELI_SATUAN";
					//echo $sql."<br>";
					$rs=mysql_query($sql);
					$ok="false";
					while (($rows=mysql_fetch_array($rs)) && ($ok=="false")){
						$qty=$rows["QTY_STOK"];
						$cid=$rows["ID"];
						$charga=$rows["HARGA_BELI_SATUAN"];
						$ch_satuan=$rows['HARGA_BELI_SATUAN'];
						$cdiskon=$rows['DISKON'];
						$ctipetrans=$rows['TIPE_TRANS'];
						$cnpajak=$rows['NILAI_PAJAK'];
						if (($cnpajak<=0) || ($ctipetrans==4) || ($ctipetrans==5) || ($ctipetrans==100)){
							$ch_satuan=$ch_satuan * (1-($cdiskon/100));
						}else{
							$ch_satuan=$ch_satuan * (1-($cdiskon/100)) * 1.1;
						}

						if ($qty>=$selisih){
							$ok="true";
							$qty_trans=0-$selisih;
							$sql="update a_penerimaan set QTY_STOK=QTY_STOK-$selisih where ID=$cid";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);					
							$sql="SELECT SQL_NO_CACHE IFNULL(SUM(t1.stok_after),0) AS jml,IFNULL(SUM(t1.ntot),0) AS ntot FROM (SELECT SQL_NO_CACHE UUID() AS cuid,IFNULL(QTY_STOK,0) AS stok_after,IFNULL((IF(((NILAI_PAJAK<=0) OR (TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) * 1.1)),0) AS ntot FROM a_penerimaan WHERE OBAT_ID=$obat_id AND KEPEMILIKAN_ID=$kepemilikan_id AND UNIT_ID_TERIMA=$idunit AND QTY_STOK>0 AND STATUS=1) AS t1";
							$rs1=mysql_query($sql);
							$cstk_after=0;
							$cnilai=0;
							if ($rows1=mysql_fetch_array($rs1)){
								$cstk_after=$rows1['jml'];
								$cnilai=$rows1['ntot'];
							}
							$cstk_bfr=$cstk_after+$selisih;
							$sql="insert into a_kartustok(OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID,fkid,tipetrans,HARGA_SATUAN,NILAI_TOTAL) values($obat_id,$kepemilikan_id,$idunit,CURDATE(),NOW(),'',$cstk_bfr,-$selisih,0,$cstk_after,'Stok Opname',$iduser,$cid,5,$ch_satuan,$cnilai)";
							//echo $sql;
							$rs1=mysql_query($sql);
						}else{
							$selisih=$selisih-$qty;
							$qty_trans=0-$qty;
							if ($selisih==0) $ok="true";
							$sql="update a_penerimaan set QTY_STOK=0 where ID=$cid";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);										
							$sql="SELECT SQL_NO_CACHE IFNULL(SUM(t1.stok_after),0) AS jml,IFNULL(SUM(t1.ntot),0) AS ntot FROM (SELECT SQL_NO_CACHE UUID() AS cuid,IFNULL(QTY_STOK,0) AS stok_after,IFNULL((IF(((NILAI_PAJAK<=0) OR (TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) * 1.1)),0) AS ntot FROM a_penerimaan WHERE OBAT_ID=$obat_id AND KEPEMILIKAN_ID=$kepemilikan_id AND UNIT_ID_TERIMA=$idunit AND QTY_STOK>0 AND STATUS=1) AS t1";
							$rs1=mysql_query($sql);
							$cstk_after=0;
							$cnilai=0;
							if ($rows1=mysql_fetch_array($rs1)){
								$cstk_after=$rows1['jml'];
								$cnilai=$rows1['ntot'];
							}
							$cstk_bfr=$cstk_after+$qty;
							$sql="insert into a_kartustok(OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID,fkid,tipetrans,HARGA_SATUAN,NILAI_TOTAL) values($obat_id,$kepemilikan_id,$idunit,CURDATE(),NOW(),'',$cstk_bfr,-$qty,0,$cstk_after,'Stok Opname',$iduser,$cid,5,$ch_satuan,$cnilai)";
							//echo $sql;
							$rs1=mysql_query($sql);
						}
					}
				}else{
					//echo "asdasd";
					$selisih=$stok-$cstok;
					if ($selisih>0){
						$sql="update $dbapotek.a_stok_opname set opname=opname+$selisih,adjust=adjust+$selisih where idunit=$idunit and idobat=$obat_id and kepemilikan_id=$kepemilikan_id and month(tgl)=$bulan and year(tgl)=$tahun";
						//echo $sql."<br>";
						$rs1=mysql_query($sql);
						$sql="select * from $dbapotek.a_stok_opname where idunit=$idunit and idobat=$obat_id and kepemilikan_id=$kepemilikan_id and month(tgl)=$bulan and year(tgl)=$tahun order by opname_id desc";
						//echo $sql."<br>";
						$rs=mysql_query($sql);
						$ok="false";
						while (($rows=mysql_fetch_array($rs)) && ($ok=="false")){
							$cid=$rows['opname_id'];
							$cidp=$rows['idpenerimaan'];
							$sql="select * from $dbapotek.a_penerimaan where ID=$cidp";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);
							$ch_satuan=0;
							if ($rows1=mysql_fetch_array($rs1)){
								$ch_satuan=$rows1['HARGA_BELI_SATUAN'];
								$cdiskon=$rows1['DISKON'];
								$ctipetrans=$rows1['TIPE_TRANS'];
								$cnpajak=$rows1['NILAI_PAJAK'];
								if (($cnpajak<=0) || ($ctipetrans==4) || ($ctipetrans==5) || ($ctipetrans==100)){
									$ch_satuan=$ch_satuan * (1-($cdiskon/100));
								}else{
									$ch_satuan=$ch_satuan * (1-($cdiskon/100)) * 1.1;
								}
							}
							
							$cqty=$rows['qty'];
							if ($cqty>=0){
								if ($cidp==0){
									$ok="true";
									$sql="insert into $dbapotek.a_penerimaan(OBAT_ID,UNIT_ID_TERIMA,KEPEMILIKAN_ID,USER_ID_KIRIM,TANGGAL_ACT,TANGGAL,QTY_SATUAN,QTY_STOK,HARGA_BELI_SATUAN,TIPE_TRANS,STATUS) values($obat_id,$idunit,$kepemilikan_id,$iduser,NOW(),CURDATE(),$selisih,$selisih,'$hargab',5,1)";
									//echo $sql."<br>";
									$rs1=mysql_query($sql);
									$sql="select ID,UUID() AS cuid from $dbapotek.a_penerimaan where UNIT_ID_TERIMA=$idunit and USER_ID_KIRIM=$iduser and TANGGAL=CURDATE() order by ID desc limit 1";
									//echo $sql."<br>";
									$rs1=mysql_query($sql);
									$cidp=0;
									if ($rows1=mysql_fetch_array($rs1)){
										$cidp=$rows1['ID'];
									}
									$sql="update $dbapotek.a_stok_opname set idpenerimaan=$cidp,qty=qty+$selisih where opname_id=$cid";
									//echo $sql."<br>";
									$rs1=mysql_query($sql);
									$sql="SELECT SQL_NO_CACHE IFNULL(SUM(t1.stok_after),0) AS jml,IFNULL(SUM(t1.ntot),0) AS ntot FROM (SELECT SQL_NO_CACHE UUID() AS cuid,IFNULL(QTY_STOK,0) AS stok_after,IFNULL((IF(((NILAI_PAJAK<=0) OR (TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) * 1.1)),0) AS ntot FROM $dbapotek.a_penerimaan WHERE OBAT_ID=$obat_id AND KEPEMILIKAN_ID=$kepemilikan_id AND UNIT_ID_TERIMA=$idunit AND QTY_STOK>0 AND STATUS=1) AS t1";
									$rs1=mysql_query($sql);
									$cstk_after=0;
									$cnilai=0;
									if ($rows1=mysql_fetch_array($rs1)){
										$cstk_after=$rows1['jml'];
										$cnilai=$rows1['ntot'];
									}
									$cstk_bfr=$cstk_after-$selisih;
									$sql="insert into $dbapotek.a_kartustok(OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID,fkid,tipetrans,HARGA_SATUAN,NILAI_TOTAL) values($obat_id,$kepemilikan_id,$idunit,CURDATE(),NOW(),'',$cstk_bfr,$selisih,0,$cstk_after,'Stok Opname',$iduser,$cidp,5,'$hargab','$cnilai')";
									//echo $sql;
									$rs1=mysql_query($sql);
								}else{
									$ok="true";
									$sql="update $dbapotek.a_penerimaan set QTY_SATUAN=QTY_SATUAN+$selisih,QTY_STOK=QTY_STOK+$selisih where ID=$cidp";
									//echo $sql."<br>";
									$rs1=mysql_query($sql);
									$sql="update $dbapotek.a_stok_opname set qty=qty+$selisih where opname_id=$cid";
									//echo $sql."<br>";
									$rs1=mysql_query($sql);
									$sql="SELECT SQL_NO_CACHE IFNULL(SUM(t1.stok_after),0) AS jml,IFNULL(SUM(t1.ntot),0) AS ntot FROM (SELECT SQL_NO_CACHE UUID() AS cuid,IFNULL(QTY_STOK,0) AS stok_after,IFNULL((IF(((NILAI_PAJAK<=0) OR (TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) * 1.1)),0) AS ntot FROM $dbapotek.a_penerimaan WHERE OBAT_ID=$obat_id AND KEPEMILIKAN_ID=$kepemilikan_id AND UNIT_ID_TERIMA=$idunit AND QTY_STOK>0 AND STATUS=1) AS t1";
									$rs1=mysql_query($sql);
									$cstk_after=0;
									$cnilai=0;
									if ($rows1=mysql_fetch_array($rs1)){
										$cstk_after=$rows1['jml'];
										$cnilai=$rows1['ntot'];
									}
									$cstk_bfr=$cstk_after-$selisih;
									$sql="insert into $dbapotek.a_kartustok(OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID,fkid,tipetrans,HARGA_SATUAN,NILAI_TOTAL) values($obat_id,$kepemilikan_id,$idunit,CURDATE(),NOW(),'',$cstk_bfr,$selisih,0,$cstk_after,'Stok Opname',$iduser,$cidp,5,'$ch_satuan',$cnilai)";
									//echo $sql;
									$rs1=mysql_query($sql);
								}
							}else{
								$ok="true";
								$jml=$selisih;
								$sql="update $dbapotek.a_stok_opname set qty=qty+$jml where opname_id=$cid";
								//echo $sql."<br>";
								$rs1=mysql_query($sql);
								$sql="update $dbapotek.a_penerimaan set QTY_STOK=QTY_STOK+$jml where ID=$cidp";
								//echo $sql."<br>";
								$rs1=mysql_query($sql);
								$sql="SELECT SQL_NO_CACHE IFNULL(SUM(t1.stok_after),0) AS jml,IFNULL(SUM(t1.ntot),0) AS ntot FROM (SELECT SQL_NO_CACHE UUID() AS cuid,IFNULL(QTY_STOK,0) AS stok_after,IFNULL((IF(((NILAI_PAJAK<=0) OR (TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) * 1.1)),0) AS ntot FROM $dbapotek.a_penerimaan WHERE OBAT_ID=$obat_id AND KEPEMILIKAN_ID=$kepemilikan_id AND UNIT_ID_TERIMA=$idunit AND QTY_STOK>0 AND STATUS=1) AS t1";
								$rs1=mysql_query($sql);
								$cstk_after=0;
								$cnilai=0;
								if ($rows1=mysql_fetch_array($rs1)){
									$cstk_after=$rows1['jml'];
									$cnilai=$rows1['ntot'];
								}
								$cstk_bfr=$cstk_after-$jml;
								$sql="insert into $dbapotek.a_kartustok(OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID,fkid,tipetrans,HARGA_SATUAN,NILAI_TOTAL) values($obat_id,$kepemilikan_id,$idunit,CURDATE(),NOW(),'',$cstk_bfr,$jml,0,$cstk_after,'Stok Opname',$iduser,$cidp,5,'$ch_satuan',$cnilai)";
								//echo $sql;
								$rs1=mysql_query($sql);
							}
						}
					}
				}
			}else{
				if ($cstok>$stok){
					$selisih=$cstok-$stok;
					$sql="select SQL_NO_CACHE *,UUID() AS cuid from $dbapotek.a_penerimaan where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id and UNIT_ID_TERIMA=$idunit and QTY_STOK>0 and STATUS=1 order by HARGA_BELI_SATUAN";
					//echo $sql."<br>";
					$rs=mysql_query($sql);
					$ok="false";
					while (($rows=mysql_fetch_array($rs)) && ($ok=="false")){
						$qty=$rows["QTY_STOK"];
						$cid=$rows["ID"];
						$charga=$rows["HARGA_BELI_SATUAN"];
						$ch_satuan=$rows['HARGA_BELI_SATUAN'];
						$cdiskon=$rows['DISKON'];
						$ctipetrans=$rows['TIPE_TRANS'];
						$cnpajak=$rows['NILAI_PAJAK'];
						if (($cnpajak<=0) || ($ctipetrans==4) || ($ctipetrans==5) || ($ctipetrans==100)){
							$ch_satuan=$ch_satuan * (1-($cdiskon/100));
						}else{
							$ch_satuan=$ch_satuan * (1-($cdiskon/100)) * 1.1;
						}

						if ($qty>=$selisih){
							$ok="true";
							$qty_trans=0-$selisih;
							$sql="update $dbapotek.a_penerimaan set QTY_STOK=QTY_STOK-$selisih where ID=$cid";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);					
							$sql="SELECT SQL_NO_CACHE IFNULL(SUM(t1.stok_after),0) AS jml,IFNULL(SUM(t1.ntot),0) AS ntot FROM (SELECT SQL_NO_CACHE UUID() AS cuid,IFNULL(QTY_STOK,0) AS stok_after,IFNULL((IF(((NILAI_PAJAK<=0) OR (TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) * 1.1)),0) AS ntot FROM $dbapotek.a_penerimaan WHERE OBAT_ID=$obat_id AND KEPEMILIKAN_ID=$kepemilikan_id AND UNIT_ID_TERIMA=$idunit AND QTY_STOK>0 AND STATUS=1) AS t1";
							$rs1=mysql_query($sql);
							$cstk_after=0;
							$cnilai=0;
							if ($rows1=mysql_fetch_array($rs1)){
								$cstk_after=$rows1['jml'];
								$cnilai=$rows1['ntot'];
							}
							$cstk_bfr=$cstk_after+$selisih;
							$sql="insert into $dbapotek.a_kartustok(OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID,fkid,tipetrans,HARGA_SATUAN,NILAI_TOTAL) values($obat_id,$kepemilikan_id,$idunit,CURDATE(),NOW(),'','$cstk_bfr',-$selisih,0,$cstk_after,'Stok Opname',$iduser,$cid,5,'$ch_satuan','$cnilai')";
							//echo $sql;
							$rs1=mysql_query($sql);
						}else{
							$selisih=$selisih-$qty;
							$qty_trans=0-$qty;
							if ($selisih==0) $ok="true";
							$sql="update $dbapotek.a_penerimaan set QTY_STOK=0 where ID=$cid";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);										
							$sql="SELECT SQL_NO_CACHE IFNULL(SUM(t1.stok_after),0) AS jml,IFNULL(SUM(t1.ntot),0) AS ntot FROM (SELECT SQL_NO_CACHE UUID() AS cuid,IFNULL(QTY_STOK,0) AS stok_after,IFNULL((IF(((NILAI_PAJAK<=0) OR (TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) * 1.1)),0) AS ntot FROM $dbapotek.a_penerimaan WHERE OBAT_ID=$obat_id AND KEPEMILIKAN_ID=$kepemilikan_id AND UNIT_ID_TERIMA=$idunit AND QTY_STOK>0 AND STATUS=1) AS t1";
							$rs1=mysql_query($sql);
							$cstk_after=0;
							$cnilai=0;
							if ($rows1=mysql_fetch_array($rs1)){
								$cstk_after=$rows1['jml'];
								$cnilai=$rows1['ntot'];
							}
							$cstk_bfr=$cstk_after+$qty;
							$sql="insert into $dbapotek.a_kartustok(OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID,fkid,tipetrans,HARGA_SATUAN,NILAI_TOTAL) values($obat_id,$kepemilikan_id,$idunit,CURDATE(),NOW(),'',$cstk_bfr,-$qty,0,$cstk_after,'Stok Opname',$iduser,$cid,5,'$ch_satuan','$cnilai')";
							//echo $sql;
							$rs1=mysql_query($sql);
						}
						$sql="insert into $dbapotek.a_stok_opname(idunit,iduser,idpenerimaan,idobat,kepemilikan_id,stok,opname,adjust,qty,harga_satuan,tgl,tgl_act) values($idunit,$iduser,$cid,$obat_id,$kepemilikan_id,$cstok,$stok,$stok-$cstok,$qty_trans,'$ch_satuan',now(),now())";
						//echo $sql."<br>";
						$rs1=mysql_query($sql);
					}
				}else{
					$selisih=$stok-$cstok;
					//echo "asdasdasdas";
					if ($selisih>0){
						//if ($hargab==0){
							/*echo "<script>alert('Obat Tersebut Belum Ada Harganya');</script>";*/
						//}else{
							$sql="insert into $dbapotek.a_penerimaan(OBAT_ID,UNIT_ID_TERIMA,KEPEMILIKAN_ID,USER_ID_KIRIM,TANGGAL_ACT,TANGGAL,QTY_SATUAN,QTY_STOK,HARGA_BELI_SATUAN,TIPE_TRANS,STATUS) values($obat_id,$idunit,$kepemilikan_id,$iduser,NOW(),CURDATE(),$selisih,$selisih,'$hargab',5,1)";
							//echo $sql."<br>";
							$rs=mysql_query($sql);
							$sql="select ID,UUID() AS cuid from $dbapotek.a_penerimaan where UNIT_ID_TERIMA=$idunit and USER_ID_KIRIM=$iduser and TANGGAL=CURDATE() order by ID desc limit 1";
							//echo $sql."<br>";
							$rs=mysql_query($sql);
							if ($rows=mysql_fetch_array($rs)){
								$cid=$rows['ID'];
								$sql="insert into $dbapotek.a_stok_opname(idunit,iduser,idpenerimaan,idobat,kepemilikan_id,stok,opname,adjust,qty,harga_satuan,tgl,tgl_act) values($idunit,$iduser,$cid,$obat_id,$kepemilikan_id,$cstok,$stok,$stok-$cstok,$selisih,'$hargab',CURDATE(),NOW())";
								//echo $sql."<br>";
								$rs1=mysql_query($sql);
								
								$sql="SELECT SQL_NO_CACHE IFNULL(SUM(t1.stok_after),0) AS jml,IFNULL(SUM(t1.ntot),0) AS ntot FROM (SELECT SQL_NO_CACHE UUID() AS cuid,IFNULL(QTY_STOK,0) AS stok_after,IFNULL((IF(((NILAI_PAJAK<=0) OR (TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) * 1.1)),0) AS ntot FROM $dbapotek.a_penerimaan WHERE OBAT_ID=$obat_id AND KEPEMILIKAN_ID=$kepemilikan_id AND UNIT_ID_TERIMA=$idunit AND QTY_STOK>0 AND STATUS=1) AS t1";
								$rs1=mysql_query($sql);
								$cstk_after=0;
								$cnilai=0;
								if ($rows1=mysql_fetch_array($rs1)){
									$cstk_after=$rows1['jml'];
									$cnilai=$rows1['ntot'];
								}
								$cstk_bfr=$cstk_after-$selisih;
								$sql="insert into $dbapotek.a_kartustok(OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID,fkid,tipetrans,HARGA_SATUAN,NILAI_TOTAL) values($obat_id,$kepemilikan_id,$idunit,CURDATE(),NOW(),'',$cstk_bfr,$selisih,0,$cstk_after,'Stok Opname',$iduser,$cid,5,'$hargab','$cnilai')";
								//echo $sql;
								$rs1=mysql_query($sql);
							}
						//}
					}else{
						$sql="insert into $dbapotek.a_stok_opname(idunit,iduser,idpenerimaan,idobat,kepemilikan_id,stok,opname,adjust,qty,harga_satuan,tgl,tgl_act) values($idunit,$iduser,0,$obat_id,$kepemilikan_id,$cstok,$stok,$selisih,$selisih,'$hargab',CURDATE(),NOW())";
						//echo $sql."<br>";
						$rs1=mysql_query($sql);				
								
						$sql="SELECT SQL_NO_CACHE IFNULL(SUM(t1.stok_after),0) AS jml,IFNULL(SUM(t1.ntot),0) AS ntot FROM (SELECT SQL_NO_CACHE UUID() AS cuid,IFNULL(QTY_STOK,0) AS stok_after,IFNULL((IF(((NILAI_PAJAK<=0) OR (TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) * 1.1)),0) AS ntot FROM $dbapotek.a_penerimaan WHERE OBAT_ID=$obat_id AND KEPEMILIKAN_ID=$kepemilikan_id AND UNIT_ID_TERIMA=$idunit AND QTY_STOK>0 AND STATUS=1) AS t1";
						//echo $sql."<br>";
						$rs1=mysql_query($sql);
						$cstk_after=0;
						$cnilai=0;
						if ($rows1=mysql_fetch_array($rs1)){
							$cstk_after=$rows1['jml'];
							$cnilai=$rows1['ntot'];
						}
						$cstk_bfr=$cstk_after-$selisih;
						$sql="insert into $dbapotek.a_kartustok(OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID,fkid,tipetrans,HARGA_SATUAN,NILAI_TOTAL) values($obat_id,$kepemilikan_id,$idunit,CURDATE(),NOW(),'',$cstk_bfr,$selisih,0,$stok,'Stok Opname',$iduser,0,5,0,'$cnilai')";
						//echo $sql;
						$rs1=mysql_query($sql);
					}
				}
			}
		break;
		
		
		case "save":
		$sql="select *,UUID() AS cuid from $dbapotek.a_stok_opname where idobat=$obat_id and idunit=$idunit and kepemilikan_id=$kepemilikan_id and month(tgl)=$bulan and year(tgl)=$tahun";
		//echo $sql."<br>";
		$rs=mysql_query($sql);
		if ($rows=mysql_fetch_array($rs)){
			$sql="select SQL_NO_CACHE UUID() AS cuid,if (sum(QTY_STOK) is null,0,sum(QTY_STOK)) as jml from $dbapotek.a_penerimaan where OBAT_ID=$obat_id and UNIT_ID_TERIMA=$idunit and KEPEMILIKAN_ID=$kepemilikan_id and STATUS=1 and QTY_STOK>0";
			$rs1=mysql_query($sql);
			if ($rows1=mysql_fetch_array($rs1)){
				$cjml=$rows1['jml'];
				if ($cjml>0){
					echo "<script>alert('Obat Tersebut Sudah Ada');</script>";
				}else{
					/*
					if ($hargab==0){
						echo "<script>alert('Obat Tersebut Belum Ada Harganya');</script>";
					}else{
					*/
						$sql="insert into $dbapotek.a_penerimaan(OBAT_ID,UNIT_ID_TERIMA,KEPEMILIKAN_ID,USER_ID_KIRIM,TANGGAL_ACT,TANGGAL,QTY_SATUAN,QTY_STOK,HARGA_BELI_SATUAN,TIPE_TRANS,STATUS) values($obat_id,$idunit,$kepemilikan_id,$iduser,NOW(),CURDATE(),$stok,$stok,'$hargab',5,1)";
						//echo $sql;
						$rs=mysql_query($sql);
						$sql="select UUID() AS cuid,ID from $dbapotek.a_penerimaan where UNIT_ID_TERIMA=$idunit and USER_ID_KIRIM=$iduser AND TIPE_TRANS=5 AND QTY_STOK>0 order by ID desc limit 1";
						//echo $sql."<br>";
						$rs1=mysql_query($sql);
						$cidp=0;
						if ($rows1=mysql_fetch_array($rs1)){
							$cidp=$rows1['ID'];
						}
						$sql="update $dbapotek.a_stok_opname set idpenerimaan=$cidp,opname=$stok,adjust=$stok,qty=$stok,harga_satuan='$hargab',tgl=CURDATE(),tgl_act=NOW() where idunit=$idunit and idobat=$obat_id and kepemilikan_id=$kepemilikan_id";
						//echo $sql."<br>";
						$rs=mysql_query($sql);
						$sql="SELECT SQL_NO_CACHE IFNULL(SUM(t1.stok_after),0) AS jml,IFNULL(SUM(t1.ntot),0) AS ntot FROM (SELECT SQL_NO_CACHE UUID() AS cuid,IFNULL(QTY_STOK,0) AS stok_after,IFNULL((IF(((NILAI_PAJAK<=0) OR (TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) * 1.1)),0) AS ntot FROM $dbapotek.a_penerimaan WHERE OBAT_ID=$obat_id AND KEPEMILIKAN_ID=$kepemilikan_id AND UNIT_ID_TERIMA=$idunit AND QTY_STOK>0 AND STATUS=1) AS t1";
						$rs=mysql_query($sql);
						$cstk_after=0;
						$cnilai=0;
						if ($rows=mysql_fetch_array($rs)){
							$cstk_after=$rows['jml'];
							$cnilai=$rows['ntot'];
						}
						$cstk_bfr=0;
						$sql="insert into $dbapotek.a_kartustok(OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID,fkid,tipetrans,HARGA_SATUAN,NILAI_TOTAL) values($obat_id,$kepemilikan_id,$idunit,CURDATE(),NOW(),'',$cstk_bfr,$stok,0,$stok,'Stok Opname',$iduser,$cidp,5,'$hargab','$cnilai')";
						//echo $sql;
						$rs=mysql_query($sql);
					//}
				}
			}
		}else{
			/*	
			if ($hargab==0){
				echo "<script>alert('Obat Tersebut Belum Ada Harganya');</script>";
			}else{
			*/
				$sql="SELECT SQL_NO_CACHE IFNULL(SUM(t1.stok_after),0) AS qty_stok FROM (SELECT SQL_NO_CACHE UUID() AS cuid,IFNULL(QTY_STOK,0) AS stok_after FROM $dbapotek.a_penerimaan WHERE OBAT_ID=$obat_id AND KEPEMILIKAN_ID=$kepemilikan_id AND UNIT_ID_TERIMA=$idunit AND QTY_STOK>0 AND STATUS=1) AS t1";
				//echo $sql;
				$rs=mysql_query($sql);
				$cstok=0;
				if ($rows=mysql_fetch_array($rs)){
					$cstok=$rows['qty_stok'];
				}
				if ($cstok>$stok){
					$selisih=$cstok-$stok;
					$tmpselisih=$cstok-$stok;
					$sql="select SQL_NO_CACHE *,UUID() AS cuid from $dbapotek.a_penerimaan where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id and UNIT_ID_TERIMA=$idunit and QTY_STOK>0 and STATUS=1 order by HARGA_BELI_SATUAN";
					//echo $sql."<br>";
					$rs=mysql_query($sql);
					$ok="false";
					while (($rows=mysql_fetch_array($rs)) && ($ok=="false")){
						$qty=$rows["QTY_STOK"];
						$cid=$rows["ID"];
						$ch_satuan=$rows['HARGA_BELI_SATUAN'];
						$cdiskon=$rows['DISKON'];
						$ctipetrans=$rows['TIPE_TRANS'];
						$cnpajak=$rows['NILAI_PAJAK'];
						if (($cnpajak<=0) || ($ctipetrans==4) || ($ctipetrans==5) || ($ctipetrans==100)){
							$ch_satuan=$ch_satuan * (1-($cdiskon/100));
						}else{
							$ch_satuan=$ch_satuan * (1-($cdiskon/100)) * 1.1;
						}
						
						if ($qty>=$selisih){
							$ok="true";
							$sql="update $dbapotek.a_penerimaan set QTY_STOK=QTY_STOK-$selisih where ID=$cid";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);					
							$sql="insert into $dbapotek.a_stok_opname(idunit,iduser,idpenerimaan,idobat,kepemilikan_id,stok,opname,adjust,qty,harga_satuan,tgl,tgl_act) values($idunit,$iduser,$cid,$obat_id,$kepemilikan_id,$cstok,$stok,-$selisih,-$selisih,'$hargab',now(),now())";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);
							$sql="SELECT SQL_NO_CACHE IFNULL(SUM(t1.stok_after),0) AS jml,IFNULL(SUM(t1.ntot),0) AS ntot FROM (SELECT SQL_NO_CACHE UUID() AS cuid,IFNULL(QTY_STOK,0) AS stok_after,IFNULL((IF(((NILAI_PAJAK<=0) OR (TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) * 1.1)),0) AS ntot FROM $dbapotek.a_penerimaan WHERE OBAT_ID=$obat_id AND KEPEMILIKAN_ID=$kepemilikan_id AND UNIT_ID_TERIMA=$idunit AND QTY_STOK>0 AND STATUS=1) AS t1";
							$rs1=mysql_query($sql);
							$cstk_after=0;
							$cnilai=0;
							if ($rows1=mysql_fetch_array($rs1)){
								$cstk_after=$rows1['jml'];
								$cnilai=$rows1['ntot'];
							}
							$cstk_bfr=$cstk_after+$selisih;
							$sql="insert into $dbapotek.a_kartustok(OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID,fkid,tipetrans,HARGA_SATUAN,NILAI_TOTAL) values($obat_id,$kepemilikan_id,$idunit,CURDATE(),NOW(),'',$cstk_bfr,-$selisih,0,$cstk_after,'Stok Opname',$iduser,$cid,5,'$ch_satuan','$cnilai')";
							//echo $sql;
							$rs1=mysql_query($sql);
						}else{
							$selisih=$selisih-$qty;
							$sql="update $dbapotek.a_penerimaan set QTY_STOK=0 where ID=$cid";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);										
							$sql="SELECT SQL_NO_CACHE IFNULL(SUM(t1.stok_after),0) AS jml,IFNULL(SUM(t1.ntot),0) AS ntot FROM (SELECT SQL_NO_CACHE UUID() AS cuid,IFNULL(QTY_STOK,0) AS stok_after,IFNULL((IF(((NILAI_PAJAK<=0) OR (TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) * 1.1)),0) AS ntot FROM $dbapotek.a_penerimaan WHERE OBAT_ID=$obat_id AND KEPEMILIKAN_ID=$kepemilikan_id AND UNIT_ID_TERIMA=$idunit AND QTY_STOK>0 AND STATUS=1) AS t1";
							$rs1=mysql_query($sql);
							$cstk_after=0;
							$cnilai=0;
							if ($rows1=mysql_fetch_array($rs1)){
								$cstk_after=$rows1['jml'];
								$cnilai=$rows1['ntot'];
							}
							$cstk_bfr=$cstk_after+$qty;
							$sql="insert into $dbapotek.a_kartustok(OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID,fkid,tipetrans,HARGA_SATUAN,NILAI_TOTAL) values($obat_id,$kepemilikan_id,$idunit,CURDATE(),NOW(),'',$cstk_bfr,-$qty,0,$cstk_after,'Stok Opname',$iduser,$cid,5,'$ch_satuan','$cnilai')";
							//echo $sql;
							$rs1=mysql_query($sql);
						}
					}
				}else{
					$selisih=$stok-$cstok;
					if ($selisih>0){
						$sql="insert into $dbapotek.a_penerimaan(OBAT_ID,UNIT_ID_TERIMA,KEPEMILIKAN_ID,USER_ID_KIRIM,TANGGAL_ACT,TANGGAL,QTY_SATUAN,QTY_STOK,HARGA_BELI_SATUAN,TIPE_TRANS,STATUS) values($obat_id,$idunit,$kepemilikan_id,$iduser,NOW(),CURDATE(),$selisih,$selisih,'$hargab',5,1)";
						//echo $sql;
						$rs=mysql_query($sql);
						$sql="select UUID() AS cuid,ID from $dbapotek.a_penerimaan where UNIT_ID_TERIMA=$idunit and USER_ID_KIRIM=$iduser and TANGGAL=CURDATE() order by ID desc limit 1";
						//echo $sql."<br>";
						$rs1=mysql_query($sql);
						$cidp=0;
						if ($rows1=mysql_fetch_array($rs1)){
							$cidp=$rows1['ID'];
						}
						$sql="insert into $dbapotek.a_stok_opname(idunit,iduser,idpenerimaan,idobat,kepemilikan_id,stok,opname,adjust,qty,harga_satuan,tgl,tgl_act) values($idunit,$iduser,$cidp,$obat_id,$kepemilikan_id,$cstok,$stok,$selisih,$selisih,'$hargab',now(),now())";
						//echo $sql."<br>";
						$rs=mysql_query($sql);
						$sql="SELECT SQL_NO_CACHE IFNULL(SUM(t1.stok_after),0) AS jml,IFNULL(SUM(t1.ntot),0) AS ntot FROM (SELECT SQL_NO_CACHE UUID() AS cuid,IFNULL(QTY_STOK,0) AS stok_after,IFNULL((IF(((NILAI_PAJAK<=0) OR (TIPE_TRANS=4) OR (TIPE_TRANS=5) OR (TIPE_TRANS=100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)),QTY_STOK*HARGA_BELI_SATUAN * (1-(DISKON/100)) * 1.1)),0) AS ntot FROM $dbapotek.a_penerimaan WHERE OBAT_ID=$obat_id AND KEPEMILIKAN_ID=$kepemilikan_id AND UNIT_ID_TERIMA=$idunit AND QTY_STOK>0 AND STATUS=1) AS t1";
						$rs=mysql_query($sql);
						$cstk_after=0;
						$cnilai=0;
						if ($rows=mysql_fetch_array($rs)){
							$cstk_after=$rows['jml'];
							$cnilai=$rows['ntot'];
						}
						$cstk_bfr=$cstk_after-$selisih;
						$sql="insert into $dbapotek.a_kartustok(OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID,fkid,tipetrans,HARGA_SATUAN,NILAI_TOTAL) values($obat_id,$kepemilikan_id,$idunit,CURDATE(),NOW(),'',$cstk_bfr,$selisih,0,$cstk_after,'Stok Opname',$iduser,$cidp,5,'$hargab','$cnilai')";
						//echo $sql;
						$rs=mysql_query($sql);
					}
				}
			//}
		}
		break;
}
		

if ($filter!=""){
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting==""){
	$sorting=$defaultsort;
	if($grd2=="true"){
		$sorting="unit";
	}
}

$bln = date('m');
$thn = date('Y');

if($bln!=$bulan || $thn!=$tahun){
	$sql="SELECT 
		  ao.OBAT_ID,
		  ao.OBAT_KODE,
		  ao.OBAT_NAMA,
		  ao.OBAT_SATUAN_KECIL,
		  ak.ID,
		  ak.NAMA,
		  so.stok,
		  so.adjust,
		  1 AS sdh_so,
		  SUM(so.qty * so.harga_satuan) AS nilai 
		FROM
		  $dbapotek.a_stok_opname so 
		  INNER JOIN $dbapotek.a_obat ao 
			ON so.idobat = ao.OBAT_ID 
		  INNER JOIN $dbapotek.a_kepemilikan ak 
			ON so.kepemilikan_id = ak.ID 
		WHERE so.idunit = '".$idunit."' 
		  AND MONTH(so.tgl) = '".$bulan."' 
		  AND YEAR(so.tgl) = '".$tahun."' 
		GROUP BY so.idobat,
		  so.kepemilikan_id,
		  so.stok,
		  so.opname 
		ORDER BY OBAT_NAMA";
}
else{
$sql="SELECT
  tbl1.*,
  IF (aso.adjust IS NULL, 0, aso.adjust) AS adjust,
  IF (aso.adjust IS NULL, 0, 1) AS sdh_so
FROM (SELECT
        au.UNIT_ID,
        au.UNIT_NAME,
        au.kdunitfar,
        ao.OBAT_ID,
        ao.OBAT_KODE,
        ao.OBAT_NAMA,
        ap.KEPEMILIKAN_ID,
        ak.NAMA,
        ap.stok,
        ap.HARGA_BELI_SATUAN,
        ap.DISKON,
        ap.NILAI_PAJAK
      FROM $dbapotek.a_obat ao
        INNER JOIN (SELECT
                      OBAT_ID,
                      SUM(QTY_STOK)            stok,
                      KEPEMILIKAN_ID,
                      UNIT_ID_TERIMA,
                      HARGA_BELI_SATUAN,
                      DISKON,
                      NILAI_PAJAK
                    FROM $dbapotek.a_penerimaan
                    WHERE UNIT_ID_TERIMA = '".$idunit."'
                        AND QTY_STOK > 0
                    GROUP BY OBAT_ID) ap
          ON ao.OBAT_ID = ap.OBAT_ID
        INNER JOIN $dbapotek.a_kepemilikan ak
          ON ak.ID = ap.KEPEMILIKAN_ID
        INNER JOIN $dbapotek.a_unit au
          ON au.UNIT_ID = ap.UNIT_ID_TERIMA WHERE ao.OBAT_ISAKTIF=1
      ORDER BY ao.OBAT_NAMA) AS tbl1
  LEFT JOIN (SELECT
               DISTINCT
               idobat,
               kepemilikan_id,
               opname,
               adjust,
               qty,
               tgl
             FROM $dbapotek.a_stok_opname
             WHERE idunit = '".$idunit."'
                 AND MONTH(tgl) = '".$bulan."'
                 AND YEAR(tgl) = '".$tahun."') AS aso
    ON aso.idobat = tbl1.OBAT_ID
      AND aso.kepemilikan_id = tbl1.KEPEMILIKAN_ID ".$filter;
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


while ($rows=mysql_fetch_array($rs))
{
	if($rows['sdh_so']=="0"){
		$status = "-";
	}
	else{
		$status = "<img src='../icon/ok.png' width='16' align='absmiddle' />";
	}
	
	$i++;
	$proses="<img src='../icon/edit.gif' width='16' align='absmiddle' style='cursor:pointer' onclick='showPop($i)' />";
	$dt.=$rows["OBAT_ID"]."|".$rows["KEPEMILIKAN_ID"]."|".$rows["stok"]."|".$rows['sdh_so'].chr(3).number_format($i,0,",","").chr(3).$rows["OBAT_KODE"].chr(3).$rows["OBAT_NAMA"].chr(3).$rows["NAMA"].chr(3).number_format($rows["stok"],0,',','.')."&nbsp;&nbsp;".chr(3).$rows['adjust'].chr(3).$status.chr(3).$proses.chr(6);
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
