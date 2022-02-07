<body bgcolor="transparance">
<?
include("../koneksi/konek.php");
$id_pelayanan = $_REQUEST['id_pelayanan'];
$getIdPasien = $_REQUEST['getIdPasien'];
$in = $_REQUEST['in'];
$kh = $_REQUEST['kh'];
$valLab = $_REQUEST['valLab'];
$kon1 = $_REQUEST['kon1'];
$userId = $_REQUEST['userId'];
if($in=="true")
{
	$query12 = "update b_pelayanan set tgl_masuk = NOW() where id = $id_pelayanan and tgl_masuk IS NULL";
	mysql_query($query12);	
}elseif($in=="false"){
	$query12 = "update b_pelayanan set tgl_keluar = NOW() where id = $id_pelayanan";
	mysql_query($query12);
}elseif($kh=="true"){
	$query12 = "update b_ms_pasien set p_khusus = '$kon1' where id = $getIdPasien";
	mysql_query($query12);
}elseif($valLab=="true"){
	$query12 = "SELECT * FROM b_pelayanan WHERE id = $id_pelayanan";
	$dvalLab = mysql_fetch_array(mysql_query($query12));
	
	if($dvalLab['accLab'] == 3)
	{
		?>
        <script>
			document.getElementById("app1").checked = true;
			document.getElementById("app2").checked = true;
			document.getElementById("app3").checked = true;
			
			document.getElementById("app1").disabled = false;
			document.getElementById("app2").disabled = false;
			document.getElementById("app3").disabled = false;
		</script>
        <?
	}elseif($dvalLab['accLab'] == 2){
		?>
        <script>
			document.getElementById("app1").checked = true;
			document.getElementById("app2").checked = true;
			document.getElementById("app3").checked = false;
			
			document.getElementById("app1").disabled = false;
			document.getElementById("app2").disabled = false;
			document.getElementById("app3").disabled = false;
		</script>
        <?
	}elseif($dvalLab['accLab'] == 1){
		?>
        <script>
			document.getElementById("app1").checked = true;
			document.getElementById("app2").checked = false;
			document.getElementById("app3").checked = false;
			
			document.getElementById("app1").disabled = false;
			document.getElementById("app2").disabled = false;
			document.getElementById("app3").disabled = true;
		</script>
        <?
	}else{
		?>
        <script>
			document.getElementById("app1").checked = false;
			document.getElementById("app2").checked = false;
			document.getElementById("app3").checked = false;
			
			document.getElementById("app1").disabled = false;
			document.getElementById("app2").disabled = true;
			document.getElementById("app3").disabled = true;
		</script>
        <?
	}
	
	$query12 = "SELECT * FROM b_ms_app_lab WHERE id_user = $userId ORDER BY acc DESC LIMIT 1";
	$dvalLab = mysql_fetch_array(mysql_query($query12));
		if($dvalLab['acc']==3)
		{
			?>
            <script>
				jQuery("#tapp1").show();
				jQuery("#tapp2").show();
				jQuery("#tapp3").show();
			</script>
            <?
		}elseif($dvalLab['acc']==2)
		{
			?>
            <script>
				jQuery("#tapp1").show();
				jQuery("#tapp2").show();
				jQuery("#tapp3").hide();
			</script>
            <?
		}else
		{
			?>
            <script>
				jQuery("#tapp1").show();
				jQuery("#tapp2").hide();
				jQuery("#tapp3").hide();
			</script>
            <?
		}
}
?>
<!--<span style="color:#F00"></span>-->
</body>