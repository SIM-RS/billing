<?php
session_start();
include("../sesi.php");
?>
<?php
/*
btnSimpanRujukUnit -> jalan ke jalan / inap ke jalan / jalan ke inap
//inap -> jalan ke inap
document.getElementById('lgnJudul').innerHTML di set 'MRS'
//non inap diset selainnya -> jalan ke jalan / inap ke jalan

btnSimpanKamar -> inap ke inap
//
*/
//session_start();
$userId = $_SESSION['userId'];
if(!isset($userId) || $userId == ''){
    header('location:../index.php');
}
//echo $_SESSION['userId'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="../theme/tab-view.css" />
        <script type="text/javascript" src="../theme/js/tab-view.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>
        <!--script src="../theme/dhtmlxcalendar.js" type="text/javascript"></script-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <!--dibawah ini diperlukan untuk menampilkan menu dropdown-->
		<script language="JavaScript" src="../theme/js/mm_menu.js"></script>
        <script language="JavaScript" src="../theme/js/dropdown.js"></script>

		<link rel="stylesheet" type="text/css" href="jquery_multiselect/jquery.multiselect.css" />
		<link rel="stylesheet" type="text/css" href="jquery_multiselect/style.css" />

        <link rel="stylesheet" type="text/css" href="jquery_multiselect/jquery-ui.css" />
        <script type="text/javascript" src="jquery_multiselect/jquery.js"></script>
        <script type="text/javascript" src="jquery_multiselect/jquery-ui.min.js"></script>
        <script type="text/javascript" src="jquery_multiselect/src/jquery.multiselect.js"></script>
		
        <!--dibawah ini diperlukan untuk menampilkan popup-->
        <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        <script type="text/javascript" src="../theme/prototype.js"></script>
        <script type="text/javascript" src="../theme/effects.js"></script>
        <script type="text/javascript" src="../theme/popup.js"></script>
        <!--diatas ini diperlukan untuk menampilkan popup-->
        
        <script>
		var anamnesa_kepala_leher,anamnesa_cor,anamnesa_pulmo,anamnesa_inspeksi,anamnesa_auskultasi,anamnesa_palpasi,anamnesa_perkusi,anamnesa_ekstremitas='';
		jQuery(function(){
			anamnesa_kepala_leher = jQuery("#cmbKepalaLeher").multiselect({
				header: false,
				uncheckAllText: true
			});
			
			anamnesa_cor = jQuery("#cmbCor").multiselect({
				header: false,
				uncheckAllText: 'Uncheck All'
			});
			
			anamnesa_pulmo = jQuery("#cmbPulmo").multiselect({
				header: false
			});
			
			anamnesa_inspeksi = jQuery("#cmbInspeksi").multiselect({
				header: false
			});
			
			anamnesa_auskultasi = jQuery("#cmbAuskultasi").multiselect({
				header: false
			});
			
			anamnesa_palpasi = jQuery("#cmbPalpasi").multiselect({
				header: false
			});
			
			anamnesa_perkusi = jQuery("#cmbPerkusi").multiselect({
				header: false
			});
			
			anamnesa_ekstremitas = jQuery("#cmbEkstremitas").multiselect({
				header: false
			});
		});
		
		var mTab = '';
		function cekLab(a){
			if(a==57){
				mTab.setTabCaption2("DIAGNOSA,TINDAKAN,RESEP,PEMAKAIAN BHP,HASIL LAB");
				//mTab.setTabPage("diagnosa.php,tindakan.php,resep.php,pemakaian_bhp.php,laborat.php");
				mTab.setTabDisplay("true,true,true,true,true,3");
				document.getElementById('tab_laborat').style.display='block';
				document.getElementById('tab_radiologi').style.display='none';
			}
			else if(a==60){
				mTab.setTabCaption2("DIAGNOSA,TINDAKAN,RESEP,PEMAKAIAN BHP,HASIL RADIOLOGI");
				//mTab.setTabPage("diagnosa.php,tindakan.php,resep.php,pemakaian_bhp.php,radiologi.php");
				mTab.setTabDisplay("true,true,true,true,true,3");
				document.getElementById('tab_radiologi').style.display='block';
				document.getElementById('tab_laborat').style.display='none';
			}
			else{
				mTab.setTabDisplay("true,true,true,true,false,0");
				//document.getElementById('tab_laborat').style.display='none';
				//document.getElementById('tab_radiologi').style.display='none';
			}
		}
		</script>
        
        <title>Pelayanan Kunjungan</title>
    </head>

    <body onload="setJam();loadUlang();cekSentPar();">
        <script type="text/JavaScript">
            var arrRange = depRange = [];
        </script>
        <iframe height="72" width="130" name="sort"
                id="sort"
                src="../theme/dsgrid_sort.php" scrolling="no"
                frameborder="0"
                style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
        </iframe>
        <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="1"
                style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe>
        <div id="popGrPet" style="display:none; width:600px;height:auto" class="popup">
<div id="divobat_edit" align="left" style="position:absolute; z-index:1; left: 100px; top: 25px; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
        <table width="590" align="center" cellpadding="3" cellspacing="0">
        <tr>
            <td colspan="2" class="font" align="center">&nbsp;</td>
        </tr>
        <tr id="trObat">
            <td class="font">Nama Obat</td>
            <td>:&nbsp;<input type="text" id="newObat" size="65" onKeyUp="suggestObat2(event,this);" autocomplete="off" /></td>
        </tr>
        <tr id="trFarmasi" style="visibility:collapse">
            <td class="font">Unit</td>
            <td>:&nbsp;<select id="IdFarmasiRujuk">
            	<?php 
				$sql="SELECT * FROM a_unit WHERE UNIT_TIPE=2 AND UNIT_ID<>$idunit AND UNIT_ISAKTIF=1";
				$rs=mysql_query($sql);
				while ($rw=mysql_fetch_array($rs)){
				?>
            	<option value="<?php echo $rw['UNIT_ID']; ?>"><?php echo $rw['UNIT_NAME']; ?></option>
                <?php 
				}
				?>
            </select></td>
        </tr>
        <tr id="trCaraBayar" style="visibility:collapse;">
            <td class="font">Cara Bayar</td>
            <td>:&nbsp;<select id="IdCaraBayar">
            	<?php 
				$sql="SELECT * FROM a_cara_bayar WHERE aktif=1";
				$rs=mysql_query($sql);
				while ($rw=mysql_fetch_array($rs)){
				?>
            	<option value="<?php echo $rw['id']; ?>"><?php echo $rw['nama']; ?></option>
                <?php 
				}
				?>
            </select></td>
        </tr>
        <tr>
            <td colspan="2" align="center" height="50" valign="bottom"><button id="sim" name="sim" value="simpan" type="button" style="cursor:pointer" class="popup_closebox" onClick="SimpanNewObat()"><img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Simpan</button>  <button type="button" id="batal" name="batal" class="popup_closebox" style="cursor:pointer"><img src="../icon/back.png" width="20" align="absmiddle" />&nbsp;&nbsp;Batal</button></td>
        </tr>
        </table>
</div>
        <input name="fdata" id="fdata" type="hidden" value=""/>
        <div id="divKunj" align="center" style="display:block;">
            <?php
            include("../koneksi/konek.php");
            include("../header1.php");
            $date_now=gmdate('d-m-Y',mktime(date('H')+7));
            $time_now=gmdate('H:i:s',mktime(date('H')+7));
            $tglGet=$_REQUEST['tgl'];
			$bl=date('m');
			$th=date('Y');
			$q1="SELECT no_minta FROM ".$dbbank_darah.".bd_permintaan_unit WHERE no_minta LIKE 'BD/MT/$th-$bl/%' ORDER BY no_minta DESC LIMIT 1";
			//echo $q1."<br>";
			$rs1=mysql_query($q1);
			if ($rows1=mysql_fetch_array($rs1)){
				$no_minta=$rows1["0"];
				$ctmp=explode("/",$no_minta);
				$dtmp=$ctmp[3]+1;
				$ctmp=$dtmp;
				for ($i=0;$i<(5-strlen($dtmp));$i++) $ctmp="0".$ctmp;
				$no_pakai="BD/MT/$th-$bl/$ctmp";
			}else{
				$no_pakai="BD/MT/$th-$bl/00001";
			}
            ?>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#008484"  class="hd2">
                <tr>
                    <td height="30">&nbsp;FORM PELAYANAN KUNJUNGAN</td>
					<?php 
					$qAkses = "SELECT ms_menu_id,mm.nama,mm.url FROM b_ms_group_petugas gp INNER JOIN b_ms_group_akses mga ON gp.ms_group_id = mga.ms_group_id INNER JOIN b_ms_menu mm ON mga.ms_menu_id=mm.id WHERE gp.ms_pegawai_id=$userId AND mga.ms_menu_id IN (37,39,42)";
					$rsAkses = mysql_query($qAkses);
					if(mysql_num_rows($rsAkses)>1){
					?>
					<td align="right">
						<select name="cmbLink" id="cmbLink" onchange="location=this.value" class="txtinputreg">
							<option>-- PILIH --</option>
							<?php while($rwMenu = mysql_fetch_array($rsAkses)){?>
							<option value="<?php echo '../'.$rwMenu['url']?>"><?php echo $rwMenu['nama']?></option>
							<?php } ?>
						</select>&nbsp;&nbsp;&nbsp;
					</td>
					<?php }?>
                </tr>
            </table>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" align="center" class="tabel">
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="45%">&nbsp;</td>
                    <td width="45%">&nbsp;</td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <fieldset>
                            <table width="75%" align="center">
                                <tr id="trTgl">
                                    <td height="30">Tanggal</td>
                                    <td align="center">:</td>
                                    <td>
                                        <input id="txtTgl" name="txtTgl" readonly size="11" class="txtcenter" type="text" value="<?php if($tglGet=='') {
                                            echo $date_now;
                                        }
                                        else {
                                            echo $tglGet;
                                        }
                                        ?>" />&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="txtcenter" onclick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange,saring);"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Jenis Layanan
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <select id="cmbJnsLay" class="txtinput" onchange="cekLab(this.value);cekInap(this.options[this.options.selectedIndex].lang);isiCombo('cmbTmpLay','<?php echo $_SESSION['userId'];?>,'+this.value,'','cmbTmpLay',evLang2);" >
                                            <?php
                                            $sql="SELECT distinct m.id,m.nama,m.inap FROM (SELECT distinct b.unit_id FROM b_ms_pegawai_unit b
                                                    where ms_pegawai_id=".$_SESSION['userId'].") as t1
                                                    inner join b_ms_unit u on t1.unit_id=u.id
                                                    inner join b_ms_unit m on u.parent_id=m.id WHERE m.kategori=2 order by nama";
                                            $rs=mysql_query($sql);
                                            while($rw=mysql_fetch_array($rs)) {
                                                ?>
                                            <option value="<?php echo $rw['id'];?>" lang="<?php echo $rw['inap'];?>" ><?php echo $rw['nama'];?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Tempat Layanan
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <select id="cmbTmpLay" class="txtinput" lang="" onchange="this.lang=this.value;evLang2();">
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                    <td align="center">
                        <table>
                            <tr>
                                <td>
                                    <input type="button" id="dtlPas" name="dtlPas" value="Detail Pelayanan Pasien" class="tblBtn" disabled="disabled" onclick="detail();" style="width:250px;height:40px;"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <button id="updtPas" name="updtPas" class="tblBtn" disabled="disabled" onclick="updatePas();" style="width:250px;height:40px;">
                                        Update Status Pasien<br />>> Sudah Dilayani
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">
                        <fieldset>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                <tr id="trDilayani">
                                    <td align="left">
                                        Status dilayani :
                                        <select id="cmbDilayani" onchange="saring();" class="txtinput">
                                            <option value="0" selected="selected">BELUM</option>
                                            <option value="1">SUDAH</option>
                                            <option value="">SEMUA</option>
                                        </select>
					<span style="padding-left:20px">
					No. RM :
					<input id="txtFilter" name="txtFilter" size="10" class="txtcenter" onkeyup="filterNoRM(event,this)"/>
					<!--input id="txtFilter" name="txtFilter" size="10" class="txtcenter" onkeyup="filter(event,this)" /-->
					<input id="btnFilter" name="btnFilter" type="button" class="tblBtn" value="Find" style="display:none" onclick="filter(event,this)" />
					</span>
				    </td>
				</tr>
                                <tr>
                                    <td align="center">
                                        <div id="gridbox" style="width:925px; height:270px; background-color:white; overflow:hidden;"></div>
                                        <div id="paging" style="width:925px;"></div>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
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
            </table>
        </div>

	<!-- rerep -->
	<div id="divResep" style="display:none; width: 900px;" class="popup">
	    <fieldset>
		<legend style="font-size: 14px; font-weight: bold;">Form Tambah Resep</legend>
		<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="tutupPopResep();" style="float:right; cursor: pointer" />
		<table width="850" border="0" cellpadding="0" cellspacing="0" align="center">
		<tr>
			<td width="2%">&nbsp;</td>
			<td width="13%">&nbsp;</td>
			<td width="80%">&nbsp;</td>
			<td width="5%">&nbsp;</td>
		</tr>
		<tr id="trNoResep" style="visibility:collapse">
			<td>&nbsp;</td>
			<td align="right">No Resep</td>
			<td>&nbsp;<input id="noResep" name="noResep" size="12" class="txtinput" disabled="disabled" /><input type="hidden" id="tglResep" name="tglResep" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="right">Apotek&nbsp;</td>
			<td>&nbsp;<select id="cmbApotek" name="cmbApotek" onchange="suggestObat(event,document.getElementById('txtNmObat'))" class="txtinput"><option></option></select></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="right" valign="middle">Nama Obat&nbsp;</td>
			<td>&nbsp;<input id="txtNmObat" name="txtNmObat" size="100" class="txtinput" onKeyUp="suggestObat(event,this);" autocomplete="off"><input id="idObat" name="idObat" type="hidden" /><input id="hargajual" name="hargajual" type="hidden" /><input id="hargabeli" name="hargabeli" type="hidden" />&nbsp;
				<div id="divobat" align="left" style="position:absolute; z-index:1; height: 230px; width:400px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC;"></div>
			</td>
		  <td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="right">Racikan&nbsp;</td>
			<td><input type="checkbox" id="chRacikan" name="chRacikan" class="txtinput" onclick="CekRacikan(this);"></td>
			<td>&nbsp;</td>
		</tr>
		<tr id="trRacikan" style="visibility:collapse">
			<td>&nbsp;</td>
			<td align="right">Racikan ke-&nbsp;</td>
			<td>&nbsp;<select id="noRacikan" name="noRacikan" class="txtinput">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            	</select>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="right">Jumlah&nbsp;</td>
			<td>&nbsp;<input id="txtJml" name="txtJml" size="3" class="txtcenter">&nbsp;
                <!--label><input type="checkbox" id="chRacikan" name="chRacikan" class="txtinput" onclick="CekRacikan(this);"> Racikan</label-->
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr id="trJmlBahan" style="visibility:collapse">
			<td>&nbsp;</td>
			<td align="right">Jumlah Bahan&nbsp;</td>
			<td>&nbsp;<input id="txtJmlBahan" name="txtJmlBahan" size="3" class="txtcenter">&nbsp;
				<select id="satuanRacikan" name="satuanRacikan" class="txtinput" style="visibility:hidden">
                <?php 
				$sql="SELECT * FROM $dbapotek.a_satuan_racikan WHERE aktif=1";
				$rs=mysql_query($sql);
				while ($rw=mysql_fetch_array($rs)){
				?>
                <option value="<?php echo $rw['nama']; ?>"><?php echo $rw['nama']; ?></option>
                <?php 
				}
				?>
            	</select>&nbsp;
                <!--label><input type="checkbox" id="chRacikan" name="chRacikan" class="txtinput" onclick="CekRacikan(this);"> Racikan</label-->
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td align="right">Ket Dosis&nbsp;</td>
			<td>&nbsp;<select id="txtDosis" name="txtDosis" class="txtinput">
                <?php 
				$sql="SELECT * FROM $dbapotek.a_dosis WHERE aktif=1";
				$rs=mysql_query($sql);
				while ($rw=mysql_fetch_array($rs)){
				?>
                <option value="<?php echo $rw['nama']; ?>"><?php echo $rw['nama']; ?></option>
                <?php 
				}
				?>
            	</select>
            </td>
			<td>&nbsp;</td>
		</tr>
		<!--tr>
			<td>&nbsp;</td>
			<td align="right">Ket Dosis&nbsp;</td>
			<td>&nbsp;<input id="txtDosis" name="txtDosis" size="30" class="txtinput"></td>
			<td>&nbsp;</td>
		</tr-->
		<tr>
			<td>&nbsp;</td>
			<td align="right">Dokter&nbsp;</td>
			<td>&nbsp;<select id="cmbDokResep" name="cmbDokResep" class="txtinput" onkeypress="setDok('btnSimpanResep',event);">
					<option value="">-Dokter-</option>
				</select>
		<label><input type="checkbox" id="chkDokterPenggantiResep" value="1" onchange="gantiDokter('cmbDokResep',this.checked);"/>Dokter Pengganti</label>
		</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td style="padding:10px;">&nbsp;<input id="idResep" name="idResep" type="hidden">
				<input id="txtStok" name="txtStok" type="hidden">
				<input type="button" id="btnSimpanResep" name="btnSimpanResep" value="Tambah" onclick="simpan(this.value,this.id,'txtNmObat');" class="tblTambah"/>
				<input type="button" id="btnHapusResep" name="btnHapusResep" value="Hapus" onclick="hapus(this.id);" disabled="disabled" class="tblHapus"/>
				<input type="button" id="btnBatalResep" name="btnBatalResep" value="Batal" onclick="batal(this.id)" class="tblBatal"/></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="2" align="center">
				<div id="gridboxResep" style="width:850px; height:150px; background-color:white;"></div>
				<br>
				<div id="pagingResep" style="width:850px;"></div>
			</td>
			<td>&nbsp;</td>
		</tr>
		</table>
	    </fieldset>
	</div>
	<!-- resep -->

  <div id="divTarikRujuk" style="display:none; width: 950px;" class="popup">
	    <fieldset>
		<legend style="font-size: 14px; font-weight: bold;">Form Ambil Pasien</legend>
		<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="batal('btnBatalTarikRujuk')" style="float:right; cursor: pointer" />
		<table>
		    <tr>
			<td valign="bottom" height="28">
			    Jenis Layanan
			</td>
			<td id="tdJns" height=30 valign="bottom">
			</td>
			<td rowspan="2">
			    <table id="div_ifinap" style="display:none">
				<tr>
				    <td align="right">Kelas :</td>
				    <td><select name="cmbKelas" id="cmbKelas_ifinap" tabindex="28" class="txtinput" onchange="isiPindahKamar();"></select></td>
				</tr>
				<tr>
				    <td width="162" align="right">Kamar :</td>
				    <td >
					<select name="cmbKamar" id="cmbKamar_ifinap" tabindex="26" class="txtinput" onchange=""></select>
					<span id="spanTarifPindah_ifinap" ></span>
				    </td>
				</tr>
				<tr id="trpindah1">
				    <td align="right">Tanggal Masuk :</td>
				    <td>
					<input type="text" class="txtcenter" readonly="readonly" name="TglMasuk" id="TglMasuk_ifinap" size="11" value="<?php echo $date_now;?>"/>
					<input type="button" class="btninput" id="btnTglMasuk_ifinap" name="btnTglMasuk" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('TglMasuk_ifinap'),depRange);" />
				    </td>
				</tr>
				<tr id="trpindah2">
				    <td align="right">Jam Masuk :</td>
				    <td>
					<input type="text" class="txtcenter" readonly="readonly" name="JamMasuk" id="JamMasuk_ifinap" size="5" maxlength="5" value=""/>
					<label><input type="checkbox" id="chkManual_ifinap" name="chkManual" onclick="setManual('ifinap')"/>set manual</label>
				    </td>
				</tr>
			    </table>
			</td>
		    </tr>
		    <tr>
			<td valign="top" height="28">
			    Tempat Layanan
			</td>
			<td valign="top" id="tdTmp"></td>
		    </tr>
		</table>
		<input type="button" class="tblBtn" onclick="getPas()" value="Rujuk Pasien ke Unit Ini" />
		<input type="hidden" id="act_tarik" />
		<span id="spanTar1" style="display:none"></span>
		<div id="gridbox_tarik" style="width:925px; height:270px; background-color:white; overflow:hidden;"></div>
		<div id="paging_tarik" style="width:925px;"></div>
	    </fieldset>
	</div>

        <!--div detil pelayanan-->
      <div id="divDetil" align="center" style="display:none;">
            <div id="divRujukUnit" style="display:none;width:700px" class="popup">
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="batal('btnBatalRujukUnit')" style="float:right; cursor: pointer" />
                <fieldset><legend id="lgnJudul"></legend>
                    <table border=0>
                        <tr>
                            <td width="162" align="right">Jenis Layanan :</td>
                            <td >
                                <select id="JnsLayanan" class="txtinput" onchange="cekRujukInap(this.options[this.options.selectedIndex].lang);if (document.getElementById('lgnJudul').innerHTML=='MRS'){isiCombo('TmpLayananInapSaja',this.value,'','TmpLayanan',isiKelas);}else{isiTmpLayananKonsul();}"></select>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">Tempat Layanan :</td>
                            <td><select name="TmpLayanan" id="TmpLayanan" tabindex="27" class="txtinput"  onchange="isiKelas();"></select></td>
                        </tr>
                        <tr id="trKelasRujuk">
                            <td align="right">Kelas :</td>
                            <td><select name="cmbKelasRujuk" id="cmbKelasRujuk" tabindex="28" class="txtinput" onchange="isiKamar();"></select></td>
                        </tr>
                        <tr id="trKamarRujuk">
                            <td align="right">Kamar :</td>
                            <td>
                                <select name="cmbKamarRujuk" id="cmbKamarRujuk" tabindex="29" class="txtinput"></select>
                                <span id="spanTarif" ></span>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">Keterangan Rujuk :</td>
                            <td><textarea id="txtKetRujuk" name="txtKetRujuk" cols="35" rows="2" class="txtinput"></textarea></td>
                        </tr>
                        <tr>
                            <td align="right">Dokter Perujuk :</td>
                            <td>
                                <select id="cmbDokRujukUnit" name="cmbDokRujukUnit" class="txtinput" onchange="">
                                    <option value="">-Dokter-</option>
                                </select>
                                <label><input type="checkbox" id="chkDokterPenggantiRujukUnit" value="1" onchange="gantiDokter('cmbDokRujukUnit',this.checked);"/>Dokter Pengganti</label>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="hidden" id="idRujukUnit" name="idRujukUnit"/>
                                <input type="button" id="btnSimpanRujukUnit" name="btnSimpanRujukUnit" value="Tambah" onclick="simpan(this.value,this.id);" class="tblTambah"/>
                                <input type="button" id="btnHapusRujukUnit" name="btnHapusRujukUnit" value="Hapus" onclick="hapus(this.id);" disabled="disabled" class="tblHapus"/>
				<input type="button" id="btnBatalRujukUnit" value="Batal" onclick="batal(this.id)" class="tblBtn" />
                                <input type="button" id="btnSpInap" name="btnSpInap" value="SURAT PERINTAH INAP" class="tblBtn" onclick="spInap()" />
                                <input id="cetak" name="cetak" type="button" value="DATA PASIEN MRS" onClick="cetak()" class="tblBtn" />
                                <input type="button" value="PRMHNN KONSUL" onClick="cetak_rm('../report_rm/Form_RSU/2.permohonankonsultasi.php')" class="tblBtn" />
                                <input type="button" id="ctkLabRadPerKonsul" name="ctkLabRadPerKonsul" value="CETAK HASIL LAB" onclick="cetakHslLabRad();" class="tblBtn"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div id="gridboxRujukUnit" style="width:650px; height:250px; padding-bottom:10px; background-color:white;"></div>
                                <div id="pagingRujukUnit" style="width:650px;"></div>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </div>
			
            <div id="divIsiDataRM" style="display:none;width:900px" class="popup">
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="batal('btnBatalIsiDataRM')" style="float:right; cursor: pointer" />
              <fieldset>
                    <legend id="lgnIsiDataRM">ISI DATA RM :&nbsp;
                        <select id="cmbIsiDataRM" name="cmbIsiDataRM" class="txtinput" onchange="evCmbDataRM();">
                        </select>
                    </legend>
                    <div id="ContentRM">
                    </div>
                   	<table border=0 align="center">
                        <tr>
                            <td align="center">
                                <input type="hidden" id="idIsiDataRM" name="idIsiDataRM"/>
                                <input type="button" id="btnSimpanIsiDataRM" name="btnSimpanIsiDataRM" value="Tambah" onclick="ActIsiDataRM(this,this.value);" class="tblTambah"/>
                                <input type="button" id="btnHapusIsiDataRM" name="btnHapusIsiDataRM" value="Hapus" onclick="ActIsiDataRM(this,this.value);" disabled="disabled" class="tblHapus"/>
				<input type="button" id="btnBatalIsiDataRM" value="Batal" onclick="ActIsiDataRM(this,this.value);" class="tblBtn" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="grdIsiDataRM" style="width:450px; height:200px; padding-bottom:10px; background-color:white;"></div>
                                <!--div id="pagingIsiDataRM" style="width:450px;"></div-->
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </div>
            
            <div id="divIsiAnamnesa" style="display:none;width:980px" class="popup">
            	<div id="hslAnamnesa" style="display:none"></div>
				<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
              <fieldset>
                    <legend id="lgnIsiDataRM">ANAMNESA</legend>
                    <div id=""></div>
                    <form id="form_isi_anamnesa" name="form_isi_anamnesa">
                   	<table border="0" cellpadding="0" cellspacing="0" align="center" width="950">
                        <tr>
                        	<td colspan="4">Pelaksana&nbsp;:&nbsp;
								<select id="cmbDokAnamnesa" name="cmbDokAnamnesa">
									<option>-</option>
								</select>
								<label>
									<input type="checkbox" id="chkDokterPenggantiAnamnesa" value="1" onchange="gantiDokter('cmbDokAnamnesa',this.checked);"/>Dokter Pengganti
								</label>
							</td>
                        </tr>
                        <tr>
                        	<td colspan="4" style="padding-top:5px; text-decoration:underline;">I. ANAMNESA</td>
                        </tr>
						<tr>
							<td>Keluhan Utama</td>
							<td>Riwayat Penyakit Sekarang</td>
							<td>Riwayat Penyakit Dahulu</td>
							<td></td>
						</tr>
						<tr>
							<td><textarea id="txtKU" name="txtKU" cols="35"></textarea></td>
							<td><textarea id="txtRPS" name="txtRPS" cols="35"></textarea></td>
							<td><textarea id="txtRPD" name="txtRPD" cols="35"></textarea></td>
							<td></td>
						</tr>
                        <tr>
							<td style="padding-top:5px;">Riwayat Penyakit Keluarga</td>
							<td style="padding-top:5px;">Anamnese Sosial</td>
							<td style="padding-top:5px;">Riwayat Alergi</td>
							<td style="padding-top:5px;"></td>
						</tr>
						<tr>
							<td><textarea id="txtRPK" name="txtRPK" cols="35"></textarea></td>
							<td><textarea id="txtAS" name="txtAS" cols="35"></textarea></td>
							<td><textarea id="txtRA" name="txtRA" cols="35"></textarea></td>
							<td></td>
						</tr>
						<td>
							<td colspan="4" style="padding-bottom:5px;"></td>
						</td>
                        <tr>
                        	<td colspan="4" style="border-top:1px solid black; padding-top:5px; text-decoration:underline;">II. PEMERIKSAAN FISIK</td>
                        </tr>
						<tr>
							<td colspan="4">
								<table width="100%">
									<tr>
										<td width="45%">
											<table width="100%">
												<tr>
													<td>Keadaan Umum</td>
													<td>:&nbsp;<input type="text" id="txtKUM" name="txtKUM" /></td>
													<td>GCS</td>
													<td>:&nbsp;<input type="text" id="txtGCS" name="txtGCS" /></td>
												</tr>
												<tr>
													<td>Kesadaran</td>
													<td>:&nbsp;
														<select id="cmbKesadaran" name="cmbKesadaran">
															<?php
																$sKesadaran="select * from anamnese_pilih where tipe='Kesadaran'";
																$qKesadaran=mysql_query($sKesadaran);
																while($rwKes=mysql_fetch_array($qKesadaran)){
															?>
																<option value="<?php echo $rwKes['nama']; ?>"><?php echo $rwKes['nama']; ?></option>
															<?php
																}
															?>
														</select>
													</td>
													<td>Status Gizi</td>
													<td>:&nbsp;
														<select id="cmbStatusGizi" name="cmbStatusGizi">
															<?php
																$sGizi="select * from anamnese_pilih where tipe='Gizi'";
																$qGizi=mysql_query($sGizi);
																while($rwGizi=mysql_fetch_array($qGizi)){
															?>
																<option value="<?php echo $rwGizi['nama']; ?>"><?php echo $rwGizi['nama']; ?></option>
															<?php
																}
															?>
														</select>
													</td>
												</tr>
												<tr>
													<td colspan="4">
														<table width="100%">
															<tr>
																<td width="35">Tensi</td>
																<td width="55" align="center"><input type="text" size="5" id="txtTensi" name="txtTensi" /></td>
																<td width="55">mmHg</td>
																<td width="100"></td>
																<td width="35">Nadi</td>
																<td width="55" align="center"><input type="text" size="5" id="txtNadi" name="txtNadi" /></td>
																<td width="55">/Mnt</td>
																<td width="100"></td>
																<td width="35">BB</td>
																<td width="55" align="center"><input type="text" size="5" id="txtBB" name="txtBB" /></td>
																<td width="55">Kg</td>
															</tr>
															<tr>
																<td width="35">RR</td>
																<td width="55" align="center"><input type="text" size="5" id="txtRR" name="txtRR" /></td>
																<td width="55">/Mnt</td>
																<td width="100"></td>
																<td width="35">Suhu</td>
																<td width="55" align="center"><input type="text" size="5" id="txtSuhu" name="txtSuhu" /></td>
																<td width="55">°C</td>
																<td width="100"></td>
																<td width="35"></td>
																<td width="55" align="center"></td>
																<td width="55"></td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
										<td width="55%">
											<table width="100%">
												<tr>
													<td>Kepala Leher</td>
													<td>:&nbsp;
														<select id="cmbKepalaLeher" name="cmbKepalaLeher" multiple="multiple">
															<?php
																$s="select * from anamnese_pilih where tipe='Kepala Leher'";
																$q=mysql_query($s);
																while($rws=mysql_fetch_array($q)){
															?>
																<option value="<?php echo $rws['nama']; ?>"><?php echo $rws['nama']; ?></option>
															<?php
																}
															?>
														</select>
													</td>
													<td>Cor</td>
													<td>:&nbsp;
														<select id="cmbCor" name="cmbCor" multiple="multiple">
															<?php
																$s="select * from anamnese_pilih where tipe='COR'";
																$q=mysql_query($s);
																while($rws=mysql_fetch_array($q)){
															?>
																<option value="<?php echo $rws['nama']; ?>"><?php echo $rws['nama']; ?></option>
															<?php
																}
															?>
														</select>
													</td>
												</tr>
												<tr>
													<td>Pulmo</td>
													<td>:&nbsp;
														<select id="cmbPulmo" name="cmbPulmo" multiple="multiple">
															<?php
																$s="select * from anamnese_pilih where tipe='PULMO'";
																$q=mysql_query($s);
																while($rws=mysql_fetch_array($q)){
															?>
																<option value="<?php echo $rws['nama']; ?>"><?php echo $rws['nama']; ?></option>
															<?php
																}
															?>
														</select>
													</td>
													<td>Inspeksi</td>
													<td>:&nbsp;
														<select id="cmbInspeksi" name="cmbInspeksi" multiple="multiple">
														<?php
															$s="select * from anamnese_pilih where tipe='Inspeksi'";
															$q=mysql_query($s);
															while($rws=mysql_fetch_array($q)){
														?>
															<option value="<?php echo $rws['nama']; ?>"><?php echo $rws['nama']; ?></option>
														<?php
															}
														?>
														</select>
													</td>
												</tr>
												<tr>
													<td>Auskultasi</td>
													<td>:&nbsp;
														<select id="cmbAuskultasi" name="cmbAuskultasi" multiple="multiple">
														<?php
															$s="select * from anamnese_pilih where tipe='Auskultasi'";
															$q=mysql_query($s);
															while($rws=mysql_fetch_array($q)){
														?>
															<option value="<?php echo $rws['nama']; ?>"><?php echo $rws['nama']; ?></option>
														<?php
															}
														?>
														</select>
													</td>
													<td>Palpasi</td>
													<td>:&nbsp;
														<select id="cmbPalpasi" name="cmbPalpasi" multiple="multiple">
														<?php
															$s="select * from anamnese_pilih where tipe='Palpasi'";
															$q=mysql_query($s);
															while($rws=mysql_fetch_array($q)){
														?>
															<option value="<?php echo $rws['nama']; ?>"><?php echo $rws['nama']; ?></option>
														<?php
															}
														?>
														</select>
													</td>
												</tr>
												<tr>
													<td>Perkusi</td>
													<td>:&nbsp;
														<select id="cmbPerkusi" name="cmbPerkusi" multiple="multiple">
														<?php
															$s="select * from anamnese_pilih where tipe='Perkusi'";
															$q=mysql_query($s);
															while($rws=mysql_fetch_array($q)){
														?>
															<option value="<?php echo $rws['nama']; ?>"><?php echo $rws['nama']; ?></option>
														<?php
															}
														?>
														</select>
													</td>
													<td>Ekstremitas</td>
													<td>:&nbsp;
														<select id="cmbEkstremitas" name="cmbEkstremitas" multiple="multiple">
														<?php
															$s="select * from anamnese_pilih where tipe='Ext'";
															$q=mysql_query($s);
															while($rws=mysql_fetch_array($q)){
														?>
															<option value="<?php echo $rws['nama']; ?>"><?php echo $rws['nama']; ?></option>
														<?php
															}
														?>
														</select>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>							
						</tr>
                        <tr>                        	
                            <td colspan="4" align="center" style="padding-bottom:10px;">
								<input type="hidden" id="id_anamnesa" name="id_anamnesa" />
								<button type="button" id="btnSimpanAnamnesa" name="btnSimpanAnamnesa" value="tambah" onClick="saveAnamnesa(this.value)" style="cursor:pointer">
									<img src="../icon/edit_add.png" height="16" width="16" style="position:absolute;" />
									<span style="margin-left:20px;">Add</span>
								</button>
								<button type="button" id="btnDeleteAnamnesa" name="btnDeleteAnamnesa" onClick="deleteAnamnesa()" style="cursor:pointer">
									<img src="../icon/del.gif" height="16" width="16" style="position:absolute;" />
									<span style="margin-left:20px;">Delete</span>
								</button>
								<button type="button" id="btnBatalAnamnesa" name="btnBatalAnamnesa" onClick="batalAnamnesa()" style="cursor:pointer">
									<img src="../icon/back.png" height="16" width="16" style="position:absolute;" />
									<span style="margin-left:20px;">Cancel</span>
								</button>
							</td>
                        </tr>
						<tr>
							<td colspan="4" align="center">
								<div id="gridboxAnamnesa" style="width:850px; height:150px; padding-bottom:20px; background-color:white;"></div>
                                <div id="pagingAnamnesa" style="width:850px;"></div>
							</td>
						</tr>
                    </table>
                    </form>
			  </fieldset>
            </div>
            
            
