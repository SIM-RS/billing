<?php 
include '../sesi.php';
include("../koneksi/konek.php");
?>
    <table id="tblObat" border="1" bordercolor="#333333" width="718" cellpadding="1" cellspacing="0" style="border-collapse:collapse; border:1px solid;">
    <tr height="20" style="background:#6699CC; color:#FFFFFF; font-weight:bold;">
    	<td width="28" align="center">No</td>
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
	  $sql="SELECT
  idbarang,
  kodebarang,
  namabarang,
  idsatuan,
  LEVEL,
  left(kodebarang,2) kodegolongan,
  islast,
  IFNULL(sisa,0) AS sisa
FROM as_ms_barang
  LEFT JOIN (SELECT
               barang_id,
               SUM(sisa)   AS sisa
             FROM as_masuk
             WHERE sisa > 0
             GROUP BY barang_id) t1
    ON t1.barang_id = idbarang
WHERE isbrg_aktif = 1 AND islast = 1 AND TRIM(namabarang) LIKE '%$aKeyword%' AND tipe='$cmb' ORDER BY kodebarang";
	  //$sql="SELECT id,kode,nama FROM ask_ms_dc_planning WHERE trim(nama) like '$aKeyword%' ORDER BY nama";
	  $rs=mysql_query($sql);
	  $arfvalue="";
	  $i=0;
	  while ($rows=mysql_fetch_array($rs)){
		$stok=$rows['sisa'];
		$arfvalue=$no."|".$rows['idbarang']."|".$rows['kodebarang']."|".$rows['namabarang']."|".$rows['idsatuan']."|".$stok;

			$nama=$i.".&nbsp;".$rows['nama'];
			
	  	$i++;
		$sql1="SELECT namabarang FROM as_ms_barang WHERE kodebarang LIKE '$rows[kodegolongan]%' and tipe='$cmb' LIMIT 1";
		$r=mysql_query($sql1);
		while($ro=mysql_fetch_array($r)){
			$d=$ro[0];
			}
	  ?>
      <tr id="list_<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="ValNamaBag(this.lang);" height="20">
      	<td class="tdisikiri"><?php echo $i; ?></td>
        <td class="tdisi" width="105" align="left"><?php echo $rows['kodebarang']; ?></td>
     	<td class="tdisi" width="231" align="left"><?php echo $rows['namabarang']; ?></td>
        <td class="tdisi" align="left"><?php echo $d; ?></td>
      	<td class="tdisi" width="156" align="left"><?php echo $rows['idsatuan']; ?></td>
      </tr>
		<?php
		}
		?>	
</table>
<?php 
mysql_close($konek);
?>