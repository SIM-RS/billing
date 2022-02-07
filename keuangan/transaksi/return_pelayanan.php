<?php
session_start();
$userId = $_SESSION['id'];
if(!isset($userId) || $userId == ''){
    header('location:../index.php');
}
include ("../koneksi/konek.php");
?>
<html>
    <head>
        <title>Form Retur Pelayanan</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <link type="text/css" href="../menu.css" rel="stylesheet" />
        <script type="text/javascript" src="../jquery.js"></script>
        
        <!--script type="text/javascript" src="../menu.js"></script-->
        <script type="text/javascript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/ajax.js"></script>
        <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
        <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        
       <script type="text/javascript" src="jquery.js"></script>
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
                background-color:#a3fcb0;
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
			.filed{
				border:2px #10476B outset;-moz-border-radius:10px;
				padding:20px;
				background-repeat:repeat-x;
			}
        </style>
        <!--<script>
		$(function() {
		$( "#datepicker" ).datepicker({
			changeMonth: true,
			changeYear: true
			});
		});
		</script>-->
    </head>
    <body onLoad="document.getElementById('txtNoRm').focus();" onclick="">
    <iframe height="72" width="130" name="sort"
                    id="sort"
                    src="../theme/dsgrid_sort.php" scrolling="no"
                    frameborder="0"
                    style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
		<div id="form_header" align="center">
         <?php
         //include("../header.php");
         $date_now=gmdate('d-m-Y',mktime(date('H')+7));
         ?>
         <script>
		 var date_now = '<?php echo $date_now; ?>';
		 </script> 
         <input type="hidden" id="tgl_now" value="<?php echo $date_now; ?>">
         </div>
         <div id="div_catatan" style="display:none;width:350px" class="popup">
            <span id="divSelesaiCatatan"></span>
            <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />
            <fieldset><legend>Catatan verifikasi</legend>
                <form id="form1" name="form1">
                    <textarea style="display:none;" id="txtTempCatatan" name="txtTempCatatan" cols="50" rows="3"></textarea>
            <table width="300" height="100" class="tabel">
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
            <table border=0 class="tabel">
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
            <table border=0 class="tabel">
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
       
    <div id="list_return" style="display:block" align="center">
    <input type="hidden" id="val" />
    <input type="hidden" id="no_rm" />
    <input type="hidden" id="no_ret" />
	<table width="1000" border="0" cellpadding="0" style="background:#EAEFF3;" cellspacing="0" align="center">
                <tr>
                	<td>&nbsp;</td>
                </tr>
                <tr>
                	<td align="center" colspan="2" style="font-size:16px"><b>Retur Tindakan Billing</b></td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;Bulan&nbsp;:&nbsp;
                  <select id="cmbBulan" class="txtinput" onChange="ganti()">
                  	<option value="01">Januari</option>
                    <option value="02">Februari</option>
                    <option value="03">Maret</option>
                    <option value="04">April</option>
                    <option value="05">Mei</option>
                    <option value="06">Juni</option>
                    <option value="07">Juli</option>
                    <option value="08">Agustus</option>
                    <option value="09">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">Nopember</option>
                    <option value="12">Desember</option>
                  </select>&nbsp;
                  <select id="cmbTahun" class="txtinput" onChange="ganti()">
                  <?php
				  $thn=date('Y');
				  for($i=$thn-9;$i<=$thn;$i++){
				  ?>
                  	<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                  <?php
				  }
				  ?>
                  </select>
                  </td>
                  <td height="30" align="right" style="padding-right:10px;">
				  <img id="btnTambah" src="../images/plus.png" width="30" height="30" style="cursor:pointer" onClick="tambah()" title="Klik untuk menambah data"/>&nbsp;
				  <img id="btnEdit" src="../images/edit.png" width="30" height="30" title="Klik untuk mengedit data" onClick="buka()" style="cursor:pointer" />&nbsp; 
				  <img src="../images/del.png" width="30" height="30" title="Klik untuk menghapus data" onClick="hapusReturn()" style="cursor:pointer" /></td>
                </tr>
                <tr>
                    <td height="30" colspan="2" align="center">
					<div id="gridReturn" style="width: 980px; height:370px; border:none; display:block"></div>
            		<div id="pagingReturn" style="width: 990px; display:block"></div>
					</td>
                </tr>
                <tr><td style="padding-top:10px" colspan="2"><?php include("../footer.php");?></td></tr>
    </table>
    </div>    
            
       <div id="form_return" style="display:none" align="center">     
            <table width="1000" border="0" cellspacing="0" cellpadding="0" class="txtinput1" bgcolor="#EAEFF3" align="center" height="450">
            	<tr>
                	<td>&nbsp;</td>
                </tr>
                <tr>
                	<td align="center" colspan="2" style="font-size:16px" id="jdlForm"><b>Input Retur Pelayanan / Tindakan Billing</b></td>
                </tr>
                <tr>
                	<td align="right">&nbsp;</td>
                </tr>
                <tr>
                    <td valign="top" height="50" style="background-color:#EAEFF3; padding-left:20px; padding-right:20px;">
                        <fieldset class="filed">
                            <legend>Data Pasien</legend>
                        <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size:12px; font-family:verdana;">
                            <tr>
                            <td>No RM</td><td> : </td><td><input type="text" tabindex="1" size="9" id="txtNoRm" name="txtNoRm" class="txtinput" onKeyUp="listPasien(event,'show',this.value)" value=""/></td>
                            <td>Jenis Perawatan</td><td>:</td><td><select id="cmbJnsRwt" name="cmbJnsRwt" disabled="disabled" onChange="setPasien(document.getElementById('txtVal').value);" class="txtinput">
                                <option value="0">Semua</option>
                                <option value="1">Rawat Jalan</option>
                                <option value="3">Rawat Inap</option>
                                <option value="2">Darurat</option>
                            </select></td>
                            <td>Nama</td><td> : </td><td><input type="text" id="txtNama" name="txtNama" size="30" readonly="readonly" class="txtinput"/></td>
                            <td>TTL</td><td> : </td><td><input type="text" id="txtTglLhr" name="txtTglLhr" readonly="readonly" class="txtinput"/></td>
                            </tr>
                            <tr>
                                <td colspan="6" rowspan="2" align="left">
                                    Tanggal Kunjungan:
                                    <input tabindex="2" id="txtTglAwal" name="txtTglAwal" size="10" class="txtcenter" value="<?php echo $date_now;?>" onFocus="this.select();" onBlur="if(this.value==''){this.value='<?php echo $date_now;?>'}" onKeyUp="if(event.which==13){ cariLagi(); document.getElementById('txtNoRm').select();} else{setTgl(event,this);}"/>
                                    <img alt="tglAwal" id="tgl01" src="http://<?php echo $_SERVER['HTTP_HOST'];?>/simrs/billing/icon/archive1.gif" onClick="gfPop.fPopCalendar(document.getElementById('txtTglAwal'),depRange,cariLagi);" style="cursor: pointer"/>
                                    &nbsp;sampai&nbsp;                                    
                                    <input tabindex="3" id="txtTglAkhir" name="txtTglAkhir"  size="10" class="txtcenter" value="<?php echo $date_now;?>" onFocus="this.select();" onBlur="if(this.value==''){this.value='<?php echo $date_now;?>'}" onKeyUp="if(event.which==13){ cariLagi();  document.getElementById('txtNoRm').select();} else{setTgl(event,this);}"/>
                                    <img alt="tglAwal" id="tgl02" src="http://<?php echo $_SERVER['HTTP_HOST'];?>/simrs/billing/icon/archive1.gif" onClick="gfPop.fPopCalendar(document.getElementById('txtTglAkhir'),depRange,cariLagi);" style="cursor: pointer"/>
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
                        <div id="temp_no" style="display:none"></div>
                        <div id="div_pasien" align="center" class="div_pasien" style="position:absolute;display:none"></div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td align="center"><!--<input type="text" id="datepicker"/>-->
                         <?php
			    $sVer="SELECT p.id ,g.nama AS grup FROM $dbbilling.b_ms_group_petugas gp
				    INNER JOIN $dbbilling.b_ms_group g ON g.id=gp.ms_group_id
				    INNER JOIN $dbbilling.b_ms_pegawai p ON p.id=gp.ms_pegawai_id
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
                        <table width="100%" border="0" style="display:none;">
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
                <tr style="display:none">
                    <td valign="top">                        
                        <fieldset>
                            <legend>Data Kunjungan
                            <input type="button" size="3" id="btnShowKunjDown" value="&or;" style="display:inline;cursor:pointer;" onClick="document.getElementById('divKunjungan').style.height='150px';this.style.display='none';document.getElementById('btnShowKunjUp').style.display='inline';"/>
                            <input type="button" size="3" id="btnShowKunjUp" value="&and;" style="display:none;cursor:pointer;" onClick="document.getElementById('divKunjungan').style.height='0px';this.style.display='none';document.getElementById('btnShowKunjDown').style.display='inline';"/>
                            </legend>                            
                            <div id="divKunjungan" align="center" style="overflow:auto;0px;">
                        		
                            </div>
                        </fieldset>                        
                    </td>
                </tr>
                <tr style="display:none;">
                    <td valign="top">
                        <fieldset>
                            <legend>Data Pelayanan
                            <input type="button" size="3" id="btnShowPelDown" value="&or;" style="display:inline;cursor:pointer;" onClick="document.getElementById('divPelayanan').style.height='0px';document.getElementById('divTablePelayanan').style.height='300px';this.style.display='none';document.getElementById('btnShowPelUp').style.display='inline';"/>
                            <input type="button" size="3" id="btnShowPelUp" value="&and;" style="display:none;cursor:pointer;" onClick="document.getElementById('divPelayanan').style.height='0px';document.getElementById('divTablePelayanan').style.height='0px';this.style.display='none';document.getElementById('btnShowPelDown').style.display='inline';"/>
                            </legend>
                            <div id="divTablePelayanan" align="center"  style="overflow:auto;height:0px;">
                                <div id="gridGrup" style="width: 990px; height:250px; border:none; display:block"></div>
            					<div id="pagingGroup" style="width: 990px; display:none"></div>
                            </div>
                            <div id="divPelayanan" style="overflow:auto;height:0px;">
                        
                            </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                </tr>
                <tr>
                    <td valign="top" style="padding-left:20px; padding-right:20px;">
                        <fieldset class="filed">
                        	<legend>Data Tindakan
                            <input type="button" size="3" id="btnShowTinDown" value="&or;" style="display:inline;cursor:pointer;" />
                            <input type="button" size="3" id="btnShowTinUp" value="&and;" style="display:none;cursor:pointer;" />
                            <span id="divSelesai" style="color:#0000ff;background-color:#ffff00;"></span></legend>
                            <div id="divTableTindakan" align="center"  style="overflow:auto;height:0px;">
                                <div id="gb" style="width: 900px; height:300px; border:none; display:block"></div>
            					<div id="pg" style="width: 900px; display:none"></div>
                            </div>
                            <div id="divTindakan" style="overflow:auto;height:0px;">
                            </div>
                           
                            
                             
                        </fieldset>
                    </td>
                </tr>
             	<tr>
                	<td>&nbsp;</td>
                </tr>
                <tr id="trTinKamar" style="visibility:collapse;">
                    <td valign="top" style="padding-left:20px; padding-right:20px;">
                        <fieldset class="filed">
                            <legend>Data Tindakan Kamar
                            <input type="button" size="3" id="btnShowTindKDown" value="&or;" style="display:inline;cursor:pointer;"/>
                            <input type="button" size="3" id="btnShowTindKUp" value="&and;" style="display:none;cursor:pointer;" />
                            
                            <span id="divSelesaiKamar" style="color:#0000ff;background-color:#ffff00;width:100px;"></span>
                            </legend>
                            <div id="divTindakankamar_" align="center" style="height:0px; overflow:auto">
                                 <div id="gbtk" style="width: 900px; height:300px; border:none; display:block"></div>
                                 <!--br><br-->
            					 <div id="pgtk" style="width: 900px; display:none"></div>
                            </div>
                            <div id="divTindakanKamar" style="display:none; overflow:auto; height:0;">
                        
                            </div>
                        </fieldset>
                    </td>
                </tr>
                <tr style="display:none;">
                    <td valign="top">
                        <fieldset>
                            <legend>Data Resep&nbsp;
                            <input type="button" size="3" id="btnShowResepDown" value="&or;" style="display:inline;cursor:pointer;" onClick="document.getElementById('divPelayanan').style.height='0px';document.getElementById('divTableResep').style.height='320px';this.style.display='none';document.getElementById('btnShowResepUp').style.display='inline';"/>
                            <input type="button" size="3" id="btnShowResepUp" value="&and;" style="display:none;cursor:pointer;" onClick="document.getElementById('divPelayanan').style.height='0px';document.getElementById('divTableResep').style.height='0px';this.style.display='none';document.getElementById('btnShowResepDown').style.display='inline';"/>
                            </legend>
                            <div id="divTableResep" align="center"  style="overflow:auto;height:0px;">
                            	<div align="right" style="padding-right:10px"><button id="viewDetil" name="viewDetil" onClick="tambahResep();">Tambah</button><button style="display:none" id="hapusDetil" name="hapusDetil" onClick="hapusResep(0,0);">Hapus</button></div>
                                <div id="gbrsp" style="width: 990px; height:250px; border:none; display:block"></div>
            					<div id="pgrsp" style="width: 990px; display:block"></div>
                            </div>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                	<td>&nbsp;</td>
                </tr>
                <tr>                              
                    <td style="padding-left:20px;">
                    <table cellpadding="0" cellspacing="0" width="100%">
                    	<tr>
                        	<td width="10%">No. Retur</td>
                            <td>: <input type="text" id="no_return" name="no_return" class="txtinput" size="25" value="" readonly ></td>
                            <td>&nbsp;</td>
                            <td rowspan="2" align="right" style="padding-right:20px;"><button type="button" onClick="cetakReturn()" style="cursor:pointer"><img src="../icon/printer.png" width="20" align="absmiddle">&nbsp;Cetak Retur</button>&nbsp;
                            <button type="button" id="btnBack" name="btnBack" style="cursor:pointer"><img src="../images/kembali.png" align="absmiddle" width="20">&nbsp;List Retur</button></td>
                        </tr>
                   		<tr>
                        	<td>Tanggal</td>
                            <td>: <input id="txtTglReturn" name="txtTglReturn" size="10" class="txtcenter" value="<?php echo $date_now;?>"/>
                                    <img alt="tanggal return" id="tglR" src="http://<?php echo $_SERVER['HTTP_HOST'];?>/simrs/billing/icon/archive1.gif" onClick="gfPop.fPopCalendar(document.getElementById('txtTglReturn'),depRange,zxc);" style="cursor: pointer"/></td>
                            <td>&nbsp;</td>                       
                        </tr>
                    </table>
                    </td>
                </tr>
                 <tr>
                	<td>&nbsp;</td>
                </tr>
                <tr>
                    <td valign="top"  style="padding-left:20px; padding-right:20px;">
                        <fieldset class="filed">
                            <legend align="center">
                            |&nbsp;<button type="button" onClick="prosesHapus()" style="cursor:pointer"><img src="../images/arrow_up.png" width="20" align="absmiddle">&nbsp;&nbsp;Batal</button>
                            <button type="button" onClick="prosesReturn()" style="cursor:pointer"><img src="../images/arrow_down.png" width="20" align="absmiddle">&nbsp;Retur</button>&nbsp;|
                            </legend>
                            <div id="divReturnTindakan" align="center"  style="overflow:auto;height:300px;">
                                <div id="gbr" style="width: 900px; height:270px; border:none; display:block"></div>
            					<div id="pgr" style="width: 900px; display:none"></div>
                            </div>
                            <div id="divReturnTindakan" style="overflow:auto;height:0px;">
                            </div>
						</fieldset>
                    </td>
                </tr>
                <tr><td style="padding-top:10px"><?php include("../footer.php");?></td></tr>
            </table> 
      </div>           
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
							//alert('pasien_list.php?act=cari&tglAwal='+tglAwal+'&tglAkhir='+tglAkhir+'&norm='+stuff+'&jenisRawat='+jenisRawat);
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
					if(fEdit==false)
						Request('getNoReturn.php','temp_no','','GET',setNoRet,'noLoad');
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
                   // Request('koreksi_utils.php?idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&tabel=pelayanan'+'&jnsRwt='+jnsRwt,'divPelayanan','','GET',afterPel,'ok');
					g.loadURL('pelayanan_util.php?idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&jnsRwt='+jnsRwt,'','GET');
                    isiPelAs(dataPasien[8]);
                    //Request('koreksi_utils.php?idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&tabel=tindakan'+'&jnsRwt='+jnsRwt,'divTindakan','','GET',getCatatan,'ok');
					//alert('r_tindakan_util.php?idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&jnsRwt='+jnsRwt);
					gg.loadURL('r_tindakan_util.php?idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&jnsRwt='+jnsRwt,'','GET');
					//alert('return_pelayanan_util.php?idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&jnsRwt='+jnsRwt+'&tanggal='+document.getElementById('txtTglReturn').value);
					ggr.loadURL('return_pelayanan_util.php?idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&jnsRwt='+jnsRwt+'&tanggal='+document.getElementById('txtTglReturn').value,'','GET');
					//alert('tindakan_util.php?idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]);
                    if(jnsRwt=='3'){
                        Request('koreksi_utils.php?idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&tabel=tindakan_kamar','divTindakanKamar','','GET');
						//alert('return_tindakan_kamar_util.php?idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&jnsRwt='+jnsRwt);
						tk.loadURL('return_tindakan_kamar_util.php?idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&jnsRwt='+jnsRwt,'','GET');
                        document.getElementById('trTinKamar').style.visibility="visible";
                    }
					else if(jnsRwt=='0'){
						 tk.loadURL('return_tindakan_kamar_util.php?idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&jnsRwt='+jnsRwt,'','GET');
						 document.getElementById('trTinKamar').style.visibility="visible";
					}
                    else{
                        document.getElementById('trTinKamar').style.visibility="collapse";
                    }
					rsp.loadURL('resep_util.php?grid=1&idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&jnsRwt='+jnsRwt,'','GET');
					
					document.getElementById('divKunjungan').style.height = '0px';
					
					
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
				
				function selesaiKamar(){
					setTimeout("document.getElementById('divSelesaiKamar').innerHTML=''",'1000');
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
					var getIdKelas=document.getElementById('txtIdKelas').value;
					var getIdUnit=document.getElementById('txtUnitId').value;
					var getIdJns=document.getElementById('txtJnsUnitId').value;
					var getIdPel=document.getElementById('txtPelId').value;
					
                    //var getIdPasien=document.getElementById('txtIdPasien').value;
                    //var getIdKelas=document.getElementById('txtIdKelas_'+idDepan[1]).value;
                    //var getIdUnit=document.getElementById('txtUnitId_'+idDepan[1]).value;
                    //var getIdJns=document.getElementById('txtJnsUnitId_'+idDepan[1]).value;
                    //var getIdPel=document.getElementById('txtPelId_'+idDepan[1]).value;                    
                    var keywords=par.value;//alert(keywords);
                    if(keywords==""){
                        document.getElementById('divtindakan2').style.display='none';
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
                            Request("tindakanlist.php?aKeyword="+keywords+"&id="+idDepan[1]+"&pasienId="+getIdPasien+"&kelasId="+getIdKelas+"&unitId="+getIdUnit+"&jenisLay="+getIdJns+"&pelayananId="+getIdPel+"&allKelas="+all, 'divtindakan2', '', 'GET');
                            if (document.getElementById('divtindakan2').style.display=='none'){
                                //fSetPosisi(document.getElementById('divtindakan2'),par);
								document.getElementById('divtindakan2').style.top='50px';
								document.getElementById('divtindakan2').style.left='150px';
							}
                            document.getElementById('divtindakan2').style.display='block';
                        }else if(key==27){
                            document.getElementById('divtindakan2').style.display='none';
                        }
                    }
                }
                function fSetTindakan(id,par){      
					//alert(par);
                    var cdata = par.split("*|*");
					
					document.getElementById('tindakan_id').value = cdata[0];
					document.getElementById('txtTind').value = cdata[1];
					document.getElementById('tdKelas').innerHTML = cdata[5];
					document.getElementById('txtBiaya').value = cdata[3];
					
                    //document.getElementById("txtIdTind_"+id).value=cdata[0];
                    //document.getElementById("txtTind_"+id).value=cdata[1];
                    //document.getElementById("txtBiaya_"+id).value=cdata[3];
                    //document.getElementById("txtBiayaKso_"+id).value=cdata[3];
                    //document.getElementById("txtBiayaPasien_"+id).value=cdata[3];
                   // document.getElementById("txtKelas_"+id).value=cdata[5];
                    //document.getElementById("txtIdKelas_"+id).value=cdata[7];
                    document.getElementById('divtindakan2').style.display='none';                    
                    //simpan(id);
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
                    //var jmlT=document.getElementById("txtJmlT").value;
					var jmlT=gg.getMaxRow();
					var tindId,tmpTindId;
                    for(var i=0;i<parseInt(jmlT);i++){                    
                        //var tindId = document.getElementById('tblTindakan').getElementsByTagName("tr")[i].id;
						tmpTindId = gg.getRowId(i+1).split("|");
						tindId = tmpTindId[4];
                        verifikasi(tindId,'1','');
                        //document.getElementById("chkVer_"+tindId).checked=true;
						document.getElementById('chkVerTindakan_'+tindId).checked=true;
						document.getElementById('chkVerTindakan_'+tindId).value='1';
						//VerifikasiTindakan(tindId);
                    }
                    
                    if(jnsRwt==1){
                        //var jmlTK=document.getElementById("txtJmlTK").value;
						var jmlTK=tk.getMaxRow();  
                        if(jmlTK!=''){
                            for(var i=0;i<parseInt(jmlTK);i++){ 
                                //var tindId = document.getElementById('tblTindakanKamar').getElementsByTagName("tr")[i].id;
								tmpTindId = tk.getRowId(i+1).split("|");
								tindId = tmpTindId[0];
                                                        
                                verifikasi(tindId,'1','yes');
                                //document.getElementById("chkVerKamar_"+tindId).checked=true;
								document.getElementById('chkVerKamarNew_'+tindId).checked=true;
								document.getElementById('chkVerKamarNew_'+tindId).value='1';
								//VerifikasiTindakanKamar(tindId);
                            }
                        }
                    }
                    cekVerifikasi(kunjId,jnsRwt);
                }
                
                function verifikasi(tinId,val,kamar){
                    //alert("verifikasi_utils.php?act=verifikasi&tindakan_id="+tinId+"&value="+val+"&kamar="+kamar+"&verifikator=<?php echo $userId;?>");
                    Request("verifikasi_utils.php?act=verifikasi&tindakan_id="+tinId+"&value="+val+"&kamar="+kamar+"&verifikator=<?php echo $userId;?>",'divSelesai','','GET',selesai,'ok');                   
                    
                }
                /*
                function verifikasiTind(tinId,val,kamar){
                    //alert("verifikasi_utils.php?act=verifikasi&tindakan_id="+tinId+"&value="+val+"&kamar="+kamar+"&verifikator=<?php echo $userId;?>");
                    Request("verifikasi_utils.php?act=verifikasi&tindakan_id="+tinId+"&value="+val+"&kamar="+kamar+"&verifikator=<?php echo $userId;?>",'divSelesai','','GET',selesai,'ok');                   
                    
                }*/
                                
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
                /*function hapusPelayanan(trId){
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
                }*/
                
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
					tk.loadURL('tindakan_kamar_util.php?idPasien='+document.getElementById('txtIdPasien').value+'&idKunj='+document.getElementById('txtKunjId').value+'&jnsRwt='+document.getElementById('cmbJnsRwt').value,'','GET');
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


