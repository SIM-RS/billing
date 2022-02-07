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

$txtidDPA=$_REQUEST['txtidDPA'];

$lvl=$parent_lvl+1;
$act=$_REQUEST['act'];
//echo $act;
//echo $act;
switch ($act){
	case "save":
		$sql="select * from jenis_transaksi where JTRANS_KODE='$kode_ma' and JTRANS_AKTIF=$aktif";
		//echo $sql;
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "<script>alert('Jenis Transaksi Sudah Ada');</script>";
		}else{
			$sql="insert into jenis_transaksi(JTRANS_KODE,JTRANS_NAMA,JTRANS_LEVEL,JTRANS_PARENT,JTRANS_PARENT_KODE,JTRANS_AKTIF,TIPE) values('$kode_ma','$ma',$lvl,$parent,'$kode_ma2',$aktif,$tipe)";
			//echo $sql;
			$rs=mysql_query($sql);
			if ($parent>0){
				$sql="update jenis_transaksi set JTRANS_ISLAST=0 where JTRANS_ID=$parent";
				//echo $sql;
				$rs=mysql_query($sql);
			}
		}
		mysql_free_result($rs1);
		break;
	case "edit":
		$sql="select * from jenis_transaksi where JTRANS_KODE='$kode_ma' and JTRANS_AKTIF=$aktif";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			$rw1=mysql_fetch_array($rs1);
			//echo $rw1["JTRANS_ID"]." - ".$idma."<br>";
			if ($rw1["JTRANS_ID"]==$idma){
				$sql="update jenis_transaksi set JTRANS_KODE='$kode_ma',JTRANS_NAMA='$ma',JTRANS_LEVEL=$lvl,JTRANS_PARENT=$parent,JTRANS_PARENT_KODE='$kode_ma2',JTRANS_AKTIF=$aktif,TIPE='$tipe' where JTRANS_ID=$idma";
				$rs=mysql_query($sql);
				$sql="update jenis_transaksi set JTRANS_ISLAST=0 where JTRANS_ID='$parent' ";
				$rs=mysql_query($sql);
			}else{
				echo "<script>alert('Jenis Transaksi dg Kode $kode_ma Sudah Ada');</script>";
			}
		}else{
			$sql="select * from jenis_transaksi where JTRANS_ID=$idma";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
			if ($rows=mysql_fetch_array($rs)){
				$cparent=$rows["JTRANS_PARENT"];
				$clvl=$rows["JTRANS_LEVEL"];
				$cmkode=$rows["JTRANS_KODE"];
				$cislast=$rows["JTRANS_ISLAST"];
			}
			//echo "cparent=".$cparent.",clvl=".$clvl.",cmkode=".$cmkode.",cislast=".$cislast."<br>";
			if ($cparent!=$parent){
				$cur_lvl=$lvl-$clvl;
				if ($cur_lvl>=0) $cur_lvl="+".$cur_lvl;
				if ($cislast==0){
					$sql="update jenis_transaksi set JTRANS_KODE=CONCAT('$kode_ma',right(JTRANS_KODE,length(JTRANS_KODE)-length('$cmkode'))),JTRANS_PARENT_KODE=CONCAT('$kode_ma',right(JTRANS_PARENT_KODE,length(JTRANS_PARENT_KODE)-length('$cmkode'))),JTRANS_LEVEL=JTRANS_LEVEL".$cur_lvl." where left(JTRANS_KODE,length('$cmkode'))='$cmkode'";
					//echo $sql."<br>";
					$rs=mysql_query($sql);
				}
				$sql="select * from jenis_transaksi where JTRANS_PARENT=$cparent";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				if (mysql_num_rows($rs)<=0){
					$sql="update jenis_transaksi set JTRANS_ISLAST=1 where JTRANS_ID=".$cparent;
					//echo $sql."<br>";
					$rs1=mysql_query($sql);
				}
			}
			
			$sql="update jenis_transaksi set JTRANS_KODE='$kode_ma',JTRANS_NAMA='$ma',JTRANS_LEVEL=$lvl,JTRANS_PARENT=$parent,JTRANS_PARENT_KODE='$kode_ma2',JTRANS_AKTIF=$aktif,TIPE='$tipe' where JTRANS_ID=$idma";
			$rs=mysql_query($sql);
			$sql="update jenis_transaksi set JTRANS_ISLAST=0 where JTRANS_ID='$parent' ";
			$rs=mysql_query($sql);
		}
		break;
	case "delete":
		$sql="select * from jenis_transaksi where JTRANS_PARENT=$idma";
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "<script>alert('Jenis Transaksi Ini Mempunyai Child, Jadi Tidak Boleh Dihapus');</script>";
		}else{
				$sql="delete from jenis_transaksi where JTRANS_ID=$idma";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				$sql="select * from jenis_transaksi where JTRANS_PARENT=".$parent;
				//echo $sql."<br>";
				$rs2=mysql_query($sql);
				if (mysql_num_rows($rs2)<=0){
					$sql="update jenis_transaksi set JTRANS_ISLAST=1 where JTRANS_ID=".$parent;
					//echo $sql."<br>";
					$rs2=mysql_query($sql);

			}
		}
		mysql_free_result($rs1);
		break;
}
?>
<html>
<head>
<title>INPUT JENIS TRANSAKSI</title>
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
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
  <div id="input" style="display:none">
      <p class="jdltable">Input Jenis Transaksi</p>
    <table width="75%" border="0" cellpadding="0" cellspacing="0" class="txtinput">
      <tr>
          <td>Kode Jenis Transaksi Induk</td>
      <td>:</td>
          <td><input name="kode_ma2" type="text" id="kode_ma2" size="20" maxlength="20" style="text-align:center" value="<?php echo $kode_ma2; ?>" readonly="true" class="txtinput"> 
            <input type="button" name="Button222" value="..." class="txtcenter" title="Pilih Rekening Induk" onClick="OpenWnd('../master/tree_jtrans_view.php?<?php echo $qstr_ma; ?>',800,500,'msma',true)">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" name="Button" value="Reset" class="txtcenter" onClick="fSetValue(window,'act*-*save*|*kode_ma2*-**|*mainduk*-**|*kode_ma*-**|*ma*-*')"></td>
    </tr>
    <tr>
      <td>Jenis Transaksi Induk</td>
      <td>:</td>
          <td ><textarea name="mainduk" cols="50" id="mainduk" class="txtinput" readonly><?=$_POST[mainduk];?></textarea></td>
    </tr>
      <tr>
          <td>Kode Jenis Transaksi</td>
      <td>:</td>
          <td><input name="kode_ma" type="text" id="kode_ma" size="6" maxlength="6" style="text-align:center"></td>
    </tr>
    <tr>
      <td>Nama Jenis Transaksi</td>
      <td>:</td>
          <td ><textarea name="ma" cols="50" id="ma" class="txtinput"></textarea></td>
    </tr>
      <!--tr>
          <td>Kode DPA</td>
      <td>:</td>
          <td><input name="txtidDPA" id="txtidDPA" type="hidden" value="0"><input name="kode_dpa" type="text" id="kode_dpa" size="20" style="text-align:center" value="" readonly="true" class="txtinput">
            <input type="button" name="Buttondpa" value="..." class="txtcenter" title="Pilih Rekening DPA" onClick="OpenWnd('../master/tree_mata_anggaran.php?id=0&par=txtidDPA*kode_dpa',800,500,'msma',true)">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" name="Button" value="Reset" class="txtcenter" onClick="fSetValue(window,'txtidDPA*-*0*|*kode_dpa*-*')"></td>
    </tr-->
    <tr>
      <td>Tipe Jurnal</td>
      <td>:</td>
          <td ><select name="tipe" id="tipe">
		  		<? $qry=mysql_query("select * from m_tipe_jurnal order by id_tipe");
					while($hs=mysql_fetch_array($qry)){?>
				<option value="<?=$hs[id_tipe]?>"><?=$hs[nama_tipe]?></option><? }?></select></td>
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
		  <td colspan="3" class="jdltable">DAFTAR MASTER TRANSAKSI</td>
	    </tr>
		
		<tr>
			<td width="98">&nbsp;</td>
			<td width="370" align="center" class="jdltable">&nbsp;</td>
			<td align="right"><BUTTON type="button" onClick="location='?f=../master/ms_trans_khusus.php'"><IMG SRC="../icon/view_list.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tabel View</BUTTON> 
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
  $strSQL = "select * from jenis_transaksi where jtrans_aktif=1 order by jtrans_kode";
  $rs = mysql_query($strSQL);
  while ($rows=mysql_fetch_array($rs)){
		 $c_level = $rows["JTRANS_LEVEL"];
		 $pkode=trim($rows['JTRANS_PARENT_KODE']);
		 $mkode=trim($rows['JTRANS_KODE']);

		 if ($pkode!=""){
		 //	if (substr($mkode,0,strlen($pkode))==$pkode) 
				$mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
			//else
			//	$mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
		 }
		 $sql="SELECT * FROM m_tipe_jurnal WHERE id_tipe=".$rows['TIPE'];
		 $rs1=mysql_query($sql);
		 $rows1=mysql_fetch_array($rs1);
		 //$tipe=array("Normal","Kas Out","Bank Out");
		 $tipe=$rows1["nama_tipe"];
		 
		 /*$sql="SELECT * FROM $dbanggaran.ms_ma msak WHERE msak.ma_id='".$rows['ID_DPA']."'";
		 $rs1=mysql_query($sql);
		 $rows1=mysql_fetch_array($rs1);
		 $kdDPA=$rows1["ma_kode"];*/
		 
		 $sql="select * from jenis_transaksi where JTRANS_ID=".$rows['JTRANS_PARENT'];
		 $rs1=mysql_query($sql);
		 if ($rows1=mysql_fetch_array($rs1)) $c_mainduk=$rows1["JTRANS_NAMA"]; else $c_mainduk="";
		 $tree[$cnt][0]= $c_level;
		 
		 $tree[$cnt][1]= $rows["JTRANS_KODE"]." - ".($mpkode==""?"":$mpkode." - ").$rows["JTRANS_NAMA"]." - Tipe: ".$tipe;
		 //$tree[$cnt][1]= $rows["JTRANS_KODE"]." - ".($mpkode==""?"":$mpkode." - ").$rows["JTRANS_NAMA"]." - Tipe: ".$tipe[$rows["TIPE"]];
		 $arfvalue="act*-*edit*|*kode_ma2*-*".$pkode."*|*idma*-*".$rows['JTRANS_ID']."*|*kode_ma*-*".$mkode."*|*ma*-*".$rows['JTRANS_NAMA']."*|*parent_lvl*-*".($rows['JTRANS_LEVEL']-1)."*|*parent*-*".$rows['JTRANS_PARENT']."*|*mainduk*-*".$c_mainduk."*|*tipe*-*".$rows['TIPE']."*|*txtidDPA*-*".$rows['ID_DPA']."*|*aktif*-*".$rows['JTRANS_AKTIF'];
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
		 if ($c_level>0)
			 $tree[$cnt][2]= "javascript:document.getElementById('input').style.display='block';document.getElementById('listma').style.display='none';fSetValue(window,'".$arfvalue."');";
 		 else
		 	 $tree[$cnt][2] = null;

		 $tree[$cnt][3]= "";
		 $tree[$cnt][4]= 0;
		 $tree[$cnt][5]=($rows['JTRANS_ISLAST']==1)?$rows['JTRANS_ID']:0;
		 //$tree[$cnt][5]="act*-*delete*|*idma*-*".$rows['MA_ID']."*|*parent*-*".$rows['MA_PARENT'];
		 $tree[$cnt][6]=$rows['JTRANS_AKTIF'];
		 $tree[$cnt][7]="act*-*delete*|*idma*-*".$rows['JTRANS_ID']."*|*parent*-*".$rows['JTRANS_PARENT'];
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
	OpenWnd('../master/ms_jurnal_excell.php',600,450,'childwnd',true);
}
</script>
</html>
<?php 
mysql_close($konek);
?>