<?php
include("../koneksi/konek.php"); 
//====================================================================
//Paging,Sorting dan Filter======

$page=$_REQUEST["page"];
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

$defaultsort=$dbbilling.".b_ms_unit.kode";
$defaultsortObat="TANGGAL";
$statusProses='Fine';
//===============================

$idUser = $_REQUEST["idUser"];
$grd = $_REQUEST["grd"];
$tahun = $_REQUEST["tahun"];
$bulan = $_REQUEST["bulan"];
$tipe = $_REQUEST["tipe"];
$cmbSupplier = $_REQUEST["cmbSupplier"];
$kso = $_REQUEST["kso"];
$tempat = $_REQUEST["tempat"];
$kasir = $_REQUEST["kasir"];
$posting = $_REQUEST["posting"];
$cmbFarmasi = $_REQUEST["cmbFarmasi"];
$noSlip = $_REQUEST["noSlip"];
$bayar = $_REQUEST["bayar"];
$act = $_REQUEST["act"];
$fdata = $_REQUEST["fdata"];
$tanggalAsli=$_REQUEST['tanggal'];
$tanggalan = explode('-',$_REQUEST['tanggal']);
$tanggal = $tanggalan[2].'-'.$tanggalan[1].'-'.$tanggalan[0];
$tglAwal = explode('-',$_REQUEST['tglAwal']);
$tanggalAwal = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
$tanggalAkhir = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];

$actUnverifikasi="";

