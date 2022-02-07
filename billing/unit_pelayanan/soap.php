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
	<td colspan="9" valign="bottom" height="30" align="center">
		<fieldset>
        <input type="hidden" id="tgl_soap" name="tgl_soap" />
		<input type="hidden" id="mnt_soap" name="mnt_soap" />
		<table width="100%" align="center" cellpadding="0" cellspacing="0">
		<tr>
		  <td width="50%">
          <select id="asalSOAP" name="asalSOAP" class="txtinput" onchange="gantiJenis(this.value);">
          	<option value="0">Perawat</option>
            <option value="1">Dokter</option>
          </select>
            </td>
          	<td width="22%" align="right">Tanggal</td>
            <td width="1%" align="center">:</td>
            <td width="27%">&nbsp;<input type="text" class="txtcenter" readonly="readonly" name="tanggalSOAP" id="tanggalSOAP" size="11" value="<?php echo date('d-m-Y'); ?>"/>&nbsp;<input type="button" class="btninput" id="btnTanggalSOAP" name="btnTanggalSOAP" value=" V " onClick="gfPop.fPopCalendar(document.getElementById('tanggalSOAP'),depRange);" /></td>
	</tr>
    	<tr>
        	<td>
            <select id="cmbDokSOAPIER" name="cmbDokSOAPIER" class="txtinput" onchange="ampek(this.value)" onkeypress="setDok('btnSimpanDiag',event,this.value);"></select>
		    <label id="label_pengganti"><input type="checkbox" id="chkDokterPenggantiSOAPIER" value="1" onchange="gantiDokter('cmbDokSOAPIER',this.checked);"/>Dokter Pengganti</label>
            </td>
            <td align="right">SOAP</td>
            <td width="1%" align="center">:</td>
            <td width="27%">&nbsp;<select id="cmbSOAPIER" class="txtinput" style="vertical-align:middle">
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
            <td width="27%">&nbsp;<input type="button" onclick="lihatSOAPIER()" value="Cetak" style="cursor:pointer" /></td>
        </tr>
	</table>
	</fieldset>
    </td>
    </tr>
</tr>
<tr>
	<td width="275">&nbsp;</td>
	<td width="63" onmouseover="className='font'" onmouseout="className='fontOut'" valign="top"><img src="../icon/sort_down_red.png" id="down" width="30" align="absbottom" style="cursor:pointer" class="tampikanSub1" />&nbsp;<font id="ganti1" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold" color="#990033">S</font></td>
		<td width="63" onmouseover="className='font'" onmouseout="className='fontOut'" valign="top"><img src="../icon/sort_down_red.png" width="30" align="absbottom" style="cursor:pointer" class="tampikanSub2" />&nbsp;<font id="ganti2" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold" color="#990033">O</font></td>
		<td width="63" onmouseover="className='font'" onmouseout="className='fontOut'" valign="top"><img src="../icon/sort_down_red.png" width="30" align="absbottom" style="cursor:pointer" class="tampikanSub3" />&nbsp;<font id="ganti3" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold" color="#990033">A</font></td>
		<td width="63" onmouseover="className='font'" onmouseout="className='fontOut'" valign="top"><img src="../icon/sort_down_red.png" width="30" align="absbottom" style="cursor:pointer" class="tampikanSub4" />&nbsp;<font id="ganti4" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold" color="#990033">P</font></td>
        <td width="63" onmouseover="className='font'" onmouseout="className='fontOut'" valign="top" style="display:none;"><img src="../icon/sort_down_red.png" width="30" align="absbottom" style="cursor:pointer" class="tampikanSub5" />&nbsp;<font id="ganti5" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold" color="#990033">I</font></td>
        <td width="63" onmouseover="className='font'" onmouseout="className='fontOut'" valign="top" style="display:none;"><img src="../icon/sort_down_red.png" width="30" align="absbottom" style="cursor:pointer" class="tampikanSub6" />&nbsp;<font id="ganti6" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold" color="#990033">E</font></td>
        <td width="63" onmouseover="className='font'" onmouseout="className='fontOut'" valign="top" style="display:none;"><img src="../icon/sort_down_red.png" width="30" align="absbottom" style="cursor:pointer" class="tampikanSub7" />&nbsp;<font id="ganti7" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold" color="#990033">R</font></td>
	<td width="230" align="right">&nbsp;</td>
</tr>
<tr>
	<td align="center" colspan="9">
	<div id="ditampilkan1" style="display:none" class="tbl" align="center">
	<table>
		<tr>
			<td width="772" align="center">
				<fieldset>
				<table width="100%" align="center">
					<tr>
						<td width="136" align="center">Subject</td>
					  <td width="437"><textarea id="sub" rows="2" cols="30"></textarea></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><button type="button" id="saveSub" name="saveSub" value="ins" onclick="actS(this.value)" style="cursor:pointer"><img src="../icon/save.gif" align="absmiddle" width="20" />&nbsp;&nbsp;Tambah</button>&nbsp;<button type="button" id="gk_sido" name="gk_sido" onclick="fReset1()" style="cursor:pointer"><img src="../icon/back.png" width="20" align="absmiddle" />&nbsp;&nbsp;Batal</button>&nbsp;<button type="button" id="hapus1" name="hapus1" onclick="del11()" disabled="disabled" style="cursor:pointer"><img src="../icon/delete2.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Hapus</button></td>
					</tr>
					<tr>
						<td colspan="5" align="center"><div id="dridSub" align="center" style="width:577px; height: 200px; background-color:white; overflow:hidden;"></div>
							<div id="pagingSub" style="width:550px; display:block;"></div>						</td>
					</tr>
				</table>
				</fieldset>			</td>
		</tr>
	</table>
	</div>	</td>
