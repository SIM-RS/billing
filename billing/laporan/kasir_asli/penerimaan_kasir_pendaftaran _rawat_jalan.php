<?php 
session_start();
include("../../sesi.php");
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

$periode = $tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2]." S/D ".$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
$period = "BETWEEN '$tglAwal2' AND '$tglAkhir2'";
$period = "BETWEEN '2012-02-01' AND '2012-02-01'";
?>
<table id="tblPrint" width="800" border="0" cellspacing="0" cellpadding="0" align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td colspan="2"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td colspan="2" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase;"><b>Rekapitulasi<br />Laporan Penerimaan Kasir Pendaftaran Rawat Jalan<br />Periode <?php echo $periode; ?></b></td>
  </tr>
  <tr>
    <td height="30" width="50%">&nbsp;Nama operator kasir pendaftaran : <span style="text-transform:uppercase; font-weight:bold; padding-left:10px;"><?php if($nmKasir==0) echo 'semua'; else echo $rwKasir['nama'];?></span></td>
	<td align="right">&nbsp;</td>	
  </tr>
  <tr>
  	<td colspan="2">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
            <tr style="text-align:center; font-weight:bold;">
            	<td width="5%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">No.</td>
				<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">Nama Poli</td>
				<td width="8%" style="border-top:1px solid; border-bottom:1px solid; border-left:1px solid; border-right:1px solid;">Jumlah Pasien</td>
				<td width="10%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">Nilai Uang (Rp)</td>
                <td width="10%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;">Total Penerimaan (Rp)</td>
			</tr>
             <?php
			$sql = "SELECT DISTINCT
			  mu.id,
			  mu.nama
			FROM (SELECT *
				  FROM b_bayar
				  WHERE kasir_id = '81'
					  AND tgl $period) b
			  INNER JOIN b_bayar_tindakan bt
				ON b.id = bt.bayar_id
			  INNER JOIN b_tindakan t
				ON bt.tindakan_id = t.id
			  INNER JOIN b_pelayanan p
				ON t.pelayanan_id = p.id
			  INNER JOIN b_ms_unit mu
				ON p.unit_id = mu.id
			ORDER BY mu.nama";
			$kueri = mysql_query($sql);
			$no = 1;
			$total_jumlah = 0;
			$total_nilai = 0;
			while($poli=mysql_fetch_array($kueri)){
				$sql2 = "SELECT IFNULL(COUNT(b.id),0) AS jum 
FROM (SELECT * FROM b_bayar WHERE kasir_id='81' AND user_act='".$nmKasir."' AND tgl $period) b 
INNER JOIN b_bayar_tindakan bt ON b.id=bt.bayar_id
INNER JOIN b_tindakan t ON bt.tindakan_id=t.id INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id
INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE mu.id='".$poli['id']."'";
//$sss="(SELECT DISTINCT pasien_id,id,unit_id FROM b_pelayanan)";
				$kueri2=mysql_query($sql2);
				$j_pasien=mysql_fetch_array($kueri2);
				$total_jumlah=$total_jumlah+$j_pasien['jum'];
				
				$sql3 = "SELECT IFNULL(SUM(bt.nilai),0) AS nilai 
FROM (SELECT * FROM b_bayar WHERE kasir_id='81' AND user_act='".$nmKasir."' AND tgl $period) b 
INNER JOIN b_bayar_tindakan bt ON b.id=bt.bayar_id
INNER JOIN b_tindakan t ON bt.tindakan_id=t.id INNER JOIN b_pelayanan p ON t.pelayanan_id=p.id
INNER JOIN b_ms_unit mu ON p.unit_id=mu.id WHERE mu.id='".$poli['id']."'";
				$kueri3 = mysql_query($sql3);
				$nilai=mysql_fetch_array($kueri3);
				$total_nilai=$total_nilai+$nilai['nilai'];
			?>
            <tr style="text-align:center; font-weight:bold;">
            	<td width="5%" style="border-bottom:1px solid;" align="center"><?php echo $no; ?></td>
				<td width="10%" style="border-bottom:1px solid;" align="left">&nbsp;<?php echo $poli['nama']; ?></td>
				<td width="8%" style="border-bottom:1px solid;" align="right"><?php echo $j_pasien['jum']; ?>&nbsp;</td>
                <td width="10%" style="border-bottom:1px solid;">&nbsp;</td>
                <td width="10%" style="border-bottom:1px solid;" align="right"><?php echo number_format($nilai['nilai'],0,',','.'); ?>&nbsp;</td>
			</tr>
            <?php
			$no++;
			}
			?>
            <tr style="text-align:center; font-weight:bold;">
            	<td width="5%" style="border-bottom:1px solid;" align="center">&nbsp;</td>
				<td width="10%" style="border-bottom:1px solid;" align="right">TOTAL :&nbsp;</td>
				<td width="8%" style="border-bottom:1px solid;" align="right"><?php echo $total_jumlah; ?>&nbsp;</td>
                <td width="10%" style="border-bottom:1px solid;">&nbsp;</td>
                <td width="10%" style="border-bottom:1px solid;" align="right"><?php echo number_format($total_nilai,0,',','.'); ?>&nbsp;</td>
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
