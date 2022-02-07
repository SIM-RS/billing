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
<title>.: Rekapitulasi Penerimaan Kasir Berdasarkan Kunjungan Pasien :.</title>
</head>
<?php
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
	$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = '".$_REQUEST['user_act']."'";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);
	$kasir = $_REQUEST['cmbKasir2'];
	$nmKasir = $_REQUEST['nmKsr'];
	
	$qKsr = "SELECT id, nama FROM b_ms_unit WHERE id = '".$kasir."'";
	$rsKsr = mysql_query($qKsr);
	$rwKsr = mysql_fetch_array($rsKsr);
	
?>
<style>
	.tblatas
	{
		font-weight:bold;
		text-transform:uppercase;
		border-bottom:1px solid #000000;
		border-top:1px solid #000000;
		/*background-color:#00FFFF;*/
		text-align:center;
	}
</style>
<body>
<table id="tblPrint" width="800" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td><b>Rumah Sakit Umum Daerah Kabupaten Sidoarjo<br />Jl. Mojopahit 667 Sidoarjo<br />Telepon (031) 8961649<br />Sidoarjo</b></td>
	</tr>
	<tr>
		<td align="center" height="70" valign="middle" style="font-size:14px; text-transform:uppercase;"><b>Laporan Penerimaan <?php echo $rwKsr['nama'];?><br />Periode <?php echo $tglAwal[0]." ".$arrBln[$tglAwal[1]]." ".$tglAwal[2].' s/d '.$tglAkhir[0]." ".$arrBln[$tglAkhir[1]]." ".$tglAkhir[2]?></b></td>
	</tr>
	<tr>
		<td height="30" style="font-weight:bold;">&nbsp;<?php echo $rwKsr['nama']?></td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
				<tr>
					<td width="30" class="tblatas" height="30">no</td>
					<td width="100" class="tblatas">TGL BAYAR</td>
					<td width="80" class="tblatas">NO KWITANSI</td>
					<td width="70" class="tblatas">no rm</td>
					<td class="tblatas">nama</td>
					<td width="150" class="tblatas">status</td>
				    <td width="90" class="tblatas">NILAI</td>
				</tr>
				<?php
						if($nmKasir!=0){
							$fKasir = "b_bayar.user_act = '".$nmKasir."'";
						}else{
							$fKasir = "b_ms_pegawai_unit.unit_id = '".$kasir."'";
						}
						$sqlNm = "SELECT b_ms_pegawai.id, b_ms_pegawai.nama FROM b_bayar INNER JOIN b_ms_pegawai ON b_ms_pegawai.id = b_bayar.user_act INNER JOIN b_ms_pegawai_unit ON b_ms_pegawai_unit.ms_pegawai_id = b_ms_pegawai.id WHERE $fKasir AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."' GROUP BY b_ms_pegawai.id ORDER BY b_ms_pegawai.nama";
						$rsNm = mysql_query($sqlNm);
						while($rwNm = mysql_fetch_array($rsNm))
						{
				?>
				<tr>
					<td colspan="7" style="padding-left:20px; text-transform:uppercase; text-decoration:underline; font-weight:bold;" height="30" valign="middle"><?php echo $rwNm['nama'];?></td>
				</tr>
				<?php
						$sqlPas = "SELECT t.no_rm, t.pasien, t.kunjungan_id,t.id,date_format(t.tgl,'%d-%m-%Y') as tglBayar,t.nobukti,t.nama AS kso,SUM(t.nilai) AS nilai FROM (SELECT b_ms_pasien.no_rm, b_ms_pasien.nama AS pasien, b_kunjungan.id AS kunjungan_id,b_bayar.id,b_bayar.tgl,b_bayar.nobukti,
b_tindakan.kso_id,kso.nama,b_bayar_tindakan.nilai,b_bayar_tindakan.id btinId FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id=b_ms_pasien.id INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id INNER JOIN b_tindakan ON b_tindakan.pelayanan_id=b_pelayanan.id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan.id INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id INNER JOIN b_ms_kso kso ON b_tindakan.kso_id=kso.id WHERE b_bayar.user_act='".$rwNm['id']."' AND b_bayar_tindakan.tipe=0 AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."'
UNION
SELECT b_ms_pasien.no_rm, b_ms_pasien.nama AS pasien, b_kunjungan.id AS kunjungan_id,b_bayar.id,b_bayar.tgl,b_bayar.nobukti,
IF((b_tindakan_kamar.kso_id=0 OR ISNULL(b_tindakan_kamar.kso_id)),b_pelayanan.kso_id,b_tindakan_kamar.kso_id) kso_id,IFNULL(kso.nama,b_ms_kso.nama) nama,b_bayar_tindakan.nilai,b_bayar_tindakan.id btinId FROM b_ms_pasien INNER JOIN b_kunjungan ON b_kunjungan.pasien_id=b_ms_pasien.id INNER JOIN b_pelayanan ON b_pelayanan.kunjungan_id=b_kunjungan.id INNER JOIN b_ms_kso ON b_pelayanan.kso_id=b_ms_kso.id INNER JOIN b_tindakan_kamar ON b_tindakan_kamar.pelayanan_id=b_pelayanan.id INNER JOIN b_bayar_tindakan ON b_bayar_tindakan.tindakan_id=b_tindakan_kamar.id INNER JOIN b_bayar ON b_bayar.id=b_bayar_tindakan.bayar_id LEFT JOIN b_ms_kso kso ON b_tindakan_kamar.kso_id=kso.id WHERE b_bayar.user_act='".$rwNm['id']."' AND b_bayar_tindakan.tipe=1 AND b_bayar.tgl BETWEEN '".$tglAwal2."' AND '".$tglAkhir2."') AS t GROUP BY t.id,t.kso_id ORDER BY t.tgl,t.pasien";
						//echo $sqlPas."<br>";
						$rsPas = mysql_query($sqlPas);
						$no=1;
						$tot=0;
						$stot=0;
						while($rwPas = mysql_fetch_array($rsPas))
						{
				?>
				<tr valign="bottom">
					<td style="text-align:center;"><?php echo $no;?></td>
					<td style="text-align:center;"><?php echo $rwPas['tglBayar']; ?></td>
					<td style="text-align:center;"><?php echo $rwPas['nobukti']; ?></td>
					<td style="text-align:center;"><?php echo $rwPas['no_rm'];?></td>
					<td style="padding-left:5px; text-transform:uppercase;"><?php echo $rwPas['pasien'];?></td>
					<td align="center" valign="bottom"><?php echo $rwPas['kso'];?></td>
				    <td align="right"><?php echo number_format($rwPas['nilai'],0,",",".");?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				    <td>&nbsp;</td>
				</tr>
				<?php
						$no++;
						$stot = $stot + $rwPas['nilai'];
						}
				?>
				<tr>
					<td height="20" colspan="5" style="text-align:center; font-weight:bold; border-top:1px solid; border-bottom:1px solid;">SUB TOTAL</td>
					<td style="border-bottom:1px solid; border-top:1px solid;">&nbsp;</td>
				    <td align="right" style="border-bottom:1px solid; border-top:1px solid;"><?php echo number_format($stot,0,",","."); ?></td>
				</tr>
				<?php
							$tot = $tot + $stot;
						}
				?>
				<tr style="background-color:#FFFF99">
					<td height="25" colspan="5" style="text-align:center; font-weight:bold; border-top:1px solid; border-bottom:1px solid;">TOTAL</td>
					<td style="border-bottom:1px solid; border-top:1px solid;">&nbsp;</td>
				    <td align="right" style="border-bottom:1px solid; border-top:1px solid;"><?php echo number_format($tot,0,",","."); ?></td>
				</tr>
			</table>
	  </td>
	</tr>
	<tr>
		<td align="right">Tgl Cetak: <?=$date_now;?>&nbsp;Jam: <?=$jam;?></td>
	</tr>
	 <tr>
	<td align="right">Yang Mencetak</td>
  </tr>
  <tr>
  	<td  height="50">&nbsp;</td>
  </tr>
  <tr>
	<td align="right"><b><?php echo $rwPeg['nama'];?></b></td>
  </tr>
	<tr id="trTombol">
        <td class="noline" align="center">
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
</table>
</body>
<?php
	mysql_free_result($rsUnit1);
	mysql_free_result($rsPeg);
	mysql_free_result($rsKsr);
	mysql_close($konek);
?>
</html>
<script type="text/JavaScript">

/* try{	
formatF4();
}catch(e){
window.location='../../addon/jsprintsetup.xpi';
} */
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