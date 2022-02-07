<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$tgl_act=gmdate('Y-m-d H:i:s',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
$bln=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_REQUEST['idunit'];
$idunit1=$_SESSION["ses_idunit"];
if ($idunit=="") $idunit=$idunit1;
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=$bln;

$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
$obat_id=$_REQUEST['obatid'];
$kepemilikan_id=$_REQUEST['kepemilikan_id'];
$stok=$_REQUEST['stok'];
$stok1=$_REQUEST['stok1'];
$ket=$_REQUEST['ket'];
$ada_data=$_REQUEST['ada_data'];
$sdh_so=$_REQUEST['sdh_so'];
$hpp==$_REQUEST['hpp'];
$profit==$_REQUEST['profit'];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="OBAT_NAMA";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================

//Aksi Save, Edit Atau Delete =========================================
$act=$_REQUEST['act']; // Jenis Aksi
//echo $act;

switch ($act){
	case "import":
		$sql="select ao.OBAT_ID,ao.OBAT_NAMA,ak.ID,ak.NAMA,sum(ap.QTY_STOK) as QTY_STOK from a_penerimaan ap inner join a_obat ao on ap.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on ap.KEPEMILIKAN_ID=ak.ID where UNIT_ID_TERIMA=$idunit and ao.OBAT_ISAKTIF=1 and STATUS=1 and QTY_STOK>0 group by ao.OBAT_ID,ak.ID order by ao.OBAT_NAMA";
		//echo $sql;
		$rs=mysqli_query($konek,$sql);
		while ($rows=mysqli_fetch_array($rs)){
			$cobat_id=$rows['OBAT_ID'];
			$c_id=$rows['ID'];
			$cstok=$rows['QTY_STOK'];
			if ($ada_data=="true"){
				$sql="select * from a_stok_opname where idunit=$idunit and idobat=$cobat_id and kepemilikan_id=$c_id and month(tgl)=$bulan and year(tgl)=$ta";
				//echo $sql;
				$rs1=mysqli_query($konek,$sql);
				if ($rows1=mysqli_fetch_array($rs1)){
					$cid=$rows1['opname_id'];
					$copname=$rows1['opname'];
					if ($copname==0){
						$sql="update a_stok_opname set stok=$cstok where opname_id=$cid";
						//echo $sql;
						$rs2=mysqli_query($konek,$sql);
					}
				}else{
					$sql="insert into a_stok_opname(idunit,iduser,idpenerimaan,idobat,kepemilikan_id,stok,opname,qty,harga_satuan,tgl,tgl_act) values($idunit,$iduser,0,$cobat_id,$c_id,$cstok,0,0,0,'$tgl2','$tgl_act')";
					//echo $sql;
					$rs2=mysqli_query($konek,$sql);
				}
			}else{
				$sql="insert into a_stok_opname(idunit,iduser,idpenerimaan,idobat,kepemilikan_id,stok,opname,qty,harga_satuan,tgl,tgl_act) values($idunit,$iduser,0,$cobat_id,$c_id,$cstok,0,0,0,'$tgl2','$tgl_act')";
				//echo $sql;
				$rs1=mysqli_query($konek,$sql);
			}
		}
		break;
	case "save":
		$sql="select * from a_stok_opname where idobat=$obat_id and idunit=$idunit and kepemilikan_id=$kepemilikan_id and month(tgl)=$bulan and year(tgl)=$ta";
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		if ($rows=mysqli_fetch_array($rs)){
			$sql="select if (sum(QTY_STOK) is null,0,sum(QTY_STOK)) as jml from a_penerimaan where OBAT_ID=$obat_id and UNIT_ID_TERIMA=$idunit and KEPEMILIKAN_ID=$kepemilikan_id and STATUS=1 and QTY_STOK>0";
			$rs1=mysqli_query($konek,$sql);
			if ($rows1=mysqli_fetch_array($rs1)){
				$cjml=$rows1['jml'];
				if ($cjml>0){
					echo "<script>alert('Obat Tersebut Sudah Ada');</script>";
				}else{
					if (trim($hpp)==""){
						$sql="select * from a_harga where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id";
						//echo $sql."<br>";
						$rs=mysqli_query($konek,$sql);
						$hargab=0;
						//$hargaj==0;
						if ($rows1=mysqli_fetch_array($rs)){
							$hargab=$rows1["HARGA_BELI_SATUAN"];
						}
					}else{
						$sql="select * from a_harga where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id";
						//echo $sql."<br>";
						$rs=mysqli_query($konek,$sql);
						if ($rows=mysqli_fetch_array($rs)){
							$sql="update a_harga set HARGA_BELI_SATUAN=$hpp,PROFIT=$profit,HARGA_JUAL_SATUAN=$hpp+($hpp*$profit/100),TGL_UPDATE='$tgl_act',USER_ID=$iduser where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id";
							$rs1=mysqli_query($konek,$sql);
						}else{
							$sql="insert into a_harga(OBAT_ID,KEPEMILIKAN_ID,HARGA_BELI_SATUAN,PROFIT,HARGA_JUAL_SATUAN,TGL_UPDATE,USER_ID) values($obat_id,$kepemilikan_id,$hpp,$profit,$hpp+($hpp*$profit/100),'$tgl_act',$iduser)";
							$rs1=mysqli_query($konek,$sql);
						}
						$hargab=$hpp;
					}
					
					if ($hargab==0){
						echo "<script>alert('Obat Tersebut Belum Ada Harganya');</script>";
					}else{
						$sql="select STOK_AFTER from a_kartustok where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id and UNIT_ID=$idunit order by TGL_TRANS desc,ID desc limit 1";
						$rs=mysqli_query($konek,$sql);
						$cstk_bfr=0;
						if ($rows=mysqli_fetch_array($rs)){
							$cstk_bfr=$rows['STOK_AFTER'];
						}
						$cstk_after=$cstk_bfr+$stok;
						$sql="insert into a_kartustok(OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID) values($obat_id,$kepemilikan_id,$idunit,'$tgl2','$tgl_act','',$cstk_bfr,$stok,0,$cstk_after,'Stok Opname',$iduser)";
						//echo $sql;
						$rs=mysqli_query($konek,$sql);
						$sql="insert into a_penerimaan(OBAT_ID,UNIT_ID_TERIMA,KEPEMILIKAN_ID,USER_ID_KIRIM,TANGGAL_ACT,TANGGAL,QTY_SATUAN,QTY_STOK,HARGA_BELI_SATUAN,TIPE_TRANS,STATUS) values($obat_id,$idunit,$kepemilikan_id,$iduser,'$tgl_act','$tgl2',$stok,$stok,$hargab,5,1)";
						//echo $sql;
						$rs=mysqli_query($konek,$sql);
						$sql="select ID from a_penerimaan where UNIT_ID_TERIMA=$idunit and USER_ID_KIRIM=$iduser and TANGGAL='$tgl2' and TANGGAL_ACT='$tgl_act' order by ID desc limit 1";
						//echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);
						$cidp=0;
						if ($rows1=mysqli_fetch_array($rs1)){
							$cidp=$rows1['ID'];
						}
						$sql="insert into a_stok_opname(idunit,iduser,idpenerimaan,idobat,kepemilikan_id,stok,opname,adjust,qty,harga_satuan,tgl,tgl_act) values($idunit,$iduser,$cidp,$obat_id,$kepemilikan_id,0,$stok,$stok,$stok,$hargab,'$tgl2','$tgl_act')";
						//echo $sql."<br>";
						$rs=mysqli_query($konek,$sql);
					}
				}
//			}else{
			}
		}else{
			if (trim($hpp)==""){
				$sql="select * from a_harga where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id";
				//echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
				$hargab=0;
				//$hargaj==0;
				if ($rows1=mysqli_fetch_array($rs)){
					$hargab=$rows1["HARGA_BELI_SATUAN"];
				}
			}else{
				$sql="select * from a_harga where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id";
				//echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
				if ($rows=mysqli_fetch_array($rs)){
					$sql="update a_harga set HARGA_BELI_SATUAN=$hpp,PROFIT=$profit,HARGA_JUAL_SATUAN=$hpp+($hpp*$profit/100),TGL_UPDATE='$tgl_act',USER_ID=$iduser where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id";
					$rs1=mysqli_query($konek,$sql);
				}else{
					$sql="insert into a_harga(OBAT_ID,KEPEMILIKAN_ID,HARGA_BELI_SATUAN,PROFIT,HARGA_JUAL_SATUAN,TGL_UPDATE,USER_ID) values($obat_id,$kepemilikan_id,$hpp,$profit,$hpp+($hpp*$profit/100),'$tgl_act',$iduser)";
					$rs1=mysqli_query($konek,$sql);
				}
				$hargab=$hpp;
			}
			
			if ($hargab==0){
				echo "<script>alert('Obat Tersebut Belum Ada Harganya');</script>";
			}else{
				$sql="select if (sum(QTY_STOK) is null,0,sum(QTY_STOK)) as qty_stok from a_penerimaan where OBAT_ID=$obat_id and UNIT_ID_TERIMA=$idunit and KEPEMILIKAN_ID=$kepemilikan_id and QTY_STOK>0 and STATUS=1";
				//echo $sql;
				$rs=mysqli_query($konek,$sql);
				$cstok=0;
				if ($rows=mysqli_fetch_array($rs)){
					$cstok=$rows['qty_stok'];
				}
/*				
				$sql="insert into a_stok_opname(idunit,iduser,idpenerimaan,idobat,kepemilikan_id,stok,opname,qty,harga_satuan,tgl,tgl_act) values($idunit,$iduser,0,$obat_id,$kepemilikan_id,$cstok,$stok,0,0,'$tgl2','$tgl_act')";
				//echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
*/										
				if ($cstok>$stok){
					$selisih=$cstok-$stok;
					$sql="select * from a_penerimaan where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id and UNIT_ID_TERIMA=$idunit and QTY_STOK>0 and STATUS=1 order by HARGA_BELI_SATUAN";
					//echo $sql."<br>";
					$rs=mysqli_query($konek,$sql);
					$ok="false";
					while (($rows=mysqli_fetch_array($rs)) && ($ok=="false")){
						$qty=$rows["QTY_STOK"];
						$cid=$rows["ID"];
						if ($qty>$selisih){
							$ok=="true";
							$sql="update a_penerimaan set QTY_STOK=QTY_STOK-$selisih where ID=$cid";
							//echo $sql."<br>";
							$rs1=mysqli_query($konek,$sql);					
							$sql="insert into a_stok_opname(idunit,iduser,idpenerimaan,idobat,kepemilikan_id,stok,opname,adjust,qty,harga_satuan,tgl,tgl_act) values($idunit,$iduser,$cid,$obat_id,$kepemilikan_id,$cstok,$stok,-$selisih,-$selisih,$hargab,'$tgl2','$tgl_act')";
							//echo $sql."<br>";
							$rs1=mysqli_query($konek,$sql);
						}else{
							$selisih=$selisih-$qty;
							$sql="update a_penerimaan set QTY_STOK=0 where ID=$cid";
							//echo $sql."<br>";
							$rs1=mysqli_query($konek,$sql);										
						}
					}
				}else{
					$selisih=$stok-$cstok;
					if ($selisih>0){
						$sql="insert into a_penerimaan(OBAT_ID,UNIT_ID_TERIMA,KEPEMILIKAN_ID,USER_ID_KIRIM,TANGGAL_ACT,TANGGAL,QTY_SATUAN,QTY_STOK,HARGA_BELI_SATUAN,TIPE_TRANS,STATUS) values($obat_id,$idunit,$kepemilikan_id,$iduser,'$tgl_act','$tgl2',$selisih,$selisih,$hargab,5,1)";
						//echo $sql;
						$rs=mysqli_query($konek,$sql);
						$sql="select ID from a_penerimaan where UNIT_ID_TERIMA=$idunit and USER_ID_KIRIM=$iduser and TANGGAL='$tgl2' and TANGGAL_ACT='$tgl_act' order by ID desc limit 1";
						//echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);
						$cidp=0;
						if ($rows1=mysqli_fetch_array($rs1)){
							$cidp=$rows1['ID'];
						}
						$sql="insert into a_stok_opname(idunit,iduser,idpenerimaan,idobat,kepemilikan_id,stok,opname,adjust,qty,harga_satuan,tgl,tgl_act) values($idunit,$iduser,$cidp,$obat_id,$kepemilikan_id,$cstok,$stok,$selisih,$selisih,$hargab,'$tgl2','$tgl_act')";
						//echo $sql."<br>";
						$rs=mysqli_query($konek,$sql);
					}
				}
			}
		}
		break;
	case "edit":
		if (trim($hpp)==""){
			$sql="select * from a_harga where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			$hargab=0;
			//$hargaj==0;
			if ($rows1=mysqli_fetch_array($rs)){
				$hargab=$rows1["HARGA_BELI_SATUAN"];
			}
		}else{
			$sql="select * from a_harga where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id";
			//echo $sql."<br>";
			$rs=mysqli_query($konek,$sql);
			if ($rows=mysqli_fetch_array($rs)){
				$sql="update a_harga set HARGA_BELI_SATUAN=$hpp,PROFIT=$profit,HARGA_JUAL_SATUAN=$hpp+($hpp*$profit/100),TGL_UPDATE='$tgl_act',USER_ID=$iduser where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id";
				//echo $sql."<br>";
				$rs1=mysqli_query($konek,$sql);
			}else{
				$sql="insert into a_harga(OBAT_ID,KEPEMILIKAN_ID,HARGA_BELI_SATUAN,PROFIT,HARGA_JUAL_SATUAN,TGL_UPDATE,USER_ID) values($obat_id,$kepemilikan_id,$hpp,$profit,$hpp+($hpp*$profit/100),'$tgl_act',$iduser)";
				//echo $sql."<br>";
				$rs1=mysqli_query($konek,$sql);
			}
			$hargab=$hpp;
		}

		$sql="select if (sum(QTY_STOK) is null,0,sum(QTY_STOK)) as qty_stok from a_penerimaan where OBAT_ID=$obat_id and UNIT_ID_TERIMA=$idunit and KEPEMILIKAN_ID=$kepemilikan_id and QTY_STOK>0 and STATUS=1";
		//echo $sql."<br>";
		$rs=mysqli_query($konek,$sql);
		$cstok=0;
		if ($rows=mysqli_fetch_array($rs)){
			$cstok=$rows['qty_stok'];
		}
		if ($sdh_so=="1"){
			if ($cstok>$stok){
				$selisih=$cstok-$stok;
				$sql="update a_stok_opname set opname=opname-$selisih,adjust=adjust-$selisih where idunit=$idunit and idobat=$obat_id and kepemilikan_id=$kepemilikan_id and month(tgl)=$bulan and year(tgl)=$ta";
				//echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
				$sql="select * from a_stok_opname where idunit=$idunit and idobat=$obat_id and kepemilikan_id=$kepemilikan_id and month(tgl)=$bulan and year(tgl)=$ta limit 1";
				//echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
				if ($rows=mysqli_fetch_array($rs)){
					$cstk=$rows['stok'];
					$cop=$rows['opname'];
					$cadj=$rows['adjust'];
				}
				$sql="select * from a_penerimaan where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id and UNIT_ID_TERIMA=$idunit and QTY_STOK>0 and STATUS=1 order by HARGA_BELI_SATUAN";
				//echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
				$ok="false";
				while (($rows=mysqli_fetch_array($rs)) && ($ok=="false")){
					$qty=$rows["QTY_STOK"];
					$cid=$rows["ID"];
					$charga=$rows["HARGA_BELI_SATUAN"];
					if ($qty>=$selisih){
						$ok="true";
						$qty_trans=0-$selisih;
						$sql="update a_penerimaan set QTY_STOK=QTY_STOK-$selisih where ID=$cid";
						//echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);					
					}else{
						$selisih=$selisih-$qty;
						$qty_trans=0-$qty;
						if ($selisih==0) $ok=="true";
						$sql="update a_penerimaan set QTY_STOK=0 where ID=$cid";
						//echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);										
					}
/*					$sql="insert into a_stok_opname(idunit,iduser,idpenerimaan,idobat,kepemilikan_id,stok,opname,adjust,qty,harga_satuan,tgl,tgl_act) values($idunit,$iduser,$cid,$obat_id,$kepemilikan_id,$cstk,$cop,$cadj,$qty_trans,$charga,'$tgl2','$tgl_act')";
					echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
*/
				}
			}else{
				$selisih=$stok-$cstok;
				if ($selisih>0){
					$sql="update a_stok_opname set opname=opname+$selisih,adjust=adjust+$selisih where idunit=$idunit and idobat=$obat_id and kepemilikan_id=$kepemilikan_id and month(tgl)=$bulan and year(tgl)=$ta";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
					$sql="select * from a_stok_opname where idunit=$idunit and idobat=$obat_id and kepemilikan_id=$kepemilikan_id and month(tgl)=$bulan and year(tgl)=$ta order by opname_id desc";
					//echo $sql."<br>";
					$rs=mysqli_query($konek,$sql);
					$ok="false";
					while (($rows=mysqli_fetch_array($rs)) && ($ok=="false")){
						$cid=$rows['opname_id'];
						$cidp=$rows['idpenerimaan'];
						$cqty=$rows['qty'];
						if ($cqty>=0){
							if ($cidp==0){
								$ok="true";
								$sql="insert into a_penerimaan(OBAT_ID,UNIT_ID_TERIMA,KEPEMILIKAN_ID,USER_ID_KIRIM,TANGGAL_ACT,TANGGAL,QTY_SATUAN,QTY_STOK,HARGA_BELI_SATUAN,TIPE_TRANS,STATUS) values($obat_id,$idunit,$kepemilikan_id,$iduser,'$tgl_act','$tgl2',$selisih,$selisih,$hargab,5,1)";
								//echo $sql."<br>";
								$rs1=mysqli_query($konek,$sql);
								$sql="select ID from a_penerimaan where UNIT_ID_TERIMA=$idunit and USER_ID_KIRIM=$iduser and TANGGAL='$tgl2' and TANGGAL_ACT='$tgl_act' order by ID desc limit 1";
								//echo $sql."<br>";
								$rs1=mysqli_query($konek,$sql);
								if ($rows1=mysqli_fetch_array($rs1)){
									$cidp=$rows1['ID'];
								}
								$sql="update a_stok_opname set idpenerimaan=$cidp,qty=qty+$selisih where ID=$cid";
								//echo $sql."<br>";
								$rs1=mysqli_query($konek,$sql);
							}else{
								$ok="true";
								$sql="update a_penerimaan set QTY_SATUAN=QTY_SATUAN+$selisih,QTY_STOK=QTY_STOK+$selisih where ID=$cidp";
								//echo $sql."<br>";
								$rs1=mysqli_query($konek,$sql);
								$sql="update a_stok_opname set qty=qty+$selisih where ID=$cid";
								//echo $sql."<br>";
								$rs1=mysqli_query($konek,$sql);
							}
						}else{
//							if (($selisih+$cqty)<=0){
								$ok=="true";
								$jml=$selisih;
								$sql="update a_stok_opname set qty=qty+$jml where opname_id=$cid";
								//echo $sql."<br>";
								$rs1=mysqli_query($konek,$sql);
/*							}else{
								$jml=0-$cqty;
								$selisih=$selisih+$cqty;
								$sql="delete from a_stok_opname where opname_id=$cid";
								echo $sql."<br>";
								$rs1=mysqli_query($konek,$sql);
							}
*/
							$sql="update a_penerimaan set QTY_STOK=QTY_STOK+$jml where ID=$cidp";
							//echo $sql."<br>";
							$rs1=mysqli_query($konek,$sql);
						}
					}
				}
			}
		}else{
			if ($cstok>$stok){
				$selisih=$cstok-$stok;
				$sql="select STOK_AFTER from a_kartustok where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id and UNIT_ID=$idunit order by TGL_TRANS desc,ID desc limit 1";
				$rs=mysqli_query($konek,$sql);
				$cstk_bfr=0;
				if ($rows=mysqli_fetch_array($rs)){
					$cstk_bfr=$rows['STOK_AFTER'];
				}
				$cstk_after=$cstk_bfr-$selisih;
				$sql="insert into a_kartustok(OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID) values($obat_id,$kepemilikan_id,$idunit,'$tgl2','$tgl_act','',$cstk_bfr,-$selisih,0,$cstk_after,'Stok Opname',$iduser)";
				//echo $sql;
				$rs=mysqli_query($konek,$sql);
				$sql="select * from a_penerimaan where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id and UNIT_ID_TERIMA=$idunit and QTY_STOK>0 and STATUS=1 order by HARGA_BELI_SATUAN";
				//echo $sql."<br>";
				$rs=mysqli_query($konek,$sql);
				$ok="false";
				while (($rows=mysqli_fetch_array($rs)) && ($ok=="false")){
					$qty=$rows["QTY_STOK"];
					$cid=$rows["ID"];
					$charga=$rows["HARGA_BELI_SATUAN"];
					if ($qty>=$selisih){
						$ok="true";
						$qty_trans=0-$selisih;
						$sql="update a_penerimaan set QTY_STOK=QTY_STOK-$selisih where ID=$cid";
						//echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);					
					}else{
						$selisih=$selisih-$qty;
						$qty_trans=0-$qty;
						if ($selisih==0) $ok=="true";
						$sql="update a_penerimaan set QTY_STOK=0 where ID=$cid";
						//echo $sql."<br>";
						$rs1=mysqli_query($konek,$sql);										
					}
					$sql="insert into a_stok_opname(idunit,iduser,idpenerimaan,idobat,kepemilikan_id,stok,opname,adjust,qty,harga_satuan,tgl,tgl_act) values($idunit,$iduser,$cid,$obat_id,$kepemilikan_id,$cstok,$stok,$stok-$cstok,$qty_trans,$charga,'$tgl2','$tgl_act')";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);
				}
			}else{
				$selisih=$stok-$cstok;
				if ($selisih>0){
					if ($hargab==0){
						echo "<script>alert('Obat Tersebut Belum Ada Harganya');</script>";
					}else{
						$sql="select STOK_AFTER from a_kartustok where OBAT_ID=$obat_id and KEPEMILIKAN_ID=$kepemilikan_id and UNIT_ID=$idunit order by TGL_TRANS desc,ID desc limit 1";
						$rs=mysqli_query($konek,$sql);
						$cstk_bfr=0;
						if ($rows=mysqli_fetch_array($rs)){
							$cstk_bfr=$rows['STOK_AFTER'];
						}
						$cstk_after=$cstk_bfr+$selisih;
						$sql="insert into a_kartustok(OBAT_ID,KEPEMILIKAN_ID,UNIT_ID,TGL_TRANS,TGL_ACT,NO_BUKTI,STOK_BEFOR,DEBET,KREDIT,STOK_AFTER,KET,USER_ID) values($obat_id,$kepemilikan_id,$idunit,'$tgl2','$tgl_act','',$cstk_bfr,$selisih,0,$cstk_after,'Stok Opname',$iduser)";
						//echo $sql;
						$rs=mysqli_query($konek,$sql);
						$sql="insert into a_penerimaan(OBAT_ID,UNIT_ID_TERIMA,KEPEMILIKAN_ID,USER_ID_KIRIM,TANGGAL_ACT,TANGGAL,QTY_SATUAN,QTY_STOK,HARGA_BELI_SATUAN,TIPE_TRANS,STATUS) values($obat_id,$idunit,$kepemilikan_id,$iduser,'$tgl_act','$tgl2',$selisih,$selisih,$hargab,5,1)";
						//echo $sql."<br>";
						$rs=mysqli_query($konek,$sql);
						$sql="select ID from a_penerimaan where UNIT_ID_TERIMA=$idunit and USER_ID_KIRIM=$iduser and TANGGAL='$tgl2' and TANGGAL_ACT='$tgl_act' order by ID desc limit 1";
						//echo $sql."<br>";
						$rs=mysqli_query($konek,$sql);
						if ($rows=mysqli_fetch_array($rs)){
							$cid=$rows['ID'];
							$sql="insert into a_stok_opname(idunit,iduser,idpenerimaan,idobat,kepemilikan_id,stok,opname,adjust,qty,harga_satuan,tgl,tgl_act) values($idunit,$iduser,$cid,$obat_id,$kepemilikan_id,$cstok,$stok,$stok-$cstok,$selisih,$hargab,'$tgl2','$tgl_act')";
							//echo $sql."<br>";
							$rs1=mysqli_query($konek,$sql);
						}
					}
				}else{
					$sql="insert into a_stok_opname(idunit,iduser,idpenerimaan,idobat,kepemilikan_id,stok,opname,adjust,qty,harga_satuan,tgl,tgl_act) values($idunit,$iduser,0,$obat_id,$kepemilikan_id,$cstok,$stok,$stok-$cstok,$selisih,$hargab,'$tgl2','$tgl_act')";
					//echo $sql."<br>";
					$rs1=mysqli_query($konek,$sql);				
				}
			}
		}
		break;
}
//Aksi Save, Edit, Delete Berakhir ============================================
?>
<html>
<head>
<title>Sistem Informasi Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<!--script src="../theme/js/noklik.js" type="text/javascript"></script-->
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
<script language="JavaScript" type="text/JavaScript">
var RowIdx;
var fKeyEnt;
function suggest(e,par){
var keywords=par.value;//alert(keywords);
	if(keywords==""){
		document.getElementById('divobat').style.display='none';
	}else{
		var key;
		if(window.event) {
		  key = window.event.keyCode; 
		}
		else if(e.which) {
		  key = e.which;
		}
		//alert(key);
		if (key==38 || key==40){
			var tblRow=document.getElementById('tblObat').rows.length;
			if (tblRow>0){
				//alert(RowIdx);
				if (key==38 && RowIdx>0){
					RowIdx=RowIdx-1;
					document.getElementById(RowIdx+1).className='itemtableReq';
					if (RowIdx>0) document.getElementById(RowIdx).className='itemtableMOverReq';
				}else if (key==40 && RowIdx<tblRow){
					RowIdx=RowIdx+1;
					if (RowIdx>1) document.getElementById(RowIdx-1).className='itemtableReq';
					document.getElementById(RowIdx).className='itemtableMOverReq';
				}
			}
		}else if (key==13){
			if (RowIdx>0){
				if (fKeyEnt==false){
					fSetObat(document.getElementById(RowIdx).lang);
				}else{
					fKeyEnt=false;
				}
			}
		}else if (key!=27 && key!=37 && key!=39){
			RowIdx=0;
			fKeyEnt=false;
			Request('../transaksi/obatlist.php?aKepemilikan=0&idunit=<?php echo $idunit; ?>&aKeyword='+keywords , 'divobat', '', 'GET' );
			if (document.getElementById('divobat').style.display=='none') fSetPosisi(document.getElementById('divobat'),par);
			document.getElementById('divobat').style.display='block';
		}
	}
}

