<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script src="../li/jquery.js" language="javascript" type="text/javascript"></script>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<script type="text/javascript" src="../theme/js/ajax.js"></script>
<link type="text/css" rel="stylesheet" href="mod.css" />
<title>Untitled Document</title>
<script type="text/JavaScript">
	var arrRange = depRange = [];
</script>
</head>
<style>
.font{
font-family:Verdana, Arial, Helvetica, sans-serif; 
font-size:16px; 
font-weight:bold; 
color:#990033;
text-decoration:blink;
}
fontOut{
font-family:Verdana, Arial, Helvetica, sans-serif; 
font-size:16px; 
font-weight:bold; 
color:#990033;
}
</style>
<body>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js" src="../theme/popcjs.php" scrolling="no" frameborder="1"
	style="border:1px solid medium ridge; position:absolute; z-index:65535; left:100px; top:50px; visibility:hidden">
</iframe>
<!--==============================================1========================================================-->
<table width="780" align="center" cellpadding="0" cellspacing="0" class="tbl">
<tr>
	<td width="671" height="30" colspan="9" align="center" valign="bottom">
		<fieldset>
        <input type="hidden" id="tgl_soap" name="tgl_soap" />
		<input type="hidden" id="mnt_soap" name="mnt_soap" />
		<table width="100%" align="center" cellpadding="0" cellspacing="0">
		<tr>
		  <td width="64%">
          <select id="asalSOAP" name="asalSOAP" class="txtinput" onchange="gantiJenis(this.value);">
          	<option value="0">Perawat</option>
            <option value="1">Dokter</option>
          </select>
            </td>
          	<td width="8%" align="right" style="display:none">Tanggal</td>
            <td width="1%" align="center" style="display:none">:</td>
            <td width="27%" style="display:none">&nbsp;<input type="text" class="txtcenter" readonly="readonly" name="tanggalSOAP" id="tanggalSOAP" size="11" value="<?php echo date('d-m-Y'); ?>"/>&nbsp;<input type="button" class="btninput" id="btnTanggalSOAP" name="btnTanggalSOAP" value=" V " onClick="gfPop.fPopCalendar(document.getElementById('tanggalSOAP'),depRange);" /></td>
	</tr>
    	<tr>
        	<td>
            <select id="cmbDokSOAPIER" name="cmbDokSOAPIER" class="txtinput" onchange="ampek(this.value)" onkeypress="setDok('btnSimpanDiag',event,this.value);"></select>
		    <label id="label_pengganti"><input type="checkbox" id="chkDokterPenggantiSOAPIER" value="1" onchange="gantiDokter('cmbDokSOAPIER',this.checked);"/>Dokter Pengganti</label>
            </td>
            <td align="right" style="display:none">SOAP</td>
            <td width="1%" align="center" style="display:none">:</td>
            <td width="27%" style="display:none">&nbsp;<select id="cmbSOAPIER" class="txtinput" style="vertical-align:middle">
    	<option value="2">Untuk Perawat</option>
        <option value="1">Untuk Dokter</option>
        <option value="3">Dokter+Perawat</option>
    	</select></td>
        </tr>
        <tr>
        	<td>
        	<input type="text" id="tglSoap" class="txtcenter" name="tglSoap" size="10" value="<?php echo date("d-m-Y") ?>" />
				<input type="button" class="btninput" id="btnTanggal1" name="btnTanggal1" value=" V " onclick="gfPop.fPopCalendar(document.getElementById('tglSoap'),depRange);" />
				&nbsp;&nbsp;&nbsp;
				<input type="text" class="txtcenter" id="mnt" name="mnt" size="7" value="<?php echo gmdate("H:i:s",mktime(date('H')+7)) ?>" />
                <input type="hidden" id="jnsLay" name="jnsLay" value="<?php echo $_REQUEST['jnsLay'] ?>" />			<input type="hidden" id="tglMas" name="tglMas" value="<?=$_REQUEST['tglMaster'] ?>" />
                <input type="hidden" id="cmbTmpLay" name="cmbTmpLay" value="<?php echo $_REQUEST['tmpLay']; ?>" />
             </td>
             <td>
            
            </td>
            <td width="1%">&nbsp;</td>
            <td width="27%" style="display:none">&nbsp;<input type="button" onclick="lihatSOAPIER()" value="Cetak" style="cursor:pointer" /></td>
        </tr>
	</table>
	</fieldset>
    </td>
    </tr>
