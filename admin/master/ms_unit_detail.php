<?php
session_start();
include '../inc/koneksi.php';
if(!isset($_SESSION['userid']) || $_SESSION['userid'] == '') {
    echo "<script>alert('Anda belum login atau session anda habis, silakan login ulang.');
                        window.location='../../index.php';
                        </script>";
}

$id 		= $_GET['id'];
$back_addr 	= "ms_unit.php";
if(isset($_GET['origin']) && $_GET['origin'] != '') 
{
    $back_addr = "ms_unit_tree.php";
}

$kode_unit		=	$_POST['kode_unit'];
$kode_unit_lama		=	$_POST['kode_unit_lama'];
$nama_unit		=	$_POST['nama_unit'];
$nickunit		=	$_POST['nickunit'];
$parent			=	$_POST["induk"];
$lvl			=	$_POST['lvl'];
$aktif			=	$_POST['aktif'];
$rc 			= 	$_POST['rc'];
$kodeAskes 		= 	$_POST['kodeAskes'];
$kategori 		= 	$_POST['kategori'];
$inap 			= 	$_POST['inap'];
$struktur_billing = $_POST['struktur_billing'];
$billing_id	= $_POST['billing_id'];
$billing_parent_id	= $_POST['billing_parent_id'];
$billing_kode	= $_POST['billing_kode'];
$billing_level	= $_POST['billing_level'];
//$penunjang = $_POST['penunjang'];


if($aktif!=true)
{
	$aktif=0;
}
else
{
	$aktif=1;
}
$parent_unit=$_POST['kode_unit1'];

if(isset($_POST["btnSimpan"]))
{
		if($_GET['act']=='edit')
		{
			$aa = mysql_fetch_array(mysql_query("select kodeunit from ms_unit where idunit='".$_GET['id']."'"));
			$kode_diri = $aa['kodeunit'];
			
			$cek_kode = "select idunit from ms_unit where kodeunit='$kode_unit' and kodeunit<>'$kode_diri'";
			$jumlahnya = mysql_num_rows(mysql_query($cek_kode));
			if($nama_unit=='')
			{
				$id = $_GET['id'];
				echo "<script>alert('Form masih kosong');location='ms_unit_detail.php?act=edit&id=$id';</script>";
			}
			else if($jumlahnya != 0)
			{
				echo "<script>alert('Kode untuk unit tersebut sudah ada')</script>";
			}
			else
			{
				$up="UPDATE ms_unit SET kodeunit=REPLACE(kodeunit,'$kode_unit_lama','$kode_unit'),namaunit='$nama_unit',nickunit='$nickunit',parentunit='$parent',level='$lvl',aktif='$aktif',rc='$rc',kodeAskes='$kodeAskes',kategori='$kategori',inap='$inap',struktur_billing='$struktur_billing',billing_id='$billing_id',billing_parent_id='$billing_parent_id',billing_kode='$billing_kode',billing_level='$billing_level' WHERE idunit='".$_GET['id']."'"; //echo $up;
				$u=mysql_query($up);
				
				mysql_query("UPDATE ms_unit SET kodeunit=REPLACE(kodeunit,'$kode_unit_lama','$kode_unit') where kodeunit like '$kode_unit_lama%'");
				//$dt = ;
				
				if($u)
				{
					if($parent_unit!='')
					{
						$up2="UPDATE ms_unit SET islast='0' WHERE id='$parent'"; //echo $up2;
						mysql_query($up2);
					}
					echo "<script>alert('Berhasil Diubah....');location='ms_unit.php';</script>";
				}
				else
				{
					echo "<script>alert('Gagal..')</script>";
				}
			}
		}
		else
		{
			$cek_kode = "select idunit from ms_unit where kodeunit='$kode_unit'";
			$jumlahnya = mysql_num_rows(mysql_query($cek_kode));

			if($nama_unit=='')
			{
				echo "<script>alert('Form masih kosong');location='ms_unit.php';</script>";
			}
			else if($jumlahnya != 0)
			{
				echo "<script>alert('Kode untuk unit tersebut sudah ada')</script>";
			}
			else 
			{
				$ins="INSERT INTO ms_unit (kodeunit,namaunit,nickunit,parentunit,level,aktif,rc,kodeAskes,kategori,inap,struktur_billing,billing_id,billing_parent_id,billing_kode,billing_level) VALUES ('$kode_unit','$nama_unit','$nickunit','$parent','$lvl','$aktif','$rc','$kodeAskes','$kategori','$inap','$struktur_billing','$billing_id','$billing_parent_id','$billing_kode','$billing_level')";// echo $ins;
				$i=mysql_query($ins);
				
				if($i)
				{
					if($parent_unit!='')
					{
						$up2="UPDATE ms_unit SET islast='0' WHERE id='$parent'"; //echo $up2;
						mysql_query($up2);
					}
					echo "<script>alert('Berhasil Ditambah....');location='ms_unit.php';</script>";
				}
				else
				{
					echo "<script>alert('Gagal..')</script>";
				}
			}
		}
}

