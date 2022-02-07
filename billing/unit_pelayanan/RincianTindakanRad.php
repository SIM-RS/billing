<?php
	include("../sesi.php");
	include("../koneksi/konek.php");
	$date_now=gmdate('d/m/Y',mktime(date('H')+7));
	$jam = date("G:i:s");
	$userId = $_REQUEST['idUser'];
	$idKunj=$_REQUEST['idKunj'];
	$jeniskasir=$_REQUEST['jenisKasir'];
	$idPel=$_REQUEST['idPel'];
	$idbayar=$_REQUEST['idbayar'];
	$tmpLay = $_REQUEST['tmpLay'];
	/*$sqlPeg = "SELECT p.id, p.nama FROM b_ms_pegawai p WHERE p.id = $userId";
	$rsPeg = mysql_query($sqlPeg);
	$rwPeg = mysql_fetch_array($rsPeg);*/
	$sql = "SELECT mp.nama FROM b_ms_pegawai mp WHERE mp.id = '$userId'";
	$rs = mysql_query($sql);
	$rows=mysql_fetch_array($rs);
	$kasir=$rows["nama"];
	$dibayar=0;
	$titipan=0;
	$keringanan=0;
	$jaminan=0;
	$sql = "SELECT b.* FROM b_bayar b WHERE b.id = '$idbayar'";
	$rs = mysql_query($sql);
	if (mysql_num_rows($rs)>0){
		$rows=mysql_fetch_array($rs);
		$dibayar=$rows["nilai"];
		$titipan=$rows["titipan"];
		$keringanan=$rows["keringanan"];
	}
	$idKasir = $_REQUEST['jenisKasir'];
	
	$qLb = "SELECT unit_id FROM b_pelayanan 
INNER JOIN b_ms_unit ON b_ms_unit.id = b_pelayanan.unit_id
WHERE b_pelayanan.kunjungan_id = '".$_REQUEST['idKunj']."' AND b_ms_unit.parent_id = '60'";
	$rsLb = mysql_query($qLb);
	$rwLb = mysql_fetch_array($rsLb);
	
	$nL = "SELECT pl.unit_id, pl.no_lab FROM b_pelayanan pl WHERE pl.kunjungan_id = '".$_REQUEST['idKunj']."' AND pl.unit_id = '".$rwLb['unit_id']."' AND pl.id = '".$idPel."'";
	$rsL = mysql_query($nL);
	$rwL = mysql_fetch_array($rsL);
	
	$qInp = "SELECT id, inap, nama FROM b_ms_unit WHERE nama LIKE '%$tmpLay'";
	$rsInp = mysql_query($qInp);
	$rwInp = mysql_fetch_array($rsInp);
