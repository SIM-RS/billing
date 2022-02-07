<?php
	include("../sesi.php");
	include("../koneksi/konek.php");
	$date_now=gmdate('d/m/Y',mktime(date('H')+7));
	$jam = date("G:i:s");
	$userId = $_REQUEST['idUser'];
	$idKunj=$_REQUEST['idKunj'];
	$idPel=$_REQUEST['idPel'];
	
	$sql = "SELECT mp.nama FROM b_ms_pegawai mp WHERE mp.id = '$userId'";
	$rs = mysql_query($sql);
	$rows=mysql_fetch_array($rs);
	$kasir=$rows["nama"];
	
	$nL = "SELECT pl.no_lab,mu.nama as unit FROM b_pelayanan pl inner join b_ms_unit mu on mu.id=pl.unit_id WHERE pl.id = '".$idPel."' and mu.parent_id in (57) ";
	$rsL = mysql_query($nL);
	$rwL = mysql_fetch_array($rsL);
	
	$nUnit = "SELECT mu.nama as unit FROM b_pelayanan pl inner join b_ms_unit mu on mu.id=pl.unit_id WHERE pl.id = '".$idPel."'";
	$rsUnit = mysql_query($nUnit);
	$rwUnit = mysql_fetch_array($rsUnit);
	$txtUnit = $rwUnit['unit']; 
?>
<title>Rincian Tindakan Lab</title>
<link type="text/css" rel="stylesheet" href="../theme/print.css">
 <script type="text/JavaScript" language="JavaScript" src="../theme/js/formatPrint.js"></script>
        <table width="700" border="0" cellpadding="0" cellspacing="2" align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
	<tr>
		<td width="115" height="30">&nbsp;</td>
		<td width="392">&nbsp;</td>
		<td width="61">&nbsp;</td>
		<td width="126">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" style="border-bottom:1px dashed;text-align:left;">
		<b><!--PEMERINTAH KABUPATEN SIDOARJO<br>-->
			<?=$namaRS?><br>
			<?php echo strtoupper($alamatRS." ".$kotaRS);?><br>
			Telepon <?php echo strtoupper($tlpRS);?></b>		</td>
		<td valign="bottom" style="text-align:right; padding-right:20px; font-size:26px; font-weight:bold; border-bottom:1px dashed;"><?php echo $rwL['no_lab'];?>&nbsp;</td>
	</tr>
	<?php
		$sql1 = "SELECT p.no_rm, k.no_billing, p.nama, p.alamat, k.unit_id, u.nama AS namaunit, k.tgl, k.kso_id, kso.nama AS STATUS, k.id,
