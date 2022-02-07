<?php 
include("../sesi.php");

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$idunit = $_SESSION["ses_idunit"];
$namaunit = $_SESSION["ses_namaunit"];
$kodeunit = $_SESSION["ses_kodeunit"];
$iduser = $_SESSION["iduser"];
$unit_tipe = $_SESSION["ses_unit_tipe"];
$kategori = $_SESSION["kategori"];

//Jika Tidak login, maka lempar ke index utk login dulu =========
if (empty ($username) AND empty ($password)){
	//header("Location: ../../index.php");
//	exit();
}
//==============================================================
if ($unit_tipe<>4){
	//header("Location: ../../index.php");
	//exit();
}
include("../koneksi/konek.php");
//============================================
$tgl=gmdate('d-m-Y',mktime(date('H')+7));
$th=explode("-",$tgl);
$tgl2="$th[2]-$th[1]-$th[0]";
//Menangkap field pada form1 dan memperkenalkan untuk melakukan ACT===
$idunit=$_SESSION["ses_idunit"];
$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0")?substr($th[1],1,1):$th[1];
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];
//$minta_id=$_REQUEST['minta_id'];
$spph_id=$_REQUEST['spph_id'];
//====================================================================
//Paging,Sorting dan Filter======
$page=$_REQUEST["page"];
$defaultsort="nama";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];
//===============================
$txtKode = $_REQUEST["kode"];
$txtNama = $_REQUEST["nama"];
$txtIsi = $_REQUEST["isi"];
$txtId = $_REQUEST["txtId"];
switch(strtolower($_REQUEST['act'])){
	case 'simpan':
		$sql1="INSERT INTO a_sop (kode,nama,isi) VALUES ('$txtKode','$txtNama','$txtIsi')";
		//echo $sql1."<br>";
		mysql_query($sql1);
		break;
	case 'update':
		$sql2="UPDATE a_sop SET kode='$txtKode',nama='$txtNama',isi='$txtIsi' WHERE id='$txtId'";
		//echo $sql2."<br>";
		mysql_query($sql2);
		break;
	case 'hapus':
		$sql3="DELETE FROM a_sop WHERE id='$txtId'";
		mysql_query($sql3);
		break;
}
?>
<html>
<head>
<title>Sistem Informasi Manajemen Rumah Sakit</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link type="text/css" rel="stylesheet" href="../theme/mod.css"/>
<script language="JavaScript" src="../theme/js/mod.js"></script>
<script language="JavaScript" src="../theme/js/ajax2.js"></script>
<script language="JavaScript" src="../js/jquery-1.8.3.js"></script>
<!-- TinyMCE -->
<script type="text/javascript" src="../theme/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		skin : "o2k7",
		height : "600",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		content_css : "../include/tinymce/examples/css/word.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "../include/tinymce/examples/lists/template_list.js",
		external_link_list_url : "../include/tinymce/examples/lists/link_list.js",
		external_image_list_url : "../include/tinymce/examples/lists/image_list.js",
		media_external_list_url : "../include/tinymce/examples/lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<!-- /TinyMCE -->
<!--<link rel="stylesheet" href="../theme/apotik.css" type="text/css" />-->
</head>
<body>
<div align="center">
<?php
	//include("../koneksi/konek.php");
	include("../header1.php");
?>
<table width="1000" border="0" cellpadding="0" cellspacing="0" class="hd2">
	<tr>
		<td height="30">&nbsp;MASTER DATA SOP</td>
	</tr>