<!-- ============= Div Permintaan Bank Darah ============= -->  
            <div id="MintaDarah" style="display:none" class="popup">
            <div id="DapatDarah" style="display:none"></div>
            <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="batal('btnBatalIsiDataRM')" style="float:right; cursor: pointer" />
            <div id="divbag" align="left" style="position:absolute; z-index:1; left: 55px; top: 290px; height: 200px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; layer-background-color: #CCCCCC;"></div>
            <fieldset>
            	<legend>PERMINTAAN DARAH</legend>
                <form id="form_darah" name="form_darah">
                 <input id="id_pel" name="id_pel" type="hidden"  />
                <input id="idkso" name="idkso" type="hidden" value="1" />
            	<table width="100%" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                <tr>
                    <td>
                    <table width="50%" align="center" cellpadding="3" cellspacing="0">
                    <tr>
                        <td width="26%">Tanggal</td>
                        <td width="74%"><input type="text" id="tgl" class="txtinput2" name="tgl" size="10" value="<?php if($_REQUEST['act']=='edit') echo tglSQL($edit['tgl']); else echo date('d-m-Y'); ?>" />&nbsp;&nbsp;<img src="../icon/archive1.gif" width="20" align="absmiddle" style="cursor:pointer; vertical-align:middle" onclick="gfPop.fPopCalendar(document.getElementById('tgl'),depRange);" /></td>
                    </tr>
                    <tr>
                        <td width="26%">No Permintaan</td>
                        <td width="74%"><div id="temp_no_minta" style="display:none;"></div><input type="text" class="txtinput2" id="no_bukti" name="no_bukti" size="22" value="<?php if($_REQUEST['act']=='edit') echo $edit['no_bukti']; else echo $no_pakai; ?>"  /></td>
                    </tr>
                    <tr>
                        <td width="26%">Dokter</td>
                        <td width="74%">
                        <select id="id_dokter" name="id_dokter" class="txtinput2">
                        <?php
                            $d = "select id,nama from ".$dbbilling.".b_ms_pegawai p where p.pegawai_jenis=8 order by nama";
                            $dd = mysql_query($d);
                            while($dktr = mysql_fetch_array($dd)){ 
                        ?>
                            <option value="<?php echo $dktr['id']; ?>"><?php echo $dktr['nama']; ?></option>
                         <?php
                            }
                         ?>
                        </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="26%">Gol. darah</td>
                        <td width="74%">
                        <select id="golongan" name="golongan" class="txtinput2">
                        <option value="0"> - </option>
                        <?php
                            $g = "select id,golongan from ".$dbbank_darah.".bd_ms_gol_darah";
                            $gg = mysql_query($g);
                            while($gol = mysql_fetch_array($gg)){ 
                        ?>
                            <option value="<?php echo $gol['id']; ?>"><?php echo $gol['golongan']; ?></option>
                        <?php
                            }
                        ?>
                        </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="26%">Sifat Permintaan</td>
                        <td width="74%">
                        <select id="sifat" name="sifat" class="txtinput2" onchange="detailPil();">
                            <option value="1">Biasa</option>
                            <option value="2">Cito</option>
                            <option value="3">Persiapan operasi</option>
                        </select>
                        </td>
                    </tr>
                    <tr id="ket_sifat" style="display:none"> 
                        <td width="26%"></td>
                        <td width="74%">Tanggal <input type="text" id="tggl" name="tggl" class="txtinput2" onclick="gfPop.fPopCalendar(document.getElementById('tggl'),depRange);" size="10" value="" /> Jam <input type="text" name="jam" id="jam" class="txtinput2" size="3" value="" /><font style="color:#F00; font-style:italic">hh:mm</font></td>
                    </tr>	
                    </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" valign="top"></td>
                </tr>
                <tr>
                    <td>
                        <table width="60%" align="center" cellpadding="0" cellspacing="0" id="tblJual">
                        <tr>
                            <td height="20" colspan="9" align="right" style="padding-right:15px; padding-bottom:5px"><img src="../icon/edit_add.png" align="absmiddle" style="cursor:pointer" width="25" onClick="addRowToTable();" /></td>
                        </tr>
                        <tr class="headtable">
                            <td width="10%" class="tblheaderkiri">No.</td>
                            <td width="10%" class="tblheader">Kode</td>
                            <td width="10%" class="tblheader">Jenis</td>
                            <td style="display:none" width="5%" class="tblheader">Gol Darah</td>
                            <td style="display:none" width="5%" class="tblheader">Rhesus</td>
                            <td width="5%" class="tblheader">Jumlah</td>
                            <td width="15%" class="tblheader">Kemasan</td>
                            <td width="10%" class="tblheader">Biaya</td>
                            <td width="10%" class="tblheader">Proses</td>
                        </tr>      
                        <tr class="itemtableA" onMouseOver="this.className='itemtableAMOver'" onMouseOut="this.className='itemtableA'">
                            <td class="tdisikiri" align="center">1</td>
                            <td class="tdisi"><input type="hidden" id="id_pr" name="id_pr" value="<?php ?>"><input type="hidden" name="idpn" id="idpn" value="<?php echo $edit['id_penerimaan']; ?>"><input type="hidden" id="idkode" name="idkode" value="<?php echo $edit['id_darah']; ?>"><input id="kode" name="kode" type="text" size="10" value="<?php echo $edit['kode_darah']; ?>" onkeyup="suggestBag(event,this);" autocomplete="off"/></td>
                            <td class="tdisi"><input id="jenis" name="jenis" type="text" size="30" value="<?php echo $edit['jenis_darah']; ?>" readonly="readonly" /></td>
                            <td style="display:none" class="tdisi"><input type="hidden" id="idgoldar" name="idgoldar" value="<?php echo $edit['id_goldar']; ?>"><input id="gol" name="gol" type="text" size="5" value="<?php echo $edit['golongan']; ?>" readonly="readonly" /></td>
                            <td style="display:none" class="tdisi"><input type="hidden" id="idresus" name="idresus" value="<?php echo $edit['id_resus']; ?>"><input id="resus" name="resus" type="text" size="5" value="<?php echo $edit['rhesus']; ?>" readonly="readonly" /></td>
                            <td class="tdisi"><input type="text" id="jumlah" name="jumlah" style="text-align:center" autocomplete="off" size="3" onkeyup="hitungBiaya(this);" /></td>
                            <td class="tdisi"><input type="text" id="kemasan" name="kemasan" size="10" value="Kantong" readonly="readonly" /></td>
                            <td class="tdisi"><input type="hidden" id="t_biaya" name="t_biaya" /><input type="text" id="biaya" name="biaya" style="text-align:right" size="10" value="<?php if($edit['id_kso']==4 || $edit['id_kso']==6) echo $edit['biaya_askes']; else echo $edit['biaya']; ?>" readonly="readonly" /><input type="hidden" id="b_umum" name="b_umum" value="<?php echo $edit['biaya']; ?>" /><input type="hidden" id="b_askes" name="b_askes"  value="<?php echo $edit['biaya_askes']; ?>"/></td>
                            <td class="tdisi"><img src="../icon/erase.png" width="16" align="absmiddle" title="Klik Untuk Menghapus" class="proses" onClick="removeRowFromTable(this);"/></td>
                            </td>
                        </tr>
                        </table>
                        <table align="center">
                            <tr>
                                <td width="680" align="right">Total&nbsp;:&nbsp;</td>
                                <td width="80" align="right"><input type="hidden" id="total" name="total"><span id="spntotal">0</span></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding-top:10px">
                    <button type="button" id="btSimpan" name="btSimpan" value="tambah" onclick="actMintaDarah(this.value);" style="cursor:pointer"><img src="../icon/add.gif" width="20" align="absmiddle" />Simpan</button>
                    <button type="button" id="btBatal" name="btBatal" onclick="batall();" style="cursor:pointer"><img src="../icon/back.png" width="20" align="absmiddle" />&nbsp;Batal</button>
                    <button type="button" id="btHapus" name="btHapus" value="Hapus" onclick="hapuss();" disabled="disabled" style="cursor:pointer"><img src="../icon/delete2.gif" align="absmiddle" width="20" />&nbsp;Hapus</button>
                    <button type="button" id="btCetak" name="btCetak" value="Cetak" onclick="cetakPermintaanDarah();" style="cursor:pointer"><img src="../icon/printer.png" align="absmiddle" width="20" />&nbsp;Cetak</button>
                    </td>
                </tr>
            <tr>
                <td height="20"></td>
            </tr>
            <tr>
            <td align="center">
            <div id="gbMintaDarah" style="width:750px; height:150px; background-color:white; overflow:hidden;"></div>
            <div id="pagingMD" style="width:750px;"></div>
            </td>
            </tr>
                </table>
                </td>
            </tr>
            <tr>
                <td height="28" background="../images/main-bg.png" style="background-repeat:repeat-x;">&nbsp;</td>
            </tr>
            </table>
            </form>
            </fieldset>
            </div>
