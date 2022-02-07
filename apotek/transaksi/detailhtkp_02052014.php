<body bgcolor="transparance">
<?
include("../koneksi/konek.php");
if($_REQUEST['cek']=='true'){
				$que = "select 
				ap.textH,ap.textT,ap.textK,ap.textP
				from $dbapotek.a_penjualan ap
				INNER JOIN $dbbilling.b_ms_pasien p
  				 ON ap.NO_PASIEN = p.no_rm 
				where ap.NO_KUNJUNGAN='".$_REQUEST['kunj']."' AND p.id='".$_REQUEST['rm']."'";
				$queLab = mysqli_fetch_array(mysqli_query($konek,$que));
				//echo $que;							
			?>
            <script>
				//jQuery("#namapatient").val("<?php echo $queLab['nama'];?>");
				document.getElementById('isiH').value="<?php echo $queLab['textH'];?>";
				document.getElementById('isiT').value="<?php echo $queLab['textT'];?>";
				document.getElementById('isiK').value="<?php echo $queLab['textK'];?>";
				document.getElementById('isiP').value="<?php echo $queLab['textP'];?>";
				//jQuery("#btnIsiDataRM19").show();
			</script>
            <?php
					}
?>

</body>