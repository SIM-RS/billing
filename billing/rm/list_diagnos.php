<?php 
include("../koneksi/konek.php");
?>
    <table id="tblObat" border="0" cellpadding="1" cellspacing="0">
      <?php 
	  $aKepemilikan=$_REQUEST["aKepemilikan"];
	  $aKeyword=$_REQUEST["aKeyword"];
	  $no=$_REQUEST["no"];
	 $sql="SELECT id,nama FROM b_ms_diagnosa WHERE trim(nama) like '$aKeyword%' GROUP BY nama ORDER BY nama LIMIT 20";
	  //$sql="SELECT id,kode,nama FROM ask_ms_dc_planning WHERE trim(nama) like '$aKeyword%' ORDER BY nama";
	  $rs=mysql_query($sql);
	  $arfvalue="";
	  $i=0;
	  while ($rows=mysql_fetch_array($rs)){
	  	$i++;
		$arfvalue=$no."|".$rows['id']."|".$rows['nama'];

			$nama=$i.".&nbsp;".$rows['nama'];
			
	  ?>
      <tr id="<?php echo $i; ?>" lang="<?php echo $arfvalue; ?>" class="itemtableReq" onMouseOver="this.className='itemtableMOverReq'" onMouseOut="this.className='itemtableReq'" onClick="ValNama(this.lang);">
        <td class="tdisikiri" width="700" align="left"><?php echo $nama; ?></td>
      </tr>
		<?php
		}
		?>	
	</table>
<?php 
mysql_close($konek);
?>