function fSetObat(par){
var cdata=par.split("*|*");
var tbl = document.getElementById('tblJual');
var tds;
	document.forms[0].obatid.value=cdata[1];
	document.forms[0].txtObat.value=cdata[2];
	document.getElementById('divobat').style.display='none';
}
</script>
</head>
<body>
<div id="divobat" align="left" style="position:absolute; z-index:1; left: 100px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
  <input name="stok1" id="stok1" type="hidden" value="">
  <input name="ada_data" id="ada_data" type="hidden" value="">
  <input name="sdh_so" id="sdh_so" type="hidden" value="">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
	<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
	<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <div id="input" style="display:none">
	  <p class="jdltable">Input Data Stok Obat / Alkes</p>
	  <table width="65%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
        <tr> 
          <td width="180">Nama Obat</td>
          <td width="10">:</td>
          <td > <input name="obatid" id="obat_id" type="hidden" value=""> <input type="text" name="txtObat" id="obat_nama" class="txtinput" size="65" onKeyUp="suggest(event,this);" autocomplete="off" /> 
          </td>
        </tr>
        <tr> 
          <td>Kepemilikan</td>
          <td>:</td>
          <td ><select name="kepemilikan_id" id="kepemilikan_id" class="txtinput">
              <?
		  $qry="select * from a_kepemilikan where aktif=1";
		  $exe=mysqli_query($konek,$qry);
		  while($show=mysqli_fetch_array($exe)){ 
		  ?>
              <option value="<?php echo $show['ID'];?>" class="txtinput"> 
              <?php echo $show['NAMA'];?></option>
              <? }?>
            </select></td>
        </tr>
        <tr> 
          <td>Stok Opname</td>
          <td>:</td>
          <td ><input name="stok" type="text" class="txtcenter" id="stok" size="8" maxlength="11" ></td>
        </tr>
        <tr> 
          <td colspan="3"><hr></td>
        </tr>
        <tr> 
          <td><input type="checkbox" name="chkupdt" value="checkbox" onClick="if (this.checked){hpp.disabled='';profit.disabled='';}else{hpp.disabled='true';profit.disabled='true';}">
            Update Master Harga</td>
          <td>&nbsp;</td>
          <td >&nbsp;</td>
        </tr>
        <tr> 
          <td>Harga Pokok Pembelian</td>
          <td>:</td>
          <td ><input name="hpp" type="text" class="txtright" id="hpp" size="8" maxlength="11" disabled="true" ></td>
        </tr>
        <tr> 
          <td>Keuntungan</td>
          <td>:</td>
          <td ><input name="profit" type="text" class="txtcenter" id="profit" size="5" maxlength="5" disabled="true" >
            %</td>
        </tr>
        <!--tr> 
		  <td>Keterangan</td>
		  <td>:</td>
		  <td ><textarea name="ket" cols="40" class="txtinput" id="ket"></textarea></td>
		</tr-->
      </table>
  <p><BUTTON type="button" onClick="if (ValidateForm('stok,obat_id,obat_nama','ind')){fSubmit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>&nbsp;<BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('listma').style.display='block';fSetValue(window,'act*-*save');"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
  </div>
  <!-- TAMPILAN TABEL DAFTAR UNIT -->
  <div id="listma" style="display:block">
	  <p><span class="jdltable">DAFTAR STOK OPNAME OBAT / ALKES</span> 
      <table width="98%" cellpadding="0" cellspacing="0" border="0">
		<tr>
		  <td width="716"><span class="txtinput">Unit : </span>
			<select name="idunit" id="idunit" class="txtinput" onChange="location='?f=../transaksi/stok&idunit='+idunit.value+'&bulan='+bulan.value+'&ta='+ta.value"<?php if (($unit_tipe<>1)&&($unit_tipe<>4)) echo " disabled";?>>
			  <?
		  $qry="select * from a_unit where UNIT_TIPE<>4 and UNIT_TIPE<>3 and UNIT_ISAKTIF=1";
		  $exe=mysqli_query($konek,$qry);
		  $i=0;
		  while($show=mysqli_fetch_array($exe)){ 
			$i++;
			if (($idunit=="")&&($i==1)) $idunit=$show['UNIT_ID'];
			//if ($i==1) $idunit=$show['UNIT_ID'];
		  ?>
			  <option value="<?php echo $show['UNIT_ID'];?>" class="txtinput"<?php if ($idunit==$show['UNIT_ID']) echo "selected";?>> <?php echo $show['UNIT_NAME'];?></option>
			  <? }?>
			</select>&nbsp;&nbsp;&nbsp;<span class="txtinput">Bulan : </span> 
            <select name="bulan" id="bulan" class="txtinput" onChange="location='?f=../transaksi/stok&idunit='+idunit.value+'&bulan='+bulan.value+'&ta='+ta.value">
              <option value="1" class="txtinput"<?php if ($bulan=="1") echo "selected";?>>Januari</option>
              <option value="2" class="txtinput"<?php if ($bulan=="2") echo "selected";?>>Pebruari</option>
              <option value="3" class="txtinput"<?php if ($bulan=="3") echo "selected";?>>Maret</option>
              <option value="4" class="txtinput"<?php if ($bulan=="4") echo "selected";?>>April</option>
              <option value="5" class="txtinput"<?php if ($bulan=="5") echo "selected";?>>Mei</option>
              <option value="6" class="txtinput"<?php if ($bulan=="6") echo "selected";?>>Juni</option>
              <option value="7" class="txtinput"<?php if ($bulan=="7") echo "selected";?>>Juli</option>
              <option value="8" class="txtinput"<?php if ($bulan=="8") echo "selected";?>>Agustus</option>
              <option value="9" class="txtinput"<?php if ($bulan=="9") echo "selected";?>>September</option>
              <option value="10" class="txtinput"<?php if ($bulan=="10") echo "selected";?>>Oktober</option>
              <option value="11" class="txtinput"<?php if ($bulan=="11") echo "selected";?>>Nopember</option>
              <option value="12" class="txtinput"<?php if ($bulan=="12") echo "selected";?>>Desember</option>
            </select>
            <span class="txtinput">Tahun : </span> 
            <select name="ta" id="ta" class="txtinput" onChange="location='?f=../transaksi/stok&idunit='+idunit.value+'&bulan='+bulan.value+'&ta='+ta.value">
            <?php for ($i=($th[2]-5);$i<($th[2]+1);$i++){ ?>
              <option value="<?php echo $i; ?>" class="txtinput"<?php if ($i==$ta) echo "selected";?>><?php echo $i;?></option>
            <? }?>
            </select></td>
		  <td width="243" align="right">
		  <!--BUTTON type="button" onClick="if (confirm('Benar Ingin Mengimport Data Stok Sekarang ?')){fSetValue(window,'act*-*import');document.form1.submit();}"<?php //if (($bulan!=$bln)||($ta!=$th[2])) echo " disabled";?>><IMG SRC="../icon/find.png" border="0" width="18" height="18" ALIGN="absmiddle">&nbsp;Import Data Stok</BUTTON-->
		  <BUTTON type="button" onClick="document.getElementById('input').style.display='block'; fSetValue(window,'act*-*save*|*stok*-*');hpp.disabled='true';profit.disabled='true';chkupdt.checked='';"<?php if (($bulan!=$bln)||($ta!=$th[2])) echo " disabled";?>><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah</BUTTON>
		  </td>
		</tr>
	</table>
	  <table width="98%" border="0" cellpadding="1" cellspacing="0">
        <tr class="headtable"> 
          <td width="30" height="25" class="tblheaderkiri">No</td>
          <td id="OBAT_KODE" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            Obat </td>
          <td id="OBAT_NAMA" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Obat </td>
          <td id="NAMA" width="100" class="tblheader" onClick="ifPop.CallFr(this);">Kepemilikan</td>
          <td id="stok" width="60" class="tblheader" onClick="ifPop.CallFr(this);">Stok</td>
          <td id="adjust" width="50" class="tblheader" onClick="ifPop.CallFr(this);">Adjust</td>
          <td id="sdh_so" width="50" class="tblheader" onClick="ifPop.CallFr(this);">Sdh 
            Stok Opname</td>
          <td class="tblheader" width="30">Proses</td>
        </tr>
        <?php 
	  if ($filter!=""){
		$filter=explode("|",$filter);
		$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  if (($bulan!=$bln)||($ta!=$th[2]))
	  		$sql="select ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.ID,ak.NAMA,so.stok,so.adjust,1 as sdh_so,sum(so.qty*so.harga_satuan) as nilai from a_stok_opname so inner join a_obat ao on so.idobat=ao.OBAT_ID inner join a_kepemilikan ak on so.kepemilikan_id=ak.ID where so.idunit=$idunit and month(so.tgl)=$bulan and year(so.tgl)=$ta".$filter." group by so.idobat,so.kepemilikan_id,so.stok,so.opname order by ".$sorting;
	  else
	  		$sql="select t1.*,if (t2.adjust is null,0,t2.adjust) as adjust,if (t2.adjust is null,0,1) as sdh_so from (select ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.ID,ak.NAMA,sum(ap.QTY_STOK) as stok,sum(ap.QTY_STOK*ap.HARGA_BELI_SATUAN) as nilai from a_penerimaan ap inner join a_obat ao on ap.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on ap.KEPEMILIKAN_ID=ak.ID where UNIT_ID_TERIMA=$idunit and ao.OBAT_ISAKTIF=1 and STATUS=1 and QTY_STOK>0".$filter." group by ao.OBAT_NAMA,ak.ID) as t1 left join (select distinct idobat,kepemilikan_id,adjust from a_stok_opname where idunit=$idunit and month(tgl)=$bulan and year(tgl)=$ta) as t2 on concat(t1.OBAT_ID,t1.ID)=concat(t2.idobat,t2.kepemilikan_id) order by ".$sorting;
	  //echo $sql;
		$rs=mysqli_query($konek,$sql);
		$jmldata=mysqli_num_rows($rs);
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";

	  $rs=mysqli_query($konek,$sql);
	  $i=($page-1)*$perpage;
	  $arfvalue="";
	  while ($rows=mysqli_fetch_array($rs)){
		$i++;
		$csdh_so=$rows['sdh_so'];
		$cadjust=$rows['adjust'];
		$arfvalue="act*-*edit*|*stok1*-*".$rows['stok']."*|*obat_id*-*".$rows['OBAT_ID']."*|*obat_nama*-*".$rows['OBAT_NAMA']."*|*kepemilikan_id*-*".$rows['ID']."*|*stok*-*".$rows['stok']."*|*sdh_so*-*".$rows['sdh_so'];
		
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
		
		$arfhapus="act*-*delete*|*harga_id*-*".$rows['HARGA_ID'];
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['OBAT_KODE']; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['NAMA']; ?></td>
          <td class="tdisi" align="center"><?php echo $rows['stok'];?></td>
          <td class="tdisi" align="center"><?php echo $cadjust;?></td>
          <td class="tdisi" align="center"><?php if ($csdh_so==1){?><img src="../icon/save.ico" border="0" width="16" height="16" align="absmiddle" title="Sudah Stok Opname"><?php }else echo "-";?></td>
          <td width="30" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Memasukkan Data Stok Opname" onClick="<?php if (($bulan!=$bln)||($ta!=$th[2])){?>alert('Data Stok Opname Terdahulu Tidak Boleh Diubah !');<?php }else{?>document.getElementById('input').style.display='block';fSetValue(window,'<?php echo $arfvalue; ?>');<?php }?>"></td>
        </tr>
        <?php 
	  }
	  mysqli_free_result($rs);
	  if ($i>0) echo "<script>document.forms[0].ada_data.value='true';</script>";
	  ?>
        <tr> 
          <td colspan="3" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="7" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
          </td>
        </tr>
      </table>
	</div>
</form>
</div>
<script>
function fSubmit(){
	if (document.forms[0].chkupdt.checked){
		if (ValidateForm('hpp,profit','ind')){
			document.form1.submit();
		}
	}else{
		document.form1.submit();
	}
}
</script>
</body>
</html>
<?php 
mysqli_close($konek);
?>