<!-- ============= Div Permintaan Bank Darah ============= -->                        
          <div id="divCtkVis" style="display:none; width:500px;" class="popup">
				<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
				<fieldset><legend>Cetak Visite Dokter</legend>
					<table width="460" border="0">
						<tr>
							<td width="20%">DOKTER</td>
							<td width="5%" align="center">:</td>
							<td width="75%"><select id="cmbDokVisite" name="cmbDokVisite" class="txtinput" ></select></td>
						</tr>
						<tr>
							<td colspan="3" align="center"><button id="ctkVisite" name="ctkVisite" onclick="cetakVisite()">CETAK VIISTE</button></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</table>				
				</fieldset>
			</div>

            <div id="divRujukRS" style="display:none;width:500px" class="popup">
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
              <fieldset><legend>Pasien Keluar</legend>
                    <table border=0 width="460">
                        <tr>
                            <td width="162" align="right">Cara Keluar :</td>
                            <td>
                                <select id="cmbCaraKeluar" class="txtinput" onchange="caraKeluar(this.value);"></select>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">Keadaan Keluar :</td>
                            <td>
                                <select id="cmbKeadaanKeluar" class="txtinput" onchange="">
                                    <option value="Perlu kontrol kembali">Perlu kontrol kembali</option>
				    <option value="Sembuh">Sembuh</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">Kasus :</td>
                            <td>
                                <select id="cmbKasus" class="txtinput">
                                    <option value="1">Baru</option>
                                    <option value="0">Lama</option>
                                </select>
                            </td>
                        </tr>
                        <tr id="trEmergency">
                            <td align="right">Status Emergency :</td>
                            <td>
                                <select id="cmbEmergency" class="txtinput"></select>
                            </td>
                        </tr>
                        <tr id="trKondisiPasien">
                            <td align="right">Kondisi Pasien :</td>
                            <td>
                                <select id="cmbKondisiPasien" class="txtinput"></select>
                            </td>
                        </tr>
                        <tr id="trkrs1">
                            <td align="right">Tanggal Pulang :</td>
                            <td>
                            <input type="text" class="txtcenter" readonly="readonly" name="TglMasuk" id="TglKrs" size="11" value="<?php echo $date_now;?>"/>
                            <input type="button" id="btnTglKrs" name="btnTglMasuk" value=" V " class="txtcenter" disabled="disabled" onClick="gfPop.fPopCalendar(document.getElementById('TglKrs'),depRange);" />
                            </td>
                        </tr>
                        <tr id="trkrs2">
                            <td align="right">Jam Pulang :</td>
                            <td>
                            <input type="text" class="txtcenter" readonly="readonly" name="JamMasuk" id="JamKrs" size="5" maxlength="5" value=""/>
                            <label><input type="checkbox" id="chkManualKrs" name="chkManual" <?php echo $DisableBD; ?> onclick="setManual('krs')"/>set manual</label>
                            </td>
                        </tr>
                        <tr id="trRujukRS" style="visibility:collapse">
                            <td width="162" align="right">RS Rujukan :</td>
                            <td >
                                <select name="cmbRS" id="cmbRS" tabindex="26" class="txtinput" onchange=""></select>
                            </td>
                        </tr>
                        <tr id="trRujukRSKet" style="visibility:collapse">
                            <td align="right">Keterangan Rujuk :</td>
                            <td>
                                <textarea id="txtKetRujukRS" name="txtKetRujukRS"  cols="35" rows="2" class="txtinput"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">Dokter :</td>
                            <td>
                                <select id="cmbDokRujukRS" name="cmbDokRujukRS" class="txtinput" onchange="setDok(this.value)">
                                    <option value="">-Dokter-</option>
                                </select>
                                <label><input type="checkbox" id="chkDokterPenggantiRujukRS" value="1" onchange="gantiDokter('cmbDokRujukRS',this.checked);"/>Dokter Pengganti</label>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td></td>
                            <td>
                                <input type="hidden" id="idRujukRS" name="idRujukRS"/>
                                <input type="button" id="btnSimpanRujukRS" name="btnSimpanRujukRS" value="Tambah" onclick="simpan(this.value,this.id);" class="tblTambah"/>
                                <input type="button" id="btnHapusRujukRS" name="btnHapusRujukRS" value="Hapus" onclick="hapus(this.id);" disabled="disabled" class="tblHapus"/>
                                <input type="button" id="btnBatalRujukRS" value="Batal" onclick="batal(this.id)" class="tblBtn" />
                                <input type="button" id="btnCetakKRS" name="btnCetakKRS" value="Cetak KRS" onclick="cetakKRS()" class="tblBtn" style="display:none;"/>
                                <input type="button" id="btnSpInap" name="btnSpInap" value="SP Inap" class="tblBtn" onclick="window.open('krs.php','_blank')" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div id="gridboxRujukRS" style="width:450px; height:150px; padding-bottom:10px; background-color:white;"></div>
                                <div id="pagingRujukRS" style="width:450px;"></div>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </div>
            <div id="divSetKamar" style="display:none;width:500px" class="popup">
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
              <fieldset><legend>Pindah Kamar</legend>
                    <table border=0>
                        <tr>
                            <td align="right">Jenis Layanan</td>
                            <td>
                                <select id="cmbJL" class="txtinput" onchange="isiCmbTL()"></select>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">Tempat Layanan</td>
                            <td>
                                <select id="cmbTL" class="txtinput" onchange="isiKelasKamar(this.value);"></select>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">Kelas :</td>
                            <td><select name="cmbKelas" id="cmbKelas" tabindex="28" class="txtinput" onchange="isiPindahKamar();"></select></td>
                        </tr>
                        <tr>
                            <td width="162" align="right">Kamar :</td>
                            <td >
                                <select name="cmbKamar" id="cmbKamar" tabindex="26" class="txtinput" onchange=""></select>
                                <span id="spanTarifPindah" ></span>
                            </td>

                        </tr>
                        <tr>
                            <td align="right">Tanggal Masuk :</td>
                            <td>
                                <input type="text" class="txtcenter" readonly="readonly" name="TglMasuk" id="TglMasuk" size="11" value="<?php echo $date_now;?>"/>
                                <input type="button" class="btninput" id="btnTglMasuk" name="btnTglMasuk" disabled="disabled" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('TglMasuk'),depRange);" />
                            </td>
                        </tr>
                        <tr>
                            <td align="right">Jam Masuk :</td>
                            <td>
                                <input type="hidden" id="jamServer" name="jamServer" value="<?php echo $time_now;?>"/>

                                <input type="text" class="txtcenter" readonly="readonly" name="JamMasuk" id="JamMasuk" size="5" maxlength="5" value=""/>
                                <label><input type="checkbox" id="chkManual" name="chkManual" <?php echo $DisableBD; ?> onclick="setManual()"/>set manual</label>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="hidden" id="idSetKamar" name="idSetKamar"/>
                                <input type="button" id="btnSimpanKamar" name="btnSimpanKamar" value="Tambah" onclick="simpan(this.value,this.id);" class="tblTambah"/>
                                <input type="button" id="btnHapusKamar" name="btnHapusKamar" value="Hapus" onclick="hapus(this.id);" disabled="disabled" class="tblHapus"/>
				<input type="button" id="btnBatalKamar" value="Batal" onclick="batal(this.id)" class="tblBtn" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div id="gridboxKamar" style="width:450px; height:250px; padding-bottom:10px; background-color:white;"></div>
                                <div id="pagingkamar" style="width:450px;"></div>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </div>
            <div id="divSetLab" style="display:none;width:450px;" class="popup">
            <div id="divDlm"></div>
				<img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
                <fieldset>
                    <legend>Nomor Spesimen</legend>
					<span id="spLab" style="display:none"></span>
                    <table border="0" cellpadding="0" cellspacing="0" align="center">
                        <tr>
                            <td width="50%" align="center" height="30">Nomor Spesimen&nbsp;:</td>
                            <td width="50%">&nbsp;&nbsp;&nbsp;<input id="txtLab" name="txtLab" size="8" onkeypress="smp(event)"></td>
                        </tr>
                    </table>
                </fieldset>
            </div>
            <div id="divSetMutasi" style="display:none;width:500px" class="popup">
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
              <fieldset><legend>Pindah Tempat Layanan (MUTASI)</legend>
                    <table border=0>
                        <tr>
                            <td width="162" align="right">Jenis Layanan :</td>
                            <td >
                                <select id="JnsLayananMutasi" class="txtinput" onchange="isiCombo('TmpLayanan',this.value,'','TmpLayananMutasi')">
                                    <?php
                                    $sql="SELECT distinct m.id,m.nama,m.inap FROM (SELECT distinct b.unit_id FROM b_ms_pegawai_unit b
					where ms_pegawai_id=".$_SESSION['userId'].") as t1
					inner join b_ms_unit u on t1.unit_id=u.id
					inner join b_ms_unit m on u.parent_id=m.id order by nama";
                                    $rs=mysql_query($sql);
                                    while($rw=mysql_fetch_array($rs)) {
                                        ?>
                                    <option value="<?php echo $rw['id'];?>" lang="<?php echo $rw['inap'];?>" ><?php echo $rw['nama'];?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">Tempat Layanan :</td>
                            <td>
                                <select name="TmpLayananMutasi" id="TmpLayananMutasi" tabindex="27" class="txtinput"  onchange=""></select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="button" id="btnSimpanMutasi" name="btnSimpanMutasi" value="Simpan Mutasi" onclick="simpanMutasi();" class="popup_closebox"/>
				<input type="button" id="btnBatalMutasi" value="Batal" onclick="batal(this.id)" class="tblBtn" />
                                <input type="button" value="Cetak Kwitansi" onclick="cetakKwitansi()" />
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </div>
            <div align="center">
          <table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#008484"  class="hd2">
                    <tr>
                        <td height="30">&nbsp;DETAIL PASIEN &nbsp; Tempat Pelayanan : <input type="text" id="txtPelUnit" value="" readonly="readonly" class="txtinput"/> <span id="spanKam"></span></td>
                        <td>
                            <img alt="close" src="../icon/close.png" onClick="document.getElementById('divDetil').style.display='none';document.getElementById('divKunj').style.display='block';document.getElementById('txtFilter').value='';loadUlang();document.getElementById('chkTind').checked=false;showUnit(false);TabViewSwitch(document.getElementById('TabView_0'),'TabView');" border="0" style="cursor:pointer; float:right" />
                        </td>
                    </tr>
                </table>
                <table width="1000" border="0" cellpadding="0" cellspacing="0" class="tabel" align="center">
                    <tr>
                        <td width="5%">&nbsp;</td>
                        <td width="90%">&nbsp;</td>
                        <td width="5%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <fieldset>
                                <table width="100%" align="center" border="0" cellpadding="1" cellspacing="1" class="tabel">
                                    <tr>
                                        <td width="8%">&nbsp;No RM</td>
                                        <td width="15%">:
					<input id="txtNo" name="txtNo" size="12" value="" onkeyup="filter(event,this)" class="txtinput" />&nbsp;
					</td>
                                        <td width="5%">&nbsp;Nama</td>
                                        <td >: <input id="txtNama" name="txtNama" size="28" value=""  class="txtinput" readonly="readonly" />&nbsp;</td>
                                        <td >&nbsp;Tanggal Lahir&nbsp;: <input id="txtTglLhr" name="txtTglLhr" size="12" value="" class="txtinput"  readonly="readonly"/>&nbsp;&nbsp;&nbsp;Umur&nbsp;:&nbsp;<input id="txtUmur" name="txtUmur" size="4" value="" class="txtinput" />&nbsp;&nbsp;&nbsp;L/P&nbsp;:&nbsp;<input id="txtSex" name="txtSex" size="2" value="" readonly="readonly" class="txtinput" /></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;Nama Ortu</td>
                                        <td>: <input id="txtOrtu" name="txtOrtu" size="15" value=""  readonly="readonly" class="txtinput" />&nbsp;</td>
                                        <td>&nbsp;Alamat</td>
                                        <td colspan="2">: <textarea id="txtAlmt" name="txtAlmt" cols="80" rows="1" readonly="readonly" class="txtinput" ></textarea>&nbsp;</td>
                                    </tr>
				    <tr>
					<td colspan="5" align="center" style="color:#203C42; font-weight:bold; font-size: 14px" id="tdStat"></td>
				    </tr>
                                </table>
                            </fieldset>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td style="padding:10px;">			    
					<input type="button" id="btnRujukUnit" name="btnRujukUnit" value="KONSUL" onclick="rujukUnit(this.value)" class="tblBtn"/>
					<input type="button" id="btnRujukRS" name="btnRujukRS" value="KRS" onclick="rujukRS()" class="tblBtn"/>
				    
					<input type="button" id="btnRekamMds" name="btnRekamMds" value="REKAM MEDIS" onclick="rekamMedis()" class="tblBtn"/>
					<input type="button" id="btnSetKamar" name="btnSetKamar" value="PINDAH KAMAR" onclick="setKamar()" style="display:none;" class="tblBtn"/>
				   
					<input type="button" id="btnMutasi" name="btnMutasi" value="MUTASI" onclick="setMutasi();" class="tblBtn"/>
					<input type="button" id="btnMRS" name="btnMRS" value="MRS" onclick="rujukUnit(this.value)" class="tblBtn"/>
				   
					<input type="button" id="btnResume" name="btnResume" value="RESUME MEDIS" onclick="resumeMedis()" class="tblBtn"/>
					<input type="button" id="btnVer" name="btnVer" value="VERIFIKASI INAP" class="tblBtn" onclick="window.open('verifikasiInap.php?idKunj='+getIdKunj+'&idUnit='+getIdUnit,'_blank')" style="display:none" />
				   
					<input type="button" id="btnCtkRincian" name="btnCtkRincian" value="CETAK RINCIAN TINDAKAN" style="cursor:pointer" onMouseOver="MM_showMenu(window.mm_menu_0814123211_0,0,20,null,'btnCtkRincian');" onMouseOut="MM_startTimeout();" class="tblBtn"/>
					<input type="button" id="btnLab" name="btnLab" value="NOMOR SPESIMEN" onclick="cetakLab();" class="tblBtn"/>
				    
					<input name="UpdStatusPx" id="UpdStatusPx" type="button" value="UBAH STATUS Px" class="tblBtn" onclick="PopUpdtStatus();" />
					<input name="ctkVis" id="ctkVis" type="button" value="CETAK VISITE" class="tblBtn" onclick="ctkVis();" />
					<input type="button" id="btnPasienPulang" name="btnPasienPulang" value="PASIEN PULANG" onclick="simpan(this.value,this.id);" class="tblBtn"/>
                            
			    <input type="button" id="btnBatalPulang" name="btnBatalPulang" value="PASIEN BATAL PULANG" onclick="hapus(this.id);" class="tblBtn"/>
                <input type="button" id="btnIsiDataRM" name="btnIsiDataRM" value="ISI DATA RM" onclick="isiDataRM();" class="tblBtn"/>
			    <input type="button" id="btnDarah" name="btnDarah" value="PERMINTAAN DARAH" class="tblBtn" onclick="isiMintaDarah()" style="display:none" />
                <input type="button" id="ctkLab" name="ctkLab" value="CETAK HASIL LAB" onclick="cetakHasilLabAll();" class="tblBtn"/>
                <input type="button" id="ctkLab" name="ctkLab" value="CETAK HASIL RADIOLOGI" onclick="cetakHasilRadAll();" class="tblBtn"/>
				<input type="button" id="btnCtkFrm" name="btnCtkFrm" value="REPORT RM" style="cursor:pointer" onMouseOver="MM_showMenu(window.mm_menu_0814123211_4,0,20,null,'btnCtkFrm');" onMouseOut="MM_startTimeout();" class="tblBtn"/>
                <input type="button" id="btnIsiDataRM" name="btnIsiDataRM" value="ANAMNESA" onclick="isiAnamnesa();" class="tblBtn"/>
				<?php
			    $sVer="SELECT p.id ,g.nama AS grup FROM b_ms_group_petugas gp
				    INNER JOIN b_ms_group g ON g.id=gp.ms_group_id
				    INNER JOIN b_ms_pegawai p ON p.id=gp.ms_pegawai_id
				    WHERE (g.nama LIKE '%VERIFIKATOR%' OR g.nama LIKE '%CIO%' OR g.ket LIKE '%VERIFIKATOR%')
				    AND p.id='$userId'";
			    $rsVer=mysql_query($sVer);
			    $hidden="none";
			    if(mysql_num_rows($rsVer)>0){
				$rwVer=mysql_fetch_array($rsVer);				
				$vid=$rwVer['id'];
				$hidden="block";
			    }
			    ?>
			    <button type="button" id="btnVerifikasi" name="btnVerifikasi" style="display:<?php echo $hidden;?>" onclick="verifikasi(<?php echo $vid?>);" class="tblBtn">
			    VERIFIKASI (belum)
			    </button>			   
			</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td align="center"><div class="TabView" id="TabView" style="width:900px; height:400px"></div></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
                <!--table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
                    <tr>
                        <td height="30">&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" class="btninput" /></td>
                        <td>&nbsp;</td>
                        <td align="right"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" class="btninput" onClick="showDetil()" />&nbsp;</td>
                    </tr>
                </table-->
            </div>
        </div>
        <div id="divUpdtStatus" style="display:none;width:450px; height:250px" align="center" class="popup">
        	<span id="inpEvUpdt" style="display:none"></span>
            <span id="spnTglInap" style="display:none"></span>
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
									$sql="SELECT id,nama FROM b_ms_kso WHERE aktif=1 ORDER BY nama";
									$rs=mysql_query($sql);
									while ($rw=mysql_fetch_array($rs)){
									?>
                                    	<option value="<?php echo $rw['id']; ?>"><?php echo $rw['nama']; ?></option>
                                    <?php 
									}
									?>
                                    </select>                                </td>
                            </tr>
                        	<tr style="visibility:visible">
                            	<td class="txtinputNoBgColor">Jenis Kunjungan</td>
                              	<td class="txtinputNoBgColor" width="10" align="center">&nbsp;:</td>
                                <td>
                                	<select id="jenisKunj" name="jenisKunj" class="txtinput" onchange="if (this.value=='1') document.getElementById('TglSJP').value=getTgl_Inap; else document.getElementById('TglSJP').value=getTgl_sjp;">
                                        <option value="1">Rawat Inap ( RI )</option>
                                    	<option value="2">Semua ( IGD, RJ, RI )</option>
                                    </select>
                            	</td>
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
                        	  <td><input type="text" class="txtinput" name="NoSJP" id="NoSJP" size="20" /></td>
                        	</tr>
                        	<tr id="trNoJaminan">
                              <td class="txtinputNoBgColor">No Anggota</td>
                        	  <td class="txtinputNoBgColor" align="center">&nbsp;:</td>
                        	  <td><input type="text" class="txtinput" name="NoJaminan" id="NoJaminan" size="20" /></td>
                      	  </tr>
                        	<tr id="trHakKelas">
                              <td class="txtinputNoBgColor">Hak Kelas</td>
                        	  <td class="txtinputNoBgColor" align="center">&nbsp;:</td>
                        	  <td><select id="cmbHakKelas" name="cmbHakKelas" class="txtinput">
                                <?php 
									$sql="SELECT * FROM b_ms_kelas WHERE id IN (2,3,4,5,6,7,8,9) AND aktif=1";
									$rs=mysql_query($sql);
									while ($rw=mysql_fetch_array($rs)){
									?>
                                <option value="<?php echo $rw['id']; ?>"><?php echo $rw['nama']; ?></option>
                                <?php 
									}
									?>
                              </select></td>
                      	  </tr>
                        	<tr id="trnmPeserta">
                        	  <td class="txtinputNoBgColor">Nama Peserta</td>
                        	  <td class="txtinputNoBgColor" align="center">&nbsp;:</td>
                        	  <td><input type="text" class="txtinput" name="nmPeserta" id="nmPeserta" size="30" /></td>
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
                        </table>
                  </td>
                </tr>
                <tr>
                    <td align="center"><br /><input name="BtnUpdtStatusPx" id="BtnUpdtStatusPx" type="button" value="Update Status" class="tblBtn" onclick="goUpdtStatusPx()" /></td>
                </tr>
            </table>
        </div> 
        <div id="divPilihKamar" style="display:none;width:350px; height:120px" align="center" class="popup">
          <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                <tr>
                    <td><img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right;cursor: pointer" /></td>
                </tr>
                <tr>
                    <td align="center">
                    	<table border="0" cellpadding="0" cellspacing="0">
                        	<tr>
                              <td class="txtinputNoBgColor">Kamar&nbsp;</td>
                        	  <td class="txtinputNoBgColor" align="center">&nbsp;:</td>
                        	  <td><select name="kamarPx" id="kamarPx" class="txtinputreg">
                                </select></td>
                       	  </tr>
                        </table>
                  </td>
                </tr>
                <tr>
                    <td align="center"><br /><input name="BtnPilihKamarPx" id="BtnPilihKamarPx" type="button" value="Pilih Kamar" class="tblBtn" onclick="PilihKamarPx()" /></td>
                </tr>
            </table>
        </div> 
	</body>
    <!--script kunjungan-->
    <script type="text/JavaScript" language="JavaScript">
        var unitId=0;
        var inap,txtTgl,cmbTmpLay,cmbDilayani;
        var jenisUnitId=0;
        var getIdPasien,getIdPel,getIdKunj,getIdUnit,getIdKelas,getUmur,getKsoId,getKsoKelasId,getIdKelasKunj,getDilayani,getKelas_id,getKamarNama,getKamarId,getTgl_sjp,getTgl_Inap,getNoSJP,getNoJaminan,getNoPasien;
        var getVerifikasi,getVerifikator;
	function cekInap(label){
            //alert(label);
            if(label=='1'){
                document.getElementById('trTgl').style.visibility='collapse';
                document.getElementById('trDilayani').style.visibility='visible';
                document.getElementById('btnSetKamar').style.display='inline';
                document.getElementById('btnMRS').disabled=true;
                document.getElementById('btnVer').style.display='inline';
				document.getElementById('btnDarah').style.display='inline';
                document.getElementById('btnRujukRS').disabled=false;
            }
            else{
                document.getElementById('trTgl').style.visibility='visible';
                document.getElementById('trDilayani').style.visibility='visible';
                document.getElementById('btnSetKamar').style.display='none';
                document.getElementById('btnMRS').disabled=false;
                document.getElementById('btnVer').style.display='none';
				document.getElementById('btnDarah').style.display='none';
                document.getElementById('btnRujukRS').disabled=false;
            }
        }
        
		function fChangeStatusPx(p){
			if (p=="1"){
				document.getElementById('trnosjp').style.visibility='collapse';
				document.getElementById('trNoJaminan').style.visibility='collapse';
				document.getElementById('trHakKelas').style.visibility='collapse';
				document.getElementById('trStatusPenj').style.visibility='collapse';
				document.getElementById('trnmPeserta').style.visibility='collapse';
				document.getElementById('spnTglSJP').innerHTML='Tgl Mulai Berubah';
			}else{
				document.getElementById('trnosjp').style.visibility='visible';
				document.getElementById('trNoJaminan').style.visibility='visible';
				document.getElementById('trHakKelas').style.visibility='visible';
				document.getElementById('trStatusPenj').style.visibility='visible';
				document.getElementById('trnmPeserta').style.visibility='visible';
				document.getElementById('spnTglSJP').innerHTML='Tgl SJP/SKP';
			}
			
			if (p=="38" || p=="39" || p=="46" || p=="53"){
				document.getElementById('cmbHakKelas').value=4;
			}
			
			/*if (p=="38" || p=="1"){
				document.getElementById('jenisKunj').innerHTML='<option value="1">Rawat Inap (RI)</option><option value="2">Semua (IGD,RJ,RI)</option>';
				document.getElementById('TglSJP').value=getTgl_Inap;
			}else{
				document.getElementById('jenisKunj').innerHTML='<option value="1">Rawat Inap (RI)</option>';
				document.getElementById('TglSJP').value=getTgl_Inap;
			}*/
			
			/*if (p=="1"){
				document.getElementById('jenisKunj').value=2;
				document.getElementById('TglSJP').value=getTgl_sjp;
			}else{*/
				document.getElementById('jenisKunj').value=1;
				document.getElementById('TglSJP').value=getTgl_Inap;
			//}
		}
        
		function goUpdtStatusPx(){
		var cstatusPx=document.getElementById('statusPx').value;
		var cTglSJP=document.getElementById('TglSJP').value;
		var cNoSJP=document.getElementById('NoSJP').value;
		var cNoJaminan=document.getElementById('NoJaminan').value;
		var ccmbHakKelas=document.getElementById('cmbHakKelas').value;
		var cStatusPenj=document.getElementById('StatusPenj').value;
		var cnmPeserta=document.getElementById('nmPeserta').value;
		var cJenisKunj=document.getElementById('jenisKunj').value;
			/*i++;
			if (i==6) i=1;
			fSetValue(window,"statusPx*-*"+i);
			fChangeStatusPx(document.getElementById('statusPx').value);*/
			var url="updtStatusPx_utils.php?idKunj="+getIdKunj+"&cstatusPx="+cstatusPx+"&cTglSJP="+cTglSJP+"&cNoSJP="+cNoSJP+"&cNoJaminan="+cNoJaminan+"&ccmbHakKelas="+ccmbHakKelas+"&cStatusPenj="+cStatusPenj+"&IdPasien="+getIdPasien+"&cnmPeserta="+cnmPeserta+"&cJenisKunj="+cJenisKunj;
			//alert(url);
			document.getElementById('inpEvUpdt').innerHTML="";
			Request(url , "inpEvUpdt", "", "GET",evUpdtStatusPx,"");
		}
		
		function evUpdtStatusPx(){
			if (document.getElementById('inpEvUpdt').innerHTML=="" || document.getElementById('inpEvUpdt').innerHTML!="Proses Update Berhasil !"){
				alert("Update Status Pasien Gagal !");
			}else{
				alert(document.getElementById('inpEvUpdt').innerHTML);
			}
		}
		
		function PopUpdtStatus()
        {
			fSetValue(window,"statusPx*-*"+getKsoId+"*|*TglSJP*-*"+getTgl_sjp+"*|*NoSJP*-*"+getNoSJP+"*|*NoJaminan*-*"+getNoJaminan+"*|*cmbHakKelas*-*"+getKsoKelasId+"*|*StatusPenj*-*"+getStatusPenj+"*|*nmPeserta*-*"+getnmPeserta);
			/*if (getKsoId==39){
				fSetValue(window,"cmbHakKelas*-*4");
			}*/
			fChangeStatusPx(document.getElementById('statusPx').value);
            new Popup('divUpdtStatus',null,{modal:true,position:'center',duration:1});
            document.getElementById('divUpdtStatus').popup.show();
        }

        function cekSentPar(){
            if('<?php echo $_POST['sentPar']?>' != '' && '<?php echo isset($_POST['sentPar'])?>' == 1){
                document.getElementById('aharef').href = "http://<?php echo $_SERVER['HTTP_HOST'].$base_addr;?>/billing/informasi/riwayat_kunj.php";
                var sentPar = '<?php echo $_POST['sentPar'];?>'.split('*|*');
                document.getElementById('cmbJnsLay').value = sentPar[1];
                document.getElementById('txtTgl').value =  sentPar[3];
                document.getElementById('txtFilter').value = sentPar[0];
                isiCombo('cmbTmpLay','<?php echo $_SESSION['userId'];?>,'+sentPar[1],sentPar[2],'',evLang2);
                //document.getElementById('cmbTmpLay').value = sentPar[2];
            }
        }

        var a1;
        function isiCombo(id,val,defaultId,targetId,evloaded){

            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            if(document.getElementById(targetId)==undefined){
                alert('Elemen target dengan id: \''+targetId+'\' tidak ditemukan!');
            }else{
                Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
            }
        }
        isiCombo('cmbTmpLay','<?php echo $_SESSION['userId'];?>,'+document.getElementById('cmbJnsLay').value,'','',evLang);
		
        function evLang(){
            //document.getElementById('cmbTmpLay').lang=document.getElementById('cmbTmpLay').value;
            //alert(document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang);
            inap=document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang;
            //alert(inap);
			/*========= tambahan tarik aktif jika Kamar Jenazah & Ambulan ===========*/
			if (document.getElementById('cmbTmpLay').value==122 || document.getElementById('cmbTmpLay').value==123 || document.getElementById('cmbJnsLay').value==57){
				document.getElementById('btnFilter').style.display = 'inline-table';
			}else{
				document.getElementById('btnFilter').style.display = 'none';
			}
			/*========= tambahan tarik aktif jika Kamar Jenazah & Ambulan ===========*/
            txtTgl=document.getElementById('txtTgl').value;
            cmbTmpLay=document.getElementById('cmbTmpLay').value;
            cmbDilayani=document.getElementById('cmbDilayani').value;
            cekInap(inap);
		if(inap == 1){
			document.getElementById('cmbDilayani').innerHTML = "<option value='0' selected='selected'>BELUM</option><option value='1'>SUDAH</option><option value=''>SEMUA</option><option value='-1'>SUDAH KELUAR</option>";
		}else{
			document.getElementById('cmbDilayani').innerHTML = "<option value='0' selected='selected'>BELUM</option><option value='1'>SUDAH</option><option value=''>SEMUA</option>";
		}

            //document.getElementById('cmbTmpLay').lang=document.getElementById('cmbTmpLay').value;
            //alert(document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang);
            unitId=document.getElementById('cmbTmpLay').value;
            jenisUnitId=document.getElementById('cmbJnsLay').value;
			
            //unitId=document.getElementById('cmbTmpLay').value;
            jenisUnitId=document.getElementById('cmbJnsLay').value;
            showGrid();
            isiCombo('cmbDok',unitId,'<?php echo $userId; ?>','cmbDokRujukUnit');
			//isiCombo('cmbDok',unitId,'<?php echo $userId; ?>','cmbDokRujukUnit',cekLogPelaksana);
            isiCombo('cmbRS');
            isiCombo('cmbDok',unitId,'<?php echo $userId; ?>','cmbDokRujukRS');
			//isiCombo('cmbDok',unitId,'<?php echo $userId; ?>','cmbDokRujukRS',cekLogPelaksana);
            if(document.getElementById('cmbJnsLay').options[document.getElementById('cmbJnsLay').options.selectedIndex].lang=='1'){
                isiCombo('cmbCaraKeluar','','','cmbCaraKeluar',gantiCaraKeluar);
            }
            else{
                isiCombo('cmbCaraKeluar','APS','','cmbCaraKeluar',gantiCaraKeluar);
            }
			isiCombo('cmbIsiDataRM',document.getElementById('cmbTmpLay').value,'','cmbIsiDataRM',evCmbDataRM);
			cekLab(document.getElementById('cmbJnsLay').value);
        }
		
		function gantiCaraKeluar(){
			caraKeluar(document.getElementById('cmbCaraKeluar').value);	
		}
		
		function ActIsiDataRM(objRM,par){
			switch (objRM.id){
				case "btnSimpanIsiDataRM":	//action utk simpan data RM
					//alert('simpan isi data RM');
					
					//alert(document.getElementById('cmbIsiDataRM').value);napTerapi,stt_nikah,usia_pakai,akibat
					switch (document.getElementById('cmbIsiDataRM').value){
						case "1":	//---NAPZA---
							var trapi=document.getElementById('trapi').value;
							var sttKwn=document.getElementById('sttKwn').value;
							var napzaDigunakan=document.getElementById('napzaDigunakan').value;
							var usia=document.getElementById('usia').value;
							var akibat=document.getElementById('akibat').value;
							var id=document.getElementById('idMaster').value;
							grdRM.loadURL("../rm/napza_utils.php?grd=grdIsiDataRM&act="+par+"&idPel="+getIdPel+"&napTerapi="+trapi+"&stt_nikah="+sttKwn+"&usia_pakai="+usia+"&akibat="+akibat+"&napza="+napzaDigunakan+"&kunjId="+getIdKunj+"&id="+id,"","GET");
							break;
						case "2":	//---GIZI BURUK---
							var bb = document.getElementById('bb').value;
							var tb = document.getElementById('tb').value;
							var statusGizi = document.getElementById('statusGizi').value;
							var tindakan = document.getElementById('tindakan').value;
							var hasilTindakan = document.getElementById('hasilTindakan').value;
							var id = document.getElementById('txtId').value;
							grdRM.loadURL("../rm/gizi_buruk_utils.php?grd=grdIsiDataRM&act="+par+"&id="+id+"&kunjId="+getIdKunj+"&idPel="+getIdPel+"&bb="+bb+"&tb="+tb+"&status_gizi_id="+statusGizi+"&tindakan="+tindakan+"&hasil_tindakan_id="+hasilTindakan,"","GET");
							break;
							//pelaku,tgl,jam,tmpt,kekerasan,tipe
						case "3":	
							var pelaku=document.getElementById('pelaku').value;
							var tgl=document.getElementById('tgl').value;
							var jam=document.getElementById('jam').value;
							var tmpt=document.getElementById('tmpt').value;
							var kekerasan=document.getElementById('kekerasan').value;
							var id=document.getElementById('idKekerasan').value;
							var tipe=document.getElementById('tipe').value;
							grdRM.loadURL("../rm/kekerasan_pa_util.php?grd=grdIsiDataRM&act="+par+"&idPel="+getIdPel+"&pelaku="+pelaku+"&tgl="+tgl+"&jam="+jam+"&tmpt="+tmpt+"&kekerasan="+kekerasan+"&kunjId="+getIdKunj+"&id="+id+"&tipe="+tipe,"","GET");
							btlKekerasan();
							break;
						case "4":	//---CAMPAK---
							var dosis = document.getElementById('dosis').value;
							var vaks = document.getElementById('vaks').value;
							var tglDemam = document.getElementById('tglDemam').value;
							var tglRash = document.getElementById('tglRash').value;
							var vita = document.getElementById('vita').value;
							var keadaan = document.getElementById('keadaan').value;
							var id = document.getElementById('txtId').value;
							grdRM.loadURL("../rm/campak_utils.php?grd=grdIsiDataRM&act="+par+"&id="+id+"&kunjId="+getIdKunj+"&idPel="+getIdPel+"&dosis="+dosis+"&vaks="+vaks+"&tglDemam="+tglDemam+"&tglRash="+tglRash+"&vita="+vita+"&keadaan="+keadaan,"","GET");
							break;
						case "5":	//---Pneumonia---
							var resiko = document.getElementById('resiko').value;
							var id = document.getElementById('idResiko').value;
							grdRM.loadURL("../rm/pneumonia_util.php?grd=grdIsiDataRM&act="+par+"&id="+id+"&kunjId="+getIdKunj+"&idPel="+getIdPel+"&resiko="+resiko+"&id="+id,"","GET");
							btlPneumonia();
							break;
						case "6":	//---KB---
							var jenisKB=document.getElementById('cmbKontrasepsi').value;
							var baru=document.getElementById('cmbPeserta').value;
							var binaan=document.getElementById('cmbBinaan').value;
							var kbgagal=(document.getElementById('chkKBGagal').checked==true)?"1":"0";
							var efek=document.getElementById('cmbEfekSamping').value;
							var komplikasi=document.getElementById('cmbKomplikasi').value;
							var gantiKB=0;
							var KBdari=0;
							var KBke=0;
							if (document.getElementById('chkGantiKB').checked){
								gantiKB=1;
								KBdari=document.getElementById('cmbKontrasepsiLama').value;
								KBke=document.getElementById('cmbKontrasepsiBaru').value;
							}
							var infertil=document.getElementById('cmbInfertil').value;
							var id=document.getElementById('txtIdKB').value;
							//alert("../rm/kb_utils.php?grd=grdIsiDataRM&act="+par+"&idPel="+getIdPel+"&jenisKB="+jenisKB+"&baru="+baru+"&binaan="+binaan+"&kbgagal="+kbgagal+"&efek="+efek+"&komplikasi="+komplikasi+"&gantiKB="+gantiKB+"&KBdari="+KBdari+"&KBke="+KBke+"&infertil="+infertil+"&kunjId="+getIdKunj+"&id="+id);
							grdRM.loadURL("../rm/kb_utils.php?grd=grdIsiDataRM&act="+par+"&idPel="+getIdPel+"&jenisKB="+jenisKB+"&baru="+baru+"&binaan="+binaan+"&kbgagal="+kbgagal+"&efek="+efek+"&komplikasi="+komplikasi+"&gantiKB="+gantiKB+"&KBdari="+KBdari+"&KBke="+KBke+"&infertil="+infertil+"&kunjId="+getIdKunj+"&id="+id,"","GET");
							break;
						case "7":	//---MATERNAL PERINATAL---
							var idMaternal = document.getElementById('jeniskasus').value;
							//alert('maternal='+idMaternal);
							grdRM.loadURL("../rm/maternal_perinatal_utils.php?grd=grdIsiDataRM&act="+par+"&id="+id+"&kunjId="+getIdKunj+"&idPel="+getIdPel+"&idMaternal="+idMaternal,"","GET");
							break;
						case "8":	//---KIA---
							var idKia = document.getElementById('kia_jenis').value;
							var idKiaDetail = document.getElementById('kia_detail').value;
							//alert('maternal='+idMaternal);
							grdRM.loadURL("../rm/kia_utils.php?grd=grdIsiDataRM&act="+par+"&id="+id+"&kunjId="+getIdKunj+"&idPel="+getIdPel+"&idKia="+idKia+"&idKiaDetail="+idKiaDetail,"","GET");
							break;
						case "9":	//---ASUHAN GIZI ANAK---
							var txtId_asuhan_gizi_anak = document.getElementById('txtId_asuhan_gizi_anak').value;
							var txtbb = document.getElementById('txtbb').value;
							var txttb = document.getElementById('txttb').value;
							var txtbbtb = document.getElementById('txtbbtb').value;
							var txtAsupanMakan = document.getElementById('txtAsupanMakan').value;
							var txtKesan = document.getElementById('txtKesan').value;
							var txtAsuhanGiziLanjut = document.getElementById('txtAsuhanGiziLanjut').value;
							var txtDiagPeny = document.getElementById('txtDiagPeny').value;
							var txtDiitDokter = document.getElementById('txtDiitDokter').value;
							grdRM.loadURL("../rm/asuhan_gizi_anak_utils.php?grd=grdIsiDataRM&act="+par+"&id="+txtId_asuhan_gizi_anak+"&kunjId="+getIdKunj+"&idPel="+getIdPel+"&txtbb="+txtbb+"&txttb="+txttb+"&txtbbtb="+txtbbtb+"&txtAsupanMakan="+txtAsupanMakan+"&txtKesan="+txtKesan+"&txtAsuhanGiziLanjut="+txtAsuhanGiziLanjut+"&txtDiagPeny="+txtDiagPeny+"&txtDiitDokter="+txtDiitDokter,"","GET");
							batalAGA();
							break;
					}
					break;
				case "btnHapusIsiDataRM":
					switch (document.getElementById('cmbIsiDataRM').value){
					case '1':
						var id = document.getElementById('idMaster').value;
						grdRM.loadURL("../rm/napza_utils.php?grd=grdIsiDataRM&act=hapus&id="+id+"&idPel="+getIdPel,"","GET");
						btlnz();
						//grdRM.loadURL("../rm/napza_utils.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						break;
					case '2':
						var id = document.getElementById('txtId').value;
						grdRM.loadURL("../rm/gizi_buruk_utils.php?grd=grdIsiDataRM&act=hapus&id="+id+"&idPel="+getIdPel,"","GET");
						batalGB();
						//grdRM.loadURL("../rm/gizi_buruk_utils.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						//return false;
						break;
					case '3':
						var id = document.getElementById('idKekerasan').value;
						grdRM.loadURL("../rm/kekerasan_pa_util.php?grd=grdIsiDataRM&act=hapus&id="+id+"&idPel="+getIdPel,"","GET");
						btlKekerasan();
						//grdRM.loadURL("../rm/kekerasan_pa_util.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						break;
					case '4':
						var id = document.getElementById('txtId').value;
						grdRM.loadURL("../rm/campak_utils.php?grd=grdIsiDataRM&act=hapus&id="+id+"&idPel="+getIdPel,"","GET");
						batalCampak();
						//grdRM.loadURL("../rm/campak_utils.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						break;
					case '5':
						var id = document.getElementById('idResiko').value;
						grdRM.loadURL("../rm/pneumonia_util.php?grd=grdIsiDataRM&act=hapus&id="+id+"&idPel="+getIdPel,"","GET");
						btlPneumonia();
						//grdRM.loadURL("../rm/pneumonia_util.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						break;
					case '6':
						var id = document.getElementById('txtIdKB').value;
						grdRM.loadURL("../rm/pneumonia_util.php?grd=grdIsiDataRM&act=hapus&id="+id+"&idPel="+getIdPel,"","GET");
						break;
					case '7':
						var id = document.getElementById('txtId').value;
						grdRM.loadURL("../rm/maternal_perinatal_utils.php?grd=grdIsiDataRM&act=hapus&id="+id+"&idPel="+getIdPel,"","GET");
						batalMP();
						//grdRM.loadURL("../rm/maternal_perinatal_utils.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						//return false;
						break;
					case '8':
						var id = document.getElementById('txtId').value;
						grdRM.loadURL("../rm/kia_utils.php?grd=grdIsiDataRM&act=hapus&id="+id+"&idPel="+getIdPel,"","GET");
						batalKIA();
						//grdRM.loadURL("../rm/kia_utils.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						//return false;
						break;
					case '9':
						var id = document.getElementById('txtId_asuhan_gizi_anak').value;
						grdRM.loadURL("../rm/asuhan_gizi_anak_utils.php?grd=grdIsiDataRM&act=hapus&id="+id+"&idPel="+getIdPel,"","GET");
						batalAGA();
						//grdRM.loadURL("../rm/kia_utils.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						//return false;
						break;
						}
					break;
					
				case "btnBatalIsiDataRM":
					switch (document.getElementById('cmbIsiDataRM').value){
					case '1':
						btlnz();
					break;
					case '2':
						batalGB();
					break;
					case '3':
						btlKekerasan();
					break;
					case '4':
						batalCampak();
					break;
					case '5':
						btlPneumonia();
					break;
					case '7':
						batalMP();
					break;
					case '8':
						batalKIA();
					break;
					case '9':
						batalAGA();
					break;
					}
					break;
			}
		}
		
		function evCmbDataRM(){
			switch (document.getElementById('cmbIsiDataRM').value){
				case "1" :	// NAPZA
					document.getElementById('divIsiDataRM').style.width='1000px';
					document.getElementById('divIsiDataRM').style.height='500px';
					Request('../rm/napza.php?idPel='+getIdPel,'ContentRM','','GET');
					if (getIdPel!=undefined){
						document.getElementById('grdIsiDataRM').style.width='860px';
						grdRM.setColHeader("NO,TERAPI,STATUS NIKAH,NAPZA YG DIGUNAKAN,USIA PERTAMA PAKAI NAPZA,PENYEBAB NAPZA");
						grdRM.setIDColHeader(",terapi,status_nikah,napza,usia_pakai,akibat");
						grdRM.setColWidth("30,120,80,200,200,200");
						grdRM.setCellAlign("center,center,center,left,center,center");
						grdRM.attachEvent("onRowClick","tarikDataRM");
						grdRM.onLoaded(tarikDataRMLoad);
						//alert("../rm/napza_utils.php?grd=grdIsiDataRM&idPel="+getIdPel);
						grdRM.loadURL("../rm/napza_utils.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						//alert("../rm/napza_utils.php?grd=grdIsiDataRM&idPel="+getIdPel)
					}
					break;
				case "2" :	// GIZI BURUK
					document.getElementById('divIsiDataRM').style.width='1000px';
					document.getElementById('divIsiDataRM').style.height='500px';
					Request('../rm/gizi_buruk.php?idPel='+getIdPel,'ContentRM','','GET');
					if (getIdPel!=undefined){
						document.getElementById('grdIsiDataRM').style.width='800px';
						grdRM.setColHeader("NO,BB,TB,STATUS GIZI,TINDAKAN,HASIL");
						//grdRM.setIDColHeader(",terapi,status,napza,usia,penyebab,cara_pakai");
						grdRM.setColWidth("30,80,80,300,400,180");
						grdRM.setCellAlign("center,center,center,left,center,center");
						grdRM.attachEvent("onRowClick","ambilDataGiziBuruk");
						//grdRM.onLoaded(tarikDataRM);
						grdRM.loadURL("../rm/gizi_buruk_utils.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
					}
					break;
					//KEKERASAN 
					case "3":
					document.getElementById('divIsiDataRM').style.width='1000px';
					document.getElementById('divIsiDataRM').style.height='510px';
					Request('../rm/kekerasan_pa.php?idPel='+getIdPel,'ContentRM','','GET');
					if (getIdPel!=undefined){
						document.getElementById('grdIsiDataRM').style.width='880px';
						grdRM.setColHeader("NO,PELAKU,TANGGAL,TEMPAT KEJADIAN,KEKERASAN YG DIALAMI,KORBAN");
						grdRM.setIDColHeader(",pelaku,tgl,tempat,kekerasan,tipe_kekerasan");
						grdRM.setColWidth("30,120,100,200,300,100");
						grdRM.setCellAlign("center,center,center,left,left,center");
						grdRM.attachEvent("onRowClick","ambilId");
						grdRM.onLoaded(tarikDataRMLoad);
						//alert("../rm/napza_utils.php?grd=grdIsiDataRM&idPel="+getIdPel);
						grdRM.loadURL("../rm/kekerasan_pa_util.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						//alert("../rm/napza_utils.php?grd=grdIsiDataRM&idPel="+getIdPel)
					}
					break;
				case "4" :	// Campak
					document.getElementById('divIsiDataRM').style.width='1000px';
					document.getElementById('divIsiDataRM').style.height='500px';
					Request('../rm/campak.php?idPel='+getIdPel,'ContentRM','','GET');
					if (getIdPel!=undefined){
						document.getElementById('grdIsiDataRM').style.width='800px';
						grdRM.setColHeader("NO,DOSIS,VAKSINASI TERAKHIR,Tanggal Demam,Tanggal Rash,Vitamin A,Keadaan Sekarang");
						//grdRM.setIDColHeader(",terapi,status,napza,usia,penyebab,cara_pakai");
						grdRM.setColWidth("30,80,80,100,100,100,100");
						grdRM.setCellAlign("center,center,center,center,center,center,center");
						grdRM.attachEvent("onRowClick","ambilDataCampak");
						//grdRM.onLoaded(tarikDataRM);
						grdRM.loadURL("../rm/campak_utils.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
					}
					break;
					case "5" :	// Pneumonia
					document.getElementById('divIsiDataRM').style.width='1000px';
					document.getElementById('divIsiDataRM').style.height='400px';
					Request('../rm/pneumonia.php?idPel='+getIdPel,'ContentRM','','GET');
					if (getIdPel!=undefined){
						document.getElementById('grdIsiDataRM').style.width='560px';
						grdRM.setColHeader("NO,Faktor Resiko");
						grdRM.setIDColHeader(",faktor_resiko");
						grdRM.setColWidth("30,500");
						grdRM.setCellAlign("center,left");
						grdRM.attachEvent("onRowClick","ambilId1");
						grdRM.onLoaded(tarikDataRMLoad);
						//alert("../rm/napza_utils.php?grd=grdIsiDataRM&idPel="+getIdPel);
						grdRM.loadURL("../rm/pneumonia_util.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						//alert("../rm/napza_utils.php?grd=grdIsiDataRM&idPel="+getIdPel)
					}
					break;
					case "6" :	// KB
					document.getElementById('divIsiDataRM').style.width='1000px';
					document.getElementById('divIsiDataRM').style.height='520px';
					Request('../rm/kb.php?idPel='+getIdPel,'ContentRM','','GET');
					if (getIdPel!=undefined){
						document.getElementById('grdIsiDataRM').style.width='560px';
						grdRM.setColHeader("NO,Jenis Kontrasepsi,Peserta,Binaan,KB Gagal,Efek Samping,Komplikasi,Ganti KB,Infertil");
						grdRM.setIDColHeader(",jenis,peserta,binaan,kb_gagal,efek_samping,komplikasi,ganti_kb,infertil");
						grdRM.setColWidth("30,150,100,80,80,150,150,160,120");
						grdRM.setCellAlign("center,center,center,center,left,left,center,center,center");
						//grdRM.attachEvent("onRowClick","ambilIdKB");
						//grdRM.onLoaded(tarikDataRMLoad);
						//alert("../rm/kb_util.php?grd=grdIsiDataRM&idPel="+getIdPel);
						grdRM.loadURL("../rm/kb_util.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						//alert("../rm/napza_utils.php?grd=grdIsiDataRM&idPel="+getIdPel)
					}
					break;
					case "7" :	// MATERNAL PERINATAL
					document.getElementById('divIsiDataRM').style.width='1000px';
					document.getElementById('divIsiDataRM').style.height='400px';
					Request('../rm/maternal_perinatal.php?idPel='+getIdPel,'ContentRM','','GET');
					//isiCombo2('jnskasus','1','','jeniskasus');
					if (getIdPel!=undefined){
						document.getElementById('grdIsiDataRM').style.width='600px';
						grdRM.setColHeader("NO,Jenis Kesakitan, Jenis Kasus");
						//grdRM.setIDColHeader(",terapi,status,napza,usia,penyebab,cara_pakai");
						grdRM.setColWidth("50,200,200");
						grdRM.setCellAlign("center,left,left");
						grdRM.attachEvent("onRowClick","ambilDataMP");
						//grdRM.onLoaded(tarikDataRM);
						grdRM.loadURL("../rm/maternal_perinatal_utils.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
					}
					break;
					case "8" :	// KIA
					document.getElementById('divIsiDataRM').style.width='1000px';
					document.getElementById('divIsiDataRM').style.height='400px';
					Request('../rm/kia.php?idPel='+getIdPel,'ContentRM','','GET');
					if (getIdPel!=undefined){
						document.getElementById('grdIsiDataRM').style.width='600px';
						grdRM.setColHeader("NO,Jenis Pelayanan,Detail");
						//grdRM.setIDColHeader(",terapi,status,napza,usia,penyebab,cara_pakai");
						grdRM.setColWidth("50,200,200");
						grdRM.setCellAlign("center,left,left");
						grdRM.attachEvent("onRowClick","ambilDataKIA");
						//grdRM.onLoaded(tarikDataRM);
						grdRM.loadURL("../rm/kia_utils.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
					}
					break;
					case "9" :	// ASUHAN GIZI ANAK
					document.getElementById('divIsiDataRM').style.width='1000px';
					document.getElementById('divIsiDataRM').style.height='700px';
					Request('../rm/asuhan_gizi_anak.php?idPel='+getIdPel,'ContentRM','','GET');
					if (getIdPel!=undefined){
						document.getElementById('grdIsiDataRM').style.width='860px';
						grdRM.setColHeader("NO,BB,TB,BB/TB,ASUPAN MAKANAN,KESAN,ASUHAN GIZI LANJUT,DIAGNOSA PENYAKIT,DIIT DOKTER");
						grdRM.setIDColHeader(",,,,,,,,");
						grdRM.setColWidth("30,120,80,200,200,200,200,200,200");
						grdRM.setCellAlign("center,center,center,left,center,center,center,center,center");
						grdRM.attachEvent("onRowClick","ambilDataAGA");
						grdRM.onLoaded(tarikDataRMLoad);
						//alert("../rm/napza_utils.php?grd=grdIsiDataRM&idPel="+getIdPel);
						grdRM.loadURL("../rm/asuhan_gizi_anak_utils.php?grd=grdIsiDataRM&idPel="+getIdPel,"","GET");
						//alert("../rm/napza_utils.php?grd=grdIsiDataRM&idPel="+getIdPel)
					}
					break;
			}
		}
		
		function GantiKBClick(){
			if (document.getElementById('chkGantiKB').checked){
				document.getElementById('trKbLama').style.visibility='visible';
				document.getElementById('trKbBaru').style.visibility='visible';
			}else{
				document.getElementById('trKbLama').style.visibility='collapse';
				document.getElementById('trKbBaru').style.visibility='collapse';
			}
		}
		
		function tarikDataRM(){
			sisipan=grdRM.getRowId(grdRM.getSelRow()).split("|");
			document.getElementById('idMaster').value=sisipan[0]
			document.getElementById('trapi').value=sisipan[3];
			document.getElementById('sttKwn').value=sisipan[5];
			document.getElementById('napzaDigunakan').value=sisipan[1];
			document.getElementById('usia').value=sisipan[4];
			document.getElementById('akibat').value=sisipan[2];
			document.getElementById('btnSimpanIsiDataRM').value='Update';
			document.getElementById('btnHapusIsiDataRM').disabled=false;
		}
		
		function ambilId(){
		var sampingan = grdRM.getRowId(grdRM.getSelRow()).split("|");
		document.getElementById('idKekerasan').value = sampingan[0];
		document.getElementById('pelaku').value = sampingan[1];
		var tanggal=grdRM.cellsGetValue(grdRM.getSelRow(),3);
		var pecah=tanggal.split(" ")
		var t=pecah[0].split("-");
		var tglOk=t[2]+"-"+t[1]+"-"+t[0];
		var t2=pecah[1].split(":");
		var jmOk=t2[0]+":"+t2[1];
		document.getElementById('tgl').value=tglOk;
		document.getElementById('jam').value=jmOk;
		document.getElementById('tmpt').value=grdRM.cellsGetValue(grdRM.getSelRow(),4);
		document.getElementById('kekerasan').value=grdRM.cellsGetValue(grdRM.getSelRow(),5);
		document.getElementById('tipe').value=grdRM.cellsGetValue(grdRM.getSelRow(),6);
		document.getElementById('btnSimpanIsiDataRM').value='Update';
		document.getElementById('btnHapusIsiDataRM').disabled=false;
		}
		
		function ambilId1(){
		var sampingan1 = grdRM.getRowId(grdRM.getSelRow()).split("|");
		document.getElementById('idResiko').value = sampingan1[0];
		document.getElementById('resiko').value = sampingan1[1];
		document.getElementById('btnSimpanIsiDataRM').value='Update';
		document.getElementById('btnHapusIsiDataRM').disabled=false;
		}
		
		function ambilDataGiziBuruk(){
			var ids = grdRM.getRowId(grdRM.getSelRow()).split("|");
			document.getElementById('txtId').value = ids[0];
			//alert(ids[0]);
			var beratbadan = grdRM.cellsGetValue(grdRM.getSelRow(),2);
			var tinggibadan = grdRM.cellsGetValue(grdRM.getSelRow(),3);
			var statusgizi = grdRM.cellsGetValue(grdRM.getSelRow(),4);
			var tindakan = grdRM.cellsGetValue(grdRM.getSelRow(),5);
			var hasil = grdRM.cellsGetValue(grdRM.getSelRow(),6);
			document.getElementById('bb').value = beratbadan;
			document.getElementById('tb').value = tinggibadan;
			document.getElementById('statusGizi').value = statusgizi;
			document.getElementById('tindakan').value = tindakan;
			document.getElementById('hasilTindakan').value = hasil;
			document.getElementById('btnSimpanIsiDataRM').value = 'simpan';
			document.getElementById('btnHapusIsiDataRM').disabled = false;
		}
		
		function ambilDataCampak(){
			var ids = grdRM.getRowId(grdRM.getSelRow()).split("|");
			document.getElementById('txtId').value = ids[0];
			//alert(ids[0]);
			var dosis = grdRM.cellsGetValue(grdRM.getSelRow(),2);
			var vaks = grdRM.cellsGetValue(grdRM.getSelRow(),3);
			var tglDemam = grdRM.cellsGetValue(grdRM.getSelRow(),4);
			var tglRash = grdRM.cellsGetValue(grdRM.getSelRow(),5);
			var vita = grdRM.cellsGetValue(grdRM.getSelRow(),6);
			var keadaan = grdRM.cellsGetValue(grdRM.getSelRow(),7);
			document.getElementById('dosis').value = dosis;
			document.getElementById('vaks').value = vaks;
			document.getElementById('tglDemam').value = tglDemam;
			document.getElementById('tglRash').value = tglRash;
			document.getElementById('vita').value = vita;
			document.getElementById('keadaan').value = keadaan;
			document.getElementById('btnSimpanIsiDataRM').value = 'simpan';
			document.getElementById('btnHapusIsiDataRM').disabled = false;
		}
		
		function ambilDataKIA(){
			var ids = grdRM.getRowId(grdRM.getSelRow()).split("|");
			document.getElementById('txtId').value = ids[0];
			var idKiaJenis = ids[1];
			var idKiaDetail = ids[2];
			//alert(ids[0]+' '+ids[1]+' '+ids[2]);
			document.getElementById('kia_jenis').value = idKiaJenis;
			isiCombo2('detailKIA',idKiaJenis,'','kia_detail');
			document.getElementById('kia_detail').value = idKiaDetail;
			document.getElementById('btnSimpanIsiDataRM').value = 'simpan';
			document.getElementById('btnHapusIsiDataRM').disabled = false;
			
			if(idKiaJenis==3 || idKiaJenis==5){
				document.getElementById('kiadetail').style.display = 'table-row';
			}
			else{
				document.getElementById('kiadetail').style.display = 'none';
			}
		}
		
		function ambilDataAGA(){
			var ids = grdRM.getRowId(grdRM.getSelRow()).split("|");
			document.getElementById('btnSimpanIsiDataRM').value = 'simpan';
			document.getElementById('btnHapusIsiDataRM').disabled = false;
			
			document.getElementById('txtId_asuhan_gizi_anak').value=ids[0];
			document.getElementById('txtbb').value=grdRM.cellsGetValue(grdRM.getSelRow(),2);
			document.getElementById('txttb').value=grdRM.cellsGetValue(grdRM.getSelRow(),3);
			document.getElementById('txtbbtb').value=grdRM.cellsGetValue(grdRM.getSelRow(),4);
			document.getElementById('txtAsupanMakan').value=grdRM.cellsGetValue(grdRM.getSelRow(),5);
			document.getElementById('txtKesan').value=grdRM.cellsGetValue(grdRM.getSelRow(),6);
			document.getElementById('txtAsuhanGiziLanjut').value=grdRM.cellsGetValue(grdRM.getSelRow(),7);
			document.getElementById('txtDiagPeny').value=grdRM.cellsGetValue(grdRM.getSelRow(),8);
			document.getElementById('txtDiitDokter').value=grdRM.cellsGetValue(grdRM.getSelRow(),9);
		}
		
		function batalGB(){
			document.getElementById('bb').value = '';
			document.getElementById('tb').value = '';
			document.getElementById('statusGizi').value = '';
			document.getElementById('tindakan').value = '';
			document.getElementById('hasilTindakan').value = '';
			document.getElementById('btnSimpanIsiDataRM').value = 'tambah';
			document.getElementById('btnHapusIsiDataRM').disabled = true;
		}
		
		function batalMP(){
			document.getElementById('btnSimpanIsiDataRM').value = 'tambah';
			document.getElementById('btnHapusIsiDataRM').disabled = true;
		}
		
		function batalKIA(){
			document.getElementById('btnSimpanIsiDataRM').value = 'tambah';
			document.getElementById('btnHapusIsiDataRM').disabled = true;
		}
		
		function batalAGA(){
			document.getElementById('btnSimpanIsiDataRM').value = 'tambah';
			document.getElementById('btnHapusIsiDataRM').disabled = true;
			document.getElementById('txtId_asuhan_gizi_anak').value='';
			document.getElementById('txtbb').value='';
			document.getElementById('txttb').value='';
			document.getElementById('txtbbtb').value='';
			document.getElementById('txtAsupanMakan').value='';
			document.getElementById('txtKesan').value='';
			document.getElementById('txtAsuhanGiziLanjut').value='';
			document.getElementById('txtDiagPeny').value='';
			document.getElementById('txtDiitDokter').value='';
		}
		
		function batalCampak(){
			document.getElementById('dosis').value = '';
			document.getElementById('vaks').value = '';
			document.getElementById('tglDemam').value = '<?php echo $date_now; ?>';
			document.getElementById('tglRash').value = '<?php echo $date_now; ?>';
			document.getElementById('vita').value = '';
			document.getElementById('keadaan').value = '';
			document.getElementById('btnSimpanIsiDataRM').value = 'tambah';
			document.getElementById('btnHapusIsiDataRM').disabled = true;
		}
		
        function btlnz(){
			document.getElementById('')
			document.getElementById('btnHapusIsiDataRM').disabled=true;
			document.getElementById('btnSimpanIsiDataRM').value='Tambah';
		}
		
		function btlKekerasan(){
			document.getElementById('tgl').value='';
			document.getElementById('jam').value='';
			document.getElementById('tmpt').value='';
			document.getElementById('kekerasan').value='';
			document.getElementById('btnHapusIsiDataRM').disabled=true;
			document.getElementById('btnSimpanIsiDataRM').value='Tambah';
		}
		
		function btlPneumonia(){
			document.getElementById('btnHapusIsiDataRM').disabled=true;
			document.getElementById('btnSimpanIsiDataRM').value='Tambah';
		}
		
		function tarikDataRMLoad(key,val){
		var tangkap,proses,tombolSimpan,tombolHapus;
		//alert(val);
			if (val!=undefined && val!='' && val!='*|*'){
				tangkap=val.split("*|*");
				if(tangkap[0]=='tambah'){
					alert("Data berhasil disimpan...");
				}else{
					alert("Data berhasil diubah...");
				}
			}
		}   
		     
		function evLang2(){
			var selCmbDilayani=0;
			if (document.getElementById('cmbDilayani')) selCmbDilayani=document.getElementById('cmbDilayani').options.selectedIndex;
			if (selCmbDilayani>2) selCmbDilayani=0;
	    	//tentangTarik();
			/*========= tambahan tarik aktif jika Kamar Jenazah & Ambulan ===========*/
			if (document.getElementById('cmbTmpLay').value==122 || document.getElementById('cmbTmpLay').value==123 || document.getElementById('cmbJnsLay').value==57){
				document.getElementById('btnFilter').style.display = 'inline-table';
			}else{
				document.getElementById('btnFilter').style.display = 'none';
			}
			/*========= tambahan tarik aktif jika Kamar Jenazah & Ambulan ===========*/
            inap=document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang;
			//alert(inap);
			if(inap == 1){
				document.getElementById('btnMRS').style.display = 'none';
				document.getElementById('UpdStatusPx').style.display = 'inline-table';
				document.getElementById('cmbDilayani').innerHTML = "<option value='0' selected='selected'>BELUM</option><option value='1'>SUDAH</option><option value=''>SEMUA</option><option value='-1'>SUDAH KELUAR</option>";
			}
			else{
				document.getElementById('btnMRS').style.display = 'inline-table';
				if (document.getElementById('cmbJnsLay').value==44){
					document.getElementById('UpdStatusPx').style.display = 'inline-table';
				}else{
					document.getElementById('UpdStatusPx').style.display = 'none';
				}
				document.getElementById('cmbDilayani').innerHTML = "<option value='0' selected='selected'>BELUM</option><option value='1'>SUDAH</option><option value=''>SEMUA</option>";
			}
			//alert(selCmbDilayani);
			document.getElementById('cmbDilayani').options.selectedIndex=selCmbDilayani;
			if('<?php echo isset($_POST['sentPar'])?>' == 0){
				document.getElementById('txtFilter').value = "";
			}
			else if('<?php echo isset($_POST['sentPar'])?>' == 1){
				var sentPar = "<?php echo $_POST['sentPar']?>".split('*|*');
				document.getElementById('cmbDilayani').value = sentPar[4];
			}
            txtTgl=document.getElementById('txtTgl').value;
            cmbTmpLay=document.getElementById('cmbTmpLay').value;
            cmbDilayani=document.getElementById('cmbDilayani').value;
            //document.getElementById('cmbTmpLay').lang=document.getElementById('cmbTmpLay').value;
            //alert(document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang);
            unitId=document.getElementById('cmbTmpLay').value;
            jenisUnitId=document.getElementById('cmbJnsLay').value;
            cekInap(inap);
            saring();
            isiCombo('cmbDok',unitId,'<?php echo $userId; ?>','cmbDokRujukUnit',cekLogPelaksana);
            isiCombo('cmbRS');
            isiCombo('cmbDok',unitId,'<?php echo $userId; ?>','cmbDokRujukRS',cekLogPelaksana);
            if(document.getElementById('cmbJnsLay').options[document.getElementById('cmbJnsLay').options.selectedIndex].lang=='1'){
                isiCombo('cmbCaraKeluar','','','cmbCaraKeluar',gantiCaraKeluar);
            }
            else{
                isiCombo('cmbCaraKeluar','APS','','cmbCaraKeluar',gantiCaraKeluar);
            }
            isiCombo('cmbDok',unitId,'<?php echo $userId; ?>','cmbDokTind',cekLogPelaksana);
            isiCombo('cmbDok',unitId,'<?php echo $userId; ?>','cmbDokDiag',cekLogPelaksana);
            isiCombo('cmbDok',unitId,'<?php echo $userId; ?>','cmbDokResep',cekLogPelaksana);
			
			/*
			if(jenisUnitId==27){
			}
			*/
        }
	
	/*function tentangTarik(){
	    document.getElementById('txtFilter').value = "";
	    //isiCombo();
	}*/
	
        function showGrid(){
            a1 = new DSGridObject("gridbox");
            a1.setHeader("DATA KUNJUNGAN PASIEN");
            a1.setColHeader("NO,TGL,NO RM,NAMA,L/P,PENJAMIN,ASAL KUNJUNGAN,ALAMAT,T.LHR,NAMA ORTU,KETERANGAN");
            a1.setIDColHeader(",,no_rm,nama,,namakso,,,,nama_ortu,alamat");
            a1.setColWidth("30,80,80,200,30,150,140,250,70,100,70");
            a1.setCellAlign("center,center,center,left,center,center,center,center,center,left,left");
            a1.setCellHeight(20);
            a1.setImgPath("../icon");
            a1.setIDPaging("paging");
            a1.attachEvent("onRowClick","ambilDataPasien");
            a1.attachEvent("onRowDblClick","detail");
            a1.onLoaded(ambilDataPasien);
	    //var no_rm = document.getElementById('txtFilter').value;
            //alert("pelayanankunjungan_utils.php?grd=true&saring=true&no_rm="+no_rm+"&saringan="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbTmpLay').value+"&dilayani="+document.getElementById('cmbDilayani').value);
            //alert("pelayanankunjungan_utils.php?grd=true&saring=true&no_rm="+document.getElementById('txtFilter').value+"&saringan="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbTmpLay').value+"&dilayani="+document.getElementById('cmbDilayani').value);
			a1.baseURL("pelayanankunjungan_utils.php?grd=true&saring=true&no_rm="+document.getElementById('txtFilter').value+"&saringan="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbTmpLay').value+"&dilayani="+document.getElementById('cmbDilayani').value);
            a1.Init();
	    
	    	tariky = new DSGridObject("gridbox_tarik");
            tariky.setHeader("DATA KUNJUNGAN PASIEN");
            tariky.setColHeader("NO,TGL,NO RM,NAMA,L/P,PENJAMIN,ASAL KUNJUNGAN,UNIT SEKARANG");
            tariky.setIDColHeader(",,no_rm,nama,,,,");
            tariky.setColWidth("30,80,80,200,30,150,140,140");
            tariky.setCellAlign("center,center,center,left,center,center,center,center");
            tariky.setCellHeight(20);
            tariky.setImgPath("../icon");
            tariky.setIDPaging("paging_tarik");
            tariky.attachEvent("onRowClick","tarikDataPasien");
            tariky.attachEvent("onRowDblClick","getPas");
            tariky.onLoaded(tarikDataPasien);
            tariky.baseURL("pelayanankunjungan_utils.php?grd=tarik&no_rm="+document.getElementById('txtFilter').value+"&saringan="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbTmpLay').value+"&dilayani="+document.getElementById('cmbDilayani').value);
            tariky.Init();
			
	    	grdRM = new DSGridObject("grdIsiDataRM");
            grdRM.setHeader("DATA REKAM MEDIS");
            grdRM.setColHeader("NO,TERAPI,STATUS NIKAH,NAPZA YG DIGUNAKAN,USIA PERTAMA PAKAI NAPZA,PENYEBAB NAPZA,CARA PAKAI");
            //grdRM.setIDColHeader(",terapi,status,napza,usia,penyebab,cara_pakai");
            grdRM.setColWidth("30,80,80,200,30,150,140");
            grdRM.setCellAlign("center,center,center,left,center,center,center");
            grdRM.setCellHeight(20);
            grdRM.setImgPath("../icon");
            //grdRM.setIDPaging("paging_tarik");
            //grdRM.attachEvent("onRowClick","tarikDataPasien");
            //grdRM.onLoaded(tarikDataPasien);
            grdRM.baseURL("../rm/napza_utils.php?grd=grdIsiDataRM&idPel=0");
            grdRM.Init();
        }
	
	var getAllPosibilities = 0;
	
	function filterNoRM(ev,par){
		if(ev.which==13){
			if(isNaN(par.value) == true || par.value == ''){
				alert("Masukan Nomor Rekam Medis Dengan Benar !");
				return;
			}
			saring();
		}
	}
	
	function filter(ev,par){
	    var no_rm, local_getAllPosibilities;
	    if(ev.which==13 || ev.which == 1){
			if(ev.which == 1){
				no_rm = document.getElementById('txtFilter').value;
			}
			else if(ev.which == 13){
				no_rm = par.value;
			}
			else if(ev == 'pass'){
				no_rm = globNo_rm;
			}
		
			if(isNaN(no_rm) == true || no_rm == ''){
				alert("Masukan Nomor Rekam Medik dengan benar.");
				return;
			}
			if(par.id == 'txtNo'){
				local_getAllPosibilities = getAllPosibilities = 2;
			}
			else{
				local_getAllPosibilities = getAllPosibilities = 1;
			}
			no_rm = no_rm;
			Request("pelayanankunjungan_utils.php?grd=true&act=tarikMang&saring=true&no_rm="+no_rm+"&saringan="+txtTgl+"&tmpLay="+cmbTmpLay+"&inap="+inap+"&dilayani=", "spanTar1", "", "GET"
		, function(){
		    var tmp = document.getElementById('spanTar1').innerHTML;
		    //alert("pelayanankunjungan_utils.php?grd=true&saring=true&no_rm="+no_rm+"&saringan="+txtTgl+"&tmpLay="+cmbTmpLay+"&inap="+inap+"&dilayani=")
		    a1.loadURL("pelayanankunjungan_utils.php?grd=true&saring=true&no_rm="+no_rm+"&saringan="+txtTgl+"&tmpLay="+cmbTmpLay+"&inap="+inap+"&dilayani=","","GET");
		    
		    if(tmp == 0){
			if(local_getAllPosibilities == 1){
			    if(ev.which == 1){
				document.getElementById('tdTmp').innerHTML = ':&nbsp;&nbsp;'+document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].innerHTML;
				document.getElementById('tdJns').innerHTML = ':&nbsp;&nbsp;'+document.getElementById('cmbJnsLay').options[document.getElementById('cmbJnsLay').options.selectedIndex].innerHTML;
				
				if(inap == 1){
				    isiCombo('cmbKelasKamar',document.getElementById('cmbTmpLay').value,'','cmbKelas_ifinap',isiPindahKamar_ifinap);
				    document.getElementById('div_ifinap').style.display = 'block';
				}
				else{
				    document.getElementById('div_ifinap').style.display = 'none';
				}
				Request("pelayanankunjungan_utils.php?grd=tarik&act=tarikMang&no_rm="+no_rm,'spanTar1','', 'GET'
				, function(){
				    tmp = document.getElementById('spanTar1').innerHTML;
				    if(tmp > 0){
					//alert("pelayanankunjungan_utils.php?grd=tarik&no_rm="+no_rm+"&inapnya="+inap);
					tariky.loadURL("pelayanankunjungan_utils.php?grd=tarik&no_rm="+no_rm+"&inapnya="+inap,'','GET');
					new Popup('divTarikRujuk',null,{modal:true,position:'center',duration:1});
					document.getElementById('divTarikRujuk').popup.show();
				    }
				    else{
					alert("Pasien dengan no RM "+no_rm+" belum diregistrasi atau sudah dipulangkan, silahkan registrasi pasien terlebih dahulu.");
				    }
				}
				,'OK');
			    }
			}
			else{
			    alert("Pasien dengan Nomor Rekam Medik "+no_rm+" tidak ada.");
			    //document.getElementById('txtNo').value
			    no_rm = globNo_rm;
			    //a1.cellsGetValue(a1.getSelRow(),3);
			    document.getElementById('txtNo').value = no_rm;
			}
		    }
		}
		, 'OK');
	    }
	}
	
	function getPas(){
	    var unitAs = tariky.cellsGetValue(tariky.getSelRow(),8);
	    while(unitAs.search('&nbsp;') == true){
		unitAs = unitAs.replace('&nbsp;',' ');
	    }
	    var namPas = tariky.cellsGetValue(tariky.getSelRow(),4);
	    while(namPas.search('&nbsp;') == true){
		namPas = namPas.replace('&nbsp;',' ');
	    }
	    var unitTu = document.getElementById('tdTmp').innerHTML;
	    while(unitTu.search('&nbsp;') == true){
		unitTu = unitTu.replace('&nbsp;',' ');
	    }
	    unitTu = unitTu.replace('&nbsp;',' ');
	    var id = document.getElementById('act_tarik').value;
	    var teks;
	    if(id == 'btnSimpanKamar'){
			teks = " memindah kamar ";
	    }
	    else{
			teks = " merujuk ";
	    }
	    
	    if(confirm("Anda akan"+teks+namPas+", dari unit "+unitAs+", menuju Unit "+unitTu
		      +".\nAnda yakin?")){
		document.getElementById('txtFilter').value = '';
		var jamMasuk_ifinap = document.getElementById("JamMasuk_ifinap").value.replace(' ','');
		var tmp;
		if(inap == 1){
		    tmp = document.getElementById('cmbKamar_ifinap').options[document.getElementById('cmbKamar_ifinap').options.selectedIndex].lang;
		}
		var idKelas = document.getElementById('cmbKelas_ifinap').value;
		var idKamar = document.getElementById('cmbKamar_ifinap').value;
		var tglMasuk = document.getElementById('TglMasuk_ifinap').value;
		var jamMasuk = document.getElementById("jamServer").value.replace(' ','');
		var isManual = document.getElementById('chkManual_ifinap').checked==true?1:0;
		var userId = '<?php echo $_SESSION['userId']?>';
		var jnsLayKamar = document.getElementById('cmbJnsLay').value;
		var tmpLayKamar = document.getElementById('cmbTmpLay').value;
		var isDokPengganti = '';//document.getElementById('chkDokterPengganti_ifinap').checked==true?1:0;
		var ketRujukUnit = '';//document.getElementById('').value;
		var idDokRujukUnit = '';//document.getElementById('').value;
		var kamar = tariky.getRowId(tariky.getSelRow()).split("|");
		//alert(document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang)
		if(document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang == 1){
		  //->jika unit tujuan inap,maka harus validasi:
		  //1.perujuk bukan unit penunjang, eg. lab,rad,dsb
		  //2.jika dalam kunjungan tersebut terdapat kunjungan di unit inap lain yang tgl_out nya masih null (aktif)
		  //		, maka perujuknya harus unit tersebut.
		  if(kamar[16] == 1){//->penunjang
		    alert("Unit "+unitAs+" adalah unit penunjang, tidak bisa merujuk ke inap (MRS).");
		    return;
		  }
		  ///////////////////belum selesai,menunggu daftar unit inap yang tidak menutup kamar asal.
		  for(var i=0; i<tariky.getMaxRow(); i++){
		    var cari_perujuk_inap = tariky.getRowId(i+1).split("|");
		    //dalam looping ini mencari kunjungan pasien ke unit yang termasuk inap,
		    //jika ada maka harus unit itu yang jadi unit perujuk.
		    if(cari_perujuk_inap[17] == '' && cari_perujuk_inap[13] == 1){//--> jika tgl_out kosong & unit pasien merupakan inap
			   //if(cari_perujuk_inap[3] != kamar[3]){//->jika unit dari baris grid yang dipilih != unit baris grid yang dilooping
			   if(tariky.getSelRow() != i+1){//->jika baris grid yang dipilih != baris grid dalam looping
				    //cari_perujuk_inap[3]->unit data grid yang dilooping
				    //kamar[3]->unit baris grid yang dipilih (diklik)
				  var cari_unitAs = tariky.cellsGetValue(i+1,8);
				  if(cari_perujuk_inap[2] == kamar[2]){ //-> cek kunjungan_id sama atau tidak
				    //kalau kunjungan_id sama, maka untuk mrs/pindah kamar harus dari unit yang aktif (tempat pasien menginap sekarang)
				    alert("Kunjungan pasien "+namPas+" aktif di "+cari_unitAs+".\nUntuk MRS ke "+unitTu+", pilih "+cari_unitAs+" sebagai unit perujuk.");
				    return;
				  }
				  else{
				    //kalau kunjungan_id berbeda, maka muncul konfirmasi untuk tetap merujuk dari unit yang dipilih
				    //atau dari unit pasien aktif menginap.
				    if(confirm("Pasien "+namPas+" aktif menginap di "+cari_unitAs+" pada kunjungan lain.\nTetap merujuk dari "+unitAs+"?")){
					   
				    }
				    else{
					   return;
				    }
				  }
			   }
		    }
		  }
		}
		//jangan lupa dihapus kalo selesai
		//return;
	   //finish
		var url;
		switch(id){
		    case 'btnSimpanKamar':
			/*if(tariky.getRowId(tariky.getSelRow())!=''){
			    alert("Satu pasien hanya bisa dipindahkamarkan satu kali.");
			    return false;
			}*/
			if(idKamar == kamar[15]){//->id kamar tujuan & id kamar asal sama
			    alert("Anda tidak dapat memindahkamarkan pasien ke kamar yang sama.");
			    return false;
			}
			if(kamar[11] == 2){//->status dilayani
			    alert("Pasien ini sudah dipindahkamarkan ke kamar lain, tidak bisa dipindahkamarkan lagi.");
			    return false;
			}
			var tmp = document.getElementById('cmbKamar_ifinap').options[document.getElementById('cmbKamar_ifinap').options.selectedIndex].lang;
			//alert(jamMasuk);
			if(ValidateForm("JamMasuk_ifinap",'ind')){
			    var jamSplit=jamMasuk_ifinap.split(':');
			    if(jamSplit.length!=2){
					alert('Format Jam Salah!');
					return false;
			    }
			    if(isNaN(jamSplit[0]) || isNaN(jamSplit[1]) || jamSplit[0]=='' || jamSplit[1]==''  || jamSplit[0].length!=2 || jamSplit[1].length!=2){
					alert('Format Jam Salah!');
					return false;
			    }
			    jamMasuk_ifinap=jamMasuk_ifinap+':'+time[2];
			    getIdKelas=idKelas;
			    url = "tindiag_utils.php?grd4=true&act=tambah&kunjungan_id="+getIdKunj+"&smpn="+id+"&tarip="+tmp+"&ksoId="+getKsoId
				+"&pasienId="+getIdPasien+"&pelayanan_id="+getIdPel+"&kamar_id="+idKamar+"&kamar_lama="+kamar[15]+"&tglMasuk="+tglMasuk
				+"&jamMasuk="+jamMasuk_ifinap+"&isManual="+isManual+"&userId="+userId+"&unitAsal="+getIdUnit
				+"&tmpLayKamar="+tmpLayKamar+"&jnsLayKamar="+jnsLayKamar+"&kelasId="+idKelas+"&unit_id="+getIdUnit;
			}
			break;
		    case 'btnSimpanRujukUnit':                       
			if(inap==1){//document.getElementById('lgnJudul').innerHTML=='MRS'
			    if(kamar[11] == 2){
					alert("Pasien ini sudah dipindahkamarkan ke kamar lain, tidak bisa merujuk untuk inap lagi.");
					return false;
			    }
			    
				url = "tindiag_utils.php?grd2=true&isInap=1&act=tambah&smpn="+id+"&tarip="+tmp+"&kamar="+idKamar
				+"&pasienId="+getIdPasien+"&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj+"&ket="+ketRujukUnit
				+"&idDok="+idDokRujukUnit+"&jnsLay="+jnsLayKamar+"&tmpLay="+tmpLayKamar+"&unitAsal="+getIdUnit
				+"&kelas="+idKelas+"&userId="+userId+"&isDokPengganti="+isDokPengganti+"&ksoId="+getKsoId;
			}
			else{
			    if(kamar[3] == tmpLayKamar){
					alert("Pasien ini sudah terdaftar di unit anda.");
					return false;
			    }
			    
				url = "tindiag_utils.php?grd2=true&isInap=0&act=tambah&smpn="+id
				+"&kunjungan_kelas_id="+getIdKelasKunj+"&kelas_id="+getKelas_id+"&pasienId="+getIdPasien
				+"&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj+"&ket="+ketRujukUnit+"&idDok="+idDokRujukUnit
				+"&jnsLay="+jnsLayKamar+"&tmpLay="+tmpLayKamar+"&unitAsal="+getIdUnit+"&unit_pelaksana="+getIdUnit
				+"&kelas="+idKelas+"&ksoId="+getKsoId+"&ksoKelasId="+getKsoKelasId+"&userId="+userId
				+"&isDokPengganti="+isDokPengganti;
			}
			break;
		}
		//alert(url);
		Request(url+"&pullMR=tarikMang","spanTar1",'',"GET",closePop,'OK');
	    }
	}
	
	function closePop(){
	    document.getElementById('divTarikRujuk').popup.hide();
	    saring();
	}
	
	function tarikDataPasien(par){
            if(tariky.getRowId(tariky.getSelRow())!=''){
                var sisip=tariky.getRowId(tariky.getSelRow()).split("|");
                getIdPasien=sisip[0]; //id pasien;
                getIdPel=sisip[1]; //id pelayanan;
                getIdKunj=sisip[2]; //id kunjungan;
                getIdUnit=sisip[3]; //id unit;
                getIdKelas=sisip[4]; //id kelas;
                getUmur=sisip[5]; //umur pasien;
                getKsoId=sisip[6];
                getKsoKelasId=sisip[7];
                getKepemilikan=sisip[8];
                getIdKelasKunj=sisip[10];
                getInap = sisip[13];
                getKelas_id = sisip[12]; //kelas id
                getDilayani=sisip[11];
		
		document.getElementById('trpindah1').style.display = 'none';
		document.getElementById('trpindah2').style.display = 'none';
	       if(getInap == 1){
		    if(getInap == inap){
			// 1 = 1 -> inap ke inap = pindah kamar
			document.getElementById('trpindah1').style.display = 'table-row';
			document.getElementById('trpindah2').style.display = 'table-row';
			document.getElementById('act_tarik').value = "btnSimpanKamar";
		    }
		    else{
			// 1 != 0 -> inap ke jalan = rujuk
			//document.getElementById('lgnJudul').innerHTML=='non-MRS';
			document.getElementById('act_tarik').value = "btnSimpanRujukUnit";
		    }
	       }
	       else{
		    if(getInap == inap){
			// 0 = 0 -> jalan ke jalan = rujuk
			//document.getElementById('lgnJudul').innerHTML=='non-MRS';
			document.getElementById('act_tarik').value = "btnSimpanRujukUnit";
		    }
		    else{
			// 0 = 1 -> jalan ke inap = rujuk inap
			//document.getElementById('lgnJudul').innerHTML=='MRS';
			document.getElementById('act_tarik').value = "btnSimpanRujukUnit";
		    }
		}
	    }
	}
	
	var globNo_rm = '';
	function ambilDataPasien(key,val){
	var tmp;
	//var xxx;
		//alert("key="+key+", val="+val);
		if (val!=undefined){
			tmp=val.split("*|*");
			if (tmp[1]!=""){
				alert(tmp[1]);
			}
		}
		
		document.getElementById('ctkLabRadPerKonsul').style.visibility='collapse';
		
		if(a1.getRowId(a1.getSelRow())!=''){
			var sisip=a1.getRowId(a1.getSelRow()).split("|");
			
			getInap = sisip[13];
			getDilayani=sisip[11];
			//alert(a1.cellsGetValue(a1.getSelRow(),2));
			
			var p = '';
			if(getInap == 1 && getDilayani == 1){
			p ="txtNo*-*"+a1.cellsGetValue(a1.getSelRow(),3)+"*|*txtNama*-*"+a1.cellsGetValue(a1.getSelRow(),4)+"*|*txtTglLhr*-*"+a1.cellsGetValue(a1.getSelRow(),10)+"*|*txtUmur*-*"+sisip[5]+"*|*txtSex*-*"+a1.cellsGetValue(a1.getSelRow(),5)+"*|*txtOrtu*-*"+a1.cellsGetValue(a1.getSelRow(),11)+"*|*txtPelUnit*-*"+sisip[9]+"*|*nomorLab*-*"+sisip[14];
			}
			else{
			p ="txtNo*-*"+a1.cellsGetValue(a1.getSelRow(),3)+"*|*txtNama*-*"+a1.cellsGetValue(a1.getSelRow(),4)+"*|*txtTglLhr*-*"+a1.cellsGetValue(a1.getSelRow(),9)+"*|*txtUmur*-*"+sisip[5]+"*|*txtSex*-*"+a1.cellsGetValue(a1.getSelRow(),5)+"*|*txtOrtu*-*"+a1.cellsGetValue(a1.getSelRow(),10)+"*|*txtPelUnit*-*"+sisip[9]+"*|*nomorLab*-*"+sisip[14];
			}
			fSetValue(window,p);
	
	
			if(getInap == 1 && getDilayani == 1){
			document.getElementById('txtAlmt').innerHTML=a1.cellsGetValue(a1.getSelRow(),9);
			}
			else{
			document.getElementById('txtAlmt').innerHTML=a1.cellsGetValue(a1.getSelRow(),8);
			}
			getIdPasien=sisip[0]; //id pasien;
			getIdPel=sisip[1]; //id pelayanan;
			getIdKunj=sisip[2]; //id kunjungan;
			getIdUnit=sisip[3]; //id unit;
			getIdKelas=sisip[4]; //id kelas;
			getUmur=sisip[5]; //umur pasien;
			getKsoId=sisip[6];
			getKsoKelasId=sisip[7];
			getKepemilikan=sisip[8];
			getIdKelasKunj=sisip[10];
			getNoPasien=a1.cellsGetValue(a1.getSelRow(),3);
			
			getKelas_id = sisip[12]; //kelas id
			
			getKamarId = sisip[15];// = kamar_id;
			//sisip[16] = kamar_nama;
			//=========tambahan by joker==================
			getTgl_sjp = sisip[19];
			Request('pelayanankunjungan_utils.php?act=getTglInap&idKunj='+getIdKunj,'spnTglInap','','GET',
				function(){
					getTgl_Inap = document.getElementById('spnTglInap').innerHTML;
				},'ok');
			//xxx=a1.cellsGetValue(a1.getSelRow(),2).split(" ");
			//getTgl_Inap = xxx[0];
			getNoSJP = sisip[20];
			getNoJaminan = sisip[21];
			getStatusPenj = sisip[22];
			getnmPeserta = sisip[23];
			//=========tambahan==================
			//=========tambahan by fidi untuk tombol verifikasi=========//
			getVerifikasi = sisip[24];
			getVerifikator = sisip[25];
			cekVerifikasi();
			//===================================================//
			isiCombo('cmbKamar',getIdUnit+','+getIdKelas);
			//alert(getIdUnit);
			//isiCombo('JnsLayanan','',document.getElementById('cmbJnsLay').value,'',isiTmpLayanan);
			if(sisip[18] == 1){
				document.getElementById('btnMRS').disabled = true;
			}
			else{
				document.getElementById('btnMRS').disabled = false;
			}
			
			if(getInap == 1 && getDilayani == 1){
				document.getElementById('tdStat').innerHTML = '<blink>'+a1.cellsGetValue(a1.getSelRow(),7)+'</blink>';
			}
			else{
				document.getElementById('tdStat').innerHTML = '<blink>'+a1.cellsGetValue(a1.getSelRow(),6)+'</blink>';
			}
	
			if(getInap == 1){
				document.getElementById('spanKam').innerHTML = " &nbsp;&nbsp;Kamar : "+sisip[16];
			}
			else{
				document.getElementById('spanKam').innerHTML = "";
			}
			//isiTmpLayanan();
			isiTmpLayananMutasi();

			isiCombo('cmbKelasKamar',document.getElementById('cmbTL').value,sisip[4],'cmbKelas',isiPindahKamar);

			isiCombo('JnsLayananDenganInap','',document.getElementById('cmbJnsLay').value,'cmbJL',isiCmbTL);

			if(getDilayani==1 || getDilayani == 2){
				document.getElementById('btnMutasi').disabled=true;
			}
			else{
				document.getElementById('btnMutasi').disabled=false;
			}
                
			if(getIdUnit=='58' || getIdUnit=='59'){
				document.getElementById('btnLab').disabled = false;
				document.getElementById('divLab').style.display = 'block';
			}
			else{
				document.getElementById('btnLab').disabled = true;
				document.getElementById('divLab').style.display = 'none';
			}

			if(getIdUnit=='45'){//jika unit IGD
				isiCombo('cmbKasusIGD','','','cmbKasus');
				isiCombo('cmbEmergency');
				isiCombo('cmbKondisiPasien');
				document.getElementById('trEmergency').style.visibility='visible';
				document.getElementById('trKondisiPasien').style.visibility='visible';
			}
			else{
				document.getElementById('cmbKasus').innerHTML='<option value="1">Baru</option><option value="0">Lama</option>';
				document.getElementById('trEmergency').style.visibility='collapse';
				document.getElementById('trKondisiPasien').style.visibility='collapse';
			}
			//alert(document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang);
		   	if(document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang=='1'){
				if(getDilayani!='0'){
					document.getElementById('dtlPas').disabled=false;
					document.getElementById('updtPas').disabled=true;
				}
				else{
					document.getElementById('dtlPas').disabled=true;
					document.getElementById('updtPas').disabled=false;
				}
			}
			else{
				document.getElementById('dtlPas').disabled=false;
				document.getElementById('updtPas').disabled=true;
			}
		
			//alert("tindiag_utils.php?grd1=true&pelayanan_id="+sisip[1]);
			f.loadURL("tindiag_utils.php?grd=true&pelayanan_id="+sisip[1],"","GET");
			//alert("tindiag_utils.php?grd1=true&pelayanan_id="+sisip[1]);
			b.loadURL("tindiag_utils.php?grd1=true&pelayanan_id="+sisip[1],"","GET");
			c.loadURL("tindiag_utils.php?grd2=true&kunjungan_id="+sisip[2]+"&unitAsal="+getIdUnit+"&filter="+c.getFilter()+"&sorting="+c.getSorting()+"&page="+c.getPage(),"","GET");
            
			//alert("tindiag_utils.php?grd3=true&kunjungan_id="+sisip[2]+"&pelayanan_id="+sisip[1]);
			d.loadURL("tindiag_utils.php?grd3=true&kunjungan_id="+sisip[2]+"&pelayanan_id="+sisip[1],"","GET");
			e.loadURL("tindiag_utils.php?grd4=true&kunjungan_id="+sisip[2]+"&unit_id="+sisip[3],"","GET");
			//resep
			//r.loadURL("tindiag_utils.php?grdResep=true&pelayanan_id="+sisip[1],"","GET");
			aResep.loadURL("tindiag_utils.php?grdRsp1=true&pelayanan_id="+sisip[1],"","GET");
			bhp.loadURL("bhp_utils.php?pelayanan_id_bhp="+sisip[1],"","GET");
			
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokTind',cekLogPelaksana);
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokDiag',cekLogPelaksana);
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokResep',cekLogPelaksana);
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokHsl',cekLogPelaksana);
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokHslRad',cekLogPelaksana);
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokAnamnesa',cekLogPelaksana);
			
			
			//raga lab
			if(document.getElementById('cmbJnsLay').value==57){
				//alert("hasilLab_utils.php?grd=true&pelayanan_id="+sisip[1]);
				isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokHsl',cekLogPelaksana);
				lab.loadURL("hasilLab_utils.php?grd=true&pelayanan_id="+sisip[1],"","GET");
			}
			
			//raga rad
			if(document.getElementById('cmbJnsLay').value==60){
				isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokHslRad',cekLogPelaksana);
				//alert("hasilRad_utils.php?grd=true&pelayanan_id="+sisip[1]);
				rad.loadURL("hasilRad_utils.php?grd=true&pelayanan_id="+sisip[1],"","GET");
			}
			
			//penyebab kecelakaan
			document.getElementById('chkPenyebabKecelakaan').checked = '';
			if(document.getElementById('cmbTmpLay').value==45){
				document.getElementById('pil_PK').style.display='inline';
			}
			else{
				document.getElementById('pil_PK').style.display='none';
			}
			
			isiCombo('cmbApotek_ruangan',getIdUnit,'','cmbApotek');
	 
			if("<?php echo isset($_POST['sentPar'])?>" == 1 && document.getElementById('txtFilter').value != ''){
			   detail();
			}
		}
		else{
			document.getElementById('dtlPas').disabled=true;
			document.getElementById('updtPas').disabled=true;
		}
	    
	    if(getAllPosibilities == 2){
			//melakukan pengecekan, jika setelah grid diload menghasilkan 1 data pasien,maka akan langsung masuk pada pelayanan.
			//jika > 1 maka user disuruh memilih dulu pasien yang mana yang akan diproses.
			//jika = 0 maka akan dilakukan pengecekan apakah unit user inap atau tidak.
			//jika inap dan jika unit asal pasien juga inap, maka action yang dilakukan adalah pindah kamar
			//jika inap dan jika unit asal pasien bukan inap, maka action yang dilakukan rujuk inap
			//jika bukan inap maka action yang dilakukan rujuk unit
			var jmlHal = a1.getMaxPage();
			var jmlOrg = a1.getMaxRow();
			if(jmlHal == 1 && jmlOrg == 1){
				if(getInap == 1){
					if(getDilayani == 1){
						detail();
					}
					else{
						updatePas(getAllPosibilities);
					}
				}
				else{
					detail();
				}
			}
			else if(jmlHal == 0){
				alert("Pasien dengan Nomor Rekam Medik "+document.getElementById('txtNo').value+" tidak ada.");
				//var no_rm = a1.cellsGetValue(a1.getSelRow(),3);
				document.getElementById('txtNo').value = globNo_rm;
			}
			getAllPosibilities = 0;
		}
	}

	function loadUlang(){
		if(document.getElementById('divKunj').style.display=='block'){
			//alert(cmbDilayani);
			goFilterAndSort('gridbox');
			//alert('refresh');
			setTimeout("loadUlang()","120000");
		}
	}
	
	function saring(){
		//alert('saring');            
		txtTgl=document.getElementById('txtTgl').value;
		cmbTmpLay=document.getElementById('cmbTmpLay').value;
		cmbDilayani=document.getElementById('cmbDilayani').value;
		//document.getElementById('cmbTmpLay').lang=document.getElementById('cmbTmpLay').value;
		//alert(document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang);
		unitId=document.getElementById('cmbTmpLay').value;
		jenisUnitId=document.getElementById('cmbJnsLay').value;
		if(cmbDilayani == -1 && inap == 1 || inap == 0){
			document.getElementById('trTgl').style.visibility='visible';
		}
		else{
			document.getElementById('trTgl').style.visibility='collapse';
		}
		//for anastesi
		//alert(cmbTmpLay);
		if(cmbTmpLay == 6 || cmbTmpLay == 7 || cmbTmpLay == 13 || cmbTmpLay == 18 || cmbTmpLay == 47 || cmbTmpLay == 63){
			document.getElementById('div_an').style.display = 'table-cell';
		}
		else{
			document.getElementById('div_an').style.display = 'none';
		}
		var no_rm = document.getElementById('txtFilter').value;
		var url = "pelayanankunjungan_utils.php?grd=true&saring=true&no_rm="+no_rm+"&saringan="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbTmpLay').value+"&no_rm="+no_rm+"&inap="+inap+"&dilayani="+document.getElementById('cmbDilayani').value;
		//alert(url)
		//a1.loadURL(url,"","GET");
		
		//mukti
		if(inap==1 && document.getElementById('cmbDilayani').value==1){
			a1.setColHeader("NO,TGL,NO RM,NAMA,L/P,KAMAR,PENJAMIN,ASAL KUNJUNGAN,ALAMAT,T.LHR,NAMA ORTU,KETERANGAN");
            a1.setIDColHeader(",,no_rm,nama,,kamar,namakso,,,,nama_ortu,alamat");
            a1.setColWidth("30,80,80,200,30,100,150,140,250,70,100,70");
            a1.setCellAlign("center,center,center,left,center,center,center,center,center,center,left,left");			
		}
		else{
			a1.setColHeader("NO,TGL,NO RM,NAMA,L/P,PENJAMIN,ASAL KUNJUNGAN,ALAMAT,T.LHR,NAMA ORTU,KETERANGAN");
            a1.setIDColHeader(",,no_rm,nama,,namakso,,,,nama_ortu,alamat");
            a1.setColWidth("30,80,80,200,30,150,140,250,70,100,70");
            a1.setCellAlign("center,center,center,left,center,center,center,center,center,left,left");
		}
		a1.loadURL(url,"","GET");
	}

	function detail(){
	    globNo_rm = a1.cellsGetValue(a1.getSelRow(),3);
	    //alert(document.getElementById('dtlPas').disabled);
	    if (document.getElementById('dtlPas').disabled==false){
		    document.getElementById('divKunj').style.display='none';
		    document.getElementById('divDetil').style.display='block';
		    mTab.refreshTab();
	    }
	    document.getElementById('btnPasienPulang').style.display = 'none';
	    document.getElementById('btnBatalPulang').style.display = 'none';
         //pasien yang pindah kamar, tombol pasien pulang / batal pulang tidak akan muncul.
	    if(getDilayani != 2 && inap == 1){
			if(document.getElementById('cmbDilayani').value == -1){
				document.getElementById('btnBatalPulang').style.display = 'inline-table';
			}
			else{
				document.getElementById('btnPasienPulang').style.display = 'inline-table';
			}
	    }
	}
	
	function updatePas(gap){
		//alert(getIdUnit+','+getIdKelas);
		isiCombo('cmbKamar',getIdUnit+','+getIdKelas,'','kamarPx');
		new Popup('divPilihKamar',null,{modal:true,position:'center',duration:1});
		document.getElementById('divPilihKamar').popup.show();
	}
	
	function PilihKamarPx(gap){
	var url;
		if(confirm("Anda yakin ingin mengubah status dilayani pada pasien ini?")){
			var inap = document.getElementById('cmbJnsLay').options[document.getElementById('cmbJnsLay').options.selectedIndex].lang;
			var no_rm = document.getElementById('txtFilter').value;
			url="pelayanankunjungan_utils.php?grd=true&saring=true&no_rm="+no_rm+"&act=update&pelayanan_id="+getIdPel+"&saringan="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbTmpLay').value+"&inap="+inap+"&dilayani="+document.getElementById('cmbDilayani').value+"&pilihKamar="+document.getElementById('kamarPx').value;
			//alert(url);
			a1.loadURL(url,"","GET");
			document.getElementById('divPilihKamar').popup.hide();
		}
	    else{
			if(gap == 2){
				document.getElementById('divDetil').style.display='none';
				document.getElementById('divKunj').style.display='block';
				loadUlang();
				document.getElementById('chkTind').checked=false;
				showUnit(false);
				//filter('pass',globNo_rm);
			}
	    }
	}
    </script>

    <!--script detil pelayanan-->
    <script type="text/JavaScript" language="JavaScript">
	function cekLogPelaksana(){
		if(document.getElementById('cmbDokTind').value==<?php echo $userId; ?>){
			disPelakasana(true);	
		}
		else{
			disPelakasana(false);
		}
	}
	
	function disPelakasana(disabel){
		document.getElementById('cmbDokRujukUnit').disabled = document.getElementById('cmbDokRujukRS').disabled = document.getElementById('cmbDokDiag').disabled = document.getElementById('cmbDokResep').disabled = document.getElementById('cmbDokTind').disabled = document.getElementById('cmbDokAnamnesa').disabled = disabel;
		
		document.getElementById('chkDokterPenggantiDiag').disabled = document.getElementById('chkDokterPenggantiResep').disabled = document.getElementById('chkDokterPenggantiTind').disabled = document.getElementById('chkDokterPenggantiRujukUnit').disabled = document.getElementById('chkDokterPenggantiRujukRS').disabled = document.getElementById('chkDokterPenggantiAnamnesa').disabled = disabel;	
	}
	
	function gantiDokter(comboDokter,statusCek,disabel){
		if(statusCek==true){
			isiCombo('cmbDokPengganti',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokRujukUnit');
			isiCombo('cmbDokPengganti',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokRujukRS');
			isiCombo('cmbDokPengganti',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokDiag');
			isiCombo('cmbDokPengganti',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokResep');
			isiCombo('cmbDokPengganti',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokTind');
			isiCombo('cmbDokPengganti',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokAnamnesa');
			//isiCombo('cmbDokPengganti',document.getElementById('cmbTmpLay').value,'',comboDokter);
		}
		else{
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokRujukUnit');
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokRujukRS');
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokDiag');
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokResep');
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokTind');
			isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'<?php echo $userId; ?>','cmbDokAnamnesa');
			//isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,comboDokter,'');
		}
		document.getElementById('chkDokterPenggantiDiag').checked = document.getElementById('chkDokterPenggantiResep').checked = document.getElementById('chkDokterPenggantiTind').checked = document.getElementById('chkDokterPenggantiRujukUnit').checked = document.getElementById('chkDokterPenggantiRujukRS').checked = document.getElementById('chkDokterPenggantiAnamnesa').checked = statusCek;
	}
		
	function setManual(val){
		if(val == 'ifinap'){
			if(document.getElementById('chkManual_ifinap').checked==true){
				document.getElementById('JamMasuk_ifinap').readOnly=false;
				document.getElementById('btnTglMasuk_ifinap').disabled=false;
			}
			else{
				document.getElementById('JamMasuk_ifinap').readOnly=true;
				document.getElementById('btnTglMasuk_ifinap').disabled=true;
			}
		}
		else if(val == 'krs') {
			if(document.getElementById('chkManualKrs').checked==true){
				document.getElementById('JamKrs').readOnly=false;
				document.getElementById('btnTglKrs').disabled=false;
			}
			else{
				document.getElementById('JamKrs').readOnly=true;
				document.getElementById('btnTglKrs').disabled=true;
			}
		}
		else {
			if(document.getElementById('chkManual').checked==true){
				document.getElementById('JamMasuk').readOnly=false;
				document.getElementById('btnTglMasuk').disabled=false;
			}
			else{
				document.getElementById('JamMasuk').readOnly=true;
				document.getElementById('btnTglMasuk').disabled=true;
			}
		}
	}

	var time;
	var tanggal=document.getElementById('TglMasuk').value.split("-");
	var tanggal_ifinap=document.getElementById('TglMasuk_ifinap').value.split("-");
	var tanggalKrs=document.getElementById('TglKrs').value.split("-");
	var tmpTgl=tanggal;
	var ttgl=parseInt((tanggal[0].substr(0,1)=='0')?tanggal[0].substr(1,1):tanggal[0]);
	var tbln=parseInt((tanggal[1].substr(0,1)=='0')?tanggal[1].substr(1,1):tanggal[1]);
	var tthn=parseInt((tanggal[2].substr(0,1)=='0')?tanggal[2].substr(1,1):tanggal[2]);

	function setJam(){
		time=document.getElementById('jamServer').value.split(':');
		var tjam=parseInt((time[0].substr(0,1)=='0')?time[0].substr(1,1):time[0]);
		var tmenit=parseInt((time[1].substr(0,1)=='0')?time[1].substr(1,1):time[1]);
		var tdetik=parseInt((time[2].substr(0,1)=='0')?time[2].substr(1,1):time[2]);
		//alert(tjam+':'+tmenit+':'+tdetik);
		tdetik+=1;
		if((tdetik)>=60){
			tdetik=tdetik-60;
			tmenit++;
			if(tmenit>=60){
				tmenit=tmenit-60;
				tjam++;
				if(tjam==24){
					tjam=0;
					ttgl++;
					if(tbln==1 || tbln==3 || tbln==5 || tbln==7 || tbln==8 || tbln==10 || tbln==12){
						if(ttgl>31){
							ttgl=1;
							tbln++;
						}
					}
					else if(tbln==4 || tbln==6 || tbln==9 || tbln==11){
						if(ttgl>30){
							ttgl=1;
							tbln++;
						}
					}
					else{
						if((tthn % 4)==0){
							if(ttgl>29){
								ttgl=1;
								tbln++;
							}
						}
						else{
							if(ttgl>28){
								ttgl=1;
								tbln++;
							}
						}
					}
					if(tbln>12){
						tbln=1;
						tthn++;
					}
				}
			}
		}
		if(tjam<10){
			time[0]='0'+tjam;
		}
		else{
			time[0]=tjam;
		}
		if(tmenit<10){
			time[1]='0'+tmenit;
		}
		else{
			time[1]=tmenit;
		}
		if(tdetik<10){
			time[2]='0'+tdetik;
		}
		else{
			time[2]=tdetik;
		}

		if(ttgl<10){
			tanggal[0]='0'+ttgl;
		}
		else{
			tanggal[0]=ttgl;
		}
		if(tbln<10){
			tanggal[1]='0'+tbln;
		}
		else{
			tanggal[1]=tbln;
		}
		if(tthn<10){
			tanggal[2]='0'+tthn;
		}
		else{
			tanggal[2]=tthn;
		}
		
		tmpTgl=tanggal[0]+'-'+tanggal[1]+'-'+tanggal[2];
		document.getElementById('jamServer').value=time[0]+':'+time[1]+':'+time[2];
		
		if(document.getElementById('chkManual_ifinap').checked==false){
			document.getElementById('JamMasuk_ifinap').value=time[0]+':'+time[1];
		}
		
		if(document.getElementById('chkManual').checked==false){
			document.getElementById('JamMasuk').value=time[0]+':'+time[1];
			document.getElementById('TglMasuk').value=tmpTgl;
		}
		
		if(document.getElementById('chkManualKrs').checked==false){
			document.getElementById('JamKrs').value=time[0]+':'+time[1];
			document.getElementById('TglKrs').value=tmpTgl;
		}
		//alert(tjam+':'+tmenit+':'+tdetik);
		setTimeout("setJam()","1000");
	}

	function rujukUnit(tombol){
		//alert(tombol);
		document.getElementById('lgnJudul').innerHTML=tombol;
		if(tombol=='MRS'){
	//alert("tindiag_utils.php?grd2=true&kunjungan_id="+getIdKunj+"&unitAsal="+getIdUnit+"&isInap=1&filter="+c.getFilter()+"&sorting="+c.getSorting()+"&page="+c.getPage());
			isiCombo('JnsLayananDenganInap','<?php echo $_SESSION['userId'];?>',document.getElementById('cmbJnsLay').value,'JnsLayanan',isiTmpLayanan);
			c.loadURL("tindiag_utils.php?grd2=true&kunjungan_id="+getIdKunj+"&unitAsal="+getIdUnit+"&isInap=1&filter="+c.getFilter()+"&sorting="+c.getSorting()+"&page="+c.getPage(),"","GET");
			//+"&pasienId="+getIdPasien
			document.getElementById('btnSpInap').style.display="block";
		}
		else{
			isiCombo('JnsLayananKonsul','<?php echo $_SESSION['userId'];?>',document.getElementById('cmbJnsLay').value,'JnsLayanan',isiTmpLayananKonsul);
			//alert("tindiag_utils.php?grd2=true&kunjungan_id="+getIdKunj+"&unitAsal="+getIdUnit+"&isInap=0&filter="+c.getFilter()+"&sorting="+c.getSorting()+"&page="+c.getPage());
			c.loadURL("tindiag_utils.php?grd2=true&kunjungan_id="+getIdKunj+"&unitAsal="+getIdUnit+"&isInap=0&filter="+c.getFilter()+"&sorting="+c.getSorting()+"&page="+c.getPage(),"","GET");
			//+"&pasienId="+getIdPasien
			document.getElementById('btnSpInap').style.display="none";
		}
		
		ambilDataRujukUnit();
		
		new Popup('divRujukUnit',null,{modal:true,position:'center',duration:1});
		document.getElementById('divRujukUnit').popup.show();
	}
	
	function cetak_rm(url){
		window.open(url+'?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idPasien='+getIdPasien+'&idUser=<?php echo $userId;?>','_blank');
	}
		
	function cetakRincian(p){
		var tmpLay = document.getElementById('txtPelUnit').value;
		if (p==0){
			window.open('RincianTindakan.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap,'_blank');
		}
		else if(p==1){
			window.open('RincianTindakanKSO.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=0','_blank');
		}
		else if(p==2){
			window.open('RincianTindakanLab.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tmpLay='+tmpLay,'_blank');
		}
		else if(p==3){
			window.open('RincianTindakanKSO.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=1','_blank');
		}
		else if(p==4){
			window.open('RincianTindakanKSO.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=2','_blank');
		}
		else if(p==5){
			window.open('RincianTindakanRad.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tmpLay='+tmpLay,'_blank');
		}
		else if(p==6){
			window.open('RincianTindakanHd.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tmpLay='+tmpLay,'_blank');
		}
		else if(p==7){
			window.open('RincianTindakanKSO.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=0&for=1','_blank');
		}
		else if(p==8){
			window.open('RincianTindakanKSO.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=1&for=1','_blank');
		}
		else if(p==9){
			window.open('RincianTindakanKSO.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=2&for=1','_blank');
		}
		else if(p==10){
			window.open('RincianTindakanKSO_Detail.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=2','_blank');
		}
		else if(p==11){
			window.open('RincianTindakanKSO_Detail.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=2&for=1','_blank');
		}
		else if(p==12){
			window.open('RincianObatKSO.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=2','_blank');
		}
		else if(p==13){
			window.open('RincianTindakanObatKSO.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idUser=<?php echo $userId;?>&inap='+inap+'&tipe=2','_blank');
		}
		else if(p==14){
			window.open('../pembayaran/tagihanKlaim.php?kunjungan_id='+getIdKunj+'&idbayar=0&idUser=<?php echo $userId;?>&jenisKasir=0','_blank');
		}
	}

	function resumeMedis(){
		window.open('resumemedis.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idPasien='+getIdPasien,'_blank');
	}

	function rujukRS(){
		new Popup('divRujukRS',null,{modal:true,position:'center',duration:1});
		document.getElementById('divRujukRS').popup.show();
	}
	
	function isiDataRM(){
		window.scroll(0,0);
		evCmbDataRM();
		new Popup('divIsiDataRM',null,{modal:true,position:'center',duration:1});
		document.getElementById('divIsiDataRM').popup.show();
	}
	
	function isiAnamnesa(){
		window.scroll(0,0);
		new Popup('divIsiAnamnesa',null,{modal:true,position:'center',duration:1});
		document.getElementById('divIsiAnamnesa').popup.show();
		anam.loadURL('tindiag_utils.php?grdAnamnesa=true&pasien_id='+getIdPasien,'','GET');
		anamnesa_kepala_leher.multiselect('uncheckAll');
		anamnesa_cor.multiselect('uncheckAll');
		anamnesa_pulmo.multiselect('uncheckAll');
		anamnesa_inspeksi.multiselect('uncheckAll');
		anamnesa_auskultasi.multiselect('uncheckAll');
		anamnesa_palpasi.multiselect('uncheckAll');
		anamnesa_perkusi.multiselect('uncheckAll');
		anamnesa_ekstremitas.multiselect('uncheckAll');
		document.getElementById('btnDeleteAnamnesa').disabled=true;
		batalAnamnesa();
	}
	
	function isiMintaDarah(){
		Request('minta_no_permintaan_darah.php','temp_no_minta','','GET',proses_isi_minta_darah,'NoLoad');
	}
	
	function proses_isi_minta_darah(){
		//alert('minta_darah_util.php?idpelayanan='+getIdPel);
		//document.getElementById('no_bukti').value=document.getElementById('temp_no_minta').innerHTML;
		//alert('minta_darah_util.php?idpelayanan='+getIdPel);
		md.loadURL('minta_darah_util.php?idpelayanan='+getIdPel,'','GET');
		batall();
		window.scroll(0,0);
		new Popup('MintaDarah',null,{modal:true,position:'center',duration:1});
		document.getElementById('btCetak').disabled=true;
		document.getElementById('MintaDarah').popup.show();
		//document.getElementById('divDetil').style.display = 'none';
		//document.getElementById('MintaDarah').style.display = 'block';
	}
	
	//resep
	var resep_baru=0,actPopResep;
	function tambahResep(){
		resep_baru=1;
		actPopResep="tambah";
		document.getElementById('chRacikan').checked=false;
		CekRacikan(document.getElementById('chRacikan'));
		//document.getElementById('trNoResep').style.display='none';
		document.getElementById('cmbApotek').disabled=false;
		new Popup('divResep',null,{modal:true,position:'center',duration:1});
		document.getElementById('divResep').popup.show();
		r.loadURL("tindiag_utils.php?grdResep=true&pelayanan_id=0","","GET");
		document.getElementById('txtNmObat').focus();
	}
	
	function CekRacikan(obj){
		if (obj.checked){
			document.getElementById('satuanRacikan').style.visibility='visible';
			document.getElementById('trRacikan').style.visibility='visible';
			document.getElementById('trJmlBahan').style.visibility='visible';
		}else{
			document.getElementById('satuanRacikan').style.visibility='collapse';
			document.getElementById('trRacikan').style.visibility='collapse';
			document.getElementById('trJmlBahan').style.visibility='collapse';
		}
	}
	//resep
	function editResep(){
	var noResep=document.getElementById('noResep').value;
	var apotek_id=document.getElementById('cmbApotek').value;
	var url,sisip;
		if (noResep=="undefined"){
			alert("Pilih Resep Terlebih Dahulu !");
			return false;
		}else{
			sisip = aResep.getRowId(aResep.getSelRow()).split("|");
			tgl_resep = sisip[1];
			resep_baru=0;
			actPopResep="edit";
			document.getElementById('chRacikan').checked=false;
			CekRacikan(document.getElementById('chRacikan'));
			//document.getElementById('trNoResep').style.display='none';
			document.getElementById('cmbApotek').disabled=true;
			new Popup('divResep',null,{modal:true,position:'center',duration:1});
			document.getElementById('divResep').popup.show();
			url="tindiag_utils.php?grdResep=true&pelayanan_id="+getIdPel+"&noResep="+noResep+"&apotek="+apotek_id+"&tgl_resep="+tgl_resep;
			//alert(url);
			r.loadURL(url,"","GET");
			document.getElementById('txtNmObat').focus();
		}
	}
	//resep

	function setKamar(){
		new Popup('divSetKamar',null,{modal:true,position:'center',duration:1});
		document.getElementById('divSetKamar').popup.show();
	}
	
	function rekamMedis(){
		window.open('rekamMedis.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idPasien='+getIdPasien,'rekam_medis');
	}
	
	function setMutasi(){
		new Popup('divSetMutasi',null,{modal:true,position:'center',duration:1});
		document.getElementById('divSetMutasi').popup.show();
	}
        
	function ctkVis(){
		isiCombo('cmbDokVisite',getIdPel,'');
		new Popup('divCtkVis',null,{modal:true,position:'center',duration:1});
		document.getElementById('divCtkVis').popup.show();
	}
	
	function cetakVisite(){
		var dokter = document.getElementById('cmbDokVisite').value;
		var userId='<?php echo $_SESSION['userId']?>';
		//alert(dokter);
	   window.open('cetakVisite.php?idKunj='+getIdKunj+'&idPel='+getIdPel+'&idPasien='+getIdPasien+'&idDokter='+dokter+'&userId='+userId,'cetak_visite');
	}
	
	function cetakLab(){
		new Popup('divSetLab',null,{modal:true,position:'center',duration:1});
		document.getElementById('divSetLab').popup.show();
		setTimeout("document.getElementById('txtLab').focus()","100");
	}

	function caraKeluar(val){
		if(val=="Dirujuk"){ /*dirujuk ke RS*/
			//document.getElementById('tabel_rs').style.visibility='visible';
			document.getElementById('trRujukRS').style.visibility='visible';
			document.getElementById('trRujukRSKet').style.visibility='visible';
			document.getElementById('cmbKeadaanKeluar').innerHTML='<option value="dirujuk">dirujuk</option>';
			document.getElementById('btnCetakKRS').style.display='table-cell';
		}
		else if(val == "Meninggal"){/*meninggal*/
			//document.getElementById('tabel_rs').style.visibility='collapse';
			document.getElementById('trRujukRS').style.visibility='collapse';
			document.getElementById('trRujukRSKet').style.visibility='collapse';
			document.getElementById('cmbKeadaanKeluar').innerHTML="<option value='Meninggal'>Meninggal</option><option value='Meninggal < 48 jam'>Meninggal < 48 jam</option><option value='Meninggal > 48 jam'>Meninggal > 48 jam</option><option value='Meninggal sebelum dirawat'>Meninggal sebelum dirawat</option>";
			document.getElementById('btnCetakKRS').style.display='none';
		}
		else if(val == "Pulang Paksa"){/*Pulang Paksa*/
			//document.getElementById('tabel_rs').style.visibility='collapse';
			document.getElementById('trRujukRS').style.visibility='collapse';
			document.getElementById('trRujukRSKet').style.visibility='collapse';
			document.getElementById('cmbKeadaanKeluar').innerHTML="<option value='Karena Biaya'>Karena Biaya</option><option value='Karena Keluarga'>Karena Keluarga</option><option value='Karena Keadaan Pasien'>Karena Keadaan Pasien</option><option value='Karena Pelayanan'>Karena Pelayanan</option>";
			document.getElementById('btnCetakKRS').style.display='none';
		}
		else{
			document.getElementById('cmbKeadaanKeluar').innerHTML='<option value="Perlu kontrol kembali">Perlu kontrol kembali</option><option value="Sembuh">Sembuh</option>';
			//document.getElementById('tabel_rs').style.visibility='collapse';
			document.getElementById('trRujukRS').style.visibility='collapse';
			document.getElementById('trRujukRSKet').style.visibility='collapse';
			document.getElementById('btnCetakKRS').style.display='none';
		}
	}

	function cetakKRS(){
		window.open('krs.php','_blank');
	}
	
	function cekRad(a){
		if(a==60){
			document.getElementById('frameRad').style.display='table-row';
		}
		else{
			document.getElementById('frameRad').style.display='none';
		}
	}

	mTab=new TabView("TabView");
	mTab.setTabCaption("DIAGNOSA,TINDAKAN,RESEP,PEMAKAIAN BHP,HASIL LAB");
	mTab.setTabCaptionWidth("180,180,180,180,180");
	mTab.setTabDisplay("true,true,true,true,false,0");
	mTab.onLoaded(showgrid);
	mTab.setTabPage("diagnosa.php,tindakan.php,resep.php,pemakaian_bhp.php,laborat_radiologi.php");
	var c,e,f,b,d,r,aResep,aDet,bhp;

	function showgrid()
	{
		//alert("tes");
		//var sisip=a1.getRowId(a1.getSelRow()).split("|");
		//alert(a1.getSelRow());
		f=new DSGridObject("gridboxTind");
		f.setHeader("DATA TINDAKAN PASIEN");
		f.setColHeader("NO,TANGGAL,TINDAKAN,KELAS,BIAYA,JUMLAH,SUBTOTAL,DOKTER,PETUGAS INPUT,KETERANGAN");
		f.setIDColHeader(",tanggal,nama,,,,,,dokter,");
		f.setColWidth("30,100,250,75,75,75,75,200,175,150");
		f.setCellAlign("center,center,left,center,right,center,right,left,left,left");
		f.setCellHeight(20);
		f.setImgPath("../icon");
		f.setIDPaging("pagingTind");
		f.attachEvent("onRowClick","ambilDataTind");
		f.attachEvent("onRowDblClick","printReport");
		f.onLoaded(konfirmasi);
		/*if (a1.){
			var sisip=a1.getRowId(a1.getSelRow()).split("|");
		}*/
		//if(sisip[0]==''){
			f.baseURL("tindiag_utils.php?grd=true&pelayanan_id=0");
		//}else{
		//	f.baseURL("tindiag_utils.php?grd=true&pelayanan_id="+sisip[1]);
		//}
		f.Init();

		b=new DSGridObject("gridbox1");
		b.setHeader("DATA DIAGNOSA PASIEN");
		b.setColHeader("NO,KODE,DIAGNOSA,DOKTER,PRIORITAS,AKHIR");
		b.setIDColHeader(",kode,nama,dokter,,");
		b.setColWidth("30,60,300,200,100,70");
		b.setCellAlign("center,center,left,left,center,center");
		b.setCellHeight(20);
		b.setImgPath("../icon");
		b.onLoaded(konfirmasi);
		b.setIDPaging("paging1");
		b.attachEvent("onRowClick","ambilDataDiag");
		//if(sisip[0]==''){
			b.baseURL("tindiag_utils.php?grd1=true&pelayanan_id=0");
		//}else{
		//    b.baseURL("tindiag_utils.php?grd1=true&pelayanan_id="+sisip[1]);
		//}
		b.Init();
		
		//resep
		r=new DSGridObject("gridboxResep");
		r.setHeader("DATA RESEP PASIEN");
		r.setColHeader("NO,NAMA OBAT,JUMLAH,RACIKAN,DOSIS,DOKTER");
		r.setIDColHeader(",OBAT_NAMA,,,,");
		r.setColWidth("30,200,50,110,180,150");
		r.setCellAlign("center,left,center,center,left,left");
		r.setCellType("txt,txt,txt,txt,txt,txt");
		r.setCellHeight(20);
		r.setImgPath("../icon");
		r.onLoaded(konfirmasi);
		r.setIDPaging("pagingResep");
		r.attachEvent("onRowClick","ambilDataResep");
		r.baseURL("tindiag_utils.php?grdResep=true&pelayanan_id=0");
		r.Init();

		//resep
		aResep=new DSGridObject("gridboxResepAwal");
		aResep.setHeader("DATA RESEP");
		aResep.setColHeader("NO,NO RESEP,TANGGAL,APOTEK,STATUS");
		aResep.setIDColHeader(",,,,");
		aResep.setColWidth("50,100,100,150,100");
		aResep.setCellAlign("center,center,center,left,center");
		aResep.setCellType("txt,txt,txt,txt,txt,chk");
		aResep.setCellHeight(20);
		aResep.setImgPath("../icon");
		aResep.onLoaded(ambilDataResepDetail);
		//aResep.setIDPaging("pagingResepAwal");
		aResep.attachEvent("onRowClick","ambilDataResepDetail");
		aResep.baseURL("tindiag_utils.php?grdRsp1=true&pelayanan_id=0");
		aResep.Init();
		
		aDet=new DSGridObject("gridboxResepDetail");
		aDet.setHeader("DATA OBAT DALAM RESEP");
		aDet.setColHeader("NO,NAMA OBAT,JUMLAH,RACIKAN,DOSIS,DOKTER,STOK,PROSES");
		aDet.setIDColHeader(",OBAT_NAMA,,,,,,");
		aDet.setColWidth("30,200,40,80,180,150,50,50");
		aDet.setCellAlign("center,left,center,center,left,left,center,center");
		aDet.setCellType("txt,txt,txt,txt,txt,txt,txt,txt");
		aDet.setCellHeight(20);
		aDet.setImgPath("../icon");
		//aDet.onLoaded(konfirmasi);
		//aDet.setIDPaging("pagingResepDetail");
		//aDet.attachEvent("onRowClick");
		aDet.baseURL("tindiag_utils.php?grdRsp2=true&pelayanan_id=0&apotek_id=0");
		aDet.Init();
		
		//resep
		
		bhp = new DSGridObject("gridbox_bhp");
		bhp.setHeader("DATA PEMAKAIAN BHP");
		bhp.setColHeader("NO,TGL,NAMA BAHAN,KEPEMILIKAN,JUMLAH,KETERANGAN");
		bhp.setIDColHeader(",TGL,OBAT_NAMA,NAMA,,KET");
		bhp.setColWidth("40,130,270,100,50,250");
		bhp.setCellAlign("center,center,left,left,center,left");
		bhp.setCellType("txt,txt,txt,txt,txt,txt");
		bhp.setCellHeight(20);
		bhp.setImgPath("../icon");
		//bhp.onLoaded(konfirmasi);
		bhp.setIDPaging("paging_bhp");
		bhp.attachEvent("onRowClick","ambil_bhp");
		bhp.baseURL("bhp_utils.php?pelayanan_id_bhp="+getIdPel);				
		bhp.Init();

		// laboratorium
		lab=new DSGridObject("gridboxHsl");
		lab.setHeader("DATA HASIL LABORATORIUM PASIEN");
		lab.setColHeader("NO,TANGGAL,TINDAKAN,HASIL,NORMAL,KETERANGAN,DOKTER");
		lab.setIDColHeader(",tanggal,nama,hasil,,ket,");
		lab.setColWidth("30,100,300,100,100,75,150");
		lab.setCellAlign("center,center,left,center,right,center,right");
		lab.setCellHeight(20);
		lab.setImgPath("../icon");
		lab.onLoaded(konfirmasi);
		lab.setIDPaging("pagingHsl");
		lab.attachEvent("onRowClick","ambilDataHsl");
		if(getIdPel==''){
			lab.baseURL("hasilLab_utils.php?grd=true&pelayanan_id=0");
		}else{
			lab.baseURL("hasilLab_utils.php?grd=true&pelayanan_id="+getIdPel);
		}
		lab.Init();	
		
		// radiologi
		rad=new DSGridObject("gridboxHslRad");
		rad.setHeader("DATA HASIL RADIOLOGI PASIEN");
		rad.setColHeader("NO,TANGGAL,HASIL,DOKTER");
		rad.setIDColHeader(",,,");
		rad.setColWidth("30,100,300,100");
		rad.setCellAlign("center,center,left,left");
		rad.setCellHeight(20);
		rad.setImgPath("../icon");
		rad.onLoaded(konfirmasi);
		rad.setIDPaging("pagingHslRad");
		rad.attachEvent("onRowClick","ambilDataHslRad");
		if(getIdPel==''){
			rad.baseURL("hasilRad_utils.php?grd=true&pelayanan_id=0");
		}else{
			rad.baseURL("hasilRad_utils.php?grd=true&pelayanan_id="+getIdPel);
		}
		rad.Init();	
		
		isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'','cmbDokTind');
		isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'','cmbDokDiag');
		isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'','cmbDokResep');
		isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'','cmbDokHsl');
		isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'','cmbDokHslRad');

		isiCombo('JnsLayanan','','1','jnsLay',isiTmpLayanan2);
		function isiTmpLayanan2(){
			isiCombo('TmpLayanan',document.getElementById('jnsLay').value,'','tmpLay');
		}
		isiCombo('cmbApotek');
	  
		Request("tindiag_utils.php?act=dok_an","dok_anastesi",'','GET');
	}
	
	function EditObat(p){
	var tmp=p.split("|");
		//alert('edit obat : '+p);
		IdResepPop=tmp[0];
		kpPop=tmp[1];
		//qtyPop=tmp[2];
		tRow=tmp[3];
		document.getElementById('trFarmasi').style.visibility="collapse";
		document.getElementById('trCaraBayar').style.visibility="collapse";
		document.getElementById('trObat').style.visibility="visible";
		document.getElementById('newObat').value="";
		new Popup('popGrPet',null,{modal:true,position:'center',duration:1});
		document.getElementById('popGrPet').popup.show();
		document.getElementById('newObat').focus();
		
		clearTimeout(fReload);
		fReload=setTimeout("AutoRefresh()", 120000);
	}

	function setUnitLagi(){
		setUnit(document.getElementById('tmpLay').value);
	}

	function showUnit(cek){
		var keywords=document.getElementById('txtTind').value;
		if(cek){
			document.getElementById('trUnit').style.visibility='visible';
			//alert("tindakanlist.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&kelasId="+getIdKelas+"&unitId="+document.getElementById('tmpLay').value);
			Request("tindakanlist.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&kelasId="+getIdKelas+"&unitId="+((document.getElementById('chkTind').checked==true)?document.getElementById('tmpLay').value:unitId)+
				"&jenisLay="+((document.getElementById('chkTind').checked==true)?document.getElementById('jnsLay').value:jenisUnitId)+"&inap="+getInap+"&pelayananId="+getIdPel, 'divtindakan', '', 'GET');
			isiCombo('cmbDok',document.getElementById('tmpLay').value,'','cmbDokTind');
		}
		else {
			document.getElementById('trUnit').style.visibility='collapse';
			//alert("tindakanlist.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&kelasId="+getIdKelas+"&unitId="+document.getElementById('cmbTmpLay').value);
			Request("tindakanlist.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&kelasId="+getIdKelas+"&unitId="+((document.getElementById('chkTind').checked==true)?document.getElementById('tmpLay').value:unitId)+
				"&jenisLay="+((document.getElementById('chkTind').checked==true)?document.getElementById('jnsLay').value:jenisUnitId)+"&inap="+getInap+"&pelayananId="+getIdPel, 'divtindakan', '', 'GET');
			isiCombo('cmbDok',unitId,'','cmbDokTind');
		}
		//document.getElementById('divtindakan').style.display='none';
	}

	function setUnit(val){
		var keywords=document.getElementById('txtTind').value;
		Request("tindakanlist.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&kelasId="+getIdKelas+"&unitId="+val, 'divtindakan', '', 'GET');
		if(document.getElementById('btnSimpanTind').value=="Simpan"){
			document.getElementById('txtTind').value='';
		}
		isiCombo('cmbDok',val,'','cmbDokTind');
	}

	var inapkah=0;
	function cekRujukInap(isinap){
		if(isinap==1){
			inapkah=1;
			document.getElementById('trKelasRujuk').style.visibility='visible';
			document.getElementById('trKamarRujuk').style.visibility='visible';
		}
		else{
			inapkah=0;
			document.getElementById('trKelasRujuk').style.visibility='collapse';
			document.getElementById('trKamarRujuk').style.visibility='collapse';
		}
	}

	function isiTmpLayanan(){
		//isiCombo('TmpLayanan',document.getElementById('JnsLayanan').value,getIdUnit,'',isiKelas);
		isiCombo('TmpLayananInapSaja',document.getElementById('JnsLayanan').value,getIdUnit,'TmpLayanan',isiKelas);
		cekRujukInap(document.getElementById('JnsLayanan').options[document.getElementById('JnsLayanan').options.selectedIndex].lang);
	}

	function isiTmpLayananKonsul(){
		isiCombo('TmpLayananBukanInap',document.getElementById('JnsLayanan').value,getIdUnit,'TmpLayanan',isiKelas);
		cekRujukInap(document.getElementById('JnsLayanan').options[document.getElementById('JnsLayanan').options.selectedIndex].lang);
	}

	function isiTmpLayananMutasi(){
		isiCombo('TmpLayanan',document.getElementById('JnsLayananMutasi').value,getIdUnit,'TmpLayananMutasi');
	}

	function isiKelas(){
		var sisipan=c.getRowId(c.getSelRow()).split("|");
		//alert(getKsoId);
		if (getKsoId=='38' || getKsoId=='39' || getKsoId=='46'){
			isiCombo('cmbKelasKamarJamkesmas',document.getElementById('TmpLayanan').value,sisipan[5],'cmbKelasRujuk',isiKamar);
		}else{
			isiCombo('cmbKelasKamar',document.getElementById('TmpLayanan').value,sisipan[5],'cmbKelasRujuk',isiKamar);
		}
	}

	function isiKamar(){
		var sisipan=c.getRowId(c.getSelRow()).split("|");
		isiCombo('cmbKamar',document.getElementById('TmpLayanan').value+','+document.getElementById('cmbKelasRujuk').value,sisipan[6],'cmbKamarRujuk',setTarif);
	}

	function setTarif(){
		document.getElementById('spanTarif').innerHTML = document.getElementById('cmbKamarRujuk').options[document.getElementById('cmbKamarRujuk').options.selectedIndex].lang;
	}

	function isiPindahKamar(){
		isiCombo('cmbKamar',document.getElementById('cmbTL').value+','+document.getElementById('cmbKelas').value,'','cmbKamar',setTarifPindah);
	}
	
	function isiPindahKamar_ifinap(){
	    isiCombo('cmbKamar',document.getElementById('cmbTmpLay').value+','+document.getElementById('cmbKelas_ifinap').value,'','cmbKamar_ifinap',setTarifIfInap);
	}
	
	function setTarifIfInap(){
	    document.getElementById('spanTarifPindah_ifinap').innerHTML = document.getElementById('cmbKamar_ifinap').options[document.getElementById('cmbKamar_ifinap').options.selectedIndex].lang;
	}

	function setTarifPindah(){
		document.getElementById('spanTarifPindah').innerHTML = document.getElementById('cmbKamar').options[document.getElementById('cmbKamar').options.selectedIndex].lang;
	}

	function isiKelasKamar(unit){
		if (getKsoId=='38' || getKsoId=='39' || getKsoId=='46'){
			isiCombo('cmbKelasKamarJamkesmas',unit,'','cmbKelas',isiPindahKamar);
		}else{
			isiCombo('cmbKelasKamar',unit,'','cmbKelas',isiPindahKamar);
		}
	}

	function isiKelasKamar2(){
		isiKelasKamar(document.getElementById('cmbTL').value);
	}

	function isiCmbTL(){
		isiCombo('TmpLayananInapSaja',document.getElementById('cmbJL').value,'','cmbTL',isiKelasKamar2);
	}

	//Tindakan
	var RowIdx1;
	var fKeyEnt1;
	function suggest1(e,par){
		var keywords=par.value;//alert(keywords);
		if(keywords==""){
			document.getElementById('divtindakan').style.display='none';
		}else{
			var key;
			if(window.event) {
				key = window.event.keyCode;
			}
			else if(e.which) {
				key = e.which;
			}
			//alert(key);
			if (key==38 || key==40){
				var tblRow=document.getElementById('tblTindakan').rows.length;
				if (tblRow>0){
					//alert(RowIdx1);
					if (key==38 && RowIdx1>0){
						RowIdx1=RowIdx1-1;
						document.getElementById('lstTind'+(RowIdx1+1)).className='itemtableReq';
						if (RowIdx1>0) document.getElementById('lstTind'+RowIdx1).className='itemtableMOverReq';
					}
					else if (key == 40 && RowIdx1 < tblRow){
						RowIdx1=RowIdx1+1;
						if (RowIdx1>1) document.getElementById('lstTind'+(RowIdx1-1)).className='itemtableReq';
						document.getElementById('lstTind'+RowIdx1).className='itemtableMOverReq';
					}
				}
			}else if (key==13){
				//alert('masuk tindakan');
				if (RowIdx1>0){
					if (fKeyEnt1==false){
						fSetTindakan(document.getElementById('lstTind'+RowIdx1).lang);
					}
					else{
						fKeyEnt1=false;
					}
				}
			}else if (key!=27 && key!=37 && key!=39){
				RowIdx1=0;
				fKeyEnt1=false;
				var all=0;
				if(key==123){
					all=1;
				}
				//alert("tindakanlist.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&kelasId="+getIdKelas+"&unitId="+((document.getElementById('chkTind').checked==true)?document.getElementById('tmpLay').value:unitId));
				//alert(getIdKelas);
				Request("tindakanlist.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&kelasId="+getIdKelas+"&unitId="+((document.getElementById('chkTind').checked==true)?document.getElementById('tmpLay').value:unitId)+
					"&jenisLay="+((document.getElementById('chkTind').checked==true)?document.getElementById('jnsLay').value:jenisUnitId)+"&inap="+getInap+"&pelayananId="+getIdPel+"&allKelas="+all, 'divtindakan', '', 'GET');
				if (document.getElementById('divtindakan').style.display=='none')
					fSetPosisi(document.getElementById('divtindakan'),par);
				document.getElementById('divtindakan').style.display='block';
			}
		}
	}

	function fSetTindakan(par){
		var cdata=par.split("*|*");
		document.getElementById("tindakan_id").value=cdata[0];
		document.getElementById("mtId").value=cdata[4];
		document.getElementById("txtTind").value=cdata[1];
		document.getElementById("txtBiaya").value=cdata[3];
		document.getElementById("txtBiayaAskes").value=cdata[6];
		document.getElementById("tdKelas").innerHTML=cdata[5];
		document.getElementById('divtindakan').style.display='none';
		if(document.getElementById('txtQty').value==''){
			document.getElementById('txtQty').value='1';
		}
		
		if (cdata[4]=="750"){
			document.getElementById('cmbDokTind').value="584";
		}else if (cdata[4]=="742" || cdata[4]=="746" || cdata[4]=="747" || cdata[4]=="748"){
			document.getElementById('cmbDokTind').value="612";
		}else if (cdata[4]=="743" || cdata[4]=="744"){
			document.getElementById('cmbDokTind').value="581";
		}
		
		document.getElementById('cmbDokTind').focus();
	}
		
	//Diagnosa
	var RowIdx;
	var fKeyEnt;
	function suggest(e,par){
		var keywords=par.value;//alert(keywords);
		if(e == 'cariDiag'){
			if(document.getElementById('divdiagnosa').style.display == 'block'){
				document.getElementById('divdiagnosa').style.display='none';
			}
			else{
				if(document.getElementById('chkPenyebabKecelakaan').checked==true){
					Request('diagnosalist.php?findAll=true&aKeyword='+keywords+'&unitId='+unitId+'&PK=1' , 'divdiagnosa', '', 'GET' );	
				}
				else{
					Request('diagnosalist.php?findAll=true&aKeyword='+keywords+'&unitId='+unitId+'&PK=0' , 'divdiagnosa', '', 'GET' );
				}
				if (document.getElementById('divdiagnosa').style.display=='none') fSetPosisi(document.getElementById('divdiagnosa'),par);
				document.getElementById('divdiagnosa').style.display='block';
			}
		}
		else{
			if(keywords==""){
				document.getElementById('divdiagnosa').style.display='none';
			}else{
				var key;
				if(window.event) {
					key = window.event.keyCode;
				}
				else if(e.which) {
					key = e.which;
				}
				//alert(key);
				if (key==38 || key==40){
					var tblRow=document.getElementById('tblDiagnosa').rows.length;
					if (tblRow>0){
						//alert(RowIdx);
						if (key==38 && RowIdx>0){
							RowIdx=RowIdx-1;
							document.getElementById('lstDiag'+(RowIdx+1)).className='itemtableReq';
							if (RowIdx>0) document.getElementById('lstDiag'+RowIdx).className='itemtableMOverReq';
						}else if (key == 40 && RowIdx < tblRow){
							RowIdx=RowIdx+1;
							if (RowIdx>1) document.getElementById('lstDiag'+(RowIdx-1)).className='itemtableReq';
							document.getElementById('lstDiag'+RowIdx).className='itemtableMOverReq';
						}
					}
				}
				else if (key==13){
					if (RowIdx>0){
						if (fKeyEnt==false){
							fSetPenyakit(document.getElementById('lstDiag'+RowIdx).lang);
						}else{
							fKeyEnt=false;
						}
					}
				}
				else if (key!=27 && key!=37 && key!=39){
					RowIdx=0;
					fKeyEnt=false;
					if(document.getElementById('chkPenyebabKecelakaan').checked==true){
						Request('diagnosalist.php?aKeyword='+keywords+'&unitId='+unitId+'&PK=1', 'divdiagnosa', '', 'GET' );
					}
					else{
						Request('diagnosalist.php?aKeyword='+keywords+'&unitId='+unitId+'&PK=0', 'divdiagnosa', '', 'GET' );
					}
					if (document.getElementById('divdiagnosa').style.display=='none') fSetPosisi(document.getElementById('divdiagnosa'),par);
					document.getElementById('divdiagnosa').style.display='block';
				}
			}
		}
	}

	function fSetPenyakit(par){
		var cdata=par.split("*|*");
		document.getElementById("diagnosa_id").value=cdata[0];
		document.getElementById("txtDiag").value=cdata[1]+" - "+cdata[2];
		document.getElementById('divdiagnosa').style.display='none';
		
		//penyebab kecelakaan
		if(document.getElementById('chkPenyebabKecelakaan').checked){
			Request('../combo_utils.php?id=PenyebabKecelakaan&value='+cdata[2],'cmbPenyebab','','GET');
			document.getElementById('trPenyebab').style.display = 'table-row';
		}
		else{
			document.getElementById('trPenyebab').style.display = 'none';
		}
		
		document.getElementById('cmbDokDiag').focus();
	}

	//Obat Resep
	var RowIdxObat;
	var fKeyEntObat;
	function suggestObat(e,par){
		var keywords=par.value;
		if(keywords==""){
			document.getElementById('divobat').style.display='none';
		}
		else{
			if(par.value.length > 1){
				var key;
				if(window.event) {
					key = window.event.keyCode;
				}
				else if(e.which) {
					key = e.which;
				}
				//alert(key);
				if (key==38 || key==40){
					var tblRow=document.getElementById('tblObat').rows.length;
					if (tblRow>0){
						//alert(RowIdx);
						if (key==38 && RowIdxObat>0){
							RowIdxObat=RowIdxObat-1;
							document.getElementById(RowIdxObat+1).className='itemtableReq';
							if (RowIdxObat>0) document.getElementById(RowIdxObat).className='itemtableMOverReq';
						}
						else if (key == 40 && RowIdxObat < tblRow){
							RowIdxObat=RowIdxObat+1;
							if (RowIdxObat>1) document.getElementById(RowIdxObat-1).className='itemtableReq';
							document.getElementById(RowIdxObat).className='itemtableMOverReq';
						}
					}
				}
				else if (key==13){
					if (RowIdxObat>0){
						if (fKeyEntObat==false){
							fSetObat(document.getElementById(RowIdxObat).lang);
						}
						else{
							fKeyEntObat=false;
						}
					}
				}
				else if (key!=27 && key!=37 && key!=39){
					fKeyEntObat=false;
					if (key==123){
						/*RowIdxObat=0;
						Request('obatlist.php?aKepemilikan=0&aHarga='+getKepemilikan+'&idapotek='+document.getElementById('cmbApotek').value+'&aKeyword='+keywords, 'divobat', '', 'GET' );*/
					}
					else if (key==120){
						//alert(RowIdxObat);
					}
					else{
						RowIdxObat=0;
						Request('obatlist.php?aKepemilikan='+getKepemilikan+'&aHarga='+getKepemilikan+'&idapotek='+document.getElementById('cmbApotek').value+'&aKeyword='+keywords, 'divobat', '', 'GET' );
					}
					if (document.getElementById('divobat').style.display=='none')
						document.getElementById('divobat').style.top='135px';
						//fSetPosisi(document.getElementById('divobat'),par);
					document.getElementById('divobat').style.display='block';
				}
			}
		}
	}
	
	function suggestObat2(e,par){
	var keywords=par.value;//alert(keywords);
	var i=1;
		//alert(par.offsetLeft);
		if(keywords.length<2){
			document.getElementById('divobat_edit').style.display='none';
		}else{
			var key;
			if(window.event) {
			  key = window.event.keyCode; 
			}
			else if(e.which) {
			  key = e.which;
			}
			//alert(key);
			if (key==38 || key==40){
				var tblRow=document.getElementById('tblObat').rows.length;
				if (tblRow>0){
					//alert(RowIdx);
					if (key==38 && RowIdx>0){
						RowIdx=RowIdx-1;
						document.getElementById(RowIdx+1).className='itemtableReq';
						if (RowIdx>0) document.getElementById(RowIdx).className='itemtableMOverReq';
					}else if (key==40 && RowIdx<tblRow){
						RowIdx=RowIdx+1;
						if (RowIdx>1) document.getElementById(RowIdx-1).className='itemtableReq';
						document.getElementById(RowIdx).className='itemtableMOverReq';
					}
				}
			}else if (key==13){
				if (RowIdx>0){
					if (fKeyEnt==false){
						fSetObat2(document.getElementById(RowIdx).lang);
					}else{
						fKeyEnt=false;
					}
				}
			}else if (key!=27 && key!=37 && key!=39 && key!=9){
				fKeyEnt=false;
				if (key==123){
					RowIdx=0;
					//alert('obatlist2.php?aKepemilikan=0&aHarga='+getKepemilikan+'&idapotek='+document.getElementById('cmbApotek').value+'&aKeyword='+keywords+'&no='+i);
					Request('obatlist2.php?aKepemilikan=0&aHarga='+getKepemilikan+'&idapotek='+document.getElementById('cmbApotek').value+'&aKeyword='+keywords+'&no='+i , 'divobat_edit', '', 'GET' );
				}else if (key==120){
					alert(RowIdx);
				}else{
					RowIdx=0;
					//alert('obatlist2.php?aKepemilikan='+getKepemilikan+'&aHarga='+getKepemilikan+'&idapotek='+document.getElementById('cmbApotek').value+'&aKeyword='+keywords+'&no='+i);
					Request('obatlist2.php?aKepemilikan='+getKepemilikan+'&aHarga='+getKepemilikan+'&idapotek='+document.getElementById('cmbApotek').value+'&aKeyword='+keywords+'&no='+i , 'divobat_edit', '', 'GET' );
				}
				if (document.getElementById('divobat_edit').style.display=='none'){
					//fSetPosisi(document.getElementById('divobat'),par);
					document.getElementById('divobat_edit').style.left="135px";
					document.getElementById('divobat_edit').style.top="55px";
				}
				document.getElementById('divobat_edit').style.display='block';
			}
		}
		
	}

	
	//resep
	function fSetObat(par){
		var cdata=par.split("*|*");
		document.getElementById("idObat").value = cdata[1];
		document.getElementById("txtNmObat").value = cdata[2];
		document.getElementById("hargajual").value = cdata[4];
		document.getElementById("hargabeli").value = cdata[7];
		//document.getElementById("txtStok").value = cdata[5];
		document.getElementById('divobat').style.display='none';
		document.getElementById('txtJml').focus();
	}
	
	function fSetObat2(par){
		var tpar=par;
		var cdata;
		while (tpar.indexOf(String.fromCharCode(5))>0){
			tpar=tpar.replace(String.fromCharCode(5),"'");
		}
		while (tpar.indexOf(String.fromCharCode(3))>0){
			tpar=tpar.replace(String.fromCharCode(3),'"');
		}
		cdata=tpar.split("*|*");
		tObat=cdata[1];
		tKpid=cdata[7];
		tHNetto=cdata[9];
		tHJual=cdata[4];
		tQtyStok=cdata[5];
		//tQty=qtyPop;
		document.getElementById('divobat_edit').style.display='none';
		document.getElementById('newObat').value=cdata[2];
	}
	
	function SimpanNewObat(){
		var tmp,no_resep,act,fdata;
		tmp = r.getRowId(r.getSelRow()).split('|');
		no_resep = tmp[2];
		if (document.getElementById('trObat').style.visibility=="visible"){
			if (confirm('Yakin Ingin Mengubah Resep ?')){
				//rDet.loadURL(url,"","GET");
				var cid=aDet.getRowId(tRow).split("|");
				var newId=cid[0]+"|"+tHJual+"|"+tHNetto+"|"+cid[3]+"|"+tKpid+"|"+tObat+"|"+cid[6];
				var stot=cid[3]*tHJual;
				
				aDet.cellsSetValue(tRow,2,document.getElementById('newObat').value);
				aDet.cellsSetValue(tRow,7,tQtyStok);
				aDet.setRowId(tRow,newId);
				HitungTot();
				document.getElementById('popGrPet').popup.hide();
			}
		}else if (document.getElementById('trFarmasi').style.visibility=="visible"){
			act="act=kirimUnit&idunitRujuk="+document.getElementById('IdFarmasiRujuk').value+"&no_rm="+tmp[3]+"&IdPel="+tmp[4];
			url="../transaksi/utils.php?"+act+"&grd=true&no_resep="+no_resep+"&status="+document.getElementById('cmbDilayani').value+"&idunit=<?php echo $idunit; ?>&iduser=<?php echo $iduser; ?>&tanggal="+document.getElementById('txtTgl').value;
			if (confirm('Yakin Ingin Mengirim Resep ke Unit Lain ?')){
				r.loadURL(url,"","GET");
				document.getElementById('popGrPet').popup.hide();
			}
		}else{
			act="act=UbahCaraBayar&newIdCarabayar="+document.getElementById('IdCaraBayar').value+"&no_rm="+tmp[3]+"&IdPel="+tmp[4];
			url="../transaksi/utils.php?"+act+"&grd=true&no_resep="+no_resep+"&status="+document.getElementById('cmbDilayani').value+"&idunit=<?php echo $idunit; ?>&iduser=<?php echo $iduser; ?>&tanggal="+document.getElementById('txtTgl').value;
			if (confirm('Yakin Ingin Mengubah Cara Bayar Pasien ?')){
				r.loadURL(url,"","GET");
				document.getElementById('popGrPet').popup.hide();
			}
		}
		
		clearTimeout(fReload);
		fReload=setTimeout("AutoRefresh()", 120000);
	}
	
	function CheckedObat(k){
		//alert(aDet.obj.childNodes[0].childNodes[k-1].childNodes[5].childNodes[0].checked);
		if (aDet.obj.childNodes[0].childNodes[k-1].childNodes[7].childNodes[0].checked){
			if (parseFloat(aDet.obj.childNodes[0].childNodes[k-1].childNodes[6].innerHTML) < parseFloat(aDet.obj.childNodes[0].childNodes[k-1].childNodes[2].innerHTML)){
				alert("Stok Obat Yang Mau Dibeli Tdk Mencukupi !");
				aDet.obj.childNodes[0].childNodes[k-1].childNodes[7].childNodes[0].checked=false;
				return false;
			}else if (parseFloat(aDet.obj.childNodes[0].childNodes[k-1].childNodes[2].childNodes[0].innerHTML)==0){
				alert("Jumlah Obat Yang Mau Dibeli Tdk Boleh 0 !");
				aDet.obj.childNodes[0].childNodes[k-1].childNodes[7].childNodes[0].checked=false;
				return false;
			}
		}
		
		HitungTotObat();	
	}
	
	function ValidasiText(p){
	var tmp=p;
		while (tmp.indexOf('.')>-1){
			tmp=tmp.replace('.','');
		}
		while (tmp.indexOf(',')>-1){
			tmp=tmp.replace(',','.');
		}
		return tmp;
	}
	
	function HitungTotObat(){
		var tmp=0;
		var sisip;
		document.getElementById('tot_harga').value="0";
		for (var k=0;k<aDet.getMaxRow();k++){
			if (aDet.obj.childNodes[0].childNodes[k].childNodes[7]){
				if (aDet.obj.childNodes[0].childNodes[k].childNodes[7].childNodes[0].checked){
					sisip=aDet.getRowId(k+1).split('|');
					tmp=tmp+parseFloat(ValidasiText(sisip[7]));
				}
			}
		}
		document.getElementById('tot_harga').value=tmp;
	}
	
	function saveResep(){
		var tmp,url;
		
		tmp="";
		for (var k=0;k<aDet.getMaxRow();k++){
			if (aDet.obj.childNodes[0].childNodes[k].childNodes[7].childNodes[0].checked && aDet.obj.childNodes[0].childNodes[k].childNodes[7].childNodes[0].disabled==false){
				tmp+=aDet.getRowId(k+1)+"*|*";
			}
		}

		if (tmp==""){
			alert("Pilih Item Obat Yang Mau Dibeli !");
			document.getElementById('btnSimpan').disabled=false;
			return false;
		}else{
			tmp=tmp.substr(0,tmp.length-3);
		}
		
		url='tindiag_utils.php?grdRsp2=true&pelayanan_id='+getIdPel+'&apotek_id='+document.getElementById('cmbApotek').value+'&tgl_resep='+document.getElementById('tglResep').value+'&smpn=btnSimpanResepObat&act=tambah&idPel='+getIdPel+'&no_rm='+getNoPasien+'&no_resep='+document.getElementById('noResep').value+'&subtotal='+document.getElementById('tot_harga').value+'&fdata='+tmp+"&idunit="+getIdUnit+"&iduser=<?php echo $_SESSION['userId']; ?>&shift=0&tanggal="+document.getElementById('tglResep').value;
		//alert(url);

		if (confirm('Apakah Data Sudah Benar?')){
			aDet.loadURL(url,'','GET');
		}else{
			
		}
		
	}

	function smp(ev)
	{
	       if(ev.which==13)
	       simpan(document.getElementById('txtLab').value,'btnSimpanLab','txtLab');
	}
	
	var eksyennya = '';
	function simpan(action,id,cek)
	{
		//alert(action+'-'+id);
		//if(ValidateForm("tindakan_id,txtBiaya,txtQty",'ind'))
		//{
		var userId='<?php echo $_SESSION['userId']?>';
		var idTind = document.getElementById("tindakan_id").value;
		var tind = document.getElementById("txtTind").value;
		var biaya = document.getElementById("txtBiaya").value;
		var biayaAskes = document.getElementById("txtBiayaAskes").value;
		var qty = document.getElementById("txtQty").value;
		var ket = document.getElementById("txtKet").value;
		var idBaru = document.getElementById("id_tind").value;
		var idDok = document.getElementById("cmbDokTind").value;
		var idDokDiag = document.getElementById("cmbDokDiag").value;
		var isDokPengganti = 0;

		var jnsLayRujukUnit = document.getElementById("JnsLayanan").value;
		var tmpLayRujukUnit = document.getElementById("TmpLayanan").value;
		var ketRujukUnit = document.getElementById("txtKetRujuk").value;
		var idDokRujukUnit = document.getElementById("cmbDokRujukUnit").value;
		var idRujukUnit = document.getElementById("idRujukUnit").value;
		var idKelasRujukUnit = getIdKelas; //kelas diambil dari kunjungan
		var idKamarRujukUnit = '';
		if(inapkah==1){
			var idKelasRujukUnit = document.getElementById("cmbKelasRujuk").value;
			var idKamarRujukUnit = document.getElementById("cmbKamarRujuk").value;
		}

		//var jnsLayRujukRS=document.getElementById("JnsLayananRS").value;
		//var tmpLayRujukRS=document.getElementById("TmpLayananRS").value;
		var idRS = document.getElementById("cmbRS").value;
		var ketRujukRS = document.getElementById("txtKetRujukRS").value;
		var idDokRujukRS = document.getElementById("cmbDokRujukRS").value;
		var idRujukRS = document.getElementById("idRujukRS").value;
		var caraKeluar = document.getElementById("cmbCaraKeluar").value;
		var keadaanKeluar = document.getElementById("cmbKeadaanKeluar").value;
		var kasus = document.getElementById("cmbKasus").value;
		var emergency = document.getElementById("cmbEmergency").value;
		var kondisiPasien = document.getElementById("cmbKondisiPasien").value;

		var tmpLayKamar = document.getElementById("cmbTL").value;
		var jnsLayKamar = document.getElementById("cmbJL").value;
		var idSetKamar = document.getElementById("idSetKamar").value;
		var idKelas = document.getElementById("cmbKelas").value;
		var idKamar = document.getElementById("cmbKamar").value;
		var tglMasuk = document.getElementById("TglMasuk").value;
		var jamMasuk = document.getElementById("JamMasuk").value.replace(' ','');
		var jamKrs = document.getElementById("JamKrs").value.replace(' ','');
		var isManual = document.getElementById('chkManual').checked;

		var idDiag = document.getElementById("id_diag").value;
		var diag = document.getElementById("txtDiag").value;
		var diag_id = document.getElementById("diagnosa_id").value;
		if(document.getElementById('chkPenyebabKecelakaan').checked){
			diag_id = document.getElementById('cmbPenyebab').value;
		}
		//alert(diag_id);
		var isPrimer = document.getElementById("cmbUtama").value;
		var isAkhir = 0;
		if(document.getElementById('chkAkhir').checked){
			isAkhir = 1;
		}
		/*var isPrimer = 1;
		if(document.getElementById("chkUtama").checked == false){
			isPrimer = 0;
		}*/
		var tglKrs = document.getElementById('TglKrs').value;

		var idResep = document.getElementById("idResep").value;
		var namaobat = document.getElementById("txtNmObat").value;
		var stok = document.getElementById("txtStok").value;
		var jumlah = document.getElementById("txtJml").value;
		var satRacikan = document.getElementById("satuanRacikan").value;
		var cnoRacikan = document.getElementById("noRacikan").value;
		var dokter = document.getElementById("cmbDokResep").value;
		var apotek = document.getElementById("cmbApotek").value;
		var idObat = document.getElementById("idObat").value;
		var netto = document.getElementById("hargajual").value;
		var satuan = document.getElementById("hargabeli").value;
		var inap = document.getElementById('cmbTmpLay').options[document.getElementById('cmbTmpLay').options.selectedIndex].lang;
		var cTglNow="<?php echo $pTglSkrg; ?>";
		var racikan = "0";
		var jmlBahan = "0";
		
		if(document.getElementById("chRacikan").checked == true){
			racikan = cnoRacikan;
			jmlBahan = document.getElementById("txtJmlBahan").value;
		}
		var url;
		
		switch(id){
			case 'btnSimpanHslRad':
				var id = document.getElementById("id_hasil_rad").value;
				var txtHslRad = document.getElementById("txtHslRad").value;
				var cmbDokHsl = document.getElementById("cmbDokHslRad").value;
				
				//if(document.getElementById('frameRad').contentWindow.file_upload==''){
				 //alert('belum lengkap');
				//}
				//file_upload
				tambahRadiologi = true;
				document.getElementById('frameRad').contentWindow.aplod(action,id,getIdPel,txtHslRad,cmbDokHsl,userId);
				
				/*
				if (action=="Simpan"){
					var cTglTind=rad.cellsGetValue(rad.getSelRow(),2);
					cTglTind=cTglTind.split(" ");
					cTglTind=cTglTind[0].split("-");
					cTglTind=cTglTind[2]+"-"+cTglTind[1]+"-"+cTglTind[0];	
				}
				
				
				if(ValidateForm("txtTind_hsl",'ind')){
					var url = "hasilRad_utils.php?grd=true&act="+action+"&smpn="+id+"&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj
					+"&idTind="+tindakan_id_hsl+"&id="+idTindHsl+"&user_act="+cmbDokHsl+"&ket="+txtKetHsl+"&hasil="+txtHsl+"&normal="+normal;
					//alert(url);
					rad.loadURL(url,"","GET");
					batalHsl();
				}
				*/
			break;
			case 'btnSimpanHsl':
				var idTindHsl = document.getElementById("idTindHsl").value;
				var tindakan_id_hsl = document.getElementById("tindakan_id_hsl").value;
				var txtHsl = document.getElementById("txtHsl").value;
				var txtKetHsl = document.getElementById("txtKetHsl").value;
				var cmbDokHsl = document.getElementById("cmbDokHsl").value;
				var normal = document.getElementById("idNormal").value;
				if (action=="Simpan"){
					var cTglTind=lab.cellsGetValue(lab.getSelRow(),2);
					cTglTind=cTglTind.split(" ");
					cTglTind=cTglTind[0].split("-");
					cTglTind=cTglTind[2]+"-"+cTglTind[1]+"-"+cTglTind[0];
					
				}
				
				if(ValidateForm("txtTind_hsl",'ind')){
					url = "hasilLab_utils.php?grd=true&act="+action+"&smpn="+id+"&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj
					+"&idTind="+tindakan_id_hsl+"&id="+idTindHsl+"&user_act="+cmbDokHsl+"&ket="+txtKetHsl+"&hasil="+txtHsl+"&normal="+normal;
					//alert(url);
					lab.loadURL(url,"","GET");
					batalHsl();
				}
			break;
			case 'btnSimpanTind':
				
				if (action=="Simpan"){
					var cTglTind=f.cellsGetValue(f.getSelRow(),2);
					cTglTind=cTglTind.split(" ");
					cTglTind=cTglTind[0].split("-");
					cTglTind=cTglTind[2]+"-"+cTglTind[1]+"-"+cTglTind[0];
					/*if (cTglNow>cTglTind){
						alert("Data Tindakan Yang Dientry Sudah Lebih Dari 24 Jam, Jadi Tidak Boleh DiUbah !");
						batal("btnBatalTind");
						return false;
					}*/
				}
				if(ValidateForm("tindakan_id,txtBiaya,txtQty",'ind')){
					var dok_an = '';
					if(cmbTmpLay == 6 || cmbTmpLay == 7 || cmbTmpLay == 13 || cmbTmpLay == 18 || cmbTmpLay == 47 || cmbTmpLay == 63){
						if(document.form_an.chk_an){
							if(document.form_an.chk_an.length){
							   for(var i=0; i<document.form_an.chk_an.length; i++){
								  if(document.form_an.chk_an[i].checked == true){
									 dok_an += document.form_an.hid_id_an[i].value+',';
								  }
							   }
							}
							else{
							   dok_an = document.getElementById('hid_id_an').value;
							}
						}
						dok_an = dok_an.substring(0,dok_an.length-1);
					}
					if(document.getElementById("chkDokterPenggantiTind").checked == true){
						isDokPengganti = 1;
					}
					document.getElementById(id).disabled = true;
					
					if(document.getElementById('chkTind').checked){
						url = "tindiag_utils.php?grd=true&act="+action+"&smpn="+id+"&id="+idBaru+"&inap="+inap+"&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj+"&kunjungan_kelas_id="+getIdKelasKunj+"&kelas_id="+getKelas_id+"&idTind="+idTind+"&tind="+tind+"&biaya="+biaya+"&biayaAskes="+biayaAskes+"&qty="+qty+"&ket="+ket+"&idDok="+idDok+"&isDokPengganti="+isDokPengganti+"&unitId="+document.getElementById('tmpLay').value+"&unit_pelaksana="+getIdUnit+"&ksoId="+getKsoId+"&ksoKelasId="+getKsoKelasId+"&userId="+userId+"&anastesi="+dok_an;
					}
					else {
						url = "tindiag_utils.php?grd=true&act="+action+"&smpn="+id+"&id="+idBaru+"&inap="+inap+"&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj+"&kunjungan_kelas_id="+getIdKelasKunj+"&kelas_id="+getKelas_id+"&idTind="+idTind+"&tind="+tind+"&biaya="+biaya+"&biayaAskes="+biayaAskes+"&qty="+qty+"&ket="+ket+"&idDok="+idDok+"&isDokPengganti="+isDokPengganti+"&unitId="+unitId+"&ksoId="+getKsoId+"&ksoKelasId="+getKsoKelasId+"&userId="+userId+"&unit_pelaksana="+getIdUnit+"&anastesi="+dok_an;
					}
					//alert(url);
					f.loadURL(url,"","GET");
					//batal('btnBatalTind');
				}
				break;

			case 'btnSimpanDiag':
				if(ValidateForm("diagnosa_id",'ind')){
					if(document.getElementById("chkDokterPenggantiDiag").checked == true){
						isDokPengganti = 1;
					}
					document.getElementById(id).disabled = true;
					url = "tindiag_utils.php?grd1=true&act="+action+"&smpn="+id+"&id="+idDiag+"&pasienId="+getIdPasien+"&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj+"&idDiag="+diag_id+"&diagnosa="+diag+"&idDok="+idDokDiag+"&isDokPengganti="+isDokPengganti+"&userId="+userId+"&isPrimer="+isPrimer+"&isAkhir="+isAkhir;
					//alert(url);
					b.loadURL(url,"","GET");
					document.getElementById("txtDiag").value = '';
					//batal('btnBatalDiag');
				}

				break;

			case 'btnSimpanLab':
				var noLab = document.getElementById('txtLab').value;
				if(ValidateForm("txtLab",'ind')){
					//document.getElementById(id).disabled = true;
					//alert("noLab.php?pelayanan_id="+getIdPel+"&noLab="+noLab);
					Request("noLab.php?pelayanan_id="+getIdPel+"&noLab="+noLab,'divDlm', '', 'GET', tutupLab);
					//document.getElementById('nomorLab').value = action;
				}
				break;
			
			case 'btnSimpanResep':	//simpan resep
				if(ValidateForm("idObat,txtNmObat,txtJml",'ind')){
					if(document.getElementById("chkDokterPenggantiResep").checked == true){
						isDokPengganti = 1;
					}
					document.getElementById(id).disabled = true;
					url = "tindiag_utils.php?grdResep=true&act="+action+"&unit_id="+document.getElementById('cmbTmpLay').value+"&smpn="+id+"&id="+idResep+"&idObat="+idObat+"&noResep="+document.getElementById('noResep').value+"&pelayanan_id="+getIdPel+"&idPas="+getIdPasien+"&ksoId="+getKsoId+"&kunjungan_id="+getIdKunj+"&apotek="+apotek+"&nama="+namaobat+"&stok="+stok+"&jumlah="+jumlah+"&txtDosis="+document.getElementById('txtDosis').value+"&dokter="+dokter+"&isracikan="+racikan+"&jmlBahan="+jmlBahan+"&satRacikan="+satRacikan+"&tgl_resep="+tgl_resep+"&isDokPengganti="+isDokPengganti+"&resep_baru="+resep_baru;
					//alert(url);
					r.loadURL(url,"","GET");
				}
				//document.getElementById('cmbApotek').value = "";
				document.getElementById('txtNmObat').value = "";
				document.getElementById('txtDosis').value = "";
				if (document.getElementById('chRacikan').checked==false){
					document.getElementById('txtJml').value = "";
					//document.getElementById('cmbDokResep').value = "";
					//document.getElementById('chRacikan').checked = false;
				}
				break;

			case 'btnSimpanRujukUnit':
				var tmp = document.getElementById('cmbKamarRujuk').options[document.getElementById('cmbKamarRujuk').options.selectedIndex].lang;
				if(document.getElementById("chkDokterPenggantiRujukUnit").checked == true){
					isDokPengganti = 1;
				}
				if(document.getElementById('lgnJudul').innerHTML=='MRS'){
					if(c.getRowId(c.getSelRow())!=''){
						alert("Satu pasien hanya bisa di-MRS-kan satu kali.");
						return false;
					}
					if ((idKamarRujukUnit=="") || (idKamarRujukUnit=="0") || (idKamarRujukUnit==undefined)){
						alert("Pilih Kamar Terlebih Dahulu !");
						return false;
					}else if ((jnsLayRujukUnit=="") || (jnsLayRujukUnit=="0") || (jnsLayRujukUnit==undefined) || (tmpLayRujukUnit=="0") || (tmpLayRujukUnit=="0") || (tmpLayRujukUnit==undefined)){
						alert("Pilih Unit Tujuan MRS Dengan Benar !");
						return false;
					}else{
						document.getElementById(id).disabled = true;
						url = "tindiag_utils.php?grd2=true&isInap=1&act="+action+"&smpn="+id+"&id="+idRujukUnit+"&tarip="+tmp+"&pasienId="+getIdPasien+"&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj+"&ket="+ketRujukUnit+"&idDok="+idDokRujukUnit+"&ksoId="+getKsoId+"&jnsLay="+jnsLayRujukUnit+"&tmpLay="+tmpLayRujukUnit+"&unitAsal="+getIdUnit+"&kelas="+idKelasRujukUnit+"&kamar="+idKamarRujukUnit+"&tarip="+tmp+"&userId="+userId+"&isDokPengganti="+isDokPengganti;
						//alert(url);
						c.loadURL(url,"","GET");
					}
				}
				else{
					if(document.getElementById('cmbTmpLay').value == tmpLayRujukUnit){
						alert("Anda tidak dapat merujuk pasien ke unit anda sendiri.");
						return false;
					}
					if ((jnsLayRujukUnit=="") || (jnsLayRujukUnit=="0") || (jnsLayRujukUnit==undefined) || (tmpLayRujukUnit=="0") || (tmpLayRujukUnit=="0") || (tmpLayRujukUnit==undefined)){
						alert("Pilih Unit Tujuan Konsul Dengan Benar !");
						return false;
					}
					document.getElementById(id).disabled = true;
					url = "tindiag_utils.php?grd2=true&isInap=0&act="+action+"&smpn="+id+"&id="+idRujukUnit+"&kunjungan_kelas_id="+getIdKelasKunj+"&kelas_id="+getKelas_id+"&pasienId="+getIdPasien+"&pelayanan_id="+getIdPel+"&kunjungan_id="+getIdKunj+"&ket="+ketRujukUnit+"&idDok="+idDokRujukUnit+"&jnsLay="+jnsLayRujukUnit+"&tmpLay="+tmpLayRujukUnit+"&unitAsal="+getIdUnit+"&unit_pelaksana="+getIdUnit+"&kelas="+idKelasRujukUnit+"&ksoId="+getKsoId+"&ksoKelasId="+getKsoKelasId+"&userId="+userId+"&isDokPengganti="+isDokPengganti;
					//alert(url);
					c.loadURL(url,"","GET");
				}
				var p="idRujukUnit*-**|*txtKetRujuk*-*";
				fSetValue(window,p);
				break;
			case 'btnSimpanRujukRS':
				if(d.getRowId(d.getSelRow())!=''){
					alert("Satu pasien hanya bisa di-KRS-kan satu kali.");
					return false;
				}
				if(document.getElementById('trRujukRS').style.visibility!='visible'){
					idRS=0;
				}
				if(ValidateForm("JamKrs",'ind')){
					document.getElementById(id).disabled = true;
					var jamSplit=jamKrs.split(':');
					if(jamSplit.length!=2){
						alert('Format Jam Salah!');
						return false;
					}
					if(isNaN(jamSplit[0]) || isNaN(jamSplit[1]) || jamSplit[0]=='' || jamSplit[1]==''  || jamSplit[0].length!=2 || jamSplit[1].length!=2){
						alert('Format Jam Salah!');
						return false;
					}
					jamMasuk=jamMasuk+':'+time[2];
					getIdKelas=idKelas;
					url = "tindiag_utils.php?grd3=true&act="+action+"&smpn="+id+"&id="+idRujukRS+"&kunjungan_id="+getIdKunj+"&pelayanan_id="+getIdPel+"&isManual="+document.getElementById('chkManualKrs').checked+"&tglKrs="+tglKrs+"&jamKrs="+jamKrs+"&caraKeluar="+caraKeluar+"&keadaanKeluar="+keadaanKeluar+"&kasus="+kasus+"&emergency="+emergency+"&kondisi="+kondisiPasien+"&ket="+ketRujukRS+"&idDok="+idDokRujukRS+"&idRS="+idRS+"&userId="+userId;
					//alert(url);
					d.loadURL(url,"","GET");
					fSetValue(window,'btnHapusRujukRS*-*true');
				}
				break;
			case 'btnSimpanKamar':
				/*if(e.getRowId(e.getSelRow())!=''){
					alert("Satu pasien hanya bisa dipindahkamarkan satu kali.");
					return false;
				}*/
		
				var kamar = a1.getRowId(a1.getSelRow()).split("|");
				/*if(idKamar == getKamarId){
					alert("Anda tidak dapat memindahkamarkan pasien ke kamar yang sama.");
					return false;
				}*/
				if(document.getElementById('cmbKamar').value==0){
					alert('Maaf, Tidak Ada Kamar Yang Kosong !');
					return false;
				}
				var tmp = document.getElementById('cmbKamar').options[document.getElementById('cmbKamar').options.selectedIndex].lang;
				//alert(jamMasuk);
				if(ValidateForm("JamMasuk",'ind')){
					document.getElementById(id).disabled = true;
					var jamSplit=jamMasuk.split(':');
					if(jamSplit.length!=2){
						alert('Format Jam Salah!');
						return false;
					}
					if(isNaN(jamSplit[0]) || isNaN(jamSplit[1]) || jamSplit[0]=='' || jamSplit[1]==''  || jamSplit[0].length!=2 || jamSplit[1].length!=2){
						alert('Format Jam Salah!');
						return false;
					}
					jamMasuk=jamMasuk+':'+time[2];
					getIdKelas=idKelas;
					eksyennya = 'pindah kamar';
					url = "tindiag_utils.php?grd4=true&act="+action+"&ksoId="+getKsoId+"&kunjungan_id="+getIdKunj+"&smpn="+id+"&id="+idSetKamar+"&tarip="+tmp+"&pasienId="+getIdPasien+"&pelayanan_id="+getIdPel+"&kamar_id="+idKamar+"&kamar_lama="+getKamarId+"&tglMasuk="+tglMasuk+"&jamMasuk="+jamMasuk+"&isManual="+isManual+"&userId="+userId+"&unitAsal="+getIdUnit+"&tmpLayKamar="+tmpLayKamar+"&jnsLayKamar="+jnsLayKamar+"&kelasId="+idKelas+"&kelas_lama="+kamar[17]+"&unit_id="+getIdUnit;
					//alert(url);
					e.loadURL(url,"","GET");
					fSetValue(window,'btnHapusKamar*-*true');
				}
				break;
			case 'btnPasienPulang':
				if(confirm("Anda akan memulangkan pasien "+document.getElementById('txtNama').value+".\nAnda yakin?")){
					Request("tindiag_utils.php?act=tambah&smpn="+id+"&kunjungan_id="+getIdKunj+"&pelayanan_id="+getIdPel,'spanTar1','','GET',pasPul,'ok');
				}
				break;
		}
	}
	
	function pasPul(){
	    alert("Pasien "+document.getElementById('txtNama').value+" "+document.getElementById('spanTar1').innerHTML);
	    if(document.getElementById('spanTar1').innerHTML == 'Berhasil dipulangkan'){
			document.getElementById('btnBatalPulang').style.display = 'inline-table';
			document.getElementById('btnPasienPulang').style.display = 'none';
	    }
	    else{
			document.getElementById('btnBatalPulang').style.display = 'none';
			document.getElementById('btnPasienPulang').style.display = 'inline-table';
	    }
	}
        
	function tutupLab(){
	var tmpNoLab=document.getElementById('txtLab').value;
		setTimeout("document.getElementById('divDlm').innerHTML = ''","2000");
		setTimeout("document.getElementById('txtLab').value = ''","2000");
		if (document.getElementById('divDlm').innerHTML == 'Update Berhasil'){
			document.getElementById('nomorLab').value = tmpNoLab;
			setTimeout("document.getElementById('divSetLab').popup.hide()","1000");
		}
	}
	
	function cetakKwitansi(){
		window.open('../loket/cetakLoket.php?idPas='+getIdPasien+'&idKunj='+getIdKunj+'&userId=<?php echo $_SESSION['userId'];?>','Kwitansi');
	}

	function simpanMutasi(){            
		var unitLama = document.getElementById('cmbTmpLay').value;
		var unitBaru=document.getElementById('TmpLayananMutasi').value;
		var no_rm = document.getElementById('txtFilter').value;
		var url="";
		url="pelayanankunjungan_utils.php?grd=true&act=simpan&no_rm="+no_rm+"&unitBaru="+unitBaru+"&unitLama="+unitLama+"&userId=<?php echo $_SESSION['userId']; ?>"+"&id="+getIdPel+"&kunjungan_id="+getIdKunj+"&saring=true&saringan="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbTmpLay').value+"&inap="+inap+"&dilayani="+document.getElementById('cmbDilayani').value;
		//alert(url);
		a1.loadURL(url,"","GET");
		document.getElementById('divDetil').style.display='none';
		document.getElementById('divKunj').style.display='block';
	}

	function ambilDataTind()
	{
		batal('btnBatalTind');
		var sisip=f.getRowId(f.getSelRow()).split("|");
		//alert(sisip[1]);
		var p ="id_tind*-*"+sisip[0]+"*|*tindakan_id*-*"+sisip[1]+"*|*txtTind*-*"+f.cellsGetValue(f.getSelRow(),3)+"*|*txtBiaya*-*"+f.cellsGetValue(f.getSelRow(),5)+"*|*txtQty*-*"+f.cellsGetValue(f.getSelRow(),6)+"*|*txtKet*-*"+f.cellsGetValue(f.getSelRow(),10)+"*|*btnSimpanTind*-*Simpan*|*btnHapusTind*-*false";
		fSetValue(window,p);
		document.getElementById("tdKelas").innerHTML=f.cellsGetValue(f.getSelRow(),4);
		if(unitId!=sisip[2]){
			document.getElementById('chkTind').checked=true;
			document.getElementById('trUnit').style.visibility='visible';
			fSetValue(window,"jnsLay*-*"+sisip[3]+"*|*tmpLay*-*"+sisip[2]);
		}else{
			document.getElementById('chkTind').checked=false;
			document.getElementById('trUnit').style.visibility='collapse';
			isiCombo('JnsLayanan','',sisip[3],'jnsLay');
			isiCombo('TmpLayanan',sisip[3],sisip[2],'tmpLay');
			//document.getElementById('cmbDokTind').value=sisip[4];
		}
		
		if(document.getElementById('cmbDokTind').disabled==false){
			if(sisip[7] == 0){
				isiCombo('cmbDok',sisip[2],sisip[4],'cmbDokTind');
				document.getElementById('chkDokterPenggantiTind').checked = false;
			}
			else{
				isiCombo('cmbDokPengganti',sisip[2],sisip[4],'cmbDokTind');
				document.getElementById('chkDokterPenggantiTind').checked = true;
			}
		}
		
		var unitUserId = document.getElementById('cmbTmpLay').value;
		if(sisip[6]!=unitUserId){
			document.getElementById('chkTind').disabled=true;
			document.getElementById('txtTind').disabled = true;
			document.getElementById('txtBiaya').disabled = true;
			document.getElementById('txtQty').disabled = true;
		}
		else{
			document.getElementById('chkTind').disabled=false;
			document.getElementById('txtTind').disabled = false;
			document.getElementById('txtBiaya').disabled = false;
			document.getElementById('txtQty').disabled = false;
		}
	  
	  	//for anastesi
	  	if(cmbTmpLay == 6 || cmbTmpLay == 7 || cmbTmpLay == 13 || cmbTmpLay == 18 || cmbTmpLay == 47 || cmbTmpLay == 63){
		 	if(sisip[9] != ''){
				var dok_an = sisip[9].split(',');
				for(var i=0; i<dok_an.length; i++){
					document.getElementById('chk_an_'+dok_an[i]).checked = true;
				}
		 	}
	  	}
		
		
		//radiologi
		/*
		if(document.getElementById('cmbJnsLay').value==60){
			document.getElementById('div_rad').style.display='none';
			document.getElementById('div_gb_rad').style.display='block';
			Request('ambil_gb_radiologi.php?id='+sisip[0],'div_gb_rad','','GET');
		}
		*/
	}
        
	function printReport(){
		var sisip=f.getRowId(f.getSelRow()).split("|");
		if(sisip[8] == '13'){
			window.open('visite.php?tindakan_id='+sisip[0]+'&petugas=<?php echo $_SESSION['userId'];?>');
			batal('btnBatalTind');
		}
	}

	function ambilDataDiag()
	{
		var sisip=b.getRowId(b.getSelRow()).split("|");
		var p ="cmbUtama*-*"+sisip[4]+"*|*btnSimpanDiag*-*Simpan*|*btnHapusDiag*-*false";
		fSetValue(window,p);
		//+"*|*cmbDokDiag*-*"+sisip[1]
		
		if(sisip[8]==0){
			document.getElementById('chkPenyebabKecelakaan').checked = '';
			document.getElementById('diagnosa_id').value = sisip[2];
			document.getElementById('id_diag').value = sisip[0];
			document.getElementById('txtDiag').value = b.cellsGetValue(b.getSelRow(),3);
			document.getElementById('trPenyebab').style.display='none';
		}
		else{
			document.getElementById('chkPenyebabKecelakaan').checked = 'true';
			document.getElementById('diagnosa_id').value = sisip[6];
			document.getElementById('id_diag').value = sisip[0];
			document.getElementById('txtDiag').value = sisip[7];
			Request('../combo_utils.php?id=PenyebabKecelakaan&value='+sisip[6]+'&defaultId='+sisip[2],'cmbPenyebab','','GET');
			document.getElementById('trPenyebab').style.display='table-row';
		}
		
		if(sisip[5]==1){
			document.getElementById('chkAkhir').checked='true';
		}
		else{
			document.getElementById('chkAkhir').checked='';
		}
		
		if(document.getElementById('cmbDokDiag').disabled==false){
			if(sisip[3] == 0){
				isiCombo('cmbDok',unitId,sisip[1],'cmbDokDiag');
				document.getElementById('chkDokterPenggantiDiag').checked = false;
			}
			else{
				isiCombo('cmbDokPengganti',unitId,sisip[1],'cmbDokDiag');
				document.getElementById('chkDokterPenggantiDiag').checked = true;
			}
		}
		
		//document.getElementById('chkDokterPenggantiDiag').checked = sisip[3];
	}
	//Resep
	var tgl_resep;

	function ambilDataResep()
	{
		var sisipan=r.getRowId(r.getSelRow()).split("|");
		//alert(sisipan);
		var p ="idResep*-*"+sisipan[0]+"*|*cmbApotek*-*"+sisipan[5]+"*|*txtNmObat*-*"+r.cellsGetValue(r.getSelRow(),2)+"*|*txtStok*-*"+sisipan[4]+"*|*txtJml*-*"+r.cellsGetValue(r.getSelRow(),3)+"*|*txtDosis*-*"+r.cellsGetValue(r.getSelRow(),5)+"*|*chRacikan*-*"+((r.cellsGetValue(r.getSelRow(),4)=='1')?'true':'false')+"*|*idObat*-*"+sisipan[2]+"*|*btnSimpanResep*-*Simpan*|*btnHapusResep*-*false";
		fSetValue(window,p);
		//+"*|*cmbDokResep*-*"+sisipan[6]
		
		if(document.getElementById('cmbDokResep').disabled==false){
			if(sisipan[7] == 0){
				isiCombo('cmbDok',unitId,sisipan[6],'cmbDokResep');
				document.getElementById('chkDokterPenggantiResep').checked = false;
			}
			else{
				isiCombo('cmbDokPengganti',unitId,sisipan[6],'cmbDokResep');
				document.getElementById('chkDokterPenggantiResep').checked = true;
			}
		}
	}

	<!-- Script Pop Up Window -->
	var win = null;
	function NewWindow(mypage,myname,w,h,scroll){
		LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
		TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
		settings =
		'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
		win = window.open(mypage,myname,settings)
	}
	<!-- Script Pop Up Window Berakhir -->
	function OpenDosis(){
		var url;
		no_resep=document.getElementById('noResep').value;
	    url="../../apotek/report/kwi_dosis.php?no_penjualan=&idpel="+getIdPel+"&no_resep="+no_resep+"&sunit="+document.getElementById('cmbApotek').value+"&no_pasien="+getNoPasien+"&tgl="+document.getElementById('tglResep').value;
		NewWindow(url,'name','1000','500','yes');
		//return false;
	}
	
	//resep
	function ambilDataResepDetail(){
		var sisip = aResep.getRowId(aResep.getSelRow()).split("|");
		/*var no_resep = aResep.cellsGetValue(aResep.getSelRow(),2);
		var Idapotek = aResep.getRowId(aResep.getSelRow());*/
		//tgl_resep = sisip[1];
		document.getElementById('tglResep').value=sisip[1];
		document.getElementById('noResep').value=sisip[2];
		document.getElementById('cmbApotek').value=sisip[0];
		document.getElementById('detail_resep').style.display = 'block';
		if(sisip[3]==3){
			document.getElementById('btnSave').disabled='';
		}
		else{
			document.getElementById('btnSave').disabled=true;
		}
		//alert("tindiag_utils.php?grdRsp2=true&no_resep="+no_resep);
		aDet.loadURL("tindiag_utils.php?grdRsp2=true&pelayanan_id="+getIdPel+"&no_resep="+sisip[2]+"&apotek_id="+sisip[0]+"&tgl_resep="+sisip[1],"","GET");
	}
	
	function tutupPopResep(){
		batal('btnBatalResep');
		//if (actPopResep=="tambah"){
			aResep.loadURL("tindiag_utils.php?grdRsp1=true&pelayanan_id="+getIdPel,"","GET");
		/*}else{
			ambilDataResepDetail();
		}*/
	}
	//resep

	function ambilDataRujukUnit(){
	var sisipan,p;
		//alert(c.getRowId(c.getSelRow()));
		document.getElementById('cetak').disabled = false;
		document.getElementById('ctkLabRadPerKonsul').style.visibility='collapse';
		
		if (c.getMaxPage()>0){
			sisipan=c.getRowId(c.getSelRow()).split("|");
			p ="idRujukUnit*-*"+sisipan[0]+"*|*JnsLayanan*-*"+sisipan[1]+"*|*TmpLayanan*-*"+sisipan[2]+"*|*btnHapusRujukUnit*-*false";
			fSetValue(window,p);
			isiCombo('TmpLayanan', sisipan[1], sisipan[2], 'TmpLayanan', '');
			//alert(sisipan[0]);+"*|*cmbDokRujukUnit*-*"+sisipan[3]
			document.getElementById('txtKetRujuk').value = c.cellsGetValue(c.getSelRow(),5);
			
			if(document.getElementById('cmbDokRujukUnit').disabled==false){
				if(sisipan[4] == 0){
					isiCombo('cmbDok',unitId,sisipan[3],'cmbDokRujukUnit');
					document.getElementById('chkDokterPenggantiRujukUnit').checked = false;
				}
				else{
					isiCombo('cmbDokPengganti',unitId,sisipan[3],'cmbDokRujukUnit');
					document.getElementById('chkDokterPenggantiRujukUnit').checked = true;
				}
			}
			
			if (sisipan[1]==57){
				document.getElementById('ctkLabRadPerKonsul').value="HASIL LAB";
				document.getElementById('ctkLabRadPerKonsul').style.visibility='visible';
			}else if (sisipan[1]==60){
				document.getElementById('ctkLabRadPerKonsul').value="HASIL RAD";
				document.getElementById('ctkLabRadPerKonsul').style.visibility='visible';
			}
		}

		if(document.getElementById('trKamarRujuk').style.visibility == 'visible'){
			setTimeout('isiKelas()',1000);
		}
	}

	function ambilDataRujukRS(){
		//alert(c.getRowId(c.getSelRow()));
		//cmbEmergency cmbKondisiPasien     chkDokterPenggantiRujukRS
		var sisipan=d.getRowId(d.getSelRow()).split("|");
	    var waktu = d.cellsGetValue(d.getSelRow(),2).split(' ');
	    waktu[1] = waktu[1].substr(0,5);
	    document.getElementById('chkManualKrs').checked = true;
	    caraKeluar(d.cellsGetValue(d.getSelRow(),3));
        var p ="idRujukRS*-*"+sisipan[0]+"*|*cmbRS*-*"+sisipan[1]+"*|*cmbDokRujukRS*-*"+sisipan[2]+"*|*cmbCaraKeluar*-*"+d.cellsGetValue(d.getSelRow(),3)+"*|*TglKrs*-*"+waktu[0]+"*|*JamKrs*-*"+waktu[1]+"*|*cmbKeadaanKeluar*-*"+sisipan[4]+"*|*cmbKasus*-*"+sisipan[5]+"*|*cmbRS*-*"+sisipan[1]+"*|*btnHapusRujukRS*-*false";
        fSetValue(window,p);
	    document.getElementById('txtKetRujukRS').innerHTML = d.cellsGetValue(d.getSelRow(),10);
	}

	function ambilDataKamar(){
		//alert(e.getRowId(e.getSelRow()));
		var sisipan=e.getRowId(e.getSelRow()).split("|");
		var p ="idSetKamar*-*"+sisipan[0]+"*|*cmbJL*-*"+sisipan[5]+"*|*btnHapusKamar*-*false";
		fSetValue(window,p);
		isiCombo('TmpLayananInapSaja',sisipan[5],sisipan[4],'cmbTL');
		isiCombo('cmbKelasKamar',sisipan[4],sisipan[2],'cmbKelas');
		isiCombo('cmbKamar',sisipan[4]+','+sisipan[2],sisipan[1],'cmbKamar');
	}
	
	function ambilDataHslRad()
	{
		var sisip = rad.getRowId(rad.getSelRow()).split("|");
		//alert(sisip);
		batalHslRad();
		document.getElementById("id_hasil_rad").value=sisip[0];
		document.getElementById("txtHslRad").value=sisip[1];
		document.getElementById("cmbDokHslRad").value=sisip[2];
		//btnSimpanTind*-*Simpan*|*btnHapusTind*-*false;
		document.getElementById("btnSimpanHslRad").value="Simpan";
		//document.getElementById("btnHapusHsl").style.disabled=false;
		var p= "btnHapusHslRad*-*false";
		fSetValue(window,p);
	}
	
	function batalHslRad(){
		document.getElementById("id_hasil_rad").value="";
		document.getElementById("txtHslRad").value="";
		document.getElementById("cmbDokHslRad").selectedIndex="";
		document.getElementById("btnSimpanHslRad").value="Tambah";
		var p= "btnHapusHslRad*-*true";
		fSetValue(window,p);
		document.getElementById('frameRad').contentWindow.kensel();
	}

	function spInap(){
		var sisipan=c.getRowId(c.getSelRow()).split("|");
		//alert('spInap.php?idKunj='+getIdKunj+'&dokter_id='+sisipan[3]);
		window.open('spInap.php?idKunj='+getIdKunj+'&dokter_id='+sisipan[3],'spInap');
		//&idUser=<?php echo $_SESSION['userId']?>'+'
	}
		
	function cetak()
	{
		var sisipan=c.getRowId(c.getSelRow()).split("|");
		window.open('cetakKamar.php?idPas='+getIdPasien+'&idKunj='+getIdKunj+'&idPel='+sisipan[0]+'&dokter_id='+sisipan[3]+'&userId=<?php echo $_SESSION['userId'];?>','cetakKamar');
	}
		
	function hapus(id)
	{
		var rowidTind = document.getElementById("id_tind").value;
		var rowidDiag = document.getElementById("id_diag").value;
		var rowidRujukUnit = document.getElementById("idRujukUnit").value;
		var rowidRujukRS = document.getElementById("idRujukRS").value;
		var rowidKamar = document.getElementById("idSetKamar").value;
		var rowidResep = document.getElementById("idResep").value;
		var tmpLayRujukUnit = document.getElementById("TmpLayanan").value;
		var userId='<?php echo $_SESSION['userId']?>';
		var unitUserId=document.getElementById('cmbTmpLay').value;
		var cTglNow="<?php echo $pTglSkrg; ?>";

		//resep
		var url;

		switch(id)
		{
			case 'btnHapusHslRad':
				var sisip=rad.getRowId(rad.getSelRow()).split("|");
				//var rowHsl = document.getElementById("idTindHsl").value;
				var cTglTind=sisip[3];
				//cTglTind=cTglTind.split(" ");
				//cTglTind=cTglTind[0].split("-");
				//cTglTind=cTglTind[2]+"-"+cTglTind[1]+"-"+cTglTind[0];
				//alert(cTglTind);
					if (cTglNow>cTglTind){
						alert("Data Yang Dientry Sudah Lebih Dari 24 Jam, Jadi Tidak Boleh Dihapus !");
					}else{
						if(confirm("Anda Yakin Ingin Menghapus Hasil Radiologi ini ?")){
							document.getElementById(id).disabled = true;
							//alert("hasilLab_utils.php?grd=true&act=hapus&hps="+id+"&id="+sisip[0]+"&pelayanan_id="+getIdPel);
							rad.loadURL("hasilRad_utils.php?grd=true&act=hapus&hps="+id+"&rowid="+sisip[0]+"&pelayanan_id="+getIdPel,'',"GET");
							//alert("tindiag_utils.php?grd=true&act=hapus&hps="+id+"&pelayanan_id="+getIdPel+"&rowid="+rowidTind+"&unit_id="+unitUserId);
							//batal('btnBatalTind');
							//batalHslRad();
						}
					}
					
			break;
			case 'btnHapusHsl':
				var sisip=lab.getRowId(lab.getSelRow()).split("|");
				var rowHsl = document.getElementById("idTindHsl").value;
				var cTglTind=lab.cellsGetValue(lab.getSelRow(),2);
				cTglTind=cTglTind.split(" ");
				//cTglTind=cTglTind[0].split("-");
				//cTglTind=cTglTind[2]+"-"+cTglTind[1]+"-"+cTglTind[0];
				//alert(cTglTind);
					if (cTglNow>cTglTind[0]){
						alert("Data Tindakan Yang Dientry Sudah Lebih Dari 24 Jam, Jadi Tidak Boleh Dihapus !");
					}else{
						if(confirm("Anda Yakin Ingin Menghapus Hasil laboratorium "+lab.cellsGetValue(lab.getSelRow(),3))){
							document.getElementById(id).disabled = true;
							//alert("hasilLab_utils.php?grd=true&act=hapus&hps="+id+"&id="+sisip[0]+"&pelayanan_id="+getIdPel);
							lab.loadURL("hasilLab_utils.php?grd=true&act=hapus&hps="+id+"&rowid="+sisip[0]+"&pelayanan_id="+getIdPel,'',"GET");
							//alert("tindiag_utils.php?grd=true&act=hapus&hps="+id+"&pelayanan_id="+getIdPel+"&rowid="+rowidTind+"&unit_id="+unitUserId);
							//batal('btnBatalTind');
							batalHsl();
						}
					}
					
			break;
			case 'btnHapusTind':
				var sisip=f.getRowId(f.getSelRow()).split("|");
				var cTglTind=f.cellsGetValue(f.getSelRow(),2);
				cTglTind=cTglTind.split(" ");
				cTglTind=cTglTind[0].split("-");
				cTglTind=cTglTind[2]+"-"+cTglTind[1]+"-"+cTglTind[0];
				//alert(cTglTind);
				if(sisip[6]!=unitUserId){
					alert('Tindakan Retribusi Tidak Bisa Dihapus!');
				}
				else{
					if (cTglNow>cTglTind){
						alert("Data Tindakan Yang Dientry Sudah Lebih Dari 24 Jam, Jadi Tidak Boleh Dihapus !");
					}else{
						if(confirm("Anda Yakin Ingin Menghapus Tindakan "+f.cellsGetValue(f.getSelRow(),3))){
							document.getElementById(id).disabled = true;
							f.loadURL("tindiag_utils.php?grd=true&act=hapus&hps="+id+"&pelayanan_id="+getIdPel+"&rowid="+rowidTind+"&unit_id="+unitUserId+"&userId="+userId,'',"GET");
							//alert("tindiag_utils.php?grd=true&act=hapus&hps="+id+"&pelayanan_id="+getIdPel+"&rowid="+rowidTind+"&unit_id="+unitUserId);
							//batal('btnBatalTind');
						}
					}
				}
				batal('btnBatalTind');
				break;

			case 'btnHapusDiag':
				if(confirm("Anda yakin menghapus Diagnosa "+b.cellsGetValue(b.getSelRow(),3))){
					document.getElementById(id).disabled = true;
					//alert("tindiag_utils.php?grd1=true&act=hapus&hps="+id+"&rowid="+rowidDiag);
					b.loadURL("tindiag_utils.php?grd1=true&act=hapus&hps="+id+"&pelayanan_id="+getIdPel+"&rowid="+rowidDiag,"","GET");
				}
				document.getElementById("txtDiag").value = '';
				break;

			case 'btnHapusResep':	//resep
				if(confirm("Anda yakin menghapus Resep "+r.cellsGetValue(r.getSelRow(),2)))
				{
					var sisip=r.getRowId(r.getSelRow()).split("|");
					var apotek = document.getElementById("cmbApotek").value;

					document.getElementById(id).disabled = true;
					url="tindiag_utils.php?grdResep=true&pelayanan_id="+getIdPel+"&act=hapus&hps="+id+"&rowid="+rowidResep+"&noResep="+document.getElementById('noResep').value+"&apotek="+apotek+"&tgl_resep="+sisip[8];
					//alert(url);
					r.loadURL(url,"","GET");
				}
				break;

			case 'btnHapusRujukUnit':
				var isInap = 0;
				if(confirm("Anda yakin menghapus rujukan ke unit "+c.cellsGetValue(c.getSelRow(),3))){
					document.getElementById(id).disabled = true;
					if(document.getElementById('lgnJudul').innerHTML=='MRS'){
						isInap = 1;
					}
					//alert("tindiag_utils.php?grd2=true&act=hapus&hps="+id+"&isInap="+isInap+"&kunjungan_id="+getIdKunj+"&pasienId="+getIdPasien+"&tmpLay="+tmpLayRujukUnit+"&pelayanan_id="+getIdPel+"&unitAsal="+getIdUnit+"&rowid="+rowidRujukUnit);
					c.loadURL("tindiag_utils.php?grd2=true&act=hapus&hps="+id+"&isInap="+isInap+"&kunjungan_id="+getIdKunj+"&pasienId="+getIdPasien+"&tmpLay="+tmpLayRujukUnit+"&pelayanan_id="+getIdPel+"&unitAsal="+getIdUnit+"&rowid="+rowidRujukUnit,"","GET");
				}
				break;
				
			case 'btnHapusRujukRS':
				if(confirm("Anda yakin menghapus KRS ini?")){
					document.getElementById(id).disabled = true;
					//alert("tindiag_utils.php?grd3=true&act=hapus&hps="+id+"&kunjungan_id="+getIdKunj+"&rowid="+rowidRujukRS+"&userId="+userId);
					d.loadURL("tindiag_utils.php?grd3=true&act=hapus&hps="+id+"&kunjungan_id="+getIdKunj+"&pelayanan_id="+getIdPel+"&rowid="+rowidRujukRS+"&userId="+userId,"","GET");
				}
				break;
			case 'btnHapusKamar':
				if(confirm("Anda yakin menghapus data pindah kamar ke "+e.cellsGetValue(e.getSelRow(),4)+" pada "+e.cellsGetValue(e.getSelRow(),2)) ){
					document.getElementById(id).disabled = true;
					//alert("tindiag_utils.php?grd4=true&act=hapus&hps="+id+"&kunjungan_id="+getIdKunj+"&pelayanan_id="+getIdPel+"&rowid="+rowidKamar+"&unit_id="+getIdUnit);
					e.loadURL("tindiag_utils.php?grd4=true&act=hapus&hps="+id+"&kunjungan_id="+getIdKunj+"&pelayanan_id="+getIdPel+"&rowid="+rowidKamar+"&unit_id="+getIdUnit,"","GET");
					fSetValue(window,'btnHapusKamar*-*true');
				}
				break;
			case 'btnBatalPulang':
				if(confirm("Pasien "+document.getElementById('txtNama').value+" batal dipulangkan.\nAnda yakin?")){
					Request("tindiag_utils.php?act=hapus&hps="+id+"&kunjungan_id="+getIdKunj+"&pelayanan_id="+getIdPel,'spanTar1','','GET',pasPul,'ok');
				}
				break;
		}
	}

	function batal(id){
		//alert(id);
		if (id != undefined && id != ""){
			if (document.getElementById(id)) document.getElementById(id).disabled = false;
		}
		switch(id){
			case 'btnSimpanHslRad':
				batalHslRad();
				break;
			case 'btnHapusHslRad':
				batalHslRad();
				break;
			case 'btnSimpanTind':
			case 'btnHapusTind':
			case 'btnBatalTind':
				if(cmbTmpLay == 6 || cmbTmpLay == 7 || cmbTmpLay == 13 || cmbTmpLay == 18 || cmbTmpLay == 47 || cmbTmpLay == 63){
					if(document.form_an.chk_an){
					   if(document.form_an.chk_an.length){
						  for(var i=0; i<document.form_an.chk_an.length; i++){
							 document.form_an.chk_an[i].checked = false;
						  }
					   }
					   else{
						  document.getElementById('chk_an').checked = false;
					   }
					}
				}
				var p="id_tind*-**|*txtTind*-**|*txtBiaya*-**|*txtKet*-**|*txtQty*-**|*chkTind*-*false*|*btnSimpanTind*-*Tambah*|*btnSimpanTind*-*false*|*btnHapusTind*-*true";
				fSetValue(window,p);
				document.getElementById('chkTind').disabled=false;
				document.getElementById('txtTind').disabled = false;
				document.getElementById('txtBiaya').disabled = false;
				document.getElementById('txtQty').disabled = false;
				document.getElementById("tdKelas").innerHTML="";
				document.getElementById('trUnit').style.visibility='collapse';
				document.getElementById('txtTind').focus();
				unitId=document.getElementById('cmbTmpLay').value;
				
				// radiologi
				if(document.getElementById('cmbJnsLay').value==60 && tambahRadiologi==false){
					document.getElementById('frameRad').contentWindow.kensel();
				}
				tambahRadiologi = false;
				
				/*
				if(document.getElementById('cmbJnsLay').value==60){
					document.getElementById('div_rad').style.display='block';
					document.getElementById('div_gb_rad').style.display='none';
				}
				*/
				// akir radiologi
				break;
			case 'btnSimpanDiag':
			case 'btnHapusDiag':
			case 'btnBatalDiag':
				var p="diagnosa_id*-**|*txtDiag*-**|*btnSimpanDiag*-*Tambah*|*btnSimpanDiag*-*false*|*btnHapusDiag*-*true";
				fSetValue(window,p);
				document.getElementById('chkPenyebabKecelakaan').checked='';
				document.getElementById('trPenyebab').style.display='none';
				document.getElementById('chkAkhir').checked='';
				break;
				//resep
			case 'btnSimpanResep':
			case 'btnHapusResep':
			case 'btnBatalResep':
				var p = "idResep*-**|*txtNmObat*-**|*btnSimpanResep*-*Tambah*|*btnSimpanResep*-*false*|*btnHapusResep*-*true";
				fSetValue(window,p);
				if (document.getElementById('chRacikan').checked==false){
					document.getElementById('txtJml').value = "";
				}
				document.getElementById('txtDosis').value = "";
				document.getElementById('txtNmObat').focus();
				//aResep.loadURL("tindiag_utils.php?grdRsp1=true&pelayanan_id="+getIdPel,"","GET");
				break;
			case 'btnBatalRujukUnit':
				var p = "idRujukUnit*-**|*btnSimpanRujukUnit*-*Tambah*|*btnSimpanRujukUnit*-*false*|*btnHapusRujukUnit*-*true";
				fSetValue(window,p);
				document.getElementById('txtKetRujuk').value = '';
				break;
			case 'btnBatalRujukRS':
				var p = "idRujukUnit*-**|*btnSimpanRujukRS*-*Tambah*|*chkManualKrs*-*false*|*btnSimpanRujukRS*-*false*|*btnHapusRujukRS*-*true";
				fSetValue(window,p);
				document.getElementById('txtKetRujuk').value = '';
				break;
			case 'btnBatalKamar':
				var p = "idRujukUnit*-**|*btnSimpanKamar*-*Tambah*|*btnSimpanKamar*-*false*|*btnHapusKamar*-*true";
				fSetValue(window,p);
				document.getElementById('txtKetRujuk').value = '';
				break;
			case 'btnBatalMutasi':
				var p = "idRujukUnit*-**|*btnSimpanMutasi*-*false";
				fSetValue(window,p);
				document.getElementById('txtKetRujuk').value = '';
				break;
		}
	}

	function setDok(ke,ev){
		fSetValue(window,"cmbDokDiag*-*"+ke+"*|*cmbDokTind*-*"+ke+"*|*cmbDokRujukRS*-*"+ke+"*|*cmbDokRujukUnit*-*"+ke+"*|*cmbDokResep*-*"+ke);
		if(ev && ev.which==13) document.getElementById(ke).focus();
	}
	
	function cekDokter(){
	var tindId=document.getElementById('mtId').value;
		//alert(tindId);
		if (tindId=="750"){
			document.getElementById('cmbDokTind').value="584";
		}else if (tindId=="742" || tindId=="746" || tindId=="747" || tindId=="748"){
			document.getElementById('cmbDokTind').value="612";
		}else if (tindId=="743" || tindId=="744"){
			document.getElementById('cmbDokTind').value="581";
		}
	}
	    
	function cekVerifikasi(){
		if(getVerifikasi=='1'){
			document.getElementById("btnVerifikasi").innerHTML="VERIFIKASI (sudah)";
			document.getElementById("btnVerifikasi").style.backgroundColor="#00ff00";
		}else{
			document.getElementById("btnVerifikasi").innerHTML="VERIFIKASI (belum)";
			document.getElementById("btnVerifikasi").style.backgroundColor="#ff0000";
		}
	}
	    
	function verifikasi(vid){
		Request("verifikasi_utils.php?act=verifikasi&pelayanan_id="+getIdPel+"&verifikator="+vid,'btnVerifikasi','','GET');
		if(document.getElementById("btnVerifikasi").innerHTML='VERIFIKASI (sudah)'){
			document.getElementById("btnVerifikasi").style.backgroundColor="#00ff00";
		}else{
			document.getElementById("btnVerifikasi").style.backgroundColor="#ff0000";
		}
	}

	function goFilterAndSort(grd){
		//alert(grd);
		if (grd=="gridbox"){
			var no_rm = document.getElementById('txtFilter').value;
			//alert("pelayanankunjungan_utils.php?grd=true&saring=true&no_rm="+no_rm+"&saringan="+txtTgl+"&tmpLay="+cmbTmpLay+"&inap="+inap+"&dilayani="+cmbDilayani+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage());
			a1.loadURL("pelayanankunjungan_utils.php?grd=true&saring=true&no_rm="+no_rm+"&saringan="+txtTgl+"&tmpLay="+cmbTmpLay+"&inap="+inap+"&dilayani="+cmbDilayani+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage(),"","GET");
		}
		else if (grd=="gridboxTind"){
			f.loadURL("tindiag_utils.php?grd=true&pelayanan_id="+getIdPel+"&filter="+f.getFilter()+"&no_rm="+no_rm+"&sorting="+f.getSorting()+"&page="+f.getPage(),"","GET");
		}
		else if (grd=="gridbox1"){
			b.loadURL("tindiag_utils.php?grd1=true&pelayanan_id="+getIdPel+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage(),"","GET");
		}
		else if (grd=="gridboxRujukUnit"){
			//alert("tindiag_utils.php?grd2=true&kunjungan_id="+getIdKunj+"&unitAsal="+getIdUnit+"&filter="+c.getFilter()+"&sorting="+c.getSorting()+"&page="+c.getPage());
			c.loadURL("tindiag_utils.php?grd2=true&kunjungan_id="+getIdKunj+"&unitAsal="+getIdUnit+"&filter="+c.getFilter()+"&sorting="+c.getSorting()+"&page="+c.getPage(),"","GET");
		}
		else if (grd=="gridboxRujukRS"){
			//alert("tindiag_utils.php?grd3=true&kunjungan_id="+getIdKunj+"&pelayanan_id="+getIdPel+"&filter="+d.getFilter()+"&sorting="+d.getSorting()+"&page="+d.getPage());
			d.loadURL("tindiag_utils.php?grd3=true&kunjungan_id="+getIdKunj+"&pelayanan_id="+getIdPel+"&filter="+d.getFilter()+"&sorting="+d.getSorting()+"&page="+d.getPage(),"","GET");
		}
		else if (grd=="gridboxKamar"){
			e.loadURL("tindiag_utils.php?grd4=true&kunjungan_id="+getIdKunj+"&unit_id="+getIdUnit+"&filter="+e.getFilter()+"&sorting="+e.getSorting()+"&page="+e.getPage(),"","GET");
		}
		else if(grd=="gridboxResep"){	//resep
			//alert("tindiag_utils.php?grdResep=true&kunjungan_id="+getIdKunj+"&filter="+r.getFilter()+"&sorting="+r.getSorting()+"&page="+r.getPage());
			r.loadURL("tindiag_utils.php?grdResep=true&pelayanan_id="+getIdPel+"&filter="+r.getFilter()+"&sorting="+r.getSorting()+"&page="+r.getPage(),"","GET");
		}
	}

	var tambahRadiologi=false;
	function konfirmasi(key,val){
		var tangkap,proses,tombolSimpan,tombolHapus,msg,id_tindakan_radiologi;
		//alert(val+'-'+key);
		if (val!=undefined){
			tangkap=val.split("*|*");
			proses=tangkap[0];
			tombolSimpan=tangkap[1];
			tombolHapus=tangkap[2];
			msg=tangkap[3];
			id_tindakan_radiologi=tangkap[4];
			tgl_resep = tangkap[5];
		}
		//alert(proses+'-'+key);
		if(key=='Error'){
			if(proses=='tambah'){
				if(tombolSimpan=='btnSimpanTind'){
					if (msg==""){
						alert('Retribusi belum diverifikasi oleh Dokter!');
					}else{
						alert(msg);
					}
				}
				else if(tombolSimpan=='btnSimpanKamar'){
					alert('Pindah kamar gagal!');
				}
				else if(tombolSimpan=='btnSimpanRujukUnit'){
					if(document.getElementById('lgnJudul').innerHTML=='MRS'){
						alert('Pasien Sudah Berkunjung Ke Unit Pelayanan Tersebut dan Belum Pulang !');
					}else{
						alert('Pasien Hari Ini Sudah Berkunjung Ke Unit Pelayanan Tersebut !');
					}
				}
				else{
					alert("Gagal Memasukan Data ke Database.");
				}
			}
			else if(proses=='simpan'){
				alert('Simpan Gagal');
			}
			else if(proses=='hapus'){
				if(tombolHapus=='btnHapusRujukUnit'){
					alert('Hapus Gagal karena pasien sudah dilayani!');
				}
				else if(tombolHapus=='btnHapusTind'){
					alert(msg);
				}
				else{
				   alert('Hapus gagal.');
				}
			}
		}
		else{
			document.getElementById('btnMutasi').disabled= true;
			if(proses=='tambah'){
				alert('Simpan Berhasil');
				if(tombolSimpan=='btnSimpanTind'){
					document.getElementById('txtTind').focus();
				}
				else if(tombolSimpan=='btnSimpanDiag'){
					document.getElementById('txtDiag').focus();
				}
				else if(tombolSimpan=='btnSimpanResep'){	//resep
					document.getElementById('txtNmObat').focus();
					resep_baru=0;
					document.getElementById('noResep').value=msg;
					document.getElementById('cmbApotek').disabled=true;
					//document.getElementById('trNoResep').style.display='table-row';
				}
				else if(tombolSimpan == 'btnSimpanKamar'){
					document.getElementById('spanKam').innerHTML = " &nbsp;&nbsp;Kamar : "+document.getElementById('cmbKamar').options[document.getElementById('cmbKamar').options.selectedIndex].innerHTML;
				}
				else if(tombolSimpan == 'btnSimpanRujukUnit'){
					ambilDataRujukUnit();
				}
			}
			else if(proses=='simpan'){
				alert('Simpan Berhasil');
			}
			else if(proses=='hapus'){
				alert('Hapus Berhasil');
				if(tombolHapus == 'btnHapusRujukUnit'){
					ambilDataRujukUnit();
				}
			}
		}
		if(proses == 'hapus'){
			batal(tombolHapus);
		}
		else{
			batal(tombolSimpan);
		}
		//shall be deleted after function works!!!
		if(eksyennya == 'pindah kamar'){
			//alert('Pindah kamar berhasil.');
			if(document.getElementById('cmbTmpLay').value == document.getElementById("cmbTL").value){
				document.getElementById('spanKam').innerHTML = " &nbsp;&nbsp;Kamar : "+document.getElementById('cmbKamar').options[document.getElementById('cmbKamar').options.selectedIndex].innerHTML;
			}
			eksyennya = '';
		}
	}
//========================tambahan raga=====================
	function CmbChange2(p,q){
			switch(p){
				case "kesakitan":
					isiCombo2('jnskasus',q,'','jeniskasus');
					break;
			}
	}
	
	function lihatDetail(p,q){
			switch(p){
				case "kia_jenis":
					isiCombo2('detailKIA',q,'','kia_detail');
					if(q==3 || q==5){
						document.getElementById('kiadetail').style.display = 'table-row';
					}
					else{
						document.getElementById('kiadetail').style.display = 'none';
					}
					break;
			}
	}
	
	function isiCombo2(id,val,defaultId,targetId,evloaded,targetWindow){
		if(targetId=='' || targetId==undefined){
			targetId=id;
		}
		//alert('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'',parent.window);
		Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'',parent.window);
	}
	
	function detailPil(){
	//alert(document.getElementById('sifat').value);
	var sifat = document.getElementById('sifat').value;
	if(sifat==1 || sifat==2){
		document.getElementById('ket_sifat').style.display='none';
		}
	if(sifat==3){
		document.getElementById('ket_sifat').style.display='table-row';
		}
	}
	<!---------------------------------------------addRowTable-------------------------------------->
function addRowToTable()
{
	kedua=1;
//use browser sniffing to determine if IE or Opera (ugly, but required)
	var isIE = false;
	if(navigator.userAgent.indexOf('MSIE')>0){isIE = true;}
//	alert(navigator.userAgent);
//	alert(isIE);
  var tbl = document.getElementById('tblJual');
  var lastRow = tbl.rows.length;
  // if there's no header row in the table, then iteration = lastRow + 1
  var iteration = lastRow;
  var row = tbl.insertRow(lastRow);
  	//row.id = 'row'+(iteration-1);
  	row.className = 'itemtableA';
	//row.setAttribute('class', 'itemtable');
	row.onmouseover = function(){this.className='itemtableAMOver';};
	row.onmouseout = function(){this.className='itemtableA';};
	//row.setAttribute('onMouseOver', "this.className='itemtableMOver'");
	//row.setAttribute('onMouseOut', "this.className='itemtable'");
  
  // left cell
  var cellLeft = row.insertCell(0);
  var textNode = document.createTextNode(iteration-1);
  cellLeft.className = 'tdisikiri';
  cellLeft.appendChild(textNode);

  
  // right cell
  cellRight = row.insertCell(1);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'id_pr';
	el.id = 'id_pr';
  	
  }else{
  	el = document.createElement('<input name="id_pr" />');
  }
  el.type = 'hidden';
  cellRight.appendChild(el);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'idpn';
	el.id = 'idpn';
  	
  }else{
  	el = document.createElement('<input name="idpn" />');
  }
  el.type = 'hidden';
  cellRight.appendChild(el);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'idkode';
	el.id = 'idkode';
  	
  }else{
  	el = document.createElement('<input name="idkode" />');
  }
  el.type = 'hidden';
  cellRight.appendChild(el);
  
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'kode';
	el.id = 'kode';
	el.setAttribute('OnKeyUp', "suggestBag(event,this);");
	el.setAttribute('autocomplete', "off");
	 	
  }else{
  	el = document.createElement('<input name="kode" id="kode" onkeyup="suggestBag(event, this);" autocomplete="off"/>');
  }
  el.type = 'text';
  el.size = 10;
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

  cellRight = row.insertCell(2);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'jenis';
	el.id = 'jenis';
	el.readOnly = true;
  	
  }else{
  	el = document.createElement('<input name="jenis" id="jenis" readonly="readonly"/>');
  }
  el.type = 'text';
  el.size = 30;
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  cellRight = row.insertCell(3);
  cellRight.style.display='none';
 if(!isIE){
  	el = document.createElement('input');
  	el.name = 'idgoldar';
	el.id = 'idgoldar';
  	
  }else{
  	el = document.createElement('<input name="idgoldar" />');
  }
  el.type = 'hidden';
  cellRight.appendChild(el);
  
 if(!isIE){
  	el = document.createElement('input');
  	el.name = 'gol';
	el.id = 'gol';
	el.readOnly = true;
  	
  }else{
  	el = document.createElement('<input name="gol" id="gol" readonly="readonly"/>');
  }
  el.type = 'text';
  el.size = 5;
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  cellRight = row.insertCell(4);
  cellRight.style.display='none';
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'idresus';
	el.id = 'idresus';
  	
  }else{
  	el = document.createElement('<input name="idresus" />');
  }
  el.type = 'hidden';
  cellRight.appendChild(el);
  
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'resus';
	el.id = 'resus';
	el.readOnly = true;
  	
  }else{
  	el = document.createElement('<input name="resus" id="resus" readonly="readonly"/>');
  }
  el.type = 'text';
  el.size = 5;
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  cellRight = row.insertCell(5);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'jumlah';
	el.id = 'jumlah';
	el.setAttribute('OnKeyUp', "hitungBiaya(this);");
	el.setAttribute('autocomplete', "off");
  	
  }else{
  	el = document.createElement('<input name="jumlah" id="jumlah" onkeyup="hitungBiaya(this);" autocomplete="off" />');
  }
  el.type = 'text';
  el.size = 3;
  el.className = 'textcenter';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

cellRight = row.insertCell(6);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'kemasan';
	el.id = 'kemasan';
	el.value = 'Kantong';
	el.readOnly = true;
  	
  }else{
  	el = document.createElement('<input name="kemasan" id="kemasan" value="Kantong" readonly="readonly" />');
  }
  el.type = 'text';
  el.size = 10;
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);

cellRight = row.insertCell(7);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'biaya';
	el.id = 'biaya';
	el.value = '0';
	el.readOnly = true;  	
  }else{
  	el = document.createElement('<input name="biaya" id="biaya" value="0" align="right" readonly="readonly" />');
  }
  el.type = 'text';
  el.size = 10;
  el.className = 'textright';
  
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 't_biaya';
	el.id = 't_biaya';
  	
  }else{
  	el = document.createElement('<input name="t_biaya" id="t_biaya" />');
  }
  el.type = 'hidden';
  el.size = 10;
  cellRight.appendChild(el);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'b_umum';
	el.id = 'b_umum';
  	
  }else{
  	el = document.createElement('<input name="b_umum" id="b_umum" />');
  }
  el.type = 'hidden';
  el.size = 10;
  cellRight.appendChild(el);
  if(!isIE){
  	el = document.createElement('input');
  	el.name = 'b_askes';
	el.id = 'b_askes';
  	
  }else{
  	el = document.createElement('<input name="b_askes" id="b_askes" />');
  }
  el.type = 'hidden';
  el.size = 10;
  cellRight.appendChild(el);

  // right cell
  cellRight = row.insertCell(8);
  if(!isIE){
  	el = document.createElement('img');
  	el.setAttribute('onClick','removeRowFromTable(this);');
  }else{
  	el = document.createElement('<img name="img" onClick="removeRowFromTable(this);"/>');
  }
  el.src = '../icon/erase.png';
  el.border = "0";
  el.width = "16";
  el.height = "16";
  el.className = 'proses';
  el.align = "absmiddle";
  el.title = "Klik Untuk Menghapus";
  
