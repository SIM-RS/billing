<?php 
//session_start();
include("../sesi.php");
?>
<?php
//session_start();
include("../koneksi/konek.php");
$userIdLaundry=$_SESSION['userId'];
//if ($userIdLaundry==""){
//	header("location:index.php?err=Silahkan Login Terlebih Dahulu !");
//}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../theme/popup.js"></script>
<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
<link type="text/css" rel="stylesheet" href="../default.css"/>
<link type="text/css" rel="stylesheet" href="../include/jquery/themes/base/ui.all.css"/>
<!-------------------------------------------------------------------->
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<link rel="stylesheet" type="text/css" href="../theme/tab-view.css" />
<script type="text/javascript" src="../theme/js/tab-view.js"></script>
<link rel="STYLESHEET" type="text/css" href="../theme/codebase/dhtmlxtabbar.css">
<script  src="../theme/codebase/dhtmlxcommon.js"></script>
<script  src="../theme/codebase/dhtmlxtabbar.js"></script>
<script type="text/javascript" src="../jquery.js"></script>
<!--<script type="text/javascript" src="../menu.js"></script>-->

<!--mulai pop up-->
<!--<link rel="stylesheet" type="text/css" href="../theme/li/popup.css" />
	<script type="text/javascript" src="../theme/li/prototype.js"></script>
	<script type="text/javascript" src="../theme/li/effects.js"></script>
	<script type="text/javascript" src="../theme/li/popup.js"></script>-->
<!--end pop up-->


<!--mulai autocomplete-->
<script src="../include/jquery/ui/jquery.ui.core.js"></script>
<script src="../include/jquery/ui/jquery.ui.widget.js"></script>
<script src="../include/jquery/external/jquery.bgiframe-2.1.2.js"></script>
<script src="../include/jquery/ui/jquery.ui.mouse.js"></script>
<script src="../include/jquery/ui/jquery.ui.draggable.js"></script>
<script src="../include/jquery/ui/jquery.ui.position.js"></script>
<script src="../include/jquery/ui/jquery.ui.resizable.js"></script>
<script src="../include/jquery/ui/jquery.ui.dialog.js"></script>
<script src="../include/jquery/ui/jquery.ui.tabs.js"></script>
<script src="../include/jquery/ui/jquery.ui.autocomplete.js"></script>
<script src="../js/jquery.form.js"></script>
<!--end autocomplete-->

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Job Order</title>
</head>

<body>
 <script type="text/JavaScript">
                var arrRange = depRange = [];
				</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
                    id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="1"
                    style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
        </iframe>
<iframe height="72" width="130" name="sort"
id="sort"
src="../theme/dsgrid_sort.php" scrolling="no"
frameborder="0"
style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center">
<?php 
include("../header1.php");
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
    $th=explode("-",$tgl);
?>

<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
                <tr>
                    <td height="30">&nbsp;STERILISASI</td>
                </tr>
            </table>
