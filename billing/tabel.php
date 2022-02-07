<?
include("sesi.php");
?>
<?php include("koneksi/konek.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="STYLESHEET" type="text/css" href="theme/mod.css">
</head>
<body bgcolor="#CCFF99">
<div align="center"><br />
<div id="gridbox" style="width:925px; height:400px; background-color:white; overflow:hidden;">
<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed; border-collapse:collapse" border="0">
<tr id="hdrcaption" class="headtable" style="height:20px">
    <td width="100%">Data Pasien</td>
</tr>
</table>
<div id="hdrbox" style="width:100%; overflow:hidden;">
<table cellpadding="0" cellspacing="0" style="width:100%; table-layout:fixed; border-collapse:collapse" border="1px">
<tr id="hdrcol" class="headtable" style="height:20px">
    <td width="30">No</td>
    <td width="80">Tgl</td>
    <td width="70">No RM</td>
    <td width="120">Kode Kunjungan</td>
    <td width="170">Nama Pasien</td>
    <td width="200">Alamat</td>
    <td width="130">KSO</td>
    <td width="140">Dokter</td>
    <td width="140">Poli/Ruang</td>
</tr>
</table>
</div>
<div id="griditem" style="width:100%; overflow:scroll;" OnScroll="document.getElementById('hdrbox').scrollLeft=this.scrollLeft;">
<table cellpadding="0" cellspacing="0" width="100%" class="GridTable" border="1px">
<?php 
//$sql="SELECT COUNT(*) FROM (SELECT *,DATE_FORMAT(tgl,'%d/%m/%Y') AS tgl1 FROM pasien_billing ORDER BY Nama) AS T1";
$sql="SELECT *,DATE_FORMAT(tgl,'%d/%m/%Y') AS tgl1 FROM pasien_billing ORDER BY Nama";
$rs=mysql_query($sql);
$sql="SELECT *,DATE_FORMAT(tgl,'%d/%m/%Y') AS tgl1 FROM pasien_billing ORDER BY Nama LIMIT 0,100";
$rs=mysql_query($sql);
$i=0;
while ($rows=mysql_fetch_array($rs)){
	$i++;
?>
<tr id="griditem<?php echo $i; ?>" lang="<?php echo $i; ?>" height="20" class="<?php if ($i==1) echo 'itemtableSelected'; elseif ($i%2) echo'GridItemOdd'; else echo 'GridItemEven';?>" onclick="ItemTblMClick(this);" onmouseover="ItemTblMOver(this);" onmouseout="ItemTblMOut(this);">
    <td width="30" align="center"><?php echo $i; ?></td>
    <td width="80"><?php echo $rows["tgl1"]; ?></td>
    <td width="70"><?php echo $rows["NoRM"]; ?></td>
    <td width="120"><?php echo $rows["Kode"]; ?></td>
    <td width="170"><?php echo $rows["Nama"]; ?></td>
    <td width="200"><?php echo $rows["Alamat"]; ?></td>
    <td width="130"><?php echo $rows["Penjamin"]; ?></td>
    <td width="140"><?php echo $rows["dokter"]; ?></td>
    <td width="120"><?php echo $rows["Poli"]; ?></td>
</tr>
<?php }?>
</table>
</div>
</div>
</div>
</body>
<script>
var lastId=1;
var gridboxh=document.getElementById('gridbox').style.height;
var hdrcaptionh=document.getElementById('hdrcaption').style.height;
var hdrcolh=document.getElementById('hdrcol').style.height;
	gridboxh=gridboxh.substr(0,gridboxh.length-2);
	hdrcaptionh=hdrcaptionh.substr(0,hdrcaptionh.length-2);
	hdrcolh=hdrcolh.substr(0,hdrcolh.length-2);
	document.getElementById('griditem').style.height=(parseInt(gridboxh)-parseInt(hdrcolh)-parseInt(hdrcaptionh)-1) + 'px';
	
function ItemTblMOver(par){
	par.className='GridItemMOver';
}
function ItemTblMOut(par){
	if (par.lang==lastId)
		par.className='GridItemSelected';
	else
		if (par.lang%2) 
			par.className='GridItemOdd';
		else
			par.className='GridItemEven';
}
function ItemTblMClick(par){
	//alert(par.id%2);
	par.className='GridItemSelected';
	if (lastId%2)
		document.getElementById("griditem"+lastId).className='GridItemOdd';
	else
		document.getElementById("griditem"+lastId).className='GridItemEven';
	lastId=par.lang;
}
</script>
</html>
<?php mysql_close($konek);?>