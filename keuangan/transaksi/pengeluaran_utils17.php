<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$bln = $_REQUEST['bln'];
$thn = $_REQUEST['thn'];
$bln_in = $_REQUEST['bln_in'];
$thn_in = $_REQUEST['thn_in'];
$tgl = tglSQL($_REQUEST['tgl']);
$stBayar = $_REQUEST['stBayar'];
$ViewBayar = $_REQUEST['ViewBayar'];
$id_trans = $_REQUEST['id_trans'];
$nobukti = $_REQUEST['nobukti'];
$ket = $_REQUEST['ket'];
$nilai = $_REQUEST['nilai'];
$nilai_sim = $_REQUEST['nilai_sim'];
if ($nilai_sim=="") $nilai_sim=0;
$jenis_supplier = $_REQUEST['jenis_supplier'];
$supplier_id = $_REQUEST['suplier_id'];
$nofaktur = $_REQUEST['nofaktur'];
$jenis_layanan = $_REQUEST['jenis_layanan'];
$unit_id = $_REQUEST['unit_id'];
if ($id_trans==8 || $id_trans==9 || $id_trans==10 || $id_trans==15){
	$jenis_layanan=0;
	$unit_id=0;
}
$tgl_act = 'now()';
$user_act = $_REQUEST['user_act'];
$id = $_REQUEST['id'];
$idma= $_REQUEST['idMa'];
//===============================
$statusProses='';
$pilihan = strtolower($_REQUEST["pilihan"]);
$act = strtolower(($_REQUEST['act']));
switch($act){
    case 'add':
	   $insert = true;
	   if($id_trans == 11){
		  $sql = "select id from k_transaksi where id_trans = '$id_trans' and no_faktur = '$nofaktur'";
		  $rs = mysql_query($sql);
		  if(mysql_num_rows($rs) <= 0){
				if($jenis_supplier=='1'){
					$sql="update ".$dbapotek.".a_penerimaan p set bayar = 1 WHERE p.TIPE_TRANS=0 AND p.STATUS=1 AND p.BATCH='$nofaktur' AND p.bayar = 0";
				}
				else if($jenis_supplier=='2'){
			    	$sql = "UPDATE $dbaset.as_masuk m,dbaset.as_po po SET m.bayar=1 WHERE m.po_id=po.id AND po.no_spk='$nofaktur'";
				}
				//echo $sql."<br>";
				$rs = mysql_query($sql);
		  }
		  else{
				$insert = false;
		  }
	   }
	   
	   //$sql = "select id from k_transaksi where id_trans = '$id_trans', ";
	   if($insert == true){
		  $sql = "insert into ".$dbkeuangan.".k_transaksi (id_trans,tgl,no_bukti,no_faktur,jenis_supplier,supplier_id,jenis_layanan,unit_id,nilai_sim,nilai
				,ket,tgl_act,user_act, id_ma_dpa )
				values ('$id_trans', '$tgl', '$nobukti', '$nofaktur','$jenis_supplier', '$supplier_id', '$jenis_layanan', '$unit_id','$nilai_sim', '$nilai'
				, '$ket', $tgl_act, '$user_act', $idma)";
		  //echo $sql."<br>";
		  $rs = mysql_query($sql);
		  if (mysql_errno()==0){
			  $transaksi_id = mysql_insert_id();
			  $fdata = $_REQUEST['fdata'];
			  $temp = explode("|",$fdata);
			  for($i=1;$i<=count($temp)-1;$i++){
					$tmp = explode("*",$temp[$i]);
					$sql2 = "insert into ".$dbkeuangan.".k_transaksi_detail (transaksi_id,jenis_layanan_id,unit_id,nilai) values ('$transaksi_id','$tmp[0]','$tmp[1]','$tmp[2]')";
					mysql_query($sql2);
			  }
		  }
	   }
        break;
    case 'edit':
	   //$sama = variable untuk cek kesamaan antara id_trans / supplier_id sebelumnya dan sekarang, defaultnya false.
	   $sama = false;
	   //jika id_trans sebelumnya = 11 & id_trans sekarang != 11
	   $sql = "select no_faktur, supplier_id, month(tgl) as bln, year(tgl) as thn from k_transaksi where id = '$id' and id_trans = 11";
	   $rs = mysql_query($sql);
	   if(mysql_num_rows($rs) > 0){
		  //$rollback = variable untuk cek perlu tidaknya mengembalikan value bayar di a_penerimaan menjadi 0
		  //, defaultnya false berarti tidak melakukan rollback.
		  $rollback = false;
		  $row = mysql_fetch_array($rs);
		  if($id_trans != 11){
			 //karena id_trans sebelumnya != id_trans sekarang maka perlu melakukan rollback.
			 $rollback = true;
		  }
		  else{
			 //karena id_trans sebelumnya = id_trans sekarang, maka $sama = true.
			 $sama = true;
			 if(($row['supplier_id'] != $supplier_id) || ($row['no_faktur']!=$nofaktur)){
				//karena supplier_id sebelumnya != supplier_id sekarang, maka sama = false;
				$sama = false;
			 }
		  }
		  if($rollback == true || $sama == false){
		    if($jenis_supplier=='1'){
			 	$sql = "update ".$dbapotek.".a_penerimaan p set bayar = 0 WHERE p.TIPE_TRANS=0 AND p.STATUS=1 AND p.BATCH='".$row['no_faktur']."' AND p.bayar = 1";
			}
		   	else if($jenis_supplier=='2'){
		       	$sql = "update ".$dbaset.".as_masuk m set bayar = 0
				      WHERE m.po_id in (SELECT id FROM  ".$dbaset.".as_po where no_po='".$row['no_faktur']."' ) and bayar = 1";
		   	}
			$rs = mysql_query($sql);
		  }
	   }
	   
	   //jika id_trans sebelumnya != 11 & id_trans sekarang = 11
	   if($id_trans == 11 && $sama == false){
	    	if($jenis_supplier=='1'){
		  		$sql = "update ".$dbapotek.".a_penerimaan p set bayar = 1 WHERE WHERE p.TIPE_TRANS=0 AND p.STATUS=1 AND p.BATCH='".$nofaktur."' and bayar = 0";
	    	}
	    	else if($jenis_supplier=='2'){
				$sql = " update ".$dbaset.".as_masuk m set bayar = 1 
				WHERE m.po_id in (SELECT id FROM  ".$dbaset.".as_po where no_po='".$nofaktur."' ) and bayar = 0";
	    	}
		  	$rs = mysql_query($sql);
	   }
	   
	   $sql = "update ".$dbkeuangan.".k_transaksi set id_trans = '$id_trans', tgl = '$tgl', no_bukti = '$nobukti', no_faktur = '$nofaktur'
		  ,jenis_supplier='$jenis_supplier', supplier_id = '$supplier_id', jenis_layanan = '$jenis_layanan', unit_id = '$unit_id', nilai_sim = '$nilai_sim', nilai = '$nilai'
		  , ket = '$ket'
		  where id = '$id'";
	   $rs = mysql_query($sql);
	   
	      $transaksi_id = $id;
		  $sqldel="delete from k_transaksi_detail where transaksi_id=".$transaksi_id;
		  mysql_query($sqldel);
		  $fdata = $_REQUEST['fdata'];
		  $temp = explode("|",$fdata);
		  for($i=1;$i<=count($temp)-1;$i++){
				$tmp = explode("*",$temp[$i]);
				$sql2 = "insert into ".$dbkeuangan.".k_transaksi_detail (transaksi_id,jenis_layanan_id,unit_id,nilai) values ('$transaksi_id','$tmp[0]','$tmp[1]','$tmp[2]')";
				mysql_query($sql2);
		  }
        break;
    case 'hapus':
	   $sql = "select no_faktur, jenis_supplier from k_transaksi where id = '$id' and id_trans = 11";
	   //echo $sql."<br>";
	   $rs = mysql_query($sql);
	   if(mysql_num_rows($rs) > 0){
		  $row = mysql_fetch_array($rs);
		  $jenis_supplier=$row['jenis_supplier'];
		  if($jenis_supplier=='1'){
				$sql = "update ".$dbapotek.".a_penerimaan p set bayar = 0 WHERE p.TIPE_TRANS=0 AND p.STATUS=1 AND p.BATCH='".$row['no_faktur']."' AND p.bayar = 1";
		  }
		  else if($jenis_supplier=='2'){
				$sql = "update ".$dbaset.".as_masuk m set bayar = 0
					WHERE m.po_id in (SELECT id FROM  ".$dbaset.".as_po where no_po='".$row['no_faktur']."' ) and bayar = 1";
		  }
		  //echo $sql."<br>";
		  $rs = mysql_query($sql);
	   }
	   
	   $sql = "delete from ".$dbkeuangan.".k_transaksi where id = '$id'";
	   $rs = mysql_query($sql);
	   $sqldel = "delete from ".$dbkeuangan.".k_transaksi_detail where transaksi_id = '$id'";
	   mysql_query($sqldel);
	   break;
    case 'pengeluaranlain2':
		$iduser=24;//user dr posting keuangan
		$noBukti = $_REQUEST['noBukti'];
		$TglBayar = tglSQL($_REQUEST['TglBayar']);
		$TglBayarPajak = $_REQUEST['TglBayarPajak'];
		if ($TglBayarPajak!="") $TglBayarPajak = tglSQL($TglBayarPajak);
		$tcaraBayar = $_REQUEST['tcaraBayar'];
		$fdata = $_REQUEST['fdata'];
		$arfdata = explode(chr(5),$fdata);
		$dataTrans = explode(chr(6),$arfdata[1]);
		for ($j=0;$j<count($dataTrans);$j++){
			$id = $dataTrans[$j];
			$sql = "select * from ".$dbkeuangan.".k_transaksi where id = '$id' and verifikasi = 1";
			//echo $sql."<br>";
			$rs = mysql_query($sql);
			if(mysql_num_rows($rs) > 0){
				$row = mysql_fetch_array($rs);
				$id_trans = $row['id_trans'];
				$sql = "update ".$dbkeuangan.".k_transaksi set no_bukti='$noBukti',tgl='$TglBayar',posting=1 where id = '$id'";
				//echo $sql."<br>";
				$rs1 = mysql_query($sql);
				switch ($id_trans){
					case 11:
						//=========== id_trans=11 --> Pembayaran Hutang Supplier --> Posting Akuntansi============
						$jenis_supplier=$row['jenis_supplier'];
						if($jenis_supplier=='1'){
							// jenis_supplier = 1 = Supplier Obat
							$nilai=$row["nilai"];
							$selisih=$row["nilai_sim"]-$nilai;
							$tgl=$TglBayar;
							$nokw=$noBukti;
							$pbf_umumId=$row["supplier_id"];
							$uraian="Posting Pembayaran Supplier Obat : ";
							
							$sql="SELECT * FROM ".$dbapotek.".a_pbf WHERE PBF_ID=$pbf_umumId";
							$rs1=mysql_query($sql);
							$rows=mysql_fetch_array($rs1);
							$uraian .=$rows["PBF_NAMA"];
							
							if ($selisih<>0){
								// jtrans = 24 = Terjadi Pengurang Pembelian, Jika Transaksi Belum Terbayar
								// jtrans = 23 = Terjadi Penambah Pembelian, Jika Transaksi Belum Terbayar
								// ma_d = 378 = Hutang Usaha Kpd Supplier Obat & Alkes
								// ma_k = 67 = Persediaan Obat & Alkes
								$jtrans=24;
								$ma_d=378;
								$ma_k=67;
								if ($selisih<0){
									$jtrans=23;
									$ma_k=378;
									$ma_d=67;
									$selisih=$selisih * -1;
								}
								
								$uraian_selisih = $uraian." - Selisih (SIM - SPK)";
								
								$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
								//echo $sql."<br>";
								$rs1=mysql_query($sql);
								$no_trans=1;
								if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
								
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_d,'$tgl','$nokw','$uraian_selisih',$selisih,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,$pbf_umumId,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
								
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_k,'$tgl','$nokw','$uraian_selisih',0,$selisih,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
							}
							
							// jtrans = 26 = Pembayaran Pembelian Obat
							// ma_d = 378 = Hutang Usaha Kpd Supplier Obat & Alkes
							// ma_k = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
							$jtrans=26;
							$ma_d=378;
							$ma_k=10;
							if ($tcaraBayar==2) $ma_k=31;
							
							$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);
							$no_trans=1;
							if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
							
							$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_d,'$tgl','$nokw','$uraian',$nilai,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,$pbf_umumId,1)";
							//echo $sql."<br>";
							$rs1 = mysql_query($sql);
							
							$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_k,'$tgl','$nokw','$uraian',0,$nilai,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
							//echo $sql."<br>";
							$rs1 = mysql_query($sql);
							
							if ($arfdata[0]!=""){
								// jtrans = 27 = Penerimaan PPN & PPH
								// ma_k1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
								// ma_k2 = 389 = Pajak penghasilan pasal 22
								// ma_d = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
								$jtrans=27;
								$ma_d=10;
								$ma_dPajak=10;
								if ($tcaraBayar==2) $ma_d=31;
								$ma_k1=394;
								$ma_k2=389;
								
								$arpajak=explode(chr(6),$arfdata[0]);
								
								//$dpp=100/110 * $nilai;
								//$ppn=10/110 * $nilai;
								$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
								$rs1=mysql_query($sql);
								$no_trans=1;
								if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
								
								$nilai2=0;
								for ($i=0;$i<count($arpajak);$i++){
									$dataPajak=explode("|",$arpajak[$i]);
									if ($dataPajak[0]==394){
										//$nilai1=$ppn;
										$nilai1=$dataPajak[1];
										$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$tgl','$nokw','$uraian',0,$nilai1,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
										//echo $sql."<br>";
										$rs1 = mysql_query($sql);
									}else{
										//$nilai1=$dataPajak[1]/100 * $dpp;
										$nilai1=$dataPajak[1];
										$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$tgl','$nokw','$uraian',0,$nilai1,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
										//echo $sql."<br>";
										$rs1 = mysql_query($sql);
									}
									
									$nilai2 +=$nilai1;
								}
								
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_dPajak,'$tgl','$nokw','$uraian',$nilai2,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
								
								if ($TglBayarPajak!=""){
									// jtrans = 94 = Pembayaran Hutang Pajak Pertambahan Nilai (PPN)
									// ma_d1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
									// ma_d2 = 389 = Pajak penghasilan pasal 22
									// ma_k = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
									$jtrans=94;
									$ma_k=10;
									$ma_kPajak=10;
									if ($tcaraBayar==2) $ma_k=31;
									$ma_d1=394;
									$ma_d2=389;
									
									$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
									//echo $sql."<br>";
									$rs1=mysql_query($sql);
									$no_trans=1;
									if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
									
									$nilai2=0;
									for ($i=0;$i<count($arpajak);$i++){
										$dataPajak=explode("|",$arpajak[$i]);
										//if ($dataPajak[0]==394){
											//$nilai1=$ppn;
											$nilai1=$dataPajak[1];
											$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$TglBayarPajak','$nokw','$uraian',$nilai1,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
											//echo $sql."<br>";
											$rs1 = mysql_query($sql);
										/*}else{
											//$nilai1=$dataPajak[1]/100 * $dpp;
											$nilai1=$dataPajak[1];
											$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$TglBayarPajak','$nokw','$uraian',$nilai1,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
											//echo $sql."<br>";
											$rs1 = mysql_query($sql);
										}*/
										
										$nilai2 +=$nilai1;
									}
									
									$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_kPajak,'$TglBayarPajak','$nokw','$uraian',0,$nilai2,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
									//echo $sql."<br>";
									$rs1 = mysql_query($sql);
								}
							}
						}
						else if($jenis_supplier=='2'){
							// jenis_supplier = 2 = Supplier Barang Umum
							$nilai=$row["nilai"];
							$selisih=$row["nilai_sim"]-$nilai;
							$tgl=$TglBayar;
							$nokw=$noBukti;
							$pbf_umumId=$row["supplier_id"];
							$uraian="Posting Pembayaran Supplier Barang Umum/HP : ";
							
							$sql="SELECT * FROM ".$dbaset.".as_ms_rekanan WHERE idrekanan=$pbf_umumId";
							$rs1=mysql_query($sql);
							$rows=mysql_fetch_array($rs1);
							$uraian .=$rows["namarekanan"];
							
							if ($selisih<>0){
								// jtrans = 289 = Terjadi Pengurang Pembelian, Jika Transaksi Belum Terbayar
								// jtrans = 288 = Terjadi Penambah Pembelian, Jika Transaksi Belum Terbayar
								// ma_d = 379 = Hutang Usaha Kpd Supplier Obat & Alkes
								// ma_k = 78 = Persediaan ATK
								$jtrans=289;
								$ma_d=379;
								$ma_k=78;
								if ($selisih<0){
									$jtrans=288;
									$ma_k=379;
									$ma_d=78;
									$selisih=$selisih * -1;
								}
								
								$uraian_selisih = $uraian." - Selisih (SIM - SPK)";
								
								$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
								//echo $sql."<br>";
								$rs1=mysql_query($sql);
								$no_trans=1;
								if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
								
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_d,'$tgl','$nokw','$uraian_selisih',$selisih,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,$pbf_umumId,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
								
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_k,'$tgl','$nokw','$uraian_selisih',0,$selisih,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
							}
							
							// jtrans = 291 = Pembayaran Pembelian ATK
							// ma_d = 379 = Hutang Usaha Kpd Supplier Umum
							// ma_k = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
							$jtrans=291;
							$ma_d=379;
							$ma_k=10;
							if ($tcaraBayar==2) $ma_k=31;
							
							$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);
							$no_trans=1;
							if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
							
							$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_d,'$tgl','$nokw','$uraian',$nilai,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,$pbf_umumId,1)";
							//echo $sql."<br>";
							$rs1 = mysql_query($sql);
							
							$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_k,'$tgl','$nokw','$uraian',0,$nilai,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
							//echo $sql."<br>";
							$rs1 = mysql_query($sql);
							
							if ($arfdata[0]!=""){
								// jtrans = 27 = Penerimaan PPN & PPH
								// ma_k1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
								// ma_k2 = 389 = Pajak penghasilan pasal 22
								// ma_d = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
								$jtrans=27;
								$ma_d=10;
								$ma_dPajak=10;
								if ($tcaraBayar==2) $ma_d=31;
								$ma_k1=394;
								$ma_k2=389;
								
								$arpajak=explode(chr(6),$arfdata[0]);
								
								//$dpp=100/110 * $nilai;
								//$ppn=10/110 * $nilai;
								$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
								$rs1=mysql_query($sql);
								$no_trans=1;
								if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
								
								$nilai2=0;
								for ($i=0;$i<count($arpajak);$i++){
									$dataPajak=explode("|",$arpajak[$i]);
									if ($dataPajak[0]==394){
										//$nilai1=$ppn;
										$nilai1=$dataPajak[1];
										$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$tgl','$nokw','$uraian',0,$nilai1,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
										//echo $sql."<br>";
										$rs1 = mysql_query($sql);
									}else{
										//$nilai1=$dataPajak[1]/100 * $dpp;
										$nilai1=$dataPajak[1];
										$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$tgl','$nokw','$uraian',0,$nilai1,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
										//echo $sql."<br>";
										$rs1 = mysql_query($sql);
									}
									
									$nilai2 +=$nilai1;
								}
								
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_dPajak,'$tgl','$nokw','$uraian',$nilai2,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
								
								if ($TglBayarPajak!=""){
									// jtrans = 94 = Pembayaran Hutang Pajak Pertambahan Nilai (PPN)
									// ma_d1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
									// ma_d2 = 389 = Pajak penghasilan pasal 22
									// ma_k = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
									$jtrans=94;
									$ma_k=10;
									$ma_kPajak=10;
									if ($tcaraBayar==2) $ma_k=31;
									$ma_d1=394;
									$ma_d2=389;
									
									$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
									//echo $sql."<br>";
									$rs1=mysql_query($sql);
									$no_trans=1;
									if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
									
									$nilai2=0;
									for ($i=0;$i<count($arpajak);$i++){
										$dataPajak=explode("|",$arpajak[$i]);
										//if ($dataPajak[0]==394){
											//$nilai1=$ppn;
											$nilai1=$dataPajak[1];
											$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$TglBayarPajak','$nokw','$uraian',$nilai1,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
											//echo $sql."<br>";
											$rs1 = mysql_query($sql);
										/*}else{
											//$nilai1=$dataPajak[1]/100 * $dpp;
											$nilai1=$dataPajak[1];
											$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$TglBayarPajak','$nokw','$uraian',$nilai1,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
											//echo $sql."<br>";
											$rs1 = mysql_query($sql);
										}*/
										
										$nilai2 +=$nilai1;
									}
									
									$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_kPajak,'$TglBayarPajak','$nokw','$uraian',0,$nilai2,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
									//echo $sql."<br>";
									$rs1 = mysql_query($sql);
								}
							}
						}
						
						break;
					case 8:
						//=========== id_trans=8 --> Pembayaran Gaji PNS --> Posting Akuntansi ============
						//$nilai=$row["nilai"];
						//$selisih=$row["nilai_sim"]-$nilai;
						$tgl=$TglBayar;
						$nokw=$noBukti;
						$uraian="Posting Gaji PNS : ";
						
						//;
						$sql="SELECT * FROM k_transaksi_detail WHERE transaksi_id='$id' AND pajak_id=0";
						$rsCC_RV=mysql_query($sql);
						if (mysql_num_rows($rsCC_RV)>0){
							$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);
							$no_trans=1;
							if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
								
							// jtrans = 109 = Pembayaran Gaji PNS (Biaya Pokok Pelayanan)
							// jtrans = 101 = Pembayaran Gaji PNS (Biaya Administrasi & Umum)
							// ma_d = 541 = Biaya Gaji PNS (Biaya Pokok Pelayanan)
							// ma_d = 622 = Biaya Gaji PNS (Biaya Administrasi & Umum)
							// ma_k = 10 = Kas Bendahara Pengeluaran, 33 = Bank Jatim - R/K 0261019205 (Bank BLUD)
							$jtrans=109;
							$ma_d=541;
							$ma_k=33;
							if ($tcaraBayar==1) $ma_k=10;
							
							$nilaiTot=0;
							while ($rwCC_RV=mysql_fetch_array($rsCC_RV)){
								$nilai=$rwCC_RV["nilai"];
								$nilaiTot +=$nilai;
								$cc_rv=$rwCC_RV["unit_id"];
								$sql="SELECT id idcc,nama FROM ".$dbakuntansi.".ak_ms_unit WHERE id=$cc_rv";
								$rs1=mysql_query($sql);
								$rows=mysql_fetch_array($rs1);
								$uraian1=$uraian.$rows["nama"];
								$cc_rv_ak=$rows["idcc"];
								
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_d,'$tgl','$nokw','$uraian1',$nilai,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,$cc_rv_ak,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
							}
							
							$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_k,'$tgl','$nokw','$uraian',0,$nilaiTot,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
							//echo $sql."<br>";
							$rs1 = mysql_query($sql);

							if ($arfdata[0]!=""){
								// jtrans = 27 = Penerimaan PPN & PPH
								// ma_k1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
								// ma_k2 = 389 = Pajak penghasilan pasal 22
								// ma_d = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
								$jtrans=27;
								$ma_d=10;
								$ma_dPajak=10;
								//if ($tcaraBayar==2) $ma_d=31;
								//$ma_k1=394;
								//$ma_k2=389;
								$uraian1=$uraian."Penerimaan Pajak";
								
								$arpajak=explode(chr(6),$arfdata[0]);
								
								//$dpp=100/110 * $nilai;
								//$ppn=10/110 * $nilai;
								$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
								$rs1=mysql_query($sql);
								$no_trans=1;
								if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
								
								$nilai2=0;
								for ($i=0;$i<count($arpajak);$i++){
									$dataPajak=explode("|",$arpajak[$i]);
									$nilai1=$dataPajak[1];
									$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$tgl','$nokw','$uraian1',0,$nilai1,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
									//echo $sql."<br>";
									$rs1 = mysql_query($sql);
									$nilai2 +=$nilai1;
								}
								
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_dPajak,'$tgl','$nokw','$uraian1',$nilai2,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
								
								if ($TglBayarPajak!=""){
									// jtrans = 94 = Pembayaran Hutang Pajak Pertambahan Nilai (PPN)
									// ma_d1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
									// ma_d2 = 389 = Pajak penghasilan pasal 22
									// ma_k = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
									$jtrans=94;
									$ma_k=10;
									$ma_kPajak=10;
									//if ($tcaraBayar==2) $ma_k=31;
									//$ma_d1=394;
									//$ma_d2=389;
									$uraian1=$uraian."Pembayaran Pajak";
									
									$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
									//echo $sql."<br>";
									$rs1=mysql_query($sql);
									$no_trans=1;
									if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
									
									$nilai2=0;
									for ($i=0;$i<count($arpajak);$i++){
										$dataPajak=explode("|",$arpajak[$i]);
										$nilai1=$dataPajak[1];
										$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$TglBayarPajak','$nokw','$uraian1',$nilai1,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
										//echo $sql."<br>";
										$rs1 = mysql_query($sql);
										$nilai2 +=$nilai1;
									}
									
									$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_kPajak,'$TglBayarPajak','$nokw','$uraian1',0,$nilai2,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
									//echo $sql."<br>";
									$rs1 = mysql_query($sql);
								}
							}
						}
						
						break;
					case 9:
						//=========== id_trans=9 --> Pembayaran PDAM --> Posting Akuntansi============
						//$nilai=$row["nilai"];
						//$selisih=$row["nilai_sim"]-$nilai;
						$tgl=$TglBayar;
						$nokw=$noBukti;
						//$cc_rv=$row["unit_id"];
						$uraian="Posting Pembayaran PDAM : ";
						
						$sql="SELECT * FROM k_transaksi_detail WHERE transaksi_id='$id' AND pajak_id=0";
						$rsCC_RV=mysql_query($sql);
						if (mysql_num_rows($rsCC_RV)>0){
							$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);
							$no_trans=1;
							if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
							
							// jtrans = 242 = Pembayaran PDAM / Air (Biaya Administrasi & Umum)
							// ma_d = 687 = Biaya Air / PDAM
							// ma_k = 10 = Kas Bendahara Pengeluaran, 31 = Bank Bendahara Pengeluaran - Bank Jatim - R/K 0261021102
							$jtrans=242;
							$ma_d=687;
							$ma_k=31;
							if ($tcaraBayar==1) $ma_k=10;

							$nilaiTot=0;
							while ($rwCC_RV=mysql_fetch_array($rsCC_RV)){
								$nilai=$rwCC_RV["nilai"];
								$nilaiTot +=$nilai;
								$cc_rv=$rwCC_RV["unit_id"];
								$sql="SELECT id idcc,nama FROM ".$dbakuntansi.".ak_ms_unit WHERE id=$cc_rv";
								$rs1=mysql_query($sql);
								$rows=mysql_fetch_array($rs1);
								$uraian1=$uraian.$rows["nama"];
								$cc_rv_ak=$rows["idcc"];
							
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_d,'$tgl','$nokw','$uraian1',$nilai,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,$cc_rv_ak,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
							}
							
							$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_k,'$tgl','$nokw','$uraian',0,$nilaiTot,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
							//echo $sql."<br>";
							$rs1 = mysql_query($sql);
							
							if ($arfdata[0]!=""){
								// jtrans = 27 = Penerimaan PPN & PPH
								// ma_k1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
								// ma_k2 = 389 = Pajak penghasilan pasal 22
								// ma_d = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
								$jtrans=27;
								$ma_d=10;
								$ma_dPajak=10;
								//if ($tcaraBayar==2) $ma_d=31;
								//$ma_k1=394;
								//$ma_k2=389;
								$uraian1=$uraian."Penerimaan Pajak";
								
								$arpajak=explode(chr(6),$arfdata[0]);
								
								//$dpp=100/110 * $nilai;
								//$ppn=10/110 * $nilai;
								$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
								$rs1=mysql_query($sql);
								$no_trans=1;
								if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
								
								$nilai2=0;
								for ($i=0;$i<count($arpajak);$i++){
									$dataPajak=explode("|",$arpajak[$i]);
									$nilai1=$dataPajak[1];
									$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$tgl','$nokw','$uraian1',0,$nilai1,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
									//echo $sql."<br>";
									$rs1 = mysql_query($sql);
									$nilai2 +=$nilai1;
								}
								
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_dPajak,'$tgl','$nokw','$uraian1',$nilai2,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
								
								if ($TglBayarPajak!=""){
									// jtrans = 94 = Pembayaran Hutang Pajak Pertambahan Nilai (PPN)
									// ma_d1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
									// ma_d2 = 389 = Pajak penghasilan pasal 22
									// ma_k = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
									$jtrans=94;
									$ma_k=10;
									$ma_kPajak=10;
									//if ($tcaraBayar==2) $ma_k=31;
									//$ma_d1=394;
									//$ma_d2=389;
									$uraian1=$uraian."Pembayaran Pajak";
									
									$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
									//echo $sql."<br>";
									$rs1=mysql_query($sql);
									$no_trans=1;
									if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
									
									$nilai2=0;
									for ($i=0;$i<count($arpajak);$i++){
										$dataPajak=explode("|",$arpajak[$i]);
										$nilai1=$dataPajak[1];
										$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$TglBayarPajak','$nokw','$uraian1',$nilai1,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
										//echo $sql."<br>";
										$rs1 = mysql_query($sql);
										$nilai2 +=$nilai1;
									}
									
									$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_kPajak,'$TglBayarPajak','$nokw','$uraian1',0,$nilai2,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
									//echo $sql."<br>";
									$rs1 = mysql_query($sql);
								}
							}
						}
						
						break;
					case 10:
						//=========== id_trans=10 --> Pembayaran PLN / Listrik --> Posting Akuntansi============
						//$nilai=$row["nilai"];
						//$selisih=$row["nilai_sim"]-$nilai;
						$tgl=$TglBayar;
						$nokw=$noBukti;
						//$cc_rv=$row["unit_id"];
						$uraian="Posting Pembayaran PLN : ";
						
						$sql="SELECT * FROM k_transaksi_detail WHERE transaksi_id='$id' AND pajak_id=0";
						$rsCC_RV=mysql_query($sql);
						if (mysql_num_rows($rsCC_RV)>0){
							$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);
							$no_trans=1;
							if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
							
							// jtrans = 241 = Pembayaran PLN / Listrik (Biaya Administrasi & Umum)
							// ma_d = 686 = Biaya PLN / Listrik
							// ma_k = 10 = Kas Bendahara Pengeluaran, 31 = Bank Bendahara Pengeluaran - Bank Jatim - R/K 0261021102
							$jtrans=241;
							$ma_d=686;
							$ma_k=31;
							if ($tcaraBayar==1) $ma_k=10;

							$nilaiTot=0;
							while ($rwCC_RV=mysql_fetch_array($rsCC_RV)){
								$nilai=$rwCC_RV["nilai"];
								$nilaiTot +=$nilai;
								$cc_rv=$rwCC_RV["unit_id"];
							
								$sql="SELECT id idcc,nama FROM ".$dbakuntansi.".ak_ms_unit WHERE id=$cc_rv";
								$rs1=mysql_query($sql);
								$rows=mysql_fetch_array($rs1);
								$uraian1=$uraian.$rows["nama"];
								$cc_rv_ak=$rows["idcc"];
								
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_d,'$tgl','$nokw','$uraian1',$nilai,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,$cc_rv_ak,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
							}
							
							$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_k,'$tgl','$nokw','$uraian',0,$nilaiTot,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
							//echo $sql."<br>";
							$rs1 = mysql_query($sql);
							
							if ($arfdata[0]!=""){
								// jtrans = 27 = Penerimaan PPN & PPH
								// ma_k1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
								// ma_k2 = 389 = Pajak penghasilan pasal 22
								// ma_d = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
								$jtrans=27;
								$ma_d=10;
								$ma_dPajak=10;
								//if ($tcaraBayar==2) $ma_d=31;
								//$ma_k1=394;
								//$ma_k2=389;
								$uraian1=$uraian."Penerimaan Pajak";
								
								$arpajak=explode(chr(6),$arfdata[0]);
								
								//$dpp=100/110 * $nilai;
								//$ppn=10/110 * $nilai;
								$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
								$rs1=mysql_query($sql);
								$no_trans=1;
								if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
								
								$nilai2=0;
								for ($i=0;$i<count($arpajak);$i++){
									$dataPajak=explode("|",$arpajak[$i]);
									$nilai1=$dataPajak[1];
									$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$tgl','$nokw','$uraian1',0,$nilai1,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
									//echo $sql."<br>";
									$rs1 = mysql_query($sql);
									$nilai2 +=$nilai1;
								}
								
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_dPajak,'$tgl','$nokw','$uraian1',$nilai2,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
								
								if ($TglBayarPajak!=""){
									// jtrans = 94 = Pembayaran Hutang Pajak Pertambahan Nilai (PPN)
									// ma_d1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
									// ma_d2 = 389 = Pajak penghasilan pasal 22
									// ma_k = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
									$jtrans=94;
									$ma_k=10;
									$ma_kPajak=10;
									//if ($tcaraBayar==2) $ma_k=31;
									//$ma_d1=394;
									//$ma_d2=389;
									$uraian1=$uraian."Pembayaran Pajak";
									
									$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
									//echo $sql."<br>";
									$rs1=mysql_query($sql);
									$no_trans=1;
									if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
									
									$nilai2=0;
									for ($i=0;$i<count($arpajak);$i++){
										$dataPajak=explode("|",$arpajak[$i]);
										$nilai1=$dataPajak[1];
										$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$TglBayarPajak','$nokw','$uraian1',$nilai1,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
										//echo $sql."<br>";
										$rs1 = mysql_query($sql);
										$nilai2 +=$nilai1;
									}
									
									$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_kPajak,'$TglBayarPajak','$nokw','$uraian1',0,$nilai2,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
									//echo $sql."<br>";
									$rs1 = mysql_query($sql);
								}
							}
						}
						break;
					case 12:
						//=========== id_trans=10 --> Pembayaran Cleanning Service --> Posting Akuntansi============
						//$nilai=$row["nilai"];
						//$selisih=$row["nilai_sim"]-$nilai;
						$tgl=$TglBayar;
						$nokw=$noBukti;
						//$cc_rv=$row["unit_id"];
						$uraian="Posting Pembayaran Cleaning Service : ";
						
						$sql="SELECT * FROM k_transaksi_detail WHERE transaksi_id='$id' AND pajak_id=0";
						$rsCC_RV=mysql_query($sql);
						if (mysql_num_rows($rsCC_RV)>0){
							$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);
							$no_trans=1;
							if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
							
							// jtrans = 261 = Pembayaran Biaya Cleaning Service (Biaya Pokok Pelayanan)
							// ma_d = 582 = Biaya Cleaning Service
							// ma_k = 10 = Kas Bendahara Pengeluaran, 31 = Bank Bendahara Pengeluaran - Bank Jatim - R/K 0261021102
							$jtrans=261;
							$ma_d=582;
							$ma_k=31;
							if ($tcaraBayar==1) $ma_k=10;

							$nilaiTot=0;
							while ($rwCC_RV=mysql_fetch_array($rsCC_RV)){
								$nilai=$rwCC_RV["nilai"];
								$nilaiTot +=$nilai;
								$cc_rv=$rwCC_RV["unit_id"];
							
								$sql="SELECT id idcc,nama FROM ".$dbakuntansi.".ak_ms_unit WHERE id=$cc_rv";
								$rs1=mysql_query($sql);
								$rows=mysql_fetch_array($rs1);
								$uraian1=$uraian.$rows["nama"];
								$cc_rv_ak=$rows["idcc"];
								
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_d,'$tgl','$nokw','$uraian1',$nilai,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,$cc_rv_ak,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
							}
							
							$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_k,'$tgl','$nokw','$uraian',0,$nilaiTot,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
							//echo $sql."<br>";
							$rs1 = mysql_query($sql);
							
							if ($arfdata[0]!=""){
								// jtrans = 27 = Penerimaan PPN & PPH
								// ma_k1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
								// ma_k2 = 389 = Pajak penghasilan pasal 22
								// ma_d = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
								$jtrans=27;
								$ma_d=10;
								$ma_dPajak=10;
								//if ($tcaraBayar==2) $ma_d=31;
								//$ma_k1=394;
								//$ma_k2=389;
								$uraian1=$uraian."Penerimaan Pajak";
								
								$arpajak=explode(chr(6),$arfdata[0]);
								
								//$dpp=100/110 * $nilai;
								//$ppn=10/110 * $nilai;
								$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
								$rs1=mysql_query($sql);
								$no_trans=1;
								if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
								
								$nilai2=0;
								for ($i=0;$i<count($arpajak);$i++){
									$dataPajak=explode("|",$arpajak[$i]);
									$nilai1=$dataPajak[1];
									$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$tgl','$nokw','$uraian1',0,$nilai1,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
									//echo $sql."<br>";
									$rs1 = mysql_query($sql);
									$nilai2 +=$nilai1;
								}
								
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_dPajak,'$tgl','$nokw','$uraian1',$nilai2,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
								
								if ($TglBayarPajak!=""){
									// jtrans = 94 = Pembayaran Hutang Pajak Pertambahan Nilai (PPN)
									// ma_d1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
									// ma_d2 = 389 = Pajak penghasilan pasal 22
									// ma_k = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
									$jtrans=94;
									$ma_k=10;
									$ma_kPajak=10;
									//if ($tcaraBayar==2) $ma_k=31;
									//$ma_d1=394;
									//$ma_d2=389;
									$uraian1=$uraian."Pembayaran Pajak";
									
									$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
									//echo $sql."<br>";
									$rs1=mysql_query($sql);
									$no_trans=1;
									if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
									
									$nilai2=0;
									for ($i=0;$i<count($arpajak);$i++){
										$dataPajak=explode("|",$arpajak[$i]);
										$nilai1=$dataPajak[1];
										$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$TglBayarPajak','$nokw','$uraian1',$nilai1,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
										//echo $sql."<br>";
										$rs1 = mysql_query($sql);
										$nilai2 +=$nilai1;
									}
									
									$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_kPajak,'$TglBayarPajak','$nokw','$uraian1',0,$nilai2,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
									//echo $sql."<br>";
									$rs1 = mysql_query($sql);
								}
							}
						}
						break;
					case 14:
						//=========== id_trans=8 --> Pembayaran Biaya Perjalanan Dinas dan Study Banding --> Posting Akuntansi ============
						//$nilai=$row["nilai"];
						//$selisih=$row["nilai_sim"]-$nilai;
						$tgl=$TglBayar;
						$nokw=$noBukti;
						$uraian="Posting Perjalanan Dinas Dalam Daerah : ";
						
						//;
						$sql="SELECT * FROM k_transaksi_detail WHERE transaksi_id='$id' AND pajak_id=0";
						$rsCC_RV=mysql_query($sql);
						if (mysql_num_rows($rsCC_RV)>0){
							$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);
							$no_trans=1;
							if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
								
							// jtrans = 248 = Pembayaran Biaya Perjalanan Dinas Dalam Daerah (Biaya Administrasi & Umum)
							// ma_d = 542 = Biaya Perjalanan Dinas Dalam Daerah (Biaya Administrasi & Umum)
							// ma_k = 10 = Kas Bendahara Pengeluaran, 33 = Bank Jatim - R/K 0261019205 (Bank BLUD)
							$jtrans=248;
							$ma_d=710;
							$ma_k=33;
							if ($tcaraBayar==1) $ma_k=10;
							
							$nilaiTot=0;
							while ($rwCC_RV=mysql_fetch_array($rsCC_RV)){
								$nilai=$rwCC_RV["nilai"];
								$nilaiTot +=$nilai;
								$cc_rv=$rwCC_RV["unit_id"];
								$sql="SELECT id idcc,nama FROM ".$dbakuntansi.".ak_ms_unit WHERE id=$cc_rv";
								$rs1=mysql_query($sql);
								$rows=mysql_fetch_array($rs1);
								$uraian1=$uraian.$rows["nama"];
								$cc_rv_ak=$rows["idcc"];
								
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_d,'$tgl','$nokw','$uraian1',$nilai,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,$cc_rv_ak,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
							}
							
							$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_k,'$tgl','$nokw','$uraian',0,$nilaiTot,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
							//echo $sql."<br>";
							$rs1 = mysql_query($sql);

							if ($arfdata[0]!=""){
								// jtrans = 27 = Penerimaan PPN & PPH
								// ma_k1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
								// ma_k2 = 389 = Pajak penghasilan pasal 22
								// ma_d = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
								$jtrans=27;
								$ma_d=10;
								$ma_dPajak=10;
								//if ($tcaraBayar==2) $ma_d=31;
								//$ma_k1=394;
								//$ma_k2=389;
								$uraian1=$uraian."Penerimaan Pajak";
								
								$arpajak=explode(chr(6),$arfdata[0]);
								
								//$dpp=100/110 * $nilai;
								//$ppn=10/110 * $nilai;
								$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
								$rs1=mysql_query($sql);
								$no_trans=1;
								if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
								
								$nilai2=0;
								for ($i=0;$i<count($arpajak);$i++){
									$dataPajak=explode("|",$arpajak[$i]);
									$nilai1=$dataPajak[1];
									$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$tgl','$nokw','$uraian1',0,$nilai1,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
									//echo $sql."<br>";
									$rs1 = mysql_query($sql);
									$nilai2 +=$nilai1;
								}
								
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_dPajak,'$tgl','$nokw','$uraian1',$nilai2,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
								
								if ($TglBayarPajak!=""){
									// jtrans = 94 = Pembayaran Hutang Pajak Pertambahan Nilai (PPN)
									// ma_d1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
									// ma_d2 = 389 = Pajak penghasilan pasal 22
									// ma_k = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
									$jtrans=94;
									$ma_k=10;
									$ma_kPajak=10;
									//if ($tcaraBayar==2) $ma_k=31;
									//$ma_d1=394;
									//$ma_d2=389;
									$uraian1=$uraian."Pembayaran Pajak";
									
									$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
									//echo $sql."<br>";
									$rs1=mysql_query($sql);
									$no_trans=1;
									if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
									
									$nilai2=0;
									for ($i=0;$i<count($arpajak);$i++){
										$dataPajak=explode("|",$arpajak[$i]);
										$nilai1=$dataPajak[1];
										$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$TglBayarPajak','$nokw','$uraian1',$nilai1,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
										//echo $sql."<br>";
										$rs1 = mysql_query($sql);
										$nilai2 +=$nilai1;
									}
									
									$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_kPajak,'$TglBayarPajak','$nokw','$uraian1',0,$nilai2,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
									//echo $sql."<br>";
									$rs1 = mysql_query($sql);
								}
							}
						}
						
						break;
					case 15:
						//=========== id_trans=15 --> Pembayaran Telpon --> Posting Akuntansi============
						//$nilai=$row["nilai"];
						//$selisih=$row["nilai_sim"]-$nilai;
						$tgl=$TglBayar;
						$nokw=$noBukti;
						//$cc_rv=$row["unit_id"];
						$uraian="Posting Pembayaran Telpon : ";
						
						$sql="SELECT * FROM k_transaksi_detail WHERE transaksi_id='$id' AND pajak_id=0";
						$rsCC_RV=mysql_query($sql);
						if (mysql_num_rows($rsCC_RV)>0){
							$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);
							$no_trans=1;
							if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
						
							// jtrans = 240 = Pembayaran Telpon (Biaya Administrasi & Umum)
							// ma_d = 685 = Biaya Telpon
							// ma_k = 10 = Kas Bendahara Pengeluaran, 31 = Bank Bendahara Pengeluaran - Bank Jatim - R/K 0261021102
							$jtrans=240;
							$ma_d=685;
							$ma_k=31;
							if ($tcaraBayar==1) $ma_k=10;

							$nilaiTot=0;
							while ($rwCC_RV=mysql_fetch_array($rsCC_RV)){
								$nilai=$rwCC_RV["nilai"];
								$nilaiTot +=$nilai;
								$cc_rv=$rwCC_RV["unit_id"];
								
								$sql="SELECT id idcc,nama FROM ".$dbakuntansi.".ak_ms_unit WHERE id=$cc_rv";
								$rs1=mysql_query($sql);
								$rows=mysql_fetch_array($rs1);
								$uraian1=$uraian.$rows["nama"];
								$cc_rv_ak=$rows["idcc"];
								
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_d,'$tgl','$nokw','$uraian1',$nilai,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,$cc_rv_ak,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
							}
						
							$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_k,'$tgl','$nokw','$uraian',0,$nilaiTot,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
							//echo $sql."<br>";
							$rs1 = mysql_query($sql);
							
							if ($arfdata[0]!=""){
								// jtrans = 27 = Penerimaan PPN & PPH
								// ma_k1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
								// ma_k2 = 389 = Pajak penghasilan pasal 22
								// ma_d = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
								$jtrans=27;
								$ma_d=10;
								$ma_dPajak=10;
								//if ($tcaraBayar==2) $ma_d=31;
								//$ma_k1=394;
								//$ma_k2=389;
								$uraian1=$uraian."Penerimaan Pajak";
								$arpajak=explode(chr(6),$arfdata[0]);
								
								//$dpp=100/110 * $nilai;
								//$ppn=10/110 * $nilai;
								$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
								$rs1=mysql_query($sql);
								$no_trans=1;
								if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
								
								$nilai2=0;
								for ($i=0;$i<count($arpajak);$i++){
									$dataPajak=explode("|",$arpajak[$i]);
									//if ($dataPajak[0]==394){
										//$nilai1=$ppn;
										$nilai1=$dataPajak[1];
										$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$tgl','$nokw','$uraian1',0,$nilai1,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
										//echo $sql."<br>";
										$rs1 = mysql_query($sql);
									/*}else{
										//$nilai1=$dataPajak[1]/100 * $dpp;
										$nilai1=$dataPajak[1];
										$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$tgl','$nokw','$uraian',0,$nilai1,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
										//echo $sql."<br>";
										$rs1 = mysql_query($sql);
									}*/
									
									$nilai2 +=$nilai1;
								}
								
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_dPajak,'$tgl','$nokw','$uraian1',$nilai2,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
								
								if ($TglBayarPajak!=""){
									// jtrans = 94 = Pembayaran Hutang Pajak Pertambahan Nilai (PPN)
									// ma_d1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
									// ma_d2 = 389 = Pajak penghasilan pasal 22
									// ma_k = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
									$jtrans=94;
									$ma_k=10;
									$ma_kPajak=10;
									//if ($tcaraBayar==2) $ma_k=31;
									//$ma_d1=394;
									//$ma_d2=389;
									$uraian1=$uraian."Pembayaran Pajak";
									
									$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
									//echo $sql."<br>";
									$rs1=mysql_query($sql);
									$no_trans=1;
									if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
									
									$nilai2=0;
									for ($i=0;$i<count($arpajak);$i++){
										$dataPajak=explode("|",$arpajak[$i]);
										//if ($dataPajak[0]==394){
											//$nilai1=$ppn;
											$nilai1=$dataPajak[1];
											$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$TglBayarPajak','$nokw','$uraian1',$nilai1,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
											//echo $sql."<br>";
											$rs1 = mysql_query($sql);
										/*}else{
											//$nilai1=$dataPajak[1]/100 * $dpp;
											$nilai1=$dataPajak[1];
											$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$TglBayarPajak','$nokw','$uraian',$nilai1,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
											//echo $sql."<br>";
											$rs1 = mysql_query($sql);
										}*/
										
										$nilai2 +=$nilai1;
									}
									
									$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_kPajak,'$TglBayarPajak','$nokw','$uraian1',0,$nilai2,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
									//echo $sql."<br>";
									$rs1 = mysql_query($sql);
								}
							}
						}
						break;
					case 17:
						//=========== id_trans=17 --> Pembayaran Jasa Medis --> Posting Akuntansi ============
						//$nilai=$row["nilai"];
						//$selisih=$row["nilai_sim"]-$nilai;
						$tgl=$TglBayar;
						$nokw=$noBukti;
						$uraian="Posting Jasa Medis : ";
						
						//;
						$sql="SELECT * FROM k_transaksi_detail WHERE transaksi_id='$id' AND pajak_id=0";
						$rsCC_RV=mysql_query($sql);
						if (mysql_num_rows($rsCC_RV)>0){
							$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);
							$no_trans=1;
							if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
								
							// jtrans = 190 = Pembayaran Jasa Medis (Biaya Pokok Pelayanan)
							// ma_d = 542 = Biaya Jasa Pelayanan (Jasa Medis)
							// ma_k = 10 = Kas Bendahara Pengeluaran, 33 = Bank Jatim - R/K 0261019205 (Bank BLUD)
							$jtrans=190;
							$ma_d=567;
							$ma_k=33;
							if ($tcaraBayar==1) $ma_k=10;
							
							$nilaiTot=0;
							while ($rwCC_RV=mysql_fetch_array($rsCC_RV)){
								$nilai=$rwCC_RV["nilai"];
								$nilaiTot +=$nilai;
								$cc_rv=$rwCC_RV["unit_id"];
								$sql="SELECT id idcc,nama FROM ".$dbakuntansi.".ak_ms_unit WHERE id=$cc_rv";
								$rs1=mysql_query($sql);
								$rows=mysql_fetch_array($rs1);
								$uraian1=$uraian.$rows["nama"];
								$cc_rv_ak=$rows["idcc"];
								
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_d,'$tgl','$nokw','$uraian1',$nilai,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,$cc_rv_ak,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
							}
							
							$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_k,'$tgl','$nokw','$uraian',0,$nilaiTot,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
							//echo $sql."<br>";
							$rs1 = mysql_query($sql);

							if ($arfdata[0]!=""){
								// jtrans = 27 = Penerimaan PPN & PPH
								// ma_k1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
								// ma_k2 = 389 = Pajak penghasilan pasal 22
								// ma_d = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
								$jtrans=27;
								$ma_d=10;
								$ma_dPajak=10;
								//if ($tcaraBayar==2) $ma_d=31;
								//$ma_k1=394;
								//$ma_k2=389;
								$uraian1=$uraian."Penerimaan Pajak";
								
								$arpajak=explode(chr(6),$arfdata[0]);
								
								//$dpp=100/110 * $nilai;
								//$ppn=10/110 * $nilai;
								$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
								$rs1=mysql_query($sql);
								$no_trans=1;
								if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
								
								$nilai2=0;
								for ($i=0;$i<count($arpajak);$i++){
									$dataPajak=explode("|",$arpajak[$i]);
									$nilai1=$dataPajak[1];
									$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$tgl','$nokw','$uraian1',0,$nilai1,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
									//echo $sql."<br>";
									$rs1 = mysql_query($sql);
									$nilai2 +=$nilai1;
								}
								
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_dPajak,'$tgl','$nokw','$uraian1',$nilai2,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
								
								if ($TglBayarPajak!=""){
									// jtrans = 94 = Pembayaran Hutang Pajak Pertambahan Nilai (PPN)
									// ma_d1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
									// ma_d2 = 389 = Pajak penghasilan pasal 22
									// ma_k = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
									$jtrans=94;
									$ma_k=10;
									$ma_kPajak=10;
									//if ($tcaraBayar==2) $ma_k=31;
									//$ma_d1=394;
									//$ma_d2=389;
									$uraian1=$uraian."Pembayaran Pajak";
									
									$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
									//echo $sql."<br>";
									$rs1=mysql_query($sql);
									$no_trans=1;
									if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
									
									$nilai2=0;
									for ($i=0;$i<count($arpajak);$i++){
										$dataPajak=explode("|",$arpajak[$i]);
										$nilai1=$dataPajak[1];
										$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$TglBayarPajak','$nokw','$uraian1',$nilai1,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
										//echo $sql."<br>";
										$rs1 = mysql_query($sql);
										$nilai2 +=$nilai1;
									}
									
									$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_kPajak,'$TglBayarPajak','$nokw','$uraian1',0,$nilai2,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
									//echo $sql."<br>";
									$rs1 = mysql_query($sql);
								}
							}
						}
						
						break;
					case 18:
						//=========== id_trans=8 --> Pembayaran Gaji Non PNS --> Posting Akuntansi ============
						//$nilai=$row["nilai"];
						//$selisih=$row["nilai_sim"]-$nilai;
						$tgl=$TglBayar;
						$nokw=$noBukti;
						$uraian="Posting Gaji Non PNS : ";
						
						//;
						$sql="SELECT * FROM k_transaksi_detail WHERE transaksi_id='$id' AND pajak_id=0";
						$rsCC_RV=mysql_query($sql);
						if (mysql_num_rows($rsCC_RV)>0){
							$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);
							$no_trans=1;
							if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
								
							// jtrans = 110 = Pembayaran Gaji Non PNS (Biaya Pokok Pelayanan)
							// jtrans = 102 = Pembayaran Gaji PNS (Biaya Administrasi & Umum)
							// ma_d = 542 = Biaya Gaji Non PNS (Biaya Pokok Pelayanan)
							// ma_d = 542 = Biaya Gaji Non PNS (Biaya Administrasi & Umum)
							// ma_k = 10 = Kas Bendahara Pengeluaran, 33 = Bank Jatim - R/K 0261019205 (Bank BLUD)
							$jtrans=110;
							$ma_d=542;
							$ma_k=33;
							if ($tcaraBayar==1) $ma_k=10;
							
							$nilaiTot=0;
							while ($rwCC_RV=mysql_fetch_array($rsCC_RV)){
								$nilai=$rwCC_RV["nilai"];
								$nilaiTot +=$nilai;
								$cc_rv=$rwCC_RV["unit_id"];
								$sql="SELECT id idcc,nama FROM ".$dbakuntansi.".ak_ms_unit WHERE id=$cc_rv";
								$rs1=mysql_query($sql);
								$rows=mysql_fetch_array($rs1);
								$uraian1=$uraian.$rows["nama"];
								$cc_rv_ak=$rows["idcc"];
								
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_d,'$tgl','$nokw','$uraian1',$nilai,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,$cc_rv_ak,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
							}
							
							$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_k,'$tgl','$nokw','$uraian',0,$nilaiTot,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
							//echo $sql."<br>";
							$rs1 = mysql_query($sql);

							if ($arfdata[0]!=""){
								// jtrans = 27 = Penerimaan PPN & PPH
								// ma_k1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
								// ma_k2 = 389 = Pajak penghasilan pasal 22
								// ma_d = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
								$jtrans=27;
								$ma_d=10;
								$ma_dPajak=10;
								//if ($tcaraBayar==2) $ma_d=31;
								//$ma_k1=394;
								//$ma_k2=389;
								$uraian1=$uraian."Penerimaan Pajak";
								
								$arpajak=explode(chr(6),$arfdata[0]);
								
								//$dpp=100/110 * $nilai;
								//$ppn=10/110 * $nilai;
								$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
								$rs1=mysql_query($sql);
								$no_trans=1;
								if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
								
								$nilai2=0;
								for ($i=0;$i<count($arpajak);$i++){
									$dataPajak=explode("|",$arpajak[$i]);
									$nilai1=$dataPajak[1];
									$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$tgl','$nokw','$uraian1',0,$nilai1,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
									//echo $sql."<br>";
									$rs1 = mysql_query($sql);
									$nilai2 +=$nilai1;
								}
								
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_dPajak,'$tgl','$nokw','$uraian1',$nilai2,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
								
								if ($TglBayarPajak!=""){
									// jtrans = 94 = Pembayaran Hutang Pajak Pertambahan Nilai (PPN)
									// ma_d1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
									// ma_d2 = 389 = Pajak penghasilan pasal 22
									// ma_k = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
									$jtrans=94;
									$ma_k=10;
									$ma_kPajak=10;
									//if ($tcaraBayar==2) $ma_k=31;
									//$ma_d1=394;
									//$ma_d2=389;
									$uraian1=$uraian."Pembayaran Pajak";
									
									$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
									//echo $sql."<br>";
									$rs1=mysql_query($sql);
									$no_trans=1;
									if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
									
									$nilai2=0;
									for ($i=0;$i<count($arpajak);$i++){
										$dataPajak=explode("|",$arpajak[$i]);
										$nilai1=$dataPajak[1];
										$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$TglBayarPajak','$nokw','$uraian1',$nilai1,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
										//echo $sql."<br>";
										$rs1 = mysql_query($sql);
										$nilai2 +=$nilai1;
									}
									
									$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_kPajak,'$TglBayarPajak','$nokw','$uraian1',0,$nilai2,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
									//echo $sql."<br>";
									$rs1 = mysql_query($sql);
								}
							}
						}
						
						break;
					case 40:
						//=========== id_trans=40 --> Pembayaran Internet --> Posting Akuntansi============
						//$nilai=$row["nilai"];
						//$selisih=$row["nilai_sim"]-$nilai;
						$tgl=$TglBayar;
						$nokw=$noBukti;
						//$cc_rv=$row["unit_id"];
						$uraian="Posting Pembayaran Internet : ";
						
						$sql="SELECT * FROM k_transaksi_detail WHERE transaksi_id='$id' AND pajak_id=0";
						$rsCC_RV=mysql_query($sql);
						if (mysql_num_rows($rsCC_RV)>0){
							$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);
							$no_trans=1;
							if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
						
							// jtrans = 243= Pembayaran Biaya Internet
							// ma_d = 688 = Biaya Internet
							// ma_k = 10 = Kas Bendahara Pengeluaran, 31 = Bank Bendahara Pengeluaran - Bank Jatim - R/K 0261021102
							$jtrans=243;
							$ma_d=688;
							$ma_k=31;
							if ($tcaraBayar==1) $ma_k=10;

							$nilaiTot=0;
							while ($rwCC_RV=mysql_fetch_array($rsCC_RV)){
								$nilai=$rwCC_RV["nilai"];
								$nilaiTot +=$nilai;
								$cc_rv=$rwCC_RV["unit_id"];
								
								$sql="SELECT id idcc,nama FROM ".$dbakuntansi.".ak_ms_unit WHERE id=$cc_rv";
								$rs1=mysql_query($sql);
								$rows=mysql_fetch_array($rs1);
								$uraian1=$uraian.$rows["nama"];
								$cc_rv_ak=$rows["idcc"];
								
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_d,'$tgl','$nokw','$uraian1',$nilai,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,$cc_rv_ak,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
							}
						
							$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_k,'$tgl','$nokw','$uraian',0,$nilaiTot,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
							//echo $sql."<br>";
							$rs1 = mysql_query($sql);
							
							if ($arfdata[0]!=""){
								// jtrans = 27 = Penerimaan PPN & PPH
								// ma_k1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
								// ma_k2 = 389 = Pajak penghasilan pasal 22
								// ma_d = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
								$jtrans=27;
								$ma_d=10;
								$ma_dPajak=10;
								//if ($tcaraBayar==2) $ma_d=31;
								//$ma_k1=394;
								//$ma_k2=389;
								$uraian1=$uraian."Penerimaan Pajak";
								$arpajak=explode(chr(6),$arfdata[0]);
								
								//$dpp=100/110 * $nilai;
								//$ppn=10/110 * $nilai;
								$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
								$rs1=mysql_query($sql);
								$no_trans=1;
								if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
								
								$nilai2=0;
								for ($i=0;$i<count($arpajak);$i++){
									$dataPajak=explode("|",$arpajak[$i]);
									//if ($dataPajak[0]==394){
										//$nilai1=$ppn;
										$nilai1=$dataPajak[1];
										$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$tgl','$nokw','$uraian1',0,$nilai1,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
										//echo $sql."<br>";
										$rs1 = mysql_query($sql);
									/*}else{
										//$nilai1=$dataPajak[1]/100 * $dpp;
										$nilai1=$dataPajak[1];
										$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$tgl','$nokw','$uraian',0,$nilai1,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
										//echo $sql."<br>";
										$rs1 = mysql_query($sql);
									}*/
									
									$nilai2 +=$nilai1;
								}
								
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_dPajak,'$tgl','$nokw','$uraian1',$nilai2,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
								
								if ($TglBayarPajak!=""){
									// jtrans = 94 = Pembayaran Hutang Pajak Pertambahan Nilai (PPN)
									// ma_d1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
									// ma_d2 = 389 = Pajak penghasilan pasal 22
									// ma_k = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
									$jtrans=94;
									$ma_k=10;
									$ma_kPajak=10;
									//if ($tcaraBayar==2) $ma_k=31;
									//$ma_d1=394;
									//$ma_d2=389;
									$uraian1=$uraian."Pembayaran Pajak";
									
									$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
									//echo $sql."<br>";
									$rs1=mysql_query($sql);
									$no_trans=1;
									if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
									
									$nilai2=0;
									for ($i=0;$i<count($arpajak);$i++){
										$dataPajak=explode("|",$arpajak[$i]);
										//if ($dataPajak[0]==394){
											//$nilai1=$ppn;
											$nilai1=$dataPajak[1];
											$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$TglBayarPajak','$nokw','$uraian1',$nilai1,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
											//echo $sql."<br>";
											$rs1 = mysql_query($sql);
										/*}else{
											//$nilai1=$dataPajak[1]/100 * $dpp;
											$nilai1=$dataPajak[1];
											$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$TglBayarPajak','$nokw','$uraian',$nilai1,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
											//echo $sql."<br>";
											$rs1 = mysql_query($sql);
										}*/
										
										$nilai2 +=$nilai1;
									}
									
									$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_kPajak,'$TglBayarPajak','$nokw','$uraian1',0,$nilai2,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
									//echo $sql."<br>";
									$rs1 = mysql_query($sql);
								}
							}
						}
						break;
					case 41:
						//=========== id_trans=40 --> Pembayaran Pelatihan --> Posting Akuntansi============
						//$nilai=$row["nilai"];
						//$selisih=$row["nilai_sim"]-$nilai;
						$tgl=$TglBayar;
						$nokw=$noBukti;
						//$cc_rv=$row["unit_id"];
						$uraian="Posting Pembayaran Pelatihan : ";
						
						$sql="SELECT * FROM k_transaksi_detail WHERE transaksi_id='$id' AND pajak_id=0";
						$rsCC_RV=mysql_query($sql);
						if (mysql_num_rows($rsCC_RV)>0){
							$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);
							$no_trans=1;
							if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
							
							// jtrans = 250= Pembayaran Biaya Pendidikan/Pelatihan/Seminar/Simposium di Lingkungan RS ( Administrasi & Umum )
							// ma_d = 718 = Biaya Honor Penyelenggara
							// ma_k = 10 = Kas Bendahara Pengeluaran, 31 = Bank Bendahara Pengeluaran - Bank Jatim - R/K 0261021102
							$jtrans=250;
							$ma_d=718;
							$ma_k=31;
							if ($tcaraBayar==1) $ma_k=10;

							$nilaiTot=0;
							while ($rwCC_RV=mysql_fetch_array($rsCC_RV)){
								$nilai=$rwCC_RV["nilai"];
								$nilaiTot +=$nilai;
								$cc_rv=$rwCC_RV["unit_id"];
								
								$sql="SELECT id idcc,nama FROM ".$dbakuntansi.".ak_ms_unit WHERE id=$cc_rv";
								$rs1=mysql_query($sql);
								$rows=mysql_fetch_array($rs1);
								$uraian1=$uraian.$rows["nama"];
								$cc_rv_ak=$rows["idcc"];
								
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_d,'$tgl','$nokw','$uraian1',$nilai,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,$cc_rv_ak,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
							}
						
							$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_k,'$tgl','$nokw','$uraian',0,$nilaiTot,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
							//echo $sql."<br>";
							$rs1 = mysql_query($sql);
							
							if ($arfdata[0]!=""){
								// jtrans = 27 = Penerimaan PPN & PPH
								// ma_k1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
								// ma_k2 = 389 = Pajak penghasilan pasal 22
								// ma_d = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
								$jtrans=27;
								$ma_d=10;
								$ma_dPajak=10;
								//if ($tcaraBayar==2) $ma_d=31;
								//$ma_k1=394;
								//$ma_k2=389;
								$uraian1=$uraian."Penerimaan Pajak";
								$arpajak=explode(chr(6),$arfdata[0]);
								
								//$dpp=100/110 * $nilai;
								//$ppn=10/110 * $nilai;
								$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
								$rs1=mysql_query($sql);
								$no_trans=1;
								if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
								
								$nilai2=0;
								for ($i=0;$i<count($arpajak);$i++){
									$dataPajak=explode("|",$arpajak[$i]);
									//if ($dataPajak[0]==394){
										//$nilai1=$ppn;
										$nilai1=$dataPajak[1];
										$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$tgl','$nokw','$uraian1',0,$nilai1,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
										//echo $sql."<br>";
										$rs1 = mysql_query($sql);
									/*}else{
										//$nilai1=$dataPajak[1]/100 * $dpp;
										$nilai1=$dataPajak[1];
										$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$tgl','$nokw','$uraian',0,$nilai1,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
										//echo $sql."<br>";
										$rs1 = mysql_query($sql);
									}*/
									
									$nilai2 +=$nilai1;
								}
								
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_dPajak,'$tgl','$nokw','$uraian1',$nilai2,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
								
								if ($TglBayarPajak!=""){
									// jtrans = 94 = Pembayaran Hutang Pajak Pertambahan Nilai (PPN)
									// ma_d1 = 394 = Pajak pertambahan nilai (PPN) atas barang dan jasa/ PPn BM
									// ma_d2 = 389 = Pajak penghasilan pasal 22
									// ma_k = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
									$jtrans=94;
									$ma_k=10;
									$ma_kPajak=10;
									//if ($tcaraBayar==2) $ma_k=31;
									//$ma_d1=394;
									//$ma_d2=389;
									$uraian1=$uraian."Pembayaran Pajak";
									
									$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
									//echo $sql."<br>";
									$rs1=mysql_query($sql);
									$no_trans=1;
									if ($rows=mysql_fetch_array($rs1)) $no_trans=$rows["no_trans"];
									
									$nilai2=0;
									for ($i=0;$i<count($arpajak);$i++){
										$dataPajak=explode("|",$arpajak[$i]);
										//if ($dataPajak[0]==394){
											//$nilai1=$ppn;
											$nilai1=$dataPajak[1];
											$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$TglBayarPajak','$nokw','$uraian1',$nilai1,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
											//echo $sql."<br>";
											$rs1 = mysql_query($sql);
										/*}else{
											//$nilai1=$dataPajak[1]/100 * $dpp;
											$nilai1=$dataPajak[1];
											$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$dataPajak[0],'$TglBayarPajak','$nokw','$uraian',$nilai1,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1)";
											//echo $sql."<br>";
											$rs1 = mysql_query($sql);
										}*/
										
										$nilai2 +=$nilai1;
									}
									
									$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$ma_kPajak,'$TglBayarPajak','$nokw','$uraian1',0,$nilai2,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
									//echo $sql."<br>";
									$rs1 = mysql_query($sql);
								}
							}
						}
						break;
				}
		   }
		}
	   	break;
}

