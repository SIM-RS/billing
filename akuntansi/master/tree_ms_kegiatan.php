<?php 
session_start();
include("../koneksi/konek.php");
//if (isset($_SESSION["PATH_INFO"]))
//	$PATH_INFO=$_SESSION["PATH_INFO"];
//else{
	$PATH_INFO="?".$_SERVER['QUERY_STRING'];
	$_SESSION["PATH_INFO"]=$PATH_INFO;
//}
$qstr_ma="par=parent*kode_kg2*kginduk*parent_lvl";
$idhapus="idkg";
$_SESSION["PATH_MS_MA"]="?".$qstr_ma;

$th=gmdate('Y',mktime(date('H')+7));
$ta=$_REQUEST['ta'];
if ($ta=="") $ta=$th;

$idkg=$_REQUEST['idkg'];
$kode_kg=trim($_REQUEST['kode_kg']);
$kg=str_replace("\'","''",trim($_REQUEST['kg']));
$kg=str_replace('\"','"',$kg);
$kg=str_replace(chr(92).chr(92),chr(92),$kg);
$pagu=$_REQUEST['pagu'];if ($pagu=="") $pagu="0";
$archkjd=$_REQUEST['archkjd'];//echo $archkjd;
$archkjd=explode("-",$archkjd);
$kode_kg2=trim($_REQUEST['kode_kg2']);
if ($kode_kg2==""){
	$parent=0;
	$parent_lvl=0;
}else{
	$kode_kg=$kode_kg2.$kode_kg;
	$parent=$_REQUEST['parent'];
	if ($parent=="") $parent=0;
	$parent_lvl=$_REQUEST['parent_lvl'];
	if ($parent_lvl=="") $parent_lvl=0;
}