function konfirmasi(key,val){
	var sisip;
	if (val!="" && val!=undefined){
		alert(val);
	}
	/*if(key=='Error'){
		if(val=='tambah')
			alert('Tambah Gagal');
		else if(val=='simpan')
			alert('Simpan Gagal');
		else if(val=='hapus')
			alert('Hapus Gagal');
		else if(val=='SudahAda')
			alert('Pasien Sudah Berkunjung ke Unit Tersebut !');
			
		batal();
	}*/
}

var g = new DSGridObject("gridGrup");
g.setHeader(" ",false);
g.setColHeader("No,Jenis Layanan,Tempat Layanan,Tempat Layanan Asal,Penjamin (KSO),Kelas,Tanggal Datang,Tanggal Pulang,Status Dilayani,Proses");
//g.setIDColHeader(",kode,nama,ket,");
g.setColWidth("30,100,90,70,70,70,70,70,70,70");
g.setCellAlign("center,left,left,left,left,left,center,center,center,center");
g.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt");
g.setCellHeight(20);
g.setImgPath("../icon");
g.setIDPaging("pagingGroup");
g.attachEvent("onRowClick","ambilPel");
g.onLoaded(konfirmasi);
g.baseURL("pelayanan_util.php");
g.Init();

var gg = new DSGridObject("gb");
gg.setHeader("DATA TINDAKAN",false);
gg.setColHeader("<input type='checkbox' id='chk' onchange='cekAll()' />,Jenis Layanan,Tempat Layanan,Tanggal,Tindakan,Kelas,Jumlah,Tarif RS,Tarif KSO,Iur Bayar,Bayar Pasien");
//g.setIDColHeader(",kode,nama,ket,");
gg.setColWidth("30,100,90,70,120,70,50,50,50,50,50");
gg.setCellAlign("center,left,left,left,left,left,center,right,right,right,right");
gg.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt");
gg.setCellHeight(20);
gg.setImgPath("../icon");
gg.setIDPaging("pg");
gg.attachEvent("onRowClick","ambilTind");
gg.baseURL("r_tindakan_util.php");
gg.Init();

