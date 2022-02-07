<?php
session_start();
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
<!--dibawah ini diperlukan untuk menampilkan popup-->
<link rel="stylesheet" type="text/css" href="../theme/popup.css" />
<script type="text/javascript" src="../theme/prototype.js"></script>
<script type="text/javascript" src="../theme/effects.js"></script>
<script type="text/javascript" src="../theme/popup.js"></script>

<title>Diagnosis</title>
</head>
<title>Diagnosis</title>
</head>

<body>

<?php
	include("../header1.php");
?>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/dsgrid_sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<form id="form2"  action="diagnosis1_tree.php">
	<input type="hidden" id="act" />
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2" align="center">
	<tr>
		<td height="30">&nbsp;FORM DIAGNOSIS ICD</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="1" cellpadding="0" class="tabel" align="center">
 
  <tr><td colspan="5">&nbsp;</td></tr>
  <tr>
  	<td>&nbsp;</td>
	<td align="right">Kode Induk</td>	<td>
      <input id="txtParentKode"  name="txtParentKode" type="text" size="20" maxlength="20" style="text-align:center" value="<?php echo $ParentKode; ?>" readonly="true" class="txtcenter"> 
      <input type="button"  class="btninput" id="btnParent" name="btnParent" value="..." title="Pilih Induk" onClick="OpenWnd('diagnosis1_tree_view.php?<?php echo $qstr_ma_sak; ?>',800,500,'msma',true)">             
	Level
	<input id="txtLevel" name="txtLevel" size="5" class="txtinput" />
	<input type="hidden" id="txtParentId" name="txtParentId" size="5" />
	<input type="hidden" id="txtParentLvl" name="txtParentLvl" size="6" />
      
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td align="right">Kode Diagnosis ICD</td>
	<input id="txtId" type="hidden" name="txtId"  class="txtinput"/>
    <td><input size="24" id="txtKode" name="txtKode"  class="txtinput"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr> 
  <tr>
    <td>&nbsp;</td>
    <td align="right">Diagnosis ICD</td>
    <td><input size="60" id="txtDiag" name="txtDiag"  class="txtinput"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">Golongan</td>
    <td>
	<input size="40"  type = "hidden" id="dg_kode" name="dg_kode"  class="txtinput"/>
	<input size="40" id="txtGol" name="txtGol"  class="txtinput"/>&nbsp;<img src="../icon/table.gif" width="20" align="absmiddle" style="cursor:pointer; vertical-align:middle" <?php echo $rows['DG_NAMA'];?> onclick="isiDataRM();" title="Pilih Golongan" /></td>
    <!--td>
                                <div id="grdIsiDataRM" type="hidden" style="width:450px; height:200px; padding-bottom:10px; background-color:white;"></div>
                                <!--div id="pagingIsiDataRM" style="width:450px;"></div-->
          </td>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">Penyakit Menular</td>
    <td>&nbsp;<select id="cmbKodeAlert" name="cmbKodeAlert"  class="txtinput">
    	<option value="0">-</option>
    	<?php 
		$sql="SELECT kdg_id,kdg_nama FROM b_ms_diagnosa_gambar WHERE tipe=1 AND kdg_aktif=1";
		$rs=mysql_query($sql);
		while ($rw=mysql_fetch_array($rs)){
		?>
		<option value="<?php echo $rw["kdg_id"]; ?>"><?php echo $rw["kdg_nama"]; ?></option>
        <?php 
		}
		?>
	</select></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
	<td align="right">Surveilance&nbsp;</td>
	<td>&nbsp;<select id="cmbSur" name="cmbSur"  class="txtinput">
		<option value="0">Tidak</option>
		<option value="1">Ya</option>
	</select>
	&nbsp;Status:<label><input type="checkbox" id="isAktif" name="isAktif"  class="txtinput"/>&nbsp;&nbsp;Aktif</label>
	</td>
	<td></td>
	<td>&nbsp;</td>
  </tr>  
  <tr>
  	<td>&nbsp;</td>
   
	<td>&nbsp;</td>
	<td>
        <input type="hidden" id="act1" value="" class="tblSimpan" />
		<input type="button" id="tblTambah" name="btnSimpan" value="Tambah"  class="tblTambah" onclick="sembarang(this.value);" />
		<input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapusbro();"  class="tblHapus" disabled="disabled"/>
		<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/>
	</td>
	<td><button type="button" id="btnTree" name="btnTree" value="Tampilan Tabel" onclick="window.location='diagnosis1.php'" class="tblViewTable">Tampilan Tabel</button></td>
	<td>&nbsp;</td> 
  </tr>
  <tr>
	<td>&nbsp;</td>
    
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">
   <div style="overflow:auto; height:220px;" id="tampil_tree">
   <table border=1 cellspacing=0 width=100%>
	<tr bgcolor="whitesmoke" ><td>
	<?php include "x.php";?> 
	</td>
      </tr>      
	</table>
   
   
   
   
   
   	</div>
   </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
   <td>&nbsp;</td>
       
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
  <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000" align="center">
  <tr height="30">
    <td>&nbsp;</td><td>&nbsp;</td>
  </tr>
