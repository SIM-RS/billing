<?php 
session_start();
include("../koneksi/konek.php");
//$PATH_INFO="?".$_SERVER['QUERY_STRING'];
$PATH_INFO="?f=../master/tree_ms_ma_sak";
$_SESSION["PATH_INFO"]=$PATH_INFO;
$qstr_ma="par=kode_ma2*mainduk";
$qstr_ma_sak="par=parent*kode_ma_sak*mainduk2*parent_lvl";
//$idhapus="idma";
$_SESSION["PATH_MS_MA"]="?".$qstr_ma;
//echo $_SERVER['HTTP_USER_AGENT'];
$idma=$_REQUEST['idma'];
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
$fk_ma=$_REQUEST['kode_ma2'];
if ($fk_ma=="") $fk_ma=0;
$ccrvpbfumum=$_REQUEST['ccrvpbfumum'];
$aktif=$_REQUEST['aktif'];
if ($aktif=="") $aktif=1;
$kode_ma2=trim($_REQUEST['kode_ma_sak']);
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
//echo "kode_ma2=".$kode_ma2." - parent=".$parent;
$lvl=$parent_lvl+1;
$act=$_REQUEST['act'];
//echo $act;
switch ($act){
	case "save":
			$sql="select * from ma_sak where MA_KODE='$kode_ma' and MA_TYPE=$type and MA_JENIS=$jenis and MA_UNIT=$fkunit and MA_AKTIF=$aktif";
	//	echo $sql."<br>";
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "<script>alert('Kode Rekening Sudah Ada');</script>";
		}else{
			$sql="insert into ma_sak(MA_KODE,MA_NAMA,MA_LEVEL,MA_PARENT,MA_PARENT_KODE,MA_JENIS,MA_TYPE,MA_UNIT,MA_AKTIF,FK_MA,CC_RV_KSO_PBF_UMUM) values('$kode_ma','$ma',$lvl,$parent,'$kode_ma2',$jenis,$type,$fkunit,$aktif,$fk_ma,$ccrvpbfumum)";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
			if ($parent>0){
				$sql="update ma_sak set MA_ISLAST=0 where MA_ID=$parent";
				//echo $sql;
				$rs=mysql_query($sql);
			}
		}
		mysql_free_result($rs1);
		break;
	case "edit":
		$sql="select * from ma_sak where MA_KODE='$kode_ma' and MA_TYPE=$type and MA_JENIS=$jenis and MA_NAMA='$ma' and MA_UNIT=$fkunit and  CC_RV_KSO_PBF_UMUM='$ccrvpbfumum' and MA_AKTIF=$aktif";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "<script>alert('Rekening Tersebut Sudah Ada');</script>";
		}else{
			$sql="select * from ma_sak where MA_ID=$idma";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
			if ($rows=mysql_fetch_array($rs)){
				$cparent=$rows["MA_PARENT"];
				$clvl=$rows["MA_LEVEL"];
				$cmkode=$rows["MA_KODE"];
				$cislast=$rows["MA_ISLAST"];
			}
			//echo "cparent=".$cparent.",clvl=".$clvl.",cmkode=".$cmkode.",cislast=".$cislast."<br>";
			$ccrv="";
			if ($cislast==1) $ccrv=", CC_RV_KSO_PBF_UMUM=$ccrvpbfumum";
			if ($cparent!=$parent){
				$cur_lvl=$lvl-$clvl;
				if ($cur_lvl>=0) $cur_lvl="+".$cur_lvl;
				$sql="update ma_sak set MA_ISLAST=0,CC_RV_KSO_PBF_UMUM=0 where MA_ID=".$parent;
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				$sql="update ma_sak set MA_KODE='$kode_ma',MA_NAMA='$ma',MA_LEVEL=$lvl,MA_PARENT=$parent,MA_PARENT_KODE='$kode_ma2',MA_JENIS=$jenis,MA_TYPE=$type,MA_UNIT=$fkunit,MA_AKTIF=$aktif, FK_MA=$fk_ma".$ccrv." where MA_ID=$idma";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				if ($cislast==0){
					$sql="update ma_sak set ma_kode=CONCAT('$kode_ma',right(ma_kode,length(ma_kode)-length('$cmkode'))),ma_parent_kode=CONCAT('$kode_ma',right(ma_parent_kode,length(ma_parent_kode)-length('$cmkode'))),ma_level=ma_level".$cur_lvl." where left(ma_kode,length('$cmkode'))='$cmkode'";
					//echo $sql."<br>";
					$rs=mysql_query($sql);
				}
				$sql="select * from ma_sak where MA_PARENT=$cparent";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				if (mysql_num_rows($rs)<=0){
					$sql="update ma_sak set MA_ISLAST=1 where MA_ID=".$cparent;
					//echo $sql."<br>";
					$rs1=mysql_query($sql);
				}
			}else{
				$sql="update ma_sak set MA_KODE='$kode_ma',MA_NAMA='$ma',MA_JENIS=$jenis,MA_TYPE=$type,MA_UNIT=$fkunit,MA_AKTIF=$aktif, FK_MA=$fk_ma".$ccrv." where MA_ID=$idma";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				if (($kode_ma!=$cmkode) && ($cislast==0)){
					$sql="update ma_sak set ma_kode=CONCAT('$kode_ma',right(ma_kode,length(ma_kode)-length('$cmkode'))),ma_parent_kode=CONCAT('$kode_ma',right(ma_parent_kode,length(ma_parent_kode)-length('$cmkode'))) where left(ma_kode,length('$cmkode'))='$cmkode'";
					//echo $sql."<br>";
					$rs=mysql_query($sql);
				}
			}
		}
		break;
	case "delete":
		$sql="select * from ma_sak where ma_parent=$idma";
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "<script>alert('Kode Rekening Ini Mempunyai Child, Jadi Tidak Boleh Dihapus');</script>";
		}else{
			$sql="select * from jurnal where fk_sak=$idma";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
			if (mysql_num_rows($rs)>0){
				echo "<script>alert('Kode Rekening Ini Sudah Pernah Digunakan Untuk Transaksi Jurnal, Jadi Tidak Boleh Dihapus');</script>";
			}else{
				$sql="delete from ma_sak where MA_ID=$idma";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				$sql1="select * from ma_sak where MA_PARENT=".$parent;
				//echo $sql1."<br>";
				$rs2=mysql_query($sql1);
				if (mysql_num_rows($rs2)<=0){
					$sql2="update ma_sak set MA_ISLAST=1,CC_RV_KSO_PBF_UMUM=$ccrvpbfumum where MA_ID=".$parent;
					//echo $sql2."<br>";
					$rs3=mysql_query($sql2);
				}
			}
		}
		mysql_free_result($rs1);
		break;
}
?>
<html>
<head>
<title>Master Data Rekening SAK</title>
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
  <div id="input" style="display:none">
      <p class="jdltable">Input Data Rekening SAK</p>
      <table width="75%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
        <tr>
          <td>Kode ID Master Rekening SAP</td>
          <td>:</td>
          <td valign="middle"><input name="kode_ma2" type="text" id="kode_ma2" size="20" maxlength="20" style="text-align:center" value="" readonly="true" class="txtcenter"> 
            <input type="button" class="txtcenter" name="Button222" value="..." title="Pilih Rekening Induk" onClick="OpenWnd('../master/tree_ma_view2.php?<?php echo $qstr_ma; ?>',800,500,'msma',true)"> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="button" name="Button" class="txtcenter" value="Reset" onClick="fSetValue(window,'act*-*save*|*kode_ma2*-**|*mainduk*-**|*kode_ma*-**|*ma*-**|*parent*-**')"></td>
        </tr>
        <tr> 
          <td>Nama Master Rekening SAP</td>
          <td>: </td>
          <td ><textarea name="mainduk" cols="50" rows="3" readonly class="txtinput" id="mainduk"><? echo $_POST[mainduk];?></textarea></td>
        </tr>

        <tr>
          <td>Kode Rekening Induk</td>
          <td>:</td>
          <td valign="middle"><input name="kode_ma_sak" type="text" id="kode_ma_sak" size="20" maxlength="20" style="text-align:center" value="<?=$kode_ma2; ?>" readonly="true" class="txtcenter"> 
            <input type="button" class="txtcenter" name="Button222" value="..." title="Pilih Rekening Induk" onClick="OpenWnd('../master/tree_ma_view_sak.php?<?php echo $qstr_ma_sak; ?>',800,500,'msma',true)"> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="button" name="Button" class="txtcenter" value="Reset" onClick="fSetValue(window,'act*-*save*|*kode_ma_sak*-**|*mainduk2*-**|*kode_ma*-**|*ma*-**|*parent*-**')"></td>
        </tr>
        <tr> 
          <td>Nama Rekening Induk</td>
          <td>: </td>
          <td ><textarea name="mainduk2" cols="50" rows="3" readonly class="txtinput" id="mainduk2"><? echo $_POST[mainduk2];?></textarea></td>
        </tr>
        <tr> 
          <td>Kode Rekening</td>
          <td>:</td>
          <td><input name="kode_ma" type="text" id="kode_ma" size="5" maxlength="6" class="txtinput" style="text-align:center"></td>
        </tr>
        <tr> 
          <td>Nama Rekening</td>
          <td>:</td>
          <td ><textarea name="ma" cols="50" rows="3" class="txtinput" id="ma"></textarea></td>
        </tr>
        <tr id="trCCRV" style="visibility:visible">
          <td>Tipe Kode Rekening</td>
          <td>:</td>
          <td><select name="ccrvpbfumum" id="ccrvpbfumum" class="txtinput">
              <option value="0">-</option>
              <option value="1">Cost/Revenue Center</option>
              <option value="2">KSO</option>
              <option value="3">PBF</option>
              <option value="4">Suplier Umum</option>
          </select></td>
        </tr>
        <tr>
          <td>Status</td>
          <td>:</td>
          <td>
		  	<select name="aktif" id="aktif" class="txtinput">
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
		  <td colspan="3" class="jdltable">DAFTAR REKENING SAK </td>
	    </tr>
		
		<tr>
			<td width="98">&nbsp;</td>
			<td width="370" align="center" class="jdltable">&nbsp;</td>
			<td align="right"><BUTTON type="button" onClick="location='?f=../master/ms_ma_sak.php'"><IMG SRC="../icon/view_list.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tabel View</BUTTON> 
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

  $canRead = true;
  $include_del = 1;
  $maxlevel=0;
  $cnt=0;
  $strSQL = "select * from ma_sak order by ma_kode";
  $rs = mysql_query($strSQL);
  while ($rows=mysql_fetch_array($rs)){
		 $c_level = $rows["MA_LEVEL"];
		 $c_islast = $rows["MA_ISLAST"];
		 $pkode=trim($rows['MA_PARENT_KODE']);
		 $mkode=trim($rows['MA_KODE']);
		 if ($pkode!=""){
		 //	if (substr($mkode,0,strlen($pkode))==$pkode) 
				$mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
			//else
			//	$mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
		 }
		 $sql="select * from ma_sak where ma_id=".$rows['MA_PARENT'];
		 $rs1=mysql_query($sql);
		 if ($rows1=mysql_fetch_array($rs1)) $c_mainduk=$rows1["MA_NAMA"]; else $c_mainduk="";
		 $tree[$cnt][0]= $c_level;
		 $tree[$cnt][1]= $rows["MA_KODE"]." - ".($mpkode==""?"":$mpkode." - ").$rows["MA_NAMA"];
		 
		 $cCCRV="*|*ccrvpbfumum*-*0";
		 if ($c_islast==1) $cCCRV="*|*ccrvpbfumum*-*".$rows['CC_RV_KSO_PBF_UMUM'];
		 $arfvalue="act*-*edit*|*kode_ma_sak*-*".$pkode."*|*idma*-*".$rows['MA_ID']."*|*kode_ma*-*".$mkode."*|*ma*-*".$rows['MA_NAMA']."*|*parent_lvl*-*".($rows['MA_LEVEL']-1)."*|*parent*-*".$rows['MA_PARENT']."*|*mainduk2*-*".$c_mainduk."*|*aktif*-*".$rows['MA_AKTIF']."*|*kode_ma2*-*".$rows['FK_MA'].$cCCRV;
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
		 if ($c_level>0)
		 	if ($c_islast==0){
			 	//$tree[$cnt][2]= "javascript:document.getElementById('input').style.display='block';document.getElementById('listma').style.display='none';document.getElementById('trCCRV').style.visibility='visible';fSetValue(window,'".$arfvalue."');";
				$tree[$cnt][2]= "javascript:document.getElementById('input').style.display='block';document.getElementById('listma').style.display='none';fSetValue(window,'".$arfvalue."');";
			}else{
			 	//$tree[$cnt][2]= "javascript:document.getElementById('input').style.display='block';document.getElementById('listma').style.display='none';document.getElementById('trCCRV').style.visibility='collapse';fSetValue(window,'".$arfvalue."');";
				$tree[$cnt][2]= "javascript:document.getElementById('input').style.display='block';document.getElementById('listma').style.display='none';fSetValue(window,'".$arfvalue."');";
			}
 		 else
		 	 $tree[$cnt][2] = null;

		 $tree[$cnt][3]= "";
		 $tree[$cnt][4]= 0;
		 $tree[$cnt][5]=($rows['MA_ISLAST']==1)?$rows['MA_ID']:0;
		 //$tree[$cnt][5]="act*-*delete*|*idma*-*".$rows['MA_ID']."*|*parent*-*".$rows['MA_PARENT'];
		 $tree[$cnt][6]=$rows['MA_AKTIF'];
		 $tree[$cnt][7]="act*-*delete*|*idma*-*".$rows['MA_ID']."*|*kode_ma_sak*-*".$rows['MA_PARENT_KODE']."*|*parent*-*".$rows['MA_PARENT']."*|*ccrvpbfumum*-*".$rows['CC_RV_KSO_PBF_UMUM'];
		 if ($tree[$cnt][0] > $maxlevel)
			$maxlevel=$tree[$cnt][0];
		 $cnt++;
	}
	mysql_free_result($rs);
include("../master/treemenu.inc.php");

?>
</td></tr>
</table>
    </p><br>
    <BUTTON type="button" onClick="BukaWndExcell();"><IMG SRC="../icon/addcommentButton.jpg" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Export ke File Excell</BUTTON>
	</div>
</form>
</div>
</body>
<script language="javascript">
function BukaWndExcell(){
	//alert('../apotik/buku_penjualan_excell.php?tgl_d='+tgld+'&tgl_s='+tgls+'&idunit1='+idunit1+'&jns_pasien='+jpasien);
	OpenWnd('../master/ma_sak_excell.php?tipe=1',600,450,'childwnd',true);
}
</script>
</html>
<?php 
mysql_close($konek);
?>