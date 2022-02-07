<?php
session_start();
include '../inc/koneksi.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='../../index.php';
                        </script>";
}

$PATH_INFO="";
$_SESSION["PATH_INFO"]=$PATH_INFO;

$qstr_ma_sak="par=txtParentId*txtParentKode*txtParentLvl*txtLevel";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ADMINISTRATOR -- Sistem Informasi Manajemen Rumah Sakit</title>
<link type="text/css" href="../inc/menu/menu.css" rel="stylesheet" />

</head>

<body>
	
        <div id="wrapper">
            <div id="header">
				<?php include("../inc/header.php");?>
				<script type="text/javascript" src="../js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="../inc/menu/menu.js"></script> 
            </div>
            
          <div id="topmenu">
                 <?php include("../inc/menu/menu.php"); ?>
          </div>
            
            <div id="content">
			
<center>


<form name="form1" method="post" action="" target="_SELF">
  <input name="act" id="act" type="hidden" value="tambah">

<table width="1000" border="0" cellspacing="0" cellpadding="2" align="center" class="tabel">  
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
  	<td width="5%">&nbsp;</td>
    <td width="10%" align="right">Kode Induk&nbsp;&nbsp;</td>
    <td width="45%">
	<input id="txtParentKode"  name="txtParentKode" type="text" size="20" maxlength="20" style="text-align:center" value="<?php echo $ParentKode; ?>" readonly="true" class="txtcenter"> 
      <input type="button" class="txtcenter" id="btnParent" name="btnParent" value="..." title="Pilih Induk" onClick="OpenWnd('ms_wilayah_tree_view.php?<?php echo $qstr_ma_sak; ?>',800,500,'msma',true)">             
	Level
	<input id="txtLevel" name="txtLevel" size="5" class="txtinput" />
	<input type="hidden" id="txtParentId" name="txtParentId" size="5" />
	<input type="hidden" id="txtParentLvl" name="txtParentLvl" size="6" />
	
	
    </td>
    <td width="20%">
	
    </td>
	<td width="5%">&nbsp;</td>
  </tr>  
  <tr>
    <td>&nbsp;</td>
    <td align="right">Kode&nbsp;&nbsp;</td>
    <td>
	<input id="txtId" name="txtId" type="hidden" />
	<input id="txtKode" name="txtKode" size="10" class="txtinput" />
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>    
  <tr>
    <td>&nbsp;</td>
    <td align="right">Nama Wilayah&nbsp;&nbsp;</td>
    <td><input id="txtNama" name="txtNama" size="32" class="txtinput" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  	<td align="right">Status&nbsp;&nbsp;</td>
	<td>
		<label><input type="checkbox" id="chAktif" name="chAktif" onclick="if(this.checked==true){this.value=1;} else{this.value=0;}" class="txtinput">aktif</label>
	</td>
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
	<td><button type="button" id="btnTree" name="btnTree" value="Tampilan Tabel" onclick="window.location='rspelindo_billing.b_ms_wilayah.php'" class="tblViewTable">Tampilan Tabel</button></td>
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
	  $strSQL = "select * from rspelindo_billing.b_ms_wilayah order by kode";
	  $rs = mysql_query($strSQL);
	  while ($rows=mysql_fetch_array($rs)){
			 $c_level = $rows["level"];
			 $pkode=trim($rows['parent_kode']);
			 $mkode=trim($rows['kode']);
			 
			 //$inap=($rows['inap']==1)?'true':'false';
			 $chkAktif=($rows['aktif']==1)?'true':'false';
			 if ($pkode!=""){
			 //	if (substr($mkode,0,strlen($pkode))==$pkode) 
					$mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
				//else
				//	$mkode=substr($mkode,strlen($pkode),strlen($mkode)-(strlen($pkode)));
			 }
			 $sql="select * from rspelindo_billing.b_ms_wilayah where id=".$rows['parent_id'];
			 $rs1=mysql_query($sql);
			 if ($rows1=mysql_fetch_array($rs1)) $c_mainduk=$rows1["nama"]; else $c_mainduk="";
			 $tree[$cnt][0]= $c_level;
			 $tree[$cnt][1]= $rows["kode"]." - ".($mpkode==""?"":$mpkode." - ").$rows["nama"];			
			 $arfvalue="txtId*-*".$rows['id']."*|*txtKode*-*".$mkode."*|*txtNama*-*".$rows['nama']."*|*txtParentLvl*-*".($rows['level']-1)."*|*txtLevel*-*".$rows['level']."*|*txtParentId*-*".$rows['parent_id']."*|*txtParentKode*-*".$rows['parent_kode']."*|*chAktif*-*".$chkAktif."*|*btnSimpan*-*Simpan";
			 $arfvalue=str_replace('"',chr(3),$arfvalue);
			 $arfvalue=str_replace("'",chr(5),$arfvalue);
			 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
			 if ($c_level>0)
				 $tree[$cnt][2]= "javascript:fSetValue(window,'".$arfvalue."');";
			 else
				 $tree[$cnt][2] = null;
	
			 $tree[$cnt][3]= "";
			 $tree[$cnt][4]= 0;
			 //$tree[$cnt][5]=($rows['islast']==1)?$rows['id']:0;
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
	</table>
    </td>
    
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


		      </center>   
            </div>
            <div id="footer">
				<?php
					$query = mysql_query("SELECT pegawai.pegawai_id, pegawai.nama,
						pgw_jabatan.id, pgw_jabatan.jbt_id,
						ms_jabatan_pegawai.id, ms_jabatan_pegawai.nama_jabatan
						FROM rspelindo_hcr.pegawai
						INNER JOIN rspelindo_hcr.pgw_jabatan ON pgw_jabatan.pegawai_id = pegawai.pegawai_id
						LEFT JOIN rspelindo_hcr.ms_jabatan_pegawai ON ms_jabatan_pegawai.id = pgw_jabatan.jbt_id
						WHERE pegawai.pegawai_id=".$_SESSION['user_id']);
					$i=0;
					$pegawai='';
					$jabatan='';
					while($row = mysql_fetch_array($query)){
						if($i==0)
							$pegawai = $row['nama'];
						if($i>0)
							$jabatan .= ", ";
						$jabatan .= $row['nama_jabatan'];	
						$i++; 
					}
				?>
               	<div style="float:left;">Nama: <span style="color:yellow"><?php echo $pegawai;?></span></div>
				<div style="float:right;"> <span style="color:yellow;"><?=$jabatan?></span> : Jabatan</div>
            </div>
            
        </div>
<div id="tempor" style="display:none"></div>
</body>
</html>
<?php

$txtInap=$_REQUEST['rdInap'];
$cekAktif=isset($_REQUEST['chAktif'])?1:0;

$kode=$_REQUEST['txtParentKode'].$_REQUEST['txtKode'];
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
		mysql_query("select * from rspelindo_billing.b_ms_wilayah where kode='".$_REQUEST['txtKode']."'");
		if(mysql_affected_rows()>0){
			echo "<script>alert('Data Sudah Ada!');</script>";
		}
		else{
			$sqlTambah="insert into rspelindo_billing.b_ms_wilayah (kode,nama,level,parent_id,parent_kode,aktif)
				values('".$kode."','".$_REQUEST['txtNama']."','".$_REQUEST['txtLevel']."','".$_REQUEST['txtParentId']."','".$_REQUEST['txtParentKode']."','".$cekAktif."')";
			$rs=mysql_query($sqlTambah);
			echo "<script>window.location='ms_wilayah_tree.php'</script>";
			echo $sqlTambah;
		}
		break;
	case 'hapus':
		mysql_query("select * from rspelindo_billing.b_ms_wilayah where parent_id='".$_REQUEST['txtId']."'");
		if(mysql_affected_rows()>0){
			echo "<script>alert('Data merupakan induk! ".$_REQUEST['txtId']."');</script>";
		}
		else{
			$sql="delete from rspelindo_billing.b_ms_wilayah where id='".$_REQUEST['txtId']."'";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
			$sql1="select * from b_ms_unit where parent_id=".$parentId;
			//echo $sql1."<br>";
			$rs2=mysql_query($sql1);
			echo "<script>window.location='ms_wilayah_tree.php'</script>";
		}		
		break;
	case 'simpan':
		$sql="select * from rspelindo_billing.b_ms_wilayah where kode='$kode' and nama='".$_REQUEST['txtNama']."' and level=$lvl and parent_id=$parentId and parent_kode='$ParentKode' and aktif='".$cekAktif."'";
		//echo $sql."<br>";
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "<script>alert('Data Tersebut Sudah Ada');</script>";
		}else{
			$sql="select * from rspelindo_billing.b_ms_wilayah where id='".$_REQUEST['txtId']."'";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
			if ($rows=mysql_fetch_array($rs)){				
				
				$cparent=$rows["parent_id"];
				$clvl=($rows["level"]-1);
				$cmkode=$rows["kode"];
				//$cislast=$rows["islast"];				
			}
			//echo "cparent=".$cparent.",clvl=".$clvl.",cmkode=".$cmkode.",cislast=".$cislast."<br>";
			if ($cparent!=$parentId){
				$cur_lvl=$lvl-$clvl;
				if ($cur_lvl>0) $cur_lvl="+".$cur_lvl;
				$sql="update rspelindo_billing.b_ms_wilayah set islast=0 where id=".$parentId;
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				$sql="update rspelindo_billing.b_ms_wilayah set kode='$kode',nama='".$_REQUEST['txtNama']."',level=$lvl,parent_id=$parentId,parent_kode='$ParentKode',aktif='".$cekAktif."' where id='".$_REQUEST['txtId']."'";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				if ($cislast==0){
					$sql="update rspelindo_billing.b_ms_wilayah set kode=CONCAT('$kode',right(kode,length(kode)-length('$cmkode'))),parent_kode=CONCAT('$kode',right(parent_kode,length(parent_kode)-length('$cmkode'))),level=".$cur_lvl." where left(kode,length('$cmkode'))='$cmkode'";
					//echo $sql."<br>";
					$rs=mysql_query($sql);
				}
				$sql="select * from rspelindo_billing.b_ms_wilayah where parent_id=$cparent";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				/*if (mysql_num_rows($rs)<=0){
					$sql="update b_ms_unit set islast=1 where id=".$cparent;
					//echo $sql."<br>";
					$rs1=mysql_query($sql);
				}*/				
			}else{	
				$sql="update rspelindo_billing.b_ms_wilayah set kode='$kode',nama='".$_REQUEST['txtNama']."',level=$lvl,parent_id=$parentId,parent_kode='$ParentKode',aktif='".$cekAktif."' where id='".$_REQUEST['txtId']."'";
				//echo $sql."<br>";
				$rs=mysql_query($sql);
				if (($kode_ma!=$cmkode) && ($cislast==0)){
					$sql="update rspelindo_billing.b_ms_wilayah set kode=CONCAT('$kode',right(kode,length(kode)-length('$cmkode'))),parent_kode=CONCAT('$kode',right(parent_kode,length(parent_kode)-length('$cmkode'))) where left(kode,length('$cmkode'))='$cmkode'";
					//echo $sql."<br>";
					$rs=mysql_query($sql);
				}
			}
			echo "<script>window.location='ms_wilayah_tree.php'</script>";
		}
		break;
}
?>
<script>
	function simpan(action){
		if(action=="Tambah")
		fSetValue(window,'act*-*tambah');
		else if(action=="Simpan")
		fSetValue(window,'act*-*simpan');
		if(ValidateForm('txtKode,txtNama,txtLevel,txtParentKode,chAktif','ind')){
			document.form1.submit();
		}
		
	}
	
	function ambilData(){
		var p="act*-*simpan*|*txtId*-*"+(a.getRowId(a.getSelRow()))+"*|*txtKode*-*"+a.cellsGetValue(a.getSelRow(),2)+"*|*txtNama*-*"+a.cellsGetValue(a.getSelRow(),3)+"*|*txtLevel*-*"+a.cellsGetValue(a.getSelRow(),4)+"*|*txtParentLvl*-**|*txtParentId*-*"+a.cellsGetValue(a.getSelRow(),5)+"*|*txtParentKode*-*"+a.cellsGetValue(a.getSelRow(),6)+"*|*chAktif*-*"+((a.cellsGetValue(a.getSelRow(),7)=='Aktif')?'true':'false')+"*|*btnSimpan*-*Simpan*|*btnHapus*-*false";
		fSetValue(window,p);		
		
	}
	
	function hapus(rowid){
		//alert("tmpt_layanan_utils.php?act=hapus&rowid="+rowid);
		if(confirm("Anda yakin menghapus Unit ini?")){
			fSetValue(window,'act*-*hapus');
			if(ValidateForm('txtId,txtKode,txtNama,txtLevel,txtParentId,txtParentKode,chAktif','ind')){
				document.form1.submit();
			}
		}
		
		batal();
	}
	
	function batal(){		
		var p="txtId*-**|*txtKode*-**|*txtNama*-**|*txtLevel*-**|*txtParentLvl*-**|*txtParentId*-**|*txtParentKode*-**|*chAktif*-*false*|*btnSimpan*-*Tambah";
		fSetValue(window,p);				
	}	
</script>

