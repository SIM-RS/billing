<?php
session_start();
include "../sesi.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script type="text/JavaScript" language="JavaScript" src="../include/jquery/jquery-1.9.1.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<title>Informasi Kunjungan</title>
</head>

<body>
<script>
	var arrRange=depRange=[];
</script>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
	id="gToday:normal:agenda.js"
	src="../theme/popcjs.php" scrolling="no"
	frameborder="1"
	style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>
<div align="center">
<?php
	include("../koneksi/konek.php");
	include("../header1.php");
	$date_now=gmdate('d-m-Y',mktime(date('H')+7));
	$exTgl=explode('-',$date_now);
	$tglAwl="01-".$exTgl[1]."-".$exTgl[2];
?>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/dsgrid_sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;INFORMASI KUNJUNGAN</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tabel" align="center">
  <tr>
    <td colspan="8">&nbsp;</td>
  </tr>
  <tr>
  <td width="1%">&nbsp;</td>
    <td width="12%" align="right">Jenis Layanan&nbsp;</td>
    <td width="15%">&nbsp;<select id="JnsLayanan" name="JnsLayanan" onchange="showTmpLay();viewKamar()" class="txtinput"></select></td>
    <td width="16%">&nbsp;</td>
	<td style="visibility:hidden">Status Pulang</td>
    <td align="left" colspan="2" style="visibility:hidden"><select name="statusPul" id="statusPul" class="txtinput" onchange="goFilterAndSort('gridbox');">
        <option value="">Semua</option>
        <option value="0">Belum Pulang</option>
        <option value="1">Sudah Pulang</option>
      </select></td>
  <td>&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td align="right">Tempat Layanan&nbsp;</td>
    <td>&nbsp;<select id="TmpLayanan" name="TmpLayanan" onchange="showTabel();" class="txtinput"></select></td>
    <td>&nbsp;</td>
    <td width="10%" align="right">Tanggal :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td colspan="2"><input id="tglMsk" name="tglMsk" size="10" value="<?php echo $date_now?>" class="txtcenter" />&nbsp;<input type="button" class="btninput" id="btnTglAwal" name="btnTgl" value=" V " onClick="gfPop.fPopCalendar(document.getElementById('tglMsk'),depRange,showTabel);" /> 
    s/d&nbsp;
    <input id="tglSelesai" name="tglSelesai" size="10" value="<?php echo $date_now?>" class="txtcenter" />&nbsp;<input type="button" class="btninput" id="btnTglAkhir" name="btnTgl" value=" V " onClick="gfPop.fPopCalendar(document.getElementById('tglSelesai'),depRange,showTabel);" /></td>
	<td width="2%">&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td align="right">Status Pasien&nbsp;</td>
    <td colspan="2">&nbsp;<select name="StatusPas" id="StatusPas" onchange="showTabel();" class="txtinput"></select></td>
    <td colspan="3" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<!--input type="checkbox" name="byTgl" id="byTgl" value="0" onclick="if(this.checked==true) this.value=1; else this.value=0; goFilterAndSort('gridbox');" />&nbsp;Tampilkan semua data sesuai periode yang dipilih--></td>
  <td>&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="37%">&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td colspan="6">
		<div id="gridbox" style="width:925px; height:350px; background-color:white; overflow:hidden;"></div>
		<div id="paging" style="width:925px;"></div></td>
  <td>&nbsp;</td>
  </tr>
  <tr><td colspan="8">&nbsp;</td></tr>
  <tr>
  <td>&nbsp;</td>
    <td colspan="3"><b>Jumlah Pasien Pulang : <span id="spanPul">0</span> Orang, Pasien Belum Pulang : <span id="spanBel">0</span> Orang</b></td>
    <td>&nbsp;</td>
    <td colspan="2"><b>Total Pasien : <span id="spanTot">0</span> Orang</b></td>
    <td><b>&nbsp;</b></td>
  <td width="0%">&nbsp;</td>
  </tr>
   <tr>
  	<td colspan="8">&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <!--<td colspan="3"><b>Jumlah Pasien Pulang : <span id="spanPul">0</span> Orang, Pasien Belum Pulang : <span id="spanBel">0</span> Orang</b></td>-->
    <td colspan="2"><b>Total Pasien Umum : <span id="umum">0</span> Orang</b></td>
    <td colspan="2"><b>Total Pasien Multiguna : <span id="multi">0</span> Orang</b></td>
    <td colspan="2"><b>Total Pasien BPJS : <span id="bpjs">0</span> Orang</b></td>
    <td colspan="2"><b>&nbsp;</b></td>
  <td width="0%">&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="8">&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td colspan="4"><b>Jumlah pengunjung Baru : <span id="spanBar">0</span> Orang, Jumlah pengunjung lama : <span id="spanLam">0</span> Orang</b></td>
    <!--<td>&nbsp;</td>-->
    <td colspan="2">&nbsp;</td>
    <td><b>&nbsp;</b></td>
  <td width="0%">&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="8">&nbsp;</td>
  </tr>
  <tr>
  	<td colspan="8">&nbsp;<div id="load1"></div></td>
	<div id="divHid" style="display:none"></div>
  </tr>
  </table>
  <!--table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
  <tr height="30">
    <td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center"><input type="button" value="&nbsp;&nbsp;&nbsp;Preview&nbsp;&nbsp;&nbsp;" /></td>
    <td align="center"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" /></a></td>
  </tr>