<table width="1000" align="center" cellpadding="0" cellspacing="0" class="tabel">
<tr>
	<td>
	<table width="959" align="center" cellpadding="0" cellspacing="0" class="tbl">
	<tr>
		<td>&nbsp;</td>
	</tr>
    <tr>
    <td colspan="2" style="padding-left:20px;font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold;">
    
                        <fieldset style="width: 200px;display:inline-table;">
                            <legend>
                                Bulan<span style="padding-left: 50px; color: #fcfcfc;">&ensp;</span>Tahun
                            </legend>
                            <select style="width:100px; height:25px;" id="blnZ" name="blnZ" onchange="filterZ()" class="txtinputreg">
                                <option value="1" <?php echo $th[1]==1?'selected="selected"':'';?> >Januari</option>
                                <option value="2" <?php echo $th[1]==2?'selected="selected"':'';?> >Februari</option>
                                <option value="3" <?php echo $th[1]==3?'selected="selected"':'';?> >Maret</option>
                                <option value="4" <?php echo $th[1]==4?'selected="selected"':'';?> >April</option>
                                <option value="5" <?php echo $th[1]==5?'selected="selected"':'';?> >Mei</option>
                                <option value="6" <?php echo $th[1]==6?'selected="selected"':'';?> >Juni</option>
                                <option value="7" <?php echo $th[1]==7?'selected="selected"':'';?> >Juli</option>
                                <option value="8" <?php echo $th[1]==8?'selected="selected"':'';?> >Agustus</option>
                                <option value="9" <?php echo $th[1]==9?'selected="selected"':'';?> >September</option>
                                <option value="10" <?php echo $th[1]==10?'selected="selected"':'';?> >Oktober</option>
                                <option value="11" <?php echo $th[1]==11?'selected="selected"':'';?> >Nopember</option>
                                <option value="12" <?php echo $th[1]==12?'selected="selected"':'';?> >Desember</option>
                            </select>&nbsp;
                            <select style="width:70px; height:25px;"  id="thnZ" name="thnZ" onchange="filterZ()" class="txtinputreg">
                                <?php
                                for ($i=($th[2]-5);$i<($th[2]+3);$i++) {
                                    ?>
                                <option value="<?php echo $i; ?>" class="txtinput" <?php if ($i==$th[2]) echo "selected";?>><?php echo $i;?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </fieldset>&nbsp;&nbsp;
                        <fieldset id="fldBayar" style="width: 155px;display:inline-table;">
                            <legend>
                                Status
                            </legend>
                            <select style="width:100px; height:25px;" id="stOrdZ" name="stOrdZ" onchange="filterZ()" class="txtinputreg">
                                <option value="">Semua&nbsp;</option>
                                <option value="0">Permohonan&nbsp;</option>
                                <option value="1">Proses&nbsp;</option>
                                <option value="2">Selesai&nbsp;</option>
                            </select>
                        </fieldset>
                        <br/><br/>
                    </td>
    </tr>
    
	<tr>
		<td>
			<input type="hidden" id="idPtgsZ" name="idPtgsZ" value="<?=$_SESSION['userId']?>" />        
			<div id="gridboxZ" style="width:900px; height:300px; background-color:white; overflow:hidden; margin:auto;"></div>
			<div id="pagingZ" style="width:900px; display:block; margin:auto;"></div>
		</td>
	</tr>
	</table>
	</td>
</tr>
<!--<tr>
		<td colspan="2" align="center" width="1024" height="50" class="h1" bgcolor="#FFFFFF"><img src="../images/home_03.png"></td>
  </tr>-->
</table>
<table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
<tr height="30">
                    <td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
                    <td>&nbsp;</td>
                    <td align="right"><a href="../../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" class="btninput" /></a>&nbsp;</td>
                </tr>
            </table>
<div id="clik"></div>
<div id="clik1"></div>

</div>
<div id="dialog-modal" title="Proses JO" style="display:none; font:12px tahoma;">
<table width="410" align="center" cellpadding="3" cellspacing="0">
<tr>
	<td width="110">Nomor WO</td>
	<td width="300"><?php
$q="SELECT MAX(IF(no_wo IS NULL,0,no_wo))+1 AS $dbcssd.no_wo FROM cssd_job_order";
$s=mysql_query($q);
$cmkode=1;
if ($rows=mysql_fetch_array($s))
{
	$cmkode=$rows["no_wo"];
}
$mkode=$cmkode;
for ($i=0;$i<(8-strlen($cmkode));$i++)
{
	$mkode="0".$mkode;
}
?><input type="text" id="kdWo" name="kdWo" size="7" value="<?=$mkode;?>" readonly="true"/><input type="hidden" id="status_joZ" name="status_joZ" /><input type="hidden" id="idZ" name="idZ" /></td>
</tr>
<tr>
			  <td width="120">Tanggal Selesai</td>
				<td width="290">
				<input type="text" id="tglSelesai" name="tglSelesai" size="10" readonly="true" value="<?=date('d-m-Y')?>" />&nbsp;
                                    <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('tglSelesai'),depRange);"/>				</td>
			  </tr>
<tr>
	<td width="120">Nama Unit</td>
	<td width="290"><input type="text" id="nmUnit" name="nmUnit" size="40" readonly="true"/></td>