</table>
  <div id="divIsiDataRM" style="display:none;width:520px" class="popup" type ="hidden">
                <img alt="close" src="../icon/x.png" width="32" class="popup_closebox" onclick="batal('btnBatalIsiDataRM')" style="float:right; cursor: pointer" />
                <fieldset>
                        <input id="cmbIsiDataRM" type ="hidden" name="cmbIsiDataRM" class="txtinput" onchange="evCmbDataRM();">
                        </input>
                      <td>
                                <div id="grdIsiDataRM" style="width:500px; height:200px; padding-bottom:10px; background-color:white;"></div>
                                <div id="pagingi" style="width:500px;"></div>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </div>
</div>
</fieldset>
<?php
//$a_kode = $_POST['txtParentKode'];
//		$a_nama = $_POST['txtDiag'];
//		$a_level = $_POST['txtLevel'];
//		$a_parentId = $_POST['txtParentId'];
//		$a_parentKode = $_POST['txtParentKode'];
//		$a_sur = $_POST['cmbSur'];
//		$a_aktif = $_POST['isAktif'];
//		$a_dg_kode = $_POST['dg_kode'];
//		if($_POST['simpan']){
//		$sqlTambah="insert into b_ms_diagnosa (kode,nama,level,parent_id,parent_kode,surveilance,aktif,dg_kode)
//				values('$a_kode','$a_nama','$a_level','$a_parentId','$a_parentKode','$a_sur','$a_aktif','$a_dg_kode')";
//				$rs=mysql_query($sqlTambah)or die(mysql_error());
//				echo "<script> alert ('Data Berhasil ditambahkan');
//			location='diagnosis1_tree.php'
				?>
			
<?php

		
			
		//mysql_query("select * from b_ms_diagnosa where kode='".$kode."'");
		//if(mysql_affected_rows()>0){
		//	echo "<script>alert('Data Sudah Ada!');";
		//}

		//else{
			//echo "lllllll11111";
		
		
			if ($parentId>0){
				$sql="update b_ms_diagnosa set islast=0 where id=$parentId";
				//echo $sql;
			//	echo "lllllllxxxxxx";
				$rs=mysql_query($sql);
			}
			/*echo "<script> alert ('Data Berhasil ditambahkan');
			location='diagnosis1_tree.php';</script>";*/
		//}




?>
</fieldset>