if ($filter!="") {
	$filter=explode("|",$filter);
	$filter=" WHERE ".$filter[0]." like '%".$filter[1]."%'";
}

if ($sorting=="") {
	$sorting="tgl"; //default sort
}

$strBayar="";
if ($stBayar<>2){
	$strBayar=" AND t.posting='$stBayar'";
}

if($pilihan == "pengeluaran") {
	$sql = "select * from (select t.id, id_trans, mt.nama as nama_trans,ma.ma_id, ma.ma_nama as ma_nama, date_format(tgl,'%d-%m-%Y') as tgl, no_bukti,t.no_faktur, t.jenis_layanan
		 , uj.nama as nama_jl, unit_id, ut.nama as nama_tl, nilai_sim, nilai, IF((t.no_faktur='' OR t.no_faktur IS NULL),t.ket,CONCAT(t.ket,' (',t.no_faktur,')')) ket,t.ket ket1, IF(t.verifikasi=1,'Sudah','Belum') verifikasi,t.verifikasi verifikasiId, jenis_supplier,IF(jenis_supplier='1','(Supplier Obat)',IF(jenis_supplier='2','(Supplier Barang)','')) as nama_jenis_supplier, supplier_id
			from ".$dbkeuangan.".k_transaksi t
			left join ".$dbanggaran.".ms_ma ma on t.id_ma_dpa = ma.ma_id
			left join ".$dbakuntansi.".ak_ms_unit uj on t.jenis_layanan = uj.id
			left join ".$dbakuntansi.".ak_ms_unit ut on t.unit_id = ut.id
			inner join ".$dbkeuangan.".k_ms_transaksi mt on t.id_trans = mt.id
			where month(tgl) = '$bln' and year(tgl) = '$thn' and mt.tipe = 2 ".$strBayar."
			order by $sorting) a1 $filter";
}