<td width="275"></tr>
<tr>
	<td align="center" colspan="9">
	<div id="ditampilkan1" style="display:block" class="tbl" align="center">
	<table>
		<tr>
			<td width="772" align="center">
				<fieldset>
				<table width="100%" align="center">
					<tr>
						<td width="136" align="center">S</td>
					  <td width="437"><textarea name="txtSxxx" cols="60" rows="2" id="txtSxxx"></textarea></td>
					</tr>
					<tr>
					  <td align="center">O</td>
					  <td><textarea name="txtOxxx" cols="60" rows="2" id="txtOxxx"></textarea></td>
				  </tr>
					<tr>
					  <td align="center">A</td>
					  <td><textarea name="txtAxxx" cols="60" rows="2" id="txtAxxx"></textarea></td>
				  </tr>
					<tr>
					  <td align="center">P</td>
					  <td><textarea name="txtPxxx" cols="60" rows="2" id="txtPxxx"></textarea></td>
				  </tr>
					<tr>
					  <td align="center">I</td>
					  <td><textarea name="txtIxxx" cols="60" rows="2" id="txtIxxx"></textarea></td>
				  </tr>
					<tr>
					  <td align="center">E</td>
					  <td><textarea name="txtExxx" cols="60" rows="2" id="txtExxx"></textarea></td>
				  </tr>
					<tr>
					  <td align="center">R</td>
					  <td><textarea name="txtRxxx" cols="60" rows="2" id="txtRxxx"></textarea></td>
				  </tr>
					<tr>
					  <td align="center"><div class="divAlasan" style="display:none">&nbsp;Alasan</div></td>
					  <td><div class="divAlasan" style="display:none"><textarea name="txtAlasanx" cols="60" rows="2" id="txtAlasanx"></textarea></div></td>
				  </tr>
					<tr>
					  <td align="center">&nbsp;</td>
					  <td>&nbsp;</td>
				  </tr>
					<tr>
						<td>&nbsp;</td>
						<td><button type="button" id="saveSub" name="saveSub" value="ins" onclick="actS(this.value)" style="cursor:pointer"><img src="../icon/save.gif" align="absmiddle" width="20" />&nbsp;&nbsp;Tambah</button>&nbsp;<button type="button" id="gk_sido" name="gk_sido" onclick="fResetSOP()" style="cursor:pointer"><img src="../icon/back.png" width="20" align="absmiddle" />&nbsp;&nbsp;Batal</button>&nbsp;<button type="button" id="hapus1" name="hapus1" onclick="del11()" disabled="disabled" style="cursor:pointer; display:none;"><img src="../icon/delete2.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Hapus</button>&nbsp;<button type="button" id="hapus1" name="hapus1" onclick="cetak11()" style="cursor:pointer"><img src="../icon/printer.png" width="20" align="absmiddle" />&nbsp;&nbsp;Cetak</button></td>
					</tr>
					<tr>
						<td colspan="5" align="center"><div id="dridSub" align="center" style="width:700px; height: 200px; background-color:white;"></div><br/>
							<div id="pagingSub" style="width:550px; display:block;"></div></td>
					</tr>
				</table>
			</fieldset></td>
		</tr>
	</table>
	</div>	</td>
</tr>
</table>

<input type="hidden" id="txtIdSub" name="txtIdSub" />
<!--=====================================end===================================-->
</body>
<script>
function cetak11(){
	var soapier_id = document.getElementById('txtIdSub').value;
	if(soapier_id==''){
		alert('Pilih data terlebih dahulu !');
		return false;
	}
	window.open('soap_report.php?idPel='+getIdPel+'&soapier_id='+soapier_id);
}

