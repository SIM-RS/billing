<?php
include("../koneksi/konek_billing_inacbg.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script type="text/javascript" src="../theme/js/ajax.js"></script>
<title>User INACBG</title>
<style>
.genap{
	background-color: #FFF4D6;
	font-size:11px;	
}
.ganjil{
	background-color:#FFBE4E;
	font-size:11px;
}
.mosover{
	background-color:#AA4500;
	color:#FDFFFA;
	font-size:11px;
	cursor:pointer;
}
</style>
</head>
<body>
<div id="divtreeview">
<table border="0" cellspacing="0" width="695">
<tr bgcolor="whitesmoke" style="background-color:#FF5510; color:#FDFFFA; font-weight:bold; font-size:14px">
    <td width="63" align="center">No.</td>
    <td width="247" align="center">Nama</td>
    <td width="379" align="center">Alamat</td>
</tr>
<?php
$sql="SELECT 
  u.user_id,
  p.person_nm,
  p.addr_txt 
FROM
  xocp_users u 
  INNER JOIN xocp_persons p 
    ON u.person_id = p.person_id 
ORDER BY p.person_nm";
$kueri=mysql_query($sql,$koneksi_inacbg);
$no=0;
while($rows=mysql_fetch_array($kueri)){
$no++;
?>
<tr onClick="window.opener.document.getElementById('user_id_inacbg').value='<?php echo $rows['user_id']; ?>'; window.close();" onMouseOver="keselect(this)" onMouseOut="deselect(this)" class="<?php if(($no%2)==1) echo 'ganjil'; else echo 'genap'; ?>">
    <td align="center"><?php echo $no; ?></td>
    <td><?php echo $rows['person_nm']; ?></td>
    <td><?php echo $rows['addr_txt']; ?></td>
</tr>
<?php
}
?>
</table>
<button style="cursor:pointer" onClick="window.opener.document.getElementById('user_id_inacbg').value=''; window.close();">Clear</button>
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