//  cellRight.setAttribute('class', 'tdisi');
  cellRight.className = 'tdisi';
  cellRight.appendChild(el);
  
  //document.forms[0].txtObat[iteration-3].focus();
}

function removeRowFromTable(cRow)
{
	//alert(cRow.parentNode.parentNode.rowIndex);
  var tbl = document.getElementById('tblJual');
  var jmlRow = tbl.rows.length;
  if (jmlRow > 2){
  	var i=cRow.parentNode.parentNode.rowIndex;
  //if (i>2){
	  tbl.deleteRow(i);
	  var lastRow = tbl.rows.length;
	  for (var i=2;i<lastRow;i++){
		var tds = tbl.rows[i].getElementsByTagName('td');
		tds[0].innerHTML=i-1;
	  }
	  //HitungTot();
  }
}

//==========================
var RowIdx;
var fKeyEnt;

function suggestBag(e,par){
var keywords=par.value;//alert(keywords);
	//alert(par.offsetLeft);
  var tbl = document.getElementById('tblJual');
  var jmlRow = tbl.rows.length;
  var i;
  if (jmlRow > 2){
  	i=par.parentNode.parentNode.rowIndex-2;
  }else{
  	i=0;	
  }
  //alert(jmlRow+'-'+i);
	if(keywords==""){
		document.getElementById('divbag').style.display='none';
	}else{
		var key;
		if(window.event) {
		  key = window.event.keyCode; 
		}
		else if(e.which) {
		  key = e.which;
		}
		//alert(key);
		if (key==38 || key==40){
			var tblRow=document.getElementById('tblbag').rows.length;
			if (tblRow>0){
				//alert(RowIdx);
				if (key==38 && RowIdx>0){
					RowIdx=RowIdx-1;
					document.getElementById(RowIdx+1).className='itemtableReq';
					if (RowIdx>0) document.getElementById(RowIdx).className='itemtableMOverReq';
				}else if (key==40 && RowIdx<tblRow){
					//alert('asd');
					RowIdx=RowIdx+1;
					if (RowIdx>1) document.getElementById(RowIdx-1).className='itemtableReq';
					document.getElementById(RowIdx).className='itemtableMOverReq';
				}
			}
		}else if (key==13){
			if (RowIdx>0){
				if (fKeyEnt==false){
					ValNamaBag(document.getElementById(RowIdx).lang);
				}else{
					fKeyEnt=false;
				}
			}
		}else if (key!=27 && key!=37 && key!=39){
			RowIdx=0;
			fKeyEnt=false;
			ReqAddr='suggest_kodebag.php?keyword='+keywords+'&gol='+document.getElementById('golongan').value+'&no='+i;
			//alert(ReqAddr);
			Request(ReqAddr , 'divbag', '', 'GET' );		
			if (document.getElementById('divbag').style.display=='none') fSetPosisi(document.getElementById('divbag'),par);
			document.getElementById('divbag').style.top='290px';
			document.getElementById('divbag').style.left='130px';
			document.getElementById('divbag').style.display='block';
		}
	}
}