</tr>
</table>
<!--==============================================2========================================================-->
<table width="780" align="center" cellpadding="0" cellspacing="0" class="tbl">
<tr>
	<td align="center" colspan="9">
	<div id="ditampilkan2" style="display:none" class="tbl"  align="center">
	<table>
		<tr>
			<td width="772" align="center">
				<fieldset>
				<table width="500">
					<tr>
						<td width="136" align="center">Object</td>
						<td width="352"><textarea id="obj" rows="2" cols="30"></textarea></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
						<button type="button" id="saveObj" name="saveObj" value="ins" onclick="actO(this.value)" style="cursor:pointer"><img src="../icon/save.gif" align="absmiddle" width="20" />&nbsp;&nbsp;Tambah</button>&nbsp;&nbsp;
			<button type="button" id="gk_sido" name="gk_sido" onclick="fReset2()" style="cursor:pointer"><img src="../icon/back.png" width="20" align="absmiddle" />&nbsp;&nbsp;Batal</button>&nbsp;&nbsp;
			<button type="button" id="hapus12" name="hapus12" onclick="del12()" disabled="disabled" style="cursor:pointer"><img src="../icon/delete2.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Hapus</button>
						</td>
					</tr>
					<tr>
						<td colspan="2"><div id="gridObj" align="center" style="width:577px; height: 200px; background-color:white; overflow:hidden;"></div>
							<div id="pagingObj" style="width:550px; display:block;"></div>
						</td>
					</tr>
				</table>
				</fieldset>
			</td>
		</tr>
	</table>
	</div>
	</td>
</tr>
</table>
<!--==============================================3========================================================-->
<table width="780" align="center" cellpadding="0" cellspacing="0" class="tbl">
<tr>
	<td align="center" colspan="9">
	<div id="ditampilkan3" style="display:none" class="tbl" align="center">
	<table>
		<tr>
			<td width="772" align="center">
				<fieldset>
				<table width="500">
					<tr>
						<td width="136" align="center">Assesment</td>
						<td width="352"><textarea id="ass" rows="2" cols="30"></textarea></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
						<button type="button" id="saveAss" name="saveAss" value="ins" onclick="actA(this.value)" style="cursor:pointer"><img src="../icon/save.gif" align="absmiddle" width="20" />&nbsp;&nbsp;Tambah</button>&nbsp;&nbsp;
			<button type="button" id="gk_sido" name="gk_sido" onclick="fReset3()" style="cursor:pointer"><img src="../icon/back.png" width="20" align="absmiddle" />&nbsp;&nbsp;Batal</button>&nbsp;&nbsp;
			<button type="button" id="hapus13" name="hapus13" onclick="del13()" disabled="disabled" style="cursor:pointer"><img src="../icon/delete2.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Hapus</button>
						</td>
					</tr>
					<tr>
						<td colspan="2"><div id="gridAss" align="center" style="width:577px; height: 200px; background-color:white; overflow:hidden;"></div>
							<div id="pagingAss" style="width:550px; display:block;"></div>
						</td>
					</tr>
				</table>
				</fieldset>
			</td>
		</tr>
	</table>
	</div>
	</td>
</tr>
</table>
<!--==============================================4========================================================-->
<table width="780" align="center" cellpadding="0" cellspacing="0" class="tbl">
<tr>
	<td align="center" colspan="9">
	<div id="ditampilkan4" style="display:none" class="tbl" align="center">
	<table>
		<tr>
			<td width="772" align="center">
				<fieldset>
				<table width="500">
					<tr>
						<td width="136" align="center">Planning</td>
						<td width="352"><textarea id="plan" rows="2" cols="30"></textarea></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
						<button type="button" id="savePlan" name="savePlan" value="ins" onclick="actP(this.value)" style="cursor:pointer"><img src="../icon/save.gif" align="absmiddle" width="20" />&nbsp;&nbsp;Tambah</button>&nbsp;&nbsp;
			<button type="button" id="gk_sido" name="gk_sido" onclick="fReset4()" style="cursor:pointer"><img src="../icon/back.png" width="20" align="absmiddle" />&nbsp;&nbsp;Batal</button>&nbsp;&nbsp;
			<button type="button" id="hapus14" name="hapus14" onclick="del14()" disabled="disabled" style="cursor:pointer"><img src="../icon/delete2.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Hapus</button>
						</td>
					</tr>
					<tr>
						<td colspan="2"><div id="gridPlan" align="center" style="width:577px; height: 200px; background-color:white; overflow:hidden;"></div>
							<div id="pagingPlan" style="width:550px; display:block;"></div>
						</td>
					</tr>
				</table>
				</fieldset>
			</td>
		</tr>
	</table>
	</div>
	</td>
</tr>
</table>
<!--==============================================5========================================================-->
<table width="780" align="center" cellpadding="0" cellspacing="0" class="tbl">
<tr>
	<td align="center" colspan="9">
	<div id="ditampilkan5" style="display:none" class="tbl" align="center">
	<table>
		<tr>
			<td width="772" align="center">
				<fieldset>
				<table width="500">
					<tr>
						<td width="136" align="center">Implementasi</td>
						<td width="352"><textarea id="inp" rows="2" cols="30"></textarea></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
						<button type="button" id="saveInp" name="saveInp" value="ins" onclick="actI(this.value)" style="cursor:pointer"><img src="../icon/save.gif" align="absmiddle" width="20" />&nbsp;&nbsp;Tambah</button>&nbsp;&nbsp;
			<button type="button" id="gk_sido" name="gk_sido" onclick="fReset5()" style="cursor:pointer"><img src="../icon/back.png" width="20" align="absmiddle" />&nbsp;&nbsp;Batal</button>&nbsp;&nbsp;
			<button type="button" id="hapus15" name="hapus15" onclick="del15()" disabled="disabled" style="cursor:pointer"><img src="../icon/delete2.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Hapus</button>
						</td>
					</tr>
					<tr>
						<td colspan="2"><div id="gridI" align="center" style="width:577px; height: 200px; background-color:white; overflow:hidden;"></div>
							<div id="pagingI" style="width:550px; display:block;"></div>
						</td>
					</tr>
				</table>
				</fieldset>
			</td>
		</tr>
	</table>
	</div>
	</td>