if($_GET['act']=='edit'){
	/*$sql="SELECT a.*,b.namaunit AS billing_parent_nama,b.billing_kode as billing_parent_kode FROM ms_unit as a left join ms_unit as b on b.billing_id=a.billing_parent_id WHERE a.idunit='".$_GET['id']."'";*/
	//$id = $_REQUEST['id'];
	$sql = "SELECT a.*,b.nama AS billing_parent_nama,b.kode AS billing_parent_kode  FROM (SELECT * FROM ms_unit WHERE idunit='$id')AS a LEFT JOIN rspelindo_billing.b_ms_unit AS b ON a.billing_parent_id=b.id";
	$rs2=mysql_query($sql);
	$data=mysql_fetch_array($rs2);
	$aktif=$data['aktif'];
	
	$billing_id = $data['billing_id'];
	$billing_parent_id = $data['billing_parent_id'];
	$billing_level = $data['billing_level'];
}
?><head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<!--<script src="../js/jquery-1.7.2.js"></script>-->
	<script type="text/javascript" language="JavaScript" src="../theme/js/mod.js"></script>
	<link type="text/css" rel="stylesheet" href="../default.css"/>
	<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
	<title>.: Data Unit :.</title>
</head>



<style>
input[type='text'],select,textarea{
padding:3px 4px;
border:1px solid #999999;
margin:1px;
}
.sembunyi{
display:none;
}
</style>
<body>
<div id="wrapper">
        <div id="header">
			<?php include("../inc/header.php");?>
        </div>
            
		<div id="topmenu">
            <?php include("../inc/menu/menu.php"); ?>
        </div>
            
<div id="content">
						<?php
						//include("../header.php");
						$act = $_GET['act'];
						$par = "act=$act";
						if($act == 'edit') {
						$par .= "&idunit=$id";
						$query = "SELECT *
									FROM ms_unit
									WHERE idunit = '$id'";//echo $query;
						$rs = mysql_query($query);
						$rows = mysql_fetch_array($rs);
						
						
						$query1 = "SELECT *
								FROM ms_unit
								WHERE idunit = '".$data["parentunit"]."'";
						$rs1 = mysql_query($query1);
						$rows1 = mysql_fetch_array($rs1);
						}
						?>