var kedua=0;
function ValNamaBag(par){
	var cdata=par.split("|");
	//var tbl = document.getElementById('tblJual');
	//alert(par);
	if(document.forms[0].idkode.length==undefined){
		kedua=0;
	}
	
	if ((cdata[0]*1)==0){
		if(kedua==1){
			//document.forms[0].idP[(cdata[0]*1)].value=cdata[1];
			document.form_darah.idpn[(cdata[0])].value=cdata[1];
			//document.form_darah.bag[(cdata[0])].value=cdata[2];
			document.form_darah.idkode[(cdata[0])].value=cdata[3];
			document.form_darah.kode[(cdata[0])].value=cdata[4];
			document.form_darah.jenis[(cdata[0])].value=cdata[5];
			document.form_darah.idgoldar[(cdata[0])].value=cdata[6];
			if(getKsoId != 4 && getKsoId != 6)
				document.form_darah.t_biaya[(cdata[0])].value=cdata[8];
			else
				document.form_darah.t_biaya[(cdata[0])].value=cdata[9];
			document.form_darah.b_umum[(cdata[0])].value=cdata[8];
			document.form_darah.b_askes[(cdata[0])].value=cdata[9];
			document.form_darah.gol[(cdata[0])].value=cdata[7];
			document.form_darah.idresus[(cdata[0])].value=cdata[10];
			document.form_darah.resus[(cdata[0])].value=cdata[11];
			document.form_darah.jumlah[(cdata[0])].focus();
		}
		if(kedua==0){
			document.form_darah.idpn.value=cdata[1];
			//document.form_darah.bag.value=cdata[2];
			document.form_darah.idkode.value=cdata[3];
			document.form_darah.kode.value=cdata[4];
			document.form_darah.jenis.value=cdata[5];	
			document.form_darah.idgoldar.value=cdata[6];
			if(getKsoId != 4 && getKsoId != 6)
				document.form_darah.t_biaya.value=cdata[8];
			else
				document.form_darah.t_biaya.value=cdata[9];
			document.form_darah.b_umum.value=cdata[8];
			document.form_darah.b_askes.value=cdata[9];
			document.form_darah.gol.value=cdata[7];
			document.form_darah.idresus.value=cdata[10];
			document.form_darah.resus.value=cdata[11];
			document.form_darah.jumlah.focus();
			
			kedua=1;
		}
	}else{
		//document.forms[0].idP[(cdata[0]*1)].value=cdata[1];
		document.form_darah.idpn[(cdata[0])].value=cdata[1];
		//document.form_darah.bag[(cdata[0])].value=cdata[2];
		document.form_darah.idkode[(cdata[0])].value=cdata[3];
		document.form_darah.kode[(cdata[0])].value=cdata[4];
		document.form_darah.jenis[(cdata[0])].value=cdata[5];
		document.form_darah.idgoldar[(cdata[0])].value=cdata[6];
		if(getKsoId != 4 && getKsoId != 6)
			document.form_darah.t_biaya[(cdata[0])].value=cdata[8];
		else
			document.form_darah.t_biaya[(cdata[0])].value=cdata[9];
		document.form_darah.b_umum[(cdata[0])].value=cdata[8];
		document.form_darah.b_askes[(cdata[0])].value=cdata[9];
		document.form_darah.gol[(cdata[0])].value=cdata[7];
		document.form_darah.idresus[(cdata[0])].value=cdata[10];
		document.form_darah.resus[(cdata[0])].value=cdata[11];
		document.form_darah.jumlah[(cdata[0])].focus();
	}
	document.getElementById('divbag').style.display='none';
	hitungTot();
}

