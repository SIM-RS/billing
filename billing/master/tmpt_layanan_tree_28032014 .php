<?php
session_start();
include("../sesi.php");
?>
<?php
//session_start();
include("../koneksi/konek.php");
//$PATH_INFO="?".$_SERVER['QUERY_STRING'];
$PATH_INFO="";
$_SESSION["PATH_INFO"]=$PATH_INFO;

$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";
//echo "act=".strtolower($_REQUEST['act'])."<br>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" rel="stylesheet" href="../theme/mod.css">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/dsgrid.js"></script>
<!-- untuk ajax-->
<script type="text/javascript" src="../theme/js/ajax.js"></script>
<!-- end untuk ajax-->
<title>Tempat Layanan</title>
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
<form name="form1" method="get" action="">
  <input name="act" id="act" type="hidden" value="tambah">
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;FORM TEMPAT LAYANAN</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="2" align="center" class="tabel">  
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
  	<td width="5%">&nbsp;</td>
    <td width="10%" align="right">Kode Induk</td>
    <td width="45%">
	<input id="txtParentKode"  name="txtParentKode" type="text" size="20" maxlength="20" style="text-align:center" value="<?php echo $ParentKode; ?>" readonly="true" class="txtcenter"> 
      <input type="button" class="btninput" id="btnParent" name="btnParent" value="..." title="Pilih Induk" onClick="OpenWnd('tmpt_layanan_tree_view.php?<?php echo $qstr_ma_sak; ?>',800,500,'msma',true)">             
	<input type="hidden" id="txtLevel" name="txtLevel" size="5" />
	<input type="hidden" id="txtParentId" name="txtParentId" size="5" />
	<input type="hidden" id="txtParentLvl" name="txtParentLvl" size="6" />    </td>
    <td width="20%">    </td>
	<td width="5%">&nbsp;</td>
  </tr>  
  <tr>
    <td>&nbsp;</td>
    <td align="right">Kode</td>
    <td>
	<input id="txtId" name="txtId" type="hidden" />
	<input id="txtKode" name="txtKode" size="10"  class="txtinput"/>
    &nbsp;Nama&nbsp;<input id="txtNama" name="txtNama" size="20"  class="txtinput"/>    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>    
  <tr>
    <td>&nbsp;</td>
    <td align="right">Kode RC Akuntansi</td>
    <td><input id="txtKodeAk" name="txtKodeAk" size="10" value="" class="txtinput"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">Keterangan</td>
    <td><input id="txtKet" name="txtKet" size="20"  class="txtinput"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
	<td>&nbsp;</td>
	<td align="right">Kategori</td>
	<td><select id="txtKtgr" name="txtKtgr" onchange="setCakupan(this.value)" class="txtinput">
	    <option value="1">Loket</option>
	    <option value="2">Pelayanan</option>
	    <option value="3">Administrasi</option>
        <option value="4">Kasir</option>
        <option value="5">Farmasi/Apotek</option>
	</select></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
    <tr id="tr_cakupan" style="display: none">
        <td></td>
        <td align="right">Cakupan Tagihan</td>
        <td>
            <select id="cakupan" name="cakupan" class="txtinput">
            </select>        </td>
    </tr>
  <tr>
    <td>&nbsp;</td>
  	<td align="right">Status inap</td>
	<td>
		<label><input type="radio" id="rdInap1" name="rdInap" value="1" checked="checked">Ya</label>
		<label><input type="radio" id="rdInap0" name="rdInap" value="0">Tidak</label>	</td>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  	<td align="right">Status</td>
	<td>
		<label><input type="checkbox" id="chAktif" name="chAktif" checked="checked" value="1" onclick="if(this.checked==true){this.value=1;} else{this.value=0;}">aktif</label>	</td>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  	<td>&nbsp;</td>
	<td>
		<input type="button" id="btnSimpan" name="btnSimpan" value="Tambah" onclick="simpan(this.value);" class="tblTambah"/>
		<!--input type="button" id="btnHapus" name="btnHapus" value="Hapus" onclick="hapus(this.title);" disabled="disabled" class="tblHapus"/-->
		<input type="button" id="btnBatal" name="btnBatal" value="Batal" onclick="batal()" class="tblBatal"/>	</td>
	<td><button type="button" id="btnTree" name="btnTree" value="Tampilan Tabel" onclick="window.location='tmpt_layanan.php'" class="tblViewTable">Tampilan Tabel</button></td>
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
	
    <td align="left" colspan="3">		
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
	  $strSQL = "select * from b_ms_unit order by kode";
	  $rs = mysql_query($strSQL);
	  while ($rows=mysql_fetch_array($rs)){
			 $c_level = $rows["level"];
			 $pkode=trim($rows['parent_kode']);
			 $mkode=trim($rows['kode']);
			 $kodeAk=trim($rows['kode_ak']);
			 
			 $inap=($rows['inap']==1)?'true':'false';
			 $chkAktif=($rows['aktif']==1)?'true':'false';
			 if ($pkode!=""){
			 //	if (substr($mkode,0,strlen($pkode))==$pkode) 
					$mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
				//else
				//	$mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
			 }
			 $sql="select * from b_ms_unit where id=".$rows['parent_id'];
			 $rs1=mysql_query($sql);
			 if ($rows1=mysql_fetch_array($rs1)) $c_mainduk=$rows1["nama"]; else $c_mainduk="";
			 $tree[$cnt][0]= $c_level;
			 $tree[$cnt][1]= $rows["kode"]." - ".($mpkode==""?"":$mpkode." - ").$rows["nama"];			
			 $arfvalue="txtId*-*".$rows['id']."*|*txtKode*-*".$mkode."*|*txtKodeAk*-*".$kodeAk."*|*txtNama*-*".$rows['nama']."*|*txtParentLvl*-*".($rows['level']-1)."*|*txtLevel*-*".$rows['level']."*|*txtParentId*-*".$rows['parent_id']."*|*txtParentKode*-*".$rows['parent_kode']."*|*txtKet*-*".$rows['ket']."*|*txtKtgr*-*".$rows['kategori']."*|*rdInap1*-*".(($inap=='true')?'true':'false')."*|*rdInap0*-*".(($inap=='true')?'false':'true')."*|*chAktif*-*".$chkAktif."*|*btnSimpan*-*Simpan";
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
	</td></tr>
	</table>    </td>
    
	<td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
  	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>
</form>
  <table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
  <tr height="30">
  	<td>&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;"  class="btninput"/></td>
	<td></td>
	<td align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;"  class="btninput"/></a>&nbsp;</td>
  </tr>
</table>
</div>
</body>
<?php
$txtInap=$_REQUEST['rdInap'];
$cekAktif=($_REQUEST['chAktif']=='')?'0':$_REQUEST['chAktif'];
$cakupan = 0;
if($_REQUEST['txtKtgr'] == 4){
    $cakupan = $_REQUEST['cakupan'];
}

$kode=$_REQUEST['txtParentKode'].$_REQUEST['txtKode'];
$kodeAk=$_REQUEST["txtKodeAk"];
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
$lvl = ($_REQUEST['txtLevel']=='')?1:$_REQUEST['txtLevel'];

switch(strtolower($_REQUEST['act'])){
	case 'tambah':
		
		mysql_query("select * from b_ms_unit where kode='".$kode."'");
		if(mysql_affected_rows()>0){
			echo "<script>alert('Data Sudah Ada!');</script>";
		}
		else{
			$sqlTambah="insert into b_ms_unit (kode,kode_ak,nama,level,parent_id,parent_kode,ket,kategori,jenis_layanan,islast,inap,aktif)
				values('".$kode."','$kodeAk','".$_REQUEST['txtNama']."','".$level."','".$_REQUEST['txtParentId']."','".$_REQUEST['txtParentKode']."','".$_REQUEST['txtKet']."','".$_REQUEST['txtKtgr']."','$cakupan','1','".$txtInap."','".$cekAktif."')";
			$rs=mysql_query($sqlTambah);
			if ($parentId>0){
				$sql="update b_ms_unit set islast=0 where id=$parentId";
				//echo $sql;
				$rs=mysql_query($sql);
			}
			echo "<script>window.location='tmpt_layanan_tree.php'</script>";
		}
		break;
	case 'hapus':
		mysql_query("select * from b_ms_unit where parent_id='".$_REQUEST['txtId']."'");
		if(mysql_affected_rows()>0){
			echo "<script>alert('Data merupakan induk! ".$_REQUEST['txtId']."');</script>";
		}
		else{
			$sql="delete from b_ms_unit where id='".$_REQUEST['txtId']."'";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
			$sql1="select * from b_ms_unit where parent_id=".$parentId;
			//echo $sql1."<br>";
			$rs2=mysql_query($sql1);
			if (mysql_num_rows($rs2)<=0){
				$sql2="update b_ms_unit set islast=1 where id=".$parentId;
				//echo $sql2."<br>";
				$rs3=mysql_query($sql2);
			}
			echo "<script>window.location='tmpt_layanan_tree.php'</script>";
		}		
		break;
	case 'simpan':
		$sql="select * from b_ms_unit where kode='$kode' and nama='".$_REQUEST['txtNama']."' and level=$lvl and parent_id=$parentId and parent_kode='$ParentKode' and ket='".$_REQUEST['txtKet']."' and kategori='".$_REQUEST['txtKtgr']."' and inap='".$txtInap."' and aktif='".$cekAktif."'";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "<script>alert('Data Tersebut Sudah Ada');</script>";
		}else{
			$sql="select * from b_ms_unit where id='".$_REQUEST['txtId']."'";
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
				$sql="update b_ms_unit set islast=0 where id=".$parentId;
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				$sql="update b_ms_unit set kode='$kode',kode_ak='$kodeAk',nama='".$_REQUEST['txtNama']."',ket='".$_REQUEST['txtKet']."',kategori='".$_REQUEST['txtKtgr']."',jenis_layanan='$cakupan',level=$lvl,parent_id=$parentId,parent_kode='$ParentKode',inap='".$txtInap."',aktif='".$cekAktif."' where id='".$_REQUEST['txtId']."'";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				if ($cislast==0){
					$sql="update b_ms_unit set kode=CONCAT('$kode',right(kode,length(kode)-length('$cmkode'))),parent_kode=CONCAT('$kode',right(parent_kode,length(parent_kode)-length('$cmkode'))),level=".$cur_lvl." where left(kode,length('$cmkode'))='$cmkode'";
					//echo $sql."<br>";
					$rs=mysql_query($sql);
				}
				$sql="select * from b_ms_unit where parent_id=$cparent";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				if (mysql_num_rows($rs)<=0){
					$sql="update b_ms_unit set islast=1 where id=".$cparent;
					//echo $sql."<br>";
					$rs1=mysql_query($sql);
				}				
			}else{	
				$sql="update b_ms_unit set kode='$kode',kode_ak='$kodeAk',nama='".$_REQUEST['txtNama']."',level=$lvl,parent_id=$parentId,parent_kode='$ParentKode',ket='".$_REQUEST['txtKet']."',kategori='".$_REQUEST['txtKtgr']."',jenis_layanan='$cakupan',inap='".$txtInap."',aktif='".$cekAktif."' where id='".$_REQUEST['txtId']."'";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				if (($kode!=$cmkode) && ($cislast==0)){
					$sql="update b_ms_unit set kode=CONCAT('$kode',right(kode,length(kode)-length('$cmkode'))),parent_kode=CONCAT('$kode',right(parent_kode,length(parent_kode)-length('$cmkode'))) where left(kode,length('$cmkode'))='$cmkode'";
					//echo $sql."<br>";
					$rs=mysql_query($sql);
				}
			}
			echo "<script>window.location='tmpt_layanan_tree.php'</script>";
		}
		break;
}
?>
<script>
	function simpan(action){
		if (document.getElementById("txtId").value==document.getElementById("txtParentId").value && document.getElementById("txtParentId").value!=""){
			alert("Unit Parent Tdk Boleh Unitnya Sendiri !");
			return false;
		}
		//alert(action);
		if(action=="Tambah")
			fSetValue(window,'act*-*tambah');
		else if(action=="Simpan")
			fSetValue(window,'act*-*simpan');
			
		if(ValidateForm('txtKode,txtKodeAk,txtNama','ind')){
			document.form1.submit();
		}
		/*
		var id=document.getElementById("btnHapus").title;
		var kode=document.getElementById("txtKode").value;
		var nama=document.getElementById("txtNama").value;
		var level=document.getElementById("txtLevel").value;
		var parentId=document.getElementById("txtParentId").value;
		var parentKode=document.getElementById("txtParentKode").value;
		var ket=document.getElementById("txtKet").value;
		if(document.getElementById("rdInap1").checked==true && document.getElementById("rdInap0").checked==false){
			var inap=document.getElementById("rdInap1").value;
		}
		else if(document.getElementById("rdInap0").checked==true && document.getElementById("rdInap1").checked==false){
			var inap=document.getElementById("rdInap0").value;
		}
		if(document.getElementById("chAktif").checked==true){
		var aktif=1;
		}
		else{
			var aktif=0;
		}		
		
		a.loadURL("tmpt_layanan_utils.php?act="+action+"&id="+id+"&kode="+kode+"&nama="+nama+"&level="+level+"&parentId="+parentId+"&parentKode="+parentKode+"&ket="+ket+"&inap="+inap+"&aktif="+aktif,"","GET");
		*/
		
	}
	
	function ambilData(){
		var p="act*-*simpan*|*txtId*-*"+(a.getRowId(a.getSelRow()))+"*|*txtKode*-*"+a.cellsGetValue(a.getSelRow(),2)+"*|*txtNama*-*"+a.cellsGetValue(a.getSelRow(),3)+"*|*txtLevel*-*"+a.cellsGetValue(a.getSelRow(),4)+"*|*txtParentLvl*-**|*txtParentId*-*"+a.cellsGetValue(a.getSelRow(),5)+"*|*txtParentKode*-*"+a.cellsGetValue(a.getSelRow(),6)+"*|*txtKet*-*"+a.cellsGetValue(a.getSelRow(),7)+"*|*rdInap0*-*"+((a.cellsGetValue(a.getSelRow(),9)=='Ya')?'false':'true')+"*|*rdInap1*-*"+((a.cellsGetValue(a.getSelRow(),9)=='Ya')?'true':'false')+"*|*chAktif*-*"+((a.cellsGetValue(a.getSelRow(),10)=='Aktif')?'true':'false')+"*|*btnSimpan*-*Simpan*|*btnHapus*-*false";
		fSetValue(window,p);		
		
	}
	
	function hapus(rowid){
		//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
		if(confirm("Anda yakin menghapus Unit ini?")){
			fSetValue(window,'act*-*hapus');
			if(ValidateForm('txtId,txtKode,txtNama,txtLevel,txtParentId,txtParentKode,txtKet,txtKtgr,rdInap1,rdInap0,chAktif','ind')){
				document.form1.submit();
			}
		}
		
		batal();
	}
	
	function batal(){		
		var p="txtId*-**|*txtKode*-**|*txtNama*-**|*txtLevel*-**|*txtParentLvl*-**|*txtParentId*-**|*txtParentKode*-**|*txtKet*-**|*rdInap0*-*true*|*rdInap1*-*false*|*chAktif*-*false*|*btnSimpan*-*Tambah";
		fSetValue(window,p);				
	}	
        
	function isiCombo(id,val,defaultId,targetId,evloaded){
		if(targetId=='' || targetId==undefined){
			targetId=id;
		}
		Request('../combo_utils.php?all=1&id='+id+'&value='+val+'&defaultId='+defaultId,targetId,'','GET',evloaded,'ok');
	}

	isiCombo('cakupan','','','cakupan','');

	function setCakupan(val){
		if(val == 4){
			document.getElementById('tr_cakupan').style.display = 'table-row';
		}
		else{
			document.getElementById('tr_cakupan').style.display = 'none';
		}
	}
</script>
</html>