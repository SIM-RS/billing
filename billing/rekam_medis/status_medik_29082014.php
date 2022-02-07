<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
$userId = $_SESSION['userId'];
$user_id_inacbg = $_SESSION['user_id_inacbg'];
if(!isset($userId) || $userId == ''){
    header('location:../index.php');
}
//echo $_SESSION['userId'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link rel="stylesheet" type="text/css" href="../theme/tab-view.css" />
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <link href="../theme/jquery-ui/css/ui-lightness/jquery-ui-1.9.2.custom.css" rel="stylesheet">
		<script src="../theme/jquery-ui/js/jquery-1.8.3.js"></script>
		<script src="../theme/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
        
        <!--dibawah ini diperlukan untuk menampilkan popup-->
        <link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        <script type="text/javascript" src="../theme/prototype.js"></script>
        <script type="text/javascript" src="../theme/effects.js"></script>
        <script type="text/javascript" src="../theme/popup.js"></script>
        <!--diatas ini diperlukan untuk menampilkan popup-->
        <title>Status Medik</title>
    </head>

    <!--<body onload="setJam();loadUlang();cekSentPar();">-->
	<body>
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
        
        
            <div id="divPilihan" style="display:none; width:300px" class="popup">
                <!--<img alt="close" src="../icon/close.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />-->
                <fieldset><legend id="lgnJudul"></legend>
                    <table border=0 width="280">
                        <tr>
                            <td width="100" align="right">Jenis :</td>
                            <td >&nbsp;<select id="cmbPilihan">
                            <option value="1">Keluar</option>
                            <option value="2">Dipinjam</option>
                            </select></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <input type="button" value="Simpan" onclick="simpan();document.getElementById('divPilihan').popup.hide();" />
                                <input type="button" value="Batal" class="popup_closebox" onclick="document.getElementById('txtFilter').select();"/>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </div>
            
			
			<div id="divpilih" style="display:none; width:415px" class="popup">
				<div style="float:right; cursor:pointer; margin-bottom:5px;" class="popup_closebox" onclick="batal()">
					<img alt="cancel" src="../icon/cancel.gif" height="16" width="16" align="absmiddle" />Tutup
				</div>
				<br>
                <!--<img alt="close" src="../icon/close.png" width="32" class="popup_closebox" style="float:right; cursor: pointer" />-->
                <fieldset><!--legend id="lgnJudul"></legend-->
                    <table border=0 width="380px">
						<tr id="radioCheck">
							<td width="38%">&nbsp;</td>
							<td ><input type="checkbox" name="dokterc" id="dokterc" onclick="edokter(this.checked)" /><label for="dokterc">Dokter</label></td>
						</tr>
                        <tr id="rwJnsLay">
							<td align="right" >Jenis Layanan</td>
							<td >&nbsp;<select name="JnsLayanan" id="JnsLayanan" tabindex="26" class="txtinput" onchange="isiCombo('TmpLayanan',this.value,'','',dokter);"></select>
							</td>
						</tr>
						<tr id="rwTmpLay">
							<td align="right" >Tempat Layanan</td>
							<td >&nbsp;<select name="TmpLayanan" id="TmpLayanan" tabindex="27" class="txtinput" onchange='dokter()'></select></td>
						</tr>
						<tr id="checkDok" style="display:none">
							<td align="right">Dokter</td>
							<td>
								&nbsp;<select name="cmbDok" id="cmbDok" tabindex="38" style="width:150px; font-size:12px;" class="txtinputreg" ></select><input type="checkbox" id="chkDokterPengganti" value="1" onChange="gantiDokter('cmbDokDiag',this.checked);" tabindex=""/><label for="chkDokterPengganti">Lainnya</label>
							</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
                        <tr>
                            <td colspan="2" align="center">
								<input type="hidden" id="statusKlik" name="statusKlik"/>
                                <input type="button" value="Simpan" onclick="simpan(document.getElementById('statusKlik').value);document.getElementById('divpilih').popup.hide();" />
                                <input type="button" value="Batal" class="popup_closebox" onclick="batal()"/>
                            </td>
                        </tr>
						<style type="text/css">
							#kotak{
								width:10px;
								height:10px;
								display:inline-block;
							}
						</style>
                    </table>
                </fieldset>
            </div>
			
            <input type="hidden" id="kunjungan_id" name="kunjungan_id" />
            <input type="hidden" id="status_medik" name="status_medik" />
            <input type="hidden" id="pasien_id" name="pasien_id" />
            <?php
            include("../koneksi/konek.php");
            include("../header1.php");
            $date_now=gmdate('d-m-Y',mktime(date('H')+7));
            $time_now=gmdate('H:i:s',mktime(date('H')+7));
            $tglGet=$_REQUEST['tgl'];
            ?>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#008484"  align="center" class="hd2">
                <tr>
                    <td height="30">&nbsp;FORM STATUS MEDIK</td>
					<td align="right">&nbsp;</td>
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
                                        ?>"/>&nbsp;<input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="txtcenter" onclick="gfPop.fPopCalendar(document.getElementById('txtTgl'),depRange,saring);"/>
                                    </td>
                                </tr>
                              
                            </table>
                        </fieldset>
                    </td>
                    <td align="center">&nbsp;
                    <button id="btnKeluar" name="btnKeluar" style="cursor:pointer" value="1" onclick="popS(this.value)">Keluar</button>&nbsp;&nbsp;&nbsp;<button id="btnPinjam" name="btnPinjam" style="cursor:pointer" value="2" onclick="popS(this.value)">Pinjam</button>&nbsp;&nbsp;&nbsp;<button id="btnMasuk" name="btnMasuk" style="cursor:pointer" value="3" onclick="simpan(this.value)">Masuk / Kembali</button>    
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">
                        <fieldset>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                <tr id="trDilayani">
                                    <td align="left"><span style="padding-left:20px">
                                        No. RM :
                                        <input id="txtFilter" name="txtFilter" size="8" maxlength="8" class="txtinput" onkeyup="filterNoRM(event,this)"/>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <div id="gridbox" style="width:925px; height:270px; background-color:white; overflow:hidden;"></div>
                                        <div id="paging" style="width:925px;"></div>
                                    </td>
                                </tr>
								<tr>
									<td>
										<div id="kotak" style="background:green; margin-right:10px;"></div>Buku status telah keluar <br />
										<div id="kotak" style="background:blue; margin-right:10px;"></div>Buku status sedang dipinjam <br />
										<div id="kotak" style="background:brown; margin-right:10px;"></div>Buku status telah kembali/masuk <br />
										<div id="kotak" style="background:black; margin-right:10px;"></div>Buku status belum dilayani <br />
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

   

	</body>
