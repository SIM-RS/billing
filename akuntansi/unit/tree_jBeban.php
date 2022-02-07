<?php 
session_start();
include("../koneksi/konek.php");
$PATH_INFO="?".$_SERVER['QUERY_STRING'];
$_SESSION["PATH_MS_MA"]=$PATH_INFO;

$par=$_REQUEST['par'];
//$par=explode("*",$par);
$noidx=$_REQUEST["cnt"];

?>
<html>
<title>Tree Rekening</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/simkeu.css" type="text/css" />
<style>
BODY, TD {font-family:Verdana; font-size:7pt}
.NormalBG 
{
	background-color : #FFFFFF;
}

.AlternateBG { 
	background-color : #FFFFFF;
}

</style>
<body style="border-width:0px;" bgcolor="#CCCCCC" topmargin="0" leftmargin="0" onLoad="javascript:if (window.focus) window.focus();">
<div align="center">
<table border=1 cellspacing=0 width="98%">
<tr>
  <td class=GreenBG align=center><font size=1><b>
.: Daftar Jenis Transaksi :.
</b></font></td>
</tr>
<tr bgcolor="whitesmoke"><td nowrap>
<?php	
  // Detail Data Parameters
  if (isset($_REQUEST["p"])) {
  	  $_SESSION['itemtree.filter'] = $_REQUEST["p"];
	  $p = $_SESSION['itemtree.filter'];	
  }
  else
  {
	  if ($_SESSION['itemtree.filter'])
	  $p = $_SESSION['itemtree.filter'];
  }
  /*********************************************/
  /*  Read text file with tree structure       */
  /*********************************************/
  
  /*********************************************/
  /* read file to $tree array                  */
  /* tree[x][0] -> tree level                  */
  /* tree[x][1] -> item text                   */
  /* tree[x][2] -> item link                   */
  /* tree[x][3] -> link target                 */
  /* tree[x][4] -> last item in subtree        */
  /*********************************************/
  //$tree=array();
  $canRead = true;
  $maxlevel=0;
  $cnt=0;
  $setLevel;
  $strSQL = "select * from ak_ms_beban_jenis where aktif=1 order by kode";
  //echo $strSQL;
  $rs = mysql_query($strSQL);
  while ($rows=mysql_fetch_array($rs)){
		 $c_level = $rows["level"];
		 if ($cnt==0)$setLevel=$c_level-1;
		 $c_level= $c_level-$setLevel;
		 $c_islast = $rows["islast"];

		 $tree[$cnt][0]= $c_level;
		 $tree[$cnt][1]= $rows['kode']." - ".$rows["nama"];
		 if ($c_level>0){
		 	if (($c_islast==1))
			$tree[$cnt][2]= "javascript:window.opener.location='main.php?f=detail&jurnal=".$par."&jbeban_id=".$rows['id']."';window.close();";
 		 }else
		 	 $tree[$cnt][2] = null;

		 $tree[$cnt][3]= "";
		 $tree[$cnt][4]= 0;
		 if ($tree[$cnt][0] > $maxlevel) 
			$maxlevel=$tree[$cnt][0];    
		 $cnt++;
	}
	mysql_free_result($rs);
include("../theme/treemenu.inc.php");

?>
</td></tr>
</table>
</div>
</body>
<script language="javascript">
function goEdit(pid,pkode,pnama,plvl) {
  window.opener.document.form1.idbarang.value = pid;
  window.opener.document.form1.namabarang.value = pnamabarang;
  window.opener.document.form1.idbarang.value = pidbarang;
  window.opener.document.form1.namabarang.value = pnamabarang;
  window.close();
}

</script>
</html>
<?php 
mysql_close($konek);
?>