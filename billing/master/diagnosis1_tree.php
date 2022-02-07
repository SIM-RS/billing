<?
include("../sesi.php");
?>
<?php
//session_start();
include("../koneksi/konek.php");
//$PATH_INFO="?".$_SERVER['QUERY_STRING'];

$perpage=$_REQUEST['perpage'];
   if ($perpage=="" || $perpage=="0")  $perpage=100;
$page=$_REQUEST['page'];
   if ($page=="" || $page=="0") $page=1;

$PATH_INFO="?page=$page&perpage=$perpage";
$_SESSION["PATH_INFO"]=$PATH_INFO;

$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<title>Diagnosis</title>
</head>

<body>
<div align="center">
<?php
	include("../header1.php");
?>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/dsgrid_sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;FORM DIAGNOSIS ICD</td>
	</tr>
</table>

<table width="1000" border="0" cellspacing="1" cellpadding="0" class="tabel" align="center">
   <form name="form1" method="post" action="" target="_SELF">
  <input name="act" id="act" type="hidden" value="tambah">
  <tr><td colspan="5">&nbsp;</td></tr>
   <tr>
  	<td>&nbsp;</td>
	<td align="right">Kode Induk</td>	<td>
      <input id="txtParentKode"  name="txtParentKode" type="text" size="20" maxlength="20" style="text-align:center" value="<?php echo $ParentKode; ?>" readonly="true" class="txtcenter"> 
      <input type="button" class="txtcenter" id="btnParent" name="btnParent" value="..." title="Pilih Induk" onClick="OpenWnd('diagnosis1_tree_view.php?<?php echo $qstr_ma_sak; ?>',800,500,'msma',true)">             
	Level
	<input id="txtLevel" name="txtLevel" size="5" class="txtinput"/>
	<input type="hidden" id="txtParentId" name="txtParentId" size="5" />
	<input type="hidden" id="txtParentLvl" name="txtParentLvl" size="6" />
      
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td align="right">Kode Diagnosis ICD</td>
	<input id="txtId" type="hidden" name="txtId" class="txtinput"/>
    <td><input size="24" id="txtKode" name="txtKode" class="txtinput"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td align="right">Diagnosis ICD&nbsp;</td>
    <td><input size="60" id="txtDiag" name="txtDiag" class="txtinput"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td align="right">Surveilance&nbsp;</td>
	<td>&nbsp;<select id="cmbSur" name="cmbSur" class="txtinput">
		<option value="0">Tidak</option>
		<option value="1">Ya</option>
	</select>&nbsp;&nbsp;Status :
      <label><input type="checkbox" id="isAktif" name="isAktif" class="txtinput" checked="checked" value="1" onclick="if(this.checked==true){this.value=1;} else{this.value=0;}"/>Aktif</label>
      </td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td align="right"></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>
		<input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="simpan(this.value);" class="tblTambah"/>
		<!--input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus"/-->
		<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/>
	</td>
	<td><button type="button" id="btnTable" name="btnTable" value="Tampilan Tabel" onclick="window.location='diagnosis1.php'" class="tblViewTable">Tampilan Tabel</button></td>
	<td>&nbsp;</td>
  </tr>
  </form>
  <tr>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">
   <div style="overflow:auto; height:220px;">
   <table border=1 cellspacing=0 width=100%>
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
	  $strSQL = "select * from b_ms_diagnosa order by kode";
	  $rs = mysql_query($strSQL);

        //bikin halaman        
        $sql=$strSQL;
        
        $jmldata=mysql_num_rows($rs);
         
         $tpage=($page-1)*$perpage;
         if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
         if ($page>1) $bpage=$page-1; else $bpage=1;
         if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
         $sql=$sql." limit $tpage,$perpage";
         //end of bikin halaman
         
         //echo $sql."<br/>";
         $rs=mysql_query($sql);
        
	  while ($rows=mysql_fetch_array($rs)){
			 $c_level = $rows["level"];
			 $pkode=trim($rows['parent_kode']);
			 $mkode=trim($rows['kode']);
			 
			 
			 $chkAktif=($rows['aktif']==1)?'true':'false';
			 if ($pkode!=""){
			 //	if (substr($mkode,0,strlen($pkode))==$pkode) 
					$mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode))); //+1 karena ada titik di kode
				//else
				//	$mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
			 }
			 $sql="select * from b_ms_diagnosa where id=".$rows['parent_id'];
			 $rs1=mysql_query($sql);
			 if ($rows1=mysql_fetch_array($rs1)) $c_mainduk=$rows1["nama"]; else $c_mainduk="";
			 $tree[$cnt][0]= $c_level;
			 $tree[$cnt][1]= $rows["kode"]." - ".($mpkode==""?"":$mpkode." - ").$rows["nama"];			
			 $arfvalue="txtId*-*".$rows['id']."*|*txtKode*-*".$mkode."*|*txtDiag*-*".$rows['nama']."*|*txtParentLvl*-*".($rows['level']-1)."*|*txtLevel*-*".$rows['level']."*|*txtParentId*-*".$rows['parent_id']."*|*txtParentKode*-*".$rows['parent_kode']."*|*cmbSur*-*".$rows['surveilance']."*|*isAktif*-*".$chkAktif."*|*btnSimpan*-*Simpan";
			 $arfvalue=str_replace('"',chr(3),$arfvalue);
			 $arfvalue=str_replace("'",chr(5),$arfvalue);
			 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
			 if ($c_level>0)
				 $tree[$cnt][2]= "javascript:fSetValue(window,'".$arfvalue."');";
			 else
				 $tree[$cnt][2] = null;
	
			 $tree[$cnt][3]= "";
			 $tree[$cnt][4]= 0;
			 $tree[$cnt][5]=($rows['islast']==1)?$rows['id']:0;
			 //$tree[$cnt][5]="act*-*delete*|*idma*-*".$rows['MA_ID']."*|*parent*-*".$rows['MA_PARENT'];
			 $tree[$cnt][6]=$rows['aktif'];
			 $tree[$cnt][7]="act*-*hapus*|*txtId*-*".$rows['id']."*|*txtParentKode*-*".$rows['parent_kode']."*|*txtParentId*-*".$rows['parent_id'];
			 if ($tree[$cnt][0] > $maxlevel) 
				$maxlevel=$tree[$cnt][0];    
			 $cnt++;
		}
		mysql_free_result($rs);
		
	$tree_img_path="../images";
	include("../theme/treemenu.inc.php");
	
      
	?>      
	</td>
      </tr>      
	</table>
   
   	</div>
   </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
   <td>&nbsp;</td>
         <td colspan=3 valign="middle" align="left">
            <form id="formPage" action="" method="post" target="_SELF">
            <input id="perpage" name="perpage" size="5" class="txtinput" onkeyup="if(event.which=='13'){ document.getElementById('formPage').submit(); }" value="<?php echo isset($_REQUEST['perpage'])?$_REQUEST['perpage']:$perpage;?>"/>
            baris pada            
            halaman ke :<input id="page" name="page" size="5" class="txtinput" onkeyup="if(event.which=='13'){ document.getElementById('formPage').submit(); }" value="<?php echo isset($_REQUEST['page'])?$_REQUEST['page']:$page;?>"/>
            dari&nbsp;
            <?php echo $totpage;?>&nbsp;
            Halaman
            &nbsp;
            <label style="margin-left:400px;">
            <img src="../icon/page_first.gif" border="0" width="30" height="30" style='cursor:pointer' title="Halaman Pertama" onclick="document.getElementById('page').value=1;document.getElementById('formPage').submit()"/>
            <img src="../icon/page_prev.gif" border="0" width="30" height="30" style='cursor:pointer' title="Halaman Sebelumnya" onclick="if (parseInt(document.getElementById('page').value) > 1){document.getElementById('page').value=(parseInt(document.getElementById('page').value)-1); document.getElementById('formPage').submit();}"/>
            <img src="../icon/page_next.gif" border="0" width="30" height="30" style='cursor:pointer' title="Halaman Selanjutnya" onclick="if (<?php echo $totpage;?> > parseInt(document.getElementById('page').value)){document.getElementById('page').value=(parseInt(document.getElementById('page').value)+1); document.getElementById('formPage').submit();}"/>
            <img src="../icon/page_last.gif" border="0" width="30" height="30" style='cursor:pointer' title="Halaman Sebelumnya" onclick="document.getElementById('page').value=<?php echo $totpage;?>; document.getElementById('formPage').submit();"/>
            </label>
            </form>
         </td>
         <td>&nbsp;</td>
      </tr>
  <tr>
    <td width="5%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="50%">&nbsp;</td>
    <td align="right" width="20%"></td>
    <td width="5%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>
  <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
  <tr height="30">
    <td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
		<td>&nbsp;</td>
		<td align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;" /></a>&nbsp;</td>
  </tr>