?>
<title>Rincian Tindakan Lab</title>
<link type="text/css" rel="stylesheet" href="../theme/print.css">
 <script type="text/JavaScript" language="JavaScript" src="../theme/js/formatPrint.js"></script>
        <table width="580" border="0" cellpadding="0" cellspacing="2" align="left" style="font-family:Arial, Helvetica, sans-serif; font-size:11px;">
	<tr>
		<td width="67" height="30">&nbsp;</td>
		<td width="220">&nbsp;</td>
		<td width="86">&nbsp;</td>
		<td width="189">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" style="border-bottom:1px dashed;text-align:left;">
		<b>PEMERINTAH KABUPATEN SIDOARJO<br>
			Rumah Sakit Umum Daerah Kabupaten Sidoarjo<br>
			Jl. Mojopahit 667 Sidoarjo<br>
			Telepon (031) 896 1649		</b>		</td>
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
		<td style="border-bottom:1px dashed;">Tgl</td>
		<td style="border-bottom:1px dashed;">:&nbsp;<?php echo tglSQL($rw1['tgl']);?></td>
		<td style="border-bottom:1px dashed;">Status Ps</td>
		<td style="border-bottom:1px dashed; text-transform:uppercase">:&nbsp;<?php echo strtolower($rw1['STATUS']);?></td>
	</tr>
	<tr>
		<td colspan="4"><?php if($rwInp['inap']==1){
		?>
			<div id="Inap">
				<table width="580" border="0" cellpadding="0" cellspacing="0" style="font-size:11px; font-family:Arial, Helvetica, sans-serif">
				<tr>
					<td width="58" height="20" align="center" style="font-weight:bold; border-bottom:1px dashed">No</td>
					<td width="442" style="font-weight:bold; border-bottom:1px dashed">&nbsp;Tindakan</td>
					<td width="242" style="font-weight:bold; border-bottom:1px dashed; text-align:right; padding-right:20px">Biaya&nbsp;</td>
				</tr>
				<?php
						$qTgl = "SELECT DATE_FORMAT(t1.tgl,'%d-%m-%Y') AS tgl, t1.unit_id 
FROM (SELECT t.tgl, pl.unit_id FROM b_kunjungan k 
INNER JOIN b_pelayanan pl ON pl.kunjungan_id = k.id 
INNER JOIN b_tindakan t ON t.pelayanan_id = pl.id WHERE k.id = '".$_REQUEST['idKunj']."' 
GROUP BY t.tgl, pl.unit_id) AS t1 WHERE t1.unit_id = '".$rwLb['unit_id']."'";
						$rsTgl = mysql_query($qTgl);
						$jaminan=0;
						$dibayar=0;
						$kurang=0;
						while($rwTgl = mysql_fetch_array($rsTgl))
						{
				?>
				<tr>
				  <td colspan="3" style="padding-left:15px; font-weight:bold;" height="20" valign="bottom"><?php echo $rwTgl['tgl'];?></td>
				</tr>
				<?php
					$tgl = tglSQL($rwTgl['tgl']);
					$sql = "SELECT mt.id, mt.nama, (t.qty * t.biaya) as biaya,(t.qty * t.biaya_kso) as biaya_kso,(t.qty * t.biaya_pasien) - t.bayar_pasien as kurang,t.bayar_pasien FROM b_tindakan t
							INNER JOIN b_ms_tindakan_kelas mtk ON mtk.id = t.ms_tindakan_kelas_id
							INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id = mt.id
							WHERE t.kunjungan_id = '".$_REQUEST['idKunj']."' AND t.tgl = '".$tgl."' AND t.ms_tindakan_unit_id = '".$rwLb['unit_id']."'";
					//echo $sql."<br/>";
					$rs = mysql_query($sql);
					$tot = 0;
					$i = 1;
					while($row = mysql_fetch_array($rs)){
						$jaminan+=$row['biaya_kso'];
						$dibayar+=$row['bayar_pasien'];
						$kurang+=$row['kurang'];
				?>
				<tr>
					<td align="center"><?php echo $i?></td>
					<td style="text-transform:capitalize">&nbsp;<?php echo strtolower($row['nama']);?></td>
					<td style="padding-right:20px" align="right"><?php echo number_format($row['biaya'],0,",",".");?></td>
				</tr>
				<?php
						
						$i++;
						$tot = $tot + $row['biaya'];
						}
				?>
				 <tr>
				   <td colspan="2" align="right">Subtotal&nbsp;</td>
				   <td style="border-top:2px groove; padding-right:20px; text-align:right; font-weight:bold;"><?php echo number_format($tot,0,",",".");?></td>
			     </tr>
				<?php
						$total += $tot;
						}
				?>
				 <tr>
				 	<td style="border-top:2px groove;">&nbsp;</td>
					<td style="border-top:2px groove; font-weight:bold;" align="right">Jumlah Total&nbsp;</td>
					<td height="28" style="border-top:2px groove; padding-right:20px; text-align:right; font-weight:bold; font-weight:bold;"><?php echo number_format($total,0,",",".");?></td>
				 </tr>
                 <?php 
					if ($jaminan>0){
				 ?>
				 <tr>
				   <td>&nbsp;</td>
				   <td align="right">Dijamin KSO</td>
				   <td style="padding-right:20px; font-weight:bold;" align="right"><?php echo number_format($jaminan,0,",",".");?></td>
		         </tr>
				 <?php 
					}
				 ?>
				 <tr>
				   <td>&nbsp;</td>
				   <td align="right">Dibayar</td>
				   <td style="padding-right:20px" align="right"><b><?php echo number_format($dibayar,0,",",".");?></b></td>
		      	 </tr>
				 <tr>
				   <td>&nbsp;</td>
				   <td align="right">Kurang Bayar</td>
				   <td style="padding-right:20px" align="right"><b><?php echo number_format($kurang,0,",",".");?></b></td>
		      	 </tr>
				 <tr>
				 	<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				 </tr>
				</table>	
			</div>
		<?php
		}else{
			?>
			<div id="gakInap">
			<table width="580" border="0" cellpadding="0" cellspacing="0" style="font-size:11px; font-family:Arial, Helvetica, sans-serif">
				<tr>
					<td width="58" height="20" align="center" style="font-weight:bold; border-bottom:1px dashed">No</td>
					<td width="442" style="font-weight:bold; border-bottom:1px dashed">&nbsp;Tindakan</td>
					<td width="242" style="font-weight:bold; border-bottom:1px dashed; text-align:right; padding-right:20px">Biaya&nbsp;</td>
				</tr>
				<?php
				
					$sql = "SELECT mt.id, mt.nama, (t.qty * t.biaya) as biaya,(t.qty * t.biaya_kso) as biaya_kso,(t.qty * t.biaya_pasien) - t.bayar_pasien as kurang,t.bayar_pasien FROM b_tindakan t
							INNER JOIN b_ms_tindakan_kelas mtk ON mtk.id = t.ms_tindakan_kelas_id
							INNER JOIN b_ms_tindakan mt ON mtk.ms_tindakan_id = mt.id
							WHERE t.kunjungan_id = '".$_REQUEST['idKunj']."' AND t.pelayanan_id = '".$idPel."' AND t.ms_tindakan_unit_id = '".$rwLb['unit_id']."'";
					//echo $sql."<br/>";
					$rs = mysql_query($sql);
					$tot = 0;
					$i = 1;
					$jaminan=0;
					$dibayar=0;
					$kurang=0;
					while($row = mysql_fetch_array($rs)){
						$jaminan+=$row['biaya_kso'];
						$dibayar+=$row['bayar_pasien'];
						$kurang+=$row['kurang'];
				?>
				<tr>
					<td align="center"><?php echo $i?></td>
					<td style="text-transform:capitalize">&nbsp;<?php echo strtolower($row['nama']);?></td>
					<td style="padding-right:20px" align="right"><?php echo number_format($row['biaya'],0,",",".");?>&nbsp;</td>
				</tr>
				<?php
						$i++;$tot = $tot + $row['biaya'];
						}
				?>
				 <tr>
				 	<td style="border-top:2px groove;">&nbsp;</td>
					<td style="border-top:2px groove;" align="right">Jumlah Total&nbsp;</td>
					<td style="border-top:2px groove; padding-right:20px" align="right"><b><?php echo number_format($tot,0,",",".");?></b>&nbsp;</td>
				 </tr>
                 <?php 
					if ($jaminan>0){
				 ?>
				 <tr>
				   <td>&nbsp;</td>
				   <td align="right">Dijamin KSO</td>
				   <td style="padding-right:20px" align="right"><b><?php echo number_format($jaminan,0,",",".");?></b></td>
		         </tr>
				 <?php 
					}
				 ?>
				 <tr>
				   <td>&nbsp;</td>
				   <td align="right">Dibayar</td>
				   <td style="padding-right:20px" align="right"><b><?php echo number_format($dibayar,0,",",".");?></b></td>
		      </tr>
				 <tr>
				   <td>&nbsp;</td>
				   <td align="right">Kurang Bayar</td>
				   <td style="padding-right:20px" align="right"><b><?php echo number_format($kurang,0,",",".");?></b></td>
		      </tr>
				 <tr>
				 	<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				 </tr>
			</table>	
			</div>	
			<?php
			
			}?></td>
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
		<td colspan="2" align="center" style="padding-right:50px; text-align:center">Kasir</td>
	</tr>
	<tr>
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