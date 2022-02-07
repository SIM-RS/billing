<?php 
session_start();
//error_reporting(E_ALL);
require_once("koneksi.php");
//if (isset($_SESSION["PATH_MS_MA"]))
//	$PATH_INFO=$_SESSION["PATH_MS_MA"];
//else{
	$PATH_INFO="?".$_SERVER['QUERY_STRING'];
	$_SESSION["PATH_MS_MA"]=$PATH_INFO;
//}
$par=$_REQUEST['par'];
$par=explode("*",$par);
$noidx=$_REQUEST["cnt"];

?>
<html>
<title>Tree Rekening</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../js/mod.js"></script>
<link rel="stylesheet" href="../css/simkeu.css" type="text/css" />
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
.: Data Rekening :.
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
  $setLevel;
  $strSQL = "select * from ma_sak where ma_aktif=1 and ma_kode like '$_GET[kode_induknya]%' order by ma_kode";
  //echo $strSQL;
  $rs = mysql_query($strSQL);
  while ($rows=mysql_fetch_array($rs)){
  	  if ($rows["CC_RV_KSO_PBF_UMUM"]==0){
		 $c_level = $rows["MA_LEVEL"];
		 if ($cnt==0) $setLevel=$c_level-1;
		 $c_level= $c_level-$setLevel;
		 $c_islast = $rows["MA_ISLAST"];
		 $tree[$cnt][0]= $c_level;
		 $tree[$cnt][1]= $rows["MA_KODE"]." - ".$rows["MA_NAMA"];
		 if ($c_islast==1){
			$tree[$cnt][2]= "javascript:fSetValueArray(window.opener,'".$par[0]."*-*".$rows['MA_ID']."*|*".$par[1]."*-*".$rows['MA_KODE']."*|*".$par[2]."*-*".$rows['MA_NAMA']."*|*".$par[3]."*-*0',$noidx);window.close();";
 		 }else
		 	 $tree[$cnt][2] = null;

		 $tree[$cnt][3]= "";
		 $tree[$cnt][4]= 0;
		 if ($tree[$cnt][0] > $maxlevel) 
			$maxlevel=$tree[$cnt][0];    
		 $cnt++;
	  }else{
		 $c_level = $rows["MA_LEVEL"];
		 if ($cnt==0) $setLevel=$c_level-1;
		 $c_level= $c_level-$setLevel;
		 $s_level= $c_level;
		 $c_islast = 0;
		 $tree[$cnt][0]= $c_level;
		 $tree[$cnt][1]= $rows["MA_KODE"]." - ".$rows["MA_NAMA"];
		 if ($c_islast==1){
			$tree[$cnt][2]= "javascript:fSetValueArray(window.opener,'".$par[0]."*-*".$rows['MA_ID']."*|*".$par[1]."*-*".$rows['MA_KODE']."*|*".$par[2]."*-*".$rows['MA_NAMA']."*|*".$par[3]."*-*0',$noidx);window.close();";
 		 }else
		 	 $tree[$cnt][2] = null;

		 $tree[$cnt][3]= "";
		 $tree[$cnt][4]= 0;
		 if ($tree[$cnt][0] > $maxlevel) 
			$maxlevel=$tree[$cnt][0];    
		 $cnt++;
			switch ($rows["CC_RV_KSO_PBF_UMUM"]){
				case 1:
					//if (substr($rows["MA_KODE"],0,1)=="4"){
					//	$sql="SELECT * FROM ak_ms_unit WHERE LEFT(kode,2)<>'08' AND aktif=1 ORDER BY kode";
					//}else{
						$sql="SELECT * FROM dbkopega_hcr.ms_unit WHERE aktif=1 ORDER BY kodeunit";
					//}
					 $rs1 = mysql_query($sql);
					 while ($rows1=mysql_fetch_array($rs1)){
                         $kodeLevel = explode('.', $rows1['kodeunit']);
						 //$c_level = $s_level + $rows1["level"];
                         $c_level = count($kodeLevel) + $s_level;
						 $c_islast = $rows1["islast"];
						 $mpkode=trim($rows1['rc']);
						 $tree[$cnt][0]= $c_level;
						 $tree[$cnt][1]= $rows["MA_KODE"].($mpkode==""?"":$mpkode." - ").$rows1["namaunit"];
						 if ($c_islast==1 && $rows1['rc'] != '0'){
							$tree[$cnt][2]= "javascript:fSetValueArray(window.opener,'".$par[0]."*-*".$rows['MA_ID']."*|*".$par[1]."*-*".$rows['MA_KODE'].$mpkode."*|*".$par[2]."*-*".$rows1['namaunit']."*|*".$par[3]."*-*".$rows1['idunit']."',$noidx);window.close();";
						 }else
							 $tree[$cnt][2] = null;
				
						 $tree[$cnt][3]= "";
						 $tree[$cnt][4]= 0;
						 if ($tree[$cnt][0] > $maxlevel)
							$maxlevel=$tree[$cnt][0];
						 $cnt++;
					 }
			 		break;
				case 2:
					 $ckso_filter=" AND type=0";
					 if ($rows["MA_TYPE"]==1){
						$ckso_filter=" AND type=1";
					 }
					 $sql="SELECT * FROM billing.b_ms_kso WHERE aktif=1 AND id>1".$ckso_filter." ORDER BY kode_ak";
					 $rs1 = mysql_query($sql);
					 while ($rows1=mysql_fetch_array($rs1)){
						 $c_level = $s_level + 1;
						 $c_islast = 1;
						 $mpkode=trim($rows1['kode_ak']);
						 $tree[$cnt][0]= $c_level;
						 $tree[$cnt][1]= $rows["MA_KODE"].($mpkode==""?"":$mpkode." - ").$rows1["nama"];
						 if ($c_islast==1){
						 	$tval=str_replace('"',chr(3),$par[0]."*-*".$rows['MA_ID']."*|*".$par[1]."*-*".$rows['MA_KODE'].$mpkode."*|*".$par[2]."*-*".$rows1['nama']."*|*".$par[3]."*-*".$rows1['id']);
							$tval=str_replace("'",chr(5),$tval);
							//$tree[$cnt][2]= "javascript:fSetValueArray(window.opener,'".$par[0]."*-*".$rows['MA_ID']."*|*".$par[1]."*-*".$rows['MA_KODE'].$mpkode."*|*".$par[2]."*-*".$rows1['nama']."*|*".$par[3]."*-*".$rows1['id']."',$noidx);window.close();";
							$tree[$cnt][2]= "javascript:fSetValueArray(window.opener,'".$tval."',$noidx);window.close();";
						 }else
							 $tree[$cnt][2] = null;
				
						 $tree[$cnt][3]= "";
						 $tree[$cnt][4]= 0;
						 if ($tree[$cnt][0] > $maxlevel)
							$maxlevel=$tree[$cnt][0];
						 $cnt++;
					 }
			 		break;
				case 3:
					 $sql="SELECT * FROM dbapotek.a_pbf WHERE PBF_ISAKTIF=1 ORDER BY PBF_KODE_AK";
					 $rs1 = mysql_query($sql);
					 while ($rows1=mysql_fetch_array($rs1)){
						 $c_level = $s_level + 1;
						 $c_islast = 1;
						 $mpkode=trim($rows1['PBF_KODE_AK']);
						 $tree[$cnt][0]= $c_level;
						 $tree[$cnt][1]= $rows["MA_KODE"].($mpkode==""?"":$mpkode." - ").$rows1["PBF_NAMA"];
						 if ($c_islast==1){
							$tree[$cnt][2]= "javascript:fSetValueArray(window.opener,'".$par[0]."*-*".$rows['MA_ID']."*|*".$par[1]."*-*".$rows['MA_KODE'].$mpkode."*|*".$par[2]."*-*".$rows1['PBF_NAMA']."*|*".$par[3]."*-*".$rows1['PBF_ID']."',$noidx);window.close();";
						 }else
							 $tree[$cnt][2] = null;
				
						 $tree[$cnt][3]= "";
						 $tree[$cnt][4]= 0;
						 if ($tree[$cnt][0] > $maxlevel)
							$maxlevel=$tree[$cnt][0];
						 $cnt++;
					 }
			 		break;
				case 4:
					 //$sql="SELECT * FROM dbaset.as_ms_rekanan WHERE STATUS=1 ORDER BY koderekanan";
                    $sql="SELECT * FROM dbkopega_scm.ms_supplier ORDER BY Supplier_KODE";
					 $rs1 = mysql_query($sql);
					 while ($rows1=mysql_fetch_array($rs1)){
						 $c_level = $s_level + 1;
						 $c_islast = 1;
						 $mpkode=trim($rows1['Supplier_KODE']);
						 $tree[$cnt][0]= $c_level;
						 $tree[$cnt][1]= $rows["MA_KODE"].($mpkode==""?"":$mpkode." - ").$rows1["Supplier_NAMA"];
						 if ($c_islast==1){
							$tree[$cnt][2]= "javascript:fSetValueArray(window.opener,'".$par[0]."*-*".$rows['MA_ID']."*|*".$par[1]."*-*".$rows['MA_KODE'].$mpkode."*|*".$par[2]."*-*".$rows1['Supplier_NAMA']."*|*".$par[3]."*-*".$rows1['Supplier_ID']."',$noidx);window.close();";
						 }else
							 $tree[$cnt][2] = null;
				
						 $tree[$cnt][3]= "";
						 $tree[$cnt][4]= 0;
						 if ($tree[$cnt][0] > $maxlevel)
							$maxlevel=$tree[$cnt][0];
						 $cnt++;
					 }
			 		break;
			}
	  }
  }
  mysql_free_result($rs);
include("treemenu.inc.php");

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
//mysql_close($konek);
?>