</table-->
</div>
</body>
<script>	
	var a=new DSGridObject("gridbox");
	var isLoaded=0;
	
	function isiCombo(id,val,defaultId,targetId,evloaded){
		//alert('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET');
		if(targetId=='' || targetId==undefined){
			targetId=id;
		}
		Request('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded);
	}
	
	function isiCombo1(id,val,defaultId,targetId,evloaded){
		//alert('../combo_utils.php?id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET');
		if(targetId=='' || targetId==undefined){
			targetId=id;
		}
		Request('../combo_utils.php?id='+id+'&value='+val+'&all=1&defaultId='+defaultId,targetId,'','GET',evloaded);
	}

	isiCombo1('StatusPas');
	isiCombo('JnsLayanan','','','',showTmpLay);

	function showTmpLay(){
		isiCombo('TmpLayananDenganSemua',document.getElementById('JnsLayanan').value,'','TmpLayanan',loadGrid);
	}
	
	function loadGrid(){
		//setTimeout('showTabel()',36000);
		if (isLoaded==0){
			a.setHeader("DATA PASIEN");
			a.setColHeader("NO,JENIS LAYANAN,TEMPAT LAYANAN,TGL MULAI,TGL SELESAI,NO RM,NAMA PASIEN,ALAMAT,STATUS PASIEN,DILAYANI");
			a.setIDColHeader(",jns_layanan,tmp_layanan,,,no_rm,nama,alamat,statuspas,status_dilayani");
			a.setColWidth("30,150,150,100,100,75,120,150,100,100");
			a.setCellAlign("center,center,center,center,center,center,left,center,center,center");
			a.setCellHeight(20);
			a.setImgPath("../icon");
			a.setIDPaging("paging");
			//a.attachEvent("onRowDblClick","tes1");
			a.onLoaded(info);
			//alert("tabel_utils.php?grd1=true&jns="+document.getElementById('JnsLayanan').value+"&tmp="+document.getElementById('TmpLayanan').value+"&sts="+document.getElementById('StatusPas').value+"&tglMsk="+document.getElementById('tglMsk').value+"&tglSls="+document.getElementById('tglSelesai').value+"&stsPul="+document.getElementById('statusPul').value);
			a.baseURL("tabel_utils.php?grd1=true&jns="+document.getElementById('JnsLayanan').value+"&tmp="+document.getElementById('TmpLayanan').value+"&sts="+document.getElementById('StatusPas').value+"&tglMsk="+document.getElementById('tglMsk').value+"&tglSls="+document.getElementById('tglSelesai').value+"&stsPul="+document.getElementById('statusPul').value);
			//alert("tabel_utils.php?grd1=true&jns="+document.getElementById('JnsLayanan').value+"&tmp="+document.getElementById('TmpLayanan').value+"&sts="+document.getElementById('StatusPas').value+"&tglMsk="+document.getElementById('tglMsk').value+"&tglSls="+document.getElementById('tglSelesai').value+"&stsPul="+document.getElementById('statusPul').value);
			a.Init();
			isLoaded=1;
		}else{
			goFilterAndSort("gridbox");
		}
	}
	
	function showTabel(){	
		//alert("tabel_utils.php?grd1=true&jns="+document.getElementById('JnsLayanan').value+"&tmp="+document.getElementById('TmpLayanan').value+"&sts="+document.getElementById('StatusPas').value+"&tglMsk="+document.getElementById('tglMsk').value+"&tglSls="+document.getElementById('tglSelesai').value+"&stsPul="+document.getElementById('statusPul').value+"&byTgl=");
		//a.loadURL("tabel_utils.php?grd1=true&jns="+document.getElementById('JnsLayanan').value+"&tmp="+document.getElementById('TmpLayanan').value+"&sts="+document.getElementById('StatusPas').value+"&tglMsk="+document.getElementById('tglMsk').value+"&tglSls="+document.getElementById('tglSelesai').value+"&stsPul="+document.getElementById('statusPul').value+"&byTgl=","","GET");
		goFilterAndSort("gridbox");
	}
	
	function goFilterAndSort(grd){
		if (grd=="gridbox"){
			//alert("tabel_utils.php?grd1=true&jns="+document.getElementById('JnsLayanan').value+"&tmp="+document.getElementById('TmpLayanan').value+"&sts="+document.getElementById('StatusPas').value+"&tglMsk="+document.getElementById('tglMsk').value+"&tglSls="+document.getElementById('tglSelesai').value+"&stsPul="+document.getElementById('statusPul').value+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
			//a.loadURL("tabel_utils.php?grd1=true&jns="+document.getElementById('JnsLayanan').value+"&tmp="+document.getElementById('TmpLayanan').value+"&sts="+document.getElementById('StatusPas').value+"&tglMsk="+document.getElementById('tglMsk').value+"&tglSls="+document.getElementById('tglSelesai').value+"&stsPul="+document.getElementById('statusPul').value+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
			viewKamar();
		}
	}
	
	function info(){
		//alert(a.getMaxPage());
		if (a.getMaxPage()>0){
			//alert("tabel_utils.php?grd1=getVal&jns="+document.getElementById('JnsLayanan').value+"&tmp="+document.getElementById('TmpLayanan').value+"&sts="+document.getElementById('StatusPas').value+"&tglMsk="+document.getElementById('tglMsk').value+"&tglSls="+document.getElementById('tglSelesai').value+"&stsPul="+document.getElementById('statusPul').value);
			Request("tabel_utils.php?grd1=getVal&jns="+document.getElementById('JnsLayanan').value+"&tmp="+document.getElementById('TmpLayanan').value+"&sts="+document.getElementById('StatusPas').value+"&tglMsk="+document.getElementById('tglMsk').value+"&tglSls="+document.getElementById('tglSelesai').value+"&stsPul="+document.getElementById('statusPul').value,'divHid','','GET',att,'ok');
		}
	}
	
	function att(){
		var info = document.getElementById('divHid').innerHTML.split('|');
		document.getElementById('spanPul').innerHTML = info[1];
		document.getElementById('spanBel').innerHTML = info[2];
		document.getElementById('spanTot').innerHTML = info[0];
	}
	function viewKamar(){
		var zxc = document.getElementById('JnsLayanan').value;
		//alert(zxc);
		if(zxc=='27'){
			a.setHeader("DATA PASIEN");
			a.setColHeader("NO,JENIS LAYANAN,TEMPAT LAYANAN,KAMAR,TGL MULAI,TGL SELESAI,NO RM,NAMA PASIEN,ALAMAT,STATUS PASIEN,PULANG");
			a.setIDColHeader(",jns_layanan,tmp_layanan,,,,no_rm,nama,alamat,statuspas,status_pulang");
			a.setColWidth("30,150,150,100,100,100,75,120,150,100,100");
			a.setCellAlign("center,center,center,center,center,center,center,left,center,center,center");
			a.setCellHeight(20);
			a.setImgPath("../icon");
			//alert("tabel_utils.php?grd1=true&jns="+document.getElementById('JnsLayanan').value+"&tmp="+document.getElementById('TmpLayanan').value+"&sts="+document.getElementById('StatusPas').value+"&tglMsk="+document.getElementById('tglMsk').value+"&tglSls="+document.getElementById('tglSelesai').value+"&stsPul="+document.getElementById('statusPul').value+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&inap=1");
			a.loadURL("tabel_utils.php?grd1=true&jns="+document.getElementById('JnsLayanan').value+"&tmp="+document.getElementById('TmpLayanan').value+"&sts="+document.getElementById('StatusPas').value+"&tglMsk="+document.getElementById('tglMsk').value+"&tglSls="+document.getElementById('tglSelesai').value+"&stsPul="+document.getElementById('statusPul').value+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&inap=1","","GET");
		}
		else{
			a.setHeader("DATA PASIEN");
			a.setColHeader("NO,JENIS LAYANAN,TEMPAT LAYANAN,TGL MULAI,TGL SELESAI,NO RM,NAMA PASIEN,ALAMAT,STATUS PASIEN,DILAYANI");
			a.setIDColHeader(",jns_layanan,tmp_layanan,,,no_rm,nama,alamat,statuspas,status_dilayani");
			a.setColWidth("30,150,150,100,100,75,120,150,100,100");
			a.setCellAlign("center,center,center,center,center,center,left,center,center,center");
			a.setCellHeight(20);
			a.setImgPath("../icon");
			a.loadURL("tabel_utils.php?grd1=true&jns="+document.getElementById('JnsLayanan').value+"&tmp="+document.getElementById('TmpLayanan').value+"&sts="+document.getElementById('StatusPas').value+"&tglMsk="+document.getElementById('tglMsk').value+"&tglSls="+document.getElementById('tglSelesai').value+"&stsPul="+document.getElementById('statusPul').value+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
		}
	}
	
	function loadGrid12(){
		setTimeout('showTabel()',"5000");
	}
	
	function showTabel(){
		var zxc = document.getElementById('JnsLayanan').value;
		//alert(zxc);
		if(zxc=='27'){
			a.loadURL("tabel_utils.php?grd1=true&jns="+document.getElementById('JnsLayanan').value+"&tmp="+document.getElementById('TmpLayanan').value+"&sts="+document.getElementById('StatusPas').value+"&tglMsk="+document.getElementById('tglMsk').value+"&tglSls="+document.getElementById('tglSelesai').value+"&stsPul="+document.getElementById('statusPul').value+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage()+"&inap=1","","GET");
		}else{
			a.loadURL("tabel_utils.php?grd1=true&jns="+document.getElementById('JnsLayanan').value+"&tmp="+document.getElementById('TmpLayanan').value+"&sts="+document.getElementById('StatusPas').value+"&tglMsk="+document.getElementById('tglMsk').value+"&tglSls="+document.getElementById('tglSelesai').value+"&stsPul="+document.getElementById('statusPul').value,"","GET");
		}
		//alert("sm_utils.php?grd1=true&jns="+document.getElementById('JnsLayanan').value+"&tmp="+document.getElementById('TmpLayanan').value+"&nama="+document.getElementById('nama').value+"&tglMsk="+document.getElementById('tglMsk').value+"&tglSls="+document.getElementById('tglSelesai').value+"&norm="+document.getElementById('norm').value+"&status_m="+document.getElementById('cmb_sm').value);
		jQuery("#load1").load("update_in_out.php?tglMsk="+document.getElementById('tglMsk').value+"&tglSls="+document.getElementById('tglSelesai').value+"&parent_id="+document.getElementById('JnsLayanan').value);
		setTimeout('showTabel()',"5000");
	}
	
	loadGrid12();
</script>
</html>
