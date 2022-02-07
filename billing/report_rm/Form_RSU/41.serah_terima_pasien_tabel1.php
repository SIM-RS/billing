<?
$start = 0;
$no = 0;
if(isset($_REQUEST['id']))
 {
  	include('../../koneksi/konek.php');
	$no = 0;
  	$id = $_REQUEST['id'];
	$q = "select * from b_form_serahterima_obat where id_serahterima='$id'";
	$s = mysql_query($q);
	$j = mysql_num_rows($s); //echo "$j";
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
/*$(".delRow").live("click", function () {

        if(confirm('Yakin data dihapus?'))
		{
			return true;
		}
		else
		{
			return false;
		}

});*/

	var x = <?=$start;?>;
	$(".alternativeRow").btnAddRow({oddRowCSS:"oddRow",evenRowCSS:"evenRow",rowNumColumn: 'no'},function(barisBaru){
		x++;
		$(barisBaru).find(".nama_obat").attr("id","nama_obat"+x);
		$(barisBaru).find(".dosis").attr("id","dosis"+x);
		$(barisBaru).find(".jumlah").attr("id","jumlah"+x);
		$(barisBaru).find(".obat_sisa").attr("id","obat_sisa"+x);
		$(barisBaru).find(".delRow").attr("lang","");
	});
	
	
	$(".delRow").btnDelRow(function(row){
		var id = $(row).find(".delRow").attr('lang');
		if(id!="")
		{
			del(id);
		}
	});
});	
</script>
<table width="1000" border="1" bordercolor="#336699" style="border-collapse:collapse;">
  <tr align="center" style="font:bold 12px tahoma;background:#6699CC; color:#FFFFFF;">
    <td width="40">No</td>
    <td width="262">Nama Obat </td>
    <td width="153">Dosis</td>
    <td width="120">Jumlah</td>
    <td width="303">Obat-obat sisa <input type="text" name="list_hapus" id="list_hapus" /></td>
    <td width="82"><!--<button class="alternativeRow" style="cursor:pointer; padding:2px 3px;">Tambah</button>-->
	<img src="add3.png" width="25" height="25" class="alternativeRow" value="Add" style="cursor:pointer; padding:2px 3px;"/></td>
  </tr>
  <?
  if(isset($_REQUEST['id']))
  {
	while($d = mysql_fetch_array($s))
	{
  ?>
    <tr align="center">
    <td><span class="no"><?=$no+1;?></span>.<input type="text" name="id1[]" id="id1" size="5"value="<?=$d['id'];?>"/></td>
    <td><input type="text" name="nama_obat[]" class="nama_obat" id="nama_obat<?=$no;?>" size="35" value="<?=$d['nama_obat'];?>" /></td>
    <td><input type="text" name="dosis[]" class="dosis" id="dosis<?=$no;?>" value="<?=$d['dosis'];?>" /></td>
    <td><input type="text" name="jumlah[]" class="jumlah" id="jumlah<?=$no;?>" value="<?=$d['jumlah'];?>"/></td>
    <td><input type="text" name="obat_sisa[]" class="obat_sisa" id="obat_sisa<?=$no;?>" size="30"  value="<?=$d['obat_sisa'];?>"/></td>
    <td><img src="hapus.png" width="20" height="20" class="delRow" border="0" style="cursor:pointer;" lang="<?=$d['id'];?>" ></td>
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
    <td><input type="text" name="nama_obat[]" class="nama_obat" id="nama_obat0" size="35" /></td>
    <td><input type="text" name="dosis[]" class="dosis" id="dosis0" /></td>
    <td><input type="text" name="jumlah[]" class="jumlah" id="jumlah0" /></td>
    <td><input type="text" name="obat_sisa[]" class="obat_sisa" id="obat_sisa0" size="30" /></td>
    <td><img src="hapus.png" width="20" height="20" class="delRow" border="0" style="cursor:pointer;" lang="0"></td>
  </tr>
<?
}
?>
</table>
<script>
function del(id)
{
	var val = $("#list_hapus").val();
	var new_val = val+","+id;
	$("#list_hapus").val(new_val);
	
}
</script>