<?php
$grd = $_REQUEST["grd"];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$txtGol=$_REQUEST['txtGol'];
$surveilance=$_REQUEST['cmbSur'];
$cekAktif=($_REQUEST['isAktif']=='')?'0':$_REQUEST['isAktif'];
$dg_kode=$_REQUEST['dg_kode'];
$emergency=$_REQUEST['emergency'];

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
$ee=$_REQUEST['act1'];
//echo $ee;
switch($_REQUEST['act1']){
//	echo "<script>alert(zxczxczczxczxczxczx);
	
	case 'Tambah':
	/*echo   "lllllllsssss";
            if($lvl=='2'){
               $kode=$_REQUEST['txtParentKode'].".".$_REQUEST['txtKode'];
            }
            else{
               $kode=$_REQUEST['txtParentKode'].$_REQUEST['txtKode'];
			   echo "lllllllsssssxxx";
            }*/
			
		$a_kode = $_REQUEST['kode'];
		$a_nama = $_REQUEST['nama'];
	//	$a_levelx = $_REQUEST['level'];
		$a_level=$_REQUEST['level'];
		$a_parentId = $_REQUEST['parentId'];
		$a_parentKode =$_REQUEST['parentKode'];
		$a_sur = $_REQUEST['sur'];
		$a_aktif = $_REQUEST['aktif'];
		$a_dg_kode = $_REQUEST['kdgol'];
		$sqlTambahx="insert into b_ms_diagnosa (kode,nama,level,parent_id,parent_kode,surveilance,aktif,dg_kode,kdg_id)
				values('$a_kode','$a_nama','$a_level','$a_parentId','$a_parentKode','$a_sur','$a_aktif','$a_dg_kode',$emergency)";
			$rs=mysql_query($sqlTambahx)or die(mysql_error());
                  //echo $sqlTambah."<br/>";
                  //echo mysql_error();
				  echo "<script> alert ('Data Berhasil ditambahkan');
			location='diagnosis2_tree.php';</script>";
		break;
	case 'Hapus':
	$a_kode = $_REQUEST['kode'];
		$a_nama = $_REQUEST['nama'];
		$a_level = $_REQUEST['level'];
		$a_parentId = $_REQUEST['parentId'];
		$a_parentKode =$_REQUEST['parentKode'];
		$a_sur = $_REQUEST['sur'];
		$a_aktif = $_REQUEST['aktif'];
		$a_dg_kode = $_REQUEST['kdgol'];
		mysql_query("select * from b_ms_diagnosa where parent_id='".$_REQUEST['id']."'");
		if(mysql_affected_rows()>0){
			echo "<script>alert('Data merupakan induk! ".$_REQUEST['parentId']."');</script>";
		}
		else{
			$sql="delete from b_ms_diagnosa where id='".$_REQUEST['id']."'";
			//echo $sql."<br>";
				echo "<script>alert('Data Berhasil Dihapus);</script>";
			$rs=mysql_query($sql);
			$sql1="select * from b_ms_diagnosa where parent_id=".$a_parentId;
			//echo $sql1."<br>";
			$rs2=mysql_query($sql1);
			if (mysql_num_rows($rs2)<=0){
				$sql2="update b_ms_diagnosa set islast=1 where id=".$a_parentId;
				//echo $sql2."<br>";
				$rs3=mysql_query($sql2);
			}
			echo "<script>window.location='diagnosis2_tree.php'</script>";
		}		
		break;
	case 'Edit':
	$a_id=$_REQUEST['id'];
	$a_kode = $_REQUEST['kode'];
		$a_nama = $_REQUEST['nama'];

		$a_level= $_REQUEST['level'];
		$a_parentId = $_REQUEST['parentId'];
		$a_parentKode =$_REQUEST['parentKode'];
		$a_sur = $_REQUEST['sur'];
		$a_aktif = $_REQUEST['aktif'];
		$a_dg_kode = $_REQUEST['kdgol'];
            if($lvl=='2'){
               $kode=$_REQUEST['parentKode'].".".$_REQUEST['kode'];
            }
            else{
               $kode=$_REQUEST['parentKode'].$_REQUEST['kode'];
            }
		$sql="select * from b_ms_diagnosa where kode='$kode' and nama='".$_REQUEST['nama']."' and level='$a_level' and parent_id='$a_parentId' and parent_kode='$a_parentKode' and surveilance='$a_sur' and dg_kode='$a_dg_kode' and kdg_id='$emergency' and aktif='".$a_aktif."'";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "<script>alert('Data Tersebut Sudah Ada');</script>";
		}else{
			$sql="select * from b_ms_diagnosa where id='".$_REQUEST['id']."'";
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
				$sql="update b_ms_diagnosa set islast=0 where id=".$a_parentId;
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				$sql="update b_ms_diagnosa set kode='$a_kode',nama='$a_nama',level='$a_level',parent_id='$a_parentId',parent_kode='$a_parentKode',surveilance='".$a_sur."',dg_kode='".$a_dg_kode."',aktif='".$a_aktif."',kdg_id='".$emergency."' where id='$a_id'";
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
				$sql="update b_ms_diagnosa set kode='$a_kode',nama='$a_nama',level='$a_level',parent_id='$a_parentId',parent_kode='$a_parentKode',surveilance='".$a_sur."',dg_kode='".$a_dg_kode."',aktif='".$a_aktif."',kdg_id='".$emergency."' where id='$a_id'";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				if (($kode_ma!=$cmkode) && ($cislast==0)){
					$sql="update b_ms_diagnosa set kode=CONCAT('$kode',right(kode,length(kode)-length('$cmkode'))),parent_kode=CONCAT('$kode',right(parent_kode,length(parent_kode)-length('$cmkode'))) where left(kode,length('$cmkode'))='$cmkode'";
					//echo $sql."<br>";
					$rs=mysql_query($sql);
				}
			}
			echo "<script>window.location='diagnosis2_tree.php'</script>";
		}
		break;
}
?>

