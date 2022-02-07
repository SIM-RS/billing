<body bgcolor="transparance">
<?
include("../koneksi/konek.php");
$id_pelayanan = $_REQUEST['id_pelayanan'];
if($_REQUEST['cek']=='aksi'){
	$query = "update b_pelayanan set rawat_bersama = 1 where id='$id_pelayanan'";
	//echo $query;
	mysql_query($query);
}

if($_REQUEST['cek']=='true'){
	$query12 = "select rawat_bersama from b_pelayanan where id='$id_pelayanan'";
	//echo $query12;
	$tes = mysql_fetch_array(mysql_query($query12));
	if($tes['rawat_bersama']=='1'){
		?>
            <script>
				jQuery("#rawatbersama").attr('disabled','disabled');
				//document.getElementById("rawatbersama").disabled = true;
			</script>
         <?
	}else{	
		?>
            <script>
				jQuery("#rawatbersama").removeAttr("disabled");
				//document.getElementById("rawatbersama").disabled = false;
			</script>
         <?
	}
}
?>
</body>