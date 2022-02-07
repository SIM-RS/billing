<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
include("../koneksi/konek.php");
$user_id=$_SESSION['userId'];
$unit_id=$_SESSION['unitId'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>

        <!--dibawah ini diperlukan untuk menampilkan popup-->
        <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        <script type="text/javascript" src="../theme/prototype.js"></script>
        <script type="text/javascript" src="../theme/effects.js"></script>
        <script type="text/javascript" src="../theme/popup.js"></script>
        <!--diatas ini diperlukan untuk menampilkan popup-->

        <!-- untuk ajax-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <!-- untuk ajax-->

        <title>Form Tindakan</title>
    </head>

    <body>
        <div align="center">
            <?php
            include("../header1.php");
            ?>
        </div>

        <iframe height="72" width="130" name="sort"
                id="sort"
                src="../theme/dsgrid_sort.php" scrolling="no"
                frameborder="0"
                style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
        </iframe>

        <!-- div tindakan-->
        <div align="center" id="div_tindakan">
            <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;FORM TARIF TINDAKAN</td>
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
                    <td align="right">Kode&nbsp;</td>
                    <td>&nbsp;<input size="16" id="txtKode" name="txtKode" class="txtinput" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Tindakan&nbsp;</td>
                    <td>&nbsp;<input size="32" id="txtNama" name="txtNama" class="txtinput" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Kode ICD9CM&nbsp;</td>
                    <td>&nbsp;<input size="16" id="txtICD9cm" name="txtICD9cm" class="txtinput" />&nbsp;<input type="button"  class="btninput" value="..." title="Pilih Induk" onClick="OpenWnd('inacbg_icd9cm.php?par='+document.getElementById('txtICD9cm').value,850,500,'msma',true)"></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Kode ASKES&nbsp;</td>
                    <td>&nbsp;<input size="16" id="txtKodeAskes" name="txtKodeAskes" class="txtinput" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Tindakan ASKES&nbsp;</td>
                    <td>&nbsp;<input size="32" id="txtNamaAskes" name="txtNamaAskes" class="txtinput" /></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right"><a href="javascript:void(0)" onClick="detailRA()">Klasifikasi</a>&nbsp;</td>
                    <td>&nbsp;<select id="cmbKlasi" name="cmbKlasi" onchange="isiCombo('cmbKelTin',this.value);"  class="txtinput"></select></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right"><a href="javascript:void(0)" onClick="detailRB()">Kelompok Tindakan</a>&nbsp;</td>
                    <td>&nbsp;<select id="cmbKelTin" name="cmbKelTin"  class="txtinput" style="width:250px;"></select></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Status&nbsp;</td>
                    <td>&nbsp;<label><input type="checkbox" id="isAktif" name="isAktif" class="txtinput" checked="checked"/>&nbsp;Aktif</label></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;<input id="txtId" type="hidden" name="txtId" /></td>
                    <td height="30">
                        <input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="simpan(this.value);" class="tblTambah"/>
                        <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus"/>
                        <input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <!--Tindakan Unit:&nbsp;
                    <select id="cmbUnit" name="cmbUnit" class="txtinput" onchange="alert('tindakan_utils.php?grd=true&unit='+document.getElementById('cmbUnit').value);">
		<option value="">-ALL UNIT-</option>
                        <?php
                        /*	$rs = mysql_query("SELECT * FROM b_ms_unit unit WHERE unit.islast=1");
            	while($rows=mysql_fetch_array($rs)):
		?>
			<option value="<?=$rows["id"]?>" <?php if($rows["id"]==$unit_id) echo "selected";?>><?=$rows["nama"]?></option>
            <?	endwhile;
                        */
                        ?>
		</select>
                        -->
                    </td>
                    <td>&nbsp;</td>
                    <td align="right"><input type="button" id="btnKelas" class="btninput" value="Set kelas dan Tarif" onclick="goToKelas()"/></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td colspan="3">
                        <div id="gridbox" style="width:925px; height:200px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:925px;"></div>	</td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="30%">&nbsp;</td>
                    <td width="30%">&nbsp;</td>
                    <td width="30%">&nbsp;</td>
                    <td width="5%">&nbsp;</td>
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
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
            <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
                <tr height="30">
                    <td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
                    <td>&nbsp;</td>
                    <td align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" class="btninput" /></a>&nbsp;</td>
                </tr>
            </table>
        </div>
        <!-- end div tindakan-->

        <!-- div kelas -->
        <div align="center" id="div_kelas" style="display:none">
            <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;FORM TARIF TINDAKAN KELAS</td>
                </tr>
            </table>
            <table width="1000" border="0" cellspacing="1" cellpadding="0" align="center" class="tabel">
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="32%">&nbsp;</td>
                    <td width="27%">&nbsp;</td>
                    <td width="5%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="5%">&nbsp;</td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Tindakan&nbsp;</td>
                    <td><span id="tind">&nbsp;</span></td>
                    <td align="right">
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Kelas&nbsp;</td>
                    <td>&nbsp;<select id="cmbKls" name="cmbKls" class="txtinput">
                            <?php
                            $dt = mysql_query("SELECT * FROM b_ms_kelas");
                            while($rw=mysql_fetch_array($dt)):
                                ?>
                            <option value="<?=$rw["id"]?>"><?=$rw["nama"]?></option>
                            <?	endwhile;?>
                        </select></td>
                    <td align="right"></td>
                    <td>&nbsp;</td>
                    <td></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td></td>
                    <td align="right">Setting Tarif :</td>
                    <td>
                        <label><input type="radio" id="chkSetTarif2" name="chkSetTarif" value="1" onchange="getRadioValue(this.name);" checked="checked"/>Nominal</label>
                        <label><input type="radio" id="chkSetTarif1" name="chkSetTarif" value="0" onchange="getRadioValue(this.name);"/>(%) Prosentase</label>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Tarif&nbsp;</td>
                    <td>&nbsp;<input class="txtinput" id="txtTarif" name="txtTarif" size="16" readonly="readonly" value="0" />
                        <input type="button" value="set tarif" onclick="getTarif();" class="tblBtn"/>
                    </td>
                    <td align="right"></td>
                    <td>&nbsp;</td>
                    <td></td>
                    <td>&nbsp;</td>
                </tr>
                <!--tr>
                    <td>&nbsp;</td>
                    <td align="right">Tarif ASKES&nbsp;</td>
                    <td>&nbsp;<input class="txtinput" id="txtTarifAskes" name="txtTarifAskes" size="16" value="0" />
                    </td>
                    <td align="right"></td>
                    <td>&nbsp;</td>
                    <td></td>
                    <td>&nbsp;</td>
                </tr-->
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Kategori&nbsp;</td>
                    <td>&nbsp;<select id="cmbRetriKls" name="cmbRetriKls" class="txtinput">
                            <option value="0">Tindakan</option>
                            <option value="1">Retribusi</option>
                        </select>
                    </td>
                    <td align="right">
                    </td>
                    <td>&nbsp;</td>
                    <td></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Status&nbsp;</td>
                    <td>&nbsp;<label><input type="checkbox" id="isAktifKls" name="isAktifKls" class="txtinput" checked="checked"/>&nbsp;Aktif</label></td>
                    <td align="right">
                    </td>
                    <td>&nbsp;</td>
                    <td></td>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;<input id="txtIdKls" type="hidden" name="txtIdKls" /></td>
                    <td height="30">
                        <input type="button" id="btnSimpanKls" name="btnSimpanKls" value="Tambah" onclick="simpanKelas(this.value);" class="tblTambah"/>
                        <input type="button" id="btnHapusKls" name="btnHapusKls" value="Hapus" onclick="hapusKelas();" disabled="disabled" class="tblHapus"/>
                        <input type="button" id="btnBatalKls" name="btnBatalKls" value="Batal" onclick="batalKelas()" class="tblBatal"/>	</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="left"><input type="button" id="btnKelasKls" class="btninput" value="Kembali" onclick="document.getElementById('div_kelas').style.display='none';document.getElementById('div_tindakan').style.display='block';batalKelas();"/></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td colspan="5" align="center">
                        <div id="gridbox2" style="width:700px; height:200px; background-color:white; overflow:hidden;"></div>
                        <div id="paging2" style="width:700px;"></div>	</td>
                    <td width="5%">&nbsp;</td>
                </tr>
                <tr>
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
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>

        <div id="div_tarif" style="display:none;width:300px" class="popup">
            <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
            <fieldset><legend>Komponen Tarif</legend>
                <table id="komTab" border="0">
                    <tr>
                        <th>komponen</th>
                        <th id="thHarga">harga</th>
                    </tr>
                    <?php
                    $sql3 = "SELECT id,kode,nama,tarip_default,tarip_prosen,aktif FROM b_ms_komponen where aktif=1";
                    $rs3 = mysql_query($sql3);
                    $i=0;
                    while($rw3 = mysql_fetch_array($rs3)) {
                        ?>
                    <tr>
                        <td><label><input type="checkbox" name="chKom" id="<?php echo "komp_".$i?>" value="<?php echo $rw3['id'];?>" onclick="setTarif();"/>
                                    <?php echo $rw3['nama']?></label></td>
                        <td>
                            <input type="text" size="5" readonly="readonly" style="text-align:right;" name="hrgkom" id='<?php echo "hrgkom_".$i;?>' value='<?php echo $rw3['tarip_default']?>' lang='<?php echo $rw3['tarip_default']?>' onblur="this.readOnly=true;" onmouseover="this.title='Tarif default : '+this.lang;" ondblclick="this.readOnly=false;" onkeyup="if(event.which==13){this.readOnly=true;simpanKom('<?php echo $rw3['id'];?>',this.value,document.getElementById('<?php echo "prokom_".$i;?>').value);}"/>
                            <input type="text" size="5" readonly="readonly" style="text-align:right;display:none;" name="prokom" id='<?php echo "prokom_".$i;?>' value='<?php echo $rw3['tarip_prosen']?>' lang='<?php echo $rw3['tarip_prosen']?>' onblur="this.readOnly=true;" onmouseover="this.title='Tarif Prosen : '+this.lang;" ondblclick="this.readOnly=false;" onkeyup="if(event.which==13){this.readOnly=true;simpanKom('<?php echo $rw3['id'];?>',document.getElementById('<?php echo "hrgkom_".$i;?>').value,this.value);}"/>
                        </td>
                    </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </table>
            </fieldset>
        </div>
        	<div id="divRiwayatAlergi" style="display:none; width:500px" class="popup">
            	<?php include("klasifikasi.php"); ?>
            </div>
            <div id="divKelompok" style="display:none; width:500px" class="popup">
            	<?php include("kelompok.php"); ?>
            </div>
    </body>
    <script type="text/JavaScript" language="JavaScript">
	//-----------Tambahan utk PopUp---------------//
	function detailRA(){
		gRA.loadURL('klasifikasi_util.php','','GET');
		new Popup('divRiwayatAlergi',null,{modal:true,position:'center',duration:1});
    	document.getElementById('divRiwayatAlergi').popup.show();	
	}
	
	function closeRA(){
		//Request('klasifikasi_util.php?act=view_last','hsl_RA_terakhir','','GET',loadRATerakhir,'noLoad');
		document.getElementById('divRiwayatAlergi').popup.hide();
		location.reload();
	}
	
	function ganti111()
	{
		gRB.loadURL('kelompok_util.php?klasifikasi='+document.getElementById("klasi").value,'','GET');
	}
	
	function batalRA(){
		document.getElementById('status').checked=false;
		document.getElementById('kode_klasifikasi').value='';
		document.getElementById('txtRiwayatAlergi').value='';
		document.getElementById('id_klasifikasi').value='';
		document.getElementById('btnSimpanRA').value='tambah';
		document.getElementById('btnSimpanRA').innerHTML="<img src='../icon/edit_add.png' height='16' width='16' style='position:absolute;' /><span style='margin-left:20px;'>Add</span>";
		document.getElementById('btnDeleteRA').disabled=true;	
	}
	
	function ambilRA(){
		var sisip=gRA.getRowId(gRA.getSelRow()).split("|");
		var cek = sisip[3];
		if(cek==1){document.getElementById('status').checked=true;}
		else{document.getElementById('status').checked=false;}
		document.getElementById('kode_klasifikasi').value=sisip[2];
		document.getElementById('txtRiwayatAlergi').value=sisip[1];
		document.getElementById('id_klasifikasi').value=sisip[0];
		document.getElementById('btnSimpanRA').value='simpan';
		document.getElementById('btnSimpanRA').innerHTML="<img src='../icon/save.gif' height='16' width='16' style='position:absolute;' /><span style='margin-left:20px;'>Save</span>";
		document.getElementById('btnDeleteRA').disabled=false;	
	}
	
	function deleteRA(){
		var	id_klasifikasi=document.getElementById('id_klasifikasi').value;
		gRA.loadURL('klasifikasi_util.php?act=hapus&id_klasifikasi='+id_klasifikasi,'','GET');
		batalRA();	
	}
	var status;
	function saveRA(act){
		if(document.getElementById('status').checked==true){
		status=1}else{status=0;};
		var kode_klasifikasi=document.getElementById('kode_klasifikasi').value;
		var txtRiwayatAlergi=document.getElementById('txtRiwayatAlergi').value;
		var	id_klasifikasi=document.getElementById('id_klasifikasi').value;
		gRA.loadURL('klasifikasi_util.php?act='+act+'&txtRiwayatAlergi='+txtRiwayatAlergi+'&id_klasifikasi='+id_klasifikasi+'&kode_klasifikasi='+kode_klasifikasi+'&status='+status,'','GET');
		batalRA();
	}
	
	/*function loadRATerakhir(){
		document.getElementById('txtRA').innerHTML = document.getElementById('hsl_RA_terakhir').innerHTML;	
	}*/
	
	function detailRB(){
		gRB.loadURL('kelompok_util.php?klasifikasi='+document.getElementById("klasi").value,'','GET');
		new Popup('divKelompok',null,{modal:true,position:'center',duration:1});
    	document.getElementById('divKelompok').popup.show();	
	}
	
	function closeRB(){
		//Request('klasifikasi_util.php?act=view_last','hsl_RA_terakhir','','GET',loadRATerakhir,'noLoad');
		document.getElementById('divKelompok').popup.hide();
		location.reload();
	}
	
	function batalRB(){
		//isiCombo('klasi','',1, 'klasi', '');
		document.getElementById('status_tindakan').checked=false;
		document.getElementById('kode_kelompok').value='';
		document.getElementById('kelompok_tindakan').value='';
		document.getElementById('id_kelompok').value='';
		document.getElementById('btnSimpanRB').value='tambah';
		document.getElementById('btnSimpanRB').innerHTML="<img src='../icon/edit_add.png' height='16' width='16' style='position:absolute;' /><span style='margin-left:20px;'>Add</span>";
		document.getElementById('btnDeleteRB').disabled=true;	
	}
	
	function ambilRB(){
		var sisip=gRB.getRowId(gRB.getSelRow()).split("|");
		var cek = sisip[3];
		if(cek==1){document.getElementById('status_tindakan').checked=true;}
		else{document.getElementById('status_tindakan').checked=false;}
		var ini=sisip[4];
		document.getElementById('klasi').value=ini;
		//isiCombo('klasi','',ini, 'klasi', '');
		document.getElementById('kode_kelompok').value=sisip[2];
		document.getElementById('kelompok_tindakan').value=sisip[1];
		document.getElementById('id_kelompok').value=sisip[0];
		document.getElementById('btnSimpanRB').value='simpan';
		document.getElementById('btnSimpanRB').innerHTML="<img src='../icon/save.gif' height='16' width='16' style='position:absolute;' /><span style='margin-left:20px;'>Save</span>";
		document.getElementById('btnDeleteRB').disabled=false;	
	}
	
	function deleteRB(){
		var	id_kelompok=document.getElementById('id_kelompok').value;
		gRB.loadURL('kelompok_util.php?act=hapus&id_kelompok='+id_kelompok,'','GET');
		batalRB();	
	}
	var status2;
	function saveRB(act){
		if(document.getElementById('status_tindakan').checked==true){
		status2=1}else{status2=0;};
		var klasi=document.getElementById('klasi').value;
		var kode_kelompok=document.getElementById('kode_kelompok').value;
		var kelompok_tindakan=document.getElementById('kelompok_tindakan').value;
		var	id_kelompok=document.getElementById('id_kelompok').value;
		gRB.loadURL('kelompok_util.php?act='+act+'&kelompok_tindakan='+kelompok_tindakan+'&id_kelompok='+id_kelompok+'&kode_kelompok='+kode_kelompok+'&klasi='+klasi+'&status='+status2+'&klasifikasi='+document.getElementById("klasi").value,'','GET');
		batalRB();
	}
	//----------------------------------------//
        function getRadioValue(nameRadio){
            for(var i=1;i<=document.getElementsByName(nameRadio).length;i++){
                if(document.getElementById(nameRadio+i).checked){
                    //alert(document.getElementById(nameRadio+i).value);
                    if(document.getElementById(nameRadio+i).value=='0'){
                        document.getElementById('thHarga').innerHTML='(%)Prosentase';
                        for(var j=0;j<document.getElementsByName('hrgkom').length;j++){
                            document.getElementById('hrgkom_'+j).style.display='none';
                            document.getElementById('prokom_'+j).style.display='block';
                        }
                        //document.getElementById('txtTarif').value=0;
                        document.getElementById('txtTarif').readOnly=false;
                    }
                    else{
                        document.getElementById('thHarga').innerHTML='Harga';
                        for(var j=0;j<document.getElementsByName('hrgkom').length;j++){
                            document.getElementById('hrgkom_'+j).style.display='block';
                            document.getElementById('prokom_'+j).style.display='none';
                        }
                        //document.getElementById('txtTarif').value=0;
                        document.getElementById('txtTarif').readOnly=true;

                    }
                }
            }

        }

        //////////////////fungsi untuk kelas tindakan////////////////////////
        function isiCombo(id,val,defaultId,targetId){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            //alert('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET');
            Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET');
        }
        isiCombo('cmbKlasi');
        //isiCombo('cmbKelTin','1');
		//var aaa1 = document.getElementById('cmbKlasi').value;
		isiCombo('cmbKelTin','5');
        function getTarif(){
            new Popup('div_tarif',null,{modal:true,position:'center',duration:0.5});
            document.getElementById('div_tarif').popup.show();
        }
        function setTarif()
        {
            document.getElementById('txtTarif').value = total();
        }

        function total(){
            var getI=<?php echo $i;?>;
            var jml=0;i=0;
            if(document.getElementById('chkSetTarif2').checked){
                while(i<getI){
                    if(document.getElementById('komp_'+i).checked==true){
                        jml+=parseInt(document.getElementById('hrgkom_'+i).value);
                    }
                    i++;
                }
                i=0;
                while(i<getI){
                    if(document.getElementById('komp_'+i).checked==true){
                        document.getElementById('prokom_'+i).value=parseInt(document.getElementById('hrgkom_'+i).value)/jml*100;
                        //alert(document.getElementById('prokom_'+i).value);
                    }
                    i++;
                }
            }
            else{
                while(i<getI){
                    if(document.getElementById('komp_'+i).checked==true){
                        document.getElementById('hrgkom_'+i).value=parseInt(document.getElementById('prokom_'+i).value)/100*parseInt(document.getElementById('txtTarif').value);
                    }
                    i++;
                }
                jml=parseInt(document.getElementById('txtTarif').value);
            }
            return jml;
        }

        function simpanKom(id,harga,prosen){
            //alert(id+" "+harga);
            //alert("tindakan_kls_utils.php?act=simpanKomponen&id="+id+"&harga="+harga);
            var saveKom = new newRequest();
            //alert("tindakan_kls_utils.php?act=simpanKomponen&id="+id+"&harga="+harga+"&prosen="+prosen+"&user_id=<?php echo $user_id; ?>"); 
            saveKom.xmlhttp.open("GET","tindakan_kls_utils.php?act=simpanKomponen&id="+id+"&harga="+harga+"&prosen="+prosen+"&user_id=<?php echo $user_id; ?>");
            saveKom.xmlhttp.onreadystatechange=function(){
                if(saveKom.xmlhttp.readyState==4){
                    var hsl = saveKom.xmlhttp.responseText;
                    if(hsl==1){
                        alert('update harga sukses');
                        setTarif();
                    }
                    else if(hsl==-1){
                        alert('update harga gagal');
                    }
                    else{
                        alert(hsl);
                    }
                }
            }
            saveKom.xmlhttp.send(null);
        }

        function simpanKelas(action)
        {
            var id = document.getElementById("txtIdKls").value;
            var kls = document.getElementById("cmbKls").value;
            var retribusi = document.getElementById("cmbRetriKls").value;
            var tarif = document.getElementById("txtTarif").value;
            //var tarifAskes = document.getElementById('txtTarifAskes').value;

            var i=0,j=0;
            var param='';
            var getI=<?php echo $i;?>;
            while(i<getI){
                if(document.getElementById('komp_'+i).checked==true){
                    param+=document.getElementById('komp_'+i).value+'|'+document.getElementById('hrgkom_'+i).value+'|'+document.getElementById('prokom_'+i).value+'-';
                }
                i++;
            }
            if(param!=''){
                param=param.substr(0,param.length-1);
            }

            if(document.getElementById("isAktifKls").checked == true)
            {
                var aktif = 1;
            }
            else
            {
                var aktif = 0;
            }

            b.loadURL("tindakan_kls_utils.php?grd=true&act="+action+"&id="+id+"&tindId="+document.getElementById('txtId').value+"&kls="+kls+"&tarif="+tarif+"&aktif="+aktif+"&retribusi="+retribusi+"&param="+param+"&user_id=<?php echo $user_id; ?>","","GET");
            //+"&tarifAskes="+tarifAskes
            batalKelas();
        }

        function ambilDataKelas()
        {
            batalKelas();
            var terima=b.getRowId(b.getSelRow()).split('#');
            for(var i=3;i<terima.length;i++){
                var t=terima[i].split("|");
                for(var j=0;j<document.getElementsByName('chKom').length;j++){
                    if(document.getElementById('komp_'+j).value==t[1]){
                        document.getElementById('hrgkom_'+j).value=t[2];
                        document.getElementById('prokom_'+j).value=t[3];
                        document.getElementById('komp_'+j).checked=true;
                    }
                }
            }

            var p="txtIdKls*-*"+terima[0]+"*|*cmbKls*-*"+terima[1]+"*|*cmbRetriKls*-*"+terima[2]+"*|*txtTarif*-*"+b.cellsGetValue(b.getSelRow(),4)+"*|*isAktifKls*-*"+((b.cellsGetValue(b.getSelRow(),5)=='Aktif')?'true':'false')+"*|*btnSimpanKls*-*Simpan*|*btnHapusKls*-*false";
            //+"*|*txtTarifAskes*-*"+b.cellsGetValue(b.getSelRow(),5)
            //alert(p);
            fSetValue(window,p);
        }

        function hapusKelas()
        {
            var rowid = document.getElementById("txtIdKls").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
            if(confirm("Anda yakin menghapus Tindakan Kelas "+b.cellsGetValue(b.getSelRow(),3)))
            {
                b.loadURL("tindakan_kls_utils.php?grd=true&act=hapus&rowid="+rowid+"&tindId="+document.getElementById('txtId').value,"","GET");
            }
            batalKelas();

        }

        function batalKelas()
        {
            var par='';
            var i=0;
            var getI=<?php echo $i;?>;
            while(i<getI){
                par+="*|*komp_"+i+"*-*false*|*hrgkom_"+i+"*-*"+document.getElementById('hrgkom_'+i).lang;
                i++;
            }

            var p="txtIdKls*-**|*cmbKls*-**|*txtTarif*-*0"+par+"*|*isAktifKls*-*true*|*btnSimpanKls*-*Tambah*|*btnHapusKls*-*true";
            //*|*txtTarifAskes*-*0
            //alert(p);
            fSetValue(window,p);
        }
        ///////////////////////////////////////////////////////////////////

        //////////////////fungsi untuk tindakan////////////////////////
        function simpan(action)
        {
            if(ValidateForm('txtKode,txtNama,isAktif','ind'))
            {
                var id = document.getElementById("txtId").value;
				var icd9cm = document.getElementById("txtICD9cm").value;
                var kode = document.getElementById("txtKode").value;
                var nama = document.getElementById("txtNama").value;
                var kodeAskes = document.getElementById("txtKodeAskes").value;
                var namaAskes = document.getElementById("txtNamaAskes").value;
                var klas_id = document.getElementById("cmbKlasi").value;
                var kel_id = document.getElementById("cmbKelTin").value;
                var unit_id = '<?php echo $unit_id;?>';
                if(document.getElementById("isAktif").checked == true)
                {
                    var aktif = 1;
                }
                else
                {
                    var aktif = 0;
                }

                a.loadURL("tindakan_utils.php?grd=true&act="+action+"&id="+id+"&unit="+unit_id+"&kode="+kode+"&nama="+nama+"&kodeAskes="+kodeAskes+"&namaAskes="+namaAskes+"&klasId="+klas_id+"&kelTinId="+kel_id+"&aktif="+aktif+"&icd9cm="+icd9cm,"","GET");
                batal();
                /*
                        document.getElementById("txtKode").value = '';
                        document.getElementById("txtNama").value = '';
                        document.getElementById("cmbKlasi").value = '';
                        document.getElementById("cmbKelTin").value = '';
                        document.getElementById("isAktif").checked = false;
                 */
            }
        }

        function ambilData()
        {
            var sisip=a.getRowId(a.getSelRow()).split("|");
            var p="txtICD9cm*-*"+sisip[5]+"*|*txtId*-*"+sisip[0]+"*|*txtKode*-*"+a.cellsGetValue(a.getSelRow(),2)+"*|*txtNama*-*"+a.cellsGetValue(a.getSelRow(),3)+"*|*txtKodeAskes*-*"+sisip[3]+"*|*txtNamaAskes*-*"+sisip[4]+"*|*cmbKlasi*-*"+sisip[2]+"*|*isAktif*-*"+((a.cellsGetValue(a.getSelRow(),6)=='Aktif')?'true':'false')+"*|*btnSimpan*-*Simpan*|*btnHapus*-*false";
            //alert(p);
            fSetValue(window,p);
            //isiCombo('cmbKlasi', '', sisip[2], 'cmbKlasi', '');
            isiCombo('cmbKelTin', sisip[2], sisip[1], 'cmbKelTin', '');
        }

        function hapus()
        {
            var rowid = document.getElementById("txtId").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
            if(confirm("Anda yakin menghapus Tindakan "+a.cellsGetValue(a.getSelRow(),3)))
            {
                a.loadURL("tindakan_utils.php?grd=true&act=hapus&rowid="+rowid,"","GET");
            }
            batal();
        }

        function batal()
        {
            var p="txtICD9cm*-**|*txtId*-**|*txtKode*-**|*txtNama*-**|*txtKodeAskes*-**|*txtNamaAskes*-**|*isAktif*-*true*|*btnSimpan*-*Tambah*|*btnHapus*-*true";
            fSetValue(window,p);
        }

        function goToKelas(){
            //alert('tes');
            var sisip=a.getRowId(a.getSelRow()).split("|");
            document.getElementById("txtId").value=sisip[0];
            document.getElementById("tind").innerHTML=a.cellsGetValue(a.getSelRow(),3);
            document.getElementById('div_kelas').style.display='block';
            document.getElementById('div_tindakan').style.display='none';
            b.loadURL("tindakan_kls_utils.php?grd=true&tindId="+document.getElementById('txtId').value,"","GET");
        }
        //////////////////////////////////////////////////////////////////

        function goFilterAndSort(grd){
            //alert(grd);
            if (grd=="gridbox"){
                a.loadURL("tindakan_utils.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
            }else if (grd=="gridbox2"){
                b.loadURL("tindakan_kls_utils.php?grd=true&tindId="+document.getElementById('txtId').value+"&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage(),"","GET");
            }
        }
        var a=new DSGridObject("gridbox");
        a.setHeader("DATA TINDAKAN");
        a.setColHeader("NO,KODE,TINDAKAN,KLASIFIKASI,KELOMPOK,STATUS AKTIF,KODE ICD9CM");
        a.setIDColHeader(",kode,nama,klasifikasi,kelompok,,");
        a.setColWidth("40,75,450,100,150,75,75");
        a.setCellAlign("center,center,left,center,center,center,center");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        a.baseURL("tindakan_utils.php?grd=true");
        a.Init();

        var b=new DSGridObject("gridbox2");
        b.setHeader("DATA TINDAKAN KELAS");
        b.setColHeader("NO,TINDAKAN,KELAS,TARIF,STATUS AKTIF");
        b.setIDColHeader(",tind,kls,,");
        b.setColWidth("30,300,100,80,75");
        b.setCellAlign("center,left,center,right,center");
        //,TARIF ASKES,80,right
        b.setCellHeight(20);
        b.setImgPath("../icon");
        b.setIDPaging("paging2");
        b.attachEvent("onRowClick","ambilDataKelas");
        //b.onLoaded(ambilDataKelas);
        b.baseURL("tindakan_kls_utils.php?grd=true&tindId=0");
        b.Init();
    </script>
</html>