</tr>
<tr>
<td width="120">Nama Barang</td>
<td width="290"><input type="text" id="nmBrg" name="nmBrg" size="40" readonly="true"/></td>			  
</tr>
<tr>
	<td width="250" align="center" style="padding-top:20px" colspan="2"><button id="tampil" name="tampil" onClick="simpen()" style="cursor:pointer" class="popup_closebox"><img src="../icon/saveButton.jpg" width="20" align="absmiddle" />&nbsp;&nbsp;Simpan </button></td>
</tr>
</table>
</div>

<div id="dialog-modal2" title="Selesai" style="display:none; font:12px tahoma;">
<table width="410" align="center" cellpadding="3" cellspacing="0">
<tr>
	<td width="110">Nomor WO</td>
	<td width="300"><input type="text" id="kdWo2" name="kdWo2" size="7" value="<?=$mkode;?>" readonly="true"/><input type="hidden" id="status_jo2" name="status_jo2" /><input type="hidden" id="id2" name="id2" /></td>
</tr>
<tr>
			  <td width="120">Tanggal Selesai</td>
				<td width="290">
				<input type="text" id="tglSelesai2" name="tglSelesai2" size="10" readonly="true" value="<?=date('d-m-Y')?>" />&nbsp;
                                    <input type="button" name="btnTgl" value="&nbsp;V&nbsp;" class="tblBtn" onclick="gfPop.fPopCalendar(document.getElementById('tglSelesai2'),depRange);"/>				</td>
			  </tr>
<tr>
	<td width="120">Nama Unit</td>
	<td width="290"><input type="text" id="nmUnit2" name="nmUnit2" size="40" readonly="true"/></td>
</tr>
<tr>
<td width="120">Nama Barang</td>
<td width="290"><input type="text" id="nmBrg2" name="nmBrg2" size="40" readonly="true"/></td>			  
</tr>
<tr>
	<td width="250" align="center" style="padding-top:20px" colspan="2"><button id="tampil" name="tampil" onClick="simpen2()" style="cursor:pointer" class="popup_closebox"><img src="../icon/saveButton.jpg" width="20" align="absmiddle" />&nbsp;&nbsp;Simpan </button></td>
</tr>
</table>
</div>
</body>
<script language="javascript">

function goFilterAndSort(abc){
	if (abc=="gridboxZ"){
		gd9.loadURL("joborderUtils.php?grd=order2&petugas=<?=$_SESSION['userId']?>&filter="+gd9.getFilter()+"&sorting="+gd9.getSorting()+"&page="+gd9.getPage(),"","GET");
		//alert("tindakanUtils.php?grd=tindakan_nic&filter="+gd9.getFilter()+"&sorting="+gd9.getSorting()+"&page="+gd9.getPage())
	}
} 

var gd9 = new DSGridObject("gridboxZ");
gd9.setHeader("Data Job Order",true);
gd9.setColHeader("No,Tanggal,Nomor JO,Tanggal Selesai,Nomor WO,Nama Unit,Nama Barang,Tipe Job Order,Nama Pemohon,Jumlah,Status,Action");
gd9.setIDColHeader(",tgl,no_jo,tgl_selesai,no_wo,nama,namabarang,tipe,namauser,qty,stat,");
gd9.setColWidth("30,90,90,90,90,150,150,100,150,50,90,70");
gd9.setCellAlign("center,center,left,center,left,left,left,center,left,center,center,center");
gd9.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt,txt");
gd9.setCellHeight(20);
gd9.setImgPath("../icon");
gd9.setIDPaging("pagingZ");
//gd9.onLoaded(konfirmasi);
gd9.attachEvent("onRowClick","ambilIdZ");
gd9.attachEvent("onRowClick","ambilIdZ2");
gd9.baseURL("joborderUtils.php?grd=order2&petugas=<?=$_SESSION['userId']?>");
gd9.Init();

function filterZ(){
        var bln = document.getElementById('blnZ').value;
        var thn = document.getElementById('thnZ').value;
		var stOrd = document.getElementById('stOrdZ').value;

				//alert(url);
        gd9.loadURL("joborderUtils.php?grd=order2&petugas=<?=$_SESSION['userId']?>&stOrd="+stOrd+"&bln="+bln+"&thn="+thn,'','GET');
        }
		
