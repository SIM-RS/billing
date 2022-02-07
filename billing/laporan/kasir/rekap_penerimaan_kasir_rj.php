<?php 
if($_POST['excel']=='excel'){
header("Content-type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="penerimaan_kasir_RJ.xls"');
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

$fKsr="";
if($_REQUEST['nmKsr']!=0){
	$fKsr = " AND user_act=".$_REQUEST['nmKsr'];
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

$periode = $tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2]." S/D ".$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
$period = "BETWEEN '$tglAwal2' AND '$tglAkhir2'";
//$period = "BETWEEN '2012-02-07' AND '2012-02-07'";

?>
<table id="tblPrint" width="800" border="0" cellspacing="0" cellpadding="0" align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td colspan="2"><b>Rumah Sakit Umum Daerah Kabupaten Sidoarjo<br />Jl. Mojopahit 667 Sidoarjo<br />Telepon (031) 8961649<br />Sidoarjo</b></td>
  </tr>
  <tr>
    <td colspan="2" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase;"><b>REKAPITULASI<br>Laporan Penerimaan Kasir Rawat Jalan<br />Periode <?php echo $periode; ?></b></td>
  </tr>
  <tr>
    <td height="30" width="50%">&nbsp;Kasir : <span style="text-transform:uppercase; font-weight:bold; padding-left:10px;"><?php if($nmKasir==0) echo 'semua'; else echo $rwKasir['nama'];?></span></td>
	<td align="right"><!--Yang Mencetak :&nbsp;<b><?php echo $rwPeg['nama'];?></b>--></td>	
  </tr>
  <tr>
  	<td colspan="2">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
            <tr style="text-align:center; font-weight:bold;">
            	<td width="5%" style="border-left:1px solid;border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">No</td>
				<!--td width="10%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">No. Kwitansi</td-->
                <td width="20%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">Unit Pelayanan</td>
                <td width="10%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">Konsul</td>
                <td width="10%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">Tindakan</td>             
                <td width="10%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">Iur Bayar</td>
                <td width="10%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">KK4</td>
                <td width="10%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">Resume Medis</td>
                <td width="10%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">Total</td>
			</tr>
            <?php 
			$qkasir="SELECT DISTINCT mp.id,mp.nama FROM (SELECT * FROM b_bayar WHERE kasir_id=$idKasirRJ $fKsr AND tgl $period) b
INNER JOIN b_ms_pegawai mp ON b.user_act=mp.id";
			//echo $qkasir."<br>";
			$rsKasir=mysql_query($qkasir);
			$total_konsul=0;
			$total_tindakan=0;
			$total_iur=0;
			$total_kk4=0;
			$total_rm=0;
			$total=0;
			while ($rwKasir=mysql_fetch_array($rsKasir)){
			?>
            <tr>
              <td colspan="8" style="text-decoration:underline">&nbsp;<b><?php echo $rwKasir['nama']; ?></b></td>
            </tr>
            <?php
				$sql="SELECT DISTINCT mu.id,mu.nama 
FROM (SELECT * FROM b_bayar WHERE user_act='".$rwKasir['id']."' AND tgl $period) b 
INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id INNER JOIN b_tindakan t ON bt.tindakan_id = t.id 
INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id INNER JOIN b_ms_unit mu ON p.unit_id=mu.id ORDER BY mu.id";
				//echo $sql."<br>";
				$kueri=mysql_query($sql);
				$t_konsul=0;
				$t_tindakan=0;
				$t_iur=0;
				$t_kk4=0;
				$t_rm=0;
				$tt=0;
				$no=0;
				while($poli=mysql_fetch_array($kueri)){
					$no++;
					/*$sql2="SELECT SUM(IF(t.kso_id<>1,bt.nilai,0)) iur,
SUM(IF(t.kso_id<>1,0,IF((mt.klasifikasi_id=11 AND mt.id<>2363),bt.nilai,0))) ret,
SUM(IF(t.kso_id<>1,0,IF((mt.id=2363),bt.nilai,0))) konsul,SUM(IF(t.kso_id<>1,0,IF((mt.id=10),bt.nilai,0))) resum,
SUM(IF(t.kso_id<>1,0,IF((mt.id=12),bt.nilai,0))) kk4,SUM(IF(t.kso_id<>1,0,IF((mt.id<>2363 AND mt.id<>10 AND mt.id<>12),bt.nilai,0))) tind 
FROM (SELECT * FROM b_bayar WHERE user_act='".$rwKasir['id']."' AND tgl $period) b 
INNER JOIN b_bayar_tindakan bt ON b.id=bt.bayar_id INNER JOIN b_tindakan_ak t ON bt.tindakan_id=t.b_tindakan_id 
INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id 
INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id 
WHERE p.unit_id='".$poli['id']."' AND bt.tipe=0 AND t.tipe_pendapatan=0 AND (t.bayar_pasien>0 OR (t.bayar_pasien=0 AND p.jenis_kunjungan<>3 AND t.tgl<=b.tgl)) GROUP BY p.unit_id ORDER BY p.unit_id";*/
					$sql2="SELECT SUM(IF(bt.kso_id<>1,bt.nilai,0)) iur,
SUM(IF(bt.kso_id<>1,0,IF((mt.klasifikasi_id=11 AND mt.id<>2363),bt.nilai,0))) ret,
SUM(IF(bt.kso_id<>1,0,IF((mt.id=2363),bt.nilai,0))) konsul,SUM(IF(bt.kso_id<>1,0,IF((mt.id=10),bt.nilai,0))) resum,
SUM(IF(bt.kso_id<>1,0,IF((mt.id=12),bt.nilai,0))) kk4,SUM(IF(bt.kso_id<>1,0,IF((mt.id<>2363 AND mt.id<>10 AND mt.id<>12),bt.nilai,0))) tind 
FROM (SELECT * FROM b_bayar WHERE user_act='".$rwKasir['id']."' AND tgl $period) b 
INNER JOIN b_bayar_tindakan bt ON b.id=bt.bayar_id INNER JOIN b_tindakan t ON bt.tindakan_id=t.id 
INNER JOIN b_ms_tindakan_kelas mtk ON t.ms_tindakan_kelas_id=mtk.id INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id=mt.id 
INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id 
WHERE p.unit_id='".$poli['id']."' AND bt.tipe=0 AND bt.nilai>0 GROUP BY p.unit_id ORDER BY p.unit_id";
					//echo $sql2."<br>";
					$kueri2=mysql_query($sql2);
					$data2=mysql_fetch_array($kueri2);
					$konsul=$data2['konsul'];
					$tind=$data2['tind'];
					$iur=$data2['iur'];
					$kk4=$data2['kk4'];
					$rm=$data2['resum'];
					$t=$konsul+$tind+$iur+$kk4+$rm;
			?>
            <tr style="text-align:center;">
            	<td width="5%" style="" align="center"><?php echo $no; ?></td>
				<!--td width="10%" style="" align="center"><?php echo $data2['nobukti']; ?></td-->
                <td width="10%" style="" align="left">&nbsp;<?php echo $poli['nama']; ?></td>
                <td width="10%" style="" align="right"><?php echo number_format($konsul,0,',','.');?>&nbsp;</td>
                <td width="10%" style="" align="right"><?php echo number_format($tind,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="" align="right"><?php echo number_format($iur,'0',',','.'); ?>&nbsp;</td>
                <td width="10%" style="" align="right"><?php echo number_format($kk4,0,',','.'); ?>&nbsp;</td>
                <td width="10%" style="" align="right"><?php echo number_format($rm,0,',','.'); ?>&nbsp;</td>
                <td width="10%" style="" align="right"><?php echo number_format($t,0,',','.'); ?>&nbsp;</td>
			</tr>
            <?php
					$t_konsul+=$konsul;
					$t_tindakan+=$tind;
					$t_iur+=$iur;
					$t_kk4+=$kk4;
					$t_rm+=$rm;
					$tt+=$t;
				}
			?>
            <tr>
            	<td colspan="9">&nbsp;</td>
            </tr>
            <tr style="text-align:center; font-weight:bold;">
            	<td width="5%" style="">&nbsp;</td>
				<!--td width="10%" style="">&nbsp;</td-->
                <td width="10%" style="" align="right">Sub Total :&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($t_konsul,0,',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($t_tindakan,0,',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($t_iur,0,',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($t_kk4,0,',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($t_rm,0,',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($tt,0,',','.'); ?>&nbsp;</td>
			</tr>
            <?php
				$total_konsul+=$t_konsul;
				$total_tindakan+=$t_tindakan;
				$total_iur+=$t_iur;
				$total_kk4+=$t_kk4;
				$total_rm+=$t_rm;
				$total+=$tt;
			}
			?>
            <tr>
            	<td colspan="9">&nbsp;</td>
            </tr>
            <tr style="text-align:center; font-weight:bold;">
            	<td width="5%" style="">&nbsp;</td>
				<!--td width="10%" style="">&nbsp;</td-->
                <td width="10%" style="" align="right">Total :&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($total_konsul,0,',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($total_tindakan,0,',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($total_iur,0,',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($total_kk4,0,',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($total_rm,0,',','.'); ?>&nbsp;</td>
                <td width="10%" style="border-top:1px solid;" align="right"><?php echo number_format($total,0,',','.'); ?>&nbsp;</td>
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
