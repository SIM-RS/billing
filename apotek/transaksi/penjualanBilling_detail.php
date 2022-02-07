<?php
//include("../sesi.php");
	include("../koneksi/konek.php");
	$sql = "SELECT $dbapotek.a_unit.UNIT_NAME AS unit, DATE_FORMAT($dbbilling.b_resep.tgl,'%d-%m-%Y') AS tgl,
$dbapotek.a_kepemilikan.NAMA AS kepemilikan, $dbbilling.b_resep.no_rm, $dbbilling.b_resep.nama_pasien, $dbbilling.b_resep.alamat, $dbbilling.b_ms_unit.nama AS tempat
FROM $dbbilling.b_resep
INNER JOIN $dbapotek.a_unit ON $dbapotek.a_unit.UNIT_ID=$dbbilling.b_resep.apotek_id
INNER JOIN $dbapotek.a_kepemilikan ON $dbapotek.a_kepemilikan.ID=$dbbilling.b_resep.kepemilikan_id
INNER JOIN $dbbilling.b_pelayanan ON $dbbilling.b_pelayanan.id=$dbbilling.b_resep.id_pelayanan
INNER JOIN $dbbilling.b_ms_unit ON $dbbilling.b_pelayanan.unit_id=$dbbilling.b_ms_unit.id
WHERE $dbbilling.b_resep.no_resep='".$_REQUEST['no_resep']."'";
	$rs = mysqli_query($konek,$sql);
	$rw = mysqli_fetch_array($rs);
?>

<div align="center">
	<table width="950" border="0" cellpadding="0" cellspacing="0" align="center">
		<tr>
			<td height="30">&nbsp;</td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #999999; border-top:1px solid #999999; border-right:1px solid #999999; border-left:1px solid #999999;">
				<table width="40%" align="center" border="0" cellpadding="0" cellspacing="4" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">
					<tr>
						<td width="30%">Unit</td>
						<td width="10%" align="center">:</td>
						<td width="60%"><?php echo $rw['unit'];?></td>
					</tr>
					<tr>
						<td>Tanggal</td>
						<td align="center">:</td>
						<td><?php echo $rw['tgl'];?></td>
					</tr>
					<tr>
						<td>Kepemilikan</td>
						<td align="center">:</td>
						<td><?php echo $rw['kepemilikan'];?></td>
					</tr>
					<tr>
						<td>No RM</td>
						<td align="center">:</td>
						<td><?php echo $rw['no_rm'];?></td>
					</tr>
					<tr>
						<td>Nama</td>
						<td align="center">:</td>
						<td><?php echo $rw['nama_pasien'];?></td>
					</tr>
					<tr>
						<td>Alamat</td>
						<td align="center">:</td>
						<td><?php echo $rw['alamat'];?></td>
					</tr>
					<tr>
						<td>Tempat Layanan</td>
						<td align="center">:</td>
						<td><?php echo $rw['tempat'];?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td height="30">&nbsp;</td>
		</tr>
		<tr>
			<td>
				<table width="95%" border="0" cellpadding="0" cellspacing="0" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">
					<tr class="headtable">
						<td class="tblheaderkiri" width="3%">No</td>
						<td class="tblheader" width="8%">Kode<br />Obat</td>
						<td class="tblheader" width="30%">Nama Obat</td>
						<td class="tblheader" width="6%">Racikan</td>
						<td class="tblheader" width="8%">Stok</td>
						<td class="tblheader" width="10%">Harga Netto</td>
						<td class="tblheader" width="10%">Jumlah</td>
						<td class="tblheader" width="10%">Harga<br />Satuan</td>
						<td class="tblheader" width="10%">Subtotal</td>
						<td class="tblheader" width="5%">Proses</td>
					</tr>
					<?php
							$qObat = "SELECT t.OBAT_ID, t.OBAT_KODE, t.OBAT_NAMA, t.racikan, IF(t.jml IS NULL,0,t.jml) AS jml, t.harga_netto,
t.qty, t.harga_satuan, t.sub_total
FROM (SELECT $dbapotek.a_obat.OBAT_ID, $dbapotek.a_obat.OBAT_KODE, $dbapotek.a_obat.OBAT_NAMA, $dbbilling.b_resep.racikan,
(SELECT SUM(dp.QTY_STOK) FROM $dbapotek.a_penerimaan dp WHERE dp.OBAT_ID = $dbbilling.b_resep.obat_id AND dp.KEPEMILIKAN_ID='".$_REQUEST['kepemilikanId']."') AS jml,
$dbbilling.b_resep.harga_netto, $dbbilling.b_resep.qty, $dbbilling.b_resep.harga_satuan, $dbbilling.b_resep.sub_total
FROM $dbbilling.b_resep
INNER JOIN $dbapotek.a_obat ON $dbapotek.a_obat.OBAT_ID=$dbbilling.b_resep.obat_id
LEFT JOIN $dbapotek.a_penerimaan ON $dbapotek.a_penerimaan.OBAT_ID=$dbbilling.b_resep.obat_id
WHERE $dbbilling.b_resep.no_resep='".$_REQUEST['no_resep']."'
GROUP BY $dbbilling.b_resep.id) AS t";
							$sObat = mysqli_query($konek,$qObat);
							$i=1;
							while($wObat = mysqli_fetch_array($sObat)){
					?>
					<tr>
						<td class="tdisikiri" align="center"><?php echo $i;?></td>
						<td class="tdisi" align="center"><?php echo $wObat['OBAT_KODE'];?></td>
						<td class="tdisi" style="padding-left:5px;"><?php echo $wObat['OBAT_NAMA'];?></td>
						<td class="tdisi" align="center"><?php if($wObat['racikan']=='1') echo "&radic;"; else echo "-";?></td>
						<td class="tdisi" align="center"><?php echo $wObat['jml'];?></td>
						<td class="tdisi" align="right" style="padding-right:5px;"><?php echo number_format($wObat['harga_netto'],0,",",".");?></td>
						<td class="tdisi" align="center"><?php echo $wObat['qty'];?></td>
						<td class="tdisi" align="right" style="padding-right:5px;"><?php echo number_format($wObat['harga_satuan'],0,",",".");?></td>
						<td class="tdisi" align="right" style="padding-right:5px;"><?php echo number_format($wObat['sub_total'],0,",",".");?></td>
						<td class="tdisi" align="center"><input id="chx" name="chx" type="checkbox" /></td>
					</tr>
					<?php
							$i++;
							}
					?>
					<tr valign="bottom">
						<td colspan="7" height="30">&nbsp;</td>
						<td>TOTAL HARGA</td>
						<td align="right"><input id="total" name="total" size="8" style="background-color:#CCCCCC; border:none;" /></td>
						<td>&nbsp;</td>
					</tr>
					<tr valign="bottom">
						<td colspan="7" height="20">&nbsp;</td>
						<td>BAYAR</td>
						<td align="right"><input id="total" name="total" size="8" style="background-color:#CCCCCC; border:none;" /></td>
						<td>&nbsp;</td>
					</tr>
					<tr valign="bottom">
						<td colspan="7" height="20">&nbsp;</td>
						<td>KEMBALI</td>
						<td align="right"><input id="total" name="total" size="8" style="background-color:#CCCCCC; border:none;" /></td>
						<td>&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
	</table>
</div>