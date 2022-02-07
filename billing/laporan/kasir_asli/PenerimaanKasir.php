<?php
session_start();
if($_POST['excel']=='excel'){
header("Content-type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="penerimaan_pasien.xls"');
}
include "../../sesi.php";
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
?>
<table id="tblPrint" width="800" border="0" cellspacing="0" cellpadding="0" align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td colspan="2"><b><?=$namaRS;?><br /><?=$alamatRS;?><br />Telepon <?=$_SESSION['tlpP'];?><br /><?=$kotaRS;?></b></td>
  </tr>
  <tr>
    <td colspan="2" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase;"><b>Laporan Penerimaan <?php echo $rwKsr['nama'];?><br />Periode <?php echo $tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2]?></b></td>
  </tr>
  <tr>
    <td height="30" width="50%">&nbsp;Kasir : <span style="text-transform:uppercase; font-weight:bold; padding-left:10px;"><?php if($nmKasir==0) echo 'semua'; else echo $rwKasir['nama'];?></span></td>
	<td align="right">Yang Mencetak :&nbsp;<b><?php echo $rwPeg['nama'];?></b></td>
  </tr>
  <tr>
  	<td colspan="2">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
			<tr style="text-align:center; font-weight:bold;">
				<td width="5%" style="border-top:1px solid; border-bottom:1px solid;">No</td>
				<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">Tgl Bayar</td>
				<td width="8%" style="border-top:1px solid; border-bottom:1px solid;">Jam</td>
				<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">No.<br />Kwitansi</td>
				<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">No.RM</td>
				<td width="30%" style="border-top:1px solid; border-bottom:1px solid;">Nama Pasien</td>
				<td width="15%" style="border-top:1px solid; border-bottom:1px solid;">Status</td>
				<td width="12%" style="border-top:1px solid; border-bottom:1px solid;">Tindakan + Retribusi/Kamar</td>
				<td width="12%" style="border-top:1px solid; border-bottom:1px solid;">Obat</td>
				<td width="12%" style="border-top:1px solid; border-bottom:1px solid;">Total</td>
			</tr>
			<?php
					if($nmKasir!=0){
						$fKasir = "b_bayar.user_act = '".$nmKasir."'";
					}else{
						$fKasir = "b_ms_pegawai_unit.unit_id = '".$kasir."'";
					}
					
					
					
					$sqlNm = "SELECT 
					b_ms_pegawai.id, 
					b_ms_pegawai.nama 
					FROM b_bayar 
					INNER JOIN b_ms_pegawai ON b_ms_pegawai.id = b_bayar.user_act 
					INNER JOIN b_ms_pegawai_unit ON b_ms_pegawai_unit.ms_pegawai_id = b_ms_pegawai.id 
					WHERE 
					$fKasir 
					AND b_bayar.kasir_id = '".$kasir."'
					AND b_bayar.tgl	BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."' 
					GROUP BY b_ms_pegawai.id 
					ORDER BY b_ms_pegawai.nama";
					$rsNm = mysql_query($sqlNm);
					while($rwNm = mysql_fetch_array($rsNm))
					{
			?>
			<tr>
				<td colspan="10" style="padding-left:20px; text-transform:uppercase; text-decoration:underline; font-weight:bold;" height="25"><?php echo $rwNm['nama'];?></td>
			</tr>
			<?php
					$sqlRuang = "SELECT t.id, t.nama, t.inap FROM (SELECT b_ms_unit.id, b_ms_unit.nama, b_ms_unit.inap FROM b_pelayanan INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id  INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id = b_tindakan.id INNER JOIN b_bayar ON b_bayar.id = b_bayar_tindakan.bayar_id WHERE b_bayar.user_act = '".$rwNm['id']."' AND b_bayar.kasir_id = '".$kasir."' AND b_bayar_tindakan.tipe=0 AND b_bayar_tindakan.nilai<>0 AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."'
					UNION
					SELECT b_ms_unit.id, b_ms_unit.nama, b_ms_unit.inap FROM b_pelayanan INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id = b_tindakan_kamar.id INNER JOIN b_bayar ON b_bayar.id = b_bayar_tindakan.bayar_id WHERE b_bayar.user_act = '".$rwNm['id']."' AND b_bayar.kasir_id = '".$kasir."' AND b_bayar_tindakan.tipe=1 AND b_bayar_tindakan.nilai<>0 AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."') AS t GROUP BY t.id";
					$rsRuang = mysql_query($sqlRuang);
					
					$totalTind = 0;
					$totalObat = 0;
					$total = 0;
					while($rwRuang = mysql_fetch_array($rsRuang))
					{
			?>
			<tr>
				<td>&nbsp;</td>
				<td colspan="9" style="text-transform:uppercase; font-weight:bold;"><?php echo $rwRuang['nama']?></td>
			</tr>
			<?php
					$sqlPas = "SELECT t.pelayanan_id, t.kso, t.kwi, t.no_rm, t.pasien, t.jam, t.tgl FROM (SELECT b_pelayanan.id AS pelayanan_id, b_ms_kso.nama AS kso, b_bayar.nobukti AS kwi, b_ms_pasien.no_rm, b_ms_pasien.nama AS pasien, TIME_FORMAT(b_bayar.tgl_act,'%H:%i') AS jam, DATE_FORMAT(b_bayar.tgl,'%d-%m-%Y') AS tgl FROM b_pelayanan INNER JOIN b_ms_pasien ON b_pelayanan.pasien_id = b_ms_pasien.id INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_kso ON b_ms_kso.id = b_tindakan.kso_id  INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id = b_tindakan.id INNER JOIN b_bayar ON b_bayar.id = b_bayar_tindakan.bayar_id WHERE b_bayar.user_act = '".$rwNm['id']."' AND b_bayar.kasir_id = '".$kasir."' AND b_bayar_tindakan.tipe=0 AND b_bayar_tindakan.nilai<>0 AND b_bayar.tgl BETWEEN  '".$tglAwal2."' AND '".$tglAkhir2."' AND b_pelayanan.unit_id = '".$rwRuang['id']."' UNION
				SELECT b_pelayanan.id AS pelayanan_id, b_ms_kso.nama AS kso, b_bayar.nobukti AS kwi, b_ms_pasien.no_rm, b_ms_pasien.nama AS pasien, TIME_FORMAT(b_bayar.tgl_act,'%H:%i') AS jam, DATE_FORMAT(b_bayar.tgl,'%d-%m-%Y') AS tgl FROM b_pelayanan INNER JOIN b_ms_pasien ON b_pelayanan.pasien_id = b_ms_pasien.id INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id INNER JOIN b_ms_kso ON b_ms_kso.id = b_tindakan.kso_id INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id = b_tindakan_kamar.id INNER JOIN b_bayar ON b_bayar.id = b_bayar_tindakan.bayar_id WHERE b_bayar.user_act = '".$rwNm['id']."' AND b_bayar.kasir_id = '".$kasir."' AND b_bayar_tindakan.tipe=1 AND b_bayar_tindakan.nilai<>0 AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."' AND b_pelayanan.unit_id = '".$rwRuang['id']."') AS t GROUP BY t.pelayanan_id";
					//echo $sqlPas."<br>";
					//if ($rwRuang['id']==39) echo $sqlPas."<br>";
					$rsPas = mysql_query($sqlPas);
					$no = 1;
					$subTind = 0;
					$subObat = 0;
					$subTot = 0;
					while($rwPas = mysql_fetch_array($rsPas))
					{
						$qTind = "SELECT SUM(b_bayar_tindakan.nilai) AS jml FROM b_pelayanan INNER JOIN b_tindakan ON b_tindakan.pelayanan_id = b_pelayanan.id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id = b_tindakan.id INNER JOIN b_bayar ON b_bayar.id = b_bayar_tindakan.bayar_id WHERE b_pelayanan.id='".$rwPas['pelayanan_id']."' AND b_bayar.user_act = '".$rwNm['id']."' AND b_bayar.kasir_id = '".$kasir."' AND b_bayar_tindakan.tipe=0 AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."'";
						//echo $qTind."<br>";
						//if ($rwRuang['id']==39) echo $qTind."<br>";
						$sTind = mysql_query($qTind);
						$wTind = mysql_fetch_array($sTind);
						
						$qInap = "SELECT SUM(b_bayar_tindakan.nilai) AS nilai FROM b_pelayanan INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id = b_pelayanan.id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id = b_tindakan_kamar.id INNER JOIN b_bayar ON b_bayar.id = b_bayar_tindakan.bayar_id WHERE b_pelayanan.id = '".$rwPas['pelayanan_id']."' AND b_bayar_tindakan.tipe = 1 AND b_bayar.user_act = '".$rwNm['id']."' AND b_bayar.kasir_id = '".$kasir."' AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."'";
						//echo $qInap."<br>";
						//if ($rwRuang['id']==39) echo $qInap."<br>";
						$sInap = mysql_query($qInap);
						$wInap = mysql_fetch_array($sInap);
						if($rwRuang['inap']==1){
							$jml = $wTind['jml'] + $wInap['nilai'];
						}else{
							$jml = $wTind['jml'];
						}
						
						$qObat = "SELECT SUM(b_bayar_tindakan.nilai) AS nilai FROM b_pelayanan INNER JOIN $dbapotek.a_penjualan ap ON ap.NO_KUNJUNGAN = b_pelayanan.id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id = ap.ID INNER JOIN b_bayar ON b_bayar.id = b_bayar_tindakan.bayar_id WHERE b_pelayanan.id = '".$rwPas['pelayanan_id']."' AND b_bayar_tindakan.tipe = 2 AND b_bayar.user_act = '".$rwNm['id']."' AND b_bayar.kasir_id = '".$kasir."' AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."'";
						//echo $qInap."<br>";
						//if ($rwRuang['id']==39) echo $qInap."<br>";
						$sObat = mysql_query($qObat);
						$wObat = mysql_fetch_array($sObat);
						$jmlObat = $wObat['nilai'];
						$jmlTot = $jml+$jmlObat;
			?>
			<tr>
				<td style="text-align:right; padding-right:5px;"><?php echo $no;?></td>
				<td style="text-align:center"><?php echo $rwPas['tgl'];?></td>
				<td style="text-align:center"><?php echo $rwPas['jam'];?></td>
				<td style="text-align:center"><?php echo $rwPas['kwi'];?></td>
				<td style="text-align:center"><?php echo $rwPas['no_rm'];?></td>
				<td style="text-transform:uppercase;">&nbsp;<?php echo $rwPas['pasien'];?></td>
				<td style="text-align:center"><?php echo $rwPas['kso'];?></td>
				<td style="text-align:right; padding-right:20px;"><?php echo number_format($jml,0,",",".");?></td>
				<td style="text-align:right; padding-right:20px;"><?php echo number_format($jmlObat,0,",",".");?></td>
				<td style="text-align:right; padding-right:20px;"><?php echo number_format($jmlTot,0,",",".");?></td>
			</tr>
			<?php
						$no++;
						$subTind += $jml;
						$subObat += $jmlObat;
						$subTot += $jml+$jmlObat;
					}
			?>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td style="text-align:right">SubTotal&nbsp;</td>
				<td style="text-align:right; padding-right:20px; border-top:1px solid;"><?php echo number_format($subTind,0,",",".");?></td>
				<td style="text-align:right; padding-right:20px; border-top:1px solid;"><?php echo number_format($subObat,0,",",".");?></td>
				<td style="text-align:right; padding-right:20px; border-top:1px solid;"><?php echo number_format($subTot,0,",",".");?></td>
			</tr>
			<?php
						$totalTind += $subTind;
						$totalObat += $subObat;
						$total += $subTot;
					}
			?>
			<tr>
				<td height="25" colspan="7" style="text-align:right; font-weight:bold; border-top:1px solid; ">TOTAL&nbsp;</td>
				<td style="text-align:right; padding-right:20px; border-top:1px solid; font-weight:bold;"><?php echo number_format($totalTind,0,",",".");?></td>
				<td style="text-align:right; padding-right:20px; border-top:1px solid; font-weight:bold;"><?php echo number_format($totalObat,0,",",".");?></td>
				<td style="text-align:right; padding-right:20px; border-top:1px solid; font-weight:bold;"><?php echo number_format($total,0,",",".");?></td>
			</tr>
			<?php 
					$ttotalTind += $totalTind;
					$ttotalObat += $totalObat;
					$ttotal += $total;
				}
			?>
			<tr>
			  <td height="25" colspan="7" style="text-align:right; font-weight:bold; border-top:1px solid; border-bottom:1px solid;">GRAND TOTAL&nbsp;</td>
			  <td style="text-align:right; font-size:12px; padding-right:20px; border-top:1px solid; border-bottom:1px solid; font-weight:bold;"><?php echo number_format($ttotalTind,0,",",".");?></td>
			  <td style="text-align:right; font-size:12px; padding-right:20px; border-top:1px solid; border-bottom:1px solid; font-weight:bold;"><?php echo number_format($ttotalObat,0,",",".");?></td>
			  <td style="text-align:right; font-size:12px; padding-right:20px; border-top:1px solid; border-bottom:1px solid; font-weight:bold;"><?php echo number_format($ttotal,0,",",".");?></td>
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
