<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<script type="text/JavaScript" language="JavaScript" src="../include/jquery/jquery-1.9.1.js"></script>
<title>Referensi Umum</title>
</head>

<body>
<div align="center">
<?php
	include("../koneksi/konek.php");
	include("../header1.php");
/*$sCek="select * from b_ms_reference where stref=36";
$qCek=mysql_query($sCek);
$rwCek=mysql_fetch_array($qCek);
$cAktif=$rwCek['aktif'];*/
?>
<script>
var arrRange=depRange=[];
/*jQuery(document).ready(function(){
	//alert("");
});*/
</script>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/dsgrid_sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="0"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;FORM REFERENSI UMUM</td>
	</tr>
</table>
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="tabel" align="center">
	<tr>
		<td height="18" colspan="4">&nbsp;</td>
	</tr>
	<tr>
		<td width="5%">
		<td width="15%">&nbsp;</td>
		<td width="75%">&nbsp;</td>
		<td width="5%">&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="2" align="left">Referensi :&nbsp;&nbsp;&nbsp;<select id="ref" name="ref" onchange="pilih()" class="txtinput">
			<!--option value="">-- Pilih --</option-->
			<option value="Pendidikan">Pendidikan</option>
			<option value="Pekerjaan">Pekerjaan</option>
            <option value="Jenis Kepegawaian">Jenis Kepegawaian</option>
			<option value="Agama">Agama</option>
			<option value="Asal Rujukan">Asal Rujukan</option>
			<option value="Tujuan Rujukan">Tujuan Rujukan</option>
			<option value="Cara Keluar">Cara Keluar</option>
			<option value="Keadaan Keluar">Keadaan Keluar</option>
			<option value="Cara Bayar">Cara Bayar</option>
			<option value="Daftar Puskesmas">Daftar Puskesmas</option>
			<option value="Daftar RS Lain">Daftar RS Lain</option>
			<option value="Daftar Dokter Non RS">Daftar Dokter Non RS</option>
			<option value="Layanan Lain-Lain">Layanan Lain-Lain</option>
            <option value="Lantai">Lantai</option>
			<!--option value="Kelompok Pegawai">Kelompok Pegawai</option-->
			<!--option value="Data Pegawai">Data Pegawai</option-->
			</select></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td colspan="2">
		<!-- isi -->
			<!-- Pendidikan -->
			<div id="div_pendidikan" style="display:block">
				<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
					<tr height="30">
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td width="45%" valign="top">
										<form method="post">
											<table width="100%" cellpadding="0" cellspacing="0" border="0">
												<tr valign="top">
													<td width="30%">Pendidikan</td>
													<td width="10%" align="center">:</td>
													<td width="60%"><input size="32" id="txtpend" name="txtpend" class="txtinput"/></td>
												</tr>
												<tr valign="top">
													<!-- <td width="30%">Flag</td> -->
													<td width="10%" align="center">:</td>
													<td width="60%"><input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="32" tabindex="3" value="<?php echo $flag; ?>"/></td>
												</tr>
												<tr>
													<td>Status</td>
													<td align="center">:</td>
													<td><input type="checkbox" id="isAktif" name="isAktif" value="1" class="txtinput" />&nbsp;&nbsp;&nbsp;Aktif</td>
												</tr>
												<tr height="30">
													<td>&nbsp;</td>
													<td><input type="hidden" id="cmd" name="cmd" />
														<input type="hidden" name="id_pend" id="id_pend" /></td>
													<td>
														<input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="simpan(this.value,'txtpend');" class="tblTambah"/>
														<input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus"/>
														<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/>
													</td>
												</tr>
											</table>
										</form>							
									</td>
									<td width="5%">&nbsp;</td>
									<td width="50%" align="right">
										<div id="gridbox" style="width:450px; height:250px; background-color:white; overflow:hidden;"></div>
										<div id="paging" style="width:450px;"></div>							
									</td>				
								</tr>
							</table>				
						</td>
					</tr>
				</table>
			</div>
			
			<!-- Pekerjaan -->
			<div id="div_pekerjaan" style="display:none">
				<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
					<tr height="30">
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td width="45%" valign="top">
										<form method="post">
											<table width="100%" cellpadding="0" cellspacing="0" border="0">
												<tr valign="top">
													<td width="30%">Pekerjaan</td>
													<td width="10%" align="center">:</td>
													<td width="60%"><input size="32" id="txtkerj" name="txtkerj" class="txtinput" /></td>
												</tr>
												<tr valign="top">
													<!-- <td width="30%">Flag</td> -->
													<td width="10%" align="center">:</td>
													<td width="60%"><input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="32" tabindex="3" value="<?php echo $flag; ?>"/></td>
												</tr>
												<tr>
													<td>Status</td>
													<td align="center">:</td>
													<td><input type="checkbox" id="isAktif1" name="isAktif1" class="txtinput" />&nbsp;&nbsp;&nbsp;Aktif</td>
												</tr>
												<tr height="30">
													<td>&nbsp;</td>
													<td><input type="hidden" id="cmd1" name="cmd1" />
														<input type="hidden" name="id_kerj" id="id_kerj" /></td>
													<td><input type="button" id="btnSimpan1" name="btnSimpan1" value="Tambah" onclick="simpan(this.value,'txtkerj');" class="tblTambah" />
														<input type="button" id="btnHapus1" name="btnHapus1" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus" />
														<input type="button" id="btnBatal1" name="btnBatal1" value="Batal" onclick="batal()" class="tblBatal"/>
													</td>
												</tr>
											</table>
										</form>							
									</td>
									<td width="5%">&nbsp;</td>
									<td width="50%" align="right">
										<div id="gridbox1" style="width:450px; height:250px; background-color:white; overflow:hidden;"></div>
										<div id="paging1" style="width:450px;"></div>							
									</td>				
								</tr>
							</table>				
						</td>
					</tr>
				</table>
			</div>
            
            <!-- Jenis Kepegawaian -->
			<div id="div_jenis_kepegawaian" style="display:none">
				<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
					<tr height="30">
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td width="45%" valign="top">
										<form method="post">
											<table width="100%" cellpadding="0" cellspacing="0" border="0">
												<tr valign="top">
													<td width="30%">Jenis Kepegawaian</td>
													<td width="10%" align="center">:</td>
													<td width="60%"><input size="32" id="txt_JK" name="txt_JK" class="txtinput" /></td>
												</tr>
												<tr valign="top">
													<!-- <td width="30%">Flag</td> -->
													<td width="10%" align="center">:</td>
													<td width="60%"><input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="32" tabindex="3" value="<?php echo $flag; ?>"/></td>
												</tr>
												<tr>
													<td>Status</td>
													<td align="center">:</td>
													<td><input type="checkbox" id="isAktifJK" name="isAktifJK" class="txtinput" />&nbsp;&nbsp;&nbsp;Aktif</td>
												</tr>
												<tr height="30">
													<td>&nbsp;</td>
													<td><input type="hidden" id="cmd1" name="cmd1" />
														<input type="hidden" name="id_JK" id="id_JK" /></td>
													<td><input type="button" id="btnSimpanJK" name="btnSimpanJK" value="Tambah" onclick="simpan(this.value,'txt_JK');" class="tblTambah" />
														<input type="button" id="btnHapusJK" name="btnHapusJK" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus" />
														<input type="button" id="btnBatalJK" name="btnBatalJK" value="Batal" onclick="batal()" class="tblBatal"/>
													</td>
												</tr>
											</table>
										</form>							
									</td>
									<td width="5%">&nbsp;</td>
									<td width="50%" align="right">
										<div id="gridboxJK" style="width:450px; height:250px; background-color:white; overflow:hidden;"></div>
										<div id="pagingJK" style="width:450px;"></div>							
									</td>				
								</tr>
							</table>				
						</td>
					</tr>
				</table>
			</div>
			
			<!-- Agama -->
			<div id="div_agama" style="display:none">
				<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
					<tr height="30">
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td width="45%" valign="top">
										<form method="post">
											<table width="100%" cellpadding="0" cellspacing="0" border="0">
												<tr valign="top">
													<td width="30%">Agama</td>
													<td width="10%" align="center">:</td>
													<td width="60%"><input size="32" id="txtagm" name="txtagm" class="txtinput" /></td>
												</tr>
												<tr valign="top">
													<!-- <td width="30%">Flag</td> -->
													<td width="10%" align="center">:</td>
													<td width="60%"><input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="32" tabindex="3" value="<?php echo $flag; ?>"/></td>
												</tr>
												<tr>
													<td>Status</td>
													<td align="center">:</td>
													<td><input type="checkbox" id="isAktif2" name="isAktif2" class="txtinput" />&nbsp;&nbsp;&nbsp;Aktif</td>
												</tr>
												<tr height="30">
													<td>&nbsp;</td>
													<td><input type="hidden" id="cmd2" name="cmd2" />
														<input type="hidden" name="id_agm" id="id_agm" /></td>
													<td><input type="button" id="btnSimpan2" name="btnSimpan2" value="Tambah" onclick="simpan(this.value,'txtagm');" class="tblTambah" />
														<input type="button" id="btnHapus2" name="btnHapus2" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus" />
														<input type="button" id="btnBatal2" name="btnBatal2" value="Batal" onclick="batal()" class="tblBatal"/>
													</td>
												</tr>
											</table>
										</form>							
									</td>
									<td width="5%">&nbsp;</td>
									<td width="50%" align="right">
										<div id="gridbox2" style="width:450px; height:250px; background-color:white; overflow:hidden;"></div>
										<div id="paging2" style="width:450px;"></div>							
									</td>				
								</tr>
							</table>				
						</td>
					</tr>
				</table>
			</div>
	
			<!-- Asal Rujukan -->
			<div id="div_asal_rujukan" style="display:none">
				<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
					<tr height="30">
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td width="45%" valign="top">
										<form method="post">
											<table width="100%" cellpadding="0" cellspacing="0" border="0">
												<tr valign="top">
													<td width="30%">Asal Rujukan</td>
													<td width="10%" align="center">:</td>
													<td width="60%"><input size="32" id="txtasruj" name="txtasruj" class="txtinput"/></td>
												</tr>
												<tr valign="top">
													<!-- <td width="30%">Flag</td> -->
													<td width="10%" align="center">:</td>
													<td width="60%"><input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="32" tabindex="3" value="<?php echo $flag; ?>"/></td>
												</tr>
												<tr>
													<td>Status</td>
													<td align="center">:</td>
													<td><input type="checkbox" id="isAktif3" name="isAktif3" class="txtinput" />&nbsp;&nbsp;&nbsp;Aktif</td>
												</tr>
												<tr height="30">
													<td>&nbsp;</td>
													<td><input type="hidden" id="cmd3" name="cmd3" />
														<input type="hidden" name="id_asruj" id="id_asruj" /></td>
													<td><input type="button" id="btnSimpan3" name="btnSimpan3" value="Tambah" onclick="simpan(this.value,'txtasruj');" class="tblTambah" />
														<input type="button" id="btnHapus3" name="btnHapus3" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus" />
														<input type="button" id="btnBatal3" name="btnBatal3" value="Batal" onclick="batal()" class="tblBatal"/>
													</td>
												</tr>
											</table>
										</form>							
									</td>
									<td width="5%">&nbsp;</td>
									<td width="50%" align="right">
										<div id="gridbox3" style="width:450px; height:250px; background-color:white; overflow:hidden;"></div>
										<div id="paging3" style="width:450px;"></div>							
									</td>				
								</tr>
							</table>				
						</td>
					</tr>
				</table>
			</div>
			
			<!-- Tujuan Rujukan -->
			<div id="div_tujuan_rujukan" style="display:none">
				<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
					<tr height="30">
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td width="45%" valign="top">
										<form method="post">
											<table width="100%" cellpadding="0" cellspacing="0" border="0">
												<tr valign="top">
													<td width="30%">Tujuan Rujukan</td>
													<td width="10%" align="center">:</td>
													<td width="60%"><input size="32" id="txttujruj" name="txttujruj" class="txtinput" /></td>
												</tr>
												<tr valign="top">
													<!-- <td width="30%">Flag</td> -->
													<td width="10%" align="center">:</td>
													<td width="60%"><input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="32" tabindex="3" value="<?php echo $flag; ?>"/></td>
												</tr>
												<tr>
													<td>Status</td>
													<td align="center">:</td>
													<td><input type="checkbox" id="isAktif4" name="isAktif4" class="txtinput" />&nbsp;&nbsp;&nbsp;Aktif</td>
												</tr>
												<tr height="30">
													<td>&nbsp;</td>
													<td><input type="hidden" id="cmd4" name="cmd4" />
														<input type="hidden" name="id_tujruj" id="id_tujruj" /></td>
													<td><input type="button" id="btnSimpan4" name="btnSimpan4" value="Tambah" onclick="simpan(this.value,'txttujruj');" class="tblTambah" />
														<input type="button" id="btnHapus4" name="btnHapus4" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus" />
														<input type="button" id="btnBatal4" name="btnBatal4" value="Batal" onclick="batal()" class="tblBatal"/>
													</td>
												</tr>
											</table>
										</form>							
									</td>
									<td width="5%">&nbsp;</td>
									<td width="50%" align="right">
										<div id="gridbox4" style="width:450px; height:250px; background-color:white; overflow:hidden;"></div>
										<div id="paging4" style="width:450px;"></div>							
									</td>				
								</tr>
							</table>				
						</td>
					</tr>
				</table>
			</div>
	
			<!-- Cara Keluar -->
			<div id="div_cara_keluar" style="display:none">
				<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
					<tr height="30">
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td width="45%" valign="top">
										<form method="post">
											<table width="100%" cellpadding="0" cellspacing="0" border="0">
												<tr valign="top">
													<td width="30%">Cara Keluar</td>
													<td width="10%" align="center">:</td>
													<td width="60%"><input size="32" id="txtcrklr" name="txtcrklr" class="txtinput" /></td>
												</tr>
												<tr valign="top">
													<!-- <td width="30%">Flag</td> -->
													<td width="10%" align="center">:</td>
													<td width="60%"><input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="32" tabindex="3" value="<?php echo $flag; ?>"/></td>
												</tr>
												<tr>
													<td>Status</td>
													<td align="center">:</td>
													<td><input type="checkbox" id="isAktif5" name="isAktif5" class="txtinput" />&nbsp;&nbsp;&nbsp;Aktif</td>
												</tr>
												<tr height="30">
													<td>&nbsp;</td>
													<td><input type="hidden" id="cmd5" name="cmd5" />
														<input type="hidden" name="id_crklr" id="id_crklr" /></td>
													<td><input type="button" id="btnSimpan5" name="btnSimpan5" value="Tambah" onclick="simpan(this.value,'txtcrklr');" class="tblTambah" />
														<input type="button" id="btnHapus5" name="btnHapus5" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus" />
														<input type="button" id="btnBatal5" name="btnBatal5" value="Batal" onclick="batal()" class="tblBatal"/>
													</td>
												</tr>
											</table>
										</form>							
									</td>
									<td width="5%">&nbsp;</td>
									<td width="50%" align="right">
										<div id="gridbox5" style="width:450px; height:250px; background-color:white; overflow:hidden;"></div>
										<div id="paging5" style="width:450px;"></div>							
									</td>				
								</tr>
							</table>				
						</td>
					</tr>
				</table>
			</div>
			
			<!-- Keadaan Keluar -->
			<div id="div_keadaan_keluar" style="display:none">
				<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
					<tr height="30">
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td width="45%" valign="top">
										<form method="post">
											<table width="100%" cellpadding="0" cellspacing="0" border="0">
												<tr valign="top">
													<td width="30%">Keadaan Keluar</td>
													<td width="10%" align="center">:</td>
													<td width="60%"><input size="32" id="txtkdklr" name="txtkdklr" class="txtinput" /></td>
												</tr>
												<tr valign="top">
													<!-- <td width="30%">Flag</td> -->
													<td width="10%" align="center">:</td>
													<td width="60%"><input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="32" tabindex="3" value="<?php echo $flag; ?>"/></td>
												</tr>
												<tr>
													<td>Status</td>
													<td align="center">:</td>
													<td><input type="checkbox" id="isAktif6" name="isAktif6" class="txtinput" />&nbsp;&nbsp;&nbsp;Aktif</td>
												</tr>
												<tr height="30">
													<td>&nbsp;</td>
													<td><input type="hidden" id="cmd6" name="cmd6" />
														<input type="hidden" name="id_kdklr" id="id_kdklr" /></td>
													<td><input type="button" id="btnSimpan6" name="btnSimpan6" value="Tambah" onclick="simpan(this.value,'txtkdklr');" class="tblTambah" />
														<input type="button" id="btnHapus6" name="btnHapus6" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus" />
														<input type="button" id="btnBatal6" name="btnBatal6" value="Batal" onclick="batal()" class="tblBatal"/>
													</td>
												</tr>
											</table>
										</form>							
									</td>
									<td width="5%">&nbsp;</td>
									<td width="50%" align="right">
										<div id="gridbox6" style="width:450px; height:250px; background-color:white; overflow:hidden;"></div>
										<div id="paging6" style="width:450px;"></div>							
									</td>				
								</tr>
							</table>				
						</td>
					</tr>
				</table>
			</div>
			
			<!-- Cara Bayar -->
			<div id="div_cara_bayar" style="display:none">
				<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
					<tr height="30">
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td width="45%" valign="top">
										<form method="post">
											<table width="100%" cellpadding="0" cellspacing="0" border="0">
												<tr valign="top">
													<td width="30%">Cara Bayar</td>
													<td width="10%" align="center">:</td>
													<td width="60%"><input size="32" id="txtcrbyr" name="txtcrbyr" class="txtinput" /></td>
												</tr>
												<tr valign="top">
													<!-- <td width="30%">Flag</td> -->
													<td width="10%" align="center">:</td>
													<td width="60%"><input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="32" tabindex="3" value="<?php echo $flag; ?>"/></td>
												</tr>
												<tr>
													<td>Status</td>
													<td align="center">:</td>
													<td><input type="checkbox" id="isAktif7" name="isAktif7" class="txtinput" />&nbsp;&nbsp;&nbsp;Aktif</td>
												</tr>
												<tr height="30">
													<td>&nbsp;</td>
													<td><input type="hidden" id="cmd7" name="cmd7" />
														<input type="hidden" name="id_crbyr" id="id_crbyr" /></td>
													<td><input type="button" id="btnSimpan7" name="btnSimpan7" value="Tambah" onclick="simpan(this.value,'txtcrbyr');" class="tblTambah" />
														<input type="button" id="btnHapus7" name="btnHapus7" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus" />
														<input type="button" id="btnBatal7" name="btnBatal7" value="Batal" onclick="batal()" class="tblBatal"/>
													</td>
												</tr>
											</table>
										</form>							
									</td>
									<td width="5%">&nbsp;</td>
									<td width="50%" align="right">
										<div id="gridbox7" style="width:450px; height:250px; background-color:white; overflow:hidden;"></div>
										<div id="paging7" style="width:450px;"></div>							
									</td>				
								</tr>
							</table>				
						</td>
					</tr>
				</table>
			</div>
			
			<!-- Daftar Pusk -->
			<div id="div_daftar_pusk" style="display:none">
				<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
					<tr height="30">
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td width="45%" valign="top">
										<form method="post">
											<table width="100%" cellpadding="0" cellspacing="0" border="0">
												<tr valign="top">
													<td width="30%">Daftar Pusk</td>
													<td width="10%" align="center">:</td>
													<td width="60%"><input size="32" id="txtdftrpusk" name="txtdftrpusk" class="txtinput" /></td>
												</tr>
												<tr valign="top">
													<!-- <td width="30%">Flag</td> -->
													<td width="10%" align="center">:</td>
													<td width="60%"><input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="32" tabindex="3" value="<?php echo $flag; ?>"/></td>
												</tr>
												<tr>
													<td>Status</td>
													<td align="center">:</td>
													<td><input type="checkbox" id="isAktif8" name="isAktif8" class="txtinput" />&nbsp;&nbsp;&nbsp;Aktif</td>
												</tr>
												<tr height="30">
													<td>&nbsp;</td>
													<td><input type="hidden" id="cmd8" name="cmd8" />
														<input type="hidden" name="id_dftrpusk" id="id_dftrpusk" /></td>
														
													<td><input type="button" id="btnSimpan8" name="btnSimpan8" value="Tambah" onclick="simpan(this.value,'txtdftrpusk');" class="tblTambah"/>
														<input type="button" id="btnHapus8" name="btnHapus8" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus" />
														<input type="button" id="btnBatal8" name="btnBatal8" value="Batal" onclick="batal()" class="tblBatal"/>
													</td>
												</tr>
											</table>
										</form>							
									</td>
									<td width="5%">&nbsp;</td>
									<td width="50%" align="right">
										<div id="gridbox8" style="width:450px; height:250px; background-color:white; overflow:hidden;"></div>
										<div id="paging8" style="width:450px;"></div>							
									</td>				
								</tr>
							</table>				
						</td>
					</tr>
				</table>
			</div>
			
			<!-- Daftar RS Lain -->
			<div id="div_rs_lain" style="display:none">
				<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
					<tr height="30">
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td width="45%" valign="top">
										<form method="post">
											<table width="100%" cellpadding="0" cellspacing="0" border="0">
												<tr valign="top">
													<td width="30%">Daftar RS Lain</td>
													<td width="10%" align="center">:</td>
													<td width="60%"><input size="32" id="txtrsln" name="txtrsln" class="txtinput" /></td>
												</tr>
												<tr valign="top">
													<!-- <td width="30%">Flag</td> -->
													<td width="10%" align="center">:</td>
													<td width="60%"><input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="32" tabindex="3" value="<?php echo $flag; ?>"/></td>
												</tr>
												<tr>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td><input type="checkbox" id="isAktif9" name="isAktif9" class="txtinput" />&nbsp;&nbsp;&nbsp;Aktif</td>
												</tr>
												<tr height="30">
													<td>&nbsp;</td>
													<td><input type="hidden" id="cmd9" name="cmd9" />
														<input type="hidden" name="id_rsln" id="id_rsln" /></td>
														
													<td><input type="button" id="btnSimpan9" name="btnSimpan9" value="Tambah" onclick="simpan(this.value,'txtrsln');" class="tblTambah"/>
														<input type="button" id="btnHapus9" name="btnHapus9" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus" />
														<input type="button" id="btnBatal9" name="btnBatal9" value="Batal" onclick="batal()" class="tblBatal"/>
													</td>
												</tr>
											</table>
										</form>							
									</td>
									<td width="5%">&nbsp;</td>
									<td width="50%" align="right">
										<div id="gridbox9" style="width:450px; height:250px; background-color:white; overflow:hidden;"></div>
										<div id="paging9" style="width:450px;"></div>							
									</td>				
								</tr>
							</table>				
						</td>
					</tr>
				</table>
			</div>
			
			<!-- Daftar Dokter Non RS -->
			<div id="div_non_rs" style="display:none">
				<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
					<tr height="30">
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td width="45%" valign="top">
										<form method="post">
											<table width="100%" cellpadding="0" cellspacing="0" border="0">
												<tr valign="top">
													<td width="30%">Daftar Dokter Non RS</td>
													<td width="10%" align="center">:</td>
													<td width="60%"><input size="32" id="txtnonrs" name="txtnonrs" class="txtinput" /></td>
												</tr>
												<tr valign="top">
													<!-- <td width="30%">Flag</td> -->
													<td width="10%" align="center">:</td>
													<td width="60%"><input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="32" tabindex="3" value="<?php echo $flag; ?>"/></td>
												</tr>
												<tr>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td><input type="checkbox" id="isAktif10" name="isAktif10" class="txtinput" />&nbsp;&nbsp;&nbsp;Aktif</td>
												</tr>
												<tr height="30">
													<td>&nbsp;</td>
													<td><input type="hidden" id="cmd10" name="cmd10" />
														<input type="hidden" name="id_nonrs" id="id_nonrs" /></td>
													<td><input type="button" id="btnSimpan10" name="btnSimpan10" value="Tambah" onclick="simpan(this.value,'txtnonrs');" class="tblTambah"/>
														<input type="button" id="btnHapus10" name="btnHapus10" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus" />
														<input type="button" id="btnBatal10" name="btnBatal10" value="Batal" onclick="batal()" class="tblBatal"/>
													</td>
												</tr>
											</table>
										</form>							
									</td>
									<td width="5%">&nbsp;</td>
									<td width="50%" align="right">
										<div id="gridbox10" style="width:450px; height:250px; background-color:white; overflow:hidden;"></div>
										<div id="paging10" style="width:450px;"></div>							
									</td>				
								</tr>
							</table>				
						</td>
					</tr>
				</table>
			</div>
            
            	<div id="div_lantai" style="display:none">
				<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
					<tr height="30">
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td width="45%" valign="top">
										<form method="post">
											<table width="100%" cellpadding="0" cellspacing="0" border="0">
												<tr valign="top">
													<td width="30%">Lantai</td>
													<td width="10%" align="center">:</td>
													<td width="60%"><input size="32" id="txtlantai" name="txtlantai" class="txtinput"/></td>
												</tr>
												<tr valign="top">
													<!-- <td width="30%">Flag</td> -->
													<td width="10%" align="center">:</td>
													<td width="60%"><input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="32" tabindex="3" value="<?php echo $flag; ?>"/></td>
												</tr>
												<tr>
													<td>Status</td>
													<td align="center">:</td>
													<td><input type="checkbox" id="isAktifL" name="isAktifL" value="1" class="txtinput" />&nbsp;&nbsp;&nbsp;Aktif</td>
												</tr>
												<tr height="30">
													<td>&nbsp;</td>
													<td><input type="hidden" id="cmd" name="cmd" />
														<input type="hidden" name="id_lantai" id="id_lantai" /></td>
													<td>
														<input type="button" id="btnSimpanL" name="btnSimpanL" value="Tambah" onclick="simpan(this.value,'txtlantai');" class="tblTambah"/>
														<input type="button" id="btnHapusL" name="btnHapusL" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus" />
														<input type="button" id="btnBatalL" name="btnBatalL" value="Batal" onclick="batal()" class="tblBatal"/>
													</td>
												</tr>
											</table>
										</form>							
									</td>
									<td width="5%">&nbsp;</td>
									<td width="50%" align="right">
										<div id="gridbox55" style="width:450px; height:250px; background-color:white; overflow:hidden;"></div>
										<div id="paging55" style="width:450px;"></div>							
									</td>				
								</tr>
							</table>				
						</td>
					</tr>
				</table>
			</div>
			
			<!-- Layanan Lain-lain -->
			<div id="div_layanan_lain" style="display:none">
				<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
					<tr height="30">
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td width="45%" valign="top">
										<form method="post">
											<table width="100%" cellpadding="0" cellspacing="0" border="0">
												<tr valign="top">
													<td width="30%">Layanan Lain-Lain</td>
													<td width="10%" align="center">:</td>
													<td width="60%"><input size="32" id="txtlain" name="txtlain" class="txtinput" /></td>
												</tr>
												<tr valign="top">
													<!-- <td width="30%">Flag</td> -->
													<td width="10%" align="center">:</td>
													<td width="60%"><input type="hidden" disabled class="txtinputreg" name="flag" id="flag" size="32" tabindex="3" value="<?php echo $flag; ?>"/></td>
												</tr>
												<tr>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td><input type="checkbox" id="isAktif11" name="isAktif11" class="txtinput" />&nbsp;&nbsp;&nbsp;Aktif</td>
												</tr>
												<tr height="30">
													<td>&nbsp;</td>
													<td><input type="hidden" id="cmd11" name="cmd11" />
														<input type="hidden" name="id_lain" id="id_lain" /></td>
													<td><input type="button" id="btnSimpan11" name="btnSimpan11" value="Tambah" onclick="simpan(this.value,'txtlain');" class="tblTambah" />
														<input type="button" id="btnHapus11" name="btnHapus11" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus" />
														<input type="button" id="btnBatal11" name="btnBatal11" value="Batal" onclick="batal()" class="tblBatal"/>
													</td>
												</tr>
											</table>
										</form>							
									</td>
									<td width="5%">&nbsp;</td>
									<td width="50%" align="right">
										<div id="gridbox11" style="width:450px; height:250px; background-color:white; overflow:hidden;"></div>
										<div id="paging11" style="width:450px;"></div>							
									</td>				
								</tr>
								
							</table>				
						</td>
					</tr>
					
				</table>
			</div>
			
			<!-- Kelompok Pegawai -->
			<!--div id="div_klp_peg" style="display:none">
				<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
					<tr height="30">
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<table width="100%" cellpadding="0" cellspacing="0" border="0">
								<tr>
									<td width="45%" valign="top">
										<form method="post">
											<table width="100%" cellpadding="0" cellspacing="0" border="0">
												<tr>
													<td>Kode</td>
													<td align="center">:</td>
													<td><input size="12" id="txtkode" name="txtkode" /></td>
												</tr>
												<tr valign="top">
													<td width="30%">Nama</td>
													<td width="10%" align="center">:</td>
													<td width="60%"><input size="32" id="txtnmklp" name="txtnmklp" /></td>
												</tr>
												<tr>
													<td>Status</td>
													<td align="center">:</td>
													<td><input type="checkbox" id="isAktif12" name="isAktif12" value="1" />&nbsp;&nbsp;&nbsp;Aktif</td>
												</tr>
												<tr height="30">
													<td colspan="3" align="right">
														<input type="hidden" id="cmd12" name="cmd12" />
														<input type="hidden" name="id_klp_peg" id="id_klp_peg" />
														<input type="button" id="btnSimpan12" name="btnSimpan12" value="Tambah" onclick="simpan(this.value);" class="tblTambah"/>
														<input type="button" id="btnHapus12" name="btnHapus12" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus"/>
														<input type="button" id="btnBatal12" name="btnBatal12" value="Batal" onclick="batal()" class="tblBatal"/>													</td>
												</tr>
											</table>
										</form>							
									</td>
									<td width="5%">&nbsp;</td>
									<td width="50%" align="right">
										<div id="gridbox12" style="width:450px; height:250px; background-color:white; overflow:hidden;"></div>
										<div id="paging12" style="width:450px;"></div>							
									</td>				
								</tr>
							</table>				
						</td>
					</tr>
				</table>
			</div-->
			
			<!-- Data Pegawai -->
			<!--div id="div_peg" style="display:none">
				<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
					<tr height="30">
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<table width="100%" cellpadding="1" cellspacing="0" border="0">
								<tr>
									<td width="20%" align="right">N.I.P&nbsp;:</td>
									<td width="25%">&nbsp;&nbsp;&nbsp;<input id="txtnip" name="txtnip" size="24" /></td>
									<td width="5%">&nbsp;</td>
									<td width="25%" align="right">Nama Orang Tua&nbsp;:</td>	
									<td width="25%">&nbsp;&nbsp;&nbsp;<input id="txtOrtu" name="txtOrtu" size="24" /></td>			
								</tr>
								<tr>
									<td align="right">Nama&nbsp;:</td>
									<td>&nbsp;&nbsp;&nbsp;<input id="txtnama" name="txtnama" size="24" /></td>
									<td>&nbsp;</td>
									<td align="right">Alamat Orang Tua&nbsp;:</td>
									<td rowspan="2">&nbsp;&nbsp;&nbsp;<textarea id="txtAlmtOrtu" name="txtAlmtOrtu" cols="20"></textarea></td>
								</tr>
								<tr>
									<td align="right">Jenis Kelamin&nbsp;:</td>
									<td>&nbsp;&nbsp;&nbsp;<select id="cmbSex" name="cmbSex">
										<option value="L">Laki-Laki</option>
										<option value="P">Perempuan</option>
										</select></td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="right">Agama&nbsp;:</td>
									<td>&nbsp;&nbsp;&nbsp;<select id="cmbAgm" name="cmbAgm">
										<option value="1">Islam</option>
										<option value="2">Kristen</option>
										<option value="3">Protestan</option>
										<option value="4">Budha</option>
										<option value="5">Hindu</option>
										</select></td>
									<td>&nbsp;</td>
									<td align="right">Nama Suami/Istri&nbsp;:</td>
									<td>&nbsp;&nbsp;&nbsp;<input id="txtNmSI" name="txtNmSI" size="24" /></td>
								</tr>
								<tr>
									<td align="right">Tanggal Lahir&nbsp;:</td>
									<td>&nbsp;&nbsp;&nbsp;<input id="txtLahir" name="txtLahir" size="16" type="text" readonly="readonly" class="txtcenter" />&nbsp;<input type="button" name="btnTgl" value="V" class="txtcenter" onclick="gfPop.fPopCalendar(document.getElementById('txtLahir'),depRange);" />
									</td>
									<td>&nbsp;</td>
									<td align="right">Unit&nbsp;:</td>
									<td>&nbsp;&nbsp;&nbsp;<select id="cmbUnit" name="cmbUnit">
										<?php
											$rs = mysql_query("SELECT * FROM b_ms_unit WHERE aktif = 1");
											while($rows = mysql_fetch_array($rs)):
										?>
										<option value="<?=$rows["id"];?>"><?=$rows["nama"];?></option>
										<?php
											endwhile;
										?>
										</select></td>
								</tr>
								<tr>
									<td align="right">Alamat&nbsp;:</td>
									<td rowspan="2">&nbsp;&nbsp;&nbsp;<textarea cols="20" id="txtAlmt" name="txtAlmt"></textarea></td>
									<td>&nbsp;</td>
									<td align="right">Kelompok&nbsp;:</td>
									<td>&nbsp;&nbsp;&nbsp;<select id="cmbKel" name="cmbKel">
										<?php
											$rs1 = mysql_query("SELECT * FROM b_ms_kelompok WHERE aktif = 1");
											while($rows1 = mysql_fetch_array($rs1)):
										?>
										<option value="<?=$rows1["id"];?>"><?=$rows1["nama"];?></option>
										<?php
											endwhile;
										?>
										</select></td>
								</tr>
								<tr>
								  <td align="right">&nbsp;</td>
									<td>&nbsp;</td>
									<td align="right">&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="right">No Telepon&nbsp;:</td>
									<td>&nbsp;&nbsp;&nbsp;<input id="txtTlp" name="txtTlp" size="24" /></td>
									<td>&nbsp;</td>
									<td align="right">Username&nbsp;:</td>
									<td>&nbsp;&nbsp;&nbsp;<input id="txtUser" name="txtUser" size="24" /></td>
								</tr>
								<tr>
									<td align="right">No Handphone&nbsp;:</td>
									<td>&nbsp;&nbsp;&nbsp;<input id="txtHp" name="txtHp" size="24" /></td>
									<td>&nbsp;</td>
									<td align="right">Password&nbsp;:</td>
									<td>&nbsp;&nbsp;&nbsp;<input id="txtPwd" name="txtPwd" size="24" /></td>
								</tr>
								<tr>
									<td align="right">Status Pernikahan&nbsp;:</td>
									<td>&nbsp;&nbsp;&nbsp;<select id="cmbStsKwn" name="cmbStsKwn">
										<option value="0">Single</option>
										<option value="1">Menikah</option>
									</select></td>
									<td>&nbsp;</td>
									<td align="right">Status&nbsp;:</td>
									<td>&nbsp;&nbsp;&nbsp;<input type="checkbox" id="isAktif13" name="isAktif13" />&nbsp;Aktif</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td colspan="3" align="center">
										<input type="hidden" id="cmd13" name="cmd13" />&nbsp;
										<input type="hidden" name="id_peg" id="id_peg" />&nbsp;
										<input type="button" id="btnSimpan13" name="btnSimpan13" value="Tambah" onclick="simpan(this.value);" class="tblTambah"/>
										<input type="button" id="btnHapus13" name="btnHapus13" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus"/>
										<input type="button" id="btnBatal13" name="btnBatal13" value="Batal" onclick="batal()" class="tblBatal"/>		
									</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td colspan="5">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="5">
										<div id="gridbox13" style="width:925px; height:250px; background-color:white; overflow:hidden;"></div>
										<div id="paging13" style="width:925px;"></div>
									</td>
								</tr>
							</table>				
						</td>
					</tr>
				</table>
			</div-->
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000" align="center">
	<tr height="30">
		<td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" class="btninput" /></td>
		<td align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" class="btninput" /></a>&nbsp;</td>
	</tr>