function cekAll(){
	for(var i=1; i<=gg.getMaxRow(); i++ ){
		var id = gg.getRowId(i);
		var idTin = id.split('|');
		if(document.getElementById('chk').checked)
			document.getElementById('chk_'+idTin[6]).checked = 'true';
		else
			document.getElementById('chk_'+idTin[6]).checked = '';
	}
}

function cekAllr(){
	for(var i=1; i<=ggr.getMaxRow(); i++ ){
		var id = ggr.getRowId(i);
		var idTin = id.split('|');
		if(document.getElementById('chkr').checked)
			document.getElementById('chkr_'+idTin[6]).checked = 'true';
		else
			document.getElementById('chkr_'+idTin[6]).checked = '';
	}
}

function cekAlltk(){
	for(var i=1; i<=tk.getMaxRow(); i++ ){
		var id = tk.getRowId(i);
		//var idTin = id.split('|');
		if(document.getElementById('chktk').checked)
			document.getElementById('chktk_'+id).checked = 'true';
		else
			document.getElementById('chktk_'+id).checked = '';
	}
}

var ggr = new DSGridObject("gbr");
ggr.setHeader("DATA TINDAKAN YANG DIRETUR",false);
ggr.setColHeader("<input type='checkbox' id='chkr' onchange='cekAllr()'/>,Jenis Layanan,Tempat Layanan,Tanggal,Tindakan,Kelas,Jumlah,Tarif RS,Tarif KSO,Iur Bayar,Bayar Pasien");
//g.setIDColHeader(",kode,nama,ket,");
ggr.setColWidth("30,100,90,70,120,70,50,50,50,50,50");
ggr.setCellAlign("center,left,left,left,left,left,center,right,right,right,right");
ggr.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt");
ggr.setCellHeight(20);
ggr.setImgPath("../icon");
ggr.setIDPaging("pgr");
ggr.attachEvent("onRowClick","ambilTind");
ggr.baseURL("return_tindakan_util.php");
ggr.Init();

var tk = new DSGridObject("gbtk");
tk.setHeader("DATA TINDAKAN KAMAR",false);
tk.setColHeader("<input type='checkbox' id='chktk' onchange='cekAlltk()' />,Jenis Layanan,Tempat Layanan,Kamar,Tgl,Tindakan,Kelas,Tarif RS,Beban KSO,Beban Pasien");
//g.setIDColHeader(",kode,nama,ket,");
tk.setColWidth("30,100,100,100,100,100,50,50,50,50");
tk.setCellAlign("center,left,left,left,left,left,center,left,center,right");
tk.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt");
tk.setCellHeight(20);
tk.setImgPath("../icon");
tk.setIDPaging("pgtk");
tk.attachEvent("onRowClick","ambilTindK");
tk.baseURL("return_tindakan_kamar_util.php");
tk.Init();

