<?php 
session_start();
include("../koneksi/konek.php");
$PATH_INFO="?".$_SERVER['QUERY_STRING'];
$_SESSION["PATH_MS_MA"]=$PATH_INFO;
$par=$_REQUEST['par'];
$par=explode("*",$par);
$noidx=$_REQUEST["cnt"];
$kodepilih=$_REQUEST["kodepilih"];
$arfvalue=$_REQUEST["arfvalue"];
$cuser=$_REQUEST['cuser'];
?>
<html>
<title>Tree Rekening</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/simkeu.css" type="text/css" />
<style>
BODY, TD {font-family:Verdana; font-size:7pt;}
.NormalBG 
{
	background-color: #FFFFFF;
}

.AlternateBG { 
	background-color:#B3FFEE;
}

</style>
<body style="border-width:0px;" bgcolor="#CCCCCC" topmargin="0" leftmargin="0" onLoad="javascript:if (window.focus) window.focus();">
<div align="center">
<table border=1 cellspacing=0 width="98%">
<tr><td class=GreenBG align=center><font size=1><b>.: Daftar Jenis Transaksi :. </b></font></td>
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
  $strSQL = "select * from jenis_transaksi where jtrans_aktif=1 and JTRANS_KODE like '$kodepilih%' order by jtrans_kode";
  //echo $strSQL;
  $rs = mysql_query($strSQL);
  while ($rows=mysql_fetch_array($rs)){
		 $c_level = $rows["JTRANS_LEVEL"];
		 if ($cnt==0) $setLevel=$c_level-1;
		 $c_level= $c_level-$setLevel;
		 $c_islast = $rows["JTRANS_ISLAST"];
		 $panjangKode = strlen($rows["JTRANS_KODE"]);
		 $tree[$cnt][0]= $c_level;
		 $tree[$cnt][1]= $rows["JTRANS_KODE"]." - ".$rows["JTRANS_NAMA"];
		 if ($c_level>0){
		 	//if (($c_islast==1) or ($panjangKode >=4))
			if ($c_islast==1){
				$sqlBJenis="SELECT DISTINCT
						  mbj.id,
						  mbj.nama,
						  mbj.kode
						FROM detil_transaksi dt
						  INNER JOIN ak_ms_beban_jenis mbj
							ON dt.fk_ms_beban_jenis = mbj.id
						WHERE dt.fk_jenis_trans = '".$rows["JTRANS_ID"]."'
						ORDER BY mbj.kode";
				$rsBJenis=mysql_query($sqlBJenis);
				if (mysql_num_rows($rsBJenis)>0){
					$c_islast = 0;
					//$tree[$cnt][2] = null;
					$tree[$cnt][2]= "javascript:window.opener.location='main.php?f=transaksi&fk_jnsTrans=".$rows['JTRANS_ID']."&idBebanJenis=0"."&fk_TipeJurnal=".$rows['TIPE_JURNAL']."&fk_kodeTrans=".$rows['JTRANS_KODE']."&islast=".$rows['JTRANS_ISLAST']."&kodepilih=".$kodepilih."&arfvalue=".$arfvalue."&cuser=".$cuser."&ganti=1';window.close();";
					$tree[$cnt][3]= "";
					$tree[$cnt][4]= 0;
					if ($tree[$cnt][0] > $maxlevel) 
						$maxlevel=$tree[$cnt][0];    
					$cnt++;
					
					$c_level++;
					while ($rwBJenis=mysql_fetch_array($rsBJenis)){
						$tree[$cnt][0]= $c_level;
						$c_islast = 1;
						$tree[$cnt][1]= $rows["JTRANS_KODE"].".".$rwBJenis["kode"]." - ".$rwBJenis["nama"];

						$tree[$cnt][2]= "javascript:window.opener.location='main.php?f=transaksi&fk_jnsTrans=".$rows['JTRANS_ID']."&idBebanJenis=".$rwBJenis["id"]."&fk_TipeJurnal=".$rows['TIPE_JURNAL']."&fk_kodeTrans=".$rows['JTRANS_KODE']."&islast=".$rows['JTRANS_ISLAST']."&kodepilih=".$kodepilih."&arfvalue=".$arfvalue."&cuser=".$cuser."&ganti=1';window.close();";
						$tree[$cnt][3]= "";
						$tree[$cnt][4]= 0;
						if ($tree[$cnt][0] > $maxlevel) 
							$maxlevel=$tree[$cnt][0];    
						$cnt++;
					}
				}else{
					$tree[$cnt][2]= "javascript:window.opener.location='main.php?f=transaksi&fk_jnsTrans=".$rows['JTRANS_ID']."&idBebanJenis=0"."&fk_TipeJurnal=".$rows['TIPE_JURNAL']."&fk_kodeTrans=".$rows['JTRANS_KODE']."&islast=".$rows['JTRANS_ISLAST']."&kodepilih=".$kodepilih."&arfvalue=".$arfvalue."&cuser=".$cuser."&ganti=1';window.close();";
					$tree[$cnt][3]= "";
					$tree[$cnt][4]= 0;
					if ($tree[$cnt][0] > $maxlevel) 
						$maxlevel=$tree[$cnt][0];    
					$cnt++;
				}
			}else{
				$tree[$cnt][2] = null;
				$tree[$cnt][3]= "";
				$tree[$cnt][4]= 0;
				if ($tree[$cnt][0] > $maxlevel) 
					$maxlevel=$tree[$cnt][0];    
				$cnt++;
			}
 		 }else{
		 	$tree[$cnt][2] = null;
			$tree[$cnt][3]= "";
			$tree[$cnt][4]= 0;
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