</tr>
</table>
<!--==============================================6========================================================-->
<table width="780" align="center" cellpadding="0" cellspacing="0" class="tbl">
<tr>
	<td align="center" colspan="9">
	<div id="ditampilkan6" style="display:none" class="tbl" align="center">
	<table>
		<tr>
			<td width="772" align="center">
				<fieldset>
				<table width="500">
					<tr>
						<td width="136" align="center">Evaluasi</td>
						<td width="352"><textarea id="eva" rows="2" cols="30"></textarea></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
						<button type="button" id="saveEva" name="saveEva" value="ins" onclick="actE(this.value)" style="cursor:pointer"><img src="../icon/save.gif" align="absmiddle" width="20" />&nbsp;&nbsp;Tambah</button>&nbsp;&nbsp;
			<button type="button" id="gk_sido" name="gk_sido" onclick="fReset6()" style="cursor:pointer"><img src="../icon/back.png" width="20" align="absmiddle" />&nbsp;&nbsp;Batal</button>&nbsp;&nbsp;
			<button type="button" id="hapus16" name="hapus16" onclick="del16()" disabled="disabled" style="cursor:pointer"><img src="../icon/delete2.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Hapus</button>
						</td>
					</tr>
					<tr>
						<td colspan="2"><div id="gridE" align="center" style="width:577px; height: 200px; background-color:white; overflow:hidden;"></div>
							<div id="pagingE" style="width:550px; display:block;"></div>
						</td>
					</tr>
				</table>
				</fieldset>
			</td>
		</tr>
	</table>
	</div>
	</td>
</tr>
</table>
<!--==============================================7========================================================-->
<table width="780" align="center" cellpadding="0" cellspacing="0" class="tbl">
<tr>
	<td align="center" colspan="9">
	<div id="ditampilkan7" style="display:none" class="tbl" align="center">
	<table>
		<tr>
			<td width="772" align="center">
				<fieldset>
				<table width="500">
					<tr>
						<td width="136" align="center">Revisi</td>
						<td width="352"><textarea id="rev" rows="2" cols="30"></textarea></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
						<button type="button" id="saveRev" name="saveRev" value="ins" onclick="actR(this.value)" style="cursor:pointer"><img src="../icon/save.gif" align="absmiddle" width="20" />&nbsp;&nbsp;Tambah</button>&nbsp;&nbsp;
			<button type="button" id="gk_sido" name="gk_sido" onclick="fReset7()" style="cursor:pointer"><img src="../icon/back.png" width="20" align="absmiddle" />&nbsp;&nbsp;Batal</button>&nbsp;&nbsp;
			<button type="button" id="hapus17" name="hapus17" onclick="del17()" disabled="disabled" style="cursor:pointer"><img src="../icon/delete2.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Hapus</button>
						</td>
					</tr>
					<tr>
						<td colspan="2"><div id="gridR" align="center" style="width:577px; height: 200px; background-color:white; overflow:hidden;"></div>
							<div id="pagingR" style="width:550px; display:block;"></div>
						</td>
					</tr>
				</table>
				</fieldset>
			</td>
		</tr>
	</table>
	</div>
	</td>
</tr>
</table>


<input type="hidden" id="txtIdSub" name="txtIdSub" />
<!--=====================================end===================================-->
</body>
<script>


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


