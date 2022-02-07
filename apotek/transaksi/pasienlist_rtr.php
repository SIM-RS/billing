<?php 
	include("../koneksi/konek.php");
?>
	<style type="text/css">
		#pasienlist_penj td{
			padding:3px;
		}
	</style>
    <table id="pasienlist_penj" border="0" cellpadding="1" cellspacing="0">
		<tr>
			<th style="font-size:12px; background:#EAF0F0; border-top:1px solid #000; border-bottom:1px solid #000;" >Tgl. Jual</th>
			<th style="font-size:12px; background:#EAF0F0; border-top:1px solid #000; border-bottom:1px solid #000;" >No. Penjualan</th>
			<th style="font-size:12px; background:#EAF0F0; border-top:1px solid #000; border-bottom:1px solid #000;" >NoRM</th>
			<th style="font-size:12px; background:#EAF0F0; border-top:1px solid #000; border-bottom:1px solid #000;" >Nama Pasien</th>
			<th style="font-size:12px; background:#EAF0F0; border-top:1px solid #000; border-bottom:1px solid #000;" >Ruang</th>
		</tr>
    <?php 
		$aKeyword=$_REQUEST["aKeyword"];
		$aOpt=$_REQUEST["aOpt"];
		$idunit=$_REQUEST["idunit"];
		$no=$_REQUEST["no"];
		$tgl_d = $_REQUEST['tgl_d'];
		$tgl_s = $_REQUEST['tgl_s'];
		
		$tgl_dTmp = explode('-',$tgl_d);
		$tgl_sTmp = explode('-',$tgl_s);
		
		$tmp_tglD = $tgl_dTmp[2].'-'.$tgl_dTmp[1].'-'.$tgl_dTmp[0];
		$tmp_tglS = $tgl_sTmp[2].'-'.$tgl_sTmp[1].'-'.$tgl_sTmp[0];
		
		
		
		if ($aOpt=="1"){
		  
			$sql = "SELECT DATE_FORMAT(ap.TGL_ACT,'%d-%m-%Y %H:%i:%s') tgl_jual, ap.NO_PENJUALAN, ap.NAMA_PASIEN, 
					   ap.NO_PASIEN, ap.NO_KUNJUNGAN, u.UNIT_NAME, ap.KSO_ID, m.NAMA
					FROM a_penjualan ap
					left JOIN a_unit u
					   ON u.UNIT_ID = ap.RUANGAN
					left JOIN a_mitra m
					   ON m.IDMITRA = ap.KSO_ID
					WHERE ap.NAMA_PASIEN LIKE '{$aKeyword}%' 
					  AND ap.TGL_ACT BETWEEN '{$tmp_tglS} 00:00:00' AND '{$tmp_tglD} 23:59:59'
					  /* AND DATE_FORMAT(ap.TGL_ACT,'%d-%m-%Y') BETWEEN '{$tgl_s}' AND '{$tgl_d}' */
					  /*AND ap.UNIT_ID = '{$idunit}'*/
					GROUP BY ap.NO_PENJUALAN
					ORDER BY ap.TGL_ACT DESC";
		} else {
			
		$sql="SELECT *FROM a_penjualan ap WHERE ap.`NO_PASIEN`='$aKeyword' ORDER BY ap.id DESC LIMIT 1";
		$rs=mysqli_query($konek,$sql);
		$rs1=mysqli_fetch_array($rs);
	  	
			$sql = "SELECT DATE_FORMAT(ap.TGL_ACT,'%d-%m-%Y %H:%i:%s') tgl_jual, ap.NO_PENJUALAN, ap.NAMA_PASIEN, 
					   ap.NO_PASIEN, ap.NO_KUNJUNGAN, u.UNIT_NAME, ap.KSO_ID, m.NAMA
					FROM a_penjualan ap
					left JOIN a_unit u
					   ON u.UNIT_ID = ap.RUANGAN
					left JOIN a_mitra m
					   ON m.IDMITRA = ap.KSO_ID
					WHERE ap.NO_PASIEN = '{$aKeyword}'
					  AND ap.TGL_ACT BETWEEN '{$tmp_tglS} 00:00:00' AND '{$tmp_tglD} 23:59:59'
					 /* AND DATE_FORMAT(ap.TGL_ACT,'%d-%m-%Y') BETWEEN '{$tgl_s}' AND '{$tgl_d}' */
					 /* AND ap.UNIT_ID = '{$idunit}'*/
					GROUP BY ap.NO_PENJUALAN
					ORDER BY ap.TGL_ACT DESC";
		}
		//echo $sql;
		$rs=mysqli_query($konek,$sql);
		$arfvalue="";
		$i=0;
		while ($rows=mysqli_fetch_array($rs)){
			$i++;
			$arfvalue=$no."*|*".$rows['NAMA_PASIEN']."*|*".$rows['NO_PASIEN']."*|*".$rows['NO_KUNJUNGAN']."*|*".$rows['UNIT_NAME']."*|*".$rows['tgl_jual']."*|*".$rows['NO_PENJUALAN']."*|*".$rows['KSO_ID']."*|*".$rows['NAMA'];
			$arfvalue=str_replace('"',chr(3),$arfvalue);
			$arfvalue=str_replace("'",chr(5),$arfvalue);
			$namapas=$rows['NAMA_PASIEN'];
	?>
			<tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetObat(this.lang);">
				<td class="tdisikiri" width="80" align="center">&nbsp;<?php echo $rows['tgl_jual']; ?></td>
				<td class="tdisi" width="80" align="center">&nbsp;<?php echo $rows['NO_PENJUALAN']; ?></td>
				<td class="tdisi" width="80" align="center">&nbsp;<?php echo $rows['NO_PASIEN']; ?></td>
				<td class="tdisi" width="200" align="left"><?php echo $namapas; ?></td>
				<td class="tdisi" width="150" align="left"><?php echo ($rows['UNIT_NAME']!="")?$rows['UNIT_NAME']:"&nbsp;"; ?></td>
			</tr>
	<?php
		}
	?>	
	</table>
<?php 
	mysqli_close($konek);
?>