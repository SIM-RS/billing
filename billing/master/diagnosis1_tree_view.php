<?
include("../sesi.php");
?>
<?php 
//session_start();
include("../koneksi/konek.php");
//if (isset($_SESSION["PATH_MS_MA"]))
//	$PATH_INFO=$_SESSION["PATH_MS_MA"];
//else{

$perpage=$_REQUEST['perpage'];
   if ($perpage=="" || $perpage=="0")  $perpage=100;
$page=$_REQUEST['page'];
   if ($page=="" || $page=="0") $page=1;

	$PATH_INFO="?page=$page&perpage=$perpage&".$_SERVER['QUERY_STRING'];
	$_SESSION["PATH_MS_MA"]=$PATH_INFO;
//}
$par=$_REQUEST['par'];
$par=explode("*",$par);

?>
<html>
<title>Tree Rekening</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/mod.css" type="text/css" />
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
<tr><td class=GreenBG align=center><font size=1><b>
.: Data Diagnosa :.
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
  $strSQL = "select * from b_ms_diagnosa order by kode";
  $rs = mysql_query($strSQL);
	//bikin halaman        
	$sql=$strSQL;
	
	$jmldata=mysql_num_rows($rs);
	 
	 $tpage=($page-1)*$perpage;
	 if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
	 if ($page>1) $bpage=$page-1; else $bpage=1;
	 if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
	 $sql=$sql." limit $tpage,$perpage";
	 //end of bikin halaman
	 
	 //echo $sql."<br/>";
  
  $rs = mysql_query($sql);
  while ($rows=mysql_fetch_array($rs)){
		 $c_level = $rows["level"];
		 $mpkode=trim($rows['kode']);
		 $tree[$cnt][0]= $c_level;
		 $tree[$cnt][1]= $rows["kode"]." - ".($mpkode==""?"":$mpkode." - ").$rows["nama"];
		 if ($c_level>0)
			 $tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$par[0]."*-*".$rows['id']."*|*".$par[1]."*-*".$rows['kode']."*|*".$par[2]."*-*".$rows['level']."*|*".$par[3]."*-*".($rows['level']+1)."');window.close();";
 		 else
		 	 $tree[$cnt][2] = null;

		 $tree[$cnt][3]= "";
		 $tree[$cnt][4]= 0;
		 if ($tree[$cnt][0] > $maxlevel) 
			$maxlevel=$tree[$cnt][0];    
		 $cnt++;
	}
	mysql_free_result($rs);
	
$tree_img_path="../images";
include("../theme/treemenu.inc.php");

?>
</td></tr>
<tr>
	<td>
		<form id="formPage" action="" method="post">
		<input id="perpage" name="perpage" size="5" class="txtinput" onKeyUp="if(event.which=='13'){ document.getElementById('formPage').submit(); }" value="<?php echo isset($_REQUEST['perpage'])?$_REQUEST['perpage']:$perpage;?>"/>
		baris pada            
		halaman ke :<input id="page" name="page" size="5" class="txtinput" onKeyUp="if(event.which=='13'){ document.getElementById('formPage').submit(); }" value="<?php echo isset($_REQUEST['page'])?$_REQUEST['page']:$page;?>"/>
		dari&nbsp;
		<?php echo $totpage;?>&nbsp;
		Halaman
		&nbsp;
		<label style="float:right;">
		<img src="../icon/page_first.gif" border="0" width="30" height="30" style='cursor:pointer' title="Halaman Pertama" onClick="document.getElementById('page').value=1;document.getElementById('formPage').submit()"/>
		<img src="../icon/page_prev.gif" border="0" width="30" height="30" style='cursor:pointer' title="Halaman Sebelumnya" onClick="if (parseInt(document.getElementById('page').value) > 1){document.getElementById('page').value=(parseInt(document.getElementById('page').value)-1); document.getElementById('formPage').submit();}"/>
		<img src="../icon/page_next.gif" border="0" width="30" height="30" style='cursor:pointer' title="Halaman Selanjutnya" onClick="if (<?php echo $totpage;?> > parseInt(document.getElementById('page').value)){document.getElementById('page').value=(parseInt(document.getElementById('page').value)+1); document.getElementById('formPage').submit();}"/>
		<img src="../icon/page_last.gif" border="0" width="30" height="30" style='cursor:pointer' title="Halaman Sebelumnya" onClick="document.getElementById('page').value=<?php echo $totpage;?>; document.getElementById('formPage').submit();"/>
		</label>
		</form>
	</td>
</tr>
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