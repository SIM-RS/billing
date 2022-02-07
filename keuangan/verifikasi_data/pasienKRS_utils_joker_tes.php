<?php
include("../koneksi/konek.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
//$defaultsort="t1.id";
$defaultsort="tgl,id";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$IdTrans=36;
$Idma_sak_d_umum=44;//===113010101 - Piutang Pasien Umum
$Idma_sak_d_kso_px=45;//===113010102 - Piutang Pasien Kerjasama dengan pihak ke III beban pasien
$Idma_sak_d_kso_kso=46;//===113010103 - Piutang Pasien Kerjasama dengan pihak ke III beban pihak ke III
$Idma_sak_d=$Idma_sak_d_kso_kso;
$Idma_sak_k_umum=488;//===41101 - Pendapatan Jasa Layanan Pasien Umum
$Idma_sak_k_kso=490;//===41103 - Pendapatan Jasa Layanan Pasien Kerja Sama dengan KSO
$Idma_sak_k_pemda=493;//===41106 - Pendapatan Jasa Layanan Pasien Subsidi Pemerintah
$Idma_sak_selisih_tarip_d_k=491;//===41104 - Selisih Tarif Jasa Layanan Pasien Kerja Sama dengan KSO
$Idma_sak_k=$Idma_sak_k_kso;

$Idma_sak=$Idma_sak_k_kso;
$Idma_dpa=6;
//===============================
$posting=$_REQUEST['posting'];
$kasir=$_REQUEST['kasir'];
$no_slip=$_REQUEST['no_slip'];
$slipke=$_REQUEST['slipke'];
$userId=$_REQUEST['userId'];
$kunj_id = $_REQUEST['kunjungan_id'];
$kso = $_REQUEST['kso'];
$grid = $_REQUEST['grid'];
$tgl = tglSQL($_REQUEST['txtTgl']);
$tgl2 = tglSQL($_REQUEST['txtTgl2']);
$tglslip = tglSQL($_REQUEST['tglslip']);
//===============================
$statusProses='';
$alasan='';
switch(strtolower($_REQUEST['act'])) {
    case 'verifikasi':
		$fdata=$_REQUEST["fdata"];
		$arfdata=explode(chr(5),$fdata);
		
		if ($posting==0)
		{
			for ($i=0;$i<count($arfdata);$i++)
			{
				$cdata=explode("|",$arfdata[$i]);
				$idKunj=$cdata[0];
				$tglK=tglSQL($cdata[2]);
				$tglP=tglSQL($cdata[2]);
				$biayaRS=$cdata[3];
				$biayaPasien=$cdata[4];
				$biayaKSO=$cdata[5];
				$bayarPasien=$cdata[6];
				$piutangPasien=$cdata[7];
				$idpeg=$cdata[8];
				$slip=$cdata[9];
				$ckso_id=$cdata[10];
				$tglS=tglSQL($cdata[2]);
				$cfkso=" AND k.kso_id = '$ckso_id'";
				
				//$sql2="select id from $dbbilling.b_kunjungan where date(disetor_tgl)='$tglK' and disetor_oleh='$idpeg' and slip_ke='$slip'";
				$sql2="select DISTINCT id from $dbbilling.b_kunjungan where tgl_pulang_ak='$tglK' and user_act_pulang='$idpeg' AND kso_id='$ckso_id' AND verif_pendapatan = 0";
				echo $sql2.";<br>";
				$rsidK=mysql_query($sql2);
				while($rwidK=mysql_fetch_array($rsidK)){
					$idK=$rwidK["id"];
					
					//========Update b_kunjungan=========
					$sqlVer="UPDATE $dbbilling.b_kunjungan
							SET $dbbilling.b_kunjungan.verif_pendapatan = 1
							WHERE $dbbilling.b_kunjungan.id = '$idK'";
					echo $sqlVer.";<br>";
					$rsVer=mysql_query($sqlVer);
					//========Update b_tindakan=========
					$sqlVer="UPDATE $dbbilling.b_tindakan
							  INNER JOIN $dbbilling.b_pelayanan
								ON $dbbilling.b_tindakan.pelayanan_id = $dbbilling.b_pelayanan.id
							SET $dbbilling.b_tindakan.posting = 1
							WHERE $dbbilling.b_pelayanan.kunjungan_id = '$idK' 
								/*AND $dbbilling.b_pelayanan.kso_id='$ckso_id'*/";
					echo $sqlVer.";<br>";
					$rsVer=mysql_query($sqlVer);
					//========Update b_tindakan_kamar=========
					$sqlVer="UPDATE $dbbilling.b_tindakan_kamar
							  INNER JOIN $dbbilling.b_pelayanan
								ON $dbbilling.b_tindakan_kamar.pelayanan_id = $dbbilling.b_pelayanan.id
							SET $dbbilling.b_tindakan_kamar.posting = 1
							WHERE $dbbilling.b_pelayanan.kunjungan_id = '$idK'
								/*AND $dbbilling.b_pelayanan.kso_id='$ckso_id'*/";
					echo $sqlVer.";<br>";
					$rsVer=mysql_query($sqlVer);
					//========Update transaksi Obat=========
					$sqlVer="UPDATE $dbapotek.a_penjualan
							  INNER JOIN $dbbilling.b_pelayanan
								ON $dbapotek.a_penjualan.NO_KUNJUNGAN = $dbbilling.b_pelayanan.id
							SET $dbapotek.a_penjualan.VERIFIKASI = 1
							WHERE $dbbilling.b_pelayanan.kunjungan_id = '$idK'
								/*AND $dbbilling.b_pelayanan.kso_id='$ckso_id'*/";
					echo $sqlVer.";<br>";
					$rsVer=mysql_query($sqlVer);
					
					//================================================ DATA DETAIL
				
					$sqlPer="SELECT id,pasien_id,tgl,
						  DATE_FORMAT(tgl_pulang,'%Y-%m-%d') AS tgl_p,
						  no_rm,nama AS pasien,
						  unit,kso_id,
						  nmkso,
						  SUM(biaya) biayaRS,
						  SUM(biaya_kso) biayaKSO,
						  SUM(biaya_pasien) biayaPasien,
						  SUM(retribusi) retribusi,
						  SUM(bayar) bayar,
						  SUM(bayar_kso) bayarKso,
						  SUM(bayar_pasien) bayarPasien,
						  DATE_FORMAT(dt,'%Y-%m-%d') AS disetor_tgl,
						  slip_ke,
						  namapeg,
						  idpeg
						FROM
						(SELECT ttind.* FROM
						(SELECT
						  k.id,
						  k.tgl,
						  k.pasien_id,
						  k.disetor_tgl,
						  k.tgl_pulang,
						  mp.no_rm,
						  mp.nama,
						  mu.nama AS unit,
						  t.id idTind,
						  kso.id kso_id,
						  kso.nama AS nmkso,
						  0 AS tipe,
						  t.qty*t.biaya biaya,
						  t.qty*t.biaya_kso biaya_kso,
						  t.qty*t.biaya_pasien biaya_pasien,
						  0 retribusi,
						  t.bayar,
						  t.bayar_kso,
						  /*t.bayar_pasien*/
						  IFNULL(SUM(IF(bt.jenis_bayar=0,bt.nilai,0)),0) AS bayar_pasien,
						  k.disetor_tgl dt,
						  g.nama namapeg,
						  k.slip_ke,
						  g.id idpeg
						FROM $dbbilling.b_kunjungan k
						  INNER JOIN $dbbilling.b_ms_pasien mp
							ON k.pasien_id = mp.id
						  INNER JOIN $dbbilling.b_ms_unit mu
							ON k.unit_id = mu.id
						  INNER JOIN $dbbilling.b_pelayanan p
							ON k.id = p.kunjungan_id
						  INNER JOIN $dbbilling.b_tindakan t
							ON p.id = t.pelayanan_id
						  INNER JOIN $dbbilling.b_ms_kso kso
							ON k.kso_id = kso.id
						  LEFT JOIN $dbbilling.b_bayar_tindakan bt 
							ON (t.id = bt.tindakan_id AND bt.tipe=0)
						  INNER JOIN $dbbilling.b_ms_pegawai g ON g.id=k.user_act_pulang
						WHERE k.pulang = 1 
						 /*AND k.kso_id<>1*/ $cfkso
							AND k.tgl_pulang_ak='$tglS'
							AND t.posting='1' AND k.id='$idK' and k.user_act_pulang='$idpeg'
						GROUP BY t.id) AS ttind
						WHERE ((ttind.biaya_kso>0) OR (ttind.biaya_pasien>ttind.bayar_pasien))
						UNION
						SELECT tk.* FROM 
							(SELECT
							  k.id,
							  k.tgl,
							  k.pasien_id,
							  k.disetor_tgl,
							  k.tgl_pulang,
							  mp.no_rm,
							  mp.nama,
							  mu.nama        AS unit_awal,
							  t.id idTind,
							  kso.id		 AS kso_id,
							  kso.nama       AS nmkso,
							  1 AS tipe,
							  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.tarip, (IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.tarip)    biaya,
							  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.beban_kso, (IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.beban_kso)    biaya_kso,
							  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.beban_pasien, (IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.beban_pasien)    biaya_pasien,
							  
		IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.retribusi, (IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.retribusi)    retribusi,
							  t.bayar,  
							  t.bayar_kso,
							  /*t.bayar_pasien*/
							  IFNULL(SUM(IF(bt.jenis_bayar=0,bt.nilai,0)),0) AS bayar_pasien,
							  k.disetor_tgl dt,
							  g.nama namapeg,
							  k.slip_ke,
							  g.id idpeg
							FROM $dbbilling.b_kunjungan k
							  INNER JOIN $dbbilling.b_ms_pasien mp
								ON k.pasien_id = mp.id
							  INNER JOIN $dbbilling.b_ms_unit mu
								ON k.unit_id = mu.id
							  INNER JOIN $dbbilling.b_pelayanan p
								ON k.id = p.kunjungan_id
							  INNER JOIN $dbbilling.b_tindakan_kamar t
								ON p.id = t.pelayanan_id
							  INNER JOIN $dbbilling.b_ms_kso kso
								ON k.kso_id = kso.id
							  LEFT JOIN $dbbilling.b_bayar_tindakan bt 
								ON (t.id = bt.tindakan_id AND bt.tipe=1)
							  INNER JOIN $dbbilling.b_ms_pegawai g ON g.id=k.user_act_pulang
							WHERE k.pulang = 1 /*AND k.kso_id<>1*/ $cfkso AND t.posting='1'
								AND t.aktif = 1 AND k.tgl_pulang_ak='$tglS' AND k.id='$idK' and k.user_act_pulang='$idpeg'
							GROUP BY t.id) AS tk 
						WHERE (tk.biaya_kso>0 OR tk.biaya_pasien>tk.bayar_pasien)
						UNION
						SELECT
						  k.id,
						  k.tgl,
						  k.pasien_id,
						  k.disetor_tgl,
						  k.tgl_pulang,
						  mp.no_rm,
						  mp.nama,
						  mu.nama AS unit_awal,
						  t.id idTind,
						  kso.id AS kso_id,
		
		
						  kso.nama AS nmkso,
						  2 AS tipe,
						SUM(
							  (t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_SATUAN)+
							  FLOOR((t.PPN/100) *  SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_SATUAN)
							  ) biaya,
							  
							  SUM(
							  (t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_KSO)+
							  FLOOR((t.PPN/100) *  SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_KSO)
							  ) biaya_kso,
							  
							  SUM(
							  (t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_PX)+
							  FLOOR((t.PPN/100) *  SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_PX)
							  ) biaya_pasien,
						  0 retribusi,
						  (SELECT IFNULL(SUM(TOTAL_HARGA),0) FROM $dbapotek.a_kredit_utang 
						  WHERE NORM=mp.no_rm AND FK_NO_PENJUALAN=t.NO_PENJUALAN 
						  AND UNIT_ID=t.UNIT_ID AND DATE(TGL_BAYAR)<=k.tgl_pulang_ak) AS bayar,  
						  0 AS bayarKso,
						  (SELECT IFNULL(SUM(TOTAL_HARGA),0) FROM $dbapotek.a_kredit_utang 
						  WHERE NORM=mp.no_rm AND FK_NO_PENJUALAN=t.NO_PENJUALAN 
						  AND UNIT_ID=t.UNIT_ID AND DATE(TGL_BAYAR)<=k.tgl_pulang_ak) AS bayar_pasien,
						   k.disetor_tgl dt,
						  g.nama namapeg,
						  k.slip_ke,
						  g.id idpeg
						FROM $dbbilling.b_kunjungan k
						  INNER JOIN $dbbilling.b_ms_pasien mp
							ON k.pasien_id = mp.id
						  INNER JOIN $dbbilling.b_ms_unit mu
							ON k.unit_id = mu.id
						  INNER JOIN $dbbilling.b_pelayanan p
							ON k.id = p.kunjungan_id
						  INNER JOIN $dbapotek.a_penjualan t
							ON p.id = t.NO_KUNJUNGAN
						  /*INNER JOIN $dbapotek.a_mitra m
							ON t.KSO_ID = m.IDMITRA
						  INNER JOIN $dbbilling.b_ms_kso kso
							ON m.kso_id_billing = kso.id*/
						  INNER JOIN $dbbilling.b_ms_kso kso
							ON k.kso_id = kso.id
						  INNER JOIN $dbbilling.b_ms_pegawai g ON g.id=k.user_act_pulang
						WHERE k.pulang = 1 /*AND k.kso_id<>1*/ $cfkso AND k.tgl_pulang_ak='$tglS' AND k.id='$idK' and k.user_act_pulang='$idpeg'
							AND t.KRONIS=0 AND ((t.DIJAMIN=1) OR (t.UTANG>0) OR (t.UTANG=0 AND t.TGL_BAYAR>k.tgl_pulang_ak)) AND t.VERIFIKASI = 1
						GROUP BY k.id,kso.id,t.UNIT_ID,t.NO_KUNJUNGAN,t.NO_PENJUALAN) AS gab
						/* WHERE 1=1 AND ((SUM(biaya_kso)>0) OR (SUM(biaya_pasien)>SUM(bayar_pasien)))*/ 
						  {$filter}
						GROUP BY id";
					echo $sqlPer.";<br>";
				   	$rsP=mysql_query($sqlPer);
					while ($rwP=mysql_fetch_array($rsP)){
						$pidK = $rwP["id"];
						//$ptglK=$rwP["disetor_tgl"];
						$ptglK=$rwP["tgl"];
						$ptglP=$rwP["tgl_p"];
						$pkso=$rwP["kso_id"];
						$pbiayaRS=$rwP["biayaRS"]+$rwP["kamarRS"]+$rwP["retribusi"];
						$pbiayaPasien=$rwP["biayaPasien"]+$rwP["kamarPasien"];
						$pbiayaKSO=$rwP["biayaKSO"]+$rwP["kamarKSO"]+$rwP["retribusi"];
						$pbayarPasien=$rwP["bayarPasien"]+$rwP["bayarKamarPasien"];
						$ppiutangPasien=$pbiayaPasien - $pbayarPasien;
					}
				//================================================= END DETAIL
				
				if (mysql_errno()==0){
					
					$sqlVerInsCek="SELECT id FROM k_piutang WHERE kunjungan_id = '$pidK' AND kso_id = '$pkso'";
					echo $sqlVerInsCek.";<br>";
					$rsVerInsCek=mysql_query($sqlVerInsCek);
					if (mysql_num_rows($rsVerInsCek)<=0){
						$sqlVerIns="INSERT INTO k_piutang(kunjungan_id,kso_id,no_bukti,tglK,tglP,biayaRS,biayaKSO,biayaPasien,
														bayarKSO,bayarPasien,piutangPasien,tipe,user_act,tgl_act)
								VALUES ($pidK,$pkso,'$no_slip','$ptglK','$tglS',$pbiayaRS,$pbiayaKSO,$pbiayaPasien,0,$pbayarPasien,$ppiutangPasien,0,'$userId',NOW())";
						echo $sqlVerIns.";<br>";
						$rsVerIns=mysql_query($sqlVerIns);
						
						if (mysql_errno()==0 && mysql_affected_rows()>0){
							//=======insert berhasil======
							$fkId=mysql_insert_id();
							//=======split data piutang (b_tindakan + Obat yg blm lunas) --> kso_id + unit_id=======
							$cUnitIdBilling=0;
	
							$sqlPiutang="SELECT
											  gab.unit_id,
											  gab.kso_id,
											  gab.is_paviliun,
											  gab.isFarmasi,
											  IFNULL(SUM(gab.biayaRS),0)    biayaRS,
											  IFNULL(SUM(gab.biayaKso),0)    biayaKso,
											  IFNULL(SUM(gab.biayaPasien),0)    biayaPasien,
											  IFNULL(SUM(retribusi),0) retribusi,
											  IFNULL(SUM(gab.bayarKso),0)    bayarKso,
											  IFNULL(SUM(gab.bayarPasien),0)    bayarPasien,
											  IFNULL(SUM(gab.ppn),0)    ppn,
											  IFNULL(SUM(gab.biaya_utip),0)    biaya_utip
											FROM (SELECT
												t.id,
												IF(t.ak_ms_unit_id=0,12,t.ak_ms_unit_id) AS unit_id,
												k.kso_id,
												t.is_paviliun,
												0			isFarmasi,
												IF(t.biaya_utip>0,t.qty * (t.biaya-t.biaya_utip),t.qty*t.biaya)	        biayaRS,
												IF(t.biaya_utip>0,t.qty * (t.biaya_kso-t.biaya_utip),t.qty*t.biaya_kso)       biayaKso,
												t.qty*t.biaya_pasien    biayaPasien,
												0 retribusi,
												t.bayar_kso             bayarKso,
												t.bayar_pasien          bayarPasien,
												0 AS ppn,
												t.biaya_utip
											FROM $dbbilling.b_tindakan t
											INNER JOIN $dbbilling.b_pelayanan p
											  ON t.pelayanan_id = p.id
										    INNER JOIN $dbbilling.b_kunjungan k
											 ON p.kunjungan_id = k.id
											WHERE p.kunjungan_id = '$pidK'
											  AND ((t.qty * t.biaya_kso > t.bayar_kso)
												OR (t.qty * t.biaya_pasien > t.bayar_pasien))
											UNION 
											SELECT DISTINCT *
											   FROM (SELECT
												   t.id,
												   9 AS unit_id,
												   k.kso_id,
												   t.is_paviliun,
												   0 isFarmasi,
												   IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.tarip, (IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.tarip)    biayaRS,
												   IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.beban_kso, (IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.beban_kso)    biayaKso,
												   IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.beban_pasien, (IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.beban_pasien)    biayaPasien,
	
	IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.retribusi, (IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.retribusi)    retribusi,											 
												   t.bayar_kso              bayarKso,
												   t.bayar_pasien           bayarPasien,
												   0 AS ppn,
												   0 AS biaya_utip
												 FROM $dbbilling.b_tindakan_kamar t
												   INNER JOIN $dbbilling.b_pelayanan p
													 ON t.pelayanan_id = p.id
												   INNER JOIN $dbbilling.b_kunjungan k
													 ON p.kunjungan_id = k.id
												 WHERE k.id = '$pidK' AND t.aktif = 1) AS tKamar
											   WHERE ((tKamar.biayaPasien > tKamar.bayarPasien)
												   OR (tKamar.biayaKso > tKamar.bayarKso))
											UNION
											SELECT * FROM
												(SELECT
												  t.ID 	AS id,
												  8 AS unit_id,
												  kso.id 	 AS kso_id,
												  p.is_paviliun,
												  1			isFarmasi,
												  SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_SATUAN)    biayaRS,
												  SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_KSO)    biayaKso,
												  SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_PX)    biayaPasien,
												  0 retribusi,
												  0       bayarKso,
												  (SELECT IFNULL(SUM(TOTAL_HARGA),0) FROM $dbapotek.a_kredit_utang 
												  WHERE NORM=mp.no_rm AND FK_NO_PENJUALAN=t.NO_PENJUALAN 
												  AND UNIT_ID=t.UNIT_ID)	  bayarPasien,
												  IF(t.ppn>0,FLOOR(SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_SATUAN)*t.ppn/100),0)    ppn,
												  0 AS biaya_utip
												FROM $dbbilling.b_kunjungan k
												  INNER JOIN $dbbilling.b_ms_pasien mp
													ON k.pasien_id = mp.id
												  INNER JOIN $dbbilling.b_ms_unit mu
													ON k.unit_id = mu.id
												  INNER JOIN $dbbilling.b_pelayanan p
													ON k.id = p.kunjungan_id
												  INNER JOIN $dbapotek.a_penjualan t
													ON p.id = t.NO_KUNJUNGAN
												  /*INNER JOIN $dbapotek.a_mitra m
													ON t.KSO_ID = m.IDMITRA
												  INNER JOIN $dbbilling.b_ms_kso kso
													ON m.kso_id_billing = kso.id*/
												  INNER JOIN $dbbilling.b_ms_kso kso
													ON k.kso_id = kso.id
												WHERE k.id='$pidK' AND ((t.DIJAMIN = 1
												  AND t.KRONIS = 0)
												  OR (t.UTANG > 0 AND t.KRONIS = 0))
												GROUP BY k.id,kso.id,t.UNIT_ID,t.NO_KUNJUNGAN,t.NO_PENJUALAN) AS tot
												WHERE ((tot.biayaKso>tot.bayarKSO) OR (tot.biayaPasien>tot.bayarPasien))) AS gab
											GROUP BY gab.unit_id, gab.kso_id, gab.isFarmasi";
							echo $sqlPiutang.";<br>";
							$rsPiutang=mysql_query($sqlPiutang);
							while ($rwPiutang=mysql_fetch_array($rsPiutang)){
								$cUnitIdBilling=$rwPiutang["unit_id"];
								$cisPavilyun=$rwPiutang["is_paviliun"];
								$cisFarmasi=$rwPiutang["isFarmasi"];
								$cKso=$rwPiutang["kso_id"];
								$cBiayaRS=$rwPiutang["biayaRS"];
								$cBiayaKso=$rwPiutang["biayaKso"];
								$cBiayaPasien=$rwPiutang["biayaPasien"];
								$cBayarKso=$rwPiutang["bayarKso"];
								$cBayarPasien=$rwPiutang["bayarPasien"];
								$cretribusi=$rwPiutang["retribusi"];
								$cppn=$rwPiutang["ppn"];
								$cbiaya_utip=$rwPiutang["biaya_utip"];
								$piutangKso=$cBiayaKso-$cBayarKso;
								$piutangPasien=$cBiayaPasien-$cBayarPasien;
								$piutangRS=$piutangKso+$piutangPasien;
								//======= nilai_sim = piutangKso+piutangPasien =========
								//======= nilai = piutangKso =========
								//======= nilai_hpp = piutangPasien =========
								
								$sqlKTrans="INSERT INTO k_transaksi
														(fk_id,
														 id_trans,
														 tipe_trans,
														 id_ma_sak,
														 id_ma_dpa,
														 tgl,
														 tgl_klaim,
														 unit_id_billing,
														 kso_id,
														 kunjungan_id,
														 kasir_id,
														 nilai_sim,
														 nilai,
														 nilai_hpp,
														 isFarmasi,
														 isPavilyun,
														 tgl_act,
														 user_act,
														 verifikasi)
											VALUES ($fkId,
													$IdTrans,
													1,
													$Idma_sak,
													$Idma_dpa,
													'$tglS',
													'$tglS',
													$cUnitIdBilling,
													$cKso,
													'$pidK',
													'$idpeg',
													$cBiayaRS,
													$piutangKso,
													$piutangPasien,
													'$cisFarmasi',
													'$cisPavilyun',
													NOW(),
													'$userId',
													1)";
								echo $sqlKTrans.";<br>";
								$rsKTrans=mysql_query($sqlKTrans);
								
								if ($cretribusi>0){
									$cpx=0;
									$cBkso=$cretribusi;
									if ($cKso==1){
										$cpx=$cretribusi;
										$cBkso=0;
									}
									
									$sqlKTrans="INSERT INTO k_transaksi
															(fk_id,
															 id_trans,
															 tipe_trans,
															 id_ma_sak,
															 id_ma_dpa,
															 tgl,
															 tgl_klaim,
															 unit_id_billing,
															 kso_id,
															 kunjungan_id,
															 kasir_id,
															 nilai_sim,
															 nilai,
															 nilai_hpp,
															 isFarmasi,
															 isPavilyun,
															 tgl_act,
															 user_act,
															 verifikasi)
												VALUES ($fkId,
														$IdTrans,
														1,
														$Idma_sak,
														$Idma_dpa,
														'$tglS',
														'$tglS',
														12,
														$cKso,
														'$pidK',
														'$idpeg',
														$cretribusi,
														$cBkso,
														$cpx,
														'4',
														'0',
														NOW(),
														'$userId',
														1)";
									echo $sqlKTrans.";<br>";
									$rsKTrans=mysql_query($sqlKTrans);
								}
								
								if ($cppn>0){
									$cpx=0;
									$cBkso=$cppn;
									if ($cKso==1){
										$cpx=$cppn;
										$cBkso=0;
									}
	
									$sqlKTrans="INSERT INTO k_transaksi
															(fk_id,
															 id_trans,
															 tipe_trans,
															 id_ma_sak,
															 id_ma_dpa,
															 tgl,
															 tgl_klaim,
															 unit_id_billing,
															 kso_id,
															 kunjungan_id,
															 kasir_id,
															 nilai_sim,
															 nilai,
															 nilai_hpp,
															 isFarmasi,
															 isPavilyun,
															 tgl_act,
															 user_act,
															 verifikasi)
												VALUES ($fkId,
														$IdTrans,
														1,
														$Idma_sak,
														$Idma_dpa,
														'$tglS',
														'$tglS',
														0,
														$cKso,
														'$pidK',
														'$idpeg',
														$cppn,
														$cBkso,
														$cpx,
														'3',
														'$cisPavilyun',
														NOW(),
														'$userId',
														1)";
									echo $sqlKTrans.";<br>";
									$rsKTrans=mysql_query($sqlKTrans);
								}
								
								if ($cbiaya_utip>0){
									$cpx=0;
									$cBkso=$cbiaya_utip;
									if ($cKso==1){
										$cpx=$cbiaya_utip;
										$cBkso=0;
									}
	
									$sqlKTrans="INSERT INTO k_transaksi
															(fk_id,
															 id_trans,
															 tipe_trans,
															 id_ma_sak,
															 id_ma_dpa,
															 tgl,
															 tgl_klaim,
															 unit_id_billing,
															 kso_id,
															 kunjungan_id,
															 kasir_id,
															 nilai_sim,
															 nilai,
															 nilai_hpp,
															 isFarmasi,
															 isPavilyun,
															 tgl_act,
															 user_act,
															 verifikasi)
												VALUES ($fkId,
														$IdTrans,
														1,
														$Idma_sak,
														$Idma_dpa,
														'$tglS',
														'$tglS',
														0,
														$cKso,
														'$pidK',
														'$idpeg',
														$cbiaya_utip,
														$cBkso,
														$cpx,
														'5',
														'$cisPavilyun',
														NOW(),
														'$userId',
														1)";
									echo $sqlKTrans.";<br>";
									$rsKTrans=mysql_query($sqlKTrans);
								}
							}
						}else{
							$statusProses='Error';
							$alasan='Posting Gagal';
							//========insert gagal --> b_kunjungan=========
							$sqlVer="UPDATE $dbbilling.b_kunjungan
									SET $dbbilling.b_kunjungan.verif_pendapatan = 0
									WHERE $dbbilling.b_kunjungan.id = '$pidK'";
							//echo $sqlVer."<br>";
							$rsVer=mysql_query($sqlVer);
							//=======insert gagal --> batalkan posting tindakan======
							$sqlVer="UPDATE $dbbilling.b_tindakan
									  INNER JOIN $dbbilling.b_pelayanan
										ON $dbbilling.b_tindakan.pelayanan_id = $dbbilling.b_pelayanan.id
									SET $dbbilling.b_tindakan.posting = 0
									WHERE $dbbilling.b_pelayanan.kunjungan_id = '$pidK'
										/*AND $dbbilling.b_pelayanan.kso_id='$ckso_id'*/";
							//echo $sqlVer."<br>";
							$rsVer=mysql_query($sqlVer);
							//========Update b_tindakan_kamar=========
							$sqlVer="UPDATE $dbbilling.b_tindakan_kamar
									  INNER JOIN $dbbilling.b_pelayanan
										ON $dbbilling.b_tindakan_kamar.pelayanan_id = $dbbilling.b_pelayanan.id
									SET $dbbilling.b_tindakan_kamar.posting = 0
									WHERE $dbbilling.b_pelayanan.kunjungan_id = '$pidK'
										/*AND $dbbilling.b_pelayanan.kso_id='$ckso_id'*/";
							//echo $sqlVer."<br>";
							$rsVer=mysql_query($sqlVer);
							//========Update transaksi Obat=========
							$sqlVer="UPDATE $dbapotek.a_penjualan
									  INNER JOIN $dbbilling.b_pelayanan
										ON $dbapotek.a_penjualan.NO_KUNJUNGAN = $dbbilling.b_pelayanan.id
									SET $dbapotek.a_penjualan.VERIFIKASI = 0
									WHERE $dbbilling.b_pelayanan.kunjungan_id = '$pidK'
										/*AND $dbbilling.b_pelayanan.kso_id='$ckso_id'*/";
							//echo $sqlVer."<br>";
							$rsVer=mysql_query($sqlVer);
						}
					}
				}else{
					$statusProses='Error';
					$alasan='Verifikasi Gagal';
					//=======update gagal --> batalkan Verifikasi Piutang tindakan======
				}
			}
		}
		
	}else{
		for ($i=0;$i<count($arfdata);$i++)
		{
			$cdata=explode("|",$arfdata[$i]);
		
			$idpeg=$cdata[8];
			$slip=$cdata[9];
			$ckso_id=$cdata[10];
			$tglS=tglSQL($cdata[2]);
			
			$sql2="select kp.kunjungan_id 
				FROM k_piutang kp 
					INNER JOIN rspelindo_billing.b_kunjungan k 
						ON kp.kunjungan_id=k.id 
				where kp.tglP='$tglS' AND kp.kso_id='$ckso_id'
				and k.user_act_pulang='$idpeg'";
			//echo $sql2.";<br>";
			$rsidK=mysql_query($sql2);
			while($rwidK=mysql_fetch_array($rsidK)){
			
				$idK=$rwidK["kunjungan_id"];
				
				//========cek sudah posting/belum=========
				$sqlCek="SELECT id FROM k_piutang WHERE kunjungan_id='$idK' AND kso_id='$ckso_id' AND tipe=0 AND posting=0";
				//echo $sqlCek.";<br>";
				$rsCek=mysql_query($sqlCek);
				if (mysql_num_rows($rsCek)>0){
					//========Update b_kunjungan=========
					$sqlVer="UPDATE $dbbilling.b_kunjungan
							SET $dbbilling.b_kunjungan.verif_pendapatan = 0
							WHERE $dbbilling.b_kunjungan.id = '$idK'";
					//echo $sqlVer."<br>";
					$rsVer=mysql_query($sqlVer);
					//========Update b_tindakan_kamar=========
					$sqlVer="UPDATE $dbbilling.b_tindakan_kamar
							  INNER JOIN $dbbilling.b_pelayanan
								ON $dbbilling.b_tindakan_kamar.pelayanan_id = $dbbilling.b_pelayanan.id
							SET $dbbilling.b_tindakan_kamar.posting = 0
							WHERE $dbbilling.b_pelayanan.kunjungan_id = '$idK' 
								/*AND $dbbilling.b_pelayanan.kso_id = '$ckso_id'*/ 
								AND $dbbilling.b_tindakan_kamar.posting = 1";
					//echo $sqlVer.";<br>";
					$rsVer=mysql_query($sqlVer);
					//========Update transaksi Obat=========
					$sqlVer="UPDATE $dbapotek.a_penjualan
							  INNER JOIN $dbbilling.b_pelayanan
								ON $dbapotek.a_penjualan.NO_KUNJUNGAN = $dbbilling.b_pelayanan.id
							SET $dbapotek.a_penjualan.VERIFIKASI = 0
							WHERE $dbbilling.b_pelayanan.kunjungan_id = '$idK' 
								/*AND $dbbilling.b_pelayanan.kso_id = '$ckso_id'*/ 
								AND $dbapotek.a_penjualan.VERIFIKASI = 1";
					//echo $sqlVer.";<br>";
					$rsVer=mysql_query($sqlVer);
					//========uposting tindakan=========
					$sqlVer="UPDATE $dbbilling.b_tindakan
							  INNER JOIN $dbbilling.b_pelayanan
								ON $dbbilling.b_tindakan.pelayanan_id = $dbbilling.b_pelayanan.id
							SET $dbbilling.b_tindakan.posting = 0
							WHERE $dbbilling.b_pelayanan.kunjungan_id = '$idK' 
								/*AND $dbbilling.b_pelayanan.kso_id = '$ckso_id'*/ 
								AND $dbbilling.b_tindakan.posting = 1";
					//echo $sqlVer.";<br>";
					$rsVer=mysql_query($sqlVer);
					if (mysql_errno()==0){
						//=========unposting tindakan berhasil========
						//========= hapus k_transaksi =========
						$sqlVer="DELETE FROM k_transaksi WHERE tipe_trans = 1 AND id_trans = $IdTrans AND fk_id IN (SELECT id FROM k_piutang 
								WHERE kunjungan_id='$idK' AND kso_id='$ckso_id' AND tipe=0)";
						//echo $sqlVer.";<br>";
						$rsVer=mysql_query($sqlVer);
						
						$sqlVerDel="DELETE FROM k_piutang WHERE kunjungan_id='$idK' AND kso_id='$ckso_id' AND tipe=0";
						//echo $sqlVerDel.";<br>";
						$rsVerDel=mysql_query($sqlVerDel);
						if (mysql_errno()>0){
							//========delete gagal --> batalkan unposting tindakan=========
							$statusProses='Error';
							$alasan='UnPosting Gagal';
	
							//========Update b_kunjungan=========
							$sqlVer="UPDATE $dbbilling.b_kunjungan
									SET $dbbilling.b_kunjungan.verif_pendapatan = 1
									WHERE $dbbilling.b_kunjungan.id = '$idK'";
							//echo $sqlVer."<br>";
							$rsVer=mysql_query($sqlVer);
							//========Update b_tindakan=========
							$sqlVer="UPDATE $dbbilling.b_tindakan
									  INNER JOIN $dbbilling.b_pelayanan
										ON $dbbilling.b_tindakan.pelayanan_id = $dbbilling.b_pelayanan.id
									SET $dbbilling.b_tindakan.posting = 1
									WHERE $dbbilling.b_pelayanan.kunjungan_id = '$idK' 
										/*AND $dbbilling.b_pelayanan.kso_id = '$ckso_id'*/ 
										AND $dbbilling.b_tindakan.posting = 0";
							//echo $sqlVer."<br>";
							$rsVer=mysql_query($sqlVer);
							//========Update b_tindakan_kamar=========
							$sqlVer="UPDATE $dbbilling.b_tindakan_kamar
									  INNER JOIN $dbbilling.b_pelayanan
										ON $dbbilling.b_tindakan_kamar.pelayanan_id = $dbbilling.b_pelayanan.id
									SET $dbbilling.b_tindakan_kamar.posting = 1
									WHERE $dbbilling.b_pelayanan.kunjungan_id = '$idK' 
										/*AND $dbbilling.b_pelayanan.kso_id = '$ckso_id'*/ 
										AND $dbbilling.b_tindakan_kamar.posting = 0";
							//echo $sqlVer."<br>";
							$rsVer=mysql_query($sqlVer);
							//========Update transaksi Obat=========
							$sqlVer="UPDATE $dbapotek.a_penjualan
									  INNER JOIN $dbbilling.b_pelayanan
										ON $dbapotek.a_penjualan.NO_KUNJUNGAN = $dbbilling.b_pelayanan.id
									SET $dbapotek.a_penjualan.VERIFIKASI = 1
									WHERE $dbbilling.b_pelayanan.kunjungan_id = '$idK' 
										/*AND $dbbilling.b_pelayanan.kso_id = '$ckso_id'*/ 
										AND $dbapotek.a_penjualan.VERIFIKASI = 0";
							//echo $sqlVer."<br>";
							$rsVer=mysql_query($sqlVer);
						}
					}else{
						//=======unposting gagal======
						$statusProses='Error';
						$alasan='UnPosting Gagal';
					}
				}else{
					//=======sudah diposting======
					$statusProses='Error';
					$alasan='Data Tidak Boleh DiUnVerifikasi Karena Sudah Diposting Ke Jurnal Akuntansi';
				}
				//========cek sudah posting/belum END=========
			}
		}
	}
	break;
}

