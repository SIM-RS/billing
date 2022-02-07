<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../theme/simkeu.css" rel="stylesheet" type="text/css" />
<title></title>
</head>
<?php
	include("../koneksi/konek.php");
    $act = $_REQUEST['act'];
    $id = $_REQUEST['id'];
	$kode = $_REQUEST['txtkode'];
    $uraian = $_REQUEST['txturaian'];
    $level = $_REQUEST['txtlevel'];
    $kelompok = $_REQUEST['txtkelompok'];
    $kategori = $_REQUEST['txtkategori'];
    $formula = $_REQUEST['txtformula'];
    // $kode2 = $_REQUEST['txtkode2'];
    // $dk = $_REQUEST['cmbdk'];
	// if($dk==0){ $ndk="D"; } else { $ndk="K";}
	$kodedebit = $_REQUEST['txtkodedebit'];
    $kodekredit = $_REQUEST['txtkodekredit'];
	$tipe = $_REQUEST['cmbtipe'];
$page=$_REQUEST["page"];
	
    
	
	switch($act){
		case "save":
			$qry=mysql_query("select * from lap_arus_kas where kode ='$kode'");
			if($hs=mysql_fetch_array($qry)>0){
				echo "<script>alert('Maaf Kode yang anda masukan sudah ada dalam database');</script>";
			}else{
				// $sql="insert into lap_arus_kas(kode,uraian,level,kelompok,kategori,formula,kode_ma_sak,d_k,type) values ('$kode','$uraian','$level','$kelompok','$kategori','$formula','$kode2','$ndk','$tipe')";
				$sql="insert into lap_arus_kas(kode,uraian,level,kelompok,kategori,formula,debit,kredit,type) values ('$kode','$uraian','$level','$kelompok','$kategori','$formula','$kodedebit','$kodekredit','$tipe')";
				echo $sql;
				$rs=mysql_query($sql);
			}
		break;
		case "edit":
			$sql="update lap_arus_kas set kode='$kode', uraian='$uraian', level='$level', kelompok='$kelompok', kategori='$kategori', formula='$formula', debit='$kodedebit', kredit='$kodekredit', type='$tipe' where id_lap_arus_kas='$id'";
			$rs=mysql_query($sql);
		break;
		case "delete":
			$sql="delete from lap_arus_kas where id_lap_arus_kas='$id'";
			$rs=mysql_query($sql);
		break;
	}
?>
<body>

<div align="center" style="margin-top:10px;">
<form name="form1" method="post">
<input name="act" id="act" type="hidden" value="save" />
<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
<div id="det" style="display:none">
	<table width="980" border="0" cellpadding="0" cellspacing="5" class="txtinput">
		<tr>
			<td colspan="2" class="jdltable">Laporan Arus Kas</td>
		</tr>
		<tr>
			<td width="10%" class="txtinput">Kode</td>
			<td width="90%">:&nbsp;<input id="id" name="id" type="hidden" /><input id="txtkode" name="txtkode" class="txtinput" /></td>
		</tr>
		<tr>
			<td class="txtinput">Uraian</td>
			<td>:&nbsp;<textarea id="txturaian" name="txturaian" cols="65" rows="3" class="txtinput"></textarea> </td>
		</tr>
		<tr>
			<td class="txtinput">Level</td>
			<td>:&nbsp;<input id="txtlevel" name="txtlevel" size="4" class="txtinput" /></td>
		</tr>
		<tr>
			<td class="txtinput">Kelompok</td>
			<td>:&nbsp;<input id="txtkelompok" name="txtkelompok" size="4" class="txtinput" /></td>
		</tr>
		<tr>
			<td class="txtinput">Kategori</td>
			<td>:&nbsp;<input id="txtkategori" name="txtkategori" size="4" class="txtinput" /></td>
		</tr>
		<tr>
			<td class="txtinput">Formula</td>
			<td>:&nbsp;<input id="txtformula" name="txtformula" size="12" class="txtinput" /></td>
		</tr>
		<!-- <tr>
			<td class="txtinput">Kode MA SAK</td>
			<td>:&nbsp;<textarea id="txtkode2" name="txtkode2" cols="65" rows="2" class="txtinput"></textarea></td>
		</tr> -->
		<tr>
			<td class="txtinput">Kode MA SAK (Debit)</td>
			<td>:&nbsp;<textarea id="txtkodedebit" name="txtkodedebit" cols="65" rows="2" class="txtinput"></textarea></td>
		</tr>
		<tr>
			<td class="txtinput">Kode MA SAK (Kredit)</td>
			<td>:&nbsp;<textarea id="txtkodekredit" name="txtkodekredit" cols="65" rows="2" class="txtinput"></textarea></td>
		</tr>
		<!-- <tr>
			<td class="txtinput">D/K</td>
			<td>:&nbsp;<select id="cmbdk" name="cmbdk" class="txtinput">
				<option value="0">Debit</option>
				<option value="1">Kredit</option>
			</select></td>
		</tr> -->
		<tr>
			<td class="txtinput">Type</td>
			<td>:&nbsp;<select id="cmbtipe" name="cmbtipe" class="txtinput">
				<option value="0">0</option>
				<option value="1">1</option>
			</select></td>
		</tr>
		<tr>
			<td height="40" colspan="2" align="center" valign="bottom"><BUTTON type="button" onClick="document.form1.submit();"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</BUTTON>
        � <BUTTON type="reset" onClick="location='?f=../master/lap_arus_kas'"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;<strong>Reset</strong>&nbsp;&nbsp;&nbsp;&nbsp;</BUTTON>
		</td>
		</tr>
	</table>
	</div>
	<div id="view" style="display:block">
	<table width="980" border="0" cellpadding="0" cellspacing="0" class="txtinput">
		<tr>
    <td colspan="12" align="right"><button type="button" name="tambah" id="tambah" onClick="document.getElementById('det').style.display='block';fSetValue(window,'act*-*save*|*txtkode*-**|*txturaian*-**|*txtlevel*-**|*txtkelompok*-**|*txtkategori*-**|*txtformula*-**|*txtkode2*-**|*txtkodedebit*-**|*txtkodekredit*-**|*cmbdk*-**|*cmbtipe*-*');"><img src="../icon/add.gif" height="16" width="16">&nbsp;Tambah</button></td>
	</tr>
	<tr class="headtable">
		<td height="20" class="tblheaderkiri" width="5%">No</td>
		<td class="tblheader" width="8%">Kode</td>
		<td class="tblheader" width="20%">Uraian</td>
		<td class="tblheader" width="8%">Level</td>
		<td class="tblheader" width="10%">Kelompok</td>
		<td class="tblheader" width="10%">Kategori</td>
		<td class="tblheader" width="10%">Formula</td>
		<td class="tblheader" width="10%">Kode MA SAK (Debit)</td>
		<td class="tblheader" width="10%">Kode MA SAK (Kredit)</td>
		<!-- <td class="tblheader" width="6%">D/K</td> -->
		<td class="tblheader" width="5%">Type</td>
		<td colspan="2" class="tblheader">Proses</td>
	</tr>
	<? $qry="SELECT id_lap_arus_kas AS id, kode, uraian, LEVEL, kelompok, kategori, formula, kode_ma_sak, IF(d_k='K','Kredit','Debit') AS d_k, debit, kredit, TYPE FROM lap_arus_kas ORDER BY kode
