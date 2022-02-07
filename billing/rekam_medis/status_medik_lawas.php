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

if($user_id_inacbg == '' || $user_id_inacbg == '0'){
    echo "<script>alert('User Login anda blm ada link ke user inacbg, hubungi petugas IT');</script>";
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
                    <button id="btnKeluar" name="btnKeluar" style="cursor:pointer" value="1" onclick="simpan(this.value)">Keluar</button>&nbsp;&nbsp;&nbsp;<button id="btnPinjam" name="btnPinjam" style="cursor:pointer" value="2" onclick="simpan(this.value)">Pinjam</button>&nbsp;&nbsp;&nbsp;<button id="btnMasuk" name="btnMasuk" style="cursor:pointer" value="3" onclick="simpan(this.value)">Masuk / Kembali</button>    
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

	var tgl;
	function showGrid(){
		a1 = new DSGridObject("gridbox");
		a1.setHeader("DATA KUNJUNGAN PASIEN");
		a1.setColHeader("NO,NO RM,NAMA,L/P,PENJAMIN,ALAMAT,T.LHR,NAMA ORTU");
		a1.setIDColHeader(",no_rm,nama,,namakso,alamat,,nama_ortu");
		a1.setColWidth("30,70,200,30,200,250,70,150");
		a1.setCellType("txt,txt,txt,txt,txt,txt,txt,txt");
		a1.setCellAlign("center,center,left,center,center,left,center,left");
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
		var sisip = a1.getRowId(a1.getSelRow()).split('|');
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
	
	function simpan(sts){
		if(confirm('Yakin ?')){
			var statusKeluar = sts;
			var tgl=document.getElementById('txtTgl').value;
			var no_rm=document.getElementById('txtFilter').value;
			var pasien_id=document.getElementById('pasien_id').value;
			
			var url = "status_medik_utils.php?act=save&grd=true&tgl="+tgl+"&no_rm="+no_rm+"&pasien_id="+pasien_id+"&statusKeluar="+statusKeluar+"&kunjungan_id="+document.getElementById('kunjungan_id').value+"&status_medik="+document.getElementById('status_medik').value+'&userId=<?php echo $userId; ?>';
			a1.loadURL(url,"","GET");
		}
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
	
