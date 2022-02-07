<?php 
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
<title>.: Laporan Penerimaan Kasir Rawat Inap :.</title>
</head>

<body>
<?php
	//session_start();
	include("../../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	
	$sqlUnit1 = "SELECT nama,inap FROM b_ms_unit WHERE id = '".$_REQUEST['JnsLayanan']."'";
	$rsUnit1 = mysql_query($sqlUnit1);
	$rwUnit1 = mysql_fetch_array($rsUnit1);
	$inap = $rwUnit1['inap'];
	
	$jdlRpt="RSUD + PAVILYUN";
	$tipe=$_REQUEST['tipe'];
	$fkunj=0;
	if ($tipe==1){
		//$jdlRpt="PAVILYUN";
		$fkunj=1;
	}
	
if($_REQUEST['TmpLayanan']!=0){
	$sqlUnit2 = "SELECT nama,inap FROM b_ms_unit WHERE id = '".$_REQUEST['TmpLayanan']."'";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	$fTmpLay = " AND p.unit_id=".$_REQUEST['TmpLayanan'];
	$inap = $rwUnit2['inap'];
}else{
	$fTmpLay = " AND p.jenis_layanan=".$_REQUEST['JnsLayanan'];
}

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
$fkasir="";
if ($nmKasir!=0) $fkasir=" AND b.user_act='$nmKasir'";

$qKsr = "SELECT id, nama FROM b_ms_unit WHERE id = '".$kasir."'";
//echo $qKsr."<br>";
$rsKsr = mysql_query($qKsr);
$rwKsr = mysql_fetch_array($rsKsr);

$sqlKasir = "SELECT id, nama FROM b_ms_pegawai WHERE id = '".$nmKasir."'";
$rsKasir = mysql_query($sqlKasir);
$rwKasir = mysql_fetch_array($rsKasir);

$periode = $tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2]." S/D ".$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
$period = "BETWEEN '$tglAwal2' AND '$tglAkhir2'";

/*$sqlKSO="SELECT DISTINCT kso.id,kso.nama FROM b_bayar b INNER JOIN b_bayar_tindakan bt ON b.id=bt.bayar_id
INNER JOIN b_ms_kso kso ON bt.kso_id=kso.id INNER JOIN b_kunjungan k ON b.kunjungan_id=k.id
WHERE k.jenis_kunjungan=$fkunj AND b.tgl $period ORDER BY kso.id";
*/
$sqlKSO="SELECT DISTINCT kso.id,kso.nama FROM b_bayar b INNER JOIN b_bayar_tindakan bt ON b.id=bt.bayar_id
INNER JOIN b_ms_kso kso ON bt.kso_id=kso.id INNER JOIN b_kunjungan k ON b.kunjungan_id=k.id
WHERE b.tgl $period ORDER BY kso.id";
$rsKSO=mysql_query($sqlKSO);
$jml_kso = mysql_num_rows($rsKSO);
?>
<table id="tblPrint" border="0" cellspacing="0" cellpadding="0" align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td colspan="2"><b>Rumah Sakit Umum Daerah Kabupaten Sidoarjo<br />Jl. Mojopahit 667 Sidoarjo<br />Telepon (031) 8961649<br />Sidoarjo</b></td>
  </tr>
  <tr>
    <td colspan="2" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase;"><b>Laporan Rekapitulasi Penerimaan <?php echo $jdlRpt; ?><br />Periode <?php echo $periode; ?></b></td>
  </tr>
  <tr>
  	<td colspan="2">
		<table border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
			<tr style="text-align:center; font-weight:bold;background-color:#CCC;">
				<td width="30" style="border-left:1px solid;border-top:1px solid; border-bottom:1px solid; border-right:1px solid;" rowspan="2">No</td>
				<td width="230" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;" rowspan="2">Nama Unit</td>
				<td style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;" colspan="<?php echo $jml_kso; ?>">PENJAMIN</td>
				<td style="border-right:1px solid;border-top:1px solid; border-bottom:1px solid;">Jumlah</td>
			</tr>
            <tr style="text-align:center; font-weight:bold;background-color:#CCC;">
				<?php
				$i=0;
				$gTotalPx=0;$gtotIur=0;$gtotUmumIur=0;
				while ($kso_rw=mysql_fetch_array($rsKSO)){
					$idKSO[$i]=$kso_rw['id'];
					$namaKSO[$i]=$kso_rw['nama'];
					$gtot[$i]=0;
					$i++;
				?>
                <td style="border-bottom:1px solid; border-right:1px solid;">&nbsp;<?php echo $kso_rw['nama']; ?>&nbsp;</td>
                <?php
				}
				?>
                <td width="100" style="border-right:1px solid;border-bottom:1px solid;">Total</td>
			</tr>
			<?php
            /*$sql_kasir = "SELECT DISTINCT mu1.id,mu1.nama FROM (SELECT mu.id,mu.nama,mu.parent_id 
FROM (SELECT b.* FROM b_bayar b INNER JOIN b_kunjungan k ON b.kunjungan_id=k.id 
WHERE k.jenis_kunjungan=$fkunj AND b.tgl $period) b INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id 
INNER JOIN b_tindakan t ON bt.tindakan_id = t.id INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id 
INNER JOIN b_ms_unit mu ON p.unit_id = mu.id WHERE bt.tipe=0 AND bt.nilai>0
UNION
SELECT mu.id,mu.nama,mu.parent_id FROM (SELECT b.* FROM b_bayar b INNER JOIN b_kunjungan k ON b.kunjungan_id=k.id 
WHERE k.jenis_kunjungan=$fkunj AND b.tgl $period) b INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id 
INNER JOIN b_tindakan_kamar t ON bt.tindakan_id = t.id INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id 
INNER JOIN b_ms_unit mu ON p.unit_id = mu.id WHERE bt.tipe=1 AND bt.nilai>0) gab 
INNER JOIN b_ms_unit mu1 ON gab.parent_id=mu1.id ORDER BY mu1.id";*/
            $sql_kasir = "SELECT DISTINCT mu1.id,mu1.nama FROM (SELECT mu.id,mu.nama,mu.parent_id 