</table>
  
</div>
</body>
<?php

$surveilance=$_REQUEST['cmbSur'];
$cekAktif=($_REQUEST['isAktif']=='')?'0':$_REQUEST['isAktif'];


$ParentKode=trim($_REQUEST['txtParentKode']);
if($ParentKode==''){
	$parentId=0;
	$parentLevel=0;      
}
else{
	$parentId=$_REQUEST['txtParentId'];
	if($parentId=='') $parentId=0;
	$parentLevel=$_REQUEST['txtParentLvl'];
	if ($parentLevel=="") $parentLevel=0;      
	
}
$lvl=$_REQUEST['txtLevel'];

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
            if($lvl=='2'){
               $kode=$_REQUEST['txtParentKode'].".".$_REQUEST['txtKode'];
            }
            else{
               $kode=$_REQUEST['txtParentKode'].$_REQUEST['txtKode'];
            }
		mysql_query("select * from b_ms_diagnosa where kode='".$kode."'");
		if(mysql_affected_rows()>0){
			echo "<script>alert('Data Sudah Ada!');</script>";
		}
		else{
			$sqlTambah="insert into b_ms_diagnosa (kode,nama,level,parent_id,parent_kode,surveilance,islast,aktif)
				values('".$kode."','".$_REQUEST['txtDiag']."','".$_REQUEST['txtLevel']."','".$_REQUEST['txtParentId']."','".$_REQUEST['txtParentKode']."','".$_REQUEST['cmbSur']."',1,'".$cekAktif."')";
			$rs=mysql_query($sqlTambah);
                  //echo $sqlTambah."<br/>";
                  //echo mysql_error();
			if ($parentId>0){
				$sql="update b_ms_diagnosa set islast=0 where id=$parentId";
				//echo $sql;
				$rs=mysql_query($sql);
			}
			echo "<script>window.location='diagnosis1_tree.php'</script>";
		}
		break;
	case 'hapus':
		mysql_query("select * from b_ms_diagnosa where parent_id='".$_REQUEST['txtId']."'");
		if(mysql_affected_rows()>0){
			echo "<script>alert('Data merupakan induk! ".$_REQUEST['txtId']."');</script>";
		}
		else{
			$sql="delete from b_ms_diagnosa where id='".$_REQUEST['txtId']."'";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
			$sql1="select * from b_ms_diagnosa where parent_id=".$parentId;
			//echo $sql1."<br>";
			$rs2=mysql_query($sql1);
			if (mysql_num_rows($rs2)<=0){
				$sql2="update b_ms_diagnosa set islast=1 where id=".$parentId;
				//echo $sql2."<br>";
				$rs3=mysql_query($sql2);
			}
			echo "<script>window.location='diagnosis1_tree.php'</script>";
		}		
		break;
	case 'simpan':
            if($lvl=='2'){
               $kode=$_REQUEST['txtParentKode'].".".$_REQUEST['txtKode'];
            }
            else{
               $kode=$_REQUEST['txtParentKode'].$_REQUEST['txtKode'];
            }
		$sql="select * from b_ms_diagnosa where kode='$kode' and nama='".$_REQUEST['txtDiag']."' and level=$lvl and parent_id=$parentId and parent_kode='$ParentKode' and surveilance='".$surveilance."' and aktif='".$cekAktif."'";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "<script>alert('Data Tersebut Sudah Ada');</script>";
		}else{
			$sql="select * from b_ms_diagnosa where id='".$_REQUEST['txtId']."'";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
			if ($rows=mysql_fetch_array($rs)){				
				
				$cparent=$rows["parent_id"];
				$clvl=($rows["level"]-1);
				$cmkode=$rows["kode"];
				$cislast=$rows["islast"];				
			}
			//echo "cparent=".$cparent.",clvl=".$clvl.",cmkode=".$cmkode.",cislast=".$cislast."<br>";
			if ($cparent!=$parentId){
				$cur_lvl=$lvl-$clvl;
				if ($cur_lvl>0) $cur_lvl="+".$cur_lvl;
				$sql="update b_ms_diagnosa set islast=0 where id=".$parentId;
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				$sql="update b_ms_diagnosa set kode='$kode',nama='".$_REQUEST['txtDiag']."',level=$lvl,parent_id=$parentId,parent_kode='$ParentKode',surveilance='".$surveilance."',aktif='".$cekAktif."' where id='".$_REQUEST['txtId']."'";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				if ($cislast==0){
					$sql="update b_ms_diagnosa set kode=CONCAT('$kode',right(kode,length(kode)-length('$cmkode'))),parent_kode=CONCAT('$kode',right(parent_kode,length(parent_kode)-length('$cmkode'))),level=".$cur_lvl." where left(kode,length('$cmkode'))='$cmkode'";
					//echo $sql."<br>";
					$rs=mysql_query($sql);
				}
				$sql="select * from b_ms_diagnosa where parent_id=$cparent";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				if (mysql_num_rows($rs)<=0){
					$sql="update b_ms_diagnosa set islast=1 where id=".$cparent;
					//echo $sql."<br>";
					$rs1=mysql_query($sql);
				}				
			}else{	
				$sql="update b_ms_diagnosa set kode='$kode',nama='".$_REQUEST['txtDiag']."',level=$lvl,parent_id=$parentId,parent_kode='$ParentKode',surveilance='".$surveilance."',aktif='".$cekAktif."' where id='".$_REQUEST['txtId']."'";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				if (($kode_ma!=$cmkode) && ($cislast==0)){
					$sql="update b_ms_diagnosa set kode=CONCAT('$kode',right(kode,length(kode)-length('$cmkode'))),parent_kode=CONCAT('$kode',right(parent_kode,length(parent_kode)-length('$cmkode'))) where left(kode,length('$cmkode'))='$cmkode'";
					//echo $sql."<br>";
					$rs=mysql_query($sql);
				}
			}
			echo "<script>window.location='diagnosis1_tree.php'</script>";
		}
		break;
}
?>
<script>

	function simpan(action)
	{
		if(action=="Tambah")
		fSetValue(window,'act*-*tambah');
		else if(action=="Simpan")
		fSetValue(window,'act*-*simpan');
            if(ValidateForm('txtKode,txtDiag,txtLevel,txtParentId,txtParentKode,cmbSur,isAktif','ind')){
			document.form1.submit();
		}
	}
	
	function ambilData()
	{
		var p="txtId*-*"+(a.getRowId(a.getSelRow()))+"*|*txtKode*-*"+a.cellsGetValue(a.getSelRow(),2)+"*|*txtDiag*-*"+a.cellsGetValue(a.getSelRow(),3)+"*|*txtLevel*-*"+a.cellsGetValue(a.getSelRow(),4)+"*|*txtParentLvl*-**|*txtParentId*-*"+a.cellsGetValue(a.getSelRow(),5)+"*|*txtParentKode*-*"+a.cellsGetValue(a.getSelRow(),6)+"*|*cmbSur*-*"+a.cellsGetValue(a.getSelRow(),7)+"*|*isAktif*-*"+((a.cellsGetValue(a.getSelRow(),9)=='Aktif')?'true':'false')+"*|*btnSimpan*-*Simpan*|*btnHapus*-*false";
		fSetValue(window,p);
	}
	
	function hapus()
	{
		var rowid = document.getElementById("txtId").value;
		//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
		if(confirm("Anda yakin menghapus Diagnosis "+a.cellsGetValue(a.getSelRow(),3)))
		{
			a.loadURL("diag_utils.php?grd=true&act=hapus&rowid="+rowid,"","GET");
		}
		
		document.getElementById("txtKode").value = '';
		document.getElementById("txtDiag").value = '';
		document.getElementById("txtLevel").value = '';
		document.getElementById("txtParentId").value = '';
		document.getElementById("txtParentKode").value = '';
		document.getElementById("cmbSur").value = '';
		document.getElementById("isAktif").checked = false;
	}
	
	function batal()
	{
		var p="txtId*-**|*txtKode*-**|*txtDiag*-**|*txtLevel*-**|*txtParentLvl*-**|*txtParentId*-**|*txtParentKode*-**|*cmbSur*-**|*isAktif*-*false*|*btnSimpan*-*Tambah*|*btnHapus*-*true";
		fSetValue(window,p);		
	}
	
	function goFilterAndSort(grd){
		//alert(grd);
		if (grd=="gridbox"){
			//alert("tabel_utils.php?grd1=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage());
			a.loadURL("diag_utils.php?grd=true&filter="+a.getFilter()+"&sorting="+a.getSorting()+"&page="+a.getPage(),"","GET");
		}/*else if (grd=="gridbox1"){
			//alert("tabel_utils.php?grd2=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage());
			b.loadURL("tabel_utils.php?grd2=true&filter="+b.getFilter()+"&sorting="+b.getSorting()+"&page="+b.getPage(),"","GET");
		}*/
	}	
</script>
</html>
<?php 
mysql_close($konek);
?>