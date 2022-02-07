<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Rincian Penerimaan Kasir Rawat Inap Berdasarkan Akhir Layanan</title>
</head>

<body>
<?php
	session_start();
	include("../../sesi.php");
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
?>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="1" style="text-align:center; font:12px tahoma; font-weight:bold">
  <tr>
    <td>RINCIAN PENERIMAAN KASIR RAWAT INAP</td>
  </tr>
  <tr>
    <td>BERDASARKAN AKHIR LAYANAN</td>
  </tr>
  <tr>
    <td>TANGGAL <?php echo $periode; ?></td>
  </tr>
</table>
<br />
<table width="800" align="center" cellpadding="1" cellspacing="0">
  <tr style="text-align:center; font:12px tahoma; font-weight:bold; text-transform:uppercase; background-color:#999999;">
    <td width="56" height="34">NO</td>
    <td width="33">&nbsp;</td>
    <td width="218">URAIAN</td>
    <td width="88">Mrs</td>
    <td width="88">Krs</td>
    <td width="139">Status</td>
    <td width="78">Nilai</td>
    <td width="66">&nbsp;</td>
  </tr>
  <?php
	$sql_kasir = "SELECT DISTINCT
	  mp.id,
	  mp.nama
		FROM b_bayar b
	  INNER JOIN b_ms_pegawai mp
		ON b.user_act = mp.id
	WHERE b.kasir_id = '83'
		AND b.tgl $period
	ORDER BY mp.nama";
	//echo $sql_kasir;
	$kueri_kasir = mysql_query($sql_kasir);
	$jml_kasir = mysql_num_rows($kueri_kasir);
	$abjad = 'A';
	while($kasir=mysql_fetch_array($kueri_kasir)){
		$stot = 0;
	?>
  <tr style="font: bold 11px tahoma; background-color:#CCCCCC;">
    <td height="27" align="center"><b><?=$abjad;?></b></td>
    <td style="padding-left:20px;">&nbsp;</td>
    <td style="padding-left:20px;"><b>KASIR <?php if($kasir['nama']==''){echo $kasir['id'];} else{echo $kasir['nama'];} ?>
    </b></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<?php
			$sql = "SELECT DISTINCT t2.unit_id id,t2.nama FROM (SELECT * FROM (SELECT p.id,p.kunjungan_id,p.unit_id, mu.nama 
FROM (SELECT * FROM b_bayar WHERE kasir_id = '83' AND user_act ='$kasir[id]' 
AND tgl $period) b INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id 
INNER JOIN b_tindakan t ON bt.tindakan_id = t.id INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id 
INNER JOIN b_ms_unit mu ON p.unit_id = mu.id 
WHERE mu.inap = '1' AND bt.tipe=0
UNION
SELECT p.id,p.kunjungan_id,p.unit_id, mu.nama 
FROM (SELECT * FROM b_bayar WHERE kasir_id = '83' AND user_act ='$kasir[id]' 
AND tgl $period) b INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id 
INNER JOIN b_tindakan_kamar tk ON bt.tindakan_id = tk.id INNER JOIN b_pelayanan p ON tk.pelayanan_id = p.id 
INNER JOIN b_ms_unit mu ON p.unit_id = mu.id 
WHERE mu.inap = '1' AND bt.tipe=1) AS t ORDER BY t.kunjungan_id,t.id DESC) AS t2 GROUP BY t2.kunjungan_id";
			//echo $sql."<br>";
			$kueri = mysql_query($sql);
			$no = 1;
			while($poli=mysql_fetch_array($kueri)){
			?>
  <tr style="font:11px tahoma;">
    <td align="center"><?php echo $no; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;<b><?php echo $poli['nama']; ?></b></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <?php
	$q_pasien="SELECT mp.nama ps_nama,k.id FROM (SELECT DISTINCT t1.kunjungan_id,t1.unit_id,t1.nama 
FROM (SELECT DISTINCT p.id,p.kunjungan_id,p.unit_id, mu.nama FROM (SELECT * FROM b_bayar WHERE kasir_id = '83' AND user_act ='$kasir[id]' 
AND tgl $period) b INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id 
INNER JOIN b_tindakan t ON bt.tindakan_id = t.id INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id 
INNER JOIN b_ms_unit mu ON p.unit_id = mu.id WHERE mu.inap = '1' AND bt.tipe=0 ORDER BY p.kunjungan_id,p.id DESC) AS t1 GROUP BY t1.kunjungan_id) t2
INNER JOIN b_kunjungan k ON t2.kunjungan_id=k.id INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id
WHERE t2.unit_id='$poli[id]'";
	//echo $q_pasien."<br>";
	$sql_pasien = mysql_query($q_pasien);
	$i=1;
	$t=0;
	while($data_pasien=mysql_fetch_array($sql_pasien))
	{
		$sqlKamar="SELECT date_format(k.tgl_in,'%d-%m-%Y') tgl_in,date_format(k.tgl_out,'%d-%m-%Y') tgl_out FROM b_pelayanan p INNER JOIN b_tindakan_kamar k ON p.id=k.pelayanan_id WHERE p.kunjungan_id='".$data_pasien['id']."' ORDER BY p.id";
		$rsKamar=mysql_query($sqlKamar);
		$rwKamar=mysql_fetch_array($rsKamar);
		$mrs=$rwKamar["tgl_in"];
		$krs=$rwKamar["tgl_out"];
		while ($rwKamar=mysql_fetch_array($rsKamar)){
			$krs=$rwKamar["tgl_out"];
		}
		
		$sqlKSO="SELECT kso.nama FROM b_pelayanan p INNER JOIN b_ms_kso kso ON p.kso_id=kso.id WHERE p.kunjungan_id='".$data_pasien['id']."' AND p.unit_id='$poli[id]'";
		$rsKSO=mysql_query($sqlKSO);
		$rwKSO=mysql_fetch_array($rsKSO);
		
		$sqlBayar="SELECT IFNULL(SUM(t1.nilai),0) AS nilai 
FROM (SELECT bt.id,bt.nilai FROM (SELECT * FROM b_bayar WHERE kasir_id = '83' AND user_act ='$kasir[id]' 
AND tgl $period) b INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id 
INNER JOIN b_tindakan t ON bt.tindakan_id = t.id INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id 
WHERE p.kunjungan_id='".$data_pasien['id']."' AND bt.tipe=0 AND bt.nilai>0
UNION
SELECT bt.id,bt.nilai FROM (SELECT * FROM b_bayar WHERE kasir_id = '83' AND user_act ='$kasir[id]' 
AND tgl $period) b INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id 
INNER JOIN b_tindakan_kamar t ON bt.tindakan_id = t.id INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id 
WHERE p.kunjungan_id='".$data_pasien['id']."' AND bt.tipe=1 AND bt.nilai>0) AS t1";
		$rsBayar=mysql_query($sqlBayar);
		$rwBayar=mysql_fetch_array($rsBayar);
  ?>
  <tr style="font:11px tahoma;<?php if($i%2==1) echo "background-color:#EEEEEE"; else echo ""; ?> ">
    <td>&nbsp;</td>
    <td><?=$i;?>. </td>
    <td>&nbsp;<?=$data_pasien['ps_nama'];?></td>
    <td align="center">&nbsp;<?=$mrs;?></td>
    <td align="center">&nbsp;<?=$krs;?></td>
    <td align="center">&nbsp;<?=$rwKSO['nama'];?></td>
    <td align="right"><?= number_format($rwBayar['nilai'],'0',',','.');?></td>
    <td>&nbsp;</td>
  </tr>
  <?php
  $i++;
  $t += $rwBayar['nilai'];
  $tot += $rwBayar['nilai'];
  }  
  ?>
    <tr style="font:bold 11px tahoma;">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><?=number_format($t,'0',',','.');?></td>
  </tr>
  <?php
  $no++;
  $stot +=$t;
  }
  ?>
