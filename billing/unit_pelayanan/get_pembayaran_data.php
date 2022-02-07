<?php
            include("../koneksi/konek.php");
			include("../sesi.php");
			$kasir=$_REQUEST['kasir'];
			$qCab = mysql_query("select cabang_id from b_ms_unit where id = '{$kasir}'");
			if($qCab && mysql_num_rows($qCab) > 0){
				$dCab = mysql_fetch_array($qCab);
				$cabang = $dCab['cabang_id'];
			} else {
				$cabang = 1 ;
			}
            $kataKunci=$_REQUEST['keyword'];
			$status=$_REQUEST['status'];
		
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
			if ($status==""){
				$sql="SELECT *
					FROM (SELECT DISTINCT
							p.jenis_kunjungan,
							k.id              AS kunj_id,
							DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,
							k.bpjs_tipe_bayar,
							mp.no_rm,
							mp.nama,
							mp.alamat,
							IFNULL(kso.id,kso_p.id) AS kso_id,
							IFNULL(kso.nama,kso_p.nama) AS kso,
							mu.nama           AS nmUnit,
							mu.inap,
							k.renc_bpjs,
							k.pulang
						  FROM (select * FROM b_kunjungan where cabang_id = '{$cabang}') k
							INNER JOIN b_ms_pasien mp
							  ON mp.id = k.pasien_id
							INNER JOIN b_pelayanan p
							  ON k.id = p.kunjungan_id
							left JOIN b_tindakan t
							  ON t.pelayanan_id = p.id
							left JOIN b_ms_kso kso
							  ON kso.id = t.kso_id
							LEFT JOIN b_ms_kso kso_p 
							  ON kso_p.id = p.kso_id 
							INNER JOIN b_ms_unit mu
							  ON mu.id = p.unit_id
							WHERE k.pulang = 0
							  AND (mp.nama LIKE '$kataKunci%'
									OR mp.no_rm = '$kataKunci') AND p.flag = '$flag'
						  ORDER BY k.tgl DESC, mu.inap DESC) AS gab
					GROUP BY gab.kunj_id
					ORDER BY gab.tgl DESC";
			}elseif($status=="all"){
				$sql="SELECT *
					FROM (SELECT DISTINCT
							p.jenis_kunjungan,
							k.id              AS kunj_id,
							DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,
							k.bpjs_tipe_bayar,
							mp.no_rm,
							mp.nama,
							mp.alamat,
							IFNULL(kso.id,kso_p.id) AS kso_id,
							IFNULL(kso.nama,kso_p.nama) AS kso,
							mu.nama           AS nmUnit,
							mu.inap,
							k.renc_bpjs,
							k.pulang
						  FROM (select * FROM b_kunjungan where cabang_id = '{$cabang}') k
							INNER JOIN b_ms_pasien mp
							  ON mp.id = k.pasien_id
							INNER JOIN b_pelayanan p
							  ON k.id = p.kunjungan_id
							left JOIN b_tindakan t
							  ON t.pelayanan_id = p.id
							LEFT JOIN b_ms_kso kso
							  ON kso.id = t.kso_id
							LEFT JOIN b_ms_kso kso_p 
							  ON kso_p.id = p.kso_id 
							INNER JOIN b_ms_unit mu
							  ON mu.id = p.unit_id
						  WHERE k.pulang = 1
							  AND (mp.nama LIKE '$kataKunci%'
									OR mp.no_rm = '$kataKunci') AND p.flag = '$flag'
						  ORDER BY k.tgl DESC, mu.inap DESC) AS gab
					GROUP BY gab.kunj_id
					ORDER BY gab.tgl DESC";
			}
			//echo $sql.";<br/>";
			$rs=mysql_query($sql);
            $i=1;
            while($rw=mysql_fetch_array($rs)){
				$jenis_kunjungan=$rw['jenis_kunjungan'];
				$fJenisKunjungan="AND p.jenis_kunjungan='".$jenis_kunjungan."'";
				$fJenisKunjungan2="AND b.jenis_kunjungan='".$jenis_kunjungan."'";
				$sudah_pulang=$rw['pulang'];
				
				$selisih_lebih_kurang=0;
				$bObat=0;
				$sisaObat=0;
				$jaminan=0;
				$kurang=0;
				$ksoid=$rw['kso_id'];
				$idKSOnew=$rw['kso_id']; //untuk retur OBAT
				$idKunj=$rw['kunj_id'];
				$kso_kelas_id=$rw['kso_kelas_id'];
				$isNaikKelas=0;
				
				$qwe="SELECT t.id FROM b_tindakan t WHERE t.biaya_pasien > 0 AND t.kunjungan_id = '".$idKunj."';";
				//echo $qwe."<br/>";
				$rsQwe=mysql_query($qwe);
				$cekIurKRS=0;
				if(mysql_num_rows($rsQwe)>0){
					$cekIurKRS=1;
				}
	
				$queBayar="SELECT b.jenis_kunjungan FROM b_bayar b WHERE b.kunjungan_id = '".$idKunj."' GROUP BY b.jenis_kunjungan;";
				//echo $queBayar."<br/>";
				$rsQBayar=mysql_query($queBayar);
				$cekSdhByrRJ=0;
				$cekSdhByrRI=0;
				if(mysql_num_rows($rsQBayar)>0){
					while($rwQBayar=mysql_fetch_array($rsQBayar)){
						if($rwQBayar['jenis_kunjungan']!=3){
							if($jenis_kunjungan!=3){
								$cekSdhByrRJ=1;
							}
						}else{
							if($jenis_kunjungan==3){
								$cekSdhByrRI=1;
							}
						}
					}
				}
				//echo $cekSdhByrRJ."<br/>".$cekSdhByrRI."<br/>";	
				//Kasir loket pendaftaran
				if($kasir==127){					
					$umum_stlh_krs2 = " ";	
					if($cekIurKRS==1){
						$umum_stlh_krs2 = " AND t._krs<>1 ";
					}else if($cekSdhByrRJ==1){
						$umum_stlh_krs2 = " AND t._krs<>1 ";
					}
					
					$sqlTin="select 
							IFNULL(sum(t.biaya*t.qty),0) as total,
							IFNULL(sum(t.biaya_kso*t.qty),0) as dijamin
							from b_tindakan t
							inner join b_pelayanan p on t.pelayanan_id=p.id
							where 
							p.kunjungan_id='".$rw['kunj_id']."'
							AND t.ms_tindakan_kelas_id IN (7513)
							$umum_stlh_krs2
							AND t.kso_id='".$ksoid."'";
					$qTind=mysql_query($sqlTin);
					$rwTind=mysql_fetch_array($qTind);
					
					$sql="SELECT 
						IFNULL(SUM(b.titipan-b.titipan_terpakai),0) AS titip 
						FROM b_bayar b 
						WHERE 
						b.kunjungan_id='".$rw['kunj_id']."'
						AND b.kso_id='".$ksoid."'
						AND b.tipe=1";
					$rsTitip=mysql_query($sql);
					$rwTitip=mysql_fetch_array($rsTitip);
					
					$sBayar="SELECT 
						IFNULL(SUM(b.nilai+b.titipan),0) AS bayar 
						FROM b_bayar b 
						WHERE 
						b.kunjungan_id='".$rw['kunj_id']."'
						AND b.kso_id='".$ksoid."'
						AND b.tipe=0";
					$rsBayar=mysql_query($sBayar);
					$rwBayar=mysql_fetch_array($rsBayar);
					
					$total=$rwTind['total']-$rwTind['dijamin'];
					$jaminan=0;
					$bayar=$rwBayar['bayar']; 
					$titipan=$rwTitip['titip'];
					$kurang=$total-$jaminan-$bayar-$titipan;
				}
				//Kasir selain loket pendaftaran
				else
				{
					if ($ksoid==$idKsoBPJS){
						//cek hak kelas
						$sHakKelas="SELECT id,level,nama FROM (
									SELECT  
									mk.id,
									mk.nama,
									mk.level
									FROM b_pelayanan p
									INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
									INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
									INNER JOIN b_ms_kso kso ON kso.id=t.kso_id
									inner join b_ms_kelas mk ON mk.id=t.kso_kelas_id
									WHERE 
									p.kunjungan_id='".$rw['kunj_id']."' 
									AND kso.id=6
									UNION
									SELECT  
									mk.id,
									mk.nama,
									mk.level
									FROM b_pelayanan p
									INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
									INNER JOIN b_ms_kso kso ON kso.id=tk.kso_id
									inner join b_ms_kelas mk ON mk.id=tk.kso_kelas_id
									WHERE 
									p.kunjungan_id='".$rw['kunj_id']."'
									AND kso.id=6) AS tblhakkelas ORDER BY level DESC LIMIT 1";
						//echo $sHakKelas."<br/>";
						$qHakKelas=mysql_query($sHakKelas);
						$rwHakKelas=mysql_fetch_array($qHakKelas);
						$kso_kelas_id=$rwHakKelas['id'];
						$kso_kelas_id_level=$rwHakKelas['level'];
						//cek naik kelas
						$sqlCekNaikKelas="SELECT id,level,nama,tipe FROM (
											SELECT  
											mk.id,
											mk.nama,
											mk.level,
											mk.tipe
											FROM b_pelayanan p
											INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
											INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
											INNER JOIN b_ms_tindakan_kelas mtk ON mtk.id=t.ms_tindakan_kelas_id
											INNER JOIN b_ms_kso kso ON kso.id=t.kso_id
											inner join b_ms_kelas mk ON mk.id=t.kelas_id
											WHERE p.kunjungan_id='".$rw['kunj_id']."' 
											AND kso.id=6
											AND mk.tipe<>1
											UNION
											SELECT  
											mk.id,
											mk.nama,
											mk.level,
											mk.tipe
											FROM b_pelayanan p
											INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
											INNER JOIN b_ms_kso kso ON kso.id=tk.kso_id
											inner join b_ms_kelas mk ON mk.id=tk.kelas_id
											WHERE p.kunjungan_id='".$rw['kunj_id']."'
											AND kso.id=6
											AND mk.tipe<>1) AS tbl ORDER BY level DESC LIMIT 1";
						//echo $sqlCekNaikKelas.";<br/>";
						$rsCekNaikKelas=mysql_query($sqlCekNaikKelas);
						//naik kelas
						if (mysql_num_rows($rsCekNaikKelas)>0){
							while ($rwNaikKelas=mysql_fetch_array($rsCekNaikKelas)){
								$ckelas=$rwNaikKelas["id"];
								$ckelas_level=$rwNaikKelas["level"];
								
								//echo "naik".$rwNaikKelas["tipe"]."MULAI".$ckelas_level."level".$kso_kelas_id_level."---SWT---";
								
								if($rwNaikKelas["tipe"]=='2'){
									$isNaikKelas=2;
								}
								else{
									if($ckelas_level>$kso_kelas_id_level){
										$isNaikKelas=1;
										//echo "YUHUX";
									}//else{ echo "YUHUT"; }
								}
							}
							//echo "isNaikKelas=".$isNaikKelas."<br>";
						}
						//cek jika pavilyun HCU --> naik kelas pavilyun
						else{
							$sqlCekNaikKelas="SELECT id,level,nama,tipe FROM (
												SELECT  
												mk.id,
												mk.nama,
												mk.level,
												mk.tipe
												FROM b_pelayanan p
												INNER JOIN b_ms_unit mu ON p.unit_id=mu.id 
												INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
												INNER JOIN b_ms_tindakan_kelas mtk ON mtk.id=t.ms_tindakan_kelas_id
												INNER JOIN b_ms_kso kso ON kso.id=t.kso_id
												inner join b_ms_kelas mk ON mk.id=t.kelas_id
												WHERE p.kunjungan_id='".$rw['kunj_id']."' 
												AND kso.id=6
												AND p.unit_id='$idPavilyunHCU'
												UNION
												SELECT  
												mk.id,
												mk.nama,
												mk.level,
												mk.tipe
												FROM b_pelayanan p
												INNER JOIN b_tindakan_kamar tk ON p.id=tk.pelayanan_id
												INNER JOIN b_ms_kso kso ON kso.id=tk.kso_id
												inner join b_ms_kelas mk ON mk.id=tk.kelas_id
												WHERE p.kunjungan_id='".$rw['kunj_id']."'
												AND kso.id=6
												AND p.unit_id='$idPavilyunHCU') AS tbl ORDER BY level DESC LIMIT 1";
							//echo $sqlCekNaikKelas.";<br/>";
							$rsCekNaikKelas=mysql_query($sqlCekNaikKelas);
							if (mysql_num_rows($rsCekNaikKelas)>0){
								$rwNaikKelas=mysql_fetch_array($rsCekNaikKelas);
								$ckelas=$rwNaikKelas["id"];
								$ckelas_level=$rwNaikKelas["level"];
								$isNaikKelas=2;									
								//echo "naik".$rwNaikKelas["tipe"]."MULAI".$ckelas_level."level".$kso_kelas_id_level."---SWT---";
							}
						}
						//cek grouper
						if ($jenis_kunjungan==3){
							$sqlGrouper="SELECT * FROM b_inacbg_grouper WHERE kunjungan_id_group='".$rw['kunj_id']."'";
							//echo $sqlGrouper.";<br/>";
							$rsGrouper=mysql_query($sqlGrouper);
							$hasil_grouper=0;
							if (mysql_num_rows($rsGrouper)>0){
								$rwGrouper=mysql_fetch_array($rsGrouper);
								$hasil_grouper=$rwGrouper['biaya_kso'];
							}
						}
						//cek sisa titipan
						$sql="SELECT 
							IFNULL(SUM(b.titipan-b.titipan_terpakai),0) AS titip 
							FROM b_bayar b 
							WHERE 
							b.kunjungan_id='".$rw['kunj_id']."' 
							/*AND b.jenis_kunjungan='".$jenis_kunjungan."'*/
							AND b.kso_id='".$ksoid."'
							AND b.tipe=1";
						//echo $sql.";<br/>";
						$rsTitip=mysql_query($sql);
						$rwTitip=mysql_fetch_array($rsTitip);
						//cek total bayar+titipan
						$sBayar="SELECT 
							IFNULL(SUM(b.nilai+b.titipan),0) AS bayar, b.no_kwitansi, id 
							FROM b_bayar b 
							WHERE 
							b.kunjungan_id='".$rw['kunj_id']."'
							/*AND b.jenis_kunjungan='".$jenis_kunjungan."'*/
							AND b.kso_id='".$ksoid."'
							AND b.tipe=0";
						//echo $sBayar.";<br/>";
						$rsBayar=mysql_query($sBayar);
						$rwBayar=mysql_fetch_array($rsBayar);
						//cek bayar obat dari kasir billing
						$sBayarO="SELECT 
								SUM(IFNULL(b.bayar,0)) AS bayar 
								FROM $dbapotek.a_kredit_utang b 
								WHERE 
								b.BILLING_BAYAR_OBAT_ID='".$rwBayar['id']."'
								AND b.NO_BAYAR = '".$rwBayar['no_kwitansi']."'
								AND b.IS_AKTIF='0'
								GROUP BY b.NO_BAYAR";
						//echo $sBayarO."<br/>---------444------<br />";
						$rsBayarO=mysql_query($sBayarO);
						$rwBayarO=mysql_fetch_array($rsBayarO);
				
						//echo $isNaikKelas."<br>";
						$kelBPJSnew=0;
						//naik kelas
						//echo "jkunj=$jenis_kunjungan, naikKelas=$isNaikKelas"."<br>";
						if ($isNaikKelas==1){
							$kelBPJSnew=1;
							$fJK="/*AND b_pelayanan.jenis_kunjungan = ".$jenis_kunjungan."*/";
							//$fJK="";
							if($jenis_kunjungan<>'3'){
								$fJK2="/*AND b.jenis_kunjungan = ".$jenis_kunjungan."*/";
							}
							
							$msgObat = "";
							
							$sNaekKlsObat="SELECT
									
									  
									  SUM(ap.QTY_JUAL * ap.HARGA_SATUAN) +
									  
									   FLOOR(
									  		(ap.PPN/100) *  SUM(ap.QTY_JUAL * ap.HARGA_SATUAN)
										  	)
											
									  AS SUBTOTAL,
									  
									   ap.DOKTER, ap.UTANG,
									   
									   IF(ap.DIJAMIN=0,SUM(IF(ap.CARA_BAYAR=2,(ap.QTY_JUAL * ap.HARGA_SATUAN),0)),'0') + 
									   (FLOOR(ap.PPN/100) * IF(ap.DIJAMIN=0,SUM(IF(ap.CARA_BAYAR=2,(ap.QTY_JUAL * ap.HARGA_SATUAN),0)),'0'))
									   
									   AS JAMINANOBAT,
									   
									   b_pelayanan.id as pel_id
									  ,ap.ID AS idpenjualan, ap.NO_PENJUALAN, ap.UNIT_ID, ap.NO_KUNJUNGAN, ap.NO_PASIEN
									FROM
									  $dbapotek.a_penjualan ap 
									  INNER JOIN b_pelayanan 
										ON ap.NO_KUNJUNGAN = b_pelayanan.id
									  INNER JOIN b_ms_unit 
										ON b_ms_unit.id = b_pelayanan.unit_id
									  INNER JOIN b_ms_unit b_ms_unit_asal 
										ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
									  INNER JOIN $dbapotek.a_mitra am 
										ON am.IDMITRA=ap.KSO_ID
									  INNER JOIN b_ms_kso kso 
										ON kso.id=b_pelayanan.kso_id
									  INNER JOIN b_kunjungan
										ON b_kunjungan.id = b_pelayanan.kunjungan_id
									  LEFT JOIN b_ms_kelas k ON k.id=b_pelayanan.kelas_id
									  INNER JOIN b_ms_kelas hk ON hk.id=b_kunjungan.kso_kelas_id 
									WHERE 
									b_pelayanan.kunjungan_id = '".$rw['kunj_id']."'
									$fJK
									AND kso.id = 6
									AND ap.CARA_BAYAR=2
									AND ap.KRONIS<>2
									and ap.DIJAMIN=0
									GROUP BY ap.NO_PENJUALAN, ap.USER_ID";
							//echo $sNaekKlsObat."<br/><br/>";
							$obtPavTmbhn=0;
							$sisaFarm=0;
							$qNaekKlsObat=mysql_query($sNaekKlsObat);
							while($rwNaekKlsObat=mysql_fetch_array($qNaekKlsObat)){
							
								$queByr = "SELECT b.tgl_act AS TGL_BAYAR FROM b_bayar b WHERE b.kunjungan_id = '".$idKunj."' AND b.kso_id = '".$idKSOnew."' ORDER BY b.id DESC";
								//echo $queByr."<br/><br/>";
								$dByr = mysql_fetch_array(mysql_query($queByr));
								
								//awal query cek retur
								$sRetur="SELECT SUM(a.QTY_RETUR) QTY,
								 
								SUM(a.QTY_RETUR * a.HARGA_SATUAN) +
								
								FLOOR(
										(a.PPN/100) *  SUM(a.QTY_RETUR * a.HARGA_SATUAN)
									 )
								
								AS SUBTOTAL, 
								SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0)) +  
								
								(FLOOR(a.PPN/100) * SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0)))
								AS DIJAMIN,
								
									b.TGL_BAYAR, c.tgl_retur, DATEDIFF(c.tgl_retur,b.TGL_BAYAR) AS cek, IF(TIMEDIFF(c.tgl_retur,'".$dByr['TGL_BAYAR']."')>0,'1','0') AS DiffDate,
									IF(a.DIJAMIN=0,SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0)),'0') +
									
									 FLOOR(
									 (a.PPN/100)*IF(a.DIJAMIN=0,SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0)),'0')
									 )
									
									AS JAMINANOBAT
									FROM $dbapotek.a_penjualan a
									LEFT JOIN $dbapotek.a_kredit_utang b ON a.NO_PENJUALAN = b.FK_NO_PENJUALAN AND a.UNIT_ID = b.UNIT_ID AND a.NO_KUNJUNGAN = b.NO_PELAYANAN AND a.NO_PASIEN = b.NORM
									LEFT JOIN $dbapotek.a_return_penjualan c ON a.ID = c.idpenjualan
									WHERE a.NO_PENJUALAN = '".$rwNaekKlsObat['NO_PENJUALAN']."' AND a.UNIT_ID = '".$rwNaekKlsObat['UNIT_ID']."' AND a.NO_KUNJUNGAN = '".$rwNaekKlsObat['pel_id']."' AND a.NO_PASIEN = '".$rwNaekKlsObat['NO_PASIEN']."' ";
								//echo $sRetur."<br/>";
								$qRetur=mysql_query($sRetur);
								$rwRetur=mysql_fetch_array($qRetur);
								if($rwRetur['DiffDate']==0){
									$subtotObat=$rwNaekKlsObat['SUBTOTAL']-$rwRetur['SUBTOTAL'];
									//$dijaminObt=$rwRJRDObat['DIJAMIN']-$rwRetur['DIJAMIN'];
									//$qtyObt=$rwRJRDObat['QTY']-$rwRetur['QTY'];
									$jminanObt=$rwNaekKlsObat['JAMINANOBAT']-$rwRetur['JAMINANOBAT'];
									$rrr=0;
								}else{
									$subtotObat=$rwNaekKlsObat['SUBTOTAL'];
									//$dijaminObt=$rwRJRDObat['DIJAMIN'];
									//$qtyObt=$rwRJRDObat['QTY'];
									$jminanObt=$rwNaekKlsObat['JAMINANOBAT'];
									$rrr=1;
								}
								//akhir query cek retur
							
								$obtPavTmbhn+=$jminanObt;//$rwNaekKlsObat['JAMINANOBAT'];
							
								if($rwNaekKlsObat['UTANG'] > 0){
									$msgObat.=$rwNaekKlsObat['NO_PENJUALAN']."-**-".$subtotObat."-**-".$rwNaekKlsObat['DOKTER']."-**-".$rwNaekKlsObat['pel_id']."***";
									$sisaFarm+=$subtotObat;//$rwNaekKlsObat['SUBTOTAL'];
								}
							
							}
							
							$total=$rwGrouper['biaya_px']+$obtPavTmbhn;
							$jaminan=0;
							$titipan=$rwTitip['titip'];
							$bayar=$rwBayar['bayar'];
							$kurang=$total-$jaminan-$titipan-$bayar;
							$selisih_lebih_kurang=$total-$jaminan-$titipan-$bayar;
						}
						//naik ke pavilyun
						elseif ($isNaikKelas==2){
							$kelBPJSnew=2;
							//echo "jkunj=$jenis_kunjungan"."<br>";
							/* ============================ CEK TIPE BAYAR BPJS ============================= */
							$sTipeBayar="select bpjs_tipe_bayar from b_kunjungan where id='".$rw['kunj_id']."'";
							$qTipeBayar=mysql_query($sTipeBayar);
							$rwTipeBayar=mysql_fetch_array($qTipeBayar);
							$TipeBayar=$rwTipeBayar['bpjs_tipe_bayar'];
							
							$totBiayaPaviliun_BPJS=0;
							$totBiayaPaviliun_BPJS_UMUM=0;
							
							$totBiayaPaviliun_BPJS_bayar=0;
							$totBiayaPaviliun_BPJS_UMUM_bayar=0;
							$msgObat = "";
							//echo "TipeBayar=".$TipeBayar."<br>";
							if ($TipeBayar==1){
								$umum_stlh_krs = " ";
								if($cekIurKRS==1){
									$umum_stlh_krs = " AND b_tindakan._krs<>1 ";
								}else if($kelBPJSnew==2){
									$umum_stlh_krs = " AND b_tindakan._krs<>1 ";
								}else if($cekSdhByrRJ==1){
									$umum_stlh_krs = " AND b_tindakan._krs<>1 ";
								}
					
								$sPavU="SELECT 
										  SUM(nilai) AS total,
										  SUM(bayar) AS bayar
										FROM
										  (SELECT
											1,  
											SUM(tbl_tindakan.biaya) AS nilai,
											SUM(tbl_tindakan.bayar) AS bayar											
										  FROM
											(SELECT 
											(b_tindakan.qty*b_tindakan.biaya) AS biaya,
											(b_tindakan.bayar) as bayar
											FROM
											  b_pelayanan  
											  INNER JOIN b_tindakan 
												ON b_tindakan.pelayanan_id = b_pelayanan.id
											  INNER JOIN b_ms_unit 
												ON b_ms_unit.id = b_pelayanan.unit_id
											  INNER JOIN b_ms_unit b_ms_unit_asal 
												ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
											  INNER JOIN b_ms_kelas mk 
												ON mk.id = b_pelayanan.kelas_id
											WHERE 
											b_pelayanan.kunjungan_id = '".$rw['kunj_id']."'
											/*AND b_pelayanan.jenis_kunjungan = '".$jenis_kunjungan."'*/
											AND b_tindakan.kso_id = 6
											AND mk.tipe = 2 $umum_stlh_krs
											) AS tbl_tindakan 
										  UNION
										  SELECT
											2,  
											SUM(kmr.biaya) AS nilai,
											SUM(kmr.bayar) AS bayar
										  FROM
											(SELECT
											  IF(b_tindakan_kamar.status_out = 0, 
											  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 1, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)+1) * (b_tindakan_kamar.tarip), 
											  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 0, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)+1) * (b_tindakan_kamar.tarip)) biaya,
											  b_tindakan_kamar.bayar as bayar
											FROM
											  b_tindakan_kamar 
											  INNER JOIN b_pelayanan 
												ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
											  INNER JOIN b_ms_unit 
												ON b_ms_unit.id = b_pelayanan.unit_id
											  INNER JOIN b_ms_unit b_ms_unit_asal 
												ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
											  INNER JOIN b_ms_kelas mk 
												ON mk.id = b_pelayanan.kelas_id 
											WHERE 
											b_pelayanan.kunjungan_id = '".$rw['kunj_id']."'
											/*AND b_pelayanan.jenis_kunjungan = '".$jenis_kunjungan."'*/
											AND b_tindakan_kamar.kso_id = 6 
											AND b_tindakan_kamar.aktif = 1
											AND mk.tipe = 2 
											) AS kmr) AS gab";
								$qPavU=mysql_query($sPavU);
								$rwPavU=mysql_fetch_array($qPavU);
								$totBiayaPaviliun_BPJS_UMUM+=$rwPavU['total'];
								$totBiayaPaviliun_BPJS_UMUM_bayar+=$rwPavU['bayar'];								
								
								$sPavObatU="SELECT
										  
										  (ap.QTY_JUAL * ap.HARGA_SATUAN) +
										  FLOOR(
									  				(ap.PPN/100) *  ((ap.QTY_JUAL) * ap.HARGA_SATUAN)
										  		)
										  
										   AS SUBTOTAL, 
										   ap.DOKTER, ap.NO_PENJUALAN,
										   
										   IF(ap.DIJAMIN=0,(IF(ap.CARA_BAYAR=2,(ap.QTY_JUAL * ap.HARGA_SATUAN),0)),'0')+
										   FLOOR(
										   (ap.PPN/100)* IF(ap.DIJAMIN=0,(IF(ap.CARA_BAYAR=2,(ap.QTY_JUAL * ap.HARGA_SATUAN),0)),'0')
										   )
										  
										   AS JAMINANOBAT
										  ,ap.ID AS idpenjualan
										FROM
										  $dbapotek.a_penjualan ap 
										  INNER JOIN b_pelayanan 
											ON ap.NO_KUNJUNGAN = b_pelayanan.id
										  INNER JOIN b_ms_unit 
											ON b_ms_unit.id = b_pelayanan.unit_id
										  INNER JOIN b_ms_unit b_ms_unit_asal 
											ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
										  INNER JOIN $dbapotek.a_mitra am 
											ON am.IDMITRA=ap.KSO_ID
										  INNER JOIN b_ms_kso kso 
											ON kso.id=b_pelayanan.kso_id
										  INNER JOIN b_kunjungan
											ON b_kunjungan.id = b_pelayanan.kunjungan_id
										  INNER JOIN b_ms_kelas k 
											ON k.id=b_pelayanan.kelas_id
										WHERE 
										b_pelayanan.kunjungan_id = '".$rw['kunj_id']."'
										/*AND b_pelayanan.jenis_kunjungan = '".$jenis_kunjungan."'*/
										AND kso.id = 6
										AND k.tipe=2
										AND ap.CARA_BAYAR=2
										AND ap.KRONIS<>2";
								//echo $sPavObatU."<br/>";
								$subTotal=0;
								$qPavObatU=mysql_query($sPavObatU);
								while($rwPavObatU=mysql_fetch_array($qPavObatU)){
								
									$queByr = "SELECT b.tgl_act AS TGL_BAYAR FROM b_bayar b WHERE b.kunjungan_id = '".$idKunj."' AND b.kso_id = '".$idKSOnew."' ORDER BY b.id DESC";
									//echo $queByr."<br/><br/>";
									$dByr = mysql_fetch_array(mysql_query($queByr));
									
									//awal query cek retur
									$sRetur="SELECT SUM(a.QTY_RETUR) QTY, 
									
									SUM(a.QTY_RETUR * a.HARGA_SATUAN)+
									
									FLOOR(
									  		(a.PPN/100) *  SUM((a.QTY_RETUR) * a.HARGA_SATUAN)
										  )
									
									AS SUBTOTAL, 
									SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0)) + 
									
									FLOOR(
									
									(a.PPN/100) *SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0))
									
									)
									
									AS DIJAMIN,
									
									
										b.TGL_BAYAR, c.tgl_retur, DATEDIFF(c.tgl_retur,b.TGL_BAYAR) AS cek, IF(TIMEDIFF(c.tgl_retur,'".$dByr['TGL_BAYAR']."')>0,'1','0') AS DiffDate,
										IF(a.DIJAMIN=0,SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0)),'0') +
										FLOOR(
										(a.PPN/100) * IF(a.DIJAMIN=0,SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0)),'0')
										)
										
										AS JAMINANOBAT
										FROM $dbapotek.a_penjualan a
										LEFT JOIN $dbapotek.a_kredit_utang b ON a.NO_PENJUALAN = b.FK_NO_PENJUALAN AND a.UNIT_ID = b.UNIT_ID AND a.NO_KUNJUNGAN = b.NO_PELAYANAN AND a.NO_PASIEN = b.NORM
										LEFT JOIN $dbapotek.a_return_penjualan c ON a.ID = c.idpenjualan
										WHERE a.ID = '".$rwPavObatU['idpenjualan']."' ";
									//echo $sRetur."<br/>";
									$qRetur=mysql_query($sRetur);
									$rwRetur=mysql_fetch_array($qRetur);
									if($rwRetur['DiffDate']==0){
										$subtotObat=$rwPavObatU['SUBTOTAL']-$rwRetur['SUBTOTAL'];
										//$dijaminObt=$rwRJRDObat['DIJAMIN']-$rwRetur['DIJAMIN'];
										//$qtyObt=$rwRJRDObat['QTY']-$rwRetur['QTY'];
										//$jminanObt=$rwPavObatU['JAMINANOBAT']-$rwRetur['JAMINANOBAT'];
										$rrr=0;
									}else{
										$subtotObat=$rwPavObatU['SUBTOTAL'];
										//$dijaminObt=$rwRJRDObat['DIJAMIN'];
										//$qtyObt=$rwRJRDObat['QTY'];
										//$jminanObt=$rwPavObatU['JAMINANOBAT'];
										$rrr=1;
									}
									//akhir query cek retur
								
									//$totBiayaPaviliun_BPJS_UMUM+=$rwPavObatU['SUBTOTAL'];	
									$subTotal+=$subtotObat;//$rwPavObatU['SUBTOTAL'];
									//$obtPavTmbhn=$rwPavObatU['JAMINANOBAT'];
								}
								
								
								
								$sPavObatUw="SELECT
										 
										  (ap.QTY_JUAL * ap.HARGA_SATUAN) +
										  
										  FLOOR(
									  		(ap.PPN/100) * ((ap.QTY_JUAL) * ap.HARGA_SATUAN)
										  	)
										  
										  AS SUBTOTAL, 
										  
										  ap.DOKTER, ap.NO_PENJUALAN,
										  IF(ap.DIJAMIN=0,(IF(ap.CARA_BAYAR=2,(ap.QTY_JUAL * ap.HARGA_SATUAN),0)),'0')+
										  FLOOR((ap.PPN/100)* IF(ap.DIJAMIN=0,(IF(ap.CARA_BAYAR=2,(ap.QTY_JUAL * ap.HARGA_SATUAN),0)),'0'))
										  AS JAMINANOBAT
										FROM
										  $dbapotek.a_penjualan ap 
										  INNER JOIN b_pelayanan 
											ON ap.NO_KUNJUNGAN = b_pelayanan.id
										  INNER JOIN b_ms_unit 
											ON b_ms_unit.id = b_pelayanan.unit_id
										  INNER JOIN b_ms_unit b_ms_unit_asal 
											ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
										  INNER JOIN $dbapotek.a_mitra am 
											ON am.IDMITRA=ap.KSO_ID
										  INNER JOIN b_ms_kso kso 
											ON kso.id=b_pelayanan.kso_id
										  INNER JOIN b_kunjungan
											ON b_kunjungan.id = b_pelayanan.kunjungan_id
										  INNER JOIN b_ms_kelas k 
											ON k.id=b_pelayanan.kelas_id
										WHERE 
										b_pelayanan.kunjungan_id = '".$rw['kunj_id']."'
										/*AND b_pelayanan.jenis_kunjungan = '".$jenis_kunjungan."'*/
										AND kso.id = 6
										AND k.tipe=2
										AND ap.CARA_BAYAR=2
										AND ap.KRONIS<>2
										AND ap.DIJAMIN = 0";
								//echo $sPavObatUw."<br/>";
								$subTotal3=0;
								$obtPavTmbhn=0;
								$qPavObatUw=mysql_query($sPavObatUw);
								while($rwPavObatUw=mysql_fetch_array($qPavObatUw)){
								
									$queByr = "SELECT b.tgl_act AS TGL_BAYAR FROM b_bayar b WHERE b.kunjungan_id = '".$idKunj."' AND b.kso_id = '".$idKSOnew."' ORDER BY b.id DESC";
									//echo $queByr."<br/><br/>";
									$dByr = mysql_fetch_array(mysql_query($queByr));
									
									//awal query cek retur
									$sRetur="SELECT SUM(a.QTY_RETUR) QTY,
									SUM(a.QTY_RETUR * a.HARGA_SATUAN)+
									FLOOR(
									  		(a.PPN/100) *  SUM((a.QTY_RETUR) * a.HARGA_SATUAN)
										  )
									AS SUBTOTAL, 
									SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0))+
									FLOOR(
									  		(a.PPN/100) *  SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0))
										  )
									AS DIJAMIN,
										b.TGL_BAYAR, c.tgl_retur, DATEDIFF(c.tgl_retur,b.TGL_BAYAR) AS cek, IF(TIMEDIFF(c.tgl_retur,'".$dByr['TGL_BAYAR']."')>0,'1','0') AS DiffDate,
									IF(a.DIJAMIN=0,SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0)),'0')+
									FLOOR(
									  		(a.PPN/100) *  IF(a.DIJAMIN=0,SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0)),'0')
										  )
									AS JAMINANOBAT
										FROM $dbapotek.a_penjualan a
										LEFT JOIN $dbapotek.a_kredit_utang b ON a.NO_PENJUALAN = b.FK_NO_PENJUALAN AND a.UNIT_ID = b.UNIT_ID AND a.NO_KUNJUNGAN = b.NO_PELAYANAN AND a.NO_PASIEN = b.NORM
										LEFT JOIN $dbapotek.a_return_penjualan c ON a.ID = c.idpenjualan
										WHERE a.ID = '".$rwPavObatUw['idpenjualan']."' ";
									//echo $sRetur."<br/>";
									$qRetur=mysql_query($sRetur);
									$rwRetur=mysql_fetch_array($qRetur);
									if($rwRetur['DiffDate']==0){
										$subtotObat=$rwPavObatUw['SUBTOTAL']-$rwRetur['SUBTOTAL'];
										//$dijaminObt=$rwRJRDObat['DIJAMIN']-$rwRetur['DIJAMIN'];
										//$qtyObt=$rwRJRDObat['QTY']-$rwRetur['QTY'];
										$jminanObt=$rwPavObatUw['JAMINANOBAT']-$rwRetur['JAMINANOBAT'];
										$rrr=0;
									}else{
										$subtotObat=$rwPavObatUw['SUBTOTAL'];
										//$dijaminObt=$rwRJRDObat['DIJAMIN'];
										//$qtyObt=$rwRJRDObat['QTY'];
										$jminanObt=$rwPavObatUw['JAMINANOBAT'];
										$rrr=1;
									}
									//akhir query cek retur
								
									//$totBiayaPaviliun_BPJS_UMUM+=$rwPavObatU['SUBTOTAL'];	
									$subTotal3+=$subtotObat;//$rwPavObatUw['SUBTOTAL'];
									$obtPavTmbhn+=$jminanObt;//$rwPavObatUw['JAMINANOBAT'];
								}
								
								
								$sPavObatU2="SELECT
										  SUM(ap.QTY_JUAL * ap.HARGA_SATUAN)+
										  FLOOR(
									  				(ap.PPN/100) *  SUM((ap.QTY_JUAL) * ap.HARGA_SATUAN)
										  		)
										  AS SUBTOTAL,
										  ap.DOKTER, ap.UTANG, b_pelayanan.id as pel_id,
										  ap.ID AS idpenjualan, ap.NO_PENJUALAN, ap.UNIT_ID, ap.NO_KUNJUNGAN, ap.NO_PASIEN
										FROM
										  $dbapotek.a_penjualan ap 
										  INNER JOIN b_pelayanan 
											ON ap.NO_KUNJUNGAN = b_pelayanan.id
										  INNER JOIN b_ms_unit 
											ON b_ms_unit.id = b_pelayanan.unit_id
										  INNER JOIN b_ms_unit b_ms_unit_asal 
											ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
										  INNER JOIN $dbapotek.a_mitra am 
											ON am.IDMITRA=ap.KSO_ID
										  INNER JOIN b_ms_kso kso 
											ON kso.id=b_pelayanan.kso_id
										  INNER JOIN b_kunjungan
											ON b_kunjungan.id = b_pelayanan.kunjungan_id
										  INNER JOIN b_ms_kelas k 
											ON k.id=b_pelayanan.kelas_id
										WHERE 
										b_pelayanan.kunjungan_id = '".$rw['kunj_id']."'
										/*AND b_pelayanan.jenis_kunjungan = '".$jenis_kunjungan."'*/
										AND kso.id = 6
										AND k.tipe=2
										AND ap.CARA_BAYAR=2
										AND ap.KRONIS<>2
										AND ap.DIJAMIN = 0
										GROUP BY ap.NO_PENJUALAN, ap.USER_ID";
								$qPavObatU2=mysql_query($sPavObatU2);
								$totalTiapResep=0;
								$sisaFarm=0;
								while($rwPavObatU2=mysql_fetch_array($qPavObatU2)){
									
									$queByr = "SELECT b.tgl_act AS TGL_BAYAR FROM b_bayar b WHERE b.kunjungan_id = '".$idKunj."' AND b.kso_id = '".$idKSOnew."' ORDER BY b.id DESC";
									//echo $queByr."<br/><br/>";
									$dByr = mysql_fetch_array(mysql_query($queByr));
									
									//awal query cek retur
									$sRetur="SELECT SUM(a.QTY_RETUR) QTY, 
									SUM(a.QTY_RETUR * a.HARGA_SATUAN)+
									FLOOR(
									  		(a.PPN/100) *  SUM((a.QTY_RETUR) * ap.HARGA_SATUAN)
										  )
									AS SUBTOTAL,
									SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0))+
									FLOOR(
									  		(a.PPN/100) *  SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0))
										  )
									AS DIJAMIN,
										b.TGL_BAYAR, c.tgl_retur, DATEDIFF(c.tgl_retur,b.TGL_BAYAR) AS cek, IF(TIMEDIFF(c.tgl_retur,'".$dByr['TGL_BAYAR']."')>0,'1','0') AS DiffDate,
									IF(a.DIJAMIN=0,SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0)),'0')+
									FLOOR(
									  		(a.PPN/100) *  IF(a.DIJAMIN=0,SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0)),'0')
										  )
									AS JAMINANOBAT
										FROM $dbapotek.a_penjualan a
										LEFT JOIN $dbapotek.a_kredit_utang b ON a.NO_PENJUALAN = b.FK_NO_PENJUALAN AND a.UNIT_ID = b.UNIT_ID AND a.NO_KUNJUNGAN = b.NO_PELAYANAN AND a.NO_PASIEN = b.NORM
										LEFT JOIN $dbapotek.a_return_penjualan c ON a.ID = c.idpenjualan
										WHERE a.NO_PENJUALAN = '".$rwPavObatU2['NO_PENJUALAN']."' AND a.UNIT_ID = '".$rwPavObatU2['UNIT_ID']."' AND a.NO_KUNJUNGAN = '".$rwPavObatU2['pel_id']."' AND a.NO_PASIEN = '".$rwPavObatU2['NO_PASIEN']."' ";
									//echo $sRetur."<br/>";
									$qRetur=mysql_query($sRetur);
									$rwRetur=mysql_fetch_array($qRetur);
									if($rwRetur['DiffDate']==0){
										$subtotObat=$rwPavObatU2['SUBTOTAL']-$rwRetur['SUBTOTAL'];
										//$dijaminObt=$rwRJRDObat['DIJAMIN']-$rwRetur['DIJAMIN'];
										//$qtyObt=$rwRJRDObat['QTY']-$rwRetur['QTY'];
										//$jminanObt=$rwPavObat['JAMINANOBAT']-$rwRetur['JAMINANOBAT'];
										$rrr=0;
									}else{
										$subtotObat=$rwPavObatU2['SUBTOTAL'];
										//$dijaminObt=$rwRJRDObat['DIJAMIN'];
										//$qtyObt=$rwRJRDObat['QTY'];
										//$jminanObt=$rwPavObat['JAMINANOBAT'];
										$rrr=1;
									}
									//akhir query cek retur
									
									$sisaObat=$rwPavObatU2['UTANG'];
									if($sisaObat>0){
										if($totalTiapResep==0){
											$totalTiapResep = $subtotObat;//$rwPavObatU2['SUBTOTAL'];
										}else{
											if($totalTiapResep > $subtotObat){
												$totalTiapResep = $subtotObat;//$rwPavObatU2['SUBTOTAL'];
											}
										}
									}
									
									if($rwPavObatU2['UTANG'] > 0){
										$msgObat.=$rwPavObatU2['NO_PENJUALAN']."-**-".$subtotObat."-**-".$rwPavObatU2['DOKTER']."-**-".$rwPavObatU2['pel_id']."***";
										$sisaFarm+=$subtotObat;//$rwPavObatU2['SUBTOTAL'];
									}
								}
							}
							else{
								$fJK="";
								$fJK3="/*AND b_pelayanan.jenis_kunjungan = ".$jenis_kunjungan."*/";
								/*if($jenis_kunjungan<>'3'){
									$fJK="AND b_pelayanan.jenis_kunjungan = ".$jenis_kunjungan;
									$fJK2="AND b.jenis_kunjungan = ".$jenis_kunjungan;
								}*/
							
								$umum_stlh_krs = " ";
								if($cekIurKRS==1){
									$umum_stlh_krs = " AND b_tindakan._krs<>1 ";
								}else if($kelBPJSnew==2){
									$umum_stlh_krs = " AND b_tindakan._krs<>1 ";
								}else if($cekSdhByrRJ==1){
									$umum_stlh_krs = " AND b_tindakan._krs<>1 ";
								}
								//echo $fJK."<br>";
								//echo $totBiayaPaviliun_BPJS."<br>";
								$sPav="SELECT 
										  SUM(nilai) AS total,
										  SUM(bayar) AS bayar
										FROM
										  (SELECT
											1,  
											SUM(tbl_tindakan.biaya) AS nilai,
											SUM(tbl_tindakan.bayar) AS bayar
										  FROM
											(SELECT 
											(b_tindakan.qty*b_tindakan.biaya) AS biaya,
											(b_tindakan.bayar) AS bayar
											FROM
											  b_pelayanan  
											  INNER JOIN b_tindakan 
												ON b_tindakan.pelayanan_id = b_pelayanan.id
											  INNER JOIN b_ms_unit 
												ON b_ms_unit.id = b_pelayanan.unit_id
											  INNER JOIN b_ms_unit b_ms_unit_asal 
												ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
											  LEFT JOIN b_ms_kelas mk 
												ON mk.id = b_tindakan.kelas_id
											  INNER JOIN b_ms_kelas hk 
												ON hk.id = b_tindakan.kso_kelas_id
											WHERE 
											b_pelayanan.kunjungan_id = '".$rw['kunj_id']."'
											$fJK $umum_stlh_krs
											AND b_tindakan.kso_id = 6
											) AS tbl_tindakan 
										  UNION
										  SELECT
											2,  
											SUM(kmr.biaya) AS nilai,
											SUM(kmr.bayar) AS bayar											
										  FROM
											(SELECT
											  IF(b_tindakan_kamar.status_out = 0, 
											  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 1, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)+1) * (b_tindakan_kamar.tarip), 
											  IF(DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in) = 0, 0, DATEDIFF(IFNULL(b_tindakan_kamar.tgl_out, NOW()), b_tindakan_kamar.tgl_in)+1) * (b_tindakan_kamar.tarip)) biaya,
											  b_tindakan_kamar.bayar as bayar
											FROM
											  b_tindakan_kamar 
											  INNER JOIN b_pelayanan 
												ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id
											  INNER JOIN b_ms_unit 
												ON b_ms_unit.id = b_pelayanan.unit_id
											  INNER JOIN b_ms_unit b_ms_unit_asal 
												ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
											  INNER JOIN b_ms_kelas mk 
												ON mk.id = b_tindakan_kamar.kelas_id
											  INNER JOIN b_ms_kelas hk 
												ON hk.id = b_tindakan_kamar.kso_kelas_id  
											WHERE 
											b_pelayanan.kunjungan_id = '".$rw['kunj_id']."'
											$fJK
											AND b_tindakan_kamar.kso_id = 6 
											AND b_tindakan_kamar.aktif = 1 
											) AS kmr) AS gab";
								//echo $sPav."<br/>";
								$qPav=mysql_query($sPav);
								$rwPav=mysql_fetch_array($qPav);
								$totBiayaPaviliun_BPJS+=$rwPav['total'];
								$totBiayaPaviliun_BPJS_bayar+=$rwPav['bayar'];
								//echo $totBiayaPaviliun_BPJS."<br>";
								$sPavObat="SELECT
										  (ap.QTY_JUAL * ap.HARGA_SATUAN)+
										  FLOOR(
									  		(ap.PPN/100) * ((ap.QTY_JUAL) * ap.HARGA_SATUAN)
										  	)
										  AS SUBTOTAL,
										  ap.DOKTER, ap.NO_PENJUALAN,
										  IF(ap.DIJAMIN=0,(IF(ap.CARA_BAYAR=2,(ap.QTY_JUAL * ap.HARGA_SATUAN),0)),'0')+
										  FLOOR(
									  		(ap.PPN/100) *   IF(ap.DIJAMIN=0,(IF(ap.CARA_BAYAR=2,(ap.QTY_JUAL * ap.HARGA_SATUAN),0)),'0')
										  	)
										  AS JAMINANOBAT,
										  ap.ID AS idpenjualan
										FROM
										  $dbapotek.a_penjualan ap 
										  INNER JOIN b_pelayanan 
											ON ap.NO_KUNJUNGAN = b_pelayanan.id
										  INNER JOIN b_ms_unit 
											ON b_ms_unit.id = b_pelayanan.unit_id
										  INNER JOIN b_ms_unit b_ms_unit_asal 
											ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
										  INNER JOIN $dbapotek.a_mitra am 
											ON am.IDMITRA=ap.KSO_ID
										  INNER JOIN b_ms_kso kso 
											ON kso.id=b_pelayanan.kso_id
										  INNER JOIN b_kunjungan
											ON b_kunjungan.id = b_pelayanan.kunjungan_id
										  LEFT JOIN b_ms_kelas k ON k.id=b_pelayanan.kelas_id
										  INNER JOIN b_ms_kelas hk ON hk.id=b_kunjungan.kso_kelas_id 
										WHERE 
										b_pelayanan.kunjungan_id = '".$rw['kunj_id']."'
										$fJK
										AND kso.id = 6
										AND ap.CARA_BAYAR=2
										AND ap.KRONIS<>2";
								//echo $sPavObat."<br/><br/>";
								//echo $totBiayaPaviliun_BPJS."<br>";
								$subTotal=0;
								$qPavObat=mysql_query($sPavObat);
								while($rwPavObat=mysql_fetch_array($qPavObat)){
								
									$queByr = "SELECT b.tgl_act AS TGL_BAYAR FROM b_bayar b WHERE b.kunjungan_id = '".$idKunj."' AND b.kso_id = '".$idKSOnew."' ORDER BY b.id DESC";
									//echo $queByr."<br/><br/>";
									$dByr = mysql_fetch_array(mysql_query($queByr));
									
									//awal query cek retur
									$sRetur="SELECT SUM(a.QTY_RETUR) QTY,
									SUM(a.QTY_RETUR * a.HARGA_SATUAN)+
									FLOOR(
									  		(a.PPN/100) *  SUM((a.QTY_RETUR) * a.HARGA_SATUAN)
										 )
									AS SUBTOTAL,
									SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0))+
									FLOOR(
									  		(a.PPN/100) *  SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0))
										 )
									AS DIJAMIN,
										b.TGL_BAYAR, c.tgl_retur, DATEDIFF(c.tgl_retur,b.TGL_BAYAR) AS cek, IF(TIMEDIFF(c.tgl_retur,'".$dByr['TGL_BAYAR']."')>0,'1','0') AS DiffDate,
									IF(a.DIJAMIN=0,SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0)),'0')+
									FLOOR(
									  		(a.PPN/100) *  IF(a.DIJAMIN=0,SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0)),'0')
										 )
									AS JAMINANOBAT
										FROM $dbapotek.a_penjualan a
										LEFT JOIN $dbapotek.a_kredit_utang b ON a.NO_PENJUALAN = b.FK_NO_PENJUALAN AND a.UNIT_ID = b.UNIT_ID AND a.NO_KUNJUNGAN = b.NO_PELAYANAN AND a.NO_PASIEN = b.NORM
										LEFT JOIN $dbapotek.a_return_penjualan c ON a.ID = c.idpenjualan
										WHERE a.ID = '".$rwPavObat['idpenjualan']."' ";
									//echo $sRetur."<br/>";
									$qRetur=mysql_query($sRetur);
									$rwRetur=mysql_fetch_array($qRetur);
									if($rwRetur['DiffDate']==0){
										$subtotObat=$rwPavObat['SUBTOTAL']-$rwRetur['SUBTOTAL'];
										//$dijaminObt=$rwRJRDObat['DIJAMIN']-$rwRetur['DIJAMIN'];
										//$qtyObt=$rwRJRDObat['QTY']-$rwRetur['QTY'];
										//$jminanObt=$rwPavObat['JAMINANOBAT']-$rwRetur['JAMINANOBAT'];
										$rrr=0;
									}else{
										$subtotObat=$rwPavObat['SUBTOTAL'];
										//$dijaminObt=$rwRJRDObat['DIJAMIN'];
										//$qtyObt=$rwRJRDObat['QTY'];
										//$jminanObt=$rwPavObat['JAMINANOBAT'];
										$rrr=1;
									}
									//akhir query cek retur
								
									//$totBiayaPaviliun_BPJS+=$rwPavObat['SUBTOTAL'];
									$subTotal+=$subtotObat;//$rwPavObat['SUBTOTAL'];
									//$obtPavTmbhn=$rwPavObat['JAMINANOBAT'];
								}
								//echo $totBiayaPaviliun_BPJS."<br>";
								$sPavObatW="SELECT
										  (ap.QTY_JUAL * ap.HARGA_SATUAN)+
										  FLOOR(
									  		(ap.PPN/100) *  ((ap.QTY_JUAL) * ap.HARGA_SATUAN)
										  	)
										  AS SUBTOTAL,
										  ap.DOKTER, ap.NO_PENJUALAN,
										  IF(ap.DIJAMIN=0,(IF(ap.CARA_BAYAR=2,(ap.QTY_JUAL * ap.HARGA_SATUAN),0)),'0')+
										   FLOOR(
									  		(ap.PPN/100) *  IF(ap.DIJAMIN=0,(IF(ap.CARA_BAYAR=2,(ap.QTY_JUAL * ap.HARGA_SATUAN),0)),'0')
										  	)
										  AS JAMINANOBAT,
										  ap.ID AS idpenjualan
										FROM
										  $dbapotek.a_penjualan ap 
										  INNER JOIN b_pelayanan 
											ON ap.NO_KUNJUNGAN = b_pelayanan.id
										  INNER JOIN b_ms_unit 
											ON b_ms_unit.id = b_pelayanan.unit_id
										  INNER JOIN b_ms_unit b_ms_unit_asal 
											ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
										  INNER JOIN $dbapotek.a_mitra am 
											ON am.IDMITRA=ap.KSO_ID
										  INNER JOIN b_ms_kso kso 
											ON kso.id=b_pelayanan.kso_id
										  INNER JOIN b_kunjungan
											ON b_kunjungan.id = b_pelayanan.kunjungan_id
										  LEFT JOIN b_ms_kelas k ON k.id=b_pelayanan.kelas_id
										  INNER JOIN b_ms_kelas hk ON hk.id=b_kunjungan.kso_kelas_id 
										WHERE 
										b_pelayanan.kunjungan_id = '".$rw['kunj_id']."'
										$fJK3
										AND kso.id = 6
										AND ap.CARA_BAYAR=2
										AND ap.KRONIS<>2
										AND ap.DIJAMIN = 0";
								//echo $sPavObatW."<br/><br/>";
								$subTotal3=0;
								$obtPavTmbhn=0;
								//echo $totBiayaPaviliun_BPJS."<br>";
								$qPavObatW=mysql_query($sPavObatW);
								while($rwPavObatW=mysql_fetch_array($qPavObatW)){
								
									$queByr = "SELECT b.tgl_act AS TGL_BAYAR FROM b_bayar b WHERE b.kunjungan_id = '".$idKunj."' AND b.kso_id = '".$idKSOnew."' ORDER BY b.id DESC";
									//echo $queByr."<br/><br/>";
									$dByr = mysql_fetch_array(mysql_query($queByr));
									
									//awal query cek retur
									$sRetur="SELECT SUM(a.QTY_RETUR) QTY,
									SUM(a.QTY_RETUR * a.HARGA_SATUAN)+
									FLOOR(
									  		(a.PPN/100) *  SUM((a.QTY_RETUR) * a.HARGA_SATUAN)
										  )
									AS SUBTOTAL,
									SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0))+
									FLOOR(
									  		(a.PPN/100) *  SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0))
										  )
									AS DIJAMIN,
										b.TGL_BAYAR, c.tgl_retur, DATEDIFF(c.tgl_retur,b.TGL_BAYAR) AS cek, IF(TIMEDIFF(c.tgl_retur,'".$dByr['TGL_BAYAR']."')>0,'1','0') AS DiffDate,
									IF(a.DIJAMIN=0,SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0)),'0')+
									FLOOR(
									  		(a.PPN/100) * IF(a.DIJAMIN=0,SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0)),'0')
										  )
									AS JAMINANOBAT
										FROM $dbapotek.a_penjualan a
										LEFT JOIN $dbapotek.a_kredit_utang b ON a.NO_PENJUALAN = b.FK_NO_PENJUALAN AND a.UNIT_ID = b.UNIT_ID AND a.NO_KUNJUNGAN = b.NO_PELAYANAN AND a.NO_PASIEN = b.NORM
										LEFT JOIN $dbapotek.a_return_penjualan c ON a.ID = c.idpenjualan
										WHERE a.ID = '".$rwPavObatW['idpenjualan']."' ";
									//echo $sRetur."<br/>";
									$qRetur=mysql_query($sRetur);
									$rwRetur=mysql_fetch_array($qRetur);
									if($rwRetur['DiffDate']==0){
										$subtotObat=$rwPavObatW['SUBTOTAL']-$rwRetur['SUBTOTAL'];
										//$dijaminObt=$rwRJRDObat['DIJAMIN']-$rwRetur['DIJAMIN'];
										//$qtyObt=$rwRJRDObat['QTY']-$rwRetur['QTY'];
										$jminanObt=$rwPavObatW['JAMINANOBAT']-$rwRetur['JAMINANOBAT'];
										$rrr=0;
									}else{
										$subtotObat=$rwPavObatW['SUBTOTAL'];
										//$dijaminObt=$rwRJRDObat['DIJAMIN'];
										//$qtyObt=$rwRJRDObat['QTY'];
										$jminanObt=$rwPavObatW['JAMINANOBAT'];
										$rrr=1;
									}
									//akhir query cek retur
								
									//$totBiayaPaviliun_BPJS+=$rwPavObat['SUBTOTAL'];
									$subTotal3+=$subtotObat;//$rwPavObatW['SUBTOTAL'];
									//echo "||".$subTotal."|-----HHH";
									$obtPavTmbhn+=$jminanObt;//$rwPavObatW['JAMINANOBAT'];
								}
								
								//echo $totBiayaPaviliun_BPJS."<br>";
								$sPavObat2="SELECT
										  SUM(ap.QTY_JUAL * ap.HARGA_SATUAN)+
										  FLOOR(
									  		(ap.PPN/100) *  SUM((ap.QTY_JUAL) * ap.HARGA_SATUAN)
										  	)
										  AS SUBTOTAL,
										  ap.DOKTER, ap.UTANG, b_pelayanan.id as pel_id, ap.ID AS idpenjualan,
										  ap.NO_PENJUALAN, ap.UNIT_ID, ap.NO_KUNJUNGAN, ap.NO_PASIEN
										FROM
										  $dbapotek.a_penjualan ap 
										  INNER JOIN b_pelayanan 
											ON ap.NO_KUNJUNGAN = b_pelayanan.id
										  INNER JOIN b_ms_unit 
											ON b_ms_unit.id = b_pelayanan.unit_id
										  INNER JOIN b_ms_unit b_ms_unit_asal 
											ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
										  INNER JOIN $dbapotek.a_mitra am 
											ON am.IDMITRA=ap.KSO_ID
										  INNER JOIN b_ms_kso kso 
											ON kso.id=b_pelayanan.kso_id
										  INNER JOIN b_kunjungan
											ON b_kunjungan.id = b_pelayanan.kunjungan_id
										  LEFT JOIN b_ms_kelas k ON k.id=b_pelayanan.kelas_id
										  INNER JOIN b_ms_kelas hk ON hk.id=b_kunjungan.kso_kelas_id 
										WHERE 
										b_pelayanan.kunjungan_id = '".$rw['kunj_id']."'
										$fJK3
										AND kso.id = 6
										AND ap.CARA_BAYAR=2
										AND ap.KRONIS<>2
										AND ap.DIJAMIN = 0
										GROUP BY ap.NO_PENJUALAN, ap.USER_ID";
								//echo $sPavObat2."---END<br/>";
								//echo $totBiayaPaviliun_BPJS."<br>";
								$qPavObatU2=mysql_query($sPavObat2);
								$totalTiapResep = 0;
								$sisaFarm=0;
								while($rwPavObatU2=mysql_fetch_array($qPavObatU2)){
									
									$queByr = "SELECT b.tgl_act AS TGL_BAYAR FROM b_bayar b WHERE b.kunjungan_id = '".$idKunj."' AND b.kso_id = '".$idKSOnew."' ORDER BY b.id DESC";
									//echo $queByr."<br/><br/>";
									$dByr = mysql_fetch_array(mysql_query($queByr));
									
									//awal query cek retur
									$sRetur="SELECT SUM(a.QTY_RETUR) QTY,
									SUM(a.QTY_RETUR * a.HARGA_SATUAN)+
									FLOOR(
									  		(a.PPN/100) *  SUM((a.QTY_RETUR) * a.HARGA_SATUAN)
										  	)
									AS SUBTOTAL,
									SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0))+
									FLOOR(
									  		(a.PPN/100) *  SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0))
										  	)
									AS DIJAMIN,
										b.TGL_BAYAR, c.tgl_retur, DATEDIFF(c.tgl_retur,b.TGL_BAYAR) AS cek, IF(TIMEDIFF(c.tgl_retur,'".$dByr['TGL_BAYAR']."')>0,'1','0') AS DiffDate
										FROM $dbapotek.a_penjualan a
										LEFT JOIN $dbapotek.a_kredit_utang b ON a.NO_PENJUALAN = b.FK_NO_PENJUALAN AND a.UNIT_ID = b.UNIT_ID AND a.NO_KUNJUNGAN = b.NO_PELAYANAN AND a.NO_PASIEN = b.NORM
										LEFT JOIN $dbapotek.a_return_penjualan c ON a.ID = c.idpenjualan
										WHERE a.NO_PENJUALAN = '".$rwPavObatU2['NO_PENJUALAN']."' AND a.UNIT_ID = '".$rwPavObatU2['UNIT_ID']."' AND a.NO_KUNJUNGAN = '".$rwPavObatU2['pel_id']."' AND a.NO_PASIEN = '".$rwPavObatU2['NO_PASIEN']."' ";
									//echo $sRetur."<br/>";
									$qRetur=mysql_query($sRetur);
									$rwRetur=mysql_fetch_array($qRetur);
									if($rwRetur['DiffDate']==0){
										$subtotObat=$rwPavObatU2['SUBTOTAL']-$rwRetur['SUBTOTAL'];
										//$dijaminObt=$rwRJRDObat['DIJAMIN']-$rwRetur['DIJAMIN'];
										//$qtyObt=$rwRJRDObat['QTY']-$rwRetur['QTY'];
										$rrr=0;
									}else{
										$subtotObat=$rwPavObatU2['SUBTOTAL'];
										//$dijaminObt=$rwRJRDObat['DIJAMIN'];
										//$qtyObt=$rwRJRDObat['QTY'];
										$rrr=1;
									}
									//akhir query cek retur
									
									$sisaObat=$rwPavObatU2['UTANG'];
									if($sisaObat>0){
										if($totalTiapResep==0){
											$totalTiapResep = $subtotObat;//$rwPavObatU2['SUBTOTAL'];
										}else{
											if($totalTiapResep > $subtotObat){
												$totalTiapResep = $subtotObat;//$rwPavObatU2['SUBTOTAL'];
											}
										}
									}
									
									if($rwPavObatU2['UTANG'] > 0){
										$msgObat.=$rwPavObatU2['NO_PENJUALAN']."-**-".$subtotObat."-**-".$rwPavObatU2['DOKTER']."-**-".$rwPavObatU2['pel_id']."***";
										$sisaFarm+=$subtotObat;//$rwPavObatU2['SUBTOTAL'];
									}
								}
							}							
							/* ============================ END CEK TIPE BAYAR BPJS ============================= */
						
							if ($TipeBayar==1){
								$total=$rwGrouper['biaya_px']+$totBiayaPaviliun_BPJS_UMUM;//+$subTotal;//obtPavTmbhn;
							}
							else{
								$total=($totBiayaPaviliun_BPJS-$hasil_grouper);//+$subTotal;
								//if($total<0) { $total=0; $subTotal=0;}
							}
							//echo "totBiayaPaviliun_BPJS=".$totBiayaPaviliun_BPJS."<br>";
							//echo "hasil_grouper=".$hasil_grouper."<br>";
							//echo "total=".$total."<br>";
							$jaminan=0;
							$titipan=$rwTitip['titip'];
							$bayar=$rwBayar['bayar'];
							$kurang=$total-$jaminan-$titipan-$bayar+$subTotal;//+$obtPavTmbhn;//$subTotal;
							$selisih_lebih_kurang=$total-$jaminan-$titipan-$bayar;		
							//echo "--tetot".$total;//."---|grouper".$hasil_grouper."|||kRG".$kurang."------zzz----".$obtPavTmbhn."--LLL---".$subTotal."--obt|".$totBiayaPaviliun_BPJS."--obttmbhn <br/>";
						}
						//tdk naik kelas
						else{
							$kelBPJSnew=3;
							$total=0;
							$jaminan=0;
							$fJK="/*AND b_pelayanan.jenis_kunjungan = ".$jenis_kunjungan."*/";
							/*if($jenis_kunjungan<>'3'){
								$fJK2="AND b.jenis_kunjungan = ".$jenis_kunjungan;
							}*/
							
							$msgObat = "";
							
							$sNaekKlsObat="SELECT
									  SUM(ap.QTY_JUAL * ap.HARGA_SATUAN)+
									  FLOOR(
									  		(ap.PPN/100) *  SUM((ap.QTY_JUAL) * ap.HARGA_SATUAN)
										  	)
									  AS SUBTOTAL,
									  ap.DOKTER, ap.UTANG,
									  IF(ap.DIJAMIN=0,SUM(IF(ap.CARA_BAYAR=2,(ap.QTY_JUAL * ap.HARGA_SATUAN),0)),'0')+
									  FLOOR(
									  		(ap.PPN/100) *  IF(ap.DIJAMIN=0,SUM(IF(ap.CARA_BAYAR=2,(ap.QTY_JUAL * ap.HARGA_SATUAN),0)),'0')
										  	)
									  AS JAMINANOBAT,
									  b_pelayanan.id as pel_id,ap.ID AS idpenjualan, ap.NO_PENJUALAN, ap.UNIT_ID, ap.NO_KUNJUNGAN, ap.NO_PASIEN
									FROM
									  $dbapotek.a_penjualan ap 
									  INNER JOIN b_pelayanan 
										ON ap.NO_KUNJUNGAN = b_pelayanan.id
									  INNER JOIN b_ms_unit 
										ON b_ms_unit.id = b_pelayanan.unit_id
									  INNER JOIN b_ms_unit b_ms_unit_asal 
										ON b_ms_unit_asal.id = b_pelayanan.unit_id_asal
									  INNER JOIN $dbapotek.a_mitra am 
										ON am.IDMITRA=ap.KSO_ID
									  INNER JOIN b_ms_kso kso 
										ON kso.id=b_pelayanan.kso_id
									  INNER JOIN b_kunjungan
										ON b_kunjungan.id = b_pelayanan.kunjungan_id
									  LEFT JOIN b_ms_kelas k ON k.id=b_pelayanan.kelas_id
									  INNER JOIN b_ms_kelas hk ON hk.id=b_kunjungan.kso_kelas_id 
									WHERE 
									b_pelayanan.kunjungan_id = '".$rw['kunj_id']."'
									$fJK
									AND kso.id = 6
									AND ap.CARA_BAYAR=2
									AND ap.KRONIS<>2
									and ap.DIJAMIN=0
									GROUP BY ap.NO_PENJUALAN, ap.USER_ID";
							//echo $sNaekKlsObat."<br/><br/>";
							$obtPavTmbhn=0;
							$sisaFarm=0;
							$subTotal=0;
							$qNaekKlsObat=mysql_query($sNaekKlsObat);
							while($rwNaekKlsObat=mysql_fetch_array($qNaekKlsObat)){
								$queByr = "SELECT b.tgl_act AS TGL_BAYAR FROM b_bayar b WHERE b.kunjungan_id = '".$idKunj."' AND b.kso_id = '".$idKSOnew."' ORDER BY b.id DESC";
								//echo $queByr."<br/><br/>";
								$dByr = mysql_fetch_array(mysql_query($queByr));
								
								//awal query cek retur
								$sRetur="SELECT SUM(a.QTY_RETUR) QTY,
								SUM(a.QTY_RETUR * a.HARGA_SATUAN)+
								FLOOR(
									  		(a.PPN/100) *  SUM((a.QTY_RETUR) * a.HARGA_SATUAN)
										  	)
								AS SUBTOTAL,
								SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0))+
								FLOOR(
									  		(a.PPN/100) *  SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0))
									  )
								AS DIJAMIN,
									b.TGL_BAYAR, c.tgl_retur, DATEDIFF(c.tgl_retur,b.TGL_BAYAR) AS cek, IF(TIMEDIFF(c.tgl_retur,'".$dByr['TGL_BAYAR']."')>0,'1','0') AS DiffDate
									,IF(a.DIJAMIN=0,SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0)),'0') AS JAMINANOBAT
									FROM $dbapotek.a_penjualan a
									LEFT JOIN $dbapotek.a_kredit_utang b ON a.NO_PENJUALAN = b.FK_NO_PENJUALAN AND a.UNIT_ID = b.UNIT_ID AND a.NO_KUNJUNGAN = b.NO_PELAYANAN AND a.NO_PASIEN = b.NORM
									LEFT JOIN $dbapotek.a_return_penjualan c ON a.ID = c.idpenjualan
									WHERE a.NO_PENJUALAN = '".$rwNaekKlsObat['NO_PENJUALAN']."' AND a.UNIT_ID = '".$rwNaekKlsObat['UNIT_ID']."' AND a.NO_KUNJUNGAN = '".$rwNaekKlsObat['pel_id']."' AND a.NO_PASIEN = '".$rwNaekKlsObat['NO_PASIEN']."' ";
								//echo $sRetur."<br/>";
								$qRetur=mysql_query($sRetur);
								$rwRetur=mysql_fetch_array($qRetur);
								if($rwRetur['DiffDate']==0){
									$subtotObat=$rwNaekKlsObat['SUBTOTAL']-$rwRetur['SUBTOTAL'];
									//$dijaminObt=$rwRJRDObat['DIJAMIN']-$rwRetur['DIJAMIN'];
									//$qtyObt=$rwRJRDObat['QTY']-$rwRetur['QTY'];
									$jminanObt=$rwNaekKlsObat['JAMINANOBAT']-$rwRetur['JAMINANOBAT'];
									$rrr=0;
								}else{
									$subtotObat=$rwNaekKlsObat['SUBTOTAL'];
									//$dijaminObt=$rwRJRDObat['DIJAMIN'];
									//$qtyObt=$rwRJRDObat['QTY'];
									$jminanObt=$rwNaekKlsObat['JAMINANOBAT'];
									$rrr=1;
								}
								//akhir query cek retur
							
								$obtPavTmbhn+=$jminanObt;//$rwNaekKlsObat['JAMINANOBAT'];
							
								if($rwNaekKlsObat['UTANG'] > 0){
									$msgObat.=$rwNaekKlsObat['NO_PENJUALAN']."-**-".$subtotObat."-**-".$rwNaekKlsObat['DOKTER']."-**-".$rwNaekKlsObat['pel_id']."***";
									$sisaFarm+=$subtotObat;//$rwNaekKlsObat['SUBTOTAL'];
								}
								$subTotal+=$subtotObat;
							}
							
							//$total=$rwGrouper['biaya_px']+$obtPavTmbhn;
							$total=$obtPavTmbhn;
							$jaminan=0;
							$titipan=$rwTitip['titip'];
							$bayar=$rwBayar['bayar'];
							$kurang=$total-$jaminan-$titipan-$bayar;
							$selisih_lebih_kurang=$total-$jaminan-$titipan-$bayar;
							/*$titipan=$rwTitip['titip'];
							$bayar=$rwBayar['bayar'];
							$kurang=$total-$jaminan-$titipan-$bayar;
							$selisih_lebih_kurang=$total-$jaminan-$titipan-$bayar;*/
						}
					}
					// JASA RAHARJA
					else if($ksoid==$idKsoJR){
						$sqlTin1="SELECT * FROM b_jaminan_kso WHERE kunjungan_id='".$rw['kunj_id']."'";
						//echo $sqlTin.";<br/>";
						$rsTin1=mysql_query($sqlTin1);
						/* if (mysql_num_rows($rsTin)>0){
							$rwTin=mysql_fetch_array($rsTin);
							$jaminan=$rwTin['biaya_kso'];
							$kurang=$rwTin['biaya_px'];
						} */		//Pindah bawah sebelum total
						
						$subTotal=0;
						$msgObat='';
					
						$umum_stlh_krs2 = " ";	
						if($cekIurKRS==1){
							$umum_stlh_krs2 = " AND t._krs<>1 ";
						}else if($cekSdhByrRJ==1){
							$umum_stlh_krs2 = " AND t._krs<>1 ";
						}
						
						if ($kasir==127){
							$sqlTin="select 
								IFNULL(sum((t.biaya)*t.qty),0) as total,
								IFNULL(SUM((t.biaya_kso)*t.qty),0) AS dijamin,
								IFNULL(SUM(t.bayar),0) AS bayar,
								IFNULL(sum(((t.biaya_pasien)*t.qty)-t.bayar),0) as kurang 
								from b_tindakan t
								inner join b_pelayanan p on t.pelayanan_id=p.id
								where p.kunjungan_id='".$rw['kunj_id']."' AND t.lunas=0 
								AND t.ms_tindakan_kelas_id IN (7513) $umum_stlh_krs2
								AND t.id NOT IN 
								(SELECT tindakan_id FROM b_bayar_tindakan bt INNER JOIN b_bayar b ON bt.bayar_id=b.id 
								INNER JOIN b_tindakan t ON bt.tindakan_id=t.id 
								WHERE b.kunjungan_id='".$rw['kunj_id']."' AND bt.tipe=0 AND t.lunas=1 
								AND t.ms_tindakan_kelas_id IN (7513))";
						}else{
							$sqlTin="select 
								IFNULL(sum((t.biaya)*t.qty),0) as total,
								IFNULL(SUM((t.biaya_kso)*t.qty),0) AS dijamin,
								IFNULL(SUM(t.bayar),0) AS bayar,
								IFNULL(sum(((t.biaya_pasien)*t.qty)-t.bayar),0) as kurang 
								from b_tindakan t
								inner join b_pelayanan p on t.pelayanan_id=p.id
								where p.kunjungan_id='".$rw['kunj_id']."' AND t.lunas=0
								$umum_stlh_krs2
								AND t.id NOT IN 
								(SELECT tindakan_id FROM b_bayar_tindakan bt INNER JOIN b_bayar b ON bt.bayar_id=b.id 
								INNER JOIN b_tindakan t ON bt.tindakan_id=t.id 
								WHERE b.kunjungan_id='".$rw['kunj_id']."' AND bt.tipe=0 AND t.lunas=1)";
						}
						
						//echo $sqlTin.";<br/>";
						$rsTin=mysql_query($sqlTin);
						$rwTin=mysql_fetch_array($rsTin);
						
						$sql="SELECT IFNULL(SUM(b.titipan-b.titipan_terpakai),0) AS titip FROM b_bayar b WHERE b.kunjungan_id='".$rw['kunj_id']."' AND b.kasir_id='".$_REQUEST['kasir']."' AND b.tipe=1";
						$rsTitip=mysql_query($sql);
						$rwTitip=mysql_fetch_array($rsTitip);
				
						$sqlKamar="SELECT IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*(tarip),
	(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*(tarip))),0) AS kamar,
	IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*(beban_kso),
	(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*(beban_kso))),0) AS kamar_kso,
	IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*(beban_pasien)-bayar,
	(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*(beban_pasien)-bayar)),0) AS kurang_kamar,SUM(IFNULL(bayar,0)) bayar 
	FROM b_tindakan_kamar b INNER JOIN b_pelayanan p ON b.pelayanan_id=p.id 
	WHERE p.kunjungan_id='".$rw['kunj_id']."' AND b.aktif=1";
						//echo $sqlKamar.";<br/>";
						$rsKamar=mysql_query($sqlKamar);
						$rwKamar=mysql_fetch_array($rsKamar);
						
						$sqlObat="SELECT 
							  IFNULL(SUM(t2.QTY_JUAL), 0) QTY_JUAL,
							  IFNULL(SUM(t2.QTY_RETUR), 0) QTY_RETUR,
							  IFNULL(SUM(t2.QTY_JUAL * t2.HARGA_SATUAN),0)+
							  FLOOR(
									  	(t2.PPN/100) *  IFNULL(SUM(t2.QTY_JUAL * t2.HARGA_SATUAN),0)
									)
							  AS SUBTOTAL,
							  
							  t2.UTANG AS sisa,
							  t2.DOKTER,
							  t2.NO_PENJUALAN, t2.UNIT_ID, t2.NO_KUNJUNGAN, t2.NO_PASIEN,
							  t2.pel_id, t2.ID AS idpenjualan 
							FROM
							  (SELECT 
								ap.*,
								p.id AS pel_id 
							  FROM
								$dbapotek.a_penjualan ap 
								INNER JOIN b_pelayanan p 
								  ON ap.NO_KUNJUNGAN = p.id 
							WHERE p.kunjungan_id='".$rw['kunj_id']."' AND ap.CARA_BAYAR=2 and ap.KRONIS<>2 and ap.DIJAMIN=0) AS t2 GROUP BY t2.NO_PENJUALAN, t2.USER_ID";
						//echo $sqlObat.";<br/>";
						$rsObat=mysql_query($sqlObat);
						$bayar2=0;
						while($rwObat=mysql_fetch_array($rsObat)){
						
							$queByr = "SELECT b.tgl_act AS TGL_BAYAR FROM b_bayar b WHERE b.kunjungan_id = '".$idKunj."' AND b.kso_id = '".$idKSOnew."' ORDER BY b.id DESC";
							//echo $queByr."<br/><br/>";
							$dByr = mysql_fetch_array(mysql_query($queByr));
										
							//awal query cek retur
							$sRetur="SELECT SUM(a.QTY_RETUR) QTY,
							SUM(a.QTY_RETUR * a.HARGA_SATUAN)+
							FLOOR(
									  (a.PPN/100) *  SUM((a.QTY_RETUR) * a.HARGA_SATUAN)
								 )
							AS SUBTOTAL,
							SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0))+
							FLOOR(
									  (a.PPN/100) *  SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0))
								 )
							AS DIJAMIN,
								b.TGL_BAYAR, c.tgl_retur, DATEDIFF(c.tgl_retur,b.TGL_BAYAR) AS cek, IF(TIMEDIFF(c.tgl_retur,'".$dByr['TGL_BAYAR']."')>0,'1','0') AS DiffDate
								FROM $dbapotek.a_penjualan a
								LEFT JOIN $dbapotek.a_kredit_utang b ON a.NO_PENJUALAN = b.FK_NO_PENJUALAN AND a.UNIT_ID = b.UNIT_ID AND a.NO_KUNJUNGAN = b.NO_PELAYANAN AND a.NO_PASIEN = b.NORM
								LEFT JOIN $dbapotek.a_return_penjualan c ON a.ID = c.idpenjualan
								WHERE a.NO_PENJUALAN = '".$rwObat['NO_PENJUALAN']."' AND a.UNIT_ID = '".$rwObat['UNIT_ID']."' AND a.NO_KUNJUNGAN = '".$rwObat['pel_id']."' AND a.NO_PASIEN = '".$rwObat['NO_PASIEN']."' ";
							//echo $sRetur."<br/>";
							$qRetur=mysql_query($sRetur);
							$rwRetur=mysql_fetch_array($qRetur);
							if($rwRetur['DiffDate']==0){
								$subtotObat=$rwObat['SUBTOTAL']-$rwRetur['SUBTOTAL'];
								//$dijaminObt=$rwPavObat['DIJAMIN']-$rwRetur['DIJAMIN'];
								//$qtyObt=$rwPavObat['QTY']-$rwRetur['QTY'];
								$rrr=0;
							}else{
								$subtotObat=$rwObat['SUBTOTAL'];
								//$dijaminObt=$rwPavObat['DIJAMIN'];
								//$qtyObt=$rwPavObat['QTY'];
								$rrr=1;
							}
							//akhir query cek retur
							
							//$bObat=$rwObat['SUBTOTAL'];
							$bObat=$subtotObat;
							$sisaObat=$rwObat['sisa'];
							
							$subTotal+=$bObat;
							
							if($sisaObat>0){
								$msgObat.=$rwObat['NO_PENJUALAN']."-**-".$bObat."-**-".$rwObat['DOKTER']."-**-".$rwObat['pel_id']."***";
								//$sisaFarm+=$bObat;
							}else{
								$bayar2+=$bObat;
							}
						}
						
						
						
						$sqlObat2="SELECT 
							  IFNULL(t2.QTY_JUAL, 0) QTY_JUAL,
							  IFNULL(t2.QTY_RETUR, 0) QTY_RETUR,
							  IFNULL(t2.QTY_JUAL * t2.HARGA_SATUAN,0)+
							  FLOOR(
								  		(t2.PPN/100) *  IFNULL(t2.QTY_JUAL * t2.HARGA_SATUAN,0)
									)
							  AS SUBTOTAL,
							  
							  t2.UTANG AS sisa,
							  t2.DOKTER,
							  t2.NO_PENJUALAN, t2.ID AS idpenjualan
							FROM
							  (SELECT 
								ap.* 
							  FROM
								$dbapotek.a_penjualan ap 
								INNER JOIN b_pelayanan p 
								  ON ap.NO_KUNJUNGAN = p.id 
							WHERE p.kunjungan_id='".$rw['kunj_id']."' AND ap.CARA_BAYAR=2 and ap.KRONIS<>2 and ap.DIJAMIN=1) AS t2";
						//echo $sqlObat2.";<br/>";
						$subtotObat2=0;
						$rsObat2=mysql_query($sqlObat2);
						while($rwObat2=mysql_fetch_array($rsObat2)){
						
							$queByr = "SELECT b.tgl_act AS TGL_BAYAR FROM b_bayar b WHERE b.kunjungan_id = '".$idKunj."' AND b.kso_id = '".$idKSOnew."' ORDER BY b.id DESC";
							//echo $queByr."<br/><br/>";
							$dByr = mysql_fetch_array(mysql_query($queByr));
							
							//awal query cek retur
							$sRetur="SELECT SUM(a.QTY_RETUR) QTY,
							SUM(a.QTY_RETUR * a.HARGA_SATUAN)+
							FLOOR(
									(a.PPN/100) *  SUM((a.QTY_RETUR) * a.HARGA_SATUAN)
							  	)
							AS SUBTOTAL,
							SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0))+
							FLOOR(
									(a.PPN/100) * SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0)
							  	))
							AS DIJAMIN,
								b.TGL_BAYAR, c.tgl_retur, DATEDIFF(c.tgl_retur,b.TGL_BAYAR) AS cek, IF(TIMEDIFF(c.tgl_retur,'".$dByr['TGL_BAYAR']."')>0,'1','0') AS DiffDate
								FROM $dbapotek.a_penjualan a
								LEFT JOIN $dbapotek.a_kredit_utang b ON a.NO_PENJUALAN = b.FK_NO_PENJUALAN AND a.UNIT_ID = b.UNIT_ID AND a.NO_KUNJUNGAN = b.NO_PELAYANAN AND a.NO_PASIEN = b.NORM
								LEFT JOIN $dbapotek.a_return_penjualan c ON a.ID = c.idpenjualan
								WHERE a.ID = '".$rwObat2['idpenjualan']."' ";
							//echo $sRetur."<br/>";
							$qRetur=mysql_query($sRetur);
							$rwRetur=mysql_fetch_array($qRetur);
							if($rwRetur['DiffDate']==0){
								$subtotObat=$rwObat2['SUBTOTAL']-$rwRetur['SUBTOTAL'];
								//$dijaminObt=$rwPavObat['DIJAMIN']-$rwRetur['DIJAMIN'];
								//$qtyObt=$rwPavObat['QTY']-$rwRetur['QTY'];
								$rrr=0;
							}else{
								$subtotObat=$rwObat2['SUBTOTAL'];
								//$dijaminObt=$rwPavObat['DIJAMIN'];
								//$qtyObt=$rwPavObat['QTY'];
								$rrr=1;
							}
							//akhir query cek retur
						
							$subtotObat2+=$subtotObat;
						}
						
							$jaminan=$rwTin['dijamin']+$rwKamar['kamar_kso']+$subtotObat2;//$rwObat2['SUBTOTAL'];
							$jaminan2=$rwTin['dijamin']+$rwKamar['kamar_kso'];
			
						$total=$rwTin['total']+$rwKamar['kamar']+$subTotal-$bayar2;
		
						if($total<0){$total=0;}
						//$kurang=$kurang+$rwTin['kurang']+$rwKamar['kurang_kamar']-$rwTitip['titip']-$bObat;
						$kurang=$total-$titipan-$jaminan2;
						$selisih_lebih_kurang=$total-$kurang;

						$igdTot=$total;
						$igdKurang=$kurang;
						$igdJaminan=$jaminan;
						$ibyrIgd=$rwTin['bayar']+$rwKamar['bayar'];

						//echo "-----Awal ".$rwTin['total']." ----||||".$rwKamar['kamar']."---|---".$subTotal."------byr".$bayar2."----jamin".$jaminan."zzz";
						//echo "<br/>TOT".$kurang."!tot!!".$total."!!jam!".$jaminan."!!byr!".$bayar2."!titip!!".$titipan.'<br/>';
					}
					//UMUM dan KSO LAINNYA
					else{
						$umum_stlh_krs = " ";	
						if($cekIurKRS==1){
							$umum_stlh_krs = " AND t._krs<>1 ";
						}else if($cekSdhByrRJ==1){
							$umum_stlh_krs = " AND t._krs<>1 ";
						}
					
						if ($kasir==127){
							$sqlTin="select 
							IFNULL(sum((t.biaya)*t.qty),0) as total,
							IFNULL(sum((t.biaya_kso)*t.qty),0) as dijamin 
							from b_tindakan t
							inner join b_pelayanan p on t.pelayanan_id=p.id
							where 
							p.kunjungan_id='".$rw['kunj_id']."'
							$umum_stlh_krs
							/*AND p.unit_id<>$idUnitAmbulan 
							AND p.unit_id<>$idUnitJenazah*/ 
							AND t.ms_tindakan_kelas_id IN (7513)
							AND t.kso_id='".$ksoid."'";
						}else{
							$sqlTin="select 
							IFNULL(sum((t.biaya)*t.qty),0) as total,
							IFNULL(sum((t.biaya_kso)*t.qty),0) as dijamin 
							from b_tindakan t
							inner join b_pelayanan p on t.pelayanan_id=p.id
							where 
							p.kunjungan_id='".$rw['kunj_id']."'
							/*AND p.unit_id<>$idUnitAmbulan 
							AND p.unit_id<>$idUnitJenazah*/
							AND t.kso_id='".$ksoid."' $umum_stlh_krs ";
						}

		//echo $sqlTin.";<br/>";
						$rsTin=mysql_query($sqlTin);
						$rwTin=mysql_fetch_array($rsTin);
						//koding awal *decyber
// 						-- IF(b.kso_id=1,IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*(retribusi),
// -- 	(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*(retribusi))),0),0) AS 
						$sqlKamar="SELECT IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*(tarip),
	(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*(tarip))),0) AS kamar,
	