if (($statusProses=='') && (strtolower($_REQUEST['act'])=='verifikasi')){
	if ($posting==0){
		$alasan='Verifikasi Data Berhasil !';
	}else{
		$alasan='UnVerifikasi Data Berhasil !';
	}
}

/* if($statusProses=='Error') {
    $dt="0".chr(5).chr(4).chr(5).strtolower($_REQUEST['act'])."*|*".$alasan;
}
else { */
	$fkso="";
	$fkso_obat="";
	if ($kso!="0"){
		//$fkso=" AND t.kso_id='$kso'";
		$fkso=" AND k.kso_id='$kso'";
		$fkso_obat=" AND kso.id='$kso'";
		//$fkso_kp=" AND kp.kso_id='$kso'";
	}
	
	$fposting="tin.posting='$posting'";
	if ($posting>0){
		$fposting="tin.posting>'$posting'";
	}
    
	if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
    }

    if ($sorting=="") {
        $sorting=$defaultsort;
    }
	//echo "grid=".$grid.";<br>";
    if($grid == "1Rkp") {
		if ($posting==0){
			$sql="SELECT id,pasien_id,DATE_FORMAT(dt,'%d-%m-%Y') AS tgl,
				  DATE_FORMAT(tgl_pulang,'%d-%m-%Y') AS tgl_p,
				  DATE_FORMAT(tgl_pulang_ak,'%d-%m-%Y') AS tgl_pulang_ak,
				  no_rm,nama AS pasien,
				  unit,kso_id,
				  nmkso,
				  SUM(biaya) biayaRS,
				  SUM(biaya_kso) biayaKSO,
				  SUM(biaya_pasien) biayaPasien,
				  SUM(retribusi) retribusi,
				  SUM(bayar) bayar,
				  SUM(bayar_kso) bayarKso,
				  SUM(bayar_pasien) bayarPasien,
				  DATE_FORMAT(dt,'%d-%m-%Y') AS disetor_tgl,
				  slip_ke,
				  namapeg,
				  idpeg
				FROM
				(SELECT ttind.* FROM
				(SELECT
				  k.id,
				  k.pasien_id,
				  k.disetor_tgl,
				  k.tgl_pulang,
				  k.tgl_pulang_ak,
				  k.user_act_pulang,
				  mp.no_rm,
				  mp.nama,
				  mu.nama AS unit,
				  t.id idTind,
				  kso.id   AS kso_id,
				  kso.nama AS nmkso,
				  0 AS tipe,
				  t.qty*t.biaya biaya,
				  t.qty*t.biaya_kso biaya_kso,
				  t.qty*t.biaya_pasien biaya_pasien,
				  0 retribusi,
				  t.bayar,
				  t.bayar_kso,
				  /*t.bayar_pasien*/
				  IFNULL(SUM(IF(bt.jenis_bayar=0,bt.nilai,0)),0) AS bayar_pasien,
				  k.disetor_tgl dt,
				  g.nama namapeg,
				  k.slip_ke,
				  g.id idpeg
				FROM $dbbilling.b_kunjungan k
				  INNER JOIN $dbbilling.b_ms_pasien mp
					ON k.pasien_id = mp.id
				  INNER JOIN $dbbilling.b_ms_unit mu
					ON k.unit_id = mu.id
				  INNER JOIN $dbbilling.b_pelayanan p
					ON k.id = p.kunjungan_id
				  INNER JOIN $dbbilling.b_tindakan t
					ON p.id = t.pelayanan_id
				  INNER JOIN $dbbilling.b_ms_kso kso
					ON k.kso_id = kso.id
				  LEFT JOIN $dbbilling.b_bayar_tindakan bt 
					ON (t.id = bt.tindakan_id AND bt.tipe=0)
				  INNER JOIN $dbbilling.b_ms_pegawai g ON g.id=k.user_act_pulang
				WHERE k.pulang = 1 
				 AND k.kso_id<>1
					AND k.tgl_pulang_ak='$tglslip'
					AND t.posting='$posting'
				GROUP BY t.id) AS ttind
				WHERE ((ttind.biaya_kso>0) OR (ttind.biaya_pasien>ttind.bayar_pasien))
				UNION
				SELECT tk.* FROM 
					(SELECT
					  k.id,
					  k.pasien_id,
					  k.disetor_tgl,
					  k.tgl_pulang,
					  k.tgl_pulang_ak,
				  	  k.user_act_pulang,
					  mp.no_rm,
					  mp.nama,
					  mu.nama        AS unit_awal,
					  t.id idTind,
					  kso.id         AS kso_id,
					  kso.nama       AS nmkso,
					  1 AS tipe,
					  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.tarip, (IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.tarip)    biaya,
					  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.beban_kso, (IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.beban_kso)    biaya_kso,
					  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.beban_pasien, (IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.beban_pasien)    biaya_pasien,
					  
IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.retribusi, (IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.retribusi)    retribusi,
					  t.bayar,  
					  t.bayar_kso,
					  /*t.bayar_pasien*/
					  IFNULL(SUM(IF(bt.jenis_bayar=0,bt.nilai,0)),0) AS bayar_pasien,
					  k.disetor_tgl dt,
					  g.nama namapeg,
					  k.slip_ke,
					  g.id idpeg
					FROM $dbbilling.b_kunjungan k
					  INNER JOIN $dbbilling.b_ms_pasien mp
						ON k.pasien_id = mp.id
					  INNER JOIN $dbbilling.b_ms_unit mu
						ON k.unit_id = mu.id
					  INNER JOIN $dbbilling.b_pelayanan p
						ON k.id = p.kunjungan_id
					  INNER JOIN $dbbilling.b_tindakan_kamar t
						ON p.id = t.pelayanan_id
					  INNER JOIN $dbbilling.b_ms_kso kso
						ON k.kso_id = kso.id
					  LEFT JOIN $dbbilling.b_bayar_tindakan bt 
						ON (t.id = bt.tindakan_id AND bt.tipe=1)
					  INNER JOIN $dbbilling.b_ms_pegawai g ON g.id=k.user_act_pulang
					WHERE k.pulang = 1  AND k.kso_id<>1  AND t.posting='$posting'
						AND t.aktif = 1 AND k.tgl_pulang_ak='$tglslip'
					GROUP BY t.id) AS tk 
				WHERE (tk.biaya_kso>0 OR tk.biaya_pasien>tk.bayar_pasien)
				UNION
				SELECT
				  k.id,
				  k.pasien_id,
				  k.disetor_tgl,
				  k.tgl_pulang,
				  k.tgl_pulang_ak,
				  k.user_act_pulang,
				  mp.no_rm,
				  mp.nama,
				  mu.nama AS unit_awal,
				  t.id idTind,
				  kso.id AS kso_id,
					

				  kso.nama AS nmkso,
				  2 AS tipe,
				SUM(
					  (t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_SATUAN)+
					  FLOOR((t.PPN/100) *  SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_SATUAN)
					  ) biaya,
					  
					  SUM(
					  (t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_KSO)+
					  FLOOR((t.PPN/100) *  SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_KSO)
					  ) biaya_kso,
					  
					  SUM(
					  (t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_PX)+
					  FLOOR((t.PPN/100) *  SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_PX)
					  ) biaya_pasien,
				  0 retribusi,
				  (SELECT IFNULL(SUM(TOTAL_HARGA),0) FROM $dbapotek.a_kredit_utang 
				  WHERE NORM=mp.no_rm AND FK_NO_PENJUALAN=t.NO_PENJUALAN 
				  AND UNIT_ID=t.UNIT_ID AND DATE(TGL_BAYAR)<=k.tgl_pulang_ak) AS bayar,  
				  0 AS bayarKso,
				  (SELECT IFNULL(SUM(TOTAL_HARGA),0) FROM $dbapotek.a_kredit_utang 
				  WHERE NORM=mp.no_rm AND FK_NO_PENJUALAN=t.NO_PENJUALAN 
				  AND UNIT_ID=t.UNIT_ID AND DATE(TGL_BAYAR)<=k.tgl_pulang_ak) AS bayar_pasien,
				   k.disetor_tgl dt,
				  g.nama namapeg,
				  k.slip_ke,
				  g.id idpeg
				FROM $dbbilling.b_kunjungan k
				  INNER JOIN $dbbilling.b_ms_pasien mp
					ON k.pasien_id = mp.id
				  INNER JOIN $dbbilling.b_ms_unit mu
					ON k.unit_id = mu.id
				  INNER JOIN $dbbilling.b_pelayanan p
					ON k.id = p.kunjungan_id
				  INNER JOIN $dbapotek.a_penjualan t
					ON p.id = t.NO_KUNJUNGAN
				  /*INNER JOIN $dbapotek.a_mitra m
					ON t.KSO_ID = m.IDMITRA
				  INNER JOIN $dbbilling.b_ms_kso kso
					ON m.kso_id_billing = kso.id*/
				  INNER JOIN $dbbilling.b_ms_kso kso 
				    ON k.kso_id = kso.id 
				  INNER JOIN $dbbilling.b_ms_pegawai g ON g.id=k.user_act_pulang
				WHERE k.pulang = 1 AND k.kso_id<>1 AND k.tgl_pulang_ak='$tglslip' 
					AND t.KRONIS=0 AND ((t.DIJAMIN=1) OR (t.UTANG>0) OR (t.UTANG=0 AND t.TGL_BAYAR>k.tgl_pulang_ak)) AND t.VERIFIKASI = '$posting'
				GROUP BY k.id,kso.id,t.UNIT_ID,t.NO_KUNJUNGAN,t.NO_PENJUALAN) AS gab
				/* WHERE 1=1 AND ((SUM(biaya_kso)>0) OR (SUM(biaya_pasien)>SUM(bayar_pasien)))*/ 
				  {$filter}
				GROUP BY kso_id,user_act_pulang,tgl_pulang_ak 
				ORDER BY namapeg,nmkso";
		}else{
			 /*$sql = "SELECT *
					FROM (SELECT DISTINCT
							  k.id,  
							  pas.no_rm,
							  pas.nama AS pasien,
							  kp.kso_id,
							  kso.nama     kso,
							  mu.nama      unit,
							  DATE_FORMAT(kp.tglK,'%d-%m-%Y') AS tgl,
							  DATE_FORMAT(kp.tglP,'%d-%m-%Y') AS tgl_p,
							  
							  SUM(kp.biayaRS) biayaRS,
							  SUM(kp.biayaPasien) biayaPasien,
							  SUM(kp.biayaKSO) biayaKSO,
							  SUM(kp.bayarPasien) bayarPasien,
							  SUM(kp.piutangPasien) piutangPasien,
							  g.nama namapeg,
							  k.tgl_pulang_ak,
							  g.id idpeg,
							  k.slip_ke,
							  DATE_FORMAT(k.disetor_tgl,'%d-%m-%Y') AS disetor_tgl
							FROM k_piutang kp
							  INNER JOIN $dbbilling.b_kunjungan k
								ON kp.kunjungan_id = k.id
							  INNER JOIN $dbbilling.b_ms_pasien pas
								ON k.pasien_id = pas.id
							  INNER JOIN $dbbilling.b_ms_kso kso
								ON k.kso_id = kso.id
							  INNER JOIN $dbbilling.b_ms_unit mu
								ON k.unit_id = mu.id
							  INNER JOIN $dbbilling.b_ms_pegawai g ON g.id=k.user_act_pulang
							WHERE kp.tglP = '$tglslip'
							AND kp.tipe=0 group by k.kso_id,k.user_act_pulang, k.tgl_pulang_ak) tx
						
					WHERE 0 = 0 {$filter} 
					ORDER BY {$sorting}";*/
			 $sql = "SELECT
					  id,
					  no_rm,
					  pasien,
					  kso_id,
					  nmkso,
					  unit,
					  tgl,
					  tgl_p,
					  SUM(biayaRS)     biayaRS,
					  SUM(biayaPasien)    biayaPasien,
					  0 retribusi,
					  SUM(biayaKSO)    biayaKSO,
					  SUM(bayarPasien)    bayarPasien,
					  SUM(piutangPasien)    piutangPasien,
					  namapeg,
					  tgl_pulang_ak,
					  idpeg,
					  slip_ke,
					  disetor_tgl
					FROM (SELECT DISTINCT
							k.id,
							pas.no_rm,
							pas.nama         AS pasien,
							kp.kso_id,
							kso.nama            nmkso,
							mu.nama             unit,
							DATE_FORMAT(kp.tglK,'%d-%m-%Y') AS tgl,
							DATE_FORMAT(kp.tglP,'%d-%m-%Y') AS tgl_p,
							kp.biayaRS,
							kp.biayaPasien,
							kp.biayaKSO,
							kp.bayarPasien,
							kp.piutangPasien,
							g.nama              namapeg,
							DATE_FORMAT(k.tgl_pulang_ak,'%d-%m-%Y') AS tgl_pulang_ak,
							g.id                idpeg,
							k.slip_ke,
							DATE_FORMAT(k.disetor_tgl,'%d-%m-%Y') AS disetor_tgl
						  FROM k_piutang kp
							INNER JOIN $dbbilling.b_kunjungan k
							  ON kp.kunjungan_id = k.id
							INNER JOIN $dbbilling.b_ms_pasien pas
							  ON k.pasien_id = pas.id
							INNER JOIN $dbbilling.b_ms_kso kso
							  ON k.kso_id = kso.id
							INNER JOIN $dbbilling.b_ms_unit mu
							  ON k.unit_id = mu.id
							INNER JOIN $dbbilling.b_ms_pegawai g
							  ON g.id = k.user_act_pulang
						  WHERE kp.tglP = '$tglslip'
							  AND kp.tipe = 0) tx
					WHERE 0 = 0 {$filter}
					GROUP BY kso_id, idpeg, tgl_pulang_ak
					ORDER BY namapeg,nmkso";
		}
		
		$sqlSum = "select ifnull(sum(biayaRS),0) as totbiayaRS, ifnull(sum(retribusi),0) as tot_retribusi
					from (".$sql.") sql36";
		//echo $sqlSum.";<br>";
		$rsSum = mysql_query($sqlSum);
		$rwSum = mysql_fetch_array($rsSum);
		$totRkp = $rwSum["totbiayaRS"]+$rwSum["tot_retribusi"];

    }else if($grid == "piutangDetail") {
		if ($posting==0){				
			$sql="SELECT id,pasien_id,DATE_FORMAT(tgl,'%d-%m-%Y') AS tgl,
				  DATE_FORMAT(tgl_pulang,'%d-%m-%Y') AS tgl_p,
				  no_rm,nama AS pasien,
				  unit,kso_id,
				  nmkso,
				  SUM(biaya) biayaRS,
				  SUM(biaya_kso) biayaKSO,
				  SUM(biaya_pasien) biayaPasien,
				  SUM(retribusi) retribusi,
				  SUM(bayar) bayar,
				  SUM(bayar_kso) bayarKso,
				  SUM(bayar_pasien) bayarPasien,
				  DATE_FORMAT(dt,'%d-%m-%Y') AS disetor_tgl,
				  slip_ke,
				  namapeg,
				  idpeg
				FROM
				(SELECT ttind.* FROM
				(SELECT
				  k.id,
				  k.tgl,
				  k.pasien_id,
				  k.disetor_tgl,
				  k.tgl_pulang,
				  k.tgl_pulang_ak,
				  k.user_act_pulang,
				  mp.no_rm,
				  mp.nama,
				  mu.nama AS unit,
				  t.id idTind,
				  kso.id AS kso_id,
				  kso.nama AS nmkso,
				  0 AS tipe,
				  t.qty*t.biaya biaya,
				  t.qty*t.biaya_kso biaya_kso,
				  t.qty*t.biaya_pasien biaya_pasien,
				  0 retribusi,
				  t.bayar,
				  t.bayar_kso,
				  /*t.bayar_pasien*/
				  IFNULL(SUM(IF(bt.jenis_bayar=0,bt.nilai,0)),0) AS bayar_pasien,
				  k.disetor_tgl dt,
				  g.nama namapeg,
				  k.slip_ke,
				  g.id idpeg
				FROM $dbbilling.b_kunjungan k
				  INNER JOIN $dbbilling.b_ms_pasien mp
					ON k.pasien_id = mp.id
				  INNER JOIN $dbbilling.b_ms_unit mu
					ON k.unit_id = mu.id
				  INNER JOIN $dbbilling.b_pelayanan p
					ON k.id = p.kunjungan_id
				  INNER JOIN $dbbilling.b_tindakan t
					ON p.id = t.pelayanan_id
				  INNER JOIN $dbbilling.b_ms_kso kso
					ON k.kso_id = kso.id
				  LEFT JOIN $dbbilling.b_bayar_tindakan bt 
					ON (t.id = bt.tindakan_id AND bt.tipe=0)
				  INNER JOIN $dbbilling.b_ms_pegawai g ON g.id=k.user_act_pulang
				WHERE k.pulang = 1 
				 /*AND k.kso_id<>1*/ $fkso 
					AND k.tgl_pulang_ak='$tglslip'
				GROUP BY t.id) AS ttind
				WHERE ((ttind.biaya_kso>0) OR (ttind.biaya_pasien>ttind.bayar_pasien))
				UNION
				SELECT tk.* FROM 
					(SELECT
					  k.id,
					  k.tgl,
					  k.pasien_id,
					  k.disetor_tgl,
					  k.tgl_pulang,
					  k.tgl_pulang_ak,
					  k.user_act_pulang,
					  mp.no_rm,
					  mp.nama,
					  mu.nama        AS unit_awal,
					  t.id idTind,
					  kso.id AS kso_id,
					  kso.nama       AS nmkso,
					  1 as tipe,
					  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.tarip, (IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.tarip)    biaya,
					  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.beban_kso, (IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.beban_kso)    biaya_kso,
					  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.beban_pasien, (IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.beban_pasien)    biaya_pasien,
					  
IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,1,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.retribusi, (IF(DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)=0,0,DATEDIFF(IFNULL(t.tgl_out,k.tgl_pulang_ak),t.tgl_in)+1))*t.retribusi)    retribusi,
					  t.bayar,  
					  t.bayar_kso,
					  /*t.bayar_pasien*/
					  IFNULL(SUM(IF(bt.jenis_bayar=0,bt.nilai,0)),0) AS bayar_pasien,
					  k.disetor_tgl dt,
					  g.nama namapeg,
					  k.slip_ke,
					  g.id idpeg
					FROM $dbbilling.b_kunjungan k
					  INNER JOIN $dbbilling.b_ms_pasien mp
						ON k.pasien_id = mp.id
					  INNER JOIN $dbbilling.b_ms_unit mu
						ON k.unit_id = mu.id
					  INNER JOIN $dbbilling.b_pelayanan p
						ON k.id = p.kunjungan_id
					  INNER JOIN $dbbilling.b_tindakan_kamar t
						ON p.id = t.pelayanan_id
					  INNER JOIN $dbbilling.b_ms_kso kso
						ON k.kso_id = kso.id
					  LEFT JOIN $dbbilling.b_bayar_tindakan bt 
						ON (t.id = bt.tindakan_id AND bt.tipe=1)
					  INNER JOIN $dbbilling.b_ms_pegawai g ON g.id=k.user_act_pulang
					WHERE k.pulang = 1 /*AND k.kso_id<>1*/ $fkso
						AND t.aktif = 1 AND k.tgl_pulang_ak='$tglslip'
					GROUP BY t.id) AS tk 
				WHERE (tk.biaya_kso>0 OR tk.biaya_pasien>tk.bayar_pasien)
				UNION
				SELECT
				  k.id,
				  k.tgl,
				  k.pasien_id,
				  k.disetor_tgl,
				  k.tgl_pulang,
				  k.tgl_pulang_ak,
				  k.user_act_pulang,
				  mp.no_rm,
				  mp.nama,
				  mu.nama AS unit_awal,
				  t.id idTind,
				  kso.id AS kso_id,


				  kso.nama AS nmkso,
				  2 AS tipe,
				SUM(
					  (t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_SATUAN)+
					  FLOOR((t.PPN/100) *  SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_SATUAN)
					  ) biaya,
					  
					  SUM(
					  (t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_KSO)+
					  FLOOR((t.PPN/100) *  SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_KSO)
					  ) biaya_kso,
					  
					  SUM(
					  (t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_PX)+
					  FLOOR((t.PPN/100) *  SUM((t.QTY_JUAL-t.QTY_RETUR) * t.HARGA_PX)
					  ) biaya_pasien,
				  0 retribusi,
				  (SELECT IFNULL(SUM(TOTAL_HARGA),0) FROM $dbapotek.a_kredit_utang 
				  WHERE NORM=mp.no_rm AND FK_NO_PENJUALAN=t.NO_PENJUALAN 
				  AND UNIT_ID=t.UNIT_ID AND DATE(TGL_BAYAR)<=k.tgl_pulang_ak) AS bayar,  
				  0 AS bayarKso,
				  (SELECT IFNULL(SUM(TOTAL_HARGA),0) FROM $dbapotek.a_kredit_utang 
				  WHERE NORM=mp.no_rm AND FK_NO_PENJUALAN=t.NO_PENJUALAN 
				  AND UNIT_ID=t.UNIT_ID AND DATE(TGL_BAYAR)<=k.tgl_pulang_ak) AS bayar_pasien,
				   k.disetor_tgl dt,
				  g.nama namapeg,
				  k.slip_ke,
				  g.id idpeg
				FROM $dbbilling.b_kunjungan k
				  INNER JOIN $dbbilling.b_ms_pasien mp
					ON k.pasien_id = mp.id
				  INNER JOIN $dbbilling.b_ms_unit mu
					ON k.unit_id = mu.id
				  INNER JOIN $dbbilling.b_pelayanan p
					ON k.id = p.kunjungan_id
				  INNER JOIN $dbapotek.a_penjualan t
					ON p.id = t.NO_KUNJUNGAN
				  /*INNER JOIN $dbapotek.a_mitra m
					ON t.KSO_ID = m.IDMITRA
				  INNER JOIN $dbbilling.b_ms_kso kso
					ON m.kso_id_billing = kso.id*/
				  INNER JOIN $dbbilling.b_ms_kso kso 
				    ON k.kso_id = kso.id 
				  INNER JOIN $dbbilling.b_ms_pegawai g ON g.id=k.user_act_pulang
				WHERE k.pulang = 1  AND k.kso_id<>1 AND k.tgl_pulang_ak='$tglslip' $fkso
					AND t.KRONIS=0 AND ((t.DIJAMIN=1) OR (t.UTANG>0) OR (t.UTANG=0 AND t.TGL_BAYAR>k.tgl_pulang_ak)) AND t.VERIFIKASI = 0
				GROUP BY k.id,kso.id,t.UNIT_ID,t.NO_KUNJUNGAN,t.NO_PENJUALAN) AS gab
				WHERE idpeg='$kasir'
				  {$filter}
				GROUP BY id";
		}else{
			$sql = "SELECT *
					FROM (SELECT DISTINCT
							  k.id,  
							  pas.no_rm,
							  pas.nama AS pasien,
							  kp.kso_id,
							  kso.nama     nmkso,
							  mu.nama      unit,
							  DATE_FORMAT(kp.tglK,'%d-%m-%Y') AS tgl,
							  DATE_FORMAT(kp.tglP,'%d-%m-%Y') AS tgl_p,
							  kp.biayaRS,
							  kp.biayaPasien,
							  0 retribusi,
							  kp.biayaKSO,
							  kp.bayarPasien,
							  kp.piutangPasien,
							  g.nama namapeg,
							  k.slip_ke,
							  g.id idpeg,
							  DATE_FORMAT(k.disetor_tgl,'%d-%m-%Y') AS disetor_tgl
							FROM k_piutang kp
							  INNER JOIN $dbbilling.b_kunjungan k
								ON kp.kunjungan_id = k.id
							  INNER JOIN $dbbilling.b_ms_pasien pas
								ON k.pasien_id = pas.id
							  INNER JOIN $dbbilling.b_ms_kso kso
								ON k.kso_id = kso.id
							  INNER JOIN $dbbilling.b_ms_unit mu
								ON k.unit_id = mu.id
							  INNER JOIN $dbbilling.b_ms_pegawai g ON g.id=k.user_act_pulang
							WHERE kp.tglP = '$tglslip'
							AND kp.tipe=0 
							AND k.user_act_pulang = '$kasir'
							$fkso) tx
					WHERE 0 = 0 {$filter} 
					ORDER BY {$sorting}";
			//echo $sql.";<br>";
		}
		//+$rows["kamarKSO"]+$rows["retribusi"];
		//if($posting == 0){
			$sqlSum = "select ifnull(sum(biayaRS),0) as totbiayaRS, 
						ifnull(sum(biayaPasien),0) as totbiayaPasien,
						ifnull(sum(biayaKSO),0) as totbiayaKSO,
						ifnull(sum(bayarPasien),0) as totbayarPasien,
						ifnull(sum(retribusi),0) as totretribusi 
						from (".$sql.") sql36";
		/*} else {
			$sqlSum = "select ifnull(sum(biayaRS),0) as totbiayaRS, 
						ifnull(sum(biayaKSO),0) as totbiayaKSO 
						from (".$sql.") sql36";
		}*/
		//echo $sqlSum.";<br>";
		$rsSum = mysql_query($sqlSum);
		$rwSum = mysql_fetch_array($rsSum);
		$totRetribusi = $rwSum["totretribusi"];
		$totPer = $rwSum["totbiayaRS"]+$totRetribusi;
		$totPas = $rwSum["totbiayaPasien"];
		$totKso = $rwSum["totbiayaKSO"]+$totRetribusi;
		$totbayarPas = $rwSum["totbayarPasien"];
		$totPiutangPx = $totPas-$totbayarPas;
		$stot = $rwSum["totbiayaKSO"];
		//echo $totPer."|".$totPas."|".$totKso."|".$totbayarPas."|".$totPiutangPx.";<br>";
    }
   
   
   /*    if($grid == '1Rkp'){
		if ($posting==0){
			 $sqlPlus = "select IFNULL(sum(biayaRS),0) as totPer,
						IFNULL(sum(biayaKSO),0) as totKso,
						IFNULL(sum(biayaPasien),0) as totPas,
						IFNULL(sum(retribusi),0) as totRet,
						IFNULL(sum(bayarPasien),0) as totbayarPas
						from (".$sql.") sql36";
			$rsPlus = mysql_query($sqlPlus);
			$rowPlus = mysql_fetch_array($rsPlus);
			$totPer = $rowPlus['totPer']+$rowPlus['totRet'];
			$totKso = $rowPlus['totKso']+$rowPlus['totRet'];
			$totPas = $rowPlus['totPas'];
			$totbayarPas = $rowPlus['totbayarPas'];
			$totPiutangPx = $totPas-$totbayarPas;
		}else if($grid == 'piutangDetail'){
			$sqlPlus = "select IFNULL(sum(biayaRS),0) as totPer,
						IFNULL(sum(biayaKSO),0) as totKso,
						IFNULL(sum(biayaPasien),0) as totPas,
						IFNULL(sum(retribusi),0) as totRet,
						IFNULL(sum(bayarPasien),0) as totbayarPas,
						IFNULL(sum(piutangPasien),0) as totpiutangPas
						from (".$sql.") sql36 ";
			$rsPlus = mysql_query($sqlPlus);
			$rowPlus = mysql_fetch_array($rsPlus);
			$totPer = $rowPlus['totPer']+$rowPlus['totRet'];
			$totKso = $rowPlus['totKso']+$rowPlus['totRet'];
			$totPas = $rowPlus['totPas'];
			$totbayarPas = $rowPlus['totbayarPas'];
			$totPiutangPx = $rowPlus['totpiutangPas'];
		}
    }*/
   
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
    $unit_asal = '';
	//echo "grid=".$grid.";<br>";
	//echo "dt=".$dt.";<br>";
    if($grid == "1Rkp") {
		//echo "grid=rkp;<br>";
		while ($rows=mysql_fetch_array($rs)) {
			$i++;
			$tmpLay = $rows["unit"];
			$kso = $rows["nmkso"];
			$tPerda=$rows["biayaRS"]+$rows["kamarRS"]+$rows["retribusi"];
			$tKSO=$rows["biayaKSO"]+$rows["kamarKSO"]+$rows["retribusi"];
			$tPx=$rows["biayaPasien"]+$rows["kamarPasien"];
			$tBayarPx=$rows["bayarPasien"]+$rows["bayarKamarPasien"];
			$tPiutangPx=$tPx-$tBayarPx;
			$sisip=$rows["id"]."|".$rows["tgl"]."|".$rows["tgl_pulang_ak"]."|".$tPerda."|".$tPx."|".$tKSO."|".$tBayarPx."|".$tPiutangPx."|".$rows["idpeg"]."|".$rows["slip_ke"]."|".$rows["kso_id"];
			/*$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["disetor_tgl"].chr(3).$rows["slip_ke"].chr(3).$rows["nama_peg"].chr(3).number_format($tKSO,0,",",".").chr(3).$kso.chr(3).$tmpLay.chr(3).number_format($tPerda,0,",",".").chr(3).number_format($tPx,0,",",".").chr(3).number_format($tKSO,0,",",".").chr(3).number_format($tBayarPx,0,",",".").chr(3).number_format($tPiutangPx,0,",",".").chr(3)."0".chr(6);*/
			
			$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["tgl_p"].chr(3).$rows["namapeg"].chr(3).$kso.chr(3).number_format($tPerda,0,",",".").chr(3)."0".chr(6);
			$tmpLay = '';
		}
    } else if($grid == "piutangDetail") {
		//echo "grid=detail;<br>";
		while ($rows=mysql_fetch_array($rs)) {
			$i++;
			$tmpLay = $rows["unit"];
			$kso = $rows["nmkso"];
			$tPerda=$rows["biayaRS"]+$rows["kamarRS"]+$rows["retribusi"];
			$tKSO=$rows["biayaKSO"]+$rows["kamarKSO"]+$rows["retribusi"];
			$tPx=$rows["biayaPasien"]+$rows["kamarPasien"];
			$tBayarPx=$rows["bayarPasien"]+$rows["bayarKamarPasien"];
			$tPiutangPx=$tPx-$tBayarPx;
			$sisip=$rows["id"]."|".$rows["tgl"]."|".$rows["tgl_p"]."|".$tPerda."|".$tPx."|".$tKSO."|".$tBayarPx."|".$tPiutangPx;
			
			$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).$rows["tgl"].chr(3).$rows["tgl_p"].chr(3).$rows["no_rm"].chr(3).$rows["pasien"].chr(3).$kso.chr(3).$tmpLay.chr(3).number_format($tPerda,0,",",".").chr(3).number_format($tPx,0,",",".").chr(3).number_format($tKSO,0,",",".").chr(3).number_format($tBayarPx,0,",",".").chr(3).number_format($tPiutangPx,0,",",".").chr(6);
			$tmpLay = '';
		}
    }
    //echo "dt=".$dt.";<br>";
    if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5);
        $dt=str_replace('"','\"',$dt);
		//echo "grid=".$grid.";<br>";
		if($grid == "1Rkp"){
			$dt = $dt.number_format(0,0,",",".").chr(3).number_format(0,0,",",".").chr(3).number_format($stot,0,",",".").chr(3).number_format(0,0,",",".").chr(3).number_format($totRkp,0,",",".").chr(3).$_REQUEST['act'].chr(3).$grid.chr(3).$alasan;
		//	$dt = $dt.chr(5).number_format($totPer,0,",",".").chr(3).number_format($totPas,0,",",".").chr(3).number_format($stot,0,",",".").chr(3).number_format($totbayarPas,0,",",".").chr(3).number_format($totPiutangPx,0,",",".").chr(3).$alasan;
		}
		else{
			$dt = $dt.number_format($totPer,0,",",".").chr(3).number_format($totPas,0,",",".").chr(3).number_format($totKso,0,",",".").chr(3).number_format($totbayarPas,0,",",".").chr(3).number_format($totPiutangPx,0,",",".").chr(3).$_REQUEST['act'].chr(3).$grid.chr(3).$alasan;
		//	$dt = $dt.chr(5).number_format($totPer,0,",",".").chr(3).number_format($totPas,0,",",".").chr(3).number_format($stot,0,",",".").chr(3).number_format($totbayarPas,0,",",".").chr(3).number_format($totPiutangPx,0,",",".").chr(3).$alasan;
		}
    }else{
		$dt = $dt.chr(5).number_format($totPer,0,",",".").chr(3).number_format($totPas,0,",",".").chr(3).number_format($totKso,0,",",".").chr(3).number_format($totbayarPas,0,",",".").chr(3).number_format($totPiutangPx,0,",",".").chr(3).$_REQUEST['act'].chr(3).$grid.chr(3).$alasan;
	}
	/*   if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5).$_REQUEST['act']."|".$grd."|".number_format($stot,0,",",".")."|".$posting;
        $dt=str_replace('"','\"',$dt);
    }else{
        $dt=$dt.chr(5).$_REQUEST['act']."|".$grd."|".number_format($stot,0,",",".")."|".$posting;
        $dt=str_replace('"','\"',$dt);
	}*/
    
    mysql_free_result($rs);
//}
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