function lihatSOAPIER(){
	var tipe = document.getElementById('cmbSOAPIER').value;
	var tanggal = document.getElementById('tanggalSOAP').value;
	if(tipe=='3'){
		window.open('r_soap2.php?idPel='+getIdPel+'&tgl='+document.getElementById('tglSoap').value+'&mnt='+document.getElementById('mnt').value+'&tanggal='+tanggal);	
	}
	else{
		window.open('r_soap.php?idPel='+getIdPel+'&tgl='+document.getElementById('tglSoap').value+'&mnt='+document.getElementById('mnt').value+'&tipe='+tipe+'&tanggal='+tanggal);
	}
}

function gantiJenis(){
	if(document.getElementById('asalSOAP').value=='0'){
		isiCombo2('cmbPerawat',document.getElementById('cmbTmpLay').value,'','cmbDokSOAPIER');
		document.getElementById('label_pengganti').style.display='none';
	}
	if(document.getElementById('asalSOAP').value=='1'){
		isiCombo('cmbDok',document.getElementById('cmbTmpLay').value,'','cmbDokSOAPIER');
		document.getElementById('label_pengganti').style.display='inline-table';
	}
}
<!--------------------------------1-------------------------------------------->
var subj = new DSGridObject("dridSub");
subj.setHeader(" ",false);
subj.setColHeader("No,Tanggal,Nama Dokter/Perawat,S,O,A,P,I,E,R");
subj.setIDColHeader(",,nama,,,,,,,");
subj.setColWidth("40,70,255,100,100,100,100,100,100,100");
subj.setCellAlign("center,center,left,left,left,left,left,left,left,left");
subj.setCellType("txt,txt,txt,txt,txt,txt,txt,txt,txt,txt");
subj.setCellHeight(20);
subj.setImgPath("../icon");
subj.setIDPaging("pagingSub");
subj.attachEvent("onRowClick","ambilIdS");
subj.baseURL("soap_utils.php?grd=1&idPel=0&cmbDokter="+document.getElementById('cmbDokSOAPIER').value);
subj.Init();