</table>
<table width="1000" border="0" cellspacing="0" cellpadding="0" class="tabel">
<tr align="center" valign="top">
	<td width="1000" height="470" align="center">
		<iframe height="72" width="130" name="sort"
			id="sort"
			src="../theme/sort.php" scrolling="no"
			frameborder="0"
			style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
		</iframe>
		<div align="center">
		  <form name="form1" method="post" action="">
			<input name="act" id="act" type="hidden" value="simpan">
			<input name="page" id="page" type="hidden" value="<?php echo $page; ?>">
			<input type="hidden" name="sorting" id="sorting" value="<?php echo $sorting; ?>">
			<input type="hidden" name="filter" id="filter" value="<?php echo $filter; ?>">
            <div id="input" style="display:none">
            <table cellpadding="0" cellspacing="0" width="80%">
            <tr>
            	<td width="16%">&nbsp;</td>
                <td width="84%">&nbsp;</td>
            </tr>
            <tr>
            	<td width="16%" colspan="2" align="center"><span class="jdltable">Input Data SOP</span></td>
            </tr>
            <tr>
            	<td width="16%">&nbsp;</td>
                <td width="84%">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">Kode : <input type="hidden" id="txtId" name="txtId"><input type="text" id="kode" name="kode" size="10">&nbsp;&nbsp;Nama : <input type="text" id="nama" name="nama" size="70"></td>
            </tr>
            <tr>
                <td colspan="2" align="center" width="100%">&nbsp;<textarea id="isi" name="isi" rows="15" cols="80" style="width: 100%; height:100%;"></textarea></td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
             
            </tr>
            <tr>
            	<td colspan="2" align="center"><button type="button" id="btnSimpan" name="btnSimpan" onClick="action2()" style="cursor:pointer"><IMG SRC="../icon/save.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Simpan</button>&nbsp;<button type="button" id="btnBatal" name="btnBatal" onClick="batal()" style="cursor:pointer"><IMG SRC="../icon/cancel.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Batal</button></td>
             
            </tr>
            </table>
            </div>
			<div id="listma" style="display:block">
			  <p><span class="jdltable">&nbsp;</span> 
              <table width="80%" cellpadding="0" cellspacing="0" border="0">
				<tr>
				  
				  <td width="530" align="right" colspan="12">
				  <BUTTON type="button" id="btnTambah" onClick="tambah()" style="cursor:pointer"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Buat SOP Baru</BUTTON>
				  </td>
				</tr>
			</table>
			  <table width="80%" border="0" cellpadding="1" cellspacing="0">
                <tr class="headtable"> 
                  <td width="20" height="25" class="tblheaderkiri">No</td>
                  <td id="kode" width="30" class="tblheader" onClick="ifPop.CallFr(this);">Kode</td>
                  <td id="nama" width="200" class="tblheader" onClick="ifPop.CallFr(this);">Nama SOP</td>
                  <td colspan="3" class="tblheader">Proses</td>
                </tr>
                <?php 
			  if ($filter!=""){
				$filter=explode("|",$filter);
				$filter=" where ".$filter[0]." like '%".$filter[1]."%'";
			  }
			  if ($sorting=="") $sorting=$defaultsort;
			  $sql="select * from a_sop ".$filter." order by ".$sorting;
			  //echo $sql."<br>";
				$rs=mysql_query($sql);
				$jmldata=mysql_num_rows($rs);
				if ($page=="" || $page=="0") $page="1";
				$perpage=50;$tpage=($page-1)*$perpage;
				if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
				if ($page>1) $bpage=$page-1; else $bpage=1;
				if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
				$sql=$sql." limit $tpage,$perpage";
				//echo $sql."<br>";
			  $rs=mysql_query($sql);
			  $i=($page-1)*$perpage;
			  while ($rows=mysql_fetch_array($rs)){
				$i++;
				$arfvalue="act*-*update*|*txtId*-*".$rows['id']."*|*kode*-*".$rows['kode']."*|*nama*-*".$rows['nama'];
				$arfhapus="act*-*hapus*|*txtId*-*".$rows['id']."*|*kode*-*".$rows['kode']."*|*nama*-*".$rows['nama'];
			  ?>
                <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
                  <td class="tdisikiri"><?php echo $i; ?></td>
                  <td class="tdisi" align="center"><?php echo $rows['kode']; ?></td>
                  <td align="left" class="tdisi"><?php echo $rows['nama']; ?></td>
                  <td width="10" class="tdisi"><img src="../icon/lihat.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Melihat Detail SOP" onClick="NewWindow('view_sop.php?id=<?php echo $rows['id']; ?>','name','900','500','yes');return false"></td>
                  <td width="10" class="tdisi" lang="<?php echo $rows['id']."|".$rows['kode']."|".$rows['nama']; ?>"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="fSetValue(window,'<?php echo $arfvalue; ?>');fedit(<?php echo $rows['id']; ?>);"></td>
                  <td width="10" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="fSetValue(window,'<?php echo $arfhapus; ?>');hapus(<?php echo $rows['id']; ?>)"></td>
                </tr>
                <?php 
			  }
			  ?>
                <tr> 
                  <td colspan="2" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
                      <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
                  <td align="right" colspan="4"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
                    <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
                    <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
                    <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp; 
                  </td>
                </tr>
              </table>
			</div>
		</form>
		</div>
	</td>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="hd2" width="1000">
  <tr height="30">
   	<td width="20%">&nbsp;<input type="button" value="&nbsp;&nbsp;&nbsp;Link&nbsp;&nbsp;&nbsp;" /></td>
	<td width="30%" align="right"><a href="../index.php"><input type="button" value="&nbsp;&nbsp;&nbsp;Keluar&nbsp;&nbsp;&nbsp;"/></a>&nbsp;</td>
  </tr>
</table>
</div>
<script language="JavaScript" src="../theme/js/mm_menu.js"></script>
<script language="JavaScript" src="../theme/js/dropdown.js"></script>
<script language="JavaScript1.2">mmLoadMenus();</script>
</div>
<span id="tmpContent" style="display:none"></span>
</div>
</body>
</html>
<script>
jQuery(document).ready(function(){
	jQuery("#btnTambah").click(function(){
		jQuery("#listma").hide(1000);
		jQuery("#input").show(1000);
	});
	
	jQuery("#btnBatal").click(function(){
		jQuery("#input").hide(1000);
		jQuery("#listma").show(1000);
	});
});


function tambah(){
	document.getElementById('btnSimpan').innerHTML="<IMG SRC='../icon/save.gif' border='0' width='16' height='16' ALIGN='absmiddle'>&nbsp;Simpan";
	document.getElementById('txtId').value='';
	document.getElementById('kode').value='';
	document.getElementById('nama').value='';
	tinyMCE.get("isi").setContent('');
	document.form1.act.value='simpan';
}

function batal(){

}

function action2(){
	document.form1.submit();
}

function hapus(id){
	if(id==document.getElementById('txtId').value){
		if(confirm("Yakin ingin menghapus data SOP '"+ document.getElementById('nama').value +"' ?")){
			document.form1.submit();
		}
	}
}

function fedit(id){
	document.getElementById('btnSimpan').innerHTML="<IMG SRC='../icon/save.gif' border='0' width='16' height='16' ALIGN='absmiddle'>&nbsp;Update";
	Request('get_sop.php?id='+id , 'tmpContent', '', 'GET',fSetContent,'NoLoad');
	jQuery("#listma").hide(1000);
	jQuery("#input").show(1000);
}

function fSetContent(){
	tinyMCE.get("isi").setContent(document.getElementById('tmpContent').innerHTML);
}

var win = null;
function NewWindow(mypage,myname,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings ='height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
	win = window.open(mypage,myname,settings)
}
</script>
<?php 
mysql_close($konek);
?>