var rsp = new DSGridObject("gbrsp");
rsp.setHeader(" ",false);
rsp.setColHeader("No,Tanggal,No Penjualan,Penjamin (KSO),No Resep,No Pasien,Nama Pasien,Nama Kepemilikan,Nama Unit,Dokter,Shift,Cara Bayar,Bayar,Utang,Harga Netto,Harga Total,Hapus,Detail");
//g.setIDColHeader(",kode,nama,ket,");
rsp.setColWidth("30,70,50,70,70,70,110,70,110,100,50,50,70,70,70,70,50,50");
rsp.setCellAlign("center,center,center,left,center,center,left,left,left,left,center,center,center,center,right,right,center,center");
rsp.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt");
rsp.setCellHeight(20);
rsp.setImgPath("../icon");
rsp.setIDPaging("pgrsp");
rsp.attachEvent("onRowClick","ambilResep");
//rsp.attachEvent("onRowDblClick","viewDetailResep");
rsp.baseURL("resep_util.php?grid=1");
rsp.Init();

function ambilResep(){
	var sisipan=rsp.getRowId(rsp.getSelRow()).split('|');
	document.getElementById('aidi_unit').value = sisipan[0];
	document.getElementById('id_pel').value = sisipan[2];
	document.getElementById('id_penjualan').value = sisipan[3];
	document.getElementById('no_penjualan').value=rsp.cellsGetValue(rsp.getSelRow(),3);
	//alert('klik');
}

function VerifikasiTindakan(idt){
	if(document.getElementById('chkVerTindakan_'+idt).checked){
		document.getElementById('chkVerTindakan_'+idt).value='1';
	}
	else{
		document.getElementById('chkVerTindakan_'+idt).value='0';
	} 
	//alert(document.getElementById('chkVerKamar').value);
	//alert(idt);
	verifikasi(idt,document.getElementById('chkVerTindakan_'+idt).value,'');
}

function VerifikasiTindakanKamar(idtk){
	if(document.getElementById('chkVerKamarNew_'+idtk).checked){
		document.getElementById('chkVerKamarNew_'+idtk).value='1';
	}
	else{
		document.getElementById('chkVerKamarNew_'+idtk).value='0';
	} 
	//alert(document.getElementById('chkVerKamar').value);
	//verifikasi(idtk,document.getElementById('chkVerKamar').value,'yes');
	Request("verifikasi_utils.php?act=verifikasi&tindakan_id="+idtk+"&value="+document.getElementById('chkVerKamarNew_'+idtk).value+"&kamar=yes&verifikator=<?php echo $userId;?>",'divSelesaiKamar','','GET',selesaiKamar,'ok');
}

function ambilPel(){
	var sisipan=g.getRowId(g.getSelRow()).split('|');
	
	document.getElementById('jenis_layanan').value=g.cellsGetValue(g.getSelRow(),2);
	document.getElementById('tempat_layanan').value=g.cellsGetValue(g.getSelRow(),3);
	document.getElementById('layanan_asal').value=g.cellsGetValue(g.getSelRow(),4);
	document.getElementById('penjamin').value=g.cellsGetValue(g.getSelRow(),5);
	document.getElementById('kelas').value=g.cellsGetValue(g.getSelRow(),6);
	document.getElementById('tanggal_datang').value=g.cellsGetValue(g.getSelRow(),7);
	document.getElementById('tanggal_pulang').value=g.cellsGetValue(g.getSelRow(),8);
	document.getElementById('status').value=sisipan[1];
	document.getElementById('penjamin_id').value=sisipan[6];
	document.getElementById('pelayanan_id').value=sisipan[0];
	//alert(sisipan[0]);
	//alert(sisipan[0]+"-"+sisipan[1]+"-"+sisipan[2]+"-"+sisipan[3]);
	if(document.getElementById('status').value==0)
		document.getElementById('cmbStatus').selectedIndex = 0;
	if(document.getElementById('status').value==1)
		document.getElementById('cmbStatus').selectedIndex = 1;
	if(document.getElementById('status').value==2)
		document.getElementById('cmbStatus').selectedIndex = 2;
		
	var id=sisipan[0];
    var unit=sisipan[2];
    var inap=sisipan[5];
    var jenis=sisipan[3];
    var kelas=sisipan[4];
    isiCombo('cmbKelasPasien',unit+','+jenis+','+inap,kelas,'cmbPKelas');
}

function ambilTind(){
	var sisipan=gg.getRowId(gg.getSelRow()).split('|');
	document.getElementById('txtIdKelas').value=sisipan[0];
	document.getElementById('txtUnitId').value=sisipan[1];
	document.getElementById('txtJnsUnitId').value=sisipan[2];
	document.getElementById('txtPelId').value=sisipan[3];
	document.getElementById('idt').value=sisipan[4];
	document.getElementById('tindakan_id').value=sisipan[5];
	//document.getElementById('tglTind').value=gg.cellsGetValue(gg.getSelRow(),4);
	document.getElementById('tanggall').value=gg.cellsGetValue(gg.getSelRow(),4);
	document.getElementById('txtTind').value=gg.cellsGetValue(gg.getSelRow(),5);
	document.getElementById('txtQty').value=gg.cellsGetValue(gg.getSelRow(),7);
	document.getElementById('txtBiaya').value=gg.cellsGetValue(gg.getSelRow(),8);
	document.getElementById('tarifKSO').value=gg.cellsGetValue(gg.getSelRow(),9);
	document.getElementById('iurBayar').value=gg.cellsGetValue(gg.getSelRow(),10);
	document.getElementById('bayarPasien').value=gg.cellsGetValue(gg.getSelRow(),11);
	//alert(sisipan[0]+"-"+sisipan[1]+"-"+sisipan[2]+"-"+sisipan[3]);
	//alert(document.getElementById('idt').value);
}

function ambilTindK(){
	var sisipan=tk.getRowId(tk.getSelRow()).split('|');
	document.getElementById('id_tk').value = sisipan[0];
	document.getElementById('id_unit').value = sisipan[1];
	document.getElementById('id_kelas').value = sisipan[2];
	document.getElementById('id_kamar').value = sisipan[3];
	
	document.getElementById('jenis_layananK').value=tk.cellsGetValue(tk.getSelRow(),2);
	document.getElementById('tempat_layananK').value=tk.cellsGetValue(tk.getSelRow(),3);
	document.getElementById('tanggal_masukK').value=tk.cellsGetValue(tk.getSelRow(),6);
	document.getElementById('tanggal_keluarK').value=tk.cellsGetValue(tk.getSelRow(),7);
	document.getElementById('tarifRSK').value=tk.cellsGetValue(tk.getSelRow(),9);
	document.getElementById('bebanKSOK').value=tk.cellsGetValue(tk.getSelRow(),10);
	document.getElementById('beban_pasienK').value=tk.cellsGetValue(tk.getSelRow(),11);
	//document.getElementById('veriK').value=tk.cellsGetValue(tk.getSelRow(),12);
	
	isiCombo('kamar',sisipan[1]+','+sisipan[2],'','cmbKamarK');
	document.getElementById('cmbKamarK').value = sisipan[3];
	isiCombo('cmbKelasKamar',sisipan[1],'','cmbKelasK');
	if(sisipan[4]==0){
		document.getElementById('cmbStatusOut').value = 0;
	}
	else{
		document.getElementById('cmbStatusOut').value = 1;
	}
}

function editTindakanKamar(){
	var jnsRwt = document.getElementById('cmbJnsRwt').value; 
    var cIdUser = "<?php echo $userId; ?>";
	var id = document.getElementById('id_tk').value;
    var unit = document.getElementById('id_unit').value;
    var kamar = document.getElementById('cmbKamarK').value;
    var kelas = document.getElementById('cmbKelasK').value;
    var tglIn = document.getElementById('tanggal_masukK').value;
    var tglOut = document.getElementById('tanggal_keluarK').value;
    var statusOut = document.getElementById('cmbStatusOut').value; 
    var bebanKso = document.getElementById('bebanKSOK').value;
    var bebanPasien = document.getElementById('beban_pasienK').value;
	
	//alert('koreksi_utils.php?id='+id+'&unit='+unit+'&kamar='+kamar+'&kelas='+kelas+'&tglIn='+tglIn+'&tglOut='+tglOut+'&statusOut='+statusOut+'&bebanKso='+bebanKso+'&bebanPasien='+bebanPasien+'&act=save_kamar&idPasien='+document.getElementById('txtIdPasien').value+'&idKunj='+document.getElementById('txtKunjId').value+'&tabel=tindakan_kamar'+'&IdUser='+cIdUser);
	
	Request('koreksi_utils.php?id='+id+'&unit='+unit+'&kamar='+kamar+'&kelas='+kelas+'&tglIn='+tglIn+'&tglOut='+tglOut+'&statusOut='+statusOut+'&bebanKso='+bebanKso+'&bebanPasien='+bebanPasien+'&act=save_kamar&idPasien='+document.getElementById('txtIdPasien').value+'&idKunj='+document.getElementById('txtKunjId').value+'&tabel=tindakan_kamar'+'&IdUser='+cIdUser,'getNote','','GET');
	alert('success');
	tk.loadURL('tindakan_kamar_util.php?idPasien='+document.getElementById('txtIdPasien').value+'&idKunj='+document.getElementById('txtKunjId').value+'&jnsRwt='+jnsRwt,'','GET');
}