jQuery(document).ready(function(){
	jQuery(".tampikanSub1").click(function(){
		jQuery("#ditampilkan1").slideToggle("slow");
		jQuery("#ditampilkan2").hide(1000);
		jQuery("#ditampilkan3").hide(1000);
		jQuery("#ditampilkan4").hide(1000);
		jQuery("#ditampilkan5").hide(1000);
		jQuery("#ditampilkan6").hide(1000);
		jQuery("#ditampilkan7").hide(1000);
		document.getElementById('ganti1').style.textDecoration="blink";
		document.getElementById('ganti1').style.color="#0033FF";
		
		document.getElementById('ganti2').style.textDecoration="";
		document.getElementById('ganti2').style.color="#990033";
		
		document.getElementById('ganti3').style.textDecoration="";
		document.getElementById('ganti3').style.color="#990033";
		
		document.getElementById('ganti4').style.textDecoration="";
		document.getElementById('ganti4').style.color="#990033";
		
		document.getElementById('ganti5').style.textDecoration="";
		document.getElementById('ganti5').style.color="#990033";
		
		document.getElementById('ganti6').style.textDecoration="";
		document.getElementById('ganti6').style.color="#990033";
		
		document.getElementById('ganti7').style.textDecoration="";
		document.getElementById('ganti7').style.color="#990033";
	});
	jQuery(".tampikanSub2").click(function(){
		jQuery("#ditampilkan2").show(1000);
		jQuery("#ditampilkan1").hide(1000);
		jQuery("#ditampilkan3").hide(1000);
		jQuery("#ditampilkan4").hide(1000);
		jQuery("#ditampilkan5").hide(1000);
		jQuery("#ditampilkan6").hide(1000);
		jQuery("#ditampilkan7").hide(1000);
		document.getElementById('ganti1').style.textDecoration="";
		document.getElementById('ganti1').style.color="#990033";
		
		document.getElementById('ganti2').style.textDecoration="blink";
		document.getElementById('ganti2').style.color="#0033FF";
		
		document.getElementById('ganti3').style.textDecoration="";
		document.getElementById('ganti3').style.color="#990033";
		
		document.getElementById('ganti4').style.textDecoration="";
		document.getElementById('ganti4').style.color="#990033";
		
		document.getElementById('ganti5').style.textDecoration="";
		document.getElementById('ganti5').style.color="#990033";
		
		document.getElementById('ganti6').style.textDecoration="";
		document.getElementById('ganti6').style.color="#990033";
		
		document.getElementById('ganti7').style.textDecoration="";
		document.getElementById('ganti7').style.color="#990033";
	});
	jQuery(".tampikanSub3").click(function(){
		jQuery("#ditampilkan3").slideToggle("slow");
		jQuery("#ditampilkan2").hide(1000);
		jQuery("#ditampilkan1").hide(1000);
		jQuery("#ditampilkan4").hide(1000);
		jQuery("#ditampilkan5").hide(1000);
		jQuery("#ditampilkan6").hide(1000);
		jQuery("#ditampilkan7").hide(1000);
		document.getElementById('ganti1').style.textDecoration="";
		document.getElementById('ganti1').style.color="#990033";
		
		document.getElementById('ganti2').style.textDecoration="";
		document.getElementById('ganti2').style.color="#990033";
		
		document.getElementById('ganti3').style.textDecoration="blink";
		document.getElementById('ganti3').style.color="#0033FF";
		
		document.getElementById('ganti4').style.textDecoration="";
		document.getElementById('ganti4').style.color="#990033";
		
		document.getElementById('ganti5').style.textDecoration="";
		document.getElementById('ganti5').style.color="#990033";
		
		document.getElementById('ganti6').style.textDecoration="";
		document.getElementById('ganti6').style.color="#990033";
		
		document.getElementById('ganti7').style.textDecoration="";
		document.getElementById('ganti7').style.color="#990033";
	});
	jQuery(".tampikanSub4").click(function(){
		jQuery("#ditampilkan4").show(1000);
		jQuery("#ditampilkan3").hide(1000);
		jQuery("#ditampilkan2").hide(1000);
		jQuery("#ditampilkan1").hide(1000);
		jQuery("#ditampilkan5").hide(1000);
		jQuery("#ditampilkan6").hide(1000);
		jQuery("#ditampilkan7").hide(1000);
		document.getElementById('ganti1').style.textDecoration="";
		document.getElementById('ganti1').style.color="#990033";
		
		document.getElementById('ganti2').style.textDecoration="";
		document.getElementById('ganti2').style.color="#990033";
		
		document.getElementById('ganti3').style.textDecoration="";
		document.getElementById('ganti3').style.color="#990033";
		
		document.getElementById('ganti4').style.textDecoration="blink";
		document.getElementById('ganti4').style.color="#0033FF";
		
		document.getElementById('ganti5').style.textDecoration="";
		document.getElementById('ganti5').style.color="#990033";
		
		document.getElementById('ganti6').style.textDecoration="";
		document.getElementById('ganti6').style.color="#990033";
		
		document.getElementById('ganti7').style.textDecoration="";
		document.getElementById('ganti7').style.color="#990033";
	});
	jQuery(".tampikanSub5").click(function(){
		jQuery("#ditampilkan5").show(1000);
		jQuery("#ditampilkan3").hide(1000);
		jQuery("#ditampilkan2").hide(1000);
		jQuery("#ditampilkan1").hide(1000);
		jQuery("#ditampilkan4").hide(1000);
		jQuery("#ditampilkan6").hide(1000);
		jQuery("#ditampilkan7").hide(1000);
		document.getElementById('ganti1').style.textDecoration="";
		document.getElementById('ganti1').style.color="#990033";
		
		document.getElementById('ganti2').style.textDecoration="";
		document.getElementById('ganti2').style.color="#990033";
		
		document.getElementById('ganti3').style.textDecoration="";
		document.getElementById('ganti3').style.color="#990033";
		
		document.getElementById('ganti4').style.textDecoration="";
		document.getElementById('ganti4').style.color="#990033";
		
		document.getElementById('ganti5').style.textDecoration="blink";
		document.getElementById('ganti5').style.color="#0033FF";
		
		document.getElementById('ganti6').style.textDecoration="";
		document.getElementById('ganti6').style.color="#990033";
		
		document.getElementById('ganti7').style.textDecoration="";
		document.getElementById('ganti7').style.color="#990033";
	});
	jQuery(".tampikanSub6").click(function(){
		jQuery("#ditampilkan6").show(1000);
		jQuery("#ditampilkan3").hide(1000);
		jQuery("#ditampilkan2").hide(1000);
		jQuery("#ditampilkan1").hide(1000);
		jQuery("#ditampilkan4").hide(1000);
		jQuery("#ditampilkan5").hide(1000);
		jQuery("#ditampilkan7").hide(1000);
		document.getElementById('ganti1').style.textDecoration="";
		document.getElementById('ganti1').style.color="#990033";
		
		document.getElementById('ganti2').style.textDecoration="";
		document.getElementById('ganti2').style.color="#990033";
		
		document.getElementById('ganti3').style.textDecoration="";
		document.getElementById('ganti3').style.color="#990033";
		
		document.getElementById('ganti4').style.textDecoration="";
		document.getElementById('ganti4').style.color="#990033";
		
		document.getElementById('ganti5').style.textDecoration="";
		document.getElementById('ganti5').style.color="#990033";
		
		document.getElementById('ganti6').style.textDecoration="blink";
		document.getElementById('ganti6').style.color="#0033FF";
		
		document.getElementById('ganti7').style.textDecoration="";
		document.getElementById('ganti7').style.color="#990033";
	});
	jQuery(".tampikanSub7").click(function(){
		jQuery("#ditampilkan7").show(1000);
		jQuery("#ditampilkan3").hide(1000);
		jQuery("#ditampilkan2").hide(1000);
		jQuery("#ditampilkan1").hide(1000);
		jQuery("#ditampilkan4").hide(1000);
		jQuery("#ditampilkan5").hide(1000);
		jQuery("#ditampilkan6").hide(1000);
		document.getElementById('ganti1').style.textDecoration="";
		document.getElementById('ganti1').style.color="#990033";
		
		document.getElementById('ganti2').style.textDecoration="";
		document.getElementById('ganti2').style.color="#990033";
		
		document.getElementById('ganti3').style.textDecoration="";
		document.getElementById('ganti3').style.color="#990033";
		
		document.getElementById('ganti4').style.textDecoration="";
		document.getElementById('ganti4').style.color="#990033";
		
		document.getElementById('ganti5').style.textDecoration="";
		document.getElementById('ganti5').style.color="#990033";
		
		document.getElementById('ganti6').style.textDecoration="";
		document.getElementById('ganti6').style.color="#990033";
		
		document.getElementById('ganti7').style.textDecoration="blink";
		document.getElementById('ganti7').style.color="#0033FF";
	});
});

