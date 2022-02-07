<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
$userId = $_SESSION['userId'];
if(!isset($userId) || $userId == ''){
    header('location:../index.php');
}
$userId = $_SESSION['userId'];//echo $userId."<br>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>Form Pembayaran</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="Cache-Control" content="no-cache, must-revalidate" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
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
                    <td width="5%">&nbsp;</td>
                    <td width="18%" align="right">Nomer RM &nbsp;</td>
                    <td colspan="2"><input type="text" name="NoRm" id="NoRm" size="20" class="txtinputreg" tabindex="1" onkeyup="listPasien(event,'show',this.value,this.id)"/>
                        <input id="txtIdBayar" name="txtIdBayar" type="hidden"/>
                        <input id="txtIdKunj" name="txtIdKunj" type="hidden"/>
                        <input id="txtIdPel" name="txtIdPel" type="hidden"/>
                        <input id="txtKsoId" name="txtKsoId" type="hidden"/>
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
                    <td width="10%">No Billing &nbsp;<input name="NoBiling" id="NoBiling" tabindex="2" size="15" class="txtinputreg" readonly="readonly" /></td>
                    <td colspan="3" align="right">Nama Ortu&nbsp;                      <input name="NmOrtu" id="NmOrtu" size="25" class="txtinputreg" readonly="readonly" /></td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Nama &nbsp;</td>
                    <td colspan="3"><input type="text" class="txtinputreg" name="Nama" id="Nama" size="56" tabindex="3" onkeyup="listPasien(event,'show',this.value,this.id)"/>
                        <div id="div_pasien" align="center" class="div_pasien" style="display:none"></div></td>
                    <td width="15%" colspan="3" rowspan="2" align="right">Alamat &nbsp;&nbsp;<textarea name="txtalamat" id="txtalamat" class="txtinputreg" rows="1" cols="40" readonly="readonly"></textarea></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Jenis Kelamin &nbsp;</td>
                    <td colspan="3"><select name="Gender" id="Gender" class="txtinputreg">
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option></select>&nbsp;<!--Umur&nbsp;<input type="text" style="text-align:center;" class="txtinputreg" name="th" id="th" size="3" tabindex="8" onkeyup="gantiTgl()"/>
			  &nbsp;Th&nbsp;&nbsp;<input type="text" style="text-align:center;" class="txtinputreg" name="Bln" id="Bln" size="3" tabindex="9" onkeyup="gantiTgl()"/>&nbsp;Bln--></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td width="12%">&nbsp;</td>
                    <td width="5%">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="3" align="right"><!--input name="UpdStatusPx" id="UpdStatusPx" type="button" value="Update Status Pasien" class="tblBtn" onclick="PopUpdtStatus();" /--></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td colspan="7">
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="40%">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                            <td width="60%" align="right">Kasir&nbsp;									</td>
                                            <td width="40%">
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
                                            <td width="60%" align="right">Untuk Pembayaran &nbsp;</td>
                                            <td width="40%">
                                            	<select id="bayarIGD" name="bayarIGD" class="txtinput" onchange="fBayarIGD();">
                                                    <option value="0">IGD</option>
                                                    <option value="1">Rawat Inap</option>
                                                    <option value="2">Ambulan</option>
                                                    <option value="3">Kamar Jenazah</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="60%" align="right">Bayar Titipan &nbsp;</td>
                                            <td width="40%"><input name="tipe" id="tipe" type="checkbox" value="0" onclick="Jaminan(this.value);" />&nbsp;</td>
                                        </tr>
                                        <tr style="visibility:collapse">
                                            <td width="60%" align="right">No. Bukti Bayar &nbsp;</td>
                                            <td width="40%"><input size="12" type="text" class="txtinputreg" id="txtnobukti" name="txtnobukti"/></td>
                                        </tr>
                                        <tr>
                                            <td width="60%" align="right">Tanggal &nbsp;</td>
                                            <td width="40%"><input id="txttgl" name="txttgl" readonly="readonly" size="11" class="txtcenter" value="<?php echo $date_now;?>"/>&nbsp;<input type="button" name="ButtonTglLahir" value=" V " class="txtcenter" <?php echo $DisableBD; ?> onClick="gfPop.fPopCalendar(document.getElementById('txttgl'),depRange);" /></td>
                                        </tr>
                                        <tr id="tot_tagihan">
                                            <td width="60%" align="right">Total Tagihan &nbsp;</td>
                                            <td width="40%"><input name="lblbiaya" class="txtinputreg" id="lblbiaya" style="text-align:right" value="0" size="10" readonly="true" /></td>
                                        </tr>
                                        <tr id="tot_titipan">
                                            <td align="right">Total Titipan &nbsp;</td>
                                            <td><input name="txtTitipan" class="txtinputreg" id="txtTitipan" style="text-align:right" value="0" size="10" readonly="true" /></td>
                                        </tr>
                                        <tr id="jaminanKSO" style="visibility:collapse">
                                            <td align="right">Jaminan KSO &nbsp;</td>
                                            <td><input name="txtJaminan" class="txtinputreg" id="txtJaminan" style="text-align:right" value="0" size="10" readonly="true" /></td>
                                        </tr>
                                        <tr id="krg_bayar">
                                            <td width="60%" align="right">Keringanan &nbsp;</td>
                                            <td width="40%" style="color:#0000FF"><input id="txtKeringanan" style="text-align:right" name="txtKeringanan" size="10" class="txtinputreg" value="0" onkeyup="HitungBayar()" /></td>
                                        </tr>
                                        <tr>
                                            <td width="60%" height="34" align="right" id="tdPembayaran" style="color:#0000FF">Pembayaran &nbsp;</td>
                                            <td width="40%"><input name="txtbayar" class="txtinputreg" id="txtbayar" style="text-align:right" value="0" size="10" /></td>
                                        </tr>
                                        <tr>
                                            <td width="60%" align="right" style="border-top:1px solid">Jumlah Uang Diterima &nbsp;</td>
                                            <td width="40%" style="border-top:1px solid"><input id="txtditerima" name="txtditerima" size="10" class="txtinputreg" style="text-align:right" value="0" onkeyup="kembali()"/></td>
                                        </tr>
                                        <tr>
                                            <td width="60%" align="right" style="border-top:1px solid">Jumlah Uang Kembali &nbsp;</td>
                                            <td width="40%" style="border-top:1px solid"><input id="txtkembali" name="txtkembali" size="10" value="0" class="txtinputreg" style="text-align:right" readonly="true"/></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <!--td width="60%" align="right">Sebagai Pembayaran &nbsp;&nbsp;&nbsp;</td>
                                            <td width="40%" align="right"><select></select></td-->
                                        </tr>
                                    </table>                                </td>
                                <td width="60%" align="right"><div id="gridbox" style="width:525px; height:150px; background-color:white; overflow:hidden;"></div>
                                    <div id="paging" style="width:525px;"></div>                                </td>
                            </tr>
                        </table>                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="3" align="right">Terima Dari&nbsp;</td>
                    <td><input size="35" class="txtinputreg" id="txtterima" name="txtterima" /></td>
                    <td align="justify">&nbsp;</td>
                    <td colspan="2" align="right">&nbsp;
                        <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="simpan(this.value);" class="tblTambah"/>
                        <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus"/>
                        <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/>                    </td>
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
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="7" style="border-bottom:2px solid" height="0">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <!--tr>
                      <td>&nbsp;</td>
                      <td colspan="2" align="right"><b>Total Biaya Pengunjung</b></td>
                      <td align="right"><b>0</b></td>
                      <td>&nbsp;</td>
                      <td style="color:#FF0000" align="right">Kurang</td>
                      <td style="color:#FF0000" align="right">0</td>
                      <td>&nbsp;</td>
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
	  </tr-->
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="7" align="center"><input name="btnPrint" id="btnPrint" type="button" class="tblCetak" value="&nbsp;&nbsp;&nbsp;Cetak" onclick="cetakPembayaran();" disabled="disabled" />&nbsp;
                        <input name="tind" id="tind" type="button" value="Lihat Tindakan" class="tblBtn" onclick="getTind()" />&nbsp;
                        <input name="rincianPas" id="rincianPas" type="button" value="Rincian Tindakan" class="tblBtn" onclick="RincianTagihan();" />&nbsp;
                        <input name="tagihan" id="btnTagihan" type="button" value="Tagihan" class="tblBtn" style="cursor:pointer" onMouseOver="MM_showMenu(window.mm_menu_0814123211_3,0,-80,null,'btnTagihan');" onMouseOut="MM_startTimeout();" />                    </td>
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
                document.getElementById('tdPembayaran').innerHTML="Nilai Titipan &nbsp;&nbsp;";
                document.getElementById('txtbayar').value=0;
                //document.getElementById('txtbayar').readOnly=false;
                document.getElementById('txtditerima').value=0;
                document.getElementById('txtkembali').value=0;
            }else{
                document.getElementById('tipe').value=0;
                document.getElementById('tot_tagihan').style.visibility='visible';
                document.getElementById('krg_bayar').style.visibility='visible';
                document.getElementById('tot_titipan').style.visibility='visible';
                document.getElementById('tdPembayaran').innerHTML="Pembayaran &nbsp;&nbsp;";
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

        function getTind()
        {
            new Popup('divTind',null,{modal:true,position:'center',duration:1});
            document.getElementById('divTind').popup.show();
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
        function listPasien(feel,how,stuff,txtId){
			//alert('asd');
            var kasir=document.getElementById('cmbKasir').value;
            var jenisKasir = document.getElementById('cmbKasir').options[document.getElementById('cmbKasir').options.selectedIndex].lang;
			//alert(stuff.length);
			String.prototype.lpad = function(padString, length) {
					var str = this;
					while (str.length < length)
						str = padString + str;
					return str;
			}
			if(stuff.length<4)
			{
					/*String.prototype.lpad = function(padString, length) {
					var str = this;
					while (str.length < length)
						str = padString + str;
					return str;
					}
*/			}
			//stuff = stuff.lpad('0',8);
			//alert(stuff);
			if(how=='show'){
				//alert(feel.which);
				if(feel.which==13 && document.getElementById('div_pasien').style.display!='block'){
					if (stuff==''){
						alert('Masukkan No RM atau Nama Pasien Terlebih Dahulu !');
					}else if(stuff.length<4){
						/*
						if(txtId=='NoRm' && stuff.length<1){
							String.prototype.lpad = function(padString, length) {
								var str = this;
								while (str.length < length)
									str = padString + str;
								return str;
							}
							stuff = stuff.lpad('0',8);
						}
						*/
						//else if(stuff.length<4){
							alert('No RM atau Nama Pasien Yang Dimasukkan Kurang Lengkap !');
						//}
					}else{
						//alert(stuff);
						keyword=stuff;
						document.getElementById('div_pasien').style.display='block';
						//alert('pasien_list.php?act=cari&kasir='+kasir+'&jenisKasir='+jenisKasir+'&keyword='+stuff);
						Request('pasien_list.php?act=cari&kasir='+kasir+'&jenisKasir='+jenisKasir+'&keyword='+stuff,'div_pasien','','GET');
						RowIdx=0;
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
				else if (feel.which==123){
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
            abc="";
            dataPasien=val.split("|");
			var p="txtIdBayar*-*"+dataPasien[0]+"*|*NoRm*-*"+dataPasien[1]+"*|*NmOrtu*-*"+dataPasien[4]+"*|*Nama*-*"+dataPasien[2]+"*|*Gender*-*"+dataPasien[5]+"*|*NoBiling*-*"+dataPasien[6]+"*|*lblbiaya*-*"+dataPasien[7]+"*|*txtIdKunj*-*"+dataPasien[9]+"*|*txtTglK*-*"+dataPasien[10]+"*|*txtIdPel*-*"+dataPasien[11]+"*|*txtTitipan*-*"+dataPasien[12]+"*|*txtbayar*-*"+dataPasien[8]+"*|*txtKsoId*-*"+dataPasien[13]+"*|*txtJaminan*-*"+dataPasien[14]+"*|*txtKeringanan*-*0"+"*|*NoBiling*-*"+dataPasien[15]+"*|*txtnobukti*-*"+dataPasien[1]+"*|*txtBayarIGD*-*"+dataPasien[16]+"*|*txtKurangIGD*-*"+dataPasien[17]+"*|*txtBayarTot*-*"+dataPasien[7]+"*|*txtKurangTot*-*"+dataPasien[8]+"*|*txtigdJaminan*-*"+dataPasien[18]+"*|*txtTotJaminan*-*"+dataPasien[14]+"*|*txtBayarAmbulan*-*"+dataPasien[19]+"*|*txtKurangAmbulan*-*"+dataPasien[20]+"*|*txtAmbulanJaminan*-*"+dataPasien[21]+"*|*txtBayarJenazah*-*"+dataPasien[22]+"*|*txtKurangJenazah*-*"+dataPasien[23]+"*|*txtJenazahJaminan*-*"+dataPasien[24];
            fSetValue(window,p);
			//alert(document.getElementById('txtTglK').value);
            /*if (dataPasien[13]!="1"){
                document.getElementById('jaminanKSO').style.visibility='visible';
            }else{
                document.getElementById('jaminanKSO').style.visibility='collapse';
            }*/
            if (dataPasien[14]!="0"){
                document.getElementById('jaminanKSO').style.visibility='visible';
            }else{
                document.getElementById('jaminanKSO').style.visibility='collapse';
            }
			//alert(dataPasien[8]);
			
			fBayarIGD();

            txtbayar=parseFloat(document.getElementById('txtbayar').value);
            document.getElementById('txtalamat').innerHTML=dataPasien[3];
            document.getElementById('div_pasien').style.display='none';
            var idKasir = document.getElementById('cmbKasir').value;
            var jenisKasir = document.getElementById('cmbKasir').options[document.getElementById('cmbKasir').options.selectedIndex].lang;
            //alert("bayar_utils.php?grd=true&idKunj="+dataPasien[9]+"&idKasir="+idKasir);
            //alert("bayar_utils.php?grd1=true&idKunj="+dataPasien[9]+"&idPel="+dataPasien[11]+"&idKasir="+idKasir+"&jenisKasir="+jenisKasir);
            a1.loadURL("bayar_utils.php?grd=true&idKunj="+dataPasien[9]+"&idKasir="+idKasir,"","GET");
            b.loadURL("bayar_utils.php?grd1=true&idKunj="+dataPasien[9]+"&idPel="+dataPasien[11]+"&idKasir="+idKasir+"&jenisKasir="+jenisKasir,"","GET");
        }

		function fBayarIGD(){
		var p=document.getElementById('bayarIGD').value;
			//alert(p);
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
			
			if (parseFloat(document.getElementById('txtbayar').value)>0){
				document.getElementById('btnSimpan').disabled=false;
			}else{
				document.getElementById('btnSimpan').disabled=true;
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
            document.getElementById('txtbayar').value = parseFloat(document.getElementById('lblbiaya').value) - parseFloat(document.getElementById('txtTitipan').value) - parseFloat(document.getElementById('txtKeringanan').value) - parseFloat(document.getElementById('txtJaminan').value);
            kembali();
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
                    var idPel = document.getElementById("txtIdPel").value;
                    var nobukti = document.getElementById("txtnobukti").value;
                    var tgl = document.getElementById("txttgl").value;
                    var nilai = document.getElementById('txtbayar').value;
                    var tagihan = document.getElementById('lblbiaya').value;
					var jaminan_kso = document.getElementById('txtJaminan').value;
                    var titipan = document.getElementById('txtTitipan').value;
                    var keringanan = document.getElementById('txtKeringanan').value;
                    var dibayaroleh = document.getElementById('txtterima').value;
                    var tipe = document.getElementById('tipe').value;
                    var kasir = document.getElementById('cmbKasir').value;
                    var jenisKasir = document.getElementById('cmbKasir').options[document.getElementById('cmbKasir').options.selectedIndex].lang;
                    var ksoId = document.getElementById('txtKsoId').value;
					var cbayarIGD = 1;

                    abc=action;
					
					if (document.getElementById('cmbKasir').value=="82") cbayarIGD = document.getElementById('bayarIGD').value;
					
					var url="bayar_utils.php?grd=true&act="+action+"&idBayar="+idBayar+"&idKunj="+idKunj+"&idPel="+idPel+"&nobukti="+nobukti+"&tgl="+tgl+"&tagihan="+tagihan+"&nilai="+nilai+"&jaminan_kso="+jaminan_kso+"&titipan="+titipan+"&keringanan="+keringanan+"&dibayaroleh="+dibayaroleh+"&userId=<?php echo $userId;?>&tipe="+tipe+"&idKasir="+kasir+"&jenisKasir="+jenisKasir+"&ksoId="+ksoId+"&bayarIGD="+cbayarIGD;
                    //alert(url);
                    batal();
                    a1.loadURL(url,"","GET");
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
			document.getElementById("btnPrint").disabled = false;
        }

        function ambilData()
        {
            var sisipan=a1.getRowId(a1.getSelRow()).split("|");
            /*var p="txtIdBayar*-*"+sisipan[0]+"*|*txtIdKunj*-*"+sisipan[1]+"*|*txtnobukti*-*"+a1.cellsGetValue(a1.getSelRow(),2)+"*|*txttgl*-*"+a1.cellsGetValue(a1.getSelRow(),3)+"*|*lblbiaya*-*"+sisipan[2]+"*|*txtKeringanan*-*"+sisipan[3]+"*|*txtTitipan*-*"+sisipan[4]+"*|*txtbayar*-*"+a1.cellsGetValue(a1.getSelRow(),4)+"*|*txtterima*-*"+a1.cellsGetValue(a1.getSelRow(),5)+"*|*tipe*-*"+((sisipan[5]=='0')?'false':'true')+"*|*btnSimpan*-*Simpan*|*btnHapus*-*false*|*btnPrint*-*false*|*rincianPas*-*false";*/
            var p="txtIdBayar*-*"+sisipan[0]+"*|*txtIdKunj*-*"+sisipan[1]+"*|*txtnobukti*-*"+a1.cellsGetValue(a1.getSelRow(),2)+"*|*txttgl*-*"+a1.cellsGetValue(a1.getSelRow(),3)+"*|*lblbiaya*-*"+sisipan[2]+"*|*txtKeringanan*-*"+sisipan[3]+"*|*txtTitipan*-*"+sisipan[4]+"*|*txtbayar*-*"+a1.cellsGetValue(a1.getSelRow(),4)+"*|*txtterima*-*"+a1.cellsGetValue(a1.getSelRow(),5)+"*|*txtJaminan*-*"+sisipan[7]+"*|*tipe*-*"+((sisipan[5]=='0')?'false':'true')+"*|*btnSimpan*-*true*|*btnHapus*-*false*|*btnPrint*-*false*|*rincianPas*-*false";
            fSetValue(window,p);
            abc="PilihPembayaran";
            //document.getElementById('tipe').value=0;
            if(document.getElementById('tipe').checked==true){
                document.getElementById('tipe').value=1;
                document.getElementById('tot_tagihan').style.visibility='collapse';
                document.getElementById('krg_bayar').style.visibility='collapse';
                document.getElementById('tot_titipan').style.visibility='collapse';
                document.getElementById('tdPembayaran').innerHTML="Nilai Titipan &nbsp;&nbsp;";
            }else{
                document.getElementById('tipe').value=0;
                document.getElementById('tot_tagihan').style.visibility='visible';
                document.getElementById('krg_bayar').style.visibility='visible';
                document.getElementById('tot_titipan').style.visibility='visible';
                document.getElementById('tdPembayaran').innerHTML="Pembayaran &nbsp;&nbsp;";
            }
        }

        function cetakPembayaran(){
            var sisipan=a1.getRowId(a1.getSelRow()).split("|");
            var idKunj = document.getElementById("txtIdKunj").value;
            //var cidbayar=(document.getElementById('btnHapus').disabled==true)?document.getElementById('txtIdBayar').value:sisipan[0];
            var cidbayar='';
			document.getElementById("btnPrint").disabled = true;

            //alert(abc);
            if (abc!="") cidbayar=sisipan[0];
            window.open('cetakPembayaran.php?idbayar='+cidbayar+'&idKunj='+idKunj+'&idPel='+document.getElementById('txtIdPel').value+'&idUser=<?php echo $userId;?>&jenisKasir='+document.getElementById('cmbKasir').options[document.getElementById('cmbKasir').options.selectedIndex].lang,'_blank');
        }

        function RincianTagihan(){
            var sisipan=a1.getRowId(a1.getSelRow()).split("|");
            var idKunj = document.getElementById("txtIdKunj").value;
            //		var cidbayar=(document.getElementById('btnHapus').disabled==true)?document.getElementById('txtIdBayar').value:sisipan[0];
            var cidbayar='';

            //alert(abc);
            if (abc!="") cidbayar=sisipan[0];
            window.open('tagihanPasien.php?idbayar='+cidbayar+'&idKunj='+idKunj+'&idPel='+document.getElementById('txtIdPel').value+'&idUser=<?php echo $userId;?>&jenisKasir='+document.getElementById('cmbKasir').options[document.getElementById('cmbKasir').options.selectedIndex].lang,'_blank');
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
            if(confirm("Anda yakin menghapus Data Pembayaran "+a1.cellsGetValue(a1.getSelRow(),2)))
            {
				url="bayar_utils.php?grd=true&idKunj="+dataPasien[9]+"&idKasir="+idKasir+"&act=hapus&rowid="+rowid+'&userId=<?php echo $userId;?>';
                //alert(url);
                a1.loadURL(url,"","GET");
            }
            batal();
        }

        function batal(){
            //alert('tes');
            document.getElementById('btnSimpan').value='Tambah';
            document.getElementById('btnSimpan').disabled=false;
            document.getElementById('btnHapus').disabled=true;
            document.getElementById('txtIdBayar').value='';
            document.getElementById('txtterima').value='';
            document.getElementById('txtbayar').value='0';
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
            document.getElementById('tot_titipan').style.visibility='visible';
            document.getElementById('tdPembayaran').innerHTML="Pembayaran &nbsp;&nbsp;";
            document.getElementById("tipe").value = 0;
            document.getElementById("tipe").checked = false;
			document.getElementById("btnPrint").disabled = true;
            //document.getElementById('cmbKasir').value='';
        }

        function saringByKasir(par){
            //alert('change');
            var idKasir = par.value;//document.getElementById('cmbKasir').value;
            abc="";
            a1.loadURL("bayar_utils.php?grd=true&idKunj="+dataPasien[9]+"&idKasir="+idKasir,"","GET");
            batal();
            filterTagihan(par);
        }
		
		function SetTRIGD(par){
			if (par.value == '82'){
				document.getElementById('idTrIGD').style.visibility='visible';
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
                a1.loadURL("bayar_utils.php?grd=true&idKunj="+dataPasien[10]+"&idKasir="+idKasir+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage(),"","GET");
            }else if(grd=="gridTind"){
                b.loadURL("bayar_utils.php?grd1=true&idKunj="+dataPasien[10]+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage(),"","GET");
            }
        }

        if(document.getElementById('cmbKasir').value != 89 && document.getElementById('cmbKasir').value != 82 && document.getElementById('cmbKasir').value != 83){
            document.getElementById('btnTagihan').disabled = true;
        }
		
		function konfirmasi(key,val){
			var tangkap,proses,tombolSimpan,tombolHapus;
			//alert(val+'-'+key);
			/*var tangkap=val.split("*|*");
			var proses=tangkap[0];
			var tombolSimpan=tangkap[1];
			var tombolHapus=tangkap[2];*/
			if (val!=undefined){
				proses=val;
			}
			if(key=='Error'){
				if(proses=='tambah'){
					alert('Proses Pembayaran Gagal !');
				}
				else if(proses=='hapus'){
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
			
			if(a1.getMaxPage() > 0)
			{
				//document.getElementById("btnPrint").disabled = false;
			}else{
				//document.getElementById("btnPrint").disabled = true;
			}

		}

        var a1=new DSGridObject("gridbox");
        a1.setHeader("DATA PEMBAYARAN");
        a1.setColHeader("NO,NO BUKTI BAYAR,TANGGAL,JUMLAH,TERIMA DARI,PETUGAS INPUT,TIPE");
        a1.setIDColHeader(",nobukti,tgl,nilai,dibayaroleh,,");
        a1.setColWidth("30,65,75,60,120,200,100");
        a1.setCellAlign("center,center,center,center,center,left,center");
        a1.setCellHeight(20);
        a1.setImgPath("../icon");
        a1.setIDPaging("paging");
        a1.attachEvent("onRowClick","ambilData");
        a1.onLoaded(konfirmasi);
        a1.baseURL("bayar_utils.php?grd=true");
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
        b.baseURL("bayar_utils.php?grd1=true&idKunj="+document.getElementById('txtIdKunj').value);
        b.Init();

    </script>
    <script language="JavaScript1.2">mmLoadMenus();</script>
</html>
<?php 
mysql_close($konek);
?>