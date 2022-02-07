<?php 
	include("../koneksi/konek.php");
	function tglSql_($val){
		$tglTmp = explode('-',$val);
		$tgl = $tglTmp[2]."-".$tglTmp[1]."-".$tglTmp[0];
		
		return $tgl;
	}
	
	    $tgl_d = $_REQUEST['tgl_d'];
		$tgl_s = $_REQUEST['tgl_s'];
		
		$tgl_dTmp = explode('-',$tgl_d);
		$tgl_sTmp = explode('-',$tgl_s);
		
		$tmp_tglD = $tgl_dTmp[2].'-'.$tgl_dTmp[1].'-'.$tgl_dTmp[0];
		$tmp_tglS = $tgl_sTmp[2].'-'.$tgl_sTmp[1].'-'.$tgl_sTmp[0];
?>


	<style type="text/css">
		#pasienlist_penj{
			border-collapse:collapse;
		}
		#pasienlist_penj td{
			padding:3px;
		}
		#pasienlist_penj th{
			background:#009900;
			font-size:12px;
			border:1px solid #000;
			b
		
		}
	</style>
    
    <table id="pasienlist_penj" border="0" cellpadding="1" cellspacing="0">
		<tr >
			<th>No. Penjualan</th>
			<th>Tgl. Penjualan</th>
			<th>NoRM</th>
			<th>KSO</th>
			<th>Nama Px</th>
			<th>Ruangan</th>
			<th>Nilai Jual</th>
			<th>Nilai Retur</th>
			<th>Total</th>
            <th><input type="checkbox" name="chkAll" id="chkAll" class="chkAll" onClick="klikAll(this.checked)" title="Pilih Semua"></th>
		</tr>
    <?php 
		$aKeyword=$_REQUEST["aKeyword"];
		$idunit=$_REQUEST["idunit"];
		$opt=$_REQUEST["opt"];
		if($opt==1){
			$sql="SELECT *FROM a_penjualan ap WHERE ap.`NO_PASIEN`='$aKeyword' ORDER BY ap.id DESC LIMIT 1";
			$rs=mysqli_query($konek,$sql);
			$rs1=mysqli_fetch_array($rs);
			$where = " ap.NO_PASIEN = '{$aKeyword}'";
			
		}elseif($opt==2){
			$where = " ap.NAMA_PASIEN like '%{$aKeyword}%' ";
		}else{
			$where = " ap.NO_PENJUALAN = '{$aKeyword}' ";
		}

		
		$sql = "SELECT ap.NO_PENJUALAN, ap.NO_PASIEN, ap.NAMA_PASIEN,
		
		SUM(ap.QTY_RETUR*ap.HARGA_SATUAN) + FLOOR((ap.PPN/100) * SUM(ap.QTY_RETUR* ap.HARGA_SATUAN)) retur, 
		
		
		(ap.HARGA_TOTAL) + 
		FLOOR((ap.PPN/100) * SUM(ap.QTY_JUAL* ap.HARGA_SATUAN)) HARGA_TOTAL,
		
		
		 ap.CARA_BAYAR, u.UNIT_NAME, ap.NO_KUNJUNGAN,ap.UNIT_ID,am.NAMA as MITRA,ap.KSO_ID,
					DATE_FORMAT(ap.TGL_ACT, '%d-%m-%Y %H:%i:%s') tgl_act, DATE(ap.TGL_ACT) tgl_jual
				FROM a_penjualan ap
				left JOIN a_unit u
				   ON u.UNIT_ID = ap.RUANGAN
				/*INNER JOIN a_penerimaan apen ON ap.`PENERIMAAN_ID`=apen.`ID`*/
				left Join a_mitra am on ap.KSO_ID=am.IDMITRA
				WHERE $where
					
				  /*AND ap.UNIT_ID = '{$idunit}'*/
				  AND ap.CARA_BAYAR IN (2,4)
				  AND (ap.SUDAH_BAYAR = 0
				   OR ap.NO_PENJUALAN NOT IN (SELECT FK_NO_PENJUALAN FROM a_kredit_utang))
				  /* AND ap.KRONIS = 0 */
				  AND ap.SUDAH_BAYAR = 0
				  AND ap.DIJAMIN = 0
				  /*AND ap.TGL_ACT BETWEEN '{$tmp_tglS} 00:00:00' AND '{$tmp_tglD} 23:59:59'*/
				GROUP BY ap.NO_PENJUALAN";
				
		//echo $sql;
		$rs=mysqli_query($konek,$sql);
		$arfvalue="";
		$i=0;
		while ($rows=mysqli_fetch_array($rs)){
			$i++;
			$arfvalue=$rows['NO_PENJUALAN']."*|*".$rows['NAMA_PASIEN']."*|*".$rows['NO_PASIEN']."*|*".$rows['NO_KUNJUNGAN']."*|*".$rows['UNIT_NAME']."*|*".tglSql_($rows['tgl_jual'])."*|*".$rows['UNIT_ID']."*|*".$rows['tgl_jual'];
			$arfvalue=str_replace('"',chr(3),$arfvalue);
			$arfvalue=str_replace("'",chr(5),$arfvalue);
			$namapas=$rows['NAMA_PASIEN'];
			$cnamapas=str_replace("'",chr(5),$namapas);
	
	?>
    
    
    
			<tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'"  ><!--onClick="fSetObat(this.lang);"-->
				<td class="tdisikiri" width="80" align="center" bgcolor="#99FF00">&nbsp;<?php echo $rows['NO_PENJUALAN']; ?></td>
				<td class="tdisi" width="100" align="center" bgcolor="#CCFF33">&nbsp;<?php echo $rows['tgl_act']; ?></td>
				<td class="tdisi" width="80" align="center" bgcolor="#CCFF33"><?php echo $rows['NO_PASIEN']; ?></td>
				<td class="tdisi" width="80" align="center" bgcolor="#CCFF33"><?php echo $rows['MITRA']; ?></td>
				<td class="tdisi" width="200" align="left" bgcolor="#CCFF33"><?php echo $namapas; ?></td>
				<td class="tdisi" width="100" align="left" bgcolor="#CCFF33"><?php echo $rows['UNIT_NAME']; ?></td>
				<td class="tdisi" width="100" align="right" bgcolor="#CCFF33"><?php echo $rows['HARGA_TOTAL']; ?></td>
				<td class="tdisi" width="100" align="right" bgcolor="#CCFF33"><?php echo $rows['retur']; ?></td>
				<td class="tdisi" width="100" align="right" bgcolor="#CCFF33"><?php echo ($rows['HARGA_TOTAL']-$rows['retur']); ?></td>
                <td class="tdisi" width="100" align="center" bgcolor="#CCFF33">
                
                <input name="chk" id="chk" type="checkbox" class="chk" value="<?php echo $rows['NO_PENJUALAN']; ?>" 
                onclick="list_pen(this.checked,'<?php echo $rows['NO_PENJUALAN']; ?>','<?php echo $rows['NO_PASIEN']; ?>',<?php echo ($rows['HARGA_TOTAL']-$rows['retur']); ?>,'<?php echo $cnamapas; ?>','<?php echo $rows['UNIT_ID']; ?>','<?php echo $rows['KSO_ID']; ?>','<?php echo $rows['tgl_jual']; ?>')"
                >
                </td>
			</tr>
	<?php
		}
		if($i == 0){
			echo "Tidak Ada Data Penjualan Pasien Tersebut!";
		}
	?>	
	</table>
   <br>
    <div align="right" style="padding-right:10px;"><button id="c_penjualan" type="submit" value="" onClick="divnone()" style="font-size:18px">&nbsp;&nbsp;PILIH&nbsp;&nbsp; </button>
    <!-- <input type="text" class="inputan" name="nilai" id="nilai" value="0" align="right"></input>-->
    </div>

<?php 
	mysqli_close($konek);
?>

<script language="JavaScript" type="text/JavaScript">



</script>