IF(b.kso_id=1,IFNULL(SUM(IF(b.status_out=0,(retribusi),(retribusi))),0),0) AS 
-- Biaya retribusi hanya dikenakan dipertama masuk rawat inap* decyber
	retribusi,
						IFNULL(SUM(IF(b.status_out=0,(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,1,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*(beban_kso),
	(IF(DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)=0,0,DATEDIFF(IFNULL(tgl_out,NOW()),tgl_in)+1))*(beban_kso))),0) AS kamar_kso

						FROM 
						b_tindakan_kamar b 
						INNER JOIN b_pelayanan p ON b.pelayanan_id=p.id 
						WHERE 
						p.kunjungan_id='".$rw['kunj_id']."'
						AND b.kso_id='".$ksoid."'
						AND b.aktif=1";
						//echo $sqlKamar.";<br/>";
						$rsKamar=mysql_query($sqlKamar);
						$rwKamar=mysql_fetch_array($rsKamar);
						
						$sql="SELECT 
							IFNULL(SUM(b.titipan-b.titipan_terpakai),0) AS titip 
							FROM b_bayar b 
							WHERE 
							b.kunjungan_id='".$rw['kunj_id']."'
							/*AND b.jenis_kunjungan='".$jenis_kunjungan."'*/
							AND b.tipe=1
							AND b.kso_id='".$ksoid."'";
						//echo $sql.";<br/>";
						$rsTitip=mysql_query($sql);
						$rwTitip=mysql_fetch_array($rsTitip);
						
						$sBayar="SELECT 
							IFNULL((b.nilai+b.titipan),0) AS bayar, b.no_kwitansi, id
							FROM b_bayar b 
							WHERE 
							b.kunjungan_id='".$rw['kunj_id']."'
							/*AND b.jenis_kunjungan='".$jenis_kunjungan."'*/					
							AND b.tipe=0
							AND b.kso_id='".$ksoid."'";
						//echo $sBayar."<br/>---------444------<br />";
						$rsBayar=mysql_query($sBayar);
						$byrObat=0;
						$bayar=0;
						while($rwBayar=mysql_fetch_array($rsBayar)){
						
							$sBayarO="SELECT 
								SUM(IFNULL(b.bayar,0)) AS bayar 
							FROM $dbapotek.a_kredit_utang b 
							WHERE 
							b.BILLING_BAYAR_OBAT_ID='".$rwBayar['id']."'
							AND b.NO_BAYAR = '".$rwBayar['no_kwitansi']."'
							AND b.IS_AKTIF='0'
							GROUP BY b.NO_BAYAR";
							//echo $sBayarO."<br/>---------4444------<br />";
							$rsBayarO=mysql_query($sBayarO);
							$rwBayarO=mysql_fetch_array($rsBayarO);
							$bayar+=$rwBayar['bayar'];
							$byrObat+=$rwBayarO['bayar'];
						
						}
						//echo "byrObat=".$byrObat."<br>";
						$total=($rwTin['total']+$rwKamar['kamar'])-($rwTin['dijamin']+$rwKamar['kamar_kso'])+$rwKamar['retribusi'];
						if($total<0){
							$total=0;
						}
						//echo "<br/>--hasdfg---------- ".$rwTin['total']." -- |||".$rwKamar['kamar']." -- ||".$rwTin['dijamin']." -- ".$rwKamar['kamar_kso']." -----444------<br />";
						$jaminan=0;
						
						
						$bayar2=$bayar-$byrObat;
						$titipan=$rwTitip['titip'];
						$kurang=$total-$jaminan-$bayar2-$titipan;
						//echo "TOT=".$kurang."!tot!!".$total."!!jam!".$jaminan."!!byr!".$bayar2."!titip!!".$titipan.'<br/>';
					}
					
					//OBAT
					//Bukan BPJS  dan bukan JASA RAHARJA
					if($ksoid != $idKsoBPJS && $ksoid !=9){
						$subTotal=0;
						$subTotalObat=0;
						$subTotalJaminan=0;	
						$totalTiapResep=0;
						//echo "-------- ".$ksoid." ------ ";
						$fCaraBayar="AND ap.CARA_BAYAR=2";
						
						$sKonsul="SELECT 
							au.UNIT_ID,
							au.UNIT_NAME 
							FROM $dbapotek.a_penjualan ap
							inner join b_pelayanan p on p.id=ap.NO_KUNJUNGAN 
							inner join $dbapotek.a_cara_bayar ac on ap.CARA_BAYAR=ac.id
							inner join $dbapotek.a_mitra am on am.IDMITRA=ap.KSO_ID
							inner join b_ms_kso kso on kso.id=p.kso_id
							inner join $dbapotek.a_unit au on au.UNIT_ID=ap.UNIT_ID  
							WHERE
							p.kunjungan_id='".$rw['kunj_id']."'
							AND ap.NO_PASIEN='".$rw['no_rm']."' 
							AND kso.id='".$ksoid."'
							$fCaraBayar
							GROUP BY au.UNIT_ID";
						//echo $sKonsul." ----------- <br>";
						$tObat=0;
						$tObatJamin=0;
						$msgObat="";
						$sisaFarm=0;
						$qKonsul=mysql_query($sKonsul);
				
						while($rwKonsul=mysql_fetch_array($qKonsul)){
							$sObat="SELECT * 
								  FROM 
								  (SELECT
								  ao.OBAT_NAMA,
								  ap.DOKTER,
								  ap.NO_PENJUALAN, ap.UNIT_ID, ap.NO_PASIEN,
								  ac.id AS CARA_BAYAR_ID,
								  ac.nama AS CARA_BAYAR,
								  SUM(ap.QTY_JUAL) QTY_JUAL, 
								  SUM(ap.QTY_RETUR) QTY_RETUR,
								  SUM(ap.QTY_JUAL) QTY,								  
								  DATE_FORMAT(ap.TGL, '%d-%m-%Y') AS TGL,
								  am.NAMA KSO,
								  SUM(ap.QTY_JUAL * ap.HARGA_SATUAN)+
								  FLOOR(
									  		(ap.PPN/100) *  SUM((ap.QTY_JUAL) * ap.HARGA_SATUAN)
										)
								  AS SUBTOTAL,
								  SUM(IF(ap.CARA_BAYAR=2,(ap.QTY_JUAL * ap.HARGA_SATUAN),0))+
								  FLOOR(
									  		(ap.PPN/100) *  SUM(IF(ap.CARA_BAYAR=2,(ap.QTY_JUAL * ap.HARGA_SATUAN),0))
										)
								  AS DIJAMIN,
								  SUM(ap.QTY_RETUR * ap.HARGA_SATUAN)+
								   FLOOR(
									  		(ap.PPN/100) *   SUM(ap.QTY_RETUR * ap.HARGA_SATUAN)
										)
								  AS RETUR,
								  k.nama AS kelas,
								  if(hk.id=1,'-',hk.nama) AS hakkelas,
								  k.level AS kelas_level,
								  k.tipe AS kelas_tipe,
								  hk.level AS hakkelas_level,
								  ap.TGL_ACT,
								  b_pelayanan.is_paviliun,
								  ap.KRONIS,
								 /*  IF(ap.KRONIS=2,'0',ap.UTANG) sisa */
								 
								  /*ap.UTANG*/ /* +FLOOR((ap.PPN/100) *  ap.UTANG)*/
								  
								  	
								if(ap.sudah_bayar=0,	( SUM(ap.QTY_JUAL * ap.HARGA_SATUAN)+
								  FLOOR(
									  		(ap.PPN/100) *  SUM((ap.QTY_JUAL) * ap.HARGA_SATUAN)
										)) -
										
										(SUM(ap.QTY_RETUR * ap.HARGA_SATUAN)+
								   FLOOR(
									  		(ap.PPN/100) *   SUM(ap.QTY_RETUR * ap.HARGA_SATUAN)
										)),0)
								  
								  
								  
								   as sisa
								  ,
								  
								  b_pelayanan.id as pel_id, ap.id idpenjualan
								FROM
								  (SELECT 
									dba_ap.* 
								  FROM
									$dbapotek.a_penjualan dba_ap
									inner join b_pelayanan p on p.id=dba_ap.NO_KUNJUNGAN
								  WHERE
								  p.kunjungan_id = '".$rw['kunj_id']."'
								  AND dba_ap.UNIT_ID='".$rwKonsul['UNIT_ID']."' 
								  ) AS ap 
								  INNER JOIN $dbapotek.a_penerimaan pn 
									ON ap.PENERIMAAN_ID = pn.ID 
								  INNER JOIN $dbapotek.a_obat ao 
									ON pn.OBAT_ID = ao.OBAT_ID 
								  INNER JOIN $dbapotek.a_cara_bayar ac on ap.CARA_BAYAR=ac.id
								  INNER JOIN $dbapotek.a_mitra am ON am.IDMITRA=ap.KSO_ID
								  INNER JOIN b_pelayanan 
									ON ap.NO_KUNJUNGAN = b_pelayanan.id
								  inner join b_ms_kso kso on kso.id=b_pelayanan.kso_id
								  INNER JOIN b_kunjungan
									ON b_kunjungan.id = b_pelayanan.kunjungan_id
								  LEFT JOIN b_ms_kelas k ON k.id=b_pelayanan.kelas_id
								  INNER JOIN b_ms_kelas hk ON hk.id=b_kunjungan.kso_kelas_id
								  where kso.id='".$ksoid."'
								  $fCaraBayar
								  AND ap.KRONIS <> 2
								  AND ap.DIJAMIN = 0 
								/*  AND sudah_bayar=0*/ 
								  GROUP BY ap.NO_PENJUALAN,ap.DOKTER,ap.NO_PASIEN
								) AS tbl ORDER BY SUBTOTAL desc";
							//echo $sObat."<br><br>";
							$qObat=mysql_query($sObat);
							while($rwObat=mysql_fetch_array($qObat)){
								
								$queByr = "SELECT ku.TGL_BAYAR FROM $dbapotek.a_kredit_utang ku WHERE ku.FK_NO_PENJUALAN='".$rwObat['NO_PENJUALAN']."' AND ku.NORM='".$rwObat['NO_PASIEN']."'";
								//echo $queByr."<br/><br/>";
								$dByr = mysql_fetch_array(mysql_query($queByr));
								
								//awal query cek retur
								$sRetur="SELECT SUM(a.QTY_RETUR) QTY,
								SUM(a.QTY_RETUR * a.HARGA_SATUAN)+
								FLOOR(
								 		(a.PPN/100) *  SUM((a.QTY_RETUR) * a.HARGA_SATUAN)
									 )
								AS SUBTOTAL, 
								SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0))+
								FLOOR(
								 		(a.PPN/100) *  SUM(IF(a.CARA_BAYAR=2,(a.QTY_RETUR * a.HARGA_SATUAN),0))
									 )
								AS DIJAMIN,
									b.TGL_BAYAR, c.tgl_retur, DATEDIFF(c.tgl_retur,b.TGL_BAYAR) AS cek, IF(TIMEDIFF(c.tgl_retur,'".$dByr['TGL_BAYAR']."')>0,'1','0') AS DiffDate
									FROM $dbapotek.a_penjualan a
									LEFT JOIN $dbapotek.a_kredit_utang b ON a.NO_PENJUALAN = b.FK_NO_PENJUALAN AND a.UNIT_ID = b.UNIT_ID AND a.NO_KUNJUNGAN = b.NO_PELAYANAN AND a.NO_PASIEN = b.NORM
									LEFT JOIN $dbapotek.a_return_penjualan c ON a.ID = c.idpenjualan
									WHERE a.NO_PENJUALAN = '".$rwObat['NO_PENJUALAN']."' AND a.UNIT_ID = '".$rwObat['UNIT_ID']."' AND a.NO_KUNJUNGAN = '".$rwObat['pel_id']."' AND a.NO_PASIEN = '".$rwObat['NO_PASIEN']."'
									/* a.ID = '".$rwObat['idpenjualan']."' */ ";
								//if ($rwObat['NO_PENJUALAN']=="030546"){
								//echo $sRetur."<br/>";
								//}
								$qRetur=mysql_query($sRetur);
								$rwRetur=mysql_fetch_array($qRetur);
								if($rwRetur['DiffDate']==0){
									$subtotObat=$rwObat['SUBTOTAL']-$rwRetur['SUBTOTAL'];
								}else{
									$subtotObat=$rwObat['SUBTOTAL'];
								}
								//akhir query cek retur
								//if ($rwObat['NO_PENJUALAN']=="030546"){
								//echo "subtotObat=".$subtotObat."<br>";
								//}
								$nBiayaJaminanObat=0;//$rwObat['DIJAMIN'];
								
								$bObat=$subtotObat;
								$sisaObat=$rwObat['sisa'];
								
								$txtKetObat="";
								if($rwObat['KRONIS']=='2'){ // OBAT PAKET
									$bObat=0;
									$nBiayaJaminanObat=0;
									$txtKetObat="PAKET";	
								}
								
								if($ksoid==6){
									$nBiayaJaminanObat=0;
								}
								else{
									if($ksoid==1){
										$nBiayaJaminanObat=0;
										$totBiaya_umum+=$bObat;	
									}
									else{
										$subBiayaKSO+=$bObat;		
									}
								}
						
								$subBiaya+=$bObat;
								$subNilaiJaminan+=$nBiayaJaminanObat;
								
								$subTotal+=$bObat;
								$subTotalJaminan+=$nBiayaJaminanObat;
								
								$subTotalObat+=$sisaObat;
								
								if($sisaObat>0){
									if($totalTiapResep==0){
										$totalTiapResep = $bObat;
									}else{
										if($totalTiapResep > $bObat){
											$totalTiapResep = $bObat;
										}
									}
								}
							
								//if($bObat!=$nBiayaJaminanObat){
								if($sisaObat>0){
									$msgObat.=$rwObat['NO_PENJUALAN']."-**-".$bObat."-**-".$rwObat['DOKTER']."-**-".$rwObat['pel_id']."***";
									$sisaFarm+=$bObat;
								}
								//}
								
								if($ksoid!=1 && $ksoid!=6){
									$nBebanPasienObat+=$bObat-$nBiayaJaminanObat;
									$subBebanPasien+=$nBebanPasienObat;
								}
								
							}
						
						}
					
						$subTotal = $subTotal - $subTotalJaminan;
						$subTotalObat = $subTotalObat - $subTotalJaminan;
					//AKHIR OBAT
					}	//akhir BPJS dan JASA RAHARJA
					
					$kurang2=$kurang;
					
					//BILLING + OBAT
					//echo " |||||||||| ".$kurang." ----------xx ".$total."-------end";
					
					if($ksoid==9){
						$subTotal2 = $subTotal;
						$subTotal = 0;
					}else{
						$subTotal = $subTotal;
					}
					
					/* if($ksoid != 1){
						$total=$total;
						$kurang=$kurang;
					} else{ */
						$total=$total+$subTotal;
						$kurang=$kurang+$subTotalObat;
					//}
					//echo "|||----- ".$subTotalObat." ----".$kurang."end";
					if($ksoid==9){ 
						$subTotal = $subTotal2;
					}if($ksoid==6){
						if($kelBPJSnew==1){
							$subTotal = $obtPavTmbhn;
						}else if($kelBPJSnew==2){
							$subTotal = $subTotal3;
						}
					}
					
					$subTotal=$subTotal-$byrObat;
					
					//echo "----- ".$total." ----".$subTotal."EL--------obt".$subTotalObat."---krg".$kurang."<br>";
				}
				
				$pelayanan_id='';
				if($rw['jenis_kunjungan']=='3'){
					$sTgl="SELECT 
							DATE_FORMAT(tk.tgl_in,'%d-%m-%Y') AS tgl
							FROM b_pelayanan p
							INNER JOIN b_tindakan_kamar tk ON tk.pelayanan_id=p.id
							WHERE p.kunjungan_id='".$rw['kunj_id']."'
							ORDER BY p.id,tk.id LIMIT 1";
					$qTgl=mysql_query($sTgl);
					$rwTgl=mysql_fetch_array($qTgl);
							
					$sUnit="SELECT
							p.id AS pelayanan_id,
							u.id,
							u.nama
							FROM b_pelayanan p
							INNER JOIN b_tindakan_kamar tk ON tk.pelayanan_id=p.id
							INNER JOIN b_ms_unit u ON u.id=p.unit_id
							WHERE p.kunjungan_id='".$rw['kunj_id']."' AND u.inap=1
							ORDER BY tk.tgl_in DESC LIMIT 1";
					$qUnit=mysql_query($sUnit);
					$rwUnit=mysql_fetch_array($qUnit);
					
					$tgl=$rwTgl['tgl'];
					$pelayanan_id=$rwUnit['pelayanan_id'];
					$unit_id=$rwUnit['id'];
					$unit=$rwUnit['nama'];
				}
				else{
					$sTglUnit="SELECT 
								DATE_FORMAT(k.tgl,'%d-%m-%Y') AS tgl,
								u.id,
								u.nama
								FROM b_kunjungan k
								INNER JOIN b_ms_unit u ON u.id=k.unit_id
								WHERE k.id='".$rw['kunj_id']."'";
					$qTglUnit=mysql_query($sTglUnit);
					$rwTglUnit=mysql_fetch_array($qTglUnit);
					
					$tgl=$rwTglUnit['tgl'];
					$unit_id=$rwTglUnit['id'];
					$unit=$rwTglUnit['nama'];
				}
				//echo "-----sisAts".$sisa_tagihan."|||";
				//echo "-----Krg".$kurang."|||";
				$sisa_tagihan=$kurang;
				if($kurang<0) $sisa_tagihan=0;
				
				$sisafarmasi = $sisaFarm;
				
				if($ksoid==9){
					$sisafarmasi = $subTotal;
				}
				
				$sisabilling = $sisa_tagihan - $sisafarmasi;
				
				//echo "jkunj=$jenis_kunjungan, sisa=".$sisa_tagihan.", sifarm=".$sisafarmasi.", sisbil=".$sisabilling."<br>";
				
				$rencBPJS="";
				if($rw['renc_bpjs']=='1' && $rw['kso_id']){
					$rencBPJS="Rencana BPJS";
				}

				//query cek konsul+MRS
				$sql2="SELECT * FROM(
						SELECT p.id, p.id AS pelayanan_id,p.tgl AS tgl_pelayanan, p.kunjungan_id, DATE_FORMAT(p.tgl, '%d-%m-%Y') tgl, u.id AS unit_id, u.nama AS unit, u2.nama AS unitasal FROM b_pelayanan p
						INNER JOIN b_ms_unit u ON u.id = p.unit_id
						INNER JOIN b_ms_unit u2 ON u2.id = p.unit_id_asal
						LEFT JOIN b_tindakan t ON t.pelayanan_id = p.id
						WHERE p.kunjungan_id = '".$rw['kunj_id']."' AND p.unit_id NOT IN (122,123) AND t.user_id IS NULL ) AS tbl
						WHERE (SELECT COUNT(d.diagnosa_id) FROM b_diagnosa d WHERE d.pelayanan_id = tbl.pelayanan_id) <= 0
						  AND (SELECT COUNT(t.id) FROM b_tindakan t WHERE t.pelayanan_id = tbl.pelayanan_id AND t.user_id <> 0) <= 0
						  AND (SELECT COUNT(ap.ID) FROM $dbapotek.a_penjualan ap WHERE ap.NO_KUNJUNGAN = tbl.pelayanan_id) <= 0 
						  AND (SELECT COUNT(p2.id) FROM b_pelayanan p2 INNER JOIN b_ms_unit u2 ON u2.id = p2.unit_id
								WHERE p2.kunjungan_id = tbl.kunjungan_id AND p2.unit_id_asal = tbl.unit_id AND u2.inap = 0) <= 0
						  AND (SELECT COUNT(p3.id) FROM b_pelayanan p3 INNER JOIN b_ms_unit u3 ON u3.id = p3.unit_id
								WHERE p3.kunjungan_id = tbl.kunjungan_id AND p3.unit_id_asal = tbl.unit_id AND u3.inap = 1) <= 0
						  AND DATEDIFF(NOW(), tbl.tgl_pelayanan) <= 0
						GROUP BY tbl.pelayanan_id";
				//echo $sql2."<br>";
				$rs2=mysql_query($sql2);
				$jmldata=mysql_num_rows($rs2);
			//akhir cek konsul+MRS
				
               	$val=
				$rw['id']."|".				//0
				$rw['no_rm']."|".			//1
				$rw['nama']."|".			//2
				$rw['alamat']."|".			//3
               	$rw['nama_ortu']."|".		//4
				$rw['sex']."|".				//5
				$rw['no_billing']."|".		//6
				$total."|".					//7
		   		$kurang."|".				//8
				$rw['kunj_id']."|".			//9
				$tgl."|".					//10
				$pelayanan_id."|".			//11
				$rwTitip['titip']."|".		//12
				$rw['kso_id']."|".			//13
				$jaminan."|".				//14
				$rw['no_billing']."|".		//15
				$igdTot."|".				//16
				$igdKurang."|".				//17
				$igdJaminan."|".			//18
				$AmbulanTot."|".			//19
				$AmbulanKurang."|".			//20
				$AmbulanJaminan."|".		//21
				$JenazahTot."|".			//22
				$JenazahKurang."|".			//23
				$JenazahJaminan."|".		//24
				$selisih_lebih_kurang."|".	//25
				$bObat."|".					//26
				$bayar."|".					//27
				$jenis_kunjungan."|".		//28
				$isNaikKelas."|".			//29
				$rw['bpjs_tipe_bayar']."|".	//30
				$rw['kso_id']."|".			//31
				$unit_id."|".				//32
				$rencBPJS."|".				//33
				$sudah_pulang."|".			//34
				$subTotal."|".				//35
				$msgObat."|".				//36
				$totalTiapResep."|".		//37
				$subTotalObat."|".			//38
				$kurang2."|".				//39
				$jmldata."|".				//40
				$sisabilling;				//41
				
				//echo "===".$sisa_tagihan;
				//echo "===".$msgObat."<br>";
				//echo "===".$subTotal."<br>";

				echo json_encode($val);
			}
				
				//if($sisa_tagihan>0 || $status=="all" || ($sudah_pulang==0 && $jenis_kunjungan==3)){
               ?>