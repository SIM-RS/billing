<?php
	include '../sesi.php';
	include("../koneksi/konek.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	
	$supplier = $_REQUEST['supplier'];
	$noPo = $_REQUEST['noPo'];
?>
<title>.: Kwitansi Pembayaran :.</title>
<table width="700" border="0" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">
	<tr>
		<td colspan="2" style="text-align:center; font-weight:bold; font-size:14px" height="30" valign="top">KWITANSI PEMBAYARAN</td>
	</tr>
	<tr style="visibility:hidden">
		<td width="30%" style="padding-left:40px;">&nbsp;NOMOR</td>
		<td width="70%">:&nbsp;</td>
	</tr>
	<tr>
		<td style="padding-left:40px;">&nbsp;TERIMA DARI</td>
		<td>:&nbsp;<b><?=$namaRS;?></b></td>
	</tr>
	<tr style=" display:none">
		<td style="padding-left:40px;">&nbsp;JUMLAH UANG</td>
		<td>:&nbsp;</td>
	</tr>
	<tr>
		<td style="padding-left:40px;">&nbsp;UNTUK</td>
		<td style="text-transform:uppercase">:&nbsp;PEMBAYARAN KEPADA <b><?php echo $supplier?></b></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="88%" border="1" cellpadding="0" cellspacing="0" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:11px; border-collapse:collapse;">
				<tr bgcolor="#CCCCCC" style="text-align:center; font-weight:bold;">
					<td width="20%" height="30">NO PO</td>
					<td width="20%">TGL PO</td>
					<td width="25%">NO FAKTUR</td>
					<td width="20%">TGL FAKTUR</td>
					<td width="15%">NILAI</td>
				</tr>
				<?php
					$sql = "SELECT as_po.no_po, DATE_FORMAT(as_po.tgl_po, '%d-%m-%Y') AS tglPo, as_masuk.no_faktur, 
							DATE_FORMAT(as_masuk.tgl_faktur, '%d-%m-%Y') AS tglFaktur, as_masuk.jml_msk, as_masuk.harga_unit, 
							as_masuk.jml_msk*as_masuk.harga_unit AS nilai 
							FROM as_masuk INNER JOIN as_po ON as_po.id = as_masuk.po_id 
							WHERE as_po.no_po = '".$noPo."' Group by tgl_po,no_po,tgl_terima,no_gudang";
					$rs = mysql_query($sql);
					$jml = 0;
					while($rw = mysql_fetch_array($rs))
					{
				?>
				<tr>
					<td height="20" style=" text-align:center;"><?php echo $rw['no_po'];?></td>
					<td style=" text-align:center;"><?php echo $rw['tglPo'];?></td>
					<td style=" text-align:center;"><?php echo $rw['no_faktur'];?></td>
					<td style=" text-align:center;"><?php echo $rw['tglFaktur'];?></td>
					<td style="text-align:right; padding-right:10px;"><?php echo number_format($rw['nilai'],0,",",".");?></td>
				</tr>
				<?php 
						$jml = $jml + $rw['nilai'];
						} 
				?>
				<tr>
					<td colspan="5" style="text-align:right; padding-right:10px;" height="25" ><?php echo number_format($jml,0,",",".")?></td>
				</tr>
		  </table>		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td valign="middle" align="right">&nbsp;<input size="21" style="text-align:right; font-size:12px; font-weight:bold; background-color:#CCFFFF; border:1px solid #00FFFF; height:30" value="Rp. <?php echo number_format($jml,0,",",".");?>" readonly="readonly" ></td>
		<td style="text-align:right; padding-right:50px;" height="70" valign="top"><?=$kotaRS;?>, <? echo date("d-m-Y");?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td style="text-align:right; padding-right:50px;"><input style="border:0; border-bottom:1px solid;" size="30px;"></td>
	</tr>
	<tr id="trTombol">
        <td class="noline" align="center" height="30" colspan="2">
            <input id="btnPrint" type="button" value="Print/Cetak" onClick="cetak(document.getElementById('trTombol'));"/>
            <input id="btnTutup" type="button" value="Tutup" onClick="window.close();"/>        </td>
    </tr>
</table>
<script>
function cetak(tombol){
        tombol.style.visibility='hidden';
        if(tombol.style.visibility=='hidden'){
		window.print();
		window.close();
        }
    }
</script>