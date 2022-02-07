<?
include("../koneksi/konek.php");
$PATH_INFO="?".$_SERVER['QUERY_STRING'];
$_SESSION["PATH_INFO"]=$PATH_INFO;
$qstr_ma="par=kode_ma2*mainduk";
$qstr_ma_sak="par=parent*kode_ma_sak*mainduk2*parent_lvl";
$_SESSION["PATH_MS_MA"]="?".$qstr_ma;
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$act=$_REQUEST['act'];
$id=$_REQUEST['id'];
$nama=$_REQUEST['nama'];
$parent=$_REQUEST['parent'];
$kode_ma_sak=$_REQUEST['kode_ma_sak'];
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="id_client";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
//Melakukan proses menyimpan, mengupdate dan mengedit
switch($act){
	case "save":
		$qry=mysql_query("select * from m_tipe_jurnal where nama_tipe='$nama'");
		if($hs=mysql_fetch_array($qry)>0){
			echo "<script>alert('Maaf Tipe yang anda masukan sudah ada dalam database');</script>";
		}else{
			$sql="SELECT MAX(id_tipe)+1 as idtipe FROM m_tipe_jurnal";
			$rs=mysql_query($sql);
			$rw=mysql_fetch_array($rs);
			$sql="insert into m_tipe_jurnal(id_tipe,nama_tipe,korek,idrek) values (".$rw['idtipe'].",'$nama','$kode_ma_sak','$parent')";
			//echo $sql."<br>";
			$rs=mysql_query($sql);
		}
	break;
	case "edit":
		$sql="update m_tipe_jurnal set nama_tipe='$nama',korek='$kode_ma_sak',idrek='$parent' where id_tipe='$id'";
		$rs=mysql_query($sql);
	break;
	case "delete":
		$sql="delete from m_tipe_jurnal where id_tipe='$id'";
		$rs=mysql_query($sql);
	break;
}
$qry=mysql_query("select max(id_tipe)+1 idtipe from m_tipe_jurnal");
$hs=mysql_fetch_array($qry);
$idtipe=$hs[idtipe];
?>
<form name="form1" method="post">
	<input name="act" id="act" type="hidden" value="save" />
  	<input name="parent" id="parent" type="hidden" value="<?php echo $parent; ?>">
  	<input name="parent_lvl" id="parent_lvl" type="hidden" value="<?php echo $parent_lvl; ?>">
	<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
    <input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
    <input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
<div id="det" style="display:none">
<table width="90%" border="0" style="font-family:Cambria, Calibri, Verdana;" cellpadding="2" align="center">
	<tr style="visibility:collapse">
		<td>Kode Tipe</td>
		<td align="center">:</td>
		<td><input name="id" id="id" value="<?=$idtipe?>" /></td>
	<tr>
		<td width="19%">Nama Tipe </td>
		<td width="3%" align="center">:</td>
	  <td width="78%"><input name="nama" id="nama" size="50"></td>
	</tr>
        <tr>
          <td>Kode Rekening SAK </td>
          <td align="center">:</td>
          <td valign="middle"><input name="kode_ma_sak" type="text" id="kode_ma_sak" size="20" maxlength="20" style="text-align:center" value="<?=$kode_ma2; ?>" readonly="true" class="txtcenter"> 
            <input type="button" class="txtcenter" name="Button222" value="..." title="Pilih Rekening Induk" onClick="OpenWnd('../master/tree_ma_view_sak.php?<?php echo $qstr_ma_sak; ?>',800,500,'msma',true)"> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="button" name="Button" class="txtcenter" value="Reset" onClick="fSetValue(window,'act*-*save*|*kode_ma_sak*-**|*mainduk2*-**|*kode_ma*-**|*ma*-**|*parent*-**')"></td>
        </tr>
        <tr> 
          <td>Nama Rekening SAK </td>
          <td align="center">: </td>
          <td ><textarea name="mainduk2" cols="50" rows="3" readonly class="txtinput" id="mainduk2"><? echo $_POST[mainduk2];?></textarea></td>
        </tr>
        <tr> 
	<tr>
		<td></td>
		<td></td>
		<td height="50"><button name="simpan" id="simpan" type="button" onClick="if (ValidateForm('nama,kode_ma_sak','ind')){document.form1.submit();}"><img src="../icon/save.gif" width="16" height="16">&nbsp;Simpan</button>&nbsp;<button type="button" name="batal" id="batal" onClick="document.getElementById('det').style.display='none'"><img src="../icon/cancel.gif" width="16" height="16" />&nbsp;Batal&nbsp;</button></td>
	</tr>
</table>
</div>
<div id="view" style="display:block">
<table border="0" width="70%" cellpadding="0" cellspacing="0" align="center">
	<tr>
    <td colspan="7" align="right"><button type="button" name="tambah" id="tambah" onClick="document.getElementById('det').style.display='block';fSetValue(window,'act*-*save*|*nama*-**|*kode_ma_sak*-**|*parent*-**|*mainduk2*-*');document.getElementById('aktif').checked=false"><img src="../icon/add.gif" height="16" width="16">&nbsp;Tambah</button></td>
	</tr>
	<tr class="headtable">
		<td width="5%" height="20" class="tblheaderkiri">No</td>
		<td width="25%" class="tblheader">Nama Tipe</td>
		<td width="11%" class="tblheader">Id Rekening</td>
		<td width="14%" class="tblheader">Kode Rekening</td>
		<td width="37%" class="tblheader">Nama Rekening</td>
		<td colspan="2" class="tblheader">Proses</td>
	</tr>
	<? $qry="select m_tipe_jurnal.*,MA_NAMA from m_tipe_jurnal left join ma_sak on idrek=MA_ID order by id_tipe";
		$rs=mysql_query($qry);
		$jmldata=mysql_num_rows($rs);
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
		$arfvalue="act*-*edit*|*id*-*".$rows['id_tipe']."*|*nama*-*".$rows['nama_tipe']."*|*parent*-*".$rows['idrek']."*|*kode_ma_sak*-*".$rows['korek']."*|*mainduk2*-*".$rows['MA_NAMA'];
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
	  	
		$arfhapus="act*-*delete*|*id*-*".$rows['id_tipe'];?>
	<tr class="itemtable">
		<td class="tdisikiri" align="center"><?=$i;?></td>
		<td class="tdisi"><?=$rows[nama_tipe]?>&nbsp;</td>
		<td class="tdisi"><?=$rows[idrek]?>&nbsp;</td>
		<td class="tdisi"><?=$rows[korek]?>&nbsp;</td>
		<td class="tdisi"><?=$rows[MA_NAMA]?>&nbsp;</td>
        <td width="3%" class="tdisi" align="center"><img style="cursor:pointer" title="Klik Untuk Mengubah" src="../icon/addcommentButton.jpg" height="16" width="16" onClick="document.getElementById('det').style.display='block';document.getElementById('view').style.display='block';fSetValue(window,'<?php echo $arfvalue; ?>');if(document.getElementById('try').value=='1'){document.getElementById('aktif').checked=true;}"></td>
		<td width="5%" class="tdisi" align="center"><img src="../icon/hapus.gif" width="16" height="16" onClick="if (confirm('Yakin Ingin Menghapus Data?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}"></td>
	</tr><? }?></table>
</div>
</form>