<?php
			$sql = "SELECT DISTINCT id,nama FROM (SELECT DISTINCT t.kunjungan_id,t.unit_id id,t.nama FROM (SELECT p.id,p.kunjungan_id,p.unit_id, mu.nama,
(SELECT DISTINCT kunjungan_id FROM b_pelayanan WHERE jenis_kunjungan=3 AND kunjungan_id=p.kunjungan_id) kunjId 
FROM (SELECT * FROM b_bayar WHERE kasir_id = '83' AND user_act ='$kasir[id]' AND tgl $period) b 
INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id INNER JOIN b_tindakan t ON bt.tindakan_id = t.id 
INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id INNER JOIN b_ms_unit mu ON p.unit_id = mu.id WHERE bt.tipe=0) AS t
WHERE t.kunjId IS NULL ORDER BY t.kunjungan_id,t.id DESC) AS t1 GROUP BY t1.kunjungan_id";
			//echo $sql."<br>";
			$kueri = mysql_query($sql);
			//$no = 1;
			while($poli=mysql_fetch_array($kueri)){
			?>
  <tr style="font:11px tahoma;">
    <td align="center"><?php echo $no; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;<b><?php echo $poli['nama']; ?></b></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <?php
	$q_pasien="SELECT mp.nama ps_nama,k.id FROM (SELECT * FROM (SELECT DISTINCT t.kunjungan_id,t.unit_id,t.nama FROM (SELECT p.id,p.kunjungan_id,p.unit_id, mu.nama,
(SELECT DISTINCT kunjungan_id FROM b_pelayanan WHERE jenis_kunjungan=3 AND kunjungan_id=p.kunjungan_id) kunjId 
FROM (SELECT * FROM b_bayar WHERE kasir_id = '83' AND user_act ='$kasir[id]' AND tgl $period) b 
INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id INNER JOIN b_tindakan t ON bt.tindakan_id = t.id 
INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id INNER JOIN b_ms_unit mu ON p.unit_id = mu.id WHERE bt.tipe=0) AS t
WHERE t.kunjId IS NULL ORDER BY t.kunjungan_id,t.id DESC) AS t1 GROUP BY t1.kunjungan_id) t2
INNER JOIN b_kunjungan k ON t2.kunjungan_id=k.id INNER JOIN b_ms_pasien mp ON k.pasien_id=mp.id
WHERE t2.unit_id='$poli[id]'";
	//echo $q_pasien."<br>";
	$sql_pasien = mysql_query($q_pasien);
	$i=1;
	$t=0;
	while($data_pasien=mysql_fetch_array($sql_pasien))
	{
		$sqlKamar="SELECT date_format(k.tgl_in,'%d-%m-%Y') tgl_in,date_format(k.tgl_out,'%d-%m-%Y') tgl_out FROM b_pelayanan p INNER JOIN b_tindakan_kamar k ON p.id=k.pelayanan_id WHERE p.kunjungan_id='".$data_pasien['id']."' ORDER BY p.id";
		$rsKamar=mysql_query($sqlKamar);
		$rwKamar=mysql_fetch_array($rsKamar);
		$mrs=$rwKamar["tgl_in"];
		$krs=$rwKamar["tgl_out"];
		while ($rwKamar=mysql_fetch_array($rsKamar)){
			$krs=$rwKamar["tgl_out"];
		}
		
		$sqlKSO="SELECT kso.nama FROM b_pelayanan p INNER JOIN b_ms_kso kso ON p.kso_id=kso.id WHERE p.kunjungan_id='".$data_pasien['id']."' AND p.unit_id='$poli[id]'";
		$rsKSO=mysql_query($sqlKSO);
		$rwKSO=mysql_fetch_array($rsKSO);
		
		$sqlBayar="SELECT IFNULL(SUM(t1.nilai),0) AS nilai 
FROM (SELECT bt.id,bt.nilai FROM (SELECT * FROM b_bayar WHERE kasir_id = '83' AND user_act ='$kasir[id]' 
AND tgl $period) b INNER JOIN b_bayar_tindakan bt ON b.id = bt.bayar_id 
INNER JOIN b_tindakan t ON bt.tindakan_id = t.id INNER JOIN b_pelayanan p ON t.pelayanan_id = p.id 
WHERE p.kunjungan_id='".$data_pasien['id']."' AND bt.tipe=0 AND bt.nilai>0) AS t1";
		$rsBayar=mysql_query($sqlBayar);
		$rwBayar=mysql_fetch_array($rsBayar);
  ?>
  <tr style="font:11px tahoma;<?php if($i%2==1) echo "background-color:#EEEEEE"; else echo ""; ?> ">
    <td>&nbsp;</td>
    <td><?=$i;?>. </td>
    <td>&nbsp;<?=$data_pasien['ps_nama'];?></td>
    <td align="center">&nbsp;<?=$mrs;?></td>
    <td align="center">&nbsp;<?=$krs;?></td>
    <td align="center">&nbsp;<?=$rwKSO['nama'];?></td>
    <td align="right"><?= number_format($rwBayar['nilai'],'0',',','.');?></td>
    <td>&nbsp;</td>
  </tr>
  <?php
  $i++;
  $t += $rwBayar['nilai'];
  $tot += $rwBayar['nilai'];
  }  
  ?>
    <tr style="font:bold 11px tahoma;">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><?=number_format($t,'0',',','.');?></td>
  </tr>
  <?php
  $no++;
  $stot +=$t;
  }
  ?>
    <tr style="font:bold 11px tahoma;">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">SUBTOTAL :&nbsp;</td>
    <td style="border-top:1px solid">&nbsp;</td>
    <td align="right" style="border-top:1px solid"><?=number_format($stot,'0',',','.');?></td>
  </tr>
  <?php
  $abjad++;
  }
  ?>
  <tr style="font:bold 11px tahoma;">
    <td height="30">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">TOTAL :&nbsp;</td>
    <td align="right" style="border-top:1px solid">&nbsp;</td>
    <td align="right" style="border-top:1px solid"><?=number_format($tot,'0',',','.');?></td>
  </tr>
  <tr>
  	<td colspan="2" height="30">&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="2" height="30">&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="6">&nbsp;</td>
	<td colspan="2" align="right" style="font-size:11px;">Tgl Cetak:&nbsp;<?php echo $date_now;?>&nbsp;Jam:&nbsp;<?php echo $jam?></td>
  </tr>
  <tr>
  	<td colspan="6">&nbsp;</td>
	<td colspan="2" align="right" style="font-size:11px;">Yang Mencetak</td>
  </tr>
  <tr>
  	<td colspan="8" height="50">&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="6">&nbsp;</td>
	<td colspan="2" align="right" style="font-size:11px;"><b><?php echo $rwPeg['nama'];?></b></td>
  </tr>
  
   <tr>
  	<td colspan="8" height="50">
	 <tr id="trTombol">
       <td colspan="8" class="noline" align="center">
			<?php 
			if($_POST['excel']!='excel'){
			?>
            <select name="select" id="cmbPrint2an" onchange="changeSize(this.value)">
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
</html>
<script>
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