//echo $sql."<br>";    
$rs=mysql_query($sql);
//echo mysql_error();
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

if($pilihan == "pengeluaran") {
	while ($rows=mysql_fetch_array($rs)) {
		$sqld="select * from k_transaksi_detail where transaksi_id=".$rows['id'];
		$kueri=mysql_query($sqld);
		$temp = "";
		while($data=mysql_fetch_array($kueri)){
			$temp = $temp."#".$data['jenis_layanan_id']."*".$data['unit_id']."*".$data['nilai'];
		}
		
		$sisip = $rows['id'].'|'.$rows['id_trans'].'|'.$rows['jenis_layanan'].'|'.$rows['unit_id'].'|'.$rows['ket1'].'|'.$rows['no_faktur'].'|'.$rows['supplier_id'].'|'.$rows['nilai'].'|'.$rows['jenis_supplier'].'|'.$rows['verifikasiId'].'|'.$rows['nilai_sim'].'|'.$rows['ma_id'].'|'.$temp;
		$i++;
		$cket="";
		if ($rows['unit_id']!=0) $cket=" - ".$rows['nama_tl'];
		$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows['tgl'].chr(3).$rows["no_bukti"].chr(3).$rows["nama_trans"].chr(3).$rows["ma_nama"].$rows["nama_jenis_supplier"].chr(3).number_format($rows['nilai'],0,",",".").chr(3).$rows['ket'].chr(3).$rows['verifikasi'].chr(3)."0".chr(6);
		//(($rows["asalunit"]!='')?"Rujuk dari: ".$rows["asalunit"]:"Loket")tglJamSQL($rows["tgl_act"])
	}
}

if ($dt!=$totpage.chr(5)) {
	$dt=substr($dt,0,strlen($dt)-1).chr(5).''."*|*";
	$dt=str_replace('"','\"',$dt);
}
mysql_free_result($rs);
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