<script language="javascript">

var sbc = document.getElementById('act1').value;
if(sbc=='Edit'){
	document.getElementById("btnHapus").disabled='';
	
}



//<input type="button" name="btnSimpan" value="Tambah"  class="tblTambah" onclick="simpan(this.value);"/>
//alert(document.getElementById('act1').value);
	//<input type="button" id="tblTambah" name="btnSimpan" value="Tambah"  class="tblTambah" onclick="simpan(this.value);" />
	function sembarang(){
		//document.getElementById('act1').value = 'Edit';
		document.getElementById("btnHapus").disabled='false';
    var ax=document.getElementById('tblTambah').value;
	var ccc=document.getElementById('act1').value=ax;
	var id = document.getElementById("txtId").value;
	var kode = document.getElementById("txtKode").value;
	var nama = document.getElementById("txtDiag").value;
	var level = document.getElementById("txtLevel").value;
	var parentId = document.getElementById("txtParentId").value;
	var parentKode = document.getElementById("txtParentKode").value;
	var sur = document.getElementById("cmbSur").value;
	var dg_kode = document.getElementById("dg_kode").value;
	var emergency = document.getElementById("cmbKodeAlert").value;
	var sbx=document.getElementById('act1').value=ccc;
	//document.getElementById('act1').value='';
	//var sbx = document.getElementById('act1').value;
	
	//alert (sbx);
		if(sbx=='Tambah'){
        	//	
		if(document.getElementById("isAktif").checked == true)
			{
				var aktif = 1;
			}
			else
			{
				var aktif = 0;
			}		
				
		//		alert(parentId);
			//	alert(parentKode);
		 window.location.href="diagnosis2_tree.php?act1="+sbx+"&kode="+kode+"&nama="+nama+"&level="+level+"&parentId="+parentId+"&parentKode="+parentKode+"&sur="+sur+"&aktif="+aktif+"&kdgol="+dg_kode+"&emergency="+emergency;
		//alert("diagnosis2_tree.php?act1="+sbx+"&id="+id+"&kode="+kode+"&nama="+nama+"&level="+level+"&parentId="+parentId+"&parentKode="+parentKode+"&sur="+sur+"&aktif="+aktif+"&kdgol="+dg_kode);
		}
		if(document.getElementById("tblTambah").value='Edit'){
		//	alert("edit");
			//alert(sbx);
			window.location.href="diagnosis2_tree.php?act1="+sbx+"&id="+id+"&kode="+kode+"&nama="+nama+"&level="+level+"&parentId="+parentId+"&parentKode="+parentKode+"&sur="+sur+"&aktif="+aktif+"&kdgol="+dg_kode+"&emergency="+emergency;
			
		}
	}
	
	
function Editing(){		
var nilai=document.getElementById('act1').value;
var id = document.getElementById("txtId").value;
var kode = document.getElementById("txtKode").value;
var nama = document.getElementById("txtDiag").value;
var level = document.getElementById("txtLevel").value;
var parentId = document.getElementById("txtParentId").value;
var parentKode = document.getElementById("txtParentKode").value;
var sur = document.getElementById("cmbSur").value;
var dg_kode = document.getElementById("dg_kode").value;		
	if(document.getElementById("isAktif").checked == true)
	{
		var aktif = 1;
	}
	else
	{
		var aktif = 0;
	}		
	document.getElementById("tblTambah").value='Edit';
	document.getElementById("btnHapus").disabled='';

	//alert(nilai);
//	var editan=Edit;
	//alert(editan);
		 //window.location.href="diagnosis2_tree.php?act1="+nilai+"&kode="+kode+"&nama="+nama+"&level="+level+"&parentId="+parentId+"&parentKode="+parentKode+"&sur="+sur+"&aktif="+aktif+"&kdgol="+dg_kode;
			
				
}

