<?php 
include("../sesi.php");
// Koneksi =================================
include("../koneksi/konek.php");
//============================================

$act=$_REQUEST['act'];

convert_var($act);

if(isset($act)){
	$id=$_REQUEST['id'];
	$kategori=$_REQUEST['kategori'];
	
	convert_var($id,$kategori);
	
	if($act == 'edit')
		$sql = "update a_obat_kategori set kategori = '{$kategori}' where id = {$id}";
	elseif($_REQUEST['act'] == 'del')
		$sql = "delete from a_obat_kategori where id = {$id}";
	else
		$sql = "insert into a_obat_kategori (kategori) values('{$kategori}')";
		
	mysqli_query($konek,$sql);
}

//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="kategori desc";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

convert_var($page,$sorting,$filter);
//===============================


?>
<html>
<head>
<title>Master Apotik <?=$namaRS;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<script language="JavaScript" src="../theme/js/mod.js"></script>
<SCRIPT language="JavaScript" src="../theme/js/tip.js"></SCRIPT>
<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />
</head>
<body>
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort1.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
<div align="center">
	<div id="input" style="display:none">
		<form name="form1" method="post" action="">
			<input name="act" id="act" type="hidden" value="">
			<input name="id" id="id" type="hidden" value="">
			<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
			<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
			<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
			<p class="jdltable">INPUT KATEGORI OBAT</p>
			<table width="550" border="0" cellpadding="1" cellspacing="1" class="txtinput">
				<tr> 
					<td width="150">Kategori Obat</td>
					<td>:</td>
					<td><input name="kategori" type="text" id="kategori" class="txtinput" size="30"></td>
				</tr>
				<tr>
					<td colspan="2"></td>
					<td>
						<BUTTON type="button" onClick="if (ValidateForm('kategori','ind')){document.form1.submit();}">
							<img src="../icon/save.gif" border="0" width="16" height="16" align="absmiddle">
							&nbsp;Simpan
						</BUTTON>
						<BUTTON type="reset" onClick="document.getElementById('input').style.display='none';document.getElementById('listma').style.display='block';fSetValue(window,'id*-**|*kategori*-*');">
							<IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">
							&nbsp;Batal&nbsp;&nbsp;&nbsp;&nbsp;
						</BUTTON>
					</td>
				</tr>
			</table>
		</form>
	</div><br/><br/>
	
	<div id="listma" style="display:block">
		<span class="jdltable">DAFTAR OBAT</span><br/><br/>
		<div align="right" style="width: 550px;">
			<button onClick="document.getElementById('input').style.display='block'; fSetValue(window,'act*-**|*id*-**|*kategori*-*')" type="button">
				<img width="16" height="16" border="0" align="absmiddle" src="../icon/add.gif">
				Tambah
			</button>
		</div>
		<table width="550" border="0" cellpadding="1" cellspacing="0">
			<tr class="headtable">
				<td id="id" width="30" class="tblheaderkiri" onClick="ifPop.CallFr(this);">No</td>
				<td class="tblheader" width="500" id="kategori" onClick="ifPop.CallFr(this);">Kategori Obat</td>
				<td class="tblheader" width="20" colspan="2">Proses</td>
			</tr>
			<?php 
			if ($filter!=""){
				$tfilter=explode("*-*",$filter);
				$filter="";
				for ($k=0;$k<count($tfilter);$k++){
					$ifilter=explode("|",$tfilter[$k]);
					$filter .=" and ".$ifilter[0]." like '%".$ifilter[1]."%'";
				}
			}
			if ($sorting=="") $sorting=$defaultsort;
			$sql = "select * from a_obat_kategori where 1 ".$filter." ORDER BY ".$sorting;
			$rs=mysqli_query($konek,$sql);
			echo mysqli_error($konek);
			$jmldata=mysqli_num_rows($rs);
			if ($page=="") $page="1";
			$perpage=50;$tpage=($page-1)*$perpage;
			if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
			if ($page>1) $bpage=$page-1; else $bpage=1;
			if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
			$sql=$sql." limit $tpage,$perpage";

			$rs=mysqli_query($konek,$sql);
			$i=($page-1)*$perpage;
			$arfvalue="";
			while ($rows=mysqli_fetch_array($rs)){
				$i++;		
				$arfvalue="act*-*edit*|*id*-*".$rows['id']."*|*kategori*-*".$rows['kategori'];
				$arfvalue=str_replace('"',chr(3),$arfvalue);
				$arfvalue=str_replace("'",chr(5),$arfvalue);
				$arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
				?>
				<input type="hidden" id="arf<?php echo $i; ?>" value="<?php echo $arfvalue; ?>" />
				<tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
					<td class="tdisikiri"><?php echo $i; ?></td>
					<td class="tdisi" align="left"><?php echo $rows['kategori']; ?></td>
					<td width="22" class="tdisi">
						<img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block'; fSetValue(window,document.getElementById('arf<?php echo $i; ?>').value);">
					</td>
					<td width="22" class="tdisi">
						<img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data?')){fSetValue(window,'act*-*del*|*id*-*<?php echo $rows['id']; ?>');document.form1.submit();}">
					</td>
				</tr>
				<?php 
			}
			mysqli_free_result($rs);
			?>
			<tr> 
				<td colspan="3">
					<table width="100%">
						<tr>
							<td align="left" class="textpaging">
								Halaman <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?>
							</td>
							<td align="right">
								<img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
								<img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
								<img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"><img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
</div>
</body>
</html>
<?php 
mysqli_close($konek);
?>