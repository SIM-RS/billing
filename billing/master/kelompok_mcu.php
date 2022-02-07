<?php 
session_start();
include("../sesi.php");
include("../koneksi/konek.php");
$user_id = $_SESSION['userId'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<script type="text/javascript" src="../include/jquery/jquery-1.9.1.js"></script>
	<title></title>
</head>

<body>
	<div style="width: 90%;margin-top:10px;padding: 10px;" id="kelompokMcu">
		<form id="formKelompokMcu">
			<table>
				<tr>
					<td>Nama Kelompok</td>
					<td>
						<input style="width: 350px;" type="text" name="nama_kelompok" id="nama_kelompok" class="txtinput">
					</td>
				</tr>
				<tr>
					<td>
						<input type="checkbox" name="Kelompok_mcu_aktif" id="Kelompok_mcu_aktif"> aktif
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<button type="button" name="simpanKelompokMcu" id="simpanKelompokMcu" value="tambahKelompok" onclick="saveData(this.value)">Tambah</button>
						<button type="button" name="deleteKelompokMcu" onclick="deleteData()" id="deleteKelompokMcu" disabled>Hapus</button>
						<button onclick="batalKelompokMcu()" type="reset">Batal</button>
					</td>
				</tr>
			</table>
		</form>
		<table style="width: 100%;">
			<tr>
				<td align="right">
					<button onclick="tampilKelompokMcuTindakan()" type="button" id="btnSetTindakanKelompokMcu" name="btnSetTindakanKelompokMcu">
						Set Tindakan Kelompok
					</button>	
					<button onclick="tampilKonsulUnit()" type="button" id="konsulUnit" name="konsulUnit">
						Set Konsul Unit
					</button>
				</td>
			</tr>
		</table>
		<div id="gridBoxMcuKelompok"></div>
		<div id="pagingMcuKelompok"></div>
	</div>
	<div style="width: 90%;margin-top:10px;padding: 10px;display: none;" id="kelompokTindakanMcu">
		<button type="button" onclick="kembaliAwal()">Kembali</button>
		<form id="kelompokTindakanMcuForm">
			<input type="hidden" id="idKelompokMcu" name="idKelompokMcu">
		</form>
		<table>
			<tr>
				<td valign="top">
					<fieldset>
						<legend>Daftar Tindakan</legend>
						<div id="grdKelompokTindakanMcu" style="width:400px; height:320px; background-color:white; overflow:hidden; padding-bottom:20px;"></div>
						<div id="pagingGrdKelompokTindakanMcu" style="width:410px;"></div>
					</fieldset>
				</td>
				<td>
					<input type="button" id="btnRight" value="" onclick="pindahKanan()" class="tblRight">
					<br>
					<input type="button" id="btnLeft" value="" onclick="pindahKiri()" class="tblLeft">
				</td>
				<td valign="top">
					<fieldset>
						<legend>Daftar Tindakan</legend>
						<table>
							<tr>
								<td>Jenis</td>
								<td>
									<select name="select" class="txtinput" id="cmbJnsLayKelMcu" onchange="isiCombo('TmpLayanan',this.value,'','cmbUnitKelMcu',ubahUnit)">
										<?php
										$sql="SELECT distinct m.id,m.nama,m.inap FROM b_ms_unit m WHERE level=1 AND kategori=2 AND aktif=1 order by nama";
										$rs=mysql_query($sql);
										while($rw=mysql_fetch_array($rs)){
											?>
											<option value="<?php echo $rw['id'];?>" label="<?php /*echo $rw['inap'];*/?>" title="<?php echo $rw['id'];?>">
												<?php echo $rw['nama'];?>	
											</option>

											<?php
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td>
									Tempat
								</td>
								<td>
									<select id="cmbUnitKelMcu" class="txtinput" lang="" onchange="ubahUnit();"></select>
								</td>
							</tr>
							<tr>
								<td>
									Dokter
								</td>
								<td>
									<form name="form_dokter_tindakan">

										<select id="cmbDokTind" name="cmbDokTind" style="min-width:250px;">
											<option value="">-Dokter-</option>
										</select>
										<br />
										<label><input type="checkbox" id="chkDokterPenggantiTind" value="1" onchange="gantiDokter('cmbDokTind',this.checked);"/>Dokter Pengganti</label>
										</form>
									</td>
								</tr>
							</table>
							<div id="grdKelompokTindakanMcuKanan" style="width:400px; height:300px; background-color:white; overflow:hidden;"></div>
							<div id="pagingGrdKelompokTindakanMcuKanan" style="width:410px;"></div>
						</fieldset>
					</td>	
				</tr>
			</table>
		</div>

		<div style="width: ;display: none;padding: 10px;margin-top: 10px;" id="kelompokTempatLayanan">
			<button type="button" onclick="kembaliAwal()">Kembali</button>
            <div id="gridboxTempatLayanan" style="width:900px; height:300px; background-color:white; overflow:hidden;"></div>
	        <div id="pagingTempatLayanan" style="width:900px;"></div></td>
		</div>
	</body>
	</html>