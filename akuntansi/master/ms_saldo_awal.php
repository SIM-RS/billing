<?php 
include("../koneksi/konek.php");
//echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."<br>";echo $_SERVER['QUERY_STRING'];
$qstr_ma="par=parent*kode_ma2*mainduk*parent_lvl";
$_SESSION["PATH_MS_MA"]="?".$qstr_ma;

$saldo_id=$_REQUEST['saldo_id'];
$idma=$_REQUEST['idma'];
$kode_ma=trim($_REQUEST['kode_ma']);
$ma=str_replace("\'","''",$_REQUEST['ma']);
$ma=str_replace('\"','"',$ma);
$ma=str_replace(chr(92).chr(92),chr(92),$ma);
$saldo=$_REQUEST['saldo'];

//$th=gmdate('d-m-Y',mktime(date('H')+7));
$th=date('d-m-Y');
$th=explode("-",$th);

$bulan=$_REQUEST['bulan'];if ($bulan=="") $bulan=(substr($th[1],0,1)=="0"?substr($th[1],1,1):$th[1]);
$bulan=explode("|",$bulan);
$ta=$_REQUEST['ta'];if ($ta=="") $ta=$th[2];

$page=$_REQUEST["page"];
$defaultsort="MA_KODE";
$sorting=$_REQUEST["sorting"];
$filter=$_REQUEST["filter"];

