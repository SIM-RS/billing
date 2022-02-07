<?php 
session_start();
include("../koneksi/konek.php");
$PATH_INFO="?".$_SERVER['QUERY_STRING'];
$_SESSION["PATH_INFO"]=$PATH_INFO;
$qstr_ma="par=parent*kode_ma2*mainduk*parent_lvl";
//$idhapus="idma";
$_SESSION["PATH_MS_MA"]="?".$qstr_ma;
//echo $_SERVER['HTTP_USER_AGENT'];
$idma=$_REQUEST['idma'];
$tipe=$_REQUEST['tipe'];
//$jenis=$_REQUEST['jenis'];
$jenis= '3';
$kode_ma=trim($_REQUEST['kode_ma']);
$kode_ma_ori=$kode_ma;
$ma=str_replace("\'","''",$_REQUEST['ma']);
$ma=str_replace('\"','"',$ma);
$ma=str_replace(chr(92).chr(92),chr(92),$ma);
//$fkunit=$_REQUEST['fkunit'];
$fkunit='0';
//$type=$_REQUEST['type'];
$type='0';
$aktif=$_REQUEST['aktif'];
if ($aktif=="") $aktif=1;
$kode_ma2=trim($_REQUEST['kode_ma2']);
if ($kode_ma2==""){
	$parent=0;
	$parent_lvl=0;
}else{
	$parent=$_REQUEST['parent'];
	if ($parent=="") $parent=0;
	$parent_lvl=$_REQUEST['parent_lvl'];
	if ($parent_lvl=="") $parent_lvl=0;
	$kode_ma=$kode_ma2.$kode_ma;
}

$idjtrans=$_REQUEST['idjtrans'];
$idma=$_REQUEST['idma'];
$txtidDPA=$_REQUEST['txtidDPA'];

$lvl=$parent_lvl+1;
$act=$_REQUEST['act'];
//echo $act;
//echo $act;
switch ($act){
	case "save":
		$sql="select * from $dbakuntansi.ak_ms_jenis_transaksi_dpa mjt_dpa where mjt_dpa.fk_jenis_trans='$idjtrans' AND mjt_dpa.fk_ma_sak='$idma'";
		//echo $sql;
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			$sql="UPDATE $dbakuntansi.ak_ms_jenis_transaksi_dpa SET fk_id_dpa='$txtidDPA' WHERE fk_jenis_trans='$idjtrans' AND fk_ma_sak='$idma'";
			//echo $sql;
			$rs=mysql_query($sql);
		}else{
			$sql="INSERT INTO $dbakuntansi.ak_ms_jenis_transaksi_dpa(fk_jenis_trans,fk_ma_sak,fk_id_dpa) VALUES('$idjtrans','$idma','$txtidDPA')";
			//echo $sql;
			$rs=mysql_query($sql);
		}
		mysql_free_result($rs1);
		break;
}
?>
<html>
<head>
<title>INPUT MAPPING JENIS TRANSAKSI - MA DPA</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/simkeu.css" type="text/css" />
</head>
<body>
<div align="center">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
  <input name="idma" id="idma" type="hidden" value="">
  <input name="idjtrans" id="idjtrans" type="hidden" value="">
  <input name="parent_lvl" id="parent_lvl" type="hidden" value="<?php echo $parent_lvl; ?>">
  <input name="parent" id="parent" type="hidden" value="<?php echo $parent; ?>">
  <input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
  <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
  <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <div id="input" style="display:none">
      <p class="jdltable">Input Jenis Transaksi</p>
    <table width="75%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
      <tr>
          <td>Kode Jenis Transaksi</td>
      <td>:</td>
          <td><input name="kode_ma" type="text" id="kode_ma" size="20" readonly style="text-align:center"></td>
    </tr>
    <tr>
      <td>Nama Jenis Transaksi</td>
      <td>:</td>
          <td ><textarea name="ma" cols="50" id="ma" readonly class="txtinput"></textarea></td>
    </tr>
      <tr>
          <td>Kode DPA</td>
      <td>:</td>
          <td><input name="txtidDPA" id="txtidDPA" type="hidden" value="0"><input name="kode_dpa" type="text" id="kode_dpa" size="20" style="text-align:center" value="" readonly="true" class="txtinput">
            <input type="button" name="Buttondpa" value="..." class="txtcenter" title="Pilih Rekening DPA" onClick="OpenWnd('../master/tree_mata_anggaran.php?id=0&par=txtidDPA*kode_dpa*ma_dpa',800,500,'msma',true)">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" name="Button" value="Reset" class="txtcenter" onClick="fSetValue(window,'txtidDPA*-*0*|*kode_dpa*-**|*ma_dpa*-*')"></td>
    </tr>
    <tr>
      <td>Nama MA DPA</td>
      <td>:</td>
          <td ><textarea name="ma_dpa" cols="50" id="ma_dpa" readonly class="txtinput"></textarea></td>
    </tr>
  </table>
  <p><BUTTON type="button" onClick="if (ValidateForm('kode_ma,ma','ind')){document.form1.submit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>&nbsp;<BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('listma').style.display='block';fSetValue(window,'act*-*save');"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
  </div>
  <div id="listma" style="display:block">
  <p>
  	<table width="98%" cellpadding="0" cellspacing="0" border="0">
		
		<tr>
		  <td colspan="3" class="jdltable">&nbsp;</td>
	    </tr>
		<tr>
		  <td colspan="3" class="jdltable">DAFTAR MASTER TRANSAKSI</td>
	    </tr>
	</table>