<form action="" method="post" id="form1" name="form1">
<table align="center" bgcolor="#FFFFFF" width="1000" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td align="center" height="300">
		<table width="581"  border="0" cellspacing="0" cellpadding="2" align="center">
		<tr>
			<td height="30" colspan="2" valign="bottom" align="right">
				<button type="button" class="Enabledbutton" id="backbutton" onClick="location='<?php echo $back_addr ?>'" title="Back" style="cursor:pointer"><img alt="back" src="../images/backsmall.gif" width="22" height="22" border="0" align="absmiddle" />Back to List</button>
				<button class="Enabledbutton" type="submit" id="btnSimpan" name="btnSimpan" onClick="return simpan()" title="Save" style="cursor:pointer"><img alt="save" src="../images/savesmall.gif" width="22" height="22" border="0" align="absmiddle" />Save Record</button>
				<button class="Disabledbutton" id="undobutton" onClick="location='<?php echo $_SERVER['REQUEST_URI'];?>'" title="Cancel / Refresh" style="cursor:pointer"><img alt="undo/refresh" src="../images/undosmall.gif" width="22" height="22" border="0" align="absmiddle" />Undo/Refresh</button>			</td>
		</tr>
		<tr>
				<td colspan="2" height="28" class="header">.: Data Unit :.</td>
		</tr>
		<tr>
			<td width="27%" height="20" class="label">&nbsp;Induk Unit</td>
			<td width="73%" class="content">&nbsp;
			<input type="hidden" id="induk" name="induk" readonly="readonly" value="<?php echo $rows1['idunit']; ?>" size="5" maxlength="10" />
			<input type="text" id="kode_unit1" name="kode_unit1" readonly="readonly" value="<?php echo $rows1['kodeunit'] ?>" size="15">
			<input type="hidden" id="kode_unit1_lama" name="kode_unit1_lama" readonly="readonly" value="<?php echo $rows1['kodeunit'] ?>" size="15">
			<input type="text" id="nama_unit1" name="nama_unit1" readonly="readonly" value="<?php echo $rows1['namaunit']; ?>" size="30" maxlength="75" />
            
			<img alt="tree" title='Struktur tree kode unit' style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absbottom"onClick="OpenWnd('ms_unit_treeup.php?act=<?=$act; ?>&par=induk*kode_unit1*nama_unit1*lvl*kode_unit',800,500,'msma',true);">			</td>
		</tr>
		<tr>
			<td height="20" class="label">&nbsp;Kode Unit</td>
			<td class="content">&nbsp;
				
				<input type="text" id="kode_unit" name="kode_unit" value="<?php echo $data['kodeunit']; ?>" maxlength="50" />
				<input type="text" id="kode_unit_lama" name="kode_unit_lama" value="<?php echo $data['kodeunit']; ?>" maxlength="50" readonly="readonly" />			</td>
		</tr>
		
		    <tr>
			<td height="20" class="label">&nbsp;Nama Unit</td>
			<td class="content">&nbsp;
				<input type="text" id="nama_unit" name="nama_unit"  value="<?php echo $data['namaunit']; ?>" size="54" maxlength="75" />			</td>
		</tr>
		<tr>
			<td height="20" class="label">&nbsp;Nick unit </td>
			<td class="content">&nbsp;
				<input type="text" id="nickunit" name="nickunit" value="<?php echo $data['nickunit'] ?>" size="54" maxlength="75"/>
			<td>		</tr>
		<tr>
			<td height="20" class="label">&nbsp;Level</td>
			<td class="content">&nbsp;
			<input type="text" id="lvl" name="lvl" value="<?php echo $data ['level']; ?>" size="10" maxlength="10"/>		</tr>
		<tr>
			<td height="20" class="label">&nbsp;Aktif</td>
			<td class="content">&nbsp;
				<input type="checkbox" id="aktif" name="aktif" <?php if($aktif==1) echo "checked=checked"; ?> checked="checked" />			</td>
		</tr>
		<tr>
		  <td height="20" class="label">&nbsp;rc</td>
		  <td class="content">&nbsp;
		    <input type="text" id="rc" name="rc" value="<?php echo $data ['rc']; ?>" size="10" maxlength="10"/></td>
		  </tr>
		<tr>
		  <td height="20" class="label">&nbsp;Kategori</td>
		  <td class="content">&nbsp;
		  <!--<select id="kategori" name="kategori" onChange="setCakupan(this.value); get_id_billing(this.value);" class="txtinput">-->
		  <select id="kategori" name="kategori"  class="txtinput" onChange="tampil(this.value)">
				<option value="0" <? if($data['kategori']==NULL) echo "selected";?>>Non Farmasi/YanMed</option>
				<option value="1" <? if($data['kategori']==1) echo "selected";?>>Loket (YanMed)</option>
				<option value="2" <? if($data['kategori']==2) echo "selected";?>>Pelayanan (YanMed)</option>
				<option value="3" <? if($data['kategori']==3) echo "selected";?>>Administrasi (YanMed)</option>
				<option value="4" <? if($data['kategori']==4) echo "selected";?>>Kasir (YanMed)</option>
				<option value="6" <? if($data['kategori']==6) echo "selected";?>>Gudang Farmasi (Farmasi)</option>
				<option value="7" <? if($data['kategori']==7) echo "selected";?>>Apotek (Farmasi)</option>
				<option value="8" <? if($data['kategori']==8) echo "selected";?>>Controller (Farmasi)</option>
				<option value="9" <? if($data['kategori']==9) echo "selected";?>>Floor Stock (Farmasi)</option>
				<option value="10" <? if($data['kategori']==10) echo "selected";?>>Produksi (Farmasi)</option>
				<option value="11" <? if($data['kategori']==11) echo "selected";?>>Komite Farmasi (Farmasi)</option>
				<option value="12" <? if($data['kategori']==12) echo "selected";?>>Kasir (Farmasi)</option>
            </select>		    </td>
		  </tr>
		</table>
	    <br>
	    <table width="580" border="0" cellpadding="2" cellspacing="0" id="xx" style="display:block;">
          <tr>
				<td colspan="2" height="28" class="header">Unit Billing </td>
		</tr>
          <tr>
		  <td width="150" height="20" class="label">Induk Billing </td>
		  <td width="422" class="content">&nbsp;
		    <input type="hidden" id="billing_parent_id" name="billing_parent_id" readonly="readonly" value="<?php echo $data['billing_parent_id']; ?>" size="5" maxlength="10" /> 
		  <input type="text" id="billing_parent_kode" name="billing_parent_kode" readonly="readonly" value="<?php echo $data['billing_parent_kode']; ?>" size="5" maxlength="10" />
		  <input type="hidden" id="billing_parent_kode_lama" name="billing_parent_kode_lama" readonly="readonly" value="<?php echo $data['billing_parent_kode']; ?>" size="5" maxlength="10" />
		  <input type="text" id="billing_parent_nama" name="billing_parent_nama" readonly="readonly" value="<?php  echo $data['billing_parent_nama']; ?>" size="30" maxlength="75" />
		  <img alt="tree" title='Struktur tree kode unit' style="cursor:pointer" border=0 src="../images/view_tree.gif" align="absbottom"onClick="OpenWnd('ms_unit_billing_treeup.php?act=<?=$act; ?>&billing_id=<?=$data['billing_id'];?>&par=billing_parent_id*billing_parent_kode*billing_parent_nama',800,500,'msma',true);">		  </td>
		</tr>
		<tr>
		  <td height="20" class="label">Kode Billing </td>
		  <td class="content">&nbsp; 
		  <input type="hidden" id="billing_id" name="billing_id" value="<?php echo $data['billing_id']; ?>" size="5" readonly="readonly" />
		  <input type="text" id="billing_kode" name="billing_kode" value="<?php echo $data['billing_kode']; ?>" maxlength="50" readonly="readonly" />
		  <input type="hidden" id="billing_kode_lama" name="billing_kode_lama" value="<?php echo $data['billing_kode']; ?>" size="5" readonly="readonly" />
		  </td>
		</tr>
		<tr>
		  <td height="20" class="label">Level</td>
		  <td class="content">&nbsp;
		    <input type="text" id="billing_level" name="billing_level" value="<?php echo $data['billing_level']; ?>" size="5" /></td>
		  </tr>
		<tr>
		  <td height="20" class="label">&nbsp;Kode Askes</td>
		  <td class="content">&nbsp; 
		  <input type="text" id="kodeAskes" name="kodeAskes" value="<?php echo $data['kodeAskes'] ?>" size="30" maxlength="75"/>		  </td>
		  </tr>
		<tr>
		  <td height="20" class="label">Status Inap </td>
		  <td class="content">&nbsp;  
		  <label><input type="radio" id="inap1" name="inap" value="1" <? if($data['inap']==1) echo "checked='checked'";?>/> Ya</label>&nbsp;&nbsp;&nbsp;
          <label><input type="radio" id="inap0" name="inap" value="0" <? if($data['inap']!=1) echo "checked='checked'";?> /> Tidak</label></td>
		  </tr>
		<tr>
		  <td height="20" class="label">Struktur Billing </td>
		  <td class="content">&nbsp;
		    <input type="text" id="struktur_billing" name="struktur_billing" value="<?php echo $data ['struktur_billing']; ?>" size="10" maxlength="10"/></td>
		  </tr>
		
		<tr>
			<td colspan="2" class="headerBawah">&nbsp;</td>
		</tr>
        </table>
	</td>
