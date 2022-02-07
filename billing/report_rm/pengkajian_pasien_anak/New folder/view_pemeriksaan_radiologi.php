<table width="600" border="1" align="center" cellpadding="2" cellspacing="1" style="border-collapse:collapse;">
  <?php
  	$no=1;
	$id=$_REQUEST['id'];
	include("../../koneksi/konek.php");
	$sql = "SELECT * FROM b_ms_pengkajian_pasien_anak2 WHERE pengkajian_id='$id'";
	$query = mysql_query($sql);
	while ($data = mysql_fetch_array($query))
	{
		if($no%2!=0)
		{
			$bg ="#FFFFFF";
		}
		else
		{
			$bg ="#ccc";
		}
	?>
  <tr bgcolor="<?=$bg;?>"class="row_colour" id="<? echo $data['id_agama'];?>" lang="<? echo "$data[id_agama] | $data[agama]";?>" onClick="pilih_data_form(this.lang)">
  	<td align="center" width="37"><?php echo $no;?></td>
    <td align="center" width="130"><?php echo $data['jenis_pemeriksaan'];?></td>
    <td align="center" width="207"><?php echo $data['bagian'];?></td>
    <td align="center" width="120"><?php echo $data['lembar'];?></td>
    <td align="center" width="200"><?php echo $data['keterangan'];?></td>
  </tr>
  <?
  $no++;
	}
	?>
</table>