jQuery("#ditampilkan1").slideToggle("slow");
jQuery("#ditampilkan2").hide(1000);
jQuery("#ditampilkan3").hide(1000);
jQuery("#ditampilkan4").hide(1000);
jQuery("#ditampilkan5").hide(1000);
jQuery("#ditampilkan6").hide(1000);
jQuery("#ditampilkan7").hide(1000);
document.getElementById('ganti1').style.textDecoration="blink";
document.getElementById('ganti1').style.color="#0033FF";

document.getElementById('ganti2').style.textDecoration="";
document.getElementById('ganti2').style.color="#990033";

document.getElementById('ganti3').style.textDecoration="";
document.getElementById('ganti3').style.color="#990033";

document.getElementById('ganti4').style.textDecoration="";
document.getElementById('ganti4').style.color="#990033";

document.getElementById('ganti5').style.textDecoration="";
document.getElementById('ganti5').style.color="#990033";

document.getElementById('ganti6').style.textDecoration="";
document.getElementById('ganti6').style.color="#990033";

document.getElementById('ganti7').style.textDecoration="";
document.getElementById('ganti7').style.color="#990033";
<!--------------------------------1-------------------------------------------->
var subj = new DSGridObject("dridSub");
subj.setHeader(" ",false);
subj.setColHeader("No,Nama,Nama Dokter/Perawat,Tanggal");
subj.setIDColHeader(",nama,,");
subj.setColWidth("40,255,70,70");
subj.setCellAlign("center,left,left,center");
subj.setCellType("txt,txt,txt,txt");
subj.setCellHeight(20);
subj.setImgPath("../icon");
subj.setIDPaging("pagingSub");
subj.attachEvent("onRowClick","ambilIdS");
subj.baseURL("soap_utils.php?grd=1&idPel=0&cmbDokter="+document.getElementById('cmbDokSOAPIER').value);
subj.Init();
function actS(par){
	var subs=document.getElementById('sub').value;
	var id=document.getElementById('txtIdSub').value;
	var cmbDok=document.getElementById('cmbDokSOAPIER').value;
	var mnt=document.getElementById('mnt').value;
	//alert("soap_utils.php?cmbDok="+cmbDok+"&grd=1&act="+par+"&subs="+subs+"&id="+id+"&idPel=<?php echo $_REQUEST['idpel'] ?>&tglMaster="+document.getElementById('tglSoap').value+"&cmbDokter="+document.getElementById('cmbDokDiag').value+"&mnt="+mnt+"&jenis="+document.getElementById('asalSOAP').value);
	subj.loadURL("soap_utils.php?cmbDok="+cmbDok+"&grd=1&act="+par+"&subs="+subs+"&id="+id+"&idPel="+getIdPel+"&tglMaster="+document.getElementById('tglSoap').value+"&cmbDokter="+document.getElementById('cmbDokDiag').value+"&mnt="+mnt+"&jenis="+document.getElementById('asalSOAP').value,'','GET');
	fReset1()
}
function ambilIdS(){
var sisip=subj.getRowId(subj.getSelRow()).split("|")
document.getElementById('txtIdSub').value=sisip[0];
document.getElementById('sub').value=subj.cellsGetValue(subj.getSelRow(),2)
document.getElementById('saveSub').innerHTML='<img src="../icon/edit.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Ubah'
document.getElementById('saveSub').value='up';
document.getElementById('hapus1').innerHTML='<img src="../icon/delete.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Hapus'
document.getElementById('hapus1').disabled=false;
}
function fReset1(){
    document.getElementById('sub').value='';
    document.getElementById('txtIdSub').value='';
    document.getElementById('saveSub').innerHTML='<img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Tambah';
    document.getElementById('saveSub').value='ins';
    document.getElementById('hapus1').innerHTML='<img src="../icon/delete2.gif" align="absmiddle" width="20"  />&nbsp;&nbsp;Hapus';
    document.getElementById('hapus1').disabled=true;
	subj.loadURL("soap_utils.php?grd=1&idPel="+getIdPel+"&cmbDokter="+document.getElementById('cmbDokDiag').value,"","GET");

}
function del11(){
    var id=document.getElementById('txtIdSub').value;
    if(confirm("Apakaha anda yakin ingin menghapus data ini !")){
        subj.loadURL("soap_utils.php?grd=1&act=del&id="+id,"","GET");
        fReset1();
    }
}
function goFilterAndSort(abc){
	if (abc=="dridSub"){
		subj.loadURL("soap_utils.php?cmbDokter="+document.getElementById('cmbDokSOAPIER').value+"&grd=1&filter="+subj.getFilter()+"&sorting="+subj.getSorting()+"&page="+subj.getPage(),"","GET");
	}
} 
<!--------------------------------2-------------------------------------------->
var Obj = new DSGridObject("gridObj");
Obj.setHeader(" ",false);
Obj.setColHeader("No,Nama,Nama Dokter,Tanggal");
Obj.setIDColHeader(",nama,,");
Obj.setColWidth("40,255,70,70");
Obj.setCellAlign("center,left,left,center");
Obj.setCellType("txt,txt,txt,txt");
Obj.setCellHeight(20);
Obj.setImgPath("../icon");
Obj.setIDPaging("pagingObj");
Obj.attachEvent("onRowClick","ambilId2");
Obj.baseURL("soap_utils.php?grd=2&idPel=0&cmbDokter="+document.getElementById('cmbDokSOAPIER').value);
Obj.Init();
function actO(par){
	var subs=document.getElementById('obj').value;
	var id=document.getElementById('txtIdSub').value;
	var cmbDok=document.getElementById('cmbDokSOAPIER').value
	var mnt=document.getElementById('mnt').value;
	Obj.loadURL("soap_utils.php?cmbDok="+cmbDok+"&grd=2&act="+par+"&subs="+subs+"&id="+id+"&idPel="+getIdPel+"&tglMaster="+document.getElementById('tglSoap').value+"&cmbDokter="+document.getElementById('cmbDokSOAPIER').value+"&mnt="+mnt+"&jenis="+document.getElementById('asalSOAP').value,"","GET");
	fReset2()
}
function ambilId2(){
var sisip=Obj.getRowId(Obj.getSelRow()).split("|")
document.getElementById('txtIdSub').value=sisip[0];
document.getElementById('obj').value=Obj.cellsGetValue(Obj.getSelRow(),2)
document.getElementById('saveObj').innerHTML='<img src="../icon/edit.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Ubah'
document.getElementById('saveObj').value='up';
document.getElementById('hapus12').innerHTML='<img src="../icon/delete.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Hapus'
document.getElementById('hapus12').disabled=false;
}
function fReset2(){
    document.getElementById('obj').value='';
    document.getElementById('txtIdSub').value='';
    document.getElementById('saveObj').innerHTML='<img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Tambah';
    document.getElementById('saveObj').value='ins';
    document.getElementById('hapus12').innerHTML='<img src="../icon/delete2.gif" align="absmiddle" width="20"  />&nbsp;&nbsp;Hapus';
    document.getElementById('hapus12').disabled=true;
	Obj.loadURL("soap_utils.php?grd=2&idPel="+getIdPel+"&cmbDokter="+document.getElementById('cmbDokSOAPIER').value,"","GET");
}
function del12(){
    var id=document.getElementById('txtIdSub').value;
    if(confirm("Apakaha anda yakin ingin menghapus data ini !")){
        Obj.loadURL("soap_utils.php?grd=2&act=del&id="+id,"","GET");
        fReset2();
    }
}
function goFilterAndSort(abc){
	if (abc=="gridObj"){
		Obj.loadURL("soap_utils.php?idPel="+getIdPel+"&cmbDokter="+document.getElementById('cmbDokSOAPIER').value+"&grd=2&filter="+Obj.getFilter()+"&sorting="+Obj.getSorting()+"&page="+Obj.getPage(),"","GET");
	}
} 
<!--------------------------------3-------------------------------------------->
var Ass = new DSGridObject("gridAss");
Ass.setHeader(" ",false);
Ass.setColHeader("No,Nama,Nama Dokter,Tanggal");
Ass.setIDColHeader(",keterangan,,");
Ass.setColWidth("40,255,70,70");
Ass.setCellAlign("center,left,left,center");
Ass.setCellType("txt,txt,txt,txt");
Ass.setCellHeight(20);
Ass.setImgPath("../icon");
Ass.setIDPaging("pagingAss");
Ass.attachEvent("onRowClick","ambilId3");
Ass.baseURL("soap_utils.php?grd=3&idPel=0&cmbDokter="+document.getElementById('cmbDokSOAPIER').value);
Ass.Init();
function actA(par){
	var subs=document.getElementById('ass').value;
	var id=document.getElementById('txtIdSub').value;
	var cmbDok=document.getElementById('cmbDokSOAPIER').value;
	var mnt=document.getElementById('mnt').value;
	Ass.loadURL("soap_utils.php?cmbDok="+cmbDok+"&grd=3&act="+par+"&subs="+subs+"&id="+id+"&idPel="+getIdPel+"&tglMaster="+document.getElementById('tglSoap').value+"&cmbDokter="+document.getElementById('cmbDokSOAPIER').value+"&mnt="+mnt+"&jenis="+document.getElementById('asalSOAP').value,'','GET');
	fReset3()
}
function ambilId3(){
var sisip=Ass.getRowId(Ass.getSelRow()).split("|")
document.getElementById('txtIdSub').value=sisip[0];
document.getElementById('ass').value=Ass.cellsGetValue(Ass.getSelRow(),2)
document.getElementById('saveAss').innerHTML='<img src="../icon/edit.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Ubah'
document.getElementById('saveAss').value='up';
document.getElementById('hapus13').innerHTML='<img src="../icon/delete.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Hapus'
document.getElementById('hapus13').disabled=false;
}
function fReset3(){
    document.getElementById('ass').value='';
    document.getElementById('txtIdSub').value='';
    document.getElementById('saveAss').innerHTML='<img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Tambah';
    document.getElementById('saveAss').value='ins';
    document.getElementById('hapus13').innerHTML='<img src="../icon/delete2.gif" align="absmiddle" width="20"  />&nbsp;&nbsp;Hapus';
    document.getElementById('hapus13').disabled=true;
	Ass.loadURL("soap_utils.php?grd=3&idPel="+getIdPel+"&cmbDokter="+document.getElementById('cmbDokSOAPIER').value,"","GET");

}
function del13(){
    var id=document.getElementById('txtIdSub').value;
    if(confirm("Apakaha anda yakin ingin menghapus data ini !")){
        Ass.loadURL("soap_utils.php?grd=3&act=del&id="+id,"","GET");
        fReset3();
    }
}
function goFilterAndSort(abc){
	if (abc=="gridAss"){
		Ass.loadURL("soap_utils.php?idPel="+getIdPel+"&cmbDokter="+document.getElementById('cmbDokSOAPIER').value+"&grd=3&filter="+Ass.getFilter()+"&sorting="+Ass.getSorting()+"&page="+Ass.getPage(),"","GET");
	}
}
<!--------------------------------4-------------------------------------------->
var Plan = new DSGridObject("gridPlan");
Plan.setHeader(" ",false);
Plan.setColHeader("No,Nama,Nama Dokter,Tanggal");
Plan.setIDColHeader(",nama,,");
Plan.setColWidth("40,255,70,70");
Plan.setCellAlign("center,left,left,center");
Plan.setCellType("txt,txt,txt,txt");
Plan.setCellHeight(20);
Plan.setImgPath("../icon");
Plan.setIDPaging("pagingPlan");
Plan.attachEvent("onRowClick","ambilId4");
Plan.baseURL("soap_utils.php?grd=4&idPel=0&cmbDokter="+document.getElementById('cmbDokSOAPIER').value);
Plan.Init();
function actP(par){
	var subs=document.getElementById('plan').value;
	var id=document.getElementById('txtIdSub').value;
	var cmbDok=document.getElementById('cmbDokSOAPIER').value
	var mnt=document.getElementById('mnt').value;
	Plan.loadURL("soap_utils.php?cmbDok="+cmbDok+"&grd=4&act="+par+"&subs="+subs+"&id="+id+"&idPel="+getIdPel+"&tglMaster="+document.getElementById('tglSoap').value+"&cmbDokter="+document.getElementById('cmbDokSOAPIER').value+"&mnt="+mnt+"&jenis="+document.getElementById('asalSOAP').value,'','GET');
	fReset4()
}
function ambilId4(){
var sisip=Plan.getRowId(Plan.getSelRow()).split("|")
document.getElementById('txtIdSub').value=sisip[0];
document.getElementById('plan').value=Plan.cellsGetValue(Plan.getSelRow(),2)
document.getElementById('savePlan').innerHTML='<img src="../icon/edit.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Ubah'
document.getElementById('savePlan').value='up';
document.getElementById('hapus14').innerHTML='<img src="../icon/delete.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Hapus'
document.getElementById('hapus14').disabled=false;
}
function fReset4(){
    document.getElementById('plan').value='';
    document.getElementById('txtIdSub').value='';
    document.getElementById('savePlan').innerHTML='<img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Tambah';
    document.getElementById('savePlan').value='ins';
    document.getElementById('hapus14').innerHTML='<img src="../icon/delete2.gif" align="absmiddle" width="20"  />&nbsp;&nbsp;Hapus';
    document.getElementById('hapus14').disabled=true;
	Plan.loadURL("soap_utils.php?grd=4&idPel="+getIdPel+"&cmbDokter="+document.getElementById('cmbDokSOAPIER').value,"","GET");
}
function del14(){
    var id=document.getElementById('txtIdSub').value;
    if(confirm("Apakaha anda yakin ingin menghapus data ini !")){
        Plan.loadURL("soap_utils.php?grd=4&act=del&id="+id,"","GET");
        fReset4();
    }
}
function goFilterAndSort(abc){
	if (abc=="gridAss"){
		Plan.loadURL("soap_utils.php?idPel="+getIdPel+"&cmbDokter="+document.getElementById('cmbDokSOAPIER').value+"&grd=4&filter="+Plan.getFilter()+"&sorting="+Plan.getSorting()+"&page="+Plan.getPage(),"","GET");
	}
}