function hapuswes(){
				
var nilai=document.getElementById('act1').value;
var id = document.getElementById("txtId").value;
			var kode = document.getElementById("txtKode").value;
			var nama = document.getElementById("txtDiag").value;
			var level = document.getElementById("txtLevel").value;
			var parentId = document.getElementById("txtParentId").value;
			var parentKode = document.getElementById("txtParentKode").value;
			var sur = document.getElementById("cmbSur").value;
			var dg_kode = document.getElementById("dg_kode").value;		
			if(document.getElementById("isAktif").checked == true)
			{
				var aktif = 1;
			}
			else
			{
				var aktif = 0;
			}		
			document.getElementById("tblTambah").value='Edit';
			document.getElementById("btnHapus").disabled='';
		//	alert("oyi");
				//alert(nilai);
			//	var editan=Edit;
				//alert(editan);
		 window.location.href="diagnosis2_tree.php?act1="+nilai+"&kode="+kode+"&nama="+nama+"&level="+level+"&parentId="+parentId+"&parentKode="+parentKode+"&sur="+sur+"&aktif="+aktif+"&kdgol="+dg_kode;
			
				
}


function hapusbro(){
document.getElementById("act1").value='Hapus';				
var nilai=document.getElementById('act1').value;
var id = document.getElementById("txtId").value;
			var kode = document.getElementById("txtKode").value;
			var nama = document.getElementById("txtDiag").value;
			var level = document.getElementById("txtLevel").value;
			var parentId = document.getElementById("txtParentId").value;
			var parentKode = document.getElementById("txtParentKode").value;
			var sur = document.getElementById("cmbSur").value;
			var dg_kode = document.getElementById("dg_kode").value;		
			if(document.getElementById("isAktif").checked == true)
			{
				var aktif = 1;
			}
			else
			{
				var aktif = 0;
			}		
			//document.getElementById("tblTambah").value='Edit';
			//alert("oyi");
				//alert(nilai);
			//	var editan=Edit;
				//alert(editan);
				document.getElementById("btnHapus").disabled='';
				var sbx=document.getElementById('act1').value;
			window.location.href="diagnosis2_tree.php?act1="+sbx+"&id="+id+"&kode="+kode+"&nama="+nama+"&level="+level+"&parentId="+parentId+"&parentKode="+parentKode+"&sur="+sur+"&aktif="+aktif+"&kdgol="+dg_kode;
			
				
}
//	document.getElementById('btnHapus').disabled=false;
	/*if(act1=="Tambah")
		{
			document.getElementById('act1').value='Tambah';
			var act = document.getElementById('act1').value;
			
			fSetValue(this,'act1*-*Tambah');
			
        
			document.getElementById("form2").submit();
	
	}*/
//	function simpan(action)
	//{
		//alert(action);
		
		
			//window.location:'diagnosis1_tree.php?kode=+kode';
			
			//alert("diagnosis1_tree.php?act='+act+'&kode='+kode+'&nama='+nama +'&level='+level+'&parentId='+parentId+'&parentKode='+parentKode+'&sur='+sur+'&dg_kode='+dg_kode+'&aktif='+aktif"));
			//alert('txtKode,txtDiag,txtLevel,txtParentId,txtParentKode,cmbSur,dg_kode,isAktif','ind');
			
			//var dataString = 'act='+act+'&kode='+kode+'&nama='+nama +'&level='+level+'&parentId='+parentId+'&parentKode='+parentKode+'&sur='+sur+'&dg_kode='+dg_kode+'&aktif='+aktif;
