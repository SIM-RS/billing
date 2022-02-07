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
$anamnes = $_REQUEST['anamnes'];
$checkout = $_REQUEST['checkout'];
$cekLabN = $_REQUEST['cekLabN'];
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
}elseif($cekLabN=="true"){
	$query12 = "SELECT * FROM b_hasil_lab where id_pelayanan = $id_pelayanan AND hasil=''";
	$execQB=mysql_query($query12);
	$jmlQB=mysql_num_rows($execQB);
	if($jmlQB>0){
		?>
        	<script>
			alert("masih ada pemeriksaan lab yang belum di entry nilai normalnya !");
            </script>
        <?
	}
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
}elseif($anamnes=="true"){
	$sqlAnam = "SELECT TENSI, TENSI_DIASTOLIK, RR, NADI, SUHU, TB, BB FROM anamnese WHERE PASIEN_ID = $getIdPasien AND SNURS = 1 ORDER BY ANAMNESE_ID DESC LIMIT 1";
	$dsqlAnam = mysql_fetch_array(mysql_query($sqlAnam));
	$jmlAnam = mysql_num_rows(mysql_query($sqlAnam));
	if($jmlAnam > 0)
	{
	?>
    <script>
		jQuery("#txtTensi").val("<?= $dsqlAnam['TENSI']?>");
		jQuery("#txtTensi1").val("<?= $dsqlAnam['TENSI_DIASTOLIK']?>");
		jQuery("#txtSuhu").val("<?= $dsqlAnam['SUHU']?>");
		jQuery("#txtNadi").val("<?= $dsqlAnam['NADI']?>");
		jQuery("#txtTB").val("<?= $dsqlAnam['TB']?>");
		jQuery("#txtBB").val("<?= $dsqlAnam['BB']?>");
	</script>
    <?
	}
}elseif($checkout=="true"){
	$sqlchek = "update b_pelayanan set checkout = 1 where id = '$id_pelayanan'";
	$execsqlchek = mysql_query($sqlchek);
}
?>
<!--<span style="color:#F00"></span>-->
</body>