<?
include("../sesi.php");
?>
<?php
//session_start();
$userId = $_SESSION['userId'];
//echo $_SESSION['userId'];
if(!isset($userId) || $userId == ''){
    header('location:../index.php');
}
include ("../koneksi/konek.php");
?>
<html>
    <head>
        <title>Form Koreksi</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <link href="../theme/rfnet.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="../theme/js/datetimepicker_css.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>
          <!--dibawah ini diperlukan untuk menampilkan popup-->
        <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        <script type="text/javascript" src="../theme/prototype.js"></script>
        <script type="text/javascript" src="../theme/effects.js"></script>
        <script type="text/javascript" src="../theme/popup.js"></script>
        <!--diatas ini diperlukan untuk menampilkan popup-->
        <style>
            .tepi{
                border:#000000 1px solid;             
            }
            .isi{
                border:#000000 1px solid;
                cursor:pointer;                
            }
            .header{
                border:#000000 1px solid;
                background-color:#99CAF2;
                font-size:10px;
            }
            .tindBok{
                height:25px;
                width:200px;
                font-size:10px;
            }
            .tglBox{
                cursor: pointer;
                text-align:center;
                font-size:10px;
            }           
        </style>
    </head>
    <body onLoad="document.getElementById('txtNoRm').focus();" onclick="">
         <?php
         include("../header1.php");
         $date_now=gmdate('d-m-Y',mktime(date('H')+7));
         ?>
         <div id="div_catatan" style="display:none;width:350px" class="popup">
            <span id="divSelesaiCatatan"></span>
            <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
            <fieldset><legend>Catatan verifikasi</legend>
                <form id="form1" name="form1">
                    <textarea style="display:none;" id="txtTempCatatan" name="txtTempCatatan" cols="50" rows="3"></textarea>
            <table width="300" height="100">
            <tr>                                
                <td>
                    
                    <label> <input type="radio" id="chkCatatan0" name="chkCatatan" value="0" checked="checked" onClick="document.getElementById('txtLainnya').readOnly=true;"/> Tidak Ada Catatan</label>
                </td>
            </tr>
            <tr>
                <td>
                    <label> <input type="radio" id="chkCatatan1" name="chkCatatan" value="1" onClick="document.getElementById('txtLainnya').readOnly=true;"/> Berkas Terbawa Pasien</label>
                </td>
                 </tr>
            <tr>
                <td>
                    <label> <input type="radio" id="chkCatatan2" name="chkCatatan" value="2" onClick="document.getElementById('txtLainnya').readOnly=true;"/> Konsul Antar poli</label>
                </td>
                 </tr>
            <tr>
                <td>
                    <label> <input type="radio" id="chkCatatan3" name="chkCatatan" value="3" onClick="document.getElementById('txtLainnya').readOnly=true;"/> Pasien Langsung Ke Penunjang</label>
                </td>
                 </tr>
            <tr>
                <td>
                    <label> <input type="radio" id="chkCatatan4" name="chkCatatan" value="4" onClick="document.getElementById('txtLainnya').readOnly=true;"/> Pengiriman Berkas Terlambat</label>
                </td>
            </tr>
            <tr>                                
                <td>
                    
                    <label> <input type="radio" id="chkCatatan5" name="chkCatatan" value="5" onClick="document.getElementById('txtLainnya').readOnly=true;"/> Pasien Tidak Jadi Berkunjung</label>
                </td>
            </tr>
             <tr>                                
                <td>
                    
                    <label>
                        <input type="radio" id="chkCatatan6" name="chkCatatan" value="6" onClick="if(this.checked){document.getElementById('txtLainnya').readOnly=false;}else{document.getElementById('txtLainnya').disabled=true;}"/> Lainnya
                    </label>
                    <input type="text" id="txtLainnya" name="txtLainnya" readonly="readonly" size="30"/>                    
                </td>
            </tr>
            <tr>
                <td align="left">
                    <input type="button" id="btnCatatan" name="btnCatatan" value="Simpan Catatan" onClick="simpanCatatan()"/>
                </td>
            </tr>
            </table>
                </form>
            </fieldset>
         </div>
         
         <div id="divTambahKamar" class="popup" style="width:500px;display:none;">
            <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />            
            <fieldset><legend>Tambah Kamar </legend>
            <table border=0>
                <tr>
                    <td align="right">Pilih Pelayanan</td>
                    <td>
                        <select id="cmbPelAs" class="txtinput" onChange="setKamar(this.value)"></select>
                    </td>
                </tr>                        
                        <tr>
                            <td width="162" align="right">Kamar :</td>
                            <td >
                                <select name="cmbKamar" id="cmbKamar" tabindex="26" class="txtinput" onChange=""></select>
                                <span id="spanTarifPindah" ></span>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">Bayar :</td>
                            <td><input id="txtBayarKmr"  class="txtinput"/></td>
                        </tr>
                        <tr>
                            <td align="right">Bayar Pasien :</td>
                            <td><input id="txtBayarPasienKmr"  class="txtinput"/></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                <input type="button" id="btnTambahKmr" value="SIMPAN" class="popup_closebox" onClick="tambahKamar();"/>
                                <input type="button" id="btnBatalKmr" value="BATAL" class="popup_closebox" />
                            </td>
                        </tr>
            </table>
            </fieldset>
        </div>
         
         <div id="divCetak" class="popup" style="width:500px;display:none;">
            <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />            
            <fieldset><legend>Cetak Rincian </legend>
            <table border=0>
                <tr>
                    <td align="right">Pilih Pelayanan</td>
                    <td>
                        <select id="cmbPelAsCetak" class="txtinput"></select>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <input type="button" id="btnCetakRincian" value="CETAK" class="popup_closebox" onClick="cetakRincian();"/>                        
                    </td>
                </tr>
            </table>
            </fieldset>
         </div>
         
         <script type="text/JavaScript">
            var arrRange=depRange=[];
        </script>
        <iframe height="193" width="168" name="gToday:normal:agenda.js"
                id="gToday:normal:agenda.js"
                src="../theme/popcjs.php" scrolling="no"
                frameborder="1"
                style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
        </iframe>
         <table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2" align="center">
                <tr>
                    <td height="30">Form Koreksi</td>
                </tr>
            </table>
            <table width="1000" border="1" cellspacing="0" cellpadding="0" class="txtinput" align="center" height="450">
                <tr>
                    <td valign="top" height="50" style="background-color:#99CAF2;">
                        <fieldset>
                            <legend>Data Pasien</legend>
                        <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size:12px; font-family:verdana;">
                            <tr>
                            <td>No RM</td><td> : </td><td><input type="text" tabindex="1" size="9" id="txtNoRm" name="txtNoRm" class="txtinput" onKeyUp="listPasien(event,'show',this.value)"/></td>
                            <td>Jenis Perawatan</td><td>:</td><td><select id="cmbJnsRwt" name="cmbJnsRwt" disabled="disabled" onChange="setPasien(document.getElementById('txtVal').value);">
                                <option value="0">Rawat Jalan</option>
                                <option value="1">Rawat Inap</option>
                                <option value="2">Darurat</option>
                            </select></td>
                            <td>Nama</td><td> : </td><td><input type="text" id="txtNama" name="txtNama" size="30" readonly="readonly" class="txtinput"/></td>
                            <td>TTL</td><td> : </td><td><input type="text" id="txtTglLhr" name="txtTglLhr" readonly="readonly" class="txtinput"/></td>
                            </tr>
                            <tr>
                                <td colspan="6" rowspan="2" align="left">
                                    Tanggal Kunjungan:
                                    <input tabindex="2" id="txtTglAwal" name="txtTglAwal" size="10" class="txtcenter" value="<?php echo $date_now;?>" onFocus="this.select();" onBlur="if(this.value==''){this.value='<?php echo $date_now;?>'}" onKeyUp="if(event.which==13){ cariLagi(); document.getElementById('txtNoRm').select();} else{setTgl(event,this);}"/>
                                    <img alt="tglAwal" src="http://<?php echo $_SERVER['HTTP_HOST'];?>/simrs-tangerang/billing/icon/archive1.gif" onClick="gfPop.fPopCalendar(document.getElementById('txtTglAwal'),depRange,cariLagi);" style="cursor: pointer"/>
                                    &nbsp;sampai&nbsp;                                    
                                    <input tabindex="3" id="txtTglAkhir" name="txtTglAkhir"  size="10" class="txtcenter" value="<?php echo $date_now;?>" onFocus="this.select();" onBlur="if(this.value==''){this.value='<?php echo $date_now;?>'}" onKeyUp="if(event.which==13){ cariLagi();  document.getElementById('txtNoRm').select();} else{setTgl(event,this);}"/>
                                    <img alt="tglAwal" src="http://<?php echo $_SERVER['HTTP_HOST'];?>/simrs-tangerang/billing/icon/archive1.gif" onClick="gfPop.fPopCalendar(document.getElementById('txtTglAkhir'),depRange,cariLagi);" style="cursor: pointer"/>
                                    <input type="hidden" id="txtIdPasien"/>
                                    <textarea id="tampung" style="display:none;" ></textarea>
                                </td>
                                <td rowspan="2">Alamat</td><td rowspan="2"> : </td><td rowspan="2"><textarea id="txaAlamat" name="txaAlamat" cols="30" rows="2" readonly="readonly" class="txtinput"></textarea></td>
                                <td>Umur</td><td> : </td><td><input type="text" id="txtUmur" name="txtUmur" size="5" readonly="readonly" class="txtinput"/></td>
                            </tr>
                            <tr>                                
                                <td>L/P</td><td> : </td><td><input type="text" id="txtSex" name="txtSex" size="5" readonly="readonly" class="txtinput"/></td>
                            </tr>
                        </table>
                        <div id="div_pasien" align="center" class="div_pasien" style="position:absolute;display:none"></div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                         <?php
			    $sVer="SELECT p.id ,g.nama AS grup FROM b_ms_group_petugas gp
				    INNER JOIN b_ms_group g ON g.id=gp.ms_group_id
				    INNER JOIN b_ms_pegawai p ON p.id=gp.ms_pegawai_id
				    WHERE (g.nama LIKE '%VERIFIKATOR%' OR g.nama LIKE '%CIO%' OR g.ket LIKE '%VERIFIKATOR%')
                     OR g.nama LIKE 'IT TEAM' AND p.id='$userId'";
			    $rsVer=mysql_query($sVer);
			    $hidden="none";
			    if(mysql_num_rows($rsVer)>0){
				$rwVer=mysql_fetch_array($rsVer);				
				$vid=$rwVer['id'];
				$hidden="block";
			    }
			    ?>        
                        <table width="100%" border="0">
                            <tr>
                                <td width="20%">
                                <button type="button" id="btnVerifikasi" name="btnVerifikasi" style="display:<?php echo $hidden;?>; cursor:pointer;" onClick="if(confirm('Anda yakin data verifikasi sudah benar?')){ tombolVerifikasi(); } else { return false; }" disabled="disabled">
                        VERIFIKASI (semua)
                        </button>
                                </td>
                                <td width="2%">
                        <input type="hidden" id="txtVal" name="txtVal"/>
                        <input type="hidden" id="txtKunjId" name="txtKunjId"/>
                        <input type="hidden" id="txtPelId" name="txtPelId"/>
                       &nbsp;
                                </td>
                                <td width="30%" align="left">                                   
                                   Verifikator : &nbsp; <span id="spVer"></span>
                                </td>
                                <td width="40%" align="center">
                                    <button type="button" id="btnCttVer" name="btnCttVer" value="show" onClick="catatan();" disabled="disabled">
                                        CATATAN VERIFIKASI
                                    </button>
                                    <button type="button" id="btnCtkRet" name="btnCtkRet" value="show" onClick="cetakRet();" disabled="disabled">CETAK RETRIBUSI</button>
                                    <button type="button" id="btnCtkRnc" name="btnCtkRnc" value="CETAK RINCIAN TINDAKAN" onClick="cetak();">
                                        CETAK RINCIAN TINDAKAN
                                    </button>                                        
                                </td>                                
                            </tr>
                            
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top">                        
                        <fieldset>
                            <legend>Data Kunjungan
                            <input type="button" size="3" id="btnShowKunjDown" value="&or;" style="display:inline;cursor:pointer;" onClick="document.getElementById('divKunjungan').style.height='150px';this.style.display='none';document.getElementById('btnShowKunjUp').style.display='inline';"/>
                            <input type="button" size="3" id="btnShowKunjUp" value="&and;" style="display:none;cursor:pointer;" onClick="document.getElementById('divKunjungan').style.height='0px';this.style.display='none';document.getElementById('btnShowKunjDown').style.display='inline';"/>
                            </legend>                            
                            <div id="divKunjungan" style="overflow:auto;height:0px;">
                        
                            </div>
                        </fieldset>                        
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <fieldset>
                            <legend>Data Pelayanan
                            <input type="button" size="3" id="btnShowPelDown" value="&or;" style="display:inline;cursor:pointer;" onClick="document.getElementById('divPelayanan').style.height='100px';document.getElementById('divTablePelayanan').style.height='40px';this.style.display='none';document.getElementById('btnShowPelUp').style.display='inline';"/>
                            <input type="button" size="3" id="btnShowPelUp" value="&and;" style="display:none;cursor:pointer;" onClick="document.getElementById('divPelayanan').style.height='0px';document.getElementById('divTablePelayanan').style.height='0px';this.style.display='none';document.getElementById('btnShowPelDown').style.display='inline';"/>
                            </legend>
                            <div id="divTablePelayanan"  style="overflow:auto;height:0px;">
                                <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size:12px; font-family:verdana;" class="tepi">
                                    <tr>
                                        <td align="center" width="2%" class="header">No</td>
                                        <td align="center" width="5%" class="header">Jenis Layanan</td>
                                        <td align="center" width="5%" class="header">Tempat Layanan</td>
                                        <td align="center" width="5%" class="header">Tempat Layanan Asal</td>
                                        <td align="center" width="17%" class="header">Penjamin (KSO)</td>
                                        <td align="center" width="10%" class="header">Kelas</td>
                                        <td align="center" width="5%" class="header">Tanggal Datang</td>
                                        <td align="center" width="5%" class="header">Tanggal Pulang</td>
                                        <td align="center" width="10%" class="header">Status Dilayani</td>
                                        <td align="center" width="5%" class="header">Hapus</td>
                                    </tr>    
                                </table>
                            </div>
                            <div id="divPelayanan" style="overflow:auto;height:0px;">
                        
                            </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <fieldset>
                            <legend>Data Tindakan&nbsp;
                            <span id="divSelesai" style="color:#0000ff;background-color:#ffff00;"></span></legend>
                            <div id="divTableTindakan">
                                <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size:12px; font-family:verdana;" class="tepi">
                                    <tr>
                                        <td align="center" width="3%" class="header">No</td>
                                        <td align="center" width="7%" class="header">Jenis Layanan</td>
                                        <td align="center" width="8%" class="header">Tempat Layanan</td>
                                        <td align="center" width="7%" class="header">Tanggal</td>
                                        <td align="center" width="22%" class="header">Tindakan</td>
                                        <td align="center" width="8%" class="header">Kelas</td>
                                        <td align="center" width="6%" class="header">Jumlah</td>
                                        <td align="center" width="7%" class="header">Tarif RS</td>
                                        <td align="center" width="7%" class="header">Tarif KSO</td>
                                        <td align="center" width="7%" class="header">Iur Bayar</td>                                        
                                        <td align="center" width="7%" class="header">Bayar Pasien</td>
                                        <td align="center" width="8%" class="header">Verifikasi</td>                                        
                                    </tr>    
                                </table>
                            </div>
                            <div id="divTindakan" style="overflow:auto;height:200px;">
                        
                            </div>
                        </fieldset>
                    </td>
                </tr>
                <tr id="trTinKamar" style="visibility:collapse;">
                    <td valign="top">
                        <fieldset>
                            <legend>Data Tindakan Kamar&nbsp;
                            <span id="divSelesaiKamar" style="color:#0000ff;background-color:#ffff00;width:100px;"></span>                            
                            </legend>
                            <img style="height:20px; width:20px; position:relative; left:98%; cursor:pointer;" title="tambah tindakan kamar" src="../icon/add.gif" onClick="<?php /*alert('masih dalam perbaikan!');*/?>popupTambahKamar()"/>
                            <div id="divTindakankamar">
                                 <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size:12px; font-family:verdana;" class="tepi">
                                    <tr>
                                        <td align="center" class="header" width="2%">No</td>
                                        <td align="center" class="header" width="7%">Jenis Layanan</td>
                                        <td align="center" class="header" width="10%">Tempat Layanan</td>
                                        <td align="center" class="header" width="16%">Kamar</td>
                                        <td align="center" class="header" width="6%">Kelas</td>
                                        <td align="center" class="header" width="12%">Tgl Masuk</td>
                                        <td align="center" class="header" width="12%">Tgl Keluar</td>
                                        <td align="center" class="header" width="7%">Status Out</td>
                                        <td align="center" class="header" width="7%">Tarif RS</td>
                                        <td align="center" class="header" width="7%">Beban KSO</td>
                                        <td align="center" class="header" width="7%">Beban Pasien</td>
                                        <td align="center" class="header" width="7%">Verifikasi</td>
                                    </tr>
                                 </table>
                            </div>
                            <div id="divTindakanKamar">
                        
                            </div>
                        </fieldset>
                    </td>
                </tr>
            </table>
            
            <script>
               
                function isiCombo(id,val,defaultId,targetId,evloaded){
                    if(targetId=='' || targetId==undefined){
                        targetId=id;
                    }
                    if(document.getElementById(targetId)==undefined){
                        alert('Elemen target dengan id: \''+targetId+'\' tidak ditemukan!');
                    }else{
                        Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
                    }
                }
                
                
                function isiPindahKamar(){
                    isiCombo('cmbKamar',document.getElementById('cmbTL').value+','+document.getElementById('cmbKelas').value,'','cmbKamar',setTarifPindah);
                }
                function setTarifPindah(){
                    document.getElementById('spanTarifPindah').innerHTML = document.getElementById('cmbKamar').options[document.getElementById('cmbKamar').options.selectedIndex].lang;
                    //document.getElementById("txtBayarKmr").value=document.getElementById('cmbKamar').options[document.getElementById('cmbKamar').options.selectedIndex].lang;
                    //document.getElementById("txtBayarPasienKmr").value=document.getElementById('cmbKamar').options[document.getElementById('cmbKamar').options.selectedIndex].lang;
                }
                var RowIdx;
                var fKeyEnt;
                var cari=0;
                var keyword='';
                function listPasien(feel,how,stuff){
                    var tglAwal = document.getElementById('txtTglAwal').value;
                    var tglAkhir = document.getElementById('txtTglAkhir').value;
                    var jenisRawat = document.getElementById('cmbJnsRwt').value;
                    if(how=='show'){
                        //alert(feel.which);
                        if((feel.which==13 && document.getElementById('div_pasien').style.display!='block') || feel=='tglUbah'){
                            keyword=stuff;
                            document.getElementById('div_pasien').style.display='block';
                            Request('pasien_list.php?act=cari&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir+'&norm='+stuff+'&jenisRawat='+jenisRawat,'div_pasien','','GET');
                            RowIdx=0;
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
                    document.getElementById('cmbJnsRwt').disabled=false;
                    document.getElementById("txtVal").value=val;
                    var jnsRwt = document.getElementById('cmbJnsRwt').value; 
                    dataPasien=val.split("|");
                    var p ="txtIdPasien*-*"+dataPasien[0]+"*|*txtNama*-*"+dataPasien[1]+"*|*txtTglLhr*-*"+dataPasien[3]+"*|*txtUmur*-*"+dataPasien[5]+"*|*txtSex*-*"+dataPasien[6]+"*|*txtKunjId*-*"+dataPasien[8]+"*|*txtPelId*-*"+dataPasien[9];
                        fSetValue(window,p);
                        document.getElementById('txaAlamat').innerHTML=dataPasien[2];                    
                    document.getElementById('div_pasien').style.display='none';
                    document.getElementById("btnVerifikasi").disabled=false;
                    cekVerifikasi(dataPasien[8],jnsRwt);                    
                    document.getElementById("btnCttVer").disabled=false;
					document.getElementById("btnCtkRet").disabled=false;
                    //document.getElementById("txtCatatan").value=dataPasien[11];                    
                    
                    Request('koreksi_utils.php?idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&tabel=kunjungan'+'&jnsRwt='+jnsRwt,'divKunjungan','','GET',afterKunj,'ok');
                    Request('koreksi_utils.php?idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&tabel=pelayanan'+'&jnsRwt='+jnsRwt,'divPelayanan','','GET',afterPel,'ok');
                    isiPelAs(dataPasien[8]);
                    Request('koreksi_utils.php?idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&tabel=tindakan'+'&jnsRwt='+jnsRwt,'divTindakan','','GET',getCatatan,'ok');
                    if(jnsRwt=='1'){
                        Request('koreksi_utils.php?idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&tabel=tindakan_kamar','divTindakanKamar','','GET');
                        document.getElementById('trTinKamar').style.visibility="visible";
                    }
                    else{
                        document.getElementById('trTinKamar').style.visibility="collapse";
                    }
                }
                
                function afterKunj(){                    
                    var unit=document.getElementById('txtKUnitId_'+dataPasien[8]).value;
                    var inap=document.getElementById('txtKInap_'+dataPasien[8]).value;
                    var jenis=document.getElementById('txtKJenisId_'+dataPasien[8]).value;
                    var kelas=document.getElementById('txtKKelasId_'+dataPasien[8]).value;
                    var kelasKSO=document.getElementById('txtKKelasKSO_'+dataPasien[8]).value;
                    isiCombo('cmbKelasPasien',unit+','+jenis+','+inap,kelas,'cmbKKelas_'+dataPasien[8]);
                    isiCombo('HakKelas','',kelasKSO,'cmbKKelasKSO_'+dataPasien[8]);                    
                }
                
                function afterPel(){                    
                    var jml=document.getElementById('txtPjml').value;
                    for(var i=1;i<jml;i++){                        
                        var id=document.getElementById('txtPId_'+i).value;
                        var unit=document.getElementById('txtPUnitId_'+id).value;
                        var inap=document.getElementById('txtPInap_'+id).value;
                        var jenis=document.getElementById('txtPJenisId_'+id).value;
                        var kelas=document.getElementById('txtPKelasId_'+id).value;
                        //alert(unit+','+inap+','+jenis);
                        isiCombo('cmbKelasPasien',unit+','+jenis+','+inap,kelas,'cmbPKelas_'+id);
                    }
                    
                }
                
                function setKamar(valuePel){
                    var dariPel=valuePel.split('|');
                    isiCombo('cmbKamar',dariPel[1]+','+dariPel[4],'','cmbKamar',setTarifPindah);
                }
                
                function isiPelAs(kunjId){
                    Request('verifikasi_utils.php?kunjId='+kunjId+'&act=setPelAs&jnsRwt='+document.getElementById('cmbJnsRwt').value,'cmbPelAs','','GET');
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
                    
                    if(ev.which!='8' || ev.which!='46'){
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
                                //gantiUmur();
                        }
                        else if(tmp.length > 10){
                                par.value = tmp.substr(0,(tmp.length-1));
                        }
                    }
                }
                
                function cariLagi(){
                    var normBox = document.getElementById('txtNoRm').value;
                    listPasien('tglUbah','show',normBox);
                }
                
                function tutupDivPasien(){
                    document.getElementById('div_pasien').style.display="none";
                }
                
                function aktif(obj){
                    var idDepan = obj.id.split("_");
					var pTglSkrg = "<?php echo $pTglSkrg; ?>";
					var bDate = "<?php echo $backdate; ?>";
					//alert(idDepan[0]+' - '+idDepan[1]);
					//alert(document.getElementById('txtTglIn_'+idDepan[1]).value);
					if(idDepan[0]=='txtTind' || idDepan[0]=='txtJml' || idDepan[0]=='txtBiayaKso' || idDepan[0]=='txtBiayaPasien'){
						if ((pTglSkrg>TglYmd(document.getElementById('txtTgl_'+idDepan[1]).value)) && (TglYmd(document.getElementById('txtTgl_'+idDepan[1]).value)>="2011-04-01") && (bDate=="0")){
							alert("Data Sudah Lebih dari 24 Jam, Jadi Tdk Boleh Diubah !");
							return false;
						}
					}
					if(idDepan[0]=='txtBebanKso' || idDepan[0]=='txtBebanPasien'){
						if ((pTglSkrg>TglYmd(document.getElementById('txtTglIn_'+idDepan[1]).value)) && (TglYmd(document.getElementById('txtTglIn_'+idDepan[1]).value)>="2011-04-01") && (bDate=="0")){
							alert("Data Sudah Lebih dari 24 Jam, Jadi Tdk Boleh Diubah !");
							return false;
						}
					}
                    obj.title=obj.value;
                    obj.readOnly=false;
                    obj.style.backgroundColor='#ffff00';
                    obj.style.color='#ff0000';
                    obj.select();                    
                    editable=true;
                }
                
                function pasif(obj){
                     var idDepan = obj.id.split("_");                    
                    
                        obj.value=obj.title;
                        obj.readOnly=true;
                        obj.style.backgroundColor='#ffffff';
                        obj.style.color='#000000';
                    
                    editable=false;
                    //document.getElementById('divtindakan').style.display='none';
                }
                var editable=false;
                function aksi(ev,obj){
                    var idDepan = obj.id.split("_");
                    if(idDepan[0]=='txtTind' && editable==true){
                        suggest1(ev,obj);
                        //alert('tes');
                    }
                    else if(ev.which=='13'){
                        if(editable==false){
                            aktif(obj);                            
                        }else{                                                          
                            obj.style.backgroundColor='#00ff00';                        
                            obj.style.color='#0000ff';
                            obj.title=obj.value;
                            obj.readOnly=true;
                            editable=false;
                            if(idDepan[0]=='txtBebanKso' || idDepan[0]=='txtBebanPasien'){
                                simpanKamar(idDepan[1]);
                            }else{
                                simpan(idDepan[1]);
                            }
                        }
                        
                    }                    
                    
                
                }
                
                function simpan(id){
                    var jnsRwt = document.getElementById('cmbJnsRwt').value; 
                    var cIdUser = "<?php echo $userId; ?>";
                    var tgl = document.getElementById('txtTgl_'+id).value;
                    var idTind = document.getElementById('txtIdTind_'+id).value;
                    var jml = document.getElementById('txtJml_'+id).value;
                    var biaya = document.getElementById('txtBiaya_'+id).value;
                    var biayaKso = document.getElementById('txtBiayaKso_'+id).value;
                    var biayaPasien = document.getElementById('txtBiayaPasien_'+id).value;
                    var bayarPasien = document.getElementById('txtBayarPasien_'+id).value;
                    var statusVer = document.getElementById('chkVer_'+id).value;
                    //alert('koreksi_utils.php?id='+id+'&tgl='+tgl+'&idTind='+idTind+'&jml='+jml+'&biaya='+biaya+'&biayaKso='+biayaKso+'&biayaPasien='+biayaPasien+'&bayarPasien='+bayarPasien+'&statusVer='+statusVer+'&act=save&idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&tabel=tindakan'+'&jnsRwt='+jnsRwt+'&IdUser='+cIdUser);
                    //Request('koreksi_utils.php?id='+id+'&tgl='+tgl+'&idTind='+idTind+'&jml='+jml+'&biaya='+biaya+'&biayaKso='+biayaKso+'&biayaPasien='+biayaPasien+'&statusVer='+statusVer+'&act=save','divSelesai','','GET',selesai,'ok');
                
                    Request('koreksi_utils.php?id='+id+'&tgl='+tgl+'&idTind='+idTind+'&jml='+jml+'&biaya='+biaya+'&biayaKso='+biayaKso+'&biayaPasien='+biayaPasien+'&bayarPasien='+bayarPasien+'&statusVer='+statusVer+'&act=save&idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&tabel=tindakan'+'&jnsRwt='+jnsRwt+'&IdUser='+cIdUser,'divTindakan','','GET',getCatatan,'ok');
                    if(jnsRwt=='1'){
                        Request('koreksi_utils.php?idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&tabel=tindakan_kamar','divTindakanKamar','','GET');
                        document.getElementById('trTinKamar').style.visibility="visible";
                    }
                    else{
                        document.getElementById('trTinKamar').style.visibility="collapse";
                    }
                    
                }
                
                function warnaiBaris(ArrayIdTd,warna){
                    for(var i=0;i<ArrayIdTd.length;i++){
                        document.getElementById(ArrayIdTd[i]).style.backgroundColor=warna;
                    }
                }
                
                function hapus(act,trId){
                    var jnsRwt = document.getElementById('cmbJnsRwt').value;
					var cIdUser = "<?php echo $userId; ?>";
                    var idTd;
					var pTglSkrg = "<?php echo $pTglSkrg; ?>";
					var bDate = "<?php echo $backdate; ?>";
					//alert(idDepan[0]);
                    if(act=='tindakan'){
						if ((pTglSkrg>TglYmd(document.getElementById('txtTgl_'+trId).value)) && (bDate=="0")){
							alert("Data Sudah Lebih dari 24 Jam, Jadi Tdk Boleh DiHapus !");
							return false;
						}
                    	idTd= new Array ('no_'+trId,'jenis_'+trId,'unit_'+trId,'tgl_'+trId,'tind_'+trId,'kelas_'+trId,'jml_'+trId,'biaya_'+trId,'biayaKso_'+trId,'biayaPasien_'+trId);
                    }else if(act=='tindakan_kamar'){
						if ((pTglSkrg>TglYmd(document.getElementById('txtTglIn_'+trId).value)) && (bDate=="0")){
							alert("Data Sudah Lebih dari 24 Jam, Jadi Tdk Boleh DiHapus !");
							return false;
						}
                    	idTd= new Array ('no_'+trId,'jenis_'+trId,'unit_'+trId,'kamar_'+trId,'kelas_'+trId,'tglIn_'+trId,'tglOut_'+trId,'statusOut_'+trId,'tarip_'+trId,'bebanKso_'+trId,'bebanPasien_'+trId);
                    }
                    warnaiBaris(idTd,"#FF0000");
                    if(confirm('Anda yakin ingin menghapus baris ini?')){
                        if(act=='tindakan'){
                            Request('koreksi_utils.php?id='+trId+'&act=delete&idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&jnsRwt='+jnsRwt+'&tabel='+act+'&IdUser='+cIdUser,'divTindakan','','GET');
                        }else if(act=='tindakan_kamar'){
                            Request('koreksi_utils.php?id='+trId+'&act=delete_kamar&idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&tabel='+act+'&IdUser='+cIdUser,'divTindakanKamar','','GET');                            
                        }
                    }else{
                        warnaiBaris(idTd,"");
                    }
                }
                
                function selesai(){
                    var kunjId=document.getElementById("txtKunjId").value;
                    var jnsRwt=document.getElementById("cmbJnsRwt").value;
                    cekVerifikasi(kunjId,jnsRwt);
                    setTimeout("document.getElementById('divSelesai').innerHTML=''",'1000');
                }
                
                function selesaiCatatan(){
                    setTimeout("document.getElementById('divSelesaiCatatan').innerHTML=''",'1000');
                }
                
                //Tindakan
                var RowIdx1;
                var fKeyEnt1;
                function suggest1(e,par){
                    var idDepan = par.id.split("_");
                    var getIdPasien=document.getElementById('txtIdPasien').value;
                    var getIdKelas=document.getElementById('txtIdKelas_'+idDepan[1]).value;
                    var getIdUnit=document.getElementById('txtUnitId_'+idDepan[1]).value;
                    var getIdJns=document.getElementById('txtJnsUnitId_'+idDepan[1]).value;
                    var getIdPel=document.getElementById('txtPelId_'+idDepan[1]).value;                    
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
                                    fSetTindakan(idDepan[1],document.getElementById('lstTind'+RowIdx1).lang);
                                }
                                else{
                                    fKeyEnt1=false;
                                }
                            }
                            editable=false;
                            par.style.backgroundColor='#ffffff';                        
                            par.style.color='#0000ff';
                            par.title=par.value;
                            par.readOnly=true;                            
                        }else if (key!=27 && key!=37 && key!=39){
                            RowIdx1=0;
                            fKeyEnt1=false;
                            var all=0;
                            if(key==123){
                                all=1;
                            }
                            //alert("tindakanlist.php?aKeyword="+keywords+"&pasienId="+getIdPasien+"&kelasId="+getIdKelas+"&unitId="+((document.getElementById('chkTind').checked==true)?document.getElementById('tmpLay').value:unitId));
                            Request("tindakanlist.php?aKeyword="+keywords+"&id="+idDepan[1]+"&pasienId="+getIdPasien+"&kelasId="+getIdKelas+"&unitId="+getIdUnit+
                                "&jenisLay="+getIdJns+"&pelayananId="+getIdPel+"&allKelas="+all, 'divtindakan', '', 'GET');
                            if (document.getElementById('divtindakan').style.display=='none')
                                fSetPosisi(document.getElementById('divtindakan'),par);
                            document.getElementById('divtindakan').style.display='block';
                        }else if(key==27){
                            document.getElementById('divtindakan').style.display='none';
                        }
                    }
                }
                function fSetTindakan(id,par){                    
                    var cdata = par.split("*|*");
                    document.getElementById("txtIdTind_"+id).value=cdata[0];
                    document.getElementById("txtTind_"+id).value=cdata[1];
                    document.getElementById("txtBiaya_"+id).value=cdata[3];
                    //document.getElementById("txtBiayaKso_"+id).value=cdata[3];
                    //document.getElementById("txtBiayaPasien_"+id).value=cdata[3];
                    document.getElementById("txtKelas_"+id).value=cdata[5];
                    document.getElementById("txtIdKelas_"+id).value=cdata[7];
                    document.getElementById('divtindakan').style.display='none';                    
                    simpan(id);
                }
                
                function cekData(){                    
                    if(document.getElementById('txtVal').value!='' || document.getElementById('txtVal').value!=''){
                        document.getElementById("btnVerifikasi").disabled=false;
                    }
                    else{
                        document.getElementById("btnVerifikasi").disabled=true;
                    }
                }
             
                function cekVerifikasi(kunjId,jnsRwt){
                    var jnsVer='';
                    if(jnsRwt=='0'){
                        jnsVer='RAWAT JALAN';
                    }
                    else if(jnsRwt=='1'){
                        jnsVer='RAWAT INAP';
                    }
                    else if(jnsRwt=='2'){
                        jnsVer='IGD';
                    }
                    //alert("verifikasi_utils.php?act=cekVerifikasi&kunjId="+kunjId+"&jnsRwt="+jnsRwt);
                    Request("verifikasi_utils.php?act=cekVerifikasi&kunjId="+kunjId+"&jnsRwt="+jnsRwt,'btnVerifikasi','','GET',setTombol);                                          
                    //alert("verifikasi_utils.php?act=cekVerifikator&kunjId="+kunjId+"&jnsRwt="+jnsRwt);
                    Request("verifikasi_utils.php?act=cekVerifikator&kunjId="+kunjId+"&jnsRwt="+jnsRwt,'spVer','','GET');
                }
                
                function setTombol(){
                    var isiTombol = document.getElementById("btnVerifikasi").innerHTML;
                    if(isiTombol.search("belum")!=-1){
                        document.getElementById('btnVerifikasi').style.backgroundColor="#ff0000";
                        document.getElementById('btnVerifikasi').style.color="#ffff00";
                        document.getElementById('btnVerifikasi').style.textDecoration="blink";
                        document.getElementById('btnVerifikasi').disabled=false;
                    }
                    else if(isiTombol.search("sudah")!=-1){
                        document.getElementById('btnVerifikasi').style.backgroundColor="#005500";
                        document.getElementById('btnVerifikasi').style.color="#ffff00";
                        document.getElementById('btnVerifikasi').style.textDecoration="blink";
                        document.getElementById('btnVerifikasi').disabled=false;
                    }
                    else{
                        document.getElementById('btnVerifikasi').style.backgroundColor="#000000";
                        document.getElementById('btnVerifikasi').style.color="#ffff00";
                        document.getElementById('btnVerifikasi').style.textDecoration="blink";
                        document.getElementById('btnVerifikasi').disabled=true;
                    }                  
                }
                
                function tombolVerifikasi(){
                    var kunjId=document.getElementById("txtKunjId").value;
                    var jnsRwt=document.getElementById("cmbJnsRwt").value;
                    var jmlT=document.getElementById("txtJmlT").value;
                                      
                    for(var i=0;i<parseInt(jmlT);i++){                    
                        var tindId = document.getElementById('tblTindakan').getElementsByTagName("tr")[i].id;                        
                        verifikasi(tindId,'1','');
                        document.getElementById("chkVer_"+tindId).checked=true;
                    }
                    
                    if(jnsRwt==1){
                        var jmlTK=document.getElementById("txtJmlTK").value;  
                        if(jmlTK!=''){
                            for(var i=0;i<parseInt(jmlTK);i++){ 
                                var tindId = document.getElementById('tblTindakanKamar').getElementsByTagName("tr")[i].id;                                                        
                                verifikasi(tindId,'1','yes');
                                document.getElementById("chkVerKamar_"+tindId).checked=true;
                            }
                        }
                    }
                    cekVerifikasi(kunjId,jnsRwt);
                }
                
                function verifikasi(tinId,val,kamar){
                    //alert("verifikasi_utils.php?act=verifikasi&tindakan_id="+tinId+"&value="+val+"&kamar="+kamar+"&verifikator=<?php echo $userId;?>");
                    Request("verifikasi_utils.php?act=verifikasi&tindakan_id="+tinId+"&value="+val+"&kamar="+kamar+"&verifikator=<?php echo $userId;?>",'divSelesai','','GET',selesai,'ok');                   
                    
                }
                
                                
                function simpanKamar(id){
                    var jnsRwt = document.getElementById('cmbJnsRwt').value; 
                    var cIdUser = "<?php echo $userId; ?>";
                    var unit = document.getElementById('txtUnit_'+id).value;
                    var kamar = document.getElementById('cmbKamar_'+id).value;
                    var kelas = document.getElementById('cmbKelas_'+id).value;
                    var tglIn = document.getElementById('txtTglIn_'+id).value;
                    var tglOut = document.getElementById('txtTglOut_'+id).value;
                    var statusOut = document.getElementById('cmbStatusOut_'+id).value; 
                    var bebanKso = document.getElementById('txtBebanKso_'+id).value;
                    var bebanPasien = document.getElementById('txtBebanPasien_'+id).value;
                    
                    //alert('koreksi_utils.php?id='+id+'&tglIn='+tglIn+'&tglOut='+tglOut+'&bebanKso='+bebanKso+'&bebanPasien='+bebanPasien+'&tabel=save_kamar');
                    //Request('koreksi_utils.php?id='+id+'&kelas='+kelas+'&tglIn='+tglIn+'&tglOut='+tglOut+'&statusOut='+statusOut+'&bebanKso='+bebanKso+'&bebanPasien='+bebanPasien+'&tabel=save_kamar','divSelesai','','GET',selesai,'ok');
                    
                    Request('koreksi_utils.php?idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&tabel=tindakan'+'&jnsRwt='+jnsRwt,'divTindakan','','GET',getCatatan,'ok');
                    if(jnsRwt=='1'){
                        //alert('koreksi_utils.php?id='+id+'&unit='+unit+'&kamar='+kamar+'&kelas='+kelas+'&tglIn='+tglIn+'&tglOut='+tglOut+'&statusOut='+statusOut+'&bebanKso='+bebanKso+'&bebanPasien='+bebanPasien+'&act=save_kamar&idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&tabel=tindakan_kamar');
                        Request('koreksi_utils.php?id='+id+'&unit='+unit+'&kamar='+kamar+'&kelas='+kelas+'&tglIn='+tglIn+'&tglOut='+tglOut+'&statusOut='+statusOut+'&bebanKso='+bebanKso+'&bebanPasien='+bebanPasien+'&act=save_kamar&idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&tabel=tindakan_kamar'+'&IdUser='+cIdUser,'divTindakanKamar','','GET','','ok');
                        document.getElementById('trTinKamar').style.visibility="visible";
                    }
                    else{
                        document.getElementById('trTinKamar').style.visibility="collapse";
                    }
                }
                
                function simpanKelasKamar(id,val){
                    isiCombo('cmbKamar_'+id,document.getElementById('unit_'+id).value+','+val,'','cmbKamar_'+id,simpanKamar(id));
                    alert('Silahkan memilih kamar sesuai kelasnya!');
                    simpanKamar(id);                    
                }
                
                 function catatan(){
                    new Popup('div_catatan',null,{modal:true,position:'center',duration:0.5});
                    document.getElementById('div_catatan').popup.show();
                }
                function getCatatan(){                    
                    var idKunj=document.getElementById('txtKunjId').value;
                    var jnsRwt=document.getElementById('cmbJnsRwt').value;
                    //document.getElementById('txtTempCatatan').value='';        
                    Request('koreksi_utils.php?idKunj='+idKunj+'&tabel=catatan&jnsRwt='+jnsRwt,'txtTempCatatan','','GET',setCatatan,'ok');
                }
                
                function setCatatan(){
                    var val = document.getElementById('txtTempCatatan').value;
                    //alert(val);
                    
                    //alert(document.getElementById('txtLainnya').value);
                    var pilih=0;                    
                    if(val==''){
                        pilih=0;
                    }
                    else if(val=='Berkas Terbawa Pasien'){
                        pilih=1;
                    }
                    else if(val=='Konsul Antar poli'){
                        pilih=2;
                    }
                    else if(val=='Pasien Langsung Ke Penunjang'){
                        pilih=3;
                    }
                    else if(val=='Pengiriman Berkas Terlambat'){
                        pilih=4;
                    }
                    else if(val=='Pasien Tidak Jadi Berkunjung'){
                        pilih=5;
                    }
                    else{
                        pilih=6;
                        document.getElementById('txtLainnya').value=val;
                    }
                    document.getElementById("chkCatatan"+pilih).checked=true;
                }
                
                function simpanCatatan(){
                    var idKunj=document.getElementById('txtKunjId').value;
                    var jnsRwt=document.getElementById('cmbJnsRwt').value;
                    var note='';
                    for(var i=0; i<document.form1.chkCatatan.length;i++){
                        if(document.getElementById("chkCatatan"+i).checked){
                            switch(document.getElementById("chkCatatan"+i).value){
                                case '0':
                                    note='';
                                    break;
                                case '1':
                                    note='Berkas Terbawa Pasien';
                                    break;
                                case '2':
                                    note='Konsul Antar poli';
                                    break;
                                case '3':
                                    note='Pasien Langsung Ke Penunjang';
                                    break;
                                case '4':
                                    note='Pengiriman Berkas Terlambat';
                                    break;
                                case '5':
                                    note='Pasien Tidak Jadi Berkunjung';
                                    break;
                                case '6':
                                    note=document.getElementById('txtLainnya').value;
                                    break;
                            }
                        }
                    }
                    Request('koreksi_utils.php?idKunj='+idKunj+'&jnsRwt='+jnsRwt+'&note='+note+'&tabel=save_catatan','divSelesaiCatatan','','GET',selesaiCatatan,'ok');
                }
                
                function cetak(){
                    Request('verifikasi_utils.php?kunjId='+document.getElementById('txtKunjId').value+'&act=setPelAs&jnsRwt='+document.getElementById('cmbJnsRwt').value,'cmbPelAsCetak','','GET');
                    new Popup('divCetak',null,{modal:true,position:'center',duration:0.5})
                    $('divCetak').popup.show();                    
                }
                
                function cetakRincian(){
                    var jnsRwt=document.getElementById('cmbJnsRwt').value;
                    var pelayanan=document.getElementById("cmbPelAsCetak").value.split("|");
                    var pelId=pelayanan[0];
                    var inap=0;
                    if(jnsRwt==1){
                        inap=1;
                    }
                    window.open('../unit_pelayanan/RincianTindakanKSO.php?idKunj='+document.getElementById('txtKunjId').value+'&idPel='+pelId+'&idUser=<?php echo $userId;?>&inap=1&tipe='+inap,'_blank');
                }
                
                function simpanKunjungan(id){
                    var pulang = document.getElementById('cmbKPulang_'+id).value; 
                    var tglSJP = document.getElementById('txtKTglSJP_'+id).value;
                    var tglMsk = document.getElementById('txtKTgl_'+id).value;
                    var tglPlg = document.getElementById('txtKTglPlg_'+id).value;
                    var kelas_id = document.getElementById('cmbKKelas_'+id).value;
                    var baruLama = document.getElementById('cmbKBaruLama_'+id).value;
                    var kso_id = document.getElementById('cmbKKSO_'+id).value;
                    var kso_kelas_id = document.getElementById('cmbKKelasKSO_'+id).value;                    
                    //alert('koreksi_utils.php?kid='+id+'&pulang='+pulang+'&tglSJP='+tglSJP+'&tglMsk='+tglMsk+'&tglPlg='+tglPlg+'&kelas_id='+kelas_id+'&baruLama='+baruLama+'&kso_id='+kso_id+'&kso_kelas_id='+kso_kelas_id+'&act=save&idKunj='+dataPasien[8]+'&tabel=kunjungan');
                    Request('koreksi_utils.php?kid='+id+'&pulang='+pulang+'&tglSJP='+tglSJP+'&tglMsk='+tglMsk+'&tglPlg='+tglPlg+'&kelas_id='+kelas_id+'&baruLama='+baruLama+'&kso_id='+kso_id+'&kso_kelas_id='+kso_kelas_id+'&act=save&idKunj='+dataPasien[8]+'&tabel=kunjungan','divKunjungan','','GET',afterKunj,'ok');                   
                    
                }
                function simpanPelayanan(id){
                    var jnsRwt = document.getElementById('cmbJnsRwt').value; 
                    
                    var pKsoId = document.getElementById('cmbPKSO_'+id).value;
                    var pKelasId = document.getElementById('cmbPKelas_'+id).value;
                    var pTgl = document.getElementById('txtPTgl_'+id).value;
                    var pTglKRS = document.getElementById('txtPTglPlg_'+id).value;
                    var dilayani = document.getElementById('cmbPDilayani_'+id).value;
                   
                    Request('koreksi_utils.php?pid='+id+'&pTgl='+pTgl+'&pKsoId='+pKsoId+'&pKelasId='+pKelasId+'&pTglKRS='+pTglKRS+'&dilayani='+dilayani+'&act=save&idKunj='+dataPasien[8]+'&tabel=pelayanan'+'&jnsRwt='+jnsRwt,'divPelayanan','','GET',afterPel,'ok');
                    //alert('koreksi_utils.php?pid='+id+'&pTgl='+pTgl+'&pKsoId='+pKsoId+'&pKelasId='+pKelasId+'&pTglKRS='+pTglKRS+'&dilayani='+dilayani+'&act=save&idKunj='+dataPasien[8]+'&tabel=pelayanan'+'&jnsRwt='+jnsRwt,'divPelayanan');
                    
                }
                function hapusPelayanan(trId){
                    var jnsRwt = document.getElementById('cmbJnsRwt').value; 
                    var idTd;                    
					var pTglSkrg = "<?php echo $pTglSkrg; ?>";
					if (pTglSkrg>TglYmd(document.getElementById('txtPTgl_'+trId).value)){
						alert("Data Sudah Lebih dari 24 Jam, Jadi Tdk Boleh DiHapus !");
						return false;
					}
                    idTd= new Array ('pno_'+trId,'pJenis_'+trId,'pUnit_'+trId,'pAsal_'+trId,'pKSO_'+trId,'pKelas_'+trId,'pTgl_'+trId,'pTglPlg_'+trId,'pDilayani_'+trId);
                    
                    warnaiBaris(idTd,"#FF0000");
                    if(confirm('Anda yakin ingin menghapus baris ini?')){                        
                        Request('koreksi_utils.php?pid='+trId+'&act=delete&idKunj='+dataPasien[8]+'&tabel=pelayanan'+'&jnsRwt='+jnsRwt,'divPelayanan','','GET',afterPel,'ok');                                                
                    }else{
                        warnaiBaris(idTd,"");
                    }
                }
                
                function popupTambahKamar()
                {
                    new Popup('divTambahKamar',null,{modal:true,position:'center',duration:0.5})
                    $('divTambahKamar').popup.show();
                    window.scrollTo(0,0);
                    document.getElementById("cmbPelAs").value='';
                    document.getElementById("cmbKamar").innerHTML='';
                    document.getElementById("spanTarifPindah").innerHTML='';
                    document.getElementById("txtBayarKmr").value=0;
                    document.getElementById("txtBayarPasienKmr").value=0;       
                }
                
                function tambahKamar(){
                    var pelayanan=document.getElementById("cmbPelAs").value;                    
                    var kamar = document.getElementById("cmbKamar").value;
                    var tarip = document.getElementById("spanTarifPindah").innerHTML;
                    var bayar = document.getElementById("txtBayarKmr").value;
                    var bayarpasien = document.getElementById("txtBayarPasienKmr").value;                    
                    Request('koreksi_utils.php?&pelayanan='+pelayanan+'&tkKamar='+kamar+'&tarip='+tarip+'&bayar='+bayar+'&bayarpasien='+bayarpasien+'&idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&act=tambah_kamar&tabel=tindakan_kamar','divTindakanKamar','','GET','','ok');
                }

				function cetakRet()
				{
					var cIdKunj=document.getElementById('txtKunjId').value;
					if (cIdKunj==""){
						alert("Pilih Kunjungan Pasien Terlebih Dahulu !");
					}else{
						window.open('../loket/cetakLoket.php?idKunj='+cIdKunj,'_blank');
					}
					//batal();
				}
            </script>
    </body>
</html>
<?php
mysql_close($konek);
?>