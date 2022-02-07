<?php 
session_start();
include("../koneksi/konek.php");
//if (isset($_SESSION["PATH_INFO"]))
//	$PATH_INFO=$_SESSION["PATH_INFO"];
//else{
	$PATH_INFO="?".$_SERVER['QUERY_STRING'];
	$_SESSION["PATH_INFO"]=$PATH_INFO;
//}
$qstr_ma="par=parent*kode_rensp*rensinduk*parent_lvl";
//$idhapus="idrens";
$_SESSION["PATH_MS_MA"]="?".$qstr_ma;

$th=gmdate('Y',mktime(date('H')+7));

$idrens=$_REQUEST['idrens'];
$kode_rens=trim($_REQUEST['kode_rens']);
$rens=str_replace("\'","''",$_REQUEST['rens']);
$rens=str_replace('\"','"',$rens);
$rens=str_replace(chr(92).chr(92),chr(92),$rens);
$tgl1=$_REQUEST['tgl1'];if ($tgl1=="") $tgl1=$th;
$tgl2=$_REQUEST['tgl2'];if ($tgl2=="") $tgl2=$th+4;
$tgl3=$_REQUEST['tgl3'];if ($tgl3=="") $tgl3=$th;
//$aktif=$_REQUEST['aktif'];
//if ($aktif=="") $aktif=1;
$kode_rensp=trim($_REQUEST['kode_rensp']);
if ($kode_rensp==""){
	$parent=0;
	$parent_lvl=0;
}else{
	$parent=$_REQUEST['parent'];
	if ($parent=="") $parent=0;
	$parent_lvl=$_REQUEST['parent_lvl'];
	if ($parent_lvl=="") $parent_lvl=0;
	$kode_rens=$kode_rensp.$kode_rens;
}