function actS(par){
	var subs=document.getElementById('txtSxxx').value+","+document.getElementById('txtOxxx').value+","+document.getElementById('txtAxxx').value+","+document.getElementById('txtPxxx').value+","+document.getElementById('txtIxxx').value+","+document.getElementById('txtExxx').value+","+document.getElementById('txtRxxx').value;
	var id=document.getElementById('txtIdSub').value;
	var cmbDok=document.getElementById('cmbDokSOAPIER').value;
	var mnt=document.getElementById('mnt').value;
	var als=document.getElementById('txtAlasanx').value;
	//alert("soap_utils.php?cmbDok="+cmbDok+"&grd=1&act="+par+"&subs="+subs+"&id="+id+"&idPel=<?php echo $_REQUEST['idpel'] ?>&tglMaster="+document.getElementById('tglSoap').value+"&cmbDokter="+document.getElementById('cmbDokDiag').value+"&mnt="+mnt+"&jenis="+document.getElementById('asalSOAP').value);
	subj.loadURL("soap_utils.php?cmbDok="+cmbDok+"&grd=1&act="+par+"&subs="+subs+"&id="+id+"&idPel="+getIdPel+"&tglMaster="+document.getElementById('tglSoap').value+"&cmbDokter="+document.getElementById('cmbDokDiag').value+"&mnt="+mnt+"&jenis="+document.getElementById('asalSOAP').value+"&alasan="+als,'','GET');
	fResetSOP()
}
function ambilIdS(){
var sisip=subj.getRowId(subj.getSelRow()).split("|")
			document.getElementById('txtIdSub').value=sisip[0];
	jQuery('#txtSxxx').val(subj.cellsGetValue(subj.getSelRow(),4));
	jQuery('#txtOxxx').val(subj.cellsGetValue(subj.getSelRow(),5));
	jQuery('#txtAxxx').val(subj.cellsGetValue(subj.getSelRow(),6));
	jQuery('#txtPxxx').val(subj.cellsGetValue(subj.getSelRow(),7));
	jQuery('#txtIxxx').val(subj.cellsGetValue(subj.getSelRow(),8));
	jQuery('#txtExxx').val(subj.cellsGetValue(subj.getSelRow(),9));
	jQuery('#txtRxxx').val(subj.cellsGetValue(subj.getSelRow(),10));

document.getElementById('saveSub').innerHTML='<img src="../icon/edit.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Ubah'
document.getElementById('saveSub').value='up';
document.getElementById('hapus1').innerHTML='<img src="../icon/delete.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Hapus'
document.getElementById('hapus1').disabled=false;
	jQuery(".divAlasan").slideDown(500);
}
function fResetSOP(){
	jQuery('#txtSxxx').val('');
	jQuery('#txtOxxx').val('');
	jQuery('#txtAxxx').val('');
	jQuery('#txtPxxx').val('');
	jQuery('#txtIxxx').val('');
	jQuery('#txtExxx').val('');
	jQuery('#txtRxxx').val('');
    document.getElementById('txtIdSub').value='';
    document.getElementById('saveSub').innerHTML='<img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Tambah';
    document.getElementById('saveSub').value='ins';
    document.getElementById('hapus1').innerHTML='<img src="../icon/delete2.gif" align="absmiddle" width="20"  />&nbsp;&nbsp;Hapus';
    document.getElementById('hapus1').disabled=true;
	subj.loadURL("soap_utils.php?grd=1&idPel="+getIdPel+"&cmbDokter="+document.getElementById('cmbDokDiag').value,"","GET");
	jQuery("#txtAlasanx").val('');
	jQuery(".divAlasan").slideUp(500);
}
function del11(){
    var id=document.getElementById('txtIdSub').value;
    if(confirm("Apakaha anda yakin ingin menghapus data ini !")){
        subj.loadURL("soap_utils.php?grd=1&act=del&id="+id,"","GET");
        fResetSOP();
    }
}
function goFilterAndSort(abc){
	if (abc=="dridSub"){
		subj.loadURL("soap_utils.php?cmbDokter="+document.getElementById('cmbDokSOAPIER').value+"&grd=1&filter="+subj.getFilter()+"&sorting="+subj.getSorting()+"&page="+subj.getPage(),"","GET");
	}
} 

function ampek(parameter){
	subj.loadURL("soap_utils.php?grd=1&cmbDokter="+parameter+"&idPel="+getIdPel,"","GET");
	/*Obj.loadURL("soap_utils.php?grd=2&cmbDokter="+parameter+"&idPel="+getIdPel,"","GET");
	Ass.loadURL("soap_utils.php?grd=3&cmbDokter="+parameter+"&idPel="+getIdPel,"","GET");
	Plan.loadURL("soap_utils.php?grd=4&cmbDokter="+parameter+"&idPel="+getIdPel,"","GET");*/
}
function isiCombo(id,val,defaultId,targetId,evloaded){
	if(targetId=='' || targetId==undefined){
		targetId=id;
	}
	if(document.getElementById(targetId)==undefined){
		alert('Elemen target dengan id: \''+targetId+'\' tidak ditemukan!');
	}else{
		Request('/simrs/billing/combo_utils.php?all=2&id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
	}
}
function isiCombo2(id,val,defaultId,targetId,evloaded){
	if(targetId=='' || targetId==undefined){
		targetId=id;
	}
	if(document.getElementById(targetId)==undefined){
		alert('Elemen target dengan id: \''+targetId+'\' tidak ditemukan!');
	}else{
		alert('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId);
		Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
	}
}
function setDok(ke,ev){
	fSetValue(window,"cmbDokDiag*-*"+ke+"*|*cmbDokTind*-*"+ke+"*|*cmbDokRujukRS*-*"+ke+"*|*cmbDokRujukUnit*-*"+ke+"*|*cmbDokResep*-*"+ke);
	if(ev.which==13) document.getElementById(ke).focus();

}
var unitId=document.getElementById('jnsLay').value;
var unit_id=document.getElementById('cmbTmpLay').value;

//isiCombo('cmbDok',unit_id,'','cmbDokDiag');
</script>
</html>
