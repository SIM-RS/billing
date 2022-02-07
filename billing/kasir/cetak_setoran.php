<?php 
session_start();
include("../sesi.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/JavaScript" language="JavaScript" src="../../theme/js/formatPrint.js"></script>
<title>Setoran Kasir</title>
</head>

<body>
<?php
	include("../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$jam = date("G:i");
	$filter=$_REQUEST["filter"];
	$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$tglAwal = explode('-',$_REQUEST['tgl']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	
?>
<table id="tblPrint" width="800" border="0" cellspacing="0" cellpadding="0" align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td colspan="2"><b><?=$_SESSION['namaP'] ?><br /><?=$_SESSION['alamatP']?><br />Telepon <?=$_SESSION['tlpP'] ?><br /><?=$_SESSION['kotaP']?></b></td>
  </tr>
  <tr>
    <td colspan="2" align="center" height="70" valign="top" style="font-size:14px; text-transform:uppercase;"><b>Cetak Setoran Penerimaan Kasir<br />Tanggal <?php echo $tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2]; ?></b></td>
  </tr>
  <tr>
  	<td colspan="2">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
			<tr style="text-align:center; font-weight:bold;">
				<td width="6%" style="border-top:1px solid; border-bottom:1px solid;">No</td>
				<td width="18%" style="border-top:1px solid; border-bottom:1px solid;" align="left">Penyetor</td>
				<td width="11%" style="border-top:1px solid; border-bottom:1px solid;">Tgl Setor</td>
				<td width="8%" style="border-top:1px solid; border-bottom:1px solid;">Jam</td>
				<td width="12%" style="border-top:1px solid; border-bottom:1px solid;">No.<br />Kwitansi</td>
				<td width="10%" style="border-top:1px solid; border-bottom:1px solid;">No.RM</td>
				<td width="24%" style="border-top:1px solid; border-bottom:1px solid;" align="left">Nama Pasien</td>
				<td width="11%" style="border-top:1px solid; border-bottom:1px solid;">Nilai</td>
			</tr>
			<?php
				if ($filter!=""){
					$filter=explode("|",$filter);
					$filter=" AND ".$filter[0]." like '%".$filter[1]."%'";
				}
				$sqlPas="SELECT 
				DATE_FORMAT(b_bayar.disetor_tgl,'%d-%m-%Y') AS tgl,
				DATE_FORMAT(b_bayar.disetor_tgl,'%H:%i') AS jam,
				b_bayar.no_kwitansi AS kwi,
				b_ms_pasien.no_rm,
				b_ms_pasien.nama as pasien,
				b_bayar.nilai,
				b_ms_pegawai.nama as penyetor
				FROM
				b_bayar
				INNER JOIN b_kunjungan ON b_kunjungan.id = b_bayar.kunjungan_id
				INNER JOIN b_ms_pasien ON b_ms_pasien.id = b_kunjungan.pasien_id
				INNER JOIN b_ms_pegawai ON b_ms_pegawai.id = b_bayar.disetor_oleh
				WHERE DATE(b_bayar.disetor_tgl)='".$tglAwal2."' AND b_bayar.disetor_oleh='".$_REQUEST['kasir']."' AND b_bayar.flag ='$flag'  AND b_bayar.disetor=1 {$filter}";
				//echo $sqlPas."<br>";
				$rsPas = mysql_query($sqlPas);
				$no = 1;
				$sub = 0;
				while($rwPas = mysql_fetch_array($rsPas))
				{
			?>
			<tr>
				<td style="text-align:center;"><?php echo $no;?></td>
				<td style="text-align:left">&nbsp;<?php echo $rwPas['penyetor'];?></td>
				<td style="text-align:center"><?php echo $rwPas['tgl'];?></td>
				<td style="text-align:center"><?php echo $rwPas['jam'];?></td>
				<td style="text-align:center"><?php echo $rwPas['kwi'];?></td>
				<td style="text-align:center"><?php echo $rwPas['no_rm'];?></td>
				<td style="text-transform:uppercase;">&nbsp;<?php echo $rwPas['pasien'];?></td>
				<td style="text-align:right; padding-right:20px;"><?php echo number_format($rwPas['nilai'],0,",",".");?></td>
			</tr>
			<?php
					$no++;
					$sub = $sub + $rwPas['nilai'];
					}
			?>
			<tr>
				<td height="25" colspan="7" style="text-align:right; font-weight:bold; border-top:1px solid; ">TOTAL&nbsp;</td>
				<td style="text-align:right; padding-right:20px; border-top:1px solid; font-weight:bold;"><?php echo number_format($sub,0,",",".");?></td>
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