//			alert(dataString);
//			$.ajax({
//			type: "POST",
//			url: "y.php",
//			data: dataString,
//			success: function(){
//			$('#tampil_tree').load('x.php');
//			}
//			});
			
			
//			alert(id+'-'+kode+'-'+nama+'-'+level+'-'+parentId+'-'+parentKode+'-'+sur+'-'+dg_kode);
		/*}
		else if(action=="Simpan"){
			document.getElementById('act').value='simpan';
			fSetValue(this,'act*-*simpan');
			
		}
		
		if(ValidateForm('txtKode,txtDiag,txtLevel,txtParentId,txtParentKode,cmbSur,dg_kode,isAktif','ind')){
				
			    
			}
	}
	*/
	function ambilData()
	{
		var p="txtId*-*"+(a.getRowId(a.getSelRow()))+"*|*txtKode*-*"+a.cellsGetValue(a.getSelRow(),2)+"*|*txtDiag*-*"+a.cellsGetValue(a.getSelRow(),3)+"*|*txtLevel*-*"+a.cellsGetValue(a.getSelRow(),4)+"*|*txtParentLvl*-**|*txtParentId*-*"+a.cellsGetValue(a.getSelRow(),5)+"*|*txtParentKode*-*"+a.cellsGetValue(a.getSelRow(),6)+"*|*cmbSur*-*"+a.cellsGetValue(a.getSelRow(),7)+"*|*dg_kode*-*"+a.cellsGetValue(a.getSelRow(),10)+"*|*isAktif*-*"+((a.cellsGetValue(a.getSelRow(),9)=='Aktif')?'true':'false')+"*|*tblTambah*-*Tambah*|*btnHapus*-*false";
		//alert(p);
		/*if(p!==0){
		document.getElementById('edit').style.display='block';
		document.getElementById('tblTambah').style.display='none';
		}else{
		document.getElementById('tblTambah').style.display='block';	
		document.getElementById('edit').style.display='none';	
		}*/
		
		fSetValue(window,p);
		
	}
	
	function hapus1()
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
		document.getElementById("dg_kode").value = '';
		document.getElementById("isAktif").checked = false;
	}
	function hapus(txtId){
		//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
		if(confirm("Anda yakin menghapus Unit ini?")){
			fSetValue(window,'act*-*hapus');
			if(ValidateForm('txtKode,txtDiag,txtLevel,txtParentId,txtParentKode,cmbSur,dg_kode,isAktif','ind')){
				document.form1.submit();
			}
		}
		batal();
	}
	
	function batal()
	{
		var p="txtId*-**|*txtKode*-**|*txtDiag*-**|*txtLevel*-**|*txtParentLvl*-**|*txtParentId*-**|*txtParentKode*-**|*cmbSur*-**|*txtGol*-**|*dg_kode*-**|*isAktif*-*false*|*tblTambah*-*Tambah*|*btnHapus*-*true";
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
		if (grd=="grdIsiDataRM")
		{
			//alert("golongan.php?grd=true&filter="+ai.getFilter()+"&sorting="+ai.getSorting()+"&page="+ai.getPage());
			ai.loadURL("golongan.php?grd=true&filter="+ai.getFilter()+"&sorting="+ai.getSorting()+"&page="+ai.getPage(),"","GET");
		}
	}	
	
	function isiDataRM(){
		window.scroll(0,0);
		new Popup('divIsiDataRM',null,{modal:true,position:'center',duration:1});
		document.getElementById('divIsiDataRM').popup.show();
	}
	
	function tarikDataRM(){
			document.getElementById('dg_kode').value=ai.cellsGetValue(ai.getSelRow(),2);
			document.getElementById('txtGol').value=ai.cellsGetValue(ai.getSelRow(),3);
			document.getElementById('divIsiDataRM').popup.hide();
	}	
			
	var ai=new DSGridObject("grdIsiDataRM");
	ai.setHeader("DIAGNOSIS");
	ai.setColHeader("NO,KODE,NAMA GOLONGAN");
	ai.setIDColHeader(",DG_KODE,DG_NAMA");
	ai.setColWidth("50,100,150");
	ai.setCellAlign("center,left,left");
	ai.setCellHeight(20);
	ai.setImgPath("../icon");
	ai.setIDPaging("pagingi");
	ai.attachEvent("onRowClick","tarikDataRM");
	ai.baseURL("golongan.php?grd=true");
	ai.Init();
	
	
	
	
</script>
</form>
   </body>


</html>
<?php 
mysql_close($konek);
?>