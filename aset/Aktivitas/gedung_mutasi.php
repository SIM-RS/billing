<?php
include '../sesi.php';
$unit_opener="par=idunit*kodeunit*namaunit*idlokasi*kodelokasi";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<body>
<div id="idmutasi" align="center" style="display:none">
 <form id="form1" name="form1" action="" method="post">
<table width="1000" align="center" bgcolor="#FFFFFF">
<tr>
 	<td align="center">
		<table width="708" align="center" cellpadding="3" cellspacing="0" class="tabel" >
		 <tr>
			<td colspan="2" class="header" align="center">
				.: Form Mutasi Barang :.	</td>
		</tr>
		 <tr>
			<td class="label" width="225">&nbsp; Kode &amp; Unit Lama
				<input type="hidden" id="idUnit" />
				<input type="hidden" id="idlokasi" name="idlokasi" />
				</td>
			<td class="content" width="469">&nbsp;
				<input type="text" id="kodeunitlama" name="kodeunitlama" size="20" readonly />&nbsp;-&nbsp;
				<input type="text" id="idUnit_lama" name="idUnit_lama" readonly size="35" value="<?php if($_REQUEST['unitlama']!='') echo $_REQUEST['unitlama']; else echo '-'?>" />    </td>
		</tr>
		<tr>
		 <tr>
			<td class="label">&nbsp; Kode Unit
				<input type="hidden" id="idunit" name="idunit" />
				<input name="kodelokasi" type="hidden" class="txtunedited" id="kodelokasi" />
			</td>
			<td class="content">&nbsp;
				<input name="kodeunit" type="text" class="txtunedited" readonly id="kodeunit" tabindex="2" size="20" maxlength="15" />                    
			</td>
		</tr>
		<tr>
			<td class="label">&nbsp; Nama Unit</td>
			<td class="content">&nbsp;
				<input type="text" name="namaunit" id="namaunit" readonly class="txtunedited" size="50" />
				<input type="hidden" id="namaunit" name="namaunit" />
				<img alt="tree" title='daftar unit kerja'  style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absbottom" onClick="OpenWnd('unit_tree.php?<?php echo $unit_opener; ?>',800,500,'Tree Unit',true)" />
			</td>
		</tr>
		<tr>
			<td colspan="2" class="header2">PENAGGUNG JAWAB MUTASI</td>
		</tr>
		<tr>
			<td valign="top" class="label">&nbsp; Nama</td>
			<td class="content">&nbsp;
				<input name="namapetugas" type="text" class="txt" id="namapetugas" size="40" maxlength="50" />
			</td>
		</tr>
		<tr>
			<td valign="top" class="label">&nbsp;
				Jabatan                    </td>
			<td class="content">&nbsp;
				<input name="jabatanpetugas" type="text" class="txt" id="jabatanpetugas" size="40" maxlength="50" />
			</td>
		</tr>
		<tr>
			<td valign="top" class="label">&nbsp;Catatan</td>
			<td class="content">&nbsp;
				<textarea name="catpetugas" cols="70" class="txt" rows="2" id="catpetugas"></textarea>
			</td>
		</tr>
		<tr>
			<td class="label">&nbsp;Tanggal Mutasi</td>
			<td class="content">&nbsp;
				<input name="tglmutasi" readonly type="text" class="txt" id="tglmutasi" size="20" maxlength="15" value="<?php echo date('d-m-Y') ?>" />
				<img alt="calender" style="cursor:pointer" border=0 src="../images/cal.gif" align="absbottom" onClick="gfPop.fPopCalendar(document.getElementById('tglmutasi'),depRange);" />
				<font color="#666666"><em>(dd-mm-yyyy)</em></font>                    </td>
		</tr>
		<tr>
			<td class="footer" align="center" colspan="2">
			  <input type="button" id="confirm" name="confirm" value="Confirm" onclick="act(this.value);" />
			  <input type="button" id="cencel" name="cencel" value="Cencel" onclick="Lidia()" />                    </td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td><div><img src="../images/foot.gif" width="1000" height="45"></div></td>
</tr>
</table>
</form>
</div>
<iframe height="193" width="168" name="gToday:normal:agenda.js"
        id="gToday:normal:agenda.js"
        src="../theme/popcjs.php" scrolling="no"
        frameborder="1"
        style="border:1px solid medium ridge; position: absolute; z-index: 65535; left: 100px; top: 50px; visibility: hidden">
</iframe>

<script type="text/JavaScript" language="JavaScript">
  var arrRange=depRange=[];
function act(berubah){
var idseri=document.getElementById('txtId').value;
var idunitlama=document.getElementById('idUnit').value;
var idunitbaru=document.getElementById('idunit').value;
var namapetugas=document.getElementById('namapetugas').value;
var jabatanpetugas=document.getElementById('jabatanpetugas').value;
var catpetugas=document.getElementById('catpetugas').value;
var tglmutasi=document.getElementById('tglmutasi').value;
if(idunit=='' || idunit==null){
	alert('Unit harus di isi !');
}else{
//alert('gedung_utils.php?act=berubah&idseri='+idseri+'&idunitlama='+idunitlama+'&idunitbaru='+idunitbaru+'&namaperugas='+namapetugas+'&jbtpetugas='+jabatanpetugas+'&catpetugas='+catpetugas+'&tglmutasi='+tglmutasi)
	rek.loadURL('gedung_utils.php?act=berubah&idseri='+idseri+'&idunitlama='+idunitlama+'&idunitbaru='+idunitbaru+'&namaperugas='+namapetugas+'&jbtpetugas='+jabatanpetugas+'&catpetugas='+catpetugas+'&tglmutasi='+tglmutasi,'','GET');
	grid.Init();
	document.getElementById('idmutasi').style.display='none';
	document.getElementById('tutup').style.display='block';
	}
	
} 
function Lidia(){
document.getElementById('txtId').value='';
document.getElementById('idUnit').value='';
document.getElementById('namaunit').value='';
document.getElementById('kodeunit').value='';
document.getElementById('namapetugas').value='';
document.getElementById('jabatanpetugas').value='';
document.getElementById('catpetugas').value='';
document.getElementById('idmutasi').style.display='none';
document.getElementById('tutup').style.display='block'; 
}
</script>