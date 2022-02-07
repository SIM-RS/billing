<?php 
session_start();
include("../koneksi/konek.php");
//if (isset($_SESSION["PATH_MS_MA"]))
//	$PATH_INFO=$_SESSION["PATH_MS_MA"];
//else{
	$PATH_INFO="?".$_SERVER['QUERY_STRING'];
	$_SESSION["PATH_MS_MA"]=$PATH_INFO;
//}
$par=$_REQUEST['par'];
$par=explode("*",$par);

$th=gmdate('Y',mktime(date('H')+7));

?>
<html>
<title>Tree Data Rencana Strategis Dan Kegiatan</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/simkeu.css" type="text/css" />
<style>
BODY, TD {font-family:Verdana; font-size:7pt}
</style>
<body style="border-width:0px;" bgcolor="#CCCCCC" topmargin="0" leftmargin="0" onload="javascript:if (window.focus) window.focus();">
<div align="center">
<table border=1 cellspacing=0 width="98%">
<tr><td class=GreenBG align=center><font size=1><b>
.: Data Rencana Strategis Dan Kegiatan :.
</b></font></td></tr>
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
  $strSQL = "select * from kegiatan where kg_tahun<=$th and kg_tahun1>=$th order by kg_kode";
  $rs = mysql_query($strSQL);
  while ($rows=mysql_fetch_array($rs)){
		 $c_level = $rows["KG_LEVEL"];
		 $c_islast = $rows["KG_ISLAST"];
		 $c_type = $rows["KG_TYPE"];
		 $tree[$cnt][0]= $c_level;
		 $tree[$cnt][1]= $rows["KG_KODE"]." - ".$rows["KG_KET"];
		 if ($c_level>0){
		 	 if (($c_type==2)||(($c_type==1)&&($c_islast==1)))
			 $tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$par[0]."*-*".$rows['KG_ID']."*|*".$par[1]."*-*".$rows['KG_KODE']."*|*".$par[2]."*-*".$rows['KG_KET']."*|*".$par[3]."*-*".$rows['KG_LEVEL']."');window.close();";
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
</html>
<?php 
mysql_close($konek);
?>