<?php 
include("../sesi.php");
include("../koneksi/konek.php");
$PATH_INFO="?".$_SERVER['QUERY_STRING'];
$_SESSION["PATH_MS_MA"]=$PATH_INFO;
$par=$_REQUEST['par'];
$par=explode("*",$par);
$noidx=$_REQUEST["cnt"];
$kodepilih=explode("|",$_REQUEST["kodepilih"]);
$strpilih="";
for ($j=0;$j<count($kodepilih);$j++) $strpilih .="JTRANS_KODE like '".$kodepilih[$j]."%' OR ";
$strpilih="(".substr($strpilih,0,strlen($strpilih)-4).")";
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
  $strSQL = "select * from $dbakuntansi.jenis_transaksi where jtrans_aktif=1 and ".$strpilih." order by jtrans_kode";
  //echo $strSQL."<br>";
  $rs = mysql_query($strSQL);
  while ($rows=mysql_fetch_array($rs)){
		 $c_level = $rows["JTRANS_LEVEL"];
		 if ($cnt==0) $setLevel=$c_level-1;
		 $c_level= $c_level-$setLevel;
		 $s_level = $c_level;
		 $c_islast = $rows["JTRANS_ISLAST"];
		 $panjangKode = strlen($rows["JTRANS_KODE"]);
		 $tree[$cnt][0]= $c_level;
		 $tree[$cnt][1]= $rows["JTRANS_KODE"]." - ".$rows["JTRANS_NAMA"];
		 
		 if ($c_level>0){
			if ($c_islast==1){
				$cek1 = "SELECT 
					  ma_sak.*
					FROM
					  $dbakuntansi.detil_transaksi 
					  INNER JOIN $dbakuntansi.jenis_transaksi 
						ON detil_transaksi.fk_jenis_trans = jenis_transaksi.JTRANS_ID 
					  INNER JOIN $dbakuntansi.ma_sak 
						ON detil_transaksi.fk_ma_sak = ma_sak.MA_ID 
					WHERE jenis_transaksi.JTRANS_KODE LIKE '".$rows["JTRANS_KODE"]."%' 
					  AND ma_sak.MA_KODE NOT LIKE '11%' 
					ORDER BY detil_transaksi.id_detil_trans";
				 //echo $cek1."<br>";
				 $kueri1 = mysql_query($cek1);
				 $data1 = mysql_fetch_array($kueri1);
				 
				 $cek2 = "SELECT * FROM $dbakuntansi.ma_sak WHERE MA_KODE LIKE '".$data1['MA_KODE']."%' ORDER BY ma_sak.MA_KODE";
				 $kueri2 = mysql_query($cek2);
				 
				if((mysql_num_rows($kueri1)==1 && mysql_num_rows($kueri2)>1)){
					$tree[$cnt][2] = null;
					 $cek2 = "SELECT * FROM $dbakuntansi.ma_sak WHERE MA_KODE LIKE '".$data1['MA_KODE']."%' AND MA_KODE <> '".$data1['MA_KODE']."' ORDER BY ma_sak.MA_KODE";
					 $kueri2 = mysql_query($cek2);
				}else{
					$tree[$cnt][2]= "javascript:set_value('0','$rows[JTRANS_KODE]','$rows[JTRANS_NAMA]','0','$rows[JTRANS_ID]','$data1[MA_ID]','$rows[JTRANS_NAMA]');window.close();";
				}
			}
 		 }else{
		 	 $tree[$cnt][2] = null;
		 }
		 $tree[$cnt][3]= "";
		 $tree[$cnt][4]= 0;
		 if ($tree[$cnt][0] > $maxlevel) 
			$maxlevel=$tree[$cnt][0];    
		 $cnt++;
		 
		 //=================================
		 if ($c_islast==1){
			 if((mysql_num_rows($kueri1)==1 && mysql_num_rows($kueri2)>1)){
				 $sublevel;
				 $cnt2=0;
				 while($data2 = mysql_fetch_array($kueri2)){
					//if($rows['JTRANS_NAMA']!=$data2['MA_NAMA']){//asdsad
						 //$c_level= $s_level+1;
						 $c_level = $data2["MA_LEVEL"];
						 if ($cnt2==0) $sublevel=$c_level-1;
						 $c_level= $s_level+$c_level-$sublevel;
						 $s2_level = $c_level;
						 $tree[$cnt][0]= $s2_level;
						 $c_islast = $data2["MA_ISLAST"];
						 $mpkode=trim($data2['MA_KODE']);
						 $tree[$cnt][1]= $rows["JTRANS_KODE"].($mpkode==""?"":$mpkode." - ").$data2["MA_NAMA"];
						 if($data2['CC_RV_KSO_PBF_UMUM']!=1 && $c_islast==1){
							$tree[$cnt][2]= "javascript:set_value('0','$data2[MA_KODE]','$data2[MA_NAMA]','1','$rows[JTRANS_ID]','$data2[MA_ID]','$rows[JTRANS_NAMA]');window.close();";
						 }else
							$tree[$cnt][2] = null;
						 $tree[$cnt][3]= "";
						 $tree[$cnt][4]= 0;
						 if ($tree[$cnt][0] > $maxlevel) 
							$maxlevel=$tree[$cnt][0];    
						 $cnt++;
						 $cnt2++;
						 
						 if ($data2["CC_RV_KSO_PBF_UMUM"]=='1'){
									if (substr($data2["MA_KODE"],0,1)=="4"){
										$sql="SELECT * FROM $dbakuntansi.ak_ms_unit WHERE LEFT(kode,2)<>'08' AND aktif=1 ORDER BY kode";
									}else{
										$sql="SELECT * FROM $dbakuntansi.ak_ms_unit WHERE aktif=1 ORDER BY kode";
									}
									 $rs1 = mysql_query($sql);
									 while ($rows1=mysql_fetch_array($rs1)){
										 $id_trans =  $rows["JTRANS_ID"];
										 $c_level = $s2_level + $rows1["level"];
										 $c_islast = $rows1["islast"];
										 $mpkode=trim($rows1['kode']);
										 $tree[$cnt][0]= $c_level;
										 $tree[$cnt][1]= $rows["JTRANS_KODE"].$data2['MA_KODE'].($mpkode==""?"":$mpkode." - ").$rows1["nama"];
										 if ($c_islast==1){
											$tree[$cnt][2]= "javascript:set_value('$rows1[id]','$rows1[kode]','$rows1[nama]','1','$rows[JTRANS_ID]','$data2[MA_ID]','$rows[JTRANS_NAMA]');window.close();";
										 }else
											 $tree[$cnt][2] = null;
								
										 $tree[$cnt][3]= "";
										 $tree[$cnt][4]= 0;
										 if ($tree[$cnt][0] > $maxlevel)
											$maxlevel=$tree[$cnt][0];
										 $cnt++;
									 }
						 }
					//}//asdsa
				 }
			 
			 }
		}
		 //=================================
	}
	mysql_free_result($rs);
	$tree_img_path="../images";
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

