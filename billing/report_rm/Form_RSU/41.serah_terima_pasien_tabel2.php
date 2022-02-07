<?
$start = 0;
$no = 0;
if(isset($_REQUEST['id']))
{
  	include('../../koneksi/konek.php');
	$no = 0;
  	$id = $_REQUEST['id'];
	$qq = "select * from b_form_serahterima_catatan where id_serahterima='$id'";
	$ss = mysql_query($qq);
	$j = mysql_num_rows($ss); //echo "$j";
	if($j==0)
	{
		$start = 0;
	}
	else
	{
		$start = $j-1;
	}
	/*echo "<script src='../../include/jquery/jquery-1.4.1.js'></script>";
	echo "<script src='js/jquery.table.addrow.js'></script>";*/
}
?>
<script>
$("document").ready(function(){
/*$(".delRow2").live("click", function () {

        if(confirm('Yakin data dihapus?'))
		{
			return true;
		}
		else
		{
			return false;
		}

});*/


	var y = <?=$start;?>;
	$(".alternativeRow2").btnAddRow({oddRowCSS:"oddRow",evenRowCSS:"evenRow",rowNumColumn: 'no'},function(barisBaru){
		y++; //alert(y);
		$(barisBaru).find(".pesanan").attr("id","pesanan"+y);
		$(barisBaru).find(".keterangan").attr("id","keterangan"+y);
		$(barisBaru).find(".instruksi").attr("id","instruksi"+y);
		$(barisBaru).find(".delRow2").attr("lang","");
	});
	
	$(".delRow2").btnDelRow(function(row){
		var id2 = $(row).find(".delRow2").attr('lang');
		if(id2!="")
		{
			del2(id2);
		}
	});
});	
</script>
<table width="1000" border="1" bordercolor="#336699" style="border-collapse:collapse;">
    <tr align="center" style="font:bold 12px tahoma;background:#6699CC; color:#FFFFFF;">
      <td width="46">No</td>
      <td width="271">Pesanan</td>
      <td width="301">Keterangan</td>
      <td width="285">Instruksi<input type="text" name="list_hapus2" id="list_hapus2" /></td>
      <td width="63"><!--<button class="alternativeRow" style="cursor:pointer; padding:2px 3px;">Tambah</button>-->
          <img src="add3.png" alt="ss" width="25" height="25" class="alternativeRow2" style="cursor:pointer; padding:2px 3px;" value="Add"/></td>
    </tr>
	 <?
	  if(isset($_REQUEST['id']))
	  {
		while($dd = mysql_fetch_array($ss))
		{
	  ?>
	<tr align="center">
      <td><span class="no"><?=$no+1;?></span>.<input type="text" name="id2[]" id="id2" size="5"value="<?=$dd['id'];?>"/></td>
      <td><input type="text" name="pesanan[]" id="pesanan0" class="pesanan" size="35" value="<?=$dd['pesanan'];?>" /></td>
      <td><input type="text" name="keterangan[]" id="keterangan0" class="keterangan" size="40" value="<?=$dd['keterangan'];?>" /></td>
      <td><input type="text" name="instruksi[]" id="instruksi0" class="instruksi" size="40" value="<?=$dd['instruksi'];?>" /></td>
      <td><!--<button class="delRow" border="0" style="cursor:pointer;">X</button>-->
          <img src="hapus.png" alt="ss" width="20" height="20" border="0" class="delRow2" style="cursor:pointer;" lang="<?=$dd['id'];?>" /></td>
    </tr>
	<?
		$no++;
		$start++;
		}
	}
	else
	{
	?>
    <tr align="center">
      <td><span class="no"></span>.</td>
      <td><input type="text" name="pesanan[]" id="pesanan0" class="pesanan" size="35" /></td>
      <td><input type="text" name="keterangan[]" id="keterangan0" class="keterangan" size="40" /></td>
      <td><input type="text" name="instruksi[]" id="instruksi0" class="instruksi" size="40" /></td>
      <td><!--<button class="delRow" border="0" style="cursor:pointer;">X</button>-->
          <img src="hapus.png" alt="ss" width="20" height="20" border="0" class="delRow2" style="cursor:pointer;" lang="" /></td>
    </tr>
	<?
	}
	?>
  </table>
  <script>
function del2(id)
{
	var val = $("#list_hapus2").val();
	var new_val = val+","+id;
	$("#list_hapus2").val(new_val);
}
</script>