<?php 
session_start();
include("../koneksi/konek.php");
	$PATH_INFO="?".$_SERVER['QUERY_STRING'];
	$_SESSION["PATH_INFO"]=$PATH_INFO;
?>
<html>
<title>Tree Mata Anggaran</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="pager.css" rel="stylesheet" type="text/css">
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
<table border=1 cellspacing=0 width=475>
<tr><td class=GreenBG align=center><font size=1><b>
.: Data Mata Anggaran :.
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
  $strSQL = "select * from ma where ma_aktif=1 order by ma_kode";
  $rs = mysql_query($strSQL);
  while ($rows=mysql_fetch_array($rs)){
		 $c_level = $rows["MA_LEVEL"];
		 $tree[$cnt][0]= $c_level;
		 $tree[$cnt][1]= $rows["MA_KODE"]." - ".$rows["MA_NAMA"];
		 if ($c_level>0)
			 $tree[$cnt][2]= "javascript:goEdit('" . $c_level . "','" . $rows["MA_NAMA"]. "');";
 		 else
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
</body>
<script language="javascript">
function goEdit(pidbarang,pnamabarang) {
  self.opener.document.form1.idbarang.value = pidbarang;
  self.opener.document.form1.namabarang.value = pnamabarang;
  window.close();
}


</script>
</html>
<?php 
mysql_close($konek);
?>