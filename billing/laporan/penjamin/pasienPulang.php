<?php 
session_start();
include("../../sesi.php");
include("../../koneksi/konek.php");
if($_POST['export']=='excel'){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="PengirimanKonsul.xls"');
}
//session_start();
$userId = $_SESSION['userId'];
//==========Menangkap filter data====
$jam = date("G:i");
$date_now=gmdate('d-m-Y',mktime(date('H')+7));
$stsPas=$_REQUEST['StatusPas0'];
if($stsPas==0) $fKso = ""; else $fKso = "AND p.kso_id = '".$stsPas."'";
//echo $filterVer;
$jnsLayanan = $_REQUEST['JnsLayananDenganInap'];
$tmpLayanan = $_REQUEST['TmpLayananInapSaja'];
if($tmpLayanan==0) $fTmp = "p.jenis_layanan = '".$jnsLayanan."'"; else $fTmp = "p.unit_id = '".$tmpLayanan."'";
$user_act=$_REQUEST['user_act'];
$rsUser=mysql_query("SELECT nip,nama FROM b_ms_pegawai WHERE id=$user_act");
$rwUser=mysql_fetch_array($rsUser);
$arrBln = array('01'=>'Januari','02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
$waktu = $_POST['cmbWaktu'];
if($waktu == 'Harian'){
	$tglAwal = explode('-',$_REQUEST['tglAwal2']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	$waktu = " AND DATE(pk.tgl_act) = '$tglAwal2' ";
	$Periode = "Tanggal : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2];
}else if($waktu == 'Bulanan'){
	$bln = $_POST['cmbBln'];
	$thn = $_POST['cmbThn'];
	$waktu = " AND month(pk.tgl_act) = '$bln' and year(pk.tgl_act) = '$thn' ";
	$Periode = "Bulan $arrBln[$bln] Tahun $thn";
}else{
	$tglAwal = explode('-',$_REQUEST['tglAwal']);
	$tglAwal2 = $tglAwal[2].'-'.$tglAwal[1].'-'.$tglAwal[0];
	//echo $arrBln[$tglAwal[1]];
	$tglAkhir = explode('-',$_REQUEST['tglAkhir']);
	$tglAkhir2 = $tglAkhir[2].'-'.$tglAkhir[1].'-'.$tglAkhir[0];
	$waktu = " AND DATE(pk.tgl_act) between '$tglAwal2' and '$tglAkhir2' ";
	$Periode = "Periode : ".$tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2];
}

	$sqlUnit2 = "SELECT id,nama FROM b_ms_unit WHERE id = '".$tmpLayanan."'";
	//echo $sqlUnit2."<br>";
	$rsUnit2 = mysql_query($sqlUnit2);
	$rwUnit2 = mysql_fetch_array($rsUnit2);
	
	$sqlPenjamin = "SELECT nama FROM b_ms_kso WHERE id='".$stsPas."'";
	//echo $sqlPenjamin."<br>";
	$rsPenjamin = mysql_query($sqlPenjamin);
	$hsPenjamin = mysql_fetch_array($rsPenjamin);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Laporan Pasien Pulang :.</title>
</head>
<style>
	.jdl{
		font-weight:bold;
		text-align:center;
		border-top:1px solid #000000;
		border-bottom:1px solid #000000;
		height:28px;
		border-left:1px solid #000000;
	}
	.isi{
		border-left:1px solid #000000;
		border-bottom:1px solid #000000;
	}
</style>
<body>
<table align="left" width="1000" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
  <tr>
    <td><b><?=$pemkabRS?><br><?=$namaRS?><br><?=$alamatRS?><br>Telepon <?=$tlpRS?><br/></b>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" height="70" valign="top" style="font-weight:bold; font-size:14px; text-transform:uppercase">LAPORAN PASIEN PULANG / KRS ( <?php if($tmpLayanan=='0') echo 'SEMUA'; else echo $rwUnit2['nama']?> )<br/><?php echo $Periode;?>&nbsp;</td>
  </tr>
  <tr>
    <td height="30" style="font-weight:bold">Penjamin Pasien&nbsp;:&nbsp;<?php if($stsPas==0) echo "SEMUA"; else echo $hsPenjamin['nama'];?></td>
  </tr>
  <tr>
    <td>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;">
			<tr>
				<td rowspan="2" class="jdl">NO</td>
				<td rowspan="2" class="jdl">NO RM</td>
				<td rowspan="2" class="jdl">NAMA PASIEN</td>
				<td rowspan="2" class="jdl">MRS</td>
				<td rowspan="2" class="jdl">KRS</td>
				<td rowspan="2" class="jdl">RUANG RAWAT</td>
				<td rowspan="2" class="jdl">STATUS PASIEN </td>
				<td rowspan="2" class="jdl">ASAL KUNJUNGAN </td>
				<td colspan="2" class="jdl">BIAYA<BR />RAWAT INAP</td>
				<td rowspan="2" class="jdl" style="border-right:1px solid #000000;">TOTAL</td>
			</tr>
			<tr>
			  	<td height="28" style="text-align:center; font-weight:bold; border-bottom:1px solid #000000; border-left:1px solid #000000;">IGD/<br>POLI</td>
				<td style="text-align:center; font-weight:bold; border-bottom:1px solid #000000; border-left:1px solid #000000;">RI</td>
			</tr>
			<?php
					$q = "SELECT p.kunjungan_id, p.id, mp.no_rm, mp.nama, p.unit_id_asal,
						(SELECT DATE_FORMAT(b_pelayanan.tgl,'%d-%m-%Y') FROM b_pelayanan WHERE kunjungan_id=p.kunjungan_id
						AND jenis_kunjungan='3' ORDER BY b_pelayanan.id ASC LIMIT 1) AS mrs,
						DATE_FORMAT(pk.tgl_act,'%d-%m-%Y') AS krs, 
						(SELECT nama FROM b_ms_kso WHERE id=p.kso_id) AS kso, 
						(SELECT nama FROM b_ms_unit INNER JOIN b_kunjungan ON b_kunjungan.unit_id=b_ms_unit.id 
						WHERE b_kunjungan.id=p.kunjungan_id) AS asal 
						FROM b_ms_pasien mp 
						INNER JOIN b_pelayanan p ON p.pasien_id=mp.id 
						INNER JOIN b_tindakan_kamar tk ON tk.pelayanan_id=p.id
						INNER JOIN b_pasien_keluar pk ON pk.pelayanan_id=p.id
						WHERE $fTmp $waktu $fKso
						GROUP BY p.kunjungan_id ORDER BY pk.tgl_act";
					//echo $q."<br/>";
					$s = mysql_query($q);
					$no = 1;
					while($w = mysql_fetch_array($s)){
						$qIgd = "SELECT SUM(t.biaya*t.qty) AS igd FROM b_pelayanan p
								INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
								WHERE t.kunjungan_id='".$w['kunjungan_id']."' AND p.jenis_kunjungan<>3";
						$sIgd = mysql_query($qIgd);
						$wIgd = mysql_fetch_array($sIgd);
						
						$qIn = "SELECT SUM(t.biaya*t.qty) AS inap FROM b_pelayanan p
								INNER JOIN b_tindakan t ON p.id=t.pelayanan_id
								WHERE t.kunjungan_id='".$w['kunjungan_id']."' AND p.jenis_kunjungan=3";
						$sIn = mysql_query($qIn);
						$wIn = mysql_fetch_array($sIn);
						
						$qKmr = "SELECT SUM(t.kamar) AS kamar FROM (SELECT IF(tk.status_out=0,IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,1,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*(tk.tarip), 
IF(DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in)=0,0,DATEDIFF(IFNULL(tk.tgl_out,NOW()),tk.tgl_in))*(tk.tarip)) kamar  FROM b_pelayanan p 
INNER JOIN b_tindakan_kamar tk ON tk.pelayanan_id=p.id
WHERE p.kunjungan_id='".$w['kunjungan_id']."' ) AS t";
						$sKmr = mysql_query($qKmr);
						$wKmr = mysql_fetch_array($sKmr);
						
						$biayaInap = $wIn['inap'] + $wKmr['kamar'];
						$total = $wIgd['igd'] + $biayaInap;
						
						//if($w['unit_id_asal']=='45') $igd=number_format($wIgd['igd'],0,",","."); else $igd="0";
					
			?>
			<tr style="text-transform:uppercase; font-size:10px;">
				<td height="22" width="3%" class="isi" style="text-align:right; padding-right:5px;"><?php echo $no;?></td>
				<td width="7%" class="isi" align="center"><?php echo $w['no_rm'];?></td>
				<td width="18%" class="isi" style="padding-left:5px;"><?php echo $w['nama'];?></td>
				<td width="8%" class="isi" style="text-align:center;"><?php echo $w['mrs'];?></td>
				<td width="8%" class="isi" style="text-align:center;"><?php echo $w['krs'];?></td>
				<td width="11%" class="isi" style="padding-left:5px;">
				<?php
					$qUn = "SELECT b_ms_unit.id, b_ms_unit.nama FROM b_ms_unit INNER JOIN b_pelayanan ON b_pelayanan.unit_id=b_ms_unit.id
							WHERE b_pelayanan.kunjungan_id='".$w['kunjungan_id']."' AND b_pelayanan.jenis_kunjungan=3 AND b_ms_unit.inap=1";
					$sUn = mysql_query($qUn);
					while($wUn = mysql_fetch_array($sUn)){
						echo $wUn['nama'].',<br>';
					}
				?>
				</td>
				<td width="11%" class="isi" style="text-align:center;"><?php echo $w['kso'];?></td>
				<td width="11%" class="isi" style="text-align:center;"><?php echo $w['asal'];?></td>
				<td width="7%" class="isi" style="text-align:right; padding-right:5px;"><?php echo number_format($wIgd['igd'],0,",",".");?></td>
				<td width="7%" class="isi" style="text-align:right; padding-right:5px;"><?php echo number_format($biayaInap,0,",",".")?></td>
				<td width="9%" class="isi" style="border-right:1px solid #000000; text-align:right; padding-right:5px;"><?php echo number_format($total,0,",",".")?></td>
			</tr>
			<?php	
					$no++;
					$jmlh1 += $wIgd['igd'];
					$jmlh2 += $biayaInap;
					$jmlh3 += $total;
					}	?>
			<tr height="28" style="font-weight:bold;">
				<td colspan="8" class="isi" align="center">TOTAL</td>
				<td class="isi" style="padding-right:5px; text-align:right;"><?php echo number_format($jmlh1,0,",",".");?></td>
				<td class="isi" style="padding-right:5px; text-align:right;"><?php echo number_format($jmlh2,0,",",".");?></td>
				<td class="isi" style="border-right:1px solid #000000; padding-right:5px; text-align:right;"><?php echo number_format($jmlh3,0,",",".");?></td>
			</tr>
		</table>
	</td>
  </tr>
  <tr>
    <td align="right" style="font-size:11px" height="30" valign="bottom">Tgl Cetak: <?php echo $date_now;?>&nbsp;Jam: <?php echo $jam;?></td>
  </tr>
  <tr>
    <td align="right" style="font-size:11px">Yang Mencetak,&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/><b><?php echo $rwUser['nama']?></b>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr id="trTombol">
        <td colspan="4" class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>
        </td>
    </tr>
</table>
</body>
<?php
	//mysql_free_result($qPenjamin);
	//mysql_free_result($qUser);
	mysql_close($konek);
?>
</html>
<script type="text/JavaScript">

/* try{	
formatF4();
}catch(e){
window.location='../../addon/jsprintsetup.xpi';
} */
    function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
		/* try{
			mulaiPrint();
		}
		catch(e){
			window.print();
		} */
		window.print();
		window.close();
        }
    }
</script>