function hitungTot(){
	var ctot=0;
	if (document.forms[0].idkode.length > 1){
		for (var i=0;i<document.forms[0].idkode.length;i++){
			ctot+=document.form_darah.t_biaya[i].value*document.form_darah.jumlah[i].value;
		}
	}else{
		ctot+=document.form_darah.t_biaya.value*document.form_darah.jumlah.value;
	}
	document.getElementById('spntotal').innerHTML=ctot;
}

function hitungBiaya(jml){
	if (document.form_darah.idkode.length > 1){
		for (var i=0;i<document.form_darah.idkode.length;i++){
			var biaya = document.form_darah.t_biaya[i].value * document.form_darah.jumlah[i].value;
			document.form_darah.biaya[i].value = biaya;
		}
	}
	else if(document.form_darah.idkode.length==undefined){
		var biaya = document.form_darah.t_biaya.value * document.form_darah.jumlah.value;
		document.form_darah.biaya.value = biaya;
	}
	hitungTot();
}

function actMintaDarah(aksi){
	if(document.form_darah.idkode.length==undefined){
		if(document.form_darah.kode.value==''||document.form_darah.jenis.value==''||document.form_darah.jumlah.value==''){
			alert('masih ada data yang kosong');
			return false;
		}
	}
	if (document.form_darah.idkode.length > 1){
		for(var it=document.form_darah.id_pr.length;it>0;it--){
			if(document.form_darah.kode[it-1].value==''||document.form_darah.jenis[it-1].value==''||document.form_darah.jumlah[it-1].value==''){
				alert('masih ada data yang kosong');
				return false;
			}
		}
	}
	
	var cdata='';
	var ctemp='';
	if (document.form_darah.idkode.length > 1){
		for (var i=0;i<document.form_darah.idkode.length;i++){
			temp=document.form_darah.idkode[i].value+'|'+document.form_darah.idgoldar[i].value+'|'+document.form_darah.idresus[i].value+'|'+document.form_darah.biaya[i].value+'|'+document.form_darah.jumlah[i].value+'|'+document.form_darah.b_umum[i].value+'|'+document.form_darah.id_pr[i].value+"**";
			ctemp=ctemp+temp;
		}
		cdata=ctemp;
		document.getElementById('fdata').value=cdata;
	}
	else if(document.form_darah.idkode.length==undefined){
		temp=document.form_darah.idkode.value+'|'+document.form_darah.idgoldar.value+'|'+document.form_darah.idresus.value+'|'+document.form_darah.biaya.value+'|'+document.form_darah.jumlah.value+'|'+document.form_darah.b_umum.value+'|'+document.form_darah.id_pr.value+"**";
		document.getElementById('fdata').value=temp;
	}
	Request('minta_no_permintaan_darah.php','temp_no_minta','','GET',proses_minta_darah(aksi),'NoLoad');
}