p.id AS pasien_id, pl.no_lab
FROM b_ms_pasien p
INNER JOIN b_kunjungan k ON k.pasien_id = p.id
INNER JOIN b_ms_unit u ON u.id = k.unit_id
INNER JOIN b_ms_kso kso ON kso.id = k.kso_id
INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id
WHERE k.id = '".$_REQUEST['idKunj']."'";
		$rs1 = mysql_query($sql1);
		$rw1 = mysql_fetch_array($rs1);
		$ksoid=$rw1['kso_id'];
		//$nL = "SELECT no_lab FROM b_pelayanan WHERE pasien_id = '".$rw1['pasien_id']."' AND jenis_layanan = '".$idKasir."'";
	?>
	<tr>
		<td>NRM</td>
		<td style="font-weight:bold;">:&nbsp;<?php echo $rw1['no_rm'];?></td>
		<td>No. Billing</td>
		<td>:&nbsp;<?php echo $rw1['no_billing'];?></td>
	</tr>
	<tr>
		<td>Nama</td>
		<td colspan="3" style="text-transform:uppercase; font-weight:bold">:&nbsp;<?php echo strtolower($rw1['nama']);?></td>
	    </tr>
	<tr>
		<td>Alamat</td>
		<td colspan="3" style="text-transform:capitalize">:&nbsp;<?php echo strtolower($rw1['alamat']);?></td>
	</tr>
	<tr>
		<td>Kunjungan</td>
		<td colspan="2" style="text-transform:capitalize">:&nbsp;<?php echo strtolower($rw1['namaunit']);?></td>
		<td>&nbsp;</td>
	</tr>
    <tr>
		<td>Tempat Layanan</td>
		<td colspan="2" style="text-transform:capitalize">:&nbsp;<?php echo $txtUnit;?></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="border-bottom:1px dashed;">Tgl</td>
		<td style="border-bottom:1px dashed;">:&nbsp;<?php echo tglSQL($rw1['tgl']);?></td>
		<td style="border-bottom:1px dashed;">Status Ps</td>
		<td style="border-bottom:1px dashed; text-transform:uppercase">:&nbsp;<?php echo strtolower($rw1['STATUS']);?></td>
	</tr>
	<tr>
		<td colspan="4">
			<div id="gakInap">
			<table width="700" border="0" cellpadding="0" cellspacing="0" style="font-size:12px; font-family:Arial, Helvetica, sans-serif">
				<tr>
					<td width="44" height="20" align="center" style="font-weight:bold; border-bottom:1px dashed">No</td>
					<td width="354" style="font-weight:bold; border-bottom:1px dashed">&nbsp;Tindakan</td>
					<td width="114" style="font-weight:bold; border-bottom:1px dashed; text-align:center;">Tanggal</td>
					<td width="188" style="font-weight:bold; border-bottom:1px dashed; text-align:right; padding-right:20px">Biaya&nbsp;</td>
				</tr>
				<?php
				
					$sql = "SELECT 
							mt.id, 
							mt.nama, 
							DATE_FORMAT(t.tgl,'%d-%m-%Y') as tgl,
							(t.qty * t.biaya) as biaya
							FROM b_tindakan t
							INNER JOIN b_ms_tindakan_kelas mtk ON mtk.id = t.ms_tindakan_kelas_id
							INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id = mt.id
							WHERE 
							t.pelayanan_id = '".$idPel."'";
					//echo $sql."<br/>";
					$rs = mysql_query($sql);
					$tot = 0;
					$i = 1;
					while($row = mysql_fetch_array($rs)){
				?>
				<tr>
					<td align="center"><?php echo $i?></td>
					<td style="text-transform:capitalize">&nbsp;<?php echo strtolower($row['nama']);?></td>
					<td style="" align="center"><?php echo $row['tgl'];?></td>
					<td style="padding-right:20px" align="right"><?php echo number_format($row['biaya'],0,",",".");?>&nbsp;</td>
				</tr>
				<?php
						$i++;$tot = $tot + $row['biaya'];
						}
				?>
				 <tr>
				 	<td style="border-top:2px groove;">&nbsp;</td>
					<td style="border-top:2px groove;" align="right">Jumlah Total&nbsp;</td>
					<td style="border-top:2px groove; padding-right:20px" align="right">&nbsp;</td>
					<td style="border-top:2px groove; padding-right:20px" align="right"><b><?php echo number_format($tot,0,",",".");?></b>&nbsp;</td>
				 </tr>
                 <tr>
				 	<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				 </tr>
			</table>	
			</div>	
			</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td colspan="2" style="padding-right:50px; text-align:center;">Sidoarjo,&nbsp;&nbsp;<?php echo $date_now;?></td>
	</tr>
	<tr>
		<td height="20">&nbsp;</td>
		<td>&nbsp;</td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td colspan="2" style="padding-right:50px; text-align:center">(<?php echo $kasir; ?>)</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td colspan="2" align="center" style="padding-right:50px; text-align:center">Petugas</td>
	</tr>
	<tr style="display:none;">
		<td colspan="4" style="font-weight:bold;" height="30" valign="bottom" align="center">"Bukti pembayaran ini juga berlaku sebagai kuitansi"</td>
	</tr>
    <tr id="trTombol">
        <td colspan="4" class="noline" align="center">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
    </tr>
</table>
<script type="text/JavaScript">
	/* try{
	formatKuitansi();
	}catch(e){
	window.location='../addon/jsprintsetup.xpi';
	} */
	
    function cetak(tombol){
        tombol.style.visibility='collapse';
        if(tombol.style.visibility=='collapse'){    
		try{
			mulaiPrint();
		}
		catch(e){
			window.print();
		}
		
	}
    }
</script>
<?php 
mysql_close($konek);
?>