function ambilIdZ(){
	var sisipan=gd9.getRowId(gd9.getSelRow()).split("|");
	document.getElementById('idZ').value=sisipan[0];
	document.getElementById('status_joZ').value=sisipan[1];
	document.getElementById('tglSelesai').value='<?=date('d-m-Y')?>';
	//document.getElementById('tglSelesai').value=sisipan[2];
	/*var sip=sisipan[3];
	alert(sip);
	if(sip!=null){
	document.getElementById('kdWo').value=sisipan[3];}*/
	document.getElementById('kdWo').value=gd9.cellsGetValue(gd9.getSelRow(),5);
	document.getElementById('nmUnit').value=gd9.cellsGetValue(gd9.getSelRow(),6);
	document.getElementById('nmBrg').value=gd9.cellsGetValue(gd9.getSelRow(),7);
}

function ambilIdZ2(){
	var sisipan=gd9.getRowId(gd9.getSelRow()).split("|");
	document.getElementById('id2').value=sisipan[0];
	document.getElementById('status_jo2').value=sisipan[1];
	//document.getElementById('tglSelesai').value='<?=date('d-m-Y')?>';
	document.getElementById('tglSelesai2').value=sisipan[2];
	/*var sip=sisipan[3];
	alert(sip);
	if(sip!=null){
	document.getElementById('kdWo').value=sisipan[3];}*/
	document.getElementById('kdWo2').value=gd9.cellsGetValue(gd9.getSelRow(),5);
	document.getElementById('nmUnit2').value=gd9.cellsGetValue(gd9.getSelRow(),6);
	document.getElementById('nmBrg2').value=gd9.cellsGetValue(gd9.getSelRow(),7);
}

function proses()
{
	ambilIdZ();
	generate_kodeZ();
	tampilPop();
}

function selesai()
{
	ambilIdZ2();
	tampilPop2();
}

function tampilPop(){
	/*new Popup('jaga',null,{modal:true,position:'center',duration:1});
	document.getElementById('jaga').popup.show();*/
	$("#dialog-modal" ).dialog({
		height: 230,
		width: 450,
		show: "slow",
		modal: true
		});
}

function tampilPop2(){
	/*new Popup('jaga',null,{modal:true,position:'center',duration:1});
	document.getElementById('jaga').popup.show();*/
	$("#dialog-modal2" ).dialog({
		height: 230,
		width: 450,
		show: "slow",
		modal: true
		});
}

function generate_kodeZ()
{
	$.get('GenerateKode_v2.php', function(data) {
	$('#kdWo').val(data);
	//alert('Load was performed.');
	});
	
/*	var dataString = "";
$.ajax({
	type: "POST",
	url: "GenerateKode_v2.php",
	data: dataString,
	success: function(msg)
		{
			alert(msg);
		}
		
		
		});*/
}

function simpen(){
	var id=document.getElementById('idZ').value;
	var kdWo=document.getElementById('kdWo').value;
	var status_jo=document.getElementById('status_joZ').value;
	var idPtgs=document.getElementById('idPtgsZ').value;
	var tglSelesai=document.getElementById('tglSelesai').value;
gd9.loadURL("joborderUtils.php?cssd=1&grd=order2&petugas=<?=$_SESSION['userId']?>&idPtgs="+idPtgs+"&id="+id+"&kdWo="+kdWo+"&tglSelesai="+tglSelesai+"&statusOrder="+status_jo,'','GET');
		generate_kodeZ();	
}

function simpen2(){
	var id=document.getElementById('id2').value;
	var kdWo=document.getElementById('kdWo2').value;
	var status_jo=document.getElementById('status_jo2').value;
	var idPtgs=document.getElementById('idPtgsZ').value;
	var tglSelesai=document.getElementById('tglSelesai2').value;
gd9.loadURL("joborderUtils.php?cssd=1&grd=order2&petugas=<?=$_SESSION['userId']?>&idPtgs="+idPtgs+"&id="+id+"&kdWo="+kdWo+"&tglSelesai="+tglSelesai+"&statusOrder="+status_jo,'','GET');
		generate_kodeZ();	
}
</script>
</html>