</html>
<script type="text/JavaScript" language="JavaScript">
	isiCombo('JnsLayanan','','','',showTmpLay);
	function showTmpLay(){
		isiCombo('TmpLayanan',document.getElementById('JnsLayanan').value,'','',dokter);
	}
	
	function popS(stat){
		if(stat==1){
			document.getElementById('radioCheck').style.display = 'none';
			document.getElementById('checkDok').style.display = 'none';
		} else if(stat==2){
			document.getElementById('radioCheck').style.display = 'table-row';
			document.getElementById('checkDok').style.display = 'none';
		}
		document.getElementById('statusKlik').value = stat;
		new Popup('divpilih',null,{modal:true,position:'center',duration:1});
        document.getElementById('divpilih').popup.show();
	}
	
	function edokter(par){
		if(par==true){
			document.getElementById('checkDok').style.display = 'table-row';
		} else {
			document.getElementById('checkDok').style.display = 'none';
		}
	}
	
	//onChange="cJPasien();" onKeyUp="cJPasien();"
	function dokter(){
		//alert(document.getElementById('TmpLayanan').value);
		document.getElementById('chkDokterPengganti').checked = false;
		isiCombo('cmbDok',document.getElementById('TmpLayanan').value);
	}
	function isiCombo(id,val,defaultId,targetId,evloaded){
		if(targetId=='' || targetId==undefined)
		{
			targetId=id;
		}
		//alert('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId);
		Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
	}
	function gantiDokter(comboDokter,statusCek){
		if(statusCek==true){
			isiCombo('cmbDokPengganti',document.getElementById('TmpLayanan').value,'','cmbDok');
		}
		else{
			isiCombo('cmbDok',document.getElementById('TmpLayanan').value,'','cmbDok');
		}
		//document.getElementById('chkDokterPenggantiDiag').checked = document.getElementById('chkDokterPenggantiResep').checked = document.getElementById('chkDokterPenggantiTind').checked = document.getElementById('chkDokterPenggantiRujukUnit').checked = document.getElementById('chkDokterPenggantiRujukRS').checked = statusCek;
	}

	var tgl;
	function showGrid(){
		a1 = new DSGridObject("gridbox");
		a1.setHeader("DATA KUNJUNGAN PASIEN");
		a1.setColHeader("NO,NO RM,NAMA,L/P,PENJAMIN,ALAMAT,T.LHR,NAMA ORTU,TUJUAN,DOKTER");
		a1.setIDColHeader(",no_rm,nama,,namakso,alamat,,nama_ortu,,");
		a1.setColWidth("30,70,200,30,200,250,70,150,150,150");
		a1.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt");
		a1.setCellAlign("center,center,left,center,center,left,center,left,left,left");
		a1.setCellHeight(20);
		a1.setImgPath("../icon");
		a1.setIDPaging("paging");
		a1.attachEvent("onRowClick","ambilDataPasien");
		a1.onLoaded(ambilDataPasien);
		a1.baseURL("status_medik_utils.php?grd=true&tgl="+document.getElementById('txtTgl').value);
		a1.Init();
	}
	
	function ambilDataPasien(){
		document.getElementById('txtFilter').select();
		document.getElementById('btnKeluar').disabled = false;
		document.getElementById('btnPinjam').disabled = false;
		document.getElementById('btnMasuk').disabled = false;
		var sisip = a1.getRowId(a1.getSelRow()).split('|');
		if(sisip[1]==1){
			document.getElementById('btnKeluar').disabled = true;
			document.getElementById('btnPinjam').disabled = true;
		} else if(sisip[1]==3){
			document.getElementById('btnMasuk').disabled = true;
		} else if(sisip[1]==2){
			document.getElementById('btnKeluar').disabled = true;
			document.getElementById('btnPinjam').disabled = true;
			document.getElementById('btnMasuk').disabled = false;
		} else {
			document.getElementById('btnKeluar').disabled = false;
			document.getElementById('btnPinjam').disabled = false;
			document.getElementById('btnMasuk').disabled = false;
		}
		document.getElementById('kunjungan_id').value=sisip[0];
		document.getElementById('status_medik').value=sisip[1];
		document.getElementById('pasien_id').value=sisip[2];
	}
	
	function saring(){
		var tgl=document.getElementById('txtTgl').value;
		var no_rm=document.getElementById('txtFilter').value;
		var url = "status_medik_utils.php?grd=true&tgl="+tgl+"&no_rm="+no_rm+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage();
		//alert(url);
		a1.loadURL(url,"","GET");
	}
	
	function batal(){
		document.getElementById('dokterc').checked = false;
		document.getElementById('statusKlik').value="";
		document.getElementById('chkDokterPengganti').checked = false;
		isiCombo('JnsLayanan','','','',showTmpLay);
	}
	
	function simpan(sts){
		if(confirm('Yakin ?')){
			var statusKeluar = sts;
			var tgl=document.getElementById('txtTgl').value;
			var no_rm=document.getElementById('txtFilter').value;
			var pasien_id=document.getElementById('pasien_id').value;
			var dokcek = document.getElementById('dokterc').checked;
			var pengganti = document.getElementById('chkDokterPengganti').checked;
			if(pengganti == true){
				var a = 1;
			} else {
				var a = 0;
			}
			var dokterId = document.getElementById('cmbDok').value;
			var Tmp_Lay = document.getElementById('TmpLayanan').value;
			var Jns_Lay = document.getElementById('JnsLayanan').value;
			
			var parLayanan = '&jnsLayanan='+Jns_Lay+'&tmpLayanan='+Tmp_Lay;
			var parDokter = '';
			if(sts==2){
				parDokter = '&dokterId='+dokterId+'&dokcek='+dokcek+'&pengganti='+a;
			}
			
			var url = "status_medik_utils.php?act=save&grd=true&tgl="+tgl+"&no_rm="+no_rm+"&pasien_id="+pasien_id+"&statusKeluar="+statusKeluar+"&kunjungan_id="+document.getElementById('kunjungan_id').value+"&status_medik="+document.getElementById('status_medik').value+'&userId=<?php echo $userId; ?>'+parLayanan+parDokter;
			//alert(url);
			a1.loadURL(url,"","GET");
		}
		//alert(document.getElementById('dokterc').checked);
		document.getElementById('dokterc').checked = false;
		document.getElementById('statusKlik').value="";
		document.getElementById('chkDokterPengganti').checked = false;
		isiCombo('JnsLayanan','','','',showTmpLay);
	}
	
	setInterval('saring()',10000);
	
	function filterNoRM(ev,par){
		if(ev.which==13){
			if(isNaN(par.value) == true || par.value == ''){
				alert("Masukan Nomor Rekam Medis Dengan Benar !");
				//return;
			}
			
			var tgl=document.getElementById('txtTgl').value;
			var no_rm=document.getElementById('txtFilter').value;
			var url = "status_medik_utils.php?act=view&grd=true&tgl="+tgl+"&no_rm="+no_rm;
			a1.loadURL(url,"","GET");
		}
	}
	
	function pilihKeluar(){
		new Popup('divPilihan',null,{modal:true,position:'center',duration:1});
		document.getElementById('divPilihan').popup.show();	
	}

	function goFilterAndSort(grd){
		var tgl=document.getElementById('txtTgl').value;
		var no_rm=document.getElementById('txtFilter').value;
		var url = "status_medik_utils.php?grd=true&tgl="+tgl+"&no_rm="+no_rm;
		
		if (grd=="gridbox"){		
			url="status_medik_utils.php?grd=true&tgl="+tgl+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage();
			a1.loadURL(url,"","GET");
		}
	}

	showGrid();
	
	function konfirmasi(key,val){
		if(key=='Error'){
			if(val=='transfer'){
				
			}
		}else{
			if(val=='view'){
				
			}
		}
	}
			
</script>
	