</tr>
<tr>
	<td colspan="2" height="28" background="../images/main-bg.png" style="background-repeat:repeat-x;">&nbsp;</td>
</tr>
</table>
</form>
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

</div>
</body>
<script src="../js/jquery-1.7.2.js"></script>
<script type="text/javascript">	
function simpan()
{
	
	if(document.getElementById('kode_unit').value=='' || document.getElementById('nama_unit').value=='')
	{
		alert('Form belum lengkap');return false;
	}
	if(document.getElementById('billing_id').value!='' && document.getElementById('billing_id').value!=0)
	{
		if(document.getElementById('kategori').value==0 || document.getElementById('kategori').value>4)
		{
			alert('Pilih kategori (YanMed)');return false;
		}
		else
		{
			document.forms[0].submit;
		}
	}
	if(document.getElementById('kode_unit').maxLength=2)
	{
		document.forms[0].submit;
	}
	
}

/*function get_kode_anak(kode,lvl,kode_parent_awal,kode_unit_awal)
{
	var url = "get_kode_anak.php?kode="+kode+"&lvl="+lvl+"&kode_parent_awal="+kode_parent_awal+"&kode_unit_awal="+kode_unit_awal; //alert(url);
	$.get(url,function(aa){
	//alert(aa);
	document.getElementById('kode_unit').value = aa;
	});
}*/
function get_kode_anak(act,kode,lvl)
{
	//alert(act);
	var kode_lama = $("#kode_unit1_lama").val(); //alert(kode_lama)
	if(act=='add')
	{
		var url = "get_kode_anak.php?kode="+kode+"&lvl="+lvl; //alert(url);
		$.get(url,function(aa){
		//alert(aa);
		document.getElementById('kode_unit').value = aa;
		});
	}
	if(act=='edit')
	{
		if(kode_lama != kode)
		{
			var url = "get_kode_anak.php?kode="+kode+"&lvl="+lvl; //alert(url);
			$.get(url,function(aa){
			//alert(aa);
			document.getElementById('kode_unit').value = aa;
			});
		}
		else
		{
			
			document.getElementById('kode_unit').value = document.getElementById('kode_unit_lama').value;
		}
	}
}


