<?php 
session_start();
if($_POST['excel']=='excel'){
header("Content-type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="penerimaan_pasien.xls"');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/JavaScript" language="JavaScript" src="../../theme/js/formatPrint.js"></script>
<title>.: Laporan Penerimaan Kasir :.</title>
</head>

<body>
<?php
	//session_start();
	include("../../koneksi/konek.php");
	// include("konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$txtJam1 = $_REQUEST['txtJam1'];
	$txtJam2 = $_REQUEST['txtJam2'];
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	
	$sqlUnit1 = "SELECT nama,inap FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	$inap = $rwUnit1['inap'];
	
if($_REQUEST['TmpLayanan']!=0){
	$sqlUnit2 = "SELECT nama,inap FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	$fTmpLay = " AND p.unit_id=".$_REQUEST['TmpLayanan'];
	$inap = $rwUnit2['inap'];
}else
	$fTmpLay = " AND p.jenis_layanan=".$_REQUEST['JnsLayanan'];

	
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);

if($_REQUEST['cmbKsr']!=0){
	
	$fKsr = " AND b.user_act=".$_REQUEST['cmbKsr'];
}

if($_REQUEST['StatusPas']!=0){
	$sqlKso = "SELECT id,nama from b_ms_kso where id = ".$_REQUEST['StatusPas'];
	$rsKso = mysql_query($sqlKso);
	$rwKso = mysql_fetch_array($rsKso);
	$fKso = " AND k.kso_id = ".$_REQUEST['StatusPas'];
}
$kasir = $_REQUEST['cmbKasir2'];
$nmKasir = $_REQUEST['nmKsr'];

$qKsr = "SELECT id, nama FROM b_ms_unit WHERE id = '".$kasir."'";
$rsKsr = mysql_query($qKsr);
$rwKsr = mysql_fetch_array($rsKsr);

$sqlKasir = "SELECT id, nama FROM b_ms_pegawai WHERE id = '".$nmKasir."'";
$rsKasir = mysql_query($sqlKasir);
$rwKasir = mysql_fetch_array($rsKasir);
?>
<table id="tblPrint" width="100%" border="0" cellspacing="0" cellpadding="0" align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td colspan="2"><b><?=$_SESSION['namaP'] ?><br /><?=$_SESSION['alamatP']?><br />
    Telepon <?=$_SESSION['tlpP'] ?><br />
    <?=$_SESSION['kotaP']?></b></td>
  </tr>
  <tr>
    <td colspan="2" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase;"><b>Laporan Penerimaan Kasir<br />Periode <?php echo $tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2]?></b></td>
  </tr>
  <tr>
    <td height="30" width="50%">&nbsp;Kasir : <span style="text-transform:uppercase; font-weight:bold; padding-left:10px;"><?php if($nmKasir==0) echo 'semua'; else echo $rwKasir['nama'];?></span></td>
	<td align="right">Yang Mencetak :&nbsp;<b><?php echo $rwPeg['nama'];?></b></td>
  </tr>
  <tr>
  	<td colspan="2">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
			<?php
				$sKol = "SELECT u.id, u.kode, u.nama, u.aktif
						FROM rspelindo_akuntansi.ak_ms_unit_new u
						WHERE u.tipe = 2
						  AND u.islast = 1
						  AND u.aktif = 1";
				$qKol = mysql_query($sKol);
				$kolAK = $casJum = array();
				while($qKol && $dKol = mysql_fetch_array($qKol)){
					$kol[$dKol['kode']] = $dKol['nama'];
					$kolAK[$dKol['kode']] = "<td width='150px' style='border-top:1px solid; border-bottom:1px solid;'>".$dKol['nama']."</td>";
					$casJum[] = "SUM(CASE WHEN t.ak_ms_unit_id = ".$dKol['id']." THEN bt.nilai ELSE 0 END) AS `".$dKol['kode']."`";
				}
				$jmlKolAk = count($kolAK);
				
				$kol = Array ( 
							'81001' => 'KLINIK UMUM', 
							'81002' => 'KLINIK SPESIALIS', 
							'81003' => 'KLINIK GIGI',
							'81004' => 'KLINIK TERPADU',
							'81005' => 'RONTGEN',
							'81006' => 'LABORAT',
							'81007' => 'FARMASI',
							'81008' => 'RAWAT INAP',
							'81009' => 'AMBULAN',
							'81010' => 'CT-SCAN',
							'81099' => 'LAINNYA',
							'41499' => 'UTIP'
						) ;
				
			?>
			<tr style="text-align:center; font-weight:bold;">
				<td width="30px" style="border-top:1px solid; border-bottom:1px solid;">No</td>
				<td width="100px" style="border-top:1px solid; border-bottom:1px solid;">Tgl Bayar</td>
				<td width="60px" style="border-top:1px solid; border-bottom:1px solid;">Jam</td>
				<td width="120px" style="border-top:1px solid; border-bottom:1px solid;">No.<br />Kwitansi</td>
                <td width="150px" style="border-top:1px solid; border-bottom:1px solid;">Nama Kasir</td>
				<td width="100px" style="border-top:1px solid; border-bottom:1px solid;">Tgl Kunjungan</td>
                <td width="100px" style="border-top:1px solid; border-bottom:1px solid;">No.RM</td>
				<td width="250px" style="border-top:1px solid; border-bottom:1px solid;" align="left">Nama Pasien</td>
				<td width="180px" style="border-top:1px solid; border-bottom:1px solid;">Status</td>
				<?php
					foreach($kol as $col){
						echo "<td width='130px' style='border-top:1px solid; border-bottom:1px solid;'>".$col."</td>";
					}
				?>
				<td width="130px" style="border-top:1px solid; border-bottom:1px solid; padding-right:20px;" align="right">PPN Nilai</td>
				<td width="130px" style="border-top:1px solid; border-bottom:1px solid; padding-right:20px;" align="right">Total</td>
			</tr>
			<?php
				if($nmKasir!=0){
					if ($kasir==0){
						$fKasir = " AND b.user_act = '".$nmKasir."'";
					}else{
						$fKasir = " AND b.kasir_id = '".$kasir."' AND b.user_act = '".$nmKasir."'";
					}
				}else{
					if ($kasir==0){
						$fKasir = "";
					}else{
						$fKasir = " AND b.kasir_id = '".$kasir."'";
					}
				}
				$sql = "SELECT gb.id, gb.no_kwitansi, gb.nm_kasir, SUM(gb.nilai) nilai, gb.nilai nilaiBayar,
							gb.jam, gb.tgl, gb.kwi, gb.no_rm, gb.tgl_kunjung, gb.pasien, gb.kso, IFNULL(gb.ak_ms_unit_id,0) ak_ms_unit_id,
							SUM(gb.`81001`) AS `81001`,
							SUM(gb.`81002`) AS `81002`,
							SUM(gb.`81003`) AS `81003`,
							SUM(gb.`81004`) AS `81004`,
							SUM(gb.`81005`) AS `81005`,
							SUM(gb.`81006`) AS `81006`,
							SUM(gb.`81007`) AS `81007`,
							SUM(gb.`81008`) AS `81008`,
							SUM(gb.`81009`) AS `81009`,
							SUM(gb.`81010`) AS `81010`,
							SUM(gb.`81099`) AS `81099`,
							SUM(gb.`41499`) AS `41499`,
							SUM(gb.PPN_NILAI) PPN_NILAI, gb.pegawai_id, gb.pegawai_nama
						FROM (SELECT b.id, b.no_kwitansi, 
							bt.tindakan_id, bt.tipe, 
							SUM(bt.nilai) nilai, b.nilai nilaiBayar,
							TIME_FORMAT(b.tgl_act, '%H:%i') AS jam,
							DATE_FORMAT(b.tgl, '%d-%m-%Y') AS tgl,
							DATE_FORMAT(k.tgl, '%d-%m-%Y') AS tgl_kunjung,
							b.no_kwitansi AS kwi,
							peg.nama AS nm_kasir,
							pas.no_rm,
							pas.nama AS pasien,
							kso.nama AS kso,
							t.ak_ms_unit_id,
							SUM(CASE WHEN t.ak_ms_unit_id = 2 THEN IF(t.biaya_utip>0,bt.nilai-t.biaya_utip,bt.nilai) ELSE 0 END) AS `81001`,
							SUM(CASE WHEN t.ak_ms_unit_id = 3 THEN IF(t.biaya_utip>0,bt.nilai-t.biaya_utip,bt.nilai) ELSE 0 END) AS `81002`,
							SUM(CASE WHEN t.ak_ms_unit_id = 4 THEN IF(t.biaya_utip>0,bt.nilai-t.biaya_utip,bt.nilai) ELSE 0 END) AS `81003`,
							SUM(CASE WHEN t.ak_ms_unit_id = 5 THEN IF(t.biaya_utip>0,bt.nilai-t.biaya_utip,bt.nilai) ELSE 0 END) AS `81004`,
							SUM(CASE WHEN t.ak_ms_unit_id = 6 THEN IF(t.biaya_utip>0,bt.nilai-t.biaya_utip,bt.nilai) ELSE 0 END) AS `81005`,
							SUM(CASE WHEN t.ak_ms_unit_id = 7 THEN IF(t.biaya_utip>0,bt.nilai-t.biaya_utip,bt.nilai) ELSE 0 END) AS `81006`,
							SUM(CASE WHEN t.ak_ms_unit_id = 8 THEN IF(t.biaya_utip>0,bt.nilai-t.biaya_utip,bt.nilai) ELSE 0 END) AS `81007`,
							SUM(CASE WHEN t.ak_ms_unit_id = 9 THEN IF(t.biaya_utip>0,bt.nilai-t.biaya_utip,bt.nilai) ELSE 0 END) AS `81008`,
							SUM(CASE WHEN t.ak_ms_unit_id = 10 THEN IF(t.biaya_utip>0,bt.nilai-t.biaya_utip,bt.nilai) ELSE 0 END) AS `81009`,
							SUM(CASE WHEN t.ak_ms_unit_id = 11 THEN IF(t.biaya_utip>0,bt.nilai-t.biaya_utip,bt.nilai) ELSE 0 END) AS `81010`,
							SUM(CASE WHEN IFNULL(t.ak_ms_unit_id,0) IN (12,0) THEN IF(t.biaya_utip>0,bt.nilai-t.biaya_utip,bt.nilai) ELSE 0 END) AS `81099`,
							SUM(CASE WHEN t.biaya_utip > 0 THEN t.biaya_utip ELSE 0 END) AS `41499`,
							0 AS PPN_NILAI, peg.id AS pegawai_id, peg.nama AS pegawai_nama
						FROM b_bayar_tindakan bt
						LEFT JOIN b_tindakan t ON t.id = bt.tindakan_id
						INNER JOIN b_bayar b ON b.id = bt.bayar_id
						INNER JOIN b_kunjungan k ON k.id = b.kunjungan_id
						INNER JOIN b_ms_pasien pas ON pas.id = k.pasien_id
						INNER JOIN b_ms_kso kso ON kso.id = k.kso_id
						INNER JOIN b_ms_unit u ON u.id = b.unit_id
						INNER JOIN b_ms_pegawai peg ON peg.id = b.user_act 
						WHERE bt.tipe = 0 
						  AND b.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."' 
						  AND TIME_FORMAT(b.tgl_act,'%H:%i') BETWEEN '$txtJam1' AND '$txtJam2'
						  {$fKasir}
						GROUP BY b.id
						UNION
						SELECT b.id, b.no_kwitansi, 
							bt.tindakan_id, bt.tipe, 
							SUM(bt.nilai) nilai, b.nilai nilaiBayar,
							TIME_FORMAT(b.tgl_act, '%H:%i') AS jam,
							DATE_FORMAT(b.tgl, '%d-%m-%Y') AS tgl,
							DATE_FORMAT(k.tgl, '%d-%m-%Y') AS tgl_kunjung,
							b.no_kwitansi AS kwi,
							peg.nama AS nm_kasir,
							pas.no_rm,
							pas.nama AS pasien,
							kso.nama AS kso,
							9 AS ak_ms_unit_id,
							0 AS `81001`,
							0 AS `81002`,
							0 AS `81003`,
							0 AS `81004`,
							0 AS `81005`,
							0 AS `81006`,
							0 AS `81007`,
							SUM(bt.nilai) AS `81008`,
							0 AS `81009`,
							0 AS `81010`,
							tk.retribusi AS `81099`,
							0 AS `41499`,
							0 AS PPN_NILAI, peg.id AS pegawai_id, peg.nama AS pegawai_nama
						FROM b_bayar_tindakan bt
						INNER JOIN b_bayar b ON b.id = bt.bayar_id
						INNER JOIN b_kunjungan k ON k.id = b.kunjungan_id
						INNER JOIN b_ms_pasien pas ON pas.id = k.pasien_id
						INNER JOIN b_ms_kso kso ON kso.id = k.kso_id
						INNER JOIN b_ms_unit u ON u.id = b.unit_id
						INNER JOIN b_ms_pegawai peg ON peg.id = b.user_act 
						INNER JOIN b_tindakan_kamar tk ON tk.id = bt.tindakan_id
						WHERE bt.tipe = 1
						  AND b.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."' 
						  AND TIME_FORMAT(b.tgl_act,'%H:%i') BETWEEN '$txtJam1' AND '$txtJam2'
						  {$fKasir}
						GROUP BY b.id
						UNION
						SELECT b.id, b.no_kwitansi, 
							bt.tindakan_id, bt.tipe, 
							SUM(bt.nilai) nilai, b.nilai nilaiBayar,
							TIME_FORMAT(b.tgl_act, '%H:%i') AS jam,
							DATE_FORMAT(b.tgl, '%d-%m-%Y') AS tgl,
							DATE_FORMAT(k.tgl, '%d-%m-%Y') AS tgl_kunjung,
							b.no_kwitansi AS kwi,
							peg.nama AS nm_kasir,
							pas.no_rm,
							pas.nama AS pasien,
							kso.nama AS kso,
							8 AS ak_ms_unit_id,
							0 AS `81001`,
							0 AS `81002`,
							0 AS `81003`,
							0 AS `81004`,
							0 AS `81005`,
							0 AS `81006`,
							SUM(bt.nilai) AS `81007`,
							0 AS `81008`,
							0 AS `81009`,
							0 AS `81010`,
							0 AS `81099`,
							0 AS `41499`,
							FLOOR(IFNULL(SUM(bt.nilai),0) * ap.PPN/100) AS PPN_NILAI, peg.id AS pegawai_id, peg.nama AS pegawai_nama
						FROM b_bayar_tindakan bt
						LEFT JOIN rspelindo_apotek.a_penjualan ap ON ap.ID = bt.tindakan_id
						INNER JOIN b_bayar b ON b.id = bt.bayar_id
						INNER JOIN b_kunjungan k ON k.id = b.kunjungan_id
						INNER JOIN b_ms_pasien pas ON pas.id = k.pasien_id
						INNER JOIN b_ms_kso kso ON kso.id = k.kso_id
						INNER JOIN b_ms_unit u ON u.id = b.unit_id
						INNER JOIN b_ms_pegawai peg ON peg.id = b.user_act 
						WHERE bt.tipe = 2 
						  AND b.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."' 
						  AND TIME_FORMAT(b.tgl_act,'%H:%i') BETWEEN '$txtJam1' AND '$txtJam2'
						  {$fKasir}
						GROUP BY ap.NO_KUNJUNGAN,ap.NO_PENJUALAN,ap.UNIT_ID,ap.USER_ID,ap.KSO_ID,ap.NO_PASIEN) AS gb
						GROUP BY gb.id
						ORDER BY gb.id";
					//echo $sql;
					$query = mysql_query($sql) or die(mysql_error());
					$no = 1;
					$total = array();
					while($data = mysql_fetch_array($query)){
						echo "<tr>";
						echo "<td align='center'>{$no}</td>";
						echo "<td align='center'>".$data['tgl']."</td>";
						echo "<td align='center'>".$data['jam']."</td>";
						echo "<td align='center'>".$data['kwi']."</td>";
						echo "<td align='center'>".$data['nm_kasir']."</td>";
						echo "<td align='center'>".$data['tgl_kunjung']."</td>";
						echo "<td align='center'>".$data['no_rm']."</td>";
						echo "<td>".$data['pasien']."</td>";
						echo "<td align='center'>".$data['kso']."</td>";
						$subtotal = 0;
						foreach($kol as $key => $val){
							echo "<td align='right'>".number_format($data[$key],0,",",".")."</td>";
							$total[$key] = $total[$key] + $data[$key];
							$subtotal += $data[$key];
						}
						
						echo "<td align='right' >".number_format($data['PPN_NILAI'],0,",",".")."</td>";
						$total['PPN'] = $total['PPN'] + $data['PPN_NILAI'];
						
						$subtotal += $data['PPN_NILAI'];
						echo "<td align='right' style='font-weight:bold;'>".number_format($subtotal,0,",",".")."</td>";
						
						$total['subtotal'] += $subtotal;
						echo "</tr>";
						$no++;
					}
					/* while($data = mysql_fetch_array($query)){
						
					} */
					
					if($nmKasir!=0){
						$fKasir = "b_bayar.user_act = '".$nmKasir."'";
					}else{
						$fKasir = "b_ms_pegawai_unit.unit_id = '".$kasir."'";
					}
				?>
			<tr style="background:#efefef;">
				<td height="25" colspan="9" style="text-align:right; font-weight:bold; border-top:1px solid; ">GRAND TOTAL&nbsp;</td>
				<!-- td style="text-align:right; padding-right:20px; border-top:1px solid; font-weight:bold;"><?php echo number_format($gtotal,0,",",".");?></td-->
				<?php
					foreach($total as $nilai){
						echo "<td align='right' style='border-top:1px solid; font-weight:bold;'>".number_format($nilai,0,",",".")."</td>";
					}
				?>
			</tr>
		</table>
	</td>
  </tr>
  <tr>
  	<td colspan="2" height="30">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td align="right">Tgl Cetak:&nbsp;<?php echo $date_now;?>&nbsp;Jam:&nbsp;<?php echo $jam?></td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td align="right">Yang Mencetak</td>
  </tr>
  <tr>
  	<td colspan="2" height="50">&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td align="right"><b><?php echo $rwPeg['nama'];?></b></td>
  </tr>
  <?php
  mysql_close($konek);
  ?>
  <tr>
  	<td colspan="2" height="50">
	 <tr id="trTombol">
       <td colspan="3" class="noline" align="center">
			<?php 
			if($_POST['excel']!='excel'){
			?>
            <select  name="select" id="cmbPrint2an" onchange="changeSize(this.value)" style="display:none;">
              <option value="0">Printer Dot Matrix</option>
              <option value="1">Printer Tinta</option>
            </select>
			<br />
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
			<?php } ?>
            </td>
    </tr>
	</td>
  </tr>
</table>
</body>
<script type="text/JavaScript">

/*try{	
formatF4Portrait();
}catch(e){
window.location='../../addon/jsprintsetup.xpi';
}*/
function changeSize(par){
	if(par == 1){
		document.getElementById('tblPrint').width = 1200;
	}
	else{
		document.getElementById('tblPrint').width = 800;
	}
}

    function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
		/*try{
			mulaiPrint();
		}
		catch(e){
			window.print();
		}*/
		window.print();
		window.close();
        }
    }
</script>
</html>
