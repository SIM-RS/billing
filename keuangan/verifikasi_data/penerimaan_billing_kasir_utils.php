<?php
include("../koneksi/konek.php");
include("../sesi.php");
include("../include/variable.inc.php");
include("distribusiBiayaKsoPx.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$id = $_REQUEST['rowid'];
//echo $tgl."<br>";
$grd = $_REQUEST['grd'];
//echo $grd."<br>";
$kasir = $_REQUEST['kasir'];
$tanggal = $_REQUEST['tanggal'];
//$tglP = tglSQL($tanggal);
$tanggalSlip = $_REQUEST['tanggalSlip'];
$no_slip = $_REQUEST['no_slip'];
$posting = $_REQUEST['posting'];
$idUser = $_REQUEST['idUser'];

$bayar_id = $_REQUEST['bayar_id'];

$jenis_lay_IPIT=94;
$jenis_lay_Pav=50;
//===============================
$IdTrans=38;
$Idma_sak_d=8;
$Idma_sak_k_umum=488;//===pendapatan px umum
$Idma_sak_k_kso=490;//===pendapatan px kso
$Idma_sak_k=$Idma_sak_k_umum;
$Idma_dpa=6;
//===============================
$statusProses='';
$alasan='';
switch(strtolower($_REQUEST['act'])) {
    case 'ubah_jenis_bayar':
		$cbyrId = $_REQUEST['cbyrId'];
		$cjbyr = ($_REQUEST['cjbyr']=="0")?"1":"0";
		$sql="UPDATE $dbbilling.b_bayar SET jenis_bayar='$cjbyr' WHERE id='$cbyrId'";
		$rs=mysql_query($sql);
		if (mysql_affected_rows()>0){
			if ($cjbyr=="0"){
				$tclr="blue";
				$tspnTxt="Bayar Tagihan";
			}else{
				$tclr="#FF00FF";
				$tspnTxt="Bayar Piutang";
			}
			echo "OK|".$cbyrId."|".$cjbyr."|".$tclr."|".$tspnTxt;
		}else{
			echo "ERROR|";
		}
		return;
		break;
    case 'koreksi_distribusi':
		//$noSlip=$_REQUEST["noSlip"];
		$fdata=$_REQUEST["fdata"];
		$arfdata=explode(chr(6),$fdata);
		for ($i=0;$i<count($arfdata);$i++)
		{
			$cdata=explode(chr(5),$arfdata[$i]);
			$idBayar=$cdata[0];
			$nilaiBayar=$cdata[1];
			$kasirId=$cdata[2];
			
			$sql="SELECT * FROM $dbbilling.b_bayar WHERE id='$idBayar' AND posting=0 AND b.flag='$flag'";
			//echo $sql.";<br>";
			$rsPost=mysql_query($sql);
			if (mysql_num_rows($rsPost)>0){
				$rwPost=mysql_fetch_array($rsPost);
				$kso_id=$rwPost["kso_id"];
				$jenis_kunjungan=$rwPost["jenis_kunjungan"];
				$jBayar=$rwPost["jenis_bayar"];
				
				$sql="SELECT 
						  IFNULL(SUM(gab.nilai),0) AS nilai,
						  IFNULL(SUM(gab.biaya),0) AS biaya,
						  IFNULL(SUM(gab.biaya_kso),0) AS biaya_kso,
						  IFNULL(SUM(gab.biaya_pasien),0) AS biaya_pasien,
						  IFNULL(SUM(gab.bayar),0) AS bayar,
						  IFNULL(SUM(gab.bayar),0) AS bayar_kso,
						  IFNULL(SUM(gab.bayar),0) AS bayar_pasien
						FROM 
						(SELECT
						  bt.nilai,
						  bt.tindakan_id,
						  t.biaya,
						  t.biaya_kso,
						  t.biaya_pasien,
						  t.bayar,
						  t.bayar_kso,
						  t.bayar_pasien
						FROM $dbbilling.b_bayar_tindakan bt
						  INNER JOIN $dbbilling.b_tindakan t
							ON bt.tindakan_id = t.id
						WHERE bt.bayar_id = '$idBayar' AND bt.tipe=0
						UNION
						SELECT
						  bt.nilai,
						  bt.tindakan_id,
						  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)=0,1, DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in))), (IF(DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)=0,0, DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)))) * t.tarip        AS biaya,
						  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)=0,1, DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in))), (IF(DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)=0,0, DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)))) * t.beban_kso    AS biaya_kso,
						  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)=0,1, DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in))), (IF(DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)=0,0, DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)))) * t.beban_pasien AS biaya_pasien,
						  t.bayar,
						  t.bayar_kso,
						  t.bayar_pasien
						FROM $dbbilling.b_bayar_tindakan bt
						  INNER JOIN $dbbilling.b_tindakan_kamar t
							ON bt.tindakan_id = t.id
						WHERE bt.bayar_id = '$idBayar'
							AND bt.tipe = 1
						UNION
						SELECT
						  bt.nilai,
						  bt.tindakan_id,
						  t.QTY_JUAL * t.HARGA_SATUAN AS  biaya,
						  0 AS biaya_kso,
						  t.QTY_JUAL * t.HARGA_SATUAN AS  biaya_pasien,
						  0 AS bayar,
						  0 AS bayar_kso,
						  0 AS bayar_pasien
						FROM $dbbilling.b_bayar_tindakan bt
						  INNER JOIN $dbapotek.a_penjualan t
							ON bt.tindakan_id = t.ID
						WHERE bt.bayar_id = '$idBayar' AND bt.tipe=2) AS gab";
				//echo $sql.";<br>";
				$rsPost=mysql_query($sql);
				$rwPost=mysql_fetch_array($rsPost);
				$nBayarTind=$rwPost["nilai"];
				$nBiayaPasien=$rwPost["biaya_pasien"];
				$nBayarPasien=$rwPost["bayar_pasien"];
				//echo "nilaiBayar=$nilaiBayar, nBiayaPasien=$nBiayaPasien, nBayarPasien=$nBayarPasien".";<br>";
				if (($nilaiBayar==($nBiayaPasien-$nBayarPasien)) || ($nilaiBayar==$nBiayaPasien)){
					$sql="SELECT
							  bt.id,
							  bt.tipe,
							  bt.nilai,
							  bt.tindakan_id,
							  t.biaya,
							  t.biaya_kso,
							  t.biaya_pasien,
							  t.bayar,
							  t.bayar_kso,
							  t.bayar_pasien
							FROM $dbbilling.b_bayar_tindakan bt
							  INNER JOIN $dbbilling.b_tindakan t
								ON bt.tindakan_id = t.id
							WHERE bt.bayar_id = '$idBayar' AND bt.tipe=0
							UNION
							SELECT
							  bt.id,
							  bt.tipe,
							  bt.nilai,
							  bt.tindakan_id,
							  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)=0,1, DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in))), (IF(DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)=0,0, DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)))) * t.tarip        AS biaya,
							  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)=0,1, DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in))), (IF(DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)=0,0, DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)))) * t.beban_kso    AS biaya_kso,
							  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)=0,1, DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in))), (IF(DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)=0,0, DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)))) * t.beban_pasien AS biaya_pasien,
							  t.bayar,
							  t.bayar_kso,
							  t.bayar_pasien
							FROM $dbbilling.b_bayar_tindakan bt
							  INNER JOIN $dbbilling.b_tindakan_kamar t
								ON bt.tindakan_id = t.id
							WHERE bt.bayar_id = '$idBayar'
								AND bt.tipe = 1
							UNION
							SELECT
							  bt.id,
							  bt.tipe,
							  bt.nilai,
							  bt.tindakan_id,
							  t.QTY_JUAL * t.HARGA_SATUAN AS  biaya,
							  0 AS biaya_kso,
							  t.QTY_JUAL * t.HARGA_SATUAN AS  biaya_pasien,
							  0 AS bayar,
							  0 AS bayar_kso,
							  0 AS bayar_pasien
							FROM $dbbilling.b_bayar_tindakan bt
							  INNER JOIN $dbapotek.a_penjualan t
								ON bt.tindakan_id = t.ID
							WHERE bt.bayar_id = '$idBayar' AND bt.tipe=2";
					//echo $sql.";<br>";
					$rsPost=mysql_query($sql);
					while ($rwPost=mysql_fetch_array($rsPost)){
						$cid=$rwPost["id"];
						$ctipe=$rwPost["tipe"];
						$cnilai=$rwPost["nilai"];
						$ctindakan_id=$rwPost["tindakan_id"];
						$cbiaya_pasien=$rwPost["biaya_pasien"];
						$cbayar_pasien=$rwPost["bayar_pasien"];
						$cnbayar=$cbiaya_pasien-$cbayar_pasien;
						if ($cnbayar==0){
							$cnbayar=$cbayar_pasien;
						}
						
						$tBayarPxNonPiutang="";
						if ($jBayar==0){
							$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$cnbayar,";
						}
						
						$cbayar=$rwPost["bayar"];
						//echo "cnilai=$cnilai, tipe=$ctipe".";<br>";
						//if ($cnilai==0){
							switch ($ctipe){
								case 0:
									$sql="UPDATE $dbbilling.b_bayar_tindakan SET nilai=$cnbayar,kso_id=$kso_id WHERE id='$cid'";
									//echo $sql.";<br>";
									$rsUpdt=mysql_query($sql);
									if ((mysql_affected_rows()>0) && ($cbiaya_pasien!=$cbayar_pasien)){
										$sql="UPDATE $dbbilling.b_tindakan 
												SET bayar=bayar+$cnbayar,bayar_pasien=bayar_pasien+$cnbayar,".$tBayarPxNonPiutang."lunas=1 
											  WHERE id='$ctindakan_id'";
										//echo $sql.";<br>";
										$rsUpdt=mysql_query($sql);
										if (mysql_errno()>0 || mysql_affected_rows()==0){
											$sql="UPDATE $dbbilling.b_bayar_tindakan SET nilai=$cnilai WHERE id='$cid'";
											//echo $sql."<br>";
											$rsUpdt=mysql_query($sql);
										}
									}
									break;
								case 1:
									$sql="UPDATE $dbbilling.b_bayar_tindakan SET nilai=$cnbayar,kso_id=$kso_id WHERE id='$cid'";
									//echo $sql.";<br>";
									$rsUpdt=mysql_query($sql);
									if (mysql_affected_rows()>0){
										$sql="UPDATE $dbbilling.b_tindakan_kamar 
												SET bayar=bayar+$cnbayar,bayar_pasien=bayar_pasien+$cnbayar,".$tBayarPxNonPiutang."lunas=1 
											  WHERE id='$ctindakan_id'";
										//echo $sql.";<br>";
										$rsUpdt=mysql_query($sql);
										if (mysql_errno()>0 || mysql_affected_rows()==0){
											$sql="UPDATE $dbbilling.b_bayar_tindakan SET nilai=$cnilai WHERE id='$cid'";
											//echo $sql."<br>";
											$rsUpdt=mysql_query($sql);
										}
									}
									break;
								case 2:
									$sql="UPDATE $dbbilling.b_bayar_tindakan SET nilai=$cnbayar,kso_id=$kso_id WHERE id='$cid'";
									//echo $sql.";<br>";
									$rsUpdt=mysql_query($sql);
									/*if (mysql_affected_rows()>0){
										$sql="UPDATE $dbapotek.a_penjualan 
												SET bayar=bayar+$cnbayar,bayar_pasien=bayar_pasien+$cnbayar,lunas=1 
											  WHERE id='$ctindakan_id'";
										$rsUpdt=mysql_query($sql);
										if (mysql_errno()>0 || mysql_affected_rows()==0){
											$sql="UPDATE $dbbilling.b_bayar_tindakan SET nilai=$cnilai WHERE id='$cid'";
											$rsUpdt=mysql_query($sql);
										}
									}*/
									break;
							}
						//}
					}
				}else{
					$sql="SELECT kunjungan_id FROM $dbbilling.b_bayar WHERE id='$idBayar' AND posting=0 AND flag='$flag'";
					//echo $sql.";<br>";
					$rsPost=mysql_query($sql);
					if (mysql_num_rows($rsPost)>0){
						$rwPost=mysql_fetch_array($rsPost);
						$kunj_id=$rwPost["kunjungan_id"];
						//=======Cek Apakah sudah ada pembayaran yg diverif u/ kunjungan ini
						$sql="SELECT * FROM $dbbilling.b_bayar WHERE kunjungan_id='$kunj_id' AND posting=1";
						//echo $sql.";<br>";
						$rsPost=mysql_query($sql);
						$sdh_posting=0;
						if (mysql_num_rows($rsPost)>0){
							$sdh_posting=1;
						}
						/*while ($rwPost=mysql_fetch_array($rsPost)){
							$cidBayar=$rwPost["id"];
							//Proses Unposting data yg sdh diposting
							//cek apakah sdh diposting ke jurnal akuntansi
							$sql="SELECT * FROM k_transaksi WHERE fk_id='$cidBayar' AND posting=0";
							//echo $sql.";<br>";
							$rsCekPost=mysql_query($sql);
							if (mysql_num_rows($rsCekPost)>0){	//====blm diposting, bisa diproses====
								$sql="UPDATE $dbbilling.b_bayar SET posting=0 WHERE id='$cidBayar'";
								//echo $sql.";<br>";
								$rsUpdt=mysql_query($sql);
								//Delete k_transaksi
								$sql="DELETE FROM k_transaksi WHERE fk_id='$cidBayar'";
								//echo $sql.";<br>";
								$rsUpdt=mysql_query($sql);
							}else{
								$sdh_posting=1;
							}
							
						}*/
						
						if ($sdh_posting==0){
							//===Proses Distribusi Ulang===
							$sql="SELECT id FROM $dbbilling.b_bayar WHERE kunjungan_id='$kunj_id'";
							//echo $sql.";<br>";
							$rsPost=mysql_query($sql);
							$isOk=1;
							while ($rwPost=mysql_fetch_array($rsPost)){
								$cidBayarDel=$rwPost["id"];
								$sql="DELETE FROM $dbbilling.b_bayar_tindakan WHERE bayar_id = '$cidBayarDel'";
								//echo $sql.";<br>";
								$rsPostDel=mysql_query($sql);
							}
							
							$sql="UPDATE $dbbilling.b_tindakan SET bayar=0,bayar_kso=0,bayar_pasien=0,bayar_pasien_non_piutang=0,lunas=0 WHERE kunjungan_id='$kunj_id'";
							//echo $sql.";<br>";
							$rsPost=mysql_query($sql);
							
							$sql="UPDATE $dbbilling.b_tindakan_kamar,$dbbilling.b_pelayanan 
									SET $dbbilling.b_tindakan_kamar.bayar=0,
										$dbbilling.b_tindakan_kamar.bayar_kso=0,
										$dbbilling.b_tindakan_kamar.bayar_pasien=0,
										$dbbilling.b_tindakan_kamar.bayar_pasien_non_piutang=0,
										$dbbilling.b_tindakan_kamar.lunas=0 
								WHERE $dbbilling.b_tindakan_kamar.pelayanan_id=$dbbilling.b_pelayanan.id 
									AND $dbbilling.b_pelayanan.kunjungan_id='$kunj_id'";
							//echo $sql.";<br>";
							$rsPost=mysql_query($sql);
							//=====Koreksi Distribusi Biaya_Px====
							$blmDistribusiBiaya=1;
							$sql="SELECT
									  t.*
									FROM $dbbilling.b_tindakan t
									  INNER JOIN $dbbilling.b_pelayanan p
										ON t.pelayanan_id = p.id
									WHERE p.kunjungan_id = '$kunj_id'
										AND p.jenis_kunjungan = '$jenis_kunjungan'
										AND t.kso_id = '$kso_id'
										AND t.biaya_pasien > t.bayar_pasien";
							//echo $sql.";<br>";
							$rsCekBlmDistribusi=mysql_query($sql);
							if (mysql_num_rows($rsCekBlmDistribusi)>0){
								$blmDistribusiBiaya=0;
							}
							
							$cIsKsoPlafon = 0;
							$arrIdKsoPlafon=explode(",",$idKsoPlafon);
							for ($i=0;$i<count($arrIdKsoPlafon);$i++){
								if ($arrIdKsoPlafon[$i]==$kso_id){
									$cIsKsoPlafon = 1;
								}
							}
							
							if ($cIsKsoPlafon==1){
								$biaya_px=0;
								$biaya_rs=0;
								
								$sCek="select * from $dbbilling.b_jaminan_kso where kunjungan_id='$kunj_id'";
								//echo $sCek.";<br>";
								$qCek=mysql_query($sCek);
								if(mysql_num_rows($qCek)>0){
									$rwCek=mysql_fetch_array($qCek);
									$biaya_kso=$rwCek['biaya_kso'];
								}
								
								$sql="SELECT * FROM $dbbilling.b_kunjungan WHERE id='$kunj_id'";
								//echo $sql.";<br>";
								$rs=mysql_query($sql);
								$rw=mysql_fetch_array($rs);
								$kso_id=$rw["kso_id"];
								
								$sqlTin="select IFNULL(sum((t.biaya)*t.qty),0) as total,IFNULL(SUM(t.bayar),0) AS bayar,IFNULL(sum(((t.biaya_pasien)*t.qty)-t.bayar),0) as kurang from $dbbilling.b_tindakan t
						inner join $dbbilling.b_pelayanan p on t.pelayanan_id=p.id
						where p.kunjungan_id='$kunj_id' AND t.lunas=0 AND t.id NOT IN 
						(SELECT tindakan_id FROM $dbbilling.b_bayar_tindakan bt INNER JOIN $dbbilling.b_bayar b ON bt.bayar_id=b.id 
						INNER JOIN $dbbilling.b_tindakan t ON bt.tindakan_id=t.id 
						WHERE b.kunjungan_id='$kunj_id' AND bt.tipe=0 AND t.lunas=1 AND b.flag='$flag')";
								//echo $sqlTin.";<br/>";
								$rsTin=mysql_query($sqlTin);
								$rwTin=mysql_fetch_array($rsTin);
								$bTin=$rwTin['total'];
								
								$sqlKamar="SELECT IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip),
						(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip))),0) AS kamar,
						IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso),
						(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso))),0) AS kamar_kso,
						IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip)-bayar,
						(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip)-bayar)),0) AS kurang_kamar,SUM(IFNULL(bayar,0)) bayar 
						FROM $dbbilling.b_tindakan_kamar b INNER JOIN $dbbilling.b_pelayanan p ON b.pelayanan_id=p.id 
						WHERE p.kunjungan_id='$kunj_id' AND b.aktif=1";
								//echo $sqlKamar.";<br/>";
								$rsKamar=mysql_query($sqlKamar);
								$rwKamar=mysql_fetch_array($rsKamar);
								$bKamar=$rwKamar['kamar'];
								
								$sqlObat="SELECT IFNULL(SUM(t2.QTY_JUAL),0) QTY_JUAL,IFNULL(SUM(t2.QTY_RETUR),0) QTY_RETUR,
										IFNULL(SUM((t2.QTY_JUAL-t2.QTY_RETUR) * t2.HARGA_SATUAN),0) AS SUBTOTAL 
										FROM (SELECT ap.* FROM $dbapotek.a_penjualan ap INNER JOIN $dbbilling.b_pelayanan p ON ap.NO_KUNJUNGAN=p.id 
										WHERE p.kunjungan_id='$kunj_id' AND ap.CARA_BAYAR=2 AND ap.DIJAMIN=1 and ap.KRONIS<>2) AS t2";
								//echo $sqlObat.";<br/>";
								$rsObat=mysql_query($sqlObat);
								$rwObat=mysql_fetch_array($rsObat);
								$bObat=$rwObat['SUBTOTAL'];
								
								$nilai=$rwTin['total']+$rwKamar['kamar']+$rwObat['SUBTOTAL'];
								$biaya_rs=$nilai;
								
								if ($nilai>$biaya_kso){
									$biaya_px=$nilai-$biaya_kso;
								}
								
								$sCek="select * from $dbbilling.b_jaminan_kso where kunjungan_id='".$kunj_id."'";
								//echo $sCek.";<br>";
								$qCek=mysql_query($sCek);
								if(mysql_num_rows($qCek)==0){
									$sIns="insert into $dbbilling.b_jaminan_kso(kunjungan_id,biaya_rs,biaya_kso,biaya_px) values ('$kunj_id','$biaya_rs','$biaya_kso','$biaya_px')";
									mysql_query($sIns);
								}
								else{
									$sUp="update $dbbilling.b_jaminan_kso set biaya_rs='$biaya_rs', biaya_kso='$biaya_kso', biaya_px='$biaya_px' where kunjungan_id='$kunj_id'";
									mysql_query($sUp);
								}
								
								//====Distribusi Jaminan KSO====
								$nilai = $biaya_kso - $bObat;
								if ($nilai<0) $nilai=0; 
								//$nilai = $biaya_kso;
								//echo "nilai=$nilai"."<br>";
								$sqlKamar="SELECT
											  b.id,
											  tarip,
											  beban_kso,
											  beban_pasien,
											  IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in))),
											  (IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))) AS jml,
											  b.bayar_pasien,
											  b.lunas
											FROM $dbbilling.b_tindakan_kamar b
											  INNER JOIN $dbbilling.b_pelayanan p
												ON b.pelayanan_id = p.id
											WHERE p.kunjungan_id = '$kunj_id'
												AND b.kso_id = '$kso_id'
												AND b.aktif = 1";
								//echo $sqlKamar.";<br/>";
								$rsKamar=mysql_query($sqlKamar);
								$ok = 'true';
								while ($rwKamar = mysql_fetch_array($rsKamar)){
									$tindId = $rwKamar['id'];
									$taripRS = $rwKamar['tarip'];
									$beban_pasien = $rwKamar['beban_pasien'];
									$bayar_pasien = $rwKamar['bayar_pasien'];
									$qtyHari = $rwKamar['jml'];
									if (($biaya_px == 0) && ($bayar_pasien == 0)){
										$biaya = $taripRS;
										$beban_pasien = 0;
									}elseif ($ok == 'true'){
										if (($biaya_kso>=$bKamar)){
											$biaya = $taripRS;
											$beban_pasien = 0;
										}else{
											$biaya = $taripRS - $beban_pasien;
										}
									}else{
										$biaya = 0;
										$beban_pasien = $taripRS;
									}
									
									if($nilai >= ($biaya * $qtyHari)){
										$nilai = $nilai - ($biaya * $qtyHari);
										if ($nilai == 0){
											$ok = 'false';
										}
										
										$sqlUp = "UPDATE $dbbilling.b_tindakan_kamar SET beban_kso = $biaya, beban_pasien = $beban_pasien WHERE id = $tindId";
										//echo $sqlUp.";<br>";
										$rsUp = mysql_query($sqlUp);
									}else{
										$biaya = floor($nilai/$qtyHari);
										$beban_pasien = $taripRS - $biaya;
										$nilai = $nilai - ($biaya * $qtyHari);
										$ok = 'false';
										
										$sqlUp = "UPDATE $dbbilling.b_tindakan_kamar SET beban_kso = $biaya, beban_pasien = $beban_pasien WHERE id = $tindId";
										//echo $sqlUp.";<br>";
										$rsUp = mysql_query($sqlUp);
									}
								}
								//echo "nilai=$nilai"."<br>";
								$sqlTin="select t.* from $dbbilling.b_tindakan t
										inner join $dbbilling.b_pelayanan p on t.pelayanan_id=p.id
										where p.kunjungan_id='$kunj_id' AND t.kso_id='$kso_id' AND t.lunas=0 AND t.id NOT IN 
										(SELECT tindakan_id FROM $dbbilling.b_bayar_tindakan bt INNER JOIN $dbbilling.b_bayar b ON bt.bayar_id=b.id 
										INNER JOIN $dbbilling.b_tindakan t ON bt.tindakan_id=t.id 
										WHERE b.kunjungan_id='".$kunj_id."' AND b.kso_id='$kso_id' AND bt.tipe=0 AND t.lunas=1 AND b.flag = '$flag')";
								//echo $sqlTin.";<br/>";
								$rsTin=mysql_query($sqlTin);
								$ok = 'true';
								while ($rwTind = mysql_fetch_array($rsTin)){
									$tindId = $rwTind['id'];
									$biaya = $rwTind['biaya'];
									$qty = $rwTind['qty'];
									$biayaNilai = $biaya * $qty;
									$biaya_Pasien = $rwTind['biaya_pasien'];
									$bayar_pasien = $rwTind['bayar_pasien'];
									
									if ($biaya_px == 0){
										$biaya_Pasien = 0;
									}elseif (($nilai >= $biayaNilai) && ($bayar_pasien == 0)){
										$biaya_Pasien = 0;
									}elseif ($ok == 'false'){
										if ($nilai > 0){
											$biaya_Pasien = $biaya - $nilai;
											$biaya = $nilai;
											$nilai = 0;
										}else{
											$biaya_Pasien = $biaya;
											$biaya = 0;
										}
									}
									
									if($nilai >= $biayaNilai){
										$nilai = $nilai - $biayaNilai;
										if ($nilai == 0){
											$ok = 'false';
										}
										//echo "nilai=$nilai, tarip=".$rwTind['biaya'].", qty=$qty"."<br>";
										$sqlUp = "UPDATE $dbbilling.b_tindakan SET biaya_kso = $biaya, biaya_pasien = $biaya_Pasien WHERE id = $tindId";
										//echo $sqlUp.";<br>";
										$rsUp = mysql_query($sqlUp);
									}else{
										if ($ok == 'true'){
											$taripRS = $biaya;
											$biaya = floor($nilai/$qty);
											$biaya_Pasien = $taripRS - $biaya;
											$nilai = $nilai - ($biaya * $qty);
										}/*else{
											$biaya_Pasien = $biaya;
											$biaya = 0;
										}*/
										
										$ok = 'false';
										//echo "nilai=$nilai, tarip=".$rwTind['biaya'].", qty=$qty"."<br>";
										$sqlUp = "UPDATE $dbbilling.b_tindakan SET biaya_kso = $biaya, biaya_pasien = $biaya_Pasien WHERE id = $tindId";
										//echo $sqlUp.";<br>";
										$rsUp = mysql_query($sqlUp);
									}
								}
							}
							elseif ($blmDistribusiBiaya==1){
								if ($kso_id==72){	// BPJS
									/* ======================= HAK KELAS ======================== */
									$sHakKelas="SELECT k.kso_kelas_id FROM $dbbilling.b_kunjungan k WHERE k.id='$kunj_id'";
									//echo $sHakKelas.";<br>";
									$qHakKelas=mysql_query($sHakKelas);
									$rwHakKelas=mysql_fetch_array($qHakKelas);
									$kso_kelas_id=$rwHakKelas['kso_kelas_id'];
									/* ======================= END HAK KELAS ======================== */
		
									/* ======================= KELAS TERTINGGI KECUALI PAVILIUN ======================== */
									$sKelasTertinggi="SELECT id,level,nama FROM (
											SELECT  
											mk.id,
											mk.nama,
											mk.level
											FROM $dbbilling.b_pelayanan p
											INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id=mu.id 
											INNER JOIN $dbbilling.b_tindakan t ON p.id=t.pelayanan_id
											INNER JOIN $dbbilling.b_ms_tindakan_kelas mtk ON mtk.id=t.ms_tindakan_kelas_id
											INNER JOIN $dbbilling.b_ms_kso kso ON kso.id=t.kso_id
											inner join $dbbilling.b_ms_kelas mk ON mk.id=t.kelas_id
											WHERE p.kunjungan_id='$kunj_id' 
											AND kso.id=$kso_id
											AND mk.tipe=0
											UNION
											SELECT  
											mk.id,
											mk.nama,
											mk.level
											FROM $dbbilling.b_pelayanan p
											INNER JOIN $dbbilling.b_tindakan_kamar tk ON p.id=tk.pelayanan_id
											INNER JOIN $dbbilling.b_ms_kso kso ON kso.id=tk.kso_id
											inner join $dbbilling.b_ms_kelas mk ON mk.id=tk.kelas_id
											WHERE p.kunjungan_id='$kunj_id'
											AND kso.id=$kso_id
											AND mk.tipe=0) AS tbl ORDER BY level DESC LIMIT 1";
									//echo $sKelasTertinggi.";<br>";
									$qKelasTertinggi=mysql_query($sKelasTertinggi);
									$rwKelasTertinggi=mysql_fetch_array($qKelasTertinggi);
									$kelas_id=$rwKelasTertinggi['id'];
									/* ======================= END KELAS TERTINGGI KECUALI PAVILIUN ======================== */
									
									/* ======================= CEK PERNAH KE PAVILIUN ??? ======================== */
									$sVIP="SELECT * FROM (
											SELECT  
											p.id
											FROM $dbbilling.b_pelayanan p
											INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id=mu.id 
											INNER JOIN $dbbilling.b_tindakan t ON p.id=t.pelayanan_id
											INNER JOIN $dbbilling.b_ms_kso kso ON kso.id=t.kso_id
											INNER JOIN $dbbilling.b_ms_kelas mk ON mk.id=t.kelas_id
											WHERE p.kunjungan_id='$kunj_id' 
											AND kso.id=$kso_id
											AND mk.tipe=2
											UNION
											SELECT  
											p.id
											FROM $dbbilling.b_pelayanan p
											INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id=mu.id
											INNER JOIN $dbbilling.b_tindakan_kamar tk ON p.id=tk.pelayanan_id
											INNER JOIN $dbbilling.b_ms_kso kso ON kso.id=tk.kso_id
											INNER JOIN $dbbilling.b_ms_kelas mk ON mk.id=tk.kelas_id
											WHERE p.kunjungan_id='$kunj_id'
											AND mk.tipe=2
											AND kso.id=$kso_id) AS tblhakkelas LIMIT 1";
									//echo $sVIP.";<br>";
									$qVIP=mysql_query($sVIP);
									
									$isVIP=0;
									if(mysql_num_rows($qVIP)>0){
										$isVIP=1;
									}
									/* ======================= END CEK PERNAH KE PAVILIUN ??? ======================== */
									
									/* ======================= JIKA PAVILIUN ========================= */
									if ($isVIP==1){
										$sPavU="SELECT 
												  SUM(nilai) AS total 
												FROM
												  (SELECT
													1,  
													SUM(tbl_tindakan.biaya) AS nilai 
												  FROM
													(SELECT 
													($dbbilling.b_tindakan.qty * $dbbilling.b_tindakan.biaya) AS biaya 
													FROM
													  $dbbilling.b_pelayanan  
													  INNER JOIN $dbbilling.b_tindakan 
														ON $dbbilling.b_tindakan.pelayanan_id = $dbbilling.b_pelayanan.id
													  INNER JOIN $dbbilling.b_ms_unit 
														ON $dbbilling.b_ms_unit.id = $dbbilling.b_pelayanan.unit_id
													  INNER JOIN $dbbilling.b_ms_unit b_ms_unit_asal 
														ON b_ms_unit_asal.id = $dbbilling.b_pelayanan.unit_id_asal
													  INNER JOIN $dbbilling.b_ms_kelas mk 
														ON mk.id = $dbbilling.b_pelayanan.kelas_id
													WHERE 
													$dbbilling.b_pelayanan.kunjungan_id = '$kunj_id'
													AND $dbbilling.b_tindakan.kso_id = $kso_id
													AND mk.tipe = 2
													) AS tbl_tindakan 
												  UNION
												  SELECT
													2,  
													SUM(kmr.biaya) AS nilai 
												  FROM
													(SELECT
													  IF($dbbilling.b_tindakan_kamar.status_out = 0, 
													  IF(DATEDIFF(IFNULL($dbbilling.b_tindakan_kamar.tgl_out, NOW()), $dbbilling.b_tindakan_kamar.tgl_in) = 0, 1, DATEDIFF(IFNULL($dbbilling.b_tindakan_kamar.tgl_out, NOW()), $dbbilling.b_tindakan_kamar.tgl_in)) * ($dbbilling.b_tindakan_kamar.beban_kso + $dbbilling.b_tindakan_kamar.beban_pasien), 
													  IF(DATEDIFF(IFNULL($dbbilling.b_tindakan_kamar.tgl_out, NOW()), $dbbilling.b_tindakan_kamar.tgl_in) = 0, 0, DATEDIFF(IFNULL($dbbilling.b_tindakan_kamar.tgl_out, NOW()), $dbbilling.b_tindakan_kamar.tgl_in)) * ($dbbilling.b_tindakan_kamar.beban_kso + $dbbilling.b_tindakan_kamar.beban_pasien)) biaya 
													FROM
													  $dbbilling.b_tindakan_kamar 
													  INNER JOIN $dbbilling.b_pelayanan 
														ON $dbbilling.b_tindakan_kamar.pelayanan_id = $dbbilling.b_pelayanan.id
													  INNER JOIN $dbbilling.b_ms_unit 
														ON $dbbilling.b_ms_unit.id = $dbbilling.b_pelayanan.unit_id
													  INNER JOIN $dbbilling.b_ms_unit b_ms_unit_asal 
														ON b_ms_unit_asal.id = $dbbilling.b_pelayanan.unit_id_asal
													  INNER JOIN $dbbilling.b_ms_kelas mk 
														ON mk.id = $dbbilling.b_pelayanan.kelas_id 
													WHERE 
													$dbbilling.b_pelayanan.kunjungan_id = '$kunj_id'
													AND $dbbilling.b_tindakan_kamar.kso_id = $kso_id 
													AND $dbbilling.b_tindakan_kamar.aktif = 1
													AND mk.tipe = 2 
													) AS kmr) AS gab";
										//echo $sPavU.";<br>";
										$qPavU=mysql_query($sPavU);
										$rwPavU=mysql_fetch_array($qPavU);
										$biaya_pav=$rwPavU['total'];
										
										$sPavObatU="SELECT
													  SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS SUBTOTAL 
													FROM
													  $dbapotek.a_penjualan ap 
													  INNER JOIN $dbbilling.b_pelayanan 
														ON ap.NO_KUNJUNGAN = $dbbilling.b_pelayanan.id
													  INNER JOIN $dbbilling.b_ms_unit 
														ON $dbbilling.b_ms_unit.id = $dbbilling.b_pelayanan.unit_id
													  INNER JOIN $dbbilling.b_ms_unit b_ms_unit_asal 
														ON b_ms_unit_asal.id = $dbbilling.b_pelayanan.unit_id_asal
													  INNER JOIN $dbapotek.a_mitra am 
														ON am.IDMITRA=ap.KSO_ID
													  INNER JOIN $dbbilling.b_ms_kso kso 
														ON kso.id=$dbbilling.b_pelayanan.kso_id
													  INNER JOIN $dbbilling.b_kunjungan
														ON $dbbilling.b_kunjungan.id = $dbbilling.b_pelayanan.kunjungan_id
													  INNER JOIN $dbbilling.b_ms_kelas k 
														ON k.id=$dbbilling.b_pelayanan.kelas_id
													WHERE 
													$dbbilling.b_pelayanan.kunjungan_id = '$kunj_id'
													AND kso.id = $kso_id
													AND k.tipe=2
													AND ap.CARA_BAYAR=2
													AND ap.KRONIS<>2";
										//echo $sPavObatU.";<br>";
										$qPavObatU=mysql_query($sPavObatU);
										$rwPavObatU=mysql_fetch_array($qPavObatU);
										$biaya_pav_obat=$rwPavObatU['SUBTOTAL'];
										$biaya_pav_px=$biaya_pav+$biaya_pav_obat;
									}
									/* ======================= END JIKA PAVILIUN ========================= */
									
									$kelas_id_jaminan=$kso_kelas_id;
									$jenis_layanan=$rw["jenis_layanan"];
									$biaya_px=0;
									$biaya_rs=0;
									$biaya_kso=0;
									
									$sqlTin="select IFNULL(sum((t.biaya)*t.qty),0) as total,IFNULL(SUM(t.bayar),0) AS bayar,IFNULL(sum(((t.biaya_pasien)*t.qty)-t.bayar),0) as kurang from $dbbilling.b_tindakan t
							inner join $dbbilling.b_pelayanan p on t.pelayanan_id=p.id
							where p.kunjungan_id='$kunj_id' AND t.lunas=0 AND t.id NOT IN 
							(SELECT tindakan_id FROM $dbbilling.b_bayar_tindakan bt INNER JOIN $dbbilling.b_bayar b ON bt.bayar_id=b.id 
							INNER JOIN $dbbilling.b_tindakan t ON bt.tindakan_id=t.id 
							WHERE b.kunjungan_id='".$kunj_id."' AND bt.tipe=0 AND t.lunas=1 AND b.flag = '$flag')";
									//echo $sqlTin.";<br/>";
									$rsTin=mysql_query($sqlTin);
									$rwTin=mysql_fetch_array($rsTin);
							
									$sqlKamar="SELECT IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip),
							(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip))),0) AS kamar,
							IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso),
							(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso))),0) AS kamar_kso,
							IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip)-bayar,
							(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip)-bayar)),0) AS kurang_kamar,SUM(IFNULL(bayar,0)) bayar 
							FROM $dbbilling.b_tindakan_kamar b INNER JOIN $dbbilling.b_pelayanan p ON b.pelayanan_id=p.id 
							WHERE p.kunjungan_id='".$kunj_id."' AND b.aktif=1";
									//echo $sqlKamar.";<br/>";
									$rsKamar=mysql_query($sqlKamar);
									$rwKamar=mysql_fetch_array($rsKamar);
									
									$sqlObat="SELECT IFNULL(SUM(t2.QTY_JUAL),0) QTY_JUAL,IFNULL(SUM(t2.QTY_RETUR),0) QTY_RETUR,
							IFNULL(SUM((t2.QTY_JUAL-t2.QTY_RETUR) * t2.HARGA_SATUAN),0) AS SUBTOTAL 
							FROM (SELECT ap.* FROM $dbapotek.a_penjualan ap INNER JOIN $dbbilling.b_pelayanan p ON ap.NO_KUNJUNGAN=p.id 
							WHERE p.kunjungan_id='".$kunj_id."' AND ap.CARA_BAYAR=2) AS t2";
									//echo $sqlObat.";<br/>";
									$rsObat=mysql_query($sqlObat);
									$rwObat=mysql_fetch_array($rsObat);
									$bObat=$rwObat['SUBTOTAL'];
									
									$nilai=$rwTin['total']+$rwKamar['kamar']+$rwObat['SUBTOTAL'];
									$biaya_rs=$nilai;
									
									if (($jenis_layanan==$jenis_lay_Pav) || ($kelas_id==5) || ($kelas_id==6) || ($kelas_id==7) || ($kelas_id==8) || ($kelas_id==9) || ($isVIP==1)){	//=======Px BPJS ke Pavilyun========			
										$sql="SELECT * FROM $dbbilling.b_inacbg_grouper WHERE kunjungan_id='$kunj_id'";
										//echo $sql.";<br>";
										$rs1=mysql_query($sql);
										if (mysql_errno()>0){
											$dt="Proses Update Gagal !";
										}else{
											if (mysql_num_rows($rs1)>0){
												$rw1=mysql_fetch_array($rs1);
												/* ===================== BIAYA PAVILIUN =================== */
												$totBiayaPaviliun_BPJS=0;
												$sPav="SELECT 
														  SUM(nilai) AS total 
														FROM
														  (SELECT
															1,  
															SUM(tbl_tindakan.biaya) AS nilai 
														  FROM
															(SELECT 
															($dbbilling.b_tindakan.qty * $dbbilling.b_tindakan.biaya) AS biaya 
															FROM
															  $dbbilling.b_pelayanan  
															  INNER JOIN $dbbilling.b_tindakan 
																ON $dbbilling.b_tindakan.pelayanan_id = $dbbilling.b_pelayanan.id
															  INNER JOIN $dbbilling.b_ms_unit 
																ON $dbbilling.b_ms_unit.id = $dbbilling.b_pelayanan.unit_id
															  INNER JOIN $dbbilling.b_ms_unit b_ms_unit_asal 
																ON b_ms_unit_asal.id = $dbbilling.b_pelayanan.unit_id_asal
															  LEFT JOIN $dbbilling.b_ms_kelas mk 
																ON mk.id = $dbbilling.b_tindakan.kelas_id
															  INNER JOIN $dbbilling.b_ms_kelas hk 
																ON hk.id = $dbbilling.b_tindakan.kso_kelas_id
															WHERE 
															$dbbilling.b_pelayanan.kunjungan_id = '$kunj_id'
															AND $dbbilling.b_tindakan.kso_id = $kso_id
															) AS tbl_tindakan 
														  UNION
														  SELECT
															2,  
															SUM(kmr.biaya) AS nilai 
														  FROM
															(SELECT
															  IF($dbbilling.b_tindakan_kamar.status_out = 0, 
															  IF(DATEDIFF(IFNULL($dbbilling.b_tindakan_kamar.tgl_out, NOW()), $dbbilling.b_tindakan_kamar.tgl_in) = 0, 1, DATEDIFF(IFNULL($dbbilling.b_tindakan_kamar.tgl_out, NOW()), $dbbilling.b_tindakan_kamar.tgl_in)) * ($dbbilling.b_tindakan_kamar.beban_kso + $dbbilling.b_tindakan_kamar.beban_pasien), 
															  IF(DATEDIFF(IFNULL($dbbilling.b_tindakan_kamar.tgl_out, NOW()), $dbbilling.b_tindakan_kamar.tgl_in) = 0, 0, DATEDIFF(IFNULL($dbbilling.b_tindakan_kamar.tgl_out, NOW()), $dbbilling.b_tindakan_kamar.tgl_in)) * ($dbbilling.b_tindakan_kamar.beban_kso + $dbbilling.b_tindakan_kamar.beban_pasien)) biaya 
															FROM
															  $dbbilling.b_tindakan_kamar 
															  INNER JOIN $dbbilling.b_pelayanan 
																ON $dbbilling.b_tindakan_kamar.pelayanan_id = $dbbilling.b_pelayanan.id
															  INNER JOIN $dbbilling.b_ms_unit 
																ON $dbbilling.b_ms_unit.id = $dbbilling.b_pelayanan.unit_id
															  INNER JOIN $dbbilling.b_ms_unit b_ms_unit_asal 
																ON b_ms_unit_asal.id = $dbbilling.b_pelayanan.unit_id_asal
															  INNER JOIN $dbbilling.b_ms_kelas mk 
																ON mk.id = $dbbilling.b_tindakan_kamar.kelas_id
															  INNER JOIN $dbbilling.b_ms_kelas hk 
																ON hk.id = $dbbilling.b_tindakan_kamar.kso_kelas_id  
															WHERE 
															$dbbilling.b_pelayanan.kunjungan_id = '$kunj_id'
															AND $dbbilling.b_tindakan_kamar.kso_id = $kso_id 
															AND $dbbilling.b_tindakan_kamar.aktif = 1 
															) AS kmr) AS gab";
												$qPav=mysql_query($sPav);
												$rwPav=mysql_fetch_array($qPav);
												$totBiayaPaviliun_BPJS += $rwPav['total'];
												
												
												$sPavObat="SELECT
														  SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS SUBTOTAL 
														FROM
														  $dbapotek.a_penjualan ap 
														  INNER JOIN $dbbilling.b_pelayanan 
															ON ap.NO_KUNJUNGAN = $dbbilling.b_pelayanan.id
														  INNER JOIN $dbbilling.b_ms_unit 
															ON $dbbilling.b_ms_unit.id = $dbbilling.b_pelayanan.unit_id
														  INNER JOIN $dbbilling.b_ms_unit b_ms_unit_asal 
															ON b_ms_unit_asal.id = $dbbilling.b_pelayanan.unit_id_asal
														  INNER JOIN $dbapotek.a_mitra am 
															ON am.IDMITRA=ap.KSO_ID
														  INNER JOIN $dbbilling.b_ms_kso kso 
															ON kso.id=$dbbilling.b_pelayanan.kso_id
														  INNER JOIN $dbbilling.b_kunjungan
															ON $dbbilling.b_kunjungan.id = $dbbilling.b_pelayanan.kunjungan_id
														  LEFT JOIN $dbbilling.b_ms_kelas k ON k.id=$dbbilling.b_pelayanan.kelas_id
														  INNER JOIN $dbbilling.b_ms_kelas hk ON hk.id=$dbbilling.b_kunjungan.kso_kelas_id 
														WHERE 
														$dbbilling.b_pelayanan.kunjungan_id = '$kunj_id'
														AND kso.id = $kso_id
														AND ap.CARA_BAYAR=2
														AND ap.KRONIS<>2";
												//echo $sPavObat."<br>";
												$qPavObat=mysql_query($sPavObat);
												$rwPavObat=mysql_fetch_array($qPavObat);
												$totBiayaPaviliun_BPJS += $rwPavObat['SUBTOTAL'];
												$nilai=$totBiayaPaviliun_BPJS;
												/* ===================== END BIAYA PAVILIUN =================== */
												
												$biaya_kso=$rw1["biaya_kso"];
												if ($nilai>$biaya_kso){
													$biaya_px=$nilai-$biaya_kso;
												//}else{
												//	$biaya_kso=$nilai;
												}
												
												$sql="SELECT * FROM $dbbilling.b_inacbg_grouper WHERE kunjungan_id='$kunj_id'";
												//echo $sql.";<br>";
												$rs1=mysql_query($sql);
												if (mysql_num_rows($rs1)>0){
													$sql="UPDATE $dbbilling.b_inacbg_grouper SET kelas_id='$kelas_id',kso_kelas_id='$kso_kelas_id',kelas_id_jaminan='$kelas_id_jaminan',biaya_rs='$biaya_rs',biaya_kso='$biaya_kso',biaya_px='$biaya_px',biaya_pav_px='$biaya_pav_px' WHERE kunjungan_id='$kunj_id'";
												}else{
													$sql="INSERT INTO $dbbilling.b_inacbg_grouper(kunjungan_id,kunjungan_id_group,kelas_id,kso_kelas_id,kelas_id_jaminan,biaya_rs,biaya_kso,biaya_px,biaya_pav_px) VALUES('$kunj_id','$kunj_id','$kelas_id','$kso_kelas_id','$kelas_id_jaminan','$biaya_rs','$biaya_kso','$biaya_px','$biaya_pav_px')";
												}
												//echo $sql.";<br>";
												$rs1=mysql_query($sql);
												if (mysql_errno()>0){
													$dt="Proses Update Gagal !";
												}else{
													distribusiBiaya($kso_id,$kunj_id,0,$biaya_kso,0,$dbbilling,$dbapotek);
													distribusiBiayaPx($kso_id,$kunj_id,0,$biaya_px,0,$dbbilling,$dbapotek);
												}
											}else{
												//echo "Numrows=0<br>";
												$dt="Proses Update Gagal !";
											}
										}
									}else{
										$sql="SELECT * FROM $dbbilling.b_inacbg_grouper WHERE kunjungan_id='$kunj_id'";
										//echo $sql.";<br>";
										$rs1=mysql_query($sql);
										if (mysql_num_rows($rs1)>0){
											$rw1=mysql_fetch_array($rs1);
											$biaya_kso=$rw1["biaya_kso"];
											$kode_grouper=$rw1["kode_grouper_inacbg"];
										
											$sql="SELECT * FROM $dbbilling.b_ms_inacbg_grouper WHERE kelas_id='$kelas_id' AND kode_inacbg='$kode_grouper' AND aktif=1";
											//echo $sql.";<br>";
											$rs=mysql_query($sql);
											if (mysql_errno()>0){
												$dt="Proses Update Gagal !";
											}else{
												if (mysql_num_rows($rs)>0){
													$rw=mysql_fetch_array($rs);
													$nilai=$rw["nilai"];
													if ($kelas_id!=$kso_kelas_id){
														if ($nilai>$biaya_kso){
															$biaya_px=$nilai-$biaya_kso;
														}else{
															$biaya_kso=$nilai;
															$kelas_id_jaminan=$kelas_id;
														}
														$sql="SELECT * FROM $dbbilling.b_inacbg_grouper WHERE kunjungan_id='$kunj_id'";
														//echo $sql.";<br>";
														$rs1=mysql_query($sql);
														if (mysql_num_rows($rs1)>0){
															$sql="UPDATE $dbbilling.b_inacbg_grouper SET kelas_id='$kelas_id',kso_kelas_id='$kso_kelas_id',kelas_id_jaminan='$kelas_id_jaminan',kode_grouper_inacbg='$kode_grouper',biaya_rs='$biaya_rs',biaya_kso='$biaya_kso',biaya_px='$biaya_px' WHERE kunjungan_id='$kunj_id'";
														}else{
															$sql="INSERT INTO $dbbilling.b_inacbg_grouper(kunjungan_id,kunjungan_id_group,kelas_id,kso_kelas_id,kelas_id_jaminan,kode_grouper_inacbg,biaya_rs,biaya_kso,biaya_px) VALUES('$kunj_id','$kunj_id','$kelas_id','$kso_kelas_id','$kelas_id_jaminan','$kode_grouper','$biaya_rs','$biaya_kso','$biaya_px')";
														}
														//echo $sql.";<br>";
														$rs1=mysql_query($sql);
														if (mysql_errno()>0){
															$dt="Proses Update Gagal !";
														}else{
															distribusiBiaya($kso_id,$kunj_id,0,$biaya_kso,0);
															distribusiBiayaPx($kso_id,$kunj_id,0,$biaya_px,0);
														}
													}else{
														$biaya_kso=$nilai;
														$sql="SELECT * FROM $dbbilling.b_inacbg_grouper WHERE kunjungan_id='$kunj_id'";
														//echo $sql.";<br>";
														$rs1=mysql_query($sql);
														if (mysql_num_rows($rs1)>0){
															$sql="UPDATE $dbbilling.b_inacbg_grouper SET kelas_id='$kelas_id',kso_kelas_id='$kso_kelas_id',kelas_id_jaminan='$kelas_id_jaminan',kode_grouper_inacbg='$kode_grouper',biaya_rs='$biaya_rs',biaya_kso='$biaya_kso',biaya_px='$biaya_px' WHERE kunjungan_id='$kunj_id'";
														}else{
															$sql="INSERT INTO $dbbilling.b_inacbg_grouper(kunjungan_id,kunjungan_id_group,kelas_id,kso_kelas_id,kelas_id_jaminan,kode_grouper_inacbg,biaya_rs,biaya_kso,biaya_px) VALUES('$kunj_id','$kunj_id','$kelas_id','$kso_kelas_id','$kelas_id_jaminan','$kode_grouper','$biaya_rs','$biaya_kso','$biaya_px')";
														}
														//echo $sql.";<br>";
														$rs1=mysql_query($sql);
														if (mysql_errno()>0){
															$dt="Proses Update Gagal !";
														}else{
															distribusiBiaya($kso_id,$kunj_id,0,$biaya_kso,0,$dbbilling,$dbapotek);
															distribusiBiayaPx($kso_id,$kunj_id,0,$biaya_px,0,$dbbilling,$dbapotek);
														}
													}
												}else{
													$dt="Proses Update Gagal !";
												}
											}
										}
									}
								}
							}
							//====Distribusi Jaminan KSO End====
							//=====Koreksi Distribusi Biaya_Px End====
							$sql="SELECT * FROM $dbbilling.b_bayar WHERE kunjungan_id='$kunj_id' ORDER BY id";
							//echo $sql.";<br>";
							$rsPost=mysql_query($sql);
							while ($rwPost=mysql_fetch_array($rsPost)){
								$cidBayar=$rwPost["id"];
								$tgl_act=$rwPost["tgl_act"];
								$jenis_kunjungan=$rwPost["jenis_kunjungan"];
								$kso_id=$rwPost["kso_id"];
								$kasir_id=$rwPost["kasir_id"];
								$no_kwitansi=$rwPost["no_kwitansi"];
								$tagihan=$rwPost["tagihan"];
								$nilai=$rwPost["nilai"];
								$stat_byr=$rwPost["stat_byr"];
								$tipe=$rwPost["tipe"];
								$jBayar=$rwPost["jenis_bayar"];
								//echo "stat_byr=$stat_byr".";<br>";
								if ($stat_byr==2){									
									$sql="SELECT
											  ap.ID,
											  ap.QTY,
											  ap.QTY_JUAL,
											  ap.QTY_RETUR,
											  ap.HARGA_SATUAN
											FROM $dbapotek.a_kredit_utang ku
											  INNER JOIN $dbapotek.a_penjualan ap
												ON ((ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN) AND (ku.NORM=ap.NO_PASIEN))
											WHERE ku.BILLING_BAYAR_OBAT_ID = '$cidBayar'";
									//echo $sql.";<br>";
									$rsObat=mysql_query($sql);
									$ok="false";
									while (($rwObat=mysql_fetch_array($rsObat)) && ($ok=="false")){
										$idTind=$rwObat["ID"];
										$tagihan_px=$rwObat["QTY_JUAL"] * $rwObat["HARGA_SATUAN"];
										//echo "nilai=$nilai, tagihan_px=$tagihan_px".";<br>";
										if ($nilai>=$tagihan_px){
											$nilai=$nilai-$tagihan_px;
											if ($nilai==0){
												$ok="true";
											}
											//===Distribusi Pembayaran===
											$sql="INSERT INTO $dbbilling.b_bayar_tindakan
															(bayar_id,
															 tindakan_id,
															 kso_id,
															 nilai,
															 tipe)
												VALUES ($cidBayar,
														$idTind,
														$kso_id,
														$tagihan_px,
														2)";
											//echo $sql.";<br>";
											$rsUpdt=mysql_query($sql);
										}else{
											$ok="true";
											$tagihan_px=$nilai;
											$nilai=0;
											//===Distribusi Pembayaran===
											$sql="INSERT INTO $dbbilling.b_bayar_tindakan
															(bayar_id,
															 tindakan_id,
															 kso_id,
															 nilai,
															 tipe)
												VALUES ($cidBayar,
														$idTind,
														$kso_id,
														$tagihan_px,
														2)";
											//echo $sql.";<br>";
											$rsUpdt=mysql_query($sql);
										}
									}
								}
								
								$sql="SELECT t.* FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
									WHERE p.kunjungan_id='$kunj_id' AND p.jenis_kunjungan='$jenis_kunjungan' AND t.kso_id='$kso_id' AND ((t.biaya_pasien * t.qty) > t.bayar_pasien)";
								//echo $sql.";<br>";
								$rsProc=mysql_query($sql);
								$ok="false";
								if (mysql_num_rows($rsProc)>0){
									while (($rwProc=mysql_fetch_array($rsProc)) && ($ok=="false")){
										$idTind=$rwProc["id"];
										$tagihan_px=$rwProc["biaya_pasien"] * $rwProc["qty"] - $rwProc["bayar_pasien"];
										//echo "idTind=$idTind, nilai=$nilai, tagihan_px=$tagihan_px".";<br>";
										if ($nilai>=$tagihan_px){
											$nilai=$nilai-$tagihan_px;
											if ($nilai==0){
												$ok="true";
											}
											
											$sql="UPDATE $dbbilling.b_tindakan 
												SET bayar=bayar+$tagihan_px,bayar_pasien=bayar_pasien+$tagihan_px,lunas=1 
												WHERE id='$idTind'";
											//echo $sql.";<br>";
											$rsUpdt=mysql_query($sql);
											if (mysql_affected_rows()>0){
												//===Distribusi Pembayaran===
												$sql="INSERT INTO $dbbilling.b_bayar_tindakan
																(bayar_id,
																 tindakan_id,
																 kso_id,
																 nilai,
																 tipe)
													VALUES ($cidBayar,
															$idTind,
															$kso_id,
															$tagihan_px,
															0)";
												//echo $sql.";<br>";
												$rsUpdt=mysql_query($sql);
											}
										}else{
											$ok="true";
											$tagihan_px=$nilai;
											$nilai=0;
											
											$sql="UPDATE $dbbilling.b_tindakan 
												SET bayar=bayar+$tagihan_px,bayar_pasien=bayar_pasien+$tagihan_px,lunas=0 
												WHERE id='$idTind'";
											//echo $sql.";<br>";
											$rsUpdt=mysql_query($sql);
											if (mysql_affected_rows()>0){
												//===Distribusi Pembayaran===
												$sql="INSERT INTO $dbbilling.b_bayar_tindakan
																(bayar_id,
																 tindakan_id,
																 kso_id,
																 nilai,
																 tipe)
													VALUES ($cidBayar,
															$idTind,
															$kso_id,
															$tagihan_px,
															0)";
												//echo $sql.";<br>";
												$rsUpdt=mysql_query($sql);
											}
										}
									}
								}else{
									$sql="SELECT DISTINCT jenis_kunjungan FROM $dbbilling.b_pelayanan WHERE kunjungan_id='$kunj_id' AND jenis_kunjungan<>$jenis_kunjungan AND kso_id='$kso_id'";
									//echo $sql.";<br>";
									$rsProc=mysql_query($sql);
									if (mysql_num_rows($rsProc)>0){
										$rwProc=mysql_fetch_array($rsProc);
										$jenis_kunjungan=$rwProc["jenis_kunjungan"];
										
										$sql="SELECT t.* FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
											WHERE p.kunjungan_id='$kunj_id' AND p.jenis_kunjungan='$jenis_kunjungan' AND t.kso_id='$kso_id' AND t.biaya_pasien>t.bayar_pasien";
										//echo $sql.";<br>";
										$rsProc=mysql_query($sql);
										if (mysql_num_rows($rsProc)>0){
											//====Update b_bayar.jenis_kunjungan===
											$sql="UPDATE $dbbilling.b_bayar SET jenis_kunjungan='$jenis_kunjungan' WHERE id='$cidBayar'";
											//echo $sql.";<br>";
											$rsJKunj=mysql_query($sql);
											$ok="false";
											while (($rwProc=mysql_fetch_array($rsProc)) && ($ok=="false")){
												$idTind=$rwProc["id"];
												$tagihan_px=$rwProc["biaya_pasien"] * $rwProc["qty"] - $rwProc["bayar_pasien"];
												//echo "idTind=$idTind, nilai=$nilai, tagihan_px=$tagihan_px".";<br>";
												if ($nilai>=$tagihan_px){
													$nilai=$nilai-$tagihan_px;
													if ($nilai==0){
														$ok="true";
													}
						
													$tBayarPxNonPiutang="";
													if ($jBayar==0){
														$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$tagihan_px,";
													}
													
													$sql="UPDATE $dbbilling.b_tindakan 
														SET bayar=bayar+$tagihan_px,bayar_pasien=bayar_pasien+$tagihan_px,".$tBayarPxNonPiutang."lunas=1 
														WHERE id='$idTind'";
													//echo $sql.";<br>";
													$rsUpdt=mysql_query($sql);
													if (mysql_affected_rows()>0){
														//===Distribusi Pembayaran===
														$sql="INSERT INTO $dbbilling.b_bayar_tindakan
																		(bayar_id,
																		 tindakan_id,
																		 kso_id,
																		 nilai,
																		 tipe)
															VALUES ($cidBayar,
																	$idTind,
																	$kso_id,
																	$tagihan_px,
																	0)";
														//echo $sql.";<br>";
														$rsUpdt=mysql_query($sql);
													}
												}else{
													$ok="true";
													$tagihan_px=$nilai;
													$nilai=0;
						
													$tBayarPxNonPiutang="";
													if ($jBayar==0){
														$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$tagihan_px,";
													}
													
													$sql="UPDATE $dbbilling.b_tindakan 
														SET bayar=bayar+$tagihan_px,bayar_pasien=bayar_pasien+$tagihan_px,".$tBayarPxNonPiutang."lunas=0 
														WHERE id='$idTind'";
													//echo $sql.";<br>";
													$rsUpdt=mysql_query($sql);
													if (mysql_affected_rows()>0){
														//===Distribusi Pembayaran===
														$sql="INSERT INTO $dbbilling.b_bayar_tindakan
																		(bayar_id,
																		 tindakan_id,
																		 kso_id,
																		 nilai,
																		 tipe)
															VALUES ($cidBayar,
																	$idTind,
																	$kso_id,
																	$tagihan_px,
																	0)";
														//echo $sql.";<br>";
														$rsUpdt=mysql_query($sql);
													}
												}
											}
										}
									}
								}
								
								if (($nilai>0) && ($jenis_kunjungan==3)){
									$sql="SELECT t.*,IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)=0,1, DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in))), (IF(DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)=0,0, DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)))) * t.beban_pasien AS biaya_pasien 
										FROM $dbbilling.b_tindakan_kamar t 
										INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
										WHERE p.kunjungan_id='$kunj_id' AND t.lunas=0";
									//echo $sql.";<br>";
									$rsProc=mysql_query($sql);
									$ok="false";
									while (($rwProc=mysql_fetch_array($rsProc)) && ($ok=="false")){
										$idTind=$rwProc["id"];
										$tagihan_px=$rwProc["biaya_pasien"] - $rwProc["bayar_pasien"];
										//echo "idTind=$idTind, nilai=$nilai, tagihan_px=$tagihan_px".";<br>";
										if ($nilai>=$tagihan_px){
											$nilai=$nilai-$tagihan_px;
											if ($nilai==0){
												$ok="true";
											}
											
											$tBayarPxNonPiutang="";
											if ($jBayar==0){
												$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$tagihan_px,";
											}
											
											$sql="UPDATE $dbbilling.b_tindakan_kamar 
												SET bayar=bayar+$tagihan_px,bayar_pasien=bayar_pasien+$tagihan_px,".$tBayarPxNonPiutang."lunas=1 
												WHERE id='$idTind'";
											//echo $sql.";<br>";
											$rsUpdt=mysql_query($sql);
											if (mysql_affected_rows()>0){
												//===Distribusi Pembayaran===
												$sql="INSERT INTO $dbbilling.b_bayar_tindakan
																(bayar_id,
																 tindakan_id,
																 kso_id,
																 nilai,
																 tipe)
													VALUES ($cidBayar,
															$idTind,
															$kso_id,
															$tagihan_px,
															1)";
												//echo $sql.";<br>";
												$rsUpdt=mysql_query($sql);
											}
										}else{
											$ok="true";
											$tagihan_px=$nilai;
											$nilai=0;
											
											$tBayarPxNonPiutang="";
											if ($jBayar==0){
												$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$tagihan_px,";
											}
											
											$sql="UPDATE $dbbilling.b_tindakan_kamar 
												SET bayar=bayar+$tagihan_px,bayar_pasien=bayar_pasien+$tagihan_px,".$tBayarPxNonPiutang."lunas=0 
												WHERE id='$idTind'";
											//echo $sql.";<br>";
											$rsUpdt=mysql_query($sql);
											if (mysql_affected_rows()>0){
												//===Distribusi Pembayaran===
												$sql="INSERT INTO $dbbilling.b_bayar_tindakan
																(bayar_id,
																 tindakan_id,
																 kso_id,
																 nilai,
																 tipe)
													VALUES ($cidBayar,
															$idTind,
															$kso_id,
															$tagihan_px,
															1)";
												//echo $sql.";<br>";
												$rsUpdt=mysql_query($sql);
											}
										}
									}
								}
								
								if ($nilai>0){	//Masih bersisa
									$sql="SELECT t.* FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
										WHERE p.kunjungan_id='$kunj_id' AND p.jenis_kunjungan<>'$jenis_kunjungan' AND t.kso_id='$kso_id' AND t.biaya_pasien>t.bayar_pasien";
									//echo $sql.";<br>";
									$rsProc=mysql_query($sql);
									if (mysql_num_rows($rsProc)>0){
										$ok="false";
										while (($rwProc=mysql_fetch_array($rsProc)) && ($ok=="false")){
											$idTind=$rwProc["id"];
											$tagihan_px=$rwProc["biaya_pasien"] * $rwProc["qty"] - $rwProc["bayar_pasien"];
											//echo "idTind=$idTind, nilai=$nilai, tagihan_px=$tagihan_px".";<br>";
											if ($nilai>=$tagihan_px){
												$nilai=$nilai-$tagihan_px;
												if ($nilai==0){
													$ok="true";
												}
					
												$tBayarPxNonPiutang="";
												if ($jBayar==0){
													$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$tagihan_px,";
												}
												
												$sql="UPDATE $dbbilling.b_tindakan 
													SET bayar=bayar+$tagihan_px,bayar_pasien=bayar_pasien+$tagihan_px,".$tBayarPxNonPiutang."lunas=1 
													WHERE id='$idTind'";
												//echo $sql.";<br>";
												$rsUpdt=mysql_query($sql);
												if (mysql_affected_rows()>0){
													//===Distribusi Pembayaran===
													$sql="INSERT INTO $dbbilling.b_bayar_tindakan
																	(bayar_id,
																	 tindakan_id,
																	 kso_id,
																	 nilai,
																	 tipe)
														VALUES ($cidBayar,
																$idTind,
																$kso_id,
																$tagihan_px,
																0)";
													//echo $sql.";<br>";
													$rsUpdt=mysql_query($sql);
												}
											}else{
												$ok="true";
												$tagihan_px=$nilai;
												$nilai=0;
					
												$tBayarPxNonPiutang="";
												if ($jBayar==0){
													$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$tagihan_px,";
												}
												
												$sql="UPDATE $dbbilling.b_tindakan 
													SET bayar=bayar+$tagihan_px,bayar_pasien=bayar_pasien+$tagihan_px,".$tBayarPxNonPiutang."lunas=0 
													WHERE id='$idTind'";
												//echo $sql.";<br>";
												$rsUpdt=mysql_query($sql);
												if (mysql_affected_rows()>0){
													//===Distribusi Pembayaran===
													$sql="INSERT INTO $dbbilling.b_bayar_tindakan
																	(bayar_id,
																	 tindakan_id,
																	 kso_id,
																	 nilai,
																	 tipe)
														VALUES ($cidBayar,
																$idTind,
																$kso_id,
																$tagihan_px,
																0)";
													//echo $sql.";<br>";
													$rsUpdt=mysql_query($sql);
												}
											}
										}
									}
								}
							}
						}else{
							//===Proses Distribusi Ulang===
							if (($nilaiBayar>$nBayarTind) && ($kso_id==1)){
								//========Cek b_bayar_tindakan yg tdk ada tindakannya=======
								$sql="SELECT
										  $dbbilling.b_bayar_tindakan.*
										FROM $dbbilling.b_bayar_tindakan
										  LEFT JOIN $dbbilling.b_tindakan
											ON $dbbilling.b_bayar_tindakan.tindakan_id = $dbbilling.b_tindakan.id
										WHERE $dbbilling.b_bayar_tindakan.bayar_id = '$idBayar'
											AND $dbbilling.b_bayar_tindakan.tipe = 0
											AND $dbbilling.b_bayar_tindakan.nilai > 0
											AND $dbbilling.b_tindakan.id IS NULL";
								//echo $sql.";<br>";
								$rsCekBlmLunas=mysql_query($sql);
								while ($rwCekBlmLunas=mysql_fetch_array($rsCekBlmLunas)){
									$cidBTind=$rwCekBlmLunas["id"];
									$sql="DELETE FROM $dbbilling.b_bayar_tindakan WHERE id='$cidBTind'";
									//echo $sql.";<br>";
									$rsDelBTind=mysql_query($sql);
								}
								//========Cek b_tindakan yg blm lunas=======
								$sql="SELECT
										  t.*
										FROM $dbbilling.b_tindakan t
										  INNER JOIN $dbbilling.b_pelayanan p
											ON t.pelayanan_id = p.id
										WHERE p.kunjungan_id = '$kunj_id'
											AND p.jenis_kunjungan = '$jenis_kunjungan'
											AND t.kso_id = '$kso_id'
											AND ((t.biaya_pasien * t.qty) > t.bayar_pasien)";
								//echo $sql.";<br>";
								$rsProc=mysql_query($sql);
								$ok="false";
								$nilai=$nilaiBayar-$nBayarTind;
								$cidBayar=$idBayar;
								if (mysql_num_rows($rsProc)>0){
									while (($rwProc=mysql_fetch_array($rsProc)) && ($ok=="false")){
										$idTind=$rwProc["id"];
										$tagihan_px=$rwProc["biaya_pasien"] * $rwProc["qty"] - $rwProc["bayar_pasien"];
										//echo "idTind=$idTind, nilai=$nilai, tagihan_px=$tagihan_px".";<br>";
										
										if ($nilai>=$tagihan_px){
											$nilai=$nilai-$tagihan_px;
											if ($nilai==0){
												$ok="true";
											}
					
											$tBayarPxNonPiutang="";
											if ($jBayar==0){
												$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$tagihan_px,";
											}
											
											$sql="UPDATE $dbbilling.b_tindakan 
												SET bayar=bayar+$tagihan_px,bayar_pasien=bayar_pasien+$tagihan_px,".$tBayarPxNonPiutang."lunas=1 
												WHERE id='$idTind'";
											//echo $sql.";<br>";
											$rsUpdt=mysql_query($sql);
											if (mysql_affected_rows()>0){
												//===Distribusi Pembayaran===
												$sql="INSERT INTO $dbbilling.b_bayar_tindakan
																(bayar_id,
																 tindakan_id,
																 kso_id,
																 nilai,
																 tipe)
													VALUES ($cidBayar,
															$idTind,
															$kso_id,
															$tagihan_px,
															0)";
												//echo $sql.";<br>";
												$rsUpdt=mysql_query($sql);
											}
										}else{
											$ok="true";
											$tagihan_px=$nilai;
											$nilai=0;
											
											$tBayarPxNonPiutang="";
											if ($jBayar==0){
												$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$tagihan_px,";
											}
											
											$sql="UPDATE $dbbilling.b_tindakan 
												SET bayar=bayar+$tagihan_px,bayar_pasien=bayar_pasien+$tagihan_px,".$tBayarPxNonPiutang."lunas=0 
												WHERE id='$idTind'";
											//echo $sql.";<br>";
											$rsUpdt=mysql_query($sql);
											if (mysql_affected_rows()>0){
												//===Distribusi Pembayaran===
												$sql="INSERT INTO $dbbilling.b_bayar_tindakan
																(bayar_id,
																 tindakan_id,
																 kso_id,
																 nilai,
																 tipe)
													VALUES ($cidBayar,
															$idTind,
															$kso_id,
															$tagihan_px,
															0)";
												//echo $sql.";<br>";
												$rsUpdt=mysql_query($sql);
											}
										}
									}
								}else{
									$sql="SELECT DISTINCT jenis_kunjungan FROM $dbbilling.b_pelayanan WHERE kunjungan_id='$kunj_id' AND jenis_kunjungan<>$jenis_kunjungan AND kso_id='$kso_id'";
									//echo $sql.";<br>";
									$rsProc=mysql_query($sql);
									if (mysql_num_rows($rsProc)>0){
										$rwProc=mysql_fetch_array($rsProc);
										$jenis_kunjungan=$rwProc["jenis_kunjungan"];
										
										$sql="SELECT t.* FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
											WHERE p.kunjungan_id='$kunj_id' AND p.jenis_kunjungan='$jenis_kunjungan' AND t.kso_id='$kso_id' AND ((t.biaya_pasien * t.qty) > t.bayar_pasien)";
										//echo $sql.";<br>";
										$rsProc=mysql_query($sql);
										if (mysql_num_rows($rsProc)>0){
											//====Update b_bayar.jenis_kunjungan===
											$sql="UPDATE $dbbilling.b_bayar SET jenis_kunjungan='$jenis_kunjungan' WHERE id='$cidBayar'";
											//echo $sql.";<br>";
											$rsJKunj=mysql_query($sql);
											$ok="false";
											while (($rwProc=mysql_fetch_array($rsProc)) && ($ok=="false")){
												$idTind=$rwProc["id"];
												$tagihan_px=$rwProc["biaya_pasien"] * $rwProc["qty"] - $rwProc["bayar_pasien"];
												//echo "idTind=$idTind, nilai=$nilai, tagihan_px=$tagihan_px".";<br>";
												if ($nilai>=$tagihan_px){
													$nilai=$nilai-$tagihan_px;
													if ($nilai==0){
														$ok="true";
													}
						
													$tBayarPxNonPiutang="";
													if ($jBayar==0){
														$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$tagihan_px,";
													}
													
													$sql="UPDATE $dbbilling.b_tindakan 
														SET bayar=bayar+$tagihan_px,bayar_pasien=bayar_pasien+$tagihan_px,".$tBayarPxNonPiutang."lunas=1 
														WHERE id='$idTind'";
													//echo $sql.";<br>";
													$rsUpdt=mysql_query($sql);
													if (mysql_affected_rows()>0){
														//===Distribusi Pembayaran===
														$sql="INSERT INTO $dbbilling.b_bayar_tindakan
																		(bayar_id,
																		 tindakan_id,
																		 kso_id,
																		 nilai,
																		 tipe)
															VALUES ($cidBayar,
																	$idTind,
																	$kso_id,
																	$tagihan_px,
																	0)";
														//echo $sql.";<br>";
														$rsUpdt=mysql_query($sql);
													}
												}else{
													$ok="true";
													$tagihan_px=$nilai;
													$nilai=0;
						
													$tBayarPxNonPiutang="";
													if ($jBayar==0){
														$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$tagihan_px,";
													}
													
													$sql="UPDATE $dbbilling.b_tindakan 
														SET bayar=bayar+$tagihan_px,bayar_pasien=bayar_pasien+$tagihan_px,".$tBayarPxNonPiutang."lunas=0 
														WHERE id='$idTind'";
													//echo $sql.";<br>";
													$rsUpdt=mysql_query($sql);
													if (mysql_affected_rows()>0){
														//===Distribusi Pembayaran===
														$sql="INSERT INTO $dbbilling.b_bayar_tindakan
																		(bayar_id,
																		 tindakan_id,
																		 kso_id,
																		 nilai,
																		 tipe)
															VALUES ($cidBayar,
																	$idTind,
																	$kso_id,
																	$tagihan_px,
																	0)";
														//echo $sql.";<br>";
														$rsUpdt=mysql_query($sql);
													}
												}
											}
										}
									}
								}
								
								if (($nilai>0) && ($jenis_kunjungan==3)){
									$sql="SELECT t.*,IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)=0,1, DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in))), (IF(DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)=0,0, DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)))) * t.beban_pasien AS biaya_pasien 
										FROM $dbbilling.b_tindakan_kamar t 
										INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
										WHERE p.kunjungan_id='$kunj_id' AND t.lunas=0";
									//echo $sql.";<br>";
									$rsProc=mysql_query($sql);
									$ok="false";
									while (($rwProc=mysql_fetch_array($rsProc)) && ($ok=="false")){
										$idTind=$rwProc["id"];
										$tagihan_px=$rwProc["biaya_pasien"] - $rwProc["bayar_pasien"];
										//echo "idTind=$idTind, nilai=$nilai, tagihan_px=$tagihan_px".";<br>";
										if ($nilai>=$tagihan_px){
											$nilai=$nilai-$tagihan_px;
											if ($nilai==0){
												$ok="true";
											}
											
											$tBayarPxNonPiutang="";
											if ($jBayar==0){
												$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$tagihan_px,";
											}
											
											$sql="UPDATE $dbbilling.b_tindakan_kamar 
												SET bayar=bayar+$tagihan_px,bayar_pasien=bayar_pasien+$tagihan_px,".$tBayarPxNonPiutang."lunas=1 
												WHERE id='$idTind'";
											//echo $sql.";<br>";
											$rsUpdt=mysql_query($sql);
											if (mysql_affected_rows()>0){
												//===Distribusi Pembayaran===
												$sql="INSERT INTO $dbbilling.b_bayar_tindakan
																(bayar_id,
																 tindakan_id,
																 kso_id,
																 nilai,
																 tipe)
													VALUES ($cidBayar,
															$idTind,
															$kso_id,
															$tagihan_px,
															1)";
												//echo $sql.";<br>";
												$rsUpdt=mysql_query($sql);
											}
										}else{
											$ok="true";
											$tagihan_px=$nilai;
											$nilai=0;
											
											$tBayarPxNonPiutang="";
											if ($jBayar==0){
												$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$tagihan_px,";
											}
											
											$sql="UPDATE $dbbilling.b_tindakan_kamar 
												SET bayar=bayar+$tagihan_px,bayar_pasien=bayar_pasien+$tagihan_px,".$tBayarPxNonPiutang."lunas=0 
												WHERE id='$idTind'";
											//echo $sql.";<br>";
											$rsUpdt=mysql_query($sql);
											if (mysql_affected_rows()>0){
												//===Distribusi Pembayaran===
												$sql="INSERT INTO $dbbilling.b_bayar_tindakan
																(bayar_id,
																 tindakan_id,
																 kso_id,
																 nilai,
																 tipe)
													VALUES ($cidBayar,
															$idTind,
															$kso_id,
															$tagihan_px,
															1)";
												//echo $sql.";<br>";
												$rsUpdt=mysql_query($sql);
											}
										}
									}
								}
								
								if ($nilai>0){	//Masih bersisa
									$sql="SELECT t.* FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
										WHERE p.kunjungan_id='$kunj_id' AND p.jenis_kunjungan<>'$jenis_kunjungan' AND t.kso_id='$kso_id' AND ((t.biaya_pasien * t.qty) > t.bayar_pasien)";
									//echo $sql.";<br>";
									$rsProc=mysql_query($sql);
									if (mysql_num_rows($rsProc)>0){
										$ok="false";
										while (($rwProc=mysql_fetch_array($rsProc)) && ($ok=="false")){
											$idTind=$rwProc["id"];
											$tagihan_px=$rwProc["biaya_pasien"] * $rwProc["qty"] - $rwProc["bayar_pasien"];
											//echo "idTind=$idTind, nilai=$nilai, tagihan_px=$tagihan_px".";<br>";
											if ($nilai>=$tagihan_px){
												$nilai=$nilai-$tagihan_px;
												if ($nilai==0){
													$ok="true";
												}
					
												$tBayarPxNonPiutang="";
												if ($jBayar==0){
													$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$tagihan_px,";
												}
												
												$sql="UPDATE $dbbilling.b_tindakan 
													SET bayar=bayar+$tagihan_px,bayar_pasien=bayar_pasien+$tagihan_px,".$tBayarPxNonPiutang."lunas=1 
													WHERE id='$idTind'";
												//echo $sql.";<br>";
												$rsUpdt=mysql_query($sql);
												if (mysql_affected_rows()>0){
													//===Distribusi Pembayaran===
													$sql="INSERT INTO $dbbilling.b_bayar_tindakan
																	(bayar_id,
																	 tindakan_id,
																	 kso_id,
																	 nilai,
																	 tipe)
														VALUES ($cidBayar,
																$idTind,
																$kso_id,
																$tagihan_px,
																0)";
													//echo $sql.";<br>";
													$rsUpdt=mysql_query($sql);
												}
											}else{
												$ok="true";
												$tagihan_px=$nilai;
												$nilai=0;
					
												$tBayarPxNonPiutang="";
												if ($jBayar==0){
													$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$tagihan_px,";
												}
												
												$sql="UPDATE $dbbilling.b_tindakan 
													SET bayar=bayar+$tagihan_px,bayar_pasien=bayar_pasien+$tagihan_px,".$tBayarPxNonPiutang."lunas=0 
													WHERE id='$idTind'";
												//echo $sql.";<br>";
												$rsUpdt=mysql_query($sql);
												if (mysql_affected_rows()>0){
													//===Distribusi Pembayaran===
													$sql="INSERT INTO $dbbilling.b_bayar_tindakan
																	(bayar_id,
																	 tindakan_id,
																	 kso_id,
																	 nilai,
																	 tipe)
														VALUES ($cidBayar,
																$idTind,
																$kso_id,
																$tagihan_px,
																0)";
													//echo $sql.";<br>";
													$rsUpdt=mysql_query($sql);
												}
											}
										}
									}
								}
							}else{
								
							}
/*							$sql="SELECT id FROM $dbbilling.b_bayar WHERE kunjungan_id='$kunj_id' AND posting=0";
							echo $sql.";<br>";
							$rsPost=mysql_query($sql);
							$isOk=1;
							while ($rwPost=mysql_fetch_array($rsPost)){
								$cidBayarDel=$rwPost["id"];
								$sql="UPDATE $dbbilling.b_bayar_tindakan
									  INNER JOIN $dbbilling.b_tindakan
										ON $dbbilling.b_bayar_tindakan.tindakan_id = $dbbilling.b_tindakan.id
									SET $dbbilling.b_tindakan.bayar = $dbbilling.b_tindakan.bayar - $dbbilling.b_bayar_tindakan.nilai,
									  $dbbilling.b_tindakan.bayar_pasien = $dbbilling.b_tindakan.bayar_pasien - $dbbilling.b_bayar_tindakan.nilai,
									  $dbbilling.b_tindakan.bayar_pasien_non_piutang = $dbbilling.b_tindakan.bayar_pasien_non_piutang - $dbbilling.b_bayar_tindakan.nilai,
									  $dbbilling.b_tindakan.lunas = 0
									WHERE $dbbilling.b_bayar_tindakan.bayar_id = '$cidBayarDel'
										AND $dbbilling.b_bayar_tindakan.tipe = 0
										AND $dbbilling.b_bayar_tindakan.nilai > 0";
								echo $sql.";<br>";
								$rsPostDel=mysql_query($sql);
								
								$sql="UPDATE $dbbilling.b_bayar_tindakan
									  INNER JOIN $dbbilling.b_tindakan_kamar
										ON $dbbilling.b_bayar_tindakan.tindakan_id = $dbbilling.b_tindakan_kamar.id
									SET $dbbilling.b_tindakan_kamar.bayar = $dbbilling.b_tindakan_kamar.bayar - $dbbilling.b_bayar_tindakan.nilai,
									  $dbbilling.b_tindakan_kamar.bayar_pasien = $dbbilling.b_tindakan_kamar.bayar_pasien - $dbbilling.b_bayar_tindakan.nilai,
									  $dbbilling.b_tindakan_kamar.bayar_pasien_non_piutang = $dbbilling.b_tindakan_kamar.bayar_pasien_non_piutang - $dbbilling.b_bayar_tindakan.nilai,
									  $dbbilling.b_tindakan_kamar.lunas = 0
									WHERE $dbbilling.b_bayar_tindakan.bayar_id = '$cidBayarDel'
										AND $dbbilling.b_bayar_tindakan.tipe = 1
										AND $dbbilling.b_bayar_tindakan.nilai > 0";
								echo $sql.";<br>";
								$rsPostDel=mysql_query($sql);
								
								$sql="DELETE FROM $dbbilling.b_bayar_tindakan WHERE bayar_id = '$cidBayarDel' AND nilai > 0";
								echo $sql.";<br>";
								$rsPostDel=mysql_query($sql);
							}
							
							$sql="UPDATE $dbbilling.b_tindakan SET bayar=0,bayar_kso=0,bayar_pasien=0,bayar_pasien_non_piutang=0,lunas=0 WHERE kunjungan_id='$kunj_id'";
							echo $sql.";<br>";
							$rsPost=mysql_query($sql);
							
							$sql="UPDATE $dbbilling.b_tindakan_kamar,$dbbilling.b_pelayanan 
									SET $dbbilling.b_tindakan_kamar.bayar=0,
										$dbbilling.b_tindakan_kamar.bayar_kso=0,
										$dbbilling.b_tindakan_kamar.bayar_pasien=0,
										$dbbilling.b_tindakan_kamar.bayar_pasien_non_piutang=0,
										$dbbilling.b_tindakan_kamar.lunas=0 
								WHERE $dbbilling.b_tindakan_kamar.pelayanan_id=$dbbilling.b_pelayanan.id 
									AND $dbbilling.b_pelayanan.kunjungan_id='$kunj_id'";
							echo $sql.";<br>";
							$rsPost=mysql_query($sql);
							//=====Koreksi Distribusi Biaya_Px====
							$blmDistribusiBiaya=1;
							$sql="SELECT
									  t.*
									FROM $dbbilling.b_tindakan t
									  INNER JOIN $dbbilling.b_pelayanan p
										ON t.pelayanan_id = p.id
									WHERE p.kunjungan_id = '$kunj_id'
										AND p.jenis_kunjungan = '$jenis_kunjungan'
										AND t.kso_id = '$kso_id'
										AND t.biaya_pasien > t.bayar_pasien";
							echo $sql.";<br>";
							$rsCekBlmDistribusi=mysql_query($sql);
							if (mysql_num_rows($rsCekBlmDistribusi)>0){
								$blmDistribusiBiaya=0;
							}
							
							$cIsKsoPlafon = 0;
							$arrIdKsoPlafon=explode(",",$idKsoPlafon);
							for ($i=0;$i<count($arrIdKsoPlafon);$i++){
								if ($arrIdKsoPlafon[$i]==$kso_id){
									$cIsKsoPlafon = 1;
								}
							}
							
							if ($cIsKsoPlafon==1){
								$biaya_px=0;
								$biaya_rs=0;
								
								$sCek="select * from $dbbilling.b_jaminan_kso where kunjungan_id='$kunj_id'";
								//echo $sCek.";<br>";
								$qCek=mysql_query($sCek);
								if(mysql_num_rows($qCek)>0){
									$rwCek=mysql_fetch_array($qCek);
									$biaya_kso=$rwCek['biaya_kso'];
								}
								
								$sql="SELECT * FROM $dbbilling.b_kunjungan WHERE id='$kunj_id'";
								//echo $sql.";<br>";
								$rs=mysql_query($sql);
								$rw=mysql_fetch_array($rs);
								$kso_id=$rw["kso_id"];
								
								$sqlTin="select IFNULL(sum((t.biaya)*t.qty),0) as total,IFNULL(SUM(t.bayar),0) AS bayar,IFNULL(sum(((t.biaya_pasien)*t.qty)-t.bayar),0) as kurang from $dbbilling.b_tindakan t
						inner join $dbbilling.b_pelayanan p on t.pelayanan_id=p.id
						where p.kunjungan_id='$kunj_id' AND t.lunas=0 AND t.id NOT IN 
						(SELECT tindakan_id FROM $dbbilling.b_bayar_tindakan bt INNER JOIN $dbbilling.b_bayar b ON bt.bayar_id=b.id 
						INNER JOIN $dbbilling.b_tindakan t ON bt.tindakan_id=t.id 
						WHERE b.kunjungan_id='$kunj_id' AND bt.tipe=0 AND t.lunas=1)";
								//echo $sqlTin.";<br/>";
								$rsTin=mysql_query($sqlTin);
								$rwTin=mysql_fetch_array($rsTin);
								$bTin=$rwTin['total'];
								
								$sqlKamar="SELECT IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip),
						(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip))),0) AS kamar,
						IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso),
						(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso))),0) AS kamar_kso,
						IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip)-bayar,
						(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip)-bayar)),0) AS kurang_kamar,SUM(IFNULL(bayar,0)) bayar 
						FROM $dbbilling.b_tindakan_kamar b INNER JOIN $dbbilling.b_pelayanan p ON b.pelayanan_id=p.id 
						WHERE p.kunjungan_id='$kunj_id' AND b.aktif=1";
								//echo $sqlKamar.";<br/>";
								$rsKamar=mysql_query($sqlKamar);
								$rwKamar=mysql_fetch_array($rsKamar);
								$bKamar=$rwKamar['kamar'];
								
								$sqlObat="SELECT IFNULL(SUM(t2.QTY_JUAL),0) QTY_JUAL,IFNULL(SUM(t2.QTY_RETUR),0) QTY_RETUR,
										IFNULL(SUM((t2.QTY_JUAL-t2.QTY_RETUR) * t2.HARGA_SATUAN),0) AS SUBTOTAL 
										FROM (SELECT ap.* FROM $dbapotek.a_penjualan ap INNER JOIN $dbbilling.b_pelayanan p ON ap.NO_KUNJUNGAN=p.id 
										WHERE p.kunjungan_id='$kunj_id' AND ap.CARA_BAYAR=2 AND ap.DIJAMIN=1 and ap.KRONIS<>2) AS t2";
								//echo $sqlObat.";<br/>";
								$rsObat=mysql_query($sqlObat);
								$rwObat=mysql_fetch_array($rsObat);
								$bObat=$rwObat['SUBTOTAL'];
								
								$nilai=$rwTin['total']+$rwKamar['kamar']+$rwObat['SUBTOTAL'];
								$biaya_rs=$nilai;
								
								if ($nilai>$biaya_kso){
									$biaya_px=$nilai-$biaya_kso;
								}
								
								$sCek="select * from $dbbilling.b_jaminan_kso where kunjungan_id='".$kunj_id."'";
								//echo $sCek.";<br>";
								$qCek=mysql_query($sCek);
								if(mysql_num_rows($qCek)==0){
									$sIns="insert into $dbbilling.b_jaminan_kso(kunjungan_id,biaya_rs,biaya_kso,biaya_px) values ('$kunj_id','$biaya_rs','$biaya_kso','$biaya_px')";
									mysql_query($sIns);
								}
								else{
									$sUp="update $dbbilling.b_jaminan_kso set biaya_rs='$biaya_rs', biaya_kso='$biaya_kso', biaya_px='$biaya_px' where kunjungan_id='$kunj_id'";
									mysql_query($sUp);
								}
								
								//====Distribusi Jaminan KSO====
								$nilai = $biaya_kso - $bObat;
								if ($nilai<0) $nilai=0; 
								//$nilai = $biaya_kso;
								//echo "nilai=$nilai"."<br>";
								$sqlKamar="SELECT
											  b.id,
											  tarip,
											  beban_kso,
											  beban_pasien,
											  IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in))),
											  (IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))) AS jml,
											  b.bayar_pasien,
											  b.lunas
											FROM $dbbilling.b_tindakan_kamar b
											  INNER JOIN $dbbilling.b_pelayanan p
												ON b.pelayanan_id = p.id
											WHERE p.kunjungan_id = '$kunj_id'
												AND b.kso_id = '$kso_id'
												AND b.aktif = 1";
								//echo $sqlKamar.";<br/>";
								$rsKamar=mysql_query($sqlKamar);
								$ok = 'true';
								while ($rwKamar = mysql_fetch_array($rsKamar)){
									$tindId = $rwKamar['id'];
									$taripRS = $rwKamar['tarip'];
									$beban_pasien = $rwKamar['beban_pasien'];
									$bayar_pasien = $rwKamar['bayar_pasien'];
									$qtyHari = $rwKamar['jml'];
									if (($biaya_px == 0) && ($bayar_pasien == 0)){
										$biaya = $taripRS;
										$beban_pasien = 0;
									}elseif ($ok == 'true'){
										if (($biaya_kso>=$bKamar)){
											$biaya = $taripRS;
											$beban_pasien = 0;
										}else{
											$biaya = $taripRS - $beban_pasien;
										}
									}else{
										$biaya = 0;
										$beban_pasien = $taripRS;
									}
									
									if($nilai >= ($biaya * $qtyHari)){
										$nilai = $nilai - ($biaya * $qtyHari);
										if ($nilai == 0){
											$ok = 'false';
										}
										
										$sqlUp = "UPDATE $dbbilling.b_tindakan_kamar SET beban_kso = $biaya, beban_pasien = $beban_pasien WHERE id = $tindId";
										//echo $sqlUp.";<br>";
										$rsUp = mysql_query($sqlUp);
									}else{
										$biaya = floor($nilai/$qtyHari);
										$beban_pasien = $taripRS - $biaya;
										$nilai = $nilai - ($biaya * $qtyHari);
										$ok = 'false';
										
										$sqlUp = "UPDATE $dbbilling.b_tindakan_kamar SET beban_kso = $biaya, beban_pasien = $beban_pasien WHERE id = $tindId";
										//echo $sqlUp.";<br>";
										$rsUp = mysql_query($sqlUp);
									}
								}
								//echo "nilai=$nilai"."<br>";
								$sqlTin="select t.* from $dbbilling.b_tindakan t
										inner join $dbbilling.b_pelayanan p on t.pelayanan_id=p.id
										where p.kunjungan_id='$kunj_id' AND t.kso_id='$kso_id' AND t.lunas=0 AND t.id NOT IN 
										(SELECT tindakan_id FROM $dbbilling.b_bayar_tindakan bt INNER JOIN $dbbilling.b_bayar b ON bt.bayar_id=b.id 
										INNER JOIN $dbbilling.b_tindakan t ON bt.tindakan_id=t.id 
										WHERE b.kunjungan_id='".$kunj_id."' AND b.kso_id='$kso_id' AND bt.tipe=0 AND t.lunas=1)";
								//echo $sqlTin.";<br/>";
								$rsTin=mysql_query($sqlTin);
								$ok = 'true';
								while ($rwTind = mysql_fetch_array($rsTin)){
									$tindId = $rwTind['id'];
									$biaya = $rwTind['biaya'];
									$qty = $rwTind['qty'];
									$biayaNilai = $biaya * $qty;
									$biaya_Pasien = $rwTind['biaya_pasien'];
									$bayar_pasien = $rwTind['bayar_pasien'];
									
									if ($biaya_px == 0){
										$biaya_Pasien = 0;
									}elseif (($nilai >= $biayaNilai) && ($bayar_pasien == 0)){
										$biaya_Pasien = 0;
									}elseif ($ok == 'false'){
										if ($nilai > 0){
											$biaya_Pasien = $biaya - $nilai;
											$biaya = $nilai;
											$nilai = 0;
										}else{
											$biaya_Pasien = $biaya;
											$biaya = 0;
										}
									}
									
									if($nilai >= $biayaNilai){
										$nilai = $nilai - $biayaNilai;
										if ($nilai == 0){
											$ok = 'false';
										}
										//echo "nilai=$nilai, tarip=".$rwTind['biaya'].", qty=$qty"."<br>";
										$sqlUp = "UPDATE $dbbilling.b_tindakan SET biaya_kso = $biaya, biaya_pasien = $biaya_Pasien WHERE id = $tindId";
										//echo $sqlUp.";<br>";
										$rsUp = mysql_query($sqlUp);
									}else{
										if ($ok == 'true'){
											$taripRS = $biaya;
											$biaya = floor($nilai/$qty);
											$biaya_Pasien = $taripRS - $biaya;
											$nilai = $nilai - ($biaya * $qty);
										}
										
										$ok = 'false';
										//echo "nilai=$nilai, tarip=".$rwTind['biaya'].", qty=$qty"."<br>";
										$sqlUp = "UPDATE $dbbilling.b_tindakan SET biaya_kso = $biaya, biaya_pasien = $biaya_Pasien WHERE id = $tindId";
										//echo $sqlUp.";<br>";
										$rsUp = mysql_query($sqlUp);
									}
								}
							}
							elseif ($blmDistribusiBiaya==1){
								if ($kso_id==72){	// BPJS
									// ======================= HAK KELAS ======================== 
									$sHakKelas="SELECT k.kso_kelas_id FROM $dbbilling.b_kunjungan k WHERE k.id='$kunj_id'";
									//echo $sHakKelas.";<br>";
									$qHakKelas=mysql_query($sHakKelas);
									$rwHakKelas=mysql_fetch_array($qHakKelas);
									$kso_kelas_id=$rwHakKelas['kso_kelas_id'];
									// ======================= END HAK KELAS ======================== 
		
									// ======================= KELAS TERTINGGI KECUALI PAVILIUN ======================== 
									$sKelasTertinggi="SELECT id,level,nama FROM (
											SELECT  
											mk.id,
											mk.nama,
											mk.level
											FROM $dbbilling.b_pelayanan p
											INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id=mu.id 
											INNER JOIN $dbbilling.b_tindakan t ON p.id=t.pelayanan_id
											INNER JOIN $dbbilling.b_ms_tindakan_kelas mtk ON mtk.id=t.ms_tindakan_kelas_id
											INNER JOIN $dbbilling.b_ms_kso kso ON kso.id=t.kso_id
											inner join $dbbilling.b_ms_kelas mk ON mk.id=t.kelas_id
											WHERE p.kunjungan_id='$kunj_id' 
											AND kso.id=$kso_id
											AND mk.tipe=0
											UNION
											SELECT  
											mk.id,
											mk.nama,
											mk.level
											FROM $dbbilling.b_pelayanan p
											INNER JOIN $dbbilling.b_tindakan_kamar tk ON p.id=tk.pelayanan_id
											INNER JOIN $dbbilling.b_ms_kso kso ON kso.id=tk.kso_id
											inner join $dbbilling.b_ms_kelas mk ON mk.id=tk.kelas_id
											WHERE p.kunjungan_id='$kunj_id'
											AND kso.id=$kso_id
											AND mk.tipe=0) AS tbl ORDER BY level DESC LIMIT 1";
									//echo $sKelasTertinggi.";<br>";
									$qKelasTertinggi=mysql_query($sKelasTertinggi);
									$rwKelasTertinggi=mysql_fetch_array($qKelasTertinggi);
									$kelas_id=$rwKelasTertinggi['id'];
									// ======================= END KELAS TERTINGGI KECUALI PAVILIUN ======================== 
									
									// ======================= CEK PERNAH KE PAVILIUN ??? ======================== 
									$sVIP="SELECT * FROM (
											SELECT  
											p.id
											FROM $dbbilling.b_pelayanan p
											INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id=mu.id 
											INNER JOIN $dbbilling.b_tindakan t ON p.id=t.pelayanan_id
											INNER JOIN $dbbilling.b_ms_kso kso ON kso.id=t.kso_id
											INNER JOIN $dbbilling.b_ms_kelas mk ON mk.id=t.kelas_id
											WHERE p.kunjungan_id='$kunj_id' 
											AND kso.id=$kso_id
											AND mk.tipe=2
											UNION
											SELECT  
											p.id
											FROM $dbbilling.b_pelayanan p
											INNER JOIN $dbbilling.b_ms_unit mu ON p.unit_id=mu.id
											INNER JOIN $dbbilling.b_tindakan_kamar tk ON p.id=tk.pelayanan_id
											INNER JOIN $dbbilling.b_ms_kso kso ON kso.id=tk.kso_id
											INNER JOIN $dbbilling.b_ms_kelas mk ON mk.id=tk.kelas_id
											WHERE p.kunjungan_id='$kunj_id'
											AND mk.tipe=2
											AND kso.id=$kso_id) AS tblhakkelas LIMIT 1";
									//echo $sVIP.";<br>";
									$qVIP=mysql_query($sVIP);
									
									$isVIP=0;
									if(mysql_num_rows($qVIP)>0){
										$isVIP=1;
									}
									// ======================= END CEK PERNAH KE PAVILIUN ??? ======================== 
									
									// ======================= JIKA PAVILIUN ========================= 
									if ($isVIP==1){
										$sPavU="SELECT 
												  SUM(nilai) AS total 
												FROM
												  (SELECT
													1,  
													SUM(tbl_tindakan.biaya) AS nilai 
												  FROM
													(SELECT 
													($dbbilling.b_tindakan.qty * $dbbilling.b_tindakan.biaya) AS biaya 
													FROM
													  $dbbilling.b_pelayanan  
													  INNER JOIN $dbbilling.b_tindakan 
														ON $dbbilling.b_tindakan.pelayanan_id = $dbbilling.b_pelayanan.id
													  INNER JOIN $dbbilling.b_ms_unit 
														ON $dbbilling.b_ms_unit.id = $dbbilling.b_pelayanan.unit_id
													  INNER JOIN $dbbilling.b_ms_unit b_ms_unit_asal 
														ON b_ms_unit_asal.id = $dbbilling.b_pelayanan.unit_id_asal
													  INNER JOIN $dbbilling.b_ms_kelas mk 
														ON mk.id = $dbbilling.b_pelayanan.kelas_id
													WHERE 
													$dbbilling.b_pelayanan.kunjungan_id = '$kunj_id'
													AND $dbbilling.b_tindakan.kso_id = $kso_id
													AND mk.tipe = 2
													) AS tbl_tindakan 
												  UNION
												  SELECT
													2,  
													SUM(kmr.biaya) AS nilai 
												  FROM
													(SELECT
													  IF($dbbilling.b_tindakan_kamar.status_out = 0, 
													  IF(DATEDIFF(IFNULL($dbbilling.b_tindakan_kamar.tgl_out, NOW()), $dbbilling.b_tindakan_kamar.tgl_in) = 0, 1, DATEDIFF(IFNULL($dbbilling.b_tindakan_kamar.tgl_out, NOW()), $dbbilling.b_tindakan_kamar.tgl_in)) * ($dbbilling.b_tindakan_kamar.beban_kso + $dbbilling.b_tindakan_kamar.beban_pasien), 
													  IF(DATEDIFF(IFNULL($dbbilling.b_tindakan_kamar.tgl_out, NOW()), $dbbilling.b_tindakan_kamar.tgl_in) = 0, 0, DATEDIFF(IFNULL($dbbilling.b_tindakan_kamar.tgl_out, NOW()), $dbbilling.b_tindakan_kamar.tgl_in)) * ($dbbilling.b_tindakan_kamar.beban_kso + $dbbilling.b_tindakan_kamar.beban_pasien)) biaya 
													FROM
													  $dbbilling.b_tindakan_kamar 
													  INNER JOIN $dbbilling.b_pelayanan 
														ON $dbbilling.b_tindakan_kamar.pelayanan_id = $dbbilling.b_pelayanan.id
													  INNER JOIN $dbbilling.b_ms_unit 
														ON $dbbilling.b_ms_unit.id = $dbbilling.b_pelayanan.unit_id
													  INNER JOIN $dbbilling.b_ms_unit b_ms_unit_asal 
														ON b_ms_unit_asal.id = $dbbilling.b_pelayanan.unit_id_asal
													  INNER JOIN $dbbilling.b_ms_kelas mk 
														ON mk.id = $dbbilling.b_pelayanan.kelas_id 
													WHERE 
													$dbbilling.b_pelayanan.kunjungan_id = '$kunj_id'
													AND $dbbilling.b_tindakan_kamar.kso_id = $kso_id 
													AND $dbbilling.b_tindakan_kamar.aktif = 1
													AND mk.tipe = 2 
													) AS kmr) AS gab";
										//echo $sPavU.";<br>";
										$qPavU=mysql_query($sPavU);
										$rwPavU=mysql_fetch_array($qPavU);
										$biaya_pav=$rwPavU['total'];
										
										$sPavObatU="SELECT
													  SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS SUBTOTAL 
													FROM
													  $dbapotek.a_penjualan ap 
													  INNER JOIN $dbbilling.b_pelayanan 
														ON ap.NO_KUNJUNGAN = $dbbilling.b_pelayanan.id
													  INNER JOIN $dbbilling.b_ms_unit 
														ON $dbbilling.b_ms_unit.id = $dbbilling.b_pelayanan.unit_id
													  INNER JOIN $dbbilling.b_ms_unit b_ms_unit_asal 
														ON b_ms_unit_asal.id = $dbbilling.b_pelayanan.unit_id_asal
													  INNER JOIN $dbapotek.a_mitra am 
														ON am.IDMITRA=ap.KSO_ID
													  INNER JOIN $dbbilling.b_ms_kso kso 
														ON kso.id=$dbbilling.b_pelayanan.kso_id
													  INNER JOIN $dbbilling.b_kunjungan
														ON $dbbilling.b_kunjungan.id = $dbbilling.b_pelayanan.kunjungan_id
													  INNER JOIN $dbbilling.b_ms_kelas k 
														ON k.id=$dbbilling.b_pelayanan.kelas_id
													WHERE 
													$dbbilling.b_pelayanan.kunjungan_id = '$kunj_id'
													AND kso.id = $kso_id
													AND k.tipe=2
													AND ap.CARA_BAYAR=2
													AND ap.KRONIS<>2";
										//echo $sPavObatU.";<br>";
										$qPavObatU=mysql_query($sPavObatU);
										$rwPavObatU=mysql_fetch_array($qPavObatU);
										$biaya_pav_obat=$rwPavObatU['SUBTOTAL'];
										$biaya_pav_px=$biaya_pav+$biaya_pav_obat;
									}
									// ======================= END JIKA PAVILIUN ========================= 
									
									$kelas_id_jaminan=$kso_kelas_id;
									$jenis_layanan=$rw["jenis_layanan"];
									$biaya_px=0;
									$biaya_rs=0;
									$biaya_kso=0;
									
									$sqlTin="select IFNULL(sum((t.biaya)*t.qty),0) as total,IFNULL(SUM(t.bayar),0) AS bayar,IFNULL(sum(((t.biaya_pasien)*t.qty)-t.bayar),0) as kurang from $dbbilling.b_tindakan t
							inner join $dbbilling.b_pelayanan p on t.pelayanan_id=p.id
							where p.kunjungan_id='$kunj_id' AND t.lunas=0 AND t.id NOT IN 
							(SELECT tindakan_id FROM $dbbilling.b_bayar_tindakan bt INNER JOIN $dbbilling.b_bayar b ON bt.bayar_id=b.id 
							INNER JOIN $dbbilling.b_tindakan t ON bt.tindakan_id=t.id 
							WHERE b.kunjungan_id='".$kunj_id."' AND bt.tipe=0 AND t.lunas=1)";
									//echo $sqlTin.";<br/>";
									$rsTin=mysql_query($sqlTin);
									$rwTin=mysql_fetch_array($rsTin);
							
									$sqlKamar="SELECT IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip),
							(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip))),0) AS kamar,
							IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso),
							(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(beban_kso))),0) AS kamar_kso,
							IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip)-bayar,
							(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)))*(tarip)-bayar)),0) AS kurang_kamar,SUM(IFNULL(bayar,0)) bayar 
							FROM $dbbilling.b_tindakan_kamar b INNER JOIN $dbbilling.b_pelayanan p ON b.pelayanan_id=p.id 
							WHERE p.kunjungan_id='".$kunj_id."' AND b.aktif=1";
									//echo $sqlKamar.";<br/>";
									$rsKamar=mysql_query($sqlKamar);
									$rwKamar=mysql_fetch_array($rsKamar);
									
									$sqlObat="SELECT IFNULL(SUM(t2.QTY_JUAL),0) QTY_JUAL,IFNULL(SUM(t2.QTY_RETUR),0) QTY_RETUR,
							IFNULL(SUM((t2.QTY_JUAL-t2.QTY_RETUR) * t2.HARGA_SATUAN),0) AS SUBTOTAL 
							FROM (SELECT ap.* FROM $dbapotek.a_penjualan ap INNER JOIN $dbbilling.b_pelayanan p ON ap.NO_KUNJUNGAN=p.id 
							WHERE p.kunjungan_id='".$kunj_id."' AND ap.CARA_BAYAR=2) AS t2";
									//echo $sqlObat.";<br/>";
									$rsObat=mysql_query($sqlObat);
									$rwObat=mysql_fetch_array($rsObat);
									$bObat=$rwObat['SUBTOTAL'];
									
									$nilai=$rwTin['total']+$rwKamar['kamar']+$rwObat['SUBTOTAL'];
									$biaya_rs=$nilai;
									
									if (($jenis_layanan==$jenis_lay_Pav) || ($kelas_id==5) || ($kelas_id==6) || ($kelas_id==7) || ($kelas_id==8) || ($kelas_id==9) || ($isVIP==1)){	//=======Px BPJS ke Pavilyun========			
										$sql="SELECT * FROM $dbbilling.b_inacbg_grouper WHERE kunjungan_id='$kunj_id'";
										//echo $sql.";<br>";
										$rs1=mysql_query($sql);
										if (mysql_errno()>0){
											$dt="Proses Update Gagal !";
										}else{
											if (mysql_num_rows($rs1)>0){
												$rw1=mysql_fetch_array($rs1);
												// ===================== BIAYA PAVILIUN =================== 
												$totBiayaPaviliun_BPJS=0;
												$sPav="SELECT 
														  SUM(nilai) AS total 
														FROM
														  (SELECT
															1,  
															SUM(tbl_tindakan.biaya) AS nilai 
														  FROM
															(SELECT 
															($dbbilling.b_tindakan.qty * $dbbilling.b_tindakan.biaya) AS biaya 
															FROM
															  $dbbilling.b_pelayanan  
															  INNER JOIN $dbbilling.b_tindakan 
																ON $dbbilling.b_tindakan.pelayanan_id = $dbbilling.b_pelayanan.id
															  INNER JOIN $dbbilling.b_ms_unit 
																ON $dbbilling.b_ms_unit.id = $dbbilling.b_pelayanan.unit_id
															  INNER JOIN $dbbilling.b_ms_unit b_ms_unit_asal 
																ON b_ms_unit_asal.id = $dbbilling.b_pelayanan.unit_id_asal
															  LEFT JOIN $dbbilling.b_ms_kelas mk 
																ON mk.id = $dbbilling.b_tindakan.kelas_id
															  INNER JOIN $dbbilling.b_ms_kelas hk 
																ON hk.id = $dbbilling.b_tindakan.kso_kelas_id
															WHERE 
															$dbbilling.b_pelayanan.kunjungan_id = '$kunj_id'
															AND $dbbilling.b_tindakan.kso_id = $kso_id
															) AS tbl_tindakan 
														  UNION
														  SELECT
															2,  
															SUM(kmr.biaya) AS nilai 
														  FROM
															(SELECT
															  IF($dbbilling.b_tindakan_kamar.status_out = 0, 
															  IF(DATEDIFF(IFNULL($dbbilling.b_tindakan_kamar.tgl_out, NOW()), $dbbilling.b_tindakan_kamar.tgl_in) = 0, 1, DATEDIFF(IFNULL($dbbilling.b_tindakan_kamar.tgl_out, NOW()), $dbbilling.b_tindakan_kamar.tgl_in)) * ($dbbilling.b_tindakan_kamar.beban_kso + $dbbilling.b_tindakan_kamar.beban_pasien), 
															  IF(DATEDIFF(IFNULL($dbbilling.b_tindakan_kamar.tgl_out, NOW()), $dbbilling.b_tindakan_kamar.tgl_in) = 0, 0, DATEDIFF(IFNULL($dbbilling.b_tindakan_kamar.tgl_out, NOW()), $dbbilling.b_tindakan_kamar.tgl_in)) * ($dbbilling.b_tindakan_kamar.beban_kso + $dbbilling.b_tindakan_kamar.beban_pasien)) biaya 
															FROM
															  $dbbilling.b_tindakan_kamar 
															  INNER JOIN $dbbilling.b_pelayanan 
																ON $dbbilling.b_tindakan_kamar.pelayanan_id = $dbbilling.b_pelayanan.id
															  INNER JOIN $dbbilling.b_ms_unit 
																ON $dbbilling.b_ms_unit.id = $dbbilling.b_pelayanan.unit_id
															  INNER JOIN $dbbilling.b_ms_unit b_ms_unit_asal 
																ON b_ms_unit_asal.id = $dbbilling.b_pelayanan.unit_id_asal
															  INNER JOIN $dbbilling.b_ms_kelas mk 
																ON mk.id = $dbbilling.b_tindakan_kamar.kelas_id
															  INNER JOIN $dbbilling.b_ms_kelas hk 
																ON hk.id = $dbbilling.b_tindakan_kamar.kso_kelas_id  
															WHERE 
															$dbbilling.b_pelayanan.kunjungan_id = '$kunj_id'
															AND $dbbilling.b_tindakan_kamar.kso_id = $kso_id 
															AND $dbbilling.b_tindakan_kamar.aktif = 1 
															) AS kmr) AS gab";
												$qPav=mysql_query($sPav);
												$rwPav=mysql_fetch_array($qPav);
												$totBiayaPaviliun_BPJS += $rwPav['total'];
												
												
												$sPavObat="SELECT
														  SUM((ap.QTY_JUAL-ap.QTY_RETUR) * ap.HARGA_SATUAN) AS SUBTOTAL 
														FROM
														  $dbapotek.a_penjualan ap 
														  INNER JOIN $dbbilling.b_pelayanan 
															ON ap.NO_KUNJUNGAN = $dbbilling.b_pelayanan.id
														  INNER JOIN $dbbilling.b_ms_unit 
															ON $dbbilling.b_ms_unit.id = $dbbilling.b_pelayanan.unit_id
														  INNER JOIN $dbbilling.b_ms_unit b_ms_unit_asal 
															ON b_ms_unit_asal.id = $dbbilling.b_pelayanan.unit_id_asal
														  INNER JOIN $dbapotek.a_mitra am 
															ON am.IDMITRA=ap.KSO_ID
														  INNER JOIN $dbbilling.b_ms_kso kso 
															ON kso.id=$dbbilling.b_pelayanan.kso_id
														  INNER JOIN $dbbilling.b_kunjungan
															ON $dbbilling.b_kunjungan.id = $dbbilling.b_pelayanan.kunjungan_id
														  LEFT JOIN $dbbilling.b_ms_kelas k ON k.id=$dbbilling.b_pelayanan.kelas_id
														  INNER JOIN $dbbilling.b_ms_kelas hk ON hk.id=$dbbilling.b_kunjungan.kso_kelas_id 
														WHERE 
														$dbbilling.b_pelayanan.kunjungan_id = '$kunj_id'
														AND kso.id = $kso_id
														AND ap.CARA_BAYAR=2
														AND ap.KRONIS<>2";
												//echo $sPavObat."<br>";
												$qPavObat=mysql_query($sPavObat);
												$rwPavObat=mysql_fetch_array($qPavObat);
												$totBiayaPaviliun_BPJS += $rwPavObat['SUBTOTAL'];
												$nilai=$totBiayaPaviliun_BPJS;
												// ===================== END BIAYA PAVILIUN =================== 
												
												$biaya_kso=$rw1["biaya_kso"];
												if ($nilai>$biaya_kso){
													$biaya_px=$nilai-$biaya_kso;
												//}else{
												//	$biaya_kso=$nilai;
												}
												
												$sql="SELECT * FROM $dbbilling.b_inacbg_grouper WHERE kunjungan_id='$kunj_id'";
												//echo $sql.";<br>";
												$rs1=mysql_query($sql);
												if (mysql_num_rows($rs1)>0){
													$sql="UPDATE $dbbilling.b_inacbg_grouper SET kelas_id='$kelas_id',kso_kelas_id='$kso_kelas_id',kelas_id_jaminan='$kelas_id_jaminan',biaya_rs='$biaya_rs',biaya_kso='$biaya_kso',biaya_px='$biaya_px',biaya_pav_px='$biaya_pav_px' WHERE kunjungan_id='$kunj_id'";
												}else{
													$sql="INSERT INTO $dbbilling.b_inacbg_grouper(kunjungan_id,kunjungan_id_group,kelas_id,kso_kelas_id,kelas_id_jaminan,biaya_rs,biaya_kso,biaya_px,biaya_pav_px) VALUES('$kunj_id','$kunj_id','$kelas_id','$kso_kelas_id','$kelas_id_jaminan','$biaya_rs','$biaya_kso','$biaya_px','$biaya_pav_px')";
												}
												//echo $sql.";<br>";
												$rs1=mysql_query($sql);
												if (mysql_errno()>0){
													$dt="Proses Update Gagal !";
												}else{
													distribusiBiaya($kso_id,$kunj_id,0,$biaya_kso,0,$dbbilling,$dbapotek);
													distribusiBiayaPx($kso_id,$kunj_id,0,$biaya_px,0,$dbbilling,$dbapotek);
												}
											}else{
												//echo "Numrows=0<br>";
												$dt="Proses Update Gagal !";
											}
										}
									}else{
										$sql="SELECT * FROM $dbbilling.b_inacbg_grouper WHERE kunjungan_id='$kunj_id'";
										//echo $sql.";<br>";
										$rs1=mysql_query($sql);
										if (mysql_num_rows($rs1)>0){
											$rw1=mysql_fetch_array($rs1);
											$biaya_kso=$rw1["biaya_kso"];
											$kode_grouper=$rw1["kode_grouper_inacbg"];
										
											$sql="SELECT * FROM $dbbilling.b_ms_inacbg_grouper WHERE kelas_id='$kelas_id' AND kode_inacbg='$kode_grouper' AND aktif=1";
											//echo $sql.";<br>";
											$rs=mysql_query($sql);
											if (mysql_errno()>0){
												$dt="Proses Update Gagal !";
											}else{
												if (mysql_num_rows($rs)>0){
													$rw=mysql_fetch_array($rs);
													$nilai=$rw["nilai"];
													if ($kelas_id!=$kso_kelas_id){
														if ($nilai>$biaya_kso){
															$biaya_px=$nilai-$biaya_kso;
														}else{
															$biaya_kso=$nilai;
															$kelas_id_jaminan=$kelas_id;
														}
														$sql="SELECT * FROM $dbbilling.b_inacbg_grouper WHERE kunjungan_id='$kunj_id'";
														//echo $sql.";<br>";
														$rs1=mysql_query($sql);
														if (mysql_num_rows($rs1)>0){
															$sql="UPDATE $dbbilling.b_inacbg_grouper SET kelas_id='$kelas_id',kso_kelas_id='$kso_kelas_id',kelas_id_jaminan='$kelas_id_jaminan',kode_grouper_inacbg='$kode_grouper',biaya_rs='$biaya_rs',biaya_kso='$biaya_kso',biaya_px='$biaya_px' WHERE kunjungan_id='$kunj_id'";
														}else{
															$sql="INSERT INTO $dbbilling.b_inacbg_grouper(kunjungan_id,kunjungan_id_group,kelas_id,kso_kelas_id,kelas_id_jaminan,kode_grouper_inacbg,biaya_rs,biaya_kso,biaya_px) VALUES('$kunj_id','$kunj_id','$kelas_id','$kso_kelas_id','$kelas_id_jaminan','$kode_grouper','$biaya_rs','$biaya_kso','$biaya_px')";
														}
														//echo $sql.";<br>";
														$rs1=mysql_query($sql);
														if (mysql_errno()>0){
															$dt="Proses Update Gagal !";
														}else{
															distribusiBiaya($kso_id,$kunj_id,0,$biaya_kso,0);
															distribusiBiayaPx($kso_id,$kunj_id,0,$biaya_px,0);
														}
													}else{
														$biaya_kso=$nilai;
														$sql="SELECT * FROM $dbbilling.b_inacbg_grouper WHERE kunjungan_id='$kunj_id'";
														//echo $sql.";<br>";
														$rs1=mysql_query($sql);
														if (mysql_num_rows($rs1)>0){
															$sql="UPDATE $dbbilling.b_inacbg_grouper SET kelas_id='$kelas_id',kso_kelas_id='$kso_kelas_id',kelas_id_jaminan='$kelas_id_jaminan',kode_grouper_inacbg='$kode_grouper',biaya_rs='$biaya_rs',biaya_kso='$biaya_kso',biaya_px='$biaya_px' WHERE kunjungan_id='$kunj_id'";
														}else{
															$sql="INSERT INTO $dbbilling.b_inacbg_grouper(kunjungan_id,kunjungan_id_group,kelas_id,kso_kelas_id,kelas_id_jaminan,kode_grouper_inacbg,biaya_rs,biaya_kso,biaya_px) VALUES('$kunj_id','$kunj_id','$kelas_id','$kso_kelas_id','$kelas_id_jaminan','$kode_grouper','$biaya_rs','$biaya_kso','$biaya_px')";
														}
														//echo $sql.";<br>";
														$rs1=mysql_query($sql);
														if (mysql_errno()>0){
															$dt="Proses Update Gagal !";
														}else{
															distribusiBiaya($kso_id,$kunj_id,0,$biaya_kso,0,$dbbilling,$dbapotek);
															distribusiBiayaPx($kso_id,$kunj_id,0,$biaya_px,0,$dbbilling,$dbapotek);
														}
													}
												}else{
													$dt="Proses Update Gagal !";
												}
											}
										}
									}
								}
							}
							//====Distribusi Jaminan KSO End====
							//=====Koreksi Distribusi Biaya_Px End====
							$sql="SELECT * FROM $dbbilling.b_bayar WHERE kunjungan_id='$kunj_id' ORDER BY id";
							echo $sql.";<br>";
							$rsPost=mysql_query($sql);
							while ($rwPost=mysql_fetch_array($rsPost)){
								$cidBayar=$rwPost["id"];
								$tgl_act=$rwPost["tgl_act"];
								$jenis_kunjungan=$rwPost["jenis_kunjungan"];
								$kso_id=$rwPost["kso_id"];
								$kasir_id=$rwPost["kasir_id"];
								$no_kwitansi=$rwPost["no_kwitansi"];
								$tagihan=$rwPost["tagihan"];
								$nilai=$rwPost["nilai"];
								$stat_byr=$rwPost["stat_byr"];
								$tipe=$rwPost["tipe"];
								$jBayar=$rwPost["jenis_bayar"];
								echo "stat_byr=$stat_byr".";<br>";
								if ($stat_byr==2){									
									$sql="SELECT
											  ap.ID,
											  ap.QTY,
											  ap.QTY_JUAL,
											  ap.QTY_RETUR,
											  ap.HARGA_SATUAN
											FROM $dbapotek.a_kredit_utang ku
											  INNER JOIN $dbapotek.a_penjualan ap
												ON ((ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN) AND (ku.NORM=ap.NO_PASIEN))
											WHERE ku.BILLING_BAYAR_OBAT_ID = '$cidBayar'";
									//echo $sql.";<br>";
									$rsObat=mysql_query($sql);
									$ok="false";
									while (($rwObat=mysql_fetch_array($rsObat)) && ($ok=="false")){
										$idTind=$rwObat["ID"];
										$tagihan_px=$rwObat["QTY_JUAL"] * $rwObat["HARGA_SATUAN"];
										//echo "nilai=$nilai, tagihan_px=$tagihan_px".";<br>";
										if ($nilai>=$tagihan_px){
											$nilai=$nilai-$tagihan_px;
											if ($nilai==0){
												$ok="true";
											}
											//===Distribusi Pembayaran===
											$sql="INSERT INTO $dbbilling.b_bayar_tindakan
															(bayar_id,
															 tindakan_id,
															 kso_id,
															 nilai,
															 tipe)
												VALUES ($cidBayar,
														$idTind,
														$kso_id,
														$tagihan_px,
														2)";
											//echo $sql.";<br>";
											$rsUpdt=mysql_query($sql);
										}else{
											$ok="true";
											$tagihan_px=$nilai;
											$nilai=0;
											//===Distribusi Pembayaran===
											$sql="INSERT INTO $dbbilling.b_bayar_tindakan
															(bayar_id,
															 tindakan_id,
															 kso_id,
															 nilai,
															 tipe)
												VALUES ($cidBayar,
														$idTind,
														$kso_id,
														$tagihan_px,
														2)";
											//echo $sql.";<br>";
											$rsUpdt=mysql_query($sql);
										}
									}
								}
								
								$sql="SELECT t.* FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
									WHERE p.kunjungan_id='$kunj_id' AND p.jenis_kunjungan='$jenis_kunjungan' AND t.kso_id='$kso_id' AND t.biaya_pasien>t.bayar_pasien";
								echo $sql.";<br>";
								$rsProc=mysql_query($sql);
								$ok="false";
								if (mysql_num_rows($rsProc)>0){
									while (($rwProc=mysql_fetch_array($rsProc)) && ($ok=="false")){
										$idTind=$rwProc["id"];
										$tagihan_px=$rwProc["biaya_pasien"] * $rwProc["qty"] - $rwProc["bayar_pasien"];
										echo "idTind=$idTind, nilai=$nilai, tagihan_px=$tagihan_px".";<br>";
										if ($nilai>=$tagihan_px){
											$nilai=$nilai-$tagihan_px;
											if ($nilai==0){
												$ok="true";
											}
											
											$sql="UPDATE $dbbilling.b_tindakan 
												SET bayar=bayar+$tagihan_px,bayar_pasien=bayar_pasien+$tagihan_px,lunas=1 
												WHERE id='$idTind'";
											echo $sql.";<br>";
											$rsUpdt=mysql_query($sql);
											if (mysql_affected_rows()>0){
												//===Distribusi Pembayaran===
												$sql="INSERT INTO $dbbilling.b_bayar_tindakan
																(bayar_id,
																 tindakan_id,
																 kso_id,
																 nilai,
																 tipe)
													VALUES ($cidBayar,
															$idTind,
															$kso_id,
															$tagihan_px,
															0)";
												echo $sql.";<br>";
												$rsUpdt=mysql_query($sql);
											}
										}else{
											$ok="true";
											$tagihan_px=$nilai;
											$nilai=0;
											
											$sql="UPDATE $dbbilling.b_tindakan 
												SET bayar=bayar+$tagihan_px,bayar_pasien=bayar_pasien+$tagihan_px,lunas=0 
												WHERE id='$idTind'";
											echo $sql.";<br>";
											$rsUpdt=mysql_query($sql);
											if (mysql_affected_rows()>0){
												//===Distribusi Pembayaran===
												$sql="INSERT INTO $dbbilling.b_bayar_tindakan
																(bayar_id,
																 tindakan_id,
																 kso_id,
																 nilai,
																 tipe)
													VALUES ($cidBayar,
															$idTind,
															$kso_id,
															$tagihan_px,
															0)";
												echo $sql.";<br>";
												$rsUpdt=mysql_query($sql);
											}
										}
									}
								}else{
									$sql="SELECT DISTINCT jenis_kunjungan FROM $dbbilling.b_pelayanan WHERE kunjungan_id='$kunj_id' AND jenis_kunjungan<>$jenis_kunjungan AND kso_id='$kso_id'";
									//echo $sql.";<br>";
									$rsProc=mysql_query($sql);
									if (mysql_num_rows($rsProc)>0){
										$rwProc=mysql_fetch_array($rsProc);
										$jenis_kunjungan=$rwProc["jenis_kunjungan"];
										
										$sql="SELECT t.* FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
											WHERE p.kunjungan_id='$kunj_id' AND p.jenis_kunjungan='$jenis_kunjungan' AND t.kso_id='$kso_id' AND t.biaya_pasien>t.bayar_pasien";
										//echo $sql.";<br>";
										$rsProc=mysql_query($sql);
										if (mysql_num_rows($rsProc)>0){
											//====Update b_bayar.jenis_kunjungan===
											$sql="UPDATE $dbbilling.b_bayar SET jenis_kunjungan='$jenis_kunjungan' WHERE id='$cidBayar'";
											//echo $sql.";<br>";
											$rsJKunj=mysql_query($sql);
											$ok="false";
											while (($rwProc=mysql_fetch_array($rsProc)) && ($ok=="false")){
												$idTind=$rwProc["id"];
												$tagihan_px=$rwProc["biaya_pasien"] * $rwProc["qty"] - $rwProc["bayar_pasien"];
												//echo "idTind=$idTind, nilai=$nilai, tagihan_px=$tagihan_px".";<br>";
												if ($nilai>=$tagihan_px){
													$nilai=$nilai-$tagihan_px;
													if ($nilai==0){
														$ok="true";
													}
						
													$tBayarPxNonPiutang="";
													if ($jBayar==0){
														$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$tagihan_px,";
													}
													
													$sql="UPDATE $dbbilling.b_tindakan 
														SET bayar=bayar+$tagihan_px,bayar_pasien=bayar_pasien+$tagihan_px,".$tBayarPxNonPiutang."lunas=1 
														WHERE id='$idTind'";
													//echo $sql.";<br>";
													$rsUpdt=mysql_query($sql);
													if (mysql_affected_rows()>0){
														//===Distribusi Pembayaran===
														$sql="INSERT INTO $dbbilling.b_bayar_tindakan
																		(bayar_id,
																		 tindakan_id,
																		 kso_id,
																		 nilai,
																		 tipe)
															VALUES ($cidBayar,
																	$idTind,
																	$kso_id,
																	$tagihan_px,
																	0)";
														//echo $sql.";<br>";
														$rsUpdt=mysql_query($sql);
													}
												}else{
													$ok="true";
													$tagihan_px=$nilai;
													$nilai=0;
						
													$tBayarPxNonPiutang="";
													if ($jBayar==0){
														$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$tagihan_px,";
													}
													
													$sql="UPDATE $dbbilling.b_tindakan 
														SET bayar=bayar+$tagihan_px,bayar_pasien=bayar_pasien+$tagihan_px,".$tBayarPxNonPiutang."lunas=0 
														WHERE id='$idTind'";
													//echo $sql.";<br>";
													$rsUpdt=mysql_query($sql);
													if (mysql_affected_rows()>0){
														//===Distribusi Pembayaran===
														$sql="INSERT INTO $dbbilling.b_bayar_tindakan
																		(bayar_id,
																		 tindakan_id,
																		 kso_id,
																		 nilai,
																		 tipe)
															VALUES ($cidBayar,
																	$idTind,
																	$kso_id,
																	$tagihan_px,
																	0)";
														//echo $sql.";<br>";
														$rsUpdt=mysql_query($sql);
													}
												}
											}
										}
									}
								}
								
								if (($nilai>0) && ($jenis_kunjungan==3)){
									$sql="SELECT t.*,IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)=0,1, DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in))), (IF(DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)=0,0, DATEDIFF(IFNULL(t.tgl_out,'".tglSQL($tanggalSlip)."'),t.tgl_in)))) * t.beban_pasien AS biaya_pasien 
										FROM $dbbilling.b_tindakan_kamar t 
										INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
										WHERE p.kunjungan_id='$kunj_id' AND t.lunas=0";
									//echo $sql.";<br>";
									$rsProc=mysql_query($sql);
									$ok="false";
									while (($rwProc=mysql_fetch_array($rsProc)) && ($ok=="false")){
										$idTind=$rwProc["id"];
										$tagihan_px=$rwProc["biaya_pasien"] - $rwProc["bayar_pasien"];
										//echo "idTind=$idTind, nilai=$nilai, tagihan_px=$tagihan_px".";<br>";
										if ($nilai>=$tagihan_px){
											$nilai=$nilai-$tagihan_px;
											if ($nilai==0){
												$ok="true";
											}
											
											$tBayarPxNonPiutang="";
											if ($jBayar==0){
												$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$tagihan_px,";
											}
											
											$sql="UPDATE $dbbilling.b_tindakan_kamar 
												SET bayar=bayar+$tagihan_px,bayar_pasien=bayar_pasien+$tagihan_px,".$tBayarPxNonPiutang."lunas=1 
												WHERE id='$idTind'";
											//echo $sql.";<br>";
											$rsUpdt=mysql_query($sql);
											if (mysql_affected_rows()>0){
												//===Distribusi Pembayaran===
												$sql="INSERT INTO $dbbilling.b_bayar_tindakan
																(bayar_id,
																 tindakan_id,
																 kso_id,
																 nilai,
																 tipe)
													VALUES ($cidBayar,
															$idTind,
															$kso_id,
															$tagihan_px,
															1)";
												//echo $sql.";<br>";
												$rsUpdt=mysql_query($sql);
											}
										}else{
											$ok="true";
											$tagihan_px=$nilai;
											$nilai=0;
											
											$tBayarPxNonPiutang="";
											if ($jBayar==0){
												$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$tagihan_px,";
											}
											
											$sql="UPDATE $dbbilling.b_tindakan_kamar 
												SET bayar=bayar+$tagihan_px,bayar_pasien=bayar_pasien+$tagihan_px,".$tBayarPxNonPiutang."lunas=0 
												WHERE id='$idTind'";
											//echo $sql.";<br>";
											$rsUpdt=mysql_query($sql);
											if (mysql_affected_rows()>0){
												//===Distribusi Pembayaran===
												$sql="INSERT INTO $dbbilling.b_bayar_tindakan
																(bayar_id,
																 tindakan_id,
																 kso_id,
																 nilai,
																 tipe)
													VALUES ($cidBayar,
															$idTind,
															$kso_id,
															$tagihan_px,
															1)";
												//echo $sql.";<br>";
												$rsUpdt=mysql_query($sql);
											}
										}
									}
								}
								
								if ($nilai>0){	//Masih bersisa
									$sql="SELECT t.* FROM $dbbilling.b_tindakan t INNER JOIN $dbbilling.b_pelayanan p ON t.pelayanan_id=p.id 
										WHERE p.kunjungan_id='$kunj_id' AND p.jenis_kunjungan<>'$jenis_kunjungan' AND t.kso_id='$kso_id' AND t.biaya_pasien>t.bayar_pasien";
									//echo $sql.";<br>";
									$rsProc=mysql_query($sql);
									if (mysql_num_rows($rsProc)>0){
										$ok="false";
										while (($rwProc=mysql_fetch_array($rsProc)) && ($ok=="false")){
											$idTind=$rwProc["id"];
											$tagihan_px=$rwProc["biaya_pasien"] * $rwProc["qty"] - $rwProc["bayar_pasien"];
											//echo "idTind=$idTind, nilai=$nilai, tagihan_px=$tagihan_px".";<br>";
											if ($nilai>=$tagihan_px){
												$nilai=$nilai-$tagihan_px;
												if ($nilai==0){
													$ok="true";
												}
					
												$tBayarPxNonPiutang="";
												if ($jBayar==0){
													$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$tagihan_px,";
												}
												
												$sql="UPDATE $dbbilling.b_tindakan 
													SET bayar=bayar+$tagihan_px,bayar_pasien=bayar_pasien+$tagihan_px,".$tBayarPxNonPiutang."lunas=1 
													WHERE id='$idTind'";
												//echo $sql.";<br>";
												$rsUpdt=mysql_query($sql);
												if (mysql_affected_rows()>0){
													//===Distribusi Pembayaran===
													$sql="INSERT INTO $dbbilling.b_bayar_tindakan
																	(bayar_id,
																	 tindakan_id,
																	 kso_id,
																	 nilai,
																	 tipe)
														VALUES ($cidBayar,
																$idTind,
																$kso_id,
																$tagihan_px,
																0)";
													//echo $sql.";<br>";
													$rsUpdt=mysql_query($sql);
												}
											}else{
												$ok="true";
												$tagihan_px=$nilai;
												$nilai=0;
					
												$tBayarPxNonPiutang="";
												if ($jBayar==0){
													$tBayarPxNonPiutang="bayar_pasien_non_piutang=bayar_pasien_non_piutang+$tagihan_px,";
												}
												
												$sql="UPDATE $dbbilling.b_tindakan 
													SET bayar=bayar+$tagihan_px,bayar_pasien=bayar_pasien+$tagihan_px,".$tBayarPxNonPiutang."lunas=0 
													WHERE id='$idTind'";
												//echo $sql.";<br>";
												$rsUpdt=mysql_query($sql);
												if (mysql_affected_rows()>0){
													//===Distribusi Pembayaran===
													$sql="INSERT INTO $dbbilling.b_bayar_tindakan
																	(bayar_id,
																	 tindakan_id,
																	 kso_id,
																	 nilai,
																	 tipe)
														VALUES ($cidBayar,
																$idTind,
																$kso_id,
																$tagihan_px,
																0)";
													//echo $sql.";<br>";
													$rsUpdt=mysql_query($sql);
												}
											}
										}
									}
								}
							}*/
						}
					}
				}
			}
		}
		break;
    case 'verifikasi':
		//$noSlip=$_REQUEST["noSlip"];
		$fTgl=tglSQL($tanggalSlip);
		$fdata=$_REQUEST["fdata"];
		$arfdata=explode(chr(6),$fdata);
		/*echo "<script>alert('$arfdata[0],$arfdata[1]');</script>";*/
		if ($posting==0)
		{
			// start verifikasi
			// start verifikasi
			// start verifikasi
			$idpost=gmdate('YmdHis',mktime(date('H')+7)).rand(1,1000);
			//echo "idpost=".$idpost.";<br>";
			for ($i=0;$i<count($arfdata);$i++)
			{
				$cdata=explode(chr(5),$arfdata[$i]);
				$slip_ke=$cdata[3];
				$user_kasir=$cdata[2];
				$ntotal=0;
				$ntotal_ppn=0;
				$ntotal_utip=0;
				$ntotal_diskon_rs = 0;
				$ntotal_diskon_dokter = 0;
				//================ query data bayar =================//
				$sql="SELECT * FROM $dbbilling.b_bayar b 
					WHERE DATE(b.disetor_tgl)='".$fTgl."' AND b.slip_ke='$slip_ke' AND b.user_act='$user_kasir' AND b.posting=0";
				echo "Query data bayar : ".$sql." End query data bayar <br>";
				$rsBayar=mysql_query($sql);

				// start perulangan data bayar 
				while ($rwBayar=mysql_fetch_array($rsBayar)){
					//$idBayar=$cdata[0];
					//$kasirId=$cdata[2];
					$idBayar=$rwBayar["id"];
					$kasirId=$user_kasir;
					//if ($idBayar==64){
					$sql="SELECT posting FROM $dbbilling.b_bayar WHERE id='$idBayar' AND posting=0";
					echo "Cek posting : ".$sql." <br>";
					$rsPost=mysql_query($sql);
					// cek data bayar yang belum diposting
					if (mysql_num_rows($rsPost)>0){
						//Baca Tgl_Penerimaan
						$sql="SELECT tgl FROM $dbbilling.b_bayar WHERE id='$idBayar'";
						echo "Cek  : ".$sql."<br>";
						$rsTglP=mysql_query($sql);
						$rwTglP=mysql_fetch_array($rsTglP);
						$tglP=$rwTglP["tgl"];
						
						$sql="UPDATE $dbbilling.b_bayar SET posting=1,bayar_posting_id='$idpost' WHERE id='$idBayar'";
						echo "Query update status posting data bayar : ".$sql." END<br>";
						$rsPost=mysql_query($sql);

						// jika update status posting data bayar berhasil
						if (mysql_errno()==0){
							// query detail pembayaran 
							$sql="SELECT
									  IFNULL(SUM(nilai),0)    nilai,
									  IFNULL(SUM(biaya),0)    biayaRS,
									  IFNULL(SUM(retribusi),0)    retribusi,
									  IFNULL(SUM(utip),0)    utip,
									  IFNULL(SUM(ppn),0)    ppn,
									  unitId,
									  ksoId,
									  tipe,
									  is_paviliun
									FROM (SELECT
											bt.id,
											(bt.nilai - t.biaya_utip)	AS nilai,
											(bt.nilai - t.biaya_utip) 	AS biaya,
											0	AS retribusi,
											t.biaya_utip 		AS utip,
											0               AS ppn,
											bt.tipe,
											IF(t.ak_ms_unit_id=0,12,t.ak_ms_unit_id)       unitId,
											kso.id      ksoId,
											t.is_paviliun
										  FROM $dbbilling.b_bayar b
											INNER JOIN $dbbilling.b_ms_kso kso
											  ON b.kso_id = kso.id
											INNER JOIN $dbbilling.b_bayar_tindakan bt
											  ON bt.bayar_id = b.id
											INNER JOIN $dbbilling.b_tindakan t
											  ON bt.tindakan_id = t.id
											INNER JOIN $dbbilling.b_pelayanan p
											  ON t.pelayanan_id = p.id
											INNER JOIN $dbbilling.b_ms_unit mu
											  ON p.unit_id = mu.id
											/*INNER JOIN $dbbilling.b_ms_tindakan_kelas mtk
											  ON t.ms_tindakan_kelas_id = mtk.id
											INNER JOIN $dbbilling.b_ms_tindakan mt
											  ON mtk.ms_tindakan_id = mt.id*/
										  WHERE bt.bayar_id = '$idBayar'
											  AND bt.nilai > 0 AND b.flag = '$flag'
											  AND bt.tipe = 0
										  UNION
										  SELECT
										  bt.id,

										  /* perhitungan nilai dan biaya menggunakan hitung hari inap */
										  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,b.tgl),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,b.tgl),t.tgl_in)+1))*(IF(bt.tipe=1,t.beban_pasien,t.retribusi)), (IF(DATEDIFF(IFNULL(t.tgl_out,b.tgl),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,b.tgl),t.tgl_in)+1))*(IF(bt.tipe=1,t.beban_pasien,t.retribusi))) nilai,
										  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,b.tgl),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,b.tgl),t.tgl_in)+1))*(IF(bt.tipe=1,t.beban_pasien,t.retribusi)), (IF(DATEDIFF(IFNULL(t.tgl_out,b.tgl),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,b.tgl),t.tgl_in)+1))*(IF(bt.tipe=1,t.beban_pasien,t.retribusi))) biaya,

										  /* perhitungan nilai dan biaya tdk menggunakan hitung hari inap */
										  /*IF(t.status_out=0,(1)*(IF(bt.tipe=1,t.beban_pasien,t.retribusi)), (1)*(IF(bt.tipe=1,t.beban_pasien,t.retribusi))) nilai,
										  IF(t.status_out=0,(1)*(IF(bt.tipe=1,t.beban_pasien,t.retribusi)), (1)*(IF(bt.tipe=1,t.beban_pasien,t.retribusi))) biaya,*/

										  t.retribusi AS retribusi,										  
										  0               AS utip,
										  0               AS ppn,
										  bt.tipe,
										  IF (bt.tipe=1,9,12)        	unitId,
										  kso.id       ksoId,
										  t.is_paviliun
										FROM $dbbilling.b_bayar b
										  INNER JOIN $dbbilling.b_ms_kso kso
											ON b.kso_id = kso.id
										  INNER JOIN $dbbilling.b_bayar_tindakan bt
											ON b.id = bt.bayar_id
										  INNER JOIN $dbbilling.b_tindakan_kamar t
											ON bt.tindakan_id = t.id
										  INNER JOIN $dbbilling.b_pelayanan p
											ON t.pelayanan_id = p.id
										  INNER JOIN $dbbilling.b_ms_unit mu
											ON p.unit_id = mu.id
										WHERE bt.bayar_id = '$idBayar' AND b.flag = '$flag'
											AND bt.nilai > 0
											AND (bt.tipe = 1/* OR bt.tipe = 4*/)
										  UNION 
										  SELECT
											bt.id,
											IFNULL(SUM(bt.nilai),0) AS nilai,
											IFNULL(SUM(bt.nilai),0) AS biaya,
											0	AS retribusi,
											0	AS utip,
											FLOOR(IFNULL(SUM(bt.nilai),0) * t.PPN/100) AS ppn,
											bt.tipe,
											8        unitId,
											kso_b.id      ksoId,
											pel.is_paviliun
										  FROM $dbbilling.b_bayar b
											INNER JOIN $dbbilling.b_ms_kso kso_b
											  ON b.kso_id = kso_b.id
											INNER JOIN $dbbilling.b_bayar_tindakan bt
											  ON b.id = bt.bayar_id
											INNER JOIN $dbapotek.a_penjualan t
											  ON bt.tindakan_id = t.ID
											INNER JOIN $dbbilling.b_pelayanan pel
											  ON t.NO_KUNJUNGAN = pel.id
											LEFT JOIN $dbapotek.a_unit p
											  ON t.RUANGAN = p.UNIT_ID
											LEFT JOIN $dbbilling.b_ms_unit bmu
											  ON p.unit_billing = bmu.id
											INNER JOIN $dbapotek.a_unit mu
											  ON t.UNIT_ID = mu.UNIT_ID
										  WHERE bt.bayar_id = '$idBayar'
											  AND bt.nilai > 0 /*AND b.flag = '$flag'*/
											  AND bt.tipe = 2
										  GROUP BY t.UNIT_ID,t.USER_ID,t.KSO_ID,t.NO_KUNJUNGAN,t.NO_PASIEN,t.NO_PENJUALAN) AS gab
									GROUP BY gab.tipe,gab.is_paviliun,gab.unitId,gab.ksoId";
							echo "Query detail per pembayaran : ".$sql."<br>";
									// IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,b.tgl),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,b.tgl),t.tgl_in)+1))*((t.retribusi)), (IF(DATEDIFF(IFNULL(t.tgl_out,b.tgl),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,b.tgl),t.tgl_in)+1))*((t.retribusi)))
									//decyber retribusi
							$rsPost=mysql_query($sql);

							//ambil data diskon dokter
							$sqlDokDiskon = "SELECT b.kasir_id,b.kso_id,b.dokter_diskon FROM $dbbilling.b_bayar b WHERE b.id = {$idBayar}";

							$queryDokDiskon = mysql_query($sqlDokDiskon);
							$nilaiDiskonDokter = 0;
							if(mysql_num_rows($queryDokDiskon) > 0){
								$fetch = mysql_fetch_assoc($queryDokDiskon);
								$dataDokterPemberiDiskon = explode('**',$fetch['dokter_diskon']);

								for($i = 0; $i < sizeof($dataDokterPemberiDiskon); $i++){

								$arrDataDiskonAndIdDokter = explode(":", $dataDokterPemberiDiskon[$i]);
								

								$idDokter = $arrDataDiskonAndIdDokter[0];
								$nilaiDiskonDokter = $arrDataDiskonAndIdDokter[1];
								$ksoIdDokter = $fetch['kso_id'];
								$kasirIdDokter = $fetch['kasir_id'];
								$ntotal_diskon_dokter += $nilaiDiskonDokter;
								
								//masukan ke dalam table k_transaksi
								if($nilaiDiskonDokter > 0){
									$sqlDiskonDokterToTransaksi = "INSERT INTO k_transaksi(fk_id,fk_bayar_posting_id,id_trans,tgl,tgl_klaim,no_bukti,unit_id_billing,kso_id,kasir_id,nilai_sim,nilai,isFarmasi,isPavilyun,verifikasi,posting,user_act,tgl_act,flag,id_dokter_diskon)VALUES('{$idBayar}','{$idpost}','{$IdTrans}','{$tglP}','".tglSql($tanggalSlip)."','{$no_slip}',0,'{$ksoIdDokter}','{$kasirId}','{$nilaiDiskonDokter}','{$nilaiDiskonDokter}',0,0,1,0,'{$idUser}',NOW(),'{$flag}',{$idDokter})";
										// mysql_query($sqlDiskonDokterToTransaksi);
									}	
								}
								 
							}

							//ambil data diskon rs
							$sqlRskDiskon = "SELECT b.kso_id,b.nilai_diskon FROM $dbbilling.b_bayar b WHERE b.id = {$idBayar}";
							echo $sqlRskDiskon;
							$queryDokDiskon = mysql_query($sqlRskDiskon);
							$nilaiDiskonRs = 0;
							if(mysql_num_rows($queryDokDiskon) > 0){
								$fetch = mysql_fetch_assoc($queryDokDiskon);
								$nilaiDiskonRs = $fetch['nilai_diskon'];
								$ksoIdDokter = $fetch['kso_id'];
								$ntotal_diskon_rs += $nilaiDiskonRs;
								//masukan ke dalam table k_transaksi
								if($nilaiDiskonRs > 0){
									$sqlDiskonDokterToTransaksi = "INSERT INTO k_transaksi(fk_id,fk_bayar_posting_id,id_trans,tgl,tgl_klaim,no_bukti,unit_id_billing,kso_id,kasir_id,nilai_sim,nilai,isFarmasi,isPavilyun,verifikasi,posting,user_act,tgl_act,flag)VALUES('{$idBayar}','{$idpost}','{$IdTrans}','{$tglP}','".tglSql($tanggalSlip)."','{$no_slip}',0,'{$ksoIdDokter}','{$kasirId}','{$nilaiDiskonRs}','{$nilaiDiskonRs}',0,0,1,0,'{$idUser}',NOW(),'{$flag}')";
									// mysql_query($sqlDiskonDokterToTransaksi);
								}
								 
							}

							//letakan perlakuan insert diskon disini kita tidak perlu mengulang nya

							if (mysql_errno()==0){
								while ($rwPost=mysql_fetch_array($rsPost)){
									// var_dump($rwpost);
									$ksoId=$rwPost["ksoId"];
									$unitId=$rwPost["unitId"];
									$nilai= $rwPost["nilai"];
									$biayaRS=$rwPost["nilai"];
									$retribusi=$rwPost["retribusi"];
									$utip=$rwPost["utip"];
									$ppn=$rwPost["ppn"];
									$tipe=$rwPost["tipe"];
									$is_paviliun=$rwPost["is_paviliun"];
									
									$ntotal += $nilai;
									
									$sql="INSERT INTO k_transaksi(fk_id,fk_bayar_posting_id,id_trans,tgl,tgl_klaim,no_bukti,unit_id_billing,kso_id,kasir_id,nilai_sim,nilai,isFarmasi,isPavilyun,verifikasi,posting,user_act,tgl_act,flag) VALUES('$idBayar','$idpost','$IdTrans','".$tglP."','".tglSQL($tanggalSlip)."','$no_slip','$unitId','$ksoId','$kasirId','$biayaRS','$nilai','$tipe','$is_paviliun',1,0,'$idUser',NOW(),'$flag')";
									echo $sql."<br>";
									$rsIns=mysql_query($sql);
									if (mysql_errno()>0)
									{
										$statusProses='Error';
									}else{
										if ($ppn>0){
											$ntotal_ppn += $ppn;
											$ntotal += $ppn;
											
											$sql="INSERT INTO k_transaksi(fk_id,fk_bayar_posting_id,id_trans,tgl,tgl_klaim,no_bukti,unit_id_billing,kso_id,kasir_id,nilai_sim,nilai,isFarmasi,isPavilyun,verifikasi,posting,user_act,tgl_act,flag) VALUES('$idBayar','$idpost','$IdTrans','".$tglP."','".tglSQL($tanggalSlip)."','$no_slip','0','$ksoId','$kasirId','$ppn','$ppn','3','$is_paviliun',1,0,'$idUser',NOW(),'$flag')";
											//echo $sql.";<br>";
											$rsIns=mysql_query($sql);
										}
										
										if ($retribusi>0){
											$ntotal +=$retribusi;
											
											$sql="INSERT INTO k_transaksi(fk_id,fk_bayar_posting_id,id_trans,tgl,tgl_klaim,no_bukti,unit_id_billing,kso_id,kasir_id,nilai_sim,nilai,isFarmasi,isPavilyun,verifikasi,posting,user_act,tgl_act,flag) VALUES('$idBayar','$idpost','$IdTrans','".$tglP."','".tglSQL($tanggalSlip)."','$no_slip','12','$ksoId','$kasirId','$retribusi','$retribusi','4','$is_paviliun',1,0,'$idUser',NOW(),'$flag')";
											//echo $sql.";<br>";
											$rsIns=mysql_query($sql);
										}
										
										if ($utip>0){
											$ntotal_utip +=$utip;
											$ntotal +=$utip;
											
											$sql="INSERT INTO k_transaksi(fk_id,fk_bayar_posting_id,id_trans,tgl,tgl_klaim,no_bukti,unit_id_billing,kso_id,kasir_id,nilai_sim,nilai,isFarmasi,isPavilyun,verifikasi,posting,user_act,tgl_act,flag) VALUES('$idBayar','$idpost','$IdTrans','".$tglP."','".tglSQL($tanggalSlip)."','$no_slip','0','$ksoId','$kasirId','$utip','$utip','5','$is_paviliun',1,0,'$idUser',NOW(),'$flag')";
											//echo $sql.";<br>";
											$rsIns=mysql_query($sql);
										}
									}
								}
							}else{
								$statusProses='Error';
								$alasan='Posting Gagal';
								$sql="UPDATE $dbbilling.b_bayar SET posting=0,bayar_posting_id='0' WHERE id='$idBayar'";
								//echo $sql.";<br>";
								$rsBatalPost=mysql_query($sql);
							}
						}
						// end jika update status posting data bayar berhasil
						else{
							$statusProses='Error';
							$alasan='Posting Gagal';
						}
					}
					// end cek data bayar yang belum diposting				
				}
				// end perulangan data bayar 
			}
			//============ Posting Jurnal Akuntansi ===========//
			if ($statusProses==''){
				//===============================
				$idpost=gmdate('YmdHis',mktime(date('H')+7)).rand(1,1000);
				$id_k_trans=$idpost;
				//$IdTrans=38;
			
				//$user_kasir=$user_kasir;
				$nslip=$no_slip;
				$tanggalSlipAk=tglSQL($tanggalSlip);
				$tglP=$tanggalSlipAk;
				$no_bukti=$nslip;
				//$id_k_trans++;
				if ($nokw=="") $nokw=$no_bukti;
				
				$sql="update ".$dbkeuangan.".k_transaksi set no_post='$id_k_trans' 
					where kasir_id='$user_kasir' AND tgl_klaim='$tanggalSlipAk' AND id_trans='$IdTrans' AND no_bukti = '$nslip'";
				//echo $sql.";<br>";
				$rsPost=mysql_query($sql);
				if (mysql_errno()==0 && mysql_affected_rows()>0)
				{						
					/*$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans FROM ".$dbakuntansi.".jurnal";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$notrans=$rwPost["notrans"];*/
					
					$sql="SELECT * FROM ".$dbbilling.".b_ms_pegawai WHERE id='$user_kasir'";
					//echo $sql.";<br>";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$ckasir=$rwPost["nama"];
					$uraian="Penerimaan Kasir : ".$ckasir.", Slip : $nslip, ".$tanggalSlipAk;
					
					//=====insert into Kas==========Diganti Bank========
					//$id_sak=5;	//Kas Penerimaan dan Pendapatan IDR
					$id_sak=6;	//Kas Kecil
					//$id_sak_ppn=1226;	//Hutang PPN  - PPN Keluaran IDR
					// $id_sak_ppn=4135;	//Hutang PPN  - PPN Keluaran
					$id_sak_ppn=1415;	//Hutang PPN  - PPN Keluaran sementara diobat *decyber
					//$id_sak_utip=1206;	//Utip - Lainnya IDR
						// $id_sak_utip=4134;	//Utip - Lainnya dganti 2274 melly
					$id_sak_utip=2274;	//Utip - Lainnya dganti 2274 melly
					$jenistrans=9;	//1112a - Terjadinya Transaksi Pendapatan (Tunai) - Tipe: Normal

					$id_sak_diskon_dokter = 2316;

					$id_sak_diskon_rs = 0;

					$id_sak_pelayanan_medik = 1409;

					echo '<br><br><br>' .$ntotal_ppn . ' - ' . $ntotal_utip . '<br><br><br>';					
					echo '<br><br><br>' .$ntotal . ' - ' . $ntotal_diskon_dokter . '<br><br><br>';					
					//kurangi total dengan diskon dokter
					// $ntotal -= $ntotal_diskon_dokter;
					// $ntotal = $ntotal + $ntotal_diskon_dokter + $ntotal_diskon_rs;
					
					$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,FK_ID_USER_APP,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,POSTING,VERIFIKASI,flag) 
		VALUES('$id_k_trans','$user_kasir','0','1',$id_sak,'$tglP','$nokw','$uraian',$ntotal,0,now(),'0','D',0,$jenistrans,$jenistrans,1,'$no_bukti','0','0',1,0,'$flag')";
					//echo $sql.";<br>";
					$rsPost=mysql_query($sql);
					
					$sql="SELECT
							  t.id,
							  t.unit_id_billing,
							  t.kso_id,
							  t.tgl,
							  t.tgl_klaim,
  							  SUM(t.nilai_sim)      AS nilai_sim,
							  SUM(t.nilai)      AS nilai,
							  kso.tipe_kso,
							  IF (kso.tipe_kso=0,mu.akun_pend_eksternal,mu.akun_pend_internal) AS akun_pend,
							  mu.akun_pend_internal,
							  mu.akun_pend_eksternal
							FROM $dbkeuangan.k_transaksi t
								INNER JOIN $dbbilling.b_ms_kso kso
    								ON t.kso_id = kso.id
								LEFT JOIN $dbakuntansi.ak_ms_unit mu
    								ON t.unit_id_billing = mu.id
							WHERE t.kasir_id = '$user_kasir'
								AND t.no_bukti = '$nslip'
								AND t.tgl_klaim = '$tanggalSlipAk'
								AND t.id_trans = '$IdTrans' 
							GROUP BY t.unit_id_billing,t.kso_id,t.tgl_klaim 
							ORDER BY t.unit_id_billing,t.id";
					//echo $sql.";<br>";
					$rsData=mysql_query($sql);
					//$ntotal=0;
					$nppn=0;
					$jTransSetor=345;	// 2005 - Kas Bendahara Penerimaan - Bank BLUD
					while ($rwData=mysql_fetch_array($rsData)){
						//$id_k_trans=0;
						//$tglP=$rwData["tgl"];
						$kso=$rwData["kso_id"];
						$unit_id=$rwData["unit_id_billing"];
						$idunit=$unit_id;
						$akun_pend=$rwData["akun_pend"];
						$nilai_sim=$rwData["nilai_sim"];
						$nilai_slip=$rwData["nilai"];
						//$ntotal +=$nilai_slip;
						
						if ($unit_id<>0){
							$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id='$kso'";
							//echo $sql.";<br>";
							$rsKso=mysql_query($sql);
							$rwKso=mysql_fetch_array($rsKso);
							$ctipeKso=$rwKso["type"];
							$ksoNama=$rwKso["nama"];
							$kdkso=$rwKso["kode_ak"];
	
							$uraian="Penerimaan Kasir : ".$ckasir.", Slip : $nslip, ".$tanggalSlipAk." - ".$ksoNama;
							//$kdkso=$rwPost["kode_ak"];
							
							$id_pendapatan=$akun_pend;	//Pendapatan Kl.. Eks/Inter (Tunai)
							
							$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,FK_ID_USER_APP,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,KSO_ID,POSTING,VERIFIKASI,flag) 
			VALUES('$id_k_trans','$user_kasir','0','1',$id_pendapatan,'$tglP','$nokw','$uraian',0,$nilai_slip,now(),0,'K',0,$jenistrans,$jenistrans,1,'$no_bukti',$kso,$idunit,$kso,1,0,'$flag')";
							//echo $sql.";<br>";
							$rsPost=mysql_query($sql);
						}else{
							//$nppn +=$nilai_slip;
						}
					}

					//lakukan pengambilan data untuk diskon dokter yang di sum berdasarkan id dokter yang sama
					$sqlDiskonDokterToAkuntansi="SELECT
							  t.id,
							  t.unit_id_billing,
							  t.kso_id,
							  t.tgl,
							  t.tgl_klaim,
  							  SUM(t.nilai_sim)      AS nilai_sim,
							  SUM(t.nilai)      AS nilai,
							  kso.tipe_kso,
							  IF (kso.tipe_kso=0,mu.akun_pend_eksternal,mu.akun_pend_internal) AS akun_pend,
							  mu.akun_pend_internal,
							  mu.akun_pend_eksternal,
							  p.nama AS nama_dokter
							FROM $dbkeuangan.k_transaksi t
								INNER JOIN $dbbilling.b_ms_kso kso
    								ON t.kso_id = kso.id
								LEFT JOIN $dbakuntansi.ak_ms_unit mu
    								ON t.unit_id_billing = mu.id
    							LEFT JOIN $dbbilling.b_ms_pegawai p
    								ON p.id = t.id_dokter_diskon
							WHERE t.kasir_id = '$user_kasir'
								AND t.no_bukti = '$nslip'
								AND t.tgl_klaim = '$tanggalSlipAk'
								AND t.id_trans = '$IdTrans'
								AND t.id_dokter_diskon != 0 
							GROUP BY t.unit_id_billing,t.kso_id,t.tgl_klaim,t.id_dokter_diskon 
							ORDER BY t.unit_id_billing,t.id";
					$queryData = mysql_query($sqlDiskonDokterToAkuntansi);
					
					while($rows = mysql_fetch_assoc($queryData)){
						$uraian = "Pemberian Diskon : " . $rows['nama_dokter'] . ", Slip : $nslip, ". $tanggalSlipAk;
						$nilai = $rows['nilai'];
						$sql = "INSERT INTO ".$dbakuntansi.".jurnal (
												FK_ID_POSTING,
												FK_ID_USER_APP,
												NO_TRANS,
												NO_PASANGAN,
												FK_SAK,
												TGL,
												NO_KW,
												URAIAN,
												DEBIT,
												KREDIT,
												TGL_ACT,
												FK_IDUSER,
												D_K,
												JENIS,
												FK_TRANS,
												FK_LAST_TRANS,
												STATUS,
												NO_BUKTI,
												CC_RV_KSO_PBF_UMUM_ID,
												CC_RV_ID,
												KSO_ID,
												POSTING,
												VERIFIKASI,
												flag 
											)
											VALUES
												(
													'$id_k_trans',
													'$user_kasir',
													'0',
													'1',
													$id_sak_diskon_dokter,
													'$tglP',
													'$nokw',
													'$uraian',
													{$nilai},
													0,
													now(),
													0,
													'D',
													0,
													$jenistrans,
													$jenistrans,
													1,
													'$no_bukti',
													'$kso',
													'0',
													'$kso',
													1,
												0,
												'$flag')";
						echo "<br> <br> <br>Penerimaan Diskon Billing Dokter : ". $sql;
						// mysql_query($sql);

						//masukan kredit ke coa 4.1.40.03 Pelayanan Medik
						$sql = "INSERT INTO ".$dbakuntansi.".jurnal (
												FK_ID_POSTING,
												FK_ID_USER_APP,
												NO_TRANS,
												NO_PASANGAN,
												FK_SAK,
												TGL,
												NO_KW,
												URAIAN,
												DEBIT,
												KREDIT,
												TGL_ACT,
												FK_IDUSER,
												D_K,
												JENIS,
												FK_TRANS,
												FK_LAST_TRANS,
												STATUS,
												NO_BUKTI,
												CC_RV_KSO_PBF_UMUM_ID,
												CC_RV_ID,
												KSO_ID,
												POSTING,
												VERIFIKASI,
												flag 
											)
											VALUES
												(
													'$id_k_trans',
													'$user_kasir',
													'0',
													'1',
													$id_sak_pelayanan_medik,
													'$tglP',
													'$nokw',
													'$uraian',
													0,
													{$nilai},
													now(),
													0,
													'K',
													0,
													$jenistrans,
													$jenistrans,
													1,
													'$no_bukti',
													'$kso',
													'0',
													'$kso',
													1,
												0,
												'$flag')";
						echo "<br> <br> <br>Penerimaan Diskon Billing Dokter : ". $sql;
						// mysql_query($sql);
					}

					//masukan total diskon rs ke sini

					if($ntotal_diskon_rs > 0){
						$uraian = "Pemberian Diskon Rs : " . $ckasir . ", Slip : $nslip, ". $tanggalSlipAk;

						$sql = "INSERT INTO ".$dbakuntansi.".jurnal (
												FK_ID_POSTING,
												FK_ID_USER_APP,
												NO_TRANS,
												NO_PASANGAN,
												FK_SAK,
												TGL,
												NO_KW,
												URAIAN,
												DEBIT,
												KREDIT,
												TGL_ACT,
												FK_IDUSER,
												D_K,
												JENIS,
												FK_TRANS,
												FK_LAST_TRANS,
												STATUS,
												NO_BUKTI,
												CC_RV_KSO_PBF_UMUM_ID,
												CC_RV_ID,
												KSO_ID,
												POSTING,
												VERIFIKASI,
												flag 
											)
											VALUES
												(
													'$id_k_trans',
													'$user_kasir',
													'0',
													'1',
													$id_sak_diskon_dokter,
													'$tglP',
													'$nokw',
													'$uraian',
													{$ntotal_diskon_rs},
													0,
													now(),
													0,
													'D',
													0,
													$jenistrans,
													$jenistrans,
													1,
													'$no_bukti',
													'$kso',
													'0',
													'$kso',
													1,
												0,
												'$flag')";
						echo "<br> <br> <br>Penerimaan Diskon Billing Dokter : ". $sql;
						// mysql_query($sql);

						//masukan kredit ke coa 4.1.40.03 Pelayanan Medik
						$sql = "INSERT INTO ".$dbakuntansi.".jurnal (
												FK_ID_POSTING,
												FK_ID_USER_APP,
												NO_TRANS,
												NO_PASANGAN,
												FK_SAK,
												TGL,
												NO_KW,
												URAIAN,
												DEBIT,
												KREDIT,
												TGL_ACT,
												FK_IDUSER,
												D_K,
												JENIS,
												FK_TRANS,
												FK_LAST_TRANS,
												STATUS,
												NO_BUKTI,
												CC_RV_KSO_PBF_UMUM_ID,
												CC_RV_ID,
												KSO_ID,
												POSTING,
												VERIFIKASI,
												flag 
											)
											VALUES
												(
													'$id_k_trans',
													'$user_kasir',
													'0',
													'1',
													$id_sak_pelayanan_medik,
													'$tglP',
													'$nokw',
													'$uraian',
													0,
													{$ntotal_diskon_rs},
													now(),
													0,
													'K',
													0,
													$jenistrans,
													$jenistrans,
													1,
													'$no_bukti',
													'$kso',
													'0',
													'$kso',
													1,
												0,
												'$flag')";
						echo "<br> <br> <br>Penerimaan Diskon Rs : ". $sql;
						// mysql_query($sql);
					}

					//if ($nppn>0){
					if ($ntotal_ppn>0){
						$uraian="Penerimaan Kasir : ".$ckasir.", Slip : $nslip, ".$tanggalSlipAk;
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,FK_ID_USER_APP,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,KSO_ID,POSTING,VERIFIKASI,flag) 
		VALUES('$id_k_trans','$user_kasir','0','1',$id_sak_ppn,'$tglP','$nokw','$uraian',0,$ntotal_ppn,now(),0,'K',0,$jenistrans,$jenistrans,1,'$no_bukti','$kso','0','$kso',1,0,'$flag')";
						//echo $sql.";<br>";
						$rsPost=mysql_query($sql);
					}

					if ($ntotal_utip>0){
						$uraian="Penerimaan Kasir : ".$ckasir.", Slip : $nslip, ".$tanggalSlipAk;
						$sql="INSERT INTO ".$dbakuntansi.".jurnal(FK_ID_POSTING,FK_ID_USER_APP,NO_TRANS,NO_PASANGAN,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,CC_RV_ID,KSO_ID,POSTING,VERIFIKASI,flag) 
		VALUES('$id_k_trans','$user_kasir','0','1',$id_sak_utip,'$tglP','$nokw','$uraian',0,$ntotal_utip,now(),0,'K',0,$jenistrans,$jenistrans,1,'$no_bukti','$kso','0','$kso',1,0,'$flag')";
						//echo $sql.";<br>";
						$rsPost=mysql_query($sql);
					}
				}
				else
				{
					$statusProses='Error';
				}				
			}
		}
		// end verifikasi
		// end verifikasi
		// end verifikasi
		else
		{
			for ($i=0;$i<count($arfdata);$i++)
			{
				$cdata=explode(chr(5),$arfdata[$i]);
				$slip_ke=$cdata[3];
				$fk_bayar_posting_id=$cdata[6];
				$no_post=$cdata[7];
				
				$user_kasir=$cdata[2];
				//$idBayar=$cdata[0];
				//$nilai=$cdata[1];
				$kasirId=$cdata[2];
				
				//$sql="SELECT * FROM $dbbilling.b_bayar WHERE id='$idBayar' AND posting=1";
				$sql="SELECT
						  *
						FROM k_transaksi t
						WHERE t.fk_bayar_posting_id = '$fk_bayar_posting_id'
							AND t.posting = '0'
							AND t.id_trans = '$IdTrans'";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				if (mysql_num_rows($rsPost)>0){
					$rwPost=mysql_fetch_array($rsPost);
					$no_post=$rwPost["no_post"];
					
					$sql="UPDATE $dbbilling.b_bayar SET posting=0,bayar_posting_id=0 WHERE bayar_posting_id='$fk_bayar_posting_id'";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					if (mysql_errno()==0){
						$sql="DELETE FROM k_transaksi WHERE fk_bayar_posting_id='$fk_bayar_posting_id' AND id_trans='$IdTrans' AND verifikasi=1";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						if (mysql_errno()>0){
							$statusProses='Error';
							$alasan='UnPosting Gagal';
							//========== b_bayar --> dikembalikan posting=1 ==============
							$sql="UPDATE $dbbilling.b_bayar SET posting=1,bayar_posting_id='$fk_bayar_posting_id' 
								WHERE id IN (SELECT DISTINCT fk_id FROM k_transaksi WHERE fk_bayar_posting_id='$fk_bayar_posting_id')";
							$rsBatalPost=mysql_query($sql);
							//========== End b_bayar --> dikembalikan posting=1 ==============
						}else{
							$sql="DELETE FROM $dbakuntansi.jurnal WHERE FK_ID_POSTING='$no_post'";
							//echo $sql."<br>";
							$rsPost=mysql_query($sql);
						}
					}else{
						$statusProses='Error';
						$alasan='UnPosting Gagal';
					}
				}else{
					$statusProses='Error';
					if (count($arfdata)==1){
						$alasan='Data Sudah Diposting ke Jurnal Akuntansi, Jadi Tidak Boleh DiUnverifikasi';
					}else{
						$alasan='Sebagian Data Sudah Diposting ke Jurnal Akuntansi, Jadi Tidak Boleh DiUnverifikasi';
					}
				}
			}			
		}
        break;
}