function set_value(a,b,c,satu,id_trans,id_ma_sak,parent){
	window.opener.document.getElementById('txtIdJnsPeng').value = a;
	window.opener.document.getElementById('txtKodeJnsPeng').value = b;
	if(satu=='1'){
		window.opener.document.getElementById('txtJnsPeng').value = parent + ' - ' + c;
	}
	else{
		window.opener.document.getElementById('txtJnsPeng').value = c;
	}
	window.opener.document.getElementById('txtIdTrans').value = id_trans;
	window.opener.document.getElementById('txtIdMaSak').value = id_ma_sak;
	if (id_ma_sak==378 || id_ma_sak==379){
		//window.opener.document.getElementById('trSup1').style.display = 'table-row';
		window.opener.document.getElementById('trSup2').style.display = 'table-row';
		window.opener.document.getElementById('trFak').style.display = 'table-row';
		window.opener.document.getElementById('tdNilai').innerHTML = 'Nilai SPK (Tagihan)';
		window.opener.document.getElementById('trForm').style.display = 'table-row';
		if (id_ma_sak==378){
			window.opener.document.getElementById('cmbJenSup').value = 1;
		}else{
			window.opener.document.getElementById('cmbJenSup').value = 2;
		}
		window.opener.fillSup(window.opener.document.getElementById('cmbJenSup').value);
	}else{
		//window.opener.document.getElementById('trSup1').style.display = 'none';
		window.opener.document.getElementById('trSup2').style.display = 'none';
		window.opener.document.getElementById('trFak').style.display = 'none';
		window.opener.document.getElementById('tdNilai').innerHTML = 'Nilai';
		window.opener.document.getElementById('trForm').style.display = 'none';
	}
	window.opener.qwerty(satu);
	window.opener.ngeload_grid_detil(b);
}

</script>
</html>
<?php 
mysql_close($konek);
?>