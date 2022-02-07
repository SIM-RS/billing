<?php 
session_start();
include("../../sesi.php");
if($_POST['excel']=='excel'){
header("Content-type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="penerimaan_kasir_pendaftaran.xls"');
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

$sql="SELECT * FROM b_ms_unit WHERE id=$idKasirPendaftaranRJ";
$rsK=mysql_query($sql);
$rwK=mysql_fetch_array($rsK);
$nkasir=$rwK['nama'];
?>
<table id="tblPrint" width="800" border="0" cellspacing="0" cellpadding="0" align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td colspan="2"><b><?=$namaRS?><br /><?=$alamatRS?><br />Telepon <?=$tlpRS?><br /><?=$kotaRS?></b></td>
  </tr>
  <tr>
    <td colspan="2" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase;"><b>Rekapitulasi<br />
    Laporan Penerimaan <?php echo $nkasir; ?><br />
      Periode <?php echo $periode; ?></b></td>
  </tr>
  <tr>
    <td height="30" width="50%"></td>
	<td align="right"></td>
  </tr>
  <tr>
  	<td colspan="2">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
			<tr style="text-align:center; font-weight:bold;">
				<td width="5%" style="border-left:1px solid; border-top:1px solid; border-bottom:1px solid; border-right:1px solid;" rowspan="2">No</td>
				<td width="20%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;" rowspan="2">Nama Poli</td>
                <?php
				$sql_kasir = "SELECT DISTINCT
				  mp.id,
				  mp.nama
				FROM b_bayar b
				  INNER JOIN b_ms_pegawai mp
					ON b.user_act = mp.id
				WHERE b.kasir_id = '$idKasirPendaftaranRJ'
					AND b.tgl $period
				ORDER BY mp.nama";
				$kueri_kasir = mysql_query($sql_kasir);
				$jml_kasir = mysql_num_rows($kueri_kasir);
				//if ($jml_kasir==0) $jml_kasir=1;
				?>
				<td width="8%" style="border-top:1px solid; border-bottom:1px solid; border-right:1px solid;" colspan="<?php echo $jml_kasir ?>">Nama Kasir</td>
				<td width="10%" style="border-top:1px solid; border-bottom:1px solid;border-right:1px solid;" colspan="2">Jumlah</td>
			</tr>
            <tr style="text-align:center; font-weight:bold;">
				<?php
				if ($jml_kasir==0){
				?>
				<td width="10%" style="border-bottom:1px solid; border-right:1px solid;">&nbsp;</td>
				<?php
				}else{
					$arKasir=array();
					$arIdKasir=array();
					$i=0;
					while($kasir=mysql_fetch_array($kueri_kasir)){
						$arIdKasir[$i]=$kasir['id'];
						$arKasir[$i]=0;
						$i++;
				?>
                <td width="10%" style="border-bottom:1px solid; border-right:1px solid;"><?php if($kasir['nama']==''){echo $kasir['id'];} else{echo $kasir['nama'];} ?></td>
                <?php
					}
				}
				?>
                <td width="8%" style="border-bottom:1px solid; border-right:1px solid;">Pasien</td>
                <td width="10%" style="border-bottom:1px solid;border-right:1px solid;">UANG</td>
			</tr>
            <?php
			/*$sql = "SELECT DISTINCT
			  mu.id,
			  mu.nama
			FROM (SELECT *
				  FROM b_bayar
				  WHERE kasir_id = '$idKasirPendaftaranRJ'
					  AND tgl $period) b
			  INNER JOIN b_bayar_tindakan bt
				ON b.id = bt.bayar_id
			  INNER JOIN b_tindakan t
				ON bt.tindakan_id = t.id
			  INNER JOIN b_pelayanan p
				ON t.pelayanan_id = p.id
			  INNER JOIN b_ms_unit mu
				ON p.unit_id = mu.id
			ORDER BY mu.nama";*/
			$sql="SELECT * FROM (SELECT id,nama FROM b_ms_unit WHERE parent_id=1 AND aktif=1 ORDER BY nama) t
UNION
SELECT * FROM (SELECT DISTINCT  mu.id,mu.nama
FROM (SELECT * FROM b_bayar WHERE kasir_id = '$idKasirPendaftaranRJ' AND tgl $period) b
INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id INNER JOIN b_tindakan t ON bt.tindakan_id = t.id
INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id INNER JOIN b_ms_unit mu ON p.unit_id = mu.id
WHERE mu.parent_id<>'1' AND bt.tipe=0
ORDER BY mu.nama) t2";
			$kueri = mysql_query($sql);
			$no = 1;
			$totJmlPx=0;
			$gTotal=0;
			while($poli=mysql_fetch_array($kueri)){
			?>
            <tr style="text-align:center;">
            	<td width="5%" style="border-left:1px solid; border-bottom:1px solid;border-right:1px solid; "><?php echo $no; ?></td>
				<td width="10%" style="border-right:1px solid; border-bottom:1px solid;" align="left">&nbsp;<?php echo $poli['nama']; ?></td>
                <?php
				if ($jml_kasir==0){
					$gTotal = 0;
				?>
                	<td width="10%" style="border-right:1px solid; border-bottom:1px solid;" align="right">0&nbsp;</td>
				<?php
				}else{
					//$kueri_kasir2 = mysql_query($sql_kasir);
					$total = 0;
					//while($kas=mysql_fetch_array($kueri_kasir2)){
					for ($i=0;$i<$jml_kasir;$i++){
						$sql = "SELECT
				  IFNULL(SUM(bt.nilai),0) AS nilai
				FROM (SELECT *
					  FROM b_bayar
					  WHERE kasir_id = '$idKasirPendaftaranRJ'
						  AND user_act = '".$arIdKasir[$i]."'
						  AND tgl $period) b
				  INNER JOIN b_bayar_tindakan bt
					ON b.id = bt.bayar_id
				  INNER JOIN b_tindakan t
					ON bt.tindakan_id = t.id
				  INNER JOIN b_pelayanan p
					ON t.pelayanan_id = p.id
				  INNER JOIN b_ms_unit mu
					ON p.unit_id = mu.id
				WHERE mu.id = '".$poli['id']."' AND bt.tipe=0";
						//echo $sql."<br>";
						$queri = mysql_query($sql);
						$dat = mysql_fetch_array($queri);
						$arKasir[$i]+=$dat[0];
						$total = $total + $dat[0];
				?>
                <td width="10%" style="border-right:1px solid; border-bottom:1px solid;" align="right"><?php echo number_format($dat[0],0,',','.'); ?>&nbsp;</td>
                <?php
					}
					$gTotal += $total;
				}
				
				/*$sql2 = "SELECT
				  IFNULL(COUNT(b.id),0) AS jumlah
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
				WHERE mu.id = '".$poli['id']."' AND bt.tipe=0";*/
				$sql2="SELECT COUNT(gab.kunjungan_id) AS jumlah FROM (SELECT DISTINCT b.kunjungan_id 
FROM (SELECT * FROM b_bayar WHERE kasir_id = '$idKasirPendaftaranRJ' AND tgl $period) b 
INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id INNER JOIN b_tindakan t ON bt.tindakan_id = t.id 
INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id INNER JOIN b_ms_unit mu ON p.unit_id = mu.id 
WHERE mu.id = '".$poli['id']."' AND bt.tipe=0) AS gab";
				//echo $sql2."<br>";
				$queri2=mysql_query($sql2);
				$data2=mysql_fetch_array($queri2);
				$totJmlPx+=$data2['jumlah'];
				?>
                <td width="8%" style="border-right:1px solid; border-bottom:1px solid;" align="center"><?php echo $data2['jumlah']; ?>&nbsp;</td>
              <td width="10%" style="border-right:1px solid; border-bottom:1px solid;" align="right"><?php echo number_format($total,0,',','.'); ?>&nbsp;</td>
			</tr>
            <?php
			$no++;
			}
			?>
            <tr style="text-align:center; font-weight:bold;">
              <td style="border-left:1px solid; border-bottom:1px solid;border-right:1px solid; ">&nbsp;</td>
              <td style="border-right:1px solid; border-bottom:1px solid;" align="right">Jumlah&nbsp;</td>
              <?php 
			  if ($jml_kasir==0){
			  	$totJmlPx=0;
			  ?>
              <td style="border-right:1px solid; border-bottom:1px solid;" align="right">0&nbsp;</td>
              <?php 
			  }else{
			  	for ($i=0;$i<$jml_kasir;$i++){
			  ?>
			  <td style="border-right:1px solid; border-bottom:1px solid;" align="right"><?php echo number_format($arKasir[$i],0,',','.'); ?>&nbsp;</td>
			  <?php
			  	}
			  }
			  ?>
              <td style="border-right:1px solid; border-bottom:1px solid;" align="center"><?php echo $totJmlPx; ?></td>
              <td style="border-right:1px solid; border-bottom:1px solid;" align="right"><?php echo number_format($gTotal,0,',','.'); ?>&nbsp;</td>
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
