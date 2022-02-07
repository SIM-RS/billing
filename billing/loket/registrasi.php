<?php

include("../sesi.php");
?>
<?php
//session_start();
$userId = $_SESSION['userId'];
if(!isset($userId) || $userId == ''){
    header('location:../index.php');
}
include '../koneksi/konek.php';
$sql="SELECT * FROM b_ms_group_petugas WHERE ms_pegawai_id='$userId' AND ms_group_id IN (10,45,46)";
$rs=mysql_query($sql);
$disableHapus="false";

$sql1="SELECT * FROM b_ms_reference WHERE stref = 35";
$rs1=mysql_query($sql1);
$drs1 = mysql_fetch_array($rs1);
$sumur = $drs1['nama'];

if($sumur=='')
{
    $sumur = 15;
}
//echo $sumur;
/*$disableHapus="true";
if ((mysql_num_rows($rs)>0) && ($backdate!="0")){
    $disableHapus="false";
}*/
?>
<html>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <head>
        <link rel="shortcut icon" href="../icon/favicon.ico" type="image/x-icon" />
        <title>Form Registrasi Pasien</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Cache-Control" content="no-cache, must-revalidate" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <link rel="stylesheet" href="../include/dialog/dialog_box.css" />
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script src="../theme/dhtmlxcalendar.js" type="text/javascript"></script>
        <!-- untuk ajax-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <script type="text/javascript" src="../include/jquery/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="jquery.maskedinput.js"></script>
        <script type="text/javascript" src="jquery.numeric.js"></script>
         <!--diatas ini diperlukan untuk menampilkan popup-->
        <script type="text/javascript" src="../include/dialog/dialog_box.js"></script>
        <script>
        jQuery.noConflict();
        </script>
        <!-- end untuk ajax-->

        <!--dibawah ini diperlukan untuk menampilkan popup-->
        <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        <script type="text/javascript" src="../theme/prototype.js"></script>
        <script type="text/javascript" src="../theme/effects.js"></script>
        <script type="text/javascript" src="../theme/popup.js"></script>
        <!--diatas ini diperlukan untuk menampilkan popup-->

        <link rel="stylesheet" type="text/css" href="../theme/bs/bootstrap.min.css" />
        
        
        <style type="text/css">
            .requiredField{
                background-color : #B1D8FC;
            }

            .form-width{
                height: 30px;
                width: 100%;
                font-size: 12px;
            }
        </style>
    
    </head>
    <body onLoad="document.getElementById('NoRm').focus();">
    
        <iframe height="72" width="130" name="sort"
                id="sort"
                src="../theme/dsgrid_sort.php" scrolling="no"
                frameborder="0"
                style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
        </iframe>
        <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js"
                src="../theme/popcjs.php" scrolling="no"
                frameborder="1"
                style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
        </iframe>
        <div align="center" id="content">
        <span id="fKonfirmasi" style="display:none;"></span>
            <?php
            //include "../header1.php";
            $date_now=gmdate('d-m-Y',mktime(date('H')+7));
            ?>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2" align="center">
                <tr>
                    <td width="504" height="30">&nbsp;FORM REGISTRASI PASIEN</td>
                    <?php 
                    $qAkses = "SELECT DISTINCT ms_menu_id,mm.nama,mm.url FROM b_ms_group_petugas gp INNER JOIN b_ms_group_akses mga ON gp.ms_group_id = mga.ms_group_id INNER JOIN b_ms_menu mm ON mga.ms_menu_id=mm.id WHERE gp.ms_pegawai_id=$userId AND mga.ms_menu_id IN (37,39,42)";
                    $rsAkses = mysql_query($qAkses);
                    if(mysql_num_rows($rsAkses)>1){
                    ?>
                    <td width="460" align="right">Link&nbsp;&nbsp;
                        <select name="cmnLink" id="cmbLink" class="txtinputreg" onChange="location=this.value;">
                            <option>-- PILIH --</option>
                            <?php while($rwMenu = mysql_fetch_array($rsAkses)){?>
                            <option value="<?php echo '../'.$rwMenu['url']?>"><?php echo $rwMenu['nama']?></option>
                            <?php } ?>
                        </select>&nbsp;</td>
                    <?php }?>
                    <td width="36">
                        <a href="../">
                            <img alt="close" src="../icon/x.png" style="cursor: pointer" width="32" />                        </a>                    </td>
                </tr>
            </table>
            <!--div id="div_tes"></div-->
            <table width="1000" border="0" cellspacing="0" cellpadding="0" class="tabel" align="center">
                <tr>
                    <td colspan="7">&nbsp;</td>
                </tr>
                <tr>
                <td width="9">&nbsp;</td>
                    <td colspan="2" style="padding-left:0px"><div id="loadG"></div></td>
                    <td colspan="4" style="padding-left:80px">&nbsp;<div id="loadS"></div></td>
                </tr>
                <tr>
                <td width="9">&nbsp;</td>
                    <td colspan="6">&nbsp;
                    <?
                    //if($_SESSION['group'] == 49)
                    //{
                    ?>
                        <fieldset style="display:inline-block; float:right; margin-right:40px;">
                            <legend style="font-size:12px">User</legend>
                            <select id="userLog" name="UserLog" onChange="saring();batal('1');" style="width:150" class="txtinputreg"></select>
                        </fieldset> 
                     <?
                    //}else{
                        ?>
                      <!--fieldset style="display:none">
                           <legend>User</legend>
                           <select id="userLog" name="UserLog" onChange="saring();batal('1');" style="width:150" class="txtinputreg"></select>
                     </fieldset--> 
                        <?
                    //}
                     ?>
                        <fieldset style="display:inline-block; float:right;">
                            <legend style="font-size:12px">Loket</legend>
                            <select id="asal" name="asal" onChange="decUser();batal('1'); if(this.value == '77') resetInputJkn(); else resetInputJkn(true);" style="width:auto" class="txtinputreg"></select>
                        </fieldset>
                          <input type="button" value="Pasien Baru" id="BtnNoRM" onClick="getNoRM()" style="height:50px; float:left; margin-left:10px; cursor:pointer;" />                   
                        <button onClick="showHideJKN();" id="btn-show-hide-jkn" style="height:50px; float:left; margin-left:10px; cursor:pointer;">Pasien dari JKN</button>
                        <button type="button" style="height: 50px;" class="btn btn-primary" data-toggle="modal" data-target="#pcrModal">
                          Pasien PCR Klinik
                        </button>
                        <div id="container-jkn" style="float: left; padding-left:10px; display: none;">
                            <form onsubmit="event.preventDefault(); submitNoAntrian();" action="">
                                No Antrian :<br/>
                                <input id="no-antrian" name="no-antrian" type="text" class="txtinput"/>
                                <button type="submit">Pilih</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <tr>
                <td width="9">&nbsp;</td>
                    <!--td colspan="6" style="padding-left:0px">&nbsp; <input type="button" value="Pasien Baru" id="BtnNoRM" class="btninputreg" onClick="getNoRM()" /></td-->
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="5" align="right"><hr /></td>
                </tr>
                <tr>
                    <td width="9">&nbsp;</td>
                    <td width="152" align="right">No RM :&nbsp;</td>
                    <td width="213">
                        <input type="text" name="NoRm"  class="requiredField" id="NoRm" size="8" class="txtinputreg" maxlength="8" tabindex="1" onKeyUp="listPasien(event,'show',this.id)"/>
                        <textarea cols="5" rows="5" style="display:none;" id="txtNoRM"></textarea>
                        <input id="txtIdPasien" name="txtIdPasien" type="hidden"/>
                        <input id="txtIdKunj" name="txtIdKunj" type="hidden"/>
                        <input id="unit_dari_jkn" name="unit_dari_jkn" type="hidden"/>
                        <input id="id_antrian_jkn" name="id_antrian_jkn" type="hidden"/>
                        <input id="IsNewPas" name="IsNewPas" value="" type="hidden"/>                    </td>
                    <td width="213">&nbsp;
                        <input name="NoBiling" id="NoBiling" readonly tabindex="2" size="18" class="txtinputreg" style="display:none" />
                        <textarea cols="5" rows="5" id="txtNoBiling" name="txtNoBiling" style="display: none"></textarea>                    </td>
                    <td width="156" align="right">&nbsp;</td>
                    <td width="193">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td align="right">Kewarganegaraan : &nbsp;</td>
                  <td> <select id="cmbKw" tabindex="14" name="cmbKw" class="txtinputreg" style="width:150px;" onChange="almtDis(this.value)">
                  </select>
                  </td>
                  <td>NIK :&nbsp;
                    <input name="NoKTP" id="NoKTP" tabindex="2" size="20" class="txtinputreg" maxlength="16" onKeyUp="listPasien(event,'show',this.id)" /></td>
                  <td align="right">Nama Ortu :</td>
                  <td><input type="text" name="NmOrtu" id="NmOrtu" size="30" tabindex="3" class="txtinputreg" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Nama :&nbsp;</td>
                    <td colspan="2"><input type="text" class="txtinputreg requiredField" name="Nama" id="Nama" size="56" tabindex="4" onKeyUp="listPasien(event,'show',this.id)" />                    </td>
                    <td align="right">Suami / Istri :&nbsp;</td>
                    <td><input type="text"  class="txtinputreg" name="NmSuTri" id="NmSuTri" size="30" tabindex="5"/></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Jenis Kelamin :&nbsp;</td>
                    <td colspan="2">
                        <select name="Gender" id="Gender" tabindex="6"  class="txtinputreg">
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option></select>
                        &nbsp;Pendidikan :&nbsp;<select name="Pendidikan" id="Pendidikan" tabindex="7" class="txtinputreg"></select></td>
                    <td align="right">Pekerjaan :&nbsp;</td>
                    <td><select name="Pekerjaan" id="Pekerjaan" tabindex="8" class="txtinputreg" style="width:230px"></select>                    </td>
                    <!--td width="44" align="right">&nbsp;</td-->
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="5" align="right"><hr /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Tgl Lahir :&nbsp;</td>
                    <td colspan="2">
                        <input type="text" class="txtcenterreg requiredField" maxlength="10" value="<?php echo $date_now;?>" onFocus="this.select();"  onKeyUp="" name="TglLahir" id="TglLahir" size="11" tabindex="9" onBlur="gantiUmur()" />
                        <input type="button" id="ButtonTglLahir" name="ButtonTglLahir" value=" V " tabindex="10" class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('TglLahir'),depRange,gantiUmur);" />
                        &nbsp;&nbsp;Umur :&nbsp;<input type="text" style="text-align:center;" value="0" class="txtinputreg" name="th" id="th" size="3" onKeyUp="gantiTgl(event,this)" tabindex="11"/>
                        &nbsp;Th&nbsp;&nbsp;<input type="text" style="text-align:center;" value="0" class="txtinputreg" name="Bln" id="Bln" size="3" tabindex="12" onKeyUp="gantiTgl(event,this)"/>&nbsp;Bln
                        &nbsp;&nbsp;<input type="text" style="text-align:center;" value="0" class="txtinputreg" name="hari" id="hari" size="3" tabindex="13" onKeyUp="gantiTgl(event,this)"/>&nbsp;Hr                    </td>
                    <td align="center" style="color:#666666">Kunjungan Pasien &nbsp;</td>
                    <td align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Agama:&nbsp;</td>
                    <td colspan="2"><select id="cmbAgama" tabindex="14" name="cmbAgama" class="txtinputreg"></select>&nbsp; Telp. <input type="text" tabindex="15" class="txtinputreg" id="telp" name="telp" size="15" />
                    &nbsp; Gol. Darah <select name="darah" id="darah" tabindex="16" class="txtinputreg">
                    <option value="-">-</option>
                    <option value="AB">AB</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="O">O</option>
                    </select>                    </td>
                    <td align="right">Tgl Kunjungan :&nbsp;</td>
                    <td>
                        <input type="text" class="txtcenterreg requiredField" name="TglKunj" readonly id="TglKunj" size="11" tabindex="24" value="<?php echo $date_now;?>"/>
                        <input type="button" id="ButtonTglKunj" name="ButtonTglKunj" value=" V " tabindex="" class="txtcenter requiredField" <?php echo $DisableBD; ?> onClick="gfPop.fPopCalendar(document.getElementById('TglKunj'),depRange,saring);document.getElementById('AslMasuk').focus();" />                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Alamat :&nbsp;</td>
                    <td colspan="2">
                        <input type="text" class="txtinputreg" name="Alamat" id="Alamat" size="35" onKeyUp="listPasien(event,'show',this.id)" tabindex="17"  />
            RT. <input type="text" class="txtinputreg" id="rt" name="rt" size="3" tabindex="18" />
            RW. <input type="text" class="txtinputreg" id="rw" name="rw" size="3" tabindex="19" />
                        <div id="div_pasien" align="center" class="div_pasien"></div>                    </td>
                    <td align="right">Asal Masuk :&nbsp;</td>
                    <td>
                        <select name="AslMasuk" id="AslMasuk" onChange="filterInap(this.value,0)" tabindex="26" class="txtinputreg requiredField">
                            <option value="">-Rujukan-</option>
                        </select>            
                        
                            <br />
                        <select name="dataMasuk" id="dataMasuk" tabindex="24" class="txtinputreg requiredField" style="display:none; width:200px;">
                            <option value="">-Pilih Pusk/RS-</option>
                        </select>                               </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Propinsi :&nbsp;</td>
                    <td colspan="2">
                        <input id="prop" name="prop" class="requiredField" size="50" onFocus="tutupAu();" onKeyUp="suggest(event,this,1);" class="txtinput" tabindex="20"/>
                        <input name="cmbProp" id="cmbProp" type="hidden" />
                        <input name="siakadStat" id="siakadStat" type="hidden" />
                        <div id="divautocomplete" align="left" style="position:absolute; z-index:1; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC;"></div>
                        <!--select id="cmbProp" name="cmbProp" onChange="isiKab();" tabindex="18"  class="txtinputreg">
                        </select--></td>
                    <td align="right">Keterangan :&nbsp;</td>
                    <td><input type="text" name="Ket" id="Ket" tabindex="27" class="txtinputreg"/></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Kabupaten/Kota :&nbsp;</td>
                    <td colspan="2"> <input id="kabx" class="requiredField" onFocus="tutupAu();"  name="kabx" size="45" onKeyUp="suggest_kab(event,this);" class="txtinput" tabindex="21" />
                    <input name="cmbKab" id="cmbKab" type="hidden" class="txtinput" size="5" />
                    <div id="divautocomplete_kab" align="left" style="position:absolute; z-index:1; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC;"></div>
                    <!--<select id="cmbKab" name="cmbKab" onChange="isiKec();" tabindex="19" class="txtinputreg"></select>--></td>
                    <td align="right">Status pasien :&nbsp;</td>
                    <td>
                        <select name="StatusPas" id="StatusPas" tabindex="28" class="txtinputreg requiredField" style="width:170px" onChange="setPenjamin(this.value);SetAsalMasuk();">
                            <option value="">-status pasien-</option>
                        </select>                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Kecamatan :&nbsp;</td>
                    <td colspan="2">
                    <input id="kecx" onFocus="tutupAu();" class="requiredField" name="kecx" size="40" onKeyUp="suggest_kec(event,this);" class="txtinput" tabindex="22"/>
                    <input name="cmbKec" id="cmbKec" type="hidden" class="txtinput" size="5" />
                    <div id="divautocomplete_kec" align="left" style="position:absolute; z-index:1; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC;"></div>
                        <!--<select id="cmbKec" name="cmbKec" onChange="isiCombo('cmbDesa',this.value);" tabindex="20" class="txtinputreg">
                        </select>-->                    </td>
                    <td align="right">Tgl SJP/SKP :&nbsp;</td>
                    <td><input name="TglSJP" id="TglSJP" size="11" tabindex="29" class="txtcenterreg" readonly value="<?php echo $date_now;?>"/>
                        <input type="button" id="ButtonTglSJP" name="ButtonTglSJP" value=" V " tabindex="30" class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('TglSJP'),depRange);" /></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Kelurahan/Desa :&nbsp;</td>
                    <td colspan="2">
                    <input id="desx" onFocus="tutupAu();" class="requiredField" name="desx" size="35" onKeyUp="suggest_des(event,this);" class="txtinput" tabindex="23" />
                    <input name="cmbDesa" id="cmbDesa" type="hidden" class="txtinput" size="5" />
                    <div id="divautocomplete_des" align="left" style="position:absolute; z-index:1; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC;"></div>
                        <!--<select id="cmbDesa" name="cmbDesa" tabindex="21" class="txtinputreg">
                        </select> -->                   </td>
                    <td align="right">No SJP/SKP :&nbsp;</td>
                    <td><input name="NoSJP" id="NoSJP" tabindex="31" class="txtinputreg" style="width:130" /><input type="button" id="getSJP" value="Get SJP" onClick="get_sjp()" tabindex="32" /></td>
                </tr>
                <!-- <tr>
                    <td>&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td colspan="2"> -->
                    <input type="hidden" disabled class="txtinput" name="flag" id="flag" size="37" tabindex="3" value="<?php echo $flag; ?>"/>
                    <!-- </td>
                    <td align="right">&nbsp;</td>
                    <td width="5" align="right">&nbsp;</td>
                </tr> -->
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="3" align="right"><hr /></td>
                    <td align="right">Jenis Layanan :&nbsp;</td>
                    <td>
                        <select name="JnsLayanan" id="JnsLayanan" tabindex="33" class="txtinputreg requiredField" onChange="isiTmpLay('setThrough');this.title=this.value;"></select>                    </td>
                    <!--if(document.getElementById('NoRm').value=='' || document.getElementById('txtIdPasien').value == ''){getNoRM();}else{getNoBil();}-->
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right" style="color:#666666">Penjamin Pasien</td>
                    <td colspan="2"><input type="checkbox" name="ok" id="ok" tabindex="" onClick="if(this.checked==true){setPenjamin(0)}else{setPenjamin(1)}"  class="txtinputreg requiredField"/>&nbsp;</td>
                    <td align="right">Tempat Layanan :&nbsp;</td>
                    <td>
                        <select name="TmpLayanan" id="TmpLayanan" tabindex="34" class="txtinputreg requiredField" onChange="this.title=this.value;setKelas('setThrough');cJPasien();cekMcuTidak(this.value);"></select>
                        <!--isiCombo('cmbKelasPasien',this.value,'','cmbKelas',setRetribusi);isiKamar-->
                        <input type="hidden" id="prev_TmpLayanan" name="prev_TmpLayanan" />  
                        <input type="hidden" id="prev_inap" name="prev_inap" />
                        <!--input type="text" id="inap" name="inap" />
                        <textarea style="display: block" id="h_inap" name="h_inap"></textarea-->                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td colspan="2"></td>
                    <td align="right">
                        <span style="display:none;" id="titleKelompokTindakanMcu">Kelompok MCU</span>
                    </td>
                    <td>
                        <select style="display:none;" name="KelompokTindakanMcu" id="KelompokTindakanMcu" class="txtinputreg requirefield">
                            <?php
                                $query = mysql_query("SELECT * FROM b_ms_mcu_kelompok WHERE aktif = 1 AND flag = 1");
                                while($rows = mysql_fetch_assoc($query)){
                                    echo '<option value="'.$rows['id'].'">'.$rows['nama_kelompok'].'</option>';
                                }
                            ?>
                        </select>
                    </td>  
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Penjamin :&nbsp;</td>
                    <td colspan="2"><input type="hidden" name="Penjamin" id="Penjamin" class="txtinputreg" />
                        <input type="text" name="txtPenjamin" id="txtPenjamin" tabindex="36" class="txtinputreg" readonly />&nbsp;&nbsp;No Anggota :&nbsp;<input name="NoAnggota" id="NoAnggota" tabindex="36" class="txtinputreg"/>                    </td>
                    <td align="right">Kelas :&nbsp;</td>
                    <td>
                        <select name="cmbKelas" id="cmbKelas" tabindex="35" title="this.value" class="txtinputreg requiredField" onChange="isiKamar('setThrough');"></select>                    </td><!--getInap();setRoom();-->
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td align="right">Hak Kelas :&nbsp;</td>
                    <td colspan="2">
                        <select name="HakKelas" id="HakKelas" tabindex="37" class="txtinputreg requiredField"></select>
            Status :&nbsp;
                        <select name="StatusPenj" id="StatusPenj" tabindex="38" class="txtinputreg">
                            <option value="ANAK KE 1">Anak Ke 1</option>
                            <option value="ANAK KE 2">Anak Ke 2</option>
                            <option value="ISTRI">Istri</option>
                            <option value="PESERTA">Peserta</option>
                            <option value="SUAMI">Suami</option>
                        </select>                    </td>
                    <td align="right" id="td_ret">
                        Retribusi :&nbsp;                    </td>
                    <td id="td_ret1">
                        <select name="Retribusi" id="Retribusi" tabindex="36" class="txtinputreg" onChange="setTarip('setThrough')" style="width:150px"></select>&nbsp;&nbsp;&nbsp;
                        <span id="spanTarif"></span>
                        <input type="hidden" id="prev_retribusi" name="prev_retribusi" />                    </td>
                    <td align="right" id="td_room">
                        Kamar :&nbsp;                    </td>
                    <td width="38" id="td_room1">
                        <select id="kamar" class="txtinputreg" onChange="setTarip('setThrough')" tabindex="37" name="kamar">
                        </select>
                        <span id="spanTarifKamar"></span>
                        <div id="div_room"></div>
                        <!--  style="display: none"kamar diambil dari b_ms_kamar,b_ms_unit,b_ms_kelas, jika kelas diganti maka kamar ikut berubah display: none; -->                    </td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td colspan="2"></td>
                    <td align="right">Dokter :&nbsp;</td>
                    <td><select name="cmbDokter" class="requiredField" id="cmbDokter" tabindex="38" style="width:150px" class="txtinputreg" onKeyUp="cJPasien();" onChange="DokterT();" ></select><label><input type="checkbox" id="chkDokterPengganti" value="1" onChange="gantiDokter('cmbDokDiag',this.checked);" tabindex=""/>Lainnya</label></td>
                </tr>
                 <tr style="display:none">
                    <td>&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td colspan="2"></td>
                    <td align="right">Jumlah Pasien:&nbsp;</td>
                    <td><div id="loadJDokter"></div></td>
                </tr>
                <tr style="display:none;">
                    <td>&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td colspan="2"></td>
                    <td align="right">No Registrasi :&nbsp;</td>
                    <td><input type="text" name="noReg1" id="noReg1" tabindex="40" class="txtinputreg"/></td>
                </tr>
                <tr>
                    <td>                    </td>
                                            <!--<td>
                        <fieldset>
                            <legend>Loket</legend>
                            <select id="asal" name="asal" onChange="decUser();batal('1');" style="width:150" class="txtinputreg"></select>
                        </fieldset>
                        <fieldset>
                            <legend>User</legend>
                            <select id="userLog" name="UserLog" onChange="saring();batal('1');" style="width:150" class="txtinputreg"></select>
                        </fieldset>                    </td>-->
                    <td colspan="3" align="center">

                    <div id="tombol1" style="border:1px solid #CCC; background-color:#FFF; margin-left:15px; padding:5px;">
                    <link rel="stylesheet" type="text/css" href="button.css">
                        <input id="kartu" name="kartu" type="button" value="Cetak Kartu" onClick="kartu()" class="button"/>
                        <input id="kartuB" name="kartuB" type="button" value="Cetak Barcode" onClick="kartuB()"  class="button"/>
                        <input id="cetak" name="cetak" type="button" value="Cetak Kwitansi" onClick="cetak()"  class="button"/>
                        <input id="cetakForm" name="cetakForm" type="button" value="Form Verifikasi" disabled="disabled" onClick="cetakForm()"  class="button"/>
                        <input id="spInap" name="spInap" type="button" value="SP INAP" disabled="disabled" onClick="spi()" style="display:none"  class="button" />
                        <input name="UpdStatusPx" id="UpdStatusPx" type="button" value="UBAH STATUS Px" style="display:none" disabled onClick="PopUpdtStatus();" />
                        <input name="cetakDaftar" id="cetakDaftar" type="button" value="Bukti Daftar" onClick="cetakDaftar();"  class="button"/>
                    <input id="skpJamkesda" name="skpJamkesda" type="button" value="SKP JAMKESDA" disabled="disabled" onClick="skp()" style="display:none"  class="button"/>
                    <input id="skpJamkesdaKmr" name="skpJamkesdaKmr" type="button" value="SKP JAMKESDA INAP" disabled="disabled" onClick="skp('kamar')" style="display:none"  class="button"/>
                    <input id="sjpJampersal" name="sjpJampersal" type="button" value="SJP JAMPERSAL" disabled="disabled" onClick="skp('jampersal')"  class="button"/>
                    <input id="sjpAskes" name="sjpAskes" type="button" value="SEP BPJS FULL" disabled="disabled" onClick="print_sjp(1)"  class="button"/>
                    <input id="sjpAskes_isi" name="sjpAskes" type="button" value="SEP BPJS ISI" disabled="disabled" onClick="print_sjp(2)"  class="button"/>
                    <input class="btnRegis" id="sjpBPJS" name="sjpBPJS" type="button" value="SJP BPJS FULL" disabled="disabled" onClick="print_sjp_bpjs(1)"  style="display:none" class="button"/>
                    <input class="btnRegis" id="sjpBPJS_isi" name="sjpBPJS_isi" type="button" value="SJP BPJS ISI" disabled="disabled" onClick="print_sjp_bpjs(2)" style="display:none"  class="button"/>
                    <!--input id="KIUP" name="KIUP" type="button" value="Cetak KIUP" onClick="kiup()" /-->
                    <input id="LabelP" name="LabelP" type="button" value="Cetak Label" onClick="cetak_label()"  class="button"/>
                    <input id="cetak2" name="cetak2" type="button" value="Cetak Antrian" onClick="cetak2()"  class="button"/>
                    </div>                    </td>
                    <!--td colspan="2"></td>
                    <td align="right">&nbsp;</td-->
                    <td colspan="2" align="center">
                        <input type="button" id="btnSimpan" name="btnSimpan" tabindex="41" value="Tambah" onClick="getNoRM1();" class="tblTambah" onBlur="document.getElementById('btnBatal').focus();"/>
                        <input type="button" id="btnHapus" name="btnHapus" value="Hapus" onClick="hapus(this.title);" disabled="disabled" class="tblHapus" tabindex="42"/>
                        <input type="button" tabindex="43" id="btnBatal" name="btnBatal" value="Batal" onClick="batal()" class="tblBatal"/>
                        <div id="divKunjLagi" style="display:none;"><input type="button" id="btnKunjUlang" name="btnKunjUlang" value="DiKunjungkan Lagi" onClick="SetKunjungLagi();" class="tblBtn"/></div>                    </td>
                </tr>
                <tr>
                    <td colspan="7" height="235" align="center">
                        <div id="gridbox" style="width:950px; height:200px; background-color:white; overflow:hidden;"></div>
                        <div id="paging" style="width:950px;"></div>                    </td>
                </tr>
            </table>
        </div>
        <span id="skpDiv" style="display:none"></span>
        <div id="div_getSJP" style="display:none;width:800px;height:550px;" align="center" class="popup">
            <table width="800" border="0" style="border-collapse:collapse; font-size:12px;">
            <tr>
                <td width="5%">&nbsp;</td>
                <td colspan="3">
                <img alt="close" id="close_btn" src="../icon/x.png" width="32" class="popup_closebox" style="float:right;cursor: pointer" />
                Ambil No. SEP
                <form id="form_sjp" action="sjp.php" method="post" target="sjp_report">
                    <input type='hidden' id="hid_user_sjp" name="userId" value="<?php echo $userId;?>" />
                    <input type='hidden' id="hid_kunjungan_id" name="hid_kunjungan_id" value="" />
                    <input type='hidden' id="first_time" name="first_time" value="" />
                </form>                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td width="110">No. Peserta</td>
                <td>
                    :&nbsp;
                    <input type="text" id="NoKa" tabindex="100" onKeyUp="suggest_sjp_byNoKa(event,this);" autocomplete="off" class="txtinput" />
                    <img src="../images/ajax.gif" id="load_gif" style="display:none;position:absolute;" />
                </td>
                <td width="10%">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                NIK                </td>
                <td>
                :&nbsp;
                <input type="text" id="NIP" tabindex="101" onKeyUp="suggest_sjp(event,this);" autocomplete="off" class="txtinput" />
                <div id="listPas_sjp" style="width:730px;height:200px;position:absolute;display:none;overflow:auto"></div>                </td>
                <td width="10%">&nbsp;</td>
            </tr>
            <tr>
                <td></td>
                <td>
                No RM                </td>
                <td colspan="2">:&nbsp;
                <span id="span_NoRm_sjp"></span>                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                Nama Peserta                </td>
                <td colspan="2">:&nbsp;
                <span id="span_namaP_sjp"></span>                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                Jenis Kelamin                </td>
                <td colspan="2">:&nbsp;
                <span id="span_gender_sjp"></span>                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                Tgl Lahir                </td>
                <td colspan="2">:&nbsp;
                <span id="span_birth_sjp"></span>                </td>
            </tr>
            <tr>
                <td></td>
                        <td>Hak Kelas </td>
                        <td colspan="2">:&nbsp;
                            <select name="HakKelas_sjp" id="HakKelas_sjp" tabindex="102" onChange="document.getElementById('HakKelas').value = this.value;" class="txtinputreg"></select>
                &nbsp;&nbsp;PISA :&nbsp;
                <span id="span_StatusPenj_sjp"></span>
                &nbsp;&nbsp;
                Tgl SEP :&nbsp;
                <input name="TglSJP_sjp" id="TglSJP_sjp" size="11" tabindex="103" class="txtcenterreg" readonly value="<?php echo $date_now;?>"/>
                            <input type="button" id="ButtonTglSJP_sjp" name="ButtonTglSJP_sjp" value=" V " tabindex="104" class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('TglSJP_sjp'),depRange,function(){document.getElementById('TglSJP').value=document.getElementById('TglSJP_sjp').value;});" />                        </td>
            </tr>
            <tr>
              <td></td>
              <td>Kode PPK</td>
              <td colspan="2">
                :&nbsp;
                <input type="text" id="kodeppk_sjp" name="kodeppk_sjp" autocomplete="off" class="txtinput" /></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                Diagnosa                </td>
                <td>
                :&nbsp;
                <input type="hidden" id="diagnosa_id_sjp" />
                <input type="text" id="diag_sjp" tabindex="105" size="70" onKeyUp="suggest_diag(event,this);" autocomplete="off" class="txtinput" />
                <div id="listDiag_sjp" style="width:400px;height:100px;overflow:auto;position:absolute;display:none;margin-left:13px;"></div>                </td>
                <td>&nbsp;</td>
            </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td >Jenis Layanan</td>
                        <td>:&nbsp;
                            <select name="JnsLayanan_sjp" id="JnsLayanan_sjp" tabindex="106" class="txtinputreg" onChange="isiTmpLay_sjp('setThrough');this.title=this.value;"></select>                        </td>
                        <!--if(document.getElementById('NoRm').value=='' || document.getElementById('txtIdPasien').value == ''){getNoRM();}else{getNoBil();}-->
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                <td >Tempat Layanan </td>
                        <td>:&nbsp;
                            <select name="TmpLayanan_sjp" id="TmpLayanan_sjp" tabindex="107" class="txtinputreg" onChange="this.title=this.value;setKelas_sjp('setThrough');"></select>                        </td>
                    </tr>
                    <td>
            <tr>
                        <td>&nbsp;</td>
                <td >Kelas </td>
                        <td colspan="2">:&nbsp;
                            <select name="cmbKelas_sjp" id="cmbKelas_sjp" tabindex="108" title="this.value" class="txtinputreg" onChange="isiKamar_sjp('setThrough');"></select>                        </td>
            </tr>
            <tr>
                        <td>&nbsp;</td>
                        <td id="td_ret_sjp">
                            Retribusi                        </td>
                        <td id="td_ret1_sjp" colspan="2" style="display:none">:&nbsp;
                            <select name="Retribusi_sjp" id="Retribusi_sjp" tabindex="109" class="txtinputreg" onChange="setTarip_sjp('setThrough')"></select>&nbsp;&nbsp;&nbsp;
                            <span id="spanTarif_sjp"></span>                        </td>
                        <td id="td_room_sjp">
                            Kamar                        </td>
                        <td id="td_room1_sjp" colspan="2" style="display:none">:&nbsp;
                            <select id="kamar_sjp" class="txtinputreg" onChange="setTarip_sjp('setThrough')" tabindex="110" name="kamar_sjp">
                            </select>
                            <span id="spanTarifKamar_sjp"></span>
                            <div id="div_room_sjp"></div>
                            <!--  style="display: none"kamar diambil dari b_ms_kamar,b_ms_unit,b_ms_kelas, jika kelas diganti maka kamar ikut berubah display: none; -->                        </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2" align="right">
                <input type="button" tabindex="111" id="conf_sjp" value="Generate SJP" onClick="confirm_sjp()" />                </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4" align="center" style="padding-top:10px;">
                    <div id="gridbox_diag_bpjs" style="width:750px; height:150px; background-color:white; overflow:hidden;"></div>
                    <!--div id="paging_diag_bpjs" style="width:700px;"></div-->
                </td>
            </tr>
            </table>
        </div>
        <div id="divUpdtStatus" style="display:none;width:450px; height:250px" align="center" class="popup">
            <span id="inpEvUpdt" style="display:none"></span>
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
                                    <select id="statusPx" name="statusPx" class="txtinput" onChange="fChangeStatusPx(this.value)">
                                    <?php 
                                    $sql="SELECT id,nama FROM b_ms_kso WHERE aktif=1 ORDER BY nama";
                                    $rs=mysql_query($sql);
                                    while ($rw=mysql_fetch_array($rs)){
                                    ?>
                                        <option value="<?php echo $rw['id']; ?>"><?php echo $rw['nama']; ?></option>
                                    <?php 
                                    }
                                    ?>
                                    </select>
                          </td>
                            </tr>
                            <tr>
                                <td class="txtinputNoBgColor"><span id="spnTglSJP">Tgl SJP/SKP</span></td>
                              <td class="txtinputNoBgColor" width="10" align="center">&nbsp;:</td>
                                <td><input type="text" class="txtcenter" name="TglSJP_pop" readonly id="TglSJP_pop" size="11" value="<?php echo $date_now;?>"/>
                              <input type="button" id="ButtonTglSJP" name="ButtonTglSJP" value=" V " class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('TglSJP'),depRange);" /></td>
                            </tr>
                            <tr id="trnosjp">
                              <td class="txtinputNoBgColor">No SJP/SKP</td>
                              <td class="txtinputNoBgColor" align="center">&nbsp;:</td>
                              <td><input type="text" class="txtinput" name="NoSJP_pop" id="NoSJP_pop" size="20" /></td>
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
                              </select>
                      </td>
                    </tr>
                            <tr id="trnmPeserta">
                              <td class="txtinputNoBgColor">Nama Peserta</td>
                              <td class="txtinputNoBgColor" align="center">&nbsp;:</td>
                              <td><input type="text" class="txtinput" name="nmPeserta" id="nmPeserta" size="30" /></td>
                          </tr>
                            <tr id="trStatusPenj">
                              <td class="txtinputNoBgColor">Status Jaminan&nbsp;</td>
                              <td class="txtinputNoBgColor" align="center">&nbsp;:</td>
                              <td><select name="StatusPenj_pop" id="StatusPenj_pop" class="txtinputreg">
                                    <option value="ANAK KE 1">Anak Ke 1</option>
                                    <option value="ANAK KE 2">Anak Ke 2</option>
                                    <option value="ISTRI">Istri</option>
                                    <option value="PESERTA">Peserta</option>
                                    <option value="SUAMI">Suami</option>
                                </select>
                      </td>
                          </tr>
                        </table>
                  </td>
                </tr>
                <tr>
                    <td align="center"><br /><input name="BtnUpdtStatusPx" id="BtnUpdtStatusPx" type="button" value="Update Status" class="tblBtn" onClick="goUpdtStatusPx()" /></td>
                </tr>
            </table>
        </div>
        
        <!-- Modal PCR -->
        <div class="modal fade" id="pcrModal" tabindex="-1" aria-labelledby="pcrModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="pcrModalLabel">PASIEN PCR</h5>
                <button type="button" class="close" id="closeBtnPcrModal" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="alert alert-success alert-dismissible fade show" id="alert-berhasil" style="display:none;" role="alert">
                    <span id="messages"></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-danger alert-dismissible fade show" id="alert-gagal" style="display:none;" role="alert">
                    <span id="messagesgagal"></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <select name="jenislayananpcr" style="display: none;" class="form-control form-width" id="jenislayananpcr" onchange="isiTmpLayPcr('setThrough')"></select>
                        </div>
                    </div>
                    <div class="col-4">
                        <select name="tmplayananpcr" style="display: none;" class="form-control form-width" id="tmplayananpcr" onchange="cmbDokterPcr()"></select>
                    </div>
                    <div class="col-4">
                        <select name="cmbdokterpcr" style="width: 90%;display: none;" class="form-control form-width" id="cmbdokterpcr"></select> 
                        <input type="hidden" name="chkDokterPenggantiPcr" id="chkDokterPenggantiPcr" onchange="gantiDokterPcr('cmbDokDiag',this.checked)">
                    </div>
                    <div class="col-4">
                        <div class="row">
                            <div class="col-9">
                                <select name="cmbRetrbibusiPcrKlinik" style="display: none;" id="cmbRetrbibusiPcrKlinik" class="form-control form-width"></select>        
                            </div>
                            <div class="col-3">
                                <span style="display: none;" id="spanTarifPcr"></span>                        
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-sm btn-primary" type="button" onclick="refreshGridPcr()">
                    Refresh
                </button>
                <div id="gridboxpcr" style="width: 100%;"></div>
                <div id="pagginationpcr"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class=" btn btn-sm btn-warning" onclick="submitPasienToRs()">Tambah</button> -->
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="dataPasienRsCekFromPcr" tabindex="-1" role="dialog" aria-labelledby="dataPasienRsCekFromPcrLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="dataPasienRsCekFromPcrLabel">Data Pasien</h5>
                <button type="button"  id="closeBtnDataPasienRs" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" id="dataPasienPcrRs">
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <input type="hidden" name="id_pasien_klinik" id="id_pasien_klinik">
        <input type="hidden" name="id_kunjungan_klinik" id="id_kunjungan_klinik">
        <input type="hidden" name="id_pelayanan_klinik" id="id_pelayanan_klinik">

    </body>
    <script src="../theme/bs/bootstrap.min.js"></script>
    
    <script type="text/JavaScript" language="JavaScript">
        var pcr = new DSGridObject("gridboxpcr");
        pcr.setHeader("DATA PASIEN");
        pcr.setColHeader("NO,NAMA,TEMPAT LAYANAN,KSO,ACTION");
        pcr.setIDColHeader("no,p.nama,u.nama,k.nama,");
        pcr.setColWidth("30,185,200,100,240");
        pcr.setCellAlign("center,left,center,center,center");
        // pcr.setCellType("chk,txt,txt,txt,txt,");
        pcr.setCellHeight(20);
        pcr.setImgPath("../icon");
        pcr.setIDPaging("pagginationpcr");
        // pcr.attachEvent("onRowClick","pcrData");
        pcr.onLoaded(konfirmasi);
        pcr.baseURL("pcr_klinik_utils.php?grd=getData");
        pcr.Init();

        function refreshGridPcr(){
            pcr.baseURL("pcr_klinik_utils.php?grd=getData");
            pcr.Init();
        }

        

        function submitPasienToRs(){
            let dataArr = [];
            let countBerhasil = 0;
            let countGagal = 0;
            let dataKirim = [];
            for(let i=0;i<pcr.obj.childNodes[0].rows.length;i++){
                if(pcr.obj.childNodes[0].childNodes[i].childNodes[0].childNodes[0].checked){
                    let data = new Object();
                    let dataPcr = pcr.getRowId(i+1).split('||');
                    for(let i = 0; i < dataPcr.length; i++){
                        let keyval = dataPcr[i].split('|');
                        data[keyval[0]] = keyval[1];
                    }
                    dataArr.push(data);
                }
            }

            console.log(dataArr);
            if(confirm("Yakin menambahkan pasien ?")){
                for(let i = 0; i < dataArr.length; i++){
                    let data = {
                        saring: true,
                        saringan: document.getElementById("TglKunj").value,
                        act: 'tambahpcr',
                        idPasien: dataArr[i].id == "-" ? "" : dataArr[i].id,
                        idKunj: '',
                        nama:  dataArr[i].nama == "-" ? "" : dataArr[i].nama,
                        namaOrtu: dataArr[i].nama_ortu == "-" ? "" : dataArr[i].nama_ortu,
                        namaSuTri:  dataArr[i].nama_suami_istri == "-" ? "" : dataArr[i].nama_suami_istri,
                        gender: dataArr[i].sex,
                        agama: dataArr[i].agama,
                        pend: dataArr[i].pendidikan_id,
                        pek: dataArr[i].pekerjaan_id,
                        tglLhr: changeDateFormat(dataArr[i].tgl_lahir),
                        thn: dataArr[i].umur_thn,
                        bln: dataArr[i].umur_bln,
                        hari: dataArr[i].umur_hr,
                        tglKun: document.getElementById('TglKunj').value,
                        alamat:  dataArr[i].alamat == "-" ? "" : dataArr[i].alamat,
                        rt: dataArr[i].rt == "-" ? "" : dataArr[i].rt,
                        kamar: '',
                        rw: dataArr[i].rw == "-" ? "" : dataArr[i].rw,
                        asalMsk: '14', //harcode
                        prop: dataArr[i].prop_id,
                        ket: dataArr[i].ket == "-" ? "" : dataArr[i].ket,
                        kab: dataArr[i].kab_id == "-" ? "" : dataArr[i].kab_id,
                        statusPas: dataArr[i].id_kso,
                        userLog: document.getElementById('userLog').value,
                        asal: 77,
                        prev_stat: '',
                        kec: dataArr[i].kec_id,
                        tglSJP: document.getElementById("TglSJP").value,
                        desa: dataArr[i].desa_id,
                        noSJP: '',
                        jnsLayanan: 57, //harcode
                        inap: 0, //harcode
                        prev_inap: '',
                        tmpLayanan: 232, //harcode
                        kelas: 1, //harcode
                        retribusi: document.getElementById('cmbRetrbibusiPcrKlinik').value,
                        prev_retribusi: '',
                        tarip: document.getElementById('cmbRetrbibusiPcrKlinik').options[document.getElementById('cmbRetrbibusiPcrKlinik').options.selectedIndex].lang,
                        penjamin: dataArr[i].id_kso,
                        noAnggota: '',
                        hakKelas: 1,
                        statusPenj: 'PESERTA',
                        telp: dataArr[i].telp == "-" ? "" : dataArr[i].telp,
                        userId: <?= $userId ?>,
                        diagAwal: '',
                        kodeppk: '',
                        namaPKSO: "",
                        noKTP: dataArr[i].no_ktp == "-" ? "" : dataArr[i].no_ktp,
                        dokter_id: document.getElementById('cmbdokterpcr').value,
                        dokterPengganti: document.getElementById('chkDokterPenggantiPcr').checked ? 1 : 0,
                        noreg1: '',
                        darah: dataArr[i].gol_darah == "-" ? "" : dataArr[i].gol_darah,
                        pusk: 0,
                        kw: 1,
                        flag: 1,
                        cabang: 1,
                        isPcrKlinik: 1,
                        id_pasien_klinik : dataArr[i].id,
                        no_rm_pasien_klinik : dataArr[i].no_rm,
                        id_kunjungan_klinik : dataArr[i].id_kunjungan,
                        id_pelayanan_klinik : dataArr[i].id_pelayanan,
                    }
                    dataKirim.push(data);
                }
                // for(let i = 0; i < dataArr.length; i++){
                    jQuery.ajax({
                        url: 'registrasi_utils_pcr_2.php',
                        method: 'post',
                        data: {    
                                dataArr : dataKirim,
                                act : 'tambahpcr',
                            },
                        dataType:'json',
                        success: function(data) {
                                if(data.status == 1){
                                    jQuery('#messages').html(data.Messages);
                                    jQuery('#alert-berhasil').show();
                                    jQuery('#alert-gagal').hide();
                                    refreshGridPcr();
                                }
                                else{
                                    jQuery('#messagesgagal').html(data.Messages);
                                    jQuery('#alert-gagal').show();
                                    jQuery('#alert-berhasil').hide();
                                }
                                // jQuery('#alert-gagal').hide();
                                // jQuery('#alert-berhasil').hide();
                            }
                        });

                    // }
                }
            }

        function changeDateFormat(dateData){
            let date = dateData.split('-');
            return date[2] + '-' + date[1] + '-' + date[0];
        }


        var arrRange=depRange=[];
        var RowIdx;
        var fKeyEnt;
        var cari=0;
        var keyword='';
        var abc = 0;
        var prev_stat = '';
        var KunjAktif=false;
        var cIdPas=cIdKunj=cUnit="";
        //variabel untuk ambil data
        var glob_jnsLay = glob_tmpLay = glob_kelas = glob_ret = glob_kamar = glob_dilayani = glob_asal = glob_dokter = '';
        var glob_type_dokter = '0';
        var th1=bln1=hr1 = "";
        var nm_pas = nip_pas = jns_pas = "";
        var cabang = 1;

        function showHideJKN(statsDisplay = 0){
            if(statsDisplay != 0){
                if(statsDisplay == 1){
                    jQuery("#container-jkn").show();
                }else{
                    jQuery("#container-jkn").hide();
                }
                return;
            }

            if(jQuery("#container-jkn").css("display") == "none"){
                jQuery("#container-jkn").show({
                    speed: 1000
                });
                jQuery("#no-antrian").focus();
            }
            else{
                jQuery("#container-jkn").hide({
                    speed: 1000
                });
            }
        }
        function submitNoAntrian(){
            if(jQuery("#no-antrian").val() != null){
                jQuery.ajax({
                    url     : 'jkn_utils.php',
                    data    : { no_antrian: jQuery("#no-antrian").val() },
                    type    : "POST",
                    dataType: "json",
                    success : function(data){
                                if(data.status == 200){
                                    jQuery("#id_antrian_jkn").val(data.id);
                                    jQuery("#unit_dari_jkn").val(data.unit_id);

                                    // Status BPJS Kesehatan
                                    jQuery("#StatusPas").val(6);
                                    jQuery("#NoAnggota").val(data.nomor_kartu);

                                    // Set jenis layanan
                                    glob_tmpLay = data.unit_id;
                                    jQuery("#JnsLayanan").val(data.parent_id);
                                    jQuery("#JnsLayanan").trigger("change");

                                    if(data.no_rm != null){
                                        alert("Pasien dari JKN ini adalah pasien yang sudah punya RM.");
                                        jQuery("#NoRm").val(data.no_rm);
                                        listPasien({which : 13},'show','NoRm');
                                    }else{
                                        alert("Pasien dari JKN ini adalah pasien baru");
                                        jQuery("#BtnNoRM").trigger("click");
                                    }
                                    showHideJKN();
                                    document.getElementById("btn-show-hide-jkn").disabled = true;
                                    jQuery("#NoKTP").val(data.nik);
                                    jQuery("#Nama").val(data.nama);
                                    
                                }else{
                                    alert("No.antrian tidak ditemukan");
                                }
                            }
                });
            }
        }

        // jQuery("#no-antrian").blur(function(){
        //     showHideJKN(-1);
        // });
        
        function DisableBtn(){
            document.getElementById("btnSimpan").disabled=true;
        }
        
        function EnableBtn(){
            document.getElementById("btnSimpan").disabled=false;
        }
        
        function DokterT()
        {
            var idDok = document.getElementById("cmbDokter").value;
            var idUnit1 = document.getElementById("TmpLayanan").value;
            
            EnableBtn();
            jQuery("#loadS").load("update_in_out.php?in=cDokterG&idDok="+idDok+"&idUnit1="+idUnit1,'',function(){
                //setTarip('setThrough');
                 document.getElementById('spanTarif').innerHTML = document.getElementById('Retribusi').options[document.getElementById('Retribusi').options.selectedIndex].lang;
            });
        }
        
        jQuery(document).ready(function(){
            setAwalLokasi();
            jQuery("#TglLahir").mask("99-99-9999");
            jQuery("#telp").numeric();
            
            jQuery("#th").numeric();
            jQuery("#Bln").numeric();
            jQuery("#hari").numeric();
            jQuery("#rt").numeric();
            jQuery("#rw").numeric();
            jQuery("#NoRm").numeric();
        });
        
        
        function tes2(ev,par)
        {
            jQuery("#th").focus();
            cekTglN();
            //gantiTgl2();
        }
        
        function cekTglN()
        {
            var tmp = jQuery("#TglLahir").val();
            var tmpSplit = tmp.split('-');
            if(tmpSplit[0] > 31)
            {
                tmpSplit[0] = 31;
            }else if(tmpSplit[1] > 12){
                tmpSplit[1] = 12;
                
            }
            var tgltmp = tmpSplit[0]+"-"+tmpSplit[1]+"-"+tmpSplit[2];
            //alert(tmpSplit[0]+"-"+tmpSplit[1]+"-"+tmpSplit[2]);
            jQuery("#TglLahir").val(tgltmp);
            gantiUmur();
            //gantiTgl2();
        }
        
        function gede(a)
        {
            var tmp = a.value
            a.value = tmp.toUpperCase();
        }
        
        function setAwalLokasi()
        {
            document.getElementById("cmbProp").value=6580;
            document.getElementById("prop").value="SUMATERA UTARA";
            document.getElementById("cmbKab").value=12150;
            document.getElementById("kabx").value="KOTA MEDAN";
        }
        
        function listPasien(feel,how,txtId,isdarijkn = false){
            
            if(txtId=='NoKTP'){
                document.getElementById(txtId).focus();
            }
            
            if(feel.which == 123){
                ambilData(1);
                return;
            }
            /*var txtId = 'NoRm*|*Nama*|*Alamat';
                //var stuff = document.getElementById('NoRm').value+"*|*"+document.getElementById('Nama').value+"*|*"+document.getElementById('Alamat').value;*/
            var stuff=document.getElementById(txtId).value;
            //alert(stuff);
            if(how=='show')
            {
                //alert('pasien_list.php?act=cari&txt='+txtId+'&keyword='+stuff)
                if(feel.which==13 && keyword!=stuff)
                {
                    getCabang(jQuery('#asal').val());
                    if (stuff=="")
                    {
                        alert("Masukkan No RM atau Nama Pasien !");
                        return false;
                    }
                    else
                    {
                        /*keyword=stuff;
                        if(txtId != 'NoRm')
                        {
                            stuff = document.getElementById('Nama').value+'<?php echo chr(3);?>'+document.getElementById('Alamat').value+'<?php echo chr(3);?>'+document.getElementById('NoKTP').value; //alert(stuff);
                            document.getElementById('div_pasien').style.display='block';
                            var url = 'pasien_list.php?act=cari&txt='+txtId+'&keyword='+stuff; //alert(url);
                            Request(url,'div_pasien','','GET');
                        }
                        else
                        {
                            document.getElementById('div_pasien').style.display='none'; 
                            //document.getElementById('div_pasien').style.display='block';                      
                            Request('pasien_list.php?act=cari&txt='+txtId+'&keyword='+stuff,'div_pasien','','GET',GetPasienByNorm);
                        }
                        RowIdx=0;*/
                        
                        keyword=stuff;
                        if(txtId == 'NoRm')
                        {
                            String.prototype.lpad = function(padString, length) {
                                var str = this;
                                while (str.length < length)
                                    str = padString + str;
                                return str;
                            }
                            var norm = stuff.lpad('0',8);
                            
                            document.getElementById('div_pasien').style.display='none'; 
                            //document.getElementById('div_pasien').style.display='block';
                            Request('pasien_list.php?lama=1&act=cari&txt='+txtId+'&keyword='+norm+'&cabang='+cabang,'div_pasien','','GET',GetPasienByNorm);
                        }
                        else if(txtId == 'NoKTP')
                        {
                            stuff = document.getElementById('Nama').value+'<?php echo chr(3);?>'+document.getElementById('Alamat').value+'<?php echo chr(3);?>'+document.getElementById('NoKTP').value; //alert(stuff);
                            document.getElementById('div_pasien').style.display='block';
                            var url = 'pasien_list.php?lama=1&act=cari&txt='+txtId+'&keyword='+stuff+'&cabang='+cabang; //alert(url);
                            Request(url,'div_pasien','','GET');
                            
                            /*document.getElementById('NoKTP').disabled=true;
                            document.getElementById('NmOrtu').disabled=true;
                            document.getElementById('Nama').disabled=true;
                            document.getElementById('NmSuTri').disabled=true;
                            document.getElementById('Gender').disabled=true;
                            document.getElementById('Pendidikan').disabled=true;
                            document.getElementById('Pekerjaan').disabled=true;
                            document.getElementById('TglLahir').disabled=true;
                            document.getElementById('th').disabled=true;
                            document.getElementById('Bln').disabled=true;
                            document.getElementById('hari').disabled=true;
                            document.getElementById('cmbAgama').disabled=true;
                            document.getElementById('telp').disabled=true;
                            document.getElementById('Alamat').disabled=true;
                            document.getElementById('rt').disabled=true;
                            document.getElementById('rw').disabled=true;
                            document.getElementById('prop').disabled=true;
                            document.getElementById('kabx').disabled=true;
                            document.getElementById('kecx').disabled=true;
                            document.getElementById('desx').disabled=true;*/
                        }
                        else
                        {
                            stuff = document.getElementById('Nama').value+'<?php echo chr(3);?>'+document.getElementById('Alamat').value+'<?php echo chr(3);?>'+document.getElementById('NoKTP').value; //alert(stuff);
                            document.getElementById('div_pasien').style.display='block';
                            var url = 'pasien_list.php?lama=1&act=cari&txt='+txtId+'&keyword='+stuff+'&cabang='+cabang; //alert(url);
                            Request(url,'div_pasien','','GET');
                        }
                        RowIdx=0;
                    }
                }
                else if ((feel.which==38 || feel.which==40) && document.getElementById('div_pasien').style.display=='block')
                {
                    //alert(feel.which);
                    //alert(keyword);
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
                else if (feel.which==13 && keyword==stuff && RowIdx>0){
                    setPasien(document.getElementById(RowIdx).lang);
                    keyword='';
                }
                
                else if(feel.which==120 && document.getElementById('div_pasien').style.display=='block' && txtId=='NoKTP'){ // tombol F9
                    stuff = document.getElementById('Nama').value+'<?php echo chr(3);?>'+document.getElementById('Alamat').value+'<?php echo chr(3);?>'+document.getElementById('NoKTP').value;
                    var url = 'pasien_list.php?lama=1&act=cari&txt='+txtId+'&keyword='+stuff+'&status=all'+'&cabang='+cabang; //alert(url);
                    Request(url,'div_pasien','','GET');
                }
                if(feel.which==27 || stuff==''){
                    if(feel.which!= 27 && txtId != 'Norm' && (document.getElementById('Nama').value != '' || document.getElementById('Alamat').value != ''))
                        return;
                    document.getElementById('div_pasien').style.display='none';
                    keyword='';
                }
            }
        }
        
        function cJPasien()
        {
            //alert('halo');
            var idDok12 = document.getElementById("cmbDokter").value;
            var TmpLayanan12 = document.getElementById("TmpLayanan").value;
            var TglKunj12 = document.getElementById("TglKunj").value;
            //alert("jmlPasien.php?idDok12="+idDok12+"&TmpLayanan12="+TmpLayanan12+"&TglKunj12="+TglKunj12);
            //jQuery("#loadJDokter").load("jmlPasien.php?idDok12="+idDok12+"&TmpLayanan12="+TmpLayanan12+"&TglKunj12="+TglKunj12);
            
            DisableBtn();
            if(glob_type_dokter=='0'){
                isiCombo('cmbDokReg',document.getElementById('TmpLayanan').value+','+document.getElementById('TglKunj').value,glob_dokter,'cmbDokter',DokterT);
                document.getElementById('chkDokterPengganti').checked = false;
            }
            else{
                isiCombo('cmbDokRegPengganti',document.getElementById('TmpLayanan').value,glob_dokter,'cmbDokter',DokterT);
                document.getElementById('chkDokterPengganti').checked = true;
            }
        }
        
        function setTgl(ev,par){
        //alert(ev.which);
            var tmp = par.value;
            var tmpSplit = tmp.split('-');
            for(var i=0; i<tmpSplit.length; i++){
                if(isNaN(tmpSplit[i]) == true){
                    alert('Masukan tanggal berupa angka!');
                    par.value = '';
                    return;
                }
            }
            
            
            
        if(ev.which!='8'){
        if(tmp.length == 2){
            if(tmp<=31){                
                par.value = tmp+'-';
            }else{
                alert('Tanggal jangan melebihi 31!');
                par.value = 31+'-';
            }
        }
        else if(tmp.length == 5){
            if(parseInt(tmp.substr(3,2))<=12){
                par.value = tmp+'-';
            }else{
                alert('Bulan jangan melebihi 12!');
                tmp = tmp.substr(0,3);
                par.value = tmp+12+'-';
            }
        }
        else if(tmp.length == 10){
            gantiUmur();
        }
        else if(tmp.length > 10){
            par.value = tmp.substr(0,(tmp.length-1));
        }
        }
        }

        var befval = '';
        function filterInap(val,isEdit){
        document.getElementById('dataMasuk').style.display = "none";
        //01-08-2016
            if(val == 11 || val == 13){
                if(val == 11) 
                    isiCombo('cmbPusk','','','dataMasuk');
                else 
                    isiCombo('cmbRSasal','','','dataMasuk');
                document.getElementById('dataMasuk').style.display = "block";
            } else {
                document.getElementById('dataMasuk').style.display = "none";
            }
        
            //jika value asal masuk = 3 (datang sendiri, jenis layanan inap tidak muncul)
          if(val == ''){
             document.getElementById('AslMasuk').value = befval;
             return;
          }
          var reload = true,jns = '',jns_lay = '';
          //var tmp_jns = document.getElementById('JnsLayanan').value;
          var tmp_unit = document.getElementById('TmpLayanan').value;
            if(val == 3  && befval != 3){
             //=====tutup sesuai loket======
             //jns = 'JnsLayananReg';
             jns = 'JnsLayananRegByLoket';
            }
            else if(befval == 3 && val != 3){
             //=====tutup sesuai loket=====
             //jns = 'JnsLayananFull';
             jns = 'JnsLayananFullByLoket';
                //isiCombo('JnsLayananFull','', glob_jnsLay,'JnsLayanan',isiTmpLay);
            }
          else{
             reload = false;
          }
          if (isEdit==1){
             if(val == 3){
                //=====tutup sesuai loket====
                //jns = 'JnsLayananReg';
                jns = 'JnsLayananRegByLoket';
             }
             else{
                //=====tutup sesuai loket=====
                //jns = 'JnsLayananFull';
                jns = 'JnsLayananFullByLoket';
             }
             reload = true;
              jns_lay = glob_jnsLay;
              if(glob_tmpLay != ''){
                tmp_unit = glob_tmpLay;
              }
          }else{
              jns_lay = document.getElementById('JnsLayanan').value
          }
          
          if(reload == true){
            //====tutup sesuai loket=====
            //isiCombo(jns, '', jns_lay, 'JnsLayanan'
            isiCombo(jns, document.getElementById('asal').value, jns_lay, 'JnsLayanan'
                    , function(){
                       //if(glob_tmpLay != ''){
                       //}
                       //document.getElementById('JnsLayanan').value = tmp_jns;
                       //isiCombo('TmpLayananDenganInap',document.getElementById('JnsLayanan').value, tmp_unit,'TmpLayanan',setKelas);
                       isiCombo('TmpLayananDenganInapByReg',document.getElementById('JnsLayanan').value+','+document.getElementById('asal').value, tmp_unit,'TmpLayanan',setKelas);
                       });
            document.getElementById('JnsLayanan_sjp').value = jns_lay;
            isiCombo('TmpLayanan_sjp',document.getElementById('JnsLayanan_sjp').value+','+document.getElementById('asal').value, tmp_unit,'TmpLayanan_sjp',setKelas_sjp);
            //isiCombo('TmpLayanan_sjpByReg',document.getElementById('JnsLayanan_sjp').value+','+document.getElementById('asal').value, tmp_unit,'TmpLayanan_sjp',setKelas_sjp);
          }
            /*else{
            //alert(glob_jnsLay);
            var jns = ((val != 3)?'JnsLayananFull':'JnsLayananReg');
            if (isEdit==1){
                isiCombo(jns, '', glob_jnsLay, 'JnsLayanan', isiTmpLay);
            }else{
                isiCombo(jns, '', document.getElementById('JnsLayanan').value, 'JnsLayanan', isiTmpLay);
            }*/
            //}

            befval = val;
        }

        function getNoRM(){
            //alert('registrasi_utils.php?act=getNoRM');
            document.getElementById("txtIdKunj").value="";
            document.getElementById("txtIdPasien").value="";
            document.getElementById("IsNewPas").value="1";
            // Request('registrasi_utils.php?act=getNoRM','txtNoRM','','GET',setNoRM,'ok');
            Request('registrasi_utils.php?act=getNoRM&cabang='+cabang,'txtNoRM','','GET',setNoRM,'ok');
        }
        function setNoRM(){
            document.getElementById('NoRm').value = document.getElementById('txtNoRM').value;
            getNoBil();
            SetDisable(4);
        }
        
        function getNoRM1(){
            //alert('registrasi_utils.php?act=getNoRM');
            //alert(document.getElementById("cmbDokter").value);
            //if(document.getElementById("cmbDokter").value=='' || document.getElementById("cmbDokter").value==0)
            if(cabang == 1){
                if(document.getElementById("StatusPas").value == 6 && document.getElementById('NoSJP').value == ''){
                    if(document.getElementById("TmpLayanan").value != 45){
                    // document.getElementById('NoSJP').style.background-color = "#B1D8FC";
                        alert("Maaf Untuk Pasien BPJS No SJP/SKP Tidak Boleh Kosong!");
                        return false;
                    }
                }
            } else {
                // document.getElementById('NoSJP').style.background-color = "#D5FED9";
            }
            if(document.getElementById("cmbDokter").value=='')
            {
                alert("anda belum memilih dokter... harap memilih dokter terlebih dahulu!!!");
            }
            
            if(document.getElementById('NoRm').value=='')
            {
                document.getElementById("txtIdKunj").value="";
                document.getElementById("txtIdPasien").value="";
                document.getElementById("IsNewPas").value="1";
                //Request('registrasi_utils.php?act=getNoRM','txtNoRM','','GET',setNoRM1,'ok'); 
                Request('registrasi_utils.php?act=getNoRM&cabang='+cabang,'txtNoRM','','GET',setNoRM1,'ok');    
            }else{
                simpan(document.getElementById('btnSimpan').value); 
            }
        }
        function setNoRM1(){
            document.getElementById('NoRm').value = document.getElementById('txtNoRM').value;
            getNoBil();
            SetDisable(4);
            simpan(document.getElementById('btnSimpan').value);
        }

        var dataPasien = new Array();

        function setPasien(val){
            console.log(val.split('|'));
            dataPasien=val.split("|");
            var p="";
            //alert(val);
            //alert(dataPasien.length);
            if (dataPasien.length>29){
                KunjAktif=true;
                p="txtIdPasien*-*"+dataPasien[0]+"*|*NoRm*-*"+dataPasien[1]+"*|*NmOrtu*-*"+dataPasien[11]+"*|*Nama*-*"+dataPasien[2]
                +"*|*NmSuTri*-*"+dataPasien[12]+"*|*Gender*-*"+dataPasien[13]+"*|*TglLahir*-*"+dataPasien[3]+"*|*Alamat*-*"+dataPasien[4]
                +"*|*cmbProp*-*"+dataPasien[10]+"*|*cmbKab*-*"+dataPasien[9]+"*|*cmbKec*-*"+dataPasien[8]+"*|*cmbDesa*-*"+dataPasien[7]
                +"*|*rt*-*"+dataPasien[5]+"*|*rw*-*"+dataPasien[6]+"*|*Pendidikan*-*"+dataPasien[14]+"*|*Pekerjaan*-*"+dataPasien[15]
                +"*|*cmbAgama*-*"+dataPasien[16]+"*|*telp*-*"+dataPasien[17]+"*|*StatusPas*-*"+dataPasien[18]+"*|*Penjamin*-*"+dataPasien[18]
                +"*|*NoAnggota*-*"+dataPasien[19]+"*|*HakKelas*-*"+dataPasien[20]+"*|*StatusPenj*-*"+dataPasien[21]+"*|*txtIdKunj*-*"+dataPasien[22]+"*|*TglKunj*-*"+dataPasien[23]+"*|*AslMasuk*-*"+dataPasien[24]+"*|*StatusPas*-*"+dataPasien[18]+"*|*TglSJP*-*"+dataPasien[25]+"*|*NoSJP*-*"+dataPasien[26]+"*|*NoKTP*-*"+dataPasien[32]+"*|*desx*-*"+dataPasien[33]+"*|*kecx*-*"+dataPasien[34]+"*|*kabx*-*"+dataPasien[35]+"*|*prop*-*"+dataPasien[36]+"*|*darah*-*"+dataPasien[37]+"*|*cmbKw*-*"+dataPasien[40];
                //alert(dataPasien);
                glob_jnsLay=dataPasien[27];
                glob_tmpLay=dataPasien[28];
                glob_kamar=dataPasien[29];
                glob_kelas=dataPasien[30];
                glob_ret = dataPasien[31];
                cIdPas=dataPasien[0];
                cIdKunj=dataPasien[22];
                cUnit=dataPasien[28];
                filterInap(dataPasien[27],1);
            }else{
                KunjAktif=false;
                var p="txtIdPasien*-*"+dataPasien[0]+"*|*NoRm*-*"+dataPasien[1]+"*|*NoKTP*-*"+dataPasien[22]+"*|*NmOrtu*-*"+dataPasien[11]+"*|*Nama*-*"+dataPasien[2]
                +"*|*NmSuTri*-*"+dataPasien[12]+"*|*Gender*-*"+dataPasien[13]+"*|*TglLahir*-*"+dataPasien[3]+"*|*Alamat*-*"+dataPasien[4]
                +"*|*cmbProp*-*"+dataPasien[10]+"*|*cmbKab*-*"+dataPasien[9]+"*|*cmbKec*-*"+dataPasien[8]+"*|*cmbDesa*-*"+dataPasien[7]
                +"*|*rt*-*"+dataPasien[5]+"*|*rw*-*"+dataPasien[6]+"*|*Pendidikan*-*"+dataPasien[14]+"*|*Pekerjaan*-*"+dataPasien[15]
                +"*|*cmbAgama*-*"+dataPasien[16]+"*|*telp*-*"+dataPasien[17]+"*|*StatusPas*-*"+dataPasien[18]+"*|*Penjamin*-*"+dataPasien[18]
                +"*|*NoAnggota*-*"+dataPasien[19]+"*|*HakKelas*-*"+dataPasien[20]+"*|*StatusPenj*-*"+dataPasien[21]+"*|*txtIdKunj*-**|*desx*-*"+dataPasien[23]+"*|*kecx*-*"+dataPasien[24]+"*|*kabx*-*"+dataPasien[25]+"*|*prop*-*"+dataPasien[26]+"*|*darah*-*"+dataPasien[27];
                if(dataPasien[0]==''){
                    getNoRM();  
                }
            }
            if(document.getElementById('asal').value == 108){
                document.getElementById('skpJamkesda').disabled = false;
                document.getElementById('UpdStatusPx').disabled = false;                
                //alert("registrasi_utils.php?act=jamkeskah&idKunj="+cIdKunj);
                Request("registrasi_utils.php?act=jamkeskah&idKunj="+cIdKunj,'skpDiv','','GET',skpCek);
            }
            
            //alert(p);
            cIdPas=dataPasien[0];
            fSetValue(window,p);
            document.getElementById("IsNewPas").value="0";
            isiCombo('cmbKab',((dataPasien[10]!='')?dataPasien[10]:1),(dataPasien[9]!='')?dataPasien[9]:1182);
            isiCombo('cmbKec',dataPasien[9],dataPasien[8]);
            isiCombo('cmbDesa',dataPasien[8],dataPasien[7]);
            gantiUmur();
            document.getElementById('div_pasien').style.display='none';
            //alert(dataPasien[18]);
                        
            if(dataPasien[18]!=undefined || dataPasien[18]!=''){
                setPenjamin(dataPasien[18]);                
            }
            else{
                setPenjamin(1);
            }
            getNoBil();
            if (dataPasien.length>29){
                //alert('aktif');
                SetDisable(1);
                document.getElementById("divKunjLagi").style.display="block";
            }else{
                SetDisable(0);
                SetAsalMasuk();
                document.getElementById("divKunjLagi").style.display="none";
            }
            // SetDisable(6);
            /*document.getElementById('NoKTP').disabled=true;
            document.getElementById('NmOrtu').disabled=true;
            document.getElementById('Nama').disabled=true;
            document.getElementById('NmSuTri').disabled=true;
            document.getElementById('Gender').disabled=true;
            document.getElementById('Pendidikan').disabled=true;
            document.getElementById('Pekerjaan').disabled=true;
            document.getElementById('TglLahir').disabled=true;
            document.getElementById('th').disabled=true;
            document.getElementById('Bln').disabled=true;
            document.getElementById('hari').disabled=true;
            document.getElementById('cmbAgama').disabled=true;
            document.getElementById('telp').disabled=true;
            document.getElementById('Alamat').disabled=true;
            document.getElementById('rt').disabled=true;
            document.getElementById('rw').disabled=true;
            document.getElementById('prop').disabled=true;
            document.getElementById('kabx').disabled=true;
            document.getElementById('kecx').disabled=true;
            document.getElementById('desx').disabled=true;*/
            jQuery("#loadG").load("gambar1.php?id_pasien="+dataPasien[0]);
            nm_pas = dataPasien[2];
            if(dataPasien[32] != "")
            {
                nip_pas = dataPasien[32];
            }else{
                nip_pas = dataPasien[22];
            }
            jns_pas = dataPasien[13];
        }
        
       function setSIAKAD()
       {
           document.getElementById("siakadStat").value = 1;
       }
       
       function skpCek(){
          if(document.getElementById('skpDiv').innerHTML>0){          
             //document.getElementById('skpJamkesdaKmr').disabled = false;           
          }
          else{
             //document.getElementById('skpJamkesdaKmr').disabled = true;             
          }
       }
        
        function SetKunjungLagi(){
            SetDisable(0);
            fSetValue(window,"txtIdKunj*-**|*TglKunj*-*<?php echo $date_now;?>*|*TglSJP*-*<?php echo $date_now;?>");
            SetAsalMasuk();
            document.getElementById('divKunjLagi').style.display="none";
        }
        
        function SetAsalMasuk(){
            if (document.getElementById('StatusPas').value=="1" || document.getElementById('StatusPas').value=="2"){
                fSetValue(window,"AslMasuk*-*3");
            }else if (document.getElementById('StatusPas').value=="4"){
                fSetValue(window,"AslMasuk*-*11");
            }else if (document.getElementById('StatusPas').value=="16" || document.getElementById('StatusPas').value=="2"){
                fSetValue(window,"AslMasuk*-*2");
            }else if (document.getElementById('StatusPas').value=="38" || document.getElementById('StatusPas').value=="39" || document.getElementById('StatusPas').value=="46" || document.getElementById('StatusPas').value=="53" || document.getElementById('StatusPas').value=="64"){
                
            }else{
                fSetValue(window,"AslMasuk*-*4");
            }
            filterInap(document.getElementById('AslMasuk').value,0);
        }

        function GetPasienByNorm(){
            var tbl=document.getElementById('pasien_table');
            var crow=tbl.rows.length;
            //alert('awas ada block yg herus dibuka');
            if(crow==2){
                setPasien(document.getElementById('1').lang);
                document.getElementById('AslMasuk').focus();
            }else{
                document.getElementById('div_pasien').style.display='block';
            }
        }

        function isiKab(){
            isiCombo('cmbKab',document.getElementById('cmbProp').value,'','',isiKec);
        }

        function isiKec(){
            isiCombo('cmbKec',document.getElementById('cmbKab').value,'','',isiDesa);
        }

        function isiDesa(){
            isiCombo('cmbDesa',document.getElementById('cmbKec').value);
        }
        /*isi combobox:
    id => elemen target
    val => parameter (bisa multiple dengan sparator ',')
    defaultId => value yang akan diselected
         */
         
        function SetDisable(p){
        var p;
            if (p==1){
                document.getElementById('NoRm').disabled=true;
                document.getElementById('NoKTP').disabled=true;
                document.getElementById('BtnNoRM').disabled=true;
                document.getElementById('Nama').disabled=true;
                document.getElementById('NmOrtu').disabled=true;
                document.getElementById('NmSuTri').disabled=true;
                document.getElementById('Gender').disabled=true;
                document.getElementById('cmbKw').disabled=true;
                
                document.getElementById('Pendidikan').disabled=true;
                document.getElementById('Pekerjaan').disabled=true;
                document.getElementById('TglLahir').disabled=true;
                document.getElementById('ButtonTglLahir').disabled=true;
                document.getElementById('th').disabled=true;
                document.getElementById('Bln').disabled=true;
                document.getElementById('hari').disabled=true;
                document.getElementById('cmbAgama').disabled=true;
                document.getElementById('Alamat').disabled=true;
                document.getElementById('telp').disabled=true;
                
                document.getElementById('rt').disabled=true;
                document.getElementById('rw').disabled=true;
                document.getElementById('prop').disabled=true;
                document.getElementById('cmbProp').disabled=true;
                document.getElementById('kabx').disabled=true;
                document.getElementById('cmbKab').disabled=true;
                document.getElementById('kecx').disabled=true;
                document.getElementById('cmbKec').disabled=true;
                document.getElementById('desx').disabled=true;
                document.getElementById('cmbDesa').disabled=true;
                document.getElementById('txtPenjamin').disabled=true;
                
                document.getElementById('NoAnggota').disabled=true;
                document.getElementById('HakKelas').disabled=true;
                document.getElementById('StatusPenj').disabled=true;
                document.getElementById('TglKunj').disabled=true;
                //document.getElementById('ButtonTglKunj').disabled=true;
                document.getElementById('AslMasuk').disabled=true;
                document.getElementById('dataMasuk').disabled=true;
                document.getElementById('Ket').disabled=true;
                
                document.getElementById('StatusPas').disabled=true;
                document.getElementById('TglSJP').disabled=true;
                document.getElementById('ButtonTglSJP').disabled=true;
                document.getElementById('NoSJP').disabled=true;
                document.getElementById('JnsLayanan').disabled=true;
                document.getElementById('TmpLayanan').disabled=true;
                document.getElementById('cmbKelas').disabled=true;
                document.getElementById('Retribusi').disabled=true;
                document.getElementById('kamar').disabled=true;
                document.getElementById('darah').disabled=true;
                
                document.getElementById('cmbDokter').disabled=true;
                document.getElementById('chkDokterPengganti').disabled=true;
                
                document.getElementById('getSJP').disabled=true;
                document.getElementById('flag').disabled=true;
                
                document.getElementById('btnSimpan').value="  Ubah  ";
            }else if (p==0){
                document.getElementById('NoRm').disabled=true;
                document.getElementById('NoKTP').disabled=false;
                document.getElementById('BtnNoRM').disabled=true;
                document.getElementById('Nama').disabled=false;
                document.getElementById('NmOrtu').disabled=false;
                document.getElementById('NmSuTri').disabled=false;
                document.getElementById('Gender').disabled=false;
                document.getElementById('cmbKw').disabled=false;
                
                document.getElementById('Pendidikan').disabled=false;
                document.getElementById('Pekerjaan').disabled=false;
                document.getElementById('TglLahir').disabled=false;
                document.getElementById('ButtonTglLahir').disabled=false;
                document.getElementById('th').disabled=false;
                document.getElementById('Bln').disabled=false;
                document.getElementById('hari').disabled=false;
                document.getElementById('cmbAgama').disabled=false;
                document.getElementById('Alamat').disabled=false;
                document.getElementById('telp').disabled=false;
                
                document.getElementById('rt').disabled=false;
                document.getElementById('rw').disabled=false;
                
                document.getElementById('prop').disabled=false;
                document.getElementById('cmbProp').disabled=false;
                document.getElementById('kabx').disabled=false;
                document.getElementById('cmbKab').disabled=false;
                document.getElementById('kecx').disabled=false;
                document.getElementById('cmbKec').disabled=false;
                document.getElementById('desx').disabled=false;
                document.getElementById('cmbDesa').disabled=false;
                
                
                document.getElementById('txtPenjamin').disabled=false;
                
                document.getElementById('NoAnggota').disabled=false;
                document.getElementById('HakKelas').disabled=false;
                document.getElementById('StatusPenj').disabled=false;
                document.getElementById('TglKunj').disabled=false;
                //document.getElementById('ButtonTglKunj').disabled=false;
                document.getElementById('AslMasuk').disabled=false;
                document.getElementById('dataMasuk').disabled=false;
                document.getElementById('Ket').disabled=false;
                
                document.getElementById('StatusPas').disabled=false;
                document.getElementById('TglSJP').disabled=false;
                document.getElementById('ButtonTglSJP').disabled=false;
                document.getElementById('NoSJP').disabled=false;
                document.getElementById('JnsLayanan').disabled=false;
                document.getElementById('TmpLayanan').disabled=false;
                document.getElementById('cmbKelas').disabled=false;
                document.getElementById('Retribusi').disabled=false;
                document.getElementById('kamar').disabled=false;
                
                document.getElementById('cmbDokter').disabled=false;
                document.getElementById('chkDokterPengganti').disabled=false;
                document.getElementById('darah').disabled=false;

                /*if(document.getElementById('asal').value == 110){
                    document.getElementById('getSJP').disabled=false;
                }else{
                    document.getElementById('getSJP').disabled=true;
                }*/

                document.getElementById('btnSimpan').value="Tambah";
            }else if (p==2){
                document.getElementById('NoRm').disabled=true;
                document.getElementById('BtnNoRM').disabled=true;
                document.getElementById('Nama').disabled=true;
                setPenjamin(document.getElementById('StatusPas').value);
            }else if (p==3){
                document.getElementById('NoRm').disabled=false;
                document.getElementById('BtnNoRM').disabled=false;
                //document.getElementById('Nama').disabled=true;
                document.getElementById('Nama').disabled=false;
                setPenjamin(document.getElementById('StatusPas').value);
            }else if (p==4){
                document.getElementById('NoRm').disabled=true;
                document.getElementById('BtnNoRM').disabled=true;
                //document.getElementById('Nama').disabled=false;
                setPenjamin(document.getElementById('StatusPas').value);
            }else if (p==5){
                document.getElementById('NoAnggota').disabled=true;
                document.getElementById('HakKelas').disabled=true;
                document.getElementById('StatusPenj').disabled=true;
                document.getElementById('txtPenjamin').disabled=true;
                /*if(document.getElementById('asal').value == 110){
                    document.getElementById('getSJP').disabled=false;
                }else{
                    document.getElementById('getSJP').disabled=true;
                }*/
            }else if(p==6){
                document.getElementById('NoRm').disabled=true;
                document.getElementById('BtnNoRM').disabled=true;
                document.getElementById('Nama').disabled=true;
                setPenjamin(document.getElementById('StatusPas').value);
                document.getElementById('NoKTP').disabled=true;
                document.getElementById('NmOrtu').disabled=true;
                document.getElementById('Nama').disabled=true;
                document.getElementById('NmSuTri').disabled=true;
                document.getElementById('Gender').disabled=true;
                document.getElementById('cmbKw').disabled=true;
                document.getElementById('Pendidikan').disabled=true;
                document.getElementById('Pekerjaan').disabled=true;
                document.getElementById('TglLahir').disabled=true;
                document.getElementById('th').disabled=true;
                document.getElementById('Bln').disabled=true;
                document.getElementById('hari').disabled=true;
                document.getElementById('cmbAgama').disabled=true;
                document.getElementById('telp').disabled=true;
                document.getElementById('Alamat').disabled=true;
                document.getElementById('rt').disabled=true;
                document.getElementById('rw').disabled=true;
                document.getElementById('prop').disabled=true;
                document.getElementById('kabx').disabled=true;
                document.getElementById('kecx').disabled=true;
                document.getElementById('desx').disabled=true;
            } else if(p==7){
                document.getElementById('prop').disabled=true;
                document.getElementById('kabx').disabled=true;
                document.getElementById('kecx').disabled=true;
                document.getElementById('desx').disabled=true;
                
                document.getElementById('prop').style.background = "#D5FED9";
                document.getElementById('kabx').style.background = "#D5FED9";
                document.getElementById('kecx').style.background = "#D5FED9";
                document.getElementById('desx').style.background = "#D5FED9";
            } else if(p==8){//
                document.getElementById('prop').disabled=false;
                document.getElementById('ButtonTglLahir').disabled=false;
                document.getElementById('kabx').disabled=false;
                document.getElementById('kecx').disabled=false;
                document.getElementById('desx').disabled=false;
                document.getElementById('prop').style.background = "#B1D8FC";
                document.getElementById('kabx').style.background = "#B1D8FC";
                document.getElementById('kecx').style.background = "#B1D8FC";
                document.getElementById('desx').style.background = "#B1D8FC";
            }
        }
        
        function almtDis(kwn){
            if(kwn > 1){
                SetDisable(7);
            } else {
                SetDisable(8);
            }
        }
        
        function isiCombo(id,val,defaultId,targetId,evloaded){
            if(targetId=='' || targetId==undefined){
                targetId=id;
            }
            var all = '';
            if(id == 'userLog'){
                //alert('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId)
                all = '&all=1';
            }
            Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId+all,targetId,'','GET',evloaded,'ok');
            //alert('combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId);
        }

        isiCombo('Pendidikan');
        isiCombo('Pekerjaan','','14');
        isiCombo('cmbProp','',(dataPasien[10]!=undefined)?dataPasien[10]:50089);
        isiCombo('cmbKab',((dataPasien[10]!=undefined)?dataPasien[10]:50089),(dataPasien[9]!=undefined)?dataPasien[9]:51506);
        isiCombo('cmbKec',((dataPasien[9]!=undefined)?dataPasien[9]:51506),(dataPasien[8]!=undefined)?dataPasien[8]:51507);
        isiCombo('cmbDesa',((dataPasien[8]!=undefined)?dataPasien[8]:51507),(dataPasien[7]!=undefined)?dataPasien[7]:51508);
        isiCombo('AslMasuk','',3,'AslMasuk',function(){befval=document.getElementById('AslMasuk').value});
        
        //=====================ditutup --> tergantung loket yg dibuka===============
        //isiCombo('JnsLayananReg','','1','JnsLayanan',isiTmpLay);
        //isiCombo('JnsLayanan_sjp','','1','JnsLayanan_sjp',isiTmpLay_sjp);
        isiCombo('JnsLayanan_sjp','','1','JnsLayanan_sjp',isiTmpLay_sjp);
        //=====================ditutup --> tergantung loket yg dibuka===============
        //getNoRM();

        function isiTmpLay(pass){
            DisableBtn();
            if(pass == 'setThrough'){
                document.getElementById('JnsLayanan_sjp').value = document.getElementById('JnsLayanan').value;
                isiTmpLay_sjp();
            }
            //alert(document.getElementById('TmpLayanan_sjp').value);
            isiCombo('TmpLayananDenganInapByReg',document.getElementById('JnsLayanan').value+','+document.getElementById('asal').value, glob_tmpLay,'TmpLayanan',setKelas);
            //tandai disini
            isiCombo('TmpLayananDenganInapByReg',document.getElementById('jenislayananpcr').value+','+document.getElementById('asal').value, 232,'tmplayananpcr',cmbDokterPcr);
            
            /**
             * ismul
             */

            if(document.getElementById('JnsLayanan').value == 1){
                jQuery('#titleKelompokTindakanMcu').show();
                jQuery('#KelompokTindakanMcu').show();
            }else{
                jQuery('#titleKelompokTindakanMcu').hide();
                jQuery('#KelompokTindakanMcu').hide();
            }
        }

        function isiTmpLayPcr(pass){
            isiCombo('TmpLayananDenganInapByReg',document.getElementById('jenislayananpcr').value+','+document.getElementById('asal').value, 232,'tmplayananpcr',cmbDokterPcr);
        }

        isiCombo('cmbAgama');
        isiCombo('cmbKw');
        isiCombo('HakKelas','','','HakKelas');

        function cmbDokterPcr(pass){
            if(glob_type_dokter=='0'){
                isiCombo('cmbDokReg',document.getElementById('tmplayananpcr').value+','+document.getElementById('TglKunj').value,glob_dokter,'cmbdokterpcr');
                document.getElementById('chkDokterPenggantiPcr').checked = false;
            }
            else{
                isiCombo('cmbDokRegPengganti',document.getElementById('tmplayananpcr').value,glob_dokter,'cmbdokterpcr');
                document.getElementById('chkDokterPenggantiPcr').checked = true;
            }
            isiCombo('RetribusiPcrKlinik', document.getElementById('jenislayananpcr').value+','+document.getElementById('tmplayananpcr').value, '', 'cmbRetrbibusiPcrKlinik',taripPcrRetribusi);
            
        }

        function taripPcrRetribusi(){
            document.getElementById('spanTarifPcr').innerHTML ='Rp'+document.getElementById('cmbRetrbibusiPcrKlinik').options[document.getElementById('cmbRetrbibusiPcrKlinik').options.selectedIndex].lang;
        }

        function isiTmpLay_sjp(pass){
            if(pass == 'setThrough'){
                document.getElementById('JnsLayanan').value = document.getElementById('JnsLayanan_sjp').value;
                isiTmpLay();
            }
            isiCombo('TmpLayanan_sjp',document.getElementById('JnsLayanan_sjp').value, glob_tmpLay,'TmpLayanan_sjp',setKelas_sjp);
        }
        isiCombo('HakKelasSJP','','','HakKelas_sjp');

        function setKelas(pass){
            if(pass == 'setThrough'){
                //alert(document.getElementById('TmpLayanan_sjp').value);
                document.getElementById('TmpLayanan_sjp').value = document.getElementById('TmpLayanan').value;
                setKelas_sjp();
            }
            //alert(document.getElementById('TmpLayanan').options[document.getElementById('TmpLayanan').options.selectedIndex].lang);
            var tmp = document.getElementById('TmpLayanan').options[document.getElementById('TmpLayanan').options.selectedIndex].lang;
            //alert(document.getElementById('TmpLayanan').value+','+document.getElementById('JnsLayanan').value+','+tmp);
            var stpas=document.getElementById('StatusPas').value;
            if (stpas == '38' || stpas == '39' || stpas == '46' || stpas == '53' || stpas == '64'){
                isiCombo('cmbKelasPasienJamkesmas',document.getElementById('TmpLayanan').value+','+document.getElementById('JnsLayanan').value+','+tmp, glob_kelas,'cmbKelas',isiKamar);
            }else{
                isiCombo('cmbKelasPasien',document.getElementById('TmpLayanan').value+','+document.getElementById('JnsLayanan').value+','+tmp, glob_kelas,'cmbKelas',isiKamar);
            }
            
            if(glob_type_dokter=='0'){
                isiCombo('cmbDokReg',document.getElementById('TmpLayanan').value+','+document.getElementById('TglKunj').value,glob_dokter,'cmbDokter');
                document.getElementById('chkDokterPengganti').checked = false;
            }
            else{
                isiCombo('cmbDokRegPengganti',document.getElementById('TmpLayanan').value,glob_dokter,'cmbDokter');
                document.getElementById('chkDokterPengganti').checked = true;
            }
        }

        function setKelas_sjp(pass){
            if(pass == 'setThrough'){
                document.getElementById('TmpLayanan').value = document.getElementById('TmpLayanan_sjp').value;
                setKelas();
            }
            
           var tmp = document.getElementById('TmpLayanan_sjp').options[document.getElementById('TmpLayanan_sjp').options.selectedIndex].lang;
            var stpas=document.getElementById('StatusPas').value;
            
            //-----------------hidden 25-07-2016-----------
             if (stpas == '38' || stpas == '39' || stpas == '46' || stpas == '53' || stpas == '64'){
                isiCombo('cmbKelasPasienJamkesmas',document.getElementById('TmpLayanan_sjp').value+','+document.getElementById('JnsLayanan_sjp').value+','+tmp, glob_kelas,'cmbKelas_sjp',isiKamar_sjp);
            }else{
                isiCombo('cmbKelasPasien',document.getElementById('TmpLayanan_sjp').value+','+document.getElementById('JnsLayanan_sjp').value+','+tmp, glob_kelas,'cmbKelas_sjp',isiKamar_sjp);
            } 
            
            //---------End hidden 25-07-2016----------------
        }

        function isiKamar(pass){
            if(pass == 'setThrough'){
                document.getElementById('cmbKelas_sjp').value = document.getElementById('cmbKelas').value;
                isiKamar_sjp();
            }
            var tmp = document.getElementById('TmpLayanan').options[document.getElementById('TmpLayanan').options.selectedIndex].lang;
            if(tmp == 1){
                document.getElementById('td_ret').style.display = 'none';
                document.getElementById('td_ret1').style.display = 'none';
                document.getElementById('td_room').style.display = '';
                document.getElementById('td_room1').style.display = '';
                isiCombo('kamar', document.getElementById('TmpLayanan').value+','+document.getElementById('cmbKelas').value, document.getElementById('div_room').innerHTML, 'kamar', setTarip);
                document.getElementById('div_room').innerHTML = '';

                //getTaripKamar(document.getElementById('kamar').value);
            }
            else{
                document.getElementById('td_ret').style.display = '';
                document.getElementById('td_ret1').style.display = '';
                document.getElementById('td_room').style.display = 'none';
                document.getElementById('td_room1').style.display = 'none';
                var jnsLay = document.getElementById('JnsLayanan').value;
                var tmpLay = document.getElementById('TmpLayanan').value;
                //document.getElementById('cmbKelas').value+','+document.getElementById('TmpLayanan').value
                //alert(jnsLay+','+tmpLay);
                isiCombo('Retribusi', jnsLay+','+tmpLay, glob_ret, '', setTarip);
            }
        }

        function isiKamar_sjp(pass){
            if(pass == 'setThrough'){
                document.getElementById('cmbKelas').value = document.getElementById('cmbKelas_sjp').value;
                isiKamar();
            }
            var tmp = document.getElementById('TmpLayanan_sjp').options[document.getElementById('TmpLayanan_sjp').options.selectedIndex].lang;
            if(tmp == 1){
                document.getElementById('td_ret_sjp').style.display = 'none';
                document.getElementById('td_ret1_sjp').style.display = 'none';
                document.getElementById('td_room_sjp').style.display = '';
                document.getElementById('td_room1_sjp').style.display = '';
                isiCombo('kamar', document.getElementById('TmpLayanan_sjp').value+','+document.getElementById('cmbKelas_sjp').value, document.getElementById('div_room_sjp').innerHTML, 'kamar_sjp', setTarip_sjp);
                document.getElementById('div_room_sjp').innerHTML = '';

                //getTaripKamar(document.getElementById('kamar').value);
            }
            else{
                document.getElementById('td_ret_sjp').style.display = '';
                document.getElementById('td_ret1_sjp').style.display = '';
                document.getElementById('td_room_sjp').style.display = 'none';
                document.getElementById('td_room1_sjp').style.display = 'none';
                var jnsLay = document.getElementById('JnsLayanan_sjp').value;
                var tmpLay = document.getElementById('TmpLayanan_sjp').value;
                //document.getElementById('cmbKelas').value+','+document.getElementById('TmpLayanan').value
                //alert(jnsLay+','+tmpLay);
                isiCombo('Retribusi', jnsLay+','+tmpLay, glob_ret, 'Retribusi_sjp', setTarip_sjp);
            }
        }
        
        function setTarip(pass){
            var tmp = document.getElementById('TmpLayanan').options[document.getElementById('TmpLayanan').options.selectedIndex].lang;
            if(tmp == 1){
                document.getElementById('spanTarifKamar').innerHTML = document.getElementById('kamar').options[document.getElementById('kamar').options.selectedIndex].lang;
            }
            else{
                //alert(document.getElementById('Retribusi').options[document.getElementById('Retribusi').options.selectedIndex].lang);
               document.getElementById('spanTarif').innerHTML = document.getElementById('Retribusi').options[document.getElementById('Retribusi').options.selectedIndex].lang;
            }
            if(pass == 'setThrough'){
                document.getElementById('Retribusi_sjp').value = document.getElementById('Retribusi').value;
                document.getElementById('spanTarif_sjp').innerHTML = document.getElementById('spanTarif').innerHTML;
                document.getElementById('kamar_sjp').value = document.getElementById('kamar').value;
                document.getElementById('spanTarifKamar_sjp').innerHTML = document.getElementById('spanTarifKamar').innerHTML;
                //setTarip_sjp('no_repeat');
            }
            cJPasien();
        }

        function setTarip_sjp(pass){
            var tmp = document.getElementById('TmpLayanan_sjp').options[document.getElementById('TmpLayanan_sjp').options.selectedIndex].lang;
            if(tmp == 1){
                tmp = document.getElementById('kamar_sjp').options[document.getElementById('kamar_sjp').options.selectedIndex].lang;
                document.getElementById('spanTarifKamar_sjp').innerHTML = tmp;
                //document.getElementById('spanTarifKamar').innerHTML = tmp;
            }
            else{
                //alert(document.getElementById('Retribusi').options[document.getElementById('Retribusi').options.selectedIndex].lang);
               tmp = document.getElementById('Retribusi_sjp').options[document.getElementById('Retribusi_sjp').options.selectedIndex].lang;
               document.getElementById('spanTarif_sjp').innerHTML = tmp;
               //document.getElementById('spanTarif').innerHTML = tmp;
            }
            
            if(pass == 'setThrough'){
                document.getElementById('kamar').value = document.getElementById('kamar_sjp').value;
                document.getElementById('Retribusi').value = document.getElementById('Retribusi_sjp').value;
                document.getElementById('spanTarifKamar').innerHTML = document.getElementById('spanTarifKamar_sjp').innerHTML;
                document.getElementById('spanTarif').innerHTML = document.getElementById('spanTarif_sjp').innerHTML;
                //setTarip();
            }
        }

        /*var p="ok,NoAnggota,HakKelas,StatusPenj,txtPenjamin";
        fDisable(p,'ok-0');*/
        SetDisable(3);

        //batal();
        
        function cal_days_in_month(iMonth, iYear)
        {
            return(new Date(iYear, iMonth, 0).getDate());
        }

        function gantiUmur2(){
            var val = document.getElementById('TglLahir').value
            var tgl = val.split('-');
            var cek_jmlhr1 = cal_days_in_month(parseInt(tgl[1]),parseInt(tgl[2]));
            
            var dDate = new Date('<?php echo gmdate('Y,m,d',mktime(date('H')+7));?>');
            var Y = dDate.getFullYear();
            var M = dDate.getMonth()+1;
            var D = dDate.getDate();
            
            var cek_jmlhr2 = cal_days_in_month(M,Y);
            
            var sshari = cek_jmlhr1-parseInt(tgl[0]);
            var ssbln=12-parseInt(tgl[1])-1;
            var hari=0;
            var bulan=0;
            var tahun=0;

            if(sshari+D>=cek_jmlhr2){
                bulan=1;
                hari=sshari+D-cek_jmlhr2;
            }else{
                hari=sshari+D;
            }
            
            if(ssbln+M+bulan>=12){
                bulan=(ssbln+M+bulan)-12;
                tahun=Y-parseInt(tgl[2]);
            }else{
                bulan=(ssbln+M+bulan);
                tahun=(Y-parseInt(tgl[2]))-1;
            }

            var selisih=tahun+" Tahun "+bulan+" Bulan "+hari+" Hari";
            //alert(selisih);
            document.getElementById("th").value = tahun;
            document.getElementById("Bln").value = bulan;
            document.getElementById("hari").value = hari;
        }
        

        function gantiUmur(){
            var val=document.getElementById('TglLahir').value;
            var dDate = new Date('<?php echo gmdate('Y,m,d',mktime(date('H')+7));?>');

            var tgl = val.split("-");
            var tahun = tgl[2];
            var bulan = tgl[1];
            var tanggal = tgl[0];
            //alert(tahun+", "+bulan+", "+tanggal);
            var Y = dDate.getFullYear();
            var M = dDate.getMonth()+1;
            var D = dDate.getDate();
            //alert(Y+", "+M+", "+D);
            Y = Y - tahun;
            M = M - bulan;
            D = D - tanggal;
            //alert(tahun+", "+bulan+", "+tanggal);
            //M = pad(M+1,2,'0',1);
            //D = pad(D,2,'0',1);
            //alert(Y+", "+M+", "+D);
            //alert(M);
            //alert(D);
            
            //alert(bulan);
            var jD = '';
            
            if(bulan==1 || bulan==3 || bulan==5 || bulan==7 || bulan==8 || bulan==10 || bulan==12){
                jD = 31;
            }else if(bulan==2){
                if(tahun%4==0){
                    jD = 29;
                }else{
                    jD = 28;
                }
            }else{
                jD = 30;
            }
            //jD = 30;
            //alert(D);
            
            if(D < 0){
                M -= 1;
                //D = jD+D;
                D = jD+D;
            }
            
            if(M < 0){
                Y -= 1;
                M = 12+M;
            }
            document.getElementById("th").value = Y;
            document.getElementById("Bln").value = M;
            document.getElementById("hari").value = D;
            
            v_thn=Y;
            v_bln=M;
            v_hr=D;
            document.getElementById("th").focus();
            //$("txtHari").value = D;
        }
        
        var v_thn,v_bln,v_hr;
        function gantiTgl(e,zxc)
        {
            var key;
            if(window.event){
                key=window.event.keyCode;
            }
            else if(e.which){
                key=e.which;
            }
            //alert('asd');
            document.getElementById("th").value=(document.getElementById("th").value=='')?0:parseInt(document.getElementById("th").value);
            document.getElementById("Bln").value=(document.getElementById("Bln").value=='')?0:parseInt(document.getElementById("Bln").value);
            document.getElementById("hari").value=(document.getElementById("hari").value=='')?0:parseInt(document.getElementById("hari").value);
            //alert(zxc.id+' | '+v_thn+' '+v_bln+' '+v_hr);
            
            if(key==9) return false;
            
            
            
            if(zxc.id=='th' && zxc.value==v_thn) return false;
            if(zxc.id=='Bln' && zxc.value==v_bln) return false;
            if(zxc.id=='hari' && zxc.value==v_hr) return false;
            
            var dDate = new Date('<?php echo gmdate('Y,m,d',mktime(date('H')+7));?>');
            
            
            var thn=(document.getElementById("th").value=='')?0:parseInt(document.getElementById("th").value);
            var bln=(document.getElementById("Bln").value=='')?0:parseInt(document.getElementById("Bln").value);
            var hari=(document.getElementById("hari").value=='')?0:parseInt(document.getElementById("hari").value);
            
            //alert(hari);
            if(bln>11){
                var tmp = parseInt(bln/12);
                if(thn == ''){
                    thn = tmp;
                }
                else{
                    thn = thn+tmp;
                }
                document.getElementById('th').value = thn;
                tmp = bln%12;
                bln = tmp;
                document.getElementById('Bln').value = bln;
            }
            if(bln == ''){
                document.getElementById('Bln').value = 0;
            }
            
            if(hari == ''){
                document.getElementById('hari').value = 0;
            }

            var Y = dDate.getFullYear()-thn;
            var M = dDate.getMonth()-bln+1;
            var D = dDate.getDate()-hari;
            //alert(D+"-"+M+"-"+Y);
            
            
            var bulan = '';
            if((D-hari)>0){
                bulan = M;
            }
            else{
                bulan = M-1;    
            }
            
            var jD = '';
            if(bulan==1 || bulan==3 || bulan==5 || bulan==7 || bulan==8 || bulan==10 || bulan==12){
                jD = 31;
            }else if(bulan==2){
                if((thn%4==0) && (thn%100!=0)){
                    jD = 29;
                }else{
                    jD = 28;
                }
            }else{
                jD = 30;
            }
            
            if(D < 0){
                M -= 1;
                D = jD+D;
            }
            if(M < 0){
                Y -= 1;
                M = 12+M;
            }
            
            var nDate = new Date(M+"/"+D+"/"+Y);
            Y = nDate.getFullYear();
            M = nDate.getMonth()+1;
            D = nDate.getDate();
            
        
            if(hari>(jD-1)){
                var tmp = parseInt(hari/jD);
                if(bln == 0){
                    M = tmp;
                }
                else{
                    M = M+tmp;
                }
                document.getElementById('Bln').value = M;
                tmp = hari%jD;
                hari = tmp;
                //alert(hari);
                document.getElementById('hari').value = hari;
            }
            
            
            if(D<10){
                D="0"+D;    
            }
            
            v_thn=Y;
            v_bln=M;
            v_hr=D;
            
            if(M<10){
                M="0"+M;
            }
            
            nDate = D + "-" + M + "-" + Y;
            
            /*
            if (D<10){
                //alert('asd');
                document.getElementById("TglLahir").value = "0" + D + "-" + M + "-" + Y;
            }else{
                //alert('asd1');
                document.getElementById("TglLahir").value = nDate;
            }
            */
            document.getElementById("TglLahir").value = nDate;
        }
        


        function simpan(action)
        {
            getCabang(jQuery('#asal').val());
            var klmn = document.getElementById('Gender').value;
            var unit12 = document.getElementById('TmpLayanan').value;
            var sumur1 = <? echo $sumur;?>;
            var jTot = 0;
            //alert(sumur1);
            SetDisable(8);
            var prop = document.getElementById('cmbProp').value;
            var kab = document.getElementById('cmbKab').value;
            var kec = document.getElementById('cmbKec').value;
            var desa = document.getElementById('cmbDesa').value;
            
            //alert(nm_pas+"\n"+nip_pas+"\n"+jns_pas);
            
            if(nm_pas != "" || nip_pas != "" || jns_pas != "")
            {
            if((nm_pas != document.getElementById("Nama").value) || (nip_pas != document.getElementById("NoKTP").value) || (jns_pas != document.getElementById("Gender").value))
            {
                if(nm_pas != document.getElementById("Nama").value)
                {
                    jTot += 1;
                }
                
                if(nip_pas != document.getElementById("NoKTP").value)
                {
                    jTot += 1;
                }
                
                if(jns_pas != document.getElementById("Gender").value)
                {
                    jTot += 1;
                }
                
                //alert(jTot);
                
                if(jTot > 2)
                {
                    alert("identitas pasien tidak dapat diubah sepenuhnya!!! hubungi admin untuk perubahan data pasien keseluruhan.");
                    return false;
                }
                    
            }
            }
            
            
            //return false;
            
            var tmpLayanan1 = document.getElementById("TmpLayanan").value;
            var prev_tmpLayanan1 = document.getElementById("prev_TmpLayanan").value;
                        
                        
            /*if((tmpLayanan1==189 || prev_tmpLayanan1==189) && prev_tmpLayanan1 !=0){
                if(tmpLayanan1 != prev_tmpLayanan1 ){
                    alert('Untuk Merubah Data Pasien MCU Silahkan Melakukan Pendaftaran Ulang !!');
                    return false;
                }
            
            }*/
            
            
            if(document.getElementById("cmbKw").value == 1){

                if(prop=="" || kab=="" || kec=="" || desa=="")
                {
                    alert('Isi Kolom Propinsi,Kabupaten,Kecamatan,Kelurahan');
                    return false;
                }
            
            }
            
            if((document.getElementById("JnsLayanan").value == 68) && (document.getElementById("Gender").value.toLowerCase() == "l"))
            {
                    //alert("pasein tersebut tidak dapat dirawat di ruang bersalin");
                    //return false;
            }
            
            if((sumur1 <= document.getElementById('th').value || (document.getElementById('th').value == 0 && document.getElementById('Bln').value == 0 && document.getElementById('hari').value == 0)) && unit12 == 15)
            {
                alert("Pasien Tersebut Tidak Dapat Mengunjungi Tempat Layanan yang Anda Pilih, lakukan entriyan dengan benar");
                return false;
            }
            
            if( ((document.getElementById('th').value == 0 && document.getElementById('Bln').value == 0 && document.getElementById('hari').value == 0)) ){
            
            
                    alert('Lengkapi Tanggal Lahir');
                    return false;
            
            
            }
            
            /*if(klmn == "L" && (unit12 == 8 || unit12 == 9))
            {
                alert("Anda Salah Dalam Melakukan Entriyan Pasien Laki - Laki ke Tempat Layanan, Lakukan Entry Kembali dng Benar");
                return false;
            }*/
            
            if (document.getElementById('btnSimpan').value=="Tambah" || document.getElementById('btnSimpan').value=="Simpan"){
                //kalau edit jenis pelayanan dsj,harus dipastikan pasien belum mendapat pelayanan,jika sudah mendapat pelayanan,update tidak boleh dikerjakan
                if (document.getElementById('asal').value==""){
                    alert("Anda Tidak Memiliki Hak Akses Untuk Melakukan Registrasi Pendaftaran Pasien, Hubungi Tim IT Untuk Menambah Hak Akses Tersebut !");
                    return false;
                }
                else{
                
                    if (document.getElementById("cmbKw").value=="1"){
                        var almt=",cmbKab,cmbProp,cmbKec,cmbDesa";
                        }else{
                        var almt="";
                        }
                        
                    if(ValidateForm('NoRm,Nama,TglLahir,th,Bln,hari,TglKunj,AslMasuk,StatusPas,JnsLayanan,TmpLayanan,cmbKelas'+almt,'ind'))
                    {
                        if (document.getElementById("HakKelas").value=="1" && document.getElementById("StatusPas").value!="1" && document.getElementById("StatusPas").value!="2"){
                            alert("Pilih Hak Kelas Pasien Penjamin !");
                            document.getElementById("HakKelas").focus();
                            return false;
                        }
                        //alert(glob_tmpLay + ' - ' +document.getElementById("TmpLayanan").value);
                        if (glob_tmpLay==document.getElementById("TmpLayanan").value && document.getElementById('btnSimpan').value=="Tambah" && document.getElementById("JnsLayanan").value!='44' && jQuery("#id_antrian_jkn").val() == ""){
                            alert("Pasien Sudah Terdaftar di Tempat Layanan Ini !");
                            document.getElementById("TmpLayanan").focus();
                            return false;
                        }
                        
                        //01-08-2016
                        if(document.getElementById("AslMasuk").value == 11 || document.getElementById("AslMasuk").value == 13){
                            if(document.getElementById("dataMasuk").value == 0){
                                alert("Tempat Asal Puskesmas/RS tidak boleh kosong");
                                document.getElementById("dataMasuk").focus();
                                document.getElementById('btnSimpan').disabled=false;
                                return false;
                            }
                        }
                        
                        if (document.getElementById('btnSimpan').value=="Simpan"){
                            if (glob_dilayani!="0"){
                                alert("Pasien Sudah Dilayani, Jadi Tidak Boleh Diubah !");
                                return false;
                            }else{
                                if (confirm("Yakin Ingin Mengubah Data Kunjungan ?")){
                                }else{
                                    batal();
                                    return false;
                                }
                            }
                        }else if (document.getElementById("IsNewPas").value==""){
                            alert("Untuk Pasien Baru, Klik Tombol No. RM Baru !");
                            return false;
                        }
                        
                        document.getElementById("btnSimpan").disabled=true;
                        var idPasien = document.getElementById("txtIdPasien").value;
                        var idKunj = document.getElementById("txtIdKunj").value;
                        var noRm = document.getElementById("NoRm").value;
                        var noKTP = document.getElementById('NoKTP').value;
                        var noBil = document.getElementById("NoBiling").value;
                        var nama = document.getElementById("Nama").value;
                        var namaOrtu = document.getElementById("NmOrtu").value;
                        var namaSuTri = document.getElementById("NmSuTri").value;
                        var gender = document.getElementById("Gender").value;
                        var agama = document.getElementById("cmbAgama").value;
                        var pend = document.getElementById("Pendidikan").value;
                        var pek = document.getElementById("Pekerjaan").value;
                        var tglLhr = document.getElementById("TglLahir").value;
                        var thn = document.getElementById("th").value;
                        var bln = document.getElementById("Bln").value;
                        var hari = document.getElementById("hari").value;
                        var tglKun = document.getElementById("TglKunj").value;
                        var alamat = document.getElementById("Alamat").value;
                        var telp = document.getElementById("telp").value;
                        var rt = document.getElementById("rt").value;
                        var rw = document.getElementById("rw").value;
                        var asalMsk = document.getElementById("AslMasuk").value;
                        var prop = document.getElementById("cmbProp").value;
                        var ket = document.getElementById("Ket").value;
                        var kab = document.getElementById("cmbKab").value;
                        var statusPas = document.getElementById("StatusPas").value;
                        var kec = document.getElementById("cmbKec").value;
                        var tglSJP = document.getElementById("TglSJP").value;
                        var desa = document.getElementById("cmbDesa").value;
                        var noSJP = document.getElementById("NoSJP").value; //asx
                        var jnsLayanan = document.getElementById("JnsLayanan").value;
                        var tmpLayanan = document.getElementById("TmpLayanan").value;
                        var kelas = document.getElementById("cmbKelas").value;
                        var asal = document.getElementById('asal').value;
                        var noreg1 = document.getElementById('noReg1').value;
                        var darah = document.getElementById('darah').value;
                        var kw = document.getElementById('cmbKw').value;
                        var flag = document.getElementById('flag').value;
    
                        var dokter = document.getElementById('cmbDokter').value;
                        var dokterPengganti = 0;
                        if(document.getElementById('chkDokterPengganti').checked){
                            dokterPengganti = 1;
                        }
                        
                        var inap = document.getElementById('TmpLayanan').options[document.getElementById('TmpLayanan').options.selectedIndex].lang;
                        var prev_inap = document.getElementById('prev_inap').value;
                        var kamar = document.getElementById('kamar').value;
    
                        var retribusi = document.getElementById("Retribusi").value;
                        var prev_retribusi = document.getElementById('prev_retribusi').value;
                        if(inap == 1){
                            retribusi = '';
                            if (kamar=="0" || kamar==""){
                                alert("Pilih Kamar Terlebih Dahulu !");
                                return false;
                            }
                        }
                        else{
                            kamar = '';
                        }
                        var tarip=document.getElementById("spanTarif").innerHTML;
                        var penjamin = document.getElementById("Penjamin").value;
                        var noAnggota = document.getElementById("NoAnggota").value;
                        var hakKelas = document.getElementById("HakKelas").value;
                        var statusPenj = document.getElementById("StatusPenj").value;
                        //alert(asal);
                        var kodeppk = (temporary_sjp[5]==undefined)?"":temporary_sjp[5];
                        var namaPKSO = (temporary_sjp[2]==undefined)?"":temporary_sjp[2];
                        var diagAwal = (ms_kd_diag==undefined)?"":document.getElementById("diagnosa_id_sjp").value;
                        var puskesmas = (asalMsk == 11) ? document.getElementById('dataMasuk').value : 0;
                        let kelompokMcu = jQuery('#KelompokTindakanMcu').val();

                        var url = "registrasi_utils.php?grd=true&saring=true&saringan="+tglKun+"&act="+action+"&idPasien="+idPasien+"&idKunj="+idKunj+"&noRm="+noRm+"&nama="+nama+"&noBil="+noBil+"&namaOrtu="+namaOrtu+"&namaSuTri="+namaSuTri+"&gender="+gender+"&agama="+agama+"&pend="+pend+"&pek="+pek+"&tglLhr="+tglLhr+"&thn="+thn+"&bln="+bln+"&hari="+hari+"&tglKun="+tglKun+"&alamat="+alamat+"&rt="+rt+"&kamar="+kamar+"&rw="+rw+"&asalMsk="+asalMsk+"&prop="+prop+"&ket="+ket+"&kab="+kab+"&statusPas="+statusPas+"&userLog="+document.getElementById('userLog').value+"&asal="+asal+"&prev_stat="+prev_stat+"&kec="+kec+"&tglSJP="+tglSJP+"&desa="+desa+"&noSJP="+noSJP+"&jnsLayanan="+jnsLayanan+"&inap="+inap+"&prev_inap="+prev_inap+"&tmpLayanan="+tmpLayanan+"&kelas="+kelas+"&retribusi="+retribusi+"&prev_retribusi="+prev_retribusi+"&tarip="+tarip+"&penjamin="+penjamin+"&noAnggota="+noAnggota+"&hakKelas="+hakKelas+"&statusPenj="+statusPenj+"&telp="+telp+"&userId=<?php echo $userId; ?>&diagAwal="+diagAwal+"&kodeppk="+kodeppk+"&namaPKSO="+namaPKSO+"&noKTP="+noKTP+"&dokter_id="+dokter+"&dokterPengganti="+dokterPengganti+"&noreg1="+noreg1+"&darah="+darah+"&pusk="+puskesmas+"&kw="+kw+"&flag="+flag+"&cabang="+cabang;

                        if(document.getElementById('unit_dari_jkn').value != undefined && document.getElementById('unit_dari_jkn').value != null && document.getElementById('unit_dari_jkn').value != ""){
                            url += "&darijkn=" + document.getElementById('unit_dari_jkn').value;
                        }
                        if(document.getElementById('id_antrian_jkn').value != undefined && document.getElementById('id_antrian_jkn').value != null && document.getElementById('id_antrian_jkn').value != ""){
                            url += "&idantrianjkn=" + document.getElementById('id_antrian_jkn').value;
                        }

                        if(tmpLayanan == 189){
                            url += "&kelompokMcu="+kelompokMcu;
                        }

                        if(document.getElementById('id_pasien_klinik').value != '' || document.getElementById('id_pasien_klinik').value != undefined){
                            url += "&id_pasien_klinik="+jQuery('#id_pasien_klinik').val();
                            url += "&id_kunjungan_klinik="+jQuery('#id_kunjungan_klinik').val();
                            url += "&id_pelayanan_klinik="+jQuery('#id_pelayanan_klinik').val();

                        }
                        
                        a.loadURL(url,"","GET");
                        //alert(url);
                    }
                }
            }else{
                SetDisable(0);
                document.getElementById('btnSimpan').value="Simpan";
                document.getElementById('divKunjLagi').style.display="none";
                setPenjamin(document.getElementById('StatusPas').value);
            }
            jQuery('#id_pasien_klinik').val("");
            jQuery('#id_pelayanan_klinik').val("");
            jQuery('#id_kunjungan_klinik').val("");
        }

        function ambilData(multi)
        {
            resetInputJkn(true);

            var regex = /(<([^>]+)>)/ig;
            var disableHapus="<?php echo $disableHapus; ?>";
            if(multi != null && multi != '' && multi == 1){
                var defSim = "btnSimpan*-*Tambah";
            }
            else{
                var defSim = "btnSimpan*-*Simpan";
            }
            var sisipan=a.getRowId(a.getSelRow()).split("|"); //alert(sisipan)
            //alert(sisipan[45]);
            var p="txtIdPasien*-*"+sisipan[1]+"*|*txtIdKunj*-*"+sisipan[0]+"*|*NoRm*-*"+sisipan[2]+"*|*NoBiling*-*"+sisipan[3]
                +"*|*Nama*-*"+a.cellsGetValue(a.getSelRow(),3).replace(regex, "")+"*|*NmOrtu*-*"+sisipan[12]+"*|*NmSuTri*-*"+sisipan[13]+"*|*Gender*-*"+sisipan[14]
                +"*|*cmbAgama*-*"+sisipan[17]+"*|*Pendidikan*-*"+sisipan[15]+"*|*Pekerjaan*-*"+sisipan[16]+"*|*TglLahir*-*"+sisipan[4]
                +"*|*th*-*"+sisipan[20]+"*|*Bln*-*"+sisipan[21]+"*|*hari*-*"+sisipan[40]+"*|*TglKunj*-*"+sisipan[19]+"*|*Alamat*-*"+sisipan[5]+"*|*telp*-*"+sisipan[18]
                +"*|*rt*-*"+sisipan[6]+"*|*rw*-*"+sisipan[7]+"*|*AslMasuk*-*"+sisipan[29]+"*|*cmbProp*-*"+sisipan[11]+"*|*Ket*-*"+sisipan[30]
                +"*|*cmbKab*-*"+sisipan[10]+"*|*StatusPas*-*"+sisipan[25]+"*|*cmbKec*-*"+sisipan[9]+"*|*TglSJP*-*"+sisipan[26]
                +"*|*cmbDesa*-*"+sisipan[8]+"*|*NoSJP*-*"+sisipan[27]
                +"*|*Penjamin*-*"+sisipan[25]+"*|*txtPenjamin*-*"+((sisipan[25]=='1')?'':sisipan[31])+"*|*NoAnggota*-*"+sisipan[28]
                +"*|*prev_inap*-*"+sisipan[34]+"*|*StatusPenj*-**|*"+defSim+"*|*btnHapus*-*"+disableHapus+"*|*HakKelas*-*"+sisipan[33]+"*|*NoKTP*-*"+sisipan[37]+"*|*prop*-*"+sisipan[44]+"*|*darah*-*"+sisipan[46]+"*|*noReg1*-*"+sisipan[45]+"*|*kabx*-*"+sisipan[43]+"*|*kecx*-*"+sisipan[42]+"*|*desx*-*"+sisipan[41]+"*|*cmbKw*-*"+sisipan[49]+"*|*spanTarif*-*"+sisipan[50];
            //saat ambil data set aslMasuk,jika aslMasuk == 3/datang sendiri jnsLayanan tidak memunculkan rawat inap,actionnya perlu delay,masih bingung
            //alert(p);
            fSetValue(window,p);
         ///   alert('glob_jnsLay = sisipan[22] -> '+sisipan[22]+'<br>glob_tmpLay = sisipan[23] -> '+sisipan[23]+'<br>glob_kelas = sisipan[24] -> '+sisipan[24]+'<br>glob_ret = sisipan[32] -> '+sisipan[32]+'<br>pusk = sisipan[47] -> '+sisipan[47]+'<br>rs = sisipan[48] -> '+sisipan[48]);

            cIdPas=sisipan[1];
            cIdKunj=sisipan[0];
            cUnit=sisipan[23];
            glob_jnsLay = sisipan[22];
            glob_tmpLay = sisipan[23];
            cUnit = sisipan[23];
            glob_kelas = sisipan[24];
            glob_ret = sisipan[32];
            prev_stat = sisipan[25];
            glob_asal = sisipan[29];
            glob_dilayani = sisipan[36];
            glob_dokter = sisipan[38];
            glob_type_dokter = sisipan[39];
            filterInap(sisipan[29],1);
            //glob_kamar = sisipan;
            isiCombo('cmbKec',sisipan[10],sisipan[9]);
            isiCombo('cmbDesa',sisipan[9],sisipan[8]);
            document.getElementById('prev_retribusi').value = sisipan[32];
            document.getElementById('prev_TmpLayanan').value = sisipan[23];
            jQuery("#loadG").load("gambar1.php?id_pasien="+cIdPas);
            //isiCombo('cmbKelas','',sisipan[33],'HakKelas');
            /*document.getElementById('kartu').disabled = false;
            if (sisipan[34]=='0'){
                document.getElementById('cetak').disabled = false;
                document.getElementById('spInap').disabled = true;
            }else{
                document.getElementById('cetak').disabled = true;
                document.getElementById('spInap').disabled = false;
            }
            document.getElementById('cetakForm').disabled = false;*/
            if(document.getElementById('asal').value=='108'){
                document.getElementById('skpJamkesda').disabled = false;
                document.getElementById('UpdStatusPx').disabled = false;
                Request("registrasi_utils.php?act=jamkeskah&idKunj="+cIdKunj,'skpDiv','','GET',skpCek);
            }
            //alert(prev_inap);
            if(document.getElementById('prev_inap').value=='1'){
                document.getElementById('spInap').disabled = false;
            }else{
                document.getElementById('spInap').disabled = true;
            }
            
            setPenjamin(sisipan[25]);
            
            /*ditampilkan tombol SKP JAMKESDA INAP jika penjamin adalah JAMKESMAS*/
            if(sisipan[25]=='38' || sisipan[25]=='39' || sisipan[25]=='46' || sisipan[25]=='64'){
                document.getElementById('skpJamkesdaKmr').disabled = false;
                document.getElementById('skpJamkesda').disabled = false;
            }else{
                document.getElementById('skpJamkesdaKmr').disabled = true;
                document.getElementById('skpJamkesda').disabled = true;
            }
            if(sisipan[25]=='53'){
                document.getElementById('sjpJampersal').disabled = false;
            }else{
                document.getElementById('sjpJampersal').disabled = true;
            }
            
            //01-08-2016
            if(sisipan[29] == 11 || sisipan[29] == 13){
            //alert(sisipan[46]);
                document.getElementById('dataMasuk').style.display = "block";
                if(sisipan[29] == 11) {
                    isiCombo('cmbPusk','',sisipan[47],'dataMasuk');
                } else {
                    isiCombo('cmbRSasal','',sisipan[48],'dataMasuk');
                }   
            } else {
                document.getElementById('dataMasuk').style.display = "none";
            }
            
            SetDisable(1);

            nm_pas = a.cellsGetValue(a.getSelRow(),3);
            nip_pas = sisipan[37];
            jns_pas = sisipan[14];
        }

        function hapus()
        {
            var idPasien = document.getElementById("txtIdPasien").value;
            var idKunj = document.getElementById("txtIdKunj").value;
            //alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
            if (glob_dilayani!="0"){
                alert("Pasien Sudah Dilayani, Jadi Tidak Boleh Dihapus !");
                return false;
            }else{
                if(confirm("Anda Yakin Ingin Menghapus Data kunjungan "+a.cellsGetValue(a.getSelRow(),3)))
                {
                    //alert("registrasi_utils.php?grd=true&act=hapus&idPasien="+idPasien+"&idKunj="+idKunj+"&userLog="+document.getElementById('userLog').value+"&asal="+document.getElementById('asal').value+"&saring=true&saringan="+document.getElementById('TglKunj').value+"&userId=<?php echo $userId; ?>");
                    a.loadURL("registrasi_utils.php?grd=true&act=hapus&idPasien="+idPasien+"&idKunj="+idKunj+"&userLog="+document.getElementById('userLog').value+"&asal="+document.getElementById('asal').value+"&saring=true&saringan="+document.getElementById('TglKunj').value+"&userId=<?php echo $userId; ?>&cabang="+cabang,"","GET");
                }
            }
        }
        
        function batal(exc)
        {
            document.getElementById("divKunjLagi").style.display="none";
            document.getElementById('spInap').disabled=true;
            document.getElementById("btnSimpan").disabled=false;
            document.getElementById("IsNewPas").value="";
            nm_pas=nip_pa=jns_pas= "";
            
            jQuery('#div_pasien').css('display','none');
            jQuery('#div_pasien').html('');
            
            if(exc == '1'){
                var tgl = document.getElementById('TglKunj').value;
            }
            var p="txtIdPasien*-**|*txtIdKunj*-**|*NoRm*-**|*NoKTP*-**|*NoBiling*-**|*Nama*-**|*noReg1*-**|*NmOrtu*-**|*NmSuTri*-**|*Gender*-**|*cmbAgama*-*1*|*cmbKw*-*1*|*Pendidikan*-**|*Pekerjaan*-**|*StatusPas*-*1*|*TglLahir*-*<?php echo $date_now;?>*|*th*-*0*|*Bln*-*0*|*hari*-*0*|*TglKunj*-*<?php echo $date_now;?>*|*TglSJP*-*<?php echo $date_now;?>*|*Alamat*-**|*telp*-**|*rt*-**|*rw*-**|*AslMasuk*-*3*|*cmbProp*-**|*Ket*-**|*cmbKab*-**|*StatusPas*-**|*cmbKec*-**|*cmbDesa*-**|*NoSJP*-**|*JnsLayanan*-**|*TmpLayanan*-**|*cmbKelas*-**|*Retribusi*-**|*Penjamin*-**|*txtPenjamin*-**|*NoAnggota*-**|*HakKelas*-**|*StatusPenj*-**|*btnSimpan*-*Tambah*|*btnHapus*-*true";
          p += "*|*skpJamkesda*-*true*|*skpJamkesdaKmr*-*true*|*UpdStatusPx*-*true*|*prop*-**|*kabx*-**|*kecx*-**|*desx*-**|*prev_TmpLayanan*-*";
            fSetValue(window,p);
            if(exc == '1'){
                document.getElementById('TglKunj').value = tgl;
            }
            //document.getElementById('spInap').disabled = true;
            filterInap(3,1);
            //getNoRM();
            setPenjamin(1);
            keyword = '';
            glob_jnsLay = glob_tmpLay = glob_kelas = glob_ret = prev_stat = glob_asal = '';
            nm_pas = nip_pas = jns_pas = "";
            SetDisable(0);
            SetDisable(3);
            document.getElementById("NoRm").focus();
            //sjp
            temporary_sjp = ms_kd_diag = '';
            document.getElementById('NoKa').value = '';
            document.getElementById('NIP').value = '';
            document.getElementById('diag_sjp').value = '';
            document.getElementById('diagnosa_id_sjp').value = '';
            document.getElementById('TglSJP_sjp').value = '<?php echo $date_now;?>';

            // JKN
            resetInputJkn();            
            
            document.getElementById('span_NoRm_sjp').innerHTML = '';
            document.getElementById('span_StatusPenj_sjp').innerHTML = '';
            document.getElementById('span_birth_sjp').innerHTML = '';
            document.getElementById('span_gender_sjp').innerHTML = '';
            document.getElementById('span_namaP_sjp').innerHTML = '';
            document.getElementById('div_room_sjp').innerHTML = '';
            document.getElementById('spanTarifKamar_sjp').innerHTML = '';
            document.getElementById('spanTarif_sjp').innerHTML = '';
            
            document.getElementById('NoKTP').disabled=false;
            document.getElementById('NmOrtu').disabled=false;
            document.getElementById('Nama').disabled=false;
            document.getElementById('NmSuTri').disabled=false;
            document.getElementById('Gender').disabled=false;
            document.getElementById('Pendidikan').disabled=false;
            document.getElementById('Pekerjaan').disabled=false;
            //document.getElementById('TglLahir').disabled=false;
            document.getElementById('th').disabled=false;
            document.getElementById('Bln').disabled=false;
            document.getElementById('hari').disabled=false;
            document.getElementById('cmbAgama').disabled=false;
            document.getElementById('telp').disabled=false;
            document.getElementById('Alamat').disabled=false;
            document.getElementById('rt').disabled=false;
            document.getElementById('rw').disabled=false;
            document.getElementById('prop').disabled=false;
            document.getElementById('kabx').disabled=false;
            document.getElementById('kecx').disabled=false;
            document.getElementById('desx').disabled=false;
            document.getElementById('prop').style.background = "#B1D8FC";
            document.getElementById('kabx').style.background = "#B1D8FC";
            document.getElementById('kecx').style.background = "#B1D8FC";
            document.getElementById('desx').style.background = "#B1D8FC";
            
            if(glob_type_dokter=='0'){
                isiCombo('cmbDokReg',document.getElementById('TmpLayanan').value+','+document.getElementById('TglKunj').value,glob_dokter,'cmbDokter');
                document.getElementById('chkDokterPengganti').checked = false;
            }
            else{
                isiCombo('cmbDokRegPengganti',document.getElementById('TmpLayanan').value,glob_dokter,'cmbDokter');
                document.getElementById('chkDokterPengganti').checked = true;
            }
            //document.getElementById('TglLahir').disabled=true;
            setAwalLokasi();
            jQuery("#loadG").html("");
            document.getElementById("siakadStat").value = 0;
        }

        /*function batal(exc)
        {
            document.getElementById("divKunjLagi").style.display="none";
            document.getElementById('spInap').disabled=true;
            document.getElementById("btnSimpan").disabled=false;
            document.getElementById("IsNewPas").value="";
            if(exc == '1'){
                var tgl = document.getElementById('TglKunj').value;
            }
            var p="txtIdPasien*-**|*txtIdKunj*-**|*NoRm*-**|*NoKTP*-**|*NoBiling*-**|*Nama*-**|*noReg1*-**|*NmOrtu*-**|*NmSuTri*-**|*Gender*-**|*cmbAgama*-**|*Pendidikan*-**|*Pekerjaan*-**|*StatusPas*-*1*|*TglLahir*-*<?php echo $date_now;?>*|*th*-*0*|*Bln*-*0*|*hari*-*0*|*TglKunj*-*<?php echo $date_now;?>*|*TglSJP*-*<?php echo $date_now;?>*|*Alamat*-**|*telp*-**|*rt*-**|*rw*-**|*AslMasuk*-*3*|*cmbProp*-**|*Ket*-**|*cmbKab*-**|*StatusPas*-**|*cmbKec*-**|*cmbDesa*-**|*NoSJP*-**|*JnsLayanan*-**|*TmpLayanan*-**|*cmbKelas*-**|*Retribusi*-**|*Penjamin*-**|*txtPenjamin*-**|*NoAnggota*-**|*HakKelas*-**|*StatusPenj*-**|*btnSimpan*-*Tambah*|*btnHapus*-*true";
          p += "*|*skpJamkesda*-*true*|*skpJamkesdaKmr*-*true*|*UpdStatusPx*-*true*|*prop*-**|*kabx*-**|*kecx*-**|*desx*-*";
            fSetValue(window,p);
            if(exc == '1'){
                document.getElementById('TglKunj').value = tgl;
            }
            //document.getElementById('spInap').disabled = true;
            filterInap(3,1);
            //getNoRM();
            setPenjamin(1);
            keyword = '';
            glob_jnsLay = glob_tmpLay = glob_kelas = glob_ret = prev_stat = glob_asal = '';
            SetDisable(0);
            SetDisable(3);
            document.getElementById("NoRm").focus();
            //sjp
            temporary_sjp = ms_kd_diag = '';
            document.getElementById('NoKa').value = '';
            document.getElementById('NIP').value = '';
            document.getElementById('diag_sjp').value = '';
            document.getElementById('diagnosa_id_sjp').value = '';
            document.getElementById('TglSJP_sjp').value = '<?php echo $date_now;?>';
            
            document.getElementById('span_NoRm_sjp').innerHTML = '';
            document.getElementById('span_StatusPenj_sjp').innerHTML = '';
            document.getElementById('span_birth_sjp').innerHTML = '';
            document.getElementById('span_gender_sjp').innerHTML = '';
            document.getElementById('span_namaP_sjp').innerHTML = '';
            document.getElementById('div_room_sjp').innerHTML = '';
            document.getElementById('spanTarifKamar_sjp').innerHTML = '';
            document.getElementById('spanTarif_sjp').innerHTML = '';
            
            document.getElementById('NoKTP').disabled=false;
            document.getElementById('NmOrtu').disabled=false;
            document.getElementById('Nama').disabled=false;
            document.getElementById('NmSuTri').disabled=false;
            document.getElementById('Gender').disabled=false;
            document.getElementById('Pendidikan').disabled=false;
            document.getElementById('Pekerjaan').disabled=false;
            //document.getElementById('TglLahir').disabled=false;
            document.getElementById('th').disabled=false;
            document.getElementById('Bln').disabled=false;
            document.getElementById('hari').disabled=false;
            document.getElementById('cmbAgama').disabled=false;
            document.getElementById('telp').disabled=false;
            document.getElementById('Alamat').disabled=false;
            document.getElementById('rt').disabled=false;
            document.getElementById('rw').disabled=false;
            document.getElementById('prop').disabled=false;
            document.getElementById('kabx').disabled=false;
            document.getElementById('kecx').disabled=false;
            document.getElementById('desx').disabled=false;
            
            if(glob_type_dokter=='0'){
                isiCombo('cmbDokReg',document.getElementById('TmpLayanan').value,glob_dokter,'cmbDokter');
                document.getElementById('chkDokterPengganti').checked = false;
            }
            else{
                isiCombo('cmbDokRegPengganti',document.getElementById('TmpLayanan').value,glob_dokter,'cmbDokter');
                document.getElementById('chkDokterPengganti').checked = true;
            }
            document.getElementById('TglLahir').disabled=true;
            setAwalLokasi();
            jQuery("#loadG").html("");
        }*/

        function getNoBil(){
            //function to get billing number
            /*var jnsLayanan = document.getElementById("JnsLayanan").value;
            var tglKun = document.getElementById("TglKunj").value;
            var noRM = document.getElementById('NoRm').value;
            &jnsLayanan='+jnsLayanan+'&tglKun='+tglKun+'&noRm='+noRM
             */
            Request('registrasi_utils.php?act=getNoBilling','txtNoBiling','','GET',setNoBil,'ok');
        }

        function setNoBil(){
            document.getElementById('NoBiling').value = document.getElementById('txtNoBiling').value;
        }

        function setPenjamin(val){
            var label='';
            if(val==1 || val==""){
                // && document.getElementById('StatusPas').options[document.getElementById('StatusPas').selectedIndex].value==1
                var p="NoAnggota,HakKelas,StatusPenj,txtPenjamin";
                fDisable(p,'ok-1');
                fSetValue(window,"ok*-*false*|*NoAnggota*-*");
                document.getElementById('HakKelas').options.selectedIndex=0;
            }
            else{
                label=document.getElementById('StatusPas').options[document.getElementById('StatusPas').selectedIndex].label;
                var p="ok,NoAnggota,HakKelas,StatusPenj,txtPenjamin";
                if (document.getElementById('StatusPas').value=="38" || document.getElementById('StatusPas').value=="39" || document.getElementById('StatusPas').value=="46" || document.getElementById('StatusPas').value=="53" || document.getElementById('StatusPas').value=="64"){
                    document.getElementById('HakKelas').options.selectedIndex=3;
                    fDisable(p,'ok-1');
                    fSetValue(window,"ok*-*true");
                }else if (document.getElementById('StatusPas').value=="2"){
                    document.getElementById('HakKelas').value=1;
                    document.getElementById('StatusPenj').options.selectedIndex=3;
                    fEnable(p,'ok-0');
                    fDisable("ok",'ok-0');
                    fSetValue(window,"ok*-*true");
                }else{
                    fEnable(p,'ok-0');
                    fDisable("ok",'ok-0');
                    fSetValue(window,"ok*-*true");
                    document.getElementById('HakKelas').value=1;
                    document.getElementById('StatusPenj').options.selectedIndex=3;
                    //document.getElementById('HakKelas').options.selectedIndex=2;
                }
            }

            fSetValue(window,"txtPenjamin*-*"+label+"*|*Penjamin*-*"+val);
            
            if (document.getElementById('StatusPas').value == <?php echo $idKsoBPJS; ?>){
                document.getElementById('getSJP').disabled=false;
                document.getElementById('sjpAskes').disabled=false;
                document.getElementById('sjpAskes_isi').disabled=false;
            }else{
                document.getElementById('getSJP').disabled=true;
                document.getElementById('sjpAskes').disabled=true;
                document.getElementById('sjpAskes_isi').disabled=true;
            }
        }
        
        function decUser(){
        //  alert(document.getElementById('asal').value+'xx');
            getCabang(jQuery('#asal').val());
            isiCombo('userLog',document.getElementById('asal').value,'<?php echo $userId; ?>','userLog',saring);
            //======Isi Jenis layanan== sesuai loket=======
            isiCombo('JnsLayananRegByLoket',document.getElementById('asal').value,'','JnsLayanan',isiTmpLay);
            isiCombo('JnsLayananRegByLoket',document.getElementById('asal').value,57,'jenislayananpcr',isiTmpLay);
            //isiCombo('TmpLayanan',document.getElementById('TmpLayanan').value,'','TmpLayanan',isiTmpLay);//ml
            isiCombo('JnsLayanan_sjp','','1','JnsLayanan_sjp',isiTmpLay_sjp);
            //isiCombo('userLog',document.getElementById('asal').value,'<?php echo $userId; ?>','userLog',saring);
            //isiTmpLay('setThrough');
            if(document.getElementById('asal').value=='108'){
                isiCombo('StatusPasJamkesmas','','','StatusPas');
            }else if(document.getElementById('asal').value=='110'){
                isiCombo('StatusPasAskes','','','StatusPas');
            }           
            else{
                isiCombo('StatusPas','',1,'StatusPas',function(){
                    setPenjamin(document.getElementById('StatusPas').value);
                });
            }
        }

    function getCabang(loket){
        // alert(loket);
        jQuery.ajax({
            url     : 'cabang_utils.php',
            data    : { loket: loket },
            type    : "POST",
            dataType: "json",
            success : 
                function(x){
                    // alert(x.cabang);
                    cabang = x.cabang;
                    if(cabang == 1){
                        document.getElementById('NoSJP').style.background = "#B1D8FC";
                    } else {
                        document.getElementById('NoSJP').style.background = "#D5FED9";
                    }
                }
        });
    }
        
    function get_sjp(){
        if(document.getElementById('Nama').value == '' || document.getElementById('NoRm').value == ''){
            alert('Nama pasien dan Nomor Rekam Medis harus diisi.');
            return;
        }
        if(document.getElementById('StatusPas').value != <?php echo $idKsoBPJS; ?>){
            alert('Penjamin pasien bukan askes sosial.');
            return;
        }
        document.getElementById('listPas_sjp').style.display='none';
        document.getElementById('listPas_sjp').innerHTML='';
        document.getElementById('NoKa').value = document.getElementById('NoAnggota').value;
        //document.getElementById('NIP').value = "";
        document.getElementById('span_NoRm_sjp').innerHTML = document.getElementById('NoRm').value;
        //document.getElementById('span_namaP_sjp').innerHTML = document.getElementById('Nama').value;
        //document.getElementById('span_gender_sjp').innerHTML = document.getElementById('Gender').options[document.getElementById('Gender').options.selectedIndex].innerHTML;
        //document.getElementById('span_birth_sjp').innerHTML = document.getElementById('TglLahir').value;
        fKeyEnt_sjp = true;
        new Popup('div_getSJP',null,{modal:true,position:'center',duration:1});
        document.getElementById('div_getSJP').popup.show();
        document.getElementById('NoKa').focus();
    }
    
    function suggest_sjp_byNoKa(e,par){
       /*  if(e.which == 13){
            document.getElementById('NoKa').disabled = true;
            document.getElementById('NIP').disabled = true;
            document.getElementById('close_btn').disabled = true;
            document.getElementById('load_gif').style.display = '';
            document.getElementById('conf_sjp').disabled = true;
            //var url = 'get_sjp.php?act=getListPesertaBy'+par.id+'&noKa='+document.getElementById('NoKa').value+'&nip='+document.getElementById('NIP').value;
            var url = 'get_sjpRelay.php?act=getListPesertaBy'+par.id+'&noKa='+document.getElementById('NoKa').value+'&nip='+document.getElementById('NIP').value;
            //alert(url);
            Request_sjp(url , 'listPas_sjp', '', 'GET', set_sjp );
        } */
        if(e.which == 13){
            document.getElementById('NoKa').disabled = true;
            document.getElementById('NIP').disabled = true;
            document.getElementById('close_btn').disabled = true;
            document.getElementById('load_gif').style.display = '';
            document.getElementById('conf_sjp').disabled = true;
            var tglSJP = document.getElementById('TglSJP_sjp').value.split('-');
            tglSJP = tglSJP[2]+'-'+tglSJP[1]+'-'+tglSJP[0];
            
            var url = 'get_sjp.php?act=getListPesertaBy'+par.id+'&tglSJP='+tglSJP+'&noKa='+document.getElementById('NoKa').value+'&nip='+document.getElementById('NIP').value;
            //var url = 'get_sjpRelay.php?act=getListPesertaBy'+par.id+'&tglSJP='+tglSJP+'&noKa='+document.getElementById('NoKa').value+'&nip='+document.getElementById('NIP').value;
            //alert(url);
            Request_sjp(url , 'listPas_sjp', '', 'GET', set_sjp );
        }
    }
    
    var nip_bef = '';
    
    function suggest_sjp(e,par){
            //alert('get_sjp.php?act='+par.id+'&noKa='+document.getElementById('NoKa').value+'&nip='+document.getElementById('NIP').value)
        var keywords=par.value;//alert(keywords);
        if(keywords==""){
            document.getElementById('listPas_sjp').style.display='none';
        }else{
            var key;
            if(window.event) {
                key = window.event.keyCode;
            }
            else if(e.which) {
                key = e.which;
            }
            //alert(key+" - "+fKeyEnt_sjp);
            if (key==38 || key==40){
                var tblRow=document.getElementById('tblPas').rows.length;
                if (tblRow>0){
                    //alert(RowIdx_sjp);
                    if (key==38 && RowIdx_sjp>0){
                        RowIdx_sjp=RowIdx_sjp-1;
                        document.getElementById('lstPas'+(RowIdx_sjp)).className='itemtableReq';
                        if (RowIdx_sjp>0) document.getElementById('lstPas'+(RowIdx_sjp-1)).className='itemtableMOverReq';
                    }else if (key == 40 && RowIdx_sjp < (tblRow-1)){
                        if (RowIdx_sjp>0) document.getElementById('lstPas'+(RowIdx_sjp-1)).className='itemtableReq';
                        document.getElementById('lstPas'+RowIdx_sjp).className='itemtableMOverReq';
                        RowIdx_sjp=RowIdx_sjp+1;
                    }
                }
            }
            else if (key==13 && fKeyEnt_sjp==false){
                if (RowIdx_sjp>0){
                //if (fKeyEnt_sjp==false){
                    fKeyEnt_sjp = true;
                    fSetPas(document.getElementById('lstPas'+(RowIdx_sjp-1)));
                /*}else{
                    fKeyEnt_sjp=false;
                }*/
                }
            }
            else if (key!=27 && key!=37 && key!=39){
                RowIdx_sjp=0;
                if(key == 13){
                     fKeyEnt_sjp=false;
                     //alert("msk");
                     //var url = 'get_sjp.php?act=getListPesertaBy'+par.id+'&noKa='+document.getElementById('NoKa').value+'&nip='+document.getElementById('NIP').value;
                     /* var url = 'get_sjpRelay.php?act=getListPesertaBy'+par.id+'&noKa='+document.getElementById('NoKa').value+'&nip='+document.getElementById('NIP').value; */
                     var tglSJP = document.getElementById('TglSJP_sjp').value.split('-');
                     tglSJP = tglSJP[2]+'-'+tglSJP[1]+'-'+tglSJP[0];
                     var url = 'get_sjp.php?act=getListPesertaBy'+par.id+'&tglSJP='+tglSJP+'&noKa='+document.getElementById('NoKa').value+'&nip='+document.getElementById('NIP').value;
                     Request_sjp(url , 'listPas_sjp', '', 'GET' );
                     //if (document.getElementById('listDiag_sjp').style.display=='none') fSetPosisi(document.getElementById('listDiag_sjp'),par);
                     document.getElementById('listPas_sjp').style.display='block';
                }
                else{
                     if(document.getElementById('NIP').value != nip_bef){
                        fKeyEnt_sjp=true;
                        document.getElementById('listPas_sjp').style.display='none';
                     }
                     nip_bef = document.getElementById('NIP').value;
                }
            }
            else if(key == 27){
                fKeyEnt_sjp=true;
                document.getElementById('listPas_sjp').style.display = 'none';
            }
        }
    }
       
       function fSetPas(par){
          fKeyEnt_sjp = true;
          document.getElementById('listPas_sjp').style.display='none';
          document.getElementById('NoKa').disabled = false;
          document.getElementById('NIP').disabled = false;
          document.getElementById('close_btn').disabled = false;
          document.getElementById('load_gif').style.display = 'none';
          document.getElementById('conf_sjp').disabled = false;
          //Nama PPK    Nomor MR    Gol
          var nope = par.childNodes[3].innerHTML;//No Peserta
          var pisa = par.childNodes[5].innerHTML;//PISA
          var nama = par.childNodes[7].innerHTML;//Nama
          var gender = par.childNodes[9].innerHTML;//Kelamin
          var gol = par.childNodes[19].innerHTML;//Golongan
          //alert(par.childNodes[3].innerHTML+'---'+par.childNodes[5].innerHTML+'---'+par.childNodes[7].innerHTML+'---'+par.childNodes[9].innerHTML+'---'+par.childNodes[19].innerHTML);
          var birth = par.childNodes[11].innerHTML.split(' ');//Tgl Lahir
          birth = birth[0];
          var kodePPK = par.childNodes[13].innerHTML;//Kode PPK
          
          var temp_loc = nope+'*-*'+pisa+'*-*'+nama+'*-*'+gender+'*-*'+birth+'*-*'+kodePPK;
          temporary_sjp = temp_loc.split('*-*');
          if(temporary_sjp.length < 2){
           alert('Gagal mengambil data Pasien.');
           return;
          }
          /*temporary_sjp[0] = nope;
          temporary_sjp[1] = pisa;
          temporary_sjp[2] = nama;
          temporary_sjp[3] = gender;
          temporary_sjp[5] = kodePPK;
          temporary_sjp[6];
          temporary_sjp[7];
          temporary_sjp[8];*/
          
          //noKa
          document.getElementById('NoKa').value = nope;
          document.getElementById('NoAnggota').value = nope;
          document.getElementById('kodeppk_sjp').value = kodePPK;
          //status
          document.getElementById('span_StatusPenj_sjp').innerHTML = ((pisa=='P')?'PESERTA':(pisa=='S'?'SUAMI':(pisa=='I'?'ISTRI':(pisa=='1'?'ANAK KE 1':'ANAK KE 2'))));
          document.getElementById('StatusPenj').value = document.getElementById('span_StatusPenj_sjp').innerHTML;
          //tgl lahir
          document.getElementById('span_birth_sjp').innerHTML = birth;//birth[2]+'-'+birth[1]+'-'+birth[0];
          document.getElementById('TglLahir').value = birth;//birth[2]+'-'+birth[1]+'-'+birth[0];
          birth = birth.split('-');
          temporary_sjp[4] = birth[2]+'-'+birth[1]+'-'+birth[0];
          //gender
          document.getElementById('span_gender_sjp').innerHTML = ((gender=='L')?'Laki-laki':'Perempuan');
          //nama
          document.getElementById('span_namaP_sjp').innerHTML = nama;
          //Hak_Kelas
          if (gol=="I" || gol=="II"){
            document.getElementById('HakKelas').value = 3;
            document.getElementById('HakKelas_sjp').value = 3;
          }else{
            document.getElementById('HakKelas').value = 2;
            document.getElementById('HakKelas_sjp').value = 2;
          }
       }
       
    var temporary_sjp = '';
    function set_sjp(){
        //alert(document.getElementById('listPas_sjp').innerHTML);
        temporary_sjp = document.getElementById('listPas_sjp').innerHTML.split('*-*');
        //alert(temporary_sjp.length);
        fKeyEnt_sjp = true;
        document.getElementById('NoKa').disabled = false;
        document.getElementById('NIP').disabled = false;
        document.getElementById('close_btn').disabled = false;
        document.getElementById('load_gif').style.display = 'none';
        document.getElementById('conf_sjp').disabled = false;
        if(temporary_sjp.length < 2){
            alert('Gagal Mengambil Data Pasien.');
            return;
        }
        //alert(document.getElementById('listPas_sjp').innerHTML)
        //0000097666569*-*P*-*IDA TRI KASIANI*-*L*-*1967-03-21 00:00:00.0*-*13031601*-*PUSKESMAS WONOAYU*-*0*-*III
        var nope = temporary_sjp[0];
        var pisa = temporary_sjp[1];
        var nama = temporary_sjp[2];
        var gender = temporary_sjp[3];
        var birth = temporary_sjp[4].split(' ');
        birth = birth[0];
        temporary_sjp[4] = birth;
        var kodePPK = temporary_sjp[5];
        var namaPPK = temporary_sjp[6];
        var hakKelasSJP = temporary_sjp[7];
        var entah = temporary_sjp[7];
        var gol = temporary_sjp[8];
        var nik = temporary_sjp[9];
        
        //noKa
        document.getElementById('NoKa').value = nope;
        document.getElementById('NoAnggota').value = nope;
        document.getElementById('NIP').value = nik;
        document.getElementById('kodeppk_sjp').value = kodePPK;
        //status
        //document.getElementById('span_StatusPenj_sjp').innerHTML = ((pisa=='P')?'PESERTA':(pisa=='S'?'SUAMI':(pisa=='I'?'ISTRI':(pisa=='1'?'ANAK KE 1':'ANAK KE 2'))));
        
        document.getElementById('span_StatusPenj_sjp').innerHTML = ((pisa=='1')?'PESERTA':(pisa=='2'?'SUAMI/ISTRI':(pisa=='3'?'ANAK':(pisa=='4'?'KEL. TAMBAHAN':''))));
        document.getElementById('StatusPenj').value = document.getElementById('span_StatusPenj_sjp').innerHTML;
        if (hakKelasSJP == "1"){
            document.getElementById('HakKelas_sjp').value = 2;
        }else if (hakKelasSJP == "2"){
            document.getElementById('HakKelas_sjp').value = 3;
        } else {
            document.getElementById('HakKelas_sjp').value = 4;
        }
        /* if (temporary_sjp[8]=="I" || temporary_sjp[8]=="II"){
            document.getElementById('HakKelas_sjp').options.selectedIndex = 1;
        }else{
            document.getElementById('HakKelas_sjp').options.selectedIndex = 0;
        } */
        document.getElementById('HakKelas').value = document.getElementById('HakKelas_sjp').value;
        //tgl lahir
        birth = birth.split('-');
        document.getElementById('span_birth_sjp').innerHTML = birth[2]+'-'+birth[1]+'-'+birth[0];
        document.getElementById('TglLahir').value = birth[2]+'-'+birth[1]+'-'+birth[0];
        //gender
        document.getElementById('span_gender_sjp').innerHTML = ((gender=='L')?'Laki-laki':'Perempuan');
        //nama
        document.getElementById('span_namaP_sjp').innerHTML = nama;
        if (document.getElementById('StatusPas').value == <?php echo $idKsoBPJS; ?>) {
            b.loadURL("riwayat_px_bpjs_utils.php?pasien_id="+document.getElementById('txtIdPasien').value,'','GET');
        }
    }
    
    function print_sjp(par){
       if(par == 'first_time'){
          document.getElementById('first_time').value = 'true';
       }
       else{
          if(a.getRowId(a.getSelRow()) == ''){
             alert('Tidak ada data.');
             return;
          }
          document.getElementById('first_time').value = 'false';
          var sisipan=a.getRowId(a.getSelRow()).split("|");
            /*var p="txtIdPasien*-*"+sisipan[1]+"*|*txtIdKunj*-*"+sisipan[0]+"*|*NoRm*-*"+sisipan[2]+"*|*NoBiling*-*"+sisipan[3]
                +"*|*Nama*-*"+a.cellsGetValue(a.getSelRow(),3)+"*|*NmOrtu*-*"+sisipan[12]+"*|*NmSuTri*-*"+sisipan[13]+"*|*Gender*-*"+sisipan[14]
                +"*|*cmbAgama*-*"+sisipan[17]+"*|*Pendidikan*-*"+sisipan[15]+"*|*Pekerjaan*-*"+sisipan[16]+"*|*TglLahir*-*"+sisipan[4]
                +"*|*th*-*"+sisipan[20]+"*|*Bln*-*"+sisipan[21]+"*|*TglKunj*-*"+sisipan[19]+"*|*Alamat*-*"+sisipan[5]+"*|*telp*-*"+sisipan[18]
                +"*|*rt*-*"+sisipan[6]+"*|*rw*-*"+sisipan[7]+"*|*AslMasuk*-*"+sisipan[29]+"*|*cmbProp*-*"+sisipan[11]+"*|*Ket*-*"+sisipan[30]
                +"*|*cmbKab*-*"+sisipan[10]+"*|*StatusPas*-*"+sisipan[25]+"*|*cmbKec*-*"+sisipan[9]+"*|*TglSJP*-*"+sisipan[26]
                +"*|*cmbDesa*-*"+sisipan[8]+"*|*NoSJP*-*"+sisipan[27]+"*|*TglSJP_sjp*-*"+sisipan[26]+"*|*HakKelas_sjp*-*"+sisipan[33]
                +"*|*Penjamin*-*"+sisipan[25]+"*|*txtPenjamin*-*"+((sisipan[25]=='1')?'':sisipan[31])+"*|*NoAnggota*-*"+sisipan[28]
                +"*|*prev_inap*-*"+sisipan[34]+"*|*StatusPenj*-**|*"+defSim+"*|*btnHapus*-*"+disableHapus+"*|*HakKelas*-*"+sisipan[33];*/
          //document.getElementById('hid_kunjungan_id').value = sisipan[0];
          document.getElementById('hid_kunjungan_id').value = cIdKunj;
          //document.getElementById('form_sjp').submit();
       }
       if (par==1){
            //document.getElementById('form_sjp').action="sjp.php";
            document.getElementById('form_sjp').action="sjp_bpjs_pdf.php";
       }else{
            //document.getElementById('form_sjp').action="sjp_isi.php";
            document.getElementById('form_sjp').action="sjp_bpjs_isi_pdf.php";
       }
       document.getElementById('form_sjp').submit();
    }

    function resetInputJkn(kunci = false){
        showHideJKN(-1); // Tutup
        document.getElementById('no-antrian').value = '';
        document.getElementById('btn-show-hide-jkn').disabled = kunci;
        jQuery("#id_antrian_jkn").val("");
        jQuery("#unit_dari_jkn").val("");
    }
    
    function print_sjp_bpjs(par){
       if(par == 'first_time'){
          document.getElementById('first_time').value = 'true';
       }
       else{
          if(a.getRowId(a.getSelRow()) == ''){
             alert('Tidak ada data.');
             return;
          }
          document.getElementById('first_time').value = 'false';
          document.getElementById('hid_kunjungan_id').value = cIdKunj;
       }
       if (par == 1){
            //document.getElementById('form_sjp').action="sjp_bpjs.php";
            document.getElementById('form_sjp').action="sjp_bpjs_pdf.php";
       }else{
            //document.getElementById('form_sjp').action="sjp_bpjs_isi.php";
            document.getElementById('form_sjp').action="sjp_bpjs_isi_pdf.php";
       }
       document.getElementById('form_sjp').submit();
    }
    
    function confirm_sjp(){
        if(temporary_sjp.length < 1){
            alert("Data Pasien Belum Ada !");
            return;
        }
        var unit = document.getElementById('TmpLayanan').value;
        if(unit == 45){
          //ms_kd_diag = '99999';
        }
        if(ms_kd_diag == ''){
            alert("Data Diagnosa Pasien Harus Diisi !");
            return;
        }
        if(document.getElementById('TglSJP_sjp').value == ''){
          alert('Tanggal SJP Harus Diisi !');
          return;
        }
        var kelasRawat=document.getElementById('HakKelas_sjp').value;
        var no_pe = temporary_sjp[0];
        var pisa = temporary_sjp[1];
        var nama = temporary_sjp[2];
        var gender = temporary_sjp[3];
        var birth = temporary_sjp[4];
        //var kodePPK = temporary_sjp[5];
        var kodePPK = document.getElementById('kodeppk_sjp').value;
        var namaPPK = temporary_sjp[6];
        var entah = temporary_sjp[7];
        var gol = temporary_sjp[8];
        var norm = document.getElementById('NoRm').value;
        var tglSJP = document.getElementById('TglSJP_sjp').value.split('-');
        tglSJP = tglSJP[2]+'-'+tglSJP[1]+'-'+tglSJP[0];
        getIdKso = document.getElementById('StatusPas').value;
        if(kelasRawat == 25) {
            kelasRawat = 1;
        } else if (kelasRawat == 27) {
            kelasRawat = 2;
        } else {
            kelasRawat = 3;
        }
        //var url = 'get_sjp.php?act=generateSJP&noKa='+no_pe+'&pisa='+pisa+'&namaPeserta='+nama+'&tglLahirPeserta='+birth+'&sexPeserta='+gender+'&norm='+norm+'&tglSJP='+tglSJP+'&kodePPK='+kodePPK+'&kd_diag='+ms_kd_diag+'&unit='+unit;
        /* var url = 'get_sjpRelay.php?act=generateSJP&noKa='+no_pe+'&pisa='+pisa+'&namaPeserta='+nama+'&tglLahirPeserta='+birth+'&sexPeserta='+gender+'&norm='+norm+'&tglSJP='+tglSJP+'&kodePPK='+kodePPK+'&kd_diag='+ms_kd_diag+'&unit='+unit; */
        
        var url = 'get_sjp.php?act=generateSJP&noKa='+no_pe+'&pisa='+pisa+'&namaPeserta='+nama+'&tglLahirPeserta='+birth+'&sexPeserta='+gender+'&norm='+norm+'&tglSJP='+tglSJP+'&kodePPK='+kodePPK+'&kd_diag='+ms_kd_diag+'&unit='+unit+'&kelasRawat='+kelasRawat+'&userId=<?php echo $userId; ?>';
        //alert(url);
        //validate_sjp();
        Request_sjp(url , 'listPas_sjp', '', 'GET', validate_sjp );
    }
    
    function validate_sjp(){
        var tmp = document.getElementById('listPas_sjp').innerHTML;
        //.split(', ');
        //var tmp = "1, 123456789".split(', ');
        var errmsg='';
        if(tmp.substr(0,5)=="Error"){
            //alert("msk");
            tmp=tmp.split("|");
            if (tmp[1]=="INAP"){
                UpdateTglPlg_sjp(tmp[2]);
            }else{
                alert(tmp[1]);
            }
        }
        else{
            document.getElementById('NoSJP').value = tmp;
            getnoSEP = tmp;
            document.getElementById('div_getSJP').popup.hide();
            simpan(document.getElementById('btnSimpan').value);
        }
        /* if(tmp[0] == "1"){
            document.getElementById('NoSJP').value = tmp[1];
            document.getElementById('div_getSJP').popup.hide();
            simpan(document.getElementById('btnSimpan').value);
        }
        else{
            for (var j=1;j<tmp.length;j++){
                errmsg +=tmp[j];
            }
            alert(errmsg);
        } */
    }
    
    function UpdateTglPlg_sjp(no_SEP){
        var url;
        var tglSJP = document.getElementById('TglSJP_sjp').value.split('-');
        tglSJP = tglSJP[2]+'-'+tglSJP[1]+'-'+tglSJP[0];
        url = 'get_sjp.php?act=UpdateTglPlgSJP&noSEP='+no_SEP+'&tglSJP='+tglSJP;
        //alert(url);
        Request_sjp(url , 'listPas_sjp', '', 'GET', Confirm_SEP_Plg );
    }
    
    function Confirm_SEP_Plg(){
        var tmp = document.getElementById('listPas_sjp').innerHTML;
        //alert(tmp);
        if (tmp=="PULANG-OK"){
            confirm_sjp();
        }else{
            alert("Gagal Update Tgl Plg SEP Pasien! ");
        }
    }
    
    //Diagnosa
        var RowIdx_sjp;
        var fKeyEnt_sjp;
        var ms_kd_diag = '';
        function suggest_diag(e,par){
            var keywords=par.value;//alert(keywords);
            var unit = document.getElementById('TmpLayanan').value;
            if(e == 'cariDiag'){
                if(document.getElementById('listDiag_sjp').style.display == 'block'){
                    document.getElementById('listDiag_sjp').style.display='none';
                }
                else{
                    Request('diagnosalist.php?findAll=true&unitId='+unit+'&aKeyword='+keywords , 'listDiag_sjp', '', 'GET' );
                    if (document.getElementById('listDiag_sjp').style.display=='none') fSetPosisi(document.getElementById('listDiag_sjp'),par);
                    document.getElementById('listDiag_sjp').style.display='block';
                }
            }
            else{
                if(keywords==""){
                    document.getElementById('listDiag_sjp').style.display='none';
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
                            //alert(RowIdx_sjp);
                            if (key==38 && RowIdx_sjp>0){
                                RowIdx_sjp=RowIdx_sjp-1;
                                document.getElementById('lstDiag'+(RowIdx_sjp+1)).className='itemtableReq';
                                if (RowIdx_sjp>0) document.getElementById('lstDiag'+RowIdx_sjp).className='itemtableMOverReq';
                            }else if (key == 40 && RowIdx_sjp < tblRow){
                                RowIdx_sjp=RowIdx_sjp+1;
                                if (RowIdx_sjp>1) document.getElementById('lstDiag'+(RowIdx_sjp-1)).className='itemtableReq';
                                document.getElementById('lstDiag'+RowIdx_sjp).className='itemtableMOverReq';
                            }
                        }
                    }
                    else if (key==13){
                        if (RowIdx_sjp>0){
                            if (fKeyEnt_sjp==false){
                                fSetPenyakit(document.getElementById('lstDiag'+RowIdx_sjp).lang);
                            }else{
                                fKeyEnt_sjp=false;
                            }
                        }
                    }
                    else if (key!=27 && key!=37 && key!=39){
                        RowIdx_sjp=0;
                        fKeyEnt_sjp=false;
                        Request('diagnosalist.php?unitId='+unit+'&aKeyword='+keywords , 'listDiag_sjp', '', 'GET' );
                        //if (document.getElementById('listDiag_sjp').style.display=='none') fSetPosisi(document.getElementById('listDiag_sjp'),par);
                        document.getElementById('listDiag_sjp').style.display='block';
                    }
                }
            }
        }

        function fSetPenyakit(par){
            var cdata=par.split("*|*");
            ms_kd_diag = cdata[2];
            while (ms_kd_diag.indexOf(' ')>0){
                ms_kd_diag=ms_kd_diag.replace(' ','');
            }
            while (ms_kd_diag.indexOf('.')>0){
                ms_kd_diag=ms_kd_diag.replace('.','');
            }
            ms_kd_diag = ms_kd_diag.substring(0,3);
            document.getElementById("diagnosa_id_sjp").value=cdata[0];
            document.getElementById("diag_sjp").value=cdata[2]+" - "+cdata[1];
            document.getElementById('listDiag_sjp').style.display='none';
        }
        
        function saring(){
            //alert("registrasi_utils.php?grd=true&saring=true&saringan="+document.getElementById('TglKunj').value+"&userLog="+document.getElementById('userLog').value+"&asal="+document.getElementById('asal').value);
            a.loadURL("registrasi_utils.php?grd=true&saring=true&saringan="+document.getElementById('TglKunj').value+"&userLog="+document.getElementById('userLog').value+"&asal="+document.getElementById('asal').value,"","GET");
            /*if(document.getElementById('NoRm').value=='' || document.getElementById('txtIdPasien').value == ''){
                getNoRM();
            }else{
                getNoBil();
            }*/
        }

        function kartu()
        {           
            var tmpLayanan = document.getElementById("TmpLayanan").value;
            var statusPas = document.getElementById("StatusPas").value;
            var hakKelas = document.getElementById("HakKelas").value;
            var dokter = document.getElementById('cmbDokter').value;
            var asalMsk = document.getElementById("AslMasuk").value;
            var tglKun = document.getElementById("TglKunj").value;
            var dokterPengganti = 0;
                if(document.getElementById('chkDokterPengganti').checked){
                    dokterPengganti = 1;
                }
            
            if (cIdPas==""){
                alert("Pilih Pasien Terlebih Dahulu !");
            }else{
                window.open('cetakKartu.php?idPas='+cIdPas+'&tmpLayanan='+tmpLayanan+'&statusPas='+statusPas+'&hakKelas='+hakKelas+'&dokter='+dokter+'&dokterPengganti='+dokterPengganti+'&asalMsk='+asalMsk+'&tglKun='+tglKun+'&userId='+<?php echo $userId; ?>,'_blank');
                
            }
            //batal();
        }

        function kartuB()
        {           
            if (cIdPas==""){
                alert("Pilih Pasien Terlebih Dahulu !");
            }else{
                window.open('cetakKartuBarcode.php?idPas='+cIdPas,'_blank');
            }
            //batal();
        }

        function cetak()
        {
            if (cIdKunj==""){
                alert("Pilih Kunjungan Pasien Terlebih Dahulu !");
            }else{
                window.open('cetakLoket.php?idPas='+cIdPas+'&loketId='+document.getElementById('asal').value+'&idKunj='+cIdKunj+'&userId=<?php echo $userId;?>','_blank');
            }
            //batal();
        }
        
         function cetak2()
        {
            if (cIdKunj==""){
                alert("Pilih Kunjungan Pasien Terlebih Dahulu !");
            }else{
                window.open('cetakAntrian.php?idPas='+cIdPas+'&loketId='+document.getElementById('asal').value+'&idKunj='+cIdKunj+'&userId=<?php echo $userId;?>','_blank');
            }
            //batal();
        }
        
        
        function kiup()
        {
            if (cIdKunj==""){
                alert("Pilih Kunjungan Pasien Terlebih Dahulu !");
            }else{
                window.open('cetakKIUP.php?idPas='+cIdPas+'&loketId='+document.getElementById('asal').value+'&idKunj='+cIdKunj+'&userId=<?php echo $userId;?>','_blank');
            }
            //batal();
        }
        
        function cetak_label()
        {
            var h = "400";
            var w = "500";
            var w1 = "330";
            var h1 = "270";
            var LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
            var TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
            var usrId = <? echo $userId;?>;
            
            if (cIdKunj==""){
                alert("Pilih Kunjungan Pasien Terlebih Dahulu !");
            }else{
                window.open('cetakLabelP.php?idPas='+cIdPas+'&loketId='+document.getElementById('asal').value+'&idKunj='+cIdKunj+'&userId=<?php echo $userId;?>','','height='+h1+',width='+w1+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable');
            }
            //batal();
        }
        
        function cetakDaftar(){
            if (cIdKunj==""){
                <?
                    $sql12 = "SELECT MAX(id) AS id FROM b_kunjungan";
                    $rsql12 = mysql_query($sql12);
                    $dsql12 = mysql_fetch_array($rsql12);
                ?>
                cIdKunj = "<? echo $dsql12['id']?>";
                //alert(cIdKunj);
                //alert("Pilih Kunjungan Pasien Terlebih Dahulu !");
            }else{
                window.open('cetakDaftar.php?idPas='+cIdPas+'&loketId='+document.getElementById('asal').value+'&idKunj='+cIdKunj+'&userId=<?php echo $userId;?>','_blank');
            }
            //batal();
        }
        
        function cetakDaftar1(a){
                var h = "400";
                var w = "500";
                var w1 = "150";
                var h1 = "400";
                var LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
                var TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
                var usrId = <? echo $userId;?>;
                
                window.open('cetakDaftar.php?idPas='+cIdPas+'&loketId='+document.getElementById('asal').value+'&idKunj='+a+'&userId=<?php echo $userId;?>','','height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable');
                if(usrId == 732)
                {
                    w1 = "330";
                    h1 = "270";
                    window.open('cetakLabelP.php?idPas='+cIdPas+'&loketId='+document.getElementById('asal').value+'&idKunj='+a+'&userId=<?php echo $userId;?>','','height='+h1+',width='+w1+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable');  
                }

            //batal();
        }

        function cetakForm()
        {
            if (cIdKunj==""){
                alert("Pilih Kunjungan Pasien Terlebih Dahulu !");
            }else{
                window.open('cetakForm.php?idPas='+cIdPas+'&idKunj='+cIdKunj+'&Unit='+cUnit+'&userId=<?php echo $userId;?>','_blank');
            }
            //batal();
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
       }
        
       function PopUpdtStatus(){
          /*p="txtIdPasien*-*"+dataPasien[0]+"*|*NoRm*-*"+dataPasien[1]+"*|*NmOrtu*-*"+dataPasien[11]+"*|*Nama*-*"+dataPasien[2]
                +"*|*NmSuTri*-*"+dataPasien[12]+"*|*Gender*-*"+dataPasien[13]+"*|*TglLahir*-*"+dataPasien[3]+"*|*Alamat*-*"+dataPasien[4]
                +"*|*cmbProp*-*"+dataPasien[10]+"*|*cmbKab*-*"+dataPasien[9]+"*|*cmbKec*-*"+dataPasien[8]+"*|*cmbDesa*-*"+dataPasien[7]
                +"*|*rt*-*"+dataPasien[5]+"*|*rw*-*"+dataPasien[6]+"*|*Pendidikan*-*"+dataPasien[14]+"*|*Pekerjaan*-*"+dataPasien[15]
                +"*|*cmbAgama*-*"+dataPasien[16]+"*|*telp*-*"+dataPasien[17]+"*|*StatusPas*-*"+dataPasien[18]+"*|*Penjamin*-*"+dataPasien[18]
                +"*|*NoAnggota*-*"+dataPasien[19]+"*|*HakKelas*-*"+dataPasien[20]+"*|*StatusPenj*-*"+dataPasien[21]+"*|*txtIdKunj*-*"+dataPasien[22]+"*|*TglKunj*-*"+dataPasien[23]+"*|*AslMasuk*-*"+dataPasien[24]+"*|*StatusPas*-*"+dataPasien[18]+"*|*TglSJP*-*"+dataPasien[25]+"*|*NoSJP*-*"+dataPasien[26];
                glob_jnsLay=dataPasien[27];
                glob_tmpLay=dataPasien[28];
                glob_kamar=dataPasien[29];
                glob_kelas=dataPasien[30];
                glob_ret = dataPasien[31];
                cIdPas=dataPasien[0];
                cIdKunj=dataPasien[22];
                cUnit=dataPasien[28];*/
          /*var p="txtIdPasien*-*"+sisipan[1]+"*|*txtIdKunj*-*"+sisipan[0]+"*|*NoRm*-*"+sisipan[2]+"*|*NoBiling*-*"+sisipan[3]
                +"*|*Nama*-*"+a.cellsGetValue(a.getSelRow(),3)+"*|*NmOrtu*-*"+sisipan[12]+"*|*NmSuTri*-*"+sisipan[13]+"*|*Gender*-*"+sisipan[14]
                +"*|*cmbAgama*-*"+sisipan[17]+"*|*Pendidikan*-*"+sisipan[15]+"*|*Pekerjaan*-*"+sisipan[16]+"*|*TglLahir*-*"+sisipan[4]
                +"*|*th*-*"+sisipan[20]+"*|*Bln*-*"+sisipan[21]+"*|*TglKunj*-*"+sisipan[19]+"*|*Alamat*-*"+sisipan[5]+"*|*telp*-*"+sisipan[18]
                +"*|*rt*-*"+sisipan[6]+"*|*rw*-*"+sisipan[7]+"*|*AslMasuk*-*"+sisipan[29]+"*|*cmbProp*-*"+sisipan[11]+"*|*Ket*-*"+sisipan[30]
                +"*|*cmbKab*-*"+sisipan[10]+"*|*StatusPas*-*"+sisipan[25]+"*|*cmbKec*-*"+sisipan[9]+"*|*TglSJP*-*"+sisipan[26]
                +"*|*cmbDesa*-*"+sisipan[8]+"*|*NoSJP*-*"+sisipan[27]
                +"*|*Penjamin*-*"+sisipan[25]+"*|*txtPenjamin*-*"+((sisipan[25]=='1')?'':sisipan[31])+"*|*NoAnggota*-*"+sisipan[28]
                +"*|*prev_inap*-*"+sisipan[34]+"*|*StatusPenj*-**|*"+defSim+"*|*btnHapus*-*"+disableHapus+"*|*HakKelas*-*"+sisipan[33];*/
                //"statusPx*-*"+getKsoId+"*|*TglSJP*-*"+getTgl_sjp+"*|*NoSJP*-*"+getNoSJP+"*|*NoJaminan*-*"+getNoJaminan+"*|*cmbHakKelas*-*"+getKsoKelasId+"*|*StatusPenj*-*"+getStatusPenj+"*|*nmPeserta*-*"+getnmPeserta
          var status_pas_upd = document.getElementById('StatusPas').value;
          var nama_upd = document.getElementById('Nama').value;
          var no_anggota_upd = document.getElementById('NoAnggota').value;
          var tgl_sjp_upd = document.getElementById('TglSJP').value;
          var no_sjp_upd = document.getElementById('NoSJP').value;
          var hak_kelas_upd = document.getElementById('HakKelas').value;
          var status_penj_upd = document.getElementById('StatusPenj').value;
          
          var url = "statusPx*-*"+status_pas_upd+"*|*TglSJP_pop*-*"+tgl_sjp_upd+"*|*NoSJP_pop*-*"+no_sjp_upd
              +"*|*NoJaminan*-*"+no_anggota_upd+"*|*cmbHakKelas*-*"+hak_kelas_upd+"*|*StatusPenj_pop*-*"+status_penj_upd
              +"*|*nmPeserta*-*"+nama_upd;
              //alert(url)
          fSetValue(window,url);
          if (status_pas_upd==39){
              fSetValue(window,"cmbHakKelas*-*4");
          }
          fChangeStatusPx(document.getElementById('statusPx').value);
            new Popup('divUpdtStatus',null,{modal:true,position:'center',duration:1});
            document.getElementById('divUpdtStatus').popup.show();
       }
        
       function goUpdtStatusPx(){
          /*p="txtIdPasien*-*"+dataPasien[0]+"*|*NoRm*-*"+dataPasien[1]+"*|*NmOrtu*-*"+dataPasien[11]+"*|*Nama*-*"+dataPasien[2]
                +"*|*NmSuTri*-*"+dataPasien[12]+"*|*Gender*-*"+dataPasien[13]+"*|*TglLahir*-*"+dataPasien[3]+"*|*Alamat*-*"+dataPasien[4]
                +"*|*cmbProp*-*"+dataPasien[10]+"*|*cmbKab*-*"+dataPasien[9]+"*|*cmbKec*-*"+dataPasien[8]+"*|*cmbDesa*-*"+dataPasien[7]
                +"*|*rt*-*"+dataPasien[5]+"*|*rw*-*"+dataPasien[6]+"*|*Pendidikan*-*"+dataPasien[14]+"*|*Pekerjaan*-*"+dataPasien[15]
                +"*|*cmbAgama*-*"+dataPasien[16]+"*|*telp*-*"+dataPasien[17]+"*|*StatusPas*-*"+dataPasien[18]+"*|*Penjamin*-*"+dataPasien[18]
                +"*|*NoAnggota*-*"+dataPasien[19]+"*|*HakKelas*-*"+dataPasien[20]+"*|*StatusPenj*-*"+dataPasien[21]+"*|*txtIdKunj*-*"+dataPasien[22]+"*|*TglKunj*-*"+dataPasien[23]+"*|*AslMasuk*-*"+dataPasien[24]+"*|*StatusPas*-*"+dataPasien[18]+"*|*TglSJP*-*"+dataPasien[25]+"*|*NoSJP*-*"+dataPasien[26];
                glob_jnsLay=dataPasien[27];
                glob_tmpLay=dataPasien[28];
                glob_kamar=dataPasien[29];
                glob_kelas=dataPasien[30];
                glob_ret = dataPasien[31];
                cIdPas=dataPasien[0];
                cIdKunj=dataPasien[22];
                cUnit=dataPasien[28];*/
        var cstatusPx=document.getElementById('statusPx').value;
        var cTglSJP=document.getElementById('TglSJP_pop').value;
        var cNoSJP=document.getElementById('NoSJP_pop').value;
        var cNoJaminan=document.getElementById('NoJaminan').value;
        var ccmbHakKelas=document.getElementById('cmbHakKelas').value;
        var cStatusPenj=document.getElementById('StatusPenj_pop').value;
        var cnmPeserta=document.getElementById('nmPeserta').value;
        var getIdKunj = document.getElementById('txtIdKunj').value;
        var getIdPasien = document.getElementById('txtIdPasien').value;
            /*i++;
            if (i==6) i=1;
            fSetValue(window,"statusPx*-*"+i);
            fChangeStatusPx(document.getElementById('statusPx').value);*/
            var url="../unit_pelayanan/updtStatusPx_utils.php?idKunj="+getIdKunj+"&cstatusPx="+cstatusPx+"&cTglSJP="+cTglSJP
            +"&cNoSJP="+cNoSJP+"&cNoJaminan="+cNoJaminan+"&ccmbHakKelas="+ccmbHakKelas+"&cStatusPenj="+cStatusPenj
            +"&IdPasien="+getIdPasien+"&cnmPeserta="+cnmPeserta;
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

        function skp(par)
        {
          var url = 'skpJamkesda.php?idKunj='+document.getElementById("txtIdKunj").value+'&userId=<?php echo $userId;?>';
          if(par == 'kamar'){
             url += "&kamar=true";
          }else if (par == 'jampersal'){
            url += "&jampersal=true";
          }
          window.open(url,'_blank'); 
            //batal();
        }

        function spi()
        {
            window.open('../unit_pelayanan/spInap.php?idKunj='+cIdKunj+'&dokter_id=','_blank');
            //batal();
        }

        function refreshGrid(){
            goFilterAndSort('gridbox');
            setTimeout('refreshGrid()', '120000');
        }

        function goFilterAndSort(grd){
            //alert(grd);
            if (grd=="gridbox"){
                //alert("registrasi_utils.php?grd=true&saring=true&saringan="+document.getElementById('TglKunj').value+"&userLog="+document.getElementById('userLog').value+"&asal="+document.getElementById('asal').value+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
                a.loadURL("registrasi_utils.php?grd=true&saring=true&saringan="+document.getElementById('TglKunj').value+"&userLog="+document.getElementById('userLog').value+"&asal="+document.getElementById('asal').value+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
            }else if(grd == "gridboxpcr"){
                pcr.loadURL("pcr_klinik_utils.php?grd=getData&filter="+pcr.getFilter()+"&sorting="+pcr.getSorting()+"&page="+pcr.getPage(),"","GET");
            }
        }

        function konfirmasi(key,val){
            var sisip;
            //alert(val);
            if(key=='Error'){
                if(val=='tambah')
                    alert('Tambah Gagal');
                else if(val=='simpan')
                    alert('Simpan Gagal');
                else if(val=='hapus')
                    alert('Hapus Gagal');
                else if(val=='SudahAda')
                    alert('Pasien Sudah Berkunjung ke Unit Tersebut !');
                    
                batal();
            }else if(val!=undefined && val!=""){
                sisip=val.split("|");
                if(sisip[0]=='tambah' || sisip[0]=='simpan' || sisip[0]=='hapus'){
                    if(sisip[0]=='tambah'){
                        
                        //alert('Tambah Berhasil');
                        //alert(sisip[1]);
                        
                        Request('registrasi_utils.php?forKonfirmasi=true&fPasienID='+sisip[
                            2], 'fKonfirmasi', '', 'GET',function(){
                            var ss = document.getElementById('fKonfirmasi').innerHTML.split('|');
                            //alert(document.getElementById('fKonfirmasi').innerHTML);
                            var dialog = "<div style='text-align:center;'>"+
                                            "<label style='font-size:16px; text-decoration:underline;'>Berhasil Ditambah</label> <br /><br />"+
                                            "<label style='font-size:20px; padding-left:20px; font-weight:bold;'>No RM : "+ss[0]+"</label> <br />"+
                                            "<label style='font-size:20px; padding-left:20px; font-weight:bold;'>Nama : "+ss[1]+"</label> <br /><br />"+
                                            "<input type='button' onClick='hideDialog()' value='    OK    ' />"+
                                         "</div>";
                            showDialog('Succses',dialog,'success');
                        });
                        
                        //cetakDaftar1(sisip[1]);
                    }
                    else if(sisip[0]=='simpan'){
                        //alert('Simpan Berhasil');
                        Request('registrasi_utils.php?forKonfirmasi=true&fPasienID='+sisip[2], 'fKonfirmasi', '', 'GET',function(){
                            var ss = document.getElementById('fKonfirmasi').innerHTML.split('|');
                            var dialog = "<div style='text-align:center;'>"+
                                            "<label style='font-size:16px; text-decoration:underline;'>Berhasil Disimpan</label> <br /><br />"+
                                            "<label style='font-size:20px; padding-left:20px; font-weight:bold;'>No RM : "+ss[0]+"</label> <br />"+
                                            "<label style='font-size:20px; padding-left:20px; font-weight:bold;'>Nama : "+ss[1]+"</label> <br /><br />"+
                                            "<input type='button' onClick='hideDialog()' value='    OK    ' />"+
                                         "</div>";
                            showDialog('Succses',dialog,'success');
                        });
                        //alert(sisip[1]);
                        //cetakDaftar1(sisip[1]);
                    }
                    else if(sisip[0]=='hapus')
                        alert('Hapus Berhasil');
                        
                    batal();
                    
                    if(sisip[0]!='hapus'){
                        cIdKunj=sisip[1];
                        cIdPas=sisip[2];
                        cUnit = sisip[3];
                        document.getElementById("hid_kunjungan_id").value=cIdKunj;
                        if (document.getElementById("StatusPas").value=="4"){
                            document.getElementById("sjpAskes").disabled = false;
                            document.getElementById("sjpAskes_isi").disabled = false;
                        }else{
                            document.getElementById("sjpAskes").disabled = true;
                            document.getElementById("sjpAskes_isi").disabled = true;
                        }
                        if (sisip[4]=="1"){
                            document.getElementById("spInap").disabled = false;
                        }else{
                            document.getElementById("spInap").disabled = true;
                        }
                    }else{
                        cIdKunj="";
                        cIdPas="";
                        cUnit = "";
                        document.getElementById("hid_kunjungan_id").value="";
                        document.getElementById("sjpAskes").disabled = true;
                        document.getElementById("sjpAskes_isi").disabled = true;
                        document.getElementById("spInap").disabled = true;
                    }
                }
            }

            if(abc==0){
                isiCombo('asalLoket','<?php echo $userId; ?>','77','asal',decUser);
                refreshGrid();
            }

            abc=1;
        }

        var a=new DSGridObject("gridbox");
        a.setHeader("DATA KUNJUNGAN PASIEN");
        a.setColHeader("NO,NO RM,NAMA,PENJAMIN,TEMPAT LAYANAN,RETRIBUSI,DOKTER,KELAS,ALAMAT");
        a.setIDColHeader(",no_rm,nama,nama_kso,tempat_layanan,tarip_r,dokter,kelas,alamat");
        a.setColWidth("30,70,200,180,150,100,180,80,260");
        a.setCellAlign("center,center,left,center,center,right,left,center,left");
        a.setCellHeight(20);
        a.setImgPath("../icon");
        a.setIDPaging("paging");
        a.attachEvent("onRowClick","ambilData");
        a.onLoaded(konfirmasi);
        //alert("registrasi_utils.php?grd=true&saring=true&saringan="+document.getElementById('TglKunj').value);
        a.baseURL("registrasi_utils.php?grd=true&saring=true&saringan="+document.getElementById('TglKunj').value);
        a.Init();
        
    
        var b=new DSGridObject("gridbox_diag_bpjs");
        b.setHeader("RIWAYAT KUNJUNGAN PASIEN BPJS");
        b.setColHeader("NO,TGL KUNJUNGAN,NO SEP,POLI,DIAGNOSA");
        b.setIDColHeader(",,,,");
        b.setColWidth("30,70,120,100,230");
        b.setCellAlign("center,center,center,center,left");
        b.setCellHeight(20);
        b.setImgPath("../icon");
        //b.setIDPaging("paging_diag_bpjs");
        b.baseURL("riwayat_px_bpjs_utils.php?pasien_id="+document.getElementById('txtIdPasien').value);
        b.Init();
        
        function gantiDokter(comboDokter,statusCek){
            if(statusCek==true){
                isiCombo('cmbDokRegPengganti',document.getElementById('TmpLayanan').value,'','cmbDokter');
            }
            else{
                isiCombo('cmbDokReg',document.getElementById('TmpLayanan').value+','+document.getElementById('TglKunj').value,'','cmbDokter');
            }
            //document.getElementById('chkDokterPenggantiDiag').checked = document.getElementById('chkDokterPenggantiResep').checked = document.getElementById('chkDokterPenggantiTind').checked = document.getElementById('chkDokterPenggantiRujukUnit').checked = document.getElementById('chkDokterPenggantiRujukRS').checked = statusCek;
        }

        function gantiDokterPcr(comboDokter,statusCek){
            if(statusCek==true){
                isiCombo('cmbDokRegPengganti',document.getElementById('tmplayananpcr').value,'','cmbdokterpcr');
            }
            else{
                isiCombo('cmbDokReg',document.getElementById('tmplayananpcr').value+','+document.getElementById('TglKunj').value,'','cmbdokterpcr');
            }
        }       
        
        jQuery(function(){
            jQuery("#NoKTP").keydown(function(e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ( jQuery.inArray(e.keyCode,[46,8,9,27,13,190]) !== -1 ||
                     // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) || 
                     // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) { 
                         // let it happen, don't do anything
                         return;
                } else {
                    // Ensure that it is a number and stop the keypress
                    if (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105 )) {
                            e.preventDefault(); 
                    }   
                }
            });
        });
        
        function suggest(e,par,wilayah_tipe){
            var keywords=par.value;
            if(keywords=="" || keywords.length<1){
                document.getElementById('divautocomplete').style.display='none';
            }else{
                var key;
                if(window.event) {
                    key = window.event.keyCode;
                }
                else if(e.which) {
                    key = e.which;
                }
                if (key==38 || key==40){
                    var tblRow=document.getElementById('tblautocomplete').rows.length;
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
                    if (RowIdx1>0){
                        if (fKeyEnt1==false){
                            fset(document.getElementById('lstTind'+RowIdx1).lang);
                            RowIdx1=0;
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
                    Request("wilayah_autocomplete.php?wilayah_tipe="+wilayah_tipe+"&aKeyword="+keywords, 'divautocomplete', '', 'GET');
                    if (document.getElementById('divautocomplete').style.display=='none')
                        fSetPosisi(document.getElementById('divautocomplete'),par);
                    document.getElementById('divautocomplete').style.display='block';
                }
            }
        }
        
        function suggest_kab(e,par)
        {
            var keywords=par.value;
            var prop_id = document.getElementById('cmbProp').value;
            if(prop_id=="")
            {
                alert('Isi Kolom Propinsi');
                document.getElementById('prop').focus();
                document.getElementById('kabx').value="";
                return false;
            }
            
            if(keywords=="" || keywords.length<1)
            {
                document.getElementById('divautocomplete_kab').style.display='none';
            }
            else
            {
                var key;
                if(window.event) {
                    key = window.event.keyCode;
                }
                else if(e.which) {
                    key = e.which;
                }
                if (key==38 || key==40){
                    var tblRow=document.getElementById('tblautocomplete_kab').rows.length;
                    if (tblRow>0){
                        //alert(RowIdx1);
                        if (key==38 && RowIdx1>0){
                            RowIdx1=RowIdx1-1;
                            document.getElementById('list_kab'+(RowIdx1+1)).className='itemtableReq';
                            if (RowIdx1>0) document.getElementById('list_kab'+RowIdx1).className='itemtableMOverReq';
                        }
                        else if (key == 40 && RowIdx1 < tblRow){
                            RowIdx1=RowIdx1+1;
                            if (RowIdx1>1) document.getElementById('list_kab'+(RowIdx1-1)).className='itemtableReq';
                            document.getElementById('list_kab'+RowIdx1).className='itemtableMOverReq';
                        }
                    }
                }else if (key==13){
                    if (RowIdx1>0){
                        if (fKeyEnt1==false){
                            fset_kab(document.getElementById('list_kab'+RowIdx1).lang);
                            RowIdx1=0;
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
                    Request("kabupaten_autocomplete.php?prop_id="+prop_id+"&aKeyword="+keywords, 'divautocomplete_kab', '', 'GET');
                    if (document.getElementById('divautocomplete_kab').style.display=='none')
                        fSetPosisi(document.getElementById('divautocomplete_kab'),par);
                    document.getElementById('divautocomplete_kab').style.display='block';
                }
            }
        }
        
        function suggest_kec(e,par)
        {
            var keywords=par.value;
            var kab_id = document.getElementById('cmbKab').value;
            
            if(kab_id=="")
            {
                alert('Isi Kolom Kabupaten');
                document.getElementById('kabx').focus();
                document.getElementById('kecx').value="";
                return false;
            }
            
            if(keywords=="" || keywords.length<1)
            {
                document.getElementById('divautocomplete_kec').style.display='none';
            }
            else
            {
                var key;
                if(window.event) {
                    key = window.event.keyCode;
                }
                else if(e.which) {
                    key = e.which;
                }
                if (key==38 || key==40){
                    var tblRow=document.getElementById('tblautocomplete_kec').rows.length;
                    if (tblRow>0){
                        //alert(RowIdx1);
                        if (key==38 && RowIdx1>0){
                            RowIdx1=RowIdx1-1;
                            document.getElementById('list_kec'+(RowIdx1+1)).className='itemtableReq';
                            if (RowIdx1>0) document.getElementById('list_kec'+RowIdx1).className='itemtableMOverReq';
                        }
                        else if (key == 40 && RowIdx1 < tblRow){
                            RowIdx1=RowIdx1+1;
                            if (RowIdx1>1) document.getElementById('list_kec'+(RowIdx1-1)).className='itemtableReq';
                            document.getElementById('list_kec'+RowIdx1).className='itemtableMOverReq';
                        }
                    }
                }else if (key==13){
                    if (RowIdx1>0){
                        if (fKeyEnt1==false){
                            fset_kec(document.getElementById('list_kec'+RowIdx1).lang);
                            RowIdx1=0;
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
                    Request("kecamatan_autocomplete.php?kab_id="+kab_id+"&aKeyword="+keywords, 'divautocomplete_kec', '', 'GET');
                    if (document.getElementById('divautocomplete_kec').style.display=='none')
                        fSetPosisi(document.getElementById('divautocomplete_kec'),par);
                    document.getElementById('divautocomplete_kec').style.display='block';
                }
            }
        }
        
        function suggest_des(e,par)
        {
            var keywords=par.value;
            var kec_id = document.getElementById('cmbKec').value;
            
            if(kec_id=="")
            {
                alert('Isi Kolom Kecamatan');
                document.getElementById('kecx').focus();
                document.getElementById('desx').value="";
                return false;
            }
            
            if(keywords=="" || keywords.length<1)
            {
                document.getElementById('divautocomplete_des').style.display='none';
            }
            else
            {
                var key;
                if(window.event) {
                    key = window.event.keyCode;
                }
                else if(e.which) {
                    key = e.which;
                }
                if (key==38 || key==40){//alert('tes')
                    var tblRow=document.getElementById('tblautocomplete_des').rows.length;
                    if (tblRow>0){
                        //alert(RowIdx1);
                        if (key==38 && RowIdx1>0){
                            RowIdx1=RowIdx1-1;
                            document.getElementById('list_des'+(RowIdx1+1)).className='itemtableReq';
                            if (RowIdx1>0) document.getElementById('list_des'+RowIdx1).className='itemtableMOverReq';
                        }
                        else if (key == 40 && RowIdx1 < tblRow){
                            RowIdx1=RowIdx1+1; //alert(RowIdx1);
                            if (RowIdx1>1) document.getElementById('list_des'+(RowIdx1-1)).className='itemtableReq';
                            document.getElementById('list_des'+RowIdx1).className='itemtableMOverReq';
                        }
                    }
                }else if (key==13){
                    if (RowIdx1>0){
                        if (fKeyEnt1==false){
                            fset_des(document.getElementById('list_des'+RowIdx1).lang);
                            RowIdx1=0;
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
                    Request("desa_autocomplete.php?kec_id="+kec_id+"&aKeyword="+keywords, 'divautocomplete_des', '', 'GET');
                    if (document.getElementById('divautocomplete_des').style.display=='none')
                        fSetPosisi(document.getElementById('divautocomplete_des'),par);
                    document.getElementById('divautocomplete_des').style.display='block';
                }
            }
        }
        
        function fset(value)
        {
            var awal =  document.getElementById("cmbProp").value;
            var dt = value.split("|");
            if(awal!=dt[0])
            {
                document.getElementById('kabx').value="";
                document.getElementById('cmbKab').value="";
                
                document.getElementById('kecx').value="";
                document.getElementById('cmbKec').value="";
                
                document.getElementById('desx').value="";
                document.getElementById('cmbDesa').value="";
            }
            document.getElementById('kabx').focus();
            document.getElementById("cmbProp").value=dt[0];
            document.getElementById("prop").value=dt[1];
            document.getElementById("divautocomplete").style.display="none";
            
            
        }
        
        function tutupAu()
        {
            document.getElementById("divautocomplete").style.display="none";
            document.getElementById("divautocomplete_kab").style.display="none";
            document.getElementById("divautocomplete_kec").style.display="none";
            document.getElementById("divautocomplete_des").style.display="none";
        }
        
        function fset_kab(value)
        {
            var awal =  document.getElementById("cmbKab").value;
            var dt = value.split("|");
            //alert(dt[1]);
            if(awal!=dt[0])
            {
                document.getElementById('kecx').value="";
                document.getElementById('cmbKec').value="";
                document.getElementById('kecx').focus();
                
                document.getElementById('desx').value="";
                document.getElementById('cmbDesa').value="";
            }
            document.getElementById("cmbKab").value=dt[0];
            document.getElementById("kabx").value=dt[1];
            document.getElementById("divautocomplete_kab").style.display="none";
        }
        function fset_kec(value)
        {
            var awal =  document.getElementById("cmbKec").value;
            var dt = value.split("|");
            if(awal!=dt[0])
            {
                document.getElementById('desx').value="";
                document.getElementById('cmbDesa').value="";                
            }
            document.getElementById('desx').focus();
            document.getElementById("cmbKec").value=dt[0];
            document.getElementById("kecx").value=dt[1];
            document.getElementById("divautocomplete_kec").style.display="none";
        }
        function fset_des(value)
        {
            var dt = value.split("|");
            document.getElementById('AslMasuk').focus();
            document.getElementById("cmbDesa").value=dt[0];
            document.getElementById("desx").value=dt[1];
            document.getElementById("divautocomplete_des").style.display="none";
        }
        
        function cek_nik(val)
        {
            if(val.length != 16 && val!="")
            {
                alert('NIK kurang dari 16 digit');
            }
            else
            {
                document.getElementById('NmOrtu').focus();
            }
        }

        function cekMcuTidak(val){
            /**
             * ismul
             */
            if(val == 189){
                jQuery('#titleKelompokTindakanMcu').show();
                jQuery('#KelompokTindakanMcu').show();
            }else{
                jQuery('#titleKelompokTindakanMcu').hide();
                jQuery('#KelompokTindakanMcu').hide();
            }
        }

        function listPasienKlinikToRs(val){
            jQuery('#dataPasienPcrRs').empty();
            jQuery('#dataPasienPcrRs').html('<img src="../unit_pelayanan/gambar/785.gif" style="width:64px;height:64px">')
            let data = new Object();

            let dataPcr = val.split('||');
            
            for(let i = 0; i < dataPcr.length; i++){
                let keyval = dataPcr[i].split('|');
                data[keyval[0]] = keyval[1];
            }
            

            let namaDepan = data.nama.split(' ');
            jQuery.ajax({
                url: 'pasien_list_pcr_rs.php',
                method : 'post',
                data : {
                    nik : data.no_ktp,
                    nama : namaDepan[0],
                    idPasien : data.id,
                    idKunj : data.id_kunjungan,
                    idPel : data.id_pelayanan,
                },
                success:function(data){
                    jQuery('#dataPasienPcrRs').empty();
                    jQuery('#dataPasienPcrRs').html(data);
                }
            });
        }

        function pilihPasienPcr(val){
            let data = val.split('|');
            jQuery("#NoRm").val(data[0]);

            jQuery('#id_pasien_klinik').val(data[1]);
            jQuery('#id_kunjungan_klinik').val(data[2]);
            jQuery('#id_pelayanan_klinik').val(data[3]);

            listPasien({which : 13},'show','NoRm');
            jQuery('#closeBtnPcrModal').trigger('click');
            jQuery('#closeBtnDataPasienRs').trigger('click');
        }

        function pilihPasienPcrBelumTerdaftar(val){
            jQuery('#btnBatal').trigger('click');
            jQuery('#closeBtnPcrModal').trigger('click');
            let data = new Object();
            let dataPcr = val.split('||');
            
            for(let i = 0; i < dataPcr.length; i++){
                let keyval = dataPcr[i].split('|');
                data[keyval[0]] = keyval[1];
            }
            jQuery('#BtnNoRM').trigger('click');
            jQuery('#NoKTP').val(data.no_ktp);
            jQuery('#Nama').val(data.nama);
            jQuery('#Pendidikan option[value='+data.pendidikan_id+']').attr('selected','selected');
            jQuery('#Gender option[value='+data.sex+']').attr('selected','selected');
            jQuery('#TglLahir').val(indonesianDate(data.tgl_lahir));
            jQuery('#TglLahir').blur(gantiUmur());
            jQuery('#cmbAgama option[value='+data.agama+']').attr('selected','selected');
            jQuery('#telp').val(data.telp);
            jQuery('#darah option[value='+data.gol_darah+']').attr('selected','selected');
            jQuery('#Alamat').val(data.alamat);
            jQuery('#rt').val(data.rt);
            jQuery('#rw').val(data.rw);

            // isiCombo('cmbProp','',data.prop_id);
            // isiCombo('cmbKab',((data.prop_id !='')?data.prop_id:1),(data.kab_id!='')?data.kab_id:1182);
            // isiCombo('cmbKec',data.kab_id,data.kec_id);
            // isiCombo('cmbDesa',data.kec_id,data.desa_id);

            jQuery('#cmbProp').val(data.prop_id);
            jQuery('#cmbKab').val(data.kab_id);
            jQuery('#cmbKec').val(data.kec_id);
            jQuery('#cmbDesa').val(data.desa_id);

            jQuery('#prop').val(data.prop);
            jQuery('#kabx').val(data.kab);
            jQuery('#kecx').val(data.kec);
            jQuery('#desx').val(data.desa);

            // Status Pasien
            jQuery("#StatusPas").val(data.id_kso);
            jQuery("#NoAnggota").val(data.no_anggota);
            jQuery('#statusPenj').val(data.status_anggota);

            //Set data pasien pcr klinik
            jQuery('#id_pasien_klinik').val(data.id);
            jQuery('#id_pelayanan_klinik').val(data.id_pelayanan);
            jQuery('#id_kunjungan_klinik').val(data.id_kunjungan);
        }

        function indonesianDate(date){
            let tanggal = date.split('-');
            return tanggal[2] + '-' + tanggal[1] + '-' + tanggal[0];
        }

        jQuery('#btnBatal').click(function(){
             //Set data pasien pcr klinik
            jQuery('#id_pasien_klinik').val("");
            jQuery('#id_pelayanan_klinik').val("");
            jQuery('#id_kunjungan_klinik').val("");
        });
    </script>
</html>
<?php 
mysql_close($konek);
?>