function editPelayanan(){
   var jnsRwt = document.getElementById('cmbJnsRwt').value; 
    var id = document.getElementById('pelayanan_id').value;          
    var pKsoId = document.getElementById('penjamin_id').value;
    var pKelasId = document.getElementById('cmbPKelas').value;
    var pTgl = document.getElementById('tanggal_datang').value;
    var pTglKRS = document.getElementById('tanggal_pulang').value;
    var dilayani = document.getElementById('cmbStatus').value;
        
	//alert('koreksi_utils.php?pid='+id+'&pTgl='+pTgl+'&pKsoId='+pKsoId+'&pKelasId='+pKelasId+'&pTglKRS='+pTglKRS+'&dilayani='+dilayani+'&act=save&idKunj='+document.getElementById('txtIdPasien').value+'&tabel=pelayanan'+'&jnsRwt='+jnsRwt);
    //Request('koreksi_utils.php?pid='+id+'&pTgl='+pTgl+'&pKsoId='+pKsoId+'&pKelasId='+pKelasId+'&pTglKRS='+pTglKRS+'&dilayani='+dilayani+'&act=save&idKunj='+dataPasien[8]+'&tabel=pelayanan'+'&jnsRwt='+jnsRwt,'getNote','','GET');
	//alert('success');
    g.loadURL('pelayanan_util.php?pid='+id+'&pTgl='+pTgl+'&pKsoId='+pKsoId+'&pKelasId='+pKelasId+'&pTglKRS='+pTglKRS+'&dilayani='+dilayani+'&act=save&idPasien='+document.getElementById('txtIdPasien').value+'&idKunj='+dataPasien[8]+'&jnsRwt='+jnsRwt,'','GET');
}

function editTindakan(){
	var jnsRwt = document.getElementById('cmbJnsRwt').value; 
    var cIdUser = "<?php echo $userId; ?>";
	
    var tgl = document.getElementById('tanggall').value;
	var id = document.getElementById('idt').value;
    var idTind = document.getElementById('tindakan_id').value;
    var jml = document.getElementById('txtQty').value;
    var biaya = document.getElementById('txtBiaya').value;
    var biayaKso = document.getElementById('tarifKSO').value;
    var biayaPasien = document.getElementById('iurBayar').value;
    var bayarPasien = document.getElementById('bayarPasien').value;
    //var statusVer = document.getElementById('veri').value;
      
	//alert('koreksi_utils.php?id='+id+'&tgl='+tgl+'&idTind='+idTind+'&jml='+jml+'&biaya='+biaya+'&biayaKso='+biayaKso+'&biayaPasien='+biayaPasien+'&bayarPasien='+bayarPasien+'&statusVer=&act=save&idPasien='+document.getElementById('txtIdPasien').value+'&idKunj='+document.getElementById('txtKunjId').value+'&tabel=tindakan'+'&jnsRwt='+document.getElementById('cmbJnsRwt').value+'&IdUser='+cIdUser);
    
	Request('koreksi_utils.php?id='+id+'&tgl='+tgl+'&idTind='+idTind+'&jml='+jml+'&biaya='+biaya+'&biayaKso='+biayaKso+'&biayaPasien='+biayaPasien+'&bayarPasien='+bayarPasien+'&statusVer=&act=save&idPasien='+document.getElementById('txtIdPasien').value+'&idKunj='+document.getElementById('txtKunjId').value+'&tabel=tindakan'+'&jnsRwt='+document.getElementById('cmbJnsRwt').value+'&IdUser='+cIdUser,'getNote','','GET');
	alert('success');
	gg.loadURL('r_tindakan_util.php?idPasien='+document.getElementById('txtIdPasien').value+'&idKunj='+document.getElementById('txtKunjId').value+'&jnsRwt='+document.getElementById('cmbJnsRwt').value,'','GET');
}

function hapusPelayanan(p){
	if(confirm('Anda yakin ingin menghapus pelayanan ini ?')){                        
	   //Request('koreksi_utils.php?pid='+document.getElementById('idt').value+'&act=delete&idKunj='+document.getElementById('txtKunjId').value+'&tabel=pelayanan'+'&jnsRwt='+document.getElementById('cmbJnsRwt').value,'getNote','','GET');
	g.loadURL('pelayanan_util.php?pid='+p+'&act=delete&IdUser=<?php echo $IdUser; ?>&idPasien='+document.getElementById('txtIdPasien').value+'&idKunj='+document.getElementById('txtKunjId').value+'&jnsRwt='+document.getElementById('cmbJnsRwt').value,'','GET');
	}
}

function hapusTindakanKamar(){
	if(confirm("Apakah anda yakin ingin menghapus data ini ?")){
	var id = document.getElementById('id_tk').value;
	var jnsRwt = document.getElementById('cmbJnsRwt').value;
	var cIdUser = "<?php echo $userId; ?>";
	//alert('koreksi_utils.php?id='+id+'&act=delete_kamar&idPasien='+document.getElementById('txtIdPasien').value+'&idKunj='+document.getElementById('txtKunjId').value+'&tabel=tindakan_kamar&IdUser='+cIdUser);	
	Request('koreksi_utils.php?id='+id+'&act=delete_kamar&idPasien='+document.getElementById('txtIdPasien').value+'&idKunj='+document.getElementById('txtKunjId').value+'&tabel=tindakan_kamar&IdUser='+cIdUser,'getNote','','GET');
	tk.loadURL('tindakan_kamar_util.php?idPasien='+document.getElementById('txtIdPasien').value+'&idKunj='+document.getElementById('txtKunjId').value+'&jnsRwt='+jnsRwt,'','GET');
	}
}
function hapusTindakan(p){
	var cIdUser = "<?php echo $userId; ?>";
	var id = document.getElementById('idt').value;
	if (p==1){
		alert("Tindakan Ini Sudah Dibayar Oleh Pasien, Jadi Tidak Boleh Dihapus !");
	}
	else if(confirm("Apakah anda yakin ingin menghapus data ini ?")){
		Request('koreksi_utils.php?id='+id+'&act=delete&idPasien='+document.getElementById('txtIdPasien').value+'&idKunj='+document.getElementById('txtKunjId').value+'&jnsRwt='+document.getElementById('cmbJnsRwt').value+'&tabel=tindakan&IdUser='+cIdUser,'getNote','','GET');	
		gg.loadURL('r_tindakan_util.php?idPasien='+document.getElementById('txtIdPasien').value+'&idKunj='+document.getElementById('txtKunjId').value+'&jnsRwt='+document.getElementById('cmbJnsRwt').value,'','GET');
	}
}
function saveTambahResep(){
	ambilCek();
	//alert(data);
		//alert('resep_util.php?grid=1&act=tambah&data='+data+'&idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&jnsRwt='+document.getElementById('cmbJnsRwt').value);	
	rsp.loadURL('resep_util.php?grid=1&act=tambah&data='+data+'&idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&jnsRwt='+document.getElementById('cmbJnsRwt').value,'','GET');
	document.getElementById('divTambahResep').popup.hide();	
	//rsp.loadURL('resep_util.php?grid=1&idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&jnsRwt='+document.getElementById('cmbJnsRwt').value,'','GET');
}
var data = '';
function ambilCek(){
	data='';
	var id_pelayanan=1234;
	for(var r = 1; r<=rr.getMaxRow();r++){ 
		if(document.getElementById('cekbok'+r).checked){
			//aidi = document.getElementById('cekbok'+r).value.split('|');
			data += document.getElementById('comboUnit').value+"**"+document.getElementById('cekbok'+r).value+"|";
			document.getElementById('cekbok'+r).checked=false;
		}
	}
}

function getPel4Combo(){
var sPel4Cmb="",tmp;
	//alert(g.getMaxRow());
	if (g.getMaxPage()>0){
		for (var r = 1; r<=g.getMaxRow();r++){
			tmp=g.getRowId(r).split("|");
			sPel4Cmb=sPel4Cmb+"<option value='"+tmp[0]+"'>"+g.cellsGetValue(r,3)+" - ("+g.cellsGetValue(r,7)+")"+"</option>";
		}
		//alert(sPel4Cmb);
	}
	return sPel4Cmb;
}

function tambahResep(){
	//alert('sdfd');
	document.getElementById('comboUnit').innerHTML=getPel4Combo();
	//isiCombo('unitResep',document.getElementById('cmbJnsRwt').value+','+document.getElementById('txtKunjId').value,unitAidi,'comboUnit');
	new Popup('divTambahResep',null,{modal:true,position:'center',duration:1});
	document.getElementById('divTambahResep').popup.show();	
	//alert(document.getElementById('txtKunjId').value+' '+document.getElementById('cmbJnsRwt').value);
	//rr.loadURL('resep_util.php?grid=3&tgl1='+document.getElementById('tanggal1').value+'&tgl2='+document.getElementById('tanggal2').value,'','GET');
	rr.loadURL('resep_util.php?grid=3&tgl1='+document.getElementById('tglrsp1').value,'','GET');
}
function hapusResep(p){
var tmp=rsp.getRowId(p+1).split("|");
//alert(p);
//alert(rsp.getRowId(p+1));
	/*if(document.getElementById('id_pel').value==''){
		alert('pilih data dulu');
	}
	else{*/
		if(confirm("Apakah anda yakin ingin menghapus data ini ?")){
			//alert('resep_util.php?grid=1&act=hapus&unit_id='+tmp[0]+'&user_id='+tmp[1]+'&no_kunjungan='+tmp[2]+'&no_pasien='+tmp[3]+'&no_penjualan='+tmp[4]+'&idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&jnsRwt='+document.getElementById('cmbJnsRwt').value);
			rsp.loadURL('resep_util.php?grid=1&act=hapus&unit_id='+tmp[0]+'&user_id='+tmp[1]+'&no_kunjungan='+tmp[2]+'&no_pasien='+tmp[3]+'&no_penjualan='+tmp[4]+'&idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&jnsRwt='+document.getElementById('cmbJnsRwt').value,'','GET');
			//rsp.loadURL('resep_util.php?grid=1&idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&jnsRwt='+document.getElementById('cmbJnsRwt').value,'','GET');
		}
	//}
}
function popupTindakan(p){
	if (p==1){
		alert("Tindakan Ini Sudah Dibayar Oleh Pasien, Jadi Tidak Boleh Diubah !");
	}else{
		new Popup('popTindakan',null,{modal:true,position:'center',duration:1});
		document.getElementById('popTindakan').popup.show();
		//document.getElementById('tglTind').value='';
	}
}
function popupTindakanKamar(){
	new Popup('popTindakanKamar',null,{modal:true,position:'center',duration:1});
	document.getElementById('popTindakanKamar').popup.show();
}
function popupPelayanan(){
	new Popup('popPelayanan',null,{modal:true,position:'center',duration:1});
	document.getElementById('popPelayanan').popup.show();	
}
function viewDetailResep(){
	new Popup('divPop',null,{modal:true,position:'center',duration:1});
	document.getElementById('divPop').popup.show();	
	//alert(document.getElementById('txtKunjId').value+' '+document.getElementById('cmbJnsRwt').value);
	b.loadURL('resep_util.php?grid=2&no_penjualan='+document.getElementById('no_penjualan').value+'&unit_id='+document.getElementById('aidi_unit').value,'','GET');
}
function zxc()
{
	//document.getElementById('trTinKamar').style.visibility="collapse";
}
function cxz1()
{
	var tanggal=document.getElementById('tanggal_masukK').value;
	document.getElementById('tanggal_masukK').value=tanggal+' 00:00:00';
	alert('jam belum di set');
}
function cxz2()
{
	var tanggal=document.getElementById('tanggal_keluarK').value;
	document.getElementById('tanggal_keluarK').value=tanggal+' 00:00:00';
	alert('jam belum di set');
}