$lvl=$parent_lvl+1;
$act=$_REQUEST['act'];
//echo $act;
switch ($act){
	case "save":
		$sql="select * from KEGIATAN where KG_KODE='$kode_kg' and KG_TYPE=2 and KG_TAHUN=$ta";
		//echo $sql;
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "<script>alert('Kode Kegiatan Sudah Ada');</script>";
		}else{
			$sql="insert into KEGIATAN(KG_KODE,KG_TAHUN,KG_TAHUN1,KG_KET,KG_LEVEL,KG_PARENT,KG_PARENT_KODE,KG_PAGU,KG_TRW1,KG_TRW2,KG_TRW3,KG_TRW4,KG_TYPE) values('$kode_kg',$ta,$ta,'$kg',$lvl,$parent,'$kode_kg2',$pagu,$archkjd[0],$archkjd[1],$archkjd[2],$archkjd[3],2)";
			//echo $sql;
			$rs=mysql_query($sql);
/*			$sql="select * from kegiatan where kg_id=".$parent;
			$rs=mysql_query($sql);
			if ($rows=mysql_fetch_array($rs)){
				$c_type=$rows[""];
*/
				$sql="update KEGIATAN set KG_ISLAST=0 where KG_ID=$parent and KG_TYPE=2";
				//echo $sql;
				$rs=mysql_query($sql);
//			}
		}
		mysql_free_result($rs1);
		break;
	case "edit":
		$sql="update KEGIATAN set KG_KODE='$kode_kg',KG_KET='$kg',KG_LEVEL=$lvl,KG_PARENT=$parent,KG_PARENT_KODE='$kode_kg2',KG_PAGU=$pagu,KG_TRW1=$archkjd[0],KG_TRW2=$archkjd[1],KG_TRW3=$archkjd[2],KG_TRW4=$archkjd[3] where KG_ID=$idkg";
		$rs=mysql_query($sql);
		break;
	case "delete":
		$sql="select * from kegiatan where KG_PARENT=$idkg";
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "<script>alert('Kode Kegiatan Ini Mempunyai Child, Jadi Tidak Boleh Dihapus');</script>";
		}else{
			$sql="select * from rba where rba_kgid=$idkg";
			$rs=mysql_query($sql);
			if (mysql_num_rows($rs)>0){
				echo "<script>alert('Kode Kegiatan Ini Sudah Dipakai Dalam RBA, Jadi Tidak Boleh Dihapus');</script>";
			}else{
				$sql="delete from KEGIATAN where KG_ID=$idkg";
				$rs=mysql_query($sql);
				$sql="select * from KEGIATAN where KG_PARENT=".$parent;
				$rs2=mysql_query($sql);
				if (mysql_num_rows($rs2)<=0){
					$sql="update KEGIATAN set KG_ISLAST=1 where KG_ID=".$parent;
					$rs2=mysql_query($sql);
				}
			}
		}
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
  <input name="idkg" id="idkg" type="hidden" value="">
  <input name="parent_lvl" id="parent_lvl" type="hidden" value="<?php echo $parent_lvl; ?>">
  <input name="parent" id="parent" type="hidden" value="<?php echo $parent; ?>">
  <input name="archkjd" id="archkjd" type="hidden" value="">
  <div id="input" style="display:none">
      <p class="jdltable">Data Kegiatan</p>
      <table width="70%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
        <tr> 
          <td width="33%">Kode Kegiatan Induk</td>
          <td width="2%">:</td>
          <td width="71%"><input name="kode_kg2" type="text" id="kode_kg2" size="20" maxlength="20" style="text-align:center" value="<?php echo $kode_kg2; ?>" readonly="true"> 
            <input type="button" name="Button222" value="..." title="Pilih Kode Rencana Strategis" onClick="OpenWnd('../master/tree_kegiatan_view.php?<?php echo $qstr_ma; ?>',800,500,'mskg',true)">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            <input type="button" name="Button" value="Reset" onClick="fSetValue(window,'act*-*save*|*kode_kg2*-**|*kginduk*-*')">          </td>
        </tr>
        <tr> 
          <td>Nama Kegiatan Induk</td>
          <td>:</td>
          <td><textarea name="kginduk" cols="50" rows="4" id="kginduk" readonly><?php echo $kginduk; ?></textarea></td>
        </tr>
        <tr> 
          <td width="33%">Kode Kegiatan</td>
          <td width="2%">:</td>
          <td width="71%"> 
            <input name="kode_kg" type="text" id="kode_kg" size="5" maxlength="6" style="text-align:center">
			</td>
        </tr>
        <tr> 
          <td>Nama Kegiatan</td>
          <td>:</td>
          <td><textarea name="kg" cols="50" rows="4" id="kg"></textarea></td>
        </tr>
        <tr> 
          <td>Nilai Pagu (Rp)</td>
          <td>:</td>
          <td><input name="pagu" type="text" id="pagu" size="12" maxlength="12" class="txtright"> 
          </td>
        </tr>
        <tr> 
          <td>JADWAL WAKTU (Triw) </td>
          <td>:</td>
          <td><input type="checkbox" name="chkjd" id="chkjd" value="checkbox">
            I&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="checkbox" name="chkjd" id="chkjd" value="checkbox">
            II&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="checkbox" name="chkjd" id="chkjd" value="checkbox">
            III&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="checkbox" name="chkjd" id="chkjd" value="checkbox">
            IV</td>
        </tr>
        <tr> 
          <td colspan="3" height="20">&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>
  			<p><BUTTON type="button" onClick="if (ValidateForm('kode_kg2,kode_kg,kg,pagu','ind')){fSetArchkjd(document.forms[0].chkjd);document.form1.submit();}"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Simpan</strong></BUTTON>
				&nbsp;&nbsp;<BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('listma').style.display='block';fSetValue(window,'act*-*save');"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Batal</strong>&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON></p>
          </td>
        </tr>
      </table>
  </div>
  <div id="listma" style="display:block">
  <p>
  	<table width="98%" cellpadding="0" cellspacing="0" border="0">
		
		<tr>
		  <td colspan="3"class="jdltable">DAFTAR KEGIATAN</td>
	    </tr>
		
		<tr>
			<td width="250"><span class="txtinput">Data Tahun
			    <select name="ta" id="ta" onChange="location='?f=../master/tree_ms_kegiatan.php&ta='+this.value">
                  <?php for ($i=$th-2;$i<$th+2;$i++){?>
                  <option value="<?php echo $i; ?>" <?php if ($i==$ta) echo "selected"; ?>><?php echo $i; ?></option>
                  <?php }?>
                </select>
			</span></td>
            <td align="center" class="jdltable" >&nbsp;</td>
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
  $strSQL = "select * from kegiatan where kg_tahun<=$ta and kg_tahun1>=$ta order by kg_kode";
  $rs = mysql_query($strSQL);
  while ($rows=mysql_fetch_array($rs)){
		 $c_level = $rows["KG_LEVEL"];
		 $pkode=trim($rows['KG_PARENT_KODE']);
		 $mkode=trim($rows['KG_KODE']);
		 if ($pkode!="") $mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
		 $sql="select * from kegiatan where kg_id=".$rows['KG_PARENT'];
		 $rs1=mysql_query($sql);
		 if ($rows1=mysql_fetch_array($rs1)) $kginduk=trim($rows1["KG_KET"]); else $kginduk="";
		 $tree[$cnt][0]= $c_level;
		 $tree[$cnt][1]= $rows['KG_KODE']." - ".$rows["KG_KET"];
		 $arfchk=$rows['KG_TRW1'].",".$rows['KG_TRW2'].",".$rows['KG_TRW3'].",".$rows['KG_TRW4'];
		 $arfvalue="act*-*edit*|*kode_kg2*-*".$pkode."*|*idkg*-*".$rows['KG_ID']."*|*kode_kg*-*".$mkode."*|*kg*-*".$rows['KG_KET']."*|*parent_lvl*-*".($rows['KG_LEVEL']-1)."*|*kginduk*-*".$kginduk."*|*parent*-*".$rows['KG_PARENT']."*|*pagu*-*".$rows['KG_PAGU'];
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
		 if ($rows['KG_TYPE']==2)
			 $tree[$cnt][2]= "javascript:document.getElementById('input').style.display='block';document.getElementById('listma').style.display='none';fSetValue(window,'".$arfvalue."');SetChk('$arfchk')";
 		 else
		 	 $tree[$cnt][2] = null;

		 $tree[$cnt][3]= "";
		 $tree[$cnt][4]= 0;
		 $tree[$cnt][5]=($rows['KG_TYPE']==1)?0:($rows['KG_ISLAST']==1?$rows['KG_ID']:0);
		 $tree[$cnt][6]=1;
		 $tree[$cnt][7]="act*-*delete*|*idkg*-*".$rows['KG_ID']."*|*parent*-*".$rows['KG_PARENT'];
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
<script>
function SetChk(p){
var q=p.split(',');
	for (var i=0;i<q.length;i++){
		if (q[i]==1) document.forms[0].chkjd[i].checked=true; else document.forms[0].chkjd[i].checked=false;
	}
}
</script>
</html>
<?php 
mysql_close($konek);
?>