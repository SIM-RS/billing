<?php
	session_start();
	include("../koneksi/konek.php");
?>
<style type="text/css">
	#inside{
		font-size:12px;
	}
	#datPas, #fkartu{
		border-collapse:collapse;
	}
	#fkartu td{
		border:0px;
		padding:5px;
		font-size:12px;
	}
	#datPas td{
		border:1px solid #000;
		padding:5px;
		font-size:12px;
	}
	#datPas th{
		border:1px solid #000;
		padding:5px;
		font-size:12px;
		text-align:center;
		background:#9EB8E0;
	}
	#datPas .noborder{
		border:0px;
	}
</style>
<div id="inside" style="padding-top:15px;">
	<div id="formK">
		<table id="fkartu">
			<tr>
				<td>No RM</td>
				<td>:</td>
				<td><input type="text" id="norm" name="norm" size="10"/></td>
			</tr>
			<tr>
				<td>Jenis Layanan</td>
				<td>:</td>
				<td>
					<select name="jnsLay" id="jnsLay" onchange="tmpLayanan(this.value)">
						<option value='all'>-- SEMUA --</option>
						<?php
							$sql = "select id,nama from $dbbilling.b_ms_unit where level=1 and kategori = 2 and aktif = 1;";
							$query = mysqli_query($konek,$sql);
							while($data = mysqli_fetch_array($query)){
								echo "<option value='".$data['id']."'>".$data['nama']."</option>";
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Tempat Layanan</td>
				<td>:</td>
				<td>
					<select name="tmpLay" id="tmpLay">
						
					</select>
				</td>
			</tr>
			<td>
				<td colspan="3">
					<button name="lihat" id="lihat" onclick="cekKK(); return false;">Lihat</button>
				</td>
			</td>
		</table>
	</div>
	<div id="dPas" style="padding:10px;"></div>
</div>
<script type="text/javascript">
	tmpLayanan(document.getElementById('jnsLay').value);
	function tmpLayanan(val){
		//alert(val);
		jQuery('#tmpLay').load('../transaksi/formkartukendali_utils.php?act=tmpLay&jnsid='+val);
	}
	function cekKK(){
		var norm = document.getElementById('norm').value;
		var jnsLay = document.getElementById('jnsLay').value;
		var tmpLay = document.getElementById('tmpLay').value;
		if(norm!=''){
			jQuery('#dPas').load('../transaksi/formkartukendali_utils.php?act=data&jnsLay='+jnsLay+'&tmpLay='+tmpLay+'&norm='+norm);
		} else {
			alert('No RM Tidak Boleh Kosong!');
		}
	}
</script>