function prosesReturn(){
	var fdata = '';
	var proses = false;
	for(var i=1;i<=gg.getMaxRow();i++){
		var temp = gg.getRowId(i);
		var idBayarTin = temp.split('|');
		if(document.getElementById('chk_'+idBayarTin[6])!=null){
			if(document.getElementById('chk_'+idBayarTin[6]).checked){
				fdata = idBayarTin[6]+"|"+fdata;
				proses = true;
			}
		}
	}
	for(var i=1;i<=tk.getMaxRow();i++){
		var temp = tk.getRowId(i);
		//var idBayarTin = temp.split('|');
		if(document.getElementById('chktk_'+temp)!=null){
			if(document.getElementById('chktk_'+temp).checked){
				fdata = temp+"|"+fdata;
				proses = true;
			}
		}
	}
	
	if(proses==false){
		alert('Pilih/cek tindakan yang ingin di retur');
		return false;
	}
	var no_return = document.getElementById('no_return').value;
	var tgl_return = document.getElementById('txtTglReturn').value;
	//alert("proses_return.php?retur=ya&no_return="+no_return+"&fdata="+fdata+"&tgl_return="+tgl_return);
	Request("proses_return.php?retur=ya&no_return="+no_return+"&fdata="+fdata+"&tgl_return="+tgl_return,'divSelesai','','GET',habisReturn,'noLoad');
}

function habisReturn(){
	var jnsRwt = document.getElementById('cmbJnsRwt').value;
	gg.loadURL('r_tindakan_util.php?idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&jnsRwt='+jnsRwt,'','GET');
	ggr.loadURL('return_pelayanan_util.php?idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&jnsRwt='+jnsRwt+'&tanggal='+document.getElementById('txtTglReturn').value,'','GET');
	tk.loadURL('return_tindakan_kamar_util.php?idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&jnsRwt='+jnsRwt,'','GET');
}

function habisHapus(){
	var jnsRwt = document.getElementById('cmbJnsRwt').value;
	gg.loadURL('r_tindakan_util.php?idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&jnsRwt='+jnsRwt,'','GET');
	ggr.loadURL('return_pelayanan_util.php?idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&jnsRwt='+jnsRwt+'&tanggal='+document.getElementById('txtTglReturn').value,'','GET');
	tk.loadURL('return_tindakan_kamar_util.php?idPasien='+dataPasien[0]+'&idKunj='+dataPasien[8]+'&jnsRwt='+jnsRwt,'','GET');
}

function prosesHapus(){
	var fdata = '';
	var proses = false;
	for(var i=1;i<=ggr.getMaxRow();i++){
		var temp = ggr.getRowId(i);
		var idBayarTin = temp.split('|');
		if(document.getElementById('chkr_'+idBayarTin[6]).checked){
			fdata = idBayarTin[6]+"|"+fdata;
			proses = true;
		}
		
	}
	if(proses==false){
		alert('Pilih/cek tindakan yang ingin di batalkan');
		return false;
	}
	//alert("proses_return.php?retur=tidak&fdata="+fdata);
	Request("proses_return.php?retur=tidak&fdata="+fdata,'divSelesai','','GET',habisHapus,'noLoad');
}

function selesaiReturn(){
	setTimeout("document.getElementById('divSelesai').innerHTML=''",'2000');
}

</script>
<div id="popTindakan" style="display:none; width:900px" class="popup">
<div id="divtindakan2" align="left" style="position:absolute; z-index:1; height: 230px; overflow: scroll; border:1px solid; display:none; background-color: #CCCCCC; left: 155px; top: -95px;"></div>
<input type="hidden" id="txtIdKelas" name="txtIdKelas" />
<input type="hidden" id="txtUnitId" name="txtUnitId" />
<input type="hidden" id="txtJnsUnitId" name="txtJnsUnitId" />
<input type="hidden" id="txtPelId" name="txtPelId" />
<!--input type="hidden" id="tanggall" name="tanggall" /-->
<input type="hidden" id="idt" name="idt" />
<table width="850" border="0" cellpadding="0" cellspacing="1" align="center" class="tabel">
    <tr>
        <td>&nbsp;</td>
        <td align="right">Tanggal :&nbsp;</td>
        <td colspan="2"><input id="tanggall" name="tanggall" size="10" class="txtcenter" readonly />&nbsp;<input type="button" id="ButtonTglTind" name="ButtonTglTind" value=" V " tabindex="23" class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('tanggall'),depRange,zxc);" /></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Tindakan :&nbsp;</td>
        <td colspan="2">
            <input name="tindakan_id" id="tindakan_id" type="hidden">
            <input id="txtTind" name="txtTind" size="100" onKeyUp="suggest1(event,this);" autocomplete="off" class="txtinput">
		  <!--input type="button" class="txtinput" value="cari" onclick="suggest1('cariTind',this);" /-->
	   </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Kelas :&nbsp;</td>
        <td><label id="tdKelas" class="txtinput" style="border:none;">non kelas</label></td>
        <td colspan="2" rowspan="4" valign="top">&nbsp;
		  <div id="div_an" style="display:none">
			 <form id="form_an" name="form_an">
				Dokter Anastesi:<br>
				<div id="dok_anastesi" style="overflow:auto;height:60px;width:350px;">
				</div>
			 </form>
		  </div>
	   </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Biaya :&nbsp;</td>
        <td><input id="txtBiaya" name="txtBiaya" type="text" size="10" class="txtinput" readonly="readonly" />
            <input id="txtBiayaAskes" name="txtBiayaAskes" type="hidden" size="10" class="txtinput" readonly="readonly" />
	   &nbsp;&nbsp;&nbsp;
	   Jumlah : <input id="txtQty" name="txtQty" type="text" size="3" class="txtcenter"/>
	   </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Tarif KSO :&nbsp;</td>
        <td><input id="tarifKSO" name="tarifKSO" size="10" class="txtinput"/></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Iur Bayar :&nbsp;</td>
        <td><input id="iurBayar" name="iurBayar" size="10" class="txtinput"/></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Bayar Pasien :&nbsp;</td>
        <td><input id="bayarPasien" name="bayarPasien" size="10" class="txtinput"/></td>
    </tr>
    <tr>
        <td colspan="3" align="center">
    </tr>
    <tr>
        <td colspan="3" align="center" height="28">
        <button id="sim" name="sim" value="simpan" type="button" style="cursor:pointer" class="popup_closebox" onClick="editTindakan()"><img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Simpan</button>��<button type="button" id="batal" name="batal" class="popup_closebox" onClick="gaksido()" style="cursor:pointer"><img src="../icon/back.png" width="20" align="absmiddle" />&nbsp;&nbsp;Batal</button>        
        </td>
    </tr>
</table>
</div>
<div id="popPelayanan" style="display:none; width:500px" class="popup">
<table width="480" border="0" cellpadding="0" cellspacing="1" align="center" class="tabel">
    <tr>
        <td>&nbsp;</td>
        <td align="right">Jenis Layanan :&nbsp;</td>
        <td colspan="2">
        	<input type="hidden" id="pelayanan_id" name="pelayanan_id" />
            <input id="jenis_layanan" name="jenis_layanan" size="40" class="txtinput" readonly>
	   </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Tempat Layanan :&nbsp;</td>
        <td><input id="tempat_layanan" name="tempat_layanan" size="40" class="txtinput" readonly></td>
        <td colspan="2" rowspan="4" valign="top">&nbsp;
	   </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Tempat Layanan Asal :&nbsp;</td>
        <td><input id="layanan_asal" name="layanan_asal" size="40" class="txtinput" readonly/></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Penjamin (KSO) :&nbsp;</td>
        <td><input type="hidden" id="penjamin_id" name="penjamin_id" /><input id="penjamin" name="penjamin" size="40" class="txtinput" readonly/></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Kelas :&nbsp;</td>
        <td><input type="hidden" id="kelas" name="kelas" size="10" class="txtinput"/>
        <select id="cmbPKelas" name="cmbPKelas" class="txtinput"></select>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Tanggal Datang :&nbsp;</td>
        <td><input id="tanggal_datang" name="tanggal_datang" size="10" class="txtcenter" readonly /></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Tanggal Pulang :&nbsp;</td>
        <td><input id="tanggal_pulang" name="tanggal_pulang" size="10" class="txtcenter" readonly />&nbsp;<input type="button" id="ButtonTglKunj" name="ButtonTglKunj" value=" V " tabindex="23" class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('tanggal_pulang'),depRange,zxc);" /></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Status Dilayani :&nbsp;</td>
        <td>
        <input id="status" type="hidden" name="status" size="10" class="txtinput"/>      
        <select id="cmbStatus" class="txtinput">
        	<option value="0">BELUM</option>
        	<option value="1">SUDAH</option>
        	<option value="2">PINDAH/KELUAR</option>
        </select> 
        </td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" align="center" height="28">
        <button id="sim" name="sim" value="simpan" type="button" style="cursor:pointer" class="popup_closebox" onClick="editPelayanan()"><img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Simpan</button>��<button type="button" id="batal" name="batal" class="popup_closebox" onClick="gaksido()" style="cursor:pointer"><img src="../icon/back.png" width="20" align="absmiddle" />&nbsp;&nbsp;Batal</button>        
        </td>
    </tr>