</table>
</div>

<script>
	function simpan(action,cek)
	{
		if(ValidateForm(cek,'ind'))
		{
			var ref = document.getElementById("ref").value;
			
			//var id_klp_peg = document.getElementById("id_klp_peg").value;
			//var id_peg = document.getElementById("id_peg").value;
			//var kode = document.getElementById("txtkode").value;
			//var nama = document.getElementById("txtnmklp").value;
			var id_pend = document.getElementById("id_pend").value;
			var pend = document.getElementById("txtpend").value;
			
			var id_lantai = document.getElementById("id_lantai").value;
			var lantai = document.getElementById("txtlantai").value;
			
			var id_kerj = document.getElementById("id_kerj").value;
			var kerj = document.getElementById("txtkerj").value;
			
			var id_agm = document.getElementById("id_agm").value;
			var agm = document.getElementById("txtagm").value;
			
			var id_asruj = document.getElementById("id_asruj").value;
			var asruj = document.getElementById("txtasruj").value;
			
			var id_tujruj = document.getElementById("id_tujruj").value;
			var tujruj = document.getElementById("txttujruj").value;
			
			var id_crklr = document.getElementById("id_crklr").value;
			var crklr = document.getElementById("txtcrklr").value;
			
			var id_kdklr = document.getElementById("id_kdklr").value;
			var kdklr = document.getElementById("txtkdklr").value;
			
			var id_crbyr = document.getElementById("id_crbyr").value;
			var crbyr = document.getElementById("txtcrbyr").value;
			
			var id_dftrpusk = document.getElementById("id_dftrpusk").value;
			var dftrpusk = document.getElementById("txtdftrpusk").value;
			
			var id_rsln = document.getElementById("id_rsln").value;
			var txtrsln = document.getElementById("txtrsln").value; 
			
			var id_nonrs = document.getElementById("id_nonrs").value;
			var nonrs = document.getElementById("txtnonrs").value;
			
			var id_lain = document.getElementById("id_lain").value;
			var lain = document.getElementById("txtlain").value;
			
			var id_JK = document.getElementById("id_JK").value;
			var txt_JK = document.getElementById("txt_JK").value;

			var flag = document.getElementById("flag").value;
			
			/*var nip = document.getElementById("txtnip").value;
			var ortu = document.getElementById("txtOrtu").value;
			var nm = document.getElementById("txtnama").value;
			var almt_ortu = document.getElementById("txtAlmtOrtu").value;
			var sex = document.getElementById("cmbSex").value;
			var agm = document.getElementById("cmbAgm").value;
			var nmsi = document.getElementById("txtNmSI").value;
			var lahir = document.getElementById("txtLahir").value;
			var almt = document.getElementById("txtAlmt").value;
			var stskwn = document.getElementById("cmbStsKwn").value;
			var tlp = document.getElementById("txtTlp").value;
			var user = document.getElementById("txtUser").value;
			var hp = document.getElementById("txtHp").value;
			var cmbunit = document.getElementById("cmbUnit").value;
			var klp = document.getElementById("cmbKel").value;
			var pwd = document.getElementById("txtPwd").value;*/
			
			var aktif_pend = 0;
			if(document.getElementById('isAktif').checked==true)
			{
				aktif_pend = 1;
			}
			
			var aktif_lantai = 0;
			if(document.getElementById('isAktifL').checked==true)
			{
				aktif_lantai = 1;
			}
			
			var aktif_kerj = 0;
			if(document.getElementById('isAktif1').checked==true)
			{
				aktif_kerj = 1;
			}
			
			var aktif_agm = 0;
			if(document.getElementById('isAktif2').checked==true)
			{
				aktif_agm = 1;
			}
			
			var aktif_asruj = 0;
			if(document.getElementById('isAktif3').checked==true)
			{
				aktif_asruj = 1;
			}
			
			var aktif_tujruj = 0;
			if(document.getElementById('isAktif4').checked==true)
			{
				aktif_tujruj = 1;
			}
			
			var aktif_crklr = 0;
			if(document.getElementById('isAktif5').checked==true)
			{
				aktif_crklr = 1;
			}
			
			var aktif_kdklr = 0;
			if(document.getElementById('isAktif6').checked==true)
			{
				aktif_kdklr = 1;
			}
			
			var aktif_crbyr = 0;
			if(document.getElementById('isAktif7').checked==true)
			{
				aktif_crbyr = 1;
			}
			
			var aktif_dftrpusk = 0;
			if(document.getElementById('isAktif8').checked==true)
			{
				aktif_dftrpusk = 1;
			}
			
			var aktif_rsln = 0;
			if(document.getElementById('isAktif9').checked==true)
			{
				aktif_rsln = 1;
			}
			
			var aktif_nonrs = 0;
			if(document.getElementById('isAktif10').checked==true)
			{
				aktif_nonrs = 1;
			}
			
			var aktif_lain = 0;
			if(document.getElementById('isAktif11').checked==true)
			{
				aktif_lain = 1;
			}
			
			var aktif_JK = 0;
			if(document.getElementById('isAktifJK').checked==true)
			{
				aktif_JK = 1;
			}
			
			
			/*var aktif_klp_peg = 0;
			if(document.getElementById('isAktif12').checked==true)
			{
				aktif_klp_peg = 1;
			}
			
			var aktif_peg = 0;
			if(document.getElementById('isAktif13').checked==true)
			{
				aktif_peg = 1;
			}*/
			
			
			switch(ref)
			{
				case 'Pendidikan':
				a.loadURL("m_umum_utils.php?grd=true&act="+action+"&ref="+ref+"&id="+id_pend+"&nama="+pend+"&flag="+flag+"&aktif="+aktif_pend,"","GET");
				break;
				
				case 'Pekerjaan':
				//alert("m_umum_utils.php?grd1=true&act="+action+"&ref="+ref+"&id="+id_kerj+"&nama="+kerj+"&aktif="+aktif_kerj);
				b.loadURL("m_umum_utils.php?grd1=true&act="+action+"&ref="+ref+"&id="+id_kerj+"&flag="+flag+"&nama="+kerj+"&aktif="+aktif_kerj,"","GET");
				break;
				
				case 'Agama':
				//alert("m_umum_utils.php?grd2=true&act="+action+"&ref="+ref+"&id="+id_agm+"&agm="+agm+"&aktif="+aktif_agm);
				c.loadURL("m_umum_utils.php?grd2=true&act="+action+"&ref="+ref+"&id="+id_agm+"&flag="+flag+"&agm="+agm+"&aktif="+aktif_agm,"","GET");
				break;
				
				case 'Asal Rujukan':
				d.loadURL("m_umum_utils.php?grd3=true&act="+action+"&ref="+ref+"&id="+id_asruj+"&flag="+flag+"&nama="+asruj+"&aktif="+aktif_asruj,"","GET");
				break;
				
				case 'Tujuan Rujukan':
				e.loadURL("m_umum_utils.php?grd4=true&act="+action+"&ref="+ref+"&id="+id_tujruj+"&flag="+flag+"&nama="+tujruj+"&aktif="+aktif_tujruj,"","GET");
				break;
				
				case 'Cara Keluar':
				f.loadURL("m_umum_utils.php?grd5=true&act="+action+"&ref="+ref+"&id="+id_crklr+"&flag="+flag+"&nama="+crklr+"&aktif="+aktif_crklr,"","GET");
				break;
				
				case 'Keadaan Keluar':
				g.loadURL("m_umum_utils.php?grd6=true&act="+action+"&ref="+ref+"&id="+id_kdklr+"&flag="+flag+"&nama="+kdklr+"&aktif="+aktif_kdklr,"","GET");
				break;
				
				case 'Cara Bayar':
				h.loadURL("m_umum_utils.php?grd7=true&act="+action+"&ref="+ref+"&id="+id_crbyr+"&flag="+flag+"&nama="+crbyr+"&aktif="+aktif_crbyr,"","GET");
				break;
				
				case 'Daftar Puskesmas':
				i.loadURL("m_umum_utils.php?grd8=true&act="+action+"&ref="+ref+"&id="+id_dftrpusk+"&flag="+flag+"&nama="+dftrpusk+"&aktif="+aktif_dftrpusk,"","GET");
				break;
				
				case 'Daftar RS Lain':
				j.loadURL("m_umum_utils.php?grd9=true&act="+action+"&ref="+ref+"&id="+id_rsln+"&flag="+flag+"&nama="+txtrsln+"&aktif="+aktif_rsln,"","GET");
				break;
				
				case 'Daftar Dokter Non RS':
				k.loadURL("m_umum_utils.php?grd10=true&act="+action+"&ref="+ref+"&id="+id_nonrs+"&flag="+flag+"&nama="+nonrs+"&aktif="+aktif_nonrs,"","GET");
				break;
				
				case 'Layanan Lain-Lain':
				l.loadURL("m_umum_utils.php?grd11=true&act="+action+"&ref="+ref+"&id="+id_lain+"&flag="+flag+"&nama="+lain+"&aktif="+aktif_lain,"","GET");
				break;
				
				case 'Jenis Kepegawaian':
				JK.loadURL("m_umum_utils.php?grdJK=true&act="+action+"&ref="+ref+"&id="+id_JK+"&flag="+flag+"&nama="+txt_JK+"&aktif="+aktif_JK,"","GET");
				break;
				
				case 'Lantai':
				LN.loadURL("m_lantai_utils.php?grdLantai=true&act="+action+"&ref="+ref+"&id="+id_lantai+"&flag="+flag+"&nama="+lantai+"&aktif="+aktif_lantai,"","GET");
				break;			
				
				/*case 'Kelompok Pegawai':
				m.loadURL("m_umum_utils.php?grd12=true&act="+action+"&ref="+ref+"&id="+id_klp_peg+"&kode="+kode+"&nama="+nama+"&aktif="+aktif_klp_peg,"","GET");
				break;
				
				/*case 'Data Pegawai':
				//alert("m_umum_utils.php?grd13=true&act="+action+"&ref="+ref+"&id="+id_peg+"&nip="+nip+"&ortu="+ortu+"&nama="+nm+"&almt_ortu="+almt_ortu+"&sex="+sex+"&agm="+agm+"&nmsi="+nmsi+"&lahir="+lahir+"&almt="+almt+"&stskwn="+stskwn+"&tlp="+tlp+"&user="+user+"&hp="+hp+"&cmbunit="+cmbunit+"&klp="+klp+"&pwd="+pwd+"&aktif="+aktif_peg);
				n.loadURL("m_umum_utils.php?grd13=true&act="+action+"&ref="+ref+"&id="+id_peg+"&nip="+nip+"&ortu="+ortu+"&nama="+nm+"&almt_ortu="+almt_ortu+"&sex="+sex+"&agm="+agm+"&nmsi="+nmsi+"&lahir="+lahir+"&almt="+almt+"&stskwn="+stskwn+"&tlp="+tlp+"&user="+user+"&hp="+hp+"&cmbunit="+cmbunit+"&klp="+klp+"&pwd="+pwd+"&aktif="+aktif_peg,"","GET");
				break;*/
			}
			
			//document.getElementById("txtkode").value = '';
			//document.getElementById("txtnmklp").value = '';
			document.getElementById("isAktif").checked = false;
			document.getElementById("txtpend").value = '';
			//document.getElementById("txtpend").checked = false;
			
			document.getElementById("isAktifL").checked = false;
			document.getElementById("txtlantai").value = '';
			
			document.getElementById("txtkerj").value = '';
			document.getElementById("isAktif1").checked = false;
			
			document.getElementById("txtagm").value = '';
			document.getElementById("isAktif2").checked = false;
			
			document.getElementById("txtasruj").value = '';
			document.getElementById("isAktif3").checked = false;
			
			document.getElementById("txttujruj").value = '';
			document.getElementById("isAktif4").checked = false;
			
			document.getElementById("txtcrklr").value = '';
			document.getElementById("isAktif5").checked = false;
			
			document.getElementById("txtkdklr").value = '';
			document.getElementById("isAktif6").checked = false;
			
			document.getElementById("txtcrbyr").value = '';
			document.getElementById("isAktif7").checked = false;
			
			document.getElementById("txtdftrpusk").value = '';
			document.getElementById("isAktif8").checked = false;
			
			document.getElementById("txtrsln").value = '';
			document.getElementById("isAktif9").checked = false;
			
			document.getElementById("txtnonrs").value = '';
			document.getElementById("isAktif10").checked = false;
			
			document.getElementById("txtlain").value = '';
			document.getElementById("isAktif11").checked = false;
			
			document.getElementById("txt_JK").value = '';
			document.getElementById("isAktifJK").checked = false;
			batal();
		}
							
	}
	
	function ambilData()
	{
		var p="id_pend*-*"+(a.getRowId(a.getSelRow()))+"*|*txtpend*-*"+a.cellsGetValue(a.getSelRow(),2)+"*|*isAktif*-*"+((a.cellsGetValue(a.getSelRow(),3)=='Aktif')?'true':'false')+"*|*btnSimpan*-*Simpan*|*btnHapus*-*false";
		fSetValue(window,p);
	}
	
	function ambilData1()
	{
		var p="id_kerj*-*"+(b.getRowId(b.getSelRow()))+"*|*txtkerj*-*"+b.cellsGetValue(b.getSelRow(),2)+"*|*isAktif1*-*"+((b.cellsGetValue(b.getSelRow(),3)=='Aktif')?'true':'false')+"*|*btnSimpan1*-*Simpan*|*btnHapus1*-*false";
		fSetValue(window,p);
	}
	
	function ambilData2()
	{
		var p="id_agm*-*"+(c.getRowId(c.getSelRow()))+"*|*txtagm*-*"+c.cellsGetValue(c.getSelRow(),2)+"*|*isAktif2*-*"+((c.cellsGetValue(c.getSelRow(),3)=='Aktif')?'true':'false')+"*|*btnSimpan2*-*Simpan*|*btnHapus2*-*false";
		fSetValue(window,p);
	}
	
	function ambilData3()
	{
		var p="id_asruj*-*"+(d.getRowId(d.getSelRow()))+"*|*txtasruj*-*"+d.cellsGetValue(d.getSelRow(),2)+"*|*isAktif3*-*"+((d.cellsGetValue(d.getSelRow(),3)=='Aktif')?'true':'false')+"*|*btnSimpan3*-*Simpan*|*btnHapus3*-*false";
		fSetValue(window,p);
	}
	
	function ambilData4()
	{
		var p="id_tujruj*-*"+(e.getRowId(e.getSelRow()))+"*|*txttujruj*-*"+e.cellsGetValue(e.getSelRow(),2)+"*|*isAktif4*-*"+((e.cellsGetValue(e.getSelRow(),3)=='Aktif')?'true':'false')+"*|*btnSimpan4*-*Simpan*|*btnHapus4*-*false";
		fSetValue(window,p);
	}
	
	function ambilData5()
	{
		var p="id_crklr*-*"+(f.getRowId(f.getSelRow()))+"*|*txtcrklr*-*"+f.cellsGetValue(f.getSelRow(),2)+"*|*isAktif5*-*"+((f.cellsGetValue(f.getSelRow(),3)=='Aktif')?'true':'false')+"*|*btnSimpan5*-*Simpan*|*btnHapus5*-*false";
		fSetValue(window,p);
	}
	
	function ambilData6()
	{
		var p="id_kdklr*-*"+(g.getRowId(g.getSelRow()))+"*|*txtkdklr*-*"+g.cellsGetValue(g.getSelRow(),2)+"*|*isAktif6*-*"+((g.cellsGetValue(g.getSelRow(),3)=='Aktif')?'true':'false')+"*|*btnSimpan6*-*Simpan*|*btnHapus6*-*false";
		fSetValue(window,p);
	}
	
	function ambilData7()
	{
		var p="id_crbyr*-*"+(h.getRowId(h.getSelRow()))+"*|*txtcrbyr*-*"+h.cellsGetValue(h.getSelRow(),2)+"*|*isAktif7*-*"+((h.cellsGetValue(h.getSelRow(),3)=='Aktif')?'true':'false')+"*|*btnSimpan7*-*Simpan*|*btnHapus7*-*false";
		fSetValue(window,p);
	}
	
	function ambilData8()
	{
		var p="id_dftrpusk*-*"+(i.getRowId(i.getSelRow()))+"*|*txtdftrpusk*-*"+i.cellsGetValue(i.getSelRow(),2)+"*|*isAktif8*-*"+((i.cellsGetValue(i.getSelRow(),3)=='Aktif')?'true':'false')+"*|*btnSimpan8*-*Simpan*|*btnHapus8*-*false";
		fSetValue(window,p);
		document.getElementById('btnHapus8').disabled=false;
	}
	
		function ambilData9()
	{
		var p="id_rsln*-*"+(j.getRowId(j.getSelRow()))+"*|*txtrsln*-*"+j.cellsGetValue(j.getSelRow(),2)+"*|*isAktif9*-*"+((j.cellsGetValue(i.getSelRow(),3)=='Aktif')?'true':'false')+"*|*btnSimpan9*-*Simpan*|*btnHapus9*-*false";
		fSetValue(window,p);
		document.getElementById('btnHapus9').disabled=false;
	}
	
	function ambilData10()
	{
		var p="id_nonrs*-*"+(k.getRowId(k.getSelRow()))+"*|*txtnonrs*-*"+k.cellsGetValue(k.getSelRow(),2)+"*|*isAktif10*-*"+((k.cellsGetValue(k.getSelRow(),3)=='Aktif')?'true':'false')+"*|*btnSimpan10*-*Simpan*|*btnHapus10*-*false";
		fSetValue(window,p);
		document.getElementById('btnHapus10').disabled=false;
	}
	
	function ambilData11()
	{
		var p="id_lain*-*"+(l.getRowId(l.getSelRow()))+"*|*txtlain*-*"+l.cellsGetValue(l.getSelRow(),2)+"*|*isAktif11*-*"+((l.cellsGetValue(l.getSelRow(),3)=='Aktif')?'true':'false')+"*|*btnSimpan11*-*Simpan*|*btnHapus11*-*false";
		fSetValue(window,p);
	}
	
	function ambilDataJK()
	{
		var p="id_JK*-*"+(JK.getRowId(JK.getSelRow()))+"*|*txt_JK*-*"+JK.cellsGetValue(JK.getSelRow(),2)+"*|*isAktifJK*-*"+((JK.cellsGetValue(JK.getSelRow(),3)=='Aktif')?'true':'false')+"*|*btnSimpanJK*-*Simpan*|*btnHapusJK*-*false";
		fSetValue(window,p);
	}
	
	function ambilDataLN()
	{
		//alert(LN.getRowId(LN.getSelRow())+"\n"+LN.cellsGetValue(LN.getSelRow(),3));
		var p="id_lantai*-*"+(LN.getRowId(LN.getSelRow()))+"*|*txtlantai*-*"+LN.cellsGetValue(LN.getSelRow(),2)+"*|*isAktifL*-*"+((LN.cellsGetValue(LN.getSelRow(),3)=='Aktif')?'true':'false')+"*|*btnSimpanL*-*Simpan*|*btnHapusL*-*true";
		fSetValue(window,p);
		jQuery("#btnHapusL").removeAttr("disabled");
	}
	
	/*function ambilData12()
	{
		var q="id_klp_peg*-*"+(m.getRowId(m.getSelRow()))+"*|*txtkode*-*"+m.cellsGetValue(m.getSelRow(),2)+"*|*txtnmklp*-*"+m.cellsGetValue(m.getSelRow(),3)+"*|*isAktif12*-*"+((m.cellsGetValue(m.getSelRow(),4)=='Aktif')?'true':'false')+"*|*btnSimpan12*-*Simpan*|*btnHapus12*-*false";
		fSetValue(window,q);
	}
	
	/*function ambilData13()
	{
		var r="id_peg*-*"+(n.getRowId(n.getSelRow()))+"*|*txtnip*-*"+n.cellsGetValue(n.getSelRow(),2)+"*|*txtnama*-*"+n.cellsGetValue(n.getSelRow(),3)+"*|*cmbSex*-*"+n.cellsGetValue(n.getSelRow(),4)+"*|*cmbAgm*-*"+n.cellsGetValue(n.getSelRow(),5)+"*|*txtLahir*-*"+n.cellsGetValue(n.getSelRow(),6)+"*|*txtAlmt*-*"+n.cellsGetValue(n.getSelRow(),7)+"*|*txtTlp*-*"+n.cellsGetValue(n.getSelRow(),8)+"*|*txtHp*-*"+n.cellsGetValue(n.getSelRow(),9)+"*|*cmbStsKwn*-*"+n.cellsGetValue(n.getSelRow(),10)+"*|*txtOrtu*-*"+n.cellsGetValue(n.getSelRow(),11)+"*|*txtAlmtOrtu*-*"+n.cellsGetValue(n.getSelRow(),12)+"*|*txtNmSI*-*"+n.cellsGetValue(n.getSelRow(),13)+"*|*txtUser*-*"+n.cellsGetValue(n.getSelRow(),14)+"*|*txtPwd*-*"+n.cellsGetValue(n.getSelRow(),15)+"*|*cmbUnit*-*"+n.cellsGetValue(n.getSelRow(),16)+"*|*cmbKel*-*"+n.cellsGetValue(n.getSelRow(),17)+"*|*isAktif13*-*"+((n.cellsGetValue(n.getSelRow(),18)=='Aktif')?'true':'false')+"*|*btnSimpan13*-*Simpan*|*btnHapus13*-*false";
		fSetValue(window,r);
	}*/
	
	
	
	function hapus()
	{
		var ref = document.getElementById("ref").value;
		var rowid = document.getElementById("id_pend").value;
		var rowid1 = document.getElementById("id_kerj").value;
		var rowid2 = document.getElementById("id_agm").value;
		var rowid3 = document.getElementById("id_asruj").value;
		var rowid4 = document.getElementById("id_tujruj").value;
		var rowid5 = document.getElementById("id_crklr").value;
		var rowid6 = document.getElementById("id_kdklr").value;
		var rowid7 = document.getElementById("id_crbyr").value;
		var rowid8 = document.getElementById("id_dftrpusk").value;
		var rowid9 = document.getElementById("id_rsln").value;
		var rowid10 = document.getElementById("id_nonrs").value;
		var rowid11 = document.getElementById("id_lain").value;	
		var id_JK = document.getElementById("id_JK").value;
		var id_lantai = document.getElementById("id_lantai").value;			
		//var rowid12 = document.getElementById("id_klp_peg").value;
		//var rowid13 = document.getElementById("id_peg").value;
		
		switch(ref)
		{
			case 'Pendidikan':
			if(confirm("Anda yakin menghapus Pendidikan "+a.cellsGetValue(a.getSelRow(),2)))
			{
				a.loadURL("m_umum_utils.php?grd=true&act=hapus&ref="+ref+"&rowid="+rowid,"","GET");
			}
			batal();
			break;
			
			case 'Pekerjaan':
			if(confirm("Anda yakin menghapus Pekerjaan "+b.cellsGetValue(b.getSelRow(),2)))
			{
				b.loadURL("m_umum_utils.php?grd1=true&act=hapus&ref="+ref+"&rowid="+rowid1,"","GET");
			}
			batal();
			break;
			
			case 'Agama':
			if(confirm("Anda yakin menghapus Agama "+c.cellsGetValue(c.getSelRow(),2)))
			{
				c.loadURL("m_umum_utils.php?grd2=true&act=hapus&ref="+ref+"&rowid="+rowid2,"","GET");
			}
			batal();
			break;
			
			case 'Asal Rujukan':
			if(confirm("Anda yakin menghapus Asal Rujukan "+d.cellsGetValue(d.getSelRow(),2)))
			{
				d.loadURL("m_umum_utils.php?grd3=true&act=hapus&ref="+ref+"&rowid="+rowid3,"","GET");
			}
			batal();
			break;
			
			case 'Tujuan Rujukan':
			if(confirm("Anda yakin menghapus Tujuan Rujukan "+e.cellsGetValue(e.getSelRow(),2)))
			{
				e.loadURL("m_umum_utils.php?grd4=true&act=hapus&ref="+ref+"&rowid="+rowid4,"","GET");
			}
			batal();
			break;
			
			case 'Cara Keluar':
			if(confirm("Anda yakin menghapus Cara Keluar "+f.cellsGetValue(f.getSelRow(),2)))
			{
				f.loadURL("m_umum_utils.php?grd5=true&act=hapus&ref="+ref+"&rowid="+rowid5,"","GET");
			}
			batal();
			break;
			
			case 'Keadaan Keluar':
			if(confirm("Anda yakin menghapus Keadaan Keluar "+g.cellsGetValue(g.getSelRow(),2)))
			{
				g.loadURL("m_umum_utils.php?grd6=true&act=hapus&ref="+ref+"&rowid="+rowid6,"","GET");
			}
			batal();
			break;
			
			case 'Cara Bayar':
			if(confirm("Anda yakin menghapus Cara Bayar "+h.cellsGetValue(h.getSelRow(),2)))
			{
				h.loadURL("m_umum_utils.php?grd7=true&act=hapus&ref="+ref+"&rowid="+rowid7,"","GET");
			}
			batal();
			break;
			
			case 'Daftar Puskesmas':
			if(confirm("Anda yakin menghapus Daftar Puskesmas "+i.cellsGetValue(i.getSelRow(),2)))
			{
				i.loadURL("m_umum_utils.php?grd8=true&act=hapus&ref="+ref+"&rowid="+rowid8,"","GET");
			}
			batal();
			break;
			
			case 'Daftar RS Lain':
			if(confirm("Anda yakin menghapus Daftar RS "+j.cellsGetValue(j.getSelRow(),2)))
			{
				j.loadURL("m_umum_utils.php?grd9=true&act=hapus&ref="+ref+"&rowid="+rowid9,"","GET");
			}
			batal();
			break;
			
			case 'Daftar Dokter Non RS':
			if(confirm("Anda yakin menghapus Daftar Dokter Non RS "+k.cellsGetValue(k.getSelRow(),2)))
			{
				k.loadURL("m_umum_utils.php?grd10=true&act=hapus&ref="+ref+"&rowid="+rowid10,"","GET");
			}
			batal();
			break;
			
			case 'Layanan Lain-Lain':
			if(confirm("Anda yakin menghapus Layanan Lain-Lain "+l.cellsGetValue(l.getSelRow(),2)))
			{
				l.loadURL("m_umum_utils.php?grd11=true&act=hapus&ref="+ref+"&rowid="+rowid11,"","GET");
			}
			batal();
			break;
			
			case 'Jenis Kepegawaian':
			if(confirm("Anda yakin menghapus Jenis Kepegawaian "+JK.cellsGetValue(JK.getSelRow(),2)))
			{
				JK.loadURL("m_umum_utils.php?grdJK=true&act=hapus&ref="+ref+"&rowid="+id_JK,"","GET");
			}
			batal();
			break;
			case 'Lantai':
			if(confirm("Anda yakin menghapus Lantai "+LN.cellsGetValue(LN.getSelRow(),2)))
			{
				LN.loadURL("m_lantai_utils.php?grdLantai=true&act=hapus&ref="+ref+"&rowid="+id_lantai,"","GET");
			}
			batal();
			break;
				
			/*case 'Kelompok Pegawai':
			//alert("m_umum_utils.php?grd12=true&act=hapus&rowid="+rowid12);
			if(confirm("Anda yakin menghapus Kelompok Pegawai "+m.cellsGetValue(m.getSelRow(),2)))
			{
				m.loadURL("m_umum_utils.php?grd12=true&act=hapus&ref="+ref+"&rowid="+rowid12,"","GET");
			}
			batal();
			break;
			
			/*case 'Data Pegawai':
			//alert("m_umum_utils.php?grd=true&act=hapus&rowid="+rowid);
			if(confirm("Anda yakin menghapus Kelompok Pegawai "+n.cellsGetValue(n.getSelRow(),2)))
			{
				n.loadURL("m_umum_utils.php?grd13=true&act=hapus&ref="+ref+"&rowid="+rowid13,"","GET");
			}
			batal();
			break;*/
			
		}
	}
	
	function batal()
	{
		var ref = document.getElementById("ref").value;
		switch(ref)
		{
			case 'Pendidikan':
			var p="id_pend*-**|*txtpend*-**|*isAktif*-*false*|*btnSimpan*-*Tambah*|*btnHapus*-*true";
			fSetValue(window,p);	
			break;
			
			case 'Pekerjaan':
			var p="id_kerj*-**|*txtkerj*-**|*isAktif1*-*false*|*btnSimpan1*-*Tambah*|*btnHapus1*-*true";
			fSetValue(window,p);	
			break;
			
			case 'Agama':
			var p="id_agm*-**|*txtagm*-**|*isAktif2*-*false*|*btnSimpan2*-*Tambah*|*btnHapus2*-*true";
			fSetValue(window,p);	
			break;
			
			case 'Asal Rujukan':
			var p="id_asruj*-**|*txtasruj*-**|*isAktif3*-*false*|*btnSimpan3*-*Tambah*|*btnHapus3*-*true";
			fSetValue(window,p);	
			break;
			
			case 'Tujuan Rujukan':
			var p="id_tujruj*-**|*txttujruj*-**|*isAktif4*-*false*|*btnSimpan4*-*Tambah*|*btnHapus4*-*true";
			fSetValue(window,p);	
			break;
			
			case 'Cara Keluar':
			var p="id_crklr*-**|*txtcrklr*-**|*isAktif5*-*false*|*btnSimpan5*-*Tambah*|*btnHapus5*-*true";
			fSetValue(window,p);	
			break;
			
			case 'Keadaan Keluar':
			var p="id_kdklr*-**|*txtkdklr*-**|*isAktif6*-*false*|*btnSimpan6*-*Tambah*|*btnHapus6*-*true";
			fSetValue(window,p);	
			break;
			
			case 'Cara Bayar':
			var p="id_crbyr*-**|*txtcrbyr*-**|*isAktif7*-*false*|*btnSimpan7*-*Tambah*|*btnHapus7*-*true";
			fSetValue(window,p);	
			break;
			
			case 'Daftar Puskesmas':
			var p="id_dftrpusk*-**|*txtdftrpusk*-**|*isAktif8*-*false*|*btnSimpan8*-*Tambah*|*btnHapus8*-*true";
			fSetValue(window,p);	
			break;
			
			case 'Daftar RS Lain':
			var p="id_rsln*-**|*txtrsln*-**|*isAktif9*-*false*|*btnSimpan9*-*Tambah*|*btnHapus9*-*true";
			fSetValue(window,p);	
			break;
			
			case 'Daftar Dokter Non RS':
			var p="id_nonrs*-**|*txtnonrs*-**|*isAktif10*-*false*|*btnSimpan10*-*Tambah*|*btnHapus10*-*true";
			fSetValue(window,p);	
			break;
			
			case 'Layanan Lain-Lain':
			var p="id_lain*-**|*txtlain*-**|*isAktif11*-*false*|*btnSimpan11*-*Tambah*|*btnHapus11*-*true";
			fSetValue(window,p);	
			break;
			
			case 'Jenis Kepegawaian':
			var p="id_JK*-**|*txt_JK*-**|*isAktifJK*-*false*|*btnSimpanJK*-*Tambah*|*btnHapusJK*-*true";
			fSetValue(window,p);	
			break;
			
			case 'Lantai':
			var p="id_lantai*-**|*txtlantai*-**|*isAktifL*-*false*|*btnSimpanL*-*Tambah*|*btnHapusL*-*true";
			fSetValue(window,p);	
			break;
			
			/*case 'Kelompok Pegawai':
			var p="id_klp_peg*-**|*txtkode*-**|*txtnmklp*-**|*isAktif12*-*false*|*btnSimpan12*-*Tambah*|*btnHapus12*-*true";
			fSetValue(window,p);
			break;
			
			/*case 'Data Pegawai':
			var p="id_peg*-**|*txtnip*-**|*txtnama*-**|*cmbSex*-**|*cmbAgm*-**|*txtLahir*-**|*txtAlmt*-**|*txtTlp*-**|*txtHp*-**|*cmbStsKwn*-**|*txtOrtu*-**|*txtAlmtOrtu*-**|*txtNmSI*-**|*txtUser*-**|*txtPwd*-**|*cmbUnit*-**|*cmbKel*-**|*isAktif13*-*false*|*btnSimpan13*-*Tambah*|*btnHapus13*-*true";
			fSetValue(window,p);
			break;*/
		}
			
	}
	
	function pilih()
	{
		document.getElementById('div_pendidikan').style.display="none";
		document.getElementById('div_pekerjaan').style.display="none";
		document.getElementById('div_jenis_kepegawaian').style.display="none";
		document.getElementById('div_agama').style.display="none";
		document.getElementById('div_asal_rujukan').style.display="none";
		document.getElementById('div_tujuan_rujukan').style.display="none";
		document.getElementById('div_cara_keluar').style.display="none";
		document.getElementById('div_keadaan_keluar').style.display="none";
		document.getElementById('div_cara_bayar').style.display="none";
		document.getElementById('div_daftar_pusk').style.display="none";
		document.getElementById('div_rs_lain').style.display="none";
		document.getElementById('div_non_rs').style.display="none";
		document.getElementById('div_layanan_lain').style.display="none";
		document.getElementById('div_lantai').style.display="none";
		/*document.getElementById('div_klp_peg').style.display="none";
		document.getElementById('div_peg').style.display="none";*/
	
		if(document.getElementById('ref').value == "Pendidikan")
		{
			document.getElementById('div_pendidikan').style.display="block";
		}
		else if(document.getElementById('ref').value == "Pekerjaan")
		{
			document.getElementById('div_pekerjaan').style.display="block";
		}
		else if(document.getElementById('ref').value == "Agama")
		{
			document.getElementById('div_agama').style.display="block";
		}
		else if(document.getElementById('ref').value == "Asal Rujukan")
		{
			document.getElementById('div_asal_rujukan').style.display="block";
		}
		else if(document.getElementById('ref').value == "Tujuan Rujukan")
		{
			document.getElementById('div_tujuan_rujukan').style.display="block";
		}
		else if(document.getElementById('ref').value == "Cara Keluar")
		{
			document.getElementById('div_cara_keluar').style.display="block";
		}
		else if(document.getElementById('ref').value == "Keadaan Keluar")
		{
			document.getElementById('div_keadaan_keluar').style.display="block";
		}
		else if(document.getElementById('ref').value == "Cara Bayar")
		{
			document.getElementById('div_cara_bayar').style.display="block";
		}
		else if(document.getElementById('ref').value == "Daftar Puskesmas")
		{
			document.getElementById('div_daftar_pusk').style.display="block";
		}
		else if(document.getElementById('ref').value == "Daftar RS Lain")
		{
			document.getElementById('div_rs_lain').style.display="block";
		}
		else if(document.getElementById('ref').value == "Daftar Dokter Non RS")
		{
			document.getElementById('div_non_rs').style.display="block";
		}
		else if(document.getElementById('ref').value == "Layanan Lain-Lain")
		{
			document.getElementById('div_layanan_lain').style.display="block";
		}
		else if(document.getElementById('ref').value == "Jenis Kepegawaian")
		{
			document.getElementById('div_jenis_kepegawaian').style.display="block";
		}else if(document.getElementById('ref').value == "Lantai")
		{
			document.getElementById('div_lantai').style.display="block";
		}
		/*else if(document.getElementById('ref').value == "Kelompok Pegawai")
		{
			document.getElementById('div_klp_peg').style.display="block";
		}
		/*else if(document.getElementById('ref').value == "Data Pegawai")
		{
			document.getElementById('div_peg').style.display="block";
		}*/
	}
		
	function goFilterAndSort(grd)
	{
		//alert(grd);		
		switch(grd){
			case 'gridbox':
				a.loadURL("m_umum_utils.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
				break;
			case 'gridbox1':
				b.loadURL("m_umum_utils.php?grd1=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage(),"","GET");
				break;
			case 'gridbox2':
				c.loadURL("m_umum_utils.php?grd2=true&filter="+c.getFilter()+"&sorting="+c.getSorting()+"&page="+c.getPage(),"","GET");
				break;
			case 'gridbox3':
				d.loadURL("m_umum_utils.php?grd3=true&filter="+d.getFilter()+"&sorting="+d.getSorting()+"&page="+d.getPage(),"","GET");
				break;
			case 'gridbox4':
				e.loadURL("m_umum_utils.php?grd4=true&filter="+e.getFilter()+"&sorting="+e.getSorting()+"&page="+e.getPage(),"","GET");
				break;
			case 'gridbox5':
				f.loadURL("m_umum_utils.php?grd5=true&filter="+f.getFilter()+"&sorting="+f.getSorting()+"&page="+f.getPage(),"","GET");
				break;
			case 'gridbox6':
				g.loadURL("m_umum_utils.php?grd6=true&filter="+g.getFilter()+"&sorting="+g.getSorting()+"&page="+g.getPage(),"","GET");
				break;
			case 'gridbox7':
				h.loadURL("m_umum_utils.php?grd7=true&filter="+h.getFilter()+"&sorting="+h.getSorting()+"&page="+h.getPage(),"","GET");
				break;
			case 'gridbox8':
				i.loadURL("m_umum_utils.php?grd8=true&filter="+i.getFilter()+"&sorting="+i.getSorting()+"&page="+i.getPage(),"","GET");
				break;
				
			case 'gridbox9':
				j.loadURL("m_umum_utils.php?grd9=true&filter="+j.getFilter()+"&sorting="+j.getSorting()+"&page="+j.getPage(),"","GET");
				break;
				
			case 'gridbox10':
				k.loadURL("m_umum_utils.php?grd10=true&filter="+k.getFilter()+"&sorting="+k.getSorting()+"&page="+k.getPage(),"","GET");
				break;
			case 'gridbox11':
				l.loadURL("m_umum_utils.php?grd11=true&filter="+l.getFilter()+"&sorting="+l.getSorting()+"&page="+l.getPage(),"","GET");
				break;
		}		
	}
	var a=new DSGridObject("gridbox");
	a.setHeader("PENDIDIKAN");
	a.setColHeader("NO,PENDIDIKAN,STATUS AKTIF");
	a.setIDColHeader(",nama,");
	a.setColWidth("50,150,50");
	a.setCellAlign("center,left,center");
	a.setCellHeight(20);
	a.setImgPath("../icon");
	a.setIDPaging("paging");
	a.attachEvent("onRowClick","ambilData");
	a.baseURL("m_umum_utils.php?grd=true");
	a.Init();
	
	var b=new DSGridObject("gridbox1");
	b.setHeader("PEKERJAAN");
	b.setColHeader("NO,PEKERJAAN,STATUS AKTIF");
	b.setIDColHeader(",nama,");
	b.setColWidth("50,150,50");
	b.setCellAlign("center,left,center");
	b.setCellHeight(20);
	b.setImgPath("../icon");
	b.setIDPaging("paging1");
	b.attachEvent("onRowClick","ambilData1");
	b.baseURL("m_umum_utils.php?grd1=true");
	b.Init();
	
	var c=new DSGridObject("gridbox2");
	c.setHeader("AGAMA");
	c.setColHeader("NO,AGAMA,STATUS AKTIF");
	c.setIDColHeader(",agama,");
	c.setColWidth("50,150,50");
	c.setCellAlign("center,left,center");
	c.setCellHeight(20);
	c.setImgPath("../icon");
	c.setIDPaging("paging2");
	c.attachEvent("onRowClick","ambilData2");
	c.baseURL("m_umum_utils.php?grd2=true");
	c.Init();
	
	var d=new DSGridObject("gridbox3");
	d.setHeader("ASAL RUJUKAN");
	d.setColHeader("NO,ASAL RUJUKAN,STATUS AKTIF");
	d.setIDColHeader(",nama,");
	d.setColWidth("50,150,50");
	d.setCellAlign("center,left,center");
	d.setCellHeight(20);
	d.setImgPath("../icon");
	d.setIDPaging("paging3");
	d.attachEvent("onRowClick","ambilData3");
	d.baseURL("m_umum_utils.php?grd3=true");
	d.Init();
	
	var e=new DSGridObject("gridbox4");
	e.setHeader("TUJUAN RUJUKAN");
	e.setColHeader("NO,TUJUAN RUJUKAN,STATUS AKTIF");
	e.setIDColHeader(",nama,");
	e.setColWidth("50,150,50");
	e.setCellAlign("center,left,center");
	e.setCellHeight(20);
	e.setImgPath("../icon");
	e.setIDPaging("paging4");
	e.attachEvent("onRowClick","ambilData4");
	e.baseURL("m_umum_utils.php?grd4=true");
	e.Init();
	
	var f=new DSGridObject("gridbox5");
	f.setHeader("CARA KELUAR");
	f.setColHeader("NO,CARA KELUAR,STATUS AKTIF");
	f.setIDColHeader(",nama,");
	f.setColWidth("50,150,50");
	f.setCellAlign("center,left,center");
	f.setCellHeight(20);
	f.setImgPath("../icon");
	f.setIDPaging("paging5");
	f.attachEvent("onRowClick","ambilData5");
	f.baseURL("m_umum_utils.php?grd5=true");
	f.Init();
	
	var g=new DSGridObject("gridbox6");
	g.setHeader("KEADAAN KELUAR");
	g.setColHeader("NO,KEADAAN KELUAR,STATUS AKTIF");
	g.setIDColHeader(",nama,");
	g.setColWidth("50,150,50");
	g.setCellAlign("center,left,center");
	g.setCellHeight(20);
	g.setImgPath("../icon");
	g.setIDPaging("paging6");
	g.attachEvent("onRowClick","ambilData6");
	g.baseURL("m_umum_utils.php?grd6=true");
	g.Init();
	
	var h=new DSGridObject("gridbox7");
	h.setHeader("CARA BAYAR");
	h.setColHeader("NO,CARA BAYAR,STATUS AKTIF");
	h.setIDColHeader(",nama,");
	h.setColWidth("50,150,50");
	h.setCellAlign("center,left,center");
	h.setCellHeight(20);
	h.setImgPath("../icon");
	h.setIDPaging("paging7");
	h.attachEvent("onRowClick","ambilData7");
	h.baseURL("m_umum_utils.php?grd7=true");
	h.Init();
	
	var i=new DSGridObject("gridbox8");
	i.setHeader("DAFTAR PUSK");
	i.setColHeader("NO,DAFTAR PUSK,STATUS AKTIF");
	i.setIDColHeader(",nama,");
	i.setColWidth("50,150,50");
	i.setCellAlign("center,left,center");
	i.setCellHeight(20);
	i.setImgPath("../icon");
	i.setIDPaging("paging8");
	i.attachEvent("onRowClick","ambilData8");
	i.baseURL("m_umum_utils.php?grd8=true");
	i.Init();
	
	var j=new DSGridObject("gridbox9");
	j.setHeader("DAFTAR RS LAIN");
	j.setColHeader("NO,DAFTAR RS LAIN,STATUS");
	a.setIDColHeader(",nama,");
	j.setColWidth("50,150,50");
	j.setCellAlign("center,left,left");
	j.setCellHeight(20);
	j.setImgPath("../icon");
	j.setIDPaging("paging9");
	j.attachEvent("onRowClick","ambilData9");
	j.baseURL("m_umum_utils.php?grd9=true");
	j.Init();
	
	var k=new DSGridObject("gridbox10");
	k.setHeader("DAFTAR DOKTER NON RS");
	k.setColHeader("NO,DAFTAR DOKTER NON RS,STATUS AKTIF");
	k.setIDColHeader(",nama,");
	k.setColWidth("50,150,50");
	k.setCellAlign("center,left,center");
	k.setCellHeight(20);
	k.setImgPath("../icon");
	k.setIDPaging("paging10");
	k.attachEvent("onRowClick","ambilData10");
	k.baseURL("m_umum_utils.php?grd10=true");
	k.Init();
	
	var l=new DSGridObject("gridbox11");
	l.setHeader("LAYANAN LAIN-LAIN");
	l.setColHeader("NO,LAYANAN LAIN-LAIN,STATUS AKTIF");
	l.setIDColHeader(",nama,");
	l.setColWidth("50,150,50");
	l.setCellAlign("center,left,center");
	l.setCellHeight(20);
	l.setImgPath("../icon");
	l.setIDPaging("paging11");
	l.attachEvent("onRowClick","ambilData11");
	l.baseURL("m_umum_utils.php?grd11=true");
	l.Init();
	
	var JK=new DSGridObject("gridboxJK");
	JK.setHeader("JENIS KEPEGAWAIAN");
	JK.setColHeader("NO,JENIS KEPEGAWAIAN,STATUS AKTIF");
	JK.setIDColHeader(",nama,");
	JK.setColWidth("50,150,50");
	JK.setCellAlign("center,left,center");
	JK.setCellHeight(20);
	JK.setImgPath("../icon");
	JK.setIDPaging("paging11");
	JK.attachEvent("onRowClick","ambilDataJK");
	JK.baseURL("m_umum_utils.php?grdJK=true");
	JK.Init();
	
	var LN=new DSGridObject("gridbox55");
	LN.setHeader("Master Lantai");
	LN.setColHeader("NO,Lantai,Status");
	LN.setIDColHeader(",nama,");
	LN.setColWidth("50,150,50");
	LN.setCellAlign("center,left,center");
	LN.setCellHeight(20);
	LN.setImgPath("../icon");
	LN.setIDPaging("paging55");
	LN.attachEvent("onRowClick","ambilDataLN");
	LN.baseURL("m_lantai_utils.php?grdLantai=true");
	LN.Init();
	
	/*var m=new DSGridObject("gridbox12");
	m.setHeader("KELOMPOK PEGAWAI");
	m.setColHeader("NO,KODE,NAMA,STATUS AKTIF");
	//a.setIDColHeader(",,NoRM,Kode,Nama,Alamat,Penjamin,dokter,Poli");
	m.setColWidth("50,75,120,50");
	m.setCellAlign("center,center,left,center");
	m.setCellHeight(20);
	m.setImgPath("../icon");
	m.setIDPaging("paging12");
	m.attachEvent("onRowClick","ambilData12");
	m.baseURL("m_umum_utils.php?grd12=true");
	m.Init();
	
	/*var n=new DSGridObject("gridbox13");
	n.setHeader("DATA PEGAWAI");
	n.setColHeader("NO,NIP,NAMA,JENIS KELAMIN,AGAMA,TGL LAHIR,ALAMAT,TELEPON,HP,MARITAL,NAMA ORTU,ALAMAT ORTU,NAMA SUAMI/ISTRI,USERNAME,PASSWORD,UNIT,KELOMPOK,STATUS AKTIF");
	n.setIDColHeader(",,,NAMA,,,,,,,,,,");
	n.setColWidth("50,75,100,75,75,75,100,75,75,75,100,100,100,75,75,75,75,75");
	n.setCellAlign("center,center,left,center,center,center,left,left,left,center,left,left,left,center,center,center,center,center");
	n.setCellHeight(20);
	n.setImgPath("../icon");
	n.setIDPaging("paging13");
	n.attachEvent("onRowClick","ambilData13");
	n.baseURL("m_umum_utils.php?grd13=true");
	n.Init();*/
	
	
</script>
</body>
</html>