<table border=1 cellspacing=0 width=98%>
<tr bgcolor="whitesmoke"><td>
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
  $strSQL = "select * from $dbakuntansi.jenis_transaksi where jtrans_aktif=1 and (JTRANS_KODE like '14%' OR JTRANS_KODE like '16%') order by jtrans_kode";
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
		 $iddpa='0';
		 $kodedpa='';
		 $ma_dpa='';
		 
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
					$strSQL = "SELECT madpa.ma_id,madpa.ma_kode,madpa.ma_nama 
FROM $dbakuntansi.ak_ms_jenis_transaksi_dpa mjt_dpa 
INNER JOIN $dbanggaran.ms_ma madpa ON mjt_dpa.fk_id_dpa=madpa.ma_id 
WHERE mjt_dpa.fk_jenis_trans='".$rows['JTRANS_ID']."' AND mjt_dpa.fk_ma_sak='".$data1['MA_ID']."'";
					$rsCekdpa=mysql_query($strSQL);
					if (mysql_num_rows($rsCekdpa)){
						$rwCekdpa=mysql_fetch_array($rsCekdpa);
						$iddpa=$rwCekdpa["ma_id"];
						$kodedpa=$rwCekdpa["ma_kode"];
						$ma_dpa=$rwCekdpa["ma_nama"];
					}else{
						$iddpa=0;
						$kodedpa='';
						$ma_dpa='';
					}
					
					$tree[$cnt][1] .= " ---> ".$ma_dpa;

					$arfvalue="kode_ma*-*".$rows['JTRANS_KODE']."*|*ma*-*".$rows['JTRANS_NAMA']."*|*idjtrans*-*".$rows['JTRANS_ID']."*|*idma*-*".$data1['MA_ID']."*|*txtidDPA*-*".$iddpa."*|*kode_dpa*-*".$kodedpa."*|*ma_dpa*-*".$ma_dpa;
					$arfvalue=str_replace('"',chr(3),$arfvalue);
					$arfvalue=str_replace("'",chr(5),$arfvalue);
					$arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
					$tree[$cnt][2]= "javascript:document.getElementById('input').style.display='block';fSetValue(window,'".$arfvalue."');";
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
						 $mpkode=$rows["JTRANS_KODE"].$mpkode;
						 $tree[$cnt][1]= $mpkode." - ".$data2["MA_NAMA"];
						 if($data2['CC_RV_KSO_PBF_UMUM']!=1 && $c_islast==1){
							$strSQL = "SELECT madpa.ma_id,madpa.ma_kode,madpa.ma_nama 
		FROM $dbakuntansi.ak_ms_jenis_transaksi_dpa mjt_dpa 
		INNER JOIN $dbanggaran.ms_ma madpa ON mjt_dpa.fk_id_dpa=madpa.ma_id 
		WHERE mjt_dpa.fk_jenis_trans='".$rows['JTRANS_ID']."' AND mjt_dpa.fk_ma_sak='".$data2['MA_ID']."'";
							$rsCekdpa=mysql_query($strSQL);
							if (mysql_num_rows($rsCekdpa)){
								$rwCekdpa=mysql_fetch_array($rsCekdpa);
								$iddpa=$rwCekdpa["ma_id"];
								$kodedpa=$rwCekdpa["ma_kode"];
								$ma_dpa=$rwCekdpa["ma_nama"];
							}else{
								$iddpa=0;
								$kodedpa='';
								$ma_dpa='';
							}
							
							$tree[$cnt][1] .= " ---> ".$ma_dpa;
							
							$arfvalue="kode_ma*-*".$mpkode."*|*ma*-*".$data2['MA_NAMA']."*|*idjtrans*-*".$rows['JTRANS_ID']."*|*idma*-*".$data2['MA_ID']."*|*txtidDPA*-*".$iddpa."*|*kode_dpa*-*".$kodedpa."*|*ma_dpa*-*".$ma_dpa;
							$arfvalue=str_replace('"',chr(3),$arfvalue);
							$arfvalue=str_replace("'",chr(5),$arfvalue);
							$arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
							$tree[$cnt][2]= "javascript:document.getElementById('input').style.display='block';fSetValue(window,'".$arfvalue."');";
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
										 $mpkode=$rows["JTRANS_KODE"].$data2['MA_KODE'].$mpkode;
										 $tree[$cnt][0]= $c_level;
										 $tree[$cnt][1]= $mpkode." - ".$rows1["nama"];
										 if ($c_islast==1){
											$strSQL = "SELECT madpa.ma_id,madpa.ma_kode,madpa.ma_nama 
						FROM $dbakuntansi.ak_ms_jenis_transaksi_dpa mjt_dpa 
						INNER JOIN $dbanggaran.ms_ma madpa ON mjt_dpa.fk_id_dpa=madpa.ma_id 
						WHERE mjt_dpa.fk_jenis_trans='".$rows['JTRANS_ID']."' AND mjt_dpa.fk_ma_sak='".$data2['MA_ID']."'";
											$rsCekdpa=mysql_query($strSQL);
											if (mysql_num_rows($rsCekdpa)){
												$rwCekdpa=mysql_fetch_array($rsCekdpa);
												$iddpa=$rwCekdpa["ma_id"];
												$kodedpa=$rwCekdpa["ma_kode"];
												$ma_dpa=$rwCekdpa["ma_nama"];
											}else{
												$iddpa=0;
												$kodedpa='';
												$ma_dpa='';
											}

										 	$tree[$cnt][1] .= " ---> ".$ma_dpa;
											
											$arfvalue="kode_ma*-*".$mpkode."*|*ma*-*".$rows1['nama']."*|*idjtrans*-*".$rows['JTRANS_ID']."*|*idma*-*".$data2['MA_ID']."*|*txtidDPA*-*".$iddpa."*|*kode_dpa*-*".$kodedpa."*|*ma_dpa*-*".$ma_dpa;
											$arfvalue=str_replace('"',chr(3),$arfvalue);
											$arfvalue=str_replace("'",chr(5),$arfvalue);
											$arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
											$tree[$cnt][2]= "javascript:document.getElementById('input').style.display='block';fSetValue(window,'".$arfvalue."');";
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
	include("../master/treemenu.inc.php");
?>
</td></tr>
</table>
    </p><!--br>
    <BUTTON type="button" onClick="BukaWndExcell();"><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export ke File Excell</BUTTON-->
	</div>
</form>
</div>
</body>
<!--script language="javascript">
function set_value(par){
var cdata=par.split('|');
	document.getElementById('kode_ma').value = cdata[0];
	document.getElementById('ma').value = cdata[1];
	document.getElementById('idjtrans').value = cdata[2];
	document.getElementById('idma').value = cdata[3];
	document.getElementById('txtidDPA').value = cdata[4];
	document.getElementById('kode_dpa').value = cdata[5];
	document.getElementById('ma_dpa').value = cdata[6];
}

</script-->
</html>
<?php 
mysql_close($konek);
?>