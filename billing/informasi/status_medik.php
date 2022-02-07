<?php
session_start();
include "../sesi.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="javascript" src="../jquery.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<script language="JavaScript" src="../theme/js/ajax.js"></script>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<title>Status Medik</title>
</head>

<body onload="start1();">
<script>
	var arrRange=depRange=[];
</script>
<div id="load1"></div>
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
		<td height="30">&nbsp;STATUS MEDIK</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tabel" align="center">
  <tr>
    <td colspan="7">&nbsp;</td>
  </tr>
  <form id="form1" action="sm_report.php" method="post" target="sm_report">
  <tr>
  <td width="0%">&nbsp;</td>
    <td width="15%" align="left">Jenis Layanan&nbsp;</td>
    <td width="17%">:&nbsp;
      <select id="JnsLayanan" name="JnsLayanan" onchange="showTmpLay();" class="txtinput"></select></td>
    <td colspan=2>&nbsp;</td>
    <td width="11%" align="left">No. RM</td>
    <td width="41%" align="left" >:&nbsp;
	<input type="text" id="norm" name="norm" onkeyup="showTabel()" class="txtinput" />    </td>
	<!--td colspan=2 align="left">Status Pulang</td>
    <td align="left" colspan="2">:&nbsp;
    <select name="norm" id="norm" class="txtinput" onchange="showTabel()">
        <option value="">Semua</option>
        <option value="0">Belum Pulang</option>
        <option value="1">Sudah Pulang</option>
      </select>
    </td-->
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td align="left">Tempat Layanan&nbsp;</td>
    <td>:&nbsp;
    <select id="TmpLayanan" name="TmpLayanan" onchange="showTabel();" class="txtinput"></select>    </td>
    <td colspan=2>&nbsp;</td>
    <td align="left">Nama</td>
    <td>:&nbsp;
    <input type="text" id="nama" name="nama" class="txtinput" onkeyup="showTabel()" />    </td>
    <!--td colspan=2 align="left">Status Pasien</td>
    <td colspan=2>:&nbsp;
    <select name="nama" id="nama" onchange="showTabel();" class="txtinput"></select>
    </td-->
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td width="15%" align="left">Tanggal</td>
    <td colspan="3">:&nbsp;
    <input id="tglMsk" name="tglMsk" size="10" value="<?php echo $date_now?>" class="txtcenter" />&nbsp;<input type="button" class="tblBtn" id="btnTglAwal" name="btnTgl" value=" V " onClick="gfPop.fPopCalendar(document.getElementById('tglMsk'),depRange,showTabel);" /> 
    s/d&nbsp;
    <input id="tglSelesai" name="tglSelesai" size="10" value="<?php echo $date_now?>" class="txtcenter" />&nbsp;<input type="button" class="tblBtn" id="btnTglAkhir" name="btnTgl" value=" V " onClick="gfPop.fPopCalendar(document.getElementById('tglSelesai'),depRange,showTabel);" />
		<span id="spanSuk" style="padding-left:30px;position:absolute;color:#ff0000"></span>    </td>
    <td align="left">Status Medik</td>
    <td>:&nbsp;
    <select id="cmb_sm" name="cmb_sm" class="txtinput" onchange="showTabel()">
		<option value=0>Belum</option>
		<option value=1>Sudah</option>
		<option value=2>Semua</option>
    </select>
    <input type="hidden" id="p_id" name="p_id" value="<?php echo $_SESSION['userId'];?>" />
    <input type="submit" name="btnPrint" id="btnPrint" value="Print Report" class="tblBtn" />    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left">Set Waktu Tracer (Detik)</td>
    <td colspan="3">: 
      <input type="text" id="sWTimer" class="txtinput" size="30" />
    <input type="button" value="SET" onclick="setSekarang();" /></td>
    <td align="left">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </form>
  <tr>
  <td>&nbsp;</td>
    <td colspan="6" style="padding-top:20px;">
		<div id="gridbox" style="width:925px; height:330px; background-color:white; overflow:hidden;"></div>
		<div id="paging" style="width:925px;"></div>    </td>
  </tr>
  <tr><td colspan="7">&nbsp;</td></tr>
  <!--tr>
  <td>&nbsp;</td>
    <td colspan="3"><b>Jumlah Pasien Pulang : <span id="spanPul">0</span> Orang, Pasien Belum Pulang : <span id="spanBel">0</span> Orang</b></td>
    <td>&nbsp;</td>
    <td colspan="2"><b>Total Pasien : <span id="spanTot"></span></b></td>
  </tr-->
  <tr>
  	<td colspan="7">&nbsp;</td>
	<div id="divHid" style="display:none"></div>
  </tr>
  </table>
  <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
  <tr height="30">
    <td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center"><input type="button" value="&nbsp;&nbsp;&nbsp;Preview&nbsp;&nbsp;&nbsp;" /></td>
    <td align="center"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" /></a></td>
  </tr>
