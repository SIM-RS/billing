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
//$jenis=$_REQUEST['jenis'];
$kode_ma=trim($_REQUEST['kode_ma']);
$kode_ma_ori=$kode_ma;
$kode_blu=trim($_REQUEST['kode_blu']);//echo "kode_blu=|".$_REQUEST['kode_blu']."|<br>";
$ma=str_replace("\'","''",$_REQUEST['ma']);
$ma=str_replace('\"','"',$ma);
$ma=str_replace(chr(92).chr(92),chr(92),$ma);
//$fkunit=$_REQUEST['fkunit'];
//$type=$_REQUEST['type'];
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

$lvl=$parent_lvl+1;
$act=$_REQUEST['act'];
//echo $act;
switch ($act){
	case "save":
		$sql="select * from COST where COST_KODE='$kode_ma' and COST_AKTIF=$aktif";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "<script>alert('Kode Cost Center Sudah Ada');</script>";
		}else{
			$sql="insert into cost(COST_KODE,COST_NAMA,COST_LEVEL,COST_PARENT,COST_PARENT_KODE,COST_AKTIF) values('$kode_ma','$ma',$lvl,$parent,'$kode_ma2',$aktif)";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
			if ($parent>0){
				$sql="update cost set COST_ISLAST=0 where COST_ID=$parent";
				//echo $sql;
				$rs=mysql_query($sql);
			}
		}
		mysql_free_result($rs1);
		break;
	case "edit":
		$sql="select * from COST where COST_KODE='$kode_ma' and COST_NAMA='$ma' and COST_AKTIF=$aktif";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "<script>alert('Cost Center Tersebut Sudah Ada');</script>";
		}else{
			$sql="select * from cost where COST_ID=$idma";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
			if ($rows=mysql_fetch_array($rs)){
				$cparent=$rows["COST_PARENT"];
				$clvl=$rows["COST_LEVEL"];
				$cmkode=$rows["COST_KODE"];
				$cislast=$rows["COST_ISLAST"];
			}
			//echo "cparent=".$cparent.",clvl=".$clvl.",cmkode=".$cmkode.",cislast=".$cislast."<br>";
			if ($cparent!=$parent){
				$cur_lvl=$lvl-$clvl;
				if ($cur_lvl>0) $cur_lvl="+".$cur_lvl;
				$sql="update cost set COST_ISLAST=0 where COST_ID=".$parent;
				//echo $sql."<br>";
				$rs=mysql_query($sql);
			$sql="update cost set COST_KODE='$kode_ma',COST_NAMA='$ma',COST_LEVEL=$lvl,COST_PARENT=$parent,COST_PARENT_KODE='$kode_ma2',COST_AKTIF=$aktif where COST_ID=$idma";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				if ($cislast==0){
					$sql="update cost set cost_kode='$kode_ma'+right(cost_kode,len(cost_kode)-len('$cmkode')),cost_parent_kode='$kode_ma'+right(cost_parent_kode,len(cost_parent_kode)-len('$cmkode')),cost_level=cost_level".$cur_lvl." where left(cost_kode,len('$cmkode'))='$cmkode'";
					//echo $sql."<br>";
					$rs=mysql_query($sql);
				}
				$sql="select * from cost where COST_PARENT=$cparent";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				if (mysql_num_rows($rs)<=0){
					$sql="update cost set COST_ISLAST=1 where COST_ID=".$cparent;
					//echo $sql."<br>";
					$rs1=mysql_query($sql);
				}				
			}else{	
				$sql="update cost set COST_KODE='$kode_ma',COST_NAMA='$ma',COST_AKTIF=$aktif where COST_ID=$idma";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
			}
		}
		break;
	case "delete":
		$sql="select * from cost where cost_parent=$idma";
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "<script>alert('Kode Cost Center ini Mempunyai Child, Jadi Tidak Boleh Dihapus');</script>";
		}else{
			$sql="select * from jurnal where fk_cost=$idma";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
			if (mysql_num_rows($rs)>0){
				echo "<script>alert('Kode Cost Center Ini Sudah Pernah Digunakan Untuk Transaksi Jurnal, Jadi Tidak Boleh Dihapus');</script>";
			}else{
				$sql="delete from cost where COST_ID=$idma";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				$sql="select * from cost where COST_PARENT=".$parent;
				$rs2=mysql_query($sql);
				if (mysql_num_rows($rs2)<=0){
					$sql="update cost set COST_ISLAST=1 where COST_ID=".$parent;
					$rs2=mysql_query($sql);
				}
			}
		}
		mysql_free_result($rs1);
		break;
}
?>
<html>
<head>
<title>Master Data Cost Center</title>
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
  <input name="parent_lvl" id="parent_lvl" type="hidden" value="<?php echo $parent_lvl; ?>">
  <input name="parent" id="parent" type="hidden" value="<?php echo $parent; ?>">
  <div id="input" style="display:none" >
      <p class="jdltable">Input Data Cost Center</p>
      <table width="75%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
        <tr> 
          <td>Kode Cost Center Induk</td>
          <td>:</td>
          <td valign="middle"><input name="kode_ma2" type="text" id="kode_ma2" size="20" maxlength="20" style="text-align:center" value="<?php echo $kode_ma2; ?>" readonly="true" class="txtcenter"> 
            <input type="button" class="txtcenter" name="Button222" value="..." title="Pilih Cost Center Induk" onClick="OpenWnd('../master/tree_cost_view.php?<?php echo $qstr_ma; ?>',800,500,'msma',true)"> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="button" name="Button" class="txtcenter" value="Reset" onClick="fSetValue(window,'act*-*save*|*kode_ma2*-**|*kode_ma*-**|*ma*-**|*parent*-**|*mainduk*-*')"></td>
        </tr>
        <tr> 
          <td>Nama Cost Center Induk</td>
          <td>:</td>
          <td ><textarea name="mainduk" cols="50" rows="3" readonly class="txtinput" id="mainduk"><?php echo $mainduk; ?></textarea></td>
        </tr>
        <tr> 
          <td>Kode Cost Center</td>
          <td>:</td>
          <td><input name="kode_ma" type="text" id="kode_ma" size="5" maxlength="6" class="txtinput" style="text-align:center"></td>
        </tr>
        <tr> 
          <td>Nama Cost Center </td>
          <td>:</td>
          <td ><textarea name="ma" cols="50" rows="3" class="txtinput" id="ma"></textarea></td>
        </tr>
        <tr> 
          <td>Status</td>
          <td>:</td>
          <td><select name="aktif" id="aktif" class="txtinput">
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select></td>
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
		  <td colspan="3" class="jdltable">DAFTAR COST CENTER</td>
	    </tr>
		
		<tr>
			<td width="98">&nbsp;</td>
			<td width="370" align="center" class="jdltable">&nbsp;</td>
			<td align="right"><BUTTON type="button" onClick="location='?f=../master/ms_cost.php'"><IMG SRC="../icon/view_list.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tabel View</BUTTON> 
            <BUTTON type="button" onClick="document.getElementById('input').style.display='block';document.getElementById('listma').style.display='none';"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah</BUTTON></td>
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
  /* tree[x][5] -> id_ma                       */
  /* tree[x][6] -> aktif/tdk aktif             */
  /*********************************************/
  //$tree=array();
  $canRead = true;
  $include_del = 1;
  $maxlevel=0;
  $cnt=0;
  $strSQL = "select * from COST order by cost_kode";
  $rs = mysql_query($strSQL);
  while ($rows=mysql_fetch_array($rs)){
		 $c_level = $rows["COST_LEVEL"];
		 $pkode=trim($rows['COST_PARENT_KODE']);
		 $mkode=trim($rows['COST_KODE']);
	//	 $mpkode=trim($rows['MA_MKODE']);
		 if ($pkode!=""){
		 //	if (substr($mkode,0,strlen($pkode))==$pkode) 
				$mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
			//else
			//	$mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
		 }
		 $sql="select * from cost where cost_id=".$rows['COST_PARENT'];
		// echo $sql;
		 $rs1=mysql_query($sql);
		 if ($rows1=mysql_fetch_array($rs1)) $c_mainduk=$rows1["COST_NAMA"]; else $c_mainduk="";
		 $tree[$cnt][0]= $c_level;
		 $tree[$cnt][1]= $rows["COST_KODE"]." - ".($mpkode==""?"":$mpkode." - ").$rows["COST_NAMA"];
		 $arfvalue="act*-*edit*|*kode_ma2*-*".$pkode."*|*idma*-*".$rows['COST_ID']."*|*kode_ma*-*".$mkode."*|*ma*-*".$rows['COST_NAMA']."*|*parent_lvl*-*".($rows['COST_LEVEL']-1)."*|*parent*-*".$rows['COST_PARENT']."*|*mainduk*-*".$c_mainduk."*|*aktif*-*".$rows['COST_AKTIF'];
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
		 if ($c_level>0)
			 $tree[$cnt][2]= "javascript:document.getElementById('input').style.display='block';document.getElementById('listma').style.display='none';fSetValue(window,'".$arfvalue."');";
 		 else
		 	 $tree[$cnt][2] = null;

		 $tree[$cnt][3]= "";
		 $tree[$cnt][4]= 0;
		 $tree[$cnt][5]=($rows['COST_ISLAST']==1)?$rows['COST_ID']:0;
		 //$tree[$cnt][5]="act*-*delete*|*idma*-*".$rows['COST_ID']."*|*parent*-*".$rows['COST_PARENT'];
		 $tree[$cnt][6]=$rows['COST_AKTIF'];
		 $tree[$cnt][7]="act*-*delete*|*idma*-*".$rows['COST_ID']."*|*parent*-*".$rows['COST_PARENT'];
		 if ($tree[$cnt][0] > $maxlevel) 
			$maxlevel=$tree[$cnt][0];    
		 $cnt++;
	}
	mysql_free_result($rs);
include("../master/treemenu.inc.php");

?>
</td></tr>
</table>
    </p>
	</div>
</form>
</div>
</body>
</html>
<?php 
mysql_close($konek);
?>