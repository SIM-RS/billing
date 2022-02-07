<body bgcolor="transparance">
<?
include("../koneksi/konek.php");
$kunjungan_id = $_REQUEST['kunjungan_id'];

if($_REQUEST['cek']=='true'){
 if($kunjungan_id!=''){
	$que = "SELECT * FROM b_pelayanan WHERE batal = 0 AND kunjungan_id = '".$kunjungan_id."';";
	$queLab = mysql_num_rows(mysql_query($que));
		if($queLab==0){											
		?>
		<script>
			//jQuery("#btnResume").hide();
			jQuery("#btnResume").prop("disabled",true);
			jQuery("#btnCtkAnam").prop("disabled",true);
			jQuery('#batalKunjungan').html('Pasien Batal Berkunjung');
		</script>
		<?
		}else{
		?>
		<script>
			//jQuery("#btnResume").show();
			jQuery("#btnResume").prop("disabled",false);
			jQuery("#btnCtkAnam").prop("disabled",false);
			jQuery('#batalKunjungan').html('');
		</script>
		<?
		}
 }else{
	?>
	<script>
        //jQuery("#btnResume").show();
        jQuery("#btnResume").prop("disabled",false);
        jQuery("#btnCtkAnam").prop("disabled",false);
        jQuery('#batalKunjungan').html('');
    </script>
    <?
 }
}
?>

</body>