var glob_no_minta = '';
function proses_minta_darah(aksi){
	var idkunjungan = getIdKunj;
	var idpelayanan = getIdPel;
	var tgl = document.getElementById('tgl').value;
	
	var no_minta;
	if(aksi=='tambah'){
		no_minta = document.getElementById('temp_no_minta').innerHTML;
	}
	else {
		no_minta = document.getElementById('no_bukti').value;
	}
	glob_no_minta=no_minta;
	
	var id_dokter = document.getElementById('id_dokter').value;
	var sifat = document.getElementById('sifat').value;
	var tggl = document.getElementById('tggl').value;
	var jam = document.getElementById('jam').value;
	var fdata = document.getElementById('fdata').value;
	//Request('minta_darah_util.php?act=tambah&idkunjungan='+idkunjungan+'&idpelayanan='+idpelayanan+'&idkso='+getKsoId+'&tgl='+tgl+'&no_minta='+no_minta+'&id_dokter='+id_dokter+'&sifat='+sifat+'&fdata='+fdata,'DapatDarah','','GET');
	//alert('minta_darah_util.php?act='+aksi+'&idkunjungan='+idkunjungan+'&idpelayanan='+idpelayanan+'&idkso='+getKsoId+'&tgl='+tgl+'&no_minta='+no_minta+'&id_dokter='+id_dokter+'&sifat='+sifat+'&tggl='+tggl+'&jam='+jam+'&fdata='+fdata);
	md.loadURL('minta_darah_util.php?act='+aksi+'&idkunjungan='+idkunjungan+'&idpelayanan='+idpelayanan+'&idkso='+getKsoId+'&tgl='+tgl+'&no_minta='+no_minta+'&id_dokter='+id_dokter+'&sifat='+sifat+'&tggl='+tggl+'&jam='+jam+'&fdata='+fdata,'','GET');
	batall();
	document.getElementById('btCetak').disabled=false;	//alert('minta_darah_util.php?act=tambah&idkunjungan='+idkunjungan+'&idpelayanan='+idpelayanan+'&idkso='+getKsoId+'&tgl='+tgl+'&no_minta='+no_minta+'&id_dokter='+id_dokter+'&sifat='+sifat+'&fdata='+fdata);
	//window.open('../../bank_darah/bd/permintaan_darah_untuk_transfusi.php?idpel='+idpelayanan+'&idkunj='+idkunjungan);
	md.loadURL('minta_darah_util.php?idpelayanan='+idpelayanan,'','GET');
}

function cetakPermintaanDarah(){
	var idkunjungan = getIdKunj;
	var idpelayanan = getIdPel;
	window.open('../../bank_darah/bd/permintaan_darah_untuk_transfusi.php?idpel='+idpelayanan+'&idkunj='+idkunjungan+'&no_minta='+glob_no_minta);
}


md=new DSGridObject("gbMintaDarah");
md.setHeader("PERMINTAAN DARAH");
md.setColHeader("NO,TGL,NO PERMINTAAN,KODE,JENIS,JUMLAH");
md.setIDColHeader(",,,,,");
md.setColWidth("30,80,150,50,150,50");
md.setCellAlign("center,center,left,left,left,center");
md.setCellHeight(20);
md.setImgPath("../icon");
md.setIDPaging("pagingMD");
md.attachEvent("onRowClick","ambilMD");
md.baseURL("minta_darah_util.php?idpelayanan=0");
md.Init();


