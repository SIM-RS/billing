<?php
session_start();
include("../sesi.php");
$userId = $_SESSION['userId'];
if(!isset($userId) || $userId == ''){
    header('location:../index.php');
}
$userId = $_SESSION['userId'];//echo $userId."<br>";
$versi="4";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>Form Pembayaran</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="Cache-Control" content="no-cache, must-revalidate" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
		<link rel="stylesheet" href="../include/dialog/dialog_box.css" />
		<script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script src="../theme/dhtmlxcalendar.js" type="text/javascript"></script>
		<!--dibawah ini diperlukan untuk menampilkan menu dropdown-->
		<script language="JavaScript" src="../theme/js/mm_menu.js"></script>
        <script language="JavaScript" src="../theme/js/dropdown.js"></script>
        <!--dibawah ini diperlukan untuk menampilkan popup-->
        <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        <script type="text/javascript" src="../theme/prototype.js"></script>
        <script type="text/javascript" src="../theme/effects.js"></script>
        <script type="text/javascript" src="../theme/popup.js"></script>
		<script type="text/javascript" src="../include/dialog/dialog_box.js"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <!-- end untuk ajax-->
</head>
    <body onload="document.getElementById('NoRm').focus();">
        <script type="text/JavaScript">
            var arrRange=depRange=[];
        </script>
        <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js"
                src="../theme/popcjs.php" scrolling="no"
                frameborder="1"
                style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
        </iframe>
        <div align="center">
            <?php
            include("../koneksi/konek.php");
            include("../header1.php");
			$sPrev="SELECT * FROM b_ms_group_petugas WHERE ms_pegawai_id='$userId' AND ms_group_id IN (10,49)";
			$qPrev=mysql_query($sPrev);
			$privilege=0;
			if (mysql_num_rows($qPrev)>0){
				$privilege=1;
			}
            $date_now=gmdate('d-m-Y',mktime(date('H')+7));
            ?>
            <iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
            </iframe>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;FORM PEMBAYARAN</td>
					<?php 
					$qAkses = "SELECT DISTINCT ms_menu_id,mm.nama,mm.url FROM b_ms_group_petugas gp INNER JOIN b_ms_group_akses mga ON gp.ms_group_id = mga.ms_group_id INNER JOIN b_ms_menu mm ON mga.ms_menu_id=mm.id WHERE gp.ms_pegawai_id=$userId AND mga.ms_menu_id IN (37,39,42,54)";
					$rsAkses = mysql_query($qAkses);
					if(mysql_num_rows($rsAkses)>1){
					?>
                    <td width="460" align="right">Link&nbsp;&nbsp;
						<select name="cmnLink" id="cmbLink" class="txtinputreg" onchange="location=this.value;">
							<option>-- PILIH --</option>
							<?php while($rwMenu = mysql_fetch_array($rsAkses)){?>
							<option value="<?php echo '../'.$rwMenu['url']?>"><?php echo $rwMenu['nama']?></option>
							<?php } ?>
						</select>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<?php }?>
                </tr>
            </table>
            <table width="1000" border="0" cellspacing="1" cellpadding="0" class="tabel" align="center">
                <tr>
                    <td colspan="9">&nbsp;</td>
                </tr>
                <tr>
                    <td width="0%">&nbsp;</td>
                    <td width="16%" align="right">Nomer RM &nbsp;</td>
                    <td colspan="2"><input type="text" name="NoRm" id="NoRm" size="20" class="txtinputreg" tabindex="1" onkeyup="listPasien(event,'show',this.value)"/>
                        <input id="txtIdBayar" name="txtIdBayar" type="hidden"/>
                        <input id="txtIdKunj" name="txtIdKunj" type="hidden"/>
                        <input id="txtJenisKunj" name="txtJenisKunj" type="hidden"/>
                        <input id="txtIdPel" name="txtIdPel" type="hidden"/>
                        <input id="txtKasirId" name="txtKasirId" type="hidden"/>
                        <input id="txtKsoId" name="txtKsoId" type="hidden"/>
                        <input id="txtUnitId" name="txtUnitId" type="hidden"/>
                        <input id="txtTglK" name="txtTglK" type="hidden"/></td>
                        <input id="txtBayarTot" name="txtBayarTot" type="hidden"/>
                        <input id="txtKurangTot" name="txtKurangTot" type="hidden"/>
                        <input id="txtBayarIGD" name="txtBayarIGD" type="hidden"/>
                        <input id="txtKurangIGD" name="txtKurangIGD" type="hidden"/>
                        <input id="txtBayarAmbulan" name="txtBayarAmbulan" type="hidden"/>
                        <input id="txtKurangAmbulan" name="txtKurangAmbulan" type="hidden"/>
                        <input id="txtBayarJenazah" name="txtBayarJenazah" type="hidden"/>
                        <input id="txtKurangJenazah" name="txtKurangJenazah" type="hidden"/>
                        <input id="txtigdJaminan" name="txtigdJaminan" type="hidden"/>
                        <input id="txtAmbulanJaminan" name="txtAmbulanJaminan" type="hidden"/>
                        <input id="txtJenazahJaminan" name="txtJenazahJaminan" type="hidden"/>
                        <input id="txtTotJaminan" name="txtTotJaminan" type="hidden"/>
                        <input name="NmOrtu" id="NmOrtu" size="25" type="hidden" />
                    <td width="24%">&nbsp;</td>
                    <td colspan="3" align="left">&nbsp;&nbsp;&nbsp;No Billing &nbsp;<input name="NoBiling" id="NoBiling" tabindex="2" size="15" class="txtinputreg" readonly="readonly" /></td>
                    <td width="0%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Nama &nbsp;</td>
                    <td colspan="3"><input type="text" class="txtinputreg" name="Nama" id="Nama" size="49" tabindex="3" onkeyup="listPasien(event,'show',this.value)"/>
                        <div id="div_pasien" align="center" class="div_pasien" style="display:none"></div></td>
                    <td colspan="3" align="center"></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right" valign="top">Alamat &nbsp;</td>
                    <td colspan="5"><textarea name="txtalamat" id="txtalamat" class="txtinputreg" rows="1" style="width:357px;" readonly="readonly"></textarea></td>
                </tr>
                <tr style="display:none">
                    <td>&nbsp;</td>
                    <td align="right">Jenis Kelamin &nbsp;</td>
                    <td colspan="3"><select name="Gender" id="Gender" class="txtinputreg">
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option></select>&nbsp;<!--Umur&nbsp;<input type="text" style="text-align:center;" class="txtinputreg" name="th" id="th" size="3" tabindex="8" onkeyup="gantiTgl()"/>
			  &nbsp;Th&nbsp;&nbsp;<input type="text" style="text-align:center;" class="txtinputreg" name="Bln" id="Bln" size="3" tabindex="9" onkeyup="gantiTgl()"/>&nbsp;Bln--></td>
                    <td width="10%">&nbsp;</td>
                </tr>
				<tr id="trTipeBayarPaviliun" style="visibility:collapse;">
					<td>&nbsp;</td>
					<td align="right">Tipe Bayar Paviliun &nbsp;</td>
					<td colspan="3">
						<span id="span_tipe_bayar_paviliun" style="display:none;"></span>
						<input type="checkbox" name="tipe_bayar_paviliun" id="tipe_bayar_paviliun" value="0" onClick="up_paviliun()" />&nbsp;Tanpa IPIT
					</td>
				</tr>
                <tr>
                    <td colspan="8" align="right" style="padding-right:30px;"><span id="spnStatus" style="color:#F00; font-size:24px; font-weight:bold; display:none"></span><input type="button" id="btnPasienPulang" name="btnPasienPulang" value="KRS" onclick="pasienPulang();" style="cursor:pointer; color:#F00; font-weight:bold; display:none;"/><input type="button" id="btnBatalPulang" name="btnBatalPulang" value="BATAL KRS" onclick="batalPulang();" style="cursor:pointer; color:#0F0; font-weight:bold; display:none;"/></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="0%">&nbsp;</td>
                    <td colspan="7"><form id="form_pmbyrn" name="form_pmbyrn">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="34%">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td width="48%" align="right">Kasir&nbsp;									</td>
                                            <td width="52%">
                                                <select id="cmbKasir" class="txtinput" onchange="saringByKasir(this);">
                                                    <?php
                                                    $sql="select u.id,u.nama,u.jenis_layanan FROM b_ms_pegawai_unit p inner join b_ms_unit u on p.unit_id=u.id where p.ms_pegawai_id = '".$_SESSION['userId']."' and u.kategori=4";
													//echo $sql."<br>";
                                                    $rs=mysql_query($sql);
                                                    while($rw=mysql_fetch_array($rs)) {
                                                        ?>
                                                    <option value="<?php echo $rw['id'];?>" lang="<?php echo $rw['jenis_layanan'];?>"><?php echo $rw['nama'];?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>                                            </td>
                                        </tr>
                                        <tr id="idTrIGD" style="visibility:collapse">
                                            <td width="48%" align="right">Untuk Pembayaran &nbsp;</td>
                                            <td width="52%">
                                            	<select id="bayarIGD" name="bayarIGD" class="txtinput" onchange="fBayarIGD();">
                                                    <option value="0">IGD</option>
                                                    <option value="1">Rawat Inap</option>
                                                    <option value="2">Ambulan</option>
                                                    <option value="3">Kamar Jenazah</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr style="visibility:hidden">
                                            <td width="48%" align="right">Bayar Titipan &nbsp;</td>
                                            <td width="52%"><input name="tipe" id="tipe" type="checkbox" value="0" onclick="Jaminan(this.value);" />&nbsp;</td>
                                        </tr>
                                        <tr style="visibility:collapse">
                                            <td width="48%" align="right">No. Bukti Bayar &nbsp;</td>
                                            <td width="52%"><input size="12" type="text" class="txtinputreg" id="txtnobukti" name="txtnobukti"/></td>
                                        </tr>
                                        <tr style="display:none">
                                            <td width="48%" align="right">Tanggal &nbsp;</td>
                                            <td width="52%"><input id="txttgl" name="txttgl" readonly="readonly" size="11" class="txtcenter" value="<?php echo $date_now;?>"/>&nbsp;<input type="button" name="ButtonTglLahir" value=" V " class="txtcenter" <?php echo $DisableBD; ?> onClick="gfPop.fPopCalendar(document.getElementById('txttgl'),depRange);" /></td>
                                        </tr>
                                        <tr id="detail_obat" style="visibility:collapse">
                                            <td width="48%" align="right">Detail Obat &nbsp;</td>
                                            <td width="52%"><input type="hidden" id="tes" name="tes"/><input type="hidden" id="bykresep" name="bykresep"/><input type="hidden" id="jmlresep" name="jmlresep"/><input type="hidden" id="minresep" name="minresep"/><input type="hidden" id="statresep" name="statresep" value="1"/><input type="hidden" id="totalcost"/></td>
                                        </tr>
										<tr>
                                            <td width="48%" align="right">Pilihan Tagihan &nbsp;</td>
                                            <td width="52%"><input type="checkbox" class="chkinput" onclick="nyalamati(this.checked)" id="resepobat">&nbsp;Pilih Tagihan</td>
                                        </tr>
										<tr id="tot_tagihan">
                                            <td width="48%" align="right">Total Tagihan &nbsp;</td>
                                            <td width="52%"><input name="lblbiaya" class="txtinputreg" id="lblbiaya" style="text-align:right" value="0" size="10" readonly="true" /></td>
                                        </tr>
                                        <tr id="tot_titipan" style="visibility:collapse">
                                            <td align="right">Total Titipan &nbsp;</td>
                                            <td><input name="txtTitipan" class="txtinputreg" id="txtTitipan" style="text-align:right" value="0" size="10" readonly="true" /></td>
                                        </tr>
                                        <tr id="jaminanKSO" style="visibility:collapse">
                                            <td align="right">Jaminan KSO &nbsp;</td>
                                            <td><input name="txtJaminan" class="txtinputreg" id="txtJaminan" style="text-align:right" value="0" size="10" readonly="true" /></td>
                                        </tr>
                                        <tr id="krg_bayar">
                                            <td width="48%" align="right">Keringanan &nbsp;</td>
                                            <td width="52%" style="color:#0000FF"><input id="txtKeringanan" style="text-align:right" name="txtKeringanan" size="10" class="txtinputreg" value="0" onkeyup="HitungBayar()" /></td>
                                        </tr>
                                        <tr id="trSudahBayar">
                                            <td width="48%" align="right">Sudah Bayar &nbsp;</td>
                                            <td width="52%" style="color:#0000FF"><input id="txtSudahBayar" style="text-align:right" name="txtSudahBayar" size="10" class="txtinputreg" readonly="readonly" value="0" /></td>
                                        </tr>
                                        <tr>
                                            <td width="48%" height="34" align="right" id="tdPembayaran" style="color:#0000FF">Pembayaran &nbsp;</td>
                                            <td width="52%"><input name="txtbayar" class="txtinputreg" id="txtbayar" style="text-align:right" value="0" size="10" onkeyup="cek();" /></td>
                                        </tr>
                                        <tr id="trSisa">
                                            <td width="48%" align="right">Sisa &nbsp;</td>
                                            <td width="52%"><input name="txtsisa" class="txtinputreg" id="txtsisa" style="text-align:right" value="0" size="10" readonly="readonly" /></td>
                                        <tr>
                                            <td width="48%" align="right" style="border-top:1px solid">Jumlah Uang Diterima &nbsp;</td>
                                            <td width="52%" style="border-top:1px solid"><input id="txtditerima" name="txtditerima" size="10" class="txtinputreg" style="text-align:right" value="0" onkeyup="kembali()"/></td>
                                        </tr>
                                        <tr>
                                            <td width="48%" align="right" style="border-top:1px solid">Jumlah Uang Kembali &nbsp;</td>
                                            <td width="52%" style="border-top:1px solid"><input id="txtkembali" name="txtkembali" size="10" value="0" class="txtinputreg" style="text-align:right" readonly="true"/></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <!--td width="60%" align="right">Sebagai Pembayaran &nbsp;&nbsp;&nbsp;</td>
                                            <td width="40%" align="right"><select></select></td-->
                                        </tr>
                                    </table>                                </td>
                                <td width="66%" align="center" valign="top"><div id="gridbox" style="width:600px; height:200px; background-color:white; overflow:hidden;"></div>
                                    <div id="paging" style="width:525px;"></div>                                </td>
                            </tr>
                        </table>                    </form></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="3" align="right">Terima Dari&nbsp;</td>
                    <td><input size="35" class="txtinputreg" id="txtterima" name="txtterima" /></td>
                    <td align="justify">&nbsp;</td>
                    <td colspan="2" align="right" style="padding-right:30px;">
						<input type="hidden" id="cekBayar" name="cekBayar" value="0" />
                        <input type="hidden" id="txtIUR" name="txtIUR" />
						&nbsp;
                        <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="simpan(this.value);" class="tblTambah"/>
                        <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus"/>
                        <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal();" class="tblBatal"/></td>
						<span id="limithapus" style="display:none;"></span>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td width="24%">&nbsp;</td>
                    <td width="11%">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="7" style="border-bottom:2px solid" height="0">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="7" align="center"><input name="btnPrint" id="btnPrint" type="button" class="tblCetak" value="&nbsp;&nbsp;&nbsp;Cetak" onclick="cetakPembayaran();" />&nbsp;<input name="btnKwi" id="btnKwi" type="button" class="tblCetak" value="&nbsp;&nbsp;&nbsp;Kwitansi" onclick="cetakKwitansi();" />&nbsp;<input type="button" onclick="getObt()" class="tblBtn" disabled="disabled" value="View Detail Tagihan" id="obt" name="obt">&nbsp;<input name="HapusKonsul" id="HapusKonsul" type="button" value="Hapus Konsul / MRS" class="tblBtn" disabled="disabled" onclick="viewHapusKonsul()" />&nbsp;<input name="rincianPas" id="rincianPas" type="button" value="Rincian Tindakan" class="tblBtn"  onMouseOver="MM_showMenu(window.mm_menu_0814123211_4a,0,-30,null,'rincianPas');" onMouseOut="MM_startTimeout();" />&nbsp;<input name="rincianPenunjang" id="rincianPenunjang" type="button" value="Cetak Penunjang & Obat" class="tblBtn"  onMouseOver="MM_showMenu(window.mm_menu_0814123211_5a,0,-108,null,'rincianPenunjang');" onMouseOut="MM_startTimeout();" />&nbsp;<input name="tagihan" id="btnTagihan" type="button" value="Tagihan" class="tblBtn" style="cursor:pointer; display:none;" onMouseOver="MM_showMenu(window.mm_menu_0814123211_3,0,-80,null,'btnTagihan');" onMouseOut="MM_startTimeout();" /></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
<table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
                <tr height="30">
                    <td>&nbsp;<!--input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /--></td>
                    <td colspan="6" align="right"><!--a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" /></a-->&nbsp;</td></tr>
            </table>
        </div>
        <div id="divUpdtStatus" style="display:none;width:450px; height:200px" align="center" class="popup">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr>
                    <td><img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right;cursor: pointer" /></td>
                </tr>
                <tr>
                    <td align="center">
                    	<table border="0" cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td class="txtinputNoBgColor">Status Pasien</td>
                              <td class="txtinputNoBgColor" width="10" align="center">&nbsp;:</td>
                                <td>
                                	<select id="statusPx" name="statusPx" class="txtinput" onchange="fChangeStatusPx(this.value)">
                                    <?php 
									$sql="SELECT id,nama FROM b_ms_kso WHERE aktif=1";
									$rs=mysql_query($sql);
									while ($rw=mysql_fetch_array($rs)){
									?>
                                    	<option value="<?php echo $rw['id']; ?>"><?php echo $rw['nama']; ?></option>
                                    <?php 
									}
									?>
                                    </select>                                </td>
                            </tr>
                        	<tr>
                            	<td class="txtinputNoBgColor"><span id="spnTglSJP">Tgl SJP/SKP</span></td>
                              <td class="txtinputNoBgColor" width="10" align="center">&nbsp;:</td>
                                <td><input type="text" class="txtcenter" name="TglSJP" readonly id="TglSJP" size="11" value="<?php echo $date_now;?>"/>
                        <input type="button" id="ButtonTglSJP" name="ButtonTglSJP" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('TglSJP'),depRange);" /></td>
                            </tr>
                        	<tr id="trnosjp">
                              <td class="txtinputNoBgColor">No SJP/SKP</td>
                        	  <td class="txtinputNoBgColor" align="center">&nbsp;:</td>
                        	  <td><input type="text" class="txtcenter" name="NoSJP" id="NoSJP" size="20" /></td>
                        	</tr>
                        	<tr id="trNoJaminan">
                              <td class="txtinputNoBgColor">No Anggota</td>
                        	  <td class="txtinputNoBgColor" align="center">&nbsp;:</td>
                        	  <td><input type="text" class="txtcenter" name="NoJaminan" id="NoJaminan" size="20" /></td>
                      	  </tr>
                        	<tr id="trHakKelas">
                              <td class="txtinputNoBgColor">Hak Kelas</td>
                        	  <td class="txtinputNoBgColor" align="center">&nbsp;:</td>
                        	  <td><select id="cmbHakKelas" name="cmbHakKelas" class="txtinput">
                                <?php 
									$sql="SELECT * FROM b_ms_kelas WHERE id IN (2,3,4,9) AND aktif=1";
									$rs=mysql_query($sql);
									while ($rw=mysql_fetch_array($rs)){
									?>
                                <option value="<?php echo $rw['id']; ?>"><?php echo $rw['nama']; ?></option>
                                <?php 
									}
									?>
                              </select></td>
                      	  </tr>
                        	<tr id="trStatusPenj">
                              <td class="txtinputNoBgColor">Status Jaminan&nbsp;</td>
                        	  <td class="txtinputNoBgColor" align="center">&nbsp;:</td>
                        	  <td><select name="StatusPenj" id="StatusPenj" class="txtinputreg">
                                    <option value="ANAK KE 1">Anak Ke 1</option>
                                    <option value="ANAK KE 2">Anak Ke 2</option>
                                    <option value="ISTRI">Istri</option>
                                    <option value="PESERTA">Peserta</option>
                                    <option value="SUAMI">Suami</option>
                                </select></td>
                       	  </tr>
                        </table>                  </td>
                </tr>
                <tr>
                    <td align="center"><br /><input name="BtnUpdtStatusPx" id="BtnUpdtStatusPx" type="button" value="Update Status" class="tblBtn" onclick="goUpdtStatusPx()" /></td>
                </tr>
            </table>
        </div>
		<div id="divObt" style="display:none;width:900px; height:335px" align="center" class="popup">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr>
                    <td width="35%"></td>
					<td width="20%"><input type="checkbox" onclick="cekAll(this.lang);" id="ceksmua"> Pilih Semua</td>
					<td width="25%"><img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right;cursor: pointer" /></td>
                </tr>
				<tr>
                    <td width="35%"><table width="100%">
						<tr>
							<td width="30%">No RM</td>
							<td width="3%">:</td>
							<td width="67%"><input type="text" readonly size="10" id="rm1" class="txtinputreg"></td>
						</tr>
						<tr>
							<td>Nama Pasien</td>
							<td>:</td>
							<td><input type="text" readonly size="33" id="pasien1" class="txtinputreg"></td>
						</tr>
						<tr>
							<td colspan="3">&nbsp;</td>
						</tr>
						<tr>
							<td>Billing</td>
							<td>:</td>
							<td><input type="text" readonly size="10" id="billing3" class="txtinputreg"><input type="text" hidden size="10" id="billing1" class="txtinputreg"></td>
						</tr>
						<tr>
							<td>Obat</td>
							<td>:</td>
							<td><input type="text" readonly size="10" id="obat1" class="txtinputreg"></td>
						</tr>
						<tr>
							<td colspan="3"><hr></hr></td>
						</tr>
						<tr>
							<td>Total Tagihan</td>
							<td>:</td>
							<td><input type="text" readonly size="10" id="tagih1" class="txtinputreg"></td>
						</tr>
						<tr>
							<td colspan="3">&nbsp;</td>
						</tr>
						<tr>
							<td>Total Obat</td>
							<td>:</td>
							<td><input type="text" readonly size="10" id="totalobat1" class="txtinputreg"></td>
						</tr>
						<tr>
							<td colspan="3">&nbsp;</td>
						</tr>
						<tr>
							<td>Pembayaran</td>
							<td>:</td>
							<td><input type="text" readonly size="10" id="bayar2" class="txtinputreg"></td>
						</tr>
					</table><div style="display:none">Pembayaran&nbsp;:&nbsp;<input type="text" readonly size="10" id="bayar1"><br/>Sisa&nbsp;:&nbsp;<input type="text" readonly size="10" id="sisa1"></div></td>
					<td width="65%" colspan="2"><div style="border:2px solid #0BC574; width: 100%; overflow: scroll; height: 280px;"><div id="det_obt"></div><div id="billing2"></div></div></td>
                </tr>
				<tr>
                    <td width="35%">&nbsp;</td>
					<td width="20%">&nbsp;</td>
					<td width="25%" align="right" colspan="2">&nbsp;</td>
                </tr>
            </table>
        </div>
		<div id="divTind" style="display:none;width:750px; height:310px" align="center" class="popup">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr>
                    <td><img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right;cursor: pointer" /></td>
                </tr>
                <tr>
                    <td>
                        <div id="gridTind" style="display:block;width:745px; height:250px" align="center"></div>				</td>
                </tr>
            </table>
        </div>
        <div id="divHapusKonsul" style="display:none;width:750px; height:350px" align="center" class="popup">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr>
                    <td><img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right;cursor: pointer" /></td>
                </tr>
                <tr>
                    <td><div id="gridHapusKonsul" style="display:block; width:750px; height:300px" align="center"></div></td>
                </tr>
            </table>
        </div>
		<div id="divHapusKonsul2" style="display:none;width:750px; height:350px" align="center" class="popup">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr>
                    <td><img alt="close" src="../icon/x.png" width="32" onclick="dialogtampil();" class="popup_closebox" style="float:right;cursor: pointer" /></td>
                </tr>
                <tr>
                    <td><div id="gridHapusKonsul2" style="display:block; width:750px; height:300px" align="center"></div></td>
                </tr>
            </table>
        </div>
        <div id="divRincianTindakan" style="display:none;width:200px; height:100px" align="center" class="popup">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr>
                    <td><img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right;cursor: pointer" /></td>
                </tr>
                <tr>
                    <td align="center"><select id="cmbRincianTindakan"></select></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td align="center"><button type="button" style="cursor:pointer;" onclick="CetakRincianTindakan(document.getElementById('cmbRincianTindakan').value)">Cetak</button></td>
                </tr>
            </table>
        </div>
        <span id="spnResHapusKonsul" style="display:none;"></span>