$act=$_REQUEST['act'];
//echo $act;
switch ($act){
	case "save":
		$sql="select * from saldo where FK_MAID=$idma and BULAN=$bulan[0] and TAHUN=$ta";
		//echo $sql;
		$rs1=mysql_query($sql);
		if (mysql_num_rows($rs1)>0){
			echo "<script>alert('Saldo Awal $bulan[1] $ta Sudah Ada');</script>";
		}else{
			$sql="insert into saldo(FK_MAID,BULAN,TAHUN,SALDO_AWAL) values($idma,$bulan[0],$ta,$saldo)";
			//echo $sql;
			$rs=mysql_query($sql);
		}
		mysql_free_result($rs1);
		break;
	case "edit":
		$sql="update saldo set FK_MAID=$idma,JTRANS_NAMA='$ma',JTRANS_LEVEL=$lvl,JTRANS_PARENT=$parent,JTRANS_PARENT_KODE='$kode_ma2',JTRANS_AKTIF=$aktif where JTRANS_ID=$idma";
		$rs=mysql_query($sql);
		break;
	case "delete":
		$sql="delete from jenis_transaksi where JTRANS_ID=$idma";
		//echo $sql."<br>";
		$rs=mysql_query($sql);'
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
<iframe height="72" width="130" name="sort"
	id="sort"
	src="../theme/sort.php" scrolling="no"
	frameborder="0"
	style="border: medium ridge; position: absolute; z-index: 65535; left: 100px; top: 250px; visibility: hidden">
</iframe>
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
      <p><span class="jdltable">DATA SALDO AWAL MATA ANGGARAN</span> 
      <table width="99%" cellpadding="0" cellspacing="0" border="0">
		<tr>
          <td width="465" class="txtinput">&nbsp;Bulan 
            <select name="bulan" id="bulan" class="txtinput" onChange="location='?f=../master/ms_saldo_awal.php&bulan='+bulan.value+'&ta='+ta.value">
			  <option value="1|Januari"<?php if ($bulan[0]=="1") echo " selected";?>>Januari</option>
			  <option value="2|Pebruari"<?php if ($bulan[0]=="2") echo " selected";?>>Pebruari</option>
			  <option value="3|Maret"<?php if ($bulan[0]=="3") echo " selected";?>>Maret</option>
			  <option value="4|April"<?php if ($bulan[0]=="4") echo " selected";?>>April</option>
			  <option value="5|Mei"<?php if ($bulan[0]=="5") echo " selected";?>>Mei</option>
			  <option value="6|Juni"<?php if ($bulan[0]=="6") echo " selected";?>>Juni</option>
			  <option value="7|Juli"<?php if ($bulan[0]=="7") echo " selected";?>>Juli</option>
			  <option value="8|Agustus"<?php if ($bulan[0]=="8") echo " selected";?>>Agustus</option>
			  <option value="9|September"<?php if ($bulan[0]=="9") echo " selected";?>>September</option>
			  <option value="10|Oktober"<?php if ($bulan[0]=="10") echo " selected";?>>Oktober</option>
			  <option value="11|Nopember"<?php if ($bulan[0]=="11") echo " selected";?>>Nopember</option>
			  <option value="12|Desember"<?php if ($bulan[0]=="12") echo " selected";?>>Desember</option>
            </select> &nbsp;Tahun 
            <select name="ta" id="ta" class="txtinput" onChange="location='?f=../master/ms_saldo_awal.php&bulan='+bulan.value+'&ta='+ta.value">
              <?php for ($i=$ta-2;$i<$ta+2;$i++){?>
              <option value="<?php echo $i; ?>" <?php if ($i==$ta) echo "selected"; ?>><?php echo $i; ?></option>
              <?php }?>
            </select> </td>
          <td width="460" align="right">
           <!--BUTTON type="button" onClick="location='?f=../master/tree_ms_ma.php'"><IMG SRC="../icon/view_tree.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tree View</BUTTON--> <BUTTON type="button" onClick="document.getElementById('input').style.display='block';document.getElementById('listma').style.display='none';"><IMG SRC="../icon/add.gif" border="0" width="16" height="16" ALIGN="absmiddle">&nbsp;Tambah</BUTTON></td>
	    </tr>
	</table>
      <table border="0" cellspacing="0" cellpadding="1">
        <tr class="headtable"> 
          <td width="40" class="tblheaderkiri">No</td>
          <td id="JTRANS_KODE" width="155" class="tblheader" onClick="ifPop.CallFr(this);">Kode 
            MA </td>
          <td id="JTRANS_NAMA" width="645" class="tblheader" onClick="ifPop.CallFr(this);">Nama 
            Mata Anggaran</td>
          <td id="JTRANS_NAMA" width="150" class="tblheader" onClick="ifPop.CallFr(this);">Saldo 
            Awal </td>
          <td class="tblheader" colspan="2">Proses</td>
        </tr>
        <?php 
	  if ($filter!=""){
	  	$filter=explode("|",$filter);
	  	$filter=" and ".$filter[0]." like '%".$filter[1]."%'";
	  }
	  if ($sorting=="") $sorting=$defaultsort;
	  //$sql="SELECT * from jenis_transaksi where JTRANS_aktif=$status".$filter." ORDER BY ".$sorting;;
	  $sql="select MA_ID,MA_KODE,MA_NAMA,SALDO_ID,SALDO_AWAL from ma_sak inner join saldo on MA_ID=FK_MAID where BULAN=$bulan and TAHUN=$ta".$filter." ORDER BY ".$sorting;;
	  //echo $sql."<br>";
		$rs=mysql_query($sql);
		$jmldata=mysql_num_rows($rs);
		if (($page=="")||($page=="0")) $page="1";
		$perpage=50;$tpage=($page-1)*$perpage;
		if (($jmldata%$perpage)>0) $totpage=floor($jmldata/$perpage)+1; else $totpage=floor($jmldata/$perpage);
		if ($page>1) $bpage=$page-1; else $bpage=1;
		if ($page<$totpage) $npage=$page+1; else $npage=$totpage;
		$sql=$sql." limit $tpage,$perpage";

	  $rs=mysql_query($sql);
	  $i=($page-1)*$perpage;
	  $arfvalue="";
	  while ($rows=mysql_fetch_array($rs)){
	  	$i++;
		$arfvalue="act*-*edit*|*idma*-*".$rows['MA_ID']."*|*kode_ma*-*".$rows['MA_KODE']."*|*ma*-*".$rows['MA_NAMA']."*|*saldo_id*-*".$rows['SALDO_ID'];
		 $arfvalue=str_replace('"',chr(3),$arfvalue);
		 $arfvalue=str_replace("'",chr(5),$arfvalue);
		 $arfvalue=str_replace(chr(92),chr(92).chr(92),$arfvalue);
	  	$arfhapus="act*-*delete*|*saldo_id*-*".$rows['SALDO_ID'];
	  ?>
        <tr class="itemtable" onMouseOver="this.className='itemtableMOver'" onMouseOut="this.className='itemtable'"> 
          <td class="tdisikiri"><?php echo $i; ?></td>
          <td class="tdisi" align="left"><?php echo $rows['MA_KODE']; ?></td>
          <td align="left" class="tdisi"><?php echo $rows['MA_NAMA']; ?></td>
          <td align="left" class="tdisi"><?php echo number_format($rows['SALDO_AWAL'],0,",","."); ?></td>
          <td width="30" class="tdisi"><img src="../icon/edit.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Mengubah" onClick="document.getElementById('input').style.display='block';document.getElementById('listma').style.display='none';fSetValue(window,'<?php echo $arfvalue; ?>');"></td>
          <td width="30" class="tdisi"><img src="../icon/del.gif" border="0" width="16" height="16" align="absmiddle" class="proses" title="Klik Untuk Menghapus" onClick="if (confirm('Yakin Ingin Menghapus Data ?')){fSetValue(window,'<?php echo $arfhapus; ?>');document.form1.submit();}"></td>
        </tr>
        <?php 
	  }
	  mysql_free_result($rs);
	  ?>
        <tr> 
          <td colspan="2" align="left"><div align="left" class="textpaging">&nbsp;&nbsp;&nbsp;Halaman 
              <?php echo ($totpage==0?"0":$page); ?> dari <?php echo $totpage; ?></div></td>
          <td colspan="4" align="right"> <img src="../icon/next_01.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Pertama" onClick="act.value='paging';page.value='1';document.form1.submit();"> 
            <img src="../icon/next_02.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Sebelumnya" onClick="act.value='paging';page.value='<?php echo $bpage; ?>';document.form1.submit();"> 
            <img src="../icon/next_03.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Berikutnya" onClick="act.value='paging';page.value='<?php echo $npage; ?>';document.form1.submit();"> 
            <img src="../icon/next_04.gif" border="0" width="30" height="30" style="cursor:pointer" title="Halaman Terakhir" onClick="act.value='paging';page.value='<?php echo $totpage; ?>';document.form1.submit();">&nbsp;&nbsp;	
          </td>
        </tr>
      </table>
    </p>
	</div>
</form>
</div>
</body>
</html>
<?php 
mysql_close($konek);
?>