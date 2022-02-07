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
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	
	$txtJam1=$_REQUEST['txtJam1'];
	$txtJam2=$_REQUEST['txtJam2'];
	
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
			<tr style="text-align:center; font-weight:bold;">
				<td width="5%" style="border-top:1px solid; border-bottom:1px solid;">No</td>
				<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">Tgl Bayar</td>
				<td width="8%" style="border-top:1px solid; border-bottom:1px solid;">Jam</td>
				<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">No.<br />Kwitansi</td>
				<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">No.RM</td>
				<td width="24%" style="border-top:1px solid; border-bottom:1px solid;" align="left">Nama Pasien</td>
				<td width="21%" style="border-top:1px solid; border-bottom:1px solid;">Status</td>
				<td width="12%" style="border-top:1px solid; border-bottom:1px solid; padding-right:20px;" align="right">Nilai</td>
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
					INNER JOIN b_ms_unit ON b_ms_unit.id = b_bayar.unit_id 
					INNER JOIN b_ms_pegawai ON b_ms_pegawai.id = b_bayar.user_act 
					INNER JOIN b_ms_pegawai_unit ON b_ms_pegawai_unit.ms_pegawai_id = b_ms_pegawai.id 
					WHERE $fKasir AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."' AND TIME_FORMAT(b_bayar.tgl_act,'%H:%i') BETWEEN '$txtJam1' AND '$txtJam2' GROUP BY b_ms_pegawai.id ORDER BY b_ms_pegawai.nama";
					//echo $sqlNm."<br>";
					$rsNm = mysql_query($sqlNm);
					while($rwNm = mysql_fetch_array($rsNm))
					{
			?>
			<tr>
				<td colspan="8" style="padding-left:10px; text-transform:uppercase; text-decoration:underline; font-weight:bold;" height="25"><?php echo $rwNm['nama'];?></td>
			</tr>
            <?php
				$sUnit="SELECT 
						b_ms_unit.id, 
						b_ms_unit.nama 
						FROM b_bayar 
						INNER JOIN b_ms_unit ON b_ms_unit.id = b_bayar.unit_id 
						WHERE 
						b_bayar.user_act = '".$rwNm['id']."' 
						AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."' AND TIME_FORMAT(b_bayar.tgl_act,'%H:%i') BETWEEN '$txtJam1' AND '$txtJam2' 
						GROUP BY b_ms_unit.id 
						ORDER BY b_ms_unit.nama";
				$qUnit=mysql_query($sUnit);
				$total=0;
				while($rwUnit=mysql_fetch_array($qUnit)){
			?>
            <tr>
				<td colspan="8" style="padding-left:20px; text-transform:uppercase; text-decoration:underline; font-weight:bold;" height="25"><?php echo $rwUnit['nama']; ?></td>
			</tr>
			<?php
					$sqlPas = "SELECT
					TIME_FORMAT(b.tgl_act,'%H:%i') AS jam, 
					DATE_FORMAT(b.tgl,'%d-%m-%Y') AS tgl,
					b.no_kwitansi as kwi,
					ps.no_rm,
					ps.nama as pasien,
					kso.nama as kso,
					b.nilai 
					FROM
					b_bayar b
					INNER JOIN b_kunjungan k ON k.id=b.kunjungan_id
					INNER JOIN b_ms_pasien ps ON ps.id=k.pasien_id
					INNER JOIN b_ms_kso kso ON kso.id=b.kso_id
					WHERE
					b.user_act = '".$rwNm['id']."'
					AND b.unit_id = '".$rwUnit['id']."'
					AND b.tgl BETWEEN  '".$tglAwal2."' AND '".$tglAkhir2."' 
					AND TIME_FORMAT(b.tgl_act,'%H:%i') BETWEEN '$txtJam1' AND '$txtJam2'
					ORDER BY b.id";
					$rsPas = mysql_query($sqlPas);
					$no = 1;
					$sub = 0;
					while($rwPas = mysql_fetch_array($rsPas))
					{
			?>
			<tr>
				<td style="text-align:center; padding-left:20px;"><?php echo $no;?></td>
				<td style="text-align:center"><?php echo $rwPas['tgl'];?></td>
				<td style="text-align:center"><?php echo $rwPas['jam'];?></td>
				<td style="text-align:center"><?php echo $rwPas['kwi'];?></td>
				<td style="text-align:center"><?php echo $rwPas['no_rm'];?></td>
				<td style="text-transform:uppercase;">&nbsp;<?php echo $rwPas['pasien'];?></td>
				<td style="text-align:center"><?php echo $rwPas['kso'];?></td>
				<td style="text-align:right; padding-right:20px;"><?php echo number_format($rwPas['nilai'],0,",",".");?></td>
			</tr>
			<?php
					$no++;
					$sub = $sub + $rwPas['nilai'];
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
				<td style="text-align:right; padding-right:20px; border-top:1px solid;"><?php echo number_format($sub,0,",",".");?></td>
			</tr>
            <?php
					$total = $total + $sub;
					}
            ?>
            <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td style="text-align:right">Total&nbsp;</td>
				<td style="text-align:right; padding-right:20px; border-top:1px solid;"><?php echo number_format($total,0,",",".");?></td>
			</tr>
			<?php
					$gtotal = $gtotal + $total;
					}
			?>
			<tr>
				<td height="25" colspan="7" style="text-align:right; font-weight:bold; border-top:1px solid; ">GRAND TOTAL&nbsp;</td>
				<td style="text-align:right; padding-right:20px; border-top:1px solid; font-weight:bold;"><?php echo number_format($gtotal,0,",",".");?></td>
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
