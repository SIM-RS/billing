	<?php include('../koneksi/konek.php'); ?>
	<div class="tabel" width="100%" style="display:block; height:100% !important;">
		<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center" class="tabel">
			 <tr>
				<td>&nbsp;</td>
				<td align="center">
					<fieldset>
						<legend>Daftar Tindakan</legend>
						<div id="gridboxtindakan" style="width:400px; height:320px; background-color:white; overflow:hidden; padding-bottom:20px;"></div>
						<div id="pagingtindakan" style="width:410px;"></div>
					</fieldset>
				</td>
				<td align="center">
					<input type="button" id="btnRight" value="" onclick="pindah('r')" class="tblRight"/><br>
					<input type="button" id="btnLeft" value="" onclick="pindah('l')" class="tblLeft"/>
				</td>
				<td align="center">
					<fieldset>
						<legend>Daftar Tindakan Tiap Kelompok Pendapatan</legend>
						<table width="396">
						<tr>
						  <td width="59">Kelompok</td>
						  <td width="325">:
							<select name="select" class="txtinput" id="pendapatan" name="pendapatan" onchange="loadGridAK(this)">
								<?php 
									$sql = "SELECT * FROM $dbakuntansi.ak_ms_unit_new un WHERE un.tipe = 2 AND un.islast = 1";
									$query = mysql_query($sql);
									while($query && $data = mysql_fetch_array($query)){
										echo "<option value='".$data['id']."'>".$data['nama']."</option>";
									}
								?>
							</select></td>
						  </tr>
						</table>
						<div id="gridboxtindakanak" style="width:400px; height:320px; background-color:white; overflow:hidden; padding-bottom:20px;"></div>
						<div id="pagingtindakanak" style="width:410px;"></div>
					</fieldset>
				</td>
				<td>&nbsp;</td>
			</tr>
		</table>
	</div>