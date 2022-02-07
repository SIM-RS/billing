<?php 
include '../secured_sess.php';
include ('../koneksi/konek.php');
$PATH_INFO="?".$_SERVER['QUERY_STRING'];
$_SESSION["PATH_MS_MA"]=$PATH_INFO;

$par=$_REQUEST['par'];
$par=explode("*",$par);
$stt=$_REQUEST['stt'];
if($stt=='')$stt=1;

?>
<html>
<title>Tree Mata Anggaran</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link rel="stylesheet" href="../theme/simkeu.css" type="text/css" />
    <script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
<body style="border-width:0px;" bgcolor="#CCCCCC" topmargin="0" leftmargin="0" onLoad="javascript:if (window.focus) window.focus();">
<input type="hidden" name="origin" id="origin" value="treeUnit" />
<table border="1" cellspacing="0" width="800">
<tr><td class='GreenBG' align=center><font size=1><b>
.: Data Mata Anggaran :.
</b></font></td></tr>
<tr bgcolor="whitesmoke">
	<td nowrap colspan="2">
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
  $tree=array();
  $canRead = true;
  $maxlevel=0;
  $cnt=0;
  $strSQL = "SELECT * FROM $dbanggaran.ms_ma msak WHERE msak.ma_aktif='".$stt."' ORDER BY msak.ma_kode2";
  //echo $strSQL."<br>";
  $rs = mysql_query($strSQL);
  while ($rows=mysql_fetch_array($rs)){
		 $c_level = $rows["ma_level"];
		 $mpkode=trim($rows['ma_kode']);
		 $islast=$rows['ma_islast'];
		 $tree[$cnt][0]= $c_level;
		 $tree[$cnt][1]= ($mpkode==""?"":$mpkode." - ").$rows["ma_nama"];
		 $arfvalue = $no."*|*".$rows['ma_id']."*|*".$rows['ma_kode']."*|*".$rows['ma_nama'];
		 $tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$par[0]."*-*".$rows['ma_id']."*|*".$par[1]."*-*".$rows['ma_kode']."*|*".$par[2]."*-*".$rows['ma_nama']."');window.close();";
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
	</td>
</tr>
</table>
</div>
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

 function Riz(){
	location='tree_mata_anggaran.php&stt='+document.getElementById('stt').value;
}
</script>
</html>
<?php 
mysql_close($konek);
?>