switch ($act){
	case "verifikasiPenerimaanPenjualanObat":
		$arfdata=explode(chr(6),$fdata);
		/*echo "<script>alert('$arfdata[0],$arfdata[1]');</script>";*/
		if ($posting==0)
		{
			for ($i=0;$i<count($arfdata);$i++)
			{
				$cdata=explode(chr(5),$arfdata[$i]);
				$sql="INSERT INTO k_transaksi(id_trans,tgl,no_bukti,unit_id_billing,kso_id,kasir_id,nilai_sim,nilai,nilai_hpp,verifikasi,posting,user_act,tgl_act,cara_bayar,unit_id,ket) VALUES('39','$cdata[0]','','$cdata[1]','$cdata[2]','$cdata[10]','$cdata[3]','$cdata[4]','$cdata[5]',1,0,'$cdata[7]',NOW(),'$cdata[8]','$cdata[9]','$cdata[6]')";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				if (mysql_errno()<=0)
				{
				}
			}
		}
		else{
			for ($i=0;$i<count($arfdata);$i++)
			{
				$cdata=explode(chr(5),$arfdata[$i]);
				$sql="SELECT * FROM k_transaksi WHERE id_trans='39' AND tgl='$cdata[0]' AND unit_id_billing='$cdata[1]' AND kso_id='$cdata[2]' AND cara_bayar='$cdata[8]' AND unit_id='$cdata[9]' AND nilai_sim='$cdata[3]' AND nilai='$cdata[4]' AND nilai_hpp='$cdata[5]' AND kasir_id='$cdata[10]' AND verifikasi=1";
				//echo $sql;
				$cek=mysql_query($sql);
				$rcek=mysql_fetch_array($cek);
				if($rcek['posting']=='0'){
					mysql_query("delete from k_transaksi where id=".$rcek['id']);
					$actUnverifikasi='sukses';
				}
				else{
					$actUnverifikasi='gagal';
				}
				if (mysql_errno()<=0)
				{
				}
			}
		}
		break;
	case "verifikasiPenerimaanBillingKasir":
		//$noSlip=$_REQUEST["noSlip"];
		$arfdata=explode(chr(6),$fdata);
		/*echo "<script>alert('$arfdata[0],$arfdata[1]');</script>";*/
		if ($posting==0)
		{
			for ($i=0;$i<count($arfdata);$i++)
			{
				$cdata=explode(chr(5),$arfdata[$i]);
				$kso=$cdata[2];
				$sql="INSERT INTO k_transaksi(id_trans,tgl,no_bukti,unit_id_billing,kso_id,kasir_id,nilai_sim,nilai,verifikasi,posting,user_act,tgl_act) VALUES('38','$cdata[4]','$cdata[5]','$cdata[1]',$kso,'$cdata[0]','$cdata[3]','$cdata[6]',1,0,'$cdata[7]',NOW())";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				if (mysql_errno()<=0)
				{
					/*//======insert into jurnal========
					$sql="SELECT rv.* FROM ".$dbbilling.".b_ms_unit mu INNER JOIN ".$dbakuntansi.".ak_ms_unit rv ON mu.kode_ak=rv.kode WHERE mu.id=$cdata[1]";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$idunit=$rwPost["id"];
					$unit=$rwPost["nama"];
					$kdunit=$rwPost["kode"];
					$sql="SELECT * FROM ".$dbbilling.".b_ms_pegawai WHERE id=$cdata[0]";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$ckasir=$rwPost["nama"];
					$sql="SELECT * FROM ".$dbbilling.".b_ms_kso WHERE id=$kso";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$ksoNama=$rwPost["nama"];
					$uraian="Penerimaan Kasir : ".$ckasir.", ".$unit." ".$tanggalAsli." - ".$ksoNama;
					$kdkso=$rwPost["kode_ak"];
					$nokw="$kdunit/$kdkso : $noSlip";
										
					if ($kso==1)
					{
						$id_sak=8;	//Kas di Bendahara Penerimaan
						$id_piutang=44;	//Piutang Px Umum
						$jenistrans=7;	//Saat Px Umum Bayar
					}
					else
					{
						$id_sak=8;	//Kas di Bendahara Penerimaan
						$id_piutang=45;	//Piutang KSO beban Px
						$jenistrans=14;	//Saat Px KSO Bayar
					}

					$sql="SELECT IFNULL(MAX(NO_TRANS)+1,1) AS notrans FROM ".$dbakuntansi.".jurnal";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					$rwPost=mysql_fetch_array($rsPost);
					$notrans=$rwPost["notrans"];

					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) 
		VALUES($notrans,$id_sak,'$tanggal','$nokw','$uraian',$cdata[3],0,now(),$idUser,'D',0,$jenistrans,$jenistrans,1,'',0,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);

					$sql="INSERT INTO ".$dbakuntansi.".jurnal(NO_TRANS,FK_SAK,TGL,NO_KW,URAIAN,DEBIT,KREDIT,TGL_ACT,FK_IDUSER,D_K,JENIS,FK_TRANS,FK_LAST_TRANS,STATUS,NO_BUKTI,CC_RV_KSO_PBF_UMUM_ID,POSTING) 
	VALUES($notrans,$id_piutang,'$tanggal','$nokw','$uraian',0,$cdata[3],now(),$idUser,'K',0,$jenistrans,$jenistrans,1,'',$kso,1)";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);*/
				}
				else
				{
					$statusProses='Error';
				}
			}
		}
		else
		{
		}
		break;
}

	if($tempat==0)
	{
		$fUnit = "";
	}
	else
	{
		$fUnit = "AND ".$dbbilling.".b_ms_unit.parent_id = '".$tempat."'";
	}

	if($statusProses=='Error') 
	{
    $dt="0".chr(5).chr(4).chr(5).$_REQUEST['act'];
	}
	else 
	{
		switch ($grd)
		{
		case "penerimaanPenjualanObat":
			if($_REQUEST['kso']!=0){
				$fkso=" AND ap.KSO_ID='".$_REQUEST['kso']."'";
				$fkso2=" AND m.IDMITRA='".$_REQUEST['kso']."'";
			}
			
			if($cmbFarmasi!=0){
				$fFarmasi=" AND ap.UNIT_ID = '$cmbFarmasi'";
				$fFarmasi2=" AND k.unit_id = '$cmbFarmasi'";
			}
			
			if($_REQUEST['shift']!=0){
				$fShift=" AND ap.SHIFT='".$_REQUEST['shift']."'";
				$fShift2=" AND k.kasir_id='".$_REQUEST['shift']."'";
			}
			
			if ($filter!="") 
			{
				$filter=explode("|",$filter);
				$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
			}
			
			
		if($posting==0){
			
			if ($sorting=="") 
			{
				$sorting="KSO_ID,CARABAYAR_ID,nama,SHIFT";
			}
			
			$sql = "SELECT 
					  * 
					FROM
					  (SELECT 
						gab3.*
					  FROM
						(SELECT 
						  gab2.*,
						  gab1.KSO_NAMA,
						  gab1.nama,
						  gab1.kso_id_billing,
						  gab1.kode_ak 
						FROM
						  (SELECT 
							am.IDMITRA,
							am.kso_id_billing,
							am.NAMA KSO_NAMA,
							mu.id,
							mu.nama,
							mu.kode_ak 
						  FROM
							$dbapotek.a_mitra am,
							(SELECT 
							  id,
							  nama,
							  IFNULL(kode_ak, '') kode_ak 
							FROM
							  $dbbilling.b_ms_unit mu 
							WHERE mu.kategori = 2 
							  AND mu.level = 2 
							UNION
							SELECT 
							  126,
							  'Instalasi Farmasi',
							  '0502') mu) AS gab1,
						  (SELECT 
						    t1.UNIT_ID AS unit_farmasi,
							t1.KSO_ID,
							t1.CARABAYAR_ID,
							t1.SHIFT,
							t1.cara_bayar,
							IFNULL(t1.unit_billing, 126) unit_billing,
							SUM(t1.tot_jual) AS nJual,
							SUM(nBahan) nBahan 
						  FROM
							(SELECT 
							  ap.UNIT_ID,
							  TGL,
							  TGL_ACT,
							  NO_PENJUALAN,
							  SHIFT,
							  ap.KSO_ID,
							  am.NAMA,
							  ak.ID AS KPID,
							  ak.NAMA AS KPNAMA,
							  ac.id AS CARABAYAR_ID,
							  ac.nama AS cara_bayar,
							  u.unit_billing,
							  FLOOR(HARGA_TOTAL) tot_jual,
							  (
								ap.QTY_JUAL * IF(
								  (
									(p.`TIPE_TRANS` = 4) 
									OR (p.`TIPE_TRANS` = 5) 
									OR (p.`TIPE_TRANS` = 100) 
									OR (p.`NILAI_PAJAK` <= 0)
								  ),
								  (
									p.HARGA_BELI_SATUAN * (1- (p.DISKON / 100))
								  ),
								  1.1 * (
									p.HARGA_BELI_SATUAN * (1- (p.DISKON / 100))
								  )
								)
							  ) nBahan 
							FROM
							  $dbapotek.a_penjualan ap 
							  INNER JOIN $dbapotek.a_mitra am 
								ON ap.KSO_ID = am.IDMITRA 
							  INNER JOIN $dbapotek.a_penerimaan p 
								ON ap.PENERIMAAN_ID = p.ID 
							  INNER JOIN $dbapotek.a_cara_bayar ac 
								ON ap.CARA_BAYAR = ac.id 
							  INNER JOIN $dbapotek.a_kepemilikan ak 
								ON ap.JENIS_PASIEN_ID = ak.ID 
							  LEFT JOIN $dbapotek.a_unit u 
								ON ap.RUANGAN = u.UNIT_ID 
							WHERE ap.TGL = '".$tanggal."'
							  $fFarmasi
							  $fkso
							  $fShift
							GROUP BY SHIFT,
							  NO_PENJUALAN,
							  TGL,
							  ap.KSO_ID,
							  ap.UNIT_ID,
							  ap.JENIS_PASIEN_ID,
							  ap.CARA_BAYAR,
							  ap.NO_PASIEN,
							  u.unit_billing 
							ORDER BY TGL_ACT DESC) AS t1 
						  GROUP BY
							t1.KSO_ID,
							t1.cara_bayar,
							t1.unit_billing,
							t1.SHIFT) AS gab2 
						WHERE gab1.IDMITRA = gab2.KSO_ID 
						  AND gab1.id = gab2.unit_billing) gab3 
						LEFT JOIN 
						  (SELECT 
							* 
						  FROM
							k_transaksi 
						  WHERE id_trans = 39 
							AND tgl = '".$tanggal."') k 
						  ON (
							k.unit_id_billing = gab3.unit_billing 
							AND k.kso_id = gab3.KSO_ID
							AND k.unit_id = gab3.unit_farmasi
							AND k.cara_bayar = gab3.CARABAYAR_ID
							AND k.kasir_id = gab3.SHIFT
						  ) 
					  WHERE k.id IS NULL) gab WHERE 0=0 $filter ORDER BY $sorting";
			}
			else{
			
			if ($sorting=="") 
			{
				$sorting="KSO_ID,nama";
			}
			
				$sql = "SELECT 
						  * 
						FROM
						  (SELECT 
							m.IDMITRA AS KSO_ID,
							cb.id AS CARABAYAR_ID,
							cb.nama AS cara_bayar,
							k.unit_id_billing AS unit_billing,
							m.NAMA AS KSO_NAMA,
							u.nama,
							k.nilai_sim AS nJual,
							k.nilai AS nSlip,
							k.nilai_hpp AS nBahan,
							k.unit_id AS unit_farmasi,
							k.kasir_id AS SHIFT
						  FROM
							k_transaksi k 
							INNER JOIN $dbapotek.a_mitra m 
							  ON m.IDMITRA = k.kso_id 
							INNER JOIN $dbbilling.b_ms_unit u 
							  ON u.id = k.unit_id_billing 
							INNER JOIN $dbapotek.a_cara_bayar cb 
							  ON cb.id = k.cara_bayar 
						  WHERE k.id_trans = 39 
							AND k.tgl = '".$tanggal."' $fkso2 $fFarmasi2 $fShift2) as tbl WHERE 0=0 $filter ORDER BY $sorting";				
			}
			break;
		case "loadkasir":
			$dt='<option value="0">SEMUA</option>';
			$qTmp = mysql_query("SELECT mp.id,mp.nama FROM (SELECT DISTINCT user_act FROM ".$dbbilling.".b_bayar b WHERE b.tgl='$tanggal') AS bb INNER JOIN ".$dbbilling.".b_ms_pegawai mp ON bb.user_act=mp.id ORDER BY mp.nama");
            while($wTmp = mysql_fetch_array($qTmp))
			{
				$dt.='<option value="'.$wTmp["id"].'">'.$wTmp["nama"].'</option>';
			}
			echo $dt;
			return;
			break;
		case "penerimaanBillingKasir":			
			if ($filter!="") 
			{
				$filter=explode("|",$filter);
				$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
			}
			
			if ($sorting=="") 
			{
				$sorting="nama,unit";
			}
			
			if ($posting==0)
			{
				if ($kasir=="0")
				{
					$fkasir="";
				}
				else
				{
					$fkasir=" AND b.user_act=".$kasir;
				}
				if ($kasir=="0")
				{
					$fkasir2="";
				}
				else
				{
					$fkasir2=" AND kasir_id=".$kasir;
				}
				$sql="SELECT t2.* FROM (SELECT t1.*,mu.nama unit,kso.nama kso,mp.nama FROM
				(SELECT gab.unit_id,gab.kso_id,gab.tgl,gab.user_act,SUM(nilai) nilai FROM 
				(SELECT bbt.*,p.unit_id FROM (SELECT bt.*,b.tgl,b.user_act FROM ".$dbbilling.".b_bayar b INNER JOIN ".$dbbilling.".b_bayar_tindakan bt ON b.id=bt.bayar_id 
				WHERE b.tgl='$tanggal'".$fkasir." AND bt.nilai>0 AND bt.tipe=0) AS bbt 
				INNER JOIN ".$dbbilling.".b_tindakan t ON bbt.tindakan_id=t.id INNER JOIN ".$dbbilling.".b_pelayanan p ON t.pelayanan_id=p.id
				UNION
				SELECT bbt.*,p.unit_id FROM (SELECT bt.*,b.tgl,b.user_act FROM ".$dbbilling.".b_bayar b INNER JOIN ".$dbbilling.".b_bayar_tindakan bt ON b.id=bt.bayar_id 
				WHERE b.tgl='$tanggal'".$fkasir." AND bt.nilai>0 AND bt.tipe=1) AS bbt 
				INNER JOIN ".$dbbilling.".b_tindakan_kamar t ON bbt.tindakan_id=t.id INNER JOIN ".$dbbilling.".b_pelayanan p ON t.pelayanan_id=p.id) AS gab 
				GROUP BY gab.kso_id,gab.unit_id,gab.user_act) AS t1 INNER JOIN ".$dbbilling.".b_ms_unit mu ON t1.unit_id=mu.id
				INNER JOIN ".$dbbilling.".b_ms_kso kso ON t1.kso_id=kso.id INNER JOIN ".$dbbilling.".b_ms_pegawai mp ON t1.user_act=mp.id) as t2 
				LEFT JOIN 
					(SELECT 
					  id,
					  unit_id_billing,
					  kso_id,
					  kasir_id 
					FROM
					  k_transaksi 
					WHERE tgl = '$tanggal' 
					  $fkasir2 
					  AND id_trans = 38) AS tt 
					ON (tt.unit_id_billing = t2.unit_id AND tt.kasir_id=t2.user_act AND tt.kso_id = t2.kso_id) 
				WHERE tt.id IS NULL
				".$filter." ORDER BY ".$sorting;
				/*if ($kasir=="0")
				{
					$fkasir="";
				}
				else
				{
					$fkasir=" AND b.user_act=".$kasir;
					$fkasir2=" AND kasir_id=".$kasir;
				}
			$sql="SELECT 
					  t2.* 
					FROM
					  (SELECT 
						t1.*,
						mu.nama unit,
						kso.nama kso,
						mp.nama 
					  FROM
						(SELECT 
						  gab.unit_id,
						  gab.kso_id,
						  gab.user_act,
						  SUM(nilai) nilai 
						FROM
						  (SELECT 
							bbt.*,
							t.kso_id,
							p.unit_id 
						  FROM
							(SELECT 
							  bt.*,
							  b.user_act 
							FROM
							  $dbbilling.b_bayar b 
							  INNER JOIN $dbbilling.b_bayar_tindakan bt 
								ON b.id = bt.bayar_id 
							WHERE b.tgl = '$tanggal' 
							  AND bt.nilai > 0 
							  AND bt.tipe = 0 $fkasir) AS bbt 
							INNER JOIN $dbbilling.b_tindakan t 
							  ON bbt.tindakan_id = t.id 
							INNER JOIN $dbbilling.b_pelayanan p 
							  ON t.pelayanan_id = p.id 
						  UNION
						  SELECT 
							bbt.*,
							t.kso_id,
							p.unit_id 
						  FROM
							(SELECT 
							  bt.*,
							  b.user_act 
							FROM
							  $dbbilling.b_bayar b 
							  INNER JOIN $dbbilling.b_bayar_tindakan bt 
								ON b.id = bt.bayar_id 
							WHERE b.tgl = '$tanggal' 
							  AND bt.nilai > 0 
							  AND bt.tipe = 1 $fkasir) AS bbt 
							INNER JOIN $dbbilling.b_tindakan_kamar t 
							  ON bbt.tindakan_id = t.id 
							INNER JOIN $dbbilling.b_pelayanan p 
							  ON t.pelayanan_id = p.id) AS gab 
						GROUP BY gab.kso_id,
						  gab.unit_id,
						  gab.user_act) AS t1 
						INNER JOIN $dbbilling.b_ms_unit mu 
						  ON t1.unit_id = mu.id 
						INNER JOIN $dbbilling.b_ms_kso kso 
						  ON t1.kso_id = kso.id 
						INNER JOIN $dbbilling.b_ms_pegawai mp 
						  ON t1.user_act = mp.id) AS t2 
					  LEFT JOIN 
						(SELECT 
						  id,
						  unit_id_billing,
						  kso_id,
						  kasir_id 
						FROM
						  k_transaksi 
						WHERE id_trans = '38' 
						  AND tgl = '$tanggal' $fkasir2) AS t3 
						ON t3.unit_id_billing = t2.unit_id 
						AND t3.kso_id = t2.kso_id 
						AND t3.kasir_id = t2.user_act 
					WHERE t3.id IS NULL $filter
					ORDER BY t2.nama,
					  t2.unit ";*/
			}
			else //jika posting==1
			{
				if ($kasir=="0")
				{
					$fkasir="";
				}
				else
				{
					$fkasir=" AND t2.user_act='".$kasir."'";
				}
			$sql = "SELECT * FROM (
					SELECT 
					  k.unit_id_billing AS unit_id,
					  k.kso_id,
					  k.kasir_id AS user_act,
					  k.nilai_sim,
					  k.nilai AS nilai_slip,
					  k.tgl,
      				  k.id_trans,
					  u.nama AS unit,
					  kso.nama AS kso,
					  pg.nama 
					FROM
					  keuangan.k_transaksi k 
					  INNER JOIN $dbbilling.b_ms_unit u 
						ON k.unit_id_billing = u.id 
					  INNER JOIN $dbbilling.b_ms_kso kso 
						ON kso.id = k.kso_id 
					  INNER JOIN $dbbilling.b_ms_pegawai pg 
						ON pg.id = k.kasir_id 
					 ) as t2 WHERE t2.tgl = '$tanggal'  AND t2.id_trans = '38' $fkasir $filter";
				
			}
			break;
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

    switch($grd)
	{
	case "penerimaanPenjualanObat":
	if($posting==0){
		$sqlTot="SELECT IFNULL(SUM(tot.nJual),0) totJual,IFNULL(SUM(tot.nBahan),0) totBahan FROM (".$sql.") AS tot";
		$rsTot=mysql_query($sqlTot);
		$rwTot=mysql_fetch_array($rsTot);
		$ntot=$rwTot["totJual"];
		$ntot1=$rwTot["totJual"];
		$ntot2=$rwTot["totBahan"];
		while ($rows=mysql_fetch_array($rs)) 
		{
			$i++;
			$nilai=$rows["nJual"];
			$dt.=$rows["unit_billing"]."|".$rows["KSO_ID"]."|".$rows["nJual"]."|".$rows["nBahan"]."|".$rows["CARABAYAR_ID"]."|".$rows["unit_farmasi"]."|".$rows["nSlip"]."|".$rows["SHIFT"].chr(3).$i.chr(3).$rows["KSO_NAMA"].chr(3).$rows["cara_bayar"].chr(3).$rows["nama"].chr(3).$rows["SHIFT"].chr(3).number_format($nilai,0,",",".").chr(3)."<input type='text' id='nilai_$i' class='txtinput' value='".number_format($nilai,0,",",".")."' style='width:98px; font:11px tahoma; padding:2px; text-align:right' onkeyup='zxc(this);setSubTotal()'>".chr(3).number_format($rows["nBahan"],0,",",".").chr(3)."0".chr(6);
		}
	}
	else{
		$sqlTot="SELECT IFNULL(SUM(tot.nJual),0) tot1,IFNULL(SUM(tot.nSlip),0) tot2,IFNULL(SUM(tot.nBahan),0) tot3 FROM (".$sql.") AS tot";
		$rsTot=mysql_query($sqlTot);
		$rwTot=mysql_fetch_array($rsTot);
		$ntot=$rwTot["tot1"];
		$ntot1=$rwTot["tot2"];
		$ntot2=$rwTot["tot3"];
		while ($rows=mysql_fetch_array($rs)) 
		{
			$i++;
			$dt.=$rows["unit_billing"]."|".$rows["KSO_ID"]."|".$rows["nJual"]."|".$rows["nBahan"]."|".$rows["CARABAYAR_ID"]."|".$rows["unit_farmasi"]."|".$rows["nSlip"]."|".$rows["SHIFT"].chr(3).$i.chr(3).$rows["KSO_NAMA"].chr(3).$rows["cara_bayar"].chr(3).$rows["nama"].chr(3).$rows["SHIFT"].chr(3).number_format($rows["nJual"],0,",",".").chr(3).number_format($rows["nSlip"],0,",",".").chr(3).number_format($rows["nBahan"],0,",",".").chr(3)."0".chr(6);
		}
	}
	break;
	case "penerimaanBillingKasir":
	$ntot=0;
	while ($rows=mysql_fetch_array($rs)) 
	{
		if ($posting==0)
		{
			$i++;
			$nilai=$rows["nilai"];
			$ntot+=$nilai;
			$dt.=$rows["user_act"]."|".$rows["unit_id"]."|".$rows["kso_id"]."|".$rows["nilai"].chr(3).$i.chr(3).$rows["unit"].chr(3).$rows["kso"].chr(3).$rows["nama"].chr(3).number_format($nilai,0,",",".").chr(3)."<input type='text' id='nilai_$i' class='txtinput' value='".number_format($nilai,0,",",".")."' style='width:98px; font:11px tahoma; padding:2px; text-align:right' onkeyup='zxc(this);setSubTotal()'>".chr(3)."0".chr(6);
		}
		else
		{
		$i++;
			$nilai=$rows["nilai_slip"];
			$ntot+=$nilai;
			$dt.=$rows["user_act"]."|".$rows["unit_id"]."|".$rows["kso_id"]."|".$rows["nilai_slip"]."|".$rows["nilai_sim"].chr(3).$i.chr(3).$rows["unit"].chr(3).$rows["kso"].chr(3).$rows["nama"].chr(3).number_format($rows["nilai_sim"],0,",",".").chr(3).number_format($nilai,0,",",".").chr(3)."<img src='../icon/ok.png' width='20px' height='20px;'>".chr(6);

		}
	}
	break;
    }
	
	
	if ($dt!=$totpage.chr(5)) {
		$dt=substr($dt,0,strlen($dt)-1).chr(5).$_REQUEST['act'];
        $dt=str_replace('"','\"',$dt);
    }else{
		$dt="0".chr(5).chr(5).$_REQUEST['act'];
	}
	
	if($grd=="penerimaanPenjualanObat"){
		$dt=$dt.chr(3).number_format($ntot,0,",",".").chr(3).number_format($ntot1,0,",",".").chr(3).number_format($ntot2,0,",",".").chr(3).$actUnverifikasi;
	}

    mysql_free_result($rs);
}
mysql_close($konek);

header("Cache-Control: no-cache, must-revalidate" );
header("Pragma: no-cache" );
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) 
{
 	header("Content-type: application/xhtml+xml");
}
else
{
 	header("Content-type: text/xml");
}

//if($ntot!=0)
//{
echo $dt;
//}

?>