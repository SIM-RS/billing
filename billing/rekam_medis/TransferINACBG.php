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
        <!--<script type="text/javascript" src="../theme/js/tab-view.js"></script>-->
        <link type="text/css" rel="stylesheet" href="../theme/mod.css" />
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/dsgrid.js"></script>
        <script type="text/JavaScript" language="JavaScript" src="../theme/js/mod.js"></script>
        <!--script src="../theme/dhtmlxcalendar.js" type="text/javascript"></script-->
        <script type="text/javascript" src="../theme/js/ajax.js"></script>
        <!--dibawah ini diperlukan untuk menampilkan menu dropdown-->
		<!--<script language="JavaScript" src="../theme/js/mm_menu.js"></script>
        <script language="JavaScript" src="../theme/js/dropdown.js"></script>-->

        <!--dibawah ini diperlukan untuk menampilkan popup-->
        <!--<link rel="stylesheet" type="text/css" href="../theme/popup.css" />
        <script type="text/javascript" src="../theme/prototype.js"></script>
        <script type="text/javascript" src="../theme/effects.js"></script>
        <script type="text/javascript" src="../theme/popup.js"></script>-->
        <!--diatas ini diperlukan untuk menampilkan popup-->
        <link href="../theme/jquery-ui/css/ui-lightness/jquery-ui-1.9.2.custom.css" rel="stylesheet">
		<script src="../theme/jquery-ui/js/jquery-1.8.3.js"></script>
		<script src="../theme/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
        <script>
		$(function() {	
		$( "#dialog" ).dialog({
			closeText: "hide",
			autoOpen: false,
			width: 400
		});
		
		$( "#fno_sjp" ).dialog({
			modal: true,
			autoOpen: false,
			width: 400,
			buttons: [{
						text: "Update",
						click: function() {
							updateNoSJP();
							$( this ).dialog( "close" );
						}
					 },
					 {
						text: "Cancel",
						click: function() {
							$( this ).dialog( "close" );
							document.getElementById('txtNoSJP').value='';
							document.getElementById('kunjungan_id').value='';
						}
					 }
					 ]
		});

		// Link to open the dialog
		/*
		$( "#updtPas" ).click(function( event ) {
			$( "#dialog" ).dialog( "open" );
			//event.preventDefault();
		});
		*/
		
		$( "#progressbar" ).progressbar({
            value: 10
        });

		});
		</script>
        <style>
   			.ui-progressbar .ui-progressbar-value { background-image: url(pbar-ani.gif); }
		</style>
        <title>Transfer INACBG</title>
    </head>

    <!--<body onload="setJam();loadUlang();cekSentPar();">-->
	<body>
    <div id="dialog" title="Status Transfers">
    	<div align="center">
        <br />
    	<div id="progressbar"></div>
        <span id="spnStatus">Tranfering 0/0 data ...</span>
        </div>
        <br />
        <span id="spnInfo">[1234567] Muhammad</span>
	</div>
    <div id="fno_sjp" title="Edit No SJP">
    	<span id="spn_sjp" style="display:none"></span>
        <div align="center">
        <input type="hidden" id="kunjungan_id" name="kunjungan_id" />
        No SJP : <input type="text" id="txtNoSJP" name="txtNoSJP" size="30" />
        </div>
	</div>
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
        <input name="fdata" id="fdata" type="hidden" value=""/>
        <div id="divKunj" align="center" style="display:block;">
            <?php
            include("../koneksi/konek.php");
            include("../header1.php");
            $date_now=gmdate('d-m-Y',mktime(date('H')+7));
            $time_now=gmdate('H:i:s',mktime(date('H')+7));
            $tglGet=$_REQUEST['tgl'];
            ?>
            <table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#008484"  class="hd2">
                <tr>
                    <td height="30">&nbsp;FORM TRANSFER INACBG</td>
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
                                        <select id="cmbJnsLay" class="txtinput" onchange="saring()" >
                                            <option value="0">RAWAT JALAN</option>
                                            <option value="1">RAWAT INAP</option>
                                            </select>
                                    </td>
                                </tr>
                                <!--tr>
                                    <td>&nbsp;
                                        
                                    </td>
                                    <td>&nbsp;</td>
                                    <td><input type="text" id="txtId" name="txtId" />&nbsp;
                                        
                                    </td>
                                </tr-->
                            </table>
                        </fieldset>
                    </td>
                    <td align="center">
                        <table>
                            <tr>
                                <td>
                                    <!--input type="button" id="dtlPas" name="dtlPas" value="Detail Pelayanan Pasien" class="tblBtn" disabled="disabled" onclick="detail();" style="width:250px;height:40px;"/-->
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <button id="updtPas" name="updtPas" class="tblBtn" onclick="updatePas()" style="width:250px;height:40px;">
                                        Transfer >> INA-CBG's
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
                                        Status Transfer :
                                        <select id="cmbTransfer" onchange="saring();cekStatus(this.value)" class="txtinput">
                                            <option value="0" selected="selected">BELUM</option>
                                            <option value="1">SUDAH</option>
                                            <!--option value="">SEMUA</option-->
                                        </select>
                                        <span style="padding-left:20px">
                                        No. RM :
                                        <input id="txtFilter" name="txtFilter" size="10" class="txtcenter" onkeyup="filterNoRM(event,this)"/>
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

		var tgl, cmbJnsLay;
		 function showGrid(){
            a1 = new DSGridObject("gridbox");
            a1.setHeader("DATA KUNJUNGAN PASIEN");
            a1.setColHeader("NO,<input id='chkAll' type='checkbox' onclick='ChkAllKlik();' />,NO RM,NAMA,L/P,PENJAMIN,NO SJP,TEMPAT PELAYANAN,ALAMAT,T.LHR,NAMA ORTU");
            a1.setIDColHeader(",,no_rm,nama,,namakso,no_sjp,unit,alamat,,nama_ortu");
            a1.setColWidth("30,30,70,200,30,200,150,140,250,70,150");
			a1.setCellType("txt,chk,txt,txt,txt,txt,txt,txt,txt,txt,txt");
            a1.setCellAlign("center,center,center,left,center,center,center,center,left,center,left");
            a1.setCellHeight(20);
            a1.setImgPath("../icon");
            a1.setIDPaging("paging");
            a1.attachEvent("onRowClick","ambilDataPasien");
            a1.attachEvent("onRowDblClick","editNoSJP");
            a1.onLoaded(konfirmasi);
			//alert("TransferINACBG_utils.php?grd=true&tgl="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbJnsLay').value+"&dilayani="+document.getElementById('cmbTransfer').value);
			a1.baseURL("TransferINACBG_utils.php?grd=true&tgl="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbJnsLay').value+"&dilayani="+document.getElementById('cmbTransfer').value);
            a1.Init();
		}
		
		function ambilDataPasien(){
			var sisip = a1.getRowId(a1.getSelRow());
			sisip = sisip.split('|');
			document.getElementById('txtNoSJP').value=a1.cellsGetValue(a1.getSelRow(),7);
			document.getElementById('kunjungan_id').value=sisip[4];			
		}
		
		function editNoSJP(){
			$( "#fno_sjp" ).dialog({
					modal: true,
					autoOpen: false,
					width: 400
				});
			$( "#fno_sjp" ).dialog( "open" );	
		}
		
		function updateNoSJP(){
			var kunj_id=document.getElementById('kunjungan_id').value;
			var no_sjp=document.getElementById('txtNoSJP').value;
			
			var tgl=document.getElementById('txtTgl').value;
			var tmpLay=document.getElementById('cmbJnsLay').value;
			var dilayani=document.getElementById('cmbTransfer').value;
			
			var url = "TransferINACBG_utils.php?act=updateNoSJP&grd=true&tgl="+tgl+"&tmpLay="+tmpLay+"&dilayani="+dilayani+"&kunj_id="+kunj_id+"&no_sjp="+no_sjp;
			//a1.loadURL(url,"","GET");
			Request(url,'spn_sjp','','GET',showNoSJP,'noload');
		}
		
		function showNoSJP(){
			if(document.getElementById('spn_sjp').innerHTML=='ok'){
				a1.cellsSetValue(a1.getSelRow(),7,document.getElementById('txtNoSJP').value);
			}
			else{
				alert('update gagal.');	
			}
		}
		
		function saring(){
			var tgl=document.getElementById('txtTgl').value;
			var tmpLay=document.getElementById('cmbJnsLay').value;
			var dilayani=document.getElementById('cmbTransfer').value;
			//var url = "TransferINACBG_utils1.php?grd=true&saring=true&cmbJnsLay="+cmbJnsLay+"&tgl="+tgl;
			var url = "TransferINACBG_utils.php?grd=true&tgl="+tgl+"&tmpLay="+tmpLay+"&dilayani="+dilayani;
			//alert(url);
			a1.loadURL(url,"","GET");
		}
		
		function ChkAllKlik(){
			if (a1.getMaxRow()>0){
				if (document.getElementById('chkAll').checked){
					//alert('check');
					for (var i=0;i<a1.getMaxRow();i++){
						//a1.cellsSetValue_(i+1,2,1);
						a1.obj.childNodes[0].childNodes[i].childNodes[1].childNodes[0].checked = true;
					}
				}else{
					//alert('uncheck');
					for (var i=0;i<a1.getMaxRow();i++){
						//a1.cellsSetValue_(i+1,2,0);
						a1.obj.childNodes[0].childNodes[i].childNodes[1].childNodes[0].checked = false;
					}
				}
			}
		}
	
		function goFilterAndSort(grd){
		var url;
		var tgl=document.getElementById('txtTgl').value;
		var tmpLay=document.getElementById('cmbJnsLay').value;
		var dilayani=document.getElementById('cmbTransfer').value;
			if (grd=="gridbox"){		
				url="TransferINACBG_utils.php?grd=true&tgl="+tgl+"&tmpLay="+tmpLay+"&dilayani="+dilayani+"&filter="+a1.getFilter()+"&sorting="+a1.getSorting()+"&page="+a1.getPage();
				a1.loadURL(url,"","GET");
			}
		}

		showGrid();
		
		function cekStatus(x){
			if(x==0){
				document.getElementById('updtPas').disabled=false;
			}
			else{
				document.getElementById('updtPas').disabled=true;
			}
		}
		
		/*
		function updatePas2(){
			var tmp='';
			var atmp='';
			var cdata='';
			for (var i=0;i<a1.getMaxRow();i++){
				if (a1.obj.childNodes[0].childNodes[i].childNodes[1].childNodes[0].checked){
					cdata=a1.getRowId(i+1).split("|");
					tmp+=cdata[0]+String.fromCharCode(5)+cdata[1]+String.fromCharCode(5)+a1.cellsGetValue(i+1,5)+String.fromCharCode(5)+a1.cellsGetValue(i+1,9)+String.fromCharCode(5)+a1.cellsGetValue(i+1,8)+String.fromCharCode(5)+a1.cellsGetValue(i+1,10)+String.fromCharCode(5)+cdata[2]+String.fromCharCode(5)+cdata[3]+String.fromCharCode(5)+cdata[4]+String.fromCharCode(5)+cdata[5]+String.fromCharCode(6);
					//atmp+=cdata[0]+'|'+cdata[1]+'**';
				}
			}
			//alert(tmp);
			
			url="TransferINACBG_utils.php?act=transfer&grd=true&tgl="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbJnsLay').value+"&dilayani="+document.getElementById('cmbTransfer').value+"&fdata="+tmp;
			//alert(url);
			a1.loadURL(url,"","GET");
		}
		*/
		
		var data_transfers = new Array();
		var current_transfer=0;
		function getJmlData(){
			jml_data=0;
			for (var i=0;i<a1.getMaxRow();i++){
					if (a1.obj.childNodes[0].childNodes[i].childNodes[1].childNodes[0].checked){
						jml_data++;
					}
			}
			return jml_data;
		}
		
		function getDataInfo(index){
			var cdata='';
			cdata=data_transfers[index].split(String.fromCharCode(5));
			return cdata[0]+' - '+cdata[1];
		}
		
		function getArrData(){
			var temp='';
			var cdata='';
			data_transfers=[];
			for (var i=0;i<a1.getMaxRow();i++){
				if (a1.obj.childNodes[0].childNodes[i].childNodes[1].childNodes[0].checked){
					cdata=a1.getRowId(i+1).split("|");
					//alert(a1.cellsGetValue(i+1,5));
					temp=cdata[0]+String.fromCharCode(5)+cdata[1]+String.fromCharCode(5)+a1.cellsGetValue(i+1,5)+String.fromCharCode(5)+a1.cellsGetValue(i+1,10)+String.fromCharCode(5)+a1.cellsGetValue(i+1,9)+String.fromCharCode(5)+a1.cellsGetValue(i+1,11)+String.fromCharCode(5)+cdata[2]+String.fromCharCode(5)+a1.cellsGetValue(i+1,7)+String.fromCharCode(5)+cdata[4]+String.fromCharCode(5)+cdata[5]+String.fromCharCode(6);
					data_transfers.push(temp);
				}
			}
		}
		
		var persenan=0;
		var stat=0;
		function updatePas(){
			var user_id_inacbg = '<?php echo $user_id_inacbg ?>';
			if(user_id_inacbg=='' || user_id_inacbg=='0'){
				alert('User Login anda blm ada link ke user inacbg, hubungi petugas IT');
				return false;	
			}
			
			current_transfer=0;
			persenan=0;
			stat=0;
			getArrData();
		
			if(getJmlData()==0){
				alert('Pilih/centang data yang akan ditransfers.');
				return false;
			}
			
			if(confirm("Ada "+getJmlData()+" data yang akan ditransfers. Lanjut ?")){
				transfering=true;
				var persen = 100/parseInt(jml_data);
				persenan = persen;
				
				$("#progressbar").progressbar({
            			value: 0
     			});
				$( "#dialog" ).dialog({
					modal: true,
					autoOpen: false,
					width: 400,
					buttons: [
						{
							text: "Stop",
							click: function() {
								if(confirm('Ingin membatalkan transfers ?')){	
									$( this ).dialog( "close" );
									transfering=false;
								}
							}
						}
					]
				});
				$( "#dialog" ).dialog( "open" );
				transfer(data_transfers[current_transfer]);
			}	
		}
		
		var transfering=false;
		function transfer(data){
			var userId = '<?php echo $userId; ?>';
			var user_id_inacbg = '<?php echo $user_id_inacbg; ?>';
			document.getElementById('spnStatus').innerHTML="Transfering "+(current_transfer+1)+"/"+jml_data+" data ...";
			document.getElementById('spnInfo').innerHTML=getDataInfo(current_transfer);
			url="TransferINACBG_utils.php?act=transfer&grd=true&user_act="+userId+"&user_id_inacbg="+user_id_inacbg+"&tgl="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbJnsLay').value+"&dilayani="+document.getElementById('cmbTransfer').value+"&fdata="+data;
			//url="testing.php?act=transfer&grd=true&tgl="+document.getElementById('txtTgl').value+"&tmpLay="+document.getElementById('cmbJnsLay').value+"&dilayani="+document.getElementById('cmbTransfer').value+"&fdata="+data;
			//alert(url);
			a1.loadURL(url,"","GET");	
		}
		
		function konfirmasi(key,val){
			for (var i=0;i<a1.getMaxRow();i++){
				a1.obj.childNodes[0].childNodes[i].childNodes[1].childNodes[0].id=i;
				a1.obj.childNodes[0].childNodes[i].childNodes[1].childNodes[0].onclick=function(){
					var brs	= parseInt(this.id); 
					if(a1.cellsGetValue(brs+1,7)=='' && this.checked==true){
						alert('No SJP masih kosong !');
						a1.obj.childNodes[0].childNodes[this.id].childNodes[1].childNodes[0].checked=false;
					}
				};	
			}
			
			
			document.getElementById('chkAll').checked=false;
			if(key=='Error'){
				if(val=='transfer'){
					document.getElementById('spnStatus').innerHTML="Transfering error...";
					transfering=false;
				}
			}else{
				if(val=='transfer'){
					stat=parseInt(stat)+parseInt(persenan);
					$("#progressbar").progressbar({
            			value: parseInt(stat)
     				});
					
					current_transfer++;
					if(current_transfer<jml_data && transfering==true){
						transfer(data_transfers[current_transfer]);
					}
					else{
						$("#progressbar").progressbar({
            			value: 100
     					});
						document.getElementById('spnStatus').innerHTML="Tranfering data selesai...";
						document.getElementById('spnInfo').innerHTML="";
						transfering=false;
						$( "#dialog" ).dialog({
							autoOpen: false,
							width: 400,
							buttons: [
								{
									text: "Ok",
									click: function() {
										$( this ).dialog( "close" );
									}
								}
							]
						});
					}
				}
			}
		}
		
	</script>
	
