<body bgcolor="transparance">
<?
include("../koneksi/konek.php");
$id_pelayanan = $_REQUEST['id_pelayanan'];
$unit = $_REQUEST['unit'];

	$query12 = "select * from b_ms_unit where id='$unit' and inap=0";
	
	$dvalLab = mysql_num_rows(mysql_query($query12));
		if($dvalLab!=0)
		{
			$query11 = "select * from b_pelayanan where id='$id_pelayanan' and dilayani=0";
			$dvalLab1 = mysql_num_rows(mysql_query($query11));
			if($dvalLab1!=0)
			{
				if($_REQUEST['cek']=='true'){
				$que = "select batal from b_pelayanan where id='$id_pelayanan'";
				$queLab = mysql_fetch_array(mysql_query($que));
					if($queLab['batal']==0){
						$query = "update b_pelayanan set batal = 1, ket_batal ='".$_REQUEST['ket_batal']."' where id='$id_pelayanan'";						
			?>
            <script>
				jQuery("#btnIsiDataRM18").hide();
				jQuery("#btnIsiDataRM19").show();
			</script>
            <?
					}else{
						$query = "update b_pelayanan set batal = 0 where id='$id_pelayanan'";
			?>
            <script>
				jQuery("#btnIsiDataRM18").show();
				jQuery("#btnIsiDataRM19").hide();
			</script>
            <?
					}
					mysql_query($query);
				}else{
			?>
            <script>
				jQuery("#btnIsiDataRM18").show();
			</script>
            <?	
				}
			}else{
			?>
            <script>
				jQuery("#btnIsiDataRM18").hide();
			</script>
			<?
			}
		}else
		{
			?>
            <script>
				jQuery("#btnIsiDataRM18").hide();
			</script>
            <?
		}
?>

</body>