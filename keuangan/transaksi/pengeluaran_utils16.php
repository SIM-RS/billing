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
$nilai_sim = $_REQUEST['nilai_sim']; if ($nilai_sim=="" || $nilai_sim==0) $nilai_sim=$nilai;
$jenis_supplier = $_REQUEST['jenis_supplier'];
$supplier_id = $_REQUEST['suplier_id'];
$nofaktur = $_REQUEST['nofaktur'];
$nterima = $_REQUEST['nterima'];
$tnterima = $nterima;
$tgl_filter1 = $_REQUEST['tgl_filter1'];
$tgl_filter2 = $_REQUEST['tgl_filter2'];
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
$id_ma_sak = $_REQUEST['id_ma_sak'];
//===============================
$statusProses='';
$pilihan = strtolower($_REQUEST["pilihan"]);
$act = strtolower(($_REQUEST['act']));
switch($act){
    case 'add':
	   	$insert = true;
	   
	   	//$sql = "select id from k_transaksi where id_trans = '$id_trans', ";
		$sql = "insert into ".$dbkeuangan.".k_transaksi (id_trans,tgl,no_bukti,no_faktur,no_terima,jenis_supplier,supplier_id,jenis_layanan,unit_id,nilai_sim,nilai
				,ket,tgl_act,user_act, id_ma_dpa, id_ma_sak, tipe_trans )
				values ('$id_trans', '$tgl', '$nobukti', '$nofaktur','$tnterima','$jenis_supplier', '$supplier_id', '$jenis_layanan', '$unit_id','$nilai_sim', '$nilai'
				, '$ket', $tgl_act, '$user_act', '$idma', '$id_ma_sak', 2)";
		//echo $sql."<br>";
		$rs = mysql_query($sql);
		if (mysql_errno()==0){
			$transaksi_id = mysql_insert_id();
			$fdata = $_REQUEST['fdata'];
			$temp = explode("|",$fdata);
			for($i=1;$i<=count($temp)-1;$i++){
				$tmp = explode("*",$temp[$i]);
				$sql2 = "insert into ".$dbkeuangan.".k_transaksi_detail (transaksi_id,jenis_layanan_id,unit_id,nilai,nilai_sim) values ('$transaksi_id','$tmp[0]','$tmp[1]','$tmp[3]','$tmp[3]')";
				//echo $sql2."<br>";
				mysql_query($sql2);
				//$up = "update ".$dbkeuangan.".k_transaksi set id_ma_sak='$tmp[2]',unit_id='0' where id=$transaksi_id";
				//mysql_query($up);
			}
					
		   if ($id_ma_sak == 1071 || $id_ma_sak == 1078){
			  $sql = "select id from k_transaksi where id_trans = '$id_trans' and no_faktur = '$nofaktur'";
			  //echo $sql."<br>";
			  $rs = mysql_query($sql);
			  $id=0;
			  if(mysql_num_rows($rs) > 0){
				$insert = false;
				$rw=mysql_fetch_array($rs);
				$id=$rw["id"];
			  }
			  
				if ($jenis_supplier=='1'){
					if ($nterima==""){
						$sql="select DISTINCT p.NOTERIMA from ".$dbapotek.".a_penerimaan p WHERE p.TIPE_TRANS=0 AND p.STATUS=1 AND p.BATCH='$nofaktur' AND p.bayar = 1";
						//echo $sql."<br>";
						$rs = mysql_query($sql);
						while ($rw=mysql_fetch_array($rs)){
							$tnterima.=$rw["NOTERIMA"]."|";
						}
						$tnterima=substr($tnterima,0,strlen($tnterima)-1);
						
						$sql="update ".$dbapotek.".a_penerimaan p set bayar = 2 WHERE p.TIPE_TRANS=0 AND p.STATUS=1 AND p.BATCH='$nofaktur' AND p.bayar = 1";
						//echo $sql."<br>";
						$rs = mysql_query($sql);
					}else{
						$nterima=explode("|",$nterima);
						for ($i=0;$i<count($nterima);$i++){
							$sql="update ".$dbapotek.".a_penerimaan p set bayar = 2 WHERE p.TIPE_TRANS=0 AND p.STATUS=1 AND p.BATCH='$nofaktur' AND p.NOTERIMA='$nterima[$i]' AND p.bayar = 1";
							//echo $sql."<br>";
							$rs = mysql_query($sql);
						}
					}
				}
				else if($jenis_supplier=='2'){
					if ($nterima==""){
						$sql="select DISTINCT m.no_gudang from ".$dbaset.".as_masuk m 
						   WHERE m.po_id in (SELECT id FROM ".$dbaset.".as_po where no_spk='$nofaktur') and bayar = 0 and posted=1 AND tgl_terima BETWEEN '".tglSQL($tgl_filter1)."' AND '".tglSQL($tgl_filter2)."'";
						//echo $sql."<br>";
						$rs = mysql_query($sql);
						while ($rw=mysql_fetch_array($rs)){
							$tnterima.=$rw["no_gudang"]."|";
						}
						$tnterima=substr($tnterima,0,strlen($tnterima)-1);
						
						/*$sql = "update ".$dbaset.".as_masuk m set bayar = 2
						   WHERE m.po_id in (SELECT id FROM  ".$dbaset.".as_po where no_po='$nofaktur' ) and bayar = 0 and posted=1";*/
						/*$sql = "update ".$dbaset.".as_masuk m set bayar = 2, no_bukti_bayar='$nobukti'
						   WHERE m.po_id in (SELECT id FROM ".$dbaset.".as_po where no_spk='$nofaktur') and bayar = 0 and posted=1 AND tgl_terima BETWEEN '".tglSQL($tgl_filter1)."' AND '".tglSQL($tgl_filter2)."'";*/
						$sql = "update ".$dbaset.".as_masuk m set bayar = 2, bayar_id='$transaksi_id'
						   WHERE m.po_id in (SELECT id FROM ".$dbaset.".as_po where no_spk='$nofaktur') and bayar = 0 and posted=1 AND tgl_terima BETWEEN '".tglSQL($tgl_filter1)."' AND '".tglSQL($tgl_filter2)."'";
						//echo $sql."<br>";
						$rs = mysql_query($sql);
					}else{
						$nterima=explode("|",$nterima);
						for ($i=0;$i<count($nterima);$i++){
							/*$sql = "update ".$dbaset.".as_masuk m set bayar = 2, no_bukti_bayar='$nobukti'
							   WHERE m.po_id in (SELECT id FROM  ".$dbaset.".as_po where no_spk='$nofaktur' ) and m.no_gudang='$nterima[$i]' and bayar = 0 and posted=1 AND tgl_terima BETWEEN '".tglSQL($tgl_filter1)."' AND '".tglSQL($tgl_filter2)."'";*/
							$sql = "update ".$dbaset.".as_masuk m set bayar = 2, bayar_id='$transaksi_id'
							   WHERE m.po_id in (SELECT id FROM  ".$dbaset.".as_po where no_spk='$nofaktur' ) and m.no_gudang='$nterima[$i]' and bayar = 0 and posted=1 AND tgl_terima BETWEEN '".tglSQL($tgl_filter1)."' AND '".tglSQL($tgl_filter2)."'";
							//echo $sql."<br>";
							$rs = mysql_query($sql);
						}
					}
				}
		   }
		}
        break;
    case 'edit':
	   //$sama = variable untuk cek kesamaan antara id_trans / supplier_id sebelumnya dan sekarang, defaultnya false.
	   /*$sama = false;
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
	   if(($id_ma_sak == 378 || $id_ma_sak == 379) && $sama == false){
	    	if($jenis_supplier=='1'){
		  		$sql = "update ".$dbapotek.".a_penerimaan p set bayar = 1 WHERE WHERE p.TIPE_TRANS=0 AND p.STATUS=1 AND p.BATCH='".$nofaktur."' and bayar = 0";
	    	}
	    	else if($jenis_supplier=='2'){
				$sql = " update ".$dbaset.".as_masuk m set bayar = 1 
				WHERE m.po_id in (SELECT id FROM  ".$dbaset.".as_po where no_po='".$nofaktur."' ) and bayar = 0";
	    	}
		  	$rs = mysql_query($sql);
	   }*/
	   
	   if ($jenis_supplier==0){
	   		$nilai_sim=$nilai;
	   }
	   
	   $sql = "update ".$dbkeuangan.".k_transaksi set id_trans = '$id_trans', tgl = '$tgl', no_bukti = '$nobukti', no_faktur = '$nofaktur'
		  ,jenis_supplier='$jenis_supplier', supplier_id = '$supplier_id', jenis_layanan = '$jenis_layanan', unit_id = '$unit_id', nilai_sim = '$nilai_sim', nilai = '$nilai'
		  , ket = '$ket', id_ma_sak = '$id_ma_sak', id_ma_dpa = '$idma'
		  where id = '$id'";
	   $rs = mysql_query($sql);
	   
	      $transaksi_id = $id;
		  $sqldel="delete from k_transaksi_detail where transaksi_id=".$transaksi_id;
		  mysql_query($sqldel);
		  $fdata = $_REQUEST['fdata'];
		  $temp = explode("|",$fdata);
		  for($i=1;$i<=count($temp)-1;$i++){
				$tmp = explode("*",$temp[$i]);
				$sql2 = "insert into ".$dbkeuangan.".k_transaksi_detail (transaksi_id,jenis_layanan_id,unit_id,nilai,nilai_sim) values ('$transaksi_id','$tmp[0]','$tmp[1]','$tmp[3]','$tmp[3]')";
				mysql_query($sql2);
				//$up = "update ".$dbkeuangan.".k_transaksi set id_ma_sak='$tmp[2]',unit_id='0' where id=$transaksi_id";
				//mysql_query($up);
		  }
        break;
    case 'hapus':
	   $sql = "select no_faktur,IFNULL(no_terima,'') no_terima,jenis_supplier from k_transaksi where id = '$id' and jenis_supplier <> 0";
	   //echo $sql."<br>";
	   $rs = mysql_query($sql);
	   if(mysql_num_rows($rs) > 0){
		  $row = mysql_fetch_array($rs);
		  $jenis_supplier=$row['jenis_supplier'];
		  $nterima=$row['no_terima'];
		  if($jenis_supplier=='1'){
		  	if ($nterima==""){
				$sql = "update ".$dbapotek.".a_penerimaan p set bayar = 1 WHERE p.TIPE_TRANS=0 AND p.STATUS=1 AND p.BATCH='".$row['no_faktur']."' AND p.bayar = 2";
				//echo $sql."<br>";
				$rs = mysql_query($sql);
			}else{
				$nterima=explode("|",$nterima);
				for ($i=0;$i<count($nterima);$i++){
					$sql = "update ".$dbapotek.".a_penerimaan p set bayar = 1 WHERE p.TIPE_TRANS=0 AND p.STATUS=1 AND p.BATCH='".$row['no_faktur']."' AND p.NOTERIMA='$nterima[$i]' AND p.bayar = 2";
					//echo $sql."<br>";
					$rs = mysql_query($sql);
				}
			}
		  }
		  else if($jenis_supplier=='2'){
		  	if ($nterima==""){
				$sql = "update ".$dbaset.".as_masuk m set bayar = 0
					WHERE m.po_id in (SELECT id FROM  ".$dbaset.".as_po where no_po='".$row['no_faktur']."' ) and bayar = 2";
				//echo $sql."<br>";
				$rs = mysql_query($sql);
			}else{
				$nterima=explode("|",$nterima);
				for ($i=0;$i<count($nterima);$i++){
					$sql = "update ".$dbaset.".as_masuk m set bayar = 0
							WHERE m.po_id in (SELECT id FROM  ".$dbaset.".as_po where no_po='".$row['no_faktur']."' ) 
							and m.no_gudang='$nterima[$i]' and bayar = 2";
					//echo $sql."<br>";
					$rs = mysql_query($sql);
				}
			}
		  }
	   }
	   
	   $sql = "delete from ".$dbkeuangan.".k_transaksi where id = '$id'";
	   $rs = mysql_query($sql);
	   $sqldel = "delete from ".$dbkeuangan.".k_transaksi_detail where transaksi_id = '$id'";
	   mysql_query($sqldel);
	   break;
	case 'pengeluaranlain2_bayarpajak':
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
			
			//=================
			// cek apakah ada data pajak sebelumnya
			
			$tgl=$TglBayar;
			$nokw=$noBukti;
			$sCek="SELECT * FROM k_transaksi_detail WHERE transaksi_id='".$id."' AND jenis_pajak=0";
			$qCek=mysql_query($sCek);
	
			if ($arfdata[0]!="" && mysql_num_rows($qCek)<=0){
						//echo "masuk";
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
						
						//$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
						$sql="SELECT NO_TRANS AS no_trans,NO_PASANGAN AS no_psg,URAIAN FROM ".$dbakuntansi.".jurnal WHERE NO_KW='".$_REQUEST['noBukti']."' LIMIT 1";
						$rs1=mysql_query($sql);
						$no_trans=1;$no_psg=1;
						if ($rows=mysql_fetch_array($rs1)){
							$no_trans=$rows["no_trans"];
							$no_psg=$rows["no_psg"];
							$uraian=$rows["URAIAN"];
						}
						
						$nilai2=0;
						for ($i=0;$i<count($arpajak);$i++){
							$dataPajak=explode("|",$arpajak[$i]);
							$nilai1=$dataPajak[1];
							$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,NO_PASANGAN,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,PAJAK,POSTING) values($no_trans,$no_psg,$dataPajak[0],'$tgl','$nokw','$uraian',0,$nilai1,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1,1)";
							//echo $sql."<br>";
							$rs1 = mysql_query($sql);
							$sql="insert into ".$dbkeuangan.".k_transaksi_detail(transaksi_id,nilai,nilai_sim,pajak_id,jenis_pajak,ket) values('$id',$nilai1,$nilai1,$dataPajak[0],0,'$uraian')";
							//echo $sql."<br>";
							$rs1 = mysql_query($sql);
							
							$nilai2 +=$nilai1;
						}
						
						$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,NO_PASANGAN,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,PAJAK,POSTING) values($no_trans,$no_psg,$ma_dPajak,'$tgl','$nokw','$uraian',$nilai2,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1,1)";
						//echo $sql."<br>";
						$rs1 = mysql_query($sql);
			}
			
			
			//===================
		
			$sql="SELECT ket FROM k_transaksi WHERE id=".$id;
			$rs2=mysql_query($sql);
			$rw2=mysql_fetch_array($rs2);
			$uraian=$rw2['ket'];
			
			$arpajak=explode(chr(6),$arfdata[0]);
		
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
							
							//$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans FROM ".$dbakuntansi.".jurnal";
							$sql="SELECT NO_TRANS AS no_trans,NO_PASANGAN AS no_psg,URAIAN FROM ".$dbakuntansi.".jurnal WHERE NO_KW='".$_REQUEST['noBukti']."' LIMIT 1";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);
							$no_trans=1;$no_psg=1;
							if ($rows=mysql_fetch_array($rs1)){
								$no_trans=$rows["no_trans"];
								$no_psg=$rows["no_psg"];
							}
							
							$nilai2=0;
							for ($i=0;$i<count($arpajak);$i++){
								$dataPajak=explode("|",$arpajak[$i]);
								$nilai1=$dataPajak[1];
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,NO_PASANGAN,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,PAJAK,POSTING) values($no_trans,$no_psg,$dataPajak[0],'$TglBayarPajak','$nokw','$uraian',$nilai1,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
								$sql="insert into ".$dbkeuangan.".k_transaksi_detail(transaksi_id,nilai,nilai_sim,pajak_id,jenis_pajak,ket) values('$id',$nilai1,$nilai1,$dataPajak[0],1,'$uraian')";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
								$nilai2 +=$nilai1;
							}
							
							$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,NO_PASANGAN,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,PAJAK,POSTING) values($no_trans,$no_psg,$ma_kPajak,'$TglBayarPajak','$nokw','$uraian',0,$nilai2,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1,1)";
							//echo $sql."<br>";
							$rs1 = mysql_query($sql);
						}
		}
		break;
    case 'pengeluaranlain2':
		$iduser=24;//user dr posting keuangan
		$noBukti = $_REQUEST['noBukti'];
		$TglBayar = tglSQL($_REQUEST['TglBayar']);
		$TglBayarPajak = $_REQUEST['TglBayarPajak'];
		$ftglByrPajak="";
		if ($TglBayarPajak!="") {
			$TglBayarPajak = tglSQL($TglBayarPajak);
			$ftglByrPajak=",tgl_klaim='$TglBayarPajak'";
		}
		$tcaraBayar = $_REQUEST['tcaraBayar'];
		$fdata = $_REQUEST['fdata'];
		$arfdata = explode(chr(5),$fdata);
		$dataTrans = explode(chr(6),$arfdata[1]);
		for ($j=0;$j<count($dataTrans);$j++){
			$id = $dataTrans[$j];
			$sql = "select * from ".$dbkeuangan.".k_transaksi where id = '$id' and verifikasi = 1";
			echo $sql.";<br>";
			$rs = mysql_query($sql);
			if(mysql_num_rows($rs) > 0){
				$row = mysql_fetch_array($rs);
				$id_trans = $row['id_trans'];
				$sql = "update ".$dbkeuangan.".k_transaksi set no_bukti='$noBukti',tgl='$TglBayar'".$ftglByrPajak.",posting=1 where id = '$id'";
				echo $sql.";<br>";
				$rs1 = mysql_query($sql);
				if (mysql_errno()==0){

					$sql="SELECT t.*,IFNULL(td.unit_id,0) td_unit_id,IFNULL(td.nilai_sim,0) td_nilai_sim,IFNULL(td.nilai,0) td_nilai 
FROM k_transaksi t LEFT JOIN k_transaksi_detail td ON t.id=td.transaksi_id 
WHERE t.id='$id' AND (td.pajak_id=0 OR td.pajak_id IS NULL)";
					echo $sql.";<br>";
					$rs2=mysql_query($sql);
					
					$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM ".$dbakuntansi.".jurnal";
					echo $sql.";<br>";
					$rs1=mysql_query($sql);
					$no_trans=1;$no_psg=1;
					if ($rows=mysql_fetch_array($rs1)){
						$no_trans=$rows["no_trans"];
						$no_psg=$rows["no_psg"];
					}
					
					$jenis_suplier=0;
					while ($rw2=mysql_fetch_array($rs2)){
						/*$sql="";
						$rs3=mysql_query($sql);
						$rw3=mysql_fetch_array($rs3);*/
						//****************
						$jenis_suplier=$rw2["jenis_supplier"];
						if ($rw2["td_nilai"]>0){
							$nilai=$rw2["td_nilai"];
							$selisih=0;
						}else{
							$nilai=$rw2["nilai"];
							$selisih=$rw2["nilai_sim"]-$nilai;
						}
						
						$nilai2=$rw2["nilai"];
						
						$tgl=$TglBayar;
						$nokw=$noBukti;
						$cc_pbf_umumId=0;
						if ($rw2["jenis_supplier"]>0){
							$cc_pbf_umumId=$rw2["supplier_id"];
						}elseif ($rw2["unit_id"]>0){
							$cc_pbf_umumId=$rw2["unit_id"];
						}elseif ($rw2["td_unit_id"]>0){
							$cc_pbf_umumId=$rw2["td_unit_id"];
						}
						
						$uraian=$rw2["ket"];
						
						// jtrans = 26 = Pembayaran Pembelian Obat
						// ma_d = 378 = Hutang Usaha Kpd Supplier Obat & Alkes
						// ma_k = 10 = Kas Bendahara Pengeluaran, 31 = Bank Jatim
						$jtrans=$rw2["id_trans"];
						//$ma_d=$rw2["id_ma_sak"];
						$ma_d=1071;
						$ma_k=7;
						if ($tcaraBayar==2){
							$ma_k=12;
						}elseif ($tcaraBayar==3){
							$ma_k=15;
						}
						
						//$sql="SELECT dt.* FROM $dbakuntansi.detil_transaksi dt WHERE dt.fk_jenis_trans='$jtrans' AND dt.id_cc_rv_kso_pbf_umum='$cc_pbf_umumId'";
						$sql="SELECT
								  dt.*,ma.MA_KODE
								FROM $dbakuntansi.detil_transaksi dt
								  INNER JOIN $dbakuntansi.ma_sak ma
									ON dt.fk_ma_sak = ma.MA_ID
								WHERE dt.fk_jenis_trans = '$jtrans' AND LEFT(ma.MA_KODE,1)<>'1' /*AND dt.dk='D'*/
									AND dt.id_cc_rv_kso_pbf_umum = '$cc_pbf_umumId'";
						echo $sql.";<br>";
						$rs1 = mysql_query($sql);
						if (mysql_num_rows($rs1) > 0){
							$rw1=mysql_fetch_array($rs1);
							$ma_d=$rw1["fk_ma_sak"];
						}
						
						$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,NO_PASANGAN,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING) values($no_trans,$no_psg,$ma_d,'$tgl','$nokw','$uraian',$nilai,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,$cc_pbf_umumId,$cc_pbf_umumId,1)";
						echo $sql.";<br>";
						$rs1 = mysql_query($sql);
						
						if ($rw2["jenis_supplier"]>0){
							$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,NO_PASANGAN,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$no_psg,$ma_k,'$tgl','$nokw','$uraian',0,$nilai2,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,'$cc_pbf_umumId',1)";
							echo $sql.";<br>";
							$rs1 = mysql_query($sql);
						}
						
						if ($selisih<>0){
							// jtrans = 24 = Terjadi Pengurang Pembelian, Jika Transaksi Belum Terbayar (Supplier Obat)
							// jtrans = 23 = Terjadi Penambah Pembelian, Jika Transaksi Belum Terbayar (Supplier Obat)
							// jtrans = 289 = Terjadi Pengurang Pembelian, Jika Transaksi Belum Terbayar (Supplier Umum)
							// jtrans = 290 = Terjadi Penambah Pembelian, Jika Transaksi Belum Terbayar (Supplier Umum)
							// ma_d = 378 = Hutang Usaha Kpd Supplier Obat & Alkes
							// ma_d = 379 = Hutang Usaha Kpd Supplier Umum
							// ma_k = 67 = Persediaan Obat & Alkes
							
							$cc_pbf_umumId_SelD=$cc_pbf_umumId;
							$cc_pbf_umumId_SelK=0;
							
							if ($rw2["jenis_supplier"]==1){
								$jtrans=24;
								$ma_d=378;
								$ma_k_sel=67;
								if ($selisih<0){
									$jtrans=23;
									$ma_k_sel=378;
									$ma_d=67;
									$selisih=$selisih * -1;
									$cc_pbf_umumId_SelK=$cc_pbf_umumId;
									$cc_pbf_umumId_SelD=0;
								}
							}else{
								$jtrans=289;
								$ma_d=379;
								$ma_k_sel=80;
								if ($selisih<0){
									$jtrans=290;
									$ma_k_sel=379;
									$ma_d=80;
									$selisih=$selisih * -1;
									$cc_pbf_umumId_SelK=$cc_pbf_umumId;
									$cc_pbf_umumId_SelD=0;
								}
							}
							
							$uraian_selisih = $uraian." : Selisih (SIM - SPK)";
							
							$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM ".$dbakuntansi.".jurnal";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);
							$no_transSel=1;$no_psgSel=1;
							if ($rows=mysql_fetch_array($rs1)){
								$no_transSel=$rows["no_trans"];
								$no_psgSel=$rows["no_psg"];
							}
							
							$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,NO_PASANGAN,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,SELISIH,POSTING) values($no_transSel,$no_psgSel,$ma_d,'$tgl','$nokw','$uraian_selisih',$selisih,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,$cc_pbf_umumId_SelD,1,1)";
							//echo $sql."<br>";
							//$rs1 = mysql_query($sql);
							
							$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,NO_PASANGAN,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,SELISIH,POSTING) values($no_transSel,$no_psgSel,$ma_k_sel,'$tgl','$nokw','$uraian_selisih',0,$selisih,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,$cc_pbf_umumId_SelK,1,1)";
							//echo $sql."<br>";
							//$rs1 = mysql_query($sql);
						}
					}
					//echo "Jenis_suplier=".$rw2["jenis_supplier"]."<br>";
					if ($jenis_suplier==0){
						$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,NO_PASANGAN,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,POSTING) values($no_trans,$no_psg,$ma_k,'$tgl','$nokw','$uraian',0,$nilai2,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1)";
						//echo $sql.";<br>";
						//$rs1 = mysql_query($sql);
					}
					
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
						
						$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM ".$dbakuntansi.".jurnal";
						$rs1=mysql_query($sql);
						$no_trans=1;$no_psg=1;
						if ($rows=mysql_fetch_array($rs1)){
							$no_trans=$rows["no_trans"];
							$no_psg=$rows["no_psg"];
						}
						
						$nilai2=0;
						
						for ($i=0;$i<count($arpajak);$i++){
							$dataPajak=explode("|",$arpajak[$i]);
							$nilai1=$dataPajak[1];
							$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,NO_PASANGAN,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,PAJAK,POSTING) values($no_trans,$no_psg,$dataPajak[0],'$tgl','$nokw','$uraian',0,$nilai1,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1,1)";
							//echo $sql."<br>";
							$rs1 = mysql_query($sql);
							$sql="insert into ".$dbkeuangan.".k_transaksi_detail(transaksi_id,nilai,nilai_sim,pajak_id,jenis_pajak,ket) values('$id',$nilai1,$nilai1,$dataPajak[0],0,'$uraian')";
							//echo $sql."<br>";
							$rs1 = mysql_query($sql);
							
							$nilai2 +=$nilai1;
						}
						
						$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,NO_PASANGAN,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,PAJAK,POSTING) values($no_trans,$no_psg,$ma_dPajak,'$tgl','$nokw','$uraian',$nilai2,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1,1)";
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
							
							$sql="SELECT IFNULL(MAX(no_trans)+1,1) AS no_trans,IFNULL(MAX(NO_PASANGAN)+1,1) AS no_psg FROM ".$dbakuntansi.".jurnal";
							//echo $sql."<br>";
							$rs1=mysql_query($sql);
							$no_trans=1;$no_psg=1;
							if ($rows=mysql_fetch_array($rs1)){
								$no_trans=$rows["no_trans"];
								$no_psg=$rows["no_psg"];
							}
							
							$nilai2=0;
							for ($i=0;$i<count($arpajak);$i++){
								$dataPajak=explode("|",$arpajak[$i]);
								$nilai1=$dataPajak[1];
								$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,NO_PASANGAN,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,PAJAK,POSTING) values($no_trans,$no_psg,$dataPajak[0],'$TglBayarPajak','$nokw','$uraian',$nilai1,0,CURDATE(),$iduser,'D',0,$jtrans,$jtrans,0,1,1)";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
								$sql="insert into ".$dbkeuangan.".k_transaksi_detail(transaksi_id,nilai,nilai_sim,pajak_id,jenis_pajak,ket) values('$id',$nilai1,$nilai1,$dataPajak[0],1,'$uraian')";
								//echo $sql."<br>";
								$rs1 = mysql_query($sql);
								$nilai2 +=$nilai1;
							}
							
							$sql="insert into ".$dbakuntansi.".JURNAL(no_trans,NO_PASANGAN,fk_sak,tgl,no_kw,uraian,debit,kredit,tgl_act,fk_iduser,d_k,JENIS,fk_trans,FK_LAST_TRANS,CC_RV_KSO_PBF_UMUM_ID,PAJAK,POSTING) values($no_trans,$no_psg,$ma_kPajak,'$TglBayarPajak','$nokw','$uraian',0,$nilai2,CURDATE(),$iduser,'K',0,$jtrans,$jtrans,0,1,1)";
							//echo $sql."<br>";
							$rs1 = mysql_query($sql);
						}
					}
					//**********************
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
	/*$sql = "select * from (select t.id, id_trans, mt.nama as nama_trans,ma.ma_id, ma.ma_nama as ma_nama, date_format(tgl,'%d-%m-%Y') as tgl, no_bukti,t.no_faktur, t.jenis_layanan
		 , uj.nama as nama_jl, unit_id, ut.nama as nama_tl, nilai_sim, nilai, IF((t.no_faktur='' OR t.no_faktur IS NULL),t.ket,CONCAT(t.ket,' (',t.no_faktur,')')) ket,t.ket ket1, IF(t.verifikasi=1,'Sudah','Belum') verifikasi,t.verifikasi verifikasiId, t.posting,jenis_supplier,IF(jenis_supplier='1','(Supplier Obat)',IF(jenis_supplier='2','(Supplier Barang)','')) as nama_jenis_supplier, supplier_id
			from ".$dbkeuangan.".k_transaksi t
			left join ".$dbanggaran.".ms_ma ma on t.id_ma_dpa = ma.ma_id
			left join ".$dbakuntansi.".ak_ms_unit uj on t.jenis_layanan = uj.id
			left join ".$dbakuntansi.".ak_ms_unit ut on t.unit_id = ut.id
			inner join ".$dbkeuangan.".k_ms_transaksi mt on t.id_trans = mt.id
			where month(tgl) = '$bln' and year(tgl) = '$thn' and mt.tipe = 2 ".$strBayar."
			order by $sorting) a1 $filter";*/
	$sql = "SELECT 
			  * 
			FROM
			  (SELECT 
				t.id,
				t.id_ma_sak,
				id_trans,
				ma.ma_id,
				jt.JTRANS_KODE AS kode_trans,
				jt.JTRANS_NAMA AS nama_trans,
				ma.ma_nama AS ma_nama,
				DATE_FORMAT(tgl, '%d-%m-%Y') AS tgl,
				no_bukti,
				t.no_faktur,
				t.jenis_layanan,
				uj.nama AS nama_jl,
				unit_id,
				ut.nama AS nama_tl,
				nilai_sim,
				nilai,
				IF(
				  (
					t.no_faktur = '' 
					OR t.no_faktur IS NULL
				  ),
				  t.ket,
				  CONCAT(t.ket, ' (', t.no_faktur, ')')
				) ket,
				t.ket ket1,
				IF(t.verifikasi = 1, 'Sudah', 'Belum') verifikasi,
				t.verifikasi verifikasiId,
				t.posting,jenis_supplier,
				IF(
				  jenis_supplier = '1',
				  '(Supplier Obat)',
				  IF(
					jenis_supplier = '2',
					'(Supplier Barang)',
					''
				  )
				) AS nama_jenis_supplier,
				supplier_id 
			  FROM
				".$dbkeuangan.".k_transaksi t 
				LEFT JOIN ".$dbanggaran.".ms_ma ma 
				  ON t.id_ma_dpa = ma.ma_id 
				LEFT JOIN ".$dbakuntansi.".ak_ms_unit uj 
				  ON t.jenis_layanan = uj.id 
				LEFT JOIN ".$dbakuntansi.".ak_ms_unit ut 
				  ON t.unit_id = ut.id 
				LEFT JOIN ".$dbakuntansi.".jenis_transaksi jt 
				  ON jt.JTRANS_ID = t.id_trans 
			  WHERE MONTH(tgl) = '$bln' 
				AND YEAR(tgl) = '$thn' AND t.tipe_trans = 2 
				".$strBayar."
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

if($pilihan == "pengeluaran"){
	while ($rows=mysql_fetch_array($rs)) {
		$sCek="SELECT 
			  * 
			FROM
			  k_transaksi_detail 
			WHERE transaksi_id = ".$rows['id']." AND jenis_pajak=1";
		$qCek=mysql_query($sCek);
		//$rwCek=mysql_fetch_array($qCek);
		if(mysql_num_rows($qCek)<=0){
			$status_pajak=1;
		}
		else{
			$status_pajak=0;
		}
		
		$sqld="select * from k_transaksi_detail where transaksi_id=".$rows['id'];
		$kueri=mysql_query($sqld);
		$temp = "";
		$cc=0;
		if (mysql_num_rows($kueri)>0){
			$cc=1;
			while($data=mysql_fetch_array($kueri)){
				$temp = $temp."#".$data['jenis_layanan_id']."*".$data['unit_id']."*".$data['nilai']."*".$data['pajak_id'];
			}
		}
		
		$sisip = $rows['id'].'|'.$rows['id_trans'].'|'.$rows['jenis_layanan'].'|'.$rows['unit_id'].'|'.''.'|'.$rows['no_faktur'].'|'.$rows['supplier_id'].'|'.$rows['nilai'].'|'.$rows['jenis_supplier'].'|'.$rows['verifikasiId'].'|'.$rows['nilai_sim'].'|'.$rows['ma_id'].'|'.$temp.'|'.$rows['kode_trans'].'|'.$rows['id_ma_sak'].'|'.$rows['posting'].'|'.$cc.'|'.$status_pajak;
		$i++;
		$cket="";
		if ($rows['unit_id']!=0) $cket=" - ".$rows['nama_tl'];
		$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows['tgl'].chr(3).$rows["no_bukti"].chr(3).$rows["nama_trans"].$cket.chr(3).$rows["ma_nama"].$rows["nama_jenis_supplier"].chr(3).number_format($rows['nilai'],0,",",".").chr(3).$rows['ket1'].chr(3).$rows['verifikasi'].chr(3)."0".chr(6);
		//(($rows["asalunit"]!='')?"Rujuk dari: ".$rows["asalunit"]:"Loket")tglJamSQL($rows["tgl_act"])
	}
}

if ($dt!=$totpage.chr(5)) {
	$dt=substr($dt,0,strlen($dt)-1).chr(5).''."*|*";
	//$dt=str_replace('"','\"',$dt);
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