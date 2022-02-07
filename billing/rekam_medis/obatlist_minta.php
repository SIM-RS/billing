<?php 
include("../sesi.php");
include("../koneksi/konek.php");
?>
    <table id="tblObat" border="0" cellpadding="1" cellspacing="0">
      <?php 
	  $aKepemilikan=$_REQUEST["aKepemilikan"];
	  $aKeyword=trim($_REQUEST["aKeyword"]);
	  $idunit=$_REQUEST["idunit"];
	  $no=$_REQUEST["no"];
	  //echo $no."<br>";
	  //$sql="select ao.*,(ah.HARGA_BELI_SATUAN*ah.PROFIT/100)+ah.HARGA_BELI_SATUAN as harga_jual from a_obat ao left join a_pabrik ap on ao.PABRIK_ID=ap.PABRIK_ID inner join a_harga ah on ao.OBAT_ID=ah.OBAT_ID where ah.KEPEMILIKAN_ID=$aKepemilikan and ao.OBAT_ISAKTIF=1 and ao.OBAT_NAMA like '$aKeyword%' ORDER BY ao.OBAT_KODE";
	  //if ($aKepemilikan=="0"){
	  	$sql="select ao.OBAT_ID,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL from dbapotek_tangerang.a_obat ao where ao.OBAT_NAMA like '$aKeyword%' and OBAT_ISAKTIF=1 order by ao.OBAT_NAMA";
/* 	  	$sql="SELECT t1.*,ao.OBAT_KODE,ao.OBAT_SATUAN_KECIL,ao.OBAT_NAMA,ak.NAMA 
			FROM (SELECT OBAT_ID,SUM(QTY_STOK) AS stok,KEPEMILIKAN_ID FROM a_penerimaan WHERE UNIT_ID_TERIMA=$idunit and KEPEMILIKAN_ID=$aKepemilikan AND QTY_STOK>0 AND STATUS=1 GROUP BY OBAT_ID,KEPEMILIKAN_ID) AS t1 
			INNER JOIN a_obat ao ON t1.OBAT_ID=ao.OBAT_ID INNER JOIN a_kepemilikan ak ON t1.KEPEMILIKAN_ID=ak.ID 
			WHERE ao.OBAT_NAMA LIKE '$aKeyword%' order by ao.OBAT_NAMA";
 */	  //}else{
	  //	$sql="select t1.*,ao.OBAT_KODE,ao.OBAT_NAMA,ao.OBAT_SATUAN_KECIL,ak.NAMA from (select ap.OBAT_ID,ap.KEPEMILIKAN_ID,sum(ap.QTY_STOK) as stok from a_penerimaan ap where ap.UNIT_ID_TERIMA=$idunit and ap.QTY_STOK>0 and ap.KEPEMILIKAN_ID=1 and ap.STATUS=1 group by ap.OBAT_ID,ap.KEPEMILIKAN_ID) as t1 inner join a_obat ao on t1.OBAT_ID=ao.OBAT_ID inner join a_kepemilikan ak on t1.KEPEMILIKAN_ID=ak.ID where ao.OBAT_NAMA like '$aKeyword%' order by ao.OBAT_NAMA";
	  //}
	  //echo $sql."<br>";
	  $rs=mysql_query($sql);
	  $arfvalue="";
	  $i=0;
	  while ($rows=mysql_fetch_array($rs)){
	  	$i++;
		//if ($aKepemilikan=="0"){
		//	$arfvalue=$no."*|*".$rows['OBAT_ID']."*|*".$rows['OBAT_NAMA']."*|*".$rows['OBAT_SATUAN_KECIL']."*|*".$rows['OBAT_KODE'];
		//}else{
			$arfvalue=$no."*|*".$rows['OBAT_ID']."*|*".$rows['OBAT_NAMA']."*|*".$rows['OBAT_SATUAN_KECIL']."*|*".$rows['OBAT_KODE']."*|*".$rows['NAMA']."*|*".$rows['KEPEMILIKAN_ID'];
		//}
	  ?>
      <tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="fSetObat(this.lang);">
        <td class="tdisikiri" width="80"><?php echo $rows['OBAT_KODE']; ?></td>
        <td class="tdisi" align="left"><?php echo $rows['OBAT_NAMA']; ?></td>
        <td class="tdisi" width="80"><?php echo $rows['OBAT_SATUAN_KECIL']; ?></td>
        <!--td class="tdisi" width="90"><?php //echo $rows['NAMA']; ?></td>
        <td class="tdisi" width="60"><?php //echo $rows['stok']; ?></td-->
      </tr>
		<?php 
		}
		?>	
	</table>
<?php 
mysql_close($konek);
?>