</table>
</div>
</body>
<script>
	var waktu1 = 0;
	isiCombo('JnsLayananWAll','','','JnsLayanan',showTmpLay);
	function showTmpLay(){
		isiCombo('TmpLayananDenganSemua',document.getElementById('JnsLayanan').value,'','TmpLayanan',showTabel);
	}
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
	
	function loadGrid(){
		setTimeout('showTabel()',"5000");
	}
	
	function showTabel(){
		//alert("sm_utils.php?grd1=true&jns="+document.getElementById('JnsLayanan').value+"&tmp="+document.getElementById('TmpLayanan').value+"&nama="+document.getElementById('nama').value+"&tglMsk="+document.getElementById('tglMsk').value+"&tglSls="+document.getElementById('tglSelesai').value+"&norm="+document.getElementById('norm').value+"&status_m="+document.getElementById('cmb_sm').value);
		a.loadURL("sm_utils.php?grd1=true&jns="+document.getElementById('JnsLayanan').value+"&tmp="+document.getElementById('TmpLayanan').value+"&nama="+document.getElementById('nama').value+"&tglMsk="+document.getElementById('tglMsk').value+"&tglSls="+document.getElementById('tglSelesai').value+"&norm="+document.getElementById('norm').value+"&status_m="+document.getElementById('cmb_sm').value,"","GET");
		setTimeout('showTabel()',"5000");
	}
	
	function print_r(){
	}
	
	function goFilterAndSort(grd){
		if (grd=="gridbox"){
			//alert("sm_utils.php?grd1=true&jns="+document.getElementById('JnsLayanan').value+"&tmp="+document.getElementById('TmpLayanan').value+"&nama="+document.getElementById('nama').value+"&tglMsk="+document.getElementById('tglMsk').value+"&tglSls="+document.getElementById('tglSelesai').value+"&norm="+document.getElementById('norm').value+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage())
			a.loadURL("sm_utils.php?grd1=true&jns="+document.getElementById('JnsLayanan').value+"&tmp="+document.getElementById('TmpLayanan').value+"&nama="+document.getElementById('nama').value+"&tglMsk="+document.getElementById('tglMsk').value+"&tglSls="+document.getElementById('tglSelesai').value+"&norm="+document.getElementById('norm').value+"&status_m="+document.getElementById('cmb_sm').value+"&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
		}
	}
	
	function statChange(){
		//alert(a.obj.childNodes[0].childNodes[parseInt(a.getSelRow())-1].childNodes[6].childNodes[0].checked)
		//a=grid
		//obj=object
		//childNodes[0]=element anak pertama dari grid,table
		//childNodes[parseInt(a.getSelRow())-1]=element anak kedua dari grid,tr
		//childNodes[6]=element anak ketiga dari grid,td
		//childNodes[0]=element anak keempat dari grid,isi td
		
		var id = a.getRowId(a.getSelRow());
		var act;
		if(a.obj.childNodes[0].childNodes[parseInt(a.getSelRow())-1].childNodes[2].childNodes[0].checked){
			var status = 1;
		}
		else{
			var status = 0;
		}
		//alert('sm_utils.php?grid1=true&act=update_stat_med&id='+id+'&status='+status);
		var url = "sm_utils.php?grd1=true&act=update_stat_med&id="+id+"&status="+status+"&jns="+document.getElementById('JnsLayanan').value+"&tmp="+document.getElementById('TmpLayanan').value+"&nama="+document.getElementById('nama').value+"&tglMsk="+document.getElementById('tglMsk').value+"&tglSls="+document.getElementById('tglSelesai').value+"&norm="+document.getElementById('norm').value+"&status_m="+document.getElementById('cmb_sm').value;
		a.loadURL(url,"","GET");
		//Request('sm_utils.php?grid1=true&act=update_stat_med&id='+id+'&status='+status,'spanSuk','','GET',tampil);
	}
	
	function tampil(key,val){
		if(val != '' && val != undefined){
			val = val.split('*|*');
			document.getElementById('spanSuk').innerHTML = val[1];
			setTimeout(function(){
				document.getElementById('spanSuk').innerHTML = '';
				},"1500");
		}
	}
	
	var a=new DSGridObject("gridbox");
	a.setHeader("DATA PASIEN");
	a.setColHeader("NO,TGL KUNJUNGAN,STATUS MEDIK,NO RM,NAMA PASIEN,ALAMAT,POLI,STATUS PASIEN,PETUGAS");
	a.setIDColHeader(",tgl,,no_rm,nama,alamat,poli,status,pgw");
	a.setColWidth("50,120,70,75,150,150,200,100,100");
	a.setCellAlign("center,center,center,center,left,left,left,left,left");
	a.setCellType("txt,txt,chk,txt,txt,txt,txt,txt,txt");
	a.setCellHeight(20);
	a.setImgPath("../icon");
	a.setIDPaging("paging");
	a.attachEvent("onRowClick",'statChange')
	//a.attachEvent("onRowDblClick","tes1");
	a.onLoaded(tampil);
	a.baseURL("sm_utils.php?grd1=true&jns="+document.getElementById('JnsLayanan').value+"&tmp="+document.getElementById('TmpLayanan').value+"&nama="+document.getElementById('nama').value+"&tglMsk="+document.getElementById('tglMsk').value+"&tglSls="+document.getElementById('tglSelesai').value+"&norm="+document.getElementById('norm').value);
	a.Init();
	
	function setSekarang()
	{
		waktu1 = document.getElementById("sWTimer").value;
		start1();
	}
	
	function start1()
	{
		if(waktu1==0)
		{
			setInterval(function(){jQuery("#load1").load("cek_r.php")},10000);	
		}else{
			waktu1 = waktu1 * 1000;
			clearInterval(setInterval(function(){jQuery("#load1").load("cek_r.php")},waktu1));	
		}
	}
	
	loadGrid();
</script>
</html>