FROM (SELECT b.* FROM b_bayar b INNER JOIN b_kunjungan k ON b.kunjungan_id=k.id 
WHERE b.tgl $period) b INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id 
INNER JOIN b_tindakan t ON bt.tindakan_id = t.id INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id 
INNER JOIN b_ms_unit mu ON p.unit_id = mu.id WHERE bt.tipe=0 AND bt.nilai>0
UNION
SELECT mu.id,mu.nama,mu.parent_id FROM (SELECT b.* FROM b_bayar b INNER JOIN b_kunjungan k ON b.kunjungan_id=k.id 
WHERE b.tgl $period) b INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id 
INNER JOIN b_tindakan_kamar t ON bt.tindakan_id = t.id INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id 
INNER JOIN b_ms_unit mu ON p.unit_id = mu.id WHERE bt.tipe=1 AND bt.nilai>0) gab 
INNER JOIN b_ms_unit mu1 ON gab.parent_id=mu1.id ORDER BY mu1.id";
                        
            //echo $sql_kasir.";<br>";
            $kueri_kasir = mysql_query($sql_kasir);
            //$jml_kasir = mysql_num_rows($kueri_kasir);
			
			while ($kasir_rw=mysql_fetch_array($kueri_kasir)){
            ?>
			<tr style="background-color:#EEE;font-weight:bold;">
				<td height="25" colspan="2" style="border-bottom:1px solid;border-right:1px solid;border-left:1px solid;">&nbsp;&nbsp;<?php echo $kasir_rw["nama"]; ?></td>
				<?php
				for($i=0;$i<$jml_kso;$i++){
					$subTotuang[$i]=0;
					$subTotiur[$i]=0;
				?>
				<td width="80" align="center" style="border-bottom:1px solid;border-right:1px solid;"></td>
				<?php
				}
				?>
				<td style="border-bottom:1px solid;border-right:1px solid;"></td>
			</tr>
            <?php
			/*$sql = "SELECT DISTINCT * FROM (SELECT mu.id,mu.nama,mu.parent_id 
FROM (SELECT b.* FROM b_bayar b INNER JOIN b_kunjungan k ON b.kunjungan_id=k.id 
WHERE k.jenis_kunjungan=$fkunj AND b.tgl $period) b INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id 
INNER JOIN b_tindakan t ON bt.tindakan_id = t.id INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id 
INNER JOIN b_ms_unit mu ON p.unit_id = mu.id WHERE bt.tipe=0 AND bt.nilai>0
UNION
SELECT mu.id,mu.nama,mu.parent_id FROM (SELECT b.* FROM b_bayar b INNER JOIN b_kunjungan k ON b.kunjungan_id=k.id 
WHERE k.jenis_kunjungan=$fkunj AND b.tgl $period) b INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id 
INNER JOIN b_tindakan_kamar t ON bt.tindakan_id = t.id INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id 
INNER JOIN b_ms_unit mu ON p.unit_id = mu.id WHERE bt.tipe=1 AND bt.nilai>0) gab
WHERE gab.parent_id=".$kasir_rw["id"]." ORDER BY gab.id";*/
			$sql = "SELECT DISTINCT * FROM (SELECT mu.id,mu.nama,mu.parent_id 
FROM (SELECT b.* FROM b_bayar b INNER JOIN b_kunjungan k ON b.kunjungan_id=k.id 
WHERE b.tgl $period) b INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id 
INNER JOIN b_tindakan t ON bt.tindakan_id = t.id INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id 
INNER JOIN b_ms_unit mu ON p.unit_id = mu.id WHERE bt.tipe=0 AND bt.nilai>0
UNION
SELECT mu.id,mu.nama,mu.parent_id FROM (SELECT b.* FROM b_bayar b INNER JOIN b_kunjungan k ON b.kunjungan_id=k.id 
WHERE b.tgl $period) b INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id 
INNER JOIN b_tindakan_kamar t ON bt.tindakan_id = t.id INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id 
INNER JOIN b_ms_unit mu ON p.unit_id = mu.id WHERE bt.tipe=1 AND bt.nilai>0) gab
WHERE gab.parent_id=".$kasir_rw["id"]." ORDER BY gab.id";
			//echo $sql."<br>";
			$kueri = mysql_query($sql);
			$no = 1;
			
			$total = 0;$totalPx = 0;
			$totUmum=0;$totIur=0;$subTotUmumIur=0;
			$SubtotalPx=0;
			while($poli=mysql_fetch_array($kueri)){
			?>
            <tr>
            	<td style="text-align:center;border-left:1px solid;border-bottom:1px solid;border-right:1px solid"><?php echo $no; ?></td>
				<td style="border-right:1px solid;border-bottom:1px solid;" align="left">&nbsp;<?php echo $poli['nama']; ?></td>
                <?php
				//$kueri_kasir2 = mysql_query($sql_kasir);
				$stotal = 0;
				$stotUmum=0;
				$stotIur=0;
				for($i=0;$i<$jml_kso;$i++){
					//bayar tindakan
					/*$sql = "SELECT IFNULL(SUM(bt.nilai),0) AS nilai FROM (SELECT b.* FROM b_bayar b INNER JOIN b_kunjungan k ON b.kunjungan_id=k.id 
WHERE k.jenis_kunjungan=$fkunj AND b.tgl $period) b
					INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id
					INNER JOIN b_tindakan t ON bt.tindakan_id = t.id
					INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id
					INNER JOIN b_ms_unit mu ON p.unit_id = mu.id WHERE bt.tipe=0 AND bt.nilai>0 AND bt.kso_id='".$idKSO[$i]."' AND mu.id = '".$poli['id']."'";*/
					$sql = "SELECT IFNULL(SUM(bt.nilai),0) AS nilai FROM (SELECT b.* FROM b_bayar b INNER JOIN b_kunjungan k ON b.kunjungan_id=k.id 
WHERE b.tgl $period) b
					INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id
					INNER JOIN b_tindakan t ON bt.tindakan_id = t.id
					INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id
					INNER JOIN b_ms_unit mu ON p.unit_id = mu.id WHERE bt.tipe=0 AND bt.nilai>0 AND bt.kso_id='".$idKSO[$i]."' AND mu.id = '".$poli['id']."'";
					//echo $sql."<br>";
					$queri = mysql_query($sql);
					$dat = mysql_fetch_array($queri);
					$uang[$i]=$dat[0];
					if ($idKSO[$i]<>1){
						$iur[$i]=$dat[0];
					}else{
						$iur[$i]=0;
					}
					//bayar kamar
					/*$sql = "SELECT IFNULL(SUM(bt.nilai),0) AS nilai FROM (SELECT b.* FROM b_bayar b INNER JOIN b_kunjungan k ON b.kunjungan_id=k.id 
WHERE k.jenis_kunjungan=$fkunj AND b.tgl $period) b
					INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id
					INNER JOIN b_tindakan_kamar t ON bt.tindakan_id = t.id
					INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id
					INNER JOIN b_ms_unit mu ON p.unit_id = mu.id WHERE bt.tipe=1 AND bt.nilai>0 AND bt.kso_id='".$idKSO[$i]."' AND mu.id = '".$poli['id']."'";*/
					$sql = "SELECT IFNULL(SUM(bt.nilai),0) AS nilai FROM (SELECT b.* FROM b_bayar b INNER JOIN b_kunjungan k ON b.kunjungan_id=k.id 
WHERE b.tgl $period) b
					INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id
					INNER JOIN b_tindakan_kamar t ON bt.tindakan_id = t.id
					INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id
					INNER JOIN b_ms_unit mu ON p.unit_id = mu.id WHERE bt.tipe=1 AND bt.nilai>0 AND bt.kso_id='".$idKSO[$i]."' AND mu.id = '".$poli['id']."'";
					//echo $sql."<br>";
					$queri = mysql_query($sql);
					$dat = mysql_fetch_array($queri);
					$uang[$i]+=$dat[0];
					if ($idKSO[$i]<>1){
						$iur[$i]+=$dat[0];
					}
					$subTotuang[$i]+=$uang[$i];
					$stotal += $uang[$i];
					$stotUmum +=$uang[$i];
					$stotIur +=$iur[$i];
				?>
                <td style="border-right:1px solid;border-bottom:1px solid;" align="right"><?php echo number_format($uang[$i],0,',','.'); ?>&nbsp;</td>
                <?php
				}
				
				$subTotUmumIur += $stotal;
				$totUmum +=$stotUmum;
				$totIur +=$stotIur;
				?>
                <td style="border-right:1px solid;border-bottom:1px solid;" align="right"><?php echo number_format($stotal,0,',','.'); ?>&nbsp;</td>
			</tr>
            <?php
			$no++;
			}
			?>
            <tr style="font-weight:bold" height="25">
              <td style="text-align:center;border-left:1px solid;border-bottom:1px solid;border-right:1px solid">&nbsp;</td>
              <td style="border-right:1px solid;border-bottom:1px solid;" align="right">Sub Total&nbsp;</td>
              <?php 
			  for ($i=0;$i<count($idKSO);$i++){
			  	$gtot[$i] +=$subTotuang[$i];
			  ?>
              <td style="border-right:1px solid;border-bottom:1px solid;" align="right"><?php echo number_format($subTotuang[$i],0,',','.'); ?>&nbsp;</td>
              <?php 
			  }
			  $gTotalPx +=$SubtotalPx;
			  $gtotIur +=$totIur;
			  $gtotUmumIur +=$subTotUmumIur;
			  ?>
              <td style="border-right:1px solid;border-bottom:1px solid;" align="right"><?php echo number_format($subTotUmumIur,0,',','.'); ?>&nbsp;</td>
            </tr>
            <?php 
			}
			?>
            <tr style="font-weight:bold" height="25">
              <td style="text-align:center;border-left:1px solid;border-bottom:1px solid;border-right:1px solid">&nbsp;</td>
              <td style="border-right:1px solid;border-bottom:1px solid;" align="right">Grand Total&nbsp;</td>
              <?php 
			  for($i=0;$i<$jml_kso;$i++){
			  ?>
              <td style="border-right:1px solid;border-bottom:1px solid;" align="right"><?php echo number_format($gtot[$i],0,',','.'); ?>&nbsp;</td>
              <?php 
			  	//$subTot[$i]=$subTotuang[$i]+$subTotiur[$i];
			  }
			  ?>
              <td style="border-right:1px solid;border-bottom:1px solid;" align="right"><?php echo number_format($gtotUmumIur,0,',','.'); ?>&nbsp;</td>
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
            <select  name="select" id="cmbPrint2an" onchange="changeSize(this.value)">
              <option value="0">Printer non-Kretekan</option>
              <option value="1">Printer Kretekan</option>
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