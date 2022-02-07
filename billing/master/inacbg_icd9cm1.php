<?php
include("../koneksi/konek.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script type="text/javascript" src="../theme/js/ajax.js"></script>
<title>ICD-9-CM INACBG</title>
<style>
.baris{
	background-color: #FFF4D6;
	font-size:10px;
	color:#000;	
}
.islast{
	background-color:#FFF4D6;
	font-size:10px;
	color:#00F;
}
.mosover{
	background-color:#AA4500;
	color:#FDFFFA;
	font-size:10px;
	cursor:pointer;
	text-decoration:underline;
}
</style>
</head>
<body>
<div id="divtreeview">
<?php
$b=explode(".",$_REQUEST['b']);
$fb=array_reverse($b);

if($_REQUEST['par']!=''){
	$cek="SELECT
		  mh.PAUI,
		  mh.PTR
		FROM
		  mrconso m 
		  INNER JOIN mrhier mh 
			ON m.AUI = mh.AUI 
		WHERE m.SAB LIKE 'ICD9CM%'
		  AND m.CODE = '".$_REQUEST['par']."'";
	$qCek=mysql_query($cek);
	$rw=mysql_fetch_array($qCek);
	$fParent="AND PAUI = '".$rw['PAUI']."'";
	
	$cek2="SELECT
		  mh.PTR
		FROM
		  mrconso m 
		  INNER JOIN mrhier mh 
			ON m.AUI = mh.AUI 
		WHERE m.SAB LIKE 'ICD9CM%'
		  AND mh.AUI = '".$rw['PAUI']."'";
	$qCek2=mysql_query($cek2);
	$rw2=mysql_fetch_array($qCek2);
	
	$b=explode(".",$rw2['PTR']);
	$fb=array_reverse($b);	
}
else{
	if($_REQUEST['PAUI']==''){
		//$fLevel="AND LENGTH(mh.PTR) = 8";
		$fParent="AND PAUI = 'A1415692'";
		
	}
	else{
		$fParent="AND PAUI = '".$_REQUEST['PAUI']."'";	
	}
}
?>
<table border="0" cellspacing="0" width="850">
<tr bgcolor="whitesmoke" style="background-color:#663333; color:#FDFFFA; font-weight:bold; font-size:14px">
    <td align="left" colspan="2">&nbsp;<img title="Level Teratas" onClick="<?php echo "window.location='inacbg_icd9cm1.php'" ?>" style="cursor:pointer; width:25" src="../icon/folder_up.png">&nbsp;<img title="Naik 1 Level" onClick="<?php echo "window.location='inacbg_icd9cm1.php?PAUI=".$fb[0]."&b=".$fb[1]."'" ?>" style="cursor:pointer; width:25" src="../icon/folder_root.png"></td>
    <td align="left" colspan="2">&nbsp;</td>
</tr>
<?php


$sql="SELECT
  m.AUI, 
  m.CODE,
  m.STR,
  mh.PAUI,
  mh.PTR,
  m.TTY 
FROM
  mrconso m 
  INNER JOIN mrhier mh 
    ON m.AUI = mh.AUI 
WHERE m.SAB LIKE 'ICD9CM%'
  $fParent 
ORDER BY m.CODE";
$kueri=mysql_query($sql);
$no=0;
while($rows=mysql_fetch_array($kueri)){
	$no++;
	//$sIslast="SELECT * FROM icd.mrhier WHERE PAUI='".$rows['AUI']."'";
	//$qIslast=mysql_query($sIslast,$koneksi_inacbg);
	//if(mysql_num_rows($qIslast)>0){
	if($rows['TTY']=='HT'){
		$islast=0;
		$onKlik="window.location='inacbg_icd9cm1.php?PAUI=".$rows['AUI']."&b=".$rows['PTR']."'";
	}
	else{
		$islast=1;
		$onKlik="window.opener.document.getElementById('par').value='".$rows['CODE']."';window.close()";
	}
	
?>
<tr onClick="<?php echo $onKlik; ?>" onMouseOver="keselect(this)" onMouseOut="deselect(this)" class="<?php if($islast==1) echo 'islast'; else echo 'baris'; ?>">
    <td width="141" align="center" style="font-weight:bold"><?php echo $rows['CODE']; ?></td>
    <td><?php echo $rows['STR']; ?></td>
    <td><span onClick="<?php echo "window.opener.document.getElementById('par').value='".$rows['CODE']."';window.close()"; ?>" style="cursor:pointer; color:#06F;"><u><a>Pilih Sebagai Parent</a></u></span></td>
</tr>
<?php
}
?>
<tr>
    <td width="141" align="center" style="font-weight:bold" colspan="3" align="center"></td>
</tr>
<tr>
    <td width="141" align="center" style="font-weight:bold" colspan="3" align="center"><input type="button" value="TOP PARENT" onClick="<?php echo "window.opener.document.getElementById('par').value='-';window.close()"; ?>"></td>
</tr>
</table>
</div>
</body>
<script>
var temp='';
function keselect(baris){
	temp=baris.className;
	baris.className='mosover';
}

function deselect(baris){
	baris.className=temp;
}
</script>