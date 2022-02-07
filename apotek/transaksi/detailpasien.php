<body bgcolor="transparance">
<?
include("../koneksi/konek.php");
if($_REQUEST['cek']=='true'){
				$que = "select 
				DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(mp.tgl_lahir, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(mp.tgl_lahir, '00-%m-%d')) umur,
				DATE_FORMAT(mp.tgl_lahir, '%d-%m-%Y') tgl_lahir,mp.no_rm,mp.no_ktp,mp.telp,mp.sex,mp.nama,
				CONCAT((CONCAT((CONCAT((CONCAT(mp.alamat,' RT.',mp.rt)),' RW.',mp.rw)),', Desa ',w.nama)),', Kecamatan ',wi.nama,', ',wii.nama) alamat_
				from $dbbilling.b_ms_pasien mp
				LEFT JOIN $dbbilling.b_ms_wilayah w ON mp.desa_id = w.id
				LEFT JOIN $dbbilling.b_ms_wilayah wi ON mp.kec_id = wi.id
				LEFT JOIN $dbbilling.b_ms_wilayah wii ON mp.kab_id = wii.id
				 where mp.id='".$_REQUEST['id_patient']."'";
				$queLab = mysqli_fetch_array(mysqli_query($konek,$que));
				//echo $que;							
			?>
            <script>
				//jQuery("#namapatient").val("<?php echo $queLab['nama'];?>");
				document.getElementById('namapatient').value="<?php echo $queLab['nama'];?>";
				document.getElementById('nmrrm').value="<?php echo $queLab['no_rm'];?>";
				document.getElementById('jenkel').value="<?php echo $queLab['sex'];?>";
				document.getElementById('umurpatient').value="<?php echo $queLab['umur'];?>";
				document.getElementById('tglpatient').value="<?php echo $queLab['tgl_lahir'];?>";
				document.getElementById('ktppatient').value="<?php echo $queLab['no_ktp'];?>";
				document.getElementById('alamatpatient').value="<?php echo $queLab['alamat_'];?>";
				document.getElementById('telppatient').value="<?php echo $queLab['telp'];?>";
				//jQuery("#btnIsiDataRM19").show();
			</script>
            <?php
					}
?>

</body>