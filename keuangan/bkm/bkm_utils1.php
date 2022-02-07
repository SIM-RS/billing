<?php
	include("../koneksi/konek.php");
	//====================================================================
	//Paging,Sorting dan Filter======
	$page=$_REQUEST["page"];
	$defaultsort="id";
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
	$userId=$_REQUEST['userId'];
	$kunj_id = $_REQUEST['kunjungan_id'];
	$rekBank = $_REQUEST['rekBank'];
	$bkm_id=$_REQUEST['klaim_id'];
	$grid = $_REQUEST['grid'];
	$thn = $_REQUEST['thn'];
	$bln = $_REQUEST['bln'];
	$data = $_REQUEST['data'];
	$tgl = tglSQL($_REQUEST['txtTgl']);
	$tglF = tglSQL($_REQUEST['tglF']);
	$tglL = tglSQL($_REQUEST['tglL']);
	//===============================
	$statusProses='';
	$alasan='';

	switch(strtolower($_REQUEST['act'])) {
		case 'buat_klaim':
			$bkm_id=0;
			$tglBKM=tglSQL($_REQUEST['tglBKM']);
			$no_bkm=$_REQUEST['no_bukti'];
			$terimaDari=$_REQUEST['terimaDari'];
			$uraian=$_REQUEST['uraian'];
			$sql = "INSERT INTO k_bkm (no_bkm, tgl, ms_rek_bank_id, terima_dari, uraian, nilai, user_act, tgl_act)
					VALUES ('{$no_bkm}', '{$tglBKM}', '{$rekBank}', '{$terimaDari}', '{$uraian}', 0, '{$userId}', NOW());";
			$rs=mysql_query($sql);
			if (mysql_affected_rows()>0){
				$bkm_id=mysql_insert_id();
			}
			echo $bkm_id;
			return;
			break;
		case 'hapus_klaim':
			$scek = "SELECT count(bd.id) jml
					FROM k_bkm_detail bd
					WHERE bd.bkm_id = {$bkm_id}";
			$qcek = mysql_query($scek);
			$dcek = mysql_fetch_array($qcek);
			if($dcek['jml'] <= 0){
				$sql="DELETE FROM k_bkm WHERE id='{$bkm_id}'";
				$rs=mysql_query($sql);
				echo 'Berhasil menghapus data BKM!';
			} else {
				echo 'Tidak dapat menghapus data BKM!';
			}
			return;
			break;
		case 'verifikasi':
			$total = 0;
			$fdata = $_REQUEST["fdata"];
			$arfdata = explode(chr(6),$fdata);
			if($posting == 0){
				foreach($arfdata as $val){
					$param = explode('|',$val);
					switch($param[2]){
						case 38:
						case 39:
						case 64:
							if($param[2] == 38){
								$fuKas = "AND t.kasir_id = ".$param[3];
							} else {
								$fuKas = "";
							}
							$kolKas = ", kasir_id";
							$kasir = ",".$param[3];
							$kasir_id = $param[3];
							break;
						default:
							$kolKas = "";
							$kasir = "";
							break;
					}
					
					$sql = "INSERT INTO keuangan.k_bkm_detail(bkm_id, id_trans {$kolKas}, shift, no_bukti, nilai)
							VALUES ('{$bkm_id}', '".$param[2]."' {$kasir}, '', '".$param[0]."', '".$param[1]."')";
					$query = mysql_query($sql);
					
					$total += $param[1];
					if (mysql_affected_rows()>0){
						$bkm_detail_id=mysql_insert_id();
					/* }
					
					if(mysql_errno <= 0){ */
						$tgl_setor = $param[5];
						//echo $param[2]."<br /><br />";
						switch($param[2]){
							case 38:
							case 39:
								$sUpdate = "UPDATE k_transaksi as t
									SET t.bkm_detail_id = {$bkm_detail_id}
									WHERE t.no_bukti = '".$param[0]."'
									  AND t.id_trans = '".$param[2]."'
									  AND t.tgl_klaim BETWEEN '{$tglF} 00:00:00' 
									  AND '{$tglL} 23:59:59'
										  {$fuKas}";
								$qUpdate = mysql_query($sUpdate);
								break;
							case 6:
								$sUpdate = "UPDATE k_parkir as p
											SET p.bkm_detail_id = '{$bkm_detail_id}'
											WHERE p.no_bukti = '".$param[0]."'
											  AND DATE(p.tgl_setor) = '{$tgl_setor}' /*  BETWEEN '{$tglF} 00:00:00' 
											  AND '{$tglL} 23:59:59' */";
								$qUpdate = mysql_query($sUpdate);
								break;
							case 30:
								$sUpdate = "UPDATE k_ambulan as p
											SET p.bkm_detail_id = '{$bkm_detail_id}'
											WHERE p.no_bukti = '".$param[0]."'
											  AND DATE(p.tgl_setor) = '{$tgl_setor}' /* BETWEEN '{$tglF} 00:00:00' 
											  AND '{$tglL} 23:59:59' */";
								$qUpdate = mysql_query($sUpdate);
								break;
							case 64:
								$sUpdate = "UPDATE db_rspendidikan.ku_bayar as p
											SET p.bkm_detail_id = '{$bkm_detail_id}'
											WHERE p.byr_kode = '".$param[0]."'
											  AND DATE(p.tgl_verifikasi) BETWEEN '{$tglF} 00:00:00' 
											  AND '{$tglL} 23:59:59'
											  AND p.petugas_id = '{$kasir_id}'";
								$qUpdate = mysql_query($sUpdate);
								break;
						}
					}
				}
				$sBkm = "UPDATE k_bkm as b
						SET b.nilai = b.nilai+{$total}
						WHERE b.id = {$bkm_id}";
				$qBkm = mysql_query($sBkm);
			} else {
				foreach($arfdata as $val){
					$param = explode('|',$val);
					//echo $param[6]."<br />";
					switch($param[2]){
						case 38:
							$unVer = "UPDATE k_transaksi AS t
										SET t.bkm_detail_id = NULL
										WHERE t.id_trans = 38
										  AND t.bkm_detail_id = ".$param[6];
							break;
						case 39:
							$unVer = "UPDATE k_transaksi AS t
										SET t.bkm_detail_id = NULL
										WHERE t.id_trans = 39
										  AND t.bkm_detail_id = ".$param[6];
							break;
						case 6:
							$unVer = "UPDATE k_parkir AS t
										SET t.bkm_detail_id = NULL
										WHERE t.bkm_detail_id = ".$param[6];
							break;
						case 30:
							$unVer = "UPDATE k_ambulan AS t
										SET t.bkm_detail_id = NULL
										WHERE t.bkm_detail_id = ".$param[6];
							break;
						case 64:
							$unVer = "UPDATE db_rspendidikan.ku_bayar AS t
										SET t.bkm_detail_id = NULL
										WHERE t.bkm_detail_id = ".$param[6];
							break;
					}
					$qunVer = mysql_query($unVer);
					if(mysql_errno() <= 0){
						$sTotal = "SELECT nilai, bkm_id FROM k_bkm_detail WHERE id = ".$param[6];
						$qTotal = mysql_query($sTotal);
						$dTotal = mysql_fetch_array($qTotal);
						
						$supBkm = "UPDATE k_bkm as b
									SET b.nilai = (b.nilai-".$dTotal['nilai'].")
									WHERE b.id = ".$dTotal['bkm_id'];
						$qupBkm = mysql_query($supBkm);
						
						if(mysql_errno() <= 0){
							$delBkm = "DELETE
										FROM k_bkm_detail
										WHERE id = '".$param[6]."'";
							$sdelBkm = mysql_query($delBkm) or die ('Unverif Hapus BKM Detail Gagal! '.mysql_error());
						}
					}
				}
			}
			break;
	}

	$fRek="";
	if ($rekBank!="0"){
		$fRek=" AND kso.id='$kso'";
	}
	if ($filter!="") {
        $filter=explode("|",$filter);
        $filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
    }
    if ($sorting=="") {
        $sorting=$defaultsort;
    }
	
	switch($grid){
		case 'klaim':
			$sql = "SELECT *
					FROM (SELECT b.*, rb.no_rek, rb.nama, rb.nama_bank
							FROM k_bkm b
							INNER JOIN k_ms_rek_bank rb
							   ON rb.id = b.ms_rek_bank_id
						  WHERE YEAR(b.tgl) = '{$thn}' AND MONTH(b.tgl) = '{$bln}' {$filter} ) t1
					ORDER BY {$sorting}";
			break;
		case 'list':				
			if($posting == 0){
				$fwhere = array(
								'bilfar' => " t.bkm_detail_id IS NULL 
												OR t.bkm_detail_id = 0 
												AND t.tgl_klaim BETWEEN '{$tglF} 00:00:00' 
												AND '{$tglL} 23:59:59'",
								'parkir' => " p.bkm_detail_id IS NULL
												OR p.bkm_detail_id = 0 
												AND p.tgl_setor BETWEEN '{$tglF} 00:00:00' 
												AND '{$tglL} 23:59:59'",
								'ambulan' => " a.bkm_detail_id IS NULL
												OR a.bkm_detail_id = 0 
												AND a.tgl_setor BETWEEN '{$tglF} 00:00:00' 
												AND '{$tglL} 23:59:59'",
								'diklit' => " b.bkm_detail_id IS NULL
												OR b.bkm_detail_id = 0 
												AND b.tgl_verifikasi BETWEEN '{$tglF} 00:00:00' 
												AND '{$tglL} 23:59:59'",
						  );
				$fjoin = array();
			} else {
				$fwhere = array(
								'bilfar' => " t.bkm_detail_id IS NOT NULL
											OR t.bkm_detail_id <> 0 
											AND bd.bkm_id = '{$bkm_id}'",
								'parkir' => " p.bkm_detail_id IS NOT NULL
											OR p.bkm_detail_id <> 0 
											AND bd.bkm_id = '{$bkm_id}'",
								'ambulan' => " a.bkm_detail_id IS NOT NULL
											OR a.bkm_detail_id <> 0 
											AND bd.bkm_id = '{$bkm_id}'",
								'diklit' => " b.bkm_detail_id IS NOT NULL
											OR b.bkm_detail_id <> 0 
											AND bd.bkm_id = '{$bkm_id}'",
						  );
				$fjoin = array(
							'bilfar' => ' INNER JOIN k_bkm_detail bd
							                  ON bd.id = t.bkm_detail_id',
							'parkir' => ' INNER JOIN k_bkm_detail bd
							                  ON bd.id = p.bkm_detail_id',
							'ambulan' => ' INNER JOIN k_bkm_detail bd
							                  ON bd.id = a.bkm_detail_id',
							'diklit' => ' INNER JOIN k_bkm_detail bd
							                  ON bd.id = b.bkm_detail_id',
						);
			}
			
			$datas = array(
				'billing' => "SELECT /* IF(t.id_trans = 38, 'Penerimaan Billing', 'Penerimaan Farmasi') AS des,  */
									t.no_bukti, SUM(t.nilai) nilai,
								   t.kasir_id, '' shift, t.id_trans id, t.tgl_klaim tgl_setor, mp.nama, t.bkm_detail_id
							FROM k_transaksi t
							/* INNER JOIN $dbbilling.b_ms_unit u
							   ON u.id = t.kasir_id */
							INNER JOIN $dbbilling.b_ms_pegawai mp
							   ON mp.id = t.kasir_id
							".$fjoin['bilfar']."
							WHERE ".$fwhere['bilfar']."
							  AND t.id_trans = 38
							GROUP BY t.id_trans, t.no_bukti, t.kasir_id",
				'farmasi' => "SELECT /* IF(t.id_trans = 38, 'Penerimaan Billing', 'Penerimaan Farmasi') AS des,  */
									t.no_bukti, SUM(t.nilai) nilai,
								   t.kasir_id, '' shift, t.id_trans id, t.tgl_klaim tgl_setor, u.username nama, t.bkm_detail_id
							FROM k_transaksi t
							/* INNER JOIN $dbbilling.b_ms_unit u
							   ON u.id = t.kasir_id */
							INNER JOIN $dbapotek.a_user u
							   ON u.kode_user = t.kasir_id
							".$fjoin['bilfar']."
							WHERE ".$fwhere['bilfar']."
							  AND t.id_trans = 39
							GROUP BY t.id_trans, t.no_bukti",
				'parkir' => "SELECT /* 'Penerimaan Parkir' AS des,  */p.no_bukti, SUM(p.nilai) nilai, p.user_act, p.shift, 
									6 AS id, p.tgl_setor,
									u.nama, p.bkm_detail_id
							FROM k_parkir p
							INNER JOIN k_ms_user u
							   ON u.id = p.user_act
							".$fjoin['parkir']."
							WHERE ".$fwhere['parkir']."
							GROUP BY p.no_bukti, DATE(p.tgl_setor)",
				'ambulan' => "SELECT /* 'Penerimaan Ambulan' AS des,  */a.no_bukti, SUM(a.nilai) nilai, a.user_act, '', 
									30 AS id, a.tgl_setor,
									u.nama, a.bkm_detail_id
							FROM k_ambulan a
							INNER JOIN k_ms_user u
							   ON u.id = a.user_act
							".$fjoin['ambulan']."
							WHERE ".$fwhere['ambulan']."
							GROUP BY a.no_bukti, DATE(a.tgl_setor)",
				'diklit' => "SELECT b.byr_kode no_bukti, SUM(b.nilai) nilai, b.petugas_id kasir_id, '' shift, '64' id, 
									b.tgl_verifikasi tgl_setor, p.pgw_nama nama, b.bkm_detail_id
							FROM db_rspendidikan.ku_bayar b
							INNER JOIN db_rspendidikan.pegawai p
							   ON p.pgw_id = b.petugas_id
							".$fjoin['diklit']."
							WHERE ".$fwhere['diklit']."
							  AND b.verifikasi = 1
							GROUP BY b.byr_kode, b.petugas_id"
			);
			
			$dataF = "";
			switch($data){
				case 0:
					$sdata = $datas['billing']." UNION ".$datas['farmasi']." UNION ".$datas['parkir']." UNION ".$datas['ambulan']." UNION ".$datas['diklit'];
					break;
				case 1:
					$sdata = $datas['billing'];
					break;
				case 2:
					$sdata = $datas['farmasi'];
					/* $dataF = " AND t1.id = '39'"; */
					break;
				case 3:
					$sdata = $datas['parkir'];
					break;
				case 4:
					$sdata = $datas['ambulan'];
					break;
				case 5:
					$sdata = $datas['diklit'];
					break;
			}
			
			$sql = "SELECT * 
					FROM ({$sdata}) t1 
					WHERE 0 = 0 {$filter}
					ORDER BY {$sorting}"; //{$dataF}
			break;
	}
	
	//echo $sql."<br>";
    $rs=mysql_query($sql) or die (mysql_error());
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
	
	switch($grid){
		case 'klaim':
			while ($rows=mysql_fetch_array($rs)){
				$i++;
				$tedit="<img src='../icon/edit.gif' border='0' width='16' height='16' align='absmiddle' class='proses' title='Klik Untuk Mengubah' onClick='fEditKlaim({$i})'>";
				$thapus="<img src='../icon/del.gif' border='0' width='16' height='16' align='absmiddle' class='proses' title='Klik Untuk Menghapus' onClick='fHapusKlaim(".$rows["id"].");'>";
				$tstatus="-";
				$view="<img src='../icon/lihat.gif' border='0' width='16' height='16' align='absmiddle' class='proses' title='View Laporan BKM' onclick='lapBKM(".$rows["id"].");'>";
				/* switch ($rows["verifikasi"]){
					case 0:
						$tstatus="Proses Pengajuan";
						$tverif="<img src='../icon/go.png' border='0' width='16' height='16' align='absmiddle' class='proses' title='Klik Untuk Verifikasi / Approve Pengajuan Klaim' onClick='fVerifKlaim(".$rows["id"].",".$rows["verifikasi"].");'>";
						break;
					case 1:
						$tstatus="Pengajuan ke KSO";
						$tverif="<img src='../icon/save.ico' border='0' width='16' height='16' align='absmiddle' class='proses' title='Klik Untuk Membatalkan Pengajuan Klaim' onClick='fVerifKlaim(".$rows["id"].",".$rows["verifikasi"].");'>";
						break;
					case 2:
						$tstatus="Sudah Dibayar";
						break;
				} */
				$tproses=$tedit."      |     ".$view."      |     ".$thapus;
				$verifikasi = 0;
				$sisip=$rows["id"]."|".$rows["ms_rek_bank_id"]."|".$rows["nilai"]."|".$rows["no_bkm"]."|".$rows["nama_bank"]." - ".$rows['nama']."|".$verifikasi."|".$rows["uraian"];
				$dt.=$sisip.chr(3).number_format($i,0,",","").chr(3).tglSQL($rows["tgl"]).chr(3).$rows["no_bkm"].chr(3).$rows["nama_bank"].chr(3).number_format($rows["nilai"],0,",",".").chr(3).$rows["terima_dari"].chr(3).$rows["uraian"].chr(3).$tproses.chr(3).$tstatus.chr(6);
			}
			break;
			
		case 'list':
			while($rows=mysql_fetch_array($rs)){
				$i++;
				if($posting == 0){
					$disabled = "";
				} else {
					$disabled = ""; //"disabled='true'";
				}
				switch($rows['id']){
					case 38:
						$des = "Penerimaan Billing";
						break;
					case 39:
						$des = "Penerimaan Farmasi";
						break;
					case 6:
						$des = "Penerimaan Parkir";
						break;
					case 30:
						$des = "Penerimaan Ambulan";
						break;
					default:
						$des = "Penerimaan Diklit";
						break;
				}
				$tgl_setor = explode(' ',$rows['tgl_setor']);
				$sisip = $rows['no_bukti'].'|'.$rows['nilai'].'|'.$rows['id'].'|'.$rows['kasir_id'].'|'.$rows['shift'].'|'.$tgl_setor[0].'|'.$rows['bkm_detail_id'];
				$dt .= $sisip.chr(3).number_format($i,0,",","").chr(3).$des.chr(3).tglSQL($tgl_setor[0]).chr(3).$rows['no_bukti'].chr(3).$rows['nilai'].chr(3).$rows['nama'].chr(3).'0" '.$disabled.chr(6);
			}
			break;
	}
	
	if ($dt!=$totpage.chr(5)) {
        $dt=substr($dt,0,strlen($dt)-1).chr(5);
        $dt=str_replace('"','\"',$dt);
		
		if($grid == 1){
			$dt = $dt.number_format($totPer,0,",",".").chr(3).number_format($totPas,0,",",".").chr(3).number_format($totKso,0,",",".").chr(3).$totKsoKlaim.chr(3).number_format($totPiutangPx,0,",",".").chr(3).$alasan;
		}
    }
    
    mysql_free_result($rs);
	mysql_close($konek);
	
	header("Cache-Control: no-cache, must-revalidate" );
	header("Pragma: no-cache" );
	if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
		header("Content-type: application/xhtml+xml");
	}else {
		header("Content-type: text/xml");
	}
	echo $dt;
?>