";
		$rs=mysql_query($qry);
		$jmldata=mysql_num_rows($rs);
		if($rs == FALSE){
			echo mysql_error();
		}
		if ($page=="") $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$qry=$qry." limit $tpage,$perpage";

	 	$rs=mysql_query($qry);
	 	$i=($page-1)*$perpage;
	 	$arfvalue="";
		while($rows=mysql_fetch_array($rs)){
		$i++;
		$arfvalue="act*-*edit*|*id*-*".$rows['id']."*|*txtkode*-*".$rows['kode']."*|*txturaian*-*".$rows['uraian']."*|*txtlevel*-*".$rows['LEVEL']."*|*txtkelompok*-*".$rows['kelompok']."*|*txtkategori*-*".$rows['kategori']."*|*txtformula*-*".$rows['formula']."*|*txtkodedebit*-*".$rows['debit']."*|*txtkodekredit*-*".$rows['kredit']."*|*cmbtipe*-*".$rows['TYPE'];
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
	  	
		$arfhapus="act*-*delete*|*id*-*".$rows['id'];?>
	<tr class="itemtable">
		<td class="tdisikiri" align="center"><?php echo $i;?></td>
		<td class="tdisi"><?php echo $rows[kode];?>&nbsp;</td>
		<td class="tdisi" style="text-align:left; padding-left:5px;"><?php echo $rows[uraian];?>&nbsp;</td>
		<td class="tdisi"><?php echo $rows[LEVEL];?>&nbsp;</td>
		<td class="tdisi"><?php echo $rows[kelompok];?>&nbsp;</td>
		<td class="tdisi"><?php echo $rows[kategori];?>&nbsp;</td>
		<td class="tdisi"><?php echo $rows[formula];?>&nbsp;</td>
		<td class="tdisi"><?php $eks=explode(',',$rows[debit]); for($a=0;$a<count($eks);$a++) echo $eks[$a]."<br/>";?>&nbsp;</td>
		<td class="tdisi"><?php $eks=explode(',',$rows[kredit]); for($a=0;$a<count($eks);$a++) echo $eks[$a]."<br/>";?>&nbsp;</td>
		<!-- <td class="tdisi"><?php echo $rows[d_k];?>&nbsp;</td> -->
		<td class="tdisi"><?php echo $rows[TYPE];?>&nbsp;</td>
		<!-- <?php echo $arfvalue; ?> -->
        <td class="tdisi" align="center" width="4%"><img src="../icon/addcommentButton.jpg" height="16" width="16" onClick="document.getElementById('det').style.display='block';document.getElementById('view').style.display='block';fSetValue(window,'<?php echo $arfvalue; ?>');"></td>
		<td class="tdisi" align="center" width="4%"><img src="../icon/hapus.gif" width="16" height="16" onClick="if (confirm('Yakin Ingin Menghapus Data?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}"></td>
	</tr><? }?>
	<tr> 
        <td colspan="4" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
            <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
        <td colspan="3" align="left" class="textpaging">Ke Halaman: 
          <input type="text" name="keHalaman" id="keHalaman" class="txtinput" size="1"> 
          <button type="button" onClick="act.value='paging';page.value=keHalaman.value;document.form1.submit();"><IMG SRC="../icon/go.png" border="0" width="10" height="15" ALIGN="absmiddle"></button></td>
        <td colspan="4" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
          <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
          <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
          <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;        </td>
      </tr>
	</table>
	</div>
	</form>
</div>
</body>
</html>