$lvl=$parent_lvl+1;
$act=$_REQUEST['act'];
//echo $act;
switch ($act){
	case "save":
		$sql="select * from kegiatan where KG_KODE='$kode_rens' and KG_TYPE=1 and KG_TAHUN1>=$tgl1";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "<script>alert('Kode Rencana Strategis Sudah Ada');</script>";
		}else{
			$sql="insert into kegiatan(KG_KODE,KG_KET,KG_LEVEL,KG_PARENT,KG_PARENT_KODE,KG_TAHUN,KG_TAHUN1) values('$kode_rens','$rens',$lvl,$parent,'$kode_rensp',$tgl1,$tgl2)";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
			if ($parent>0){
				$sql="update kegiatan set KG_ISLAST=0 where KG_ID=$parent";
				//echo $sql;
				$rs=mysql_query($sql);
			}
		}
		mysql_free_result($rs1);
		break;
	case "edit":
		$sql="update kegiatan set KG_KODE='$kode_rens',KG_KET='$rens',KG_LEVEL=$lvl,KG_PARENT=$parent,KG_PARENT_KODE='$kode_rensp',KG_TAHUN=$tgl1,KG_TAHUN1=$tgl2 where KG_ID=$idrens";
		//echo $sql."<br>";
		$rs=mysql_query($sql);
		break;
	case "delete":
		$sql="select * from kegiatan where kg_parent=$idrens";
		$rs1=mysql_query($sql);
		if ($rows=mysql_fetch_array($rs1)){
			$islst=$rows["KG_ISLAST"];
			if ($islst==1)
				echo "<script>alert('Kode Rencana Strategis Ini Sudah Digunakan Dlm Kegiatan, Jadi Tidak Boleh Dihapus');</script>";
			else
				echo "<script>alert('Kode Rencana Strategis Ini Mempunyai Child, Jadi Tidak Boleh Dihapus');</script>";
		}else{
			$sql="delete from kegiatan where KG_ID=$idrens";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
			$sql="select * from KEGIATAN where KG_PARENT=".$parent;
			$rs=mysql_query($sql);
			if (mysql_num_rows($rs)<=0){
				$sql="update KEGIATAN set KG_ISLAST=1 where KG_ID=".$parent;
				$rs=mysql_query($sql);
			}
		}
		mysql_free_result($rs1);
		break;
}
?>
<html>
<head>
<title>Master Data Mata Anggaran</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<link rel="stylesheet" href="../theme/simkeu.css" type="text/css" />
</head>
<style>
.tree_ma {font-family:Verdana; font-size:8pt}
.tree_ma1 {font-family:Verdana; font-size:8pt; color:#333333;}
</style>
<body>
<div align="center">
  <form name="form1" method="post" action="">
  <input name="act" id="act" type="hidden" value="save">
  <input name="idrens" id="idrens" type="hidden" value="">
  <input name="parent_lvl" id="parent_lvl" type="hidden" value="<?php echo $parent_lvl; ?>">
  <input name="parent" id="parent" type="hidden" value="<?php echo $parent; ?>">
  <div id="input" style="display:none">
      <p class="jdltable">Input Data Rencana Strategis (RENSTRA)</p>
      <table width="90%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
        <tr> 
          <td width="35%">Kode Rencana Strategis Induk</td>
          <td width="2%">:</td>
          <td><input name="kode_rensp" type="text" id="kode_rensp" size="15" maxlength="15" style="text-align:center" value="<?php echo $kode_rensp; ?>" readonly="true"> 
            <input type="button" name="Button222" value="..." title="Pilih Rencana Strategis (Renstra) Induk" onClick="OpenWnd('../master/tree_renstra_view.php?<?php echo $qstr_ma; ?>',800,500,'msrens',true)">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            <input type="button" name="Button" value="Reset" onClick="fSetValue(window,'act*-*save*|*kode_rensp*-**|*rensinduk*-*')"></td>
        </tr>
        <tr> 
          <td>Nama Rencana Strategis Induk</td>
          <td>:</td>
          <td><textarea name="rensinduk" cols="50" rows="4" id="rensinduk" readonly><?php echo $rensinduk; ?></textarea></td>
        </tr>
        <tr> 
          <td width="35%">Kode Rencana Strategis (Renstra)</td>
          <td width="2%">:</td>
          <td><input name="kode_rens" type="text" id="kode_rens" size="5" maxlength="6" style="text-align:center"></td>
        </tr>
        <tr> 
          <td>Nama Rencana Strategis (Renstra)</td>
          <td>:</td>
          <td><textarea name="rens" cols="50" rows="4" id="rens"></textarea></td>
        </tr>
        <tr> 
          <td>Masa Berlaku</td>
          <td>:</td>
          <td>
		  	<select name="tgl1" id="tgl1">
		  	<?php for ($i=$th-1;$i<$th+12;$i++){?>
              <option value="<?php echo $i; ?>"<?php if ($i==$tgl1) echo " selected";?>><?php echo $i; ?></option>
			<?php }?>
            </select>&nbsp;&nbsp;s/d&nbsp;&nbsp;
		  	<select name="tgl2" id="tgl2">
		  	<?php for ($i=$th-1;$i<$th+12;$i++){?>
              <option value="<?php echo $i; ?>"<?php if ($i==$tgl2) echo " selected";?>><?php echo $i; ?></option>
			<?php }?>
            </select>		  
		  </td>
        </tr>
      </table>
  <p><BUTTON type="button" onClick="if (ValidateForm('kode_rens,rens','ind')){document.form1.submit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>&nbsp;<BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('listma').style.display='block';fSetValue(window,'act*-*save');"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
  </div>
  <div id="listma" style="display:block">
  <p>
  	<table width="98%" cellpadding="0" cellspacing="0" border="0">
		
		<tr>
		  <td colspan="3" class="jdltable">&nbsp;</td>
	    </tr>
		<tr>
		  <td colspan="3" class="jdltable">DAFTAR RENCANA STRATEGIS </td>
	    </tr>
		<tr>
			<td width="250">&nbsp;</td>
			
          <td align="center" class="jdltable"><!--select name="select" id="select">
              <?php //for ($i=$th-1;$i<$th+12;$i++){?>
              <option value="<?php //echo $i; ?>"<?php //if ($i==$tgl3) echo " selected";?>><?php //echo $i; ?></option>
              <?php //}?>
            </select--></td>
			<td width="250" align="right"><!--BUTTON type="button" onClick="location='?f=../master/ms_renstra.php'"><IMG SRC="../images/tree_expand.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tabel View</BUTTON-->&nbsp;<BUTTON type="button" onClick="document.getElementById('input').style.display='block';document.getElementById('listma').style.display='none';"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah</BUTTON></td>
		</tr>
	</table>
<table border=1 cellspacing=0 width=98%>
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
  /* tree[x][5] -> id_ma                       */
  /* tree[x][6] -> aktif/tdk aktif             */
  /*********************************************/
  //$tree=array();
  $include_del = 1;
  $canRead = true;
  $maxlevel=0;
  $cnt=0;
  $strSQL = "select * from kegiatan where kg_type=1 and kg_tahun<=$th and kg_tahun1>=$th order by kg_kode";
  $rs = mysql_query($strSQL);
  while ($rows=mysql_fetch_array($rs)){
		 $c_level = $rows["KG_LEVEL"];
		 $pkode=trim($rows['KG_PARENT_KODE']);
		 $mkode=trim($rows['KG_KODE']);
		 if ($pkode!="") $mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
		 $sql="select * from kegiatan where kg_id=".$rows['KG_PARENT'];
		 $rs1=mysql_query($sql);
		 if ($rows1=mysql_fetch_array($rs1)) $rensp=trim($rows1["KG_KET"]); else $rensp="";
		 $tree[$cnt][0]= $c_level;
		 $tree[$cnt][1]= $rows['KG_KODE']." - ".$rows["KG_KET"];
		 $arfvalue="act*-*edit*|*kode_rensp*-*".$pkode."*|*idrens*-*".$rows['KG_ID']."*|*kode_rens*-*".$mkode."*|*rens*-*".$rows['KG_KET']."*|*rensinduk*-*".$rensp."*|*parent_lvl*-*".($rows['KG_LEVEL']-1)."*|*parent*-*".$rows['KG_PARENT']."*|*tgl1*-*".$rows['KG_TAHUN']."*|*tgl2*-*".$rows['KG_TAHUN1'];
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
		 if ($c_level>0)
			 $tree[$cnt][2]= "javascript:document.getElementById('input').style.display='block';document.getElementById('listma').style.display='none';fSetValue(window,'".$arfvalue."');";
 		 else
		 	 $tree[$cnt][2] = null;

		 $tree[$cnt][3]= "";
		 $tree[$cnt][4]= 0;
		 $tree[$cnt][5]=($rows['KG_ISLAST']==1)?$rows['KG_ID']:0;
		 $tree[$cnt][6]=1;
		 $tree[$cnt][7]="act*-*delete*|*idrens*-*".$rows['KG_ID']."*|*parent*-*".$rows['KG_PARENT'];
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