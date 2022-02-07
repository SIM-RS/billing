<?php
include("../koneksi/konek.php");
include("../include/variable.inc.php");
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="ap.NO_PENJUALAN";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
$id = $_REQUEST['rowid'];
//echo $tgl."<br>";
$grd = $_REQUEST['grd'];
$posting = $_REQUEST["posting"];
$kso = $_REQUEST["kso"];
$cmbFarmasi = $_REQUEST["cmbFarmasi"];
$tanggal = tglSQL($_REQUEST["tanggal"]);
$tanggalSlip = tglSQL($_REQUEST["tanggalSlip"]);
$no_slip = $_REQUEST["no_slip"];

$shift = $_REQUEST["shift"];
$userId = $_REQUEST["userId"];
//===============================
$idTrans_Penerimaan_Kasir_Farmasi=39;
//===============================
$statusProses='';
$alasan='';
$msg="sukses";

switch(strtolower($_REQUEST['act'])) {
	case "verif_penerimaan_kasir_farmasi_progress":
		$fdata=$_REQUEST["fdata"];
		$arfdata=explode(chr(6),$fdata);
		//echo "arfdata=".$arfdata."<br>";
		if ($posting==0)
		{
			$msg="Proses Verifikasi Berhasil !";
			for ($i=0;$i<count($arfdata);$i++)
			{
				$cdata=explode("|",$arfdata[$i]);
				
				$IdUnit=$cdata[0];
				$NoPenjualan=$cdata[1];
				$NoRm=$cdata[2];
				$NoResep=$cdata[3];
				$UserEntryResep=$cdata[4];
				$ShiftResep=$cdata[5];
				$cNilai=$cdata[6];
				$cNetto=$cdata[7];
				$IdUnitBilling=$cdata[8];
				$Kso_Id=$cdata[9];
				$IdKreditUtang=$cdata[10];
				$IdCaraBayar=$cdata[11];
				$kso_id_billing=$cdata[12];
				$isPavilyun=$cdata[13];
				
				//if ($IdCaraBayar==1){
					$sql="UPDATE $dbapotek.a_penjualan SET VERIFIKASI=1,VERIFIKASI_ACT='$userId' WHERE UNIT_ID='$IdUnit' AND USER_ID='$UserEntryResep' AND TGL='$tanggal' AND NO_PENJUALAN='$NoPenjualan' AND NO_PASIEN='$NoRm' AND SHIFT='$ShiftResep' AND VERIFIKASI=0";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
				//}
				$sql="UPDATE $dbapotek.a_kredit_utang SET VERIF=1,USER_VERIF='$userId',TGL_VERIF=NOW() WHERE ID='$IdKreditUtang' AND VERIF=0";
				//echo $sql."<br>";
				$rsPost=mysql_query($sql);
				if (mysql_errno()==0 && mysql_affected_rows()>0)
				{
					$sql="INSERT INTO k_transaksi(fk_id,id_trans,tgl,tgl_klaim,no_bukti,no_faktur,no_terima,unit_id_billing,kso_id,kasir_id,nilai_sim,nilai,nilai_hpp,verifikasi,posting,user_act,tgl_act,cara_bayar,isFarmasi,isPavilyun,unit_id,ket) VALUES('$IdKreditUtang','$idTrans_Penerimaan_Kasir_Farmasi','$tanggal','$tanggalSlip','$no_slip','$NoPenjualan','$NoRm','$IdUnitBilling','$kso_id_billing','$UserEntryResep','$cNilai','$cNilai','$cNetto',1,0,'$userId',NOW(),'$IdCaraBayar','2','$isPavilyun','$IdUnit','Penerimaan Kasir Farmasi')";
					//echo $sql."<br>";
					$rsPost=mysql_query($sql);
					if (mysql_errno()>0){
						//if ($IdCaraBayar==1){
							$sql="UPDATE $dbapotek.a_penjualan SET VERIFIKASI=0,VERIFIKASI_ACT='0' WHERE UNIT_ID='$IdUnit' AND USER_ID='$UserEntryResep' AND TGL='$tanggal' AND NO_PENJUALAN='$NoPenjualan' AND NO_PASIEN='$NoRm' AND SHIFT='$ShiftResep' AND VERIFIKASI=1";
							//echo $sql."<br>";
							$rsPost=mysql_query($sql);
						//}
						$sql="UPDATE $dbapotek.a_kredit_utang SET VERIF=0,USER_VERIF='0',TGL_VERIF=NULL WHERE ID='$IdKreditUtang' AND VERIF='1'";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						
						$msg="Proses Verifikasi Gagal !";
					}
				}else{
					$msg="Proses Verifikasi Gagal !";
				}
			}
		}
		else{
			$msg="Proses UnVerifikasi Berhasil !";
			for ($i=0;$i<count($arfdata);$i++)
			{
				$cdata=explode("|",$arfdata[$i]);
				
				$IdUnit=$cdata[0];
				$NoPenjualan=$cdata[1];
				$NoRm=$cdata[2];
				$NoResep=$cdata[3];
				$UserEntryResep=$cdata[4];
				$ShiftResep=$cdata[5];
				$cNilai=$cdata[6];
				$cNetto=$cdata[7];
				$IdUnitBilling=$cdata[8];
				$Kso_Id=$cdata[9];
				$IdKreditUtang=$cdata[10];
				$IdCaraBayar=$cdata[11];
				
				//===Cek Sudah Posting apa belum===
				$sql = "select * FROM k_transaksi WHERE id_trans='$idTrans_Penerimaan_Kasir_Farmasi' AND tgl='$tanggal' AND no_faktur='$NoPenjualan' AND no_terima='$NoRm' AND unit_id_billing='$IdUnitBilling' AND kasir_id='$UserEntryResep' AND unit_id='$IdUnit' and posting = 0";
				$query = mysql_query($sql);
				if(mysql_num_rows($query) > 0){		
					/* $sql="SELECT * FROM $dbapotek.a_penjualan WHERE UNIT_ID='$IdUnit' AND USER_ID='$UserEntryResep' AND TGL='$tanggal' AND NO_PENJUALAN='$NoPenjualan' AND NO_PASIEN='$NoRm' AND SHIFT='$ShiftResep' AND VERIFIKASI=1 AND POSTING=0";
					//echo $sql.";<br>";
					$rsPost=mysql_query($sql);
					if (mysql_num_rows($rsPost)>0){ */
						//if ($IdCaraBayar==1){
							$sql="UPDATE $dbapotek.a_penjualan SET VERIFIKASI=0,VERIFIKASI_ACT=0 WHERE UNIT_ID='$IdUnit' AND USER_ID='$UserEntryResep' AND TGL='$tanggal' AND NO_PENJUALAN='$NoPenjualan' AND NO_PASIEN='$NoRm' AND SHIFT='$ShiftResep' AND VERIFIKASI=1 AND POSTING=0";
							//echo $sql."<br>";
							$rsPost=mysql_query($sql);
						//}
						$sql="UPDATE $dbapotek.a_kredit_utang SET VERIF=0,USER_VERIF='0',TGL_VERIF=NULL WHERE ID='$IdKreditUtang' AND VERIF=1";
						//echo $sql."<br>";
						$rsPost=mysql_query($sql);
						if (mysql_errno()==0 && mysql_affected_rows()>0)
						{
							$sql="DELETE FROM k_transaksi WHERE id_trans='$idTrans_Penerimaan_Kasir_Farmasi' AND tgl='$tanggal' AND no_faktur='$NoPenjualan' AND no_terima='$NoRm' AND unit_id_billing='$IdUnitBilling' AND kasir_id='$UserEntryResep' AND unit_id='$IdUnit' and posting = 0";
							//echo $sql."<br>";
							$rsPost=mysql_query($sql);
						}else{
							$msg="Proses UnVerifikasi Gagal !";
						}
					/* }else{
						$msg = "Proses unVerifikasi Gagal !. Transaksi Sudah Diposting, Jadi Tidak Bisa UnVerifikasi.";
					} */
				} else {
					$msg = "Proses unVerifikasi Gagal !. Transaksi Sudah Diposting, Jadi Tidak Bisa UnVerifikasi.";
				}
				// echo $msg;
			}
		}
		echo "OK";
		return;
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
	
    if ($grd == "penerimaanPenjualanObat") {
			if ($kso!=0){
				$fkso=" AND am.kso_id_billing='$kso'";
			}
			
			if ($cmbFarmasi!=0){
				$fFarmasi=" AND ap.UNIT_ID = '$cmbFarmasi'";
			}
			
			if ($shift!=0){
				$fShift=" AND ku.SHIFT='$shift'";
			}
			
			$fposting=" AND ku.VERIF = $posting";
			
			$sql="SELECT DISTINCT
					  ku.ID,
					  ku.NO_BAYAR,
					  ku.TOTAL_HARGA	AS HARGA_TOTAL,
					  kt.no_bukti,
					  SUM(FLOOR((ap.QTY_JUAL)*ap.HARGA_NETTO)) AS HARGA_NETTO,
					  ku.BILLING_BAYAR_OBAT_ID,
					  DATE_FORMAT(ap.TGL,'%d/%m/%Y') AS tgl1,
					  ap.TGL,
					  ap.UNIT_ID,
					  au.UNIT_NAME             AS apotek,
					  ap.NO_PENJUALAN,
					  ap.NO_RESEP,
					  ap.NO_PASIEN,
					  ap.USER_ID,
					  ap.NAMA_PASIEN,
					  ap.SHIFT,
					  ap.CARA_BAYAR,
					  cb.nama                  AS cbayar,
					  ap.KSO_ID,
					  IFNULL(pel.is_paviliun,0) AS isPavilyun,
					  am.kso_id_billing,
					  am.NAMA                  AS KSO,
					  aunit.UNIT_NAME,
					  aunit.unit_billing
					FROM $dbapotek.a_kredit_utang ku
					  INNER JOIN $dbapotek.a_penjualan ap
						ON (ku.FK_NO_PENJUALAN = ap.NO_PENJUALAN
							AND ku.UNIT_ID = ap.UNIT_ID
							AND ku.NORM = ap.NO_PASIEN)
					  INNER JOIN $dbapotek.a_unit au
						ON ap.UNIT_ID = au.UNIT_ID
					  INNER JOIN $dbapotek.a_cara_bayar cb
						ON cb.id = ap.CARA_BAYAR
					  LEFT JOIN $dbbilling.b_pelayanan pel
						ON ap.NO_KUNJUNGAN = pel.id
					  LEFT JOIN $dbapotek.a_mitra am
						ON ap.KSO_ID = am.IDMITRA
					  LEFT JOIN $dbapotek.a_unit aunit
						ON (ap.RUANGAN = aunit.UNIT_ID)
					  LEFT JOIN k_transaksi kt
						ON (ku.ID = kt.fk_id)
					WHERE (ku.BILLING_BAYAR_OBAT_ID = 0
							OR ku.BILLING_BAYAR_OBAT_ID IS NULL)
						AND DATE(ku.TGL_BAYAR) = '$tanggal'
						$fposting
						$fFarmasi $fShift $fkso $filter
					GROUP BY ap.NO_PENJUALAN,ap.UNIT_ID,ap.NAMA_PASIEN,ap.USER_ID,ap.KSO_ID,ap.SHIFT";
		/*$sqlSum = "select ifnull(sum(nilai),0) as totnilai from (".$sql.") sql36";
		$rsSum = mysql_query($sqlSum);
		$rwSum = mysql_fetch_array($rsSum);
		$stot = $rwSum["totnilai"];*/
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
				  INNER JOIN $dbbilling.b_ms_pegawai mp
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
				  IF(t.status_out=0,(IF(DATEDIFF(IFNULL(t.tgl_out,b.tgl),t.tgl_in)=0,1,
				  DATEDIFF(IFNULL(t.tgl_out,b.tgl),t.tgl_in))), 
				  (IF(DATEDIFF(IFNULL(t.tgl_out,b.tgl),t.tgl_in)=0,0,
				  DATEDIFF(IFNULL(t.tgl_out,b.tgl),t.tgl_in))))    jml,
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
				  INNER JOIN $dbapotek.a_mitra kso
					ON bt.kso_id = kso.IDMITRA
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
    
    //echo $sql."<br>";
    $rs=mysql_query($sql);
    $jmldata=mysql_num_rows($rs);
    if ($page=="" || $page=="0") $page=1;
    $tpage=($page-1)*$perpage;
    if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
    if ($page>1) $bpage=$page-1; else $bpage=1;
    if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
    $sql2=$sql." limit $tpage,$perpage";
    //echo $sql;

    $rs=mysql_query($sql2);
    $i=($page-1)*$perpage;
    $dt=$totpage.chr(5);

    if ($grd == "penerimaanPenjualanObat") {
		if($posting==0){
			$sqlTot="SELECT IFNULL(SUM(tot.HARGA_TOTAL),0) totJual,IFNULL(SUM(tot.HARGA_NETTO),0) totBahan FROM (".$sql.") AS tot";
			//echo $sqlTot."<br>";
			$rsTot=mysql_query($sqlTot);
			$rwTot=mysql_fetch_array($rsTot);
			$ntot=$rwTot["totJual"];
			$ntot2=$rwTot["totBahan"];
			while ($rows=mysql_fetch_array($rs)) 
			{
				$i++;
				$nilai=$rows["HARGA_TOTAL"];
				$netto=$rows["HARGA_NETTO"];
				$sisip=$rows["UNIT_ID"]."|".$rows["NO_PENJUALAN"]."|".$rows["NO_PASIEN"]."|".$rows["NO_RESEP"]."|".$rows["USER_ID"]."|".$rows["SHIFT"]."|".$nilai."|".$netto."|".$rows["unit_billing"]."|".$rows["KSO_ID"]."|".$rows["ID"]."|".$rows["CARA_BAYAR"]."|".$rows["kso_id_billing"]."|".$rows["isPavilyun"];
				$dt.=$sisip.chr(3).$i.chr(3).$rows["NO_BAYAR"].chr(3).$rows["no_bukti"].chr(3).$rows["NO_PASIEN"].chr(3).$rows["NAMA_PASIEN"].chr(3).$rows["KSO"].chr(3).$rows["UNIT_NAME"].chr(3).$rows["SHIFT"].chr(3).number_format($nilai,0,",",".").chr(3).number_format($netto,0,",",".").chr(3)."0".chr(6);
			}
		}
		else{
			$sqlTot="SELECT IFNULL(SUM(tot.HARGA_TOTAL),0) totJual,IFNULL(SUM(tot.HARGA_NETTO),0) totBahan FROM (".$sql.") AS tot";
			//echo $sqlTot."<br>";
			$rsTot=mysql_query($sqlTot);
			$rwTot=mysql_fetch_array($rsTot);
			$ntot=$rwTot["totJual"];
			$ntot2=$rwTot["totBahan"];
			while ($rows=mysql_fetch_array($rs)) 
			{
				$i++;
				$nilai=$rows["HARGA_TOTAL"];
				$netto=$rows["HARGA_NETTO"];
				$sisip=$rows["UNIT_ID"]."|".$rows["NO_PENJUALAN"]."|".$rows["NO_PASIEN"]."|".$rows["NO_RESEP"]."|".$rows["USER_ID"]."|".$rows["SHIFT"]."|".$nilai."|".$netto."|".$rows["unit_billing"]."|".$rows["KSO_ID"]."|".$rows["ID"]."|".$rows["CARA_BAYAR"]."|".$rows["kso_id_billing"]."|".$rows["isPavilyun"];
				$dt.=$sisip.chr(3).$i.chr(3).$rows["NO_BAYAR"].chr(3).$rows["no_bukti"].chr(3).$rows["NO_PASIEN"].chr(3).$rows["NAMA_PASIEN"].chr(3).$rows["KSO"].chr(3).$rows["UNIT_NAME"].chr(3).$rows["SHIFT"].chr(3).number_format($nilai,0,",",".").chr(3).number_format($netto,0,",",".").chr(3)."0".chr(6);
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
        $dt=substr($dt,0,strlen($dt)-1).chr(5).$_REQUEST['act']."|".$grd."|".number_format($ntot,0,",",".")."|".number_format($ntot2,0,",",".")."|".$msg;
        $dt=str_replace('"','\"',$dt);
    }else{
        $dt=$dt.chr(5).$_REQUEST['act']."|".$grd."|0|0";
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