function get_id_billing(act,kodeparent,lvl)
{
		//alert(kode+'-'+lvl);	
		var billing_id = document.getElementById('billing_id').value;
		if(act=='add')
		{
			var url = "get_id_billing.php"; //alert(url);
			$.get(url,function(aa){
			//alert(aa);
			document.getElementById('billing_id').value = aa;
			});
		}
		if(act=='edit' && billing_id==0)
		{
			var url = "get_id_billing.php"; //alert(url);
			$.get(url,function(aa){
			//alert(aa);
			document.getElementById('billing_id').value = aa;
			});
		}
		
		if($("#billing_parent_kode_lama").val()==kodeparent)
		{
			var lama = $("#billing_kode_lama").val()
			$("#billing_kode").val(lama);
		}
		else
		{
			
		
			var url = "get_kode_billing.php?kode="+kodeparent; //alert(url);
			$.get(url,function(bb){
			//alert(bb);
			//document.getElementById('billing_kode').value = kodeparent+bb;
			document.getElementById('billing_kode').value = bb;
			document.getElementById('billing_level').value = 2;
			});
		}
	
}

function get_id_billing2(val,lvl)
{
	//alert(lvl);
	/*if(document.getElementById('billing_id').value == "")//pas edit
	{*/
		//alert(val);
		if(val != 0)
		{
			<?
			if($_REQUEST['act']=='add')
			{
			?>
				var url = "get_id_billing.php"; //alert(url);
				$.get(url,function(aa){
				//alert(aa);
				document.getElementById('billing_id').value = aa;
				});
			<?php
			}
			?>
			document.getElementById('billing_level').value = parseInt(lvl)+1;;
			
		}
		else
		{
			<?
			if($_REQUEST['act']=='add')
			{
			?>
			document.getElementById('billing_id').value = '';
			document.getElementById('billing_level').value = '';
			<?
			}
			?>
			
		}
		
	/*}*/
	
}
function tampil(val)
{
	//alert(val);
	if(val==1 || val==2 || val==3 || val==4)
	{
		//$(".sembunyi").show();
		//document.getElementsByClassName("sembunyi").style.display = "block";
		document.getElementById("xx").style.display = "block";
	}
	else
	{
		document.getElementById("xx").style.display = "none";
		$("#inap0").attr("checked","checked");
	}
}
</script>
</html>
