<?php 
include '../sesi.php';
include("../koneksi/konek.php");
	$aKepemilikan=$_REQUEST["aKepemilikan"];
	  $aKeyword=$_REQUEST["aKeyword"];
	  $idunit=$_REQUEST["idunit"];
	  $no=$_REQUEST["no"];
	  $act = $_REQUEST["act"];
	  /* if($act == 'add'){
		$klik = 'set_barang_add(this.lang)';
	  } elseif($act == 'edit') {
		$klik = 'set_barang_edit(this.lang)';
	  } */
	  
	  $klik = 'set_barang_add(this.lang)';
	  //$aKeyword = str_replace(' ','%20',$aKeyword);
	  //$par = $aKeyword.'|'.$no;
?>

    <!--table id="tipeTabel" border="1" width="736" cellpadding="1" cellspacing="0" style="border-collapse:collapse; border:1px solid;">
	<tr>
		<td style="padding-top:10px; padding-bottom:10px; padding-left:10px;">
			Tipe : 
			<select name="tipe" id="tipe" onChange="ambilData(this.value,'<?php echo $par; ?>')">
				<option value="0">Semua</option>
				<option value="1">Inventaris</option>
				<option value="2">Pakai Habis</option>
			</select>
		</td>
	</tr>
	</table-->
	<table id="tblObat" border="" width="736" cellpadding="1" cellspacing="0" style="border-collapse:collapse; border:1px solid;">
		<tr height="20" style="background:#336699; color:#FFFFFF; font-weight:bold;">
    	<td width="28" height="25">No</td>
    	<td align="center">Kode Barang</td>
        <td align="center">Nama Barang</td>
        <td width="188" align="center">Kelompok</td>
        <td align="center">Satuan</td>
        <td align="center">Harga Terakhir </td>
    </tr>
      <?php 
	  //$sql="SELECT idbarang,kodebarang,namabarang,idsatuan,left(kodebarang,2) kodegolongan FROM as_ms_barang WHERE TRIM(namabarang) LIKE '%$aKeyword%' AND islast=1 ORDER BY kodebarang";
	  if($tipe!=0){
		$tipeL = "AND tipe = ".$tipe;
	  } else {
		$tipeL = '';
	  }
	  $sql = "SELECT a.tipe, a.idbarang,a.kodebarang,a.namabarang,a.idsatuan,LEFT(a.kodebarang,2) kodegolongan,b.harga_unit FROM as_ms_barang AS a 
  LEFT JOIN(SELECT * FROM (SELECT barang_id,harga_unit FROM as_masuk ORDER BY msk_id DESC) AS xx GROUP BY xx.barang_id)AS b ON b.barang_id=a.`idbarang`
  WHERE TRIM(a.namabarang) LIKE '%".trim($aKeyword)."%' AND a.islast=1 {$tipeL} ORDER BY a.kodebarang";
      //echo $sql;
	  $rs=mysql_query($sql);
	  $arfvalue="";
	  $i=0;
	  while ($rows=mysql_fetch_array($rs))
	  {
		$arfvalue=$no."|".$rows['idbarang']."|".$rows['kodebarang']."|".$rows['namabarang']."|".$rows['idsatuan']."|".$rows['harga_unit'];

			$nama=$i.".&nbsp;".$rows['nama'];
			
			
	  	$i++;
		$sql1="SELECT namabarang FROM as_ms_barang WHERE kodebarang LIKE '$rows[kodegolongan]%' and tipe = '$rows[tipe]' LIMIT 1";
		$r=mysql_query($sql1);
		while($ro=mysql_fetch_array($r))
		{
			$d=$ro[0];
		}
	  ?>
	<tr id="row_<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="<?php echo $klik; ?>" height="20">
      	<td class="tdisikiri"><?=$i?></td>
        <td class="tdisi" width="105" align="left"><?php echo $rows['kodebarang']; ?></td>
     	<td class="tdisi" width="231" align="left"><?php echo $rows['namabarang']; ?></td>
        <td class="tdisi" align="left"><?=$d?></td>
      	<td class="tdisi" width="174" align="left"><?php echo $rows['idsatuan']; ?></td>
        <td class="tdisi" width="174" align="right"><?php echo number_format($rows['harga_unit'],2,',','.'); ?></td>
	</tr>
		<?php
		//$no++;
		}
		?>	
	</table>
<?php 
mysql_close($konek);
?>