</table>
</div>
<div id="popTindakanKamar" style="display:none; width:500px" class="popup">
<div id="tanggalan"></div>

<table width="400" border="0" cellpadding="0" cellspacing="1" align="center" class="tabel">
    <tr>
        <td>&nbsp;</td>
        <td align="right">Jenis Layanan :&nbsp;</td>
        <td colspan="2">
        <input type="hidden" id="id_tk" name="id_tk" />
        <input type="hidden" id="id_unit" name="id_unit" />
        <input type="hidden" id="id_kelas" name="id_kelas" />
        <input type="hidden" id="id_kamar" name="id_kamar" />
            <input id="jenis_layananK" name="jenis_layananK" size="20" class="txtinput" readonly>
	   </td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Tempat Layanan :&nbsp;</td>
        <td><input id="tempat_layananK" name="tempat_layananK" size="20" class="txtinput" readonly></td>
        <td colspan="2" rowspan="4" valign="top">&nbsp;
	   </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Kamar :&nbsp;</td>
        <td>
        <select id="cmbKamarK" name="cmbKamarK" class="txtinput">
        </select>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Kelas :&nbsp;</td>
        <td>
        <select id="cmbKelasK" name="cmbKelasK" class="txtinput">
        </select>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Tanggal Masuk :&nbsp;</td>
        <td><input id="tanggal_masukK" name="tanggal_masukK" size="20" class="txtinput" onDblClick="gfPop.fPopCalendar(document.getElementById('tanggal_masukK'),depRange,cxz1);" />
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Tanggal Keluar :&nbsp;</td>
        <td><input id="tanggal_keluarK" name="tanggal_keluarK" size="20" class="txtinput" onDblClick="gfPop.fPopCalendar(document.getElementById('tanggal_keluarK'),depRange,cxz2);"/></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Status Out :&nbsp;</td>
        <td>
        <select id="cmbStatusOut" name="cmbStatusOut" class="txtinput">
        	<option value="0">Pulang</option>
            <option value="1">Pindah</option>
        </select>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Tarif RS :&nbsp;</td>
        <td>
        <input id="tarifRSK" name="tarifRSK" size="10" class="txtinput" readonly/>      
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Beban KSO :&nbsp;</td>
        <td><input id="bebanKSOK" name="bebanKSOK" size="10" class="txtinput"/></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td align="right">Beban Pasien :&nbsp;</td>
        <td><input id="beban_pasienK" name="beban_pasienK" size="10" class="txtinput"/></td>
    </tr>
    <tr>
        <td colspan="3" align="center" height="28">
        <button id="sim" name="sim" value="simpan" type="button" style="cursor:pointer" class="popup_closebox" onClick="editTindakanKamar()"><img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Simpan</button>��<button type="button" id="batal" name="batal" class="popup_closebox" onClick="gaksido()" style="cursor:pointer"><img src="../icon/back.png" width="20" align="absmiddle" />&nbsp;&nbsp;Batal</button>        
        </td>
    </tr>
</table>
</div>
<div id="getNote" style="display:none; width:900"></div>
<div id="divPop" class="popup" style="width:580px;height:270px;display:none;">
            <fieldset>
                <legend style="float:right">
                    <div style="float:right; cursor:pointer" class="popup_closebox">
                        <img alt="close" src="../icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
                </legend>
                <input type="hidden" id="id_penjualan" name="id_penjualan" />
                <input type="hidden" id="id_pel" name="id_pel" />
                <input type="hidden" id="no_pen" name="id_pen" />
                <input type="hidden" id="no_penjualan" name="no_penjualan" />
                <input type="hidden" id="aidi_unit" name="aidi_unit" />
                <table>
                    <tr>
                        <td>
                            <div id="gridbox_pop" style="width:550px; height:180px; background-color:white; "></div>
                            <br>
                            <div id="paging_pop" style="width:550px;"></div>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
<div id="divTambahResep" class="popup" style="width:1000px;height:500px;display:none;">
            <fieldset>
                <legend style="float:right">
                    <div style="float:right; cursor:pointer" class="popup_closebox">
                        <img alt="close" src="../icon/cancel.gif" height="16" width="16" align="absmiddle"/>Tutup</div>
                </legend>
                <table class="tabel">
                	<tr>
                    	<td>Tanggal :
                        	 <input id="tglrsp1" name="tglrsp1" size="10" class="txtinput" onClick="gfPop.fPopCalendar(document.getElementById('tanggal1'),depRange,tanggal1);" value="<?php echo date('d-m-Y'); ?>" />&nbsp;<input type="button" id="ButtonTglRsp" name="ButtonTglRsp" value=" V " tabindex="23" class="txtcenter" onClick="gfPop.fPopCalendar(document.getElementById('tglrsp1'),depRange,tanggal1);" /><!--s/d&nbsp;
                             <input id="tanggal2" name="tanggal2" size="10" class="txtinput" onClick="gfPop.fPopCalendar(document.getElementById('tanggal2'),depRange,tanggal1);" value="<?php echo date('d-m-Y'); ?>" /-->
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div id="gridbox_tambah_resep" style="width:970px; height:300px; background-color:white; "></div>
                            <br><br>
                            <div id="paging_tambah_resep" style="width:970px;"></div>
                        </td>
                    </tr>
                    <tr>
                    	<td>Pilih Unit Pelayanan :
                        <input type="hidden" id="unitAidi" name="unitAidi" />
                        <select id="comboUnit" name="comboUnit" class="txtinput">
                        </select>
                        </td>
                    </tr>
                    <tr>
                    	<td align="center">
                         <button onClick="saveTambahResep()" style="cursor:pointer" class="popup_closebox" >Save</button>
                        <td>
                    </tr>
                    
                </table>
            </fieldset>
</div>
<?php include("../laporan/report_form.php");?>
</body>
</html>

<script>
$(document).ready(function(){
	$("#btnShowTinDown").click(function(){
		 document.getElementById('btnShowTinDown').style.display='none';
		 $("#divTableTindakan").animate({height:330},"slow");
		 document.getElementById('btnShowTinUp').style.display='inline';
	});
	
	$("#btnShowTinUp").click(function(){
		 document.getElementById('btnShowTinUp').style.display='none';
		 $("#divTableTindakan").animate({height:0},"slow");
		 document.getElementById('btnShowTinDown').style.display='inline';
	});
	
	$("#btnShowTindKDown").click(function(){
		 document.getElementById('btnShowTindKDown').style.display='none';
		 $("#divTindakankamar_").animate({height:330},"slow");
		 document.getElementById('btnShowTindKUp').style.display='inline';
	});
	
	$("#btnShowTindKUp").click(function(){
		 document.getElementById('btnShowTindKUp').style.display='none';
		 $("#divTindakankamar_").animate({height:0},"slow");
		 document.getElementById('btnShowTindKDown').style.display='inline';
	});
	
	$("#btnTambah").click(function(){
		$("#list_return").hide(500);
		$("#form_return").show(500);
		
		//$("#list_return").slideUp("slow");
		//document.getElementById("list_return").style.display='none';
		//$("#form_return").slideDown(1000);
	});
	
	$("#btnBack").click(function(){
		parent.setIframe(675);
		$("#form_return").hide(500);
		$("#list_return").show(500);
		//$("#form_return").hide(500);
		//$("#form_return").slideUp(1000);
		//document.getElementById("list_return").style.display='block';
		rt.loadURL("list_retur_pelayanan_util.php?bln="+document.getElementById('cmbBulan').value+"&thn="+document.getElementById('cmbTahun').value,'','GET');
	});
});

function tanggal1(){
	//rr.loadURL('resep_util.php?grid=3&tgl1='+document.getElementById('tglrsp1').value+'&tgl2='+document.getElementById('tanggal2').value,'','GET');
	rr.loadURL('resep_util.php?grid=3&tgl1='+document.getElementById('tglrsp1').value,'','GET');
}
var b=new DSGridObject("gridbox_pop");
b.setHeader("DETAIL PENDAPATAN FARMASI");
b.setColHeader("NO,NAMA OBAT,QTY,NILAI,SUB TOTAL");
b.setIDColHeader(",obat_nama,,,");
b.setColWidth("30,200,30,80,80");
b.setCellAlign("center,left,center,center,right");
b.setCellHeight(20);
b.setImgPath("../icon");
b.setIDPaging("paging_pop");
b.baseURL("resep_util.php?grid=2");
b.Init();


var rr=new DSGridObject("gridbox_tambah_resep");
rr.setHeader("PENJUALAN APOTEK");
rr.setColHeader("&nbsp;,No,Tgl Act,No Penjualan,No Resep,No RM,Nama Pasien,Cara Bayar,Unit,Ruangan (Poli),Dokter,Shift,Total,Detail");
rr.setIDColHeader(",,,no_penjualan,no_resep,no_pasien,nama_pasien,,au.UNIT_NAME,,,,,");
rr.setColWidth("30,30,80,80,80,80,130,80,80,80,80,80,80,30");
rr.setCellAlign("center,center,center,center,center,center,left,center,center,center,left,center,center,center");
rr.setCellHeight(20);
rr.setImgPath("../icon");
rr.setIDPaging("paging_tambah_resep");
rr.baseURL("resep_util.php?grid=3");
rr.Init();

