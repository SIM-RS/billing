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
        <title>Kelengkapan Berkas</title>
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
            <input type="hidden" id="pelayanan_id" name="pelayanan_id" />
            <input type="hidden" id="formulir_id" name="formulir_id" />
            <span id="spanSukRM" style="display:none"></span>
<?php
            include("../koneksi/konek.php");
            include("../header1.php");
            $date_now=gmdate('d-m-Y',mktime(date('H')+7));
            $time_now=gmdate('H:i:s',mktime(date('H')+7));
            $tglGet=$_REQUEST['tgl'];
            ?>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#008484"  align="center" class="hd2">
                <tr>
                    <td height="30">&nbsp;FORM CEK LIST KELENGKAPAN BERKAS</td>
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
                                <tr>
                                    <td>
                                        Jenis Layanan
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <select id="cmbJnsLay" class="txtinput" onchange="saring();trTgl();" >
                                            <option value="0">RAWAT JALAN</option>
                                            <option value="1">RAWAT INAP</option>
                                            </select>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                    <td align="center">&nbsp;
                        
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">
                        <fieldset>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                <tr id="trDilayani"> 
                            <td align="left" colspan="2"><span style="padding-left:20px">
                                        No. RM :
                                        <input id="txtFilter" name="txtFilter" size="10" class="txtinput" onkeyup="filterNoRM(event,this)"/>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" colspan="2">
                                        <div id="gridbox" style="width:925px; height:270px; background-color:white; overflow:hidden;"></div>
                                        <div id="paging" style="width:925px;"></div>
                                    </td>
                                </tr>
                                <tr>
                                	<td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                	<td width="50%" style="vertical-align:top" align="left">
                                    	<div id="gridbox2" style="width:450px; height:270px; background-color:white; overflow:hidden;"></div>
                                        <div id="paging2" style="width:450px;"></div>
                                    </td>
                              <td width="50%" style="vertical-align:top" align="right">
                                    	<div id="gridbox3" style="width:450px; height:270px; background-color:white; overflow:hidden;"></div>
                                        <div id="paging3" style="width:450px;"></div>
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

		var tgl, cmbJnsLay;
		function showGrid(){
            a1 = new DSGridObject("gridbox");
            a1.setHeader("DATA KUNJUNGAN PASIEN");
            a1.setColHeader("NO,NO RM,NAMA,L/P,PENJAMIN,NO SJP,TEMPAT PELAYANAN,ALAMAT,T.LHR,NAMA ORTU");
            a1.setIDColHeader(",no_rm,nama,,namakso,no_sjp,unit,alamat,,nama_ortu");
            a1.setColWidth("30,70,200,30,200,150,140,250,70,150");
			a1.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt");
            a1.setCellAlign("center,center,left,center,center,center,center,left,center,left");
            a1.setCellHeight(20);
            a1.setImgPath("../icon");
            a1.setIDPaging("paging");
            a1.attachEvent("onRowClick","ambilDataPasien");
            //a1.attachEvent("onRowDblClick","editNoSJP");
            a1.onLoaded(ambilDataPasien);
			a1.baseURL("ceklist_berkas_utils.php?grd=true&tgl="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbJnsLay').value);
            a1.Init();
			
			a2 = new DSGridObject("gridbox2");
            a2.setHeader("JENIS FORMULIR REPORT RM");
            a2.setColHeader("NO,NAMA");
            a2.setIDColHeader(",");
            a2.setColWidth("50,300");
			a2.setCellType("txt,txt");
            a2.setCellAlign("center,left");
            a2.setCellHeight(20);
            a2.setImgPath("../icon");
            a2.setIDPaging("paging2");
            a2.attachEvent("onRowClick","ambilDataReportRM");
            //a1.attachEvent("onRowDblClick","editNoSJP");
            a2.onLoaded(ambilDataReportRM);
			a2.baseURL("ceklist_berkas_utils.php?grd2=true&tgl="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbJnsLay').value);
            a2.Init();
			
			a3 = new DSGridObject("gridbox3");
            a3.setHeader("DATA REPORT RM");
            a3.setColHeader("NO,,KODE,NAMA");
            a3.setIDColHeader(",,,");
            a3.setColWidth("30,30,100,250");
			a3.setCellType("txt,chk,txt,txt");
            a3.setCellAlign("center,center,center,left");
            a3.setCellHeight(20);
            a3.setImgPath("../icon");
            a3.setIDPaging("paging3");
            a3.attachEvent("onRowClick","cekList");
            //a1.attachEvent("onRowDblClick","editNoSJP");
            a3.onLoaded(cekAnalisa);
			a3.baseURL("ceklist_berkas_utils.php?grd3=true&tgl="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbJnsLay').value);
            a3.Init();
		}
		
		function cekAnalisa(){
			/*
			var sdh_analisa = a3.getRowId(a3.getSelRow()).split('|');
			if(sdh_analisa[1]=='1'){
				a3.obj.childNodes[0].childNodes[parseInt(a3.getSelRow())-1].childNodes[1].childNodes[0].checked
			}
			*/
		}
		
		function cekList(){
			
			var dicentang = a3.getRowId(a3.getSelRow()).split('|');
			dicentang = dicentang[1];
			
			var act;
			var idPel = document.getElementById('pelayanan_id').value;
			var idReport = a3.getRowId(parseInt(a3.getSelRow()-1)+1).split('|');
			
			if(a3.obj.childNodes[0].childNodes[parseInt(a3.getSelRow())-1].childNodes[1].childNodes[0].checked){
				act = 'tambah';
			}
			else{
				act = 'hapus';
			}
			Request('ceklist_berkas_utils.php?grd3=false&act='+act+'&id='+idReport[0]+'&pelayanan_id='+idPel+'&formulir_id='+document.getElementById('formulir_id').value+'&userId=<?php echo $userId; ?>','spanSukRM','','GET');
		}
		
		function ambilDataReportRM(){
			var sisip = a2.getRowId(a2.getSelRow());
			document.getElementById('formulir_id').value=sisip;
			a3.loadURL("ceklist_berkas_utils.php?grd3=true&parent_id="+sisip+'&pelayanan_id='+document.getElementById('pelayanan_id').value,'','GET');
		}
		
		function ambilDataPasien(){
			var data = a1.getRowId(a1.getSelRow()).split('|');
			//alert(data[2]);
			document.getElementById('kunjungan_id').value=data[0];
			document.getElementById('status_medik').value=data[1];
			document.getElementById('pelayanan_id').value=data[2];
			
			
			if(document.getElementById('pelayanan_id').value==''){
				a2.loadURL("ceklist_berkas_utils.php?grd2=true&pelayanan_id=0",'','GET');	
			}
			else{
				a2.loadURL("ceklist_berkas_utils.php?grd2=true&pelayanan_id="+document.getElementById('pelayanan_id').value,'','GET');
			}
		}
		
		function saring(){
			var tgl=document.getElementById('txtTgl').value;
			var tmpLay=document.getElementById('cmbJnsLay').value;
			var no_rm=document.getElementById('txtFilter').value;
			var url = "ceklist_berkas_utils.php?grd=true&tgl="+tgl+"&tmpLay="+tmpLay+"&no_rm="+no_rm;
			//alert(url);
			a1.loadURL(url,"","GET");
		}
		
		setInterval('saring()',5000);
		
		function filterNoRM(ev,par){
			if(ev.which==13){
				if(isNaN(par.value) == true || par.value == ''){
					alert("Masukan Nomor Rekam Medis Dengan Benar !");
					return;
				}
				
				var tgl=document.getElementById('txtTgl').value;
				var tmpLay=document.getElementById('cmbJnsLay').value;
				var no_rm=document.getElementById('txtFilter').value;
				var url = "ceklist_berkas_utils.php?act=view&grd=true&tgl="+tgl+"&tmpLay="+tmpLay+"&no_rm="+no_rm;
				a1.loadURL(url,"","GET");
			}
		}
		
	
		function goFilterAndSort(grd){
			var tgl=document.getElementById('txtTgl').value;
			var tmpLay=document.getElementById('cmbJnsLay').value;
			var no_rm=document.getElementById('txtFilter').value;
			var url = "ceklist_berkas_utils.php?grd=true&tgl="+tgl+"&tmpLay="+tmpLay+"&no_rm="+no_rm;
			//alert(url);
			//a1.loadURL(url,"","GET");
			
			
			if (grd=="gridbox"){		
				url="ceklist_berkas_utils.php?grd=true&tgl="+tgl+"&tmpLay="+tmpLay+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage();
				a1.loadURL(url,"","GET");
			}
		}

		showGrid();
		
		function konfirmasi(key,val){
			document.getElementById('txtFilter').select();
			var sisip = a1.getRowId(a1.getSelRow()).split('|');
			document.getElementById('kunjungan_id').value=sisip[0];
			document.getElementById('status_medik').value=sisip[1];
			
			if(key=='Error'){
				if(val=='transfer'){
					
				}
			}else{
				if(val=='view'){
				
				}
			}
		}
		
		function trTgl(){
			if(document.getElementById('cmbJnsLay').value=='0'){
				document.getElementById('trTgl').style.visibility='visible';
			}
			else{
				document.getElementById('trTgl').style.visibility='collapse';
			}	
		}
		trTgl();		
	</script>
	