<!--------------------------------5-------------------------------------------->
var gi = new DSGridObject("gridI");
gi.setHeader(" ",false);
gi.setColHeader("No,Nama,Nama Dokter,Tanggal");
gi.setIDColHeader(",keterangan,,");
gi.setColWidth("40,255,70,70");
gi.setCellAlign("center,left,left,center");
gi.setCellType("txt,txt,txt,txt");
gi.setCellHeight(20);
gi.setImgPath("../icon");
gi.setIDPaging("pagingI");
gi.attachEvent("onRowClick","ambilId5");
gi.baseURL("soap_utils.php?grd=5&idPel=0&cmbDokter="+document.getElementById('cmbDokSOAPIER').value);
gi.Init();
function actI(par){
	var subs=document.getElementById('inp').value;
	var id=document.getElementById('txtIdSub').value;
	var cmbDok=document.getElementById('cmbDokSOAPIER').value;
	var mnt=document.getElementById('mnt').value;
	gi.loadURL("soap_utils.php?cmbDok="+cmbDok+"&grd=5&act="+par+"&subs="+subs+"&id="+id+"&idPel="+getIdPel+"&tglMaster="+document.getElementById('tglSoap').value+"&cmbDokter="+document.getElementById('cmbDokSOAPIER').value+"&mnt="+mnt+"&jenis="+document.getElementById('asalSOAP').value,'','GET');
	fReset5();
}
function ambilId5(){
var sisip=gi.getRowId(gi.getSelRow()).split("|");
document.getElementById('txtIdSub').value=sisip[0];
document.getElementById('inp').value=gi.cellsGetValue(gi.getSelRow(),2);
document.getElementById('saveInp').innerHTML='<img src="../icon/edit.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Ubah'
document.getElementById('saveInp').value='up';
document.getElementById('hapus15').innerHTML='<img src="../icon/delete.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Hapus'
document.getElementById('hapus15').disabled=false;
}
function fReset5(){
    document.getElementById('inp').value='';
    document.getElementById('txtIdSub').value='';
    document.getElementById('saveInp').innerHTML='<img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Tambah';
    document.getElementById('saveInp').value='ins';
    document.getElementById('hapus15').innerHTML='<img src="../icon/delete2.gif" align="absmiddle" width="20"  />&nbsp;&nbsp;Hapus';
    document.getElementById('hapus15').disabled=true;
	gi.loadURL("soap_utils.php?grd=5&idPel="+getIdPel+"&cmbDokter="+document.getElementById('cmbDokSOAPIER').value,"","GET");

}
function del15(){
    var id=document.getElementById('txtIdSub').value;
    if(confirm("Apakaha anda yakin ingin menghapus data ini !")){
        Ass.loadURL("soap_utils.php?grd=5&act=del&id="+id,"","GET");
        fReset5();
    }
}
function goFilterAndSort(abc){
	if (abc=="gridI"){
		gi.loadURL("soap_utils.php?idPel="+getIdPel+"&cmbDokter="+document.getElementById('cmbDokSOAPIER').value+"&grd=5&filter="+gi.getFilter()+"&sorting="+gi.getSorting()+"&page="+gi.getPage(),"","GET");
	}
}
<!--------------------------------6-------------------------------------------->
var ge = new DSGridObject("gridE");
ge.setHeader(" ",false);
ge.setColHeader("No,Nama,Nama Dokter,Tanggal");
ge.setIDColHeader(",keterangan,,");
ge.setColWidth("40,255,70,70");
ge.setCellAlign("center,left,left,center");
ge.setCellType("txt,txt,txt,txt");
ge.setCellHeight(20);
ge.setImgPath("../icon");
ge.setIDPaging("pagingE");
ge.attachEvent("onRowClick","ambilId6");
ge.baseURL("soap_utils.php?grd=6&idPel=0&cmbDokter="+document.getElementById('cmbDokSOAPIER').value);
ge.Init();
function actE(par){
	var subs=document.getElementById('eva').value;
	var id=document.getElementById('txtIdSub').value;
	var cmbDok=document.getElementById('cmbDokSOAPIER').value;
	var mnt=document.getElementById('mnt').value;
	ge.loadURL("soap_utils.php?cmbDok="+cmbDok+"&grd=6&act="+par+"&subs="+subs+"&id="+id+"&idPel="+getIdPel+"&tglMaster="+document.getElementById('tglSoap').value+"&cmbDokter="+document.getElementById('cmbDokSOAPIER').value+"&mnt="+mnt+"&jenis="+document.getElementById('asalSOAP').value,'','GET');
	fReset6()
}
function ambilId6(){
var sisip=ge.getRowId(ge.getSelRow()).split("|")
document.getElementById('txtIdSub').value=sisip[0];
document.getElementById('eva').value=ge.cellsGetValue(ge.getSelRow(),2)
document.getElementById('saveEva').innerHTML='<img src="../icon/edit.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Ubah'
document.getElementById('saveEva').value='up';
document.getElementById('hapus16').innerHTML='<img src="../icon/delete.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Hapus'
document.getElementById('hapus16').disabled=false;
}
function fReset6(){
    document.getElementById('eva').value='';
    document.getElementById('txtIdSub').value='';
    document.getElementById('saveEva').innerHTML='<img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Tambah';
    document.getElementById('saveEva').value='ins';
    document.getElementById('hapus16').innerHTML='<img src="../icon/delete2.gif" align="absmiddle" width="20"  />&nbsp;&nbsp;Hapus';
    document.getElementById('hapus16').disabled=true;
	ge.loadURL("soap_utils.php?grd=6&idPel="+getIdPel+"&cmbDokter="+document.getElementById('cmbDokSOAPIER').value,"","GET");

}
function del16(){
    var id=document.getElementById('txtIdSub').value;
    if(confirm("Apakaha anda yakin ingin menghapus data ini !")){
        ge.loadURL("soap_utils.php?grd=6&act=del&id="+id,"","GET");
        fReset6();
    }
}
function goFilterAndSort(abc){
	if (abc=="gridE"){
		ge.loadURL("soap_utils.php?idPel="+getIdPel+"&cmbDokter="+document.getElementById('cmbDokSOAPIER').value+"&grd=6&filter="+ge.getFilter()+"&sorting="+ge.getSorting()+"&page="+ge.getPage(),"","GET");
	}
}
<!--------------------------------7-------------------------------------------->
var gr = new DSGridObject("gridR");
gr.setHeader(" ",false);
gr.setColHeader("No,Nama,Nama Dokter,Tanggal");
gr.setIDColHeader(",keterangan,,");
gr.setColWidth("40,255,70,70");
gr.setCellAlign("center,left,left,center");
gr.setCellType("txt,txt,txt,txt");
gr.setCellHeight(20);
gr.setImgPath("../icon");
gr.setIDPaging("pagingR");
gr.attachEvent("onRowClick","ambilId7");
gr.baseURL("soap_utils.php?grd=7&idPel=0&cmbDokter="+document.getElementById('cmbDokSOAPIER').value);
gr.Init();
function actR(par){
	var subs=document.getElementById('rev').value;
	var id=document.getElementById('txtIdSub').value;
	var cmbDok=document.getElementById('cmbDokSOAPIER').value;
	var mnt=document.getElementById('mnt').value;
	gr.loadURL("soap_utils.php?cmbDok="+cmbDok+"&grd=7&act="+par+"&subs="+subs+"&id="+id+"&idPel="+getIdPel+"&tglMaster="+document.getElementById('tglSoap').value+"&cmbDokter="+document.getElementById('cmbDokSOAPIER').value+"&mnt="+mnt+"&jenis="+document.getElementById('asalSOAP').value,'','GET');
	fReset7();
}
function ambilId7(){
var sisip=gr.getRowId(gr.getSelRow()).split("|")
document.getElementById('txtIdSub').value=sisip[0];
document.getElementById('rev').value=gr.cellsGetValue(gr.getSelRow(),2)
document.getElementById('saveRev').innerHTML='<img src="../icon/edit.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Ubah'
document.getElementById('saveRev').value='up';
document.getElementById('hapus17').innerHTML='<img src="../icon/delete.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Hapus'
document.getElementById('hapus17').disabled=false;
}
function fReset7(){
    document.getElementById('rev').value='';
    document.getElementById('txtIdSub').value='';
    document.getElementById('saveRev').innerHTML='<img src="../icon/save.gif" width="20" align="absmiddle" />&nbsp;&nbsp;Tambah';
    document.getElementById('saveRev').value='ins';
    document.getElementById('hapus17').innerHTML='<img src="../icon/delete2.gif" align="absmiddle" width="20"  />&nbsp;&nbsp;Hapus';
    document.getElementById('hapus17').disabled=true;
	gr.loadURL("soap_utils.php?grd=7&idPel="+getIdPel+"&cmbDokter="+document.getElementById('cmbDokSOAPIER').value,"","GET");

}
function del17(){
    var id=document.getElementById('txtIdSub').value;
    if(confirm("Apakaha anda yakin ingin menghapus data ini !")){
        gr.loadURL("soap_utils.php?grd=7&act=del&id="+id,"","GET");
        fReset7();
    }
}
function goFilterAndSort(abc){
	if (abc=="gridE"){
		gr.loadURL("soap_utils.php?idPel="+getIdPel+"&cmbDokter="+document.getElementById('cmbDokSOAPIER').value+"&grd=6&filter="+gr.getFilter()+"&sorting="+gr.getSorting()+"&page="+gr.getPage(),"","GET");
	}
}
//===================================================================================
function ampek(parameter){
	subj.loadURL("soap_utils.php?grd=1&cmbDokter="+parameter+"&idPel="+getIdPel,"","GET");
	Obj.loadURL("soap_utils.php?grd=2&cmbDokter="+parameter+"&idPel="+getIdPel,"","GET");
	Ass.loadURL("soap_utils.php?grd=3&cmbDokter="+parameter+"&idPel="+getIdPel,"","GET");
	Plan.loadURL("soap_utils.php?grd=4&cmbDokter="+parameter+"&idPel="+getIdPel,"","GET");
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