function ambilMD(){
	var ids = md.getRowId(md.getSelRow()).split("|");
	document.getElementById('id_pr').value = ids[0];
	document.getElementById('idkode').value = ids[1];
	document.getElementById('idgoldar').value = ids[2];
	document.getElementById('idresus').value = ids[3];
	if(getKsoId==4 || getKsoId==6){
		document.getElementById('t_biaya').value = ids[6];
	}
	else{
		document.getElementById('t_biaya').value = ids[5];
	}
	document.getElementById('jumlah').value = md.cellsGetValue(md.getSelRow(),6);
	document.getElementById('biaya').value = document.getElementById('t_biaya').value * document.getElementById('jumlah').value;
	document.form_darah.tgl.value = md.cellsGetValue(md.getSelRow(),2);
	document.form_darah.no_bukti.value = md.cellsGetValue(md.getSelRow(),3);
	glob_no_minta = md.cellsGetValue(md.getSelRow(),3);
	document.form_darah.id_dokter.value = ids[8];
	document.form_darah.sifat.value = ids[7];
	document.form_darah.kode.value = md.cellsGetValue(md.getSelRow(),4);
	document.form_darah.jenis.value = md.cellsGetValue(md.getSelRow(),5);
	//document.form_darah.gol.value = md.cellsGetValue(md.getSelRow(),6);
	//document.form_darah.resus.value = md.cellsGetValue(md.getSelRow(),7);
	document.form_darah.b_umum.value=ids[5];
	document.form_darah.b_askes.value=ids[6];
	//var dosis = grdRM.cellsGetValue(grdRM.getSelRow(),2);
	
	document.getElementById('btHapus').disabled=false;
	document.getElementById('btSimpan').value = 'update';
	document.getElementById('btSimpan').innerHTML='<img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Update';
    document.getElementById('btHapus').innerHTML='<img src="../icon/delete.gif" align="absmiddle" width="20"  />&nbsp;&nbsp;Hapus';
}

function batall(){
	if (document.form_darah.idkode.length > 1){
		for(var i=document.form_darah.idkode.length;i>=2;i--){			
			var del=i+1;
			var tbl=document.getElementById('tblJual');
			tbl.deleteRow(del);
		}
	}
	document.getElementById('idkode').value = '';
	document.getElementById('idgoldar').value = '';
	document.getElementById('idresus').value = '';
	document.getElementById('t_biaya').value = '';
	document.getElementById('jumlah').value = '';
	document.getElementById('biaya').value = '';
	document.form_darah.tgl.value = '<?php echo date('d-m-Y'); ?>';
	document.form_darah.no_bukti.value = document.getElementById('temp_no_minta').innerHTML;
	document.form_darah.kode.value = '';
	document.form_darah.jenis.value = '';
	document.form_darah.gol.value = '';
	document.form_darah.resus.value = '';
	document.form_darah.b_umum.value='';
	document.form_darah.b_askes.value='';
	
	document.getElementById('btHapus').disabled=true;
	document.getElementById('btSimpan').value = 'tambah';
	document.getElementById('btSimpan').innerHTML='<img src="../icon/add.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Simpan';
    document.getElementById('btHapus').innerHTML='<img src="../icon/delete2.gif" align="absmiddle" width="20"  />&nbsp;&nbsp;Hapus';
}

function hapuss(){
	var id=document.getElementById('id_pr').value;
	if(document.getElementById('id_pr').value=='' || document.getElementById('id_pr').value==null){
		alert("Pilih data yang akan dihapus terlebih dahulu.. !")
	}else{
		if(confirm("Apakah anda yakin ingin menghapus data ini ?")){
			md.loadURL("minta_darah_util.php?act=hapus&id="+id+"idpelayanan="+getIdPel,"","GET");
			md.loadURL("minta_darah_util.php?idpelayanan="+getIdPel,"","GET");
		}
	}
	batall();
}

//========================tambahan raga=====================
	c=new DSGridObject("gridboxRujukUnit");
	c.setHeader("DATA RUJUK UNIT");
	c.setColHeader("NO,TGL,UNIT,DOKTER,KETERANGAN");
	c.setIDColHeader(",,unit,dokter,");
	c.setColWidth("30,80,100,200,150");
	c.setCellAlign("center,center,left,left,left,left");
	c.setCellHeight(20);
	c.setImgPath("../icon");
	c.onLoaded(konfirmasi);
	//c.setIDPaging("pagingRujukUnit");
	c.attachEvent("onRowClick","ambilDataRujukUnit");
	c.baseURL("tindiag_utils.php?grd2=true&kunjungan_id=0&unitAsal=0");
	//c.baseURL("tindiag_utils.php?grd2=true&kunjungan_id="+getIdKunj+"&unitAsal="+getIdUnit);
	//pasienId="+getIdPasien
	c.Init();

	d=new DSGridObject("gridboxRujukRS");
	d.setHeader("DATA KELUAR RUMAH SAKIT");
	d.setColHeader("NO,TANGGAL,CARA KELUAR,KEADAAN KELUAR,KASUS,RUMAH SAKIT,DOKTER,EMERGENCY,KONDISI PASIEN,KETERANGAN");
	d.setIDColHeader(",,cara_keluar,keadaan_keluar,kasus,rs,dokter,");
	d.setColWidth("30,80,100,150,70,200,150,150,100,100");
	d.setCellAlign("center,center,center,center,left,left,left,center,center,left");
	d.setCellHeight(20);
	d.setImgPath("../icon");
	d.onLoaded(konfirmasi);
	//d.setIDPaging("pagingRujukRS");
	d.attachEvent("onRowClick","ambilDataRujukRS");
	//alert("tindiag_utils.php?grd3=true&kunjungan_id="+getIdKunj);
	d.baseURL("tindiag_utils.php?grd3=true&kunjungan_id=0");
	//d.baseURL("tindiag_utils.php?grd3=true&kunjungan_id="+getIdKunj);
	d.Init();

	e=new DSGridObject("gridboxKamar");
	e.setHeader("DATA SET KAMAR");
	e.setColHeader("NO,TGL MASUK,TGL KELUAR,KAMAR,BIAYA");
	e.setIDColHeader(",tgl_in,tgl_out,nama,");
	e.setColWidth("30,150,150,100,100");
	e.setCellAlign("center,center,center,left,right");
	e.setCellHeight(20);
	e.setImgPath("../icon");
	e.onLoaded(konfirmasi);
	//d.setIDPaging("pagingRujukRS");
	e.attachEvent("onRowClick","ambilDataKamar");
	//e.baseURL("tindiag_utils.php?grd4=true&kunjungan_id="+getIdKunj+"&unit_id="+getIdUnit);
	e.baseURL("tindiag_utils.php?grd4=true&kunjungan_id=0&unit_id=0");
	e.Init();
	
	anam=new DSGridObject("gridboxAnamnesa");
	anam.setHeader("DATA ANAMNESA");
	anam.setColHeader("NO,TANGGAL,DOKTER");
	anam.setIDColHeader(",TGL,");
	anam.setColWidth("30,100,350");
	anam.setCellAlign("center,center,left");
	anam.setCellHeight(20);
	anam.setImgPath("../icon");
	anam.onLoaded(konfirmasi);
	anam.setIDPaging("pagingAnamnesa");
	anam.attachEvent("onRowClick","ambilDataAnamnesa");
	anam.baseURL("tindiag_utils.php?grdAnamnesa=true&pasien_id="+getIdPasien);
	anam.Init();
	
	var RowIdxObat2;
	function suggestObat_bhp(e,par){
		var id_unit = document.getElementById('cmbTmpLay').value;
		var keywords=par.value;
		if(keywords==""){
			document.getElementById('divobat_bhp').style.display='none';
		}
		else{
			if(par.value.length > 1){
				var key;
				if(window.event) {
					key = window.event.keyCode;
				}
				else if(e.which) {
					key = e.which;
				}
				//alert(key);
				if (key==38 || key==40){
					var tblRow=document.getElementById('tblObat').rows.length;
					if (tblRow>0){
						//alert(RowIdx);
						if (key==38 && RowIdxObat2>0){
							RowIdxObat2=RowIdxObat2-1;
							document.getElementById(RowIdxObat2+1).className='itemtableReq';
							if (RowIdxObat2>0) document.getElementById(RowIdxObat2).className='itemtableMOverReq';
						}
						else if (key == 40 && RowIdxObat2 < tblRow){
							RowIdxObat2=RowIdxObat2+1;
							if (RowIdxObat2>1) document.getElementById(RowIdxObat2-1).className='itemtableReq';
							document.getElementById(RowIdxObat2).className='itemtableMOverReq';
						}
					}
				}
				else if (key==13){
					if (RowIdxObat2>0){
						if (fKeyEntObat==false){
							fSetObat(document.getElementById(RowIdxObat2).lang);
						}
						else{
							fKeyEntObat=false;
						}
					}
				}
				else if (key!=27 && key!=37 && key!=39){
					fKeyEntObat=false;
					if (key==123){
						RowIdxObat2=0;
						Request('obatlist_bhp.php?id_unit='+id_unit+'&aKeyword='+keywords, 'divobat_bhp', '', 'GET' );
					}
					else if (key==120){
						//alert(RowIdxObat2);
					}
					else{
						RowIdxObat2=0;
						Request('obatlist_bhp.php?id_unit='+id_unit+'&aKeyword='+keywords, 'divobat_bhp', '', 'GET' );
					}
					if (document.getElementById('divobat_bhp').style.display=='none')
						document.getElementById('divobat_bhp').style.top='305px';
						//fSetPosisi(document.getElementById('divobat_bhp'),par);
					document.getElementById('divobat_bhp').style.display='block';
					/* RowIdxObat2=0;
								fKeyEntObat=false;
								//alert('obatlist.php?aKeyword='+keywords+'&idapotek='+document.getElementById('cmbApotek').value);
								Request('obatlist.php?aKeyword='+keywords+'&idapotek='+document.getElementById('cmbApotek').value+'&kepemilikanId='+getKepemilikan, 'divobat_bhp', '', 'GET' );
								if (document.getElementById('divobat_bhp').style.display=='none') fSetPosisi(document.getElementById('divobat_bhp'),par);
								document.getElementById('divobat_bhp').style.display='block'; */
				}
			}
		}
	}
	
	function fSetObat_bhp(par){//menampilkan obat/bahan
		var id_unit = document.getElementById('cmbTmpLay').value;
		var data_bhp=par.split("*|*");
		document.getElementById("penerimaan_id_bhp").value = data_bhp[1];
		document.getElementById("obat_id_bhp").value = data_bhp[2];
		document.getElementById("unit_id_terima_bhp").value = data_bhp[3];
		document.getElementById("kepemilikan_id_bhp").value = data_bhp[11];
		document.getElementById("nama_bahan").value = data_bhp[4];
		//document.getElementById("kepemilikan_id_bhp").value = getKepemilikan;
		document.getElementById("unit_id_bhp").value = getIdUnit;
		
		document.getElementById("kso_id_bhp").value = getKsoId;
		document.getElementById("pelayanan_id_bhp").value = getIdPel;
		document.getElementById("no_pas").value = document.getElementById("txtNo").value;
		document.getElementById("nama_pas").value = document.getElementById("txtNama").value;
		document.getElementById("alamat_pas").value = document.getElementById("txtAlmt").value;
		document.getElementById("h_satuan").value = data_bhp[9];
		//var totalnya = parseFloat(data_bhp[8])*parseFloat(data_bhp[9]);
		//document.getElementById("h_total").value = totalnya;
		document.getElementById("user_act_bhp").value = <?=$userId;?>
		
		
		document.getElementById('divobat_bhp').style.display='none';
		//alert(document.getElementById("statusPx").value);
//		document.getElementById('btnSimpanResep').focus();
	}
	function simpan_bhp(act){
		var nama_bahan = document.getElementById("nama_bahan").value;
		var penerimaan_id_bhp = document.getElementById("penerimaan_id_bhp").value;
		var obat_id_bhp = document.getElementById("obat_id_bhp").value;
		var unit_id_terima_bhp = document.getElementById("unit_id_terima_bhp").value;
		var kepemilikan_id_bhp = document.getElementById("kepemilikan_id_bhp").value
		var unit_id_bhp = document.getElementById("unit_id_bhp").value;
		var kso_id_bhp = document.getElementById("kso_id_bhp").value;
		var tggl_bhp = document.getElementById("tggl_bhp").value;
		//var tggl_act_bhp = document.getElementById("tggl_act_bhp").value;
		var pelayanan_id_bhp = document.getElementById("pelayanan_id_bhp").value;
		var no_pas = document.getElementById("no_pas").value;
		var nama_pas = document.getElementById("nama_pas").value;
		var alamat_pas = document.getElementById("alamat_pas").value;   
		var jumlah_bhp = document.getElementById("jumlah_bhp").value;
		var h_satuan = document.getElementById("h_satuan").value;
		//var h_total = document.getElementById("h_total").value;
		var keterangan_bhp = document.getElementById("keterangan_bhp").value;
		var user_act_bhp = document.getElementById("user_act_bhp").value;
		var status_bhp = document.getElementById("status_bhp").value;
		if(nama_bahan=="" || jumlah_bhp=="")
		{
			alert('Pengisian Form Kurang Lengkap !');
		}
		else
		{
			if(act=='Tambah')
			{
				var url_bhp = "bhp_utils.php?act="+act+"&penerimaan_id_bhp="+penerimaan_id_bhp+"&obat_id_bhp="+obat_id_bhp+"&kepemilikan_id_bhp="+kepemilikan_id_bhp+"&unit_id_bhp="+unit_id_bhp+"&kso_id_bhp="+kso_id_bhp+"&tggl_bhp="+tggl_bhp+"&pelayanan_id_bhp="+pelayanan_id_bhp+"&no_pas="+no_pas+"&nama_pas="+nama_pas+"&alamat_pas="+alamat_pas+"&jumlah_bhp="+jumlah_bhp+"&h_satuan="+h_satuan+"&keterangan_bhp="+keterangan_bhp+"&user_act_bhp="+user_act_bhp+"&status_bhp="+status_bhp+"&unit_id_terima_bhp="+unit_id_terima_bhp+"&pelayanan_id_bhp="+getIdPel;
			}
			if(act=='Update')
			{
				var id_bhp = document.getElementById("id_bhp").value;
				var url_bhp = "bhp_utils.php?act="+act+"&id_bhp="+id_bhp+"&penerimaan_id_bhp="+penerimaan_id_bhp+"&obat_id_bhp="+obat_id_bhp+"&kepemilikan_id_bhp="+kepemilikan_id_bhp+"&jumlah_bhp="+jumlah_bhp+"&h_satuan="+h_satuan+"&keterangan_bhp="+keterangan_bhp+"&user_act_bhp="+user_act_bhp+"&status_bhp="+status_bhp+"&pelayanan_id_bhp="+getIdPel;
			}
		}
		//alert(url_bhp);
		bhp.loadURL(url_bhp,"","GET");
		batal_bhp()
	}
		
		function ambil_bhp(){//alert(bhp.getRowId(bhp.getSelRow()));
		var sisip=bhp.getRowId(bhp.getSelRow()).split("|");
		var id = sisip[0];
		
			document.getElementById("btnSimpan_bhp").value = 'Update';
			document.getElementById("btnHapus_bhp").disabled = false;
			
			document.getElementById("id_bhp").value = sisip[0];
			document.getElementById("penerimaan_id_bhp").value = sisip[1];
			document.getElementById("obat_id_bhp").value = sisip[2];
			document.getElementById("kepemilikan_id_bhp").value = sisip[3];
			document.getElementById("user_act_bhp").value = sisip[4];
			if(sisip[5]=='1')
			{
				document.getElementById("status_bhp").checked = true;
				document.getElementById("status_bhp").value = '1';
			}
			else
			{
				document.getElementById("status_bhp").checked = false;
				document.getElementById("status_bhp").value = '0';
			}
			document.getElementById("h_satuan").value = sisip[6];
			//document.getElementById("nama_bahan").readOnly = true;
			document.getElementById("nama_bahan").disabled = true;
			document.getElementById("nama_bahan").value = bhp.cellsGetValue(bhp.getSelRow(),3);
			document.getElementById("jumlah_bhp").value = bhp.cellsGetValue(bhp.getSelRow(),5);
			document.getElementById("keterangan_bhp").value = bhp.cellsGetValue(bhp.getSelRow(),6);
		}
		
		function batal_bhp(){
			document.getElementById("btnSimpan_bhp").value = 'Tambah';
			document.getElementById("btnHapus_bhp").disabled = true;
			
			document.getElementById("id_bhp").value = '';
			document.getElementById("penerimaan_id_bhp").value = '';
			document.getElementById("obat_id_bhp").value = '';
			document.getElementById("kepemilikan_id_bhp").value = '';
			document.getElementById("user_act_bhp").value = '';
			document.getElementById("nama_bahan").value = '';
			document.getElementById("h_satuan").value = '';
			document.getElementById("jumlah_bhp").value = '';
			document.getElementById("keterangan_bhp").value = '';
			document.getElementById("status_bhp").value = '0';
			document.getElementById("status_bhp").checked = false;
			document.getElementById("nama_bahan").disabled = false;
		}
		
		function hapus_bhp(act){
		var id_bhp = document.getElementById("id_bhp").value;
		var url_bhp = "bhp_utils.php?pelayanan_id_bhp="+getIdPel+"&act="+act+"&id_bhp="+id_bhp;
			//alert(url_bhp);
			bhp.loadURL(url_bhp,"","GET");
			batal_bhp();
		}
		
		function ganti_status_bhp(val)
		{
			if(val=='0')
			{
				document.getElementById("status_bhp").value = '1';
			}
			if(val=='1')
			{
				document.getElementById("status_bhp").value = '0';
			}
		}
		
// penambahan hasil lab
	function suggestHsl(e,par){
		var keywords=par.value;//alert(keywords);
		if(keywords=="" || keywords.length<3){
			document.getElementById('divtindakanHsl').style.display='none';
		}else{
			var key;
			if(window.event) {
				key = window.event.keyCode;
			}
			else if(e.which) {
				key = e.which;
			}
			//alert(key);
			if (key==38 || key==40){
				var tblRow=document.getElementById('tblTindakanHsl').rows.length;
				if (tblRow>0){
					//alert(RowIdx1);
					if (key==38 && RowIdx1>0){
						RowIdx1=RowIdx1-1;
						document.getElementById('lstTindHsl'+(RowIdx1+1)).className='itemtableReq';
						if (RowIdx1>0) document.getElementById('lstTindHsl'+RowIdx1).className='itemtableMOverReq';
					}
					else if (key == 40 && RowIdx1 < tblRow){
						RowIdx1=RowIdx1+1;
						if (RowIdx1>1) document.getElementById('lstTindHsl'+(RowIdx1-1)).className='itemtableReq';
						document.getElementById('lstTindHsl'+RowIdx1).className='itemtableMOverReq';
					}
				}
			}else if (key==13){
				//alert('masuk tindakan');
				if (RowIdx1>0){
					if (fKeyEnt1==false){
						fSetHsl(document.getElementById('lstTindHsl'+RowIdx1).lang);
					}
					else{
						fKeyEnt1=false;
					}
				}
			}else if (key!=27 && key!=37 && key!=39){
				RowIdx1=0;
				fKeyEnt1=false;
				var all=0;
				if(key==123){
					all=1;
				}
				//alert("tindakanlist_lab.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&pelayananId="+getIdPel+"lp="+document.getElementById('txtSex').value);
				//alert("tindakanlist.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&kelasId="+getIdKelas+"&unitId="+((document.getElementById('chkTind').checked==true)?document.getElementById('tmpLay').value:unitId));
				Request("tindakanlist_lab.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&pelayananId="+getIdPel+"&lp="+document.getElementById('txtSex').value, 'divtindakanHsl', '', 'GET');
				if (document.getElementById('divtindakanHsl').style.display=='none')
					fSetPosisi(document.getElementById('divtindakanHsl'),par);
				document.getElementById('divtindakanHsl').style.display='block';
			}
		}
	}
	
	function fSetHsl(par){
		var cdata=par.split("|");
		document.getElementById("idNormal").value=cdata[0];
		document.getElementById("tindakan_id_hsl").value=cdata[1];
		document.getElementById("txtTind_hsl").value=cdata[2];
		document.getElementById("normal").innerHTML=cdata[3];
		document.getElementById('divtindakanHsl').style.display='none';
		
	}
	
	function cetakHslLabRad(){
		if (document.getElementById('ctkLabRadPerKonsul').value=="HASIL LAB"){
			cetakHsl();
		}else if (document.getElementById('ctkLabRadPerKonsul').value=="HASIL RAD"){
			cetakHasilRadAll();
		}
	}
	
	function cetakHsl(){
		window.open('hasil_laborat.php?idKunj='+getIdKunj+'&idPel='+getIdPel,'_blank');
	}
	
	function batalHsl(){
		var idTindHsl = document.getElementById("idTindHsl").value="";
		var tindakan_id_hsl = document.getElementById("tindakan_id_hsl").value="";
		var txtHsl = document.getElementById("txtHsl").value="";
		var txtKetHsl = document.getElementById("txtKetHsl").value="";
		var cmbDokHsl = document.getElementById("cmbDokHsl").selectedIndex="";
		var normal = document.getElementById("idNormal").value="";
		document.getElementById("normal").innerHTML="";
		document.getElementById("txtTind_hsl").value="";
		document.getElementById("btnSimpanHsl").value="Tambah";
		//document.getElementById("btnHapusHsl").style.disabled=false;
		var p= "btnHapusHsl*-*true";
		fSetValue(window,p);
	}
	
	function ambilDataHsl()
	{
		var sisip = lab.getRowId(lab.getSelRow()).split("|");
		//alert(sisip);
		batalHsl();
		document.getElementById("idTindHsl").value=sisip[0];
		document.getElementById("tindakan_id_hsl").value=sisip[3];
		document.getElementById("txtHsl").value=sisip[2];
		document.getElementById("txtKetHsl").value=sisip[7];
		document.getElementById("cmbDokHsl").value=sisip[6];
		document.getElementById("idNormal").value=sisip[4];
		document.getElementById("normal").innerHTML=sisip[5];
		document.getElementById("txtTind_hsl").value=sisip[1];
		//btnSimpanTind*-*Simpan*|*btnHapusTind*-*false;
		document.getElementById("btnSimpanHsl").value="Simpan";
		//document.getElementById("btnHapusHsl").style.disabled=false;
		var p= "btnHapusHsl*-*false";
		fSetValue(window,p);
	}
	
	function showgrid2(){
		//alert('sip');
		//showgrid();
		//isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'','cmbDokHsl');
	}
	
	var actTree;
	function loadtree(p,act,par)
	{		
		var a=p.split("*-*");
		//alert(a[0]+'act='+act+'&par='+par+'&gid='+document.getElementById(a[2]).value);
		if(act=='Tambah' || act=='Simpan' || act=='Hapus'){
			actTree=act;
			Request ( a[0]+'act='+act+'&par='+par+'&gid='+document.getElementById(a[2]).value+a[3]+'&cnt='+a[4] , a[1], '', 'GET',berhasil,'no');
		}
		else{			
			Request ( a[0]+'act='+act+'&par='+par+'&gid='+document.getElementById(a[2]).value+a[3]+'&cnt='+a[4] , a[1], '', 'GET');
			//isiCombo('cmbGroup','','','cmbGroup');
		}
	}
	
	function berhasil(){
		batalSetting();		
		alert(actTree+' Berhasil!');
	}
	
	function cetakHasilLabAll(){
		window.open('hasil_laborat_all.php?idKunj='+getIdKunj+'&idPel='+getIdPel,'_blank');
	}
	
	function cetakHasilRadAll(){
		window.open('hasil_radiologi_all.php?idKunj='+getIdKunj+'&idPel='+getIdPel,'_blank');
	}
	
	
	
	function cekPenyebabKecelakaan(){
		//batal('btnBatalDiag');
		var p="diagnosa_id*-**|*txtDiag*-**|*btnSimpanDiag*-*Tambah*|*btnSimpanDiag*-*false*|*btnHapusDiag*-*true";
		fSetValue(window,p);
		//document.getElementById('chkPenyebabKecelakaan').checked='';
		//document.getElementById('trPenyebab').style.display='none';
		document.getElementById('chkAkhir').checked='';
		
		if(document.getElementById('chkPenyebabKecelakaan').checked){
			//document.getElementById('trPrioritas').style.display = 'none';
			//document.getElementById('trDiagnosaAkhir').style.display = 'none';
			//document.getElementById('trPenyebab').style.display = 'table-row';
		}
		else{
			//document.getElementById('trPrioritas').style.display = 'table-row';
			//document.getElementById('trDiagnosaAkhir').style.display = 'table-row';
			document.getElementById('trPenyebab').style.display = 'none';
		}
	}
	
	function hapus_foto_radiologi(a,b){
		if(b==1){ // 1=insert lagi
			Request('act_radiologi.php?act=delete&id='+a,'temp_rad','','GET',insertRadLagi(a),'noload');
		}
		else{
			Request('act_radiologi.php?act=delete&id='+a,'temp_rad','','GET');
		}
	}
	
	function insertRadLagi(a){
		var userId='<?php echo $_SESSION['userId']?>';
		tambahRadiologi = true;
		document.getElementById('frameRad').contentWindow.aplod('add',a,userId);
	}
	
	function afterRad(str){
		alert(str);
		document.getElementById("id_hasil_rad").value="";
		document.getElementById("txtHslRad").value="";
		document.getElementById("cmbDokHslRad").selectedIndex="";
		document.getElementById("btnSimpanHslRad").value="Tambah";
		var p= "btnHapusHslRad*-*true";
		fSetValue(window,p);
		rad.loadURL("hasilRad_utils.php?grd=true&pelayanan_id="+getIdPel,"","GET");
	}
	
	function simpan_tanpa_gambar(act){
		var userId='<?php echo $_SESSION['userId']?>';		
		var id = document.getElementById("id_hasil_rad").value;
		var txtHslRad = document.getElementById("txtHslRad").value;
		var cmbDokHsl = document.getElementById("cmbDokHslRad").value;
     						
		rad.loadURL("hasilRad_utils.php?grd=true&smpn=btnSimpanHslRad&pelayanan_id="+getIdPel+"&act="+act+"&id="+id+"&txtHslRad="+txtHslRad+"&cmbDokHsl="+cmbDokHsl+"&userId="+userId,"","GET");
	}
	
	function ReportRm(no)
	{
		var noRM = document.getElementById("txtNo").value;
		var nama = document.getElementById("txtNama").value;
		var umur = document.getElementById("txtUmur").value;
		var sex = document.getElementById("txtSex").value;
		var alamat = document.getElementById("txtAlmt").value;
		var tgl = document.getElementById("txtTglLhr").value;
		var kamar = document.getElementById("txtPelUnit").value;
		//alert(getKelas_id);
		
		var tambahan = "nama="+nama+"&umur="+umur+"&sex="+sex+"&alamat="+alamat+"&noRM="+noRM+"&tgl="+tgl+"&kamar="+kamar+"&kelas_id="+getKelas_id;
		//alert(tambahan);
		if(no==1)
		{
			var url = '../report_rm/1.inform_konsen.php?'+tambahan; 
		}
		else if(no==2)
		{
			var url = '../report_rm/2.APS.php?'+tambahan;
		}
		else if(no==3)
		{
			var url = '../report_rm/3.ctt_asuhan_gizi.php?'+tambahan; 
		}
		else if(no==4)
		{
			var url = '../report_rm/4.srt_kenal_lahir.php?'+tambahan; 
		}
		else if(no==5)
		{
			var url = '../report_rm/5.monitpring_ESO.php?'+tambahan; 
		}
		else if(no==6)
		{
			var url = '../report_rm/6.check_list_cath.php?'+tambahan; 
		}
		else if(no==7)
		{
			var url = '../report_rm/7.rujukan.php?'+tambahan; 
		}
		else if(no==8)
		{
			var url = '../report_rm/8.rencana_harian.php?'+tambahan;
		}
		else if(no==9)
		{
			var url = '../report_rm/9.check_list_pnrmn.php?'+tambahan; 
		}
		else if(no==10)
		{
			var url = '../report_rm/10.lap_kejadian.php?'+tambahan; 
		}
		else if(no==11)
		{
			var url = '../report_rm/11.pesanan_post.php?'+tambahan; 
		}
		else if(no==12)
		{
			var url = '../report_rm/12.persetujuan_transfusi.php?'+tambahan; 
		}
		else if(no==13)
		{
			var url = '../report_rm/13. checklist_pengkajian_kep.php?'+tambahan; 
		}
		else if(no==14)
		{
			var url = '../report_rm/14.resume_kep.php?'+tambahan; 
		}
		else if(no==15)
		{
			var url = '../report_rm/15.rekam_medis.php?'+tambahan; 
		}
		else if(no==16)
		{
			var url = '../report_rm/16.Chart_ICU.php?'+tambahan; 
		}
		else 
		{
			var url = '../report_rm/17.obs_harian_bayi.php?'+tambahan; 
		}
		//alert(url);
		window.open(url);
	}
	
	function saveAnamnesa(aksinya){
		
	   var KUNJ_ID=getIdKunj;
	   var PEL_ID=getIdPel;
	   var PEGAWAI_ID=document.getElementById('cmbDokAnamnesa').value;
	   var KU=document.getElementById('txtKU').value;
	   var SOS=document.getElementById('txtAS').value;
	   var RPS=document.getElementById('txtRPS').value
	   var RPD=document.getElementById('txtRPD').value;
	   var RPK=document.getElementById('txtRPK').value;
	   var KUM=document.getElementById('txtKUM').value;
	   var RA=document.getElementById('txtRA').value;
	   var GCS=document.getElementById('txtGCS').value;
	   var KESADARAN=document.getElementById('cmbKesadaran').value;
	   var TENSI=document.getElementById('txtTensi').value;
	   var RR=document.getElementById('txtRR').value;
	   var NADI=document.getElementById('txtNadi').value;
	   var SUHU=document.getElementById('txtSuhu').value;
	   var BB=document.getElementById('txtBB').value;
	   var GIZI=document.getElementById('cmbStatusGizi').value;
	   
	   
	    var ar_cmbKepalaLeher = anamnesa_kepala_leher.multiselect("getChecked").map(function(){return this.value;}).get();
		var ar_cmbCor = anamnesa_cor.multiselect("getChecked").map(function(){return this.value;}).get();
	   	var ar_cmbPulmo = anamnesa_pulmo.multiselect("getChecked").map(function(){return this.value;}).get();
	   	var ar_cmbInspeksi = anamnesa_inspeksi.multiselect("getChecked").map(function(){return this.value;}).get();
	   	var ar_cmbPalpasi = anamnesa_palpasi.multiselect("getChecked").map(function(){return this.value;}).get();
	   	var ar_cmbAuskultasi = anamnesa_auskultasi.multiselect("getChecked").map(function(){return this.value;}).get();
	    var ar_cmbPerkusi = anamnesa_perkusi.multiselect("getChecked").map(function(){return this.value;}).get();
	    var ar_cmbEkstremitas = anamnesa_ekstremitas.multiselect("getChecked").map(function(){return this.value;}).get();
	   
		var url = 'tindiag_utils.php?id_anamnesa='+document.getElementById('id_anamnesa').value+'&KUNJ_ID='+KUNJ_ID+'&PEL_ID='+PEL_ID+'&PASIEN_ID='+getIdPasien+'&PEGAWAI_ID='+PEGAWAI_ID+'&KU='+KU+'&SOS='+SOS+'&RPS='+RPS+'&RPD='+RPD+'&RPK='+RPK+'&KUM='+KUM+'&RA='+RA+'&GCS='+GCS+'&KESADARAN='+KESADARAN+'&TENSI='+TENSI+'&+RR='+RR+'&NADI='+NADI+'&SUHU='+SUHU+'&BB='+BB+'&GIZI='+GIZI+'&KL='+ar_cmbKepalaLeher+'&COR='+ar_cmbCor+'&PULMO='+ar_cmbPulmo+'&INSPEKSI='+ar_cmbInspeksi+'&PALPASI='+ar_cmbPalpasi+'&AUSKULTASI='+ar_cmbAuskultasi+'&PERKUSI='+ar_cmbPerkusi+'&EXT='+ar_cmbEkstremitas;
		
		anam.loadURL(url+'&act=data_anamnesa&action='+aksinya+'&grdAnamnesa=true&pasien_id='+getIdPasien,'','GET');
		batalAnamnesa();
	}
	
	function ambilDataAnamnesa(){
		
		document.getElementById('btnSimpanAnamnesa').value='simpan';
		document.getElementById('btnSimpanAnamnesa').innerHTML="<img src='../icon/save.gif' height='16' width='16' style='position:absolute;' /><span style='margin-left:20px;'>Save</span>";
		document.getElementById('btnDeleteAnamnesa').disabled=false;
		
		var sisip=anam.getRowId(anam.getSelRow()).split("|");
		document.getElementById('id_anamnesa').value=sisip[0];
		document.getElementById('cmbDokAnamnesa').value=sisip[4];
		document.getElementById('txtKU').value=sisip[5];
		document.getElementById('txtAS').value=sisip[6];
		document.getElementById('txtRPS').value=sisip[7];
		document.getElementById('txtRPD').value=sisip[8];
		document.getElementById('txtRPK').value=sisip[9];
		document.getElementById('txtRA').value=sisip[10];
		document.getElementById('txtKUM').value=sisip[11];
		document.getElementById('txtGCS').value=sisip[12];
		document.getElementById('cmbKesadaran').value=sisip[13];
		document.getElementById('txtTensi').value=sisip[14];
		document.getElementById('txtRR').value=sisip[15];
		document.getElementById('txtNadi').value=sisip[16];
		document.getElementById('txtSuhu').value=sisip[17];
		document.getElementById('txtBB').value=sisip[18];
		document.getElementById('cmbStatusGizi').value=sisip[19];
		
		anamnesa_kepala_leher.multiselect('uncheckAll');
		anamnesa_cor.multiselect('uncheckAll');
		anamnesa_pulmo.multiselect('uncheckAll');
		anamnesa_inspeksi.multiselect('uncheckAll');
		anamnesa_auskultasi.multiselect('uncheckAll');
		anamnesa_palpasi.multiselect('uncheckAll');
		anamnesa_perkusi.multiselect('uncheckAll');
		anamnesa_ekstremitas.multiselect('uncheckAll');
		
		var dok_KL = sisip[20].split(',');
		for(var i=0; i<dok_KL.length; i++){
			for (x=0;x<document.getElementById('cmbKepalaLeher').length;x++){
				if(document.form_isi_anamnesa.cmbKepalaLeher[x].value==dok_KL[i]){
					document.form_isi_anamnesa.cmbKepalaLeher[x].selected=true;	
				}
			}
		}
		
		var dok_Cor = sisip[21].split(',');
		for(var i=0; i<dok_Cor.length; i++){
			for (x=0;x<document.getElementById('cmbCor').length;x++){
				if(document.form_isi_anamnesa.cmbCor[x].value==dok_Cor[i]){
					document.form_isi_anamnesa.cmbCor[x].selected=true;
				}
			}
		}
		
		var dok_Pulmo = sisip[22].split(',');
		for(var i=0; i<dok_Pulmo.length; i++){
			for (x=0;x<document.getElementById('cmbPulmo').length;x++){
				if(document.form_isi_anamnesa.cmbPulmo[x].value==dok_Pulmo[i]){
					document.form_isi_anamnesa.cmbPulmo[x].selected=true;	
				}
			}
		}
		
		var dok_Inspeksi = sisip[23].split(',');
		for(var i=0; i<dok_Inspeksi.length; i++){
			for (x=0;x<document.getElementById('cmbInspeksi').length;x++){
				if(document.form_isi_anamnesa.cmbInspeksi[x].value==dok_Inspeksi[i]){
					document.form_isi_anamnesa.cmbInspeksi[x].selected=true;	
				}
			}
		}
		
		var dok_Auskultasi = sisip[25].split(',');
		for(var i=0; i<dok_Auskultasi.length; i++){
			for (x=0;x<document.getElementById('cmbAuskultasi').length;x++){
				if(document.form_isi_anamnesa.cmbAuskultasi[x].value==dok_Auskultasi[i]){
					document.form_isi_anamnesa.cmbAuskultasi[x].selected=true;	
				}
			}
		}
		
		var dok_Palpasi = sisip[24].split(',');
		for(var i=0; i<dok_Palpasi.length; i++){
			for (x=0;x<document.getElementById('cmbPalpasi').length;x++){
				if(document.form_isi_anamnesa.cmbPalpasi[x].value==dok_Palpasi[i]){
					document.form_isi_anamnesa.cmbPalpasi[x].selected=true;	
				}
			}
		}
		
		var dok_Perkusi = sisip[26].split(',');
		for(var i=0; i<dok_Perkusi.length; i++){
			for (x=0;x<document.getElementById('cmbPerkusi').length;x++){
				if(document.form_isi_anamnesa.cmbPerkusi[x].value==dok_Perkusi[i]){
					document.form_isi_anamnesa.cmbPerkusi[x].selected=true;	
				}
			}
		}
		
		var dok_Ekstremitas = sisip[27].split(',');
		for(var i=0; i<dok_Ekstremitas.length; i++){
			for (x=0;x<document.getElementById('cmbEkstremitas').length;x++){
				if(document.form_isi_anamnesa.cmbEkstremitas[x].value==dok_Ekstremitas[i]){
					document.form_isi_anamnesa.cmbEkstremitas[x].selected=true;	
				}
			}
		}
		
		anamnesa_kepala_leher.multiselect('refresh');
		anamnesa_cor.multiselect('refresh');
		anamnesa_pulmo.multiselect('refresh');
		anamnesa_inspeksi.multiselect('refresh');
		anamnesa_auskultasi.multiselect('refresh');
		anamnesa_palpasi.multiselect('refresh');
		anamnesa_perkusi.multiselect('refresh');
		anamnesa_ekstremitas.multiselect('refresh');
		
	}
	
	function deleteAnamnesa(){
		anam.loadURL('tindiag_utils.php?act=data_anamnesa&action=hapus&grdAnamnesa=true&pasien_id='+getIdPasien+'&id_anamnesa='+document.getElementById('id_anamnesa').value,'','GET');
		batalAnamnesa();	
	}

	function batalAnamnesa(){
		document.getElementById('btnDeleteAnamnesa').disabled=true;
		document.getElementById('btnSimpanAnamnesa').value='tambah';
		document.getElementById('btnSimpanAnamnesa').innerHTML="<img src='../icon/edit_add.png' height='16' width='16' style='position:absolute;' /><span style='margin-left:20px;'>Add</span>";		
		document.getElementById('id_anamnesa').value = "";
		document.getElementById('cmbDokAnamnesa').value =  "";
		document.getElementById('txtKU').value = "";
		document.getElementById('txtAS').value = "";
		document.getElementById('txtRPS').value = "";
		document.getElementById('txtRPD').value = "";
		document.getElementById('txtRPK').value = "";
		document.getElementById('txtKUM').value = "";
		document.getElementById('txtRA').value = "";
		document.getElementById('txtGCS').value = "";
		document.getElementById('cmbKesadaran').value = "";
		document.getElementById('txtTensi').value = "";
		document.getElementById('txtRR').value = "";
		document.getElementById('txtNadi').value = "";
		document.getElementById('txtSuhu').value = "";
		document.getElementById('txtBB').value = "";
		document.getElementById('cmbStatusGizi').value = "";
		anamnesa_kepala_leher.multiselect('uncheckAll');
		anamnesa_cor.multiselect('uncheckAll');
		anamnesa_pulmo.multiselect('uncheckAll');
		anamnesa_inspeksi.multiselect('uncheckAll');
		anamnesa_auskultasi.multiselect('uncheckAll');
		anamnesa_palpasi.multiselect('uncheckAll');
		anamnesa_perkusi.multiselect('uncheckAll');
		anamnesa_ekstremitas.multiselect('uncheckAll');
	}
	
	</script>
    <script language="JavaScript1.2">mmLoadMenus();</script>
</html>