</body>
    <script type="text/JavaScript">
        var txtbayar=0,txtditerima=0,txtkembali=0;
        var abc = '';
        function Jaminan(a){
            if(a=="0"){
                txtbayar=parseFloat(document.getElementById('txtbayar').value);
                txtditerima=parseFloat(document.getElementById('txtditerima').value);
                txtkembali=parseFloat(document.getElementById('txtkembali').value);
                document.getElementById('tipe').value=1;
                document.getElementById('tot_tagihan').style.visibility='collapse';
                document.getElementById('krg_bayar').style.visibility='collapse';
                document.getElementById('tot_titipan').style.visibility='collapse';
                document.getElementById('tdPembayaran').innerHTML="Nilai Titipan &nbsp;";
                document.getElementById('txtbayar').value=0;
                //document.getElementById('txtbayar').readOnly=false;
                document.getElementById('txtditerima').value=0;
                document.getElementById('txtkembali').value=0;
            }else{
                document.getElementById('tipe').value=0;
                document.getElementById('tot_tagihan').style.visibility='visible';
                document.getElementById('krg_bayar').style.visibility='visible';
                document.getElementById('tot_titipan').style.visibility='collapse';
                document.getElementById('tdPembayaran').innerHTML="Pembayaran &nbsp;";
                document.getElementById('txtbayar').value=txtbayar;
                //document.getElementById('txtbayar').readOnly=true;
                document.getElementById('txtditerima').value=txtditerima;
                document.getElementById('txtkembali').value=txtkembali;
            }
            filterTagihan(document.getElementById('cmbKasir'));
            /*document.getElementById('txtnobukti').value='';
                    document.getElementById('lblbiaya').value='';
                    document.getElementById('txtbayar').value='';
                    document.getElementById('txtkrgbayar').value='';
                    document.getElementById('txtditerima').value='';
                    document.getElementById('txtkembali').value=0;*/
        }

        function getObt()
        {
            document.getElementById('bayar1').value = document.getElementById('txtbayar').value;
			
			new Popup('divObt',null,{modal:true,position:'center',duration:1});
            document.getElementById('divObt').popup.show();
        }
		
		function viewHapusKonsul()
        {
			hk.loadURL("bayar_utils.php?versi=<?php echo $versi; ?>&grd2=true&idKunj="+dataPasien[9]+"&idPel="+dataPasien[11]+"&jenisKunj="+dataPasien[28]+"&pulang=1","","GET");
            new Popup('divHapusKonsul',null,{modal:true,position:'center',duration:1});
            document.getElementById('divHapusKonsul').popup.show();
        }
		
		function viewHapusKonsul2()
        {
			hk2.loadURL("bayar_utils.php?versi=<?php echo $versi; ?>&grd2=true&idKunj="+dataPasien[9]+"&idPel="+dataPasien[11]+"&jenisKunj="+dataPasien[28]+"&pulang=0","","GET");
            new Popup('divHapusKonsul2',null,{modal:true,position:'center',duration:1});
            document.getElementById('divHapusKonsul2').popup.show();
        }

		function fChangeStatusPx(p){
			if (p=="1"){
				document.getElementById('trnosjp').style.visibility='collapse';
				document.getElementById('trNoJaminan').style.visibility='collapse';
				document.getElementById('trHakKelas').style.visibility='collapse';
				document.getElementById('trStatusPenj').style.visibility='collapse';
				document.getElementById('spnTglSJP').innerHTML='Tgl Mulai Berubah';
			}else{
				document.getElementById('trnosjp').style.visibility='visible';
				document.getElementById('trNoJaminan').style.visibility='visible';
				document.getElementById('trHakKelas').style.visibility='visible';
				document.getElementById('trStatusPenj').style.visibility='visible';
				document.getElementById('spnTglSJP').innerHTML='Tgl SJP/SKP';
			}
		}
        
		function goUpdtStatusPx(){
			/*i++;
			if (i==6) i=1;
			fSetValue(window,"statusPx*-*"+i);
			fChangeStatusPx(document.getElementById('statusPx').value);*/
			
		}
		
		function PopUpdtStatus()
        {
            new Popup('divUpdtStatus',null,{modal:true,position:'center',duration:1});
            document.getElementById('divUpdtStatus').popup.show();
        }

        var RowIdx;
        var fKeyEnt;
        var cari=0;
        var keyword='';
        function listPasien(feel,how,stuff){
            var kasir=document.getElementById('cmbKasir').value;
            var jenisKasir = document.getElementById('cmbKasir').options[document.getElementById('cmbKasir').options.selectedIndex].lang;
			//alert(stuff.length);
			if(how=='show'){
				//alert(feel.which);
				if(feel.which==13 && document.getElementById('div_pasien').style.display!='block'){
					if (stuff==''){
						alert('Masukkan No RM atau Nama Pasien Terlebih Dahulu !');
					}else if(stuff.length<4){
						alert('No RM atau Nama Pasien Yang Dimasukkan Kurang Lengkap !');
					}else{
						keyword=stuff;
						document.getElementById('div_pasien').style.display='block';
						alert('pasien_list_tes.php?act=cari&kasir='+kasir+'&jenisKasir='+jenisKasir+'&keyword='+stuff);
						Request('pasien_list.php?act=cari&kasir='+kasir+'&jenisKasir='+jenisKasir+'&keyword='+stuff,'div_pasien','','GET');
						RowIdx=0;
						
						document.getElementById('det_obt').innerHTML='';
					}
				}
				else if ((feel.which==38 || feel.which==40) && document.getElementById('div_pasien').style.display=='block'){
					//alert(feel.which);
					var tblRow=document.getElementById('pasien_table').rows.length;
					if (tblRow>0){
						//alert(RowIdx);
						if (feel.which==38 && RowIdx>0){
							RowIdx=RowIdx-1;
							document.getElementById(RowIdx+1).className='itemtableReq';
							if (RowIdx>0) document.getElementById(RowIdx).className='itemtableMOverReq';
						}else if (feel.which == 40 && RowIdx < tblRow){
							RowIdx=RowIdx+1;
							if (RowIdx>1) document.getElementById(RowIdx-1).className='itemtableReq';
							document.getElementById(RowIdx).className='itemtableMOverReq';
						}

					}
				}
				else if (feel.which==120 || feel.which==123){
					if (stuff==''){
						alert('Masukkan No RM atau Nama Pasien Terlebih Dahulu !');
					}else if(stuff.length<4){
						alert('No RM atau Nama Pasien Yang Dimasukkan Kurang Lengkap !');
					}else{
						keyword=stuff;
						document.getElementById('div_pasien').style.display='block';
						//alert('pasien_list.php?act=cari&kasir='+kasir+'&jenisKasir='+jenisKasir+'&keyword='+stuff+'&status=all');
						Request('pasien_list.php?act=cari&kasir='+kasir+'&jenisKasir='+jenisKasir+'&keyword='+stuff+'&status=all','div_pasien','','GET');
						RowIdx=0;
					}
				}
				else if (feel.which==13 && RowIdx>0){
					setPasien(document.getElementById(RowIdx).lang);
					keyword='';
				}
				else if(feel.which==27 || stuff==''){
					document.getElementById('div_pasien').style.display='none';
				}
			}
        }

        var dataPasien = new Array();

        function setPasien(val){
            //alert(val);
			batal();
			
            abc="";
            dataPasien=val.split("|");
			
			var p="txtIdBayar*-*"+dataPasien[0]+"*|*NoRm*-*"+dataPasien[1]+"*|*NmOrtu*-*"+dataPasien[4]+"*|*Nama*-*"+dataPasien[2]+"*|*Gender*-*"+dataPasien[5]+"*|*NoBiling*-*"+dataPasien[6]+"*|*lblbiaya*-*"+dataPasien[7]+"*|*txtIdKunj*-*"+dataPasien[9]+"*|*txtTglK*-*"+dataPasien[10]+"*|*txtIdPel*-*"+dataPasien[11]+"*|*txtTitipan*-*"+dataPasien[12]+"*|*txtbayar*-*"+dataPasien[8]+"*|*txtKsoId*-*"+dataPasien[31]+"*|*txtJaminan*-*"+dataPasien[14]+"*|*txtKeringanan*-*0"+"*|*NoBiling*-*"+dataPasien[15]+"*|*txtnobukti*-*"+dataPasien[1]+"*|*txtBayarIGD*-*"+dataPasien[16]+"*|*txtKurangIGD*-*"+dataPasien[17]+"*|*txtBayarTot*-*"+dataPasien[7]+"*|*txtKurangTot*-*"+dataPasien[8]+"*|*txtigdJaminan*-*"+dataPasien[18]+"*|*txtTotJaminan*-*"+dataPasien[14]+"*|*txtBayarAmbulan*-*"+dataPasien[19]+"*|*txtKurangAmbulan*-*"+dataPasien[20]+"*|*txtAmbulanJaminan*-*"+dataPasien[21]+"*|*txtBayarJenazah*-*"+dataPasien[22]+"*|*txtKurangJenazah*-*"+dataPasien[23]+"*|*txtJenazahJaminan*-*"+dataPasien[24]+"*|*txtSudahBayar*-*"+dataPasien[27]+"*|*txtJenisKunj*-*"+dataPasien[28]+"*|*txtUnitId*-*"+dataPasien[32];
            fSetValue(window,p);
				var dataPasien35;// = dataPasien[35];
				if(dataPasien[35] == 'undefined' || dataPasien[35] == ''){
					dataPasien35 = dataPasien[35] * 1;
				}else{dataPasien35 = parseInt(dataPasien[35]);}
			document.getElementById('tagih1').value = dataPasien[7];
			document.getElementById('billing1').value = parseInt(dataPasien[41]);//parseInt(dataPasien[7])-parseInt(dataPasien[35]);
			document.getElementById('billing3').value = parseInt(dataPasien[7])-dataPasien35;
			var biiiil = parseInt(dataPasien[41]);//var biiiil = parseInt(dataPasien[7])-parseInt(dataPasien[35]);
			//alert(dataPasien35);
		if(dataPasien[41]!=0){
			document.getElementById('billing2').innerHTML = "<input type='checkbox' onclick='cekresep(this.lang);bersihAll();' id='cekbilling'> Billing Rp "+biiiil;
		}else{
			document.getElementById('billing2').innerHTML = "<input type='hidden' id='cekbilling'>";
		}
			document.getElementById('obat1').value = dataPasien35;
			document.getElementById('rm1').value = dataPasien[1];
			document.getElementById('pasien1').value = dataPasien[2];
			
			var sip=dataPasien[36].split("***");
			var jum_sip = sip.length;
			var jum_sip2 = jum_sip-1;
			//alert(jum_sip);
			
			document.getElementById('tes').value = dataPasien[36];
			
			document.getElementById('bykresep').value = jum_sip2;
			document.getElementById('jmlresep').value = dataPasien35;
			document.getElementById('minresep').value = dataPasien[37];
			
			if(jum_sip>0){
				//div id = det_obt
				var elm2 = document.getElementById('det_obt');
					for(var z=0;z<jum_sip2;z++){
						var sip2=sip[z].split("-**-");
						
						elm2.innerHTML += "<input type='checkbox' id='pilihresep"+z+"' name='pilihresep["+z+"]' value='"+sip2[1]+"' lang='"+sip2[0]+"' onclick='cekresep(this.lang);bersihAll();' /> Nota Penjualan "+sip2[0]+" - Rp "+sip2[1]+"<input type='hidden' id='plhresep"+z+"' name='plhresep"+z+"' value='"+sip2[0]+"' /><input type='hidden' id='pelresep"+z+"' name='pelresep"+z+"' value='"+sip2[3]+"' /></br>";
						
					}
				//document.getElementById('det_obt').innerHTML += "<tr><td><input type='checkbox' name='pilih' value='"+sip2[1]+"' />"+sip2[1]+"</td><td></td></tr>";
			}
		    
			document.getElementById('spnStatus').innerHTML=dataPasien[33];
			
			if(dataPasien[28]=='3'){
				document.getElementById('btnPrint').disabled=true;
				document.getElementById('HapusKonsul').disabled=false;
				if(dataPasien[34]=='0'){
					document.getElementById('btnBatalPulang').style.display = 'none';
					document.getElementById('btnPasienPulang').style.display = 'table-row';
					
					/* if(dataPasien[40]>0){
						viewHapusKonsul2();
						//dialogtampil();
					}else{
						dialogtampil();
					} */
				}
				else{
					document.getElementById('btnBatalPulang').style.display = 'table-row';
					document.getElementById('btnPasienPulang').style.display = 'none';
					
					/* if(dataPasien[40]>0){
						viewHapusKonsul();
						//dialogtampil();
					} */
				}
			}
			else{
				document.getElementById('btnPrint').disabled=false;
				document.getElementById('HapusKonsul').disabled=true;
				/* document.getElementById('btnPasienPulang').style.display = 'table-row';
				document.getElementById('btnBatalPulang').style.display = 'none'; */
				if(dataPasien[34]=='0'){
					document.getElementById('btnBatalPulang').style.display = 'none';
					document.getElementById('btnPasienPulang').style.display = 'table-row';
				}
				else{
					document.getElementById('btnBatalPulang').style.display = 'table-row';
					document.getElementById('btnPasienPulang').style.display = 'none';
				}
			}
			
            if (dataPasien[14]!="0"){
                document.getElementById('jaminanKSO').style.visibility='visible';
            }else{
                document.getElementById('jaminanKSO').style.visibility='collapse';
            }
			
            if (dataPasien[12]!="0"){
                document.getElementById('tot_titipan').style.visibility='collapse';
            }else{
                document.getElementById('tot_titipan').style.visibility='collapse';
            }
			//alert(dataPasien[8]);
			
			if (dataPasien[29] == 2) {
				document.getElementById('trTipeBayarPaviliun').style.visibility = "visible";
				if (dataPasien[30] == 1) {
					document.getElementById('tipe_bayar_paviliun').checked = true;
				} else {
					document.getElementById('tipe_bayar_paviliun').checked = false;
				}
			} else {
				document.getElementById('trTipeBayarPaviliun').style.visibility = "collapse";
			}
			
			fBayarIGD();

            txtbayar=parseFloat(document.getElementById('txtbayar').value);
            document.getElementById('txtalamat').innerHTML=dataPasien[3];
            document.getElementById('div_pasien').style.display='none';
			document.getElementById('cekBayar').value = 0;
            var idKasir = document.getElementById('cmbKasir').value;
            var jenisKasir = document.getElementById('cmbKasir').options[document.getElementById('cmbKasir').options.selectedIndex].lang;
            //alert("bayar_utils.php?versi=<?php echo $versi; ?>&grd=true&idKunj="+dataPasien[9]+"&idKasir="+idKasir);
            //alert("bayar_utils.php?versi=<?php echo $versi; ?>&grd1=true&idKunj="+dataPasien[9]+"&idPel="+dataPasien[11]+"&idKasir="+idKasir+"&jenisKasir="+jenisKasir);
            a1.loadURL("bayar_utils.php?versi=<?php echo $versi; ?>&grd=true&idKunj="+dataPasien[9]+"&idKasir="+idKasir+"&jenisKunj="+dataPasien[28],"","GET");
            b.loadURL("bayar_utils.php?versi=<?php echo $versi; ?>&grd1=true&idKunj="+dataPasien[9]+"&idPel="+dataPasien[11]+"&idKasir="+idKasir+"&jenisKasir="+jenisKasir,"","GET");
			
			// if(dataPasien[28]==3){
				/* if(dataPasien[40]>0){
					viewHapusKonsul2();
					//dialogtampil();
				}else{
					dialogtampil();
				} */
				if(dataPasien[34]=='0'){
					if(dataPasien[40]>0){
						viewHapusKonsul2();
						//dialogtampil();
					}else{
						dialogtampil();
					}
				}
				else{
					if(dataPasien[40]>0){
						viewHapusKonsul();
						//dialogtampil();
					}
				}
			/* } else {
				if(dataPasien[40]>0){
					viewHapusKonsul();
					//dialogtampil();
				}
			}  */
        }
		
		function dialogtampil(){
			/*if(confirm("Anda akan memulangkan pasien "+dataPasien[2]+".\nAnda yakin?")){
				//Request("../unit_pelayanan/tindiag_utils.php?act=tambah&smpn=btnPasienPulang&kunjungan_id="+dataPasien[9]+"&pelayanan_id="+dataPasien[11]+'&userId=<?php echo $userId;?>','spnResHapusKonsul','','GET',pasPul,'ok');
			}*/
			
			var dialog = "<div style='text-align:center;'>"+
							"<label style='font-size:20px; padding-left:20px; font-weight:bold;'>Anda akan memulangkan pasien "+dataPasien[2]+"</label> <br />"+
							"<label style='font-size:20px; padding-left:20px; font-weight:bold;'>Anda yakin?</label> <br /><br />"+
							"<input type='button' onClick='hideDialog();pulangRI();' value='    YA    ' />&nbsp;&nbsp;&nbsp;"+
							"<input type='button' onClick='hideDialog()' value='  TIDAK  ' />"+
						 "</div>";
			showDialog('Konfirmasi',dialog,'prompt');
		}
		
		function pulangRI(){
		var kasir = document.getElementById('cmbKasir').value;
			//Request("../unit_pelayanan/tindiag_utils.php?act=tambah&smpn=btnPasienPulang&kunjungan_id="+dataPasien[9]+"&pelayanan_id="+dataPasien[11]+'&userId=<?php echo $userId;?>'+"&idKasir="+kasir,'spnResHapusKonsul','','GET',pasPul,'ok');
			Request("../unit_pelayanan/krs/pasienKRS_utils.php?act=tambah&smpn=btnPasienPulang&kunjungan_id="+dataPasien[9]+"&pelayanan_id="+dataPasien[11]+"&userId=<?php echo $userId;?>"+"&idKasir="+kasir,'spnResHapusKonsul','','GET',pasPul,'ok');
		}

		function fBayarIGD(){
			/*
			var p=document.getElementById('bayarIGD').value;
			if (document.getElementById('cmbKasir').value=="82"){
				if (p=='0'){
					document.getElementById('lblbiaya').value=document.getElementById('txtBayarIGD').value;
					document.getElementById('txtbayar').value=document.getElementById('txtKurangIGD').value;
					document.getElementById('txtJaminan').value=document.getElementById('txtigdJaminan').value;
				}else if (p=='2'){
					document.getElementById('lblbiaya').value=document.getElementById('txtBayarAmbulan').value;
					document.getElementById('txtbayar').value=document.getElementById('txtKurangAmbulan').value;
					document.getElementById('txtJaminan').value=document.getElementById('txtAmbulanJaminan').value;
				}else if (p=='3'){
					document.getElementById('lblbiaya').value=document.getElementById('txtBayarJenazah').value;
					document.getElementById('txtbayar').value=document.getElementById('txtKurangJenazah').value;
					document.getElementById('txtJaminan').value=document.getElementById('txtJenazahJaminan').value;
				}else{
					document.getElementById('lblbiaya').value=document.getElementById('txtBayarTot').value;
					document.getElementById('txtbayar').value=document.getElementById('txtKurangTot').value;
					document.getElementById('txtJaminan').value=document.getElementById('txtTotJaminan').value;
				}
			}
			*/
			document.getElementById('lblbiaya').value=document.getElementById('txtBayarTot').value;
			document.getElementById('txtbayar').value=document.getElementById('txtKurangTot').value;
			document.getElementById('txtJaminan').value=document.getElementById('txtTotJaminan').value;
			
			/*
			if (parseFloat(document.getElementById('txtbayar').value)>0){
				document.getElementById('btnSimpan').disabled=false;
			}else{
				document.getElementById('btnSimpan').disabled=true;
			}
			*/
			
			//document.getElementById("txtbayar").readOnly=true;
			document.getElementById('txtIUR').value=document.getElementById('txtbayar').value;
			if(document.getElementById('txtbayar').value<=0){
				//document.getElementById("txtbayar").readOnly=true;
			}
							//document.getElementById('txtbayar').value=parseFloat(document.getElementById('txtbayar').value)-parseFloat(document.getElementById('txtTitipan').value);
			
			if(document.getElementById('txtbayar').value<0) document.getElementById('txtbayar').value=0;
			
			var sisa=0;
			if(document.getElementById('txtIUR').value<0){
				sisa=Math.abs(parseFloat(document.getElementById('txtIUR').value));	
			}
			document.getElementById('txtsisa').value=sisa;
			
			if (sisa>0){
                document.getElementById('trSisa').style.visibility='visible';
            }else{
                document.getElementById('trSisa').style.visibility='collapse';
            }
			
		}

        function kembali()
        {
            if(parseFloat(document.getElementById('txtditerima').value)>parseFloat(document.getElementById('txtbayar').value)){
                document.getElementById('txtkembali').value = parseFloat(document.getElementById('txtditerima').value) - parseFloat(document.getElementById('txtbayar').value);
            }
            else{
                document.getElementById('txtkembali').value = 0;
            }
        }

        function HitungBayar(){
            /*if (document.getElementById('txtKeringanan').value = ""){
                            document.getElementById('txtKeringanan').value = 0;
                    }*/
            document.getElementById('txtbayar').value = parseFloat(document.getElementById('lblbiaya').value) - parseFloat(document.getElementById('txtTitipan').value) - parseFloat(document.getElementById('txtKeringanan').value) - parseFloat(document.getElementById('txtJaminan').value) - parseFloat(document.getElementById('txtSudahBayar').value);
            kembali();
        }

		function up_paviliun(){
			var tipe_bayar_paviliun = (document.getElementById('tipe_bayar_paviliun').checked == true) ? 1 : 0;
			Request("bayar_utils.php?versi=<?php echo $versi; ?>&act=up_paviliun&idKunj="+document.getElementById("txtIdKunj").value+"&tipe_bayar_paviliun="+tipe_bayar_paviliun, 'span_tipe_bayar_paviliun', '','GET', function(){
				alert(document.getElementById('span_tipe_bayar_paviliun').innerHTML);
				batal();
			});
		}
		
		function cekresep(action)
		{
		var cdata='';
		var sx1,sx2,sx3;
		var bykres = document.getElementById('bykresep').value;
		for (var i=0;i<bykres;i++){
			sx1=document.getElementById('plhresep'+i).value;
			sx3=document.getElementById('pelresep'+i).value;
			if (document.getElementById('pilihresep'+i).checked==true){
				sx2="1";
			}else{
				sx2="0";
			}
			while (sx1.indexOf(".")>-1){
				sx1=sx1.replace(".","");
			}
			while (sx3.indexOf(".")>-1){
				sx3=sx3.replace(".","");
			}
			
			cdata +=sx1+'|'+sx2+'|'+sx3+'**';
		}
		//alert(cdata);
		
		var sum = 0;
		var gn, elem, ceken, ceken2;
		
			for (i=0; i<bykres; i++) {
			gn = 'pilihresep'+i;
			elem = document.getElementById(gn);
			if (elem.checked == true) { sum += parseInt(elem.value); }
			}
		ceken = document.getElementById('totalcost').value = sum;
		ceken2 = parseInt(ceken);
		if (document.getElementById('cekbilling').checked==true){
			ceken2 = parseInt(ceken) + parseInt(document.getElementById('billing1').value);
		}
		
		document.getElementById('totalobat1').value = ceken;
		document.getElementById('sisa1').value = parseInt(document.getElementById('bayar1').value) - ceken2;
		document.getElementById('txtbayar').value = document.getElementById('bayar2').value = ceken2;
		
		var pmbyrnx = parseInt(document.getElementById('txtbayar').value);
			/*if(pmbyrnx<=ceken){
			for (i=0; i<bykres; i++) {
			gn = 'pilihresep'+i;
			document.getElementById(gn).checked = false;
			}
			document.getElementById('sisa1').value = document.getElementById('totalobat1').value = '0';
			alert('Pastikan jumlah resep mencukupi !');
			}*/
		if (document.getElementById('resepobat').checked==true){
			document.getElementById('statresep').value = 5;
		}
		}
		
		function cekAll()
		{
			var bykres = document.getElementById('bykresep').value;
			if (document.getElementById('ceksmua').checked==true){
				for (i=0; i<bykres; i++) {
				gn = 'pilihresep'+i;
				document.getElementById(gn).checked = true;
				}
				document.getElementById('cekbilling').checked = true;
			}else if (document.getElementById('ceksmua').checked==false){	
				for (i=0; i<bykres; i++) {
				gn = 'pilihresep'+i;
				document.getElementById(gn).checked = false;
				}
				document.getElementById('cekbilling').checked = false;
			}
		cekresep(bykres);
		}
		
		function bersihAll()
		{
			document.getElementById('ceksmua').checked = false;
		}
		
		function cek(action)
		{
			var pmbyrn = parseInt(document.getElementById('txtbayar').value);
			var tot_tag = parseInt(document.getElementById('lblbiaya').value);
			var tot_obt = parseInt(document.getElementById('jmlresep').value);
			var min_rsp = parseInt(document.getElementById('minresep').value);
			
			if(pmbyrn!=tot_tag){
			  if(pmbyrn<=tot_tag){
			   //document.getElementById('detail_obat').style.visibility='collapse';
			   document.getElementById('obt').disabled=true;
			   //document.getElementById('resepobat').disabled=true;
			   document.getElementById('resepobat').checked = false;
			   clearObt();
			   document.getElementById('statresep').value = 2;
				if(pmbyrn>=tot_obt){
					//alert('Obat terbayarkan global');
					//document.getElementById('detail_obat').style.visibility='collapse';
					document.getElementById('obt').disabled=true;
					//document.getElementById('resepobat').disabled=true;
					document.getElementById('resepobat').checked = false;
					clearObt();
					document.getElementById('statresep').value = 2;
				}else{
					if(pmbyrn>=min_rsp){
						//document.getElementById('detail_obat').style.visibility='visible';
						//document.getElementById('obt').disabled=false;
						//document.getElementById('resepobat').disabled=false;
						clearObt();
						document.getElementById('statresep').value = 3;
						}else{
						//document.getElementById('detail_obat').style.visibility='collapse';
						document.getElementById('obt').disabled=true;
						//document.getElementById('resepobat').disabled=true;
						document.getElementById('resepobat').checked = false;
						clearObt();
						document.getElementById('statresep').value = 4;
					}
				}
			  }else{
			   //document.getElementById('detail_obat').style.visibility='collapse';
			   document.getElementById('obt').disabled=true;
			   //document.getElementById('resepobat').disabled=true;
			   document.getElementById('resepobat').checked = false;
			   clearObt();
			   document.getElementById('statresep').value = 1;
			  }
			}else{
				//document.getElementById('detail_obat').style.visibility='collapse';
				document.getElementById('obt').disabled=true;
				//document.getElementById('resepobat').disabled=true;
			    document.getElementById('resepobat').checked = false;
				clearObt();
				document.getElementById('statresep').value = 1;
			}
		}
		
		function nyalamati()
		{
			if (document.getElementById('resepobat').checked==true){
				document.getElementById('obt').disabled=false;
				document.getElementById('txtbayar').value = '0';
				document.getElementById('statresep').value = 5;
				getObt();
			}else{
				document.getElementById('obt').disabled=true;
			}
			document.getElementById('ceksmua').value='';
			document.getElementById('bayar2').value='';
			document.getElementById('totalobat1').value='';
			
			/* if (document.getElementById('resepobat').checked==true){
				document.getElementById('statresep').value = 5;
			} */
		}
		
		function clearObt()
		{
			var bykres = document.getElementById('bykresep').value;
			for (i=0; i<bykres; i++) {
			gn = 'pilihresep'+i;
			document.getElementById(gn).checked = false;
			}
		}
		
        function simpan(action)
        {
            if(ValidateForm('NoRm,txtnobukti,txttgl,txtbayar','ind'))
            {
				var tglk,tglbyr;
				tglk=document.getElementById("txtTglK").value.split("-");
				tglk=tglk[2]+"-"+tglk[1]+"-"+tglk[0];
				tglbyr=document.getElementById("txttgl").value.split("-");
				tglbyr=tglbyr[2]+"-"+tglbyr[1]+"-"+tglbyr[0];
				//alert(tglbyr+"    "+tglk);
				if (tglbyr<tglk){
                    alert("Tanggal Bayar Tidak Boleh Sebelum Tanggal Kunjungan !");
                    return false;
				}
                if (document.getElementById("txtbayar").value=="0"){
                    alert("Nilai Pembayaran Tidak Boleh 0 !");
                    return false;
                }else if(isNaN(document.getElementById("txtbayar").value)){
                    alert("Nilai Pembayaran Harus Angka !");
                    return false;
                }else{
                    var idBayar = document.getElementById("txtIdBayar").value;
                    var idKunj = document.getElementById("txtIdKunj").value;
					var jenisKunj = document.getElementById("txtJenisKunj").value;
                    var idPel = document.getElementById("txtIdPel").value;
                    var nobukti = document.getElementById("txtnobukti").value;
                    var tgl = document.getElementById("txttgl").value;
                    var nilai = document.getElementById('txtbayar').value;
                    var tagihan = document.getElementById('lblbiaya').value;
					var jaminan_kso = document.getElementById('txtJaminan').value;
                    var titipan = document.getElementById('txtTitipan').value;
					var retursisa = document.getElementById('txtsisa').value;
					
                    var keringanan = document.getElementById('txtKeringanan').value;
                    var dibayaroleh = document.getElementById('txtterima').value;
                    var tipe = document.getElementById('tipe').value;
                    var kasir = document.getElementById('cmbKasir').value;
                    var jenisKasir = document.getElementById('cmbKasir').options[document.getElementById('cmbKasir').options.selectedIndex].lang;
                    var ksoId = document.getElementById('txtKsoId').value;
					var unitId = document.getElementById('txtUnitId').value;
					var cbayarIGD = 1;

                    abc=action;
					
					if (document.getElementById('cmbKasir').value=="82") cbayarIGD = document.getElementById('bayarIGD').value;
					var url;
					var statres = document.getElementById('statresep').value;
					var tot_obtz = parseInt(document.getElementById('jmlresep').value);
					var min_rspz = parseInt(document.getElementById('minresep').value);
					
					var norm = parseInt(document.getElementById('NoRm').value);
					
					var cdataz='';
					var sx1z,sx2z,sx3z,sx4z;
					var bykresz = document.getElementById('bykresep').value;
					for (var i=0;i<bykresz;i++){
						sx1z=document.getElementById('plhresep'+i).value;
						sx4z=document.getElementById('pelresep'+i).value;
						sx3z=document.getElementById('pilihresep'+i).value;
						if (document.getElementById('pilihresep'+i).checked==true){
							sx2z="1";
						}else{
							sx2z="0";
						}
						while (sx1z.indexOf(".")>-1){
							sx1z=sx1z.replace(".","");
						}
						while (sx3z.indexOf(".")>-1){
							sx3z=sx3z.replace(".","");
						}
						while (sx4z.indexOf(".")>-1){
							sx4z=sx4z.replace(".","");
						}
						
						cdataz +=sx1z+'|'+sx2z+'|'+sx3z+'|'+sx4z+'**';
					}
					
					var tes = document.getElementById('tes').value;
					
					var otomasi;
					if (document.getElementById('resepobat').checked==true){
						otomasi = 1;
					}else{
						otomasi = 0;
					}
					
					var bill;
					if (document.getElementById('cekbilling').checked==true){
						bill = 1;
					}else{
						bill = 0;
					}
					var bilingmasuk = document.getElementById('billing3').value;
				//alert("statres="+statres+",tot_obtz="+tot_obtz);
				if(tagihan==0){
					alert('Anda tidak bisa melakukan pembayaran karena tagihan 0 !');
				}else{
					if(statres==1){			//pmbyrn!=tagihan 	; pmbyrn>tagihan
						 if(tot_obtz==0){
							url="bayar_utils.php?versi=<?php echo $versi;?>&grd=true&act="+action+"&idBayar="+idBayar+"&idKunj="+idKunj+"&idPel="+idPel+"&nobukti="+nobukti+"&tgl="+tgl+"&tagihan="+tagihan+"&nilai="+nilai+"&jaminan_kso="+jaminan_kso+"&titipan="+titipan+"&keringanan="+keringanan+"&dibayaroleh="+dibayaroleh+"&userId=<?php echo $userId;?>&tipe="+tipe+"&idKasir="+kasir+"&jenisKasir="+jenisKasir+"&ksoId="+ksoId+"&bayarIGD="+cbayarIGD+"&jenisKunj="+jenisKunj+"&retursisa="+retursisa+"&jenisKunj="+dataPasien[28]+"&unitId="+unitId+"&statpembyrn=1";
							//alert("billing");
						 }else{
							url="bayar_utils.php?versi=<?php echo $versi;?>&grd=true&act="+action+"&idBayar="+idBayar+"&idKunj="+idKunj+"&idPel="+idPel+"&nobukti="+nobukti+"&tgl="+tgl+"&tagihan="+tagihan+"&nilai="+nilai+"&jaminan_kso="+jaminan_kso+"&titipan="+titipan+"&keringanan="+keringanan+"&dibayaroleh="+dibayaroleh+"&userId=<?php echo $userId;?>&tipe="+tipe+"&idKasir="+kasir+"&jenisKasir="+jenisKasir+"&ksoId="+ksoId+"&bayarIGD="+cbayarIGD+"&jenisKunj="+jenisKunj+"&retursisa="+retursisa+"&jenisKunj="+dataPasien[28]+"&unitId="+unitId+"&statpembyrn=2&jmlresep="+tot_obtz+"&bykresep="+bykresz+"&detresep="+cdataz+"&norm="+norm;
							//alert("obat full+sisanya billing1");
						 }
					}else if(statres==2){	//pmbyrn<=tagihan	; pmbyrn>=total_obat
						url="bayar_utils.php?versi=<?php echo $versi;?>&grd=true&act="+action+"&idBayar="+idBayar+"&idKunj="+idKunj+"&idPel="+idPel+"&nobukti="+nobukti+"&tgl="+tgl+"&tagihan="+tagihan+"&nilai="+nilai+"&jaminan_kso="+jaminan_kso+"&titipan="+titipan+"&keringanan="+keringanan+"&dibayaroleh="+dibayaroleh+"&userId=<?php echo $userId;?>&tipe="+tipe+"&idKasir="+kasir+"&jenisKasir="+jenisKasir+"&ksoId="+ksoId+"&bayarIGD="+cbayarIGD+"&jenisKunj="+jenisKunj+"&retursisa="+retursisa+"&jenisKunj="+dataPasien[28]+"&unitId="+unitId+"&statpembyrn=2&jmlresep="+tot_obtz+"&bykresep="+bykresz+"&detresep="+cdataz+"&norm="+norm;
						//alert("obat full+sisanya billing2");
					}else if(statres==3){	//pmbyrn>=min_resep
						url="bayar_utils.php?versi=<?php echo $versi;?>&grd=true&act="+action+"&idBayar="+idBayar+"&idKunj="+idKunj+"&idPel="+idPel+"&nobukti="+nobukti+"&tgl="+tgl+"&tagihan="+tagihan+"&nilai="+nilai+"&jaminan_kso="+jaminan_kso+"&titipan="+titipan+"&keringanan="+keringanan+"&dibayaroleh="+dibayaroleh+"&userId=<?php echo $userId;?>&tipe="+tipe+"&idKasir="+kasir+"&jenisKasir="+jenisKasir+"&ksoId="+ksoId+"&bayarIGD="+cbayarIGD+"&jenisKunj="+jenisKunj+"&retursisa="+retursisa+"&jenisKunj="+dataPasien[28]+"&unitId="+unitId+"&statpembyrn=3&jmlresep="+tot_obtz+"&bykresep="+bykresz+"&detresep="+cdataz+"&norm="+norm+"&tes="+tes+"&otomasi="+otomasi;
						//alert("obat bbrp resep+sisanya billing1");
					}else if(statres==4){	//pmbyrn<min_resep
						url="bayar_utils.php?versi=<?php echo $versi;?>&grd=true&act="+action+"&idBayar="+idBayar+"&idKunj="+idKunj+"&idPel="+idPel+"&nobukti="+nobukti+"&tgl="+tgl+"&tagihan="+tagihan+"&nilai="+nilai+"&jaminan_kso="+jaminan_kso+"&titipan="+titipan+"&keringanan="+keringanan+"&dibayaroleh="+dibayaroleh+"&userId=<?php echo $userId;?>&tipe="+tipe+"&idKasir="+kasir+"&jenisKasir="+jenisKasir+"&ksoId="+ksoId+"&bayarIGD="+cbayarIGD+"&jenisKunj="+jenisKunj+"&retursisa="+retursisa+"&jenisKunj="+dataPasien[28]+"&unitId="+unitId+"&statpembyrn=1";
						//alert("billing");
					}else if(statres==5){	//centang
						url="bayar_utils.php?versi=<?php echo $versi;?>&grd=true&act="+action+"&idBayar="+idBayar+"&idKunj="+idKunj+"&idPel="+idPel+"&nobukti="+nobukti+"&tgl="+tgl+"&tagihan="+tagihan+"&nilai="+nilai+"&jaminan_kso="+jaminan_kso+"&titipan="+titipan+"&keringanan="+keringanan+"&dibayaroleh="+dibayaroleh+"&userId=<?php echo $userId;?>&tipe="+tipe+"&idKasir="+kasir+"&jenisKasir="+jenisKasir+"&ksoId="+ksoId+"&bayarIGD="+cbayarIGD+"&jenisKunj="+jenisKunj+"&retursisa="+retursisa+"&jenisKunj="+dataPasien[28]+"&unitId="+unitId+"&statpembyrn=3&jmlresep="+tot_obtz+"&bykresep="+bykresz+"&detresep="+cdataz+"&norm="+norm+"&tes="+tes+"&otomasi="+otomasi+"&cekbilling="+bill+"&masukbilling="+bilingmasuk;
						//alert("obat bbrp resep+sisanya billing2");
					}
					
					//alert(url);
                    a1.loadURL(url,"","GET");
					batal();
					document.getElementById('cekBayar').value = 1;
				}
                    /*document.getElementById("txtnobukti").value = '';
					document.getElementById("txttgl").value = '';
					document.getElementById("txtbayar").value = '';
					document.getElementById("txtditerima").value = '';
					document.getElementById("txtterima").value = '';
					document.getElementById("txtkembali").value = 0;
					document.getElementById("tipe").value = 0;
					document.getElementById("tipe").checked = false;*/
                }
            }
        }

        function ambilData()
        {
			document.getElementById('cekBayar').value = 1;
            var sisipan=a1.getRowId(a1.getSelRow()).split("|");
            /*var p="txtIdBayar*-*"+sisipan[0]+"*|*txtIdKunj*-*"+sisipan[1]+"*|*txtnobukti*-*"+a1.cellsGetValue(a1.getSelRow(),2)+"*|*txttgl*-*"+a1.cellsGetValue(a1.getSelRow(),3)+"*|*lblbiaya*-*"+sisipan[2]+"*|*txtKeringanan*-*"+sisipan[3]+"*|*txtTitipan*-*"+sisipan[4]+"*|*txtbayar*-*"+a1.cellsGetValue(a1.getSelRow(),4)+"*|*txtterima*-*"+a1.cellsGetValue(a1.getSelRow(),5)+"*|*tipe*-*"+((sisipan[5]=='0')?'false':'true')+"*|*btnSimpan*-*Simpan*|*btnHapus*-*false*|*btnPrint*-*false*|*rincianPas*-*false";*/
            var p="txtIdBayar*-*"+sisipan[0]+"*|*txtIdKunj*-*"+sisipan[1]+"*|*txtnobukti*-*"+sisipan[8]+"*|*txttgl*-*"+sisipan[9]+"*|*lblbiaya*-*"+sisipan[2]+"*|*txtKeringanan*-*"+sisipan[3]+"*|*txtTitipan*-*"+sisipan[4]+"*|*txtbayar*-*"+
			sisipan[10]+"*|*txtterima*-*"+sisipan[11]+"*|*txtJaminan*-*"+sisipan[7]+"*|*tipe*-*"+((sisipan[5]=='0')?'false':'true')+"*|*btnSimpan*-*true*|*btnHapus*-*false*|*btnPrint*-*false*|*rincianPas*-*false*|*txtKasirId*-*"+sisipan[12];
            fSetValue(window,p);
			
			if(sisipan[13]=='3'){
				document.getElementById('btnPrint').disabled=true;	
			}
			else{
				document.getElementById('btnPrint').disabled=false;
			}
			
            abc="PilihPembayaran";
            //document.getElementById('tipe').value=0;
            if(document.getElementById('tipe').checked==true){
                document.getElementById('tipe').value=1;
                document.getElementById('tot_tagihan').style.visibility='collapse';
                document.getElementById('krg_bayar').style.visibility='collapse';
                document.getElementById('tot_titipan').style.visibility='collapse';
                document.getElementById('tdPembayaran').innerHTML="Nilai Titipan &nbsp;";
            }else{
                document.getElementById('tipe').value=0;
                document.getElementById('tot_tagihan').style.visibility='visible';
                document.getElementById('krg_bayar').style.visibility='visible';
                document.getElementById('tot_titipan').style.visibility='collapse';
                document.getElementById('tdPembayaran').innerHTML="Pembayaran &nbsp;";
            }
        }
		
		/*
        function cetakPembayaran(){
			if(document.getElementById('cekBayar').value == 0){
				alert('Lakukan Pembayaran / Pilih Pembayaran Terlebih Dahulu!!!');
			}else{
				if(document.getElementById('tipe').value == 1){
					alert('Pembayaran / Data Pembayaran termasuk titipan!!!');
				}else{
					var sisipan=a1.getRowId(a1.getSelRow()).split("|");
					var idKunj = document.getElementById("txtIdKunj").value;
					var jenisKunj = document.getElementById("txtJenisKunj").value;
					//var cidbayar=(document.getElementById('btnHapus').disabled==true)?document.getElementById('txtIdBayar').value:sisipan[0];
					var cidbayar='';

					if (abc!="") cidbayar=sisipan[0];
					
					window.open('cetakPembayaran.php?kunjungan_id='+idKunj+'&idbayar='+cidbayar+'&idPel='+document.getElementById('txtIdPel').value+'&idUser=<?php echo $userId;?>&jenisKasir='+document.getElementById('cmbKasir').options[document.getElementById('cmbKasir').options.selectedIndex].lang+'&kasir='+document.getElementById('cmbKasir').value+'&jenisKunj='+jenisKunj,'tagihan');
				}
			}
        }
		*/
		
		function cetakPembayaran(){
			if(document.getElementById('cekBayar').value == 0){
				alert('Lakukan Pembayaran / Pilih Pembayaran Terlebih Dahulu!!!');
			}else{
				var sisipan=a1.getRowId(a1.getSelRow()).split("|");
				var idKunj = document.getElementById("txtIdKunj").value;
				var jenisKunj = document.getElementById("txtJenisKunj").value;
				//var cidbayar=(document.getElementById('btnHapus').disabled==true)?document.getElementById('txtIdBayar').value:sisipan[0];
				var cidbayar='';

				if (abc!="") cidbayar=sisipan[0];
				
				window.open('cetakPembayaran_rj.php?kunjungan_id='+idKunj+'&idbayar='+cidbayar+'&idPel='+document.getElementById('txtIdPel').value+'&idUser=<?php echo $userId;?>&jenisKasir='+document.getElementById('cmbKasir').options[document.getElementById('cmbKasir').options.selectedIndex].lang+'&kasir='+sisipan[12]+'&jenisKunj='+jenisKunj,'tagihan1');
			}
        }
		
		function cetakKwitansi(){
			if(document.getElementById('cekBayar').value == 0){
				alert('Lakukan Pembayaran / Pilih Pembayaran Terlebih Dahulu!!!');
			}else{
				var sisipan=a1.getRowId(a1.getSelRow()).split("|");
				var idKunj = document.getElementById("txtIdKunj").value;
				var jenisKunj = document.getElementById("txtJenisKunj").value;
				var cidbayar='';

				if (abc!="") cidbayar=sisipan[0];
				if(jenisKunj=='3' || jenisKunj=='2'){
					window.open('cetakPembayaran.php?kunjungan_id='+idKunj+'&idbayar='+cidbayar+'&idPel='+document.getElementById('txtIdPel').value+'&idUser=<?php echo $userId;?>&jenisKasir='+document.getElementById('cmbKasir').options[document.getElementById('cmbKasir').options.selectedIndex].lang+'&kasir='+document.getElementById('cmbKasir').value+'&jenisKunj='+jenisKunj,'tagihan');
				}
				else{
					window.open('cetakPembayaran.php?kunjungan_id='+idKunj+'&idbayar='+cidbayar+'&idPel='+document.getElementById('txtIdPel').value+'&idUser=<?php echo $userId;?>&jenisKasir='+document.getElementById('cmbKasir').options[document.getElementById('cmbKasir').options.selectedIndex].lang+'&kasir='+document.getElementById('cmbKasir').value+'&jenisKunj='+jenisKunj,'tagihan2');	
				}
				
				

			}
        }

		function RincianTagihan(){
            var sisipan=a1.getRowId(a1.getSelRow()).split("|");
            var idKunj = document.getElementById("txtIdKunj").value;
			var ksoId = document.getElementById('txtKsoId').value;
			var jenisKunj = (document.getElementById("txtJenisKunj").value=='3')?1:0;
            //		var cidbayar=(document.getElementById('btnHapus').disabled==true)?document.getElementById('txtIdBayar').value:sisipan[0];
            var cidbayar='',url;

            //alert(abc);
            if (abc!="") cidbayar=sisipan[0];
			
			url='../unit_pelayanan/RincianTindakanAll.php?idKunj='+idKunj+'&idPel='+document.getElementById('txtIdPel').value+'&idUser=<?php echo $userId;?>&tipe='+jenisKunj;
            window.open(url,'_blank');
        }

		function CetakRincianTagihan(x){
            var sisipan=a1.getRowId(a1.getSelRow()).split("|");
            var idKunj = document.getElementById("txtIdKunj").value;
			var ksoId = document.getElementById('txtKsoId').value;
			var cidbayar='',url;

            if (abc!="") cidbayar=sisipan[0];
			
			url='../unit_pelayanan/RincianTindakanAllPel.php?idKunj='+idKunj+'&idPel='+document.getElementById('txtIdPel').value+'&idUser=<?php echo $userId;?>&tipe='+x;
            window.open(url,'_blank');
        }
		
		function CetakRekapKSOTagihan(x){
            var idKunj = document.getElementById("txtIdKunj").value;
			
			url='tagihan.php?idKunj='+idKunj+'&idPel='+document.getElementById('txtIdPel').value+'&idUser=<?php echo $userId;?>&tipe='+x;
            window.open(url,'_blank');
        }
		
		function CetakRekapTagihan(x){
            var idKunj = document.getElementById("txtIdKunj").value;
			
			url='../unit_pelayanan/RekapTindakanAllPel.php?idKunj='+idKunj+'&idPel='+document.getElementById('txtIdPel').value+'&idUser=<?php echo $userId;?>&tipe='+x;
            window.open(url,'_blank');
        }
		
		function RincianTindakan(x){
			var idKunj = document.getElementById("txtIdKunj").value;
			Request('bayar_utils.php?versi=<?php echo $versi; ?>&getIdPelayanan=true&idKunj='+idKunj+'&unit_id='+x,'cmbRincianTindakan','','GET',function(){
				new Popup('divRincianTindakan',null,{modal:true,position:'center',duration:1});
            	document.getElementById('divRincianTindakan').popup.show();	
			},'noload');
		}
		
		function CetakRincian(menu){
			var sisipan=a1.getRowId(a1.getSelRow()).split("|");
            var idKunj = document.getElementById("txtIdKunj").value;
			var url;

			if(menu==0){
				url='../unit_pelayanan/RincianObatAll.php?idKunj='+idKunj+'&idPel='+document.getElementById('txtIdPel').value+'&idUser=<?php echo $userId;?>&tipe=0';
			}
			else if(menu==1){
				url='../unit_pelayanan/RincianObatAll.php?idKunj='+idKunj+'&idPel='+document.getElementById('txtIdPel').value+'&idUser=<?php echo $userId;?>&tipe=1';
			}
			else if(menu==2){
				url='../unit_pelayanan/RincianObatAll.php?idKunj='+idKunj+'&idPel='+document.getElementById('txtIdPel').value+'&idUser=<?php echo $userId;?>&tipe=2';
			}
            window.open(url,'_blank');
		}
		
		function CetakRincianTindakan(p){
            var sisipan=a1.getRowId(a1.getSelRow()).split("|");
            var idKunj = document.getElementById("txtIdKunj").value;
			var cidbayar='',url;
			
			url='../unit_pelayanan/RincianTindakanX.php?idKunj='+idKunj+'&idPel='+p+'&idUser=<?php echo $userId;?>';
            window.open(url,'_blank');
        }

        function tagihan(p){
            //alert(abc);
			if (p==0){
				if (abc!=""){
					var sisipan=a1.getRowId(a1.getSelRow()).split("|");
					var idKunj = document.getElementById("txtIdKunj").value;
					var cidbayar='';
					cidbayar=sisipan[0];
					window.open('tagihan.php?kunjungan_id='+idKunj+'&idbayar='+cidbayar+'&idPel='+document.getElementById('txtIdPel').value+'&idUser=<?php echo $userId;?>&jenisKasir='+document.getElementById('cmbKasir').options[document.getElementById('cmbKasir').options.selectedIndex].lang+'&kasir='+document.getElementById('cmbKasir').value,'tagihan');
				}else{
					alert("Pilih Pembayaran Terlebih Dahulu !");
				}
			}else if(p==1){
				if (abc!=""){
					var sisipan=a1.getRowId(a1.getSelRow()).split("|");
					var idKunj = document.getElementById("txtIdKunj").value;
					var cidbayar='';
					cidbayar=sisipan[0];
					window.open('tagihanKurang.php?kunjungan_id='+idKunj+'&idbayar='+cidbayar+'&idPel='+document.getElementById('txtIdPel').value+'&idUser=<?php echo $userId;?>&jenisKasir='+document.getElementById('cmbKasir').options[document.getElementById('cmbKasir').options.selectedIndex].lang+'&kasir='+document.getElementById('cmbKasir').value,'tagihan');
				}else{
					alert("Pilih Pembayaran Terlebih Dahulu !");
				}
			}
        }

        function hapus()
        {
			var idKasir = document.getElementById('cmbKasir').value;
            var rowid = document.getElementById("txtIdBayar").value;
			var url;
            Request("bayar_action.php?action=getLimit&idbayar="+rowid,'limithapus','','GET',function(){
				var data = document.getElementById('limithapus').innerHTML;
				if(data > 0){
					alert('Sudah melebihi 1 hari, tidak bisa dihapus!!!');
					batal();
				} else {
					if(confirm("Anda yakin menghapus Data Pembayaran "+a1.cellsGetValue(a1.getSelRow(),2)))
					{
						document.getElementById('cekBayar').value = 0;
						url="bayar_utils.php?versi=<?php echo $versi; ?>&grd=true&idKunj="+dataPasien[9]+"&idKasir="+idKasir+"&act=hapus&rowid="+rowid+"&jenisKunj="+dataPasien[28]+"&userId=<?php echo $userId;?>";
						//alert(url);
						a1.loadURL(url,"","GET");
					}
					batal();
				}
			});
        }
		
        function batal(){
            //alert('tes');
			document.getElementById('spnStatus').innerHTML='';
            document.getElementById('btnSimpan').value='Tambah';
            document.getElementById('btnSimpan').disabled=false;
            document.getElementById('btnHapus').disabled=true;
            document.getElementById('txtIdBayar').value='';
            document.getElementById('txtterima').value='';
            document.getElementById('txtbayar').value='0';
			document.getElementById('txtSudahBayar').value='0';
			document.getElementById('txtBayarIGD').value='0';
			document.getElementById('txtKurangIGD').value='0';
			document.getElementById('bayarIGD').options.selectedIndex = 0;
			document.getElementById('txtBayarAmbulan').value='0';
			document.getElementById('txtKurangAmbulan').value='0';
			document.getElementById('txtBayarJenazah').value='0';
			document.getElementById('txtKurangJenazah').value='0';
			document.getElementById('txtBayarTot').value='0';
			document.getElementById('txtKurangTot').value='0';
			document.getElementById('txtigdJaminan').value='0';
			document.getElementById('txtAmbulanJaminan').value='0';
			document.getElementById('txtJenazahJaminan').value='0';
			document.getElementById('txtTotJaminan').value='0';
            document.getElementById('txtditerima').value='0';
            document.getElementById('txtkembali').value='0';
            document.getElementById('txtnobukti').value='';
            document.getElementById('lblbiaya').value='0';
            document.getElementById('txtTitipan').value='0';
            document.getElementById('txtJaminan').value='0';
            document.getElementById('txtKeringanan').value='0';
            document.getElementById('tot_tagihan').style.visibility='visible';
            document.getElementById('krg_bayar').style.visibility='visible';
            document.getElementById('tot_titipan').style.visibility='collapse';
            document.getElementById('tdPembayaran').innerHTML="Pembayaran &nbsp;";
            document.getElementById("tipe").value = 0;
            document.getElementById("tipe").checked = false;
			document.getElementById('cekBayar').value = 0;
			document.getElementById('txtsisa').value='0';
            //document.getElementById('cmbKasir').value='';
			document.getElementById('bykresep').value='0';
			document.getElementById('jmlresep').value='0';
			document.getElementById('minresep').value='0';
			document.getElementById('statresep').value='1';
			//document.getElementById('detail_obat').style.visibility='collapse';
			document.getElementById('obt').disabled=true;
			document.getElementById('resepobat').disabled=false;
			document.getElementById('resepobat').checked = false;
			document.getElementById('det_obt').innerHTML='';
			document.getElementById('ceksmua').checked = false;
			document.getElementById('bayar2').value='';
			document.getElementById('totalobat1').value='';
        }

        function saringByKasir(par){
            //alert('change');
            var idKasir = par.value;//document.getElementById('cmbKasir').value;
            abc="";
            a1.loadURL("bayar_utils.php?versi=<?php echo $versi; ?>&grd=true&idKunj="+dataPasien[9]+"&idKasir="+idKasir+"&jenisKunj="+dataPasien[28],"","GET");
            batal();
            filterTagihan(par);
        }
		
		function SetTRIGD(par){
			if (par.value == '82'){
				document.getElementById('idTrIGD').style.visibility='collapse';
			}else{
				document.getElementById('idTrIGD').style.visibility='collapse';
				document.getElementById("bayarIGD").value=0;
				document.getElementById("bayarIGD").checked=false;
			}
		}
        
		SetTRIGD(document.getElementById("cmbKasir"));
		
        function filterTagihan(par){
            if((par.value == '82' || par.value == '83' || par.value == '89') && document.getElementById('tipe').checked == false){
                document.getElementById('btnTagihan').disabled = false;
            }
            else{
                document.getElementById('btnTagihan').disabled = true;
            }
			SetTRIGD(par);
        }

        function goFilterAndSort(grd){
            //alert(grd);
            if (grd=="gridbox"){
                a1.loadURL("bayar_utils.php?versi=<?php echo $versi; ?>&grd=true&idKunj="+dataPasien[10]+"&idKasir="+idKasir+"&jenisKunj="+dataPasien[28]+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage(),"","GET");
            }else if(grd=="gridTind"){
                b.loadURL("bayar_utils.php?versi=<?php echo $versi; ?>&grd1=true&idKunj="+dataPasien[10]+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage(),"","GET");
            }
        }

        if(document.getElementById('cmbKasir').value != 89 && document.getElementById('cmbKasir').value != 82 && document.getElementById('cmbKasir').value != 83){
            document.getElementById('btnTagihan').disabled = true;
        }
		
		function konfirmasi(key,val){
			var cdata,tangkap,proses,msg,tombolSimpan,tombolHapus;
			//alert(val+'-'+key);
			/*var tangkap=val.split("*|*");
			var proses=tangkap[0];
			var tombolSimpan=tangkap[1];
			var tombolHapus=tangkap[2];*/
			if (val!=undefined){
				cdata=val.split(String.fromCharCode(1));
				proses=cdata[0];
				msg=cdata[1];
			}
			if(key=='Error'){
				if(proses=='tambah'){
					if(msg!='')
						alert(msg);
					else
						alert('Proses Pembayaran Gagal !');
				}
				else if(proses=='hapus'){
					if(msg!='')
						alert(msg);
					else
						alert('Hapus Pembayaran Gagal !');
				}
			}
			/*else{
				if (a1.getMaxPage()>0){
					document.getElementById('btnPrint').disabled = false;
					document.getElementById('btnPrint').disabled = false;
				}else{
					document.getElementById('btnTagihan').disabled = true;
					document.getElementById('btnTagihan').disabled = true;
				}
				if(proses=='tambah'){
					alert('Tambah Berhasil');
				}
				else if(proses=='hapus'){
					alert('Hapus Berhasil');
				}
			}*/

		}

        var a1=new DSGridObject("gridbox");
        a1.setHeader("DATA PEMBAYARAN");
        a1.setColHeader("NO,TANGGAL,NO BUKTI BAYAR,JUMLAH,STATUS,TERIMA DARI,PETUGAS INPUT,JENIS KASIR");
        a1.setIDColHeader(",tgl,nobukti,nilai,,dibayaroleh,");
        a1.setColWidth("30,100,100,60,100,120,200,80");
        a1.setCellAlign("center,center,center,center,center,center,left,center");
        a1.setCellHeight(20);
        a1.setImgPath("../icon");
        a1.setIDPaging("paging");
        a1.attachEvent("onRowClick","ambilData");
        a1.onLoaded(konfirmasi);
        a1.baseURL("bayar_utils.php?versi=<?php echo $versi; ?>&grd=true");
        a1.Init();


        var b=new DSGridObject("gridTind");
        b.setHeader("DATA TINDAKAN PASIEN");
        b.setColHeader("NO,KODE,TINDAKAN,KELAS,BIAYA,JUMLAH,SUBTOTAL,DOKTER,KETERANGAN");
        b.setIDColHeader(",kdTind,nmTind,,,,,konsul,");
        b.setColWidth("30,80,250,75,65,45,70,200,150");
        b.setCellAlign("center,center,left,center,right,center,right,left,left");
        b.setCellHeight(20);
        b.setImgPath("../icon");
        //b.setIDPaging("paging");
        /*b.attachEvent("onRowClick","ambilDataTind");*/
        b.baseURL("bayar_utils.php?versi=<?php echo $versi; ?>&grd1=true&idKunj="+document.getElementById('txtIdKunj').value);
        b.Init();
		
		var hk=new DSGridObject("gridHapusKonsul");
        hk.setHeader("DATA KONSUL YANG BELUM DILAYANI/MRS BELUM DITINDAK");
        hk.setColHeader("NO,TGL,TEMPAT LAYANAN,ASAL LAYANAN,PROSES");
        hk.setIDColHeader(",,,,");
        hk.setColWidth("30,160,220,220,70");
        hk.setCellAlign("center,center,left,left,center");
        hk.setCellHeight(20);
        hk.setImgPath("../icon");
        hk.baseURL("bayar_utils.php?versi=<?php echo $versi; ?>&grd1=true&idKunj="+document.getElementById('txtIdKunj').value+"&pulang=1");
        hk.Init();
		
		var hk2=new DSGridObject("gridHapusKonsul2");
        hk2.setHeader("DATA KONSUL YANG BELUM DILAYANI/MRS BELUM DITINDAK");
        hk2.setColHeader("NO,TGL,TEMPAT LAYANAN,ASAL LAYANAN,PROSES");
        hk2.setIDColHeader(",,,,");
        hk2.setColWidth("30,160,220,220,70");
        hk2.setCellAlign("center,center,left,left,center");
        hk2.setCellHeight(20);
        hk2.setImgPath("../icon");
        hk2.baseURL("bayar_utils.php?versi=<?php echo $versi; ?>&grd1=true&idKunj="+document.getElementById('txtIdKunj').value+"&pulang=0");
        hk2.Init();
		
		function hapusKonsul(p,r){
			if(confirm('Anda Yakin Ingin Menghapus Pelayanan Tersebut ?')){
				//alert(r);
				 Request('bayar_utils.php?versi=<?php echo $versi; ?>&act=hapuspel&id='+p,'spnResHapusKonsul','','GET',function(){
					if(r==0){
					hk2.loadURL("bayar_utils.php?versi=<?php echo $versi; ?>&grd2=true&idKunj="+dataPasien[9]+"&idPel="+dataPasien[11]+"&jenisKunj="+dataPasien[28]+"&pulang=0","","GET");
					}else{
					hk.loadURL("bayar_utils.php?versi=<?php echo $versi; ?>&grd2=true&idKunj="+dataPasien[9]+"&idPel="+dataPasien[11]+"&jenisKunj="+dataPasien[28]+"&pulang=1","","GET");
					}
					alert(document.getElementById('spnResHapusKonsul').innerHTML);		
				},'noload')	 
			}
		}
		
		function masih_progres(p){
			alert('On Progress...');
		}
		
		function pasienPulang(){
		var kasir = document.getElementById('cmbKasir').value;
			if(confirm("Anda akan memulangkan pasien "+document.getElementById('Nama').value+".\nAnda yakin?")){
				//alert("../unit_pelayanan/krs/pasienKRS_utils.php?act=tambah&smpn=btnPasienPulang&kunjungan_id="+dataPasien[9]+"&pelayanan_id="+dataPasien[11]+"&userId=<?php echo $userId;?>"+"&idKasir="+kasir);
				//Request("../unit_pelayanan/tindiag_utils.php?act=tambah&smpn=btnPasienPulang&kunjungan_id="+dataPasien[9]+"&pelayanan_id="+dataPasien[11]+'&userId=<?php echo $userId;?>'+"&idKasir="+kasir,'spnResHapusKonsul','','GET',pasPul,'ok');
				Request("../unit_pelayanan/krs/pasienKRS_utils.php?act=tambah&smpn=btnPasienPulang&kunjungan_id="+dataPasien[9]+"&pelayanan_id="+dataPasien[11]+"&userId=<?php echo $userId;?>"+"&idKasir="+kasir,'spnResHapusKonsul','','GET',pasPul,'ok');
			}	
		}
		
		function batalPulang(){
		var kasir = document.getElementById('cmbKasir').value;
			if(confirm("Pasien "+document.getElementById('Nama').value+" batal dipulangkan.\nAnda yakin?")){
				//alert("../unit_pelayanan/krs/pasienKRS_utils.php?act=hapus&hps=btnBatalPulang&kunjungan_id="+dataPasien[9]+"&pelayanan_id="+dataPasien[11]+'&userId=<?php echo $userId;?>');
				//Request("../unit_pelayanan/tindiag_utils.php?act=hapus&hps=btnBatalPulang&kunjungan_id="+dataPasien[9]+"&pelayanan_id="+dataPasien[11]+'&userId=<?php echo $userId;?>','spnResHapusKonsul','','GET',pasPul,'ok');
				Request("../unit_pelayanan/krs/pasienKRS_utils.php?act=hapus&hps=btnBatalPulang&kunjungan_id="+dataPasien[9]+"&pelayanan_id="+dataPasien[11]+'&userId=<?php echo $userId;?>','spnResHapusKonsul','','GET',pasPul,'ok');
			}	
		}
		
		function pasPul(){
			var privilege='<?php echo $privilege; ?>';
			if(document.getElementById('spnResHapusKonsul').innerHTML == 'Berhasil dipulangkan'){
				alert("Pasien "+document.getElementById('Nama').value+" "+document.getElementById('spnResHapusKonsul').innerHTML);
				if(privilege=='1'){
					document.getElementById('btnBatalPulang').style.display = 'table-row';	
				}
				else{
					document.getElementById('btnBatalPulang').style.display = 'none';
				}
				document.getElementById('btnPasienPulang').style.display = 'none';
			}else if(document.getElementById('spnResHapusKonsul').innerHTML == 'Waktu Pembatalan Telah Habis!!!'){
				alert(document.getElementById('spnResHapusKonsul').innerHTML);
			}else{
				alert(document.getElementById('spnResHapusKonsul').innerHTML);
				document.getElementById('btnBatalPulang').style.display = 'none';
				document.getElementById('btnPasienPulang').style.display = 'table-row';
			}
		}
    </script>
    <script language="JavaScript1.2">mmLoadMenus();</script>
</html>
<?php 
mysql_close($konek);
?>