if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act'])."|".$alasan;
}
else {
    if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
    }

    if ($sorting=="") {
        $sorting=$defaultsort;
    }
	
	if ($grd == "penerimaanBillingKasirRkp"){
		//$fkasir=" AND mp.id = '$kasir' ";
		$fkasir=" AND b.user_act = '$kasir' ";
		if ($kasir==0){
			$fkasir="";
		}
		
		//$fTgl=tglSQL($tanggal);
		$fTgl=tglSQL($tanggalSlip);
		
		$fTipeTrans="";
		$fFilterTgl=" AND DATE(b.disetor_tgl) = '".$fTgl."'";		
		$fposting=" AND b.posting=$posting ";
		$fNoBuktiSetor="''        AS no_slip_setor";
		$fNilai="SUM(b.nilai) AS nilai";
		
		if ($posting!="0"){
			$fTipeTrans=" AND t.id_trans='$IdTrans' ";
			$fFilterTgl=" AND t.tgl_klaim = '".$fTgl."'";
			$fposting="";
			$fNoBuktiSetor="t.no_bukti AS no_slip_setor";
			$fNilai="SUM(t.nilai) AS nilai";
			
			$sql="SELECT *
					FROM (SELECT
					  b.id,
					  DATE_FORMAT(b.disetor_tgl,'%d-%m-%Y') AS tgl,
					  b.slip_ke,
					  /*b.bayar_posting_id,*/
					  IFNULL(t.fk_bayar_posting_id,0) AS fk_bayar_posting_id,
					  IFNULL(t.no_post,0) AS no_post,
					  IFNULL(t.posting,0) AS tposting,
					  $fNoBuktiSetor,
					  b.user_act,
					  mp.nama   AS pegawai_kasir,
					  $fNilai
					FROM $dbbilling.b_bayar b
					  INNER JOIN $dbbilling.b_ms_pegawai mp
						ON b.user_act = mp.id
					  LEFT JOIN k_transaksi t
						ON b.id = t.fk_id
					WHERE 1 = 1 AND b.flag = '$flag'
						$fFilterTgl 
						$fposting
						$fTipeTrans
					GROUP BY DATE(b.disetor_tgl),b.slip_ke, b.user_act) AS gab
					WHERE 1 = 1 $filter
					ORDER BY ".$sorting;
		}else{	
			$sql="SELECT *
					FROM (SELECT
					  b.id,
					  DATE_FORMAT(b.disetor_tgl,'%d-%m-%Y') AS tgl,
					  b.slip_ke,
					  0 AS fk_bayar_posting_id,
					  0 AS no_post,
					  0 AS tposting,
					  $fNoBuktiSetor,
					  b.user_act,
					  mp.nama   AS pegawai_kasir,
					  $fNilai
					FROM $dbbilling.b_bayar b
					  INNER JOIN $dbbilling.b_ms_pegawai mp
						ON b.user_act = mp.id
					WHERE 1 = 1 AND b.flag = '$flag'
						$fFilterTgl 
						$fposting
						$fTipeTrans
					GROUP BY DATE(b.disetor_tgl),b.slip_ke, b.user_act) AS gab
					WHERE 1 = 1 $filter
					ORDER BY ".$sorting;
		}
		
/*		$sql="SELECT *
				FROM (SELECT
				  b.id,
				  DATE_FORMAT(b.disetor_tgl,'%d-%m-%Y') AS tgl,
				  b.slip_ke,
				  IFNULL(t.fk_bayar_posting_id,0) AS fk_bayar_posting_id,
				  IFNULL(t.no_post,0) AS no_post,
				  IFNULL(t.posting,0) AS tposting,
				  $fNoBuktiSetor,
				  b.user_act,
				  mp.nama   AS pegawai_kasir,
				  $fNilai
				FROM $dbbilling.b_bayar b
				  INNER JOIN $dbbilling.b_ms_pegawai mp
					ON b.user_act = mp.id
				  LEFT JOIN k_transaksi t
					ON b.id = t.fk_id
				WHERE 1 = 1
					$fFilterTgl 
					$fposting
					$fTipeTrans
				GROUP BY DATE(b.disetor_tgl),b.slip_ke, b.user_act) AS gab
				WHERE 1 = 1 $filter
				ORDER BY ".$sorting;*/
		
		if($posting == 0){
			$sqlSum = "select ifnull(sum(nilai),0) as totnilai from (".$sql.") sql36";
		} else {
			$sqlSum = "select ifnull(sum(nilai),0) as totnilai from (".$sql.") sql36";
		}
		//echo $sqlSum.";<br>";
		$rsSum = mysql_query($sqlSum);
		$rwSum = mysql_fetch_array($rsSum);
		$stot = $rwSum["totnilai"];
    }else if ($grd == "penerimaanBillingKasir"){
    	// start detail rekap transaksi per setoran

		//$fkasir=" AND mp.id = '$kasir' ";
		$fkasir=" AND b.user_act = '$kasir' ";
		if ($kasir==0){
			$fkasir="";
		}
		
		//$fTgl=tglSQL($tanggal);
		$fTgl=tglSQL($tanggalSlip);
		
		$Slip_ke=$_REQUEST["Slip_ke"];
		$fSlip_ke=" AND b.slip_ke='$Slip_ke' ";
		$fTipeTrans="";
		$fFilterTgl=" AND DATE(b.disetor_tgl) = '".$fTgl."'";		
		$fposting=" AND b.posting=$posting ";
				
		$fBtind="LEFT JOIN (SELECT bt.id,bt.bayar_id,bt.nilai
							FROM $dbbilling.b_bayar b
							  INNER JOIN $dbbilling.b_bayar_tindakan bt
								ON b.id = bt.bayar_id
							  INNER JOIN $dbbilling.b_tindakan t
								ON bt.tindakan_id = t.id
							WHERE bt.tipe = 0
								$fkasir 
								$fSlip_ke 
								$fposting 
								$fTipeTrans
							  	$fFilterTgl
							UNION
							SELECT bt.id,bt.bayar_id,bt.nilai+t.retribusi AS nilai
							FROM $dbbilling.b_bayar b
							  INNER JOIN $dbbilling.b_bayar_tindakan bt
								ON b.id = bt.bayar_id
							  INNER JOIN $dbbilling.b_tindakan_kamar t
								ON bt.tindakan_id = t.id
							WHERE (bt.tipe = 1/* OR bt.tipe = 4*/) AND b.flag='$flag'
								$fkasir 
								$fSlip_ke 
								$fposting 
								$fTipeTrans
							  	$fFilterTgl
							UNION
							SELECT bt.id,bt.bayar_id,SUM(bt.nilai)+FLOOR(t.PPN/100*SUM(bt.nilai)) AS nilai
							FROM $dbbilling.b_bayar b
							  INNER JOIN $dbbilling.b_bayar_tindakan bt
								ON b.id = bt.bayar_id
							  INNER JOIN $dbapotek.a_penjualan t
								ON bt.tindakan_id = t.ID
							WHERE bt.tipe = 2 AND b.flag='$flag'
								$fkasir 
								$fSlip_ke 
								$fposting 
								$fTipeTrans
							  	$fFilterTgl GROUP BY t.UNIT_ID,t.USER_ID,t.NO_KUNJUNGAN,t.NO_PASIEN,t.NO_PENJUALAN,t.NO_RESEP) bt
						  ON b.id = bt.bayar_id";
						  // (DATEDIFF(IFNULL(IF(t.tgl_out IS NOT NULL && DATEDIFF(t.tgl_out, b.tgl_act) < 0, t.tgl_out, b.tgl_act), b.tgl_act),t.tgl_in)+1)*
						  //decyber

		$fNilaiD="IFNULL(SUM(bt.nilai),0)";
		if ($posting!="0"){
			$fTipeTrans=" AND t.id_trans='$IdTrans' ";
			$fFilterTgl=" AND t.`tgl_klaim` = '".$fTgl."'";
			$fBtind="";
			$fNilaiD="(SELECT 
						  IFNULL(SUM(kt.nilai), 0) 
						FROM
						  k_transaksi kt 
						WHERE kt.fk_id = b.id /*8-7-2019 Hafiz antisipasi ada old data*/  AND kt.fk_bayar_posting_id = b.bayar_posting_id)";
		}
		
		$sql="SELECT *
				FROM (SELECT DISTINCT
						b.id,
						b.jenis_bayar,
						IF (b.jenis_bayar=0,'Bayar Tagihan','Bayar Piutang') AS jbayar,
						DATE_FORMAT(b.tgl,'%d-%m-%Y') AS tglP,
						b.user_act,
						b.nobukti,
						b.no_kwitansi,
						b.nilai,
						b.ket,
						IFNULL(t.posting,0) AS tposting,
						t.no_bukti    AS no_slip,
						k.no_billing,
						k.tgl,
						pas.no_rm,
						pas.nama,
						mu.nama       AS kasir,
						mp.nama       AS petugas,
						b.slip_ke,
						$fNilaiD AS nilaiD
					  FROM $dbbilling.b_bayar b
						$fBtind
						INNER JOIN $dbbilling.b_ms_pegawai mp
						  ON b.user_act = mp.id
						INNER JOIN $dbbilling.b_ms_unit mu
						  ON b.kasir_id = mu.id
						INNER JOIN $dbbilling.b_kunjungan k
						  ON b.kunjungan_id = k.id
						INNER JOIN $dbbilling.b_ms_pasien pas
						  ON k.pasien_id = pas.id
						LEFT JOIN k_transaksi t
						  ON b.id = t.fk_id
					  WHERE 1 = 1 AND b.flag='$flag'
					      $fkasir 
						  $fSlip_ke 
						  $fposting 
						  $fTipeTrans
						  $fFilterTgl 
					  GROUP BY b.id) AS gab
				WHERE 1 = 1
				ORDER BY ".$sorting;
		
		if($posting == 0){
			$sqlSum = "select ifnull(sum(nilai),0) as totnilai from (".$sql.") sql36";
		} else {
			$sqlSum = "select ifnull(sum(nilaiD),0) as totnilai from (".$sql.") sql36";
		}
		echo "Query detail rekap transaksi per setoran : ".$sqlSum."<br>";
		$rsSum = mysql_query($sqlSum);

		$rwSum = mysql_fetch_array($rsSum);
		if($rwSum == FALSE){
			echo mysql_error();
		}
		$stot = $rwSum["totnilai"];
	// end detail rekap transaksi per setoran
    }else if ($grd == "penerimaanBillingKasirDetail"){
		$sql="SELECT
				  b.user_act,
				  bt.id,
				  bt.nilai,
				  bt.tipe,
				  DATE_FORMAT(t.tgl,'%d-%m-%Y') tgl_tind,
				  mu.id unitId,
				  mu.nama unitName,
  				  ''	      ket,
				  kso.nama kso,
				  mt.nama namaTind,
				  t.qty		jml,
				  mp.nama dokter
				FROM $dbbilling.b_bayar b
				  INNER JOIN $dbbilling.b_bayar_tindakan bt
					ON b.id = bt.bayar_id
				  INNER JOIN $dbbilling.b_ms_kso kso
					ON bt.kso_id = kso.id
				  INNER JOIN $dbbilling.b_tindakan t
					ON bt.tindakan_id = t.id
				  LEFT JOIN $dbbilling.b_ms_pegawai mp
					ON t.user_id = mp.id
				  INNER JOIN $dbbilling.b_pelayanan p
					ON t.pelayanan_id = p.id
				  INNER JOIN $dbbilling.b_ms_unit mu
					ON p.unit_id = mu.id
				  INNER JOIN $dbbilling.b_ms_tindakan_kelas mtk
					ON t.ms_tindakan_kelas_id = mtk.id
				  INNER JOIN $dbbilling.b_ms_tindakan mt
					ON mtk.ms_tindakan_id = mt.id
				WHERE bt.bayar_id = '$bayar_id' AND bt.nilai>0 AND bt.tipe=0
				UNION
				SELECT
				  b.user_act,
				  bt.id,
				  bt.nilai,
				  bt.tipe,
				  DATE_FORMAT(b.tgl,'%d-%m-%Y') tgl_tind,
				  mu.id unitId,
				  mu.nama unitName,
				  ''	      ket,
				  kso.nama kso,
				  'Kamar' namaTind,
				  IF(t.status_out=0,(1), 
				  (1))    jml,
				  '' dokter
				FROM $dbbilling.b_bayar b
				  INNER JOIN $dbbilling.b_bayar_tindakan bt
					ON b.id = bt.bayar_id
				  INNER JOIN $dbbilling.b_ms_kso kso
					ON bt.kso_id = kso.id
				  INNER JOIN $dbbilling.b_tindakan_kamar t
					ON bt.tindakan_id = t.id
				  INNER JOIN $dbbilling.b_pelayanan p
					ON t.pelayanan_id = p.id
				  INNER JOIN $dbbilling.b_ms_unit mu
					ON p.unit_id = mu.id
				WHERE bt.bayar_id = '$bayar_id' AND bt.nilai>0 AND bt.tipe=1
				UNION
				SELECT
				  b.user_act,
				  bt.id,
				  bt.nilai,
				  bt.tipe,
				  DATE_FORMAT(t.TGL,'%d-%m-%Y')    tgl_tind,
				  bmu.id       unitId,
                  bmu.nama     unitName,
				  mu.UNIT_NAME	ket,
				  kso.nama    kso,
				  ao.OBAT_NAMA      namaTind,
				  t.QTY_JUAL	jml,
				  t.DOKTER    dokter
				FROM $dbbilling.b_bayar b
				  INNER JOIN $dbbilling.b_bayar_tindakan bt
					ON b.id = bt.bayar_id
				  INNER JOIN $dbbilling.b_ms_kso kso
					ON bt.kso_id = kso.id
				  INNER JOIN $dbapotek.a_penjualan t
					ON bt.tindakan_id = t.ID
				  INNER JOIN $dbapotek.a_penerimaan ap
					ON t.PENERIMAAN_ID = ap.ID
				  INNER JOIN $dbapotek.a_obat ao
					ON ap.OBAT_ID = ao.OBAT_ID
				  LEFT JOIN $dbapotek.a_unit p
					ON t.RUANGAN = p.UNIT_ID
				  LEFT JOIN $dbbilling.b_ms_unit bmu
					ON p.unit_billing = bmu.id
				  INNER JOIN $dbapotek.a_unit mu
					ON t.UNIT_ID = mu.UNIT_ID
				WHERE bt.bayar_id = '$bayar_id'
					AND bt.nilai > 0
					AND bt.tipe = 2";
		
		$sqlSum = "select ifnull(sum(nilai),0) as totnilai from (".$sql.") sql36";
		$rsSum = mysql_query($sqlSum);
		$rwSum = mysql_fetch_array($rsSum);
		$stot = $rwSum["totnilai"];
	}
	elseif ($grd=="loadkasir"){
		$dt='<option value="0">SEMUA</option>';
		//$sqlKasir="SELECT mp.id,mp.nama FROM (SELECT DISTINCT user_act FROM ".$dbbilling.".b_bayar b WHERE b.tgl='".tglSQL($tanggal)."') AS bb INNER JOIN ".$dbbilling.".b_ms_pegawai mp ON bb.user_act=mp.id ORDER BY mp.nama";
		$sqlKasir="SELECT mp.id,mp.nama FROM (SELECT DISTINCT user_act FROM ".$dbbilling.".b_bayar b WHERE DATE(b.disetor_tgl)='".tglSQL($tanggalSlip)."') AS bb INNER JOIN ".$dbbilling.".b_ms_pegawai mp ON bb.user_act=mp.id ORDER BY mp.nama";
		//echo $sqlKasir."<br>";
		$qTmp = mysql_query($sqlKasir);
		while($wTmp = mysql_fetch_array($qTmp))
		{
			$dt.='<option value="'.$wTmp["id"].'">'.$wTmp["nama"].'</option>';
		}
		echo $dt;
		return;
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

    if ($grd == "penerimaanBillingKasirRkp") {
		$j=0;
		if ($posting==0){
			while ($rows=mysql_fetch_array($rs)) {
				$i++;
				$j++;
				$sisip=$rows["id"]."|".$rows["nilai"]."|".$rows["user_act"]."|".$rows["slip_ke"]."|".$rows["tgl"]."|".$rows["tposting"]."|".$rows["fk_bayar_posting_id"]."|".$rows["no_post"];
				$tchk="<input id='chkKasir_$j' type='checkbox' value='1' />";
				$tslip_ke=$rows["slip_ke"];
				
				$tdisable="";
				//if ($rows["tgl"]<"2015-06-01"){
					//$tdisable="disabled='disabled'";
				//}
				
				//if ($rows["nilai"]<>$rows["nilaiD"]){
				//	$tchk="<input id='chkKasir_$j' type='checkbox' value='0' $tdisable />";
				//	$tno_kw="<span style='color:red;' title='Tgl Kunjung : ".tglSQL($rows["tgl"])."'>".$rows["no_kwitansi"]."</span>";
				//}
				
				$styleSpn="style='color:blue;'";
				//if ($rows["jenis_bayar"]==1) $styleSpn="style='color:#FF00FF;'";
				//$tjbayar="<span $styleSpn title='Klik Untuk Mengubah Jenis Pembayaran' id='spn_".$rows["id"]."' lang='".$rows["jenis_bayar"]."' onclick='fJBayarChange(this);'>".$rows["jbayar"]."</span>";
				
				$dt.=$sisip.chr(3).number_format($i,0,",",".").chr(3).$rows["tgl"].chr(3).$rows["slip_ke"].chr(3).$rows["no_slip_setor"].chr(3).$rows["pegawai_kasir"].chr(3).number_format($rows["nilai"],0,",",".").chr(3).$tchk.chr(6);
			}
		}else{
			while ($rows=mysql_fetch_array($rs)) {
				$i++;
				$j++;
				$sisip=$rows["id"]."|".$rows["nilai"]."|".$rows["user_act"]."|".$rows["slip_ke"]."|".$rows["tgl"]."|".$rows["tposting"]."|".$rows["fk_bayar_posting_id"]."|".$rows["no_post"];
				
				$tchk="<input id='chkKasir_$j' type='checkbox' value='1' />";
				//$tslip_ke=$rows["slip_ke"];
				
				//$tno_kw=$rows["no_kwitansi"];
				//if ($rows["nilai"]<>$rows["nilaiD"]){
				//	$tno_kw="<span style='color:red;'>".$rows["no_kwitansi"]."</span>";
				//}
				
				$styleSpn="style='color:blue;'";
				/*if ($rows["jenis_bayar"]==1) $styleSpn="style='color:#FF00FF;'";
				$tjbayar="<span $styleSpn id='spn_".$rows["id"]."' lang='".$rows["jenis_bayar"]."'>".$rows["jbayar"]."</span>";*/
				
				$dt.=$sisip.chr(3).number_format($i,0,",",".").chr(3).$rows["tgl"].chr(3).$rows["slip_ke"].chr(3).$rows["no_slip_setor"].chr(3).$rows["pegawai_kasir"].chr(3).number_format($rows["nilai"],0,",",".").chr(3).$tchk.chr(6);
			}
		}
    }else if ($grd == "penerimaanBillingKasir") {
		$j=0;
		if ($posting==0){
			while ($rows=mysql_fetch_array($rs)) {
				$i++;
				$j++;
				$sisip=$rows["id"]."|".$rows["nilai"]."|".$rows["user_act"]."|".$rows["tposting"]."|".$rows["no_kwitansi"]."|".$rows["no_rm"]."|".$rows["nilaiD"]."|".$rows["tgl"]."|".$rows["jenis_bayar"];
				$tchk="<input id='chkKasirDet_$j' type='checkbox' value='1' />";
				$tno_kw=$rows["no_kwitansi"];
				
				$tdisable="";
				if ($rows["tgl"]<"2015-06-01"){
					//$tdisable="disabled='disabled'";
				}
				
				if ($rows["nilai"]<>$rows["nilaiD"]){
					$tchk="<input id='chkKasirDet_$j' type='checkbox' value='0' $tdisable />";
					$tno_kw="<span style='color:red;' title='Tgl Kunjung : ".tglSQL($rows["tgl"])."'>".$rows["no_kwitansi"]."</span>";
				}
				
				$styleSpn="style='color:blue;'";
				if ($rows["jenis_bayar"]==1) $styleSpn="style='color:#FF00FF;'";
				$tjbayar="<span $styleSpn title='Klik Untuk Mengubah Jenis Pembayaran' id='spn_".$rows["id"]."' lang='".$rows["jenis_bayar"]."' onclick='fJBayarChange(this);'>".$rows["jbayar"]."</span>";
				
				$dt.=$sisip.chr(3).number_format($i,0,",",".").chr(3).$rows["tglP"].chr(3).$tno_kw.chr(3).$rows["slip_ke"].chr(3).$rows["no_slip"].chr(3).$rows["no_rm"].chr(3).$rows["nama"].chr(3).$tjbayar.chr(3).$rows["petugas"].chr(3).number_format($rows["nilai"],0,",",".").chr(3).$tchk.chr(3).$rows["kasir"].chr(6);
			}
		}else{
			while ($rows=mysql_fetch_array($rs)) {
				$i++;
				$j++;
				$sisip=$rows["id"]."|".$rows["nilai"]."|".$rows["user_act"]."|".$rows["tposting"]."|".$rows["no_kwitansi"]."|".$rows["no_rm"]."|".$rows["nilaiD"]."|".$rows["tgl"]."|".$rows["jenis_bayar"];
				
				$tchk="<input id='chkKasirDet_$j' type='checkbox' value='1' />";
				
				$tno_kw=$rows["no_kwitansi"];
				if ($rows["nilai"]<>$rows["nilaiD"]){
					$tno_kw="<span style='color:red;'>".$rows["no_kwitansi"]."</span>";
				}
				
				$styleSpn="style='color:blue;'";
				if ($rows["jenis_bayar"]==1) $styleSpn="style='color:#FF00FF;'";
				$tjbayar="<span $styleSpn id='spn_".$rows["id"]."' lang='".$rows["jenis_bayar"]."'>".$rows["jbayar"]."</span>";
				
				$dt.=$sisip.chr(3).number_format($i,0,",",".").chr(3).$rows["tglP"].chr(3).$tno_kw.chr(3).$rows["slip_ke"].chr(3).$rows["no_slip"].chr(3).$rows["no_rm"].chr(3).$rows["nama"].chr(3).$tjbayar.chr(3).$rows["petugas"].chr(3).number_format($rows["nilaiD"],0,",",".").chr(3).$tchk.chr(3).$rows["kasir"].chr(6);
			}
		}
    }
    else if ($grd == "penerimaanBillingKasirDetail") {
        while ($rows=mysql_fetch_array($rs)) {
            $i++;
            $dt .= $rows["id"]."|".$rows["tipe"]."|".$rows["nilai"].chr(3).number_format($i,0,",","").chr(3).$rows["tgl_tind"].chr(3).$rows["unitName"].chr(3).$rows["kso"].chr(3).$rows["namaTind"].chr(3).$rows["dokter"].chr(3).$rows["ket"].chr(3).number_format($rows["nilai"],0,",",".").chr(6);
        }
    }

    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5).$_REQUEST['act']."|".$grd."|".number_format($stot,0,",",".")."|".$posting;
        $dt=str_replace('"','\"',$dt);
    }else{
        $dt=$dt.chr(5).$_REQUEST['act']."|".$grd."|".number_format($stot,0,",",".")."|".$posting;
        $dt=str_replace('"','\"',$dt);
	}
    mysql_free_result($rs);
}
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
?>
