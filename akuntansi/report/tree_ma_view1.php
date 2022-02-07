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
  $strSQL = "select * from ma_sak where ma_aktif=1 order by ma_kode";
  $rs = mysql_query($strSQL);
  while ($rows=mysql_fetch_array($rs)){
		 $c_level = $rows["MA_LEVEL"];
		 $c_islast = $rows["MA_ISLAST"];
		 $cc_rv_kso_pbf_umum = $rows["CC_RV_KSO_PBF_UMUM"];
		 if ($cc_rv_kso_pbf_umum>0){
			$tree[$cnt][0]= $c_level;
			$tree[$cnt][1]= $rows["MA_KODE"]." - ".$rows["MA_NAMA"];
			$tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$par[0]."*-*".$rows['MA_ID']."*|*".$par[1]."*-*".$rows['MA_KODE']."*|*".$par[2]."*-*".$rows['MA_NAMA']."*|*".$par[3]."*-*".$c_islast."*|*".$par[4]."*-*".$cc_rv_kso_pbf_umum."*|*".$par[5]."*-*0*|*".$par[6]."*-*0');window.close();";
			$tree[$cnt][3]= "";
			$tree[$cnt][4]= 0;
			$tree[$cnt][6]= "";
			if ($tree[$cnt][0] > $maxlevel) 
				$maxlevel=$tree[$cnt][0];    
			$cnt++;
			switch ($cc_rv_kso_pbf_umum){
				case 1:
					if (substr($rows["MA_KODE"],0,1)=="4"){
						$sql="SELECT * FROM ak_ms_unit WHERE LEFT(kode,2)<>'08' ORDER BY kode";
					}else{
						$sql="SELECT * FROM ak_ms_unit ORDER BY kode";
					}
					$rs1=mysql_query($sql);
					while ($rw1=mysql_fetch_array($rs1)){
						$ak_level = $rw1["level"];
						$ak_islast=$rw1["islast"];
						$mpkode=$rows["MA_KODE"].trim($rw1['kode']);
						$tree[$cnt][0]= $c_level+$ak_level;
						$tree[$cnt][1]= $mpkode." - ".$rw1["nama"];
						$tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$par[0]."*-*".$rows['MA_ID']."*|*".$par[1]."*-*".$mpkode."*|*".$par[2]."*-*".$rw1["nama"]."*|*".$par[3]."*-*".$c_islast."*|*".$par[4]."*-*".$cc_rv_kso_pbf_umum."*|*".$par[5]."*-*".$rw1["id"]."*|*".$par[6]."*-*".$ak_islast."');window.close();";
						$tree[$cnt][3]= "";
						$tree[$cnt][4]= 0;
						$tree[$cnt][6]= "";
						if ($tree[$cnt][0] > $maxlevel) 
							$maxlevel=$tree[$cnt][0];    
						$cnt++;
					}
					break;
				case 2:
					$sql="SELECT * FROM billing.b_ms_kso WHERE id>1 ORDER BY kode_ak";
					$rs1=mysql_query($sql);
					while ($rw1=mysql_fetch_array($rs1)){
						$ak_level = 1;
						$ak_islast=1;
						$mpkode=$rows["MA_KODE"].trim($rw1['kode_ak']);
						$tree[$cnt][0]= $c_level+$ak_level;
						$tree[$cnt][1]= $mpkode." - ".$rw1["nama"];
						$tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$par[0]."*-*".$rows['MA_ID']."*|*".$par[1]."*-*".$mpkode."*|*".$par[2]."*-*".$rw1["nama"]."*|*".$par[3]."*-*".$c_islast."*|*".$par[4]."*-*".$cc_rv_kso_pbf_umum."*|*".$par[5]."*-*".$rw1["id"]."*|*".$par[6]."*-*".$ak_islast."');window.close();";
						$tree[$cnt][3]= "";
						$tree[$cnt][4]= 0;
						$tree[$cnt][6]= "";
						if ($tree[$cnt][0] > $maxlevel) 
							$maxlevel=$tree[$cnt][0];    
						$cnt++;
					}
					break;
				case 3:
					$sql="SELECT * FROM dbapotek.a_pbf ORDER BY PBF_KODE_AK";
					$rs1=mysql_query($sql);
					while ($rw1=mysql_fetch_array($rs1)){
						$ak_level = 1;
						$ak_islast=1;
						$mpkode=$rows["MA_KODE"].trim($rw1['PBF_KODE_AK']);
						$tree[$cnt][0]= $c_level+$ak_level;
						$tree[$cnt][1]= $mpkode." - ".$rw1["PBF_NAMA"];
						$tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$par[0]."*-*".$rows['MA_ID']."*|*".$par[1]."*-*".$mpkode."*|*".$par[2]."*-*".$rw1["PBF_NAMA"]."*|*".$par[3]."*-*".$c_islast."*|*".$par[4]."*-*".$cc_rv_kso_pbf_umum."*|*".$par[5]."*-*".$rw1["PBF_ID"]."*|*".$par[6]."*-*".$ak_islast."');window.close();";
						$tree[$cnt][3]= "";
						$tree[$cnt][4]= 0;
						$tree[$cnt][6]= "";
						if ($tree[$cnt][0] > $maxlevel) 
							$maxlevel=$tree[$cnt][0];    
						$cnt++;
					}
					break;
				case 4:
					$sql="SELECT * FROM dbaset.as_ms_rekanan ORDER BY koderekanan";
					$rs1=mysql_query($sql);
					while ($rw1=mysql_fetch_array($rs1)){
						$ak_level = 1;
						$ak_islast=1;
						$mpkode=$rows["MA_KODE"].trim($rw1['koderekanan']);
						$tree[$cnt][0]= $c_level+$ak_level;
						$tree[$cnt][1]= $mpkode." - ".$rw1["namarekanan"];
						$tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$par[0]."*-*".$rows['MA_ID']."*|*".$par[1]."*-*".$mpkode."*|*".$par[2]."*-*".$rw1["namarekanan"]."*|*".$par[3]."*-*".$c_islast."*|*".$par[4]."*-*".$cc_rv_kso_pbf_umum."*|*".$par[5]."*-*".$rw1["idrekanan"]."*|*".$par[6]."*-*".$ak_islast."');window.close();";
						$tree[$cnt][3]= "";
						$tree[$cnt][4]= 0;
						$tree[$cnt][6]= "";
						if ($tree[$cnt][0] > $maxlevel) 
							$maxlevel=$tree[$cnt][0];    
						$cnt++;
					}
					break;
			}
		 }else{
			 $tree[$cnt][0]= $c_level;
			 $tree[$cnt][1]= $rows["MA_KODE"]." - ".$rows["MA_NAMA"];
			$tree[$cnt][2]= "javascript:fSetValue(window.opener,'".$par[0]."*-*".$rows['MA_ID']."*|*".$par[1]."*-*".$rows['MA_KODE']."*|*".$par[2]."*-*".$rows['MA_NAMA']."*|*".$par[3]."*-*".$c_islast."*|*".$par[4]."*-*0*|*".$par[5]."*-*0*|*".$par[6]."*-*0');window.close();";
			 $tree[$cnt][3]= "";
			 $tree[$cnt][4]= 0;
			 $tree[$cnt][6]= "";
			 if ($tree[$cnt][0] > $maxlevel) 
				$maxlevel=$tree[$cnt][0];    
			 $cnt++;
		 }
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