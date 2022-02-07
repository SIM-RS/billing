<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link type="text/css" rel="stylesheet" href="../theme/mod.css">
	<script language="JavaScript" src="../theme/js/mod.js"></script>
	<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
	<script src="../include/jquery/jquery-1.9.1.js"></script>
	<!-- untuk ajax-->
	<script type="text/javascript" src="../theme/js/ajax.js"></script>
	<!-- end untuk ajax-->
	<title>Form Kamar</title>
</head>

<body>
	<div align="center">
		<?php
		include("../koneksi/konek.php");
		include("../header1.php");
		?>
		<iframe height="72" width="130" name="sort" id="sort" src="../theme/dsgrid_sort.php" scrolling="no" frameborder="0" style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
		</iframe>
		<div id="div_masterKamar" style="display:block;">

			<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
				<tr>
					<td height="30">&nbsp;FORM TARIF TINDAKAN KAMAR</td>
				</tr>
			</table>
			<table width="1000" border="0" cellspacing="1" cellpadding="0" align="center" class="tabel">
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="right">&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="right">Jenis Layanan&nbsp;</td>
					<td>&nbsp;<select id="cmbJnsLay" name="cmbJnsLay" class="txtinput" onchange="isiCombo('TmpLayananInapSaja',this.value,'','cmbUnit');">
							<?php
							$rs = mysql_query("SELECT * FROM b_ms_unit unit WHERE unit.inap=1 AND unit.level=1");
							while ($rows = mysql_fetch_array($rs)) :
								?>
								<option value="<?= $rows["id"] ?>"><?= $rows["nama"] ?></option>
							<?php endwhile; ?>
						</select></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="right">Unit&nbsp;</td>
					<td>&nbsp;<select id="cmbUnit" name="cmbUnit" class="txtinput"></select>
						<input type="hidden" id="txtIdUnit" name="txtIdUnit" /></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="right">Nama Kamar&nbsp;</td>
					<td>&nbsp;<input size="32" id="txtNama" name="txtNama" class="txtinput" /></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="right">Kode&nbsp;</td>
					<td>&nbsp;<input size="16" id="txtKode" name="txtKode" class="txtinput" /></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="right">Lantai&nbsp;</td>
					<td>&nbsp;<select id="cmbLantai" name="cmbLantai" class="txtinput">
							<?php
							$sLt = "select nama from b_ms_kamar_lantai where aktif=1 order by nama";
							$qLt = mysql_query($sLt);
							while ($rwLt = mysql_fetch_array($qLt)) {
								?>
								<option value="<?php echo $rwLt['nama']; ?>"><?php echo $rwLt['nama']; ?></option>
							<?php
							}
							?>
						</select>
					</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="right">Jumlah Tempat Tidur&nbsp;</td>
					<td>&nbsp;<input id="txtJmlTT" name="txtJmlTT" size="5" maxlength="4" value="1" class="txtcenter" onkeyup="if(isNaN(this.value)){ alert('isilah dengan angka!'); this.value='';}" /></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="right">Jumlah Tempat Tidur Bayangan&nbsp;</td>
					<td>&nbsp;<input id="txtJmlTTB" name="txtJmlTTB" size="5" maxlength="4" value="0" class="txtcenter" onkeyup="if(isNaN(this.value)){ alert('isilah dengan angka!'); this.value='';}" /></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<td>&nbsp;</td>
				<!-- <td align="right">Flag&nbsp;</td> -->
				<td>&nbsp;<input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="5" tabindex="3" value="<?php echo $flag; ?>" /></td>
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="right">Status&nbsp;</td>
					<td>&nbsp;<label><input type="checkbox" id="isAktif" name="isAktif" class="txtinput" checked="checked" />&nbsp;Aktif</label></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;<input id="txtId" type="hidden" name="txtId" /></td>
					<td height="30">
						<input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="simpan(this.value);" class="tblTambah" />
						<input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus" />
						<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal" />
					</td>
					<td align="right"><input type="button" id="btnTarifKamar" name="btnTarifKamar" value="Set Tarif Kamar" onclick="setTarif();" class="tblBtn" /></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="5%">&nbsp;</td>
					<td colspan="3">
						<div id="gridbox" style="width:900px; height:200px; background-color:white; overflow:hidden;"></div>
						<div id="paging" style="width:900px;"></div>
					</td>
					<td width="5%">&nbsp;</td>
				</tr>
				<tr>
					<td width="5%">&nbsp;</td>
					<td width="30%">&nbsp;</td>
					<td width="30%">&nbsp;</td>
					<td width="30%">&nbsp;</td>
					<td width="5%">&nbsp;</td>
				</tr>

			</table>
		</div>


		<div id="div_tarifKamar" style="display:none;">

			<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
				<tr>
					<td height="30">&nbsp;FORM TARIF KAMAR</td>
				</tr>
			</table>
			<table width="1000" border="0" cellspacing="1" cellpadding="0" align="center" class="tabel">
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="right">&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>

				<tr>
					<td>&nbsp;</td>
					<td align="right">Kelas&nbsp;</td>
					<td>&nbsp;<select id="cmbKls" name="cmbKls" class="txtinput">
							<?php
							$dt = mysql_query("SELECT * FROM b_ms_kelas ORDER BY kode");
							while ($rw = mysql_fetch_array($dt)) :
								?>
								<option value="<?= $rw["id"] ?>"><?= $rw["nama"] ?></option>
							<?php endwhile; ?>
						</select></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="right">Penjamin&nbsp;</td>
					<td>&nbsp;<select id="cmbPenjamin" name="cmbPenjamin" class="txtinput">
							<?php
							$dt = mysql_query("SELECT * FROM b_ms_kso where aktif=1");
							while ($rw = mysql_fetch_array($dt)) :
								?>
								<option value="<?= $rw["id"] ?>"><?= $rw["nama"] ?></option>
							<? endwhile; ?>
						</select></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>

				<tr>
					<td>&nbsp;</td>
					<td align="right">Tarif Kamar&nbsp;</td>
					<td>&nbsp;<input id="txtTarif" name="txtTarif" size="24" class="txtinput" onkeyup="if(isNaN(this.value)){ alert('isilah dengan angka!'); this.value='';}" /></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<td>&nbsp;</td>
				<!-- <td align="right">Flag&nbsp;</td> -->
				<td>&nbsp;<input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="5" tabindex="3" value="<?php echo $flag; ?>" /></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;<input id="txtIdTarif" type="hidden" name="txtIdTarif" /></td>
					<td height="30">
						<input type="button" id="btnSimpanTarif" name="btnSimpanTarif" value="Tambah" onclick="simpanTarif(this.value);" class="tblTambah" />
						<input type="button" id="btnHapusTarif" name="btnHapusTarif" value="Hapus" onclick="hapusTarif(this.title);" disabled="disabled" class="tblHapus" />
						<input type="button" id="btnBatalTarif" name="btnBatalTarif" value="Batal" onclick="batalTarif()" class="tblBatal" />
					</td>
					<td align="right"><input type="button" id="btnTarifKamar" name="btnTarifKamar" value="Kembali ke Master Kamar" onclick="setTarif();" class="tblBtn" /></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="5%">&nbsp;</td>
					<td colspan="3" align="center">
						<div id="gridbox2" style="width:900px; height:200px; background-color:white;"></div>
						<div id="paging2" style="width:900px;padding-top:20px;"></div>
					</td>
					<td width="5%">&nbsp;</td>
				</tr>
				<tr>
					<td width="5%">&nbsp;</td>
					<td width="30%">&nbsp;</td>
					<td width="30%">&nbsp;</td>
					<td width="30%">&nbsp;</td>
					<td width="5%">&nbsp;</td>
				</tr>
			</table>
		</div>
	</div>