function goFilterAndSort(grd){		
	if(grd=="gridbox_tambah_resep"){			
		//rr.loadURL('resep_util.php?grid=3&tgl1='+document.getElementById('tanggal1').value+'&tgl2='+document.getElementById('tanggal2').value+'&filter='+rr.getFilter()+'&sorting='+rr.getSorting()+'&page='+rr.getPage(),'','GET');
		//alert('resep_util.php?grid=3&tgl1='+document.getElementById('tglrsp1').value+'&filter='+rr.getFilter()+'&sorting='+rr.getSorting()+'&page='+rr.getPage());
		rr.loadURL('resep_util.php?grid=3&tgl1='+document.getElementById('tglrsp1').value+'&filter='+rr.getFilter()+'&sorting='+rr.getSorting()+'&page='+rr.getPage(),'','GET');
	}
	else if(grd=='gridReturn'){
		rt.loadURL('list_retur_pelayanan_util.php?bln='+document.getElementById('cmbBulan').value+'&thn='+document.getElementById('cmbTahun').value+'&filter='+rt.getFilter()+'&sorting='+rt.getSorting()+'&page='+rt.getPage(),'','GET');
	}
}

var win = null;
function NewWindow(mypage,myname,w,h,scroll){
LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
settings =
'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
win = window.open(mypage,myname,settings)
}

var rt = new DSGridObject("gridReturn");
rt.setHeader("DATA RETUR PELAYANAN / TINDAKAN",false);
rt.setColHeader("No,Tanggal,No Retur,Tgl Kunjungan,No RM,Nama Pasien,Alamat");
rt.setIDColHeader(",,r.no_return,,p.no_rm,p.nama,p.alamat");
rt.setColWidth("30,70,70,70,70,150,200");
rt.setCellAlign("center,center,left,center,center,left,left");
rt.setCellType("txt,txt,txt,txt,txt,txt,txt");
rt.setCellHeight(20);
rt.setImgPath("../icon");
rt.setIDPaging("pagingReturn");
rt.attachEvent("onRowClick","ambilPel");
rt.onLoaded(konfirmasi);
rt.baseURL("list_retur_pelayanan_util.php?bln=<?php echo date('m'); ?>&thn=<?php echo date('Y'); ?>");
rt.Init();

function tambah(){
	fEdit=false;
	bukalock();
	setKosong();
	bukaW();
	//document.getElementById('form_return').style.height='100px';
	//parent.setIframe(document.body.scrollHeight);
	parent.setIframe(1520);
}

var temp_no_return='';
function ambilPel(){
	var no_rm=rt.cellsGetValue(rt.getSelRow(),5);
	var no_ret=rt.cellsGetValue(rt.getSelRow(),3);
	document.getElementById('no_rm').value=no_rm;
	document.getElementById('no_ret').value=no_ret;
	temp_no_return=no_ret;
	var sisipan=rt.getRowId(rt.getSelRow());
	document.getElementById('val').value=sisipan;
	var sisip = sisipan.split('|');
	document.getElementById('cmbJnsRwt').value = sisip[9];
	document.getElementById('txtTglReturn').value = rt.cellsGetValue(rt.getSelRow(),2);
}

var fEdit=false;
function buka(){
	fEdit=true;
	if(document.getElementById('no_rm').value=='' || document.getElementById('no_rm').value==null){
		alert('Pilih/klik data terlebih dahulu');
		return false;
	}
	var val = document.getElementById('val').value;
	//window.location = 'return_pelayanan.php?act=edit&no_rm='+document.getElementById('no_rm').value+'&no_return='+document.getElementById('no_return').value+'&val='+val;
	setPasien(val);
	//alert(temp_no_return);
	document.getElementById('no_ret').value=temp_no_return;
	document.getElementById('txtNoRm').value= document.getElementById('no_rm').value;
	document.getElementById('no_return').value= document.getElementById('no_ret').value;
	document.getElementById('txtTglAwal').value= dataPasien[4];
	document.getElementById('txtTglAkhir').value= dataPasien[4];
	//bukaW();
	
	var tinggi = parseInt(document.getElementById('divTableTindakan').style.height) + parseInt(document.getElementById('divTindakankamar_').style.height);
	//alert("tinggi="+tinggi);
	parent.setIframe(1520);
	$("#list_return").hide(500);
	$("#form_return").show(500);
	
	//document.getElementById('no_return').value='temp_no_return';
	//alert(temp_no_return);
	//alert(document.getElementById('no_ret').value);
	//document.getElementById('no_return').value=temp_no_return;
	//alert('adasdad='+document.getElementById('no_return').value);
	lock();
	//alert(document.getElementById('divTableTindakan').style.height);
	//alert(document.getElementById('divTindakankamar_').style.height);
}
function hapusReturn(){
	if(document.getElementById('no_ret').value=='' || document.getElementById('no_ret').value==null){
		alert('Pilih/klik data terlebih dahulu');
		return false;
	}
	if(confirm('Yakin ingin mengapus data ini ???')){
		rt.loadURL('list_retur_pelayanan_util.php?act=hapus&no_return='+document.getElementById('no_ret').value+'&bln='+document.getElementById('cmbBulan').value+'&thn='+document.getElementById('cmbTahun').value,'','GET');
	}
	rt.loadURL('list_retur_pelayanan_util.php?bln='+document.getElementById('cmbBulan').value+'&thn='+document.getElementById('cmbTahun').value,'','GET');
}

function bukaW(){
	
	//document.getElementById('form_header').style.display='none';
	//document.getElementById('list_return').style.display='none';
	//document.getElementById('form_return').style.display='block';
}

function tutupFormReturn(){
	document.getElementById('form_header').style.display='block';
	document.getElementById('list_return').style.display='block';
	document.getElementById('form_return').style.display='none';
	rt.loadURL("list_retur_pelayanan_util.php?bln="+document.getElementById('cmbBulan').value+"&thn="+document.getElementById('cmbTahun').value,'','GET');
}

function setKosong(){
	
	var p ="txtIdPasien*-**|*txtNama*-**|*txtTglLhr*-**|*txtUmur*-**|*txtSex*-**|*txtKunjId*-**|*txtPelId*-*";
	fSetValue(window,p);
	
	
	document.getElementById('txaAlamat').innerHTML=''; 
	Request('koreksi_utils.php','divKunjungan','','GET');
	gg.loadURL('r_tindakan_util.php?idPasien=0&idKunj=0&jnsRwt=0','','GET');
	ggr.loadURL('return_pelayanan_util.php?idPasien=0&idKunj=0&jnsRwt=0&tanggal='+document.getElementById('txtTglReturn').value,'','GET');
	tk.loadURL('return_tindakan_kamar_util.php?idPasien=0&idKunj=0&jnsRwt=0','','GET');
	
	document.getElementById('txtNoRm').value= '';
	document.getElementById('no_return').value= '';
	document.getElementById('cmbJnsRwt').disabled=true;
	Request('getNoReturn.php','temp_no','','GET',setNoRet,'noLoad');
	document.getElementById('txtTglAwal').value= document.getElementById('tgl_now').value;
	document.getElementById('txtTglAkhir').value= document.getElementById('tgl_now').value;	
}

function setNoRet(){
	document.getElementById('no_return').value = document.getElementById('temp_no').innerHTML;
	document.getElementById('txtNoRm').focus();	
}

function cetakReturn(){
	window.open('lap_return_pelayanan.php?idKunj='+dataPasien[8]+'&jnsRwt='+document.getElementById('cmbJnsRwt').value+'&tanggal='+document.getElementById('txtTglReturn').value);
}

function ganti(){
	//alert("list_retur_pelayanan_util.php?bln="+document.getElementById('cmbBulan').value+"&thn="+document.getElementById('cmbTahun').value);
	rt.loadURL("list_retur_pelayanan_util.php?bln="+document.getElementById('cmbBulan').value+"&thn="+document.getElementById('cmbTahun').value,'','GET');
}

document.getElementById('cmbBulan').value = '<?php echo date('m'); ?>';
document.getElementById('cmbTahun').value = '<?php echo date('Y'); ?>';
tutupFormReturn();

function lock(){
	document.getElementById('jdlForm').innerHTML = '<b>Edit Form</b>';
	document.getElementById('txtNoRm').disabled = true;
	//document.getElementById('cmbJnsRwt').disabled = true;
	document.getElementById('txtTglAwal').readOnly = true;
	document.getElementById('txtTglAkhir').readOnly = true;
	document.getElementById('txtTglReturn').readOnly = true;
	document.getElementById('tgl01').style.display = 'none';
	document.getElementById('tgl02').style.display = 'none';
	document.getElementById('tglR').style.display = 'none';
}

function bukalock(){
	document.getElementById('jdlForm').innerHTML = '<b>Input Form</b>';
	document.getElementById('txtNoRm').disabled = '';
	//document.getElementById('cmbJnsRwt').disabled = '';
	document.getElementById('txtTglAwal').readOnly = '';
	document.getElementById('txtTglAkhir').readOnly = '';
	document.getElementById('txtTglReturn').readOnly = '';
	document.getElementById('tgl01').style.display = 'inline';
	document.getElementById('tgl02').style.display = 'inline';
	document.getElementById('tglR').style.display = 'inline';
	
	document.getElementById('txtTglReturn').value = date_now;
}
function zxc(){
}
</script>
<?php
mysql_close($konek);
?>