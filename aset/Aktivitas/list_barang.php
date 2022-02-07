<?php 
include '../sesi.php';
include("../koneksi/konek.php");
?>
    <table id="tblObat" border="1" width="736" cellpadding="1" cellspacing="0" style="border-collapse:collapse; border:1px solid;">
    <tr height="20" style="background: #6699CC; color:#FFFFFF; font-weight:bold;">
    	<td width="28">No</td>
    	<td align="center">Kode Barang</td>
        <td align="center">Nama Barang</td>
        <td width="188" align="center">Kelompok</td>
        <td align="center">Satuan</td>
    </tr>
      <?php 
	  $aKepemilikan=$_REQUEST["aKepemilikan"];
	  $aKeyword=$_REQUEST["aKeyword"];
	  $idunit=$_REQUEST["idunit"];
	  $no=$_REQUEST["no"];
	  $cmb=$_REQUEST['cmb'];
	  $sql="SELECT idbarang,kodebarang,namabarang,idsatuan,left(kodebarang,2) kodegolongan FROM as_ms_barang WHERE tipe='$cmb' AND TRIM(namabarang) LIKE '%$aKeyword%' AND islast=1 ORDER BY kodebarang";
	  //$sql="SELECT id,kode,nama FROM ask_ms_dc_planning WHERE trim(nama) like '$aKeyword%' ORDER BY nama";
	  $rs=mysql_query($sql);
	  $arfvalue="";
	  $i=0;
	  while ($rows=mysql_fetch_array($rs)){
		$arfvalue=$no."|".$rows['idbarang']."|".$rows['kodebarang']."|".$rows['namabarang']."|".$rows['idsatuan'];

			$nama=$i.".&nbsp;".$rows['nama'];
			
	  	$i++;
		$sql1="SELECT namabarang FROM as_ms_barang WHERE kodebarang LIKE '$rows[kodegolongan]%' LIMIT 1";
		$r=mysql_query($sql1);
		while($ro=mysql_fetch_array($r)){
			$d=$ro[0];
			}
	  ?>
      <tr id="list_<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="ValNamaBag(this.lang);" height="20">
      	<td class="tdisikiri"><?=$i?></td>
        <td class="tdisi" width="105" align="left"><?php echo $rows['kodebarang']; ?></td>
     	<td class="tdisi" width="231" align="left"><?php echo $rows['namabarang']; ?></td>
        <td class="tdisi" align="left"><?=$d?></td>
      	<td class="tdisi" width="174" align="left"><?php echo $rows['idsatuan']; ?></td>
      </tr>
		<?php
		}
		?>	
	</table>
<?php 
mysql_close($konek);
?>