</body>
<script>
	function isiCombo(id, val, defaultId, targetId, evloaded) {
		//alert('pasien_list.php?act=combo&id='+id+'&value='+val);
		if (targetId == '' || targetId == undefined) {
			targetId = id;
		}
		Request('../combo_utils.php?id=' + id + '&value=' + val + '&defaultId=' + defaultId, targetId, '', 'GET', evloaded);

	}
	isiCombo('TmpLayananInapSaja', document.getElementById('cmbJnsLay').value, '', 'cmbUnit');

	function simpan(action) {
		if (ValidateForm('txtKode,txtNama,cmbUnit', 'ind')) {
			var id = document.getElementById("txtId").value;
			var kode = document.getElementById("txtKode").value;
			var nama = document.getElementById("txtNama").value;
			var lantai = document.getElementById("cmbLantai").value;
			var unit_id = document.getElementById("cmbUnit").value;
			var jmlTT = document.getElementById('txtJmlTT').value;
			var jmlTTB = document.getElementById('txtJmlTTB').value;
			var flag = document.getElementById('flag').value;

			if (document.getElementById("isAktif").checked == true) {
				var aktif = 1;
			} else {
				var aktif = 0;
			}


			a.loadURL("kamar_utils.php?grd=true&act=" + action + "&id=" + id + "&unit=" + unit_id + "&kode=" + kode + "&nama=" + nama + "&lantai=" + lantai + "&jmlTT=" + jmlTT + "&jmlTTB=" + jmlTTB + "&flag=" + flag + "&aktif=" + aktif, "", "GET");

			document.getElementById("txtKode").value = '';
			document.getElementById("txtNama").value = '';
			document.getElementById("txtTarif").value = '';
			document.getElementById("cmbUnit").value = '';
			document.getElementById("cmbKls").value = '';
			document.getElementById('txtJmlTT').value = '';
			document.getElementById('txtJmlTTB').value = '';
			document.getElementById("isAktif").checked = '';
		}
	}

	function simpanTarif(action) {
		var id = document.getElementById("txtIdTarif").value;
		let idPenjamin = jQuery('#cmbPenjamin').val();
		var idKamar = document.getElementById("txtId").value;
		var tarif = document.getElementById("txtTarif").value;
		var kelas = document.getElementById("cmbKls").value;
		var unit_id = document.getElementById("txtIdUnit").value;
		var flag = document.getElementById("flag").value;
		//alert("kamar_utils.php?grd2=true&act="+action+"&id="+id+"&idKamar="+idKamar+"&unit="+unit_id+"&tarif="+tarif+"&kelas="+kelas);
		b.loadURL("kamar_utils.php?grd2=true&act=" + action + "&id=" + id + "&idKamar=" + idKamar + "&unit=" + unit_id + "&tarif=" + tarif + "&flag=" + flag + "&kelas=" + kelas + "&penjamin="+idPenjamin, "", "GET");
		batalTarif();
	}

	function ambilData() {
		var sisipan = a.getRowId(a.getSelRow()).split("|");
		var p = "txtId*-*" + sisipan[0] + "*|*txtKode*-*" + a.cellsGetValue(a.getSelRow(), 2) + "*|*txtNama*-*" + a.cellsGetValue(a.getSelRow(), 3) + "*|*cmbLantai*-*" + a.cellsGetValue(a.getSelRow(), 4) + "*|*cmbJnsLay*-*" + sisipan[2] + "*|*txtJmlTT*-*" + a.cellsGetValue(a.getSelRow(), 6) + "*|*txtJmlTTB*-*" + a.cellsGetValue(a.getSelRow(), 7) + "*|*isAktif*-*" + ((a.cellsGetValue(a.getSelRow(), 8) == 'Aktif') ? 'true' : 'false') + "*|*btnSimpan*-*Simpan*|*btnHapus*-*false";
		//alert(p);
		fSetValue(window, p);
		isiCombo('TmpLayananInapSaja', document.getElementById('cmbJnsLay').value, sisipan[1], 'cmbUnit');

	}

	function ambilDataTarif() {
		var sisipan = b.getRowId(b.getSelRow()).split("|");
		var p = "txtIdTarif*-*" + sisipan[0] + "*|*txtTarif*-*" + b.cellsGetValue(b.getSelRow(), 5) + "*|*cmbJnsLay*-*" + sisipan[3] + "*|*cmbKls*-*" + sisipan[1] + "*|*btnSimpanTarif*-*Simpan*|*btnHapusTarif*-*false";
		//alert(p);
		fSetValue(window, p);
		isiCombo('TmpLayanan', document.getElementById('cmbJnsLay').value, sisipan[2], 'cmbUnit');
	}

	function hapus() {
		var rowid = document.getElementById("txtId").value;
		//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
		if (confirm("Anda yakin menghapus Kamar " + a.cellsGetValue(a.getSelRow(), 3))) {
			a.loadURL("kamar_utils.php?grd=true&act=hapus&rowid=" + rowid, "", "GET");
		}

		document.getElementById("txtKode").value = '';
		document.getElementById("txtNama").value = '';
		document.getElementById("txtTarif").value = '';
		document.getElementById("cmbUnit").value = '';
		document.getElementById("cmbKls").value = '';
		document.getElementById('txtJmlTT').value = '';
		document.getElementById('txtJmlTTB').value = '';
		document.getElementById("isAktif").checked = '';
	}

	function hapusTarif() {
		if (b.getMaxPage() > 0) {
			var sisipan = b.getRowId(b.getSelRow()).split("|");
			var rowid = sisipan[0];
			var idKamar = sisipan[2];
			//alert("kamar_utils.php?grd2=true&act=hapus&rowid="+rowid);
			if (confirm("Anda yakin menghapus tarif unit " + b.cellsGetValue(b.getSelRow(), 2) + " kelas " + b.cellsGetValue(b.getSelRow(), 4))) {
				b.loadURL("kamar_utils.php?grd2=true&idKamar=" + idKamar + "&act=hapus&rowid=" + rowid, "", "GET");
			}
			batalTarif();
		} else {
			alert("Data tidak ada!");
		}
	}

	function batal() {
		var p = "txtId*-**|*txtKode*-**|*txtNama*-**|*cmbUnit*-**|*txtJmlTT*-*1*|*txtJmlTTB*-*0*|*isAktif*-*true*|*btnSimpan*-*Tambah*|*btnHapus*-*true";
		fSetValue(window, p);
	}

	function batalTarif() {
		var p = "txtIdTarif*-**|*txtTarif*-**|*cmbKls*-**|*btnSimpanTarif*-*Tambah*|*btnHapusTarif*-*true";
		fSetValue(window, p);
	}

	function setTarif() {
		var sisipan = a.getRowId(a.getSelRow()).split("|");
		fSetValue(window, "txtId*-*" + sisipan[0]);
		document.getElementById("txtIdUnit").value = sisipan[1];
		if (document.getElementById("div_masterKamar").style.display == 'block') {
			document.getElementById("div_masterKamar").style.display = 'none';
			document.getElementById("div_tarifKamar").style.display = 'block';
			b.loadURL("kamar_utils.php?grd2=true&idKamar=" + sisipan[0], '', 'GET');
		} else {
			document.getElementById("div_masterKamar").style.display = 'block';
			document.getElementById("div_tarifKamar").style.display = 'none';
		}

	}

	function cekData() {
		if (a.getMaxPage() > 0) {
			document.getElementById("btnTarifKamar").disabled = false;
		} else {
			document.getElementById("btnTarifKamar").disabled = true;
		}
	}


	function goFilterAndSort(grd) {
		//alert(grd);
		if (grd == "gridbox") {
			a.loadURL("kamar_utils.php?grd=true&filter=" + a.getFilter() + "&sorting=" + a.getSorting() + "&page=" + a.getPage(), "", "GET");
		}
	}
	var a = new DSGridObject("gridbox");
	a.setHeader("KAMAR");
	a.setColHeader("NO,KODE,NAMA KAMAR,LANTAI,UNIT,TEMPAT TIDUR,TEMPAT TIDUR BAYANGAN,STATUS AKTIF");
	a.setIDColHeader(",kode,nama,lantai,unit,,");
	a.setColWidth("30,50,160,50,160,100,120,100");
	a.setCellAlign("center,left,left,center,left,center,center,center");
	a.setCellHeight(20);
	a.setImgPath("../icon");
	a.setIDPaging("paging");
	a.attachEvent("onRowClick", "ambilData");
	a.onLoaded(cekData);
	a.baseURL("kamar_utils.php?grd=true");
	a.Init();

	var b = new DSGridObject("gridbox2");
	b.setHeader("TARIF KAMAR");
	b.setColHeader("NO,UNIT,NAMA KAMAR,KELAS,TARIF KAMAR,PENJAMIN");
	b.setIDColHeader(",unit,nama,kelas,,");
	b.setColWidth("30,200,200,200,200,200");
	b.setCellAlign("center,left,left,center,right,left");
	b.setCellHeight(20);
	b.setImgPath("../icon");
	b.setIDPaging("paging2");
	b.attachEvent("onRowClick", "ambilDataTarif");
	var sisipan = a.getRowId(a.getSelRow()).split("|");
	b.baseURL("kamar_utils.php?grd2=true&idKamar=0");
	b.Init();
</script>

</html>
<?php
mysql_close($konek);
?>